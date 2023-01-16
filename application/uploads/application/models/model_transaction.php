<?php

Class Model_transaction extends CI_Model 
{
	/* BEGIN REGISTRASI REKENING TABUNGAN *******************************************************/
	public function get_all_product_tabungan()
	{
		$sql = "SELECT product_code, product_name, jenis_tabungan from mfi_product_saving ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_rekening_tabungan_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
							 mfi_account_saving.account_saving_id				
							,mfi_account_saving.product_code
							,mfi_account_saving.account_saving_no
							,mfi_cif.nama
							,mfi_cif.cif_no
							,mfi_cm.cm_name
							,mfi_product_saving.product_name
				FROM
							mfi_cif
				INNER JOIN 
							mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no 
				INNER JOIN 
							mfi_product_saving ON mfi_product_saving.product_code = mfi_account_saving.product_code
				LEFT JOIN
							mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";

			if ($flag_all_branch==0) {
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) AND mfi_account_saving.status_rekening=0 ";
				$param[] = $branch_code;
			} else {
				$sql .= " WHERE mfi_account_saving.status_rekening=0 ";
			}

		}else{

			if ($flag_all_branch==0) {
				$sql .= " WHERE mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) AND mfi_account_saving.status_rekening=0 ";
				$param[] = $branch_code;
			} else {
				$sql .= " WHERE mfi_account_saving.status_rekening=0 ";
			}

		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}



	public function ajax_get_value_from_cif_no1($cif_no)
	{
		$sql = "SELECT
				mfi_cif.branch_code,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.cif_no,
				mfi_cif.cm_code,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_cif.cif_type,
				mfi_cif.telpon_seluler,
				mfi_cm.cm_name as majlis,
				mfi_account_default_balance.tabungan_wajib,
				mfi_account_default_balance.tabungan_sukarela,
				mfi_account_default_balance.tabungan_kelompok
				FROM mfi_cif , mfi_cm, mfi_account_default_balance
        		where mfi_cif.cif_no = ? AND mfi_cif.cm_code=mfi_cm.cm_code
        		AND mfi_cif.cif_no = mfi_account_default_balance.cif_no";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	function ajax_get_value_from_cif_no_saleh($cif_no){
		$sql = "SELECT
		mc.branch_code,
		mc.nama,
		mc.cif_no,
		mc.cm_code,
		SUM(mtsp.total_setoran) AS total_setoran
		FROM mfi_cif AS mc
		LEFT JOIN mfi_cm AS mcm ON (mc.cm_code = mcm.cm_code)
		LEFT JOIN mfi_trx_setoran_pokok AS mtsp ON (mtsp.cif_no = mc.cif_no)
		WHERE mc.cif_no = ?
		GROUP BY 1,2,3,4";

		$param = array($cif_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function ajax_get_tabungan($cif_no){
		$sql = "SELECT
		madb.tabungan_wajib,
		madb.tabungan_sukarela,
		madb.tabungan_kelompok
		FROM mfi_cif AS mc
		LEFT JOIN mfi_cm AS mcm ON (mc.cm_code = mcm.cm_code)
		LEFT JOIN mfi_account_default_balance AS madb ON (madb.cif_no = mc.cif_no)
		WHERE mc.cif_no = ?";

		$param = array($cif_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	public function ajax_get_tabungan_by_cif_type($cif_type)
	{
		$sql = "SELECT * FROM mfi_product_saving";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function ajax_get_value_from_cif_no($cif_no) //ini kode yang dulu. trus sekarang diganti ke yang atas. karna yang iini ada relasi ke mfi_account_saving 
	{
		$sql = "SELECT
				mfi_cif.branch_code,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.cif_no,
				mfi_cif.cm_code,
				mfi_account_saving.account_saving_no,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler
				FROM
				mfi_cif
				INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
        		where mfi_cif.cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function ajax_get_value_from_cif_no2($cif_no)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_saving.account_saving_no
				FROM
				mfi_cif
				INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
				where mfi_account_saving.account_saving_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}
	
	public function count_cif_by_product_code($product_code)
	{
		$sql = "SELECT max(substr(account_saving_no,19)) AS jumlah from mfi_account_saving where product_code = ?";
		$query = $this->db->query($sql,array($product_code));

		return $query->row_array();
	}
	
	public function add_rekening_tabungan($data)
	{
		$this->db->insert('mfi_account_saving',$data);
	}
	
	public function delete_rekening_tabungan($param)
	{
		$this->db->delete('mfi_account_saving',$param);
	}
	
	public function get_account_saving_by_account_saving_id($account_saving_id)
	{
		$sql = "SELECT
					mfi_account_saving.account_saving_id,
					mfi_account_saving.cif_no,
					mfi_account_saving.rencana_setoran_next,
					mfi_account_saving.biaya_administrasi,
					mfi_cif.nama,
					mfi_cif.panggilan,
					mfi_cif.ibu_kandung,
					mfi_cif.tmp_lahir,
					mfi_cif.tgl_lahir,
					mfi_cif.alamat,
					mfi_cif.rt_rw,
					mfi_cif.desa,
					mfi_cif.kecamatan,
					mfi_cif.kabupaten,
					mfi_cif.kodepos,
					mfi_cif.telpon_rumah,
					mfi_cif.telpon_seluler,
					mfi_cif.cif_type,
					mfi_account_saving.product_code,
					mfi_account_saving.branch_code,
					mfi_account_saving.account_saving_no,
					mfi_account_saving.rencana_jangka_waktu,
					mfi_account_saving.rencana_setoran,
					mfi_account_saving.rencana_periode_setoran,
					mfi_account_saving.tanggal_buka,
					mfi_product_saving.jenis_tabungan,
					mfi_product_saving.product_name,
					mfi_product_saving.product_code,
					mfi_cm.cm_name as majlis
				FROM
					mfi_account_saving
				INNER JOIN 
					mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				INNER JOIN
					mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN 
					mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
				WHERE 
					account_saving_id = ? ";
		$query = $this->db->query($sql,array($account_saving_id));

		return $query->row_array();
	}
	
	public function edit_rekening_tabungan($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}
	/* END REGISTRASI REKENING TABUNGAN *******************************************************/

	public function datatable_deposito_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.account_deposit_id,
				mfi_cif.nama,
				mfi_cm.cm_name,
				mfi_account_deposit.cif_no
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
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

	public function get_cfi_by_cif_no($cif_no)
	{
		$sql = "SELECT
			mfi_cif.cif_no,
			mfi_cif.nama,
			mfi_cif.panggilan,
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
			mfi_cif.telpon_rumah,
			mfi_cif.telpon_seluler,
			mfi_cif.branch_code,
			mfi_account_saving.account_saving_no
			FROM
			mfi_cif
			LEFT JOIN mfi_account_saving ON mfi_cif.cif_no = mfi_account_saving.cif_no
			WHERE mfi_cif.cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}
	
	
	public function add_deposito($data)
	{
		$this->db->insert('mfi_account_deposit',$data);
	}

	
	public function get_all_product()
	{
		$sql = "SELECT product_code, product_name from mfi_product_deposit ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	public function delete_deposit($param)
	{
		$this->db->delete('mfi_account_deposit',$param);
	}
	
	public function get_deposit_by_id($account_deposit_id)
	{
		$sql = "SELECT
			mfi_account_deposit.account_deposit_id,
			mfi_cif.cif_no,
			mfi_cif.nama,
			mfi_cif.panggilan,
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
			mfi_cif.telpon_rumah,
			mfi_cif.telpon_seluler,
			mfi_account_deposit.jangka_waktu,
			mfi_account_deposit.tanggal_buka,
			mfi_account_deposit.tanggal_jtempo_last,
			mfi_account_deposit.tanggal_jtempo_next,
			mfi_account_deposit.automatic_roll_over,
			mfi_account_deposit.nisbah_bagihasil,
			mfi_account_deposit.nominal,
			mfi_account_deposit.account_deposit_no,
			mfi_account_deposit.account_saving_no,
			-- mfi_account_saving.saldo_memo,
			mfi_account_deposit.product_code
			FROM
			mfi_account_deposit
			INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
			-- INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
			WHERE mfi_account_deposit.account_deposit_id = ?";
		$query = $this->db->query($sql,array($account_deposit_id));

		return $query->row_array();
	}

	public function edit_deposit($data,$param)
	{
		$this->db->update('mfi_account_deposit',$data,$param);
	}
	
	public function cif_count_product_code($product_code)
	{
		$sql = "select max(substr(account_deposit_no,19)) AS jumlah from mfi_account_deposit where product_code = ?";
		$query = $this->db->query($sql,array($product_code));

		return $query->row_array();
	}

	/* BEGIN REGISTRASI REKENING PEMBIAYAAN *******************************************************/	
	public function get_product_financing()
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.jenis_pembiayaan,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi
				FROM
				mfi_product_financing
				";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_setor_tunai_tabungan($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				a.trx_date,
				a.amount,
				a.account_saving_no,
				a.trx_account_saving_id,
				c.cif_no,
				c.nama,
				d.trx_detail_id
				FROM 
				mfi_trx_account_saving a,
				mfi_account_saving b,
				mfi_cif c,
				mfi_trx_detail d
				WHERE a.account_saving_no = b.account_saving_no 
				AND b.cif_no = c.cif_no 
				AND d.trx_detail_id = a.trx_detail_id 
				AND a.trx_saving_type = 1 
				AND b.status_rekening = 1 
				AND d.trx_type = 1
				AND a.flag_debit_credit = 'C'
				AND a.trx_status = 0
				AND a.created_by = ?
		       ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,array($this->session->userdata('user_id')));

		return $query->result_array();
	}

	public function datatable_penarikan_tunai_tabungan($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				a.trx_date,
				a.amount,
				a.account_saving_no,
				a.trx_account_saving_id,
				c.cif_no,
				c.nama,
				d.trx_detail_id
				FROM 
				mfi_trx_account_saving a,
				mfi_account_saving b,
				mfi_cif c,
				mfi_trx_detail d
				WHERE a.account_saving_no = b.account_saving_no 
				AND b.cif_no = c.cif_no 
				AND d.trx_detail_id = a.trx_detail_id 
				AND a.trx_saving_type = 2 
				AND b.status_rekening = 1 
				AND d.trx_type = 1
				AND a.flag_debit_credit = 'D'
				AND a.trx_status = 0
				AND a.created_by=?
		       ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,array($this->session->userdata('user_id')));
		return $query->result_array();
	}

	public function count_cif_by_product_code_financing($product_code)
	{
		$sql = "select max(substr(account_financing_no,19)) AS jumlah from mfi_account_financing where product_code = ?";
		$query = $this->db->query($sql,array($product_code));

		return $query->row_array();
	}

	
	public function count_cif_by_cif_no_financing($cif_no)
	{
		$sql = "select max(substr(account_financing_no,19)) AS jumlah from mfi_account_financing where cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	
	public function get_ajax_akad($product_code)
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_akad.akad_name,
				mfi_akad.akad_code
				FROM
				mfi_product_financing
				INNER JOIN mfi_product_akad ON mfi_product_akad.product_code = mfi_product_financing.product_code
				INNER JOIN mfi_akad ON mfi_akad.akad_code = mfi_product_akad.akad_code

				WHERE mfi_product_financing.product_code  = ?";
		$query = $this->db->query($sql,array($product_code));

		return $query->row_array();
	}

	
	public function get_ajax_jenis_keuntungan($akad)
	{
		$sql = "SELECT
				akad_name,
				jenis_keuntungan,
				akad_code
				FROM
				mfi_akad
				WHERE akad_code  = ?";
		$query = $this->db->query($sql,array($akad));

		return $query->row_array();
	}

	public function get_jenis_program_financing()
	{
		$sql = "SELECT program_code, program_name from mfi_financing_program ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_sektor()
	{
		$sql = "SELECT
				mfi_list_code.code_group,
				mfi_list_code.code_description,
				mfi_list_code_detail.code_value,
				mfi_list_code_detail.display_text
				FROM
				mfi_list_code
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group = mfi_list_code.code_group
				where mfi_list_code.code_group='sektor_ekonomi' ORDER BY display_sort ASC";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_peruntukan()
	{
		$sql = "SELECT
				mfi_list_code.code_group,
				mfi_list_code.code_description,
				mfi_list_code_detail.code_value,
				mfi_list_code_detail.display_text
				FROM
				mfi_list_code
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group = mfi_list_code.code_group
				where mfi_list_code.code_group='peruntukan' ORDER BY display_sort ASC";
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	public function add_rekening_pembiayaan($data)
	{
		$this->db->insert('mfi_account_financing',$data);
	}
	
	public function add_rekening_pembiayaan_array($array_data)
	{
		$this->db->insert_batch('mfi_account_financing_schedulle',$array_data);
	}
	
	public function delete_rekening_pembiayaan($param)
	{
		$this->db->delete('mfi_account_financing',$param);
	}

	public function get_account_financing_by_cif_no($cif_no)
	{
		$sql = "select 
					cif_no,
					(case when mfi_account_financing.jtempo_angsuran_next is null 
						then mfi_account_financing.tanggal_mulai_angsur 
						else mfi_account_financing.jtempo_angsuran_next 
					end) as jtempo_angsuran_next,
					tanggal_jtempo,
					jangka_waktu,
					account_financing_no,
					periode_jangka_waktu,
					saldo_pokok,
					saldo_margin,
					saldo_catab,
					counter_angsuran,
					status_rekening 
				from 
					mfi_account_financing 
				where 
					cif_no = ? and status_rekening = 1";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function get_account_financing_by_account_financing_no2($account_financing_no)
	{
		$sql = "select 
		cif_no,
		(case when mfi_account_financing.jtempo_angsuran_next is null 
			then mfi_account_financing.tanggal_mulai_angsur 
			else mfi_account_financing.jtempo_angsuran_next 
		end) as jtempo_angsuran_next,
		tanggal_jtempo,
		jangka_waktu,
		account_financing_no,
		periode_jangka_waktu,
		saldo_pokok,
		saldo_margin,
		saldo_catab,
		counter_angsuran,
		status_rekening,
		branch_code
		
		from mfi_account_financing
		where account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}
	
	public function get_account_financing_by_account_financing_no_baru($account_financing_no,$cif_no)
	{
		$sql = "select 
		cif_no,
		(case when mfi_account_financing.jtempo_angsuran_next is null 
			then mfi_account_financing.tanggal_mulai_angsur 
			else mfi_account_financing.jtempo_angsuran_next 
		end) as jtempo_angsuran_next,
		tanggal_jtempo,
		jangka_waktu,
		account_financing_no,
		periode_jangka_waktu,
		saldo_pokok,
		saldo_margin,
		saldo_catab,
		counter_angsuran,
		status_rekening,
		branch_code
		
		from mfi_account_financing
		where account_financing_no = ? and cif_no = ?";
		$query = $this->db->query($sql,array($account_financing_no,$cif_no));

		return $query->row_array();
	}

	public function get_account_financing_by_account_financing_id($account_financing_id)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.cif_type,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.usia,
				mfi_cif.tgl_lahir,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler,
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.jenis_pembiayaan,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.pokok,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.margin,
				mfi_account_financing.dana_kebajikan,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_tab_wajib,
				mfi_account_financing.angsuran_tab_kelompok,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.biaya_administrasi,
				mfi_account_financing.biaya_asuransi_jiwa,
				mfi_account_financing.biaya_asuransi_jaminan,
				mfi_account_financing.biaya_notaris,
				mfi_account_financing.sumber_dana,
				mfi_account_financing.saldo_catab,
				mfi_account_financing.dana_sendiri,
				mfi_account_financing.dana_kreditur,
				mfi_account_financing.ujroh_kreditur,
				mfi_account_financing.ujroh_kreditur_carabayar,
				mfi_account_financing.ujroh_kreditur_persen,
				mfi_account_financing.tanggal_pengajuan,
				mfi_account_financing.tanggal_akad,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.akad_code,
				mfi_account_financing.sektor_ekonomi,
				mfi_account_financing.peruntukan,
				mfi_account_financing.program_code,
				mfi_account_financing.flag_jadwal_angsuran,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.pembiayaan_ke,
				mfi_account_financing_reg.description,
				mfi_akad.akad_name
				FROM
				mfi_cif
				LEFT JOIN mfi_account_financing ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				LEFT JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
				LEFT JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_account_financing.cif_no
				WHERE mfi_account_financing.account_financing_id = ? ";
		$query = $this->db->query($sql,array($account_financing_id));

		return $query->row_array();
	}
	
	public function get_account_financing_schedulle_by_no_account($account_financing_no)
	{
		$sql = "SELECT
				mfi_account_financing_schedulle.account_financing_schedulle_id,
				mfi_account_financing_schedulle.account_no_financing,
				mfi_account_financing_schedulle.tangga_jtempo,
				mfi_account_financing_schedulle.angsuran_pokok,
				mfi_account_financing_schedulle.angsuran_margin,
				mfi_account_financing_schedulle.angsuran_tabungan
				FROM
				mfi_account_financing
				LEFT JOIN mfi_account_financing_schedulle ON mfi_account_financing.account_financing_no = mfi_account_financing_schedulle.account_no_financing
				";
		if($account_financing_no==true)
			$sql .="WHERE mfi_account_financing_schedulle.account_no_financing = ? ";

		$query = $this->db->query($sql,array($account_financing_no));

		return $query->result_array();
	}
	
	public function cek_eksistensi_tanggal_jatuh_tempo($account_financing_no,$tglakhir_angsuran)
	{
		$sql = "select count(*) as num from mfi_account_financing_schedulle where account_no_financing = ? AND tangga_jtempo = ?";
		$query = $this->db->query($sql,array($account_financing_no,$tglakhir_angsuran));
		$row = $query->row_array();
		if(count($row)>0){
			return $row['num'];
		}else{
			return 0;
		}
		// return $query->result_array();
	}

	public function get_ambil_akad()
	{
		$sql = "SELECT
				mfi_akad.akad_code,
				mfi_akad.akad_name,
				mfi_akad.jenis_keuntungan
				FROM
				mfi_akad
				WHERE type_product = '2'
				";
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	public function edit_rekening_pembiayaan($data,$param)
	{
		$this->db->update('mfi_account_financing',$data,$param);
	}
	
	public function edit_rekening_pembiayaan_array($array_data,$param2)
	{
		$this->db->update('mfi_account_financing_schedulle',$array_data,$param2);
	}
	
	public function delete_rekening_pembiayaan_array($param2)
	{
		$this->db->delete('mfi_account_financing_schedulle',$param2);
	}

	public function insert_rekening_pembiayaan_array($array_data)
	{
		$this->db->insert_batch('mfi_account_financing_schedulle',$array_data);
	}

	public function get_ajax_biaya_administrasi($product,$biaya_administrasi,$tahun)
	{
		$sql = "select fn_get_biaya_adm_pembiayaan(?,?,?) as biaya_adm";

		$query = $this->db->query($sql,array($product,$biaya_administrasi,$tahun));
		$row = $query->row_array();

		return (!isset($row['biaya_adm']))?0:$row['biaya_adm'];
	}

	public function get_ajax_biaya_premi_asuransi_jiwa($product,$manfaat,$year,$month,$years,$months)
	{
		$sql = "select fn_get_premi_asuransi(?,?,?,?,?,?) as biaya_premi";

		$query = $this->db->query($sql,array($product,$manfaat,$year,$month,$years,$months));
		$row = $query->row_array();
		// print_r($this->db);
		return (!isset($row['biaya_premi']))?0:$row['biaya_premi'];
	}

	public function get_ajax_value_from_cif_no($cif_no)
	{
		$sql = "SELECT
				mfi_cif.branch_code,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.cif_no,
				mfi_cif.cif_type,
				mfi_cif.cm_code,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler,
				mfi_cm.cm_name
				FROM
				mfi_cif
				LEFT JOIN mfi_cm ON mfi_cif.cm_code=mfi_cm.cm_code
        		where mfi_cif.cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	//END REKENING PEMBIAYAAN

	// BEGIN PERSEDIAAN MBA
	function datatable_persediaan_mba_setup($sWhere='',$sOrder='',$sLimit='',$branch_code=''){

		$param = array();

		$sql = "SELECT
		maf.account_financing_no,
		mc.nama,
		maf.tanggal_akad,
		maf.pokok,
		FROM mfi_account_financing AS maf
		LEFT JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no";

		if($sWhere != ""){
			$sql .= "$sWhere";
			if($branch_code!="00000"){
				$sql .= " AND mc.branch_code IN(SELECT branch_code
				FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch_code;
			}
		} else {
			if($branch_code!="00000"){
				$sql .= " WHERE mc.branch_code IN(SELECT branch_code
				FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch_code;
			}
		}

		if($sOrder != ""){
			$sql .= " $sOrder ";
		}

		if ($sLimit != ""){
			$sql .= " $sLimit";
		}

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	//BEGIN VERIFIKASI PEMBIAYAAN
	public function datatable_rekening_ver_pembiayaan_setup($sWhere='',$sOrder='',$sLimit='',$tgl_akad='',$branch_code='')
	{
		$param = array();
		$sql = "SELECT
		mfi_akad.akad_code,
		mfi_akad.akad_name,
		mfi_account_financing.account_financing_id,
		mfi_account_financing.account_financing_no,
		mfi_account_financing.jangka_waktu,
		mfi_account_financing.pokok,
		mfi_account_financing.tanggal_akad,
		mfi_cif.cif_no,
		mfi_cif.nama,
		mfi_cm.cm_name
		FROM
		mfi_account_financing
		LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
		LEFT JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
		LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
		LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			$sql .= " AND mfi_account_financing.tanggal_akad = ? ";
			$tgl_akad = substr($tgl_akad,4,4).'-'.substr($tgl_akad,2,2).'-'.substr($tgl_akad,0,2);
			$param[] = $tgl_akad;
		}else{
			$sql .= " WHERE mfi_account_financing.tanggal_akad = ? ";
			$tgl_akad = substr($tgl_akad,4,4).'-'.substr($tgl_akad,2,2).'-'.substr($tgl_akad,0,2);
			$param[] = $tgl_akad;
		}

		if ($branch_code!="00000") {
			$sql .= " AND mfi_cif.branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function verifikasi_rekening_pembiayaan($data,$param)
	{
		$this->db->update('mfi_account_financing',$data,$param);
	}

	public function update_status_financing_reg($data2,$param2)
	{
		$this->db->update('mfi_account_financing_reg',$data2,$param2);
	}

	//END VERIFIKASI PEMBIAYAAN
	

	/* BEGIN INSURANCE *******************************************************/
	public function get_all_insurance()
	{
		$sql = "SELECT
						mfi_cif.nama,
						mfi_account_insurance.account_insurance_no,
						mfi_product_insurance.product_name,
						mfi_account_insurance.status,
						mfi_account_insurance.account_insurance_id
				FROM
						mfi_cif
			INNER JOIN 	
						mfi_account_insurance ON mfi_cif.cif_no = mfi_account_insurance.cif_no
			INNER JOIN 	
						mfi_product_insurance ON mfi_account_insurance.product_code = mfi_product_insurance.product_code ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_all_product_insurance()
	{
		$sql = "SELECT * from mfi_product_insurance ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_all_insurance_plan()
	{
		$sql = "SELECT * from mfi_product_insurance_plan ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_insurance_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
						mfi_cif.nama,
						mfi_account_insurance.account_insurance_no,
						mfi_product_insurance.product_name,
						mfi_account_insurance.status_rekening,
						mfi_account_insurance.account_insurance_id,
						mfi_cm.cm_name
				FROM
						mfi_cif
				INNER JOIN 	
							mfi_account_insurance ON mfi_cif.cif_no = mfi_account_insurance.cif_no
				INNER JOIN 	
							mfi_product_insurance ON mfi_account_insurance.product_code = mfi_product_insurance.product_code
				LEFT JOIN
							mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
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
	
	
	public function add_insurance($data)
	{
		$this->db->insert('mfi_account_insurance',$data);
	}
	
	public function delete_insurance($param)
	{
		$this->db->delete('mfi_account_insurance',$param);
	}
	
	public function get_account_insurance_by_account_insurance_id($account_insurance_id)
	{
		$sql = "SELECT
							mfi_cif.cif_no,
							mfi_cif.nama,
							mfi_cif.panggilan,
							mfi_cif.ibu_kandung,
							mfi_cif.tmp_lahir,
							mfi_cif.tgl_lahir,
							mfi_cif.alamat,
							mfi_cif.rt_rw,
							mfi_cif.desa,
							mfi_cif.kecamatan,
							mfi_cif.kabupaten,
							mfi_cif.kodepos,
							mfi_cif.telpon_rumah,
							mfi_cif.telpon_seluler,
							mfi_account_insurance.account_insurance_id,
							mfi_account_insurance.product_code,
							mfi_account_insurance.account_insurance_no,
							mfi_account_insurance.awal_kontrak,
							mfi_account_insurance.akhir_kontrak,
							mfi_account_insurance.benefit_value,
							mfi_account_insurance.premium_value,
							mfi_account_insurance.premium_rate,
							mfi_account_insurance.plan_code,
							mfi_account_insurance.account_saving_no,
							mfi_account_insurance.usia_peserta,
							mfi_product_insurance.product_name,
							mfi_product_insurance.insurance_type,
							mfi_product_insurance.rate_type,
							mfi_product_insurance.rate_code
					FROM
							mfi_cif
				INNER JOIN 	
							mfi_account_insurance ON mfi_cif.cif_no = mfi_account_insurance.cif_no
				INNER JOIN 
							mfi_product_insurance ON mfi_account_insurance.product_code = mfi_product_insurance.product_code

				WHERE 
							account_insurance_id = ? ";
		$query = $this->db->query($sql,array($account_insurance_id));

		return $query->row_array();
	}
	
	public function edit_insurance($data,$param)
	{
		$this->db->update('mfi_account_insurance',$data,$param);
	}

	public function count_account_no_by_product_code($product_code)
	{
		$sql = "select max(right(account_insurance_no,3)) AS jumlah from mfi_account_insurance where product_code = ?";
		$query = $this->db->query($sql,array($product_code));

		return $query->row_array();
	}

	public function count_premi_rate_0($rate_type)
	{
		$sql = "select rate_tunggal as rate from mfi_product_insurance where rate_type = ?";
		$query = $this->db->query($sql,array($rate_type));

		return $query->row_array();
	}

	public function count_premi_rate_1($rate_code,$usia,$kontrak)
	{
		$sql = "select rate_value as rate from mfi_product_insurance_rate where rate_code = ? AND usia = ? AND kontrak = ? ";
		$query = $this->db->query($sql,array($rate_code,$usia,$kontrak));

		return $query->row_array();
	}

	public function count_premi_rate_2($plan_code)
	{
		$sql = "select premium_value AS rate from mfi_product_insurance_plan where plan_code = ?";
		$query = $this->db->query($sql,array($plan_code));

		return $query->row_array();
	}
	/* END INSURANCE *******************************************************/

	/* PENARIKAN TUNAI TABUNGAN *******************************************************/
	// search account saving number
	public function search_account_saving_no($keyword='',$cif_type='',$cm_code='')
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_saving.cif_no,
				mfi_account_saving.account_saving_no,
				mfi_account_saving.product_code,
				mfi_account_saving.status_rekening,
				mfi_product_saving.product_name
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				INNER JOIN mfi_product_saving ON mfi_product_saving.product_code = mfi_account_saving.product_code
				WHERE (UPPER(nama) like ? or account_saving_no like ?)
				AND mfi_product_saving.product_code = '0007'
				";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($cif_type!=""){
			$sql .= " and cif_type = ? ";
			$param[] = $cif_type;
		}

		if($cm_code!=""){
			$sql .= " and cm_code = ? ";
			$param[] = $cm_code;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function account_saving_no_individu($keyword='',$cif_type='',$cm_code='',$branch_code){
		$sql = "SELECT
		mc.nama,
		mas.cif_no,
		mas.account_saving_no,
		mas.product_code,
		mas.status_rekening,
		mps.product_name,
		mcm.cm_name,
		maf.account_financing_no AS reference_no
		FROM mfi_account_saving AS mas
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		JOIN mfi_account_financing AS maf ON maf.account_saving_no = mas.account_saving_no
		JOIN mfi_branch AS mb ON mb.branch_code = mas.branch_code
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE (UPPER(nama) like ? or mas.account_saving_no like ?)
		AND maf.financing_type = '1' and maf.status_rekening = '1'";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($cif_type!=""){
			$sql .= " and cif_type = ? ";
			$param[] = $cif_type;
		}

		if($cm_code!=""){
			$sql .= " and cm_code = ? ";
			$param[] = $cm_code;
		}

		if($branch_code!='00000'){
			$sql .= " and mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function search_account_saving_no_active($keyword='')
	{

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_type,
				mfi_cm.cm_code,
				mfi_cm.cm_name,
				mfi_account_saving.cif_no,
				mfi_account_saving.account_saving_no,
				mfi_account_saving.product_code,
				mfi_account_saving.status_rekening,
				mfi_product_saving.product_name
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_product_saving ON mfi_product_saving.product_code = mfi_account_saving.product_code
				LEFT JOIN mfi_branch ON mfi_branch.branch_id=mfi_cm.branch_id
				WHERE (UPPER(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?) and mfi_account_saving.status_rekening = 1
				AND mfi_cif.cif_type=0
				";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if ($flag_all_branch==0) {
			$sql .= " AND mfi_branch.branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function ajax_get_value_from_account_saving($no_rekening)
	{
		$sql = "SELECT
						(mfi_account_saving.saldo_memo-mfi_account_saving.saldo_hold-mfi_product_saving.saldo_minimal) AS saldo_efektif,
						mfi_cif.nama,
						mfi_account_saving.account_saving_no,
						mfi_cif.cif_no,
						mfi_product_saving.product_name,
						mfi_account_saving.saldo_memo,
						mfi_account_saving.saldo_hold,
						mfi_product_saving.saldo_minimal,
						mfi_branch.branch_id
				FROM
						mfi_cif
				INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
				INNER JOIN mfi_branch ON mfi_account_saving.branch_code = mfi_branch.branch_code
				WHERE mfi_account_saving.account_saving_no = ?
				";
		$query = $this->db->query($sql,array($no_rekening));
		
		return $query->row_array();
	}

	public function ajax_get_value_from_account_saving2($no_rekening)
	{
		$sql = "SELECT (mfi_account_saving.saldo_memo-mfi_account_saving.saldo_hold-mfi_product_saving.saldo_minimal) 
				as saldo_efektif,mfi_account_saving.saldo_memo,mfi_account_saving.account_saving_no,nama,mfi_account_saving.product_code,product_name,status_rekening ,mfi_cif.cif_type,mfi_cif.cif_no
				,mfi_trx_account_saving.trx_account_saving_id,mfi_trx_account_saving.trx_date
				from mfi_account_saving 
				left join mfi_product_saving on mfi_account_saving.product_code = mfi_product_saving.product_code
				left join mfi_cif on mfi_account_saving.cif_no = mfi_cif.cif_no
				left join mfi_trx_account_saving on mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				where mfi_account_saving.account_saving_no = ?
				";
		$query = $this->db->query($sql,array($no_rekening));
		
		return $query->row_array();
	}

	public function ajax_get_value_from_account_saving_status_3($no_rekening)
	{
		$sql = "SELECT (mfi_account_saving.saldo_memo-mfi_account_saving.saldo_hold-mfi_product_saving.saldo_minimal) 
				as saldo_efektif,mfi_account_saving.saldo_memo,mfi_account_saving.account_saving_no,nama,mfi_account_saving.product_code,product_name,status_rekening ,mfi_cif.cif_type,mfi_cif.cif_no
				,mfi_trx_account_saving.trx_account_saving_id
				from mfi_account_saving 
				left join mfi_product_saving on mfi_account_saving.product_code = mfi_product_saving.product_code
				left join mfi_cif on mfi_account_saving.cif_no = mfi_cif.cif_no
				left join mfi_trx_account_saving on mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				where mfi_account_saving.account_saving_no = ? AND status_rekening = '3' AND mfi_cif.cif_type=0
				";
		$query = $this->db->query($sql,array($no_rekening));
		
		return $query->row_array();
	}

	public function get_rekening_tabungan_berencana_tujuan($cif_no,$account_financing_no)
	{
		$sql = "select * from mfi_account_saving where cif_no = ? and account_financing_no <> ? and status_rekening = 1";
		$query = $this->db->query($sql,array($cif_no,$account_saving_no));
		return $query->result_array();
	}

	public function update_account_saving_penarikan($data_account_saving,$param_account_saving)
	{
		$this->db->update('mfi_account_saving',$data_account_saving,$param_account_saving);
	}

	public function insert_trx_account_saving_penarikan($data_trx_account_saving)
	{
		$this->db->insert('mfi_trx_account_saving',$data_trx_account_saving);
	}

	public function insert_trx_detail_penarikan($data_trx_detail)
	{
		$this->db->insert('mfi_trx_detail',$data_trx_detail);
	}

	public function update_trx_account_saving_penarikan($data_trx_account_saving,$param)
	{
		$this->db->update('mfi_trx_account_saving',$data_trx_account_saving,$param);
	}

	public function update_trx_detail_penarikan($data_trx_detail,$param)
	{
		$this->db->update('mfi_trx_detail',$data_trx_detail,$param);
	}
	
	public function check_no_referensi($no_referensi)
	{
		$sql = "select count(*) as num from mfi_trx_account_saving where reference_no = ?";
		$query = $this->db->query($sql,array($no_referensi));

		$row = $query->row_array();
		if($row['num']>0){
			return false;
		}else{
			return true;
		}
	}

	
	/**************************************************************************************/
	// BEGIN SETORAN TUNAI TABUNGAN 
	/**************************************************************************************/
	

	// search cif number
	public function search_cif_by_account_saving($keyword='',$type='',$cm_code='')
	{
		$sql = "SELECT
		mfi_account_saving.account_saving_no,
		mfi_cif.cif_no,
		mfi_cif.nama,
		mfi_product_saving.product_name,
		mfi_product_saving.product_code,
		mfi_account_saving.status_rekening
		FROM mfi_account_saving
		INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
		INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
		WHERE (upper(mfi_cif.nama) LIKE ? OR mfi_cif.cif_no LIKE ? OR mfi_account_saving.account_saving_no LIKE ?)
		AND mfi_account_saving.status_rekening !=2 AND mfi_product_saving.product_code = '0007'";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		$param[] = '%'.$keyword.'%';

		if($type!=""){
			$sql .= ' and cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!=""){
			$sql .= ' and cm_code = ?';
			$param[] = $cm_code;
		} 

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function search_cif_by_account_saving_no($account_saving_no)
	{
		$sql = "SELECT
		(mfi_account_saving.saldo_memo-mfi_account_saving.saldo_hold-mfi_product_saving.saldo_minimal) AS saldo_efektif,
		mfi_cif.nama,
		mfi_account_saving.account_saving_no,
		mfi_cif.cif_no,
		mfi_product_saving.product_name,
		mfi_account_saving.saldo_memo,
		mfi_account_saving.saldo_hold,
		mfi_product_saving.saldo_minimal,
		mfi_branch.branch_id
		FROM
		mfi_cif
		INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
		INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
		INNER JOIN mfi_branch ON mfi_account_saving.branch_code = mfi_branch.branch_code
		WHERE mfi_account_saving.account_saving_no = ?";
		

		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	public function add_setoran_tunai_detail($data)
	{
		$this->db->insert('mfi_trx_detail',$data);
	}

	public function add_setoran_tunai_account_saving($data)
	{
		$this->db->insert('mfi_trx_account_saving',$data);
	}

	public function update_setoran_tunai_detail($data,$param)
	{
		$this->db->update('mfi_trx_detail',$data,$param);
	}

	public function update_setoran_tunai_trx_account_saving($data,$param)
	{
		$this->db->update('mfi_trx_account_saving',$data,$param);
	}

	public function update_setoran_tunai_account_saving($data_account_saving,$param_account_saving)
	{
		$this->db->update('mfi_account_saving',$data_account_saving,$param_account_saving);
	}
	

	/**************************************************************************************/
	// END SETORAN TUNAI TABUNGAN 
	/**************************************************************************************/



	/* BEGIN PINBUK ************************************************************/

	public function get_no_rekening_pinbuk_sumber($keyword,$no_rekening_tujuan)
	{
		$sql = "select 
				mfi_account_saving.account_saving_no,
				mfi_account_saving.status_rekening,
				mfi_cif.nama,
				mfi_product_saving.product_name,
				(mfi_account_saving.saldo_memo - mfi_account_saving.saldo_hold - mfi_product_saving.saldo_minimal) as saldo_efektif
				from mfi_account_saving
				left join mfi_cif on mfi_cif.cif_no = mfi_account_saving.cif_no
				left join mfi_product_saving on mfi_product_saving.product_code = mfi_account_saving.product_code
				where (mfi_account_saving.account_saving_no like ? or upper(mfi_cif.nama) like ?)
				and mfi_cif.cif_type = 1 and mfi_account_saving.account_saving_no<>?
			";
		$query = $this->db->query($sql,array('%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%',$no_rekening_tujuan));

		return $query->result_array();
	}

	public function get_no_rekening_pinbuk_tujuan($keyword,$no_rekening_sumber)
	{
		$sql = "select 
				mfi_account_saving.account_saving_no,
				mfi_account_saving.status_rekening,
				mfi_cif.nama,
				mfi_product_saving.product_name,
				(mfi_account_saving.saldo_memo - mfi_account_saving.saldo_hold - mfi_product_saving.saldo_minimal) as saldo_efektif
				from mfi_account_saving
				left join mfi_cif on mfi_cif.cif_no = mfi_account_saving.cif_no
				left join mfi_product_saving on mfi_product_saving.product_code = mfi_account_saving.product_code
				where (mfi_account_saving.account_saving_no like ? or upper(mfi_cif.nama) like ?)
				and mfi_cif.cif_type = 1 and mfi_account_saving.account_saving_no<>?
			";
		$query = $this->db->query($sql,array('%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%',$no_rekening_sumber));

		return $query->result_array();
	}

	public function get_account_saving_by_account_saving_no($account_saving_no)
	{
		$sql = "select * from mfi_account_saving where account_saving_no = ?";
		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	public function update_account_saving($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}

	public function insert_trx_account_saving($data)
	{
		$this->db->insert('mfi_trx_account_saving',$data);
	}

	public function insert_trx_detail($data)
	{
		$this->db->insert('mfi_trx_detail',$data);
	}

	/* END PINBUK ************************************************************/



	/****************************************************************************************/	
	// BEGIN REGISTRASI PENCAIRAN DEPOSITO
	/****************************************************************************************/

	public function search_cif_by_account_deposit($keyword)
	{
		$sql = "SELECT
						mfi_product_deposit.product_name,
						mfi_account_deposit.account_deposit_no,
						mfi_account_deposit.account_saving_no,
						mfi_cif.nama,
						mfi_cif.cif_no,
						mfi_account_deposit.status_rekening
				FROM
						mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				INNER JOIN mfi_product_deposit ON mfi_account_deposit.product_code = mfi_product_deposit.product_code

				WHERE (upper(nama) like ? or account_saving_no like ?)
				";

			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));
		
		// print_r($this->db);

		return $query->result_array();
	}

	public function search_cif_by_account_deposit_no($account_deposit_no)
	{
		$sql = "SELECT
						mfi_product_deposit.product_name,
						mfi_account_deposit.automatic_roll_over,
						mfi_account_deposit.account_deposit_no,
						mfi_account_deposit.account_saving_no,
						mfi_cif.nama,
						mfi_cif.cif_no,
						mfi_cif.ibu_kandung,
						mfi_cif.tgl_lahir,
						mfi_cif.rt_rw,
						mfi_cif.alamat,
						mfi_cif.desa,
						mfi_cif.kecamatan,
						mfi_cif.kabupaten,
						mfi_product_deposit.product_code,
						mfi_product_deposit.product_name,
						mfi_account_deposit.jangka_waktu,
						mfi_account_deposit.nominal,
						mfi_account_deposit.tanggal_jtempo_last,
						mfi_account_deposit.automatic_roll_over
				FROM
						mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				INNER JOIN mfi_product_deposit ON mfi_account_deposit.product_code = mfi_product_deposit.product_code


				WHERE (mfi_account_deposit.account_deposit_no = ?)";
		

		$query = $this->db->query($sql,array($account_deposit_no));

		return $query->row_array();
	}

	public function search_name_by_account_saving_no($account_saving_no)
	{
		$sql = "SELECT
						mfi_account_saving.account_saving_no,
						mfi_cif.cif_no,
						mfi_cif.nama AS atasnama
				FROM
						mfi_account_saving
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no


				WHERE (mfi_account_saving.account_saving_no = ?)";
		

		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	public function search_name_by_account_saving_no_klaim($account_saving_no)
	{
		$sql = "SELECT
						mfi_account_saving.account_saving_no,
						mfi_cif.cif_no,
						mfi_cif.nama
				FROM
						mfi_cif
				INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
				WHERE mfi_account_saving.account_saving_no = ?";

		$query = $this->db->query($sql,array($account_saving_no));

		return $query->result_array();
	}

	public function update_pencairan_deposito($data_pencairan_deposito,$param_pencairan_deposito)
	{
		$this->db->update('mfi_account_deposit',$data_pencairan_deposito,$param_pencairan_deposito);
	}

	public function insert_deposito_break($data)
	{
		$this->db->insert('mfi_account_deposit_break',$data);
	}
	
	/****************************************************************************************/	
	// END REGISTRASI PENCAIRAN DEPOSITO
	/****************************************************************************************/

	//BEGIN VERIFIKASI DEPOSITO
	public function datatable_rekening_ver_deposito_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_cm.cm_name,
				mfi_account_deposit.account_deposit_id,
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.jangka_waktu,
				mfi_account_deposit.nominal
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
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

	public function verifikasi_rekening_deposito($data,$param)
	{
		$this->db->update('mfi_account_deposit',$data,$param);
	}

	public function verifikasi_rek_deposito($data,$param)
	{
		$this->db->update('mfi_account_deposit',$data,$param);
	}
	
	public function delete_rekening_deposito($param)
	{
		$this->db->delete('mfi_account_deposit',$param);
	}

	public function get_product_deposito()
	{
		$sql = "SELECT product_code, product_name from mfi_product_deposit ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function update_saldo_memo_from_account_saving($data2,$param2)
	{
		$this->db->update('mfi_account_saving',$data2,$param2);
	}

	public function insert_mfi_trx_detail($data_trx_detail)
	{
		$this->db->insert('mfi_trx_detail',$data_trx_detail);
	}

	public function insert_mfi_trx_account_deposit($data_trx_account_deposit)
	{
		$this->db->insert('mfi_trx_account_deposit',$data_trx_account_deposit);
	}

	public function insert_mfi_trx_account_saving($data_trx_account_saving)
	{
		$this->db->insert('mfi_trx_account_saving',$data_trx_account_saving);
	}

	public function get_date_current()
	{
		$sql = "SELECT date_current from mfi_date_transaction";
		$query = $this->db->query($sql);

		$row = $query->row_array();
		return $row['date_current'];
	}

	//END VERIFIKASI DEPOSITO

	/**************************************************************************************/
	// BEGIN VERIFIKASI PENCAIRAN DEPOSITO 
	/**************************************************************************************/
	public function datatable_pencairan_deposito_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_cm.cm_name,
				mfi_account_deposit.account_deposit_id,
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.nominal,
				mfi_account_deposit.jangka_waktu,
				mfi_account_deposit_break.account_deposit_break_id,
				mfi_account_deposit_break.status_break
				FROM
				mfi_account_deposit_break
				INNER JOIN mfi_account_deposit ON mfi_account_deposit.account_deposit_no = mfi_account_deposit_break.account_deposit_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
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

	public function search_cif_by_account_deposit_break_id($account_deposit_break_id)
	{
		$sql = "SELECT
						mfi_product_deposit.product_name,
						mfi_account_deposit.account_deposit_no,
						mfi_cif.nama,
						mfi_cif.cif_no,
						mfi_cif.ibu_kandung,
						mfi_cif.tgl_lahir,
						mfi_cif.rt_rw,
						mfi_cif.alamat,
						mfi_cif.desa,
						mfi_cif.kecamatan,
						mfi_cif.kabupaten,
						mfi_product_deposit.product_name,
						mfi_account_deposit.jangka_waktu,
						mfi_account_deposit.nominal,
						mfi_account_deposit.tanggal_jtempo_last,
						mfi_account_deposit.automatic_roll_over,
						mfi_account_deposit.automatic_roll_over,
						mfi_account_deposit_break.account_deposit_break_id,
						mfi_account_deposit_break.account_saving_no
				FROM
						mfi_account_deposit
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				LEFT JOIN mfi_product_deposit ON mfi_account_deposit.product_code = mfi_product_deposit.product_code
				LEFT JOIN mfi_account_deposit_break ON mfi_account_deposit_break.account_deposit_no = mfi_account_deposit.account_deposit_no



				WHERE (mfi_account_deposit_break.account_deposit_break_id = ?)";
		

		$query = $this->db->query($sql,array($account_deposit_break_id));

		return $query->row_array();
	}

	public function update_account_deposit($data,$param)
	{
		$this->db->update('mfi_account_deposit',$data,$param);
	}

	public function update_account_deposit_break($data,$param)
	{
		$this->db->update('mfi_account_deposit_break',$data,$param);
	}

	public function delete_account_deposit_break($param)
	{
		$this->db->delete('mfi_account_deposit_break',$param);
	}
	/**************************************************************************************/
	// END VERIVIKASI PENCAIRAN DEPOSITO 
	/**************************************************************************************/

	//BEGIN VERIFIKASI ASURANSI
	public function datatable_verifikasi_insurance_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_account_insurance.account_insurance_no,
				mfi_cif.nama,
				mfi_product_insurance.product_name,
				mfi_product_insurance.product_code,
				mfi_account_insurance.benefit_value,
				mfi_account_insurance.premium_value,
				mfi_account_insurance.awal_kontrak,
				mfi_account_insurance.akhir_kontrak,
				mfi_account_insurance.status_rekening,
				mfi_cif.cif_no,
				mfi_account_insurance.account_insurance_id,
				mfi_cm.cm_name
				FROM
				mfi_cif
				INNER JOIN mfi_account_insurance ON mfi_account_insurance.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_insurance ON mfi_product_insurance.product_code = mfi_account_insurance.product_code
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
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

	public function get_account_insurance_by_account_insurance_id_on_verifikasi($account_insurance_id)
	{
		$sql = "SELECT
							mfi_cif.cif_no,
							mfi_cif.nama,
							mfi_cif.panggilan,
							mfi_cif.ibu_kandung,
							mfi_cif.tmp_lahir,
							mfi_cif.tgl_lahir,
							mfi_cif.alamat,
							mfi_cif.rt_rw,
							mfi_cif.desa,
							mfi_cif.kecamatan,
							mfi_cif.kabupaten,
							mfi_cif.kodepos,
							mfi_cif.telpon_rumah,
							mfi_cif.telpon_seluler,
							mfi_account_insurance.account_insurance_id,
							mfi_account_insurance.product_code,
							mfi_account_insurance.account_insurance_no,
							mfi_account_insurance.awal_kontrak,
							mfi_account_insurance.akhir_kontrak,
							mfi_account_insurance.benefit_value,
							mfi_account_insurance.premium_value,
							mfi_account_insurance.premium_rate,
							mfi_account_insurance.plan_code,
							mfi_account_insurance.account_saving_no AS pemegang_rekening,
							mfi_account_insurance.usia_peserta,
							mfi_product_insurance.product_name,
							mfi_product_insurance.insurance_type,
							mfi_product_insurance.rate_type,
							mfi_product_insurance.rate_code,
							mfi_account_saving.saldo_memo
					FROM
							mfi_cif
				INNER JOIN 	
							mfi_account_insurance ON mfi_cif.cif_no = mfi_account_insurance.cif_no
				INNER JOIN 
							mfi_product_insurance ON mfi_account_insurance.product_code = mfi_product_insurance.product_code
				INNER JOIN 
							mfi_account_saving ON mfi_cif.cif_no = mfi_account_saving.cif_no

				WHERE 
							account_insurance_id = ? ";
		$query = $this->db->query($sql,array($account_insurance_id));

		return $query->row_array();
	}


	public function mencari_nama_pemegang_rekening($pemegang_rekening)
	{
		$sql = "SELECT
						mfi_cif.nama
				FROM
						mfi_cif
				INNER JOIN mfi_account_saving ON mfi_cif.cif_no = mfi_account_saving.cif_no
				where mfi_account_saving.account_saving_no = ?";
		$query = $this->db->query($sql,array($pemegang_rekening));

		return $query->row_array();
	}

	public function update_saldo_memo($update_saldo_memo,$account_saving_no)
	{
		$this->db->update('mfi_account_saving',$update_saldo_memo,$account_saving_no);
	}

	public function insert_mfi_trx_detail_on_verifikasi_insurance($data)
	{
		$this->db->insert('mfi_trx_detail',$data);
	}

	public function insert_mfi_trx_account_insurance_on_verifikasi_insurance($data)
	{
		$this->db->insert('mfi_trx_account_insurance',$data);
	}
	
	public function insert_mfi_trx_account_saving_on_verifikasi_insurance($data)
	{
		$this->db->insert('mfi_trx_account_saving',$data);
	}

	public function verifikasi_rekening_asuransi($data,$param)
	{
		$this->db->update('mfi_account_insurance',$data,$param);
	}

	public function verifikasi_rek_asuransi($data,$param)
	{
		$this->db->update('mfi_account_insurance',$data,$param);
	}
	
	public function delete_rekening_asuransi($param)
	{
		$this->db->delete('mfi_account_insurance',$param);
	}

	public function get_product_asuransi()
	{
		$sql = "SELECT product_code, product_name from mfi_product_deposit ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_trx_rembug_data($cm_code,$tanggal)
	{
		$sql = "SELECT 
		cif.cif_id,
		cif.cm_code,
		cif.cif_no,
		cif.nama,
		(CASE WHEN (cif.status IN(1,3) AND balance.transaksi_lain = 0)
		THEN cif_kelompok.setoran_lwk ELSE 0 END) AS setoran_lwk,
		cif_kelompok.setoran_mingguan,
		pembiayaan.account_financing_no,
		balance.tabungan_sukarela,
		balance.tabungan_wajib,
		balance.transaksi_lain,
		(CASE WHEN droping.status_droping = 1
		THEN balance.angsuran ELSE 0 END) AS angsuran,
		(CASE WHEN droping.status_droping = 1
		THEN balance.pokok_pembiayaan ELSE 0 END) AS pokok_pembiayaan,
		(CASE WHEN droping.status_droping = 1
		THEN balance.margin_pembiayaan ELSE 0 END) AS margin_pembiayaan,
		(CASE WHEN droping.status_droping = 1
		THEN balance.catab_pembiayaan ELSE 0 END) AS catab_pembiayaan,
		balance.tabungan_kelompok,
		(CASE WHEN droping.status_droping = 1
		THEN pembiayaan.saldo_pokok ELSE 0 END) AS saldo_pokok,
		(CASE WHEN droping.status_droping = 1
		THEN pembiayaan.saldo_margin ELSE 0 END) AS saldo_margin,
		(CASE WHEN droping.status_droping = 1
		THEN pembiayaan.saldo_catab ELSE 0 END) AS saldo_catab,
		(CASE WHEN droping.status_droping = 1
		THEN pembiayaan.jangka_waktu ELSE 0 END) AS jangka_waktu,
		(CASE WHEN droping.status_droping = 1
		THEN pembiayaan.periode_jangka_waktu ELSE 0 END) AS periode_jangka_waktu,
		(CASE WHEN droping.status_droping = 1
		THEN pembiayaan.counter_angsuran ELSE 0 END) AS counter_angsuran,
		(CASE WHEN pembiayaan.tanggal_akad <= ?
			THEN (CASE WHEN pembiayaan.status_rekening = 1
			THEN (CASE WHEN (select status_droping FROM mfi_account_financing_droping
			AS droping
			WHERE droping.account_financing_no = pembiayaan.account_financing_no) = 1
			THEN (pembiayaan.angsuran_pokok + pembiayaan.angsuran_margin+pembiayaan.angsuran_catab+pembiayaan.angsuran_tab_wajib+pembiayaan.angsuran_tab_kelompok)
			ELSE 0  END)
			ELSE 0 END) 
		ELSE 0 END) AS jumlah_angsuran,
		(select status_droping FROM mfi_account_financing_droping droping WHERE droping.account_financing_no = pembiayaan.account_financing_no),
		pembiayaan.tanggal_akad,
		(CASE WHEN pembiayaan.tanggal_akad <= ? THEN (CASE WHEN (select status_droping FROM mfi_account_financing_droping droping WHERE droping.account_financing_no = pembiayaan.account_financing_no) = 0 THEN pembiayaan.pokok ELSE 0 END) ELSE 0 END) AS pokok
		,(CASE WHEN pembiayaan.tanggal_akad <= ? THEN (CASE WHEN (select status_droping FROM mfi_account_financing_droping droping WHERE droping.account_financing_no = pembiayaan.account_financing_no) = 0 THEN pembiayaan.margin ELSE 0 END) ELSE 0 END) AS margin
		,(CASE WHEN pembiayaan.tanggal_akad <= ? THEN (CASE WHEN (select status_droping FROM mfi_account_financing_droping droping WHERE droping.account_financing_no = pembiayaan.account_financing_no) = 0 THEN pembiayaan.pokok ELSE 0 END) ELSE 0 END) AS droping
		,(CASE WHEN pembiayaan.tanggal_akad <= ? THEN (CASE WHEN pembiayaan.status_rekening = 1 THEN (CASE WHEN (select status_droping FROM mfi_account_financing_droping droping WHERE droping.account_financing_no = pembiayaan.account_financing_no) = 1 THEN pembiayaan.angsuran_pokok ELSE 0 END) ELSE 0 END) ELSE 0 END) AS angsuran_pokok
		,(CASE WHEN pembiayaan.tanggal_akad <= ? THEN (CASE WHEN pembiayaan.status_rekening = 1 THEN (CASE WHEN (select status_droping FROM mfi_account_financing_droping droping WHERE droping.account_financing_no = pembiayaan.account_financing_no) = 1 THEN pembiayaan.angsuran_margin ELSE 0 END) ELSE 0 END) ELSE 0 END) AS angsuran_margin
		,(CASE WHEN pembiayaan.tanggal_akad <= ? THEN (CASE WHEN pembiayaan.status_rekening = 1 THEN (CASE WHEN (select status_droping FROM mfi_account_financing_droping droping WHERE droping.account_financing_no = pembiayaan.account_financing_no) = 1 THEN pembiayaan.angsuran_catab ELSE 0 END) ELSE 0 END) ELSE 0 END) AS angsuran_catab
		,(CASE WHEN pembiayaan.tanggal_akad <= ? THEN (CASE WHEN pembiayaan.status_rekening = 1 THEN (CASE WHEN (select status_droping FROM mfi_account_financing_droping droping WHERE droping.account_financing_no = pembiayaan.account_financing_no) = 1 THEN pembiayaan.angsuran_tab_wajib ELSE 0 END) ELSE 0 END) ELSE 0 END) AS angsuran_tab_wajib
		,(CASE WHEN pembiayaan.tanggal_akad <= ? THEN (CASE WHEN pembiayaan.status_rekening = 1 THEN (CASE WHEN (select status_droping FROM mfi_account_financing_droping droping WHERE droping.account_financing_no = pembiayaan.account_financing_no) = 1 THEN pembiayaan.angsuran_tab_kelompok ELSE 0 END) ELSE 0 END) ELSE 0 END) AS angsuran_tab_kelompok
		,pembiayaan.product_code
		,(CASE WHEN pembiayaan.tanggal_akad <= ? THEN (CASE WHEN (select status_droping FROM mfi_account_financing_droping droping WHERE droping.account_financing_no = pembiayaan.account_financing_no) = 0 THEN (pembiayaan.cadangan_resiko + pembiayaan.dana_kebajikan + pembiayaan.biaya_administrasi + pembiayaan.biaya_notaris) ELSE 0 END) ELSE 0 END) AS adm
		,(CASE WHEN pembiayaan.tanggal_akad <= ? THEN (CASE WHEN (select status_droping FROM mfi_account_financing_droping droping WHERE droping.account_financing_no = pembiayaan.account_financing_no) = 0 THEN (biaya_asuransi_jiwa + biaya_asuransi_jaminan) ELSE 0 END) ELSE 0 END) asuransi 
		,cif.status
		,(CASE WHEN droping.status_droping = 1 THEN COALESCE(SUM(berencana.rencana_setoran),0) ELSE 0 END) AS setoran_berencana
		,droping.status_droping
		,(pembiayaan.jangka_waktu-pembiayaan.counter_angsuran) AS freq_saldo_outstanding
		,(select fn_get_freq_tunggakan(pembiayaan.account_financing_no,?)) AS freq_tunggakan
		,cif.kelompok
		FROM mfi_cif AS cif
		LEFT OUTER JOIN mfi_cif_kelompok AS cif_kelompok ON cif_kelompok.cif_id = cif.cif_id
		LEFT OUTER JOIN mfi_account_default_balance AS balance  ON (cif.cif_no = balance.cif_no)
		LEFT OUTER JOIN mfi_account_financing AS pembiayaan ON (pembiayaan.cif_no=cif.cif_no AND pembiayaan.status_rekening = 1 AND pembiayaan.financing_type='0')
		LEFT OUTER JOIN mfi_account_financing_droping AS droping ON droping.account_financing_no=pembiayaan.account_financing_no
		LEFT OUTER JOIN mfi_account_saving AS berencana ON (berencana.cif_no = cif.cif_no
			AND berencana.product_code = (select pberencana.product_code FROM mfi_product_saving AS pberencana WHERE pberencana.product_code = berencana.product_code AND pberencana.jenis_tabungan = 1)
		)
		WHERE cif.cm_code=? AND cif.cif_type=0 AND cif.status IN (1,3) 
		AND (CASE WHEN (select count(*) FROM mfi_account_financing WHERE cif.cif_no=mfi_account_financing.cif_no AND mfi_account_financing.status_rekening=1 and mfi_account_financing.financing_type='0') > 1 THEN droping.status_droping=1 ELSE 1=1 END)

		GROUP BY 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,38,39,40,41
		ORDER BY cif.kelompok::integer asc;
		";
		$query = $this->db->query($sql,array($tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$cm_code));
		// echo "<pre>";
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	//END VERIFIKASI ASURANSI

	/* BEGIN TRANSAKSI REMBUG **********************************************************/

	public function update_account_default_balance($data,$param)
	{
		$this->db->update('mfi_account_default_balance',$data,$param);
	}

	public function insert_trx_cm($data)
	{
		$this->db->insert('mfi_trx_cm',$data);
	}

	public function insert_trx_cm_detail($data)
	{
		$this->db->insert('mfi_trx_cm_detail',$data);
	}

	public function insert_trx_cm_detail2($data)
	{
		$this->db->insert('mfi_trx_cm_detail',$data);
	}

	public function get_gl_account($branch_code)
	{
		$sql = "select gl_account_id,account_code,account_name,account_type,account_group_code from mfi_gl_account";

		$param = array();

		if ($branch_code == '00000') {
			$sql .= " WHERE flag_akses != ? ";
			$param[] = 'C';
		} else {
			$sql .= " WHERE flag_akses != ? ";
			$param[] = 'P';
		}
		$sql.=" order by account_code,account_name asc";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	/* END TRANSAKSI REMBUG **********************************************************/


	/* BEGIN TRANSAKSI JURNAL **********************************************************/

	public function insert_trx_gl($data)
	{
		$this->db->insert("mfi_trx_gl",$data);
	}

	public function insert_trx_gl_detail($data)
	{
		$this->db->insert_batch("mfi_trx_gl_detail",$data);
	}

	/* END TRANSAKSI JURNAL **********************************************************/


	/* BEGIN GL ACCOUNT CASH **********************************************************/

	public function ajax_get_gl_account_cash()
	{
		$sql = "select 
				mfi_gl_account_cash.account_cash_id,
				mfi_gl_account_cash.account_cash_code,
				mfi_gl_account_cash.fa_code,
				mfi_fa.fa_name,
				mfi_gl_account_cash.account_cash_name,
				mfi_gl_account_cash.gl_account_code
				from mfi_gl_account_cash
				left join mfi_fa on mfi_fa.fa_code = mfi_gl_account_cash.fa_code
				";
		
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function insert_trx_gl_cash($data)
	{
		$this->db->insert('mfi_trx_gl_cash',$data);
	}

	public function insert_trx_gl_cash_detail($data)
	{
		$this->db->insert_batch('mfi_trx_gl_cash_detail',$data);
	}

	public function update_gl_account_cash($data,$param)
	{
		$this->db->update('mfi_gl_account_cash',$data,$param);
	}

	public function get_gl_account_cash_by_account_cash_id($account_cash_id)
	{
		$sql = "select * from mfi_gl_account_cash where account_cash_id = ?";
		$query = $this->db->query($sql,array($account_cash_id));

		return $query->row_array();
	}

	public function ajax_get_gl_account_cash_by_keyword($keyword,$branch_code='',$account_cash_type='')
	{
		$sql = "select 
				mfi_gl_account_cash.*
				,mfi_fa.fa_name
				,mfi_branch.branch_code
				,mfi_branch.branch_name
				,mfi_branch.branch_class
				from mfi_gl_account_cash 
				left join mfi_fa on mfi_fa.fa_code = mfi_gl_account_cash.fa_code
				left join mfi_branch on mfi_branch.branch_code=mfi_fa.branch_code
				where ((mfi_gl_account_cash.account_cash_code like ? or upper(mfi_gl_account_cash.account_cash_name) like ? or mfi_fa.fa_code like ? or upper(mfi_fa.fa_name) like ?))
			";
		$param[]='%'.$keyword.'%';
		$param[]='%'.strtoupper(strtolower($keyword)).'%';
		$param[]='%'.$keyword.'%';
		$param[]='%'.strtoupper(strtolower($keyword)).'%';
		if($branch_code!="00000"){
			$sql .= " and mfi_fa.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[]=$branch_code;
		}

		if($account_cash_type!=""){
			$sql .= " and mfi_gl_account_cash.account_cash_type = ?";
			$param[]=$account_cash_type;
		}

		$sql.=" order by mfi_fa.branch_code,fa_code asc";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		return $query->result_array();
	}

	public function ajax_get_cm_by_fa_code($fa_code)
	{
		$sql = "select * from mfi_cm where fa_code = ?";
		$query = $this->db->query($sql,array($fa_code));

		return $query->result_array();
	}

	public function insert_trx_gl_cash_detail_cm($data)
	{
		$this->db->insert_batch('mfi_trx_gl_cash_detail_cm',$data);
	}

	/* END GL ACCOUNT CASH **********************************************************/


	/* BEGIN VERIFICATION TRANSACTION **********************************************************/

	public function insert_trx_account_deposit($data)
	{
		$this->db->insert('mfi_trx_account_deposit',$data);
	}

	/* END VERIFICATION TRANSACTION **********************************************************/

	

	/* BEGIN PENDEBETAN ANGSURAN PEMBIAYAAN **********************************************************/

	public function get_data_pendebetan_angsuran_pembiayaan($tanggal_jto)
	{
		$sql = "
		select a.jtempo_angsuran_next,a.account_financing_no,c.nama,date_part('month', age(date(?), a.jtempo_angsuran_next) ) as freq_bayar,
		a.angsuran_pokok,a.angsuran_margin,a.angsuran_catab as angsuran_tabungan,(a.angsuran_pokok+a.angsuran_margin+a.angsuran_catab) angsuran,
		(b.saldo_memo-b.saldo_hold-e.saldo_minimal) as saldo_tabungan
		from mfi_account_financing a,mfi_account_saving b,mfi_cif c,mfi_product_financing d,mfi_product_saving e
		where a.account_saving_no=b.account_saving_no and a.cif_no=c.cif_no and e.product_code=b.product_code
		and a.product_code=d.product_code and d.jenis_pembiayaan=0
		and date_part('month', age(date(?), a.jtempo_angsuran_next) ) > 0
		";
		$query = $this->db->query($sql,array($tanggal_jto,$tanggal_jto));

		return $query->result_array();
	}

	public function get_account_financing_by_account_financing_no($account_financing_no)
	{
		$sql = "SELECT 
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.cif_type,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.product_code,
				mfi_account_financing.branch_code,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.dana_kebajikan,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.biaya_administrasi,
				mfi_account_financing.biaya_asuransi_jiwa,
				mfi_account_financing.biaya_asuransi_jaminan,
				mfi_account_financing.biaya_notaris,
				mfi_account_financing.sumber_dana,
				mfi_account_financing.dana_sendiri,
				mfi_account_financing.dana_kreditur,
				mfi_account_financing.ujroh_kreditur,
				mfi_account_financing.ujroh_kreditur_persen,
				mfi_account_financing.ujroh_kreditur_nominal,
				mfi_account_financing.ujroh_kreditur_carabayar,
				mfi_account_financing.tanggal_pengajuan,
				mfi_account_financing.tanggal_akad,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.jtempo_angsuran_last,
				mfi_account_financing.jtempo_angsuran_next,
				mfi_account_financing.rate_margin,
				mfi_account_financing.status_rekening,
				mfi_account_financing.tanggal_lunas,
				mfi_account_financing.status_kolektibilitas,
				mfi_account_financing.status_par,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.sektor_ekonomi,
				mfi_account_financing.peruntukan,
				mfi_account_financing.akad_code,
				mfi_account_financing.program_code,
				mfi_account_financing.flag_jadwal_angsuran,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.fa_code,
				mfi_account_financing.registration_no,
				mfi_account_financing.angsuran_tab_wajib,
				mfi_account_financing.kreditur_code,
				mfi_account_financing.angsuran_tab_kelompok,
				mfi_account_financing.uang_muka,
				mfi_account_financing.tanggal_registrasi,
				mfi_account_financing.jenis_jaminan,
				mfi_account_financing.flag_wakalah,
				mfi_account_financing.keterangan_jaminan,
				mfi_account_financing.nominal_taksasi,
				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.pembiayaan_ke,
				mfi_account_financing_reg.description,
				mfi_account_financing.financing_type,
				mfi_account_financing.peserta_asuransi,
				mfi_account_financing.tanggal_peserta_asuransi,
				mfi_account_financing.hubungan_peserta_asuransi,
				mfi_account_financing.flag_double_premi,
				mfi_account_financing.ktp_asuransi,
				mfi_cif.no_hp,
				mfi_cif_kelompok.p_no_hp,
				mfi_cm.cm_name,
				mfi_fa.fa_name,
				mfi_fa.fa_code
				FROM mfi_account_financing 
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_cif_kelompok ON mfi_cif_kelompok.cif_id = mfi_cif.cif_id
				LEFT JOIN mfi_cm ON mfi_cm.cm_code=mfi_cif.cm_code
				LEFT JOIN mfi_account_financing_reg ON mfi_account_financing_reg.registration_no=mfi_account_financing.registration_no
				LEFT JOIN mfi_fa ON mfi_fa.fa_code=mfi_account_financing.fa_code
				WHERE account_financing_no = ?
				";

		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function update_account_financing($data,$param)
	{
		$this->db->update("mfi_account_financing",$data,$param);
	}

	public function insert_trx_account_financing($data)
	{
		$this->db->insert("mfi_trx_account_financing",$data);
	}

	public function fn_get_saldoawal_kaspetugas($account_cash_code,$date,$type=0)
	{
		$sql = "select fn_get_saldoawal_kaspetugas(?,?,?) as val";
		$query = $this->db->query($sql,array($account_cash_code,$date,$type));
		$row = $query->row_array();
		return $row['val'];
	}

	public function delete_account_financing_schedulle($param2){
		$this->db->delete('mfi_account_financing_schedulle',$param2);
	}

	/* END PENDEBETAN ANGSURAN PEMBIAYAAN **********************************************************/

	public function insert_trx_cm_detail_droping($data)
	{
		$this->db->insert('mfi_trx_cm_detail_droping',$data);
	}


	/****************************************************************************************/	
	// BEGIN KAS PETUGAS
	/****************************************************************************************/

	function get_all_branch()
    {
        $sql = "SELECT * FROM  mfi_branch ";

		$query = $this->db->query($sql);

		return $query->result_array();
    }


	public function datatable_transaksi_kas_petugas($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$sql = "SELECT
						 mfi_trx_gl_cash.trx_gl_cash_id
						,mfi_trx_gl_cash.trx_date
						,mfi_trx_gl_cash.account_cash_code
						,mfi_trx_gl_cash.account_teller_code
						,mfi_trx_gl_cash.trx_gl_cash_type
						,mfi_trx_gl_cash.description
						,mfi_trx_gl_cash.amount
						,(SELECT
								mfi_gl_account_cash.account_cash_name
								FROM
								mfi_gl_account_cash
								WHERE account_cash_code = mfi_trx_gl_cash.account_cash_code
						 ) as kode_kas_petugas
						,(SELECT
								mfi_gl_account_cash.account_cash_name
								FROM
								mfi_gl_account_cash
								WHERE account_cash_code = mfi_trx_gl_cash.account_teller_code
						)	as kode_kas_teller	
				FROM
						mfi_trx_gl_cash 
				LEFT JOIN 
						mfi_gl_account_cash ON mfi_trx_gl_cash.account_cash_code=mfi_gl_account_cash.account_cash_code
				LEFT JOIN 
						mfi_fa ON mfi_gl_account_cash.fa_code = mfi_fa.fa_code
				";

		$param = array();

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mfi_trx_gl_cash.status=0";
		}else{
			$sql .= "WHERE mfi_trx_gl_cash.status=0";
		}

		if ($branch_code!="00000") {
			$sql .= " AND mfi_fa.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function datatable_verifikasi_transaksi_kas_petugas($sWhere='',$sOrder='',$sLimit='',$from_date='',$thru_date='',$branch_code='')
	{
		$sql = "SELECT
						 mfi_trx_gl_cash.trx_gl_cash_id
						,mfi_trx_gl_cash.trx_date
						,mfi_trx_gl_cash.account_cash_code
						,mfi_trx_gl_cash.account_teller_code
						,mfi_trx_gl_cash.trx_gl_cash_type
						,mfi_trx_gl_cash.description
						,mfi_trx_gl_cash.amount
						,(SELECT
								mfi_gl_account_cash.account_cash_name
								FROM
								mfi_gl_account_cash
								WHERE account_cash_code = mfi_trx_gl_cash.account_cash_code
						 ) as kode_kas_petugas
						,(SELECT
								mfi_gl_account_cash.account_cash_name
								FROM
								mfi_gl_account_cash
								WHERE account_cash_code = mfi_trx_gl_cash.account_teller_code
						)	as kode_kas_teller	
				FROM
						mfi_trx_gl_cash 
						LEFT JOIN mfi_gl_account_cash b ON b.account_cash_code=mfi_trx_gl_cash.account_teller_code
						LEFT JOIN mfi_fa c ON c.fa_code=b.fa_code
						";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mfi_trx_gl_cash.status=0";
		}else{
			$sql .= "WHERE mfi_trx_gl_cash.status=0";
		}

		$param = array();
		if($from_date!="--" && $thru_date!="--"){
			$sql.=" AND mfi_trx_gl_cash.trx_date between ? and ? ";
			$param[] = $from_date;
			$param[] = $thru_date;
		}

		if($branch_code!="00000"){
			$sql.=" AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[]=$branch_code;
		}

		$sql.=" ORDER BY mfi_trx_gl_cash.trx_date ASC ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	public function get_trx_by_trx_gl_cash_id($trx_gl_cash_id)
	{
		$sql = "select a.*,c.branch_code,d.branch_name,c.fa_name as account_cash_name, f.fa_name as account_teller_name 
				from mfi_trx_gl_cash a 
				left join mfi_gl_account_cash b on b.account_cash_code=a.account_cash_code
				left join mfi_fa c on c.fa_code=b.fa_code
				left join mfi_branch d on d.branch_code=c.branch_code
				left join mfi_gl_account_cash e on e.account_cash_code=a.account_teller_code
				left join mfi_fa f on f.fa_code=e.fa_code
				where a.trx_gl_cash_id=?
				"; 

		$query = $this->db->query($sql,array($trx_gl_cash_id));

		return $query->row_array();
	}


   	function get_fa_by_branch_code($branch_code)
    {
        $sql = "SELECT 
        					mfi_fa.fa_code
        					,mfi_fa.fa_name
        					,mfi_fa.branch_code
        					,mfi_gl_account_cash.account_cash_name
        					,mfi_gl_account_cash.account_cash_code
        					,mfi_gl_account_cash.gl_account_code
				FROM
							mfi_fa
				INNER JOIN mfi_gl_account_cash ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
        		WHERE mfi_fa.branch_code = ? AND account_cash_type='0' order by mfi_fa.fa_name asc ";

		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
    }


   	function get_account_cash_code_by_branch_code($branch_code)
    {
        $sql = "SELECT 
        					mfi_fa.fa_code
        					,mfi_fa.fa_name
        					,mfi_fa.branch_code
        					,mfi_gl_account_cash.account_cash_name
        					,mfi_gl_account_cash.account_cash_code
        					,mfi_gl_account_cash.gl_account_code
				FROM
							mfi_fa
				INNER JOIN mfi_gl_account_cash ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
        		WHERE mfi_fa.branch_code = ? AND account_cash_type='1' order by mfi_fa.fa_name asc";

		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
    }	

    function get_account_cash_code_fa()
    {
    	$sql = "SELECT 
        					mfi_fa.fa_code
        					,mfi_fa.fa_name
        					,mfi_fa.branch_code
        					,mfi_gl_account_cash.account_cash_name
        					,mfi_gl_account_cash.account_cash_code
        					,mfi_gl_account_cash.gl_account_code
				FROM
							mfi_fa
				INNER JOIN mfi_gl_account_cash ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
        		WHERE account_cash_type='0' ";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

    function get_account_cash_code_teller()
    {
    	$sql = "SELECT 
        					mfi_fa.fa_code
        					,mfi_fa.fa_name
        					,mfi_fa.branch_code
        					,mfi_gl_account_cash.account_cash_name
        					,mfi_gl_account_cash.account_cash_code
        					,mfi_gl_account_cash.gl_account_code
				FROM
							mfi_fa
				INNER JOIN mfi_gl_account_cash ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
        		WHERE account_cash_type='1' ";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

	public function add_kas_petugas($data)
	{
		$this->db->insert('mfi_trx_gl_cash',$data);
	}
	
	public function edit_kas_petugas($data,$param)
	{
		$this->db->update('mfi_trx_gl_cash',$data,$param);
	}

	public function delete_kas_petugas($param)
	{
		$this->db->delete('mfi_trx_gl_cash',$param);
	}	

	public function update_status_gl_cash($data2,$param)
	{
		$this->db->update('mfi_trx_gl_cash',$data2,$param);
	}

	public function insert_mfi_trx_gl($data)
	{
		$this->db->insert('mfi_trx_gl',$data);
	}

	public function insert_mfi_trx_gl_detail($data3)
	{
		$this->db->insert('mfi_trx_gl_detail',$data3);
	}

	/****************************************************************************************/	
	// END KAS PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN TABUNGAN BERENCANA
	/****************************************************************************************/

	public function get_tabungan_berencana_by_cif_no($cif_no)
	{
		$sql = "select 
					mfi_account_saving.*
					,mfi_product_saving.product_name
					,mfi_product_saving.product_code 
					,mfi_product_saving.nick_name
				from 
					mfi_account_saving
				left join mfi_product_saving on (mfi_product_saving.product_code = mfi_account_saving.product_code)
				left join mfi_cif on mfi_cif.cif_no=mfi_account_saving.cif_no
				where 
					mfi_product_saving.jenis_tabungan = 1
					and mfi_account_saving.cif_no = ?
					and mfi_account_saving.status_rekening = 1
					and mfi_cif.status = 1
			   ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->result_array();
	}
	public function get_tabungan_berencana_by_cif_no2($cif_no,$account_financing_no)
	{
		$sql = "select 
					mfi_account_saving.account_saving_id
					,mfi_account_saving.product_code
					,mfi_account_saving.cif_no
					,mfi_account_saving.account_saving_no
					,mfi_account_saving.branch_code
					,mfi_account_saving.tanggal_buka
					,mfi_account_saving.status_rekening
					,mfi_account_saving.saldo_riil
					,mfi_account_saving.saldo_memo
					,mfi_account_saving.saldo_hold
					,mfi_account_saving.saldo_last_day
					,mfi_account_saving.saldo_last_month
					,mfi_account_saving.akumulasi_saldo_harian
					,mfi_account_saving.akumulasi_hari_proses
					,mfi_account_saving.rencana_setoran
					,mfi_account_saving.rencana_periode_setoran
					,mfi_account_saving.rencana_setoran_last
					,mfi_account_saving.rencana_setoran_next
					,mfi_account_saving.rencana_kontrak
					,mfi_account_saving.rencana_awal_kontrak
					,mfi_account_saving.rencana_akhir_kontrak
					,mfi_account_saving.created_by
					,mfi_account_saving.created_date
					,mfi_account_saving.rencana_jangka_waktu
					,mfi_account_saving.counter_angsruan
					,mfi_product_saving.product_name
				from 
					mfi_account_saving
				left join mfi_product_saving on (mfi_product_saving.product_code = mfi_account_saving.product_code)
				left join mfi_account_financing on mfi_account_financing.cif_no=mfi_account_saving.cif_no and mfi_account_financing.account_financing_no=?
				left join mfi_account_financing_droping on mfi_account_financing_droping.account_financing_no=mfi_account_financing.account_financing_no
				where 
					mfi_product_saving.jenis_tabungan = 1
					and mfi_account_saving.cif_no = ?
					and mfi_account_saving.status_rekening = 1
					and mfi_account_financing_droping.status_droping = 1
			   ";
		$query = $this->db->query($sql,array($account_financing_no,$cif_no));

		return $query->result_array();
	}
	public function get_tabungan_berencana_by_cif_no3($cif_no)
	{
		$sql = "select 
					mfi_account_saving.*
					,mfi_product_saving.product_name
					,mfi_product_saving.product_code 
					,mfi_product_saving.nick_name
				from 
					mfi_account_saving
				left join mfi_product_saving on (mfi_product_saving.product_code = mfi_account_saving.product_code)
				left join mfi_cif on mfi_cif.cif_no=mfi_account_saving.cif_no
				where 
					mfi_product_saving.jenis_tabungan = 1
					and mfi_account_saving.cif_no = ?
					and mfi_account_saving.status_rekening = 1
					and mfi_cif.status = 1
					and mfi_account_saving.product_code <> '0006'
			   ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->result_array();
	}

	/**
	* untuk mencari data tabungan berdasarkan cif_no
	* jumlah record yg di return = 1 record
	* @param cif_no
	*/

	public function get_account_saving_by_cif_no($cif_no)
	{
		$sql = "select * from mfi_account_saving where cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	//Function untuk mencari get grace produk kelompok di tabel mfi_institution
	public function get_grace_periode_kelompok()
	{
		$sql = "select * from mfi_institution";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_ajax_produk_by_cif_type0()
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.jenis_pembiayaan
				FROM
				mfi_product_financing
				WHERE jenis_pembiayaan = '1'
				";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_ajax_produk_by_cif_type1()
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.jenis_pembiayaan
				FROM
				mfi_product_financing
				WHERE jenis_pembiayaan = '0'
				";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	public function check_account_financing_no($account_financing_no)
	{
		$sql = "select count(*) as num from mfi_account_financing where account_financing_no = ? AND status_rekening='1'";
		$query = $this->db->query($sql,array($account_financing_no));

		$row = $query->row_array();
		if($row['num']>0){
			return false;
		}else{
			return true;
		}
	}

	public function date_current()
	{
		$sql = "SELECT date_current from mfi_date_transaction ORDER BY date_current DESC LIMIT 1";
		$query = $this->db->query($sql);

		$row = $query->row_array();
		return $row['date_current'];
	}

	public function get_ajax_produk_by_cif_type_link_edit1()
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.jenis_pembiayaan
				FROM
				mfi_product_financing
				WHERE jenis_pembiayaan = '0'
				";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function set_saving_by_saving_no($account_saving_no){
		$sql = "SELECT
		mps.product_name
		FROM mfi_account_saving AS mas
		LEFT JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		WHERE mas.account_saving_no = ?";

		$param = array($account_saving_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function get_ajax_produk_by_product_code($product_code){
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.jenis_pembiayaan
				FROM
				mfi_product_financing
				WHERE product_code = ?
				";

		$param = array($product_code);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	public function get_ajax_produk_by_cif_type_link_edit0()
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.jenis_pembiayaan
				FROM
				mfi_product_financing
				WHERE jenis_pembiayaan = '1'
				";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	//Fungsi Mencari No Registrasi Pembiayaan pada tabel mfi_account_financing_reg
	public function search_no_reg($keyword,$type,$cm_code)
	{
		$branch_code=$this->session->userdata('branch_code');
		$sql = "select 
				mfi_account_financing_reg.registration_no,
				mfi_cif.nama, 
				mfi_cif.cif_no, 
				mfi_cm.cm_name,
				mfi_fa.fa_code,
				mfi_fa.fa_name
				from mfi_account_financing_reg 
				inner join mfi_cif ON mfi_cif.cif_no = mfi_account_financing_reg.cif_no and mfi_account_financing_reg.status = '0'
				left join mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				left join mfi_fa ON mfi_fa.fa_code = mfi_cm.fa_code
				where (upper(mfi_cif.nama) like ? or mfi_account_financing_reg.cif_no like ?)";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		
		if($type!="") {

			$sql 	.= ' and mfi_cif.cif_type = ?';
			$param[] = $type;

		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}

		if($branch_code!="00000"){
			$sql .= " and mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[]=$branch_code;
		}

		// print_r($this->db);
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_ajax_value_from_no_reg($no_reg)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.cm_code,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.cif_type,
				mfi_cif.branch_code,
				mfi_cif.no_hp,

				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.uang_muka,
				mfi_account_financing_reg.peruntukan,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_account_financing_reg.rencana_droping,
				mfi_account_financing_reg.pembiayaan_ke,
				mfi_account_financing_reg.description,
				mfi_account_financing_reg.financing_type,

				mfi_cm.cm_name,

				mfi_cif_kelompok.p_no_hp
				FROM
				mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing_reg.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code=mfi_cif.cm_code
				left join mfi_cif_kelompok on mfi_cif.cif_id = mfi_cif_kelompok.cif_id 
        		WHERE mfi_account_financing_reg.registration_no = ?";
		$query = $this->db->query($sql,array($no_reg));

		return $query->row_array();
	}

	public function update_status_pengajuan_pembiayaan($data_reg,$param_reg)
	{
		$this->db->update('mfi_account_financing_reg',$data_reg,$param_reg);
	}

	public function update_no_hp($datasa)
	{
		$this->db->update('mfi_cif',$datasa);
	}
	public function update_p_no_hp($datasas)
	{
		$this->db->update('mfi_cif_kelompok',$datasas);
	}

	//Fungsi Untuk memanggil status rekening pembiayaan

	
	public function get_status_rekening_from_account_financing($account_financing_no)
	{
		$sql = "SELECT
				status_rekening
				FROM
				mfi_account_financing
				WHERE account_financing_no = ? ";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function datatable_verifikasi_trx_rembug($sWhere='',$sOrder='',$sLimit='',$branch_id='',$branch_code='',$trx_date='')
	{

		$sql = "SELECT 
				mfi_trx_cm_save.trx_cm_save_id
				,mfi_trx_cm_save.infaq
				,mfi_trx_cm_save.kas_awal
				,mfi_trx_cm_save.branch_id
				,mfi_trx_cm_save.cm_code
				,mfi_trx_cm_save.trx_date
				,mfi_trx_cm_save.account_cash_code
				,mfi_trx_cm_save.fa_code
				,mfi_branch.branch_name
				,mfi_branch.branch_code
				,mfi_gl_account_cash.account_cash_name
				,mfi_cm.cm_name
				,mfi_fa.fa_name
				from mfi_trx_cm_save
				left join mfi_branch on mfi_branch.branch_id = mfi_trx_cm_save.branch_id
				left join mfi_gl_account_cash on mfi_gl_account_cash.account_cash_code = mfi_trx_cm_save.account_cash_code
				left join mfi_cm on mfi_cm.cm_code = mfi_trx_cm_save.cm_code
				left join mfi_fa on mfi_fa.fa_code = mfi_trx_cm_save.fa_code
		";

		$param = array();
		if ( $sWhere != "" ){
			$sql .= "$sWhere ";

			if($branch_code!="00000"){
				$sql .= " AND mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
			}

			if($trx_date!=""){
				$sql .= " AND mfi_trx_cm_save.trx_date = ? ";
				$param[] = $trx_date;
			}

		}else{

			if($branch_code!="00000"){
				$sql .= " WHERE mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
			}

			if($trx_date!=""){
				if($branch_code!="00000"){
					$sql .= " AND ";
				}else{
					$sql .= " WHERE ";
				}
				$sql .= "  mfi_trx_cm_save.trx_date = ? ";
				$param[] = $trx_date;
			}
		}


		if ( $sOrder != "" )
			$sql .= "order by fa_name,cm_name,mfi_trx_cm_save.created_date asc";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function search_branch_by_keyword($keyword)
	{
		$branch_code=$this->session->userdata('branch_code');
		$sql = "select * from mfi_branch where (UPPER(branch_name) like ? or branch_code like ?)";
		$param[]='%'.strtoupper(strtolower($keyword)).'%';
		$param[]='%'.$keyword.'%';
		if($branch_code!="00000"){
			$sql.=" and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[]=$branch_code;
		}
		$sql.=" order by branch_code asc";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function insert_trx_cm_save($data)
	{
		$this->db->insert('mfi_trx_cm_save',$data);
	}

	public function insert_trx_cm_save_detail($data)
	{
		$this->db->insert_batch('mfi_trx_cm_save_detail',$data);
	}

	public function insert_trx_cm_save_berencana($data)
	{
		$this->db->insert_batch('mfi_trx_cm_save_berencana',$data);
	}

	public function get_trx_cm_save_detail($trx_cm_save_id,$cm_code)
	{
		/*$sql = "select 
					mfi_trx_cm_save_detail.* 
				from 
					mfi_trx_cm_save_detail, 
					mfi_cif 
				where 
					mfi_trx_cm_save_detail.cif_no = mfi_cif.cif_no and
					mfi_trx_cm_save_detail.trx_cm_save_id = ? 
				order by 
					mfi_cif.kelompok::integer 
					asc
				";*/
		$sql = "SELECT
		a.cif_no,
		b.account_financing_no,
		c.trx_cm_save_detail_id,
		c.trx_cm_save_id,
		c.absen,
		COALESCE(c.frekuensi,0) AS frekuensi,
		COALESCE(c.setoran_tab_sukarela,0) AS setoran_tab_sukarela,
		COALESCE(c.setoran_lwk,0) AS setoran_lwk,
		COALESCE(c.setoran_mingguan,0) AS setoran_mingguan,
		c.penarikan_tab_sukarela,
		COALESCE(c.kas_awal,0) AS kas_awal,
		COALESCE(c.infaq,0) AS infaq,
		c.created_by,
		c.created_stamp,
		COALESCE(c.status_angsuran_margin,0) AS status_angsuran_margin,
		COALESCE(c.status_angsuran_catab,0) AS status_angsuran_catab,
		COALESCE(c.status_angsuran_tab_wajib,0) AS status_angsuran_tab_wajib,
		COALESCE(c.status_angsuran_tab_kelompok,0) AS status_angsuran_tab_kelompok,
		COALESCE(c.muqosha,0) AS muqosha,
		c.keterangan
		FROM mfi_cif a
		LEFT JOIN mfi_account_financing b ON b.cif_no=a.cif_no AND b.status_rekening=1 AND b.financing_type = '0'
		LEFT JOIN mfi_account_financing_droping droping ON b.account_financing_no=droping.account_financing_no
		LEFT JOIN mfi_trx_cm_save_detail c ON (c.account_financing_no=b.account_financing_no or c.cif_no=a.cif_no) AND c.trx_cm_save_id=?
		WHERE a.cm_code=? AND a.cif_type=0 AND a.status in (1,3)
		AND (CASE WHEN (SELECT count(*) FROM mfi_account_financing WHERE a.cif_no=mfi_account_financing.cif_no AND mfi_account_financing.status_rekening=1 AND mfi_account_financing.financing_type = '0') > 1 THEN droping.status_droping=1 ELSE 1=1 END)
		order by a.kelompok::integer asc";
		$query = $this->db->query($sql,array($trx_cm_save_id,$cm_code));
		return $query->result_array();
	}

	public function get_trx_cm_save_berencana($trx_cm_save_detail_id)
	{
		$sql = "select trx_cm_save_berencana_id,trx_cm_save_detail_id,account_saving_no,amount,frekuensi from mfi_trx_cm_save_berencana where trx_cm_save_detail_id = ?";
		$query = $this->db->query($sql,array($trx_cm_save_detail_id));

		return $query->result_array();
	}

	public function delete_trx_cm_save($param)
	{
		$this->db->delete('mfi_trx_cm_save',$param);
	}

	public function delete_trx_cm_save_berencana($param)
	{
		$this->db->delete('mfi_trx_cm_save_berencana',$param);
	}

	public function delete_trx_cm_save_detail($param)
	{
		$this->db->delete('mfi_trx_cm_save_detail',$param);
	}

	public function get_trx_cm_save_by_param($param)
	{
		$sql = "select * from mfi_trx_cm_save where 
				branch_id = ? and
				cm_code = ? and
				trx_date = ? and 
				account_cash_code = ?
		";
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_saldo_tab_sukarela($cif_no)
	{
		$sql = "select tabungan_sukarela from mfi_account_default_balance where cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function update_account_financing_droping($data,$param)
	{
		$this->db->update('mfi_account_financing_droping',$data,$param);
	}

	public function get_account_financing_droping($account_financing_no,$tanggal)
	{
		$sql = "select COUNT(*) AS jumlah from mfi_account_financing_droping where account_financing_no = ? AND status_droping = '0' AND droping_date = ?";
		$query = $this->db->query($sql,array($account_financing_no,$tanggal));

		return $query->row_array();
	}

	/**
	* PROSES JURNAL OTOMATIS
	*/
	public function proses_jurnal_otomatis($from_date,$thru_date)
	{
		$sql = "select fn_proses_jurnal_trx(?, ?)";
		$query = $this->db->query($sql,array($from_date,$thru_date));
	}

	/**
	* PROSES CLOSING
	*/
	public function proses_closing()
	{
		/* do proses closing function */
	}

	//Proses dapatkan account_saving
	public function get_value_lap_rek_tab($cif_no)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_account_saving.account_saving_no
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				WHERE mfi_cif.cif_no like ?
				";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function search_account_deposit_no($keyword='',$cif_type='',$cm_code='')
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_deposit.cif_no,
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.product_code,
				mfi_account_deposit.status_rekening,
				mfi_product_deposit.product_name
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				INNER JOIN mfi_product_deposit ON mfi_product_deposit.product_code = mfi_account_deposit.product_code
				WHERE (UPPER(nama) like ? or account_deposit_no like ?)
				";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($cif_type!=""){
			$sql .= " and cif_type = ? ";
			$param[] = $cif_type;
		}

		if($cm_code!=""){
			$sql .= " and cm_code = ? ";
			$param[] = $cm_code;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_account_deposit($cif_no)
	{
		$sql = "SELECT account_deposit_no, account_deposit_id FROM mfi_account_deposit WHERE cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->result_array();
	}

	function get_account_saving($cif_no){
		$sql = "SELECT
		mps.product_name,
		mas.account_saving_no,
		mas.account_saving_id
		FROM mfi_account_saving AS mas
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		WHERE mas.cif_no = ?";

		$param = array($cif_no);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_account_saving_individu($cif_no){
		$sql = "SELECT
		mps.product_name,
		mas.account_saving_no,
		mas.account_saving_id
		FROM mfi_account_saving AS mas
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		WHERE mas.cif_no = ? AND mps.product_type = '1'";

		$param = array($cif_no);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	//Proses dapatkan account_saving
	public function get_value_lap_rek_dep($cif_no)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_account_deposit.account_deposit_no
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				where mfi_cif.cif_no like ?
				";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	//BEGIN PEMBAYARAN ANGSURAN
	function get_cif_for_pembayaran_angsuran($account_financing_no){
		$sql = "SELECT
		mc.nama,
		maf.account_financing_id,
		maf.branch_code,
		maf.cadangan_resiko,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.angsuran_catab,
		maf.angsuran_tab_wajib,
		maf.angsuran_tab_kelompok,
		maf.account_saving_no,
		maf.pokok,
		maf.margin,
		maf.jangka_waktu,
		maf.periode_jangka_waktu,
		maf.account_financing_no,
		maf.tanggal_jtempo,
		maf.jtempo_angsuran_next,
		maf.saldo_pokok,
		maf.saldo_catab,
		maf.saldo_margin,
		maf.counter_angsuran,
		mpf.product_name,
		mas.saldo_memo,
		mas.account_saving_id,
		mfi_branch.branch_id,
		(maf.angsuran_pokok+maf.angsuran_margin+maf.cadangan_resiko) AS total_angsuran
		FROM mfi_account_financing AS maf
		LEFT JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		LEFT JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_account_saving AS mas ON mas.account_saving_no = maf.account_saving_no
		LEFT JOIN mfi_branch ON mfi_branch.branch_code = maf.branch_code
		WHERE maf.account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	function get_cif_for_pembayaran_angsuran_non_reguler($account_financing_no){
		$sql = "SELECT
		c.nama, 
		a.account_financing_id, 
		a.branch_code, 
		a.cadangan_resiko, 
		b.angsuran_pokok, 
		b.angsuran_margin, 
		b.angsuran_tabungan,
		a.account_saving_no,
		a.pokok,a.margin,
		a.jangka_waktu,
		a.periode_jangka_waktu,
		a.account_financing_no,
		b.tangga_jtempo as tanggal_jtempo, 
		a.saldo_pokok, 
		a.saldo_catab, 
		a.saldo_margin, 
		e.product_name, 
		d.saldo_memo, 
		d.account_saving_id, 
		b.tanggal_bayar, 
		(b.angsuran_pokok-b.bayar_pokok) bayar_pokok, 
		(b.angsuran_margin-b.bayar_margin) bayar_margin, 
		(b.angsuran_tabungan-b.bayar_tabungan) bayar_tabungan,
		b.bayar_pokok as byr_pokok,
		b.bayar_margin as byr_margin,
		b.account_financing_schedulle_id,
		f.branch_id
		from mfi_account_financing a, mfi_account_financing_schedulle b, mfi_cif c, mfi_account_saving d, mfi_product_financing e, mfi_branch f
		where a.account_financing_no=b.account_no_financing and a.cif_no=c.cif_no 
		and a.account_saving_no=d.account_saving_no and a.product_code=e.product_code
		and f.branch_code=a.branch_code
		and b.status_angsuran=0 and a.flag_jadwal_angsuran=0 and a.account_financing_no = ?
		order by b.tangga_jtempo asc limit 1
			   ";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function get_flag_jadwal_angsuran($account_financing_no)
	{
		$sql ="select flag_jadwal_angsuran from mfi_account_financing where account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	public function get_flag_jadwal($account_financing_id)
	{
		$sql ="select flag_jadwal_angsuran from mfi_account_financing where account_financing_id = ?";
		$query = $this->db->query($sql,array($account_financing_id));
		$row = $query->row_array();
		return $row['flag_jadwal_angsuran'];
	}
	
	public function insert_mfi_trx_account_financing($data1)
	{
		$this->db->insert('mfi_trx_account_financing',$data1);
	}
	
	public function update_mfi_account_financing($data2,$param2)
	{
		$this->db->update('mfi_account_financing',$data2,$param2);
	}
	
	public function update_mfi_account_saving($data3,$param3)
	{
		$this->db->update('mfi_account_saving',$data3,$param3);
	}
	
	public function insert_mfi_trx_account_tabungan($data4)
	{
		$this->db->insert('mfi_trx_account_saving',$data4);
	}
	
	public function insert_on_mfi_trx_detail($data5)
	{
		$this->db->insert('mfi_trx_detail',$data5);
	}
	
	public function update_on_financing_schedulle($data6,$param6)
	{
		$this->db->update('mfi_account_financing_schedulle',$data6,$param6);
	}

	public function get_trx_sequence($no_rekening)
	{
		$sql = "select max(trx_sequence) as sequence from mfi_trx_detail where account_no = ?";
		$query = $this->db->query($sql,array($no_rekening));
		$row = $query->row_array();
		return $row['sequence'];
	}

	//Verifikasi Transaksi
	function grid_verifikasi_transaksi($sidx='',$sord='',$limit_rows='',$start='',$no_rekening=''){
		$order = '';
		$limit = '';
		$param = array();

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		// TABUNGAN
		$sql = "SELECT 
				mfi_trx_account_saving.trx_account_saving_id AS id_transaksi,
				mfi_cif.cif_no AS no_cif,
				'Tabungan' AS jenis_transaksi,
				mfi_trx_account_saving.trx_date AS tgl_transaksi,
				mfi_trx_account_saving.account_saving_no AS no_rekening,
				mfi_cif.nama AS nama_cif,
				mfi_cm.cm_name,
				mgac.account_cash_name,
				mfi_trx_account_saving.trx_saving_type AS keterangan,
				mfi_trx_account_saving.amount AS jumlah
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_trx_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				LEFT JOIN mfi_gl_account_cash AS mgac ON mgac.account_cash_code = mfi_trx_account_saving.account_cash_code
				WHERE mfi_trx_account_saving.account_saving_no LIKE ? AND mfi_trx_account_saving.trx_status !='1'
				AND mfi_trx_account_saving.trx_saving_type IN('1','2')";
		$param[] = "%".$no_rekening."%";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		// PEMBIAYAAN
		$sql .=	"UNION ALL
			SELECT 
			mfi_trx_account_financing.trx_account_financing_id AS id_transaksi,
			mfi_cif.cif_no AS no_cif,
			'Pembiayaan' AS jenis_transaksi,
			mfi_trx_account_financing.trx_date AS tgl_transaksi,
			mfi_trx_account_financing.account_financing_no AS no_rekening,
			mfi_cif.nama AS nama_cif,
			mfi_cm.cm_name,
			mgac.account_cash_name,
			mfi_trx_account_financing.trx_financing_type AS keterangan,
			(mfi_trx_account_financing.pokok+mfi_trx_account_financing.margin+mfi_trx_account_financing.catab+mfi_trx_account_financing.tab_wajib+mfi_trx_account_financing.tab_kelompok) AS jumlah
			FROM
			mfi_trx_account_financing
			JOIN mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_trx_account_financing.account_financing_no
			JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
			JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
			JOIN mfi_gl_account_cash AS mgac ON mgac.account_cash_code = mfi_trx_account_financing.account_cash_code
			WHERE mfi_trx_account_financing.account_financing_no LIKE ?
			AND mfi_trx_account_financing.trx_status = '0'
			AND mfi_trx_account_financing.trx_financing_type = '1'";
		$param[] = "%".$no_rekening."%";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		// SMK
		$sql .=	"UNION ALL
			SELECT 
			mfi_trx_smk.trx_smk_id AS id_transaksi,
			mfi_smk.cif_no AS no_cif,
			'SMK' AS jenis_transaksi,
			mfi_trx_smk.trx_date AS tgl_transaksi,
			mfi_smk.sertifikat_no AS no_rekening,
			mfi_smk.nama AS nama_cif,
			mfi_cm.cm_name,
			mgac.account_cash_name,
			mfi_trx_smk.trx_type AS keterangan,
			-- (case when mfi_trx_smk.trx_type = 0 then 'Pinbuk' else 'Tunai' end) AS keterangan,
			mfi_smk.nominal AS jumlah
			FROM
			mfi_trx_smk
			LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_trx_smk.cif_no
			LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
			LEFT JOIN mfi_gl_account_cash AS mgac ON mgac.account_cash_code = mfi_trx_smk.account_cash_code
			INNER JOIN mfi_smk ON mfi_smk.trx_smk_code = mfi_trx_smk.trx_smk_code
			AND mfi_smk.status = '1'
			WHERE mfi_smk.sertifikat_no LIKE ? AND mfi_trx_smk.trx_status !='1'
			";
		$param[] = "%".$no_rekening."%";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function grid_verifikasi_transaksi_tabungan($sidx='',$sord='',$limit_rows='',$start='',$no_rekening='')
	{
		$order = '';
		$limit = '';
		$param = array();

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
				mfi_trx_account_saving.trx_account_saving_id AS id_transaksi,
				mfi_cif.cif_no AS no_cif,
				'Tabungan' AS jenis_transaksi,
				mfi_trx_account_saving.trx_date AS tgl_transaksi,
				mfi_trx_account_saving.account_saving_no AS no_rekening,
				mfi_cif.nama AS nama_cif,
				mfi_cm.cm_name,
				mgac.account_cash_name,
				mfi_trx_account_saving.trx_saving_type AS keterangan,
				mfi_trx_account_saving.amount AS jumlah
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_trx_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				LEFT JOIN mfi_gl_account_cash AS mgac ON mgac.account_cash_code = mfi_trx_account_saving.account_cash_code
				WHERE mfi_trx_account_saving.account_saving_no LIKE ? AND mfi_trx_account_saving.trx_status !='1'
				AND mfi_trx_account_saving.trx_saving_type IN('1','2')";
		$param[] = "%".$no_rekening."%";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function grid_verifikasi_transaksi_pembiayaan($sidx='',$sord='',$limit_rows='',$start='',$no_rekening='')
	{
		$order = '';
		$limit = '';
		$param = array();

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
				mfi_trx_account_financing.trx_account_financing_id AS id_transaksi,
				mfi_cif.cif_no AS no_cif,
				'Pembiayaan' AS jenis_transaksi,
				mfi_trx_account_financing.trx_date AS tgl_transaksi,
				mfi_trx_account_financing.account_financing_no AS no_rekening,
				mfi_cif.nama AS nama_cif,
				mfi_cm.cm_name,
				mgac.account_cash_name,
				mfi_trx_account_financing.trx_financing_type AS keterangan,
				(mfi_trx_account_financing.pokok+mfi_trx_account_financing.margin+mfi_trx_account_financing.catab+mfi_trx_account_financing.tab_wajib+mfi_trx_account_financing.tab_kelompok) AS jumlah
				FROM
				mfi_trx_account_financing
				JOIN mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_trx_account_financing.account_financing_no
				JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				JOIN mfi_gl_account_cash AS mgac ON mgac.account_cash_code = mfi_trx_account_financing.account_cash_code
				WHERE mfi_trx_account_financing.account_financing_no LIKE ?
				AND mfi_trx_account_financing.trx_status = '0'
				AND mfi_trx_account_financing.trx_financing_type = '1'";
		$param[] = "%".$no_rekening."%";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function grid_verifikasi_transaksi_old($sidx='',$sord='',$limit_rows='',$start='',$no_rekening='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
				mfi_trx_account_saving.trx_account_saving_id AS id_transaksi,
				mfi_cif.cif_no AS no_cif,
				'Tabungan' AS jenis_transaksi,
				mfi_trx_account_saving.trx_date AS tgl_transaksi,
				mfi_trx_account_saving.account_saving_no AS no_rekening,
				mfi_cif.nama AS nama_cif,
				mfi_trx_account_saving.trx_saving_type AS keterangan,
				mfi_trx_account_saving.amount AS jumlah
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_trx_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				WHERE mfi_trx_account_saving.account_saving_no LIKE ? AND mfi_trx_account_saving.trx_status !='1' AND mfi_cif.cif_type = '1'
				UNION ALL

				SELECT 
				mfi_trx_account_financing.trx_account_financing_id AS id_transaksi,
				mfi_cif.cif_no AS no_cif,
				'Pembiayaan' AS jenis_transaksi,
				mfi_trx_account_financing.trx_date AS tgl_transaksi,
				mfi_trx_account_financing.account_financing_no AS no_rekening,
				mfi_cif.nama AS nama_cif,
				mfi_trx_account_financing.trx_financing_type AS keterangan,
				(mfi_trx_account_financing.pokok+mfi_trx_account_financing.margin+mfi_trx_account_financing.catab)*mfi_trx_account_financing.freq AS jumlah
				FROM
				mfi_trx_account_financing
				INNER JOIN mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_trx_account_financing.account_financing_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				WHERE mfi_trx_account_financing.account_financing_no LIKE ? AND mfi_trx_account_financing.trx_status !='1' AND mfi_cif.cif_type = '1'
				UNION ALL

				SELECT 
				mfi_trx_smk.trx_smk_id AS id_transaksi,
				mfi_smk.cif_no AS no_cif,
				'SMK' AS jenis_transaksi,
				mfi_trx_smk.trx_date AS tgl_transaksi,
				mfi_smk.sertifikat_no AS no_rekening,
				mfi_smk.nama AS nama_cif,
				mfi_trx_smk.trx_type AS keterangan,
				-- (case when mfi_trx_smk.trx_type = 0 then 'Pinbuk' else 'Tunai' end) AS keterangan,
				mfi_smk.nominal AS jumlah
				FROM
				mfi_trx_smk
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_trx_smk.cif_no
				AND mfi_cif.cif_type = '1'
				INNER JOIN mfi_smk ON mfi_smk.trx_smk_code = mfi_trx_smk.trx_smk_code
				AND mfi_smk.status = '1'
				WHERE mfi_smk.sertifikat_no LIKE ? AND mfi_trx_smk.trx_status !='1'
				";

			$param[] = "%".$no_rekening."%";
			$param[] = "%".$no_rekening."%";
			$param[] = "%".$no_rekening."%";

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		return $query->result_array();
	}

	public function get_no_rekening($keyword)
	{
		$sql = "

		SELECT
		mfi_account_financing.account_financing_no AS no_rekening,
		mfi_cif.nama AS nama_cif,
		'PEMBIAYAAN' AS jenis_transaksi
		FROM
		mfi_account_financing,mfi_cif 
		WHERE mfi_cif.cif_no = mfi_account_financing.cif_no
		AND (upper(mfi_cif.nama) like ? or mfi_account_financing.account_financing_no like ?)

		UNION ALL

		SELECT
		mfi_account_saving.account_saving_no AS no_rekening,
		mfi_cif.nama AS nama_cif,
		'TABUNGAN' AS jenis_transaksi
		FROM
		mfi_account_saving,mfi_cif 
		WHERE mfi_cif.cif_no = mfi_account_saving.cif_no
		AND (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?)

		UNION ALL

		SELECT
		mfi_smk.sertifikat_no AS no_rekening,
		mfi_cif.nama AS nama_cif,
		'SMK' AS jenis_transaksi
		FROM
		mfi_smk,mfi_cif 
		WHERE mfi_cif.cif_no = mfi_smk.cif_no
		AND (upper(mfi_cif.nama) like ? or mfi_smk.sertifikat_no like ?)

		";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function aktivasi_transaksi_saving($data,$param)
	{
		$this->db->update('mfi_trx_account_saving',$data,$param);
	}
	
	public function aktivasi_transaksi_financing($data,$param)
	{
		$this->db->update('mfi_trx_account_financing',$data,$param);
	}
	
	public function aktivasi_transaksi_smk($data,$param)
	{
		$this->db->update('mfi_trx_smk',$data,$param);
	}

	public function detail_transaksi_tabungan($id)
	{
		$sql = "SELECT
				mfi_branch.branch_name AS nama_cabang,
				mfi_cif.nama AS nama_cif,
				mfi_trx_account_saving.account_saving_no AS no_rekening,
				mfi_trx_account_saving.trx_saving_type AS tipe_transaksi,
				mfi_trx_account_saving.trx_date AS tgl_transaksi,
				mfi_trx_account_saving.amount AS jumlah,
				mfi_trx_account_saving.reference_no AS no_referensi,
				mfi_trx_account_saving.description AS keterangan
				FROM 
				mfi_trx_account_saving
				INNER JOIN mfi_branch ON mfi_branch.branch_id = mfi_trx_account_saving.branch_id
				INNER JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_trx_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				WHERE mfi_trx_account_saving.trx_account_saving_id  = ?
				";

		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function detail_transaksi_pembiayaan($id)
	{
		$sql = "SELECT
				mfi_branch.branch_name,
				mfi_cif.nama,
				mfi_trx_account_financing.account_financing_no,
				mfi_trx_account_financing.trx_financing_type,
				mfi_trx_account_financing.trx_date,
				mfi_trx_account_financing.jto_date,
				mfi_trx_account_financing.pokok,
				mfi_trx_account_financing.margin,
				mfi_trx_account_financing.catab,
				mfi_trx_account_financing.reference_no,
				mfi_trx_account_financing.tab_wajib,
				mfi_trx_account_financing.tab_sukarela,
				mfi_trx_account_financing.freq,
				mfi_trx_account_financing.description
				FROM
				mfi_trx_account_financing
				INNER JOIN mfi_branch ON mfi_branch.branch_id = mfi_trx_account_financing.branch_id
				INNER JOIN mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_trx_account_financing.account_financing_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				WHERE mfi_trx_account_financing.trx_account_financing_id  = ?
				";

		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function detail_transaksi_smk($id)
	{
		$sql = "SELECT
				mfi_smk.nama,
				mfi_smk.sertifikat_no,
				mfi_smk.cif_no,
				mfi_smk.nominal,
				mfi_smk.date_issued,
				mfi_trx_smk.account_cash_code,
				mfi_trx_smk.trx_type,
				mfi_trx_smk.setor_tunai,
				mfi_trx_smk.tabungan_wajib,
				mfi_trx_smk.tabungan_kelompok,
				mfi_trx_smk.total,
				mfi_trx_smk.trx_date
				FROM
				mfi_trx_smk
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_trx_smk.cif_no
				INNER JOIN mfi_smk ON mfi_smk.trx_smk_code = mfi_smk.trx_smk_code
				WHERE mfi_trx_smk.trx_smk_id  = ?
				";

		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function get_value_lap_rek_tab_for_cetak($account_saving_no)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_account_saving.account_saving_no
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				WHERE mfi_account_saving.account_saving_no like ?
				";
		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	//TRANSAKSI SETORAN POKOK
	public function datatable_trx_setoran_pokok_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT 
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cm.cm_name,
				mfi_trx_setoran_pokok.trx_id,
				mfi_trx_setoran_pokok.setor_tunai,
				mfi_trx_setoran_pokok.setor_tabungan_wajib,
				mfi_trx_setoran_pokok.setor_tabungan_kelompok,
				mfi_trx_setoran_pokok.setor_tabungan_sukarela,
				mfi_trx_setoran_pokok.trx_date
				FROM
				mfi_trx_setoran_pokok
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_trx_setoran_pokok.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
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

	function datatable_r_verif_anggota($sWhere='',$sOrder='',$sLimit='',$branch,$cm){
		$sql = "SELECT 
				mtsp.*,mc.nama
				FROM mfi_cif AS mc
				JOIN mfi_trx_setoran_pokok AS mtsp ON (mtsp.cif_no = mc.cif_no) ";

		$param = array();

		if ($sWhere != ""){
			$sql .= "$sWhere ";

			if($branch != '00000'){
				$sql .= " AND mc.branch_code in(select branch_code from mfi_branch_member where branch_induk= ? ) ";
				$param[] = $branch;
			}

			if($cm != ''){
				$sql .= " AND mc.cm_code  = ? ";
				$param[] = $cm;
			}
		} else {
			if($branch != '00000'){
				$sql .= " WHERE mc.branch_code in(select branch_code from mfi_branch_member where branch_induk= ? ) ";
				$param[] = $branch;
			}

			if($cm != ''){
				$sql .= " AND mc.cm_code  = ? ";
				$param[] = $cm;
			}
		}

		$sql .= "AND mtsp.trx_status = '0' ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function cek_verif($id){
		$sql = "SELECT trx_status FROM mfi_trx_setoran_pokok WHERE trx_id = ?";

		$param = array($id);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function update_status_verif_pokok($id,$data){
		$this->db->where('trx_id',$id);
		$this->db->update('mfi_trx_setoran_pokok',$data);
	}

	public function add_transaksi_setoran_pokok($data)
	{
		$this->db->insert('mfi_trx_setoran_pokok',$data);
	}

	function update_saldo_balance($cif_no,$data){
		$this->db->where('cif_no',$cif_no);
		$this->db->update('mfi_account_default_balance',$data);
	}

	function add_transaksi_setoran_wajib($data){
		$this->db->insert('mfi_trx_smk',$data);
	}
	
	public function delete_trx_setoran_pokok($param)
	{
		$this->db->delete('mfi_trx_setoran_pokok',$param);
	}

	function check_simpanan_pokok(){
		$sql = "SELECT
		simpanan_pokok
		FROM mfi_institution";

		$query = $this->db->query($sql);

		return $query->row_array();
	}

    public function check_valid_cif_no($cif_no)
    {
        $sql = "SELECT
        mc.nama,
        mtsp.cif_no,
        mtsp.trx_date,
        COUNT(*) AS num
        FROM mfi_trx_setoran_pokok AS mtsp
        LEFT JOIN mfi_cif AS mc ON (mc.cif_no = mtsp.cif_no)
        WHERE mtsp.cif_no = ?
        GROUP BY 1,2,3";
        $query = $this->db->query($sql,array($cif_no));

        return $query->row_array();
    }

    function check_valid_cif_no_saleh($cif_no){
        $sql = "SELECT
        SUM(mtsp.total_setoran) AS total_setoran
        FROM mfi_trx_setoran_pokok AS mtsp
        LEFT JOIN mfi_cif AS mc ON (mc.cif_no = mtsp.cif_no)
        WHERE mtsp.cif_no = ?";
        $query = $this->db->query($sql,array($cif_no));

        return $query->row_array();
    }

    function update_simpanan_pokok($cif_no,$data){
    	$this->db->where('cif_no',$cif_no);
    	$this->db->update('mfi_account_default_balance',$data);
    }
	//TRANSAKSI SETORAN POKOK

    function cek_trx_kontrol_periode($tanggal)
    {
    	$sql = "select count(*) as num from mfi_trx_kontrol_periode where status = 1 and ? between periode_awal and periode_akhir";
    	$query = $this->db->query($sql,array($tanggal));

    	$row = $query->row_array();
    	if($row['num']>0){
    		return true;
    	}else{
    		return false;
    	}
    }

    public function insert_trx_cm_lwk($data)
    {
    	$this->db->insert('mfi_trx_cm_lwk',$data);
    }
	
	public function delete_trx_cm_lwk($param){
		$this->db->delete('mfi_trx_cm_lwk',$param);
	}
	
	public function proses_del_pelunasan_pembayaran($param){
		$this->db->delete('mfi_account_financing_lunas',$param);
	}

	public function get_review_transaksi($sidx='',$sord='',$limit_rows='',$start='',$from_date='',$thru_date='',$branch_code='')
	{
		$CI = get_instance();
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "select 
				mfi_trx_gl.trx_gl_id,
				mfi_trx_gl.trx_date,
				mfi_trx_gl.voucher_no,
				mfi_trx_gl.description,
				mfi_trx_gl.voucher_date,
				mfi_trx_gl.voucher_ref,
				(select sum(amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'C') as total_credit,
				(select sum(amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'D') as total_debit,
				mfi_branch.branch_name,
				mfi_branch.branch_code,
				mfi_trx_gl.flag_status
				from mfi_trx_gl 
				left join mfi_branch on mfi_branch.branch_code=mfi_trx_gl.branch_code
				";
		// if($from_date!="" && $thru_date!=""){
			$sql .= " where mfi_trx_gl.voucher_date between ? and ? 
					--and (mfi_trx_gl.description not like 'TRX REMBUG%' AND mfi_trx_gl.description not like 'PELUNASAN TRX REMBUG%' AND mfi_trx_gl.description not like 'ANGGOTA KELUAR TRX REMBUG%') 
					and mfi_trx_gl.jurnal_trx_id is null
					";
			$param[] = $CI->datepicker_convert(true,$from_date,'/');
			$param[] = $CI->datepicker_convert(true,$thru_date,'/');
		// }
		if($branch_code!="00000"){
			$sql.=" and mfi_trx_gl.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$sql .= " order by mfi_trx_gl.jurnal_trx_id,mfi_trx_gl.created_date desc $limit";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function get_trx_gl_detail($trx_gl_id)
	{
		$sql = "select * from mfi_trx_gl_detail where trx_gl_id = ? order by flag_debit_credit DESC";
		$query = $this->db->query($sql,array($trx_gl_id));

		return $query->result_array();
	}

	public function get_detail_review_transaksi($sidx='',$sord='',$limit_rows='',$start='',$trx_gl_id='')
	{
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "select 
				mfi_trx_gl_detail.trx_gl_detail_id
				,mfi_trx_gl_detail.trx_gl_id
				,mfi_trx_gl_detail.account_code
				,mfi_gl_account.account_name
				,mfi_trx_gl_detail.description
				,(case when flag_debit_credit = 'D' then amount else 0 end) debit
				,(case when flag_debit_credit = 'C' then amount else 0 end) credit
				from mfi_trx_gl_detail
				join mfi_gl_account on mfi_trx_gl_detail.account_code = mfi_gl_account.account_code
				where mfi_trx_gl_detail.trx_gl_id = ?
		 ";

		$sql .= "$order $limit";

		$query = $this->db->query($sql,array($trx_gl_id));

		return $query->result_array();
	}

	public function delete_trx_gl_detail($param)
	{
		$this->db->delete('mfi_trx_gl_detail',$param);
	}

	public function delete_trx_gl($param)
	{
		$this->db->delete('mfi_trx_gl',$param);
	}

	public function update_trx_gl($data,$param)
	{
		$this->db->update('mfi_trx_gl',$data,$param);
	}

	public function get_trx_gl_detail_sequence($trx_gl_id)
	{
		$sql = "select (coalesce(trx_sequence,0)+1) as seq from mfi_trx_gl_detail where trx_gl_id = ? order by trx_sequence desc";
		$query = $this->db->query($sql,array($trx_gl_id));
		$row = $query->row_array();

		return $row['seq'];
	}

	public function update_trx_gl_detail($data,$param)
	{
		$this->db->update('mfi_trx_gl_detail',$data,$param);
	}

	public function validate_double_transaction($cm_code,$trx_date)
	{
		$sql = "select count(*) as num from mfi_trx_cm where cm_code = ? and trx_date = ?";
		$query = $this->db->query($sql,array($cm_code,$trx_date));
		$row = $query->row_array();
		if($row['num']==0){
			return true;
		}else{
			return false;
		}
	}

	public function insert_trx_cm_detail_savingplan($data)
	{
		$this->db->insert('mfi_trx_cm_detail_savingplan',$data);
	}

	public function insert_trx_cm_detail_savingplan_account($data)
	{
		$this->db->insert_batch('mfi_trx_cm_detail_savingplan_account',$data);
	}

	public function get_mutasi_by_cif_no($cif_no,$tanggal='')
	{
		$sql = "select a.*,(b.jangka_waktu-b.counter_angsuran) as freq_sisa_angsuran,b.angsuran_pokok
				,b.angsuran_margin ,b.account_financing_no ,b.jangka_waktu
				,b.periode_jangka_waktu ,b.counter_angsuran, a.bonus_bagihasil, a.infaq
				from mfi_cif_mutasi a
				left join mfi_account_financing b on a.cif_no=b.cif_no and a.saldo_pembiayaan_pokok=b.saldo_pokok and b.status_rekening = 4
				where a.cif_no = ? and a.status = 1 and a.tipe_mutasi='1'";
		$param[]=$cif_no;
		if($tanggal!=''){
			$sql.=" and a.tanggal_mutasi <= ?";
			$param[]=$tanggal;
		}
		$query = $this->db->query($sql,$param);
		return $query->row_array();
	}

	public function get_account_code_petugas($account_cash_code)
	{
		$sql = "select gl_account_code from mfi_gl_account_cash where account_cash_code = ?";
		$query = $this->db->query($sql,array($account_cash_code));

		$row = $query->row_array();
		return $row['gl_account_code'];
	}

	public function get_account_code_teller($account_teller_code)
	{
		$sql = "select gl_account_code from mfi_gl_account_cash where account_cash_code = ?";
		$query = $this->db->query($sql,array($account_teller_code));

		$row = $query->row_array();
		return $row['gl_account_code'];
	}

	public function delete_trx_gl_cash($param)
	{
		$this->db->delete('mfi_trx_gl_cash',$param);
	}

	public function fn_create_jurnal_rembug($trx_cm_id)
	{
		$sql = "select fn_proses_jurnal_trx_rembug(?)";
		$query = $this->db->query($sql,array($trx_cm_id));
	}

	public function get_account_financing_by_financing_id($account_financing_id)
	{
		$sql = "SELECT 
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.cif_type,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.product_code,
				mfi_account_financing.branch_code,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.dana_kebajikan,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.biaya_administrasi,
				mfi_account_financing.biaya_asuransi_jiwa,
				mfi_account_financing.biaya_asuransi_jaminan,
				mfi_account_financing.biaya_notaris,
				mfi_account_financing.sumber_dana,
				mfi_account_financing.dana_sendiri,
				mfi_account_financing.dana_kreditur,
				mfi_account_financing.ujroh_kreditur,
				mfi_account_financing.ujroh_kreditur_persen,
				mfi_account_financing.ujroh_kreditur_nominal,
				mfi_account_financing.ujroh_kreditur_carabayar,
				mfi_account_financing.tanggal_pengajuan,
				mfi_account_financing.tanggal_akad,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.jtempo_angsuran_last,
				mfi_account_financing.jtempo_angsuran_next,
				mfi_account_financing.rate_margin,
				mfi_account_financing.status_rekening,
				mfi_account_financing.tanggal_lunas,
				mfi_account_financing.status_kolektibilitas,
				mfi_account_financing.status_par,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.sektor_ekonomi,
				mfi_account_financing.peruntukan,
				mfi_account_financing.akad_code,
				mfi_account_financing.program_code,
				mfi_account_financing.flag_jadwal_angsuran,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.fa_code,
				mfi_account_financing.registration_no,
				mfi_account_financing.angsuran_tab_wajib,
				mfi_account_financing.kreditur_code,
				mfi_account_financing.angsuran_tab_kelompok,
				mfi_account_financing.tanggal_registrasi,
				mfi_account_financing.jenis_jaminan,
				mfi_account_financing.flag_wakalah,
				mfi_account_financing.keterangan_jaminan,
				mfi_account_financing.financing_type,
				mfi_account_financing.peserta_asuransi,
				mfi_account_financing.tanggal_peserta_asuransi,
				mfi_account_financing.hubungan_peserta_asuransi,
				mfi_account_financing.flag_double_premi,
				mfi_account_financing.ktp_asuransi,
				mfi_account_financing_reg.pembiayaan_ke,
				mfi_account_financing_reg.description,
				mfi_fa.fa_name,
				mfi_cif.no_hp,
				mfi_cif_kelompok.p_no_hp
				FROM mfi_account_financing 
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_account_financing.fa_code
				INNER JOIN mfi_cif_kelompok ON mfi_cif_kelompok.cif_id = mfi_cif.cif_id
				WHERE account_financing_id = ?
				";

		$query = $this->db->query($sql,array($account_financing_id));

		return $query->row_array();
	}

	public function fn_proses_jurnal_tutuptabunganberencana($trx_account_saving_id)
	{
		$sql = "select fn_proses_jurnal_tutuptabunganberencana(?)";
		$query = $this->db->query($sql,array($trx_account_saving_id));
	}

	public function fn_proses_jurnal_kaspetugas($trx_gl_cash_id)
	{
		$sql = "select fn_proses_jurnal_kaspetugas(?)";
		$query = $this->db->query($sql,array($trx_gl_cash_id));
	}

	/**
	* fungsi untuk menjurnal angsuran pembiayaan individu
	* @author : sayyid
	*/
	public function fn_proses_jurnal_angsuran_pyd($account_financing_no)
	{
		$sql = "select fn_proses_jurnal_angsuran_pyd(?)";
		$query = $this->db->query($sql,array($account_financing_no));
	}

	function fn_proses_jurnal_angsuran_pyd_cash($account_financing_no){
		$sql = "select fn_proses_jurnal_angsuran_pyd_cash(?)";
		$query = $this->db->query($sql,array($account_financing_no));
	}

	function fn_proses_jurnal_angsuran_pyd_pinbuk($account_financing_no){
		$sql = "select fn_proses_jurnal_angsuran_pyd_pinbuk(?)";
		$query = $this->db->query($sql,array($account_financing_no));
	}

	/**
	* get data majelis
	* @author : sayyid
	*/
	public function get_cm_data_by_code($cm_code)
	{
		$sql = "select * from mfi_cm where cm_code=?";
		$query = $this->db->query($sql,array($cm_code));
		return $query->row_array();
	}

	/**
	* get jurnal umum review
	* @author : sayyid
	*/
	public function get_jurnal_umum_rev($sidx='',$sord='',$limit_rows='',$start='',$from_date='',$thru_date='')
	{
		$CI = get_instance();
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "select 
				trx_gl_id,
				trx_date,
				voucher_no,
				description,
				voucher_date,
				voucher_ref,
				(select sum(amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'C') as total_credit,
				(select sum(amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'D') as total_debit,
				mfi_user.fullname
				from mfi_trx_gl
				left join mfi_user on mfi_user.user_id=mfi_trx_gl.created_by::integer
				where created_by = ?
				";
		$param[] = $this->session->userdata('user_id');
		// if($from_date!="" && $thru_date!=""){
		$sql .= " and voucher_date between ? and ? ";
		$param[] = $CI->datepicker_convert(true,$from_date,'/');
		$param[] = $CI->datepicker_convert(true,$thru_date,'/');
		// }
		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_jenis_jaminan()
	{
		$sql = "SELECT
				mfi_list_code.code_group,
				mfi_list_code.code_description,
				mfi_list_code_detail.code_value,
				mfi_list_code_detail.display_text
				FROM
				mfi_list_code
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group = mfi_list_code.code_group
				where mfi_list_code.code_group='jaminan' ORDER BY display_sort ASC
			   ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_pengguna_dana()
	{
		$sql = "SELECT * FROM mfi_list_code_detail where code_group='penggunadana' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_setor_tunai_by_id($trx_account_saving_id)
	{
		$sql = "SELECT
				a.trx_date,
				a.amount,
				a.account_saving_no,
				a.trx_account_saving_id,
				c.cif_no,
				c.nama,
				d.trx_detail_id,
				e.product_name,
				(b.saldo_memo-b.saldo_hold-e.saldo_minimal) AS saldo_efektif,
				a.reference_no,
				a.description,
				a.branch_id
				FROM 
				mfi_trx_account_saving a,
				mfi_account_saving b,
				mfi_cif c,
				mfi_trx_detail d,
				mfi_product_saving e
				WHERE a.account_saving_no = b.account_saving_no 
				AND b.cif_no = c.cif_no AND d.trx_detail_id = a.trx_detail_id 
				AND e.product_code = b.product_code
				AND a.trx_saving_type = 1 AND b.status_rekening = 1 
				AND d.trx_type = 1 AND a.flag_debit_credit = 'C' AND a.trx_account_saving_id = ?
			   ";
		$query = $this->db->query($sql,array($trx_account_saving_id));

		return $query->row_array();
	}
	
	public function get_penarikan_tunai_by_id($trx_account_saving_id)
	{
		$sql = "SELECT
				a.trx_date,
				a.amount,
				a.account_saving_no,
				a.trx_account_saving_id,
				c.cif_no,
				c.nama,
				d.trx_detail_id,
				e.product_name,
				(b.saldo_memo-b.saldo_hold-e.saldo_minimal) AS saldo_efektif,
				a.reference_no,
				a.description,
				a.branch_id
				FROM 
				mfi_trx_account_saving a,
				mfi_account_saving b,
				mfi_cif c,
				mfi_trx_detail d,
				mfi_product_saving e
				WHERE a.account_saving_no = b.account_saving_no 
				AND b.cif_no = c.cif_no AND d.trx_detail_id = a.trx_detail_id 
				AND e.product_code = b.product_code
				AND a.trx_saving_type = 2 AND b.status_rekening = 1 
				AND d.trx_type = 1 AND a.flag_debit_credit = 'D' AND  a.trx_account_saving_id = ?
			   ";
		$query = $this->db->query($sql,array($trx_account_saving_id));

		return $query->row_array();
	}

	function datatable_rekening_pembiayaan_setup($sWhere='',$sOrder='',$sLimit=''){
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		maf.account_financing_id,
		maf.account_financing_no,
		maf.status_rekening,
		maf.product_code,
		maf.financing_type
		FROM mfi_account_financing AS maf
		INNER JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no 
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($flag_all_branch==0){
				$sql.="AND mc.branch_code='".$branch_code."'";
			}
		}else{
			if($flag_all_branch==0){
				$sql.="WHERE mc.branch_code='".$branch_code."'";
			}
		}

		if ( $sOrder != "" )
		$sql .= "$sOrder ";

		if ( $sLimit != "" )
		$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function datatable_rak_setup($sWhere='',$sOrder='',$sLimit=''){
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
		mtr.trx_rak_id,
		mtr.trx_rak_type,
		mtr.voucher_date,
		mb.branch_name AS branch_kirim,
		mbr.branch_name AS branch_terima,
		mtr.amount
		FROM mfi_trx_rak AS mtr
		JOIN mfi_branch AS mb ON mb.branch_code = mtr.branch_kirim
		JOIN mfi_branch AS mbr ON mbr.branch_code = mtr.branch_terima ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mtr.status = '0'";
			if($flag_all_branch==0){
				$sql.="AND mtr.status = '0' AND mtr.branch_kirim='".$branch_code."'";
			}
		}else{
			$sql .= "WHERE mtr.status = '0'";
			if($flag_all_branch==0){
				$sql.="AND mtr.status = '0' AND mtr.branch_kirim='".$branch_code."'";
			}
		}

		if ( $sOrder != "" )
		$sql .= "$sOrder ";

		if ( $sLimit != "" )
		$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_rak_by_trx_rak_id($trx_rak_id){
		$sql = "SELECT * FROM mfi_trx_rak WHERE trx_rak_id = ?";

		$param = array($trx_rak_id);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function get_rak($cabang){
		$sql = "SELECT
		mr.bank_account_code,
		mga.account_name
		FROM mfi_rak AS mr
		JOIN mfi_gl_account AS mga ON mga.account_code = mr.bank_account_code
		WHERE mr.branch_code = ?";

		$param = array($cabang);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function proses_input_trx_rak($data){
		$this->db->insert('mfi_trx_rak',$data);
	}

	function proses_edit_trx_rak($data,$param){
		$this->db->update('mfi_trx_rak',$data,$param);
	}

	public function datatable_pinbuk_tabungan($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "select 
				a.trx_detail_id,
				a.account_no as no_rek_tabungan_sumber,
				a.account_no_dest as no_rek_tabungan_tujuan,
				(select b.nama from mfi_cif b,mfi_account_saving c where b.cif_no=c.cif_no and c.account_saving_no=a.account_no) as nama_tabungan_sumber,
				(select b.nama from mfi_cif b,mfi_account_saving c where b.cif_no=c.cif_no and c.account_saving_no=a.account_no_dest) as nama_tabungan_tujuan,
				a.amount,
				a.trx_date
				from mfi_trx_detail a
				where a.trx_type=1 and a.trx_account_type=3
				and (a.trx_detail_id in(select b.trx_detail_id from mfi_trx_account_saving b where b.trx_detail_id=a.trx_detail_id and b.trx_saving_type=3 and b.trx_status=0) 
				and a.trx_detail_id in(select b.trx_detail_id from mfi_trx_account_saving b where b.trx_detail_id=a.trx_detail_id and b.trx_saving_type=4 and b.trx_status=0))
				and a.created_by=?
		       ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,array($this->session->userdata('user_id')));

		return $query->result_array();
	}



	/* DELETING TRANSACTION SAVING(TABUNGAN) */

	/**
	* GET DATA TRANSAKSI SAVING(TABUNGAN)
	* @author : sayyid
	* date : 25 agustus 2014
	* @param : trx_detail_id
	*/
	public function get_trx_account_saving_by_trx_detail_id($trx_detail_id,$trx_saving_type='')
	{
		$sql = "select trx_account_saving_id,branch_id,account_saving_no,trx_saving_type,flag_debit_credit,trx_date,amount from mfi_trx_account_saving where trx_detail_id=?";
		$param[]=$trx_detail_id;
		if($trx_saving_type!=''){
			$sql.=" and trx_saving_type=?";
			$param[]=$trx_saving_type;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	/**
	* DELETE TRX ACCOUNT SAVING
	* @author : sayyid
	* date : 25 agustus 2014
	*/
	public function delete_trx_account_saving($param)
	{
		$this->db->delete('mfi_trx_account_saving',$param);
	}
	/**
	* DELETE TRX DETAIL
	* @author : sayyid
	* date : 25 agustus 2014
	*/
	public function delete_trx_detail($param)
	{
		$this->db->delete('mfi_trx_detail',$param);
	}

	public function get_product_financing_data_by_code($product_code)
	{
		$sql="select * from mfi_product_financing where product_code=?";
		$query=$this->db->query($sql,array($product_code));
		return $query->row_array();
	}
	

	/**
	* GET SEQUENCE NUMBER OF ACCOUNT SAVING NO
	* @author sayyid nurkilah
	* @param product_code
	* @param cif_no
	*/
	public function get_seq_account_saving_no($product_code,$cif_no)
	{
		$sql = "SELECT max(RIGHT(account_saving_no,2)) AS jumlah from mfi_account_saving where product_code = ? and cif_no = ?";
		$query = $this->db->query($sql,array($product_code,$cif_no));

		return $query->row_array();
	}

	/**
	* GET SEQUENCE NUMBER OF ACCOUNT FINANCING NO
	* @author sayyid nurkilah
	* @param product_code
	* @param cif_no
	*/
	public function get_seq_account_financing_no($product_code,$cif_no)
	{
		$sql = "SELECT max(RIGHT(account_financing_no,2)) AS jumlah from mfi_account_financing where product_code = ? and cif_no = ?";
		$query = $this->db->query($sql,array($product_code,$cif_no));

		return $query->row_array();
	}

	public function get_grace_periode($cif_type)
	{
		$sql = "select grace_period_kelompok,grace_period_individu from mfi_institution limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if($cif_type==0){
			return $row['grace_period_kelompok'];
		}else{
			return $row['grace_period_individu'];
		}
	}

	public function get_trx_rembug_is_exist($trx_date,$cm_code)
	{
		$sql = "select count(*) as num from mfi_trx_cm where trx_date=? and cm_code=?";
		$query = $this->db->query($sql,array($trx_date,$cm_code));
		$data = $query->row_array();
		$num = $data['num'];

		return $num;
	}


	/* get data pendebetan tab.berencana untuk anggota keluar */
	public function get_data_pendebetan_tab_berencana($cif_no)
	{
		$sql = "select a.cif_no, sum(a.saldo_memo) as amount
				from mfi_account_saving a, mfi_cif b
				where a.cif_no=b.cif_no
				and a.status_rekening=4
				and b.cif_no=?
				group by 1";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	/* get data pendebetan tab.berencana untuk anggota keluar */
	public function get_data_pendebetan_tab_berencana_detail($cif_no)
	{
		$sql = "select 
				a.product_code, a.cif_no, a.saldo_memo as amount
				from mfi_account_saving a,mfi_cif b
				where a.cif_no=b.cif_no
				and a.status_rekening=4
				and b.cif_no=?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->result_array();
	}

	function get_branch_id_by_code($branch_code)
	{
		$sql="select branch_id from mfi_branch where branch_code=?";
		$query=$this->db->query($sql,array($branch_code));
		$row=$query->row_array();

		return $row;
	}

	function insert_batch_trx_sukarela($data)
	{
		$this->db->insert_batch('mfi_trx_tab_sukarela',$data);
	}
	function get_counter_angsuran($account_financing_no) {
		$sql = "select counter_angsuran from mfi_account_financing where account_financing_no=?";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		if (count($row)>0) {
			return $row['counter_angsuran'];
		} else {
			return 0;
		}
	}

	function cekHariLibur($jtempo_angsuran_next)
	{
		$sql = "
			select count(*) jml from mfi_hari_libur
			where tanggal = ?
		";
		$query = $this->db->query($sql,array($jtempo_angsuran_next));
		$row = $query->row_array();
		if ($row['jml']==0) {
			return false;
		} else {
			return true;
		}
	}

	function datatable_r_verif_pinbuk($sWhere='',$sOrder='',$sLimit='',$branch){
		$sql = "SELECT trx_date,SUM(wajib) AS wajib,SUM(kelompok) AS kelompok,
			SUM(total) AS total, created_date FROM (
			SELECT mts.trx_date, SUM(mts.tabungan_wajib) AS wajib,
			SUM(mts.tabungan_kelompok) AS kelompok, SUM(mts.total) AS total,
			mts.created_date
			FROM mfi_trx_smk AS mts
			JOIN mfi_cif AS mc ON (mc.cif_no = mts.cif_no)
			WHERE mts.trx_status = '0' AND mc.branch_code = ?
			GROUP BY 1,5

			UNION ALL

			SELECT mtsp.trx_date, SUM(mtsp.setor_tabungan_wajib) AS wajib,
			SUM(mtsp.setor_tabungan_kelompok) AS kelompok,
			SUM(mtsp.total_setoran) AS total, mtsp.created_date
			FROM mfi_trx_setoran_pokok AS mtsp
			JOIN mfi_cif AS mc ON (mc.cif_no = mtsp.cif_no)
			WHERE mtsp.trx_status = '0' AND mc.branch_code = ?
			GROUP BY 1,5
		) AS transaksi
		GROUP BY 1,5";

		$param = array();

		$param[] = $branch;
		$param[] = $branch;

		if($sWhere != ""){
			$sql .= $sWhere;
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function datatable_r_detil_pinbuk($sWhere='',$sOrder='',$sLimit='',$branch){
		$sql = "SELECT a.cif_id id,a.cif_no,a.nama,
			COALESCE(b.tabungan_wajib,0) tabungan_wajib,
			COALESCE(b.tabungan_kelompok,0) tabungan_kelompok,
			COALESCE(b.simpanan_pokok,0) simpanan_pokok,
			COALESCE(b.smk,0) smk
			FROM mfi_cif a, mfi_account_default_balance b ";		

		if($sWhere != ""){
			$sql .= $sWhere;
			$sql .= " AND a.cif_no = b.cif_no AND a.status = 1
			AND a.branch_code = ? ";
		} else {
			$sql .= " WHERE a.cif_no = b.cif_no AND a.status = 1
			AND a.branch_code = ? ";
		}

		$param = array($branch);

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function update_setoran_pokok($by,$date,$branch,$created){
		//$this->db->where('created_date',$id);
		//$this->db->update('mfi_trx_setoran_pokok',$data);

		$sql = "UPDATE mfi_trx_setoran_pokok SET trx_status = '1', verify_by = ?, verify_date = ? WHERE created_date = ? AND cif_no IN (SELECT cif_no FROM mfi_cif WHERE branch_code = ?)";

		$param = array($by,$date,$created,$branch);

		$query = $this->db->query($sql,$param);
	}

	function update_setoran_smk($by,$date,$branch,$created){
		//$this->db->where('created_date',$id);
		//$this->db->update('mfi_trx_smk',$data);

		$sql = "UPDATE mfi_trx_smk SET trx_status = '1', verify_by = ?, verify_date = ? WHERE created_date = ? AND cif_no IN (SELECT cif_no FROM mfi_cif WHERE branch_code = ?)";

		$param = array($by,$date,$created,$branch);

		$query = $this->db->query($sql,$param);
	}

	function ajax_get_product_financing_by_jenis_pembiayaan($jenis_pembiayaan){
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.jenis_pembiayaan
				FROM
				mfi_product_financing
				WHERE jenis_pembiayaan = ? ";
		$query = $this->db->query($sql,array($jenis_pembiayaan));
		return $query->result_array();
	}

	function get_data_trx_account_saving_by_id($trx_account_saving_id)
	{
		$sql = "select * from mfi_trx_account_saving where trx_account_saving_id=?";
		$query = $this->db->query($sql,array($trx_account_saving_id));
		return $query->row_array();
	}

	function get_data_account_saving_by_account_no($account_saving_no)
	{
		$sql = "select * from mfi_account_saving where account_saving_no=?";
		$query = $this->db->query($sql,array($account_saving_no));
		return $query->row_array();
	}

	public function fn_jurnal_trx_saving($trx_account_saving_id)
	{
		$sql = "select fn_jurnal_trx_saving(?,?)";
		$query = $this->db->query($sql,array($trx_account_saving_id,$this->session->userdata('user_id')));
	}

	function get_data_trx_account_financing_by_id($id)
	{
		$sql = "select * from mfi_trx_account_financing where trx_account_financing_id=?";
		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}

	function get_data_trx_detail_by_id($id)
	{
		$sql = "select * from mfi_trx_detail where trx_detail_id=?";
		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}
	
	function get_account_cash_code($gl_code){
		$sql = "SELECT account_cash_code FROM mfi_gl_account_cash WHERE gl_account_code = ?";
		
		$param = array($gl_code);
		
		$query = $this->db->query($sql,$param);
		
		return $query->row_array();
	}

	function get_data_account_financing_by_account_no($account_financing_no)
	{
		$sql = "select * from mfi_account_financing where account_financing_no=?";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	function get_data_account_financing_schedulle_by_account_no($account_financing_no)
	{
		$sql = "select * from mfi_account_financing_schedulle where account_no_financing=? and status_angsuran=0 order by tangga_jtempo asc limit 1";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	function get_last_counter_angsuran_by_account_financing_no($account_financing_no)
	{
		$sql = "select count(*) counter_angsuran from mfi_account_financing_schedulle where account_no_financing=? and status_angsuran=1";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		return $row['counter_angsuran'];
	}

	function get_jtempo_angsuran_next_schedulle($account_financing_no)
	{
		$sql = "select tangga_jtempo from mfi_account_financing_schedulle where account_no_financing=? and status_angsuran=0 order by tangga_jtempo asc limit 1 offset 1";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		if (count($row)>0){
			return $row['tangga_jtempo'];
		} else {
			return false;
		}
	}

	function get_petugas(){
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
				$sql .= " WHERE branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function search_fa($keyword,$branch){
		$sql = "SELECT fa_code, fa_name
		FROM mfi_fa
		WHERE fa_name LIKE ? AND branch_code = ? ORDER BY 2";

		$param = array();
		$param[] = '%'.strtoupper($keyword).'%';
		$param[] = $branch;
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_count_pembatalan_angsuran($trx_date,$cm_code){
		$sql = "SELECT
		COUNT(*) AS jumlah

		FROM mfi_trx_cm_detail AS mtcd

		JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mtcd.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no

		WHERE mtc.trx_date = ? AND maf.status_rekening = '1' AND mtc.cm_code = ?";

		$param = array($trx_date,$cm_code);

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		if(isset($row['jumlah'])){
			$result = $row['jumlah'];
		} else {
			$result = 0;
		}
		return $result;
	}

	function jqgrid_list_pembatalan_angsuran($sidx='',$sord='',$limit_rows='',$start='',$trx_date,$cm_code){
		$order = '5,4';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord ";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start ";

		$sql = "SELECT
		mtcd.trx_cm_detail_id,
		mtcd.cif_no,
		mc.nama,
		mtcd.account_financing_no,
		maf.pokok,
		maf.margin,
		mtcd.angsuran_pokok,
		mtcd.angsuran_margin,
		mtcd.angsuran_catab,
		maf.account_saving_no,
		maf.counter_angsuran

		FROM mfi_trx_cm_detail AS mtcd

		JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mtcd.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no

		WHERE mtc.trx_date = ? AND maf.status_rekening = '1' AND mtc.cm_code = ?";

		$param = array($trx_date,$cm_code);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_data_for_pembatalan_angsuran($rekening){
		$sql = "SELECT
		mtaf.trx_account_financing_id,
		maf.account_financing_no,
		mc.nama,
		maf.pokok,
		maf.margin,
		maf.tanggal_akad,
		mtaf.pokok as angsuran_pokok,
		mtaf.margin as angsuran_margin,
		mtaf.jto_date,
		mtaf.trx_date,
		mtaf.angsuran_ke

		FROM mfi_trx_account_financing AS mtaf

		JOIN mfi_account_financing AS maf
		ON maf.account_financing_no = mtaf.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no

		WHERE mas.status_rekening = 1 AND mtaf.trx_financing_type = 1
		AND mtaf.trx_status = 1 AND mtaf.account_financing_no = ?";

		$param = array($rekening);

		$query = $this->db->query($sql,$param);

		$return = $query->row_array();

		echo $return;
	}

	function check_gl($branch_code,$tanggal,$account_code,$flag,$amount){
		$sql = "SELECT
		COUNT(*) AS total
		FROM mfi_trx_gl_detail
		WHERE account_code = ? AND flag_debit_credit = ? AND amount = ?
		AND trx_gl_id IN(SELECT trx_gl_id FROM mfi_trx_gl WHERE branch_code = ? AND voucher_date = ?)";

		$param = array($account_code,$flag,$amount,$branch_code,$tanggal);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	// PERPANJANGAN TABBER
	// perpanjang
	public function verif_perpanjang_tabber($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}

	// FOR INSERT TO mfi_account_saving_schedule
	public function insert_perpanjang_tabber($datas,$param)
	{
		$this->db->insert('mfi_account_saving_schedulle',$datas,$param);
	}

	public function update_perpanjang_tabber($datas,$param)
	{
		$this->db->update('mfi_account_saving_schedule',$datas,$param);
	}
	// END PERPANJANGAN TABBER
}