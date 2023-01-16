<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Webservices extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('model_webservice');
	}

	function regis_anggota()
	{		
		$cif_no = $this->input->post('cif_no');
		$ibu_kandung = $this->input->post('ibu_kandung');
		$tgl_lahir = $this->input->post('tgl_lahir');

		$regis_anggota = $this->model_webservice->regis_anggota($cif_no, $ibu_kandung, $tgl_lahir);
		$regis_anggota_ = $this->model_webservice->regis_anggota_($cif_no, $ibu_kandung, $tgl_lahir);

		$result = array('regis_anggota' => $regis_anggota, 'regis_anggota_' => $regis_anggota_);
		echo json_encode($result);
	}

	function regis_investor()
	{		
		$cif_no = $this->input->post('cif_no');
		$ibu_kandung = $this->input->post('ibu_kandung');
		$tgl_lahir = $this->input->post('tgl_lahir');

		$regis_investor = $this->model_webservice->regis_investor($cif_no, $ibu_kandung, $tgl_lahir);
		$regis_investor_ = $this->model_webservice->regis_investor_($cif_no, $ibu_kandung, $tgl_lahir);
		$result = array('regis_investor' => $regis_investor, 'regis_investor_' => $regis_investor_);
		echo json_encode($result);
	}

	function get_saldo_anggota(){
		$cif_no = $this->input->post('cif_no');
		$get = $this->model_webservice->get_saldo_anggota($cif_no);
		$get_saldo_berencana_anggota = $this->model_webservice->get_saldo_berencana_anggota($cif_no);
		$get_saldo_pembiayaan_anggota = $this->model_webservice->get_saldo_pembiayaan_anggota($cif_no);
		$get_data_anggota = $this->model_webservice->get_data_anggota($cif_no);
		$result = array('data' => $get,
						'get_saldo_berencana_anggota' => $get_saldo_berencana_anggota,
						'get_saldo_pembiayaan_anggota' => $get_saldo_pembiayaan_anggota,
						'get_data_anggota' => $get_data_anggota);

		echo json_encode($result);
	}

	function get_detail()
	{
		$from_date = $this->input->post('from_date');
		$cif_no = $this->input->post('cif_no');

		$get_count_par_all = $this->model_webservice->get_count_par_all($from_date);
		$get_count_par_lancar = $this->model_webservice->get_count_par_lancar($from_date);
		$get_count_anggota = $this->model_webservice->get_count_anggota();
		$get_sum_saldo = $this->model_webservice->get_sum_saldo();
		$get_count_majelis = $this->model_webservice->get_count_majelis();
		$get_count_cabang = $this->model_webservice->get_count_cabang();
		$get_sum_aset = $this->model_webservice->get_sum_aset($from_date);
		$get_sum_shu = $this->model_webservice->get_sum_shu($from_date);
		$get_sum_modal = $this->model_webservice->get_sum_modal($from_date);
		$get_outstanding = $this->model_webservice->get_outstanding();
		$get_droping = $this->model_webservice->get_droping();
		$get_pembiayaan = $this->model_webservice->get_pembiayaan();
		$get_data_anggota = $this->model_webservice->get_data_anggota($cif_no);
		$result = array('get_count_par_all' => $get_count_par_all,
						'get_count_par_lancar' => $get_count_par_lancar,
						'get_count_anggota' => $get_count_anggota,
						'get_sum_saldo' => $get_sum_saldo,
						'get_count_majelis' => $get_count_majelis,
						'get_count_cabang' => $get_count_cabang,
						'get_sum_aset' => $get_sum_aset,
						'get_sum_shu' => $get_sum_shu,
						'get_sum_modal' => $get_sum_modal,
						'get_outstanding' => $get_outstanding,
						'get_droping' => $get_droping,
						'get_pembiayaan' => $get_pembiayaan,
						'get_data_anggota' => $get_data_anggota);

		echo json_encode($result);
	}

	function get_data_anggota()
	{
		$cif_no = $this->input->post('cif_no');
		$get_data_anggota = $this->model_webservice->get_data_anggota($cif_no);
		$result = array('get_data_anggota' => $get_data_anggota);

		echo json_encode($result);
	}

	function get_saldo_sukarela(){
		$cif_no = $this->input->post('cif_no');
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		$saldo = $this->model_webservice->get_saldo_awal_sukarela($cif_no, $from_date);
		$get = $this->model_webservice->get_statement_sukarela($cif_no, $from_date, $thru_date);
		$get_data_anggota = $this->model_webservice->get_data_anggota($cif_no);
		$result = array(
			'saldo_awal' => $saldo,
			'data' => $get,
			'get_data_anggota' => $get_data_anggota
		);

		echo json_encode($result);
	}

	function get_saldo_kelompok()
	{
		$cif_no = $this->input->post('cif_no');
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		$get_saldo_awal_kelompok = $this->model_webservice->get_saldo_awal_kelompok($cif_no, $from_date);
		$get_statement_tab_kelompok = $this->model_webservice->get_statement_tab_kelompok($cif_no, $from_date, $thru_date);
		$get_data_anggota = $this->model_webservice->get_data_anggota($cif_no);
		$result = array('get_saldo_awal_kelompok' => $get_saldo_awal_kelompok,
						'get_statement_tab_kelompok' => $get_statement_tab_kelompok,
						'get_data_anggota' => $get_data_anggota);

		echo json_encode($result);
	}

	function get_saldo_wajib()
	{
		$cif_no = $this->input->post('cif_no');
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		$get_saldo_awal_wajib = $this->model_webservice->get_saldo_awal_wajib($cif_no, $from_date);
		$get_statement_tab_wajib = $this->model_webservice->get_statement_tab_wajib($cif_no, $from_date, $thru_date);
		$get_data_anggota = $this->model_webservice->get_data_anggota($cif_no);
		$result = array('get_saldo_awal_wajib' => $get_saldo_awal_wajib,
						'get_statement_tab_wajib' => $get_statement_tab_wajib,
						'get_data_anggota' => $get_data_anggota);

		echo json_encode($result);
	}

	function get_saldo_berencana()
	{
		$cif_no = $this->input->post('cif_no');
		$get_saldo_awal_berencana = $this->model_webservice->get_saldo_awal_berencana($cif_no);
		$get_statement_tab_berencana = $this->model_webservice->get_statement_tab_berencana($cif_no);
		$get_data_anggota = $this->model_webservice->get_data_anggota($cif_no);
		$result = array('get_saldo_awal_berencana' => $get_saldo_awal_berencana,
						'get_statement_tab_berencana' => $get_statement_tab_berencana,
						'get_data_anggota' => $get_data_anggota);

		echo json_encode($result);
	}

	function action_regis_deposit()
	{

			$data = array('branch_code' => '99999',
							'tgl_gabung' => date('Y-m-d'),
							'nama' => $this->input->post('nama'),
							'panggilan' => $this->input->post('panggilan'),
							'jenis_kelamin' => $this->input->post('jenis_kelamin'),
							'ibu_kandung' => $this->input->post('ibu_kandung'),
							'tmp_lahir' => $this->input->post('tmp_lahir'),
							'tgl_lahir' => $this->input->post('tgl_lahir'),
							'alamat' => $this->input->post('alamat'),
							'rt_rw' => '/',
							'cif_type' => '1',
							'desa' => $this->input->post('desa'),
							'kecamatan' => $this->input->post('kecamatan'),
							'kabupaten' => $this->input->post('kabupaten'),
							'kodepos' => $this->input->post('kodepos'),
							'no_ktp' => $this->input->post('no_ktp'),
							'telpon_rumah' => $this->input->post('telpon_rumah'),
							'no_npwp' => $this->input->post('no_npwp'),
							'pendidikan' => $this->input->post('pendidikan'),
							'status_perkawinan' => $this->input->post('status_perkawinan'),
							'pekerjaan' => $this->input->post('pekerjaan'),
							'pendapatan_perbulan' => $this->input->post('pendapatan_perbulan'),
							'created_by' => 'SYS');

		$action_regis_deposit = $this->model_webservice->action_regis_deposit($data);
	}

	function get_data_investor()
	{
		$cif_no = $this->input->post('cif_no');
		$get_data_investor = $this->model_webservice->get_data_anggota($cif_no);
		$result = array('get_data_investor' => $get_data_investor);

		echo json_encode($result);
	}

	function get_saldo_investor() 
	{
		$cif_no = $this->input->post('cif_no');
		$get_deposito_investor = $this->model_webservice->get_deposito_investor($cif_no);
		$get_tabungan_investor = $this->model_webservice->get_tabungan_investor($cif_no);
		$result = array('get_deposito_investor' => $get_deposito_investor,
						'get_tabungan_investor' => $get_tabungan_investor);

		echo json_encode($result);
	}

	function action_regis_pembiayaan()
	{

			$data = array('partner_type' => '1',
							'flag_lembaga' => $this->input->post('flag_lembaga'),
							'no_identitas' => $this->input->post('no_identitas'),
							'nama' => $this->input->post('nama'),
							'jenis_kelamin' => $this->input->post('jenis_kelamin'),
							'alamat' => $this->input->post('alamat'),
							'rt_rw' => $this->input->post('rt_rw'),
							'desa' => $this->input->post('desa'),
							'kecamatan' => $this->input->post('kecamatan'),
							'kabupaten' => $this->input->post('kabupaten'),
							'kodepos' => $this->input->post('kodepos'),
							'email' => $this->input->post('email'),
							'notelp' => $this->input->post('notelp'),
							'cp_name' => $this->input->post('cp_name'),
							'cp_notelp' => $this->input->post('cp_notelp'),
							'created_by' => 'sys',
							'created_timestamp' => date("Y-m-d h:i:s"));

		$action_regis_pembiayaan = $this->model_webservice->action_regis_pembiayaan($data);
	}

	function get_detail_pembiayaan()
	{
		$display_text = $this->input->post('display_text');

		$get_detail_pembiayaan = $this->model_webservice->get_detail_pembiayaan($display_text);
		$result = array('get_detail_pembiayaan' => $get_detail_pembiayaan);

		echo json_encode($result);

	}
}