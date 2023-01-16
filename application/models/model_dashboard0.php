<?php

Class Model_dashboard extends CI_Model {

	public function get_anggota($branch_code)
	{
		$sql = "SELECT
				COUNT (*) AS num
				FROM 
				mfi_cif where status=1 ";
		if($branch_code!="00000"){
			$sql.=" and branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
		}
		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
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
				mfi_fa";
		if($branch_code!="00000"){
			$sql.=" WHERE branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
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
				mfi_cm";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_rembug($branch_code)
	{
		$sql = "SELECT
				COUNT (*) AS num
				FROM mfi_cm,mfi_branch
				WHERE mfi_cm.branch_id=mfi_branch.branch_id
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
}