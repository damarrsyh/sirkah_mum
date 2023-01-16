<?php

class Model_core extends CI_Model {

	/**
	 * fungsi untuk mendapatkan menu id
	 * 
	 * @param menu_url (url)
	 *
	 */
	public function get_menu_id($menu_url)
	{
		$sql = "SELECT menu_id FROM mfi_menu WHERE menu_url = ?";
		$query = $this->db->query($sql,array($menu_url));

		$row = $query->row_array();

		if ( count($row) > 0 )
			return $row['menu_id'];
		else
			return NULL;
	}

	public function get_menu_title($menu_url)
	{
		$sql = "SELECT menu_title FROM mfi_menu WHERE menu_url = ?";
		$query = $this->db->query($sql,array($menu_url));

		$row = $query->row_array();

		if ( count($row) > 0 )
			return $row['menu_title'];
		else
			return NULL;
	}

	/**
	 * fungsi untuk mengambil branch status berdasarkan user
	*/
	public function get_user_status($branch_code, $url_active_one, $url_active_two)
	{
		$sql = "SELECT sr.branch_code,
				br.branch_status,
				nv.role_id,
				mn.menu_id, mn.menu_parent, mn.menu_title, mn.menu_url, mn.menu_flag_link, mn.menu_tipe
				FROM mfi_user AS sr
				JOIN mfi_branch AS br ON (sr.branch_code = br.branch_code)
				JOIN mfi_user_nav AS nv ON (sr.role_id = nv.role_id)
				JOIN mfi_menu AS mn ON (nv.menu_id = mn.menu_id)
				WHERE sr.branch_code = '$branch_code' AND mn.menu_url = '$url_active_two'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_branch_status($branch_code)
	{
		$sql = "SELECT branch_code, branch_status FROM mfi_branch WHERE branch_code = '$branch_code'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	/**
	 * fungsi untuk mengambil menu
	 *
	 * @param role_id, menu_parent
	 *
	 * menu parent di set default 0 (Root Menu),
	 * 0 = Root Menu, > 0 = Sub Menu
	 */
	public function get_menu($role_id,$menu_parent=0)
	{
		$sql = "SELECT mfi_menu.menu_id
		,mfi_menu.menu_parent
		,mfi_menu.menu_title
		,mfi_menu.menu_url
		,mfi_menu.menu_flag_link
		,mfi_menu.menu_icon_parent 
		FROM mfi_menu 
		LEFT JOIN mfi_user_nav ON mfi_user_nav.menu_id = mfi_menu.menu_id
		WHERE mfi_user_nav.role_id = ? AND mfi_menu.menu_parent = ? ORDER BY position ASC";

		$query = $this->db->query($sql,array($role_id,$menu_parent));
		// echo "<pre>";
		// print_r($this->db);
		return $query->result_array();
	}

	public function get_menu_position($menu_parent=0)
	{
		$sql = "SELECT mfi_menu.menu_id
		,mfi_menu.menu_parent
		,mfi_menu.menu_title
		,mfi_menu.menu_url
		,mfi_menu.menu_flag_link
		,mfi_menu.menu_icon_parent 
		FROM mfi_menu 
		WHERE mfi_menu.menu_parent = ? ORDER BY position ASC";

		$query = $this->db->query($sql,array($menu_parent));
		// echo "<pre>";
		// print_r($this->db);
		return $query->result_array();
	}

	public function get_user()
	{
		$sql = "SELECT mfi_user.user_id,mfi_user.username,mfi_user_role.role_name,mfi_user.status FROM mfi_user
				LEFT JOIN mfi_user_role ON mfi_user_role.role_id = mfi_user.role_id
				ORDER BY mfi_user.created_stamp DESC
				";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_role()
	{
		$this->db->order_by('role_name','asc');
		$query = $this->db->get('mfi_user_role');
		return $query->result_array();
	}

	public function add_user($data)
	{
		$this->db->insert('mfi_user',$data);
	}

	public function get_user_by_user_id($user_id)
	{
		$sql = "SELECT 
						*
				FROM 
						mfi_user 
				WHERE 
						user_id = ?";
		$query = $this->db->query($sql,array($user_id));

		return $query->row_array();
	}

	public function edit_user($data,$param)
	{
		$this->db->update('mfi_user',$data,$param);
	}

	public function delete_user($param)
	{
		$this->db->delete('mfi_user',$param);
	}

	public function get_notification($status='')
	{
		$sql = "select * from mfi_notification";
		if($status!=''){
			$sql .= " where status = ?";
		}
		$query = $this->db->query($sql,array($status));

		return $query->result_array();

	}

	public function get_branch()
	{
		$sql = "select branch_id,branch_code,branch_name from mfi_branch where branch_status = '1'";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function edit_profile($data,$param)
	{
		$this->db->update('mfi_user',$data,$param);
	}

	public function get_current_date()
	{
		$sql = "select periode_awal from mfi_trx_kontrol_periode where status='1'";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['periode_awal'];
	}

	// get_user_by_user_keyword

	public function get_user_by_user_keyword($keyword,$branch_code)
	{
		$sql = "select * from mfi_user where username like ? and branch_code = ? order by user_id asc";
		$query = $this->db->query($sql,array('%'.$keyword.'%',$branch_code));

		return $query->result_array();
	}

	// get_trx_kontrol_periode_active

	public function get_trx_kontrol_periode_active()
	{
		$sql = "select periode_id, periode_awal, periode_akhir from mfi_trx_kontrol_periode where status = 1 limit 1";
		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function get_row_list_code_detail($code_group)
	{
		$sql = "select code_value,display_text from mfi_list_code_detail where code_group=?";
		$query = $this->db->query($sql,array($code_group));
		return $query->row_array();
	}

	function get_list_code_detail($code_group)
	{
		$sql = "select code_value,display_text from mfi_list_code_detail where code_group=?";
		$query = $this->db->query($sql,array($code_group));
		return $query->result_array();
	}

	function cek_url_is_allowed($menu_id,$role_id)
	{
		$sql = "select count(*) jml from mfi_user_nav where menu_id = ? and role_id = ?";
		$query = $this->db->query($sql,array($menu_id,$role_id));
		$row = $query->row_array();
		if ($row['jml']>0) {
			return true;
		} else {
			return false;
		}
	}

	function cek_menu_is_exists($url)
	{
		$sql = "select count(*) jml from mfi_menu where upper(replace(menu_url,'/','')) = ?";
		$query = $this->db->query($sql,array($url));
		$row = $query->row_array();
		if ($row['jml']>0) {
			return true;
		} else {
			return false;
		}
	}

	function get_menu_id_by_url($url)
	{
		$sql = "select menu_id from mfi_menu where upper(replace(menu_url,'/','')) = ?";
		$query = $this->db->query($sql,array($url));
		$row = $query->row_array();
		if (isset($row['menu_id'])) {
			return $row['menu_id'];
		} else {
			return false;
		}
	}
}