<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_kelompok extends CI_Model {

	
	/****************************************************************************************/	
	// BEGIN ANGGOTA KELUAR
	/****************************************************************************************/
	public function get_all_mfi_city_kecamatan()
	{
		$sql = "SELECT * from mfi_city_kecamatan";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_verifikasi_mutasi_anggota_keluar($sWhere='',$sOrder='',$sLimit='',$branch_id='',$branch_code='',$trx_date='')
	{
		$sql = "SELECT
						mfi_cif_mutasi.cif_mutasi_id,
						mfi_cif_mutasi.description as alasan,
						mfi_cif_mutasi.potongan_pembiayaan,
						mfi_cm.cm_code,
						mfi_cm.cm_name,
						mfi_cif.cif_no,
						mfi_cif.nama,
						mfi_cif_mutasi.tanggal_mutasi,
						mfi_cif_mutasi.created_date,
						mfi_cif_mutasi.created_by
				FROM
						mfi_cif_mutasi
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_cif_mutasi.cif_no
				LEFT JOIN mfi_cm ON mfi_cif.cm_code = mfi_cm.cm_code
				";

		$param = array();
		if ( $sWhere != "" ){
			$sql .= "$sWhere mfi_cif_mutasi.status=0 AND mfi_cif_mutasi.tipe_mutasi=1";

			if($branch_code!=""){
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
			}

			if($trx_date!=""){
				$sql .= " AND mfi_cif_mutasi.tanggal_mutasi = ? ";
				$param[] = $trx_date;
			}
		}else{
			$sql .= "WHERE mfi_cif_mutasi.status=0 AND mfi_cif_mutasi.tipe_mutasi=1";

			if($branch_code!=""){
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
			}

			if($trx_date!=""){
				$sql .= " AND mfi_cif_mutasi.tanggal_mutasi = ? ";
				$param[] = $trx_date;
			}
		}

		if ( $sOrder != "" )
			$sql .= "order by mfi_cif_mutasi.tanggal_mutasi asc ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function update_mutasi_anggota($data,$param)
	{
		$this->db->update('mfi_cif_mutasi',$data,$param);
	}

	public function delete_mutasi_anggota($param)
	{
		$this->db->delete('mfi_cif_mutasi',$param);
	}

	public function get_rembug_by_keyword($keyword='',$branch_code='')
	{
		$param = array();
		// $branch_code = $this->session->userdata('branch_code');
		// $flag_all_branch = $this->session->userdata('flag_all_branch');
		
		$sql = "SELECT mfi_cm.cm_code, mfi_cm.cm_name, mfi_branch.branch_code 
				from mfi_cm, mfi_branch 
				WHERE mfi_branch.branch_id=mfi_cm.branch_id AND (UPPER(cm_name) like ? or UPPER(cm_code) like ?)";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		if ($branch_code!='00000') {
			$sql .= " AND mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}
		
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function search_desa_by_kecamatan($keyword,$kecamatan)
	{
		$sql = "SELECT
							*
				FROM
							mfi_kecamatan_desa
				WHERE (desa_code like ? or desa like ?) ";
		if($kecamatan!=""){
			$sql .= ' and kecamatan_code = ?';
			$query = $this->db->query($sql,array('%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%',$kecamatan));
		}else{

			$query = $this->db->query($sql,array('%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%'));
		}

		// print_r($this->db);

		return $query->result_array();
	}

	public function get_rembug_by_desa_code($desa_code)
	{
		$sql = "SELECT * from mfi_cm WHERE desa_code=? ";
		$query = $this->db->query($sql,array($desa_code));

		return $query->result_array();
	}

	public function get_anggota_rembug_by_cm_code($cm_code)
	{
		$sql = "SELECT * from mfi_cif WHERE cm_code=? AND status!=2 AND status!=3 ";
		$query = $this->db->query($sql,array($cm_code));
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function get_cif_by_cif_no($cif_no)
	{
		$sql = "SELECT * from mfi_cif WHERE cif_no=? AND status!=2 order by kelompok::integer asc ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	function cek_pembiayaan_aktif_individu($cif_no){
		$sql = "SELECT COUNT(*) AS jumlah FROM mfi_account_financing WHERE status_rekening = '1' AND financing_type = '1' AND cif_no = ?";

		$param = array($cif_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	public function get_saldo_by_cif_no($cif_no)
	{
		$sql = "SELECT
		a.cif_no,a.nama
		,(SELECT SUM(saldo_pokok) FROM mfi_account_financing AS maf WHERE maf.cif_no = a.cif_no AND maf.status_rekening = '1') AS saldo_pokok
		,(SELECT SUM(saldo_margin) FROM mfi_account_financing AS maf WHERE maf.cif_no = a.cif_no AND maf.status_rekening = '1') AS saldo_margin
		,(SELECT SUM(saldo_catab) FROM mfi_account_financing AS maf WHERE maf.cif_no = a.cif_no AND maf.status_rekening = '1') AS saldo_catab
		,sum(b.tabungan_wajib) AS tabungan_wajib
		,sum(b.tabungan_kelompok) AS tabungan_kelompok
		,sum(b.tabungan_sukarela) AS tabungan_sukarela
		,sum(b.tabungan_minggon) AS tabungan_minggon
		,sum(b.cadangan_resiko) AS cadangan_resiko
		,sum(b.simpanan_pokok) AS simpanan_pokok 
		,sum(b.setoran_lwk) AS saldo_lwk 
		,sum(b.smk) AS smk
		
		,sum(c.saldo_pembiayaan_pokok) AS saldo_pembiayaan_pokok
		,sum(c.saldo_pembiayaan_margin) AS saldo_pembiayaan_margin
		,sum(c.saldo_pembiayaan_catab) AS saldo_pembiayaan_catab
		,sum(c.saldo_tab_wajib) AS saldo_pembiayaan_tab_wajib
		,sum(c.saldo_tab_kelompok) AS saldo_pembiayaan_tab_kelompok
		,sum(c.potongan_pembiayaan) AS potongan_pembiayaan
		
		,(select sum(amount) from mfi_titipan_bagihasil where status=0 and flag_debit_credit='C' and cif_no=a.cif_no) as bonus_bagihasil_credit
		,(select sum(amount) from mfi_titipan_bagihasil where status=0 and flag_debit_credit='D' and cif_no=a.cif_no) AS bonus_bagihasil_debet
		,(select sum(saldo_memo) from mfi_account_saving where cif_no = a.cif_no and status_rekening='1' AND product_code NOT IN('0009')) as saldo_memo
		,(select sum(saldo_memo) from mfi_account_saving where cif_no = a.cif_no and status_rekening='1' AND product_code ='0009') as saldo_individu
		,(select sum(nominal) from mfi_account_deposit where cif_no = a.cif_no and status_rekening='1') as nominal
---		,(SELECT setoran_lwk FROM mfi_cif_kelompok AS mck, mfi_cif AS mc WHERE mck.cif_id = mc.cif_id AND mc.cif_no = a.cif_no) AS saldo_lwk
		,(SELECT setoran_mingguan FROM mfi_cif_kelompok AS mck, mfi_cif AS mc WHERE mck.cif_id = mc.cif_id AND mc.cif_no = a.cif_no) AS saldo_mingguan
		FROM mfi_cif a
		LEFT JOIN mfi_account_default_balance b ON a.cif_no=b.cif_no
		LEFT JOIN mfi_cif_mutasi c ON a.cif_no=c.cif_no AND tipe_mutasi=1
		WHERE a.cif_no=?
		GROUP BY 1,2 ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function proses_anggota_keluar($data)
	{
		$this->db->insert('mfi_cif_mutasi',$data);
	}

	public function cek_cif_mutasi($cif_no)
	{
		$sql="select count(*) jml from mfi_cif_mutasi where cif_no=? and tipe_mutasi='1'";
		$query=$this->db->query($sql,array($cif_no));
		$row=$query->row_array();
		$jml=$row['jml'];
		if($jml==0){
			return true;
		}else{
			return false;
		}
	}

	public function update_cif_status($data,$param)
	{
		$this->db->update('mfi_cif',$data,$param);
	}

	/****************************************************************************************/	
	// END ANGGOTA KELUAR
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN ANGGOTA PINDAH
	/****************************************************************************************/
	public function proses_anggota_pindah($data)
	{
		$this->db->insert('mfi_cif_mutasi',$data);
	}

	public function update_cif_cm_code($data,$param)
	{
		$this->db->update('mfi_cif',$data,$param);
	}

	public function update_mfi_cif_mutasi($data,$param)
	{
		$this->db->update('mfi_cif_mutasi',$data,$param);
	}

	public function datatable_verifikasi_mutasi_anggota_pindah($sWhere='',$sOrder='',$sLimit='',$branch_id='',$branch_code='',$trx_date='')
	{
		///$sql = "SELECT mcm.cif_mutasi_id, mcf.cif_no, mcf.nama, mc.cm_code,	mc.cm_name, mcm.tanggal_mutasi, mcm.cm_code_baru, 
		////				mfc.cm_name AS rembug_baru, mcm.description AS alasan, mcm.potongan_pembiayaan, mcm.created_date, mcm.created_by,

		$sql = "SELECT mcm.*, mcf.cif_no, mcf.nama, mc.cm_code,	mc.cm_name, mfc.cm_name AS rembug_baru, mcm.description AS alasan 		

		FROM mfi_cif_mutasi AS mcm

		LEFT JOIN mfi_cif AS mcf ON mcf.cif_no = mcm.cif_no
		LEFT JOIN mfi_cm AS mc ON mc.cm_code = mcm.cm_code
		LEFT JOIN mfi_cm AS mfc ON mfc.cm_code = mcm.cm_code_baru ";

		$param = array();

		if ( $sWhere != "" ){
			$sql .= "$sWhere mcm.status_mutasi = '0' AND mcm.tipe_mutasi = '2' ";

			if($branch_code!="00000"){
				$sql .= "AND mcf.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
				$param[] = $branch_code;
			}

			if($trx_date!=""){
				$sql .= "AND mcm.tanggal_mutasi = ? ";
				$param[] = $trx_date;
			}
		}else{
			$sql .= "WHERE mcm.status_mutasi = '0' AND mcm.tipe_mutasi = '2' ";

			if($branch_code!="00000"){
				$sql .= "AND mcf.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
				$param[] = $branch_code;
			}

			if($trx_date!=""){
				$sql .= "AND  mcm.tanggal_mutasi = ? ";
				$param[] = $trx_date;
			}
		}

		if ( $sOrder != "" )
			$sql .= "ORDER BY mcm.tanggal_mutasi asc ";

		if ( $sLimit != "" )
			$sql .= "$sLimit";

		//echo $sql;

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}
	/****************************************************************************************/	
	// END ANGGOTA PINDAH
	/****************************************************************************************/

	function get_product_savingplan($cif_no)
	{
		$sql =" select b.product_name from mfi_account_saving a,mfi_product_saving b
				where a.product_code=b.product_code and a.status_rekening=1 and b.jenis_tabungan=1
				and a.cif_no=?
				";
		$query=$this->db->query($sql,array($cif_no));
		return $query->result_array();
	}

	function get_account_saving_plan($cif_no)
	{
		$sql="select 
				a.*
			  from mfi_account_saving a, mfi_product_saving b
			  where a.product_code=b.product_code and b.jenis_tabungan=1
			  and a.cif_no=? and a.status_rekening=1
		";
		$query=$this->db->query($sql,array($cif_no));
		return $query->result_array();
	}

	function insert_trx_account_saving_batch($data)
	{
		$this->db->insert_batch('mfi_trx_account_saving',$data);
	}

	function insert_trx_detail($data)
	{
		$this->db->insert('mfi_trx_detail',$data);
	}

	function get_trx_saving_for_droping_savingplan($account_saving_no)
	{
		$sql = "select * from mfi_trx_account_saving where account_saving_no=? and trx_saving_type=5";
		$query = $this->db->query($sql,array($account_saving_no));
		return $query->row_array();
	}

	function get_mutasi_by_id($cif_mutasi_id)
	{
		$sql = "select 
					cif_no
					,cm_code
					,tanggal_mutasi
					,saldo_tab_wajib
					,saldo_tab_kelompok
					,bonus_bagihasil 
					,saldo_tab_berencana
					,saldo_individu
					,saldo_simpanan_pokok
					,saldo_smk
					,saldo_lwk
					,saldo_simpanan_wajib
				from mfi_cif_mutasi 
				where cif_mutasi_id=? and tipe_mutasi=1";
		$query = $this->db->query($sql,array($cif_mutasi_id));
		return $query->row_array();
	}

	function get_keterangan_keluar()
	{
		$sql = "SELECT * FROM mfi_list_code_detail WHERE code_group='anggotakeluar' order by code_value ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_unit_by_keyword($keyword='',$branch_code='')
	{
		$param = array();
		// $branch_code = $this->session->userdata('branch_code');
		// $flag_all_branch = $this->session->userdata('flag_all_branch');
		
		$sql = "SELECT 
				branch_code, 
				branch_name 
				FROM mfi_branch 
				WHERE (UPPER(branch_name) like ? or UPPER(branch_code) like ?)
			   ";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		if ($branch_code!='00000') {
			$sql .= " AND mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}
		
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

}