<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelompok extends GMN_Controller 
{


	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_kelompok');
		$this->load->model('model_nasabah');
		$this->load->model('model_transaction');
	}

	public function index()
	{
		$data['container'] = 'kelompok';
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// BEGIN ANGGOTA KELUAR
	/****************************************************************************************/

	public function anggota_keluar()
	{
		$data['container'] = 'kelompok/anggota_keluar';
		$data['kecamatan'] = $this->model_kelompok->get_all_mfi_city_kecamatan();
		$this->load->view('core',$data);
	}

	public function search_desa_by_kecamatan()
	{
		$keyword = $this->input->post('keyword');
		$kecamatan = $this->input->post('kecamatan');
		$data = $this->model_kelompok->search_desa_by_kecamatan($keyword,$kecamatan);

		echo json_encode($data);
	}

	public function get_rembug_by_desa_code()
	{
		$desa_code = $this->input->post('desa_code');
		$data = $this->model_kelompok->get_rembug_by_desa_code($desa_code);

		echo json_encode($data);
	}

	public function get_anggota_rembug_by_cm_code()
	{
		$cm_code = $this->input->post('cm_code');
		$data = $this->model_kelompok->get_anggota_rembug_by_cm_code($cm_code);

		echo json_encode($data);
	}

	public function get_cif_by_cif_no()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_kelompok->get_cif_by_cif_no($cif_no);

		echo json_encode($data);
	}

	public function get_saldo_by_cif_no()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_kelompok->get_saldo_by_cif_no($cif_no);

		echo json_encode($data);
	}

	function get_saldo_by_cif_no_verifikasi(){
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_kelompok->get_saldo_by_cif_no($cif_no);

		echo json_encode($data);
	}

	public function get_rembug_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_kelompok->get_rembug_by_keyword($keyword,$branch_code);

		echo json_encode($data);
	}

	function proses_anggota_keluar(){
		$cif_no = $this->input->post('cif_no');
		$tipe_mutasi = "1"; //anggota keluar
		$cm_code = $this->input->post('cm_code');
		$saldo_pembiayaan = $this->convert_numeric($this->input->post('saldo_pembiayaan'));
		$saldo_margin = $this->convert_numeric($this->input->post('saldo_margin'));
		$saldo_catab = $this->convert_numeric($this->input->post('saldo_catab'));
		$saldo_tabungan_wajib = $this->convert_numeric($this->input->post('saldo_tabungan_wajib'));
		$saldo_tabungan_kelompok = $this->convert_numeric($this->input->post('saldo_tabungan_kelompok'));
		$saldo_sukarela = $this->convert_numeric($this->input->post('saldo_sukarela'));
		$saldo_tabungan_mingguan = $this->convert_numeric($this->input->post('saldo_tabungan_mingguan'));
		$saldo_tabungan_berencana = $this->convert_numeric($this->input->post('saldo_tabungan_berencana'));
		$saldo_deposito = $this->convert_numeric($this->input->post('saldo_deposito'));
		$saldo_cadangan_resiko = $this->convert_numeric($this->input->post('saldo_cadangan_resiko'));
		$saldo_simpanan_pokok = $this->convert_numeric($this->input->post('saldo_simpanan_pokok'));
		///$saldo_smk = $this->convert_numeric($this->input->post('saldo_smk'));
		///$saldo_mingguan = $this->convert_numeric($this->input->post('saldo_mingguan'));
		$saldo_smk = '0';
		$saldo_mingguan = '0';
		$saldo_lwk = $this->convert_numeric($this->input->post('saldo_lwk'));
		$potongan_pembiayaan = $this->convert_numeric($this->input->post('potongan_pembiayaan'));
		$setoran_tambahan = $this->convert_numeric($this->input->post('setoran_tambahan'));
		$penarikan_tabungan_sukarela = $this->convert_numeric($this->input->post('penarikan_tabungan_sukarela'));
		$bonus_bagihasil = $this->convert_numeric($this->input->post('bonus_bagihasil'));
		$saldo_individu = $this->convert_numeric($this->input->post('saldo_individu'));
		$flag_saldo_margin = $this->input->post('flag_saldo_margin');
		$flag_saldo_catab = $this->input->post('flag_saldo_catab');
		$flag_saldo_tabungan_wajib = $this->input->post('flag_saldo_tabungan_wajib');
		$flag_saldo_tabungan_kelompok = $this->input->post('flag_saldo_tabungan_kelompok');
		$tanggal_mutasi = $this->input->post('tanggal_mutasi');
		$tanggal_mutasi = $this->datepicker_convert(true,$tanggal_mutasi,'/');

		$alasan = $this->input->post('alasan');
		$keterangan = $this->input->post('keterangan');
		$fa_code = "0"; //untuk sementara karna tak tahu harus diisi apa
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('user_id');

		$cek_cif_mutasi = $this->model_kelompok->cek_cif_mutasi($cif_no);

		$validate_pembiayaan = TRUE;

		if($cek_cif_mutasi == FALSE){
			$return = array(
				'success' => FALSE,
				'message' => 'Anggota ini SUDAH melakukan Registrasi Anggota Keluar!'
			);
		} else {
			$data = array(
				'cif_no' => $cif_no,
				'tipe_mutasi' => $tipe_mutasi,
				'cm_code' => $cm_code,
				'saldo_pembiayaan_pokok' => $saldo_pembiayaan,
				'saldo_pembiayaan_margin' => $saldo_margin,
				'saldo_pembiayaan_catab' => $saldo_catab,
				'saldo_tab_wajib' => $saldo_tabungan_wajib,
				'saldo_tab_kelompok' => $saldo_tabungan_kelompok,
				'saldo_tab_sukarela' => $saldo_sukarela,
				'saldo_tab_minggon' => $saldo_mingguan,
				'saldo_tab_berencana' => $saldo_tabungan_berencana,
				'saldo_deposito' => $saldo_deposito,
				'saldo_cadangan_resiko' => $saldo_cadangan_resiko,
				'saldo_simpanan_pokok' => $saldo_simpanan_pokok,
				'saldo_simpanan_wajib' => $saldo_tabungan_mingguan,
				'saldo_smk' => $saldo_smk,
				'saldo_lwk' => $saldo_lwk,
				'potongan_pembiayaan' => $potongan_pembiayaan,
				'setoran_tambahan' => $setoran_tambahan,
				'saldo_individu' => $saldo_individu,
				'penarikan_tabungan_sukarela' => $penarikan_tabungan_sukarela,
				'flag_saldo_margin' => (($flag_saldo_margin==1)?1:2),
				'flag_saldo_catab' => (($flag_saldo_catab==1)?1:2),
				'flag_saldo_tabungan_wajib' => (($flag_saldo_tabungan_wajib==1)?1:2),
				'flag_saldo_tabungan_kelompok' => (($flag_saldo_tabungan_kelompok==1)?1:2),
				'bonus_bagihasil' => $bonus_bagihasil,
				'status' => 0,
				'description' => $keterangan,
				'alasan' => $alasan,
				'tanggal_mutasi' => $tanggal_mutasi,
				'fa_code' => $fa_code,
				'created_date' => $created_date,
				'created_by' => $created_by
			);

			$this->db->trans_begin();

			// CEK PEMBIAYAAN AKTIF INDIVIDU
			$cekIndividu = $this->model_kelompok->cek_pembiayaan_aktif_individu($cif_no);
			$jumlah = $cekIndividu['jumlah'];

			if($jumlah > 0){
				$return = array(
					'success' => FALSE,
					'message' => 'Gagal! Masih ada Pembiayaan Individu yang aktif. Harap lunaskan terlebih dahulu.'
				);
			} else {
				$this->model_kelompok->proses_anggota_keluar($data);

				if($this->db->trans_status() === TRUE){
					$this->db->trans_commit();
					$return = array(
						'success' => TRUE,
						'message' => 'Registrasi Pengeluaran Anggota Berhasil!'
					);
				} else {
					$this->db->trans_rollback();
					$return = array(
						'success' => FALSE,
						'message' => 'Failed to Connect into Databases, Please Contact Your Administrator!'
					);
				}
			}
		}

		echo json_encode($return);
	}

	function verifikasi_approve_mutasi_anggota_keluar(){
		$cif_mutasi_id 		= $this->input->post('cif_mutasi_id');
		$cif_no 			= $this->input->post('id_anggota');
		$data_mutasi 		= $this->model_kelompok->get_mutasi_by_id($cif_mutasi_id);

		/*raw history mutasi*/
		$data 				= array('status'=>1);
		$param 				= array('cif_mutasi_id'=>$cif_mutasi_id);

		/*raw anggota/cif*/
		$data_status 		= array('status'=>3);
		$param_status 		= array('cif_no'=>$cif_no);

		/*raw financing*/
		$data_financing 	= array('status_rekening'=>4);
		$param_financing 	= array('cif_no'=>$cif_no,'status_rekening'=>1);

		/*raw account_saving*/
		$data_saving 		= array('status_rekening'=>4);
		$param_saving 		= array('cif_no'=>$cif_no,'status_rekening'=>1);

		/*raw deposito*/
		$data_deposito 		= array('status_rekening'=>4);
		$param_deposito 	= array('cif_no'=>$cif_no,'status_rekening'=>1);

		/*
		| raw trx sukarela
		|----------------------------
		| - tab.wajib
		| - tab.kelompok
		| - bonus bagihasil
		*/
		$data_trx_sukarela=array();

		if($data_mutasi['saldo_tab_wajib']>0){
			$data_trx_sukarela[] = array(
					'cif_no'=>$data_mutasi['cif_no']
					,'trx_date'=>$data_mutasi['tanggal_mutasi']
					,'amount'=>$data_mutasi['saldo_tab_wajib']
					,'trx_type'=>1
					,'flag_debet_credit'=>'C'
					,'trx_source_id'=>$cif_mutasi_id
					,'created_stamp'=>date('Y-m-d H:i:s')
					,'created_by'=>$this->session->userdata('user_id')
				);
		}
		if($data_mutasi['saldo_tab_kelompok']>0){
			$data_trx_sukarela[] = array(
					'cif_no'=>$data_mutasi['cif_no']
					,'trx_date'=>$data_mutasi['tanggal_mutasi']
					,'amount'=>$data_mutasi['saldo_tab_kelompok']
					,'trx_type'=>2
					,'flag_debet_credit'=>'C'
					,'trx_source_id'=>$cif_mutasi_id
					,'created_stamp'=>date('Y-m-d H:i:s')
					,'created_by'=>$this->session->userdata('user_id')
				);
		}
		if($data_mutasi['bonus_bagihasil']>0){
			$data_trx_sukarela[] = array(
					'cif_no'=>$data_mutasi['cif_no']
					,'trx_date'=>$data_mutasi['tanggal_mutasi']
					,'amount'=>$data_mutasi['bonus_bagihasil']
					,'trx_type'=>6
					,'flag_debet_credit'=>'C'
					,'trx_source_id'=>$cif_mutasi_id
					,'created_stamp'=>date('Y-m-d H:i:s')
					,'created_by'=>$this->session->userdata('user_id')
				);
		}
		if($data_mutasi['saldo_tab_berencana']>0){
			$data_trx_sukarela[] = array(
					'cif_no'=>$data_mutasi['cif_no']
					,'trx_date'=>$data_mutasi['tanggal_mutasi']
					,'amount'=>$data_mutasi['saldo_tab_berencana']
					,'trx_type'=>3
					,'flag_debet_credit'=>'C'
					,'trx_source_id'=>$cif_mutasi_id
					,'created_stamp'=>date('Y-m-d H:i:s')
					,'created_by'=>$this->session->userdata('user_id')
				);
		}
		if($data_mutasi['saldo_individu'] > 0){
			$data_trx_sukarela[] = array(
				'cif_no'=>$data_mutasi['cif_no']
				,'trx_date'=>$data_mutasi['tanggal_mutasi']
				,'amount'=>$data_mutasi['saldo_individu']
				,'trx_type'=>10
				,'flag_debet_credit'=>'C'
				,'trx_source_id'=>$cif_mutasi_id
				,'created_stamp'=>date('Y-m-d H:i:s')
				,'created_by'=>$this->session->userdata('user_id')
			);
		}
		if($data_mutasi['saldo_simpanan_pokok']>0){
			$data_trx_sukarela[] = array(
					'cif_no'=>$data_mutasi['cif_no']
					,'trx_date'=>$data_mutasi['tanggal_mutasi']
					,'amount'=>$data_mutasi['saldo_simpanan_pokok']
					,'trx_type'=>11
					,'flag_debet_credit'=>'C'
					,'trx_source_id'=>$cif_mutasi_id
					,'created_stamp'=>date('Y-m-d H:i:s')
					,'created_by'=>$this->session->userdata('user_id')
				);
		}
		if($data_mutasi['saldo_smk']>0){
			$data_trx_sukarela[] = array(
					'cif_no'=>$data_mutasi['cif_no']
					,'trx_date'=>$data_mutasi['tanggal_mutasi']
					,'amount'=>$data_mutasi['saldo_smk']
					,'trx_type'=>12
					,'flag_debet_credit'=>'C'
					,'trx_source_id'=>$cif_mutasi_id
					,'created_stamp'=>date('Y-m-d H:i:s')
					,'created_by'=>$this->session->userdata('user_id')
				);
		}
		if($data_mutasi['saldo_lwk']>0){
			$data_trx_sukarela[] = array(
					'cif_no'=>$data_mutasi['cif_no']
					,'trx_date'=>$data_mutasi['tanggal_mutasi']
					,'amount'=>$data_mutasi['saldo_lwk']
					,'trx_type'=>13
					,'flag_debet_credit'=>'C'
					,'trx_source_id'=>$cif_mutasi_id
					,'created_stamp'=>date('Y-m-d H:i:s')
					,'created_by'=>$this->session->userdata('user_id')
				);
		}
		if($data_mutasi['saldo_simpanan_wajib']>0){
			$data_trx_sukarela[] = array(
					'cif_no'=>$data_mutasi['cif_no']
					,'trx_date'=>$data_mutasi['tanggal_mutasi']
					,'amount'=>$data_mutasi['saldo_simpanan_wajib']
					,'trx_type'=>14
					,'flag_debet_credit'=>'C'
					,'trx_source_id'=>$cif_mutasi_id
					,'created_stamp'=>date('Y-m-d H:i:s')
					,'created_by'=>$this->session->userdata('user_id')
				);
		}

		/*get account saving plan cif*/
		$result_saving=$this->model_kelompok->get_account_saving_plan($cif_no);

		/*updating to master*/
		$this->db->trans_begin();

		//updating to mfi_account_financing
		$this->model_transaction->update_account_financing($data_financing,$param_financing);
		//updating to mfi_account_saving
		$this->model_transaction->update_account_saving($data_saving,$param_saving);
		//updating to mfi_account_deposito
		$this->model_transaction->update_account_deposit($data_deposito,$param_deposito);
		//updating to mfi_cif_mutasi
		$this->model_kelompok->update_mutasi_anggota($data,$param);
		//updating to mfi_cif
		$this->model_kelompok->update_cif_status($data_status,$param_status);
		//insert to trx sukarela
		if(count($data_trx_sukarela)>0){
			$this->model_transaction->insert_batch_trx_sukarela($data_trx_sukarela);
		}

		if($this->db->trans_status()==true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	public function verifikasi_reject_mutasi_anggota_keluar()
	{
		$cif_mutasi_id = $this->input->post('cif_mutasi_id');
		$cif_no = $this->input->post('cif_no');
		$data_status = array('status'=>1);
		$param_status= array('cif_no'=>$cif_no);
		$param=array('cif_mutasi_id'=>$cif_mutasi_id);
		$this->db->trans_begin();
		$this->model_kelompok->update_cif_status($data_status,$param_status);
		$this->model_kelompok->delete_mutasi_anggota($param);
		if($this->db->trans_status()==true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END ANGGOTA KELUAR
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN ANGGOTA PINDAH
	/****************************************************************************************/
	public function anggota_mutasi()
	{
		$data['container'] = 'kelompok/anggota_mutasi';
		$data['kecamatan'] = $this->model_kelompok->get_all_mfi_city_kecamatan();
		$this->load->view('core',$data);
	}
	public function proses_anggota_pindah()
	{
		
		$id_anggota					= $this->input->post('id_anggota'); 
		$saldo_pembiayaan 			= $this->convert_numeric($this->input->post('saldo_pembiayaan'));
		$saldo_margin 				= $this->convert_numeric($this->input->post('saldo_margin'));
		$saldo_catab 				= $this->convert_numeric($this->input->post('saldo_catab'));
		$saldo_tabungan_wajib 		= $this->convert_numeric($this->input->post('saldo_tabungan_wajib'));
		$saldo_tabungan_kelompok 	= $this->convert_numeric($this->input->post('saldo_tabungan_kelompok'));
		$saldo_sukarela 			= $this->convert_numeric($this->input->post('saldo_sukarela'));
		$saldo_tabungan_berencana 	= $this->convert_numeric($this->input->post('saldo_tabungan_berencana')); 
		$saldo_individu 			= $this->convert_numeric($this->input->post('saldo_individu')); 
		$bonus_bagihasil 			= $this->convert_numeric($this->input->post('bonus_bagihasil'));
		$saldo_simpanan_pokok 		= $this->convert_numeric($this->input->post('saldo_simpanan_pokok')); 
		$saldo_tabungan_mingguan 	= $this->convert_numeric($this->input->post('saldo_tabungan_mingguan'));
		$saldo_lwk 					= $this->convert_numeric($this->input->post('saldo_lwk'));
		$saldo_smk 					= $this->convert_numeric($this->input->post('saldo_smk')); 
		$tipe_mutasi				= "2"; // mutasi
		$cm_code					= $this->input->post('cm_code'); 
		$cm_code_baru				= $this->input->post('cm_code2'); 
		$branch_code_unit2			= $this->input->post('branch_code_unit2'); 
		$alasan						= $this->input->post('alasan');
		$keterangan 				= $this->input->post('keterangan');
		$tanggal_mutasi				= $this->datepicker_convert(true,$this->input->post('tanggal_mutasi'),'/');
		// $tanggal_mutasi				= date('Y-m-d H:i:s');
		$fa_code					= "0"; //untuk sementara karna tak tahu harus diisi apa
		$created_date				= date('Y-m-d H:i:s');
		$created_by					= $this->session->userdata('user_id');
	    //array input table mfi_cif_mutasi
		$data = array(
						'cif_no'					=> $id_anggota,
						'tipe_mutasi'				=> $tipe_mutasi, 
						'cm_code'					=> $cm_code, 
						'saldo_pembiayaan_pokok' 	=> $saldo_pembiayaan,
						'saldo_pembiayaan_margin' 	=> $saldo_margin,
						'saldo_pembiayaan_catab' 	=> $saldo_catab,
						'saldo_tab_wajib' 			=> $saldo_tabungan_wajib,
						'saldo_tab_kelompok' 		=> $saldo_tabungan_kelompok,
						'saldo_tab_sukarela' 		=> $saldo_sukarela,
						'saldo_tab_berencana' 		=> $saldo_tabungan_berencana,
						'saldo_individu' 			=> $saldo_individu,
						'bonus_bagihasil' 			=> $bonus_bagihasil, 						
						'saldo_simpanan_pokok' 		=> $saldo_simpanan_pokok,
						'saldo_simpanan_wajib' 		=> $saldo_tabungan_mingguan,
						'saldo_smk' 				=> $saldo_smk,
						'saldo_lwk' 				=> $saldo_lwk, 					
						'status' 					=> 0,  
						'cm_code_baru'				=> $cm_code_baru,
						'alasan'					=> $alasan,
						'description'				=> $keterangan,
						'tanggal_mutasi'			=> $tanggal_mutasi,
						'fa_code'					=> $fa_code,
						'created_date'				=> $created_date,
						'created_by'				=> $created_by 

					);
		//array data update cif cm_code
		// $data_baru = array('cm_code'=>$cm_code_baru);
		// $param = array('cif_no'=>$cif_no);

		$data_baru = array(
			//'cm_code' => $cm_code_baru,
			'branch_code' => $branch_code_unit2
		);
		$param = array('cif_no'=>$id_anggota);

		$this->db->trans_begin();
		$this->model_kelompok->proses_anggota_pindah($data); //input ke tabel mfi_cif_mutasi
		$this->model_kelompok->update_cif_cm_code($data_baru,$param); //update status cif
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	public function verifikasi_anggota_mutasi()
	{
		$data['container'] = 'kelompok/verifikasi_anggota_mutasi';
		$data['kecamatan'] = $this->model_kelompok->get_all_mfi_city_kecamatan();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function datatable_verifikasi_mutasi_anggota_pindah()
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

		$rResult 			= $this->model_kelompok->datatable_verifikasi_mutasi_anggota_pindah($sWhere,$sOrder,$sLimit,$branch_id,$branch_code,$trx_date); // query get data to view
		$rResultFilterTotal = $this->model_kelompok->datatable_verifikasi_mutasi_anggota_pindah($sWhere,'','',$branch_id,$branch_code,$trx_date); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_kelompok->datatable_verifikasi_mutasi_anggota_pindah('','','',$branch_id,$branch_code,$trx_date); // get number of all data
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
						<input type="hidden" id="h_cm_code_baru" value="'.$aRow['cm_code_baru'].'">
						<input type="hidden" id="h_rembug_baru" value="'.$aRow['rembug_baru'].'">

						<input type="hidden" id="h_saldo_pembiayaan" value="'.$aRow['saldo_pembiayaan_pokok'].'">
						<input type="hidden" id="h_saldo_margin" value="'.$aRow['saldo_pembiayaan_margin'].'">
						<input type="hidden" id="h_saldo_catab" value="'.$aRow['saldo_pembiayaan_catab'].'">
						<input type="hidden" id="h_saldo_tab_wajib" value="'.$aRow['saldo_tab_wajib'].'">
						<input type="hidden" id="h_saldo_tab_kelompok" value="'.$aRow['saldo_tab_kelompok'].'">
						<input type="hidden" id="h_saldo_tab_sukarela" value="'.$aRow['saldo_tab_sukarela'].'"> 
						<input type="hidden" id="h_saldo_tab_berencana" value="'.$aRow['saldo_tab_berencana'].'">
						<input type="hidden" id="h_saldo_individu" value="'.$aRow['saldo_individu'].'">  
						<input type="hidden" id="h_bonus_bagihasil" value="'.$aRow['bonus_bagihasil'].'">  
						<input type="hidden" id="h_saldo_simpanan_pokok" value="'.$aRow['saldo_simpanan_pokok'].'">  
						<input type="hidden" id="h_saldo_simpanan_wajib" value="'.$aRow['saldo_simpanan_wajib'].'"> 
						<input type="hidden" id="h_saldo_smk" value="'.$aRow['saldo_smk'].'"> 
						<input type="hidden" id="h_saldo_lwk" value="'.$aRow['saldo_lwk'].'"> 

					  </div>';
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function verifikasi_approve_mutasi_anggota_pindah()
	{
		$cif_mutasi_id = $this->input->post('cif_mutasi_id');
		$cif_no = $this->input->post('cif_no');
		$var_cm_code_baru = $this->input->post('var_cm_code_baru');
		$data=array('status'=>1
					,'status_mutasi'=>1
					,'verify_by'=>$this->session->userdata('user_id')
					,'verify_date'=>date("Y-m-d")
					);
		$param=array('cif_mutasi_id'=>$cif_mutasi_id);

		//array data update cif cm_code
		$data_baru = array('cm_code'=>$var_cm_code_baru);
		$param_baru = array('cif_no'=>$cif_no);

		$this->db->trans_begin();
		$this->model_kelompok->update_mfi_cif_mutasi($data,$param); //update status di table mfi_cif_mutasi
		$this->model_kelompok->update_cif_cm_code($data_baru,$param_baru); //update status cif
		if($this->db->trans_status()==true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	public function verifikasi_reject_mutasi_anggota_pindah()
	{
		$cif_mutasi_id = $this->input->post('cif_mutasi_id');
		$cif_no = $this->input->post('cif_no');

		$param=array('cif_mutasi_id'=>$cif_mutasi_id);

		$this->db->trans_begin();
		$this->model_kelompok->delete_mutasi_anggota($param);
		if($this->db->trans_status()==true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END ANGGOTA PINDAH
	/****************************************************************************************/

	function ajax_get_product_savingplan()
	{
		$cif_no=$this->input->post('cif_no');
		$data=$this->model_kelompok->get_product_savingplan($cif_no);
		echo json_encode($data);
	}

	public function get_unit_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_kelompok->get_unit_by_keyword($keyword,$branch_code);

		echo json_encode($data);
	}
}