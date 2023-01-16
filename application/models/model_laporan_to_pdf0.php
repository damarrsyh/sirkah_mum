<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_laporan_to_pdf extends CI_Model {

	/****************************************************************************************/	
	// BEGIN SALDO KAS PETUGAS
	/****************************************************************************************/


	public function export_saldo_kas_petugas($cabang='',$tanggal)
	{
		$sql = " SELECT 
						mfi_gl_account_cash.account_cash_code,
						mfi_fa.fa_name,
						fn_get_saldoawal_kaspetugas(mfi_gl_account_cash.account_cash_code,?,0) as saldoawal,
						fn_get_mutasi_kaspetugas(mfi_gl_account_cash.account_cash_code,?,'D') as mutasi_debet,
						fn_get_mutasi_kaspetugas(mfi_gl_account_cash.account_cash_code,?,'C') as mutasi_credit
				from 	
						mfi_gl_account_cash 
				left outer join mfi_fa on (mfi_gl_account_cash.fa_code=mfi_fa.fa_code)
				where 
						mfi_fa.branch_code=? and mfi_gl_account_cash.account_cash_type = '0'
				order by mfi_gl_account_cash.account_cash_code ";

		$query = $this->db->query($sql,array($tanggal,$tanggal,$tanggal,$cabang));
		// print_r($this->db);
		return $query->result_array();
	}

	public function get_cabang($cabang='')
	{
		$sql = " SELECT 
						branch_name
				from 	
						mfi_branch 
				where 
						branch_code=? ";

		$query = $this->db->query($sql,array($cabang));
		$row = $query->row_array();
		return $row['branch_name'];
	}

	/****************************************************************************************/	
	// END SALDO KAS PETUGAS
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN TRANSAKSI KAS PETUGAS
	/****************************************************************************************/


	public function export_transaksi_kas_petugas($tanggal,$tanggal2,$account_cash_code)
	{
		$sql = "SELECT 
		a.trx_gl_cash_type,
		a.trx_date,
		b.display_text trx_type,
		a.description,
		a.flag_debet_credit,
		(case when a.flag_debet_credit='D' then a.amount else 0 end) as trx_debet,
		(case when a.flag_debet_credit='C' then a.amount else 0 end) as trx_credit
		from 
		mfi_trx_gl_cash as a
		left outer join 
		mfi_list_code_detail b on (a.trx_gl_cash_type=CAST(b.code_value as integer) 
		and b.code_group='trx_gl_cash_type')
		where 
		a.trx_date between ? and ?
		and a.account_cash_code = ?
		order by a.trx_date,a.trx_gl_cash_type,a.created_date";

		$query = $this->db->query($sql,array($tanggal,$tanggal2,$account_cash_code));	
		return $query->result_array();
	}

	/****************************************************************************************/	
	// END TRANSAKSI KAS PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN LABA RUGI
	/****************************************************************************************/


	public function export_lap_lr($cabang='')
	{
		$sql = "SELECT
				mfi_gl_report.report_code,
				mfi_gl_report.report_name,
				mfi_gl_report_item.item_code,
				mfi_gl_report_item.item_name,
				mfi_gl_report_item.posisi,
				mfi_gl_report_item.item_type,
				mfi_gl_report.report_type
				FROM
				mfi_gl_report
				INNER JOIN mfi_gl_report_item ON mfi_gl_report_item.report_code = mfi_gl_report.report_code
				where 
				mfi_gl_report.report_type=?
				order by mfi_gl_account_cash.account_cash_code ";

		$query = $this->db->query($sql,array($cabang));
		// print_r($this->db);
		return $query->result_array();
	}

	public function getReportItem()
	{
		$sql = "SELECT * FROM v_report_finansial WHERE report_code = '20'";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}

	/*public function getReportItem()
	{
		$sql = "SELECT
				mfi_gl_report.report_code,
				mfi_gl_report.report_name,
				mfi_gl_report_item.item_code,
				mfi_gl_report_item.item_name,
				mfi_gl_report_item.posisi,
				mfi_gl_report_item.item_type,
				mfi_gl_report.report_type
				FROM
				mfi_gl_report
				INNER JOIN mfi_gl_report_item ON mfi_gl_report_item.report_code = mfi_gl_report.report_code
				WHERE mfi_gl_report.report_type=1
				ORDER BY mfi_gl_report_item.item_code ASC
				";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}*/

	/****************************************************************************************/	
	// END LAPORAN LABA RUGI
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN NERACA_GL
	/****************************************************************************************/
	public function export_neraca_gl($branch_code,$from_date,$last_date)
	{
		$param = array();
		// $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
		$report_code='10';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1         
			              else  
			                fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)         
			              end  
			        END AS saldo_mutasi
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";

		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = $from_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = 'all';

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = $from_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $branch_code;

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

			/* saldo mutasi */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes2=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount2=array();
				for($j=0;$j<count($item_codes2);$j++){
					$arr_amount2[$item_codes2[$j]]=$this->get_amount_mutasi_from_item_code($item_codes2[$j],$from_date,$last_date,$branch_code,$report_code);
				}
				$formula2=$rows[$i]['formula'];
				foreach($arr_amount2 as $key2=>$value2):
				$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
				endforeach;
				if($formula2!=""){
					$sqlsal2="select ($formula2) as saldo";
					$quesal2=$this->db->query($sqlsal2);
					$rowsal2=$quesal2->row_array();
					$saldo_mutasi=$rowsal2['saldo'];
				}else{
					$saldo_mutasi=0;
				}
			}else{
				$saldo_mutasi=$rows[$i]['saldo_mutasi'];
			}
			$row[$i]['saldo_mutasi'] = $saldo_mutasi;
		}
		return $row;
	}
	public function export_neraca_gl2($branch_code,$last_date)
	{
		$param = array();
		$report_code='10';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";

		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);

		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

		}
		return $row;
	}
	// END NERACA_GL
	/****************************************************************************************/

	// BEGIN KEUANGAN BULANAN 

	function export_keuangan_neraca_bulanan($branch_code,$last_date,$report_code,$bulan){
		$param = array(); 

		if($branch_code=="00000"){
			$sql = "SELECT
			a.report_code,
			a.item_code,
			a.item_type,
			a.posisi,
			a.display_saldo,
			a.formula,
			a.formula_text_bold,
			CASE
	            WHEN a.posisi = 0 THEN '<b>'||a.item_name||'</b>'
	            WHEN a.posisi = 1 THEN ('  '||a.item_name::TEXT)::character varying
	            WHEN a.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::TEXT ||a.item_name::TEXT)::character varying
	            WHEN a.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::TEXT || a.item_name::TEXT)::character varying
	            ELSE a.item_name
	        END AS item_name,
	        (select CASE WHEN a.display_saldo = 1 THEN coalesce(sum(c.saldo*-1),0) ELSE coalesce(sum(c.saldo),0)  END 
			 from mfi_closing_ledger_data c, mfi_gl_report_item_member b 
			 where c.account_code = b.account_code and b.gl_report_item_id=a.gl_report_item_id 
			 and c.closing_thru_date =? and c.flag_akhir_tahun = 'T' 
			 ) saldo 

			FROM mfi_gl_report_item a 			
			WHERE a.report_code = ? ";

			$sql .= " ORDER BY 1,2 ";  

			/* param saldo awal */
			$param[] = $last_date;			
			/* param report group */
			$param[] = $report_code;
		}else{

			$sql = "SELECT
			a.report_code, 
			a.item_code,
			a.item_type,
			a.posisi,
			a.display_saldo,
			a.formula,
			a.formula_text_bold,
			CASE
	            WHEN a.posisi = 0 THEN '<b>'||a.item_name||'</b>'
	            WHEN a.posisi = 1 THEN ('  '||a.item_name::text)::character varying
	            WHEN a.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text ||a.item_name::text)::character varying
	            WHEN a.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || a.item_name::text)::character varying
	            ELSE a.item_name
	        END AS item_name,
	        (select CASE WHEN a.display_saldo = 1 THEN coalesce(sum(c.saldo*-1),0) ELSE coalesce(sum(c.saldo),0)  END 
			 from mfi_closing_ledger_data c, mfi_gl_report_item_member b 
			 where c.account_code = b.account_code and b.gl_report_item_id=a.gl_report_item_id 
			 and c.closing_thru_date =? and c.flag_akhir_tahun = 'T' 
			 and c.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk =?) ) saldo 
			FROM mfi_gl_report_item a 
			 
			WHERE a.report_code = ? ";

			$sql .= " ORDER BY 1,2 ";

			/* param saldo awal */
			$param[] = $last_date;
			$param[] = $branch_code;
			/* param report group */
			$param[] = $report_code;
		}		 

		$query = $this->db->query($sql,$param);

		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_bulanan($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

		}
		return $row;
	} 

	function saldo_awal_desember($cabang,$from_date,$last_date,$report_code,$item_code){
		$param = array();
		$sql = "SELECT SUM(saldo_awal) AS saldo FROM mfi_closing_ledger_data WHERE closing_from_date = ? AND closing_thru_date = ? AND account_code IN(SELECT account_code FROM mfi_gl_report_item_member WHERE gl_report_item_id IN(SELECT gl_report_item_id FROM mfi_gl_report_item WHERE report_code = ? AND item_code = ?))";

		$param[] = $from_date;
		$param[] = $last_date;
		$param[] = $report_code;
		$param[] = $item_code;

		if($cabang != '00000'){
			$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $cabang;
		}

		$query = $this->db->query($sql,$param);
		return $query->row_array();
	}

	function fn_get_mutasi_amount_gl_report_item($cabang,$report_code,$item_code,$from_date,$last_date,$flag_debit_credit){
		$sql = "SELECT fn_get_mutasi_amount_gl_report_item(?,?,?,?,?,?) AS saldo";
		$param = array($cabang,$report_code,$item_code,$from_date,$last_date,$flag_debit_credit);
		$query = $this->db->query($sql,$param);
		return $query->row_array();
	}

	// BEGIN KEUANGAN TEMPORARY
	function getClosing($cabang){
		$sql = "SELECT
		mcld.account_code,
		mb.branch_code
		FROM mfi_closing_ledger_data AS mcld, mfi_branch AS mb ";

		$param = array();

		if($cabang != '00000'){
			$sql .= "WHERE mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 2,1";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_ledger(){
		$sql = "SELECT account_code FROM mfi_gl_account";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function show_saldo_awal($account_code,$branch,$from){
		$sql = "SELECT
		COALESCE(saldo,0) AS saldo
		FROM mfi_closing_ledger_data
		WHERE account_code = ? AND closing_from_date = ?";

		$param = array();

		$param[] = $account_code;
		$param[] = $from;

		if($branch != '00000'){
			$sql .= " AND branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch;
		}

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function show_debet($account_code,$cabang,$from,$thru){
		$sql = "SELECT
		COALESCE(SUM(mtgd.amount),0) AS debet
		FROM mfi_trx_gl_detail AS mtgd, mfi_trx_gl AS mtg
		WHERE mtgd.trx_gl_id = mtg.trx_gl_id AND mtgd.account_code = ?
		AND mtgd.flag_debit_credit = 'D' ";

		$param = array();

		$param[] = $account_code;

		if($cabang != '00000'){
			$sql .= "AND mtg.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		$sql .= "AND mtg.voucher_date BETWEEN ? AND ?";
		$param[] = $from;
		$param[] = $thru;

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function show_credit($cabang,$from,$thru){
		$sql = "SELECT
		COALESCE(SUM(mtgd.amount),0) AS debet
		FROM mfi_trx_gl_detail AS mtgd, mfi_trx_gl AS mtg
		WHERE mtgd.trx_gl_id = mtg.trx_gl_id AND mtgd.account_code = ?
		AND mtgd.flag_debit_credit = 'C' ";

		$param = array();

		$param[] = $account_code;

		if($cabang != '00000'){
			$sql .= "AND mtg.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		$sql .= "AND mtg.voucher_date BETWEEN ? AND ?";
		$param[] = $from;
		$param[] = $thru;

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function show_saldo_db_cr($account_code,$cabang){
		$sql = "SELECT
		COALESCE(SUM(saldo_awal + (total_mutasi_debet - total_mutasi_credit)),0) AS saldo_akhir
		FROM mfi_report_financing_temporary
		WHERE account_code = ? ";

		$param = array();

		$param[] = $account_code;

		if($cabang != '00000'){
			$sql .= "AND branch_code = ? ";
			$param[] = $cabang;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function update_temp($data,$param){
		$this->db->update('mfi_report_financing_temporary',$data,$param);
	}

	function delete_temp($data){
		$this->db->delete('mfi_report_financing_temporary',$data);
	}

	function insert_temp($cabang,$fromlm,$from,$thru,$user_id,$flag_akhir_tahun){
		$sql = "SELECT fn_insert_report_temporary(?,?,?,?,?,?)";

		$param = array($cabang,$fromlm,$from,$thru,$user_id,$flag_akhir_tahun);

		$query = $this->db->query($sql,$param);
	}


	function insert_temp_2($cabang,$report_code,$fromlm,$from,$thru,$user_id,$flag_akhir_tahun){
		$sql = "SELECT fn_insert_keuangan_report(?,?,?,?,?,?,?)";

		$param = array($cabang,$report_code,$fromlm,$from,$thru,$user_id,$flag_akhir_tahun);

		$query = $this->db->query($sql,$param);
	}


	function insert_absen_report($cabang,$majelis,$from,$thru,$user_id){
		$sql = "SELECT fn_insert_absen_report(?,?,?,?,?)";

		$param = array($cabang,$majelis,$from,$thru,$user_id);

		$query = $this->db->query($sql,$param);
	}

	function insert_trx_cm_detail_temp( $cabang, $from, $thru, $user_id){
		$sql = "SELECT fn_insert_trx_cm_detail_temp(?,?,?,?)";

		$param = array($cabang, $from, $thru, $user_id);

		$query = $this->db->query($sql,$param);
	}


	function insert_temp_bd($cabang,$report_code,$fromlm,$from,$thru,$user_id,$breakdown = '',$flag_akhir_tahun){
		$sql = "SELECT fn_insert_keuangan_report_bd(?,?,?,?,?,?,?,?)";

		$param = array($cabang,$report_code,$fromlm,$from,$thru,$user_id,$breakdown,$flag_akhir_tahun);

		$query = $this->db->query($sql,$param);
	}

	// BEGIN NERACA TEMP
	function export_neraca_temp($branch_code,$report_code){
		$param = array();

		$user_id = $this->session->userdata('user_id');

		if($branch_code=="00000"){

			$sql = "SELECT a.report_code, a.item_code, a.item_type, a.posisi, a.display_saldo, a.formula, a.formula_text_bold, 
					CASE
			            WHEN a.posisi = 0 THEN '<b>'||a.item_name||'</b>'
			            WHEN a.posisi = 1 THEN ('  '||a.item_name::text)::character varying
			            WHEN a.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text ||a.item_name::text)::character varying
			            WHEN a.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || a.item_name::text)::character varying
			            ELSE a.item_name
			        END AS item_name,
			        COALESCE(CASE
			            WHEN a.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when a.display_saldo = 1 
			                 then sum(c.saldo_akhir)*-1         
			              else  
			                 sum(c.saldo_akhir)         
			              end  
			        END,0) AS saldo
				from mfi_gl_report_item a 
				left outer join mfi_gl_report_item_member b on a.gl_report_item_id=b.gl_report_item_id 
				left outer join mfi_report_financing_temporary c on b.account_code = c.account_code 
				where a.report_code=? and c.user_id = ?
				group by 1,2,3,4,5,6,7,8  
				order by 1,2 "; 
			$param[] = $report_code;
			$param[] = $user_id;

		}else{
			
			$sql = "SELECT a.report_code, a.item_code, a.item_type, a.posisi, a.display_saldo, a.formula, a.formula_text_bold, 
					CASE
			            WHEN a.posisi = 0 THEN '<b>'||a.item_name||'</b>'
			            WHEN a.posisi = 1 THEN ('  '||a.item_name::text)::character varying
			            WHEN a.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text ||a.item_name::text)::character varying
			            WHEN a.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || a.item_name::text)::character varying
			            ELSE a.item_name
			        END AS item_name,
			        COALESCE(CASE
			            WHEN a.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when a.display_saldo = 1 
			                 then sum(c.saldo_akhir)*-1         
			              else  
			                 sum(c.saldo_akhir)        
			              end  
			        END,0) AS saldo
				from mfi_gl_report_item a 
				left outer join mfi_gl_report_item_member b on a.gl_report_item_id=b.gl_report_item_id 
				left outer join mfi_report_financing_temporary c on b.account_code = c.account_code 
				where c.branch_code in (select branch_code from mfi_branch_member where branch_induk=?) 
				and a.report_code=? and c.user_id = ?
				group by 1,2,3,4,5,6,7,8  
				order by 1,2 "; 

			$param[] = $branch_code;
			$param[] = $report_code;
			$param[] = $user_id;
		} 		

		$query = $this->db->query($sql,$param);

		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_temp($item_codes[$j],$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

		}
		return $row;
	}

	function export_neraca_temp_2($branch_code,$report_code,$breakdown,$user_id){
		$param = array();

		$sql = "SELECT
		report_code,
		item_code,
		item_type,
		posisi,
		display_saldo,
		formula,
		formula_text_bold,
		item_name,
		COALESCE(CASE WHEN item_type = '0' THEN NULL::INTEGER ELSE CASE WHEN display_saldo = '1' THEN SUM(saldo) * (-1) ELSE SUM(saldo) END END,0) AS saldo
		FROM mfi_keuangan_report
		WHERE report_code = ? AND created_by = ? ";

		$param[] = $report_code;
		$param[] = $user_id;

		if($branch_code != '00000'){
			$sql .= "AND report_branch IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY
		report_code,
		item_code,
		item_type,
		posisi,
		display_saldo,
		formula,
		formula_text_bold,
		item_name ";
		$sql .= "ORDER BY report_code, item_code";

		$query = $this->db->query($sql,$param);

		$rows=$query->result_array();

		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];

			if($breakdown == 'Y'){
				$first_saldo = $rows[$i]['saldo'] / 2;
			} else {
				$first_saldo = $rows[$i]['saldo'];
			}

			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_temp_2($item_codes[$j],$branch_code,$report_code,$user_id);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$first_saldo;		
			}
			$row[$i]['saldo'] = $saldo;	

		}
		return $row;
	}

	// BEGIN LABA RUGI TEMP
	function export_lr_temp($branch_code,$report_code){
		$param = array();

		$user_id = $this->session->userdata('user_id');

		if($branch_code=="00000"){

			$sql = "SELECT a.report_code, a.item_code, a.item_type, a.posisi, a.display_saldo, a.formula, a.formula_text_bold, 
					CASE
			            WHEN a.posisi = 0 THEN '<b>'||a.item_name||'</b>'
			            WHEN a.posisi = 1 THEN ('  '||a.item_name::text)::character varying
			            WHEN a.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text ||a.item_name::text)::character varying
			            WHEN a.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || a.item_name::text)::character varying
			            ELSE a.item_name
			        END AS item_name,
			        CASE
			            WHEN a.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when a.display_saldo = 1 
			                 then sum(c.saldo_awal)*-1         
			              else  
			                 sum(c.saldo_awal)  
			              end  
			        END AS saldo, 
			        CASE
			            WHEN a.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when a.display_saldo = 1 
			                 then sum(c.total_mutasi_debet-c.total_mutasi_credit)*-1         
			              else  
			                 sum(c.total_mutasi_debet-c.total_mutasi_credit)  
			              end  
			        END AS saldo_mutasi 
				from mfi_gl_report_item a 
				left outer join mfi_gl_report_item_member b on a.gl_report_item_id=b.gl_report_item_id 
				left outer join mfi_report_financing_temporary c on b.account_code = c.account_code 
				where a.report_code=? and c.user_id=?
				group by 1,2,3,4,5,6,7,8  
				order by 1,2 "; 

			$param[] = $report_code;
			$param[] = $user_id;
		}
		else 
		{
		$sql = "SELECT a.report_code, a.item_code, a.item_type, a.posisi, a.display_saldo, a.formula, a.formula_text_bold, 
					CASE
			            WHEN a.posisi = 0 THEN '<b>'||a.item_name||'</b>'
			            WHEN a.posisi = 1 THEN ('  '||a.item_name::text)::character varying
			            WHEN a.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text ||a.item_name::text)::character varying
			            WHEN a.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || a.item_name::text)::character varying
			            ELSE a.item_name
			        END AS item_name,
			        CASE
			            WHEN a.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when a.display_saldo = 1 
			                 then sum(c.saldo_awal)*-1         
			              else  
			                 sum(c.saldo_awal)  
			              end  
			        END AS saldo, 
			        CASE
			            WHEN a.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when a.display_saldo = 1 
			                 then sum(c.total_mutasi_debet-c.total_mutasi_credit)*-1         
			              else  
			                 sum(c.total_mutasi_debet-c.total_mutasi_credit)  
			              end  
			        END AS saldo_mutasi 
				from mfi_gl_report_item a 
				left outer join mfi_gl_report_item_member b on a.gl_report_item_id=b.gl_report_item_id 
				left outer join mfi_report_financing_temporary c on b.account_code = c.account_code 
				where c.branch_code in (select branch_code from mfi_branch_member where branch_induk =? )
				and a.report_code=? and c.user_id=?
				group by 1,2,3,4,5,6,7,8  
				order by 1,2 "; 

			$param[] = $branch_code;
			$param[] = $report_code;
			$param[] = $user_id;
		}

		$query = $this->db->query($sql,$param);

		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_temp($item_codes[$j],$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

			/* saldo mutasi */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes2=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount2=array();
				for($j=0;$j<count($item_codes2);$j++){
					$arr_amount2[$item_codes2[$j]]=$this->get_amount_mutasi_from_item_code($item_codes2[$j],$from_date,$last_date,$branch_code,$report_code);
				}
				$formula2=$rows[$i]['formula'];
				foreach($arr_amount2 as $key2=>$value2):
				$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
				endforeach;
				if($formula2!=""){
					$sqlsal2="select ($formula2) as saldo";
					$quesal2=$this->db->query($sqlsal2);
					$rowsal2=$quesal2->row_array();
					$saldo_mutasi=$rowsal2['saldo'];
				}else{
					$saldo_mutasi=0;
				}
			}else{
				$saldo_mutasi=$rows[$i]['saldo_mutasi'];
			}
			$row[$i]['saldo_mutasi'] = $saldo_mutasi;

		}
		return $row;
	}

	function export_lr_temp_2($branch_code,$report_code,$breakdown,$user_id){
		$param = array();

		$sql = "SELECT
		report_code,
		item_code,
		item_type,
		posisi,
		display_saldo,
		formula,
		formula_text_bold,
		item_name,
		(CASE WHEN item_type = '0' THEN NULL::INTEGER ELSE CASE WHEN display_saldo = '1' THEN SUM(saldo_awal) * (-1) ELSE SUM(saldo_awal) END END) AS saldo,
		(CASE WHEN item_type = '0' THEN NULL::INTEGER ELSE CASE WHEN display_saldo = '1' THEN SUM(mutasi_debit - mutasi_credit) * (-1) ELSE SUM(mutasi_debit - mutasi_credit) END END) AS saldo_mutasi
		FROM mfi_keuangan_report
		WHERE report_code = ? AND created_by = ? ";

		$param[] = $report_code;
		$param[] = $user_id;

		if($branch_code != '00000'){
			$sql .= "AND report_branch IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY
		report_code,
		item_code,
		item_type,
		posisi,
		display_saldo,
		formula,
		formula_text_bold,
		item_name ";
		$sql .= "ORDER BY 1,2";

		$query = $this->db->query($sql,$param);

		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];
			$row[$i]['item_name'] = $rows[$i]['item_name'];

			if($breakdown == ''){
				$first_saldo = $rows[$i]['saldo'];
				$first_saldo_mutasi = $rows[$i]['saldo_mutasi'];
			} else {
				if($breakdown == 'Y'){
					$first_saldo = $rows[$i]['saldo'] / 2;
					$first_saldo_mutasi = $rows[$i]['saldo_mutasi'] / 2;
				} else {
					$first_saldo = $rows[$i]['saldo'];
					$first_saldo_mutasi = $rows[$i]['saldo_mutasi'];
				}
			}

			/* saldo */
			if($rows[$i]['item_type']=='2'){
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_temp_2($item_codes[$j],$branch_code,$report_code,$user_id);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo = $first_saldo;
			}

			$row[$i]['saldo'] = $saldo;	

			/* saldo mutasi */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes2=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount2=array();
				for($j=0;$j<count($item_codes2);$j++){
					$arr_amount2[$item_codes2[$j]]=$this->get_amount_mutasi_from_item_code_2($item_codes2[$j],$from_date,$last_date,$report_code,$user_id);
				}
				$formula2=$rows[$i]['formula'];
				foreach($arr_amount2 as $key2=>$value2):
				$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
				endforeach;
				if($formula2!=""){
					$sqlsal2="select ($formula2) as saldo";
					$quesal2=$this->db->query($sqlsal2);
					$rowsal2=$quesal2->row_array();
					$saldo_mutasi=$rowsal2['saldo'];
				}else{
					$saldo_mutasi=0;
				}
			}else{
				$saldo_mutasi = $first_saldo_mutasi;
			}

			$row[$i]['saldo_mutasi'] = $saldo_mutasi;

		}
		return $row;
	}

	// TRIAL BALANCE TEMP //
	// --------------------------------- //

	function export_trial_balance_temp($cabang, $fromlm, $start, $from, $report_code)
	{
		$param = array();

		if($cabang == "00000")
		{
			$sql = "SELECT a.account_code, a.account_name,
					sum(b.saldo) saldo_awal,

					(SELECT sum(d.amount)
					FROM mfi_trx_gl c, mfi_trx_gl_detail d
					WHERE c.trx_gl_id = d.trx_gl_id 
					AND d.flag_debit_credit='D'
					AND c.voucher_date
					between ? and ?
					AND d.account_code=a.account_code) total_mutasi_debet,

					(SELECT sum(f.amount)
					FROM mfi_trx_gl e, mfi_trx_gl_detail f  
					WHERE e.trx_gl_id = f.trx_gl_id 
					AND f.flag_debit_credit='C'
					AND e.voucher_date 
					BETWEEN ? and ? 
					AND f.account_code=a.account_code) total_mutasi_credit

					from mfi_gl_account a 
					left outer join mfi_closing_ledger_data b on a.account_code=b.account_code and b.closing_from_date=? 
					group by 1,2 
					order by 1,2 ";
			$param[] = $start;
			$param[] = $from;
			$param[] = $start;
			$param[] = $from;
			$param[] = $fromlm;
		} else {
			$sql = "SELECT a.account_code, a.account_name,
					sum(b.saldo) saldo_awal,

					(SELECT sum(d.amount)
					FROM mfi_trx_gl c, mfi_trx_gl_detail d
					WHERE c.trx_gl_id = d.trx_gl_id 
					AND d.flag_debit_credit = 'D'
					AND c.branch_code in
					(SELECT branch_code FROM mfi_branch_member
					WHERE branch_induk = ?)
					AND c.voucher_date BETWEEN ? AND ?
					AND d.account_code = a.account_code) total_mutasi_debet,

					(SELECT sum(f.amount)
					FROM mfi_trx_gl e, mfi_trx_gl_detail f
					WHERE e.trx_gl_id = f.trx_gl_id
					AND f.flag_debit_credit = 'C'
					AND e.branch_code in
					(SELECT branch_code FROM mfi_branch_member
					WHERE branch_induk = ?)
					AND e.voucher_date BETWEEN ? AND ?
					AND F.account_code = a.account_code) total_mutasi_credit

					FROM mfi_gl_account a
					LEFT OUTER JOIN mfi_closing_ledger_data b
					ON a.account_code = b.account_code
					AND b.closing_from_date = ?
					AND b.branch_code in
					(SELECT branch_code FROM mfi_branch_member
					WHERE branch_induk = ?)
					GROUP BY 1,2
					ORDER BY 1,2";
			$param[] = $cabang;
			$param[] = $start;
			$param[] = $from;
			$param[] = $cabang;
			$param[] = $start;
			$param[] = $from;
			$param[] = $fromlm;
			$param[] = $cabang;
		}
				
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	// FINISH //
	// ---------------------- //

	/****************************************************************************************/	
	// BEGIN LIST JATUH TEMPO
	/****************************************************************************************/
	function export_list_jatuh_tempo($cabang,$pembiayaan,$petugas,$majelis,$from,$thru){
		$sql = "SELECT
		maf.account_financing_no,
		mc.nama,
		mcm.cm_name,
		mcm.cm_code,
		(SELECT COUNT(cif_no) FROM mfi_account_financing AS fci WHERE fci.cif_no = mc.cif_no GROUP BY fci.cif_no) AS ke,
		mkd.desa,
		maf.pokok,
		maf.margin,
		maf.jangka_waktu,
		maf.periode_jangka_waktu,
		maf.tanggal_jtempo,
		maf.tanggal_akad,
		maf.branch_code,
		maf.saldo_pokok,
		maf.angsuran_pokok,
		maf.financing_type
		FROM mfi_account_financing AS maf
		JOIN mfi_cif AS mc ON maf.cif_no = mc.cif_no
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		JOIN mfi_cm AS mcm ON mcm.branch_id = mb.branch_id
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_kecamatan_desa AS mkd ON mcm.desa_code = mkd.desa_code
		WHERE maf.tanggal_jtempo BETWEEN ? AND ? ";

		$param = array();

		$param[] = $from;
		$param[] = $thru;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ?";
			$param[] = $majelis;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	/****************************************************************************************/	
	// END LIST JATUH TEMPO
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/
	function list_pelunasan_pembiayaan($cabang,$pembiayaan,$petugas,$majelis,$from,$thru,$kreditur){
		$sql = "SELECT
		mafl.tanggal_lunas,
		maf.account_financing_no,
		mc.nama,
		maf.pokok,
		maf.margin,
		maf.jangka_waktu,
		maf.periode_jangka_waktu,
		maf.tanggal_jtempo,
		maf.counter_angsuran,
		maf.financing_type,
		mcm.cm_name,
		mcm.cm_code,
		maf.branch_code,
		mafl.saldo_pokok,
		maf.angsuran_pokok,
		mafl.saldo_margin,
		mafl.potongan_margin,
		mafl.saldo_wajib,
		mafl.saldo_kelompok,
		mafl.saldo_catab,
		mafl.status_pelunasan,
		krt.display_text AS krd,
		maf.kreditur_code
		FROM mfi_account_financing_lunas AS mafl
		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mafl.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		WHERE mafl.tanggal_lunas BETWEEN ? AND ? ";

		$param = array();

		$param[] = $from;
		$param[] = $thru;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		}

		//$sql .= "GROUP BY";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	/****************************************************************************************/	
	// END LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN DROPING PEMBIAYAAN
	/****************************************************************************************/

	function export_lap_droping_pembiayaan($cabang,$majelis,$from,$thru,$pembiayaan,$petugas,$peruntukan,$sektor,$produk,$kreditur){
		$sql = "SELECT
		mc.nama,
		mafd.droping_date,
		mafd.droping_by,
		mafd.account_financing_no,
		mcm.cm_name,
		mpf.nick_name,
		maf.pokok,
		maf.margin,
		maf.jangka_waktu,
		maf.periode_jangka_waktu, 
		maf.financing_type,
		maf.tanggal_jtempo,
		mafr.pembiayaan_ke, 
		(SELECT g.pokok FROM mfi_account_financing AS g WHERE g.cif_no=mafd.cif_no
		 AND g.tanggal_akad < maf.tanggal_akad ORDER BY g.tanggal_akad DESC
		 LIMIT 1) AS pokok_sebelum,
		mafr.description,
		maf.pengguna_dana,
		mc.no_hp,
		mlcd.display_text AS dtp,
		mldc.display_text AS dts,
		maf.biaya_administrasi, 
		maf.cadangan_resiko, 
		maf.biaya_asuransi_jiwa,
		krt.display_text AS krd,
		maf.kreditur_code

		FROM mfi_account_financing_droping AS mafd

		JOIN mfi_account_financing AS maf
		ON mafd.account_financing_no = maf.account_financing_no		
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_product_financing AS mpf ON maf.product_code = mpf.product_code 
		JOIN mfi_account_financing_reg AS mafr
		ON maf.registration_no = mafr.registration_no AND maf.cif_no=mafr.cif_no
		LEFT JOIN mfi_list_code_detail AS mlcd
		ON CAST(mlcd.code_value AS INTEGER) = maf.peruntukan
		AND mlcd.code_group= 'peruntukan'
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		LEFT JOIN mfi_list_code_detail AS mldc
		ON CAST(mldc.code_value AS INTEGER) = maf.sektor_ekonomi
		AND mldc.code_group= 'sektor_ekonomi'
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code

		WHERE mafd.droping_date BETWEEN ? AND ?
		AND maf.status_rekening <> 0 ";

		$param[] = $from;
		$param[] = $thru;

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		} 
		
		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		} 

		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ? ";
			$param[] = $sektor;
		} 

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		} 

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		$sql .= "ORDER BY mcm.cm_name,mc.cif_no ASC";

		$query = $this->db->query($sql,$param);
		
		return $query->result_array();
	}

	/****************************************************************************************/	
	// END LAPORAN DROPING PEMBIAYAAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// LAPORAN CHANELLING DEBITUR
	/****************************************************************************************/ 
	function export_lap_chn_debitur($account_financing_no_array){
		$sql = "SELECT
		mc.branch_code, mcm.cm_code, mcm.cm_name, mc.nama, mc.no_ktp, mc.status_perkawinan, mc.pendidikan, mc.pekerjaan,  mc.tgl_lahir, mc.tgl_gabung, 
		mc.alamat, mc.no_hp,  mb.branch_name, mpc.city_code,  
		mck.rmhlantai, mck.sku_no,
		mafd.droping_date,
		mafd.account_financing_no, 		
		maf.pokok, maf.margin, maf.jangka_waktu, maf.periode_jangka_waktu, maf.financing_type, maf.kreditur_code, mafr.pembiayaan_ke,  
		mpf.nick_name,
		mlcd.display_text AS dtp,
		mldc.display_text AS dts,
		krt.display_text AS krd, 	
		mcck.kodepos, mkd.desa, mcck.kecamatan, 
		map.registration_no, 		
		max(map.modal_awal) as modal_awal,  
		max(map.omset_usaha) as omset_usaha,   
		max(map.pend_gaji) as pend_gaji, 
		max(map.pend_usaha) as pend_usaha, 
		max(map.pend_lainya) as pend_lainya  	

		FROM mfi_account_financing_droping AS mafd

		JOIN mfi_account_financing AS maf ON mafd.account_financing_no = maf.account_financing_no		
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no 
		LEFT JOIN mfi_cif_kelompok AS mck ON mc.cif_id = mck.cif_id   
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code 
		LEFT JOIN mfi_kecamatan_desa as mkd on mkd.desa_code=mcm.desa_code 
		LEFT JOIN mfi_city_kecamatan as mcck on mcck.kecamatan_code=mkd.kecamatan_code  
		LEFT JOIN mfi_province_city as mpc on mpc.city_code=mcck.city_code 		
		LEFT JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id 
		LEFT JOIN mfi_product_financing AS mpf ON maf.product_code = mpf.product_code 
		LEFT JOIN mfi_account_financing_reg AS mafr ON mafr.registration_no = maf.registration_no 
		LEFT JOIN mfi_account_financing_map AS map ON map.registration_no = mafr.registration_no 
		LEFT JOIN mfi_list_code_detail AS mlcd ON CAST(mlcd.code_value AS INTEGER) = maf.peruntukan AND mlcd.code_group= 'peruntukan'
		LEFT JOIN mfi_list_code_detail AS krt ON (maf.kreditur_code = krt.code_value) AND krt.code_group = 'kreditur'
		LEFT JOIN mfi_list_code_detail AS mldc ON CAST(mldc.code_value AS INTEGER) = maf.sektor_ekonomi AND mldc.code_group= 'sektor_umi'
		
		WHERE  maf.status_rekening = '1' ";

		$sql .=  "AND mafd.account_financing_no in ".$account_financing_no_array;   


		$sql .= " group by  1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33  
		        ORDER BY mc.branch_code, mcm.cm_code, mc.nama ASC";

		$query = $this->db->query($sql);
		
		return $query->result_array();
	}

	function insert_chn_report($data_batch)
	{
		$this->db->insert_batch('mfi_chn_report',$data_batch);		
	}

	function jqgrid_count_chn_debitur($debitur_upload_no)
	{
		$query = $this->db->query("SELECT count(*) AS num FROM mfi_chn_report WHERE debitur_upload_no = '$debitur_upload_no'");

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_chn_debitur($debitur_upload_no)
	{
		$query = $this->db->query("SELECT account_financing_no, cif_no, no_ktp, debitur_status FROM mfi_chn_report WHERE debitur_upload_no = '$debitur_upload_no'");

		return $query->result_array();
	}

	/****************************************************************************************/	
	// END cretae lap CHANELLING DEBITUR
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN CHANELLING AKAD
	/****************************************************************************************/ 
	function create_lap_chn_akad($debitur_upload_no){
		$sql = "SELECT
				 mcr.no_ktp nik, mcr.account_financing_no noakad, mcr.account_financing_no norekening, 	'1' statusakad, '1'	statusrekening,  maf.tanggal_akad tanggalakad, 	maf.tanggal_jtempo	tanggaljatuhtempo, maf.pokok  nilaiakad, '41' skema, '000' idkelompok,	'2' sukubunga, 	mldc.display_text  sektor, '0' kodepenjamin, '00000' nopenjaminan,	'0' nilaidijamin, maf.kreditur_code, mcm.cm_name, mc.nama  

		FROM mfi_chn_report as mcr 
		JOIN mfi_account_financing AS maf on mcr.account_financing_no = maf.account_financing_no 	
		LEFT JOIN mfi_cif AS mc ON mcr.cif_no = mc.cif_no  
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code 
		LEFT JOIN mfi_list_code_detail AS mldc ON CAST(mldc.code_value AS INTEGER) = maf.sektor_ekonomi AND mldc.code_group= 'sektor_umi' 
		
		WHERE  mcr.debitur_upload_no=? and mcr.debitur_status=1  ORDER BY mcm.cm_name,mcr.cif_no ASC "; 

		$param[] = $debitur_upload_no;

		$query = $this->db->query($sql,$param); 
		
		return $query->result_array();
	}

	function update_chn_akad_trm($debitur_upload_no)
	{
		$query = $this->db->query("UPDATE mfi_chn_report SET akad_status = '0' WHERE debitur_upload_no = '$debitur_upload_no' AND debitur_status = '1'");

		return $query;

	}

	function jqgrid_count_chn_akad($debitur_upload_no)
	{
		$query = $this->db->query("SELECT count(*) num FROM mfi_chn_report WHERE debitur_upload_no = '$debitur_upload_no' AND akad_status::varchar <> ''");

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_chn_akad($debitur_upload_no)
	{
		$query = $this->db->query("SELECT account_financing_no, cif_no, no_ktp, akad_status FROM mfi_chn_report WHERE debitur_upload_no = '$debitur_upload_no' AND akad_status::varchar <> ''");

		return $query->result_array();
	}

	/****************************************************************************************/	
	// END LAPORAN CHANELLING AKAD
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN CHANELLING DROPING
	/****************************************************************************************/ 

	function create_lap_chn_droping($debitur_upload_no)
	{
		$sql = "SELECT
				  maf.tanggal_akad tanggalakad, now() tanggalpelaporan, mcr.account_financing_no norekening, mcr.account_financing_no noakad, maf.pokok  nominal    

		FROM mfi_chn_report as mcr 
		JOIN mfi_account_financing AS maf on mcr.account_financing_no = maf.account_financing_no 			
		WHERE  mcr.debitur_upload_no=? and mcr.akad_status=1  ORDER BY 1,3 "; 

		$param[] = $debitur_upload_no;

		$query = $this->db->query($sql,$param); 
		
		return $query->result_array();
	}

	function update_chn_droping_trm($debitur_upload_no)
	{
		$query = $this->db->query("UPDATE mfi_chn_report SET droping_status = '0' WHERE debitur_upload_no = '$debitur_upload_no' AND debitur_status = '1' AND akad_status = '1'");

		return $query;

	}

	/****************************************************************************************/	
	// END LAPORAN CHANELLING DROPING
	/****************************************************************************************/ 



	/****************************************************************************************/	
	// LAPORAN LIST ANGGOTA
	/****************************************************************************************/

	public function export_excel_list_anggota()
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.desa,
				mfi_cif.created_timestamp,
				mfi_cif.jenis_kelamin,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.ibu_kandung,
				mfi_cif_kelompok.cif_kelompok_id,
				mfi_cif_kelompok.cif_id,
				mfi_cif_kelompok.setoran_lwk,
				mfi_cif_kelompok.setoran_mingguan,
				mfi_cif_kelompok.pendapatan,
				mfi_cif_kelompok.literasi_latin,
				mfi_cif_kelompok.literasi_arab,
				mfi_cif_kelompok.p_nama,
				mfi_cif_kelompok.p_tmplahir,
				mfi_cif_kelompok.p_usia,
				mfi_cif_kelompok.p_tglahir,
				mfi_cif_kelompok.p_pendidikan,
				mfi_cif_kelompok.p_pekerjaan,
				mfi_cif_kelompok.p_ketpekerjaan,
				mfi_cif_kelompok.p_pendapatan,
				mfi_cif_kelompok.p_periodependapatan,
				mfi_cif_kelompok.p_literasi_latin,
				mfi_cif_kelompok.p_literasi_arab,
				mfi_cif_kelompok.p_jmltanggungan,
				mfi_cif_kelompok.p_jmlkeluarga,
				mfi_cif_kelompok.rmhstatus,
				mfi_cif_kelompok.rmhukuran,
				mfi_cif_kelompok.rmhatap,
				mfi_cif_kelompok.rmhlantai,
				mfi_cif_kelompok.rmhdinding,
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
				mfi_cm.cm_name
				FROM
				mfi_cif
				INNER JOIN mfi_cif_kelompok ON mfi_cif_kelompok.cif_id = mfi_cif.cif_id
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				ORDER BY mfi_cif_kelompok.cif_kelompok_id ASC
				";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}

	public function export_list_anggota($branch_code,$cm_code)
	{
		$sql = "SELECT
				mfi_cif.cm_code,
				mfi_cm.branch_id,
				mfi_cm.cm_name
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_branch ON mfi_branch.branch_id = mfi_cm.branch_id
				WHERE mfi_cif.cif_id IS NOT NULL AND mfi_cif.status = '1'
				";

			if($branch_code!="0000")
			{
				$sql .= " AND mfi_branch.branch_code = ? ";
				$param[] = $branch_code;
			}
			if($cm_code!="0000")
			{
				$sql .= " AND mfi_cm.cm_code = ? ";
				$param[] = $cm_code;
			}

			$sql .= " GROUP BY mfi_cif.cm_code,mfi_cm.branch_id,mfi_cm.cm_name";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		return $query->result_array();
	}

	function export_list_anggota2($branch,$cm){
		$param = array();
		$query2 = "SELECT
		mfi_cif.panggilan,
		mfi_cif.cif_no,
		mfi_cif.nama,
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
		mfi_cif.no_npwp,
		mfi_cif.telpon_rumah,
		mfi_cif.telpon_seluler,
		mfi_cif.pendidikan,
		mfi_cif.status_perkawinan,
		mfi_cif.pekerjaan,
		mfi_cif.ket_pekerjaan,
		mfi_cif.pendapatan_perbulan,
		mfi_cif.tgl_gabung,
		mfi_cif_kelompok.cif_kelompok_id,
		mfi_cif_kelompok.cif_id,
		mfi_cif_kelompok.setoran_lwk,
		mfi_cif_kelompok.setoran_mingguan,
		mfi_cif_kelompok.pendapatan,
		mfi_cif_kelompok.literasi_latin,
		mfi_cif_kelompok.literasi_arab,
		mfi_cif_kelompok.p_nama,
		mfi_cif_kelompok.p_tmplahir,
		mfi_cif_kelompok.p_usia,
		mfi_cif_kelompok.p_tglahir,
		mfi_cif_kelompok.p_pendidikan,
		mfi_cif_kelompok.p_pekerjaan,
		mfi_cif_kelompok.p_ketpekerjaan,
		mfi_cif_kelompok.p_pendapatan,
		mfi_cif_kelompok.p_periodependapatan,
		mfi_cif_kelompok.p_literasi_latin,
		mfi_cif_kelompok.p_literasi_arab,
		mfi_cif_kelompok.p_jmltanggungan,
		mfi_cif_kelompok.p_jmlkeluarga,
		mfi_cif_kelompok.rmhstatus,
		mfi_cif_kelompok.rmhukuran,
		mfi_cif_kelompok.rmhatap,
		mfi_cif_kelompok.rmhlantai,
		mfi_cif_kelompok.rmhdinding,
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
		mfi_cm.cm_name,
		mfi_cif.cm_code
		FROM mfi_cif LEFT JOIN mfi_cif_kelompok ON mfi_cif_kelompok.cif_id = mfi_cif.cif_id LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
		WHERE mfi_cif.cif_type = 0 AND mfi_cif.status = '1' ";

		if($branch != '00000'){
			$query2 .= " AND mfi_cif.branch_code = ? ";
			$param[] = $branch;
		}

		if($cm != '0000'){
			$query2 .= " AND mfi_cm.cm_code = ? ";
			$param[] = $cm;
		}

		$data2 = $this->db->query($query2,$param);
		return $data2->result_array();
	}

	public function export_list_individu($tglawal,$tglakhir)
	{
		$query = "SELECT * FROM mfi_cif WHERE tgl_gabung BETWEEN ? AND ? AND cif_type = '1'";
		$data = $this->db->query($query,array($tglawal,$tglakhir));
		return $data->result_array();
	}

	/****************************************************************************************/	
	// END LAPORAN LIST ANGGOTA
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN OUTSTANDING
	/****************************************************************************************/

	function export_lap_list_outstanding_pembiayaan($cabang,$cif_type,$pembiayaan,$petugas,$majelis,$produk,$peruntukan,$sektor,$tanggal,$kreditur){
		$sql = "SELECT
		mc.nama,
		mc.no_ktp,
		mc.desa,
		mafd.droping_date,
		mafd.droping_by,
		maf.account_financing_no,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.saldo_pokok,
		maf.saldo_margin,
		maf.saldo_catab,
		maf.status_kolektibilitas,
		maf.margin,
		maf.pokok,
		maf.dana_kebajikan,
		maf.financing_type,
		maf.jangka_waktu, 
		maf.tanggal_jtempo,
		mlcd.display_text AS peruntukan,
		fice.display_text AS sektor,
		mcm.cm_name,
		mf.fa_name,
		mpf.nick_name,  

		CAST((maf.saldo_pokok / maf.angsuran_pokok) AS INTEGER) AS freq_bayar_saldo,

		maf.counter_angsuran AS freq_bayar_pokok, 
		
		(((? - maf.tanggal_mulai_angsur) / 7) + 1) AS seharusnya, 

		(SELECT COUNT(*) AS jumlah FROM mfi_hari_libur WHERE EXTRACT(DOW FROM tanggal) = EXTRACT(DOW FROM maf.tanggal_mulai_angsur) AND tanggal BETWEEN maf.tanggal_mulai_angsur AND ?) AS hari_libur,  

		krt.display_text AS krd,
		maf.kreditur_code,
		maf.fl_reschedulle
		FROM mfi_account_financing AS maf
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_account_financing_droping AS mafd
		ON maf.account_financing_no = mafd.account_financing_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_list_code_detail AS mlcd
		ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR)
		AND mlcd.code_group = 'peruntukan'
		JOIN mfi_list_code_detail AS fice
		ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR)
		AND fice.code_group = 'sektor_ekonomi'
		JOIN mfi_product_financing AS mpf
		ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		WHERE maf.status_rekening = '1' AND mc.cif_type='0'";

		$param = array(); 
		$param[] =$tanggal; 
		$param[] =$tanggal; 

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		}

		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ? ";
			$param[] = $sektor;
		} 

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		$sql .= "ORDER BY mb.branch_code,mcm.cm_name";  //,mc.kelompok::INTEGER ASC

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function export_lap_list_outstanding_pembiayaan_ind($cabang,$cif_type,$pembiayaan,$petugas,$majelis,$produk,$peruntukan,$sektor,$tanggal,$kreditur){
		$sql = "SELECT		
		mc.nama,
		mc.no_ktp,
		mc.desa,
		mc.cif_type,
		mafd.droping_date,
		mafd.droping_by,
		maf.account_financing_no,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.saldo_pokok,
		maf.saldo_margin,
		maf.saldo_catab,
		maf.status_kolektibilitas,
		maf.margin,
		maf.pokok,
		maf.dana_kebajikan,
		maf.tanggal_jtempo,
		mlcd.display_text AS peruntukan,fice.display_text AS sektor,
		mf.fa_name,
		mpf.nick_name,	
		CAST((maf.saldo_pokok / maf.angsuran_pokok) AS INTEGER) AS freq_bayar_saldo,
		maf.counter_angsuran AS freq_bayar_pokok,
		maf.jangka_waktu,
		krt.display_text AS krd,
		maf.kreditur_code,
		maf.fl_reschedulle
		FROM mfi_account_financing AS maf
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
		JOIN mfi_branch AS mb ON mb.branch_code=mc.branch_code 	
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = maf.fa_code
		JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR)	AND mlcd.code_group = 'peruntukan'
		JOIN mfi_list_code_detail AS fice ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR)	AND fice.code_group = 'sektor_ekonomi'
		JOIN mfi_product_financing AS mpf	ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		WHERE maf.status_rekening = '1'  AND  mc.cif_type='1' ";

		$param = array();

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mc.cm_code = ? ";
			$param[] = $majelis;
		}

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		}

		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ? ";
			$param[] = $sektor;
		} 

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		$sql .= "ORDER BY mb.branch_code";  //,mc.kelompok::INTEGER ASC ,mc.cm_name

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function export_lap_list_outstanding_pembiayaan_lalu($cabang,$pembiayaan,$petugas,$majelis,$produk,$peruntukan,$sektor,$tanggal,$kreditur){
		$sql = "SELECT
				mc.nama,
				mc.no_ktp,
				mc.desa,
				mafd.droping_date,
				mafd.droping_by,
				maf.account_financing_no,
				maf.angsuran_pokok,
				maf.angsuran_margin,
				mcfd.saldo_pokok,
				mcfd.saldo_margin,
				mcfd.saldo_catab,
				maf.status_kolektibilitas,
				maf.margin,
				maf.pokok,
				maf.dana_kebajikan,
				maf.financing_type,
				maf.jangka_waktu,
				mlcd.display_text AS peruntukan,
				fice.display_text AS sektor,
				mcm.cm_name,
				mf.fa_name,
				mpf.nick_name, 

				CAST((mcfd.saldo_pokok / maf.angsuran_pokok) AS INTEGER) AS freq_bayar_saldo, 
				(maf.jangka_waktu - (mcfd.saldo_pokok / maf.angsuran_pokok)::INTEGER) AS freq_bayar_pokok,
		
				(((? - maf.tanggal_mulai_angsur) / 7) + 1) AS seharusnya, 
				(SELECT COUNT(*) AS jumlah FROM mfi_hari_libur WHERE EXTRACT(DOW FROM tanggal) = EXTRACT(DOW FROM maf.tanggal_mulai_angsur) AND tanggal BETWEEN maf.tanggal_mulai_angsur AND ?) AS hari_libur, 
				
				maf.fl_reschedulle,
				krt.display_text AS krd,
				maf.kreditur_code,
				maf.tanggal_jtempo
				FROM mfi_closing_financing_data AS mcfd
				JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
				JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
				JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
				JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
				JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
				LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
				LEFT JOIN mfi_list_code_detail AS krt ON (maf.kreditur_code = krt.code_value) AND krt.code_group = 'kreditur'
				JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR) AND mlcd.code_group = 'peruntukan'
				JOIN mfi_list_code_detail AS fice ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR) AND fice.code_group = 'sektor_ekonomi'
				JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		 		";

		$param = array(); 
		$param[] =$tanggal; 
		$param[] =$tanggal; 

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		}

		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ? ";
			$param[] = $sektor;
		}

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		$sql .= "AND mcfd.closing_thru_date = ? ";
		$param[] = $tanggal;

		$sql .= "ORDER BY mb.branch_code,mcm.cm_name,mc.kelompok::INTEGER ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	} 

	function export_lap_list_outstanding_tabungan_lalu($cabang,$tabungan,$petugas,$majelis,$produk,$tanggal){
		$param = array();
		$sql = "SELECT
		mcsd.account_saving_no,
		mc.nama,
		mc.no_ktp,
		mcm.cm_name,
		mps.nick_name,
		mcsd.saldo_memo
		FROM mfi_closing_saving_data AS mcsd
		JOIN mfi_account_saving AS mas ON mas.account_saving_no = mcsd.account_saving_no
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mcsd.closing_thru_date = ? and mas.product_code<>'0006' ";

		$param[] = $tanggal;

		if($tabungan != '9'){
			$sql .= "AND mps.jenis_tabungan = ? ";
			$param[] = $tabungan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($produk != '00000'){
			$sql .= "AND mps.product_code = ? ";
			$param[] = $produk;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	} 

	/****************************************************************************************/	
	// END LAPORAN OUTSTANDING
	/****************************************************************************************/


	function export_list_saldo_tbg($cabang,$tabungan,$produk){
		$param = array();
		$sql = "SELECT mas.branch_code, 
		mas.account_saving_no,
		mc.nama,
		mc.no_ktp,
		mcm.cm_name,
		mps.nick_name,
		mas.saldo_memo
		FROM mfi_account_saving AS mas
		LEFT JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		LEFT JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		WHERE mas.product_code<>'0006' and mas.status_rekening='1' ";

		if($cabang != '00000'){
			$sql .= "AND mc.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}
		

		if($tabungan != '9'){
			$sql .= "AND mps.jenis_tabungan = ? ";
			$param[] = $tabungan;
		}

		
		if($produk != '00000'){
			$sql .= "AND mps.product_code = ? ";
			$param[] = $produk;
		}

		$sql .= " ORDER BY 1,5,3 ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	} 

	/****************************************************************************************/	
	// END LAPORAN SALDO TBG
	/****************************************************************************************/



	/****************************************************************************************/	
	// LAPORAN PREMI ANGGOTA
	/****************************************************************************************/

	function export_lap_list_premi_anggota($cabang,$rembug,$product_code,$financing_type){
		$sql = "SELECT
		maf.account_financing_no,
		mc.nama,
		mcm.cm_name,
		mc.tgl_lahir,
		(select age(mc.tgl_lahir)) AS usia,
		maf.peserta_asuransi AS p_nama,
		maf.tanggal_peserta_asuransi,
		(select age(maf.tanggal_peserta_asuransi)) AS p_usia,
		maf.pokok,
		maf.margin,
		mafd.droping_date,
		maf.tanggal_akad,
		maf.jangka_waktu,
		maf.tanggal_jtempo,
		maf.biaya_asuransi_jiwa,
		mafd.droping_by,
		maf.saldo_pokok,
		maf.saldo_margin,
		mf.fa_name
		FROM mfi_account_financing AS maf
		LEFT JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		LEFT JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE maf.status_rekening = 1 AND maf.financing_type = ? ";

		$param = array();

		$param[] = $financing_type;

		if($cabang != '00000'){
			$sql .= "AND mc.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($rembug != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $rembug;
		}

		if($product_code != '00000'){
			$sql .= "AND maf.product_code = ?";
			$param[] = $product_code;
		}

		$sql .= " ORDER BY mc.branch_code,mcm.cm_name,mc.kelompok::INTEGER ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	} 

	/****************************************************************************************/	
	// END LAPORAN PREMI ANGGOTA 
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST REGISTRASI PEMBIAYAAN
	/****************************************************************************************/
	function export_list_registrasi_pembiayaan($from,$thru,$cabang,$majelis,$pembiayaan,$petugas,$produk){
		$sql = "SELECT
		maf.account_financing_no,
		mc.nama,
		maf.tanggal_registrasi,
		maf.pokok,
		maf.margin,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.angsuran_catab,
		maf.jangka_waktu,
		maf.status_rekening,
		mcm.cm_name,
		mcm.cm_code,
		maf.periode_jangka_waktu,
		maf.financing_type,
		mpf.nick_name,
		maf.tanggal_pengajuan,
		maf.biaya_administrasi,
		maf.biaya_asuransi_jiwa

		FROM mfi_account_financing AS maf

		JOIN mfi_account_financing_reg AS mafr ON mafr.registration_no = maf.registration_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE maf.status_rekening = '1' ";

		$param = array();

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		}

		$sql .= "AND maf.tanggal_registrasi BETWEEN ? AND ? ";

		$param[] = $from;
		$param[] = $thru;

		$sql .= "ORDER BY
		maf.tanggal_registrasi,
		mcm.cm_code,
		mc.nama";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	/****************************************************************************************/	
	// END LIST REGISTRASI PEMBIAYAAN
	/****************************************************************************************/



	// PAR
	public function get_laporan_par($date,$branch_code)
	{
		$flag_all_branch=$this->session->userdata('flag_all_branch');
		$sql = "
			SELECT 
				a.cif_no,
				b.branch_code,
				a.account_financing_no,
				b.nama,
				a.pokok,
				a.margin,
				c.droping_date,
				a.angsuran_pokok,
				a.angsuran_margin,
				a.saldo_pokok,
				a.saldo_margin,
				(case when (? - a.jtempo_angsuran_next) < 0 then '0' else (? - a.jtempo_angsuran_next) end) as hari_nunggak,
				(case when fn_get_freq_tunggakan(a.account_financing_no,cast(? as text)) < 0 then '0' else fn_get_freq_tunggakan(a.account_financing_no,cast(? as text)) end) as freq_tunggakan,
				(case when (fn_get_freq_tunggakan(a.account_financing_no,cast(? as text)) * a.angsuran_pokok) < 0 then '0' else (fn_get_freq_tunggakan(a.account_financing_no,cast(? as text)) * a.angsuran_pokok) end) as tunggakan_pokok,
				(case when (fn_get_freq_tunggakan(a.account_financing_no,cast(? as text)) * a.angsuran_margin) < 0 then '0' else (fn_get_freq_tunggakan(a.account_financing_no,cast(? as text)) * a.angsuran_margin) end) as tunggakan_margin,
				(case when fn_get_par(? - a.jtempo_angsuran_next) is null then '0' else fn_get_par(? - a.jtempo_angsuran_next) end) as par_desc,
				(case when fn_get_cpp_par(? - a.jtempo_angsuran_next) is null then '0' else fn_get_cpp_par(? - a.jtempo_angsuran_next) end) par,
				(case when (fn_get_cpp_par(? - a.jtempo_angsuran_next)/100 * a.saldo_pokok) is null then '0' else (fn_get_cpp_par(? - a.jtempo_angsuran_next)/100 * a.saldo_pokok) end) as cadangan_piutang

			from mfi_account_financing a

			left join mfi_cif b on b.cif_no=a.cif_no
			left join mfi_account_financing_droping c on c.account_financing_no=a.account_financing_no

			where a.status_rekening=1 and a.saldo_pokok<>0
		";
		if($flag_all_branch=="0" || $branch_code!="00000"){
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
		}
		$sql .= "
			order by par_desc asc
		";
		$query = $this->db->query($sql,array($date,$date,$date,$date,$date,$date,$date,$date,$date,$date,$date,$date,$date,$date,$branch_code));
		
		return $query->result_array();
	}



	/****************************************************************************************/	
	// BEGIN REKAP JATUH TEMPO PEMBIAYAAN
	/****************************************************************************************/
		//cabang
		public function export_rekap_jatuh_tempo_semua_cabang($tanggal,$tanggal2)
		{
			$sql = "SELECT
							mfi_branch.branch_code,
							mfi_branch.branch_name,
							Count(mfi_cif.cif_no) AS jumlah_anggota,
							Sum(mfi_account_financing.angsuran_pokok) AS pokok
					FROM
							mfi_cif
							JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
							JOIN mfi_branch ON mfi_branch.branch_code = mfi_cif.branch_code
					WHERE
							mfi_account_financing.jtempo_angsuran_next BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//by cabang
		public function export_rekap_jatuh_tempo_cabang($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
							mfi_cm.cm_code
							,mfi_cm.cm_name
							,count(mfi_cif.cif_no) as jumlah_anggota
							,sum(mfi_account_financing.angsuran_pokok) as pokok 
					from 
							mfi_cm
					join mfi_cif on mfi_cif.cm_code = mfi_cm.cm_code
					join mfi_account_financing on mfi_account_financing.cif_no = mfi_cif.cif_no

					where 	mfi_account_financing.jtempo_angsuran_next between ? and ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="0000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="0000")
					{
					$sql .= " AND mfi_account_financing.branch_code = ? ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//rembug
		public function export_rekap_jatuh_tempo_rembug($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
							mfi_cm.cm_code
							,mfi_cm.cm_name
							,count(mfi_cif.cif_no) as jumlah_anggota
							,sum(mfi_account_financing.angsuran_pokok) as pokok 
					from 
							mfi_cm
					join mfi_cif on mfi_cif.cm_code = mfi_cm.cm_code
					join mfi_account_financing on mfi_account_financing.cif_no = mfi_cif.cif_no

					where 	mfi_account_financing.jtempo_angsuran_next between ? and ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="0000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="0000")
					{
					$sql .= " AND mfi_account_financing.branch_code = ? ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//petugas
		public function export_rekap_jatuh_tempo_petugas($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT
								mfi_fa.fa_code,
								mfi_fa.fa_name,
								Count(mfi_cif.cif_no) AS jumlah_anggota,
								Sum(mfi_account_financing.angsuran_pokok) AS pokok
					FROM
								mfi_cif
								JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
								JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
								JOIN mfi_fa ON mfi_cm.fa_code = mfi_fa.fa_code
					WHERE
								mfi_account_financing.jtempo_angsuran_next BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="0000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="0000")
					{
					$sql .= " AND mfi_account_financing.branch_code = ? ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		
		//produk
		public function export_rekap_jatuh_tempo_produk($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT
								mfi_product_financing.product_code,
								mfi_product_financing.product_name,
								Count(mfi_account_financing.product_code) AS jumlah_anggota,
								Sum(mfi_account_financing.angsuran_pokok) AS pokok
					FROM
								mfi_account_financing
								JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
								
					WHERE
								mfi_account_financing.jtempo_angsuran_next BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="0000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="0000")
					{
					$sql .= " AND mfi_account_financing.branch_code = ? ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		
		//peruntukan
		public function export_rekap_jatuh_tempo_peruntukan($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT
								mfi_list_code_detail.display_text,
								mfi_list_code_detail.code_value,
								Count(mfi_cif.cif_no) AS jumlah_anggota,
								Sum(mfi_account_financing.angsuran_pokok) AS pokok
					FROM
								mfi_cif
								JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
								JOIN mfi_list_code_detail ON CAST(mfi_account_financing.peruntukan AS character varying) = mfi_list_code_detail.code_value
					WHERE
								mfi_list_code_detail.code_group='peruntukan'
								AND mfi_account_financing.jtempo_angsuran_next BETWEEN ? AND ? ";


					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code=="0000" || $branch_code=="")
					{
					$sql .= " ";
					}
					elseif($branch_code!="0000")
					{
					$sql .= " AND mfi_account_financing.branch_code = ? ";
					$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
	/****************************************************************************************/	
	// END REKAP JATUH TEMPO
	/****************************************************************************************/

	// BEGIN REKAP PENGAJUAN PEMBIAYAAN
	function export_rekap_pengajuan_pembiayaan($cabang,$pembiayaan,$kategori,$from,$thru){
		$sql = "SELECT ";

		if($kategori == '1'){
			$sql .= "mcm.cm_name AS keterangan, ";
		} else if($kategori == '2'){
			$sql .= "mf.fa_name AS keterangan, ";
		} else if($kategori == '3'){
			$sql .= "mlcd.display_text AS keterangan, ";
		} else if($kategori == '4'){
			$sql .= "mb.branch_name AS keterangan, ";
		}

		$sql .= "COUNT(mc.cif_no) AS jumlah_anggota,
		SUM(mafr.amount) AS nominal,
		mafr.financing_type, mb.branch_code
		FROM mfi_account_financing_reg AS mafr
		JOIN mfi_cif AS mc ON mc.cif_no = mafr.cif_no ";

		if($kategori == '1'){
			$sql .= "JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code ";
			$sql .= "JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id ";
		} else if($kategori == '2'){
			$sql .= "JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code ";
			$sql .= "JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code ";
			$sql .= "JOIN mfi_branch AS mb ON mb.branch_code = mf.branch_code ";
		} else if($kategori == '3'){
			$sql .= "JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = mafr.peruntukan::VARCHAR AND mlcd.code_group = 'peruntukan' ";
			$sql .= "JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code ";
		} else if($kategori == '4'){
			$sql .= "JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code ";
		}

		$sql .= "WHERE mc.cif_no <> '' ";

		$param = array();

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($pembiayaan != '9'){
			$sql .= "AND mafr.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		$sql .= "AND mafr.tanggal_pengajuan BETWEEN ? AND ? ";
		$param[] = $from;
		$param[] = $thru;

		if($kategori == '4')
		{
			$sql .= "GROUP BY 1,4,5 ORDER BY mb.branch_code";

		}else
		{
			$sql .= "GROUP BY 1,4,5 ORDER BY 1";

		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	/****************************************************************************************/	
	// BEGIN REKAP PENCAIRAN PEMBIAYAAN
	/****************************************************************************************/
		//cabang
		public function export_rekap_pencairan_pembiayaan_semua_cabang($tanggal,$tanggal2)
		{
			$sql = "SELECT
					mb.branch_code,
					mb.branch_name,
					COUNT(mc.cif_no) AS num,
					SUM(maf.pokok) AS amount
					FROM mfi_cif AS mc
					JOIN mfi_account_financing AS maf
					ON (maf.cif_no = mc.cif_no)
					JOIN mfi_account_financing_droping AS mafd
					ON (mafd.cif_no = maf.cif_no)
					JOIN mfi_branch AS mb ON (mb.branch_code = mc.branch_code)
					WHERE mafd.droping_date
					BETWEEN ? AND ? ";

					$param[] = $tanggal;	
					$param[] = $tanggal2;

					$sql.=" GROUP BY 1,2 ORDER BY 2";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}

		//by cabang
		public function export_rekap_pencairan_pembiayaan_cabang($branch_code,$tanggal,$tanggal2)
		{
			$param = array();
			$sql = "SELECT
					a.branch_code
					,a.branch_name
					,(select count(*) from mfi_account_financing_droping b, mfi_account_financing c, mfi_cif d 
						where b.account_financing_no=c.account_financing_no and b.cif_no=d.cif_no 
						and b.droping_date between ? and ?
						and d.branch_code = a.branch_code
					) as num
					,(select sum(c.pokok) from mfi_account_financing_droping b, mfi_account_financing c, mfi_cif d
						where b.account_financing_no=c.account_financing_no and b.cif_no=d.cif_no
						and b.droping_date between ? and ?
						and d.branch_code = a.branch_code
					) as amount
					FROM mfi_branch a
					WHERE (select count(*) from mfi_account_financing_droping b, mfi_account_financing c, mfi_cif d 
						where b.account_financing_no=c.account_financing_no and b.cif_no=d.cif_no 
						and b.droping_date between ? and ?
						and d.branch_code = a.branch_code
					) > 0";
			
			$param[] = $tanggal;
			$param[] = $tanggal2;
			$param[] = $tanggal;
			$param[] = $tanggal2;
			$param[] = $tanggal;
			$param[] = $tanggal2;
			if ($branch_code!="00000") {
				$sql .= " AND a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
	
			$sql .= " ORDER BY a.branch_code asc";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}
		//rembug
		public function export_rekap_pencairan_pembiayaan_rembug($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
					a.cm_code
					,a.cm_name
					,count(e.account_financing_no) num
					,sum(e.pokok) amount 
					FROM mfi_cm a
					INNER JOIN mfi_branch b ON a.branch_id=b.branch_id
					INNER JOIN mfi_cif c ON c.cm_code=a.cm_code 
					INNER JOIN mfi_account_financing_droping d ON d.cif_no=c.cif_no
					INNER JOIN mfi_account_financing e ON e.account_financing_no=d.account_financing_no 
					where d.droping_date between ? and ? ";

					$param[] = $tanggal;	
					$param[] = $tanggal2;
					if ($branch_code!="00000") {
						$sql .= " AND b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
						$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		//petugas
		public function export_rekap_pencairan_pembiayaan_petugas($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT
					a.fa_code,
					a.fa_name,
					(select count(*) from mfi_account_financing_droping b, mfi_account_financing c, mfi_cif d, mfi_cm e
						where b.account_financing_no=c.account_financing_no and c.cif_no=d.cif_no and d.cm_code=e.cm_code
						and e.fa_code=a.fa_code and b.droping_date between ? and ?
					) as num,
					(select sum(c.pokok) from mfi_account_financing_droping b, mfi_account_financing c, mfi_cif d, mfi_cm e
						where b.account_financing_no=c.account_financing_no and c.cif_no=d.cif_no and d.cm_code=e.cm_code
						and e.fa_code=a.fa_code and b.droping_date between ? and ?
						) amount
					FROM mfi_fa a
					WHERE (select count(*) from mfi_account_financing_droping b, mfi_account_financing c, mfi_cif d, mfi_cm e
						where b.account_financing_no=c.account_financing_no and c.cif_no=d.cif_no and d.cm_code=e.cm_code
						and e.fa_code=a.fa_code and b.droping_date between ? and ?
					) > 0
					";
			$param[] = $tanggal;	
			$param[] = $tanggal2;
			$param[] = $tanggal;	
			$param[] = $tanggal2;
			$param[] = $tanggal;	
			$param[] = $tanggal2;
			if ($branch_code!="00000") {
				$sql .= " AND a.branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
			}
			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}
		
		//Produk
		public function export_rekap_pencairan_pembiayaan_produk($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT 
					a.product_code
					,a.product_name
					,count(b.account_financing_no) num
					,sum(b.pokok) amount 
					FROM mfi_product_financing a
					INNER JOIN mfi_account_financing b ON a.product_code=b.product_code
					INNER JOIN mfi_cif c ON c.cif_no=b.cif_no
					INNER JOIN mfi_account_financing_droping d ON d.account_financing_no=b.account_financing_no
					INNER JOIN mfi_cm e ON c.cm_code=e.cm_code 
					INNER JOIN mfi_branch f ON f.branch_id=e.branch_id
					where d.droping_date between ? and ? ";

					$param[] = $tanggal;	
					$param[] = $tanggal2;

					if($branch_code!="00000") {
						$sql .= " AND f.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
						$param[] = $branch_code;
					}

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}
		
		
	//peruntukan
	public function export_rekap_pencairan_pembiayaan_peruntukan($branch_code,$tanggal,$tanggal2)
	{
		$param = array();
		$sql = "SELECT 
				a.code_value
				,a.display_text
				,count(b.account_financing_no) num
				,sum(b.pokok) amount 
				FROM mfi_list_code_detail a
				INNER JOIN mfi_account_financing b ON b.peruntukan=a.code_value::integer
				INNER JOIN mfi_account_financing_droping c ON c.account_financing_no=b.account_financing_no
				INNER JOIN mfi_cif d ON d.cif_no=b.cif_no
				INNER JOIN mfi_cm e ON e.cm_code=d.cm_code
				INNER JOIN mfi_branch f ON e.branch_id=f.branch_id
				WHERE a.code_group='peruntukan'
				AND c.droping_date between ? and ? ";

				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code!="00000") {
					$sql .= " AND f.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1,2 ";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
		
	//nominal
	public function export_rekap_pencairan_pembiayaan_nominal($branch_code,$tanggal,$tanggal2)
	{
		$param = array();
		$sql = "SELECT  
				a.nominal_code, a.nominal_text, 
				( select count(b.*) from mfi_account_financing b, mfi_account_financing_droping c, mfi_cif d 
				where b.pokok between a.nominal_minimal and a.nominal_maksimal 
				and b.cif_no=d.cif_no
				and c.account_financing_no=b.account_financing_no 
				and c.droping_date between ? and ?";
				$param[] = $tanggal;
				$param[] = $tanggal2;
				if ($branch_code!="00000") {
					$sql .= " and d.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
				}
				$sql .= ") as num, 
				( select sum(b.pokok) from mfi_account_financing b, mfi_account_financing_droping c, mfi_cif d 
				where b.pokok between a.nominal_minimal and a.nominal_maksimal 
				and b.cif_no=d.cif_no
				and c.account_financing_no=b.account_financing_no 
				and c.droping_date between ? and ?";
				$param[] = $tanggal;
				$param[] = $tanggal2;
				if ($branch_code!="00000") {
					$sql .= " and d.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
				}
				$sql .= ") as amount 
				from 
				mfi_nominal a 
				order by 1,2 ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}	


	// sektor
	public function export_rekap_pencairan_pembiayaan_sektor($branch_code,$tanggal,$tanggal2)
	{
		$param = array();
		$sql = "SELECT 
				a.code_value,
				a.display_text,
				COUNT(b.account_financing_no) AS num,
				SUM(b.pokok) AS amount 
				FROM mfi_list_code_detail a
				LEFT JOIN mfi_account_financing b 
				ON CAST(b.sektor_ekonomi AS VARCHAR) = a.code_value 
				LEFT JOIN mfi_account_financing_droping c on b.account_financing_no=c.account_financing_no 
				LEFT JOIN mfi_cif AS d ON d.cif_no = b.cif_no
				LEFT JOIN mfi_cm AS e ON e.cm_code = d.cm_code
				LEFT JOIN mfi_branch AS f ON e.branch_id = f.branch_id
				WHERE a.code_group='sektor_ekonomi'
				AND c.droping_date BETWEEN ? AND ? ";

				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code!="00000") {
					$sql .= " AND f.branch_code IN (SELECT branch_code
					FROM mfi_branch_member WHERE branch_induk = ?)";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1,2 ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}	

	// kreditur
	public function export_rekap_pencairan_pembiayaan_kreditur($branch_code,$tanggal,$tanggal2)
	{
		$param = array();
		$sql = "SELECT 
				a.code_value,
				a.display_text,
				COUNT(b.account_financing_no) AS num,
				SUM(b.pokok) AS amount 
				FROM mfi_list_code_detail a
				LEFT JOIN mfi_account_financing b ON CAST(b.kreditur_code AS VARCHAR) = a.code_value 
				LEFT JOIN mfi_account_financing_droping c on b.account_financing_no=c.account_financing_no 
				LEFT JOIN mfi_cif AS d ON d.cif_no = b.cif_no
				LEFT JOIN mfi_cm AS e ON e.cm_code = d.cm_code
				LEFT JOIN mfi_branch AS f ON e.branch_id = f.branch_id
				WHERE a.code_group='kreditur'
				AND c.droping_date BETWEEN ? AND ? ";

				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code!="00000") {
					$sql .= " AND f.branch_code IN (SELECT branch_code
					FROM mfi_branch_member WHERE branch_induk = ?)";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1,2 ORDER BY a.code_value";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}	
	/****************************************************************************************/	
	// END REKAP PENCAIRAN PEMBIAYAAN
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// START REKAP PELUNASAN
	// Author : Aiman
	// Date   : 24 - 04 - 2018
	/****************************************************************************************/

	//kreditur
	public function export_rekap_pelunasan_pembiayaan_kreditur($branch_code,$tanggal,$tanggal2)
	{
		$param = array();
		$sql = "SELECT c.code_value, 
				c.display_text,
				count(a.account_financing_no) AS num,
				sum(a.saldo_pokok) AS amount
				FROM mfi_account_financing_lunas AS a
				JOIN mfi_account_financing AS b ON a.account_financing_no = b.account_financing_no
				JOIN mfi_list_code_detail AS c ON b.kreditur_code = c.code_value AND  c.code_group = 'kreditur'
				JOIN mfi_cif AS d ON b.cif_no = d.cif_no
				WHERE a.tanggal_lunas BETWEEN ? AND ?";

				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code!="00000") {
					$sql .= " AND d.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1,2 ORDER BY c.code_value";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}	

	//Sektor
	public function export_rekap_pelunasan_pembiayaan_sektor($branch_code,$tanggal,$tanggal2)
	{
		$param = array();
		$sql = "SELECT a.code_value, 
				a.display_text,
				count(c.account_financing_no) AS num,
				sum(c.saldo_pokok) AS amount
				FROM mfi_list_code_detail AS a
				JOIN mfi_account_financing AS b ON CAST(b.sektor_ekonomi AS VARCHAR) = a.code_value
				JOIN mfi_account_financing_lunas AS c ON b.account_financing_no = c.account_financing_no 
				JOIN mfi_cif AS d ON b.cif_no = d.cif_no
				JOIN mfi_cm AS e ON d.cm_code = e.cm_code 
				JOIN mfi_branch AS f ON e.branch_id = f.branch_id
				WHERE a.code_group='sektor_ekonomi'
				AND c.tanggal_lunas BETWEEN ? AND ?";

				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code!="00000") {
					$sql .= " AND f.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1,2 ORDER BY a.code_value";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	//Nominal
	public function export_rekap_pelunasan_pembiayaan_nominal($branch_code,$tanggal,$tanggal2)
	{
		$param = array();
		$sql = "SELECT 
				a.nominal_code, a.nominal_text,
				(SELECT count(b.*) FROM mfi_account_financing AS b,
				mfi_account_financing_lunas AS c,
				mfi_cif AS d
				WHERE b.pokok BETWEEN a.nominal_minimal AND a.nominal_maksimal 
				AND b.account_financing_no = c.account_financing_no
				AND b.cif_no = d.cif_no
				AND c.tanggal_lunas BETWEEN ? AND ?";
				$param[] = $tanggal;
				$param[] = $tanggal2;
				if ($branch_code!="00000") {
					$sql .= " AND d.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?)";
					$param[] = $branch_code;
				}
				$sql .= ") AS num,
				(SELECT sum(c.saldo_pokok) FROM mfi_account_financing AS b,
				mfi_account_financing_lunas AS c,
				mfi_cif AS d
				WHERE b.pokok BETWEEN a.nominal_minimal AND a.nominal_maksimal 
				AND b.account_financing_no = c.account_financing_no
				AND b.cif_no = d.cif_no
				AND c.tanggal_lunas BETWEEN ? AND ?";
				$param[] = $tanggal;
				$param[] = $tanggal2;
				if ($branch_code!="00000") {
					$sql .= " AND d.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?)";
					$param[] = $branch_code;
				}
				$sql .= ") AS amount
					FROM mfi_nominal AS a
					ORDER BY 1,2 ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}	

	//Peruntukan
	public function export_rekap_pelunasan_pembiayaan_peruntukan($branch_code,$tanggal,$tanggal2)
	{
		$param = array();
		$sql = "SELECT a.code_value,
				a.display_text,
				count(c.account_financing_no) AS num,
				sum(c.saldo_pokok) AS amount
				FROM mfi_list_code_detail AS a
				JOIN mfi_account_financing AS b ON b.peruntukan = a.code_value::integer
				JOIN mfi_account_financing_lunas AS c ON b.account_financing_no = c.account_financing_no
				JOIN mfi_cif AS d ON b.cif_no = d.cif_no
				JOIN mfi_cm AS e ON d.cm_code = e.cm_code
				JOIN mfi_branch AS f ON e.branch_id = f.branch_id
				WHERE a.code_group = 'peruntukan'
				AND c.tanggal_lunas BETWEEN ? AND ?";

				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code!="00000") {
					$sql .= " AND f.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1,2 ORDER BY a.code_value";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	//Produk
	public function export_rekap_pelunasan_pembiayaan_produk($branch_code,$tanggal,$tanggal2)
	{
		$param = array();
		$sql = "SELECT a.product_code,
				a.product_name,
				count(c.account_financing_no) AS num,
				sum(c.saldo_pokok) AS amount
				FROM mfi_product_financing AS a
				JOIN mfi_account_financing AS b ON a.product_code=b.product_code
				JOIN mfi_account_financing_lunas AS c ON b.account_financing_no = c.account_financing_no
				JOIN mfi_cif AS d ON b.cif_no = d.cif_no
				JOIN mfi_cm AS e ON d.cm_code = e.cm_code
				JOIN mfi_branch AS f ON e.branch_id = f.branch_id
				WHERE c.tanggal_lunas BETWEEN  ? AND ?";

				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code!="00000") {
					$sql .= " AND f.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1,2";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	//Petugas
	public function export_rekap_pelunasan_pembiayaan_petugas($branch_code,$tanggal,$tanggal2)
		{
			$sql = "SELECT
					a.fa_code,
					a.fa_name,
					(SELECT count(*) FROM mfi_account_financing_lunas b, mfi_account_financing c, mfi_cif d, mfi_cm e
						WHERE b.account_financing_no = c.account_financing_no 
						AND c.cif_no = d.cif_no 
						AND d.cm_code = e.cm_code
						AND e.fa_code = a.fa_code 
						AND b.tanggal_lunas BETWEEN ? AND ?
					) AS num,
					(SELECT sum(b.saldo_pokok) FROM mfi_account_financing_lunas b, mfi_account_financing c, mfi_cif d, mfi_cm e
						WHERE b.account_financing_no = c.account_financing_no 
						AND c.cif_no = d.cif_no 
						AND d.cm_code = e.cm_code
						AND e.fa_code = a.fa_code 
						AND b.tanggal_lunas BETWEEN ? AND ?
					) AS amount
					FROM mfi_fa AS a
					WHERE (SELECT count(*) FROM mfi_account_financing_lunas b, mfi_account_financing c, mfi_cif d, mfi_cm e
						WHERE b.account_financing_no = c.account_financing_no 
						AND c.cif_no = d.cif_no 
						AND d.cm_code = e.cm_code
						AND e.fa_code = a.fa_code 
						AND b.tanggal_lunas BETWEEN ? AND ?
					) > 0
					";
			$param[] = $tanggal;	
			$param[] = $tanggal2;
			$param[] = $tanggal;	
			$param[] = $tanggal2;
			$param[] = $tanggal;	
			$param[] = $tanggal2;
			if ($branch_code!="00000") {
				$sql .= " AND a.branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
			}
			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

	//Rembug
	public function export_rekap_pelunasan_pembiayaan_rembug($branch_code,$tanggal,$tanggal2)
	{
		$param = array();
		$sql = "SELECT d.cm_code,
					d.cm_name,
					count(a.account_financing_no) AS num,
					sum(a.saldo_pokok) AS amount
					FROM mfi_account_financing_lunas AS a
					JOIN mfi_account_financing AS b ON a.account_financing_no = b.account_financing_no
					JOIN mfi_cif AS c ON b.cif_no = c.cif_no
					JOIN mfi_cm AS d ON c.cm_code = d.cm_code
					JOIN mfi_branch AS e ON d.branch_id = e.branch_id
					WHERE a.tanggal_lunas BETWEEN ? AND ?";

				$param[] = $tanggal;	
				$param[] = $tanggal2;

				if($branch_code!="00000") {
					$sql .= " AND b.branch_code in (SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
					$param[] = $branch_code;
				}

				$sql.=" GROUP BY 1,2";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	//Cabang
	public function export_rekap_pelunasan_pembiayaan_cabang($branch_code,$tanggal,$tanggal2)
		{
			$param = array();
			$sql = "SELECT
					a.branch_code,
					a.branch_name,
					(SELECT count(*) FROM mfi_account_financing_lunas b, mfi_account_financing c, mfi_cif d 
						WHERE b.account_financing_no = c.account_financing_no 
						AND c.cif_no = d.cif_no 
						AND b.tanggal_lunas BETWEEN ? AND?
						AND d.branch_code = a.branch_code
					) AS num,
					(SELECT sum(b.saldo_pokok) FROM mfi_account_financing_lunas b, mfi_account_financing c, mfi_cif d
						WHERE b.account_financing_no = c.account_financing_no 
						AND c.cif_no = d.cif_no
						AND b.tanggal_lunas BETWEEN ? AND ?
						AND d.branch_code = a.branch_code
					) AS amount
					FROM mfi_branch a
					WHERE (SELECT count(*) FROM mfi_account_financing_lunas b, mfi_account_financing c, mfi_cif d 
						WHERE b.account_financing_no = c.account_financing_no 
						AND c.cif_no = d.cif_no 
						AND b.tanggal_lunas BETWEEN ? AND ?
						AND d.branch_code = a.branch_code
					) > 0";
			
			$param[] = $tanggal;
			$param[] = $tanggal2;
			$param[] = $tanggal;
			$param[] = $tanggal2;
			$param[] = $tanggal;
			$param[] = $tanggal2;
			if ($branch_code!="00000") {
				$sql .= " AND a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
	
			$sql .= " ORDER BY a.branch_code asc";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}

	/****************************************************************************************/	
	// END REKAP PELUNASAN
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// BEGIN REKAP ANGGOTA KELUAR 	
	/****************************************************************************************/
		//cabang
		public function export_rekap_anggota_keluar_semua_cabang($tanggal,$tanggal2)
		{
			$sql = "SELECT
							mfi_branch.branch_code,
							mfi_branch.branch_name,
							Count(mfi_cif_mutasi.cif_no) AS num
					FROM
							mfi_cif_mutasi
							JOIN mfi_cif ON mfi_cif_mutasi.cif_no = mfi_cif.cif_no
							JOIN mfi_branch ON mfi_branch.branch_code = mfi_cif.branch_code
					WHERE
							mfi_cif_mutasi.tipe_mutasi='1' and 
							mfi_cif_mutasi.tanggal_mutasi BETWEEN ? AND ? ";

					$param[] = $tanggal;	
					$param[] = $tanggal2;

					$sql.=" GROUP BY 1,2 ";

					$query = $this->db->query($sql,$param);

					return $query->result_array();
		}

		//by cabang
		public function export_rekap_anggota_keluar_cabang($branch_code,$tanggal,$tanggal2)
		{
			$param = array();
			$sql = " select 
					d.branch_code, d.branch_name, 
					count(a.cif_no) num 
					from mfi_cif_mutasi  a 
					left outer join mfi_cif b on a.cif_no=b.cif_no 
					left outer join mfi_cm c on b.cm_code=c.cm_code 
					left outer join mfi_branch d on b.branch_code=d.branch_code 
					where a.tipe_mutasi='1'
					and a.tanggal_mutasi between ? and ? ";
					$param[] = $tanggal;
					$param[] = $tanggal2;
					$param[] = $tanggal;
					$param[] = $tanggal2;
					$param[] = $tanggal;
					$param[] = $tanggal2;
					if ($branch_code!="00000") {
					$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
					$param[] = $branch_code;
					}
					$sql .= " group by 1,2 ";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}
		
		//petugas
		public function export_rekap_anggota_keluar_petugas($branch_code,$tanggal,$tanggal2)
		{
			$param = array();
			$sql ="select 
			       d.fa_code, d.fa_name,
				   count(a.cif_no) num 
				   from mfi_cif_mutasi  a
				   left outer join mfi_cif b on a.cif_no=b.cif_no 
				   left outer join mfi_cm c on b.cm_code=c.cm_code 
				   left outer join mfi_fa d on c.fa_code=d.fa_code 
				   where a.tipe_mutasi='1'
				   and a.tanggal_mutasi between ? and ? ";
				$param[] = $tanggal;	
				$param[] = $tanggal2;
				$param[] = $tanggal;	
				$param[] = $tanggal2;
				$param[] = $tanggal;	
				$param[] = $tanggal2;
				if ($branch_code!="00000") {	
					$sql .= " AND b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
				$param[] = $branch_code;
				}
				$sql .=" group by 1,2 "; 
					
				$query = $this->db->query($sql,$param);
			return $query->result_array();
		}
		
		//kecamatan
		public function export_rekap_anggota_keluar_kecamatan($branch_code,$tanggal,$tanggal2)
		{
			$param = array();
			$sql = "SELECT 
					e.kecamatan_code, e.kecamatan, 
					count(a.cif_no) num 
					from mfi_cif_mutasi  a 
					left outer join mfi_cif b on a.cif_no=b.cif_no 
					left outer join mfi_cm c on b.cm_code=c.cm_code 
					left outer join mfi_kecamatan_desa d on c.desa_code=d.desa_code 
					left outer join mfi_city_kecamatan e on d.kecamatan_code=e.kecamatan_code 
					where a.tipe_mutasi='1' 
					and a.tanggal_mutasi between ? and ? 
					";
				$param[] = $tanggal;	
				$param[] = $tanggal2;
				$param[] = $tanggal;	
				$param[] = $tanggal2;
				$param[] = $tanggal;	
				$param[] = $tanggal2;
				if ($branch_code!="00000") {
					$sql .= " AND b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
				}
				$sql .=" group by 1,2 "; 
				
				$query = $this->db->query($sql,$param);
			return $query->result_array();
		}
		
		//alasan 
		public function export_rekap_anggota_keluar_alasan($branch_code,$tanggal,$tanggal2)
		{
			$param = array();
			$sql = "SELECT 
					d.code_value, d.display_text, 
					count(a.cif_no) num 
					from mfi_cif_mutasi  a 
					left outer join mfi_cif b on a.cif_no=b.cif_no 
					left outer join mfi_cm c on b.cm_code=c.cm_code 
					left outer join mfi_list_code_detail d on a.alasan=d.code_value and d.code_group='anggotakeluar' 
					where a.tipe_mutasi='1' 
					and a.tanggal_mutasi between ? and ? ";
					$param[] = $tanggal;	
					$param[] = $tanggal2;
					if ($branch_code!="00000") {
					$sql .= " AND b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
				}			
				$sql .=" group by 1,2 order by 1,2  "; 
				
				$query = $this->db->query($sql,$param);
			return $query->result_array();
		}		

	/****************************************************************************************/	
	// END REKAP ANGGOTA KELUAR 
	/****************************************************************************************/
	
	

	/****************************************************************************************/	
	// BEGIN REKAP SALDO ANGGOTA 
	/****************************************************************************************/
	
	///rekap_saldo_anggota by cabang 
	public function export_rekap_saldo_anggota($branch_code)
	{
		$sql = "SELECT 
		mb.branch_code,
		mb.branch_name,
		COUNT(mc.cif_no) AS jumlah_anggota,
		(SELECT SUM(saldo_pokok) FROM mfi_account_financing AS maf, mfi_cif AS mcf WHERE maf.cif_no = mcf.cif_no AND maf.status_rekening = '1' AND mcf.status = '1' AND mcf.branch_code = mb.branch_code) AS saldo_pokok,
		(SELECT SUM(saldo_margin) FROM mfi_account_financing AS maf, mfi_cif AS mcf WHERE maf.cif_no = mcf.cif_no AND maf.status_rekening = '1' AND mcf.status = '1' AND mcf.branch_code = mb.branch_code) AS saldo_margin,
		(SELECT SUM(saldo_catab) FROM mfi_account_financing AS maf, mfi_cif AS mcf WHERE maf.cif_no = mcf.cif_no AND maf.status_rekening = '1' AND mcf.status = '1' AND mcf.branch_code = mb.branch_code) AS saldo_catab,
		(SELECT SUM(saldo_memo) FROM mfi_account_saving AS mas, mfi_cif AS mcf WHERE mas.account_saving_no = mcf.cif_no AND mas.status_rekening = '1'  AND mas.product_code='0099' AND mcf.status = '1' AND mas.branch_code = mb.branch_code) AS dtk,
		SUM(madb.setoran_lwk) AS setoran_lwk,
		SUM(madb.simpanan_pokok) AS simpanan_pokok,
		SUM(madb.tabungan_minggon) AS tabungan_minggon,
		SUM(madb.tabungan_sukarela) AS tabungan_sukarela,
		SUM(madb.tabungan_kelompok) AS tabungan_kelompok
		FROM mfi_account_default_balance AS madb 
		LEFT JOIN mfi_cif AS mc on madb.cif_no = mc.cif_no 
		LEFT JOIN mfi_branch AS mb on mb.branch_code = mc.branch_code 
		WHERE mc.status = '1' ";

		if($branch_code=="00000" || $branch_code==""){
			$sql .= "";
			$param[] = $branch_code;
		}else if($branch_code!="00000"){
			$sql .="AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}
		
		$sql .="GROUP BY 1,2 ORDER BY 1,2"; 
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_rekap_saldo_anggota_lalu($branch_code)
	{
		$sql = "SELECT 
		mb.branch_code,
		mb.branch_name,
		COUNT(mc.cif_no) AS jumlah_anggota,
		(SELECT SUM(saldo_pokok) FROM mfi_account_financing AS maf, mfi_cif AS mcf WHERE maf.cif_no = mcf.cif_no AND maf.status_rekening = '1' AND mcf.status = '1' AND mcf.branch_code = mb.branch_code) AS saldo_pokok,
		(SELECT SUM(saldo_margin) FROM mfi_account_financing AS maf, mfi_cif AS mcf WHERE maf.cif_no = mcf.cif_no AND maf.status_rekening = '1' AND mcf.status = '1' AND mcf.branch_code = mb.branch_code) AS saldo_margin,
		(SELECT SUM(saldo_catab) FROM mfi_account_financing AS maf, mfi_cif AS mcf WHERE maf.cif_no = mcf.cif_no AND maf.status_rekening = '1' AND mcf.status = '1' AND mcf.branch_code = mb.branch_code) AS saldo_catab,
		SUM(madb.setoran_lwk) AS setoran_lwk,
		SUM(madb.simpanan_pokok) AS simpanan_pokok,
		SUM(mcbd.tabungan_wajib) AS tabungan_minggon,
		SUM(mcbd.tabungan_sukarela) AS tabungan_sukarela,
		SUM(mcbd.tabungan_kelompok) AS tabungan_kelompok
		FROM mfi_closing_balance_data AS mcbd 
		LEFT JOIN mfi_cif AS mc on mcbd.cif_no = mc.cif_no 
		LEFT JOIN mfi_branch AS mb on mb.branch_code = mc.branch_code 
		LEFT JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		WHERE mc.status = '1' AND mcbd.closing_thru_date = ? ";
			$param[] = $tanggal;

		if($branch_code=="0000" || $branch_code==""){
			$sql .= "";
			$param[] = $branch_code;
		}else if($branch_code!="0000"){
			$sql .="AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}
		
		$sql .="GROUP BY 1,2 ORDER BY 1,2"; 
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	
	///rekap saldo anggota by rembug 
	public function export_rekap_saldo_anggota_rembug($branch_code)
	{
		$sql = "SELECT 
				b.cm_code, a.cm_name, 
				count(b.cif_no) jumlah_anggota, 
				sum(c.saldo_pokok) saldo_pokok,	sum(c.saldo_margin) saldo_margin, sum(c.saldo_catab) saldo_catab, sum(f.saldo_memo) dtk,
				sum(d.setoran_lwk) setoran_lwk, sum(d.simpanan_pokok) simpanan_pokok, sum(d.tabungan_minggon) tabungan_minggon, 
				sum(d.tabungan_sukarela) tabungan_sukarela, sum(d.tabungan_kelompok) tabungan_kelompok 
				from mfi_cif b 
				left outer join mfi_cm a on a.cm_code=b.cm_code 
				left outer join mfi_account_default_balance d on d.cif_no=b.cif_no 
				left outer join mfi_account_financing c on c.cif_no=b.cif_no and c.status_rekening='1' 
				left outer join mfi_account_saving f on f.account_saving_no=b.cif_no and f.product_code='0099' and  f.status_rekening='1' 
				where b.status='1' ";

		if($branch_code=="00000" || $branch_code==""){
			$sql .= " ";
			$param[] = $branch_code;
		}else if($branch_code!="00000"){
			$sql .=" and b.branch_code in (select branch_code from mfi_branch_member where branch_induk= ?) ";
			$param[] = $branch_code;
		}
		
		$sql .=" GROUP BY 1,2 ORDER BY 1,2 "; 
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	
	///rekap saldo anggota by petugas
	public function export_rekap_saldo_anggota_petugas($branch_code)
	{
		$sql = "SELECT 
				a.fa_code, e.fa_name,  
				count(b.cif_no) jumlah_anggota, 
				sum(c.saldo_pokok) saldo_pokok,	sum(c.saldo_margin) saldo_margin, sum(c.saldo_catab) saldo_catab, sum(f.saldo_memo) dtk, 
				sum(d.setoran_lwk) setoran_lwk, sum(d.simpanan_pokok) simpanan_pokok, sum(d.tabungan_minggon) tabungan_minggon, 
				sum(d.tabungan_sukarela) tabungan_sukarela, sum(d.tabungan_kelompok) tabungan_kelompok 
				from mfi_cif b 
				left outer join mfi_cm a on a.cm_code=b.cm_code 
				left outer join mfi_fa e on e.fa_code=a.fa_code 
				left outer join mfi_account_default_balance d on d.cif_no=b.cif_no 
				left outer join mfi_account_financing c on c.cif_no=b.cif_no and c.status_rekening='1' 
				left outer join mfi_account_saving f on f.account_saving_no=b.cif_no and f.product_code='0099' and f.status_rekening='1' 
				where b.status='1' ";

		if($branch_code=="00000" || $branch_code==""){
			$sql .= " ";
			$param[] = $branch_code;
		}else if($branch_code!="00000"){
			$sql .=" and b.branch_code in (select branch_code from mfi_branch_member where branch_induk= ?) ";
			$param[] = $branch_code;
		}
		
		$sql .=" GROUP BY 1,2 ORDER BY 1,2 "; 
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_rekap_outstanding_pembiayaan_semua_cabang($branch_code)
	{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					 mfi_branch.branch_code
					,mfi_branch.branch_name
					,(select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="0000"){
				$sql .= " and mfi_account_financing.branch_code = ?";
				$param[] = $branch_code;
			}
			$sql .= "
						) as num
					,(select sum(mfi_account_financing.saldo_pokok) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="0000"){
				$sql .= " and mfi_account_financing.branch_code = ?";
				$param[] = $branch_code;
			}
			$sql .= "
						) as pokok
					,(select sum(mfi_account_financing.saldo_margin) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="0000"){
				$sql .= " and mfi_account_financing.branch_code = ?";
				$param[] = $branch_code;
			}
			$sql .= "
						) as margin
					from mfi_branch
					where (select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="0000"){
				$sql .= " and mfi_account_financing.branch_code = ?";
				$param[] = $branch_code;
			}
			$sql .= "
						) > 0
					";

					$sql.=" GROUP BY 1,2 ORDER BY mfi_branch.branch_name asc";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
	}

	function export_rekap_outstanding_pembiayaan_cabang_lalu($branch_code,$tanggal){
		$param = array();

		$sql = "SELECT
		mb.branch_name,
		COUNT(mcld.*) AS jumlah,
		SUM(mcld.saldo_pokok) AS saldo_pokok,
		SUM(mcld.saldo_margin) AS saldo_margin
		FROM mfi_branch AS mb
		JOIN mfi_account_financing AS maf ON maf.branch_code = mb.branch_code
		JOIN mfi_closing_financing_data AS mcld ON mcld.account_financing_no = maf.account_financing_no
		WHERE mcld.closing_thru_date = ? ";

		$param[] = $tanggal;

		if($branch_code != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1 ORDER BY 1";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_rekap_outstanding_pembiayaan_cabang($branch_code)
	{
		$param = array();
		$sql = "SELECT 
				 mfi_branch.branch_code
				,mfi_branch.branch_name
				,mfi_branch.branch_class
				,(select count(*) from mfi_account_financing a where a.status_rekening=1 and a.branch_code=mfi_branch.branch_code) as num
				,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a where a.status_rekening=1 and a.branch_code=mfi_branch.branch_code) as pokok
				,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a where a.status_rekening=1 and a.branch_code=mfi_branch.branch_code) as margin
				,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a where a.status_rekening=1 and a.branch_code=mfi_branch.branch_code) as catab
				FROM mfi_branch ";
		if ($branch_code!="00000") {
			$sql .= " WHERE mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$sql .= " order by 3,2";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

		//rembug
		public function export_rekap_outstanding_pembiayaan_rembug($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					mfi_cm.cm_code
					,mfi_cm.cm_name
					,(select count(*) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as jumlah
					,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as saldo_pokok
					,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as saldo_margin
					,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as saldo_catab
					from mfi_cm
					where (select count(*) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) > 0 ";

			$sql.=" GROUP BY 1,2 ORDER BY mfi_cm.cm_name asc";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

	function export_rekap_outstanding_pembiayaan_rembug_lalu($branch_code,$tanggal){
		$param = array();

		$sql = "SELECT
		mcm.cm_name,
		COUNT(mcld.*) AS jumlah,
		SUM(mcld.saldo_pokok) AS saldo_pokok,
		SUM(mcld.saldo_margin) AS saldo_margin,
		SUM(mcld.saldo_catab) AS saldo_catab
		FROM mfi_cm AS mcm
		JOIN mfi_cif AS mc ON mc.cm_code = mcm.cm_code
		JOIN mfi_account_financing AS maf ON maf.cif_no = mc.cif_no
		JOIN mfi_closing_financing_data AS mcld ON mcld.account_financing_no = maf.account_financing_no
		WHERE mcld.closing_thru_date = ? ";

		$param[] = $tanggal;

		if($branch_code != '00000'){
			$sql .= "AND maf.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";

			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1 ORDER BY 1";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

		//petugas
		public function export_rekap_outstanding_pembiayaan_petugas($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					mfi_fa.fa_code
					,mfi_fa.fa_name
					,(select count(*) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as jumlah
					,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") as saldo_pokok
					,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") as saldo_margin
					,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") as saldo_catab
					from mfi_fa
					where (select count(*) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") > 0";
			$sql.=" GROUP BY 1,2 ORDER BY mfi_fa.fa_name asc";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

		function export_rekap_outstanding_pembiayaan_petugas_lalu($branch_code,$tanggal){

			$param = array();

			$sql = "SELECT
			mf.fa_name,
			COUNT(mcld.*) AS jumlah,
			SUM(mcld.saldo_pokok) AS saldo_pokok,
			SUM(mcld.saldo_margin) AS saldo_margin,
			SUM(mcld.saldo_catab) AS saldo_catab
			FROM mfi_fa AS mf
			JOIN mfi_cm AS mcm ON mcm.fa_code = mf.fa_code
			JOIN mfi_cif AS mc ON mc.cm_code = mcm.cm_code
			JOIN mfi_account_financing AS maf ON maf.cif_no = mc.cif_no
			JOIN mfi_closing_financing_data AS mcld ON mcld.account_financing_no = maf.account_financing_no
			WHERE mcld.closing_thru_date = ? ";

			$param[] = $tanggal;

			if($branch_code != '00000'){
				$sql .= "AND maf.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
				$param[] = $branch_code;
			}

			$sql .= "GROUP BY 1 ORDER BY 1";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}

		function export_rekap_outstanding_pembiayaan_produk($branch_code){
			$sql = "SELECT mpf.product_name, mpf.product_code, 
			COUNT(cif_no) AS num,
			COALESCE(SUM(maf.saldo_pokok),0) AS pokok,
			COALESCE(SUM(maf.saldo_margin),0) AS margin,
			COALESCE(SUM(maf.saldo_catab),0) AS catab
			FROM mfi_account_financing AS maf
			LEFT JOIN mfi_product_financing AS mpf
			ON (mpf.product_code = maf.product_code)
			WHERE maf.status_rekening = '1' ";

			$param = array();

			if($branch_code != '00000'){
				$sql .= "AND maf.branch_code
				IN(SELECT branch_code FROM mfi_branch_member
				WHERE branch_induk = ?)";
				
				$param[] = $branch_code;
			}

			$sql .= "GROUP BY 1,2 ORDER BY 1 ASC";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}


		function export_rekap_outstanding_pembiayaan_produk_lalu($branch_code,$tanggal){
			$param = array();

			$sql = "SELECT
			mpf.product_name,
			COUNT(*) AS num,
			SUM(mcfd.saldo_pokok) AS pokok,
			SUM(mcfd.saldo_margin) AS margin,
			SUM(mcfd.saldo_catab) AS catab
			FROM mfi_closing_financing_data AS mcfd
			JOIN mfi_account_financing AS maf ON mcfd.account_financing_no = maf.account_financing_no
			JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
			WHERE mcfd.closing_thru_date = ? ";

			$param[] = $tanggal;

			if($branch_code != '00000'){
				$sql .= "AND maf.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
				$param[] = $branch_code;
			}

			$sql .= "GROUP BY 1 ORDER BY 1";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}
		
		/* Produk Sayyid
		public function export_rekap_outstanding_pembiayaan_produk($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
			mfi_product_financing.product_name,
			mfi_product_financing.product_code,
			(SELECT COUNT(*) FROM mfi_account_financing a
			 WHERE a.status_rekening = 1
			 AND a.product_code::VARCHAR = mfi_product_financing.product_code";
			if($branch_code!="00000"){
				$sql .= " AND a.branch_code IN(SELECT branch_code
				FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch_code;
			}
			$sql .= ") AS num,
			(SELECT COALESCE(SUM(a.saldo_pokok),0) FROM mfi_account_financing a
			 WHERE a.status_rekening = 1
			 AND a.product_code::VARCHAR = mfi_product_financing.product_code";
			if($branch_code!="00000"){
				$sql .= " AND a.branch_code IN(SELECT branch_code
				FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch_code;
			}
			$sql .= ") AS pokok,
			(SELECT COALESCE(SUM(a.saldo_margin),0) FROM mfi_account_financing a
			 WHERE a.status_rekening = 1
			 AND a.product_code::VARCHAR = mfi_product_financing.product_code";
			if($branch_code!="00000"){
				$sql .= " AND a.branch_code IN(SELECT branch_code
				FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch_code;
			}
			$sql .= ") AS margin,
			(SELECT COALESCE(SUM(a.saldo_catab),0) FROM mfi_account_financing a
			 WHERE a.status_rekening = 1
			 AND a.product_code::VARCHAR = mfi_product_financing.product_code";
			if($branch_code!="00000"){
				$sql .= " AND a.branch_code IN(SELECT branch_code
				FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch_code;
			}
			$sql .= ") AS catab
			FROM mfi_product_financing 
			WHERE (SELECT COUNT(*) FROM mfi_account_financing a
			WHERE a.status_rekening = 1
			AND a.product_code::VARCHAR = mfi_product_financing.product_code";
			if($branch_code!="00000"){
				$sql .= " AND a.branch_code IN(SELECT branch_code
				FROM mfi_branch_member WHERE branch_induk = ?)";
				$param[] = $branch_code;
			}
			$sql .= ") > 0";
			$sql.=" GROUP BY 1,2";
			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}
		*/
		
		//peruntukan
		public function export_rekap_outstanding_pembiayaan_peruntukan($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					 code_detail.display_text
					,code_detail.code_value
					,(select count(*) from mfi_account_financing a where a.status_rekening=1 ";

					if($branch_code!="00000"){
						$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
						$param[] = $branch_code;
					}

			$sql .= " and a.peruntukan::varchar=code_detail.code_value) as num
					,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as pokok
					,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as margin
					,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as catab
					from mfi_list_code_detail as code_detail
					where (select count(*) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) > 0 and code_detail.code_group='peruntukan' ";

					$sql.=" GROUP BY 1,2";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
		}


	function export_rekap_outstanding_pembiayaan_peruntukan_lalu($branch_code,$tanggal){
		$param = array();

		$sql = "SELECT
		mlcd.display_text,
		COUNT(mcfd.*) AS num,
		SUM(mcfd.saldo_pokok) AS pokok,
		SUM(mcfd.saldo_margin) AS margin,
		SUM(mcfd.saldo_catab) AS catab
		FROM mfi_list_code_detail AS mlcd
		JOIN mfi_account_financing AS maf ON maf.peruntukan::VARCHAR = mlcd.code_value
		JOIN mfi_closing_financing_data AS mcfd ON mcfd.account_financing_no = maf.account_financing_no
		WHERE mlcd.code_group = 'peruntukan' AND mcfd.closing_thru_date = ? ";

		$param[] = $tanggal;

		if($branch_code != '00000'){
			$sql .= "AND maf.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[]  = $branch_code;
		}

		$sql .= "GROUP BY 1 ORDER BY 1";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

		function export_rekap_outstanding_pembiayaan_sektor_usaha($branch_code){
			$sql = "SELECT mlcd.display_text, COUNT(*) AS num,
			SUM(maf.saldo_pokok) AS pokok,
			SUM(maf.saldo_margin) AS margin,
			SUM(maf.saldo_catab) AS catab
			FROM mfi_account_financing AS maf
			LEFT JOIN mfi_product_financing AS mpf
			ON (mpf.product_code = maf.product_code)
			LEFT JOIN mfi_list_code_detail AS mlcd
			ON (CAST(mlcd.code_value AS INTEGER) = maf.sektor_ekonomi)
			AND mlcd.code_group = 'sektor_ekonomi'
			WHERE maf.status_rekening = '1' ";

			$param = array();

			if($branch_code != '00000'){
				$sql .= "AND maf.branch_code
				IN(SELECT branch_code FROM mfi_branch_member
				WHERE branch_induk = ?)";
				
				$param[] = $branch_code;
			}

			$sql .= "GROUP BY 1 ORDER BY 1 ASC";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}

		function export_rekap_outstanding_pembiayaan_sumber_dana($branch_code){
			$sql = "SELECT mlcd.display_text, COUNT(*) AS num,
			SUM(maf.saldo_pokok) AS pokok,
			SUM(maf.saldo_margin) AS margin,
			SUM(maf.saldo_catab) AS catab
			FROM mfi_account_financing AS maf
			LEFT JOIN mfi_product_financing AS mpf
			ON (mpf.product_code = maf.product_code)
			LEFT JOIN mfi_list_code_detail AS mlcd
			ON (CAST(mlcd.code_value AS VARCHAR) = maf.kreditur_code)
			AND mlcd.code_group = 'kreditur'
			WHERE maf.status_rekening = '1' ";

			$param = array();

			if($branch_code != '00000'){
				$sql .= "AND maf.branch_code
				IN(SELECT branch_code FROM mfi_branch_member
				WHERE branch_induk = ?)";
				
				$param[] = $branch_code;
			}

			$sql .= "GROUP BY 1 ORDER BY 1 ASC";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}

		function export_rekap_outstanding_pembiayaan_sektor_usaha_lalu($branch_code,$tanggal){
			$param = array();

			$sql = "SELECT
			mlcd.display_text,
			COUNT(mcfd.*) AS num,
			SUM(mcfd.saldo_pokok) AS pokok,
			SUM(mcfd.saldo_margin) AS margin,
			SUM(mcfd.saldo_catab) AS catab
			FROM mfi_list_code_detail AS mlcd
			JOIN mfi_account_financing AS maf ON maf.sektor_ekonomi::VARCHAR = mlcd.code_value
			JOIN mfi_closing_financing_data AS mcfd ON mcfd.account_financing_no = maf.account_financing_no
			WHERE mlcd.code_group = 'sektor_ekonomi' AND mcfd.closing_thru_date = ? ";

			$param[] = $tanggal;

			if($branch_code != '00000'){
				$sql .= "AND maf.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
				$param[]  = $branch_code;
			}

			$sql .= "GROUP BY 1 ORDER BY 1";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}

		function export_rekap_outstanding_pembiayaan_sumber_dana_lalu($branch_code,$tanggal){
			$param = array();

			$sql = "SELECT
			mlcd.display_text,
			COUNT(mcfd.*) AS num,
			SUM(mcfd.saldo_pokok) AS pokok,
			SUM(mcfd.saldo_margin) AS margin,
			SUM(mcfd.saldo_catab) AS catab
			FROM mfi_list_code_detail AS mlcd
			JOIN mfi_account_financing AS maf ON maf.kreditur_code = mlcd.code_value
			JOIN mfi_closing_financing_data AS mcfd ON mcfd.account_financing_no = maf.account_financing_no
			WHERE mlcd.code_group = 'kreditur' AND mcfd.closing_thru_date = ? ";

			$param[] = $tanggal;

			if($branch_code != '00000'){
				$sql .= "AND maf.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
				$param[]  = $branch_code;
			}

			$sql .= "GROUP BY 1 ORDER BY 1";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}

		/*sektor usaha sayyid
		public function export_rekap_outstanding_pembiayaan_sektor_usaha($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					 code_detail.display_text
					,code_detail.code_value
					,(select count(*) from mfi_account_financing a where a.status_rekening=1 ";

			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql .= " and a.sektor_ekonomi::varchar=code_detail.code_value) as num
					,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a where a.status_rekening=1 and a.sektor_ekonomi::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as pokok
					,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a where a.status_rekening=1 and a.sektor_ekonomi::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as margin
					,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a where a.status_rekening=1 and a.sektor_ekonomi::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as catab
					from mfi_list_code_detail as code_detail
					where (select count(*) from mfi_account_financing a where a.status_rekening=1 and a.sektor_ekonomi::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) > 0 and code_detail.code_group='sektor_ekonomi' ";

			$sql.=" GROUP BY 1,2";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}
		*/

	/****************************************************************************************/	
	// END REKAP OUTSTANDING PEMBIAYAAN
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// REKAP SEBARAN ANGGOTA 
	/****************************************************************************************/
	
	//cabang
	function export_rekap_sebaran_anggota_semua_cabang($branch_code){
		$sql = "SELECT

		mpc.city_code,
		mpc.city,

		(SELECT COUNT(mck.kecamatan_code) FROM mfi_city_kecamatan AS mck WHERE mck.city_code = mpc.city_code AND mck.kecamatan_code IN(
			SELECT kecamatan_code FROM mfi_kecamatan_desa WHERE desa_code IN(
				SELECT desa_code FROM mfi_cm WHERE cm_code IN(
					SELECT cm_code FROM mfi_cif WHERE status = '1'";

		$param = array();
		
		if($branch_code != '00000'){
			$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$sql .=")))) AS kecamatan,

		(SELECT COUNT(mkd.desa_code) FROM mfi_kecamatan_desa AS mkd
		 JOIN mfi_city_kecamatan AS mck ON mkd.kecamatan_code = mck.kecamatan_code AND mck.city_code = mpc.city_code AND mkd.desa_code IN(
			SELECT desa_code FROM mfi_cm WHERE cm_code IN(
				SELECT cm_code FROM mfi_cif WHERE status = '1'";

		if($branch_code != '00000'){
			$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}
		
		$sql .="))) AS desa,

		(SELECT COUNT(mcm.cm_code) FROM mfi_cm AS mcm
		 JOIN mfi_kecamatan_desa AS mkd ON mcm.desa_code = mkd.desa_code
		 JOIN mfi_city_kecamatan AS mck ON mck.kecamatan_code = mkd.kecamatan_code AND mck.city_code = mpc.city_code AND mcm.cm_code IN(
			SELECT cm_code FROM mfi_cif WHERE status = '1'";

		if($branch_code != '00000'){
			$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$sql .= ")) AS majelis,

		(SELECT COUNT(mc.cif_no) FROM mfi_cif AS mc JOIN mfi_cm AS mcm ON mc.cm_code = mcm.cm_code JOIN mfi_kecamatan_desa AS mkd ON mcm.desa_code = mkd.desa_code JOIN mfi_city_kecamatan AS mck ON mck.kecamatan_code = mkd.kecamatan_code AND mck.city_code = mpc.city_code AND mc.status = '1'"; 

		if($branch_code != '00000'){
			$sql .= " AND branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$sql .= ") AS anggota

		FROM mfi_province_city AS mpc
		JOIN mfi_city_kecamatan AS mck ON mck.city_code = mpc.city_code
		JOIN mfi_kecamatan_desa AS mkd ON mkd.kecamatan_code = mck.kecamatan_code
		JOIN mfi_cm AS mcm ON mcm.desa_code = mkd.desa_code
		JOIN mfi_cif AS mc ON mc.cm_code = mcm.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code

		WHERE mpc.city_code IN(SELECT city_code FROM mfi_city_kecamatan WHERE kecamatan_code IN(SELECT kecamatan_code FROM mfi_kecamatan_desa WHERE desa_code IN(SELECT desa_code FROM mfi_cm WHERE cm_code IN(SELECT cm_code FROM mfi_cif WHERE status = '1'))))";
		
		if($branch_code != '00000'){
			$sql .= " AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY 1,2 ORDER BY 1";

		//echo $sql; exit();

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	/*
	public function export_rekap_sebaran_anggota_semua_cabang($branch_code)
	{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "select 
					a.city_code, a.city, 
					(select count(b.kecamatan_code) 
					from mfi_city_kecamatan b 
					where  b.city_code=a.city_code and b.kecamatan_code in 
					(select kecamatan_code from mfi_kecamatan_desa where desa_code in 
					(select desa_code from mfi_cm where cm_code in 
					(select cm_code from mfi_cif where status='1') 
					))) kecamatan, 
					(select count(c.desa_code) 
					from mfi_kecamatan_desa c, mfi_city_kecamatan d 
					where c.kecamatan_code = d.kecamatan_code and d.city_code=a.city_code and c.desa_code in 
					(select desa_code from mfi_cm where cm_code in 
					(select cm_code from mfi_cif where  status='1' ) 
					)) desa, 
					(select count(e.cm_code)
					from mfi_cm e, mfi_kecamatan_desa f, mfi_city_kecamatan g 
					where e.desa_code=f.desa_code and f.kecamatan_code=g.kecamatan_code and g.city_code=a.city_code and e.cm_code in 
					(select cm_code from mfi_cif where status='1' ) 
					) majelis , 
					(select count(h.cif_no)
					from mfi_cif h, mfi_cm i, mfi_kecamatan_desa j, mfi_city_kecamatan k 
					where h.cm_code=i.cm_code and i.desa_code=j.desa_code and j.kecamatan_code=k.kecamatan_code and k.city_code=a.city_code and h.status='1'
					)  anggota  
					from mfi_province_city a 
					where a.city_code in 
					(select city_code from mfi_city_kecamatan where kecamatan_code in 
					(select kecamatan_code from mfi_kecamatan_desa where desa_code in 
					(select desa_code from mfi_cm where cm_code in 
					(select cm_code from mfi_cif where status='1' ) 
					))) 
					group by 1,2 "; 

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
	}
	*/

		//by cabang
		public function export_rekap_sebaran_anggota_cabang($branch_code)
		{
			$param = array();
			$sql = "select 
					a.city_code, a.city, 
					(select count(b.kecamatan_code) kecamatan 
					from mfi_city_kecamatan b 
					where  b.city_code=a.city_code and b.kecamatan_code in 
					(select kecamatan_code from mfi_kecamatan_desa where desa_code in 
					(select desa_code from mfi_cm where cm_code in 
					(select cm_code from mfi_cif where status='1') 
					))), 
					(select count(c.desa_code) desa 
					from mfi_kecamatan_desa c, mfi_city_kecamatan d 
					where c.kecamatan_code = d.kecamatan_code and d.city_code=a.city_code and c.desa_code in 
					(select desa_code from mfi_cm where cm_code in 
					(select cm_code from mfi_cif where  status='1' ) 
					)), 
					(select count(e.cm_code) majelis 
					from mfi_cm e, mfi_kecamatan_desa f, mfi_city_kecamatan g 
					where e.desa_code=f.desa_code and f.kecamatan_code=g.kecamatan_code and g.city_code=a.city_code and e.cm_code in 
					(select cm_code from mfi_cif where status='1' ) 
					), 
					(select count(h.cif_no) anggota  
					from mfi_cif h, mfi_cm i, mfi_kecamatan_desa j, mfi_city_kecamatan k 
					where h.cm_code=i.cm_code and i.desa_code=j.desa_code and j.kecamatan_code=k.kecamatan_code and k.city_code=a.city_code and h.status='1'
					) 
					from mfi_province_city a 
					where a.city_code in 
					(select city_code from mfi_city_kecamatan where kecamatan_code in 
					(select kecamatan_code from mfi_kecamatan_desa where desa_code in 
					(select desa_code from mfi_cm where cm_code in 
					(select cm_code from mfi_cif where status='1' ) 
					))) 
					group by 1,2 "; 

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

	/****************************************************************************************/	
	// END REKAP SEBARAN ANGGOTA 
	/****************************************************************************************/
	function jqgrid_count_outstanding_pembiayaan($cabang,$cif_type,$pembiayaan,$majelis,$petugas,$tanggal,$produk,$peruntukan,$sektor,$kreditur){
		$sql = "SELECT
		COUNT(*) AS num

		FROM mfi_account_financing AS maf

		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		JOIN mfi_account_financing_droping AS mafd
		ON maf.account_financing_no = mafd.account_financing_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_list_code_detail AS mlcd
		ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR)
		AND mlcd.code_group = 'peruntukan'
		JOIN mfi_list_code_detail AS fice
		ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR)
		AND fice.code_group = 'sektor_ekonomi'
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'

		WHERE maf.status_rekening = '1' ";

		$param = array();

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ?";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		// if($majelis != '00000'){
		// 	$sql .= "AND mcm.cm_code = ? ";
		// 	$param[] = $majelis;
		// }

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ?";
			$param[] = $produk;
		}
		
		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ?";
			$param[] = $sektor;
		} 

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_outstanding_pembiayaan($sidx,$sord,$limit_rows,$start,$cabang,$cif_type,$pembiayaan,$majelis,$petugas,$tanggal,$product_code,$peruntukan,$sektor,$kreditur){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY mb.branch_code,mcm.cm_name";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
		mc.nama,
		mc.no_ktp,
		mc.desa,
		mafd.droping_date,
		mafd.droping_by,
		maf.account_financing_no,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.saldo_pokok,
		maf.saldo_margin,
		maf.status_kolektibilitas,
		maf.margin,
		maf.pokok,
		maf.dana_kebajikan,
		mlcd.display_text AS peruntukan,
		fice.display_text AS sektor,
		mcm.cm_name,
		mf.fa_name,
		mpf.nick_name,
		CAST((maf.saldo_pokok / maf.angsuran_pokok) AS INTEGER)
		AS freq_bayar_saldo,
		maf.counter_angsuran AS freq_bayar_pokok,
		krt.display_text AS krd,
		maf.kreditur_code,
		maf.fl_reschedulle
		FROM mfi_account_financing AS maf
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_account_financing_droping AS mafd
		ON maf.account_financing_no = mafd.account_financing_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_list_code_detail AS mlcd
		ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR)
		AND mlcd.code_group = 'peruntukan'
		JOIN mfi_list_code_detail AS fice
		ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR)
		AND fice.code_group = 'sektor_ekonomi'
		JOIN mfi_product_financing AS mpf
		ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		WHERE maf.status_rekening = '1' AND  mc.cif_type='0' ";

		$param = array();

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ?";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($product_code != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $product_code;
		}

		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ? ";
			$param[] = $sektor;
		} 

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_count_outstanding_pembiayaan_lalu($cabang,$pembiayaan,$majelis,$petugas,$tanggal,$produk,$peruntukan,$sektor,$kreditur){
		$sql = "SELECT
		COUNT(*) AS num

		FROM mfi_closing_financing_data AS mcfd

		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		JOIN mfi_account_financing_droping AS mafd
		ON maf.account_financing_no = mafd.account_financing_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_list_code_detail AS mlcd
		ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR)
		AND mlcd.code_group = 'peruntukan'
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		JOIN mfi_list_code_detail AS fice
		ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR)
		AND fice.code_group = 'sektor_ekonomi'

		";

		$param = array();

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		}
		
		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ? ";
			$param[] = $sektor;
		}

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		$sql .= "AND mcfd.closing_thru_date = ?";
		$param[] = $tanggal;

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_outstanding_pembiayaan_lalu($sidx,$sord,$limit_rows,$start,$cabang,$pembiayaan,$majelis,$petugas,$tanggal,$product_code,$peruntukan,$sektor,$kreditur){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY mb.branch_code,mcm.cm_name,mc.kelompok::INTEGER ASC";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
		mc.nama,
		mc.no_ktp,
		mc.desa,
		mafd.droping_date,
		mafd.droping_by,
		maf.account_financing_no,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.jangka_waktu,
		mcfd.saldo_pokok,
		mcfd.saldo_margin,
		mcfd.saldo_catab,
		maf.status_kolektibilitas,
		maf.margin,
		maf.pokok,
		maf.dana_kebajikan,
		mlcd.display_text AS peruntukan,
		fice.display_text AS sektor,
		mcm.cm_name,
		mf.fa_name,
		mpf.nick_name,
		maf.fl_reschedulle,
		CAST((mcfd.saldo_pokok / maf.angsuran_pokok) AS INTEGER)
		AS freq_bayar_saldo,
		(maf.jangka_waktu - (mcfd.saldo_pokok / maf.angsuran_pokok)::INTEGER) AS freq_bayar_pokok,
		krt.display_text AS krd,
		maf.kreditur_code,
		maf.tanggal_jtempo
		FROM mfi_closing_financing_data AS mcfd
		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_account_financing_droping AS mafd
		ON maf.account_financing_no = mafd.account_financing_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_list_code_detail AS mlcd
		ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR)
		AND mlcd.code_group = 'peruntukan'
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		JOIN mfi_list_code_detail AS fice
		ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR)
		AND fice.code_group = 'sektor_ekonomi'
		JOIN mfi_product_financing AS mpf
		ON mpf.product_code = maf.product_code
		 ";

		$param = array();

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($product_code != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $product_code;
		}

		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ? ";
			$param[] = $sektor;
		}

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		$sql .= "AND mcfd.closing_thru_date = ?";
		$param[] = $tanggal;

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_count_outstanding_tabungan_lalu($cabang,$tabungan,$majelis,$petugas,$tanggal,$produk){
		$param = array();

		$sql = "SELECT
		COUNT(*) AS num

		FROM mfi_closing_saving_data AS mcsd
		JOIN mfi_account_saving AS mas ON mas.account_saving_no = mcsd.account_saving_no
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mcsd.closing_thru_date = ? ";

		$param[] = $tanggal;

		if($tabungan != '9'){
			$sql .= "AND mps.jenis_tabungan = ? ";
			$param[] = $tabungan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($produk != '00000'){
			$sql .= "AND mps.product_code = ? ";
			$param[] = $produk;
		}
		
		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_outstanding_tabungan_lalu($sidx,$sord,$limit_rows,$start,$cabang,$tabungan,$majelis,$petugas,$tanggal,$product_code){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY mb.branch_code,mcm.cm_name,mc.kelompok::INTEGER ASC";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$param = array();

		$sql = "SELECT
		mcsd.account_saving_no,
		mc.nama,
		mc.no_ktp,
		mcm.cm_name,
		mps.nick_name,
		mcsd.saldo_memo
		FROM mfi_closing_saving_data AS mcsd
		JOIN mfi_account_saving AS mas ON mas.account_saving_no = mcsd.account_saving_no
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mcsd.closing_thru_date = ? ";

		$param[] = $tanggal;

		if($tabungan != '9'){
			$sql .= "AND mps.jenis_tabungan = ? ";
			$param[] = $tabungan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($product_code != '00000'){
			$sql .= "AND mps.product_code = ? ";
			$param[] = $product_code;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	// =====================================
	function jqgrid_count_outstanding_pembiayaan_ind($cabang,$cif_type,$pembiayaan,$majelis,$petugas,$tanggal,$produk,$peruntukan,$sektor,$kreditur){
		$sql = "SELECT
		COUNT(*) AS num

		FROM mfi_account_financing AS maf

		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
		JOIN mfi_branch AS mb ON mb.branch_code=mc.branch_code 	
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = maf.fa_code
		JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR)	AND mlcd.code_group = 'peruntukan'
		JOIN mfi_list_code_detail AS fice ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR)	AND fice.code_group = 'sektor_ekonomi'
		JOIN mfi_product_financing AS mpf	ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'

		WHERE maf.status_rekening = '1'  AND  mc.cif_type='1' ";

		$param = array();

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ?";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		// if($majelis != '00000'){
		// 	$sql .= "AND mcm.cm_code = ? ";
		// 	$param[] = $majelis;
		// }

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ?";
			$param[] = $produk;
		}
		
		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ?";
			$param[] = $sektor;
		} 

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_outstanding_pembiayaan_ind($sidx,$sord,$limit_rows,$start,$cabang,$cif_type,$pembiayaan,$majelis,$petugas,$tanggal,$product_code,$peruntukan,$sektor,$kreditur){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY mb.branch_code";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT		
		mc.nama,
		mc.no_ktp,
		mc.desa,
		mafd.droping_date,
		mafd.droping_by,
		maf.account_financing_no,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.saldo_pokok,
		maf.saldo_margin,
		maf.status_kolektibilitas,
		maf.margin,
		maf.pokok,
		maf.dana_kebajikan,
		mlcd.display_text AS peruntukan,fice.display_text AS sektor,
		mf.fa_name,
		mpf.nick_name,	
		CAST((maf.saldo_pokok / maf.angsuran_pokok) AS INTEGER) AS freq_bayar_saldo,
		maf.counter_angsuran AS freq_bayar_pokok,
		krt.display_text AS krd,
		maf.kreditur_code,
		maf.fl_reschedulle
		FROM mfi_account_financing AS maf
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
		JOIN mfi_branch AS mb ON mb.branch_code=mc.branch_code 	
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = maf.fa_code
		JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR)	AND mlcd.code_group = 'peruntukan'
		JOIN mfi_list_code_detail AS fice ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR)	AND fice.code_group = 'sektor_ekonomi'
		JOIN mfi_product_financing AS mpf	ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		WHERE maf.status_rekening = '1'  AND  mc.cif_type = '1' "; //AND maf.financing_type = '1'

		$param = array();

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ?";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		// if($majelis != '00000'){
		// 	$sql .= "AND mcm.cm_code = ? ";
		// 	$param[] = $majelis;
		// }

		if($product_code != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $product_code;
		}

		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ? ";
			$param[] = $sektor;
		} 

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_count_outstanding_pembiayaan_kel($cabang,$cif_type,$pembiayaan,$majelis,$petugas,$tanggal,$produk,$peruntukan,$sektor){
		$sql = "SELECT
		COUNT(*) AS num

		FROM mfi_account_financing AS maf

		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
		JOIN mfi_branch AS mb ON mb.branch_code=mc.branch_code 	
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = maf.fa_code
		JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR)	AND mlcd.code_group = 'peruntukan'
		JOIN mfi_list_code_detail AS fice ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR)	AND fice.code_group = 'sektor_ekonomi'
		JOIN mfi_product_financing AS mpf	ON mpf.product_code = maf.product_code

		WHERE maf.status_rekening = '1'  AND  mc.cif_type='0' ";

		$param = array();

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ?";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ?";
			$param[] = $produk;
		}
		
		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ?";
			$param[] = $sektor;
		} 

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_outstanding_pembiayaan_kel($sidx,$sord,$limit_rows,$start,$cabang,$cif_type,$pembiayaan,$majelis,$petugas,$tanggal,$product_code,$peruntukan,$sektor,$kreditur){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY mb.branch_code";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT		
		mc.nama,
		mc.no_ktp,
		mc.desa,
		mafd.droping_date,
		mafd.droping_by,
		maf.account_financing_no,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.saldo_pokok,
		maf.saldo_margin,
		maf.status_kolektibilitas,
		maf.margin,
		maf.pokok,
		maf.dana_kebajikan,
		mlcd.display_text AS peruntukan,fice.display_text AS sektor,
		mf.fa_name,
		mpf.nick_name,	
		CAST((maf.saldo_pokok / maf.angsuran_pokok) AS INTEGER) AS freq_bayar_saldo,
		maf.counter_angsuran AS freq_bayar_pokok,
		krt.display_text AS krd,
		maf.kreditur_code
		FROM mfi_account_financing AS maf
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
		JOIN mfi_branch AS mb ON mb.branch_code=mc.branch_code 	
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = maf.fa_code
		JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR)	AND mlcd.code_group = 'peruntukan'
		JOIN mfi_list_code_detail AS fice ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR)	AND fice.code_group = 'sektor_ekonomi'
		JOIN mfi_product_financing AS mpf	ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		WHERE maf.status_rekening = '1'  AND  mc.cif_type='0' "; //AND maf.financing_type = '1'

		$param = array();

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ?";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($product_code != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $product_code;
		}

		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ? ";
			$param[] = $sektor;
		} 

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	// END

		function jqgrid_count_premi_anggota($cabang,$rembug,$product_code,$financing_type){
			$sql = "SELECT
			COUNT(*) AS num
			FROM mfi_account_financing AS maf
			LEFT JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
			LEFT JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
			LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
			LEFT JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
			LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
			WHERE maf.status_rekening = '1' AND maf.financing_type = ? ";

			$param = array();

			$param[] = $financing_type;

			if($cabang != '00000'){
				$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
				$param[] = $cabang;
			}

			if($rembug != '00000'){
				$sql .= "AND mcm.cm_code = ? ";
				$param[] = $rembug;
			}

			if($product_code != '00000'){
				$sql .= "AND maf.product_code = ? ";
				$param[] = $product_code;
			}

			$query = $this->db->query($sql,$param);
			$row = $query->row_array();
			return $row['num'];

		} 	

		function jqgrid_list_premi_anggota($sidx,$sord,$limit_rows,$start,$cabang,$rembug,$product_code,$financing_type){
			$order = '';
			$limit = '';

			if ($sidx!='' && $sord!='') $order = "ORDER BY mb.branch_code,mcm.cm_name,mc.kelompok::integer ASC";
			if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

			$sql = "SELECT
			maf.account_financing_no,
			mc.nama,
			mc.tgl_lahir,
			(select age(mc.tgl_lahir)) AS usia,
			mcm.cm_name,
			maf.peserta_asuransi AS p_nama,
			maf.tanggal_peserta_asuransi,
			(select age(maf.tanggal_peserta_asuransi)) AS p_usia,
			maf.pokok,
			maf.margin,
			mafd.droping_date,
			maf.tanggal_akad,
			maf.jangka_waktu,
			maf.tanggal_jtempo,
			maf.biaya_asuransi_jiwa,
			mafd.droping_by,
			maf.saldo_pokok,
			maf.saldo_margin,
			mf.fa_name
			FROM mfi_account_financing AS maf
			LEFT JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
			LEFT JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
			LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
			LEFT JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
			LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
			WHERE maf.status_rekening = 1 AND maf.financing_type = ? ";

			$param = array();

			$param[] = $financing_type;

			if($cabang != '00000'){
				$sql .= "AND mb.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
				$param[] = $cabang;
			}

			if($rembug != '00000'){
				$sql .= "AND mcm.cm_code = ? ";
				$param[] = $rembug;
			}

			if($product_code != '00000'){
				$sql .= "AND maf.product_code = ? ";
				$param[] = $product_code;
			}

			$sql .= "$order $limit";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		} 

	/****************************************************************************************/	
	// BEGIN LIST PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/
	function export_list_pengajuan_pembiayaan($cabang,$from,$thru,$majelis,$pembiayaan,$petugas){
		$sql = "SELECT
		mafr.registration_no,
		mafr.rencana_droping,
		mafr.status,
		mafr.tanggal_pengajuan,
		mc.nama,
		mcm.cm_name,
		mafr.amount,
		mafr.financing_type
		FROM mfi_account_financing_reg AS mafr
		JOIN mfi_cif AS mc ON mafr.cif_no = mc.cif_no
		JOIN mfi_cm AS mcm ON mc.cm_code = mcm.cm_code
		JOIN mfi_branch AS mb ON mcm.branch_id = mb.branch_id

		WHERE mafr.tanggal_pengajuan BETWEEN ? AND ? ";

		$param[] = $from;
		$param[] = $thru;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code = ? ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($petugas != '00000'){
			$sql .= "AND mcm.fa_code = ? ";
			$param[] = $petugas;
		}

		if($pembiayaan != '9'){
			$sql .= 'AND mafr.financing_type = ? ';
			$param[] = $pembiayaan;
		}

		$sql .= "ORDER BY mafr.tanggal_pengajuan DESC, mafr.status";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	/****************************************************************************************/	
	// END LIST PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN BLOKIR TABUNGAN
	/****************************************************************************************/

	public function export_list_blokir_tabungan($from_date,$thru_date,$branch_code)
	{
		$sql = "SELECT
				mfi_account_saving.account_saving_no as no_rek,
				mfi_cif.nama as nama,
				mfi_account_saving_blokir.created_date as tgl_blokir,
				mfi_account_saving_blokir.amount as jumlah,
				mfi_account_saving.created_date as tgl_buka,
				mfi_account_saving_blokir.description as keterangan
				FROM
				mfi_account_saving_blokir,mfi_account_saving,mfi_cif
				WHERE mfi_account_saving_blokir.account_saving_no = mfi_account_saving.account_saving_no
				AND mfi_account_saving.cif_no = mfi_cif.cif_no
				AND mfi_account_saving_blokir.created_date BETWEEN ? AND ?
				AND mfi_account_saving_blokir.tipe_mutasi = '2'
				";
				$param[]=$from_date;
				$param[]=$thru_date;
				if($branch_code!="0000"){
					$sql.=" AND mfi_cif.branch_code=?";
					$param[]=$branch_code;
				}

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 


	/****************************************************************************************/	
	// END LAPORAN BLOKIR TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN PEMBUKAAN DEPOSITO 
	/****************************************************************************************/

	public function export_list_pembukaan_deposito($from_date,$thru_date,$cabang,$product_code)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.nominal,
				mfi_account_deposit.jangka_waktu,
				mfi_account_deposit.tanggal_buka,
				mfi_account_deposit.tanggal_jtempo_last,
				mfi_account_deposit.automatic_roll_over,
				mfi_product_deposit.product_name,
				mfi_cm.cm_name
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_deposit ON mfi_account_deposit.product_code = mfi_product_deposit.product_code
				LEFT OUTER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				WHERE mfi_account_deposit.tanggal_buka BETWEEN ? AND ?
				-- AND mfi_account_deposit.status_rekening != '2'
				";
				$param[]=$from_date;
				$param[]=$thru_date;

				if($cabang!="0000"){
					$sql.=" AND mfi_cif.branch_code=?";
					$param[]=$cabang;
				}

				if($product_code!="0000"){
				$sql .= " AND mfi_product_deposit.product_code = ? ";
				$param[] = $product_code;
				}

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	}

	function get_product2($product_code)
	{
		$sql="select * from mfi_product_deposit where product_code=?";
		$query=$this->db->query($sql,array($product_code));
		return $query->row_array();
	}

	


	/****************************************************************************************/	
	// END LAPORAN PEMBUKAAN DEPOSITO 
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN DROPING DEPOSITO
	/****************************************************************************************/

	public function export_lap_droping_deposito($from_date,$thru_date,$cabang='',$product_code)
	{
		$sql = "SELECT
				mfi_account_deposit.account_deposit_no,
				mfi_cif.nama,
				mfi_account_deposit.jangka_waktu,
				mfi_account_deposit.tanggal_buka,
				mfi_account_deposit_break.trx_date,
				mfi_account_deposit.nilai_bagihasil_last,
				mfi_account_deposit.nominal
				FROM
				mfi_account_deposit
				LEFT JOIN mfi_account_deposit_break ON mfi_account_deposit.account_deposit_no = mfi_account_deposit_break.account_deposit_no
				LEFT JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				WHERE 		
				mfi_account_deposit_break.trx_date between ? and ?
				AND mfi_account_deposit.status_rekening !='0'
				";

				$param[] = $from_date;
				$param[] = $thru_date;

				if($cabang=="0000" || $cabang=="")
				{
				$sql .= " ";
				}
				elseif($cabang!="0000")
				{
				$sql .= " AND mfi_cif.branch_code = ? ";
				$param[] = $cabang;
				}

				if($product_code!="0000"){
				$sql .= " AND mfi_product_deposit.product_code = ? ";
				$param[] = $product_code;
				}

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 


	/****************************************************************************************/	
	// END LAPORAN DROPING DEPOSITO
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN OUTSTANDING
	/****************************************************************************************/

	public function export_rekap_outstanding_deposito($cabang='',$tanggal,$produk)
	{
		$sql = "SELECT
				mfi_account_deposit.account_deposit_no,
				mfi_cif.nama,
				mfi_account_deposit.tanggal_jtempo_last,
				mfi_account_deposit.automatic_roll_over,
				mfi_account_deposit.nominal,
				mfi_account_deposit.nilai_cadangan_bagihasil
				FROM
				mfi_account_deposit_break
				INNER JOIN mfi_account_deposit ON mfi_account_deposit_break.account_deposit_no = mfi_account_deposit.account_deposit_no
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_branch ON mfi_cif.branch_code = mfi_branch.branch_code
				INNER JOIN mfi_cm ON mfi_cif.cm_code = mfi_cm.cm_code
				INNER JOIN mfi_product_deposit ON mfi_account_deposit.product_code = mfi_product_deposit.product_code
				WHERE mfi_account_deposit.status_rekening != '0'
				";

				$param[] = $tanggal;

				if($cabang=="0000" || $cabang=="")
				{
				$sql .= " ";
				}
				elseif($cabang!="0000")
				{
				$sql .= " AND mfi_cif.branch_code = ? ";
				$param[] = $cabang;
				}

				// if($rembug!="")
				// {
				// $sql .= " AND mfi_cm.cm_code = ? ";
				// $param[] = $rembug;
				// }

				if($produk!="")
				{
				$sql .= " AND mfi_product_deposit.product_code = ? ";
				$param[] = $produk;
				}

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 

	/****************************************************************************************/	
	// END LAPORAN OUTSTANDING
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN TRANSAKSI TABUNGAN
	/****************************************************************************************/

	public function export_lap_transaksi_tabungan($cabang='',$rembug='',$from_date,$thru_date)
	{
		$sql = "SELECT 
				mfi_trx_account_saving.branch_id,
				mfi_trx_account_saving.account_saving_no,
				mfi_cif.nama,
				mfi_trx_account_saving.trx_saving_type,
				mfi_trx_account_saving.flag_debit_credit,
				mfi_trx_account_saving.trx_date,
				mfi_trx_account_saving.amount,
				mfi_trx_account_saving.description 
				FROM
				mfi_trx_account_saving
				LEFT JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_trx_account_saving.account_saving_no
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				WHERE mfi_trx_account_saving.trx_date BETWEEN ? AND ?
				";

				$param[] = $from_date;
				$param[] = $thru_date;

				if($cabang!="0000"){
					$sql .= " AND mfi_cif.branch_code=?";
					$param[] = $cabang;
				}
				if($rembug!="0000"){
					$sql .= " AND mfi_cif.cm_code=?";
					$param[] = $rembug;
				}
				$query = $this->db->query($sql,$param);
				// echo "<pre>";
				// print_r($this->db);
				// die();
				return $query->result_array();
	} 


	/****************************************************************************************/	
	// END LAPORAN TRANSAKSI TABUNGAN
	/****************************************************************************************/



	/****************************************************************************************/	
	// LAPORAN TRANSAKSI AKUN
	/****************************************************************************************/

	public function export_lap_transaksi_akun($cabang='',$rembug='',$from_date,$thru_date)
	{
		$sql = "SELECT
				mfi_trx_gl.branch_code,
				mfi_trx_gl.trx_date,
				mfi_trx_gl_detail.account_code,
				mfi_gl_account.account_name,
				mfi_trx_gl_detail.flag_debit_credit,
				mfi_trx_gl_detail.amount,
				mfi_trx_gl_detail.description,
				mfi_cif.nama  
				FROM 
				mfi_trx_gl_detail,
				mfi_trx_gl,
				mfi_gl_account,
				mfi_branch,
				mfi_cif,
				mfi_cm
				WHERE 
				mfi_trx_gl_detail.trx_gl_id=mfi_trx_gl.trx_gl_id 
				AND mfi_trx_gl_detail.account_code=mfi_gl_account.account_code
				AND mfi_branch.branch_code=mfi_trx_gl.branch_code
				AND mfi_cif.branch_code=mfi_branch.branch_code
				AND mfi_cm.cm_code=mfi_cif.cm_code
				AND mfi_trx_gl.trx_date BETWEEN ? AND ?
				";

				$param[] = $from_date;
				$param[] = $thru_date;

				if($cabang=="0000" || $cabang=="")
				{
				$sql .= " ";
				}
				elseif($cabang!="0000")
				{
				$sql .= " AND mfi_cif.branch_code = ? ";
				$param[] = $cabang;
				}

				if($rembug!="")
				{
				$sql .= " AND mfi_cm.cm_code = ? ";
				$param[] = $rembug;
				}

				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 


	/****************************************************************************************/	
	// END LAPORAN TRANSAKSI AKUN
	/****************************************************************************************/

	public function get_data_rekap_transaksi_rembug_by_semua_cabang($from_date,$thru_date)
	{
		$sql = "
				select branch_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_branch.branch_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as tab_kelompok_cr
				from mfi_branch
				union all
				select
				mfi_branch.branch_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_branch
				) as foo
				group by branch_name
		";
		$query = $this->db->query($sql,array($from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date));
		return $query->result_array();
	}

	public function get_data_rekap_transaksi_rembug_by_cabang($cabang,$from_date,$thru_date)
	{
		$sql = "
				select branch_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_branch.branch_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.branch_id = mfi_branch.branch_id) as tab_kelompok_cr
				from mfi_branch
				where mfi_branch.branch_code = ?
				union all
				select
				mfi_branch.branch_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm,mfi_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm,mfi_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_cm.branch_id = mfi_branch.branch_id and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_branch
				where mfi_branch.branch_code = ?
				) as foo
				group by branch_name
		";
		$query = $this->db->query($sql,array($cabang,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$cabang));
		return $query->result_array();
	}

	public function get_data_rekap_transaksi_rembug_by_rembug_semua_cabang($from_date,$thru_date)
	{
		$sql = "
				select cm_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_cm.cm_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as tab_kelompok_cr
				from mfi_cm
				union all
				select
				mfi_cm.cm_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_cm
				) as foo
				group by cm_name
		";
		$query = $this->db->query($sql,array($from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date));
		return $query->result_array();
	}

	public function get_data_rekap_transaksi_rembug_by_rembug_cabang($cabang,$from_date,$thru_date)
	{
		$sql = "
				select cm_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_cm.cm_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.cm_code = mfi_cm.cm_code) as tab_kelompok_cr
				from mfi_cm,mfi_branch
				where mfi_cm.branch_id = mfi_branch.branch_id and mfi_branch.branch_code = ?
				union all
				select
				mfi_cm.cm_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm where mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_cm.cm_code = mfi_trx_cm.cm_code and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_cm,mfi_branch
				where mfi_cm.branch_id = mfi_branch.branch_id and mfi_branch.branch_code = ?
				) as foo
				group by cm_name
		";
		$query = $this->db->query($sql,array($cabang,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$cabang));
		return $query->result_array();
	}

	public function get_data_rekap_transaksi_rembug_by_petugas_semua_cabang($from_date,$thru_date)
	{
		$sql = "
				select fa_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_fa.fa_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as tab_kelompok_cr
				from mfi_fa,mfi_gl_account_cash
				where mfi_fa.fa_code = mfi_gl_account_cash.fa_code and mfi_gl_account_cash.account_cash_type=0
				union all
				select
				mfi_fa.fa_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_fa,mfi_gl_account_cash
				where mfi_fa.fa_code = mfi_gl_account_cash.fa_code and mfi_gl_account_cash.account_cash_type=0
				) as foo
				group by fa_name
		";
		$query = $this->db->query($sql,array($from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date));
		return $query->result_array();
	}

	public function get_data_rekap_transaksi_rembug_by_petugas_cabang($cabang,$from_date,$thru_date)
	{
		$sql = "
				
				select fa_name,sum(angsuran_pokok) as angsuran_pokok,sum(angsuran_margin)as angsuran_margin,sum(angsuran_catab) as angsuran_catab, sum(tab_wajib_cr) as tab_wajib_cr, sum(tab_sukarela_db) as tab_sukarela_db, sum(droping) as droping, sum(tab_kelompok_cr) as tab_kelompok_cr from (
				select
				mfi_fa.fa_name
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_pokok
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_margin else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_margin
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_catab else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as angsuran_catab
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_wajib else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as tab_wajib_cr
				,(select sum(mfi_trx_cm_save_detail.penarikan_tab_sukarela) from mfi_trx_cm_save,mfi_trx_cm_save_detail where mfi_trx_cm_save.trx_cm_save_id = mfi_trx_cm_save_detail.trx_cm_save_id) as tab_sukarela_db
				,(select (select sum((case when mfi_account_financing_droping.status_droping = 0 and mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then mfi_account_financing.pokok else 0 end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as droping
				,(select (select sum((case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing_droping.status_droping = 1 then mfi_trx_cm_save_detail.frekuensi * mfi_account_financing.angsuran_tab_kelompok else 0 end) end)) from mfi_trx_cm_save_detail,mfi_account_financing,mfi_account_financing_droping where mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date and mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no and mfi_trx_cm_save_detail.cif_no = mfi_account_financing.cif_no and mfi_account_financing.status_rekening = 1 and mfi_trx_cm_save_detail.trx_cm_save_id=mfi_trx_cm_save.trx_cm_save_id) from mfi_trx_cm_save where mfi_trx_cm_save.fa_code = mfi_fa.fa_code) as tab_kelompok_cr
				from mfi_fa,mfi_gl_account_cash
				where mfi_fa.fa_code = mfi_gl_account_cash.fa_code and mfi_gl_account_cash.account_cash_type=0
				and mfi_fa.branch_code = ?
				union all
				select
				mfi_fa.fa_name
				,(select sum(mfi_trx_cm.angsuran_pokok) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_pokok
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_margin) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_margin
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.angsuran_catab) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as angsuran_catab
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_wajib_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id=mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_wajib_cr
				,(select sum(mfi_trx_cm.tab_sukarela_db) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_sukarela_db
				,(select sum(mfi_trx_cm.droping) from mfi_trx_cm where mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as droping
				,(select sum(mfi_trx_cm_detail.freq*mfi_trx_cm_detail.tab_kelompok_cr) from mfi_trx_cm_detail,mfi_trx_cm where mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id and mfi_trx_cm.fa_code = mfi_fa.fa_code and mfi_trx_cm.trx_date between ? and ?) as tab_kelompok_cr
				from mfi_fa,mfi_gl_account_cash
				where mfi_fa.fa_code = mfi_gl_account_cash.fa_code and mfi_gl_account_cash.account_cash_type=0
				and mfi_fa.branch_code = ?
				) as foo
				group by fa_name
		";
		$query = $this->db->query($sql,array($cabang,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$from_date,$thru_date,$cabang));
		return $query->result_array();
	}

	public function cetak_akad_pembiayaan_get_institution()
	{
		$sql = "SELECT * FROM mfi_institution ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function cetak_akad_pembiayaan_data($account_financing_id="")
	{
		$sql = "SELECT
						 mfi_account_financing.account_financing_id
						,mfi_account_financing.cif_no
						,mfi_account_financing.account_financing_no
						,mfi_account_financing.pokok
						,mfi_account_financing.margin
						,mfi_cif.nama
						,mfi_cif.alamat
						,mfi_cif.pekerjaan
						,mfi_cif.no_ktp
						,mfi_account_financing.jangka_waktu
						,mfi_account_financing.periode_jangka_waktu
						,mfi_product_financing.product_name
						,mfi_product_financing.product_code
						,mfi_account_financing.angsuran_pokok
						,mfi_account_financing.angsuran_margin
						,mfi_account_financing.angsuran_catab
						,mfi_account_financing.tanggal_mulai_angsur
						,mfi_account_financing.tanggal_jtempo
						,mfi_account_financing.biaya_administrasi
					FROM
						mfi_account_financing
					INNER JOIN mfi_cif ON mfi_account_financing.cif_no = mfi_cif.cif_no
					INNER JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
					WHERE mfi_account_financing.account_financing_id = ?
						";
		$query = $this->db->query($sql,array($account_financing_id));
		return $query->row_array();
	}



	/*
	| QUERY FOR LABA RUGI REPORT
	| SAYYID NURKILAH
	*/
	public function export_lap_laba_rugi($branch_code,$from_date,$last_date)
	{
		$param = array();
		$report_code='20';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1         
			              else  
			                fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)         
			              end  
			        END AS saldo_mutasi
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";
			
		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = 'all';
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = 'all';

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = $branch_code;
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = $branch_code;

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

			/* saldo mutasi */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes2=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount2=array();
				for($j=0;$j<count($item_codes2);$j++){
					$arr_amount2[$item_codes2[$j]]=$this->get_amount_mutasi_from_item_code($item_codes2[$j],$from_date,$last_date,$branch_code,$report_code);
				}
				$formula2=$rows[$i]['formula'];
				foreach($arr_amount2 as $key2=>$value2):
				$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
				endforeach;
				if($formula2!=""){
					$sqlsal2="select ($formula2) as saldo";
					$quesal2=$this->db->query($sqlsal2);
					$rowsal2=$quesal2->row_array();
					$saldo_mutasi=$rowsal2['saldo'];
				}else{
					$saldo_mutasi=0;
				}
			}else{
				$saldo_mutasi=$rows[$i]['saldo_mutasi'];
			}
			$row[$i]['saldo_mutasi'] = $saldo_mutasi;
		}
		return $row;
	}

	function export_keuangan_labarugi_bulanan($branch_code,$last_date,$report_code,$bulan){
		$param = array(); 
		if($branch_code=="00000"){

			$sql = "SELECT
			a.report_code,
			a.item_code,
			a.item_type,
			a.posisi,
			a.display_saldo,
			a.formula,
			a.formula_text_bold,
			CASE
	            WHEN a.posisi = 0 THEN '<b>'||a.item_name||'</b>'
	            WHEN a.posisi = 1 THEN ('  '||a.item_name::text)::character varying
	            WHEN a.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text ||a.item_name::text)::character varying
	            WHEN a.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || a.item_name::text)::character varying
	            ELSE a.item_name
	        END AS item_name,

	         (select CASE WHEN a.display_saldo = 1 THEN coalesce(sum(c.saldo_awal*-1),0) ELSE coalesce(sum(c.saldo_awal),0)  END 
			 from mfi_closing_ledger_data c, mfi_gl_report_item_member b 
			 where c.account_code = b.account_code and b.gl_report_item_id=a.gl_report_item_id 
			 and c.closing_thru_date =? and c.flag_akhir_tahun = 'T' 
			 ) saldo, 

			 (select CASE WHEN a.display_saldo = 1 THEN coalesce(sum((c.total_mutasi_debet-c.total_mutasi_credit) *-1),0) ELSE coalesce(sum((c.total_mutasi_debet-c.total_mutasi_credit)),0)  END 
			 from mfi_closing_ledger_data c, mfi_gl_report_item_member b 
			 where c.account_code = b.account_code and b.gl_report_item_id=a.gl_report_item_id 
			 and c.closing_thru_date =? and c.flag_akhir_tahun = 'T' 
			 ) saldo_mutasi  

			FROM mfi_gl_report_item a 
			
			WHERE  a.report_code = ? ";

			$sql .= " ORDER BY 1,2";
			
			$param[] = $last_date; 
			$param[] = $last_date;
			/* param report group */
			$param[] = $report_code;
		}else{

			$sql = "SELECT
			a.report_code,
			a.item_code,
			a.item_type,
			a.posisi,
			a.display_saldo,
			a.formula,
			a.formula_text_bold,
			CASE
	            WHEN a.posisi = 0 THEN '<b>'||a.item_name||'</b>'
	            WHEN a.posisi = 1 THEN ('  '||a.item_name::TEXT)::character varying
	            WHEN a.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::TEXT ||a.item_name::TEXT)::character varying
	            WHEN a.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::TEXT || a.item_name::TEXT)::character varying
	            ELSE a.item_name
	        END AS item_name, 

	        (select CASE WHEN a.display_saldo = 1 THEN coalesce(sum(c.saldo_awal*-1),0) ELSE coalesce(sum(c.saldo_awal),0)  END 
			 from mfi_closing_ledger_data c, mfi_gl_report_item_member b 
			 where c.account_code = b.account_code and b.gl_report_item_id=a.gl_report_item_id 
			 and c.closing_thru_date =? and c.flag_akhir_tahun = 'T' 
			 and c.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk =?) ) saldo,  

			 (select CASE WHEN a.display_saldo = 1 THEN coalesce(sum((c.total_mutasi_debet-c.total_mutasi_credit)*-1),0) ELSE coalesce(sum(c.total_mutasi_debet-c.total_mutasi_credit),0)  END 
			 from mfi_closing_ledger_data c, mfi_gl_report_item_member b 
			 where c.account_code = b.account_code and b.gl_report_item_id=a.gl_report_item_id 
			 and c.closing_thru_date =? and c.flag_akhir_tahun = 'T' 
			 and c.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk =?) ) saldo_mutasi   

			FROM mfi_gl_report_item a 
			
			WHERE  a.report_code = ? ";

			$sql .= " ORDER BY 1,2 ";

			$param[] = $last_date;
			$param[] = $branch_code; 
			$param[] = $last_date;
			$param[] = $branch_code;
			/* param report group */
			$param[] = $report_code;
		}	

		$query = $this->db->query($sql,$param);
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_bulanan($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

			/* saldo mutasi */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes2=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount2=array();
				for($j=0;$j<count($item_codes2);$j++){
					$arr_amount2[$item_codes2[$j]]=$this->get_amount_mutasi_from_item_code($item_codes2[$j],$from_date,$last_date,$branch_code,$report_code);
				}
				$formula2=$rows[$i]['formula'];
				foreach($arr_amount2 as $key2=>$value2):
				$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
				endforeach;
				if($formula2!=""){
					$sqlsal2="select ($formula2) as saldo";
					$quesal2=$this->db->query($sqlsal2);
					$rowsal2=$quesal2->row_array();
					$saldo_mutasi=$rowsal2['saldo'];
				}else{
					$saldo_mutasi=0;
				}
			}else{
				$saldo_mutasi=$rows[$i]['saldo_mutasi'];
			}
			$row[$i]['saldo_mutasi'] = $saldo_mutasi;
		}
		return $row;
	}

	/**
	*Laporan Trial Balance
	*/

	function export_keuangan_trial_balance($branch_code,$from_date,$last_date){
		$param = array();

		if($branch_code=="00000")
		{
			$sql = "SELECT a.account_code, b.account_name, 
					sum(a.saldo_awal) saldo_awal,
					sum(a.total_mutasi_debet) total_mutasi_debet,
					sum(a.total_mutasi_credit) total_mutasi_credit,
					sum(a.saldo) saldo
					FROM mfi_closing_ledger_data a
					LEFT OUTER JOIN mfi_gl_account b 
					on a.account_code = b.account_code
					WHERE a.closing_thru_date = '$last_date'
					GROUP BY 1,2
					ORDER BY 1,2";			
		} else
		{
			$sql = "SELECT a.account_code, b.account_name,
					sum(a.saldo_awal) saldo_awal,
					sum(a.total_mutasi_debet) total_mutasi_debet,
					sum(a.total_mutasi_credit) total_mutasi_credit,
					sum(a.saldo) saldo
					FROM mfi_closing_ledger_data a
					LEFT OUTER JOIN mfi_gl_account b
					on a.account_code = b.account_code
					WHERE a.closing_thru_date = '$last_date'
					AND a.branch_code
					IN (SELECT branch_code FROM mfi_branch_member WHERE branch_code = '$branch_code')
					GROUP BY 1,2
					ORDER BY 1,2";
		}

			
		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = 'all';
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = 'all';

		}else{
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = $branch_code;
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	/**
	* LAPORAN PAR TERHITUNG
	*/
	public function get_laporan_par_terhitung($date,$branch_code,$kol='all')
	{
		// $flag_all_branch=$this->session->userdata('flag_all_branch');

		$sql = "SELECT
		b.account_financing_no,
		d.nama,
		b.pokok,
		b.margin,
		b.jangka_waktu,
		b.tanggal_mulai_angsur,
		b.saldo_pokok,
		b.saldo_margin,
		c.droping_date,
		b.angsuran_pokok,
		b.angsuran_margin,
		CAST((b.pokok - a.saldo_pokok) / b.angsuran_pokok AS INTEGER) AS terbayar,
		(((? - b.tanggal_mulai_angsur) / 7) + 1) AS seharusnya,
		a.saldo_pokok,
		a.saldo_margin,
		a.hari_nunggak,
		a.freq_tunggakan,
		a.tunggakan_pokok,
		a.tunggakan_margin,
		a.par_desc,
		a.par,
		a.cadangan_piutang,
		e.cm_name
		FROM mfi_par a
		LEFT JOIN mfi_account_financing b
		ON b.account_financing_no = a.account_financing_no
		LEFT JOIN mfi_account_financing_droping c
		ON c.account_financing_no = a.account_financing_no
		LEFT JOIN mfi_cif d ON d.cif_no = b.cif_no
		LEFT JOIN mfi_cm e ON e.cm_code = d.cm_code
		WHERE a.tanggal_hitung = ?";

		$param[] = $date;
		$param[] = $date;

		if($branch_code!="00000"){
			$sql .= " AND a.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		if($kol!="all"){
			$sql .= " AND a.par_desc = ?";
			$param[] = $kol;
		}

		$sql .= " ORDER BY par, e.cm_name, d.nama ASC";
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_rekapitulasi_npl2($branch_code,$fa_code,$cm_code,$tanggal_hitung)
	{
		$param=array();
		$sql = "select
				fa.fa_code,
				fa.fa_name,

				fn_get_par_jml_by_fa(fa.fa_code,'0',?,?) jml0,
				fn_get_par_saldo_pokok_by_fa(fa.fa_code,'0',?,?) saldo_pokok0,
				fn_get_par_cpp_by_fa(fa.fa_code,'0',?,?) cpp0,

				fn_get_par_jml_by_fa(fa.fa_code,'1 - 30',?,?) jml1,
				fn_get_par_saldo_pokok_by_fa(fa.fa_code,'1 - 30',?,?) saldo_pokok1,
				fn_get_par_cpp_by_fa(fa.fa_code,'1 - 30',?,?) cpp1,

				fn_get_par_jml_by_fa(fa.fa_code,'31 - 60',?,?) jml2,
				fn_get_par_saldo_pokok_by_fa(fa.fa_code,'31 - 60',?,?) saldo_pokok2,
				fn_get_par_cpp_by_fa(fa.fa_code,'31 - 60',?,?) cpp2,

				fn_get_par_jml_by_fa(fa.fa_code,'61 - 90',?,?) jml3,
				fn_get_par_saldo_pokok_by_fa(fa.fa_code,'61 - 90',?,?) saldo_pokok3,
				fn_get_par_cpp_by_fa(fa.fa_code,'61 - 90',?,?) cpp3,

				fn_get_par_jml_by_fa(fa.fa_code,'91 - 120',?,?) jml4,
				fn_get_par_saldo_pokok_by_fa(fa.fa_code,'91 - 120',?,?) saldo_pokok4,
				fn_get_par_cpp_by_fa(fa.fa_code,'91 - 120',?,?) cpp4,

				fn_get_par_jml_by_fa(fa.fa_code,'> 120',?,?) jml5,
				fn_get_par_saldo_pokok_by_fa(fa.fa_code,'> 120',?,?) saldo_pokok5,
				fn_get_par_cpp_by_fa(fa.fa_code,'> 120',?,?) cpp5
				from mfi_fa fa, mfi_cm cm
				where fa.fa_code=cm.fa_code
		";
		
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		$param[]=$cm_code;
		$param[]=$tanggal_hitung;
		
		
		if($branch_code!="00000"){
			$sql.=" and fa.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[]=$branch_code;
		}

		if($fa_code!='all'){
			$sql.=" and fa.fa_code=?";
			$param[]=$fa_code;
		}

		$sql .= "
				group by 1,2
				order by fa_code asc";
		$query=$this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function export_rekapitulasi_npl_by_produk($cabang,$tanggal_hitung)
	{
		$param=array();
		$sql = "SELECT
				a.product_name,";
					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan=0 
						and par_desc='0' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml0,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan=0 
						and par_desc='0' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok0,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan=0 
						and par_desc='0' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp0, ";

					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='1 - 30' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml1,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='1 - 30' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok1,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='1 - 30' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp1, ";

					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='31 - 60' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml2,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='31 - 60' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok2,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='31 - 60' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp2, ";
					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='61 - 90' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml3,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='61 - 90' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok3,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='61 - 90' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp3, ";
					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='91 - 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml4,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='91 - 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok4,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='91 - 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp4, ";
					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='> 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml5,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='> 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok5,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='> 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.product_code::varchar=a.product_code::varchar ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp5 ";

		$sql.=" from mfi_product_financing a ";
		$query = $this->db->query($sql,$param);
		
		return $query->result_array();
	}

	public function export_rekapitulasi_npl_by_peruntukan($cabang,$tanggal_hitung)
	{
		$param=array();
		$sql = "SELECT
				a.display_text,";
					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan=0 
						and par_desc='0' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml0,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan=0 
						and par_desc='0' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok0,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan=0 
						and par_desc='0' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp0, ";


					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='1 - 30' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml1,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='1 - 30' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok1,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='1 - 30' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp1, ";

					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='31 - 60' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml2,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='31 - 60' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok2,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='31 - 60' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp2, ";

					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='61 - 90' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml3,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='61 - 90' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok3,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='61 - 90' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp3, ";

					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='91 - 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml4,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='91 - 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok4,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='91 - 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp4, ";

					$sql.="
					(select count(mfi_par.*) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='> 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}						 
					$sql.="
					) as jml5,
					(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='> 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as saldo_pokok5,
					(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1
						where mfi_par.freq_tunggakan>0 
						and par_desc='> 120' 
						and mfi_par.tanggal_hitung=?
						and mfi_par.account_financing_no= a1.account_financing_no
						and a1.peruntukan::integer=a.code_value::integer ";
					$param[] = $tanggal_hitung;
						if($cabang!="00000"){
							$sql .= " AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
							$param[] = $cabang;
						}	
					$sql.="
					)as cpp5 ";

		$sql.=" from mfi_list_code_detail a WHERE a.code_group='peruntukan' ";
		$query = $this->db->query($sql,$param);
		
		return $query->result_array();
	}

	public function export_rekapitulasi_npl_by_rembug($cabang,$tanggal_hitung)
	{
		$param=array();
		$sql = "SELECT
					b.branch_name,
					a.cm_name,
						(select count(mfi_par.*) from mfi_par, mfi_account_financing a1, mfi_cif a2
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='1 - 30' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						) as jml1,
						(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1, mfi_cif a2
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='1 - 30' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as saldo_pokok1,
						(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1, mfi_cif a2 
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='1 - 30' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as cpp1,
						(select count(mfi_par.*) from mfi_par, mfi_account_financing a1, mfi_cif a2
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='31 - 60' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as jml2,
						(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1, mfi_cif a2
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='31 - 60' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as saldo_pokok2,
						(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1, mfi_cif a2 
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='31 - 60' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as cpp2,
						(select count(mfi_par.*) from mfi_par, mfi_account_financing a1, mfi_cif a2
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='61 - 90'
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as jml3,
						(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1, mfi_cif a2
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='61 - 90'
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as saldo_pokok3,
						(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1, mfi_cif a2 
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='61 - 90'
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as cpp3,
						(select count(mfi_par.*) from mfi_par, mfi_account_financing a1, mfi_cif a2
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='91 - 120'
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as jml4,
						(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1, mfi_cif a2
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='91 - 120'
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as saldo_pokok4,
						(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1, mfi_cif a2 
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='91 - 120'
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as cpp4,
						(select count(mfi_par.*) from mfi_par, mfi_account_financing a1, mfi_cif a2
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='> 120'
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as jml5,
						(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1, mfi_cif a2
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='> 120'
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as saldo_pokok5,
						(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1, mfi_cif a2 
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=b.branch_code 
							and par_desc='> 120'
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a.cm_code
						)as cpp5

					from mfi_cm a
					INNER JOIN mfi_branch b ON a.branch_id=b.branch_id
					WHERE a.cm_code is not null
				";
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		if($cabang!="00000"){
			$sql .= "and b.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?)";
			$param[] = $cabang;
		}
		$sql .=	"order by 1,2 ";
		$query = $this->db->query($sql,$param);
		
		return $query->result_array();
	}

	public function export_rekapitulasi_npl_by_petugas($cabang,$cm_code,$tanggal_hitung)
	{
		$param=array();
		$sql = "SELECT
					b.branch_name,
					c.cm_name,
					a.fa_name,
					a.fa_code,
						(select count(mfi_par.*) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3 
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='1 - 30' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						) as jml1,
						(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3 
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='1 - 30' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						)as saldo_pokok1,
						(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='1 - 30' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						)as cpp1,
						(select count(mfi_par.*) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='31 - 60' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						) as jml2,
						(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='31 - 60' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						)as saldo_pokok2,
						(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='31 - 60' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						)as cpp2,
						(select count(mfi_par.*) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='61 - 90' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						) as jml3,
						(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='61 - 90' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						)as saldo_pokok3,
						(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='61 - 90' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						)as cpp3,
						(select count(mfi_par.*) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='91 - 120' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						) as jml4,
						(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='91 - 120' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						)as saldo_pokok4,
						(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='91 - 120' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						)as cpp4,
						(select count(mfi_par.*) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='> 120' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						) as jml5,
						(select sum(mfi_par.saldo_pokok) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='> 120' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						)as saldo_pokok5,
						(select sum(mfi_par.cadangan_piutang) from mfi_par, mfi_account_financing a1, mfi_cif a2, mfi_cm a3  
							where mfi_par.freq_tunggakan>0 
							AND mfi_par.branch_code=a.branch_code 
							and par_desc='> 120' 
							and mfi_par.tanggal_hitung=?
							and mfi_par.account_financing_no= a1.account_financing_no
							AND a1.cif_no=a2.cif_no 
							AND a2.cm_code=a3.cm_code 
							AND a3.fa_code=a.fa_code
							AND a3.cm_code=c.cm_code
						)as cpp5

					from mfi_fa a
					INNER JOIN mfi_cm c ON a.fa_code=c.fa_code
					INNER JOIN mfi_branch b ON a.branch_code=b.branch_code
					WHERE a.fa_code is not null
				";
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		if($cabang!="00000"){
			$sql .= "and a.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?)";
			$param[] = $cabang;
		}
		if($cm_code!="all"){
			$sql .= "and c.cm_code=? ";
			$param[] = $cm_code;
		}
		$sql .=	"order by 1,2,3 ";
		$query = $this->db->query($sql,$param);
		
		return $query->result_array();
	}

	public function export_rekapitulasi_npl($cabang,$tanggal_hitung)
	{
		$param=array();
		$sql = "select
				a.branch_code,
				a.branch_name,
				a.branch_class,
				
				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan=0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='0' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan=0 AND mfi_par.branch_code=a.branch_code and par_desc='0' and mfi_par.tanggal_hitung='2018-04-06')
				end) as jml0,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan=0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='0' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan=0 AND mfi_par.branch_code=a.branch_code and par_desc='0' and mfi_par.tanggal_hitung='2018-04-06')
				end) as saldo_pokok0,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan=0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='0' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan=0 AND mfi_par.branch_code=a.branch_code and par_desc='0' and mfi_par.tanggal_hitung='2018-04-06') 
				end) as cpp0,
				
				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='1 - 30' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='1 - 30' and mfi_par.tanggal_hitung='2018-04-06')
				end) as jml1,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='1 - 30' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='1 - 30' and mfi_par.tanggal_hitung='2018-04-06')
				end) as saldo_pokok1,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='1 - 30' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='1 - 30' and mfi_par.tanggal_hitung='2018-04-06') 
				end) as cpp1,

				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='31 - 60' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='31 - 60' and mfi_par.tanggal_hitung='2018-04-06')
				end) as jml2,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='31 - 60' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='31 - 60' and mfi_par.tanggal_hitung='2018-04-06')
				end) as saldo_pokok2,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='31 - 60' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='31 - 60' and mfi_par.tanggal_hitung='2018-04-06') 
				end) as cpp2,

				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='61 - 90' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='61 - 90' and mfi_par.tanggal_hitung='2018-04-06')
				end) as jml3,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='61 - 90' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='61 - 90' and mfi_par.tanggal_hitung='2018-04-06')
				end) as saldo_pokok3,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='61 - 90' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='61 - 90' and mfi_par.tanggal_hitung='2018-04-06') 
				end) as cpp3,

				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='91 - 120' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='91 - 120' and mfi_par.tanggal_hitung='2018-04-06')
				end) as jml4,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='91 - 120' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='91 - 120' and mfi_par.tanggal_hitung='2018-04-06')
				end) as saldo_pokok4,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='91 - 120' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='91 - 120' and mfi_par.tanggal_hitung='2018-04-06') 
				end) as cpp4,

				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='> 120' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='> 120' and mfi_par.tanggal_hitung='2018-04-06')
				end) as jml5,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='> 120' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='> 120' and mfi_par.tanggal_hitung='2018-04-06')
				end) as saldo_pokok5,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='> 120' and mfi_par.tanggal_hitung='2018-04-06')
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='> 120' and mfi_par.tanggal_hitung='2018-04-06') 
				end) as cpp5
				from mfi_branch a
				where a.branch_class <> 0 and a.branch_class <> 1
				";
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		$param[] = $tanggal_hitung;
		if($cabang!="00000"){
			$sql .= "and a.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?)";
			$param[] = $cabang;
		}
		$sql .=	"group by a.branch_code,a.branch_name,a.branch_class
				order by a.branch_code,a.branch_name asc;
				";
		$query = $this->db->query($sql,$param);
		
		return $query->result_array();
	}

	public function export_rekapitulasi_kol($cabang='',$kol='',$tanggal_hitung='')
	{
		if ($tanggal_hitung=='') {
			$sqltanggal_hitung = "select tanggal_hitung from mfi_par order by tanggal_hitung desc limit 1";
			$qrytanggal_hitung = $this->db->query($sqltanggal_hitung);
			$rowtanggal_hitung = $qrytanggal_hitung->row_array();
			$tanggal_hitung = $rowtanggal_hitung['tanggal_hitung'];
		}

		$param=array();
		$sql = "SELECT
		'0' jumlah_hari_1
		,'PINJAMAN LANCAR' par_desc ";
		if ($cabang!="00000") {
			$sql.=" ,(select count(*) from mfi_par where par_desc='0' and tanggal_hitung=? and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) jumlah ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;

			$sql.=" ,(select count(distinct z.cif_no) from mfi_par x, mfi_account_financing y, mfi_cif z  where 
					 x.account_financing_no=y.account_financing_no and y.cif_no=z.cif_no and 
					 x.par_desc='0' and x.tanggal_hitung=? and x.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) anggota ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;

		} else {
			$sql.=" ,(select count(*) from mfi_par where par_desc='0' and tanggal_hitung=?) jumlah ";
			$param[] = $tanggal_hitung; 


			$sql.=" ,(select count(distinct z.cif_no) from mfi_par x, mfi_account_financing y, mfi_cif z  where 
					 x.account_financing_no=y.account_financing_no and y.cif_no=z.cif_no and 
					 x.par_desc='0' and x.tanggal_hitung=? ) anggota ";
			$param[] = $tanggal_hitung;
		}
		$sql.=",'0' cpp
		,'0' cadangan_piutang";
		
		if ($cabang!="00000") {
			$sql.=" ,(select sum(saldo_pokok) from mfi_par where par_desc='0' and tanggal_hitung=? and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) saldo_pokok ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;
		} else {
			$sql.=" ,(select sum(saldo_pokok) from mfi_par where par_desc='0' and tanggal_hitung=?) saldo_pokok ";
			$param[] = $tanggal_hitung;
		}

		$sql.=" UNION ALL ";
		$sql .= "SELECT 
		a.jumlah_hari_1
		,('TERTUNGGAK '||a.par_desc||' HARI') par_desc
		";
		if($cabang!="00000"){
			$sql .= ",(select count(*) from mfi_par b where b.par_desc=a.par_desc AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) and tanggal_hitung=? ) jumlah ";
			$param[] = $cabang;
			$param[] = $tanggal_hitung;


			$sql.=" ,(select count(distinct z.cif_no) from mfi_par x, mfi_account_financing y, mfi_cif z  where 
					 x.account_financing_no=y.account_financing_no and y.cif_no=z.cif_no and 
					 x.par_desc=a.par_desc and x.tanggal_hitung=? and x.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) anggota ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;

		}else{
			$sql .= ",(select count(*) from mfi_par b where b.par_desc=a.par_desc and tanggal_hitung=? ) jumlah ";
			$param[] = $tanggal_hitung;


			$sql.=" ,(select count(distinct z.cif_no) from mfi_par x, mfi_account_financing y, mfi_cif z  where 
					 x.account_financing_no=y.account_financing_no and y.cif_no=z.cif_no and 
					 x.par_desc=a.par_desc and x.tanggal_hitung=? ) anggota ";
			$param[] = $tanggal_hitung;

		}
		$sql .=	" ,a.cpp ";
		if($cabang!="00000"){
			$sql .= ",(select coalesce(sum(cadangan_piutang),0) from mfi_par c where c.par_desc=a.par_desc AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) and tanggal_hitung=? ) cadangan_piutang ";
			$param[] = $cabang;
			$param[] = $tanggal_hitung;
		}else{
			$sql .= ",(select coalesce(sum(cadangan_piutang),0) from mfi_par c where c.par_desc=a.par_desc and tanggal_hitung=? ) cadangan_piutang ";
			$param[] = $tanggal_hitung;
		}
		if($cabang!="00000"){
			$sql .= ",(select coalesce(sum(saldo_pokok),0) from mfi_par c where c.par_desc=a.par_desc AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) and tanggal_hitung=? ) saldo_pokok ";
			$param[] = $cabang;
			$param[] = $tanggal_hitung;
		}else{
			$sql .= ",(select coalesce(sum(saldo_pokok),0) from mfi_par c where c.par_desc=a.par_desc and tanggal_hitung=? ) saldo_pokok ";
			$param[] = $tanggal_hitung;
		}
		$sql .=	" FROM mfi_param_par a ";

		if($kol!="all"){
			$sql .= " WHERE a.par_desc=? ";
			$param[] = str_replace('%20', ' ', $kol);
		}
		$sql .=	" order by 1 asc ";
		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();		
		return $query->result_array();
	}

	function export_rekapitulasi_kol2($cabang='',$kol='',$tanggal_hitung=''){
		if ($tanggal_hitung=='') {
			$sqltanggal_hitung = "select tanggal_hitung from mfi_par order by tanggal_hitung desc limit 1";
			$qrytanggal_hitung = $this->db->query($sqltanggal_hitung);
			$rowtanggal_hitung = $qrytanggal_hitung->row_array();
			$tanggal_hitung = $rowtanggal_hitung['tanggal_hitung'];
		}

		$param=array();
		$sql = "SELECT
		'0' jumlah_hari_1
		,'PINJAMAN LANCAR' par_desc ";
		if ($cabang!="00000") {
			$sql.=" ,(select count(*) from mfi_par where par_desc='0' and tanggal_hitung=? and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) jumlah ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;
		} else {
			$sql.=" ,(select count(*) from mfi_par where par_desc='0' and tanggal_hitung=?) jumlah ";
			$param[] = $tanggal_hitung;
		}
		$sql.=",'0' cpp
		,'0' cadangan_piutang";
		
		if ($cabang!="00000") {
			$sql.=" ,(select sum(saldo_pokok) from mfi_par where par_desc='0' and tanggal_hitung=? and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) saldo_pokok ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;
			$sql.=",(select sum(a.pokok) from mfi_account_financing a, mfi_par b where a.account_financing_no = b.account_financing_no and b.tanggal_hitung = ? and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) pokok ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;
			$sql.=",(select sum(a.margin) from mfi_account_financing a, mfi_par b where a.account_financing_no = b.account_financing_no and b.tanggal_hitung = ? and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) margin ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;
			$sql.=",(select sum(saldo_margin) from mfi_par where par_desc='0' and tanggal_hitung=? and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) saldo_margin ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;
			$sql.=",(select sum(tunggakan_pokok) from mfi_par where par_desc='0' and tanggal_hitung=? and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) tunggakan_pokok ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;
			$sql.=",(select sum(tunggakan_margin) from mfi_par where par_desc='0' and tanggal_hitung=? and branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) tunggakan_margin ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;
		} else {
			$sql.=" ,(select sum(saldo_pokok) from mfi_par where par_desc='0' and tanggal_hitung=?) saldo_pokok ";
			$param[] = $tanggal_hitung;
			$sql.=",(select sum(a.pokok) from mfi_account_financing a, mfi_par b where a.account_financing_no = b.account_financing_no and b.tanggal_hitung = ?) pokok ";
			$param[] = $tanggal_hitung;
			$sql.=",(select sum(a.margin) from mfi_account_financing a, mfi_par b where a.account_financing_no = b.account_financing_no and b.tanggal_hitung = ?) margin ";
			$param[] = $tanggal_hitung;
			$sql.=",(select sum(saldo_margin) from mfi_par where par_desc='0' and tanggal_hitung=?) saldo_margin ";
			$param[] = $tanggal_hitung;
			$sql.=",(select sum(tunggakan_pokok) from mfi_par where par_desc='0' and tanggal_hitung=?) tunggakan_pokok ";
			$param[] = $tanggal_hitung;
			$sql.=",(select sum(tunggakan_margin) from mfi_par where par_desc='0' and tanggal_hitung=?) tunggakan_margin ";
			$param[] = $tanggal_hitung;
		}

		$sql.=" UNION ALL ";
		$sql .= "SELECT 
		a.jumlah_hari_1
		,('TERTUNGGAK '||a.par_desc||' HARI') par_desc
		";
		if($cabang!="00000"){
			$sql .= ",(select count(*) from mfi_par b where b.par_desc=a.par_desc AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) and tanggal_hitung=? ) jumlah ";
			$param[] = $cabang;
			$param[] = $tanggal_hitung;
		}else{
			$sql .= ",(select count(*) from mfi_par b where b.par_desc=a.par_desc and tanggal_hitung=? ) jumlah ";
			$param[] = $tanggal_hitung;
		}
		$sql .=	" ,a.cpp ";
		if($cabang!="00000"){
			$sql .= ",(select coalesce(sum(cadangan_piutang),0) from mfi_par c where c.par_desc=a.par_desc AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) and tanggal_hitung=? ) cadangan_piutang ";
			$param[] = $cabang;
			$param[] = $tanggal_hitung;
		}else{
			$sql .= ",(select coalesce(sum(cadangan_piutang),0) from mfi_par c where c.par_desc=a.par_desc and tanggal_hitung=? ) cadangan_piutang ";
			$param[] = $tanggal_hitung;
		}
		if($cabang!="00000"){
			$sql .= ",(select coalesce(sum(saldo_pokok),0) from mfi_par c where c.par_desc=a.par_desc AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) and tanggal_hitung=? ) saldo_pokok ";
			$param[] = $cabang;
			$param[] = $tanggal_hitung;
			$sql.=",(select coalesce(sum(c.pokok),0) from mfi_account_financing c, mfi_par b where c.account_financing_no = b.account_financing_no and b.par_desc = a.par_desc and b.tanggal_hitung = ? and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) pokok ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;
			$sql.=",(select coalesce(sum(c.margin),0) from mfi_account_financing c, mfi_par b where c.account_financing_no = b.account_financing_no and b.par_desc = a.par_desc and b.tanggal_hitung = ? and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)) margin ";
			$param[] = $tanggal_hitung;
			$param[] = $cabang;
			$sql.=",(select coalesce(sum(saldo_margin),0) from mfi_par c where c.par_desc=a.par_desc AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) and tanggal_hitung=? ) saldo_margin";
			$param[] = $cabang;
			$param[] = $tanggal_hitung;
			$sql.=",(select coalesce(sum(tunggakan_pokok),0) from mfi_par c where c.par_desc=a.par_desc AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) and tanggal_hitung=? ) tunggakan_pokok";
			$param[] = $cabang;
			$param[] = $tanggal_hitung;
			$sql.=",(select coalesce(sum(tunggakan_margin),0) from mfi_par c where c.par_desc=a.par_desc AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) and tanggal_hitung=? ) tunggakan_margin";
			$param[] = $cabang;
			$param[] = $tanggal_hitung;
		}else{
			$sql .= ",(select coalesce(sum(saldo_pokok),0) from mfi_par c where c.par_desc=a.par_desc and tanggal_hitung=? ) saldo_pokok ";
			$param[] = $tanggal_hitung;
			$sql.=",(select coalesce(sum(c.pokok),0) from mfi_account_financing c, mfi_par b where c.account_financing_no = b.account_financing_no and b.par_desc = a.par_desc and b.tanggal_hitung = ?) pokok ";
			$param[] = $tanggal_hitung;
			$sql.=",(select coalesce(sum(c.margin),0) from mfi_account_financing c, mfi_par b where c.account_financing_no = b.account_financing_no and b.par_desc = a.par_desc and b.tanggal_hitung = ?) margin ";
			$param[] = $tanggal_hitung;
			$sql.=",(select coalesce(sum(saldo_margin),0) from mfi_par c where c.par_desc=a.par_desc and tanggal_hitung=? ) saldo_margin";
			$param[] = $tanggal_hitung;
			$sql.=",(select coalesce(sum(tunggakan_pokok),0) from mfi_par c where c.par_desc=a.par_desc and tanggal_hitung=? ) tunggakan_pokok";
			$param[] = $tanggal_hitung;
			$sql.=",(select coalesce(sum(tunggakan_margin),0) from mfi_par c where c.par_desc=a.par_desc and tanggal_hitung=? ) tunggakan_margin";
			$param[] = $tanggal_hitung;
		}
		$sql .=	" FROM mfi_param_par a ";

		if($kol!="all"){
			$sql .= " WHERE a.par_desc=? ";
			$param[] = str_replace('%20', ' ', $kol);
		}
		$sql .=	" order by 1 asc ";

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();		
		return $query->result_array();
	}

	/*
	| GET CODES BY FORMULA
	*/
	function get_codes_by_formula($formula)
	{
		$explode=explode('$',$formula);
		$length=count($explode);
		$idx=0;
		$arr_string=array();
		for($i=0;$i<$length;$i++){
			if(trim($explode[$i])!=""){
				$arr_string[] = substr($explode[$i],0,7);
			}
		}
		return $arr_string;
	}
	/*
	| GET SALDO MUTASI BY ITEM CODES
	*/ 
	function get_amount_mutasi_from_item_code($item_code,$from_date,$last_date,$branch_code,$report_code){
		$sql = "SELECT
		(CASE WHEN mgri.item_type = 0
			THEN
				NULL::INTEGER
			ELSE
				CASE WHEN mgri.display_saldo = 1 
					THEN sum(mcld.total_mutasi_debet-mcld.total_mutasi_credit)*-1         
					ELSE sum(mcld.total_mutasi_debet-mcld.total_mutasi_credit)         
      	  		END
      	END) AS saldo
	    FROM mfi_gl_report_item AS mgri
	    LEFT JOIN mfi_gl_report_item_member AS mgrim on mgrim.gl_report_item_id = mgri.gl_report_item_id
	    LEFT JOIN mfi_closing_ledger_data AS mcld on mcld.account_code = mgrim.account_code
	    WHERE mgri.report_code = ? AND mcld.flag_akhir_tahun = 'T' ";

		$param[] = $report_code;

	    if($branch_code != '00000'){
	    	$sql .= " AND mcld.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
	    }

		$query = $this->db->query($sql,$param);
		$row = $query->row_array();

		return $row['saldo'];
	}

	function get_amount_mutasi_from_item_code_2($item_code,$from_date,$last_date,$report_code,$user_id){
		$sql = "SELECT
		(CASE WHEN item_type = 0
			THEN
				NULL::INTEGER
			ELSE
				CASE WHEN display_saldo = 1 
					THEN sum(mutasi_debit-mutasi_credit)*-1         
					ELSE sum(mutasi_debit-mutasi_credit)         
      	  		END
      	END) AS saldo
	    FROM JOIN mfi_keuangan_report
	    WHERE report_code = ? AND created_by = ?";

		$param[] = $report_code;
		$param[] = $user_id;

		$query = $this->db->query($sql,$param);
		$row = $query->row_array();

		return $row['saldo'];
	}

	function get_amount_mutasi_from_item_code_v2($item_code,$from_date,$last_date,$branch_code,$report_code)
	{
		$sql = "SELECT (CASE WHEN item_type = 0 
					THEN NULL::integer
		            ELSE 
		              case when display_saldo = 1 
		              then fn_get_saldo_mutasi_gl_account_new(gl_report_item_id,item_type, ? , ? , ?)*-1         
		              else fn_get_saldo_mutasi_gl_account_new(gl_report_item_id,item_type, ? , ? , ?)         
	              	  end
		        	END) AS saldo
		        FROM mfi_gl_report_item 
		        WHERE report_code = ?
		        AND item_code=?
        ";
		if($branch_code=="00000"){
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $report_code;
			$param[] = $item_code;
		}else{
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $report_code;
			$param[] = $item_code;
		}
		$query = $this->db->query($sql,$param);
		$row=$query->row_array();
		return $row['saldo'];
	}
	/*
	| GET SALDO BY ITEM CODES
	*/
	function get_amount_from_item_code($item_code,$last_date,$branch_code,$report_code)
	{
		$sql = "SELECT (CASE WHEN item_type = 0 
					THEN NULL::integer
		            ELSE 
		              case when display_saldo = 1 
		              then fn_get_saldo_group_glaccount3(gl_report_item_id,item_type, ? , ?)*-1         
		              else fn_get_saldo_group_glaccount3(gl_report_item_id,item_type, ? , ?)         
	              	  end
		        	END) AS saldo
		        FROM mfi_gl_report_item 
		        WHERE report_code = ?
		        AND item_code=?
        ";
		if($branch_code=="00000"){
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $report_code;
			$param[] = $item_code;
		}else{
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $report_code;
			$param[] = $item_code;
		}
		$query = $this->db->query($sql,$param);
		$row=$query->row_array();
		return $row['saldo'];
	}

	function get_amount_from_item_code_temp($item_code,$branch_code,$report_code)
	{
		$sql = "SELECT (CASE WHEN item_type = 0 
					THEN NULL::integer
		            ELSE 
		              case when display_saldo = 1 
		              then fn_get_saldo_group_glaccount_temp(gl_report_item_id,?)*-1         
		              else fn_get_saldo_group_glaccount_temp(gl_report_item_id,?)         
	              	  end
		        	END) AS saldo
		        FROM mfi_gl_report_item 
		        WHERE report_code = ?
		        AND item_code=?
        ";

		if($branch_code=="00000"){
			$param[] = 'all';
			$param[] = 'all';
			$param[] = $report_code;
			$param[] = $item_code;
		}else{
			$param[] = $branch_code;
			$param[] = $branch_code;
			$param[] = $report_code;
			$param[] = $item_code;
		}
		$query = $this->db->query($sql,$param);
		$row=$query->row_array();
		return $row['saldo'];
	}

	function get_amount_from_item_code_temp_2($item_code,$branch_code,$report_code,$user_id)
	{
		$sql = "SELECT (CASE WHEN item_type = 0 
					THEN NULL::integer
		            ELSE 
		              case when display_saldo = 1 
		              then fn_get_saldo_group_glaccount_temp(gl_report_item_id,?,?)*-1         
		              else fn_get_saldo_group_glaccount_temp(gl_report_item_id,?,?)         
	              	  end
		        	END) AS saldo
		        FROM mfi_gl_report_item 
		        WHERE report_code = ?
		        AND item_code=?
        ";

		if($branch_code=="00000"){
			$param[] = 'all';
			$param[] = $user_id;
			$param[] = 'all';
			$param[] = $user_id;
			$param[] = $report_code;
			$param[] = $item_code;
		}else{
			$param[] = $branch_code;
			$param[] = $user_id;
			$param[] = $branch_code;
			$param[] = $user_id;
			$param[] = $report_code;
			$param[] = $item_code;
		}
		$query = $this->db->query($sql,$param);
		$row=$query->row_array();
		return $row['saldo'];
	}

	function get_amount_from_item_code_bulanan($item_code,$last_date,$branch_code,$report_code)
	{
		$sql = "SELECT (CASE WHEN mgri.item_type = 0 
					THEN NULL::integer
		            ELSE 
		              case when mgri.display_saldo = 1 
		              then SUM(mcld.saldo)*-1
		              else SUM(mcld.saldo)
	              	  end
		        	END) AS saldo
		        FROM mfi_gl_report_item AS mgri
				LEFT JOIN mfi_gl_report_item_member AS mgrim ON mgrim.gl_report_item_id = mgri.gl_report_item_id
				LEFT JOIN mfi_closing_ledger_data AS mcld ON mcld.account_code = mgrim.account_code
		        WHERE mgri.report_code = ? AND mgri.item_code=? AND mcld.closing_thru_date = ? AND mcld.flag_akhir_tahun = 'T' 
        ";

		$param[] = $report_code;
		$param[] = $item_code;
		$param[] = $last_date;

		if($branch_code != '00000'){
			$sql .= "AND mcld.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		$row=$query->row_array();
		return $row['saldo'];
	}

	function get_amount_from_item_code_v2($item_code,$last_date,$branch_code,$report_code)
	{
		$sql = "SELECT (CASE WHEN item_type = 0 
					THEN NULL::integer
		            ELSE 
		              case when display_saldo = 1 
		              then fn_get_saldo_group_glaccount_new(gl_report_item_id,item_type, ? , ?)*-1         
		              else fn_get_saldo_group_glaccount_new(gl_report_item_id,item_type, ? , ?)         
	              	  end
		        	END) AS saldo
		        FROM mfi_gl_report_item 
		        WHERE report_code = ?
		        AND item_code=?
        ";
		if($branch_code=="00000"){
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $report_code;
			$param[] = $item_code;
		}else{
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $report_code;
			$param[] = $item_code;
		}
		$query = $this->db->query($sql,$param);
		$row=$query->row_array();
		return $row['saldo'];
	}
	public function get_branch_by_branch_induk($branch_induk,$branch_class_output)
	{
		switch ($branch_class_output) {
			case '1':
			$sql = "select * from mfi_branch where branch_class=1 order by branch_code";
			break;
			case '2':
			$sql = "select * from mfi_branch where branch_class=2 and branch_induk = ? order by branch_code";
			break;
			case '3':
			$sql = "select * from mfi_branch where branch_class=3 and branch_induk = ? order by branch_code";
			break;
			default:
			$sql = "";
			break;
		}
		if($sql==""){
			return array();
		}else{
			$query = $this->db->query($sql,array($branch_induk));
			return $query->result_array();
		}
	}

	function get_saldo_report_by_item_code_2($report_code,$item_code,$branch_code){
		$param = array();

		$sql = "SELECT
		item_type,
		formula,
		formula_text_bold,
		(COALESCE(CASE WHEN item_type = '0' THEN NULL::INTEGER ELSE CASE WHEN display_saldo = '1' THEN SUM(saldo_awal) * (-1) ELSE SUM(saldo_awal) END END,0)) AS saldo
		FROM mfi_keuangan_report
		WHERE report_code = ? AND item_code = ? ";

		$param[] = $report_code;
		$param[] = $item_code;

		if($branch_code != '00000'){
			$sql .= "AND report_branch IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY
		item_type,
		formula,
		formula_text_bold,
		display_saldo";
		
		$query = $this->db->query($sql,$param);
		$rows=$query->row_array();

		if(isset($rows['item_type'])){
			$item_tipe = $rows['item_type'];
		} else {
			$item_tipe = '';
		}

		if($item_tipe == '2'){ // FORMULA
			$item_codes=$this->get_codes_by_formula($rows['formula']);
			$arr_amount=array();
			for($j=0;$j<count($item_codes);$j++){
				$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_temp($item_codes[$j],$branch_code,$report_code);
			}
			$formula=$rows['formula'];
			foreach($arr_amount as $key=>$value):
			$formula=str_replace('$'.$key, $value.'::numeric', $formula);
			endforeach;
			if($formula==''){
				$saldo=0;
			}else{
				$sqlsal="select ($formula) as saldo";
				$quesal=$this->db->query($sqlsal);
				$rowsal=$quesal->row_array();
				$saldo=$rowsal['saldo'];
			}
		}else{
			if(isset($rows['saldo'])){
				$saldo = $rows['saldo'];
			} else {
				$saldo = 0;
			}
		}
		
		/* SALDO MUTASI */
		$param2 = array();

		$sql2 = "SELECT
		item_type,
		formula,
		formula_text_bold,
		(COALESCE(CASE WHEN item_type = '0' THEN NULL::INTEGER ELSE CASE WHEN display_saldo = '1' THEN SUM(mutasi_debit - mutasi_credit) * (-1) ELSE SUM(mutasi_debit - mutasi_credit) END END,0)) AS saldo_mutasi
		FROM mfi_keuangan_report
		WHERE report_code = ? AND item_code = ? ";

		$param2[] = $report_code;
		$param2[] = $item_code;

		if($branch_code != '00000'){
			$sql2 .= "AND report_branch IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param2[] = $branch_code;
		}

		$sql2 .= "GROUP BY
		item_type,
		formula,
		formula_text_bold,
		display_saldo";

		$query2 = $this->db->query($sql2,$param2);
		$rows2=$query2->row_array();

		if(isset($rows2['item_type'])){
			$row_item_tipe2 = $rows2['item_type'];
		} else {
			$row_item_tipe2 = '';
		}
		
		if($row_item_tipe2 == '2'){ // FORMULA
			$item_codes2=$this->get_codes_by_formula($rows2['formula']);
			$arr_amount2=array();
			for($j=0;$j<count($item_codes2);$j++){
				$arr_amount2[$item_codes2[$j]]=$this->get_amount_from_item_code_temp($item_codes2[$j],$branch_code,$report_code);
			}
			$formula2=$rows2['formula'];
			foreach($arr_amount2 as $key2=>$value2):
			$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
			endforeach;
			if($formula2==''){
				$saldo_mutasi=0;
			}else{
				$sqlsal2="select ($formula) as saldo_mutasi";
				$quesal2=$this->db->query($sqlsal2);
				$rowsal2=$quesal2->row_array();
				$saldo_mutasi=$rowsal2['saldo_mutasi'];
			}
		}else{
			if(isset($rows2['saldo_mutasi'])){
				$saldo_mutasi = $rows2['saldo_mutasi'];
			} else {
				$saldo_mutasi = 0;
			}
		}

		$return['saldo'] = $saldo;
		$return['saldo_mutasi'] = $saldo_mutasi;

		return $return;
	}
	
	public function get_saldo_report_by_item_code2($report_code,$item_code,$branch_code)
	{
		$param = array();

		/* SALDO */
		$sql = "SELECT
		mgri.item_type,
		mgri.formula,
		mgri.formula_text_bold,
		COALESCE(CASE
		    WHEN mgri.item_type = 0 THEN NULL::integer
		    ELSE 
		      case 
		      when mgri.display_saldo = 1 
		       then sum(mrft.saldo_awal) * -1
		      else  
					sum(mrft.saldo_awal)
		      end  
		END,0) AS saldo
		FROM mfi_gl_report_item AS mgri
		LEFT JOIN mfi_gl_report_item_member AS mgrim on mgrim.gl_report_item_id = mgri.gl_report_item_id
		LEFT JOIN mfi_report_financing_temporary AS mrft on mrft.account_code = mgrim.account_code
		WHERE mgri.report_code = ? AND mrft.user_id = ?
		AND mgri.item_code = ? ";

		$param[] = $report_code;
		$param[] = $this->session->userdata('user_id');
		$param[] = $item_code;

		if($branch_code != '00000'){
			$sql .= "AND mrft.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY
		mgri.item_type,
		mgri.formula,
		mgri.formula_text_bold,
		mgri.display_saldo,
		mgri.report_code,
		mgri.item_code
		ORDER BY
		mgri.report_code,
		mgri.item_code,
		mgri.item_type";

		$query = $this->db->query($sql,$param);
		$rows=$query->row_array();

		if(isset($rows['item_type'])){
			$row_item_tipe = $rows['item_type'];
		} else {
			$row_item_tipe = '';
		}
		
		if($row_item_tipe == '2'){ // FORMULA
			$item_codes=$this->get_codes_by_formula($rows['formula']);
			$arr_amount=array();
			for($j=0;$j<count($item_codes);$j++){
				$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_temp($item_codes[$j],$branch_code,$report_code);
			}
			$formula=$rows['formula'];
			foreach($arr_amount as $key=>$value):
			$formula=str_replace('$'.$key, $value.'::numeric', $formula);
			endforeach;
			if($formula==''){
				$saldo=0;
			}else{
				$sqlsal="select ($formula) as saldo";
				$quesal=$this->db->query($sqlsal);
				$rowsal=$quesal->row_array();
				$saldo=$rowsal['saldo'];
			}
		}else{
			if(isset($rows['saldo'])){
				$saldo = $rows['saldo'];
			} else {
				$saldo = 0;
			}
		}

		/*SALDO MUTASI*/
		$param2 = array();

		$sql2 = "SELECT
		mgri.item_type,
		mgri.formula,
		mgri.formula_text_bold,
		CASE
			WHEN mgri.item_type = 0 THEN NULL::integer
			ELSE 
			  case 
			  when mgri.display_saldo = 1 
				 then sum(mrft.total_mutasi_debet-mrft.total_mutasi_credit)*-1         
			  else  
				 sum(mrft.total_mutasi_debet-mrft.total_mutasi_credit)  
			  end  
		END AS saldo_mutasi 
		FROM mfi_gl_report_item AS mgri
		LEFT JOIN mfi_gl_report_item_member AS mgrim on mgrim.gl_report_item_id = mgri.gl_report_item_id
		LEFT JOIN mfi_report_financing_temporary AS mrft on mrft.account_code = mgrim.account_code
		WHERE mgri.report_code = ? AND mrft.user_id = ?
		AND mgri.item_code = ? ";

		$param2[] = $report_code;
		$param2[] = $this->session->userdata('user_id');
		$param2[] = $item_code;

		if($branch_code != '00000'){
			$sql2 .= "AND mrft.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param2[] = $branch_code;
		}

		$sql2 .= "GROUP BY
		mgri.item_type,
		mgri.formula,
		mgri.formula_text_bold,
		mgri.display_saldo,
		mgri.report_code,
		mgri.item_code
		ORDER BY
		mgri.report_code,
		mgri.item_code,
		mgri.item_type";

		$query2 = $this->db->query($sql2,$param2);
		$rows2=$query2->row_array();

		if(isset($rows2['item_type'])){
			$row_item_tipe2 = $rows2['item_type'];
		} else {
			$row_item_tipe2 = '';
		}
		
		if($row_item_tipe2 == '2'){ // FORMULA
			$item_codes2=$this->get_codes_by_formula($rows2['formula']);
			$arr_amount2=array();
			for($j=0;$j<count($item_codes2);$j++){
				$arr_amount2[$item_codes2[$j]]=$this->get_amount_from_item_code_temp($item_codes2[$j],$branch_code,$report_code);
			}
			$formula2=$rows2['formula'];
			foreach($arr_amount2 as $key2=>$value2):
			$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
			endforeach;
			if($formula2==''){
				$saldo_mutasi=0;
			}else{
				$sqlsal2="select ($formula) as saldo_mutasi";
				$quesal2=$this->db->query($sqlsal2);
				$rowsal2=$quesal2->row_array();
				$saldo_mutasi=$rowsal2['saldo_mutasi'];
			}
		}else{
			if(isset($rows2['saldo_mutasi'])){
				$saldo_mutasi = $rows2['saldo_mutasi'];
			} else {
				$saldo_mutasi = 0;
			}
		}

		$return['saldo'] = $saldo;
		$return['saldo_mutasi'] = $saldo_mutasi;

		return $return;

	}

	public function get_saldo_report_by_item_code2_bulanan($report_code,$item_code,$branch_code,$from_date,$last_date)
	{
		$param = array();

		$sql = "SELECT
		mgri.item_type,
		mgri.formula,
		mgri.formula_text_bold,
		COALESCE(CASE
		    WHEN mgri.item_type = 0 THEN NULL::integer
		    ELSE 
		      case 
		      when mgri.display_saldo = 1 
		       then SUM(mcld.saldo_awal)*-1
		      else  
				SUM(mcld.saldo_awal)
		      end  
		END,0) AS saldo
		FROM mfi_gl_report_item AS mgri
		LEFT JOIN mfi_gl_report_item_member AS mgrim ON mgrim.gl_report_item_id = mgri.gl_report_item_id
		LEFT JOIN mfi_closing_ledger_data AS mcld ON mcld.account_code = mgrim.account_code
		WHERE mgri.report_code = ? and mgri.item_code = ?
		AND mcld.closing_thru_date = ? AND mcld.flag_akhir_tahun = 'T' ";
		
		$param[] = $report_code;
		$param[] = $item_code;
		$param[] = $last_date;

		if($branch_code != '00000'){
			$sql .= "AND mcld.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY
		mgri.item_type,
		mgri.formula,
		mgri.formula_text_bold,
		mgri.display_saldo,
		mgri.report_code,
		mgri.item_code
		ORDER BY
		mgri.report_code,
		mgri.item_code,
		mgri.item_type";

		$query = $this->db->query($sql,$param);
		$rows=$query->row_array();

		if(isset($rows['item_type'])){
			$rows_item_type = $rows['item_type'];
		} else {
			$rows_item_type = '';
		}
		
		if($rows_item_type=='2'){ // FORMULA
			$item_codes=$this->get_codes_by_formula($rows['formula']);
			$arr_amount=array();
			for($j=0;$j<count($item_codes);$j++){
				$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_bulanan($item_codes[$j],$from_date,$branch_code,$report_code);
			}
			$formula=$rows['formula'];
			foreach($arr_amount as $key=>$value):
			$formula=str_replace('$'.$key, $value.'::numeric', $formula);
			endforeach;
			if($formula==''){
				$saldo=0;
			}else{
				$sqlsal="select ($formula) as saldo";
				$quesal=$this->db->query($sqlsal);
				$rowsal=$quesal->row_array();
				$saldo=$rowsal['saldo'];
			}
		}else{
			if(isset($rows['saldo'])){
				$saldo = $rows['saldo'];
			} else {
				$saldo = 0;
			}
		}
		
		/*SALDO MUTASI*/
		$param2 = array();
		$sql2 = "SELECT
				mgri.item_type,
				mgri.formula,
				mgri.formula_text_bold,
				coalesce(CASE
				    WHEN mgri.item_type = 0 THEN NULL::integer
				    ELSE 
				      case 
				      when mgri.display_saldo = 1 
				       then sum(c.total_mutasi_debet-c.total_mutasi_credit)*-1
				      else  
					   sum(c.total_mutasi_debet-c.total_mutasi_credit)  
				      end  
				END,0) AS saldo_mutasi
				FROM mfi_gl_report_item AS mgri
				LEFT JOIN mfi_gl_report_item_member b on mgri.gl_report_item_id=b.gl_report_item_id 
				LEFT JOIN mfi_closing_ledger_data c on b.account_code = c.account_code 
				WHERE mgri.report_code = ? AND mgri.item_code = ? AND c.closing_thru_date = ? AND c.flag_akhir_tahun = 'T' ";

		$param2[] = $report_code;
		$param2[] = $item_code;
		$param2[] = $last_date;

		if($branch_code != '00000'){
			$sql2 .= "AND c.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param2[] = $branch_code;
		}

		$sql2 .= "GROUP BY mgri.item_type,mgri.formula,mgri.formula_text_bold,mgri.display_saldo,mgri.report_code,mgri.item_code
		ORDER BY mgri.report_code, mgri.item_code, mgri.item_type
			";
		
		$query2 = $this->db->query($sql2,$param2);
		$rows2=$query2->row_array();

		if(isset($rows2['item_type'])){
			$rows2_item_type = $rows2['item_type'];
		} else {
			$rows2_item_type = '';
		}
		
		if($rows2_item_type=='2'){ // FORMULA
			$item_codes2=$this->get_codes_by_formula($rows2['formula']);
			$arr_amount2=array();
			for($j=0;$j<count($item_codes2);$j++){
				$arr_amount2[$item_codes2[$j]]=$this->get_amount_from_item_code_bulanan($item_codes2[$j],$last_date,$branch_code,$report_code);
			}
			$formula2=$rows2['formula'];
			foreach($arr_amount2 as $key2=>$value2):
			$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
			endforeach;
			if($formula2==''){
				$saldo_mutasi=0;
			}else{
				$sqlsal2="select ($formula) as saldo_mutasi";
				$quesal2=$this->db->query($sqlsal2);
				$rowsal2=$quesal2->row_array();
				$saldo_mutasi=$rowsal2['saldo_mutasi'];
			}
		}else{
			if(isset($rows2['saldo_mutasi'])){
				$saldo_mutasi = $rows2['saldo_mutasi'];
			} else {
				$saldo_mutasi = 0;
			}
		}

		$return['saldo'] = $saldo;
		$return['saldo_mutasi'] = $saldo_mutasi;

		return $return;

	}

	public function get_saldo_report_by_item_code2_v2($report_code,$item_code,$branch_code,$from_date,$last_date)
	{
		$param = array();

		/* SALDO */
		$sql = "SELECT
				mfi_gl_report_item.item_type,
				mfi_gl_report_item.formula,
				mfi_gl_report_item.formula_text_bold,
				coalesce(CASE
				    WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
				    ELSE 
				      case 
				      when mfi_gl_report_item.display_saldo = 1 
				       then fn_get_saldo_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1
				      else  
					fn_get_saldo_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)
				      end  
				END,0) AS saldo
				FROM mfi_gl_report_item 
				WHERE mfi_gl_report_item.report_code = ? and mfi_gl_report_item.item_code = ?
				ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			";
		
		$param[] = $from_date;
		$param[] = $branch_code;
		$param[] = $from_date;
		$param[] = $branch_code;
		$param[] = $report_code;
		$param[] = $item_code;

		$query = $this->db->query($sql,$param);
		$rows=$query->row_array();
		
		if($rows['item_type']=='2'){ // FORMULA
			$item_codes=$this->get_codes_by_formula($rows['formula']);
			$arr_amount=array();
			for($j=0;$j<count($item_codes);$j++){
				$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_v2($item_codes[$j],$from_date,$branch_code,$report_code);
			}
			$formula=$rows['formula'];
			foreach($arr_amount as $key=>$value):
			$formula=str_replace('$'.$key, $value.'::numeric', $formula);
			endforeach;
			if($formula==''){
				$saldo=0;
			}else{
				$sqlsal="select ($formula) as saldo";
				$quesal=$this->db->query($sqlsal);
				$rowsal=$quesal->row_array();
				$saldo=$rowsal['saldo'];
			}
		}else{
			$saldo=$rows['saldo'];
		}

		/*SALDO MUTASI*/
		$param2 = array();
		$sql2 = "SELECT
				mfi_gl_report_item.item_type,
				mfi_gl_report_item.formula,
				mfi_gl_report_item.formula_text_bold,
				coalesce(CASE
				    WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
				    ELSE 
				      case 
				      when mfi_gl_report_item.display_saldo = 1 
				       then fn_get_saldo_mutasi_gl_account_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1
				      else  
					   fn_get_saldo_mutasi_gl_account_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)
				      end  
				END,0) AS saldo_mutasi
				FROM mfi_gl_report_item 
				WHERE mfi_gl_report_item.report_code = ? and mfi_gl_report_item.item_code = ?
				ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			";
		
		$param2[] = $from_date;
		$param2[] = $last_date;
		$param2[] = $branch_code;
		$param2[] = $from_date;
		$param2[] = $last_date;
		$param2[] = $branch_code;
		$param2[] = $report_code;
		$param2[] = $item_code;

		$query2 = $this->db->query($sql2,$param2);
		$rows2=$query2->row_array();
		
		if($rows2['item_type']=='2'){ // FORMULA
			$item_codes2=$this->get_codes_by_formula($rows2['formula']);
			$arr_amount2=array();
			for($j=0;$j<count($item_codes2);$j++){
				$arr_amount2[$item_codes2[$j]]=$this->get_amount_from_item_code_v2($item_codes2[$j],$last_date,$branch_code,$report_code);
			}
			$formula2=$rows2['formula'];
			foreach($arr_amount2 as $key2=>$value2):
			$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
			endforeach;
			if($formula2==''){
				$saldo_mutasi=0;
			}else{
				$sqlsal2="select ($formula) as saldo_mutasi";
				$quesal2=$this->db->query($sqlsal2);
				$rowsal2=$quesal2->row_array();
				$saldo_mutasi=$rowsal2['saldo_mutasi'];
			}
		}else{
			$saldo_mutasi=$rows2['saldo_mutasi'];
		}

		$return['saldo'] = $saldo;
		$return['saldo_mutasi'] = $saldo_mutasi;

		return $return;

	}
	// public function get_saldo_report_by_item_code_v2($report_code,$item_code,$branch_code,$from_date,$last_date)
	// {
	// 	$param = array();

	// 	/* SALDO */
	// 	$sql = "SELECT
	// 			mfi_gl_report_item.item_type,
	// 			mfi_gl_report_item.formula,
	// 			mfi_gl_report_item.formula_text_bold,
	// 			coalesce(CASE
	// 			    WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
	// 			    ELSE 
	// 			      case 
	// 			      when mfi_gl_report_item.display_saldo = 1 
	// 			       then fn_get_saldo_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1
	// 			      else  
	// 				fn_get_saldo_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)
	// 			      end  
	// 			END,0) AS saldo
	// 			FROM mfi_gl_report_item 
	// 			WHERE mfi_gl_report_item.report_code = ? and mfi_gl_report_item.item_code = ?
	// 			ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
	// 		";
		
	// 	$param[] = $from_date;
	// 	$param[] = $branch_code;
	// 	$param[] = $from_date;
	// 	$param[] = $branch_code;
	// 	$param[] = $report_code;
	// 	$param[] = $item_code;

	// 	$query = $this->db->query($sql,$param);
	// 	$rows=$query->row_array();
		
	// 	if($rows['item_type']=='2'){ // FORMULA
	// 		$item_codes=$this->get_codes_by_formula($rows['formula']);
	// 		$arr_amount=array();
	// 		for($j=0;$j<count($item_codes);$j++){
	// 			$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_v2($item_codes[$j],$from_date,$branch_code,$report_code);
	// 		}
	// 		$formula=$rows['formula'];
	// 		foreach($arr_amount as $key=>$value):
	// 		$formula=str_replace('$'.$key, $value.'::numeric', $formula);
	// 		endforeach;
	// 		if($formula==''){
	// 			$saldo=0;
	// 		}else{
	// 			$sqlsal="select ($formula) as saldo";
	// 			$quesal=$this->db->query($sqlsal);
	// 			$rowsal=$quesal->row_array();
	// 			$saldo=$rowsal['saldo'];
	// 		}
	// 	}else{
	// 		$saldo=$rows['saldo'];
	// 	}

	// 	/*SALDO MUTASI*/
	// 	$param2 = array();
	// 	$sql2 = "SELECT
	// 			mfi_gl_report_item.item_type,
	// 			mfi_gl_report_item.formula,
	// 			mfi_gl_report_item.formula_text_bold,
	// 			coalesce(CASE
	// 			    WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
	// 			    ELSE 
	// 			      case 
	// 			      when mfi_gl_report_item.display_saldo = 1 
	// 			       then fn_get_saldo_mutasi_gl_account_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1
	// 			      else  
	// 				   fn_get_saldo_mutasi_gl_account_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)
	// 			      end  
	// 			END,0) AS saldo_mutasi
	// 			FROM mfi_gl_report_item 
	// 			WHERE mfi_gl_report_item.report_code = ? and mfi_gl_report_item.item_code = ?
	// 			ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
	// 		";
		
	// 	$param2[] = $from_date;
	// 	$param2[] = $last_date;
	// 	$param2[] = $branch_code;
	// 	$param2[] = $from_date;
	// 	$param2[] = $last_date;
	// 	$param2[] = $branch_code;
	// 	$param2[] = $report_code;
	// 	$param2[] = $item_code;

	// 	$query2 = $this->db->query($sql2,$param2);
	// 	$rows2=$query2->row_array();
		
	// 	if($rows2['item_type']=='2'){ // FORMULA
	// 		$item_codes2=$this->get_codes_by_formula($rows2['formula']);
	// 		$arr_amount2=array();
	// 		for($j=0;$j<count($item_codes2);$j++){
	// 			$arr_amount2[$item_codes2[$j]]=$this->get_amount_from_item_code_v2($item_codes2[$j],$last_date,$branch_code,$report_code);
	// 		}
	// 		$formula2=$rows2['formula'];
	// 		foreach($arr_amount2 as $key2=>$value2):
	// 		$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
	// 		endforeach;
	// 		if($formula2==''){
	// 			$saldo_mutasi=0;
	// 		}else{
	// 			$sqlsal2="select ($formula) as saldo_mutasi";
	// 			$quesal2=$this->db->query($sqlsal2);
	// 			$rowsal2=$quesal2->row_array();
	// 			$saldo_mutasi=$rowsal2['saldo_mutasi'];
	// 		}
	// 	}else{
	// 		$saldo_mutasi=$rows2['saldo_mutasi'];
	// 	}

	// 	$return['saldo'] = $saldo;
	// 	$return['saldo_mutasi'] = $saldo_mutasi;

	// 	return $return;

	// }

	function get_saldo_report_by_item_code($report_code,$item_code,$branch_code){
		$param = array();

		$sql = "SELECT
		mfi_gl_report_item.item_type,
		mfi_gl_report_item.formula,
		mfi_gl_report_item.formula_text_bold,
		coalesce(CASE
		    WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
		    ELSE 
		      case 
		      when mfi_gl_report_item.display_saldo = 1 
		       then fn_get_saldo_group_glaccount5(mfi_gl_report_item.gl_report_item_id,?)*-1
		      else  
			fn_get_saldo_group_glaccount5(mfi_gl_report_item.gl_report_item_id,?)
		      end  
		END,0) AS saldo
		FROM mfi_gl_report_item 
		WHERE mfi_gl_report_item.report_code = ? AND mfi_gl_report_item.item_code = ?
		ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type ";

		if($branch_code == '00000'){
			$param[] = 'all';
			$param[] = 'all';
			$param[] = $report_code;
			$param[] = $item_code;
		} else {
			$param[] = $branch_code;
			$param[] = $branch_code;
			$param[] = $report_code;
			$param[] = $item_code;
		}
		
		$query = $this->db->query($sql,$param);
		$rows=$query->row_array();

		if(isset($rows['item_type'])){
			$item_tipe = $rows['item_type'];
		} else {
			$item_tipe = '';
		}

		if($item_tipe == '2'){ // FORMULA
			$item_codes=$this->get_codes_by_formula($rows['formula']);
			$arr_amount=array();
			for($j=0;$j<count($item_codes);$j++){
				$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_temp($item_codes[$j],$branch_code,$report_code);
			}
			$formula=$rows['formula'];
			foreach($arr_amount as $key=>$value):
			$formula=str_replace('$'.$key, $value.'::numeric', $formula);
			endforeach;
			if($formula==''){
				$saldo=0;
			}else{
				$sqlsal="select ($formula) as saldo";
				$quesal=$this->db->query($sqlsal);
				$rowsal=$quesal->row_array();
				$saldo=$rowsal['saldo'];
			}
		}else{
			if(isset($rows['saldo'])){
				$saldo = $rows['saldo'];
			} else {
				$saldo = 0;
			}
		}
		return $saldo;
	}

	public function get_saldo_report_by_item_code_bulanan($report_code,$item_code,$branch_code,$periode_bulan,$periode_tahun,$periode_hari)
	{
		$param = array();
		$last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;

		$sql = "SELECT
		mgri.item_type,
		mgri.formula,
		mgri.formula_text_bold,
		COALESCE(CASE
		    WHEN mgri.item_type = 0 THEN NULL::integer
		    ELSE 
		      case 
		      when mgri.display_saldo = 1 
		       then SUM(mcld.saldo)*-1
		      else  
				SUM(mcld.saldo)
		      end  
		END,0) AS saldo
		FROM mfi_gl_report_item AS mgri
		LEFT JOIN mfi_gl_report_item_member AS mgrim ON mgrim.gl_report_item_id = mgri.gl_report_item_id
		LEFT JOIN mfi_closing_ledger_data AS mcld ON mcld.account_code = mgrim.account_code
		WHERE mgri.report_code = ? and mgri.item_code = ?
		AND mcld.closing_thru_date = ? ";
		
		$param[] = $report_code;
		$param[] = $item_code;
		$param[] = $last_date;

		if($branch_code != '00000'){
			$sql .= "AND mcld.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$sql .= "GROUP BY
		mgri.item_type,
		mgri.formula,
		mgri.formula_text_bold,
		mgri.display_saldo,
		mgri.report_code,
		mgri.item_code
		ORDER BY
		mgri.report_code,
		mgri.item_code,
		mgri.item_type";

		$query = $this->db->query($sql,$param);
		$rows=$query->row_array();
		
		if($rows['item_type']=='2'){ // FORMULA
			$item_codes=$this->get_codes_by_formula($rows['formula']);
			$arr_amount=array();
			for($j=0;$j<count($item_codes);$j++){
				$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$last_date,$branch_code,$report_code);
			}
			$formula=$rows['formula'];
			foreach($arr_amount as $key=>$value):
			$formula=str_replace('$'.$key, $value.'::numeric', $formula);
			endforeach;
			if($formula==''){
				$saldo=0;
			}else{
				$sqlsal="select ($formula) as saldo";
				$quesal=$this->db->query($sqlsal);
				$rowsal=$quesal->row_array();
				$saldo=$rowsal['saldo'];
			}
		}else{
			$saldo=$rows['saldo'];
		}
		return $saldo;
	}

	public function get_saldo_report_by_item_code_v2($report_code,$item_code,$branch_code,$periode_bulan,$periode_tahun,$periode_hari)
	{
		$param = array();
		$last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;

		$sql = "SELECT
				mfi_gl_report_item.item_type,
				mfi_gl_report_item.formula,
				mfi_gl_report_item.formula_text_bold,
				coalesce(CASE
				    WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
				    ELSE 
				      case 
				      when mfi_gl_report_item.display_saldo = 1 
				       then fn_get_saldo_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1
				      else  
					fn_get_saldo_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)
				      end  
				END,0) AS saldo
				FROM mfi_gl_report_item 
				WHERE mfi_gl_report_item.report_code = ? and mfi_gl_report_item.item_code = ?
				ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			";
		
		$param[] = $last_date;
		$param[] = $branch_code;
		$param[] = $last_date;
		$param[] = $branch_code;
		$param[] = $report_code;
		$param[] = $item_code;

		$query = $this->db->query($sql,$param);
		$rows=$query->row_array();
		
		if($rows['item_type']=='2'){ // FORMULA
			$item_codes=$this->get_codes_by_formula($rows['formula']);
			$arr_amount=array();
			for($j=0;$j<count($item_codes);$j++){
				$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_v2($item_codes[$j],$last_date,$branch_code,$report_code);
			}
			$formula=$rows['formula'];
			foreach($arr_amount as $key=>$value):
			$formula=str_replace('$'.$key, $value.'::numeric', $formula);
			endforeach;
			if($formula==''){
				$saldo=0;
			}else{
				$sqlsal="select ($formula) as saldo";
				$quesal=$this->db->query($sqlsal);
				$rowsal=$quesal->row_array();
				$saldo=$rowsal['saldo'];
			}
		}else{
			$saldo=$rows['saldo'];
		}
		return $saldo;
	}

	public function export_lap_laba_rugi_rinci($branch_code,$from_date,$last_date)
	{
		$param = array();
		
		$report_code='21';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1         
			              else  
			                fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)         
			              end  
			        END AS saldo_mutasi
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";

		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = 'all';
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = 'all';

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = $branch_code;
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = $branch_code;

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

			/* saldo mutasi */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes2=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount2=array();
				for($j=0;$j<count($item_codes2);$j++){
					$arr_amount2[$item_codes2[$j]]=$this->get_amount_mutasi_from_item_code($item_codes2[$j],$from_date,$last_date,$branch_code,$report_code);
				}
				$formula2=$rows[$i]['formula'];
				foreach($arr_amount2 as $key2=>$value2):
				$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
				endforeach;
				if($formula2!=""){
					$sqlsal2="select ($formula2) as saldo";
					$quesal2=$this->db->query($sqlsal2);
					$rowsal2=$quesal2->row_array();
					$saldo_mutasi=$rowsal2['saldo'];
				}else{
					$saldo_mutasi=0;
				}
			}else{
				$saldo_mutasi=$rows[$i]['saldo_mutasi'];
			}
			$row[$i]['saldo_mutasi'] = $saldo_mutasi;
		}
		return $row;
	}
	public function export_neraca_rinci_gl($branch_code,$from_date,$last_date)
	{
		$param = array();
		$report_code='11';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1         
			              else  
			                fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)         
			              end  
			        END AS saldo_mutasi
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";

		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = $from_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = 'all';

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = $from_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $branch_code;

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

			/* saldo mutasi */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes2=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount2=array();
				for($j=0;$j<count($item_codes2);$j++){
					$arr_amount2[$item_codes2[$j]]=$this->get_amount_mutasi_from_item_code($item_codes2[$j],$from_date,$last_date,$branch_code,$report_code);
				}
				$formula2=$rows[$i]['formula'];
				foreach($arr_amount2 as $key2=>$value2):
				$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
				endforeach;
				if($formula2!=""){
					$sqlsal2="select ($formula2) as saldo";
					$quesal2=$this->db->query($sqlsal2);
					$rowsal2=$quesal2->row_array();
					$saldo_mutasi=$rowsal2['saldo'];
				}else{
					$saldo_mutasi=0;
				}
			}else{
				$saldo_mutasi=$rows[$i]['saldo_mutasi'];
			}
			$row[$i]['saldo_mutasi'] = $saldo_mutasi;
		}
		return $row;
	}
/*
	public function export_neraca_rinci_gl2($branch_code,$last_date)
	{
		$param = array();
		$report_code='11';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.item_code
			 ";

		if($branch_code=="00000"){
			// param saldo awal
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $last_date;
			$param[] = 'all';

			// param report group
			$param[] = $report_code;
		}else{
			// param saldo awal
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $last_date;
			$param[] = $branch_code;

			// param report group
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			// saldo
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	
		}
		return $row;
	}
*/
	public function export_neraca_rinci_gl2($branch_code,$last_date)
	{
		$param = array();
		$report_code='11';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.item_code
			 ";

		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	
		}
		return $row;

	}

	function export_list_angsuran_pembiayaan_kelompok($from,$thru,$cabang,$majelis,$petugas,$produk,$kreditur){
		$sql = "SELECT
			mtcd.account_financing_no,
			mc.nama,
			mtc.trx_date,
			mcm.cm_name,
			maf.pokok,
			maf.margin,
			maf.jangka_waktu,
			maf.periode_jangka_waktu,
			maf.jtempo_angsuran_last,
			maf.saldo_pokok,
			maf.saldo_margin,
			mpf.nick_name,
			krt.display_text AS krd,
			((mtcd.angsuran_pokok * mtcd.freq) + (mtcd.angsuran_margin * mtcd.freq)) AS jml_angsuran,
			(mtcd.angsuran_pokok * mtcd.freq) AS angsuran_pokok,
			(mtcd.angsuran_margin * mtcd.freq) AS angsuran_margin,
			(mtcd.angsuran_catab * mtcd.freq) AS angsuran_catab,
			((mtcd.angsuran_pokok + mtcd.angsuran_margin + mtcd.angsuran_catab ) * mtcd.freq) AS jml_bayar,
			-- mtcd.account_cash_code, 
			mgac.account_cash_name 		
			
			FROM mfi_trx_cm_detail AS mtcd

			JOIN mfi_account_financing AS maf ON mtcd.account_financing_no = maf.account_financing_no
			JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
			JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
			JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
			JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
			JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
			JOIN mfi_fa AS mf ON mf.fa_code = mtc.fa_code
			JOIN mfi_gl_account_cash AS mgac ON mgac.fa_code = mf.fa_code
			JOIN mfi_list_code_detail AS krt ON maf.kreditur_code = krt.code_value AND krt.code_group = 'kreditur'


			WHERE mtc.trx_date BETWEEN ? AND ?
			AND maf.financing_type = '0' AND mtcd.freq <> '0' ";

		$param = array();

		$param[] = $from;	
		$param[] = $thru;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

        if($majelis != '00000'){
            $sql .= "AND mcm.cm_code = ? ";
            $param[] = $majelis;
        }

        if($petugas != '00000'){
            $sql .= "AND mgac.account_cash_code = ? ";
            $param[] = $petugas;
        }

        if($produk != '00000'){
            $sql .= "AND mpf.product_code = ? ";
            $param[] = $produk;
        }

        if($kreditur != '11111'){
            $sql .= "AND maf.kreditur_code = ? ";
            $param[] = $kreditur;
        }

		$sql .= "ORDER BY
		mtc.trx_date,
		mc.cm_code,
		maf.account_financing_no
		ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}


	function export_list_proyeksi_angsuran($from,$thru,$cabang,$majelis,$pembiayaan,$petugas,$produk,$kreditur){

    	$sql = "SELECT
				a.account_financing_no, 
				b.nama, 
				c.cm_name, 
				a.pokok, 
				a.margin, 
				a.jangka_waktu, 
				a.periode_jangka_waktu, 
				a.tanggal_akad, 
				a.tanggal_mulai_angsur, 
				a.tanggal_jtempo, 
				a.angsuran_pokok, 
				a.angsuran_margin, 
				a.angsuran_catab, 
				a.counter_angsuran, 
				a.status_rekening, 
				a.saldo_pokok, 
				a.saldo_margin, 
				a.saldo_catab, 

				(((? - a.tanggal_mulai_angsur) / 7) + 1) AS proyeksi_count, 
				(SELECT COUNT(*) AS jumlah FROM mfi_hari_libur WHERE EXTRACT(DOW FROM tanggal) = EXTRACT(DOW FROM a.tanggal_mulai_angsur) AND tanggal BETWEEN a.tanggal_mulai_angsur AND ?) AS hari_libur1, 

				(((? - a.tanggal_mulai_angsur) / 7) + 1) AS proyeksi_count2, 
				(SELECT COUNT(*) AS jumlah FROM mfi_hari_libur WHERE EXTRACT(DOW FROM tanggal) = EXTRACT(DOW FROM a.tanggal_mulai_angsur) AND tanggal BETWEEN a.tanggal_mulai_angsur AND ?) AS hari_libur2, 

				(SELECT count(*) FROM generate_series( ?::timestamp , ?::timestamp, '1 day'::interval) dd WHERE extract(dow from dd)=EXTRACT(DOW FROM a.tanggal_mulai_angsur)) as proyeksi_bayar 

				from mfi_account_financing a 
				left join mfi_cif b on a.cif_no=b.cif_no 
				left join mfi_cm c on b.cm_code=c.cm_code 
				
				where a.tanggal_mulai_angsur<? and a.tanggal_jtempo>? and a.financing_type=? ";	

		$param = array();

		$param[] = $from;	
		$param[] = $from;

		$param[] = $thru; 	
		$param[] = $thru;	

		$param[] = $from; 	
		$param[] = $thru;

		$param[] = $thru;
		$param[] = $from;

		$param[] = $pembiayaan;

		if($cabang != '00000'){
			$sql .= "AND a.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		} 

		if($produk != '00000'){
			$sql .= "AND a.product_code = ? ";
			$param[] = $produk;
		}

       

		$sql .= " group by 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18 ORDER BY 3,1 ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}


	function export_list_angsuran_pembiayaan_individu($from,$thru,$cabang,$majelis,$petugas,$produk,$kreditur){
		$sql = "SELECT 
		a.account_financing_no, 
		c.nama, 
		a.trx_date, 
		d.cm_name, 
		b.pokok, 
		b.margin, 
		b.jangka_waktu,
		b.periode_jangka_waktu, 
		b.saldo_pokok,
		b.saldo_margin, 
		e.nick_name,
		b.periode_jangka_waktu,
		b.jtempo_angsuran_last,
		(a.pokok * a.freq) AS bayar_pokok, 
		(a.margin * a.freq) AS bayar_margin, 
		(a.catab * a.freq) AS bayar_catab, 
		((a.pokok + a.margin+ catab) * a.freq) AS jml_bayar, 
		a.account_cash_code, 
		f.account_cash_name,
		krt.display_text AS krd
		
		from mfi_trx_account_financing a 
		left join mfi_account_financing b on a.account_financing_no=b.account_financing_no 
		left join mfi_cif c on b.cif_no= c.cif_no
		left join mfi_cm d on c.cm_code=d.cm_code 
		left join mfi_product_financing e on b.product_code= e.product_code 
		left JOIN mfi_gl_account_cash f ON f.account_cash_code = a.account_cash_code
		left join mfi_fa g ON g.fa_code = b.fa_code
		JOIN mfi_list_code_detail AS krt ON b.kreditur_code = krt.code_value


		WHERE a.trx_date BETWEEN ? AND ? 
		AND b.financing_type = '1'  AND a.trx_financing_type in ( '1','2') ";

		$param = array();

		$param[] = $from;	
		$param[] = $thru;

		if($cabang != '00000'){
			$sql .= "AND c.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

        if($majelis != '00000'){
            $sql .= "AND d.cm_code = ? ";
            $param[] = $majelis;
        }

        if($petugas != '00000'){
            $sql .= "AND f.account_cash_code = ? ";
            $param[] = $petugas;
        }

        if($produk != '00000'){
            $sql .= "AND e.product_code = ? ";
            $param[] = $produk;
        }

        if($kreditur != '11111'){
            $sql .= "AND b.kreditur_code = ? ";
            $param[] = $kreditur;
        }

		$sql .= "ORDER BY
		a.trx_date,
		d.cm_code,
		b.account_financing_no
		ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}



	function export_list_proyeksi_realisasi_angsuran($from,$thru,$cabang,$produk,$majelis){
		$sql = "SELECT
		maf.account_financing_no,
		mc.nama,
		mcm.cm_name,
		maf.pokok,
		maf.margin,
		maf.tanggal_akad,
		maf.saldo_pokok,
		maf.saldo_margin,
		SUM(mtcd.angsuran_pokok * mtcd.freq) AS angsuran_pokok,
		SUM(mtcd.angsuran_margin * mtcd.freq) AS angsuran_margin,
		mcm.cm_code,
		mpf.nick_name

		FROM mfi_account_financing AS maf

		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		LEFT JOIN mfi_trx_cm_detail AS mtcd
		ON mtcd.account_financing_no = maf.account_financing_no
		LEFT JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
		JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code

		WHERE maf.financing_type = '0' AND mtcd.freq <> 0 ";

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN (SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

        if($produk != '0000'){
            $sql .= "AND mpf.product_code = ? ";
            $param[] = $produk;
        }

        if($majelis != '00000'){
            $sql .= "AND mcm.cm_code = ? ";
            $param[] = $majelis;
        }

		$sql .= "AND mtc.trx_date BETWEEN ? AND ?
		GROUP BY 1,2,3,4,5,6,7,8,11,12
		ORDER BY mcm.cm_code, maf.account_financing_no ASC";

		$param[] = $from;	
		$param[] = $thru;

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function export_lap_pencairan_tabungan_berencana($produk,$cabang='',$rembug='',$from_date,$thru_date)
	{
		$sql = "SELECT
		mc.cif_no as id_anggota,
		mc.nama as nama,
		mcm.cm_name as majelis,
		mas.tanggal_buka,
		mas.rencana_jangka_waktu as jangka_waktu,
		mtas.trx_date as tanggal_cair,
		mtas.amount as pencairan,
		mtas.trx_status,
		mps.nick_name,
		mps.product_name
		FROM
		mfi_trx_account_saving AS mtas
		JOIN mfi_account_saving AS mas ON mtas.account_saving_no = mas.account_saving_no
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		JOIN mfi_cif AS mc ON mas.cif_no = mc.cif_no
		JOIN mfi_cm AS mcm ON mc.cm_code = mcm.cm_code
		WHERE mtas.trx_saving_type = 5
		AND mtas.trx_date BETWEEN ? AND ? ";

		$param[] = $from_date;
		$param[] = $thru_date;

		if($cabang!="00000"){
			$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($rembug!="0000"){
			$sql .= "AND mc.cm_code = ? ";
			$param[] = $rembug;
		}

		if($produk!="0000"){
			$sql .= "AND mps.product_code = ? ";
			$param[] = $produk;
		}

		$sql .= "UNION ALL
		SELECT 
		c.cif_no as id_anggota,
		e.nama as nama,
		f.cm_name as majelis,
		g.tanggal_buka,
		g.rencana_jangka_waktu as jangka_waktu,
		a.trx_date as tanggal_cair,
		(d.freq*d.amount) as pencairan,
		a.trx_status,
		mps.nick_name,
		mps.product_name
		from mfi_trx_cm a
		left join mfi_trx_cm_detail b on a.trx_cm_id=b.trx_cm_id
		left join mfi_trx_cm_detail_savingplan c on b.trx_cm_detail_id=c.trx_cm_detail_id
		left join mfi_trx_cm_detail_savingplan_account d on d.trx_cm_detail_savingplan_id=c.trx_cm_detail_savingplan_id
		left join mfi_cif e on e.cif_no=b.cif_no
		left join mfi_cm f on f.cm_code=a.cm_code
		left join mfi_account_saving g on g.cif_no=b.cif_no and g.product_code=d.product_code
		left join mfi_product_saving mps on mps.product_code = g.product_code
		where a.trx_date between ? and ? and d.flag_debet_credit='D'";

		$param[] = $from_date;
		$param[] = $thru_date;

		if($cabang!="00000"){
			$sql .= " AND e.branch_code in(SELECT branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $cabang;
		}

		if($rembug!="0000"){
			$sql .= " AND a.cm_code = ? ";
			$param[] = $rembug;
		} 
		
		$sql .= " ORDER BY 6,1 ASC";

		$query = $this->db->query($sql,$param);
		
		return $query->result_array();
	}
	
	//cabang
	public function export_rekap_angsuran_semua_cabang($branch_code,$tanggal1_,$tanggal2_)
	{
		$param = array();
		$sql = "select
				d.branch_code,
				d.branch_name,
				count(*) as num,
				sum(a.angsuran_pokok*a.freq) pokok,
				sum(a.angsuran_margin*a.freq) margin,
				sum(a.angsuran_catab*a.freq) catab
				from mfi_trx_cm_detail a
				left join mfi_trx_cm b on a.trx_cm_id=b.trx_cm_id
				left join mfi_cm c on b.cm_code=c.cm_code
				left join mfi_branch d on d.branch_id=c.branch_id
				left join mfi_account_financing e on e.account_financing_no=a.account_financing_no
				where b.trx_date between ? and ?
				and a.freq <> '0'
			";

			$param[] = $tanggal1_;	
			$param[] = $tanggal2_;

			if ($branch_code!="00000") {
				$sql .= " and d.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " group by 1,2";
			$query = $this->db->query($sql,$param);
			return $query->result_array();
	}

		//by cabang
		public function export_rekap_angsuran_cabang($branch_code,$tanggal1_,$tanggal2_)
		{
			$param = array();
			$sql = "select
					d.branch_code,
					d.branch_name,
					count(*) as num,
					sum(a.angsuran_pokok*a.freq) pokok,
					sum(a.angsuran_margin*a.freq) margin,
					sum(a.angsuran_catab*a.freq) catab
					from mfi_trx_cm_detail a
					left join mfi_trx_cm b on a.trx_cm_id=b.trx_cm_id
					left join mfi_cm c on b.cm_code=c.cm_code
					left join mfi_branch d on d.branch_id=c.branch_id
					left join mfi_account_financing e on e.account_financing_no=a.account_financing_no
					where b.trx_date between ? and ?
					and a.freq <> '0'
				   ";

			$param[] = $tanggal1_;	
			$param[] = $tanggal2_;

			if ($branch_code!="00000") {
				$sql .= " and d.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " group by 1,2";
			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}
		//rembug
		public function export_rekap_angsuran_rembug($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "select
					c.cm_code,
					c.cm_name,
					count(*) as num,
					sum(a.angsuran_pokok*a.freq) pokok,
					sum(a.angsuran_margin*a.freq) margin,
					sum(a.angsuran_catab*a.freq) catab
					from mfi_trx_cm_detail a
					left join mfi_trx_cm b on a.trx_cm_id=b.trx_cm_id
					left join mfi_cm c on b.cm_code=c.cm_code
					left join mfi_account_financing d on d.account_financing_no=a.account_financing_no
					where b.trx_date between ? and ?
					and a.freq <> '0'
				   ";

			$param[] = $tanggal1;	
			$param[] = $tanggal2;

			if ($branch_code!="00000") {
				$sql .= " and d.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql.=" group by 1,2";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

		//petugas
		public function export_rekap_angsuran_petugas($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "select
					c.fa_code,
					c.fa_name,
					count(*) as num,
					sum(a.angsuran_pokok*a.freq) pokok,
					sum(a.angsuran_margin*a.freq) margin,
					sum(a.angsuran_catab*a.freq) catab
					from mfi_trx_cm_detail a
					left join mfi_trx_cm b on a.trx_cm_id=b.trx_cm_id
					left join mfi_fa c on b.fa_code=c.fa_code
					left join mfi_account_financing d on d.account_financing_no=a.account_financing_no
					where b.trx_date between ? and ?
					and a.freq <> '0'
				   ";
			$param[] = $tanggal1;	
			$param[] = $tanggal2;
			if($branch_code!="00000"){
				$sql .= " and d.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql.=" group by 1,2";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}
		
		//Produk
		public function export_rekap_angsuran_produk($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "select
					c.product_code,
					c.product_name,
					count(*) as num,
					sum(a.angsuran_pokok*a.freq) pokok,
					sum(a.angsuran_margin*a.freq) margin,
					sum(a.angsuran_catab*a.freq) catab
					from mfi_trx_cm_detail a
					left join mfi_trx_cm b on a.trx_cm_id=b.trx_cm_id
					left join mfi_account_financing d on d.account_financing_no=a.account_financing_no
					left join mfi_product_financing c on c.product_code=d.product_code
					where b.trx_date between ? and ?
					and a.freq <> '0'
				   ";
			$param[] = $tanggal1;	
			$param[] = $tanggal2;
			if($branch_code!="00000"){
				$sql .= " and d.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql.=" group by 1,2";
			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}
		
		//peruntukan
		public function export_rekap_angsuran_peruntukan($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "select
					e.code_value,
					e.display_text,
					count(*) as num,
					sum(a.angsuran_pokok*a.freq) pokok,
					sum(a.angsuran_margin*a.freq) margin,
					sum(a.angsuran_catab*a.freq) catab
					from mfi_trx_cm_detail a
					left join mfi_trx_cm b on a.trx_cm_id=b.trx_cm_id
					left join mfi_account_financing d on d.account_financing_no=a.account_financing_no 
					left join mfi_list_code_detail e on e.code_group='peruntukan' and e.code_value::integer=d.peruntukan
					where b.trx_date between ? and ?
					and a.freq <> '0'
				   ";

				    $param[] = $tanggal1;	
					$param[] = $tanggal2;

				    if($branch_code!="00000"){
						$sql .= " and d.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
						$param[] = $branch_code;
					}

					$sql.=" group by 1,2 order by 1";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
		}

		//sektor usaha
		public function export_rekap_angsuran_sektor_usaha($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "select
					e.code_value,
					e.display_text,
					count(*) as num,
					sum(a.angsuran_pokok*a.freq) pokok,
					sum(a.angsuran_margin*a.freq) margin,
					sum(a.angsuran_catab*a.freq) catab
					from mfi_trx_cm_detail a
					left join mfi_trx_cm b on a.trx_cm_id=b.trx_cm_id
					left join mfi_account_financing d on d.account_financing_no=a.account_financing_no
					left join mfi_list_code_detail e on e.code_group='sektor_ekonomi' and e.code_value::integer=d.sektor_ekonomi
					where b.trx_date between ? and ?
					and a.freq <> '0'
				   ";

			$param[] = $tanggal1;	
			$param[] = $tanggal2;

		    if($branch_code!="00000"){
				$sql .= " and d.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql.=" group by 1,2 order by 1";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

		//kreditur
		public function export_rekap_angsuran_kreditur($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "select
					e.code_value,
					e.display_text,
					count(*) as num,
					sum(a.angsuran_pokok*a.freq) pokok,
					sum(a.angsuran_margin*a.freq) margin,
					sum(a.angsuran_catab*a.freq) catab
					from mfi_trx_cm_detail a
					left join mfi_trx_cm b on a.trx_cm_id=b.trx_cm_id
					left join mfi_account_financing d on d.account_financing_no=a.account_financing_no
					left join mfi_list_code_detail e on e.code_group='kreditur' and e.code_value=d.kreditur_code
					where b.trx_date between ? and ?
					and a.freq <> '0'
				   ";

			$param[] = $tanggal1;	
			$param[] = $tanggal2;

		    if($branch_code!="00000"){
				$sql .= " and d.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql.=" group by 1,2 order by 1";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}


	// ----------------------------------------------------------------------
	// START REKAP ANGSURAN INDIVIDU
	// ----------------------------------------------------------------------


		function export_rekap_angsuran_kreditur_individu($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "SELECT 
					c.code_value, 
					c.display_text, 
					count(*) AS num, 
					sum(a.pokok * a.freq) AS pokok, 
					sum(a.margin * a.freq) AS margin, 
					sum(a.catab * a.freq) AS catab  
					FROM mfi_trx_account_financing AS a 
					JOIN mfi_account_financing AS b ON a.account_financing_no = b.account_financing_no
					JOIN mfi_list_code_detail AS c ON b.kreditur_code = c.code_value
					WHERE a.trx_date BETWEEN ? AND ?
					AND a.trx_financing_type in ( '1','2') 
					AND c.code_group = 'kreditur'
				   ";

			$param[] = $tanggal1;	
			$param[] = $tanggal2;

		    if($branch_code!="00000"){
				$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql.=" group by 1,2 order by 1";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}		

		function export_rekap_angsuran_sektor_usaha_individu($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "SELECT 
					c.code_value, 
					c.display_text, 
					count(*) AS num, 
					sum(a.pokok * a.freq) AS pokok, 
					sum(a.margin * a.freq) AS margin, 
					sum(a.catab * a.freq) AS catab  
					FROM mfi_trx_account_financing AS a 
					JOIN mfi_account_financing AS b ON a.account_financing_no = b.account_financing_no
					JOIN mfi_list_code_detail AS c ON c.code_value::integer = b.sektor_ekonomi
					WHERE a.trx_date BETWEEN ? AND ?
					AND a.trx_financing_type in ( '1','2') 
					AND c.code_group = 'sektor_ekonomi'
				   ";

			$param[] = $tanggal1;	
			$param[] = $tanggal2;

		    if($branch_code!="00000"){
				$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql.=" group by 1,2 order by 1";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}		

		function export_rekap_angsuran_peruntukan_individu($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "SELECT 
					c.code_value, 
					c.display_text, 
					count(*) AS num, 
					sum(a.pokok * a.freq) AS pokok, 
					sum(a.margin * a.freq) AS margin, 
					sum(a.catab * a.freq) AS catab  
					FROM mfi_trx_account_financing AS a 
					JOIN mfi_account_financing AS b ON a.account_financing_no = b.account_financing_no
					JOIN mfi_list_code_detail AS c ON c.code_value::integer = b.peruntukan
					WHERE a.trx_date BETWEEN ? AND ?
					AND a.trx_financing_type in ( '1','2') 
					AND c.code_group = 'peruntukan'
				   ";

			$param[] = $tanggal1;	
			$param[] = $tanggal2;

		    if($branch_code!="00000"){
				$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql.=" group by 1,2 order by 1";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}	

		function export_rekap_angsuran_produk_individu($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "SELECT 
					c.product_code, 
					c.product_name, 
					count(*) AS num, 
					sum(a.pokok * a.freq) AS pokok, 
					sum(a.margin * a.freq) AS margin, 
					sum(a.catab * a.freq) AS catab  
					FROM mfi_trx_account_financing AS a 
					JOIN mfi_account_financing AS b ON a.account_financing_no = b.account_financing_no
					JOIN mfi_product_financing AS c ON c.product_code = b.product_code
					WHERE a.trx_date BETWEEN ? AND ?
					AND a.trx_financing_type in ( '1','2') 
				   ";

			$param[] = $tanggal1;	
			$param[] = $tanggal2;

		    if($branch_code!="00000"){
				$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql.=" group by 1,2 order by 1";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

		function export_rekap_angsuran_petugas_individu($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "SELECT 
					c.fa_code, 
					c.fa_name, 
					count(*) AS num, 
					sum(a.pokok * a.freq) AS pokok, 
					sum(a.margin * a.freq) AS margin, 
					sum(a.catab * a.freq) AS catab  
					FROM mfi_trx_account_financing AS a 
					JOIN mfi_gl_account_cash AS b ON a.account_cash_code = b.account_cash_code
					JOIN mfi_fa AS c ON b.fa_code = c.fa_code
					JOIN mfi_account_financing AS d ON d.account_financing_no = a.account_financing_no
					WHERE a.trx_date BETWEEN ? AND ?
					AND a.trx_financing_type in ( '1','2') 
				   ";

			$param[] = $tanggal1;	
			$param[] = $tanggal2;

		    if($branch_code!="00000"){
				$sql .= " and d.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql.=" group by 1,2 order by 1";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

		function export_rekap_angsuran_rembug_individu($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "SELECT 
					d.cm_code, 
					d.cm_name, 
					count(*) AS num, 
					sum(a.pokok * a.freq) AS pokok, 
					sum(a.margin * a.freq) AS margin, 
					sum(a.catab * a.freq) AS catab  
					FROM mfi_trx_account_financing AS a 
					JOIN mfi_account_financing AS b ON b.account_financing_no = a.account_financing_no
					JOIN mfi_cif AS c ON b.cif_no = c.cif_no
					JOIN mfi_cm AS d ON c.cm_code = d.cm_code
					WHERE a.trx_date BETWEEN ? AND ?
					AND a.trx_financing_type in ( '1','2') 
				   ";

			$param[] = $tanggal1;	
			$param[] = $tanggal2;

		    if($branch_code!="00000"){
				$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql.=" group by 1,2 order by 1";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

		function export_rekap_angsuran_cabang_individu($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "SELECT 
					d.cm_code, 
					e.branch_code, 
					e.branch_name,
					count(*) AS num, 
					sum(a.pokok * a.freq) AS pokok, 
					sum(a.margin * a.freq) AS margin, 
					sum(a.catab * a.freq) AS catab  
					FROM mfi_trx_account_financing AS a 
					JOIN mfi_account_financing AS b ON b.account_financing_no = a.account_financing_no
					JOIN mfi_cif AS c ON b.cif_no = c.cif_no
					JOIN mfi_cm AS d ON c.cm_code = d.cm_code
					JOIN mfi_branch AS e ON d.branch_id = e.branch_id
					WHERE a.trx_date BETWEEN ? AND ?
					AND a.trx_financing_type in ( '1','2') 
				   ";

			$param[] = $tanggal1;	
			$param[] = $tanggal2;

		    if($branch_code!="00000"){
				$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql.=" group by 1,2,3 order by 1";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

		function export_rekap_angsuran_semua_cabang_individu($branch_code,$tanggal1,$tanggal2)
		{
			$param = array();
			$sql = "SELECT 					 
					e.branch_code, 
					e.branch_name,
					count(*) AS num, 
					sum(a.pokok * a.freq) AS pokok, 
					sum(a.margin * a.freq) AS margin, 
					sum(a.catab * a.freq) AS catab  
					FROM mfi_trx_account_financing AS a 
					JOIN mfi_account_financing AS b ON b.account_financing_no = a.account_financing_no
					JOIN mfi_cif AS c ON b.cif_no = c.cif_no
					JOIN mfi_cm AS d ON c.cm_code = d.cm_code
					JOIN mfi_branch AS e ON d.branch_id = e.branch_id
					WHERE a.trx_date BETWEEN ? AND ?
					AND a.trx_financing_type in ( '1','2') 
				   ";

			$param[] = $tanggal1;	
			$param[] = $tanggal2;

		    if($branch_code!="00000"){
				$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			$sql.=" group by 1,2 order by 1";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

	// ----------------------------------------------------------------------
	// END REKAP ANGSURAN INDIVIDU
	// ----------------------------------------------------------------------

		public function jqgrid_list_transaksi_rembug($sidx='',$sord='',$limit_rows='',$start='',$branch_code='',$cm_code='',$from_date='',$thru_date='',$fa_code='')
		{
			$order = '';
			$limit = '';

			if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
			if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

			$sql = "select
				'Ya' as status_verifikasi,
				((select sum((a.angsuran_pokok+a.angsuran_margin+a.angsuran_catab+a.tab_wajib_cr+a.tab_kelompok_cr) * a.freq)+coalesce(sum(a.tab_sukarela_cr),0)+coalesce(sum(a.minggon),0)+coalesce(sum(b.administrasi),0)+coalesce(sum(b.asuransi),0)
				from mfi_trx_cm_detail a
				left join mfi_trx_cm_detail_droping b on a.trx_cm_detail_id = b.trx_cm_detail_id
				left join mfi_trx_cm_detail_savingplan c on a.trx_cm_detail_id = c.trx_cm_detail_id 
				where a.trx_cm_id = mfi_trx_cm.trx_cm_id
				))+(select coalesce(sum(b.amount*b.freq),0)
					from mfi_trx_cm_detail_savingplan a, mfi_trx_cm_detail_savingplan_account b
					where a.trx_cm_detail_savingplan_id=b.trx_cm_detail_savingplan_id and a.trx_cm_detail_id in(
						select trx_cm_detail_id from mfi_trx_cm_detail where trx_cm_id=mfi_trx_cm.trx_cm_id
					)
				)+infaq_kelompok setoran,
				(droping+tab_sukarela_db) penarikan,
				mfi_trx_cm.trx_cm_id,
				mfi_cm.cm_code,
				mfi_cm.cm_name,
				mfi_fa.fa_name,
				mfi_trx_cm.trx_date,
				CAST(mfi_trx_cm.created_date as varchar(10))
				from mfi_trx_cm
				left join mfi_cm on mfi_cm.cm_code = mfi_trx_cm.cm_code
				left join mfi_fa on mfi_fa.fa_code = mfi_trx_cm.fa_code
				left join mfi_branch on mfi_branch.branch_id=mfi_cm.branch_id
				where trx_date between ? and ?
				";

				$param[] = $from_date;
				$param[] = $thru_date;

				if($branch_code!="00000"){
					$sql .= " and mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
				}

				if($cm_code!="0000"){
					$sql .= " and mfi_cm.cm_code = ? ";
					$param[] = $cm_code;
				}

				if($fa_code!="0000"){
					$sql .= " and mfi_trx_cm.fa_code = ? ";
					$param[] = $fa_code;
				}

				$sql .= "
						union all
						select
						'Tidak' as status_verifikasi,
						((select sum((
						(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_pokok else 0 end) else 0 end) else 0 end)+
						(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_margin else 0 end) else 0 end) else 0 end)+
						(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_catab else 0 end) else 0 end) else 0 end)+
						(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_tab_wajib else 0 end) else 0 end) else 0 end)+
						(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_tab_kelompok else 0 end) else 0 end) else 0 end)
						) * a.frekuensi)+
						sum(a.setoran_tab_sukarela)+
						sum(a.setoran_mingguan)+
						sum((case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then (mfi_account_financing.cadangan_resiko + dana_kebajikan + biaya_administrasi + biaya_notaris) else 0 end) else 0 end))+
						sum((case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then (biaya_asuransi_jiwa + biaya_asuransi_jaminan) else 0 end) else 0 end))+
						sum( (select sum(b.amount*b.frekuensi) from mfi_trx_cm_save_berencana b where b.trx_cm_save_detail_id=a.trx_cm_save_detail_id ))
						--(select (b.amount*b.frekuensi) from mfi_trx_cm_save_berencana b where b.trx_cm_save_detail_id=a.trx_cm_save_detail_id)
						--coalesce(sum(b.amount*b.frekuensi),0)
						from mfi_trx_cm_save_detail a
						left join mfi_account_financing on mfi_account_financing.cif_no = a.cif_no  and mfi_account_financing.status_rekening = 1 and mfi_account_financing.financing_type = 0
						--left join mfi_trx_cm_save_berencana b on a.trx_cm_save_detail_id = b.trx_cm_save_detail_id 
						where a.trx_cm_save_id = mfi_trx_cm_save.trx_cm_save_id
						)) setoran,
						(select (sum(a.penarikan_tab_sukarela)+sum((case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then mfi_account_financing.pokok else 0 end) else 0 end)))
						from mfi_trx_cm_save_detail a
						left join mfi_account_financing on mfi_account_financing.cif_no = a.cif_no and mfi_account_financing.status_rekening = 1 and mfi_account_financing.financing_type = 0
						where a.trx_cm_save_id = mfi_trx_cm_save.trx_cm_save_id 
						) penarikan,
						mfi_trx_cm_save.trx_cm_save_id,
						mfi_cm.cm_code,
						mfi_cm.cm_name,
						mfi_fa.fa_name,
						mfi_trx_cm_save.trx_date,
						CAST(mfi_trx_cm_save.created_date as varchar(10))
						from mfi_trx_cm_save
						left join mfi_cm on mfi_cm.cm_code = mfi_trx_cm_save.cm_code
						left join mfi_fa on mfi_fa.fa_code = mfi_trx_cm_save.fa_code
						left join mfi_branch on mfi_trx_cm_save.branch_id=mfi_branch.branch_id
						where trx_date between ? and ? ";

				$param[] = $from_date;
				$param[] = $thru_date;

				if($branch_code!="00000"){
					$sql .= " and mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code;
				}

				if($cm_code!="0000"){
					$sql .= " and mfi_cm.cm_code = ? ";
					$param[] = $cm_code;
				}

				if($fa_code!="0000"){
					$sql .= " and mfi_trx_cm_save.fa_code = ? ";
					$param[] = $fa_code;
				}

			$sql .= "$order $limit";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

	function export_rekap_saldo_tabungan($cabang){
		$sql = "SELECT
		mps.product_name,
		COUNT(mas.cif_no) AS jumlah,
		SUM(mas.saldo_memo) AS nominal

		FROM mfi_account_saving AS mas
		LEFT JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		WHERE mas.status_rekening = '1' ";

		$param = array();

		if($cabang != '00000'){
			$sql .= "AND mas.branch_code = ? ";
			$param[] = $cabang;
		}

		$sql .= "GROUP BY 1";
		$sql .= "ORDER BY 1";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}


	function export_rekap_saldo_tabungan_lalu($cabang,$tanggal){
		$sql = "SELECT mas.product_code, 
		mps.product_name,
		COUNT(mcs.cif_no) AS jumlah,
		SUM(mcs.saldo_memo) AS nominal

		FROM mfi_closing_saving_data AS mcs
		LEFT JOIN mfi_account_saving AS mas ON mcs.account_saving_no=mas.account_saving_no
		LEFT JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		WHERE mcs.closing_thru_date=?  and mas.product_code<>'0006' ";

		$param = array();

		$param[] = $tanggal;

		if($cabang != '00000'){
			$sql .= "AND mas.branch_code = ? ";
			$param[] = $cabang;
		}

		$sql .= "GROUP BY 1,2 ";
		$sql .= "ORDER BY 1";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function export_rekap_transaksi_individu($branch,$rembug,$petugas,$from,$thru){
		$sql = "SELECT
		maf.account_financing_no,
		mcm.cm_name,
		mc.nama,
		maf.pokok,
		maf.biaya_administrasi,
		maf.biaya_asuransi_jiwa,
		maf.jangka_waktu,
		maf.counter_angsuran,
		mpf.product_name,
		(CASE WHEN(maf.periode_jangka_waktu = 0)
			-- HARIAN
			THEN (? - maf.jtempo_angsuran_next)
		WHEN(maf.periode_jangka_waktu = 1)
			-- MINGGUAN
			THEN ((? - maf.jtempo_angsuran_next) / 7)
		ELSE 0 END) AS tunggakan,
		(maf.angsuran_pokok + maf.angsuran_margin + maf.angsuran_catab + maf.angsuran_tab_wajib + maf.angsuran_tab_kelompok) AS angsuran

		FROM mfi_account_financing AS maf

		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code

		WHERE maf.financing_type = 1 AND maf.status_rekening = 1 ";

		$param = array();

		$param[] = $from;
		$param[] = $from;

		if($branch != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member
			WHERE branch_induk = ?) ";
			$param[] = $branch;
		}

		if($rembug != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $rembug;
		}

		if($petugas != '00000'){
			$sql .= "AND maf.fa_code = ? ";
			$param[] = $petugas;
		}

		$sql .= "ORDER BY 1,2";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_neraca_gl_v2($branch_code,$last_date)
	{
		$param = array();
		// $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
		$report_code='10';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";

		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_v2($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

		}
		return $row;
	}

	public function export_neraca_rinci_gl_v2($branch_code,$last_date)
	{
		$param = array();
		$report_code='11';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.item_code
			 ";

		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_v2($item_codes[$j],$last_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	
		}
		return $row;
	}


	public function export_lap_laba_rugi_v2($branch_code,$from_date,$last_date)
	{
		$param = array();
		$report_code='20';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount_lr(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount_lr(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_mutasi_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1         
			              else  
			                fn_get_saldo_mutasi_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)         
			              end  
			        END AS saldo_mutasi
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";
			
		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = 'all';
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = 'all';

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = $branch_code;
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = $branch_code;

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_v2($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

			/* saldo mutasi */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes2=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount2=array();
				for($j=0;$j<count($item_codes2);$j++){
					$arr_amount2[$item_codes2[$j]]=$this->get_amount_mutasi_from_item_code_v2($item_codes2[$j],$from_date,$last_date,$branch_code,$report_code);
				}
				$formula2=$rows[$i]['formula'];
				foreach($arr_amount2 as $key2=>$value2):
				$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
				endforeach;
				if($formula2!=""){
					$sqlsal2="select ($formula2) as saldo";
					$quesal2=$this->db->query($sqlsal2);
					$rowsal2=$quesal2->row_array();
					$saldo_mutasi=$rowsal2['saldo'];
				}else{
					$saldo_mutasi=0;
				}
			}else{
				$saldo_mutasi=$rows[$i]['saldo_mutasi'];
			}
			$row[$i]['saldo_mutasi'] = $saldo_mutasi;
		}
		return $row;
	}


	public function export_lap_laba_rugi_rinci_v2($branch_code,$from_date,$last_date)
	{
		$param = array();
		
		$report_code='21';
		$sql = "SELECT mfi_gl_report_item.report_code,
			    mfi_gl_report_item.item_code,
			    mfi_gl_report_item.item_type,
			    mfi_gl_report_item.posisi,
			    mfi_gl_report_item.formula,
			    mfi_gl_report_item.formula_text_bold,
			        CASE
			            WHEN mfi_gl_report_item.posisi = 0 THEN '<b>'||mfi_gl_report_item.item_name||'</b>'
			            WHEN mfi_gl_report_item.posisi = 1 THEN ('  '||mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            WHEN mfi_gl_report_item.posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || mfi_gl_report_item.item_name::text)::character varying
			            ELSE mfi_gl_report_item.item_name
			        END AS item_name,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_group_glaccount_lr(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1         
			              else  
			                fn_get_saldo_group_glaccount_lr(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)         
			              end  
			        END AS saldo,
			        CASE
			            WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when mfi_gl_report_item.display_saldo = 1 
			               then fn_get_saldo_mutasi_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1         
			              else  
			                fn_get_saldo_mutasi_group_glaccount_new(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)         
			              end  
			        END AS saldo_mutasi
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			 ";

		if($branch_code=="00000"){
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = 'all';
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = 'all';

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = 'all';

			/* param report group */
			$param[] = $report_code;
		}else{
			/* param saldo awal */
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = $branch_code;
			$param[] = date('Y-m-d',strtotime($from_date.' -1 day'));
			$param[] = $branch_code;

			/* param saldo awal mutasi */
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;
			$param[] = $from_date;
			$param[] = $last_date;
			$param[] = $branch_code;

			/* param report group */
			$param[] = $report_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$rows=$query->result_array();
		$row=array();
		for($i=0;$i<count($rows);$i++){
			$row[$i]['report_code'] = $rows[$i]['report_code'];	
			$row[$i]['item_code'] = $rows[$i]['item_code'];	
			$row[$i]['item_type'] = $rows[$i]['item_type'];	
			$row[$i]['posisi'] = $rows[$i]['posisi'];	
			$row[$i]['formula'] = $rows[$i]['formula'];	
			$row[$i]['formula_text_bold'] = $rows[$i]['formula_text_bold'];	
			$row[$i]['item_name'] = $rows[$i]['item_name'];
			/* saldo */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount=array();
				for($j=0;$j<count($item_codes);$j++){
					$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code_v2($item_codes[$j],$from_date,$branch_code,$report_code);
				}
				$formula=$rows[$i]['formula'];
				foreach($arr_amount as $key=>$value):
				$formula=str_replace('$'.$key, $value.'::numeric', $formula);
				endforeach;
				if($formula!=""){
					$sqlsal="select ($formula) as saldo";
					$quesal=$this->db->query($sqlsal);
					$rowsal=$quesal->row_array();
					$saldo=$rowsal['saldo'];
				}else{
					$saldo=0;
				}
			}else{
				$saldo=$rows[$i]['saldo'];
			}
			$row[$i]['saldo'] = $saldo;	

			/* saldo mutasi */
			if($rows[$i]['item_type']=='2'){ // FORMULA
				$item_codes2=$this->get_codes_by_formula($rows[$i]['formula']);
				$arr_amount2=array();
				for($j=0;$j<count($item_codes2);$j++){
					$arr_amount2[$item_codes2[$j]]=$this->get_amount_mutasi_from_item_code_v2($item_codes2[$j],$from_date,$last_date,$branch_code,$report_code);
				}
				$formula2=$rows[$i]['formula'];
				foreach($arr_amount2 as $key2=>$value2):
				$formula2=str_replace('$'.$key2, $value2.'::numeric', $formula2);
				endforeach;
				if($formula2!=""){
					$sqlsal2="select ($formula2) as saldo";
					$quesal2=$this->db->query($sqlsal2);
					$rowsal2=$quesal2->row_array();
					$saldo_mutasi=$rowsal2['saldo'];
				}else{
					$saldo_mutasi=0;
				}
			}else{
				$saldo_mutasi=$rows[$i]['saldo_mutasi'];
			}
			$row[$i]['saldo_mutasi'] = $saldo_mutasi;
		}
		return $row;
	}

	function export_lap_list_bagihasil($cabang,$majelis,$petugas,$periode){
		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		mtcd.tab_sukarela_cr
		FROM mfi_trx_cm_detail AS mtcd
		JOIN mfi_cif AS mc ON mc.cif_no = mtcd.cif_no
		JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
		JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mtcd.keterangan LIKE '%POSTING BAHAS%' ";

		$param = array();

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code = ? ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}
		
		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		$tanggal1 = $periode.'-01-01';
		$tanggal2 = $periode.'-12-31';

		$sql .= "AND mtc.trx_date BETWEEN ? AND ? ";
		$sql .=" ORDER BY mcm.cm_code, mc.kelompok";
		$param[] = $tanggal1;
		$param[] = $tanggal2;

		$query = $this->db->query($sql,$param);
		
		return $query->result_array();
	}

	function export_lap_list_bagihasil_shu($cabang,$majelis,$petugas,$periode){
		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		mttb.amount
		FROM mfi_trx_tab_sukarela AS mttb
		JOIN mfi_cif AS mc ON mc.cif_no = mttb.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mttb.trx_type = '9' ";

		$param = array();

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code = ? ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}
		
		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		$tanggal1 = $periode.'-01-01';
		$tanggal2 = $periode.'-12-31';

		$sql .= "AND mttb.trx_date BETWEEN ? AND ? ";
		$sql .=" ORDER BY mcm.cm_code, mc.kelompok";
		$param[] = $tanggal1;
		$param[] = $tanggal2;

		$query = $this->db->query($sql,$param);
		
		return $query->result_array();
	}

	// Begin Laporan Anggota Bulan Lalu
	function jqgrid_count_anggota_bulan_lalu($cabang,$majelis,$petugas,$tanggal){
		$sql = "SELECT 
		COUNT(*) AS num

				FROM mfi_closing_balance_data a 
				JOIN mfi_cif AS b ON b.cif_no=a.cif_no
				JOIN mfi_cm AS c ON c.cm_code=b.cm_code
				JOIN mfi_branch AS d ON d.branch_id=c.branch_id
				JOIN mfi_fa AS e ON e.fa_code = c.fa_code
				JOIN mfi_kecamatan_desa AS h ON h.desa_code = c.desa_code
				WHERE a.cif_no <> '0'
				";

		$param = array();

		// if($pembiayaan != '9'){
		// 	$sql .= "AND f.financing_type = ? ";
		// 	$param[] = $pembiayaan;
		// }

		if($cabang != '00000'){
			$sql .= "AND d.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND e.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND c.cm_code = ? ";
			$param[] = $majelis;
		}

		// if($produk != '00000'){
		// 	$sql .= "AND g.product_code = ? ";
		// 	$param[] = $produk;
		// }
		
		// if($peruntukan != '00000'){
		// 	$sql .= "AND f.peruntukan = ? ";
		// 	$param[] = $peruntukan;
		// } 

		// if($sektor != '00000'){
		// 	$sql .= "AND f.sektor_ekonomi = ? ";
		// 	$param[] = $sektor;
		// }

		$sql .= "AND a.closing_thru_date = ?";
		$param[] = $tanggal;

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_anggota_bulan_lalu($sidx,$sord,$limit_rows,$start,$cabang,$majelis,$petugas,$tanggal){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY d.branch_code,c.cm_name,b.kelompok::INTEGER ASC";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT  
				a.closing_id, a.closing_from_date, a.closing_thru_date, b.branch_code, a.cif_no, b.nama, c.cm_name, h.desa, e.fa_name,  
				a.saldo_tab_sukarela, a.saldo_tab_wajib, a.saldo_tab_kelompok, 	a.saldo_rr_tab_sukarela, a.saldo_rr_tab_wajib, 	a.saldo_rr_tab_kelompok,  i.setoran_lwk, 
				sum(k.saldo_memo) saldo_tabber, sum(l.pokok) pokok, sum(l.margin) margin, sum(m.saldo_pokok) saldo_pokok, sum(m.saldo_margin) saldo_margin,  sum(m.saldo_catab) saldo_catab 			 
				FROM mfi_closing_balance_data a 															
				left outer JOIN mfi_cif b on b.cif_no=a.cif_no 															
				left outer JOIN mfi_account_default_balance i on i.cif_no=a.cif_no 															
				left outer JOIN mfi_cm c on c.cm_code=b.cm_code															
				left outer JOIN mfi_branch d on d.branch_id=c.branch_id															
				left outer JOIN mfi_fa e on e.fa_code = c.fa_code															
				left outer JOIN mfi_kecamatan_desa h on h.desa_code = c.desa_code 															
				left outer JOIN mfi_closing_saving_data k on k.cif_no=a.cif_no  and k.closing_from_date=a.closing_from_date 															
				left outer JOIN mfi_closing_financing_data m on m.cif_no=a.cif_no  and m.closing_from_date=a.closing_from_date 
				left outer JOIN mfi_account_financing l on l.account_financing_no=m.account_financing_no  															

				WHERE  a.cif_no <> '0'
				";

		$param = array();

		if($cabang != '00000'){
			$sql .= "AND b.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND e.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND b.cm_code = ? ";
			$param[] = $majelis;
		}

		// if($produk != '00000'){
		// 	$sql .= "AND g.product_code = ? ";
		// 	$param[] = $produk;
		// }
		
		// if($peruntukan != '00000'){
		// 	$sql .= "AND f.peruntukan = ? ";
		// 	$param[] = $peruntukan;
		// } 

		// if($sektor != '00000'){
		// 	$sql .= "AND f.sektor_ekonomi = ? ";
		// 	$param[] = $sektor;
		// }

		$sql .= "AND a.closing_thru_date = ?";
		$param[] = $tanggal;

		$sql .= " group by 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16  ORDER BY b.branch_code,c.cm_name, a.cif_no ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function export_lap_list_anggota_bulan_lalu($cabang,$petugas,$majelis,$tanggal){
		$sql = "SELECT  
				a.closing_id, a.closing_from_date, a.closing_thru_date, b.branch_code, a.cif_no, b.nama, c.cm_name, h.desa, e.fa_name,  
				a.saldo_tab_sukarela, a.saldo_tab_wajib, a.saldo_tab_kelompok, 	a.saldo_rr_tab_sukarela, a.saldo_rr_tab_wajib, 	a.saldo_rr_tab_kelompok,  i.setoran_lwk, 
				sum(k.saldo_memo) saldo_tabber, sum(l.pokok) pokok, sum(l.margin) margin, sum(m.saldo_pokok) saldo_pokok, sum(m.saldo_margin) saldo_margin,  sum(m.saldo_catab) saldo_catab 			 
				FROM mfi_closing_balance_data a 															
				left outer JOIN mfi_cif b on b.cif_no=a.cif_no 															
				left outer JOIN mfi_account_default_balance i on i.cif_no=a.cif_no 															
				left outer JOIN mfi_cm c on c.cm_code=b.cm_code															
				left outer JOIN mfi_branch d on d.branch_id=c.branch_id															
				left outer JOIN mfi_fa e on e.fa_code = c.fa_code															
				left outer JOIN mfi_kecamatan_desa h on h.desa_code = c.desa_code 															
				left outer JOIN mfi_closing_saving_data k on k.cif_no=a.cif_no  and k.closing_from_date=a.closing_from_date 															
				left outer JOIN mfi_closing_financing_data m on m.cif_no=a.cif_no  and m.closing_from_date=a.closing_from_date 
				left outer JOIN mfi_account_financing l on l.account_financing_no=m.account_financing_no  															

				WHERE a.cif_no <> '0'
				";

		$param = array();

		if($cabang != '00000'){
			$sql .= "AND b.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND e.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND b.cm_code = ? ";
			$param[] = $majelis;
		}

		// if($produk != '00000'){
		// 	$sql .= "AND g.product_code = ? ";
		// 	$param[] = $produk;
		// }
		
		// if($peruntukan != '00000'){
		// 	$sql .= "AND f.peruntukan = ? ";
		// 	$param[] = $peruntukan;
		// } 

		// if($sektor != '00000'){
		// 	$sql .= "AND f.sektor_ekonomi = ? ";
		// 	$param[] = $sektor;
		// }

		$sql .= "AND a.closing_thru_date = ?";
		$param[] = $tanggal;

		$sql .= " group by 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16  ORDER BY b.branch_code,c.cm_name, a.cif_no ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	} 

	// END

	// List Pengajuan Pembiayaan
	function jqgrid_count_pengajuan_pembiayaan($cabang,$pembiayaan,$petugas,$majelis,$tanggal,$tanggal2){
		$sql = "SELECT

		COUNT(*) AS num

		FROM mfi_account_financing_reg AS mafr

		INNER JOIN mfi_cif AS mc ON mafr.cif_no = mc.cif_no
		INNER JOIN mfi_cm AS mcm ON mc.cm_code = mcm.cm_code
		INNER JOIN mfi_branch AS mb ON mcm.branch_id = mb.branch_id

		WHERE mafr.tanggal_pengajuan between ? AND ?
		 ";

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code = ? ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.fa_code = ? ";
			$param[] = $majelis;
		}

		if($pembiayaan != '9'){
			$sql .= 'AND mafr.financing_type = ? ';
			$param[] = $pembiayaan;
		}

		//$param[] = $cabang;
		//$param[] = $tanggal;
		

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_pengajuan_pembiayaan($sidx,$sord,$limit_rows,$start,$cabang,$pembiayaan,$petugas,$majelis,$tanggal,$tanggal2){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY mafr.tanggal_pengajuan DESC, mafr.status";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		
		$sql = "SELECT
		mafr.registration_no,
		mafr.rencana_droping,
		mafr.status,
		mafr.tanggal_pengajuan,
		mc.nama,
		mcm.cm_name,
		mafr.amount,
		mafr.financing_type
		FROM mfi_account_financing_reg AS mafr
		JOIN mfi_cif AS mc ON mafr.cif_no = mc.cif_no
		JOIN mfi_cm AS mcm ON mc.cm_code = mcm.cm_code
		JOIN mfi_branch AS mb ON mcm.branch_id = mb.branch_id

		WHERE mafr.tanggal_pengajuan BETWEEN ? AND ? ";

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code = ? ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.fa_code = ? ";
			$param[] = $majelis;
		}

		if($pembiayaan != '9'){
			$sql .= 'AND mafr.financing_type = ? ';
			$param[] = $pembiayaan;
		}

		//$param[] = $tanggal;
		// $param[] = $from;
		// $param[] = $thru;

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END

	// List Registrasi Pembiayaan
	function jqgrid_count_registrasi_pembiayaan($cabang,$pembiayaan,$majelis,$produk,$petugas,$tanggal,$tanggal2){
		$sql = "SELECT
		Count(*) AS num

		FROM mfi_account_financing AS maf

		JOIN mfi_account_financing_reg AS mafr ON mafr.registration_no = maf.registration_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE maf.status_rekening = '1' AND maf.tanggal_registrasi BETWEEN ? AND ? ";

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		}

		

		//$sql .= " ";
		
		//$param[] = $cabang;
		//$param[] = $tanggal;
		

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_registrasi_pembiayaan($sidx,$sord,$limit_rows,$start,$cabang,$pembiayaan,$majelis,$produk,$petugas,$tanggal,$tanggal2){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY maf.tanggal_registrasi,mcm.cm_code, mc.nama";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		
		$sql = "SELECT
		maf.account_financing_no,
		mc.nama,
		maf.tanggal_registrasi,
		maf.pokok,
		maf.margin,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.angsuran_catab,
		maf.jangka_waktu,
		maf.status_rekening,
		mcm.cm_name,
		mcm.cm_code,
		maf.periode_jangka_waktu,
		maf.financing_type,
		mpf.nick_name,
		mpf.product_code,
		mpf.product_name

		FROM mfi_account_financing AS maf

		JOIN mfi_account_financing_reg AS mafr ON mafr.registration_no = maf.registration_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE maf.tanggal_registrasi BETWEEN ? AND ?";

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		}

		//$sql .= "AND maf.tanggal_registrasi BETWEEN ? AND ? ";

		//$param[] = $tanggal;
		// $param[] = $from;
		// $param[] = $thru;

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END


	/****************************************************************************************/	
	// BEGIN REKAP SALDO ANGGOTA 
	/****************************************************************************************/
	public function export_rekap_saldo_anggota_semua_cabang1($branch_code)
	{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					 mfi_branch.branch_code
					,mfi_branch.branch_name
					,(select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="0000"){
				$sql .= " and mfi_account_financing.branch_code = ?";
				$param[] = $branch_code;
			}
			$sql .= "
						) as num
					,(select sum(mfi_account_financing.saldo_pokok) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="0000"){
				$sql .= " and mfi_account_financing.branch_code = ?";
				$param[] = $branch_code;
			}
			$sql .= "
						) as pokok
					,(select sum(mfi_account_financing.saldo_margin) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="0000"){
				$sql .= " and mfi_account_financing.branch_code = ?";
				$param[] = $branch_code;
			}
			$sql .= "
						) as margin
					from mfi_branch
					where (select count(*) from mfi_account_financing,mfi_cif where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_branch.branch_code = mfi_account_financing.branch_code and mfi_account_financing.status_rekening = 1
					";
			if($branch_code!="0000"){
				$sql .= " and mfi_account_financing.branch_code = ?";
				$param[] = $branch_code;
			}
			$sql .= "
						) > 0
					";

					$sql.=" GROUP BY 1,2 ORDER BY mfi_branch.branch_name asc";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
	}
	
	function export_rekap_saldo_anggota_semua_cabang_lalu($branch_code,$tanggal){
		$param = array();

		$sql = "SELECT 
		mb.branch_code,
		mb.branch_name,
		(SELECT
		 COUNT(*)
		 FROM mfi_closing_financing_data AS mcfd
		 JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
		 JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		 WHERE mb.branch_code = maf.branch_code
		 AND maf.status_rekening = 1 AND mcfd.closing_thru_date = ?";

		$param[] = $tanggal;

		if($branch_code != '00000'){
			$sql .= " AND maf.branch_code = ?";
			$param[] = $branch_code;
		}

		$sql .= ") AS num,
		(SELECT
		 SUM(mcfd.saldo_pokok)
		 FROM mfi_closing_financing_data AS mcfd
		 JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
		 JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		 WHERE mb.branch_code = maf.branch_code
		 AND maf.status_rekening = 1 AND mcfd.closing_thru_date = ?";

		$param[] = $tanggal;

		if($branch_code != '00000'){
			$sql .= " AND maf.branch_code = ?";
			$param[] = $branch_code;
		}

		$sql .= ") AS pokok,
		(SELECT
		 SUM(mcfd.saldo_margin)
		 FROM mfi_closing_financing_data AS mcfd
		 JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
		 JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		 WHERE mb.branch_code = maf.branch_code
		 AND maf.status_rekening = 1 AND mcfd.closing_thru_date = ?";

		$param[] = $tanggal;

		if($branch_code != '00000'){
			$sql .= " AND maf.branch_code = ?";
			$param[] = $branch_code;
		}
		$sql .= ") AS margin
		FROM mfi_branch AS mb
		WHERE (SELECT
			   COUNT(*)
			   FROM mfi_closing_financing_data AS mcfd
			   JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
			   JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
			   WHERE mb.branch_code = maf.branch_code
			   AND maf.status_rekening = 1 AND mcfd.closing_thru_date = ?";

		$param[] = $tanggal;

		if($branch_code != '00000'){
			$sql .= " AND maf.branch_code = ?";
			$param[] = $branch_code;
		}

		$sql .= ") > 0 ";
		$sql .= "GROUP BY 1,2 ORDER BY mb.branch_name ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_rekap_saldo_anggota_cabang1($branch_code)
	{
		$param = array();
		$sql = "SELECT 
				 mfi_branch.branch_code
				,mfi_branch.branch_name
				,mfi_branch.branch_class
				,(select count(*) from mfi_account_financing a where a.status_rekening=1 and a.branch_code=mfi_branch.branch_code) as num
				,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a where a.status_rekening=1 and a.branch_code=mfi_branch.branch_code) as pokok
				,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a where a.status_rekening=1 and a.branch_code=mfi_branch.branch_code) as margin
				,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a where a.status_rekening=1 and a.branch_code=mfi_branch.branch_code) as catab
				FROM mfi_branch ";
		if ($branch_code!="00000") {
			$sql .= " WHERE mfi_branch.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$sql .= " order by 3,2";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function export_rekap_saldo_anggota_cabang_lalu($branch_code,$tanggal){

		$sql = "SELECT 
		mb.branch_code,
		mb.branch_name,
		mb.branch_class,
		(SELECT
		 COUNT(*)
		 FROM mfi_closing_financing_data AS mcfd
		 JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
		 WHERE maf.status_rekening = '1'
		 AND maf.branch_code = mb.branch_code
		 AND mcfd.closing_thru_date = ?) AS num,
		(SELECT
		 COALESCE(SUM(mcfd.saldo_pokok),0)
		 FROM mfi_closing_financing_data AS mcfd
		 JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
		 WHERE maf.status_rekening = '1'
		 AND maf.branch_code = mb.branch_code
		 AND mcfd.closing_thru_date = ?) AS pokok,
		(SELECT
		 COALESCE(SUM(mcfd.saldo_margin),0)
		 FROM mfi_closing_financing_data AS mcfd
		 JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
		 WHERE maf.status_rekening = '1'
		 AND branch_code = mb.branch_code
		 AND mcfd.closing_thru_date = ?) AS margin,
		(SELECT
		 COALESCE(SUM(mcfd.saldo_catab),0)
		 FROM mfi_closing_financing_data AS mcfd
		 JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
		 WHERE maf.status_rekening = '1'
		 AND maf.branch_code = mb.branch_code
		 AND mcfd.closing_thru_date = ?) AS catab

		FROM mfi_branch AS mb ";

		$param = array();

		$param[] = $tanggal;
		$param[] = $tanggal;
		$param[] = $tanggal;
		$param[] = $tanggal;

		if($branch_code != '00000') {
			$sql .= "WHERE mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		$sql .= " ORDER BY 3,2";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

		//rembug
		public function export_rekap_saldo_anggota_rembug1($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					mfi_cm.cm_code
					,mfi_cm.cm_name
					,(select count(*) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as num
					,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as pokok
					,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as margin
					,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as catab
					from mfi_cm
					where (select count(*) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) > 0 ";

			$sql.=" GROUP BY 1,2 ORDER BY mfi_cm.cm_name asc";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

		public function export_rekap_saldo_anggota_rembug_lalu($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					mfi_cm.cm_code
					,mfi_cm.cm_name
					,(select count(c.*) from mfi_account_financing a, mfi_cif b, mfi_closing_financing_data c where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code and c.account_financing_no=a.account_financing_no";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as num
					,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as pokok
					,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as margin
					,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as catab
					from mfi_cm
					where (select count(*) from mfi_account_financing a, mfi_cif b where a.cif_no=b.cif_no and a.status_rekening=1 and b.cm_code=mfi_cm.cm_code";
			if($branch_code!="00000"){
				$sql .= " and b.branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) > 0 ";

			$sql.=" GROUP BY 1,2 ORDER BY mfi_cm.cm_name asc";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

		//petugas
		public function export_rekap_saldo_anggota_petugas1($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					mfi_fa.fa_code
					,mfi_fa.fa_name
					,(select count(*) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as num
					,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") as pokok
					,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") as margin
					,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") as catab
					from mfi_fa
					where (select count(*) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") > 0";
			$sql.=" GROUP BY 1,2 ORDER BY mfi_fa.fa_name asc";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

		public function export_rekap_saldo_anggota_petugas_lalu($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					mfi_fa.fa_code
					,mfi_fa.fa_name
					,(select count(*) from mfi_account_financing a, mfi_cif b, mfi_cm c, mfi_closing_financing_data d where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code and d.account_financing_no=a.account_financing_no";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as num
					,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") as pokok
					,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") as margin
					,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") as catab
					from mfi_fa
					where (select count(*) from mfi_account_financing a, mfi_cif b, mfi_cm c where a.cif_no=b.cif_no and b.cm_code=c.cm_code and a.status_rekening=1 and c.fa_code=mfi_fa.fa_code
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= ") > 0";
			$sql.=" GROUP BY 1,2 ORDER BY mfi_fa.fa_name asc";

			$query = $this->db->query($sql,$param);
			return $query->result_array();
		}

		function export_rekap_saldo_anggota_produk1($branch_code){
			$sql = "SELECT mpf.product_name, mpf.product_code,
			COUNT(*) AS num,
			COALESCE(SUM(maf.saldo_pokok),0) AS pokok,
			COALESCE(SUM(maf.saldo_margin),0) AS margin,
			COALESCE(SUM(maf.saldo_catab),0) AS catab
			FROM mfi_account_financing AS maf
			LEFT JOIN mfi_product_financing AS mpf
			ON (mpf.product_code = maf.product_code)
			WHERE maf.status_rekening = '1' ";

			$param = array();

			if($branch_code != '00000'){
				$sql .= "AND maf.branch_code
				IN(SELECT branch_code FROM mfi_branch_member
				WHERE branch_induk = ?)";
				
				$param[] = $branch_code;
			}

			$sql .= "GROUP BY 1,2 ORDER BY 1 ASC";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}


		function export_rekap_saldo_anggota_produk_lalu ($branch_code){
			$sql = "SELECT mpf.product_name, mpf.product_code,
			COUNT(*) AS num,
			COALESCE(SUM(maf.saldo_pokok),0) AS pokok,
			COALESCE(SUM(maf.saldo_margin),0) AS margin,
			COALESCE(SUM(maf.saldo_catab),0) AS catab
			FROM mfi_closing_financing_data AS mcfd
			LEFT JOIN mfi_account_financing AS maf
			ON (mcfd.account_financing_no = maf.account_financing_no)
			LEFT JOIN mfi_product_financing AS mpf
			ON (mpf.product_code = maf.product_code) 
			WHERE maf.status_rekening = '1' ";

			$param = array();

			if($branch_code != '00000'){
				$sql .= "AND maf.branch_code
				IN(SELECT branch_code FROM mfi_branch_member
				WHERE branch_induk = ?)";
				
				$param[] = $branch_code;
			}

			$sql .= "GROUP BY 1,2 ORDER BY 1 ASC";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}

		//peruntukan
		public function export_rekap_saldo_anggota_peruntukan1($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					 code_detail.display_text
					,code_detail.code_value
					,(select count(*) from mfi_account_financing a where a.status_rekening=1 ";

					if($branch_code!="00000"){
						$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
						$param[] = $branch_code;
					}

			$sql .= " and a.peruntukan::varchar=code_detail.code_value) as num
					,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as pokok
					,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as margin
					,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as catab
					from mfi_list_code_detail as code_detail
					where (select count(*) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) > 0 and code_detail.code_group='peruntukan' ";

					$sql.=" GROUP BY 1,2";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
		}


		public function export_rekap_saldo_anggota_peruntukan_lalu($branch_code)
		{
			$tanggal = date('Y-m-d');
			$param = array();
			$sql = "SELECT 
					 code_detail.display_text
					,code_detail.code_value
					,(select count(b.*) from mfi_account_financing a, mfi_closing_financing_data b where a.status_rekening=1 and b.account_financing_no=a.account_financing_no ";

					if($branch_code!="00000"){
						$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
						$param[] = $branch_code;
					}

			$sql .= " and a.peruntukan::varchar=code_detail.code_value) as num
					,(select coalesce(sum(a.saldo_pokok),0) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as pokok
					,(select coalesce(sum(a.saldo_margin),0) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as margin
					,(select coalesce(sum(a.saldo_catab),0) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) as catab
					from mfi_list_code_detail as code_detail
					where (select count(*) from mfi_account_financing a where a.status_rekening=1 and a.peruntukan::varchar=code_detail.code_value
					";
			if($branch_code!="00000"){
				$sql .= " and a.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
			$sql .= " ) > 0 and code_detail.code_group='peruntukan' ";

					$sql.=" GROUP BY 1,2";

					$query = $this->db->query($sql,$param);
					// echo '<pre>';
					// print_r($this->db);
					// die();
					return $query->result_array();
		}

		function export_rekap_saldo_anggota_sektor_usaha1($branch_code){
			$sql = "SELECT mlcd.display_text, COUNT(*) AS num,
			SUM(maf.saldo_pokok) AS pokok,
			SUM(maf.saldo_margin) AS margin,
			SUM(maf.saldo_catab) AS catab
			FROM mfi_account_financing AS maf
			LEFT JOIN mfi_product_financing AS mpf
			ON (mpf.product_code = maf.product_code)
			LEFT JOIN mfi_list_code_detail AS mlcd
			ON (CAST(mlcd.code_value AS INTEGER) = maf.sektor_ekonomi)
			AND mlcd.code_group = 'sektor_ekonomi'
			WHERE maf.status_rekening = '1' ";

			$param = array();

			if($branch_code != '00000'){
				$sql .= "AND maf.branch_code
				IN(SELECT branch_code FROM mfi_branch_member
				WHERE branch_induk = ?)";
				
				$param[] = $branch_code;
			}

			$sql .= "GROUP BY 1 ORDER BY 1 ASC";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}

		function export_rekap_saldo_anggota_sektor_usaha_lalu($branch_code){
			$sql = "SELECT mlcd.display_text, COUNT(*) AS num,
			SUM(maf.saldo_pokok) AS pokok,
			SUM(maf.saldo_margin) AS margin,
			SUM(maf.saldo_catab) AS catab
			FROM mfi_closing_financing_data AS mcfd
			LEFT JOIN mfi_account_financing AS maf
			ON(mcfd.account_financing_no=maf.account_financing_no)
			LEFT JOIN mfi_product_financing AS mpf
			ON (mpf.product_code = maf.product_code)
			LEFT JOIN mfi_list_code_detail AS mlcd
			ON (CAST(mlcd.code_value AS INTEGER) = maf.sektor_ekonomi)
			AND mlcd.code_group = 'sektor_ekonomi'
			WHERE maf.status_rekening = '1' ";

			$param = array();

			if($branch_code != '00000'){
				$sql .= "AND maf.branch_code
				IN(SELECT branch_code FROM mfi_branch_member
				WHERE branch_induk = ?)";
				
				$param[] = $branch_code;
			}

			$sql .= "GROUP BY 1 ORDER BY 1 ASC";

			$query = $this->db->query($sql,$param);

			return $query->result_array();
		}

	/****************************************************************************************/	
	// END REKAP OUTSTANDING PEMBIAYAAN
	/****************************************************************************************/


	// List Pembiayaan
	function jqgrid_count_pembiayaan($cabang,$majelis,$tanggal,$tanggal2,$pembiayaan,$petugas,$peruntukan,$sektor,$produk,$kreditur){
		$sql = "SELECT
		Count(*) AS num

		FROM mfi_account_financing_droping AS mafd

		JOIN mfi_account_financing AS maf
		ON mafd.account_financing_no = maf.account_financing_no		
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_product_financing AS mpf ON maf.product_code = mpf.product_code 
		JOIN mfi_account_financing_reg AS mafr
		ON maf.registration_no = mafr.registration_no AND maf.cif_no=mafr.cif_no
		LEFT JOIN mfi_list_code_detail AS mlcd
		ON CAST(mlcd.code_value AS INTEGER) = maf.peruntukan
		AND mlcd.code_group= 'peruntukan'
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		LEFT JOIN mfi_list_code_detail AS mldc
		ON CAST(mldc.code_value AS INTEGER) = maf.sektor_ekonomi
		AND mldc.code_group= 'sektor_ekonomi'
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code

		WHERE mafd.droping_date BETWEEN ? AND ?
		AND maf.status_rekening <> 0 ";

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		} 
		
		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		} 

		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ? ";
			$param[] = $sektor;
		} 

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		} 

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		

		//$sql .= " ";
		
		//$param[] = $cabang;
		//$param[] = $tanggal;
		

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_pembiayaan($sidx,$sord,$limit_rows,$start,$cabang,$majelis,$tanggal,$tanggal2,$pembiayaan,$petugas,$peruntukan,$sektor,$produk,$kreditur){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY mcm.cm_name,mc.cif_no ASC";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		
		$sql = "SELECT
		mc.nama,
		mafd.droping_date,
		mafd.droping_by,
		mafd.account_financing_no,
		mcm.cm_name,
		mpf.nick_name,
		maf.pokok,
		maf.margin,
		maf.jangka_waktu,
		maf.periode_jangka_waktu, 
		maf.financing_type,
		mafr.pembiayaan_ke, 
		(SELECT g.pokok FROM mfi_account_financing AS g WHERE g.cif_no=mafd.cif_no
		 AND g.tanggal_akad < maf.tanggal_akad ORDER BY g.tanggal_akad DESC
		 LIMIT 1) AS pokok_sebelum,
		mafr.description,
		maf.pengguna_dana,
		mc.no_hp,
		mlcd.display_text AS dtp,
		mldc.display_text AS dts,
		maf.biaya_administrasi,
		maf.biaya_asuransi_jiwa,
		krt.display_text AS krd,
		maf.kreditur_code

		FROM mfi_account_financing_droping AS mafd

		JOIN mfi_account_financing AS maf
		ON mafd.account_financing_no = maf.account_financing_no		
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_product_financing AS mpf ON maf.product_code = mpf.product_code 
		JOIN mfi_account_financing_reg AS mafr
		ON maf.registration_no = mafr.registration_no AND maf.cif_no=mafr.cif_no
		LEFT JOIN mfi_list_code_detail AS mlcd
		ON CAST(mlcd.code_value AS INTEGER) = maf.peruntukan
		AND mlcd.code_group= 'peruntukan'
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		LEFT JOIN mfi_list_code_detail AS mldc
		ON CAST(mldc.code_value AS INTEGER) = maf.sektor_ekonomi
		AND mldc.code_group= 'sektor_ekonomi'
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code

		WHERE mafd.droping_date BETWEEN ? AND ?
		AND maf.status_rekening <> 0 ";

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		} 
		
		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		} 

		if($peruntukan != '00000'){
			$sql .= "AND maf.peruntukan = ? ";
			$param[] = $peruntukan;
		} 

		if($sektor != '00000'){
			$sql .= "AND maf.sektor_ekonomi = ? ";
			$param[] = $sektor;
		} 

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		} 

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		//$sql .= "AND maf.tanggal_registrasi BETWEEN ? AND ? ";

		//$param[] = $tanggal;
		// $param[] = $from;
		// $param[] = $thru;

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END

	// List Angsuran Pembiayaan
	function jqgrid_count_angsuran_pembiayaan($tanggal,$tanggal2,$cabang,$pembiayaan,$majelis,$petugas,$produk,$kreditur){

		if($pembiayaan == 0){
			$sql = "SELECT
			Count(*) AS num

			FROM mfi_trx_cm_detail AS mtcd

			JOIN mfi_account_financing AS maf ON mtcd.account_financing_no = maf.account_financing_no
			JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
			JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
			JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
			JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
			JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
			JOIN mfi_fa AS mf ON mf.fa_code = mtc.fa_code
			JOIN mfi_gl_account_cash AS mgac ON mgac.fa_code = mf.fa_code

			WHERE mtc.trx_date BETWEEN ? AND ?
			AND maf.financing_type = '0' AND mtcd.freq <> '0' ";
			$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

        if($majelis != '00000'){
            $sql .= "AND mcm.cm_code = ? ";
            $param[] = $majelis;
        }

        if($petugas != '00000'){
            $sql .= "AND mgac.account_cash_code = ? ";
            $param[] = $petugas;
        }

        if($produk != '00000'){
            $sql .= "AND mpf.product_code = ? ";
            $param[] = $produk;
        }

        if($kreditur != '11111'){
            $sql .= "AND maf.kreditur_code = ? ";
            $param[] = $kreditur;
        }
		}else{
			$sql = "SELECT
			Count(*) AS num

			from mfi_trx_account_financing mtaf 
			left join mfi_account_financing maf on mtaf.account_financing_no=maf.account_financing_no 
			left join mfi_cif mc on maf.cif_no= mc.cif_no
			left join mfi_cm mcm on mc.cm_code=mcm.cm_code 
			left join mfi_product_financing mpf on maf.product_code= mpf.product_code 
			left JOIN mfi_gl_account_cash mgac ON mgac.account_cash_code = mtaf.account_cash_code
			left join mfi_fa mf ON mf.fa_code = maf.fa_code
			JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id


			WHERE mtaf.trx_date BETWEEN ? AND ?
			AND maf.financing_type = '1' ";
		


		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

        if($majelis != '00000'){
            $sql .= "AND mcm.cm_code = ? ";
            $param[] = $majelis;
        }

        if($petugas != '00000'){
            $sql .= "AND mtaf.account_cash_code = ? ";
            $param[] = $petugas;
        }

        if($produk != '00000'){
            $sql .= "AND mpf.product_code = ? ";
            $param[] = $produk;
        } 

        if($kreditur != '00000'){
            $sql .= "AND maf.kreditur_code = ? ";
            $param[] = $kreditur;
        }
    }

		

		//$sql .= " ";
		
		//$param[] = $cabang;
		//$param[] = $tanggal;
		

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_angsuran_pembiayaan($sidx,$sord,$limit_rows,$start,$tanggal,$tanggal2,$cabang,$pembiayaan,$majelis,$petugas,$produk,$kreditur){
		$order = '';
		$limit = '';

		// if ($sidx!='' && $sord!='') $order = "ORDER BY mtc.trx_date,mc.cm_code ASC";
		// if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		if($pembiayaan == '0'){
		if ($sidx!='' && $sord!='') $order = "ORDER BY mtc.trx_date,mc.cm_code ASC";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";
			$sql = "SELECT
			mtcd.account_financing_no,
			mc.nama,
			mtc.trx_date,
			mcm.cm_name,
			maf.pokok,
			maf.margin,
			maf.jangka_waktu,
			maf.periode_jangka_waktu,
			maf.jtempo_angsuran_last,
			maf.saldo_pokok,
			maf.saldo_margin,
			mpf.nick_name,
			((mtcd.angsuran_pokok * mtcd.freq) + (mtcd.angsuran_margin * mtcd.freq)) AS jml_angsuran,
			(mtcd.angsuran_pokok * mtcd.freq) AS angsuran_pokok,
			(mtcd.angsuran_margin * mtcd.freq) AS angsuran_margin,
			(mtcd.angsuran_catab * mtcd.freq) AS angsuran_catab,
			((mtcd.angsuran_pokok * mtcd.freq) + (mtcd.angsuran_margin * mtcd.freq)) AS jml_bayar,
			mgac.account_cash_name 
			
			FROM mfi_trx_cm_detail AS mtcd

			JOIN mfi_account_financing AS maf ON mtcd.account_financing_no = maf.account_financing_no
			JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
			JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
			JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
			JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
			JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
			JOIN mfi_fa AS mf ON mf.fa_code = mtc.fa_code
			JOIN mfi_gl_account_cash AS mgac ON mgac.fa_code = mf.fa_code
			JOIN mfi_list_code_detail AS lcd ON maf.kreditur_code = lcd.kreditur_code AND lcd.code_group = 'kreditur'


			WHERE mtc.trx_date BETWEEN ? AND ?
			AND maf.financing_type = '0' AND mtcd.freq <> '0' ";

			$param = array();
			$param[] = $tanggal;
			$param[] = $tanggal2;

			if($cabang != '00000'){
				$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
				$param[] = $cabang;
			}

	        if($majelis != '00000'){
	            $sql .= "AND mcm.cm_code = ? ";
	            $param[] = $majelis;
	        }

	        if($petugas != '00000'){
	            $sql .= "AND mgac.account_cash_code = ? ";
	            $param[] = $petugas;
	        }

	        if($produk != '00000'){
	            $sql .= "AND mpf.product_code = ? ";
	            $param[] = $produk;
	        }

	        if($kreditur != '11111'){
	            $sql .= "AND maf.kreditur_code = ? ";
	            $param[] = $kreditur;
	        }

			//$sql .= "AND maf.tanggal_registrasi BETWEEN ? AND ? ";

			//$param[] = $tanggal;
			// $param[] = $from;
			// $param[] = $thru;

			$sql .= "$order $limit";

		} else if($pembiayaan == '1'){
		if ($sidx!='' && $sord!='') $order = "ORDER BY mtaf.trx_date,mc.cm_code ASC";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";
			$sql = "SELECT 
			mtaf.account_financing_no, 
			mc.nama, 
			mtaf.trx_date, 
			mcm.cm_name, 
			maf.pokok, 
			maf.margin, 
			maf.jangka_waktu,
			maf.periode_jangka_waktu, 
			maf.saldo_pokok,
			maf.saldo_margin, 
			mpf.nick_name,
			maf.periode_jangka_waktu,
			maf.jtempo_angsuran_last,
			(mtaf.pokok * mtaf.freq) AS bayar_pokok, 
			(mtaf.margin * mtaf.freq) AS bayar_margin, 
			(mtaf.catab * mtaf.freq) AS bayar_catab, 
			((mtaf.pokok +mtaf.margin+mtaf.catab) * mtaf.freq) AS jml_bayar,
			mgac.account_cash_code, 
			mgac.account_cash_name 
			
			from mfi_trx_account_financing mtaf 
			left join mfi_account_financing maf on mtaf.account_financing_no=maf.account_financing_no 
			left join mfi_cif mc on maf.cif_no= mc.cif_no
			left join mfi_cm mcm on mc.cm_code=mcm.cm_code 
			left join mfi_product_financing mpf on maf.product_code= mpf.product_code 
			left JOIN mfi_gl_account_cash mgac ON mgac.account_cash_code = mtaf.account_cash_code
			left join mfi_fa mf ON mf.fa_code = maf.fa_code
			JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id


			WHERE mtaf.trx_date BETWEEN ? AND ?
			AND maf.financing_type = '1' AND mtaf.trx_financing_type in ( '1','2')";
		


		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

        if($majelis != '00000'){
            $sql .= "AND mcm.cm_code = ? ";
            $param[] = $majelis;
        }

        if($petugas != '00000'){
            $sql .= "AND mtaf.account_cash_code = ? ";
            $param[] = $petugas;
        }

        if($produk != '00000'){
            $sql .= "AND mpf.product_code = ? ";
            $param[] = $produk;
        }

        if($kreditur != '00000'){
            $sql .= "AND maf.kreditur_code = ? ";
            $param[] = $kreditur;
        }

		//$sql .= "AND maf.tanggal_registrasi BETWEEN ? AND ? ";

		//$param[] = $tanggal;
		// $param[] = $from;
		// $param[] = $thru;

		$sql .= "$order $limit";
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END

	// List Angsuran Pembiayaan
	function jqgrid_count_pelunasan_pembiayaan($cabang,$pembiayaan,$petugas,$majelis,$tanggal,$tanggal2,$kreditur){

		$sql = "SELECT
		Count(*) AS num

		FROM mfi_account_financing_lunas AS mafl

		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mafl.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		LEFT JOIN mfi_list_code_detail AS krt
		ON (maf.kreditur_code = krt.code_value)
		AND krt.code_group = 'kreditur'
		WHERE mafl.tanggal_lunas BETWEEN ? AND ? ";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

        if($majelis != '00000'){
            $sql .= "AND mcm.cm_code = ? ";
            $param[] = $majelis;
        }

        if($petugas != '00000'){
            $sql .= "AND mf.fa_code = ? ";
            $param[] = $petugas;
        }

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

        // if($produk != '00000'){
        //     $sql .= "AND mpf.product_code = ? ";
        //     $param[] = $produk;
        // } 

		

		//$sql .= " ";
		
		//$param[] = $cabang;
		//$param[] = $tanggal;
		

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_pelunasan_pembiayaan($sidx,$sord,$limit_rows,$start,$cabang,$pembiayaan,$petugas,$majelis,$tanggal,$tanggal2,$kreditur){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY mafl.tanggal_lunas,maf.account_financing_no ASC";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

			$sql = "SELECT
			mafl.tanggal_lunas,
			maf.account_financing_no,
			mc.nama,
			maf.pokok,
			maf.margin,
			maf.jangka_waktu,
			maf.periode_jangka_waktu,
			maf.tanggal_jtempo,
			maf.counter_angsuran,
			maf.financing_type,
			mcm.cm_name,
			mcm.cm_code,
			maf.branch_code,
			mafl.saldo_pokok,
			maf.angsuran_pokok,
			mafl.saldo_margin,
			mafl.potongan_margin,
			krt.display_text AS krd,
			maf.kreditur_code

			FROM mfi_account_financing_lunas AS mafl
			JOIN mfi_account_financing AS maf ON maf.account_financing_no = mafl.account_financing_no
			JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
			JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
			JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
			LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
			LEFT JOIN mfi_list_code_detail AS krt
			ON (maf.kreditur_code = krt.code_value)
			AND krt.code_group = 'kreditur'
			WHERE mafl.tanggal_lunas BETWEEN ? AND ? ";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($kreditur != '00000'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur;
		} 

		//$sql .= "AND maf.tanggal_registrasi BETWEEN ? AND ? ";

		//$param[] = $tanggal;
		// $param[] = $from;
		// $param[] = $thru;

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END

	// List Jatuh Tempo
	function jqgrid_count_jatuh_tempo($cabang,$pembiayaan,$petugas,$majelis,$tanggal,$tanggal2){

		$sql = "SELECT
		Count(*) AS num

		FROM mfi_account_financing AS maf

		JOIN mfi_cif AS mc ON maf.cif_no = mc.cif_no
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		JOIN mfi_cm AS mcm ON mcm.branch_id = mb.branch_id
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_kecamatan_desa AS mkd ON mcm.desa_code = mkd.desa_code
		WHERE maf.tanggal_jtempo BETWEEN ? AND ? ";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ?";
			$param[] = $majelis;
		}

        // if($produk != '00000'){
        //     $sql .= "AND mpf.product_code = ? ";
        //     $param[] = $produk;
        // }		

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_jatuh_tempo($sidx,$sord,$limit_rows,$start,$cabang,$pembiayaan,$petugas,$majelis,$tanggal,$tanggal2){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " ";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
		maf.account_financing_no,
		mc.nama,
		mcm.cm_name,
		mcm.cm_code,
		(SELECT COUNT(cif_no) FROM mfi_account_financing AS fci WHERE fci.cif_no = mc.cif_no GROUP BY fci.cif_no) AS ke,
		mkd.desa,
		maf.pokok,
		maf.margin,
		maf.jangka_waktu,
		maf.periode_jangka_waktu,
		maf.tanggal_jtempo,
		maf.tanggal_akad,
		maf.branch_code,
		maf.saldo_pokok,
		maf.angsuran_pokok,
		maf.financing_type
		FROM mfi_account_financing AS maf
		JOIN mfi_cif AS mc ON maf.cif_no = mc.cif_no
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		JOIN mfi_cm AS mcm ON mcm.branch_id = mb.branch_id
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_kecamatan_desa AS mkd ON mcm.desa_code = mkd.desa_code
		WHERE maf.tanggal_jtempo BETWEEN ? AND ? ";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ?";
			$param[] = $majelis;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END

	// List Kolektibilitas
	function jqgrid_count_kolektibilitas($date,$branch_code,$kol='all'){

		$sql = "SELECT
		Count(*) AS num

		FROM mfi_par a

		LEFT JOIN mfi_account_financing b
		ON b.account_financing_no = a.account_financing_no
		LEFT JOIN mfi_account_financing_droping c
		ON c.account_financing_no = a.account_financing_no
		LEFT JOIN mfi_cif d ON d.cif_no = b.cif_no
		LEFT JOIN mfi_cm e ON e.cm_code = d.cm_code
		WHERE a.tanggal_hitung = ?";
		

		$param = array();
		$param[] = $date;
		$param[] = $date;

		if($branch_code!="00000"){
			$sql .= " AND a.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		if($kol!="all"){
			$sql .= " AND a.par_desc = ?";
			$param[] = $kol;
		}

        // if($produk != '00000'){
        //     $sql .= "AND mpf.product_code = ? ";
        //     $param[] = $produk;
        // }		

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_kolektibilitas($sidx,$sord,$limit_rows,$start,$date,$branch_code,$kol='all'){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " ORDER BY b.account_financing_no";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
		b.account_financing_no,
		d.nama,
		b.pokok,
		b.margin,
		b.jangka_waktu,
		b.tanggal_mulai_angsur,
		b.saldo_pokok,
		b.saldo_margin,
		c.droping_date,
		b.angsuran_pokok,
		b.angsuran_margin,
		CAST((b.pokok - a.saldo_pokok) / b.angsuran_pokok AS INTEGER) AS terbayar,
		(((? - b.tanggal_mulai_angsur) / 7) + 1) AS seharusnya,
		a.saldo_pokok,
		a.saldo_margin,
		a.hari_nunggak,
		a.freq_tunggakan,
		a.tunggakan_pokok,
		a.tunggakan_margin,
		a.par_desc,
		a.par,
		a.cadangan_piutang,
		e.cm_name
		FROM mfi_par a
		LEFT JOIN mfi_account_financing b
		ON b.account_financing_no = a.account_financing_no
		LEFT JOIN mfi_account_financing_droping c
		ON c.account_financing_no = a.account_financing_no
		LEFT JOIN mfi_cif d ON d.cif_no = b.cif_no
		LEFT JOIN mfi_cm e ON e.cm_code = d.cm_code
		WHERE a.tanggal_hitung = ?";
		

		$param = array();
		$param[] = $date;
		$param[] = $date;

		if($branch_code!="00000"){
			$sql .= " AND a.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?)";
			$param[] = $branch_code;
		}

		if($kol!="all"){
			$sql .= " AND a.par_desc = ?";
			$param[] = $kol;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END


	// List Saldo Anggota
	function jqgrid_count_saldo_anggota($branch_code,$fa_code,$cm_code){

		$sql = "SELECT
		Count(*) AS num

		FROM mfi_cif AS mc

		LEFT JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_kecamatan_desa AS mkd ON mkd.desa_code = mcm.desa_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mc.status <> 2 ";
		

		$param = array();
		//$param[] = $branch_code;
		// $param[] = $tanggal2;

		if($branch_code!="00000"){
			$sql .= "AND mc.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($fa_code != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $fa_code;
		}

		if($cm_code!="" || $cm_code!=false){
			$sql .= "AND mc.cm_code = ? ";
			$param[] = $cm_code;
		}	

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_saldo_anggota($sidx,$sord,$limit_rows,$start,$branch_code,$fa_code,$cm_code){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " ORDER BY mc.cif_no ";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		mkd.desa,
		madb.setoran_lwk,
		madb.simpanan_pokok,
		madb.tabungan_minggon,
		madb.tabungan_sukarela,
		madb.tabungan_kelompok,
		(SELECT SUM(saldo_pokok) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS saldo_pokok,
		(SELECT SUM(saldo_margin) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS saldo_margin,
		(SELECT SUM(pokok) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS pokok,
		(SELECT SUM(margin) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS margin,
		(SELECT SUM(saldo_memo) FROM mfi_account_saving WHERE cif_no = mc.cif_no AND product_code='0099' AND status_rekening = '1') AS saldo_dtk, 
		(SELECT SUM(saldo_memo) FROM mfi_account_saving WHERE cif_no = mc.cif_no AND product_code<>'0099' AND status_rekening = '1') AS saldo_taber   

		FROM mfi_cif AS mc

		LEFT JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_kecamatan_desa AS mkd ON mkd.desa_code = mcm.desa_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mc.status <> 2 ";
		

		$param = array();
		//$param[] = $branch_code;
		// $param[] = $tanggal2;

		if($branch_code!="00000"){
			$sql .= "AND mc.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($fa_code != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $fa_code;
		}

		if($cm_code!="" || $cm_code!=false){
			$sql .= "AND mc.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_list_saldo_anggota_bulan_lalu($sidx,$sord,$limit_rows,$start,$branch_code,$fa_code,$cm_code){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " ORDER BY mc.cif_no ";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		mkd.desa,
		madb.setoran_lwk,
		madb.simpanan_pokok,
		madb.tabungan_wajib AS tabungan_minggon,
		madb.tabungan_sukarela, 
		madb.tabungan_kelompok,
		(SELECT SUM(saldo_pokok) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS saldo_pokok,
		(SELECT SUM(saldo_margin) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS saldo_margin,
		(SELECT SUM(pokok) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS pokok,
		(SELECT SUM(margin) FROM mfi_account_financing WHERE cif_no = mc.cif_no AND status_rekening = '1') AS margin 

		FROM mfi_cif AS mc

		LEFT JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_kecamatan_desa AS mkd ON mkd.desa_code = mcm.desa_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mc.status <> 2 ";
		

		$param = array();
		//$param[] = $branch_code;
		// $param[] = $tanggal2;

		if($branch_code!="00000"){
			$sql .= "AND mc.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($fa_code != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $fa_code;
		}

		if($cm_code!="" || $cm_code!=false){
			$sql .= "AND mc.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}


	// END


	// List Anggota Masuk
	function jqgrid_count_anggota_masuk($cabang,$majelis,$tanggal,$tanggal2){

		$sql = "SELECT
		Count(*) AS num

		FROM mfi_cif AS mc
		
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.tgl_gabung BETWEEN ? AND ?  ";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ?";
			$param[] = $majelis;
		}	

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}



	// count Anggota absen
	function jqgrid_count_anggota_absen($cabang,$majelis,$tanggal,$tanggal2){
		$param = array();

		$sql = "SELECT
		COUNT(*) AS num
		FROM mfi_absen_report AS mar
		LEFT JOIN mfi_cif AS mc on mar.cif_no = mc.cif_no 
		LEFT JOIN mfi_cm AS mcm on mc.cm_code = mcm.cm_code  
		WHERE mar.cif_no <> '0' AND mar.absen_from_date = ? AND mar.absen_thru_date = ? ";

		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($majelis != 'all'){
			$sql .= "AND mc.cm_code = ?";
			$param[] = $majelis;
		}	

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}



	function jqgrid_list_anggota_masuk($sidx,$sord,$limit_rows,$start,$cabang,$majelis,$tanggal,$tanggal2){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " ORDER BY mc.cif_no";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		mc.tgl_gabung,
		mc.jenis_kelamin,
		mc.ibu_kandung,
		mc.tmp_lahir,
		mc.tgl_lahir,
		mc.usia,
		mc.alamat
		FROM mfi_cif AS mc
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.tgl_gabung BETWEEN ? AND ? ";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ?";
			$param[] = $majelis;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END 


	function jqgrid_list_anggota_absen($sidx,$sord,$limit_rows,$start,$cabang,$majelis,$tanggal,$tanggal2){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " ORDER BY mc.cif_no";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$param = array();

		$sql = "SELECT
		mar.cif_no,
		mc.nama,
		mc.branch_code,
		mc.cm_code,
		mcm.cm_name,
		mc.tgl_gabung,
		mar.h,
		mar.i,
		mar.s,
		mar.a
		FROM mfi_absen_report AS mar
		LEFT JOIN mfi_cif AS mc ON mar.cif_no = mc.cif_no
		LEFT JOIN mfi_cm AS mcm ON mc.cm_code = mcm.cm_code
		WHERE mar.cif_no <> '0' AND mar.absen_from_date = ? AND mar.absen_thru_date = ? ";

		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($majelis != 'all'){
			$sql .= "AND mc.cm_code = ?";
			$param[] = $majelis;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END


	// List Anggota Keluar
	function jqgrid_count_anggota_keluar($branch_code,$cm_code,$tanggal,$tanggal2,$alasan){

		$sql = "SELECT
		Count(*) AS num

		from mfi_cif_mutasi  a

		left join  mfi_cif b on a.cif_no=b.cif_no
		left join mfi_cm c on b.cm_code = c.cm_code				
		WHERE a.tipe_mutasi = 1 AND a.tanggal_mutasi BETWEEN ? AND ? ";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($branch_code!="00000"){
			$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($cm_code!="all"){
			$sql .= " AND b.cm_code = ? ";
			$param[] = $cm_code;
		}
		// if($from_date!="" && $thru_date!=""){
		// 	$sql .= " AND a.tanggal_mutasi BETWEEN ? AND ? ";
		// 	$param[] = $from_date;
		// 	$param[] = $thru_date;
		// }
		if($alasan!='' && $alasan!='-'){
			$sql .= " AND a.alasan = ? ";
			$param[] = $alasan;			
		}

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_count_anggota_mutasi($branch_code,$cm_code,$tanggal,$tanggal2,$alasan){

		$sql = "SELECT
		Count(*) AS num

		from mfi_cif_mutasi  a

		left join  mfi_cif b on a.cif_no=b.cif_no
		left join mfi_cm c on b.cm_code = c.cm_code				
		WHERE a.tipe_mutasi = 1 AND a.tanggal_mutasi BETWEEN ? AND ? ";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($branch_code!="00000"){
			$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($cm_code!="all"){
			$sql .= " AND b.cm_code = ? ";
			$param[] = $cm_code;
		}
		// if($from_date!="" && $thru_date!=""){
		// 	$sql .= " AND a.tanggal_mutasi BETWEEN ? AND ? ";
		// 	$param[] = $from_date;
		// 	$param[] = $thru_date;
		// }
		if($alasan!='' && $alasan!='-'){
			$sql .= " AND a.alasan = ? ";
			$param[] = $alasan;			
		}

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_anggota_keluar($sidx,$sord,$limit_rows,$start,$branch_code,$cm_code,$tanggal,$tanggal2,$alasan){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " ORDER BY a.tanggal_mutasi, c.cm_name, b.nama";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
		a.cif_no,
		b.nama,
		c.cm_name,
		b.tgl_gabung, 
		a.tanggal_mutasi,
		a.description alasan_keluar,
		(SELECT display_text FROM mfi_list_code_detail WHERE code_group='anggotakeluar' AND code_value=a.alasan) alasan,
		(select account_financing_no from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) account_financing_no_last,
		(select pembiayaan_ke from mfi_account_financing_reg where cif_no=a.cif_no order by pembiayaan_ke desc limit 1) pembiayaan_ke_last, 
		(select tanggal_akad from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) tanggal_akad_last,
		(select pokok from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) pokok_last,
		(select jangka_waktu from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) jangka_waktu_last 
		from mfi_cif_mutasi  a 
		left join  mfi_cif b on a.cif_no=b.cif_no
		left join mfi_cm c on b.cm_code = c.cm_code				
		WHERE a.tipe_mutasi = 1 AND a.tanggal_mutasi BETWEEN ? AND ?
		";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($branch_code!="00000"){
			$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($cm_code!="all"){
			$sql .= " AND b.cm_code = ? ";
			$param[] = $cm_code;
		}
		// if($from_date!="" && $thru_date!=""){
		// 	$sql .= " AND a.tanggal_mutasi BETWEEN ? AND ? ";
		// 	$param[] = $from_date;
		// 	$param[] = $thru_date;
		// }
		if($alasan!='' && $alasan!='-'){
			$sql .= " AND a.alasan = ? ";
			$param[] = $alasan;			
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END


	function jqgrid_list_anggota_mutasi($sidx,$sord,$limit_rows,$start,$branch_code,$cm_code,$tanggal,$tanggal2,$alasan){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " ORDER BY a.tanggal_mutasi, c.cm_name, b.nama";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
		a.cif_no, b.nama, c.cm_name rembug_lama, d.cm_name rembug_baru, b.tgl_gabung, a.tanggal_mutasi, a.description keterangan, 
		(SELECT display_text FROM mfi_list_code_detail WHERE code_group='anggotakeluar' AND code_value=a.alasan) alasan_mutasi,
		(select account_financing_no from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) account_financing_no_last,
		(select pembiayaan_ke from mfi_account_financing_reg where cif_no=a.cif_no order by pembiayaan_ke desc limit 1) pembiayaan_ke_last, 
		(select tanggal_akad from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) tanggal_akad_last,
		(select pokok from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) pokok_last,
		(select jangka_waktu from mfi_account_financing  where cif_no=a.cif_no order by tanggal_akad desc limit 1 ) jangka_waktu_last 
		from mfi_cif_mutasi  a 
		left join  mfi_cif b on a.cif_no=b.cif_no
		left join mfi_cm c on a.cm_code = c.cm_code	
		left join mfi_cm d on a.cm_code_baru = d.cm_code				
		WHERE a.tipe_mutasi = 2 AND a.tanggal_mutasi BETWEEN ? AND ?
		";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($branch_code!="00000"){
			$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if($cm_code!="all"){
			$sql .= " AND b.cm_code = ? ";
			$param[] = $cm_code;
		}
		// if($from_date!="" && $thru_date!=""){
		// 	$sql .= " AND a.tanggal_mutasi BETWEEN ? AND ? ";
		// 	$param[] = $from_date;
		// 	$param[] = $thru_date;
		// }
		if($alasan!='' && $alasan!='-'){
			$sql .= " AND a.alasan = ? ";
			$param[] = $alasan;			
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END



	// List Buka Tabungan
	function jqgrid_count_list_buka_tabugan($produk,$tanggal,$tanggal2,$branch_code){

		$sql = "SELECT
		Count(*) AS num

		FROM mfi_account_saving AS mas

		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mas.status_rekening = '1' AND mas.tanggal_buka BETWEEN ? AND ? ";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($produk!="0000"){
			$sql .= "AND mps.product_code = ? ";
			$param[] = $produk;
		}

		// if($from_date!="" && $thru_date!=""){
		// 	$sql .= " ";
		// 	$param[] = $from_date;
		// 	$param[] = $thru_date;
		// }

		if($branch_code!="0000"){
			$sql .= "AND mc.branch_code=? ";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_buka_tabungan($sidx,$sord,$limit_rows,$start,$produk,$tanggal,$tanggal2,$branch_code){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " GROUP BY 1,2,3,4,5,6,7,8,9,10
		ORDER BY mas.tanggal_buka ASC";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
		mas.account_saving_no,
		mc.nama,
		mcm.cm_name,
		mps.product_name,
		mas.tanggal_buka,
		mas.rencana_jangka_waktu,
		(mas.tanggal_buka + mas.rencana_jangka_waktu) AS tanggal_jtempo,
		mas.rencana_setoran,
		mas.status_rekening,
		mas.saldo_memo
		FROM mfi_account_saving AS mas
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mas.status_rekening = '1' AND mas.tanggal_buka BETWEEN ? AND ? ";
		

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($produk!="0000"){
			$sql .= "AND mps.product_code = ? ";
			$param[] = $produk;
		}

		// if($from_date!="" && $thru_date!=""){
		// 	$sql .= " ";
		// 	$param[] = $from_date;
		// 	$param[] = $thru_date;
		// }

		if($branch_code!="0000"){
			$sql .= "AND mc.branch_code=? ";
			$param[] = $branch_code;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END

	// List Buka Tabungan Jtempo
	function jqgrid_count_list_buka_tabugan_jtempo($produk,$tanggal,$tanggal2,$branch_code, $status,$rembug){

		$sql = "SELECT
		Count(*) AS num

		FROM 
			mfi_account_saving AS mas
			LEFT JOIN mfi_product_saving AS mps
			ON mps.product_code = mas.product_code
			LEFT JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
			LEFT JOIN mfi_cm AS cm ON mc.cm_code = cm.cm_code
			WHERE mas.status_rekening=1 ";
		

		$param = array();
		// $param[] = $tanggal;
		// $param[] = $tanggal2;

		if($produk!="0000"){
			$sql .= " AND mps.product_code = ?";
			$param[] = $produk;
		}
		if($tanggal!="" && $tanggal2!=""){
			$sql .= " AND (mas.tanggal_buka + (mas.rencana_jangka_waktu * 7))
			BETWEEN ? AND ?";
			$param[] = $tanggal;
			$param[] = $tanggal2;
		}
		if($branch_code!="0000"){
				
			$sql .= " AND mas.branch_code=?";
			$param[] = $branch_code;
		}
		if($status !="9"){
			$sql .= " AND mas.status_rekening = ?";
			$param[] = $status;
		}
		if($rembug != "0000"){
			$sql .= " AND cm.cm_code = ?";
			$param[] = $rembug;
		}

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_buka_tabungan_jtempo($sidx,$sord,$limit_rows,$start,$produk,$tanggal,$tanggal2,$branch_code,$status,$rembug){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " ORDER BY mas.tanggal_buka,mas.rencana_akhir_kontrak ASC ";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
				mps.*,
				mas.*,
				mc.nama,
				cm.cm_code,
				cm.cm_name
				FROM 
				mfi_account_saving AS mas
				LEFT JOIN mfi_product_saving AS mps
				ON mps.product_code = mas.product_code
				LEFT JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
				LEFT JOIN mfi_cm AS cm ON mc.cm_code = cm.cm_code
				WHERE mas.status_rekening=1 ";
		

		$param = array();
		// $param[] = $tanggal;
		// $param[] = $tanggal2;

		if($produk!="0000"){
			$sql .= " AND mps.product_code = ?";
			$param[] = $produk;
		}
		if($tanggal!="" && $tanggal2!=""){
			$sql .= " AND (mas.tanggal_buka + (mas.rencana_jangka_waktu * 7))
			BETWEEN ? AND ?";
			$param[] = $tanggal;
			$param[] = $tanggal2;
		}
		if($branch_code!="0000"){
				
			$sql .= " AND mas.branch_code=?";
			$param[] = $branch_code;
		}
		if($status != "9"){
			$sql .= " AND mas.status_rekening=?";
			$param[] = $status;
		}
		if($rembug != "0000"){
			$sql .= " AND cm.cm_code = ?";
			$param[] = $rembug;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END

	// List Pembukaan Tabungan
	function jqgrid_count_list_pembukaan_tabungan($produk,$branch_code){

		$sql = "SELECT
		Count(*) AS num

		FROM mfi_account_saving AS mas

		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		WHERE mas.status_rekening = 1  ";
		

		$param = array();
		// $param[] = $tanggal;
		// $param[] = $tanggal2;

		if($produk != 'all'){
			$sql .= "AND mas.product_code = ? ";
			$param[] = $produk;
		}

		if($branch_code != '00000'){
			$sql.="AND mc.branch_code in(SELECT branch_code FROM mfi_branch_member
			WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_pembukaan_tabungan($sidx,$sord,$limit_rows,$start,$produk,$branch_code){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " ORDER BY 2,1,6 ";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
		mps.product_name,
		mcm.cm_name,
		mas.account_saving_no,
		mas.status_rekening,
		mas.saldo_memo,
		mc.nama,
		mas.rencana_jangka_waktu,
		mas.rencana_setoran,
		mas.counter_angsruan,
		mas.tanggal_buka
		FROM mfi_account_saving AS mas
		JOIN mfi_product_saving AS mps ON mps.product_code = mas.product_code
		JOIN mfi_cif AS mc ON mc.cif_no = mas.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		WHERE mas.status_rekening = 1 ";
		

		$param = array();
		// $param[] = $tanggal;
		// $param[] = $tanggal2;

		if($produk != 'all'){
			$sql .= "AND mas.product_code = ? ";
			$param[] = $produk;
		}

		if($branch_code != '00000'){
			$sql.="AND mc.branch_code in(SELECT branch_code FROM mfi_branch_member
			WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END

	// BEGIN List Wakalah | T | TGL 07-09-2017
	function export_list_wakalah($from,$thru,$cabang,$majelis,$pembiayaan,$petugas,$produk){
		$sql = "SELECT 
		mafw.account_financing_wakalah_id,
		maf.account_financing_no,
		mafw.status_wakalah,
		mafw.tanggal_wakalah,
		mafw.account_cash_code,
		mc.nama,
		mcm.cm_name,
		mpf.product_name,
		maf.pokok As jumlah_wakalah,
		mf.fa_name


		FROM mfi_account_financing_wakalah AS mafw

		LEFT JOIN mfi_account_financing AS maf ON maf.account_financing_no = mafw.account_financing_no
		LEFT JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		LEFT JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code

		
		";

		$param = array();

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		}

		$sql .= "AND maf.tanggal_registrasi BETWEEN ? AND ? ";

		$param[] = $from;
		$param[] = $thru;

		$sql .= "ORDER BY mafw.tanggal_wakalah, maf.account_financing_no, mc.nama, mcm.cm_name, mpf.product_name, jumlah_wakalah, mf.fa_name, mafw.status_wakalah";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_count_wakalah($cabang,$pembiayaan,$majelis,$produk,$petugas,$tanggal,$tanggal2){
		$sql = "SELECT
		Count(*) AS num

		FROM mfi_account_financing_wakalah AS mafw

		LEFT JOIN mfi_account_financing AS maf ON maf.account_financing_no = mafw.account_financing_no
		LEFT JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		LEFT JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code

		WHERE maf.tanggal_registrasi BETWEEN ? AND ? ";

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		}

		

		//$sql .= " ";
		
		//$param[] = $cabang;
		//$param[] = $tanggal;
		

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_wakalah($sidx,$sord,$limit_rows,$start,$cabang,$pembiayaan,$majelis,$produk,$petugas,$tanggal,$tanggal2){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY mafw.tanggal_wakalah, maf.account_financing_no, mc.nama, mcm.cm_name, mpf.product_name, jumlah_wakalah, mf.fa_name, mafw.status_wakalah";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = " SELECT 
		mafw.account_financing_wakalah_id,
		maf.account_financing_no,
		mafw.status_wakalah,
		mafw.tanggal_wakalah,
		mafw.account_cash_code,
		mc.nama,
		mcm.cm_name,
		mpf.product_name,
		maf.pokok As jumlah_wakalah,
		mf.fa_name


		FROM mfi_account_financing_wakalah AS mafw

		LEFT JOIN mfi_account_financing AS maf ON maf.account_financing_no = mafw.account_financing_no
		LEFT JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		LEFT JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		LEFT JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code

		WHERE maf.tanggal_registrasi BETWEEN ? AND ?


		";

		$param = array();
		$param[] = $tanggal;
		$param[] = $tanggal2;

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($produk != '00000'){
			$sql .= "AND mpf.product_code = ? ";
			$param[] = $produk;
		}

		//$sql .= "AND maf.tanggal_registrasi BETWEEN ? AND ? ";

		//$param[] = $tanggal;
		// $param[] = $from;
		// $param[] = $thru;

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	// END

	function export_lembar_absensi_anggota($branch_code,$fa_code,$cm_code){
		$param = array();

		$sql = "SELECT
		mc.cif_no,
		mcm.cm_name,
		mc.nama
		FROM mfi_cif AS mc
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.status = '1' ";

		if($branch_code != '00000'){
			$sql .= "AND mc.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		if($fa_code != '00000'){
			$sql .= "AND mcm.fa_code = ? ";
			$param[] = $fa_code;
		}

		if($cm_code != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $cm_code;
		}

		$query = $this->db->query($sql,$param);    
		return $query->result_array();
	}


	/***************************************************************************************/
	//BEGIN PROYEKSI DROPING
	//Author : Aiman
	//Tgl    : 29 - 05 - 18
	/***************************************************************************************/

	function export_lap_proyeksi_droping($branch_code, $year){
		$sql = "SELECT a.proyeksi_droping_id, a.branch_code, b.branch_name, a.year, a.month, a.account_target, a.amount_target, a.created_by, a.created_date,
				a.account_real, a.amount_real
				FROM mfi_proyeksi_droping AS a
				JOIN mfi_branch AS b ON a.branch_code = b.branch_code
				WHERE a.proyeksi_droping_id <> '' ";
	
		$param = array();

		if($branch_code != '9999'){
			$sql .= "AND a.branch_code = ? ";
			$param[] = $branch_code;
		}

		if($year != '00000'){
			$sql .= "AND a.year = ? ";
			$param[] = $year;
		}

		$sql .= "ORDER BY a.branch_code, a.year, a.month";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function export_lap_proyeksi_droping_pusat($branch_code, $year)
	{
		$sql = "SELECT a.month, a.year, sum(a.account_target) AS account_target, sum(a.amount_target) AS amount_target,
				sum(a.account_real) AS account_real, sum(a.amount_real) AS amount_real
				FROM mfi_proyeksi_droping AS a
				JOIN mfi_branch AS b ON a.branch_code = b.branch_code
				WHERE a.proyeksi_droping_id <> '' ";
	
		$param = array();

		if($year != '00000'){
			$sql .= "AND a.year = ? ";
			$param[] = $year;
		}

		$sql .= "GROUP BY a.month, a.year ORDER BY a.month";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_count_lap_proyeksi_droping($cabang,$year,$sort,$sidx,$limit_rows){
		$sql = "SELECT COUNT(*) AS num
				FROM mfi_proyeksi_droping AS a
				JOIN mfi_branch AS b ON a.branch_code = b.branch_code
				WHERE a.proyeksi_droping_id <> ''
		 ";

		$param = array();

		if($cabang != '9999'){
			$sql .= "AND a.branch_code = ? ";
			$param[] = $cabang;
		}

		if($year != '00000'){
			$sql .= "AND a.year = ? ";
			$param[] = $year;
		}

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		return $row['num'];
	}

	function jqgrid_list_lap_proyeksi_droping($sidx,$sord,$limit_rows,$start,$cabang,$year){
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY a.branch_code, a.month, a.year";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		
		$sql = "SELECT a.proyeksi_droping_id, a.branch_code, b.branch_name, a.year, a.month, a.account_target, a.amount_target, a.created_by, a.created_date,
				a.account_real, a.amount_real
				FROM mfi_proyeksi_droping AS a
				JOIN mfi_branch AS b ON a.branch_code = b.branch_code
				WHERE a.proyeksi_droping_id <> ''  ";

		$param = array();

		if($cabang != '9999'){
			$sql .= "AND b.branch_code = ? ";
			$param[] = $cabang;
		}

		if($year != '00000'){
			$sql .= "AND a.year = ? ";
			$param[] = $year;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_list_lap_proyeksi_droping_pusat($sidx,$sord,$limit_rows,$start,$cabang,$year){
		$order = '';
		$limit = '';

		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		
		$sql = "SELECT a.month, a.year, sum(a.account_target) AS account_target, sum(a.amount_target) AS amount_target,
				sum(a.account_real) AS account_real, sum(a.amount_real) AS amount_real
				FROM mfi_proyeksi_droping AS a
				JOIN mfi_branch AS b ON a.branch_code = b.branch_code
				WHERE a.proyeksi_droping_id <> ''  ";

		$param = array();	

		if($year != '00000'){
			$sql .= "AND a.year = ? ";
			$param[] = $year;
		}

		$sql .= "GROUP BY a.month, a.year ORDER BY a.month $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	/***************************************************************************************/
	//END PROYEKSI DROPING
	/***************************************************************************************/

	function export_list_api_debitur($cabang,$pembiayaan,$petugas,$majelis,$kreditur_code,$status_pyd_kreditur){
		$param = array(); 

		$sql = "SELECT
		mc.nama,
		mc.no_ktp,
		mc.desa,
		mafd.droping_date,
		mafd.droping_by,
		maf.account_financing_no,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.saldo_pokok,
		maf.saldo_margin,
		maf.saldo_catab,
		maf.status_kolektibilitas,
		maf.margin,
		maf.pokok,
		maf.dana_kebajikan,
		maf.financing_type,
		maf.jangka_waktu, 
		maf.tanggal_jtempo,
		mlcd.display_text AS peruntukan,
		fice.display_text AS sektor,
		mcm.cm_name,
		mf.fa_name,
		mpf.nick_name,  
		CAST((maf.saldo_pokok / maf.angsuran_pokok) AS INTEGER) AS freq_bayar_saldo,
		maf.counter_angsuran AS freq_bayar_pokok, 
		krt.display_text AS krd,
		maf.kreditur_code,
		maf.status_pyd_kreditur
		FROM mfi_account_financing AS maf
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR) AND mlcd.code_group = 'peruntukan'
		JOIN mfi_list_code_detail AS fice ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR) AND fice.code_group = 'sektor_ekonomi'
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_list_code_detail AS krt ON (maf.kreditur_code = krt.code_value) AND krt.code_group = 'kreditur'
		WHERE maf.status_rekening = '1' ";

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code
			FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($pembiayaan != '9'){
			$sql .= "AND maf.financing_type = ? ";
			$param[] = $pembiayaan;
		}

		if($petugas != '00000'){
			$sql .= "AND mf.fa_code = ? ";
			$param[] = $petugas;
		}

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		if($kreditur_code != '9'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur_code;
		}

		if($status_pyd_kreditur != '9'){
			$sql .= "AND maf.status_pyd_kreditur = ? ";
			$param[] = $status_pyd_kreditur;
		}

		$sql .= "ORDER BY mb.branch_code,mcm.cm_name";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function export_list_api_debitur_not_reject($kreditur_code,$batch_no,$status_pyd_kreditur,$branch_code){
		$param = array(); 

		$sql = "SELECT
		mb.branch_name,
		mc.nama,
		mc.no_ktp,
		mc.desa,
		mafd.droping_date,
		mafd.droping_by,
		maf.account_financing_no,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.saldo_pokok,
		maf.saldo_margin,
		maf.saldo_catab,
		maf.status_kolektibilitas,
		maf.margin,
		maf.pokok,
		maf.dana_kebajikan,
		maf.financing_type,
		maf.jangka_waktu, 
		maf.tanggal_jtempo,
		mlcd.display_text AS peruntukan,
		fice.display_text AS sektor,
		mcm.cm_name,
		mf.fa_name,
		mpf.nick_name,  
		CAST((maf.saldo_pokok / maf.angsuran_pokok) AS INTEGER) AS freq_bayar_saldo,
		maf.counter_angsuran AS freq_bayar_pokok, 
		krt.display_text AS krd,
		maf.kreditur_code,
		(CASE WHEN maf.status_pyd_kreditur = '0' THEN
			'Registrasi'
		 WHEN maf.status_pyd_kreditur = '1' THEN
		 	'Aktif'
		 WHEN maf.status_pyd_kreditur = '3' THEN
		 	'Pengajuan'
		END) AS status_pyd_kreditur
		FROM mfi_account_financing AS maf
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR) AND mlcd.code_group = 'peruntukan'
		JOIN mfi_list_code_detail AS fice ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR) AND fice.code_group = 'sektor_ekonomi'
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_list_code_detail AS krt ON (maf.kreditur_code = krt.code_value) AND krt.code_group = 'kreditur'
		WHERE maf.status_rekening = '1' AND maf.batch_no = ? ";

		$param[] = $batch_no;

		if($kreditur_code != '9'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur_code;
		}

		if($branch_code <> '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		if($status_pyd_kreditur != '9'){
			$sql .= "AND maf.status_pyd_kreditur = ? ";
			$param[] = $status_pyd_kreditur;
		}

		$sql .= "ORDER BY mb.branch_code,mcm.cm_name";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function export_list_api_debitur_reject($kreditur_code,$batch_no,$branch_code){
		$param = array(); 

		$sql = "SELECT
		mb.branch_name,
		mc.nama,
		mc.no_ktp,
		mc.desa,
		mafd.droping_date,
		mafd.droping_by,
		maf.account_financing_no,
		maf.angsuran_pokok,
		maf.angsuran_margin,
		maf.saldo_pokok,
		maf.saldo_margin,
		maf.saldo_catab,
		maf.status_kolektibilitas,
		maf.margin,
		maf.pokok,
		maf.dana_kebajikan,
		maf.financing_type,
		maf.jangka_waktu, 
		maf.tanggal_jtempo,
		mlcd.display_text AS peruntukan,
		fice.display_text AS sektor,
		mcm.cm_name,
		mf.fa_name,
		mpf.nick_name,  
		CAST((maf.saldo_pokok / maf.angsuran_pokok) AS INTEGER) AS freq_bayar_saldo,
		maf.counter_angsuran AS freq_bayar_pokok, 
		krt.display_text AS krd,
		maf.kreditur_code,
		'Tolak' AS status_pyd_kreditur
		FROM mfi_account_financing_kreditur AS mafk
		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mafk.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_account_financing_droping AS mafd ON maf.account_financing_no = mafd.account_financing_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = CAST(maf.peruntukan AS VARCHAR) AND mlcd.code_group = 'peruntukan'
		JOIN mfi_list_code_detail AS fice ON fice.code_value = CAST(maf.sektor_ekonomi AS VARCHAR) AND fice.code_group = 'sektor_ekonomi'
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		LEFT JOIN mfi_list_code_detail AS krt ON (maf.kreditur_code = krt.code_value) AND krt.code_group = 'kreditur'
		WHERE maf.status_rekening = '1' AND maf.batch_no = ? ";

		$param[] = $batch_no;

		if($kreditur_code != '9'){
			$sql .= "AND maf.kreditur_code = ? ";
			$param[] = $kreditur_code;
		}

		if($branch_code <> '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}

		$sql .= "ORDER BY mb.branch_code,mcm.cm_name";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
}