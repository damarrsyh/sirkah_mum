<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_administration');
		$this->load->model('model_transaction');
		$this->load->model('model_cif');
		$this->load->model('model_nasabah');
		$this->load->library('html2pdf');
	}

	public function datatable_rekening_tabungan_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_cif.cif_no','mfi_cif.nama','product_name','account_saving_no','');
				
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

		$rResult 			= $this->model_transaction->datatable_rekening_tabungan_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_rekening_tabungan_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_rekening_tabungan_setup(); // get number of all data
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
			$rembug='';
			if($aRow['cm_name']!=""){
				$rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['account_saving_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = $aRow['product_name'];
			$row[] = $aRow['account_saving_no'];
			$row[] = '<a href="javascript:;" account_saving_id="'.$aRow['account_saving_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function ajax_get_value_from_cif_no()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->ajax_get_value_from_cif_no1($cif_no);

		$result = array(
			'branch_code' => $data['branch_code'],
			'nama' => $data['nama'],
			'panggilan' => $data['panggilan'],
			'ibu_kandung' => $data['ibu_kandung'],
			'tmp_lahir' => $data['tmp_lahir'],
			'tgl_lahir' => $data['tgl_lahir'],
			'no_ktp' => $data['no_ktp'],
			'usia' => $data['usia'],
			'alamat' => $data['alamat'],
			'rt_rw' => $data['rt_rw'],
			'desa' => $data['desa'],
			'kecamatan' => $data['kecamatan'],
			'kabupaten' => $data['kabupaten'],
			'cif_no' => $data['cif_no'],
			'cm_code' => $data['cm_code'],
			'kodepos' => $data['kodepos'],
			'telpon_rumah' => $data['telpon_rumah'],
			'cif_type' => $data['cif_type'],
			'telpon_seluler' => $data['telpon_seluler'],
			'majlis' => $data['majlis'],
			'tabungan_wajib' => number_format($data['tabungan_wajib']),
			'tabungan_sukarela' => number_format($data['tabungan_sukarela']),
			'tabungan_kelompok' => number_format($data['tabungan_kelompok'])

		);

		echo json_encode($result);
	}

	function ajax_get_value_from_cif_no_saleh(){
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->ajax_get_value_from_cif_no_saleh($cif_no);

		if(isset($data['total_setoran'])){
			$total = $data['total_setoran'];
		} else {
			$total = '0';
		}

		$result = array(
			'branch_code' => $data['branch_code'],
			'nama' => $data['nama'],
			'cif_no' => $data['cif_no'],
			'cm_code' => $data['cm_code'],
			'total_setoran' => $total
		);

		echo json_encode($result);
	}

	function ajax_get_tabungan(){
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->ajax_get_tabungan($cif_no);

		$result = array(
			'tabungan_wajib' => number_format($data['tabungan_wajib']),
			'tabungan_sukarela' => number_format($data['tabungan_sukarela']),
			'tabungan_kelompok' => number_format($data['tabungan_kelompok'])
		);

		echo json_encode($result);
	}

	function verifikasi_setoran_pokok(){
		$data['container'] = 'transaction/verifikasi_setoran_pokok';
		$data['branch_name_cm'] = ($this->session->userdata('branch_name_cm')==true)?$this->session->userdata('branch_name_cm'):$this->session->userdata('branch_name');
		$data['branch_code_cm'] = ($this->session->userdata('branch_code_cm')==true)?$this->session->userdata('branch_code_cm'):$this->session->userdata('branch_code');
		$data['branch_name_cm'] = ($this->session->userdata('branch_name_cm')==true)?$this->session->userdata('branch_name_cm'):$this->session->userdata('branch_name');
		$branch=$this->model_transaction->get_branch_id_by_code($data['branch_code_cm']);
		$branch_id=$branch['branch_id'];
		$data['branch_id_cm'] = $branch_id;
		$data['branch_class_cm'] = ($this->session->userdata('branch_class_cm')==true)?$this->session->userdata('branch_class_cm'):$this->session->userdata('branch_class');
		$this->load->view('core',$data);
	}

	function datatable_r_verif_anggota(){
		$branch = $_GET['branch'];
		$cm = $_GET['cm'];

		if($cm == '0000'){
			$cm = '';
		}

		$aColumns = array('mc.cif_no','mc.nama','setor_tabungan_wajib','setor_tabungan_kelompok','setor_tabungan_sukarela','');
				
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
						$sWhere = "AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult = $this->model_transaction->datatable_r_verif_anggota($sWhere,$sOrder,$sLimit,$branch,$cm); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_r_verif_anggota($sWhere,'','',$branch,$cm); // get number of filtered data
		$iFilteredTotal = count($rResultFilterTotal); 
		$rResultTotal = $this->model_transaction->datatable_r_verif_anggota('','','',$branch,$cm); // get number of all data
		$iTotal = count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			//"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$rembug='';

			$trx_id = $aRow['trx_id'];
			$cif = $aRow['cif_no'];
			$nama = $aRow['nama'];
			$wajib = $aRow['setor_tabungan_wajib'];
			$kelompok = $aRow['setor_tabungan_kelompok'];
			$sukarela = $aRow['setor_tabungan_sukarela'];

			$row[] = $cif;
			$row[] = $nama;
			$row[] = '<div align="right">Rp '.number_format($wajib,0,',','.').'</div>';
			$row[] = '<div align="right">Rp '.number_format($kelompok,0,',','.').'</div>';
			$row[] = '<div align="right">Rp '.number_format($sukarela,0,',','.').'</div>';
			$row[] = '<a href="javascript:;" id="verif_anggota" trx_id="'.$trx_id.'">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function proses_verifikasi_anggota(){
		@date_default_timezone_set('Asia/Jakarta');
		$id = $this->input->post('id');

		$cek = $this->model_transaction->cek_verif($id);
		$status = $cek['trx_status'];

		$by = $this->session->userdata('user_id');
		$date = date('Y-m-d H:i:s');

		if($status == 0){
			$data = array(
				'trx_status' => 1,
				'verify_by' => $by,
				'verify_date' => $date
			);

			$this->db->trans_begin();
			$this->model_transaction->update_status_verif_pokok($id,$data);

			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$array = array('sukses' => TRUE);
			} else {
				$this->db->trans_rollback();
				$array = array('sukses' => FALSE);
			}
		} else {
			$array = array('sukses' => FALSE);
		}

		echo json_encode($array);
	}

	function verifikasi_pinbuk_setoran(){
		$data['container'] = 'transaction/verifikasi_pinbuk_setoran';
		$data['branch_name_cm'] = ($this->session->userdata('branch_name_cm')==true)?$this->session->userdata('branch_name_cm'):$this->session->userdata('branch_name');
		$data['branch_code_cm'] = ($this->session->userdata('branch_code_cm')==true)?$this->session->userdata('branch_code_cm'):$this->session->userdata('branch_code');
		$data['branch_name_cm'] = ($this->session->userdata('branch_name_cm')==true)?$this->session->userdata('branch_name_cm'):$this->session->userdata('branch_name');
		$branch=$this->model_transaction->get_branch_id_by_code($data['branch_code_cm']);
		$branch_id=$branch['branch_id'];
		$data['branch_id_cm'] = $branch_id;
		$data['branch_class_cm'] = ($this->session->userdata('branch_class_cm')==true)?$this->session->userdata('branch_class_cm'):$this->session->userdata('branch_class');
		$this->load->view('core',$data);
	}

	function datatable_r_verif_pinbuk(){
		$branch = $_GET['branch'];
		//$cm = $_GET['cm'];

		/*
		if($cm == '0000'){
			$cm = '';
		}
		*/

		$aColumns = array('trx_date','wajib','kelompok','total','');
				
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
						$sWhere = "AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult = $this->model_transaction->datatable_r_verif_pinbuk($sWhere,$sOrder,$sLimit,$branch); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_r_verif_pinbuk($sWhere,'','',$branch); // get number of filtered data
		$iFilteredTotal = count($rResultFilterTotal); 
		$rResultTotal = $this->model_transaction->datatable_r_verif_pinbuk('','','',$branch); // get number of all data
		$iTotal = count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			//"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$rembug='';

			$trx_date = $aRow['trx_date'];
			$wajib = $aRow['wajib'];
			$kelompok = $aRow['kelompok'];
			$total = $aRow['total'];
			$created = $aRow['created_date'];

			$row[] = '<center>'.$trx_date.'</center>';
			$row[] = '<center>'.number_format($wajib).'</center>';
			$row[] = '<center>'.number_format($kelompok).'</center>';
			$row[] = '<center>'.number_format($total).'</center>';
			$row[] = '<center><a href="javascript:;" id="verif_kelompok" created="'.$created.'" wajib="'.$wajib.'" kelompok="'.$kelompok.'" total="'.$total.'">Verifikasi</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function datatable_r_detil_pinbuk(){
		$branch = $_GET['branch'];

		$aColumns = array('a.cif_no','a.nama','b.tabungan_wajib','b.tabungan_kelompok','b.simpanan_pokok','b.smk');
				
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
						$sWhere = "AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult = $this->model_transaction->datatable_r_detil_pinbuk($sWhere,$sOrder,$sLimit,$branch); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_r_detil_pinbuk($sWhere,'','',$branch); // get number of filtered data
		$iFilteredTotal = count($rResultFilterTotal); 
		$rResultTotal = $this->model_transaction->datatable_r_detil_pinbuk('','','',$branch); // get number of all data
		$iTotal = count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			//"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$rembug='';

			$cif_no = $aRow['cif_no'];
			$nama = $aRow['nama'];
			$tabungan_wajib = $aRow['tabungan_wajib'];
			$tabungan_kelompok = $aRow['tabungan_kelompok'];
			$simpanan_pokok = $aRow['simpanan_pokok'];
			$smk = $aRow['smk'];

			$row[] = '<center>'.$cif_no.'</center>';
			$row[] = '<center>'.$nama.'</center>';
			$row[] = '<center>'.number_format($tabungan_wajib).'</center>';
			$row[] = '<center>'.number_format($tabungan_kelompok).'</center>';
			$row[] = '<center>'.number_format($simpanan_pokok).'</center>';
			$row[] = '<center>'.number_format($smk).'</center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function proses_pembukuan_setoran_pokok(){
		$wajib = $this->input->post('pwajib');
		$kelompok = $this->input->post('pkelompok');
		$total = $this->input->post('ptotal');
		$created = $this->input->post('pcreated');
		$branch = $this->input->post('pbranch');

		$verify_by = $this->session->userdata('user_id');
		$verify_date = date('Y-m-d H:i:s');

		$u_pokok = array(
			'trx_status' => '1',
			'verify_by' => $verify_by,
			'verify_date' => $verify_date
		);

		$u_smk = array(
			'trx_status' => '1',
			'verify_by' => $verify_by,
			'verify_date' => $verify_date
		);

		$this->db->trans_begin();
		$this->model_transaction->update_setoran_pokok($verify_by,$verify_date,$branch,$created);
		$this->model_transaction->update_setoran_smk($verify_by,$verify_date,$branch,$created);

		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
			$result = array(
				'sukses' => TRUE,
				'message' => 'Verifikasi Berhasil'
			);
		} else {
			$this->db->trans_rollback();
			$result = array(
				'sukses' => FALSE,
				'message' => 'Verifikasi Gagal'
			);
		}

		echo json_encode($result);
	}

	public function ajax_get_tabungan_by_cif_type()
	{
		$cif_type = $this->input->post('cif_type');
		$data = $this->model_transaction->ajax_get_tabungan_by_cif_type($cif_type);

		echo json_encode($data);
	}


	public function ajax_get_value_from_cif_no2()
	{
		$cif_no = $this->input->post('account_saving_no');
		$data = $this->model_transaction->ajax_get_value_from_cif_no2($cif_no);

		echo json_encode($data);
	}

	public function add_rekening_tabungan()
	{
		$product				= $this->input->post('product');
		$product_code			= substr($product,1,5);
		$cif_no		 			= $this->input->post('cif_no');
		$account_saving_no 		= $this->input->post('account_saving_no');
		$branch_code	 		= $this->input->post('branch_code');
		$rencana_setoran 		= $this->input->post('rencana_setoran');
		$rencana_periode_setoran= $this->input->post('rencana_periode_setoran');
		$rencana_jangka_waktu	= $this->input->post('rencana_jangka_waktu');
		$jenis_tabungan			= $this->input->post('jenis_tabungan');
		$rencana_setoran_next_	= $this->input->post('rencana_setoran_next');
        $rencana_setoran_next 	= substr($rencana_setoran_next_,4,4).'-'.substr($rencana_setoran_next_,2,2).'-'.substr($rencana_setoran_next_,0,2);
		$tanggal_pembukaan		= $this->input->post('tanggal_pembukaan');
        $tanggal_buka 			= substr($tanggal_pembukaan,4,4).'-'.substr($tanggal_pembukaan,2,2).'-'.substr($tanggal_pembukaan,0,2);
		$biaya_administrasi     = $this->convert_numeric($this->input->post('biaya_administrasi'));

		if($jenis_tabungan=='1')
		{
			$data = array(
				'product_code'				=>$product_code,
				'cif_no' 					=>$cif_no,
				'account_saving_no' 		=>$account_saving_no,
				'branch_code' 				=>$branch_code,
				'tanggal_buka' 				=>$tanggal_buka,
				'status_rekening'			=>'0',
				'rencana_setoran' 			=>$this->convert_numeric($rencana_setoran),
				'rencana_periode_setoran' 	=>$rencana_periode_setoran,
				'rencana_jangka_waktu' 		=>$rencana_jangka_waktu,
				'rencana_setoran_last' 		=>$tanggal_buka,
				'rencana_setoran_next' 		=>$rencana_setoran_next,
				'created_by' 				=>$this->session->userdata('user_id'),
				'created_date' 				=>date("Y-m-d H:i:s")
				);
		}
		else
		{
			$data = array(
				'product_code'				=>$product_code,
				'cif_no' 					=>$cif_no,
				'status_rekening'			=> '1',
				'account_saving_no' 		=>$account_saving_no,
				'branch_code' 				=>$branch_code,
				'tanggal_buka' 				=>$tanggal_buka,
				'created_by' 				=>$this->session->userdata('user_id'),
				'created_date' 				=>date("Y-m-d H:i:s")
				// 'rencana_setoran_last' 		=>$tanggal_buka,
				// 'rencana_setoran_next' 		=>$rencana_setoran_next
				);
		}
		$data['biaya_administrasi'] = $biaya_administrasi;

		$this->db->trans_begin();
		$this->model_transaction->add_rekening_tabungan($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	
	public function count_cif_by_product_code()
	{
		$product_code = $this->input->post('product_code');
		$data = $this->model_transaction->count_cif_by_product_code($product_code);

		echo json_encode($data);
	}

	/**
	* AJAX GET SEQUENCE NUMBER OF ACCOUNT SAVING NO
	* @author sayyid nurkilah
	* @param product_code
	* @param cif_no
	*/
	function get_seq_account_saving_no()
	{
		$product_code=$this->input->post('product_code');
		$cif_no=$this->input->post('cif_no');
		$data=$this->model_transaction->get_seq_account_saving_no($product_code,$cif_no);
		$jumlah=(int)$data['jumlah'];
		if(count($data)>0){
			$newseq=$jumlah+1;
			if($jumlah<10){
				$newseq='0'.$newseq;
			}
		}else{
			$newseq='01';
		}
		$return=array('newseq'=>$newseq);
		echo json_encode($return);
	}
	
	public function delete_rekening_tabungan()
	{
		$account_saving_id = $this->input->post('account_saving_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_saving_id) ; $i++ )
		{
			$param = array('account_saving_id'=>$account_saving_id[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_rekening_tabungan($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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
	
	public function get_account_saving_by_account_saving_id()
	{
		$account_saving_id = $this->input->post('account_saving_id');
		$data = $this->model_transaction->get_account_saving_by_account_saving_id($account_saving_id);

		echo json_encode($data);
	}
	
	public function edit_rekening_tabungan()
	{
		$account_saving_id		= $this->input->post('account_saving_id');
		$product				= $this->input->post('product2');
		$product_code			= substr($product,1,5);;
		$cif_no		 			= $this->input->post('cif_no2');
		$account_saving_no 		= $this->input->post('account_saving_no2');
		$branch_code	 		= $this->input->post('branch_code2');
		
		$rencana_setoran 		= $this->input->post('rencana_setoran2');
		$rencana_periode_setoran= $this->input->post('rencana_periode_setoran2');
		$rencana_jangka_waktu	= $this->input->post('rencana_jangka_waktu2');

		$product2_code_old		= $this->input->post('product2_code_old');
		$account_saving_no2_old	= $this->input->post('account_saving_no2_old');
		$rencana_setoran_next_	= $this->input->post('rencana_setoran_next2');
        $rencana_setoran_next = substr($rencana_setoran_next_,4,4).'-'.substr($rencana_setoran_next_,2,2).'-'.substr($rencana_setoran_next_,0,2);
		$tanggal_pembukaan2	= $this->input->post('tanggal_pembukaan2');
        $tanggal_buka = substr($tanggal_pembukaan2,4,4).'-'.substr($tanggal_pembukaan2,2,2).'-'.substr($tanggal_pembukaan2,0,2);
		
        $biaya_administrasi = $this->convert_numeric($this->input->post('biaya_administrasi'));

		// if($product2_code_old==$product_code) {
		// 	$return = array('success'=>false,'message'=>'Error: Tidak dapat melakukan edit pada produk yang sama!');
		// }
		// else
		// {
			$data = array(
				'product_code'				=>$product_code,
				'cif_no' 					=>$cif_no,
				'account_saving_no' 		=>$account_saving_no,
				'branch_code' 				=>$branch_code,
				'tanggal_buka' 				=>$tanggal_buka
			);
			$datax = $this->model_transaction->count_cif_by_product_code($product_code);
			
			// if($datax['jumlah']==null){
				$data['rencana_setoran'] 		 = $this->convert_numeric($rencana_setoran);
				$data['rencana_periode_setoran'] = $rencana_periode_setoran;
				$data['rencana_jangka_waktu'] 	 = $rencana_jangka_waktu;
				$data['rencana_setoran_next'] 	 = $rencana_setoran_next;
			// }	
			$data['biaya_administrasi'] = $biaya_administrasi;
			$param = array('account_saving_id'=>$account_saving_id);

			$this->db->trans_begin();
			$this->model_transaction->edit_rekening_tabungan($data,$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true,'message'=>'Success: Edit rekening tabungan berhasil!');
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false,'message'=>'Error: Failed to connect into databases, please try again latter or contact your administrator!');
			}
		// }

		echo json_encode($return);
	}


	/* END REGISTRASI REKENING TABUNGAN *******************************************************/
	//Fungsi Untuk Datatable Deposito
	public function datatable_deposito_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_cif.cif_no','mfi_cif.nama','account_deposit_no','' );
				
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
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
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
						$sWhere = "";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}

		$rResult 			= $this->model_transaction->datatable_deposito_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_deposito_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_deposito_setup(); // get number of all data
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
			if($aRow['cm_name']!=""){
			   $rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			$row[] = '<input type="checkbox" value="'.$aRow['account_deposit_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = $aRow['account_deposit_no'];
			$row[] = '<a href="javascript:;" account_deposit_id="'.$aRow['account_deposit_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	public function get_cfi_by_cif_no()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->get_cfi_by_cif_no($cif_no);

		echo json_encode($data);
	}
	
	public function add_deposito()
	{
		$cif_no		 			= $this->input->post('no_customer');
		$product_code			= $this->input->post('product');
		$branch_code	 		= $this->input->post('branch_code');
		$account_deposit_no 	= $this->input->post('no_rekening');
		$jangka_waktu	 		= $this->input->post('jangka_waktu');
		$jatuh_tempo_	 		= $this->input->post('jatuh_tempo');
		$jatuh_tempo 			= str_replace('/', '', $jatuh_tempo_);
		// $jatuh_tempo_next_	 	= $this->input->post('jatuh_tempo_next');
		// $jatuh_tempo_next		= str_replace('/', '', $jatuh_tempo_next_);
		$nominal	 			= $this->convert_numeric($this->input->post('nominal'));
		$nisbah_bagihasil 		= $this->input->post('nisbah_bagihasil');
		$rek_bagi_hasil 		= $this->input->post('rek_bagi_hasil');
		$ya		 				= $this->input->post('ya');
		$tanggal_buka           = $this->input->post('tanggal_buka');

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal pengajuan
		// $tgl_jtempo 		= substr("$jatuh_tempo",0,2);
	 //    $bln_jtempo 		= substr("$jatuh_tempo",2,2);
	 //    $thn_jtempo 		= substr("$jatuh_tempo",4,4);
	 //    $tglakhir 			= "$thn_jtempo-$bln_jtempo-$tgl_jtempo";  

	    $tgl_buka 		= substr("$tanggal_buka",0,2);
	    $bln_buka 		= substr("$tanggal_buka",3,2);
	    $thn_buka 		= substr("$tanggal_buka",-4);
	    $tglbuka		= "$thn_buka-$bln_buka-$tgl_buka";

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal pengajuan
		// $tgl_jtempo_next	= substr("$jatuh_tempo_next",0,2);
	 //    $bln_jtempo_next	= substr("$jatuh_tempo_next",2,2);
	 //    $thn_jtempo_next	= substr("$jatuh_tempo_next",4,4);
	 //    $tglakhir_next		= "$thn_jtempo_next-$bln_jtempo_next-$tgl_jtempo_next"; 

	 	$tglakhir_next  = date("Y-m-d", strtotime($tglbuka.'+ 1 month'));
	 	$tglakhir  = date("Y-m-d", strtotime($tglbuka.'+ 1 month'));
		
		$data = array(
				'cif_no'				=>$cif_no,
				'branch_code'			=>$branch_code,
				'product_code'			=>$product_code,
				'account_deposit_no'	=>$account_deposit_no,
				'jangka_waktu'			=>$jangka_waktu,
				'nominal'				=>$nominal,
				'nisbah_bagihasil'		=>$nisbah_bagihasil,
				'tanggal_buka'			=>$tglbuka,
				'tanggal_jtempo_last'	=>$tglakhir,
				'tanggal_jtempo_next'	=>$tglakhir_next,
				'account_saving_no'		=>$rek_bagi_hasil,
				'automatic_roll_over'	=>$ya,
				'created_by'			=>$this->session->userdata('user_id'),
				'created_date'			=>date('Y-m-d H:i:s')
				);
		
		$this->db->trans_begin();
		$this->model_transaction->add_deposito($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	
	

	public function delete_deposit()
	{
		$account_deposit_id = $this->input->post('account_deposit_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_deposit_id) ; $i++ )
		{
			$param = array('account_deposit_id'=>$account_deposit_id[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_deposit($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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
	
	public function get_deposit_by_id()
	{
		$account_deposit_id = $this->input->post('account_deposit_id');
		$data = $this->model_transaction->get_deposit_by_id($account_deposit_id);

		echo json_encode($data);
	}
	
	public function edit_deposit()
	{	
		$account_deposit_id		= $this->input->post('account_deposit_id');
		$product_code			= $this->input->post('product');
		$account_deposit_no 	= $this->input->post('no_rekening');
		$jangka_waktu	 		= $this->input->post('jangka_waktu');
		$jatuh_tempo_	 		= $this->input->post('jatuh_tempo');
		$jatuh_tempo 			= str_replace('/', '', $jatuh_tempo_);
		$jatuh_tempo_next_	 	= $this->input->post('jatuh_tempo_next');
		$jatuh_tempo_next		= str_replace('/', '', $jatuh_tempo_next_);
		$nominal	 			= $this->convert_numeric($this->input->post('nominal'));
		$nisbah_bagihasil 		= $this->input->post('nisbah_bagihasil');
		$rek_bagi_hasil 		= $this->input->post('rek_bagi_hasil');
		$ya		 				= $this->input->post('ya');
		$tanggal_buka           = $this->input->post('tanggal_buka');

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal pengajuan
		// $tgl_jtempo 		= substr("$jatuh_tempo",0,2);
	 	// $bln_jtempo 		= substr("$jatuh_tempo",2,2);
	 	// $thn_jtempo 		= substr("$jatuh_tempo",4,4);
	 	// $tglakhir 	    = "$thn_jtempo-$bln_jtempo-$tgl_jtempo"; 

	    $tgl_buka 		= substr("$tanggal_buka",0,2);
	    $bln_buka 		= substr("$tanggal_buka",3,2);
	    $thn_buka 		= substr("$tanggal_buka",-4);
	    $tglbuka		= "$thn_buka-$bln_buka-$tgl_buka";

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal pengajuan
		// $tgl_jtempo_next 	= substr("$jatuh_tempo_next",0,2);
	 	// $bln_jtempo_next 	= substr("$jatuh_tempo_next",2,2);
	 	// $thn_jtempo_next 	= substr("$jatuh_tempo_next",4,4);
	 	// $tglakhir_next		= "$thn_jtempo_next-$bln_jtempo_next-$tgl_jtempo_next"; 

	    // Merubah format tanggal ke dalam format inggris untuk tanggal pengajuan
	    $tglakhir_next  = date("Y-m-d", strtotime($tglbuka.'+ 1 month'));
	 	$tglakhir  = date("Y-m-d", strtotime($tglbuka.'+ 1 month'));
		
		
		$param = array('account_deposit_id'=>$account_deposit_id);
		$data = array(
				'product_code'			=>$product_code,
				'account_deposit_no'	=>$account_deposit_no,
				'jangka_waktu'			=>$jangka_waktu,
				'tanggal_jtempo_last'	=>$tglakhir,
				'tanggal_jtempo_next'	=>$tglakhir_next,
				'nominal'				=>$nominal,
				'nisbah_bagihasil'		=>$nisbah_bagihasil,
				'account_saving_no'		=>$rek_bagi_hasil,
				'automatic_roll_over'	=>$ya,
				'tanggal_buka'          =>$tglbuka
				);
		
		$this->db->trans_begin();
		$this->model_transaction->edit_deposit($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	
	public function cif_count_product_code()
	{
		$product_code	= $this->input->post('product_code');
		$data			= $this->model_transaction->cif_count_product_code($product_code);
		
		echo json_encode($data);
	}

	public function cif_count_jangka_waktu()
	{
		$product_code = $this->input->post('product_code');
		$data 		  = $this->model_transaction->cif_count_jangka_waktu($product_code);

		echo json_encode($data);
	}

	public function cif_count_nisbah_bagihasil()
	{
		$product_code = $this->input->post('product_code');
		$data 		  = $this->model_transaction->cif_count_nisbah_bagihasil($product_code);

		echo json_encode($data);
	}

	/*REGISTRASI REKENING PEMBIAYAAN *******************************************************/
	public function datatable_rekening_pembiayaan_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mc.cif_no','mc.nama','maf.financing_type','maf.account_financing_no','');
				
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
		else
		{
			$sWhere = "WHERE maf.status_rekening ='0'";
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

		$rResult 			= $this->model_transaction->datatable_rekening_pembiayaan_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_rekening_pembiayaan_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_rekening_pembiayaan_setup(); // get number of all data
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
			if($aRow['status_rekening']==0){
			  $aRow['status_rekening'] = '<a href="javascript:;" account_financing_no="'.$aRow['account_financing_no'].'" id="link-edit">Edit</a>';
			  $label_class = $aRow['status_rekening'];
			}
			if($aRow['status_rekening']==0){
			  $aRow['status_rekening'] = '<div align="center"><a href="javascript:;" class="btn mini purple" style="white-space:nowrap;" account_financing_no="'.$aRow['account_financing_no'].'" id="link-edit"><i class="icon-pencil"></i> Edit</a></div>';
			  $label_class = $aRow['status_rekening'];
			}elseif($aRow['status_rekening']==1){
			  $aRow['status_rekening'] = 'Active';
			  $classs = 'info';
			  $label_class = '<span class="label label-'.$classs.'">'.$aRow['status_rekening'].'</span>';
			}elseif($aRow['status_rekening']==2){
			  $aRow['status_rekening'] = 'Lunas';
			  $classs = 'success';
			  $label_class = '<span class="label label-'.$classs.'">'.$aRow['status_rekening'].'</span>';
			}else{
			  $aRow['status_rekening'] = 'Verified';
			  $classs = 'important';
			  $label_class = '<span class="label label-'.$classs.'">'.$aRow['status_rekening'].'</span>';
			}
			$rembug='';
			if($aRow['cm_name']!=""){
			   $rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}

			if($aRow['financing_type'] == 0) {
				$jenis = 'Kelompok';
			} else {
				$jenis = 'Individu';
			}

			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['account_financing_no'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = $jenis;
			$row[] = $aRow['account_financing_no'];
			$row[] = $label_class;

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	
	public function count_cif_by_product_code_financing()
	{
		$product_code = $this->input->post('product_code');
		$data = $this->model_transaction->count_cif_by_product_code_financing($product_code);

		echo json_encode($data);
	}

	
	public function count_cif_by_cif_no_financing()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->count_cif_by_cif_no_financing($cif_no);

		echo json_encode($data);
	}

	
	public function get_ajax_akad()
	{
		$product_code = $this->input->post('product_code');
		$data = $this->model_transaction->get_ajax_akad($product_code);

		echo json_encode($data);
	}

	
	public function get_ajax_jenis_keuntungan()
	{
		$akad = $this->input->post('akad');
		$data = $this->model_transaction->get_ajax_jenis_keuntungan($akad);

		echo json_encode($data);
	}

	public function add_pembiayaan()
	{
		$debug = false;

		/*
		| BEGIN DECLARE VARIABLE
		|------------------------------------------
		*/
		$product_code				= $this->input->post('product');
		$registration_no		 	= $this->input->post('registration_no');
		$cif_no		 				= $this->input->post('cif_no');
		$cif_id		 				= $this->input->post('cif_id');
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$account_financing_no		= $this->input->post('account_financing_no');
		$akad_code					= $this->input->post('akad');
		$nisbah_bagihasil			= $this->input->post('nisbah_bagihasil');
		$uang_muka					= $this->get_numeric($this->input->post('uang_muka'));
		$pokok						= $this->get_numeric($this->input->post('nilai_pembiayaan'));
		$margin 					= $this->get_numeric($this->input->post('margin_pembiayaan'));
		$account_saving				= $this->input->post('account_saving');
		$flag_wakalah				= $this->input->post('flag_wakalah');
		$periode_jangka_waktu		= $this->input->post('periode_angsuran');
		$jangka_waktu				= $this->input->post('jangka_waktu');
		$tanggal_pengajuan			= $this->datepicker_convert(true,$this->input->post('tgl_pengajuan'),'/');
		$tanggal_registrasi			= $this->datepicker_convert(true,$this->input->post('tgl_registrasi'),'/');
		$tanggal_akad				= $this->datepicker_convert(true,$this->input->post('tgl_akad'),'/');
		$tanggal_mulai_angsur		= $this->datepicker_convert(true,$this->input->post('angsuranke1'),'/');
		$tanggal_jtempo				= $this->datepicker_convert(true,$this->input->post('tgl_jtempo'),'/');
		$angs_tanggal				= $this->input->post('angs_tanggal');
		$angs_pokok  				= $this->input->post('angs_pokok');
		$angs_margin				= $this->input->post('angs_margin');
		$angs_tabungan				= $this->input->post('angs_tabungan');
		$angsuran_pokok				= $this->input->post('angsuran_pokok');
		$angsuran_margin			= $this->input->post('angsuran_margin');
		$angsuran_tabungan			= $this->get_numeric($this->input->post('angsuran_tabungan'));
		$tabungan_wajib 			= $this->get_numeric($this->input->post('tabungan_wajib'));
		$tabungan_kelompok 			= $this->get_numeric($this->input->post('tabungan_kelompok'));
		$saldo_pokok 				= $this->get_numeric($this->input->post('nilai_pembiayaan'));
		$saldo_margin 				= $this->get_numeric($this->input->post('margin_pembiayaan'));
		$saldo_cadangan_resiko 		= $this->get_numeric($this->input->post('cadangan_resiko'));
		$dana_kebajikan				= $this->get_numeric($this->input->post('dana_kebajikan'));
		$biaya_administrasi			= $this->get_numeric($this->input->post('biaya_administrasi'));
		$biaya_notaris 				= $this->get_numeric($this->input->post('biaya_notaris'));
		$biaya_asuransi_jiwa 		= $this->get_numeric($this->input->post('p_asuransi_jiwa'));
		$biaya_asuransi_jaminan		= $this->get_numeric($this->input->post('p_asuransi_jaminan'));
		$flag_double_premi = $this->input->post('flag_double_premi');
		$peserta_asuransi = $this->input->post('peserta_asuransi');
		$ktp_asuransi = $this->input->post('ktp_asuransi');
		$tanggal_peserta_asuransi = $this->input->post('tanggal_peserta_asuransi');
	    $tanggal_peserta_asuransi = str_replace('/','',$tanggal_peserta_asuransi);
	    $tanggal_peserta_asuransi = substr($tanggal_peserta_asuransi,4,4).'-'.substr($tanggal_peserta_asuransi,2,2).'-'.substr($tanggal_peserta_asuransi,0,2);
		$hubungan_peserta_asuransi = $this->input->post('hubungan_peserta_asuransi');
		$sumber_dana 				= $this->input->post('sumber_dana_pembiayaan');
		$dana_sendiri 				= $this->get_numeric($this->input->post('dana_sendiri'));
		$dana_sendiri_campuran 		= $this->get_numeric($this->input->post('dana_sendiri_campuran'));
		$dana_kreditur 				= $this->get_numeric($this->input->post('dana_kreditur'));
		$dana_kreditur_campuran 	= $this->get_numeric($this->input->post('dana_kreditur_campuran'));
		$ujroh_kreditur				= $this->get_numeric($this->input->post('keuntungan'));
		$ujroh_kreditur_campuran 	= $this->get_numeric($this->input->post('keuntungan_campuran'));
		$ujroh_kreditur_persen 		= $this->get_numeric($this->input->post('angsuran'));
		$ujroh_kreditur_persen_campuran = $this->get_numeric($this->input->post('angsuran_campuran'));
		$ujroh_kreditur_carabayar	= $this->input->post('pembayaran_kreditur');
		$ujroh_kreditur_carabayar2	= $this->input->post('pembayaran_kreditur2');
		$jenis_program 				= $this->input->post('jenis_program');
		$jadwal_angsuran			= $this->input->post('jadwal_angsuran');
		$branch_code 				= $this->input->post('branch_code');
		$sektor_ekonomi				= $this->input->post('sektor_ekonomi');
		$peruntukan     			= $this->input->post('peruntukan_pembiayaan');
		$kreditur_code1     		= $this->input->post('kreditur_code1');
		$kreditur_code2     		= $this->input->post('kreditur_code2');
		$jaminan     				= $this->input->post('jaminan');
		$keterangan_jaminan     	= $this->input->post('keterangan_jaminan');
		$nominal_taksasi     		= $this->convert_numeric($this->input->post('nominal_taksasi'));
		$keterangan     			= $this->input->post('keterangan');
		$jenis_pembiayaan 			= $this->input->post('jenis_pembiayaan');
		$fa_code 					= $this->input->post('fa_code');
		$pengguna_dana     			= $this->input->post('pengguna_dana');
		$no_hp     					= $this->input->post('no_hp');
		$p_no_hp     				= $this->input->post('p_no_hp');
		$dtk						= $this->get_numeric($this->input->post('dtk'));
		$confirm = TRUE;

		if($jenis_pembiayaan == '0'){
			// kelompok
			$financing_type = '0';
			$fa_code = '';

			/*
			if($akad_code == '310'){
				$flag_wakalah = '1';
			}
			*/
			
		} else {
			// individu
			$financing_type = '1';
		}

		if($tanggal_peserta_asuransi == '--'){
			$tanggal_peserta_asuransi = null;
		}

		if($hubungan_peserta_asuransi == ''){
			$hubungan_peserta_asuransi = 0;
		}

		/*
		| END DECLARE VARIABLE
		|------------------------------------------
		*/

    	$array_data = array();
	    switch ($jadwal_angsuran) {
	    	case '0':

    		$data = array(
				'product_code'				=>$product_code,
				'branch_code'				=>$branch_code,
				'cif_no' 					=>$cif_no,
				'account_financing_no' 		=>$account_financing_no,
				'akad_code' 				=>$akad_code,
				'pokok'		 				=>$this->convert_numeric($pokok),
				'margin' 					=>$this->convert_numeric($margin),
				'periode_jangka_waktu'	 	=>$periode_jangka_waktu,
				'jangka_waktu' 				=>$jangka_waktu,
				'tanggal_pengajuan'			=>$tanggal_pengajuan,
				'tanggal_akad' 				=>$tanggal_akad,
				'tanggal_mulai_angsur' 		=>$tanggal_mulai_angsur,
				'tanggal_jtempo' 			=>$tanggal_jtempo,
				'fa_code' 					=>$fa_code,
				'cadangan_resiko' 			=>$this->convert_numeric($saldo_cadangan_resiko),
				'biaya_administrasi' 		=>$this->convert_numeric($biaya_administrasi),
				'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris),
				'biaya_asuransi_jiwa' 		=>$this->convert_numeric($biaya_asuransi_jiwa),
				'biaya_asuransi_jaminan' 	=>$this->convert_numeric($biaya_asuransi_jaminan),
				'dana_kebajikan'			=>$this->convert_numeric($dana_kebajikan),
				'created_by'				=>$this->session->userdata('user_id'),
				'created_date'				=>date('Y-m-d H:i:s'),
				'program_code'				=>$jenis_program,
				'flag_jadwal_angsuran'		=>$jadwal_angsuran,
				'account_saving_no'			=>$account_saving,
				'sektor_ekonomi' 			=>$sektor_ekonomi,
				'peruntukan' 				=>$peruntukan,
				'registration_no'			=>$registration_no,
				'uang_muka'					=>$this->convert_numeric($uang_muka),
				'tanggal_registrasi'		=>$tanggal_registrasi,
				'jenis_jaminan'				=>$this->get($jaminan),
				'keterangan_jaminan'		=>$this->get($keterangan_jaminan),
				'nisbah_bagihasil'			=>$this->get($nisbah_bagihasil),
				'flag_wakalah'				=>$flag_wakalah,
				'financing_type'			=>$financing_type,
				'program_code'				=>$this->get($jenis_program),
				'peserta_asuransi'			=> $peserta_asuransi,
				'tanggal_peserta_asuransi'	=> $tanggal_peserta_asuransi,
				'hubungan_peserta_asuransi' => $hubungan_peserta_asuransi,
				'flag_double_premi' 		=> $flag_double_premi,
				'pengguna_dana'				=> $pengguna_dana,
				'ktp_asuransi' 				=> $ktp_asuransi,
				'simpanan_wajib_pinjam' 	=> $this->convert_numeric($dtk)
			);

			if($sumber_dana=='0'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri);
			}else if($sumber_dana=='1'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur);
				$data['ujroh_kreditur']				= $ujroh_kreditur_persen;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar;
				$data['kreditur_code']				= $kreditur_code1;
			}else if($sumber_dana=='2'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri_campuran);
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur_campuran);
				$data['ujroh_kreditur']				= $ujroh_kreditur_persen_campuran;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_campuran;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar2;
				$data['kreditur_code']				= $kreditur_code2;
			}
	    	
     	    for($i=0;$i<count($angs_tanggal);$i++)
			{
				$tgl_angsuran = $this->datepicker_convert(true,$angs_tanggal[$i],'/');
				$array_data[] = array(
					'account_no_financing'		=>$account_financing_no,
					'tangga_jtempo' 			=>$tgl_angsuran,
					'angsuran_pokok' 			=>$this->convert_numeric($angs_pokok[$i]),
					'angsuran_margin' 			=>$this->convert_numeric($angs_margin[$i]),
					'angsuran_tabungan' 		=>$this->convert_numeric($angs_tabungan[$i])
				);
		    }

	    	break;
	    	case '1':
    		$data = array(
				'product_code'				=>$product_code,
				'branch_code'				=>$branch_code,
				'cif_no' 					=>$cif_no,
				'account_financing_no' 		=>$account_financing_no,
				'akad_code' 				=>$akad_code,
				'pokok'		 				=>$this->convert_numeric($pokok),
				'margin' 					=>$this->convert_numeric($margin),
				'periode_jangka_waktu'	 	=>$periode_jangka_waktu,
				'jangka_waktu' 				=>$jangka_waktu,
				'tanggal_pengajuan'			=>$tanggal_pengajuan,
				'tanggal_akad' 				=>$tanggal_akad,
				'tanggal_mulai_angsur' 		=>$tanggal_mulai_angsur,
				'tanggal_jtempo' 			=>$tanggal_jtempo,
				'fa_code' 					=>$fa_code,
				'angsuran_pokok'			=>$this->convert_numeric($angsuran_pokok),
				'angsuran_margin'			=>$this->convert_numeric($angsuran_margin),
				'angsuran_catab'			=>$this->convert_numeric($angsuran_tabungan),
				'angsuran_tab_wajib'		=>$this->convert_numeric($tabungan_wajib),
				'angsuran_tab_kelompok'		=>$this->convert_numeric($tabungan_kelompok),
				'saldo_pokok'				=>$this->convert_numeric($saldo_pokok),
				'saldo_margin'				=>$this->convert_numeric($saldo_margin),
				'cadangan_resiko' 			=>$this->convert_numeric($saldo_cadangan_resiko),
				'biaya_administrasi' 		=>$this->convert_numeric($biaya_administrasi),
				'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris),
				'biaya_asuransi_jiwa' 		=>$this->convert_numeric($biaya_asuransi_jiwa),
				'biaya_asuransi_jaminan' 	=>$this->convert_numeric($biaya_asuransi_jaminan),
				'dana_kebajikan'			=>$this->convert_numeric($dana_kebajikan),
				'created_by'				=>$this->session->userdata('user_id'),
				'created_date'				=>date('Y-m-d H:i:s'),
				'program_code'				=>$jenis_program,
				'flag_jadwal_angsuran'		=>$jadwal_angsuran,
				'account_saving_no'			=>$account_saving,
				'sektor_ekonomi' 			=>$sektor_ekonomi,
				'peruntukan' 				=>$peruntukan,
				'registration_no'			=>$registration_no,
				'uang_muka'					=>$this->convert_numeric($uang_muka),
				'tanggal_registrasi'		=>$tanggal_registrasi,
				'jenis_jaminan'				=>$this->get($jaminan),
				'keterangan_jaminan'		=>$this->get($keterangan_jaminan),
				'nisbah_bagihasil'			=>$this->get($nisbah_bagihasil),
				'flag_wakalah'				=>$flag_wakalah,
				'financing_type'			=>$financing_type,
				'program_code'				=>$this->get($jenis_program),
				'peserta_asuransi'			=> $peserta_asuransi,
				'tanggal_peserta_asuransi'	=> $tanggal_peserta_asuransi,
				'hubungan_peserta_asuransi' => $hubungan_peserta_asuransi,
				'flag_double_premi' 		=> $flag_double_premi,
				'pengguna_dana'				=> $pengguna_dana,
				'ktp_asuransi' 				=> $ktp_asuransi,
				'simpanan_wajib_pinjam' 	=> $this->convert_numeric($dtk)
			);

			if ($sumber_dana=='0') {
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri);
				$data['kreditur_code']				= '00';
			} else if($sumber_dana=='1') {
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur);
				$data['ujroh_kreditur']				= $ujroh_kreditur;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar;
				$data['kreditur_code']				= $kreditur_code1;
			} else if ($sumber_dana=='2') {
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri_campuran);
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur_campuran);
				$data['ujroh_kreditur']				= $ujroh_kreditur_campuran;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen_campuran;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar2;
				$data['kreditur_code']				= $kreditur_code2;
			}

	    	break;
	    }

		$data_reg 	= array('status'=>"1",'description'=>$keterangan);
		$param_reg 	= array('account_financing_reg_id'=>$account_financing_reg_id);

		$datasa['no_hp'] =  $no_hp;
		$datasas['p_no_hp'] = $p_no_hp;
		$param_hp = array('cif_no' => $cif_no);
		$param_p_hp = array('cif_id' => $cif_id);

		$cek = $this->model_transaction->cek_hari_libur($tanggal_mulai_angsur);
		if($cek['num'] > 0){
			$confirm = FALSE;
			$return = array(
				'success' => FALSE,
				'message' => 'Tanggal Mulai Angsur Tepat Pada Hari Libur, Silahkan Ubah Kembali'
			);
		}

		if($tanggal_mulai_angsur < $tanggal_akad){
			$confirm = FALSE;
				$return = array(
					'success' => FALSE,
					'message' => 'Tanggal Mulai Angsur Tidak Boleh Lebih Kecil Daripada Tanggal Cair, Silahkan Ubah Kembali'
				);
		}

		if ($debug==true) {

			echo "<pre>";
			print_r($data);
			print_r($array_data);
			print_r($data_reg);
			print_r($param_reg);
			// print_r($datasa);
			die('-Debug Mode-');

		} else {
			if($financing_type == 1){
				if($fa_code == ''){
					$confirm = FALSE;
					$return = array('success'=>false,'message'=>'Petugas harus dipilih');
				}
			}

			if($flag_double_premi == 1){
				if($peserta_asuransi == '' or $tanggal_peserta_asuransi == '--' or $hubungan_peserta_asuransi == '' or $ktp_asuransi == ''){
					$confirm = FALSE;
					$return = array('success'=>FALSE,'message'=>'Data Peserta Asuransi harus diisi');
				}
			}

			if($financing_type == 0){
				$cek = $this->model_transaction->sql_cek($cif_no,$financing_type);

				$jum = $cek['jum'];
				if($jum > 0){
					$confirm = FALSE;
					$return = array('success'=>false,'message'=>'Masih Ada Pembiayaan Kelompok Yang Aktif');
				}
			}

			if($confirm == TRUE){
				$this->db->trans_begin();
				$this->model_transaction->add_rekening_pembiayaan($data);
				$this->model_transaction->update_status_pengajuan_pembiayaan($data_reg,$param_reg);
				$this->model_transaction->update_no_hp($datasa,$param_hp);
				$this->model_transaction->update_p_no_hp($datasas,$param_p_hp);
				if(count($array_data)>0){
					$this->model_transaction->add_rekening_pembiayaan_array($array_data);
				}
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$return = array('success'=>true);
				}else{
					$this->db->trans_rollback();
					$return = array('success'=>false,'message'=>'Koneksi terputus');
				}
			}

			echo json_encode($return);

		}
	}

	
	public function delete_rekening_pembiayaan()
	{
		$account_financing_no 	= $this->input->post('account_financing_no');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_no) ; $i++ )
		{
			$param = array('account_financing_no'=>$account_financing_no[$i]);
			$param2 = array('account_no_financing'=>$account_financing_no[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_rekening_pembiayaan($param);
			$this->model_transaction->delete_account_financing_schedulle($param2);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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

	
	public function delete_rek_pembiayaan()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$approve_by			  = $this->session->userdata('user_id');
		
		// $data = array(
		// 				'status_rekening'=>1,
		// 				'approve_by'	 =>$approve_by,
		// 				'approve_date'	 =>date('Y-m-d H:i:s')
		// 			 );
	
		$param = array('account_financing_id'=>$account_financing_id);

		$this->db->trans_begin();
		// $this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
		$this->model_transaction->delete_rekening_pembiayaan($param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	
	public function get_account_financing_by_account_financing_id()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_account_financing_by_account_financing_no($account_financing_no);

		echo json_encode($data);
	}
	
	public function get_account_financing_by_account_financing_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_account_financing_by_account_financing_no($account_financing_no);

		echo json_encode($data);
	}
	
	public function get_account_financing_by_financing_id()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$data = $this->model_transaction->get_account_financing_by_financing_id($account_financing_id);

		echo json_encode($data);
	}
	
	public function get_account_financing_schedulle_by_no_account()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_account_financing_schedulle_by_no_account($account_financing_no);
		$data['length'] = count($data);
		echo json_encode($data);
	}
	
	public function edit_rekening_pembiayaan()
	{
		$debug = false;

		/*
		| BEGIN DECLARE VARIABLE
		|------------------------------------------
		*/
		$account_financing_schedulle_id	= $this->input->post('account_financing_schedulle_id');
		$account_financing_id			= $this->input->post('account_financing_id');

		$product_code				= $this->input->post('product');
		$registration_no		 	= $this->input->post('registration_no');
		$cif_id		 				= $this->input->post('cif_id');
		$cif_no		 				= $this->input->post('cif_no');
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id2');
		$account_financing_no		= $this->input->post('account_financing_no');
		$akad_code					= $this->input->post('akad');
		$nisbah_bagihasil			= $this->input->post('nisbah_bagihasil');
		$uang_muka					= $this->get_numeric($this->input->post('uang_muka'));
		$pokok						= $this->get_numeric($this->input->post('nilai_pembiayaan'));
		$margin 					= $this->get_numeric($this->input->post('margin_pembiayaan'));
		$account_saving				= $this->input->post('account_saving');
		$flag_wakalah				= $this->input->post('flag_wakalah');
		$periode_jangka_waktu		= $this->input->post('periode_angsuran');
		$jangka_waktu				= $this->input->post('jangka_waktu');
		$tanggal_pengajuan			= $this->datepicker_convert(true,$this->input->post('tgl_pengajuan_edit'),'/');
		$tanggal_registrasi			= $this->datepicker_convert(true,$this->input->post('tgl_registrasi_edit'),'/');
		$tanggal_akad				= $this->datepicker_convert(true,$this->input->post('tgl_akad_edit'),'/');
		$tanggal_mulai_angsur		= $this->datepicker_convert(true,$this->input->post('angsuranke1_edit'),'/');
		$tanggal_jtempo				= $this->datepicker_convert(true,$this->input->post('tgl_jtempo_edit'),'/');
		$angs_tanggal				= $this->input->post('angs_tanggal');
		$angs_pokok  				= $this->input->post('angs_pokok');
		$angs_margin				= $this->input->post('angs_margin');
		$angs_tabungan				= $this->input->post('angs_tabungan');
		$angsuran_pokok				= $this->input->post('angsuran_pokok');
		$angsuran_margin			= $this->input->post('angsuran_margin');
		$angsuran_tabungan			= $this->get_numeric($this->input->post('angsuran_tabungan'));
		$tabungan_wajib 			= $this->get_numeric($this->input->post('tabungan_wajib'));
		$tabungan_kelompok 			= $this->get_numeric($this->input->post('tabungan_kelompok'));
		$saldo_pokok 				= $this->get_numeric($this->input->post('nilai_pembiayaan'));
		$saldo_margin 				= $this->get_numeric($this->input->post('margin_pembiayaan'));
		$saldo_cadangan_resiko 		= $this->get_numeric($this->input->post('cadangan_resiko'));
		$dana_kebajikan				= $this->get_numeric($this->input->post('dana_kebajikan'));
		$biaya_administrasi			= $this->get_numeric($this->input->post('biaya_administrasi'));
		$biaya_notaris 				= $this->get_numeric($this->input->post('biaya_notaris'));
		$biaya_asuransi_jiwa 		= $this->get_numeric($this->input->post('p_asuransi_jiwa'));
		$flag_double_premi = $this->input->post('flag_double_premi');
		$ktp_asuransi = $this->input->post('ktp_asuransi');
		$peserta_asuransi = $this->input->post('peserta_asuransi');
		$tanggal_peserta_asuransi = $this->input->post('tanggal_peserta_asuransi');
	    $tanggal_peserta_asuransi = str_replace('/','',$tanggal_peserta_asuransi);
	    $tanggal_peserta_asuransi = substr($tanggal_peserta_asuransi,4,4).'-'.substr($tanggal_peserta_asuransi,2,2).'-'.substr($tanggal_peserta_asuransi,0,2);
		$hubungan_peserta_asuransi = $this->input->post('hubungan_peserta_asuransi');
		$biaya_asuransi_jaminan		= $this->get_numeric($this->input->post('p_asuransi_jaminan'));
		$sumber_dana 				= $this->input->post('sumber_dana_pembiayaan');
		$dana_sendiri 				= $this->get_numeric($this->input->post('dana_sendiri'));
		$dana_sendiri_campuran 		= $this->get_numeric($this->input->post('dana_sendiri_campuran'));
		$dana_kreditur 				= $this->get_numeric($this->input->post('dana_kreditur'));
		$dana_kreditur_campuran 	= $this->get_numeric($this->input->post('dana_kreditur_campuran'));
		$ujroh_kreditur				= $this->get_numeric($this->input->post('keuntungan'));
		$ujroh_kreditur_campuran 	= $this->get_numeric($this->input->post('keuntungan_campuran'));
		$ujroh_kreditur_persen 		= $this->get_numeric($this->input->post('angsuran'));
		$ujroh_kreditur_persen_campuran = $this->get_numeric($this->input->post('angsuran_campuran'));
		$ujroh_kreditur_carabayar	= $this->input->post('pembayaran_kreditur');
		$ujroh_kreditur_carabayar2	= $this->input->post('pembayaran_kreditur2');
		$jenis_program 				= $this->input->post('jenis_program');
		$jadwal_angsuran			= $this->input->post('jadwal_angsuran');
		$branch_code 				= $this->input->post('branch_code2');
		$sektor_ekonomi				= $this->input->post('sektor_ekonomi');
		$peruntukan     			= $this->input->post('peruntukan_pembiayaan');
		$kreditur_code1     		= $this->input->post('kreditur_code21');
		$kreditur_code2     		= $this->input->post('kreditur_code22');
		$jaminan     				= $this->input->post('jaminan');
		$keterangan_jaminan     	= $this->input->post('keterangan_jaminan');
		$jenis_pembiayaan     		= $this->input->post('jenis_pembiayaan');
		$nominal_taksasi     		= $this->convert_numeric($this->input->post('nominal_taksasi'));
		$keterangan     			= $this->input->post('keterangan');
		$fa_code     				= $this->input->post('fa_code');
		$pengguna_dana				= $this->input->post('pengguna_dana');
		$no_hp     					= $this->input->post('no_hp');
		$p_no_hp					= $this->input->post('p_no_hp');
		$dtk						= $this->get_numeric($this->input->post('dtk'));
		$confirm					= TRUE;
	

		if ($jenis_pembiayaan=='0') {
			$financing_type = '0';
			$fa_code = '0';

			/*
			if($akad_code == '310'){
				$flag_wakalah = '1';
			}
			*/
		} else {
			$financing_type = '1';
		}

		if($tanggal_peserta_asuransi == '--'){
			$tanggal_peserta_asuransi = null;
		}

		if($hubungan_peserta_asuransi == ''){
			$hubungan_peserta_asuransi = 0;
		}

		/*
		| END DECLARE VARIABLE
		|------------------------------------------
		*/

    	$array_data = array();
	    switch ($jadwal_angsuran) {
	    	case '0': //NON REGULER

    		$data = array(
				'product_code'				=>$product_code,
				'branch_code'				=>$branch_code,
				'cif_no' 					=>$cif_no,
				'account_financing_no' 		=>$account_financing_no,
				'akad_code' 				=>$akad_code,
				'pokok'		 				=>$this->convert_numeric($pokok),
				'margin' 					=>$this->convert_numeric($margin),
				'periode_jangka_waktu'	 	=>$periode_jangka_waktu,
				'jangka_waktu' 				=>$jangka_waktu,
				'tanggal_pengajuan'			=>$tanggal_pengajuan,
				'tanggal_akad' 				=>$tanggal_akad,
				'tanggal_mulai_angsur' 		=>$tanggal_mulai_angsur,
				'tanggal_jtempo' 			=>$tanggal_jtempo,
				'cadangan_resiko' 			=>$this->convert_numeric($saldo_cadangan_resiko),
				'biaya_administrasi' 		=>$this->convert_numeric($biaya_administrasi),
				'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris),
				'biaya_asuransi_jiwa' 		=>$this->convert_numeric($biaya_asuransi_jiwa),
				'biaya_asuransi_jaminan' 	=>$this->convert_numeric($biaya_asuransi_jaminan),
				'dana_kebajikan'			=>$this->convert_numeric($dana_kebajikan),
				'program_code'				=>$jenis_program,
				'flag_jadwal_angsuran'		=>$jadwal_angsuran,
				'account_saving_no'			=>$account_saving,
				'sektor_ekonomi' 			=>$sektor_ekonomi,
				'peruntukan' 				=>$peruntukan,
				'uang_muka'					=>$this->convert_numeric($uang_muka),
				'tanggal_registrasi'		=>$tanggal_registrasi,
				'jenis_jaminan'				=>$this->get($jaminan),
				'keterangan_jaminan'		=>$this->get($keterangan_jaminan),
				'nisbah_bagihasil'			=>$this->get($nisbah_bagihasil),
				'flag_wakalah'				=>$flag_wakalah,
				'financing_type'			=>$financing_type,
				'fa_code'					=>$fa_code,
				'program_code'				=>$this->get($jenis_program),
				'peserta_asuransi'			=> $peserta_asuransi,
				'tanggal_peserta_asuransi'	=> $tanggal_peserta_asuransi,
				'hubungan_peserta_asuransi' => $hubungan_peserta_asuransi,
				'flag_double_premi' 		=> $flag_double_premi,
				'pengguna_dana'				=> $pengguna_dana,
				'ktp_asuransi' 				=> $ktp_asuransi,
				'simpanan_wajib_pinjam'		=>$this->convert_numeric($pokok)
			);

			if($sumber_dana=='0'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri);
				$data['kreditur_code']				= '00';
			}else if($sumber_dana=='1'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur);
				$data['ujroh_kreditur']				= $ujroh_kreditur_persen;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar;
				$data['kreditur_code']				= $kreditur_code1;
			}else if($sumber_dana=='2'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri_campuran);
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur_campuran);
				$data['ujroh_kreditur']				= $ujroh_kreditur_persen_campuran;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_campuran;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar2;
				$data['kreditur_code']				= $kreditur_code2;
			}
	    	
     	    for($i=0;$i<count($angs_tanggal);$i++)
			{
				$tgl_angsuran = $this->datepicker_convert(true,$angs_tanggal[$i],'/');
				$array_data[] = array(
					'account_no_financing'		=>$account_financing_no,
					'tangga_jtempo' 			=>$tgl_angsuran,
					'angsuran_pokok' 			=>$this->convert_numeric($angs_pokok[$i]),
					'angsuran_margin' 			=>$this->convert_numeric($angs_margin[$i]),
					'angsuran_tabungan' 		=>$this->convert_numeric($angs_tabungan[$i])
				);
		    }

	    	break;
	    	case '1': // REGULER

    		$data = array(
				'product_code'				=>$product_code,
				'branch_code'				=>$branch_code,
				'cif_no' 					=>$cif_no,
				'account_financing_no' 		=>$account_financing_no,
				'akad_code' 				=>$akad_code,
				'pokok'		 				=>$this->convert_numeric($pokok),
				'margin' 					=>$this->convert_numeric($margin),
				'periode_jangka_waktu'	 	=>$periode_jangka_waktu,
				'jangka_waktu' 				=>$jangka_waktu,
				'tanggal_pengajuan'			=>$tanggal_pengajuan,
				'tanggal_akad' 				=>$tanggal_akad,
				'tanggal_mulai_angsur' 		=>$tanggal_mulai_angsur,
				'tanggal_jtempo' 			=>$tanggal_jtempo,
				'angsuran_pokok'			=>$this->convert_numeric($angsuran_pokok),
				'angsuran_margin'			=>$this->convert_numeric($angsuran_margin),
				'angsuran_catab'			=>$this->convert_numeric($angsuran_tabungan),
				'angsuran_tab_wajib'		=>$this->convert_numeric($tabungan_wajib),
				'angsuran_tab_kelompok'		=>$this->convert_numeric($tabungan_kelompok),
				'saldo_pokok'				=>$this->convert_numeric($saldo_pokok),
				'saldo_margin'				=>$this->convert_numeric($saldo_margin),
				'cadangan_resiko' 			=>$this->convert_numeric($saldo_cadangan_resiko),
				'biaya_administrasi' 		=>$this->convert_numeric($biaya_administrasi),
				'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris),
				'biaya_asuransi_jiwa' 		=>$this->convert_numeric($biaya_asuransi_jiwa),
				'biaya_asuransi_jaminan' 	=>$this->convert_numeric($biaya_asuransi_jaminan),
				'dana_kebajikan'			=>$this->convert_numeric($dana_kebajikan),
				'program_code'				=>$jenis_program,
				'flag_jadwal_angsuran'		=>$jadwal_angsuran,
				'account_saving_no'			=>$account_saving,
				'sektor_ekonomi' 			=>$sektor_ekonomi,
				'peruntukan' 				=>$peruntukan,
				'uang_muka'					=>$this->convert_numeric($uang_muka),
				'tanggal_registrasi'		=>$tanggal_registrasi,
				'jenis_jaminan'				=>$this->get($jaminan),
				'keterangan_jaminan'		=>$this->get($keterangan_jaminan),
				'nisbah_bagihasil'			=>$this->get($nisbah_bagihasil),
				'flag_wakalah'				=>$flag_wakalah,
				'financing_type'			=>$financing_type,
				'fa_code'					=>$fa_code,
				'program_code'				=>$this->get($jenis_program),
				'peserta_asuransi'			=> $peserta_asuransi,
				'tanggal_peserta_asuransi'	=> $tanggal_peserta_asuransi,
				'hubungan_peserta_asuransi' => $hubungan_peserta_asuransi,
				'flag_double_premi' 		=> $flag_double_premi,
				'pengguna_dana'				=> $pengguna_dana,
				'ktp_asuransi' 				=> $ktp_asuransi,
				'simpanan_wajib_pinjam'		=>$this->convert_numeric($dtk)
			);

			if ($sumber_dana=='0') {
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri);
				$data['kreditur_code']				= '00';
			} else if($sumber_dana=='1') {
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur);
				$data['ujroh_kreditur']				= $ujroh_kreditur;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar;
				$data['kreditur_code']				= $kreditur_code1;
			} else if ($sumber_dana=='2') {
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri_campuran);
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur_campuran);
				$data['ujroh_kreditur']				= $ujroh_kreditur_campuran;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen_campuran;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar2;
				$data['kreditur_code']				= $kreditur_code2;
			}

	    	break;
	    }

		$data_reg 	= array('status'=>"1",'description'=>$keterangan);
		$param_reg 	= array('account_financing_reg_id'=>$account_financing_reg_id);
		
		$param 		= array('account_financing_id'=>$account_financing_id);
		$param2 	= array('account_no_financing'=>$account_financing_no);

		$cek = $this->model_transaction->cek_hari_libur($tanggal_mulai_angsur);
		if($cek['num'] > 0){
			$confirm = FALSE;
				$return = array(
					'success' => FALSE,
					'message' => 'Tanggal Mulai Angsur Tepat Pada Hari Libur, Silahkan Ubah Kembali'
				);
		}

		if($tanggal_mulai_angsur < $tanggal_akad){
			$confirm = FALSE;
				$return = array(
					'success' => FALSE,
					'message' => 'Tanggal Mulai Angsur Tidak Boleh Lebih Kecil Daripada Tanggal Cair, Silahkan Ubah Kembali'
				);
		}

		if ($debug==true) {

			echo '<pre>';
			print_r($data);
			print_r($param);
			print_r($param2);
			print_r($array_data);
			die('-Debug Mode-');

		} else {

			if($financing_type == 1){
				if($fa_code == ''){
					$confirm = FALSE;
					$return = array('success'=>false,'message'=>'Petugas harus dipilih');
				}
			}

			if($flag_double_premi == 1){
				if($peserta_asuransi == '' or $tanggal_peserta_asuransi == '--' or $hubungan_peserta_asuransi == '' or $ktp_asuransi == ''){
					$confirm = FALSE;
					$return = array('success'=>FALSE,'message'=>'Data Peserta Asuransi harus diisi');
				}
			}

			if($financing_type == 0){
				$cek = $this->model_transaction->sql_cek($cif_no,$financing_type);

				$jum = $cek['jum'];
				if($jum > 0){
					$confirm = FALSE;
					$return = array('success'=>false,'message'=>'Masih Ada Pembiayaan Kelompok Yang Aktif');
				}
			}

			$datasa['no_hp'] =  $no_hp;
			$datasas['p_no_hp'] = $p_no_hp;
			$param_hp = array('cif_no' => $cif_no);
			$param_p_hp = array('cif_id' => $cif_id);

		    if($confirm == TRUE){
			    $this->db->trans_begin();

				$this->model_transaction->edit_rekening_pembiayaan($data,$param);
				$this->model_transaction->delete_rekening_pembiayaan_array($param2);
				$this->model_transaction->update_status_pengajuan_pembiayaan($data_reg,$param_reg);
				$this->model_transaction->update_no_hp($datasa,$param_hp);
				$this->model_transaction->update_p_no_hp($datasas,$param_p_hp);
				if(count($array_data)>0){
					$this->model_transaction->insert_rekening_pembiayaan_array($array_data);
				}

				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$return = array('success'=>true);
				}else{
					$this->db->trans_rollback();
					$return = array('success'=>false);
				}
			}

			echo json_encode($return);

		}
	}

	public function get_ajax_biaya_administrasi()
	{
		$product 				= $this->input->post('product');
		$biaya_administrasi 	= $this->input->post('biaya_administrasi');
		$tanggal_akad 			= $this->input->post('tgl_akad');
		$tanggal_akad 			= str_replace('/', '', $tanggal_akad);
		//$tanggal_mulai_angsur 	= $this->input->post('angsuranke1');
		$tanggal_jtempo			= $this->input->post('tgl_jtempo');
		$tanggal_jtempo 		= str_replace('/', '', $tanggal_jtempo);

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal akad
		$tgl_akad 			=substr("$tanggal_akad",0,2);
	    $bln_akad 			=substr("$tanggal_akad",2,2);
	    $thn_akad	 		=substr("$tanggal_akad",4,4);
	    $tglakhir_akad		= "$thn_akad-$bln_akad-$tgl_akad";  

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Angsuran
		/*$tgl_mulai_angsur 	=substr("$tanggal_mulai_angsur",0,2);
	    $bln_mulai_angsur 	=substr("$tanggal_mulai_angsur",2,2);
	    $thn_mulai_angsur	=substr("$tanggal_mulai_angsur",4,4);
	    $tglakhir_angsur	= "$thn_mulai_angsur-$bln_mulai_angsur-$tgl_mulai_angsur"; */

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Jatuh Tempo
		$tgl_jtempo     	= substr("$tanggal_jtempo",0,2);
	    $bln_jtempo     	= substr("$tanggal_jtempo",2,2);
	    $thn_jtempo	        = substr("$tanggal_jtempo",4,4);
	    $tglakhir_jtempo	= "$thn_jtempo-$bln_jtempo-$tgl_jtempo";

		$awal_kontrak 		= $tglakhir_akad;
		$akhir_kontrak 		= $tglakhir_jtempo;
		$diff 				= abs(strtotime($akhir_kontrak) - strtotime($awal_kontrak));

		$years 	= floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days 	= floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		if($months>=0){
			$years++;
		}

		/*echo $years;
		die();*/

		//$tahun = $years;
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$data = $this->model_transaction->get_ajax_biaya_administrasi($product,$biaya_administrasi,$years);

		echo json_encode(array('biaya_administrasi'=>$data));
	}

	public function get_ajax_biaya_premi_asuransi_jiwa()
	{
		$product 				= $this->input->post('product');
		$manfaat 				= $this->input->post('total');
		$tgl_lahir 				= $this->input->post('tgl_lahir');
		$tgl_lahir 				= str_replace('-', '', $tgl_lahir);
		$tanggal_akad 			= $this->input->post('tgl_akad');
		$tanggal_akad 			= str_replace('/', '', $tanggal_akad);
		$usia 					= $this->input->post('usia');
		//$tanggal_mulai_angsur 	= $this->input->post('angsuranke1');
		$tanggal_jtempo			= $this->input->post('tgl_jtempo');
		$tanggal_jtempo 		= str_replace('/', '', $tanggal_jtempo);

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal akad
		$tgl_akad 			= substr("$tanggal_akad",0,2);
	    $bln_akad 			= substr("$tanggal_akad",2,2);
	    $thn_akad	 		= substr("$tanggal_akad",4,4);
	    $tglakhir_akad		= "$thn_akad-$bln_akad-$tgl_akad";  

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Angsuran
		/*$tgl_mulai_angsur 	=substr("$tanggal_mulai_angsur",0,2);
	    $bln_mulai_angsur 	=substr("$tanggal_mulai_angsur",2,2);
	    $thn_mulai_angsur	=substr("$tanggal_mulai_angsur",4,4);
	    $tglakhir_angsur	= "$thn_mulai_angsur-$bln_mulai_angsur-$tgl_mulai_angsur"; */

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Jatuh Tempo
		$tgl_jtempo     	= substr("$tanggal_jtempo",0,2);
	    $bln_jtempo     	= substr("$tanggal_jtempo",2,2);
	    $thn_jtempo	        = substr("$tanggal_jtempo",4,4);
	    $tglakhir_jtempo	= "$thn_jtempo-$bln_jtempo-$tgl_jtempo";

		$awal_kontrak 		= $tglakhir_akad;
		$akhir_kontrak 		= $tglakhir_jtempo;

		$diff = abs(strtotime($akhir_kontrak) - strtotime($awal_kontrak));

		$years 	= floor($diff / (365*60*60*24));
		$months	= floor(($diff - ($years * (365*60*60*24))) / (30*60*60*24));
		$days 	= floor(($diff - ($years * (365*60*60*24))) - ($months * (30*60*60*24))/ (60*60*24));
		
		// if($months>0){
			// $years++;
		// }

		// echo $years;
		// echo $months;
		// die();
		
		$masa_kontrak_tahun = $years;
		$masa_kontrak_bulan = $months;
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$awal_lahir 		= $tgl_lahir;
		$tanggal_skrng 		= date('Y-m-d');
		$difff 				= abs(strtotime($tanggal_skrng) - strtotime($awal_lahir));

		$year 	= floor($difff / (365*60*60*24));
		$month 	= floor(($difff - ($year * (365*60*60*24))) / (30*60*60*24));
		$day 	= floor(($difff - ($year * (365*60*60*24))) - ($month * (30*60*60*24))/ (60*60*24));
		
		// if($month>0){
		// 	$year++;
		// }

		if($tgl_lahir=="")
		{
			$year=$usia;
			$month=0;
		}

		// echo $year;
		// echo $month;
		// die();
		
		/*
		$usia_tahun = $year;
		$usia_bulan = $month;*/
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$data = $this->model_transaction->get_ajax_biaya_premi_asuransi_jiwa($product,$manfaat,$year,$month,$years,$months);
		if($data==null){
			$data=0;
		}

		echo json_encode(array('p_asuransi_jiwa'=>$data));
	}

	public function get_ajax_value_from_cif_no()
	{
		$cif_no 			= $this->input->post('cif_no');
		$data 				= $this->model_transaction->get_ajax_value_from_cif_no($cif_no);
		// $data['tgl_lahir'] 	= $this->format_date_detail($data['tgl_lahir'],'id',false,'/');
		echo json_encode($data);
	}

	public function get_ajax_biaya_premi_asuransi_jiwa2()
	{
		$product 				= $this->input->post('product_ins');
		$manfaat 				= $this->input->post('manfaat');
		$tgl_lahir 				= $this->input->post('tgl_lahir');
		$tgl_lahir = str_replace('/', '', $tgl_lahir);
		$tanggal_akad 			= $this->input->post('tgl_akad');
		$tanggal_akad = str_replace('/', '', $tanggal_akad);
		//$tanggal_mulai_angsur 	= $this->input->post('angsuranke1');
		$tanggal_jtempo			= $this->input->post('tgl_jtempo');
		$tanggal_jtempo = str_replace('/', '', $tanggal_jtempo);

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal akad
		$tgl_akad 			=substr("$tanggal_akad",0,2);
	    $bln_akad 			=substr("$tanggal_akad",2,2);
	    $thn_akad	 		=substr("$tanggal_akad",4,4);
	    $tglakhir_akad		= "$thn_akad-$bln_akad-$tgl_akad";  

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Angsuran
		/*$tgl_mulai_angsur 	=substr("$tanggal_mulai_angsur",0,2);
	    $bln_mulai_angsur 	=substr("$tanggal_mulai_angsur",2,2);
	    $thn_mulai_angsur	=substr("$tanggal_mulai_angsur",4,4);
	    $tglakhir_angsur	= "$thn_mulai_angsur-$bln_mulai_angsur-$tgl_mulai_angsur"; */

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Jatuh Tempo
		$tgl_jtempo     	=substr("$tanggal_jtempo",0,2);
	    $bln_jtempo     	=substr("$tanggal_jtempo",2,2);
	    $thn_jtempo	        =substr("$tanggal_jtempo",4,4);
	    $tglakhir_jtempo	= "$thn_jtempo-$bln_jtempo-$tgl_jtempo";

		$awal_kontrak 		= $tglakhir_akad;
		$akhir_kontrak 		= $tglakhir_jtempo;
		$diff = abs(strtotime($akhir_kontrak) - strtotime($awal_kontrak));

		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		if($months>0){
			$years++;
		}

		/*echo $years;
		echo $months;
		die();*/
/*
		$masa_kontrak_tahun = $years;
		$masa_kontrak_bulan = $months;*/
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$awal_lahir 		= $tgl_lahir;
		$tanggal_skrng 		= date('Y-m-d');
		$difff = abs(strtotime($tanggal_skrng) - strtotime($awal_lahir));

		$year = floor($difff / (365*60*60*24));
		$month = floor(($difff - $year * 365*60*60*24) / (30*60*60*24));
		$day = floor(($difff - $year * 365*60*60*24 - $month*30*60*60*24)/ (60*60*24));
		if($month>0){
			$year++;
		}

		/*echo $year;
		echo $month;
		die();*/
/*
		$usia_tahun = $year;
		$usia_bulan = $month;*/
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$data = $this->model_transaction->get_ajax_biaya_premi_asuransi_jiwa($product,$manfaat,$year,$month,$years,$months);
		if($data==null){
			$data=0;
		}

		echo json_encode(array('p_asuransi_jiwa'=>$data));
	}

	//END REKENING PEMBIAYAAN

	// BEGIN DATATABLE PERSEDIAAN MBA
	function datatable_persediaan_mba_setup(){

		$param_branch_code = isset($_GET['param_branch_code'])?$_GET['param_branch_code']:'';

		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'account_financing_no','mfi_cif.nama','mfi_akad.akad_name','pokok','');
		// $cm_code = @$_GET['cm_code'];
				
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
			$sWhere = " WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
			if($sWhere==""){
				$sWhere = " WHERE mfi_account_financing.status_rekening ='0'";
			}else{
				$sWhere .= " AND mfi_account_financing.status_rekening ='0'";
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
						$sWhere = " WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_transaction->datatable_persediaan_mba_setup($sWhere,$sOrder,$sLimit,$param_tanggal_akad,$param_branch_code); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_persediaan_mba_setup($sWhere,'','',$param_tanggal_akad,$param_branch_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_persediaan_mba_setup('','','',$param_tanggal_akad,$param_branch_code); // get number of all data
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
		
		foreach($rResult as $aRow){
			$row = array();

			$account_financing_no = $aRow['account_financing_no'];
			$nama = $aRow['nama'];
			$tanggal_akad = $aRow['tanggal_akad'];
			$pokok = $aRow['pokok'];

			$row[] = $account_financing_no;
			$row[] = $nama;
			$row[] = $tanggal_akad;
			$row[] = '<div align="right">Rp '.number_format($pokok,0,',','.').',-</div>';
			$row[] = '<a href="javascript:;" account_financing_no="'.$account_financing_no.'" id="link-edit">Detail</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	//BEGIN VERIFIKASI REKENING PEMBIAYAAN


	/*REGISTRASI REKENING PEMBIAYAAN *******************************************************/
	

	public function datatable_rekening_ver_pembiayaan_setup()
	{

		$param_tanggal_akad = isset($_GET['param_tanggal_akad'])?$_GET['param_tanggal_akad']:'';
		$param_branch_code = isset($_GET['param_branch_code'])?$_GET['param_branch_code']:'';

		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'account_financing_no','mfi_cif.nama','mfi_akad.akad_name','pokok','');
		// $cm_code = @$_GET['cm_code'];
				
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
			if($sWhere==""){
				$sWhere = " WHERE mfi_account_financing.status_rekening ='0'";
			}else{
				$sWhere .= " AND mfi_account_financing.status_rekening ='0'";
			}

		// else
		// {
		// 	$sWhere = "where mfi_account_financing.status_rekening ='0'";
		// }
		
		// if($sWhere==""){
			// $sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		// }else{
			// $sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
		// }

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

		$rResult 			= $this->model_transaction->datatable_rekening_ver_pembiayaan_setup($sWhere,$sOrder,$sLimit,$param_tanggal_akad,$param_branch_code); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_rekening_ver_pembiayaan_setup($sWhere,'','',$param_tanggal_akad,$param_branch_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_rekening_ver_pembiayaan_setup('','','',$param_tanggal_akad,$param_branch_code); // get number of all data
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
			if($aRow['cm_name']!=""){
			   $rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			// $row[] = '<input type="checkbox" value="'.$aRow['account_financing_no'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = $aRow['akad_name'];
			$row[] = '<div align="right">Rp '.number_format($aRow['pokok'],0,',','.').',-</div>';
			$row[] = $aRow['display_text'];
			$row[] = '<a href="javascript:;" account_financing_no="'.$aRow['account_financing_no'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function verifikasi_rekening_pembiayaan()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$approve_by			  = $this->session->userdata('fullname');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>1,
							'approve_by'	 =>$approve_by,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_financing_id'=>$account_financing_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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

	public function in_verifikasi_rekening_pembiayaan()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$approve_by			  = $this->session->userdata('fullname');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>0,
							'approve_by'	 =>$approve_by,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_financing_id'=>$account_financing_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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

	function verifikasi_rek_pembiayaan(){
		$account_financing_id = $this->input->post('account_financing_id');
		$cif_no = $this->input->post('cif_no');
		$financing_type = $this->input->post('financing_type');
		$branch_code = $this->input->post('branch_code2');
		$tanggal_penga = $this->input->post('tgl_pengajuan');
		$tanggal_pengajuan_ = str_replace('/','', $tanggal_penga);
        $tanggal_pengajuan = substr($tanggal_pengajuan_,4,4).'-'.substr($tanggal_pengajuan_,2,2).'-'.substr($tanggal_pengajuan_,0,2);
		$pro_code = $this->input->post('pro_code');
		$approve_date = date('Y-m-d H:i:s');
		$approve_by = $this->session->userdata('user_id');

		$data = array(
			'status_rekening' => '1',
			'approve_by' => $approve_by,
			'approve_date' => $approve_date
		);

		$param = array('account_financing_id' => $account_financing_id);

		$data2 = array('status' => '1');
		$param2 = array('cif_no' => $cif_no);

		if($financing_type == '1'){
			$product_code = $this->model_nasabah->get_product_code_on_list_code_detail_by_product_financing($pro_code);
			$cek_exist_data_on_account_saving = $this->model_nasabah->cek_exist_data_on_account_saving($cif_no,$product_code);

			if($cek_exist_data_on_account_saving == TRUE){
				$rekening_baru = $cif_no;

				$data_account_saving = array(
					'product_code' => $product_code,
					'cif_no' => $cif_no,
					'account_saving_no' => $rekening_baru,
					'branch_code' => $branch_code,
					'tanggal_buka' => $tanggal_pengajuan,
					'status_rekening' => '1',
					'saldo_riil' => '0',
					'saldo_memo' => '0',
					'saldo_hold' => '0',
					'created_by' => $approve_by,
					'created_date' => $approve_date
				);

				$this->model_transaction->add_rekening_tabungan($data_account_saving);
			} else {
				$call_rekening = $this->model_nasabah->get_saving_individu($cif_no);
				$rekening_baru = $call_rekening['account_saving_no'];
			}

			$d_saving = array('account_saving_no' => $rekening_baru);
			$p_saving = array('account_financing_id' => $account_financing_id);

			$this->model_transaction->edit_rekening_pembiayaan($d_saving,$p_saving);
		} else {
			$cek = $this->model_transaction->sql_cek($cif_no,$financing_type);

			$jum = $cek['jum'];
			if($jum > 0){
				$confirm = FALSE;
				$return = array(
					'success' => FALSE,
					'message' => 'Masih Ada Pembiayaan Kelompok Yang Aktif'
				);
			}
		}
		
		$this->db->trans_begin();
		$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
		$this->model_transaction->update_status_financing_reg($data2,$param2);
		$this->db->reconnect();
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function verifikasi_rek_pembiayaan_new(){
		$account_financing_id = $this->input->post('account_financing_id');
		$cif_no = $this->input->post('cif_no');
		$financing_type = $this->input->post('financing_type');
		$branch_code = $this->input->post('branch_code2');
		$tanggal_penga = $this->input->post('tgl_pengajuan');
		$tanggal_pengajuan_ = str_replace('/','', $tanggal_penga);
        $tanggal_pengajuan = substr($tanggal_pengajuan_,4,4).'-'.substr($tanggal_pengajuan_,2,2).'-'.substr($tanggal_pengajuan_,0,2);
		$pro_code = $this->input->post('pro_code');
		$approve_date = date('Y-m-d H:i:s');
		$approve_by = $this->session->userdata('user_id');
		$dtk = $this->convert_numeric($this->input->post('dtk'));
		$confirm = TRUE;

		$data = array(
			'status_rekening' => '1',
			'approve_by' => $approve_by,
			'approve_date' => $approve_date
		);

		$param = array('account_financing_id' => $account_financing_id);

		$data2 = array('status' => '1');
		$param2 = array('cif_no' => $cif_no);

		if($financing_type == '1'){
			$product_code = $this->model_nasabah->get_product_code_on_list_code_detail_by_product_financing($pro_code);
			$cek_exist_data_on_account_saving = $this->model_nasabah->cek_exist_data_on_account_saving($cif_no,$product_code);

			if($cek_exist_data_on_account_saving == TRUE){
				$rekening_baru = $cif_no;

				$data_account_saving = array(
					'product_code' => $product_code,
					'cif_no' => $cif_no,
					'account_saving_no' => $rekening_baru,
					'branch_code' => $branch_code,
					'tanggal_buka' => $tanggal_pengajuan,
					'status_rekening' => '1',
					'saldo_riil' => '0',
					'saldo_memo' => '0',
					'saldo_hold' => '0',
					'created_by' => $approve_by,
					'created_date' => $approve_date
				);
			} else {
				$call_rekening = $this->model_nasabah->get_saving_individu($cif_no);
				$rekening_baru = $call_rekening['account_saving_no'];
			}

			$d_saving = array('account_saving_no' => $rekening_baru);
			$p_saving = array('account_financing_id' => $account_financing_id);
		} else {
			$cek = $this->model_transaction->sql_cek($cif_no,$financing_type);

			$jum = $cek['jum'];
			if($jum > 0){
				$confirm = FALSE;
				$return = array(
					'success' => FALSE,
					'message' => 'Masih Ada Pembiayaan Kelompok Yang Aktif'
				);
			}
		}

		$cek_saving_dtk = $this->model_transaction->cek_saving_dtk($cif_no);
		$count_dtk = count($cek_saving_dtk);

		if($count_dtk > 0){
			$data_dtk = array('rencana_setoran' => $dtk, 'rencana_jangka_waktu' => '1', 'counter_angsruan' => '0');
			$param_dtk = array('account_saving_no' => $cek_saving_dtk['account_saving_no']);
		} else {
			$create_dtk = array(
				'product_code' => '0099',
				'cif_no' => $cif_no,
				'account_saving_no' => $cif_no,
				'branch_code' => $branch_code,
				'tanggal_buka' => $tanggal_pengajuan,
				'status_rekening' => '1',
				'rencana_setoran' => $dtk,
				'rencana_jangka_waktu' => '1',
				'rencana_periode_setoran' => '1',
				'counter_angsruan'=> '0',
				'created_by' => $approve_by,
				'created_date' => $approve_date
			);
		}

		if($confirm == TRUE){
			$this->db->trans_begin();

			if($financing_type == '1'){
				if($cek_exist_data_on_account_saving == TRUE){
					$this->model_transaction->add_rekening_tabungan($data_account_saving);
				}

				$this->model_transaction->edit_rekening_pembiayaan($d_saving,$p_saving);
			}

			$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
			$this->model_transaction->update_status_financing_reg($data2,$param2);

			if($count_dtk > 0){
				$this->model_transaction->edit_rekening_tabungan($data_dtk,$param_dtk);
			} else {
				$this->model_transaction->add_rekening_tabungan($create_dtk);
			}

			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$return = array('success' => TRUE);
			} else {
				$this->db->trans_rollback();
				$return = array('success' => FALSE);
			}
		}

		echo json_encode($return);
	}

	function proses_wakalah(){
		$nama = $this->input->post('nama');
		$majelis = $this->input->post('cm_name');
		$branch_code = $this->input->post('branch_code2');
		$rekening = $this->input->post('account_financing_no');
		$pokok = $this->input->post('nilai_pembiayaan');
		$periode = $this->input->post('tanggal_wakalah');
		$kas = $this->input->post('account_cash_code');
		$product_code = $this->input->post('pro_code');
		$created_by = $this->session->userdata('user_id');
		$created_date = date('Y-m-d H:i:s');
		$description = 'TRX WAKALAH MBA A.N '.$nama.' ('.$rekening.') || '.$majelis;
		$description2 = 'WAKALAH MBA A.N '.$nama.' ('.$rekening.') || '.$majelis;

		$pokok = str_replace('.','',$pokok);

		$tanggal = substr($periode,0,2);
		$bulan = substr($periode,2,2);
		$tahun = substr($periode,-4);

		$tanggal_wakalah = $tahun.'-'.$bulan.'-'.$tanggal;

		$update = array('iswakalah' => '1');
		$param = array('account_financing_no' => $rekening);

		$wakalah_id = uuid(FALSE);
		$trx_gl_id = uuid(FALSE);

		$insert = array(
			'account_financing_wakalah_id' => $wakalah_id,
			'account_financing_no' => $rekening,
			'tanggal_wakalah' => $tanggal_wakalah,
			'account_cash_code' => $kas,
			'create_by' => $created_by,
			'created_date' => $created_date
		);

		// INSERT KAS PETUGAS
		$insert2 = array(
			'trx_date' => $tanggal_wakalah,
			'account_cash_code' => $kas,
			'trx_gl_cash_type' => '7',
			'flag_debet_credit' => 'C',
			'account_teller_code' => $kas,
			'voucher_date' => $tanggal_wakalah,
			'voucher_ref' => $rekening,
			'description' => $description2,
			'created_by' => $created_by,
			'created_date' => $created_date,
			'amount' => $pokok,
			'status' => '1',
			'trx_gl_id' => $trx_gl_id
		);

		// GET GL WAKALAH
		$gl_wakalah_code = $this->model_transaction->gl_wakalah_code($product_code);
		$product_gl = $gl_wakalah_code['gl_titipan_wakalah'];

		// GET GL ACCOUNT CASH CODE
		$gl_cash_code = $this->model_transaction->gl_cash_code($kas);
		$cash_gl = $gl_cash_code['gl_account_code'];

		// CREATE JURNAL
		$insert3 = array(
			'trx_gl_id' => $trx_gl_id,
			'trx_date' => $tanggal_wakalah,
			'voucher_date' => $tanggal_wakalah,
			'voucher_ref' => $rekening,
			'branch_code' => $branch_code,
			'jurnal_trx_id' => $wakalah_id,
			'created_by' => $created_by,
			'created_date' => $created_date,
			'description' => $description
		);

		// CREATE JURNAL DETAIL
		$insert_gl = array();
		$insert_gl[] = array(
			'trx_gl_id' => $trx_gl_id,
			'account_code' => $product_gl,
			'flag_debit_credit' => 'D',
			'amount' => $pokok,
			'description' => $description2,
			'trx_sequence' => '0'
		);

		$insert_gl[] = array(
			'trx_gl_id' => $trx_gl_id,
			'account_code' => $cash_gl,
			'flag_debit_credit' => 'C',
			'amount' => $pokok,
			'description' => $description2,
			'trx_sequence' => '1'
		);

		$this->db->trans_begin();
		$this->model_transaction->insert_wakalah($insert);
		$this->model_transaction->update_account_financing($update,$param);
		$this->model_transaction->insert_trx_gl_cash($insert2);
		$this->model_transaction->insert_mfi_trx_gl($insert3);
		$this->model_transaction->insert_batch_gl_detail($insert_gl);

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}


	/****************************************************************************************/	
	// BEGIN ASURANSI SETUP
	/****************************************************************************************/
	public function datatable_insurance_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_account_insurance.account_insurance_no', 'mfi_cif.nama', 'mfi_product_insurance.product_name','mfi_account_insurance.status_rekening');
				
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
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
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
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}
		$rResult 			= $this->model_transaction->datatable_insurance_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_insurance_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_insurance_setup(); // get number of all data
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
			if($aRow['cm_name']!=""){
			   $rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			$row[] = '<input type="checkbox" value="'.$aRow['account_insurance_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_insurance_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = $aRow['product_name'];
			$row[] = $aRow['status_rekening'];
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_insurance()
	{
		$product_code_ 		= $this->input->post('product_code');
		$product_code 		=substr("$product_code_",2,3);
		$cif_no 	 		= $this->input->post('cif_no');
		$rate_type	 		= $this->input->post('rate_type');
		if($rate_type==0)
		{
			$benefit_value 		= $this->input->post('benefit_value');
			$awal_kontrak_		= $this->input->post('awal_kontrak0');
			$akhir_kontrak_		= $this->input->post('akhir_kontrak0');
			$usia_peserta 		= $this->input->post('usia');
			$premium_rate 		= $this->input->post('premium_rate0');
			$premium_value 		= $this->input->post('premium_value0');
			$plan_code	 		= NULL;
		}
		else if($rate_type==1)
		{
			$benefit_value 		= $this->input->post('benefit_value');
			$awal_kontrak_		= $this->input->post('awal_kontrak0');
			$akhir_kontrak_		= $this->input->post('akhir_kontrak0');
			$usia_peserta 		= $this->input->post('usia');
			$premium_rate 		= $this->input->post('premium_rate0');
			$premium_value 		= $this->input->post('premium_value0');
			$plan_code	 		= NULL;
		}
		else if($rate_type==2)
		{
			$benefit_value 		='0';
			$awal_kontrak_		= $this->input->post('awal_kontrak1');
			$akhir_kontrak_		= $this->input->post('akhir_kontrak1');
			$usia_peserta 		= $this->input->post('usia');
			$premium_rate 		= '0';
			$premium_value 		= $this->input->post('premium_value1');
			$plan_code_	 		= $this->input->post('plan_code');
			$plan_code 			=substr("$plan_code_",0,8);
		}

		
		$created_by 		  = $this->session->userdata('user_id');
		$account_insurance_no = $this->input->post('account_no');
		$rekening_tabungan 	  = $this->input->post('rekening_tabungan');
		//$nama_pemegang_rek    = $this->input->post('nama_pemegang_rek');

		$tgl =substr("$awal_kontrak_",0,2);
	    $bln =substr("$awal_kontrak_",2,2);
	    $thn =substr("$awal_kontrak_",4,4);
	    $awal_kontrak = "$thn-$bln-$tgl";  

		$tgl2 =substr("$akhir_kontrak_",0,2);
	    $bln2 =substr("$akhir_kontrak_",2,2);
	    $thn2 =substr("$akhir_kontrak_",4,4);
	    $akhir_kontrak = "$thn2-$bln2-$tgl2"; 

			$data = array(
				'product_code'			=>$product_code,
				'cif_no'				=>$cif_no,
				'benefit_value' 		=>$benefit_value,
				'premium_rate' 			=>$premium_rate,
				'premium_value' 		=>$premium_value,
				'awal_kontrak' 			=>$awal_kontrak,
				'akhir_kontrak' 		=>$akhir_kontrak,
				'plan_code' 			=>$plan_code,
				'created_by' 			=>$created_by,
				'created_date' 			=>date('Y-m-d H:i:s'),
				'usia_peserta' 			=>$usia_peserta,
				'account_insurance_no'	=>$account_insurance_no,
				'account_saving_no'		=>$rekening_tabungan
				);
		

		$this->db->trans_begin();
		$this->model_transaction->add_insurance($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_insurance()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_insurance_id) ; $i++ )
		{
			$param = array('account_insurance_id'=>$account_insurance_id[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_insurance($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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

	public function get_account_insurance_by_account_insurance_id()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$data = $this->model_transaction->get_account_insurance_by_account_insurance_id($account_insurance_id);

		echo json_encode($data);
	}

	public function edit_insurance()
	{
		$smk_id				= $this->input->post('smk_id');
		$sertifikat_no 		= $this->input->post('sertifikat_no2');
		$nama 				= $this->input->post('nama2');
		$nominal 			= $this->input->post('nominal2');
		$status 			= "0";
		$created_by			= $this->session->userdata('user_id2');
		$created_date		= date('Y-m-d H:i:s');
		$status_anggota		= $this->input->post('status_anggota2');
		if ($status_anggota=='0') 
		{			
			$cif_no 		= $this->input->post('cif_no2');
		} 
		else 
		{
			$cif_no = '';
		}
		
		$tanggal_mulai		= $this->input->post('date_issued2');

		$tgl =substr("$tanggal_mulai",0,2);
	    $bln =substr("$tanggal_mulai",2,2);
	    $thn =substr("$tanggal_mulai",4,4);
	    $date_issued = "$thn-$bln-$tgl";  

		$param = array('smk_id'=>$smk_id);

			$data = array(
				'sertifikat_no'		=>$sertifikat_no,
				'nama' 				=>$nama,
				'nominal' 			=>$nominal,
				'date_issued' 		=>$date_issued,
				'status' 			=>$status,				
				'created_by' 		=>$created_by,
				'created_date' 		=>$created_date,
				'status_anggota'	=>$status_anggota,
				'cif_no' 			=>$cif_no
				);
		

		$this->db->trans_begin();
		$this->model_cif->edit_registrasi_smk($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function count_account_no_by_product_code()
	{
		$product_code = $this->input->post('product_code');
		$data = $this->model_transaction->count_account_no_by_product_code($product_code);

		$jumlah = $data['jumlah'];
			if($jumlah==null)
            {
              $total = 0;
            }
            else
            {
              $total = $jumlah;
            }
            $no_urut = $total+1;
            $no_urut_ = sprintf('%03s', $no_urut);            
            $no_urut_account = $product_code.''.$no_urut_;

		echo $no_urut_account;
	}

	public function count_premi_rate_0()
	{
		$benefit_value 	= $this->input->post('benefit_value');
		$rate_type 		= '0';
		$data 			= $this->model_transaction->count_premi_rate_0($rate_type);

		if (count($data)==0) {
			$premium_value = "Tidak Ditemukan";
		} else {		
			$premi = $data['rate'];
			$premium_value = $premi * $benefit_value;
		}

		echo $premium_value;
	}

	public function count_premi_rate_1()
	{
		$param = $this->input->post('param');
		$pecah = explode("-", $param);
		$rate_code 		= $pecah[0];
		$usia 			= $pecah[1];
		$kontrak 		= $pecah[2];
		$benefit_value 	= $pecah[3];
		$data 			= $this->model_transaction->count_premi_rate_1($rate_code,$usia,$kontrak);

		if (count($data)==0) {
			$premium_value = "Tidak Ditemukan";
		} else {		
			$premi = $data['rate'];
			$premium_value = $premi * $benefit_value;
		}

		echo $premium_value;
	}

	public function count_premi_rate_2()
	{
		$plan_code = $this->input->post('plan_code');
		$data = $this->model_transaction->count_premi_rate_2($plan_code);

		if (count($data)==0) {
			$premium_value = "Tidak Ditemukan";
		} else {		
			$premi = $data['rate'];
			$premium_value = $premi * $benefit_value;
		}

		echo $premium_value;
	}

	public function menghitung_tahun()
	{
		$tanggal = $this->input->post('tanggal');
		$pecah = explode("-", $tanggal);
		$tgl1 = $pecah[0];
		$tgl2 = $pecah[1];

		$date1 = substr($tgl1,0,2);
		$month1 = substr($tgl1,2,2);
		$year1 = substr($tgl1,4,4);


		$date2 =  substr($tgl2,0,2);
		$month2 =  substr($tgl2,2,2);
		$year2 =   substr($tgl2,4,4);

		// menghitung JDN dari masing-masing tanggal

		$jd1 = GregorianToJD($month1, $date1, $year1);
		$jd2 = GregorianToJD($month2, $date2, $year2);

		// hitung selisih hari kedua tanggal

		$selisih = $jd2 - $jd1;
		$tahun = ceil($selisih/365);

		echo $tahun;
	}

	

	/****************************************************************************************/	
	// END ASURANSI SETUP
	/****************************************************************************************/


	/* BEGIN PENARIKAN TUNAI TABUNGAN *******************************************************/

	public function penarikan_tunai()
	{
		$data['container'] = 'transaction/penarikan_tunai';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$branch_code = $this->session->userdata('branch_code');
		$data['account_cash'] = $this->model_transaction->ajax_get_gl_account_cash_by_keyword('',$branch_code,'0');
		$this->load->view('core',$data);
	}

	function search_account_saving_no_baru(){
		$keyword = $this->input->post('keyword');
		$branch_code = $this->session->userdata('branch_code');

		$data = $this->model_transaction->search_account_saving_no_baru($keyword,$branch_code);

		echo json_encode($data);
	}

	public function search_account_saving_no()
	{
		$keyword = $this->input->post('keyword');
		$cm_code = $this->input->post('cm_code');
		$branch = $this->session->userdata('branch_code');
		$data = $this->model_transaction->account_saving_no_individu($keyword,$cm_code,$branch);

		echo json_encode($data);
	}

	public function search_account_saving_no_active()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_transaction->search_account_saving_no_active($keyword);

		echo json_encode($data);
	}

	function search_rekening_tabungan_pencairan(){
		$keyword = $this->input->post('keyword');
		$data = $this->model_transaction->search_rekening_tabungan_pencairan($keyword);

		echo json_encode($data);
	}

	public function ajax_get_value_from_account_saving()
	{
		$no_rekening = $this->input->post('account_saving_no');
		$data = $this->model_transaction->ajax_get_value_from_account_saving($no_rekening);

		echo json_encode($data);
	}

	public function ajax_get_value_from_account_saving2()
	{
		$no_rekening = $this->input->post('account_saving_no');
		$data = $this->model_transaction->ajax_get_value_from_account_saving2($no_rekening);

		echo json_encode($data);
	}

	public function ajax_get_value_from_account_saving_status_3()
	{
		$no_rekening = $this->input->post('account_saving_no');
		$data = $this->model_transaction->ajax_get_value_from_account_saving_status_3($no_rekening);

		echo json_encode($data);
	}

	public function proses_pencairan_tabungan()
	{
	    $cif_no = $this->input->post('cif_no');
	    $cif_type = $this->input->post('cif_type');
	    // $nama = $this->input->post('nama');
	    // $product = $this->input->post('product');
	    // $tanggal_transaksi = $this->input->post('tanggal_transaksi');
	    // $tanggal_transaksi = $this->datepicker_convert(true,$tanggal_transaksi,'/');
	    $no_rekening = $this->input->post('no_rekening');
		// $status_rekening = $this->input->post('status_rekening');
	    $no_rekening_individu = $this->input->post('no_rekening_individu');
	    // $status_rekening_individu = $this->input->post('status_rekening_individu');
	    $pencairan_ke = $this->input->post('pencairan_ke');
	    $saldo_memo = $this->input->post('saldo_memo');
	    $saldo_memo = $this->convert_numeric($saldo_memo);
	    $jumlah_penarikan = $this->input->post('jumlah_penarikan');
	    $jumlah_penarikan = $this->convert_numeric($jumlah_penarikan);

	    $cif = $this->model_transaction->get_saldo_tab_sukarela($cif_no);

	    if($pencairan_ke=="PINBUK"){

			//di cek nomor rekeningnya
			//individu atau kelompok
			if($cif_type=='0'){ // tabungan berencana
				$data_balance = array('tabungan_sukarela'=>$cif['tabungan_sukarela']+$jumlah_penarikan);
				$param_balance = array('cif_no'=>$cif_no);

				$data_saving = array('saldo_memo'=>0,'status_rekening'=>2);
				$param_saving = array('account_saving_no'=>$no_rekening);

				$this->db->trans_begin();
				$this->model_nasabah->update_default_balance($data_balance,$param_balance);
				$this->model_transaction->update_account_saving($data_saving,$param_saving); // update tabungan berencana & tutup buku
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$return = array('success'=>true,'message'=>'Pencairan Tabungan Berencana Berhasil!');
				}else{
					$this->db->trans_rollback();
					$return = array('success'=>false,'message'=>'failed to connect into databases, please contact your administrator!');
				}
			}else if($cif_type=='1'){
				if($no_rekening_individu!=""){ //validate nomor rekening tujuan
					$data_saving = array('saldo_memo'=>0,'status_rekening'=>2);
					$param_saving = array('account_saving_no'=>$no_rekening);
					$data_saving_tujuan = array('saldo_memo'=>$saving['saldo_memo']+$saldo_memo);
					$param_saving_tujuan = array('account_saving_no'=>$no_rekening_individu);
					
					$this->db->trans_begin();
					$this->model_transaction->update_account_saving($data_saving,$param_saving); // update tabungan berencana & tutup buku
					$this->model_transaction->update_account_saving($data_saving_tujuan,$param_saving_tujuan); // update tabungan berencana tujuan
					if($this->db->trans_status()===true){
						$this->db->trans_commit();
						$return = array('success'=>true,'message'=>'Pencairan Tabungan Berencana Berhasil!');
					}else{
						$this->db->trans_rollback();
						$return = array('success'=>false,'message'=>'failed to connect into databases, please contact your administrator!');
					}
				}
			}else{
	    		$return = array('success'=>false,'message'=>'failed to connect into databases, please contact your administrator!');
			}

	    }else if($pencairan_ke=="TUNAI"){
			$data_saving = array('saldo_memo'=>0,'status_rekening'=>2);
			$param_saving = array('account_saving_no'=>$no_rekening);

			$this->db->trans_begin();
			$this->model_transaction->update_account_saving($data_saving,$param_saving); // update tabungan berencana & tutup buku
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true,'message'=>'Pencairan Tabungan Berencana Berhasil!');
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false,'message'=>'failed to connect into databases, please contact your administrator!');
			}
	    }else{
	    	$return = array('success'=>false,'message'=>'failed to connect into databases, please contact your administrator!');
	    }

	    echo json_encode($return);
	}

	public function ajax_get_rekening_tabungan_berencana_tujuan()
	{
		$cif_no = $this->input->post('cif_no');
		$account_saving_no = $this->input->post('cif_no');
		$rekening = $this->model_transaction->get_rekening_tabungan_berencana_tujuan($cif_no,$account_financing_no);
		echo json_encode($rekening);
	}

	public function proses_penarikan_tunai_tabungan()
	{
		$no_rekening			= $this->input->post('no_rekening');
		$saldo_efektif	 		= $this->convert_numeric($this->input->post('saldo_efektif'));
		$jumlah_penarikan 		= $this->convert_numeric($this->input->post('jumlah_penarikan'));
		$no_referensi			= $this->input->post('no_referensi');
		$keterangan				= $this->input->post('keterangan');
		$account_cash_code 		= $this->input->post('account_cash_code');
		$tanggal_transaksi 		= $this->datepicker_convert(true,$this->input->post('tanggal_transaksi'),'/');
		$created_by			  	= $this->session->userdata('user_id');

		$dataaccsaving 			= $this->model_transaction->get_account_saving_by_account_saving_no($no_rekening);

		$data_account_saving 	= array('saldo_memo' => $dataaccsaving['saldo_memo'] - $jumlah_penarikan);
		$param_account_saving   = array('account_saving_no' => $no_rekening);

		$trx_detail_id = uuid(false);

		if ($saldo_efektif>=$jumlah_penarikan)
		{

			$data_trx_account_saving = array(
								'branch_id' 		=> $this->session->userdata('branch_id'),
								'account_saving_no' => $no_rekening,
								'trx_saving_type' 	=> '2',
								'flag_debit_credit' => 'D',
								'trx_date' 			=> $tanggal_transaksi,
								'amount' 			=> $jumlah_penarikan,
								'reference_no' 		=> $no_referensi,
								'description' 		=> $keterangan,
								'created_date' 		=> date('Y-m-d H:i:s'),
								'created_by' 		=> $created_by,
								'account_cash_code' => $account_cash_code,
								'trx_detail_id' 	=> $trx_detail_id
				);

			$data_trx_detail = array(
								'trx_type'			=>'1',
								'trx_account_type' 	=>'2',
								'account_no'		=>$no_rekening,
								// 'account_no_dest'	=>$no_rekening,
								// 'account_type_dest'	=>'2',
								'flag_debit_credit' =>'D',
								'amount' 			=>$jumlah_penarikan,
								'trx_date' 			=>date('Y-m-d'),
								'reference_no' 		=>$no_referensi,
								'description'		=>$keterangan,
								'created_date'		=>date('Y-m-d H:i:s'),
								'created_by' 		=>$created_by,
								'trx_detail_id' 	=> $trx_detail_id			
				);
		
			$this->db->trans_begin();
			if($account_cash_code != ''){
				$this->model_transaction->insert_trx_account_saving_penarikan($data_trx_account_saving);
				$this->model_transaction->insert_trx_detail_penarikan($data_trx_detail);
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$return = array('success'=>0);
				}else{
					$this->db->trans_rollback();
					$return = array('success'=>1);
				}
			} else {
				$return = array('success'=>1,'message'=>'Kas Petugas harus diisi');
			}

		}
		else if ($saldo_efektif<=$jumlah_penarikan) 
		{
			$return = array('success'=>2);
		}
		
		echo json_encode($return);
	}

	public function check_no_referensi()
	{
		$no_referensi = $this->input->post('no_referensi');

		$no_referensi_validation = $this->model_transaction->check_no_referensi($no_referensi);

		if($no_referensi_validation==true){
			$return = array('success'=>true,'message'=>'No Referensi Bisa Dipakai');
		}else{
			$return = array('success'=>false,'message'=>'No Referensi Sudah Ada');
		}

		echo json_encode($return);

	}

	public function datatable_penarikan_tunai_tabungan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'c.cif_no','c.nama','a.account_saving_no','a.amount','a.trx_date','');
				
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
			$sWhere = "AND (";
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
						$sWhere = "AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_transaction->datatable_penarikan_tunai_tabungan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_penarikan_tunai_tabungan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_penarikan_tunai_tabungan(); // get number of all data
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
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['account_saving_no'];
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = $this->format_date_detail($aRow['trx_date'],'id',false,'/');
			$row[] = '<a href="javascript:;" trx_detail_id="'.$aRow['trx_detail_id'].'" nama="'.$aRow['nama'].'" account_saving_no="'.$aRow['account_saving_no'].'" id="link-delete">Delete</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_penarikan_tunai_by_id()
	{
		$trx_account_saving_id = $this->input->post('trx_account_saving_id');
		$data = $this->model_transaction->get_penarikan_tunai_by_id($trx_account_saving_id);

		echo json_encode($data);
	}

	public function update_penarikan_tunai_tabungan()
	{
		$trx_account_saving_id 	= $this->input->post('trx_account_saving_id');
		$trx_detail_id 		    = $this->input->post('trx_detail_id');
		$no_rekening			= $this->input->post('no_rekening');
		$saldo_efektif	 		= $this->convert_numeric($this->input->post('saldo_efektif'));
		//$tanggal_transaksi 		= $this->input->post('tanggal_transaksi');		
		$jumlah_penarikan 		= $this->convert_numeric($this->input->post('jumlah_penarikan'));
		$no_referensi			= $this->input->post('no_referensi');
		$keterangan				= $this->input->post('keterangan');
		$created_by			  	= $this->session->userdata('fullname');

		$dataaccsaving 			= $this->model_transaction->get_account_saving_by_account_saving_no($no_rekening);

		$data_account_saving 	= array('saldo_memo' => $dataaccsaving['saldo_memo'] - $jumlah_penarikan);
		$param_account_saving   = array('account_saving_no' => $no_rekening);

		if ($saldo_efektif>=$jumlah_penarikan)
		{

			$data_trx_account_saving = array(
								'branch_id' 		=> $this->session->userdata('branch_id'),
								'account_saving_no' => $no_rekening,
								'trx_saving_type' 	=> '2',
								'flag_debit_credit' => 'D',
								'trx_date' 			=> date('Y-m-d'),
								'amount' 			=> $jumlah_penarikan,
								'reference_no' 		=> $no_referensi,
								'description' 		=> $keterangan,
								'created_date' 		=> date('Y-m-d H:i:s'),
								'created_by' 		=> $this->session->userdata('fullname')
				);

			$param_trx_account_saving = array('trx_account_saving_id'=>$trx_account_saving_id);

			$data_trx_detail = array(
								'trx_type'			=>'1',
								'trx_account_type' 	=>'2',
								'account_no'		=>$no_rekening,
								// 'account_no_dest'	=>$no_rekening,
								// 'account_type_dest'	=>'2',
								'flag_debit_credit' =>'D',
								'amount' 			=>$jumlah_penarikan,
								'trx_date' 			=>date('Y-m-d'),
								'reference_no' 		=>$no_referensi,
								'description'		=>$keterangan,
								'created_date'		=>date('Y-m-d H:i:s'),
								'created_by' 		=>$created_by,
								'trx_detail_id' 	=> $trx_detail_id				
				);

			$param_trx_detail = array('trx_detail_id'=>$trx_detail_id);
		
			$this->db->trans_begin();
			$this->model_transaction->update_account_saving_penarikan($data_account_saving,$param_account_saving);
			$this->model_transaction->update_trx_account_saving_penarikan($data_trx_account_saving,$param_trx_account_saving);
			$this->model_transaction->update_trx_detail_penarikan($data_trx_detail,$param_trx_detail);

			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>0);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>1);
			}
		}
		else if ($saldo_efektif<=$jumlah_penarikan) 
		{
			$return = array('success'=>2);
		}
		
		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END PENARIKAN TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN SETORAN TUNAI TABUNGAN
	/****************************************************************************************/
	public function setoran_tunai()
	{
		$data['container'] = 'transaction/setoran_tunai';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$branch_code = $this->session->userdata('branch_code');
		$data['account_cash'] = $this->model_transaction->ajax_get_gl_account_cash_by_keyword('',$branch_code,'0');
		$this->load->view('core',$data);
	}

	public function datatable_setor_tunai_tabungan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'c.cif_no','c.nama','a.account_saving_no','a.amount','a.trx_date','');
				
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
			$sWhere = "AND (";
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
						$sWhere = "AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_transaction->datatable_setor_tunai_tabungan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_setor_tunai_tabungan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_setor_tunai_tabungan(); // get number of all data
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
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['account_saving_no'];
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = $this->format_date_detail($aRow['trx_date'],'id',false,'/');
			$row[] = '<a href="javascript:;" trx_detail_id="'.$aRow['trx_detail_id'].'" account_saving_no="'.$aRow['account_saving_no'].'" nama="'.$aRow['nama'].'" id="link-delete">Delete</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	public function datatable_pembukaan_deposito()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'b.cif_no','c.nama','a.account_deposit_no','a.amount','a.trx_date');
				
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}

		$rResult 			= $this->model_transaction->datatable_pembukaan_deposito($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_pembukaan_deposito($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_pembukaan_deposito(); // get number of all data
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
			$row[] = $aRow['trx_date'];
			$row[] = $aRow['account_deposit_no'];
			$row[] = $aRow['nama'];
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	public function datatable_pencairan_deposito()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'b.cif_no','c.nama','a.account_deposit_no','a.amount','a.trx_date');
				
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower(mysql_real_escape_string( $_GET['sSearch'] ))."%' OR ";
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower(mysql_real_escape_string($_GET['sSearch_'.$i]))."%' ";
				}
			}
		}

		$rResult 			= $this->model_transaction->datatable_pencairan_deposito($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_pencairan_deposito($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_pencairan_deposito(); // get number of all data
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
			$row[] = $aRow['trx_date'];
			$row[] = $aRow['account_deposit_no'];
			$row[] = $aRow['nama'];
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function search_cif_by_account_saving()
	{
		$keyword = $this->input->post('keyword');
		$cm_code = $this->input->post('cm_code');
		$branch_code = $this->session->userdata('branch_code');
		$data = $this->model_transaction->account_saving_no_individu($keyword,$cm_code,$branch_code);

		echo json_encode($data);
	}

	public function search_cif_by_account_saving_no()
	{
		$account_saving_no = $this->input->post('account_saving_no');
		$data = $this->model_transaction->search_cif_by_account_saving_no($account_saving_no);

		echo json_encode($data);
	}

	public function add_setoran_tunai()
	{
		$account_saving_no 	= $this->input->post('account_saving_no');
		$amount 			= $this->convert_numeric($this->input->post('jumlah_setoran'));
		$reference_no 		= $this->input->post('no_referensi');
		$description 		= $this->input->post('keterangan');
		$account_cash_code 	= $this->input->post('account_cash_code');
		$trx_date 			= $this->datepicker_convert(true,$this->input->post('tgl_trx'),'/');
		$created_by 		= $this->session->userdata('user_id');
		$branch_id 			= $this->session->userdata('branch_id');
		$nama 				= $this->session->userdata('nama');

		$trx_detail_id = uuid(false);

			//aray untuk input ke table mfi_trx_detail
			$data_trx_detail = array(				
				'trx_detail_id'		=>$trx_detail_id,		
				'trx_type'			=>'1',
				'trx_account_type' 	=>'1',
				'account_no'		=>$account_saving_no,
				'flag_debit_credit' =>'C',
				'amount' 			=>$amount,
				'trx_date' 			=>$trx_date,
				'reference_no' 		=>$reference_no,
				'description' 		=>$description,
				'created_by' 		=>$created_by,
				'created_date' 		=> date('Y-m-d H:i:s')
				// 'account_no_dest' 	=> $account_saving_no,
				// 'account_type_dest' => '1'
				);

			//aray untuk input ke table mfi_trx_account_saving
			$data_trx_account_saving = array(				
				'branch_id'			=>$branch_id ,
				'account_saving_no' =>$account_saving_no,
				'trx_saving_type' 	=>'1',
				'flag_debit_credit' =>'C',
				'trx_date' 			=>$trx_date,
				'amount' 			=>$amount,
				'reference_no' 		=>$reference_no,
				'description' 		=>$description,
				'created_date' 		=> date('Y-m-d H:i:s'),
				'account_cash_code' => $account_cash_code,
				'created_by' 		=>$created_by,
				'trx_detail_id' 	=> $trx_detail_id
				);

			//parameter update
			$dataaccsaving 			= $this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no);
			$data_account_saving 	= array('saldo_memo' => $dataaccsaving['saldo_memo'] + $amount);
			$param_account_saving   = array('account_saving_no' => $account_saving_no);
		

		$this->db->trans_begin();
		if($account_cash_code != ''){
			$this->model_transaction->add_setoran_tunai_account_saving($data_trx_account_saving);
			$this->model_transaction->add_setoran_tunai_detail($data_trx_detail);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
					$account_saving = $account_saving_no;
					$teller 		= $this->session->userdata('branch_code').'.'.$this->session->userdata('user_id');
					$amount 		= 'IDR'.$amount;
					$date_time 		= $trx_date.' '.date('H:i:s');
				$return = array('success'=>true,'account_saving'=>$account_saving,'teller'=>$teller,'amount'=>$amount,'date_time'=>$date_time);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		} else {
			$return = array('success'=>false,'message'=>'Kas Petugas harus diisi');
		}

		echo json_encode($return);
	}

	public function get_setor_tunai_by_id()
	{
		$trx_account_saving_id = $this->input->post('trx_account_saving_id');
		$data = $this->model_transaction->get_setor_tunai_by_id($trx_account_saving_id);

		echo json_encode($data);
	}

	public function edit_setoran_tunai()
	{
		$trx_account_saving_id 	= $this->input->post('trx_account_saving_id');
		$trx_detail_id 		= $this->input->post('trx_detail_id');
		$account_saving_no 	= $this->input->post('account_saving_no');
		$amount 			= $this->convert_numeric($this->input->post('jumlah_setoran'));
		$reference_no 		= $this->input->post('no_referensi');
		$description 		= $this->input->post('keterangan');
		$trx_date 			= $this->datepicker_convert(true,$this->input->post('tgl_trx'),'/');
		$created_by 		= $this->session->userdata('user_id');
		$branch_id 			= $this->session->userdata('branch_id');
		$nama 				= $this->session->userdata('nama');

			//aray untuk input ke table mfi_trx_detail
			$data_trx_detail = array(				
				'trx_type'			=>'1',
				'trx_account_type' 	=>'1',
				'account_no'		=>$account_saving_no,
				'flag_debit_credit' =>'C',
				'amount' 			=>$amount,
				'trx_date' 			=>$trx_date,
				'reference_no' 		=>$reference_no,
				'description' 		=>$description,
				'created_by' 		=>$created_by,
				'created_date' 		=> date('Y-m-d H:i:s')
				// 'account_no_dest' 	=> $account_saving_no,
				// 'account_type_dest' => '1'
				);

			$param_trx_detail = array('trx_detail_id'=>$trx_detail_id);

			//aray untuk input ke table mfi_trx_account_saving
			$data_trx_account_saving = array(				
				'branch_id'			=>$branch_id,
				'account_saving_no' =>$account_saving_no,
				'trx_saving_type' 	=>'1',
				'flag_debit_credit' =>'C',
				'trx_date' 			=>$trx_date,
				'amount' 			=>$amount,
				'reference_no' 		=>$reference_no,
				'description' 		=>$description,
				'created_date' 		=> date('Y-m-d H:i:s'),
				'created_by' 		=>$created_by,
				'trx_detail_id' 	=> $trx_detail_id
				);

			$param_trx_account_saving = array('trx_account_saving_id'=>$trx_account_saving_id);

			//parameter update
			$dataaccsaving 			= $this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no);
			$data_account_saving 	= array('saldo_memo' => $dataaccsaving['saldo_memo'] + $amount);
			$param_account_saving   = array('account_saving_no' => $account_saving_no);
		

		$this->db->trans_begin();
		$this->model_transaction->update_setoran_tunai_trx_account_saving($data_trx_account_saving,$param_trx_account_saving);
		$this->model_transaction->update_setoran_tunai_detail($data_trx_detail,$param_trx_detail);
		$this->model_transaction->update_setoran_tunai_account_saving($data_account_saving,$param_account_saving);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
				$account_saving = $account_saving_no;
				$teller 		= $this->session->userdata('branch_code').'.'.$this->session->userdata('user_id');
				$amount 		= 'IDR'.$amount;
				$date_time 		= $trx_date.' '.date('H:i:s');
			$return = array('success'=>true,'account_saving'=>$account_saving,'teller'=>$teller,'amount'=>$amount,'date_time'=>$date_time);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END SETORAN TUNAI TABUNGAN
	/****************************************************************************************/


	/*****************************************************************************************/
	// PIBUK
	/*****************************************************************************************/

	public function pinbuk()
	{
		$data['container'] = 'transaction/pinbuk';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function get_no_rekening_pinbuk_sumber()
	{
		$keyword = $this->input->post('keyword');
		$no_rekening_tujuan = $this->input->post('no_rekening_tujuan');

		$data = $this->model_transaction->get_no_rekening_pinbuk_sumber($keyword,$no_rekening_tujuan);

		echo json_encode($data);
	}

	public function get_no_rekening_pinbuk_tujuan()
	{
		$keyword = $this->input->post('keyword');
		$no_rekening_sumber = $this->input->post('no_rekening_sumber');

		$data = $this->model_transaction->get_no_rekening_pinbuk_tujuan($keyword,$no_rekening_sumber);

		echo json_encode($data);
	}

	public function process_pinbuk()
	{
		$no_rekening_sumber 		= $this->input->post('no_rekening_sumber');
		$nama_sumber				= $this->input->post('nama_sumber');
		$produk_sumber 				= $this->input->post('produk_sumber');
		$saldo_efektif_sumber 		= $this->convert_numeric($this->input->post('saldo_efektif_sumber'));

		$no_rekening_tujuan 		= $this->input->post('no_rekening_tujuan');
		$nama_tujuan				= $this->input->post('nama_tujuan');
		$produk_tujuan 				= $this->input->post('produk_tujuan');

		$tanggal_efektif_transaksi 	= $this->input->post('tanggal_efektif_transaksi');
		$tanggal_efektif_transaksi = str_replace('/', '', $tanggal_efektif_transaksi);
		$tanggal_efektif_transaksi  = substr($tanggal_efektif_transaksi,4,4).'-'.substr($tanggal_efektif_transaksi,2,2).'-'.substr($tanggal_efektif_transaksi,0,2);
		$jumlah_pinbuk_transaksi 	= $this->convert_numeric($this->input->post('jumlah_pinbuk_transaksi'));
		$no_referensi_transaksi 	= $this->input->post('no_referensi_transaksi');
		$keterangan_transaksi 		= $this->input->post('keterangan_transaksi');

		$dataaccsavingsumber = $this->model_transaction->get_account_saving_by_account_saving_no($no_rekening_sumber);
		$dataaccsavingtujuan = $this->model_transaction->get_account_saving_by_account_saving_no($no_rekening_tujuan);

		$data_account_saving_sumber = array('saldo_memo' => $dataaccsavingsumber['saldo_memo'] - $jumlah_pinbuk_transaksi);
		$param_account_saving_sumber = array('account_saving_no' => $no_rekening_sumber);

		$data_account_saving_tujuan = array('saldo_memo' => $dataaccsavingtujuan['saldo_memo'] + $jumlah_pinbuk_transaksi);
		$param_account_saving_tujuan = array('account_saving_no' => $no_rekening_tujuan);

		$trx_detail_id = uuid(false);

		// DEBIT
		$data_trx_account_saving1 = array(
				'branch_id' => $this->session->userdata('branch_id'),
				'account_saving_no' => $no_rekening_sumber,
				'trx_saving_type' => 3,
				'flag_debit_credit' => 'D',
				'trx_date' => $tanggal_efektif_transaksi,
				'amount' => $jumlah_pinbuk_transaksi,
				'reference_no' => $no_referensi_transaksi,
				'description' => $keterangan_transaksi,
				'created_date' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id'),
				'trx_detail_id' => $trx_detail_id
			);

		// CREDIT
		$data_trx_account_saving2 = array(
				'branch_id' => $this->session->userdata('branch_id'),
				'account_saving_no' => $no_rekening_tujuan,
				'trx_saving_type' => 4,
				'flag_debit_credit' => 'C',
				'trx_date' => $tanggal_efektif_transaksi,
				'amount' => $jumlah_pinbuk_transaksi,
				'reference_no' => $no_referensi_transaksi,
				'description' => $keterangan_transaksi,
				'created_date' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id'),
				'trx_detail_id' => $trx_detail_id
			);

		$data_trx_detail = array(
				'trx_detail_id' => $trx_detail_id,
				'trx_type' => 1,
				'trx_account_type' => 3,
				'account_no' => $no_rekening_sumber,
				'flag_debit_credit' => 'D',
				'amount' => $jumlah_pinbuk_transaksi,
				'trx_date' => $tanggal_efektif_transaksi,
				'reference_no' => $no_referensi_transaksi,
				'description' => $keterangan_transaksi,
				'created_by' => $this->session->userdata('user_id'),
				'created_date' => date('Y-m-d H:i:s'),
				'account_no_dest' => $no_rekening_tujuan,
				'account_type_dest' => 4
			);

		$this->db->trans_begin();

		$this->model_transaction->update_account_saving($data_account_saving_sumber,$param_account_saving_sumber); // DEBIT
		$this->model_transaction->update_account_saving($data_account_saving_tujuan,$param_account_saving_tujuan); // CREDIT

		$this->model_transaction->insert_trx_account_saving($data_trx_account_saving1); // DEBIT
		$this->model_transaction->insert_trx_account_saving($data_trx_account_saving2); // KREDIT

		$this->model_transaction->insert_trx_detail($data_trx_detail);

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);

	}

	public function datatable_pinbuk_tabungan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'a.account_no','a.account_no_dest','a.amount','a.trx_date','');
				
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
			$sWhere = "AND (";
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
						$sWhere = "AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_transaction->datatable_pinbuk_tabungan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_pinbuk_tabungan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_pinbuk_tabungan(); // get number of all data
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
			$row[] = $aRow['no_rek_tabungan_sumber'].'-'.$aRow['nama_tabungan_sumber'];
			$row[] = $aRow['no_rek_tabungan_tujuan'].'-'.$aRow['nama_tabungan_tujuan'];
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = '<div align="center">'.$this->format_date_detail($aRow['trx_date'],'id',false,'/').'</div>';
			$row[] = '<div align="center"><a href="javascript:;" trx_detail_id="'.$aRow['trx_detail_id'].'" no_rek_tabungan_sumber="'.$aRow['no_rek_tabungan_sumber'].'" nama_tabungan_sumber="'.$aRow['nama_tabungan_sumber'].'" id="link-delete" class="btn mini red">Delete</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	/****************************************************************************************/	
	// BEGIN REGISTRASI PENCAIRAN DEPOSITO
	/****************************************************************************************/
	public function search_cif_by_account_deposit()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_transaction->search_cif_by_account_deposit($keyword);

		echo json_encode($data);
	}

	public function search_name_by_account_saving_no()
	{
		$account_saving_no = $this->input->post('account_saving_no');
		$data = $this->model_transaction->search_name_by_account_saving_no($account_saving_no);

		echo json_encode($data);
	}


	public function search_name_by_account_saving_no_klaim()
	{
		$account_saving_no = $this->input->post('account_saving_no');
		$data = $this->model_transaction->search_name_by_account_saving_no($account_saving_no);

		echo json_encode($data);
	}

	public function reg_pencairan_deposito()
	{
		$account_deposit_no = $this->input->post('account_deposit_no');
		$trx_date	 		= date('Y-m-d');
		$created_date	 	= date('Y-m-d H:i:s');
		$account_saving_no  = $this->input->post('account_saving_no');
		$created_by 		= $this->session->userdata('user_id');
		$tanggal_cair 		= $this->datepicker_convert(true,$this->input->post('tanggal_cair'),'/');
		$nominal 			= str_replace(",", "", $this->input->post('nominal'));
		$nama 				= $this->input->post('nama');

			//aray untuk update status rekening deposito
			/*$data_pencairan_deposito = array(				
				'status_rekening'	=>'3'
				);
			$param_pencairan_deposito   = array('account_deposit_no' => $account_deposit_no.'::varchar');*/

			$update_status_deposito = array('status_rekening' => '4');
			$no_rekening = array('account_deposit_no' => $account_deposit_no);


			//aray untuk input ke table mfi_trx_detail
			$data_trx_deposit = array(				
				'account_deposit_no'	=>$account_deposit_no,		
				'trx_deposit_type'		=>'2',
				'trx_date' 				=>$tanggal_cair,
				'amount'				=>$nominal,
				'description'			=>'Pencairan Deposito an. '.$nama,
				'created_by' 			=>$created_by,
				'created_date' 			=>date('Y-m-d'),
				'trx_status' 			=>'0'
				);

			//aray untuk insert ke tabel deposite_break
			$data_deposito_break = array(	
				'account_deposit_no'	=>$account_deposit_no,	
				'account_saving_no'		=>$account_saving_no,	
				'created_by'			=>$created_by,	
				'created_date'			=>$created_date,	
				'status_break'			=>'0',
				'trx_date'          	=>$tanggal_cair
				);

		

		$this->db->trans_begin();

		//$this->model_transaction->update_pencairan_deposito($data_pencairan_deposito,$param_pencairan_deposito); // UPDATE
		$this->model_transaction->insert_deposito_break($data_deposito_break); // INSERT
		$this->model_transaction->add_pembukaan_deposito($data_trx_deposit);
		$this->model_transaction->update_status_deposito($update_status_deposito, $no_rekening);
		
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END REGISTRASI PENCAIRAN DEPOSITO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN TRANSAKSI PEMBUKAAN DEPOSITO
	/****************************************************************************************/

	public function pembukaan_deposito()
	{
		$data['container'] = 'transaction/pembukaan_deposito';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$branch_code = $this->session->userdata('branch_code');
		$data['account_cash'] = $this->model_transaction->ajax_get_gl_account_cash_by_keyword('',$branch_code,'0');
		$this->load->view('core',$data);
	}

	function get_deposito_verified(){
		$keyword = $this->input->post('keyword');
		$branch_code = $this->session->userdata('branch_code');

		$data = $this->model_transaction->get_deposito_verified($keyword,$branch_code);

		echo json_encode($data);
	}

	public function search_cif_by_account_deposit_no()
	{
		$account_deposit_no = $this->input->post('account_deposit_no');

		$data = $this->model_transaction->search_cif_by_account_deposit_no($account_deposit_no);

		echo json_encode($data);
	}

	public function add_pembukaan_deposito()
	{
		$account_deposit_no = $this->input->post('account_deposit_no');
		$nominal 			= $this->convert_numeric($this->input->post('nominal'));
		$nama_ 				= $this->input->post('nama');
		$product_name 		= $this->input->post('product_name');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		$account_cash_code 	= $this->input->post('account_cash_code');
		$tanggal_buka 		= $this->datepicker_convert(true,$this->input->post('tanggal_buka'),'/');
		$created_by 		= $this->session->userdata('user_id');
		$branch_id 			= $this->session->userdata('branch_id');
		$nama 				= $this->session->userdata('nama');

		$trx_detail_id = uuid(false);

		$data_trx_deposit = array(				
			'account_deposit_no'	=>$account_deposit_no,		
			'trx_deposit_type'		=>'0',
			'trx_date' 				=>$tanggal_buka,
			'amount'				=>$nominal,
			'description'			=>'Pembukaan Deposito an. '.$nama_,
			'created_by' 			=>$created_by,
			'created_date' 			=>date('Y-m-d'),
			'trx_status' 			=>'0',
			'account_cash_code' 	=>$account_cash_code
		);

		$this->db->trans_begin();
		if($account_cash_code != ''){
			$this->model_transaction->add_pembukaan_deposito($data_trx_deposit);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		} else {
			$return = array('success'=>false,'message'=>'Kas Petugas harus diisi');
		}

		echo json_encode($return);
	}

	function get_transaksi_by_norek()
	{
		$account_deposit_no = $this->input->post('account_deposit_no');
		$data = $this->model_transaction->get_transaksi_by_norek($account_deposit_no);
		$return = (count($data)>0) ? '1' : '0' ;
		echo $return;		
	}

	/****************************************************************************************/	
	// END TRANSAKSI PEMBUKAAN DEPOSITO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN TRANSAKSI PENCAIRAN DEPOSITO
	/****************************************************************************************/

	public function pencairan_deposito()
	{
		$data['container'] = 'transaction/pencairan_deposito';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$branch_code = $this->session->userdata('branch_code');
		$data['account_cash'] = $this->model_transaction->ajax_get_gl_account_cash_by_keyword('',$branch_code,'0');
		$this->load->view('core',$data);
	}

	function get_pencairan_verified(){
		$keyword = $this->input->post('keyword');
		$branch_code = $this->session->userdata('branch_code');

		$data = $this->model_transaction->get_pencairan_verified($keyword,$branch_code);

		echo json_encode($data);
	}

	function get_pencairan_by_norek()
	{
		$account_deposit_no = $this->input->post('account_deposit_no');
		$data = $this->model_transaction->get_pencairan_by_norek($account_deposit_no);
		$return = (count($data)>0) ? '1' : '0' ;
		echo $return;		
	}

	public function add_pencairan_deposito()
	{
		$account_deposit_no = $this->input->post('account_deposit_no');
		$nominal 			= $this->convert_numeric($this->input->post('nominal'));
		$nama_ 				= $this->input->post('nama');
		$product_name 		= $this->input->post('product_name');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		$account_cash_code 	= $this->input->post('account_cash_code');
		$tanggal_buka 		= $this->datepicker_convert(true,$this->input->post('tanggal_buka'),'/');
		$created_by 		= $this->session->userdata('user_id');
		$branch_id 			= $this->session->userdata('branch_id');
		$nama 				= $this->session->userdata('nama');

		$trx_detail_id = uuid(false);

			//aray untuk input ke table mfi_trx_detail
			$data_trx_deposit = array(				
				'account_deposit_no'	=>$account_deposit_no,		
				'trx_deposit_type'		=>'2',
				'trx_date' 				=>$tanggal_buka,
				'amount'				=>$nominal,
				'description'			=>'Pencairan Deposito an. '.$nama_,
				'created_by' 			=>$created_by,
				'created_date' 			=>date('Y-m-d'),
				'trx_status' 			=>'0'
				);
		

		$this->db->trans_begin();
		if($account_cash_code != ''){
			$this->model_transaction->add_pembukaan_deposito($data_trx_deposit);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		} else {
			$return = array('success'=>false,'message'=>'Kas Petugas harus diisi');
		}

		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END TRANSAKSI PENCAIRAN DEPOSITO
	/****************************************************************************************/

	/*REGISTRASI REKENING PEMBIAYAAN *******************************************************/
	public function datatable_rekening_ver_deposito_setup_new()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('','account_deposit_no','mc.nama','nominal','jangka_waktu','');
		$branch_code = @$_GET['branch_code'];

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
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ') ';
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
						$sWhere = "AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult = $this->model_transaction->datatable_rekening_ver_deposito_setup_new($sWhere,$sOrder,$sLimit,$branch_code);
		$rResultFilterTotal = $this->model_transaction->datatable_rekening_ver_deposito_setup_new($sWhere,'','',$branch_code);
		$iFilteredTotal = count($rResultFilterTotal); 
		$rResultTotal = $this->model_transaction->datatable_rekening_ver_deposito_setup_new('','','',$branch_code);
		$iTotal = count($rResultTotal);	
		
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
			if($aRow['cm_name']!=""){
			   $rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			$row[] = '<input type="checkbox" value="'.$aRow['account_deposit_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_deposit_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = '<div align="right">Rp '.number_format($aRow['nominal'],0,',','.').',-</div>';
			$row[] = $aRow['jangka_waktu']." Bulan";
			$row[] = '<a href="javascript:;" account_deposit_id="'.$aRow['account_deposit_id'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function datatable_rekening_ver_deposito_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('','account_deposit_no','mfi_cif.nama','nominal','jangka_waktu','');
		$cm_code = @$_GET['cm_code'];
				
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
		else
		{
			$sWhere = "where mfi_account_deposit.status_rekening ='0'";
		}

		if($sWhere==""){
			$sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		}else{
			$sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
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

		$rResult 			= $this->model_transaction->datatable_rekening_ver_deposito_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_rekening_ver_deposito_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_rekening_ver_deposito_setup(); // get number of all data
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
			if($aRow['cm_name']!=""){
			   $rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			$row[] = '<input type="checkbox" value="'.$aRow['account_deposit_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_deposit_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = '<div align="right">Rp '.number_format($aRow['nominal'],0,',','.').',-</div>';
			$row[] = $aRow['jangka_waktu']." Bulan";
			$row[] = '<a href="javascript:;" account_deposit_id="'.$aRow['account_deposit_id'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function verifikasi_rekening_deposito()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$approve_by			  = $this->session->userdata('fullname');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>1,
							'approve_by'	 =>$approve_by,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_financing_id'=>$account_financing_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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

	public function in_verifikasi_rekening_deposito()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$approve_by			  = $this->session->userdata('fullname');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>0,
							'approve_by'	 =>$approve_by,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_financing_id'=>$account_financing_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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

	public function verifikasi_rek_deposito()
	{
		$account_deposit_id 		= $this->input->post('account_deposit_id');
		$account_saving_no			= $this->input->post('rek_bagi_hasil');
		$no_rekening				= $this->input->post('no_rekening');
		$nominal 					= $this->input->post('nominal');
		$saldo_memo_account_saving 	= $this->input->post('saldo_memo');
		$approve_by			  		= $this->session->userdata('user_id');
		$saldo_memo 				= $saldo_memo_account_saving-$nominal;
		$trx_detail_id 				= uuid(false);
		$created_by 				= $this->session->userdata('user_id');
		$created_date		  		= date('Y-m-d H:i:s');
		$date_current 				= $this->model_transaction->get_date_current();

		
			$data 				= array(
									'status_rekening'=>3,
									'verify_by'	 	 =>$approve_by,
									'verify_date'	 =>date('Y-m-d H:i:s')
								 );
			$param 				= array('account_deposit_id'=>$account_deposit_id);

			$data2 				= array('saldo_memo'=>$saldo_memo);
			$param2 			= array('account_saving_no'=>$account_saving_no);

			$data_trx_detail 	= array(
									'trx_detail_id'		=>$trx_detail_id,
									'trx_account_type'  =>'0',
									'account_type_dest' =>'3',
									'trx_type' 			=>'2',
									'account_no'		=>$no_rekening,
									'flag_debit_credit'	=>'C',
									'amount'			=>$this->convert_numeric($nominal),
									'trx_date'			=>$date_current,
									'account_no_dest'	=>$account_saving_no,
									'created_by'		=>$created_by,
									'created_date' 		=>$created_date
								  );

			$data_trx_account_deposit = array(
										'account_deposit_no'	=>$no_rekening,
										'trx_deposit_type' 		=>'0',
										'trx_date'				=>$date_current,
										'amount' 				=>$this->convert_numeric($nominal),
										'created_by'			=>$created_by,
										'created_date' 			=>$created_date,
										'trx_detail_id'			=>$trx_detail_id
										);

			$data_trx_account_saving = array(
										'branch_id' 		=> $this->session->userdata('branch_id'),
										'account_saving_no' => $account_saving_no,
										'trx_saving_type' 	=> '3',
										'flag_debit_credit' => 'C',
										'trx_date' 			=> $date_current,
										'amount' 			=> $this->convert_numeric($nominal),
										// 'description' 		=> $keterangan,
										'created_date' 		=> date('Y-m-d H:i:s'),
										'created_by' 		=> $this->session->userdata('user_id'),
										'trx_detail_id' 	=> $trx_detail_id
										);
 		
		$this->db->trans_begin();
		$this->model_transaction->verifikasi_rek_deposito($data,$param);
		/*$this->model_transaction->update_saldo_memo_from_account_saving($data2,$param2);
		$this->model_transaction->insert_mfi_trx_detail($data_trx_detail);
		$this->model_transaction->insert_mfi_trx_account_deposit($data_trx_account_deposit);
		$this->model_transaction->insert_mfi_trx_account_saving($data_trx_account_saving);*/
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	
	public function delete_rek_deposito()
	{
		$account_deposito_id = $this->input->post('account_deposit_id');

		
			$param = array('account_deposit_id'=>$account_deposito_id);
			$this->db->trans_begin();
			$this->model_transaction->delete_rekening_deposito($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}

		echo json_encode($return);
	}
	//END VERIFIKASI REKENING PEMBIAYAAN


	/****************************************************************************************/	
	// BEGIN VERIFIKASI ASURANSI SETUP
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// END VERIFIKASI PENCAIRAN DEPOSITO
	/****************************************************************************************/

	public function datatable_pencairan_deposito_setup_new()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('','mfi_account_deposit.account_deposit_no','mfi_cif.nama','mfi_account_deposit.nominal','mfi_account_deposit.jangka_waktu','');
		$cm_code = @$_GET['cm_code'];
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
		else
		{
			$sWhere = "where mfi_account_deposit_break.status_break = '0'";
		}

		if($sWhere=="" || $cm_code!="00000" ){
			$sWhere = " WHERE mfi_branch.branch_code = '".$cm_code."' ";
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

		$rResult 			= $this->model_transaction->datatable_pencairan_deposito_setup_new($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_pencairan_deposito_setup_new($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_pencairan_deposito_setup_new(); // get number of all data
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
			if($aRow['cm_name']!=""){
			   $rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			$row[] = '<input type="checkbox" value="'.$aRow['account_deposit_break_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_deposit_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = '<div align="right">Rp '.number_format($aRow['nominal'],0,',','.').',-</div>';
			$row[] = $aRow['jangka_waktu'];
			$row[] = '<a href="javascript:;" account_deposit_break_id="'.$aRow['account_deposit_break_id'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function datatable_pencairan_deposito_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('','mfi_account_deposit.account_deposit_no','mfi_cif.nama','mfi_account_deposit.nominal','mfi_account_deposit.jangka_waktu','');
		$cm_code = @$_GET['cm_code'];
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
		else
		{
			$sWhere = "where mfi_account_deposit_break.status_break = '0'";
		}

		if($sWhere==""){
			$sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		}else{
			$sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
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

		$rResult 			= $this->model_transaction->datatable_pencairan_deposito_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_pencairan_deposito_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_pencairan_deposito_setup(); // get number of all data
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
			if($aRow['cm_name']!=""){
			   $rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			$row[] = '<input type="checkbox" value="'.$aRow['account_deposit_break_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_deposit_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = $aRow['nominal'];
			$row[] = $aRow['jangka_waktu'];
			$row[] = '<a href="javascript:;" account_deposit_break_id="'.$aRow['account_deposit_break_id'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function search_cif_by_account_deposit_break_id()
	{
		$account_deposit_break_id = $this->input->post('account_deposit_break_id');
		$data = $this->model_transaction->search_cif_by_account_deposit_break_id($account_deposit_break_id);

		echo json_encode($data);
	}

	public function verifikasi_pencairan_deposito()
	{
		$account_deposit_break_id 	= $this->input->post('account_deposit_break_id');
		$account_deposit_no 		= $this->input->post('account_deposit_no');
		$account_saving_no 			= $this->input->post('account_saving_no');
		$nominal 					= str_replace(".", "", $this->input->post('nominal'));
		$verify_by			  		= $this->session->userdata('user_id');
		$verify_date		  		= date('Y-m-d H:i:s');
		$trx_detail_id 				= uuid(false);
		$current_date 				= $this->current_date();


			//array update deposit
			$data_account_deposit = array(
									'status_rekening'=>'2'
								 );
			$param_account_deposit = array('account_deposit_no'=>$account_deposit_no);

			//array update deposit break
			$data_account_deposit_break = array(
											'status_break'	 =>'1',
											'verify_by'	 	 =>$verify_by,
											'verify_date'	 =>$verify_date
										 );
			$param_account_deposit_break = array('account_deposit_break_id'=>$account_deposit_break_id);

			//array insert mfi_trx_detail
			$data_trx_detail = array(
					'trx_detail_id' => $trx_detail_id,
					'trx_type' => 2,
					'trx_account_type' => 0,
					'account_no' => $account_deposit_no,
					'flag_debit_credit' => 'D',
					'amount' => $nominal,
					'trx_date' => $current_date,
					'account_no_dest' => $account_saving_no,
					'account_type_dest' => 4,
					'created_date' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('user_id'),
					'description' => 'Pencairan Deposito'
				);

			//array insert mfi_trx_account_saving
			$data_trx_account_saving = array(
					'trx_account_saving_id' => uuid(false),
					'branch_id' => $this->session->userdata('branch_id'),
					'account_saving_no' => $account_saving_no,
					'trx_saving_type' => 4,
					'flag_debit_credit' => 'C',
					'trx_date' => $current_date,
					'amount' => $nominal,
					'created_date' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('user_id'),
					'trx_detail_id' => $trx_detail_id
				);

			//array insert mfi_trx_account_deposit
			$data_trx_account_deposit = array(
					'trx_account_deposit_id' => uuid(false),
					'account_deposit_no' => $account_deposit_no,
					'trx_deposit_type' => 0,
					'trx_date' => $current_date,
					'amount' => $nominal,
					'created_date' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('user_id'),
					'trx_detail_id' => $trx_detail_id,
					'trx_status' => '1'
				);

		$this->db->trans_begin();
		$this->model_transaction->insert_trx_detail($data_trx_detail);
		//$this->model_transaction->insert_trx_account_saving($data_trx_account_saving);
		$this->model_transaction->insert_trx_account_deposit($data_trx_account_deposit);
		$this->model_transaction->fn_jurnal_pencairan_deposito($account_deposit_no);
		$this->model_transaction->update_account_deposit($data_account_deposit,$param_account_deposit); //UPDATE TABEL DEPOSIT
		$this->model_transaction->update_account_deposit_break($data_account_deposit_break,$param_account_deposit_break); //UPDATE TABEL DEPOSIT BREAK
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function reject_ver_pencairan_deposito()
	{
		$account_deposit_break_id 	= $this->input->post('account_deposit_break_id');
		$account_deposit_no 		= $this->input->post('account_deposit_no');
		$verify_by			  		= $this->session->userdata('user_id');
		$verify_date		  		= date('Y-m-d H:i:s');

			//array update deposit
			$data_account_deposit = array(
									'status_rekening'=>'1'
								 );
			$param_account_deposit = array('account_deposit_no'=>$account_deposit_no);

			//array update deposit break
			$data_account_deposit_break = array(
											'verify_by'	 	 =>$verify_by,
											'verify_date'	 =>$verify_date
										 );
			$param_account_deposit_break = array('account_deposit_break_id'=>$account_deposit_break_id);

			//array delete deposit break
			$param_account_deposit_break_delete = array('account_deposit_break_id'=>$account_deposit_break_id);

			$param_account_deposit_no = array('account_deposit_no' => $account_deposit_no,
												'trx_deposit_type' => '2');
		
		$this->db->trans_begin();

		$this->model_transaction->update_account_deposit($data_account_deposit,$param_account_deposit); //UPDATE TABEL DEPOSIT

		$this->model_transaction->update_account_deposit_break($data_account_deposit_break,$param_account_deposit_break); //UPDATE TABEL DEPOSIT BREAK
		
		$this->model_transaction->delete_account_deposit_break($param_account_deposit_break_delete); //DELETE

		$this->model_transaction->delete_trx_account_deposit($param_account_deposit_no);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}


	/****************************************************************************************/	
	// END VERIFIKASI PENCAIRAN DEPOSITO
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN VERIFIKASI ASURANSI
	/****************************************************************************************/

	public function datatable_verifikasi_insurance_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_account_insurance.account_insurance_no', 'mfi_cif.nama', 'mfi_product_insurance.product_name','mfi_account_insurance.benefit_value','mfi_account_insurance.premium_value','mfi_account_insurance.status_rekening','');
				
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
		else
		{
			$sWhere = "where mfi_account_insurance.status_rekening ='0'";
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

		$rResult 			= $this->model_transaction->datatable_verifikasi_insurance_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_verifikasi_insurance_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_verifikasi_insurance_setup(); // get number of all data
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
			if($aRow['cm_name']!=""){
			   $rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			$row[] = '<input type="checkbox" value="'.$aRow['account_insurance_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_insurance_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = $aRow['product_name'];
			$row[] = $aRow['benefit_value'];
			$row[] = $aRow['premium_value'];
			$row[] = $aRow['status_rekening'];
			$row[] = '<a href="javascript:;" account_insurance_id="'.$aRow['account_insurance_id'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_account_insurance_by_account_insurance_id_on_verifikasi()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$data = $this->model_transaction->get_account_insurance_by_account_insurance_id_on_verifikasi($account_insurance_id);

		echo json_encode($data);
	}

	public function mencari_nama_pemegang_rekening()
	{
		$pemegang_rekening = $this->input->post('pemegang_rekening');
		$data = $this->model_transaction->mencari_nama_pemegang_rekening($pemegang_rekening);

		echo json_encode($data);
	}

	public function verifikasi_rekening_asuransi()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$user_id			  = $this->session->userdata('user_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_insurance_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>1,
							'approve_by'	 =>$user_id,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_insurance_id'=>$account_insurance_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_asuransi($data,$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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

	public function in_verifikasi_rekening_asuransi()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$user_id			  = $this->session->userdata('user_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>0,
							'approve_by'	 =>$user_id,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_insurance_id'=>$account_insurance_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_asuransi($data,$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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

	public function verifikasi_rek_asuransi()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$account_saving_no 	  = $this->input->post('pemegang_rekening');
		$user_id			  = $this->session->userdata('user_id');

				//variable untuk insert ke mfi_trx_detail
				$trx_detail_id 			= uuid(false);
				$trx_type 				= '1';
				$trx_account_type 		= '3';
				$account_no				= $this->input->post('pemegang_rekening');
				$flag_debit_credit 		= 'D';
				$amount 				= $this->input->post('premium_value');
				$trx_date 				= $this->model_transaction->get_date_current();
				$created_by 			= $user_id;
				$created_date 			= date("Y-m-d H:i:s");
				$account_no_dest		= $this->input->post('account_no2');
				$account_type_dest		= '0';
					//array untuk insert ke mfi_trx_detail
					$mfi_trx_detail = array(
											 'trx_detail_id ' 	=> $trx_detail_id 
											,'trx_summary_id' 	=> NULL
											,'trx_type'			=> $trx_type 	
											,'trx_account_type' => $trx_account_type 
											,'account_no'		=> $account_saving_no	
											,'flag_debit_credit'=> $flag_debit_credit 
											,'amount' 			=> $amount 
											,'trx_date' 		=> $trx_date 	
											,'reference_no' 	=> NULL
											,'description' 		=> NULL
											,'created_by' 		=> $created_by 
											,'created_date' 	=> $created_date 
											,'account_no_dest' 	=> $account_no_dest	
											,'account_type_dest'=> $account_type_dest	
											);

				//variable untuk insert ke  mfi_trx_account_insurance 
				$trx_account_insurance_id 	= uuid(false);
				$account_insurance_no 		= $this->input->post('account_no2');
				$trx_insurance_type 		= '0';
					//array untuk insert ke  mfi_trx_account_insurance //note: beberapa variabel menggunakan variabel yang sudah ada
					$mfi_trx_account_insurance = array(
														 'trx_account_insurance_id' => $trx_account_insurance_id
														,'account_insurance_no'		=> $account_insurance_no	
														,'trx_insurance_type' 		=> $trx_insurance_type 
														,'trx_date' 				=> $trx_date 	
														,'amount' 					=> $amount 
														,'description' 				=> NULL
														,'created_by' 				=> $created_by 
														,'created_date' 			=> $created_date 	
														,'trx_detail_id' 			=> $trx_detail_id 	
													  );

				//variable untuk insert ke  mfi_trx_account_saving 
				$branch_id 				= $this->session->userdata('branch_id');
				$account_saving_no 		= $this->input->post('pemegang_rekening');
				$trx_saving_type	 	= '3';
				$flag_debit_credit_		= 'D';
					//array untuk insert ke  mfi_trx_account_saving //note: beberapa variabel menggunakan variabel yang sudah ada
					$mfi_trx_account_saving = array(
														 'branch_id' 			=> $branch_id
														,'account_saving_no'	=> $account_saving_no 
														,'trx_saving_type'		=> $trx_saving_type
														,'flag_debit_credit'	=> $flag_debit_credit_	
														,'trx_date'				=> $trx_date 
														,'amount'				=> $amount
														,'reference_no'			=> NULL
														,'description'			=> NULL
														,'created_date'			=> $created_date
														,'created_by'			=> $created_by 
														,'trx_detail_id'		=> $trx_detail_id 
													  );
				
				//variable update table  mfi_account_insurance.status_rekening=1, mfi_account_saving.saldo_memo
				//mfi_account_saving.saldo_memo
				$insurance_type	  = $this->input->post('insurance_type');
				$mfi_account_saving_saldo_memo	  = $this->input->post('saldo_memo');			
				$saldo_memo = $this->input->post('update_saldo_memo');
					//mfi_account_saving.saldo_memo
					$update_saldo_memo = array(
											'saldo_memo'=>$saldo_memo
										 );
					$account_saving_no = array('account_saving_no'=>$account_saving_no);
			
					//mfi_account_insurance.status_rekening=1
					$data = array(
									'status_rekening'=>1,
									'verify_by'	 	 =>$user_id,
									'verify_date'	 =>date('Y-m-d H:i:s')
								 );
					$param = array('account_insurance_id'=>$account_insurance_id);
		
		$this->db->trans_begin();
		//insert
		$this->model_transaction->insert_mfi_trx_detail_on_verifikasi_insurance($mfi_trx_detail); //insert mfi_trx_detail
		$this->model_transaction->insert_mfi_trx_account_insurance_on_verifikasi_insurance($mfi_trx_account_insurance); //insert mfi_trx_account_insurance
		$this->model_transaction->insert_mfi_trx_account_saving_on_verifikasi_insurance($mfi_trx_account_saving); //insert mfi_trx_account_saving
		//update
		$this->model_transaction->verifikasi_rek_asuransi($data,$param);//mfi_account_insurance.status_rekening=1
		$this->model_transaction->update_saldo_memo($update_saldo_memo,$account_saving_no); //update saldo_momo
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	
	public function delete_rek_asuransi()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$user_id			  = $this->session->userdata('user_id');

			$data = array(
							'status_rekening'=>1,
							'verify_by'	 	 =>$user_id,
							'verify_date'	 =>date('Y-m-d H:i:s')
						 );

			$param = array('account_insurance_id'=>$account_insurance_id);
			$this->db->trans_begin();

			$this->model_transaction->verifikasi_rek_asuransi($data,$param);
			$this->model_transaction->delete_rekening_asuransi($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END VERIFIKASI ASURANSI
	/****************************************************************************************/

	public function trx_rembug()
	{
		$data['container'] = 'transaction/trx_rembug';
		$data['current_date'] = ($this->session->userdata('trx_date_cm')==true)?$this->session->userdata('trx_date_cm'):$this->format_date_detail($this->current_date(),'id',false,'/');
		$data['fa_name_cm'] = ($this->session->userdata('fa_name_cm')==true)?$this->session->userdata('fa_name_cm'):'';
		$data['fa_code_cm'] = ($this->session->userdata('fa_code_cm')==true)?$this->session->userdata('fa_code_cm'):'';
		$data['account_cash_code_cm'] = ($this->session->userdata('account_cash_code_cm')==true)?$this->session->userdata('account_cash_code_cm'):'';
		$data['branch_code_cm'] = ($this->session->userdata('branch_code_cm')==true)?$this->session->userdata('branch_code_cm'):$this->session->userdata('branch_code');
		$data['branch_name_cm'] = ($this->session->userdata('branch_name_cm')==true)?$this->session->userdata('branch_name_cm'):$this->session->userdata('branch_name');
		$branch=$this->model_transaction->get_branch_id_by_code($data['branch_code_cm']);
		$branch_id=$branch['branch_id'];
		$data['branch_id_cm'] = $branch_id;
		$data['branch_class_cm'] = ($this->session->userdata('branch_class_cm')==true)?$this->session->userdata('branch_class_cm'):$this->session->userdata('branch_class');
		
		$this->load->view('core',$data);
	}

	public function get_trx_rembug_data()
	{
		$cm_code = $this->input->post('cm_code');
		$tanggal = $this->input->post('tanggal');
		$tanggal = str_replace('/', '', $tanggal);
		$tanggal = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
		$account_cash_code = $this->input->post('account_cash_code');
		$rows = $this->model_transaction->get_trx_rembug_data($cm_code,$tanggal);
		$i=0;
		$data['data'] = array();
		$data['mutasi'] = array();
		$data['tab_berencana'] = array();
		foreach($rows as $row)
		{
			$data['data'][$i]['cif_id'] = ($row['cif_id']==null)?0:$row['cif_id'];
			$data['data'][$i]['cm_code'] = ($row['cm_code']==null)?0:$row['cm_code'];
			$data['data'][$i]['cif_no'] = ($row['cif_no']==null)?0:$row['cif_no'];
			$data['data'][$i]['nama'] = ($row['nama']==null)?0:$row['nama'];
			$data['data'][$i]['account_financing_no'] = ($row['account_financing_no']==null)?'':$row['account_financing_no'];
			$data['data'][$i]['tabungan_sukarela'] = ($row['tabungan_sukarela']==null)?0:$row['tabungan_sukarela'];
			$data['data'][$i]['tabungan_wajib'] = ($row['tabungan_wajib']==null)?0:$row['tabungan_wajib'];
			$data['data'][$i]['transaksi_lain'] = ($row['transaksi_lain']==null)?0:$row['transaksi_lain'];
			$data['data'][$i]['tabungan_minggon'] = ($row['tabungan_minggon']==null)?0:$row['tabungan_minggon'];
			$data['data'][$i]['angsuran'] = ($row['angsuran']==null)?0:$row['angsuran'];
			$data['data'][$i]['pokok_pembiayaan'] = ($row['pokok_pembiayaan']==null)?0:$row['pokok_pembiayaan'];
			$data['data'][$i]['margin_pembiayaan'] = ($row['margin_pembiayaan']==null)?0:$row['margin_pembiayaan'];
			$data['data'][$i]['catab_pembiayaan'] = ($row['catab_pembiayaan']==null)?0:$row['catab_pembiayaan'];
			$data['data'][$i]['tabungan_kelompok'] = ($row['tabungan_kelompok']==null)?0:$row['tabungan_kelompok'];
			$data['data'][$i]['jumlah_angsuran'] = ($row['jumlah_angsuran']==null)?0:$row['jumlah_angsuran'];
			$data['data'][$i]['pokok'] = ($row['pokok']==null)?0:$row['pokok'];
			$data['data'][$i]['droping'] = ($row['droping']==null)?0:$row['droping'];
			$data['data'][$i]['angsuran_pokok'] = ($row['angsuran_pokok']==null)?0:$row['angsuran_pokok'];
			$data['data'][$i]['angsuran_margin'] = ($row['angsuran_margin']==null)?0:$row['angsuran_margin'];
			$data['data'][$i]['angsuran_catab'] = ($row['angsuran_catab']==null)?0:$row['angsuran_catab'];
			$data['data'][$i]['angsuran_tab_wajib'] = ($row['angsuran_tab_wajib']==null)?0:$row['angsuran_tab_wajib'];
			$data['data'][$i]['angsuran_tab_kelompok'] = ($row['angsuran_tab_kelompok']==null)?0:$row['angsuran_tab_kelompok'];
			$data['data'][$i]['adm'] = ($row['adm']==null)?0:$row['adm'];
			$data['data'][$i]['asuransi'] = ($row['asuransi']==null)?0:$row['asuransi'];
			$data['data'][$i]['setoran_berencana'] = ($row['setoran_berencana']==null)?0:$row['setoran_berencana'];
			$data['data'][$i]['setoran_lwk'] = ($row['setoran_lwk']==null)?0:$row['setoran_lwk'];
			$data['data'][$i]['setoran_mingguan'] = ($row['setoran_mingguan']==null)?0:$row['setoran_mingguan'];
			$data['data'][$i]['margin'] = ($row['margin']==null)?0:$row['margin'];
			$data['data'][$i]['saldo_pokok'] = ($row['saldo_pokok']==null)?0:$row['saldo_pokok'];
			$data['data'][$i]['saldo_margin'] = ($row['saldo_margin']==null)?0:$row['saldo_margin'];
			$data['data'][$i]['saldo_catab'] = ($row['saldo_catab']==null)?0:$row['saldo_catab'];
			$data['data'][$i]['jangka_waktu'] = ($row['jangka_waktu']==null)?0:$row['jangka_waktu'];
			$data['data'][$i]['periode_jangka_waktu'] = ($row['periode_jangka_waktu']==null)?0:$row['periode_jangka_waktu'];
			$data['data'][$i]['counter_angsuran'] = ($row['counter_angsuran']==null)?0:$row['counter_angsuran'];
			$data['data'][$i]['status'] = $row['status'];
			$data['data'][$i]['status_droping'] = $row['status_droping'];
			$data['data'][$i]['tanggal_akad'] = $row['tanggal_akad'];
			$data['data'][$i]['tanggal'] = $tanggal;
			// $data['tab_berencana'][$i] = $this->model_transaction->get_tabungan_berencana_by_cif_no2($row['cif_no'],$row['account_financing_no']);
			$data['tab_berencana'][$i] = $this->model_transaction->get_tabungan_berencana_by_cif_no($row['cif_no']);
			$mutasi = $this->model_transaction->get_mutasi_by_cif_no($row['cif_no'],$tanggal);
			$data['mutasi'][$i]['account_financing_no'] = (count($mutasi)>0)?$mutasi['account_financing_no']:'';
			$data['mutasi'][$i]['jangka_waktu'] = (count($mutasi)>0)?$mutasi['jangka_waktu']:'';
			$data['mutasi'][$i]['periode_jangka_waktu'] = (count($mutasi)>0)?$mutasi['periode_jangka_waktu']:'';
			$data['mutasi'][$i]['counter_angsuran'] = (count($mutasi)>0)?$mutasi['counter_angsuran']:'';
			$data['mutasi'][$i]['freq_sisa_angsuran'] = (count($mutasi)>0)?$mutasi['freq_sisa_angsuran']:0;
			$data['mutasi'][$i]['angsuran_pokok'] = (count($mutasi)>0)?$mutasi['angsuran_pokok']:0;
			$data['mutasi'][$i]['angsuran_margin'] = (count($mutasi)>0)?$mutasi['angsuran_margin']:0;
			$data['mutasi'][$i]['saldo_pembiayaan_pokok'] = (count($mutasi)>0)?$mutasi['saldo_pembiayaan_pokok']:0;
			$data['mutasi'][$i]['saldo_pembiayaan_margin'] = (count($mutasi)>0)?$mutasi['saldo_pembiayaan_margin']:0;
			$data['mutasi'][$i]['saldo_pembiayaan_catab'] = (count($mutasi)>0)?$mutasi['saldo_pembiayaan_catab']:0;
			$data['mutasi'][$i]['saldo_tab_wajib'] = (count($mutasi)>0)?$mutasi['saldo_tab_wajib']:0;
			$data['mutasi'][$i]['saldo_tab_kelompok'] = (count($mutasi)>0)?$mutasi['saldo_tab_kelompok']:0;
			$data['mutasi'][$i]['saldo_tab_sukarela'] = (count($mutasi)>0)?$mutasi['saldo_tab_sukarela']:0;
			$data['mutasi'][$i]['saldo_tab_berencana'] = (count($mutasi)>0)?$mutasi['saldo_tab_berencana']:0;
			$data['mutasi'][$i]['saldo_individu'] = (count($mutasi)>0)?$mutasi['saldo_individu']:0;
			$data['mutasi'][$i]['flag_saldo_margin'] = (count($mutasi)>0)?$mutasi['flag_saldo_margin']:0;
			$data['mutasi'][$i]['setoran_tambahan'] = (count($mutasi)>0)?$mutasi['setoran_tambahan']:0;
			$data['mutasi'][$i]['penarikan_tabungan_sukarela'] = (count($mutasi)>0)?$mutasi['penarikan_tabungan_sukarela']:0;
			$data['mutasi'][$i]['potongan_pembiayaan'] = (count($mutasi)>0)?$mutasi['potongan_pembiayaan']:0;
			$data['mutasi'][$i]['bonus_bagihasil'] = (count($mutasi)>0)?$mutasi['bonus_bagihasil']:0;
			$data['mutasi'][$i]['infaq'] = (count($mutasi)>0)?$mutasi['infaq']:0;
			$data['mutasi'][$i]['saldo_deposito'] = (count($mutasi)>0)?$mutasi['saldo_deposito']:0;
			$data['mutasi'][$i]['saldo_cadangan_resiko'] = (count($mutasi)>0)?$mutasi['saldo_cadangan_resiko']:0;
			$data['mutasi'][$i]['saldo_simpanan_pokok'] = (count($mutasi)>0)?$mutasi['saldo_simpanan_pokok']:0;
			$data['mutasi'][$i]['saldo_smk'] = (count($mutasi)>0)?$mutasi['saldo_smk']:0;
			$data['mutasi'][$i]['saldo_tab_minggon'] = (count($mutasi)>0)?$mutasi['saldo_tab_minggon']:0;
			$data['mutasi'][$i]['saldo_lwk'] = (count($mutasi)>0)?$mutasi['saldo_lwk']:0;
			$data['mutasi'][$i]['saldo_simpanan_wajib'] = (count($mutasi)>0)?$mutasi['saldo_simpanan_wajib']:0;
			$i++;
		}
		$data['kas_awal'] = $this->model_transaction->fn_get_saldoawal_kaspetugas($account_cash_code,$tanggal,1); // 1 = mencari kas awal
		echo json_encode($data);
	}

	public function process_trx_rembug_save()
	{
		set_time_limit(0);
		// echo "<pre>";
		// print_r($_POST);
		// die();
		$branch_name 					= $this->input->post('branch_name');
		$branch_code 					= $this->input->post('branch_code');
		$branch_class 					= $this->input->post('branch_class');
		$branch_id 						= $this->input->post('branch_id');
		$cm_code 						= $this->input->post('cm_code');
		$fa_code 						= $this->input->post('fa_code');
		$fa_name 						= $this->input->post('fa_name');
		$account_cash_code 				= $this->input->post('account_cash_code');
		$trx_date 						= $this->input->post('tanggal2');
		$trx_date 						= str_replace('/', '', $trx_date);
		$trx_date 						= substr($trx_date,4,4).'-'.substr($trx_date,2,2).'-'.substr($trx_date,0,2);
		$cif_no 						= $this->input->post('cif_no');
		$account_financing_no 			= $this->input->post('account_financing_no');
		$absen 							= $this->input->post('absen');
		$frekuensi1 					= $this->input->post('freq');
		$setoran_tab_sukarela 			= $this->convert_numeric($this->input->post('setoran_tabungan_sukarela'));
		$setoran_lwk					= $this->convert_numeric($this->input->post('setoran_lwk'));
		$setoran_mingguan 				= $this->convert_numeric($this->input->post('setoran_mingguan'));
		$penarikan_tab_sukarela 		= $this->convert_numeric($this->input->post('penarikan_tabungan_sukarela'));
		$status_angsuran_margin 		= $this->input->post('status_angsuran_margin');
		$status_angsuran_catab 			= $this->input->post('status_angsuran_catab');
		$status_angsuran_tab_wajib 		= $this->input->post('status_angsuran_tab_wajib');
		$status_angsuran_tab_kelompok 	= $this->input->post('status_angsuran_tab_kelompok');
		$account_saving_no 				= $this->input->post('detail_berencana_account_no');
		$amount 						= $this->input->post('detail_berencana_setoran');
		$frekuensi2 					= $this->input->post('detail_berencana_freq');
		$infaq 							= $this->convert_numeric($this->input->post('infaq_kelompok'));
		$kas_awal 						= $this->convert_numeric($this->input->post('kas_awal'));
		$vtrx_cm_save_id				= $this->input->post('trx_cm_save_id');
	    $muqosha 						= $this->input->post('muqosha');
	    $keterangan 					= $this->input->post('keterangan');

	    $trx_rembug_is_exist = $this->model_transaction->get_trx_rembug_is_exist($trx_date,$cm_code);
	    $trx_rembug_is_exist=0;
	    if($trx_rembug_is_exist>0)
	    {
			$return = array('success'=>false,'message'=>'Transaksi Dibatalkan. Dikarnakan Double Transaksi.');
	    }
	    else
	    {
			// delete table trx_cm_save apabila sudah ada di database
			if($vtrx_cm_save_id!="")
			{
				$this->delete_trx_cm_save($vtrx_cm_save_id,$cm_code);
			}
			$trx_cm_save_id 				= uuid(false);
			$data_trx_cm_save_berencana 	= array();
			$data_trx_cm_save_detail 		= array();
			$data_trx_cm_save 				= array(
												'trx_cm_save_id' 		=> $trx_cm_save_id
												,'infaq' 				=> $infaq
												,'kas_awal' 			=> $kas_awal
												,'branch_id' 			=> $branch_id
												,'cm_code' 				=> $cm_code
												,'fa_code' 				=> $fa_code
												,'account_cash_code' 	=> $account_cash_code
												,'trx_date' 			=> $trx_date
												,'created_date' 		=> date('Y-m-d')
											  );

			for ( $i = 0 ; $i < count($cif_no) ; $i++ )
			{

				$trx_cm_save_detail_id 				= uuid(false);

				$data_trx_cm_save_detail[] 			= array(
						 'cif_no' 						=> $cif_no[$i]
						,'trx_cm_save_detail_id' 		=> $trx_cm_save_detail_id
						,'trx_cm_save_id' 				=> $trx_cm_save_id
						,'account_financing_no' 		=> $account_financing_no[$i]
						,'absen' 						=> $absen[$i]
						,'frekuensi' 					=> $frekuensi1[$i]
						,'setoran_tab_sukarela' 		=> $setoran_tab_sukarela[$i]
						,'setoran_lwk' 					=> $setoran_lwk[$i]
						,'setoran_mingguan' 			=> $setoran_mingguan[$i]
						,'penarikan_tab_sukarela' 		=> $penarikan_tab_sukarela[$i]
						,'status_angsuran_margin' 		=> $status_angsuran_margin[$i]
						,'status_angsuran_catab' 		=> $status_angsuran_catab[$i]
						,'status_angsuran_tab_wajib' 	=> $status_angsuran_tab_wajib[$i]
						,'status_angsuran_tab_kelompok' => $status_angsuran_tab_kelompok[$i]
						,'muqosha' 						=> $muqosha[$i]
						,'keterangan' 					=> $keterangan[$i]
					);

				if(isset($account_saving_no[$i]))
				{
					for ( $j = 0 ; $j < count($account_saving_no[$i]) ; $j++ )
					{

						$data_trx_cm_save_berencana[] 		= array(
								 'trx_cm_save_berencana_id' => uuid(false)
								,'trx_cm_save_detail_id' 	=> $trx_cm_save_detail_id
								,'account_saving_no' 		=> $account_saving_no[$i][$j]
								,'amount' 					=> $this->convert_numeric($amount[$i][$j])
								,'frekuensi' 				=> $frekuensi2[$i][$j]
							);
					}
				}

			}
			
			/*
			echo "<pre>";
			print_r($data_trx_cm_save);
			print_r($data_trx_cm_save_detail);
			print_r($data_trx_cm_save_berencana);
			die();
			*/

			$this->db->trans_begin();

			if ( count ( $data_trx_cm_save ) > 0 ) {
				$this->model_transaction->insert_trx_cm_save($data_trx_cm_save);
			}

			if ( count ( $data_trx_cm_save_detail ) > 0 ) {
				$this->model_transaction->insert_trx_cm_save_detail($data_trx_cm_save_detail);
			}

			if ( count ( $data_trx_cm_save_berencana ) > 0 ) {
				$this->model_transaction->insert_trx_cm_save_berencana($data_trx_cm_save_berencana);
			}


			if ( $this->db->trans_status() === true )
			{
				$this->db->trans_commit();
				$return = array('success'=>true,'message'=>'Transaksi Berhasil !');
				$this->session->set_userdata('trx_date_cm',$this->input->post('tanggal2'));
				$this->session->set_userdata('fa_name_cm',$fa_name);
				$this->session->set_userdata('fa_code_cm',$fa_code);
				$this->session->set_userdata('account_cash_code_cm',$account_cash_code);
				$this->session->set_userdata('branch_name_cm',$branch_name);
				$this->session->set_userdata('branch_code_cm',$branch_code);
				$this->session->set_userdata('branch_class_cm',$branch_class);
				$this->session->set_userdata('barnch_id_cm',$branch_id);

			}
			else
			{
				$this->db->trans_rollback();
				$return = array('success'=>false,'message'=>'Transaksi Gagal! Silahkan Hubungi Administrator untuk masalah ini.');
			}
		}

		echo json_encode($return);


	}

	function process_trx_rembug(){
		$fa_code 								= $this->input->post('fa_code');
	    $account_cash_code 						= $this->input->post('account_cash_code');
	    $cm_code 								= $this->input->post('cm_code');
	    $branch_code 							= $this->input->post('branch_code');
	    $branch_id 								= $this->input->post('branch_id');
	    $tanggal 								= $this->input->post('tanggal2');
	    $cif_no 								= $this->input->post('cif_no');
	    $account_financing_no 					= $this->input->post('account_financing_no');
	    $absen 									= $this->input->post('absen');
	    $angsuran_pokok 						= $this->input->post('angsuran_pokok');
	    $angsuran_margin 						= $this->input->post('angsuran_margin');
	    $angsuran_catab 						= $this->input->post('angsuran_catab');
	    $angsuran_tab_wajib 					= $this->input->post('angsuran_tab_wajib');
	    $angsuran_tab_kelompok 					= $this->input->post('angsuran_tab_kelompok');
	    $balance_angsuran 						= $this->input->post('balance_angsuran');
	    $balance_tabungan_wajib 				= $this->input->post('balance_tabungan_wajib');
	    $balance_tabungan_minggon 				= $this->input->post('balance_tabungan_minggon');
	    $balance_tabungan_sukarela 				= $this->input->post('balance_tabungan_sukarela');
	    $balance_transaksi_lain 				= $this->input->post('balance_transaksi_lain');
	    $balance_pokok_pembiayaan 				= $this->input->post('balance_pokok_pembiayaan');
	    $balance_margin_pembiayaan 				= $this->input->post('balance_margin_pembiayaan');
	    $balance_catab_pembiayaan 				= $this->input->post('balance_catab_pembiayaan');
	    $balance_tabungan_kelompok 				= $this->input->post('balance_tabungan_kelompok');
	    $freq 									= $this->input->post('freq');
	    $jumlah_angsuran 						= $this->input->post('jumlah_angsuran');
	    $setoran_tabungan_sukarela 				= $this->input->post('setoran_tabungan_sukarela');
	    $penarikan_tabungan_sukarela 			= $this->input->post('penarikan_tabungan_sukarela');
	    $realisasi_plafon 						= $this->input->post('realisasi_plafon');
	    $realisasi_adm 							= $this->input->post('realisasi_adm');
	    $droping 								= $this->input->post('droping');
	    $realisasi_asuransi 					= $this->input->post('realisasi_asuransi');
	    $realisasi_margin 						= $this->input->post('realisasi_margin');
	    $total_angsuran 						= $this->input->post('total_angsuran');
	    $total_setoran_tab_sukarela 			= $this->input->post('total_setoran_tab_sukarela');
	    $total_infaq 							= $this->input->post('total_infaq');
	    $total_penarikan_tab_sukarela 			= $this->input->post('total_penarikan_tab_sukarela');
	    $total_realisasi_plafon 				= $this->input->post('total_realisasi_plafon');
	    $total_realisasi_adm 					= $this->input->post('total_realisasi_adm');
	    $total_realisasi_asuransi 				= $this->input->post('total_realisasi_asuransi');
	    $kas_awal 								= $this->input->post('kas_awal');
	    $infaq_kelompok 						= $this->input->post('infaq_kelompok');
	    $setoran 								= $this->input->post('setoran');
	    $penarikan 								= $this->input->post('penarikan');
	    $saldo_kas 								= $this->input->post('saldo_kas');
	    $setoran_tab_berencana 					= $this->input->post('setoran_tab_berencana');
	    $detail_berencana_account_no 			= $this->input->post('detail_berencana_account_no');
	    $detail_berencana_product_code 			= $this->input->post('detail_berencana_product_code');
	    $detail_berencana_setoran 				= $this->input->post('detail_berencana_setoran');
	    $detail_berencana_freq 					= $this->input->post('detail_berencana_freq');
	    $setoran_tab_berencana_product_code 	= $this->input->post('setoran_tab_berencana_product_code');
	    $setoran_lwk 							= $this->input->post('setoran_lwk');
	    $setoran_mingguan 						= $this->input->post('setoran_mingguan');
	    $setoran_minggon 						= $this->input->post('setoran_minggon');
	    $trx_cm_save_id 						= $this->input->post('trx_cm_save_id');
	    $muqosha 								= $this->input->post('muqosha');
	    $keterangan 							= $this->input->post('keterangan');
	    $detail_berencana_biaya_administrasi 	= $this->input->post('detail_berencana_biaya_administrasi');
	    $biaya_administrasi_tab_berencana 		= $this->input->post('biaya_administrasi_tab_berencana');
	    $saldo_tab_wajib 						= $this->input->post('saldo_tab_wajib');
	    $saldo_tab_kelompok 					= $this->input->post('saldo_tab_kelompok');
	    $bonus_bagihasil 						= $this->input->post('bonus_bagihasil');

		$validate_double_transaction=true;
		$debug=false;
		$success=0;
		$failed=0;
		if($validate_double_transaction==false){
			$return = array('success'=>false,'message'=>'Transaksi Dibatalkan. Dikarnakan Double Transaksi.');
		}else{
			/* 
			| INSERT DATA HISTORY TRANSAKSI
			|-----------------------------------
			| BEGIN
			*/
			$this->db->trans_strict(TRUE);
			$this->db->trans_begin();

			/* set ID mfi_trx_cm */
			$trx_cm_id = uuid(false);

			/* 
			| hitung total untuk mfi_trx_cm 
			| BEGIN 
			*/
			$total_droping = 0;
			$total_angsuran_tab_wajib = 0;
			$total_angsuran_tab_kelompok = 0;
			$total_angsuran_pokok = 0;
			$total_angsuran_margin = 0;
			$total_angsuran_catab = 0;
			$total_minggon = 0;

			for ( $x = 0 ; $x < count($cif_no) ; $x++ )
			{
				$total_minggon+=$this->convert_numeric($setoran_minggon[$x]);
				$total_droping+=$this->convert_numeric($droping[$x]);
				$total_angsuran_tab_wajib+=$this->convert_numeric($angsuran_tab_wajib[$x]);
				$total_angsuran_tab_kelompok+=$this->convert_numeric($angsuran_tab_kelompok[$x]);
				$total_angsuran_pokok+=$this->convert_numeric($angsuran_pokok[$x])*$freq[$x];
				$total_angsuran_margin+=$this->convert_numeric($angsuran_margin[$x]);
				$total_angsuran_catab+=$this->convert_numeric($angsuran_catab[$x]);
			}
			/* 
			| END
			*/

			/* 
			| INSERTING DATA INTO mfi_trx_cm
			| BEGIN
			*/
			$data_cm = array(
				'trx_cm_id' => $trx_cm_id
				,'cm_code' => $cm_code
				,'trx_date' => $tanggal
				,'droping' => $total_droping
				,'tab_wajib_cr' => $total_angsuran_tab_wajib
				,'tab_sukarela_cr' => $this->convert_numeric($total_setoran_tab_sukarela)
				,'transaksi_lain_cr' => $total_minggon
				,'trx_status' => 1
				,'tab_sukarela_db' => $this->convert_numeric($total_penarikan_tab_sukarela)
				,'fa_code' => $fa_code
				,'created_by' => $this->session->userdata('user_id')
				,'created_date' => date("Y-m-d H:i:s")
				,'angsuran_pokok' => $total_angsuran_pokok
				,'angsuran_margin' => $total_angsuran_margin
				,'angsuran_catab' => $total_angsuran_catab
				,'infaq_kelompok' => $this->convert_numeric($infaq_kelompok)
			);
			$this->model_transaction->insert_trx_cm($data_cm);
			/* 
			| END 
			*/

			/* 
			| INSERTING DATA LOG HISTORY TRX_REMBUG
			| BEGIN
			*/

			$data_log_trx = array(
				'trx_cm_id' => $trx_cm_id,
				'created_date' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id')
			);

			$this->model_transaction->insert_trx_log_trx_rembug($data_log_trx);

			$batch_trx_cm_detail_id = array();

			for ( $y=0; $y<count($cif_no); $y++ )
			{
				/* DECLARE ARRAY VARIABLE */
				$data_cm_detail = array();
				$data_cm_detail_droping = array();
				$data_savingplan = array();
				$data_savingplan_account = array();

				/* set ID for each mfi_trx_cm_detail */
				$trx_cm_detail_id = uuid(false);

				/* set ID for each mfi_trx_cm_detail_savingplan */
				$trx_cm_detail_saving_plan_id = uuid(false);

				/* inserting ID of mfi_trx_cm_detail into BATCH data */
				$batch_trx_cm_detail_id[$y] = $trx_cm_detail_id;

				/*getting angsuran ke*/


				/*
				| INSERTING DATA INTO mfi_trx_cm_detail
				| BEGIN
				*/
				$data_cm_detail = array(
					'trx_cm_id' => $trx_cm_id
					,'trx_cm_detail_id' => $trx_cm_detail_id
					,'cif_no' => $cif_no[$y]
					,'angsuran_pokok' => $this->convert_numeric($angsuran_pokok[$y])
					,'angsuran_margin' => $this->convert_numeric($angsuran_margin[$y])
					,'angsuran_catab' => $this->convert_numeric($angsuran_catab[$y])
					,'tab_wajib_cr' => $this->convert_numeric($angsuran_tab_wajib[$y])
					,'tab_kelompok_cr' => $this->convert_numeric($angsuran_tab_kelompok[$y])
					,'tab_sukarela_cr' => $this->convert_numeric($setoran_tabungan_sukarela[$y])
					,'tab_sukarela_db' => $this->convert_numeric($penarikan_tabungan_sukarela[$y])
					,'minggon' => $this->convert_numeric($setoran_minggon[$y])
					,'absen' => $absen[$y]
					,'freq' => $freq[$y]
					,'keterangan' => $keterangan[$y]
					,'account_financing_no' => $account_financing_no[$y]
				);

				/* kalo ada angsuran */
				if ($freq[$y]>0) {
					
					// cek kalo punya pembiayaan
					if ($account_financing_no[$y]!="") {

						$angs = $this->model_transaction->get_counter_angsuran($account_financing_no[$y]);
						$angsuran_ke = $angs+$freq[$y];
						$data_cm_detail['angsuran_ke'] = $angsuran_ke;
						
					}

				}

				$this->model_transaction->insert_trx_cm_detail($data_cm_detail);
				/*
				| END
				*/

				/*
				| INSERTING DATA LWK AND SETORAN MINGGUAN INTO mfi_trx_cm_lwk
				| @Condition : if $setoran_lwk is not 0 or $setoran_mingguan is not 0
				| BEGIN
				*/
				if($this->convert_numeric($setoran_lwk[$y]) > 0){
					$data_cm_lwk = array(
						'trx_cm_detail_id' => $trx_cm_detail_id,
						'cif_no' => $cif_no[$y],
						'setoran_lwk' => $this->convert_numeric($setoran_lwk[$y])
					);

					$data_delete_lwk = array('cif_no' => $cif_no[$y]);

					$this->model_transaction->delete_trx_cm_lwk($data_delete_lwk);
					$this->model_transaction->insert_trx_cm_lwk($data_cm_lwk);
				}
				/*
				| END
				*/

				/*
				| UPDATE NOMINAL SETORAN MINGGUAN ke tabel mfi_tunggakan_mingguan
				| @Condition : Cek terlebih dahulu ke tabel tunggakan
				| BEGIN
				*/
				if($this->convert_numeric($setoran_mingguan[$y]) > 0){
					$cek_tunggakan_mingguan = $this->model_transaction->cek_tunggakan_mingguan($cif_no[$y]);
					$total = $cek_tunggakan_mingguan['total'];

					if($total > 0){
						$cek_tunggakan = $this->model_transaction->cek_tunggakan($cif_no[$y]);
						$count_tunggakan = count($cek_tunggakan);

						$institution = $this->model_cif->get_institution();
						$nominal = $institution['minggon'];

						$setoran_mg = $nominal;

						if($count_tunggakan > 0){
							for($tg = 0; $tg < $count_tunggakan; $tg++){
								if($setoran_mg > 0){
									$amount = $cek_tunggakan[$tg]['amount'];

									$param_tunggakan = array('trx_date' => $cek_tunggakan[$tg]['trx_date']);

									$this->model_transaction->delete_tunggakan($param_tunggakan);

									$setoran_mg -= $amount;
								}
							}
						}
					}

					$data_cm_wajib = array(
						'trx_cm_detail_id' => $trx_cm_detail_id,
						'cif_no' => $cif_no[$y],
						'setoran_mingguan' => $this->convert_numeric($setoran_mingguan[$y])
					);
					$this->model_transaction->insert_trx_cm_wajib($data_cm_wajib);
				} else {
					$cek_tunggakan_mingguan_by_tanggal = $this->model_transaction->cek_tunggakan_mingguan_by_tanggal($cif_no[$y],$tanggal);
					$jumlah = $cek_tunggakan_mingguan_by_tanggal['jumlah'];

					if($jumlah == '0'){
						$institution = $this->model_cif->get_institution();
						$nominal = $institution['minggon'];

						$data_tunggakan = array(
							'cif_no' => $cif_no[$y],
							'trx_date' => $tanggal,
							'amount' => $nominal
						);

						$this->model_transaction->insert_tunggakan($data_tunggakan);
					}
				}
				/*
				| END
				*/

				/*
				| INSERTING DATA DROPING INTO mfi_trx_cm_detail_droping
				| BEGIN
				*/
				if ( $this->convert_numeric($droping[$y]) > 0 ) {
					$data_cm_detail_droping = array(
						'trx_cm_detail_id' => $trx_cm_detail_id,
						'cif_no' => $cif_no[$y],
						'droping' => $this->convert_numeric($droping[$y]),
						'administrasi' => $this->convert_numeric($realisasi_adm[$y]),
						'margin' => $this->convert_numeric($realisasi_margin[$y]),
						'asuransi' => $this->convert_numeric($realisasi_asuransi[$y])
					);
					$this->model_transaction->insert_trx_cm_detail_droping($data_cm_detail_droping);
					
					/* UPDATE STATUS WAKALAH
					$update_wakalah = array('status_wakalah' => '1');
					$param_wakalah = array('account_financing_no' => $account_financing_no[$y]);
					$this->model_transaction->update_mfi_account_financing_wakalah($update_wakalah,$param_wakalah);

					/* UPDATE TANGGAL AKAD JIKA MURABAHAH
					$get_akad_code = $this->model_transaction->get_akad_code($account_financing_no[$y]);
					$code_akad = $get_akad_code['akad_code'];
					if($code_akad == '310'){
						$data_tanggal_akad_droping = array('tanggal_akad' => $tanggal);
						$param_tanggal_akad_droping = array('account_financing_no' => $account_financing_no[$y]);
						$this->model_transaction->update_mfi_account_financing($data_tanggal_akad_droping,$param_tanggal_akad_droping);
					}
					*/
				}
				/*
				| END
				*/

				/*
				| INSERTING DATA TAB.RENCANA INTO mfi_trx_cm_detail_savingplan & mfi_trx_cm_detail_savingplan_account
				| @Condition : if $setoran_tab_berencana is not 0
				| BEGIN
				*/
				if($this->convert_numeric($setoran_tab_berencana[$y])>0){
					
					/* insert into mfi_trx_cm_detail_savingplan */
					$data_savingplan = array(
						'trx_cm_detail_savingplan_id' => $trx_cm_detail_saving_plan_id,
						'trx_cm_detail_id' => $trx_cm_detail_id,
						'cif_no' => $cif_no[$y],
						'amount' => $this->convert_numeric($setoran_tab_berencana[$y])-$this->convert_numeric($biaya_administrasi_tab_berencana[$y]),
						'biaya_administrasi' => $this->convert_numeric($biaya_administrasi_tab_berencana[$y])
					);
					$this->model_transaction->insert_trx_cm_detail_savingplan($data_savingplan);

					/* insert into mfi_trx_cm_detail_savingplan_account */
					for ( $z = 0 ; $z < count(@$detail_berencana_product_code[$y]) ; $z++ ) // record nya berdasarkan kode produk
					{
						$data_savingplan_account[] = array(
							'trx_cm_detail_savingplan_account_id' => uuid(false),
							'trx_cm_detail_savingplan_id' => $trx_cm_detail_saving_plan_id,
							'account_saving_no' => $detail_berencana_account_no[$y][$z],
							'product_code' => (isset($detail_berencana_product_code[$y][$z])?$detail_berencana_product_code[$y][$z]:null),
							'amount' => $this->convert_numeric($detail_berencana_setoran[$y][$z]),
							'biaya_administrasi' => $detail_berencana_biaya_administrasi[$y][$z],
							'flag_debet_credit' => 'C',
							'freq' => (isset($detail_berencana_freq[$y][$z])?$detail_berencana_freq[$y][$z]:0)
						);
					}
					$this->model_transaction->insert_trx_cm_detail_savingplan_account($data_savingplan_account);
				}
				/*
				| END
				*/

				/*
				| INSERTING DATA PELUNASAN
				| BEGIN
				*/

				// $get_financing = $this->model_transaction->get_account_financing_by_cif_no($cif_no[$y]);
				$get_financing = $this->model_transaction->get_account_financing_by_account_financing_no_baru($account_financing_no[$y],$cif_no[$y]);

				if(count($get_financing)>0)
				{
					$v_saldo_pokok = $get_financing['saldo_pokok']-($freq[$y]*$this->convert_numeric($angsuran_pokok[$y]));
					if($v_saldo_pokok==0){
						$v_saldo_margin = 0;
					}else{
						$v_saldo_margin = $get_financing['saldo_margin']-($freq[$y]*$this->convert_numeric($angsuran_margin[$y]));
					}

					$v_saldo_catab = $get_financing['saldo_catab']+($freq[$y]*$this->convert_numeric($angsuran_catab[$y]));
					$saldo_syarat_lunas = $v_saldo_pokok+$v_saldo_margin;

					if($saldo_syarat_lunas==0){
						$v_status_rekening = 2;
					}else{
						$v_status_rekening = $get_financing['status_rekening'];
					}

					if($v_status_rekening==2)
					{
						$data_financing_lunas = array(
								'account_financing_no'	=>$get_financing['account_financing_no'],
								'saldo_pokok' 			=>$get_financing['saldo_pokok'],
								'saldo_margin' 			=>$get_financing['saldo_margin'],
								'saldo_catab' 			=>$get_financing['saldo_catab'],
								'potongan_margin' 		=>$muqosha[$y],
								'status_pelunasan'		=>'1',
								'create_by' 			=>$this->session->userdata('user_id'),
								'created_date'			=>date("Y-m-d H:i:s"),
								'tanggal_lunas'			=>$tanggal,
								'trx_cm_detail_id'      =>$trx_cm_detail_id
							);

						$data_del_financing_lunas = array('account_financing_no' => $get_financing['account_financing_no']);

						$data_trx_sukarela=array();
						if($v_saldo_catab>0){
							$data_trx_sukarela[] = array(
								'cif_no'=>$cif_no[$y]
								,'account_financing_no'=>$get_financing['account_financing_no']
								,'trx_date'=>$tanggal
								,'amount'=>$v_saldo_catab
								,'trx_type'=>5
								,'flag_debet_credit'=>'C'
								,'trx_source_id'=>$trx_cm_detail_id
								,'created_stamp'=>date('Y-m-d H:i:s')
								,'created_by'=>$this->session->userdata('user_id')
							);

							$data_del_trx_lunas_pinbuk_catab = array('cif_no'=>$cif_no[$y], 'account_financing_no'=>$get_financing['account_financing_no'] ); 
						}

						$this->model_transaction->proses_del_pelunasan_pembayaran($data_del_financing_lunas);
						$this->model_nasabah->proses_reg_pelunasan_pembayaran($data_financing_lunas);
						if(count($data_trx_sukarela)>0){
							$this->model_transaction->proses_del_pinbuk_catab($data_del_trx_lunas_pinbuk_catab); 
							$this->model_transaction->insert_batch_trx_sukarela($data_trx_sukarela);
						}
					}
				}
				/*
				| INSERTING DATA PELUNASAN
				| END
				*/

				$cif = $this->model_cif->get_cif_by_cif_no($cif_no[$y]);
				if($cif['status']==3){
					$savingplan_id=uuid(false);
					/*inserting history pendebetan tab.berencana*/
					$savingplan_master = $this->model_transaction->get_data_pendebetan_tab_berencana($cif_no[$y]);
					if(count($savingplan_master)>0)
					{
						if ( $savingplan_master['amount'] > 0 ) {
							$raw_savingplan = array(
								'trx_cm_detail_savingplan_id'=>$savingplan_id,
								'trx_cm_detail_id'=>$trx_cm_detail_id,
								'cif_no'=>$cif_no[$y],
								'amount'=>$savingplan_master['amount']
							);
						
							$this->model_transaction->insert_trx_cm_detail_savingplan($raw_savingplan);

							/*inserting history pendebetan tab.berencana detail*/
							$raw_savingplan_account=array();
							$savingplan_detail = $this->model_transaction->get_data_pendebetan_tab_berencana_detail($cif_no[$y]);
							foreach($savingplan_detail as $savingplandetail){
								$raw_savingplan_account[] = array(
									'trx_cm_detail_savingplan_account_id'=>uuid(false),
									'trx_cm_detail_savingplan_id'=>$savingplan_id,
									'product_code'=>$savingplandetail['product_code'],
									'amount'=>$savingplandetail['amount'],
									'flag_debet_credit'=>'D',
									'freq'=>1
								);
							}
							$this->model_transaction->insert_trx_cm_detail_savingplan_account($raw_savingplan_account);
						}
					}

					$savingplanmaster_individu = $this->model_transaction->get_data_pendebetan_tab_individu($cif_no[$y]);

					if(count($savingplanmaster_individu) > 0){
						// INSERT mfi_trx_detail
						$trx_detail_id_keluar = uuid(FALSE);
						$trx_detail_keluar = array(
							'trx_detail_id' => $trx_detail_id_keluar,
							'trx_type' => '1',
							'trx_account_type' => '3',
							'account_no' => $savingplanmaster_individu['account_saving_no'],
							'flag_debit_credit' => 'D',
							'amount' => $savingplanmaster_individu['saldo_memo'],
							'trx_date' => $tanggal,
							'reference_no' => $savingplanmaster_individu['cif_no'],
							'description' => 'ANGGOTA KELUAR',
							'created_by' => $this->session->userdata('user_id'),
							'created_date' => date('Y-m-d H:i:s')
						);

						// INSERT mfi_trx_accunt_saving
						$trx_saving_keluar = array(
							'branch_id' => $branch_id,
							'account_saving_no' => $savingplanmaster_individu['account_saving_no'],
							'trx_saving_type' => '3',
							'flag_debit_credit' => 'D',
							'trx_date' => $tanggal,
							'amount' => $savingplanmaster_individu['saldo_memo'],
							'reference_no' => $savingplanmaster_individu['cif_no'],
							'description' => 'ANGGOTA KELUAR',
							'created_date' => date('Y-m-d H:i:s'),
							'created_by' => $this->session->userdata('user_id'),
							'trx_detail_id' => $trx_detail_id_keluar,
							'verify_by' => $this->session->userdata('user_id'),
							'verify_date' => date('Y-m-d H:i:s'),
							'trx_status' => '1'
						);

						$this->model_transaction->insert_trx_detail($trx_detail_keluar);
						$this->model_transaction->insert_trx_account_saving($trx_saving_keluar);
					}
				}

			} // END LOOP CIF

			/* Deleting TRX Save */
			$this->delete_trx_cm_save($trx_cm_save_id,$cm_code);

			/*
			| INSERT DATA HISTORY TRANSAKSI
			|-----------------------------------
			| END
			*/

			/*
			| PROCESSING JURNAL TRX REMBUG
			*/
			$this->model_transaction->fn_create_jurnal_rembug($trx_cm_id);

			// if($this->db->trans_status()===TRUE){
			// 	$this->db->trans_commit();
			// }else{
			// 	$this->db->trans_rollback();
			// }

			/*
			| INSERT DATA TRANSAKSI KAS PETUGAS
			| Penarikan dan Penerimaan
			|---------------------------------------
			| BEGIN
			*/
			// $this->db->trans_begin();

			/* Declare */
			$cm = $this->model_transaction->get_cm_data_by_code($cm_code);

			/* Inserting data setoran */
			$trx_gl_cash_id1 = uuid(false);
			$TKP_total_setoran = $this->convert_numeric($setoran)+$this->convert_numeric($infaq_kelompok);
			$TKP_penerimaan=array();
			if($TKP_total_setoran>0)
			{
				$TKP_penerimaan = array(
					'trx_gl_cash_id'		=> $trx_gl_cash_id1
					,'trx_date'				=> $tanggal
					,'account_cash_code'	=> $account_cash_code
					,'trx_gl_cash_type'		=> 2
					,'flag_debet_credit'	=> 'D'
					,'account_teller_code'	=> $account_cash_code
					,'voucher_date'			=> $tanggal
					,'voucher_ref'			=> $cm_code
					,'description'			=> 'PENERIMAAN REMBUG '.$cm['cm_name'].' ('.$cm_code.')'
					,'created_by'			=> $this->session->userdata('username')
					,'created_date'			=> date('Y-m-d')
					,'amount'				=> $TKP_total_setoran
					,'status' 				=> 1
					,'trx_cm_id' 			=> $trx_cm_id
				);
				
				$this->model_transaction->insert_trx_gl_cash($TKP_penerimaan);
			}

			/* inserting data penarikan */
			$trx_gl_cash_id2 = uuid(false);
			$TKP_total_penarikan=$this->convert_numeric($penarikan);
			$TKP_penarikan=array();
			if($TKP_total_penarikan>0)
			{
				$TKP_penarikan = array(
					'trx_gl_cash_id'		=> $trx_gl_cash_id2
					,'trx_date'				=> $tanggal
					,'account_cash_code'	=> $account_cash_code
					,'trx_gl_cash_type'		=> 3
					,'flag_debet_credit'	=> 'C'
					,'account_teller_code'	=> $account_cash_code
					,'voucher_date'			=> $tanggal
					,'voucher_ref'			=> $cm_code
					,'description'			=> 'PENARIKAN REMBUG '.$cm['cm_name'].' ('.$cm_code.')'
					,'created_by'			=> $this->session->userdata('username')
					,'created_date'			=> date('Y-m-d')
					,'amount'				=> $TKP_total_penarikan
					,'status' 				=> 1
					,'trx_cm_id' 			=> $trx_cm_id
				);
				
				$this->model_transaction->insert_trx_gl_cash($TKP_penarikan);

			}

			/* INSERTING DATA INTO mfi_trx_gl_cash_detail */
			$TKP_detail[] = array(
				'trx_gl_cash_id' => $trx_gl_cash_id1
				,'cm_code' => $cm_code
				,'amount_setoran' => $this->convert_numeric($setoran)
				,'amount_penarikan' => 0
			);
			$TKP_detail[] = array(
				'trx_gl_cash_id' => $trx_gl_cash_id2
				,'cm_code' => $cm_code
				,'amount_setoran' => 0
				,'amount_penarikan' => $this->convert_numeric($penarikan)
			);

			$this->model_transaction->insert_trx_gl_cash_detail($TKP_detail); // insert batch
			
			/*
			| INSERT DATA TRANSAKSI KAS PETUGAS
			| Penarikan dan Penerimaan
			|---------------------------------------
			| END
			*/

			/*
			| UPDATE DATA REKENING PEMBIAYAAN & TAB.BERENCANA
			|---------------------------------------------------
			| BEGIN
			*/

			for( $i=0; $i<count($cif_no); $i++ ){

				$cif = $this->model_cif->get_cif_by_cif_no($cif_no[$i]);
				
				/*
				| UPDATE SALDO TAB.BERENCANA
				| BEGIN
				*/
				if(isset($detail_berencana_account_no[$i])){

					for ( $j = 0 ; $j < count($detail_berencana_account_no[$i]) ; $j++ ){

						$record_saving = $this->model_transaction->get_account_saving_by_account_saving_no($detail_berencana_account_no[$i][$j]);
						if(count($record_saving)>0){

							$param_saving = array('account_saving_no' => $detail_berencana_account_no[$i][$j]);
							$data_saving = array(
								'saldo_memo' => $record_saving['saldo_memo']+($this->convert_numeric($detail_berencana_setoran[$i][$j])*$detail_berencana_freq[$i][$j]),
								'saldo_riil' => $record_saving['saldo_riil']+($this->convert_numeric($detail_berencana_setoran[$i][$j])*$detail_berencana_freq[$i][$j]),
								'counter_angsruan' => $record_saving['counter_angsruan']+$detail_berencana_freq[$i][$j]
							);
							$this->model_transaction->update_account_saving($data_saving,$param_saving);
						}

						if($detail_berencana_freq[$i][$j] == '1' and $detail_berencana_product_code[$i][$j] == '0099'){
							$param_saving_dtk = array('account_saving_no' => $detail_berencana_account_no[$i][$j]);
							$data_saving_dtk = array(
								'rencana_setoran' => '0',
								'counter_angsruan' => '0'
							);
							$this->model_transaction->update_account_saving($data_saving_dtk,$param_saving_dtk);
						}

					}

				}
				/*
				| END
				*/

				/*
				| UPDATE TAB.BALANCE
				| BEGIN
				*/
				if ($setoran_lwk[$i]>0){

					$data_balance = array(
					'pokok_pembiayaan' 		=> ($this->convert_numeric($balance_pokok_pembiayaan[$i])-($freq[$i]*$this->convert_numeric($angsuran_pokok[$i])))
					,'margin_pembiayaan' 	=> ($this->convert_numeric($balance_margin_pembiayaan[$i])-($freq[$i]*$this->convert_numeric($angsuran_margin[$i])))
					,'catab_pembiayaan' 	=> ($this->convert_numeric($balance_catab_pembiayaan[$i])+($freq[$i]*$this->convert_numeric($angsuran_catab[$i])))
					,'tabungan_wajib' 		=> ($this->convert_numeric($balance_tabungan_wajib[$i])+($freq[$i]*$this->convert_numeric($angsuran_tab_wajib[$i])))
					,'tabungan_kelompok'	=> ($this->convert_numeric($balance_tabungan_kelompok[$i])+($freq[$i]*$this->convert_numeric($angsuran_tab_kelompok[$i])))
					,'transaksi_lain' 		=> ($this->convert_numeric($balance_transaksi_lain[$i])+$this->convert_numeric($setoran_minggon[$i]))
					,'tabungan_minggon' 	=> ($this->convert_numeric($balance_tabungan_minggon[$i])+$this->convert_numeric($setoran_mingguan[$i]))
					,'setoran_lwk' 			=> ($this->convert_numeric($setoran_lwk[$i]))
					);
				}
				else {
					$data_balance = array(
					'pokok_pembiayaan' 		=> ($this->convert_numeric($balance_pokok_pembiayaan[$i])-($freq[$i]*$this->convert_numeric($angsuran_pokok[$i])))
					,'margin_pembiayaan' 	=> ($this->convert_numeric($balance_margin_pembiayaan[$i])-($freq[$i]*$this->convert_numeric($angsuran_margin[$i])))
					,'catab_pembiayaan' 	=> ($this->convert_numeric($balance_catab_pembiayaan[$i])+($freq[$i]*$this->convert_numeric($angsuran_catab[$i])))
					,'tabungan_wajib' 		=> ($this->convert_numeric($balance_tabungan_wajib[$i])+($freq[$i]*$this->convert_numeric($angsuran_tab_wajib[$i])))
					,'tabungan_kelompok'	=> ($this->convert_numeric($balance_tabungan_kelompok[$i])+($freq[$i]*$this->convert_numeric($angsuran_tab_kelompok[$i])))
					,'transaksi_lain' 		=> ($this->convert_numeric($balance_transaksi_lain[$i])+$this->convert_numeric($setoran_minggon[$i]))
					,'tabungan_minggon' 	=> ($this->convert_numeric($balance_tabungan_minggon[$i])+$this->convert_numeric($setoran_mingguan[$i]))
					);					
				}

				/*
				| END
				*/

				/*
				| UPDATE REK.PEMBIAYAAN
				| BEGIN
				*/
				// $get_financing = $this->model_transaction->get_account_financing_by_cif_no($cif_no[$i]);
				$get_financing = $this->model_transaction->get_account_financing_by_account_financing_no_baru($account_financing_no[$i],$cif_no[$i]);
				if( count($get_financing) > 0 ){

					/*
					| SET JATUH TEMPO ANGSURAN NEXT
					| BEGIN
					*/
					$jtempo_angsuran_last 	= $get_financing['jtempo_angsuran_next'];
					$jtempo_angsuran_next 	= null;
					$periode_jangka_waktu 	= $get_financing['periode_jangka_waktu'];
					$tanggal_jtempo 		= $get_financing['tanggal_jtempo'];
					
					if($periode_jangka_waktu==0){
						$freq_jtempo = $freq[$i]*1;
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_last.' +'.$freq_jtempo.' days'));
					}else if($periode_jangka_waktu==1){
						$freq_jtempo = $freq[$i]*7;
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_last.' +'.$freq_jtempo.' days'));
					}else if($periode_jangka_waktu==2){
						$freq_jtempo = $freq[$i]*1;
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_last.' +'.$freq_jtempo.' month'));
					}else if($periode_jangka_waktu==3){
						$jtempo_angsuran_next = $tanggal_jtempo;
					}

					$iJto = 1;
					do {
						$cekHariLibur = $this->model_transaction->cekHariLibur($jtempo_angsuran_next);
						// var_dump($cekHariLibur);
						if ($cekHariLibur==true) {
							if($periode_jangka_waktu==0){
								$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +1 days'));
							}else if($periode_jangka_waktu==1){
								$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +1 weeks'));
							}else if($periode_jangka_waktu==2){
								$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +1 month'));
							}else if($periode_jangka_waktu==3){
								$jtempo_angsuran_next = $tanggal_jtempo;
							}
							$iJto++;
						} else {
							break;
						}
					} while ($iJto > 1);
					// die();

					/*
					| END;
					*/

					/* set data untuk tanggal angsuran selanjutnya */
					$data_financing['jtempo_angsuran_last'] = $jtempo_angsuran_last;
					$data_financing['jtempo_angsuran_next'] = $jtempo_angsuran_next;

					$data_financing['saldo_pokok'] = $get_financing['saldo_pokok']-($freq[$i]*$this->convert_numeric($angsuran_pokok[$i]));
					if($data_financing['saldo_pokok']==0){
						$data_financing['saldo_margin'] = $get_financing['saldo_margin']-$get_financing['saldo_margin'];
					}else{
						$data_financing['saldo_margin'] = $get_financing['saldo_margin']-($freq[$i]*$this->convert_numeric($angsuran_margin[$i]));
					}

					$data_financing['saldo_catab'] = $get_financing['saldo_catab']+($freq[$i]*$this->convert_numeric($angsuran_catab[$i]));
					$saldo_syarat_lunas = $data_financing['saldo_pokok']+$data_financing['saldo_margin'];

					if($saldo_syarat_lunas==0){
						$data_financing['status_rekening'] = 2;
					}else{
						$data_financing['status_rekening'] = $get_financing['status_rekening'];
					}

					/* mengaktifkan rek.pembiayaan pada saat transaksi pertama ( setoran lwk )*/
					if($get_financing['status_rekening'] == 0) {
						$data_financing['status_rekening'] = 1;
					}

					// jika pelunasan (status_rekening = 2) 
					// saldo catab di mutasi ke tabungan sukarela
					// ------------------------------------------------------
					// status_rekening : 0=baru registrasi 1=aktif 2=lunas 3=verified
					// ------------------------------------------------------
					if($data_financing['status_rekening'] == 2 || $data_financing['status_rekening'] == 4){

						// data balance
						$data_balance['tabungan_sukarela'] = $cif['tabungan_sukarela']+$this->convert_numeric($setoran_tabungan_sukarela[$i])-$this->convert_numeric($penarikan_tabungan_sukarela[$i])+$data_financing['saldo_catab'];
						$data_balance['catab_pembiayaan'] = 0;
						
						// data financing/pembiayaan
						$data_financing['saldo_catab'] = 0;
						$data_financing['tanggal_lunas'] = $tanggal;

					} else {
						
						$data_balance['tabungan_sukarela'] = ($this->convert_numeric($balance_tabungan_sukarela[$i])+$this->convert_numeric($setoran_tabungan_sukarela[$i])-$this->convert_numeric($penarikan_tabungan_sukarela[$i]));

					}

					/* update counter_angsuran */
					if ( ( $jumlah_angsuran[$i]*$freq[$i] ) > 0 ) {
						$data_financing['counter_angsuran'] = ((int)$get_financing['counter_angsuran'])+$freq[$i];
					}else{
						$data_financing['counter_angsuran'] = ((int)$get_financing['counter_angsuran']);
					}

					$param_financing = array(
						'account_financing_no' => $account_financing_no[$i]
					);

					$this->model_transaction->update_account_financing($data_financing,$param_financing);

					/*
					| FINANCING DROPING
					| BEGIN
					*/
					$get_financing_droping = $this->model_transaction->get_account_financing_droping($get_financing['account_financing_no']);
					if($get_financing_droping['status_droping']=='0' && $realisasi_plafon[$i]!='0'){
						// update ke financing droping (ketika pencairan)
						$data_financing_droping 	= array(
							'status_droping'=>1,
							'droping_by'	=>$this->session->userdata('user_id'),
							'droping_date'	=>$tanggal);
						$param_financing_droping 	= array('account_financing_no'=>$account_financing_no[$i]);

						$this->model_transaction->update_account_financing_droping($data_financing_droping,$param_financing_droping);

						// update default balance (ketika pencairan)
						$data_balance['account_financing_no'] = $account_financing_no[$i];
						$data_balance['pokok_pembiayaan'] = $this->convert_numeric($realisasi_plafon[$i]);
						$data_balance['margin_pembiayaan'] = $this->convert_numeric($realisasi_margin[$i]);

					}
					/*
					| END
					*/

				}else{

					$data_balance['tabungan_sukarela'] = ($this->convert_numeric($balance_tabungan_sukarela[$i])+$this->convert_numeric($setoran_tabungan_sukarela[$i])-$this->convert_numeric($penarikan_tabungan_sukarela[$i]));

				}
				/*
				| END
				*/

				if($cif['status']==3){
					$tab_wajib_kelompok = $saldo_tab_wajib[$i]+$saldo_tab_kelompok[$i]+$bonus_bagihasil[$i];
					$data_balance['tabungan_sukarela'] = $data_balance['tabungan_sukarela']+$tab_wajib_kelompok;
				}

				$param_balance = array('cif_no'=>$cif_no[$i]);
				$this->model_transaction->update_account_default_balance($data_balance,$param_balance);
				/*
				| ANGGOTA MASUK
				| BEGIN
				*/
				if($cif['status']=='0'){
					$data_cif = array('status'=>1);
					$param_cif = array('cif_no'=>$cif_no[$i]);
					$this->model_cif->update_cif($data_cif,$param_cif);
				}
				/*
				| END
				*/

				/*
				| ANGGOTA KELUAR
				| BEGIN
				*/
				if($cif['status']==3){

					// ak = anggota keluar
					// default balance
					$ak_data_balance = array('tabungan_wajib'=>0
											,'tabungan_kelompok'=>0
											,'tabungan_minggon'=>0
											,'cadangan_resiko'=>0
											,'simpanan_pokok'=>0
											,'smk'=>0
										);
					$ak_param_balance 			= array('cif_no'=>$cif_no[$i]);
					
					//financing
					$ak_data_financing 			= array('status_rekening'=>2);
					$ak_param_financing 		= array('cif_no'=>$cif_no[$i],'status_rekening'=>4);
					//saving
					$ak_data_saving 			= array('saldo_memo'=>0,'status_rekening'=>2);
					$ak_param_saving 			= array('cif_no'=>$cif_no[$i],'status_rekening'=>4);
					//deposito
					$ak_data_deposito 			= array('nominal'=>0,'status_rekening'=>2);
					$ak_param_deposito 			= array('cif_no'=>$cif_no[$i],'status_rekening'=>4);

					$this->model_transaction->update_account_default_balance($ak_data_balance,$ak_param_balance);
					$this->model_transaction->update_account_financing($ak_data_financing,$ak_param_financing);
					$this->model_transaction->update_account_saving($ak_data_saving,$ak_param_saving);
					$this->model_transaction->update_account_deposit($ak_data_deposito,$ak_param_deposito);

					$data_cif = array('status'=>2,'tanggal_keluar'=>$tanggal);
					$param_cif = array('cif_no'=>$cif_no[$i]);
					$this->model_cif->update_cif($data_cif,$param_cif);
				}
				/*
				| END
				*/

			}

			$data_update_log_trx = array('end_date' => date('Y-m-d H:i:s'));
			$param_update_log_trx = array('trx_cm_id' => $trx_cm_id);
			$this->model_transaction->update_log_trx_rembug($data_update_log_trx,$param_update_log_trx);

			if($this->db->trans_status()===TRUE){
				$this->db->trans_commit();
				$success++;
				$return = array('success'=>true,'message'=>'Transaksi Berhasil !','num'=>$success);
			}else{
				$this->db->trans_rollback();
				$failed++;
				$return = array('success'=>false,'message'=>'Transaksi Gagal! Silahkan Hubungi Administrator untuk masalah ini.','num'=>$failed);
			}

			/*
			| END DATABASE TRANSACTION
			*/		


		}

		echo json_encode($return);
	}

	/**
	* JURNAL UMUM REV
	* Rabu, 20 Agustus 2014
	* @author sayyid nurkilah
	*/
	public function jurnal_umum_rev()
	{
		$data['container'] = 'transaction/jurnal_umum_rev';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/**
	* GRID TABLE JURNAL UMUM REV
	* Rabu, 20 Agustus 2014
	* @author sayyid nurkilah
	*/
	public function get_jurnal_umum_rev()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'code';
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$from_date = isset($_REQUEST['from_date'])?$_REQUEST['from_date']:'';
		$thru_date = isset($_REQUEST['thru_date'])?$_REQUEST['thru_date']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_transaction->get_jurnal_umum_rev('','','','',$from_date,$thru_date);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_transaction->get_jurnal_umum_rev($sidx,$sort,$limit_rows,$start,$from_date,$thru_date);
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['id'] = $row['trx_gl_id'];
			$responce['rows'][$i]['cell'] = array(
				$row['trx_gl_id']
				,date('d/m/Y',strtotime(substr($row['trx_date'],0,10)))
				,date('d/m/Y',strtotime(substr($row['voucher_date'],0,10)))
				,$row['voucher_ref']
				,$row['description']
				,$row['total_debit']
				,$row['total_credit']
				,$row['fullname']
			);
			$i++;
		}

		echo json_encode($responce);
	}
	/**
	* GET JURNAL UMUM DETAIL
	* Rabu, 20 Agustus 2014
	* @author sayyid nurkilah
	*/
	public function get_jurnal_umum_rev_detail()
	{
		$trx_gl_id=$this->input->post('trx_gl_id');
		$data=$this->model_transaction->get_trx_gl_detail($trx_gl_id);
		echo json_encode($data);
	}
	/**
	* PROSES SAVE UPDATE TRANSAKSI JURNAL UMUM
	* Rabu, 20 Agustus 2014
	* @author sayyid nurkilah
	*/
	public function update_transaksi_jurnal()
	{
		// echo "<pre>";
		// print_r($_POST);

		$branch_code 		= $this->input->post('branch_code');
		$no_referensi 		= $this->input->post('no_referensi2');
		$deskripsi 			= $this->input->post('deskripsi2');
		$tanggal 			= $this->input->post('tanggal2');
		$tanggal 			= str_replace('/', '', $tanggal);
		$tanggal 			= substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);

		$gl_account_id 		= $this->input->post('gl_account_id');
		$account_code 		= $this->input->post('account_code');
		$credit 			= $this->convert_numeric($this->input->post('credit'));
		$debet 				= $this->convert_numeric($this->input->post('debet'));
		$description 		= $this->input->post('description');

		$account_group_code = $this->input->post('account_group_code');
		$account_type 		= $this->input->post('account_type');

		$trx_gl_id 			= $this->input->post('trx_gl_id');

		$data_trx_gl = array(
				// 'trx_gl_id' => $trx_gl_id,
				'trx_date' 	=> $tanggal,
				'voucher_date' => $tanggal,
				'voucher_ref' => $no_referensi,
				'branch_code' => $branch_code,
				'created_by' => $this->session->userdata('user_id'),
				// 'jurnal_trx_type' => 0,
				'description' => $deskripsi
				// 'created_date' => date('Y-m-d H:i:s')
			);
		$param_trx_gl = array('trx_gl_id'=>$trx_gl_id);

		$data_trx_gl_detail = array();
		for ( $i = 0 ; $i < count($gl_account_id) ; $i++ )
		{
			/** 1. mendapatkan flag D/C. Default = X 
			 * 	2. mencari amount
			 */
			$flag_debit_credit = 'X';
			$amount = 0;
			if ( $credit[$i] > $debet[$i] ) {
				$flag_debit_credit = 'C';
				$amount = $credit[$i];
			}
			else if ( $credit[$i] < $debet[$i] ) {
				$flag_debit_credit = 'D';
				$amount = $debet[$i];
			}
			

			$data_trx_gl_detail[] = array(
					'trx_gl_id' => $trx_gl_id,
					'account_code' => $account_code[$i],
					'flag_debit_credit' => $flag_debit_credit,
					'amount' => $amount,
					'description' => $description[$i],
					'trx_sequence' => $i
				);
		}

		$this->db->trans_begin();
		$this->model_transaction->update_trx_gl($data_trx_gl,$param_trx_gl);
		$this->model_transaction->delete_trx_gl_detail($param_trx_gl);
		$this->model_transaction->insert_trx_gl_detail($data_trx_gl_detail);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'JURNAL BERHASIL DI REVISI!');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Failed to insert Journal ! please contact your administrator!');
		}
		echo json_encode($return);
	}

	/****************************************************************************************/
	// JURNAL UMUM
	/****************************************************************************************/

	public function jurnal_umum()
	{
		$data['container'] = 'transaction/jurnal_umum';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function ajax_get_gl_account()
	{
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_transaction->get_gl_account($branch_code);

		echo json_encode($data);
	}

	function check_gl(){
		$branch_code = $this->input->post('branch_code');
		$tanggal = $this->input->post('tanggal');
		$account_code = $this->input->post('account_code');
		$debet = $this->input->post('debet');
		$credit = $this->input->post('credit');

		$tanggal = str_replace('/','-',$tanggal);
		$debet = str_replace('.','',$debet);
		$credit = str_replace('.','',$credit);

		if($debet > 0){
			$flag = 'D';
			$amount = $debet;
		}

		if($credit > 0){
			$flag = 'C';
			$amount = $credit;
		}

		$tanggal = date('Y-m-d',strtotime($tanggal));

		$check = $this->model_transaction->check_gl($branch_code,$tanggal,$account_code,$flag,$amount);

		$total = $check['total'];

		$result = array('total' => $total);

		echo json_encode($result);
	}

	public function process_transaksi_jurnal()
	{
		$branch_code 		= $this->input->post('branch_code');
		$no_referensi 		= $this->input->post('no_referensi2');
		$deskripsi 			= $this->input->post('deskripsi2');
		$tanggal 			= $this->input->post('tanggal2');
		$tanggal = str_replace('/', '', $tanggal);
		$tanggal 			= substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);

		$gl_account_id 		= $this->input->post('gl_account_id');
		$account_code 		= $this->input->post('account_code');
		$credit 			= $this->convert_numeric($this->input->post('credit'));
		$debet 				= $this->convert_numeric($this->input->post('debet'));
		$description 		= $this->input->post('description');

		$account_group_code = $this->input->post('account_group_code');
		$account_type 		= $this->input->post('account_type');

		$trx_gl_id 			= uuid(false);

		$data_trx_gl = array(
				'trx_gl_id' => $trx_gl_id,
				'trx_date' 	=> date("Y-m-d"),
				'voucher_date' => $tanggal,
				'voucher_ref' => $no_referensi,
				'branch_code' => $branch_code,
				'created_by' => $this->session->userdata('user_id'),
				'jurnal_trx_type' => 0,
				'description' => $deskripsi,
				'created_date' => date('Y-m-d H:i:s')
			);

		$data_trx_gl_detail = array();
		for ( $i = 0 ; $i < count($gl_account_id) ; $i++ )
		{
			/** 1. mendapatkan flag D/C. Default = X 
			 * 	2. mencari amount
			 */
			$flag_debit_credit = 'X';
			$amount = 0;
			if ( $credit[$i] > $debet[$i] ) {
				$flag_debit_credit = 'C';
				$amount = $credit[$i];
			}
			else if ( $credit[$i] < $debet[$i] ) {
				$flag_debit_credit = 'D';
				$amount = $debet[$i];
			}
			

			$data_trx_gl_detail[] = array(
					'trx_gl_id' => $trx_gl_id,
					'account_code' => $account_code[$i],
					'flag_debit_credit' => $flag_debit_credit,
					'amount' => $amount,
					'description' => $description[$i],
					'trx_sequence' => $i
				);
		}

		$this->db->trans_begin();
		$this->model_transaction->insert_trx_gl($data_trx_gl);
		$this->model_transaction->insert_trx_gl_detail($data_trx_gl_detail);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'JURNAL BERHASIL DI TAMBAHKAN!');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Failed to insert Journal ! please contact your administrator!');
		}
		echo json_encode($return);
	}

	/****************************************************************************************/	
	// BEGIN DROPING KAS PETUGAS
	/****************************************************************************************/

	public function droping_kas_petugas()
	{
		$data['container'] = 'transaction/droping_kas_petugas';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function ajax_get_gl_account_cash()
	{
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_transaction->ajax_get_gl_account_cash();

		echo json_encode($data);
	}

	public function process_droping()
	{
		$account_cash_id = $this->input->post('account_cash_id');
		$account_cash_name = $this->input->post('account_cash_name');
		$account_code = $this->input->post('account_code');
		$amount = $this->input->post('amount');
		$branch_code = $this->input->post('branch_code');
		$description = $this->input->post('description');
		$deskripsi2 = $this->input->post('deskripsi2');
		$fa_code = $this->input->post('fa_code');
		$no_referensi2 = $this->input->post('no_referensi2');
		$tanggal2 = $this->input->post('tanggal2');
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal2 = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);


		$trx_gl_cash_id = uuid(false);
		$trx_gl_cash_data = array(
				'trx_gl_cash_id' => $trx_gl_cash_id,
				'trx_date' => $tanggal2,
				'voucher_date' => $tanggal2,
				'description' => $deskripsi2,
				'created_by' => $this->session->userdata('user_id'),
				'created_date' => date('Y-m-d H:i:s')
			);

		$trx_gl_cash_detail_data = array();
		for ( $i = 0 ; $i < count($account_cash_id) ; $i++ )
		{
			$trx_gl_cash_detail_data[] = array(
					'trx_gl_cash_detail_id' => uuid(false),
					'trx_gl_cash_id' => $trx_gl_cash_id,
					'account_cash_code' => $account_code[$i],
					'amount' => $amount[$i],
					'description' => $description[$i]
				);
		}

		$this->db->trans_begin();
		
		$this->model_transaction->insert_trx_gl_cash($trx_gl_cash_data);
		$this->model_transaction->insert_trx_gl_cash_detail($trx_gl_cash_detail_data);

		for ( $j = 0 ; $j < count($account_cash_id) ; $j++ )
		{
			$account_cash = $this->model_transaction->get_gl_account_cash_by_account_cash_id($account_cash_id[$j]);
			$gl_account_cash_param = array('account_cash_id'=>$account_cash_id[$j],'account_cash_code'=>$account_code[$j],'fa_code'=>$fa_code[$j]);
			$saldo = ($account_cash['saldo']+$amount[$j]);
			$gl_account_cash_data = array('saldo' => $saldo);

			$this->model_transaction->update_gl_account_cash($gl_account_cash_data,$gl_account_cash_param);
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'Droping Kas Sukses !');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Droping Kas Sukses !');
		}
		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END DROPING KAS PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN SETORAN KAS PETUGAS
	/****************************************************************************************/

	public function setoran_kas_petugas()
	{
		$data['container'] = 'transaction/setoran_kas_petugas';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function ajax_get_gl_account_cash_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_transaction->ajax_get_gl_account_cash_by_keyword($keyword,$branch_code,'0');

		echo json_encode($data);
	}

	public function ajax_get_gl_account_cash1_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_transaction->ajax_get_gl_account_cash_by_keyword($keyword,$branch_code,'1');

		echo json_encode($data);
	}

	public function ajax_get_cm_by_fa_code()
	{
		$fa_code = $this->input->post('fa_code');
		$data = $this->model_transaction->ajax_get_cm_by_fa_code($fa_code);

		echo json_encode($data);
	}

	public function process_setoran_kas_petugas()
	{
		$branch_code = $this->input->post('branch_code');
	    $tanggal2 = $this->input->post('tanggal2');
	    $tanggal2 = str_replace('/','',$tanggal2);
		$tanggal2 = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	    $no_referensi2 = $this->input->post('no_referensi2');
	    $deskripsi2 = $this->input->post('deskripsi2');
	    $account_cash_id = $this->input->post('account_cash_id');
	    $account_cash_code = $this->input->post('account_cash_code');
	    $fa_code = $this->input->post('fa_code');
	    $account_code = $this->input->post('account_code');
	    $cm_id = $this->input->post('cm_id');
	    $cm_code = $this->input->post('cm_code');
	    $amount = $this->input->post('amount');
	    $description = $this->input->post('description');
	    $total_amount_def = $this->input->post('total_amount_def');
		$account_cash = $this->model_transaction->get_gl_account_cash_by_account_cash_id($account_cash_id);

		$trx_gl_cash_id = uuid(false);
		$trx_gl_cash_data = array(
				'trx_gl_cash_id' => $trx_gl_cash_id,
				'trx_date' => $tanggal2,
				'voucher_date' => $tanggal2,
				'description' => $deskripsi2,
				'created_by' => $this->session->userdata('user_id'),
				'created_date' => date('Y-m-d H:i:s')
			);
		$trx_gl_cash_detail_id = uuid(false);
		$trx_gl_cash_detail_data[] = array(
				'trx_gl_cash_detail_id' => $trx_gl_cash_detail_id,
				'trx_gl_cash_id' => $trx_gl_cash_id,
				'account_cash_code' => $account_cash_code,
				'amount' => $total_amount_def,
				'description' => $deskripsi2
			);

		$saldo = $account_cash['saldo']-$total_amount_def;

		$gl_account_cash_param = array(
									'account_cash_id'=>$account_cash_id
									,'account_cash_code'=>$account_cash_code
									,'fa_code'=>$fa_code
								);

		$gl_account_cash_data = array(
									'saldo' => $saldo
								);

		$trx_gl_cash_detail_cm = array();
		for ( $i = 0 ; $i < count($cm_id) ; $i++ )
		{
			$trx_gl_cash_detail_cm_data[] = array(
												'trx_gl_cash_detail_id' => $trx_gl_cash_detail_id,
												'cm_code' => $cm_code[$i],
												'amount' => $amount[$i],
												'description' => $description[$i]
											);
		}

		$this->db->trans_begin();
		$this->model_transaction->insert_trx_gl_cash($trx_gl_cash_data);
		$this->model_transaction->insert_trx_gl_cash_detail($trx_gl_cash_detail_data);
		$this->model_transaction->update_gl_account_cash($gl_account_cash_data,$gl_account_cash_param);
		$this->model_transaction->insert_trx_gl_cash_detail_cm($trx_gl_cash_detail_cm_data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'Setoran Kas Sukses !');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Setoran Kas Gagal !');
		}

		echo json_encode($return);
	}

	/* BEGIN DEBET ANGSURAN **************************************************************/

	public function pendebetan_angsuran()
	{
		$data['container'] = 'transaction/pendebetan_angsuran';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function ajax_get_data_pendebetan_angsuran_pembiayaan()
	{
		$branch_code = $this->input->post('branch_code');
		$tanggal_jto = $this->input->post('tanggal_jto');
	    $tanggal_jto = str_replace('/', '', $tanggal_jto);
		$tanggal_jto = substr($tanggal_jto,4,4).'-'.substr($tanggal_jto,2,2).'-'.substr($tanggal_jto,0,2);

		$data = $this->model_transaction->get_data_pendebetan_angsuran_pembiayaan($tanggal_jto);

		echo json_encode($data);
	}

	public function process_pendebetan_angsuran_pembiayaan()
	{
		$branch_id 				= $this->input->post('branch_id');
		$branch_code 			= $this->input->post('branch_code');
	    $tanggal_jto 			= $this->input->post('tanggal_jto2');
	    $tanggal_jto = str_replace('/', '', $tanggal_jto);
	    $account_financing_no 	= $this->input->post('account_financing_no');
	    $angsuran_pokok 		= $this->input->post('angsuran_pokok');
	    $angsuran_margin 		= $this->input->post('angsuran_margin');
	    $angsuran_tabungan 		= $this->input->post('angsuran_tabungan');
	    $angsuran 				= $this->input->post('angsuran');
	    $jto_angsuran 			= $this->input->post('jto_angsuran');
	    $saldo_tabungan 		= $this->input->post('saldo_tabungan');
	    $jto_next 				= $this->input->post('jtempo_angsuran_next');

	    $success=0;
	    $failed=0;
	    $sub_success=0;
	    $sub_success_desc = '';
	    $sub_failed=0;
	    $sub_failed_desc = '';

	    for ( $i = 0 ; $i < count($account_financing_no) ; $i++ )
	    {

	    	$get_data_financing = $this->model_transaction->get_account_financing_by_account_financing_no($account_financing_no[$i]);

	    	if(count($get_data_financing)>0)
	    	{
	    		$jtempo_angsuran_last 	= $get_data_financing['jtempo_angsuran_next'];
				$jangkawaktu 			= $get_data_financing['periode_jangka_waktu']; // 0 = harian, 1=mingguan, 2=bulanan, 3=jtempo
				$jtempo_db 				= $get_data_financing['tanggal_jtempo'];
				$jtempo_angsuran_next   = null;

				if($jangkawaktu==0)
					$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_last.' +1 days'));

				else if($jangkawaktu==1)
					$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_last.' +7 days'));

				else if($jangkawaktu==2)
					$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_last.' +1 month'));

				else if($jangkawaktu==3)
					$jtempo_angsuran_next = $jtempo_db;

		    	// update mfi_account_financing
		    	$data_account_financing = array(
		    			'saldo_pokok' => $get_data_financing['saldo_pokok']-($angsuran_pokok[$i]*$jto_angsuran[$i]),
		    			'saldo_margin' => $get_data_financing['saldo_margin']-($angsuran_margin[$i]*$jto_angsuran[$i]),
		    			'cadangan_resiko' => $get_data_financing['cadangan_resiko']-($angsuran_tabungan[$i]*$jto_angsuran[$i]),
		    			'jtempo_angsuran_last' => $jtempo_angsuran_last,
		    			'jtempo_angsuran_next' => $jtempo_angsuran_next
		    		);
		    	$param_account_financing = array(
		    			'account_financing_no' => $account_financing_no[$i]
		    		);

		    	if($get_data_financing['saldo_pokok']-($angsuran_pokok[$i]*$jto_angsuran[$i])==0){
		    		$data_account_financing['status_rekening'] = 2;
		    	}

		    	// update mfi_account_saving
		    	$data_account_saving = array(
		    			'saldo_memo' => $saldo_tabungan[$i]-($angsuran[$i] * $jto_angsuran[$i])
		    		);
		    	$param_account_saving = array('account_saving_no' => $get_data_financing['account_saving_no']);


		    	$trx_detail_id = uuid(false);

		    	// insert mfi_trx_detail
		    	$data_trx_detail = array(
		    			'trx_detail_id' => $trx_detail_id,
		    			'trx_type' => 1,
		    			'trx_account_type' => 3,
		    			'account_no' => $get_data_financing['account_saving_no'],
		    			'flag_debit_credit' => 'D',
		    			'amount' => ($angsuran[$i] * $jto_angsuran[$i]),
		    			'trx_date' => $this->current_date(),
		    			'created_by' => $this->session->userdata('user_id'),
		    			'created_date' => date('Y-m-d H:i:s'),
		    			'account_no_dest' => $account_financing_no[$i],
		    			'account_type_dest' => 1
		    		);

		    	// insert mfi_trx_account_saving
		    	$data_trx_account_saving = array(
		    			'trx_detail_id' => $trx_detail_id,
		    			'trx_account_saving_id' => uuid(false),
		    			'branch_id' => $branch_id,
		    			'account_saving_no' => $get_data_financing['account_saving_no'],
		    			'trx_saving_type' => 3,
		    			'flag_debit_credit' => 'D',
		    			'trx_date' => $this->current_date(),
		    			'amount' => ($angsuran[$i] * $jto_angsuran[$i]),
		    			'created_date' => date('Y-m-d H:i:s'),
		    			'created_by' => $this->session->userdata('user_id')
		    		);
		    	
		    	for ( $j = 0 ; $j < count($jto_angsuran[$i]) ; $j++ )
		    	{
		    		// insert ke mfi_trx_account_saving
		    		$data_trx_account_financing = array(
		    				'trx_account_financing_id' => uuid(false),
		    				'branch_id' => $branch_id,
		    				'trx_detail_id' => $trx_detail_id,
		    				'account_financing_no' => $get_data_financing['account_financing_no'],
		    				'trx_financing_type' => 1,
		    				'trx_date' => $this->current_date(),
		    				'jto_date' => $jto_next[$i],
		    				'pokok' => $angsuran_pokok[$i],
		    				'margin' => $angsuran_margin[$i],
		    				'catab' => $angsuran_tabungan[$i],
		    				'created_date' => date('Y-m-d H:i:s'),
		    				'created_by' => $this->session->userdata('user_id')
		    			);

		    		$this->db->trans_begin();
		    		$this->model_transaction->insert_trx_account_financing($data_trx_account_financing);
		    		if($this->db->trans_status()===true){
		    			$this->db->trans_commit();
		    			$sub_success++;
		    		}else{
		    			$this->db->trans_rollback();
		    			$sub_failed++;
		    		}
		    	}
		    	$sub_success_desc += '<success> Line '.$i.' : '.$sub_success.' <br>';
		    	$sub_failed_desc += '<failed> Line '.$i.' : '.$sub_failed.' <br>';

		    	$this->db->trans_begin();

		    	$this->model_transaction->update_account_financing($data_account_financing,$param_account_financing);
		    	$this->model_transaction->update_account_saving($data_account_saving,$param_account_saving);
		    	$this->model_transaction->insert_trx_detail($data_trx_detail);
		    	$this->model_transaction->insert_trx_account_saving($data_trx_account_saving);

		    	if($this->db->trans_status()===true){
		    		$this->db->trans_commit();
		    		$success++;
		    	}else{
		    		$this->db->trans_rollback();
		    		$failed++;
		    	}

		    } // end if

	    } // end for


	    if($success>0)
	    {
		    $return = array(
		    		'success' => true,
		    		'num_success'=>$success,
		    		'num_failed'=>$failed,
		    		'sub_success_desc' => $sub_success_desc,
		    		'sub_failed_desc' => $sub_failed_desc
		    	);
		}
		else
		{
		    $return = array(
		    		'success' => false,
		    		'num_success'=>$success,
		    		'num_failed'=>$failed,
		    		'sub_success_desc' => $sub_success_desc,
		    		'sub_failed_desc' => $sub_failed_desc
		    	);
		}

		echo json_encode($return);

	} // end function process_pendebetan_angsuran_pembiayaan()


	/* END DEBET ANGSURAN **************************************************************/

	// PEMBATALAN ANGSURAN
	function pembatalan_angsuran(){
		$data['container'] = 'transaction/pembatalan_angsuran';
		$this->load->view('core',$data);
	}

    function jqgrid_list_pembatalan_angsuran(){
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
        $sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'cif_no';//1
        $sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
        $cm_code = isset($_REQUEST['cm_code'])?$_REQUEST['cm_code']:'';
        $trx_date = isset($_REQUEST['trx_date'])?$_REQUEST['trx_date']:'';
        $trx_date = $this->datepicker_convert(FALSE,$trx_date);

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
        if ($totalrows) {
            $limit_rows = $totalrows;
        }

        $count = $this->model_transaction->jqgrid_count_pembatalan_angsuran($trx_date,$cm_code);

        if ($count > 0) {
            $total_pages = ceil($count / $limit_rows);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
        $page = $total_pages;
        $start = $limit_rows * $page - $limit_rows;
        if ($start < 0) $start = 0;

        $result = $this->model_transaction->jqgrid_list_pembatalan_angsuran($sidx,$sort,$limit_rows,$start,$trx_date,$cm_code);

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $i = 0;

        foreach ($result as $row){
            $responce['rows'][$i]['cif_no']=$row['cif_no'];
            $responce['rows'][$i]['cell']=array(
                $row['trx_cm_detail_id']
                ,$row['cif_no']
                ,$row['nama']
                ,$row['account_financing_no']
                ,$row['pokok']
                ,$row['margin']
                ,$row['angsuran_pokok']
                ,$row['angsuran_margin']
                ,$row['angsuran_catab']
                ,$row['account_saving_no']
                ,$row['counter_angsuran']
            );
            $i++;
        }

        echo json_encode($responce);
    }

    function get_data_for_pembatalan_angsuran(){
    	$rekening = $this->input->post('account_financing_no');
    	$data = $this->model_transaction->get_data_for_pembatalan_angsuran($rekening);
    }

	/****************************************************************************************/	
	// BEGIN KAS PETUGAS
	/****************************************************************************************/
	public function kas_petugas()
	{
		$data['container']  = 'transaction/kas_petugas';
		$branch_code 		= $this->session->userdata('branch_code');
		$data['kas_petugas']= $this->model_transaction->get_fa_by_branch_code($branch_code);		
		$data['kas_teller'] = $this->model_transaction->get_account_cash_code_by_branch_code($branch_code);
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['branchs'] = $this->model_administration->get_branchs();
		$this->load->view('core',$data);
	}

	public function get_accounts_cash_by_branch_code()
	{
		$branch_code=$this->input->post('branch_code');
		$kas_petugas=$this->model_transaction->get_fa_by_branch_code($branch_code);
		$kas_teller=$this->model_transaction->get_account_cash_code_by_branch_code($branch_code);
		$datas['kas_petugas']=$kas_petugas;
		$datas['kas_teller']=$kas_teller;
		echo json_encode($datas);
	}


	public function datatable_transaksi_kas_petugas()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','trx_date','account_cash_code','account_teller_code','mfi_trx_gl_cash.trx_gl_cash_type','mfi_trx_gl_cash.amount','mfi_trx_gl_cash.description','');
				
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

		$rResult 			= $this->model_transaction->datatable_transaksi_kas_petugas($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_transaksi_kas_petugas($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_transaksi_kas_petugas(); // get number of all data
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
			if ($aRow['trx_gl_cash_type']==1) 
			{
				$jenis_trx = "droping kas";
			} 
			else if ($aRow['trx_gl_cash_type']==2) 
			{
				$jenis_trx = "setoran rembug";
			}
			else if ($aRow['trx_gl_cash_type']==3) 
			{
				$jenis_trx = "penarikan rembug";
			}
			else if ($aRow['trx_gl_cash_type']==4) 
			{
				$jenis_trx = "setor ke teller";
			}
			
			$row[] = '<input type="checkbox" value="'.$aRow['trx_gl_cash_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['trx_date'];
			$row[] = $aRow['kode_kas_petugas'];
			$row[] = $aRow['kode_kas_teller'];
			$row[] = $jenis_trx;
			$row[] = '<div align="right">'.number_format($aRow['amount'],0,',','.').'</div>';
			$row[] = $aRow['description'];
			$row[] = '<a href="javascript:;" trx_gl_cash_id="'.$aRow['trx_gl_cash_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_trx_by_trx_gl_cash_id()
	{
		$trx_gl_cash_id = $this->input->post('trx_gl_cash_id');
		$data = $this->model_transaction->get_trx_by_trx_gl_cash_id($trx_gl_cash_id);

		echo json_encode($data);
	}


	public function get_fa_by_branch_code()
	{
		$branch_code = $this->session->userdata('branch_code');;
		$data = $this->model_transaction->get_fa_by_branch_code($branch_code);

		echo json_encode($data);
	}

	public function get_account_cash_code_by_branch_code()
	{
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_transaction->get_account_cash_code_by_branch_code($branch_code);

		echo json_encode($data);
	}

	public function add_kas_petugas()
	{
		$angs_tanggal	 = $this->input->post('trx_date');
		$angs_tanggal = str_replace('/', '', $angs_tanggal);
		$tg_angsuran = substr($angs_tanggal,0,2);
		$bl_angsuran = substr($angs_tanggal,2,2);
		$th_angsuran = substr($angs_tanggal,4,4);
		$trx_date 	 = "$th_angsuran-$bl_angsuran-$tg_angsuran";
		$account_cash_code		= $this->input->post('kas_petugas');
		$trx_gl_cash_type		= $this->input->post('jenis_transaksi');
		if ($trx_gl_cash_type==1) 
		{			
			$flag_debet_credit		= 'D';
		} 
		else 
		{
			$flag_debet_credit		= 'C';
		}		
		$account_teller_code 	= $this->input->post('kas_teller');
		$voucher_date		 	= $this->current_date();
		$voucher_ref		 	= $this->input->post('no_referensi');
		$description		 	= $this->input->post('keterangan');
		$created_by 		  	= $this->session->userdata('user_id');
		$created_date		 	= date('Y-m-d H:i:s');
		$amount				 	= $this->input->post('jumlah_setoran');
		
		$data = array(
						 'trx_date'				=> $trx_date
						,'account_cash_code'	=> $account_cash_code
						,'trx_gl_cash_type'		=> $trx_gl_cash_type
						,'flag_debet_credit'	=> $flag_debet_credit
						,'account_teller_code'	=> $account_teller_code
						,'voucher_date'			=> $voucher_date
						,'voucher_ref'			=> $voucher_ref
						,'description'			=> $description
						,'created_by'			=> $created_by
						,'created_date'			=> $created_date
						,'amount'				=> str_replace('.','',$amount)
						,'status' 				=> 0
					);
		
		$this->db->trans_begin();
		$this->model_transaction->add_kas_petugas($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}


	
	public function edit_kas_petugas()
	{	
		$trx_gl_cash_id		 	= $this->input->post('trx_gl_cash_id');

		$angs_tanggal	 = $this->input->post('trx_date2');
		$angs_tanggal = str_replace('/', '', $angs_tanggal);
			$tg_angsuran = substr($angs_tanggal,0,2);
			$bl_angsuran = substr($angs_tanggal,2,2);
			$th_angsuran = substr($angs_tanggal,4,4);
			$trx_date 	 = "$th_angsuran-$bl_angsuran-$tg_angsuran";
		$account_cash_code		= $this->input->post('kas_petugas2');
		$trx_gl_cash_type		= $this->input->post('jenis_transaksi2');
			if ($trx_gl_cash_type==1) 
			{			
				$flag_debet_credit		= 'D';
			} 
			else 
			{
				$flag_debet_credit		= 'C';
			}		
		$account_teller_code 	= $this->input->post('kas_teller2');
		$voucher_date		 	= $this->current_date();
		$voucher_ref		 	= $this->input->post('no_referensi2');
		$description		 	= $this->input->post('keterangan2');
		$created_by 		  	= $this->session->userdata('user_id');
		$created_date		 	= date('Y-m-d H:i:s');
		$amount				 	= $this->input->post('jumlah_setoran2');
		
		
		$param = array('trx_gl_cash_id'=>$trx_gl_cash_id);
		$data = array(
						 'trx_gl_cash_id'		=> $trx_gl_cash_id
						,'trx_date'				=> $trx_date
						,'account_cash_code'	=> $account_cash_code
						,'trx_gl_cash_type'		=> $trx_gl_cash_type
						,'flag_debet_credit'	=> $flag_debet_credit
						,'account_teller_code'	=> $account_teller_code
						,'voucher_date'			=> $voucher_date
						,'voucher_ref'			=> $voucher_ref
						,'description'			=> $description
						,'created_by'			=> $created_by
						,'created_date'			=> $created_date
						,'amount'				=> str_replace('.','',$amount)
						,'status' 				=> 0
					);
		
		$this->db->trans_begin();
		$this->model_transaction->edit_kas_petugas($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	
	
	public function delete_kas_petugas()
	{
		$trx_gl_cash_id = $this->input->post('trx_gl_cash_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($trx_gl_cash_id) ; $i++ )
		{
			$param = array('trx_gl_cash_id'=>$trx_gl_cash_id[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_kas_petugas($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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


	public function verifikasi_transaksi_kas_petugas()
	{
		$data['container']  = 'transaction/verifikasi_kas_petugas';
		$branch_code 		= $this->session->userdata('branch_code');
		$data['kas_petugas']= $this->model_transaction->get_account_cash_code_fa($branch_code);		
		$data['kas_teller'] = $this->model_transaction->get_account_cash_code_teller($branch_code);
		$data['branchs']    = $this->model_administration->get_branchs();
		$this->load->view('core',$data);
	}

	public function datatable_verifikasi_transaksi_kas_petugas()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$branch_code = @$_GET['branch_code'];
		$from_date  = str_replace('/','',@$_GET['from_date']);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date  = str_replace('/','',@$_GET['thru_date']);
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);
		$aColumns = array( '','trx_date','account_cash_code','account_teller_code','mfi_trx_gl_cash.trx_gl_cash_type','mfi_trx_gl_cash.amount','mfi_trx_gl_cash.description','');
				
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

		$rResult 			= $this->model_transaction->datatable_verifikasi_transaksi_kas_petugas($sWhere,$sOrder,$sLimit,$from_date,$thru_date,$branch_code); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_verifikasi_transaksi_kas_petugas($sWhere,'','',$from_date,$thru_date,$branch_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_verifikasi_transaksi_kas_petugas('','','',$from_date,$thru_date,$branch_code); // get number of all data
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
			if ($aRow['trx_gl_cash_type']==1) 
			{
				$jenis_trx = "droping kas";
			} 
			else if ($aRow['trx_gl_cash_type']==2) 
			{
				$jenis_trx = "setoran rembug";
			}
			else if ($aRow['trx_gl_cash_type']==3) 
			{
				$jenis_trx = "penarikan rembug";
			}
			else if ($aRow['trx_gl_cash_type']==4) 
			{
				$jenis_trx = "setor ke teller";
			}
			
			$row[] = '<input type="checkbox" value="'.$aRow['trx_gl_cash_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = '<div align="center">'.$aRow['trx_date'].'</div>';
			$row[] = $aRow['kode_kas_petugas'];
			$row[] = $aRow['kode_kas_teller'];
			$row[] = $jenis_trx;
			$row[] = '<div align="right">'.number_format($aRow['amount'],0,',','.').'</div>';
			$row[] = $aRow['description'];
			$row[] = '<a href="javascript:;" trx_gl_cash_id="'.$aRow['trx_gl_cash_id'].'" id="link-verifikasi">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function verifikasi_reject_kas_petugas()
	{
		$trx_gl_cash_id = $this->input->post('trx_gl_cash_id');
		$param = array('trx_gl_cash_id'=>$trx_gl_cash_id);
		$this->db->trans_begin();
		$this->model_transaction->delete_kas_petugas($param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	public function verifikasi_approve_kas_petugas()
	{

		$trx_gl_cash_id	 	 = $this->input->post('trx_gl_cash_id');
		$angs_tanggal	 	 = $this->input->post('trx_date2');
		$angs_tanggal 		 = str_replace('/', '', $angs_tanggal);
		$tg_angsuran 		 = substr($angs_tanggal,0,2);
		$bl_angsuran 		 = substr($angs_tanggal,2,2);
		$th_angsuran 		 = substr($angs_tanggal,4,4);
		$trx_date 	 		 = "$th_angsuran-$bl_angsuran-$tg_angsuran";
		$voucher_date		 = $this->current_date();
		$voucher_ref		 = $this->input->post('no_referensi2');
		$branch_code 		 = $this->session->userdata('branch_code');
		$description		 = $this->input->post('keterangan2');
		$created_by 		 = $this->session->userdata('user_id');
		$created_date		 = date('Y-m-d H:i:s');
		$account_cash_code	 = $this->input->post('kas_petugas2_hidden');
		$account_teller_code = $this->input->post('kas_teller2_hidden');
		$trx_gl_cash_type	 = $this->input->post('jenis_transaksi2');
		$amount	 			 = $this->convert_numeric($this->input->post('jumlah_setoran2'));

		// if($trx_gl_cash_type==1){
		// 	$flag_debit_credit1 = "D";
		// 	$trx_sequence1 	    = 0;
		// 	$flag_debit_credit2 = "C";
		// 	$trx_sequence2 	    = 1;
		// }else{
		// 	$flag_debit_credit1 = "C";
		// 	$trx_sequence1 	    = 1;
		// 	$flag_debit_credit2 = "D";
		// 	$trx_sequence2 	    = 0;
		// }

		// $account_code_petugas = $this->model_transaction->get_account_code_petugas($account_cash_code);
		// $account_code_teller  = $this->model_transaction->get_account_code_teller($account_teller_code);
		
		// $data = array(
		// 				 'trx_gl_id'		=> $trx_gl_id
		// 				,'trx_date'			=> date("Y-m-d")
		// 				,'voucher_date'		=> $trx_date
		// 				,'voucher_ref'		=> $voucher_ref
		// 				,'branch_code'		=> $branch_code
		// 				,'jurnal_trx_type'	=> 0
		// 				,'created_by'		=> $created_by
		// 				,'created_date'		=> $created_date
		// 				,'description'		=> $description
		// 			);

		$data2 = array('status'=>1);
		$param = array('trx_gl_cash_id'=>$trx_gl_cash_id);

		// $data3 = array(
		// 			 'trx_gl_id'			=> $trx_gl_id
		// 			,'account_code'			=> $account_code_petugas
		// 			,'flag_debit_credit'	=> $flag_debit_credit1
		// 			,'amount'				=> $amount
		// 			,'description'			=> ''
		// 			,'trx_sequence'			=> $trx_sequence1
		// 			);

		// $data4 = array(
		// 			 'trx_gl_id'			=> $trx_gl_id
		// 			,'account_code'			=> $account_code_teller
		// 			,'flag_debit_credit'	=> $flag_debit_credit2
		// 			,'amount'				=> $amount
		// 			,'description'			=> ''
		// 			,'trx_sequence'			=> $trx_sequence2
					// );
		
		$this->db->trans_begin();
		$this->model_transaction->update_status_gl_cash($data2,$param);
		$this->model_transaction->fn_proses_jurnal_kaspetugas($trx_gl_cash_id);
		// $this->model_transaction->insert_mfi_trx_gl($data);
		// $this->model_transaction->insert_mfi_trx_gl_detail($data3);
		// $this->model_transaction->insert_mfi_trx_gl_detail($data4);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END KAS PETUGAS
	/****************************************************************************************/

	public function ajax_form_detail_setoran_tab_berencana()
	{
		$cif_no = $this->input->post('cif_no');

		$data = $this->model_transaction->get_tabungan_berencana_by_cif_no($cif_no);

		echo json_encode($data);
	}



	public function get_ajax_biaya_premi_asuransi()
	{
		$product 				= $this->input->post('produkpremi');
		$manfaat 				= $this->input->post('total');
		$tgl_lahir 				= $this->input->post('tgl_lahir');
		$tgl_lahir 				= str_replace('/', '', $tgl_lahir);
		$tanggal_akad 			= $this->input->post('tgl_akad');
		$tanggal_akad 			= str_replace('/', '', $tanggal_akad);
		//$tanggal_mulai_angsur 	= $this->input->post('angsuranke1');
		$tanggal_jtempo			= $this->input->post('tgl_jtempo');
		$tanggal_jtempo 		= str_replace('/', '', $tanggal_jtempo);

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal akad
		$tgl_akad 			=substr("$tanggal_akad",0,2);
	    $bln_akad 			=substr("$tanggal_akad",2,2);
	    $thn_akad	 		=substr("$tanggal_akad",4,4);
	    $tglakhir_akad		= "$thn_akad-$bln_akad-$tgl_akad";  

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Angsuran
		/*$tgl_mulai_angsur 	=substr("$tanggal_mulai_angsur",0,2);
	    $bln_mulai_angsur 	=substr("$tanggal_mulai_angsur",2,2);
	    $thn_mulai_angsur	=substr("$tanggal_mulai_angsur",4,4);
	    $tglakhir_angsur	= "$thn_mulai_angsur-$bln_mulai_angsur-$tgl_mulai_angsur"; */

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Jatuh Tempo
		$tgl_jtempo     	=substr("$tanggal_jtempo",0,2);
	    $bln_jtempo     	=substr("$tanggal_jtempo",2,2);
	    $thn_jtempo	        =substr("$tanggal_jtempo",4,4);
	    $tglakhir_jtempo	= "$thn_jtempo-$bln_jtempo-$tgl_jtempo";

		$awal_kontrak 		= $tglakhir_akad;
		$akhir_kontrak 		= $tglakhir_jtempo;
		$diff = abs(strtotime($akhir_kontrak) - strtotime($awal_kontrak));

		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		if($months>0){
			$years++;
		}

		/*echo $years;
		echo $months;
		die();*/
/*
		$masa_kontrak_tahun = $years;
		$masa_kontrak_bulan = $months;*/
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$awal_lahir 		= $tgl_lahir;
		$tanggal_skrng 		= date('Y-m-d');
		$difff = abs(strtotime($tanggal_skrng) - strtotime($awal_lahir));

		$year = floor($difff / (365*60*60*24));
		$month = floor(($difff - $year * 365*60*60*24) / (30*60*60*24));
		$day = floor(($difff - $year * 365*60*60*24 - $month*30*60*60*24)/ (60*60*24));
		if($month>0){
			$year++;
		}

		/*echo $year;
		echo $month;
		die();*/
/*
		$usia_tahun = $year;
		$usia_bulan = $month;*/
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$data = $this->model_transaction->get_ajax_biaya_premi_asuransi_jiwa($product,$manfaat,$year,$month,$years,$months);
		if($data==null){
			$data=0;
		}

		echo json_encode(array('p_asuransi_jiwa'=>$data));
	}

	public function get_ajax_produk_by_cif_type()
	{
		$cif_type_hidden = $this->input->post('cif_type');
		// $jenis_pembiayaan='';
		if($cif_type_hidden=='0')
		{
			// $jenis_pembiayaan=1;
			$data = $this->model_transaction->get_ajax_produk_by_cif_type0();
		}
		else if($cif_type_hidden=='1')
		{
			$data = $this->model_transaction->get_ajax_produk_by_cif_type1();
		}

		echo json_encode($data);
	}

	public function check_account_financing_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');

		$no_validation = $this->model_transaction->check_account_financing_no($account_financing_no);

		if($no_validation==true){
			$return = array('stat'=>true,'message'=>'No Rekening Berlaku');
		}else{
			$return = array('stat'=>false,'message'=>'No Rekening Sudah Terdaftar dan Aktif');
		}

		echo json_encode($return);

	}

	public function get_ajax_produk_by_cif_type_link_edit()
	{
		$financing_type = $this->input->post('financing_type');
		// $cif_type_hidden = $this->input->post('cif_type_hidden2');
		// $jenis_pembiayaan='';
		if($financing_type=='0')
		{
			// $jenis_pembiayaan=1;
			$data = $this->model_transaction->get_ajax_produk_by_cif_type_link_edit0();
		}
		else if($financing_type=='1')
		{
			$data = $this->model_transaction->get_ajax_produk_by_cif_type_link_edit1();
		}

		echo json_encode($data);
	}

	function set_saving_by_saving_no(){
		$account_saving_no = $this->input->post('account_saving_no');

		$saving = $this->model_transaction->set_saving_by_saving_no($account_saving_no);

		$product_name = $saving['product_name'];

		$data = array(
			'success' => TRUE,
			'product_name' => $product_name
		);

		echo json_encode($data);
	}

	function get_ajax_produk_by_product_code(){
		$product_code = $this->input->post('product_code');
		$data = $this->model_transaction->get_ajax_produk_by_product_code($product_code);

		echo json_encode($data);
	}

	//Fungsi Mencari No Registrasi Pembiayaan pada tabel mfi_account_financing_reg
	public function search_no_reg()
	{
		$keyword = $this->input->post('keyword');
		$type = $this->input->post('cif_type');
		$cm_code = $this->input->post('cm_code');
		$data = $this->model_transaction->search_no_reg($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	//Fungsi untuk mencari data CIF ketika Button Select di tekan
	public function get_ajax_value_from_no_reg()
	{
		$no_reg = $this->input->post('no_reg');
		$data = $this->model_transaction->get_ajax_value_from_no_reg($no_reg);

		echo json_encode($data);
	}

	//Fungsi untuk mencari tanggal akad
	public function ajax_get_tanggal_akad()
	{
		$tanggal_pengajuan 	= $this->input->post('tanggal_pengajuan');
		$hari 					= '7';
		$hari2 					= '14';
		$hari3 					= '21';

			$tgl_akad 			= date('d/m/Y',strtotime($tanggal_pengajuan. '+'.$hari.' days'));
			$angsuranke1 		= date('d/m/Y',strtotime($tanggal_pengajuan. '+'.$hari2.' days'));
			$tgl_jtempo 		= date('d/m/Y',strtotime($tanggal_pengajuan. '+'.$hari3.' days'));

		echo json_encode(array('tgl_akad'=>$tgl_akad,'angsuranke1'=>$angsuranke1,'tgl_jtempo'=>$tgl_jtempo));
	}

	public function ajax_get_tanggal_akad2()
	{
		$tanggal_pengajuan 	= $this->input->post('tanggal_pengajuan');
		$hari 					= '7';
		// $hari2 					= '14';
		// $hari3 					= '21';

			$tgl_akad 			= date('d/m/Y',strtotime($tanggal_pengajuan. '+'.$hari.' days'));
			// $angsuranke1 		= date('d/m/Y',strtotime($tanggal_pengajuan. '+'.$hari2.' days'));
			// $tgl_jtempo 		= date('d/m/Y',strtotime($tanggal_pengajuan. '+'.$hari3.' days'));

		echo json_encode(array('tgl_akad'=>$tgl_akad));
		// echo json_encode(array('tgl_akad'=>$tgl_akad,'angsuranke1'=>$angsuranke1,'tgl_jtempo'=>$tgl_jtempo));
	}

	//Fungsi untuk memanggil status rekening pembiayaan
	public function get_status_rekening_from_account_financing()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_status_rekening_from_account_financing($account_financing_no);

		echo json_encode($data);
	}


	function verifikasi_trx_rembug(){
		$data['container'] = 'transaction/verifikasi_trx_rembug';
		$data['title'] = 'Verifikasi Transaksi Rembug';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	//datatable verifikasi transaksi rembug
	public function datatable_verifikasi_trx_rembug()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		
		$branch_id 			= @$_GET['branch_id'];
		$branch_code 		= @$_GET['branch_code'];
		$trx_date 			= @$_GET['trx_date'];
		$trx_date 			= str_replace('/', '', $trx_date);
		$tgl_trx_date 		= substr($trx_date,0,2);
	    $bln_trx_date 		= substr($trx_date,2,2);
	    $thn_trx_date 		= substr($trx_date,4,4);
	    
	    if($trx_date!="")
	    	$trx_date 			= "$thn_trx_date-$bln_trx_date-$tgl_trx_date"; 
	    
	    // echo $trx_date;
	    // die();

		$aColumns 			= array( 'mfi_cm.cm_name','mfi_trx_cm_save.trx_date','mfi_gl_account_cash.account_cash_name','');
		
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
			for ( $i=0 ; $i<
				count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';

			$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
			
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

		$rResult 			= $this->model_transaction->datatable_verifikasi_trx_rembug($sWhere,$sOrder,$sLimit,$branch_id,$branch_code,$trx_date); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_verifikasi_trx_rembug($sWhere,'','',$branch_id,$branch_code,$trx_date); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_verifikasi_trx_rembug('','','',$branch_id,$branch_code,$trx_date); // get number of all data
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
			$row[] = $aRow['cm_name'];
			$row[] = $this->format_date_detail($aRow['trx_date'],'id',false,'/');
			$row[] = $aRow['account_cash_name'];
			$row[] = '<div align="center"><a href="javascript:;" trx_cm_save_id="'.$aRow['trx_cm_save_id'].'" 
			fa_code = "'.$aRow['fa_code'].'"
			account_cash_code = "'.$aRow['account_cash_code'].'"
			account_cash_name = "'.$aRow['account_cash_name'].'"
			cm_code = "'.$aRow['cm_code'].'"
			cm_name = "'.$aRow['cm_name'].'"
			branch_name = "'.$aRow['branch_name'].'"
			branch_code = "'.$aRow['branch_code'].'"
			branch_id = "'.$aRow['branch_id'].'"
			infaq = "'.$aRow['infaq'].'"
			kas_awal = "'.$aRow['kas_awal'].'"
			tanggal2 = "'.$aRow['trx_date'].'"
			trx_date = "'.$this->format_date_detail($aRow['trx_date'],'id',false,'/').'"
			id="link-verifikasi">Verifikasi</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function search_branch_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_transaction->search_branch_by_keyword($keyword);

		echo json_encode($data);
	}

	public function get_trx_cm_save_detail()
	{
		$trx_cm_save_id = $this->input->post('trx_cm_save_id');
		$cm_code = $this->input->post('cm_code');
		$datas = $this->model_transaction->get_trx_cm_save_detail($trx_cm_save_id,$cm_code);
		$i=0;
		$row['data']=array();
		$row['berencana']=array();
		foreach($datas as $data){
			$row['data'][$i]['cif_no'] 							= $data['cif_no'];
			$row['data'][$i]['account_financing_no'] 			= $data['account_financing_no'];
			$row['data'][$i]['trx_cm_save_detail_id'] 			= $data['trx_cm_save_detail_id'];
			$row['data'][$i]['trx_cm_save_id'] 					= $data['trx_cm_save_id'];
			$row['data'][$i]['absen'] 							= $data['absen'];
			$row['data'][$i]['frekuensi'] 						= $data['frekuensi'];
			$row['data'][$i]['setoran_tab_sukarela'] 			= $data['setoran_tab_sukarela'];
			$row['data'][$i]['setoran_lwk'] 					= $data['setoran_lwk'];
			$row['data'][$i]['setoran_mingguan'] 				= $data['setoran_mingguan'];
			$row['data'][$i]['penarikan_tab_sukarela'] 			= $data['penarikan_tab_sukarela'];
			$row['data'][$i]['kas_awal'] 						= $data['kas_awal'];
			$row['data'][$i]['infaq'] 							= $data['infaq'];
			$row['data'][$i]['created_by'] 						= $data['created_by'];
			$row['data'][$i]['created_stamp'] 					= $data['created_stamp'];
			$row['data'][$i]['status_angsuran_margin'] 			= $data['status_angsuran_margin'];
			$row['data'][$i]['status_angsuran_catab'] 			= $data['status_angsuran_catab'];
			$row['data'][$i]['status_angsuran_tab_wajib'] 		= $data['status_angsuran_tab_wajib'];
			$row['data'][$i]['status_angsuran_tab_kelompok'] 	= $data['status_angsuran_tab_kelompok'];
			$row['data'][$i]['muqosha'] 						= $data['muqosha'];
			$row['data'][$i]['keterangan'] 						= $data['keterangan'];
			$row['berencana'][$i]								= $this->model_transaction->get_trx_cm_save_berencana($data['trx_cm_save_detail_id']);
			$i++;
		}

		echo json_encode($row);
	}

	public function get_trx_cm_save_berencana()
	{
		$trx_cm_save_detail_id = $this->input->post('trx_cm_save_detail_id');
		$data = $this->model_transaction->get_trx_cm_save_berencana($trx_cm_save_detail_id);

		echo json_encode($data);
	}

	public function delete_trx_cm_save($trx_cm_save_id,$cm_code)
	{
		$data_trx_cm_save_detail 	= $this->model_transaction->get_trx_cm_save_detail($trx_cm_save_id,$cm_code);

		$this->db->trans_begin();
		$param_trx_cm_save = array('trx_cm_save_id'=>$trx_cm_save_id);
		$this->model_transaction->delete_trx_cm_save($param_trx_cm_save);
		for ( $i = 0 ; $i < count($data_trx_cm_save_detail) ; $i++ )
		{
			$param_trx_cm_save_berencana = array('trx_cm_save_detail_id'=>$data_trx_cm_save_detail[$i]['trx_cm_save_detail_id']);
			$this->model_transaction->delete_trx_cm_save_berencana($param_trx_cm_save_berencana);
		}

		$param_trx_cm_save_detail = array('trx_cm_save_id'=>$trx_cm_save_id);
		$this->model_transaction->delete_trx_cm_save_detail($param_trx_cm_save_detail);

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			return true;
		}else{
			$this->db->trans_rollback();
			return false;
		}
	}

	public function reject_trx_rembug()
	{
		$trx_cm_save_id = $this->input->post('trx_cm_save_id');
		$cm_code = $this->input->post('cm_code');
		$delete = $this->delete_trx_cm_save($trx_cm_save_id,$cm_code);

		if($delete==true){
			$return = array('success'=>true,'message'=>'Reject Success !');
		}else{
			$return = array('success'=>false,'message'=>'Reject Failed !');
		}

		echo json_encode($return);
	}

	function reject_transaksi(){
		$id 	= $this->input->post('id');
		$jenis 	= $this->input->post('jenis');
		$account_no = $this->input->post('account_no');

		$this->db->trans_begin();
		if($jenis=="Tabungan"){
			$data_trx_account_saving = $this->model_transaction->get_data_trx_account_saving_by_id($id);
			$trx_detail_id = $data_trx_account_saving['trx_detail_id'];

			$param_trx_detail = array('trx_detail_id'=>$trx_detail_id);
			$param_trx_account_saving = array('trx_account_saving_id'=>$id);

			$this->db->delete('mfi_trx_account_saving',$param_trx_account_saving);
			$this->db->delete('mfi_trx_detail',$param_trx_detail);

		}

		if($jenis=="Pembiayaan"){

			$get = $this->model_transaction->get_data_account_financing_by_account_no($account_no);
			$counter = $get['counter_angsuran'];
			$last = $get['jtempo_angsuran_last'];
			$next = $get['jtempo_angsuran_next'];


			$data_trx_account_financing = $this->model_transaction->get_data_trx_account_financing_by_id($id);
			$trx_detail_id = $data_trx_account_financing['trx_detail_id'];
			$freq = $data_trx_account_financing['freq'];

			$param_trx_detail = array('trx_detail_id'=>$trx_detail_id);
			$param_trx_account_financing = array('trx_account_financing_id'=>$id);

			$param_trx_account_saving = array('trx_account_saving_id'=>$id);

			$this->db->delete('mfi_trx_account_financing',$param_trx_account_financing);
			$this->db->delete('mfi_trx_account_saving',$param_trx_account_saving);
			$this->db->delete('mfi_trx_detail',$param_trx_detail);
		}

		if ($this->db->trans_status()===TRUE) {
			$this->db->trans_commit();
			$return = array('success'=>true);
		} else {
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);

	}

	public function get_trx_cm_save_by_param()
	{
		$branch_id 			= $this->input->post('branch_id');
		$cm_code 			= $this->input->post('cm_code');
		$trx_date 			= $this->input->post('trx_date');
		$trx_date 			= str_replace('/', '', $trx_date);
		$tgl_trx_date 		= substr($trx_date,0,2);
	    $bln_trx_date 		= substr($trx_date,2,2);
	    $thn_trx_date 		= substr($trx_date,4,4);
	    $trx_date 			= "$thn_trx_date-$bln_trx_date-$tgl_trx_date"; 
		$account_cash_code = $this->input->post('account_cash_code');

		$param = array($branch_id,$cm_code,$trx_date,$account_cash_code);
		$data = $this->model_transaction->get_trx_cm_save_by_param($param);

		echo json_encode($data);
	}

	public function check_saldo_tab_sukarela()
	{
		$cif_no = $this->input->post('cif_no');

		$data = $this->model_transaction->get_saldo_tab_sukarela($cif_no);
		if(count($data)>0){
			$return = array('saldo'=>$data['tabungan_sukarela']);
		}else{
			$return = array('saldo'=>0);
		}

		echo json_encode($return);
	}

	public function check_angsuran_terakhir()
	{
		$cif_no = $this->input->post('cif_no');

		$data_financing = $this->model_transaction->get_account_financing_by_cif_no($cif_no);

		$jangka_waktu 			= $data_financing['jangka_waktu'];
		$periode_jangka_waktu 	= $data_financing['periode_jangka_waktu'];
		$tgl_mulai_angsur 		= $data_financing['tanggal_mulai_angsur'];
		$jtempo_angsuran_next 	= $data_financing['jtempo_angsuran_next'];
		$jtempo_angsuran_last 	= $data_financing['jtempo_angsuran_last'];



	}

	function test_week()
	{
		echo "<pre>";
		print_r($this->get_week('2013-10-23'));
	}

	function get_week($date) {
        $start = strtotime($date) - strftime('%w', $date) * 24 * 60 * 60;
        $end = $start + 6 * 24 * 60 * 60;
        return array('start' => strftime('%Y-%m-%d', $start),
                     'end' => strftime('%Y-%m-%d', $end));
	}

	/**
	* JURNAL OTOMATIS
	*/
	function jurnal_otomatis()
	{
		$data['container'] = 'transaction/jurnal_otomatis';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/**
	* PROSES JURNAL OTOMATIS
	*/
	function proses_jurnal_otomatis()
	{
		$from_date = $this->input->post('from_date');
		$from_date = explode('/',$from_date);
		$from_date = $from_date[2].'-'.$from_date[1].'-'.$from_date[0];
		$thru_date = $this->input->post('thru_date');
		$thru_date = explode('/',$thru_date);
		$thru_date = $thru_date[2].'-'.$thru_date[1].'-'.$thru_date[0];

		$this->db->trans_begin();
		$this->model_transaction->proses_jurnal_otomatis($from_date,$thru_date);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$this->session->set_flashdata('message','Proses Transaksi Jurnal Otomatis Sukses !');
			$this->session->set_flashdata('status','1');
		}else{
			$this->db->trans_rollback();
			$this->session->set_flashdata('message','Failed connection into Databases, Please Contact Your Administrator !');
			$this->session->set_flashdata('status','0');
		}
		redirect("transaction/jurnal_otomatis");
	}

	/**
	* CLOSING
	*/
	function closing()
	{
		$data['container'] = 'transaction/closing';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/**
	* PROSES CLOSING
	*/
	function proses_closing()
	{
		$this->db->trans_begin();
		$this->model_transaction->proses_closing();
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$this->session->set_flashdata('message','Proses Closing Sukses !');
			$this->session->set_flashdata('status','1');
		}else{
			$this->db->trans_rollback();
			$this->session->set_flashdata('message','Failed connection into Databases, Please Contact Your Administrator !');
			$this->session->set_flashdata('status','0');
		}
		redirect("transaction/closing");
	}

	public function get_value_lap_rek_tab()
	{
		$cif_no 	= $this->input->post('cif_no');
		$data 		= $this->model_transaction->get_value_lap_rek_tab($cif_no);

		echo json_encode($data);
	}

	public function get_value_lap_rek_tab_for_cetak()
	{
		$account_saving_no 	= $this->input->post('account_saving_no');
		$data 				= $this->model_transaction->get_value_lap_rek_tab_for_cetak($account_saving_no);

		echo json_encode($data);
	}

	public function get_account_deposit()
	{
		$cif_no = $this->input->post('cif_no');
		$data 	= $this->model_transaction->get_account_deposit($cif_no);

		echo json_encode($data);
	}

	public function get_account_saving()
	{
		$cif_no = $this->input->post('cif_no');
		$data 	= $this->model_transaction->get_account_saving($cif_no);

		echo json_encode($data);
	}

	function get_account_saving_individu(){
		$cif_no = $this->input->post('cif_no');
		$data 	= $this->model_transaction->get_account_saving_individu($cif_no);

		echo json_encode($data);
	}

	public function search_account_deposit_no()
	{
		$keyword 	= $this->input->post('keyword');
		$cif_type 	= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_transaction->search_account_deposit_no($keyword,$cif_type,$cm_code);

		echo json_encode($data);
	}

	public function get_value_lap_rek_dep()
	{
		$cif_no = $this->input->post('cif_no');
		$data 	= $this->model_transaction->get_value_lap_rek_dep($cif_no);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// BEGIN PEMBAYARAN ANGSURAN
	/****************************************************************************************/
	public function pembayaran_angsuran()
	{
		$data['container'] 		= 'transaction/pembayaran_angsuran';
		$branch_code = $this->session->userdata('branch_code');
		$data['account_cash'] = $this->model_transaction->ajax_get_gl_account_cash_by_keyword('',$branch_code,'0');
		$this->load->view('core',$data);
	}

	public function get_cif_for_pembayaran_angsuran()
	{
		$account_financing_no 	= $this->input->post('account_financing_no');
		$data 					= $this->model_transaction->get_cif_for_pembayaran_angsuran($account_financing_no);
		// $current_date 			= $this->model_transaction->get_date_current();

		// $tgl     				=substr("$current_date",8,2);
	    // $bln     				=substr("$current_date",5,2);
	    // $thn	        		=substr("$current_date",0,4);
	    // $data['current_date']	= "$tgl/$bln/$thn";

		echo json_encode($data);
	}

	public function get_cif_for_pembayaran_angsuran_non_reguler()
	{
		$account_financing_no 	= $this->input->post('account_financing_no');
		$data 					= $this->model_transaction->get_cif_for_pembayaran_angsuran_non_reguler($account_financing_no);
		// $current_date 			= $this->model_transaction->get_date_current();

		// $tgl     				=substr("$current_date",8,2);
	    // $bln     				=substr("$current_date",5,2);
	    // $thn	        		=substr("$current_date",0,4);
	    // $data['current_date']	= "$tgl/$bln/$thn";

		echo json_encode($data);
	}

	public function get_flag_jadwal_angsuran()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_flag_jadwal_angsuran($account_financing_no);
		echo json_encode($data);
	}

	function proses_pembayaran_angsuran(){
		$account_financing_id = $this->input->post('account_financing_id');
		$account_financing_schedulle_id = $this->input->post('account_financing_schedulle_id');
		$account_saving_id 	  = $this->input->post('account_saving_id');
		$branch_id 		 	  = $this->input->post('branch_id');
		$no_rekening 		  = $this->input->post('no_rekening');
		$nama				  = $this->input->post('nama');
		$produk				  = $this->input->post('produk');
		$pokok_pembiayaan 	  = $this->convert_numeric($this->input->post('pokok_pembiayaan'));
		$margin_pembiayaan 	  = $this->convert_numeric($this->input->post('margin_pembiayaan'));
		$jangka_waktu 		  = $this->input->post('jangka_waktu');
		$pokok				  = $this->convert_numeric($this->input->post('pokok'));
		$margin				  = $this->convert_numeric($this->input->post('margin'));
		$cadangan_tabungan 	  = $this->convert_numeric($this->input->post('cadangan_tabungan'));
		$wajib 	  			  = $this->convert_numeric($this->input->post('wajib'));
		$kelompok 	  		  = $this->convert_numeric($this->input->post('kelompok'));
		$total_angsuran 	  = $this->convert_numeric($this->input->post('total_angsuran'));
		$jtempo_angsuran 	  = $this->input->post('jtempo_angsuran');
		$no_rek_tabungan 	  = $this->input->post('no_rek_tabungan');
		$freq_pembayaran 	  = $this->input->post('freq_pembayaran');
		$nominal_pembayaran   = $this->convert_numeric($this->input->post('nominal_pembayaran'));
		$tgl_bayar 			  = $this->input->post('tgl_bayar');
		$keterangan 		  = $this->input->post('keterangan');
		$cash_type 		  	  = $this->input->post('cash_type');
		$saldo_pokok 		  = $this->convert_numeric($this->input->post('saldo_pokok'));
		$saldo_memo 		  = $this->convert_numeric($this->input->post('saldo_memo'));
		$saldo_catab 		  = $this->convert_numeric($this->input->post('saldo_catab'));
		$saldo_margin 		  = $this->convert_numeric($this->input->post('saldo_margin'));
		$periode_jangka_waktu = $this->input->post('periode');
		$account_cash_code 	  = $this->input->post('account_cash_code');
		$bayar_pokok 		  = $this->convert_numeric($this->input->post('bayar_pokok'));
		$bayar_margin 		  = $this->convert_numeric($this->input->post('bayar_margin'));
		$bayar_pokok_before   = $this->input->post('bayar_pokok_before');
		$bayar_margin_before  = $this->input->post('bayar_margin_before');
		$counter_angsuran  	  = $this->input->post('counter_angsuran');

		$tgl_jtempo 		  = substr("$jtempo_angsuran",0,2);
	    $bln_jtempo 		  = substr("$jtempo_angsuran",3,2);
	    $thn_jtempo 		  = substr("$jtempo_angsuran",6,4);
	    $tglakhir_jtempo 	  = "$thn_jtempo-$bln_jtempo-$tgl_jtempo";  

		$tanggal_bayar 		  = substr("$tgl_bayar",0,2);
	    $bulan_bayar 		  = substr("$tgl_bayar",3,2);
	    $tahun_bayar 		  = substr("$tgl_bayar",6,4);
	    $tglakhir_bayar 	  = "$tahun_bayar-$bulan_bayar-$tanggal_bayar"; 

		if($periode_jangka_waktu=='0'){
			$tgl_angs_next = date('Y/m/d',strtotime($tglakhir_jtempo.'+'.$freq_pembayaran.' days'));
			$jto_date = date('Y/m/d',strtotime($tgl_angs_next.'- 1 days'));
		}else if($periode_jangka_waktu=='1'){
			$tgl_angs_next = date('Y/m/d',strtotime($tglakhir_jtempo.'+'.$freq_pembayaran.' weeks'));
			$jto_date = date('Y/m/d',strtotime($tgl_angs_next.'- 1 weeks'));
		}else{
			$tgl_angs_next = date('Y/m/d',strtotime($tglakhir_jtempo.'+'.$freq_pembayaran.' months'));
			$jto_date = date('Y/m/d',strtotime($tgl_angs_next.'- 1 months'));
		}

		$flag_jdwl_angsuran = $this->model_transaction->get_flag_jadwal($account_financing_id);

		$trx_detail_id = uuid(false);
		$trx_account_financing_id=uuid(false);

		$pokok = $pokok * $freq_pembayaran;
		$margin = $margin * $freq_pembayaran;
		$cadangan_tabungan = $cadangan_tabungan * $freq_pembayaran;
		$wajib = $wajib * $freq_pembayaran;
		$kelompok = $kelompok * $freq_pembayaran;

		if($flag_jdwl_angsuran=='1'){
			$data1 = array(
				 'branch_id'			=>$branch_id
				,'trx_account_financing_id'=>$trx_account_financing_id
				,'trx_detail_id'		=>$trx_detail_id
				,'account_financing_no'	=>$no_rekening
				,'trx_financing_type'	=>'1'
				,'trx_date'				=>$tglakhir_bayar
				,'jto_date'				=>$jto_date
				,'pokok'				=>$pokok
				,'margin'				=>$margin
				,'catab'				=>$cadangan_tabungan
				,'reference_no'			=>$no_rek_tabungan
				,'description'			=>$keterangan
				,'created_date'			=>date("Y-m-d H:i:s")
				,'created_by'			=>$this->session->userdata('user_id')
				,'trx_sequence'			=>0
				,'tab_wajib'			=>$wajib
				,'tab_kelompok'			=>$kelompok
				,'tab_sukarela'			=>0
				,'account_cash_code'	=> $account_cash_code
				,'freq'					=>$freq_pembayaran
				,'cash_type'			=>$cash_type
			);

			$param3 = array('account_saving_id'=>$account_saving_id);

			$data4 = array(
				 'branch_id'			=>$branch_id
				,'account_saving_no'	=>$no_rek_tabungan
				,'trx_account_saving_id'=>$trx_account_financing_id
				,'trx_saving_type'		=>3
				,'flag_debit_credit'	=>'D'
				,'trx_date'				=>$tglakhir_bayar
				,'amount'				=>$nominal_pembayaran
				,'reference_no'			=>$no_rekening
				,'description'			=>$keterangan
				,'created_date'			=>date("Y-m-d H:i:s")
				,'created_by'			=>$this->session->userdata('user_id')
				,'trx_detail_id'		=>$trx_detail_id
				,'trx_status'			=>1
			);

			$trx_sequence = $this->model_transaction->get_trx_sequence($no_rekening);

			$data5 = array(
				 'trx_detail_id'		=>$trx_detail_id
				,'trx_summary_id'		=>''
				,'trx_type'				=>3
				,'trx_account_type'		=>1
				,'account_no'			=>$no_rekening
				,'flag_debit_credit'	=>''
				,'amount'				=>$nominal_pembayaran
				,'trx_date'				=>$tglakhir_bayar
				,'reference_no'			=>''
				,'description'			=>$keterangan
				,'created_by'			=>$this->session->userdata('user_id')
				,'created_date'			=>date("Y-m-d H:i:s")
				,'account_no_dest'		=>$no_rek_tabungan
				,'trx_sequence'			=>$trx_sequence
				,'account_type_dest'	=>1
			);

			$this->db->trans_begin();
			$this->model_transaction->insert_mfi_trx_account_financing($data1);
			if($cash_type == '1'){
				// PINBUK
				$this->model_transaction->insert_mfi_trx_account_saving($data4);
			}

			$this->model_transaction->insert_on_mfi_trx_detail($data5);
		}else{
			$data1 = array(
				 'branch_id'			=>$branch_id
				,'trx_account_financing_id'=>$trx_account_financing_id
				,'trx_detail_id'		=>$trx_detail_id
				,'account_financing_no'	=>$no_rekening
				,'trx_financing_type'	=>'1'
				,'trx_date'				=>$tglakhir_bayar
				,'jto_date'				=>$tglakhir_jtempo
				,'pokok'				=>$bayar_pokok
				,'margin'				=>$bayar_margin
				,'catab'				=>$cadangan_tabungan
				,'reference_no'			=>$no_rek_tabungan
				,'description'			=>$keterangan
				,'created_date'			=>date("Y-m-d H:i:s")
				,'created_by'			=>$this->session->userdata('user_id')
				,'trx_sequence'			=>0
				,'tab_wajib'			=>$wajib
				,'tab_kelompok'			=>$kelompok
				,'tab_sukarela'			=>0
				,'freq'					=>$freq_pembayaran
				,'account_cash_code'	=> $account_cash_code
				,'cash_type'			=> $cash_type
			);


			$data3 = array(
				 'saldo_memo'			=>($saldo_memo-$total_angsuran)
			);

			$param3 = array('account_saving_id'=>$account_saving_id);

			$data4 = array(
				 'branch_id'			=>$branch_id
				,'account_saving_no'	=>$no_rek_tabungan
				,'trx_account_saving_id'=>$trx_account_financing_id
				,'trx_saving_type'		=>3
				,'flag_debit_credit'	=>'D'
				,'trx_date'				=>$tglakhir_bayar
				,'amount'				=>$nominal_pembayaran
				,'reference_no'			=>$no_rekening
				,'description'			=>$keterangan
				,'created_date'			=>date("Y-m-d H:i:s")
				,'created_by'			=>$this->session->userdata('user_id')
				,'trx_detail_id'		=>$trx_detail_id
				,'trx_status'		=>1
			);

			$trx_sequence = $this->model_transaction->get_trx_sequence($no_rekening);

			$data5 = array(
				 'trx_detail_id'		=>$trx_detail_id
				,'trx_summary_id'		=>''
				,'trx_type'				=>3
				,'trx_account_type'		=>1
				,'account_no'			=>$no_rekening
				,'flag_debit_credit'	=>''
				,'amount'				=>$nominal_pembayaran
				,'trx_date'				=>$tglakhir_bayar
				,'reference_no'			=>''
				,'description'			=>$keterangan
				,'created_by'			=>$this->session->userdata('user_id')
				,'created_date'			=>date("Y-m-d H:i:s")
				,'account_no_dest'		=>$no_rek_tabungan
				,'trx_sequence'			=>$trx_sequence
				,'account_type_dest'	=>1
			);

			$data6 = array(
				 'bayar_pokok'			=>($bayar_pokok_before+$bayar_pokok)
				,'bayar_margin'			=>($bayar_margin_before+$bayar_margin)
				,'tanggal_bayar'	    =>$tglakhir_bayar
				);

			if(($bayar_pokok_before+$bayar_pokok)==$pokok && ($bayar_margin_before+$bayar_margin)==$margin){
				$data6['status_angsuran'] = 1;
			}else{
				$data6['status_angsuran'] = 0;
			}

			$param6 = array('account_financing_schedulle_id'=>$account_financing_schedulle_id);

			$this->db->trans_begin();
			$this->model_transaction->insert_mfi_trx_account_financing($data1);
			if($cash_type == '1'){
				// PINBUK
				$this->model_transaction->insert_mfi_trx_account_saving($data4);
			}
			
			$this->model_transaction->insert_on_mfi_trx_detail($data5);
			$this->model_transaction->update_on_financing_schedulle($data6,$param6);
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/	
	// BEGIN VERIFIKASI TRANSAKSI
	/****************************************************************************************/
	
	function verifikasi_transaksi(){
		$data['container'] = 'transaction/verifikasi_transaksi';
		$this->load->view('core',$data);
	}

	public function grid_verifikasi_transaksi()
	{
		$page 			= isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows 	= isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx 			= isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'cif_no';//1
		$sort 			= isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$account_no 	= isset($_REQUEST['account_no'])?$_REQUEST['account_no']:'';
		$jenis_transaksi= isset($_REQUEST['jenis_transaksi'])?$_REQUEST['jenis_transaksi']:'';
		
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		if($jenis_transaksi=='all'){
			$result = $this->model_transaction->grid_verifikasi_transaksi('','','','',$account_no);
		}else if($jenis_transaksi=='1'){ // TABUNGAN
			$result = $this->model_transaction->grid_verifikasi_transaksi_tabungan('','','','',$account_no);
		}else if($jenis_transaksi=='2'){ // PEMBIAYAAN
			$result = $this->model_transaction->grid_verifikasi_transaksi_pembiayaan('','','','',$account_no);
		}else if($jenis_transaksi=='3'){ // DEPOSITO
			$result = $this->model_transaction->grid_verifikasi_transaksi_deposito('','','','',$account_no);
		}

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		if($jenis_transaksi=='all'){
			$result = $this->model_transaction->grid_verifikasi_transaksi($sidx,$sort,$limit_rows,$start,$account_no);
		}else if($jenis_transaksi=='1'){ // TABUNGAN
			$result = $this->model_transaction->grid_verifikasi_transaksi_tabungan($sidx,$sort,$limit_rows,$start,$account_no);
		}else if($jenis_transaksi=='2'){ // PEMBIAYAAN
			$result = $this->model_transaction->grid_verifikasi_transaksi_pembiayaan($sidx,$sort,$limit_rows,$start,$account_no);
		}else if($jenis_transaksi=='3'){ // DEPOSITO
			$result = $this->model_transaction->grid_verifikasi_transaksi_deposito($sidx,$sort,$limit_rows,$start,$account_no);
		}

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$jumlah = $row['jumlah'];
			$keterangan = $row['keterangan'];
			if($row['jenis_transaksi']=='Tabungan'){
				switch ($keterangan) {
					case '1':
						$keterangan='SETORAN TUNAI';
						break;
					case '2':
						$keterangan='PENARIKAN TUNAI';
						break;
					case '3':
						$keterangan='PEMINDAH BUKUAN KELUAR';
						break;
					case '7':
						$keterangan='DENDA ANGSURAN';
						break;
					default:
						$keterangan='PEMINDAH BUKUAN MASUK';
						break;
				}
			}else if($row['jenis_transaksi']=='Pembiayaan'){
				switch ($keterangan) {
					case '0':
						$keterangan='DROPING';
						break;
					case '1':
						$keterangan='ANGSURAN';
						break;
					case '2':
						$keterangan='PELUNASAN';
						break;
				}
			}else if($row['jenis_transaksi']=='Deposito'){
				switch ($keterangan) {
					case '0':
						$keterangan='PEMBUKAAN';
						break;
					case '2':
						$keterangan='PENCAIRAN';
						break;
				}
			}

			if($jumlah != 0){
				$responce['rows'][$i]['id_transaksi']=$row['id_transaksi'];
			    $responce['rows'][$i]['cell']=array(
				    $row['id_transaksi']
				    ,$row['jenis_transaksi']
				    ,$row['tgl_transaksi']
				    ,$row['no_rekening']
				    ,$row['nama_cif']
				    ,$row['cm_name']
				    ,$row['account_cash_name']
				    ,$jumlah
				    ,$keterangan
			    );

			    $i++;
			}
		}

		echo json_encode($responce);
	}

	public function get_no_rekening()
	{
		$keyword 	= $this->input->post('keyword');
		$data 		= $this->model_transaction->get_no_rekening($keyword);

		echo json_encode($data);
	}

	function aktivasi_transaksi(){
		$id 	= $this->input->post('id');
		$jenis 	= $this->input->post('jenis');
		$account_no = $this->input->post('account_no');
		$keterangan = $this->input->post('keterangan');
		
		$this->db->trans_begin();

		if($jenis=="Tabungan"){
			$data_trx_account_saving = $this->model_transaction->get_data_trx_account_saving_by_id($id);
			$data_account_saving = $this->model_transaction->get_data_account_saving_by_account_no($account_no);
			$trx_type = $data_trx_account_saving['trx_saving_type'];


			if ($trx_type == '1') { //setoran
				$saldo_memo=$data_account_saving['saldo_memo']+$data_trx_account_saving['amount'];
				$saldo_riil=$saldo_memo;
			} else if ($trx_type == '2') { //penarikan tunai
				$saldo_memo=$data_account_saving['saldo_memo']-$data_trx_account_saving['amount'];
				$saldo_riil=$saldo_memo;
			} else if ($trx_type == '3') { //pemindah bukuan keluar
				$saldo_memo=$data_account_saving['saldo_memo']-$data_trx_account_saving['amount'];
				$saldo_riil=$saldo_memo;
			} else if ($trx_type == '4') { //pemindah bukuan masuk
				$saldo_memo=$data_account_saving['saldo_memo']+$data_trx_account_saving['amount'];
				$saldo_riil=$saldo_memo;
			} else {
				$saldo_memo=$data_account_saving['saldo_memo'];
				$saldo_riil=$saldo_memo;
			}

			$trx_gl_cash = uuid(FALSE);
			$trx_voucher_date = $data_trx_account_saving['trx_date'];
			$account_cash_teller_code = $data_trx_account_saving['account_cash_code'];
			$voucher_ref = $data_trx_account_saving['account_saving_no'];
			$created_by = $this->session->userdata('user_id');
			$created_date = date('Y-m-d H:i:s');
			$amount = $data_trx_account_saving['amount'];
			$status = '1';
			// INSERT trx_gl_cash
			if($keterangan == 'SETORAN TUNAI'){
				$trx_gl_cash_type = 5;
				$flag_debet_credit = 'D';
				
				$data = array(
					'trx_gl_cash_id' =>  $trx_gl_cash,
					'trx_date' => $trx_voucher_date,
					'account_cash_code' => $account_cash_teller_code,
					'trx_gl_cash_type' => $trx_gl_cash_type,
					'flag_debet_credit' => $flag_debet_credit,
					'account_teller_code' => $account_cash_teller_code,
					'voucher_date' => $trx_voucher_date,
					'voucher_ref' => $voucher_ref,
					'description' => $keterangan,
					'created_by' => $created_by,
					'created_date' => $created_date,
					'amount' => $amount,
					'status' => '1'
				);
				
				$this->model_transaction->insert_trx_gl_cash($data);
			} else if($keterangan == 'PENARIKAN TUNAI'){
				$trx_gl_cash_type = 6;
				$flag_debet_credit = 'C';

				$data = array(
					'trx_gl_cash_id' =>  $trx_gl_cash,
					'trx_date' => $trx_voucher_date,
					'account_cash_code' => $account_cash_teller_code,
					'trx_gl_cash_type' => $trx_gl_cash_type,
					'flag_debet_credit' => $flag_debet_credit,
					'account_teller_code' => $account_cash_teller_code,
					'voucher_date' => $trx_voucher_date,
					'voucher_ref' => $voucher_ref,
					'description' => $keterangan,
					'created_by' => $created_by,
					'created_date' => $created_date,
					'amount' => $amount,
					'status' => '1'
				);
				
				$this->model_transaction->insert_trx_gl_cash($data);
			}

			$data_tab=array('saldo_memo'=>$saldo_memo,'saldo_riil'=>$saldo_riil);
			$param_tab=array('account_saving_no'=>$account_no);

			$data   = array('verify_by'=>$this->session->userdata('user_id'),'verify_date'=>date('Y-m-d H:i:s'),'trx_status'=>'1');
			$param 	= array('trx_account_saving_id'=>$id);

			$this->model_transaction->aktivasi_transaksi_saving($data,$param);
			$this->model_transaction->update_account_saving($data_tab,$param_tab);
			
			$this->model_transaction->fn_jurnal_trx_saving($id);
		}

		if($jenis=="Pembiayaan"){
			$data_trx_account_financing = $this->model_transaction->get_data_trx_account_financing_by_id($id);

			$trx_detail_id = $data_trx_account_financing['trx_detail_id'];
			$cash_type = $data_trx_account_financing['cash_type'];

			$trx_gl_cash = uuid(FALSE);
			$trx_voucher_date = $data_trx_account_financing['trx_date'];
			$account_cash_teller_code = $data_trx_account_financing['account_cash_code'];
			$voucher_ref = $data_trx_account_financing['account_financing_no'];
			$created_by = $this->session->userdata('user_id');
			$created_date = date('Y-m-d H:i:s');
			$amount = $data_trx_account_financing['pokok'] + $data_trx_account_financing['margin'] + $data_trx_account_financing['catab'] + $data_trx_account_financing['tab_wajib'] + $data_trx_account_financing['tab_kelompok'];
			$status = '1';
			
			$data_trx_detail = $this->model_transaction->get_data_trx_detail_by_id($trx_detail_id);

			$account_financing_no = $account_no;

			$data_account_financing = $this->model_transaction->get_data_account_financing_by_account_no($account_financing_no);

			$data_account_financing_new = $this->model_transaction->get_data_account_financing_by_account_no_new($account_financing_no);


			$flag_jadwal_angsuran = $data_account_financing['flag_jadwal_angsuran'];
			$periode_jangka_waktu = $data_account_financing['periode_jangka_waktu'];
			$jtempo_angsuran_last = $data_trx_account_financing['jto_date'];
			$jtempo_angsuran_next = $data_account_financing['jtempo_angsuran_next'];
			$jangka_waktu = $data_account_financing['jangka_waktu'];

			$nama = $data_account_financing_new['nama'];
			$cm_name = $data_account_financing_new['cm_name'];

			$financing_schedulle_data = array();

			// collect data for $financing_data
			$saldo_pokok = $data_account_financing['saldo_pokok'] - $data_trx_account_financing['pokok'];
			$saldo_margin = $data_account_financing['saldo_margin'] - $data_trx_account_financing['margin'];
			$saldo_catab = $data_account_financing['saldo_catab'] + $data_trx_account_financing['catab'];


			if ($data_account_financing['flag_jadwal_angsuran']=='1') {
				$counter_angsuran = $data_trx_account_financing['freq'] + $data_account_financing['counter_angsuran'];

				if ($periode_jangka_waktu=='0') {
					$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_last.' +1 days'));
				} else if ($periode_jangka_waktu=='1') {
					$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_last.' +7 days'));
				} else if ($periode_jangka_waktu=='2') {
					$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_last.' +1 months'));
				} else if ($periode_jangka_waktu=='3') {
					$jtempo_angsuran_next = $data_account_financing['tangal_jtempo'];
				}
			} else {
				$data_account_financing_schedulle = $this->model_transaction->get_data_account_financing_schedulle_by_account_no($account_financing_no);
				$last_counter_angsuran = $this->model_transaction->get_last_counter_angsuran_by_account_financing_no($account_financing_no);
				$angsuran_pokok = $data_account_financing_schedulle['angsuran_pokok'];
				$angsuran_margin = $data_account_financing_schedulle['angsuran_margin'];
				$angsuran_tabungan = $data_account_financing_schedulle['angsuran_tabungan'];
				$bayar_pokok = $data_account_financing_schedulle['bayar_pokok'];
				$bayar_margin = $data_account_financing_schedulle['bayar_margin'];
				$bayar_tabungan = $data_account_financing_schedulle['bayar_tabungan'];
				$least_angsuran_pokok = $angsuran_pokok-($bayar_pokok+$data_trx_account_financing['pokok']);
				$least_angsuran_margin = $angsuran_margin-($bayar_margin+$data_trx_account_financing['margin']);
				$least_angsuran_tabungan = $angsuran_tabungan-($bayar_tabungan+$data_trx_account_financing['catab']);
				$account_financing_schedulle_id = $data_account_financing_schedulle['account_financing_schedulle_id'];

				$financing_schedulle_data = array(
					 'bayar_pokok'=>$bayar_pokok+$data_trx_account_financing['pokok']
					,'bayar_margin'=>$bayar_margin+$data_trx_account_financing['margin']
					,'tanggal_bayar'=>$data_trx_account_financing['trx_date']
				);
				if ($least_angsuran_pokok==0 && $least_angsuran_margin==0 && $least_angsuran_tabungan==0) {
					$counter_angsuran = $last_counter_angsuran+1;
					$jtempo_angsuran_next = $this->model_transaction->get_jtempo_angsuran_next_schedulle($account_financing_no);
					if ($jtempo_angsuran_next==false) {
						$jtempo_angsuran_next = $data_account_financing['tanggal_jtempo'];
					}
					$financing_schedulle_data['status_angsuran'] = 1;
				} else {
					$counter_angsuran = $data_account_financing['counter_angsuran'];
				}
				$financing_schedulle_param = array('account_financing_schedulle_id'=>$account_financing_schedulle_id);

			}

			$iJto = 1;
			do {
				$cekHariLibur = $this->model_transaction->cekHariLibur($jtempo_angsuran_next);
				// var_dump($cekHariLibur);
				if ($cekHariLibur==true) {
					if($periode_jangka_waktu==0){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +1 days'));
					}else if($periode_jangka_waktu==1){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +1 weeks'));
					}else if($periode_jangka_waktu==2){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +1 month'));
					}else if($periode_jangka_waktu==3){
						$jtempo_angsuran_next = $tanggal_jtempo;
					}
					$iJto++;
				} else {
					break;
				}
			} while ($iJto > 1);

			$financing_data = array(
					'saldo_pokok'=>$saldo_pokok
					,'saldo_margin'=>$saldo_margin
					,'saldo_catab'=>$saldo_catab
					,'counter_angsuran'=>$counter_angsuran
					,'jtempo_angsuran_last'=>$jtempo_angsuran_last
					,'jtempo_angsuran_next'=>$jtempo_angsuran_next
			);

			if($jangka_waktu == $counter_angsuran){
				$financing_data['status_rekening'] = 2;
			}

			$financing_param = array('account_financing_no'=>$account_financing_no);

			$trx_financing_data   = array('verify_by'=>$this->session->userdata('user_id'),'verify_date'=>date('Y-m-d H:i:s'),'trx_status'=>'1');
			$trx_financing_param  = array('trx_account_financing_id'=>$id);
			$this->model_transaction->aktivasi_transaksi_financing($trx_financing_data,$trx_financing_param);

			$trx_gl_cash_type = 5;
			$flag_debet_credit = 'D';
			
			// INSERT mfi_trx_gl_cash
			$data = array(
				'trx_gl_cash_id' =>  $trx_gl_cash,
				'trx_date' => $trx_voucher_date,
				'account_cash_code' => $account_cash_teller_code,
				'trx_gl_cash_type' => $trx_gl_cash_type,
				'flag_debet_credit' => $flag_debet_credit,
				'account_teller_code' => $account_cash_teller_code,
				'voucher_date' => $trx_voucher_date,
				'voucher_ref' => $voucher_ref,
				'description' => 'SETORAN INDIVIDU A.N '.$nama.' MAJELIS '.$cm_name.'',
				'created_by' => $created_by,
				'created_date' => $created_date,
				'amount' => $amount,
				'status' => '1'
			);
			
			if($cash_type == '0'){
				$this->model_transaction->insert_trx_gl_cash($data);
				$this->model_transaction->fn_proses_jurnal_angsuran_pyd_cash($id);
			} else {
				// update saldo_memo dan saldo_riil
				$account_saving_no = $data_account_financing['account_saving_no'];
				$get_saving = $this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no);
				$data_trx_account_saving = $this->model_transaction->get_data_trx_account_saving_by_id($id);
				$saving_data = array(
					'saldo_riil' => $get_saving['saldo_riil'] - $data_trx_account_saving['amount'],
					'saldo_memo' => $get_saving['saldo_memo'] - $data_trx_account_saving['amount'],
					'status_rekening' => 2
				);
				$param_saving_no = array('account_saving_no' => $account_saving_no);
				$this->model_transaction->edit_rekening_tabungan($saving_data,$param_saving_no);
				$this->model_transaction->fn_proses_jurnal_angsuran_pyd_pinbuk($id);
			}

			$this->model_transaction->update_mfi_account_financing($financing_data,$financing_param);
			if (count($financing_schedulle_data)>0) {
				$this->model_transaction->update_on_financing_schedulle($financing_schedulle_data,$financing_schedulle_param);
			}
		}

		if($jenis=="SMK"){
			$data   = array('verify_by'=>$this->session->userdata('user_id'),'verify_date'=>date('Y-m-d H:i:s'),'trx_status'=>'1');
			$param 	= array('trx_smk_id'=>$id);
			$this->model_transaction->aktivasi_transaksi_smk($data,$param);
		}

		if($jenis == 'Deposito'){
			$call_deposito = $this->model_transaction->call_deposito_by_deposit_no($account_no);
			$trx_deposit_type = $call_deposito['trx_deposit_type'];

			$data_trx_deposito = array('trx_status' => '1');
			$param_deposito = array('account_deposit_no' => $account_no);
			$this->model_transaction->update_trx_deposito($data_trx_deposito,$param_deposito);

			if($trx_deposit_type == '0'){
				$data_deposito = array('status_rekening' => '1');

				// JURNAL PEMBUKAAN
				$this->model_transaction->fn_jurnal_pembukaan_deposito($account_no);
			} else if($trx_deposit_type == '2'){
				$data_deposito = array('status_rekening' => '2');

				// JURNAL PENCAIRAN
				$this->model_transaction->fn_jurnal_pencairan_deposito($account_no);
			}

			$this->model_transaction->edit_deposit($data_deposito,$param_deposito);
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function aktivasi_transaksi_new(){
		$id = $this->input->post('id');
		$jenis = $this->input->post('jenis');
		$account_no = $this->input->post('account_no');
		$keterangan = $this->input->post('keterangan');
		
		if($jenis == 'Tabungan'){
			$data_trx_account_saving = $this->model_transaction->get_data_trx_account_saving_by_id($id);
			$data_account_saving = $this->model_transaction->get_data_account_saving_by_account_no($account_no);
			$trx_type = $data_trx_account_saving['trx_saving_type'];
			$nama_saving = $data_account_saving['nama'];
			$majlis_saving = $data_account_saving['cm_name'];

			if ($trx_type == '1') {
				$saldo_memo = $data_account_saving['saldo_memo']+$data_trx_account_saving['amount'];
				$saldo_riil = $saldo_memo;
			} else if ($trx_type == '2') {
				$saldo_memo = $data_account_saving['saldo_memo']-$data_trx_account_saving['amount'];
				$saldo_riil = $saldo_memo;
			} else if ($trx_type == '3') {
				$saldo_memo = $data_account_saving['saldo_memo']-$data_trx_account_saving['amount'];
				$saldo_riil = $saldo_memo;
			} else if ($trx_type == '4') {
				$saldo_memo = $data_account_saving['saldo_memo']+$data_trx_account_saving['amount'];
				$saldo_riil = $saldo_memo;
			} else {
				$saldo_memo = $data_account_saving['saldo_memo'];
				$saldo_riil = $saldo_memo;
			}

			$trx_gl_cash = uuid(FALSE);
			$trx_voucher_date = $data_trx_account_saving['trx_date'];
			$account_cash_teller_code = $data_trx_account_saving['account_cash_code'];
			$voucher_ref = $data_trx_account_saving['account_saving_no'];
			$created_by = $this->session->userdata('user_id');
			$created_date = date('Y-m-d H:i:s');
			$amount = $data_trx_account_saving['amount'];
			$status = '1';

			if($keterangan == 'SETORAN TUNAI'){
				$trx_gl_cash_type = 5;
				$flag_debet_credit = 'D';
				
				$data_setoran_tunai = array(
					'trx_gl_cash_id' => $trx_gl_cash,
					'trx_date' => $trx_voucher_date,
					'account_cash_code' => $account_cash_teller_code,
					'trx_gl_cash_type' => $trx_gl_cash_type,
					'flag_debet_credit' => $flag_debet_credit,
					'account_teller_code' => $account_cash_teller_code,
					'voucher_date' => $trx_voucher_date,
					'voucher_ref' => $voucher_ref,
					'description' => 'SETOR TUNAI '.$nama_saving.' - '.$majlis_saving,
					'created_by' => $created_by,
					'created_date' => $created_date,
					'amount' => $amount,
					'status' => '1'
				);
			} else if($keterangan == 'PENARIKAN TUNAI'){
				$trx_gl_cash_type = 6;
				$flag_debet_credit = 'C';

				$data_tarikan_tunai = array(
					'trx_gl_cash_id' => $trx_gl_cash,
					'trx_date' => $trx_voucher_date,
					'account_cash_code' => $account_cash_teller_code,
					'trx_gl_cash_type' => $trx_gl_cash_type,
					'flag_debet_credit' => $flag_debet_credit,
					'account_teller_code' => $account_cash_teller_code,
					'voucher_date' => $trx_voucher_date,
					'voucher_ref' => $voucher_ref,
					'description' => 'TARIK TUNAI '.$nama_saving.' - '.$majlis_saving,
					'created_by' => $created_by,
					'created_date' => $created_date,
					'amount' => $amount,
					'status' => '1'
				);
			}

			$data_tabungan = array(
				'saldo_memo' => $saldo_memo,
				'saldo_riil' => $saldo_riil
			);

			$param_tabungan = array('account_saving_no' => $account_no);

			$data_histori_tabungan = array(
				'verify_by' => $created_by,
				'verify_date' => $created_date,
				'trx_status' => '1'
			);

			$param_histori_tabungan = array('trx_account_saving_id' => $id);
		} else if($jenis == 'Pembiayaan'){
			$data_trx_account_financing = $this->model_transaction->get_data_trx_account_financing_by_id($id);

			$trx_detail_id = $data_trx_account_financing['trx_detail_id'];
			$cash_type = $data_trx_account_financing['cash_type'];

			$trx_gl_cash = uuid(FALSE);
			$trx_voucher_date = $data_trx_account_financing['trx_date'];
			$account_cash_teller_code = $data_trx_account_financing['account_cash_code'];
			$voucher_ref = $data_trx_account_financing['account_financing_no'];
			$created_by = $this->session->userdata('user_id');
			$created_date = date('Y-m-d H:i:s');
			$freq_bayar = $data_trx_account_financing['freq']; 
			$amount = $data_trx_account_financing['pokok'] + $data_trx_account_financing['margin'] + $data_trx_account_financing['catab'] + $data_trx_account_financing['tab_wajib'] + $data_trx_account_financing['tab_kelompok'];
			$status = '1';
			
			$data_trx_detail = $this->model_transaction->get_data_trx_detail_by_id($trx_detail_id);

			$account_financing_no = $account_no;

			$data_account_financing = $this->model_transaction->get_data_account_financing_by_account_no($account_financing_no);

			$data_account_financing_new = $this->model_transaction->get_data_account_financing_by_account_no_new($account_financing_no);

			$flag_jadwal_angsuran = $data_account_financing['flag_jadwal_angsuran'];
			$tanggal_akad 		  = $data_account_financing['tanggal_akad'];
			$periode_jangka_waktu = $data_account_financing['periode_jangka_waktu'];
			$jtempo_angsuran_last = $data_trx_account_financing['jto_date'];
			$jtempo_angsuran_next = $data_account_financing['jtempo_angsuran_next'];
			$jangka_waktu 		  = $data_account_financing['jangka_waktu']; 
			$angsuran_pokok       = $data_account_financing['angsuran_pokok']; 
			$angsuran_margin       = $data_account_financing['angsuran_margin'];

			$nama = $data_account_financing_new['nama'];
			$cm_name = $data_account_financing_new['cm_name'];

			$financing_schedulle_data = array();

			///$saldo_pokok = $data_account_financing['saldo_pokok'] - $data_trx_account_financing['pokok'];
			///$saldo_margin = $data_account_financing['saldo_margin'] - $data_trx_account_financing['margin'];
			$saldo_catab = $data_account_financing['saldo_catab'] + $data_trx_account_financing['catab'];

			/**	
			if($data_account_financing['flag_jadwal_angsuran'] == '1'){
				$counter_angsuran = $data_trx_account_financing['freq'] + $data_account_financing['counter_angsuran'];
				if($periode_jangka_waktu == '0'){
					$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_last.' + 1 DAY'));
				} else if ($periode_jangka_waktu == '1'){
					$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_last.' + 1 WEEK'));
				} else if ($periode_jangka_waktu == '2'){
					$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_last.' + 1 MONTH'));
				} else if ($periode_jangka_waktu == '3'){
					$jtempo_angsuran_next = $data_account_financing['tangal_jtempo'];
				}
			} 
			**/ 
			///$data_account_financing['margin'] - $data_bayar_angs_idvidu['margin'];

			if($data_account_financing['flag_jadwal_angsuran'] == '1'){ 

				$data_bayar_angs_idvidu = $this->model_transaction->get_data_bayar_angs_idvidu($account_financing_no,$tanggal_akad);
				$counter_angsuran 		= $data_bayar_angs_idvidu['freq']+$data_trx_account_financing['freq']; 
				$sisa_counter_angsuran  = $jangka_waktu-$counter_angsuran;
				$saldo_pokok 			= $sisa_counter_angsuran*$angsuran_pokok;
				$saldo_margin 			= $sisa_counter_angsuran*$angsuran_margin;
				
				///$get_counter_angsuran = $this->model_transaction->get_counter_angsuran_idvidu($account_financing_no,$tanggal_akad);
				///$counter_angsuran = $data_trx_account_financing['freq'] + $get_counter_angsuran;
				$jtempo_angsuran_last = $this->model_transaction->get_jtempo_angsuran_last($account_financing_no,$freq_bayar);  
				
				

				if($periode_jangka_waktu == '0'){
					$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_last.' + 1 DAY'));
				} else if ($periode_jangka_waktu == '1'){
					$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_last.' + 1 WEEK'));
				} else if ($periode_jangka_waktu == '2'){
					$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_last.' + 1 MONTH'));
				} else if ($periode_jangka_waktu == '3'){
					$jtempo_angsuran_next = $data_account_financing['tangal_jtempo'];
				}								
			
				$iJto = 1;

				if($periode_jangka_waktu == '1' or $periode_jangka_waktu == '0'){
					do {
						$cekHariLibur = $this->model_transaction->cekHariLibur($jtempo_angsuran_next);

						if($cekHariLibur == TRUE) {
							if($periode_jangka_waktu == '0'){
								$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_next.' + 1 DAY'));
							} else if($periode_jangka_waktu == '1'){
								$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_next.' + 1 WEEK'));
							}

							$iJto++;
						} else {
							break;
						}
					} while ($iJto > 1);
				}

			}


			else {
				$data_account_financing_schedulle = $this->model_transaction->get_data_account_financing_schedulle_by_account_no($account_financing_no);
				$last_counter_angsuran = $this->model_transaction->get_last_counter_angsuran_by_account_financing_no($account_financing_no);
				$angsuran_pokok = $data_account_financing_schedulle['angsuran_pokok'];
				$angsuran_margin = $data_account_financing_schedulle['angsuran_margin'];
				$angsuran_tabungan = $data_account_financing_schedulle['angsuran_tabungan'];
				$bayar_pokok = $data_account_financing_schedulle['bayar_pokok'];
				$bayar_margin = $data_account_financing_schedulle['bayar_margin'];
				$bayar_tabungan = $data_account_financing_schedulle['bayar_tabungan'];
				$least_angsuran_pokok = $angsuran_pokok-($bayar_pokok+$data_trx_account_financing['pokok']);
				$least_angsuran_margin = $angsuran_margin-($bayar_margin+$data_trx_account_financing['margin']);
				$least_angsuran_tabungan = $angsuran_tabungan-($bayar_tabungan+$data_trx_account_financing['catab']);
				$account_financing_schedulle_id = $data_account_financing_schedulle['account_financing_schedulle_id'];

				$financing_schedulle_data = array(
					'bayar_pokok'=> $bayar_pokok + $data_trx_account_financing['pokok'],
					'bayar_margin'=> $bayar_margin + $data_trx_account_financing['margin'],
					'tanggal_bayar'=> $data_trx_account_financing['trx_date']
				);

				if ($least_angsuran_pokok==0 && $least_angsuran_margin==0 && $least_angsuran_tabungan==0) {
					$counter_angsuran = $last_counter_angsuran+1;
					$jtempo_angsuran_next = $this->model_transaction->get_jtempo_angsuran_next_schedulle($account_financing_no);

					if ($jtempo_angsuran_next==false) {
						$jtempo_angsuran_next = $data_account_financing['tanggal_jtempo'];
					}

					$financing_schedulle_data['status_angsuran'] = 1;
				} else {
					$counter_angsuran = $data_account_financing['counter_angsuran'];
				}

				$financing_schedulle_param = array('account_financing_schedulle_id'=>$account_financing_schedulle_id);
			}


			$financing_data = array(
					'saldo_pokok'=>$saldo_pokok
					,'saldo_margin'=>$saldo_margin
					,'saldo_catab'=>$saldo_catab
					,'counter_angsuran'=>$counter_angsuran
					,'jtempo_angsuran_last'=>$jtempo_angsuran_last
					,'jtempo_angsuran_next'=>$jtempo_angsuran_next
			);

			if($jangka_waktu == $counter_angsuran){
				$financing_data['status_rekening'] = 2;
			}

			$financing_param = array('account_financing_no'=>$account_financing_no);

			$trx_financing_data = array(
				'verify_by' => $this->session->userdata('user_id'),
				'verify_date' => date('Y-m-d H:i:s'),
				'trx_status' => '1'
			);

			$trx_financing_param  = array('trx_account_financing_id' => $id);

			$trx_gl_cash_type = 5;
			$flag_debet_credit = 'D';
			
			// INSERT mfi_trx_gl_cash
			$data_setoran_cash = array(
				'trx_gl_cash_id' =>  $trx_gl_cash,
				'trx_date' => $trx_voucher_date,
				'account_cash_code' => $account_cash_teller_code,
				'trx_gl_cash_type' => $trx_gl_cash_type,
				'flag_debet_credit' => $flag_debet_credit,
				'account_teller_code' => $account_cash_teller_code,
				'voucher_date' => $trx_voucher_date,
				'voucher_ref' => $voucher_ref,
				'description' => 'SETORAN INDIVIDU A.N '.$nama.' MAJELIS '.$cm_name.'',
				'created_by' => $created_by,
				'created_date' => $created_date,
				'amount' => $amount,
				'status' => '1'
			);
			
			if($cash_type == '1'){
				// update saldo_memo dan saldo_riil
				$account_saving_no = $data_account_financing['account_saving_no'];
				$get_saving = $this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no);
				$data_trx_account_saving = $this->model_transaction->get_data_trx_account_saving_by_id($id);
				$saving_data = array(
					'saldo_riil' => $get_saving['saldo_riil'] - $data_trx_account_saving['amount'],
					'saldo_memo' => $get_saving['saldo_memo'] - $data_trx_account_saving['amount'],
					'status_rekening' => 2
				);

				$param_saving_no = array('account_saving_no' => $account_saving_no);
			}
		} else if($jenis == 'SMK'){
			$data_smk = array(
				'verify_by' => $this->session->userdata('user_id'),
				'verify_date' => date('Y-m-d H:i:s'),
				'trx_status' => '1'
			);

			$param_smk = array('trx_smk_id' => $id);
		} else if($jenis == 'Deposito') {
			$call_deposito = $this->model_transaction->call_deposito_by_deposit_no($account_no);
			$trx_deposit_type = $call_deposito['trx_deposit_type'];

			$data_trx_deposito = array('trx_status' => '1');
			$param_deposito = array('account_deposit_no' => $account_no);

			if($trx_deposit_type == '0'){
				$data_deposito = array('status_rekening' => '1');
			} else if($trx_deposit_type == '2'){
				$data_deposito = array('status_rekening' => '2');
			}
		}

		// BEGIN TRANSACTION
		$this->db->trans_begin();

		if($jenis == 'Tabungan'){
			// UPDATE DATA HISTORI DAN MASTER TABUNGAN
			$this->model_transaction->aktivasi_transaksi_saving($data_histori_tabungan,$param_histori_tabungan);
			$this->model_transaction->update_account_saving($data_tabungan,$param_tabungan);

			// BUAT JURNAL
			$this->model_transaction->fn_jurnal_trx_saving($id); 
			
			if($keterangan == 'SETORAN TUNAI'){
				// INSERT mfi_trx_gl_cash
				$this->model_transaction->insert_trx_gl_cash($data_setoran_tunai);
			} else {
				// INSERT mfi_trx_gl_cash
				$this->model_transaction->insert_trx_gl_cash($data_tarikan_tunai);
			}

		} else if($jenis == 'Pembiayaan'){
			// UPDATE DATA HISTORI PEMBIAYAAN
			$this->model_transaction->aktivasi_transaksi_financing($trx_financing_data,$trx_financing_param);

			if($cash_type == '0'){
				// BUAT JURNAL
				$this->model_transaction->fn_proses_jurnal_angsuran_pyd_cash($id);

				/* INSERT mfi_trx_gl_cash
				$this->model_transaction->insert_trx_gl_cash($data_setoran_cash);
				*/
			} else {
				// UPDATE DATA MASTER TABUNGAN
				$this->model_transaction->edit_rekening_tabungan($saving_data,$param_saving_no);

				// BUAT JURNAL
				$this->model_transaction->fn_proses_jurnal_angsuran_pyd_pinbuk($id);
			}

			// UPDATE DATA MASTER PEMBIAYAAN
			$this->model_transaction->update_mfi_account_financing($financing_data,$financing_param);

			if(count($financing_schedulle_data) > 0){
				// UPDATE DATA MASTER PEMBIAYAAN SCHEDULLE
				$this->model_transaction->update_on_financing_schedulle($financing_schedulle_data,$financing_schedulle_param);
			}
		} else if($jenis == 'SMK'){
			// UPDATE DATA SMK
			$this->model_transaction->aktivasi_transaksi_smk($data_smk,$param_smk);
		} else if($jenis == 'Deposito') {
			// UPDATE HISTORI DEPOSITO
			$this->model_transaction->update_trx_deposito($data_trx_deposito,$param_deposito);

			if($trx_deposit_type == '0'){
				// JURNAL PEMBUKAAN DEPOSITO
				$this->model_transaction->fn_jurnal_pembukaan_deposito($account_no);
			} else {
				// JURNAL PENCAIRAN DEPOSITO
				$this->model_transaction->fn_jurnal_pencairan_deposito($account_no);
			}

			// UPDATE DATA DEPOSITO
			$this->model_transaction->edit_deposit($data_deposito,$param_deposito);
		}

		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
			$return = array('success' => TRUE);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => FALSE);
		}

		echo json_encode($return);
	}

	public function detail_transaksi_tabungan()
	{
		$id 	= $this->input->post('id');
		$data 	= $this->model_transaction->detail_transaksi_tabungan($id);

		echo json_encode($data);
	}

	public function detail_transaksi_pembiayaan()
	{
		$id 	= $this->input->post('id');
		$data 	= $this->model_transaction->detail_transaksi_pembiayaan($id);

		echo json_encode($data);
	}

	public function detail_transaksi_smk()
	{
		$id 	= $this->input->post('id');
		$data 	= $this->model_transaction->detail_transaksi_smk($id);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// END VERIFIKASI TRANSAKSI
	/****************************************************************************************/

	public function print_form_trx_rembug()
	{
		$cm_code = $this->uri->segment(3);
		$account_cash_code = $this->uri->segment(4);
		$tanggal = $this->uri->segment(5);
		$branch = $this->uri->segment(6);
		$cm = $this->uri->segment(7);
		$tanggal = $this->datepicker_convert(true,$tanggal,'-');
        $rows = $this->model_transaction->get_trx_rembug_data($cm_code,$tanggal);
		$i=0;
		$data['data'] = array();
		$data['tab_berencana'] = array();
		foreach($rows as $row)
		{
			// $data['tab_berencana'][$i] = $this->model_transaction->get_tabungan_berencana_by_cif_no2($row['cif_no'],$row['account_financing_no']);
			// $data_tabungan_berencana = $this->model_transaction->get_tabungan_berencana_by_cif_no($row['cif_no']);
			$data_tabungan_berencana = $this->model_transaction->get_tabungan_berencana_by_cif_no3($row['cif_no']);
			$data['tab_berencana'][$i] = $data_tabungan_berencana;
			if(count($data_tabungan_berencana)>0)
			{
				for($j=0;$j<count($data_tabungan_berencana);$j++)
				{
					if($j==0){
						$data['data'][$i]['no_urut'] = ($row['kelompok']==null)?0:$row['kelompok'];
						$data['data'][$i]['cif_id'] = ($row['cif_id']==null)?0:$row['cif_id'];
						$data['data'][$i]['cm_code'] = ($row['cm_code']==null)?0:$row['cm_code'];
						$data['data'][$i]['cif_no'] = ($row['cif_no']==null)?0:$row['cif_no'];
						$data['data'][$i]['nama'] = ($row['nama']==null)?0:$row['nama'];
						$data['data'][$i]['account_financing_no'] = ($row['account_financing_no']==null)?'':$row['account_financing_no'];
						$data['data'][$i]['tabungan_sukarela'] = ($row['tabungan_sukarela']==null)?0:$row['tabungan_sukarela'];
						$data['data'][$i]['tabungan_wajib'] = ($row['tabungan_wajib']==null)?0:$row['tabungan_wajib'];
						$data['data'][$i]['transaksi_lain'] = ($row['transaksi_lain']==null)?0:$row['transaksi_lain'];
						$data['data'][$i]['angsuran'] = ($row['angsuran']==null)?0:$row['angsuran'];
						$data['data'][$i]['pokok_pembiayaan'] = ($row['pokok_pembiayaan']==null)?0:$row['pokok_pembiayaan'];
						$data['data'][$i]['margin_pembiayaan'] = ($row['margin_pembiayaan']==null)?0:$row['margin_pembiayaan'];
						$data['data'][$i]['catab_pembiayaan'] = ($row['catab_pembiayaan']==null)?0:$row['catab_pembiayaan'];
						$data['data'][$i]['tabungan_kelompok'] = ($row['tabungan_kelompok']==null)?0:$row['tabungan_kelompok'];
						$data['data'][$i]['jumlah_angsuran'] = ($row['jumlah_angsuran']==null)?0:$row['jumlah_angsuran'];
						$data['data'][$i]['pokok'] = '';
						$data['data'][$i]['droping'] = '';
						$data['data'][$i]['angsuran_pokok'] = ($row['angsuran_pokok']==null)?0:$row['angsuran_pokok'];
						$data['data'][$i]['angsuran_margin'] = ($row['angsuran_margin']==null)?0:$row['angsuran_margin'];
						$data['data'][$i]['angsuran_catab'] = ($row['angsuran_catab']==null)?0:$row['angsuran_catab'];
						$data['data'][$i]['angsuran_tab_wajib'] = ($row['angsuran_tab_wajib']==null)?0:$row['angsuran_tab_wajib'];
						$data['data'][$i]['angsuran_tab_kelompok'] = ($row['angsuran_tab_kelompok']==null)?0:$row['angsuran_tab_kelompok'];
						$data['data'][$i]['adm'] = '';
						$data['data'][$i]['asuransi'] = '';
						$data['data'][$i]['nick_name'] = ($data_tabungan_berencana[$j]['nick_name']==null)?0:$data_tabungan_berencana[$j]['nick_name'];
						$data['data'][$i]['setoran_berencana'] = ($data_tabungan_berencana[$j]['rencana_setoran']==null)?0:$data_tabungan_berencana[$j]['rencana_setoran'];
						$data['data'][$i]['taber_saldo_bayar'] = ($data_tabungan_berencana[$j]['rencana_jangka_waktu']-$data_tabungan_berencana[$j]['counter_angsruan']);
						$data['data'][$i]['setoran_lwk'] = ($row['setoran_lwk']==null)?0:$row['setoran_lwk'];
						$data['data'][$i]['setoran_mingguan'] = ($row['setoran_mingguan']==null)?0:$row['setoran_mingguan'];
						$data['data'][$i]['margin'] = ($row['margin']==null)?0:$row['margin'];
						$data['data'][$i]['saldo_pokok'] = ($row['saldo_pokok']==null)?0:$row['saldo_pokok'];
						$data['data'][$i]['saldo_margin'] = ($row['saldo_margin']==null)?0:$row['saldo_margin'];
						$data['data'][$i]['saldo_catab'] = ($row['saldo_catab']==null)?0:$row['saldo_catab'];
						$data['data'][$i]['status'] = $row['status'];
						$data['data'][$i]['status_droping'] = $row['status_droping'];
						$data['data'][$i]['freq_saldo_outstanding'] = $row['freq_saldo_outstanding'];
						$data['data'][$i]['freq_tunggakan'] = ($row['freq_tunggakan']>0)?$row['freq_tunggakan']:0;
						$data['data'][$i]['counter_angsuran'] = ($row['freq_saldo_outstanding']!='')?$row['counter_angsuran']:'';
						$i++;
					}else{
						$data['data'][$i]['no_urut'] = '';
						$data['data'][$i]['cif_id'] = '';
						$data['data'][$i]['cm_code'] = '';
						$data['data'][$i]['cif_no'] = '';
						$data['data'][$i]['nama'] = '';
						$data['data'][$i]['account_financing_no'] = '';
						$data['data'][$i]['tabungan_sukarela'] = '';
						$data['data'][$i]['tabungan_wajib'] = '';
						$data['data'][$i]['transaksi_lain'] = '';
						$data['data'][$i]['angsuran'] = '';
						$data['data'][$i]['pokok_pembiayaan'] = '';
						$data['data'][$i]['margin_pembiayaan'] = '';
						$data['data'][$i]['catab_pembiayaan'] = '';
						$data['data'][$i]['tabungan_kelompok'] = '';
						$data['data'][$i]['jumlah_angsuran'] = '';
						$data['data'][$i]['pokok'] = '';
						$data['data'][$i]['droping'] = '';
						$data['data'][$i]['angsuran_pokok'] = '';
						$data['data'][$i]['angsuran_margin'] = '';
						$data['data'][$i]['angsuran_catab'] = '';
						$data['data'][$i]['angsuran_tab_wajib'] = '';
						$data['data'][$i]['angsuran_tab_kelompok'] = '';
						$data['data'][$i]['adm'] = '';
						$data['data'][$i]['asuransi'] = '';
						$data['data'][$i]['nick_name'] = ($data_tabungan_berencana[$j]['nick_name']==null)?0:$data_tabungan_berencana[$j]['nick_name'];
						$data['data'][$i]['setoran_berencana'] = ($data_tabungan_berencana[$j]['rencana_setoran']==null)?0:$data_tabungan_berencana[$j]['rencana_setoran'];
						$data['data'][$i]['taber_saldo_bayar'] = ($data_tabungan_berencana[$j]['rencana_jangka_waktu']-$data_tabungan_berencana[$j]['counter_angsruan']);
						$data['data'][$i]['setoran_lwk'] = '';
						$data['data'][$i]['setoran_mingguan'] = '';
						$data['data'][$i]['margin'] = '';
						$data['data'][$i]['saldo_pokok'] = '';
						$data['data'][$i]['saldo_margin'] = '';
						$data['data'][$i]['saldo_catab'] = '';
						$data['data'][$i]['status'] = '';
						$data['data'][$i]['status_droping'] = '';
						$data['data'][$i]['freq_saldo_outstanding'] = '';
						$data['data'][$i]['freq_tunggakan'] = '';
						$data['data'][$i]['counter_angsuran'] = '';
						$i++;
					}
				}
			}
			else
			{
				$data['data'][$i]['no_urut'] = ($row['kelompok']==null)?0:$row['kelompok'];
				$data['data'][$i]['cif_id'] = ($row['cif_id']==null)?0:$row['cif_id'];
				$data['data'][$i]['cm_code'] = ($row['cm_code']==null)?0:$row['cm_code'];
				$data['data'][$i]['cif_no'] = ($row['cif_no']==null)?0:$row['cif_no'];
				$data['data'][$i]['nama'] = ($row['nama']==null)?0:$row['nama'];
				$data['data'][$i]['account_financing_no'] = ($row['account_financing_no']==null)?'':$row['account_financing_no'];
				$data['data'][$i]['tabungan_sukarela'] = ($row['tabungan_sukarela']==null)?0:$row['tabungan_sukarela'];
				$data['data'][$i]['tabungan_wajib'] = ($row['tabungan_wajib']==null)?0:$row['tabungan_wajib'];
				$data['data'][$i]['transaksi_lain'] = ($row['transaksi_lain']==null)?0:$row['transaksi_lain'];
				$data['data'][$i]['angsuran'] = ($row['angsuran']==null)?0:$row['angsuran'];
				$data['data'][$i]['pokok_pembiayaan'] = ($row['pokok_pembiayaan']==null)?0:$row['pokok_pembiayaan'];
				$data['data'][$i]['margin_pembiayaan'] = ($row['margin_pembiayaan']==null)?0:$row['margin_pembiayaan'];
				$data['data'][$i]['catab_pembiayaan'] = ($row['catab_pembiayaan']==null)?0:$row['catab_pembiayaan'];
				$data['data'][$i]['tabungan_kelompok'] = ($row['tabungan_kelompok']==null)?0:$row['tabungan_kelompok'];
				$data['data'][$i]['jumlah_angsuran'] = ($row['jumlah_angsuran']==null)?0:$row['jumlah_angsuran'];
				$data['data'][$i]['pokok'] = '';
				$data['data'][$i]['droping'] = '';
				$data['data'][$i]['angsuran_pokok'] = ($row['angsuran_pokok']==null)?0:$row['angsuran_pokok'];
				$data['data'][$i]['angsuran_margin'] = ($row['angsuran_margin']==null)?0:$row['angsuran_margin'];
				$data['data'][$i]['angsuran_catab'] = ($row['angsuran_catab']==null)?0:$row['angsuran_catab'];
				$data['data'][$i]['angsuran_tab_wajib'] = ($row['angsuran_tab_wajib']==null)?0:$row['angsuran_tab_wajib'];
				$data['data'][$i]['angsuran_tab_kelompok'] = ($row['angsuran_tab_kelompok']==null)?0:$row['angsuran_tab_kelompok'];
				$data['data'][$i]['adm'] = '';
				$data['data'][$i]['asuransi'] = '';
				$data['data'][$i]['nick_name'] = '';
				$data['data'][$i]['setoran_berencana'] = '';
				$data['data'][$i]['taber_saldo_bayar'] = '';
				$data['data'][$i]['setoran_lwk'] = ($row['setoran_lwk']==null)?0:$row['setoran_lwk'];
				$data['data'][$i]['setoran_mingguan'] = ($row['setoran_mingguan']==null)?0:$row['setoran_mingguan'];
				$data['data'][$i]['margin'] = ($row['margin']==null)?0:$row['margin'];
				$data['data'][$i]['saldo_pokok'] = ($row['saldo_pokok']==null)?0:$row['saldo_pokok'];
				$data['data'][$i]['saldo_margin'] = ($row['saldo_margin']==null)?0:$row['saldo_margin'];
				$data['data'][$i]['saldo_catab'] = ($row['saldo_catab']==null)?0:$row['saldo_catab'];
				$data['data'][$i]['status'] = $row['status'];
				$data['data'][$i]['status_droping'] = $row['status_droping'];
				$data['data'][$i]['freq_saldo_outstanding'] = $row['freq_saldo_outstanding'];
				$data['data'][$i]['freq_tunggakan'] = ($row['freq_tunggakan']>0)?$row['freq_tunggakan']:0;
				$data['data'][$i]['counter_angsuran'] = ($row['freq_saldo_outstanding']!='')?$row['counter_angsuran']:'';
				$i++;
			}
			
		}
		$data['kas_awal'] = $this->model_transaction->fn_get_saldoawal_kaspetugas($account_cash_code,$tanggal,1); // 1 = mencari kas awal
        $data['cabang'] = $branch;
        $data['majelis'] = $cm;

        ob_start();
        
        $this->load->view('transaction/print_form_trx_rembug',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('FORMULIR TRANSAKSI REMBUG.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
	}

	/****************************************************************************************/	
	// BEGIN TRANSAKSI SETORAN POKOK
	/****************************************************************************************/
	public function setoran_pokok()
	{
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['container'] = 'transaction/setoran_pokok';
		$this->load->view('core',$data);
	}

	public function datatable_trx_setoran_pokok_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_cif.cif_no','mfi_cif.nama','setor_tunai','setor_tabungan_wajib','setor_tabungan_kelompok','setor_tabungan_sukarela','trx_date','');
				
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

		$rResult 			= $this->model_transaction->datatable_trx_setoran_pokok_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_trx_setoran_pokok_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_trx_setoran_pokok_setup(); // get number of all data
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

			if($aRow['setor_tabungan_wajib'] != 0){
				$setoran_tunai = $aRow['setor_tabungan_wajib'];
			} else if($aRow['setor_tabungan_kelompok'] != 0){
				$setoran_tunai = $aRow['setor_tabungan_kelompok'];
			} else if($aRow['setor_tabungan_sukarela'] != 0){
				$setoran_tunai = $aRow['setor_tabungan_sukarela'];
			} else {
				$setoran_tunai = '0';
			}

			if($aRow['cm_name']!=""){
			   $rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			$row[] = '<input type="checkbox" value="'.$aRow['trx_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = '<div align="right">Rp '.number_format($setoran_tunai,0,',','.').',-</div>';
			$row[] = $this->format_date_detail($aRow['trx_date'],'id',false,'/');
			// $row[] = '<a href="javascript:;" trx_id="'.$aRow['trx_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_transaksi_setoran_pokok()
	{
		$cif_no		 				= $this->input->post('cif_no');
		$setor_tunai 				= $this->input->post('setor_tunai');
		$setor_tabungan_wajib	 	= $this->input->post('setor_tabungan_wajib');
		$setor_tabungan_kelompok 	= $this->input->post('setor_tabungan_kelompok');
		$setor_tabungan_sukarela 	= $this->input->post('setor_tabungan_sukarela');
		$total_setoran 				= $this->input->post('total_setoran');
		$jenis_tabungan				= $this->input->post('jenis_tabungan');

		if($jenis_tabungan == 'wajib'){
			$tabungan_wajib = $setor_tunai;
			$sisa_wajib = str_replace('.','',$setor_tabungan_wajib) - str_replace('.','',$setor_tunai);
			$tabungan_sukarela = 0;
			$tabungan_kelompok = 0;
			$update_saldo = array('tabungan_wajib' => $sisa_wajib);
		} else if($jenis_tabungan == 'sukarela'){
			$tabungan_wajib = 0;
			$tabungan_sukarela = $setor_tunai;
			$sisa_sukarela = str_replace('.','',$setor_tabungan_sukarela) - str_replace('.','',$setor_tunai);
			$tabungan_kelompok = 0;
			$update_saldo = array('tabungan_sukarela' => $sisa_sukarela);
		} else {
			$tabungan_wajib = 0;
			$tabungan_sukarela = 0;
			$tabungan_kelompok = $setor_tunai;
			$sisa_kelompok = str_replace('.','',$setor_tabungan_kelompok) - str_replace('.','',$setor_tunai);
			$update_saldo = array('tabungan_kelompok' => $sisa_kelompok);
		}

		$total_setoran = $this->convert_numeric($tabungan_wajib) + $this->convert_numeric($tabungan_sukarela) + $this->convert_numeric($tabungan_kelompok);

		$data = array(
			'cif_no' 					=>$cif_no,
			'trx_type' 					=>'0',
			//'setor_tunai'				=>$this->convert_numeric($setor_tunai),
			'setor_tabungan_wajib' 		=>$this->convert_numeric($tabungan_wajib),
			'setor_tabungan_kelompok' 	=>$this->convert_numeric($tabungan_kelompok),
			'setor_tabungan_sukarela' 	=>$this->convert_numeric($tabungan_sukarela),
			'total_setoran' 			=>$this->convert_numeric($total_setoran),
			'trx_date' 					=>date("Y-m-d"),
			'created_date' 				=>date("Y-m-d H:i:s"),
			'created_by' 				=>$this->session->userdata('user_id')
			);

		$this->db->trans_begin();
		$this->model_transaction->add_transaksi_setoran_pokok($data);
		$this->model_transaction->update_saldo_balance($cif_no,$update_saldo);
		$cek = $this->model_transaction->check_valid_cif_no_saleh($cif_no);
		$s_pokok = $cek['total_setoran'];

		if($s_pokok == '100000'){
			$u_array = array('simpanan_pokok' => $s_pokok);
			$this->model_transaction->update_simpanan_pokok($cif_no,$u_array);
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function check_valid_cif_no()
	{
		$cif_no 		= $this->input->post('cif_no');
		$id_valid 		= $this->model_transaction->check_valid_cif_no($cif_no);

		if(isset($id_valid['num']) > 0){
			$return = array(
				'stat'=> FALSE,
				'nama' => $id_valid['nama'],
				'rekening' => $id_valid['cif_no'],
				'tanggal_transaksi' => $id_valid['trx_date']
			);
		} else {
			$return = array('stat'=>true);
		}

		echo json_encode($return);

	}

	function check_valid_cif_no_saleh(){
		$cif_no = $this->input->post('cif_no');
		$total = $this->input->post('total');
		$setor = $this->input->post('setor');
		$setor = str_replace('.','',$setor);

		$check = $this->model_transaction->check_simpanan_pokok();
		$cif = $this->model_transaction->check_valid_cif_no_saleh($cif_no);

		$pokok = $check['simpanan_pokok'];
		$total_setoran = (isset($cif['total_setoran'])) ? $cif['total_setoran'] : '';
		$maks_setoran = $pokok - $total_setoran;

		if($total_setoran == '100000'){
			$return = array(
				'stat' => FALSE,
				'ket' => 'Gagal! Setoran sudah mencapai '.number_format($total_setoran)
			);
		} else {
			if($setor > $maks_setoran){
				$return = array(
					'stat' => FALSE,
					'ket' => 'Maksimal Setoran Rp. '.number_format($maks_setoran)
				);
			} else {
				$return = array('stat' => TRUE);
			}
		}


		echo json_encode($return);
	}

	public function delete_trx_setoran_pokok()
	{
		$trx_id = $this->input->post('trx_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($trx_id) ; $i++ )
		{
			$param = array('trx_id'=>$trx_id[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_trx_setoran_pokok($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
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

	/****************************************************************************************/	
	// END TRANSAKSI SETORAN POKOK
	/****************************************************************************************/

	function cek_trx_kontrol_periode()
	{
		$tanggal = $this->input->post('tanggal');
		$tanggal = $this->datepicker_convert(true,$tanggal,$separator='/');
		$cek = $this->model_transaction->cek_trx_kontrol_periode($tanggal);
		$return = array('success'=>$cek);
		echo json_encode($return);
	}

	//Get tanggal realisasi pencairan
	public function get_plan_pencairan()
	{
		$tgl_pengajuan = $this->input->post('tanggal_pengajuan');
		$hari 		   = '7';
		$tanggal_pengajuan = date('d/m/Y',strtotime($tgl_pengajuan. '+'.$hari.' days'));

		echo json_encode(array('realisasi_pengajuan'=>$tanggal_pengajuan));
	}
	//Get tanggal realisasi pencairan

	// BEGIN REVIEW JURNAL TRANSAKSI
	public function review_transaksi()
	{
		$data['container'] 	= 'transaction/review_transaksi';
		$branch_code = $this->session->userdata('branch_code');
		$data['accounts'] 	= $this->model_transaction->get_gl_account($branch_code);
		$this->load->view('core',$data);
	}

	public function get_review_transaksi()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'code';
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$from_date = isset($_REQUEST['from_date'])?$_REQUEST['from_date']:'';
		$thru_date = isset($_REQUEST['thru_date'])?$_REQUEST['thru_date']:'';
		$branch_code = isset($_REQUEST['branch_code'])?$_REQUEST['branch_code']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_transaction->get_review_transaksi('','','','',$from_date,$thru_date,$branch_code);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_transaction->get_review_transaksi($sidx,$sort,$limit_rows,$start,$from_date,$thru_date,$branch_code);
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			// $trx_detail = $this->model_transaction->get_trx_gl_detail($row['trx_gl_id']);
			// $desc = '';
			// for ( $j = 0 ; $j < count($trx_detail) ; $j++ ) {
			// 	if($j>0){
			// 		$desc.= '-';
			// 	}
			// 	$desc .= $trx_detail[$j]['description'];
			// }

			$responce['rows'][$i]['id'] = $row['trx_gl_id'];
			$responce['rows'][$i]['cell'] = array(
				$row['trx_gl_id']
				,substr($row['trx_date'],0,10)
				,substr($row['voucher_date'],0,10)
				,$row['voucher_ref']
				,$row['description']
				,$row['total_debit']
				,$row['total_credit']
				,$row['branch_name']
				,$row['flag_status']
			);
			$i++;
		}

		echo json_encode($responce);
	}

	function update_flag_status_trx_gl()
	{
		$trx_gl_id=$this->input->get('trx_gl_id');
		$data=array('flag_status'=>'1');
		$param=array('trx_gl_id'=>$trx_gl_id);
		$this->db->trans_begin();
		$this->model_transaction->update_trx_gl($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return=array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return=array('success'=>false);
		}
		echo json_encode($return);
	}

	function get_detail_review_transaksi()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'code';
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$trx_gl_id = isset($_REQUEST['trx_gl_id'])?$_REQUEST['trx_gl_id']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_transaction->get_detail_review_transaksi('','','','',$trx_gl_id);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_transaction->get_detail_review_transaksi($sidx,$sort,$limit_rows,$start,$trx_gl_id);
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['id'] = $row['trx_gl_detail_id'];
			$responce['rows'][$i]['cell'] = array(
				 $row['trx_gl_detail_id']
				,$row['trx_gl_id']
				,$row['account_code']
				,$row['account_name']
				,$row['description']
				,$row['debit']
				,$row['credit']
			);
			$i++;
		}

		echo json_encode($responce);
	}

	public function update_description_acctg_trans()
	{
		$acctg_trans_id = $this->input->post('acctg_trans_id');
		$description = $this->input->post('description');

		$data = array('description'=>$description);
		$param = array('acctg_trans_id'=>$acctg_trans_id);

		$this->db->trans_begin();
		$this->model_transaction->update_acctg_trans($data,$param);
		if($this->db->trans_status()===true)
		{
			$this->db->trans_commit();
			$return = array('success'=>true);
		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function update_acctg_trans_entry()
	{
		$trx_gl_detail_id = $this->input->post('trx_gl_detail_id');
		$trx_gl_id = $this->input->post('trx_gl_id');
		$account_code = $this->input->post('account_code');
		$description = $this->input->post('description');
		$debit = $this->input->post('debit');
		$credit = $this->input->post('credit');

		if($debit>$credit){
			$amount = $debit;
			$debit_credit_flag = 'D';
		}else if($credit>$debit){
			$amount = $credit;
			$debit_credit_flag = 'C';
		}else{
			$amount = 0;
			$debit_credit_flag = NULL;
		}

		$data = array(
				'account_code' => $account_code
				,'description' => $description
				,'flag_debit_credit' => $debit_credit_flag
				,'amount' => $this->convert_numeric($amount)
			);
		$param = array('trx_gl_detail_id'=>$trx_gl_detail_id,'trx_gl_id'=>$trx_gl_id);

		$this->db->trans_begin();
		$this->model_transaction->update_trx_gl_detail($data,$param);
		if($this->db->trans_status()===true)
		{
			$this->db->trans_commit();
			$return = array('success'=>true);
		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function add_acctg_trans_entry()
	{
		$trx_gl_id = $this->input->post('trx_gl_id');
		$account_code = $this->input->post('account_code');
		$description = $this->input->post('description');
		$debit = $this->input->post('debit');
		$credit = $this->input->post('credit');

		if($debit>$credit){
			$amount = $debit;
			$debit_credit_flag = 'D';
		}else if($credit>$debit){
			$amount = $credit;
			$debit_credit_flag = 'C';
		}else{
			$amount = 0;
			$debit_credit_flag = NULL;
		}

		$trx_sequence = $this->model_transaction->get_trx_gl_detail_sequence($trx_gl_id);

		$data[] = array(
				'trx_gl_detail_id' => uuid(false)
				,'trx_gl_id' => $trx_gl_id
				,'account_code' => $account_code
				,'description' => $description
				,'flag_debit_credit' => $debit_credit_flag
				,'amount' => $this->convert_numeric($amount)
				,'trx_sequence' => $trx_sequence
			);

		$this->db->trans_begin();
		$this->model_transaction->insert_trx_gl_detail($data);
		if($this->db->trans_status()===true)
		{
			$this->db->trans_commit();
			$return = array('success'=>true);
		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_jurnal_transaksi_detail()
	{
		$trx_gl_detail_id = $this->input->post('trx_gl_detail_id');
		$param = array('trx_gl_detail_id'=>$trx_gl_detail_id);

		$this->db->trans_begin();
		$this->model_transaction->delete_trx_gl_detail($param);
		if($this->db->trans_status()===true)
		{
			$this->db->trans_commit();
			$return = array('success'=>true);
		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_jurnal_transaksi()
	{
		$trx_gl_id = $this->input->post('trx_gl_id');
		$param = array('trx_gl_id'=>$trx_gl_id);

		$this->db->trans_begin();
		$this->model_transaction->delete_trx_gl_detail($param);
		if($this->db->trans_status()===true)
		{
			$this->db->trans_commit();

			$this->db->trans_begin();
			$this->model_transaction->delete_trx_gl($param);
			$this->model_transaction->delete_trx_gl_cash($param);
			if($this->db->trans_status()===true)
			{
				$this->db->trans_commit();
				$return = array('success'=>true);
			}
			else
			{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}

		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/* PENCAIRAN TABUNGAN */

	public function pencairan_tabungan()
	{

		$data['container'] = 'transaction/pencairan_tabungan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/* DELETING TRANSACTION SAVING(TABUNGAN) */

	/**
	* DELETE SETORAN TUNAI
	* @author : sayyid
	* date : 25 agustus 2014
	* @param : trx_detail_id
	*/
	public function delete_setoran_tunai()
	{
		$trx_detail_id=$this->input->post('trx_detail_id');
		$data_trx_account_saving=$this->model_transaction->get_trx_account_saving_by_trx_detail_id($trx_detail_id);
		if(count($data_trx_account_saving)==1){
			$data_trx_account_saving=$data_trx_account_saving[0];
			$account_saving_no=$data_trx_account_saving['account_saving_no'];
			$data_account_saving=$this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no);
			$amount=$data_trx_account_saving['amount'];
			$data=array('saldo_memo'=>$data_account_saving['saldo_memo']-$amount);
			$param=array('account_saving_no'=>$account_saving_no);
			$param_trx_detail=array('trx_detail_id'=>$trx_detail_id);
			$this->db->trans_begin();
			$this->model_transaction->update_account_saving($data,$param);
			$this->model_transaction->delete_trx_account_saving($param_trx_detail);
			$this->model_transaction->delete_trx_detail($param_trx_detail);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		}else{
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}
	/**
	* DELETE PENARIKAN TUNAI
	* @author : sayyid
	* date : 25 agustus 2014
	* @param : trx_detail_id
	*/
	public function delete_penarikan_tunai()
	{
		$trx_detail_id=$this->input->post('trx_detail_id');
		$data_trx_account_saving=$this->model_transaction->get_trx_account_saving_by_trx_detail_id($trx_detail_id);
		if(count($data_trx_account_saving)==1){
			$param_trx_detail=array('trx_detail_id'=>$trx_detail_id);
			$this->db->trans_begin();
			$this->model_transaction->delete_trx_account_saving($param_trx_detail);
			$this->model_transaction->delete_trx_detail($param_trx_detail);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		}else{
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}
	/**
	* DELETE PINBUK
	* @author : sayyid
	* date : 25 agustus 2014
	* @param : trx_detail_id
	*/
	public function delete_pinbuk()
	{
		$trx_detail_id=$this->input->post('trx_detail_id');
		
		$data_pinbuk_keluar=$this->model_transaction->get_trx_account_saving_by_trx_detail_id($trx_detail_id,3);
		$data_pinbuk_masuk=$this->model_transaction->get_trx_account_saving_by_trx_detail_id($trx_detail_id,4);
		
		if(count($data_pinbuk_keluar)==1 && count($data_pinbuk_masuk)==1){

			$data_pinbuk_keluar=$data_pinbuk_keluar[0];
			$data_pinbuk_masuk=$data_pinbuk_masuk[0];

			$account_saving_no_sumber=$data_pinbuk_keluar['account_saving_no'];
			$account_saving_no_tujuan=$data_pinbuk_masuk['account_saving_no'];

			$data_account_saving_sumber=$this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no_sumber);
			$data_account_saving_tujuan=$this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no_tujuan);

			$amount_sumber=$data_pinbuk_keluar['amount'];
			$amount_tujuan=$data_pinbuk_masuk['amount'];

			$data_sumber=array('saldo_memo'=>$data_account_saving_sumber['saldo_memo']+$amount_sumber);
			$param_sumber=array('account_saving_no'=>$account_saving_no_sumber);

			$data_tujuan=array('saldo_memo'=>$data_account_saving_tujuan['saldo_memo']-$amount_tujuan);
			$param_tujuan=array('account_saving_no'=>$account_saving_no_tujuan);

			$param_trx_detail=array('trx_detail_id'=>$trx_detail_id);

			$this->db->trans_begin();
			$this->model_transaction->update_account_saving($data_sumber,$param_sumber);
			$this->model_transaction->update_account_saving($data_tujuan,$param_tujuan);
			$this->model_transaction->delete_trx_account_saving($param_trx_detail);
			$this->model_transaction->delete_trx_detail($param_trx_detail);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		}else{
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	public function get_product_financing_data_by_code()
	{
		$product_code=$this->input->post('product_code');
		$data=$this->model_transaction->get_product_financing_data_by_code($product_code);
		echo json_encode($data);
	}

	function ajax_get_product_financing_by_jenis_pembiayaan(){
		$jenis_pembiayaan = $this->input->post('jenis_pembiayaan');

		if($jenis_pembiayaan == 0){
			$jp = '1';
		} else {
			$jp = '0';
		}

		$data = $this->model_transaction->ajax_get_product_financing_by_jenis_pembiayaan($jp);
		echo json_encode($data);
	}

	function ajax_get_product_financing_by_jenis_pembiayaan2(){
		$jenis_pembiayaan = $this->input->post('jenis_pembiayaan');

		$data = $this->model_transaction->ajax_get_product_financing_by_jenis_pembiayaan($jenis_pembiayaan);
		echo json_encode($data);
	}

	function search_fa(){
		$branch = $this->input->post('branch');
		$keyword = $this->input->post('keyword');
		$data = $this->model_transaction->search_fa($keyword,$branch);

		echo json_encode($data);
	}

	function rak(){
		$data['container'] = 'transaction/transaksi_rak';
		$data['branch'] = $this->model_transaction->get_all_branch();
		$this->load->view('core',$data);
	}

	function datatable_rak_setup(){
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('','trx_rak_type','voucher_date','branch_kirim','branch_terima','amount','');
				
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

		$rResult 			= $this->model_transaction->datatable_rak_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_rak_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_rak_setup(); // get number of all data
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
		
		foreach($rResult as $aRow){
			$jenis_transaksi = $aRow['trx_rak_type'];

			if($jenis_transaksi == 1){
				$jenis = 'Droping dana dari Pusat';
			} else if($jenis_transaksi == 2){
				$jenis = 'Setor dana dari Cabang';
			} else {
				$jenis = 'Biaya Antar Kantor';
			}

			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['trx_rak_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = '<center>'.$jenis.'</center>';
			$row[] = '<center>'.$aRow['voucher_date'].'</center>';
			$row[] = '<center>'.$aRow['branch_kirim'].'</center>';
			$row[] = '<center>'.$aRow['branch_terima'].'</center>';
			$row[] = '<center>Rp. '.number_format($aRow['amount'],0,',','.').'</center>';
			$row[] = '<center><a href="javascript:;" id="link-edit" trx_rak_id="'.$aRow['trx_rak_id'].'">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function get_rak(){
		$cabang = $this->input->post('branch_code');

		$get_rak = $this->model_transaction->get_rak($cabang);

		$html = '<option value="" selected="selected">-- Pilih --</option>';

		foreach($get_rak AS $gr){
			$bank = $gr['bank_account_code'];
			$akun = $gr['account_name'];

			$html .= '<option value="'.$bank.'">'.$akun.'</option>';
		}

		echo $html;
	}

	function add_rak(){
		$trx_rak_type = $this->input->post('trx_rak_type');
		$voucher = $this->input->post('voucher_date');
		$branch_kirim = $this->input->post('branch_kirim');
		$rak_kirim = $this->input->post('rak_kirim');
		$bank_kirim = $this->input->post('bank_kirim');
		$branch_terima = $this->input->post('branch_terima');
		$rak_terima = $this->input->post('rak_terima');
		$bank_terima = $this->input->post('bank_terima');
		$amount = $this->input->post('amount');
		$keterangan = $this->input->post('keterangan');

		$voucher_date_ =str_replace("/","", $voucher);
        $voucher_date = substr($voucher_date_,4,4).'-'.substr($voucher_date_,2,2).'-'.substr($voucher_date_,0,2);

        $amount =str_replace(".","", $amount);

		$data = array(
			'voucher_date' => $voucher_date,
			'branch_kirim' => $branch_kirim,
			'branch_terima' => $branch_terima,
			'amount' => $amount,
			'trx_rak_type' => $trx_rak_type,
			'rak_kirim' => $rak_kirim,
			'rak_terima' => $rak_terima,
			'bank_kirim' => $bank_kirim,
			'bank_terima' => $bank_terima,
			'keterangan' => $keterangan,
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d H:i:s'),
		);

		$this->db->trans_begin();
		$this->model_transaction->proses_input_trx_rak($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function get_rak_by_trx_rak_id(){
		$trx_rak_id = $this->input->post('trx_rak_id');

		$get_trx = $this->model_transaction->get_rak_by_trx_rak_id($trx_rak_id);

		$result = array(
			'trx_rak_id' => $get_trx['trx_rak_id'],
			'trx_rak_type' => $get_trx['trx_rak_type'],
			'voucher_date' => substr($get_trx['voucher_date'],-2).'/'.substr($get_trx['voucher_date'],5,2).'/'.substr($get_trx['voucher_date'],0,4),
			'rak_kirim' => $get_trx['rak_kirim'],
			'bank_kirim' => $get_trx['bank_kirim'],
			'branch_kirim' => $get_trx['branch_kirim'],
			'branch_terima' => $get_trx['branch_terima'],
			'rak_terima' => $get_trx['rak_terima'],
			'bank_terima'=> $get_trx['bank_terima'],
			'amount' => number_format($get_trx['amount'],0,',','.')
		);

		echo json_encode($result);
	}

	function get_rak_edit(){
		$cabang = $this->input->post('branch_code');
		$bank_sumber = $this->input->post('bank_sumber');

		$get_rak = $this->model_transaction->get_rak($cabang);

		$html = '<option value="">-- Pilih --</option>';

		foreach($get_rak AS $gr){
			$bank = $gr['bank_account_code'];
			$akun = $gr['account_name'];

			if($bank_sumber == $bank){
				$selected = ' selected="selected"';
			} else {
				$selected = '';
			}

			$html .= '<option value="'.$bank.'"'.$selected.'>'.$akun.'</option>';
		}

		echo $html;
	}

	function edit_rak(){
		$trx_rak_id = $this->input->post('trx_rak_id');
		$trx_rak_type = $this->input->post('trx_rak_type');
		$voucher = $this->input->post('voucher_date');
		$branch_kirim = $this->input->post('branch_kirim');
		$rak_kirim = $this->input->post('rak_kirim');
		$bank_kirim = $this->input->post('bank_kirim');
		$branch_terima = $this->input->post('branch_terima');
		$rak_terima = $this->input->post('rak_terima');
		$bank_terima = $this->input->post('bank_terima');
		$amount = $this->input->post('amount');

		$voucher_date_ =str_replace("/","", $voucher);
        $voucher_date = substr($voucher_date_,4,4).'-'.substr($voucher_date_,2,2).'-'.substr($voucher_date_,0,2);

        $amount =str_replace(".","", $amount);

		$data = array(
			'voucher_date' => $voucher_date,
			'branch_kirim' => $branch_kirim,
			'branch_terima' => $branch_terima,
			'amount' => $amount,
			'trx_rak_type' => $trx_rak_type,
			'rak_kirim' => $rak_kirim,
			'rak_terima' => $rak_terima,
			'bank_kirim' => $bank_kirim,
			'bank_terima' => $bank_terima
		);

		$param = array('trx_rak_id' => $trx_rak_id);

		$this->db->trans_begin();
		$this->model_transaction->proses_edit_trx_rak($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	// START PERPANJANGAN TABBER
	function do_perpanjang_tabber(){
		$account_saving_no = $this->input->post('account_saving_no');
		$rencana_sebelum = $this->input->post('rencana_jangka_waktu');
		$rencana_setelah = $this->input->post('rencana_jangka_waktu_akhir2');
		$tgl_perpanjangan = $this->input->post('tanggal_perpanjangan');
		$counter_angsruan = $this->input->post('counter_angsruan');
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('user_id');

		$tanggal = substr($tgl_perpanjangan,0,2);
		$bulan = substr($tgl_perpanjangan,2,2);
		$tahun = substr($tgl_perpanjangan,-4);

		$tanggal_perpanjangan = $tahun.'-'.$bulan.'-'.$tanggal;

		$datas = array(
			'account_saving_no' => $account_saving_no,
			'rencana_jangka_waktu_sebelum' => $rencana_sebelum,
			'rencana_jangka_waktu_setelah' => $rencana_setelah,
			'tanggal_perpanjangan' => $tanggal_perpanjangan,
			'counter_angsruan' => $counter_angsruan,
			'created_date'=> $created_date,
			'created_by'=> $created_by
		);

		$check = $this->model_transaction->check_saving_schedulle($account_saving_no);
		$jumlah = $check['jum'];

		if($jumlah > 0){
			$return = array(
				'success' => FALSE,
				'message' => 'Tabungan ini sudah pernah diperpanjang tetapi belum diverifikasi. Silakkan verifikasi terlebih dahulu.'
			);
		} else {
			$this->db->trans_begin();
			$this->model_transaction->insert_perpanjang_tabber($datas);
			
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$return = array(
					'success' => TRUE,
					'message' => 'Berhasil!'
				);
			}else{
				$this->db->trans_rollback();
				$return = array(
					'success' => FALSE,
					'message' => 'Gagal!'
				);
			}
		}

		echo json_encode($return);
	}
	// END PERPANJANGAN TABBER

	
// ======================================================================
	public function get_account_financing_by_account_financing_id2()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_account_financing_by_account_financing_no($account_financing_no);

		echo json_encode($data);
	}

	/*Transaksi Wakalah *******************************************************/
	

	function datatable_transaksi_wakalah(){

		$param_branch_code = $this->session->userdata('branch_code');

		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'account_financing_no','mc.nama','ma.akad_name','pokok','');
				
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

		$rResult 			= $this->model_transaction->datatable_transaksi_wakalah($sWhere,$sOrder,$sLimit,$param_branch_code); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_transaksi_wakalah($sWhere,'','',$param_branch_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_transaksi_wakalah('','','',$param_branch_code); // get number of all data
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
		
		foreach($rResult as $aRow){
			$row = array();
			$rembug='';
			if($aRow['cm_name']!=""){
			   $rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = $aRow['akad_name'];
			$row[] = '<div align="right">Rp '.number_format($aRow['pokok'],0,',','.').',-</div>';
			$row[] = '<a href="javascript:;" account_financing_no="'.$aRow['account_financing_no'].'" id="link-edit">Proses</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	//END Transaksi Wakalah

	function datatable_perpanjangan(){
		$branch_code = $this->session->userdata('branch_code');
		$aColumns = array('mass.account_saving_no','mc.nama','');

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
			if($sWhere==""){
				$sWhere = " WHERE mass.status_verifikasi ='0'";
			}else{
				$sWhere .= " AND mass.status_verifikasi ='0'";
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

		$rResult = $this->model_transaction->datatable_perpanjangan($sWhere,$sOrder,$sLimit,$branch_code);
		$rResultFilterTotal = $this->model_transaction->datatable_perpanjangan($sWhere,'','',$branch_code);
		$iFilteredTotal = count($rResultFilterTotal); 
		$rResultTotal = $this->model_transaction->datatable_perpanjangan('','','',$branch_code);
		$iTotal = count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow){
			$row = array();
			$rembug = '';

			if($aRow['cm_name'] != ''){
				$rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}

			$row[] = $aRow['account_saving_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = '<center><a href="javascript:;" account_saving_no="'.$aRow['account_saving_no'].'" id="link-edit">Verifikasi</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode($output);
	}

	function reject_data_perpanjangan_tabber(){
		$account_saving_no = $this->input->post('account_saving_no');

		$param = array('account_saving_no' => $account_saving_no);

		$this->db->trans_begin();
		$this->model_transaction->delete_perpanjangan_tabber($param);

		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
			$result = array('success' => TRUE);
		} else {
			$this->db->trans_rollback();
			$result = array('success' => FALSE);
		}

		echo json_encode($result);
	}

	function verif_perpanjang_tabber(){
		$account_saving_no = $this->input->post('account_saving_no');
		$rencana_jangka_waktu = $this->input->post('rencana_jangka_waktu_akhir2');

		$data = array('rencana_jangka_waktu' => $rencana_jangka_waktu);

		$datas = array('status_verifikasi' => '1');

		$param = array('account_saving_no'	=>$account_saving_no);

		$this->db->trans_begin();
		$this->model_transaction->verif_perpanjang_tabber($data,$param);
		$this->model_transaction->update_perpanjang_tabber($datas,$param);

		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
			$return = array(
				'success' => TRUE,
				'message' => 'Verifikasi Berhasil!');
		} else {
			$this->db->trans_rollback();
			$return = array(
				'success' => FALSE,
				'message' => 'Verifikasi Gagal!'
			);
		}

		echo json_encode($return);
	}
	// END VERIFIKASI PERPANJANGAN TABBER
}



/* End of file transaction.php */
/* Location: ./application/controllers/transaction.php */