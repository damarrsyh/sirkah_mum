<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Koreksi_sukarela extends GMN_Controller {

	function __construct(){
		parent::__construct(true);
		$this->load->model('model_koreksi');
	}

	function index(){
		$this->koreksi();
	}

	function koreksi(){
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

    function proses_koreksi(){
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

}