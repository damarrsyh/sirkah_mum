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
		fn_get_saldoawal_kaspetugas(a.account_cash_code,?,0) as saldoawal,
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

		$query = $this->db->query($sql,array($tanggal,$tanggal,$tanggal2,$account_cash_code));	
		// print_r($this->db);
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
	function export_keuangan_neraca_bulanan($branch_code,$last_date,$report_code){
		$param = array(); 

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
			                 then sum(c.saldo)*-1         
			              else  
			                 sum(c.saldo)        
			              end  
			        END AS saldo
				from mfi_gl_report_item a 
				left outer join mfi_gl_report_item_member b on a.gl_report_item_id=b.gl_report_item_id 
				left outer join mfi_closing_ledger_data_2 c on b.account_code = c.account_code 
				where c.closing_thru_date=? 
				and a.report_code=?   
				group by 1,2,3,4,5,6,7,8  
				order by 1,2 ";  

			/* param saldo awal */
			$param[] = $last_date;			
			/* param report group */
			$param[] = $report_code;
		}else{

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
			                 then sum(c.saldo)*-1         
			              else  
			                 sum(c.saldo)        
			              end  
			        END AS saldo
				from mfi_gl_report_item a 
				left outer join mfi_gl_report_item_member b on a.gl_report_item_id=b.gl_report_item_id 
				left outer join mfi_closing_ledger_data_2 c on b.account_code = c.account_code 
				where c.closing_thru_date=? 
				and c.branch_code in (select branch_code from mfi_branch_member where branch_induk =? )
				and a.report_code=?   
				group by 1,2,3,4,5,6,7,8  
				order by 1,2 ";  
			/* param saldo awal */
			$param[] = $last_date;
			$param[] = $branch_code;
			/* param report group */
			$param[] = $report_code;
		}		 

		/*
		{$sql = "SELECT report_code,
			    item_code,
			    item_type,
			    posisi,
			    formula,
			    formula_text_bold,
			        CASE
			            WHEN posisi = 0 THEN '<b>'||item_name||'</b>'
			            WHEN posisi = 1 THEN ('  '||item_name::text)::character varying
			            WHEN posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || item_name::text)::character varying
			            WHEN posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || item_name::text)::character varying
			            ELSE item_name
			        END AS item_name,
			        CASE
			            WHEN item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when display_saldo = 1 
			               then fn_get_saldo_group_glaccount4(gl_report_item_id,?,?)*-1         
			              else  
			                fn_get_saldo_group_glaccount4(gl_report_item_id,?,?)         
			              end  
			        END AS saldo
			    FROM mfi_gl_report_item WHERE mfi_gl_report_item.report_code = ?
			    ORDER BY report_code, item_code, item_type
			 ";
		}
		*/

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

	function insert_temp($cabang,$fromlm,$from,$thru,$user_id){
		$sql = "SELECT fn_insert_report_temporay(?,?,?,?,?)";

		$param = array($cabang,$fromlm,$from,$thru,$user_id);

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
			        CASE
			            WHEN a.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when a.display_saldo = 1 
			                 then sum(c.saldo_akhir)*-1         
			              else  
			                 sum(c.saldo_akhir)         
			              end  
			        END AS saldo
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
			        CASE
			            WHEN a.item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when a.display_saldo = 1 
			                 then sum(c.saldo_akhir)*-1         
			              else  
			                 sum(c.saldo_akhir)        
			              end  
			        END AS saldo
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

		/*$sql = "SELECT report_code, item_code,  item_type, posisi, formula, formula_text_bold,
			        CASE
			            WHEN posisi = 0 THEN '<b>'||item_name||'</b>'
			            WHEN posisi = 1 THEN ('  '||item_name::text)::character varying
			            WHEN posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || item_name::text)::character varying
			            WHEN posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || item_name::text)::character varying
			            ELSE item_name
			        END AS item_name,
			        CASE
			            WHEN item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when display_saldo = 1 
			               then fn_get_saldo_group_glaccount5(gl_report_item_id,?)*-1         
			              else  
			                fn_get_saldo_group_glaccount5(gl_report_item_id,?)         
			              end  
			        END AS saldo
			    FROM mfi_gl_report_item
			    
			    WHERE report_code = ?
			    ORDER BY report_code, item_code, item_type
			 ";
		*/

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

		/*$sql = "SELECT report_code, item_code, item_type, posisi, formula, formula_text_bold,
			        CASE
			            WHEN posisi = 0 THEN '<b>'||item_name||'</b>'
			            WHEN posisi = 1 THEN ('  '||item_name::text)::character varying
			            WHEN posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || item_name::text)::character varying
			            WHEN posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || item_name::text)::character varying
			            ELSE item_name
			        END AS item_name,
			        CASE
			            WHEN item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when display_saldo = 1 
			               then fn_get_saldo_group_glaccount6(gl_report_item_id,?)*-1         
			              else  
			                fn_get_saldo_group_glaccount6(gl_report_item_id,?)         
			              end  
			        END AS saldo,
			        CASE
			            WHEN item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when display_saldo = 1 
			               then fn_get_saldo_mutasi_group_glaccount2(gl_report_item_id, item_type, ? , ? , ?)*-1         
			              else  
			                fn_get_saldo_mutasi_group_glaccount2(gl_report_item_id, item_type, ? , ? , ?)         
			              end  
			        END AS saldo_mutasi
			    FROM mfi_gl_report_item
			    
			    WHERE report_code = ?
			    
			    ORDER BY report_code, item_code, item_type
			 ";
		*/

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
	function list_pelunasan_pembiayaan($cabang,$pembiayaan,$petugas,$majelis,$from,$thru){
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
		mafl.potongan_margin
		FROM mfi_account_financing_lunas AS mafl
		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mafl.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		LEFT JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
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

	function export_lap_droping_pembiayaan($cabang,$majelis,$from,$thru,$pembiayaan,$petugas,$peruntukan,$sektor,$produk){
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
		mlcd.display_text AS dtp,
		mldc.display_text AS dts

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

		$sql .= "ORDER BY mcm.cm_name,mc.cif_no ASC";

		$query = $this->db->query($sql,$param);
		
		return $query->result_array();
	}

	/****************************************************************************************/	
	// END LAPORAN DROPING PEMBIAYAAN
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

	function export_lap_list_outstanding_pembiayaan($cabang,$pembiayaan,$petugas,$majelis,$produk,$peruntukan,$sektor,$tanggal){
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
		maf.financing_type,
		mlcd.display_text AS peruntukan,
		fice.display_text AS sektor,
		mcm.cm_name,
		mf.fa_name,
		mpf.nick_name,
		CAST((maf.saldo_pokok / maf.angsuran_pokok) AS INTEGER)
		AS freq_bayar_saldo,
		maf.counter_angsuran AS freq_bayar_pokok
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
		WHERE maf.status_rekening = '1' ";

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

		$sql .= "ORDER BY mb.branch_code,mcm.cm_name,mc.kelompok::INTEGER ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	} 

	/****************************************************************************************/	
	// END LAPORAN OUTSTANDING
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
		mpf.nick_name

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
		} else {
			$sql .= "mlcd.display_text AS keterangan, ";
		}

		$sql .= "COUNT(mc.cif_no) AS jumlah_anggota,
		SUM(mafr.amount) AS nominal,
		mafr.financing_type
		FROM mfi_account_financing_reg AS mafr
		JOIN mfi_cif AS mc ON mc.cif_no = mafr.cif_no ";

		if($kategori == '1'){
			$sql .= "JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code ";
			$sql .= "JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id ";
		} else if($kategori == '2'){
			$sql .= "JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code ";
			$sql .= "JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code ";
			$sql .= "JOIN mfi_branch AS mb ON mb.branch_code = mf.branch_code ";
		} else {
			$sql .= "JOIN mfi_list_code_detail AS mlcd ON mlcd.code_value = mafr.peruntukan::VARCHAR AND mlcd.code_group = 'peruntukan' ";
			$sql .= "JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code ";
		}

		$sql .= "WHERE mafr.status = '1' ";

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

		$sql .= "GROUP BY 1,4 ORDER BY 1";

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
	/****************************************************************************************/	
	// END REKAP PENCAIRAN PEMBIAYAAN
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
		SUM(madb.setoran_lwk) AS setoran_lwk,
		SUM(madb.simpanan_pokok) AS simpanan_pokok,
		SUM(madb.tabungan_wajib) AS tabungan_minggon,
		SUM(madb.tabungan_sukarela) AS tabungan_sukarela,
		SUM(madb.tabungan_kelompok) AS tabungan_kelompok
		FROM mfi_account_default_balance AS madb 
		LEFT JOIN mfi_cif AS mc on madb.cif_no = mc.cif_no 
		LEFT JOIN mfi_branch AS mb on mb.branch_code = mc.branch_code 
		WHERE mc.status = '1' ";

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
				sum(c.saldo_pokok) saldo_pokok,	sum(c.saldo_margin) saldo_margin, sum(c.saldo_catab) saldo_catab,
				sum(d.setoran_lwk) setoran_lwk, sum(d.simpanan_pokok) simpanan_pokok, sum(d.tabungan_wajib) tabungan_minggon, 
				sum(d.tabungan_sukarela) tabungan_sukarela, sum(d.tabungan_kelompok) tabungan_kelompok 
				from mfi_cif b 
				left outer join mfi_cm a on a.cm_code=b.cm_code 
				left outer join mfi_account_default_balance d on d.cif_no=b.cif_no 
				left outer join mfi_account_financing c on c.cif_no=b.cif_no and c.status_rekening='1' 
				where b.status='1' ";

		if($branch_code=="0000" || $branch_code==""){
			$sql .= " ";
			$param[] = $branch_code;
		}else if($branch_code!="0000"){
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
				sum(c.saldo_pokok) saldo_pokok,	sum(c.saldo_margin) saldo_margin, sum(c.saldo_catab) saldo_catab,
				sum(d.setoran_lwk) setoran_lwk, sum(d.simpanan_pokok) simpanan_pokok, sum(d.tabungan_wajib) tabungan_minggon, 
				sum(d.tabungan_sukarela) tabungan_sukarela, sum(d.tabungan_kelompok) tabungan_kelompok 
				from mfi_cif b 
				left outer join mfi_cm a on a.cm_code=b.cm_code 
				left outer join mfi_fa e on e.fa_code=a.fa_code 
				left outer join mfi_account_default_balance d on d.cif_no=b.cif_no 
				left outer join mfi_account_financing c on c.cif_no=b.cif_no and c.status_rekening='1' 
				where b.status='1' ";

		if($branch_code=="0000" || $branch_code==""){
			$sql .= " ";
			$param[] = $branch_code;
		}else if($branch_code!="0000"){
			$sql .=" and b.branch_code in (select branch_code from mfi_branch_member where branch_induk= ?) ";
			$param[] = $branch_code;
		}
		
		$sql .=" GROUP BY 1,2 ORDER BY 1,2 "; 
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	//cabang
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

		//by cabang
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

		function export_rekap_outstanding_pembiayaan_produk($branch_code){
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
	function jqgrid_count_outstanding_pembiayaan($cabang,$pembiayaan,$majelis,$petugas,$tanggal,$produk,$peruntukan,$sektor){
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

	function jqgrid_list_outstanding_pembiayaan($sidx,$sord,$limit_rows,$start,$cabang,$pembiayaan,$majelis,$petugas,$tanggal,$product_code,$peruntukan,$sektor){
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
		maf.counter_angsuran AS freq_bayar_pokok
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

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	} 	

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

	public function export_list_pembukaan_deposito($from_date,$thru_date,$cabang)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.nominal,
				mfi_account_deposit.jangka_waktu,
				mfi_account_deposit.tanggal_buka,
				mfi_account_deposit.tanggal_jtempo_last,
				mfi_account_deposit.automatic_roll_over
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				WHERE mfi_account_deposit.tanggal_buka BETWEEN ? AND ?
				AND mfi_account_deposit.status_rekening != '2'
				";
				$param[]=$from_date;
				$param[]=$thru_date;
				if($cabang!="0000"){
					$sql.=" AND mfi_cif.branch_code=?";
					$param[]=$cabang;
				}
				$query = $this->db->query($sql,$param);

				return $query->result_array();
	} 


	/****************************************************************************************/	
	// END LAPORAN PEMBUKAAN DEPOSITO 
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN DROPING DEPOSITO
	/****************************************************************************************/

	public function export_lap_droping_deposito($cabang='',$rembug='',$from_date,$thru_date)
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

				if($rembug!="")
				{
				$sql .= " AND mfi_cm.cm_code = ? ";
				$param[] = $rembug;
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

	public function export_rekap_outstanding_deposito($cabang='',$rembug='',$tanggal,$produk)
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

				if($rembug!="")
				{
				$sql .= " AND mfi_cm.cm_code = ? ";
				$param[] = $rembug;
				}

				if($produk!="")
				{
				$sql .= " AND mfi_product_deposit.product_code = ? ";
				$param[] = $rembug;
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

	function export_keuangan_labarugi_bulanan($branch_code,$last_date,$report_code){
		$param = array(); 
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
				left outer join mfi_closing_ledger_data_2 c on b.account_code = c.account_code 
				where c.closing_thru_date=? 
				and a.report_code=?   
				group by 1,2,3,4,5,6,7,8  
				order by 1,2 ";
			
			$param[] = $last_date;
			/* param report group */
			$param[] = $report_code;
		}else{

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
				left outer join mfi_closing_ledger_data_2 c on b.account_code = c.account_code 
				where c.closing_thru_date=? 
				and c.branch_code in (select branch_code from mfi_branch_member where branch_induk =? )
				and a.report_code=?   
				group by 1,2,3,4,5,6,7,8  
				order by 1,2 ";  

			$param[] = $last_date;
			$param[] = $branch_code;
			/* param report group */
			$param[] = $report_code;
			
		}	

		/*$sql = "SELECT report_code, item_code, item_type, posisi, formula, formula_text_bold, 
			        CASE
			            WHEN posisi = 0 THEN '<b>'||item_name||'</b>'
			            WHEN posisi = 1 THEN ('  '::text || item_name::text)::character varying
			            WHEN posisi = 2 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;'::text || item_name::text)::character varying
			            WHEN posisi = 3 THEN (' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'::text || item_name::text)::character varying
			            ELSE item_name
			        END AS item_name,
			        CASE
			            WHEN item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when display_saldo = 1 
			               then fn_get_saldo_group_glaccount4(gl_report_item_id,?,?)*-1         
			              else  
			                fn_get_saldo_group_glaccount4(gl_report_item_id,?,?)         
			              end  
			        END AS saldo,
			        CASE
			            WHEN item_type = 0 THEN NULL::integer
			            ELSE 
			              case 
			              when display_saldo = 1 
			               then fn_get_saldo_mutasi_group_glaccount2(gl_report_item_id,item_type, ? , ? , ?)*-1         
			              else  
			                fn_get_saldo_mutasi_group_glaccount2(gl_report_item_id,item_type, ? , ? , ?)         
			              end  
			        END AS saldo_mutasi
			    FROM mfi_gl_report_item WHERE report_code = ?
			    ORDER BY report_code, item_code, item_type
			 ";
			*/
		

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
					FROM mfi_closing_ledger_data_2 a
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
					FROM mfi_closing_ledger_data_2 a
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
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='1 - 30' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='1 - 30' and mfi_par.tanggal_hitung=?)
				end) as jml1,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='1 - 30' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='1 - 30' and mfi_par.tanggal_hitung=?)
				end) as saldo_pokok1,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='1 - 30' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='1 - 30' and mfi_par.tanggal_hitung=?) 
				end) as cpp1,

				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='31 - 60' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='31 - 60' and mfi_par.tanggal_hitung=?)
				end) as jml2,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='31 - 60' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='31 - 60' and mfi_par.tanggal_hitung=?)
				end) as saldo_pokok2,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='31 - 60' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='31 - 60' and mfi_par.tanggal_hitung=?) 
				end) as cpp2,

				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='61 - 90' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='61 - 90' and mfi_par.tanggal_hitung=?)
				end) as jml3,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='61 - 90' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='61 - 90' and mfi_par.tanggal_hitung=?)
				end) as saldo_pokok3,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='61 - 90' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='61 - 90' and mfi_par.tanggal_hitung=?) 
				end) as cpp3,

				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='91 - 120' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='91 - 120' and mfi_par.tanggal_hitung=?)
				end) as jml4,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='91 - 120' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='91 - 120' and mfi_par.tanggal_hitung=?)
				end) as saldo_pokok4,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='91 - 120' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='91 - 120' and mfi_par.tanggal_hitung=?) 
				end) as cpp4,

				(case when a.branch_class = 2 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='> 120' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select count(*) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='> 120' and mfi_par.tanggal_hitung=?)
				end) as jml5,
				(case when a.branch_class = 2 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='> 120' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select sum(saldo_pokok) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='> 120' and mfi_par.tanggal_hitung=?)
				end) as saldo_pokok5,
				(case when a.branch_class = 2 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code in(select branch_code from mfi_branch_member where branch_induk = a.branch_code) and par_desc='> 120' and mfi_par.tanggal_hitung=?)
				      when a.branch_class = 3 then 
					(select sum(cadangan_piutang) from mfi_par where mfi_par.freq_tunggakan>0 AND mfi_par.branch_code=a.branch_code and par_desc='> 120' and mfi_par.tanggal_hitung=?) 
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
	function get_amount_mutasi_from_item_code($item_code,$from_date,$last_date,$branch_code,$report_code)
	{
		$sql = "SELECT (CASE WHEN item_type = 0 
					THEN NULL::integer
		            ELSE 
		              case when display_saldo = 1 
		              then fn_get_saldo_mutasi_gl_account2(gl_report_item_id,item_type, ? , ? , ?)*-1         
		              else fn_get_saldo_mutasi_gl_account2(gl_report_item_id,item_type, ? , ? , ?)         
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
		              then fn_get_saldo_group_glaccount5(gl_report_item_id,item_type, ?)*-1         
		              else fn_get_saldo_group_glaccount5(gl_report_item_id,item_type, ?)         
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
		        WHERE mgri.report_code = ? AND mgri.item_code=? AND mcld.closing_thru_date = ? 
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
	
	public function get_saldo_report_by_item_code2($report_code,$item_code,$branch_code,$from_date,$last_date)
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
				       then fn_get_saldo_group_glaccount7(mfi_gl_report_item.gl_report_item_id,?)*-1
				      else  
					fn_get_saldo_group_glaccount7(mfi_gl_report_item.gl_report_item_id,?)
				      end  
				END,0) AS saldo
				FROM mfi_gl_report_item 
				WHERE mfi_gl_report_item.report_code = ? and mfi_gl_report_item.item_code = ?
				ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			";
		
		$param[] = $branch_code;
		$param[] = $branch_code;
		$param[] = $report_code;
		$param[] = $item_code;

		$query = $this->db->query($sql,$param);
		$rows=$query->row_array();
		
		if($rows['item_type']=='2'){ // FORMULA
			$item_codes=$this->get_codes_by_formula($rows['formula']);
			$arr_amount=array();
			for($j=0;$j<count($item_codes);$j++){
				$arr_amount[$item_codes[$j]]=$this->get_amount_from_item_code($item_codes[$j],$from_date,$branch_code,$report_code);
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
		/*
		$sql2 = "SELECT
				mfi_gl_report_item.item_type,
				mfi_gl_report_item.formula,
				mfi_gl_report_item.formula_text_bold,
				coalesce(CASE
				    WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
				    ELSE 
				      case 
				      when mfi_gl_report_item.display_saldo = 1 
				       then fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)*-1
				      else  
					   fn_get_saldo_mutasi_group_glaccount2(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ? , ?)
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
		*/
		
		$sql2 = "SELECT
				mfi_gl_report_item.item_type,
				mfi_gl_report_item.formula,
				mfi_gl_report_item.formula_text_bold,
				CASE
					WHEN mfi_gl_report_item.item_type = 0 THEN NULL::integer
					ELSE 
					  case 
					  when mfi_gl_report_item.display_saldo = 1 
						 then sum(mfi_report_financing_temporary.total_mutasi_debet-mfi_report_financing_temporary.total_mutasi_credit)*-1         
					  else  
						 sum(mfi_report_financing_temporary.total_mutasi_debet-mfi_report_financing_temporary.total_mutasi_credit)  
					  end  
				END AS saldo_mutasi 
				FROM mfi_gl_report_item
				left outer join mfi_gl_report_item_member on mfi_gl_report_item.gl_report_item_id=mfi_gl_report_item_member.gl_report_item_id
				left outer join mfi_report_financing_temporary on mfi_gl_report_item_member.account_code = mfi_report_financing_temporary.account_code
				WHERE mfi_gl_report_item.report_code = ? and mfi_gl_report_item.item_code = ?
				GROUP BY
				mfi_gl_report_item.item_type,
				mfi_gl_report_item.formula,
				mfi_gl_report_item.formula_text_bold,
				mfi_gl_report_item.display_saldo,
				mfi_gl_report_item.report_code,
				mfi_gl_report_item.item_code
				ORDER BY mfi_gl_report_item.report_code, mfi_gl_report_item.item_code, mfi_gl_report_item.item_type
			";

		$param2[] = $report_code;
		$param2[] = $item_code;

		$query2 = $this->db->query($sql2,$param2);
		$rows2=$query2->row_array();
		
		if($rows2['item_type']=='2'){ // FORMULA
			$item_codes2=$this->get_codes_by_formula($rows2['formula']);
			$arr_amount2=array();
			for($j=0;$j<count($item_codes2);$j++){
				$arr_amount2[$item_codes2[$j]]=$this->get_amount_from_item_code($item_codes2[$j],$last_date,$branch_code,$report_code);
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
		
		if($rows['item_type']=='2'){ // FORMULA
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
			$saldo=$rows['saldo'];
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
				WHERE mgri.report_code = ? AND c.closing_thru_date = ?
				GROUP BY mgri.item_type,mgri.formula,mgri.formula_text_bold,mgri.display_saldo,mgri.report_code,mgri.item_code
				ORDER BY mgri.report_code, mgri.item_code, mgri.item_type
			";
		
		$param2[] = $report_code;
		$param2[] = $last_date;

		$query2 = $this->db->query($sql2,$param2);
		$rows2=$query2->row_array();
		
		if($rows2['item_type']=='2'){ // FORMULA
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
			$saldo_mutasi=$rows2['saldo_mutasi'];
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

	public function get_saldo_report_by_item_code($report_code,$item_code,$branch_code,$periode_bulan,$periode_tahun,$periode_hari)
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
				       then fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)*-1
				      else  
					fn_get_saldo_group_glaccount3(mfi_gl_report_item.gl_report_item_id,mfi_gl_report_item.item_type, ? , ?)
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
		LEFT JOIN mfi_closing_ledger_data_2 AS mcld ON mcld.account_code = mgrim.account_code
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

	function export_list_angsuran_pembiayaan_kelompok($from,$thru,$cabang,$majelis,$petugas,$produk){
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
		((mtcd.angsuran_pokok * mtcd.freq) + (mtcd.angsuran_margin * mtcd.freq)) AS jml_bayar			
		
		FROM mfi_trx_cm_detail AS mtcd

		JOIN mfi_account_financing AS maf ON mtcd.account_financing_no = maf.account_financing_no
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
		JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_fa AS mf ON mf.fa_code = mtc.fa_code

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
            $sql .= "AND mf.fa_code = ? ";
            $param[] = $petugas;
        }

        if($produk != '00000'){
            $sql .= "AND mpf.product_code = ? ";
            $param[] = $produk;
        }

		$sql .= "ORDER BY
		mtc.trx_date,
		mc.cm_code,
		maf.account_financing_no
		ASC";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function export_list_angsuran_pembiayaan_individu($from,$thru,$cabang,$majelis,$petugas,$produk){
		$sql = "SELECT
		mtaf.account_financing_no,
		mc.nama,
		mtaf.trx_date,
		mcm.cm_name,
		maf.pokok,
		maf.margin,
		maf.jangka_waktu,
		maf.periode_jangka_waktu,
		maf.jtempo_angsuran_last,
		maf.saldo_pokok,
		maf.saldo_margin,
		mpf.nick_name,
		-- ((mtaf.pokok * mtaf.freq) + (mtaf.margin * mtaf.freq)) AS jml_angsuran,
		(mtaf.pokok * mtaf.freq) AS angsuran_pokok,
		(mtaf.margin * mtaf.freq) AS angsuran_margin,
		(mtaf.catab * mtaf.freq) AS angsuran_catab,
		((mtaf.pokok * mtaf.freq) + (mtaf.margin * mtaf.freq) + (mtaf.catab * mtaf.freq) ) AS jml_bayar
		
		FROM mfi_trx_account_financing AS mtaf

		JOIN mfi_account_financing AS maf ON mtaf.account_financing_no = maf.account_financing_no
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code

		WHERE mtaf.trx_date BETWEEN ? AND ?
		AND maf.financing_type = '1' AND mtaf.freq > '1' ";

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
            $sql .= "AND mf.fa_code = ? ";
            $param[] = $petugas;
        }

        if($produk != '00000'){
            $sql .= "AND mpf.product_code = ? ";
            $param[] = $produk;
        }

		$sql .= "ORDER BY
		mtaf.trx_date,
		mc.cm_code,
		maf.account_financing_no
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
				left join mfi_account_financing e on e.account_financing_no=a.account_financing_no and e.status_rekening=1
				where b.trx_date between ? and ?
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
					left join mfi_account_financing e on e.account_financing_no=a.account_financing_no and e.status_rekening=1
					where b.trx_date between ? and ?
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
					left join mfi_account_financing d on d.account_financing_no=a.account_financing_no and d.status_rekening=1
					where b.trx_date between ? and ?
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
					left join mfi_account_financing d on d.account_financing_no=a.account_financing_no and d.status_rekening=1
					where b.trx_date between ? and ?
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
					left join mfi_account_financing d on d.account_financing_no=a.account_financing_no and d.status_rekening=1
					left join mfi_product_financing c on c.product_code=d.product_code
					where b.trx_date between ? and ?
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
					left join mfi_account_financing d on d.account_financing_no=a.account_financing_no and d.status_rekening=1
					left join mfi_list_code_detail e on e.code_group='peruntukan' and e.code_value::integer=d.peruntukan
					where b.trx_date between ? and ?
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
					left join mfi_account_financing d on d.account_financing_no=a.account_financing_no and d.status_rekening=1
					left join mfi_list_code_detail e on e.code_group='sektor_ekonomi' and e.code_value::integer=d.sektor_ekonomi
					where b.trx_date between ? and ?
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
						select trx_cm_detail_id from mfi_trx_cm_detail where trx_cm_id='ec2bb00731a52624950e3093c9299f8a'
					)
				) setoran,
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
						left join mfi_account_financing on mfi_account_financing.cif_no = a.cif_no  and mfi_account_financing.status_rekening = 1
						--left join mfi_trx_cm_save_berencana b on a.trx_cm_save_detail_id = b.trx_cm_save_detail_id 
						where a.trx_cm_save_id = mfi_trx_cm_save.trx_cm_save_id
						)) setoran,
						(select (sum(a.penarikan_tab_sukarela)+sum((case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then mfi_account_financing.pokok else 0 end) else 0 end)))
						from mfi_trx_cm_save_detail a
						left join mfi_account_financing on mfi_account_financing.cif_no = a.cif_no and mfi_account_financing.status_rekening = 1
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

		WHERE maf.jtempo_angsuran_next <= ? AND maf.financing_type = 1
		AND maf.status_rekening = 1 ";

		$param = array();

		$param[] = $from;
		$param[] = $from;
		$param[] = $thru;

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

	function export_lap_list_bagihasil($majelis,$petugas,$periode){
		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		mtcd.tab_sukarela_cr
		FROM mfi_trx_cm_detail AS mtcd
		JOIN mfi_cif AS mc ON mc.cif_no = mtcd.cif_no
		JOIN mfi_trx_cm AS mtc ON mtc.trx_cm_id = mtcd.trx_cm_id
		JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
		JOIN mfi_fa AS mf ON mf.fa_code = mcm.fa_code
		WHERE mtcd.keterangan LIKE '%POSTING BAHAS%' ";

		$param = array();

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
}