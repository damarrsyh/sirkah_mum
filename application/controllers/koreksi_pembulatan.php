<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Koreksi_pembulatan extends GMN_Controller{

	function __construct(){
		parent::__construct(true);
		$this->load->model('model_koreksi');
	}

	function index(){
		$this->koreksi();
	}

	function koreksi(){
		$data['title'] = 'Koreksi Pembulatan Wajib Kelompok';
		$data['container'] = 'koreksi/koreksi_pembulatan';
		$this->load->view('core',$data);
	}

    function jqgrid_list_koreksi_pembulatan(){
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

        $count = $this->model_koreksi->jqgrid_count_koreksi_pembulatan($cm_code);

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

        $result = $this->model_koreksi->jqgrid_list_koreksi_pembulatan($sidx,$sort,$limit_rows,$start,$cm_code);

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $i = 0;

        foreach ($result as $row){
            $responce['rows'][$i]['cif_no']=$row['cif_no'];
            $responce['rows'][$i]['cell']=array(
                 $row['cif_no']
                ,$row['nama']
                ,$row['tabungan_wajib']
                ,$row['tabungan_kelompok']
                ,$row['cm_name']
            );
            $i++;
        }

        echo json_encode($responce);
    }

    function proses_koreksi(){
        $branch_code = $this->input->post('branch_code');
        $cm_code = $this->input->post('cm_code');

        $show = $this->model_koreksi->show_data_koreksi_pembulatan($cm_code);

        $this->db->trans_begin();

        foreach($show as $sh){
            $cif_no = $sh['cif_no'];
            $tabungan_wajib = $sh['tabungan_wajib'];
            $tabungan_kelompok = $sh['tabungan_kelompok'];

            $last_digit_wajib = substr($tabungan_wajib, -2);
            $last_digit_kelompok = substr($tabungan_kelompok, -2);

            if($last_digit_wajib != '00'){
                $last_digit_wajib = abs((int)$last_digit_wajib);
                $tabungan_wajib_kal = $tabungan_wajib - $last_digit_wajib;
            }

            if($last_digit_kelompok != '00'){
                $last_digit_kelompok = abs((int)$last_digit_kelompok);
                $tabungan_kelompok_kal = $tabungan_kelompok - $last_digit_kelompok;
            }

            echo '<p>';
            echo 'CIF No : '.$cif_no.'<br />';
            echo 'Tabungan Wajib Asli : '.$tabungan_wajib.'<br />';
            echo 'Tabungan Kelompok Asli : '.$tabungan_kelompok.'<br />';
            echo '2 Digit Terakhir Wajib : '.$last_digit_wajib.'<br />';
            echo '2 Digit Terakhir Kelompok : '.$last_digit_kelompok.'<br />';
            echo '</p>';

            echo '<p>';
            echo 'CIF No : '.$cif_no.'<br />';
            echo 'Tabungan Wajib Kalkulasi : '.@$tabungan_wajib_kal.'<br />';
            echo 'Tabungan Kelompok Kalkulasi : '.@$tabungan_kelompok_kal.'<br />';
            echo '</p>';
            echo '<hr />';
        }

        exit();

        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            $this->session->set_flashdata('notification','<div class="alert alert-success alert-dismissable"><h4><i class="icon fa fa-check"></i> Sukses!</h4> Data berhasil diperbaiki</div>');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('notification','<div class="alert alert-danger alert-dismissable"><h4><i class="icon fa fa-times"></i> Gagal!</h4> Data gagal diperbaiki</div>');
        }

        redirect(site_url('koreksi_pembulatan'));
    }

}