<?php

Class Model_dashboard extends CI_Model {

	// public function get_anggota($branch_code)
	// {
	// 	$sql = "SELECT
	// 	COUNT (*) AS num
	// 	FROM 
	// 	mfi_cif where status=1 ";
	// 	if($branch_code!="00000"){
	// 		$sql.=" and branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
	// 	}
	// 	$query = $this->db->query($sql,array($branch_code));

	// 	return $query->result_array();
	// }

	public function get_anggota($branch_code)
	{
		$this->db->where('mfi_cif.status =', '1');

		if($branch_code != '00000'){
			$this->db->where("mfi_cif.branch_code in (select branch_code from mfi_branch_member where branch_induk = '".$branch_code."')", NULL, FALSE);
		}


		return $this->db->count_all_results('mfi_cif');
	}

	public function get_all_anggota()
	{
		$sql = "SELECT
		COUNT (*) AS num
		FROM 
		mfi_cif";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_petugas($branch_code)
	{
		$sql = "SELECT
		COUNT (*) AS num
		FROM 
		mfi_fa where status=1 ";
		if($branch_code!="00000"){
			$sql.=" AND branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
		}
		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
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

	public function get_rembug($branch_code)
	{
		$sql = "SELECT
		COUNT (*) AS num
		FROM mfi_cm,mfi_branch
		WHERE mfi_cm.branch_id=mfi_branch.branch_id and status_aktif='Y' 
		";
		if($branch_code!="00000"){
			$sql.=" AND branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
		}
		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
	}

	function chart_anggota($branch_code){
		$sql = "SELECT
		mb.branch_code,
		mb.branch_name AS display_text,
		COUNT(mc.*) AS count
		FROM mfi_branch AS mb
		JOIN mfi_cif AS mc ON mc.branch_code = mb.branch_code";

		$array = array();

		if($branch_code != '00000'){
			$sql .= " AND mb.branch_code IN (SELECT branch_code FROM mfi_branch_member
			WHERE branch_induk = ?)";
			$array = array($branch_code);
		}

		$sql .= " GROUP BY 1,2";

		$query = $this->db->query($sql,$array);

		return $query->result_array();
	}

	function chart_peruntukan($branch_code){
		$sql = "SELECT
		a.peruntukan,
		b.display_text,
		COUNT(a.*) AS count,
		SUM(a.saldo_pokok) AS saldo_pokok
		FROM mfi_account_financing AS a
		JOIN mfi_list_code_detail AS b ON a.peruntukan = b.display_sort
		WHERE b.code_group = 'peruntukan' AND a.status_rekening = '1'";

		$array = array();

		if($branch_code != '00000'){
			$sql .=" AND branch_code IN (SELECT branch_code FROM mfi_branch_member
			WHERE branch_induk = ?)";

			$array = array($branch_code);
		}

		$sql .= " GROUP BY 1,2 ORDER BY 3 DESC";

		$query = $this->db->query($sql,$array);
		return $query->result_array();
	}

	/**
	 * APM 20-Jan-02
	 */
	
	public function get_max_par_tanggal_hitung()
	{
		$where = NULL;
		if($this->session->userdata('branch_code') != '00000'){
			$branch_code = $this->session->userdata('branch_code');
			$where = "WHERE branch_code = '".$branch_code."'";
		}
		$exec = $this->db->query("SELECT MAX(tanggal_hitung) AS tanggal_hitung FROM mfi_par ".$where);

		$count = $exec->num_rows();

		if($count == 0){
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
			$par_desc[$i] = ['Tertunggak '.$param_par->par_desc.' Hari', $param_par->par_desc];
		}

		$total = 0;
		foreach ($par_desc as $key) {
			$this->db->select('SUM(saldo_pokok) AS saldo_pokok');
			if($this->session->userdata('branch_code') != '00000'){
				$this->db->where('branch_code', $this->session->userdata('branch_code'));
			}
			$this->db->where('tanggal_hitung', $tanggal_hitung);
			$this->db->where('par_desc', $key[1]);
			$exec = $this->db->get('mfi_par');

			$total += $exec->row()->saldo_pokok;
		}

		foreach ($par_desc as $key) {
			$this->db->select('SUM(saldo_pokok) AS saldo_pokok');
			if($this->session->userdata('branch_code') != '00000'){
				$this->db->where('branch_code', $this->session->userdata('branch_code'));
			}
			$this->db->where('tanggal_hitung', $tanggal_hitung);
			$this->db->where('par_desc', $key[1]);
			$exec = $this->db->get('mfi_par');

			$persennya = number_format(($exec->row()->saldo_pokok / $total) * 100, 2);

			$data[] = [
				'label' => $key[0].' ('.number_format($exec->row()->saldo_pokok,0).') '.$persennya.'%',
				'value' => $exec->row()->saldo_pokok
			];
		}
		return $data;
	}


	public function get_par_10up()
	{
		$tanggal_hitung = $this->get_max_par_tanggal_hitung();
		$this->db->select('SUM(saldo_pokok) AS saldo_pokok, SUM(cadangan_piutang) AS cpp');
		if($this->session->userdata('branch_code') != '00000')
		{
			$this->db->where('branch_code', $this->session->userdata('branch_code'));
		}

		$not_in = ['0', '10'];
		$this->db->where('tanggal_hitung', $tanggal_hitung);
		$this->db->where_not_in('par', $not_in );

		$query = $this->db->get('mfi_par');
		return $query->row_array();
	}


	public function get_par_all()
	{
		$tanggal_hitung = $this->get_max_par_tanggal_hitung();
		$this->db->select('SUM(saldo_pokok) AS saldo_pokok');
		if($this->session->userdata('branch_code') != '00000')
		{
			$this->db->where('branch_code', $this->session->userdata('branch_code'));
		}

		$this->db->where('tanggal_hitung', $tanggal_hitung);
		$query = $this->db->get('mfi_par'); 
		return $query->row_array();
	}

	public function get_outstanding()
	{
		$this->db->select('SUM(saldo_pokok) AS outstanding');
		if($this->session->userdata('branch_code') != '00000')
		{
			$this->db->where('branch_code', $this->session->userdata('branch_code'));
		}
		$this->db->where('status_rekening', '1' );
		$query = $this->db->get('mfi_account_financing'); 
		return $query->row_array();
	}

	public function get_outstanding_taber()
	{
		$this->db->select('SUM(saldo_memo) AS outstanding_taber');
		if($this->session->userdata('branch_code') != '00000')
		{
			$this->db->where('branch_code', $this->session->userdata('branch_code'));
		}
		$not_in = ['0006', '0009','0099'];
		$this->db->where('status_rekening', '1' );
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
				'nominal_formated' => number_format($key->nominal,0),
				'persen'           => number_format($persennya,2),
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

	public function get_periode_akhir()
	{
		$sql = "select periode_akhir from mfi_trx_kontrol_periode where status = 1 limit 1"; 
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function get_drop( $periode_awal, $periode_akhir, $branch_code )
	{
		$sql = "SELECT prdfin.product_code, prdfin.product_name, prdfin.nick_name, 
				SUM(accfin.pokok) as nominal  
				FROM mfi_product_financing as prdfin 
				left join mfi_account_financing AS accfin on prdfin.product_code= accfin.product_code and accfin.status_rekening<>'0' and accfin.tanggal_akad  between ? and ?    
				"; 

		$param   = array();
		$param[] = $periode_awal;
		$param[] = $periode_akhir;

		if($branch_code != '00000'){
			$sql .=" and accfin.branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?)";

			$param[] = $branch_code;
		}
		
		$sql .="group by 1,2,3  order by 1 ";

		$que = $this->db->query($sql,$param);

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
				'nominal_formated' => number_format($key->nominal,0),
				'persen'           => number_format($persennya,2),
			];
		}
		return $data;
	}

	public function get_angs( $periode_awal, $periode_akhir, $branch_code )
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

		if($branch_code != '00000'){
			$sql .=" where branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?)";

			$param[] = $branch_code;
		}
		
		$sql .="group by 1,2,3  order by 1 ";

		$que = $this->db->query($sql,$param);

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
				'nominal_formated' => number_format($key->nominal,0),
				'persen'           => number_format($persennya,2),
			];
		}
		return $data;
	}


	public function get_disbursement( $periode_awal, $periode_akhir, $branch_code )
	{
		$sql = "SELECT SUM(accfin.pokok) as disbursement  
				FROM mfi_account_financing as accfin, mfi_account_financing_droping as accfd  
				WHERE accfin.account_financing_no = accfd.account_financing_no  and accfd.droping_date  between ? and ?    
				"; 
		$param   = array();
		$param[] = $periode_awal;
		$param[] = $periode_akhir;

		if($branch_code != '00000'){
			$sql .=" and accfin.branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		return $query->row_array();
	}

	public function get_payment( $periode_awal, $periode_akhir, $branch_code )
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

		if($branch_code != '00000'){
			$sql .=" and maf.branch_code IN (SELECT branch_code FROM mfi_branch_member where branch_induk = ?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		return $query->row_array();
	}



}