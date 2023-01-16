<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kantor_layanan extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_kantor_layanan');/*
		$this->load->model('model_laporan_to_pdf');
		$this->load->library('html2pdf');
		$this->load->library('phpexcel');*/
	}

	/****************************************************************************************/	
	// BEGIN KANTOR CABANG
	/****************************************************************************************/
	public function kantor_cabang()
	{
		$data['container'] = 'kantor_layanan/branch_kantor_cabang';
		$data['cabang'] = $this->model_kantor_layanan->get_all_branch();
		$data['jabatan'] = $this->model_kantor_layanan->get_all_jabatan();
		$data['branch_class_login'] = $this->model_kantor_layanan->get_branch_class_login($this->session->userdata('branch_code'));
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END KANTOR CABANG
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN STATUS KANTOR
	/****************************************************************************************/
	public function status_kantor()
	{
		$data['container'] = 'kantor_layanan/update_branch_status';
		$data['cabang'] = $this->model_kantor_layanan->get_all_branch();
		$data['status_cabang'] = $this->model_kantor_layanan->get_all_status_cabang();
		$data['branch_class_login'] = $this->model_kantor_layanan->get_branch_class_login($this->session->userdata('branch_code'));
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END STATUS KANTOR
	/****************************************************************************************/

	// ------------------------------------------------------------------------------------------
	// BEGIN REMBUG SETUP
	// ------------------------------------------------------------------------------------------
	public function rembug_setup()
	{
		$data['container'] = 'kantor_layanan/rembug_setup';
		$data['branch_id'] = $this->session->userdata('branch_id');
		$data['branch_code'] = $this->session->userdata('branch_code');
		//$data['cabang'] = $this->model_cif->get_all_branch_();
		$data['petugas'] = $this->model_kantor_layanan->get_all_petugas();
		$data['kecamatan'] = $this->model_kantor_layanan->get_kecamatan();
		$data['branch'] = $this->model_kantor_layanan->get_all_branch();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REMBUG SETUP
	/****************************************************************************************/

	// [BEGIN] PETUGAS LAPANGAN SETUP

	public function petugas_lapangan()
	{
		$data['container'] = 'kantor_layanan/petugas_lapangan';
		$data['cabang'] = $this->model_kantor_layanan->get_all_branch_();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}
	// [END] PETUGAS LAPANGAN SETUP


	// [BEGIN] DESA
	public function desa()
	{
		$data['container'] = 'kantor_layanan/desa';
		$data['kecamatan'] = $this->model_kantor_layanan->get_kecamatan();
		$data['city'] = $this->model_kantor_layanan->get_city();
		$this->load->view('core', $data);
	}
	// [END] DESA


	// [BEGIN] KECAMATAN
	public function kecamatan()
	{
		$data['container'] = 'kantor_layanan/kecamatan';
		$data['city'] = $this->model_kantor_layanan->get_city();
		$this->load->view('core', $data);
	}

	// [END] KECAMATAN

	// [BEGIN] KABUPATEN
	public function kabupaten()
	{
		$data['container'] = 'kantor_layanan/kabupaten';
		$data['province'] = $this->model_kantor_layanan->get_province();
		$this->load->view('core', $data);
	}
	// [END] KABUPATEN


	/*
	Identitas Lembaga
	Ujang Irawan
	30 September 2014
	*/

	public function lembaga()
	{
		$data = $this->model_kantor_layanan->get_lembaga();
		$data['container'] = 'kantor_layanan/identitas_lembaga';
		$this->load->view('core',$data);
	}


	public function edit_lembaga()
	{
		$institution_name = $this->input->post('institution_name');
		// $officer_name = $this->input->post('officer_name');
		// $officer_title = $this->input->post('officer_title');
		$alamat = $this->input->post('alamat');
		// $cadangan = $this->input->post('cadangan');
		// $titipan_notaris = $this->input->post('titipan_notaris');
		$cif_type = $this->input->post('cif_type');

		$data = array(
				'institution_name' => $institution_name,
				// 'officer_name' => $officer_name,
				// 'officer_title' => $officer_title,
				'alamat' => $alamat,
				'cif_type' => $cif_type
				// 'cadangan' => $cadangan,
				// 'titipan_notaris' => $this->convert_numeric($titipan_notaris)
			);

		$this->db->trans_begin();
		$this->model_kantor_layanan->edit_lembaga($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}


}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */