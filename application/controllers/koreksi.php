<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Koreksi extends GMN_Controller {

	function __construct(){
		parent::__construct(true);
		$this->load->model('model_koreksi');
	}

	function index(){
		$this->koreksi_angsuran();
	}

	function koreksi_angsuran(){
		$data['title'] = 'Koreksi Angsuran';
		$data['container'] = 'koreksi/koreksi_angsuran';
		$this->load->view('core',$data);
	}

	function proses_koreksi_angsuran(){
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

            $i_fin = array(
                'saldo_pokok' => $s_fin['pokok'] - ($s_fin['angsuran_pokok'] * $maksimal),
                'saldo_margin' => $s_fin['margin'] - ($s_fin['angsuran_margin'] * $maksimal),
                'saldo_catab' => $s_fin['angsuran_catab'] * $maksimal,
                'counter_angsuran' => $maksimal
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

        $this->model_koreksi->fn_update_jtempo_angsuran_last_next($branch_code);

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

    function proses_koreksi_angsuran2(){
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

            $i_fin = array(
                'saldo_pokok' => $s_fin['pokok'] - ($s_fin['angsuran_pokok'] * $angsuran_ke),
                'saldo_margin' => $s_fin['margin'] - ($s_fin['angsuran_margin'] * $angsuran_ke),
                'saldo_catab' => $s_fin['angsuran_catab'] * $angsuran_ke,
                'counter_angsuran' => $angsuran_ke
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

        $this->model_koreksi->fn_update_jtempo_angsuran_last_next($branch);

        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            $return = array('sukses' => TRUE);
        } else {
            $this->db->trans_rollback();
            $return = array('sukses' => FALSE);
        }

        echo json_encode($return);
   }

    function koreksi_tabber(){
        $data['title'] = 'Koreksi Tabungan Berencana';
        $data['container'] = 'koreksi/koreksi_tabber';
        $this->load->view('core',$data);
    }

    function proses_koreksi_tabber(){
        $branch_code = $this->input->post('branch_code');
        $cm_code = $this->input->post('cm_code');

        $show = $this->model_koreksi->show_data_koreksi_taber($branch_code,$cm_code);

        $this->db->trans_begin();

        foreach($show as $sh){
            $nama = $sh['nama'];
            $rencana = $sh['rencana_setoran'];
            $account_saving_no = $sh['account_saving_no'];
            $saldo_memo = $sh['saldo_memo'];
            $saldo_histori = $sh['saldo_histori'];
            $cm_name = $sh['cm_name'];

            $counter = $saldo_histori / $rencana;
            $riil = $rencana * $counter;
            $memo = $rencana * $counter;

            $update = array(
                'saldo_riil' => $riil,
                'saldo_memo' => $memo,
                'counter_angsruan' => $counter
            );

            $this->model_koreksi->update_tabber($update,$account_saving_no);
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

    function jqgrid_list_koreksi_tabber(){
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
        $sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'account_saving_no';//1
        $sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
        $tanggal = date('Y-m-d');
        $branch_code = isset($_REQUEST['branch_code'])?$_REQUEST['branch_code']:'';
        $cm_code = isset($_REQUEST['cm_code'])?$_REQUEST['cm_code']:'';
        
        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
        if ($totalrows) {
            $limit_rows = $totalrows;
        }

        $count = $this->model_koreksi->jqgrid_count_koreksi_tabber($branch_code,$cm_code);

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

        $result = $this->model_koreksi->jqgrid_list_koreksi_tabber($sidx,$sort,$limit_rows,$start,$branch_code,$cm_code);

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $i = 0;

        foreach ($result as $row){
            $responce['rows'][$i]['account_saving_no']=$row['account_saving_no'];
            $responce['rows'][$i]['cell']=array(
                 $row['account_saving_no']
                ,$row['nama']
                ,$row['saldo_memo']
                ,$row['saldo_histori']
                ,$row['cm_name']
            );
            $i++;
        }

        echo json_encode($responce);
    }

    function koreksi_sukarela(){
        $data['title'] = 'Koreksi Tabungan Sukarela';
        $data['container'] = 'koreksi/koreksi_sukarela';
        $this->load->view('core',$data);
    }

    function jqgrid_list_koreksi_sukarela(){
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
        $sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'cif_no';//1
        $sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
        $tanggal = date('Y-m-d');
        $branch_code = isset($_REQUEST['branch_code'])?$_REQUEST['branch_code']:'';
        $cm_code = isset($_REQUEST['cm_code'])?$_REQUEST['cm_code']:'';
        
        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
        if ($totalrows) {
            $limit_rows = $totalrows;
        }

        $count = $this->model_koreksi->jqgrid_count_koreksi_sukarela($branch_code,$cm_code);

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

        $result = $this->model_koreksi->jqgrid_list_koreksi_sukarela($sidx,$sort,$limit_rows,$start,$branch_code,$cm_code);

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $i = 0;

        foreach ($result as $row){
            $responce['rows'][$i]['cif_no']=$row['cif_no'];
            $responce['rows'][$i]['cell']=array(
                 $row['cif_no']
                ,$row['nama']
                ,$row['tabungan_sukarela']
                ,$row['tabungan_histori']
                ,$row['cm_name']
            );
            $i++;
        }

        echo json_encode($responce);
    }

    function proses_koreksi_sukarela(){
        $branch_code = $this->input->post('branch_code');
        $cm_code = $this->input->post('cm_code');

        $show = $this->model_koreksi->show_data_koreksi_sukarela($branch_code,$cm_code);

        $this->db->trans_begin();

        foreach($show as $sh){
            $cif_no = $sh['cif_no'];
            $tabungan_sukarela = $sh['tabungan_sukarela'];
            $tabungan_histori = $sh['tabungan_histori'];

            $update = array('tabungan_sukarela' => $tabungan_histori);

            $this->model_koreksi->update_tabsuk($update,$cif_no);
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

    function koreksi_jto_individu(){
        $data['title'] = 'Koreksi Jto Individu';
        $data['container'] = 'koreksi/koreksi_jto_individu';
        $this->load->view('core',$data);
    }

    function proses_koreksi_jto_individu(){
        $branch_code = $this->input->post('branch');

        $this->db->trans_begin();

        $show = $this->model_koreksi->show_data_koreksi_jto_individu($branch_code);

        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            $return = array('sukses' => TRUE);
        } else {
            $this->db->trans_rollback();
            $return = array('sukses' => FALSE);
        }

        echo json_encode($return);
    }

    function koreksi_wajib_kelompok(){
        $data['title'] = 'Koreksi Wajib Kelompok';
        $data['container'] = 'koreksi/koreksi_wajib_kelompok';
        $this->load->view('core',$data);
    }

    function jqgrid_list_koreksi_wajib_kelompok(){
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
        $sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'account_saving_no';//1
        $sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
        $tanggal = date('Y-m-d');
        $branch_code = isset($_REQUEST['branch_code'])?$_REQUEST['branch_code']:'';
        $cm_code = isset($_REQUEST['cm_code'])?$_REQUEST['cm_code']:'';
        
        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
        if ($totalrows) {
            $limit_rows = $totalrows;
        }

        $count = $this->model_koreksi->jqgrid_count_koreksi_wajib_kelompok($branch_code,$cm_code);

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

        $result = $this->model_koreksi->jqgrid_list_koreksi_wajib_kelompok($sidx,$sort,$limit_rows,$start,$branch_code,$cm_code);

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $i = 0;

        foreach ($result as $row){
            $tabungan_histori_wajib = $row['tabungan_wajib_histori_kelompok'] + $row['tabungan_wajib_histori_individu'];
            $tabungan_histori_kelompok = $row['tabungan_kelompok_histori_kelompok'] + $row['tabungan_kelompok_histori_individu'];
            $responce['rows'][$i]['cif_no'] = $row['cif_no'];

            $responce['rows'][$i]['cell'] = array(
                $row['cif_no'],
                $row['nama'],
                number_format($row['tabungan_wajib'],0,',','.'),
                number_format($tabungan_histori_wajib,0,',','.'),
                number_format($row['tabungan_kelompok'],0,',','.'),
                number_format($tabungan_histori_kelompok,0,',','.'),
                $row['cm_name']
            );

            $i++;
        }

        echo json_encode($responce);
    }

    function proses_koreksi_wajib_kelompok(){
        $branch_code = $this->input->post('branch_code');
        $cm_code = $this->input->post('cm_code');

        $show = $this->model_koreksi->show_data_koreksi_wajib_kelompok($branch_code,$cm_code);

        $this->db->trans_begin();

        foreach($show as $sh){
            $cif_no = $sh['cif_no'];
            $nama = $sh['nama'];
            $tabungan_wajib = $sh['tabungan_wajib'];
            $tabungan_wajib_histori = $sh['tabungan_wajib_histori_kelompok'] + $sh['tabungan_wajib_histori_individu'];
            $tabungan_kelompok = $sh['tabungan_kelompok'];
            $tabungan_kelompok_histori = $sh['tabungan_kelompok_histori_kelompok'] + $sh['tabungan_kelompok_histori_individu'];

            $update = array(
                'tabungan_wajib' => $tabungan_wajib_histori,
                'tabungan_kelompok' => $tabungan_kelompok_histori
            );

            $this->model_koreksi->update_tabsuk($update,$cif_no);
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

    function koreksi_transaksi_majelis(){
        $data['title'] = 'Koreksi Transaksi Majelis';
        $data['container'] = 'koreksi/koreksi_transaksi_majelis';
        $this->load->view('core',$data);
    }

    function jqgrid_list_koreksi_tmajelis(){
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
        $sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'trx_date';
        $sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';

        $branch_code = isset($_REQUEST['branch_code'])?$_REQUEST['branch_code']:'';
        $cm_code = isset($_REQUEST['cm_code'])?$_REQUEST['cm_code']:'';
        $from_date = isset($_REQUEST['from_date'])?$_REQUEST['from_date']:'';
        $thru_date = isset($_REQUEST['thru_date'])?$_REQUEST['thru_date']:'';

        $from_date = str_replace('/','-',$from_date);
        $from_date = date('Y-m-d', strtotime($from_date));

        $thru_date = str_replace('/','-',$thru_date);
        $thru_date = date('Y-m-d', strtotime($thru_date));
        
        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;
        if ($totalrows) {
            $limit_rows = $totalrows;
        }

        $count = $this->model_koreksi->jqgrid_count_koreksi_tmajelis('','','','',$branch_code,$cm_code,$from_date,$thru_date);

        if ($count > 0) {
            $total_pages = ceil($count / $limit_rows);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
        $page = $total_pages;
        $start = $limit_rows * $page - $limit_rows;
        if ($start < 0) $start = 0;

        $result = $this->model_koreksi->jqgrid_list_koreksi_tmajelis($sidx,$sort,$limit_rows,$start,$branch_code,$cm_code,$from_date,$thru_date);

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $i = 0;

        foreach ($result as $row){
            if($row['jurnal_transaksi'] > 0){
                $jurnal = 'Terjadi';
            } else {
                $jurnal = 'Tidak Terjadi';
            }

            $responce['rows'][$i]['trx_date']=$row['trx_date'];
            $responce['rows'][$i]['cell']=array(
                 $row['trx_date']
                ,$row['branch_name']
                ,$row['cm_name']
                ,$jurnal
                ,$row['fa_name']
            );
            $i++;
        }

        echo json_encode($responce);
    }

    function proses_koreksi_tmajelis(){
        $branch_code = $this->input->post('branch_code');
        $cm_code = $this->input->post('cm_code');
        $from_date = $this->input->post('from_date');
        $thru_date = $this->input->post('thru_date');

        $from_date = str_replace('/','-',$from_date);
        $from_date = date('Y-m-d', strtotime($from_date));

        $thru_date = str_replace('/','-',$thru_date);
        $thru_date = date('Y-m-d', strtotime($thru_date));

        $show = $this->model_koreksi->show_data_koreksi_tmajelis($branch_code,$cm_code,$from_date,$thru_date);

        $this->db->trans_begin();

        foreach($show as $sh){
            $trx_cm_id = $sh['trx_cm_id'];

            // AMBIL mfi_trx_cm_detail
            $get_trx_cm_detail = $this->model_koreksi->show_trx_cm_detail($trx_cm_id);
            foreach($get_trx_cm_detail as $gtcd){
                $trx_cm_detail_id = $gtcd['trx_cm_detail_id'];

                // CEK PEMBIAYAAN LUNAS
                $cek_financing_lunas = $this->model_koreksi->show_financing_lunas($trx_cm_detail_id);
                $jumlah_lunas = $cek_financing_lunas['jumlah'];
                if($jumlah_lunas > 0){
                    // DELETE PEMBIAYAAN LUNAS
                    $param_financing_lunas = array(
                        'trx_cm_detail_id' => $trx_cm_detail_id
                    );
                    $this->model_koreksi->delete_table('mfi_account_financing_lunas',$param_financing_lunas);
                }

                // CEK ANGSURAN TABUNGAN
                $cek_angsuran_tabungan = $this->model_koreksi->show_savingplan($trx_cm_detail_id);
                $count_angsuran_tabungan = count($cek_angsuran_tabungan);
                if($count_angsuran_tabungan > 0){
                    foreach($cek_angsuran_tabungan as $cat){
                        $trx_cm_detail_savingplan_id = $cat['trx_cm_detail_savingplan_id'];

                        // CEK ANGSURAN TABUNGAN DETAIL
                        $cek_angsuran_tabungan_detail = $this->model_koreksi->show_savingplan_account($trx_cm_detail_savingplan_id);
                        $count_angsuran_tabungan_detail = count($cek_angsuran_tabungan_detail);
                        if($count_angsuran_tabungan_detail > 0){
                            // DELETE ANGSURAN TABUNGAN DETAIL
                            $param_angsuran_tabungan_detail = array(
                                'trx_cm_detail_savingplan_id' => $trx_cm_detail_savingplan_id
                            );
                            $this->model_koreksi->delete_table('mfi_trx_cm_detail_savingplan_account',$param_angsuran_tabungan_detail);
                        }
                    }

                    // DELETE ANGSURAN TABUNGAN
                    $param_angsuran_tabungan = array(
                        'trx_cm_detail_id' => $trx_cm_detail_id
                    );
                    $this->model_koreksi->delete_table('mfi_trx_cm_detail_savingplan',$param_angsuran_tabungan);
                }

                // CEK DROPING PEMBIAYAAN
                $cek_droping_pembiayaan = $this->model_koreksi->show_detail_droping($trx_cm_detail_id);
                $count_droping_pembiayaan = count($cek_droping_pembiayaan);
                if($count_droping_pembiayaan > 0){
                    // DELETE DROPING PEMBIAYAAN
                    $param_droping_pembiayaan = array(
                        'trx_cm_detail_id' => $trx_cm_detail_id
                    );
                    $this->model_koreksi->delete_table('mfi_trx_cm_detail_droping',$param_droping_pembiayaan);
                }

                // CEK LWK
                $cek_lwk = $this->model_koreksi->show_cm_lwk($trx_cm_detail_id);
                $count_lwk = count($cek_lwk);
                if($count_lwk > 0){
                    // DELETE CM LWK
                    $param_cm_lwk = array(
                        'trx_cm_detail_id' => $trx_cm_detail_id
                    );
                    $this->model_koreksi->delete_table('mfi_trx_cm_lwk',$param_cm_lwk);
                }
            }

            // DELETE DETAIL TRANSAKSI MAJELIS
            $param_cm_detail = array(
                'trx_cm_id' => $trx_cm_id
            );
            $this->model_koreksi->delete_table('mfi_trx_cm_detail',$param_cm_detail);
        }

        // DELETE TRANSAKSI MAJELIS
        $param_cm = array(
            'trx_cm_id' => $trx_cm_id
        );
        $this->model_koreksi->delete_table('mfi_trx_cm',$param_cm);

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