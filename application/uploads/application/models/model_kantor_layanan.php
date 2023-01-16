<?php

Class Model_kantor_layanan extends CI_Model {

	function get_all_branch()
    {
        $sql = "SELECT 
        				 branch_id
        				,branch_code 
        				,branch_name
        			FROM 
        				 mfi_branch
				WHERE 
						branch_class=0";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

	function get_all_jabatan()
    {
        $sql = "SELECT 
        				 code_value
        				,display_text 
        			FROM 
        				 mfi_list_code_detail
				WHERE 
						code_group='jabatan' ";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

	function get_all_petugas(){
		$sql = "SELECT * from mfi_fa";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

    function get_all_status_cabang()
    {
    	$sql = "SELECT code_value, display_text FROM mfi_list_code_detail WHERE code_group = 'status_cabang'";

    	$query = $this->db->query($sql);
    	return $query->result_array();
    }

	public function get_kecamatan()
	{
		$sql = "SELECT
					 mfi_city_kecamatan.city_kecamatan_id,
					 mfi_city_kecamatan.kecamatan_code,
					 mfi_city_kecamatan.city_code,
					 mfi_city_kecamatan.kecamatan,
					 mfi_province_city.city_code,
					 mfi_province_city.city_abbr,
					 mfi_province_city.city
				FROM
					 mfi_city_kecamatan
				INNER JOIN  mfi_province_city ON  mfi_city_kecamatan.city_code =  mfi_province_city.city_code
				ORDER BY 
					 mfi_city_kecamatan.kecamatan asc
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_all_branch_()
	{
		$param=array();
		$branch_code=$this->session->userdata('branch_code');
	    
	    $sql = "SELECT branch_id,branch_code,branch_name FROM mfi_branch ";
	    
	    if($branch_code!="00000"){
		    $sql.= "WHERE branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
		    $param[]=$branch_code;
		}

	    $sql.="ORDER BY branch_code,branch_name asc";
		
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_city()
	{
		$sql = "select * from mfi_province_city order by city_abbr,city_code asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_province()
	{
		$query = $this->db->get('mfi_province_code');
		return $query->result_array();
	}

	function get_branch_class_login($branch_code='')
	{
	    $sql = "SELECT 
					     branch_class
				    FROM 
					     mfi_branch WHERE branch_code=? ";
    
		    $query = $this->db->query($sql,array($branch_code));
    
		    $data = $query->row_array();
		    return $data['branch_class'];
	}

	function get_lembaga()
	{
		$sql = "SELECT * FROM mfi_institution";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function edit_lembaga($data)
	{
		$this->db->update('mfi_institution',$data);
	}



}