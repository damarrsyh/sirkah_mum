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

	public function index()
	{
		$branch_code		= $this->session->userdata('branch_code');
		$data['petugas']	= $this->model_dashboard->get_petugas($branch_code);
		$data['anggota']	= $this->model_dashboard->get_anggota($branch_code);
		$data['rembug']		= $this->model_dashboard->get_rembug($branch_code);
		$data['container'] 	= 'dashboard';


		//chart
		$data_chart		= $this->model_dashboard->chart_peruntukan($branch_code);
		$rows = array();
		//flag is not needed
		$flag = true;
		$table = array();
		$table['cols'] = array(			 
		    // Labels for your chart, these represent the column titles
		    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
		    array('label' => 'people', 'type' => 'string'),
		    array('label' => 'total', 'type' => 'number')
		 
		);
		 
		$rows = array();
		for ($i=0; $i <count($data_chart) ; $i++) 
		{ 
		    $temp = array();
		    // the following line will be used to slice the Pie chart
		    $temp[] = array('v' => (string) $data_chart[$i]['display_text'].' ('.number_format($data_chart[$i]['saldo_pokok']).')');
		    // Values of each slice
		    $temp[] = array('v' => (float) $data_chart[$i]['count']);
		    $rows[] = array('c' => $temp);
		}
		 
		$table['rows'] = $rows;
		$data['jsonPie'] = json_encode($table);

		$data_chartColoum		= $this->model_dashboard->chart_anggota($branch_code);
			$rows = array();
			//flag is not needed
			$flag = true;
			$table = array();
			$table['cols'] = array(			 
			    // Labels for your chart, these represent the column titles
			    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
			    array('label' => 'people', 'type' => 'string'),
			    array('label' => 'total', 'type' => 'number')
			 
			);
			 
			$rows = array();
			for ($i=0; $i <count($data_chartColoum) ; $i++) 
			{ 
				if($data_chartColoum[$i]['count']>0)
				{
				    $temp = array();
				    // the following line will be used to slice the Pie chart
				    $temp[] = array('v' => (string) $data_chartColoum[$i]['display_text'].' '.$data_chartColoum[$i]['count'].' Anggota'); 			 
				    // Values of each slice
				    $temp[] = array('v' => (float) $data_chartColoum[$i]['count']);
				    $rows[] = array('c' => $temp);
				}
			}
			 
			$table['rows'] = $rows;
			$data['jsonColoum'] = json_encode($table);
		//end chart

		$this->load->view('core',$data);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */