<?php

class Model_login extends CI_Model {

	public function authentication($username,$password,$salt)
	{
		$password = sha1($password.$salt);
		$sql = "SELECT 
							mfi_user.user_id
							,mfi_user.username
							,mfi_user.role_id
							,mfi_user.fullname
							,mfi_user.photo
							,mfi_user.branch_code 
							,mfi_branch.branch_id 
							,mfi_branch.branch_code 
							,mfi_branch.branch_name 
							,mfi_branch.branch_class 
							,mfi_user.themes
							,mfi_user.flag_all_branch

							,mfi_institution.institution_name
							,mfi_institution.officer_name
							,mfi_institution.officer_title
							,mfi_institution.day_transaction
							,mfi_institution.max_plafon
							,mfi_institution.grace_period_kelompok
							,mfi_institution.grace_period_individu
							,mfi_institution.setoran_lwk
							,mfi_institution.minggon
							,mfi_institution.simpanan_wajib
							,mfi_institution.cif_type
				from 
							mfi_user
				left join 	mfi_branch on mfi_branch.branch_code = mfi_user.branch_code ,
							mfi_institution
				WHERE 
						mfi_user.username = ? 
						AND mfi_user.password = ? 
						AND mfi_user.status = '1'";
		$query = $this->db->query($sql,array($username,$password));

		return $query->row_array();
	}

	public function get_access($username)
	{
		$sql = "SELECT rl.day_access, rl.time_access_start, rl.time_access_end, us.username FROM mfi_user_role AS rl JOIN mfi_user AS us ON(rl.role_id = us.role_id)
				WHERE us.username = '$username'";
		$query = $this->db->query($sql);
		
		return $query->row_array();
	}


}