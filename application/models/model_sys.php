<?php

Class Model_sys extends CI_Model {


	public function get_periode()
	{
		$sql = " SELECT 
						*
				from 	
						mfi_trx_kontrol_periode 
						";

		$query = $this->db->query($sql);
		return $query->row_array();
	}

	function insert_periode($data){
		$this->db->insert('mfi_trx_kontrol_periode',$data);
	}

	function delete_summary_mutasi(){
		$sql = "DELETE FROM mfi_gl_account_summary_mutasi";

		$this->db->query($sql);
	}

	function check_status_periode($periode_id){
		$sql = "SELECT status FROM mfi_trx_kontrol_periode WHERE periode_id = ?";

		$param = array($periode_id);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function fn_proses_jurnal_akhir_tahun($first_date_at_year,$last_date_at_year,$branch_code,$gl_shu_tahun_lalu){
		$sql = "SELECT fn_proses_jurnal_akhir_tahun(?,?,?,?)";

		$param = array($first_date_at_year,$last_date_at_year,$branch_code,$gl_shu_tahun_lalu);

		$query = $this->db->query($sql,$param);
	}

	function fn_jurnal_ditribusi_shu_branch($tanggal,$gl_sukarela,$gl_rak_pusat,$branch_code){
		$sql = "SELECT fn_jurnal_ditribusi_shu_branch(?,?,?,?)";

		$param = array($tanggal,$gl_sukarela,$gl_rak_pusat,$branch_code);

		$query = $this->db->query($sql,$param);
	}

	function get_branch_akhir_tahun($first_date_at_year,$last_date_at_year){
		$sql = "SELECT
		a.branch_code,
		a.branch_name
		FROM mfi_branch AS a, mfi_trx_gl AS b
		WHERE a.branch_code = b.branch_code
		AND a.branch_class <> '0'
		AND b.voucher_date BETWEEN ? AND ?
		GROUP BY 1,2
		ORDER BY a.branch_code ASc";

		$param = array($first_date_at_year,$last_date_at_year);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function update_periode($data,$param)
	{
		$this->db->update('mfi_trx_kontrol_periode',$data,$param);
	}

	public function do_bagihasil_tabungan($product_code,$tanggal,$rate)
	{
		$sql="select fn_proses_distribusi_bahas_tabungan(?,?,?)";
		$query=$this->db->query($sql,array($product_code,$tanggal,$rate));
	}

	public function get_saldo_tabungan_anggota($product_code)
	{
		$param=array();
		switch ($product_code) {
			case '97': // sukarela
			$sql="select coalesce(sum(a.tabungan_sukarela),0) amount from mfi_account_default_balance a, mfi_cif b where a.cif_no=b.cif_no and b.status=1";
			break;
			case '98': // wajib
			$sql="select coalesce(sum(a.tabungan_wajib),0) amount from mfi_account_default_balance a, mfi_cif b where a.cif_no=b.cif_no and b.status=1";
			break;
			case '99': // kelompok
			$sql="select coalesce(sum(a.tabungan_kelompok),0) amount from mfi_account_default_balance a, mfi_cif b where a.cif_no=b.cif_no and b.status=1";
			break;
			default:
			$sql="select coalesce(sum(a.saldo_memo),0) amount from mfi_account_saving a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and a.product_code=?";
			$param[]=$product_code;
			break;
		}

		$query = $this->db->query($sql,$param);
		$return=$query->row_array();

		return $return['amount'];
	}

	public function do_bagihasi_kelompok($proyeksi_bahas_id,$trx_date)
	{
		$sql1 ="select
				id as proyeksi_bahas_detail_id,
				product_code,
				product_name,
				jumlah_bonus
				from mfi_proyeksi_bahas_detail
				where proyeksi_bahas_id=?
		";
		$query1=$this->db->query($sql1,array($proyeksi_bahas_id));
		$res1=$query1->result_array();

		$row=array();
		for($i=0;$i<count($res1);$i++){
			
			$product_code=$res1[$i]['product_code'];
			$product_name=$res1[$i]['product_name'];
			$jumlah_bonus=$res1[$i]['jumlah_bonus'];
			$proyeksi_bahas_detail_id=$res1[$i]['proyeksi_bahas_detail_id'];

			/*get saldo tab seluruh nasabah*/
			$total_saldo=$this->get_saldo_tabungan_anggota($product_code);

			$sql2 = "select
				a.cif_no,
				a.branch_code,
				b.tabungan_sukarela,
				b.tabungan_wajib,
				b.tabungan_kelompok
				from mfi_cif a
				left join mfi_account_default_balance b on b.cif_no=a.cif_no
				where a.status=1";
			$query2=$this->db->query($sql2);
			$res2=$query2->result_array();

			for($j=0;$j<count($res2);$j++){

				$cif_no=$res2[$j]['cif_no'];
				$branch_code=$res2[$j]['branch_code'];

				/*get tab.anggota per nasabah*/
				$tabungan_sukarela_nasabah=$res2[$j]['tabungan_sukarela'];
				$tabungan_wajib_nasabah=$res2[$j]['tabungan_wajib'];
				$tabungan_kelompok_nasabah=$res2[$j]['tabungan_kelompok'];

				if($total_saldo>0)
				{
					switch ($product_code) 
					{
						case '97': // SUKARELA
						$jumlah_bonus_nasabah = $tabungan_sukarela_nasabah/$total_saldo*$jumlah_bonus;
						if($jumlah_bonus_nasabah>0){
							$row[]=array(
								'cif_no'=>$cif_no,
								'account_saving_no'=>NULL,
								'trx_date'=>$trx_date,
								'amount'=>$jumlah_bonus_nasabah,
								'flag_debit_credit'=>'C',
								'keterangan'=>'BAHAS '.$product_name,
								'bahas_type'=>1, // tab anggota
								'created_by'=>$this->session->userdata('user_id'),
								'created_stamp'=>date('Y-m-d H:i:s'),
								'status'=>0,
								'branch_code'=>$branch_code,
								'proyeksi_bahas_detail_id'=>$proyeksi_bahas_detail_id
							);
						}
						break;
						case '98': // WAJIB
						$jumlah_bonus_nasabah = $tabungan_wajib_nasabah/$total_saldo*$jumlah_bonus;
						if($jumlah_bonus_nasabah>0){
							$row[]=array(
								'cif_no'=>$cif_no,
								'account_saving_no'=>NULL,
								'trx_date'=>$trx_date,
								'amount'=>$jumlah_bonus_nasabah,
								'flag_debit_credit'=>'C',
								'keterangan'=>'BAHAS '.$product_name,
								'bahas_type'=>2, // tab anggota
								'created_by'=>$this->session->userdata('user_id'),
								'created_stamp'=>date('Y-m-d H:i:s'),
								'status'=>0,
								'branch_code'=>$branch_code,
								'proyeksi_bahas_detail_id'=>$proyeksi_bahas_detail_id
							);
						}
						break;
						case '99': // KELOMPOK
						$jumlah_bonus_nasabah = $tabungan_kelompok_nasabah/$total_saldo*$jumlah_bonus;
						if($jumlah_bonus_nasabah>0){
							$row[]=array(
								'cif_no'=>$cif_no,
								'account_saving_no'=>NULL,
								'trx_date'=>$trx_date,
								'amount'=>$jumlah_bonus_nasabah,
								'flag_debit_credit'=>'C',
								'keterangan'=>'BAHAS '.$product_name,
								'bahas_type'=>3, // tab anggota
								'created_by'=>$this->session->userdata('user_id'),
								'created_stamp'=>date('Y-m-d H:i:s'),
								'status'=>0,
								'branch_code'=>$branch_code,
								'proyeksi_bahas_detail_id'=>$proyeksi_bahas_detail_id
							);
						}
						break;
						default:
						$sql3 = "select account_saving_no,saldo_memo from mfi_account_saving where cif_no=? and status_rekening=1 and product_code=?";
						$query3=$this->db->query($sql3,array($cif_no,$product_code));
						$res3=$query3->result_array();
						for($k=0;$k<count($res3);$k++){
							/*get tab.saving per nasabah*/
							$saving_nasabah=$res3[$k]['saldo_memo'];
							$account_saving_no=$res3[$k]['account_saving_no'];
							$jumlah_bonus_nasabah = $saving_nasabah/$total_saldo*$jumlah_bonus;

							if($jumlah_bonus>0)
							{
								$row[]=array(
									'cif_no'=>$cif_no,
									'account_saving_no'=>$account_saving_no,
									'trx_date'=>$trx_date,
									'amount'=>$jumlah_bonus_nasabah,
									'flag_debit_credit'=>'C',
									'keterangan'=>'BAHAS '.$product_name,
									'bahas_type'=>0, // tab ren&etc
									'created_by'=>$this->session->userdata('user_id'),
									'created_stamp'=>date('Y-m-d H:i:s'),
									'status'=>0,
									'branch_code'=>$branch_code,
									'proyeksi_bahas_detail_id'=>$proyeksi_bahas_detail_id
								);
							}
						}
						break;
					}
				}

			}

		}
		
		$this->db->trans_begin();
		if(count($row)>0){
			$this->db->insert_batch('mfi_titipan_bagihasil',$row);
		}
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			// return true;
		}else{
			$this->db->trans_rollback();
			// return false;
		}
	}

	public function do_debet_adm($tanggal)
	{
		$sql="select fn_proses_debet_adm_tabungan(?)";
		$query=$this->db->query($sql,array($tanggal));
	}
	/*
	| CLOSING TRANSACTION (TUTUP BUKU TRANSAKSI)
	| created_by : sayyid
	| created_date : 2014-10-28 09:38
	*/
	function get_balance_data_for_closing($branch_code)
	{
		$sql = "SELECT
				a.cif_no,
				a.tabungan_sukarela,
				a.tabungan_wajib,
				a.tabungan_kelompok
				FROM mfi_account_default_balance a, mfi_cif b
				WHERE a.cif_no=b.cif_no
				AND b.status=1
				";
		$param=array();
		if($branch_code!="00000"){
			$sql .= " AND b.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
			$param[]=$branch_code;
		}
		$query=$this->db->query($sql,$param);
		return $query->result_array();
	}
	function get_saving_data_for_closing($branch_code)
	{
		$sql = " SELECT 
					mfi_account_saving.account_saving_no
				   ,mfi_account_saving.saldo_riil
				   ,mfi_account_saving.saldo_memo
				   ,mfi_cif.cif_no
				   ,mfi_cif.nama 
				 FROM mfi_account_saving,mfi_cif
				 WHERE mfi_account_saving.status_rekening = 1
				 AND mfi_cif.cif_no=mfi_account_saving.cif_no
				";
		$param=array();
		if($branch_code!="00000"){
			$sql .= " AND mfi_cif.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
			$param[]=$branch_code;
		}
		$query=$this->db->query($sql,$param);
		return $query->result_array();
	}
	function get_financing_data_for_closing($branch_code)
	{
		$sql = " SELECT 
					mfi_account_financing.account_financing_no
				   ,mfi_account_financing.saldo_pokok
				   ,mfi_account_financing.saldo_margin
				   ,mfi_account_financing.saldo_catab
				   ,mfi_cif.cif_no
				   ,mfi_cif.nama 
				 FROM mfi_account_financing,mfi_cif
				 WHERE mfi_account_financing.status_rekening = 1
				 AND mfi_cif.cif_no=mfi_account_financing.cif_no
				";
		$param=array();
		if($branch_code!="00000"){
			$sql .= " AND mfi_cif.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
			$param[]=$branch_code;
		}
		$query=$this->db->query($sql,$param);
		return $query->result_array();
	}
	function get_ledger_data_for_closing($branch_code)
	{
		$sql = "SELECT
				a.account_code,
				a.transaction_flag_default,
				(select coalesce(sum(b.amount),0) 
					from mfi_trx_gl_detail b, mfi_trx_gl c 
					where c.trx_gl_id=b.trx_gl_id 
					and b.account_code=a.account_code 
					and b.amount is not null and b.amount <> 0
					and b.flag_debit_credit='D'
					and c.branch_code=?
					)-(select coalesce(sum(b.amount),0) 
						from mfi_trx_gl_detail b, mfi_trx_gl c 
						where c.trx_gl_id=b.trx_gl_id 
						and b.account_code=a.account_code 
						and b.amount is not null and b.amount <> 0
						and b.flag_debit_credit='C'
						and c.branch_code=?
						) as saldo
				FROM mfi_gl_account a
				ORDER BY a.account_code ASC";
		$query=$this->db->query($sql,array($branch_code,$branch_code));
		return $query->result_array();
	}
	function get_average_saldo_balance($cif_no,$from_date,$thru_date)
	{
		$sql_sukarela = "SELECT coalesce(fn_get_saldo_awal_rinci_sukarela_by_cif(?,?,?),0)+coalesce(fn_get_average_saldo_balance_sukarela(?,?,?),0) as saldo";
		$query_sukarela=$this->db->query($sql_sukarela,array($cif_no,$from_date,'all',$cif_no,$from_date,$thru_date));
		$row_sukarela=$query_sukarela->row_array();
		$arr['tabungan_sukarela']=$row_sukarela['saldo'];

		$sql_wajib = "SELECT coalesce(fn_get_saldo_awal_rinci_wajib_by_cif(?,?,?),0)+coalesce(fn_get_average_saldo_balance_wajib(?,?,?),0) as saldo";
		$query_wajib=$this->db->query($sql_wajib,array($cif_no,$from_date,'all',$cif_no,$from_date,$thru_date));
		$row_wajib=$query_wajib->row_array();
		$arr['tabungan_wajib']=$row_wajib['saldo'];

		$sql_kelompok = "SELECT coalesce(fn_get_saldo_awal_rinci_kelompok_by_cif(?,?,?),0)+coalesce(fn_get_average_saldo_balance_kelompok(?,?,?),0) as saldo";
		$query_kelompok=$this->db->query($sql_kelompok,array($cif_no,$from_date,'all',$cif_no,$from_date,$thru_date));
		$row_kelompok=$query_kelompok->row_array();
		$arr['tabungan_kelompok']=$row_kelompok['saldo'];

		return $arr;
	}
	function get_average_saldo_tabungan($account_saving_no,$from_date,$thru_date)
	{
		$sql = "SELECT fn_get_average_saldo_tabungan(?,?,?) as saldo";
		$query=$this->db->query($sql,array($account_saving_no,$from_date,$thru_date));
		$row=$query->row_array();
		return $row['saldo'];
	}
	function get_average_saldo_ledger($account_code,$from_date,$thru_date)
	{
		$sql = "SELECT fn_get_average_saldo_ledger(?,?,?) as saldo";
		$query=$this->db->query($sql,array($account_code,$from_date,$thru_date));
		$row=$query->row_array();
		return $row['saldo'];
	}
	function get_branch_by_branch_class($branch_class)
	{
		$sql = "select * from mfi_branch where branch_class=? order by branch_code asc";
		$query=$this->db->query($sql,array($branch_class));
		return $query->result_array();		
	}
	function cek_par($thru_date,$branch_code)
	{
		$sql = "select count(*) as jum from mfi_par where tanggal_hitung=? and branch_code=?";
		$query=$this->db->query($sql,array($thru_date,$branch_code));
		$row=$query->row_array();

		if(count($row)>0){
			$exists=$row['jum'];
		}else{
			$exists=0;
		}
		return $exists;
	}
	function delete_par($thru_date,$branch_code)
	{
		$param=array('tanggal_hitung'=>$thru_date,'branch_code'=>$branch_code);
		$this->db->delete('mfi_par',$param);
	}
	function insert_closing_balance_data($closing_id,$from_date,$thru_date,$created_by){
		$sql = "SELECT fn_insert_closing_balance_data(?,?,?,?)";

		$param = array($closing_id,$from_date,$thru_date,$created_by);

		$query = $this->db->query($sql,$param);
	}
	function insert_closing_financing_data($closing_id,$from_date,$thru_date,$created_by){
		$sql = "SELECT fn_insert_closing_financing_data(?,?,?,?)";

		$param = array($closing_id,$from_date,$thru_date,$created_by);

		$query = $this->db->query($sql,$param);
	}
	function insert_closing_saving_data($closing_id,$from_date,$thru_date,$created_by){
		$sql = "SELECT fn_insert_closing_saving_data(?,?,?,?)";

		$param = array($closing_id,$from_date,$thru_date,$created_by);

		$query = $this->db->query($sql,$param);
	}
	function insert_closing_ledger_data($branch_code,$from_date_lm,$from_date,$thru_date,$closing_id,$user_id,$flag_akhir_tahun,$bulan_lama){
		$sql = "SELECT fn_insert_closing_ledger_data(?,?,?,?,?,?,?,?)";

		$param = array($branch_code,$from_date_lm,$from_date,$thru_date,$closing_id,$user_id,$flag_akhir_tahun,$bulan_lama);

		$query = $this->db->query($sql,$param);
	}
	function insert_jurnal_akhir_tahun($first_date_at_year,$last_date_at_year,$branch_code,$gl_shu_tahun_lalu){
		$sql = "SELECT fn_proses_jurnal_akhir_tahun(?,?,?,?)";

		$param = array($first_date_at_year,$last_date_at_year,$branch_code,$gl_shu_tahun_lalu);

		$query = $this->db->query($sql,$param);
	}
	function insert_closing_kolektibilitas_data($data)
	{
		$this->db->insert_batch('mfi_par',$data);
	}

	/*
	| GET NUM VERIFIED TRX NOT YET
	*/
	function num_trx_cm_verified_not_yet($branch_code)
	{
		$param = array();
		$sql = "select count(*) as num from mfi_trx_cm_save a, mfi_cm b, mfi_branch c
				where a.cm_code=b.cm_code and b.branch_id=c.branch_id";
		if ($branch_code!="00000") {
			$sql .= " and c.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
			$param[]= $branch_code;
		}
		$query=$this->db->query($sql,$param);
		$row=$query->row_array();
		return $row['num'];
	}
	function num_trx_saving_verified_not_yet($branch_code)
	{
		$param=array();
		$sql = "select count(*) as num from mfi_trx_account_saving a, mfi_branch b 
				where a.trx_status = 0 and a.branch_id=b.branch_id";
		if ($branch_code!="00000") {
			$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$query=$this->db->query($sql,$param);
		$row=$query->row_array();
		return $row['num'];
	}
	function num_trx_mutasi_verified_not_yet($branch_code)
	{
		$param= array();
		$sql = "select count(*) as num from mfi_cif_mutasi a, mfi_cif b
				where a.status = 0 and a.tipe_mutasi=1 and a.cif_no=b.cif_no";
		if ($branch_code!="00000") {
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$query=$this->db->query($sql,$param);
		$row=$query->row_array();
		return $row['num'];
	}
	//END CLOSING sayyid

	/*BAGIHASIL*/
	function get_titipan_bagihasil_by_periode($from_date,$thru_date,$flag_debit_credit)
	{
		$sql = "SELECT
					titipan_bagihasil_id,
					cif_no,
					account_saving_no,
					trx_date,
					amount,
					flag_debit_credit,
					keterangan,
					created_by,
					created_stamp,
					bahas_type,
					status
				FROM mfi_titipan_bagihasil 
				WHERE trx_date between ? AND ? 
				AND flag_debit_credit = ?
				AND status=0
				";

		$query = $this->db->query($sql,array($from_date,$thru_date,$flag_debit_credit));

		return $query->result_array();
	}
	function get_amount_titipan_bagihasil_by_cif_no($cif_no,$flag_debit_credit)
	{
		$sql = "SELECT coalesce(sum(amount),0) amount
				FROM mfi_titipan_bagihasil
				WHERE cif_no=? AND flag_debit_credit=? AND status=0
		";
		$query = $this->db->query($sql,array($cif_no,$flag_debit_credit));
		return $query->row_array();
	}
	function get_sum_bonus_titipan($from_date,$thru_date)
	{
		$sql = "SELECT 
					cif_no,
					coalesce(sum(amount),0) amount
				FROM mfi_titipan_bagihasil
				WHERE trx_date between ? AND ? 
				AND flag_debit_credit='D'
				AND status=0
				GROUP BY 1
		";
		
		$query = $this->db->query($sql,array($from_date,$thru_date));

		return $query->result_array();
	}


	/**********************************************************************************/
	//BEGIN BAGI HASIL 17-09-2014
	public function pembiayaan_yg_diberikan($f='',$l='')
	{
		$sql = "SELECT sum(fn_get_saldo_awal_gl_account2(a.code_value,?,'all')+fn_get_average_saldo_gl_account(a.code_value,?,?)) as saldo
				from mfi_list_code_detail a
				where a.code_group like 'bahas_pembiayaan' ";

		$query = $this->db->query($sql,array($f,$f,$l));
		$data =  $query->row_array();
		// print_r($this->db);
		// die();
		return $data['saldo'];
	}	

	function pembiayaan_yg_diberikan_v2($f='',$l=''){
		$from = date('Y-m-d',strtotime($f.' - 1 MONTH'));

		$sql = "SELECT sum(fn_get_saldo_awal_gl_account4(a.code_value,?,'all',?,?)) as saldo
				from mfi_list_code_detail a
				where a.code_group like 'bahas_pembiayaan' ";

		$query = $this->db->query($sql,array($from,$f,$l));
		$data =  $query->row_array();

		return $data['saldo'];
	}	
	public function pendapatan_operasional($f='',$l='')
	{
		$sql = "SELECT 
				coalesce(sum(fn_get_mutasi_gl_account2(a.code_value, ?, ?, 'C', 'all')),0) -
				coalesce(sum(fn_get_mutasi_gl_account2(a.code_value, ?, ?, 'D', 'all')),0) as saldo
				from mfi_list_code_detail a
				where a.code_group like 'bahas_pendapatan'
				 ";

		$query = $this->db->query($sql,array($f,$l,$f,$l));
		$data =  $query->row_array();
		return $data['saldo'];
	}
	function pendapatan_operasional_v2($f='',$l=''){
		$sql = "SELECT 
				coalesce(sum(fn_get_mutasi_gl_account2(a.code_value, ?, ?, 'C', 'all')),0) -
				coalesce(sum(fn_get_mutasi_gl_account2(a.code_value, ?, ?, 'D', 'all')),0) as saldo
				from mfi_list_code_detail a
				where a.code_group like 'bahas_pendapatan'
				 ";

		$query = $this->db->query($sql,array($f,$l,$f,$l));
		$data =  $query->row_array();
		return $data['saldo'];
	}
	public function dana_pihak_ke3($f='',$l='')
	{
		$sql = "SELECT (sum(fn_get_saldo_awal_gl_account2(a.code_value,?,'all')+fn_get_average_saldo_gl_account(a.code_value,?,?))*-1) as saldo
				from mfi_list_code_detail a
				where a.code_group like 'bahas_dp3'
				 ";

		$query = $this->db->query($sql,array($f,$f,$l));
		$data =  $query->row_array();
		return $data['saldo'];
	}
	function dana_pihak_ke3_v2($f='',$l=''){
		$from = date('Y-m-d',strtotime($f.' - 1 MONTH'));
		$sql = "SELECT (sum(fn_get_saldo_awal_gl_account4(a.code_value,?,'all',?,?))*-1) as saldo
				from mfi_list_code_detail a
				where a.code_group like 'bahas_dp3'
				 ";

		$query = $this->db->query($sql,array($from,$f,$l));
		$data =  $query->row_array();
		return $data['saldo'];
	}
	public function generate_product_deposito($l='')
	{
		$sql = "SELECT a.product_code,a.product_name,a.nisbah,
				(coalesce(fn_get_saldo_gl_account2(b.gl_saldo, ?,'all'),0) *-1) as saldo
				from mfi_product_deposit a,mfi_product_deposit_gl b
				where a.product_deposit_gl_code=b.product_deposit_gl_code
				order by 1
				 ";

		$query = $this->db->query($sql,array($l));
		return $query->result_array();
	}	

	function generate_product_deposito_v2($f='',$l=''){
		$from = date('Y-m-d',strtotime($f.' - 1 MONTH'));
		$sql = "SELECT a.product_code,a.product_name,a.nisbah,
				(coalesce(fn_get_saldo_awal_gl_account4(b.gl_saldo,?,'all',?,?),0) *-1) as saldo
				from mfi_product_deposit a,mfi_product_deposit_gl b
				where a.product_deposit_gl_code=b.product_deposit_gl_code
				order by 1
				 ";

		$query = $this->db->query($sql,array($from,$f,$l));
		return $query->result_array();
	}	
	public function generate_product_mudharabah($l='')
	{
		$sql = "SELECT a.product_code,a.product_name,a.nisbah,
				(coalesce(fn_get_saldo_gl_account2(b.gl_saldo, ?,'all'),0) *-1) as saldo
				from mfi_product_saving a,mfi_product_saving_gl b
				where a.product_saving_gl_code=b.product_saving_gl_code and a.akad=111
				order by 1
				 ";

		$query = $this->db->query($sql,array($l));
		return $query->result_array();
	}	
	function generate_product_mudharabah_v2($f='',$l=''){
		$from = date('Y-m-d',strtotime($f.' - 1 MONTH'));
		$sql = "SELECT a.product_code,a.product_name,a.nisbah,
				(coalesce(fn_get_saldo_awal_gl_account4(b.gl_saldo,?,'all',?,?),0) *-1) as saldo
				from mfi_product_saving a,mfi_product_saving_gl b
				where a.product_saving_gl_code=b.product_saving_gl_code and a.akad=111
				order by 1
				 ";

		$query = $this->db->query($sql,array($from,$f,$l));
		return $query->result_array();
	}	
	public function generate_product_wadiah($from_trx_date,$thru_trx_date)
	{
		/*$sql = "SELECT a.product_code,a.product_name,
				(coalesce(fn_get_saldo_gl_account2(b.gl_saldo, ?,'all'),0) *-1) as saldo
				from mfi_product_saving a,mfi_product_saving_gl b
				where a.product_saving_gl_code=b.product_saving_gl_code and a.akad=110
				order by 1
				 ";*/
		$sql = "SELECT a.product_code,a.product_name,
				coalesce(fn_get_saldo_awal_gl_account3(b.gl_saldo,?,'all')+fn_get_average_saldo_gl_account2(b.gl_saldo,?,?),0) as saldo
				from mfi_product_saving a,mfi_product_saving_gl b
				where a.product_saving_gl_code=b.product_saving_gl_code and a.akad=110
				order by 1
				 ";

		$query = $this->db->query($sql,array($from_trx_date,$from_trx_date,$thru_trx_date));
		return $query->result_array();
	}	
	function generate_product_wadiah_v2($f='',$l=''){
		/*
		$sql = "SELECT a.product_code,a.product_name,
				(coalesce(fn_get_saldo_gl_account2(b.gl_saldo, ?,'all'),0) *-1) as saldo
				from mfi_product_saving a,mfi_product_saving_gl b
				where a.product_saving_gl_code=b.product_saving_gl_code and a.akad=110
				order by 1
				 ";
		$sql = "SELECT a.product_code,a.product_name,
				coalesce(fn_get_saldo_awal_gl_account3(b.gl_saldo,?,'all')+fn_get_average_saldo_gl_account2(b.gl_saldo,?,?),0) as saldo
				from mfi_product_saving a,mfi_product_saving_gl b
				where a.product_saving_gl_code=b.product_saving_gl_code and a.akad=110
				order by 1
				 ";
		*/
		$from = date('Y-m-d',strtotime($f.' - 1 MONTH'));
		$sql = "SELECT a.product_code,a.product_name,
				(coalesce(fn_get_saldo_awal_gl_account4(b.gl_saldo,?,'all',?,?),0) * -1) as saldo
				from mfi_product_saving a,mfi_product_saving_gl b
				where a.product_saving_gl_code=b.product_saving_gl_code and a.akad=110
				order by 1";

		$query = $this->db->query($sql,array($from,$f,$l));

		return $query->result_array();
	}	

	public function generate_product_tabungan_anggota($f,$l)
	{
		/*$sql="select
				(coalesce(fn_get_saldo_gl_account2(gl_tab_sukarela, ?,'all'),0) *-1) as saldo_tabungan_sukarela,
				(coalesce(fn_get_saldo_gl_account2(gl_tab_wajib, ?,'all'),0) *-1) as saldo_tabungan_wajib,
				(coalesce(fn_get_saldo_gl_account2(gl_tab_kelompok, ?,'all'),0) *-1) as saldo_tabungan_kelompok
			  from mfi_product_cm_gl
			  where product_cm_gl_code='01'
		";*/
		$sql =" select 
					coalesce(fn_get_saldo_awal_gl_account3(gl_tab_sukarela,?,'all')+fn_get_average_saldo_gl_account2(gl_tab_sukarela,?,?),0) saldo_tabungan_sukarela,
					coalesce(fn_get_saldo_awal_gl_account3(gl_tab_kelompok,?,'all')+fn_get_average_saldo_gl_account2(gl_tab_kelompok,?,?),0) saldo_tabungan_kelompok,
					coalesce(fn_get_saldo_awal_gl_account3(gl_tab_wajib,?,'all')+fn_get_average_saldo_gl_account2(gl_tab_wajib,?,?),0) saldo_tabungan_wajib
				from mfi_product_cm_gl
				where product_cm_gl_code='01'
		";
		$query=$this->db->query($sql,array($f,$f,$l,$f,$f,$l,$f,$f,$l));
		return $query->row_array();
	}
	function generate_product_tabungan_anggota_v2($f,$l){
		/*
		$sql="select
				(coalesce(fn_get_saldo_gl_account2(gl_tab_sukarela, ?,'all'),0) *-1) as saldo_tabungan_sukarela,
				(coalesce(fn_get_saldo_gl_account2(gl_tab_wajib, ?,'all'),0) *-1) as saldo_tabungan_wajib,
				(coalesce(fn_get_saldo_gl_account2(gl_tab_kelompok, ?,'all'),0) *-1) as saldo_tabungan_kelompok
			  from mfi_product_cm_gl
			  where product_cm_gl_code='01'
		";
		$sql =" select 
					coalesce(fn_get_saldo_awal_gl_account3(gl_tab_sukarela,?,'all')+fn_get_average_saldo_gl_account2(gl_tab_sukarela,?,?),0) saldo_tabungan_sukarela,
					coalesce(fn_get_saldo_awal_gl_account3(gl_tab_kelompok,?,'all')+fn_get_average_saldo_gl_account2(gl_tab_kelompok,?,?),0) saldo_tabungan_kelompok,
					coalesce(fn_get_saldo_awal_gl_account3(gl_tab_wajib,?,'all')+fn_get_average_saldo_gl_account2(gl_tab_wajib,?,?),0) saldo_tabungan_wajib
				from mfi_product_cm_gl
				where product_cm_gl_code='01'
		";
		*/
		$from = date('Y-m-d',strtotime($f.' - 1 MONTH'));
		$sql ="SELECT 
		(coalesce(fn_get_saldo_awal_gl_account4(gl_tab_sukarela,?,'all',?,?),0) * -1) saldo_tabungan_sukarela,
		(coalesce(fn_get_saldo_awal_gl_account4(gl_tab_kelompok,?,'all',?,?),0) * -1) saldo_tabungan_kelompok,
		(coalesce(fn_get_saldo_awal_gl_account4(gl_tab_wajib,?,'all',?,?),0) * -1) saldo_tabungan_wajib
		from mfi_product_cm_gl
		where product_cm_gl_code='01'";
		$query=$this->db->query($sql,array($from,$f,$l,$from,$f,$l,$from,$f,$l));
		return $query->row_array();
	}

	public function insert_into_mfi_proyeksi_bahas($data)
	{
		$this->db->insert('mfi_proyeksi_bahas',$data);		
	}

	public function insert_batch_proyeksi_bahas_detail($data)
	{
		$this->db->insert_batch('mfi_proyeksi_bahas_detail',$data);
	}

	function insert_batch_trx_tab_sukarela($data){
		$this->db->insert_batch('mfi_trx_tab_sukarela',$data);
	}

	function insert_distribusi_shu($data){
		$this->db->insert('mfi_distribusi_shu',$data);
	}

	public function insert_proyeksi_bahas_detail($data)
	{
		$this->db->insert('mfi_proyeksi_bahas_detail',$data);		
	}
	public function cek_periode_bahas($b='',$t='')
	{
		$param = array();
		$sql = "SELECT COUNT(*) result FROM mfi_proyeksi_bahas WHERE bulan=? AND tahun=? ";
		$param[] = $b;
		$param[] = $t;

		$query = $this->db->query($sql,$param);
		$data = $query->row_array();
		return $data['result'];
	}
	public function select_proyeksi_bahas_detail($proyeksi_bahas_id='')
	{
		$param = array();
		$sql = "SELECT * FROM mfi_proyeksi_bahas_detail WHERE proyeksi_bahas_id=? ";
		$param[] = $proyeksi_bahas_id;

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}	
	public function get_data_proyeksi_bahas($m='',$y='')
	{
		$param = array();
		$sql = "SELECT * FROM mfi_proyeksi_bahas WHERE tahun=? AND bulan=? ";
		$param[] = $y;
		$param[] = $m;

		$query = $this->db->query($sql,$param);
		return $query->row_array();
	}		
	public function generate_product_komposisi($id_proyeksi_bahas='')
	{
		$param = array();
		$sql = "SELECT * FROM mfi_proyeksi_bahas_detail WHERE proyeksi_bahas_id=? AND product_code not in('97','98','99') ORDER BY product_type DESC ";
		$param[] = $id_proyeksi_bahas;

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}	
	public function datatable_sys_account_setup($sWhere='',$sOrder='',$sLimit='',$code_group='')
	{
		$param = array();
		$sql = "SELECT * FROM mfi_list_code_detail WHERE ";
		if ($code_group==''){
			$sql .= " code_group IN('bahas_pembiayaan','bahas_dp3','bahas_pendapatan') ";
		}else{
			$sql .= " code_group = ? ";
			$param[] = $code_group;
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";
		else
			$sql .= "ORDER BY code_value ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	public function delete_sys_account_bahas($param)
	{
		$this->db->delete('mfi_list_code_detail',$param);
	}	
	public function proses_input_setup_gl_bahas($data)
	{
		$this->db->insert('mfi_list_code_detail',$data);
	}
	public function proses_edit_setup_gl_bahas($data,$param)
	{
		$this->db->update('mfi_list_code_detail',$data,$param);
	}
	public function get_gl_account_bahas_by_id($list_code_detail_id)
	{
		$sql = "SELECT * FROM mfi_list_code_detail WHERE list_code_detail_id = ?";
				
		$query = $this->db->query($sql,array($list_code_detail_id));

		return $query->row_array();
	}

	//END BAGI HASIL
	/**********************************************************************************/
	function get_gl_list_code_detail($code_group)
	{
		$sql = "select code_value,display_text from mfi_list_code_detail where code_group=? limit 1";
		$query = $this->db->query($sql,array($code_group));
		return $query->row_array();
	}

	function fn_proses_jurnal_titipan_bagihasil($proyeksi_bahas_id,$trx_date)
	{
		$sql = "select fn_proses_jurnal_titipan_bagihasil(?,?)";
		$query = $this->db->query($sql,array($proyeksi_bahas_id,$trx_date));
	}

	function getBranchsGL(){
		$sql = "SELECT
		mb.branch_code,
		mb.branch_name
		FROM mfi_branch AS mb
		JOIN mfi_trx_gl AS mtg ON mtg.branch_code = mb.branch_code
		GROUP BY 1,2";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_account_bahas_to_sukarela()
	{
		$sql = "
			select
			(select code_value from mfi_list_code_detail where code_group='gl_titipan_bagihasil') titipan,
			(select gl_tab_sukarela from mfi_product_cm_gl limit 1) sukarela
		";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	function get_amount_titipan_bagihasil($date1,$date2,$branch_code)
	{
		$sql = "
			SELECT * FROM (
				SELECT 
					a.cif_no
					,(coalesce(sum((case when a.flag_debit_credit='D' then 
						a.amount*-1 
					else 
						a.amount 
					end)),0)::integer/500)*500 amount
				FROM mfi_titipan_bagihasil a, mfi_cif b, mfi_cm c, mfi_fa d
				WHERE a.trx_date between ? and ?
				and a.cif_no=b.cif_no
				and b.cm_code=c.cm_code
				and c.fa_code=d.fa_code
				and b.branch_code=?
				and a.flag_debit_credit='C'
				group by 1
				) AS x
				WHERE amount <> 0
		";
		$query = $this->db->query($sql,array($date1,$date2,$branch_code));
		$row = $query->result_array();

		$amount = 0;
		foreach($row as $rw):
			$amount+= $rw['amount'];
		endforeach;

		return $amount;
	}

	public function jqgrid_setup_hari_libur($sidx='',$sord='',$limit_rows='',$start='',$year)
	{
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "
			SELECT * FROM mfi_hari_libur
		";
		$param = array();
		if($year!="all"){
			$sql .= " WHERE extract(year from tanggal) = ?";
			$param[] = $year;
		}
		$sql .= " ORDER BY tanggal ASC";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	} 

	function getYearHariLibur()
	{
		$sql = "
			SELECT extract(year from tanggal) as year
			from mfi_hari_libur
			group by 1
			order by 1 asc
		";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_setup_hari_libur_by_id($id)
	{
		$sql = "
			SELECT * FROM mfi_hari_libur WHERE id = ?
		";
		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}

	function get_branch_awaltahun($tahun)
	{
		$sql = "select a.branch_code,a.branch_name from mfi_branch a, mfi_titipan_bagihasil b
		where a.branch_code not in(select branch_code from mfi_proses_awaltahun_log where tahun=?)
		and a.branch_class<>0
		and a.branch_code=b.branch_code
		and extract(year from b.trx_date) = ?
		group by 1,2
		order by a.branch_code asc
		";
		$query = $this->db->query($sql,array($tahun,$tahun-1));
		return $query->result_array();
	}

	function check_status_cif_no($cif_no){
		$sql = "SELECT status FROM mfi_cif WHERE cif_no = ?";

		$param = array($cif_no);

		$query = $this->db->query($sql,$param);

		return $query;
	}

	function insert_shu_sukarela($data){
		$this->db->insert('mfi_trx_shu_sukarela',$data);
	}

	function update_default_account_balance($amount,$cif_no){
		$sql = "UPDATE mfi_account_default_balance SET tabungan_sukarela = tabungan_sukarela + ? WHERE cif_no = ?";

		$param = array($amount,$cif_no);

		$query = $this->db->query($sql,$param);
	}

	function insert_shu_sukarela_rejected($data){
		$this->db->insert('mfi_trx_shu_sukarela_rejected',$data);
	}

	function get_product_financing(){
		$sql = "SELECT
		mpf.product_code,
		mpf.product_name,
		mpfg.gl_saldo_pokok
		FROM mfi_product_financing AS mpf
		JOIN mfi_product_financing_gl AS mpfg ON mpfg.product_financing_gl_code = mpf.product_financing_gl_code
		ORDER BY product_code";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_rinci_kelompok($branch_code,$product_code,$from_date,$thru_date){
		$param = array();

		$sql = "SELECT
		COALESCE(SUM(mtc.droping),0) AS debet,
		COALESCE(SUM(mtcd.freq * mtcd.angsuran_pokok),0) AS credit
		FROM mfi_trx_cm_detail AS mtcd
		JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mtcd.account_financing_no
		WHERE mtcd.freq > 0  AND maf.product_code = ? ";

		$param[] = $product_code;

		if($branch_code != '00000'){
			$sql .= "AND maf.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "AND mtc.trx_date BETWEEN ? AND ?";
		$param[] = $from_date;
		$param[] = $thru_date;

		$query = $this->db->query($sql,$param);

		return $query->row_array();

	}

	function get_product_financing_by_jenis($jenis_pembiayaan){
		$sql = "SELECT
		mpf.product_code,
		mpf.product_name,
		mpfg.gl_saldo_pokok
		FROM mfi_product_financing AS mpf
		JOIN mfi_product_financing_gl AS mpfg ON mpfg.product_financing_gl_code = mpf.product_financing_gl_code
		WHERE mpf.jenis_pembiayaan = ?
		ORDER BY product_code";

		$param = array($jenis_pembiayaan);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_saldo_awal_by_product_code($branch_code,$product_code,$from_date){
		$sql = "SELECT
		COALESCE(SUM(saldo),0) AS saldo_awal
		FROM mfi_closing_ledger_data WHERE account_code = ? AND closing_from_date = ?
		AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";

		$param = array($product_code,$from_date,$branch_code);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function get_mutasi_debet_credit_by_product_code($branch_code,$gl_saldo_pokok,$from_date,$thru_date){
		$sql = "SELECT
		mtg.trx_gl_id,
		(SELECT COALESCE(SUM(amount),0) FROM mfi_trx_gl_detail WHERE trx_gl_id = mtg.trx_gl_id AND account_code = ? AND flag_debit_credit = 'D') AS debet,
		(SELECT COALESCE(SUM(amount),0) FROM mfi_trx_gl_detail WHERE trx_gl_id = mtg.trx_gl_id AND account_code = ? AND flag_debit_credit = 'C') AS credit
		FROM mfi_trx_gl AS mtg
		WHERE mtg.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) AND mtg.voucher_date BETWEEN ? AND ?";

		$param = array($gl_saldo_pokok,$gl_saldo_pokok,$branch_code,$from_date,$thru_date);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function get_rinci_financing($branch_code){
		$param = array();

		$sql = "SELECT
		f.branch_code,
		f.branch_name,
		d.gl_saldo_pokok AS account_code,
		e.account_name,
		COALESCE(SUM(a.saldo_pokok),0) AS saldo_rinci
		FROM mfi_account_financing AS a
		JOIN mfi_product_financing AS c ON c.product_code = a.product_code
		JOIN mfi_product_financing_gl AS d ON d.product_financing_gl_code = c.product_financing_gl_code
		JOIN mfi_gl_account AS e ON e.account_code = d.gl_saldo_pokok
		JOIN mfi_branch AS f ON f.branch_code = a.branch_code
		WHERE a.status_rekening = '1' ";

		if($branch_code != '00000'){
			$sql .= "AND a.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2,3,4 ORDER BY 1,4";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_rinci_saving($branch_code){
		$param = array();

		$sql = "SELECT
		f.branch_code,
		f.branch_name,
		d.gl_saldo AS account_code,
		e.account_name,
		COALESCE(SUM(a.saldo_memo),0) AS saldo_rinci
		FROM mfi_account_saving AS a
		JOIN mfi_product_saving AS c ON c.product_code = a.product_code
		JOIN mfi_product_saving_gl AS d ON d.product_saving_gl_code = c.product_saving_gl_code
		JOIN mfi_gl_account AS e ON e.account_code = d.gl_saldo
		JOIN mfi_branch AS f ON f.branch_code = a.branch_code
		WHERE a.status_rekening = '1' ";

		if($branch_code != '00000'){
			$sql .= "AND a.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2,3,4 ORDER BY 1,4";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_ledger($account_code,$from,$thru,$closing_date,$branch_code){
		$param = array();

		$sql = "SELECT
		b.branch_code,
		a.account_code,
		a.account_name,
		COALESCE(b.saldo,0) AS saldo_awal,
		(SELECT COALESCE(SUM(c.amount),0) FROM mfi_trx_gl_detail AS c, mfi_trx_gl AS d WHERE c.trx_gl_id = d.trx_gl_id AND c.flag_debit_credit = 'D' AND c.account_code = a.account_code AND d.branch_code = b.branch_code AND d.trx_date BETWEEN ? AND ?) AS debet,
		(SELECT COALESCE(SUM(c.amount),0) FROM mfi_trx_gl_detail AS c, mfi_trx_gl AS d WHERE c.trx_gl_id = d.trx_gl_id AND c.flag_debit_credit = 'C' AND c.account_code = a.account_code AND d.branch_code = b.branch_code AND d.trx_date BETWEEN ? AND ?) AS credit  
		FROM mfi_gl_account AS a
		LEFT JOIN mfi_closing_ledger_data AS b ON a.account_code = b.account_code AND b.branch_code = ? AND b.closing_from_date = ? AND b.flag_akhir_tahun = 'T'
		WHERE a.account_code = ? ";

		$param[] = $from;
		$param[] = $thru;
		$param[] = $from;
		$param[] = $thru;
		$param[] = $branch_code;
		$param[] = $closing_date;
		$param[] = $account_code;

		/*
		if($branch_code != '00000'){
			$sql .= "AND b.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "AND b.closing_from_date = ? AND b.flag_akhir_tahun = 'T'";
		$param[] = $closing_date;
		*/

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function get_outstanding($branch_code,$product_code){
		$sql = "SELECT COALESCE(SUM(saldo_pokok),0) AS saldo_pokok FROM mfi_account_financing WHERE product_code = ? AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";

		$param = array($product_code,$branch_code);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function hitung_pembiayaan_new($branch_code,$from_date,$thru_date){
		$param = array();

		$sql = "SELECT
		mpf.product_code,
		COALESCE(SUM(debet.amount),0) AS debet,
		COALESCE(SUM(credit.amount),0) AS credit,
		maf.saldo_pokok
		FROM mfi_product_financing AS mpf
		JOIN mfi_account_financing AS maf ON maf.product_code = mpf.product_code
		JOIN mfi_trx_gl AS mtg ON mtg.branch_code = maf.branch_code
		LEFT JOIN mfi_trx_gl_detail AS debet ON debet.trx_gl_id = mtg.trx_gl_id AND debet.account_code = mpf.product_financing_gl_code AND debet.flag_debit_credit = 'D'
		LEFT JOIN mfi_trx_gl_detail AS credit ON credit.trx_gl_id = mtg.trx_gl_id AND credit.account_code = mpf.product_financing_gl_code AND credit.flag_debit_credit = 'C'
		WHERE maf.status_rekening = '1' ";

		if($branch_code != '00000'){
			$sql .= "AND maf.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "AND mtg.voucher_date BETWEEN ? AND ? ";

		$param[] = $from_date;
		$param[] = $thru_date;

		$sql .= "GROUP BY 1,4 ORDER BY 1";

		$query = $this->db->result_array();
	}

	function hitung_pembiayaan($branch_code,$from_date,$thru_date){
		$sql = "SELECT
		c.product_name,
		c.product_financing_gl_code,

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_financing_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id ";

		$param = array();

		if($branch_code != '00000'){
			$sql .= "AND x.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "AND x.voucher_date <= ? AND y.flag_debit_credit = 'D'
		AND y.account_code = z.gl_saldo_pokok
		AND z.product_financing_gl_code = c.product_financing_gl_code) - 

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_financing_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id ";

		$param[] = $thru_date;

		if($branch_code != '00000'){
			$sql .= "AND x.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}
		
		$sql .= "AND x.voucher_date <= ? AND y.flag_debit_credit = 'C'
		AND y.account_code = z.gl_saldo_pokok
		AND z.product_financing_gl_code = c.product_financing_gl_code) AS ledger,

		SUM(a.saldo_pokok) AS rinci

		FROM mfi_account_financing AS a, mfi_product_financing AS c
		WHERE a.status_rekening = '1' ";

		$param[] = $thru_date;
		
		if($branch_code != '00000'){
			$sql .= "AND a.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}
		
		$sql .= "AND a.product_code = c.product_code
		GROUP BY 1,2";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function hitung_catab($branch_code,$from_date,$thru_date){
		$sql = "SELECT

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'C'
		AND y.account_code IN(
		SELECT gl_saldo_catab FROM mfi_product_financing_gl LIMIT 1
		)) -

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'D'
		AND y.account_code IN(
		SELECT gl_saldo_catab FROM mfi_product_financing_gl LIMIT 1
		)) AS ledger,

		SUM(saldo_catab) AS total_catab

		FROM mfi_account_financing
		WHERE status_rekening = '1' AND branch_code = ?
		";

		$param = array(
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code
		);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function hitung_member($branch_code,$from_date,$thru_date){
		$sql = "SELECT

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_cm_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'C'
		AND y.account_code = z.gl_tab_wajib) -

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_cm_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'D'
		AND y.account_code = z.gl_tab_wajib) AS ledger_tawab,

		SUM(a.tabungan_wajib) AS total_tawab,

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_cm_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'C'
		AND y.account_code = z.gl_tab_kelompok) -

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_cm_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'D'
		AND y.account_code = z.gl_tab_kelompok) AS ledger_takel,

		SUM(a.tabungan_kelompok) AS total_takel,

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_cm_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'C'
		AND y.account_code = z.gl_tab_sukarela) -

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_cm_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'D'
		AND y.account_code = z.gl_tab_sukarela) AS ledger_tasuk,

		SUM(a.tabungan_sukarela) AS total_tasuk,

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_cm_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'C'
		AND y.account_code = z.gl_tab_lwk) -

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_cm_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'D'
		AND y.account_code = z.gl_tab_lwk) AS ledger_lwk,

		SUM(a.setoran_lwk) AS total_lwk

		FROM mfi_account_default_balance AS a, mfi_cif AS b
		WHERE b.branch_code = ? AND b.status = '1'
		AND a.cif_no = b.cif_no";

		$param = array(
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code
		);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function hitung_saving($branch_code,$from_date,$thru_date){
		$sql = "SELECT
		c.product_name,
		c.product_saving_gl_code,

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_saving_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'C'
		AND y.account_code = z.gl_saldo
		AND z.product_saving_gl_code = c.product_saving_gl_code) -

		(SELECT SUM(y.amount)
		FROM mfi_trx_gl AS x, mfi_trx_gl_detail AS y, mfi_product_saving_gl AS z 
		WHERE x.trx_gl_id = y.trx_gl_id AND x.branch_code = ?
		AND x.voucher_date <= ? AND y.flag_debit_credit = 'D'
		AND y.account_code = z.gl_saldo
		AND z.product_saving_gl_code = c.product_saving_gl_code) AS ledger,

		SUM(a.saldo_memo) AS rinci

		FROM mfi_account_saving AS a, mfi_product_saving AS c
		WHERE a.status_rekening = '1' AND a.branch_code = ?
		AND a.product_code = c.product_code
		GROUP BY 1,2";

		$param = array(
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code,
			$thru_date,
			$branch_code
		);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_amount_mutasi_ledger($branch_code,$account_code)
	{
		$sql = "
			select
				total_trx_debet,
				total_trx_credit
			from mfi_gl_account_summary_mutasi
			where branch_code=? and account_code=?
		";
		$query = $this->db->query($sql,array($branch_code,$account_code));
		$row = $query->row_array();
		if (count($row)>0) {
			return $row;
		} else {
			return array(
				 'total_trx_debet'=>0
				,'total_trx_credit'=>0
			);
		}
	}

	function get_shu_tahun($cabang,$from,$thru,$account_code){
		$param = array();

		$sql = "SELECT SUM(saldo) AS saldo FROM mfi_closing_ledger_data WHERE closing_from_date = ? AND closing_thru_date = ? AND account_code LIKE ?";

		$param[] = $from;
		$param[] = $thru;
		$param[] = $account_code.'%';

		if($cabang != '00000'){
			$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $cabang;
		}

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function cek_distribusi_shu($tahun){
		$sql = "SELECT * FROM mfi_distribusi_shu WHERE tahun = ?::VARCHAR";

		$param = array($tahun);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function get_saldo_margin($cabang,$from,$thru){
		$param = array();

		$sql = "SELECT
		mc.cif_no,
		COALESCE(SUM(mtcd.angsuran_margin),0) AS margin_kelompok,
		(SELECT COALESCE(SUM(mtaf.margin),0) FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf WHERE mtaf.account_financing_no = maf.account_financing_no AND maf.cif_no = mc.cif_no AND mtaf.trx_date BETWEEN ? AND ?) AS margin_individu
		FROM mfi_cif AS mc
		JOIN mfi_trx_cm_detail AS mtcd ON mtcd.cif_no = mc.cif_no
		JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		WHERE mc.status = '1' ";

		$param[] = $from;
		$param[] = $thru;

		if($cabang != '00000'){
			$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		$sql .= "AND mtc.trx_date BETWEEN ? AND ? ";

		$param[] = $from;
		$param[] = $thru;
		
		$sql .= "GROUP BY 1 ORDER BY 1";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_saldo_modal($cabang){
		$param = array();
		$sql = "SELECT
		mc.cif_no,
		COALESCE(SUM(madb.tabungan_wajib),0) AS tabungan_wajib,
		COALESCE(SUM(madb.setoran_lwk),0) AS setoran_lwk,
		COALESCE(SUM(madb.simpanan_pokok),0) AS simpanan_pokok
		FROM mfi_cif AS mc
		JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		WHERE mc.status = '1' ";

		if($cabang != '00000'){
			$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		$sql .= "GROUP BY 1 ORDER BY 1";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

}