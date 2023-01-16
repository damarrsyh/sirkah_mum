<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_gl extends CI_Model {

	/* BEGIN SETUP GL ACCOUNT *******************************************************/
	public function get_code_value()
	{
		$sql = "SELECT code_value, code_group, display_text from mfi_list_code_detail where code_group='account_type'";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function search_account_group($code_value)
	{
		$sql = "select group_code,group_name,account_type from mfi_gl_account_group where account_type = ? order by group_code asc";
		// $sql = "select group_code,group_name,account_type from mfi_gl_account_group where account_type = ?";
		$query = $this->db->query($sql,array($code_value));

		return $query->result_array();
	}

	public function proses_input_setup_gl_account($data)
	{
		$this->db->insert('mfi_gl_account',$data);
	}

	public function proses_input_setup_gl_account_budget($data)
	{
		$this->db->insert('mfi_gl_account_budget',$data);
	}

	public function datatable_gl_account_setup($sWhere='',$sOrder='',$sLimit='',$account_type='',$account_group='')
	{
		$sql = "SELECT
				mfi_gl_account.gl_account_id,
				mfi_gl_account.account_code,
				mfi_gl_account.account_type,
				mfi_gl_account.account_name,
				mfi_list_code_detail.display_text
				FROM
				mfi_gl_account
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value  = CAST(mfi_gl_account.account_type AS VARCHAR) 
				 ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere";
			if($account_type!=""){
				$sql .= " AND mfi_gl_account.account_type = '".$account_type."'";
				if($account_group!=""){
					$sql .= " AND mfi_gl_account.account_group_code = '".$account_group."'";
				}
			}
		}
		else{
			if($account_type!=""){
				$sql .= "WHERE mfi_gl_account.account_type = '".$account_type."'";
				if($account_group!=""){
					$sql .= " AND mfi_gl_account.account_group_code = '".$account_group."'";
				}
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";
		else
			$sql .= "ORDER BY mfi_gl_account.account_code asc ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function delete_gl_account($param)
	{
		$this->db->delete('mfi_gl_account',$param);
	}

	public function get_gl_account_by_id($gl_account_id)
	{
		$sql = "SELECT
				mfi_gl_account.gl_account_id,
				mfi_gl_account.account_code,
				mfi_gl_account.account_type,
				mfi_gl_account.account_name,
				mfi_gl_account.account_group_code,
				mfi_gl_account.transaction_flag_default,
				mfi_gl_account.flag_akses,
				mfi_gl_account_group.group_name,
				mfi_list_code_detail.code_value,
				mfi_list_code_detail.code_group,
				mfi_list_code_detail.display_text
				FROM
				mfi_gl_account
				LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value  = CAST(mfi_gl_account.account_type AS VARCHAR) 
				LEFT JOIN mfi_gl_account_group ON mfi_gl_account_group.account_type  = mfi_gl_account.account_type
				WHERE mfi_gl_account.gl_account_id = ?";
				
		$query = $this->db->query($sql,array($gl_account_id));

		return $query->row_array();
	}

	public function proses_edit_setup_gl_account($data,$param)
	{
		$this->db->update('mfi_gl_account',$data,$param);
	}

	public function get_gl_account_budget_by_id($account_code)
	{
		$sql = "SELECT
				* FROM mfi_gl_account_budget
				WHERE account_code = ?";
				
		$query = $this->db->query($sql,array($account_code));

		return $query->result_array();
	}

	public function proses_edit_setup_gl_account_budget($data,$param)
	{
		$this->db->update('mfi_gl_account_budget',$data,$param);
	}

	public function get_data_from_account_group($gl_account_id)
	{
		$sql = "SELECT
				mfi_gl_account.gl_account_id,
				mfi_gl_account.account_code,
				mfi_gl_account.account_name,
				mfi_list_code_detail.display_text
				FROM
				mfi_gl_account
				LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value  = CAST(mfi_gl_account.account_type AS VARCHAR) 
				WHERE mfi_list_code_detail.code_group = 'account_type'
				AND mfi_gl_account.gl_account_id = ? ";
		$query = $this->db->query($sql,array($gl_account_id));

		return $query->result_array();
	}

	/* END SETUP GL ACCOUNT *******************************************************/
	/****************************************************************************************/	
	// BEGIN ACCOUNT GROUP SETUP
	/****************************************************************************************/
	public function datatable_account_group_setup($sWhere='',$sOrder='',$sLimit='',$group_type='')
	{
		$sql = "SELECT
						mfi_gl_account_group.account_type,
						mfi_gl_account_group.group_name,
						mfi_gl_account_group.group_code,
						mfi_list_code_detail.display_text,
						mfi_list_code_detail.code_group,
						mfi_gl_account_group.gl_account_group_id
				FROM
						mfi_gl_account_group
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value  = CAST(mfi_gl_account_group.account_type AS VARCHAR)
				 ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($group_type!=""){
				$sql .= " AND mfi_gl_account_group.account_type = '".$group_type."'";
			}
		}else{
			if($group_type!=""){
				$sql .= "WHERE mfi_gl_account_group.account_type = '".$group_type."'";
			}
		}

		if ( $sOrder != "" ){
			$sql .= "$sOrder ";
		}else{
			$sql .= "ORDER BY mfi_gl_account_group.group_code ASC";
		}

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_group_type()
	{
		$sql = "SELECT
						mfi_list_code_detail.code_group,
						mfi_list_code_detail.code_value,
						mfi_list_code_detail.display_text
				FROM
						mfi_list_code_detail
				where mfi_list_code_detail.code_group = 'account_type' ";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function add_account_group($data)
	{
		$this->db->insert('mfi_gl_account_group',$data);
	}

	public function delete_account_group($param)
	{
		$this->db->delete('mfi_gl_account_group',$param);
	}

	public function get_account_group_by_id($gl_account_group_id)
	{
		$sql = "SELECT
						mfi_gl_account_group.account_type,
						mfi_gl_account_group.group_name,
						mfi_gl_account_group.group_code,
						mfi_list_code_detail.display_text,
						mfi_list_code_detail.code_group,
						mfi_gl_account_group.gl_account_group_id
				FROM
						mfi_gl_account_group
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value  = CAST(mfi_gl_account_group.account_type AS VARCHAR) 
				WHERE 	mfi_list_code_detail.code_group = 'account_type' 
				AND 	mfi_gl_account_group.gl_account_group_id = ?
				";

		$query = $this->db->query($sql,array($gl_account_group_id));
		return $query->row_array();
	}

	public function edit_account_group($data,$param)
	{
		$this->db->update('mfi_gl_account_group',$data,$param);
	}
	
	public function check_group_code($group_code)
	{
		$sql = "select count(*) as num from mfi_gl_account_group where group_code = ?";
		$query = $this->db->query($sql,array($group_code));

		$row = $query->row_array();
		if($row['num']>0){
			return false;
		}else{
			return true;
		}
	}
	/****************************************************************************************/	
	// END ACCOUNT GROUP SETUP
	/****************************************************************************************/

	/****************************************************************************************/	
	// END SETUP KAS PETUGAS
	/****************************************************************************************/

	public function datatable_setup_kas_petugas($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		$sql = "SELECT
				mfi_gl_account_cash.fa_code,
				mfi_gl_account_cash.account_cash_code,
				mfi_gl_account_cash.account_cash_name,
				mfi_fa.fa_name,
				mfi_user.fullname,
				mfi_gl_account_cash.account_cash_id
				FROM
				mfi_gl_account_cash
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
				LEFT JOIN mfi_user ON mfi_user.user_id = mfi_gl_account_cash.user_id
				 ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($flag_all_branch==0){
				$sql.="AND mfi_fa.branch_code='".$branch_code."'";
			}
		}else{
			if($flag_all_branch==0){
				$sql.="WHERE mfi_fa.branch_code='".$branch_code."'";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function datatable_setup_rak($sWhere='',$sOrder='',$sLimit=''){
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		$sql = "SELECT
		mr.rak_id,
		mb.branch_name,
		mgar.account_name AS rak_account_code,
		mgab.account_name AS bank_account_code,
		mgaa.account_name AS biaya_account_code,
		mgap.account_name AS pendapatan_account_code
		FROM mfi_rak AS mr
		JOIN mfi_branch AS mb ON mb.branch_code = mr.branch_code
		JOIN mfi_gl_account AS mgar ON mgar.account_code = mr.rak_account_code
		JOIN mfi_gl_account AS mgab ON mgab.account_code = mr.bank_account_code
		JOIN mfi_gl_account AS mgaa ON mgaa.account_code = mr.biaya_account_code
		JOIN mfi_gl_account AS mgap ON mgap.account_code = mr.pendapatan_account_code ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($flag_all_branch==0){
				$sql.="AND mb.branch_code='".$branch_code."'";
			}
		}else{
			if($flag_all_branch==0){
				$sql.="WHERE mb.branch_code='".$branch_code."'";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function datatable_setup_recuring($sWhere='',$sOrder='',$sLimit=''){
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		$sql = "SELECT
		mjt.template_id,
		mjt.template_name,
		mjt.template_code,
		mgar.account_name AS debet_account,
		mgab.account_name AS credit_account
		FROM mfi_jurnal_template AS mjt
		JOIN mfi_gl_account AS mgar ON mgar.account_code = mjt.debet_account
		JOIN mfi_gl_account AS mgab ON mgab.account_code = mjt.credit_account ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_fa_name()
	{
		$sql = "SELECT fa_code, fa_name FROM mfi_fa";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_account_name()
	{
		$sql = "SELECT account_code, account_name FROM mfi_gl_account";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_ajax_count_cash_name($fa_code)
	{
		$sql = "select max(right(account_cash_code,2)) AS jumlah from mfi_gl_account_cash where fa_code = ?";
		$query = $this->db->query($sql,array($fa_code));

		return $query->row_array();
	}

	public function get_fa_code_from_mfi_fa($fa_code){
		$sql = "select fa_id,fa_code, fa_name from mfi_fa where fa_code = ?";
		$query = $this->db->query($sql,array($fa_code));
		
		$row = $query->row_array();
		return $row['fa_id'];
	}

	public function get_fa_name_from_mfi_fa($fa_code){
		$sql = "select fa_name from mfi_fa where fa_code = ?";
		$query = $this->db->query($sql,array($fa_code));
		
		$row = $query->row_array();
		return $row['fa_name'];
	}

	public function get_ajax_account_name($account_code){
		$sql = "select account_name from mfi_gl_account where account_code = ?";
		$query = $this->db->query($sql,array($account_code));
		
		$row = $query->row_array();
		return $row['account_name'];
	}

	public function proses_input_setup_kas_petugas($data)
	{
		$this->db->insert('mfi_gl_account_cash',$data);
	}

	function proses_input_setup_rak($data){
		$this->db->insert('mfi_rak',$data);
	}

	function proses_input_setup_recuring($data){
		$this->db->insert('mfi_jurnal_template',$data);
	}

	public function delete_gl_account_cash($param)
	{
		$this->db->delete('mfi_gl_account_cash',$param);
	}

	function delete_gl_rak($param){
		$this->db->delete('mfi_rak',$param);
	}

	function delete_gl_recuring($param){
		$this->db->delete('mfi_jurnal_template',$param);
	}

	public function get_gl_account_cash_by_id($account_cash_id)
	{
		$sql = "SELECT
				mfi_user.fullname,
				mfi_gl_account_cash.user_id,
				mfi_gl_account_cash.account_cash_code,
				mfi_gl_account_cash.fa_code,
				mfi_gl_account_cash.account_cash_id,
				mfi_gl_account_cash.account_cash_name,
				mfi_gl_account_cash.gl_account_code,
				mfi_gl_account_cash.account_cash_type,
				mfi_gl_account.account_name,
				mfi_fa.fa_name,
				mfi_fa.branch_code
				FROM
				mfi_gl_account_cash
				INNER JOIN mfi_gl_account ON mfi_gl_account.account_code = mfi_gl_account_cash.gl_account_code
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
				LEFT JOIN mfi_user ON mfi_user.user_id = mfi_gl_account_cash.user_id
				WHERE mfi_gl_account_cash.account_cash_id = ?";
				
		$query = $this->db->query($sql,array($account_cash_id));

		return $query->row_array();
	}

	function get_gl_rak_by_id($rak_id){
		$sql = "SELECT
		rak_id,
		branch_code,
		rak_account_code,
		bank_account_code,
		biaya_account_code,
		pendapatan_account_code
		FROM mfi_rak AS mr
		WHERE rak_id = ?";
				
		$query = $this->db->query($sql,array($rak_id));

		return $query->row_array();
	}

	function get_gl_recuring_by_id($template_id){
		$sql = "SELECT
		template_id,
		template_name,
		template_code,
		debet_account,
		credit_account
		FROM mfi_jurnal_template
		WHERE template_id = ?";
				
		$query = $this->db->query($sql,array($template_id));

		return $query->row_array();
	}

	public function proses_edit_setup_kas_petugas($data,$param)
	{
		$this->db->update('mfi_gl_account_cash',$data,$param);
	}

	function proses_edit_setup_rak($data,$param){
		$this->db->update('mfi_rak',$data,$param);
	}

	function proses_edit_setup_recuring($data,$param){
		$this->db->update('mfi_jurnal_template',$data,$param);
	}

	function get_all_branch()
    {
        $sql = "SELECT * FROM  mfi_branch ORDER BY branch_code";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

   	function get_fa_by_branch_code($branch_code)
    {
        $sql = "SELECT * FROM  mfi_fa WHERE branch_code = ? ";

		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
    }

	/****************************************************************************************/	
	// END SETUP KAS PETUGAS
	/****************************************************************************************/

	public function get_gl_account_by_keyword($keyword)
	{
		$sql = "select * from mfi_gl_account where UPPER(account_code) like ? or UPPER(account_name) like ?";
		$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.strtoupper(strtolower($keyword)).'%'));

		return $query->result_array();
	}

	public function datatable_report_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_gl_report ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}

	public function add_report_setup($data)
	{
		$this->db->insert('mfi_gl_report',$data);
	}

	public function delete_report_setup($param)
	{
		$this->db->delete('mfi_gl_report',$param);
	}

	public function get_row_report_setup($gl_report_id)
	{
		$sql = "select * from mfi_gl_report where gl_report_id = ?";
		$query = $this->db->query($sql,array($gl_report_id));

		return $query->row_array();
	}

	public function update_report_setup($data,$param)
	{
		$this->db->update('mfi_gl_report',$data,$param);
	}

	/* REPORT ITEM */

	public function datatable_report_item_setup($report_code='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_gl_report_item WHERE report_code = ?";
		$sql .= " ORDER BY item_code ASC ";

		if ( $sLimit != "" )
			$sql .= " $sLimit ";

		$query = $this->db->query($sql,array($report_code));
		// print_r($this->db);
		return $query->result_array();
	}

	// add item
	public function add_report_item_setup($data)
	{
		$this->db->insert('mfi_gl_report_item',$data);
	}

	// delete item
	public function delete_report_item_setup($param)
	{
		$this->db->delete('mfi_gl_report_item',$param);
	}

	// get ajax
	public function get_row_report_item_setup($gl_report_item_id)
	{
		$sql = "select * from mfi_gl_report_item where gl_report_item_id = ?";
		$query = $this->db->query($sql,array($gl_report_item_id));

		return $query->row_array();
	}

	// update item
	public function update_report_item_setup($data,$param)
	{
		$this->db->update('mfi_gl_report_item',$data,$param);
	}

	/* report item member */

	// datatable
	public function datatable_report_item_member_setup($gl_report_item_id='',$sOrder='',$sLimit='',$sWHERE='')
	{
		$sql = "
		select 
		mfi_gl_account.account_code,
		mfi_gl_account.account_name,
		(select count(*) from mfi_gl_report_item_member where mfi_gl_report_item_member.account_code = mfi_gl_account.account_code and mfi_gl_report_item_member.gl_report_item_id = ?) as count
		from mfi_gl_account 
		";

		if ( $sWHERE != "0" ){
			$sql .= "WHERE account_type = $sWHERE ";
		}else{
			$sql .= "WHERE account_type IN(1,2,3,4,5) ";
		}

		if ( $sOrder != "" ){ 
			$sql .= "$sOrder ";
		}else{
			$sql .=" ORDER BY account_code ";
		}
		if ( $sLimit != "" ){
			$sql .= "$sLimit ";
		}

		$query = $this->db->query($sql,array($gl_report_item_id));
		// print_r($this->db);
		return $query->result_array();
	}
	
	// delete report item member
	public function delete_report_item_member($param)
	{
		$this->db->delete('mfi_gl_report_item_member',$param);
	}

	// insert report item member
	public function insert_report_item_member($data)
	{
		$this->db->insert_batch('mfi_gl_report_item_member',$data);
	}

	public function get_list_code_account_type(){
		$sql="select * from mfi_list_code_detail where code_group = 'account_type' order by code_group";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function check_account_transaction_is_exists($account_code)
	{
		$sql="select count(*) num from mfi_trx_gl_detail where account_code=?";
		$query=$this->db->query($sql,array($account_code));
		$row=$query->row_array();
		if($row['num']==0){
			return false;
		}else{
			return true;
		}
	}

}