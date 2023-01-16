<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_laporan extends CI_Model {

	/****************************************************************************************/	
	// BEGIN SALDO KAS PETUGAS
	/****************************************************************************************/

	public function get_all_branch()
	{
		$sql = "SELECT * from mfi_branch";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function fn_insert_par($branch_code,$tanggal_hitung,$created_by,$created_date){
		$sql = "SELECT fn_insert_par(?,?,?,?)";
		$param = array($branch_code,$tanggal_hitung,$created_by,$created_date);

		$this->db->query($sql,$param);
	}

	function show_fa_name($fa_code){
		$sql = "SELECT fa_name FROM mfi_fa WHERE fa_code = ?";

		$param = array($fa_code);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function insert_report_kas_petugas($branch_code,$tanggal,$user_id){
		$sql = "SELECT fn_insert_report_kaspetugas(?,?,?)";

		$param = array($branch_code,$tanggal,$user_id);

		$this->db->query($sql,$param);
	}

	function show_report_kas_petugas($branch_code,$tanggal,$user_id){
		$sql = "SELECT * FROM mfi_report_kas_petugas_temporary WHERE branch_code = ? AND trx_date = ? AND user_id = ?";

		$param = array($branch_code,$tanggal,$user_id);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function datatable_saldo_kas_petugas_new($sOrder,$sLimit,$cabang,$tanggal,$user_id){
		$sql = "SELECT
		account_cash_code,
		fa_name,
		saldo_awal,
		mutasi_debet,
		mutasi_credit,
		saldo_akhir
		FROM mfi_report_kas_petugas_temporary
		WHERE branch_code = ? AND trx_date = ? AND user_id = ? ";

		$param = array($cabang,$tanggal,$user_id);

		$sql .= "ORDER BY account_cash_code ";

		if($sOrder != ''){
			$sql .= $sOrder.' ';
		}

		if($sLimit != ''){
			$sql .= $sLimit;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function datatable_saldo_kas_petugas($sOrder='',$sLimit='',$cabang='',$tanggal){
		$sql = "SELECT
		mgac.account_cash_code,
		mf.fa_name,
		fn_get_saldoawal_kaspetugas(mgac.account_cash_code,?,0)
		AS saldoawal,
		fn_get_mutasi_kaspetugas(mgac.account_cash_code,?,'D')
		AS mutasi_debet,
		fn_get_mutasi_kaspetugas(mgac.account_cash_code,?,'C')
		AS mutasi_credit
		
		from mfi_gl_account_cash AS mgac
		
		LEFT JOIN mfi_fa AS mf ON (mgac.fa_code=mf.fa_code)
		WHERE mgac.account_cash_type = '0' AND
		(fn_get_saldoawal_kaspetugas(mgac.account_cash_code,?,0) +
		fn_get_mutasi_kaspetugas(mgac.account_cash_code,?,'D') -
		fn_get_mutasi_kaspetugas(mgac.account_cash_code,?,'C')) <> 0";
		if($cabang!="00000"){
			$sql .= " AND mf.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
		}

		$sql .= " ORDER BY mgac.account_cash_code ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,array($tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$cabang));
		// print_r($this->db);
		return $query->result_array();
	}

	function get_totalsaldoawal_kas_petugas($cabang,$tanggal)
	{
		$sql="select 
			  coalesce(sum(fn_get_saldoawal_kaspetugas(mfi_gl_account_cash.account_cash_code,?,0)),0) as totalsaldoawal 
			  from mfi_gl_account_cash
			  left outer join mfi_fa on (mfi_gl_account_cash.fa_code=mfi_fa.fa_code)
			  where mfi_gl_account_cash.account_cash_type='0'
			";
		if($cabang!="00000"){
			$sql .= " AND mfi_fa.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
		}
		$query=$this->db->query($sql,array($tanggal,$cabang));
		return $query->row_array();
	}

	function get_totalsaldoakhir_kas_petugas($cabang,$tanggal)
	{
		$sql="select 
			  (coalesce(sum(fn_get_saldoawal_kaspetugas(mfi_gl_account_cash.account_cash_code,?,0)),0)+
			  coalesce(sum(fn_get_mutasi_kaspetugas(mfi_gl_account_cash.account_cash_code,?,'D')),0)-
			  coalesce(sum(fn_get_mutasi_kaspetugas(mfi_gl_account_cash.account_cash_code,?,'C')),0))
			  as totalsaldoakhir
			  from mfi_gl_account_cash
			  left outer join mfi_fa on (mfi_gl_account_cash.fa_code=mfi_fa.fa_code)
			  where mfi_gl_account_cash.account_cash_type='0'
			";
		if($cabang!="00000"){
			$sql .= " AND mfi_fa.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
		}
		$query=$this->db->query($sql,array($tanggal,$tanggal,$tanggal,$cabang));
		// echo "<pre>";
		// print_r($this->db);
		// die();
		return $query->row_array();
	}

	/****************************************************************************************/	
	// END SALDO KAS PETUGAS
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN TRANSAKSI KAS PETUGAS
	/****************************************************************************************/
	public function search_code_cash_by_keyword($keyword,$type)
	{
		$branch_code = $this->session->userdata('branch_code');
		$sql = "SELECT
							mfi_gl_account_cash.account_cash_name,
							mfi_gl_account_cash.account_cash_code,
							mfi_gl_account_cash.fa_code,
							mfi_fa.fa_name
				FROM
							mfi_gl_account_cash
				INNER JOIN mfi_fa ON mfi_gl_account_cash.fa_code=mfi_fa.fa_code
				WHERE (mfi_gl_account_cash.account_cash_name like ? or mfi_gl_account_cash.account_cash_code like ?) ";
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		if($type!=""){
			$sql .= ' and account_cash_type = ?';
			$param[] = $type;
		}
		if ($branch_code!='00000') {
			$sql .= ' and mfi_fa.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)';
			$param[] = $branch_code;
		}
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_saldo_awal_kas_petugas($account_cash_code,$from){
		$sql = "SELECT COALESCE(fn_get_saldoawal_kaspetugas(?,?,0),0) AS saldo_awal";

		$param = array($account_cash_code,$from);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	public function datatable_transaksi_kas_petugas_setup($sOrder='',$sLimit='',$tanggal='',$tanggal2='',$account_cash_code='')
	{
		$sql = "SELECT 
		a.trx_gl_cash_type,
		a.trx_date,
		b.display_text trx_type,
		a.description,
		a.flag_debet_credit,
		(case when a.flag_debet_credit='D' then a.amount else 0 end) as trx_debet,
		(case when a.flag_debet_credit='C' then a.amount else 0 end) as trx_credit
		from 
		mfi_trx_gl_cash as a
		left outer join 
		mfi_list_code_detail b on (a.trx_gl_cash_type=CAST(b.code_value as integer) 
		and b.code_group='trx_gl_cash_type')
		where 
		a.trx_date between ? and ?
		and a.account_cash_code = ?
		order by a.trx_date,a.trx_gl_cash_type,a.created_date ";


		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,array($tanggal,$tanggal2,$account_cash_code));
		// print_r($this->db);
		return $query->result_array();
	}


	/****************************************************************************************/	
	// END TRANSAKSI KAS PETUGAS
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN GL REPORT
	/****************************************************************************************/

	function get_gl_account_history($branch_code='',$account_code='',$from_date='',$thru_date=''){
		$sql = "SELECT
		mtgd.trx_gl_detail_id,
		mtg.trx_gl_id,
		mtgd.account_code,
		mtgd.flag_debit_credit,
		mtgd.amount,
		mtg.voucher_date,
		(CASE WHEN mtgd.flag_debit_credit = 'C' THEN mtgd.amount ELSE 0 END) AS credit,
		(CASE WHEN mtgd.flag_debit_credit = 'D' THEN mtgd.amount ELSE 0 END) AS debit,
		mga.transaction_flag_default,
		mtg.description
		FROM mfi_trx_gl AS mtg
		LEFT JOIN mfi_trx_gl_detail AS mtgd ON mtgd.trx_gl_id = mtg.trx_gl_id
		LEFT JOIN mfi_gl_account AS mga ON mga.account_code = mtgd.account_code
		WHERE mtgd.account_code = ?
		AND mtg.voucher_date BETWEEN ? AND ? ";

		$param[] = $account_code;
		$param[] = $from_date;
		$param[] = $thru_date;

		if ( $branch_code != "00000" ) {
			$sql .= "AND mtg.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}
		
		$sql .= "ORDER BY mtg.voucher_date, mtg.created_date, mtgd.trx_sequence ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_gl_rekap_transaksi($branch_code='',$from_date='',$thru_date='')
	{
		$sql = "select
				gl_account.gl_account_id, 
				gl_account.account_code, 
				gl_account.account_name, 
				(select sum(amount) from mfi_trx_gl_detail 
					join mfi_trx_gl on mfi_trx_gl.trx_gl_id = mfi_trx_gl_detail.trx_gl_id
					where mfi_trx_gl_detail.flag_debit_credit = 'C' 
					and mfi_trx_gl.branch_code = ?
					and mfi_trx_gl.trx_date between ? and ?
					and mfi_trx_gl_detail.account_code = gl_account.account_code) as credit,
				(select sum(amount) from mfi_trx_gl_detail 
					join mfi_trx_gl on mfi_trx_gl.trx_gl_id = mfi_trx_gl_detail.trx_gl_id
					where mfi_trx_gl_detail.flag_debit_credit = 'D'
					and mfi_trx_gl.branch_code = ?
					and mfi_trx_gl.trx_date between ? and ?
					and mfi_trx_gl_detail.account_code = gl_account.account_code) as debit
				from mfi_gl_account gl_account
				join mfi_trx_gl_detail trx_gl_detail on trx_gl_detail.account_code = gl_account.account_code
				group by 1,2,3,4,5
		";

		$query = $this->db->query($sql,array($branch_code,$from_date,$thru_date,$branch_code,$from_date,$thru_date));
		
		return $query->result_array();
	}

	public function get_neraca_saldo_gl($branch_code='',$periode_tanggal='',$periode_bulan='',$periode_tahun='')
	{
		$last_date = date('Y-m-d',strtotime($periode_tahun.'-'.$periode_bulan.'-01 -1 days'));

		$from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
		$thru_periode = $periode_tahun.'-'.$periode_bulan.'-'.$periode_tanggal;
		// $thru_periode = $periode_tahun.'-'.$periode_bulan.'-'.date('t',strtotime($from_periode));
		$sql = "SELECT
				gl_account.gl_account_id, 
				gl_account.account_code, 
				gl_account.account_name, 
				gl_account.account_group_code, 
				coalesce(fn_get_saldo_gl_account2(gl_account.account_code,?,?),0) as saldo_awal,
				coalesce(fn_get_mutasi_gl_account2(gl_account.account_code,?,?,'D',?),0) as debit,
				coalesce(fn_get_mutasi_gl_account2(gl_account.account_code,?,?,'C',?),0) as credit
				from mfi_gl_account gl_account
				order by gl_account.account_group_code,gl_account.account_code asc
				--group by 1,2,3,4,5
		";

		if($branch_code=='00000'){
			$branch_code = 'all';
		}

		$query = $this->db->query($sql,array(
				$last_date,
				$branch_code,

				$from_periode,
				$thru_periode,
				$branch_code,

				$from_periode,
				$thru_periode,
				$branch_code
			));
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function get_neraca_saldo_gl2($branch_code='',$periode1='',$periode2='')
	{
		$last_date = date('Y-m-d',strtotime($periode1.' -1 days'));

		$sql = "SELECT
		gl_account_id,
		account_code,
		account_name,
		account_group_code,
		COALESCE(fn_get_saldo_gl_account2(account_code,?,?),0) AS saldo_awal,
		COALESCE(fn_get_mutasi_gl_account2(account_code,?,?,'D',?),0) AS debit,
		COALESCE(fn_get_mutasi_gl_account2(account_code,?,?,'C',?),0) AS credit
		FROM mfi_gl_account ";

		$param = array();

		if($branch_code != '00000'){
			$sql .= "WHERE flag_akses != ? ";
			$param[] = 'P';
		}

		if($branch_code == '00000'){
			$branch_code = 'all';
		}

		$param[] = $last_date;
		$param[] = $branch_code;
		$param[] = $periode1;
		$param[] = $periode2;
		$param[] = $branch_code;
		$param[] = $periode1;
		$param[] = $periode2;
		$param[] = $branch_code;

		$sql .= "ORDER BY account_group_code,account_code ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	
	public function get_rekap_mutasi_gl($branch_code='',$from_date='',$thru_date='')
	{   	
		$sql = "
			SELECT
			gl_account.account_code, 
			gl_account.account_name, 
			'0' as sequence,
			(select coalesce(sum(a.amount),0)
			from mfi_trx_gl_detail a, mfi_trx_gl b
			where a.trx_gl_id=b.trx_gl_id and a.flag_debit_credit='D'
			and b.voucher_date between ? and ? and a.account_code=gl_account.account_code ";
		$param[] = $from_date;
		$param[] = $thru_date;
		if ($branch_code!="00000") {
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}
		$sql .= ") debit,
			'0' as credit,
			'D' as flag_debit_credit
			from mfi_gl_account gl_account
			where (select coalesce(sum(a.amount),0)
			from mfi_trx_gl_detail a, mfi_trx_gl b
			where a.trx_gl_id=b.trx_gl_id and a.flag_debit_credit='D'
			and b.voucher_date between ? and ? and a.account_code=gl_account.account_code ";
		$param[] = $from_date;
		$param[] = $thru_date;
		if ($branch_code!="00000") {
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}
		$sql .= ") <> 0

			UNION ALL

			SELECT
			gl_account.account_code, 
			gl_account.account_name, 
			'1' as sequence,
			'0' as debit,
			(select coalesce(sum(a.amount),0)
			from mfi_trx_gl_detail a, mfi_trx_gl b
			where a.trx_gl_id=b.trx_gl_id and a.flag_debit_credit='C'
			and b.voucher_date between ? and ? and a.account_code=gl_account.account_code ";
		$param[] = $from_date;
		$param[] = $thru_date;
		if ($branch_code!="00000") {
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}
		$sql .= ") credit,
			'C' as flag_debit_credit
			from mfi_gl_account gl_account
			where (select coalesce(sum(a.amount),0)
			from mfi_trx_gl_detail a, mfi_trx_gl b
			where a.trx_gl_id=b.trx_gl_id and a.flag_debit_credit='C'
			and b.voucher_date between ? and ? and a.account_code=gl_account.account_code ";
		$param[] = $from_date;
		$param[] = $thru_date;
		if ($branch_code!="00000") {
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}
		$sql .= ") <> 0
			order by account_code,sequence asc ";
		// $sql = "SELECT
		// 		gl_account.account_code, 
		// 		gl_account.account_name, 
		// 		'0' as sequence,
		// 		coalesce(fn_get_mutasi_gl_account2(gl_account.account_code,?,?,'D',?),0) as debit,
		// 		'0' as credit,
		// 		'D' as flag_debit_credit
		// 		from mfi_gl_account gl_account
		// 		where coalesce(fn_get_mutasi_gl_account2(gl_account.account_code,?,?,'D',?),0) <> '0'

		// 		UNION ALL

		// 		SELECT
		// 		gl_account.account_code, 
		// 		gl_account.account_name, 
		// 		'1' as sequence,
		// 		'0' as debit,
		// 		coalesce(fn_get_mutasi_gl_account2(gl_account.account_code,?,?,'C',?),0) as credit,
		// 		'C' as flag_debit_credit
		// 		from mfi_gl_account gl_account
		// 		where coalesce(fn_get_mutasi_gl_account2(gl_account.account_code,?,?,'C',?),0) <> '0'
				
		// 		order by account_code,sequence asc
		// ";
	
		$query = $this->db->query($sql,$param);
		// echo '<pre>';
		// print_r($this->db);
		// die();
		return $query->result_array();
	}
	
	
	
	/****************************************************************************************/	
	// END GL REPORT
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN DROPING PEMBIAYAAN
	/****************************************************************************************/

	public function getReportDropingPembiayaan()
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_financing_droping.droping_date,
				mfi_account_financing_droping.droping_by,
				mfi_account_financing_droping.account_financing_no,
				mfi_account_financing.pokok,
				mfi_account_financing.dana_kebajikan,
				mfi_cm.cm_name,
				mfi_fa.fa_name
				FROM
				mfi_cif
				INNER JOIN mfi_account_financing_droping ON mfi_account_financing_droping.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_cm.fa_code
				WHERE mfi_account_financing.status_rekening !=0
				ORDER BY mfi_account_financing_droping.account_financing_droping_id ASC
				";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}

	/****************************************************************************************/	
	// END LAPORAN DROPING PEMBIAYAAN
	/****************************************************************************************/



	
	/****************************************************************************************/	
	// BEGIN KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/
	function fn_insert_kpa_tmp($account_financing_no, $financing_type, $user_id){
		$sql = "SELECT fn_insert_kpa_tmp(?,?,?)";

		$param = array($account_financing_no,$financing_type,$user_id);

		$query = $this->db->query($sql,$param);
	}

	

	public function get_kartu_pengawasan_angsuran_by_account_no($account_no)
	{
		$sql = "
		SELECT
			mfi_cif.cif_no,
			mfi_cif.nama,
			mfi_cif.cif_type,
			mfi_cm.cm_name,
			mfi_kecamatan_desa.desa,
			mfi_account_financing.pokok,
			mfi_account_financing.margin,
			mfi_account_financing.status_rekening,
			mfi_account_financing_droping.droping_date,
			mfi_account_financing.tanggal_jtempo,
			mfi_account_financing.financing_type,
			mfi_product_financing.product_name,
			mfi_account_financing.account_saving_no,
			mfi_list_code_detail.display_text AS untuk,
			mfi_account_financing_reg.pembiayaan_ke as pydke,
			mfi_account_financing.angsuran_pokok,
			mfi_account_financing.angsuran_margin,
			mfi_account_financing.angsuran_catab,
			mfi_account_financing.jangka_waktu,
			mfi_account_financing.angsuran_tab_wajib,
			mfi_account_financing.angsuran_tab_kelompok
			
		FROM
			mfi_account_financing
		INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
		LEFT JOIN mfi_cm ON mfi_cif.cm_code = mfi_cm.cm_code
		LEFT JOIN mfi_kecamatan_desa ON mfi_cm.desa_code = mfi_kecamatan_desa.desa_code
		INNER JOIN mfi_account_financing_droping ON mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no
		INNER JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
		LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value=mfi_account_financing.peruntukan::varchar AND mfi_list_code_detail.code_group='peruntukan'
		LEFT JOIN mfi_account_financing_reg ON mfi_account_financing_reg.registration_no=mfi_account_financing.registration_no
		WHERE 
		--mfi_account_financing.status_rekening='1' AND
		mfi_account_financing.account_financing_no = ?
		";
		$query = $this->db->query($sql,array($account_no));

		return $query->row_array();
	}

	public function get_trx_pembiayaan_by_cif_no($cif_no)
	{
		$sql = "SELECT
						mfi_account_financing.cif_no,
						mfi_account_financing.jangka_waktu,
						mfi_account_financing.tanggal_mulai_angsur,
						mfi_trx_cm.trx_date,
						mfi_trx_cm.angsuran_pokok,
						mfi_trx_cm.angsuran_margin,
						mfi_trx_cm.angsuran_catab
				FROM
						mfi_account_financing
				INNER JOIN mfi_trx_cm_detail ON mfi_account_financing.cif_no = mfi_trx_cm_detail.cif_no
				INNER JOIN mfi_trx_cm ON mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id

				WHERE mfi_account_financing.cif_no = ? 
				AND mfi_account_financing.status_rekening='1' ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->result_array();
	}

	public function get_row_pembiayaan_by_account_no($account_financing_no)
	{
		$sql = "SELECT 
					tanggal_mulai_angsur_o tanggal_mulai_angsur
					,tanggal_akad_o tanggal_akad
					,tanggal_jtempo_o tanggal_jtempo
					,jangka_waktu_o-(saldo_pokok_o/angsuran_pokok_o)::integer jangka_waktu
					,periode_jangka_waktu_o periode_jangka_waktu
					,(angsuran_pokok_o+angsuran_margin_o+angsuran_catab_o+angsuran_tab_wajib_o+angsuran_tab_kelompok_o) as jumlah_angsuran
					,pokok_o pokok
					,margin_o margin
					,saldo_catab_o saldo_catab
					,angsuran_pokok_o angsuran_pokok
					,angsuran_margin_o angsuran_margin
					,angsuran_catab_o angsuran_catab
				FROM mfi_account_financing_re_schedulle 
				WHERE account_financing_no=? AND status=1
				UNION ALL
				SELECT 
					tanggal_mulai_angsur
					,tanggal_akad
					,tanggal_jtempo
					,jangka_waktu
					,periode_jangka_waktu
					,(angsuran_pokok+angsuran_margin+angsuran_catab+angsuran_tab_wajib+angsuran_tab_kelompok) as jumlah_angsuran
					,pokok
					,margin
					,saldo_catab
					,angsuran_pokok
					,angsuran_margin
					,angsuran_catab
				FROM mfi_account_financing 
				WHERE account_financing_no=?
				ORDER BY tanggal_akad ASC
			  ";

		$query = $this->db->query($sql,array($account_financing_no,$account_financing_no));

		return $query->result_array();
	}



	public function get_trx_cm_by_account_cif_no($account_financing_no,$cif_no,$cif_type,$jtempo='')
	{
		$param=array();
		if($cif_type==0){ // kelompok
			$sql = "select 
					b.trx_date 
					from mfi_trx_cm_detail a, mfi_trx_cm b 
					where a.trx_cm_id = b.trx_cm_id 
					and a.cif_no = ?
				  ";
			$param[]=$cif_no;
		}
		if($cif_type==1){
			$sql = "select  
					a.trx_date 
					from mfi_trx_account_financing a 
					where a.account_financing_no=? and a.jto_date=?
				  ";
			$param[]=$account_financing_no;
			$param[]=$jtempo;
		}
		// $sql .='aaaa';


		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_history_cm_trx_date($cif_no,$tgl_angsur)
	{
		$sql = "select
				b.trx_date
				from mfi_trx_cm_detail a, mfi_trx_cm b
				where a.trx_cm_id=b.trx_cm_id and a.cif_no=? and b.trx_date=?";
		$query=$this->db->query($sql,array($cif_no,$tgl_angsur));
		return $query->row_array();
	}

	function get_history_cm_trx_date_by_account_financing_no($account_financing_no,$angsuran_ke,$financing_type,$jtempo){
		$param = array();
		if($financing_type == '0'){
			/*
			$sql = "SELECT
			a.trx_date,
			c.fullname AS validasi
			FROM mfi_trx_cm AS a
			JOIN mfi_trx_cm_detail AS b ON a.trx_cm_id = b.trx_cm_id
			LEFT JOIN mfi_user AS c ON c.user_id::VARCHAR = a.created_by
			WHERE b.account_financing_no = ? AND b.angsuran_ke = ?";
			$param[] = $account_financing_no;
			$param[] = $angsuran_ke;
			*/
			$sql = "SELECT
			tgl_bayar AS trx_date,
			validasi
			FROM mfi_kpa_tmp
			WHERE account_financing_no = ? AND angsuran_ke = ?";

			$param[] = $account_financing_no;
			$param[] = $angsuran_ke;
		} else {
			/*
			$sql = "SELECT
			a.trx_date,
			b.fullname AS validasi
			FROM mfi_trx_account_financing AS a
			LEFT JOIN mfi_user AS b ON b.user_id::VARCHAR = a.verify_by
			WHERE a.account_financing_no = ? AND a.trx_financing_type IN('1','2')
			AND a.jto_date = ? AND a.trx_status = '1'";
			$param[] = $account_financing_no;
			$param[] = $jtempo;
			*/

			$sql = "SELECT
			tgl_bayar AS trx_date,
			validasi
			FROM mfi_kpa_tmp
			WHERE account_financing_no = ? AND angsuran_ke = ?";

			$param[] = $account_financing_no;
			$param[] = $angsuran_ke;

		}

		$query = $this->db->query($sql,$param);
		return $query->row_array();
	}
	/****************************************************************************************/	
	// END KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// FUNGSI UNTUK MEMANGGIL NAMA DESA
	/****************************************************************************************/
	public function get_all_desa()
	{
		$sql = "SELECT * from mfi_kecamatan_desa";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_desa_by_keyword($keyword)
	{
		$sql = "SELECT
				mfi_kecamatan_desa.desa_code,
				mfi_kecamatan_desa.desa
				FROM
				mfi_kecamatan_desa
				where (UPPER(desa) like ? or UPPER(desa_code) like ?)";
		
		$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.strtoupper(strtolower($keyword)).'%'));

		return $query->result_array();
	}
	/****************************************************************************************/	
	// FUNGSI UNTUK MEMANGGIL NAMA DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT OUTSTANDING BY DESA
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_desa()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_kecamatan_desa.desa,
				SUM(mfi_account_financing.pokok) AS pokok,
				SUM(mfi_account_financing.margin) AS margin
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_kecamatan_desa ON mfi_cm.desa_code = mfi_kecamatan_desa.desa_code
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				group by mfi_kecamatan_desa.desa";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT OUTSTANDING BY DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT OUTSTANDING BY REMBUG
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_rembug()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_cm.cm_name,
				SUM(mfi_account_financing.pokok) AS pokok,
				SUM(mfi_account_financing.margin) AS margin
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				group by mfi_cm.cm_name";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT OUTSTANDING BY REMBUG
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT OUTSTANDING BY PETUGAS
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_petugas()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_fa.fa_name,
				SUM(mfi_account_financing.pokok) AS pokok,
				SUM(mfi_account_financing.margin) AS margin
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_cm.fa_code
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				group by mfi_fa.fa_name";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT OUTSTANDING BY PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT OUTSTANDING BY PERUNTUKAN
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_peruntukan()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_account_financing.peruntukan,
				SUM(mfi_account_financing.pokok) AS pokok,
				SUM(mfi_account_financing.margin) AS margin
				FROM
				mfi_cif
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				group by mfi_account_financing.peruntukan";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT OUTSTANDING BY PERUNTUKAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENGAJUAN BY DESA
	/****************************************************************************************/
	public function export_rekap_pengajuan_pembiayaan_by_desa()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_kecamatan_desa.desa,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_kecamatan_desa ON mfi_cm.desa_code = mfi_kecamatan_desa.desa_code
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				group by mfi_kecamatan_desa.desa";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENGAJUAN BY DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENGAJUAN BY REMBUG
	/****************************************************************************************/
	public function export_rekap_pengajuan_pembiayaan_by_rembug()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_cm.cm_name,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				group by mfi_cm.cm_name";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENGAJUAN BY REMBUG
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENGAJUAN BY PETUGAS
	/****************************************************************************************/
	public function export_rekap_pengajuan_pembiayaan_by_petugas()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_fa.fa_name,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_cm.fa_code
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				group by mfi_fa.fa_name";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENGAJUAN BY PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENGAJUAN BY PERUNTUKAN
	/****************************************************************************************/
	public function export_rekap_pengajuan_pembiayaan_by_peruntukan()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_account_financing.peruntukan,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				group by mfi_account_financing.peruntukan";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENGAJUAN BY PERUNTUKAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENCAIRAN BY DESA
	/****************************************************************************************/
	public function export_rekap_pencairan_pembiayaan_by_desa()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_kecamatan_desa.desa,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_kecamatan_desa ON mfi_cm.desa_code = mfi_kecamatan_desa.desa_code
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				group by mfi_kecamatan_desa.desa";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENCAIRAN BY DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENCAIRAN BY REMBUG
	/****************************************************************************************/
	public function export_rekap_pencairan_pembiayaan_by_rembug($branch_code='', $from_date='',$thru_date='')
	{
		$sql = "SELECT
				c.cm_code ,
				COUNT(a.account_financing_no) AS num,				
				SUM(b.pokok) AS amount
				FROM
				mfi_account_financing_droping a
				INNER JOIN mfi_account_financing b  ON a.account_financing_no = b.account_financing_no
				INNER JOIN mfi_cif c ON b.cif_no = c.cif_no 
				where a.droping_date between ? and ? ";
								
				$param[] = $from_date;
				$param[] = $thru_date;

				if($branch_code!="00000"){
				$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
				}
				
				$sql .= " group by 1 "; 

				$query = $this->db->query($sql,$param);
				return $query->result_array();
	}

	/****************************************************************************************/	
	// END EXPORT REKAP PENCAIRAN BY REMBUG
	/****************************************************************************************/

	
	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENCAIRAN BY PETUGAS
	/****************************************************************************************/
	public function export_rekap_pencairan_pembiayaan_by_petugas($branch_code='', $from_date='',$thru_date='')
	{
		$sql = "SELECT
				b.fa_code ,
				COUNT(a.account_financing_no) AS num,				
				SUM(b.pokok) AS amount
				FROM
				mfi_account_financing_droping a
				INNER JOIN mfi_account_financing b  ON a.account_financing_no = b.account_financing_no
				INNER JOIN mfi_cif c ON b.cif_no = c.cif_no 
				where a.droping_date between ? and ? ";
								
				$param[] = $from_date;
				$param[] = $thru_date;

				if($branch_code!="00000"){
				$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
				}
				
				$sql .= " group by 1 "; 

				$query = $this->db->query($sql,$param);
				return $query->result_array();
	}

	/****************************************************************************************/	
	// END EXPORT REKAP PENCAIRAN BY PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENCAIRAN BY PERUNTUKAN
	/****************************************************************************************/

	public function export_rekap_pencairan_pembiayaan_by_peruntukan($branch_code='',$fa_code='',$from_date='',$thru_date='',$cm_code='')
	{
		$sql = "SELECT
		        b.peruntukan,d.display_text as tujuan_pembiayaan,
				COUNT(a.account_financing_no) AS num,
				SUM(b.pokok) AS amount
				FROM mfi_account_financing_droping a
				INNER JOIN mfi_account_financing b
				ON a.account_financing_no = b.account_financing_no
				INNER JOIN mfi_cif c ON b.cif_no = c.cif_no
				INNER JOIN mfi_list_code_detail d
				ON b.peruntukan = d.code_value::integer and d.code_group='peruntukan'
				INNER JOIN mfi_cm AS mcm ON mcm.cm_code = c.cm_code
				INNER JOIN mfi_fa e ON e.fa_code = mcm.fa_code
				where a.droping_date between ? and ?";
				
				$param[] = $from_date;
				$param[] = $thru_date;

				if($branch_code!="00000"){
					$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
				}
				
				if($fa_code!="0000"){
					$sql .= " and e.fa_code = ?";
					$param[] = $fa_code;
				}

				if ($cm_code!="0000") {
					$sql .= " and mcm.cm_code = ?";
					$param[] = $cm_code;
				}

				$sql .= " group by 1,2"; 

				$query = $this->db->query($sql,$param);
				return $query->result_array();
	}

	/****************************************************************************************/	
	// END EXPORT REKAP PENCAIRAN BY PERUNTUKAN
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENCAIRAN BY SEKTOR USAHA
	/****************************************************************************************/

	public function export_rekap_pencairan_pembiayaan_by_sektor($branch_code='',$fa_code='',$from_date='',$thru_date='',$cm_code='')
	{
		$sql = "SELECT
		        b.sektor_ekonomi, d.display_text as sektor_usaha,
				COUNT(a.account_financing_no) AS num,
				SUM(b.pokok) AS amount
				FROM mfi_account_financing_droping a
				INNER JOIN mfi_account_financing b
				ON a.account_financing_no = b.account_financing_no
				INNER JOIN mfi_cif c ON b.cif_no = c.cif_no
				INNER JOIN mfi_list_code_detail d
				ON b.sektor_ekonomi = d.code_value::integer
				AND d.code_group='sektor_ekonomi'
				INNER JOIN mfi_cm AS mcm ON mcm.cm_code = c.cm_code
				INNER JOIN mfi_fa e ON e.fa_code = mcm.fa_code
				where a.droping_date between ? and ?";
				
				$param[] = $from_date;
				$param[] = $thru_date;

				if($branch_code!="0000"){
					$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
				}
				
				if($fa_code!="0000"){
					$sql .= " and e.fa_code = ?";
					$param[] = $fa_code;
				}

				if ($cm_code!="0000") {
					$sql .= " and mcm.cm_code = ?";
					$param[] = $cm_code;
				}

				$sql .= " group by 1,2"; 
				
				$query = $this->db->query($sql,$param);
				return $query->result_array();
	}

	/****************************************************************************************/	
	// END EXPORT REKAP PENCAIRAN BY Sektor Usaha
	/****************************************************************************************/
	
	
	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENCAIRAN BY PRODUK
	/****************************************************************************************/
	public function export_rekap_pencairan_pembiayaan_by_produk($branch_code='',$fa_code='',$from_date='',$thru_date='',$cm_code='') 
	{
		$sql = "SELECT
				maf.product_code,
				mpf.product_name,
				COUNT(maf.account_financing_no) AS num,
				SUM(maf.pokok) AS amount
				FROM mfi_account_financing AS maf
				LEFT JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
				LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code 
				LEFT JOIN mfi_account_financing_droping AS mfd ON mfd.account_financing_no = maf.account_financing_no 
				LEFT JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code 
				LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
				WHERE mfd.droping_date between ? and ? "; 
								
				$param[] = $from_date;
				$param[] = $thru_date;

				if($branch_code!="0000"){
					$sql .= " and maf.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
				}

				if ($cm_code!="0000") {
					$sql .= " and mcm.cm_code = ?";
					$param[] = $cm_code;
				}

				if($fa_code!="0000"){
					$sql .= " and mf.fa_code = ?";
					$param[] = $fa_code;
				}

				$sql .= " group by 1,2"; 

				$query = $this->db->query($sql,$param);
				return $query->result_array();
	}

	/****************************************************************************************/	
	// END REKAP PENCAIRAN BY PRODUK
	/****************************************************************************************/

	function cek_libur($tgl_angsur){
		$sql = "SELECT COUNT(*) jml FROM mfi_hari_libur WHERE tanggal = ?";
		$param = array($tgl_angsur);
		$query = $this->db->query($sql,$param);
		$row = $query->row_array();

		if ($row['jml']==0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	
	
	/// Begin Export Cash Flow Transaksi Rembug
	
	function export_cashflow_transaksi_rembug($branch_code='',$cm_code='',$fa_code='',$from_date='',$thru_date=''){
		// QUERY CASH IN
		$sql_1 = "SELECT
		COALESCE(SUM(a.angsuran_pokok*a.freq),0) angsuran_pokok,
		COALESCE(SUM(a.angsuran_margin*a.freq),0) angsuran_margin,
		COALESCE(SUM(a.angsuran_catab*a.freq),0) angsuran_catab,
		COALESCE(SUM(a.tab_wajib_cr*a.freq),0) tab_wajib_cr,
		COALESCE(SUM(a.tab_kelompok_cr*a.freq),0) tab_kelompok_cr,
		COALESCE(SUM(a.tab_sukarela_cr),0) tab_sukarela_cr,
		COALESCE(SUM(a.tab_sukarela_db),0) tab_sukarela_db
		from mfi_trx_cm_detail a
		join mfi_trx_cm b on a.trx_cm_id=b.trx_cm_id
		join mfi_cm c on b.cm_code=c.cm_code
		join mfi_branch d on c.branch_id=d.branch_id
		join mfi_fa e on e.fa_code=c.fa_code
		where b.trx_date between ? and ? ";

		$param_1[] = $from_date;
		$param_1[] = $thru_date;

		if ($branch_code!="0000") {
			$sql_1 .= "and d.branch_code in (SELECT branch_code from mfi_branch_member where branch_induk=?) ";
			$param_1[] = $branch_code;
		}

		if ($cm_code!="0000") {
			$sql_1 .= "and c.cm_code = ?";
			$param_1[] = $cm_code;
		}

		if ($fa_code!="0000") {
			$sql_1 .= "and e.fa_code = ?";
			$param_1[] = $fa_code;
		}

		$query_1 = $this->db->query($sql_1,$param_1);
		$row_1 = $query_1->row_array();

		$row['angsuran_pokok'] = $row_1['angsuran_pokok'];
		$row['angsuran_margin'] = $row_1['angsuran_margin'];
		$row['angsuran_catab'] = $row_1['angsuran_catab'];
		$row['tab_wajib_cr'] = $row_1['tab_wajib_cr'];
		$row['tab_kelompok_cr'] = $row_1['tab_kelompok_cr'];
		$row['tab_sukarela_cr'] = $row_1['tab_sukarela_cr'];

		$sql_2 = "SELECT COALESCE(SUM(saldo_catab),0) AS saldo_catab
		FROM mfi_account_financing_lunas AS mafl
		JOIN mfi_trx_cm_detail AS mtcd ON mtcd.trx_cm_detail_id = mafl.trx_cm_detail_id
		JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
		JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mafl.tanggal_lunas BETWEEN ? AND ? "; 

		$param_2[] = $from_date;
		$param_2[] = $thru_date;

		if($branch_code != '0000'){
			$sql_2 .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param_2[] = $branch_code;
		}

		if($cm_code != '0000'){
			$sql_2 .= "AND mcm.cm_code = ? ";
			$param_2[] = $cm_code;
		}

		if($fa_code != '0000'){
			$sql_2 .= "AND mf.fa_code = ?";
			$param_2[] = $fa_code;
		}

		$query_2 = $this->db->query($sql_2,$param_2);
		$row_2 = $query_2->row_array();

		$row['saldo_catab'] = $row_2['saldo_catab'];

		$sql_3 = "SELECT
		COALESCE(SUM(a.droping),0) droping,
		COALESCE(SUM(a.infaq_kelompok),0) infaq_kelompok,
		COALESCE(SUM(a.transaksi_lain_cr),0) transaksi_lain_cr,
		COALESCE(SUM(a.transaksi_lain_db),0) transaksi_lain_db
		from mfi_trx_cm a
		join mfi_cm b on a.cm_code=b.cm_code
		join mfi_branch c on b.branch_id=c.branch_id
		join mfi_fa d ON d.fa_code = b.fa_code
		where a.trx_date between ? and ? ";

		$param_3[] = $from_date;
		$param_3[] = $thru_date;

		if ($branch_code!="0000"){
			$sql_3 .= "and c.branch_code in(SELECT branch_code from mfi_branch_member where branch_induk=?) ";
			$param_3[] = $branch_code;
		}

		if ($cm_code!="0000"){
			$sql_3 .= "AND b.cm_code = ? ";
			$param_3[] = $cm_code;
		}

		if($fa_code != '0000'){
			$sql_3 .= "AND d.fa_code = ? ";
			$param_3[] = $fa_code;
		}

		$query_3= $this->db->query($sql_3,$param_3);
		$row_3 = $query_3->row_array();

		$row['infaq_kelompok'] = $row_3['infaq_kelompok'];
		$row['droping'] = $row_3['droping'];
		$row['transaksi_lain_cr'] = $row_3['transaksi_lain_cr'];
		$row['transaksi_lain_db'] = $row_3['transaksi_lain_db'];

		$sql_4 = "SELECT
		COALESCE(SUM(mcmut.saldo_tab_wajib),0) AS tab_wajib_db,
		COALESCE(SUM(mcmut.saldo_tab_kelompok),0) AS tab_kelompok_db
		FROM mfi_cif_mutasi AS mcmut
		JOIN mfi_cm AS mcm ON mcm.cm_code = mcmut.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mcmut.tipe_mutasi = '1' ";

		if($branch_code != '0000'){
			$sql_4 .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param_4[] = $branch_code;
		}

		if($cm_code != '0000'){
			$sql_4 .= "AND mcm.cm_code = ? ";
			$param_4[] = $cm_code;
		}

		if($fa_code != '0000'){
			$sql_4 .= "AND mf.fa_code = ? ";
			$param_4[] = $fa_code;
		}

		$sql_4 .= "AND mcmut.tanggal_mutasi BETWEEN ? AND ?";

		$param_4[] = $from_date;
		$param_4[] = $thru_date;

		$query_4 = $this->db->query($sql_4,$param_4);
		$row_4 = $query_4->row_array();

		$sql_5 = "SELECT
		SUM(maf.biaya_administrasi) AS administrasi,
		SUM(maf.biaya_asuransi_jiwa) AS asuransi
		FROM mfi_account_financing AS maf
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		WHERE maf.status_rekening = '1'";

		if($branch_code != '0000'){
			$sql_5 .= " AND mc.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?)";
			$param_5[] = $branch_code;
		}

		if($cm_code != '0000'){
			$sql_5 .= " AND mc.cm_code = ?";
			$param_5[] = $cm_code;
		}

		$sql_5 .= " AND maf.tanggal_akad BETWEEN ? AND ?";

		$param_5[] = $from_date;
		$param_5[] = $thru_date;

		$query_5 = $this->db->query($sql_5,$param_5);
		$row_5 = $query_5->row_array();

		$row['administrasi'] = $row_5['administrasi'];
		$row['asuransi'] = $row_5['asuransi'];

		$row['tab_wajib_db'] = $row_4['tab_wajib_db'];
		$row['tab_kelompok_db'] = $row_4['tab_kelompok_db'];

		$row['tab_sukarela'] = $row_1['tab_sukarela_db'] - ($row['tab_kelompok_db'] + $row['tab_wajib_db'] + $row['saldo_catab']);

		$row['cash_in'] = $row['angsuran_pokok']+$row['angsuran_margin']+$row['angsuran_catab']+$row['tab_wajib_cr']+$row['tab_kelompok_cr']+$row['tab_sukarela_cr']+$row['infaq_kelompok']+$row['administrasi']+$row['asuransi'];
		$row['cash_out'] = $row['tab_kelompok_db']+$row['tab_wajib_db']+$row['saldo_catab']+$row['tab_sukarela']+$row['droping'];

		return $row;
	}
	
	/////////End Export Cash Flow Transaksi Rembug

	// START EXPORT REKAP CASHFLOW TRANSAKSI REMBUG
	function export_rekap_cashflow_transaksi_rembug($cabang,$from,$thru){
		$sql = "SELECT
		mcm.cm_name,

		COALESCE(SUM(mtcd.angsuran_pokok * mtcd.freq),0) AS angsuran_pokok,
		COALESCE(SUM(mtcd.angsuran_margin * mtcd.freq),0) AS angsuran_margin,
		COALESCE(SUM(mtcd.angsuran_catab * mtcd.freq),0) AS angsuran_catab,
		COALESCE(SUM(mtcd.tab_wajib_cr * mtcd.freq),0) AS tab_wajib_cr,
		COALESCE(SUM(mtcd.tab_kelompok_cr * mtcd.freq),0) AS tab_kelompok_cr,

		COALESCE(SUM(mtc.tab_wajib_db),0) AS tab_wajib_db,
		COALESCE(SUM(mtcd.tab_sukarela_db),0) AS tab_sukarela_db,
		COALESCE(SUM(mtc.droping),0) AS droping

		FROM mfi_trx_cm AS mtc
		JOIN mfi_trx_cm_detail AS mtcd ON mtcd.trx_cm_id = mtc.trx_cm_id
		JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		--JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code

		WHERE mtc.trx_date BETWEEN ? AND ?";

		$param = array();

		$param[] = $from;
		$param[] = $thru;

		if($cabang != '00000'){
			$sql .= " AND mb.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $cabang;
		}

		$sql .= " GROUP BY 1";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function export_rekap_cashflow_transaksi_petugas($cabang,$from,$thru){
		$sql = "SELECT
		mf.fa_name,

		COALESCE(SUM(mtcd.angsuran_pokok * mtcd.freq),0) AS angsuran_pokok,
		COALESCE(SUM(mtcd.angsuran_margin * mtcd.freq),0) AS angsuran_margin,
		COALESCE(SUM(mtcd.angsuran_catab * mtcd.freq),0) AS angsuran_catab,
		COALESCE(SUM(mtcd.tab_wajib_cr * mtcd.freq),0) AS tab_wajib_cr,
		COALESCE(SUM(mtcd.tab_kelompok_cr * mtcd.freq),0) AS tab_kelompok_cr,

		COALESCE(SUM(mtc.tab_wajib_db),0) AS tab_wajib_db,
		COALESCE(SUM(mtcd.tab_sukarela_db),0) AS tab_sukarela_db,
		COALESCE(SUM(mtc.droping),0) AS droping

		FROM mfi_trx_cm AS mtc
		JOIN mfi_trx_cm_detail AS mtcd ON mtcd.trx_cm_id = mtc.trx_cm_id
		JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code

		WHERE mtc.trx_date BETWEEN ? AND ?";

		$param = array();

		$param[] = $from;
		$param[] = $thru;

		if($cabang != '00000'){
			$sql .= " AND mb.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $cabang;
		}

		$sql .= " GROUP BY 1";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END EXPORT REKAP CASHFLOW TRANSAKSI REMBUG

	public function export_list_transaksi_rembug($branch_code='',$cm_code='',$from_date='',$thru_date='',$fa_code='')
	{
		$sql = "select
				'Ya' as status_verifikasi,
				mfi_trx_cm.infaq_kelompok infaq,
				((select sum((a.angsuran_pokok+a.angsuran_margin+a.angsuran_catab+a.tab_wajib_cr+a.tab_kelompok_cr) * a.freq)+coalesce(sum(a.tab_sukarela_cr),0)+coalesce(sum(a.minggon),0)+coalesce(sum(b.administrasi),0)+coalesce(sum(b.asuransi),0)
				from mfi_trx_cm_detail a 
				left join mfi_trx_cm_detail_droping b on a.trx_cm_detail_id = b.trx_cm_detail_id
				left join mfi_trx_cm_detail_savingplan c on a.trx_cm_detail_id = c.trx_cm_detail_id 
				where a.trx_cm_id = mfi_trx_cm.trx_cm_id
				))+(select coalesce(sum(b.amount*b.freq),0)
					from mfi_trx_cm_detail_savingplan a, mfi_trx_cm_detail_savingplan_account b
					where a.trx_cm_detail_savingplan_id=b.trx_cm_detail_savingplan_id and b.flag_debet_credit = 'C' and a.trx_cm_detail_id in(
						select trx_cm_detail_id from mfi_trx_cm_detail where trx_cm_id=mfi_trx_cm.trx_cm_id
					)
				) setoran,
				(droping+tab_sukarela_db) penarikan,
				mfi_trx_cm.trx_cm_id,
				mfi_cm.cm_name,
				mfi_fa.fa_name,
				mfi_trx_cm.trx_date,
				CAST(mfi_trx_cm.created_date as varchar(10))
				
				from mfi_trx_cm
				left join mfi_cm on mfi_cm.cm_code = mfi_trx_cm.cm_code
				left join mfi_fa on mfi_fa.fa_code = mfi_trx_cm.fa_code
				left join mfi_branch on mfi_branch.branch_id=mfi_cm.branch_id
				where trx_date between ? and ?
				";

		$param[] = $from_date;
		$param[] = $thru_date;

		if($branch_code!="00000"){
			$sql .= " and mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($cm_code!="0000"){
			$sql .= " and mfi_cm.cm_code = ? ";
			$param[] = $cm_code;
		}

		if($fa_code!="0000"){
			$sql .= " and mfi_trx_cm.fa_code = ? ";
			$param[] = $fa_code;
		}

		$sql .= "
				union all
				select
				'Tidak' as status_verifikasi,
				mfi_trx_cm_save.infaq,
				((select sum((
				(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_pokok else 0 end) else 0 end) else 0 end)+
				(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_margin else 0 end) else 0 end) else 0 end)+
				(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_catab else 0 end) else 0 end) else 0 end)+
				(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_tab_wajib else 0 end) else 0 end) else 0 end)+
				(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_tab_kelompok else 0 end) else 0 end) else 0 end)
				) * a.frekuensi)+
				sum(a.setoran_tab_sukarela)+
				sum(a.setoran_mingguan)+
				sum((case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then (mfi_account_financing.cadangan_resiko + dana_kebajikan + biaya_administrasi + biaya_notaris) else 0 end) else 0 end))+
				sum((case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then (biaya_asuransi_jiwa + biaya_asuransi_jaminan) else 0 end) else 0 end))+
				sum( (select sum(b.amount*b.frekuensi) from mfi_trx_cm_save_berencana b where b.trx_cm_save_detail_id=a.trx_cm_save_detail_id ))
				--(select (b.amount*b.frekuensi) from mfi_trx_cm_save_berencana b where b.trx_cm_save_detail_id=a.trx_cm_save_detail_id)
				--coalesce(sum(b.amount*b.frekuensi),0)
				from mfi_trx_cm_save_detail a
				left join mfi_account_financing on mfi_account_financing.cif_no = a.cif_no  and mfi_account_financing.status_rekening = 1 and mfi_account_financing.financing_type = 0
				--left join mfi_trx_cm_save_berencana b on a.trx_cm_save_detail_id = b.trx_cm_save_detail_id 
				where a.trx_cm_save_id = mfi_trx_cm_save.trx_cm_save_id
				)) setoran,
				(select (sum(a.penarikan_tab_sukarela)+sum((case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then mfi_account_financing.pokok else 0 end) else 0 end)))
				from mfi_trx_cm_save_detail a
				left join mfi_account_financing on mfi_account_financing.cif_no = a.cif_no and mfi_account_financing.status_rekening = 1 and mfi_account_financing.financing_type = 0
				where a.trx_cm_save_id = mfi_trx_cm_save.trx_cm_save_id 
				) penarikan,
				mfi_trx_cm_save.trx_cm_save_id,
				mfi_cm.cm_name,
				mfi_fa.fa_name,
				mfi_trx_cm_save.trx_date,
				CAST(mfi_trx_cm_save.created_date as varchar(10))

				from mfi_trx_cm_save
				left join mfi_cm on mfi_cm.cm_code = mfi_trx_cm_save.cm_code
				left join mfi_fa on mfi_fa.fa_code = mfi_trx_cm_save.fa_code
				left join mfi_branch on mfi_trx_cm_save.branch_id=mfi_branch.branch_id
				where trx_date between ? and ? ";

		$param[] = $from_date;
		$param[] = $thru_date;

		if($branch_code!="00000"){
			$sql .= " and mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($cm_code!="0000"){
			$sql .= " and mfi_cm.cm_code = ? ";
			$param[] = $cm_code;
		}

		if($fa_code!="0000"){
			$sql .= " and mfi_trx_cm_save.fa_code = ? ";
			$param[] = $fa_code;
		}

		$sql .= " order by trx_date asc ";

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function export_list_transaksi_rembug_sub($trx_cm_id,$from_date,$thru_date,$trx_date='')
	{
		$sql = "
				select
				mfi_cif.cif_no,
				mfi_cif.nama,
				cast(mfi_cif.kelompok as integer) kelompok,
				mfi_trx_cm_detail.angsuran_pokok,
				mfi_trx_cm_detail.angsuran_margin,
				mfi_trx_cm_detail.angsuran_catab,
				mfi_trx_cm_lwk.setoran_lwk,
				mfi_trx_cm_wajib.setoran_mingguan,
				mfi_trx_cm_detail.tab_sukarela_cr,
				mfi_trx_cm_detail.freq,
				mfi_trx_cm_detail.minggon,
				mfi_trx_cm_detail.tab_wajib_cr,
				mfi_trx_cm_detail.tab_sukarela_db,
				mfi_trx_cm_detail.tab_kelompok_cr, 
				(	select 
						(case when count(*) = 0 then '0' else mfi_account_financing.pokok end)
					from mfi_account_financing
					join mfi_account_financing_droping on mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no
						and mfi_account_financing_droping.droping_date = ? and status_droping = 1
					where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_account_financing.status_rekening = 1 and mfi_account_financing.financing_type = '0'
					group by mfi_account_financing.pokok
					limit 1
				) as pokok,
				mfi_trx_cm_detail_droping.droping,
				mfi_trx_cm_detail_droping.administrasi,
				mfi_trx_cm_detail_droping.asuransi,
				(select count(*) from mfi_account_financing where mfi_account_financing.cif_no = mfi_cif.cif_no) as pembiayaan_ke,
				(select coalesce(sum(b.amount*b.freq),0)
					from mfi_trx_cm_detail_savingplan a, mfi_trx_cm_detail_savingplan_account b
					where a.trx_cm_detail_savingplan_id=b.trx_cm_detail_savingplan_id  and b.flag_debet_credit = 'C' and
					a.trx_cm_detail_id=mfi_trx_cm_detail.trx_cm_detail_id
				) as tabren, 
				keterangan 
				from mfi_trx_cm_detail
				left join mfi_cif on mfi_cif.cif_no = mfi_trx_cm_detail.cif_no
				left join mfi_trx_cm_lwk on mfi_trx_cm_lwk.trx_cm_detail_id = mfi_trx_cm_detail.trx_cm_detail_id 
				left join mfi_trx_cm_wajib on mfi_trx_cm_wajib.trx_cm_detail_id = mfi_trx_cm_detail.trx_cm_detail_id
				left join mfi_trx_cm_detail_droping on mfi_trx_cm_detail_droping.trx_cm_detail_id = mfi_trx_cm_detail.trx_cm_detail_id
				where mfi_trx_cm_detail.trx_cm_id = ?

				union all

				select
				mfi_cif.cif_no,
				mfi_cif.nama, 
				cast(mfi_cif.kelompok as integer) kelompok,
				(case when mfi_account_financing.tanggal_akad <= ? then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_pokok else 0 end) else 0 end) else 0 end) as angsuran_pokok,
				(case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing.tanggal_akad <= ? then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_margin else 0 end) else 0 end) else 0 end) end) as angsuran_margin,
				(case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing.tanggal_akad <= ? then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_catab else 0 end) else 0 end) else 0 end) end) as angsuran_catab,
				mfi_trx_cm_save_detail.setoran_lwk, 
				mfi_trx_cm_save_detail.setoran_mingguan, 
				mfi_trx_cm_save_detail.setoran_tab_sukarela AS tab_sukarela_cr,
				mfi_trx_cm_save_detail.frekuensi as freq, 
				'0' as minggon,
				(case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing.tanggal_akad <= ? then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_tab_wajib else 0 end) else 0 end) else 0 end) end) as tab_wajib_cr,
				mfi_trx_cm_save_detail.penarikan_tab_sukarela as tab_sukarela_db,
				(case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing.tanggal_akad <= ? then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_tab_kelompok else 0 end) else 0 end) else 0 end) end) as tab_kelompok_cr,
				(case when mfi_account_financing.tanggal_akad <= ? then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then mfi_account_financing.pokok else 0 end) else 0 end) as pokok,
				null as droping,
				(case when mfi_account_financing.tanggal_akad <= ? then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then (mfi_account_financing.cadangan_resiko + dana_kebajikan + biaya_administrasi + biaya_notaris) else 0 end) else 0 end) as administrasi,
				(case when mfi_account_financing.tanggal_akad <= ? then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then (biaya_asuransi_jiwa + biaya_asuransi_jaminan) else 0 end) else 0 end) asuransi,
				(select count(*) from mfi_account_financing where mfi_account_financing.cif_no = mfi_cif.cif_no) as pembiayaan_ke,
				(select SUM(mfi_trx_cm_save_berencana.amount*mfi_trx_cm_save_berencana.frekuensi) from mfi_trx_cm_save_berencana where mfi_trx_cm_save_berencana.trx_cm_save_detail_id=mfi_trx_cm_save_detail.trx_cm_save_detail_id) as tabren, '' as ket 
				from mfi_trx_cm_save_detail
				left join mfi_cif on mfi_cif.cif_no = mfi_trx_cm_save_detail.cif_no
				left join mfi_account_financing ON (mfi_account_financing.cif_no=mfi_cif.cif_no) AND (mfi_account_financing.status_rekening = 1) AND (mfi_account_financing.financing_type = 0)
				where mfi_trx_cm_save_detail.trx_cm_save_id = ? 
				order by kelompok asc
				";
		$query = $this->db->query($sql,array($trx_date,$trx_cm_id,$trx_date,$trx_date,$trx_date,$trx_date,$trx_date,$trx_date,$trx_date,$trx_date,$trx_cm_id));

		return $query->result_array();
	}
	
	public function export_list_transaksi_rembug_sub2($branch_code,$cm_code,$from_trx_date,$thru_trx_date,$fa_code)
	{
		$sql ="
		select 
		b.created_date tanggal_transaksi, 
		b.trx_date tgl_bayar, 
		d.cm_name majlis, 
		e.fa_name nama_petugas, 
		a.cif_no id_anggota,  
		a.trx_cm_id, 
		c.nama, 
		a.freq, 
		a.angsuran_pokok, 
		a.angsuran_margin, 
		a.angsuran_catab,   
		a.tab_sukarela_cr setoran_sukarela, 
		a.minggon wajib, 
		a.tab_kelompok_cr kelompok, 
		a.tab_sukarela_db penarikan_sukarela, 
		a.keterangan, 
		coalesce((select setoran_lwk from mfi_trx_cm_lwk  where cif_no=a.cif_no and  trx_cm_detail_id=a.trx_cm_detail_id),0) lwk, 
		coalesce((select setoran_mingguan from mfi_trx_cm_wajib  where cif_no=a.cif_no and  trx_cm_detail_id=a.trx_cm_detail_id),0) simwa, 
		coalesce((select pokok from mfi_account_financing  where account_financing_no=a.account_financing_no and tanggal_akad=b.trx_date),0) plafon, 
		coalesce((select biaya_administrasi from mfi_account_financing  where account_financing_no=a.account_financing_no and tanggal_akad=b.trx_date),0) adm,    
		coalesce((select biaya_asuransi_jiwa from mfi_account_financing  where account_financing_no=a.account_financing_no and tanggal_akad=b.trx_date),0)asuransi 
			
		from mfi_trx_cm_detail a 

		join mfi_trx_cm b on a.trx_cm_id=b.trx_cm_id 
		left outer join mfi_cif c on a.cif_no=c.cif_no 
		left outer join mfi_cm  d on c.cm_code=d.cm_code   
		left outer join mfi_fa  e on d.fa_code=e.fa_code
		left outer join mfi_branch f on f.branch_code=c.branch_code  

		where b.trx_date between ? and ?
			
			";
		$param[] = $from_trx_date;
		$param[] = $thru_trx_date;

		if($branch_code!="00000"){
			$sql .= " and f.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($cm_code!="0000"){
			$sql .= " and d.cm_code = ? ";
			$param[] = $cm_code;
		}

		if($fa_code!="0000"){
			$sql .= " and e.fa_code = ? ";
			$param[] = $fa_code;
		}

		$sql .= " order by b.trx_date asc, d.cm_code ";

		$query = $this->db->query($sql,$param); 


		return $query->result_array();
	}

	public function export_list_saldo_tabungan($branch_code='',$fa_code='',$cm_code='')
	{
		$param = array();
		$sql = "SELECT 
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		mkd.desa,
		madb.setoran_lwk,
		madb.simpanan_pokok,
		madb.tabungan_minggon,
		madb.tabungan_sukarela,
		madb.tabungan_kelompok,
		mf.fa_name,
		(SELECT SUM(saldo_pokok) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS saldo_pokok,
		(SELECT SUM(saldo_margin) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS saldo_margin,
		(SELECT SUM(pokok) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS pokok,
		(SELECT SUM(margin) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS margin,
		(SELECT SUM(saldo_memo) FROM mfi_account_saving WHERE cif_no = mc.cif_no AND product_code='0099' AND status_rekening = '1') AS saldo_dtk 

		FROM mfi_cif AS mc

		LEFT JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_kecamatan_desa AS mkd ON mkd.desa_code = mcm.desa_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mc.status <> 2 ";
		
		if($branch_code!="00000"){
			$sql .= "AND mc.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($fa_code != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $fa_code;
		}

		if($cm_code!="" || $cm_code!=false){
			$sql .= "AND mc.cm_code = ? ";
			$param[] = $cm_code;
		}
		$sql .= "ORDER BY mcm.cm_name,mc.kelompok::integer ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_simpanan_pokok($branch_code='',$cm_code='')
	{
		$sql = "SELECT
				mc.cif_no,
				mc.nama,
				mcm.cm_name,
				madb.tabungan_wajib,
				madb.tabungan_kelompok,
				madb.simpanan_pokok,
				madb.smk
				FROM mfi_account_default_balance AS madb
				LEFT JOIN mfi_cif AS mc ON madb.cif_no = mc.cif_no
				LEFT JOIN mfi_cm AS mcm ON mc.cm_code = mcm.cm_code
				WHERE ";
		
		// $param[] = $awal_trx_date;
		// $param[] = $akhir_trx_date;

		if($branch_code!="00000"){
			$sql .= " mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($cm_code!="" || $cm_code!=false){
			$sql .= " AND mc.cm_code = ? ";
			$param[] = $cm_code;
		}
		$sql .= " ORDER BY mcm.cm_name,mc.kelompok::integer ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	
	/// BEGIN  EXPORT LIST ANGGOTA KELUAR 	
	function export_list_anggota_keluar( $branch_code='',$cm_code='',$from_date, $thru_date,$alasan=''){
		$sql = "SELECT 
		a.cif_no,
		b.nama,
		c.cm_name,
		b.tgl_gabung, 
		a.tanggal_mutasi,
		a.saldo_pembiayaan_pokok,
		a.saldo_pembiayaan_margin,
		a.saldo_pembiayaan_catab,
		a.saldo_tab_wajib,
		a.saldo_tab_kelompok,
		a.saldo_tab_sukarela, 
		a.saldo_tab_berencana, 
		a.saldo_simpanan_pokok, 
		a.saldo_smk, 
		a.bonus_bagihasil, 
		a.saldo_lwk, 
		a.description alasan_keluar, 
		(SELECT display_text FROM mfi_list_code_detail WHERE code_group='anggotakeluar' AND code_value=a.alasan) alasan,
		(select account_financing_no from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) account_financing_no_last,
		(select pembiayaan_ke from mfi_account_financing_reg where cif_no=a.cif_no order by pembiayaan_ke desc limit 1) pembiayaan_ke_last, 
		(select tanggal_akad from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) tanggal_akad_last,
		(select pokok from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) pokok_last, 
		(select margin from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) margin_last,
		(select jangka_waktu from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) jangka_waktu_last 
		from mfi_cif_mutasi  a 
		left join  mfi_cif b on a.cif_no=b.cif_no
		left join mfi_cm c on b.cm_code = c.cm_code
		WHERE a.tipe_mutasi = 1
		";

		$param = array();

		if($branch_code!="00000"){
			$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($cm_code!="all"){
			$sql .= " AND b.cm_code = ? ";
			$param[] = $cm_code;
		}
		if($from_date!="" && $thru_date!=""){
			$sql .= " AND a.tanggal_mutasi BETWEEN ? AND ? ";
			$param[] = $from_date;
			$param[] = $thru_date;
		}
		if($alasan!='' && $alasan!='-'){
			$sql .= " AND a.alasan = ? ";
			$param[] = $alasan;			
		}
		$sql .= " ORDER BY a.tanggal_mutasi, c.cm_name, b.nama ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	/// END EXPORT LIST ANGGOTA KELUAR 


	/// BEGIN  EXPORT LIST ANGGOTA MUTASI 	
	function export_list_anggota_mutasi( $branch_code='',$cm_code='',$from_date, $thru_date,$alasan=''){
		$sql = "SELECT 
		a.cif_no, b.nama, c.cm_name majlis_lama, d.cm_name majlis_baru, b.tgl_gabung, a.tanggal_mutasi, a.saldo_pembiayaan_pokok, a.saldo_pembiayaan_margin, a.saldo_pembiayaan_catab,
		a.saldo_tab_wajib, a.saldo_tab_kelompok, a.saldo_tab_sukarela, a.saldo_tab_berencana, a.saldo_simpanan_pokok, a.saldo_smk, a.bonus_bagihasil, 
		a.saldo_lwk, a.description keterangan, 
		(SELECT display_text FROM mfi_list_code_detail WHERE code_group='anggotakeluar' AND code_value=a.alasan) alasan,
		(select account_financing_no from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) account_financing_no_last,
		(select pembiayaan_ke from mfi_account_financing_reg where cif_no=a.cif_no order by pembiayaan_ke desc limit 1) pembiayaan_ke_last, 
		(select tanggal_akad from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) tanggal_akad_last,
		(select pokok from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) pokok_last, 
		(select margin from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) margin_last,
		(select jangka_waktu from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) jangka_waktu_last 
		from mfi_cif_mutasi  a 
		left join  mfi_cif b on a.cif_no=b.cif_no
		left join mfi_cm c on a.cm_code = c.cm_code 
		left join mfi_cm d on a.cm_code_baru = d.cm_code 
		WHERE a.tipe_mutasi = 2
		";

		$param = array();

		if($branch_code!="00000"){
			$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($cm_code!="all"){
			$sql .= " AND b.cm_code = ? ";
			$param[] = $cm_code;
		}
		if($from_date!="" && $thru_date!=""){
			$sql .= " AND a.tanggal_mutasi BETWEEN ? AND ? ";
			$param[] = $from_date;
			$param[] = $thru_date;
		}
		if($alasan!='' && $alasan!='-'){
			$sql .= " AND a.alasan = ? ";
			$param[] = $alasan;			
		}
		$sql .= " ORDER BY a.tanggal_mutasi, b.nama ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	/// END EXPORT LIST ANGGOTA MUTASI  



	
	// BEGIN LIST ANGGOTA MASUK
	function export_list_anggota_masuk($cabang,$majelis,$from,$thru){
		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		mc.tgl_gabung,
		mc.jenis_kelamin,
		mc.ibu_kandung,
		mc.tmp_lahir,
		mc.tgl_lahir,
		mc.usia,
		mc.alamat
		FROM mfi_cif AS mc
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.tgl_gabung BETWEEN ? AND ? ";

		$param = array();

		$param[] = $from;
		$param[] = $thru;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ?";
			$param[] = $majelis;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}


	// BEGIN LIST ANGGOTA ABSEN
	function export_list_anggota_absen($cabang,$majelis,$from,$thru){
		$sql = "SELECT 		
		 	    a.cif_no, b.nama, b.branch_code, b.cm_code, c.cm_name, b.tgl_gabung, a.h, a.i, a.s, a.a   
				from mfi_absen_report a 
				left outer join mfi_cif b on a.cif_no=b.cif_no 
				left outer join mfi_cm c on b.cm_code=c.cm_code  
				WHERE a.cif_no <> '0' and a.absen_from_date =? and a.absen_thru_date=? ";

		$param = array();

		$param[] = $from;
		$param[] = $thru;

		if($cabang != '00000'){
			$sql .= "AND a.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($majelis != 'all'){
			$sql .= "AND b.cm_code = ?";
			$param[] = $majelis;
		}

		$sql .=" order by b.branch_code, b.cm_code, a.cif_no "; 

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	// END LIST ANGGOTA ABSEN  


	// BEGIN LEMBAR ABSEN ANGGOTA 
	function export_lembar_absen_anggota($cabang,$majelis,$tahun){
		$sql = "SELECT 		
		 	    a.cif_no, a.nama, a.branch_code, a.cm_code, b.cm_name, a.tgl_gabung, a.kelompok 
				from mfi_cif a  
				left outer join mfi_cm b on a.cm_code=b.cm_code 
				WHERE a.cif_no <> '0' ";

		$param = array();

		if($cabang != '00000'){
			$sql .= "AND a.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($majelis != 'all'){
			$sql .= " AND a.cm_code = ?";
			$param[] = $majelis;
		}

		$sql .=" order by a.branch_code, a.cm_code, a.status, a.kelompok  "; 

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	// END LIST ANGGOTA ABSEN 



	public function get_cm_name_by_cm_code($cm_code)
	{
		$sql = "select cm_name from mfi_cm where cm_code = ?";
		$query = $this->db->query($sql,array($cm_code));

		$row = $query->row_array();

		return !isset($row['cm_name'])?'':$row['cm_name'];
	}

	public function get_branch_name_by_branch_code($branch_code)
	{
		$sql = "select branch_name from mfi_branch where branch_code = ?";
		$query = $this->db->query($sql,array($branch_code));

		$row = $query->row_array();

		return $row['branch_name'];
	}

	public function get_all_produk_tabungan()
	{
		$sql = "SELECT 
				mfi_product_saving.product_code,
				mfi_product_saving.product_name
				FROM 
				mfi_account_saving 
				INNER JOIN mfi_product_saving ON mfi_product_saving.product_code = mfi_account_saving.product_code
				GROUP BY 1,2
				";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_majelis()
	{
		$query = $this->db->query("SELECT * FROM mfi_cm");
		return $query->result_array();
	}

	function get_all_produk_tabungan_individu(){
		$sql = "SELECT 
		mps.product_code,
		mps.product_name
		FROM mfi_account_saving AS mas
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		WHERE mps.product_type = '1'
		GROUP BY 1,2";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function export_list_pembukaan_tabungan($produk,$branch_code)
	{
		$sql = "SELECT 
		mps.product_name,
		mcm.cm_name,
		mas.account_saving_no,
		mas.status_rekening,
		mas.saldo_memo,
		mc.nama,
		mas.rencana_jangka_waktu,
		mas.rencana_setoran,
		mas.counter_angsruan,
		mas.tanggal_buka
		FROM mfi_account_saving AS mas
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		WHERE mas.status_rekening = 1 ";

		$param = array();

		if($produk != 'all'){
			$sql .= "AND mas.product_code = ? ";
			$param[] = $produk;
		}

		if($branch_code != '00000'){
			$sql.="AND mc.branch_code in(SELECT branch_code FROM mfi_branch_member
			WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "ORDER BY 2,1,6";
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_produk($produk)
	{
		$sql = "SELECT 
				mfi_product_saving.product_code,
				mfi_product_saving.product_name
				FROM 
				mfi_account_saving , mfi_product_saving
				WHERE mfi_product_saving.product_code = mfi_account_saving.product_code
				AND mfi_product_saving.product_code = ?
				";

		$query = $this->db->query($sql,array($produk));

		$row = $query->row_array();
		if(isset($row['product_name'])){
			return $row['product_name'];
		}else{
			return 0;
		}
	}

	public function export_list_rekening_tabungan($cif_no,$no_rek,$produk,$from_date,$thru_date)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_product_saving.product_name,
				mfi_product_saving.product_code,
				mfi_account_saving.account_saving_no,
				mfi_account_saving.saldo_memo,
				mfi_account_saving.saldo_riil,
				mfi_trx_account_saving.trx_account_saving_id,
				mfi_trx_account_saving.branch_id,
				mfi_trx_account_saving.account_saving_no,
				mfi_trx_account_saving.trx_saving_type,
				mfi_trx_account_saving.flag_debit_credit,
				mfi_trx_account_saving.trx_date,
				mfi_trx_account_saving.amount,
				mfi_trx_account_saving.reference_no,
				mfi_trx_account_saving.description,
				mfi_trx_account_saving.created_date,
				mfi_trx_account_saving.created_by,
				mfi_trx_account_saving.trx_sequence,
				mfi_trx_account_saving.trx_detail_id
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
				WHERE mfi_cif.cif_no = ? AND mfi_account_saving.account_saving_no = ? AND mfi_product_saving.product_code = ? AND mfi_trx_account_saving.trx_date BETWEEN ? AND ?
				";
		$query = $this->db->query($sql,array($cif_no,$no_rek,$produk,$from_date,$thru_date));

		return $query->result_array();
	}

	public function export_list_statement_tabungan($cif_no,$no_rek,$from_date,$thru_date)
	{
		$sql = "SELECT
		mtas.flag_debit_credit,
		mtas.trx_date,
		mtas.amount,
		mtas.description
		FROM mfi_trx_account_saving AS mtas
		JOIN mfi_account_saving AS mas
		ON mtas.account_saving_no = mas.account_saving_no
		JOIN mfi_cif AS mc ON mas.cif_no = mc.cif_no
		JOIN mfi_product_saving AS mps ON mas.product_code = mps.product_code
		WHERE mc.cif_no = ? AND mas.account_saving_no = ?
		AND mtas.trx_date BETWEEN ? AND ?
		ORDER BY mtas.trx_date, mtas.trx_sequence";
		$query = $this->db->query($sql,array($cif_no,$no_rek,$from_date,$thru_date));

		return $query->result_array();
	}

	public function get_saldo_awal_credit($no_rek,$from_date)
	{
		$sql = "SELECT 
				SUM(amount) AS credit
				FROM mfi_trx_account_saving WHERE account_saving_no = ? AND trx_date < ? AND flag_debit_credit = 'C'
				";
		$query = $this->db->query($sql,array($no_rek,$from_date));

		return $query->row_array();
		// return $row['credit'];
	}

	public function get_saldo_awal_debet($no_rek,$from_date)
	{
		$sql = "SELECT 
				SUM(amount) AS debit
				FROM mfi_trx_account_saving WHERE account_saving_no = ? AND trx_date < ? AND flag_debit_credit = 'D'
				";
		$query = $this->db->query($sql,array($no_rek,$from_date));

		return $query->row_array();
		// return $row['debit'];
	}

	public function get_nama($cif_no)
	{
		$sql = "SELECT nama FROM mfi_cif WHERE cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		$row = $query->row_array();
		return $row['nama'];
	}

	function export_list_buka_tabungan($produk,$from_date,$thru_date,$branch_code){
		$param = array();
		$sql = "SELECT 
		mas.account_saving_no,
		mc.nama,
		mcm.cm_name,
		mps.product_name,
		mas.tanggal_buka,
		mas.rencana_jangka_waktu,
		mas.rencana_setoran,
		mas.status_rekening,
		mas.saldo_memo,
		mas.rencana_periode_setoran
		FROM mfi_account_saving AS mas
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mas.status_rekening = '1' ";

		if($produk!="0000"){
			$sql .= "AND mps.product_code = ? ";
			$param[] = $produk;
		}

		if($from_date!="" && $thru_date!=""){
			$sql .= "AND mas.tanggal_buka BETWEEN ? AND ? ";
			$param[] = $from_date;
			$param[] = $thru_date;
		}

		if($branch_code!="0000"){
			$sql .= "AND mc.branch_code=? ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2,3,4,5,6,7,8,9,10
		ORDER BY mas.tanggal_buka ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_list_buka_tabungan_jtempo($produk,$from_date,$thru_date,$branch_code, $status,$rembug)
	{
		$param = array();
		$sql = "SELECT 
				mps.*,
				mas.*,
				mc.nama,
				cm.cm_code,
				cm.cm_name
				FROM 
				mfi_account_saving AS mas
				LEFT JOIN mfi_product_saving AS mps
				ON mps.product_code = mas.product_code
				LEFT JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
				LEFT JOIN mfi_cm AS cm ON mc.cm_code = cm.cm_code
				WHERE mas.status_rekening=1
				";

		if($produk!="0000"){
			$sql .= " AND mps.product_code = ?";
			$param[] = $produk;
		}
		if($from_date!="" && $thru_date!=""){
			$sql .= " AND (mas.tanggal_buka + (mas.rencana_jangka_waktu * 7))
			BETWEEN ? AND ?";
			$param[] = $from_date;
			$param[] = $thru_date;
		}
		if($branch_code!="0000"){
				
			$sql .= " AND mas.branch_code=?";
			$param[] = $branch_code;
		}
		if($status != "9"){
			$sql .= " AND mas.status_rekening = ?";
			$param[] = $status;
		}
		if($rembug != "0000"){
			$sql .= " AND cm.cm_code = ?";
			$param[] = $rembug;
		}

		$sql .= " ORDER BY mas.tanggal_buka,mas.rencana_akhir_kontrak ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_cetak_trans_buku($param)
	{
		$sql = "SELECT
				mfi_account_saving.saldo_riil,
				mfi_trx_account_saving.flag_debit_credit,
				mfi_trx_account_saving.trx_date,
				mfi_trx_account_saving.trx_saving_type,
				mfi_trx_account_saving.amount
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				WHERE mfi_trx_account_saving.trx_account_saving_id = ?
				";
		$query = $this->db->query($sql,array($param));

		return $query->row_array();
	}

	/*public function export_cetak_trans_buku($param)
	{
		$sql = "SELECT
				mfi_setup_margin_buku_tab.item,
				mfi_setup_margin_buku_tab.top_margin,
				mfi_setup_margin_buku_tab.bottom_margin,
				mfi_setup_margin_buku_tab.left_margin,
				mfi_setup_margin_buku_tab.right_margin,
				mfi_account_saving.saldo_riil,
				mfi_trx_account_saving.flag_debit_credit,
				mfi_trx_account_saving.trx_date,
				mfi_trx_account_saving.amount
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_setup_margin_buku_tab ON mfi_account_saving.branch_code = mfi_setup_margin_buku_tab.branch_code
				INNER JOIN mfi_account_saving ON mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				WHERE mfi_trx_account_saving.trx_account_saving_id = ?
				";
		$query = $this->db->query($sql,array($param));

		return $query->row_array();
	}*/

	public function get_margin($institution_name)
	{
		$sql = "SELECT * FROM mfi_setup_margin_buku_tab WHERE institution_name = ? order by posisi ASC";
		$query = $this->db->query($sql,array($institution_name));

		return $query->result_array();
	}

	public function get_all_produk_deposito()
	{
		$sql = "SELECT 
				mfi_product_deposit.product_code,
				mfi_product_deposit.product_name
				FROM 
				mfi_product_deposit";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function export_list_saldo_deposito($from_date,$thru_date,$product_code,$cabang)
	{
		// $sql = "SELECT 
		// 		madb.account_deposit_no,
		// 		mc.nama,
		// 		madb.trx_date,
		// 		mpd.product_name AS keterangan,
		// 		mpd.product_code AS kode,				
		// 		mad.nominal AS nominal,
		// 		mb.branch_name,
		// 		mb.branch_code,
		// 		mcm.cm_name,
		// 		mad.jangka_waktu,
		// 		madb.trx_date,
		// 		mad.tanggal_jtempo_last,
		// 		mad.automatic_roll_over

		// 		FROM mfi_account_deposit_break AS madb
		// 		LEFT OUTER JOIN mfi_account_deposit AS mad ON mad.account_deposit_no = madb.account_deposit_no
		// 		INNER JOIN mfi_cif AS mc ON mc.cif_no = mad.cif_no
		// 		LEFT OUTER JOIN mfi_product_deposit AS mpd ON mpd.product_code = mad.product_code
		// 		LEFT OUTER JOIN mfi_branch AS mb ON mb.branch_code = mad.branch_code
		// 		LEFT OUTER JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		// 		WHERE mad.tanggal_buka BETWEEN ? AND ? AND mad.status_rekening='1'
				
		// 		";
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.nominal,
				mfi_account_deposit.jangka_waktu,
				mfi_account_deposit.tanggal_buka,
				mfi_account_deposit.tanggal_jtempo_last,
				mfi_account_deposit.automatic_roll_over,
				mfi_product_deposit.product_name,
				mfi_cm.cm_name
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_deposit ON mfi_account_deposit.product_code = mfi_product_deposit.product_code
				LEFT OUTER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				WHERE mfi_account_deposit.tanggal_buka BETWEEN ? AND ?
				-- AND mfi_account_deposit.status_rekening != '2'
				";

				$param[]=$from_date;
				$param[]=$thru_date;

				if($cabang!="0000"){
					$sql.=" AND mfi_cif.branch_code=?";
					$param[]=$cabang;
				}

				if($product_code!="0000"){
				$sql .= " AND mfi_product_deposit.product_code = ? ";
				$param[] = $product_code;
				}


				// $sql.="GROUP BY 1,2,3,4,5,6,7,8,9,10,11,12,13";

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}

	public function export_rekap_saldo_deposito($produk,$branch_code)
	{
		$sql = "SELECT 
				mfi_product_deposit.product_code as kode,
				mfi_product_deposit.product_name as keterangan,
				COUNT(mfi_account_deposit.*) as jumlah,
				SUM(mfi_account_deposit.nominal) as nominal
				FROM 
				mfi_account_deposit 
				INNER JOIN mfi_product_deposit ON mfi_product_deposit.product_code = mfi_account_deposit.product_code
				LEFT OUTER JOIN mfi_branch ON mfi_branch.branch_code = mfi_account_deposit.branch_code
				
				";
				//WHERE  mfi_account_deposit.status_rekening = '1' AND mfi_product_deposit.product_code = ?
				//GROUP BY 1,2 


		if($produk!="0000"){
		$sql .= " AND mfi_product_deposit.product_code = ? ";
		$param[] = $produk;
		}

		if($branch_code!="0000"){
			$sql.=" AND mfi_branch.branch_code=?";
			$param[]=$branch_code;
		}

		$sql.="GROUP BY 1,2";


		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_produk_saving_by_norek($no_rek)
	{
		$sql = "SELECT 
						b.product_name 
				from mfi_account_saving a
				INNER JOIN mfi_product_saving b ON a.product_code=b.product_code
				WHERE a.account_saving_no = ?
				";
		$query = $this->db->query($sql,array($no_rek));

		$row = $query->row_array();
		return $row['product_name'];
	}

	public function get_produk_deposito($produk)
	{
		$sql = "SELECT 
				mfi_product_deposit.product_code,
				mfi_product_deposit.product_name
				FROM 
				mfi_product_deposit 
				WHERE mfi_product_deposit.product_code = ?
				";
		$query = $this->db->query($sql,array($produk));

		$row = $query->row_array();
		return $row['product_name'];
	}

	public function export_rekap_pembukaan_deposito($cabang,$produk,$from_date,$thru_date)
	{	
		

		$sql = "SELECT 
				mfi_product_deposit.product_code as kode,
				mfi_product_deposit.product_name as keterangan,
				COUNT(mfi_account_deposit.*) as jumlah,
				SUM(mfi_account_deposit.nominal) as nominal
				FROM 
				mfi_account_deposit 
				INNER JOIN mfi_product_deposit ON mfi_product_deposit.product_code = mfi_account_deposit.product_code
				LEFT OUTER JOIN mfi_cif ON mfi_cif.cif_no=mfi_account_deposit.cif_no
				WHERE mfi_account_deposit.tanggal_buka BETWEEN ? AND ?

				
				";

		$param=array();
		$param[]=$from_date;
		$param[]=$thru_date;
		if($produk!="0000"){
		$sql .= " AND mfi_product_deposit.product_code = ? ";
		$param[] = $produk;
		}

		if($cabang!="0000"){
			$sql.=" AND mfi_cif.branch_code=?";
			$param[]=$cabang;
		}
		
		$sql.="GROUP BY 1,2";
		$query = $this->db->query($sql,$param);

		return $query->result_array();

		// --mfi_product_deposit.product_code = ?
	}

	public function export_rekap_bagi_hasil_deposito($produk,$from_date,$thru_date)
	{
		$sql = "SELECT
				mfi_account_deposit_bahas.account_deposit_no,
				mfi_account_deposit_bahas.tanggal,
				mfi_cif.nama,
				mfi_account_deposit_bahas.saldo_bahas,
				mfi_account_deposit_bahas.nominal_bahas,
				mfi_account_deposit_bahas.zakat_bahas,
				mfi_account_deposit_bahas.pajak_bahas
				FROM
				mfi_account_deposit_bahas
				INNER JOIN mfi_account_deposit ON mfi_account_deposit_bahas.account_deposit_no = mfi_account_deposit.account_deposit_no
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_deposit ON mfi_product_deposit.product_code = mfi_account_deposit.product_code
				WHERE mfi_product_deposit.product_code = ?
				AND mfi_account_deposit_bahas.tanggal BETWEEN ? AND ?
				";
		$query = $this->db->query($sql,array($produk,$from_date,$thru_date));

		return $query->result_array();
	}

	public function export_list_rekening_deposito($cif_no,$no_rek,$produk,$from_date,$thru_date)
	{
		$sql = "SELECT
				mfi_trx_account_deposit.trx_date,
				mfi_trx_account_deposit.description,
				mfi_account_deposit.nominal,
				mfi_account_deposit.nilai_bagihasil_last,
				mfi_account_deposit_bahas.nominal_bahas,
				mfi_account_deposit_bahas.pajak_bahas
				FROM
				mfi_trx_account_deposit
				LEFT OUTER JOIN mfi_account_deposit ON mfi_trx_account_deposit.account_deposit_no = mfi_account_deposit.account_deposit_no
				LEFT OUTER JOIN mfi_product_deposit ON mfi_product_deposit.product_code = mfi_account_deposit.product_code
				LEFT OUTER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				LEFT OUTER JOIN mfi_account_deposit_bahas ON mfi_trx_account_deposit.account_deposit_no = mfi_account_deposit_bahas.account_deposit_no
				WHERE mfi_cif.cif_no = ? AND mfi_account_deposit.account_deposit_no = ? AND mfi_product_deposit.product_code = ? AND mfi_trx_account_deposit.trx_date BETWEEN ? AND ?
				";
		$query = $this->db->query($sql,array($cif_no,$no_rek,$produk,$from_date,$thru_date));

		return $query->result_array();
	}

	public function datatable_rekening_buku_tabungan_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_trx_account_saving.account_saving_no,
				mfi_trx_account_saving.trx_date,
				mfi_trx_account_saving.flag_debit_credit,
				mfi_account_saving.saldo_riil,
				mfi_trx_account_saving.trx_account_saving_id,
				mfi_cif.nama
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);
		// print_r($this->db);	
		return $query->result_array();
	}

	function get_detail_transaction($trx_gl_id)
	{
		$sql = "select 
				mfi_gl_account.account_code,
				mfi_gl_account.account_name,
				mfi_trx_gl_detail.flag_debit_credit,
				mfi_trx_gl_detail.amount,
				mfi_trx_gl_detail.description
				from mfi_trx_gl_detail , mfi_gl_account
				where mfi_trx_gl_detail.account_code = mfi_gl_account.account_code 
				and mfi_trx_gl_detail.trx_gl_id = ?
				order by mfi_trx_gl_detail.trx_sequence asc
				";
		$query = $this->db->query($sql,array($trx_gl_id));

		return $query->result_array();
	}

	/*CETAK VOUCHER BEGIN*/


	function datatable_cetak_voucher($dWhere='', $sWhere='',$sOrder='',$sLimit='')
	{
		$param = array();

		$sql = "SELECT
			mfi_trx_gl.trx_gl_id,
			mfi_trx_gl.voucher_no,
			mfi_trx_gl.voucher_ref,
			mfi_trx_gl.trx_date,
			mfi_trx_gl.voucher_date,
			mfi_trx_gl.description,
			(select sum(mfi_trx_gl_detail.amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'C') as total_credit,
			(select sum(mfi_trx_gl_detail.amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'D') as total_debit
			from mfi_trx_gl where branch_code is not null
		";
		if ( $sWhere != "" ) {

			// if($dWhere['from_date']!="" || $dWhere['to_date']!=""){
				$sql .= " $sWhere and mfi_trx_gl.voucher_date between ? and ? ";
				$param[] = $dWhere['from_date'];
				$param[] = $dWhere['to_date'];
			// }else{
				// $sql .= " $sWhere ";
			// }

		}else{

			// if($dWhere['from_date']!="" || $dWhere['to_date']!=""){
				$sql .= " and mfi_trx_gl.voucher_date between ? and ? ";
				$param[] = $dWhere['from_date'];
				$param[] = $dWhere['to_date'];
			// }

		}

		if( $dWhere['voucher_ref'] != "" ) {
			$sql .= " and voucher_ref like ? ";
			$param[] = $dWhere['voucher_ref'];
		}
		
		if( $dWhere['voucher_no'] != "" ) {
			$sql .= " and voucher_no like ? ";
			$param[] = $dWhere['voucher_no'];
		}
		
		if( $dWhere['jurnal_trx_type'] != "" ) {
			$sql .= " and jurnal_trx_type = ? ";
			$param[] = $dWhere['jurnal_trx_type'];
		}
		$branch_code = $this->session->userdata('branch_code');
		if ($branch_code!='00000') {
			$sql .= " AND mfi_trx_gl.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
			$param[] = $this->session->userdata('branch_code');
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_trx_gl_by_id($trx_gl_id)
	{
		$sql = "select
					a.voucher_no,
					a.trx_date
				from mfi_trx_gl a
				where a.trx_gl_id = ?";
		$query = $this->db->query($sql,array($trx_gl_id));

		return $query->row_array();
	}

	public  function get_trx_gl_detail_by_trx_gl_id($trx_gl_id)
	{
		$sql = "select
					b.account_code,
					b.account_name,
					(case when flag_debit_credit = 'C' then a.amount else 0 end) as credit,
					(case when flag_debit_credit = 'D' then a.amount else 0 end) as debit
				from mfi_trx_gl_detail a, mfi_gl_account b
				where a.account_code = b.account_code and
				a.trx_gl_id = ?
				order by a.trx_sequence asc
		";
		$query = $this->db->query($sql,array($trx_gl_id));

		return $query->result_array();
	}


	public function get_trx_gl($from_date,$thru_date,$branch_code='')
	{
		$param=array();
		if($from_date=="---" && $thru_date=="---"){
			$sql = "select * from mfi_trx_gl";
			if ($branch_code!="00000") {
				$sql .= " WHERE branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$query = $this->db->query($sql,$param);
		}else{
			$sql = "select * from mfi_trx_gl where voucher_date between ? and ?";
			$param[] = $from_date;
			$param[] = $thru_date;
			if ($branch_code!="00000") {
				$sql .= " and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$query = $this->db->query($sql,$param);
		}

		return $query->result_array();
	}

	public function get_cif_by_account_financing_no($account_financing_no)
	{
		$sql="SELECT 
				mfi_cif.cif_no,
				mfi_cif.cif_type
			  from mfi_account_financing,mfi_cif
			  where mfi_account_financing.cif_no=mfi_cif.cif_no
			  and mfi_account_financing.account_financing_no=?
			";
		$query=$this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	public function get_petugas()
	{
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
						 fa_code
						,fa_name
				FROM
						mfi_fa
				";

			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " WHERE branch_code = ? ";
				$param[] = $branch_code;
			}
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	
	
	public function fn_get_saldo_gl_account2($account_code,$last_date,$branch_code)
	{
		$sql = "select fn_get_saldo_awal_gl_account2(?,?,?) as saldo_awal";
		$param[]=$account_code;
		$param[]=$last_date;
		if($branch_code!='00000'){
			$param[]=$branch_code;
		}else{
			$param[]='all';
		}
		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		return $query->row_array();
	}
	
	public function get_account_group_by_code($group_code)
	{
		$sql = "select group_code, group_name from mfi_gl_account_group where group_code=?";
		$query=$this->db->query($sql,array($group_code));
		return $query->row_array();
	}

	public function get_par($branch_code='')
	{
		$param=array();
		if($branch_code==''){
			$branch_code=$this->session->userdata('branch_code');
		}

		$sql = "select tanggal_hitung from mfi_par ";
		if($branch_code!="00000"){
			$sql.="where branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[]=$branch_code;
		}

		$sql.= "group by 1 order by tanggal_hitung desc";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_tanggal_closing($branch_code){
		$sql = "SELECT closing_from_date,closing_thru_date FROM mfi_closing_ledger_data ";

		$param = array();

		if($branch_code != '00000'){
			$sql.="WHERE branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql.= "GROUP BY 1,2 ORDER BY closing_thru_date DESC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_tanggal_closing(){
		$sql = "SELECT closing_thru_date FROM mfi_closing_financing_data
		GROUP BY closing_thru_date ORDER BY closing_thru_date DESC";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_param_par()
	{
		$sql="select * from mfi_param_par order by jumlah_hari_1 asc";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	function get_fa_by_branch($branch_code='',$branch_class='')
	{
		if($branch_code==''){
			$branch_code=$this->session->userdata('branch_code');
			$branch_class=$this->session->userdata('branch_class');
		}
		$sql="select * from mfi_fa where branch_code=? order by fa_code asc";
		$query=$this->db->query($sql,array($branch_code));
		$return=$query->result_array();
		if($branch_class!='3'){
			$return=array();
		}
		return $return;
	}

	function get_cm_by_branch($branch_code='',$branch_class='')
	{
		if($branch_code==''){
			$branch_code=$this->session->userdata('branch_code');
			$branch_class=$this->session->userdata('branch_class');
		}
		$sql="select mfi_cm.* from mfi_cm,mfi_branch where mfi_cm.branch_id=mfi_branch.branch_id and mfi_branch.branch_code=? order by mfi_cm.cm_name asc";
		$query=$this->db->query($sql,array($branch_code));
		$return=$query->result_array();
		if($branch_class!='3'){
			$return=array();
		}
		return $return;
	}

	function get_cm_by_fa($branch_code,$fa_code){
		$sql="select mfi_cm.* from mfi_cm,mfi_branch
			  where mfi_cm.branch_id=mfi_branch.branch_id and
			  mfi_branch.branch_code=? and
			  mfi_cm.fa_code=?
			  order by cm_name asc";
		$query=$this->db->query($sql,array($branch_code,$fa_code));
		return $query->result_array();
	}

	function get_all_par()
	{
		$sql="SELECT par_desc from mfi_param_par order by jumlah_hari_1 asc";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	function get_cm_by_fa_code($fa_code){
		$param = array();
		$sql="select mfi_cm.* from mfi_cm,mfi_branch
			  where mfi_cm.branch_id=mfi_branch.branch_id ";
		if ($fa_code!='all') {
			$sql .=" and mfi_cm.fa_code=? ";
			$param[] = $fa_code;
		}
		$sql .=" order by cm_name asc ";
		$query=$this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_product_saving_by_saving_type($type){
		$sql = "SELECT * FROM mfi_product_saving WHERE jenis_tabungan = ? and product_code<>'0006'  ORDER BY product_code";

		$param = array($type);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_product_financing()
	{
		$sql="select * from mfi_product_financing order by product_code asc";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	function read_kreditur($sidx,$sord,$limit_rows,$start,$branch_code,$product,$tanggal,$tanggal2,$kreditur_from){
		$param = array();

		$sql = "SELECT
		maf.account_financing_id,
		mb.branch_name,
		(CASE WHEN mc.cif_type = '0' THEN
			mcm.cm_name
		ELSE
			'INDIVIDU'
		END) AS cm_name,
		mc.cif_no,
		mc.nama,
		maf.account_financing_no,
		maf.pokok,
		maf.margin,
		maf.jangka_waktu,
		(CASE WHEN maf.periode_jangka_waktu = '0' THEN
			'Hari'
		WHEN maf.periode_jangka_waktu = '1' THEN
			'Minggu'
		WHEN maf.periode_jangka_waktu = '2' THEN
			'Bulan'
		ELSE
			'Tempo'
		END) AS periode_jangka_waktu,
		maf.tanggal_akad,
		(CASE WHEN maf.sumber_dana = '0' THEN
			'Sendiri'
		WHEN maf.sumber_dana = '1' THEN
			'Kreditur'
		ELSE
			'Campuran'
		END) AS sumber_dana,
		mlcd.display_text,
		mpf.product_name
		FROM mfi_account_financing AS maf
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = maf.kreditur_code AND mlcd.code_group = 'kreditur'
		WHERE maf.status_pyd_kreditur = '0' AND maf.status_rekening = '1' AND maf.kreditur_code = ? ";

		$param[] = $kreditur_from;

		if($branch_code != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		if($product != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $product;
		}

		$sql .= "AND maf.tanggal_akad BETWEEN ? AND ? ";

		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($sidx != ''){
            $sql .= 'ORDER BY '.$sidx.' '.$sord.' ';
        }

        if($limit_rows != '' and $start != ''){
            $sql .= 'LIMIT '.$limit_rows.' OFFSET '.$start;
        }

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_kreditur()
	{
		$query = $this->db->query("SELECT * FROM mfi_list_code_detail WHERE code_group = 'kreditur' ORDER BY code_value");
		return $query->result_array();
	}

	function get_kreditur_by_code($kreditur)
	{
		$query = $this->db->query("SELECT * FROM mfi_list_code_detail WHERE code_group = 'kreditur' AND code_value = '$kreditur' "  );
		return $query->row_array(); 
	}

	function get_product_financing_by_code($product_code)
	{
		$sql="select * from mfi_product_financing where product_code=?";
		$query=$this->db->query($sql,array($product_code));
		return $query->row_array();
	}

	public function get_produk_pembiayaan_individu()
	{
		$sql = "select * from mfi_product_financing where jenis_pembiayaan = 0";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function get_produk_pembiayaan_kelompok()
	{
		$sql = "select * from mfi_product_financing where jenis_pembiayaan = 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function get_cm($branch_code='')
	{
		$param=array();
		$sql = "select mfi_cm.* from mfi_cm left join mfi_branch on mfi_branch.branch_id=mfi_cm.branch_id ";
		if($branch_code!='00000'){
			$sql.=" where mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}
		$sql .= " order by mfi_cm.cm_code asc";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_produk_name($produk)
	{
		$sql = "select product_name from mfi_product_financing where product_code = ?";
		$query = $this->db->query($sql,array($produk));
		$row = $query->row_array();
		if(isset($row['product_name'])){
			return $row['product_name'];
		}else{
			return 'SEMUA';
		}
	}

	function get_cif_by_cm_code($cm_code)
	{
		$sql = "select cif_no,nama from mfi_cif where cm_code=?";
		$query = $this->db->query($sql,array($cm_code));
		return $query->result_array();
	}

	function get_account_saving_by_cif_no($cif_no){
		$sql = "SELECT
		a.account_saving_no,
		b.product_name
		FROM mfi_account_saving a,mfi_product_saving b
		WHERE a.product_code = b.product_code
		AND b.jenis_tabungan = '1' AND a.cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));
		return $query->result_array();
	}

	function get_statement_tab_kelompok_data($cm_code,$cif_no,$tabungan,$no_rekening)
	{
		switch ($tabungan) {
			case 'tab_sukarela':
			$sql = "select";
			break;
			case 'tab_wajib':
			$sql = "select";
			break;
			case 'tab_kelompok':
			$sql = "select";
			break;
			case 'tab_berencana':
			$sql = "select";
			break;
		}

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_name_and_cm_by_cif_no($cif_no='')
	{
		$param = array();
		$sql = "SELECT a.cm_name cabang ,b.nama cif FROM mfi_cm a
				INNER JOIN mfi_cif b ON a.cm_code=b.cm_code 
				WHERE b.cif_no=? ";
		$param[]=$cif_no;
		$query = $this->db->query($sql,$param);
		return $query->row_array();
	}

	function get_saldo_awal_tab_wajib_kelompok($cif_no='',$from_date='') 
	{
		$param = array();
		$sql = "SELECT SUM(a.tab_wajib_cr*a.freq) AS s
				FROM mfi_trx_cm_detail a, mfi_trx_cm b 
				WHERE b.trx_cm_id=a.trx_cm_id and b.trx_date< ? AND a.cif_no=? ";
		$param[]=$from_date;
		$param[]=$cif_no;
		$query = $this->db->query($sql,$param);
		$data = $query->row_array();
		$return = ($data['s']>0) ? $data['s'] : 0 ;
		return $return;
	}

	function get_statement_tab_kelompok_tab_wajib($cif_no='',$from_date='',$thru_date=''){
		$param = array();
		$sql = "SELECT b.trx_date created_date, a.tab_wajib_cr, a.freq
				FROM mfi_trx_cm_detail a, mfi_trx_cm b 
				WHERE b.trx_cm_id=a.trx_cm_id and a.cif_no=?
				AND b.trx_date between ? AND ?";

		$param[]=$cif_no;
		$param[]=$from_date;
		$param[]=$thru_date;

		$sql .= "UNION ALL

				SELECT
				mtaf.trx_date created_date, maf.angsuran_tab_wajib tab_wajib_cr, mtaf.freq 
				FROM mfi_trx_account_financing mtaf, mfi_account_financing maf 
				WHERE maf.account_financing_no = mtaf.account_financing_no and maf.cif_no = ? AND mtaf.trx_date BETWEEN ? AND ?
				ORDER BY 1";
		$param[]=$cif_no;
		$param[]=$from_date;
		$param[]=$thru_date;

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_saldo_awal_tab_kel_kelompok($cif_no='',$from_date='') {
		$param = array();
		$sql = "SELECT SUM(a.tab_kelompok_cr*a.freq) AS s
				FROM mfi_trx_cm_detail a, mfi_trx_cm b 
				WHERE b.trx_cm_id=a.trx_cm_id and b.trx_date < ? AND a.cif_no=? ";
		$param[]=$from_date;
		$param[]=$cif_no;
		$query = $this->db->query($sql,$param);
		$data = $query->row_array();
		$return = ($data['s']>0) ? $data['s'] : 0 ;
		return $return;
	}


	function get_saldo_awal_sim_wajib($cif_no='',$from_date='')
	{
		$param = array();
		$sql = "SELECT SUM(a.setoran_mingguan) AS s 
				FROM mfi_trx_cm_wajib a, mfi_trx_cm_detail b, mfi_trx_cm  c 
				where a.trx_cm_detail_id=b.trx_cm_detail_id 
				and b.trx_cm_id=c.trx_cm_id 
				and c.trx_date < ? AND a.cif_no=? ";
		$param[]=$from_date;
		$param[]=$cif_no;
		$query = $this->db->query($sql,$param);
		$data = $query->row_array();
		$return = ($data['s']>0) ? $data['s'] : 0 ;
		return $return;
	}

	 


	function get_statement_tab_kelompok_sim_wajib($cif_no='',$from_date='',$thru_date=''){
		$param = array();
		$sql = "SELECT c.trx_date created_date, a.setoran_mingguan,  b.freq  
				FROM mfi_trx_cm_wajib a 
				join mfi_trx_cm_detail b on a.trx_cm_detail_id = b.trx_cm_detail_id 
				JOIN mfi_trx_cm c ON b.trx_cm_id=c.trx_cm_id 
				WHERE a.cif_no=?
				AND c.trx_date between ? AND ?  ";

		$param[]=$cif_no;
		$param[]=$from_date;
		$param[]=$thru_date;
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}


	function get_saldo_awal_tab_sukarela($cif_no='',$from_date='')
	{
		$param = array();
		/* get amount credit saldo awal dari table mfi_trx_tab_sukarela */
		$sql1 = "select coalesce(sum(amount),0) amount
				 from mfi_trx_tab_sukarela 
				 where flag_debet_credit='C' 
				 and cif_no = ? 
				 and trx_date < ? ";
		/* get amount debet saldo awal dari table mfi_trx_tab_sukarela */
		$sql2 = "select coalesce(sum(amount),0) amount
				 from mfi_trx_tab_sukarela 
				 where flag_debet_credit='D'
				 and cif_no = ? 
				 and trx_date < ?";
		/* get saldo awal dari table mfi_trx_cm_detail */
		$sql3 = "select sum(a.tab_sukarela_cr-a.tab_sukarela_db) amount
				 from mfi_trx_cm_detail a, mfi_trx_cm b
				 where a.trx_cm_id=b.trx_cm_id
				 and a.cif_no = ?
				 and b.trx_date < ?";
		/* get saldo awal dari table mfi_trx_shu_sukarela */
		$sql4 = "select sum(amount) amount
				 from mfi_trx_shu_sukarela
				 where cif_no = ? and trx_date < ?";

		$query1 = $this->db->query($sql1,array($cif_no,$from_date));
		$query2 = $this->db->query($sql2,array($cif_no,$from_date));
		$query3 = $this->db->query($sql3,array($cif_no,$from_date));
		$query4 = $this->db->query($sql4,array($cif_no,$from_date));
		
		$row1 = $query1->row_array();
		$row2 = $query2->row_array();
		$row3 = $query3->row_array();
		$row4 = $query4->row_array();

		$amount1 = $row1['amount'];
		$amount2 = $row2['amount'];
		$amount3 = $row3['amount'];
		$amount4 = $row4['amount'];

		$saldo = $amount1+$amount2+$amount3+$amount4;
		return $saldo;
	}

	function get_statement_tab_kelompok_tab_sukarela($cif_no='',$from_date='',$thru_date=''){
		$param = array();
		$sql = "select 
				trx_date,
				created_stamp,
				(case when trx_type='1' then 'TRX ANGGOTA KELUAR (TAB.WAJIB)'
				      when trx_type='2' then 'TRX ANGGOTA KELUAR (TAB.KELOMPOK)'
				      when trx_type='3' then 'TRX ANGGOTA KELUAR (TAB.BERENCANA)'
				      when trx_type='4' then 'PENCAIRAN TABUNGAN BERENCANA No.'||account_saving_no
				      when trx_type='5' then 'PELUNASAN PEMBIAYAAN No.Rek.'||account_financing_no
				      when trx_type='6' then 'TRX ANGGOTA KELUAR (BONUS)'
				      when trx_type='7' then 'BONUS (TAB.BERENCANA) No.Rek.'||account_saving_no
				      when trx_type='8' then 'BAGI HASIL TABUNGAN'
				      when trx_type='9' then 'BAGI HASIL SHU'
				      when trx_type='10' then 'TRX ANGGOTA KELUAR (TAB.INDIVIDU)'
				      when trx_type='11' then 'TRX ANGGOTA KELUAR (SIMPANAN POKOK)'
				      when trx_type='12' then 'TRX ANGGOTA KELUAR (SALDO SMK)'
				      when trx_type='13' then 'TRX ANGGOTA KELUAR (SALDO LWK)' 
				      when trx_type='14' then 'TRX ANGGOTA KELUAR (SALDO SIMPANAN WAJIB)' end) as description,
				(case when flag_debet_credit='C' then amount else 0 end) as amount_credit,
				(case when flag_debet_credit='D' then amount else 0 end) as amount_debit
				from mfi_trx_tab_sukarela
				where trx_date between ? and ? and cif_no = ?
				union all
				select
				b.trx_date,
				b.created_date as created_stamp,
				'SETORAN TABUNGAN' as description,
				a.tab_sukarela_cr as amount_credit,
				0 as amount_debit
				from mfi_trx_cm_detail a, mfi_trx_cm b
				where b.trx_cm_id=a.trx_cm_id and a.tab_sukarela_cr > 0
				and b.trx_date between ? and ? and a.cif_no = ?
				union all
				select
				b.trx_date,
				b.created_date as created_stamp,
				'PENARIKAN TABUNGAN' as description,
				0 as amount_credit,
				a.tab_sukarela_db as amount_debit
				from mfi_trx_cm_detail a, mfi_trx_cm b
				where b.trx_cm_id=a.trx_cm_id and a.tab_sukarela_db > 0
				and b.trx_date between ? and ? and a.cif_no = ?
				union all
				select
				trx_date,
				created_stamp,
				'SHU' as description,
				amount as amount_credit,
				'0' as amount_debit
				from mfi_trx_shu_sukarela
				where trx_date between ? and ? and cif_no = ?
				order by 1,2 asc";
		$param[]=$from_date;
		$param[]=$thru_date;
		$param[]=$cif_no;
		$param[]=$from_date;
		$param[]=$thru_date;
		$param[]=$cif_no;
		$param[]=$from_date;
		$param[]=$thru_date;
		$param[]=$cif_no;
		$param[]=$from_date;
		$param[]=$thru_date;
		$param[]=$cif_no;
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}


	function get_statement_kehadiran($cif_no='',$from_date='',$thru_date='')
	{
		$param = array();
		$sql = "select 
				a.cif_no, b.trx_date, a.absen 
				from mfi_trx_cm_detail a, mfi_trx_cm b 
				where a.trx_cm_id=b.trx_cm_id and a.cif_no=? and b.trx_date between ? and ? order by b.trx_date ";  
		$param[]=$cif_no;
		$param[]=$from_date;
		$param[]=$thru_date;		
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}


	function get_statement_tab_kelompok_tab_kel($cif_no='',$from_date='',$thru_date=''){
		$param = array();

		$sql = "SELECT b.trx_date created_date, a.tab_kelompok_cr, a.freq 
				FROM mfi_trx_cm_detail a, mfi_trx_cm b 
				WHERE b.trx_cm_id=a.trx_cm_id and a.cif_no=? 
				AND date(b.created_date) between ? AND ? ";

		$param[]=$cif_no;
		$param[]=$from_date;
		$param[]=$thru_date;

		$sql .= "UNION ALL

				SELECT mtaf.trx_date AS created_date, maf.angsuran_tab_kelompok AS tab_kelompok_cr, mtaf.freq
				FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf 
				WHERE maf.account_financing_no = mtaf.account_financing_no and maf.cif_no = ? AND mtaf.trx_date BETWEEN ? AND ?
				ORDER BY 1";
		$param[]=$cif_no;
		$param[]=$from_date;
		$param[]=$thru_date;

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_peutgas_by_branch_code($branch_code)
	{
		$sql="select * from mfi_fa where branch_code=? order by fa_name";
		$query = $this->db->query($sql,array($branch_code));
		return $query->result_array();
	}

	function get_rembug_by_fa_code_hari($fa_code,$hari,$majelis) {
		$param = array();
		$sql = "select cm_code,cm_name from mfi_cm where fa_code=? and hari_transaksi=?";
		$param[] = $fa_code;
		$param[] = $hari;
		if($majelis != '00000'){
			$sql .= " and cm_code = ?";
			$param[] = $majelis;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_data_lembar_absensi_anggota($branch_code,$fa_code,$cm_code)
	{
		$sql = "select a.cif_no,b.cm_name,a.nama,a.kelompok::integer from mfi_cif a, mfi_cm b where a.cm_code=b.cm_code and a.status='1' ";

		$param = array();
		if ($branch_code!="00000") {
			$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if ($fa_code!="all") {
			$sql .= " and b.fa_code = ? ";
			$param[] = $fa_code;
		}

		if ($cm_code!="all") {
			$sql .= " and b.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= " order by 1,4";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_tanggal_transaksi($cm_code,$from_date,$thru_date){
		$sql = "SELECT trx_date FROM mfi_trx_cm WHERE cm_code = ? AND trx_date BETWEEN ? AND ? ORDER BY trx_date";

		$param = array($cm_code,$from_date,$thru_date);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_trx_cm_per_cif_by_cif_ym($cif_no,$year,$month)
	{
		$from_date=$year.'-'.$month.'-01';
		$thru_date=$year.'-'.$month.'-'.date('t',strtotime($from_date));

		$sql = "select b.trx_date,a.absen
				from mfi_trx_cm_detail a, mfi_trx_cm b
				where a.trx_cm_id=b.trx_cm_id and 
				a.cif_no = ? and
				b.trx_date between ? and ?
				";
		$query = $this->db->query($sql,array($cif_no,$from_date,$thru_date));
		return $query->result_array();
	}

	function get_branch_by_code($branch_code)
	{
		$sql = "select branch_name from mfi_branch where branch_code=?";
		$query = $this->db->query($sql,array($branch_code));
		return $query->row_array();
	}
	function get_fa_by_code($fa_code)
	{
		$sql = "select fa_name from mfi_fa where fa_code=?";
		$query = $this->db->query($sql,array($fa_code));
		return $query->row_array();
	}
	function get_cm_by_code($cm_code)
	{
		$sql = "select cm_name from mfi_cm where cm_code=?";
		$query = $this->db->query($sql,array($cm_code));
		return $query->row_array();
	}
	function get_kecamatan()
	{
		$sql = "select kecamatan_code,kecamatan from mfi_city_kecamatan order by 2";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	

	/*
	| list saldo anggota
	| ujangirawan - 13 Mei 2015
	*/
	public function export_saldo_anggota_kecamatan($branch_code,$tanggal,$tanggal2,$kecamatan)
	{
		$param = array();
		$sql = "select
				a.kecamatan,
				b.desa,
				c.cm_name,
				(select count(*) from mfi_cif d 
				     where d.status='1' and d.cm_code=c.cm_code 
				     and d.tgl_gabung between ? and ?";
		$param[] = $tanggal;
		$param[] = $tanggal2;
		if ($branch_code!="00000") {
			$sql .= " and d.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$sql .= ") as num
				from mfi_city_kecamatan a, mfi_kecamatan_desa b, mfi_cm c
				where a.kecamatan_code=b.kecamatan_code and b.desa_code=c.desa_code
				and (select count(*) from mfi_cif d 
				     where d.status='1' and d.cm_code=c.cm_code 
				     and d.tgl_gabung between ? and ?";
		$param[] = $tanggal;
		$param[] = $tanggal2;
		if ($branch_code!="00000") {
			$sql .= " and d.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$sql .= ") > 0";
		if ($kecamatan!="all") {
			$sql .= " and a.kecamatan_code=?";
			$param[] = $kecamatan;
		}
		$sql .= " order by 1,2,3";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	/*
	| end saldo anggota
	*/
	
	/*
	| Export Rekap Jumlah Anggota by kota
	*/
	public function export_pdf_rekap_jumlah_anggota_kota($branch_code)
	{
		$param = array();
		$sql = "select 				
				a.city_code kode, 
				a.city keterangan,
				 count(b.cif_no) jumlah 
				from mfi_province_city a, mfi_cif b, mfi_cm c, mfi_kecamatan_desa d, mfi_city_kecamatan e 
				where a.city_code=e.city_code and e.kecamatan_code=d.kecamatan_code and d.desa_code=c.desa_code and c.cm_code=b.cm_code and b.status='1' "; 
				if ($branch_code!="00000") {
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
				} 
				$sql .= "group by 1,2  order by 1,2 ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	/*
	| end rekap_jumlah_anggota by kota
	*/
	
	/*
	| Export Rekap Jumlah Anggota by kecamatan
	*/
	public function export_pdf_rekap_jumlah_anggota_kecamatan($branch_code)
	{
		$param = array();
		$sql = "select 				
				a.kecamatan_code kode, 
				a.kecamatan keterangan,
				 count(b.cif_no) jumlah 
				from mfi_city_kecamatan a, mfi_cif b, mfi_cm c, mfi_kecamatan_desa d 
				where a.kecamatan_code=d.kecamatan_code and d.desa_code=c.desa_code and c.cm_code=b.cm_code and b.status='1' "; 
				if ($branch_code!="00000") {
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
				} 
				$sql .= "group by 1,2  order by 1,2 ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();	
	}
	/*
	| end rekap_jumlah_anggota by kecamatan
	*/
	
	/*
	| Export Rekap Jumlah Anggota by desa
	*/
	public function export_pdf_rekap_jumlah_anggota_desa($branch_code)
	{
		$param = array();
		$sql = "select 				
				a.desa_code kode, 
				a.desa keterangan,
				 count(b.cif_no) jumlah 
				from mfi_kecamatan_desa a, mfi_cif b, mfi_cm c
				where a.desa_code=c.desa_code and c.cm_code=b.cm_code and b.status='1' "; 
				if ($branch_code!="00000") {
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
				} 
				$sql .= "group by 1,2  order by 1,2 ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	/*
	| end rekap_jumlah_anggota by desa
	*/
	/*
	| Export Rekap Jumlah Anggota by rembug
	*/	
	public function export_pdf_rekap_jumlah_anggota_rembug($branch_code)
	{
		$param = array();
		$sql = "select 				
				a.cm_code kode, 
				a.cm_name keterangan,
				 count(b.cif_no) jumlah 
				from mfi_cm a, mfi_cif b 
				where a.cm_code=b.cm_code and b.status='1' "; 
				if ($branch_code!="00000") {
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
				} 
				$sql .= "group by 1,2  order by 1,2 ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	/*
	| end rekap_jumlah_anggota by rembug 
	*/
	/*
	| Export Rekap Jumlah Anggota by petugas
	*/	
	public function export_pdf_rekap_jumlah_anggota_petugas($branch_code)
	{
		$param = array();
		$sql = "select 				
				a.fa_code kode, 
				a.fa_name keterangan,
				 count(b.cif_no) jumlah 
				from mfi_fa a, mfi_cif b, mfi_cm c
				where a.fa_code=c.fa_code and c.cm_code=b.cm_code and b.status='1' "; 
				if ($branch_code!="00000") {
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
				} 
				$sql .= "group by 1,2  order by 1,2 ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	/*
	| end rekap_jumlah_anggota by petugas 
	*/

	
	
	function get_data_bahas($branch_code,$from_date,$thru_date)
	{
		$param = array();
		$sql = "select b.branch_code,a.cif_no,b.nama,c.cm_name as majelis,a.trx_date,sum(a.amount) amount
				from mfi_trx_shu_sukarela a, mfi_cif b, mfi_cm c
				where a.cif_no=b.cif_no and a.trx_date between ? and ? and b.cm_code=c.cm_code";
		$param[] = $from_date;
		$param[] = $thru_date;
		if ($branch_code!="00000") {
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$sql.= " group by 1,2,3,4,5
				union all
				select a.branch_code,a.cif_no, b.nama,c.cm_name as majelis,a.trx_date,sum(a.amount) amount
				from mfi_titipan_bagihasil a, mfi_cif b, mfi_cm c
				where a.cif_no=b.cif_no and a.status=0 and a.trx_date between ? and ? and b.cm_code=c.cm_code";
		$param[] = $from_date;
		$param[] = $thru_date;
		if ($branch_code!="00000") {
			$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$sql.= " group by 1,2,3,4,5
				order by 2,3";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_data_bahas2($branch_code,$from_date,$thru_date)
	{
		$param = array();
		$sql = "SELECT 
				mds.tahun,
				mds.shu_tahun,
				mds.shu_anggota,
				mds.shu_transaksi,
				mds.shu_modal,
				mds.total_margin,
				mds.total_modal,
				mds.tanggal_transaksi,
				mb.branch_name	
				from mfi_distribusi_shu AS mds
				LEFT OUTER JOIN mfi_branch AS mb ON mb.branch_code = mds.branch_code
				where tanggal_transaksi between ? and ? ";

		$param[] = $from_date;
		$param[] = $thru_date;

			// if($branch_code != '00000'){
			// 	$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			// 	$param[] = $branch_code;
			// }

		
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_saldo_awal_tab_berencana($account_saving_no='',$from_date='')
	{
		$param = array();
		$sql = "select sum(amount) as s from (
					
					select 
						sum(a.amount) as amount
					from mfi_trx_konversi_saving a,mfi_account_saving b,mfi_product_saving c
					where a.cif_no=b.cif_no
					and a.product_code=b.product_code
					and a.tanggal>b.tanggal_buka
					and b.product_code=c.product_code
					and c.jenis_tabungan='1'
					and a.flag_debit_credit='C'
					and b.account_saving_no = ?
					and a.tanggal<?
					
					union all
					
					select 
						sum(a.amount)*-1 as amount
					from mfi_trx_account_saving a
					left join mfi_account_saving b on b.account_saving_no=a.account_saving_no
					where a.flag_debit_credit='D'
					and a.trx_saving_type='5'
					and b.account_saving_no=?
					and a.trx_date<?
					
					union all
					
					select
						sum(b.freq*b.amount) as amount
					from mfi_trx_cm_detail_savingplan a
					join mfi_trx_cm_detail_savingplan_account b on b.trx_cm_detail_savingplan_id=a.trx_cm_detail_savingplan_id
					join mfi_trx_cm_detail c on c.trx_cm_detail_id=a.trx_cm_detail_id
					join mfi_trx_cm d on d.trx_cm_id=c.trx_cm_id
					join mfi_account_saving e on e.account_saving_no=b.account_saving_no
					join mfi_product_saving f on f.product_code=e.product_code
					where e.account_saving_no=?
					and d.trx_date<?
					and b.flag_debet_credit='C'
					
					union all
					
					select
						sum(b.freq*b.amount)*-1 as amount
					from mfi_trx_cm_detail_savingplan a
					join mfi_trx_cm_detail_savingplan_account b on b.trx_cm_detail_savingplan_id=a.trx_cm_detail_savingplan_id
					join mfi_trx_cm_detail c on c.trx_cm_detail_id=a.trx_cm_detail_id
					join mfi_trx_cm d on d.trx_cm_id=c.trx_cm_id
					join mfi_account_saving e on e.account_saving_no=b.account_saving_no
					join mfi_product_saving f on f.product_code=e.product_code
					where e.account_saving_no=?
					and d.trx_date<?
					and b.flag_debet_credit='D'

				) as saldo_awal_tab_berencana
			";
		$param[]=$account_saving_no;
		$param[]=$from_date;
		$param[]=$account_saving_no;
		$param[]=$from_date;
		$param[]=$account_saving_no;
		$param[]=$from_date;
		$param[]=$account_saving_no;
		$param[]=$from_date;
		$query = $this->db->query($sql,$param);
		$data = $query->row_array();
		$return = ($data['s']>0) ? $data['s'] : 0 ;
		return $return;
	}

	function get_statement_tab_kelompok_tab_berencana($account_saving_no='',$from_date='',$thru_date='')
	{
		$param = array();
		$sql = "select
		a.tanggal as trx_date,
		a.description,
		0 as amount_debit,
		a.amount as amount_credit
		from mfi_trx_konversi_saving a,mfi_product_saving b,mfi_account_saving c
		where a.product_code=b.product_code
		and b.jenis_tabungan='1'
		and a.cif_no=c.cif_no
		and a.product_code=c.product_code
		and a.tanggal>c.tanggal_buka
		and a.flag_debit_credit='C'
		and c.account_saving_no = ?
		and a.tanggal between ? and ?

		union all

		select
		trx_date,
		description,
		amount as amount_debit,
		0 as amount_credit
		from mfi_trx_account_saving a
		left join mfi_account_saving b on b.account_saving_no=a.account_saving_no
		where a.flag_debit_credit='D' and a.trx_saving_type='5' and b.account_saving_no=? and a.trx_date between ? and ?

		union all


		select
		d.trx_date,
		'SETORAN TABUNGAN'||' '||UPPER(f.nick_name) as description,
		0 as amount_debit,
		sum(a.amount*a.freq) as amount_credit
		from mfi_trx_cm_detail_savingplan_account a, mfi_trx_cm_detail_savingplan b, mfi_trx_cm_detail c, mfi_trx_cm d, mfi_account_saving e, mfi_product_saving f
		where a.trx_cm_detail_savingplan_id=b.trx_cm_detail_savingplan_id
		and b.trx_cm_detail_id=c.trx_cm_detail_id
		and c.trx_cm_id=d.trx_cm_id
		and a.account_saving_no=e.account_saving_no
		and e.product_code=f.product_code
		and a.account_saving_no=?
		and d.trx_date between ? and ?
		and a.flag_debet_credit='C'
		and a.freq>0
		group by 1,2,3

		union all

		select
		d.trx_date,
		'TRX KELUAR#PENCAIRAN TABUNGAN'||' '||UPPER(f.nick_name) as description,
		sum(b.amount*b.freq) as amount_debit,
		0 as amount_credit
		from mfi_trx_cm_detail_savingplan a
		join mfi_trx_cm_detail_savingplan_account b on b.trx_cm_detail_savingplan_id=a.trx_cm_detail_savingplan_id
		join mfi_trx_cm_detail c on c.trx_cm_detail_id=a.trx_cm_detail_id
		join mfi_trx_cm d on d.trx_cm_id=c.trx_cm_id
		join mfi_account_saving e on e.account_saving_no=b.account_saving_no
		join mfi_product_saving f on f.product_code=e.product_code
		where e.account_saving_no=?
		and d.trx_date between ? and ?
		and b.flag_debet_credit='D'
		and b.amount*b.freq > 0
		group by 1,2,4
		order by 1 asc";
		$param[]=$account_saving_no;
		$param[]=$from_date;
		$param[]=$thru_date;
		$param[]=$account_saving_no;
		$param[]=$from_date;
		$param[]=$thru_date;
		$param[]=$account_saving_no;
		$param[]=$from_date;
		$param[]=$thru_date;
		$param[]=$account_saving_no;
		$param[]=$from_date;
		$param[]=$thru_date;
		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		return $query->result_array();
	}

	function get_tanggal_par()
	{
		$sql="SELECT tanggal_hitung from mfi_par group by 1 order by tanggal_hitung asc";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	function show_peruntukan($code){
		$sql = "SELECT * FROM mfi_list_code_detail
		WHERE code_group = ? AND code_value != '0'
		ORDER BY display_text ASC";

		$param = array($code);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function export_rekap_sebaran_anggota($sWhere = '',$sOrder = '',$sLimit = '',$branch,$city){
		$sql = "SELECT

		mpc.city_code,
		mpc.city,

		(SELECT COUNT(mck.kecamatan_code) FROM mfi_city_kecamatan AS mck WHERE mck.city_code = mpc.city_code AND mck.kecamatan_code IN(
			SELECT kecamatan_code FROM mfi_kecamatan_desa WHERE desa_code IN(
				SELECT desa_code FROM mfi_cm WHERE cm_code IN(
					SELECT cm_code FROM mfi_cif WHERE status = '1'";


		$param = array();

		if ($sWhere != ""){
			if($branch != '00000'){
				$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch;
			}

			$sql .=")))) AS kecamatan,

			(SELECT COUNT(mkd.desa_code) FROM mfi_kecamatan_desa AS mkd
			 JOIN mfi_city_kecamatan AS mck ON mkd.kecamatan_code = mck.kecamatan_code AND mck.city_code = mpc.city_code AND mkd.desa_code IN(
				SELECT desa_code FROM mfi_cm WHERE cm_code IN(
					SELECT cm_code FROM mfi_cif WHERE status = '1'";

			if($branch != '00000'){
				$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch;
			}
			
			$sql .="))) AS desa,

			(SELECT COUNT(mcm.cm_code) FROM mfi_cm AS mcm
			 JOIN mfi_kecamatan_desa AS mkd ON mcm.desa_code = mkd.desa_code
			 JOIN mfi_city_kecamatan AS mck ON mck.kecamatan_code = mkd.kecamatan_code AND mck.city_code = mpc.city_code AND mcm.cm_code IN(
				SELECT cm_code FROM mfi_cif WHERE status = '1'";

			if($branch != '00000'){
				$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch;
			}

			$sql .= ")) AS majelis,

			(SELECT COUNT(mc.cif_no) FROM mfi_cif AS mc JOIN mfi_cm AS mcm ON mc.cm_code = mcm.cm_code JOIN mfi_kecamatan_desa AS mkd ON mcm.desa_code = mkd.desa_code JOIN mfi_city_kecamatan AS mck ON mck.kecamatan_code = mkd.kecamatan_code AND mck.city_code = mpc.city_code AND mc.status = '1'"; 

			if($branch != '00000'){
				$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch;
			}

			$sql .= ") AS anggota

			FROM mfi_province_city AS mpc
			JOIN mfi_city_kecamatan AS mck ON mck.city_code = mpc.city_code
			JOIN mfi_kecamatan_desa AS mkd ON mkd.kecamatan_code = mck.kecamatan_code
			JOIN mfi_cm AS mcm ON mcm.desa_code = mkd.desa_code
			JOIN mfi_cif AS mc ON mc.cm_code = mcm.cm_code
			JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code

			WHERE mpc.city_code IN(SELECT city_code FROM mfi_city_kecamatan WHERE kecamatan_code IN(SELECT kecamatan_code FROM mfi_kecamatan_desa WHERE desa_code IN(SELECT desa_code FROM mfi_cm WHERE cm_code IN(SELECT cm_code FROM mfi_cif WHERE status = '1'))))";
			
			if($branch != '00000'){
				$sql .= " AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch;
			}

			$sql .= " $sWhere ";
		} else {
			if($branch != '00000'){
				$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch;
			}

			$sql .=")))) AS kecamatan,

			(SELECT COUNT(mkd.desa_code) FROM mfi_kecamatan_desa AS mkd
			 JOIN mfi_city_kecamatan AS mck ON mkd.kecamatan_code = mck.kecamatan_code AND mck.city_code = mpc.city_code AND mkd.desa_code IN(
				SELECT desa_code FROM mfi_cm WHERE cm_code IN(
					SELECT cm_code FROM mfi_cif WHERE status = '1'";

			if($branch != '00000'){
				$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch;
			}
			
			$sql .="))) AS desa,

			(SELECT COUNT(mcm.cm_code) FROM mfi_cm AS mcm
			 JOIN mfi_kecamatan_desa AS mkd ON mcm.desa_code = mkd.desa_code
			 JOIN mfi_city_kecamatan AS mck ON mck.kecamatan_code = mkd.kecamatan_code AND mck.city_code = mpc.city_code AND mcm.cm_code IN(
				SELECT cm_code FROM mfi_cif WHERE status = '1'";

			if($branch != '00000'){
				$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch;
			}

			$sql .= ")) AS majelis,

			(SELECT COUNT(mc.cif_no) FROM mfi_cif AS mc JOIN mfi_cm AS mcm ON mc.cm_code = mcm.cm_code JOIN mfi_kecamatan_desa AS mkd ON mcm.desa_code = mkd.desa_code JOIN mfi_city_kecamatan AS mck ON mck.kecamatan_code = mkd.kecamatan_code AND mck.city_code = mpc.city_code AND mc.status = '1'"; 

			if($branch != '00000'){
				$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch;
			}

			$sql .= ") AS anggota

			FROM mfi_province_city AS mpc
			JOIN mfi_city_kecamatan AS mck ON mck.city_code = mpc.city_code
			JOIN mfi_kecamatan_desa AS mkd ON mkd.kecamatan_code = mck.kecamatan_code
			JOIN mfi_cm AS mcm ON mcm.desa_code = mkd.desa_code
			JOIN mfi_cif AS mc ON mc.cm_code = mcm.cm_code
			JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code

			WHERE mpc.city_code = ?";

			$param[] = $city;
			
			if($branch != '00000'){
				$sql .= " AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch;
			}
		}

		$sql .= " GROUP BY 1,2 ";

		if($sOrder != '') $sql .= "$sOrder ";

		if($sLimit != '') $sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_periode_trx($status=0)
	{
		$sql = "
			select
				periode_id
				,periode_awal
				,periode_akhir
				,status
			from mfi_trx_kontrol_periode
			where status=?
			order by periode_awal desc
		";
		$query = $this->db->query($sql,array($status));
		return $query->result_array();
	}

	function get_periode_now(){
		$sql = "SELECT * FROM mfi_trx_kontrol_periode WHERE status = '1'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	function get_all_produk($financing){
		$sql ="
			select * from mfi_product_financing where jenis_pembiayaan = ?";
			$param=array($financing);
			$query = $this->db->query($sql,$param);
		return $query->result_array();

	}

	function saldo_bulan_lalu($branch_code,$from,$thru){
		$param = array();

		$sql = "SELECT
		mga.gl_account_id,
		mga.account_code,
		mga.account_name,
		mga.account_group_code,
		COALESCE(SUM(mcld.saldo_awal),0) AS saldo_awal,
		COALESCE(SUM(mcld.total_mutasi_debet),0) AS debit,
		COALESCE(SUM(mcld.total_mutasi_credit),0) AS credit,
		COALESCE(SUM(mcld.saldo),0) AS saldo_akhir
		FROM mfi_gl_account AS mga
		JOIN mfi_closing_ledger_data AS mcld ON mcld.account_code = mga.account_code
		WHERE mcld.closing_from_date = ? AND mcld.closing_thru_date = ?
		AND mcld.flag_akhir_tahun = 'T' ";

		$param[] = $from;
		$param[] = $thru;

		if($branch_code != '00000'){
			$sql .= "AND mcld.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) AND mga.flag_akses != ?";

			$param[] = $branch_code;
			$param[] = 'P';
		}

		$sql .= "GROUP BY 1,2,3,4";

		$sql .= "ORDER BY mga.account_group_code, mga.account_code ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function saldo_bulan_ini($branch_code,$user_id){
		$param = array();

		$sql = "SELECT
		mga.gl_account_id,
		mga.account_code,
		mga.account_name,
		mga.account_group_code,
		COALESCE(SUM(mrft.saldo_awal),0) AS saldo_awal,
		COALESCE(SUM(mrft.total_mutasi_debet),0) AS debit,
		COALESCE(SUM(mrft.total_mutasi_credit),0) AS credit,
		COALESCE(SUM(mrft.saldo_akhir),0) AS saldo_akhir
		FROM mfi_report_financing_temporary AS mrft
		JOIN mfi_gl_account AS mga ON mga.account_code = mrft.account_code
		WHERE mrft.user_id = ? ";

		$param[] = $user_id;

		if($branch_code != '00000'){
			$sql .= "AND mrft.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) AND mga.flag_akses != ? ";

			$param[] = $branch_code;
			$param[] = 'P';
		}

		$sql .= "GROUP BY 1,2,3,4";

		$sql .= "ORDER BY mga.account_group_code, mga.account_code ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	/***************************************************************************************/
	//BEGIN PROYEKSI DROPING
	//Author : Aiman
	//Tgl    : 29 - 05 - 18
	/***************************************************************************************/

	function get_year()
	{
		$query = $this->db->query("SELECT DISTINCT year FROM mfi_proyeksi_droping");
		return $query->result(); 
	}

	/***************************************************************************************/
	//END PROYEKSI DROPING
	/***************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN CHANELLING DEBITUR
	/****************************************************************************************/ 

	function get_chn_debitur_upload()
	{
		$query = $this->db->query("SELECT debitur_upload_no FROM mfi_chn_report WHERE debitur_status = '0' GROUP BY debitur_upload_no"); 
		return $query->result();
	}

	function update_chn_debitur_trm($debitur_upload_no, $nik_array)
	{
		$query = $this->db->query("UPDATE mfi_chn_report SET debitur_status = '1' WHERE debitur_upload_no = '$debitur_upload_no' AND no_ktp IN ".$nik_array."");

		return $query;

	}

	function update_chn_debitur_ggl($debitur_upload_no, $nik_array)
	{
		$query = $this->db->query("UPDATE mfi_chn_report SET debitur_status = '9' WHERE debitur_upload_no = '$debitur_upload_no' AND no_ktp NOT IN ".$nik_array."");

		return $query;

	}

	/****************************************************************************************/	
	// END LAPORAN CHANELLING DEBITUR
	/****************************************************************************************/ 

	/****************************************************************************************/	
	// LAPORAN CHANELLING AKAD
	/****************************************************************************************/ 

	function get_chn_debitur_upload_1()
	{
		$query = $this->db->query("SELECT debitur_upload_no FROM mfi_chn_report WHERE debitur_status = '1' GROUP BY debitur_upload_no");
		return $query->result();
	}

	function get_chn_akad_upload_0()
	{
		$query = $this->db->query("SELECT debitur_upload_no FROM mfi_chn_report WHERE debitur_status = '1' AND akad_status = '0' GROUP BY debitur_upload_no");
		return $query->result();
	}

	function update_chn_akad_trm($debitur_upload_no, $norek_array)
	{
		$query = $this->db->query("UPDATE mfi_chn_report SET akad_status = '1' WHERE debitur_upload_no = '$debitur_upload_no' AND account_financing_no IN ".$norek_array."");

		return $query;

	}

	function update_chn_akad_ggl($debitur_upload_no, $norek_array)
	{
		$query = $this->db->query("UPDATE mfi_chn_report SET akad_status = '9' WHERE debitur_upload_no = '$debitur_upload_no' AND account_financing_no NOT IN ".$norek_array."");

		return $query;

	}

	/****************************************************************************************/	
	// END LAPORAN CHANELLING AKAD
	/****************************************************************************************/ 

	/****************************************************************************************/	
	// LAPORAN CHANELLING DROPING
	/****************************************************************************************/ 

	function get_chn_akad_upload_1()
	{
		$query = $this->db->query("SELECT debitur_upload_no FROM mfi_chn_report WHERE akad_status = '1' GROUP BY debitur_upload_no");
		return $query->result();
	}

	function get_chn_droping_upload_0()
	{
		$query = $this->db->query("SELECT debitur_upload_no FROM mfi_chn_report WHERE droping_status = '0'	 GROUP BY debitur_upload_no");
		return $query->result();
	}

	function update_kreditur_code_trm($norek_array)
	{
		$query = $this->db->query("UPDATE mfi_account_financing SET sumber_dana = '1', kreditur_code = '18' WHERE account_financing_no IN ".$norek_array."");

		return $query;

	}

	function update_chn_droping_ggl($debitur_upload_no, $norek_array)
	{
		$query = $this->db->query("UPDATE mfi_chn_report SET droping_status = '9' WHERE debitur_upload_no = '$debitur_upload_no' AND account_financing_no NOT IN ".$norek_array."");

		return $query;

	}

	/*
	function get_debitur($kreditur_code){
		$sql = "SELECT
		maf.account_financing_no,
		mb.branch_code,
		mc.nama,
		mcm.cm_name,
		mkd.desa,
		maf.tanggal_akad,
		maf.pokok,
		maf.jangka_waktu,
		mafr.description,
		mlcd.display_text AS sektor_ekonomi,
		fioe.display_text AS peruntukan,
		mc.no_ktp,
		mc.tmp_lahir,
		mc.tgl_lahir,
		mc.alamat,
		mpc.city,
		mpc.city_abbr,
		mc.kodepos,
		mc.ibu_kandung,
		mb.branch_name
		FROM mfi_account_financing AS maf
		JOIN mfi_account_financing_reg AS mafr ON mafr.registration_no = maf.registration_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value::INTEGER = maf.sektor_ekonomi AND mlcd.code_group = 'sektor_ekonomi'
		JOIN mfi_list_code_detail AS fioe ON fioe.code_value::INTEGER = maf.peruntukan AND fioe.code_group = 'peruntukan'
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_kecamatan_desa AS mkd ON mkd.desa_code = mcm.desa_code
		LEFT JOIN mfi_city_kecamatan AS mck ON mck.kecamatan_code = mkd.kecamatan_code
		LEFT JOIN mfi_province_city AS mpc ON mpc.city_code = mck.city_code
		WHERE maf.status_pyd_kreditur = '0' AND maf.status_rekening = '1' AND maf.kreditur_code = ?";

		$param = array($kreditur_code);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	*/

	function get_kreditur_by($account_financing_id){
		$sql = "SELECT
		maf.account_financing_no,
		mb.branch_code,
		mc.nama,
		mcm.cm_name,
		mkd.desa,
		maf.tanggal_akad,
		maf.pokok,
		maf.jangka_waktu,
		mafr.description,
		mlcd.display_text AS sektor_ekonomi,
		fioe.display_text AS peruntukan,
		mc.no_ktp,
		mc.tmp_lahir,
		mc.tgl_lahir,
		mc.alamat,
		mpc.city,
		mpc.city_abbr,
		mc.kodepos,
		mc.ibu_kandung,
		mb.branch_name,
		mafr.tanggal_pengajuan,
		mafr.map_no,
		mafr.doc_ktp,
		mafr.doc_kk,
		mafr.doc_pendukung,
		mafr.ttd_anggota
		FROM mfi_account_financing AS maf
		JOIN mfi_account_financing_reg AS mafr ON mafr.registration_no = maf.registration_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value::INTEGER = maf.sektor_ekonomi AND mlcd.code_group = 'sektor_ekonomi'
		JOIN mfi_list_code_detail AS fioe ON fioe.code_value::INTEGER = maf.peruntukan AND fioe.code_group = 'peruntukan'
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_kecamatan_desa AS mkd ON mkd.desa_code = mcm.desa_code
		LEFT JOIN mfi_city_kecamatan AS mck ON mck.kecamatan_code = mkd.kecamatan_code
		LEFT JOIN mfi_province_city AS mpc ON mpc.city_code = mck.city_code
		WHERE maf.status_pyd_kreditur = '0' AND maf.status_rekening = '1'  AND maf.account_financing_id = ?";

		$param = array($account_financing_id);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function update_rekening($data,$param){
		$this->db->update('mfi_account_financing',$data,$param);
	}

	function get_batch(){
		$sql = "SELECT batch_no FROM mfi_account_financing GROUP BY 1 ORDER BY 1";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	/****************************************************************************************/	
	// END LAPORAN CHANELLING DROPING
	/****************************************************************************************/ 
}