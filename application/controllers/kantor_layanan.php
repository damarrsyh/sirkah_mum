<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kantor_layanan extends GMN_Controller {

	function __construct(){
		parent::__construct(TRUE);
		$this->load->model('model_kantor_layanan');
	}

	function kantor_cabang(){
		$branch_code = $this->session->userdata('branch_code');
		$data['container'] = 'kantor_layanan/branch_kantor_cabang';
		$data['cabang'] = $this->model_kantor_layanan->get_all_branch();
		$data['jabatan'] = $this->model_kantor_layanan->get_all_jabatan();
		$data['branch_class_login'] = $this->model_kantor_layanan->get_branch_class_login($branch_code);
		$this->load->view('core',$data);
	}

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



	public function target_cabang()
	{
		$data['container'] = 'kantor_layanan/target_cabang';
		$data['branch_id'] = $this->session->userdata('branch_id');
		$data['branch_code'] = $this->session->userdata('branch_code');
		//$data['cabang'] = $this->model_cif->get_all_branch_();
		$data['petugas'] = $this->model_kantor_layanan->get_all_petugas();
		$data['kecamatan'] = $this->model_kantor_layanan->get_kecamatan();
		$data['branch'] = $this->model_kantor_layanan->get_all_branch();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

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

	/***************************************************************************************/
	//BEGIN PROYEKSI DROPING
	//Author : Aiman
	//Tgl    : 23 - 05 - 18
	/***************************************************************************************/

	function proyeksi_droping()
	{
		$data['title'] = 'Regis Target Droping';
		$data['container'] = 'kantor_layanan/proyeksi_droping';
		$this->load->view('core',$data);
	}

	function action_regis_proyeksi_droping()
	{
			$data = array(
				'branch_code'			=>$this->input->post('result'),
				'year'					=>$this->input->post('year'),
				'month'					=>$this->input->post('month'),
				'account_target'		=>$this->convert_numeric($this->input->post('account_target')),
				'amount_target'			=>$this->convert_numeric($this->input->post('amount_target')),
				'created_by'			=>$this->session->userdata('user_id'),
				'created_date'			=>date('Y-m-d')
				);
		
			$this->db->trans_begin();
			$this->model_kantor_layanan->action_regis_proyeksi_droping($data);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		

		echo json_encode($return);
	}

	function action_update_proyeksi_droping()
	{
		$proyeksi_droping_id = $this->input->post('proyeksi_droping_id');

		if($this->input->post('result2') == '0')
		{
			$branch = $this->input->post('branch_code2');
		}else
		{
			$branch = $this->input->post('result2');
		}

		$data = array(
				'branch_code'			=>$branch,
				'year'					=>$this->input->post('year2'),
				'month'					=>$this->input->post('month2'),
				'account_target'		=>$this->convert_numeric($this->input->post('account_target')),
				'amount_target'			=>$this->convert_numeric($this->input->post('amount_target')),
				'created_by'			=>$this->session->userdata('user_id'),
				'created_date'			=>date('Y-m-d')
				);
		
		$param = array('proyeksi_droping_id'=>$proyeksi_droping_id);
		$this->db->trans_begin();
		$this->model_kantor_layanan->action_update_proyeksi_droping($data, $param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function datatable_proyeksi_droping()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','branch_code','year','month','account_target','amount_target','created_by','created_date','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_kantor_layanan->datatable_proyeksi_droping($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_kantor_layanan->datatable_proyeksi_droping($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_kantor_layanan->datatable_proyeksi_droping(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$rembug='';

			if($aRow['month'] == '1'){$bulan = "Januari";}else
			if($aRow['month'] == '2'){$bulan = "Februari";}else
			if($aRow['month'] == '3'){$bulan = "Maret";}else
			if($aRow['month'] == '4'){$bulan = "April";}else
			if($aRow['month'] == '5'){$bulan = "Mei";}else
			if($aRow['month'] == '6'){$bulan = "Juni";}else
			if($aRow['month'] == '7'){$bulan = "Juli";}else
			if($aRow['month'] == '8'){$bulan = "Agustus";}else
			if($aRow['month'] == '9'){$bulan = "September";}else
			if($aRow['month'] == '10'){$bulan = "Oktober";}else
			if($aRow['month'] == '11'){$bulan = "November";}else
			if($aRow['month'] == '12'){$bulan = "Desember";}

			$row[] = '<input type="checkbox" value="'.$aRow['proyeksi_droping_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['branch_name'];
			$row[] = $bulan.' '.$aRow['year'];
			$row[] = $aRow['account_target'].' orang';
			$row[] = '<div align="right">Rp '.number_format($aRow['amount_target'],0,',','.').',-</div>';
			$row[] = '<a href="javascript:;" proyeksi_droping_id="'.$aRow['proyeksi_droping_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function action_delete_proyeksi()
	{
		$proyeksi_droping_id = $this->input->post('proyeksi_droping_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($proyeksi_droping_id) ; $i++ )
		{
			$param = array('proyeksi_droping_id'=>$proyeksi_droping_id[$i]);

			$check_proyeksi_real = $this->model_kantor_layanan->get_proyeksi_by_id($proyeksi_droping_id[$i]);

			if($check_proyeksi_real['account_real'] == '')
			{
				$this->db->trans_begin();
				$this->model_kantor_layanan->action_delete_proyeksi($param);
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$success++;
				}else{
					$this->db->trans_rollback();
					$failed++;
				}				
			}else
			{
				$failed++;
			}
			
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	function get_proyeksi_by_id()
	{
		$proyeksi_droping_id = $this->input->post('proyeksi_droping_id');
		$data = $this->model_kantor_layanan->get_proyeksi_by_id($proyeksi_droping_id);

		echo json_encode($data);
	}

	function get_proyeksi_by_branch()
	{
		$branch_code = $this->input->post('branch_code');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		if($month == '1'){$mont_ = 'Januari';}else
		if($month == '2'){$mont_ = 'Februari';}else
		if($month == '3'){$mont_ = 'Maret';}else
		if($month == '4'){$mont_ = 'April';}else
		if($month == '5'){$mont_ = 'Mei';}else
		if($month == '6'){$mont_ = 'Juni';}else
		if($month == '7'){$mont_ = 'Juli';}else
		if($month == '8'){$mont_ = 'Agustus';}else
		if($month == '9'){$mont_ = 'September';}else
		if($month == '10'){$mont_ = 'Oktober';}else
		if($month == '11'){$mont_ = 'November';}else
		if($month == '12'){$mont_ = 'Desember';}

		$get =$this->model_kantor_layanan->get_proyeksi_by_branch($branch_code, $year, $month);
		$get_ = $get['total'];

		if($get_ == 0){
			$return = array('valid'=>true);
		}else{

			$branch = $this->model_kantor_layanan->get_branch_name($branch_code);
			$branch_ = $branch['branch_name'];

			$return = array('valid'=>false,'message'=>'Proyeksi cabang '.$branch_.' periode '.$mont_.' '.$year.' telah diproses!!');
		}
		echo json_encode($return);

	}

	/***************************************************************************************/
	//END PROYEKSI DROPING
	/***************************************************************************************/

}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */