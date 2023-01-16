<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cif extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_cif');
		$this->load->model('model_kelompok');
		$this->load->model('model_transaction');
	}

	// [BEGIN] CIF KELOMPOK 

	public function cif_kelompok()
	{
		$data['container'] 				= 'cif/cif_kelompok';
		// $data['branch'] 				= $this->model_cif->get_all_branch();
		$data['branch'] 				= $this->session->userdata('branch_id');
		$institution 					= $this->model_cif->get_institution();
		$data['default_setoran_lwk'] 	= $institution['setoran_lwk'];
		$data['default_minggon'] 		= $institution['minggon'];
		$data['current_date'] 			= $this->current_date();
		$this->load->view('core',$data);
	}

	public function add_cif_kelompok()
	{
		$cm_code 								= $this->input->post('add_cm_code');
		$step1_cif_no 							= $this->input->post('step1_cif_no');
	    $step1_tanggal_gabung 					= str_replace('/','',$this->input->post('step1_tanggal_gabung'));
	    $step1_tanggal_gabung 					= substr($step1_tanggal_gabung,4,4).'-'.substr($step1_tanggal_gabung,2,2).'-'.substr($step1_tanggal_gabung,0,2);
	    $step1_nama 							= $this->input->post('step1_nama');
	    $step1_panggilan 						= $this->input->post('step1_panggilan');
	    $step1_kelompok 						= $this->input->post('step1_kelompok');
	    $step1_setoran_lwk 						= $this->convert_numeric($this->input->post('step1_setoran_lwk'));
	    $step1_setoran_mingguan 				= $this->convert_numeric($this->input->post('step1_setoran_mingguan'));
	    $step2_pribadi_jenis_kelamin 			= $this->input->post('step2_pribadi_jenis_kelamin');
	    $step2_pribadi_ibu_kandung 				= $this->input->post('step2_pribadi_ibu_kandung');
	    $step2_pribadi_tmp_lahir 				= $this->input->post('step2_pribadi_tmp_lahir');
	    $step2_pribadi_tgl_lahir 				= $this->input->post('step2_pribadi_tgl_lahir');
	    $step2_pribadi_tgl_lahir 				= STR_REPLACE('/','',$step2_pribadi_tgl_lahir);
	    $step2_pribadi_tgl_lahir 				= substr($step2_pribadi_tgl_lahir,4,4).'-'.substr($step2_pribadi_tgl_lahir,2,2).'-'.substr($step2_pribadi_tgl_lahir,0,2);
	    $step2_pribadi_usia 					= $this->input->post('step2_pribadi_usia');
	    $step2_pribadi_no_ktp 					= $this->input->post('step2_pribadi_no_ktp');
	    $step2_pribadi_no_hp 					= $this->input->post('step2_pribadi_no_hp');
	    $step2_pribadi_pengguna_dana 			= $this->input->post('step2_pribadi_pengguna_dana');
	    $step2_pribadi_alamat 					= $this->input->post('step2_pribadi_alamat');
	    $step2_pribadi_rt 						= $this->input->post('step2_pribadi_rt');
	    $step2_pribadi_rw 						= $this->input->post('step2_pribadi_rw');
	    $step2_pribadi_desa 					= $this->input->post('step2_pribadi_desa');
	    $step2_pribadi_kecamatan 				= $this->input->post('step2_pribadi_kecamatan');
	    $step2_pribadi_kabupaten 				= $this->input->post('step2_pribadi_kabupaten');
	    $step2_pribadi_kodepos 					= $this->input->post('step2_pribadi_kodepos');
	    $step2_pribadi_koresponden_alamat 		= $this->input->post('step2_pribadi_koresponden_alamat');
	    $step2_pribadi_koresponden_rt 			= $this->input->post('step2_pribadi_koresponden_rt');
	    $step2_pribadi_koresponden_rw 			= $this->input->post('step2_pribadi_koresponden_rw');
	    $step2_pribadi_koresponden_desa 		= $this->input->post('step2_pribadi_koresponden_desa');
	    $step2_pribadi_koresponden_kecamatan 	= $this->input->post('step2_pribadi_koresponden_kecamatan');
	    $step2_pribadi_koresponden_kabupaten 	= $this->input->post('step2_pribadi_koresponden_kabupaten');
	    $step2_pribadi_koresponden_kodepos 		= $this->input->post('step2_pribadi_koresponden_kodepos');
	    $step2_pribadi_pendidikan 				= $this->input->post('step2_pribadi_pendidikan');
	    $step2_pribadi_pekerjaan 				= $this->input->post('step2_pribadi_pekerjaan');
	    $step2_pribadi_pendapatan 				= $this->convert_numeric($this->input->post('step2_pribadi_pendapatan'));
	    $step2_pribadi_ket_pekerjaan 			= $this->input->post('step2_pribadi_ket_pekerjaan');
	    $step2_pribadi_literasi_latin 			= $this->input->post('step2_pribadi_literasi_latin');
	    $step2_pribadi_literasi_arab 			= $this->input->post('step2_pribadi_literasi_arab');
		$step2_pasangan_nama 					= $this->input->post('step2_pasangan_nama');
	    $step2_pasangan_tmplahir 				= $this->input->post('step2_pasangan_tmplahir');
	    $step2_pasangan_tglahir 				= $this->input->post('step2_pasangan_tglahir');
	    $step2_pasangan_tglahir 				= STR_REPLACE('/','',$step2_pasangan_tglahir);
	    $step2_pasangan_tglahir 				= substr($step2_pasangan_tglahir,4,4).'-'.substr($step2_pasangan_tglahir,2,2).'-'.substr($step2_pasangan_tglahir,0,2);
	    $step2_pasangan_usia 					= $this->input->post('step2_pasangan_usia');
	    $step2_pasangan_no_ktp 					= $this->input->post('step2_pasangan_no_ktp');
	    $step2_pasangan_no_hp 					= $this->input->post('step2_pasangan_no_hp');
	    $step2_pasangan_pendidikan 				= $this->input->post('step2_pasangan_pendidikan');
	    $step2_pasangan_pekerjaan 				= $this->input->post('step2_pasangan_pekerjaan');
	    $step2_pasangan_pendapatan 				= $this->convert_numeric($this->input->post('step2_pasangan_pendapatan'));
	    $step2_pasangan_ketpekerjaan 			= $this->input->post('step2_pasangan_ketpekerjaan');
	    $step2_pasangan_jmlkeluarga 			= $this->input->post('step2_pasangan_jmlkeluarga');
	    $step2_pasangan_jmltanggungan 			= $this->input->post('step2_pasangan_jmltanggungan');
	    $step2_pasangan_literasi_latin 			= $this->input->post('step2_pasangan_literasi_latin');
	    $step2_pasangan_literasi_arab 			= $this->input->post('step2_pasangan_literasi_arab');
	    $step3_rmhstatus 						= $this->input->post('step3_rmhstatus');
	    $step3_rekening_listrik 				= $this->input->post('step3_rekening_listrik');
	    $step3_rekening_listrik_biaya 			= $this->convert_numeric($this->input->post('step3_rekening_listrik_biaya'));
	    $step3_rekening_pdam 					= $this->input->post('step3_rekening_pdam');
	    $step3_rekening_pdam_biaya 				= $this->convert_numeric($this->input->post('step3_rekening_pdam_biaya'));
	    $step3_bpjs 							= $this->input->post('step3_bpjs');
	    $step3_bpjs_biaya 						= $this->convert_numeric($this->input->post('step3_bpjs_biaya'));
	    $step3_rmhukuran 						= $this->input->post('step3_rmhukuran');
	    $step3_rmhdinding 						= $this->input->post('step3_rmhdinding');
	    $step3_rmhatap 							= $this->input->post('step3_rmhatap');
	    $step3_rmhlantai 						= $this->input->post('step3_rmhlantai');
	    $step3_rmhjamban 						= $this->input->post('step3_rmhjamban');
	    $step3_rmhair 							= $this->input->post('step3_rmhair');
	    $step3_lahansawah 						= $this->input->post('step3_lahansawah');
	    $step3_lahankebun 						= $this->input->post('step3_lahankebun');
	    $step3_lahanpekarangan 					= $this->input->post('step3_lahanpekarangan');
	    $step3_ternakunggas 					= $this->input->post('step3_ternakunggas');
	    $step3_ternakdomba 						= $this->input->post('step3_ternakdomba');
	    $step3_sapi_ternakkerbau 				= $this->input->post('step3_sapi_ternakkerbau');
	    $step3_kendsepeda 						= $this->input->post('step3_kendsepeda');
	    $step3_kendmotor 						= $this->input->post('step3_kendmotor');
	    $step3_elektape 						= $this->input->post('step3_elektape');
	    $step3_elekplayer 						= $this->input->post('step3_elekplayer');
	    $step3_elektv 							= $this->input->post('step3_elektv');
	    $step3_elekkulkas 						= $this->input->post('step3_elekkulkas');
	    $step3_kendsepeda 						= $this->input->post('step3_kendsepeda');
	    $step3_kendmotor 						= $this->input->post('step3_kendmotor');
	    $step4_ushrumahtangga 					= $this->input->post('step4_ushrumahtangga');
	    $step4_ushkomoditi 						= $this->input->post('step4_ushkomoditi');
	    $step4_ushlokasi 						= $this->input->post('step4_ushlokasi');
	    $step4_ushomset 						= $this->convert_numeric($this->input->post('step4_ushomset'));
	    $step4_byaberas 						= $this->convert_numeric($this->input->post('step4_byaberas'));
	    $step4_byadapur 						= $this->convert_numeric($this->input->post('step4_byadapur'));
	    $step4_byalistrik 						= $this->convert_numeric($this->input->post('step4_byalistrik'));
	    $step4_byatelpon 						= $this->convert_numeric($this->input->post('step4_byatelpon'));
	    $step4_byasekolah 						= $this->convert_numeric($this->input->post('step4_byasekolah'));
	    $step4_byalain 							= $this->convert_numeric($this->input->post('step4_byalain'));

	    $cif_id 								= md5(date('Y-m-d H:i:s'));
	    $branch_code 							= $this->model_cif->get_branch_code_by_cm($cm_code);
	    $data_cif = array(
	    		 'nama' 					=> ($step1_nama=="") ? null : $step1_nama
	    		,'cif_id' 					=> ($cif_id=="") ? null : $cif_id
	    		,'cm_code' 					=> ($cm_code=="") ? null : $cm_code
				,'tgl_gabung' 				=> ($step1_tanggal_gabung=="") ? null : $step1_tanggal_gabung
				,'panggilan' 				=> ($step1_panggilan=="") ? null : $step1_panggilan
				,'kelompok' 				=> ($step1_kelompok=="") ? null : $step1_kelompok
				,'jenis_kelamin' 			=> ($step2_pribadi_jenis_kelamin=="") ? null : $step2_pribadi_jenis_kelamin
				,'ibu_kandung' 				=> ($step2_pribadi_ibu_kandung=="") ? null : $step2_pribadi_ibu_kandung
				,'tmp_lahir' 				=> ($step2_pribadi_tmp_lahir=="") ? null : $step2_pribadi_tmp_lahir
				,'tgl_lahir' 				=> ($step2_pribadi_tgl_lahir=="--") ? null : $step2_pribadi_tgl_lahir
				,'usia' 					=> ($step2_pribadi_usia=="") ? null : $step2_pribadi_usia
				,'no_ktp' 					=> ($step2_pribadi_no_ktp=="") ? null : $step2_pribadi_no_ktp
				,'no_hp' 					=> ($step2_pribadi_no_hp=="") ? null : $step2_pribadi_no_hp
				,'alamat' 					=> ($step2_pribadi_alamat=="") ? null : $step2_pribadi_alamat
				,'rt_rw' 					=> ($step2_pribadi_rt.'/'.$step2_pribadi_rw=="") ? null : $step2_pribadi_rt.'/'.$step2_pribadi_rw
				,'desa' 					=> ($step2_pribadi_desa=="") ? null : $step2_pribadi_desa
				,'kecamatan' 				=> ($step2_pribadi_kecamatan=="") ? null : $step2_pribadi_kecamatan
				,'kabupaten' 				=> ($step2_pribadi_kabupaten=="") ? null : $step2_pribadi_kabupaten
				,'kodepos' 					=> ($step2_pribadi_kodepos=="") ? null : $step2_pribadi_kodepos
				,'koresponden_alamat' 		=> ($step2_pribadi_koresponden_alamat=="") ? null : $step2_pribadi_koresponden_alamat
				,'koresponden_rt_rw' 		=> ($step2_pribadi_koresponden_rt.'/'.$step2_pribadi_koresponden_rw=="") ? null : $step2_pribadi_koresponden_rt.'/'.$step2_pribadi_koresponden_rw
				,'koresponden_desa' 		=> ($step2_pribadi_koresponden_desa=="") ? null : $step2_pribadi_koresponden_desa
				,'koresponden_kecamatan' 	=> ($step2_pribadi_koresponden_kecamatan=="") ? null : $step2_pribadi_koresponden_kecamatan
				,'koresponden_kabupaten' 	=> ($step2_pribadi_koresponden_kabupaten=="") ? null : $step2_pribadi_koresponden_kabupaten
				,'koresponden_kodepos' 		=> ($step2_pribadi_koresponden_kodepos=="") ? null : $step2_pribadi_koresponden_kodepos
				,'pendidikan' 				=> ($step2_pribadi_pendidikan=="") ? null : $step2_pribadi_pendidikan
				,'pekerjaan' 				=> ($step2_pribadi_pekerjaan=="") ? null : $step2_pribadi_pekerjaan
				,'ket_pekerjaan' 			=> ($step2_pribadi_ket_pekerjaan=="") ? null : $step2_pribadi_ket_pekerjaan
				,'branch_code' 				=> $branch_code
				,'cif_type' 				=> 0
				,'status' 					=> 1
	    	);
	    $data_cif_kelompok = array(
	    		 'setoran_lwk' 				=> ($step1_setoran_lwk=="")?null:$step1_setoran_lwk
	    		,'cif_id' 					=> ($cif_id=="")?null:$cif_id
	    		,'setoran_mingguan' 		=> ($step1_setoran_mingguan=="")?null:$step1_setoran_mingguan
	    		,'literasi_latin' 			=> ($step2_pribadi_literasi_latin==true) ? $step2_pribadi_literasi_latin : 0 
				,'literasi_arab' 			=> ($step2_pribadi_literasi_arab==true) ? $step2_pribadi_literasi_arab : 0 
				,'pendapatan' 				=> ($step2_pribadi_pendapatan=="")?null:$step2_pribadi_pendapatan
	    		,'p_nama' 					=> ($step2_pasangan_nama=="")?null:$step2_pasangan_nama
				,'p_tmplahir' 				=> ($step2_pasangan_tmplahir=="")?null:$step2_pasangan_tmplahir
				,'p_tglahir' 				=> ($step2_pasangan_tglahir=="--")?null:$step2_pasangan_tglahir
				,'p_usia' 					=> ($step2_pasangan_usia=="")?null:$step2_pasangan_usia
				,'p_no_ktp' 				=> ($step2_pasangan_no_ktp=="")?null:$step2_pasangan_no_ktp
				,'p_no_hp' 					=> ($step2_pasangan_no_hp=="")?null:$step2_pasangan_no_hp
				,'pengguna_dana'			=> ($step2_pribadi_pengguna_dana=="") ? null:$step2_pribadi_pengguna_dana
				,'p_pendidikan' 			=> ($step2_pasangan_pendidikan=="")?null:$step2_pasangan_pendidikan
				,'p_pekerjaan' 				=> ($step2_pasangan_pekerjaan=="")?null:$step2_pasangan_pekerjaan
				,'p_ketpekerjaan'			=> ($step2_pasangan_ketpekerjaan=="")?null:$step2_pasangan_ketpekerjaan
				,'p_pendapatan' 			=> ($step2_pasangan_pendapatan=="")?null:$step2_pasangan_pendapatan
				,'p_periodependapatan' 		=> ($step2_pasangan_pendapatan=="")?null:$step2_pasangan_pendapatan
				,'p_literasi_latin' 		=> ($step2_pasangan_literasi_latin==true) ? $step2_pasangan_literasi_latin : 0
				,'p_literasi_arab' 			=> ($step2_pasangan_literasi_arab==true) ? $step2_pasangan_literasi_arab : 0
				,'p_jmltanggungan' 			=> ($step2_pasangan_jmltanggungan=="")?null:$step2_pasangan_jmltanggungan
				,'p_jmlkeluarga'	 		=> ($step2_pasangan_jmlkeluarga=="")?null:$step2_pasangan_jmlkeluarga
				,'rmhstatus' 				=> ($step3_rmhstatus=="")?null:$step3_rmhstatus
				,'rekening_listrik' 		=> ($step3_rekening_listrik=="")?null:$step3_rekening_listrik
				,'rekening_listrik_biaya' 	=> ($step3_rekening_listrik_biaya=="")?null:$step3_rekening_listrik_biaya
				,'rekening_pdam' 			=> ($step3_rekening_pdam=="")?null:$step3_rekening_pdam
				,'rekening_pdam_biaya' 		=> ($step3_rekening_pdam_biaya=="")?null:$step3_rekening_pdam_biaya
				,'bpjs' 					=> ($step3_bpjs=="")?null:$step3_bpjs
				,'bpjs_biaya' 				=> ($step3_bpjs_biaya=="")?null:$step3_bpjs_biaya
				,'rmhukuran' 				=> ($step3_rmhukuran=="")?null:$step3_rmhukuran
				,'rmhatap' 					=> ($step3_rmhatap=="")?null:$step3_rmhatap
				,'rmhdinding' 				=> ($step3_rmhdinding=="")?null:$step3_rmhdinding
				,'rmhlantai' 				=> ($step3_rmhlantai=="")?null:$step3_rmhlantai
				,'rmhjamban' 				=> ($step3_rmhjamban=="")?null:$step3_rmhjamban
				,'rmhair' 					=> ($step3_rmhair=="")?null:$step3_rmhair
				,'lahansawah' 				=> ($step3_lahansawah=="")?null:$step3_lahansawah
				,'lahankebun' 				=> ($step3_lahankebun=="")?null:$step3_lahankebun
				,'lahanpekarangan' 			=> ($step3_lahanpekarangan=="")?null:$step3_lahanpekarangan
				,'ternakkerbau' 			=> ($step3_sapi_ternakkerbau=="")?null:$step3_sapi_ternakkerbau
				,'ternakdomba' 				=> ($step3_ternakdomba=="")?null:$step3_ternakdomba
				,'ternakunggas' 			=> ($step3_ternakunggas=="")?null:$step3_ternakunggas
				,'elektape' 				=> ($step3_elektape == false) ? 0 : $step3_elektape
				,'elektv' 					=> ($step3_elektv == false) ? 0 : $step3_elektv
				,'elekplayer' 				=> ($step3_elekplayer == false) ? 0 : $step3_elekplayer
				,'elekkulkas' 				=> ($step3_elekkulkas == false) ? 0 : $step3_elekkulkas
				,'kendsepeda' 				=> ($step3_kendsepeda=="")?null:$step3_kendsepeda
				,'kendmotor' 				=> ($step3_kendmotor=="")?null:$step3_kendmotor
				,'ushrumahtangga' 			=> ($step4_ushrumahtangga=="")?null:$step4_ushrumahtangga
				,'ushkomoditi' 				=> ($step4_ushkomoditi=="")?null:$step4_ushkomoditi
				,'ushlokasi' 				=> ($step4_ushlokasi=="")?null:$step4_ushlokasi
				,'ushomset' 				=> ($step4_ushomset=="")?null:$step4_ushomset
				,'byaberas' 				=> ($step4_byaberas=="")?null:$step4_byaberas
				,'byadapur' 				=> ($step4_byadapur=="")?null:$step4_byadapur
				,'byalistrik' 				=> ($step4_byalistrik=="")?null:$step4_byalistrik
				,'byatelpon' 				=> ($step4_byatelpon=="")?null:$step4_byatelpon
				,'byasekolah'	 			=> ($step4_byasekolah=="")?null:$step4_byasekolah
				,'byalain' 					=> ($step4_byalain=="")?null:$step4_byalain
	    	);
		
		$this->db->trans_begin();
		$this->model_cif->insert_cif($data_cif);
		$this->model_cif->insert_cif_kelompok($data_cif_kelompok);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'Add CIF Successed!');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Add CIF Failed!');
		}

		echo json_encode($return);
	}

	public function datatable_cif_kelompok()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_cif.cif_no','mfi_cif.nama', 'mfi_cm.cm_name', 'mfi_cif.kelompok','mfi_cif.status','');
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		// if($cm_code!="")
		// {
		if($sWhere==""){
			$sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		}else{
			$sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
		}
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_cif->datatable_cif_kelompok($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_cif_kelompok($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_cif_kelompok(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['cif_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['cm_name'];
			$row[] = $aRow['kelompok'];
			if($aRow['status']==0){
				$status = '<span class="btn mini blue-stripe">register</span>';
			}else if($aRow['status']==1){
				$status = '<span class="btn mini green-stripe">aktif</span>';
			}else{
				$status = '<span class="btn mini red-stripe">tidak aktif</span>';
			}
			$row[] = $status;
			$row[] = '<div align="center"><a href="javascript:;" cif_id="'.$aRow['cif_id'].'" id="link-edit" class="btn mini purple">Edit</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_cif_kelompok()
	{
		$cif_id = $this->input->post('cif_id');
		$data = $this->model_cif->get_cif_kelompok_by_cif_id($cif_id);

		echo json_encode($data);
	}

	public function update_cif_kelompok()
	{
		// $cm_code 							= $this->input->post('cm_code');
		$cif_id 								= $this->input->post('cif_id');
		$step1_cif_no 							= $this->input->post('step1_cif_no');
	    $step1_tanggal_gabung 					= str_replace('/','',$this->input->post('step1_tanggal_gabung'));
	    $step1_tanggal_gabung 					= substr($step1_tanggal_gabung,4,4).'-'.substr($step1_tanggal_gabung,2,2).'-'.substr($step1_tanggal_gabung,0,2);
	    $step1_nama 							= $this->input->post('step1_nama');
	    $step1_panggilan 						= $this->input->post('step1_panggilan');
	    $step1_kelompok 						= $this->input->post('step1_kelompok');
	    $step1_setoran_lwk 						= $this->convert_numeric($this->input->post('step1_setoran_lwk'));
	    $step1_setoran_mingguan 				= $this->convert_numeric($this->input->post('step1_setoran_mingguan'));
	    $step2_pribadi_jenis_kelamin 			= $this->input->post('step2_pribadi_jenis_kelamin');
	    $step2_pribadi_ibu_kandung 				= $this->input->post('step2_pribadi_ibu_kandung');
	    $step2_pribadi_tmp_lahir 				= $this->input->post('step2_pribadi_tmp_lahir');
	    $step2_pribadi_tgl_lahir 				= $this->input->post('step2_pribadi_tgl_lahir');
	    $step2_pribadi_tgl_lahir 				= str_replace('/','',$step2_pribadi_tgl_lahir);
	    $step2_pribadi_tgl_lahir 				= substr($step2_pribadi_tgl_lahir,4,4).'-'.substr($step2_pribadi_tgl_lahir,2,2).'-'.substr($step2_pribadi_tgl_lahir,0,2);
	    $step2_pribadi_usia 					= $this->input->post('step2_pribadi_usia');
	    $step2_pribadi_no_ktp 					= $this->input->post('step2_pribadi_no_ktp');
	    $step2_pribadi_no_hp 					= $this->input->post('step2_pribadi_no_hp');
	    $step2_pribadi_pengguna_dana			= $this->input->post('step2_pribadi_pengguna_dana');
	    $step2_pribadi_alamat 					= $this->input->post('step2_pribadi_alamat');
	    $step2_pribadi_rt 						= $this->input->post('step2_pribadi_rt');
	    $step2_pribadi_rw 						= $this->input->post('step2_pribadi_rw');
	    $step2_pribadi_desa 					= $this->input->post('step2_pribadi_desa');
	    $step2_pribadi_kecamatan 				= $this->input->post('step2_pribadi_kecamatan');
	    $step2_pribadi_kabupaten 				= $this->input->post('step2_pribadi_kabupaten');
	    $step2_pribadi_kodepos 					= $this->input->post('step2_pribadi_kodepos');
	    $step2_pribadi_koresponden_alamat 		= $this->input->post('step2_pribadi_koresponden_alamat');
	    $step2_pribadi_koresponden_rt 			= $this->input->post('step2_pribadi_koresponden_rt');
	    $step2_pribadi_koresponden_rw 			= $this->input->post('step2_pribadi_koresponden_rw');
	    $step2_pribadi_koresponden_desa 		= $this->input->post('step2_pribadi_koresponden_desa');
	    $step2_pribadi_koresponden_kecamatan 	= $this->input->post('step2_pribadi_koresponden_kecamatan');
	    $step2_pribadi_koresponden_kabupaten 	= $this->input->post('step2_pribadi_koresponden_kabupaten');
	    $step2_pribadi_koresponden_kodepos 		= $this->input->post('step2_pribadi_koresponden_kodepos');
	    $step2_pribadi_pendidikan 				= $this->input->post('step2_pribadi_pendidikan');
	    $step2_pribadi_pekerjaan 				= $this->input->post('step2_pribadi_pekerjaan');
	    $step2_pribadi_pendapatan 				= $this->convert_numeric($this->input->post('step2_pribadi_pendapatan'));
	    $step2_pribadi_ket_pekerjaan 			= $this->input->post('step2_pribadi_ket_pekerjaan');
	    $step2_pribadi_literasi_latin 			= $this->input->post('step2_pribadi_literasi_latin');
	    $step2_pribadi_literasi_arab 			= $this->input->post('step2_pribadi_literasi_arab');
		$step2_pasangan_nama 					= $this->input->post('step2_pasangan_nama');
	    $step2_pasangan_tmplahir 				= $this->input->post('step2_pasangan_tmplahir');
	    $step2_pasangan_tglahir 				= $this->input->post('step2_pasangan_tglahir');
	    $step2_pasangan_tglahir 				= str_replace('/','',$step2_pasangan_tglahir);
	    $step2_pasangan_tglahir 				= substr($step2_pasangan_tglahir,4,4).'-'.substr($step2_pasangan_tglahir,2,2).'-'.substr($step2_pasangan_tglahir,0,2);
	    $step2_pasangan_usia 					= $this->input->post('step2_pasangan_usia');
	    $step2_pasangan_no_ktp 					= $this->input->post('step2_pasangan_no_ktp');
	    $step2_pasangan_no_hp 					= $this->input->post('step2_pasangan_no_hp');
	    $step2_pasangan_pendidikan 				= $this->input->post('step2_pasangan_pendidikan');
	    $step2_pasangan_pekerjaan 				= $this->input->post('step2_pasangan_pekerjaan');
	    $step2_pasangan_pendapatan 				= $this->convert_numeric($this->input->post('step2_pasangan_pendapatan'));
	    $step2_pasangan_ketpekerjaan 			= $this->input->post('step2_pasangan_ketpekerjaan');
	    $step2_pasangan_jmlkeluarga 			= $this->input->post('step2_pasangan_jmlkeluarga');
	    $step2_pasangan_jmltanggungan 			= $this->input->post('step2_pasangan_jmltanggungan');
	    $step2_pasangan_literasi_latin 			= $this->input->post('step2_pasangan_literasi_latin');
	    $step2_pasangan_literasi_arab 			= $this->input->post('step2_pasangan_literasi_arab');
	    $step3_rmhstatus 						= $this->input->post('step3_rmhstatus');

	    $step3_rekening_listrik 				= $this->input->post('step3_rekening_listrik');
	    $step3_rekening_listrik_biaya 			= $this->convert_numeric($this->input->post('step3_rekening_listrik_biaya'));
	    $step3_rekening_pdam 					= $this->input->post('step3_rekening_pdam');
	    $step3_rekening_pdam_biaya 				= $this->convert_numeric($this->input->post('step3_rekening_pdam_biaya'));
	    $step3_bpjs 							= $this->input->post('step3_bpjs');
	    $step3_bpjs_biaya 						= $this->convert_numeric($this->input->post('step3_bpjs_biaya'));

	    $step3_rmhukuran 						= $this->input->post('step3_rmhukuran');
	    $step3_rmhdinding 						= $this->input->post('step3_rmhdinding');
	    $step3_rmhatap 							= $this->input->post('step3_rmhatap');
	    $step3_rmhlantai 						= $this->input->post('step3_rmhlantai');
	    $step3_rmhjamban 						= $this->input->post('step3_rmhjamban');
	    $step3_rmhair 							= $this->input->post('step3_rmhair');
	    $step3_lahansawah 						= $this->input->post('step3_lahansawah');
	    $step3_lahankebun 						= $this->input->post('step3_lahankebun');
	    $step3_lahanpekarangan 					= $this->input->post('step3_lahanpekarangan');
	    $step3_ternakunggas 					= $this->input->post('step3_ternakunggas');
	    $step3_ternakdomba 						= $this->input->post('step3_ternakdomba');
	    $step3_sapi_ternakkerbau 				= $this->input->post('step3_sapi_ternakkerbau');
	    $step3_kendsepeda 						= $this->input->post('step3_kendsepeda');
	    $step3_kendmotor 						= $this->input->post('step3_kendmotor');
	    $step3_elektape 						= $this->input->post('step3_elektape');
	    $step3_elekplayer 						= $this->input->post('step3_elekplayer');
	    $step3_elektv 							= $this->input->post('step3_elektv');
	    $step3_elekkulkas 						= $this->input->post('step3_elekkulkas');
	    $step3_kendsepeda 						= $this->input->post('step3_kendsepeda');
	    $step3_kendmotor 						= $this->input->post('step3_kendmotor');
	    $step4_ushrumahtangga 					= $this->input->post('step4_ushrumahtangga');
	    $step4_ushkomoditi 						= $this->input->post('step4_ushkomoditi');
	    $step4_ushlokasi 						= $this->input->post('step4_ushlokasi');
	    $step4_ushomset 						= $this->convert_numeric($this->input->post('step4_ushomset'));
	    $step4_byaberas 						= $this->convert_numeric($this->input->post('step4_byaberas'));
	    $step4_byadapur 						= $this->convert_numeric($this->input->post('step4_byadapur'));
	    $step4_byalistrik 						= $this->convert_numeric($this->input->post('step4_byalistrik'));
	    $step4_byatelpon 						= $this->convert_numeric($this->input->post('step4_byatelpon'));
	    $step4_byasekolah 						= $this->convert_numeric($this->input->post('step4_byasekolah'));
	    $step4_byalain 							= $this->convert_numeric($this->input->post('step4_byalain'));

	    // $cif_id = rand(0,100000);
	    $param = array('cif_id'=>$cif_id);
	    $data_cif = array(
	    		 'nama' 						=> @$step1_nama
	    		// ,'cif_id' 					=> $get_cif_kelompok_by_cif_id
				,'tgl_gabung' 					=> ($step1_tanggal_gabung=="")?null:$step1_tanggal_gabung
				,'panggilan' 					=> ($step1_panggilan=="")?null:$step1_panggilan
				,'kelompok' 					=> ($step1_kelompok=="")?null:$step1_kelompok
				,'jenis_kelamin' 				=> ($step2_pribadi_jenis_kelamin=="")?null:$step2_pribadi_jenis_kelamin
				,'ibu_kandung' 					=> ($step2_pribadi_ibu_kandung=="")?null:$step2_pribadi_ibu_kandung
				,'tmp_lahir' 					=> ($step2_pribadi_tmp_lahir=="")?null:$step2_pribadi_tmp_lahir
				,'tgl_lahir' 					=> ($step2_pribadi_tgl_lahir=="")?null:$step2_pribadi_tgl_lahir
				,'usia' 						=> ($step2_pribadi_usia=="")?null:$step2_pribadi_usia
				,'no_ktp' 						=> ($step2_pribadi_no_ktp=="")?null:$step2_pribadi_no_ktp
				,'no_hp' 						=> ($step2_pribadi_no_hp=="")?null:$step2_pribadi_no_hp
				,'alamat' 						=> ($step2_pribadi_alamat=="")?null:$step2_pribadi_alamat
				,'rt_rw' 						=> @$step2_pribadi_rt.'/'.$step2_pribadi_rw
				,'desa' 						=> ($step2_pribadi_desa=="")?null:$step2_pribadi_desa
				,'kecamatan' 					=> ($step2_pribadi_kecamatan=="")?null:$step2_pribadi_kecamatan
				,'kabupaten' 					=> ($step2_pribadi_kabupaten=="")?null:$step2_pribadi_kabupaten
				,'kodepos' 						=> ($step2_pribadi_kodepos=="")?null:$step2_pribadi_kodepos
				,'koresponden_alamat' 			=> ($step2_pribadi_koresponden_alamat=="")?null:$step2_pribadi_koresponden_alamat
				,'koresponden_rt_rw' 			=> $step2_pribadi_koresponden_rt.'/'.$step2_pribadi_koresponden_rw
				,'koresponden_desa' 			=> ($step2_pribadi_koresponden_desa=="")?null:$step2_pribadi_koresponden_desa
				,'koresponden_kecamatan' 		=> ($step2_pribadi_koresponden_kecamatan=="")?null:$step2_pribadi_koresponden_kecamatan
				,'koresponden_kabupaten' 		=> ($step2_pribadi_koresponden_kabupaten=="")?null:$step2_pribadi_koresponden_kabupaten
				,'koresponden_kodepos' 			=> ($step2_pribadi_koresponden_kodepos=="")?null:$step2_pribadi_koresponden_kodepos
				,'pendidikan' 					=> ($step2_pribadi_pendidikan=="")?null:$step2_pribadi_pendidikan
				,'pekerjaan' 					=> ($step2_pribadi_pekerjaan=="")?null:$step2_pribadi_pekerjaan
				,'ket_pekerjaan' 				=> ($step2_pribadi_ket_pekerjaan=="")?null:$step2_pribadi_ket_pekerjaan
				// ,'branch_code' 					=> $this->session->userdata('branch_code')
	    	);
	    $data_cif_kelompok = array(
	    		 'setoran_lwk' 					=> @$step1_setoran_lwk
	    		// ,'cif_id' 					=> $cif_id
	    		,'setoran_mingguan' 			=> ($step1_setoran_mingguan=="")?null:$step1_setoran_mingguan
	    		,'literasi_latin' 				=> ($step2_pribadi_literasi_latin==true) ? $step2_pribadi_literasi_latin : 0 
				,'literasi_arab' 				=> ($step2_pribadi_literasi_arab==true) ? $step2_pribadi_literasi_arab : 0 
				,'pendapatan' 					=> ($step2_pribadi_pendapatan=="")?null:$step2_pribadi_pendapatan
	    		,'p_nama' 						=> ($step2_pasangan_nama=="")?null:$step2_pasangan_nama
				,'p_tmplahir' 					=> ($step2_pasangan_tmplahir=="")?null:$step2_pasangan_tmplahir
				,'p_tglahir' 					=> ($step2_pasangan_tglahir=="--")?null:$step2_pasangan_tglahir
				,'p_usia' 						=> ($step2_pasangan_usia=="")?null:$step2_pasangan_usia
				,'p_no_ktp' 					=> ($step2_pasangan_no_ktp=="")?null:$step2_pasangan_no_ktp
				,'p_no_hp' 						=> ($step2_pasangan_no_hp=="")?null:$step2_pasangan_no_hp
				,'pengguna_dana'				=> ($step2_pribadi_pengguna_dana=="") ? null:$step2_pribadi_pengguna_dana
				,'p_pendidikan' 				=> ($step2_pasangan_pendidikan=="")?null:$step2_pasangan_pendidikan
				,'p_pekerjaan' 					=> ($step2_pasangan_pekerjaan=="")?null:$step2_pasangan_pekerjaan
				,'p_ketpekerjaan' 				=> ($step2_pasangan_ketpekerjaan=="")?null:$step2_pasangan_ketpekerjaan
				,'p_pendapatan' 				=> ($step2_pasangan_pendapatan=="")?null:$step2_pasangan_pendapatan
				,'p_periodependapatan' 			=> ($step2_pasangan_pendapatan=="")?null:$step2_pasangan_pendapatan
				,'p_literasi_latin' 			=> ($step2_pasangan_literasi_latin==true) ? $step2_pasangan_literasi_latin : 0
				,'p_literasi_arab' 				=> ($step2_pasangan_literasi_arab==true) ? $step2_pasangan_literasi_arab : 0
				,'p_jmltanggungan' 				=> ($step2_pasangan_jmltanggungan=="")?null:$step2_pasangan_jmltanggungan
				,'p_jmlkeluarga' 				=> ($step2_pasangan_jmlkeluarga=="")?null:$step2_pasangan_jmlkeluarga
				,'rmhstatus' 					=> ($step3_rmhstatus=="")?null:$step3_rmhstatus

				,'rekening_listrik' 			=> ($step3_rekening_listrik=="")?null:$step3_rekening_listrik
				,'rekening_listrik_biaya' 		=> ($step3_rekening_listrik_biaya=="")?null:$step3_rekening_listrik_biaya
				,'rekening_pdam' 				=> ($step3_rekening_pdam=="")?null:$step3_rekening_pdam
				,'rekening_pdam_biaya' 			=> ($step3_rekening_pdam_biaya=="")?null:$step3_rekening_pdam_biaya
				,'bpjs' 						=> ($step3_bpjs=="")?null:$step3_bpjs
				,'bpjs_biaya' 					=> ($step3_bpjs_biaya=="")?null:$step3_bpjs_biaya

				,'rmhukuran' 					=> ($step3_rmhukuran=="")?null:$step3_rmhukuran
				,'rmhatap' 						=> ($step3_rmhatap=="")?null:$step3_rmhatap
				,'rmhdinding' 					=> ($step3_rmhdinding=="")?null:$step3_rmhdinding
				,'rmhlantai' 					=> ($step3_rmhlantai=="")?null:$step3_rmhlantai
				,'rmhjamban' 					=> ($step3_rmhjamban=="")?null:$step3_rmhjamban
				,'rmhair' 						=> ($step3_rmhair=="")?null:$step3_rmhair
				,'lahansawah' 					=> ($step3_lahansawah=="")?null:$step3_lahansawah
				,'lahankebun' 					=> ($step3_lahankebun=="")?null:$step3_lahankebun
				,'lahanpekarangan' 				=> ($step3_lahanpekarangan=="")?null:$step3_lahanpekarangan
				,'ternakkerbau' 				=> ($step3_sapi_ternakkerbau=="")?null:$step3_sapi_ternakkerbau
				,'ternakdomba' 					=> ($step3_ternakdomba=="")?null:$step3_ternakdomba
				,'ternakunggas' 				=> ($step3_ternakunggas=="")?null:$step3_ternakunggas
				,'elektape' 					=> ($step3_elektape == false) ? 0 : $step3_elektape
				,'elektv' 						=> ($step3_elektv == false) ? 0 : $step3_elektv
				,'elekplayer' 					=> ($step3_elekplayer == false) ? 0 : $step3_elekplayer
				,'elekkulkas' 					=> ($step3_elekkulkas == false) ? 0 : $step3_elekkulkas
				,'kendsepeda' 					=> ($step3_kendsepeda=="")?null:$step3_kendsepeda
				,'kendmotor'	 				=> ($step3_kendmotor=="")?null:$step3_kendmotor
				,'ushrumahtangga' 				=> ($step4_ushrumahtangga=="")?null:$step4_ushrumahtangga
				,'ushkomoditi' 					=> ($step4_ushkomoditi=="")?null:$step4_ushkomoditi
				,'ushlokasi' 					=> ($step4_ushlokasi=="")?null:$step4_ushlokasi
				,'ushomset' 					=> ($step4_ushomset=="")?null:$step4_ushomset
				,'byaberas' 					=> ($step4_byaberas=="")?null:$step4_byaberas
				,'byadapur' 					=> ($step4_byadapur=="")?null:$step4_byadapur
				,'byalistrik' 					=> ($step4_byalistrik=="")?null:$step4_byalistrik
				,'byatelpon' 					=> ($step4_byatelpon=="")?null:$step4_byatelpon
				,'byasekolah' 					=> ($step4_byasekolah=="")?null:$step4_byasekolah
				,'byalain' 						=> ($step4_byalain=="")?null:$step4_byalain
	    	);
		
		$this->db->trans_begin();
		$this->model_cif->update_cif($data_cif,$param);
		$this->model_cif->update_cif_kelompok($data_cif_kelompok,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'Edit CIF Successed!');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Edit CIF Failed!');
		}

		echo json_encode($return);
	}

	public function get_rembug_by_keyword()
	{
		$keyword 		= $this->input->post('keyword');
		$branch_code 	= $this->input->post('branch_code');

		$data = $this->model_cif->get_rembug_by_keyword($keyword,$branch_code);

		echo json_encode($data);
	}

	public function get_rembug_by_keyword_branch_id()
	{
		$keyword 		= $this->input->post('keyword');
		$branch_id 		= $this->input->post('branch_id');
		// $branch_code 	= $this->input->post('branch_code');

		$data = $this->model_cif->get_rembug_by_keyword_branch_id($keyword,$branch_id);

		echo json_encode($data);
	}

	public function get_rembug_by_keyword_danpetugas()
	{
		$keyword 		= $this->input->post('keyword');
		$petugas 		= $this->input->post('petugas');
		$branch_id 		= $this->input->post('branch_id');
		if($branch_id=="0000") $branch_id = "";
		$data = $this->model_cif->get_rembug_by_keyword_danpetugas($keyword,$branch_id,$petugas);

		echo json_encode($data);
	}


	public function delete_cif_kelompok()
	{
		$cif_id = $this->input->post('cif');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($cif_id) ; $i++ )
		{
			$param = array('cif_id'=>$cif_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_cif_kelompok($param);
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

	// [END] CIF KELOMPOK 
	
	/********************************************************************************************/

	// [BEGIN] CIF KELOMPOK LOG

	public function edit_cif_kelompok()
	{
		$data['container'] 				= 'cif/edit_cif_kelompok';
		// $data['branch'] 				= $this->model_cif->get_all_branch();
		$data['branch'] 				= $this->session->userdata('branch_id');
		$institution 					= $this->model_cif->get_institution();
		$data['default_setoran_lwk'] 	= $institution['setoran_lwk'];
		$data['default_minggon'] 		= $institution['minggon'];
		$data['current_date'] 			= $this->current_date();
		$this->load->view('core',$data);
	}

	// [BEGIN] BRANCH SETUP

	public function branch_setup()
	{
		$data['container'] = 'cif/branch_setup';
		$this->load->view('core',$data);
	}

	// [END] BRANCH SETUP

	/********************************************************************************************/

	// [BEGIN] SERVICE AREA SETUP

	public function service_area_setup()
	{
		$data['container'] = 'cif/service_area_setup';
		$this->load->view('core',$data);
	}

	// [END] SERVICE AREA  SETUP


	// ------------------------------------------------------------------------------------------
	// BEGIN REMBUG SETUP
	// ------------------------------------------------------------------------------------------

	public function rembug_setup()
	{
		$data['container'] 		= 'cif/rembug_setup';
		$data['branch_id'] 		= $this->session->userdata('branch_id');
		$data['branch_code'] 	= $this->session->userdata('branch_code');
		//$data['cabang'] 		= $this->model_cif->get_all_branch_();
		$data['petugas'] 		= $this->model_cif->get_all_petugas();
		$data['kecamatan'] 		= $this->model_cif->get_kecamatan();
		$data['branch'] 		= $this->model_cif->get_all_branch();
		$this->load->view('core',$data);
	}

	public function datatable_rembug_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */

		$branch_code = @$_GET['branch_code'];
		$aColumns = array( '','cm_name','mfi_kecamatan_desa.desa','');
				
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
			if($branch_code!="")
				$sWhere .= " and branch_code = '".$branch_code."'";
		}
		else
		{
			$sWhere .= "WHERE branch_code = '".$branch_code."'";
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_cif->datatable_rembug_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_rembug_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_rembug_setup(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['cm_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cm_name'];
			$row[] = $aRow['desa'];
			$row[] = '<a href="javascript:;" cm_id="'.$aRow['cm_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_rembug()
	{
		$cm_code 			= $this->input->post('id_rembug');
		$branch_name 		= $this->input->post('branch_name');
		$cm_name 			= $this->input->post('nama_rembug');
		$fa_code 			= $this->input->post('petugas_lapangan');
		$tgl_pembentukan 	= $this->input->post('tanggal_pembentukan');
		$hari_transaksi 	= $this->input->post('hari_transaksi');
		$branch_code 		= $this->input->post('add_branch_code');
		$desa_code 			= $this->input->post('desa_code');
		
		$branch_id 			= $this->model_cif->get_branch_id_by_branch_code($branch_code);

		$tgl =substr("$tgl_pembentukan",0,2);
	    $bln =substr("$tgl_pembentukan",2,2);
	    $thn =substr("$tgl_pembentukan",4,4);
	    $tglakhir = "$thn-$bln-$tgl";  
	    
		$data = array(
				'cm_code'			=> $cm_code,
				'cm_name'			=> $cm_name,
				'branch_id' 		=> $branch_id,
				'fa_code'  			=> $fa_code,
				'tgl_pembentukan'	=> $tglakhir,
				'created_by'		=> 'Admin',
				'created_timestamp'	=> date('Y-m-d H:i:s'),
				'hari_transaksi'	=> $hari_transaksi,
				'jam_transaksi'		=> date('H:i'),
				'desa_code'			=> $desa_code
			);
		$this->db->trans_begin();
		$this->model_cif->add_rembug($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_rembug()
	{
		$cm_id = $this->input->post('cm_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($cm_id) ; $i++ )
		{
			$param = array('cm_id'=>$cm_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_rembug($param);
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


	public function get_user_by_cm_id()
	{
		$cm_id = $this->input->post('cm_id');
		$data = $this->model_cif->get_user_by_cm_id($cm_id);

		echo json_encode($data);
	}


	public function edit_rembug()
	{
		$cm_id 			= $this->input->post('cm_id');
		$cm_name 		= $this->input->post('nama_rembug');
		$fa_code 		= $this->input->post('petugas_lapangan');
		$hari_transaksi = $this->input->post('hari_transaksi');
		$desa_code 		= $this->input->post('desa_code');

		$param = array('cm_id'=>$cm_id);
		$data = array(
				 'cm_name'			=> $cm_name
				,'fa_code'  			=> $fa_code
				,'hari_transaksi'	=> $hari_transaksi
				,'desa_code'			=> $desa_code
			);

		$this->db->trans_begin();
		$this->model_cif->edit_rembug($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	
	public function get_ajax_branch_code_()
	{
		$branch_code 	= $this->input->post('branch_code');
		$branch_id 		= $this->model_cif->get_branch_id_by_branch_code($branch_code);
		$data 			= $this->model_cif->get_ajax_branch_code_($branch_id);

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
            $no_urut_ = sprintf('%04s', $no_urut);            
            $no_urut_rembug = $branch_code.''.$no_urut_;

		echo $no_urut_rembug;
	}
	
	
	public function get_ajax_name()
	{
		$input		= $this->input->post('code');
		$code		= substr($input,0,4);
		$id 		= substr($input,4);
		$data		= $this->model_cif->get_all_petugas_($id);
		
		echo json_encode($data);
	}



	// ------------------------------------------------------------------------------------------
	// END REMBUG SETUP
	// ------------------------------------------------------------------------------------------


		// [BEGIN] BRANCH {KANTOR CABANG}

	public function kantor_cabang()
	{
		$data['container'] = 'cif/branch_kantor_cabang';
		$data['cabang'] = $this->model_cif->get_all_branch();
		$this->load->view('core',$data);
	}

	public function datatable_kantor_cabang_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','branch_code', 'branch_name','branch_class','branch_officer_name','display_text','');
				
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
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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
		$rResult 			= $this->model_cif->datatable_kantor_cabang_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_kantor_cabang_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_kantor_cabang_setup(); // get number of all data
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
			
			if($aRow['branch_class']==0)
				{$jenis="Pusat";}
			else if($aRow['branch_class']==1)
				{$jenis="Wilayah";}
			else if($aRow['branch_class']==2)
				{$jenis="Cabang";}
			else
				{$jenis="Unit";}

			$row[] = '<input type="checkbox" value="'.$aRow['branch_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['branch_code'];
			$row[] = $aRow['branch_name'];
			$row[] = $jenis;
			$row[] = $aRow['branch_officer_name'];
			$row[] = $aRow['display_text'];
			$row[] = '<center><a href="javascript:;" branch_id="'.$aRow['branch_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function datatable_status_kantor_cabang()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','branch_code', 'branch_name','branch_class','branch_officer_name','display_text','');
				
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
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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
		$rResult 			= $this->model_cif->datatable_status_kantor_cabang($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_status_kantor_cabang($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_status_kantor_cabang(); // get number of all data
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
			
			if($aRow['branch_class']==0)
				{$jenis="Pusat";}
			else if($aRow['branch_class']==1)
				{$jenis="Wilayah";}
			else if($aRow['branch_class']==2)
				{$jenis="Cabang";}
			else
				{$jenis="Unit";}

			$row[] = '<input type="checkbox" value="'.$aRow['branch_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['branch_code'];
			$row[] = $aRow['branch_name'];
			$row[] = $jenis;
			$row[] = $aRow['branch_officer_name'];
			$row[] = $aRow['display_text'];
			$row[] = '<center><a href="javascript:;" branch_id="'.$aRow['branch_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	/*******************************************************************/
	// Ade, cabang 5 digit 13-11-2014
	public function add_kantor_cabang()
	{
		$branch_name 			= $this->input->post('branch_name');
		$branch_induk 			= $this->input->post('branch_induk');
		$branch_class 			= $this->input->post('branch_class');
		$branch_code 			= $this->input->post('branch_code');
		$branch_officer_title 	= $this->input->post('branch_officer_title');
		$branch_officer_name 	= $this->input->post('branch_officer_name');
		$wilayah 				= $this->input->post('wilayah');

		if($branch_induk=="")
		{
			$data = array(
				'branch_name'			=> $branch_name,
				'branch_code' 			=> $branch_code,
				'branch_officer_title' 	=> $branch_officer_title,
				'branch_officer_name' 	=> $branch_officer_name,
				'branch_status' 		=> '1',
				'wilayah' 				=> $wilayah,
				'branch_class' 			=> $branch_class
				);
		}
		else
		{
			$data = array(
				'branch_name'			=> $branch_name,
				'branch_code' 			=> $branch_code,
				'branch_officer_title' 	=> $branch_officer_title,
				'branch_officer_name' 	=> $branch_officer_name,
				'branch_status' 		=> '1',
				'branch_class' 			=> $branch_class,
				'wilayah' 				=> $wilayah,
				'branch_induk' 			=> $branch_induk
				);
		}

		/**
		* description branch_class
		* 1 = wilayah
		* 2 = cabang
		* 3 = capem
		*/
		$branch_member = array();
		if($branch_class==1){
			// branch_induk = wilayah & branch_child/code = wilayah
			$branch_member[]=array(
					'branch_induk' => $branch_code,
					'branch_code' => $branch_code
				);
		}else if($branch_class==2){
			// branch_induk = cabang & branch_child/code = cabang
			$branch_member[]=array(
					'branch_induk' => $branch_code,
					'branch_code' => $branch_code
				);
			// branch_induk = wilayah & branch_child/code = cabang
			$branch_member[]=array(
					'branch_induk' => $branch_induk,
					'branch_code' => $branch_code
				);
		}else if($branch_class==3){
			// branch_induk = capem & branch_child/code = capem
			$branch_member[]=array(
					'branch_induk' => $branch_code,
					'branch_code' => $branch_code
				);
			// branch_induk = cabang & branch_child/code = capem
			$branch_member[]=array(
					'branch_induk' => $branch_induk,
					'branch_code' => $branch_code
				);

			$wilayah_code = $this->model_cif->get_wilayah_code_by_branch_induk($branch_induk);
			// branch_induk = wilayah & branch_child/code = capem
			$branch_member[]=array(
					'branch_induk' => $wilayah_code,
					'branch_code' => $branch_code
				);
		}

		$this->db->trans_begin();
		$this->model_cif->add_kantor_cabang($data);
		if(count($branch_member)>0){
			$this->model_cif->add_branch_member($branch_member);
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
	// END Ade, cabang 5 digit 13-11-2014
	/*******************************************************************/

	public function add_kantor_cabangOld()
	{
		$branch_name 			= $this->input->post('branch_name');
		$branch_induk 			= $this->input->post('branch_induk');
		$branch_class 			= $this->input->post('branch_class');
		$branch_code 			= $this->input->post('branch_code');
		$branch_officer_title 	= $this->input->post('branch_officer_title');
		$branch_officer_name 	= $this->input->post('branch_officer_name');

		if($branch_induk=="")
		{
			$data = array(
				'branch_name'			=> $branch_name,
				'branch_code' 			=> $branch_code,
				'branch_officer_title' 	=> $branch_officer_title,
				'branch_officer_name' 	=> $branch_officer_name,
				'branch_status' 		=> '1',
				'branch_class' 			=> $branch_class
				);
		}
		else
		{
			$data = array(
				'branch_name'			=> $branch_name,
				'branch_code' 			=> $branch_code,
				'branch_officer_title' 	=> $branch_officer_title,
				'branch_officer_name' 	=> $branch_officer_name,
				'branch_status' 		=> '1',
				'branch_class' 			=> $branch_class,
				'branch_induk' 			=> $branch_induk
				);
		}
		

		$this->db->trans_begin();
		$this->model_cif->add_kantor_cabang($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_kantor_cabangOld()
	{
		$branch_id = $this->input->post('branch_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($branch_id) ; $i++ )
		{
			$param = array('branch_id'=>$branch_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_kantor_cabang($param);
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

	public function delete_kantor_cabang()
	{
		$branch_id = $this->input->post('branch_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($branch_id) ; $i++ )
		{	
			$branch_code = $this->model_cif->get_branch_code_by_branch_id($branch_id[$i]);
			$param = array('branch_id'=>$branch_id[$i]);
			$param2 = array('branch_code'=>$branch_code);
			$this->db->trans_begin();
			$this->model_cif->delete_kantor_cabang($param);
			$this->model_cif->delete_kantor_cabang_member($param2);
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

	public function get_branch_by_branch_id()
	{
		$branch_id 	= $this->input->post('branch_id');
		$data 		= $this->model_cif->get_branch_by_branch_id($branch_id);

		echo json_encode($data);
	}

	public function get_branch_status_by_branch_id()
	{
		$branch_id 	= $this->input->post('branch_id');
		$data 		= $this->model_cif->get_branch_status_by_branch_id($branch_id);

		echo json_encode($data);
	}

	public function edit_kantor_cabang()
	{
		$branch_id 				= $this->input->post('branch_id');
		$branch_name 			= $this->input->post('branch_name');
		$branch_code 			= $this->input->post('branch_code');
		$branch_induk 			= $this->input->post('branch_induk');
		$branch_class 			= $this->input->post('branch_class');
		$branch_officer_name 	= $this->input->post('branch_officer_name');
		$branch_officer_title 	= $this->input->post('branch_officer_title');

		$param = array('branch_id'=>$branch_id);


		if($branch_induk=="")
		{
			$data = array(
				'branch_name'			=> $branch_name,
				'branch_code' 			=> $branch_code,
				'branch_officer_name' 	=> $branch_officer_name,
				'branch_officer_title' 	=> $branch_officer_title,
				'branch_class' 			=> $branch_class
				);
		}
		else
		{
			$data = array(
				'branch_name'			=> $branch_name,
				'branch_code' 			=> $branch_code,
				'branch_class' 			=> $branch_class,
				'branch_officer_name' 	=> $branch_officer_name,
				'branch_officer_title' 	=> $branch_officer_title,
				'branch_induk' 			=> $branch_induk
				);
		}

		$this->db->trans_begin();
		$this->model_cif->edit_kantor_cabang($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function edit_status_kantor_cabang()
	{
		$branch_id 				= $this->input->post('branch_id');
		$branch_name 			= $this->input->post('branch_name');
		$branch_induk 			= $this->input->post('branch_induk');
		$branch_status 			= $this->input->post('branch_status');

		$param = array('branch_id'=>$branch_id);

			$data = array(
				'branch_name'			=> $branch_name,
				'branch_induk' 			=> $branch_induk,
				'branch_status' 		=> $branch_status
				);
		

		$this->db->trans_begin();
		$this->model_cif->edit_status_kantor_cabang($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function ajax_get_branch_id()
	{
		$branch_class = $this->input->post('branch_class');
		$id = substr(($branch_class),0,3);

		echo $id;
	}

	// [END] BRANCH {KANTOR CABANG}

	// [BEGIN] PETUGAS LAPANGAN SETUP

	public function petugas_lapangan()
	{
		$data['container'] = 'cif/petugas_lapangan';
		$data['cabang'] = $this->model_cif->get_all_branch_();
		$this->load->view('core',$data);
	}

	public function datatable_petugas_lapangan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '' ,'fa_id','fa_name','');
				
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_cif->datatable_petugas_lapangan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_petugas_lapangan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_petugas_lapangan(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['fa_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['fa_code'];
			$row[] = $aRow['fa_name'];
			$row[] = $aRow['branch_name'];
			$row[] = '<center><a href="javascript:;" fa_id="'.$aRow['fa_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_petugas()
	{
		$branch_name		= $this->input->post('branch_name');
		$id_petugas			= $this->input->post('id_petugas');
		$nama_petugas		= $this->input->post('nama_petugas');
		$level				= $this->input->post('level');
		$tgl_gabung			= $this->input->post('tanggal_bergabung');
		$tgl_gabung     	= str_replace('/', '', $tgl_gabung);
		$tgl 				= substr("$tgl_gabung",0,2);
	    $bln 				= substr("$tgl_gabung",2,2);
	    $thn 				= substr("$tgl_gabung",4,4);
	    $tglakhir 			= "$thn-$bln-$tgl";  

	$data = array(
					'branch_code'		=> $branch_name,
					'fa_code'			=> $id_petugas,
					'fa_name'			=> $nama_petugas,
					'fa_level'			=> $level,
					'tgl_gabung'		=> $tglakhir,
					'created_by'		=> $this->session->userdata('user_id'),
					'created_timestamp'	=> date('Y-m-d H:i:s')
				);

		$this->db->trans_begin();
		$this->model_cif->add_petugas($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}


	public function delete_petugas()
	{
		$fa_id = $this->input->post('fa_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($fa_id) ; $i++ )
		{
			$param = array('fa_id'=>$fa_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_petugas($param);
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

	public function edit_petugas()
	{
		$fa_id 			= $this->input->post('fa_id');
		$branch_name 	= $this->input->post('branch_name2');
		$id_petugas2 	= $this->input->post('id_petugas2');
		$fa_name 		= $this->input->post('nama_petugas');
		$level 			= $this->input->post('level');

		$param = array('fa_id'=>$fa_id);
		$data = array(
				'fa_name'		=> $fa_name,
				'fa_code'		=> $id_petugas2,
				'fa_level'		=> $level,
				'branch_code'	=> $branch_name
			);

		$this->db->trans_begin();
		$this->model_cif->edit_petugas($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function get_petugas_by_id()
	{
		$fa_id 	= $this->input->post('fa_id');
		$data 	= $this->model_cif->get_petugas_by_id($fa_id);

		echo json_encode($data);
	}

	public function search_cif_no()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_no($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	public function search_pemegang_rekening_bycif_no()
	{
		$cif_no 	= $this->input->post('cif_no');
		$data 		= $this->model_cif->search_pemegang_rekening_bycif_no($cif_no);

		echo json_encode($data);
	}

	public function search_cif_no2()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$data 		= $this->model_cif->search_cif_no2($keyword,$type);

		echo json_encode($data);
	}
	
	
	public function search_fa_name()
	{
		$branch_code 	= $this->input->post('branch_code');
		$data 			= $this->model_cif->search_fa_name($branch_code);

		echo json_encode($data);
	}
	
	public function get_ajax_branch_code()
	{
		$code		= $this->input->post('code');
		$data		= $this->model_cif->get_ajax_branch_code($code);

		$jumlah = $data['jumlah'];
		if($jumlah==null)
        {
          $total = 0;
        }
        else
        {
          $total = $jumlah;
        }
        $no_urut 	= $total+1;
        $no_urut_ 	= sprintf('%04s', $no_urut);            
        $no_urut_petugas = $code.''.$no_urut_;

		echo $no_urut_petugas;
	}

	public function get_ajax_sequenc_fa()
	{
		$branch_code = $this->input->post('code');
		$data		 = $this->model_cif->get_ajax_sequenc_fa($branch_code);

		$max = $data['max'];
			if($max==null)
            {
              $total = 0;
            }
            else
            {
              $total = $max;
            }
            $no_urut 	= $total+1;
            $no_urut_ 	= sprintf('%04s', $no_urut);            
            $no_urut_petugas = $branch_code.''.$no_urut_;

		echo $no_urut_petugas;
	}
	// [END] PETUGAS LAPANGAN  SETUP


	// ------------------------------------------------------------------------------------------
	// BEGIN KABUPATEN SETUP
	// ------------------------------------------------------------------------------------------

	public function kabupaten()
	{
		$data['container'] = 'cif/kabupaten';
		$data['province'] = $this->model_cif->get_province();
		$this->load->view('core', $data);
	}

	public function datatable_kabupaten()
	{
		$aColumns = array( '','city_code', 'city_abbr','');
				
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
			$sOrder = " ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( trim($sOrder) == "ORDER BY" )
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_cif->datatable_kabupaten($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_kabupaten($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_kabupaten(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['city_code'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['city_code'];
			$row[] = $aRow['city'];
			$row[] = '<a href="javascript:;" city_code="'.$aRow['city_code'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_city()
	{
		$province_code 	= $this->input->post('province_code');
		$city_code 		= $this->input->post('city_code');
		$city_abbr 		= $this->input->post('city_abbr');
		$data = array(
				'province_code'	=> $province_code,
				'city_code'		=> $city_code,
				'city_abbr'		=> $city_abbr,
				'city'			=> $city_abbr
			);

		$this->db->trans_begin();
		$this->model_cif->add_city($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success', false);
		}

		echo json_encode($return);
	}

	public function get_city_by_id()
	{
		$city_code = $this->input->post('city_code');
		$data = $this->model_cif->get_city_by_id($city_code);

		echo json_encode($data);
	}


	public function delete_city()
	{
		$city_code = $this->input->post('city_code');

		$success = 0;
		$failed = 0;
		for ($i=0; $i < count($city_code) ; $i++) 
		{ 
			$param = array('city_code' =>$city_code[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_city($param);
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
			$return = array('succes'=>true,'num_success'=>$success,'num_failed'=>$failed);
		}

		echo json_encode($return);
	}


	public function edit_city()
	{
		$city_code2 	= $this->input->post('city_code2');
		$city_code 		= $this->input->post('city_code');
		$province_code 	= $this->input->post('province_code');
		$city_abbr 		= $this->input->post('city_abbr');

		$param = array('city_code'=>$city_code2);
		$data = array(
				'city_code'		=> $city_code,
				'province_code'	=> $province_code,
				'city_abbr' 	=> $city_abbr,
				'city'			=> $city_abbr
			);

		$this->db->trans_begin();
		$this->model_cif->edit_city($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}
		// [END] SERVICE KABUPATEN

	public function kecamatan()
	{
		$data['container'] 	= 'cif/kecamatan';
		$data['city'] 		= $this->model_cif->get_city();
		$this->load->view('core', $data);
	}

	public function datatable_kecamatan()
	{
		$aColumns = array( '','kecamatan_code','kecamatan', 'mfi_city_kecamatan.city_code','');
				
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
			$sOrder = " ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( trim($sOrder) == "ORDER BY" )
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_cif->datatable_kecamatan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_kecamatan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_kecamatan(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['kecamatan_code'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['kecamatan_code'];
			$row[] = $aRow['kecamatan'];
			$row[] = $aRow['city'];
			$row[] = '<a href="javascript:;" city_kecamatan_id="'.$aRow['city_kecamatan_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	public function add_kecamatan()
	{
		$city_kecamatan_id 	= rand(0000,9999);
		$kecamatan_code 	= $this->input->post('kecamatan_code');
		$city_code 			= $this->input->post('city_code');
		$kecamatan 			= $this->input->post('kecamatan');
		$data = array(
				'city_kecamatan_id'	=> $city_kecamatan_id,
				'kecamatan_code'	=> $kecamatan_code,
				'city_code'			=> $city_code,
				'kecamatan'			=> $kecamatan
			);

		$this->db->trans_begin();
		$this->model_cif->add_kecamatan($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success', false);
		}

		echo json_encode($return);
	}

	public function get_kecamatan_by_id()
	{
		$city_kecamatan_id 	= $this->input->post('city_kecamatan_id');
		$data 				= $this->model_cif->get_kecamatan_by_id($city_kecamatan_id);

		echo json_encode($data);
	}


	public function delete_kecamatan()
	{
		$kecamatan_code = $this->input->post('kecamatan_code');

		$success = 0;
		$failed = 0;
		for ($i=0; $i < count($kecamatan_code) ; $i++) 
		{ 
			$param = array('kecamatan_code' =>$kecamatan_code[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_kecamatan($param);
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
			$return = array('succes'=>true,'num_success'=>$success,'num_failed'=>$failed);
		}

		echo json_encode($return);
	}


	public function edit_kecamatan()
	{
		$kecamatan_code 	= $this->input->post('kecamatan_code');
		$city_code 			= $this->input->post('city_code2');
		$kecamatan 			= $this->input->post('kecamatan');
		$city_kecamatan_id 	= $this->input->post('city_kecamatan_id');
		$param 				= array('city_kecamatan_id'=>$city_kecamatan_id);
		$data = array(
				'kecamatan_code'=>$kecamatan_code,
				'city_code'=>$city_code,
				'kecamatan'=>$kecamatan
			);

		$this->db->trans_begin();
		$this->model_cif->edit_kecamatan($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	
	public function get_ajax_city_code()
	{
		$city_code		= $this->input->post('code');
		$data		= $this->model_cif->get_ajax_city_code($city_code);

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
            $no_urut_ = sprintf('%02s', $no_urut);            
            $no_urut_kecamatan = $city_code.''.$no_urut_;

		echo $no_urut_kecamatan;
	}

	public function search_city_code()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_cif->search_city_code($keyword);

		echo json_encode($data);
	}
	


	public function desa()
	{
		$data['container'] 	= 'cif/desa';
		$data['kecamatan'] 	= $this->model_cif->get_kecamatan();
		$data['city'] 		= $this->model_cif->get_city();
		$this->load->view('core', $data);
	}

	public function datatable_desa()
	{
		$aColumns = array( '','desa_code','desa', 'mfi_city_kecamatan.kecamatan','');
				
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
			$sOrder = " ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( trim($sOrder) == "ORDER BY" )
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_cif->datatable_desa($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_desa($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_desa(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['desa_code'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['desa_code'];
			$row[] = $aRow['desa'];
			$row[] = $aRow['kecamatan'];
			$row[] = '<a href="javascript:;" kecamatan_desa_id="'.$aRow['kecamatan_desa_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_desa()
	{
		$desa_code 		= $this->input->post('desa_code');
		$kecamatan_code = $this->input->post('kecamatan_code');
		$desa 			= $this->input->post('desa');
		$data = array(
				'desa_code'			=> $desa_code,
				'kecamatan_code'	=> $kecamatan_code,
				'desa'				=> $desa
			);

		$this->db->trans_begin();
		$this->model_cif->add_desa($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success', false);
		}

		echo json_encode($return);
	}

	public function get_desa_by_id()
	{
		$kecamatan_desa_id = $this->input->post('kecamatan_desa_id');
		$data = $this->model_cif->get_desa_by_id($kecamatan_desa_id);

		echo json_encode($data);
	}


	public function delete_desa()
	{
		$desa_code = $this->input->post('desa_code');

		$success = 0;
		$failed = 0;
		for ($i=0; $i < count($desa_code) ; $i++) 
		{ 
			$param = array('desa_code' =>$desa_code[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_desa($param);
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
			$return = array('succes'=>true,'num_success'=>$success,'num_failed'=>$failed);
		}

		echo json_encode($return);
	}


	public function edit_desa()
	{
		$desa_code 			= $this->input->post('desa_code');
		$kecamatan_code 	= $this->input->post('kecamatan_code2');
		$desa 				= $this->input->post('desa');
		$kecamatan_desa_id 	= $this->input->post('kecamatan_desa_id');
		$param = array('kecamatan_desa_id'=>$kecamatan_desa_id);
		$data = array(
				'desa_code'			=> $desa_code,
				'kecamatan_code'	=> $kecamatan_code,
				'desa'				=> $desa
			);

		$this->db->trans_begin();
		$this->model_cif->edit_desa($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	
	public function get_ajax_kecamatan_code()
	{
		$kecamatan_code		= $this->input->post('code');
		$data				= $this->model_cif->get_ajax_kecamatan_code($kecamatan_code);

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
        $no_urut_ = sprintf('%02s', $no_urut);            
        $no_urut_desa = $kecamatan_code.''.$no_urut_;

		echo $no_urut_desa;
	}

	public function search_kecamatan_code()
	{
		$keyword 	= $this->input->post('keyword');
		$city 		= $this->input->post('city_code');
		$data 		= $this->model_cif->search_kecamatan_code($keyword,$city);

		echo json_encode($data);
	}


	// [BEGIN] CIF INDIVIDU 

	public function cif_individu()
	{
		$data['container'] = 'cif/cif_individu';
		$this->load->view('core',$data);
	}

	public function add_cif_individu()
	{
		$nama 					= $this->input->post('nama');
		$tgl_gabung 			= $this->input->post('tgl_gabung');
		$tgl_gabung 			= str_replace('/', '', $tgl_gabung);
		$tgl_gabung 			= substr($tgl_gabung,4,4).'-'.substr($tgl_gabung,2,2).'-'.substr($tgl_gabung,0,2);
		$panggilan 				= $this->input->post('panggilan');
		$jenis_kelamin 			= $this->input->post('jenis_kelamin');
		$ibu_kandung 			= $this->input->post('ibu_kandung');
		$tmp_lahir 				= $this->input->post('tmp_lahir');
		$tgl_lahir 				= $this->input->post('tgl_lahir');
		$tgl_lahir 				= str_replace('/', '', $tgl_lahir);
		$tgl_lahir 				= substr($tgl_lahir,4,4).'-'.substr($tgl_lahir,2,2).'-'.substr($tgl_lahir,0,2);
		$usia 					= $this->input->post('usia');
		$alamat 				= $this->input->post('alamat');
		$rt 					= $this->input->post('rt');
		$rw 					= $this->input->post('rw');
		$desa 					= $this->input->post('desa');
		$kecamatan 				= $this->input->post('kecamatan');
		$kabupaten 				= $this->input->post('kabupaten');
		$kode_pos 				= $this->input->post('kode_pos');
		$sama 					= $this->input->post('sama');
		$koresponden_alamat 	= $this->input->post('koresponden_alamat');
		$koresponden_rt 		= $this->input->post('koresponden_rt');
		$koresponden_rw 		= $this->input->post('koresponden_rw');
		$koresponden_desa 		= $this->input->post('koresponden_desa');
		$koresponden_kecamatan 	= $this->input->post('koresponden_kecamatan');
		$koresponden_kabupaten 	= $this->input->post('koresponden_kabupaten');
		$koresponden_kode_pos 	= $this->input->post('koresponden_kode_pos');
		$no_ktp 				= $this->input->post('no_ktp');
		$telpon_rumah 			= $this->input->post('telpon_rumah');
		$no_npwp 				= $this->input->post('no_npwp');
		$pendidikan 			= $this->input->post('pendidikan');
		$status_perkawinan 		= $this->input->post('status_perkawinan');
		$identitas_pasangan 	= $this->input->post('identitas_pasangan');
		$pekerjaan 				= $this->input->post('pekerjaan');
		$pendapatan 			= $this->convert_numeric($this->input->post('pendapatan'));
		$keterangan_pekerjaan 	= $this->input->post('keterangan_pekerjaan');
		$data = array(
			 'nama' 					=> ($nama=="") ? null : $nama
			,'tgl_gabung' 				=> ($tgl_gabung=="") ? null : $tgl_gabung
			,'panggilan' 				=> ($panggilan=="") ? null : $panggilan
			,'jenis_kelamin' 			=> ($jenis_kelamin=="") ? null : $jenis_kelamin
			,'ibu_kandung' 				=> ($ibu_kandung=="") ? null : $ibu_kandung
			,'tmp_lahir' 				=> ($tmp_lahir=="") ? null : $tmp_lahir
			,'tgl_lahir' 				=> ($tgl_lahir=="") ? null : $tgl_lahir
			,'usia' 					=> ($usia=="") ? null : $usia
			,'alamat' 					=> ($alamat=="") ? null : $alamat
			,'rt_rw' 					=> $rt.'/'.$rw
			,'desa' 					=> ($desa=="") ? null : $desa
			,'kecamatan' 				=> ($kecamatan=="") ? null : $kecamatan
			,'kabupaten' 				=> ($kabupaten=="") ? null : $kabupaten
			,'kodepos'	 				=> ($kode_pos=="") ? null : $kode_pos
			,'koresponden_alamat' 		=> ($koresponden_alamat=="") ? null : $koresponden_alamat
			,'koresponden_rt_rw' 		=> $koresponden_rt.'/'.$koresponden_rw
			,'koresponden_desa' 		=> ($koresponden_desa=="") ? null : $koresponden_desa
			,'koresponden_kecamatan' 	=> ($koresponden_kecamatan=="") ? null : $koresponden_kecamatan
			,'koresponden_kabupaten' 	=> ($koresponden_kabupaten=="") ? null : $koresponden_kabupaten
			,'koresponden_kodepos' 		=> ($koresponden_kode_pos=="") ? null : $koresponden_kode_pos
			,'no_ktp' 					=> ($no_ktp=="") ? null : $no_ktp
			,'telpon_rumah' 			=> ($telpon_rumah=="") ? null : $telpon_rumah
			,'no_npwp' 					=> ($no_npwp=="") ? null : $no_npwp
			,'pendidikan' 				=> ($pendidikan=="") ? null : $pendidikan
			,'status_perkawinan' 		=> ($status_perkawinan=="") ? null : $status_perkawinan
			,'identitas_pasangan' 		=> ($identitas_pasangan=="") ? null : $identitas_pasangan
			,'pekerjaan' 				=> ($pekerjaan=="") ? null : $pekerjaan
			,'pendapatan_perbulan'	 	=> ($pendapatan=="") ? null : $pendapatan
			,'ket_pekerjaan' 			=> ($keterangan_pekerjaan=="") ? null : $keterangan_pekerjaan
			,'cif_type' 				=> 1
			,'branch_code' 				=> $this->session->userdata('branch_code')
		);

		$this->db->trans_begin();
		$this->model_cif->add_cif_individu($data);
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

	public function datatable_cif_individu()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','cif_no','nama','jenis_kelamin','tgl_lahir','usia','');
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_cif->datatable_cif_individu($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_cif_individu($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_cif_individu(); // get number of all data
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
			if($aRow['jenis_kelamin']=="P"){
				$aRow['jenis_kelamin'] = "Pria";
			}else if($aRow['jenis_kelamin']=="W"){
				$aRow['jenis_kelamin'] = "Wanita";
			}
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['cif_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['jenis_kelamin'];
			$row[] = $this->format_date_detail($aRow['tgl_lahir'],'id',false,'/');
			$row[] = $aRow['usia']." Tahun";
			$row[] = '<a href="javascript:;" cif_id="'.$aRow['cif_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_cif_individu()
	{
		$cif_id = $this->input->post('cif_id');
		$data 	= $this->model_cif->get_cif_individu($cif_id);

		echo json_encode($data);
	}

	public function update_cif_individu()
	{
		$cif_id 				= $this->input->post('cif_id');
		$nama 					= $this->input->post('nama');
		$tgl_gabung 			= $this->input->post('tgl_gabung');
		$tgl_gabung 			= str_replace('/', '', $this->input->post('tgl_gabung'));
		$tgl_gabung 			= substr($tgl_gabung,4,4).'-'.substr($tgl_gabung,2,2).'-'.substr($tgl_gabung,0,2);
		$panggilan 				= $this->input->post('panggilan');
		$jenis_kelamin 			= $this->input->post('jenis_kelamin');
		$ibu_kandung 			= $this->input->post('ibu_kandung');
		$tmp_lahir 				= $this->input->post('tmp_lahir');
		$tgl_lahir 				= str_replace('/', '', $this->input->post('tgl_lahir'));
		$tgl_lahir 				= substr($tgl_lahir,4,4).'-'.substr($tgl_lahir,2,2).'-'.substr($tgl_lahir,0,2);
		$usia 					= $this->input->post('usia');
		$alamat 				= $this->input->post('alamat');
		$rt 					= $this->input->post('rt');
		$rw 					= $this->input->post('rw');
		$desa 					= $this->input->post('desa');
		$kecamatan 				= $this->input->post('kecamatan');
		$kabupaten 				= $this->input->post('kabupaten');
		$kode_pos 				= $this->input->post('kode_pos');
		$koresponden_alamat 	= $this->input->post('koresponden_alamat');
		$koresponden_rt 		= $this->input->post('koresponden_rt');
		$koresponden_rw 		= $this->input->post('koresponden_rw');
		$koresponden_desa 		= $this->input->post('koresponden_desa');
		$koresponden_kecamatan 	= $this->input->post('koresponden_kecamatan');
		$koresponden_kabupaten 	= $this->input->post('koresponden_kabupaten');
		$koresponden_kode_pos 	= $this->input->post('koresponden_kode_pos');
		$no_ktp 				= $this->input->post('no_ktp');
		$telpon_rumah 			= $this->input->post('telpon_rumah');
		$no_npwp 				= $this->input->post('no_npwp');
		$pendidikan 			= $this->input->post('pendidikan');
		$status_perkawinan 		= $this->input->post('status_perkawinan');
		$identitas_pasangan 	= $this->input->post('identitas_pasangan');
		$pekerjaan 				= $this->input->post('pekerjaan');
		$pendapatan 			= $this->convert_numeric($this->input->post('pendapatan'));
		$keterangan_pekerjaan 	= $this->input->post('keterangan_pekerjaan');
		$param = array('cif_id'=>$cif_id);
		$data = array(
			 'nama' 					=> $nama
			,'panggilan' 				=> $panggilan
			,'jenis_kelamin' 			=> $jenis_kelamin
			,'ibu_kandung' 				=> $ibu_kandung
			,'tmp_lahir' 				=> $tmp_lahir
			,'tgl_gabung' 				=> $tgl_gabung
			,'tgl_lahir' 				=> $tgl_lahir
			,'usia' 					=> $usia
			,'alamat' 					=> $alamat
			,'rt_rw' 					=> $rt.'/'.$rw
			,'desa' 					=> $desa
			,'kecamatan' 				=> $kecamatan
			,'kabupaten' 				=> $kabupaten
			,'kodepos' 					=> $kode_pos
			,'koresponden_alamat' 		=> $koresponden_alamat
			,'koresponden_rt_rw' 		=> $koresponden_rt.'/'.$koresponden_rw
			,'koresponden_desa' 		=> $koresponden_desa
			,'koresponden_kecamatan' 	=> $koresponden_kecamatan
			,'koresponden_kabupaten' 	=> $koresponden_kabupaten
			,'koresponden_kodepos' 		=> $koresponden_kode_pos
			,'no_ktp' 					=> $no_ktp
			,'telpon_rumah' 			=> $telpon_rumah
			,'no_npwp' 					=> $no_npwp
			,'pendidikan' 				=> $pendidikan
			,'status_perkawinan' 		=> $status_perkawinan
			,'identitas_pasangan' 		=> $identitas_pasangan
			,'pekerjaan' 				=> $pekerjaan
			,'pendapatan_perbulan' 		=> $pendapatan
			,'ket_pekerjaan' 			=> $keterangan_pekerjaan
		);

		$this->db->trans_begin();
		$this->model_cif->update_cif_individu($data,$param);

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

	public function delete_cif_individu()
	{
		$cif_id = $this->input->post('cif_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($cif_id) ; $i++ )
		{
			$param = array('cif_id'=>$cif_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_cif_individu($param);
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
	// BEGIN PROGRAM SETUP
	/****************************************************************************************/
	public function program()
	{
		$data['container'] = 'cif/program';
		$data['kreditur'] = $this->model_cif->get_list_code('kreditur');
		$this->load->view('core',$data);
	}

	public function datatable_program_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','program_code', 'program_name','program_owner','sifat_dana','');
				
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
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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
		$rResult 			= $this->model_cif->datatable_program_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_program_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_program_setup(); // get number of all data
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
			
			if($aRow['sifat_dana']==0)
				{
					$sifat_dana="Hibah";
				}
			else if($aRow['sifat_dana']==1)
				{
					$sifat_dana="Dana Bergulir";
				}
			else
				{
					$sifat_dana="Pembiayaan";
				}

			$row[] = '<input type="checkbox" value="'.$aRow['financing_program_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['program_code'];
			$row[] = $aRow['program_name'];
			$row[] = $aRow['program_owner'];
			$row[] = $sifat_dana;
			$row[] = '<center><a href="javascript:;" financing_program_id="'.$aRow['financing_program_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_program()
	{
		$program_code 		= $this->input->post('program_code');
		$program_name 		= $this->input->post('program_name');
		$program_owner 		= $this->input->post('program_owner');
		$sifat_dana 		= $this->input->post('sifat_dana');
		$target_customer 	= $this->input->post('target_customer');
		$target_pembiayaan 	= $this->input->post('target_pembiayaan');

		$tanggal_mulai 		= $this->input->post('tanggal_mulai');
		$tgl_mulai			= str_replace("/","", $tanggal_mulai);
        $tgl_m_pengajuan	= substr($tgl_mulai,4,4).'-'.substr($tgl_mulai,2,2).'-'.substr($tgl_mulai,0,2);

		$tanggal_berakhir 	= $this->input->post('tanggal_berakhir');
		$tgl_berakhir		= str_replace("/","", $tanggal_berakhir);
        $tgl_b_pengajuan	= substr($tgl_berakhir,4,4).'-'.substr($tgl_berakhir,2,2).'-'.substr($tgl_berakhir,0,2);

        $program_owner_text = $this->model_cif->get_list_code_text('kreditur',$program_owner);
        $program_owner_text = $program_owner_text['display_text'];

		// $tgl 				= substr("$tanggal_mulai",0,2);
	    // $bln 				= substr("$tanggal_mulai",2,2);
	    // $thn 				= substr("$tanggal_mulai",4,4);
	    // $tgl_mulai 			= "$thn-$bln-$tgl";  

	    // $tgl2 				= substr("$tanggal_berakhir",0,2);
	    // $bln2 				= substr("$tanggal_berakhir",2,2);
	    // $thn2 				= substr("$tanggal_berakhir",4,4);
	    // $tgl_berakhir 		= "$thn2-$bln2-$tgl2"; 

			$data = array(
				'program_code'		=> $program_code,
				'program_name' 		=> $program_name,
				'program_owner' 	=> $program_owner_text,
				'program_owner_code'=> $program_owner,
				'sifat_dana' 		=> $sifat_dana,
				'tanggal_mulai' 	=> $tgl_m_pengajuan,				
				'tanggal_berakhir' 	=> $tgl_b_pengajuan,
				'target_customer' 	=> $target_customer,
				'target_pembiayaan' => $this->convert_numeric($target_pembiayaan),
				'status_program' 	=> '0'
				);
		

		$this->db->trans_begin();
		$this->model_cif->add_program($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_program()
	{
		$financing_program_id = $this->input->post('financing_program_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($financing_program_id) ; $i++ )
		{
			$param = array('financing_program_id'=>$financing_program_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_program($param);
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

	public function get_program_by_financing_program_id()
	{
		$financing_program_id = $this->input->post('financing_program_id');
		$data = $this->model_cif->get_program_by_financing_program_id($financing_program_id);

		echo json_encode($data);
	}

	public function edit_program()
	{
		$financing_program_id 		= $this->input->post('financing_program_id');
		$program_code 				= $this->input->post('program_code2');
		$program_name 				= $this->input->post('program_name2');
		$program_owner 				= $this->input->post('program_owner2');
		$sifat_dana 				= $this->input->post('sifat_dana2');
		$target_customer 			= $this->input->post('target_customer2');
		$target_pembiayaan 			= $this->input->post('target_pembiayaan2');

		$tanggal_mulai 		= $this->input->post('tanggal_mulai2');
		$tgl_mulai			= str_replace("/","", $tanggal_mulai);
        $tgl_m_pengajuan	= substr($tgl_mulai,4,4).'-'.substr($tgl_mulai,2,2).'-'.substr($tgl_mulai,0,2);

		$tanggal_berakhir 	= $this->input->post('tanggal_berakhir2');
		$tgl_berakhir		= str_replace("/","", $tanggal_berakhir);
        $tgl_b_pengajuan	= substr($tgl_berakhir,4,4).'-'.substr($tgl_berakhir,2,2).'-'.substr($tgl_berakhir,0,2);

        $program_owner_text = $this->model_cif->get_list_code_text('kreditur',$program_owner);
        $program_owner_text = $program_owner_text['display_text'];

		// $tgl 						= substr("$tanggal_mulai",0,2);
	    // $bln 						= substr("$tanggal_mulai",2,2);
	    // $thn 						= substr("$tanggal_mulai",4,4);
	    // $tgl_mulai 					= "$thn-$bln-$tgl";  

	    // $tgl2 						= substr("$tanggal_berakhir",0,2);
	    // $bln2 						= substr("$tanggal_berakhir",2,2);
	    // $thn2 						= substr("$tanggal_berakhir",4,4);
	    // $tgl_berakhir 				= "$thn2-$bln2-$tgl2"; 

		$param = array('financing_program_id'=>$financing_program_id);

			$data = array(
				'program_code'		=> $program_code,
				'program_name' 		=> $program_name,
				'program_owner' 	=> $program_owner_text,
				'program_owner_code'=> $program_owner,
				'sifat_dana' 		=> $sifat_dana,
				'tanggal_mulai' 	=> $tgl_m_pengajuan,				
				'tanggal_berakhir' 	=> $tgl_b_pengajuan,
				'target_customer' 	=> $target_customer,
				'target_pembiayaan' => $this->convert_numeric($target_pembiayaan),
				'status_program' 	=> '0'
				);

		$this->db->trans_begin();
		$this->model_cif->edit_program($data,$param);
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
	// END PROGRAM SETUP
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN SMK SETUP
	/****************************************************************************************/
	public function registrasi_smk()
	{
		$data['container'] 		= 'cif/registrasi_smk';
		$data['branch_code'] 	= $this->session->userdata('branch_code');
		$data['tanggal'] 		= date('d-m-Y');
		$branch_code 			= $this->session->userdata('branch_code');
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['kas_petugas'] 	= $this->model_cif->get_fa_by_branch_code($branch_code);
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$data['nominal'] 		= $this->model_cif->get_nominal_awal();
		$this->load->view('core',$data);
	}

	public function datatable_registrasi_smk_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_trx_smk.cif_no','mfi_smk.nama', 'mfi_trx_smk.trx_type', 'mfi_trx_smk.trx_date','mfi_smk.nominal', '');
				
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
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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
		$rResult 			= $this->model_cif->datatable_registrasi_smk_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_registrasi_smk_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_registrasi_smk_setup(); // get number of all data
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

			$trx_type = $aRow['trx_type'];
			if($trx_type=='1'){
				$aTrx_type = "Tunai";
			}else{
				$aTrx_type = "Pinbuk";
			}

			$row[] = '<input type="checkbox" value="'.$aRow['trx_smk_code'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $aTrx_type;
			$row[] = $this->format_date_detail($aRow['trx_date'],'id',false,'/');
			$row[] = "Rp. ".number_format($aRow['nominal'],0,',','.');
			$row[] = $aRow['jml_sertifikat']." Sertifikat";
			// $row[] = '<center><a href="javascript:;" trx_smk_id="'.$aRow['trx_smk_id'].'" id="link-edit">Edit</a></center>';
			$row[] = '<center><a href="#dialog_detail" data-toggle="modal" trx_smk_id="'.$aRow['trx_smk_id'].'" id="link-detail">Detail</a></center>';
			// $row[] = '<center><a href="'.site_url('cif/export_smk/'.$aRow['smk_id'].'/'.$aRow['status'].'').'" target="_blank">Print</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function count_no_sertifikat_by_branch_code()
	{
		$branch_code 	= $this->input->post('branch_code');
		$data 			= $this->model_cif->count_no_sertifikat_by_branch_code($branch_code);

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
            $no_urut_ = sprintf('%06s', $no_urut);            
            $no_urut_sertifikat = $branch_code.''.$no_urut_;

		echo $no_urut_sertifikat;
	}

	public function get_fa_by_branch_code()
	{
		$branch_code = $this->session->userdata('branch_code');
		$data = $this->model_cif->get_fa_by_branch_code($branch_code);

		echo json_encode($data);
	}

	public function add_registrasi_smk()
	{
		$sertifikat_no 			= $this->input->post('sertifikat_no');
		$status_anggota			= $this->input->post('status_anggota');
		$nama 					= $this->input->post('nama');
		$nominal 				= $this->convert_numeric($this->input->post('nominal'));
		$tipe_trx				= $this->input->post('status_option');
		$created_by				= $this->session->userdata('user_id');
		$created_date			= date('Y-m-d H:i:s');

		if ($status_anggota=='0'){			
			$cif_no = "";
		}else{
			$cif_no 			= $this->input->post('cif_no');
		}

		if($tipe_trx=='0'){
			$account_cash_code	= "";
			$setoran_tunai 		= 0;
			$tabungan_wajib 	= $this->convert_numeric($this->input->post('tabungan_wajib'));
			$tabungan_kelompok 	= $this->convert_numeric($this->input->post('tabungan_kelompok'));
			$total 				= $this->convert_numeric($this->input->post('total'));
		}else{
			$account_cash_code	= $this->input->post('account_cash_code');
			$setoran_tunai 		= $this->convert_numeric($this->input->post('setoran_tunai'));
			$tabungan_wajib 	= 0;
			$tabungan_kelompok 	= 0;
			$total 				= $this->convert_numeric($this->input->post('total'));
		}
		
		$tanggal_			= $this->input->post('date_issued');
		$tanggal_mulai		= str_replace("/", "", $tanggal_);
	    $date_issued 		= substr($tanggal_mulai,0,2).'-'.substr($tanggal_mulai,2,2).'-'.substr($tanggal_mulai,4,4);
	    $total_rec 			= $total/50000;

	    //Mendapatkan No Sertifikat Jika Total Merupakan Kelipatan 50000
	    $branch_code 		= $this->session->userdata('branch_code');
		$data 				= $this->model_cif->count_no_sertifikat_by_branch_code($branch_code);
		$datas 				= $this->model_cif->count_code_trx_smk();
		$jumlah 			= $data['jumlah'];
		$jumlah2 			= $datas['jumlah'];

		if($jumlah==null){
          $num = 0;
        }else{
          $num = $jumlah;
        }

        if($jumlah2==null){
          $num2 = 0;
        }else{
          $num2 = $jumlah2;
        }

        $trx_smk_code = sprintf('%06s', $num2+1);

				$data1 = array(
					'cif_no'			=> $cif_no,
					'trx_type'			=> $tipe_trx,
					'account_cash_code'	=> $account_cash_code,
					'setor_tunai'		=> $setoran_tunai,
					'tabungan_wajib'	=> $tabungan_wajib,
					'tabungan_kelompok'	=> $tabungan_kelompok,
					'total'				=> $total,
					'trx_date'			=> $created_date,
					'created_date'		=> $created_date,
					'created_by'		=> $created_by,
					'trx_smk_code'		=> $trx_smk_code
					);

			for($i=1;$i<=$total_rec;$i++){
				$data2[] = array(
					'sertifikat_no'		=> $branch_code.''.sprintf('%06s', $num+$i),
					'cif_no' 			=> $cif_no,
					'nama' 				=> $nama,
					'nominal' 			=> 50000,
					'date_issued' 		=> $date_issued,
					'created_by' 		=> $created_by,
					'created_date' 		=> $created_date,
					'status_anggota'	=> $status_anggota,
					'trx_smk_code'		=> $trx_smk_code
				);
			}

		$this->db->trans_begin();
		$this->model_cif->add_trx_smk($data1);
		if(count($data2)>0){
			$this->model_cif->add_registrasi_smk($data2);
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

	public function delete_registrasi_smk()
	{
		$trx_smk_code = $this->input->post('trx_smk_code');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($trx_smk_code) ; $i++ )
		{
			$param = array('trx_smk_code'=>$trx_smk_code[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_registrasi_smk($param);
			$this->model_cif->delete_registrasi_trx_smk($param);
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

	public function get_smk_by_smk_id()
	{
		$trx_smk_id = $this->input->post('trx_smk_id');
		$data = $this->model_cif->get_smk_by_smk_id($trx_smk_id);

		echo json_encode($data);
	}

	public function edit_registrasi_smk()
	{
		$smk_id 				= $this->input->post('smk_id');
		$trx_smk_id 			= $this->input->post('trx_smk_id');
		$sertifikat_no 			= $this->input->post('sertifikat_no2');
		$status_anggota			= $this->input->post('status_anggota2');
		$nama 					= $this->input->post('nama2');
		$nominal 				= $this->convert_numeric($this->input->post('nominal2'));
		$tipe_trx				= $this->input->post('status_option2');
		$created_by				= $this->session->userdata('user_id');
		$created_date			= date('Y-m-d H:i:s');
		// $total2_hide			= $this->input->post('total2_hide');

		if ($status_anggota=='0'){			
			$cif_no 			= $this->input->post('cif_no2');
		}else{
			$cif_no = "";
		}

		if($tipe_trx=='0'){
			$account_cash_code	= "";
			$setoran_tunai 		= 0;
			$tabungan_wajib 	= $this->convert_numeric($this->input->post('tabungan_wajib2'));
			$tabungan_kelompok 	= $this->convert_numeric($this->input->post('tabungan_kelompok2'));
			$total 				= $this->convert_numeric($this->input->post('total2'));
		}else{
			$account_cash_code	= $this->input->post('account_cash_code2');
			$setoran_tunai 		= $this->convert_numeric($this->input->post('setoran_tunai2'));
			$tabungan_wajib 	= 0;
			$tabungan_kelompok 	= 0;
			$total 				= $this->convert_numeric($this->input->post('total2'));
		}
		
		$tanggal_			= $this->input->post('date_issued2');
		$tanggal_mulai		= str_replace("/", "", $tanggal_);
	    $date_issued 		= substr($tanggal_mulai,0,2).'-'.substr($tanggal_mulai,2,2).'-'.substr($tanggal_mulai,4,4);
	    $total_rec 			= $total/50000;

	    //Mendapatkan No Sertifikat Jika Total Merupakan Kelipatan 50000
	    $branch_code 		= $this->session->userdata('branch_code');
		$data 				= $this->model_cif->count_no_sertifikat_by_branch_code($branch_code);
		$jumlah 			= $data['jumlah'];

		if($jumlah==null){
          $num = 0;
        }else{
          $num = $jumlah;
        }

				$data1 = array(
					'cif_no'			=> $cif_no,
					'trx_type'			=> $tipe_trx,
					'account_cash_code'	=> $account_cash_code,
					'setor_tunai'		=> $setoran_tunai,
					'tabungan_wajib'	=> $tabungan_wajib,
					'tabungan_kelompok'	=> $tabungan_kelompok,
					'total'				=> $total,
					'trx_date'			=> $created_date,
					'created_date'		=> $created_date,
					'created_by'		=> $created_by
					);

				$param1 = array('trx_smk_id'=>$trx_smk_id);

			for($i=1;$i<=$total_rec;$i++){
				$data2[] = array(
					'sertifikat_no'		=> $branch_code.''.sprintf('%06s', $num+$i),
					'cif_no' 			=> $cif_no,
					'nama' 				=> $nama,
					'nominal' 			=> 50000,
					'date_issued' 		=> $date_issued,
					'created_by' 		=> $created_by,
					'created_date' 		=> $created_date,
					'status_anggota'	=> $status_anggota,
				);
				$param2[] = array('cif_no'=>$cif_no);
			}

			// if($total_rec!=$total2_hide){
			// 	for($i=1;$i<=($total_rec-$total2_hide);$i++){
			// 		$data3[] = array(
			// 			'sertifikat_no'		=> $branch_code.''.sprintf('%06s', $num+$i),
			// 			'cif_no' 			=> $cif_no,
			// 			'nama' 				=> $nama,
			// 			'nominal' 			=> 50000,
			// 			'date_issued' 		=> $date_issued,
			// 			'created_by' 		=> $created_by,
			// 			'created_date' 		=> $created_date,
			// 			'status_anggota'	=> $status_anggota,
			// 		);
			// 	}
			// }

		$this->db->trans_begin();
		$this->model_cif->edit_trx_smk($data1,$param1);
		for ( $i = 0 ; $i < count($data2) ; $i++ )
		{
			$this->model_cif->edit_registrasi_smk($data2[$i],$param2[$i]);
		}
		// if(count($data3)>0){
		// 	$this->model_cif->add_registrasi_smk($data3);
		// }
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function detail_registrasi_smk()
	{
		$trx_smk_id = $this->input->post('trx_smk_id');
		$data 		= $this->model_cif->detail_registrasi_smk($trx_smk_id);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// END SMK SETUP
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN PELEPASAN SMK SETUP
	/****************************************************************************************/
	public function pelepasan_smk()
	{
		$data['container'] = 'cif/pelepasan_smk';
		$data['branch_code'] = $this->session->userdata('branch_code');
		$data['tanggal'] = date('d-m-Y');
		$this->load->view('core',$data);
	}

	public function datatable_pelepasan_smk_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','sertifikat_no', 'nama', 'nominal','date_issued','');
				
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
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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
		$rResult 			= $this->model_cif->datatable_pelepasan_smk_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_pelepasan_smk_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_pelepasan_smk_setup(); // get number of all data
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

			$row[] = '<input type="checkbox" value="'.$aRow['smk_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['sertifikat_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['nominal'];
			$row[] = $aRow['date_issued'];
			$row[] = '<center><a href="javascript:;" smk_id="'.$aRow['smk_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_pelepasan_smk()
	{
		$smk_id 			= $this->input->post('smk_id3');
		$sertifikat_no 		= $this->input->post('sertifikat_no3');
		$status             = "0";
		$tanggal_mulai		= $this->input->post('date_close3');
		$tgl 				= substr("$tanggal_mulai",0,2);
	    $bln 				= substr("$tanggal_mulai",3,2);
	    $thn 				= substr("$tanggal_mulai",6,4);
	    $date_close 		= "$thn-$bln-$tgl";  

	    $param = array('smk_id'=>$smk_id);

			$data = array(
				'status'			=> $status,
				'date_close' 		=> $date_close
				);
		

		$this->db->trans_begin();
		$this->model_cif->add_pelepasan_smk($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_pelepasan_smk()
	{
		$smk_id = $this->input->post('smk_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($smk_id) ; $i++ )
		{
			$param = array('smk_id'=>$smk_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_registrasi_smk($param);
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

	public function get_pelepasan_smk_by_smk_id()
	{
		$smk_id = $this->input->post('smk_id');
		$data = $this->model_cif->get_smk_by_smk_id($smk_id);

		echo json_encode($data);
	}

	public function edit_pelepasan_smk()
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

		$tgl 				= substr("$tanggal_mulai",0,2);
	    $bln 				= substr("$tanggal_mulai",2,2);
	    $thn 				= substr("$tanggal_mulai",4,4);
	    $date_issued 		= "$thn-$bln-$tgl";  

		$param = array('smk_id'=>$smk_id);

			$data = array(
				'sertifikat_no'		=> $sertifikat_no,
				'nama' 				=> $nama,
				'nominal' 			=> $nominal,
				'date_issued' 		=> $date_issued,
				'status' 			=> $status,				
				'created_by' 		=> $created_by,
				'created_date' 		=> $created_date,
				'status_anggota'	=> $status_anggota,
				'cif_no' 			=> $cif_no
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


	public function ajax_get_value_from_sertifikat_no()
	{
		$sertifikat_no 	= $this->input->post('sertifikat_no');
		$data 			= $this->model_cif->ajax_get_value_from_sertifikat_no($sertifikat_no);

		echo json_encode($data);
	}

	public function search_sertifikat_no()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_cif->search_sertifikat_no($keyword);

		echo json_encode($data);
	}

	public function export_smk()
	{
		$smk_id = $this->uri->segment(3);
		$status = $this->uri->segment(4);

		if ($status==0) 
		{			
			echo "<script>alert('Status Belum Aktif');javascript:window.close();</script>";
		} 
		else if ($status==2)
		{
			echo "<script>alert('Status Tidak Aktif');javascript:window.close();</script>";
		}
		else
		{

		$this->load->library('html2pdf');
		ob_start();

		
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		$data['sertifikat'] = $this->model_cif->get_data_from_sertifikat($smk_id,$status);

		$this->load->view('cif/export_smk',$data);

		$content = ob_get_clean();

		try
	    {
	        $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
	        $html2pdf->pdf->SetDisplayMode('fullpage');
	        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	        $html2pdf->Output('Sertifikat.pdf');
	    }
	    catch(HTML2PDF_exception $e) {
	        echo $e;
	        exit;
	    }
	  }
	}
	

	/****************************************************************************************/	
	// END PELEPASAN SMK SETUP
	/****************************************************************************************/

	public function get_all_branch()
	{
		$branch = $this->model_cif->get_all_branch();
		echo json_encode($branch);
	}

	public function get_all_branch_by_id()
	{
		$branch_id 	= $this->input->post('branch_id');
		$branch 	= $this->model_cif->get_all_branch_by_id($branch_id);
		echo json_encode($branch);
	}

	public function get_branch_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_cif->get_branch_by_keyword($keyword);

		echo json_encode($data);
	}


	public function ajax_get_tanggal_jatuh_tempo()
	{
		$periode_angsuran 	= $this->input->post('periode_angsuran');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		$hari 				= '7';
		$minggu 			= '1';
		$bln 				= '1';
		$angsuranke1 = $this->input->post('angsuranpertama');
		if($periode_angsuran=='0'){
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' days'));
		}else if($periode_angsuran=='1'){
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' weeks'));
		}else{
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' months'));
		}

		echo json_encode(array('jatuh_tempo'=>$jatuh_tempo));
	}

	public function get_desa_by_keyword()
	{
		$keyword 	= $this->input->post('keyword');
		$kecamatan 	= $this->input->post('kecamatan');

		$data 		= $this->model_cif->get_desa_by_keyword($keyword,$kecamatan);

		echo json_encode($data);
	}

	public function get_fa_by_keyword()
	{
		$keyword 		= $this->input->post('keyword');
		$branch_code 	= $this->input->post('branch_code');
		$data 			= $this->model_cif->get_fa_by_keyword($keyword,$branch_code);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// BEGIN REGISTRASI PELUNASAN PEMBIAYAAN
	/****************************************************************************************/

	public function search_cif_for_pelunasan_pembiayaan()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_for_pelunasan_pembiayaan($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// BEGIN BLOKIR TABUNGAN
	/****************************************************************************************/

	public function search_cif_for_blokir_tabungan()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_for_blokir_tabungan($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// BEGIN BUKA BLOKIR TABUNGAN
	/****************************************************************************************/

	public function search_cif_for_buka_tabungan()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_for_buka_tabungan($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// BEGIN TUTUP TABUNGAN
	/****************************************************************************************/

	public function search_cif_for_tutup_tabungan()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_for_tutup_tabungan($keyword,$type,$cm_code);

		echo json_encode($data);
	}



	/****************************************************************************************/	
	// BEGIN FUNCTION
	/****************************************************************************************/
	public function search_cabang()
	{
		$keyword 	= $this->input->post('keyword');
		$data 		= $this->model_cif->search_cabang($keyword);
		echo json_encode($data);
	}

	function search_city(){
		$keyword 	= $this->input->post('keyword');
		$branch 	= $this->input->post('branch');
		$data 		= $this->model_cif->search_city($keyword,$branch);
		echo json_encode($data);
	}

	function search_kecamatan(){
		$keyword 	= $this->input->post('keyword');
		$branch 	= $this->input->post('branch');
		$city 	= $this->input->post('city');
		$data 		= $this->model_cif->search_kecamatan($keyword,$branch,$city);
		echo json_encode($data);
	}

	function search_desa(){
		$keyword 	= $this->input->post('keyword');
		$branch 	= $this->input->post('branch');
		$city 	= $this->input->post('city');
		$kecamatan 	= $this->input->post('kecamatan');
		$data 		= $this->model_cif->search_desa($keyword,$branch,$city,$kecamatan);
		echo json_encode($data);
	}
	/****************************************************************************************/	
	// END FUNCTION
	/****************************************************************************************/


	/****************************************************************************************/	
	// END FUNCTION CARI ACCOUNT INSURANCE NO
	/****************************************************************************************/

	public function search_account_insurance_no()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_account_insurance_no($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// END FUNCTION
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN ANGGOTA PINDAH
	/****************************************************************************************/
	public function anggota_mutasi()
	{
		$this->load->model('model_kelompok');

		$data['container'] = 'kelompok/anggota_mutasi';
		$data['kecamatan'] = $this->model_kelompok->get_all_mfi_city_kecamatan();
		$data['alasan'] = $this->model_kelompok->get_keterangan_keluar();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END ANGGOTA PINDAH
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN ANGGOTA KELUAR
	/****************************************************************************************/
	public function anggota_keluar()
	{
		$this->load->model('model_kelompok');

		$data['container'] = 'kelompok/anggota_keluar';
		$data['kecamatan'] = $this->model_kelompok->get_all_mfi_city_kecamatan();
		$data['alasan'] = $this->model_kelompok->get_keterangan_keluar();
		$this->load->view('core',$data);
	}	

	public function verifikasi_anggota_keluar()
	{
		$this->load->model('model_kelompok');

		$data['container'] = 'kelompok/verifikasi_anggota_keluar';
		$data['kecamatan'] = $this->model_kelompok->get_all_mfi_city_kecamatan();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function datatable_verifikasi_mutasi_anggota_keluar()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */

		$branch_id 			= @$_GET['branch_id'];
		$branch_code 		= @$_GET['branch_code'];
		// $trx_date 			= @$_GET['trx_date'];
		// $trx_date 			= str_replace('/', '', $trx_date);
		// $tgl_trx_date 		= substr($trx_date,0,2);
	 //    $bln_trx_date 		= substr($trx_date,2,2);
	 //    $thn_trx_date 		= substr($trx_date,4,4);
	    
	 //    if($trx_date!="")
	 //    	$trx_date 			= "$thn_trx_date-$bln_trx_date-$tgl_trx_date"; 
	    
		$aColumns = array( '','cm_code','cif_no','nama','created_date','created_by','');
				
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

		$rResult 			= $this->model_kelompok->datatable_verifikasi_mutasi_anggota_keluar($sWhere,$sOrder,$sLimit,$branch_id,$branch_code); // query get data to view
		$rResultFilterTotal = $this->model_kelompok->datatable_verifikasi_mutasi_anggota_keluar($sWhere,'','',$branch_id,$branch_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_kelompok->datatable_verifikasi_mutasi_anggota_keluar('','','',$branch_id,$branch_code); // get number of all data
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
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = '<div align="center">'.date('d/m/Y',strtotime($aRow['tanggal_mutasi'])).'</div>';
			$row[] = '<div align="center">'.$aRow['created_date'].'</div>';
			$row[] = '<div align="center">'.$aRow['created_by'].'</div>';
			$row[] = '<div align="center">
						<a href="javascript:;" tanggal_mutasi="'.date('d/m/Y',strtotime($aRow['tanggal_mutasi'])).'" cm_code="'.$aRow['cm_code'].'" cm_name="'.$aRow['cm_name'].'" cif_no="'.$aRow['cif_no'].'" nama="'.$aRow['nama'].'" cif_mutasi_id="'.$aRow['cif_mutasi_id'].'" id="link-verifikasi">Verifikasi</a>
						<input type="hidden" id="h_alasan" value="'.$aRow['alasan'].'">
						<input type="hidden" id="h_potongan_pembiayaan" value="'.$aRow['potongan_pembiayaan'].'">
					  </div>';
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	/****************************************************************************************/	
	// END ANGGOTA KELUAR
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN GET AJAX TANGGAL MULAI ANGSUR
	/****************************************************************************************/
	public function ajax_get_tanggal_angsur_pertama()
	{
		$periode_angsuran 		= $this->input->post('periode_angsuran');
		$jangka_waktu 			= $this->input->post('jangka_waktu');
		$tgl_akad 				= $this->input->post('tgl_akad');
		$grace_kelompok_hari 	= $this->input->post('grace_kelompok_hari');
		$grace_kelompok_minggu 	= $this->input->post('grace_kelompok_minggu');
		$grace_kelompok_bulan 	= $this->input->post('grace_kelompok_bulan');
		$hari 					= '3';
		$minggu 				= '2';
		$bulan 					= '1';
		if($periode_angsuran=='0'){
			$angsuranke1 = date('d/m/Y',strtotime($tgl_akad. '+'.$hari.' days'));
			// $angsuranke1 = date('d/m/Y',strtotime($angsuranke1. '+'.$grace_kelompok_hari.' days'));
		}else if($periode_angsuran=='1'){
			$angsuranke1 = date('d/m/Y',strtotime($tgl_akad. '+'.$minggu.' weeks'));
			// $angsuranke1 = date('d/m/Y',strtotime($angsuranke1. '+'.$grace_kelompok_minggu.' weeks'));
		}else{
			$angsuranke1 = date('d/m/Y',strtotime($tgl_akad. '+'.$bulan.' months'));
			// $angsuranke1 = date('d/m/Y',strtotime($angsuranke1. '+'.$grace_kelompok_bulan.' months'));
		}

		echo json_encode(array('angsuranke1'=>$angsuranke1));
	}

	/****************************************************************************************/	
	// END GET AJAX TANGGAL MULAI ANGSUR
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN GET AJAX TANGGAL SEKARANG
	/****************************************************************************************/
	public function ajax_get_date_now()
	{
		$tgl_akad 				= $this->input->post('tgl_akad');
		$date_now				= date('Y-m-d');
		$tgl     				= substr("$date_now",8,2);
	    $bln     				= substr("$date_now",5,2);
	    $thn	        		= substr("$date_now",0,4);
	    $tglakhir				= "$tgl-$bln-$thn";
	    $hari 					= '7';
	    $tgl_akad_sementara 	= date('d/m/Y',strtotime($tglakhir. '+'.$hari.' days'));

		echo json_encode(array('date_now'=>$tglakhir,'date_akad'=>$tgl_akad_sementara));
	}

	/****************************************************************************************/	
	// END GET AJAX TANGGAL SEKARANG
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN GET AJAX TANGGAL JATUH TEMPO
	/****************************************************************************************/
	public function ajax_get_tanggal_jatuh_tempo2()
	{
		$periode_angsuran 	= $this->input->post('periode_angsuran');
		$hari 				= '7';
		$minggu 			= '1';
		$bln 				= '0';
		$angsuranke1 		= $this->input->post('angsuranpertama');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		if($periode_angsuran=='0'){
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' days'));
		}else if($periode_angsuran=='1'){
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' weeks'));
		}else{
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' months'));
		}

		echo json_encode(array('jatuh_tempo'=>$jatuh_tempo));
	}
	/****************************************************************************************/	
	// END GET AJAX TANGGAL JATUH TEMPO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN FUNCTION
	/****************************************************************************************/
	public function search_cif()
	{
		$keyword 	= $this->input->post('keyword');
		$data 		= $this->model_cif->search_cif($keyword);

		echo json_encode($data);
	}
	/****************************************************************************************/	
	// END FUNCTION
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN GET AJAX TANGGAL JATUH TEMPO
	/****************************************************************************************/
	public function ajax_get_tanggal_jatuh_tempo_deposito()
	{
		$jangka_waktu 	= $this->input->post('jangka_waktu');
		$tgl_sekarang 	= $this->input->post('tgl_sekarang');

		$jatuh_tempo = date('d/m/Y',strtotime($tgl_sekarang. '+'.$jangka_waktu.' months'));

		echo json_encode(array('jatuh_tempo'=>$jatuh_tempo));
	}

	public function ajax_get_tanggal_jatuh_tempo_next_deposito()
	{
		$jangka_waktu 	= "1";
		$tgl_sekarang 	= $this->input->post('tgl_sekarang');
		
		$jatuh_tempo_next = date('d/m/Y',strtotime($tgl_sekarang. '+'.$jangka_waktu.' months'));

		echo json_encode(array('jatuh_tempo_next'=>$jatuh_tempo_next));
	}
	/****************************************************************************************/	
	// END GET AJAX TANGGAL JATUH TEMPO
	/****************************************************************************************/

	public function search_no_pembiayaan()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_no_pembiayaan($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	/*
	| URUT NO KELOMPOK
	*/
	function urut_no_kelompok()
	{
		$data['title'] = "Urut No Kelompok";
		$data['container'] = "cif/urut_no_kelompok";
		$data['cms'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	function get_all_data_cif_by_cm_code()
	{
		$cm_code=$this->input->post('cm_code');
		$status=$this->input->post('status');
		$data=$this->model_cif->get_all_data_cif_by_cm_code($cm_code,$status);
		echo json_encode($data);
	}

	function process_urut_no_kelompok()
	{
		$arr_cif_id=$this->input->post('arr_cif_id');
		$arr_no_urut=$this->input->post('arr_no_urut');
		
		$this->db->trans_begin();
		for($i=0;$i<count($arr_cif_id);$i++){
			$upd_cif=array('kelompok'=>$arr_no_urut[$i]);
			$prm_cif=array('cif_id'=>$arr_cif_id[$i]);
			$this->model_cif->update_cif($upd_cif,$prm_cif);
		}
		if($this->db->trans_status()===TRUE){
			$this->db->trans_commit();
			$return=array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return=array('success'=>false);
		}
		echo json_encode($return);
	}


	/******************************************************************************************/
	//TAMBAHAN ADE, BRANCH 5 DIGIT
	public function get_all_branch_wilayah()
	{
		$branch = $this->model_cif->get_all_branch_wilayah();
		echo json_encode($branch);
	}
	public function get_all_branch_cabang()
	{
		$branch = $this->model_cif->get_all_branch_cabang();
		echo json_encode($branch);
	}
	//END TAMBAHAN ADE, BRANCH 5 DIGIT
	/******************************************************************************************/

	/*
	* SETORAN POKOK
	*/
	function setoran_pokok()
	{
		$data['container'] = 'cif/setoran_pokok';
		$this->load->view('core',$data);
	}

	function do_setoran_pokok()
	{
		$debug = false;
		$tanggal = $this->input->post('tanggal');

		$cek_double_proses = $this->model_cif->check_double_proses_setoran_pokok($tanggal);

		if ($cek_double_proses==true) {
			$rows = $this->model_cif->get_saldo_for_setoran_pokok();

			$arr_trx_pokok = array();
			$arr_trx_wajib = array();

			$this->db->trans_begin();

				foreach ($rows as $row) :
					$v_cif_no = $row['cif_no'];
					$v_nama = $row['nama'];
					$v_tabungan_wajib = $row['tabungan_wajib'];
					$v_tabungan_kelompok = $row['tabungan_kelompok'];
					$v_smk = $row['smk'];
					$v_flag_setoran = $row['flag_setoran']; // 0 = setoran pokok, 1 = setoran wajib
					$v_total_tabungan = 0;

					// BEGIN
					$setoran_pokok = $this->_setoran_pokok;
					$setoran_wajib = $this->_setoran_wajib;
					$total_tabungan = $v_tabungan_wajib+$v_tabungan_kelompok;

					$sisa_setoran_pokok = $setoran_pokok;
					$sisa_setoran_wajib = $setoran_wajib;
					$sisa_tabungan_wajib = $v_tabungan_wajib;
					$sisa_tabungan_kelompok = $v_tabungan_kelompok;
					$setor_tabungan_wajib = 0;
					$setor_tabungan_kelompok = 0;

					switch ($v_flag_setoran) {
						case '0': // setoran pokok
							$setoran_wajib=0;
							// debet saldo tabungan sebesar setoran pokok
							// jika saldo tabungan >= setoran pokok maka didebet sejumlah setoran pokok
							// dan jika saldo tabungan < setoran pokok maka ga didebet
							if ( $total_tabungan >= $sisa_setoran_pokok )
							{
								// debet tabungan wajib
								$sisa_tabungan_wajib = $v_tabungan_wajib-$sisa_setoran_pokok;
								if ($sisa_tabungan_wajib<0) $sisa_tabungan_wajib=0;
								$setor_tabungan_wajib = $v_tabungan_wajib-$sisa_tabungan_wajib;
								
								// kurangi setoran pokok
								$sisa_setoran_pokok -= $setor_tabungan_wajib;

								// debet tabungan kelompok
								if ($sisa_setoran_pokok>0)
								{
									$sisa_tabungan_kelompok = $v_tabungan_kelompok-$sisa_setoran_pokok;
									$sisa_setoran_pokok = 0;
								}
								$setor_tabungan_kelompok = $v_tabungan_kelompok-$sisa_tabungan_kelompok;

								// create history trx
								$arr_trx_pokok[] = array(
									'cif_no' => $v_cif_no
									,'trx_type' => 0
									,'setor_tabungan_wajib' => $setor_tabungan_wajib
									,'setor_tabungan_kelompok' => $setor_tabungan_kelompok
									,'total_setoran' => $setoran_pokok
									,'trx_date' => $tanggal
									,'created_by' => $this->session->userdata('user_id')
									,'trx_status' => 1
									,'verify_by' => $this->session->userdata('user_id')
									,'verify_date' => date('Y-m-d H:i:s')
								);

								// update saldo default balance
								if ($debug==false) {
									$saldo = array(
											'tabungan_wajib'=>$sisa_tabungan_wajib,
											'tabungan_kelompok'=>$sisa_tabungan_kelompok,
											'simpanan_pokok'=>$setoran_pokok
										);
									$param = array('cif_no'=>$v_cif_no);
									$this->db->update('mfi_account_default_balance',$saldo,$param);
								}
							}
						break;
						case '1': // setoran wajib
							$setoran_pokok=0;
							// debet saldo tabungan sebesar setoran pokok
							// jika saldo tabungan >= setoran pokok maka didebet sejumlah setoran pokok
							// dan jika saldo tabungan < setoran pokok maka ga didebet
							if ( $total_tabungan >= $sisa_setoran_wajib )
							{
								// debet tabungan wajib
								$sisa_tabungan_wajib = $v_tabungan_wajib-$sisa_setoran_wajib;
								if ($sisa_tabungan_wajib<0) $sisa_tabungan_wajib=0;
								$setor_tabungan_wajib = $v_tabungan_wajib-$sisa_tabungan_wajib;
								
								// kurangi setoran wajib
								$sisa_setoran_wajib -= $setor_tabungan_wajib;

								// debet tabungan kelompok
								if ($sisa_setoran_wajib>0)
								{
									$sisa_tabungan_kelompok = $v_tabungan_kelompok-$sisa_setoran_wajib;
									$sisa_setoran_wajib = 0;
								}
								$setor_tabungan_kelompok = $v_tabungan_kelompok-$sisa_tabungan_kelompok;

								// create history trx
								$arr_trx_wajib[] = array(
									'cif_no' => $v_cif_no
									,'trx_type' => 0
									,'tabungan_wajib' => $setor_tabungan_wajib
									,'tabungan_kelompok' => $setor_tabungan_kelompok
									,'total' => $setoran_wajib
									,'trx_date' => $tanggal
									,'created_by' => $this->session->userdata('user_id')
									,'trx_status' => 1
									,'verify_by' => $this->session->userdata('user_id')
									,'verify_date' => date('Y-m-d H:i:s')
								);

								// update saldo default balance
								if ($debug==false) {
									$saldo = array(
											'tabungan_wajib'=>$sisa_tabungan_wajib,
											'tabungan_kelompok'=>$sisa_tabungan_kelompok,
											'smk'=>$v_smk+$setoran_wajib
										);
									$param = array('cif_no'=>$v_cif_no);
									$this->db->update('mfi_account_default_balance',$saldo,$param);
								}
							}
						break;
					}

				endforeach;
				if ($debug==false) {
					if (count($arr_trx_pokok)>0) {
						$this->db->insert_batch('mfi_trx_setoran_pokok',$arr_trx_pokok);
					}
					if (count($arr_trx_wajib)>0) {
						$this->db->insert_batch('mfi_trx_smk',$arr_trx_wajib);
					}
				} else {
					echo "<pre>";
					print_r($arr_trx_pokok);
					print_r($arr_trx_wajib);
					echo "</pre>";
					die();
				}

			if ($this->db->trans_status()===true) {
				$this->db->trans_commit();
				$return = array('success'=>true);
			} else {
				$this->db->trans_rollback();
				$return = array('success'=>false,'message'=>'Failed to connect into databases, please check your connection.');
			}
		} else {
			$return = array('success'=>false,'message'=>'Proses sudah dilakukan pada Tanggal ini!');
		}
		echo json_encode($return);
	}

	function jqgrid_setoran_pokok()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'account_financing_no';//1
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$branch_code = $_REQUEST['branch_code'];
		
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_cif->jqgrid_setoran_pokok('','','','',$branch_code);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_cif->jqgrid_setoran_pokok($sidx,$sort,$limit_rows,$start,$branch_code);
		
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['id']=$row['id'];
		    $responce['rows'][$i]['cell']=array(
			     $row['id']
				,$row['cif_no']
				,$row['nama']
				,$row['tabungan_wajib']
				,$row['tabungan_kelompok']
				,$row['simpanan_pokok']
				,$row['smk']
			);
		    $i++;
		}

		echo json_encode($responce);
	}

	function debet_setoran_pokok(){
		$tanggal = $this->input->post('tanggal');
		$branch = $this->input->post('branch');
		$trx_date = date('Y-m-d');
		$trx_datetime = date('Y-m-d H:i:s');
		$created_date = date('Y-m-d H:i:s');

		$show = $this->model_cif->show_account_default_balance($branch);

		$ins = $this->model_cif->show_institution();

		$simpanan_pokok = $ins['simpanan_pokok']; // 100.000
		$simpanan_wajib = $ins['simpanan_wajib']; // 50.000

		$this->db->trans_begin();

		foreach($show as $sh){
			$cif_no = $sh['cif_no'];
			$wajib = $sh['tabungan_wajib']; // 117.000
			$kelompok = $sh['tabungan_kelompok']; // 208.294
			$simpok = $sh['simpanan_pokok'];

			if($simpok != $simpanan_pokok){
				if($wajib > $simpanan_pokok){
					$sisa_setoran = $wajib - $simpanan_pokok; // 117.000 - 100.000 = 17.000
					$sisa_wajib = $sisa_setoran; // 17.000 (DIAMBIL)
					$total_setoran = $wajib - $sisa_setoran;
					$limit_wajib = $total_setoran;
					$insert = array(
						'cif_no' => $cif_no,
						'trx_type' => 0,
						'setor_tabungan_wajib' => $limit_wajib,
						'setor_tabungan_kelompok' => 0,
						'setor_tabungan_sukarela' => 0,
						'total_setoran' => $total_setoran,
						'trx_date' => $trx_date,
						'created_date' => $trx_datetime,
						'created_by' => $this->session->userdata('user_id')
					);

					$total_tabungan = $sisa_wajib + $kelompok; // 17.000 + 208.294 = 225.294

					if($total_tabungan >= $simpanan_wajib){
						$freq = ceil($total_tabungan / $simpanan_wajib);
						$smk = 0;

						for($i = 1; $i <= $freq; $i++){
							if(($i * $simpanan_wajib) <= $total_tabungan){
								$smk += $simpanan_wajib;
							}
						}
						
						$sisa_total_kelompok = $smk - $sisa_wajib; // 200.000 - 17.000 = 183.000
						
						$insert_smk = array(
							'cif_no' => $cif_no,
							'trx_type' => 0,
							'tabungan_wajib' => $sisa_wajib,
							'tabungan_kelompok' => 0,
							'total' => $sisa_wajib,
							'trx_date' => $trx_date,
							'created_date' => $created_date,
							'created_by' => $this->session->userdata('user_id')
						);

						$s_insert_smk = array(
							'cif_no' => $cif_no,
							'trx_type' => 0,
							'tabungan_wajib' => 0,
							'tabungan_kelompok' => $sisa_total_kelompok,
							'total' => $sisa_total_kelompok,
							'trx_date' => $trx_date,
							'created_date' => $created_date,
							'created_by' => $this->session->userdata('user_id')
						);

						$sisa_kelompok = $total_tabungan - $smk;

						$update = array(
							'tabungan_wajib' => 0,
							'tabungan_kelompok' => $sisa_kelompok,
							'simpanan_pokok' => $total_setoran,
							'smk' => $smk
						);
					}

					$this->model_transaction->add_transaksi_setoran_pokok($insert);
					$this->model_transaction->add_transaksi_setoran_wajib($insert_smk);
					$this->model_transaction->add_transaksi_setoran_wajib($s_insert_smk);
					$this->model_transaction->update_simpanan_pokok($cif_no,$update);
				} else if($wajib < $simpanan_pokok) {
					$jumlah_setoran = $wajib + $kelompok; // 74.600 + 158.194 = 232.794
					if($jumlah_setoran > $simpanan_pokok){
						$total_kelompok = $simpanan_pokok - $wajib; // 100.000 - 74.600 = 25.400
						$total_setoran = $wajib + $total_kelompok; // 74.600 + 25.400 = 232.794
						$sisa_setoran = $jumlah_setoran - $total_setoran; // 232.794 - 100.000 = 132.794

						$insert = array(
							'cif_no' => $cif_no,
							'trx_type' => 0,
							'setor_tabungan_wajib' => $wajib,
							'setor_tabungan_kelompok' => 0,
							'setor_tabungan_sukarela' => 0,
							'total_setoran' => $wajib,
							'trx_date' => $trx_date,
							'created_date' => $trx_datetime,
							'created_by' => $this->session->userdata('user_id')
						);

						$this->model_transaction->add_transaksi_setoran_pokok($insert);

						$s_insert = array(
							'cif_no' => $cif_no,
							'trx_type' => 0,
							'setor_tabungan_wajib' => 0,
							'setor_tabungan_kelompok' => $total_kelompok,
							'setor_tabungan_sukarela' => 0,
							'total_setoran' => $total_kelompok,
							'trx_date' => $trx_date,
							'created_date' => $trx_datetime,
							'created_by' => $this->session->userdata('user_id')
						);

						$this->model_transaction->add_transaksi_setoran_pokok($s_insert);

						if($sisa_setoran >= $simpanan_wajib){
							$freq = ceil($sisa_setoran / $simpanan_wajib);
							$smk = 0;

							for($i = 1; $i <= $freq; $i++){
								if(($i * $simpanan_wajib) <= $sisa_setoran){
									$smk += $simpanan_wajib;
								}
							}
							
							$sisa_total_kelompok = $smk;

							$insert_smk = array(
								'cif_no' => $cif_no,
								'trx_type' => 0,
								'tabungan_wajib' => 0,
								'tabungan_kelompok' => $sisa_total_kelompok,
								'total' => $sisa_total_kelompok,
								'trx_date' => $trx_date,
								'created_date' => $created_date,
								'created_by' => $this->session->userdata('user_id')
							);

							$sisa_kelompok = $sisa_setoran - $smk;
							$update = array(
								'tabungan_wajib' => 0,
								'tabungan_kelompok' => $sisa_kelompok,
								'simpanan_pokok' => $total_setoran,
								'smk' => $smk
							);

							$this->model_transaction->add_transaksi_setoran_wajib($insert_smk);
						} else {
							$sisa_kelompok = $sisa_setoran;
							$update = array(
								'tabungan_wajib' => 0,
								'tabungan_kelompok' => $sisa_kelompok,
								'simpanan_pokok' => $total_setoran
							);
						}

						$this->model_transaction->update_simpanan_pokok($cif_no,$update);

					} else if($jumlah_setoran == $simpanan_pokok){
						$insert = array(
							'cif_no' => $cif_no,
							'trx_type' => 0,
							'setor_tabungan_wajib' => $wajib,
							'setor_tabungan_kelompok' => 0,
							'setor_tabungan_sukarela' => 0,
							'total_setoran' => $wajib,
							'trx_date' => $trx_date,
							'created_date' => $trx_datetime,
							'created_by' => $this->session->userdata('user_id')
						);

						$this->model_transaction->add_transaksi_setoran_pokok($insert);

						$s_insert = array(
							'cif_no' => $cif_no,
							'trx_type' => 0,
							'setor_tabungan_wajib' => 0,
							'setor_tabungan_kelompok' => $kelompok,
							'setor_tabungan_sukarela' => 0,
							'total_setoran' => $kelompok,
							'trx_date' => $trx_date,
							'created_date' => $trx_datetime,
							'created_by' => $this->session->userdata('user_id')
						);

						$this->model_transaction->add_transaksi_setoran_pokok($s_insert);

						$update = array(
							'tabungan_wajib' => 0,
							'tabungan_kelompok' => 0,
							'simpanan_pokok' => $jumlah_setoran
						);
						$this->model_transaction->update_simpanan_pokok($cif_no,$update);
					}
				} else {
					$total_setoran = $wajib;
					$insert = array(
						'cif_no' => $cif_no,
						'trx_type' => 0,
						'setor_tabungan_wajib' => $wajib,
						'setor_tabungan_kelompok' => 0,
						'setor_tabungan_sukarela' => 0,
						'total_setoran' => $wajib,
						'trx_date' => $trx_date,
						'created_date' => $trx_datetime,
						'created_by' => $this->session->userdata('user_id')
					);

					$this->model_transaction->add_transaksi_setoran_pokok($insert);

					if($kelompok >= $simpanan_wajib){
						$freq = ceil($kelompok / $simpanan_wajib);
						$smk = 0;

						for($i = 1; $i <= $freq; $i++){
							if(($i * $simpanan_wajib) <= $kelompok){
								$smk += $simpanan_wajib;
							}
						}

						$sisa_total_kelompok = $smk;

						$sisa_kelompok = $kelompok - $smk;

						$insert_smk = array(
							'cif_no' => $cif_no,
							'trx_type' => 0,
							'tabungan_wajib' => 0,
							'tabungan_kelompok' => $sisa_total_kelompok,
							'total' => $sisa_total_kelompok,
							'trx_date' => $trx_date,
							'created_date' => $created_date,
							'created_by' => $this->session->userdata('user_id')
						);

						$update = array(
							'tabungan_wajib' => 0,
							'tabungan_kelompok' => $sisa_kelompok,
							'simpanan_pokok' => $total_setoran,
							'smk' => $smk
						);
					}

					$this->model_transaction->add_transaksi_setoran_wajib($insert_smk);
					$this->model_transaction->update_simpanan_pokok($cif_no,$update);
				}
			}
		}

		if($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return = array('success'=> TRUE);
		} else {
			$this->db->trans_rollback();
			$return = array(
				'success'=> FALSE,
				'message'=> 'Failed to connect into databases, please check your connection.'
			);
		}

		echo json_encode($return);
	}

	function search_petugas_by_cabang(){
		$keyword = $this->input->post('keyword');
		$cabang = $this->input->post('branch_code');
		$search = $this->model_cif->search_petugas_by_cabang($keyword,$cabang);

		echo json_encode($search);
	}

	function search_majelis_by_petugas(){
		$keyword = $this->input->post('keyword');
		$kode = $this->input->post('branch_code');
		$cabang = $this->input->post('branch_id');
		$petugas = $this->input->post('fa_code');
		$search = $this->model_cif->search_majelis_by_petugas($keyword,$kode,$cabang,$petugas);

		echo json_encode($search);
	}

	public function search_account_no()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_by_account_no($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	public function search_account_no_by_status_verif()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_account_no_by_status_verif($keyword,$type,$cm_code);

		echo json_encode($data);
	}
}

/* End of file group.php */
/* Location: ./application/controllers/group.php */