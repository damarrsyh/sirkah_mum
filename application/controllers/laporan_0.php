<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends GMN_Controller
{

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
		$this->load->view('core', $data);
	}

	/****************************************************************************************/
	// BEGIN SALDO KAS PERUGAS
	/****************************************************************************************/

	public function saldo_kas_petugas()
	{
		$data['container'] = 'laporan/saldo_kas_petugas';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}

	function datatable_saldo_kas_petugas_new()
	{
		$aColumns = array('', 'account_cash_code', 'fa_name', 'saldo_awal', 'mutasi_debet', 'mutasi_credit', '');
		$cabang  = @$_GET['cabang'];
		$tanggal = @$_GET['tanggal'];
		$tanggal = str_replace('/', '', $tanggal);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$user_id = $this->session->userdata('user_id');

		$sLimit = "";
		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = " OFFSET " . intval($_GET['iDisplayStart']) . " LIMIT " .
				intval($_GET['iDisplayLength']);
		}

		$sOrder = "";
		if (isset($_GET['iSortCol_0'])) {
			$sOrder = "ORDER BY  ";
			for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
				if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
					$sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
						($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
				}
			}

			$sOrder = substr_replace($sOrder, "", -2);
			if ($sOrder == "ORDER BY") {
				$sOrder = "";
			}
		}

		$rResult = $this->model_laporan->datatable_saldo_kas_petugas_new($sOrder, $sLimit, $cabang, $tanggal, $user_id);
		$rResultFilterTotal = $this->model_laporan->datatable_saldo_kas_petugas_new('', '', $cabang, $tanggal, $user_id);
		$iFilteredTotal = count($rResultFilterTotal);
		$rResultTotal = $this->model_laporan->datatable_saldo_kas_petugas_new('', '', $cabang, $tanggal, $user_id);
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
		$no = 1;
		foreach ($rResult as $aRow) {
			$row = array();
			$row[] = $no++;
			$row[] = $aRow['account_cash_code'];
			$row[] = $aRow['fa_name'];
			$row[] = '<div align="right">' . number_format($aRow['saldo_awal'], 0, ',', '.') . '</div>';
			$row[] = '<div align="right">' . number_format($aRow['mutasi_debet'], 0, ',', '.') . '</div>';
			$row[] = '<div align="right">' . number_format($aRow['mutasi_credit'], 0, ',', '.') . '</div>';
			$row[] = '<div align="right">' . number_format(($aRow['saldo_akhir']), 0, ',', '.') . '</div>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}

	public function datatable_saldo_kas_petugas()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('', 'account_cash_code', 'fa_name', 'saldoawal', 'mutasi_debet', 'mutasi_credit', '');
		$cabang  = @$_GET['cabang'];
		$tanggal = @$_GET['tanggal'];
		$tanggal = str_replace('/', '', $tanggal);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		/* 
		 * Paging
		 */
		$sLimit = "";
		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = " OFFSET " . intval($_GET['iDisplayStart']) . " LIMIT " .
				intval($_GET['iDisplayLength']);
		}

		/*
		 * Ordering
		 */
		$sOrder = "";
		if (isset($_GET['iSortCol_0'])) {
			$sOrder = "ORDER BY  ";
			for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
				if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
					$sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
						($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
				}
			}

			$sOrder = substr_replace($sOrder, "", -2);
			if ($sOrder == "ORDER BY") {
				$sOrder = "";
			}
		}

		$rResult 			= $this->model_laporan->datatable_saldo_kas_petugas($sOrder, $sLimit, $cabang, $tanggal); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_saldo_kas_petugas('', '', $cabang, $tanggal); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal);
		$rResultTotal 		= $this->model_laporan->datatable_saldo_kas_petugas('', '', $cabang, $tanggal); // get number of all data
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
		$no = 1;
		foreach ($rResult as $aRow) {
			$row = array();
			$row[] = $no++;
			$row[] = $aRow['account_cash_code'];
			$row[] = $aRow['fa_name'];
			$row[] = '<div align="right">' . number_format($aRow['saldoawal'], 0, ',', '.') . '</div>';
			$row[] = '<div align="right">' . number_format($aRow['mutasi_debet'], 0, ',', '.') . '</div>';
			$row[] = '<div align="right">' . number_format($aRow['mutasi_credit'], 0, ',', '.') . '</div>';
			$row[] = '<div align="right">' . number_format(($aRow['saldoawal'] + $aRow['mutasi_debet'] - $aRow['mutasi_credit']), 0, ',', '.') . '</div>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}

	function get_saldo_awal_dan_akhir_kas_petugas()
	{
		$cabang = $this->input->post('cabang');
		$tanggal = $this->datepicker_convert(true, $this->input->post('tanggal'), '/');
		$saldoawal = $this->model_laporan->get_totalsaldoawal_kas_petugas($cabang, $tanggal);
		$saldoakhir = $this->model_laporan->get_totalsaldoakhir_kas_petugas($cabang, $tanggal);
		$total_saldo_awal = $saldoawal['totalsaldoawal'];
		$total_saldo_akhir = $saldoakhir['totalsaldoakhir'];
		$return = array('total_saldo_awal' => $total_saldo_awal, 'total_saldo_akhir' => $total_saldo_akhir);
		echo json_encode($return);
	}

	function get_saldo_awal_dan_akhir_kas_petugas_new()
	{
		$branch_code = $this->input->post('cabang');
		$tanggal = $this->input->post('tanggal');
		$user_id = $this->session->userdata('user_id');

		$tanggal = $this->datepicker_convert(TRUE, $tanggal, '/');

		$insert = $this->model_laporan->insert_report_kas_petugas($branch_code, $tanggal, $user_id);

		$show = $this->model_laporan->show_report_kas_petugas($branch_code, $tanggal, $user_id);

		$total_saldo_awal = 0;
		$total_saldo_akhir = 0;

		foreach ($show as $sh) {
			$saldo_awal = $sh['saldo_awal'];
			$saldo_akhir = $sh['saldo_akhir'];

			$total_saldo_awal += $saldo_awal;
			$total_saldo_akhir += $saldo_akhir;
		}

		$result = array(
			'total_saldo_awal' => $total_saldo_awal,
			'total_saldo_akhir' => $total_saldo_akhir
		);

		echo json_encode($result);
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
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}


	public function search_code_cash_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$type = $this->input->post('account_type');
		$data = $this->model_laporan->search_code_cash_by_keyword($keyword, $type);

		echo json_encode($data);
	}

	public function datatable_transaksi_kas_petugas()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('', 'trx_date', 'trx_type', 'trx_debet', 'trx_credit', 'saldoawal');
		$tanggal  = @$_GET['tanggal'];
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = @$_GET['tanggal2'];
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
		$account_cash_code = @$_GET['account_cash_code'];
		/* 
		 * Paging
		 */
		$sLimit = "";
		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = " OFFSET " . intval($_GET['iDisplayStart']) . " LIMIT " .
				intval($_GET['iDisplayLength']);
		}

		/*
		 * Ordering
		 */
		$sOrder = "";
		if (isset($_GET['iSortCol_0'])) {
			$sOrder = "ORDER BY  ";
			for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
				if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
					$sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
						($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
				}
			}

			$sOrder = substr_replace($sOrder, "", -2);
			if ($sOrder == "ORDER BY") {
				$sOrder = "";
			}
		}

		$rSaldoAwal = $this->model_laporan->get_saldo_awal_kas_petugas($account_cash_code, $tanggal);
		$rResult 			= $this->model_laporan->datatable_transaksi_kas_petugas_setup($sOrder, $sLimit, $tanggal, $tanggal2, $account_cash_code); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_transaksi_kas_petugas_setup('', '', $tanggal, $tanggal2, $account_cash_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal);
		$rResultTotal 		= $this->model_laporan->datatable_transaksi_kas_petugas_setup('', '', $tanggal, $tanggal2, $account_cash_code); // get number of all data
		$iTotal 			= count($rResultTotal);

		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal + 1,
			"aaData" => array()
		);

		$no = 1;

		$saldo = (isset($rSaldoAwal['saldo_awal'])) ? $rSaldoAwal['saldo_awal'] : 0;

		$baris = array();
		$baris[] = '<div align="center">' . $no . '</div>';
		$baris[] = '<div align="center">&nbsp;</div>';
		$baris[] = '<div align="center">SALDO AWAL</div>';
		$baris[] = '<div align="right">&nbsp;</div>';
		$baris[] = '<div align="right">&nbsp;</div>';
		$baris[] = '<div align="right">' . number_format($saldo, 0, ',', '.') . '</div>';

		$output['aaData'][] = $baris;

		$no += 1;

		foreach ($rResult as $aRow) {
			if ($aRow['flag_debet_credit'] == 'D') {
				$saldo += $aRow['trx_debet'];
			}

			if ($aRow['flag_debet_credit'] == 'C') {
				$saldo -= $aRow['trx_credit'];
			}

			$row = array();

			$row[] = '<div align="center">' . $no++ . '</div>';
			$row[] = '<div align="center">' . $aRow['trx_date'] . '</div>';
			$row[] = '<div align="center">' . $aRow['description'] . '</div>';
			$row[] = '<div align="right">' . number_format($aRow['trx_debet'], 0, ',', '.') . '</div>';
			$row[] = '<div align="right">' . number_format($aRow['trx_credit'], 0, ',', '.') . '</div>';
			$row[] = '<div align="right">' . number_format($saldo, 0, ',', '.') . '</div>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}

	/****************************************************************************************/
	// END TRANSAKSI KAS PERUGAS
	/****************************************************************************************/

	/*GL ACCOUNT HISTORY / LIST JURNAL UMUM*/

	public function list_jurnal_umum_gl()
	{
		$data['container'] = 'laporan/list_jurnal_umum_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}

	public function get_gl_account_history()
	{
		$branch_code = $this->input->post('branch_code');
		$account_code = $this->input->post('account_code');
		$from_date = $this->input->post('from_date');
		$from_date = str_replace('/', '', $from_date);
		$from_date = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
		$thru_date = $this->input->post('thru_date');
		$thru_date = str_replace('/', '', $thru_date);
		$thru_date = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);

		$datas = $this->model_laporan->get_gl_account_history($branch_code, $account_code, $from_date, $thru_date);
		$saldo = $this->model_laporan->fn_get_saldo_gl_account2($account_code, $from_date, $branch_code);

		$saldo_akhir = $saldo['saldo_awal'];
		$total_debit = 0;
		$total_credit = 0;
		$i = 0;
		for ($j = 0; $j < count($datas) + 1; $j++) {
			if ($j == 0) {
				$data['data'][$j]['nomor'] = '';
				$data['data'][$j]['trx_date'] = '';
				$data['data'][$j]['description'] = 'Saldo Awal';
				$data['data'][$j]['debit'] = '';
				$data['data'][$j]['credit'] = '';
				$data['data'][$j]['saldo_akhir'] = $saldo_akhir;
				$data['data'][$j]['trx_gl_id'] = '';
			} else {
				if ($datas[$i]['flag_debit_credit'] == "C") {
					if ($datas[$i]['transaction_flag_default'] == 'C') {
						$saldo_akhir += $datas[$i]['amount'];
					} else {
						$saldo_akhir -= $datas[$i]['amount'];
					}
				}
				if ($datas[$i]['flag_debit_credit'] == "D") {
					if ($datas[$i]['transaction_flag_default'] == 'D') {
						$saldo_akhir += $datas[$i]['amount'];
					} else {
						$saldo_akhir -= $datas[$i]['amount'];
					}
				}
				$data['data'][$j]['nomor'] = $i + 1;
				$data['data'][$j]['trx_date'] = date('d-m-Y', strtotime($datas[$i]['voucher_date']));
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
		$this->load->view('core', $data);
	}

	public function get_gl_rekap_transaksi()
	{
		$branch_code = $this->input->post('branch_code');
		$from_date = $this->input->post('from_date');
		$from_date = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
		$thru_date = $this->input->post('thru_date');
		$thru_date = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);

		$datas = $this->model_laporan->get_gl_rekap_transaksi($branch_code, $from_date, $thru_date);

		$saldo_akhir = 0;
		$total_debit = 0;
		$total_credit = 0;

		for ($i = 0; $i < count($datas); $i++) {
			$data['data'][$i]['nomor'] = $i + 1;
			$data['data'][$i]['saldo_awal'] = 0;
			$data['data'][$i]['account'] = $datas[$i]['account_code'] . ' - ' . $datas[$i]['account_name'];
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
		$this->load->view('core', $data);
	}

	function get_neraca_saldo_gl2()
	{
		$branch_code = $this->input->post('branch_code');
		$from = $this->input->post('periode1');
		$thru = $this->input->post('periode2');
		$user_id = $this->session->userdata('user_id');

		$from_tanggal = substr($from, 0, 2);
		$from_bulan = substr($from, 2, 2);
		$from_tahun = substr($from, -4);

		$thru_tanggal = substr($thru, 0, 2);
		$thru_bulan = substr($thru, 2, 2);
		$thru_tahun = substr($thru, -4);

		$from = $from_tahun . '-' . $from_bulan . '-' . $from_tanggal;
		$thru = $thru_tahun . '-' . $thru_bulan . '-' . $thru_tanggal;

		$startGetClosing = $from_tahun . '-' . $from_bulan . '-01';
		$fromlm = date('Y-m-d', strtotime($startGetClosing . ' - 1 MONTH'));

		$periode = $this->model_laporan->get_periode_now();
		$periode_awal = $periode['periode_awal'];
		$periode_akhir = $periode['periode_akhir'];

		if ($from < $periode_awal or $thru < $periode_awal) {
			$datas = $this->model_laporan->saldo_bulan_lalu($branch_code, $from, $thru);
		} else {
			$this->model_laporan_to_pdf->insert_temp($branch_code, $fromlm, $from, $thru, $user_id);
			$datas = $this->model_laporan->saldo_bulan_ini($branch_code, $user_id);
		}

		$saldo_akhir = 0;
		$total_debit = 0;
		$total_credit = 0;
		$ii = 0;
		$group_name = '';

		for ($i = 0; $i < count($datas); $i++) {
			$group = $this->model_laporan->get_account_group_by_code($datas[$i]['account_group_code']);

			if (count($group) > 0) {
				if ($group_name != $group['group_name']) {
					$group_name = $group['group_name'];
					$data['data'][$ii]['nomor'] = '';
					$data['data'][$ii]['saldo_awal'] = '';
					$data['data'][$ii]['account'] = $group_name;
					$data['data'][$ii]['debit'] = '';
					$data['data'][$ii]['credit'] = '';
					$data['data'][$ii]['saldo_akhir'] = '';
					$ii++;
				}
			} else {
				$group_name = '';
			}

			$data['data'][$ii]['nomor'] = $i + 1;
			$data['data'][$ii]['saldo_awal'] = $datas[$i]['saldo_awal'];
			$data['data'][$ii]['account'] = $datas[$i]['account_code'] . ' - ' . $datas[$i]['account_name'];
			$data['data'][$ii]['debit'] = $datas[$i]['debit'];
			$data['data'][$ii]['credit'] = $datas[$i]['credit'];
			$data['data'][$ii]['saldo_akhir'] = $this->coalesce($datas[$i]['saldo_awal'] + $datas[$i]['debit'] - $datas[$i]['credit'], 0);

			$total_debit  += $datas[$i]['debit'];
			$total_credit += $datas[$i]['credit'];
			if (count($group) > 0) {
				$group_name = $group['group_name'];
			}
			$ii++;
		}
		$data['total_debit'] = $total_debit;
		$data['total_credit'] = $total_credit;

		echo json_encode($data);
	}

	function coalesce($value, $default_value)
	{
		if ($value == '') {
			return $default_value;
		} else {
			return $value;
		}
	}

	/* END NERACA SALDO GL */

	///* REKAP MUTASI GL *///

	public function rekap_mutasi_gl()
	{
		$data['container'] = 'laporan/rekap_mutasi_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
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
		$from_date = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
		$thru_date = $this->input->post('thru_date');
		$thru_date = str_replace('/', '', $thru_date);
		$thru_date = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);

		$datas = $this->model_laporan->get_rekap_mutasi_gl($branch_code, $from_date, $thru_date);

		$total_debit = 0;
		$total_credit = 0;
		$ii = 0;
		$group_name = '';
		$data['data'][$ii]['nomor'] = '&nbsp;';
		$data['data'][$ii]['account'] = '&nbsp;';
		// $data['data'][$ii]['saldo_awal'] = 0;
		$data['data'][$ii]['debit'] = 0;
		$data['data'][$ii]['credit'] = 0;
		// $data['data'][$ii]['saldo_akhir'] = 0;

		for ($i = 0; $i < count($datas); $i++) {
			$data['data'][$ii]['nomor'] = $i + 1;
			$data['data'][$ii]['account'] = $datas[$i]['account_code'] . ' - ' . $datas[$i]['account_name'];
			// $data['data'][$ii]['saldo_awal'] = $datas[$i]['saldo_awal'];
			$data['data'][$ii]['debit'] = $datas[$i]['debit'];
			$data['data'][$ii]['credit'] = $datas[$i]['credit'];
			// $data['data'][$ii]['saldo_akhir'] = $this->coalesce($datas[$i]['saldo_awal']+$datas[$i]['debit']-$datas[$i]['credit'],0);

			$total_debit += $datas[$i]['debit'];
			$total_credit += $datas[$i]['credit'];

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
		$from_date = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
		$thru_date = str_replace('/', '', $thru_date);
		$thru_date = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);


		$data['datas'] = $this->model_laporan->get_rekap_mutasi_gl($branch_code, $from_date, $thru_date);

		$this->load->view('laporan/cetak_rekap_mutasi_gl_txt', $data);
	}
	///* END REKAP MUTASI GL *///


	/****************************************************************************************/
	// BEGIN REPORT LABA RUGI
	/****************************************************************************************/

	public function laba_rugi_gl()
	{
		$data['container'] = 'laporan/laba_rugi_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}
	public function laba_rugi_gl_v2()
	{
		$data['container'] = 'laporan/laba_rugi_gl_v2';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
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
		$this->load->view('core', $data);
	}
	public function neraca_gl_v2()
	{
		$data['container'] = 'laporan/neraca_gl_v2';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['periodes'] = $this->model_laporan->get_periode_trx(0);
		$data['periode_run'][0] = $this->model_laporan->get_periode_trx(1);
		$this->load->view('core', $data);
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
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
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
		$this->load->view('core', $data);
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
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['product'] = $this->model_laporan->get_product_financing();
		$data['peruntukan'] = $this->model_laporan->show_peruntukan('peruntukan');
		$data['sektor'] = $this->model_laporan->show_peruntukan('sektor_ekonomi');
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$this->load->view('core', $data);
	}
	/****************************************************************************************/
	// END REPORT LIST PENGHAPUSAN PEMBIAYAAN
	/****************************************************************************************/

	function api_debitur()
	{
		$data['container'] = 'laporan/api_debitur';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$data['product'] = $this->model_laporan->get_product_financing();
		$this->load->view('core', $data);
	}

	function read_kreditur()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'account_financing_no'; //1
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';

		$branch_code = isset($_REQUEST['branch_code']) ? $_REQUEST['branch_code'] : '';
		$product = isset($_REQUEST['product']) ? $_REQUEST['product'] : '';
		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';
		$kreditur_from = isset($_REQUEST['kreditur_from']) ? $_REQUEST['kreditur_from'] : '';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$tanggal = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal)));
		$tanggal2 = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal2)));

		$result = $this->model_laporan->read_kreditur('', '', '', '', $branch_code, $product, $tanggal, $tanggal2, $kreditur_from);

		$count = count($result);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan->read_kreditur($sidx, $sort, $limit_rows, $start, $branch_code, $product, $tanggal, $tanggal2, $kreditur_from);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		foreach ($result as $row) {
			$responce['rows'][] = array(
				'id' => $row['account_financing_id'],
				'branch_name' => $row['branch_name'],
				'cm_name' => $row['cm_name'],
				'cif_no' => $row['cif_no'],
				'nama' => $row['nama'],
				'account_financing_no' => $row['account_financing_no'],
				'pokok' => $row['pokok'],
				'margin' => $row['margin'],
				'jangka_waktu' => $row['jangka_waktu'] . ' ' . $row['periode_jangka_waktu'],
				'tanggal_akad' => $row['tanggal_akad'],
				'sumber_dana' => $row['sumber_dana'],
				'display_text' => $row['display_text'],
				'product_name' => $row['product_name']
			);
		}

		echo json_encode($responce);
	}

	function proses_api_debitur()
	{
		$show = $this->input->post('object');
		$batch_no = $this->input->post('batch_no');
		$group_bprs = $this->input->post('group_bprs');

		$count = count($show);

		$key = '22daf1c95493347d9588b44863bd05f3';

		$link_ktp = site_url('api/download_ktp');
		$link_kk = site_url('api/download_kk');
		$link_pendukung = site_url('api/download_pendukung');
		$link_tandatangan = site_url('api/download_sign');

		$path = './assets/img/document/';
		$path2 = './assets/img/ttd/';

		$fields = array();

		for ($i = 0; $i < $count; $i++) {
			$get = $this->model_laporan->get_kreditur_by($show[$i]);

			$day = date('l', strtotime($get['tanggal_pengajuan']));

			if ($day == 'Sunday') {
				$hari = 'Minggu';
			} else if ($day == 'Monday') {
				$hari = 'Senin';
			} else if ($day == 'Tuesday') {
				$hari = 'Selasa';
			} else if ($day == 'Wednesday') {
				$hari = 'Rabu';
			} else if ($day == 'Thrusday') {
				$hari = 'Kamis';
			} else if ($day == 'Friday') {
				$hari = 'Jumat';
			} else {
				$hari = 'Sabtu';
			}

			if (isset($get['doc_ktp'])) {
				if (file_exists($path . @$get['doc_ktp'])) {
					$path_ktp = $path . @$get['doc_ktp'];
					$type_ktp = pathinfo($path_ktp, PATHINFO_EXTENSION);
					$data_ktp = @file_get_contents($path_ktp);
					$base64_ktp = 'data:image/' . $type_ktp . ';base64,' . base64_encode($data_ktp);
				} else {
					$path_ktp = $path . 'ktp_none.png';
					$type_ktp = pathinfo($path_ktp, PATHINFO_EXTENSION);
					$data_ktp = @file_get_contents($path_ktp);
					$base64_ktp = 'data:image/' . $type_ktp . ';base64,' . base64_encode($data_ktp);
				}
			} else {
				$path_ktp = $path . 'ktp_none.png';
				$type_ktp = pathinfo($path_ktp, PATHINFO_EXTENSION);
				$data_ktp = @file_get_contents($path_ktp);
				$base64_ktp = 'data:image/' . $type_ktp . ';base64,' . base64_encode($data_ktp);
			}

			if (isset($get['doc_kk'])) {
				if (file_exists($path . @$get['doc_kk'])) {
					$path_kk = $path . @$get['doc_kk'];
					$type_kk = pathinfo($path_kk, PATHINFO_EXTENSION);
					$data_kk = @file_get_contents($path_kk);
					$base64_kk = 'data:image/' . $type_kk . ';base64,' . base64_encode($data_kk);
				} else {
					$path_kk = $path . 'kk_none.png';
					$type_kk = pathinfo($path_kk, PATHINFO_EXTENSION);
					$data_kk = @file_get_contents($path_kk);
					$base64_kk = 'data:image/' . $type_kk . ';base64,' . base64_encode($data_kk);
				}
			} else {
				$path_kk = $path . 'kk_none.png';
				$type_kk = pathinfo($path_kk, PATHINFO_EXTENSION);
				$data_kk = @file_get_contents($path_kk);
				$base64_kk = 'data:image/' . $type_kk . ';base64,' . base64_encode($data_kk);
			}

			if (isset($get['doc_pendukung'])) {
				if (file_exists($path . @$get['doc_pendukung'])) {
					$path_pendukung = $path . @$get['doc_pendukung'];
					$type_pendukung = pathinfo($path_pendukung, PATHINFO_EXTENSION);
					$data_pendukung = @file_get_contents($path_pendukung);
					$base64_pendukung = 'data:image/' . $type_pendukung . ';base64,' . base64_encode($data_pendukung);
				} else {
					$path_pendukung = $path . 'pendukung_none.png';
					$type_pendukung = pathinfo($path_pendukung, PATHINFO_EXTENSION);
					$data_pendukung = @file_get_contents($path_pendukung);
					$base64_pendukung = 'data:image/' . $type_pendukung . ';base64,' . base64_encode($data_pendukung);
				}
			} else {
				$path_pendukung = $path . 'pendukung_none.png';
				$type_pendukung = pathinfo($path_pendukung, PATHINFO_EXTENSION);
				$data_pendukung = @file_get_contents($path_pendukung);
				$base64_pendukung = 'data:image/' . $type_pendukung . ';base64,' . base64_encode($data_pendukung);
			}

			$path_ttd = $path2 . @$get['ttd_anggota'];
			$type_ttd = pathinfo($path_ttd, PATHINFO_EXTENSION);
			$data_ttd = @file_get_contents($path_ttd);
			$base64_ttd = 'data:image/' . $type_ttd . ';base64,' . base64_encode($data_ttd);

			$fields[$i]['no_id_cabang'] = $get['branch_code'];
			$fields[$i]['nm_anggota'] = $get['nama'];
			$fields[$i]['rembuk'] = $get['cm_name'];
			$fields[$i]['desa'] = $get['desa'];
			$fields[$i]['tgl_cair'] = $get['tanggal_akad'];
			$fields[$i]['pembiayaan'] = $get['pokok'];
			$fields[$i]['tenor'] = $get['jangka_waktu'];
			$fields[$i]['kd_cab'] = '002';
			$fields[$i]['keterangan'] = $get['description'];
			$fields[$i]['sektor'] = $get['sektor_ekonomi'];
			$fields[$i]['barang'] = $get['peruntukan'];
			$fields[$i]['no_ktp'] = $get['no_ktp'];
			$fields[$i]['tmp_lahir'] = $get['tmp_lahir'];
			$fields[$i]['tgl_lahir'] = $get['tgl_lahir'];
			$fields[$i]['alamat_lengkap'] = $get['alamat'];
			$fields[$i]['status'] = $get['city'];
			$fields[$i]['kabupaten'] = $get['city_abbr'];
			$fields[$i]['kode_pos'] = $get['kodepos'];
			$fields[$i]['ibu_kandung'] = $get['ibu_kandung'];
			$fields[$i]['cabang'] = $get['branch_name'];
			$fields[$i]['tahap'] = '1';
			$fields[$i]['statusa'] = '0';
			$fields[$i]['kode_koperasi'] = $get['branch_code'];
			$fields[$i]['group_bprs'] = $group_bprs;
			$fields[$i]['tgl_pengajuan'] = $get['tanggal_pengajuan'];
			$fields[$i]['hari_pengajuan'] = $hari;
			$fields[$i]['no_rekening'] = $get['account_financing_no'];
			$fields[$i]['link_ktp'] = $base64_ktp; //$link_ktp.'/'.$get['map_no'];
			$fields[$i]['link_kk'] = $base64_kk; //$link_kk.'/'.$get['map_no'];
			$fields[$i]['link_pendukung'] = $base64_pendukung; //$link_pendukung.'/'.$get['map_no'];
			$fields[$i]['link_tandatangan'] = $base64_ttd; //$link_tandatangan.'/'.$get['map_no'];

			$data = array(
				'status_pyd_kreditur' => '3',
				'batch_no' => $batch_no
			);

			$param = array('account_financing_no' => $get['account_financing_no']);

			$this->model_laporan->update_rekening($data, $param);
		}

		$ch = curl_init('https://siponi.id/apisiponi/api/debitur');

		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Connection: Keep-Alive',
			'key: ' . $key
		));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		$response_json = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		$ret = json_decode($response_json);

		$datax = array(
			'data' => $ret,
			'message' => $httpcode
		);

		$status = $datax['data']->status;
		$message = $datax['data']->message;

		if ($status == TRUE) {
			$result = array(
				'status' => TRUE,
				'message' => 'Pengajuan Kreditur berhasil'
			);
		} else {
			$result = array(
				'status' => FALSE,
				'message' => 'Pengajuan Kreditur gagal'
			);
		}

		echo json_encode($result);
	}

	function list_chn_debitur_v2()
	{
		$data['container'] = 'laporan/list_chn_debitur_v2';
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$data['batch'] = $this->model_laporan->get_batch();
		$this->load->view('core', $data);
	}

	function list_chn_debitur()
	{
		$data['container'] = 'laporan/list_chn_debitur';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$this->load->view('core', $data);
	}

	public function update_chn_debitur()
	{
		$data['container'] = 'laporan/update_chn_debitur';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$data['get_chn_debitur_upload'] = $this->model_laporan->get_chn_debitur_upload();
		$this->load->view('core', $data);
	}

	function imp_chn_debitur_excel()
	{
		if (is_array($_FILES)) {
			if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
				$sourcePath = $_FILES['userfile']['tmp_name'];
				$targetPath = "./assets/excel/import_debitur.xls";
				move_uploaded_file($sourcePath, $targetPath);
			}
		}
	}

	function jqgrid_list_chn_debitur()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$debitur_upload_no = $_REQUEST['debitur_upload_no'];

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_chn_debitur($debitur_upload_no);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_chn_debitur($debitur_upload_no);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {

			$account_financing_no 	= $row['account_financing_no'];
			$cif_no 				= $row['cif_no'];
			$no_ktp 				= $row['no_ktp'];
			$get_debitur_status 	= $row['debitur_status'];

			if ($get_debitur_status == '0') {
				$debitur_status = 'Pengajuan';
			} else if ($get_debitur_status == '1') {
				$debitur_status = 'Diterima belum akad';
			} else if ($get_debitur_status == '2') {
				$debitur_status = 'Diterima sudah akad';
			} else if ($get_debitur_status == '9') {
				$debitur_status = 'Ditolak';
			}

			$responce['rows'][$i]['account_financing_no'] = $account_financing_no;
			$responce['rows'][$i]['cell'] = array($account_financing_no, $cif_no, $no_ktp, $debitur_status);

			$i++;
		}

		echo json_encode($responce);
	}

	function imp_chn_debitur_update_excel()
	{
		if (is_array($_FILES)) {
			if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
				$sourcePath = $_FILES['userfile']['tmp_name'];
				$targetPath = "./assets/excel/import_debitur_update.xls";
				move_uploaded_file($sourcePath, $targetPath);
			}
		}
	}

	public function read_import_debitur_update()
	{
		$target = './assets/excel/import_debitur_update.xls';

		try {
			$objPHPExcel = PHPExcel_IOFactory::load($target);
		} catch (Exception $e) {
			$confirm = FALSE;
			$result = array(
				'result' => FALSE,
				'message' => 'Tidak dapat membuka file :' . $e->getMessage(),
				'tbody' => ''
			);
		}


		$worksheet = $objPHPExcel->getActiveSheet()->toArray(NULL, TRUE, TRUE, TRUE);
		$numRows = count($worksheet);
		$nik_array = " (";
		$data_batch = array();
		// MULAI BARIS KE-3
		for ($i = 2; $i < ($numRows + 1); $i++) {
			$nik = $worksheet[$i]['B'];

			if ($i != $numRows) {
				$nik_array = $nik_array . $nik . "', ";
			} else {
				$nik_array = $nik_array . $nik . "')";
			}
		}
		///echo "<tr>";
		///echo "<td".$cif_no_array.">".$cif_no_array."</td>";
		///echo "</tr>";
		return $nik_array;
	}

	public function chn_debitur_update()
	{
		$target = './assets/excel/import_debitur_update.xls';

		try {
			$objPHPExcel = PHPExcel_IOFactory::load($target);
		} catch (Exception $e) {
			$confirm = FALSE;
			$result = array(
				'result' => FALSE,
				'message' => 'Tidak dapat membuka file :' . $e->getMessage(),
				'tbody' => ''
			);
		}


		$worksheet = $objPHPExcel->getActiveSheet()->toArray(NULL, TRUE, TRUE, TRUE);
		$numRows = count($worksheet);
		$nik_array = " (";
		$data_batch = array();
		// MULAI BARIS KE-3
		for ($i = 2; $i < ($numRows + 1); $i++) {
			$nik = $worksheet[$i]['B'];

			if ($i != $numRows) {
				$nik_array = $nik_array . $nik . "', ";
			} else {
				$nik_array = $nik_array . $nik . "')";
			}
		}

		$debitur_upload_no = $this->input->post('debitur_upload_no');


		$this->db->trans_begin();
		$this->model_laporan->update_chn_debitur_trm($debitur_upload_no, $nik_array);
		$this->model_laporan->update_chn_debitur_ggl($debitur_upload_no, $nik_array);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/
	// END DEBITUR
	/****************************************************************************************/


	public function list_chn_akad()
	{
		$data['container'] = 'laporan/list_chn_akad';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$data['get_chn_debitur_upload'] = $this->model_laporan->get_chn_debitur_upload_1();
		$this->load->view('core', $data);
	}

	public function update_chn_akad()
	{
		$data['container'] = 'laporan/update_chn_akad';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$data['get_chn_akad_upload_0'] = $this->model_laporan->get_chn_akad_upload_0();
		$this->load->view('core', $data);
	}

	function imp_chn_akad_excel()
	{
		if (is_array($_FILES)) {
			if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
				$sourcePath = $_FILES['userfile']['tmp_name'];
				$targetPath = "./assets/excel/import_akad.xls";
				move_uploaded_file($sourcePath, $targetPath);
			}
		}
	}


	function imp_chn_akad_update_excel()
	{
		if (is_array($_FILES)) {
			if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
				$sourcePath = $_FILES['userfile']['tmp_name'];
				$targetPath = "./assets/excel/import_akad_update.xls";
				move_uploaded_file($sourcePath, $targetPath);
			}
		}
	}


	function jqgrid_list_chn_akad()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$debitur_upload_no = $_REQUEST['debitur_upload_no'];

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_chn_akad($debitur_upload_no);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_chn_akad($debitur_upload_no);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {

			$account_financing_no 	= $row['account_financing_no'];
			$cif_no 				= $row['cif_no'];
			$no_ktp 				= $row['no_ktp'];
			$get_akad_status	 	= $row['akad_status'];

			if ($get_akad_status == '0') {
				$akad_status = 'Pengajuan';
			} else if ($get_akad_status == '1') {
				$akad_status = 'Diterima belum cair';
			} else if ($get_akad_status == '2') {
				$akad_status = 'Diterima sudah cair';
			} else if ($get_akad_status == '9') {
				$akad_status = 'Ditolak';
			}

			$responce['rows'][$i]['account_financing_no'] = $account_financing_no;
			$responce['rows'][$i]['cell'] = array($account_financing_no, $cif_no, $no_ktp, $akad_status);

			$i++;
		}

		echo json_encode($responce);
	}



	public function chn_akad_update()
	{
		$target = './assets/excel/import_akad_update.xls';

		try {
			$objPHPExcel = PHPExcel_IOFactory::load($target);
		} catch (Exception $e) {
			$confirm = FALSE;
			$result = array(
				'result' => FALSE,
				'message' => 'Tidak dapat membuka file :' . $e->getMessage(),
				'tbody' => ''
			);
		}


		$worksheet = $objPHPExcel->getActiveSheet()->toArray(NULL, TRUE, TRUE, TRUE);
		$numRows = count($worksheet);
		$norek_array = " (";
		$data_batch = array();
		// MULAI BARIS KE-3
		for ($i = 2; $i < ($numRows + 1); $i++) {
			$norek = $worksheet[$i]['C'];

			if ($i != $numRows) {
				$norek_array = $norek_array . $norek . "', ";
			} else {
				$norek_array = $norek_array . $norek . "')";
			}
		}

		$debitur_upload_no = $this->input->post('debitur_upload_no');


		$this->db->trans_begin();
		$this->model_laporan->update_chn_akad_trm($debitur_upload_no, $norek_array);
		$this->model_laporan->update_chn_akad_ggl($debitur_upload_no, $norek_array);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/
	// END AKAD
	/****************************************************************************************/
	public function list_chn_droping()
	{
		$data['container'] = 'laporan/list_chn_droping';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$data['get_chn_debitur_upload'] = $this->model_laporan->get_chn_akad_upload_1();
		$this->load->view('core', $data);
	}

	function imp_chn_droping_excel()
	{
		if (is_array($_FILES)) {
			if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
				$sourcePath = $_FILES['userfile']['tmp_name'];
				$targetPath = "./assets/excel/import_droping.xls";
				move_uploaded_file($sourcePath, $targetPath);
			}
		}
	}

	public function update_chn_droping()
	{
		$data['container'] = 'laporan/update_chn_droping';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$data['get_chn_akad_upload_0'] = $this->model_laporan->get_chn_droping_upload_0();
		$this->load->view('core', $data);
	}


	function imp_chn_droping_update_excel()
	{
		if (is_array($_FILES)) {
			if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
				$sourcePath = $_FILES['userfile']['tmp_name'];
				$targetPath = "./assets/excel/import_droping_update.xls";
				move_uploaded_file($sourcePath, $targetPath);
			}
		}
	}

	public function chn_droping_update()
	{
		$target = './assets/excel/import_droping_update.xls';

		try {
			$objPHPExcel = PHPExcel_IOFactory::load($target);
		} catch (Exception $e) {
			$confirm = FALSE;
			$result = array(
				'result' => FALSE,
				'message' => 'Tidak dapat membuka file :' . $e->getMessage(),
				'tbody' => ''
			);
		}


		$worksheet = $objPHPExcel->getActiveSheet()->toArray(NULL, TRUE, TRUE, TRUE);
		$numRows = count($worksheet);
		$norek_array = " (";
		$data_batch = array();
		// MULAI BARIS KE-3
		for ($i = 2; $i < ($numRows + 1); $i++) {
			$norek = $worksheet[$i]['D'];

			if ($i != $numRows) {
				$norek_array = $norek_array . $norek . "', ";
			} else {
				$norek_array = $norek_array . $norek . "')";
			}
		}

		//$debitur_upload_no = $this->input->post('debitur_upload_no');

		$this->db->trans_begin();
		$this->model_laporan->update_kreditur_code_trm($norek_array);
		//$this->model_laporan->update_chn_droping_ggl($debitur_upload_no, $norek_array);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/
	// END DROPING
	/****************************************************************************************/



	/****************************************************************************************/
	// BEGIN LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/

	function list_pelunasan_pembiayaan()
	{
		$data['container'] = 'laporan/list_pelunasan_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$this->load->view('core', $data);
	}

	/****************************************************************************************/
	// END LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/


	/****************************************************************************************/
	// BEGIN REPORT LIST OUTSTANDING PEMBIAYAAN
	/****************************************************************************************/

	function list_outstanding_pembiayaan()
	{
		$data['container'] = 'laporan/list_outstanding_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['product'] = $this->model_laporan->get_product_financing();
		$data['peruntukan'] = $this->model_laporan->show_peruntukan('peruntukan');
		$data['sektor'] = $this->model_laporan->show_peruntukan('sektor_ekonomi');
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$this->load->view('core', $data);
	}


	function jqgrid_list_outstanding_pembiayaan()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'account_financing_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$tanggal = date('Y-m-d');
		$cabang = $_REQUEST['branch_code'];
		$petugas = $_REQUEST['fa_code'];
		$majelis = $_REQUEST['cm_code'];
		$cif_type = $_REQUEST['cif_type'];
		$pembiayaan = $_REQUEST['financing_type'];
		$product_code = $_REQUEST['product_code'];
		$peruntukan = $_REQUEST['peruntukan'];
		$sektor = $_REQUEST['sektor'];
		$kreditur = $_REQUEST['kreditur'];
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		// echo "<pre>";
		// 		print_r($cif_type);
		// 		echo"<br>";
		// 		print_r($pembiayaan);
		// 		die();


		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		// if($cif_type == 1){
		// 	$pembiayaan ='1';
		// } else {
		// 	$pembiayaan ='0';
		// }

		if ($pembiayaan == 1) {
			$petugas = '00000';
		}

		//       echo "<pre>";
		// print_r($cif_type);
		// echo"<br>";
		// print_r($pembiayaan);
		// die();

		if ($cif_type == 1) {
			$count = $this->model_laporan_to_pdf->jqgrid_count_outstanding_pembiayaan_ind($cabang, $cif_type, $pembiayaan, $majelis, $petugas, $tanggal, $product_code, $peruntukan, $sektor, $kreditur);
			// echo "<pre>";
			// print_r($count);
			// die();
		} else {
			$count = $this->model_laporan_to_pdf->jqgrid_count_outstanding_pembiayaan($cabang, $cif_type, $pembiayaan, $majelis, $petugas, $tanggal, $product_code, $peruntukan, $sektor, $kreditur);
			//       print_r($count);
			// die();
		}





		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		if ($cif_type == 1) {
			$result = $this->model_laporan_to_pdf->jqgrid_list_outstanding_pembiayaan_ind($sidx, $sort, $limit_rows, $start, $cabang, $cif_type, $pembiayaan, $majelis, $petugas, $tanggal, $product_code, $peruntukan, $sektor, $kreditur);

			// echo "<pre>";
			// print_r($result);
			// die();
		} else {
			$result = $this->model_laporan_to_pdf->jqgrid_list_outstanding_pembiayaan($sidx, $sort, $limit_rows, $start, $cabang, $cif_type, $pembiayaan, $majelis, $petugas, $tanggal, $product_code, $peruntukan, $sektor, $kreditur);
			// echo "<pre>";
			// print_r($result);
			// die();
		}


		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {
			if ($cif_type == 1) {

				$rekening = $row['account_financing_no'];
				$nama = $row['nama'];
				$ktp = $row['no_ktp'];
				// $rembug = $row['cm_name'];
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
				$kreditur = $row['krd'];
				$fl_reschedulle = $row['fl_reschedulle'];

				if ($bayar == NULL) {
					$bayar = '0';
				}

				$responce['rows'][$i]['account_financing_no'] = $rekening;
				$responce['rows'][$i]['cell'] = array($rekening, $nama, $ktp, $droping, $pokok, $margin, $bayar, $saldo, $saldo_pokok, $saldo_margin, $produk, $sektors, $peruntukans, $kreditur, $fl_reschedulle);

				$i++;
			} else {
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
				$kreditur = $row['krd'];
				$fl_reschedulle = $row['fl_reschedulle'];

				if ($bayar == NULL) {
					$bayar = '0';
				}

				$responce['rows'][$i]['account_financing_no'] = $rekening;
				$responce['rows'][$i]['cell'] = array($rekening, $nama, $ktp, $rembug, $droping, $pokok, $margin, $bayar, $saldo, $saldo_pokok, $saldo_margin, $produk, $sektors, $peruntukans, $kreditur, $fl_reschedulle);

				$i++;
			}
		}

		echo json_encode($responce);
	}
	/****************************************************************************************/
	// END REPORT LIST OUTSTANDING PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/
	// BEGIN REPORT LIST OUTSTANDING BULAN LALU
	/****************************************************************************************/
	function list_outstanding_bulan_lalu()
	{
		$data['container'] = 'laporan/list_outstanding_bulan_lalu';
		$data['product'] = $this->model_laporan->get_product_financing();
		$data['peruntukan'] = $this->model_laporan->show_peruntukan('peruntukan');
		$data['sektor'] = $this->model_laporan->show_peruntukan('sektor_ekonomi');
		$data['tanggal'] = $this->model_laporan->show_tanggal_closing();
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$this->load->view('core', $data);
	}

	function jqgrid_list_outstanding_pembiayaan_lalu()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'account_financing_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$tanggal = date('Y-m-d');
		$cabang = $_REQUEST['branch_code'];
		$petugas = $_REQUEST['fa_code'];
		$majelis = $_REQUEST['cm_code'];
		$pembiayaan = $_REQUEST['financing_type'];
		$product_code = $_REQUEST['product_code'];
		$peruntukan = $_REQUEST['peruntukan'];
		$sektor = $_REQUEST['sektor'];
		$tanggal = $_REQUEST['tanggal'];
		$kreditur = $_REQUEST['kreditur'];

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		if ($pembiayaan == 1) {
			$majelis = '00000';
			$petugas = '00000';
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_outstanding_pembiayaan_lalu($cabang, $pembiayaan, $majelis, $petugas, $tanggal, $product_code, $peruntukan, $sektor, $kreditur);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_outstanding_pembiayaan_lalu($sidx, $sort, $limit_rows, $start, $cabang, $pembiayaan, $majelis, $petugas, $tanggal, $product_code, $peruntukan, $sektor, $kreditur);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {
			$rekening = $row['account_financing_no'];
			$nama = $row['nama'];
			$ktp = $row['no_ktp'];
			$rembug = $row['cm_name'];
			$droping = $row['droping_date'];
			$pokok = $row['pokok'];
			$margin = $row['margin'];
			$bayar = $row['freq_bayar_pokok'];
			$saldo = $row['freq_bayar_saldo'];
			$jangka_waktu = $row['jangka_waktu'];
			$saldo_pokok = $row['saldo_pokok'];
			$saldo_margin = $row['saldo_margin'];
			$saldo_catab = $row['saldo_catab'];
			$produk = $row['nick_name'];
			$sektors = $row['sektor'];
			$peruntukans = $row['peruntukan'];
			$kreditur = $row['krd'];
			$fl_reschedulle = $row['fl_reschedulle'];
			$tanggal_jtempo = $row['tanggal_jtempo'];

			if ($bayar == NULL) {
				$bayar = '0';
			}

			$responce['rows'][$i]['account_financing_no'] = $rekening;
			$responce['rows'][$i]['cell'] = array($rekening, $nama, $ktp, $rembug, $droping, $pokok, $margin, $bayar, $saldo, $jangka_waktu, $saldo_pokok, $saldo_margin, $saldo_catab, $produk, $sektors, $peruntukans, $kreditur, $fl_reschedulle, $tanggal_jtempo);

			$i++;
		}

		echo json_encode($responce);
	}
	/****************************************************************************************/
	// END REPORT LIST OUTSTANDING PEMBIAYAAN BULAN LALU
	/****************************************************************************************/

	/****************************************************************************************/
	// BEGIN REPORT LIST PERMI ANGGOTA 
	/****************************************************************************************/

	public function list_premi_anggota()
	{
		$data['container'] = 'laporan/list_premi_anggota';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['product'] = $this->model_laporan->get_product_financing();
		$this->load->view('core', $data);
	}

	public function jqgrid_list_premi_anggota()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'account_financing_no'; //1
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$branch_code = isset($_REQUEST['branch_code']) ? $_REQUEST['branch_code'] : '';
		$cm_code = isset($_REQUEST['cm_code']) ? $_REQUEST['cm_code'] : '';
		$financing_type = isset($_REQUEST['financing_type']) ? $_REQUEST['financing_type'] : '';
		$product_code = isset($_REQUEST['product_code']) ? $_REQUEST['product_code'] : '';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		if ($financing_type == 1) {
			$cm_code = '00000';
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_premi_anggota($branch_code, $cm_code, $product_code, $financing_type);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_premi_anggota($sidx, $sort, $limit_rows, $start, $branch_code, $cm_code, $product_code, $financing_type);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row) {
			$responce['rows'][$i]['account_financing_no'] = $row['account_financing_no'];
			$responce['rows'][$i]['cell'] = array(
				$row['account_financing_no'], $row['nama'], $row['cm_name'], $row['usia'], $row['p_nama'], $row['p_usia'], $row['pokok'], $row['droping_date'], $row['saldo_pokok'], $row['biaya_asuransi_jiwa']

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
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['product'] = $this->model_laporan->get_product_financing();
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}

	/****************************************************************************************/
	// END LIST REGISTRASI PEMBIAYAAN
	/****************************************************************************************/

	/* LAPORAN PAR atau AGING REPORT */
	public function laporan_par()
	{
		$data['container'] 		= 'anggota/aging_report';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['kreditur'] 		= $this->model_laporan->get_kreditur();
		$data['param_par'] 		= $this->model_laporan->get_param_par();
		$this->load->view('core', $data);
	}

	function get_tanggal_par()
	{
		$branch_code = $this->input->post('branch_code');
		$pars = $this->model_laporan->get_par($branch_code);
		echo json_encode($pars);
	}

	// BEGIN KEUANGAN BULANAN
	function keuangan_bulanan()
	{
		$data['container'] = 'laporan/keuangan_bulanan';
		$this->load->view('core', $data);
	}

	function keuangan_bulanan_p1()
	{
		$data['container'] = 'laporan/keuangan_bulanan_p1';
		$this->load->view('core', $data);
	}

	function keuangan_bulanan_p2()
	{
		$data['container'] = 'laporan/keuangan_bulanan_p2';
		$this->load->view('core', $data);
	}

	function get_tanggal_closing()
	{
		$branch_code = $this->input->post('branch_code');
		$close = $this->model_laporan->get_tanggal_closing($branch_code);
		echo json_encode($close);
	}

	// BEGIN NERACA LABA RUGI TEMP
	function neraca_lr_temp()
	{
		$data['container'] = 'laporan/neraca_lr_temp';
		$this->load->view('core', $data);
	}

	function neraca_lr_temp_2()
	{
		$data['container'] = 'laporan/neraca_lr_temp_2';
		$this->load->view('core', $data);
	}

	/****************************************************************************************/
	// BEGIN KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/

	public function kartu_pengawasan_angsuran()
	{
		$data['container'] = 'laporan/kartu_pengawasan_angsuran';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}

	public function get_kartu_pengawasan_angsuran_by_account_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_laporan->get_kartu_pengawasan_angsuran_by_account_no($account_financing_no);
		if (count($data) > 0) {
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
		$user_id = $this->session->userdata('user_id');
		$datas = $this->model_laporan->get_row_pembiayaan_by_account_no($account_financing_no);
		$fn = $this->model_laporan->fn_insert_kpa_tmp($account_financing_no, $financing_type, $user_id);

		$html = '';
		$no = 1;
		$tgl_angsur = '';

		foreach ($datas as $data) {
			$jumlah_angsur = $data['jumlah_angsuran'];
			$pokok = $data['pokok'];
			$margin = $data['margin'];
			$catab = 0;

			for ($i = 0; $i < $data['jangka_waktu']; $i++) {

				if ($i == 0) {
					$tgl_angsur = $data['tanggal_mulai_angsur'];
				} else {
					if ($data['periode_jangka_waktu'] == 0) {
						$tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 1 day"));
					} else if ($data['periode_jangka_waktu'] == 1) {
						$tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 7 day"));
					} else if ($data['periode_jangka_waktu'] == 2) {
						$tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 1 month"));
					} else if ($data['periode_jangka_waktu'] == 3) {
						$tgl_angsur = $data['tgl_jtempo'];
					}

					if ($data['periode_jangka_waktu'] != '2') {
						$iJto = 1;
						do {
							$cekHariLibur = $this->model_laporan->cek_libur($tgl_angsur);

							if ($cekHariLibur == TRUE) {
								if ($data['periode_jangka_waktu'] == '0') {
									$tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 1 day"));
								} else if ($data['periode_jangka_waktu'] == '1') {
									$tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 7 day"));
								} else if ($data['periode_jangka_waktu'] == '2') {
									$tgl_angsur = $tgl_angsur;
								} else if ($data['periode_jangka_waktu'] == '3') {
									$tgl_angsur = $data['tgl_jtempo'];
								}

								$iJto++;
							} else {
								break;
							}
						} while ($iJto > 1);
					}
				}

				$pokok -= $data['angsuran_pokok'];
				$margin -= $data['angsuran_margin'];
				$catab += $data['angsuran_catab'];

				$historycm = $this->model_laporan->get_history_cm_trx_date_by_account_financing_no($account_financing_no, $no, $financing_type, $tgl_angsur);

				$tgl_bayar = (isset($historycm['trx_date'])) ? (date('d-m-Y', strtotime($historycm['trx_date']))) : '';
				$validasi = (isset($historycm['validasi'])) ? ($historycm['validasi']) : '';

				$html .= '<tr>
	              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">' . date("d-m-Y", strtotime($tgl_angsur)) . '</td>
	              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">' . $tgl_bayar . '</td>
	              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">' . $no . '</td>
	              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">' . number_format($jumlah_angsur, 0, ',', '.') . '</td>
	              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">' . number_format($pokok, 0, ',', '.') . '</td>
	              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">' . number_format($margin, 0, ',', '.') . '</td>
	              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">' . number_format($catab, 0, ',', '.') . '</td>
	              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">' . $validasi . '</td>
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

	function proyeksi_realisasi_angsuran()
	{
		$data['container'] = 'laporan/proyeksi_realisasi_angsuran';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['produk'] = $this->model_laporan->get_produk_pembiayaan_kelompok();
		$this->load->view('core', $data);
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
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
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
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}

	public function rekap_outstanding_piutang_p()
	{
		$data['container'] = 'laporan/rekap_outstanding_piutang_p';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}

	function rekap_outstanding_bulan_lalu()
	{
		$data['container'] = 'laporan/rekap_outstanding_bulan_lalu';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['tanggal'] = $this->model_laporan->show_tanggal_closing();
		$this->load->view('core', $data);
	}

	public function rekap_sebaran_anggota()
	{
		$data['container'] = 'laporan/rekap_sebaran_anggota';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
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
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}

	public function rekap_pengajuan_p()
	{
		$data['container'] = 'laporan/rekap_pengajuan_p';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}
	/****************************************************************************************/
	// END LAPORAN REKAP PENGAJUAN
	/****************************************************************************************/

	/****************************************************************************************/
	// BEGIN LAPORAN REKAP PELUNASAN
	/****************************************************************************************/

	public function rekap_pelunasan_pembiayaan()
	{
		$data['container'] = 'laporan/rekap_pelunasan_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}
	/****************************************************************************************/
	// END LAPORAN REKAP PELUNASAN
	/****************************************************************************************/

	/****************************************************************************************/
	// BEGIN LAPORAN PENCARIAN PEMBIAYAAN
	/****************************************************************************************/

	public function list_pencairan_pembiayaan()
	{
		$data['container'] = 'laporan/list_pencairan_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}
	/****************************************************************************************/
	// END LAPORAN PENCARIAN PEMBIAYAAN
	/****************************************************************************************/


	function rekap_target_realisasi()
	{
		$data['container'] 		= 'laporan/rekap_target_realisasi';
		$data['jenistarget'] 	= $this->model_laporan->get_targetcabang();
		$data['tahuntarget'] 	= $this->model_laporan->get_tahuntarget();
		$this->load->view('core', $data);
	}

	function rekap_target_realisasi_p1()
	{
		$data['container'] 		= 'laporan/rekap_target_realisasi_p1';
		$data['jenistarget'] 	= $this->model_laporan->get_targetcabang_p1();
		$data['tahuntarget'] 	= $this->model_laporan->get_tahuntarget();
		$this->load->view('core', $data);
	}

	function rekap_target_realisasi_p2()
	{
		$data['container'] 		= 'laporan/rekap_target_realisasi_p2';
		$data['jenistarget'] 	= $this->model_laporan->get_targetcabang_p2();
		$data['tahuntarget'] 	= $this->model_laporan->get_tahuntarget();
		$this->load->view('core', $data);
	} 

	function rekap_target_realisasi_p3()
	{
		$data['container'] 		= 'laporan/rekap_target_realisasi_p3';
		$data['jenistarget'] 	= $this->model_laporan->get_targetcabang_p3();
		$data['tahuntarget'] 	= $this->model_laporan->get_tahuntarget();
		$this->load->view('core', $data);
	}

	function rekap_target_realisasi_p4()
	{
		$data['container'] 		= 'laporan/rekap_target_realisasi_p4';
		$data['jenistarget'] 	= $this->model_laporan->get_targetcabang_p4();
		$data['tahuntarget'] 	= $this->model_laporan->get_tahuntarget();
		$this->load->view('core', $data);
	}



	function grafik_target_realisasi_proses()
	{
		$branch_code  = $this->input->post('branch_code');
		$jenistarget  = $this->input->post('jenistarget');
		$tahuntarget  = $this->input->post('tahuntarget');

		$get_graphic = $this->model_laporan_to_pdf->export_rekap_target_realisasi($branch_code, $jenistarget, $tahuntarget);
		$branch_graph = $this->model_laporan->get_branch_by_code($branch_code);

		$view = array();

		$i = 1;

		foreach ($get_graphic as $gg) {
			$keterangan = $gg['keterangan'];
			$b1 = $gg['b1'] * 1;
			$b2 = $gg['b2'] * 1;
			$b3 = $gg['b3'] * 1;
			$b4 = $gg['b4'] * 1;
			$b5 = $gg['b5'] * 1;
			$b6 = $gg['b6'] * 1;
			$b7 = $gg['b7'] * 1;
			$b8 = $gg['b8'] * 1;
			$b9 = $gg['b9'] * 1;
			$b10 = $gg['b10'] * 1;
			$b11 = $gg['b11'] * 1;
			$b12 = $gg['b12'] * 1;

			if ($i == 1) {
				$color = '#55BBDD';
			} else {
				$color = '#FF0000';
			}

			$view[] = array(
				'name' => $keterangan,
				'data' => array($b1, $b2, $b3, $b4, $b5, $b6, $b7, $b8, $b9, $b10, $b11, $b12),
				'color' => $color
			);

			$i++;
		}
		$data['container'] = 'laporan/rekap_grafik_target_realisasi';
		$data['title'] = 'Grafik Target Realisasi';
		$data['branch_code'] = $branch_code;
		$data['branch_name'] = $branch_graph['branch_name'];
		$data['branch_id'] = $branch_graph['branch_id'];
		$data['jenistarget'] = $this->model_laporan->get_targetcabang();
		$data['jenis_target'] = $jenistarget;
		$data['tahuntarget'] = $this->model_laporan->get_tahuntarget();
		$data['tahun_target'] = $tahuntarget;
		$data['graphic'] = $get_graphic;
		$data['detail'] = json_encode($view);

		$this->load->view('core', $data);
	}



	/****************************************************************************************/
	// BEGIN LAPORAN REKAP PENCARIAN PEMBIAYAAN
	public function rekap_pencairan_pembiayaan()
	{
		$data['container'] = 'laporan/rekap_pencairan_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kecamatan'] = $this->model_laporan->get_kecamatan();
		$this->load->view('core', $data);
	} 

	public function rekap_pencairan_pembiayaan_p()
	{
		$data['container'] = 'laporan/rekap_pencairan_pembiayaan_p';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kecamatan'] = $this->model_laporan->get_kecamatan();
		$this->load->view('core', $data);
	}

	// END LAPORAN REKAP PENCARIAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/
	// BEGIN LAPORAN REKAP ANGGOTA KELUAR 
	public function rekap_anggota_keluar_p()
	{
		$data['container'] = 'laporan/rekap_anggota_keluar_p';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kecamatan'] = $this->model_laporan->get_kecamatan();
		$this->load->view('core', $data);
	}
	// END LAPORAN REKAP PENCARIAN PEMBIAYAAN
	/****************************************************************************************/ 

		/****************************************************************************************/
	// BEGIN LAPORAN REKAP ANGGOTA KELUAR 
	public function rekap_anggota_keluar()
	{
		$data['container'] = 'laporan/rekap_anggota_keluar';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kecamatan'] = $this->model_laporan->get_kecamatan();
		$this->load->view('core', $data);
	}
	// END LAPORAN REKAP PENCARIAN PEMBIAYAAN
	/****************************************************************************************/


	public function rekap_anggota_masuk()
	{
		$data['container'] = 'laporan/rekap_anggota_masuk';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kecamatan'] = $this->model_laporan->get_kecamatan();
		$this->load->view('core', $data);
	}



	/****************************************************************************************/
	// BEGIN LAPORAN REKAP CASHFLOW_TRANSAKSI_REMBUG
	public function rekap_cashflow_transaksi_rembug()
	{
		$data['container'] = 'laporan/rekap_cashflow_transaksi_rembug';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['trx_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
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
		$data['trx_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
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
		$data['trx_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
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
		$data['trx_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}

	public function list_saldo_anggota()
	{
		$data['container'] = 'laporan/list_saldo_anggota';
		$data['title'] = 'List Saldo Anggota';
		$data['trx_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}


	public function list_saldo_tbg()
	{
		$data['container'] = 'laporan/list_saldo_tbg';
		$data['title'] = 'List Saldo Tabungan';
		$data['trx_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}

	function list_anggota_keluar()
	{
		$data['container'] = 'laporan/list_anggota_keluar';
		$data['title'] = 'List Anggota Keluar';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['alasan'] = $this->model_kelompok->get_keterangan_keluar();
		$this->load->view('core', $data);
	}

	function list_anggota_mutasi()
	{
		$data['container'] = 'laporan/list_anggota_mutasi';
		$data['title'] = 'List Mutasi Anggota';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['alasan'] = $this->model_kelompok->get_keterangan_keluar();
		$this->load->view('core', $data);
	}

	function list_anggota_masuk()
	{
		$data['container'] = 'laporan/list_anggota_masuk';
		$data['title'] = 'List Anggota Masuk';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}

	function list_anggota_absen()
	{
		$data['container'] = 'laporan/list_anggota_absen';
		$data['title'] = 'List Kehadiran Anggota';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}

	function lembar_absen_anggota()
	{
		$data['container'] = 'laporan/lembar_absen_anggota';
		$data['title'] = 'Lembar Absen Anggota';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
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
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
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
		$this->load->view('core', $data);
	}

	function rekap_saldo_tabungan()
	{
		$data['container'] 	= 'laporan/rekap_saldo_tabungan';
		$data['produk'] 	= $this->model_laporan->get_all_produk_tabungan();
		$this->load->view('core', $data);
	}
	/****************************************************************************************/
	// END LIST SALDO TABUNGAN
	/****************************************************************************************/

	function rekap_saldo_tabungan_lalu()
	{
		$data['container'] 	= 'laporan/rekap_saldo_tabungan_lalu';
		$data['tanggal'] = $this->model_laporan->show_tanggal_closing();
		$data['produk'] 	= $this->model_laporan->get_all_produk_tabungan();
		$this->load->view('core', $data);
	}


	/****************************************************************************************/
	// BEGIN LIST BLOKIR TABUNGAN
	/****************************************************************************************/

	public function list_blokir_tabungan()
	{
		$data['container'] 		= 'laporan/list_blokir_tabungan';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
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
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
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
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
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
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
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
		$data['majelis']		= $this->model_laporan->get_majelis();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
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
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}

	public function setup_margin()
	{
		$data['container'] 	= 'laporan/setup_margin';
		$this->load->view('core', $data);
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
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['produk'] 	= $this->model_laporan->get_all_produk_deposito();
		$this->load->view('core', $data);
	}

	public function list_saldo_deposito()
	{
		$data['container'] 	= 'laporan/list_saldo_deposito';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['produk'] 	= $this->model_laporan->get_all_produk_deposito();
		$this->load->view('core', $data);
	}

	public function list_pencairan_deposito()
	{
		$data['container'] 		= 'laporan/list_pencairan_deposito';
		$data['produk'] 	= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}

	public function list_rekap_pembukaan()
	{
		$data['container'] 		= 'laporan/list_rekap_pembukaan';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}

	public function rekap_outstanding()
	{
		$data['container'] 		= 'laporan/rekap_outstanding';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}

	public function rekap_bagi_hasil()
	{
		$data['container'] 		= 'laporan/rekap_bagi_hasil';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}

	public function rekap_history()
	{
		$data['container'] 		= 'laporan/rekap_history';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
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
		$aColumns = array('', 'trx_date', 'nama', 'account_saving_no', 'flag_debit_credit', 'saldo_riil', 'username', '');
		$no_rek   = @$_GET['no_rek'];
		$tanggal  = @$_GET['tanggal'];
		$tanggal2 = @$_GET['tanggal2'];
		$date1    = $this->datepicker_convert(true, $tanggal);
		$date2    = $this->datepicker_convert(true, $tanggal2);

		/* 
		 * Paging
		 */
		$sLimit = "";
		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = " OFFSET " . intval($_GET['iDisplayStart']) . " LIMIT " .
				intval($_GET['iDisplayLength']);
		}

		/*
		 * Ordering
		 */
		$sOrder = "";
		if (isset($_GET['iSortCol_0'])) {
			$sOrder = "ORDER BY  ";
			for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
				if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
					$sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
						($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
				}
			}

			$sOrder = substr_replace($sOrder, "", -2);
			if ($sOrder == "ORDER BY") {
				$sOrder = "";
			}
		}

		/* 
		 * Filtering
		 */
		$sWhere = "";
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
			$sWhere = "WHERE (";
			for ($i = 0; $i < count($aColumns); $i++) {
				if ($aColumns[$i] != '')
					$sWhere .= "LOWER(CAST(" . $aColumns[$i] . " AS VARCHAR)) LIKE '%" . strtolower($_GET['sSearch']) . "%' OR ";
			}
			$sWhere = substr_replace($sWhere, "", -3);
			$sWhere .= ')';
		}

		if ($sWhere == "") {
			if ($no_rek != "" or ($tanggal != "" && $tanggal2 != "")) {
				$sWhere = 'WHERE ';
				if ($no_rek != "") {
					$sWhere .= " mfi_trx_account_saving.account_saving_no = '" . $no_rek . "' ";
				}
				if ($date1 != "" && $date2 != "") {
					if ($no_rek != "") {
						$sWhere .= " AND ";
					}
					$sWhere .= " mfi_trx_account_saving.trx_date BETWEEN '" . $date1 . "' AND '" . $date2 . "' ";
				}
				// $sWhere = " WHERE mfi_trx_account_saving.account_saving_no = '".$no_rek."' AND mfi_trx_account_saving.trx_date BETWEEN '".$date1."' AND '".$date2."' ";
			}
		} else {
			if ($no_rek != "") {
				$sWhere .= " AND mfi_trx_account_saving.account_saving_no = '" . $no_rek . "' ";
			}
			if ($date1 != "" && $date2 != "") {
				$sWhere .= "  AND mfi_trx_account_saving.trx_date BETWEEN '" . $date1 . "' AND '" . $date2 . "' ";
			}
			// $sWhere .= " AND mfi_trx_account_saving.account_saving_no = '".$no_rek."' AND mfi_trx_account_saving.trx_date BETWEEN '".$tanggal."' AND '".$tanggal2."' ";
		}

		/* Individual column filtering */
		for ($i = 0; $i < count($aColumns); $i++) {
			if ($aColumns[$i] != '') {
				if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
					if ($sWhere == "") {
						$sWhere = "WHERE ";
					} else {
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(" . $aColumns[$i] . " AS VARCHAR)) LIKE '%" . strtolower($_GET['sSearch_' . $i]) . "%' ";
				}
			}
		}

		$rResult 			= $this->model_laporan->datatable_rekening_buku_tabungan_setup($sWhere, $sOrder, $sLimit); // query get data to view
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

		foreach ($rResult as $aRow) {
			$row = array();
			$row[] = '<input type="checkbox" value="' . $aRow['trx_account_saving_id'] . '" id="checkbox[]" name="checkbox[]" class="checkboxes" >';
			$row[] = $aRow['trx_date'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['account_saving_no'];
			$row[] = $aRow['flag_debit_credit'];
			$row[] = $aRow['saldo_riil'];
			$row[] = $this->session->userdata('username');

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
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
		if ($trx_account_saving_id == "") {
			echo "<script>alert('Please select some row to print !');window.close();</script>";
		} else {

			ob_start();

			$config['full_tag_open']    = '<p>';
			$config['full_tag_close']   = '</p>';

			$data['cetak_buku'] = array();
			for ($i = 0; $i < count($trx_account_saving_id); $i++) {
				$data['cetak_buku'][] = $this->model_laporan->export_cetak_trans_buku($trx_account_saving_id[$i]);
			}
			$data['margin'] = $this->model_laporan->get_margin($institution_name);

			$this->load->view('laporan/export_cetak_trans_buku', $data);

			$content = ob_get_clean();

			try {
				$html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
				$html2pdf->pdf->SetDisplayMode('fullpage');
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output('BUKU-TRANSAKSI-REK-TABUNGAN.pdf');
			} catch (HTML2PDF_exception $e) {
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
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		//$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
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
		$data['current_date'] 	= $this->format_date_detail($this->current_date(), 'id', false, '/');
		//$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
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
		$this->load->view('core', $data);
	}

	function datatable_cetak_voucher()
	{
		$from_date = $this->datepicker_convert(true, $this->input->get('from_date'), '/');
		$to_date = $this->datepicker_convert(true, $this->input->get('to_date'), '/');
		$voucher_ref = $this->input->get('voucher_ref');
		$voucher_no = $this->input->get('voucher_no');
		$jurnal_trx_type = $this->input->get('jurnal_trx_type');
		$branch_code = $this->input->get('branch_code');
		$from_date = ($from_date == '') ? '' : $from_date;
		$to_date = ($to_date == '') ? '' : $to_date;
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('mfi_trx_gl.trx_date', 'mfi_trx_gl.voucher_no', 'mfi_trx_gl.voucher_ref', '', 'total_debit', 'total_credit', '');
		/* 
		 * Paging
		 */
		$sLimit = "";
		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = " OFFSET " . intval($_GET['iDisplayStart']) . " LIMIT " .
				intval($_GET['iDisplayLength']);
		}

		/*
		 * Ordering
		 */
		$sOrder = "";
		if (isset($_GET['iSortCol_0'])) {
			$sOrder = "ORDER BY  ";
			for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
				if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
					$sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
						($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
				}
			}

			$sOrder = substr_replace($sOrder, "", -2);
			if ($sOrder == "ORDER BY") {
				$sOrder = "";
			}
		}

		/* 
		 * Filtering
		 */
		$sWhere = "";
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
			$sWhere = " AND (";
			for ($i = 0; $i < count($aColumns); $i++) {
				if ($aColumns[$i] != '')
					$sWhere .= "LOWER(" . $aColumns[$i] . ") LIKE '%" . strtolower($_GET['sSearch']) . "%' OR ";
			}
			$sWhere = substr_replace($sWhere, "", -3);
			$sWhere .= ')';
		}

		/* Individual column filtering */
		for ($i = 0; $i < count($aColumns); $i++) {
			if ($aColumns[$i] != '') {
				if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
					if ($sWhere == "") {
						$sWhere = " AND ";
					} else {
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(" . $aColumns[$i] . ") LIKE '%" . strtolower($_GET['sSearch_' . $i]) . "%' ";
				}
			}
		}

		$dWhere['from_date'] 	= $from_date;
		$dWhere['to_date'] 		= $to_date;
		$dWhere['voucher_ref'] 	= $voucher_ref;
		$dWhere['voucher_no'] 	= $voucher_no;
		$dWhere['branch_code'] 	= $branch_code;
		$dWhere['jurnal_trx_type'] 	= $jurnal_trx_type;

		$rResult 			= $this->model_laporan->datatable_cetak_voucher($dWhere, $sWhere, $sOrder, $sLimit); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_cetak_voucher($dWhere, $sWhere); // get number of filtered data
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

		foreach ($rResult as $aRow) {
			$row = array();
			$row[] = '<div align="center">' . date('d-m-Y', strtotime($aRow['trx_date'])) . '</div>';
			$row[] = '<div align="center">' . $aRow['voucher_no'] . '</div>';
			$row[] = $aRow['voucher_ref'];
			$row[] = $aRow['description'];
			$row[] = '<div align="right">' . number_format($aRow['total_debit'], 0, ',', '.') . '</div>';
			$row[] = '<div align="right">' . number_format($aRow['total_credit'], 0, ',', '.') . '</div>';
			$row[] = '<div align="center" style="white-space:nowrap"><a href="javascript:void(0);" id="btn-cetakvoucher" class="btn mini green" style="white-space:nowrap" trx_gl_id="' . $aRow['trx_gl_id'] . '"><i class="icon-print"></i> Cetak</a></div>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}

	public function get_data_cetak_voucher()
	{
		$trx_gl_id = $this->input->post('trx_gl_id');
		$data['trx_gl'] = $this->model_laporan->get_trx_gl_by_id($trx_gl_id);
		$data['trx_gl']['trx_date'] = $this->format_date_detail(substr($data['trx_gl']['trx_date'], 0, 10), 'id', false, '-');
		$data['trx_gl_detail'] = $this->model_laporan->get_trx_gl_detail_by_trx_gl_id($trx_gl_id);
		echo json_encode($data);
	}

	/* REKAP SALDO ANGGOTA */

	public function rekap_saldo_anggota()
	{
		$data['container'] = 'laporan/rekap_saldo_anggota';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}

	public function rekap_saldo_anggota_p()
	{
		$data['container'] = 'laporan/rekap_saldo_anggota_p';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}


	/* REKAP TRANSAKSI REMBUG */

	public function rekap_transaksi_rembug()
	{
		$data['container'] = 'laporan/rekap_transaksi_rembug';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}

	/* LAPORAN JURNAL TRANSAKSI */
	public function jurnal_transaksi()
	{
		$data['container'] = 'laporan/jurnal_transaksi';
		$this->load->view('core', $data);
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
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}

	public function proses_hitung_kolektibilitas()
	{
		$branch_id = $this->uri->segment(3);
		$date = $this->uri->segment(4);
		$desc_date = substr($date, 0, 2) . '/' . substr($date, 2, 2) . '/' . substr($date, 4, 4);
		$date = substr($date, 4, 4) . '-' . substr($date, 2, 2) . '-' . substr($date, 0, 2);
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('user_id');
		if ($branch_id == "00000") {
			$branch_id = '';
		}
		$branch_data = $this->model_cif->get_branch_by_branch_id($branch_id);
		$branch_code = $branch_data['branch_code'];
		$branch_class = $branch_data['branch_class'];
		if ($branch_class == '3') {
			$sql_cek_par = "select count(*) as jum from mfi_par where tanggal_hitung=? and branch_code=?";
		} else {
			$sql_cek_par = "select count(*) as jum from mfi_par where tanggal_hitung=? and branch_code in (select branch_code from mfi_branch_member where branch_induk = ?)";
		}
		$query_cek_par = $this->db->query($sql_cek_par, array($date, $branch_code));
		$row_cek_par = $query_cek_par->row_array();

		if (count($row_cek_par) > 0) {
			$cek_par_exists = $row_cek_par['jum'];
		} else {
			$cek_par_exists = 0;
		}

		if ($branch_class < 2) {
			$this->session->set_flashdata('failed', 'Proses dibatalkan. Perhitungan Kolektibilitas hanya boleh digunakan oleh Unit/Cabang saja!');
		}
		// else if($cek_par_exists>0)
		// {
		// 	$this->session->set_flashdata('failed','Proses Hitung Dibatalkan! Perhitungan pernah dilakukan pada tanggal ini!');
		// }
		else {
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
			$this->db->query('delete from mfi_par where tanggal_hitung=? and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)', array($date, $branch_code));

			/*
			if(count($kolektibilitas)>0){
				$this->db->insert_batch('mfi_par',$kolektibilitas);
			}
			*/
			$insert = $this->model_laporan->fn_insert_par($branch_code, $date, $created_by, $created_date);

			if ($this->db->trans_status() === true) {
				$this->db->trans_commit();
				$this->session->set_flashdata('success', 'Proses Hitung Kolektibilitas SUKSES!');
			} else {
				$this->db->trans_rollback();
				$this->session->set_flashdata('failed', 'Something went wrong! please contact your administrator!');
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
		$this->load->view('core', $data);
	}

	function rekap_kolektibilitas_p()
	{
		$data['container'] = 'laporan/rekap_kolektibilitas_p';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['data_fa'] = $this->model_laporan->get_fa_by_branch();
		$data['data_cm'] = $this->model_laporan->get_cm_by_branch();
		$data['data_kol'] = $this->model_laporan->get_all_par();
		$data['tanggal'] = $this->model_laporan->get_tanggal_par();
		$this->load->view('core', $data);
	}

	function aging_report_schedulle()
	{
		$data['container'] = 'laporan/aging_report_schedulle';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['data_fa'] = $this->model_laporan->get_fa_by_branch();
		$data['data_cm'] = $this->model_laporan->get_cm_by_branch();
		$data['data_kol'] = $this->model_laporan->get_all_par();
		$data['tanggal'] = $this->model_laporan->get_tanggal_par();
		$this->load->view('core', $data);
	}

	function rekap_transaksi_individu()
	{
		$data['container'] = 'laporan/rekap_transaksi_individu';
		$this->load->view('core', $data);
	}

	function get_fa_by_branch()
	{
		$branch_code = $this->input->post('branch_code');
		$branch_class = $this->input->post('branch_class');
		$data = $this->model_laporan->get_fa_by_branch($branch_code, $branch_class);
		echo json_encode($data);
	}

	function get_cm_by_branch()
	{
		$branch_code = $this->input->post('branch_code');
		$branch_class = $this->input->post('branch_class');
		$data = $this->model_laporan->get_cm_by_branch($branch_code, $branch_class);
		echo json_encode($data);
	}
	function get_cm_by_fa()
	{
		$branch_code = $this->input->post('branch_code');
		$fa_code = $this->input->post('fa_code');
		$data = $this->model_laporan->get_cm_by_fa($branch_code, $fa_code);
		echo json_encode($data);
	}
	function get_cm_by_fa_code()
	{
		$fa_code = $this->input->post('fa_code');
		$data = $this->model_laporan->get_cm_by_fa_code($fa_code);
		echo json_encode($data);
	}

	/*
	| DATA LENGKAP PEMBIAYAAN
	*/
	function data_lengkap_pembiayaan()
	{
		$data['container'] = 'laporan/data_lengkap_pembiayaan';
		$data['title'] = 'Laporan Data Lengkap Pembiayaan';
		$this->load->view('core', $data);
	}

	/**
	 * MODUL : LAPORAN LABA RUGI RINCI
	 * @author Sayyid Nurkilah
	 */
	public function laba_rugi_rinci_gl()
	{
		$data['container'] = 'laporan/laba_rugi_rinci_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}
	public function laba_rugi_rinci_gl_v2()
	{
		$data['container'] = 'laporan/laba_rugi_rinci_gl_v2';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}
	public function neraca_rinci_gl()
	{
		$data['container'] = 'laporan/neraca_rinci_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}
	public function neraca_rinci_gl_v2()
	{
		$data['container'] = 'laporan/neraca_rinci_gl_v2';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}

	function list_angsuran_pembiayaan()
	{
		$branch_code = $this->session->userdata('branch_code');

		$data['container'] = 'laporan/list_angsuran_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['produk'] = $this->model_laporan->get_produk_pembiayaan_kelompok();
		$data['produk1'] = $this->model_laporan->get_produk_pembiayaan_individu();
		$data['rembug'] = $this->model_laporan->get_cm($branch_code);
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$data['fa_name_cm'] = ($this->session->userdata('fa_name_cm') == true) ? $this->session->userdata('fa_name_cm') : '';


		$this->load->view('core', $data);
	}

	function list_proyeksi_angsuran()
	{
		$branch_code = $this->session->userdata('branch_code');

		$data['container'] = 'laporan/list_proyeksi_angsuran';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['produk'] = $this->model_laporan->get_produk_pembiayaan_kelompok();
		$data['produk1'] = $this->model_laporan->get_produk_pembiayaan_individu();
		$data['rembug'] = $this->model_laporan->get_cm($branch_code);
		$data['kreditur'] = $this->model_laporan->get_kreditur();
		$data['fa_name_cm'] = ($this->session->userdata('fa_name_cm') == true) ? $this->session->userdata('fa_name_cm') : '';


		$this->load->view('core', $data);
	}

	public function ajax_get_cm_by_branch()
	{
		$branch_code = $this->input->post('branch_code');
		$rembug = $this->model_laporan->get_cm($branch_code);
		echo json_encode($rembug);
	}

	/*LAPORANS STATEMENT TAB.KELOMPOK*/
	function statement_tab_kelompok()
	{
		$data['title'] = 'Statement Tabungan Kelompok';
		$data['container'] = 'laporan/statement_tab_kelompok';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', FALSE, '/');
		$data['cms'] = $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}

	function statement_kehadiran()
	{
		$data['title'] = 'History Kehadiran Anggota ';
		$data['container'] = 'laporan/statement_kehadiran';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', FALSE, '/');
		$data['cms'] = $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}


	function get_cif_by_cm_code()
	{
		$cm_code = $this->input->post('cm_code');
		$data = $this->model_laporan->get_cif_by_cm_code($cm_code);
		echo json_encode($data);
	}

	function get_account_saving_by_cif_no()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_laporan->get_account_saving_by_cif_no($cif_no);
		echo json_encode($data);
	}

	function rekap_trx_rembug()
	{
		$data['container'] = 'laporan/rekap_trx_rembug';
		$data['petugass'] = $this->model_laporan->get_petugas();
		$this->load->view('core', $data);
	}

	function get_rembug_by_fa_branch()
	{
		$branch = $this->input->post('branch');

		$get = $this->model_cif->get_rembug_by_fa_branch($branch);

		$html = '<option value="" selected="selected">-- Pilih --</option>';
		$html .= '<option value="00000">SEMUA</option>';

		foreach ($get as $g) {
			$cm_code = $g['cm_code'];
			$cm_name = $g['cm_name'];

			$html .= '<option value="' . $cm_code . '">' . $cm_name . '</option>';
		}

		echo $html;
	}

	function get_peutgas_by_branch_code()
	{
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_laporan->get_peutgas_by_branch_code($branch_code);
		echo json_encode($data);
	}
	function get_cm_by_branch_id()
	{
		$branch_id = $this->input->post('branch_id');
		$sql = "select cm_code,cm_name from mfi_cm where branch_id=?";
		$query = $this->db->query($sql, array($branch_id));
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
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['produk'] 		= $this->model_laporan->get_all_produk_tabungan();
		//$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}


	/*sayyid*/
	function lembar_absensi_anggota()
	{
		$data['container'] = 'laporan/lembar_absensi_anggota';
		$this->load->view('core', $data);
	}



	/*
	| Laporan List Saldo Anggota
	| ujangirawan -- 13 Mei 2015
    */
	public function list_saldo_anggota_o()
	{
		$data['container'] = 'anggota/list_saldo_anggota';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kecamatan'] = $this->model_laporan->get_kecamatan();
		$this->load->view('core', $data);
	}

	public function rekap_jumlah_anggota()
	{
		$data['container'] = 'laporan/rekap_jumlah_anggota';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['kecamatan'] = $this->model_laporan->get_kecamatan();
		$this->load->view('core', $data);
	}



	public function export_pdf_saldo_anggota_kecamatan()
	{
		$tanggal1 = $this->uri->segment(3);
		$tanggal1__ = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
		$tanggal1_ = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
		$tanggal2 = $this->uri->segment(4);
		$tanggal2__ = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
		$tanggal2_ = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
		$cabang = $this->uri->segment(5);
		$kecamatan = $this->uri->segment(6);
		if ($cabang == false) {
			$cabang = "0000";
		} else {
			$cabang =   $cabang;
		}

		if ($tanggal1 == "") {
			echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
		} else if ($tanggal2 == "") {
			echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
		} else {
			$datas = $this->model_laporan->export_saldo_anggota_kecamatan($cabang, $tanggal1_, $tanggal2_, $kecamatan);
			ob_start();
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			$data['result'] = $datas;
			if ($cabang != '0000') {
				$data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
			} else {
				$data['cabang'] = "SEMUA CABANG";
			}
			$data['tanggal1_'] = $tanggal1__;
			$data['tanggal2_'] = $tanggal2__;
			$this->load->view('laporan/export_saldo_anggota_by_kecamatan', $data);
			$content = ob_get_clean();
			try {
				$html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
				$html2pdf->pdf->SetDisplayMode('fullpage');
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output('list_saldo_anggota"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
			} catch (HTML2PDF_exception $e) {
				echo $e;
				exit;
			}
		}
	}

	// Export Rekap Jumlah Anggota ///
	public function export_pdf_rekep_jumlah_anggota()
	{
		$cabang = $this->uri->segment(3);

		if ($cabang == false) {
			$cabang = "0000";
		} else {
			$cabang =   $cabang;
		}

		$datas = $this->model_laporan->export_rekap_jumlah_anggota($cabang);
		ob_start();
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$data['result'] = $datas;
		if ($cabang != '0000') {
			$data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
		} else {
			$data['cabang'] = "SEMUA CABANG";
		}
		$this->load->view('laporan/export_rekap_jumlah_anggota', $data);
		$content = ob_get_clean();
		try {
			$html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output('rekap_jumlah_anggota"' . $cabang . '".pdf');
		} catch (HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
	}
	// End Export Rekap Jumlah Anggota ///


	public function export_xls_saldo_anggota_kecamatan()
	{
		$tanggal1 = $this->uri->segment(3);
		$tanggal1__ = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
		$tanggal1_ = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
		$tanggal2 = $this->uri->segment(4);
		$tanggal2__ = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
		$tanggal2_ = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
		$cabang = $this->uri->segment(5);
		$kecamatan = $this->uri->segment(6);
		if ($cabang == false) {
			$cabang = "0000";
		} else {
			$cabang =   $cabang;
		}

		if ($tanggal1 == "") {
			echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
		} else if ($tanggal2 == "") {
			echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
		} else {
			$datas = $this->model_laporan->export_saldo_anggota_kecamatan($cabang, $tanggal1_, $tanggal2_, $kecamatan);
			if ($cabang != '0000') {
				$datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			} else {
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
			$objPHPExcel->getActiveSheet()->setCellValue('A1', strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2', "Cabang : " . $datacabang);
			$objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3', "List Saldo Anggota Berdasarkan Kecamatan");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:E4');
			$objPHPExcel->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A4', "Periode : " . $tanggal1__ . ' s/d ' . $tanggal2__);
			$objPHPExcel->getActiveSheet()->setCellValue('A6', "No");
			$objPHPExcel->getActiveSheet()->setCellValue('B6', "Kecamatan");
			$objPHPExcel->getActiveSheet()->setCellValue('C6', "Desa");
			$objPHPExcel->getActiveSheet()->setCellValue('D6', "Majelis");
			$objPHPExcel->getActiveSheet()->setCellValue('E6', "Jumlah");

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
			for ($i = 0; $i < count($datas); $i++) {
				$total_anggota += $datas[$i]['num'];
				$objPHPExcel->getActiveSheet()->setCellValue('A' . $ii, ($i + 1));
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $ii, $datas[$i]['kecamatan']);
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $ii, $datas[$i]['desa']);
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $ii, $datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $ii, number_format($datas[$i]['num'], 0, ',', '.') . ' ');

				$objPHPExcel->getActiveSheet()->getStyle('A' . $ii . ':A' . $ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B' . $ii . ':B' . $ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C' . $ii . ':C' . $ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D' . $ii . ':D' . $ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E' . $ii . ':E' . $ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A' . $ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E' . $ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B' . $ii . ':D' . $ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('A' . $ii . ':E' . $ii)->getFont()->setSize(10);
				$ii++;
			} //END FOR

			$iii = count($datas) + 8;
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $iii, " " . number_format($total_anggota, 0, ',', '.') . ' ');

			$objPHPExcel->getActiveSheet()->getStyle('E' . $iii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C' . $iii . ':E' . $iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $iii . ':E' . $iii)->getFont()->setSize(10);
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

	function distribusi_shu()
	{
		$data['container'] = 'laporan/distribusi_shu';
		$this->load->view('core', $data);
	}

	function laporan_bagihasil()
	{
		$data['container'] = 'laporan/laporan_bagihasil';
		$this->load->view('core', $data);
	}

	public function rekap_angsuran()
	{
		$data['container'] = 'laporan/rekap_angsuran';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}

	public function jqgrid_list_transaksi_rembug()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'trx_date';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		// $tanggal = date('Y-m-d');
		$branch_code = isset($_REQUEST['branch_code']) ? $_REQUEST['branch_code'] : '';
		$fa_code = isset($_REQUEST['fa_code']) ? $_REQUEST['fa_code'] : '';
		$cm_code = isset($_REQUEST['cm_code']) ? $_REQUEST['cm_code'] : '';
		$from_date = isset($_REQUEST['awal_trx_date']) ? $_REQUEST['awal_trx_date'] : '';
		$thru_date = isset($_REQUEST['akhir_trx_date']) ? $_REQUEST['akhir_trx_date'] : '';
		$from_date = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
		$thru_date = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$result = $this->model_laporan_to_pdf->jqgrid_list_transaksi_rembug('', '', '', '', $branch_code, $cm_code, $from_date, $thru_date, $fa_code);

		$count = count($result);
		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_transaksi_rembug($sidx, $sort, $limit_rows, $start, $branch_code, $cm_code, $from_date, $thru_date, $fa_code);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row) {
			$responce['rows'][$i]['cm_code'] = $row['cm_code'];
			$responce['rows'][$i]['cell'] = array(
				$row['cm_code'], $row['trx_date'], $row['cm_name'], $row['fa_name'], $row['setoran'], $row['penarikan'], $row['status_verifikasi']
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
		$data['trx_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}

	function list_rekap_sebaran_anggota()
	{
		$branch = $_GET['branch'];
		$city = $_GET['city'];

		$aColumns = array('mpc.city_code', 'mpc.city', 'kecamatan', 'desa', 'majelis', 'anggota');

		/* 
		 * Paging
		 */
		$sLimit = "";
		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = " OFFSET " . intval($_GET['iDisplayStart']) . " LIMIT " .
				intval($_GET['iDisplayLength']);
		}

		/*
		 * Ordering
		 */
		$sOrder = "";
		if (isset($_GET['iSortCol_0'])) {
			$sOrder = "ORDER BY  ";
			for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
				if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
					$sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
						($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
				}
			}

			$sOrder = substr_replace($sOrder, "", -2);
			if ($sOrder == "ORDER BY") {
				$sOrder = "";
			}
		}

		/* 
		 * Filtering
		 */

		$sWhere = "";
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
			$sWhere = "AND (";
			for ($i = 0; $i < count($aColumns); $i++) {
				if ($aColumns[$i] != '')
					$sWhere .= "LOWER(CAST(" . $aColumns[1] . " AS VARCHAR)) LIKE '%" . strtolower($_GET['sSearch']) . "%' OR ";
			}
			$sWhere = substr_replace($sWhere, "", -3);
			$sWhere .= ')';
		}

		/* Individual column filtering */
		for ($i = 0; $i < count($aColumns); $i++) {
			if ($aColumns[$i] != '') {
				if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
					if ($sWhere == "") {
						$sWhere = "AND ";
					} else {
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(" . $aColumns[$i] . " AS VARCHAR)) LIKE '%" . strtolower($_GET['sSearch_' . $i]) . "%' ";
				}
			}
		}

		$rResult = $this->model_laporan->export_rekap_sebaran_anggota($sWhere, $sOrder, $sLimit, $branch, $city);
		$rResultFilterTotal = $this->model_laporan->export_rekap_sebaran_anggota($sWhere, '', '', $branch, $city);
		$iFilteredTotal = count($rResultFilterTotal);
		$rResultTotal = $this->model_laporan->export_rekap_sebaran_anggota('', '', '', $branch, $city);
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

		foreach ($rResult as $aRow) {
			$row = array();

			$kode = $aRow['city_code'];
			$kota = $aRow['city'];
			$kecamatan = $aRow['kecamatan'];
			$desa = $aRow['desa'];
			$majelis = $aRow['majelis'];
			$anggota = $aRow['anggota'];

			$row[] = '<center>' . $kode . '</center>';
			$row[] = '<center>' . $kota . '</center>';
			$row[] = '<center>' . $kecamatan . '</center>';
			$row[] = '<center>' . $desa . '</center>';
			$row[] = '<center>' . $majelis . '</center>';
			$row[] = '<center>' . $anggota . '</center>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}

	function list_bagihasil()
	{
		$data['container'] = 'laporan/list_bagihasil';
		$this->load->view('core', $data);
	}

	function list_bahas_shu()
	{
		$data['container'] = 'laporan/list_bahas_shu';
		$this->load->view('core', $data);
	}

	function get_all_produk()
	{
		$financing = $this->input->post('financing');
		if ($financing == '1') {
			$financing = '0';
		} else if ($financing == '0') {
			$financing = '1';
		}
		$pars = $this->model_laporan->get_all_produk($financing);
		$html = "";
		$html .= '<option value="" selected="selected">Pilih</option>';
		$html .= '<option value="00000">SEMUA</option>';

		foreach ($pars as $produk) {
			$product_code = $produk['product_code'];
			$product_name = $produk['product_name'];
			$html .= '<option value="' . $product_code . '">' . $product_name . '</option>';
		}
		echo $html;
	}

	/****************************************************************************************/
	// BEGIN REPORT LIST ANGGOTA BULAN LALU
	/****************************************************************************************/
	function list_anggota_bulan_lalu()
	{
		$data['container'] = 'laporan/list_anggota_bulan_lalu';
		$data['product'] = $this->model_laporan->get_product_financing();
		$data['peruntukan'] = $this->model_laporan->show_peruntukan('peruntukan');
		$data['sektor'] = $this->model_laporan->show_peruntukan('sektor_ekonomi');
		$data['tanggal'] = $this->model_laporan->show_tanggal_closing();
		$this->load->view('core', $data);
	}

	function jqgrid_list_anggota_bulan_lalu()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'account_financing_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$tanggal = date('Y-m-d');
		$cabang = $_REQUEST['branch_code'];
		$petugas = $_REQUEST['fa_code'];
		$majelis = $_REQUEST['cm_code'];
		// $pembiayaan = $_REQUEST['financing_type'];
		// $product_code = $_REQUEST['product_code'];
		// $peruntukan = $_REQUEST['peruntukan'];
		// $sektor = $_REQUEST['sektor'];
		$tanggal = $_REQUEST['tanggal'];

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		// if($pembiayaan == 1){
		//     $majelis = '00000';
		//     $petugas = '00000';
		// }

		$count = $this->model_laporan_to_pdf->jqgrid_count_anggota_bulan_lalu($cabang, $majelis, $petugas, $tanggal);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_anggota_bulan_lalu($sidx, $sort, $limit_rows, $start, $cabang, $majelis, $petugas, $tanggal, $tanggal);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {

			$cif_no 			= $row['cif_no'];
			$nama 				= $row['nama'];
			$majelis 			= $row['cm_name'];
			$desa 				= $row['desa'];
			$pokok 				= number_format($row['pokok'], 0, ',', '.');
			$margin 			= number_format($row['margin'], 0, ',', '.');
			// $setoran_lwk 		= number_format($row['setoran_lwk'],0,',','.');
			// $tabungan_minggon 	= number_format($row['tabungan_minggon'],0,',','.');
			// $tabungan_kelompok 	= number_format($row['tabungan_kelompok'],0,',','.');
			// $tabungan_sukarela 	= number_format($row['tabungan_sukarela'],0,',','.');
			$saldo_pokok 		= number_format($row['saldo_pokok'], 0, ',', '.');
			$saldo_margin 		= number_format($row['saldo_margin'], 0, ',', '.');
			$saldo_catab 		= number_format($row['saldo_catab'], 0, ',', '.');
			$saldo_tabber 		= number_format($row['saldo_tabber'], 0, ',', '.');

			// $cif_no = $row['cif_no'];
			// $nama = $row['nama'];

			$saldo_tab_sukarela = number_format($row['saldo_tab_sukarela'], 0, ',', '.');
			$saldo_tab_wajib = number_format($row['saldo_tab_wajib'], 0, ',', '.');
			$saldo_tab_kelompok = number_format($row['saldo_tab_kelompok'], 0, ',', '.');

			$responce['rows'][$i]['cif_no'] = $cif_no;
			$responce['rows'][$i]['cell'] = array($cif_no, $nama, $majelis, $desa, $pokok, $margin, $saldo_tab_wajib, $saldo_tab_kelompok, $saldo_tab_sukarela, $saldo_pokok, $saldo_margin, $saldo_catab, $saldo_tabber);

			$i++;
		}

		echo json_encode($responce);
	}
	/****************************************************************************************/
	// END REPORT LIST ANGGOTA BULAN LALU
	/****************************************************************************************/

	// 
	// GRID LIST PENGAJUAN PEMBIAYAAN 
	// 

	function jqgrid_list_pengajuan_pembiayaan()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		// $tanggal = date('Y-m-d');
		// $tanggal2 = date('Y-m-d');
		$cabang = $_REQUEST['branch_code'];
		$petugas = $_REQUEST['fa_code'];
		$majelis = $_REQUEST['cm_code'];
		$pembiayaan = $_REQUEST['financing_type'];

		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		// echo"<pre>";
		// print_r($from);
		// echo"<br>";
		// print_r($thru);
		// echo"<br>";
		// print_r($majelis);
		// echo"<br>";
		// print_r($pembiayaan);
		// echo"<br>";

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		if ($pembiayaan == 1) {
			$jenis = 'Individu';
			$jenis2 = strtoupper($jenis);
		} else if ($pembiayaan == 0) {
			$jenis = 'Kelompok';
			$jenis2 = strtoupper($jenis);
		} else {
			$jenis = 'Semua';
			$jenis2 = strtoupper($jenis);
		}


		if ($pembiayaan == 1) {
			$majelis = '00000';
			$petugas = '00000';
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_pengajuan_pembiayaan($cabang, $pembiayaan, $majelis, $petugas, $tanggal, $tanggal2);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_pengajuan_pembiayaan($sidx, $sort, $limit_rows, $start, $cabang, $pembiayaan, $majelis, $petugas, $tanggal, $tanggal2);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {

			$rekening = $row['registration_no'];
			$nama = $row['nama'];
			$rembug = $row['cm_name'];
			$jenis2 = $row['financing_type'];
			$tanggal_pengajuan = $row['tanggal_pengajuan'];
			$rencana_droping = $row['rencana_droping'];
			$amount = $row['amount'];
			$status = $row['status'];

			if ($pembiayaan == 1) {
				$jenis = 'Individu';
				$jenis2 = strtoupper($jenis);
			} else if ($pembiayaan == 0) {
				$jenis = 'Kelompok';
				$jenis2 = strtoupper($jenis);
			} else {
				$jenis = 'Semua';
				$jenis2 = strtoupper($jenis);
			}

			if ($status == 1) {
				$status_ = 'Aktivasi';
				$status2 = strtoupper($status_);
			} else if ($status == 2) {
				$status_ = 'Tolak';
				$status2 = strtoupper($status_);
			} else if ($status == 3) {
				$status_ = 'Batal';
				$status2 = strtoupper($status_);
			} else {
				$status_ = 'Registrasi';
				$status2 = strtoupper($status_);
			}

			$responce['rows'][$i]['registration_no'] = $rekening;
			$responce['rows'][$i]['cell'] = array($rekening, $nama, $rembug, $jenis2, $tanggal_pengajuan, $rencana_droping, $amount, $status2);

			$i++;
		}

		echo json_encode($responce);
	}

	// 
	// GRID LIST REGISTRASI PEMBIAYAAN 
	// 

	function jqgrid_list_registrasi_pembiayaan()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$petugas = $_REQUEST['fa_code'];
		$majelis = $_REQUEST['cm_code'];
		$pembiayaan = $_REQUEST['financing_type'];
		$produk = $_REQUEST['product_code'];

		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		if ($pembiayaan == 1) {
			$jenis = 'Individu';
			$jenis2 = strtoupper($jenis);
		} else if ($pembiayaan == 0) {
			$jenis = 'Kelompok';
			$jenis2 = strtoupper($jenis);
		} else {
			$jenis = 'Semua';
			$jenis2 = strtoupper($jenis);
		}


		if ($pembiayaan == 1) {
			$majelis = '00000';
			$petugas = '00000';
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_registrasi_pembiayaan($cabang, $pembiayaan, $majelis, $produk, $petugas, $tanggal, $tanggal2);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_registrasi_pembiayaan($sidx, $sort, $limit_rows, $start, $cabang, $pembiayaan, $majelis, $produk, $petugas, $tanggal, $tanggal2);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {

			$account_financing_no = $row['account_financing_no'];
			$nama = $row['nama'];
			$cm_name = $row['cm_name'];
			$financing_type = $row['financing_type'];
			$product_code = $row['product_name'];
			$tanggal_registrasi = $row['tanggal_registrasi'];
			$pokok = number_format($row['pokok'], 0, ',', '.');
			$margin = number_format($row['margin'], 0, ',', '.');
			$angsuran_pokok = number_format($row['angsuran_pokok'], 0, ',', '.');
			$angsuran_margin = number_format($row['angsuran_margin'], 0, ',', '.');
			$angsuran_catab = number_format($row['angsuran_catab'], 0, ',', '.');
			$jangka_waktu = $row['jangka_waktu'];
			$status_rekening = $row['status_rekening'];
			$cm_code = $row['cm_code'];
			$periode_jangka_waktu = $row['periode_jangka_waktu'];
			$nick_name = $row['nick_name'];

			$total = $angsuran_pokok + $angsuran_margin + $angsuran_catab;

			if ($financing_type == 1) {
				$jenis = 'Individu';
				$jenis2 = strtoupper($jenis);
			} else if ($financing_type == 0) {
				$jenis = 'Kelompok';
				$jenis2 = strtoupper($jenis);
			} else {
				$jenis = 'Semua';
				$jenis2 = strtoupper($jenis);
			}

			if ($status_rekening == 1) {
				$status_ = 'Aktif';
				$status2 = strtoupper($status_);
			} else if ($status_rekening == 2) {
				$status_ = 'Lunas';
				$status2 = strtoupper($status_);
			} else if ($status_rekening == 3) {
				$status_ = 'Verified';
				$status2 = strtoupper($status_);
			} else {
				$status_ = 'Baru';
				$status2 = strtoupper($status_);
			}

			$responce['rows'][$i]['account_financing_no'] = $account_financing_no;
			$responce['rows'][$i]['cell'] = array($account_financing_no, $nama, $cm_name, $jenis2, $product_code, $tanggal_registrasi, $pokok, $margin, $angsuran_pokok, $angsuran_margin, $angsuran_catab, $total, $jangka_waktu, $status2);

			$i++;
		}

		echo json_encode($responce);
	}

	// 
	// GRID SALDO ANGGOTA BULAN LALU
	// 

	public function rekap_saldo_anggota_bulan_lalu()
	{
		$data['container'] = 'laporan/rekap_saldo_anggota_bulan_lalu';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['tanggal'] = $this->model_laporan->show_tanggal_closing();
		$this->load->view('core', $data);
	}


	// 
	// GRID LIST PEMBIAYAAN
	// 

	function jqgrid_list_pembiayaan()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$petugas = $_REQUEST['fa_code'];
		$majelis = $_REQUEST['cm_code'];
		$pembiayaan = $_REQUEST['financing_type'];
		$produk = $_REQUEST['product_code'];
		$peruntukan = $_REQUEST['peruntukan'];
		$sektor = $_REQUEST['sektor'];
		$kreditur = $_REQUEST['kreditur'];

		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		if ($pembiayaan == 1) {
			$jenis = 'Individu';
			$jenis2 = strtoupper($jenis);
		} else if ($pembiayaan == 0) {
			$jenis = 'Kelompok';
			$jenis2 = strtoupper($jenis);
		} else {
			$jenis = 'Semua';
			$jenis2 = strtoupper($jenis);
		}


		if ($pembiayaan == 1) {
			$majelis = '00000';
			$petugas = '00000';
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_pembiayaan($cabang, $majelis, $tanggal, $tanggal2, $pembiayaan, $petugas, $peruntukan, $sektor, $produk, $kreditur);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_pembiayaan($sidx, $sort, $limit_rows, $start, $cabang, $majelis, $tanggal, $tanggal2, $pembiayaan, $petugas, $peruntukan, $sektor, $produk, $kreditur);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {

			$nama 					= $row['nama'];
			$droping_date 			= $row['droping_date'];
			$account_financing_no 	= $row['account_financing_no'];
			$cm_name 				= $row['cm_name'];
			$nick_name 				= $row['nick_name'];
			$pokok 					= number_format($row['pokok'], 0, ',', '.');
			$margin 				= number_format($row['margin'], 0, ',', '.');
			$financing_type 		= $row['financing_type'];
			$jangka_waktu 			= $row['jangka_waktu'];
			$periode_jangka_waktu 	= $row['periode_jangka_waktu'];
			$pembiayaan_ke 			= $row['pembiayaan_ke'];
			$s_pokok 				= number_format($row['pokok_sebelum'], 0, ',', '.');
			$biaya_administrasi 	= number_format($row['biaya_administrasi'], 0, ',', '.');
			$biaya_asuransi_jiwa 	= number_format($row['biaya_asuransi_jiwa'], 0, ',', '.');
			$pengguna_dana 			= $row['pengguna_dana'];
			$description 			= $row['description'];
			$dtp 					= $row['dtp'];
			$dts 					= $row['dts'];
			$no_hp 					= $row['no_hp'];
			$sumber_dana 			= $row['krd'];

			if ($pembiayaan_ke == 1) {
				$keterangan = 'Droping Baru';
			} else if ($pokok == $s_pokok) {
				$keterangan = 'Droping Tetap';
			} else if ($pokok > $s_pokok) {
				$keterangan = 'Droping Naik';
			} else {
				$keterangan = 'Droping Turun';
			}

			if ($financing_type == 0) {
				$jenis = 'Kelompok';
			} else {
				$jenis = 'Individu';
			}

			if ($pengguna_dana == 1) {
				$pengguna_dana = 'Anggota';
			} else if ($pengguna_dana == 2) {
				$pengguna_dana = 'Suami';
			} else {
				$pengguna_dana = 'Anak';
			}

			if ($periode_jangka_waktu == 0) {
				$periode_jangka_waktu = 'Harian';
			} else if ($periode_jangka_waktu == 1) {
				$periode_jangka_waktu = 'Mingguan';
			} else if ($periode_jangka_waktu == 2) {
				$periode_jangka_waktu = 'Bulanan';
			} else {
				$periode_jangka_waktu = 'Jatuh Tempo';
			}

			$responce['rows'][$i]['account_financing_no'] = $account_financing_no;
			$responce['rows'][$i]['cell'] = array($droping_date, $account_financing_no, $nama, $jenis, $sumber_dana, $cm_name, $pembiayaan_ke, $nick_name, $pokok, $margin, $periode_jangka_waktu, $jangka_waktu, $biaya_administrasi, $biaya_asuransi_jiwa, $s_pokok, $keterangan, $pengguna_dana, $dtp . "-" . $description, $dts, $no_hp);

			$i++;
		}

		echo json_encode($responce);
	}

	// 
	// GRID LIST ANGSURAN PEMBIAYAAN
	// 

	function jqgrid_list_angsuran_pembiayaan()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		// $petugas = $_REQUEST['fa_code'];
		$petugas = $_REQUEST['account_cash_code'];
		$kreditur = $_REQUEST['kreditur'];

		// echo"<pre>";
		// print_r($petugas);
		// die();


		$majelis = $_REQUEST['cm_code'];
		$pembiayaan = $_REQUEST['financing_type'];
		$produk = $_REQUEST['product_code'];
		// $peruntukan = $_REQUEST['peruntukan'];
		//$sektor = $_REQUEST['sektor'];


		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;


		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		if ($pembiayaan == 1) {
			$jenis = 'Individu';
			$jenis2 = strtoupper($jenis);
		} else if ($pembiayaan == 0) {
			$jenis = 'Kelompok';
			$jenis2 = strtoupper($jenis);
		} else {
			$jenis = 'Semua';
			$jenis2 = strtoupper($jenis);
		}


		if ($pembiayaan == 1) {
			$majelis = '00000';
			// $petugas = '00000';
		}

		if ($petugas == '00000') {
			$fa = 'SEMUA KAS PETUGAS';
		} else {
			$getPetugas = $this->model_cif->get_fa_by_account_cash_code($petugas);
			$fa = $getPetugas['account_cash_name'];
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_angsuran_pembiayaan($tanggal, $tanggal2, $cabang, $pembiayaan, $majelis, $petugas, $produk, $kreditur);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_angsuran_pembiayaan($sidx, $sort, $limit_rows, $start, $tanggal, $tanggal2, $cabang, $pembiayaan, $majelis, $petugas, $produk, $kreditur);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		if ($pembiayaan == 0) {
			foreach ($result as $row) {

				$trx_date 				= $row['trx_date'];
				$account_financing_no 	= $row['account_financing_no'];
				$nama 					= $row['nama'];
				$cm_name 				= $row['cm_name'];
				$nick_name 				= $row['nick_name'];
				$pokok 					= number_format($row['pokok'], 0, ',', '.');
				$margin 				= number_format($row['margin'], 0, ',', '.');
				$jangka_waktu 			= $row['jangka_waktu'];
				$angsuran_pokok 		= number_format($row['angsuran_pokok'], 0, ',', '.');
				$angsuran_margin 		= number_format($row['angsuran_margin'], 0, ',', '.');
				$angsuran_catab 		= number_format($row['angsuran_catab'], 0, ',', '.');
				$jml_bayar 				= number_format($row['jml_bayar'], 0, ',', '.');
				$kas_petugas 			= $row['account_cash_name'];

				$responce['rows'][$i]['account_financing_no'] = $account_financing_no;
				$responce['rows'][$i]['cell'] = array($trx_date, $account_financing_no, $nama, $cm_name, $nick_name, $pokok, $margin, $jangka_waktu, $angsuran_pokok, $angsuran_margin, $angsuran_catab, $jml_bayar, $kas_petugas);

				$i++;
			}
		} else if ($pembiayaan == 1) {
			foreach ($result as $row) {

				$trx_date 				= $row['trx_date'];
				$account_financing_no 	= $row['account_financing_no'];
				$nama 					= $row['nama'];
				$majelis 				= $row['cm_name'];
				$produk 				= $row['nick_name'];
				$pokok 					= $row['pokok'];
				$margin 				= $row['margin'];
				$jangka_waktu 			= $row['jangka_waktu'];
				$angsuran_pokok 		= $row['bayar_pokok'];
				$angsuran_margin		= $row['bayar_margin'];
				$angsuran_catab 		= $row['bayar_catab'];
				$jml_bayar 				= $row['jml_bayar'];
				$kas_petugas 			= $row['account_cash_name'];


				$responce['rows'][$i]['account_financing_no'] = $account_financing_no;
				$responce['rows'][$i]['cell'] = array($trx_date, $account_financing_no, $nama, $majelis, $produk, $pokok, $margin, $jangka_waktu, $angsuran_pokok, $angsuran_margin, $angsuran_catab, $jml_bayar, $kas_petugas);

				$i++;
			}
		}

		echo json_encode($responce);
	}

	// 
	// GRID LIST PELUNASAN PEMBIAYAAN
	// 

	function jqgrid_list_pelunasan_pembiayaan()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$petugas = $_REQUEST['fa_code'];
		$majelis = $_REQUEST['cm_code'];
		$pembiayaan = $_REQUEST['financing_type'];
		$produk = $_REQUEST['product_code'];
		$peruntukan = $_REQUEST['peruntukan'];
		$sektor = $_REQUEST['sektor'];
		$kreditur = $_REQUEST['kreditur'];

		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		if ($pembiayaan == 1) {
			$jenis = 'Individu';
			$jenis2 = strtoupper($jenis);
		} else if ($pembiayaan == 0) {
			$jenis = 'Kelompok';
			$jenis2 = strtoupper($jenis);
		} else {
			$jenis = 'Semua';
			$jenis2 = strtoupper($jenis);
		}


		if ($pembiayaan == 1) {
			$majelis = '00000';
			$petugas = '00000';
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_pelunasan_pembiayaan(
			$cabang,
			$pembiayaan,
			$petugas,
			$majelis,
			$tanggal,
			$tanggal2,
			$kreditur
		);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_pelunasan_pembiayaan($sidx, $sort, $limit_rows, $start, $cabang, $pembiayaan, $petugas, $majelis, $tanggal, $tanggal2, $kreditur);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;


		foreach ($result as $row) {

			$tanggal_lunas 			= $row['tanggal_lunas'];
			$account_financing_no 	= $row['account_financing_no'];
			$nama 					= $row['nama'];
			$majelis 				= $row['cm_name'];
			$kreditur 				= $row['krd'];
			$pokok 					= number_format($row['pokok'], 0, ',', '.');
			$margin 				= number_format($row['margin'], 0, ',', '.');
			$jangka_waktu 			= $row['jangka_waktu'];
			$jtempo 				= $row['tanggal_jtempo'];
			$saldo_pokok 			= number_format($row['saldo_pokok'], 0, ',', '.');
			$saldo_margin 			= number_format($row['saldo_margin'], 0, ',', '.');
			$periode_jangka_waktu 	= $row['periode_jangka_waktu'];
			$counter 				= $row['counter_angsuran'];
			$financing_type 		= $row['financing_type'];

			$sisa = $jangka_waktu - $counter;
			$responce['rows'][$i]['account_financing_no'] = $account_financing_no;
			$responce['rows'][$i]['cell'] = array($tanggal_lunas, $account_financing_no, $nama, $majelis, $kreditur, $jenis2, $pokok, $margin, $jangka_waktu, $jtempo, $sisa, $saldo_pokok, $saldo_margin);

			$i++;
		}


		echo json_encode($responce);
	}

	// 
	// GRID LIST JATUH TEMPO
	// 

	function jqgrid_list_jatuh_tempo()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$petugas = $_REQUEST['fa_code'];
		$majelis = $_REQUEST['cm_code'];
		$pembiayaan = $_REQUEST['financing_type'];
		$produk = $_REQUEST['product_code'];
		$peruntukan = $_REQUEST['peruntukan'];
		$sektor = $_REQUEST['sektor'];

		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		if ($pembiayaan == 1) {
			$jenis = 'Individu';
			$jenis2 = strtoupper($jenis);
		} else if ($pembiayaan == 0) {
			$jenis = 'Kelompok';
			$jenis2 = strtoupper($jenis);
		} else {
			$jenis = 'Semua';
			$jenis2 = strtoupper($jenis);
		}


		if ($pembiayaan == 1) {
			$majelis = '00000';
			$petugas = '00000';
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_jatuh_tempo(
			$cabang,
			$pembiayaan,
			$petugas,
			$majelis,
			$tanggal,
			$tanggal2
		);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_jatuh_tempo($sidx, $sort, $limit_rows, $start, $cabang, $pembiayaan, $petugas, $majelis, $tanggal, $tanggal2);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;


		foreach ($result as $row) {

			$tanggal_akad 			= $row['tanggal_akad'];
			$account_financing_no 				= $row['account_financing_no'];
			$nama 					= $row['nama'];
			$majelis 				= $row['cm_name'];
			$desa 					= $row['desa'];
			$ke 					= $row['ke'];
			$pokok 					= $row['pokok'];
			$margin 				= $row['margin'];
			$jangka_waktu 			= $row['jangka_waktu'];
			$jtempo 				= $row['tanggal_jtempo'];
			$periode_jangka_waktu 	= $row['periode_jangka_waktu'];
			$financing_type 		= $row['financing_type'];
			$saldo_pokok 			= $row['saldo_pokok'];
			$angsuran_pokok 		= $row['angsuran_pokok'];

			if ($periode_jangka_waktu == '0') {
				$periode = 'Hari';
			} else if ($periode_jangka_waktu == '1') {
				$periode = 'Minggu';
			} else if ($periode_jangka_waktu == '2') {
				$periode = 'Bulan';
			} else if ($periode_jangka_waktu == '3') {
				$periode = 'Jatuh Tempo';
			}

			if ($financing_type == '0') {
				$pembiayaan = 'Kelompok';
			} else {
				$pembiayaan = 'Individu';
			}

			$sisa_angsuran = $saldo_pokok / $angsuran_pokok;
			$sisa = ceil($sisa_angsuran);

			$responce['rows'][$i]['account_financing_no'] = $account_financing_no;
			$responce['rows'][$i]['cell'] = array($tanggal_akad, $account_financing_no, $nama, $majelis, $pembiayaan, $desa, $ke, $pokok, $margin, $sisa . ' ' . $periode, $jangka_waktu . ' ' . $periode, $jtempo);

			$i++;
		}


		echo json_encode($responce);
	}

	// 
	// GRID LIST KOLEKTIBILITAS
	// 

	function jqgrid_list_kolektibilitas()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$tanggal_hitung = isset($_REQUEST['date']) ? $_REQUEST['date'] : '';
		$tanggal_hitung = str_replace('/', '', $tanggal_hitung);
		$tanggal_hitung = substr($tanggal_hitung, 4, 4) . '-' . substr($tanggal_hitung, 2, 2) . '-' . substr($tanggal_hitung, 0, 2);
		$branch_code = $_REQUEST['branch_code'];
		$kol = $_REQUEST['kol'];
		$fa_code = $_REQUEST['fa_code'];
		$kreditur = $_REQUEST['kreditur'];

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_kolektibilitas($tanggal_hitung, $branch_code, $kol, $fa_code);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_kolektibilitas($sidx, $sort, $limit_rows, $start, $tanggal_hitung, $branch_code, $kol, $fa_code, $kreditur);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {

			$account_financing_no 	= $row['account_financing_no'];
			$majelis 				= $row['cm_name'];
			$nama 					= $row['nama'];
			$pokok 					= number_format($row['pokok'], 0, ',', '.');
			$margin 				= number_format($row['margin'], 0, ',', '.');
			$jangka_waktu 			= $row['jangka_waktu'];
			$droping_date 			= $row['droping_date'];
			$tanggal_mulai_angsur 	= $row['tanggal_mulai_angsur'];
			$angsuran_pokok 		= number_format($row['angsuran_pokok'], 0, ',', '.');
			$angsuran_margin 		= number_format($row['angsuran_margin'], 0, ',', '.');
			$terbayar 				= $row['terbayar'];
			$seharusnya 			= $row['seharusnya'];
			$saldo_pokok 			= number_format($row['saldo_pokok'], 0, ',', '.');
			$saldo_margin 			= number_format($row['saldo_margin'], 0, ',', '.');
			$hari_nunggak 			= $row['hari_nunggak'];
			$freq_tunggakan 		= $row['freq_tunggakan'];
			$tunggakan_pokok 		= number_format($row['tunggakan_pokok'], 0, ',', '.');
			$tunggakan_margin 		= $row['tunggakan_margin'];
			$cadangan_piutang 		= number_format($row['cadangan_piutang'], 0, ',', '.');
			$par 					= $row['par'];
			$par_desc 				= $row['par_desc'];

			$responce['rows'][$i]['account_financing_no'] = $account_financing_no;
			$responce['rows'][$i]['cell'] = array($account_financing_no, $majelis, $nama, $pokok, $margin, $jangka_waktu, $droping_date, $tanggal_mulai_angsur, $angsuran_pokok, $angsuran_margin, $terbayar, $seharusnya, $saldo_pokok, $saldo_margin, $hari_nunggak, $freq_tunggakan, $tunggakan_pokok, $tunggakan_margin, $par_desc, $par, $cadangan_piutang);

			$i++;
		}


		echo json_encode($responce);
	}

	// GRID LIST SALDO TABUNGAN	// 
	function jqgrid_list_saldo_tabungan()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$majelis = $_REQUEST['cm_code'];
		$petugas = $_REQUEST['fa_code'];

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_saldo_anggota(
			$cabang,
			$petugas,
			$majelis
		);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_saldo_anggota($sidx, $sort, $limit_rows, $start, $cabang, $petugas, $majelis);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;


		foreach ($result as $row) {

			$cif_no 			= $row['cif_no'];
			$nama 				= $row['nama'];
			$majelis 			= $row['cm_name'];
			$desa 				= $row['desa'];
			$pokok 				= number_format($row['pokok'], 0, ',', '.');
			$margin 			= number_format($row['margin'], 0, ',', '.');
			$setoran_lwk 		= number_format($row['setoran_lwk'], 0, ',', '.');
			$tabungan_minggon 	= number_format($row['tabungan_minggon'], 0, ',', '.');
			$tabungan_kelompok 	= number_format($row['saldo_dtk'], 0, ',', '.');
			$tabungan_sukarela 	= number_format($row['tabungan_sukarela'], 0, ',', '.');
			$saldo_pokok 		= number_format($row['saldo_pokok'], 0, ',', '.');
			$saldo_margin 		= number_format($row['saldo_margin'], 0, ',', '.');

			$responce['rows'][$i]['cif_no'] = $cif_no;
			$responce['rows'][$i]['cell'] = array($cif_no, $nama, $majelis, $desa, $pokok, $margin, $setoran_lwk, $tabungan_minggon, $tabungan_kelompok, $tabungan_sukarela, $saldo_pokok, $saldo_margin);

			$i++;
		}


		echo json_encode($responce);
	}

	// GRID LIST SALDO ANGGOTA	// 
	function jqgrid_list_saldo_anggota()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$majelis = $_REQUEST['cm_code'];
		$petugas = $_REQUEST['fa_code'];

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_saldo_anggota(
			$cabang,
			$petugas,
			$majelis
		);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_saldo_anggota($sidx, $sort, $limit_rows, $start, $cabang, $petugas, $majelis);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;


		foreach ($result as $row) {

			$cif_no 			= $row['cif_no'];
			$nama 				= $row['nama'];
			$majelis 			= $row['cm_name'];
			$desa 				= $row['desa'];
			$setoran_lwk 		= number_format($row['setoran_lwk'], 0, ',', '.');
			$tabungan_minggon 	= number_format($row['tabungan_minggon'], 0, ',', '.');
			$tabungan_kelompok 	= number_format($row['saldo_dtk'], 0, ',', '.');
			$tabungan_sukarela 	= number_format($row['tabungan_sukarela'], 0, ',', '.');
			$tabungan_berencana = number_format($row['saldo_taber'], 0, ',', '.');
			$pokok 				= number_format($row['pokok'], 0, ',', '.');
			$margin 			= number_format($row['margin'], 0, ',', '.');
			$saldo_pokok 		= number_format($row['saldo_pokok'], 0, ',', '.');
			$saldo_margin 		= number_format($row['saldo_margin'], 0, ',', '.');

			$responce['rows'][$i]['cif_no'] = $cif_no;
			$responce['rows'][$i]['cell'] = array($cif_no, $nama, $majelis, $desa, $setoran_lwk, $tabungan_minggon, $tabungan_kelompok, $tabungan_sukarela, $tabungan_berencana, $pokok, $margin, $saldo_pokok, $saldo_margin);

			$i++;
		}


		echo json_encode($responce);
	}


	// 
	// GRID LIST ANGGOTA MASUK
	// 

	function jqgrid_list_anggota_masuk()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$majelis = $_REQUEST['cm_code'];
		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_anggota_masuk(
			$cabang,
			$majelis,
			$tanggal,
			$tanggal2
		);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_anggota_masuk($sidx, $sort, $limit_rows, $start, $cabang, $majelis, $tanggal, $tanggal2);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;


		foreach ($result as $row) {

			$cif_no 		= $row['cif_no'];
			$nama 			= $row['nama'];
			$majelis 		= $row['cm_name'];
			$tgl_gabung 	= date('d/m/Y', strtotime($row['tgl_gabung']));
			$jenis_kelamin 	= $row['jenis_kelamin'];
			$ibu_kandung 	= $row['ibu_kandung'];
			$tmp_lahir 		= $row['tmp_lahir'];
			$tgl_lahir 		= date('d/m/y', strtotime($row['tgl_lahir']));
			$usia 			= $row['usia'];
			$alamat 		= $row['alamat'];


			if ($jenis_kelamin == "W") {
				$kelamin = "Wanita";
			} else {
				$kelamin = "Pria";
			}

			//$lahir = date("d-m-Y", strtotime($row['tgl_gabung']));
			//date_format($tgl_gabung,"d-m-Y");

			$responce['rows'][$i]['cif_no'] = $cif_no;
			$responce['rows'][$i]['cell'] = array($cif_no, $nama, $majelis, $tgl_gabung, $kelamin, $ibu_kandung, $tmp_lahir, $tgl_lahir, $usia, $alamat);

			$i++;
		}


		echo json_encode($responce);
	}



	function jqgrid_list_anggota_absen()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$majelis = $_REQUEST['cm_code'];
		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
		$user_id = $this->session->userdata('user_id');



		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;


		$insert_absen_report = $this->model_laporan_to_pdf->insert_absen_report($cabang, $majelis, $tanggal, $tanggal2, $user_id);

		if ($totalrows) {
			$limit_rows = $totalrows;
		}


		$count = $this->model_laporan_to_pdf->jqgrid_count_anggota_absen($cabang, $majelis, $tanggal, $tanggal2);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_anggota_absen($sidx, $sort, $limit_rows, $start, $cabang, $majelis, $tanggal, $tanggal2);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;


		foreach ($result as $row) {

			$cif_no 		= $row['cif_no'];
			$nama 			= $row['nama'];
			$majelis 		= $row['cm_name'];
			$tgl_gabung 	= date('d/m/Y', strtotime($row['tgl_gabung']));
			$hadir		 	= $row['h'];
			$ijin		 	= $row['i'];
			$sakit  		= $row['s'];
			$abstain		= $row['a'];

			//$lahir = date("d-m-Y", strtotime($row['tgl_gabung']));
			//date_format($tgl_gabung,"d-m-Y");

			$responce['rows'][$i]['cif_no'] = $cif_no;
			$responce['rows'][$i]['cell'] = array($cif_no, $nama, $majelis, $tgl_gabung, $hadir, $ijin, $sakit, $abstain);

			$i++;
		}


		echo json_encode($responce);
	}


	// 
	// GRID LIST ANGGOTA KELUAR
	// 

	function jqgrid_list_anggota_keluar()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$majelis = $_REQUEST['cm_code'];
		$alasan = $_REQUEST['alasan'];
		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_anggota_keluar(
			$cabang,
			$majelis,
			$tanggal,
			$tanggal2,
			$alasan
		);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_anggota_keluar($sidx, $sort, $limit_rows, $start, $cabang, $majelis, $tanggal, $tanggal2, $alasan);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;


		foreach ($result as $row) {

			$cif_no 					= $row['cif_no'];
			$nama 						= $row['nama'];
			$majelis 					= $row['cm_name'];
			$tgl_gabung 				= date('d/m/Y', strtotime($row['tgl_gabung']));
			$tanggal_mutasi 			= date('d/m/Y', strtotime($row['tanggal_mutasi']));
			$alasan_keluar 				= $row['alasan_keluar'];
			$alasan 					= $row['alasan'];



			$responce['rows'][$i]['cif_no'] = $cif_no;
			$responce['rows'][$i]['cell'] = array($cif_no, $nama, $majelis, $tgl_gabung, $tanggal_mutasi, $alasan_keluar, $alasan);

			$i++;
		}


		echo json_encode($responce);
	}



	// 
	// GRID LIST ANGGOTA MUTASI 
	// 

	function jqgrid_list_anggota_mutasi()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$majelis = $_REQUEST['cm_code'];
		$alasan = $_REQUEST['alasan'];
		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_anggota_mutasi(
			$cabang,
			$majelis,
			$tanggal,
			$tanggal2,
			$alasan
		);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_anggota_mutasi($sidx, $sort, $limit_rows, $start, $cabang, $majelis, $tanggal, $tanggal2, $alasan);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;


		foreach ($result as $row) {

			$cif_no 					= $row['cif_no'];
			$nama 						= $row['nama'];
			$majelis_lama  				= $row['rembug_lama'];
			$majelis_baru 				= $row['rembug_baru'];
			$tgl_gabung 				= date('d/m/Y', strtotime($row['tgl_gabung']));
			$tanggal_mutasi 			= date('d/m/Y', strtotime($row['tanggal_mutasi']));
			$alasan_mutasi 				= $row['alasan_mutasi'];
			$keterangan 				= $row['keterangan'];



			$responce['rows'][$i]['cif_no'] = $cif_no;
			$responce['rows'][$i]['cell'] = array($tanggal_mutasi, $cif_no, $nama, $majelis_lama, $majelis_baru, $alasan_mutasi, $keterangan);

			$i++;
		}


		echo json_encode($responce);
	}



	// 
	// GRID LIST BUKA TABUNGAN
	// 

	function jqgrid_list_buka_tabungan()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$majelis = $_REQUEST['cm_code'];
		$produk = $_REQUEST['produk'];
		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';


		// echo"<pre>";
		// echo($produk);
		// die();

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_list_buka_tabugan(
			$produk,
			$tanggal,
			$tanggal2,
			$cabang
		);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_buka_tabungan($sidx, $sort, $limit_rows, $start, $produk, $tanggal, $tanggal2, $cabang);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;


		foreach ($result as $row) {

			$account_saving_no 		= $row['account_saving_no'];
			$nama 					= $row['nama'];
			$majelis 				= $row['cm_name'];
			$product_name 			= $row['product_name'];
			$tgl_buka 				= date('d/m/Y', strtotime($row['tanggal_buka']));
			$rencana_jangka_waktu 	= $row['rencana_jangka_waktu'];
			$tanggal_jtempo 		= date('d/m/Y', strtotime($row['tanggal_jtempo']));
			$rencana_setoran 		= number_format($row['rencana_setoran'], 0, ',', '.');
			$status 				= $row['status_rekening'];
			$saldo_memo 			= number_format($row['saldo_memo'], 0, ',', '.');

			if ($status == 1) {
				$status_rek = "Aktif";
			} else {
				$status_rek = "Tidak Aktif";
			}

			$responce['rows'][$i]['account_saving_no'] = $account_saving_no;
			$responce['rows'][$i]['cell'] = array($account_saving_no, $nama, $majelis, $product_name, $tgl_buka, $rencana_jangka_waktu, $tanggal_jtempo, $rencana_setoran, $status_rek, $saldo_memo);

			$i++;
		}


		echo json_encode($responce);
	}

	// 
	// GRID LIST BUKA TABUNGAN JTEMPO
	// 

	function jqgrid_list_buka_tabungan_jtempo()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		//$majelis = $_REQUEST['cm_code'];
		$produk = $_REQUEST['produk'];
		$status = $_REQUEST['status'];
		$rembug = $_REQUEST['rembug'];
		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';


		// echo"<pre>";
		// echo($produk);
		// die();

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_list_buka_tabugan_jtempo(
			$produk,
			$tanggal,
			$tanggal2,
			$cabang,
			$status,
			$rembug
		);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_buka_tabungan_jtempo($sidx, $sort, $limit_rows, $start, $produk, $tanggal, $tanggal2, $cabang, $status, $rembug);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;


		foreach ($result as $row) {

			$tgl_buka 				= date('d/m/Y', strtotime($row['tanggal_buka']));
			$tanggal_jtempo 		= date('d-m-Y', strtotime($row['tanggal_buka'] . ' + ' . (7 * $row['rencana_jangka_waktu']) . ' days'));
			$account_saving_no 		= $row['account_saving_no'];
			$nama 					= $row['nama'];
			$product_name 			= $row['product_name'];
			$rencana_jangka_waktu 	= $row['rencana_jangka_waktu'];
			$rencana_setoran 		= number_format($row['rencana_setoran'], 0, ',', '.');
			$counter_angsruan       = number_format($row['counter_angsruan'], 0, ',', '.');
			$saldo_memo 			= number_format($row['saldo_memo'], 0, ',', '.');
			$status 				= $row['status_rekening'];
			$rembug 				= $row['cm_name'];

			if ($status == 0) {
				$status_rek = "Registrasi";
			} else if ($status == 1) {
				$status_rek = "Aktif";
			} else if ($status == 2) {
				$status_rek = "Cair / Tutup";
			} else if ($status == 3) {
				$status_rek = "Proses Pencairan";
			} else {
				$status_rek = "Anggota Keluar";
			}

			$responce['rows'][$i]['account_saving_no'] = $account_saving_no;
			$responce['rows'][$i]['cell'] = array($tgl_buka, $tanggal_jtempo, $account_saving_no, $rembug, $nama, $product_name, $rencana_jangka_waktu, $rencana_setoran, $counter_angsruan, $saldo_memo, $status_rek);

			$i++;
		}


		echo json_encode($responce);
	}

	// 
	// GRID LIST PEMBUKAAN TABUNGAN
	// 

	function jqgrid_list_pembukaan_tabungan()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		//$majelis = $_REQUEST['cm_code'];
		$produk = $_REQUEST['produk'];
		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_list_pembukaan_tabungan(
			$produk,
			$cabang
		);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_pembukaan_tabungan($sidx, $sort, $limit_rows, $start, $produk, $cabang);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;


		foreach ($result as $row) {

			$account_saving_no 		= $row['account_saving_no'];
			$majelis 					= $row['cm_name'];
			$nama 					= $row['nama'];
			$product_name 			= $row['product_name'];
			$tgl_buka 				= date('d/m/Y', strtotime($row['tanggal_buka']));
			//$tanggal_jtempo 		= date('d-m-Y',strtotime($row['tanggal_buka'] . ' + '.(7 * $row['rencana_jangka_waktu']).' days' ));
			$rencana_jangka_waktu 	= $row['rencana_jangka_waktu'];
			$rencana_setoran 		= number_format($row['rencana_setoran'], 0, ',', '.');
			$terbayar 				= $row['counter_angsruan'];
			$saldo_memo 			= number_format($row['saldo_memo'], 0, ',', '.');
			$status 				= $row['status_rekening'];

			if ($status == 1) {
				$status_rek = "Aktif";
			} else {
				$status_rek = "Tidak Aktif";
			}

			$responce['rows'][$i]['account_saving_no'] = $account_saving_no;
			$responce['rows'][$i]['cell'] = array($account_saving_no, $majelis, $nama, $product_name, $tgl_buka, $rencana_jangka_waktu, $rencana_setoran, $terbayar, $saldo_memo, $status_rek);

			$i++;
		}


		echo json_encode($responce);
	}

	/****************************************************************************************/
	// BEGIN LIST WAKALAH | T | TGL 07-09-2017
	/****************************************************************************************/

	public function list_wakalah()
	{
		$data['container'] = 'laporan/list_wakalah';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['product'] = $this->model_laporan->get_product_financing();
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core', $data);
	}

	// 
	// GRID LIST WAKALAH
	// 

	function jqgrid_list_wakalah()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$cabang = $_REQUEST['branch_code'];
		$petugas = $_REQUEST['fa_code'];
		$majelis = $_REQUEST['cm_code'];
		$pembiayaan = $_REQUEST['financing_type'];
		$produk = $_REQUEST['product_code'];

		$tanggal = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : '';
		$tanggal2 = isset($_REQUEST['tanggal2']) ? $_REQUEST['tanggal2'] : '';

		$tanggal = str_replace('/', '', $tanggal);
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
		$tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		// echo"<pre>";
		// print_r($from);
		// echo"<br>";
		// print_r($thru);
		// echo"<br>";
		// print_r($majelis);
		// echo"<br>";
		// print_r($pembiayaan);
		// echo"<br>";

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		if ($pembiayaan == 1) {
			$jenis = 'Individu';
			$jenis2 = strtoupper($jenis);
		} else if ($pembiayaan == 0) {
			$jenis = 'Kelompok';
			$jenis2 = strtoupper($jenis);
		} else {
			$jenis = 'Semua';
			$jenis2 = strtoupper($jenis);
		}


		if ($pembiayaan == 1) {
			$majelis = '00000';
			$petugas = '00000';
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_wakalah($cabang, $pembiayaan, $majelis, $produk, $petugas, $tanggal, $tanggal2);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_wakalah($sidx, $sort, $limit_rows, $start, $cabang, $pembiayaan, $majelis, $produk, $petugas, $tanggal, $tanggal2);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {

			$tanggal_wakalah 		= $row['tanggal_wakalah'];
			$account_financing_no 	= $row['account_financing_no'];
			$nama 					= $row['nama'];
			$cm_name 				= $row['cm_name'];
			$product_code 			= $row['product_name'];
			$pokok 					= number_format($row['jumlah_wakalah'], 0, ',', '.');
			$petugas 				= $row['fa_name'];
			$status_wakalah 		= $row['status_wakalah'];

			if ($status_wakalah == 0) {
				$status_wakalah_ = "Register";
			} else {
				$status_wakalah_ = "Revers";
			}


			$responce['rows'][$i]['account_financing_no'] = $account_financing_no;
			$responce['rows'][$i]['cell'] = array($tanggal_wakalah, $account_financing_no, $nama, $cm_name, $product_code, $pokok, $petugas, $status_wakalah_);

			$i++;
		}

		echo json_encode($responce);
	}

	/****************************************************************************************/
	// END LIST WAKALAH
	/****************************************************************************************/

	function list_tabungan_bulan_lalu()
	{
		$data['container'] = 'laporan/list_tabungan_bulan_lalu';
		$data['tanggal'] = $this->model_laporan->show_tanggal_closing();
		$this->load->view('core', $data);
	}

	function get_product_saving_by_type()
	{
		$saving_type = $this->input->post('saving_type');

		$get = $this->model_laporan->get_product_saving_by_saving_type($saving_type);

		$html = '<option value="" selected="selected">Pilih</option>';
		$html .= '<option value="00000">SEMUA</option>';

		foreach ($get as $saving) {
			$product_code = $saving['product_code'];
			$nick_name = $saving['nick_name'];

			$html .= '<option value="' . $product_code . '">' . $nick_name . '</option>';
		}

		echo $html;
	}

	function jqgrid_list_outstanding_tabungan_lalu()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'account_financing_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$tanggal = date('Y-m-d');
		$cabang = $_REQUEST['branch_code'];
		$petugas = $_REQUEST['fa_code'];
		$majelis = $_REQUEST['cm_code'];
		$tabungan = $_REQUEST['saving_type'];
		$product_code = $_REQUEST['product_code'];
		$tanggal = $_REQUEST['tanggal'];

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_outstanding_tabungan_lalu($cabang, $tabungan, $majelis, $petugas, $tanggal, $product_code);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_outstanding_tabungan_lalu($sidx, $sort, $limit_rows, $start, $cabang, $tabungan, $majelis, $petugas, $tanggal, $product_code);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {
			$rekening = $row['account_saving_no'];
			$nama = $row['nama'];
			$ktp = $row['no_ktp'];
			$rembug = $row['cm_name'];
			$nick_name = $row['nick_name'];
			$saldo_memo = $row['saldo_memo'];

			$responce['rows'][$i]['account_saving_no'] = $rekening;
			$responce['rows'][$i]['cell'] = array($rekening, $nama, $ktp, $rembug, $nick_name, $saldo_memo);

			$i++;
		}

		echo json_encode($responce);
	}

	/***************************************************************************************/
	//BEGIN PROYEKSI DROPING
	//Author : Aiman
	//Tgl    : 24 - 05 - 18
	/***************************************************************************************/

	function proyeksi_droping()
	{
		$data['container'] = 'laporan/proyeksi_droping';
		$data['get_year'] = $this->model_laporan->get_year();
		$this->load->view('core', $data);
	}

	function jqgrid_lap_proyeksi_droping()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'registration_no';
		$sort = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		// $tanggal = date('Y-m-d');
		// $tanggal2 = date('Y-m-d');
		$cabang = $_REQUEST['branch_code'];
		$year = $_REQUEST['year'];

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$count = $this->model_laporan_to_pdf->jqgrid_count_lap_proyeksi_droping($cabang, $year, $sort, $sidx, $limit_rows);

		if ($count > 0) {
			$total_pages = ceil($count / $limit_rows);
		} else {
			$total_pages = 0;
		}

		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		if ($cabang == '9999') {
			$result = $this->model_laporan_to_pdf->jqgrid_list_lap_proyeksi_droping($sidx, $sort, $limit_rows, $start, $cabang, $year);
		} else if ($cabang == '00000') {
			$result = $this->model_laporan_to_pdf->jqgrid_list_lap_proyeksi_droping_pusat($sidx, $sort, $limit_rows, $start, $cabang, $year);
		} else {
			$result = $this->model_laporan_to_pdf->jqgrid_list_lap_proyeksi_droping($sidx, $sort, $limit_rows, $start, $cabang, $year);
		}

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;

		foreach ($result as $row) {


			if ($cabang == '00000') {
				$branch_name = 'Pusat';
			} else {
				$branch_name = $row['branch_name'];
			}

			$year = $row['year'];
			$month = $row['month'];
			$account_target = number_format($row['account_target'], 0, ',', '.');
			$amount_target = number_format($row['amount_target'], 2, ',', '.');
			$account_real = number_format($row['account_real'], 0, ',', '.');
			$amount_real = number_format($row['amount_real'], 2, ',', '.');

			if ($month == '1') {
				$mont_ = 'Januari';
			} else
            if ($month == '2') {
				$mont_ = 'Februari';
			} else
            if ($month == '3') {
				$mont_ = 'Maret';
			} else
            if ($month == '4') {
				$mont_ = 'April';
			} else
            if ($month == '5') {
				$mont_ = 'Mei';
			} else
            if ($month == '6') {
				$mont_ = 'Juni';
			} else
            if ($month == '7') {
				$mont_ = 'Juli';
			} else
            if ($month == '8') {
				$mont_ = 'Agustus';
			} else
            if ($month == '9') {
				$mont_ = 'September';
			} else
            if ($month == '10') {
				$mont_ = 'Oktober';
			} else
            if ($month == '11') {
				$mont_ = 'November';
			} else
            if ($month == '12') {
				$mont_ = 'Desember';
			}

			$responce['rows'][$i]['cell'] = array($branch_name, $mont_ . ' - ' . $year, $account_target, $amount_target, $account_real, $amount_real);

			$i++;
		}

		echo json_encode($responce);
	}

	/***************************************************************************************/
	//END PROYEKSI DROPING
	/***************************************************************************************/
}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */