<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends GMN_Controller
{

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

	function chart_branch()
	{
		$branch_code = $this->session->userdata('branch_code');

		$chart = $this->model_dashboard->chart_anggota($branch_code);

		$data = array();

		foreach ($chart as $ch) {
			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => $ch['count'],
				'persen' => 0
			);
		}

		echo json_encode($data);
	}

	function chart_fa()
	{
		$branch_code = $this->session->userdata('branch_code');

		$chart = $this->model_dashboard->chart_petugas($branch_code);

		$data = array();

		foreach ($chart as $ch) {
			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => $ch['count'],
				'persen' => 0
			);
		}

		echo json_encode($data);
	}

	function chart_rembug()
	{
		$branch_code = $this->session->userdata('branch_code');

		$chart = $this->model_dashboard->chart_rembug($branch_code);

		$data = array();

		foreach ($chart as $ch) {
			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => $ch['count'],
				'persen' => 0
			);
		}

		echo json_encode($data);
	}

	function chart_simwa()
	{
		$branch_code = $this->session->userdata('branch_code');

		$chart = $this->model_dashboard->chart_simwa($branch_code);

		$data = array();

		foreach ($chart as $ch) {
			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => $ch['total_simwa'],
				'persen' => 0
			);
		}

		echo json_encode($data);
	}

	function chart_simpok()
	{
		$branch_code = $this->session->userdata('branch_code');

		$chart = $this->model_dashboard->chart_simpok($branch_code);

		$data = array();

		foreach ($chart as $ch) {
			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => $ch['total_simpok'],
				'persen' => 0
			);
		}

		echo json_encode($data);
	}

	function chart_sukarela()
	{
		$branch_code = $this->session->userdata('branch_code');

		$chart = $this->model_dashboard->chart_sukarela($branch_code);

		$data = array();

		foreach ($chart as $ch) {
			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => $ch['total_sukarela'],
				'persen' => 0
			);
		}

		echo json_encode($data);
	}

	function chart_dtk()
	{
		$branch_code = $this->session->userdata('branch_code');

		$chart = $this->model_dashboard->chart_dtk($branch_code);

		$data = array();

		foreach ($chart as $ch) {
			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => $ch['total_taber'],
				'persen' => 0
			);
		}

		echo json_encode($data);
	}

	function chart_taber()
	{
		$branch_code = $this->session->userdata('branch_code');

		$chart = $this->model_dashboard->chart_taber($branch_code);

		$data = array();

		foreach ($chart as $ch) {
			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => $ch['total_taber'],
				'persen' => 0
			);
		}

		echo json_encode($data);
	}

	function chart_disbursement()
	{
		$branch_code = $this->session->userdata('branch_code');

		$periode_awal = $this->model_dashboard->get_periode_awal();
		$periode_akhir = $this->model_dashboard->get_periode_akhir();

		$chart = $this->model_dashboard->chart_disbursement($branch_code, $periode_awal['periode_awal'], $periode_akhir['periode_akhir']);

		$data = array();

		foreach ($chart as $ch) {
			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => $ch['total_disbursement'],
				'persen' => 0
			);
		}

		echo json_encode($data);
	}

	function chart_outstanding()
	{
		$branch_code = $this->session->userdata('branch_code');

		$chart = $this->model_dashboard->chart_outstanding($branch_code);

		$data = array();

		foreach ($chart as $ch) {
			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => $ch['total_outstanding'],
				'persen' => 0
			);
		}

		echo json_encode($data);
	}

	function chart_par()
	{
		$branch_code = $this->session->userdata('branch_code');

		$chart = $this->model_dashboard->chart_par($branch_code);

		$data = array();

		foreach ($chart as $ch) {
			$par = $this->model_dashboard->get_par_all_v2($ch['branch_code']);

			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => $ch['total_par'],
				'persen' => number_format(($ch['total_par'] / $par['saldo_pokok']) * 100, 2, ',', '.')
			);
		}

		echo json_encode($data);
	}

	function chart_shu()
	{
		$branch_code = $this->session->userdata('branch_code');

		$periode_awal = $this->model_dashboard->get_periode_awal();

		$closing_thru_date = date('Y-m-d', strtotime($periode_awal['periode_awal'] . ' - 1 DAY'));

		$chart = $this->model_dashboard->chart_shu($branch_code, $closing_thru_date);

		$data = array();

		foreach ($chart as $ch) {
			$data[] = array(
				'product_code' => NULL,
				'product_name' => $ch['display_text'],
				'nominal' => ($ch['pendapatan'] * -1) - $ch['biaya'],
				'persen' => 0
			);
		}

		echo json_encode($data);
	}

	function index()
	{
		$branch_code = $this->session->userdata('branch_code');
		$role_id = $this->session->userdata('role_id');

		$periode_awal = $this->model_dashboard->get_periode_awal();
		$periode_akhir = $this->model_dashboard->get_periode_akhir();

		$tgl_obj = new DateTime();

		$closing_thru_date = date('Y-m-d', strtotime($periode_awal['periode_awal'] . ' - 1 DAY'));

		$pendapatan = $this->model_dashboard->get_shu($branch_code, $closing_thru_date, 4);
		$biaya = $this->model_dashboard->get_shu($branch_code, $closing_thru_date, 5);

		$data['cabang'] = $this->model_dashboard->get_cabang();
		$data['branch'] = $this->model_dashboard->get_cabang_num($branch_code);
		$data['petugas'] = $this->model_dashboard->get_petugas($branch_code);
		$data['anggota'] = $this->model_dashboard->get_anggota($branch_code);
		$data['rembug'] = $this->model_dashboard->get_rembug($branch_code);
		$data['simwapoksuk'] = $this->model_dashboard->get_simwa_simpok_sukarela($branch_code);
		$data['dtk'] = $this->model_dashboard->get_dtk($branch_code);
		$data['taber'] = $this->model_dashboard->get_taber($branch_code);
		$data['shu'] = ($pendapatan['amount'] * -1) - $biaya['amount'];

		if ($role_id == 41) { // PENGAWAS or PENGURUS
			$data['container'] = 'dashboard_pengurus';
		} else { // NON PENGAWAS or PENGURUS
			$data['container'] = 'dashboard';
		}

		$max_par_tanggal_hitung = $this->model_dashboard->get_max_par_tanggal_hitung();

		$data['tanggal_par'] =  NULL;

		if ($max_par_tanggal_hitung != NULL) {
			$data['tanggal_par'] = $tgl_obj->createFromFormat('Y-m-d', $max_par_tanggal_hitung)->format('d-M-Y');
		}

		$data['par_10up'] = $this->model_dashboard->get_par_10up();
		$data['par_all'] = $this->model_dashboard->get_par_all();
		$data['outstanding'] = $this->model_dashboard->get_outstanding();
		$data['outstanding_taber'] = $this->model_dashboard->get_outstanding_taber();

		$data['disbursement'] = $this->model_dashboard->get_disbursement($periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code);

		$periode_awal = $this->model_dashboard->get_periode_awal();
		$periode_akhir = $this->model_dashboard->get_periode_akhir();

		$data['payment'] = $this->model_dashboard->get_payment($periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code);

		// CHART PERUNTUKAN
		$data_chart = $this->model_dashboard->chart_peruntukan($branch_code);
		$rows = array();
		$table = array();

		$table['cols'] = array(
			array('label' => 'people', 'type' => 'string'),
			array('label' => 'total', 'type' => 'number')
		);

		$rows = array();

		for ($i = 0; $i < count($data_chart); $i++) {
			$temp = array();
			$temp[] = array('v' => (string) $data_chart[$i]['display_text'] . ' (' . number_format($data_chart[$i]['saldo_pokok']) . ')');
			$temp[] = array('v' => (float) $data_chart[$i]['count']);
			$rows[] = array('c' => $temp);
		}

		$table['rows'] = $rows;
		$data['jsonPie'] = json_encode($table);

		$this->load->view('core', $data);
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
		$arr 			= $this->model_dashboard->get_drop($periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code);
		echo json_encode($arr);
		exit;
	}

	public function get_drop_vs()
	{
		$branch_code    = $this->session->userdata('branch_code'); 
		$periode_awal   = $this->model_dashboard->get_periode_awal(); 
		$periode_akhir  = $this->model_dashboard->get_periode_akhir(); 
		$tahun 			= date('Y',strtotime($periode_awal['periode_awal'])); 
		$bulan 			= date('n',strtotime($periode_awal['periode_awal'])); 
		$arr 			= $this->model_dashboard->get_drop_vs($periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code, $tahun, $bulan ); 
		echo json_encode($arr); 
		exit; 
	}

	public function get_outs_vs()
	{
		$branch_code    = $this->session->userdata('branch_code'); 
		$periode_awal   = $this->model_dashboard->get_periode_awal(); 
		$periode_akhir  = $this->model_dashboard->get_periode_akhir(); 
		$tahun 			= date('Y',strtotime($periode_awal['periode_awal'])); 
		$bulan 			= date('n',strtotime($periode_awal['periode_awal'])); 
		$arr 			= $this->model_dashboard->get_outs_vs($periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code, $tahun, $bulan ); 
		echo json_encode($arr); 
		exit; 
	}

	public function get_par_vs()
	{
		$branch_code    = $this->session->userdata('branch_code'); 
		$periode_awal   = $this->model_dashboard->get_periode_awal(); 		 
		///$periode_akhir  = $this->model_dashboard->get_periode_akhir(); 
		$periode_akhir  = $this->model_dashboard->get_max_par_tanggal_hitung();
		$tahun 			= date('Y',strtotime($periode_awal['periode_awal'])); 
		$bulan 			= date('n',strtotime($periode_awal['periode_awal'])); 
		$arr 			= $this->model_dashboard->get_par_vs($periode_awal['periode_awal'], $periode_akhir, $branch_code, $tahun, $bulan ); 
		echo json_encode($arr); 
		exit; 
	}

	public function get_rekagt_vs()
	{
		$branch_code    = $this->session->userdata('branch_code'); 
		$periode_awal   = $this->model_dashboard->get_periode_awal(); 
		$periode_akhir  = $this->model_dashboard->get_periode_akhir(); 
		$tahun 			= date('Y',strtotime($periode_awal['periode_awal'])); 
		$bulan 			= date('n',strtotime($periode_awal['periode_awal'])); 
		$arr 			= $this->model_dashboard->get_rekagt_vs($periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code, $tahun, $bulan ); 
		echo json_encode($arr); 
		exit; 
	}

	public function get_outagt_vs()
	{
		$branch_code    = $this->session->userdata('branch_code'); 
		$periode_awal   = $this->model_dashboard->get_periode_awal(); 
		$periode_akhir  = $this->model_dashboard->get_periode_akhir(); 
		$tahun 			= date('Y',strtotime($periode_awal['periode_awal'])); 
		$bulan 			= date('n',strtotime($periode_awal['periode_awal'])); 
		$arr 			= $this->model_dashboard->get_outagt_vs($periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code, $tahun, $bulan ); 
		echo json_encode($arr); 
		exit; 
	}

	public function get_jmlagt_vs()
	{
		$branch_code    = $this->session->userdata('branch_code'); 
		$periode_awal   = $this->model_dashboard->get_periode_awal(); 
		$periode_akhir  = $this->model_dashboard->get_periode_akhir(); 
		$tahun 			= date('Y',strtotime($periode_awal['periode_awal'])); 
		$bulan 			= date('n',strtotime($periode_awal['periode_awal'])); 
		$arr 			= $this->model_dashboard->get_jmlagt_vs($periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code, $tahun, $bulan ); 
		echo json_encode($arr); 
		exit; 
	}

	public function get_angs()
	{
		$branch_code    = $this->session->userdata('branch_code');
		$periode_awal   = $this->model_dashboard->get_periode_awal();
		$periode_akhir  = $this->model_dashboard->get_periode_akhir();
		$arr 			= $this->model_dashboard->get_angs($periode_awal['periode_awal'], $periode_akhir['periode_akhir'], $branch_code);
		echo json_encode($arr);
		exit;
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */