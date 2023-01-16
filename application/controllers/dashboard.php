<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model("model_dashboard");
	}

	public function test()
	{
		var_dump($this->model_dashboard->get_max_par_tanggal_hitung());
		exit;
	}

	public function index()
	{
		$branch_code            = $this->session->userdata('branch_code');
		$tgl_obj                = new DateTime();
		$data['petugas']        = $this->model_dashboard->get_petugas($branch_code);
		$data['anggota']        = $this->model_dashboard->get_anggota($branch_code);
		$data['rembug']         = $this->model_dashboard->get_rembug($branch_code);
		$data['container']      = 'dashboard';
		$max_par_tanggal_hitung = $this->model_dashboard->get_max_par_tanggal_hitung();
		$data['tanggal_par']    =  NULL;

		if($max_par_tanggal_hitung != NULL){
			$data['tanggal_par']    = $tgl_obj->createFromFormat('Y-m-d', $max_par_tanggal_hitung)->format('d-M-Y');
		}

		$data['par_10up'] 		= $this->model_dashboard->get_par_10up();
		$data['par_all'] 		= $this->model_dashboard->get_par_all(); 

		$data['outstanding'] 		= $this->model_dashboard->get_outstanding(); 
		$data['outstanding_taber'] 	= $this->model_dashboard->get_outstanding_taber();

		$periode_awal   		= $this->model_dashboard->get_periode_awal();
	    $periode_akhir  		= $this->model_dashboard->get_periode_akhir();
	    $data['disbursement'] 	= $this->model_dashboard->get_disbursement( $periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code ); 

	    $periode_awal   		= $this->model_dashboard->get_periode_awal();
	    $periode_akhir  		= $this->model_dashboard->get_periode_akhir();
	    $data['payment'] 		= $this->model_dashboard->get_payment( $periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code ); 



		
		//chart
		$data_chart    = $this->model_dashboard->chart_peruntukan($branch_code);
		$rows          = array();
		$flag          = true;
		$table         = array();
		$table['cols'] = array(
			array('label' => 'people', 'type' => 'string'),
			array('label' => 'total', 'type' => 'number')
		);

		$rows = array();
		for ($i=0; $i <count($data_chart) ; $i++) 
		{ 
			$temp = array();
			$temp[] = array('v' => (string) $data_chart[$i]['display_text'].' ('.number_format($data_chart[$i]['saldo_pokok']).')');
			$temp[] = array('v' => (float) $data_chart[$i]['count']);
			$rows[] = array('c' => $temp);
		}

		$table['rows'] = $rows;
		$data['jsonPie'] = json_encode($table);

		$data_chartColoum		= $this->model_dashboard->chart_anggota($branch_code);
		$rows = array();
		$flag = true;
		$table = array();
		$table['cols'] = array(
			array('label' => 'people', 'type' => 'string'),
			array('label' => 'total', 'type' => 'number')
		);

		$rows = array();
		for ($i=0; $i <count($data_chartColoum) ; $i++) 
		{ 
			if($data_chartColoum[$i]['count']>0)
			{
				$temp = array();
				$temp[] = array('v' => (string) $data_chartColoum[$i]['display_text'].' '.$data_chartColoum[$i]['count'].' Anggota');
				$temp[] = array('v' => (float) $data_chartColoum[$i]['count']);
				$rows[] = array('c' => $temp);
			}
		}

		$table['rows']      = $rows;
		$data['jsonColoum'] = json_encode($table);
		//end chart

		$this->load->view('core',$data);
	}

	/**
	 * APM 20-Jan-02
	 */
	public function get_par()
	{
		$arr = $this->model_dashboard->get_par();
		echo json_encode($arr);
		exit;
	}

	public function get_tab()
	{
		$arr = $this->model_dashboard->get_tab();
		echo json_encode($arr);
		exit;
	}
	
	public function get_drop()
	{
		$branch_code    = $this->session->userdata('branch_code');
		$periode_awal   = $this->model_dashboard->get_periode_awal();
		$periode_akhir  = $this->model_dashboard->get_periode_akhir();
		///$arr 			= $this->model_dashboard->get_drop( $periode_awal, $periode_akhir, $branch_code);
		$arr 			= $this->model_dashboard->get_drop( $periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code );
		echo json_encode($arr);
		exit;
	}

	public function get_angs()
	{
		$branch_code    = $this->session->userdata('branch_code');
		$periode_awal   = $this->model_dashboard->get_periode_awal();
		$periode_akhir  = $this->model_dashboard->get_periode_akhir();
		$arr 			= $this->model_dashboard->get_angs( $periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code );
		echo json_encode($arr);
		exit;
	}


}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */