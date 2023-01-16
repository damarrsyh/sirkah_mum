<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Koreksi_angsuran extends GMN_Controller {

	function __construct(){
		parent::__construct(true);
		$this->load->library('phpexcel','phpexcel/IOFactory');
		$this->load->model('model_koreksi');
	}

	function index(){
		$this->koreksi();
	}

	function koreksi(){
		$data['title'] = 'Koreksi Angsuran';
		$data['container'] = 'koreksi/koreksi_angsuran';
		$this->load->view('core',$data);
	}

	function proses_koreksi(){
        $branch_code = $this->input->post('branch');
        $cm_code = $this->input->post('rembug');

        $show = $this->model_koreksi->show_data_koreksi($branch_code,$cm_code);

        $this->db->trans_begin();

        foreach($show as $sh){
        	$cif_no = $sh['cif_no'];
            $nama = $sh['nama'];
        	$account_financing_no = $sh['account_financing_no'];
        	$angsuran_ke = $sh['angsuran_ke'];
        	$jumlah_angs = $sh['jumlah_angs'];
        	$cm_code = $sh['cm_code'];

            // Get Minimal angsuran_ke
            $show = $this->model_koreksi->get_angsuran_ke($account_financing_no);
            $minimal = $show['min_angs'];

            if($minimal > 1){
                $update = $this->model_koreksi->fn_edit_trxcm_angsuran_ke2($account_financing_no);
            } else {
                $update = $this->model_koreksi->fn_edit_trxcm_angsuran_ke($account_financing_no);
            }

            // Get Maksimal angsuran_ke
            $max = $this->model_koreksi->get_angsuran_max($account_financing_no);
            $maksimal = $max['max_angs'];

            // Show data finance
            $s_fin = $this->model_koreksi->show_financing($account_financing_no);

            $jtempo_angsuran_last = date('Y-m-d',strtotime($s_fin['tanggal_mulai_angsur'] . ' + '.((7 * $maksimal) - 7).' days' ));
            $jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_last . ' + 7 days' ));

            $i_fin = array(
                'saldo_pokok' => $s_fin['pokok'] - ($s_fin['angsuran_pokok'] * $maksimal),
                'saldo_margin' => $s_fin['margin'] - ($s_fin['angsuran_margin'] * $maksimal),
                'saldo_catab' => $s_fin['angsuran_catab'] * $maksimal,
                'counter_angsuran' => $maksimal,
                'jtempo_angsuran_last' => $jtempo_angsuran_last,
                'jtempo_angsuran_next' => $jtempo_angsuran_next
            );

            // Update mfi_account_financing
            $ubah = $this->model_koreksi->update_account_financing($i_fin,$account_financing_no);

            // Show jangka_waktu
            $show_finance = $this->model_koreksi->show_financing($account_financing_no);
            $jangka_waktu = $show_finance['jangka_waktu'];
            $counter_angsuran = $show_finance['counter_angsuran'];

            if($jangka_waktu == $counter_angsuran){
                // Update status rekening
                $item = array('status_rekening' => 2);
                $status = $this->model_koreksi->update_account_financing($item,$account_financing_no);
            }

            // jumlahkan tabungan kelompok dan tabungan wajib
            $tab_wajib_kelompok = $this->model_koreksi->sum_wajib_kelompok($cif_no);
            $tabungan_wajib = $tab_wajib_kelompok['tabungan_wajib'];
            $tabungan_kelompok = $tab_wajib_kelompok['tabungan_kelompok'];

            // update saldo default balance
            $data_wajib_kelompok = array(
                'tabungan_wajib' => $tabungan_wajib,
                'tabungan_kelompok' => $tabungan_kelompok
            );

            //$ubah_wajib_kelompok = $this->model_koreksi->update_tabsuk($data_wajib_kelompok,$cif_no);
        }

        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            $return = array('sukses' => TRUE);
        } else {
            $this->db->trans_rollback();
            $return = array('sukses' => FALSE);
        }

        echo json_encode($return);
	}

    function jqgrid_list_koreksi_angsuran(){
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
        $sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'account_financing_no';//1
        $sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
        $tanggal = date('Y-m-d');
        $branch_code = isset($_REQUEST['branch_code'])?$_REQUEST['branch_code']:'';
        $cm_code = isset($_REQUEST['cm_code'])?$_REQUEST['cm_code']:'';
        
        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
        if ($totalrows) {
            $limit_rows = $totalrows;
        }

        $count = $this->model_koreksi->jqgrid_count_koreksi_angsuran($branch_code,$cm_code);

        // $count = count($result);
        if ($count > 0) {
            $total_pages = ceil($count / $limit_rows);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
        $page = $total_pages;
        $start = $limit_rows * $page - $limit_rows;
        if ($start < 0) $start = 0;

        $result = $this->model_koreksi->jqgrid_list_koreksi_angsuran($sidx,$sort,$limit_rows,$start,$branch_code,$cm_code);

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $i = 0;

        foreach ($result as $row){
            $responce['rows'][$i]['account_financing_no']=$row['account_financing_no'];
            $responce['rows'][$i]['cell']=array(
                 $row['account_financing_no']
                ,$row['nama']
                ,$row['angsuran_ke']
                ,$row['jumlah_angs']
                ,$row['cm_name']
            );
            $i++;
        }

        echo json_encode($responce);
    }

    function jqgrid_list_koreksi_angsuran2(){
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
        $sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'account_financing_no';//1
        $sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
        $tanggal = date('Y-m-d');
        $branch_code = isset($_REQUEST['branch_code'])?$_REQUEST['branch_code']:'';
        $cm_code = isset($_REQUEST['cm_code'])?$_REQUEST['cm_code']:'';
        
        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
        if ($totalrows) {
            $limit_rows = $totalrows;
        }

        $count = $this->model_koreksi->jqgrid_count_koreksi_angsuran($branch_code,$cm_code);

        // $count = count($result);
        if ($count > 0) {
            $total_pages = ceil($count / $limit_rows);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
        $page = $total_pages;
        $start = $limit_rows * $page - $limit_rows;
        if ($start < 0) $start = 0;

        $result = $this->model_koreksi->jqgrid_list_koreksi_angsuran2($sidx,$sort,$limit_rows,$start,$branch_code,$cm_code);

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $i = 0;

        foreach ($result as $row){
            $responce['rows'][$i]['account_financing_no']=$row['account_financing_no'];
            $responce['rows'][$i]['cell']=array(
                 $row['account_financing_no']
                ,$row['nama']
                ,$row['counter_angsuran']
                ,$row['angsuran_ke']
                ,$row['cm_name']
            );
            $i++;
        }

        echo json_encode($responce);
    }

    function proses_koreksi2(){
        $branch = $this->input->post('branch');
        $rembug = $this->input->post('rembug');
        
        $show = $this->model_koreksi->show_data_koreksi2($branch,$rembug);

        $this->db->trans_begin();

        foreach($show as $sh){
            $cif_no = $sh['cif_no'];
            $account_financing_no = $sh['account_financing_no'];
            $counter_angsuran = $sh['counter_angsuran'];
            $angsuran_ke = $sh['angsuran_ke'];

            // Show data finance
            $s_fin = $this->model_koreksi->show_financing($account_financing_no);

            $jtempo_angsuran_last = date('Y-m-d',strtotime($s_fin['tanggal_mulai_angsur'] . ' + '.((7 * $angsuran_ke) - 7).' days' ));
            $jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_last . ' + 7 days' ));

            $i_fin = array(
                'saldo_pokok' => $s_fin['pokok'] - ($s_fin['angsuran_pokok'] * $angsuran_ke),
                'saldo_margin' => $s_fin['margin'] - ($s_fin['angsuran_margin'] * $angsuran_ke),
                'saldo_catab' => $s_fin['angsuran_catab'] * $angsuran_ke,
                'counter_angsuran' => $angsuran_ke,
                'jtempo_angsuran_last' => $jtempo_angsuran_last,
                'jtempo_angsuran_next' => $jtempo_angsuran_next
            );

            // Update mfi_account_financing
            $ubah = $this->model_koreksi->update_account_financing($i_fin,$account_financing_no);

            // Show jangka_waktu
            $show_finance = $this->model_koreksi->show_financing($account_financing_no);
            $jangka_waktu = $show_finance['jangka_waktu'];
            $counter_angsuran = $show_finance['counter_angsuran'];

            if($jangka_waktu == $counter_angsuran){
                // Update status rekening
                $item = array('status_rekening' => 2);
                $status = $this->model_koreksi->update_account_financing($item,$account_financing_no);
            }

            // jumlahkan tabungan kelompok dan tabungan wajib
            $tab_wajib_kelompok = $this->model_koreksi->sum_wajib_kelompok($cif_no);
            $tabungan_wajib = $tab_wajib_kelompok['tabungan_wajib'];
            $tabungan_kelompok = $tab_wajib_kelompok['tabungan_kelompok'];

            // update saldo default balance
            $data_wajib_kelompok = array(
                'tabungan_wajib' => $tabungan_wajib,
                'tabungan_kelompok' => $tabungan_kelompok
            );

            //$ubah_wajib_kelompok = $this->model_koreksi->update_tabsuk($data_wajib_kelompok,$cif_no);
        }

        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            $return = array('sukses' => TRUE);
        } else {
            $this->db->trans_rollback();
            $return = array('sukses' => FALSE);
        }

        echo json_encode($return);
   }

}