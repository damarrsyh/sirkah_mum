<?php

class Model_dashboard extends CI_Model
{
	public function get_all_anggota()
	{
		$sql = "SELECT
		COUNT (*) AS num
		FROM 
		mfi_cif";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_cabang()
	{
		$sql = "SELECT branch_code FROM mfi_cif WHERE status = 1 GROUP BY 1 ORDER BY 1 ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_petugas($branch_code)
	{
		$param = array();

		$sql = "SELECT COUNT(*) AS num FROM mfi_fa WHERE status = 1 ";

		if ($branch_code != '00000') {
			$sql .= "AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql, $param);

		return $query->row_array();
	}

	function get_anggota($branch_code)
	{
		$param = array();

		$sql = "SELECT COUNT(*) AS num FROM mfi_cif WHERE status = '1' ";

		if ($branch_code != '00000') {
			$sql .= "AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql, $param);

		return $query->row_array();
	}

	function get_simwa_simpok_sukarela($branch_code)
	{
		$param = array();

		$sql = "SELECT SUM(a.tabungan_minggon) AS total_simwa, SUM(a.setoran_lwk) AS total_simpok, SUM(a.tabungan_sukarela) AS total_sukarela FROM mfi_account_default_balance AS a, mfi_cif AS b WHERE a.cif_no = b.cif_no AND b.status = '1' ";

		if ($branch_code <> '00000') {
			$sql .= "AND b.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql, $param);

		return $query->row_array();
	}

	function get_dtk($branch_code)
	{
		$param = array();

		$sql = "SELECT SUM(saldo_memo) AS saldo_taber FROM mfi_account_saving WHERE status_rekening = '1' AND product_code = '0099' ";

		if ($branch_code <> '00000') {
			$sql .= "AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql, $param);

		return $query->row_array();
	}

	function get_taber($branch_code)
	{
		$param = array();

		$sql = "SELECT SUM(saldo_memo) AS saldo_taber FROM mfi_account_saving WHERE status_rekening = '1' AND product_code <> '0099' ";

		if ($branch_code <> '00000') {
			$sql .= "AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql, $param);

		return $query->row_array();
	}

	function get_shu($branch_code, $closing_thru_date, $account_code)
	{
		$param = array();

		$sql = "SELECT SUM(saldo) AS amount FROM mfi_closing_ledger_data WHERE closing_thru_date = ? AND flag_akhir_tahun = 'T' AND account_code LIKE ? ";

		$param[] = $closing_thru_date;
		$param[] = $account_code . '%';

		if ($branch_code <> '00000') {
			$sql .= "AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql, $param);

		return $query->row_array();
	}

	public function get_all_petugas()
	{
		$sql = "SELECT
		COUNT (*) AS num
		FROM 
		mfi_fa";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_all_rembug()
	{
		$sql = "SELECT
		COUNT (*) AS num
		FROM 
		mfi_cm where status_aktif='Y' ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_rembug($branch_code)
	{
		$param = array();

		$sql = "SELECT COUNT(mcm.*) AS num FROM mfi_cm AS mcm, mfi_branch AS mb WHERE mcm.branch_id = mb.branch_id AND status_aktif = 'Y' ";

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_code = ?) ";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql, $param);

		return $query->row_array();
	}

	function chart_anggota($branch_code)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		COUNT(mc.*) AS count
		FROM mfi_branch AS mb
		JOIN mfi_cif AS mc ON mc.branch_code = mb.branch_code
		WHERE mc.status = '1' ";

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_petugas($branch_code)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		COUNT(mf.*) AS count
		FROM mfi_branch AS mb
		JOIN mfi_fa AS mf ON mf.branch_code = mb.branch_code
		WHERE mf.status = '1' ";

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_rembug($branch_code)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		COUNT(mcm.*) AS count
		FROM mfi_branch AS mb
		JOIN mfi_cm AS mcm ON mcm.branch_id = mb.branch_id
		WHERE mcm.status_aktif = 'Y' ";

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_simwa($branch_code)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		SUM(madb.tabungan_minggon) AS total_simwa
		FROM mfi_branch AS mb
		JOIN mfi_cif AS mc ON mc.branch_code = mb.branch_code
		JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		WHERE mc.status = '1' ";

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_simpok($branch_code)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		SUM(madb.setoran_lwk) AS total_simpok
		FROM mfi_branch AS mb
		JOIN mfi_cif AS mc ON mc.branch_code = mb.branch_code
		JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		WHERE mc.status = '1' ";

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_sukarela($branch_code)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		SUM(madb.tabungan_sukarela) AS total_sukarela
		FROM mfi_branch AS mb
		JOIN mfi_cif AS mc ON mc.branch_code = mb.branch_code
		JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		WHERE mc.status = '1' ";

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_dtk($branch_code)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		SUM(mas.saldo_memo) AS total_taber
		FROM mfi_branch AS mb
		JOIN mfi_account_saving AS mas ON mas.branch_code = mb.branch_code
		WHERE mas.status_rekening = '1' AND mas.product_code = '0099' ";

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_taber($branch_code)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		SUM(mas.saldo_memo) AS total_taber
		FROM mfi_branch AS mb
		JOIN mfi_account_saving AS mas ON mas.branch_code = mb.branch_code
		WHERE mas.status_rekening = '1' AND mas.product_code <> '0099' ";

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_disbursement($branch_code, $periode_awal, $periode_akhir)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		SUM(maf.pokok) AS total_disbursement
		FROM mfi_branch AS mb
		JOIN mfi_account_financing AS maf ON maf.branch_code = mb.branch_code
		JOIN mfi_account_financing_droping AS mafd ON mafd.account_financing_no = maf.account_financing_no
		WHERE mafd.droping_date BETWEEN ? AND ? ";

		$param[] = $periode_awal;
		$param[] = $periode_akhir;

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_outstanding($branch_code)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		SUM(maf.saldo_pokok) AS total_outstanding
		FROM mfi_branch AS mb
		JOIN mfi_account_financing AS maf ON maf.branch_code = mb.branch_code
		WHERE maf.status_rekening = '1' ";

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_par($branch_code)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		SUM(mp.saldo_pokok) AS total_par
		FROM mfi_branch AS mb
		JOIN mfi_par AS mp ON mp.branch_code = mb.branch_code
		WHERE mp.tanggal_hitung = ? AND mp.par NOT IN('0','10') ";

		$param[] = $this->get_max_par_tanggal_hitung();

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_shu($branch_code, $closing_thru_date)
	{
		$param = array();

		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		(SELECT SUM(saldo) FROM mfi_closing_ledger_data WHERE branch_code = ? AND closing_thru_date = ? AND flag_akhir_tahun = 'T' AND account_code LIKE '4%') AS pendapatan,
		(SELECT SUM(saldo) FROM mfi_closing_ledger_data WHERE branch_code = ? AND closing_thru_date = ? AND flag_akhir_tahun = 'T' AND account_code LIKE '5%') AS biaya
		FROM mfi_branch AS mb ";

		$param[] = $branch_code;
		$param[] = $closing_thru_date;
		$param[] = $branch_code;
		$param[] = $closing_thru_date;

		if ($branch_code != '00000') {
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		$query = $this->db->query($sql, $param);

		return $query->result_array();
	}

	function chart_peruntukan($branch_code)
	{
		$sql = "SELECT
		a.peruntukan,
		b.display_text,
		COUNT(a.*) AS count,
		SUM(a.saldo_pokok) AS saldo_pokok
		FROM mfi_account_financing AS a
		JOIN mfi_list_code_detail AS b ON a.peruntukan = b.display_sort
		WHERE b.code_group = 'peruntukan' AND a.status_rekening = '1'";

		$array = array();

		if ($branch_code != '00000') {
			$sql .= " AND branch_code IN (SELECT branch_code FROM mfi_branch_member
			WHERE branch_induk = ?)";

			$array = array($branch_code);
		}

		$sql .= " GROUP BY 1,2 ORDER BY 3 DESC";

		$query = $this->db->query($sql, $array);
		return $query->result_array();
	}

	/**
	 * APM 20-Jan-02
	 */

	public function get_max_par_tanggal_hitung()
	{
		$where = NULL;
		if ($this->session->userdata('branch_code') != '00000') {
			$branch_code = $this->session->userdata('branch_code');
			$where = "WHERE branch_code = '" . $branch_code . "'";
		}
		$exec = $this->db->query("SELECT MAX(tanggal_hitung) AS tanggal_hitung FROM mfi_par " . $where);

		$count = $exec->num_rows();

		if ($count == 0) {
			return NULL;
			exit;
		}

		$tanggal_hitung = $exec->row()->tanggal_hitung;
		return $tanggal_hitung;
	}

	public function get_par()
	{
		$tanggal_hitung = $this->get_max_par_tanggal_hitung();

		$param_pars   = $this->db->get('mfi_param_par');
		$i            = 0;
		$par_desc[$i] = ['Pembiayaan Lancar', '0'];

		foreach ($param_pars->result() as $param_par) {
			$i++;
			$par_desc[$i] = ['Tertunggak ' . $param_par->par_desc . ' Hari', $param_par->par_desc];
		}

		$total = 0;
		foreach ($par_desc as $key) {
			$this->db->select('SUM(saldo_pokok) AS saldo_pokok');
			if ($this->session->userdata('branch_code') != '00000') {
				$this->db->where('branch_code', $this->session->userdata('branch_code'));
			}
			$this->db->where('tanggal_hitung', $tanggal_hitung);
			$this->db->where('par_desc', $key[1]);
			$exec = $this->db->get('mfi_par');

			$total += $exec->row()->saldo_pokok;
		}

		foreach ($par_desc as $key) {
			$this->db->select('SUM(saldo_pokok) AS saldo_pokok');
			if ($this->session->userdata('branch_code') != '00000') {
				$this->db->where('branch_code', $this->session->userdata('branch_code'));
			}
			$this->db->where('tanggal_hitung', $tanggal_hitung);
			$this->db->where('par_desc', $key[1]);
			$exec = $this->db->get('mfi_par');

			$persennya = number_format(($exec->row()->saldo_pokok / $total) * 100, 2);

			$data[] = [
				'label' => $key[0] . ' (' . number_format($exec->row()->saldo_pokok, 0) . ') ' . $persennya . '%',
				'value' => $exec->row()->saldo_pokok
			];
		}
		return $data;
	}


	public function get_par_10up()
	{
		$tanggal_hitung = $this->get_max_par_tanggal_hitung();
		$this->db->select('SUM(saldo_pokok) AS saldo_pokok, SUM(cadangan_piutang) AS cpp');
		if ($this->session->userdata('branch_code') != '00000') {
			$this->db->where('branch_code', $this->session->userdata('branch_code'));
		}

		$not_in = ['0', '10'];
		$this->db->where('tanggal_hitung', $tanggal_hitung);
		$this->db->where_not_in('par', $not_in);

		$query = $this->db->get('mfi_par');
		return $query->row_array();
	}

	public function get_par_all_v2($branch_code)
	{
		$tanggal_hitung = $this->get_max_par_tanggal_hitung();
		$this->db->select('SUM(saldo_pokok) AS saldo_pokok');
		if ($branch_code != '00000') {
			$this->db->where('branch_code', $branch_code);
		}

		$this->db->where('tanggal_hitung', $tanggal_hitung);
		$query = $this->db->get('mfi_par');
		return $query->row_array();
	}

	public function get_par_all()
	{
		$tanggal_hitung = $this->get_max_par_tanggal_hitung();
		$this->db->select('SUM(saldo_pokok) AS saldo_pokok');
		if ($this->session->userdata('branch_code') != '00000') {
			$this->db->where('branch_code', $this->session->userdata('branch_code'));
		}

		$this->db->where('tanggal_hitung', $tanggal_hitung);
		$query = $this->db->get('mfi_par');
		return $query->row_array();
	}

	public function get_outstanding()
	{
		$this->db->select('SUM(saldo_pokok) AS outstanding');
		if ($this->session->userdata('branch_code') != '00000') {
			$this->db->where('branch_code', $this->session->userdata('branch_code'));
		}
		$this->db->where('status_rekening', '1');
		$query = $this->db->get('mfi_account_financing');
		return $query->row_array();
	}

	public function get_outstanding_taber()
	{
		$this->db->select('SUM(saldo_memo) AS outstanding_taber');
		if ($this->session->userdata('branch_code') != '00000') {
			$this->db->where('branch_code', $this->session->userdata('branch_code'));
		}
		$not_in = ['0006', '0009', '0099'];
		$this->db->where('status_rekening', '1');
		$this->db->where_not_in('product_code', $not_in);
		$query = $this->db->get('mfi_account_saving');
		return $query->row_array();
	}

	public function get_tab()
	{
		$this->db->select("
			prdsav.product_code,
			prdsav.product_name, prdsav.nick_name,
			(
			SELECT coalesce (SUM(accs.saldo_memo),0) FROM mfi_account_saving AS accs WHERE prdsav.product_code = accs.product_code AND accs.status_rekening = '1'
			) AS nominal
			", FALSE);
		$this->db->order_by('prdsav.product_code', 'asc');

		$not_in = ['0006', '0009', '0099'];
		$this->db->where_not_in('prdsav.product_code', $not_in);
		$que = $this->db->get('mfi_product_saving AS prdsav');

		$total = 0;
		foreach ($que->result() as $key) {
			$total += $key->nominal;
		}

		foreach ($que->result() as $key) {
			$persennya = ($key->nominal / $total) * 100;
			$data[] = [
				'product_code'     => $key->product_code,
				'product_name'     => $key->nick_name,
				'nominal'          => $key->nominal,
				'nominal_formated' => number_format($key->nominal, 0),
				'persen'           => number_format($persennya, 2),
			];
		}
		return $data;
	}


	public function get_periode_awal()
	{
		$sql = "select periode_awal from mfi_trx_kontrol_periode where status = 1 limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	} 

	public function get_tahun()
	{
		$sql = "select year (periode_awal) from mfi_trx_kontrol_periode where status = 1 limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function get_bulan()
	{
		$sql = "select month (periode_awal) from mfi_trx_kontrol_periode where status = 1 limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function get_periode_akhir()
	{
		$sql = "select periode_akhir from mfi_trx_kontrol_periode where status = 1 limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function get_drop($periode_awal, $periode_akhir, $branch_code)
	{
		$sql = "SELECT prdfin.product_code, prdfin.product_name, prdfin.nick_name, 
				SUM(accfin.pokok) as nominal  
				FROM mfi_product_financing as prdfin 
				left join mfi_account_financing AS accfin on prdfin.product_code= accfin.product_code and accfin.status_rekening<>'0' and accfin.tanggal_akad  between ? and ?    
				";

		$param   = array();
		$param[] = $periode_awal;
		$param[] = $periode_akhir;

		if ($branch_code != '00000') {
			$sql .= " and accfin.branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?)";

			$param[] = $branch_code;
		}

		$sql .= "group by 1,2,3  order by 1 ";

		$que = $this->db->query($sql, $param);

		$total = 0;
		foreach ($que->result() as $key) {
			$total += $key->nominal;
		}

		foreach ($que->result() as $key) {
			$persennya = ($key->nominal / $total) * 100;
			$data[] = [
				'product_code'     => $key->product_code,
				'product_name'     => $key->nick_name,
				'nominal'          => $key->nominal,
				'nominal_formated' => number_format($key->nominal, 0),
				'persen'           => number_format($persennya, 2),
			];
		}
		return $data;
	}

	public function get_drop_vs($periode_awal, $periode_akhir, $branch_code, $tahun, $bulan )
	{
		if ($branch_code == '00000') {
			$sql = "SELECT target_item product_code, 'droping target' product_name , 'target' nick_name , sum(t";
			$sql .=	$bulan;
			$sql .=") nominal ";
			$sql .= " from mfi_target_cabang where tahun=? and target_item='301' group by 1,2,3  
					union all 
					SELECT target_item product_code, 'droping real' product_name ,  'real' nick_name, 
					(select sum (pokok) from mfi_account_financing where status_rekening='1' and tanggal_akad between ? and ? ) nominal  
					from mfi_target_cabang where tahun=? and target_item='301' group by 1, 2, 3 ";

			$param   = array(); 
			$param[] = $tahun; 
			$param[] = $periode_awal; 
			$param[] = $periode_akhir; 
			$param[] = $tahun; 			
		}
		else 
		{
			$sql = "SELECT target_item product_code, 'droping target' product_name , 'target' nick_name , sum(t";
			$sql .=$bulan;
			$sql .=") nominal ";
			$sql .= " from mfi_target_cabang where tahun=? and target_item='301' 
					and branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?) group by 1,2,3  
					union all 
					SELECT target_item product_code, 'droping real' product_name ,  'real' nick_name, 
					(select  coalesce (SUM(pokok),0) from mfi_account_financing where status_rekening='1' and tanggal_akad between ? and ? 
					and branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?)  ) nominal  
					from mfi_target_cabang where tahun=? and target_item='301' 
					and branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?)  group by 1, 2, 3 ";

			$param   = array(); 
			$param[] = $tahun; 
			$param[] = $branch_code; 
			$param[] = $periode_awal; 
			$param[] = $periode_akhir; 
			$param[] = $branch_code; 
			$param[] = $tahun; 
			$param[] = $branch_code; 			

		}

		$que = $this->db->query($sql, $param);

		$total = 0;
		foreach ($que->result() as $key) {
			$total += $key->nominal;
		}

		foreach ($que->result() as $key) {
			///$persennya = ($key->nominal / $total) * 100; 
			$persennya =0;
			$data[] = [
				'product_code'     => $key->product_code,
				'product_name'     => $key->nick_name,
				'nominal'          => $key->nominal,
				'nominal_formated' => number_format($key->nominal, 0),
				'persen'           => number_format($persennya, 2),
			];
		}
		return $data;
	}

	public function get_outs_vs($periode_awal, $periode_akhir, $branch_code, $tahun, $bulan )
	{	
		if ($branch_code == '00000') { 
			$sql = "SELECT target_item product_code, 'outstanding target' product_name , 'target' nick_name , sum(t";
			$sql .= $bulan;
			$sql .= ") nominal ";
			$sql .= " from mfi_target_cabang where tahun=? and target_item='302' group by 1,2,3  
					union all 
					SELECT target_item product_code, 'outstanding real' product_name ,  'real' nick_name, 
					(select sum (saldo_pokok) from mfi_account_financing where status_rekening='1' ) nominal  
					from mfi_target_cabang where tahun=? and target_item='302' group by 1, 2, 3 ";

			$param   = array(); 
			$param[] = $tahun; 
			$param[] = $tahun; 	
		} 
		else 
		{
			$sql = "SELECT target_item product_code, 'outstanding target' product_name , 'target' nick_name , sum(t";
			$sql .= $bulan;
			$sql .= ") nominal " ;
			$sql .= " from mfi_target_cabang where tahun=? and target_item='302' 
					and branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?) group by 1,2,3  
					union all 
					SELECT target_item product_code, 'outstanding real' product_name ,  'real' nick_name, 
					(select coalesce (SUM(saldo_pokok),0) from mfi_account_financing where status_rekening='1' 
					 and branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?) ) nominal  
					from mfi_target_cabang where tahun=? and target_item='302' 
					and branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?) group by 1, 2, 3 ";			
			$param   = array(); 
			$param[] = $tahun; 
			$param[] = $branch_code; 
			$param[] = $branch_code; 
			$param[] = $tahun; 
			$param[] = $branch_code;
		} 

		$que = $this->db->query($sql, $param);

		$total = 0;
		foreach ($que->result() as $key) {
			$total += $key->nominal;
		}

		foreach ($que->result() as $key) {
			///$persennya = ($key->nominal / $total) * 100;
			$persennya =0;
			$data[] = [
				'product_code'     => $key->product_code,
				'product_name'     => $key->nick_name,
				'nominal'          => $key->nominal,
				'nominal_formated' => number_format($key->nominal, 0),
				'persen'           => number_format($persennya, 2),
			];
		}
		return $data;
	}


	public function get_angs($periode_awal, $periode_akhir, $branch_code)
	{
		$sql = "SELECT mpf.product_code, mpf.product_name, mpf.nick_name, sum(mtcmd.angsuran_pokok*mtcmd.freq) nominal 
				from mfi_trx_cm_detail as mtcmd
				join mfi_trx_cm  as mtcm on mtcm.trx_cm_id=mtcmd.trx_cm_id 
				join mfi_account_financing  as maf on mtcmd.account_financing_no=maf.account_financing_no 
				left join mfi_product_financing as mpf on maf.product_code=mpf.product_code 
				where mtcmd.freq>0 and mtcm.trx_date between ? and ? 
				";

		$param   = array();
		$param[] = $periode_awal;
		$param[] = $periode_akhir;

		if ($branch_code != '00000') {
			$sql .= " where branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?)";

			$param[] = $branch_code;
		}

		$sql .= "group by 1,2,3  order by 1 ";

		$que = $this->db->query($sql, $param);

		$total = 0;
		foreach ($que->result() as $key) {
			$total += $key->nominal;
		}

		foreach ($que->result() as $key) {
			$persennya = ($key->nominal / $total) * 100;
			$data[] = [
				'product_code'     => $key->product_code,
				'product_name'     => $key->nick_name,
				'nominal'          => $key->nominal,
				'nominal_formated' => number_format($key->nominal, 0),
				'persen'           => number_format($persennya, 2),
			];
		}
		return $data;
	}


	public function get_disbursement($periode_awal, $periode_akhir, $branch_code)
	{
		$sql = "SELECT SUM(accfin.pokok) as disbursement  
				FROM mfi_account_financing as accfin, mfi_account_financing_droping as accfd  
				WHERE accfin.account_financing_no = accfd.account_financing_no  and accfd.droping_date  between ? and ?    
				";
		$param   = array();
		$param[] = $periode_awal;
		$param[] = $periode_akhir;

		if ($branch_code != '00000') {
			$sql .= " and accfin.branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql, $param);
		return $query->row_array();
	}

	public function get_payment($periode_awal, $periode_akhir, $branch_code)
	{
		$sql = "SELECT sum(mtcmd.angsuran_pokok*mtcmd.freq) as payment 
				from mfi_trx_cm_detail as mtcmd
				join mfi_trx_cm  as mtcm on mtcm.trx_cm_id=mtcmd.trx_cm_id 
				join mfi_account_financing  as maf on mtcmd.account_financing_no=maf.account_financing_no 
				where mtcmd.freq>0 and mtcm.trx_date between ? and ?    
				";
		$param   = array();
		$param[] = $periode_awal;
		$param[] = $periode_akhir;

		if ($branch_code != '00000') {
			$sql .= " and maf.branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql, $param);
		return $query->row_array();
	}
}
