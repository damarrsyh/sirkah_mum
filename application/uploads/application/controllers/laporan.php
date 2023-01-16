<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */
	 
	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_laporan');
		$this->load->model('model_cif');
		$this->load->model('model_laporan_to_pdf');
		$this->load->model('model_kelompok');
		$this->load->library('html2pdf');
		$this->load->library('phpexcel');
	}

	public function index()
	{
		$data['container'] = 'laporan';
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// BEGIN SALDO KAS PERUGAS
	/****************************************************************************************/

	public function saldo_kas_petugas()
	{
		$data['container'] = 'laporan/saldo_kas_petugas';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function datatable_saldo_kas_petugas()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','account_cash_code','fa_name', 'saldoawal', 'mutasi_debet','mutasi_credit','');
		$cabang  = @$_GET['cabang'];
		$tanggal = @$_GET['tanggal'];
		$tanggal = str_replace('/','',$tanggal);
		$tanggal = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
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
		
		$rResult 			= $this->model_laporan->datatable_saldo_kas_petugas($sOrder,$sLimit,$cabang,$tanggal); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_saldo_kas_petugas('','',$cabang,$tanggal); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_laporan->datatable_saldo_kas_petugas('','',$cabang,$tanggal); // get number of all data
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
		$no=1;
		foreach($rResult as $aRow)
		{
			$row = array();
			$row[] = $no++;
			$row[] = $aRow['account_cash_code'];
			$row[] = $aRow['fa_name'];
			$row[] = '<div align="right">'.number_format($aRow['saldoawal'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['mutasi_debet'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['mutasi_credit'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format(($aRow['saldoawal']+$aRow['mutasi_debet']-$aRow['mutasi_credit']),0,',','.').'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function get_saldo_awal_dan_akhir_kas_petugas()
	{
		$cabang=$this->input->post('cabang');
		$tanggal=$this->datepicker_convert(true,$this->input->post('tanggal'),'/');
		$saldoawal=$this->model_laporan->get_totalsaldoawal_kas_petugas($cabang,$tanggal);
		$saldoakhir=$this->model_laporan->get_totalsaldoakhir_kas_petugas($cabang,$tanggal);
		$total_saldo_awal=$saldoawal['totalsaldoawal'];
		$total_saldo_akhir=$saldoakhir['totalsaldoakhir'];
		$return=array('total_saldo_awal'=>$total_saldo_awal,'total_saldo_akhir'=>$total_saldo_akhir);
		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END SALDO KAS PERUGAS
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN TRANSAKSI KAS PERUGAS
	/****************************************************************************************/

	public function transaksi_kas_petugas()
	{
		$data['container'] = 'laporan/transaksi_kas_petugas';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}


	public function search_code_cash_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$type = $this->input->post('account_type');
		$data = $this->model_laporan->search_code_cash_by_keyword($keyword,$type);

		echo json_encode($data);
	}

	public function datatable_transaksi_kas_petugas()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '', 'trx_date', 'trx_type', 'trx_debet','trx_credit','saldoawal');
		$tanggal  = @$_GET['tanggal'];
		$tanggal = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
		$tanggal2 = @$_GET['tanggal2'];
		$tanggal2 = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
		$account_cash_code = @$_GET['account_cash_code'];
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
		
		$rResult 			= $this->model_laporan->datatable_transaksi_kas_petugas_setup($sOrder,$sLimit,$tanggal,$tanggal2,$account_cash_code); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_transaksi_kas_petugas_setup('','',$tanggal,$tanggal2,$account_cash_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_laporan->datatable_transaksi_kas_petugas_setup('','',$tanggal,$tanggal2,$account_cash_code); // get number of all data
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
		$no=1;
		$saldo = (isset($rResult[0]['saldoawal']))?$rResult[0]['saldoawal']:0;
		foreach($rResult as $aRow)
		{
			$row = array();
			if($aRow['flag_debet_credit']=='D'){
				$saldo += $aRow['trx_debet'];
			}
			if($aRow['flag_debet_credit']=='C'){
				$saldo -= $aRow['trx_credit'];
			}
			$row[] = $no++;
			$row[] = '<div align="center">'.$aRow['trx_date'].'</div>';
			$row[] = '<div align="center">'.$aRow['description'].'</div>';
			$row[] = '<div align="right">'.number_format($aRow['trx_debet'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['trx_credit'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($saldo,0,',','.').'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	/****************************************************************************************/	
	// END TRANSAKSI KAS PERUGAS
	/****************************************************************************************/

	/*GL ACCOUNT HISTORY / LIST JURNAL UMUM*/

	public function list_jurnal_umum_gl()
	{
		$data['container'] = 'laporan/list_jurnal_umum_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function get_gl_account_history()
	{
		$branch_code = $this->input->post('branch_code');
		$account_code = $this->input->post('account_code');
		$from_date = $this->input->post('from_date');
		$from_date = str_replace('/', '', $from_date);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = $this->input->post('thru_date');
		$thru_date = str_replace('/', '', $thru_date);
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);

		$datas = $this->model_laporan->get_gl_account_history($branch_code,$account_code,$from_date,$thru_date);
		$saldo = $this->model_laporan->fn_get_saldo_gl_account2($account_code,$from_date,$branch_code);

		$saldo_akhir = $saldo['saldo_awal'];
		$total_debit = 0;
		$total_credit = 0;
		$i = 0;
		for ( $j = 0 ; $j < count($datas)+1 ; $j++ )
		{
			if($j==0)
			{
				$data['data'][$j]['nomor'] = '';
				$data['data'][$j]['trx_date'] = '';
				$data['data'][$j]['description'] = 'Saldo Awal';
				$data['data'][$j]['debit'] = '';
				$data['data'][$j]['credit'] = '';
				$data['data'][$j]['saldo_akhir'] = $saldo_akhir;
				$data['data'][$j]['trx_gl_id'] = '';
			}
			else
			{
				if($datas[$i]['flag_debit_credit']=="C"){
					if($datas[$i]['transaction_flag_default']=='C'){
						$saldo_akhir += $datas[$i]['amount'];
					}else{
						$saldo_akhir -= $datas[$i]['amount'];
					}
				}
				if($datas[$i]['flag_debit_credit']=="D"){
					if($datas[$i]['transaction_flag_default']=='D'){
						$saldo_akhir += $datas[$i]['amount'];
					}else{
						$saldo_akhir -= $datas[$i]['amount'];
					}	
				}
				$data['data'][$j]['nomor'] = $i+1;
				$data['data'][$j]['trx_date'] = date('d-m-Y',strtotime($datas[$i]['voucher_date']));
				$data['data'][$j]['description'] = $datas[$i]['description'];
				$data['data'][$j]['debit'] = $datas[$i]['debit'];
				$data['data'][$j]['credit'] = $datas[$i]['credit'];
				$data['data'][$j]['saldo_akhir'] = $saldo_akhir;
				$data['data'][$j]['trx_gl_id'] = $datas[$i]['trx_gl_id'];
				
				$total_debit  += $datas[$i]['debit'];
				$total_credit += $datas[$i]['credit'];

				$i++;
			}
		}
		$data['total_debit'] = $total_debit;
		$data['total_credit'] = $total_credit;

		echo json_encode($data);
	}

	/*GL REKAP TRANSAKSI*/

	public function rekap_trx_gl()
	{
		$data['container'] = 'laporan/rekap_trx_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function get_gl_rekap_transaksi()
	{
		$branch_code = $this->input->post('branch_code');
		$from_date = $this->input->post('from_date');
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = $this->input->post('thru_date');
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);

		$datas = $this->model_laporan->get_gl_rekap_transaksi($branch_code,$from_date,$thru_date);

		$saldo_akhir = 0;
		$total_debit = 0;
		$total_credit = 0;
		
		for ( $i = 0 ; $i < count($datas) ; $i++ )
		{
			$data['data'][$i]['nomor'] = $i+1;
			$data['data'][$i]['saldo_awal'] = 0;
			$data['data'][$i]['account'] = $datas[$i]['account_code'].' - '.$datas[$i]['account_name'];
			$data['data'][$i]['debit'] = $datas[$i]['debit'];
			$data['data'][$i]['credit'] = $datas[$i]['credit'];
			$data['data'][$i]['saldo_akhir'] = 0;
			
			$total_debit  += $datas[$i]['debit'];
			$total_credit += $datas[$i]['credit'];

		}
		$data['total_debit'] = $total_debit;
		$data['total_credit'] = $total_credit;

		echo json_encode($data);
	}

	/* NERACA SALDO GL */

	public function neraca_saldo_gl()
	{
		$data['container'] = 'laporan/neraca_saldo_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function get_neraca_saldo_gl()
	{
		$branch_code = $this->input->post('branch_code');
		$periode1 = $this->datepicker_convert(true,$this->input->post('periode1'),'/');
		$periode2 = $this->datepicker_convert(true,$this->input->post('periode2'),'/');

		$datas = $this->model_laporan->get_neraca_saldo_gl2($branch_code,$periode1,$periode2);

		$saldo_akhir = 0;
		$total_debit = 0;
		$total_credit = 0;
		$ii=0;
		$group_name='';
		for ( $i = 0 ; $i < count($datas) ; $i++ )
		{
			$group = $this->model_laporan->get_account_group_by_code($datas[$i]['account_group_code']);
			if(count($group)>0){
				if($group_name!=$group['group_name']){
					$group_name=$group['group_name'];
					$data['data'][$ii]['nomor'] = '';
					$data['data'][$ii]['saldo_awal'] = '';
					$data['data'][$ii]['account'] = $group_name;
					$data['data'][$ii]['debit'] = '';
					$data['data'][$ii]['credit'] = '';
					$data['data'][$ii]['saldo_akhir'] = '';
					$ii++;
				}
			}else{
				$group_name='';
			}

			$data['data'][$ii]['nomor'] = $i+1;
			$data['data'][$ii]['saldo_awal'] = $datas[$i]['saldo_awal'];
			$data['data'][$ii]['account'] = $datas[$i]['account_code'].' - '.$datas[$i]['account_name'];
			$data['data'][$ii]['debit'] = $datas[$i]['debit'];
			$data['data'][$ii]['credit'] = $datas[$i]['credit'];
			$data['data'][$ii]['saldo_akhir'] = $this->coalesce($datas[$i]['saldo_awal']+$datas[$i]['debit']-$datas[$i]['credit'],0);
			
			$total_debit  += $datas[$i]['debit'];
			$total_credit += $datas[$i]['credit'];
			if(count($group)>0){
				$group_name=$group['group_name'];
			}
			$ii++;
		}
		$data['total_debit'] = $total_debit;
		$data['total_credit'] = $total_credit;

		echo json_encode($data);
	}

	function coalesce($value,$default_value)
	{
		if($value==''){
			return $default_value;
		}else{
			return $value;
		}
	}

	/* END NERACA SALDO GL */
	
	///* REKAP MUTASI GL *///

	public function rekap_mutasi_gl()	
	{	
		$data['container'] = 'laporan/rekap_mutasi_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function get_rekap_mutasi_gl()	
	{   
	    //$branch_code = $this->input->post('branch_code');
		//$periode_bulan = $this->input->post('periode_bulan');
		//$periode_tahun = $this->input->post('periode_tahun');

		//$datas = $this->model_laporan->get_neraca_saldo_gl($branch_code,$periode_bulan,$periode_tahun);	
	
        $branch_code = $this->input->post('branch_code');
		
		$from_date = $this->input->post('from_date');
		$from_date = str_replace('/', '', $from_date);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = $this->input->post('thru_date');
		$thru_date = str_replace('/', '', $thru_date);
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);
	    
		$datas = $this->model_laporan->get_rekap_mutasi_gl($branch_code,$from_date,$thru_date);	
		
		$total_debit=0;
		$total_credit=0;
		$ii=0;
		$group_name='';
		$data['data'][$ii]['nomor'] = '&nbsp;';			
		$data['data'][$ii]['account'] = '&nbsp;';
		// $data['data'][$ii]['saldo_awal'] = 0;
		$data['data'][$ii]['debit'] = 0;
		$data['data'][$ii]['credit'] = 0;
		// $data['data'][$ii]['saldo_akhir'] = 0;
		
		for ( $i = 0 ; $i < count($datas) ; $i++ )
		{	
			$data['data'][$ii]['nomor'] = $i+1;			
			$data['data'][$ii]['account'] = $datas[$i]['account_code'].' - '.$datas[$i]['account_name'];
			// $data['data'][$ii]['saldo_awal'] = $datas[$i]['saldo_awal'];
			$data['data'][$ii]['debit'] = $datas[$i]['debit'];
			$data['data'][$ii]['credit'] = $datas[$i]['credit'];
			// $data['data'][$ii]['saldo_akhir'] = $this->coalesce($datas[$i]['saldo_awal']+$datas[$i]['debit']-$datas[$i]['credit'],0);

			$total_debit+=$datas[$i]['debit'];
			$total_credit+=$datas[$i]['credit'];

			$ii++;
		}
		
		$data['total_debit'] = $total_debit;
		$data['total_credit'] = $total_credit;

		echo json_encode($data);
	}

	public function cetak_rekap_mutasi_gl_txt()	
	{   	
		$from_date = $this->uri->segment(3);
		$thru_date = $this->uri->segment(4);
        $branch_code = $this->uri->segment(5);
		
		$from_date = str_replace('/', '', $from_date);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = str_replace('/', '', $thru_date);
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);	

		
		$data['datas'] = $this->model_laporan->get_rekap_mutasi_gl($branch_code,$from_date,$thru_date);	

		$this->load->view('laporan/cetak_rekap_mutasi_gl_txt',$data);
	}
	///* END REKAP MUTASI GL *///
	
	
	/****************************************************************************************/	
	// BEGIN REPORT LABA RUGI
	/****************************************************************************************/

	public function laba_rugi_gl()
	{
		$data['container'] = 'laporan/laba_rugi_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	public function laba_rugi_gl_v2()
	{
		$data['container'] = 'laporan/laba_rugi_gl_v2';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REPORT LABA RUGI
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN NERACA_GL
	/****************************************************************************************/
	public function neraca_gl()
	{
		$data['container'] = 'laporan/neraca_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	public function neraca_gl_v2()
	{
		$data['container'] = 'laporan/neraca_gl_v2';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['periodes'] = $this->model_laporan->get_periode_trx(0);
		$data['periode_run'][0] = $this->model_laporan->get_periode_trx(1);
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END LAPORAN NERACA_GL
	/****************************************************************************************/




	/****************************************************************************************/	
	// BEGIN LIST JATUH TEMPO
	/****************************************************************************************/

	public function list_jatuh_tempo()
	{
		$data['container'] = 'laporan/list_jatuh_tempo';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST JATUH TEMPO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REPORT LABA RUGI PUBLISH
	/****************************************************************************************/

	public function laba_rugi_publish()
	{
		$data['container'] = 'laporan/laba_rugi_publish';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REPORT LABA RUGI PUBLISH
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REPORT LIST PENGHAPUSAN PEMBIAYAAN
	/****************************************************************************************/

	public function list_droping_pembiayaan()
	{
		$data['container'] = 'laporan/list_droping_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['product'] = $this->model_laporan->get_product_financing();
		$data['peruntukan'] = $this->model_laporan->show_peruntukan('peruntukan');
		$data['sektor'] = $this->model_laporan->show_peruntukan('sektor_ekonomi');
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REPORT LIST PENGHAPUSAN PEMBIAYAAN
	/****************************************************************************************/

	

	/****************************************************************************************/	
	// BEGIN LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/

	function list_pelunasan_pembiayaan(){
		$data['container'] = 'laporan/list_pelunasan_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/
	

	/****************************************************************************************/	
	// BEGIN REPORT LIST OUTSTANDING PEMBIAYAAN
	/****************************************************************************************/

	function list_outstanding_pembiayaan(){
		$data['container'] = 'laporan/list_outstanding_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['product'] = $this->model_laporan->get_product_financing();
		$data['peruntukan'] = $this->model_laporan->show_peruntukan('peruntukan');
		$data['sektor'] = $this->model_laporan->show_peruntukan('sektor_ekonomi');
		$this->load->view('core',$data);
	}
	
		
	function jqgrid_list_outstanding_pembiayaan(){
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'account_financing_no';
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$tanggal = date('Y-m-d');
		$cabang = $_REQUEST['branch_code'];
		$petugas = $_REQUEST['fa_code'];
		$majelis = $_REQUEST['cm_code'];
		$pembiayaan = $_REQUEST['financing_type'];
		$product_code = $_REQUEST['product_code'];
		$peruntukan = $_REQUEST['peruntukan'];
		$sektor = $_REQUEST['sektor'];
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;
		
		if($totalrows){
			$limit_rows = $totalrows;
		}

        if($pembiayaan == 1){
            $majelis = '00000';
            $petugas = '00000';
        }

		$count = $this->model_laporan_to_pdf->jqgrid_count_outstanding_pembiayaan($cabang,$pembiayaan,$majelis,$petugas,$tanggal,$product_code,$peruntukan,$sektor);

		if ($count > 0){
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_outstanding_pembiayaan($sidx,$sort,$limit_rows,$start,$cabang,$pembiayaan,$majelis,$petugas,$tanggal,$product_code,$peruntukan,$sektor);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row){
			$rekening = $row['account_financing_no'];
			$nama = $row['nama'];
			$ktp = $row['no_ktp'];
			$rembug = $row['cm_name'];
			$droping = $row['droping_date'];
			$pokok = $row['pokok'];
			$margin = $row['margin'];
			$bayar = $row['freq_bayar_pokok'];
			$saldo = $row['freq_bayar_saldo'];
			$saldo_pokok = $row['saldo_pokok'];
			$saldo_margin = $row['saldo_margin'];
			$produk = $row['nick_name'];
			$sektors = $row['sektor'];
			$peruntukans = $row['peruntukan'];

			if($bayar == NULL){
				$bayar = '0';
			}

			$responce['rows'][$i]['account_financing_no'] = $rekening;
		    $responce['rows'][$i]['cell'] = array($rekening,$nama,$ktp,$rembug,$droping,$pokok,$margin,$bayar,$saldo,$saldo_pokok,$saldo_margin,$produk,$sektors,$peruntukans);

		    $i++;
		}

		echo json_encode($responce);
	}
	/****************************************************************************************/	
	// END REPORT LIST OUTSTANDING PEMBIAYAAN
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// BEGIN REPORT LIST PERMI ANGGOTA 
	/****************************************************************************************/

	public function list_premi_anggota()
	{
		$data['container'] = 'laporan/list_premi_anggota';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['product'] = $this->model_laporan->get_product_financing();
		$this->load->view('core',$data);
	}
	
	public function jqgrid_list_premi_anggota()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'account_financing_no';//1
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$branch_code = isset($_REQUEST['branch_code'])?$_REQUEST['branch_code']:'';
		$cm_code = isset($_REQUEST['cm_code'])?$_REQUEST['cm_code']:'';
		$financing_type = isset($_REQUEST['financing_type'])?$_REQUEST['financing_type']:'';
		$product_code = isset($_REQUEST['product_code'])?$_REQUEST['product_code']:'';
		
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		if($financing_type == 1){
			$cm_code = '00000';
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_premi_anggota($branch_code,$cm_code,$product_code,$financing_type);

		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_premi_anggota($sidx,$sort,$limit_rows,$start,$branch_code,$cm_code,$product_code,$financing_type);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
	        $responce['rows'][$i]['account_financing_no']=$row['account_financing_no'];
		    $responce['rows'][$i]['cell']=array(
			     $row['account_financing_no']
				,$row['nama']
				,$row['cm_name']
				,$row['usia']
				,$row['p_nama']
				,$row['p_usia']
				,$row['pokok']
				,$row['droping_date']
				,$row['saldo_pokok']
				,$row['biaya_asuransi_jiwa']
				
		    );
		    $i++;
		}

		echo json_encode($responce);
	}

	/****************************************************************************************/	
	// END REPORT LIST PREMI ANGGOTA 
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST REGISTRASI PEMBIAYAAN
	/****************************************************************************************/

	public function list_registrasi_pembiayaan()
	{
		$data['container'] = 'laporan/list_registrasi_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['product'] = $this->model_laporan->get_product_financing();
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST REGISTRASI PEMBIAYAAN
	/****************************************************************************************/

	/* LAPORAN PAR atau AGING REPORT */
	public function laporan_par()
	{
		$data['container'] = 'anggota/aging_report';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['param_par'] = $this->model_laporan->get_param_par();
		$this->load->view('core',$data);
	}

	function get_tanggal_par()
	{
		$branch_code=$this->input->post('branch_code');
		$pars=$this->model_laporan->get_par($branch_code);
		echo json_encode($pars);
	}

	// BEGIN KEUANGAN BULANAN
	function keuangan_bulanan(){
		$data['container'] = 'laporan/keuangan_bulanan';
		$this->load->view('core',$data);
	}

	function get_tanggal_closing(){
		$branch_code = $this->input->post('branch_code');
		$close = $this->model_laporan->get_tanggal_closing($branch_code);
		echo json_encode($close);
	}

	// BEGIN NERACA LABA RUGI TEMP
	function neraca_lr_temp(){
		$data['container'] = 'laporan/neraca_lr_temp';
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// BEGIN KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/

	public function kartu_pengawasan_angsuran()
	{
		$data['container'] = 'laporan/kartu_pengawasan_angsuran';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	public function get_kartu_pengawasan_angsuran_by_account_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_laporan->get_kartu_pengawasan_angsuran_by_account_no($account_financing_no);
		if (count($data)>0) {
			$data['droping_date'] = date("d-m-Y", strtotime($data['droping_date']));
			$data['tanggal_jtempo'] = date("d-m-Y", strtotime($data['tanggal_jtempo']));
		}

		echo json_encode($data);
	}

	public function get_trx_pembiayaan_by_cif_no()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_laporan->get_trx_pembiayaan_by_cif_no($cif_no);

		echo json_encode($data);
	}


	/** 
	* UPDATED 2014-08-27 at NGANJUK
	* @author : sayyid
	*/
	public function get_row_pembiayaan_by_account_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$cif_no = $this->input->post('cif_no');
		$cif_type = $this->input->post('cif_type');
		$financing_type = $this->input->post('financing_type');
		$datas = $this->model_laporan->get_row_pembiayaan_by_account_no($account_financing_no);

		$html = '';
		$no=1;

		foreach($datas as $data)
		{
			$jumlah_angsur=$data['jumlah_angsuran'];
			$pokok=$data['pokok'];

			for ($i=0;$i<$data['jangka_waktu'];$i++) { //loop

				if($i==0){
					 $tgl_angsur = $data['tanggal_mulai_angsur'];
				}else{
					if($data['periode_jangka_waktu']==0){
						$tgl_angsur = date("Y-m-d",strtotime($tgl_angsur." + 1 day"));
					}else if($data['periode_jangka_waktu']==1){
						$tgl_angsur = date("Y-m-d",strtotime($tgl_angsur." + 7 day"));
					}else if($data['periode_jangka_waktu']==2){
						$tgl_angsur = date("Y-m-d",strtotime($tgl_angsur." + 1 month"));
					}else if($data['periode_jangka_waktu']==3){
						$tgl_angsur = $data['tgl_jtempo'];
					}
				}
				$pokok-=$data['angsuran_pokok'];
				$historycm=$this->model_laporan->get_history_cm_trx_date_by_account_financing_no($account_financing_no,$no,$financing_type,$tgl_angsur);

				$tgl_bayar=(isset($historycm['trx_date']))?(date('d-m-Y',strtotime($historycm['trx_date']))):'';
				$validasi = (isset($historycm['validasi']))?($historycm['validasi']):'';
				$html .= '<tr>
				              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.date("d-m-Y", strtotime($tgl_angsur)).'</td>
				              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$tgl_bayar.'</td>
				              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$no.'</td>
				              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($jumlah_angsur,0,',','.').'</td>
				              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($pokok,0,',','.').'</td>
				              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$validasi.'</td>
				          </tr>';
				$no++;
			}
		}

		echo $html;
	}
	/****************************************************************************************/	
	// END KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/

	function proyeksi_realisasi_angsuran(){
		$data['container'] = 'laporan/proyeksi_realisasi_angsuran';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['produk'] = $this->model_laporan->get_produk_pembiayaan_kelompok();
		$this->load->view('core',$data);
	}


	/****************************************************************************************/	
	// END KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP JATUH TEMPO
	/****************************************************************************************/

	public function rekap_jatuh_tempo()
	{
		$data['container'] = 'laporan/rekap_jatuh_tempo';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END REKAP JATUH TEMPO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN OUTSTANDING BERDASARKAN DESA
	/****************************************************************************************/

	public function rekap_outstanding_piutang()
	{
		$data['container'] = 'laporan/rekap_outstanding_piutang';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	
	public function rekap_sebaran_anggota()
	{
		$data['container'] = 'laporan/rekap_sebaran_anggota';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function get_desa_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_laporan->get_desa_by_keyword($keyword);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// END LAPORAN OUTSTANDING BERDASARKAN DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN REKAP PENGAJUAN
	/****************************************************************************************/

	public function rekap_pengajuan()
	{
		$data['container'] = 'laporan/rekap_pengajuan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END LAPORAN REKAP PENGAJUAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN PENCARIAN PEMBIAYAAN
	/****************************************************************************************/

	public function list_pencairan_pembiayaan()
	{
		$data['container'] = 'laporan/list_pencairan_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END LAPORAN PENCARIAN PEMBIAYAAN
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// BEGIN LAPORAN REKAP PENCARIAN PEMBIAYAAN
	public function rekap_pencairan_pembiayaan()
	{
		$data['container'] = 'laporan/rekap_pencairan_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kecamatan'] = $this->model_laporan->get_kecamatan();
		$this->load->view('core',$data);
	}
	// END LAPORAN REKAP PENCARIAN PEMBIAYAAN
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// BEGIN LAPORAN REKAP ANGGOTA KELUAR 
	public function rekap_anggota_keluar()
	{
		$data['container'] = 'laporan/rekap_anggota_keluar';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kecamatan'] = $this->model_laporan->get_kecamatan();
		$this->load->view('core',$data);
	}
	// END LAPORAN REKAP PENCARIAN PEMBIAYAAN
	/****************************************************************************************/
	
	
	/****************************************************************************************/	
	// BEGIN LAPORAN REKAP CASHFLOW_TRANSAKSI_REMBUG
	public function rekap_cashflow_transaksi_rembug()
	{
		$data['container'] = 'laporan/rekap_cashflow_transaksi_rembug';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['trx_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}
	// END LAPORAN REKAP CASHFLOW_TRANSAKSI_REMBUG
	/****************************************************************************************/
	
	

	/****************************************************************************************/	
	// BEGIN LIST TRANSAKSI REMBUG
	/****************************************************************************************/

	public function list_transaksi_rembug()
	{
		$data['container'] = 'laporan/list_transaksi_rembug';
		$data['title'] = 'List Transaksi rembug';
		$data['trx_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data); 
	}

	/****************************************************************************************/	
	// END LIST TRANSAKSI REMBUG
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// BEGIN CASH FLOW TRANSAKSI REMBUG
	/****************************************************************************************/

	public function cashflow_transaksi_rembug()
	{
		$data['container'] = 'laporan/cashflow_transaksi_rembug';
		$data['title'] = 'Cash Flow Transaksi Rembug';
		$data['trx_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data); 
	}

	/****************************************************************************************/	
	// END LIST TRANSAKSI REMBUG
	/****************************************************************************************/
	
	

	/****************************************************************************************/	
	// BEGIN LIST SALDO ANGGOTA
	/****************************************************************************************/

	public function list_saldo_tabungan()
	{
		$data['container'] = 'laporan/list_saldo_tabungan';
		$data['title'] = 'List Saldo Tabungan';
		$data['trx_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data); 
	}

	function list_anggota_keluar(){
		$data['container'] = 'laporan/list_anggota_keluar';
		$data['title'] = 'List Anggota Keluar';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['alasan'] = $this->model_kelompok->get_keterangan_keluar();
		$this->load->view('core',$data); 
	}
	
	function list_anggota_masuk(){
		$data['container'] = 'laporan/list_anggota_masuk';
		$data['title'] = 'List Anggota Masuk';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data); 
	}
	/****************************************************************************************/	
	// END LIST SALDO TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/

	public function list_pengajuan_pembiayaan()
	{
		$data['container'] = 'laporan/list_pengajuan_pembiayaan';		
		$data['petugas'] 	= $this->model_laporan->get_petugas();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST SALDO TABUNGAN
	/****************************************************************************************/

	public function list_pembukaan_tabungan()
	{
		$data['container'] 	= 'laporan/list_pembukaan_tabungan';
		$data['produk'] 	= $this->model_laporan->get_all_produk_tabungan();
		$this->load->view('core',$data);
	}

	function rekap_saldo_tabungan(){
		$data['container'] 	= 'laporan/rekap_saldo_tabungan';
		$data['produk'] 	= $this->model_laporan->get_all_produk_tabungan();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END LIST SALDO TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST BLOKIR TABUNGAN
	/****************************************************************************************/

	public function list_blokir_tabungan()
	{
		$data['container'] 		= 'laporan/list_blokir_tabungan';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST BLOKIR TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST REKENING TABUNGAN
	/****************************************************************************************/

	public function list_rekening_tabungan()
	{
		$data['container'] 		= 'laporan/list_rekening_tabungan';
		$data['produk'] 		= $this->model_laporan->get_all_produk_tabungan_individu();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST REKENING TABUNGAN
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// BEGIN STATEMENT REKENING TABUNGAN SUKARELA 
	/****************************************************************************************/

	public function statement_tabungan_sukarela()
	{
		$data['container'] 		= 'laporan/statement_tabungan_sukarela';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END STATEMENT REKENING TABUNGAN SUKARELA 
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST PEMBUKAAN TABUNGAN
	/****************************************************************************************/

	public function list_buka_tabungan()
	{
		$data['container'] 		= 'laporan/list_buka_tabungan';
		$data['produk'] 		= $this->model_laporan->get_all_produk_tabungan();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST PEMBUKAAN TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST PEMBUKAAN TABUNGAN JATUH TEMPO
	/****************************************************************************************/

	public function list_buka_tabungan_jtempo()
	{
		$data['container'] 		= 'laporan/list_buka_tabungan_jtempo';
		$data['produk'] 		= $this->model_laporan->get_all_produk_tabungan();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST PEMBUKAAN TABUNGAN JATUH TEMPO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN CETAK TRANSAKSI BUKU TABUNGAN
	/****************************************************************************************/

	public function cetak_trans_buku()
	{
		$data['container'] 		= 'laporan/cetak_trans_buku';
		$data['produk'] 		= $this->model_laporan->get_all_produk_tabungan();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	public function setup_margin()
	{
		$data['container'] 	= 'laporan/setup_margin';
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END CETAK TRANSAKSI BUKU TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN DEPOSITO
	/****************************************************************************************/

	public function list_pembukaan_deposito()
	{
		$data['container'] 		= 'laporan/list_pembukaan_deposito';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function list_saldo_deposito()
	{
		$data['container'] 	= 'laporan/list_saldo_deposito';
		$data['produk'] 	= $this->model_laporan->get_all_produk_deposito();
		$this->load->view('core',$data);
	}

	public function list_pencairan_deposito()
	{
		$data['container'] 		= 'laporan/list_pencairan_deposito';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function list_rekap_pembukaan()
	{
		$data['container'] 		= 'laporan/list_rekap_pembukaan';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function rekap_outstanding()
	{
		$data['container'] 		= 'laporan/rekap_outstanding';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function rekap_bagi_hasil()
	{
		$data['container'] 		= 'laporan/rekap_bagi_hasil';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function rekap_history()
	{
		$data['container'] 		= 'laporan/rekap_history';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LAPORAN DEPOSITO
	/****************************************************************************************/


	//CETAK TRANSAKSI BUKU TABUNGAN

	public function datatable_rekening_buku_tabungan_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','trx_date','nama','account_saving_no','flag_debit_credit','saldo_riil','username','');
		$no_rek   = @$_GET['no_rek'];
		$tanggal  = @$_GET['tanggal'];
		$tanggal2 = @$_GET['tanggal2'];
        $date1    = $this->datepicker_convert(true,$tanggal);
        $date2    = $this->datepicker_convert(true,$tanggal2); 
				
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
			if($no_rek!="" or ($tanggal!="" && $tanggal2!="") )
			{
				$sWhere = 'WHERE ';
				if($no_rek!=""){
					$sWhere .= " mfi_trx_account_saving.account_saving_no = '".$no_rek."' ";
				}
				if($date1!="" && $date2!=""){
					if($no_rek!="")
					{
						$sWhere .= " AND ";
					}
					$sWhere .= " mfi_trx_account_saving.trx_date BETWEEN '".$date1."' AND '".$date2."' ";
				}
				// $sWhere = " WHERE mfi_trx_account_saving.account_saving_no = '".$no_rek."' AND mfi_trx_account_saving.trx_date BETWEEN '".$date1."' AND '".$date2."' ";
			}
		}else{
			if($no_rek!=""){
				$sWhere .= " AND mfi_trx_account_saving.account_saving_no = '".$no_rek."' ";
			}
			if($date1!="" && $date2!=""){
				$sWhere .= "  AND mfi_trx_account_saving.trx_date BETWEEN '".$date1."' AND '".$date2."' ";
			}
			// $sWhere .= " AND mfi_trx_account_saving.account_saving_no = '".$no_rek."' AND mfi_trx_account_saving.trx_date BETWEEN '".$tanggal."' AND '".$tanggal2."' ";
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

		$rResult 			= $this->model_laporan->datatable_rekening_buku_tabungan_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_rekening_buku_tabungan_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_laporan->datatable_rekening_buku_tabungan_setup(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['trx_account_saving_id'].'" id="checkbox[]" name="checkbox[]" class="checkboxes" >';
			$row[] = $aRow['trx_date'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['account_saving_no'];
			$row[] = $aRow['flag_debit_credit'];
			$row[] = $aRow['saldo_riil'];
			$row[] = $this->session->userdata('username');

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

    public function export_cetak_trans_buku()
    {
    	// echo "<pre>";
    	// print_r($_POST);
    	// die();
		$trx_account_saving_id  = $this->input->post('checkbox');
		$institution_name		= $this->session->userdata('institution_name');
		
		// print_r($this->_trx_account_saving_id);
		// die();
		if($trx_account_saving_id==""){
			echo "<script>alert('Please select some row to print !');window.close();</script>";
		}else{

        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['cetak_buku'] = array();
		for ( $i = 0 ; $i < count($trx_account_saving_id) ; $i++ )
		{
			$data['cetak_buku'][] = $this->model_laporan->export_cetak_trans_buku($trx_account_saving_id[$i]);
		}
		$data['margin'] = $this->model_laporan->get_margin($institution_name);
       
        $this->load->view('laporan/export_cetak_trans_buku',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('BUKU-TRANSAKSI-REK-TABUNGAN.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    	}
    }
    /****************************************************************************/
    //END LAPORAN LIST PEMBUKAAN TABUNGAN
    /****************************************************************************/

	//END CETAK TRANSAKSI BUKU TABUNGAN

	/****************************************************************************************/	
	// BEGIN REPORT TRANSAKSI TABUNGAN
	/****************************************************************************************/

	public function transaksi_tabungan()
	{
		$data['container'] 		= 'laporan/transaksi_tabungan';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		//$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REPORT TRANSAKSI TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REPORT TRANSAKSI AKUN
	/****************************************************************************************/

	public function transaksi_akun()
	{
		$data['container'] 		= 'laporan/transaksi_akun';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		//$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REPORT TRANSAKSI AKUN
	/****************************************************************************************/

	public function get_detail_transaction()
	{
		$trx_gl_id = $this->input->post('trx_gl_id');
		$data = $this->model_laporan->get_detail_transaction($trx_gl_id);

		echo json_encode($data);
	}

	/* laporan cetak voucher */

	function cetak_voucher()
	{
		$data['container'] = 'laporan/cetak_voucher';
		$this->load->view('core',$data);
	}

	function datatable_cetak_voucher()
	{
		$from_date = $this->datepicker_convert(true,$this->input->get('from_date'),'/');
		$to_date = $this->datepicker_convert(true,$this->input->get('to_date'),'/');
		$voucher_ref = $this->input->get('voucher_ref');
		$voucher_no = $this->input->get('voucher_no');
		$jurnal_trx_type = $this->input->get('jurnal_trx_type');
		$branch_code = $this->input->get('branch_code');
		$from_date = ($from_date=='')?'':$from_date;
		$to_date = ($to_date=='')?'':$to_date;
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'mfi_trx_gl.trx_date','mfi_trx_gl.voucher_no','mfi_trx_gl.voucher_ref', '', 'total_debit','total_credit','');
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
			$sWhere = " AND (";
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
						$sWhere = " AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$dWhere['from_date'] 	= $from_date;
		$dWhere['to_date'] 		= $to_date;
		$dWhere['voucher_ref'] 	= $voucher_ref;
		$dWhere['voucher_no'] 	= $voucher_no;
		$dWhere['branch_code'] 	= $branch_code;
		$dWhere['jurnal_trx_type'] 	= $jurnal_trx_type;

		$rResult 			= $this->model_laporan->datatable_cetak_voucher($dWhere,$sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_cetak_voucher($dWhere,$sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_laporan->datatable_cetak_voucher($dWhere); // get number of all data
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
			$row[] = '<div align="center">'.date('d-m-Y',strtotime($aRow['trx_date'])).'</div>';
			$row[] = '<div align="center">'.$aRow['voucher_no'].'</div>';
			$row[] = $aRow['voucher_ref'];
			$row[] = $aRow['description'];
			$row[] = '<div align="right">'.number_format($aRow['total_debit'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['total_credit'],0,',','.').'</div>';
			$row[] = '<div align="center" style="white-space:nowrap"><a href="javascript:void(0);" id="btn-cetakvoucher" class="btn mini green" style="white-space:nowrap" trx_gl_id="'.$aRow['trx_gl_id'].'"><i class="icon-print"></i> Cetak</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_data_cetak_voucher()
	{
		$trx_gl_id = $this->input->post('trx_gl_id');
		$data['trx_gl'] = $this->model_laporan->get_trx_gl_by_id($trx_gl_id);
		$data['trx_gl']['trx_date'] = $this->format_date_detail(substr($data['trx_gl']['trx_date'],0,10),'id',false,'-');
		$data['trx_gl_detail'] = $this->model_laporan->get_trx_gl_detail_by_trx_gl_id($trx_gl_id);
		echo json_encode($data);
	}

	/* REKAP SALDO ANGGOTA */

	public function rekap_saldo_anggota()
	{
		$data['container'] = 'laporan/rekap_saldo_anggota';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/* REKAP TRANSAKSI REMBUG */
	
	public function rekap_transaksi_rembug()
	{
		$data['container'] = 'laporan/rekap_transaksi_rembug';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/* LAPORAN JURNAL TRANSAKSI */
	public function jurnal_transaksi()
     {
		$data['container'] = 'laporan/jurnal_transaksi';
		$this->load->view('core',$data);
	}

	/**
	* MODUL : HITUNG KOLEKTIBILITAS
	* date : 2014-11-17 22:00
	* @TAM
	* @author sayyid nurkilah
	*/
	public function hitung_kolektibilitas()
	{
		$data['container'] = 'laporan/hitung_kolektibilitas';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function proses_hitung_kolektibilitas()
	{
		$branch_id = $this->uri->segment(3);
		$date = $this->uri->segment(4);
		$desc_date = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
		$date = substr($date,4,4).'-'.substr($date,2,2).'-'.substr($date,0,2);
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('user_id');
		if($branch_id=="00000"){
			$branch_id = '';
		}
		$branch_data = $this->model_cif->get_branch_by_branch_id($branch_id);
		$branch_code = $branch_data['branch_code'];
		$branch_class = $branch_data['branch_class'];
		if ($branch_class=='3') {
			$sql_cek_par = "select count(*) as jum from mfi_par where tanggal_hitung=? and branch_code=?";
		} else {
			$sql_cek_par = "select count(*) as jum from mfi_par where tanggal_hitung=? and branch_code in (select branch_code from mfi_branch_member where branch_induk = ?)";
		}
		$query_cek_par=$this->db->query($sql_cek_par,array($date,$branch_code));
		$row_cek_par=$query_cek_par->row_array();

		if(count($row_cek_par)>0){
			$cek_par_exists=$row_cek_par['jum'];
		}else{
			$cek_par_exists=0;
		}

		if($branch_class < 2){
			$this->session->set_flashdata('failed','Proses dibatalkan. Perhitungan Kolektibilitas hanya boleh digunakan oleh Unit/Cabang saja!');
		}
		// else if($cek_par_exists>0)
		// {
		// 	$this->session->set_flashdata('failed','Proses Hitung Dibatalkan! Perhitungan pernah dilakukan pada tanggal ini!');
		// }
		else
		{
			$this->db->trans_begin();

			/*
			$data = $this->model_laporan_to_pdf->get_laporan_par($date,$branch_code);

			$kolektibilitas = array();
			for($i=0;$i<count($data);$i++)
			{
				$kolektibilitas[] = array(
						'branch_code' => $data[$i]['branch_code']
						,'tanggal_hitung' => $date
						,'account_financing_no' => $data[$i]['account_financing_no']
						,'saldo_pokok' => $data[$i]['saldo_pokok']
						,'saldo_margin' => $data[$i]['saldo_margin']
						,'hari_nunggak' => $data[$i]['hari_nunggak']
						,'freq_tunggakan' => $data[$i]['freq_tunggakan']
						,'tunggakan_pokok' => $data[$i]['tunggakan_pokok']
						,'tunggakan_margin' => $data[$i]['tunggakan_margin']
						,'par_desc' => $data[$i]['par_desc']
						,'par' => $data[$i]['par']
						,'cadangan_piutang' => $data[$i]['cadangan_piutang']
						,'created_date'=>date('Y-m-d H:i:s')
						,'created_by'=>$this->session->userdata('user_id')
					);
				
				$status_kolektibilitas=0;
				switch ($data[$i]['par_desc']){
					case "1 - 30":
					$status_kolektibilitas=1;
					break;
					case "31 - 60":
					$status_kolektibilitas=2;
					break;
					case "61 - 90":
					$status_kolektibilitas=3;
					break;
					case "91 - 120":
					$status_kolektibilitas=4;
					break;
					case "> 120":
					$status_kolektibilitas=5;
					break;
				}

				$row_financing=array('status_kolektibilitas'=>$status_kolektibilitas);
				$param_financing=array('account_financing_no'=>$data[$i]['account_financing_no']);
				$this->db->update("mfi_account_financing",$row_financing,$param_financing);

			}
			*/

			// $this->db->delete('mfi_par',array('branch_code'=>$branch_code,'tanggal_hitung'=>$date));
			$this->db->query('delete from mfi_par where tanggal_hitung=? and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)',array($date,$branch_code));

			/*
			if(count($kolektibilitas)>0){
				$this->db->insert_batch('mfi_par',$kolektibilitas);
			}
			*/
			$insert = $this->model_laporan->fn_insert_par($branch_code,$date,$created_by,$created_date);

			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$this->session->set_flashdata('success','Proses Hitung Kolektibilitas SUKSES!');
			}else{
				$this->db->trans_rollback();
				$this->session->set_flashdata('failed','Something went wrong! please contact your administrator!');
			}
		}

		redirect("laporan/hitung_kolektibilitas");

	}

	/*
	| REKAP KOLEKTIBILITAS
	| Sayyid Nurkilah
	*/
	function rekap_kolektibilitas()
	{
		$data['container'] = 'laporan/rekap_kolektibilitas';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['data_fa'] = $this->model_laporan->get_fa_by_branch();
		$data['data_cm'] = $this->model_laporan->get_cm_by_branch();
		$data['data_kol'] = $this->model_laporan->get_all_par();
		$data['tanggal'] = $this->model_laporan->get_tanggal_par();
		$this->load->view('core',$data);
	}

	function aging_report_schedulle(){
		$data['container'] = 'laporan/aging_report_schedulle';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['data_fa'] = $this->model_laporan->get_fa_by_branch();
		$data['data_cm'] = $this->model_laporan->get_cm_by_branch();
		$data['data_kol'] = $this->model_laporan->get_all_par();
		$data['tanggal'] = $this->model_laporan->get_tanggal_par();
		$this->load->view('core',$data);
	}

	function rekap_transaksi_individu(){
		$data['container'] = 'laporan/rekap_transaksi_individu';
		$this->load->view('core',$data);
	}

	function get_fa_by_branch()
	{
		$branch_code=$this->input->post('branch_code');
		$branch_class=$this->input->post('branch_class');
		$data=$this->model_laporan->get_fa_by_branch($branch_code,$branch_class);
		echo json_encode($data);
	}

	function get_cm_by_branch()
	{
		$branch_code=$this->input->post('branch_code');
		$branch_class=$this->input->post('branch_class');
		$data=$this->model_laporan->get_cm_by_branch($branch_code,$branch_class);
		echo json_encode($data);
	}
	function get_cm_by_fa()
	{
		$branch_code=$this->input->post('branch_code');
		$fa_code=$this->input->post('fa_code');
		$data=$this->model_laporan->get_cm_by_fa($branch_code,$fa_code);
		echo json_encode($data);
	}
	function get_cm_by_fa_code()
	{
		$fa_code=$this->input->post('fa_code');
		$data=$this->model_laporan->get_cm_by_fa_code($fa_code);
		echo json_encode($data);
	}

	/*
	| DATA LENGKAP PEMBIAYAAN
	*/
	function data_lengkap_pembiayaan()
	{
		$data['container']='laporan/data_lengkap_pembiayaan';
		$data['title']='Laporan Data Lengkap Pembiayaan';
		$this->load->view('core',$data);
	}

	/**
	* MODUL : LAPORAN LABA RUGI RINCI
	* @author Sayyid Nurkilah
	*/
	public function laba_rugi_rinci_gl()
	{
		$data['container'] = 'laporan/laba_rugi_rinci_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	public function laba_rugi_rinci_gl_v2()
	{
		$data['container'] = 'laporan/laba_rugi_rinci_gl_v2';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	public function neraca_rinci_gl()
	{
		$data['container'] = 'laporan/neraca_rinci_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	public function neraca_rinci_gl_v2()
	{
		$data['container'] = 'laporan/neraca_rinci_gl_v2';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	function list_angsuran_pembiayaan(){
		$branch_code=$this->session->userdata('branch_code');

		$data['container'] = 'laporan/list_angsuran_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['produk'] = $this->model_laporan->get_produk_pembiayaan_kelompok();
		$data['rembug'] = $this->model_laporan->get_cm($branch_code);
		$this->load->view('core',$data);
	}

	public function ajax_get_cm_by_branch()
	{
		$branch_code=$this->input->post('branch_code');
		$rembug = $this->model_laporan->get_cm($branch_code);
		echo json_encode($rembug);
	}

	/*LAPORANS STATEMENT TAB.KELOMPOK*/
	function statement_tab_kelompok()
	{
		$data['title'] = "Statement Tabungan Kelompok";
		$data['container'] = 'laporan/statement_tab_kelompok';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cms'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	function get_cif_by_cm_code()
	{
		$cm_code=$this->input->post('cm_code');
		$data=$this->model_laporan->get_cif_by_cm_code($cm_code);
		echo json_encode($data);
	}

	function get_account_saving_by_cif_no()
	{
		$cif_no=$this->input->post('cif_no');
		$data=$this->model_laporan->get_account_saving_by_cif_no($cif_no);
		echo json_encode($data);
	}


	public function rekap_trx_rembug()
	{
		$data['container'] = 'laporan/rekap_trx_rembug';
		$data['petugass'] = $this->model_laporan->get_petugas();
		$this->load->view('core',$data);
	}
	function get_peutgas_by_branch_code()
	{
		$branch_code=$this->input->post('branch_code');
		$data=$this->model_laporan->get_peutgas_by_branch_code($branch_code);
		echo json_encode($data);
	}
	function get_cm_by_branch_id()
	{
		$branch_id = $this->input->post('branch_id');
		$sql = "select cm_code,cm_name from mfi_cm where branch_id=?";
		$query = $this->db->query($sql,array($branch_id));
		$data = $query->result_array();
		echo json_encode($data);
	}


	/*
	| Pencairan Tabungan Berencana
	| ujangirawan - 29 April 2015
	*/
	public function pencairan_tabungan_berencana()
	{
		$data['container'] = 'laporan/pencairan_tabungan_berencana';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['produk'] 		= $this->model_laporan->get_all_produk_tabungan();
		//$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}


	/*sayyid*/
	function lembar_absensi_anggota()
	{
		$data['container'] = 'laporan/lembar_absensi_anggota';
		$this->load->view('core',$data);
	}



    /*
	| Laporan List Saldo Anggota
	| ujangirawan -- 13 Mei 2015
    */
	public function list_saldo_anggota()
	{
		$data['container'] = 'anggota/list_saldo_anggota';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kecamatan'] = $this->model_laporan->get_kecamatan();
		$this->load->view('core',$data);
	}
	
	public function rekap_jumlah_anggota()
	{
		$data['container'] = 'laporan/rekap_jumlah_anggota';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kecamatan'] = $this->model_laporan->get_kecamatan();
		$this->load->view('core',$data);
	}
	
	

	public function export_pdf_saldo_anggota_kecamatan()
    {
        $tanggal1 = $this->uri->segment(3);
        $tanggal1__ = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_ = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2 = $this->uri->segment(4);
        $tanggal2__ = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_ = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $cabang = $this->uri->segment(5);       
        $kecamatan = $this->uri->segment(6);
        if ($cabang==false){
            $cabang = "0000";
        }else{
            $cabang =   $cabang;            
        }

       	if ($tanggal1==""){
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }else if ($tanggal2==""){
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }else{
            $datas = $this->model_laporan->export_saldo_anggota_kecamatan($cabang,$tanggal1_,$tanggal2_,$kecamatan);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            $data['result']= $datas;
            if ($cabang !='0000'){
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            }else{
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            $this->load->view('laporan/export_saldo_anggota_by_kecamatan',$data);
            $content = ob_get_clean();
            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('list_saldo_anggota"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
	
	// Export Rekap Jumlah Anggota ///
	public function export_pdf_rekep_jumlah_anggota()
    {
        $cabang = $this->uri->segment(3);       

        if ($cabang==false){
            $cabang = "0000";
        }else{
            $cabang =   $cabang;            
        }

       	if ($tanggal1==""){
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }else if ($tanggal2==""){
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }else{
            $datas = $this->model_laporan->export_rekap_jumlah_anggota($cabang);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            $data['result']= $datas;
            if ($cabang !='0000'){
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            }else{
                $data['cabang'] = "SEMUA CABANG";
            }
            $this->load->view('laporan/export_rekap_jumlah_anggota',$data);
            $content = ob_get_clean();
            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('rekap_jumlah_anggota"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
	// End Export Rekap Jumlah Anggota ///
	

    public function export_xls_saldo_anggota_kecamatan()
	{
		$tanggal1 = $this->uri->segment(3);
        $tanggal1__ = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_ = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2 = $this->uri->segment(4);
        $tanggal2__ = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_ = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $cabang = $this->uri->segment(5);       
        $kecamatan = $this->uri->segment(6);
        if ($cabang==false){
            $cabang = "0000";
        }else{
            $cabang =   $cabang;            
        }

       	if ($tanggal1==""){
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }else if ($tanggal2==""){
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }else{
            $datas = $this->model_laporan->export_saldo_anggota_kecamatan($cabang,$tanggal1_,$tanggal2_,$kecamatan);
            if ($cabang !='0000'){
                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
            }else{
                $datacabang = "Semua Cabang";
            }
			
			// ----------------------------------------------------------
	    	// [BEGIN] EXPORT SCRIPT
			// ----------------------------------------------------------

			// Create new PHPExcel object
			$objPHPExcel = $this->phpexcel;
			// Set document properties
			$objPHPExcel->getProperties()->setCreator("MICROFINANCE")
										 ->setLastModifiedBy("MICROFINANCE")
										 ->setTitle("Office 2007 XLSX Test Document")
										 ->setSubject("Office 2007 XLSX Test Document")
										 ->setDescription("REPORT, generated using PHP classes.")
										 ->setKeywords("REPORT")
										 ->setCategory("Test result file");

			$objPHPExcel->setActiveSheetIndex(0); 

			$styleArray = array(
	       		'borders' => array(
			             'outline' => array(
			                    'style' => PHPExcel_Style_Border::BORDER_THIN,
			                    'color' => array('rgb' => '000000'),
			             ),
			       ),
			);

			$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
			$objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"List Saldo Anggota Berdasarkan Kecamatan");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:E4');
			$objPHPExcel->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"No");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"Kecamatan");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"Desa");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"Majelis");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"Jumlah");

			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFont()->setSize(10);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$ii = 7;
      		$total_anggota = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
        		$total_anggota+=$datas[$i]['num'];     
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['kecamatan']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['desa']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,number_format($datas[$i]['num'],0,',','.').' ');

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':E'.$ii)->getFont()->setSize(10);
				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_anggota,0,',','.').' ');

			$objPHPExcel->getActiveSheet()->getStyle('E'.$iii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':E'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':E'.$iii)->getFont()->setSize(10);

			}

	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LIST_SALDO_ANGGOTA.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}
    /*
	| End Saldo Anggota
    */

	function laporan_bagihasil()
	{
		$data['container'] = 'laporan/laporan_bagihasil';
		$this->load->view('core',$data);
	}

	public function rekap_angsuran()
	{
		$data['container'] = 'laporan/rekap_angsuran';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function jqgrid_list_transaksi_rembug()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'trx_date';
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		// $tanggal = date('Y-m-d');
		$branch_code = isset($_REQUEST['branch_code'])?$_REQUEST['branch_code']:'';
		$fa_code = isset($_REQUEST['fa_code'])?$_REQUEST['fa_code']:'';
		$cm_code = isset($_REQUEST['cm_code'])?$_REQUEST['cm_code']:'';
		$from_date = isset($_REQUEST['awal_trx_date'])?$_REQUEST['awal_trx_date']:'';
		$thru_date = isset($_REQUEST['akhir_trx_date'])?$_REQUEST['akhir_trx_date']:'';
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);
		
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_laporan_to_pdf->jqgrid_list_transaksi_rembug('','','','',$branch_code,$cm_code,$from_date,$thru_date,$fa_code);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_transaksi_rembug($sidx,$sort,$limit_rows,$start,$branch_code,$cm_code,$from_date,$thru_date,$fa_code);
		
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['cm_code']=$row['cm_code'];
		    $responce['rows'][$i]['cell']=array(
			     $row['cm_code']
				,$row['trx_date']
				,$row['cm_name']
				,$row['fa_name']
				,$row['setoran']
				,$row['penarikan']
				,$row['status_verifikasi']
		    );
		    $i++;
		}

		echo json_encode($responce);
	}

	/****************************************************************************************/	
	// BEGIN SIMPANAN POKOK
	/****************************************************************************************/

	public function simpanan_pokok()
	{
		$data['container'] = 'laporan/simpanan_pokok';
		$data['title'] = 'Simpanan Pokok';
		$data['trx_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data); 
	}

	function list_rekap_sebaran_anggota(){
		$branch = $_GET['branch'];
		$city = $_GET['city'];

		$aColumns = array('mpc.city_code','mpc.city','kecamatan','desa','majelis','anggota');

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
					$sWhere .= "LOWER(CAST(".$aColumns[1]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
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

		$rResult = $this->model_laporan->export_rekap_sebaran_anggota($sWhere,$sOrder,$sLimit,$branch,$city);
		$rResultFilterTotal = $this->model_laporan->export_rekap_sebaran_anggota($sWhere,'','',$branch,$city);
		$iFilteredTotal = count($rResultFilterTotal);
		$rResultTotal = $this->model_laporan->export_rekap_sebaran_anggota('','','',$branch,$city);
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

		foreach($rResult as $aRow){
			$row = array();

			$kode = $aRow['city_code'];
			$kota = $aRow['city'];
			$kecamatan = $aRow['kecamatan'];
			$desa = $aRow['desa'];
			$majelis = $aRow['majelis'];
			$anggota = $aRow['anggota'];

			$row[] = '<center>'.$kode.'</center>';
			$row[] = '<center>'.$kota.'</center>';
			$row[] = '<center>'.$kecamatan.'</center>';
			$row[] = '<center>'.$desa.'</center>';
			$row[] = '<center>'.$majelis.'</center>';
			$row[] = '<center>'.$anggota.'</center>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}

	function list_bagihasil(){
		$data['container'] = 'laporan/list_bagihasil';
		$this->load->view('core',$data);
	}


}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */