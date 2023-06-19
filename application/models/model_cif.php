<?php

Class Model_cif extends CI_Model {

	public function insert_cif($data)
	{
		$this->db->insert('mfi_cif',$data);		
	}

	public function insert_cif_kelompok($data)
	{
		$this->db->insert('mfi_cif_kelompok',$data);
	}

	public function update_cif($data,$param)
	{
		$this->db->update('mfi_cif',$data,$param);		
	}

	public function update_cif_kelompok($data,$param)
	{
		$this->db->update('mfi_cif_kelompok',$data,$param);
	}

	function get_fa_by_fa_code($fa_code){
		$sql = "SELECT fa_name FROM mfi_fa WHERE fa_code = ?";
		
		$param = array($fa_code);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function get_fa_by_account_cash_code($fa_code){
		$sql = "SELECT mf.fa_name, mgac.account_cash_name
		FROM mfi_fa AS mf

				JOIN mfi_gl_account_cash AS mgac ON mgac.fa_code = mf.fa_code

		WHERE mgac.account_cash_code = ? 

		";
		
		$param = array($fa_code);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function get_majelis($majelis)
	{
		$query = $this->db->query("SELECT * FROM mfi_cm WHERE cm_code = '$majelis'");
		return $query->row_array(); 
	}

	function cek_ktp($ktp){
		$sql = "SELECT
		nama,
		no_ktp,
		COUNT(*) AS total
		FROM mfi_cif
		WHERE no_ktp = ? AND status = '1'
		GROUP BY 1,2";

		$param = array($ktp);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	public function datatable_cif_kelompok($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT mfi_cif.*,mfi_cm.cm_name FROM mfi_cif LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code ";

		if ( $sWhere != "" ){
			$sql .= " $sWhere AND cif_type = 0";
		}else{
			$sql .= " WHERE cif_type = 0";
		}

		// if ( $sOrder != "" )
		if ($sWhere!="") {
			$sql .= " ORDER BY mfi_cif.status,mfi_cif.kelompok::integer ASC ";
		}
			// $sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= " $sLimit ";

		$query = $this->db->query($sql);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	function get_rembug_by_keyword($keyword,$branch_code){
		$param = array();
		$sql = "SELECT
		mcm.cm_code,
		mcm.cm_name,
		mb.branch_code 
		FROM mfi_cm AS mcm, mfi_branch AS mb
		WHERE mb.branch_id = mcm.branch_id
		AND (UPPER(cm_name) LIKE ? OR UPPER(cm_code) LIKE ?)";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		if($branch_code!="00000"){
			$sql .= " AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$sql.=" ORDER BY mcm.cm_code ASC";
		
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_rembug_by_keyword_branch_id($keyword='',$branch_id='')
	{
		$param = array();
		// $branch_code = $this->session->userdata('branch_code');
		// $flag_all_branch = $this->session->userdata('flag_all_branch');
		
		$sql_branch="select branch_code from mfi_branch where branch_id=?";
		$query_branch=$this->db->query($sql_branch,array($branch_id));
		$data_branch=$query_branch->row_array();
		$branch_code=$data_branch['branch_code'];

		$sql = "SELECT mfi_cm.cm_code, mfi_cm.cm_name, mfi_branch.branch_code 
				from mfi_cm, mfi_branch 
				WHERE mfi_branch.branch_id=mfi_cm.branch_id AND (UPPER(cm_name) like ? or UPPER(cm_code) like ?)";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		if($branch_code!="00000"){
			$sql .= " AND mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$sql.=" order by mfi_cm.cm_code asc";
		
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_rembug_by_keyword_danpetugas($keyword='',$branch_id='',$fa_code='')
	{
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		
		$sql = "SELECT mfi_cm.cm_code, mfi_cm.cm_name, mfi_branch.branch_code 
				from mfi_cm, mfi_branch 
				WHERE mfi_branch.branch_id=mfi_cm.branch_id AND (UPPER(cm_name) like ? or UPPER(cm_code) like ?)";

			$param[] = '%'.strtoupper(strtolower($keyword)).'%';
			$param[] = '%'.strtoupper(strtolower($keyword)).'%';

			if ($flag_all_branch==0) {
				$sql .= " AND mfi_branch.branch_code = ? ";
				$param[] = $branch_code;
			}
			if ($fa_code!=0) {
				$sql .= " AND mfi_cm.fa_code = ? ";
				$param[] = $fa_code;
			}
		
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function delete_cif_kelompok($param){

		$cif_no = $this->get_cif_no_by_cif_id($param['cif_id']);
		
		$this->db->delete('mfi_cif_kelompok_log',array('cif_id'=>$param['cif_id']));
		$this->db->delete('mfi_account_default_balance',array('cif_no'=>$cif_no));
		$this->db->delete('mfi_cif_kelompok',$param);
		$this->db->delete('mfi_cif',$param);
	}

	public function get_cif_no_by_cif_id($cif_id)
	{	
		$this->db->select('cif_no');
		$this->db->where('cif_id',$cif_id);
		$sql = $this->db->get('mfi_cif');
		$row = $sql->row_array();

		return $row['cif_no'];
	}

	public function delete_cif_individu($param){
		$this->db->delete('mfi_cif',$param);
	}

	// [BEGIN] BRANCH SETUP REMBUG	

	/********************************************************************************************/

	
	public function datatable_target_cabang($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT a.*, b.display_text as item_target   
		        FROM mfi_target_cabang a 
		        left join mfi_list_code_detail b on a.target_item =b.code_value and b.code_group='targetcabang' ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

<<<<<<< HEAD
	public function add_target_cabang($data)
	{
		$this->db->insert('mfi_target_cabang',$data);
	}

	public function get_data_target_by_target_id($target_id)
	{
		$sql = "SELECT a.*, b.branch_name, c.display_text item_target 
		FROM mfi_target_cabang  a 
		left join mfi_branch b on a.branch_code=b.branch_code 
		left join mfi_list_code_detail c on a.target_item=c.code_value and c.code_group='targetcabang'  
		WHERE a.target_id = ?";
		$query = $this->db->query($sql,array($target_id));

		return $query->row_array();
	}

	public function edit_target_cabang($data,$param)
	{
		$this->db->update('mfi_target_cabang',$data,$param);
	}


	public function datatable_rembug_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT mfi_cm.cm_id,mfi_cm.cm_name,mfi_cm.branch_id,mfi_branch.branch_id,mfi_branch.branch_name, mfi_kecamatan_desa.desa_code,mfi_kecamatan_desa.desa 
				FROM mfi_cm
				LEFT JOIN mfi_kecamatan_desa ON mfi_kecamatan_desa.desa_code = mfi_cm.desa_code
				LEFT JOIN mfi_branch ON mfi_cm.branch_id = mfi_branch.branch_id ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

=======
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
	public function add_rembug($data)
	{
		$this->db->insert('mfi_cm',$data);
	}

	function get_rembug_by_fa_branch($branch){
		$param = array();

		$sql = "SELECT
		cm_code,
		cm_name
		FROM mfi_cm WHERE branch_id = ? ";

		$param[] = $branch;

		$sql .= "ORDER BY cm_name";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function delete_rembug($param)
	{
		$this->db->delete('mfi_cm',$param);
	}

	public function get_user_by_cm_id($cm_id)
	{
		$sql = "SELECT
				mfi_cm.cm_id,
				mfi_cm.cm_name,
				mfi_cm.cm_code,
				mfi_cm.desa_code,
				mfi_kecamatan_desa.desa,
				mfi_cm.fa_code,
				mfi_cm.hari_transaksi,
				mfi_fa.fa_name
				FROM
				mfi_cm
				LEFT JOIN mfi_fa ON mfi_fa.fa_code = mfi_cm.fa_code
				LEFT JOIN mfi_kecamatan_desa ON mfi_kecamatan_desa.desa_code = mfi_cm.desa_code
				WHERE cm_id = ?";
		$query = $this->db->query($sql,array($cm_id));

		return $query->row_array();
	}
<<<<<<< HEAD

	public function edit_rembug($data,$param)
=======
	
	public function edit_rembug($data, $param)
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
	{
		$this->db->update('mfi_cm',$data,$param);
	}

	public function get_all_petugas()
	{
		$sql = "SELECT * from mfi_fa";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_gl_account_by_account_code($account_code)
	{
		$sql = 'select * from mfi_gl_account where account_code = ?';
<<<<<<< HEAD
		$query = $this->db->query($sql,array($account_code));

=======
		$query = $this->db->query($sql, array($account_code));
		
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
		return $query->row_array();
	}
	
	public function get_ajax_branch_code_($branch_id)
	{
		$sql = "select max(right(cm_code,4)) AS jumlah from mfi_cm where branch_id = ?";
		$query = $this->db->query($sql,array($branch_id));

		return $query->row_array();
	}

	
	public function get_ajax_sequenc_fa($branch_code)
	{
		$sql = "select max(right(fa_code,4)) AS max from mfi_fa where left(branch_code,5) = ?";
<<<<<<< HEAD
		$query = $this->db->query($sql,array($branch_code));
=======
		$query = $this->db->query($sql, array($branch_code));
		
		return $query->row_array();
	}
	
	/********************************************************************************************/
	
	/********************************************************************************************/
	
	
	// [BEGIN] BRANCH SETUP TARGET CABANG
	
	/********************************************************************************************/
	
	public function datatable_target_cabang($sWhere = '', $sOrder = '', $sLimit = '')
	{
		$sql = "SELECT 
		mtc.target_id,
		mtc.tahun,
		mtc.target_item,
		mtc.t1,
		mtc.t2,
		mtc.t3,
		mtc.t4,
		mtc.t5,
		mtc.t6,
		mtc.t7,
		mtc.t8,
		mtc.t9,
		mtc.t10,
		mtc.t11,
		mtc.t12
		
		FROM mfi_target_cabang AS mtc ";

	if ($sWhere != "")
	$sql .= "$sWhere ";

	if ($sOrder != "")
	$sql .= "$sOrder ";

	if ($sLimit != "")
	$sql .= "$sLimit ";
	
	$query = $this->db->query($sql);
	
	return $query->result_array();
	}

	public function add_target_cabang($data)
	{
		$this->db->insert('mfi_target_cabang', $data);
	}

	public function get_data_by_target_id($target_id)
	{
		$sql = "SELECT
				mtc.target_id,
				mtc.tahun,
				mtc.item_target,
				mtc.t1,
				mtc.t2,
				mtc.t3,
				mtc.t4,
				mtc.t5,
				mtc.t6,
				mtc.t7,
				mtc.t8,
				mtc.t9,
				mtc.t10,
				mtc.t11,
				mtc.t12
				FROM
				mfi_target_cabang AS mtc 
				WHERE target_id = ?";
		$query = $this->db->query($sql, array($target_id));
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda

		return $query->row_array();
	}

	
	public function delete_target_cabang($param)
	{
		$this->db->delete('mfi_target_cabang', $param);
	}


	public function get_ajax_branch_name_($branch_id)
	{
		$sql = "select AS jumlah from mfi_target_cabang where branch_id = ?";
		$query = $this->db->query($sql, array($branch_id));
	
		return $query->row_array();
	}
	
	/********************************************************************************************/
	
	/********************************************************************************************/
	
	// [BEGIN] BRANCH SETUP KANTOR CABANG
<<<<<<< HEAD

	function datatable_kantor_cabang_setup($sWhere,$sOrder,$sLimit){
=======
	
	function datatable_kantor_cabang_setup($sWhere, $sOrder, $sLimit)
	{
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
		$sql = "SELECT
		mb.branch_id,
		mb.branch_name,
		mb.branch_status,
		mb.branch_code,
		mb.branch_induk,
		mb.branch_class,
		mb.branch_grade,
		mb.tanggal_buka,
		mb.branch_officer_name,
		mb.branch_officer_title,
		mlcd.code_value,
		mlcd.display_text
		FROM mfi_branch AS mb
		JOIN mfi_list_code_detail AS mlcd ON mb.branch_officer_title = mlcd.code_value::INTEGER
		WHERE mlcd.code_group = 'jabatan' ";
<<<<<<< HEAD
		
		if($sWhere != ''){
			$sql .= $sWhere.' ';
=======

if ($sWhere != '') {
	$sql .= $sWhere . ' ';
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
		}

		if($sOrder != ''){
			$sql .= $sOrder.' ';
		}

		if($sLimit != ''){
			$sql .= $sLimit.' ';
		}

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	public function datatable_status_kantor_cabang($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
							mfi_branch.branch_id,
							mfi_branch.branch_name,
							mfi_branch.branch_status,
							mfi_branch.branch_code,
							mfi_branch.branch_status,
							mfi_branch.branch_induk,
							mfi_branch.branch_class,
							mfi_branch.branch_grade,
							mfi_branch.tanggal_buka,
							mfi_branch.branch_officer_name,
							mfi_branch.branch_officer_title,
							mfi_list_code_detail.code_value,
							mfi_list_code_detail.display_text
				FROM
							mfi_branch
				INNER JOIN mfi_list_code_detail ON mfi_branch.branch_status = CAST(mfi_list_code_detail.code_value as integer)
				WHERE mfi_list_code_detail.code_group='status_cabang'
				 ";
		
		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_all_branch_id($branch_id){
		$sql = "SELECT
		branch_id,
		branch_code,
		branch_name
		FROM mfi_branch
		WHERE branch_id = ?";

		$param = array($branch_id);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_all_branch(){
        $sql = "SELECT
        branch_id,
        branch_code,
        branch_name
        FROM mfi_branch WHERE branch_class = '0'";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

	function get_all_branch_by_id($branch_id)
    {
        $sql = "SELECT 
        				 branch_id
        				,branch_code 
        				,branch_name
        			FROM 
        				 mfi_branch
				WHERE 
						branch_class=0 AND branch_id = ?";

		$query = $this->db->query($sql,array($branch_id));

		return $query->result_array();
    }

	function add_kantor_cabang($data){
		$this->db->insert('mfi_branch',$data);
	}

	public function delete_kantor_cabang($param)
	{
		$this->db->delete('mfi_branch',$param);
	}

	public function edit_kantor_cabang($data,$param)
	{
		$this->db->update('mfi_branch',$data,$param);
	}

	public function edit_status_kantor_cabang($data, $param)
	{
		$this->db->update('mfi_branch', $data, $param);
	}

	function get_branch_by_branch_id($branch_id){
		$sql = "SELECT
		mb.branch_id,
		mb.branch_name,
		mb.branch_status,
		mb.branch_code,
		mb.branch_induk,
		(SELECT branch_name FROM mfi_branch WHERE branch_code = mb.branch_induk) AS branch_induk_name,
		mb.branch_class,
		mb.branch_grade,
		mb.tanggal_buka,
		mb.branch_officer_name,
		mb.branch_officer_title,
		mlcd.code_value,
		mlcd.display_text
		FROM mfi_branch AS mb
		LEFT JOIN mfi_list_code_detail AS mlcd ON mb.branch_officer_title = CAST(mlcd.code_value AS INTEGER)
		WHERE mlcd.code_group = 'jabatan' AND mb.branch_id = ?";

		$param = array($branch_id);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	public function get_branch_status_by_branch_id($branch_id)
	{
		$sql = "SELECT
							mfi_branch.branch_id,
							mfi_branch.branch_name,
							mfi_branch.branch_status,
							mfi_branch.branch_code,
							mfi_branch.branch_induk,
							mfi_branch.branch_class,
							mfi_branch.branch_grade,
							mfi_branch.tanggal_buka,
							mfi_branch.branch_officer_name,
							mfi_branch.branch_officer_title,
							mfi_list_code_detail.code_value,
							mfi_list_code_detail.display_text
				FROM
							mfi_branch
				LEFT JOIN mfi_list_code_detail ON mfi_branch.branch_status = CAST(mfi_list_code_detail.code_value as integer) WHERE mfi_list_code_detail.code_group = 'status_cabang' AND mfi_branch.branch_id = ?";

		$query = $this->db->query($sql,array($branch_id));

		return $query->row_array();
	}

	// [END] BRANCH  SETUP KANTOR CABANG

	/********************************************************************************************/

	/********************************************************************************************/

	// [BEGIN] BRANCH SETUP PETUGAS LAPANGAN

	public function datatable_petugas_lapangan($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$sql = "SELECT
				mfi_fa.fa_id,
				mfi_fa.fa_name,
				mfi_fa.fa_code,
				mfi_fa.branch_code,
				mfi_branch.branch_name
				FROM
				mfi_branch
				INNER JOIN mfi_fa ON mfi_branch.branch_code = mfi_fa.branch_code
 			";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($branch_code!='00000'){
				$sql.="AND mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}else{
			if($branch_code!='00000'){
				$sql.="WHERE mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function add_petugas($data)
	{
		$this->db->insert('mfi_fa',$data);
	}

	public function delete_petugas($param)
	{
		$this->db->delete('mfi_fa',$param);
	}

	public function get_petugas_by_id($fa_id)
	{
		$sql = "SELECT fa_id,fa_name,fa_code,branch_code,fa_level FROM mfi_fa WHERE fa_id = ?";
		$query = $this->db->query($sql,array($fa_id));

		return $query->row_array();
	}

	public function get_ajax_branch_code($code)
	{
		$sql = "select max(substr(fa_code,5)) AS jumlah from mfi_fa where left(branch_code,4) = ?";
		$query = $this->db->query($sql,array($code));

		return $query->row_array();
	}

	function get_all_branch_()
	{
<<<<<<< HEAD
	    $sql = "SELECT 
					     branch_id
					    ,branch_code
					    ,branch_name
				    FROM 
					     mfi_branch";
    
		    $query = $this->db->query($sql);
    
		    return $query->result_array();
	}
=======
		$sql = "SELECT 
		branch_id
		,branch_code
		,branch_name
		FROM 
		mfi_branch";
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda

	public function edit_petugas($data,$param)
	{
		$this->db->update('mfi_fa',$data,$param);
	}

	public function search_target_item($branch_code)
	{
		$sql = "select * from mfi_list_code_detail where code_group='targetcabang' ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function search_fa_name($branch_code)
	{
		$sql = "select * from mfi_fa where branch_code = ?";
		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
	}

	function search_cabang_shu($keyword,$tahun){
		$param = array();

		$sql = "SELECT
		branch_code,
		branch_name
		FROM mfi_branch
		WHERE branch_code NOT IN(SELECT branch_code FROM mfi_distribusi_shu WHERE tahun = ?::VARCHAR) AND branch_name LIKE ? ";

		$param[] = $tahun;
		$param[] = '%'.strtoupper($keyword).'%';

		$sql .= " ORDER BY branch_code";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function search_cabang($keyword)
	{
		$sql = "select 
					a.branch_id
					,a.branch_name
					,a.branch_status
					,a.branch_code
					,a.branch_induk
					,a.branch_grade
					,a.tanggal_buka
					,a.branch_officer_name
					,b.display_text branch_officer_title 
				from mfi_branch a, mfi_list_code_detail b 
				where 
					a.branch_officer_title=cast(b.code_value as integer) 
					AND b.code_group='jabatan'
					AND (upper(branch_name) like ? or branch_code like ?)
			";

		$branch_code=$this->session->userdata('branch_code');
		$param[]='%'.strtoupper(strtolower($keyword)).'%';
		$param[]='%'.$keyword.'%';
		
		if($branch_code!="00000"){
			$sql.=" and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[]=$branch_code;
		}
		$sql .= " order by a.branch_code asc";
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function search_city($keyword,$branch){
		$param = array();

		$sql = "SELECT
		mpc.city_code,
		mpc.city
		FROM mfi_branch AS mb
		JOIN mfi_cm AS mcm ON mcm.branch_id = mb.branch_id
		JOIN mfi_kecamatan_desa AS mkd ON mkd.desa_code = mcm.desa_code
		JOIN mfi_city_kecamatan AS mck ON mck.kecamatan_code = mkd.kecamatan_code
		JOIN mfi_province_city AS mpc ON mpc.city_code = mck.city_code
		JOIN mfi_province_code AS mpcd ON mpcd.province_code = mpc.province_code
		WHERE (UPPER(mpc.city) LIKE ? OR UPPER(mpc.city_code) LIKE ?)";

		$param[] = "%".strtoupper($keyword)."%";
		$param[] = "%".strtoupper($keyword)."%";

		if($branch != '00000'){
			$sql .= " AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch;
		}
		
		$sql .= "GROUP BY 1,2 ORDER BY 1,2";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function search_kecamatan($keyword,$branch,$city){
		$param = array();

		$sql = "SELECT
		mck.kecamatan_code,
		mck.kecamatan
		FROM mfi_branch AS mb
		JOIN mfi_cm AS mcm ON mcm.branch_id = mb.branch_id
		JOIN mfi_kecamatan_desa AS mkd ON mkd.desa_code = mcm.desa_code
		JOIN mfi_city_kecamatan AS mck ON mck.kecamatan_code = mkd.kecamatan_code
		JOIN mfi_province_city AS mpc ON mpc.city_code = mck.city_code
		JOIN mfi_province_code AS mpcd ON mpcd.province_code = mpc.province_code
		WHERE (UPPER(mck.kecamatan) LIKE ? OR UPPER(mck.kecamatan_code) LIKE ?)";
		
		$param[] = "%".strtoupper($keyword)."%";
		$param[] = "%".strtoupper($keyword)."%";

		if($branch != '00000'){
			$sql .= " AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch;
		}

		if($city != '00000'){
			$sql .= " AND mpc.city_code = ?";
			$param[] = $city;
		}

		$sql .= " GROUP BY 1,2 ORDER BY 1,2";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function search_desa($keyword,$branch,$city,$kecamatan){
		$param = array();

		$sql = "SELECT
		mkd.desa_code,
		mkd.desa
		FROM mfi_branch AS mb
		JOIN mfi_cm AS mcm ON mcm.branch_id = mb.branch_id
		JOIN mfi_kecamatan_desa AS mkd ON mkd.desa_code = mcm.desa_code
		JOIN mfi_city_kecamatan AS mck ON mck.kecamatan_code = mkd.kecamatan_code
		JOIN mfi_province_city AS mpc ON mpc.city_code = mck.city_code
		JOIN mfi_province_code AS mpcd ON mpcd.province_code = mpc.province_code

		WHERE (UPPER(mkd.desa) LIKE ? OR UPPER(mkd.desa_code) LIKE ?)";

		$param[] = "%".strtoupper($keyword)."%";
		$param[] = "%".strtoupper($keyword)."%";

		if($branch != '00000'){
			$sql .= " AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch;
		}

		if($city != '00000'){
			$sql .= " AND mpc.city_code = ?";
			$param[] = $city;
		}

		if($kecamatan != '00000'){
			$sql .= " AND mck.kecamatan_code = ?";
			$param[] = $kecamatan;
		}

		$sql .= " GROUP BY 1,2 ORDER BY 1,2";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function search_cif_no_active($keyword,$type,$cm_code){
		$param = array();

		$branch_code = $this->session->userdata('branch_code');

		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name
		FROM mfi_cif AS mc
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.status = '1' AND (UPPER(mc.nama) LIKE ? OR mc.cif_no LIKE ?) ";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		
		if($type != ''){
			$sql .= 'AND mc.cif_type = ? ';
			$param[] = $type;
		}

		if($cm_code != '' and $type == '0'){
			$sql .= 'AND mc.cm_code = ? ';
			$param[] = $cm_code;
		}

		if($branch_code != '00000'){
			$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function search_cif_no($keyword,$type,$cm_code){
		$param = array();

		$branch_code = $this->session->userdata('branch_code');

		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name
		FROM mfi_cif AS mc
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE (UPPER(mc.nama) LIKE ? OR mc.cif_no LIKE ?) ";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		
		if($type != ''){
			$sql .= 'AND mc.cif_type = ? ';
			$param[] = $type;
		}

		if($type == '0'){
			$sql .= 'AND mc.cm_code = ? ';
			$param[] = $cm_code;
		}

		if($branch_code != '00000'){
			$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function search_cif_no_tabungan($keyword,$type,$cm_code){
		$param = array();

		$branch_code = $this->session->userdata('branch_code');

		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name
		FROM mfi_cif AS mc
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.status = '1' AND (UPPER(mc.nama) LIKE ? OR mc.cif_no LIKE ?) ";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		
		if($type != ''){
			$sql .= 'AND mc.cif_type = ? ';
			$param[] = $type;
		}

		if($cm_code != '' and $type == '0'){
			$sql .= 'AND mc.cm_code = ? ';
			$param[] = $cm_code;
		}

		if($branch_code != '00000'){
			$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function search_cif_no_individu($keyword){
		$param = array();

		// $branch_code = $this->session->userdata('branch_code');

		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name
		FROM mfi_cif AS mc
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE (UPPER(mc.nama) LIKE ? OR mc.cif_no LIKE ?) AND status = '1' ";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		
		// if($type != ''){
		// 	$sql .= 'AND mc.cif_type = ? '; AND status = '1' 
		// 	$param[] = $type;
		// }

		// if($cm_code != '' and $type == '0'){
		// 	$sql .= 'AND mc.cm_code = ? ';
		// 	$param[] = $cm_code;
		// }

		// if($branch_code != '00000'){
		// 	$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
		// 	$param[] = $branch_code;
		// }

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function search_pemegang_rekening_bycif_no($cif_no)
	{
			$sql = "SELECT
			mfi_cif.nama,
			mfi_account_saving.account_saving_no
			FROM
			mfi_cif
			INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
			where mfi_cif.cif_no = ?";
			$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function search_cif_no2($keyword,$type)
	{
			$sql = "SELECT
			mfi_cif.nama,
			mfi_cm.cm_name,
			mfi_account_saving.account_saving_no
			FROM
			mfi_cif
			INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
			INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
			where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?)";
		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%',$type));
		}else{

			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));
		}

		// print_r($this->db);

		return $query->result_array();
	}

	public function get_cif_kelompok_by_cif_id($cif_id)
	{
		$sql = "select 
		mfi_cif.cif_id,
		mfi_cif.tgl_gabung,
		mfi_cif.cm_code,
		mfi_cif.cif_no,
		mfi_cif.nama,
		mfi_cif.panggilan,
		mfi_cif.kelompok,
		mfi_cif.jenis_kelamin,
		mfi_cif.ibu_kandung,
		mfi_cif.tmp_lahir,
		mfi_cif.tgl_lahir,
		mfi_cif.usia,
		mfi_cif.alamat,
		mfi_cif.rt_rw,
		mfi_cif.desa,
		mfi_cif.kecamatan,
		mfi_cif.kabupaten,
		mfi_cif.kodepos,
		mfi_cif.no_ktp,
		mfi_cif.no_hp,
		mfi_cif.no_npwp,
		mfi_cif.telpon_rumah,
		mfi_cif.telpon_seluler,
		mfi_cif.pendidikan,
		mfi_cif.status_perkawinan,
		mfi_cif.pekerjaan,
		mfi_cif.ket_pekerjaan,
		mfi_cif.pendapatan_perbulan,
		mfi_cif.tgl_gabung,
		mfi_cif.created_by,
		mfi_cif.created_timestamp,
		mfi_cif.branch_code,
		mfi_cif.cif_type,
		mfi_cif.koresponden_alamat,
		mfi_cif.koresponden_rt_rw,
		mfi_cif.koresponden_desa,
		mfi_cif.koresponden_kecamatan,
		mfi_cif.koresponden_kabupaten,
		mfi_cif.koresponden_kodepos,

		mfi_cif_kelompok.cif_kelompok_id,
		mfi_cif_kelompok.setoran_lwk,
		mfi_cif_kelompok.setoran_mingguan,
		mfi_cif_kelompok.pendapatan,
		mfi_cif_kelompok.literasi_latin,
		mfi_cif_kelompok.literasi_arab,
		mfi_cif_kelompok.p_nama,
		mfi_cif_kelompok.p_tmplahir,
		mfi_cif_kelompok.p_tglahir,
		mfi_cif_kelompok.p_usia,
		mfi_cif_kelompok.p_pendidikan,
		mfi_cif_kelompok.p_pekerjaan,
		mfi_cif_kelompok.p_ketpekerjaan,
		mfi_cif_kelompok.p_pendapatan,
		mfi_cif_kelompok.p_periodependapatan,
		mfi_cif_kelompok.p_literasi_latin,
		mfi_cif_kelompok.p_literasi_arab,
		mfi_cif_kelompok.p_jmltanggungan,
		mfi_cif_kelompok.p_jmlkeluarga,
		mfi_cif_kelompok.p_no_ktp,
		mfi_cif_kelompok.p_no_hp,
		mfi_cif_kelompok.rmhstatus,
		mfi_cif_kelompok.rmhukuran,
		mfi_cif_kelompok.rmhatap,
		mfi_cif_kelompok.rmhdinding,
		mfi_cif_kelompok.rmhlantai,
		mfi_cif_kelompok.rmhjamban,
		mfi_cif_kelompok.rmhair,
		mfi_cif_kelompok.lahansawah,
		mfi_cif_kelompok.lahankebun,
		mfi_cif_kelompok.lahanpekarangan,
		mfi_cif_kelompok.ternakkerbau,
		mfi_cif_kelompok.ternakdomba,
		mfi_cif_kelompok.ternakunggas,
		mfi_cif_kelompok.elektape,
		mfi_cif_kelompok.elektv,
		mfi_cif_kelompok.elekplayer,
		mfi_cif_kelompok.elekkulkas,
		mfi_cif_kelompok.kendsepeda,
		mfi_cif_kelompok.kendmotor,
		mfi_cif_kelompok.ushrumahtangga,
		mfi_cif_kelompok.ushkomoditi,
		mfi_cif_kelompok.ushlokasi,
		mfi_cif_kelompok.ushomset,
		mfi_cif_kelompok.byaberas,
		mfi_cif_kelompok.byadapur,
		mfi_cif_kelompok.byalistrik,
		mfi_cif_kelompok.byatelpon,
		mfi_cif_kelompok.byasekolah,
		mfi_cif_kelompok.byalain,
		mfi_cif_kelompok.rekening_listrik,
		mfi_cif_kelompok.rekening_listrik_biaya,
		mfi_cif_kelompok.rekening_pdam,
		mfi_cif_kelompok.rekening_pdam_biaya,
		mfi_cif_kelompok.bpjs,
		mfi_cif_kelompok.bpjs_biaya,
		mfi_cm.cm_name
		from mfi_cif
		left join mfi_cif_kelompok on mfi_cif.cif_id = mfi_cif_kelompok.cif_id 
		left join mfi_cm on mfi_cm.cm_code = mfi_cif.cm_code
		where 
		mfi_cif.cif_id = ?";
		$query = $this->db->query($sql,array($cif_id));
		// print_r($this->db);
		return $query->row_array();
	}
	
	// ###########################################################################

	//kabupaten

	public function add_city($data)
	{
		$this->db->insert('mfi_province_city', $data);
	}

	public function get_city_by_id($city_code)
	{
		$sql = "SELECT * FROM mfi_province_city WHERE city_code = ? ";
		$query = $this->db->query($sql, array($city_code));

		return $query->row_array();
	}

	public function get_province()
	{
		$query = $this->db->get('mfi_province_code');
		return $query->result_array();
	}

	public function edit_city($data, $param)
	{
		$this->db->update('mfi_province_city',$data, $param);
	}

	public function delete_city($param)
	{
		$this->db->delete('mfi_province_city',$param);
	}

	//kecamatan

	public function add_kecamatan($data)
	{
		$this->db->insert('mfi_city_kecamatan', $data);
	}

	public function get_kecamatan_by_id($city_kecamatan_id)
	{
		$sql = "SELECT
				mfi_city_kecamatan.city_kecamatan_id,
				mfi_city_kecamatan.city_code,
				mfi_city_kecamatan.kecamatan_code,
				mfi_city_kecamatan.kecamatan,
				mfi_province_city.city
				FROM
				mfi_city_kecamatan
				INNER JOIN mfi_province_city ON mfi_province_city.city_code = mfi_city_kecamatan.city_code
				WHERE city_kecamatan_id = ? ";
		$query = $this->db->query($sql, array($city_kecamatan_id));

		return $query->row_array();
	}

	public function get_ajax_city_code($city_code)
	{
		$sql = "select max(substr(kecamatan_code,5)) AS jumlah from mfi_city_kecamatan where left(city_code,4) = ?";
		$query = $this->db->query($sql,array($city_code));

		return $query->row_array();
	}

	public function get_city()
	{
		$sql = "select * from mfi_province_city order by city_abbr,city_code asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function edit_kecamatan($data, $param)
	{
		$this->db->update('mfi_city_kecamatan', $data, $param);
	}

	public function delete_kecamatan($param)
	{
		$this->db->delete('mfi_city_kecamatan', $param);
	}

	public function search_city_code($keyword)
	{
		$sql = "select city_code,city from mfi_province_city where UPPER(city) like ? or city_code like ?";
		$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));

		return $query->result_array();
	}

	//desa

	public function add_desa($data)
	{
		$this->db->insert('mfi_kecamatan_desa', $data);
	}

	public function get_desa_by_id($kecamatan_desa_id)
	{
		$sql = "SELECT
				mfi_kecamatan_desa.desa,
				mfi_kecamatan_desa.kecamatan_code,
				mfi_kecamatan_desa.desa_code,
				mfi_kecamatan_desa.kecamatan_desa_id,
				mfi_city_kecamatan.kecamatan
				FROM
				mfi_kecamatan_desa
				INNER JOIN mfi_city_kecamatan ON mfi_city_kecamatan.kecamatan_code = mfi_kecamatan_desa.kecamatan_code
				WHERE kecamatan_desa_id = ? ";
		$query = $this->db->query($sql, array($kecamatan_desa_id));

		return $query->row_array(); 
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

	public function get_bulan()
	{
		$sql = "SELECT
					 mfi_target_cabang.t1,
					 mfi_target_cabang.t2,
					 mfi_target_cabang.t3,
					 mfi_target_cabang.t4,
					 mfi_target_cabang.t5,
					 mfi_target_cabang.t6,
					 mfi_target_cabang.t7,
					 mfi_target_cabang.t8,
					 mfi_target_cabang.t9,
					 mfi_target_cabang.t10,
					 mfi_target_cabang.t11,
					 mfi_target_cabang.t12
				FROM
					 mfi_target_cabangf
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function edit_desa($data, $param)
	{
		$this->db->update('mfi_kecamatan_desa', $data, $param);
	}

	public function delete_desa($param)
	{
		$this->db->delete('mfi_kecamatan_desa', $param);
	}

	public function search_kecamatan_code($keyword,$city)
	{
		$sql = "select kecamatan_code,kecamatan from mfi_city_kecamatan where (upper(kecamatan) like ? or kecamatan_code like ?)";
		if($city!=""){
			$sql .= ' and city_code = ?';
			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%',$city));
		}else{

			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));
		}

		// print_r($this->db);

		return $query->result_array();
	}

	public function get_ajax_kecamatan_code($kecamatan_code)
	{
		$sql = "select max(substr(desa_code,7)) AS jumlah from mfi_kecamatan_desa where kecamatan_code = ?";
		$query = $this->db->query($sql,array($kecamatan_code));

		return $query->row_array();
	}


	// [BEGIN] KABUPATEN

	public function datatable_kabupaten($sWhere='', $sOrder='', $sLimit='')
	{
		$sql = "SELECT * FROM mfi_province_city";

		if($sWhere !="")
			$sql .= "$sWhere";

		if($sOrder !="")
			$sql .= "$sOrder";

		if ($sLimit !="")
			$sql .= "$sLimit";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	/********************************************************************************************/

	// [BEGIN] KECAMATAN

	public function datatable_kecamatan($sWhere='', $sOrder='', $sLimit='')
	{
		$sql = 'SELECT
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
					';

		if($sWhere !="")
			$sql .= "$sWhere";

		if($sOrder !="")
			$sql .= "$sOrder";

		if ($sLimit !="")
			$sql .= "$sLimit";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	/********************************************************************************************/

	// [BEGIN] DESA

	public function datatable_desa($sWhere='', $sOrder='', $sLimit='')
	{
		$sql = 'SELECT
					 mfi_kecamatan_desa.kecamatan_desa_id,
					 mfi_kecamatan_desa.desa_code,
					 mfi_kecamatan_desa.kecamatan_code,
					 mfi_kecamatan_desa.desa,
					 mfi_city_kecamatan.kecamatan_code,
					 mfi_city_kecamatan.kecamatan
				FROM
					 mfi_kecamatan_desa
				INNER JOIN  mfi_city_kecamatan ON  mfi_kecamatan_desa.kecamatan_code =  mfi_city_kecamatan.kecamatan_code
					';

		if($sWhere !="")
			$sql .= "$sWhere";

		if($sOrder !="")
			$sql .= "$sOrder";

		if ($sLimit !="")
			$sql .= "$sLimit";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	/*************************************************************************************************/
	// CIF INDIVIDU
	/*************************************************************************************************/

	public function add_cif_individu($data)
	{
		$this->db->insert('mfi_cif',$data);
	}

	public function datatable_cif_individu($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * from mfi_cif ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere and cif_type = 1";
		}else{
			$sql .= "WHERE cif_type = 1";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}

	public function get_cif_individu($cif_id)
	{
		$sql = "select * from mfi_cif where cif_id = ?";
		$query = $this->db->query($sql,array($cif_id));

		return $query->row_array();
	}

	public function update_cif_individu($data,$param)
	{
		$this->db->update('mfi_cif',$data,$param);
	}
	
	public function get_pendidikan_cif_individu()
	{
		$sql = "select * from mfi_list_code_detail where code_group = 'pendidikan' order by display_sort asc";
		$query = $this->db->query($sql);

		return $query->result_array();
	}


	/********************************************************************************************/
	// [BEGIN] PROGRAM
	/********************************************************************************************/

	public function datatable_program_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_financing_program";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_all_program()
    {
        $sql = "SELECT * FROM mfi_financing_program";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

	public function add_program($data)
	{
		$this->db->insert('mfi_financing_program',$data);
	}

	public function delete_program($param)
	{
		$this->db->delete('mfi_financing_program',$param);
	}

	public function edit_program($data,$param)
	{
		$this->db->update('mfi_financing_program',$data,$param);
	}

	public function get_program_by_financing_program_id($financing_program_id)
	{
		$sql = "select * from mfi_financing_program where financing_program_id = ?";
		$query = $this->db->query($sql,array($financing_program_id));

		return $query->row_array();
	}


	/********************************************************************************************/
	// [END] PROGRAM
	/********************************************************************************************/

	/********************************************************************************************/
	// [BEGIN] SMK
	/********************************************************************************************/

	public function datatable_registrasi_smk_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_trx_smk.trx_smk_id,
				mfi_trx_smk.trx_smk_code,
				mfi_trx_smk.cif_no,
				mfi_trx_smk.trx_type,
				mfi_trx_smk.trx_date,
				mfi_smk.nominal,
				mfi_smk.nama,
				COUNT(mfi_smk.sertifikat_no) AS jml_sertifikat
				FROM
				mfi_trx_smk
				INNER JOIN mfi_smk ON mfi_smk.cif_no = mfi_trx_smk.cif_no
				";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			$sql .= " GROUP BY 1,2,3,4,5,6,7 ";
		}else{
			$sql .= " GROUP BY 1,2,3,4,5,6,7 ";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";


		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_all_registrasi_smk()
    {
        $sql = "SELECT * FROM mfi_smk ";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

    
   	function get_fa_by_branch_code($branch_code)
    {
        $sql = "SELECT 
        					mfi_fa.fa_code
        					,mfi_fa.fa_name
        					,mfi_fa.branch_code
        					,mfi_gl_account_cash.account_cash_name
        					,mfi_gl_account_cash.account_cash_code
				FROM
							mfi_fa
				INNER JOIN mfi_gl_account_cash ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
        		WHERE mfi_fa.branch_code = ? AND account_cash_type='0' ";

		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
    }

	public function add_trx_smk($data1)
	{
		$this->db->insert('mfi_trx_smk',$data1);
	}

	public function add_registrasi_smk($data2)
	{
		$this->db->insert_batch('mfi_smk',$data2);
	}

	public function edit_trx_smk($data1,$param1)
	{
		$this->db->update('mfi_trx_smk',$data1,$param1);
	}

	public function edit_registrasi_smk($data2,$param2)
	{
		$this->db->update('mfi_smk',$data2,$param2);
	}

	public function delete_registrasi_smk($param)
	{
		$this->db->delete('mfi_smk',$param);
	}

	public function delete_registrasi_trx_smk($param)
	{
		$this->db->delete('mfi_trx_smk',$param);
	}

	public function get_smk_by_smk_id($trx_smk_id)
	{
		$sql = "SELECT 
				mfi_smk.*,
				mfi_trx_smk.*
				FROM
				mfi_smk
				INNER JOIN mfi_trx_smk ON mfi_trx_smk.trx_smk_code = mfi_smk.trx_smk_code
				WHERE mfi_trx_smk.trx_smk_id = ?";

		$query = $this->db->query($sql,array($trx_smk_id));

		return $query->row_array();
	}

	public function detail_registrasi_smk($trx_smk_id)
	{
		$sql = "SELECT 
				mfi_smk.nama,
				mfi_smk.sertifikat_no,
				mfi_smk.smk_id,
				mfi_smk.status AS stat,
				mfi_trx_smk.cif_no
				FROM 
				mfi_smk
				INNER JOIN mfi_trx_smk ON mfi_trx_smk.cif_no = mfi_smk.cif_no 
				WHERE mfi_trx_smk.trx_smk_id = ?
				";
		$query = $this->db->query($sql,array($trx_smk_id));

		return $query->result_array();
	}

	public function count_no_sertifikat_by_branch_code($branch_code)
	{
		$sql = "select max(substr(sertifikat_no,5)) AS jumlah from mfi_smk where left(sertifikat_no,4) =  ?";
		$query = $this->db->query($sql,array($branch_code));

		return $query->row_array();
	}

	public function count_code_trx_smk()
	{
		$sql = "select max(substr(trx_smk_code,5)) AS jumlah from mfi_trx_smk";
		$query = $this->db->query($sql);

		return $query->row_array();
	}


	/********************************************************************************************/
	// [END] SMK
	/********************************************************************************************/


	/********************************************************************************************/
	// [BEGIN] PELEPASAN SMK
	/********************************************************************************************/

	public function datatable_pelepasan_smk_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_smk WHERE status=2 ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_all_pelepasan_smk()
    {
        $sql = "SELECT * FROM mfi_smk ";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

	public function add_pelepasan_smk($data,$param)
	{
		$this->db->update('mfi_smk',$data,$param);
	}

	public function delete_pelepasan_smk($param)
	{
		$this->db->delete('mfi_smk',$param);
	}

	public function edit_pelepasan_smk($data,$param)
	{
		$this->db->update('mfi_smk',$data,$param);
	}

	public function get_pelepasan_smk_by_smk_id($smk_id)
	{
		$sql = "select * from mfi_smk where smk_id = ?";
		$query = $this->db->query($sql,array($smk_id));

		return $query->row_array();
	}

	public function count_no_pelepasan_by_branch_code($branch_code)
	{
		$sql = "select max(substr(sertifikat_no,5)) AS jumlah from mfi_smk where left(sertifikat_no,4) =  ?";
		$query = $this->db->query($sql,array($branch_code));

		return $query->row_array();
	}

	public function ajax_get_value_from_sertifikat_no($sertifikat_no)
	{
		$sql = "select * from mfi_smk where sertifikat_no = ?";
		$query = $this->db->query($sql,array($sertifikat_no));

		return $query->row_array();
	}

	// search sertifikat number
	public function search_sertifikat_no($keyword)
	{
		$sql = "SELECT * FROM mfi_smk where status=1 AND (upper(nama) like ? or sertifikat_no like ?)";
		$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));

		return $query->result_array();
	}

	public function get_data_from_sertifikat($smk_id,$status)
	{
		$sql = "select nama, cif_no, sertifikat_no, nominal, smk_id from mfi_smk where smk_id= ? AND status = ?";
		$query = $this->db->query($sql,array($smk_id,$status));

		return $query->result_array();
	}


	/********************************************************************************************/
	// [END] PELEPASAN SMK
	/********************************************************************************************/

	public function get_branch_by_keyword($keyword)
	{
		$branch_code=$this->session->userdata('branch_code');
		$sql = "select branch_id,branch_code,branch_name,branch_class from mfi_branch where (UPPER(branch_name) like ? or UPPER(branch_code) like ?)";
		$param[]='%'.strtoupper(strtolower($keyword)).'%';
		$param[]='%'.strtoupper(strtolower($keyword)).'%';
		if($branch_code!="00000"){
			$sql.=" and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[]=$branch_code;
		}
		$sql.=" order by branch_code asc";
		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// echo $branch_code;
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function get_branch_id_by_branch_code($branch_code){
		$sql = "select branch_id from mfi_branch where branch_code = ?";
		$query = $this->db->query($sql,array($branch_code));
		
		$row = $query->row_array();
		return $row['branch_id'];
	}

<<<<<<< HEAD
	public function get_desa_by_keyword($keyword,$kecamatan)
=======
	public function get_branch_id_by_branch_name($branch_name)
	{
		$sql = "select branch_id from mfi_branch where branch_name = ?";
		$query = $this->db->query($sql, array($branch_name));

		$row = $query->row_array();
		return $row['branch_id'];
	}

	public function get_desa_by_keyword($keyword, $kecamatan)
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
	{
		$sql = "select
				mfi_kecamatan_desa.desa_code,
				mfi_kecamatan_desa.desa 
				from mfi_kecamatan_desa
				";
		if($kecamatan!=""){
			$sql .= "where kecamatan_code = ? and (desa_code like ? or UPPER(desa) like ?)";
			$param[]=$kecamatan;
			$param[]='%'.$keyword.'%';
			$param[]='%'.strtoupper(strtolower($keyword)).'%';
		}else{
			$sql .= "where (desa_code like ? or UPPER(desa) like ?)";
			$param[]='%'.$keyword.'%';
			$param[]='%'.strtoupper(strtolower($keyword)).'%';
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_fa_by_keyword($keyword,$branch_code)
	{
		$sql = "select fa_code,fa_name from mfi_fa where branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) and ( fa_code like ? or upper(fa_name) like ? )";
		$query = $this->db->query($sql,array($branch_code,'%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%'));

		return $query->result_array();
	}

	// search cif number
	function search_cif_for_pelunasan_pembiayaan($keyword,$type,$cm_code){
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
		maf.account_financing_no,
		mc.nama,
		mcm.cm_name,
		mpf.product_name
		FROM mfi_account_financing AS maf
		LEFT JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		where maf.status_rekening !=2 AND (upper(mc.nama) like ? or maf.account_financing_no like ?)
		AND maf.financing_type = '1'";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($type!=""){
			$sql .= ' and mc.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mc.cm_code = ?';
			$param[] = $cm_code;
		}

		if ($flag_all_branch==0) {
			$sql .= " AND mc.branch_code = ? ";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		return $query->result_array();
	}

	// search cif number
	public function search_cif_for_blokir_tabungan($keyword,$type,$cm_code)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_account_saving.account_saving_no,
				mfi_cif.nama,
				mfi_cm.cm_name
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?) and mfi_account_saving.status_rekening=1";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		$param[] = '%'.$keyword.'%';
		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}

		if ($flag_all_branch==0) {
			$sql .= " AND mfi_cif.branch_code = ? ";
			$param[] = $branch_code;
		}

		// print_r($this->db);
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	// search cif number
	public function search_cif_for_buka_tabungan($keyword,$type,$cm_code)
	{

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_account_saving.account_saving_no,
				mfi_cif.nama,
				mfi_cm.cm_name,
				mfi_account_saving_blokir.tipe_mutasi
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_account_saving_blokir ON mfi_account_saving_blokir.account_saving_no = mfi_account_saving.account_saving_no
				where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?) AND mfi_account_saving_blokir.tipe_mutasi=2";
		
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}
		
		if ($flag_all_branch==0) {
			$sql .= " AND mfi_cif.branch_code = ? ";
			$param[] = $branch_code;
		}

		// print_r($this->db);
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	// search cif number
	public function search_cif_for_tutup_tabungan($keyword='',$type='',$cm_code='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$param = array();
		$sql = "SELECT
				mfi_account_saving.account_saving_no,
				mfi_cif.nama,
				mfi_cm.cm_name,
				mfi_account_saving_blokir.tipe_mutasi
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_account_saving_blokir ON mfi_account_saving_blokir.account_saving_no = mfi_account_saving.account_saving_no
				where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?) AND mfi_account_saving_blokir.tipe_mutasi!=1";
		
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}
		
		if ($flag_all_branch==0) {
			$sql .= " AND mfi_cif.branch_code = ? ";
			$param[] = $branch_code;
		}

		// print_r($this->db);
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	// search cif number
	public function search_account_insurance_no($keyword,$type,$cm_code)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "select 
				mfi_account_insurance.account_insurance_no,
				mfi_cif.nama, 
				mfi_cm.cm_name 
				from mfi_cif 
				INNER JOIN mfi_account_insurance ON mfi_account_insurance.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				where (upper(mfi_cif.nama) like ? or mfi_account_insurance.account_insurance_no like ?)";
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}
		
		if ($flag_all_branch==0) {
			$sql .= " AND mfi_cif.branch_code = ? ";
			$param[] = $branch_code;
		}

		// print_r($this->db);

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	/** GET REMBUG DATA OPTION (CM) **************************************************/

	function get_cm_data(){
		$param = array();

		$branch_code = $this->session->userdata('branch_code');

		$sql = "SELECT
		mcm.cm_code,
		mcm.cm_name,
		mb.branch_code
		FROM mfi_cm AS mcm
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id ";

		if($branch_code != '00000'){
			$sql .= " WHERE mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "ORDER BY mcm.cm_name ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	// institution

	public function get_institution()
	{
		$query = $this->db->get('mfi_institution');
		return $query->row_array();
	}


	public function search_cif($keyword)
	{
		$sql = "SELECT
				mfi_account_saving.account_saving_no,
				mfi_cif.nama
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?)";

			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));
		

		// print_r($this->db);

		return $query->result_array();
	}

	public function get_nominal_awal()
	{
		$sql = "SELECT
				mfi_list_code.code_group,
				mfi_list_code.code_description,
				mfi_list_code_detail.code_value,
				mfi_list_code_detail.display_text
				FROM
				mfi_list_code
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group = mfi_list_code.code_group
				where mfi_list_code.code_group='SMK' ORDER BY display_sort ASC";
		$query = $this->db->query($sql);

		$row = $query->row_array();
		$nominal = $row['code_value'];
		return $nominal;
	}

	public function search_no_pembiayaan($keyword,$type,$cm_code,$branch_code)
	{
		$sql = "SELECT 
		maf.account_financing_no,
		maf.status_rekening,
		mc.nama,
		mpf.nick_name
		FROM mfi_account_financing AS maf
		INNER JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		INNER JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		WHERE (upper(mc.nama) like ? or maf.account_financing_no like ?)";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($branch_code != '00000'){
			$sql .= " AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}
		
		if($type!="") {
			$sql 	.= ' AND mc.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' AND mc.cm_code = ?';
			$param[] = $cm_code;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	/* GET CM */
	public function get_cm_by_cm_code($cm_code)
	{
		$sql = "select cm_code,cm_name from mfi_cm where cm_code = ?";
		$query = $this->db->query($sql,array($cm_code));

		return $query->row_array();
	}

	/* GET CIF BY CIF NO */
	public function get_cif_by_cif_no($cif_no)
	{
		$sql = "select
		
				  mfi_cif.cif_id
				  ,mfi_cif.cm_code
				  ,mfi_cif.nama
				  ,mfi_cif.kelompok
				  ,mfi_cif.jenis_kelamin
				  ,mfi_cif.tgl_lahir
				  ,mfi_cif.usia
				  ,mfi_cif.tgl_gabung
				  ,mfi_cif.branch_code
				  ,mfi_cif.cif_type
				  ,mfi_cif.status
				  ,mfi_cif.tanggal_keluar 
				  ,mfi_account_default_balance.tabungan_sukarela
				  ,mfi_account_default_balance.tabungan_wajib
				  ,mfi_account_default_balance.tabungan_kelompok
				
				from mfi_cif , mfi_account_default_balance
				
				where mfi_cif.cif_no=mfi_account_default_balance.cif_no and mfi_cif.cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));
		return $query->row_array();
	}

	public function get_list_code($code_group)
	{
		$sql = "select * from mfi_list_code_detail where code_group = ? and code_value <> '00' order by display_sort asc";
		$query = $this->db->query($sql,array($code_group));

		return $query->result_array();
	}

	public function get_list_code_text($code_group,$code_value)
	{
		$sql = "select * from mfi_list_code_detail where code_group = ? and code_value = ? order by display_sort asc";
		$query = $this->db->query($sql,array($code_group,$code_value));

		return $query->row_array();
	}

	function get_all_data_cif_by_cm_code($cm_code,$status='all')
	{
		$sql="select * from mfi_cif where cm_code=? ";
		$param[]=$cm_code;
		if($status!='all'){
			$sql.=" and status=? ";
			$param[]=$status;
		}
		$sql.=" order by status,kelompok::integer";
		$query=$this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_all_branch_wilayah(){
    	$param = array();

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

        $sql = "SELECT
        branch_id,
        branch_code,
        branch_name
        FROM mfi_branch WHERE branch_class = '1' ";

		if($flag_all_branch != '1'){
			$sql .= "AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "ORDER BY 2";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
    }

	function get_all_branch_cabang(){
    	$param = array();

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

        $sql = "SELECT
        branch_id,
        branch_code,
        branch_name,
        wilayah
        FROM mfi_branch WHERE branch_class = '2' ";

		if($flag_all_branch != '1'){
			$sql .= "AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "ORDER BY 2";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
    }

    function add_branch_member($branch_member){
    	$this->db->insert_batch('mfi_branch_member',$branch_member);
    }
    
    function get_wilayah_code_by_branch_induk($branch_induk){
    	$sql = "SELECT wilayah FROM mfi_branch WHERE branch_code = ?";
    	$param = array($branch_induk);
    	$query = $this->db->query($sql,$param);
    	$row = $query->row_array();

    	if(isset($row['wilayah']) == TRUE){
    		$wilayah = $row['wilayah'];
    	} else {
    		$wilayah = '00000';
    	}

    	return $wilayah;
    }

    function delete_kantor_cabang_member($param)
    {
    	$this->db->delete('mfi_branch_member',$param);
    }   

    function get_branch_code_by_branch_id($branch_id)
    {
    	$sql = "select branch_code from mfi_branch where branch_id=?";
    	$query=$this->db->query($sql,array($branch_id));
    	$row=$query->row_array();
    	if(isset($row['branch_code'])==true){
    		return $row['branch_code'];
    	}else{
    		return '0';
    	}
    } 

	//END TAMBAHAN ADE, BRANCH 5 DIGIT

    function get_branch_code_by_cm($cm_code)
    {
    	$sql = "select mfi_branch.branch_code 
    			from mfi_cm,mfi_branch
    			where mfi_cm.branch_id=mfi_branch.branch_id and mfi_cm.cm_code=?";
    	$query=$this->db->query($sql,array($cm_code));
    	$row= $query->row_array();
    	return $row['branch_code'];
    }


	function get_branchs()
    {
        $param = array();
    	$branch_code = $this->session->userdata('branch_code');
        $sql = "SELECT branch_id ,branch_code ,branch_name
        		FROM mfi_branch ";

        if ($branch_code!="00000") {
        	$sql .= " WHERE branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
        	$param[] = $branch_code;
        }
        $sql .= " ORDER BY branch_code ASC";
		$query = $this->db->query($sql,$param);

		return $query->result_array();
    }

    function get_saldo_for_setoran_pokok()
    {
    	$sql = "
    		select
				a.cif_no,
				a.nama,
				b.tabungan_wajib,
				b.tabungan_kelompok,
				b.smk,
				(case when coalesce(b.simpanan_pokok,0) > 0 then
					1 else 0
				end) flag_setoran
			from mfi_cif a, mfi_account_default_balance b
			where a.cif_no=b.cif_no
			and a.status = 1
    	";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }

    function check_double_proses_setoran_pokok($tanggal)
    {
    	$sql = "
    		select count(*) num from mfi_trx_setoran_pokok where trx_date=?
    	";
    	$query = $this->db->query($sql,array($tanggal));
    	$row = $query->row_array();
    	if ($row['num']>0) {
    		return false;
    	} else {
    		$sql = "
	    		select count(*) num from mfi_trx_smk where trx_date=?
	    	";
	    	$query = $this->db->query($sql,array($tanggal));
	    	$row = $query->row_array();
	    	if ($row['num']>0) {
	    		return false;
	    	} else {
	    		return true;
	    	}
    	}
    }

    function jqgrid_setoran_pokok($sidx='',$sord='',$limit_rows='',$start='',$branch)
	{
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$param = array();

		$sql = "
			SELECT
			a.cif_id id,
			a.cif_no,a.nama,
			COALESCE(b.tabungan_wajib,0) tabungan_wajib,
			COALESCE(b.tabungan_kelompok,0) tabungan_kelompok,
			COALESCE(b.simpanan_pokok,0) simpanan_pokok,
			COALESCE(b.smk,0) smk
			FROM mfi_cif a, mfi_account_default_balance b
			WHERE a.cif_no = b.cif_no AND a.status=1
		";

		if($branch != '00000'){
			$sql .= " AND a.branch_code = ?";
			$param[] = $branch;
		}

		$sql .= " ORDER BY a.cif_no ASC";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function show_account_default_balance($branch){
		$sql = "SELECT
		a.cif_no,
		COALESCE(b.tabungan_wajib) AS tabungan_wajib,
		COALESCE(b.tabungan_kelompok) AS tabungan_kelompok,
		COALESCE(b.simpanan_pokok) AS simpanan_pokok
		FROM mfi_cif AS a
		JOIN mfi_account_default_balance AS b ON (a.cif_no = b.cif_no)
		WHERE a.status = 1";

		$param = array();

		if($branch != '00000'){
			$sql .= " AND a.branch_code = ?";
			$param[] = $branch;
		}

		$sql .= " ORDER BY a.cif_no ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_institution(){
		$sql = "SELECT simpanan_pokok, simpanan_wajib
				FROM mfi_institution";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

	function search_petugas_by_cabang($keyword,$cabang){
		$sql = "SELECT
		mf.fa_code,
		mf.fa_name
		FROM mfi_fa AS mf
		JOIN mfi_branch AS mb ON mb.branch_code = mf.branch_code
		AND (UPPER(fa_name) LIKE ? OR UPPER(fa_code) LIKE ?) ";

		$param = array();

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		$sql .= "ORDER BY mf.fa_code ASC";
		
		$query = $this->db->query($sql,$param);

		return $query->result_array();

	}

	function search_majelis_by_petugas($keyword,$kode,$cabang,$petugas){
		$sql = "SELECT
		mcm.cm_code,
		mcm.cm_name
		FROM mfi_cm AS mcm
		JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		AND (UPPER(mcm.cm_name) LIKE ? OR UPPER(mcm.cm_code) LIKE ?) ";

		$param = array();

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		if($petugas != '00000'){
			$sql .= "AND mcm.fa_code = ? ";
			$param[] = $petugas;
		}

		if($kode != '00000'){
			$sql .= "AND mb.branch_id = ? ";
			$param[] = $cabang;
		}

		$sql .= "ORDER BY mcm.cm_code ASC";
		
		$query = $this->db->query($sql,$param);

		return $query->result_array();

	}

	function search_majelis_by_petugas2($keyword,$kode,$cabang,$petugas){
		$sql = "SELECT
		mcm.cm_code,
		mcm.cm_name,
		mgac.account_cash_code
		FROM mfi_cm AS mcm
		JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_gl_account_cash AS mgac ON mgac.fa_code = mf.fa_code
		AND (UPPER(mcm.cm_name) LIKE ? OR UPPER(mcm.cm_code) LIKE ?) ";

		$param = array();

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		if($petugas != '00000'){
			$sql .= "AND mgac.account_cash_code = ? ";
			$param[] = $petugas;
		}

		if($kode != '00000'){
			$sql .= "AND mb.branch_id = ? ";
			$param[] = $cabang;
		}

		$sql .= "ORDER BY mcm.cm_code ASC";
		
		$query = $this->db->query($sql,$param);

		return $query->result_array();

	}

	function search_saving_by_keyword($keyword,$branch_code,$cm_code,$cif_type){
		$sql = "SELECT
		mas.account_saving_no,
		mc.nama,
		mps.nick_name
		FROM mfi_account_saving AS mas
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		WHERE (UPPER(mc.nama) LIKE ? OR mas.account_saving_no LIKE ?)
		AND mas.status_rekening = '1' AND mps.jenis_tabungan = '1' ";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($branch_code != '00000'){
			$sql .= "AND mc.branch_code = ? ";
			$param[] = $branch_code;
		}

		if($cif_type == '0'){
			$sql .= "AND mc.cif_type = ? ";
			$param[] = $cif_type;

			if($cm_code != ''){
				$sql .= "AND mcm.cm_code = ?";
				$param[] = $cm_code;
			}
		} else {
			$sql .= "AND mc.cif_type = ? ";
			$param[] = $cif_type;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function search_account_no_by_status_verif($keyword,$type,$cm_code)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_account_saving.account_saving_no,
				mfi_cif.nama,
				mfi_cm.cm_name
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?) and mfi_account_saving.status_rekening=1 ";
				//where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?) and mfi_account_saving_schedule.status_verif=1 ";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		$param[] = '%'.$keyword.'%';
		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}

		if ($flag_all_branch==0) {
			$sql .= " AND mfi_cif.branch_code = ? ";
			$param[] = $branch_code;
		}

		// print_r($this->db);
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_periode_active()
	{
		$query = $this->db->query("SELECT periode_awal, periode_akhir FROM mfi_trx_kontrol_periode WHERE status = 1 LIMIT 1");
		return $query->row_array();
	}

	function get_count_cif($periode_awal_2, $periode_akhir_2)
	{
		$query = $this->db->query("SELECT count(*)+1 count FROM mfi_cif WHERE tgl_gabung BETWEEN '$periode_awal_2' AND '$periode_akhir_2'");
		return $query->row_array();
	}

	function jqgrid_count_cek_ktp($no_ktp){
		$sql = "SELECT
		COUNT(*) AS jumlah
		FROM mfi_cif AS mc
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.no_ktp = ?";

		$param = array($no_ktp);

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		if(isset($row['jumlah'])){
			$result = $row['jumlah'];
		} else {
			$result = 0;
		}
		return $result;
	}

	function jqgrid_list_cek_ktp($sidx='',$sord='',$limit_rows='',$start='',$no_ktp){
		$order = '1';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord ";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
		mb.branch_name,
		(CASE WHEN mc.cif_type = '0' THEN
			mcm.cm_name
		 ELSE
		 	'INDIVIDU'
		END) AS cm_name,
		mc.cif_no,
		mc.nama,
		mc.tgl_gabung
		FROM mfi_cif AS mc
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.no_ktp = ? ";

		$param = array($no_ktp);

		$sql .= $order.' '.$limit;

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
}