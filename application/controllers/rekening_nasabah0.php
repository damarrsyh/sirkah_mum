<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rekening_nasabah extends GMN_Controller
{

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_nasabah');
		$this->load->model('model_transaction');
		$this->load->model('model_cif');
	}

	/****************************************************************************************/
	// BEGIN PELUNASAN PEMBIAYAAN
	/****************************************************************************************/
	public function pelunasan()
	{
		$data['container'] = 'nasabah/registrasi_pelunasan_pembiayaan';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$branch_code = $this->session->userdata('branch_code');
		$data['account_cash'] = $this->model_transaction->ajax_get_gl_account_cash_by_keyword('', $branch_code, '0');
		$this->load->view('core', $data);
	}

	function cek_trx_kontrol_periode()
	{
		$tanggal = $this->input->post('tanggal');
		$tanggal = $this->datepicker_convert(true, $tanggal, $separator = '/');
		$cek = $this->model_transaction->cek_trx_kontrol_periode($tanggal);
		$return = array('success' => $cek);
		echo json_encode($return);
	}

	public function get_cif_by_account_financing_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_nasabah->get_cif_by_account_financing_no($account_financing_no);

		echo json_encode($data);
	}

	function proses_reg_pelunasan_pembayaran()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$account_financing_schedulle_id	= $this->input->post('account_financing_schedulle_id');
		$account_financing_no = $this->input->post('no_pembiayaan');
		$cash_type = $this->input->post('cash_type');
		$pokok = $this->input->post('pokok_pembiayaan');
		$margin = $this->input->post('margin_pembiayaan');
		$saldo_pokok = $this->input->post('saldo_pokok');
		$saldo_margin = $this->input->post('saldo_margin');
		$saldo_tabungan_lunas = $this->input->post('saldo_tabungan');
		$saldo_tabungan_trx = $this->input->post('saldo_tabungan_trx');
		$saldo_wajib = $this->input->post('saldo_wajib_trx');
		$saldo_kelompok = $this->input->post('saldo_kelompok_trx');
		$potongan_margin = $this->input->post('potongan_margin');
		$created_by = $this->session->userdata('user_id');
		$tanggal_jtempo = $this->input->post('tanggal_jtempo');
		$jtempo_angsuran_next = $this->input->post('jtempo_angsuran_next');
		$freq = $this->input->post('freq');
		$counter_angsuran = $this->input->post('counter_angsuran');
		$periode_jangka_waktu = $this->input->post('periode_jangka_waktu');
		$created_date = date('Y-m-d H:i:s');
		$account_cash_code = $this->input->post('account_cash_code');
		$tanggal_lunas = $this->input->post('tanggal_lunas');
		$total_pembayaran = $this->input->post('total_pembayaran');
		$no_rek_tabungan = $this->input->post('no_rek_tabungan');
		$saldo_memo = $this->input->post('saldo_memo');
		$angsuran_pokok = $this->input->post('angsuran_pokok');
		$angsuran_margin = $this->input->post('angsuran_margin');
		$angsuran_catab = $this->input->post('angsuran_catab');
		$angsuran_tab_wajib = $this->input->post('angsuran_tab_wajib');
		$angsuran_tab_kelompok = $this->input->post('angsuran_tab_kelompok');

		$calculate_saldo_catab = $this->input->post('calculate_saldo_catab');
		$calculate_saldo_wajib = $this->input->post('calculate_saldo_wajib');
		$calculate_saldo_kelompok = $this->input->post('calculate_saldo_kelompok');

		$trx_detail_id = uuid(FALSE);

		$pokok = $this->convert_numeric($pokok);
		$margin = $this->convert_numeric($margin);
		$saldo_pokok = $this->convert_numeric($saldo_pokok);
		$saldo_margin = $this->convert_numeric($saldo_margin);
		$saldo_tabungan_lunas = $this->convert_numeric($saldo_tabungan_lunas);
		$saldo_tabungan_trx = $this->convert_numeric($saldo_tabungan_trx);
		$saldo_wajib = $this->convert_numeric($saldo_wajib);
		$saldo_kelompok = $this->convert_numeric($saldo_kelompok);
		$potongan_margin = $this->convert_numeric($potongan_margin);
		$total_pembayaran = $this->convert_numeric($total_pembayaran);
		$saldo_memo = $this->convert_numeric($saldo_memo);

		$tanggal_transaksi = str_replace('/', '-', $tanggal_lunas);
		$tanggal_transaksi = date('Y-m-d', strtotime($tanggal_transaksi));

		$valid = TRUE;

		if ($cash_type == 1) {
			// PINBUK
			if ($total_pembayaran > $saldo_memo) {
				$valid = FALSE;
			}
		}

		// FINANCING LUNAS
		$saldo_pokok_lunas = $angsuran_pokok * $counter_angsuran;
		$saldo_margin_lunas = $angsuran_margin * $counter_angsuran;
		$saldo_catab_lunas = $angsuran_catab * $counter_angsuran;
		$saldo_wajib_lunas = $angsuran_tab_wajib * $counter_angsuran;
		$saldo_kelompok_lunas = $angsuran_tab_kelompok * $counter_angsuran;

		// TRX ACCOUNT_FINANCING
		$saldo_pokok_trx = $angsuran_pokok * $freq;
		$saldo_margin_trx = $angsuran_margin * $freq;
		$saldo_catab_trx = $angsuran_catab * $freq;
		$saldo_wajib_trx = $angsuran_tab_wajib * $freq;
		$saldo_kelompok_trx = $angsuran_tab_kelompok * $freq;

		// PINBUK CATAB
		$saldo_catab_pinbuk = $angsuran_catab * ($counter_angsuran + $freq);

		if ($calculate_saldo_catab == 1) {
			$saldo_catab_trx = 0;
			$saldo_catab_pinbuk = 0;
		}

		if ($calculate_saldo_wajib == 1) {
			$saldo_wajib_trx = 0;
		}

		if ($calculate_saldo_kelompok == 1) {
			$saldo_kelompok_trx = 0;
		}

		if ($valid == TRUE) {
			$data = array(
				'account_financing_no' => $account_financing_no,
				'saldo_pokok' => $saldo_pokok_trx,
				'saldo_margin' => $saldo_margin_trx,
				'saldo_catab' => $saldo_catab_lunas,
				'saldo_wajib' => $saldo_wajib_trx,
				'saldo_kelompok' => $saldo_kelompok_trx,
				'potongan_margin' => $potongan_margin,
				'status_pelunasan' => '0',
				'jenis_pembayaran' => $cash_type,
				'account_cash_code' => $account_cash_code,
				'tanggal_lunas' => $tanggal_transaksi,
				'flag_catab' => $calculate_saldo_catab,
				'flag_wajib' => $calculate_saldo_wajib,
				'flag_kelompok' => $calculate_saldo_kelompok,
				'create_by' => $created_by,
				'created_date' => $created_date
			);

			$data_trx_account_financing = array(
				'account_financing_no' => $account_financing_no,
				'trx_financing_type' => '2',
				'branch_id' => $this->session->userdata('branch_id'),
				'trx_date' => $tanggal_transaksi,
				'jto_date' => $tanggal_jtempo,
				'pokok' => $saldo_pokok_trx,
				'margin' => $saldo_margin_trx,
				'catab' => $saldo_catab_trx,
				'tab_wajib' => $saldo_wajib_trx,
				'tab_kelompok' => $saldo_kelompok_trx,
				'created_by' => $created_by,
				'created_date' => $created_date,
				'trx_detail_id' => $trx_detail_id,
				'freq' => $freq,
				'account_cash_code' => $account_cash_code,
				'cash_type' => $cash_type,
				'description' => 'PELUNASAN PEMBIAYAAN PASS ACCT. ' . $account_financing_no,
				'trx_status' => '0'
			);

			$this->db->trans_begin();
			$this->model_nasabah->proses_reg_pelunasan_pembayaran($data);
			$this->model_nasabah->insert_mfi_trx_account_financing($data_trx_account_financing);

			// financing transaction
			if ($this->db->trans_status() === true) {
				$this->db->trans_commit();
				$return = array('success' => true, 'message' => '');
			} else {
				$this->db->trans_rollback();
				$return = array('success' => false, 'message' => 'Gagal! Koneksi terputus');
			}
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false, 'message' => 'Gagal! Saldo Rekening Tabungan tidak mencukupi');
		}

		echo json_encode($return);
	}

	function get_financing_by_id()
	{
		$account_financing_lunas_id = $this->input->post('account_financing_lunas_id');
		$data = $this->model_nasabah->get_financing_by_id($account_financing_lunas_id);

		echo json_encode($data);
	}

	public function proses_edit_pelunasan_pembayaran()
	{
		$account_financing_lunas_id 	= $this->input->post('account_financing_lunas_id');
		$account_financing_id 			= $this->input->post('account_financing_id');
		$account_financing_schedulle_id	= $this->input->post('account_financing_schedulle_id');
		$account_financing_no 			= $this->input->post('no_pembiayaan');
		$saldo_pokok		 			= $this->input->post('saldo_pokok');
		$saldo_margin 					= $this->input->post('saldo_margin');
		$saldo_tabungan 				= $this->input->post('saldo_tabungan');
		$potongan_margin 	 			= $this->input->post('potongan_margin');
		$created_by 					= $this->session->userdata('user_id');
		$created_date 					= date('Y-m-d H:i:s');
		$date_current 					= $this->model_transaction->get_date_current();

		$data = array(
			/*'account_financing_no'	=>$account_financing_no,
				'saldo_pokok' 			=>$saldo_pokok,
				'saldo_margin' 			=>$saldo_margin,*/
			'potongan_margin' 		=> $potongan_margin,
			/*'status_pelunasan'		=>'0',
				'create_by' 			=>$created_by,
				'created_date'			=>$created_date*/
		);
		$param = array('account_financing_lunas_id' => $account_financing_lunas_id);

		$data_financing = array(
			'saldo_pokok'			=> $saldo_pokok,
			'saldo_margin'			=> $saldo_margin,
			'saldo_cadangan_resiko'	=> $saldo_tabungan
			/*'jtempo_angsuran_last'	=>$jtempo_angsuran_last,
							'jtempo_angsuran_next'	=>$jtempo_angsuran_next*/
		);

		$param_financing = array('account_financing_id' => $account_financing_id);

		$data_financing_schedulle = array(
			'tanggal_bayar' 	=> $date_current,
			'bayar_pokok'		=> $saldo_pokok,
			'bayar_margin'		=> $saldo_margin,
			'bayar_tabungan'	=> $saldo_tabungan
		);

		$param_financing_schedulle = array('account_financing_schedulle_id' => $account_financing_schedulle_id);

		$this->db->trans_begin();
		$this->model_nasabah->proses_edit_pelunasan_pembayaran($data, $param);
		$this->model_nasabah->update_account_financing($data_financing, $param_financing);
		$this->model_nasabah->update_account_financing_schedulle($data_financing_schedulle, $param_financing_schedulle);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	public function delete_data_pelunasan_pembiayaan()
	{
		$account_financing_lunas_id = $this->input->post('account_financing_lunas_id');

		$success = 0;
		$failed  = 0;
		for ($i = 0; $i < count($account_financing_lunas_id); $i++) {
			$param = array('account_financing_lunas_id' => $account_financing_lunas_id[$i]);
			$this->db->trans_begin();
			$this->model_nasabah->delete_data_pelunasan_pembiayaan($param);
			if ($this->db->trans_status() === true) {
				$this->db->trans_commit();
				$success++;
			} else {
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if ($success == 0) {
			$return = array('success' => false, 'num_success' => $success, 'num_failed' => $failed);
		} else {
			$return = array('success' => true, 'num_success' => $success, 'num_faield' => $failed);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/
	// END PELUNASAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/
	// BEGIN VERIFIKASI PELUNASAN PEMBIAYAAN
	/****************************************************************************************/
	function verifikasi_pelunasan()
	{
		$branch_code = $this->session->userdata('branch_code');
		$data['container'] = 'nasabah/verifikasi_pelunasan';
		$data['account_cash'] = $this->model_transaction->ajax_get_gl_account_cash_by_keyword('', $branch_code, '0');
		$this->load->view('core', $data);
	}

	public function datatable_verifikasi_pelunasan_pembiayaan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('', 'mfi_account_financing.account_financing_no', 'mfi_cif.nama', 'mfi_akad.akad_name', 'mfi_account_financing.jangka_waktu', '');
		// $cm_code = @$_GET['cm_code'];

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

		$branch_code = $this->session->userdata('branch_code');

		$rResult 			= $this->model_nasabah->datatable_verifikasi_pelunasan_pembiayaan($sWhere, $sOrder, $sLimit, $branch_code); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_verifikasi_pelunasan_pembiayaan($sWhere, '', '', $branch_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal);
		$rResultTotal 		= $this->model_nasabah->datatable_verifikasi_pelunasan_pembiayaan('', '', '', $branch_code); // get number of all data
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
			$rembug = '';
			if ($aRow['cm_name'] != "") {
				$rembug = ' <a href="javascript:void(0);" class="btn mini green-stripe">' . $aRow['cm_name'] . '</a>';
			}
			$row[] = '<input type="checkbox" value="' . $aRow['account_financing_lunas_id'] . '" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'] . $rembug;
			$row[] = $aRow['akad_name'];
			$row[] = $aRow['jangka_waktu'] . " Pekan";
			$row[] = '<a href="javascript:;" account_financing_lunas_id="' . $aRow['account_financing_lunas_id'] . '" trx_account_financing_id = "' . $aRow['trx_account_financing_id'] . '" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}

	function proses_verifikasi_pelunasan_pembayaran()
	{
		$account_financing_lunas_id = $this->input->post('account_financing_lunas_id');
		$account_financing_id = $this->input->post('account_financing_id');
		$trx_account_financing_id = $this->input->post('trx_account_financing_id');
		$nama_lengkap = $this->input->post('nama_lengkap');
		$account_financing_no = $this->input->post('no_pembiayaan');
		$cash_type = $this->input->post('cash_type');
		$account_cash_code = $this->input->post('account_cash_code');
		$flag_catab = $this->input->post('flag_catab');
		$total_pembayaran = $this->input->post('total_pembayaran');
		$tanggal_jtempo = $this->input->post('tanggal_jtempo');
		$tanggal_lunas = $this->input->post('tanggal_lunas');
		$no_rek_tabungan = $this->input->post('no_rek_tabungan');
		$saldo_pokok = $this->input->post('saldo_pokok');
		$saldo_margin = $this->input->post('saldo_margin');
		$saldo_tabungan = $this->input->post('saldo_tabungan_trx');
		$saldo_catab = $this->input->post('saldo_tabungan');
		$saldo_memo = $this->input->post('saldo_memo');
		$tanggal_lunas = $this->input->post('tanggal_lunas');
		$counter_angsuran = $this->input->post('counter_angsuran');
		$freq = $this->input->post('freq');
		$jangka_waktu = $this->input->post('jangka_waktu');

		$total_pembayaran = $this->convert_numeric($total_pembayaran);
		$saldo_pokok = $this->convert_numeric($saldo_pokok);
		$saldo_margin = $this->convert_numeric($saldo_margin);
		$saldo_tabungan = $this->convert_numeric($saldo_tabungan);
		$saldo_catab = $this->convert_numeric($saldo_catab);
		$saldo_memo = $this->convert_numeric($saldo_memo);

		$created_by = $this->session->userdata('user_id');
		$created_date = date('Y-m-d H:i:s');

		$branch_id = $this->session->userdata('branch_id');

		$trx_detail_id = uuid(FALSE);

		$data = array(
			'status_pelunasan' => '1',
			'verify_by' => $created_by,
			'verifiy_date' => $created_date
		);

		$param = array('account_financing_lunas_id' => $account_financing_lunas_id);

		if ($flag_catab == '0') {
			$saldo_kalkulasi_catab = $saldo_catab + $saldo_tabungan;
		} else {
			$saldo_kalkulasi_catab = $saldo_catab;
		}

		$data_acc_financing = array(
			'status_rekening' => '2',
			'saldo_pokok' => '0',
			'saldo_margin' => '0',
			'saldo_catab' => '0'
		);

		$param_acc_financing = array('account_financing_no' => $account_financing_no);

		$data_trx_detail = array(
			'trx_detail_id' => $trx_detail_id,
			'trx_account_type' => '2',
			'trx_type' => '3',
			'account_no' => $account_financing_no,
			'flag_debit_credit'	=> 'C',
			'amount' => $total_pembayaran,
			'trx_date' => $tanggal_lunas,
			'account_no_dest' => $no_rek_tabungan,
			'created_by' => $created_by,
			'created_date' => $created_date
		);

		$trx_account_financing = array(
			'trx_detail_id' => $trx_detail_id,
			'reference_no' => $no_rek_tabungan,
			'verify_by' => $created_by,
			'verify_date' => $created_date
		);

		$param_trx_financing = array('trx_account_financing_id' => $trx_account_financing_id);

		$this->db->trans_begin();

		if ($saldo_kalkulasi_catab > 0) {
			$data_trx_account_saving = array(
				'branch_id' => $branch_id,
				'account_saving_no' => $no_rek_tabungan,
				'trx_saving_type' => '4',
				'flag_debit_credit' => 'C',
				'trx_date' => $tanggal_lunas,
				'amount' => $saldo_kalkulasi_catab,
				'reference_no' => $account_financing_no,
				'description' => 'PEMINDAHBUKUAN SALDO CATAB#PASS ACCT. ' . $nama_lengkap,
				'created_date' => $created_date,
				'created_by' => $created_by,
				'trx_detail_id' => $trx_detail_id,
				'verify_by' => $created_by,
				'verify_date' => $created_date,
				'trx_status' => '1',
				'account_cash_code' => $account_cash_code,
			);

			$this->model_nasabah->insert_mfi_trx_account_saving($data_trx_account_saving);

			$data_saving = array(
				'saldo_memo' => $saldo_kalkulasi_catab,
				'saldo_riil' => $saldo_kalkulasi_catab
			);

			$param_saving = array('account_saving_no' => $no_rek_tabungan);

			$this->model_nasabah->update_account_saving($data_saving, $param_saving);
		}

		if ($cash_type == '0') {
			// CASH
			$trx_gl_cash = uuid(FALSE);
			$data_trx_account_financing = $this->model_transaction->get_data_trx_account_financing_by_id($trx_account_financing_id);

			$data2 = array(
				'trx_gl_cash_id' =>  $trx_gl_cash,
				'trx_date' => $data_trx_account_financing['trx_date'],
				'account_cash_code' => $data_trx_account_financing['account_cash_code'],
				'trx_gl_cash_type' => 5,
				'flag_debet_credit' => 'D',
				'account_teller_code' => $data_trx_account_financing['account_cash_code'],
				'voucher_date' => $data_trx_account_financing['trx_date'],
				'voucher_ref' => $data_trx_account_financing['account_financing_no'],
				'description' => 'PELUNASAN PEMBIAYAAN PASS ACCT. ' . $account_financing_no,
				'created_by' => $created_by,
				'created_date' => $created_date,
				'amount' => $total_pembayaran,
				'status' => '1'
			);

			$this->model_transaction->insert_trx_gl_cash($data2);
		} else {
			// PINBUK
			$data_trx_account_saving = array(
				'branch_id' => $this->session->userdata('branch_id'),
				'account_saving_no' => $no_rek_tabungan,
				'trx_saving_type' => '4',
				'flag_debit_credit' => 'D',
				'trx_date' => $tanggal_lunas,
				'amount' => $total_pembayaran,
				'reference_no' => $account_financing_no,
				'description' => 'PENERIMAAN PEMBIAYAAN#PASS ACCT. ' . $nama_lengkap,
				'created_date' => $created_date,
				'created_by' => $created_by,
				'trx_sequence' => '4',
				'trx_detail_id' => $trx_detail_id,
				'verify_by' => $created_by,
				'verify_date' => $created_date,
				'trx_status' => '1',
				'account_cash_code' => $account_cash_code,
			);

			$this->model_nasabah->insert_mfi_trx_account_saving($data_trx_account_saving);
		}

		$this->model_nasabah->proses_verifikasi_pelunasan_pembayaran($data, $param);
		$this->model_nasabah->update_account_financing_data($data_acc_financing, $param_acc_financing);
		$this->model_nasabah->update_trx_account_financing($trx_account_financing, $param_trx_financing);
		$this->model_nasabah->insert_mfi_trx_detail($data_trx_detail);


		$this->model_nasabah->fn_proses_jurnal_pelunasan_pyd_individu($account_financing_lunas_id);

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return = array('success' => TRUE);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => FALSE);
		}

		echo json_encode($return);
	}

	function proses_verifikasi_pelunasan_pembayaran_new()
	{
		$account_financing_lunas_id = $this->input->post('account_financing_lunas_id');
		$account_financing_id = $this->input->post('account_financing_id');
		$trx_account_financing_id = $this->input->post('trx_account_financing_id');
		$nama_lengkap = $this->input->post('nama_lengkap');
		$account_financing_no = $this->input->post('no_pembiayaan');
		$cash_type = $this->input->post('cash_type');
		$account_cash_code = $this->input->post('account_cash_code');
		$flag_catab = $this->input->post('flag_catab');
		$total_pembayaran = $this->input->post('total_pembayaran');
		$tanggal_jtempo = $this->input->post('tanggal_jtempo');
		$tanggal_lunas = $this->input->post('tanggal_lunas');
		$no_rek_tabungan = $this->input->post('no_rek_tabungan');
		$saldo_pokok = $this->input->post('saldo_pokok');
		$saldo_margin = $this->input->post('saldo_margin');
		$saldo_tabungan = $this->input->post('saldo_tabungan_trx');
		$saldo_catab = $this->input->post('saldo_tabungan');
		$saldo_memo = $this->input->post('saldo_memo');
		$tanggal_lunas = $this->input->post('tanggal_lunas');
		$counter_angsuran = $this->input->post('counter_angsuran');
		$freq = $this->input->post('freq');
		$jangka_waktu = $this->input->post('jangka_waktu');

		$total_pembayaran = $this->convert_numeric($total_pembayaran);
		$saldo_pokok = $this->convert_numeric($saldo_pokok);
		$saldo_margin = $this->convert_numeric($saldo_margin);
		$saldo_tabungan = $this->convert_numeric($saldo_tabungan);
		$saldo_catab = $this->convert_numeric($saldo_catab);
		$saldo_memo = $this->convert_numeric($saldo_memo);

		$created_by = $this->session->userdata('user_id');
		$created_date = date('Y-m-d H:i:s');

		$branch_id = $this->session->userdata('branch_id');

		$trx_detail_id = uuid(FALSE);

		$data = array(
			'status_pelunasan' => '1',
			'verify_by' => $created_by,
			'verifiy_date' => $created_date
		);

		$param = array('account_financing_lunas_id' => $account_financing_lunas_id);

		if ($flag_catab == '0') {
			$saldo_kalkulasi_catab = $saldo_catab + $saldo_tabungan;
		} else {
			$saldo_kalkulasi_catab = $saldo_catab;
		}

		$data_acc_financing = array(
			'status_rekening' => '2',
			'saldo_pokok' => '0',
			'saldo_margin' => '0',
			'saldo_catab' => '0'
		);

		$param_acc_financing = array('account_financing_no' => $account_financing_no);

		$data_trx_detail = array(
			'trx_detail_id' => $trx_detail_id,
			'trx_account_type' => '2',
			'trx_type' => '3',
			'account_no' => $account_financing_no,
			'flag_debit_credit'	=> 'C',
			'amount' => $total_pembayaran,
			'trx_date' => $tanggal_lunas,
			'account_no_dest' => $no_rek_tabungan,
			'created_by' => $created_by,
			'created_date' => $created_date
		);

		$trx_account_financing = array(
			'trx_detail_id' => $trx_detail_id,
			'reference_no' => $no_rek_tabungan,
			'verify_by' => $created_by,
			'verify_date' => $created_date,
			'trx_status' => '1'
		);

		$param_trx_financing = array('trx_account_financing_id' => $trx_account_financing_id);

		if ($saldo_kalkulasi_catab > 0) {
			$data_trx_account_saving_catab = array(
				'branch_id' => $branch_id,
				'account_saving_no' => $no_rek_tabungan,
				'trx_saving_type' => '4',
				'flag_debit_credit' => 'C',
				'trx_date' => $tanggal_lunas,
				'amount' => $saldo_kalkulasi_catab,
				'reference_no' => $account_financing_no,
				'description' => 'PEMINDAHBUKUAN SALDO CATAB#PASS ACCT. ' . $nama_lengkap,
				'created_date' => $created_date,
				'created_by' => $created_by,
				'trx_detail_id' => $trx_detail_id,
				'verify_by' => $created_by,
				'verify_date' => $created_date,
				'trx_status' => '1',
				'account_cash_code' => $account_cash_code,
			);

			$data_saving = array(
				'saldo_memo' => $saldo_kalkulasi_catab,
				'saldo_riil' => $saldo_kalkulasi_catab
			);

			$param_saving = array('account_saving_no' => $no_rek_tabungan);
		}

		if ($cash_type == '0') {
			// CASH
			$trx_gl_cash = uuid(FALSE);
			$data_trx_account_financing = $this->model_transaction->get_data_trx_account_financing_by_id($trx_account_financing_id);

			$data2 = array(
				'trx_gl_cash_id' =>  $trx_gl_cash,
				'trx_date' => $data_trx_account_financing['trx_date'],
				'account_cash_code' => $data_trx_account_financing['account_cash_code'],
				'trx_gl_cash_type' => 5,
				'flag_debet_credit' => 'D',
				'account_teller_code' => $data_trx_account_financing['account_cash_code'],
				'voucher_date' => $data_trx_account_financing['trx_date'],
				'voucher_ref' => $data_trx_account_financing['account_financing_no'],
				'description' => 'PELUNASAN PEMBIAYAAN PASS ACCT. ' . $account_financing_no,
				'created_by' => $created_by,
				'created_date' => $created_date,
				'amount' => $total_pembayaran,
				'status' => '1'
			);
		} else {
			// PINBUK
			$data_trx_account_saving = array(
				'branch_id' => $this->session->userdata('branch_id'),
				'account_saving_no' => $no_rek_tabungan,
				'trx_saving_type' => '4',
				'flag_debit_credit' => 'D',
				'trx_date' => $tanggal_lunas,
				'amount' => $total_pembayaran,
				'reference_no' => $account_financing_no,
				'description' => 'PENERIMAAN PEMBIAYAAN#PASS ACCT. ' . $nama_lengkap,
				'created_date' => $created_date,
				'created_by' => $created_by,
				'trx_sequence' => '4',
				'trx_detail_id' => $trx_detail_id,
				'verify_by' => $created_by,
				'verify_date' => $created_date,
				'trx_status' => '1',
				'account_cash_code' => $account_cash_code,
			);
		}

		$this->db->trans_begin();

		if ($saldo_kalkulasi_catab > 0) {
			$this->model_nasabah->insert_mfi_trx_account_saving($data_trx_account_saving_catab);
			$this->model_nasabah->update_account_saving($data_saving, $param_saving);
		}

		if ($cash_type == '0') {
			$this->model_transaction->insert_trx_gl_cash($data2);
		} else {
			$this->model_nasabah->insert_mfi_trx_account_saving($data_trx_account_saving);
		}

		$this->model_nasabah->proses_verifikasi_pelunasan_pembayaran($data, $param);
		$this->model_nasabah->update_account_financing_data($data_acc_financing, $param_acc_financing);
		$this->model_nasabah->update_trx_account_financing($trx_account_financing, $param_trx_financing);
		$this->model_nasabah->insert_mfi_trx_detail($data_trx_detail);


		$this->model_nasabah->fn_proses_jurnal_pelunasan_pyd_individu($account_financing_lunas_id);

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return = array('success' => TRUE);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => FALSE);
		}

		echo json_encode($return);
	}

	function reject_data_pelunasan_pembiayaan()
	{
		$account_financing_lunas_id = $this->input->post('account_financing_lunas_id');
		$rekening = $this->input->post('account_financing_no');

		$param = array('account_financing_lunas_id' => $account_financing_lunas_id);
		$param2 = array('account_financing_no' => $rekening, 'trx_financing_type' => '2');
		$this->db->trans_begin();
		$this->model_nasabah->reject_data_pelunasan_pembiayaan($param);
		$this->model_nasabah->delete_trx_account_financing($param2);
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
	// END VERIFIKASI PELUNASAN PEMBIAYAAN
	/****************************************************************************************/


	/****************************************************************************************/
	// BEGIN PENCAIRAN PEMBIAYAAN
	/****************************************************************************************/
	function pencairan_pembiayaan()
	{
		$data['container'] = 'nasabah/pencairan_pembiayaan';
		$data['product'] = $this->model_transaction->get_product_financing();
		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['jaminan'] = $this->model_transaction->get_jenis_jaminan();
		$data['branch'] = $this->model_cif->get_all_branch();
		$data['trx_date'] = $this->current_date();
		$data['branchs'] = $this->model_cif->get_branchs();
		$this->load->view('core', $data);
	}



	public function datatable_pencairan_pembiayaan()
	{

		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('mfi_account_financing.account_financing_no', 'mfi_cif.nama', 'mfi_akad.akad_name', 'pokok', 'jangka_waktu', 'tanggal_akad', '');
		// $cm_code = @$_GET['cm_code'];

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
		// if($sWhere==""){
		// 		$sWhere = " WHERE mfi_account_financing_droping.status_droping ='0'";
		// 	}else{
		// 		$sWhere .= " AND mfi_account_financing_droping.status_droping ='0' ";
		// 	}
		else {
			$sWhere = "where mfi_account_financing_droping.status_droping ='0'";
		}

		// if($sWhere==""){
		// $sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		// }else{
		// $sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
		// }

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

		$rResult 			= $this->model_nasabah->datatable_pencairan_pembiayaan($sWhere, $sOrder, $sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_pencairan_pembiayaan($sWhere, '', ''); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal);
		$rResultTotal 		= $this->model_nasabah->datatable_pencairan_pembiayaan('', '', ''); // get number of all data
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
			$rembug = '';
			if ($aRow['cm_name'] != "") {
				$rembug = ' <a href="javascript:void(0);" class="btn mini green-stripe">' . $aRow['cm_name'] . '</a>';
			}
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'] . $rembug;
			$row[] = $aRow['akad_name'];
			$row[] = '<div align="right">Rp ' . number_format($aRow['pokok'], 0, ',', '.') . ',-</div>';
			$row[] = $aRow['jangka_waktu'] . " Minggu";
			$row[] = $aRow['tanggal_akad'];
			$row[] = '<a href="javascript:;" account_financing_id="' . $aRow['account_financing_id'] . '" id="link-edit">Pencairan</a>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}


	public function reject_pencairan_pembiayaan()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$account_financing_no = $this->input->post('account_financing_no');


		$data = array(
			'status_rekening' => 0,
			'approve_by'	 => null,
			'approve_date'	 => null
		);

		$param = array('account_financing_id' => $account_financing_id);
		$param_droping = array('account_financing_no' => $account_financing_no);

		$this->db->trans_begin();
		$this->model_transaction->verifikasi_rekening_pembiayaan($data, $param);
		$this->model_nasabah->delete_data_financing_from_financing_droping($param_droping);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	function proses_pencairan_rekening_pembiayaan()
	{
		$branch_id = $this->session->userdata('branch_id');
		$account_financing_id = $this->input->post('account_financing_id');
		$account_financing_no = $this->input->post('account_financing_no');
		$tanggal_akad = $this->input->post('tgl_akad');
		$tanggal_mulai_angsur = $this->input->post('angsuranke1');
		$tanggal_jtempo = $this->input->post('tgl_jtempo');
		$nilai_pembiayaan = str_replace(',', '', $this->input->post('nilai_pembiayaan'));
		$margin_pembiayaan = str_replace(',', '', $this->input->post('margin_pembiayaan'));
		$amount = $nilai_pembiayaan + $margin_pembiayaan;
		$created_by = $this->session->userdata('user_id');
		$created_date = date('Y-m-d H:i:s');

		$tgl_akad = substr($tanggal_akad, 0, 2);
		$bln_akad = substr($tanggal_akad, 2, 2);
		$thn_akad = substr($tanggal_akad, 4, 4);
		$tglakhir_akad = $thn_akad . '-' . $bln_akad . '-' . $tgl_akad;

		$tgl_mulai_angsur = substr($tanggal_mulai_angsur, 0, 2);
		$bln_mulai_angsur = substr($tanggal_mulai_angsur, 2, 2);
		$thn_mulai_angsur = substr($tanggal_mulai_angsur, 4, 4);
		$tglakhir_angsur = $thn_mulai_angsur . '-' . $bln_mulai_angsur . '-' . $tgl_mulai_angsur;

		$tgl_jtempo = substr($tanggal_jtempo, 0, 2);
		$bln_jtempo = substr($tanggal_jtempo, 2, 2);
		$thn_jtempo = substr($tanggal_jtempo, 4, 4);
		$tglakhir_jtempo = $thn_jtempo . '-' . $bln_jtempo . '-' . $tgl_jtempo;

		$data_financing_droping = array(
			'status_droping' => '1',
			'droping_by' => $created_by,
			'droping_date' => $tglakhir_akad
		);

		$param_financing_droping = array('account_financing_no' => $account_financing_no);

		$data_financing = array(
			'tanggal_akad' => $tglakhir_akad,
			'tanggal_mulai_angsur' => $tglakhir_angsur,
			'jtempo_angsuran_next' => $tglakhir_angsur,
			'tanggal_jtempo' => $tglakhir_jtempo
		);

		$param_financing = array('account_financing_id' => $account_financing_id);

		$data_default_balance = array(
			'account_financing_no' => $account_financing_no,
			'pokok_pembiayaan' => $nilai_pembiayaan,
			'margin_pembiayaan' => $margin_pembiayaan
		);

		$param_default_balance = array('account_financing_no' => $account_financing_no);

		$get_financing = $this->model_nasabah->get_account_financing_by_account_financing_no($account_financing_no);

		$trx_detail_id = uuid(FALSE);
		$trx_detail = array(
			'trx_detail_id' => $trx_detail_id,
			'trx_type' => '3',
			'trx_account_type' => '0',
			'account_no' => $account_financing_no,
			'flag_debit_credit' => 'D',
			'amount' => $amount,
			'trx_date' => $tglakhir_akad,
			'created_by' => $created_by,
			'created_date' => $created_date,
			'account_no_dest' => $account_financing_no,
			'account_type_dest' => '1'
		);

		$trx_account_financing = array(
			'branch_id' => $branch_id,
			'trx_detail_id' => $trx_detail_id,
			'account_financing_no' => $account_financing_no,
			'trx_financing_type' => '0',
			'trx_date' => $tglakhir_akad,
			'jto_date' => $get_financing['jtempo_angsuran_next'],
			'pokok' => $nilai_pembiayaan,
			'margin' => $margin_pembiayaan,
			'catab' => '0',
			'created_date' => $created_date,
			'created_by' => $created_by,
		);

		$this->db->trans_begin();

		$this->model_nasabah->insert_mfi_trx_detail($trx_detail);
		$this->model_nasabah->insert_mfi_trx_account_financing($trx_account_financing);

		$this->model_nasabah->fn_proses_jurnal_droping_pyd($account_financing_no);

		$this->model_nasabah->update_account_financing_droping($data_financing_droping, $param_financing_droping);
		$this->model_nasabah->update_account_financing($data_financing, $param_financing);
		$this->model_nasabah->update_default_balance($data_default_balance, $param_default_balance);

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return = array('success' => TRUE);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => FALSE);
		}

		echo json_encode($return);
	}


	/****************************************************************************************/
	// END PENCAIRAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/
	// BEGIN BLOKIR TABUNGAN
	/****************************************************************************************/
	public function blokir_rekening()
	{
		$data['container'] = 'nasabah/blokir_rekening';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}

	public function get_cif_by_account_saving_no()
	{
		$account_saving_no = $this->input->post('account_saving_no');
		$data = $this->model_nasabah->get_cif_by_account_saving_no($account_saving_no);

		echo json_encode($data);
	}

	public function proses_blokir_rek_tabungan()
	{
		$account_saving_id = $this->input->post('account_saving_id');
		$account_saving_no = $this->input->post('account_saving_no');
		$status_blokir	   = $this->input->post('status_blokir');
		$saldo_hold		   = $this->input->post('saldo_ditahan');
		$alasan 		   = $this->input->post('alasan');


		$data_blokir_saving = array(
			'account_saving_no' => $account_saving_no,
			'tipe_mutasi' => 2,
			// 'amount'=>$saldo_hold,
			'description' => $alasan,
			'created_date' => date('Y-m-d H:i:s'),
			'created_by' => $this->session->userdata('user_id')
		);

		if ($status_blokir == 1) { // apabila status blokir adalah Rekening
			$data_blokir_saving['amount'] = 0;
			$data = array('status_rekening' => 3);
		} else { // apabila status blokir adalah Saldo
			$data_blokir_saving['amount'] = $this->convert_numeric($saldo_hold);
			$data = array('saldo_hold' => $this->convert_numeric($saldo_hold));
		}
		$param = array('account_saving_id' => $account_saving_id);

		$this->db->trans_begin();
		$this->model_nasabah->update_account_saving_from_blokir($data, $param);
		$this->model_nasabah->insert_account_saving_blokir($data_blokir_saving);
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
	// END BLOKIR TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/
	// BEGIN BUKA ATAU PEMBATALAN TABUNGAN
	/****************************************************************************************/
	public function pembatalan_blokir()
	{
		$data['container'] = 'nasabah/pembatalan_blokir';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}

	public function get_cif_by_account_saving_no_for_buka()
	{
		$account_saving_no = $this->input->post('account_saving_no');
		$data = $this->model_nasabah->get_cif_by_account_saving_no_for_buka($account_saving_no);

		echo json_encode($data);
	}

	public function proses_buka_blokir_rek_tabungan()
	{
		$account_saving_blokir_id 	= $this->input->post('account_saving_blokir_id');
		$account_saving_id 			= $this->input->post('account_saving_id');
		$account_saving_no 			= $this->input->post('account_saving_no');
		$saldo_ditahan		   		= $this->convert_numeric($this->input->post('saldo_ditahan'));
		$saldo_hold		   			= $this->convert_numeric($this->input->post('saldo_hold'));
		$alasan 		   			= $this->input->post('alasan');
		$status_blokir 		   		= $this->input->post('status_blokir');

		if ($status_blokir == 1) { // apabila status blokir adalah Rekening
			$data = array('status_rekening' => 1);
		} else { // apabila status blokir adalah Saldo
			$data = array('saldo_hold' => $saldo_hold - $saldo_ditahan);
		}

		$data_blokir_saving = array(
			//'account_saving_no'=>$account_saving_no,
			'tipe_mutasi' => 3,
			'amount' => $saldo_hold,
			'description' => $alasan
			//'created_date'=>date('Y-m-d H:i:s'),
			//'created_by'=>$this->session->userdata('user_id')
		);

		$param			   	   	= array('account_saving_id'	=> $account_saving_id);
		$param_blokir_saving 	= array('account_saving_no'	=> $account_saving_no, 'tipe_mutasi' => 2);

		$this->db->trans_begin();
		$this->model_nasabah->update_account_saving_from_blokir($data, $param);
		$this->model_nasabah->update_account_saving_blokir($data_blokir_saving, $param_blokir_saving);
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
	// END BUKA PEMBATALAN BLOKIR TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/
	// BEGIN TUTUP REKENING TABUNGAN
	/****************************************************************************************/
	public function penutupan_rekening()
	{
		$data['container'] = 'nasabah/penutupan_rekening';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}

	public function proses_penutupan_rek_tabungan()
	{
		//$account_saving_blokir_id = $this->input->post('account_saving_blokir_id');
		$account_saving_no = $this->input->post('account_saving_no');
		//$saldo_hold		   = $this->input->post('saldo_ditahan');
		$alasan 		   = $this->input->post('alasan');

		$data_blokir_saving			   		= array(
			//'saldo_hold'			=>$saldo_hold,
			'tipe_mutasi'		=> 1,
			'description'		=> $alasan
		);
		$param_blokir_saving			   	= array('account_saving_no'		=> $account_saving_no);

		$this->db->trans_begin();
		$this->model_nasabah->update_account_saving_blokir($data_blokir_saving, $param_blokir_saving);
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
	// END TUTUP REKENING TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/
	// BEGIN ASURANSI KLAIM
	/****************************************************************************************/

	public function klaim_asuransi()
	{
		$data['container'] = 'nasabah/klaim_asuransi';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}

	public function search_cif_by_account_insurance_no()
	{
		$account_insurance_no = $this->input->post('account_insurance_no');
		$data = $this->model_nasabah->search_cif_by_account_insurance_no($account_insurance_no);

		echo json_encode($data);
	}

	public function pengajuan_klaim_asuransi()
	{
		$account_insurance_no = $this->input->post('no_rekening');
		$type_claim  		  = $this->input->post('jenis_klaim');
		$date_claim 		  = $this->input->post('tgl_klaim');
		$amount_claim 		  = $this->input->post('benefit_value');
		$created_by			  = $this->session->userdata('user_id');

		//Merubah format tanggal ke dalam format Inggris
		$tgl_klaim 			= substr("$date_claim", 0, 2);
		$bln_klaim 			= substr("$date_claim", 2, 2);
		$thn_klaim	 		= substr("$date_claim", 4, 4);
		$tglakhir_klaim		= "$thn_klaim-$bln_klaim-$tgl_klaim";

		$data 		= array(
			'account_insurance_no'	=> $account_insurance_no,
			'date_claim'			=> $tglakhir_klaim,
			'type_claim'			=> $type_claim,
			'amount_claim'			=> $amount_claim,
			'claim_status'			=> 0,
			'desc_status'			=> 'Pengajuan Klaim',
			'payment_status'		=> 0,
			'created_by'			=> $created_by,
			'created_date'			=> date('Y-m-d H:i:s')

		);

		$this->db->trans_begin();
		$this->model_nasabah->pengajuan_klaim_asuransi($data);
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
	// END ASURANSI KLAIM
	/****************************************************************************************/

	/****************************************************************************************/
	// BEGIN VERIFIKASI ASURANSI KLAIM
	/****************************************************************************************/

	public function verifikasi_klaim_asuransi()
	{
		$data['container'] = 'nasabah/verifikasi_klaim_asuransi';
		$this->load->view('core', $data);
	}

	/****************************************************************************************/
	// BEGIN VERIFIKASI ASURANSI
	/****************************************************************************************/

	public function datatable_verifikasi_insurance_klaim()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('', 'mfi_insurance_claim.account_insurance_no', 'mfi_cif.nama', 'mfi_product_insurance.product_name', 'mfi_insurance_claim.type_claim', 'mfi_insurance_claim.amount_claim', '');

		/* 
		 * Paging
		 */
		$sLimit = "";
		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = " OFFSET " . intval($_GET['iDisplayStart']) . " LIMIT " .
				intval($_GET['iDisplayLength']);
		}

		/*
		 * Orderuing
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
		} else {
			$sWhere = "where mfi_insurance_claim.claim_status ='0'";
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

		$rResult 			= $this->model_nasabah->datatable_verifikasi_insurance_klaim($sWhere, $sOrder, $sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_verifikasi_insurance_klaim($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal);
		$rResultTotal 		= $this->model_nasabah->datatable_verifikasi_insurance_klaim(); // get number of all data
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
			$rembug = '';
			if ($aRow['cm_name'] != "") {
				$rembug = ' <a href="javascript:void(0);" class="btn mini green-stripe">' . $aRow['cm_name'] . '</a>';
			}
			$row[] = '<input type="checkbox" value="' . $aRow['account_insurance_id'] . '" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_insurance_no'];
			$row[] = $aRow['nama'] . $rembug;
			$row[] = $aRow['product_name'];
			if ($aRow['type_claim'] == 0) {
				$type_claim = "Meninggal Dunia";
			} else if ($aRow['type_claim'] == 2) {
				$type_claim = "Dana Tunai";
			} else if ($aRow['type_claim'] == 3) {
				$type_claim = "Rawat Jalan";
			} else if ($aRow['type_claim'] == 4) {
				$type_claim = "Rawat Inap";
			}
			$row[] = $type_claim;
			$row[] = $aRow['amount_claim'];
			$row[] = '<a href="javascript:;" account_insurance_id="' . $aRow['account_insurance_id'] . '" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}

	public function search_cif_by_account_insurance_id()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$data = $this->model_nasabah->search_cif_by_account_insurance_id($account_insurance_id);

		echo json_encode($data);
	}

	public function proses_verifikasi_klaim_asuransi()
	{
		$insurance_claim_id 		= $this->input->post('insurance_claim_id');
		$approve_by 				= $this->session->userdata('user_id');
		$approve_date		  		= date('Y-m-d H:i:s');

		$data 				= array(
			'claim_status'			=> 1,
			'approve_by'	 	  	=> $approve_by,
			'approve_date'	  		=> $approve_date
		);
		$param 				= array('insurance_claim_id' => $insurance_claim_id);


		$this->db->trans_begin();
		$this->model_nasabah->proses_verifikasi_klaim_asuransi($data, $param);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	public function reject_data_klaim_asuransi()
	{
		$insurance_claim_id = $this->input->post('insurance_claim_id');

		$param = array('insurance_claim_id' => $insurance_claim_id);

		$this->db->trans_begin();
		$this->model_nasabah->reject_data_klaim_asuransi($param);
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
	// END VERIFIKASI ASURANSI KLAIM
	/****************************************************************************************/

	/* BEGIN REGISTRASI REKENING TABUNGAN *******************************************************/
	function registrasi_rekening_tabungan()
	{
		$data['container'] = 'transaction/registrasi_rekening_tabungan';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['product'] = $this->model_transaction->get_all_product_tabungan();
		$data['current_date'] = date("d/m/Y");
		$this->load->view('core', $data);
	}
	/* END REGISTRASI REKENING TABUNGAN *******************************************************/

	/* BEGIN REGISTRASI REKENING DEPOSITO *******************************************************/
	//Fungsi Untuk Menampilakan data Deposito
	public function registrasi_rekening_deposito()
	{
		$data['container'] = 'transaction/registrasi_rekening_deposito';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['product'] = $this->model_transaction->get_all_product();
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}
	/* END REGISTRASI REKENING DEPOSITO *******************************************************/

	/* BEGIN PENCAIRAN REKENING DEPOSITO *******************************************************/
	public function pencairan_deposito()
	{
		$data['container'] = 'transaction/registrasi_pencairan_deposito';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}
	/* END PENCAIRAN REKENING DEPOSITO *******************************************************/

	/* BEGIN VERIFIKASI DEPOSITO *******************************************************/
	public function verifikasi_reg_deposito()
	{
		$data['container'] = 'transaction/verifikasi_reg_deposito';
		$data['product'] = $this->model_transaction->get_product_deposito();
		$data['branch'] = $this->model_cif->get_all_branch();
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$this->load->view('core', $data);
	}
	/* END VERIFIKASI DEPOSITO *******************************************************/

	/* BEGIN VERIFIKASI CAIR DEPOSITO *******************************************************/
	public function verifikasi_cair_deposito()
	{
		$data['container'] = 'transaction/verifikasi_cair_deposito';
		$data['branch'] = $this->model_cif->get_all_branch();
		$data['product'] = $this->model_transaction->get_product_deposito();
		$this->load->view('core', $data);
	}
	/* END VERIFIKASI CAIR DEPOSITO *******************************************************/

	/* BEGIN PEMBIAYAAN *******************************************************/
	function pembiayaan()
	{
		$date_current = $this->model_transaction->date_current();
		$tgl = substr($date_current, 8, 2);
		$bln = substr($date_current, 5, 2);
		$thn = substr($date_current, 0, 4);
		$current_date = $tgl . '/' . $bln . '/' . $thn;

		$data['container'] = 'transaction/registrasi_rekening_pembiayaan';

		$data['date'] = $current_date;
		$data['kreditur'] = $this->model_cif->get_list_code('kreditur');
		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['pekerjaan'] = $this->model_transaction->get_pekerjaan();
		$data['grace'] = $this->model_transaction->get_grace_periode_kelompok();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['jaminan'] = $this->model_transaction->get_jenis_jaminan();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['fa_name_cm'] = ($this->session->userdata('fa_name_cm') == true) ? $this->session->userdata('fa_name_cm') : '';
		$data['pengguna_data'] = $this->model_transaction->get_pengguna_dana();

		$this->load->view('core', $data);
	}
	/* END PEMBIAYAAN *********************************************************************/

	/* BEGIN VERIFIKASI PEMBIAYAAN *******************************************************/
	function verifikasi_reg_pembiayaan()
	{
		$data['container'] = 'transaction/verifikasi_reg_pembiayaan';
		$data['product'] = $this->model_transaction->get_product_financing();
		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['jaminan'] = $this->model_transaction->get_jenis_jaminan();
		$data['branch'] = $this->model_cif->get_all_branch();
		$data['branchs'] = $this->model_cif->get_branchs();
		$data['trx_date'] = $this->current_date();
		$data['kreditur'] = $this->model_cif->get_list_code('kreditur');
		$this->load->view('core', $data);
	}
	/* END VERIFIKASI PEMBIAYAAN *******************************************************/

	/* BEGIN PERSEDIAAN MBA */
	function persediaan_mba()
	{
		$data['container'] = 'transaction/persediaan_mba';
		$data['branch'] = $this->model_cif->get_all_branch();
		$data['branchs'] = $this->model_cif->get_branchs();
		$this->load->view('core', $data);
	}
	/* END PERSEDIAAN MBA */

	/* BEGIN ASURANSI *******************************************************/
	public function asuransi()
	{
		$data['container'] = 'transaction/asuransi';
		$data['product'] = $this->model_transaction->get_all_product_insurance();
		$data['plan'] = $this->model_transaction->get_all_insurance_plan();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}
	/* END ASURANSI *******************************************************/

	/* BEGIN VERIFIKASI ASURANSI *******************************************************/
	public function verifikasi_peserta_asuransi()
	{
		$data['container'] = 'transaction/verifikasi_peserta_asuransi';
		$data['product'] = $this->model_transaction->get_all_product_insurance();
		$data['plan'] = $this->model_transaction->get_all_insurance_plan();
		$this->load->view('core', $data);
	}
	/* END VERIFIKASI ASURANSI *******************************************************/

	/*********************************************************************************/
	// BEGIN PENGAJUAN PEMBIAYAAN 
	/*********************************************************************************/
	public function pengajuan_pembiayaan()
	{
		$data['container'] 	= 'transaction/pengajuan_pembiayaan';

		$data['date'] = date('d/m/Y', strtotime($this->get_from_trx_date()));
		$data['tanggal_pencairan'] = date('d/m/Y', strtotime($this->get_from_trx_date() . ' +7 days'));

		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['pekerjaan'] = $this->model_transaction->get_pekerjaan();
		$data['grace'] = $this->model_transaction->get_grace_periode_kelompok();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}

	public function datatable_pengajuan_pembiayaan_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('', 'mafr.registration_no', 'mc.nama', 'mafr.tanggal_pengajuan', 'mafr.rencana_droping', 'mafr.amount', 'mafr.peruntukan', 'mafr.financing_type', '', '', '');

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
					$sWhere .= "LOWER(CAST(" . $aColumns[$i] . " AS VARCHAR)) LIKE '%" . strtolower($_GET['sSearch']) . "%' OR ";
			}
			$sWhere = substr_replace($sWhere, "", -3);
			$sWhere .= ')';
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

		$rResult 			= $this->model_nasabah->datatable_pengajuan_pembiayaan_setup($sWhere, $sOrder, $sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_pengajuan_pembiayaan_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal);
		$rResultTotal 		= $this->model_nasabah->datatable_pengajuan_pembiayaan_setup(); // get number of all data
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
			if ($aRow['status'] == 0) {
				$aRow['status'] = '<center><a href="javascript:;" account_financing_reg_id="' . $aRow['account_financing_reg_id'] . '" registration_no="' . $aRow['registration_no'] . '" id="link-edit">Edit</a></center>';
				$label_class = $aRow['status'];
			} elseif ($aRow['status'] == 1) {
				$aRow['status'] = 'Aktif';
				$classs = 'success';
				$label_class = '<span class="label label-' . $classs . '">' . $aRow['status'] . '</span>';
			} elseif ($aRow['status'] == 2) {
				$aRow['status'] = 'Ditolak';
				$label_class = '<span class="label label-' . $classs . '">' . $aRow['status'] . '</span>';
			} else {
				$aRow['status'] = 'Dibatalkan';
				$label_class = '<span class="label label-' . $classs . '">' . $aRow['status'] . '</span>';
			}

			if ($aRow['financing_type'] == 0) {
				$jenis = 'Kelompok';
			} else {
				$jenis = 'Individu';
			}

			$rembug = '';
			if ($aRow['cm_name'] != "") {
				$rembug = ' <a href="javascript:void(0);" class="btn mini green-stripe">' . $aRow['cm_name'] . '</a>';
			}

			$row = array();
			$row[] = '<input type="checkbox" value="' . $aRow['account_financing_reg_id'] . '" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['registration_no'];
			$row[] = $aRow['nama'] . $rembug;
			$row[] = $this->format_date_detail($aRow['tanggal_pengajuan'], 'id', false, '/');
			$row[] = $this->format_date_detail($aRow['rencana_droping'], 'id', false, '/');
			$row[] = '<div align="right">Rp ' . number_format($aRow['amount'], 0, ',', '.') . ',-</div>';
			$row[] = $aRow['display_peruntukan'];
			$row[] = $jenis;
			$row[] = $label_class;
			// $row[] = '<a href="javascript:;" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" id="link-edit">Edit</a>';
			$row[] = '<center><a href="javascript:;" account_financing_reg_id="' . $aRow['account_financing_reg_id'] . '" id="link_batal">Batalkan</a></center>';
			$row[] = '<center><a href="javascript:;" account_financing_reg_id="' . $aRow['account_financing_reg_id'] . '" id="link_tolak">Tolak</a></center>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}

	public function add_pengajuan_pembiayaan()
	{
		$cif_no				= $this->input->post('cif_no');
		$no_ktp				= $this->input->post('no_ktp');
		$branch_code		= $this->input->post('branch_code');
		$uang_muka			= '0';
		$amount				= $this->input->post('amount');
		$amountpengajuan	= $this->convert_numeric($amount);
		$peruntukan			= $this->input->post('peruntukan');
		$status				= '0';
		$description		= $this->input->post('keterangan');
		$financing_type		= $this->input->post('financing_type');
		$pyd				= $this->input->post('pyd');

		$tanggal_penga	 	= $this->input->post('tanggal_pengajuan');
		$tanggal_pengajuan_ = str_replace("/", "", $tanggal_penga);
		$tanggal_pengajuan = substr($tanggal_pengajuan_, 4, 4) . '-' . substr($tanggal_pengajuan_, 2, 2) . '-' . substr($tanggal_pengajuan_, 0, 2);

		$created_by			= $this->session->userdata('user_id');
		$created_date	 	= date('Y-m-d');

		$rencana_drop	 = $this->input->post('rencana_droping');
		$rencana_droping_ = str_replace("/", "", $rencana_drop);
		$rencana_droping = substr($rencana_droping_, 4, 4) . '-' . substr($rencana_droping_, 2, 2) . '-' . substr($rencana_droping_, 0, 2);


		$telp_no 			= $this->input->post('telp_no');
		$pekerjaan 			= $this->input->post('pekerjaan');
		$psg_pekerjaan 	 	= $this->input->post('psg_pekerjaan');
		$psg_telp			= $this->input->post('psg_telp');
		$pend_gaji 			= $this->input->post('pend_gaji');
		$pend_usaha 		= $this->input->post('pend_usaha');
		$pend_lainya   		= $this->input->post('pend_lainya');
		$jumlah_tanggungan 	= $this->input->post('jumlah_tanggungan');
		$ket_tanggungan		= $this->input->post('ket_tanggungan');
		$by_dapur 			= $this->input->post('by_dapur');
		$by_gas				= $this->input->post('by_gas');
		$by_listrik			= $this->input->post('by_listrik');
		$by_air 			= $this->input->post('by_air');
		$by_pulsa 			= $this->input->post('by_pulsa');
		$by_spp_anak 		= $this->input->post('by_spp_anak');
		$by_jajan_anak 		= $this->input->post('by_jajan_anak');
		$by_transport_anak 	= $this->input->post('by_transport_anak');
		$by_lainya_anak 	= $this->input->post('by_lainya_anak');
		$by_sewa_rumah 		= $this->input->post('by_sewa_rumah');
		$by_kredit 			= $this->input->post('by_kredit');
		$by_arisan 			= $this->input->post('by_arisan');
		$by_jajan 			= $this->input->post('by_jajan');
		$by_hutang_ph3 		= $this->input->post('by_hutang_ph3');
		$saving_power 		= $this->input->post('saving_power');
		$repayment_capacity = $this->input->post('repayment_capacity');
		$rumah_jml  		= $this->input->post('rumah_jml');
		$rumah_nom 			= $this->input->post('rumah_nom');
		$rumah_ket 			= $this->input->post('rumah_ket');
		$tanah_jml 			= $this->input->post('tanah_jml');
		$tanah_nom 			= $this->input->post('tanah_nom');
		$tanah_ket			= $this->input->post('tanah_ket');
		$mobil_jml 			= $this->input->post('mobil_jml');
		$mobil_nom			= $this->input->post('mobil_nom');
		$mobil_ket 			= $this->input->post('mobil_ket');
		$motor_jml 			= $this->input->post('motor_jml');
		$motor_nom			= $this->input->post('motor_nom');
		$motor_ket 			= $this->input->post('motor_ket');
		$sepeda_jml 		= $this->input->post('sepeda_jml');
		$sepeda_nom			= $this->input->post('sepeda_nom');
		$sepeda_ket 		= $this->input->post('sepeda_ket');
		$tv_jml 			= $this->input->post('tv_jml');
		$tv_nom				= $this->input->post('tv_nom');
		$tv_ket 			= $this->input->post('tv_ket');
		$dvd_jml 			= $this->input->post('dvd_jml');
		$dvd_nom			= $this->input->post('dvd_nom');
		$dvd_ket 			= $this->input->post('dvd_ket');
		$kulkas_jml			= $this->input->post('kulkas_jml');
		$kulkas_nom			= $this->input->post('kulkas_nom');
		$kulkas_ket 		= $this->input->post('kulkas_ket');
		$mcuci_jml 			= $this->input->post('mcuci_jml');
		$mcuci_nom			= $this->input->post('mcuci_nom');
		$mcuci_ket 			= $this->input->post('mcuci_ket');
		$ternak_jml 		= $this->input->post('ternak_jml');
		$ternak_nom			= $this->input->post('ternak_nom');
		$ternak_ket 		= $this->input->post('ternak_ket');
		$jenis_usaha  		= $this->input->post('jenis_usaha');
		$lama_usaha 		= $this->input->post('lama_usaha');
		$lokasi_usaha 		= $this->input->post('lokasi_usaha');
		$jenis_komoditi 	= $this->input->post('jenis_komoditi');
		$aset_usaha_nom		= $this->input->post('aset_usaha_nom');
		$no_izin_usaha		= $this->input->post('no_izin_usaha');
		$aset_usaha_desc 	= $this->input->post('aset_usaha_desc');
		$modal_awal			= $this->input->post('modal_awal');
		$omset_usaha		= $this->input->post('omset_usaha');
		$hpp_usaha			= $this->input->post('hpp_usaha');
		$persediaan_usaha	= $this->input->post('persediaan_usaha');
		$piutang_usaha		= $this->input->post('piutang_usaha');
		$frek_belanja 		= $this->input->post('frek_belanja');
		$laba_kotor			= $this->input->post('laba_kotor');
		$by_usaha_transport	= $this->input->post('by_usaha_transport');
		$by_usaha_kirim		= $this->input->post('by_usaha_kirim');
		$by_usaha_karyawan	= $this->input->post('by_usaha_karyawan');
		$by_usaha_perawatan	= $this->input->post('by_usaha_perawatan');
		$by_usaha_konsumsi	= $this->input->post('by_usaha_konsumsi');
		$by_usaha_sewa		= $this->input->post('by_usaha_sewa');
		$by_usaha_total		= $this->input->post('by_usaha_total');
		$laba_bersih		= $this->input->post('laba_bersih');
		$komoditi 			= $this->input->post('komoditi');
		$map_no	 			= $cif_no . "" . date('Ymdhis');
		$ttd_anggota                = $this->input->post('ttd_anggota');
		$ttd_ketua_majelis          = $this->input->post('ttd_ketua_majelis');
		$ttd_pasangan          		= $this->input->post('ttd_pasangan');
		$ttd_ketua_pasangan         = $this->input->post('ttd_ketua_pasangan');
		$ttd_tpl                    = $this->input->post('ttd_tpl');

		$nama_gambar = NULL;
		if ($ttd_anggota) {
			$path = APPPATH . '../assets/img/ttd/';
			$nama_gambar = sha1(rand() . date('Y-m-d H:i:s')) . '.png';

			$ttd_anggota = str_replace('data:image/png;base64,', '', $ttd_anggota);
			$ttd_anggota = str_replace(' ', '+', $ttd_anggota);
			$decoded_data = (base64_decode($ttd_anggota));

			file_put_contents($path . $nama_gambar, $decoded_data);
		}

		$nama_gambar_ketua_majelis = NULL;
		if ($ttd_ketua_majelis) {
			$path = APPPATH . '../assets/img/ttd/';
			$nama_gambar_ketua_majelis = sha1(rand() . date('Y-m-d H:i:s')) . '.png';

			$ttd_ketua_majelis = str_replace('data:image/png;base64,', '', $ttd_ketua_majelis);
			$ttd_ketua_majelis = str_replace(' ', '+', $ttd_ketua_majelis);
			$decoded_data = (base64_decode($ttd_ketua_majelis));

			file_put_contents($path . $nama_gambar_ketua_majelis, $decoded_data);
		}

		$nama_gambar_pasangan = NULL;
		if ($ttd_pasangan) {
			$path = APPPATH . '../assets/img/ttd/';
			$nama_gambar_pasangan = sha1(rand() . date('Y-m-d H:i:s')) . '.png';

			$ttd_pasangan = str_replace('data:image/png;base64,', '', $ttd_pasangan);
			$ttd_pasangan = str_replace(' ', '+', $ttd_pasangan);
			$decoded_data = (base64_decode($ttd_pasangan));

			file_put_contents($path . $nama_gambar_pasangan, $decoded_data);
		}

		$nama_gambar_tpl = NULL;
		if ($ttd_tpl) {
			$path = APPPATH . '../assets/img/ttd/';
			$nama_gambar_tpl = sha1(rand() . date('Y-m-d H:i:s')) . '.png';

			$ttd_tpl = str_replace('data:image/png;base64,', '', $ttd_tpl);
			$ttd_tpl = str_replace(' ', '+', $ttd_tpl);
			$decoded_data = (base64_decode($ttd_tpl));

			file_put_contents($path . $nama_gambar_tpl, $decoded_data);
		}

		$data = array(
			'cif_no'				=> $cif_no, 'amount'				=> $this->convert_numeric($amount), 'peruntukan'			=> $peruntukan, 'rencana_droping'		=> $rencana_droping, 'status'				=> $status, 'description'			=> $description, 'tanggal_pengajuan'	=> $tanggal_pengajuan, 'created_by'			=> $created_by, 'created_date'			=> $created_date, 'financing_type'		=> $financing_type, 'pembiayaan_ke'		=> $pyd, 'uang_muka'			=> $this->convert_numeric($uang_muka), 'map_no'	 			=> $map_no, 'ttd_anggota'         => $nama_gambar, 'ttd_ketua_majelis'   => $nama_gambar_ketua_majelis, 'ttd_suami'   	      => $nama_gambar_pasangan, 'ttd_tpl'             => $nama_gambar_tpl
		);

		$datamap = array(
			'cif_no'				=> $cif_no, 'pembiayaan_ke'		=> $pyd, 'telp_no' 				=> $telp_no, 'pekerjaan' 			=> $pekerjaan, 'psg_pekerjaan' 		=> $psg_pekerjaan, 'psg_telp' 			=> $psg_telp, 'registration_no'		=> $cif_no, 'pend_gaji'			=> $this->convert_numeric($pend_gaji), 'pend_usaha' 			=> $this->convert_numeric($pend_usaha), 'pend_lainya' 			=> $this->convert_numeric($pend_lainya), 'jumlah_tanggungan'	=> $jumlah_tanggungan, 'by_dapur' 			=> $this->convert_numeric($by_dapur), 'by_gas'				=> $this->convert_numeric($by_gas), 'by_listrik' 			=> $this->convert_numeric($by_listrik), 'by_air' 				=> $this->convert_numeric($by_air), 'by_pulsa'				=> $this->convert_numeric($by_pulsa), 'by_spp_anak'			=> $this->convert_numeric($by_spp_anak), 'by_jajan_anak' 		=> $this->convert_numeric($by_jajan_anak), 'by_transport_anak' 	=> $this->convert_numeric($by_transport_anak), 'by_lainya_anak'		=> $this->convert_numeric($by_lainya_anak), 'by_sewa_rumah' 		=> $this->convert_numeric($by_sewa_rumah), 'by_kredit' 			=> $this->convert_numeric($by_kredit), 'by_arisan'			=> $this->convert_numeric($by_arisan), 'by_jajan' 			=> $this->convert_numeric($by_jajan), 'by_hutang_ph3' 		=> $this->convert_numeric($by_hutang_ph3), 'saving_power' 		=> $this->convert_numeric($saving_power), 'repayment_capacity' 	=> $this->convert_numeric($repayment_capacity), 'rumah_jml' 			=> $rumah_jml, 'rumah_nom' 			=> $this->convert_numeric($rumah_nom), 'rumah_ket' 			=> $rumah_ket, 'tanah_jml' 			=> $tanah_jml, 'tanah_nom' 			=> $this->convert_numeric($tanah_nom), 'tanah_ket' 			=> $tanah_ket, 'mobil_jml' 			=> $mobil_jml, 'mobil_nom' 			=> $this->convert_numeric($mobil_nom), 'mobil_ket' 			=> $mobil_ket, 'motor_jml' 			=> $motor_jml, 'motor_nom' 			=> $this->convert_numeric($motor_nom), 'motor_ket' 			=> $motor_ket, 'sepeda_jml' 			=> $sepeda_jml, 'sepeda_nom' 			=> $this->convert_numeric($sepeda_nom), 'sepeda_ket' 			=> $sepeda_ket, 'tv_jml' 				=> $tv_jml, 'tv_nom' 				=> $this->convert_numeric($tv_nom), 'tv_ket' 				=> $tv_ket, 'dvd_jml' 				=> $dvd_jml, 'dvd_nom' 				=> $this->convert_numeric($dvd_nom), 'dvd_ket' 				=> $dvd_ket, 'kulkas_jml' 			=> $kulkas_jml, 'kulkas_nom' 			=> $this->convert_numeric($kulkas_nom), 'kulkas_ket' 			=> $kulkas_ket, 'mcuci_jml' 			=> $mcuci_jml, 'mcuci_nom' 			=> $this->convert_numeric($mcuci_nom), 'mcuci_ket' 			=> $mcuci_ket, 'ternak_jml' 			=> $ternak_jml, 'ternak_nom' 			=> $this->convert_numeric($ternak_nom), 'ternak_ket' 			=> $ternak_ket, 'jenis_usaha' 			=> $jenis_usaha, 'lama_usaha' 			=> $lama_usaha, 'lokasi_usaha' 		=> $lokasi_usaha, 'jenis_komoditi' 		=> $jenis_komoditi, 'aset_usaha_desc' 		=> $aset_usaha_desc, 'aset_usaha_nom'		=> $this->convert_numeric($aset_usaha_nom), 'no_izin_usaha'		=> $this->convert_numeric($no_izin_usaha), 'modal_awal' 			=> $this->convert_numeric($modal_awal), 'omset_usaha' 			=> $this->convert_numeric($omset_usaha), 'hpp_usaha' 			=> $this->convert_numeric($hpp_usaha), 'persediaan_usaha' 	=> $this->convert_numeric($persediaan_usaha), 'piutang_usaha' 		=> $this->convert_numeric($piutang_usaha), 'frek_belanja' 		=> $frek_belanja, 'laba_kotor' 			=> $this->convert_numeric($laba_kotor), 'by_usaha_transport' 	=> $this->convert_numeric($by_usaha_transport), 'by_usaha_kirim' 		=> $this->convert_numeric($by_usaha_kirim), 'by_usaha_karyawan' 	=> $this->convert_numeric($by_usaha_karyawan), 'by_usaha_perawatan' 	=> $this->convert_numeric($by_usaha_perawatan), 'by_usaha_konsumsi' 	=> $this->convert_numeric($by_usaha_konsumsi), 'by_usaha_sewa' 		=> $this->convert_numeric($by_usaha_sewa), 'by_usaha_total' 		=> $this->convert_numeric($by_usaha_total), 'laba_bersih' 			=> $this->convert_numeric($laba_bersih), 'map_no'	 			=> $map_no

		);

		$data_cif_kel = array(
			'pendapatan'			=> $pend_gaji, 'p_pekerjaan'			=> $psg_pekerjaan, 'byadapur'				=> $by_dapur, 'byalistrik'			=> $by_listrik, 'byatelpon'			=> $by_pulsa, 'byasekolah'			=> $by_spp_anak, 'ushkomoditi'			=> $komoditi, 'ushlokasi'			=> $lokasi_usaha, 'ushomset'				=> $omset_usaha
		);


		$dataktp = array('no_ktp' => $no_ktp);
		$param = array('cif_no' => $cif_no);

		$this->db->trans_begin();
		$this->model_nasabah->update_cif_no_ktp($dataktp, $param);
		$this->model_nasabah->add_map_pembiayaan($datamap);
		$this->model_nasabah->add_pengajuan_pembiayaan($data);
		//$this->model_nasabah->add_cif_kelompok($data_cif_kel);

		#$registration_no  	= $this->model_nasabah->get_new_registration_no($cif_no, $amountpengajuan, $pyd, $status, $created_by, $created_date); 

		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	public function edit_tanda_tangan2()
	{
		$map_no = $this->input->post('map_no');
		$ttd    = $this->input->post('ttd');
		$tipe   = $this->input->post('tipe');
		$path = APPPATH . '../assets/img/ttd/';
		$nama_gambar = sha1(date('Y-m-d H:i:s')) . '.png';

		$ttd = str_replace('data:image/png;base64,', '', $ttd);
		$ttd = str_replace(' ', '+', $ttd);
		$decoded_data = (base64_decode($ttd));

		file_put_contents($path . $nama_gambar, $decoded_data);

		$exec = $this->model_nasabah->edit_tanda_tangan2($map_no, $nama_gambar, $tipe);

		if ($exec) {
			$ret = ['code' => 200, 'new_image' => $nama_gambar];
		} else {
			$ret = ['code' => 500];
		}

		echo json_encode($ret);
	}

	public function get_pengajuan_pembiayaan_by_account_financing_reg_id()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$data = $this->model_nasabah->get_pengajuan_pembiayaan_by_account_financing_reg_id($account_financing_reg_id);

		echo json_encode($data);
	}

	public function edit_pengajuan_pembiayaan()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$financing_type2	= $this->input->post('financing_type2');
		$pyd				= $this->input->post('pyd2');
		$uang_muka			= '0';
		$amount				= $this->input->post('amount2');
		$peruntukan			= $this->input->post('peruntukan2');
		$description		= $this->input->post('keterangan2');
		$created_by			= $this->session->userdata('user_id');


		$tanggal_penga	 	= $this->input->post('tanggal_pengajuan2');
		$tanggal_pengajuan_ = str_replace("/", "", $tanggal_penga);
		$tanggal_pengajuan 	= substr($tanggal_pengajuan_, 4, 4) . '-' . substr($tanggal_pengajuan_, 2, 2) . '-' . substr($tanggal_pengajuan_, 0, 2);

		$rencana_drop	 	= $this->input->post('rencana_droping2');
		$rencana_droping_ 	= str_replace("/", "", $rencana_drop);
		$rencana_droping 	= substr($rencana_droping_, 4, 4) . '-' . substr($rencana_droping_, 2, 2) . '-' . substr($rencana_droping_, 0, 2);


		$registration_no	= $this->input->post('registration_no');
		$map_no				= $this->input->post('map_no');
		$telp_no 			= $this->input->post('telp_no2');
		$pekerjaan 			= $this->input->post('pekerjaan2');
		$psg_telp 			= $this->input->post('psg_telp2');
		$psg_pekerjaan 		= $this->input->post('psg_pekerjaan2');
		$pend_gaji			= $this->input->post('pend_gaji2');
		$pend_usaha			= $this->input->post('pend_usaha2');
		$pend_lainya		= $this->input->post('pend_lainya2');

		$jumlah_tanggungan	= $this->input->post('jumlah_tanggungan2');
		$ket_tanggungan		= $this->input->post('ket_tanggungan2');
		$by_dapur			= $this->input->post('by_dapur2');
		$by_gas 			= $this->input->post('by_gas2');
		$by_listrik			= $this->input->post('by_listrik2');
		$by_pulsa			= $this->input->post('by_pulsa2');
		$by_air				= $this->input->post('by_air2');
		$by_sewa_rumah		= $this->input->post('by_sewa_rumah2');
		$by_kredit			= $this->input->post('by_kredit2');
		$by_arisan			= $this->input->post('by_arisan2');
		$by_jajan			= $this->input->post('by_jajan2');
		$by_hutang_ph3		= $this->input->post('by_hutang_ph32');
		$by_spp_anak		= $this->input->post('by_spp_anak2');
		$by_jajan_anak		= $this->input->post('by_jajan_anak2');
		$by_transport_anak	= $this->input->post('by_transport_anak2');
		$by_lainya_anak		= $this->input->post('by_lainya_anak2');
		$saving_power		= $this->input->post('saving_power2');
		$repayment_capacity	= $this->input->post('repayment_capacity2');
		$jenis_usaha		= $this->input->post('jenis_usaha2');
		$jenis_komoditi		= $this->input->post('komoditi2');
		$lama_usaha			= $this->input->post('lama_usaha2');
		$lokasi_usaha		= $this->input->post('lokasi_usaha2');
		$aset_usaha_desc	= $this->input->post('aset_usaha_desc2');
		$aset_usaha_nom		= $this->input->post('aset_usaha_nom2');
		$modal_awal			= $this->input->post('modal_awal2');
		$omset_usaha		= $this->input->post('omset_usaha2');
		$hpp_usaha			= $this->input->post('hpp_usaha2');
		$persediaan_usaha	= $this->input->post('persediaan_usaha2');
		$piutang_usaha		= $this->input->post('piutang_usaha2');
		$frek_belanja		= $this->input->post('frek_belanja2');
		$laba_kotor			= $this->input->post('laba_kotor2');
		$by_usaha_transport	= $this->input->post('by_usaha_transport2');
		$by_usaha_kirim		= $this->input->post('by_usaha_kirim2');
		$by_usaha_karyawan	= $this->input->post('by_usaha_karyawan2');
		$by_usaha_perawatan	= $this->input->post('by_usaha_perawatan2');
		$by_usaha_konsumsi	= $this->input->post('by_usaha_konsumsi2');
		$by_usaha_sewa		= $this->input->post('by_usaha_sewa2');
		$rumah_jml			= $this->input->post('rumah_jml2');
		$rumah_nom			= $this->input->post('rumah_nom2');
		$rumah_ket			= $this->input->post('rumah_ket2');
		$tanah_jml			= $this->input->post('tanah_jml2');
		$tanah_nom			= $this->input->post('tanah_nom2');
		$tanah_ket			= $this->input->post('tanah_ket2');
		$mobil_jml			= $this->input->post('mobil_jml2');
		$mobil_nom			= $this->input->post('mobil_nom2');
		$mobil_ket			= $this->input->post('mobil_ket2');
		$motor_jml			= $this->input->post('motor_jml2');
		$motor_nom			= $this->input->post('motor_nom2');
		$motor_ket			= $this->input->post('motor_ket2');
		$sepeda_jml			= $this->input->post('sepeda_jml2');
		$sepeda_nom			= $this->input->post('sepeda_nom2');
		$sepeda_ket			= $this->input->post('sepeda_ket2');
		$tv_jml				= $this->input->post('tv_jml2');
		$tv_nom				= $this->input->post('tv_nom2');
		$tv_ket				= $this->input->post('tv_ket2');
		$dvd_jml			= $this->input->post('dvd_jml2');
		$dvd_nom			= $this->input->post('dvd_nom2');
		$dvd_ket			= $this->input->post('dvd_ket2');
		$kulkas_jml			= $this->input->post('kulkas_jml2');
		$kulkas_nom			= $this->input->post('kulkas_nom2');
		$kulkas_ket			= $this->input->post('kulkas_ket2');
		$mcuci_jml			= $this->input->post('mcuci_jml2');
		$mcuci_nom			= $this->input->post('mcuci_nom2');
		$mcuci_ket			= $this->input->post('mcuci_ket2');
		$ternak_jml			= $this->input->post('ternak_jml2');
		$ternak_nom			= $this->input->post('ternak_nom2');
		$ternak_ket			= $this->input->post('ternak_ket2');


		$data = array(
			'amount'				=> $this->convert_numeric($amount), 'peruntukan'			=> $peruntukan, 'rencana_droping'		=> $rencana_droping, 'description'			=> $description, 'created_by'			=> $created_by, 'financing_type'		=> $financing_type2, 'tanggal_pengajuan'	=> $tanggal_pengajuan, 'pembiayaan_ke'		=> $pyd, 'uang_muka'			=> $this->convert_numeric($uang_muka)
		);

		$param = array('account_financing_reg_id' => $account_financing_reg_id);


		$datamap = array(
			'telp_no' 				=> $telp_no, 'pekerjaan'			=> $pekerjaan, 'psg_telp' 			=> $psg_telp, 'psg_pekerjaan' 		=> $psg_pekerjaan, 'pend_gaji'			=> $this->convert_numeric($pend_gaji), 'pend_usaha'			=> $this->convert_numeric($pend_usaha), 'pend_lainya'			=> $this->convert_numeric($pend_lainya), 'jumlah_tanggungan'	=> $jumlah_tanggungan, 'ket_tanggungan' 		=> $ket_tanggungan, 'by_dapur'				=> $this->convert_numeric($by_dapur), 'by_gas'				=> $this->convert_numeric($by_gas), 'by_listrik'			=> $this->convert_numeric($by_listrik), 'by_pulsa'				=> $this->convert_numeric($by_pulsa), 'by_air'				=> $this->convert_numeric($by_air), 'by_sewa_rumah'		=> $this->convert_numeric($by_sewa_rumah), 'by_kredit'			=> $this->convert_numeric($by_kredit), 'by_arisan'			=> $this->convert_numeric($by_arisan), 'by_jajan'				=> $this->convert_numeric($by_jajan), 'by_hutang_ph3'		=> $this->convert_numeric($by_hutang_ph3), 'by_spp_anak'			=> $this->convert_numeric($by_spp_anak), 'by_jajan_anak'		=> $this->convert_numeric($by_jajan_anak), 'by_transport_anak'	=> $this->convert_numeric($by_transport_anak), 'by_lainya_anak'		=> $this->convert_numeric($by_lainya_anak), 'saving_power'			=> $this->convert_numeric($saving_power), 'repayment_capacity'	=> $this->convert_numeric($repayment_capacity), 'rumah_jml'			=> $rumah_jml, 'rumah_nom'			=> $this->convert_numeric($rumah_nom), 'rumah_ket'			=> $rumah_ket, 'tanah_jml'			=> $tanah_jml, 'tanah_nom'			=> $this->convert_numeric($tanah_nom), 'tanah_ket'			=> $tanah_ket, 'mobil_jml'			=> $mobil_jml, 'mobil_nom'			=> $this->convert_numeric($mobil_nom), 'mobil_ket'			=> $mobil_ket, 'motor_jml'			=> $motor_jml, 'motor_nom'			=> $this->convert_numeric($motor_nom), 'motor_ket'			=> $motor_ket, 'motor_jml'			=> $motor_jml, 'motor_nom'			=> $this->convert_numeric($motor_nom), 'motor_ket'			=> $motor_ket, 'sepeda_jml'			=> $sepeda_jml, 'sepeda_nom'			=> $this->convert_numeric($sepeda_nom), 'sepeda_ket'			=> $sepeda_ket, 'tv_jml'				=> $tv_jml, 'tv_nom'				=> $this->convert_numeric($tv_nom), 'tv_ket'				=> $tv_ket, 'dvd_jml'				=> $dvd_jml, 'dvd_nom'				=> $this->convert_numeric($dvd_nom), 'dvd_ket'				=> $dvd_ket, 'kulkas_jml'			=> $kulkas_jml, 'kulkas_nom'			=> $this->convert_numeric($kulkas_nom), 'kulkas_ket'			=> $kulkas_ket, 'mcuci_jml'			=> $mcuci_jml, 'mcuci_nom'			=> $this->convert_numeric($mcuci_nom), 'mcuci_ket'			=> $mcuci_ket, 'ternak_jml'			=> $ternak_jml, 'ternak_nom'			=> $this->convert_numeric($ternak_nom), 'ternak_ket'			=> $ternak_ket, 'jenis_usaha'			=> $jenis_usaha, 'jenis_komoditi'		=> $jenis_komoditi, 'lama_usaha'			=> $lama_usaha, 'lokasi_usaha'			=> $lokasi_usaha, 'aset_usaha_desc'		=> $aset_usaha_desc, 'aset_usaha_nom'		=> $this->convert_numeric($aset_usaha_nom), 'omset_usaha'			=> $this->convert_numeric($omset_usaha), 'hpp_usaha'			=> $this->convert_numeric($hpp_usaha), 'persediaan_usaha'		=> $this->convert_numeric($persediaan_usaha), 'piutang_usaha'		=> $this->convert_numeric($piutang_usaha), 'modal_awal'			=> $this->convert_numeric($modal_awal), 'frek_belanja'			=> $frek_belanja, 'laba_kotor'			=> $this->convert_numeric($laba_kotor), 'by_usaha_transport'	=> $this->convert_numeric($by_usaha_transport), 'by_usaha_kirim'		=> $this->convert_numeric($by_usaha_kirim), 'by_usaha_karyawan'	=> $this->convert_numeric($by_usaha_karyawan), 'by_usaha_perawatan'	=> $this->convert_numeric($by_usaha_perawatan), 'by_usaha_konsumsi'	=> $this->convert_numeric($by_usaha_konsumsi), 'by_usaha_sewa'		=> $this->convert_numeric($by_usaha_sewa)
		);

		$param_map = array('map_no' => $map_no);


		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data, $param);
		$this->model_nasabah->edit_map_pembiayaan($datamap, $param, $param_map);

		if ($this->db->trans_status() == true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	public function delete_pengajuan_pembiayaan()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$registration_no = $this->input->post('registration_no');
		$success = 0;
		$failed  = 0;
		for ($i = 0; $i < count($account_financing_reg_id); $i++) {
			$param = array('account_financing_reg_id' => $account_financing_reg_id[$i]);
			$param_map = array('registration_no' => $registration_no[$i]);
			#echo $param_map	;
			$this->db->trans_begin();
			$this->model_nasabah->delete_pengajuan_pembiayaan($param);
			$this->model_nasabah->delete_map_pembiayaan($param_map);
			if ($this->db->trans_status() === true) {
				$this->db->trans_commit();
				$success++;
			} else {
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if ($success == 0) {
			$return = array('success' => false, 'num_success' => $success, 'num_failed' => $failed);
		} else {
			$return = array('success' => true, 'num_success' => $success, 'num_faield' => $failed);
		}

		echo json_encode($return);
	}

	public function batal_pengajuan_pembiayaan()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');

		$data = array(
			'status'				=> "3"
		);

		$param = array('account_financing_reg_id' => $account_financing_reg_id);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data, $param);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	public function tolak_pengajuan_pembiayaan()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');

		$data = array(
			'status'				=> "2"
		);

		$param = array('account_financing_reg_id' => $account_financing_reg_id);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data, $param);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	public function history_outstanding_pembiayaan()
	{
		$cif_no 			= $this->input->post('cif_no');
		$data 				= $this->model_nasabah->history_outstanding_pembiayaan($cif_no);

		echo json_encode($data);
	}


	public function map_data()
	{
		$cif_no 			= $this->input->post('cif_no');
		$data 				= $this->model_nasabah->map_data($cif_no);

		echo json_encode($data);
	}

	public function get_pyd_ke()
	{
		$cif_no 	= $this->input->post('cif_no');
		$data 		= $this->model_nasabah->get_pyd_ke($cif_no);

		$jumlah = $data['jumlah'];
		if ($jumlah == null) {
			$total = 0;
		} else {
			$total = $jumlah;
		}

		$pyd = $total + 1;

		echo $pyd;
	}
	/*********************************************************************************/
	// END PENGAJUAN PEMBIAYAAN 
	/*********************************************************************************/

	/****************************************************************************************/
	// BEGIN RESCHEDULLING PEMBIAYAAN
	/****************************************************************************************/
	function re_scheduling()
	{
		$data['grace'] = $this->model_transaction->get_grace_periode_kelompok();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['container'] 	= 'nasabah/rescheduling';
		$this->load->view('core', $data);
	}

	public function get_cif_for_rechedulling()
	{
		$account_financing_no 	= $this->input->post('account_financing_no');
		$data 					= $this->model_nasabah->get_cif_for_rechedulling($account_financing_no);
		$current_date 			= $this->model_transaction->get_date_current();

		$tgl     				= substr("$current_date", 8, 2);
		$bln     				= substr("$current_date", 5, 2);
		$thn	        		= substr("$current_date", 0, 4);
		$data['current_date']	= "$tgl/$bln/$thn";

		echo json_encode($data);
	}

	public function ajax_get_pokok_reschedull()
	{
		$periode_angsuran 	= $this->input->post('periode_angsuran');
		$pokok 				= $this->input->post('pokok');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		if ($periode_angsuran == '0') {
			$tgl = $jangka_waktu . ' days';
			$total_pokok = $pokok / $tgl;
		} else if ($periode_angsuran == '1') {
			$tgl = $jangka_waktu . ' weeks';
			$total_pokok = $pokok / $tgl;
		} else {
			$tgl = $jangka_waktu . ' months';
			$total_pokok = $pokok / $tgl;
		}

		echo json_encode(array('total_pokok' => $total_pokok));
	}

	public function ajax_get_margin_reschedull()
	{
		$periode_angsuran 	= $this->input->post('periode_angsuran');
		$margin 				= $this->input->post('margin');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		if ($periode_angsuran == '0') {
			$tgl = $jangka_waktu . ' days';
			$total_margin = $margin / $tgl;
		} else if ($periode_angsuran == '1') {
			$tgl = $jangka_waktu . ' weeks';
			$total_margin = $margin / $tgl;
		} else {
			$tgl = $jangka_waktu . ' months';
			$total_margin = $margin / $tgl;
		}

		echo json_encode(array('total_margin' => $total_margin));
	}

	public function proses_rescheduling()
	{
		$cif_no = $this->input->post('cif_no');
		$account_financing_no = $this->input->post('account_financing_no');
		$nama = $this->input->post('nama');
		$nama_ibukandung = $this->input->post('nama_ibukandung');
		$tempatlahir = $this->input->post('tempatlahir');
		$tanggallahir = $this->input->post('tanggallahir');
		$usia = $this->input->post('usia');
		$pokok_o = $this->input->post('pokok_o');
		$margin_o = $this->input->post('margin_o');
		$saldopokok_o = $this->input->post('saldopokok_o');
		$saldomargin_o = $this->input->post('saldomargin_o');
		$saldocatab_o = $this->input->post('saldocatab_o');
		$jangkawaktu_o = $this->input->post('jangkawaktu_o');
		$periodejangkawaktu_o = $this->input->post('periodejangkawaktu_o');
		$angsuranpokok_o = $this->input->post('angsuranpokok_o');
		$angsuranmargin_o = $this->input->post('angsuranmargin_o');
		$angsurancatab_o = $this->input->post('angsurancatab_o');
		$angsurantabwajib_o = $this->input->post('angsurantabwajib_o');
		$angsurantabkelompok_o = $this->input->post('angsurantabkelompok_o');
		$tanggalakad_o = $this->input->post('tanggalakad_o');
		$tanggalmulaiangsur_o = $this->input->post('tanggalmulaiangsur_o');
		$tanggaljtempo_o = $this->input->post('tanggaljtempo_o');
		$saldopokok_n = $this->input->post('saldopokok_n');
		$saldomargin_n = $this->input->post('saldomargin_n');
		$saldocatab_n = $this->input->post('saldocatab_n');
		$jangkawaktu_n = $this->input->post('jangkawaktu_n');
		$periodejangkawaktu_n = $this->input->post('periodejangkawaktu_n');
		$angsuranpokok_n = $this->input->post('angsuranpokok_n');
		$angsuranmargin_n = $this->input->post('angsuranmargin_n');
		$angsurancatab_n = $this->input->post('angsurancatab_n');
		$angsurantabwajib_n = $this->input->post('angsurantabwajib_n');
		$angsurantabkelompok_n = $this->input->post('angsurantabkelompok_n');
		// $tanggalakad_n=$this->input->post('tanggalakad_n');
		$tanggalmulaiangsur_n = $this->input->post('tanggalmulaiangsur_n');
		$tanggaljtempo_n = $this->input->post('tanggaljtempo_n');
		$reschedule_ke = $this->input->post('reschedule_ke');
		$tanggal_reschedule = $this->input->post('tanggal_reschedule');
		$product_code = $this->input->post('product_code');

		/*convert date from id to en*/
		$tanggallahir = $this->datepicker_convert(true, $tanggallahir, '/');
		$tanggalakad_o = $this->datepicker_convert(true, $tanggalakad_o, '/');
		// $tanggalakad_n=$this->datepicker_convert(true,$tanggalakad_n,'/');
		$tanggalmulaiangsur_o = $this->datepicker_convert(true, $tanggalmulaiangsur_o, '/');
		$tanggalmulaiangsur_n = $this->datepicker_convert(true, $tanggalmulaiangsur_n, '/');
		$tanggaljtempo_o = $this->datepicker_convert(true, $tanggaljtempo_o, '/');
		$tanggaljtempo_n = $this->datepicker_convert(true, $tanggaljtempo_n, '/');
		$tanggal_reschedule = $this->datepicker_convert(true, $tanggal_reschedule, '/');

		$data = array(
			'product_code' => $product_code,
			'cif_no' => $cif_no,
			'branch_code' => $this->session->userdata('branch_code'),
			'account_financing_no' => $account_financing_no,
			'jangka_waktu_o' => $jangkawaktu_o,
			'jangka_waktu_n' => $jangkawaktu_n,
			'periode_jangka_waktu_o' => $periodejangkawaktu_o,
			'periode_jangka_waktu_n' => $periodejangkawaktu_n,
			'pokok_o' => $this->convert_numeric($pokok_o),
			'pokok_n' => $this->convert_numeric($saldopokok_n),
			'margin_o' => $this->convert_numeric($margin_o),
			'margin_n' => $this->convert_numeric($saldomargin_n),
			'angsuran_pokok_o' => $this->convert_numeric($angsuranpokok_o),
			'angsuran_pokok_n' => $this->convert_numeric($angsuranpokok_n),
			'angsuran_margin_o' => $this->convert_numeric($angsuranmargin_o),
			'angsuran_margin_n' => $this->convert_numeric($angsuranmargin_n),
			'angsuran_catab_o' => $this->convert_numeric($angsurancatab_o),
			'angsuran_catab_n' => $this->convert_numeric($angsurancatab_n),
			'angsuran_tab_wajib_o' => $this->convert_numeric($angsurantabwajib_o),
			'angsuran_tab_wajib_n' => $this->convert_numeric($angsurantabwajib_n),
			'angsuran_tab_kelompok_o' => $this->convert_numeric($angsurantabkelompok_o),
			'angsuran_tab_kelompok_n' => $this->convert_numeric($angsurantabkelompok_n),
			'saldo_pokok_o' => $this->convert_numeric($saldopokok_o),
			'saldo_margin_o' => $this->convert_numeric($saldomargin_o),
			'saldo_catab_o' => $this->convert_numeric($saldocatab_o),
			'tanggal_akad_o' => $tanggalakad_o,
			'tanggal_reschedule' => $tanggal_reschedule,
			'tanggal_mulai_angsur_o' => $tanggalmulaiangsur_o,
			'tanggal_mulai_angsur_n' => $tanggalmulaiangsur_n,
			'tanggal_jtempo_o' => $tanggaljtempo_o,
			'tanggal_jtempo_n' => $tanggaljtempo_n,
			'reschedule_ke' => $reschedule_ke,
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d H:i:s'),
			'status' => 0
		);

		$this->db->trans_begin();
		$this->model_nasabah->proses_rescheduling($data);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	public function reject_rescheduling()
	{
		$account_rescheduling_id = $this->input->post('account_rescheduling_id');
		$param = array('account_rescheduling_id' => $account_rescheduling_id);
		$this->db->trans_begin();
		$this->model_nasabah->reject_rescheduling($param);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}
		echo json_encode($return);
	}

	public function approve_rescheduling()
	{
		$account_rescheduling_id = $this->input->post('account_rescheduling_id');
		$account_financing_no = $this->input->post('account_financing_no');
		$pokok = $this->input->post('saldopokok_n');
		$margin = $this->input->post('saldomargin_n');
		$jangkawaktu = $this->input->post('jangkawaktu_n');
		$periodejangkawaktu = $this->input->post('periodejangkawaktu_n');
		$angsuranpokok = $this->input->post('angsuranpokok_n');
		$angsuranmargin = $this->input->post('angsuranmargin_n');
		$angsurancatab = $this->input->post('angsurancatab_n');
		$angsurantabwajib = $this->input->post('angsurantabwajib_n');
		$angsurantabkelompok = $this->input->post('angsurantabkelompok_n');
		$tanggal_reschedule = $this->input->post('tanggal_reschedule');
		$tanggalmulaiangsur = $this->input->post('tanggalmulaiangsur_n');
		$tanggaljtempo = $this->input->post('tanggaljtempo_n');

		/*convert date from id to en*/
		$tanggal_reschedule = $this->datepicker_convert(true, $tanggal_reschedule, '/');
		$tanggalmulaiangsur = $this->datepicker_convert(true, $tanggalmulaiangsur, '/');
		$tanggaljtempo = $this->datepicker_convert(true, $tanggaljtempo, '/');

		$data = array(
			'pokok' => $this->convert_numeric($pokok),
			'margin' => $this->convert_numeric($margin),
			'saldo_margin' => $this->convert_numeric($margin),
			'jangka_waktu' => $jangkawaktu,
			'periode_jangka_waktu' => $periodejangkawaktu,
			'angsuran_pokok' => $this->convert_numeric($angsuranpokok),
			'angsuran_margin' => $this->convert_numeric($angsuranmargin),
			'angsuran_catab' => $this->convert_numeric($angsurancatab),
			'angsuran_tab_wajib' => $this->convert_numeric($angsurantabwajib),
			'angsuran_tab_kelompok' => $this->convert_numeric($angsurantabkelompok),
			'tanggal_akad' => $tanggal_reschedule,
			'tanggal_mulai_angsur' => $tanggalmulaiangsur,
			'tanggal_jtempo' => $tanggaljtempo,
			'jtempo_angsuran_last' => $tanggaljtempo,
			'jtempo_angsuran_next' => $tanggalmulaiangsur,
			'counter_angsuran' => 0,
			'fl_reschedulle' => 'Y'
		);

		$param = array('account_financing_no' => $account_financing_no);
		$data_rescheduling = array('status' => 1, 'approve_by' => $this->session->userdata('user_id'), 'approve_date' => date('Y-m-d H:i:s'));
		$param_rescheduling = array('account_rescheduling_id' => $account_rescheduling_id);

		$this->db->trans_begin();
		$this->model_nasabah->update_account_financing($data, $param);
		$this->model_nasabah->update_rescheduling($data_rescheduling, $param_rescheduling);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}
		echo json_encode($return);
	}

	function verifikasi_rescheduling()
	{
		$data['container'] = 'nasabah/verifikasi_rescheduling';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$data['branch'] = $this->model_cif->get_all_branch();
		$this->load->view('core', $data);
	}

	public function datatable_verifikasi_rescheduling()
	{

		$aColumns = array('mfi_account_financing.account_financing_no', 'mfi_cif.nama', 'mfi_akad.akad_name', 'mfi_account_financing.jangka_waktu', '');
		$tanggal = @$_GET['tanggal_reschedule'];
		if ($tanggal != "") {
			$tanggal = $this->datepicker_convert(true, $tanggal, '/');
		}
		/*pagging*/
		$sLimit = "";
		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = " OFFSET " . intval($_GET['iDisplayStart']) . " LIMIT " .
				intval($_GET['iDisplayLength']);
		}
		/*ordering*/
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
		/*filtering*/
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

		$rResult 			= $this->model_nasabah->datatable_verifikasi_rescheduling($sWhere, $sOrder, $sLimit, $tanggal); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_verifikasi_rescheduling($sWhere, '', '', $tanggal); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal);
		$rResultTotal 		= $this->model_nasabah->datatable_verifikasi_rescheduling('', '', '', $tanggal); // get number of all data
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
			$rembug = '';
			if ($aRow['cm_name'] != "") {
				$rembug = ' <a href="javascript:void(0);" class="btn mini green-stripe">' . $aRow['cm_name'] . '</a>';
			}
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'] . $rembug;
			$row[] = '<div style="text-align:right">' . number_format($aRow['pokok_o'], 0, ',', '.') . '</div>';
			$row[] = '<div style="text-align:right">' . number_format($aRow['margin_o'], 0, ',', '.') . '</div>';
			$row[] = '<div style="text-align:center">' . $aRow['tanggal_jtempo_o'];
			$row[] = '<div style="text-align:center">' . $aRow['reschedule_ke'] . '</div>';
			$row[] = '<div style="text-align:center"><a href="javascript:void(0);" class="btn mini green" id="link-edit" cm_name="' . $aRow['cm_name'] . '" account_rescheduling_id="' . $aRow['account_rescheduling_id'] . '" account_financing_no="' . $aRow['account_financing_no'] . '" nama="' . $aRow['nama'] . '" ibu_kandung="' . $aRow['ibu_kandung'] . '" tmp_lahir="' . $aRow['tmp_lahir'] . '" tgl_lahir="' . $aRow['tgl_lahir'] . '" usia="' . $aRow['usia'] . '" jangka_waktu_o="' . $aRow['jangka_waktu_o'] . '" jangka_waktu_n="' . $aRow['jangka_waktu_n'] . '" periode_jangka_waktu_o="' . $aRow['periode_jangka_waktu_o'] . '" periode_jangka_waktu_n="' . $aRow['periode_jangka_waktu_n'] . '" pokok_o="' . $aRow['pokok_o'] . '" pokok_n="' . $aRow['pokok_n'] . '" margin_o="' . $aRow['margin_o'] . '" margin_n="' . $aRow['margin_n'] . '" angsuran_pokok_o="' . $aRow['angsuran_pokok_o'] . '" angsuran_pokok_n="' . $aRow['angsuran_pokok_n'] . '" angsuran_margin_o="' . $aRow['angsuran_margin_o'] . '" angsuran_margin_n="' . $aRow['angsuran_margin_n'] . '" angsuran_catab_o="' . $aRow['angsuran_catab_o'] . '" angsuran_catab_n="' . $aRow['angsuran_catab_n'] . '" saldo_pokok_o="' . $aRow['saldo_pokok_o'] . '" saldo_margin_o="' . $aRow['saldo_margin_o'] . '" saldo_catab_o="' . $aRow['saldo_catab_o'] . '" tanggal_akad_o="' . $aRow['tanggal_akad_o'] . '" tanggal_reschedule="' . $aRow['tanggal_reschedule'] . '" tanggal_mulai_angsur_o="' . $aRow['tanggal_mulai_angsur_o'] . '" tanggal_mulai_angsur_n="' . $aRow['tanggal_mulai_angsur_n'] . '" tanggal_jtempo_o="' . $aRow['tanggal_jtempo_o'] . '" tanggal_jtempo_n="' . $aRow['tanggal_jtempo_n'] . '" reschedule_ke="' . $aRow['reschedule_ke'] . '" angsuran_tab_wajib_o="' . $aRow['angsuran_tab_wajib_o'] . '" angsuran_tab_wajib_n="' . $aRow['angsuran_tab_wajib_n'] . '" angsuran_tab_kelompok_o="' . $aRow['angsuran_tab_kelompok_o'] . '" angsuran_tab_kelompok_n="' . $aRow['angsuran_tab_kelompok_n'] . '">Verifikasi</a></div>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}

	/****************************************************************************************/
	// END RESCHEDULLING PEMBIAYAAN
	/****************************************************************************************/


	/* GET PROGRAM KHUSUS BY KREDITUR */
	function get_program_khusus()
	{
		$program_owner_code = $this->input->post('program_owner_code');
		$data = $this->model_nasabah->get_program_khusus_by_program_owner_code($program_owner_code);

		echo json_encode($data);
	}



	/****************************************************************************************/
	// BEGIN PENCAIRAN TABUNGAN Ade 14072014
	/****************************************************************************************/
	function pencairan_tabungan()
	{
		$data['container'] = 'nasabah/pencairan_tabungan';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', FALSE, '/');
		$this->load->view('core', $data);
	}

	public function proses_pencairan_tabungan()
	{
		$account_saving_no 	= $this->input->post('no_rekening');
		$nama 	= $this->input->post('nama');
		$saldo_memo 		= $this->convert_numeric($this->input->post('saldo_memo'));
		$trx_detail_id 		= uuid(false);
		$saving 			= $this->model_nasabah->get_account_saving($account_saving_no);
		$tanggal 			= $this->datepicker_convert(true, $this->input->post('tanggal'), '/');

		$counter_angsruan = $saving['counter_angsruan'];
		$rencana_jangka_waktu = $saving['rencana_jangka_waktu'];

		if ($counter_angsruan == $rencana_jangka_waktu) {
			$flag_pencairan = 1;
		} else {
			$flag_pencairan = 2;
		}

		$data = array(
			'status_rekening'	=> 3
		);

		$data_trx_account_saving = array(
			'branch_id' => $this->session->userdata('branch_id'), 'account_saving_no' => $account_saving_no, 'trx_saving_type' => 5 // tutup rekening
			, 'flag_debit_credit' => 'D', 'trx_date' => $tanggal, 'amount' => $saldo_memo, 'created_date' => date('Y-m-d'), 'created_by' => $this->session->userdata('username'), 'description' => 'pencairan dan penutupan tabungan no. rek:' . $account_saving_no . ' a.n ' . $nama, 'trx_status' => 0, 'trx_detail_id' => $trx_detail_id, 'flag_pencairan' => $flag_pencairan
		);

		$data_trx_detail = array(
			'trx_detail_id' => $trx_detail_id, 'trx_type' => 1, 'trx_account_type' => 5 // tutup rekening
			, 'account_no' => $account_saving_no, 'flag_debit_credit' => 'D', 'amount' => $saldo_memo, 'trx_date' => $tanggal, 'description' => 'pencairan dan penutupan tabungan no. rek:' . $account_saving_no . ' a.n ' . $nama, 'created_by' => $this->session->userdata('username'), 'created_date' => date('Y-m-d')
		);

		$param = array('account_saving_no' => $account_saving_no);

		$this->db->trans_begin();
		$this->model_nasabah->proses_pencairan_tabungan($data, $param);
		$this->model_nasabah->insert_mfi_trx_detail($data_trx_detail);
		$this->model_nasabah->insert_mfi_trx_account_saving($data_trx_account_saving);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	public function reject_pencairan_tabungan()
	{
		$account_saving_no 			= $this->input->post('no_rekening');
		$trx_account_saving_id 			= $this->input->post('trx_account_saving_id');

		$trx_saving = $this->model_nasabah->get_trx_saving_by_id($trx_account_saving_id);
		$trx_detail_id = $trx_saving['trx_detail_id'];

		$data = array(
			'status_rekening' => 1
		);

		$param = array('account_saving_no' => $account_saving_no);
		$param2 = array('trx_account_saving_id' => $trx_account_saving_id);
		$param3 = array('trx_detail_id' => $trx_detail_id);
		$this->db->trans_begin();
		$this->model_nasabah->proses_pencairan_tabungan($data, $param);
		$this->model_nasabah->delete_trx_account_saving($param2);
		$this->model_nasabah->delete_trx_detail($param3);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}

		echo json_encode($return);
	}

	public function verifikasi_pencairan_tabungan()
	{
		$data['container'] = 'nasabah/verifikasi_pencairan_tabungan';
		$data['current_date'] = $this->format_date_detail($this->current_date(), 'id', false, '/');
		$branch_id = $this->session->userdata('branch_id');
		$data['branch'] = $this->model_cif->get_all_branch_id($branch_id);

		$this->load->view('core', $data);
	}

	public function grid_verifikasi_pencairan_tabungan()
	{
		$page 			= isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows 	= isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx 			= isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'cif_no'; //1
		$sort 			= isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'DESC';
		$branch_id 		= isset($_REQUEST['branch_id']) ? $_REQUEST['branch_id'] : '';
		$cm_name 		= isset($_REQUEST['cm_name']) ? $_REQUEST['cm_name'] : '';
		$nama 			= isset($_REQUEST['nama']) ? $_REQUEST['nama'] : '';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$result = $this->model_nasabah->grid_verifikasi_pencairan_tabungan('', '', '', '', $branch_id, $cm_name, $nama); //2

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

		$result = $this->model_nasabah->grid_verifikasi_pencairan_tabungan($sidx, $sort, $limit_rows, $start, $branch_id, $cm_name, $nama); //3

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row) {
			$responce['rows'][$i]['account_saving_no'] = $row['account_saving_no'];
			$responce['rows'][$i]['cell'] = array(
				$row['trx_date'], $row['product_name'], $row['branch_name'], $row['cm_name'], $row['account_saving_no'], $row['nama'], $row['saldo_memo'], $row['trx_account_saving_id']
			);
			$i++;
		}

		echo json_encode($responce);
	}

	public function proses_verifikasi_pencairan_tabungan()
	{
		$cif_no 					= $this->input->post('cif_no');
		$cif_type 					= $this->input->post('cif_type');
		$trx_account_saving_id 		= $this->input->post('trx_account_saving_id');
		$no_rekening 				= $this->input->post('no_rekening');
		$no_rekening_individu 		= $this->input->post('no_rekening_individu');
		$pencairan_ke 				= $this->input->post('pencairan_ke');
		$saldo_memo 				= $this->input->post('saldo_memo');
		$saldo_memo 				= $this->convert_numeric($saldo_memo);
		$jumlah_penarikan 			= $this->input->post('jumlah_penarikan');
		$jumlah_penarikan 			= $this->convert_numeric($jumlah_penarikan);
		$trx_date 					= $this->input->post('trx_date');

		$cif = $this->model_transaction->get_saldo_tab_sukarela($cif_no);

		//di cek nomor rekeningnya
		//individu atau kelompok
		if ($cif_type == '0') { // tabungan berencana

			$data_balance = array('tabungan_sukarela' => $cif['tabungan_sukarela'] + $jumlah_penarikan);
			$param_balance = array('cif_no' => $cif_no);

			$data_saving = array('saldo_memo' => 0, 'status_rekening' => 2);
			$param_saving = array('account_saving_no' => $no_rekening);

			$data_trx_sukarela = array();
			if ($jumlah_penarikan > 0) {
				$data_trx_sukarela[] = array(
					'cif_no' => $cif_no, 'account_saving_no' => $no_rekening, 'trx_date' => $trx_date, 'amount' => $jumlah_penarikan, 'trx_type' => 4, 'flag_debet_credit' => 'C', 'trx_source_id' => $trx_account_saving_id, 'created_stamp' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('user_id')
				);
			}

			$this->db->trans_begin();
			$this->model_nasabah->update_default_balance($data_balance, $param_balance);
			$this->model_transaction->update_account_saving($data_saving, $param_saving); // update tabungan berencana & tutup buku

			if (count($data_trx_sukarela) > 0) {
				$this->model_transaction->del_pinbuk_taber($param_saving);
				$this->model_transaction->insert_batch_trx_sukarela($data_trx_sukarela);
			}

			if ($this->db->trans_status() === true) {

				$this->db->trans_commit();
				$return = array('success' => true, 'message' => 'Pencairan Tabungan Berencana Berhasil!');

				$data_trx_account_saving = array(
					'verify_by' => $this->session->userdata('username'), 'verify_date' => date('Y-m-d'), 'trx_status' => 1
				);

				$param_trx_account_saving = array(
					'trx_account_saving_id' => $trx_account_saving_id
				);

				$this->db->trans_begin();
				$this->model_nasabah->update_mfi_trx_account_saving($data_trx_account_saving, $param_trx_account_saving);
				$this->model_transaction->fn_proses_jurnal_tutuptabunganberencana($trx_account_saving_id);
				if ($this->db->trans_status() === true) {
					$this->db->trans_commit();
				} else {
					$this->db->trans_rollback();
				}
			} else {

				$this->db->trans_rollback();
				$return = array('success' => false, 'message' => 'failed to connect into databases, please contact your administrator!');
			}
		} else if ($cif_type == '1') {

			if ($no_rekening_individu != "") { //validate nomor rekening tujuan
				$data_saving = array('saldo_memo' => 0, 'status_rekening' => 2);
				$param_saving = array('account_saving_no' => $no_rekening);
				$data_saving_tujuan = array('saldo_memo' => $saving['saldo_memo'] + $saldo_memo);
				$param_saving_tujuan = array('account_saving_no' => $no_rekening_individu);

				$data_trx_account_saving = array(
					'verify_by' => $this->session->userdata('username'), 'verify_date' => date('Y-m-d'), 'trx_status' => 1
				);

				$param_trx_account_saving = array(
					'trx_account_saving_id' => $trx_account_saving_id
				);

				$this->db->trans_begin();
				$this->model_transaction->update_account_saving($data_saving, $param_saving); // update tabungan berencana & tutup buku
				$this->model_transaction->update_account_saving($data_saving_tujuan, $param_saving_tujuan); // update tabungan berencana tujuan
				$this->model_nasabah->update_mfi_trx_account_saving($data_trx_account_saving, $param_trx_account_saving);
				$this->model_transaction->fn_proses_jurnal_tutuptabunganberencana($trx_account_saving_id);
				if ($this->db->trans_status() === true) {
					$this->db->trans_commit();
					$return = array('success' => true, 'message' => 'Pencairan Tabungan Berencana Berhasil!');
				} else {
					$this->db->trans_rollback();
					$return = array('success' => false, 'message' => 'failed to connect into databases, please contact your administrator!');
				}
			}
		} else {

			$return = array('success' => false, 'message' => 'failed to connect into databases, please contact your administrator!');
		}

		echo json_encode($return);
	}

	/****************************************************************************************/
	// END PENCAIRAN TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/
	// BEGIN CETAK AKAD PEMBIAYAAN Ade Sagita 18-08-2014
	/****************************************************************************************/
	public function cetak_akad_pembiayaan()
	{
		$data['container'] = 'nasabah/cetak_akad_pembiayaan';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}
	/****************************************************************************************/
	// END CETAK AKAD PEMBIAYAAN Ade Sagita 18-08-2014
	/****************************************************************************************/


	/*
	| Modul : Registrasi Pembiayaan
	| GENERATE TANGGAL ANGSURAN KE-1
	*/
	public function get_tanggal_mulai_angsur()
	{
		$tgl_akad = $this->input->post('tgl_akad');
		$periode_jangka_waktu = $this->input->post('periode_jangka_waktu');
		$cif_type = (int)$this->input->post('cif_type');
		$grace_periode = $this->model_transaction->get_grace_periode($cif_type);
		$grace_periode[0] = substr($grace_periode, 0, 1); //harian
		$grace_periode[1] = substr($grace_periode, 1, 1); //mingguan
		$grace_periode[2] = substr($grace_periode, 2, 1); //bulanan
		$grace_periode[3] = substr($grace_periode, 3, 1); //tahunan

		/*convert tgl_akad*/
		$tgl_akad = $this->datepicker_convert(true, $tgl_akad, '/');

		switch ($periode_jangka_waktu) {
			case '0';
				$tanggal_mulai_angsur = date('Y-m-d', strtotime($tgl_akad . " +" . $grace_periode[0] . " day"));
				break;
			case '1';
				$tanggal_mulai_angsur = date('Y-m-d', strtotime($tgl_akad . " +" . $grace_periode[1] . " week"));
				break;
			case '2';
				$tanggal_mulai_angsur = date('Y-m-d', strtotime($tgl_akad . " +" . $grace_periode[2] . " month"));
				break;
			case '3';
				$tanggal_mulai_angsur = '';
				break;
		}

		$iJto = 1;
		do {
			$cekHariLibur = $this->model_transaction->cekHariLibur($tanggal_mulai_angsur);

			if ($cekHariLibur == true) {
				if ($periode_jangka_waktu == 0) {
					$tanggal_mulai_angsur = date("Y-m-d", strtotime($tanggal_mulai_angsur . ' +1 days'));
				} else if ($periode_jangka_waktu == 1) {
					$tanggal_mulai_angsur = date("Y-m-d", strtotime($tanggal_mulai_angsur . ' +1 weeks'));
				} else if ($periode_jangka_waktu == 2) {
					$tanggal_mulai_angsur = $tanggal_mulai_angsur;
				} else if ($periode_jangka_waktu == 3) {
					$tanggal_mulai_angsur = '';
				}
				$iJto++;
			} else {
				break;
			}
		} while ($iJto > 1);

		echo json_encode(array('tanggal_mulai_angsur' => $tanggal_mulai_angsur));
	}

	/*
	| Modul : Registrasi Pembiayaan
	| GENERATE TANGGAL JATUH TEMPO
	*/
	public function get_tanggal_jatuh_tempo()
	{
		$tgl_akad = $this->input->post('tgl_akad');
		$mulai_angsur = $this->input->post('tgl_mulai_angsur');
		$jangka_waktu = (int)$this->input->post('jangka_waktu');
		$periode_jangka_waktu = $this->input->post('periode_jangka_waktu');
		$cif_type = (int)$this->input->post('cif_type');
		$grace_periode = $this->model_transaction->get_grace_periode($cif_type);
		$grace_periode[0] = substr($grace_periode, 0, 1); //harian
		$grace_periode[1] = substr($grace_periode, 1, 1); //mingguan
		$grace_periode[2] = substr($grace_periode, 2, 1); //bulanan
		$grace_periode[3] = substr($grace_periode, 3, 1); //tahunan
		$jangka_waktu = $jangka_waktu + $grace_periode[1] - 1;

		/*convert tgl_akad*/
		$tgl_akad = $this->datepicker_convert(true, $tgl_akad, '/');
		$mulai_angsur = $this->datepicker_convert(true, $mulai_angsur, '/');

		switch ($periode_jangka_waktu) {
			case '0';
				$tanggal_jtempo = date('Y-m-d', strtotime($tgl_akad . " +" . $jangka_waktu . " day"));
				break;
			case '1';
				$tanggal_jtempo = date('Y-m-d', strtotime($tgl_akad . " +" . $jangka_waktu . " week"));
				break;
			case '2';
				$tanggal_jtempo = date('Y-m-d', strtotime($tgl_akad . " +" . $jangka_waktu . " month"));
				break;
			case '3';
				$tanggal_jtempo = '';
				break;
		}

		$hitung_hari_libur = $this->model_nasabah->hitung_hari_libur($mulai_angsur, $tanggal_jtempo);
		$jumlah_hari_libur = $hitung_hari_libur['jumlah'];

		if ($jumlah_hari_libur > 0) {
			if ($periode_jangka_waktu == '0') {
				$tanggal_jatuh_tempo = date('Y-m-d', strtotime($tanggal_jtempo . ' + ' . $jumlah_hari_libur . ' DAYS'));
			} elseif ($periode_jangka_waktu == '1') {
				$tanggal_jatuh_tempo = date('Y-m-d', strtotime($tanggal_jtempo . ' + ' . $jumlah_hari_libur . ' WEEKS'));
			} elseif ($periode_jangka_waktu == '2') {
				$tanggal_jatuh_tempo = $tanggal_jtempo;
			} elseif ($periode_jangka_waktu == '3') {
				$tanggal_jatuh_tempo = '';
			}
		} else {
			$tanggal_jatuh_tempo = $tanggal_jtempo;
		}

		echo json_encode(array('tanggal_jtempo' => $tanggal_jatuh_tempo));
	}

	/*
	| Modul : Registrasi Pembiayaan
	| GENERATE TANGGAL ANGSURAN KE-1
	*/
	public function get_tanggal_mulai_angsur_for_rescheduling()
	{
		$tgl_akad = $this->input->post('tgl_akad');
		$periode_jangka_waktu = $this->input->post('periode_jangka_waktu');
		$cif_type = (int)$this->input->post('cif_type');
		$grace_periode = $this->model_transaction->get_grace_periode($cif_type);
		$grace_periode[0] = substr($grace_periode, 0, 1); //harian
		$grace_periode[1] = substr($grace_periode, 1, 1); //mingguan
		$grace_periode[2] = substr($grace_periode, 2, 1); //bulanan
		$grace_periode[3] = substr($grace_periode, 3, 1); //tahunan

		/*convert tgl_akad*/
		$tgl_akad = $this->datepicker_convert(true, $tgl_akad, '/');

		switch ($periode_jangka_waktu) {
			case '0';
				$tanggal_mulai_angsur = date('Y-m-d', strtotime($tgl_akad . " +" . $grace_periode[0] . " day"));
				break;
			case '1';
				$tanggal_mulai_angsur = date('Y-m-d', strtotime($tgl_akad . " +1 week")); //khusus re scheduling
				break;
			case '2';
				$tanggal_mulai_angsur = date('Y-m-d', strtotime($tgl_akad . " +" . $grace_periode[2] . " month"));
				break;
			case '3';
				$tanggal_mulai_angsur = '';
				break;
		}
		echo json_encode(array('tanggal_mulai_angsur' => $tanggal_mulai_angsur));
	}

	/*
	| Modul : Registrasi Pembiayaan
	| GENERATE TANGGAL JATUH TEMPO
	*/
	public function get_tanggal_jatuh_tempo_for_rescheduling()
	{
		$tgl_akad = $this->input->post('tgl_akad');
		$jangka_waktu = (int)$this->input->post('jangka_waktu');
		$periode_jangka_waktu = $this->input->post('periode_jangka_waktu');
		$cif_type = (int)$this->input->post('cif_type');
		$grace_periode = $this->model_transaction->get_grace_periode($cif_type);
		$grace_periode[0] = substr($grace_periode, 0, 1); //harian
		$grace_periode[1] = substr($grace_periode, 1, 1); //mingguan
		$grace_periode[2] = substr($grace_periode, 2, 1); //bulanan
		$grace_periode[3] = substr($grace_periode, 3, 1); //tahunan

		/*convert tgl_akad*/
		$tgl_akad = $this->datepicker_convert(true, $tgl_akad, '/');

		switch ($periode_jangka_waktu) {
			case '0';
				$tanggal_jtempo = date('Y-m-d', strtotime($tgl_akad . " +" . $jangka_waktu . " day"));
				break;
			case '1';
				$tanggal_jtempo = date('Y-m-d', strtotime($tgl_akad . " +" . $jangka_waktu . " week"));
				break;
			case '2';
				$tanggal_jtempo = date('Y-m-d', strtotime($tgl_akad . " +" . $jangka_waktu . " month"));
				break;
			case '3';
				$tanggal_jtempo = '';
				break;
		}

		echo json_encode(array('tanggal_jtempo' => $tanggal_jtempo));
	}


	/**
	 * AJAX GET SEQUENCE NUMBER OF ACCOUNT FINANCING NO
	 * @author sayyid nurkilah
	 * @param product_code
	 * @param cif_no
	 */
	function get_seq_account_financing_no()
	{
		$product_code = $this->input->post('product_code');
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->get_seq_account_financing_no($product_code, $cif_no);
		$jumlah = (int)$data['jumlah'];
		if (count($data) > 0) {
			$newseq = $jumlah + 1;
			if ($jumlah < 10) {
				$newseq = '0' . $newseq;
			}
		} else {
			$newseq = '01';
		}
		$return = array('newseq' => $newseq);
		echo json_encode($return);
	}

	/*
	| MODUL : GET BIAYA ADMINISTRASI PEMBIAYAAN
	*/
	public function get_biaya_administrasi()
	{
		$product_code = $this->input->post('product_code');
		$pokok = $this->convert_numeric($this->input->post('pokok'));
		$tanggal_akad = $this->datepicker_convert(true, $this->input->post('tanggal_akad'), '/');
		$tanggal_jtempo = $this->datepicker_convert(true, $this->input->post('tanggal_jtempo'), '/');

		$awal_kontrak = $tanggal_akad;
		$akhir_kontrak = $tanggal_jtempo;
		$diff = abs(strtotime($akhir_kontrak) - strtotime($awal_kontrak));
		$tahun_kontrak = floor($diff / (365 * 60 * 60 * 24));
		$months = floor(($diff - $tahun_kontrak * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days = floor(($diff - $tahun_kontrak * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
		if ($months >= 0) {
			$tahun_kontrak++;
		}

		$biaya_adm = $this->model_transaction->get_ajax_biaya_administrasi($product_code, $pokok, $tahun_kontrak);
		echo json_encode(array('biaya_administrasi' => $biaya_adm));
	}

	/*
	| MODUL : GET BIAYA ADMINISTRASI PEMBIAYAAN
	*/
	public function get_biaya_premi_asuransi_jiwa()
	{
		$product_code = $this->input->post('product_code');
		$manfaat = $this->convert_numeric($this->input->post('manfaat'));
		$usia = $this->input->post('usia');
		$tanggal_akad = $this->datepicker_convert(true, $this->input->post('tanggal_akad'), '/');
		$tanggal_jtempo = $this->datepicker_convert(true, $this->input->post('tanggal_jtempo'), '/');

		$awal_kontrak = $tanggal_akad;
		$akhir_kontrak = $tanggal_jtempo;
		$diff = abs(strtotime($akhir_kontrak) - strtotime($awal_kontrak));
		$tahun_kontrak = floor($diff / (365 * 60 * 60 * 24));
		$month_kontrak = floor(($diff - $tahun_kontrak * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days = floor(($diff - $tahun_kontrak * 365 * 60 * 60 * 24 - $month_kontrak * 30 * 60 * 60 * 24) / (60 * 60 * 24));
		if ($month_kontrak >= 0) {
			$tahun_kontrak++;
		}

		$biaya_premi = $this->model_transaction->get_ajax_biaya_premi_asuransi_jiwa($product_code, $manfaat, $tahun_kontrak, $month_kontrak, $usia, 0);
		echo json_encode(array('biaya_premi_asuransi_jiwa' => $biaya_premi));
	}

	public function search_account_financing_no()
	{
		$keyword = $this->input->post('keyword');
		$cm_code = $this->input->post('cm_code');
		$type = $this->input->post('cif_type');
		$status_rekening = $this->input->post('status_rekening');

		$data = $this->model_nasabah->search_account_financing_no($keyword, $cm_code, $status_rekening, $type);

		echo json_encode($data);
	}

	public function get_biaya_administrasi_saving_by_product_code()
	{
		$product_code = $this->input->post('product_code');
		$data = $this->model_nasabah->get_biaya_administrasi_saving_by_product_code($product_code);
		$biaya_administrasi = $data['biaya_administrasi'];
		$return = array('biaya_administrasi' => $biaya_administrasi);
		echo json_encode($return);
	}

	/*
	** Validasi pengajuan. Ade Sagita 16-03-2015, (dititah k sayyid)
	*/
	public function cek_aktif_pengajuan()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_nasabah->cek_aktif_pengajuan($cif_no);
		$return = (count($data) > 0) ? '1' : '0';
		echo $return;
	}
	public function cek_aktif_pembiayaan()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_nasabah->cek_aktif_pembiayaan($cif_no);
		$return = (count($data) > 0) ? '1' : '0';
		echo $return;
	}
	/*
	** END Validasi pengajuan. Ade Sagita 16-03-2015
	*/

	/*
	| Verifikasi Pembukaan Rekening
	*/
	function verifikasi_pembukaan_rekening()
	{
		$data['title'] = 'Verifikasi Pembukaan Rekening';
		$data['branchs'] = $this->model_cif->get_branchs();
		$data['container'] = 'nasabah/verifikasi_pembukaan_rekening';
		$this->load->view('core', $data);
	}

	function get_kas_petugas_by_branch_code()
	{
		$branch_code = $this->input->post('branch_code');
		$kas_petugas = $this->model_transaction->get_fa_by_branch_code($branch_code);
		echo json_encode($kas_petugas);
	}

	function get_kas_teller_by_branch_code()
	{
		$branch_code = $this->input->post('branch_code');
		$kas_teller = $this->model_transaction->get_account_cash_code_by_branch_code($branch_code);
		echo json_encode($kas_teller);
	}

	function datatable_verifikasi_pembukaan_rekening()
	{
		$aColumns = array('a.account_saving_no', 'b.nama', 'c.product_name', 'a.rencana_setoran', 'a.tanggal_buka', '');
		// $tanggal_buka = '';

		$tanggal_buka = '';
		if ($_GET['tanggal_buka'] != "") {
			$tanggal_buka = $this->datepicker_convert(true, $_GET['tanggal_buka'], '/');
		}
		$tanggal_buka2 = '';
		if ($_GET['tanggal_buka2'] != "") {
			$tanggal_buka2 = $this->datepicker_convert(true, $_GET['tanggal_buka2'], '/');
		}
		$param_branch_code = '';
		if ($_GET['param_branch_code'] != "") {
			$param_branch_code = $_GET['param_branch_code'];
		}

		// pagging
		$sLimit = "";
		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = " OFFSET " . intval($_GET['iDisplayStart']) . " LIMIT " . intval($_GET['iDisplayLength']);
		}
		// ordering
		$sOrder = "";
		if (isset($_GET['iSortCol_0'])) {
			$sOrder = "ORDER BY  ";
			for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
				if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
					$sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
				}
			}

			$sOrder = substr_replace($sOrder, "", -2);
			if ($sOrder == "ORDER BY") {
				$sOrder = "";
			}
		}
		// filtering
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

		$rResult 			= $this->model_nasabah->datatable_verifikasi_pembukaan_rekening($sWhere, $sOrder, $sLimit, $tanggal_buka, $tanggal_buka2, $param_branch_code); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_verifikasi_pembukaan_rekening($sWhere, '', '', $tanggal_buka, $tanggal_buka2, $param_branch_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal);
		$rResultTotal 		= $this->model_nasabah->datatable_verifikasi_pembukaan_rekening('', '', '', $tanggal_buka, $tanggal_buka2, $param_branch_code); // get number of all data
		$iTotal 			= count($rResultTotal);

		// output
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);

		foreach ($rResult as $aRow) {
			$row = array();
			$row[] = $aRow['account_saving_no'];
			$row[] = $aRow['cm_name'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['product_name'];
			$row[] = '<div align="right">' . number_format($aRow['rencana_setoran'], 0, ',', '.') . '</div>';
			$row[] = '<div align="center">' . date('d/m/Y', strtotime($aRow['tanggal_buka'])) . "</div>";
			$row[] = '<div align="center"><a href="javascript:;" class="btn mini green" account_saving_id="' . $aRow['account_saving_id'] . '" id="link-verifikasi">Verifikasi</a></div>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}

	function approve_pembukaan_tabungan()
	{
		$account_saving_id = $this->input->post('account_saving_id');
		$product2 = $this->input->post('product2');
		$tanggal_pembukaan = $this->datepicker_convert(TRUE, $this->input->post('tanggal_pembukaan2'), '/');

		$data = array('status_rekening' => '1');
		$param = array('account_saving_id' => $account_saving_id);

		$trx_gl_cash_id = uuid(FALSE);
		$kas_petugas = $this->input->post('kas_petugas');
		$trx_gl_cash_type = '4';
		$flag_debet_credit = 'D';
		$kas_teller = $this->input->post('kas_teller');
		$voucher_date = $tanggal_pembukaan;
		$voucher_ref = $this->input->post('account_saving_no2');
		$description = $this->input->post('keterangan');
		$created_by = $this->session->userdata('user_id');
		$created_date = date('Y-m-d H:i:s');
		$amount = $this->input->post('biaya_administrasi');

		$data_kas = array(
			'trx_gl_cash_id' => $account_saving_id,
			'trx_date' => $tanggal_pembukaan,
			'account_cash_code' => $kas_petugas,
			'trx_gl_cash_type' => $trx_gl_cash_type,
			'flag_debet_credit' => $flag_debet_credit,
			'account_teller_code' => $kas_teller,
			'voucher_date' => $voucher_date,
			'voucher_ref' => $voucher_ref,
			'description' => 'BIAYA ADMINISTRASI PEMBUKAAN ' . $product2,
			'created_by' => $created_by,
			'created_date' => $created_date,
			'amount' => str_replace('.', '', $amount),
			'status' => 1
		);

		$this->db->trans_begin();
		$this->model_transaction->insert_trx_gl_cash($data_kas);
		$this->model_transaction->update_mfi_account_saving($data, $param);
		$this->model_nasabah->fn_jurnal_biaya_adm_tab_berencana($account_saving_id, $kas_petugas);

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$return = array('success' => TRUE);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => FALSE);
		}

		echo json_encode($return);
	}

	function reject_pembukaan_tabungan()
	{
		$account_saving_id = $this->input->post('account_saving_id');

		$param = array('account_saving_id' => $account_saving_id);
		$this->db->trans_begin();
		$this->db->delete('mfi_account_saving', $param);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}
		echo json_encode($return);
	}

	public function generate_jtempo()
	{
		$periode_setoran = $this->input->post('periode_setoran');
		$jangka_waktu = $this->input->post('jangka_waktu');
		$setoran_next = $this->datepicker_convert(true, $this->input->post('setoran_next'), '/');

		if ($periode_setoran == '2') { //harian
			$return = date('d/m/Y', strtotime($setoran_next . '+' . ($jangka_waktu - 1) . 'days'));
		} else if ($periode_setoran == '1') { //mingguan
			$return = date('d/m/Y', strtotime($setoran_next . '+' . ($jangka_waktu - 1) . 'weeks'));
		} else { //bulanan
			$return = date('d/m/Y', strtotime($setoran_next . '+' . ($jangka_waktu - 1) . 'months'));
		}

		echo $return;
	}

	/*
	| [BEGIN]
	| MODUL : PENGHAPUSAN PEMBIAYAAN
	| berfungsi untuk menghapus pembiayaan yang salah droping
	| by : sayyid
	*/
	function penghapusan()
	{
		$data['title'] = 'Penghapusan Pembiayaan';
		$data['container'] = 'nasabah/penghapusan';
		$this->load->view('core', $data);
	}
	function jqgrid_data_penghapusan_pembiayaan()
	{
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
		$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 'data_peserta_id';
		$sord = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'ASC';
		$branch_code = isset($_REQUEST['branch_code']) ? $_REQUEST['branch_code'] : '';
		$cm_code = isset($_REQUEST['cm_code']) ? $_REQUEST['cm_code'] : '';
		$cif_no = isset($_REQUEST['cif_no']) ? $_REQUEST['cif_no'] : '';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) {
			$limit_rows = $totalrows;
		}

		$result = $this->model_nasabah->jqgrid_data_penghapusan_pembiayaan('', '', '', '', $branch_code, $cm_code, $cif_no);

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

		$result = $this->model_nasabah->jqgrid_data_penghapusan_pembiayaan($sidx, $sord, $limit_rows, $start, $branch_code, $cm_code, $cif_no);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row) {
			$responce['rows'][$i]['account_financing_id'] = $row['account_financing_id'];
			$responce['rows'][$i]['cell'] = array(
				$row['account_financing_id'], $row['cif_no'], $row['account_financing_no'], $row['cm_name'], $row['nama'], $row['pokok'], $row['margin'], $row['angsuran_pokok'], $row['angsuran_margin'], $row['angsuran_catab'], $row['saldo_pokok'], $row['saldo_margin'], $row['saldo_catab'], $row['tanggal_akad'], $row['jangka_waktu'], $row['periode_jangka_waktu'], $row['counter_angsuran'], $row['biaya_administrasi'], $row['biaya_asuransi_jiwa'], $row['biaya_asuransi_jaminan']

			);
			$i++;
		}

		echo json_encode($responce);
	}
	/*
	| [END]
	| MODUL : PENGHAPUSAN PEMBIAYAAN
	*/

	public function check_valid_data_tab_berencana()
	{
		$product_code = substr($this->input->post('product_code'), 1, 5);
		$cif_no = $this->input->post('cif_no');
		$nama = $this->input->post('nama');
		$account_saving_no = $this->input->post('account_saving_no');
		$product_name = $this->input->post('product_name');
		$get = $this->model_nasabah->check_valid_data_tab_berencana($product_code, $cif_no);
		if ($get['total'] > 0) {
			$return = array('valid' => false, 'message' => "Anggota " . $nama . " sudah memiliki produk " . $product_name . " dengan nomer rekening " . $account_saving_no . "");
		} else {
			$return = array('valid' => true);
		}
		echo json_encode($return);
	}

	function cek_angsuran()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$cek_angsuran = $this->model_nasabah->cek_angsuran($account_financing_no);
		$return = array('result' => $cek_angsuran);
		echo json_encode($return);
	}

	function koreksi_droping()
	{
		$data['title'] = "Koreksi Droping Pembiayaan";
		$data['container'] = 'nasabah/koreksi_droping';
		$data['sektor'] 		= $this->model_transaction->get_sektor();
		$data['peruntukan'] 	= $this->model_transaction->get_peruntukan();
		$data['jenis_program'] 	= $this->model_transaction->get_jenis_program_financing();
		$data['jaminan'] 		= $this->model_transaction->get_jenis_jaminan();
		$data['petugas'] 		= $this->model_transaction->get_petugas();
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$this->load->view('core', $data);
	}

	function get_koreksi_droping_financing_schedulle()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_nasabah->get_koreksi_droping_financing_schedulle($account_financing_no);

		echo json_encode($data);
	}


	function proses_koreksi_droping()
	{
		$account_financing_no = $this->input->post('account_financing_no');

		$pokok = $this->convert_numeric($this->input->post('pokok'));
		$margin = $this->convert_numeric($this->input->post('margin'));
		$jangka_waktu = $this->input->post('jangka_waktu');
		$tanggal_droping = $this->datepicker_convert(true, $this->input->post('tanggal_droping'), '/');
		$tanggal_mulai_angsur = $this->datepicker_convert(true, $this->input->post('tanggal_mulai_angsur'), '/');
		$tanggal_jtempo = $this->datepicker_convert(true, $this->input->post('tanggal_jtempo'), '/');
		$angsuran_pokok = $this->convert_numeric($this->input->post('angsuran_pokok'));
		$angsuran_margin = $this->convert_numeric($this->input->post('angsuran_margin'));
		// ------------------------------- new
		$uang_muka = $this->convert_numeric($this->input->post('uangmuka'));
		$titipan_notaris = $this->convert_numeric($this->input->post('titipannotaris'));
		$periode_jangka_waktu = $this->input->post('periode_jangka_waktu');
		$angsuran_catab = $this->convert_numeric($this->input->post('angsurancatab'));
		$angsuran_tab_wajib = $this->convert_numeric($this->input->post('angsuran_tab_wajib'));
		$angsuran_tab_kelompok = $this->convert_numeric($this->input->post('angsuran_tab_kelompok'));
		$simpanan_wajib_pinjam = $this->convert_numeric($this->input->post('simpananwajibpinjam'));
		$biaya_administrasi = $this->convert_numeric($this->input->post('biayaadministrasi'));
		$biaya_jasa_layanan = $this->convert_numeric($this->input->post('biayajasalayanan'));
		$biaya_notaris = $this->convert_numeric($this->input->post('biayanotaris'));
		$biaya_asuransi_jiwa = $this->convert_numeric($this->input->post('premiasuransijiwa'));
		$biaya_asuransi_jaminan = $this->convert_numeric($this->input->post('premiasuransijaminan'));
		$jenis_jaminan = $this->input->post('jaminanprimer');
		$keterangan_jaminan = $this->input->post('ketjaminanprimer');
		$jumlah_jaminan = $this->input->post('jmljaminanprimer');
		$nominal_taksasi = $this->convert_numeric($this->input->post('nominaljaminanprimer'));
		$presentasi_jaminan = $this->input->post('presentasejaminanprimer');
		$jenis_jaminan_sekunder = $this->input->post('jaminansekunder');
		$keterangan_jaminan_sekunder = $this->input->post('ketjaminansekunder');
		$jumlah_jaminan_sekunder = $this->input->post('jmljaminansekunder');
		$nominal_taksasi_sekunder = $this->convert_numeric($this->input->post('nominaljaminansekunder'));
		$presentasi_jaminan_sekunder = $this->input->post('presentasejaminansekunder');
		$sektor_ekonomi = $this->input->post('sektorekonomi');
		$peruntukan = $this->input->post('peruntukanpembiayaan');
		$flag_wakalah = $this->input->post('flagwakalah');
		$fa_code_o = $this->input->post('fa_code_o');
		$resort_code_o = $this->input->post('resort_code_o');

		$pokok2 = $this->convert_numeric($this->input->post('pokok2'));
		$margin2 = $this->convert_numeric($this->input->post('margin2'));
		$jangka_waktu2 = $this->input->post('jangka_waktu2');
		$tanggal_droping2 = $this->datepicker_convert(true, $this->input->post('tanggal_droping2'), '/');
		$tanggal_mulai_angsur2 = $this->datepicker_convert(true, $this->input->post('tanggal_mulai_angsur2'), '/');
		$tanggal_jtempo2 = $this->datepicker_convert(true, $this->input->post('tanggal_jtempo2'), '/');
		$angsuran_pokok2 = $this->convert_numeric($this->input->post('angsuran_pokok2'));
		$angsuran_margin2 = $this->convert_numeric($this->input->post('angsuran_margin2'));
		// ------------------------------- new
		$uang_muka2 = $this->convert_numeric($this->input->post('uangmuka2'));
		$titipan_notaris2 = $this->convert_numeric($this->input->post('titipannotaris2'));
		$periode_jangka_waktu2 = $this->input->post('periode_jangka_waktu2');
		$angsuran_catab2 = $this->convert_numeric($this->input->post('angsurancatab2'));
		$angsuran_tab_wajib2 = $this->convert_numeric($this->input->post('angsuran_tab_wajib2'));
		$angsurancatab2 = $this->convert_numeric($this->input->post('angsurancatab2'));
		$angsuran_tab_kelompok2 = $this->convert_numeric($this->input->post('angsuran_tab_kelompok2'));
		$simpanan_wajib_pinjam2 = $this->convert_numeric($this->input->post('simpananwajibpinjam2'));
		$biaya_administrasi2 = $this->convert_numeric($this->input->post('biayaadministrasi2'));
		$biaya_jasa_layanan2 = $this->convert_numeric($this->input->post('biayajasalayanan2'));
		$biaya_notaris2 = $this->convert_numeric($this->input->post('biayanotaris2'));
		$biaya_asuransi_jiwa2 = $this->convert_numeric($this->input->post('premiasuransijiwa2'));
		$biaya_asuransi_jaminan2 = $this->convert_numeric($this->input->post('premiasuransijaminan2'));
		$jenis_jaminan2 = $this->input->post('jaminanprimer2');
		$keterangan_jaminan2 = $this->input->post('ketjaminanprimer2');
		$jumlah_jaminan2 = $this->input->post('jmljaminanprimer2');
		$nominal_taksasi2 = $this->convert_numeric($this->input->post('nominaljaminanprimer2'));
		$presentasi_jaminan2 = $this->input->post('presentasejaminanprimer2');
		$jenis_jaminan_sekunder2 = $this->input->post('jaminansekunder2');
		$keterangan_jaminan_sekunder2 = $this->input->post('ketjaminansekunder2');
		$jumlah_jaminan_sekunder2 = $this->input->post('jmljaminansekunder2');
		$nominal_taksasi_sekunder2 = $this->convert_numeric($this->input->post('nominaljaminansekunder2'));
		$presentasi_jaminan_sekunder2 = $this->input->post('presentasejaminansekunder2');
		$sektor_ekonomi2 = $this->input->post('sektorekonomi2');
		$peruntukan2 = $this->input->post('peruntukanpembiayaan2');
		$flag_wakalah2 = $this->input->post('flagwakalah2');
		$fa_code_n = $this->input->post('fa_code_n');
		$resort_code_n = $this->input->post('resort_code_n');
		//----------------new 14-02-2015
		$jml_angsuran = $this->input->post('jml_angsuran');
		$desc_peruntukan2 = $this->input->post('desc_peruntukan2');

		$flag_jadwal_angsuran = $this->input->post('flag_jadwal_angsuran');
		$financing_type = $this->input->post('financing_type');

		$bValid = true;
		$debug = false;

		/*
	    /-----------new 14-12-2015 palentin saurna mah :D
	    /jika jml_angsuran lebih dari 0 maka hanya data jaminan dan peruntukan yg bisa diupdate
	    */
		if ($jml_angsuran > 0) {

			/*
		    | updating mfi_account_financing_reg (desc peruntukan) //----------------new 14-02-2015
		    */
			if ($bValid == true) {
				$registration_no = $this->input->post('registration_no');
				$desc_peruntukan = $this->input->post('desc_peruntukan');
				$desc_peruntukan2 = $this->input->post('desc_peruntukan2');

				if ($desc_peruntukan != $desc_peruntukan2) { //do update description

					$raw_account_financing_reg = array('description' => $desc_peruntukan2);
					$param_account_financing_reg = array('registration_no' => $registration_no);


					if ($debug == true) {
						echo "<pre>";
						print_r($raw_account_financing_reg);
						print_r($param_account_financing_reg);
					} else {
						$this->db->trans_begin();
						$this->db->update('mfi_account_financing_reg', $raw_account_financing_reg, $param_account_financing_reg);
						if ($this->db->trans_status() === true) {
							$this->db->trans_commit();
						} else {
							$this->db->trans_rollback();
							$bValid = false;
							$error_state = 1;
						}
					}
				}
			}
			/*
		    | updating mfi_account_financing (data non nominal) //----------------new 14-02-2015
		    */
			if ($bValid == true) {
				$raw_account_financing = array(
					'jenis_jaminan' => ($jenis_jaminan2 == "") ? NULL : $jenis_jaminan2, 'keterangan_jaminan' => ($keterangan_jaminan2 == "") ? NULL : $keterangan_jaminan2, 'jumlah_jaminan' => ($jumlah_jaminan2 == "") ? NULL : $jumlah_jaminan2, 'nominal_taksasi' => ($nominal_taksasi2 == "") ? NULL : $nominal_taksasi2, 'presentase_jaminan' => ($presentasi_jaminan2 == "") ? NULL : $presentasi_jaminan2, 'jenis_jaminan_sekunder' => ($jenis_jaminan_sekunder2 == "") ? NULL : $jenis_jaminan_sekunder2, 'keterangan_jaminan_sekunder' => ($keterangan_jaminan_sekunder2 == "") ? NULL : $keterangan_jaminan_sekunder2, 'jumlah_jaminan_sekunder' => ($jumlah_jaminan_sekunder2 == "") ? NULL : $jumlah_jaminan_sekunder2, 'nominal_taksasi_sekunder' => ($nominal_taksasi_sekunder2 == "") ? NULL : $nominal_taksasi_sekunder2, 'presentase_jaminan_sekunder' => ($presentasi_jaminan_sekunder2 == "") ? NULL : $presentasi_jaminan_sekunder2, 'sektor_ekonomi' => $sektor_ekonomi2, 'peruntukan' => $peruntukan2, 'flag_wakalah' => $flag_wakalah2
				);
				$param_account_financing = array('account_financing_no' => $account_financing_no);


				if ($debug == true) {
					echo "<pre>";
					print_r($raw_account_financing);
					print_r($param_account_financing);
				} else {
					$this->db->trans_begin();
					$this->db->update('mfi_account_financing', $raw_account_financing, $param_account_financing);
					if ($this->db->trans_status() === true) {
						$this->db->trans_commit();
					} else {
						$this->db->trans_rollback();
						$bValid = false;
						$error_state = 2;
					}
				}
			}
		} else //---------------- jumlah angsuran = 0
		{

			/*
	    	| updating mfi_trx_account_financing
	    	| updating mfi_trx_detail
	    	| berfungsi untuk mengubah data transaksi droping
	    	*/
			if ($pokok != $pokok2 || $margin != $margin2 || $tanggal_droping != $tanggal_droping2) {

				$param_upd_trx_acct_financing 	= array('account_financing_no' => $account_financing_no, 'trx_financing_type' => '0');
				$raw_upd_trx_acct_financing		= array('pokok' => $pokok2, 'margin' => $margin2, 'jto_date' => $tanggal_mulai_angsur2, 'trx_date' => $tanggal_droping2);

				$param_upd_trx_detail 			= array('account_no' => $account_financing_no, 'trx_type' => '3', 'trx_account_type' => '0');
				$raw_upd_trx_detail 			= array('amount' => $pokok2 + $margin2, 'trx_date' => $tanggal_droping2);

				if ($debug == true) {
					echo "<pre>";
					print_r($raw_upd_trx_acct_financing);
					print_r($raw_upd_trx_detail);
				} else {
					$this->db->trans_begin();
					$this->model_nasabah->update_trx_account_financing($raw_upd_trx_acct_financing, $param_upd_trx_acct_financing);
					$this->model_nasabah->update_trx_detail($raw_upd_trx_detail, $param_upd_trx_detail);
					if ($this->db->trans_status() === true) {
						$this->db->trans_commit();
					} else {
						$this->db->trans_rollback();
						$bValid = false;
						$error_state = 1;
					}
				}
			}

			/*
		    | updating mfi_account_saving
		    */
			if ($bValid == true) {
				if ($financing_type == 1) {
					$account_saving_no = $this->model_nasabah->get_account_saving_by_account_financing_no($account_financing_no);
					$account_saving = $this->model_nasabah->get_account_saving($account_saving_no);

					$biaya_sebelumnya = $biaya_administrasi + $biaya_notaris + $biaya_asuransi_jiwa + $biaya_asuransi_jaminan + $biaya_jasa_layanan + $simpanan_wajib_pinjam;
					$saldo_memo_sebelumnya = $account_saving['saldo_memo'] - ($pokok - $biaya_sebelumnya);
					$saldo_riil_sebelumnya = $account_saving['saldo_riil'] - ($pokok - $biaya_sebelumnya);
					$account_saving_no 	   = $account_saving['account_saving_no'];
					$raw_account_saving = array('saldo_memo' => $saldo_memo_sebelumnya, 'saldo_riil' => $saldo_riil_sebelumnya);

					$param_account_saving = array('account_saving_no' => $account_saving_no);


					if ($debug == true) {
						echo "<pre>";
						print_r($raw_account_saving);
						print_r($param_account_saving);
					} else {
						$this->db->trans_begin();
						$this->model_nasabah->update_account_saving($raw_account_saving, $param_account_saving);
						if ($this->db->trans_status() === true) {
							$this->db->trans_commit();
						} else {
							$this->db->trans_rollback();
							$bValid = false;
							$error_state = '1.1';
						}
					}
				}
			}

			/* 
		    | updating mfi_account_financing_droping
		    | updating mfi_account_financing
		    */
			if ($bValid == true) {

				$param_acct_financing_droping	= array('account_financing_no' => $account_financing_no);
				$raw_acct_financing_droping		= array('droping_date' => $tanggal_droping2);

				// reguler
				if ($flag_jadwal_angsuran == '1') {

					$param_acct_financing 			= array('account_financing_no' => $account_financing_no);
					$raw_acct_financing 			= array(
						'pokok' => $pokok2, 'margin' => $margin2, 'jangka_waktu' => $jangka_waktu2, 'tanggal_akad' => $tanggal_droping2, 'tanggal_mulai_angsur' => $tanggal_mulai_angsur2, 'tanggal_jtempo' => $tanggal_jtempo2, 'jtempo_angsuran_last' => $tanggal_droping2, 'jtempo_angsuran_next' => $tanggal_mulai_angsur2, 'angsuran_pokok' => $angsuran_pokok2, 'angsuran_margin' => $angsuran_margin2, 'angsuran_catab' => $angsuran_catab2, 'angsuran_tab_wajib' => $angsuran_tab_wajib2, 'angsuran_tab_kelompok' => $angsuran_tab_kelompok2, 'uang_muka' => $uang_muka2, 'titipan_notaris' => $titipan_notaris2, 'periode_jangka_waktu' => $periode_jangka_waktu2, 'simpanan_wajib_pinjam' => $simpanan_wajib_pinjam2, 'biaya_administrasi' => $biaya_administrasi2, 'biaya_jasa_layanan' => $biaya_jasa_layanan2, 'biaya_notaris' => $biaya_notaris2, 'biaya_asuransi_jiwa' => $biaya_asuransi_jiwa2, 'biaya_asuransi_jaminan' => $biaya_asuransi_jaminan2, 'jenis_jaminan' => ($jenis_jaminan2 == "") ? NULL : $jenis_jaminan2, 'keterangan_jaminan' => ($keterangan_jaminan2 == "") ? NULL : $keterangan_jaminan2, 'jumlah_jaminan' => ($jumlah_jaminan2 == "") ? NULL : $jumlah_jaminan2, 'nominal_taksasi' => ($nominal_taksasi2 == "") ? NULL : $nominal_taksasi2, 'presentase_jaminan' => ($presentasi_jaminan2 == "") ? NULL : $presentasi_jaminan2, 'jenis_jaminan_sekunder' => ($jenis_jaminan_sekunder2 == "") ? NULL : $jenis_jaminan_sekunder2, 'keterangan_jaminan_sekunder' => ($keterangan_jaminan_sekunder2 == "") ? NULL : $keterangan_jaminan_sekunder2, 'jumlah_jaminan_sekunder' => ($jumlah_jaminan_sekunder2 == "") ? NULL : $jumlah_jaminan_sekunder2, 'nominal_taksasi_sekunder' => ($nominal_taksasi_sekunder2 == "") ? NULL : $nominal_taksasi_sekunder2, 'presentase_jaminan_sekunder' => ($presentasi_jaminan_sekunder2 == "") ? NULL : $presentasi_jaminan_sekunder2, 'sektor_ekonomi' => $sektor_ekonomi2, 'peruntukan' => $peruntukan2, 'flag_wakalah' => $flag_wakalah2, 'fa_code' => $fa_code_n, 'resort_code' => $resort_code_n
					);
				} else {

					$param_acct_financing 			= array('account_financing_no' => $account_financing_no);
					$raw_acct_financing 			= array(
						'pokok' => $pokok2, 'margin' => $margin2, 'jangka_waktu' => $jangka_waktu2, 'tanggal_akad' => $tanggal_droping2, 'tanggal_mulai_angsur' => $tanggal_mulai_angsur2, 'tanggal_jtempo' => $tanggal_jtempo2, 'jtempo_angsuran_last' => $tanggal_droping2, 'jtempo_angsuran_next' => $tanggal_mulai_angsur2, 'uang_muka' => $uang_muka2, 'titipan_notaris' => $titipan_notaris2, 'periode_jangka_waktu' => $periode_jangka_waktu2, 'simpanan_wajib_pinjam' => $simpanan_wajib_pinjam2, 'biaya_administrasi' => $biaya_administrasi2, 'biaya_jasa_layanan' => $biaya_jasa_layanan2, 'biaya_notaris' => $biaya_notaris2, 'biaya_asuransi_jiwa' => $biaya_asuransi_jiwa2, 'biaya_asuransi_jaminan' => $biaya_asuransi_jaminan2, 'jenis_jaminan' => ($jenis_jaminan2 == "") ? NULL : $jenis_jaminan2, 'keterangan_jaminan' => ($keterangan_jaminan2 == "") ? NULL : $keterangan_jaminan2, 'jumlah_jaminan' => ($jumlah_jaminan2 == "") ? NULL : $jumlah_jaminan2, 'nominal_taksasi' => ($nominal_taksasi2 == "") ? NULL : $nominal_taksasi2, 'presentase_jaminan' => ($presentasi_jaminan2 == "") ? NULL : $presentasi_jaminan2, 'jenis_jaminan_sekunder' => ($jenis_jaminan_sekunder2 == "") ? NULL : $jenis_jaminan_sekunder2, 'keterangan_jaminan_sekunder' => ($keterangan_jaminan_sekunder2 == "") ? NULL : $keterangan_jaminan_sekunder2, 'jumlah_jaminan_sekunder' => ($jumlah_jaminan_sekunder2 == "") ? NULL : $jumlah_jaminan_sekunder2, 'nominal_taksasi_sekunder' => ($nominal_taksasi_sekunder2 == "") ? NULL : $nominal_taksasi_sekunder2, 'presentase_jaminan_sekunder' => ($presentasi_jaminan_sekunder2 == "") ? NULL : $presentasi_jaminan_sekunder2, 'sektor_ekonomi' => $sektor_ekonomi2, 'peruntukan' => $peruntukan2, 'flag_wakalah' => $flag_wakalah2, 'fa_code' => $fa_code_n, 'resort_code' => $resort_code_n
					);

					/*declare variable angsuran non reguler*/
					$sch_tgl_jtempo = $this->input->post('sch_tgl_jtempo');
					$sch_angsuran_pokok = $this->input->post('sch_angsuran_pokok');
					$sch_angsuran_margin = $this->input->post('sch_angsuran_margin');
					$sch_angsuran_tabungan = $this->input->post('sch_angsuran_tabungan');
					$param_acct_financing_schedulle = array('account_no_financing' => $account_financing_no);
					$raw_acct_financing_schedulle = array();
					for ($i = 0; $i < count($sch_tgl_jtempo); $i++) {
						$raw_acct_financing_schedulle[] = array(
							'account_no_financing' => $account_financing_no,
							'tangga_jtempo' => $this->datepicker_convert(true, $sch_tgl_jtempo[$i], '/'),
							'angsuran_pokok' => $this->convert_numeric($sch_angsuran_pokok[$i]),
							'angsuran_margin' => $this->convert_numeric($sch_angsuran_margin[$i]),
							'angsuran_tabungan' => $this->convert_numeric($sch_angsuran_tabungan[$i]),
							'status_angsuran' => 0,
							'bayar_pokok' => 0,
							'bayar_margin' => 0,
							'bayar_tabungan' => 0,
							'tabungan_wajib' => 0,
							'tabungan_kelompok' => 0
						);
					}
				}

				$registration_no = $this->model_nasabah->get_registration_no_by_account_financing_no($account_financing_no);
				$raw_acct_financing_reg = array('fa_code' => $fa_code_n, 'resort_code' => $resort_code_n);
				$param_acct_financing_reg = array('registration_no' => $registration_no);

				if ($debug == true) {
					echo "<pre>";
					print_r($raw_acct_financing_droping);
					print_r($raw_acct_financing);
					print_r($raw_acct_financing_reg);
				} else {
					$this->db->trans_begin();
					$this->model_nasabah->update_account_financing_droping($raw_acct_financing_droping, $param_acct_financing_droping);
					$this->model_nasabah->update_account_financing($raw_acct_financing, $param_acct_financing);
					/*tambahan(update ke table mfi financing reg)*/
					$this->model_nasabah->update_account_financing_reg($raw_acct_financing_reg, $param_acct_financing_reg);
					if ($flag_jadwal_angsuran == '0') { //Non Reguler
						if (count($raw_acct_financing_schedulle) > 0) {
							$this->model_nasabah->update_koreksi_droping_account_financing_schedulle($raw_acct_financing_schedulle, $param_acct_financing_schedulle);
						}
					}
					if ($this->db->trans_status() === true) {
						$this->db->trans_commit();
					} else {
						$this->db->trans_rollback();
						$bValid = false;
						$error_state = 2;
					}
				}
			}

			/*
		    | running procedure function droping by postgresql
		    */
			if ($bValid == true) {

				if ($debug == false) {
					$this->db->trans_begin();
					//$this->model_nasabah->fn_proses_jurnal_droping_pyd($account_financing_no);
					if ($this->db->trans_status() === true) {
						$this->db->trans_commit();
					} else {
						$this->db->trans_rollback();
						$bValid = false;
						$error_state = 3;
					}
				}
			}

			/*
		    | insert log koreksi droping
		    */
			if ($bValid == true) {

				$raw_log_koreksi_droping = array(
					'account_financing_no' => $account_financing_no, 'tanggal_koreksi' => date('Y-m-d H:i:s'), 'user_id' => $this->session->userdata('user_id'), 'status' => 0, 'verify_by' => NULL, 'verify_date' => NULL, 'pokok' => $pokok, 'margin' => $margin, 'jangka_waktu' => $jangka_waktu, 'tanggal_droping' => $tanggal_droping, 'tanggal_mulai_angsur' => $tanggal_mulai_angsur, 'tanggal_jtempo' => $tanggal_jtempo, 'angsuran_pokok' => $angsuran_pokok, 'angsuran_margin' => $angsuran_margin
					// ------------- new
					, 'uang_muka' => $uang_muka, 'titipan_notaris' => $titipan_notaris, 'periode_jangka_waktu' => $periode_jangka_waktu, 'angsuran_catab' => $angsuran_catab, 'angsuran_tab_wajib' => $angsuran_tab_wajib, 'angsuran_tab_kelompok' => $angsuran_tab_kelompok, 'simpanan_wajib_pinjam' => $simpanan_wajib_pinjam, 'biaya_administrasi' => $biaya_administrasi, 'biaya_jasa_layanan' => $biaya_jasa_layanan, 'biaya_notaris' => $biaya_notaris, 'biaya_asuransi_jiwa' => $biaya_asuransi_jiwa, 'biaya_asuransi_jaminan' => $biaya_asuransi_jaminan, 'jenis_jaminan' => ($jenis_jaminan == "") ? NULL : $jenis_jaminan, 'keterangan_jaminan' => ($keterangan_jaminan == "") ? NULL : $keterangan_jaminan, 'jumlah_jaminan' => ($jumlah_jaminan == "") ? NULL : $jumlah_jaminan, 'nominal_taksasi' => ($nominal_taksasi == "") ? NULL : $nominal_taksasi, 'presentase_jaminan' => ($presentasi_jaminan == "") ? NULL : $presentasi_jaminan, 'jenis_jaminan_sekunder' => ($jenis_jaminan_sekunder == "") ? NULL : $jenis_jaminan_sekunder, 'keterangan_jaminan_sekunder' => ($keterangan_jaminan_sekunder == "") ? NULL : $keterangan_jaminan_sekunder, 'jumlah_jaminan_sekunder' => ($jumlah_jaminan_sekunder == "") ? NULL : $jumlah_jaminan_sekunder, 'nominal_taksasi_sekunder' => ($nominal_taksasi_sekunder == "") ? NULL : $nominal_taksasi_sekunder, 'presentase_jaminan_sekunder' => ($presentasi_jaminan_sekunder == "") ? NULL : $presentasi_jaminan_sekunder, 'sektor_ekonomi' => $sektor_ekonomi, 'peruntukan' => $peruntukan, 'flag_wakalah' => $flag_wakalah, 'fa_code' => $fa_code_o, 'resort_code' => $resort_code_o, 'pokok2' => $pokok2, 'margin2' => $margin2, 'jangka_waktu2' => $jangka_waktu2, 'tanggal_droping2' => $tanggal_droping2, 'tanggal_mulai_angsur2' => $tanggal_mulai_angsur2, 'tanggal_jtempo2' => $tanggal_jtempo2, 'angsuran_pokok2' => $angsuran_pokok2, 'angsuran_margin2' => $angsuran_margin2
					// ------------- new
					, 'uang_muka2' => $uang_muka2, 'titipan_notaris2' => $titipan_notaris2, 'periode_jangka_waktu2' => $periode_jangka_waktu2, 'angsuran_catab2' => $angsuran_catab2, 'angsuran_tab_wajib2' => $angsuran_tab_wajib2, 'angsuran_tab_kelompok2' => $angsuran_tab_kelompok2, 'simpanan_wajib_pinjam2' => $simpanan_wajib_pinjam2, 'biaya_administrasi2' => $biaya_administrasi2, 'biaya_jasa_layanan2' => $biaya_jasa_layanan2, 'biaya_notaris2' => $biaya_notaris2, 'biaya_asuransi_jiwa2' => $biaya_asuransi_jiwa2, 'biaya_asuransi_jaminan2' => $biaya_asuransi_jaminan2, 'jenis_jaminan2' => ($jenis_jaminan2 == "") ? NULL : $jenis_jaminan2, 'keterangan_jaminan2' => ($keterangan_jaminan2 == "") ? NULL : $keterangan_jaminan2, 'jumlah_jaminan2' => ($jumlah_jaminan2 == "") ? NULL : $jumlah_jaminan2, 'nominal_taksasi2' => ($nominal_taksasi2 == "") ? NULL : $nominal_taksasi2, 'presentase_jaminan2' => ($presentasi_jaminan2 == "") ? NULL : $presentasi_jaminan2, 'jenis_jaminan_sekunder2' => ($jenis_jaminan_sekunder2 == "") ? NULL : $jenis_jaminan_sekunder2, 'keterangan_jaminan_sekunder2' => ($keterangan_jaminan_sekunder2 == "") ? NULL : $keterangan_jaminan_sekunder2, 'jumlah_jaminan_sekunder2' => ($jumlah_jaminan_sekunder2 == "") ? NULL : $jumlah_jaminan_sekunder2, 'nominal_taksasi_sekunder2' => ($nominal_taksasi_sekunder2 == "") ? NULL : $nominal_taksasi_sekunder2, 'presentase_jaminan_sekunder2' => ($presentasi_jaminan_sekunder2 == "") ? NULL : $presentasi_jaminan_sekunder2, 'sektor_ekonomi2' => $sektor_ekonomi2, 'peruntukan2' => $peruntukan2, 'flag_wakalah2' => $flag_wakalah2, 'fa_code2' => $fa_code_n, 'resort_code2' => $resort_code_n
					//--------------------new
					// ,'description' => $desc_peruntukan2

				);

				if ($debug == true) {
					echo "<pre>";
					print_r($raw_log_koreksi_droping);
				} else {
					$this->db->trans_begin();
					$this->model_nasabah->insert_log_koreksi_droping($raw_log_koreksi_droping);
					if ($this->db->trans_status() === true) {
						$this->db->trans_commit();
					} else {
						$this->db->trans_rollback();
						$bValid = false;
						$error_state = 4;
					}
				}
			}

			/*
		    | updating mfi_account_financing_reg (desc peruntukan) //----------------new 14-02-2015
		    */
			if ($bValid == true) {

				$registration_no = $this->input->post('registration_no');
				$desc_peruntukan = $this->input->post('desc_peruntukan');
				$desc_peruntukan2 = $this->input->post('desc_peruntukan2');

				if ($desc_peruntukan != $desc_peruntukan2) { //do update description

					$raw_account_saving_reg = array('description' => $desc_peruntukan2);
					$param_account_saving_reg = array('registration_no' => $registration_no);


					if ($debug == true) {
						echo "<pre>";
						print_r($raw_account_saving_reg);
						print_r($param_account_saving_reg);
					} else {
						$this->db->trans_begin();
						$this->db->update('mfi_account_financing_reg', $raw_account_saving_reg, $param_account_saving_reg);
						if ($this->db->trans_status() === true) {
							$this->db->trans_commit();
						} else {
							$this->db->trans_rollback();
							$bValid = false;
							$error_state = 5;
						}
					}
				}
			}
		} //------------end new 14-12-2015

		if ($bValid == true) {
			$return = array('success' => true);
		} else {
			$return = array('success' => false, 'error_state' => $error_state);
		}

		echo json_encode($return);
	}


	/* PERUBAHAN PENCAIRAN */
	public function perubahan_pencairan()
	{
		$data['container'] = 'nasabah/perubahan_pencairan';
		$data['branch'] = $this->model_cif->get_all_branch();
		$data['branchs'] = $this->model_cif->get_branchs();
		$data['trx_date'] = $this->current_date();
		$this->load->view('core', $data);
	}
	public function datatable_perubahan_pencairan()
	{
		$param_tanggal_akad = isset($_GET['param_tanggal_akad']) ? $_GET['param_tanggal_akad'] : '';
		$param_branch_code = isset($_GET['param_branch_code']) ? $_GET['param_branch_code'] : '';
		$param_cm_code = isset($_GET['param_cm_code']) ? $_GET['param_cm_code'] : '';

		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('account_financing_no', 'mfi_cif.nama', 'mfi_akad.akad_name', 'mfi_account_financing.tanggal_akad', 'pokok', '');

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

		$rResult 						= $this->model_nasabah->datatable_perubahan_pencairan($sWhere, $sOrder, $sLimit, $param_tanggal_akad, $param_branch_code, $param_cm_code); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_perubahan_pencairan($sWhere, '', '', $param_tanggal_akad, $param_branch_code, $param_cm_code); // get number of filtered data
		$iFilteredTotal 		= count($rResultFilterTotal);
		$rResultTotal 			= $this->model_nasabah->datatable_perubahan_pencairan('', '', '', $param_tanggal_akad, $param_branch_code, $param_cm_code); // get number of all data
		$iTotal 						= count($rResultTotal);

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
			$rembug = '';
			if ($aRow['cm_name'] != "") {
				$rembug = ' <a href="javascript:void(0);" class="btn mini green-stripe">' . $aRow['cm_name'] . '</a>';
			}
			// $row[] = '<input type="checkbox" value="'.$aRow['account_financing_no'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'] . $rembug;
			$row[] = $aRow['akad_name'];
			$row[] = date('d-m-Y', strtotime($aRow['tanggal_akad']));
			$row[] = '<div align="right">Rp ' . number_format($aRow['pokok'], 0, ',', '.') . ',-</div>';
			//$row[] = $aRow['cm_name'];
			$row[] = '<a href="javascript:;" class="label label-sm blue label-info" data-account_financing_no="' . $aRow['account_financing_no'] . '" id="link-edit">Ubah</a>';

			$output['aaData'][] = $row;
		}

		echo json_encode($output);
	}
	function get_data_perubahan_pencairan()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_nasabah->get_data_perubahan_pencairan($account_financing_no);
		echo json_encode($data);
	}
	function get_tanggal_mulai_angsur_v2()
	{
		$tanggal_akad = $this->datepicker_convert(true, $this->input->post('tanggal_akad'), '/');
		$grace_periode = $this->model_transaction->get_grace_periode(0);
		$grace_periode = substr($grace_periode, 1, 1); //mingguan
		$tanggal_mulai_angsur = date('Y-m-d', strtotime($tanggal_akad . ' +' . $grace_periode . ' week'));
		echo json_encode(array('date' => $tanggal_mulai_angsur));
	}
	function do_perubahan_pencairan()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$account_financing_no = $this->input->post('account_financing_no');
		$tanggal_akad = $this->datepicker_convert(true, $this->input->post('tanggal_akad', '/'));
		$grace_periode = $this->model_transaction->get_grace_periode(0);
		$grace_periode = substr($grace_periode, 1, 1); //mingguan
		$tanggal_mulai_angsur = date('Y-m-d', strtotime($tanggal_akad . ' +' . $grace_periode . ' week'));

		$data = array(
			'tanggal_akad' => $tanggal_akad,
			'tanggal_mulai_angsur' => $tanggal_mulai_angsur,
			'jtempo_angsuran_last' => $tanggal_akad,
			'jtempo_angsuran_next' => date('Y-m-d', strtotime($tanggal_mulai_angsur . ' +1 week'))
		);
		$param = array('account_financing_id' => $account_financing_id);

		$data1 = array('droping_date' => $tanggal_akad);
		$param1 = array('account_financing_no' => $account_financing_no);

		$this->db->trans_begin();
		$this->db->update('mfi_account_financing', $data, $param);
		$this->db->update('mfi_account_financing_droping', $data1, $param1);
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			$return = array('success' => true);
		} else {
			$this->db->trans_rollback();
			$return = array('success' => false);
		}
		echo json_encode($return);
	}

	function get_cm_data_by_branch_code()
	{
		$branch_code = $this->input->post('branch_code');
		$q = $this->db->query("
			select 
				a.cm_code,
				a.cm_name
			from mfi_cm a, mfi_branch b
			where a.branch_id=b.branch_id
			and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)
			order by 2 asc
		", array($branch_code));
		$r = $q->result_array();

		echo json_encode($r);
	}
	/* //PERUBAHAN PENCAIRAN */

	/* BEGIN PERPANJANGAN TABBER *******************************************************/
	function perpanjang_tabber()
	{
		$data['container'] = 'transaction/perpanjang_tabber';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['current_date'] = date('d/m/Y');
		$this->load->view('core', $data);
	}

	function search_rekening_tabungan()
	{
		$rekening = $this->input->post('rekening');

		$data = $this->model_nasabah->search_rekening_tabungan($rekening);

		$tanggal_lahir = str_replace('-', '/', $data['tgl_lahir']);
		$tgl_lahir = date('d/m/Y', strtotime($tanggal_lahir));

		$rencana_setor = str_replace('-', '/', $data['rencana_setoran_next']);
		$rencana_setoran_next = date('d/m/Y', strtotime($rencana_setor));

		$tgl_buka = str_replace('-', '/', $data['tanggal_buka']);
		$tanggal_buka = date('d/m/Y', strtotime($tgl_buka));

		$biaya_adm = number_format($data['biaya_administrasi'], 0, ',', '.');
		$setoran = number_format($data['rencana_setoran'], 0, ',', '.');

		$tanggal_perpanjangan = str_replace('-', '/', $data['tanggal_perpanjangan']);
		$tanggal_perpanjangan = date('d/m/Y', strtotime($tanggal_perpanjangan));

		$perpanjangan_jangka_waktu = $data['rencana_jangka_waktu_setelah'] - $data['rencana_jangka_waktu'];

		$result = array(
			'account_saving_no' => $data['account_saving_no'],
			'nama' => $data['nama'],
			'majelis' => $data['cm_name'],
			'ibu_kandung' => $data['ibu_kandung'],
			'tmp_lahir' => $data['tmp_lahir'],
			'tgl_lahir' => $tgl_lahir,
			'product_name' => $data['product_name'],
			'biaya_administrasi' => $biaya_adm,
			'rencana_setoran' => $setoran,
			'rencana_periode_setoran' => $data['rencana_periode_setoran'],
			'rencana_setoran_next' => $rencana_setoran_next,
			'tanggal_buka' => $tanggal_buka,
			'rencana_jangka_waktu' => $data['rencana_jangka_waktu'],
			'counter_angsruan' => $data['counter_angsruan'],
			'rencana_jangka_waktu_akhir' => $data['rencana_jangka_waktu_setelah'],
			'rencana_jangka_waktu2' => $perpanjangan_jangka_waktu,
			'tanggal_perpanjangan' => $tanggal_perpanjangan
		);

		echo json_encode($result);
	}



	/* END PERPANJANGAN TABBER *********************************************************/

	/* BEGIN TRANSKSI WAKALAH *******************************************************/
	function transaksi_wakalah()
	{
		$data['container'] = 'transaction/transaksi_wakalah';
		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['jaminan'] = $this->model_transaction->get_jenis_jaminan();
		$branch_code = $this->session->userdata('branch_code');
		$data['account_cash'] = $this->model_transaction->ajax_get_gl_account_cash_by_keyword('', $branch_code, '0');
		$this->load->view('core', $data);
	}
	/* END TRANSAKSI WAKALAH *******************************************************/


	function verifikasi_perpanjang_tabber()
	{
		$data['container'] = 'transaction/verifikasi_perpanjang_tabber';
		$this->load->view('core', $data);
	}

	public function get_value_verif()
	{
		$account_saving_no 				= $this->input->post('account_saving_no');
		$data 							= $this->model_nasabah->get_value_verif($account_saving_no);
		// echo "<pre>";
		// 	print_r($account_saving_no);
		// 	die();
		$tgl_lahir_						= date('d-m-Y', strtotime($data['tgl_lahir']));
		$rencana_setoran_next 			= date('d-m-Y', strtotime($data['rencana_setoran_next']));
		$tanggal_buka 					= date('d-m-Y', strtotime($data['tanggal_buka']));
		$tanggal_perpanjangan 			= date('d-m-Y', strtotime($data['tanggal_perpanjangan']));


		$result = array(
			'branch_code' 					=> $data['branch_code'],
			'product_code' 					=> $data['product_code'],
			'product_name' 					=> $data['product_name'],
			'nama' 							=> $data['nama'],
			'panggilan' 					=> $data['panggilan'],
			'ibu_kandung' 					=> $data['ibu_kandung'],
			'tmp_lahir' 					=> $data['tmp_lahir'],
			'tgl_lahir' 					=> $tgl_lahir_,
			'usia' 							=> $data['usia'],
			'alamat' 						=> $data['alamat'],
			'rt_rw'							=> $data['rt_rw'],
			'desa' 							=> $data['desa'],
			'kecamatan' 					=> $data['kecamatan'],
			'kabupaten' 					=> $data['kabupaten'],
			'cif_no' 						=> $data['cif_no'],
			'cm_code' 						=> $data['cm_code'],
			'kodepos' 						=> $data['kodepos'],
			'telpon_rumah' 					=> $data['telpon_rumah'],
			'cif_type' 						=> $data['cif_type'],
			'telpon_seluler' 				=> $data['telpon_seluler'],
			'majlis' 						=> $data['majlis'],
			'tanggal_buka' 					=> $tanggal_buka,
			'biaya_administrasi' 			=> $data['biaya_administrasi'],
			'counter_angsruan' 				=> $data['counter_angsruan'],
			// tabungan berencana
			'rencana_setoran' 				=> $data['rencana_setoran'],
			'rencana_jangka_waktu' 			=> $data['rencana_jangka_waktu'],
			'rencana_setoran_next' 			=> $rencana_setoran_next,
			'rencana_awal_kontrak' 			=> $data['rencana_awal_kontrak'],
			'rencana_periode_setoran' 		=> $data['rencana_periode_setoran'],
			'rencana_jangka_waktu_setelah' 	=> $data['rencana_jangka_waktu_setelah'],
			'tanggal_perpanjangan' 			=> $tanggal_perpanjangan
			// 'tabungan_wajib' => number_format($data['tabungan_wajib']),
			// 'tabungan_sukarela' => number_format($data['tabungan_sukarela']),
			// 'tabungan_kelompok' => number_format($data['tabungan_kelompok'])

		);

		echo json_encode($result);
	}

	function get_document()
	{
		$cif_no = $this->input->post('cif_no');

		$path = './assets/img/document/';

		$ktp = 'ktp_' . $cif_no . '.png';
		$kk = 'kk_' . $cif_no . '.png';
		$pendukung = 'pendukung_' . $cif_no . '.png';

		if (file_exists($path . $ktp)) {
			$path_ktp = $path . $ktp;
			$type_ktp = pathinfo($path_ktp, PATHINFO_EXTENSION);
			$data_ktp = @file_get_contents($path_ktp);
			$base64_ktp = 'data:image/' . $type_ktp . ';base64,' . base64_encode($data_ktp);
			$file_ktp = $ktp;
		} else {
			$path_ktp = $path . 'ktp_none.png';
			$type_ktp = pathinfo($path_ktp, PATHINFO_EXTENSION);
			$data_ktp = @file_get_contents($path_ktp);
			$base64_ktp = 'data:image/' . $type_ktp . ';base64,' . base64_encode($data_ktp);
			$file_ktp = 'ktp_none.png';
		}

		if (file_exists($path . $kk)) {
			$path_kk = $path . $kk;
			$type_kk = pathinfo($path_kk, PATHINFO_EXTENSION);
			$data_kk = @file_get_contents($path_kk);
			$base64_kk = 'data:image/' . $type_kk . ';base64,' . base64_encode($data_kk);
			$file_kk = $kk;
		} else {
			$path_kk = $path . 'kk_none.png';
			$type_kk = pathinfo($path_kk, PATHINFO_EXTENSION);
			$data_kk = @file_get_contents($path_kk);
			$base64_kk = 'data:image/' . $type_kk . ';base64,' . base64_encode($data_kk);
			$file_kk = 'kk_none.png';
		}

		if (file_exists($path . $pendukung)) {
			$path_pendukung = $path . $pendukung;
			$type_pendukung = pathinfo($path_pendukung, PATHINFO_EXTENSION);
			$data_pendukung = @file_get_contents($path_pendukung);
			$base64_pendukung = 'data:image/' . $type_pendukung . ';base64,' . base64_encode($data_pendukung);
			$file_pendukung = $pendukung;
		} else {
			$path_pendukung = $path . 'pendukung_none.png';
			$type_pendukung = pathinfo($path_pendukung, PATHINFO_EXTENSION);
			$data_pendukung = @file_get_contents($path_pendukung);
			$base64_pendukung = 'data:image/' . $type_pendukung . ';base64,' . base64_encode($data_pendukung);
			$file_pendukung = 'pendukung_none.png';
		}

		$data = array(
			'base64_ktp' => $base64_ktp,
			'file_ktp' => $file_ktp,
			'base64_kk' => $base64_kk,
			'file_kk' => $file_kk,
			'base64_pendukung' => $base64_pendukung,
			'file_pendukung' => $file_pendukung
		);

		echo json_encode($data);
	}

	function compress_img_54($filename)
	{
		$width = 1000;
		$height = 750;

		$path = './assets/img/document/';

		$info = getimagesize($path . $filename);

		// Get New Dimensions
		list($width_orig, $height_orig) = getimagesize($path . $filename);

		$ratio_orig = $width_orig / $height_orig;

		if ($width / $height > $ratio_orig) {
			$width = $height * $ratio_orig;
		} else {
			$height = $width / $ratio_orig;
		}

		$image_p = imagecreatetruecolor($width, $height);

		if ($info['mime'] == 'image/jpeg' or $info['mime'] == 'image/jpg') {
			$image = imagecreatefromjpeg($path . $filename);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
			imagejpeg($image_p, $path . $filename);
		} else if ($info['mime'] == 'image/gif') {
			$image = imagecreatefromgif($path . $filename);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
			imagegif($image_p, $path . $filename);
		} else if ($info['mime'] == 'image/png') {
			$image = imagecreatefrompng($path . $filename);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
			imagepng($image_p, $path . $filename);
		}
	}

	function upload_document()
	{
		$cif_no = $this->input->post('cif_no');
		$rencana_drop = $this->input->post('rencana_droping');
		$rencana_droping_ = str_replace("/", "", $rencana_drop);
		$rencana_droping = substr($rencana_droping_, 4, 4) . '-' . substr($rencana_droping_, 2, 2) . '-' . substr($rencana_droping_, 0, 2);

		$doc_ktp = @$_FILES['doc_ktp'];
		$name_ktp = $doc_ktp['name'];
		$tmp_ktp = $doc_ktp['tmp_name'];

		$doc_kk = @$_FILES['doc_kk'];
		$name_kk = $doc_kk['name'];
		$tmp_kk = $doc_kk['tmp_name'];

		$doc_pendukung = @$_FILES['doc_pendukung'];
		$name_pendukung = $doc_pendukung['name'];
		$tmp_pendukung = $doc_pendukung['tmp_name'];

		$doc_path = './assets/img/document/';

		if ($name_ktp != '') {
			$nama_file_ktp = 'ktp_' . $cif_no;
			$file_ktp = $nama_file_ktp . '.png';

			move_uploaded_file($tmp_ktp, $doc_path . $file_ktp);
			$this->compress_img_54($file_ktp);
		} else {
			if (file_exists($doc_path . 'ktp_' . $cif_no . '.png')) {
				$file_ktp = 'ktp_' . $cif_no . '.png';
				$this->compress_img_54($file_ktp);
			} else {
				$file_ktp = '';
			}
		}

		if ($name_kk != '') {
			$nama_file_kk = 'kk_' . $cif_no;
			$file_kk = $nama_file_kk . '.png';

			move_uploaded_file($tmp_kk, $doc_path . $file_kk);
			$this->compress_img_54($file_kk);
		} else {
			if (file_exists($doc_path . 'kk_' . $cif_no . '.png')) {
				$file_kk = 'kk_' . $cif_no . '.png';
				$this->compress_img_54($file_kk);
			} else {
				$file_kk = '';
			}
		}

		if ($name_pendukung != '') {
			$nama_file_pendukung = 'pendukung_' . $cif_no;
			$file_pendukung = $nama_file_pendukung . '.png';

			move_uploaded_file($tmp_pendukung, $doc_path . $file_pendukung);
			$this->compress_img_54($file_pendukung);
		} else {
			if (file_exists($doc_path . 'pendukung_' . $cif_no . '.png')) {
				$file_pendukung = 'pendukung_' . $cif_no . '.png';
				$this->compress_img_54($file_pendukung);
			} else {
				$file_pendukung = '';
			}
		}

		$param = array(
			'cif_no' => $cif_no,
			'rencana_droping' => $rencana_droping
		);

		$data = array(
			'doc_ktp' => $file_ktp,
			'doc_kk' => $file_kk,
			'doc_pendukung' => $file_pendukung
		);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data, $param);

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$result = array('success' => TRUE);
		} else {
			$this->db->trans_rollback();
			$result = array('success' => FALSE);
		}

		echo json_encode($result);
	}

	function upload_document_edit()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$cif_no = $this->input->post('cif_no2');
		$old_ktp = $this->input->post('old_ktp');
		$old_kk = $this->input->post('old_kk');
		$old_pendukung = $this->input->post('old_pendukung');

		$doc_ktp = @$_FILES['doc_ktp'];
		$name_ktp = $doc_ktp['name'];
		$tmp_ktp = $doc_ktp['tmp_name'];

		$doc_kk = @$_FILES['doc_kk'];
		$name_kk = $doc_kk['name'];
		$tmp_kk = $doc_kk['tmp_name'];

		$doc_pendukung = @$_FILES['doc_pendukung'];
		$name_pendukung = $doc_pendukung['name'];
		$tmp_pendukung = $doc_pendukung['tmp_name'];

		$doc_path = './assets/img/document/';

		if ($name_ktp != '') {
			$nama_file_ktp = 'ktp_' . $cif_no;
			$file_ktp = $nama_file_ktp . '.png';

			@unlink($doc_path . $old_ktp);
			move_uploaded_file($tmp_ktp, $doc_path . $file_ktp);
			$this->compress_img_54($file_ktp);
		} else {
			if (file_exists($doc_path . $old_ktp)) {
				$file_ktp = $old_ktp;
			} else {
				$file_ktp = '';
			}
		}

		if ($name_kk != '') {
			$nama_file_kk = 'kk_' . $cif_no;
			$file_kk = $nama_file_kk . '.png';

			@unlink($doc_path . $old_kk);
			move_uploaded_file($tmp_kk, $doc_path . $file_kk);
			$this->compress_img_54($file_kk);
		} else {
			if (file_exists($doc_path . $old_kk)) {
				$file_kk = $old_kk;
			} else {
				$file_kk = '';
			}
		}

		if ($name_pendukung != '') {
			$nama_file_pendukung = 'pendukung_' . $cif_no;
			$file_pendukung = $nama_file_pendukung . '.png';

			@unlink($doc_path . $old_pendukung);
			move_uploaded_file($tmp_pendukung, $doc_path . $file_pendukung);
			$this->compress_img_54($file_pendukung);
		} else {
			if (file_exists($doc_path . $old_pendukung)) {
				$file_pendukung = $old_pendukung;
			} else {
				$file_pendukung = '';
			}
		}

		$param = array('account_financing_reg_id' => $account_financing_reg_id);

		$data = array(
			'doc_ktp' => $file_ktp,
			'doc_kk' => $file_kk,
			'doc_pendukung' => $file_pendukung
		);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data, $param);

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$result = array('success' => TRUE);
		} else {
			$this->db->trans_rollback();
			$result = array('success' => FALSE);
		}

		echo json_encode($result);
	}
}
