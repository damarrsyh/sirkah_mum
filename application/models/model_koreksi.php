<?php

Class Model_koreksi extends CI_Model {

	function get_angsuran_ke($account_financing_no){
		$sql = "SELECT MIN(angsuran_ke) AS min_angs FROM mfi_trx_cm_detail
				WHERE account_financing_no = ?";

		$param = array($account_financing_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function get_angsuran_max($account_financing_no){
		$sql = "SELECT MAX(angsuran_ke) AS max_angs FROM mfi_trx_cm_detail
				WHERE account_financing_no = ?";

		$param = array($account_financing_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function fn_edit_trxcm_angsuran_ke2($account_financing_no){
		$sql = "SELECT fn_edit_trxcm_angsuran_ke2(account_financing_no)
				FROM mfi_account_financing AS maf, mfi_cif AS mc
				WHERE maf.cif_no = mc.cif_no and maf.account_financing_no = ?
				AND maf.status_rekening = 1";

		$param = array($account_financing_no);

		$query = $this->db->query($sql,$param);
	}

	function fn_edit_trxcm_angsuran_ke($account_financing_no){
		$sql = "SELECT fn_edit_trxcm_angsuran_ke(account_financing_no)
				FROM mfi_account_financing AS maf, mfi_cif AS mc
				WHERE maf.cif_no = mc.cif_no and maf.account_financing_no = ?
				AND maf.status_rekening = 1";

		$param = array($account_financing_no);

		$query = $this->db->query($sql,$param);
	}

	function jqgrid_count_koreksi_angsuran($cabang,$cm_code){
		$sql = "SELECT
				mc.nama,mtcd.account_financing_no, mtcd.angsuran_ke,
				COUNT(mtcd.angsuran_ke) AS jumlah_angs, mc.cm_code,
				COUNT(*) AS jumlah
				FROM
				mfi_trx_cm_detail AS mtcd, mfi_account_financing AS mf, mfi_cif AS mc,
				mfi_cm AS mcm
				WHERE mtcd.freq != '0' AND mf.status_rekening = '1'
				AND mtcd.account_financing_no = mf.account_financing_no
				AND mf.cif_no = mc.cif_no AND mc.cm_code = mcm.cm_code
				AND mf.financing_type = '0'";

		$param = array();

		if($cabang != '00000'){
			$sql .= " AND mc.branch_code = ?";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= " AND mcm.cm_code = ?";
			$param[] = $cm_code;
		}

		$sql .= " GROUP BY 1,2,3,5 HAVING COUNT(mtcd.angsuran_ke) > 1";

		$query = $this->db->query($sql,$param);
		$row = $query->row_array();

		if(isset($row['jumlah'])){
			$result = $row['jumlah'];
		} else {
			$result = 0;
		}
		return $result;
	}

	function jqgrid_list_koreksi_angsuran($sidx='',$sord='',$limit_rows='',$start='',$cabang,$cm_code){
		$order = '5,4';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
				mc.nama,mtcd.account_financing_no, mtcd.angsuran_ke,
				COUNT(mtcd.angsuran_ke) AS jumlah_angs, mcm.cm_name
				FROM
				mfi_trx_cm_detail AS mtcd, mfi_account_financing AS mf, mfi_cif AS mc,
				mfi_cm AS mcm
				WHERE mtcd.freq != '0' AND mf.status_rekening = '1'
				AND mtcd.account_financing_no = mf.account_financing_no
				AND mf.cif_no = mc.cif_no AND mcm.cm_code = mc.cm_code
				AND mf.financing_type = '0'";

		$param = array();

		if($cabang != '00000'){
			$sql .= " AND mc.branch_code = ?";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= " AND mcm.cm_code = ?";
			$param[] = $cm_code;
		}

		$sql .= " GROUP BY 1,2,3,5 HAVING COUNT(mtcd.angsuran_ke) > 1 ";

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function jqgrid_list_koreksi_angsuran2($sidx='',$sord='',$limit_rows='',$start='',$cabang,$cm_code){
		$order = '5,4';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
				maf.account_financing_no,
				mc.nama,
				maf.counter_angsuran,
				MAX(mtcd.angsuran_ke) AS angsuran_ke,
				mcm.cm_name
				FROM mfi_account_financing AS maf
				JOIN mfi_trx_cm_detail AS mtcd ON mtcd.account_financing_no = maf.account_financing_no
				JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
				JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
				WHERE maf.status_rekening = '1' AND mtcd.freq != '0'
				AND maf.financing_type = '0'";

		$param = array();

		if($cabang != '00000'){
			$sql .= " AND mc.branch_code = ?";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= " AND mcm.cm_code = ?";
			$param[] = $cm_code;
		}

		$sql .= " GROUP BY 1,2,3,5 HAVING MAX(mtcd.angsuran_ke) != maf.counter_angsuran ";

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function show_data_koreksi($branch_code,$cm_code){
		$sql = "SELECT
				mc.cif_no,mc.nama,mtcd.account_financing_no, mtcd.angsuran_ke,
				COUNT(mtcd.angsuran_ke) AS jumlah_angs, mc.cm_code
				FROM
				mfi_trx_cm_detail AS mtcd, mfi_account_financing AS mf, mfi_cif AS mc,
				mfi_cm AS mcm
				WHERE mtcd.freq != '0' AND mf.status_rekening = '1'
				AND mtcd.account_financing_no = mf.account_financing_no
				AND mf.cif_no = mc.cif_no AND mcm.cm_code = mc.cm_code
				AND mf.financing_type = '0'";

		$param = array();

		if($branch_code != '00000'){
			$sql .= " AND mc.branch_code = ?";
			$param[] = $branch_code;
		}

		if($cm_code != '00000'){
			$sql .= " AND mcm.cm_code = ?";
			$param[] = $cm_code;
		}

		$sql .= " GROUP BY 1,2,3,4,6 HAVING COUNT(mtcd.angsuran_ke) > 1 ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_data_koreksi2($branch,$rembug){
		$sql = "SELECT
		maf.account_financing_no,
		mc.cif_no,
		mc.nama,
		maf.counter_angsuran,
		MAX(mtcd.angsuran_ke) AS angsuran_ke,
		mcm.cm_name
		FROM mfi_account_financing AS maf
		JOIN mfi_trx_cm_detail AS mtcd ON mtcd.account_financing_no = maf.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE maf.status_rekening = '1' AND mtcd.freq != '0'
		AND maf.financing_type = '0'";

		$param = array();

		if($branch != '00000'){
			$sql .= " AND mc.branch_code = ?";
			$param[] = $branch;
		}

		if($rembug != '00000'){
			$sql .= " AND mcm.cm_code = ?";
			$param[] = $rembug;
		}

		$sql .= " GROUP BY 1,2,3,4,6
		HAVING MAX(mtcd.angsuran_ke) != maf.counter_angsuran
		ORDER BY 2";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_financing($account_financing_no){
		$sql = "SELECT * FROM mfi_account_financing WHERE account_financing_no = ?";

		$param = array($account_financing_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function update_account_financing($item,$account_financing_no){
		$this->db->where('account_financing_no',$account_financing_no);
		$this->db->update('mfi_account_financing',$item);
	}

	function jqgrid_count_koreksi_tabber($cabang,$cm_code){
		$sql = "SELECT COUNT(*) AS jumlah FROM (
		SELECT
		mc.nama,
		mcm.cm_name,
		mas.account_saving_no,
		mas.saldo_memo,
		(
			SELECT SUM(amount) AS saldo
			FROM (
				SELECT SUM(a.amount) as amount
				FROM mfi_trx_konversi_saving AS a
				LEFT JOIN mfi_account_saving AS b ON b.cif_no = a.cif_no AND b.product_code = a.product_code
				LEFT JOIN mfi_product_saving AS c ON c.product_code = b.product_code
				WHERE a.tanggal > b.tanggal_buka
				AND c.jenis_tabungan = '1' AND a.flag_debit_credit = 'C'
				AND b.account_saving_no = mas.account_saving_no
				
				UNION ALL
		
				SELECT SUM(a.amount) * -1 AS amount
				FROM mfi_trx_account_saving AS a
				LEFT JOIN mfi_account_saving AS b ON b.account_saving_no = a.account_saving_no
				LEFT JOIN mfi_product_saving AS c ON c.product_code = b.product_code
				WHERE a.flag_debit_credit = 'D' AND a.trx_saving_type = '5'
				AND c.jenis_tabungan = '0' AND a.trx_status = '1'
				AND b.account_saving_no = mas.account_saving_no

				UNION ALL

				SELECT SUM(b.freq * b.amount) AS amount
				FROM mfi_trx_cm_detail_savingplan AS a
				JOIN mfi_trx_cm_detail_savingplan_account AS b ON b.trx_cm_detail_savingplan_id = a.trx_cm_detail_savingplan_id
				JOIN mfi_trx_cm_detail AS c ON c.trx_cm_detail_id = a.trx_cm_detail_id
				JOIN mfi_trx_cm AS d ON d.trx_cm_id = c.trx_cm_id
				JOIN mfi_account_saving AS e ON e.account_saving_no = b.account_saving_no
				JOIN mfi_product_saving AS f ON f.product_code = e.product_code
				WHERE b.flag_debet_credit = 'C' AND e.account_saving_no = mas.account_saving_no
				AND f.jenis_tabungan = '1'

				UNION ALL

				SELECT SUM(b.freq * b.amount) * -1 AS amount
				FROM mfi_trx_cm_detail_savingplan AS a
				JOIN mfi_trx_cm_detail_savingplan_account AS b ON b.trx_cm_detail_savingplan_id = a.trx_cm_detail_savingplan_id
				JOIN mfi_trx_cm_detail AS c ON c.trx_cm_detail_id = a.trx_cm_detail_id
				JOIN mfi_trx_cm AS d ON d.trx_cm_id = c.trx_cm_id
				JOIN mfi_account_saving AS e ON e.account_saving_no = b.account_saving_no
				JOIN mfi_product_saving AS f ON f.product_code = e.product_code
				WHERE b.flag_debet_credit = 'D' AND e.account_saving_no = mas.account_saving_no
				AND f.jenis_tabungan = '1'
			) AS saldo_awal_tab_berencana
		) AS saldo_histori

		FROM mfi_account_saving AS mas
		LEFT JOIN mfi_cif AS mc ON(mc.cif_no = mas.cif_no)
		LEFT JOIN mfi_cm AS mcm ON(mcm.cm_code = mc.cm_code)
		WHERE mas.status_rekening = '1'";

		$param = array();

		if($cabang != '00000'){
			$sql .= " AND mc.branch_code = ?";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= " AND mc.cm_code = ?";
			$param[] = $cm_code;
		}

		$sql .= ") AS x
		WHERE saldo_memo <> saldo_histori";

		$query = $this->db->query($sql,$param);
		$row = $query->row_array();

		if(isset($row['jumlah'])){
			$result = $row['jumlah'];
		} else {
			$result = 0;
		}
		return $result;
	}

	function jqgrid_list_koreksi_tabber($sidx='',$sord='',$limit_rows='',$start='',$cabang,$cm_code){
		$order = '5,4';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT * FROM (
		SELECT
		mc.nama,
		mcm.cm_name,
		mas.account_saving_no,
		mas.saldo_memo,
		(
			SELECT SUM(amount) AS saldo
			FROM (
				SELECT SUM(a.amount) as amount
				FROM mfi_trx_konversi_saving AS a
				LEFT JOIN mfi_account_saving AS b ON b.cif_no = a.cif_no AND b.product_code = a.product_code
				LEFT JOIN mfi_product_saving AS c ON c.product_code = b.product_code
				WHERE a.tanggal > b.tanggal_buka
				AND c.jenis_tabungan = '1' AND a.flag_debit_credit = 'C'
				AND b.account_saving_no = mas.account_saving_no
				
				UNION ALL
		
				SELECT SUM(a.amount) * -1 AS amount
				FROM mfi_trx_account_saving AS a
				LEFT JOIN mfi_account_saving AS b ON b.account_saving_no = a.account_saving_no
				LEFT JOIN mfi_product_saving AS c ON c.product_code = b.product_code
				WHERE a.flag_debit_credit = 'D' AND a.trx_saving_type = '5'
				AND c.jenis_tabungan = '0' AND a.trx_status = '1'
				AND b.account_saving_no = mas.account_saving_no

				UNION ALL

				SELECT SUM(b.freq * b.amount) AS amount
				FROM mfi_trx_cm_detail_savingplan AS a
				JOIN mfi_trx_cm_detail_savingplan_account AS b ON b.trx_cm_detail_savingplan_id = a.trx_cm_detail_savingplan_id
				JOIN mfi_trx_cm_detail AS c ON c.trx_cm_detail_id = a.trx_cm_detail_id
				JOIN mfi_trx_cm AS d ON d.trx_cm_id = c.trx_cm_id
				JOIN mfi_account_saving AS e ON e.account_saving_no = b.account_saving_no
				JOIN mfi_product_saving AS f ON f.product_code = e.product_code
				WHERE b.flag_debet_credit = 'C' AND e.account_saving_no = mas.account_saving_no
				AND f.jenis_tabungan = '1'

				UNION ALL

				SELECT SUM(b.freq * b.amount) * -1 AS amount
				FROM mfi_trx_cm_detail_savingplan AS a
				JOIN mfi_trx_cm_detail_savingplan_account AS b ON b.trx_cm_detail_savingplan_id = a.trx_cm_detail_savingplan_id
				JOIN mfi_trx_cm_detail AS c ON c.trx_cm_detail_id = a.trx_cm_detail_id
				JOIN mfi_trx_cm AS d ON d.trx_cm_id = c.trx_cm_id
				JOIN mfi_account_saving AS e ON e.account_saving_no = b.account_saving_no
				JOIN mfi_product_saving AS f ON f.product_code = e.product_code
				WHERE b.flag_debet_credit = 'D' AND e.account_saving_no = mas.account_saving_no
				AND f.jenis_tabungan = '1'
			) AS saldo_awal_tab_berencana
		) AS saldo_histori

		FROM mfi_account_saving AS mas
		LEFT JOIN mfi_cif AS mc ON(mc.cif_no = mas.cif_no)
		LEFT JOIN mfi_cm AS mcm ON(mcm.cm_code = mc.cm_code)
		WHERE mas.status_rekening = '1'";

		$param = array();

		if($cabang != '00000'){
			$sql .= " AND mc.branch_code = ?";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= " AND mc.cm_code = ?";
			$param[] = $cm_code;
		}

		$sql .= "$order $limit) AS x WHERE saldo_memo <> saldo_histori";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function show_data_koreksi_taber($branch_code,$cm_code){
		$sql = "SELECT * FROM (
		SELECT
		mc.nama,
		mcm.cm_name,
		mas.rencana_setoran,
		mas.account_saving_no,
		mas.saldo_memo,
		(
			SELECT SUM(amount) AS saldo
			FROM (
				SELECT SUM(a.amount) as amount
				FROM mfi_trx_konversi_saving AS a
				LEFT JOIN mfi_account_saving AS b ON b.cif_no = a.cif_no AND b.product_code = a.product_code
				LEFT JOIN mfi_product_saving AS c ON c.product_code = b.product_code
				WHERE a.tanggal > b.tanggal_buka
				AND c.jenis_tabungan = '1' AND a.flag_debit_credit = 'C'
				AND b.account_saving_no = mas.account_saving_no
				
				UNION ALL
		
				SELECT SUM(a.amount) * -1 AS amount
				FROM mfi_trx_account_saving AS a
				LEFT JOIN mfi_account_saving AS b ON b.account_saving_no = a.account_saving_no
				LEFT JOIN mfi_product_saving AS c ON c.product_code = b.product_code
				WHERE a.flag_debit_credit = 'D' AND a.trx_saving_type = '5'
				AND c.jenis_tabungan = '0' AND a.trx_status = '1'
				AND b.account_saving_no = mas.account_saving_no

				UNION ALL

				SELECT SUM(b.freq * b.amount) AS amount
				FROM mfi_trx_cm_detail_savingplan AS a
				JOIN mfi_trx_cm_detail_savingplan_account AS b ON b.trx_cm_detail_savingplan_id = a.trx_cm_detail_savingplan_id
				JOIN mfi_trx_cm_detail AS c ON c.trx_cm_detail_id = a.trx_cm_detail_id
				JOIN mfi_trx_cm AS d ON d.trx_cm_id = c.trx_cm_id
				JOIN mfi_account_saving AS e ON e.account_saving_no = b.account_saving_no
				JOIN mfi_product_saving AS f ON f.product_code = e.product_code
				WHERE b.flag_debet_credit = 'C' AND e.account_saving_no = mas.account_saving_no
				AND f.jenis_tabungan = '1'

				UNION ALL

				SELECT SUM(b.freq * b.amount) * -1 AS amount
				FROM mfi_trx_cm_detail_savingplan AS a
				JOIN mfi_trx_cm_detail_savingplan_account AS b ON b.trx_cm_detail_savingplan_id = a.trx_cm_detail_savingplan_id
				JOIN mfi_trx_cm_detail AS c ON c.trx_cm_detail_id = a.trx_cm_detail_id
				JOIN mfi_trx_cm AS d ON d.trx_cm_id = c.trx_cm_id
				JOIN mfi_account_saving AS e ON e.account_saving_no = b.account_saving_no
				JOIN mfi_product_saving AS f ON f.product_code = e.product_code
				WHERE b.flag_debet_credit = 'D' AND e.account_saving_no = mas.account_saving_no
				AND f.jenis_tabungan = '1'
			) AS saldo_awal_tab_berencana
		) AS saldo_histori

		FROM mfi_account_saving AS mas
		LEFT JOIN mfi_cif AS mc ON(mc.cif_no = mas.cif_no)
		LEFT JOIN mfi_cm AS mcm ON(mcm.cm_code = mc.cm_code)
		WHERE mas.status_rekening = '1'";

		$param = array();

		if($branch_code != '00000'){
			$sql .= " AND mc.branch_code = ?";
			$param[] = $branch_code;
		}

		if($cm_code != '00000'){
			$sql .= " AND mc.cm_code = ?";
			$param[] = $cm_code;
		}

		$sql .= ") AS x
		WHERE saldo_memo <> saldo_histori";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function update_tabber($data,$account_saving_no){
		$this->db->where('account_saving_no',$account_saving_no);
		$this->db->update('mfi_account_saving',$data);
	}

	function jqgrid_count_koreksi_sukarela($cabang,$cm_code){
		$param = array();

		$sql = "SELECT COUNT(*) AS jumlah FROM (
		SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		COALESCE(madb.tabungan_sukarela,0) AS tabungan_sukarela,
		(COALESCE(mtts.mtts_credit,0) - COALESCE(frau.mtts_debet,0) + COALESCE(mtcd.trx_sukarela,0) + COALESCE(SUM(mtss.amount),0)) AS tabungan_histori
		FROM mfi_cif AS mc
		JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN (
			SELECT
			cif_no,
			SUM(amount) AS mtts_credit
			FROM mfi_trx_tab_sukarela
			WHERE flag_debet_credit = 'C'
			GROUP BY 1
		) AS mtts ON mtts.cif_no = mc.cif_no
		LEFT JOIN (
			SELECT
			cif_no,
			SUM(amount) AS mtts_debet
			FROM mfi_trx_tab_sukarela
			WHERE flag_debet_credit = 'D'
			GROUP BY 1
		) AS frau ON frau.cif_no = mc.cif_no
		LEFT JOIN (
			SELECT
			cif_no,
			SUM(tab_sukarela_cr - tab_sukarela_db) AS trx_sukarela
			FROM mfi_trx_cm_detail
			GROUP BY 1
		) AS mtcd ON mtcd.cif_no = mc.cif_no
		LEFT JOIN mfi_trx_shu_sukarela AS mtss ON mtss.cif_no = mc.cif_no
		WHERE mc.status = '1' ";

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= "GROUP BY
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		madb.tabungan_sukarela,
		mtts.mtts_credit,
		frau.mtts_debet,
		mtcd.trx_sukarela
		ORDER BY mc.cif_no) AS x WHERE tabungan_sukarela <> tabungan_histori";

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		if(isset($row['jumlah'])){
			$result = $row['jumlah'];
		} else {
			$result = 0;
		}
		return $result;
	}

	function jqgrid_count_koreksi_sukarela_old($cabang,$cm_code){
		$sql = "SELECT
		COUNT(*) AS jumlah

		FROM mfi_account_default_balance a, mfi_cif b
		WHERE a.cif_no = b.cif_no";

		$param = array();

		if($cabang != '00000'){
			$sql .= " AND b.branch_code = ?";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= " AND b.cm_code = ?";
			$param[] = $cm_code;
		}

		$sql .= " AND (
		(SELECT COALESCE(SUM(amount),0) FROM mfi_trx_tab_sukarela
		 WHERE flag_debet_credit = 'C' AND cif_no = a.cif_no) -
		(SELECT COALESCE(SUM(amount),0) FROM mfi_trx_tab_sukarela
		 WHERE flag_debet_credit = 'D' AND cif_no = a.cif_no) +
		(SELECT COALESCE(SUM(x.tab_sukarela_cr - x.tab_sukarela_db),0)
		 FROM mfi_trx_cm_detail x, mfi_trx_cm y
		 WHERE x.trx_cm_id = y.trx_cm_id AND x.cif_no = a.cif_no) +
		(SELECT COALESCE(SUM(amount),0) amount
		 FROM mfi_trx_shu_sukarela WHERE cif_no = a.cif_no)
		) <> a.tabungan_sukarela";

		$query = $this->db->query($sql,$param);
		$row = $query->row_array();

		if(isset($row['jumlah'])){
			$result = $row['jumlah'];
		} else {
			$result = 0;
		}
		return $result;
	}

	function jqgrid_list_koreksi_sukarela($sidx='',$sord='',$limit_rows='',$start='',$cabang,$cm_code){
		$order = '1';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = 'ORDER BY '.$sidx.' '.$sord.' ';
		if ($limit_rows!='' && $start!='') $limit = 'LIMIT '.$limit_rows.' OFFSET '.$start;

		$param = array();

		$sql = "SELECT * FROM (
		SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		COALESCE(madb.tabungan_sukarela,0) AS tabungan_sukarela,
		(COALESCE(mtts.mtts_credit,0) - COALESCE(frau.mtts_debet,0) + COALESCE(mtcd.trx_sukarela,0) + COALESCE(SUM(mtss.amount),0)) AS tabungan_histori
		FROM mfi_cif AS mc
		JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN (
			SELECT
			cif_no,
			SUM(amount) AS mtts_credit
			FROM mfi_trx_tab_sukarela
			WHERE flag_debet_credit = 'C'
			GROUP BY 1
		) AS mtts ON mtts.cif_no = mc.cif_no
		LEFT JOIN (
			SELECT
			cif_no,
			SUM(amount) AS mtts_debet
			FROM mfi_trx_tab_sukarela
			WHERE flag_debet_credit = 'D'
			GROUP BY 1
		) AS frau ON frau.cif_no = mc.cif_no
		LEFT JOIN (
			SELECT
			cif_no,
			SUM(tab_sukarela_cr - tab_sukarela_db) AS trx_sukarela
			FROM mfi_trx_cm_detail
			GROUP BY 1
		) AS mtcd ON mtcd.cif_no = mc.cif_no
		LEFT JOIN mfi_trx_shu_sukarela AS mtss ON mtss.cif_no = mc.cif_no
		WHERE mc.status = '1' ";

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= "GROUP BY
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		madb.tabungan_sukarela,
		mtts.mtts_credit,
		frau.mtts_debet,
		mtcd.trx_sukarela ".$order.$limit.") AS x WHERE tabungan_sukarela <> tabungan_histori";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_list_koreksi_sukarela_old($sidx='',$sord='',$limit_rows='',$start='',$cabang,$cm_code){
		$order = '1';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = " ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
		a.cif_no,
		b.nama,
		a.tabungan_sukarela,
		(
		(SELECT COALESCE(SUM(amount),0) FROM mfi_trx_tab_sukarela
		WHERE flag_debet_credit = 'C' AND cif_no = a.cif_no) -
		(SELECT COALESCE(SUM(amount),0) FROM mfi_trx_tab_sukarela
		 WHERE flag_debet_credit = 'D' AND cif_no = a.cif_no) +
		(SELECT COALESCE(SUM(x.tab_sukarela_cr - x.tab_sukarela_db),0)
		 FROM mfi_trx_cm_detail x, mfi_trx_cm y
		 WHERE x.trx_cm_id = y.trx_cm_id AND x.cif_no = a.cif_no) +
		(SELECT COALESCE(SUM(amount),0) amount FROM mfi_trx_shu_sukarela
		WHERE cif_no = a.cif_no)
		) AS tabungan_histori,
		c.cm_name

		FROM mfi_account_default_balance a, mfi_cif b, mfi_cm c
		WHERE a.cif_no = b.cif_no AND b.cm_code = c.cm_code";

		$param = array();

		if($cabang != '00000'){
			$sql .= " AND b.branch_code = ?";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= " AND b.cm_code = ?";
			$param[] = $cm_code;
		}

		$sql .= " AND (
		(SELECT COALESCE(SUM(amount),0) FROM mfi_trx_tab_sukarela
		 WHERE flag_debet_credit = 'C' AND cif_no = a.cif_no) -
		(SELECT COALESCE(SUM(amount),0) FROM mfi_trx_tab_sukarela
		 WHERE flag_debet_credit = 'D' AND cif_no = a.cif_no) +
		(SELECT COALESCE(SUM(x.tab_sukarela_cr - x.tab_sukarela_db),0)
		 FROM mfi_trx_cm_detail x, mfi_trx_cm y
		 WHERE x.trx_cm_id = y.trx_cm_id AND x.cif_no = a.cif_no) +
		(SELECT COALESCE(SUM(amount),0) amount
		 FROM mfi_trx_shu_sukarela WHERE cif_no = a.cif_no)
		) <> a.tabungan_sukarela";

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function show_data_koreksi_sukarela($cabang,$cm_code){
		$param = array();

		$sql = "SELECT * FROM (
		SELECT
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		COALESCE(madb.tabungan_sukarela,0) AS tabungan_sukarela,
		(COALESCE(mtts.mtts_credit,0) - COALESCE(frau.mtts_debet,0) + COALESCE(mtcd.trx_sukarela,0) + COALESCE(SUM(mtss.amount),0)) AS tabungan_histori
		FROM mfi_cif AS mc
		JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		JOIN mfi_branch AS mb ON mb.branch_code = mc.branch_code
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		LEFT JOIN (
			SELECT
			cif_no,
			SUM(amount) AS mtts_credit
			FROM mfi_trx_tab_sukarela
			WHERE flag_debet_credit = 'C'
			GROUP BY 1
		) AS mtts ON mtts.cif_no = mc.cif_no
		LEFT JOIN (
			SELECT
			cif_no,
			SUM(amount) AS mtts_debet
			FROM mfi_trx_tab_sukarela
			WHERE flag_debet_credit = 'D'
			GROUP BY 1
		) AS frau ON frau.cif_no = mc.cif_no
		LEFT JOIN (
			SELECT
			cif_no,
			SUM(tab_sukarela_cr - tab_sukarela_db) AS trx_sukarela
			FROM mfi_trx_cm_detail
			GROUP BY 1
		) AS mtcd ON mtcd.cif_no = mc.cif_no
		LEFT JOIN mfi_trx_shu_sukarela AS mtss ON mtss.cif_no = mc.cif_no
		WHERE mc.status = '1' ";

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= "GROUP BY
		mc.cif_no,
		mc.nama,
		mcm.cm_name,
		madb.tabungan_sukarela,
		mtts.mtts_credit,
		frau.mtts_debet,
		mtcd.trx_sukarela
		ORDER BY mc.cif_no) AS x WHERE tabungan_sukarela <> tabungan_histori";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_data_koreksi_sukarela_old($cabang,$cm_code){
		$sql = "SELECT * FROM (
		SELECT
		a.cif_no,
		b.nama,
		a.tabungan_sukarela,
		(
		(SELECT COALESCE(SUM(amount),0) FROM mfi_trx_tab_sukarela
		WHERE flag_debet_credit = 'C' AND cif_no = a.cif_no) -
		(SELECT COALESCE(SUM(amount),0) FROM mfi_trx_tab_sukarela
		 WHERE flag_debet_credit = 'D' AND cif_no = a.cif_no) +
		(SELECT COALESCE(SUM(x.tab_sukarela_cr - x.tab_sukarela_db),0)
		 FROM mfi_trx_cm_detail x, mfi_trx_cm y
		 WHERE x.trx_cm_id = y.trx_cm_id AND x.cif_no = a.cif_no) +
		(SELECT COALESCE(SUM(amount),0) amount FROM mfi_trx_shu_sukarela
		WHERE cif_no = a.cif_no)
		) AS tabungan_histori,
		c.cm_name

		FROM mfi_account_default_balance a, mfi_cif b, mfi_cm c
		WHERE a.cif_no = b.cif_no AND b.cm_code = c.cm_code";

		$param = array();

		if($cabang != '00000'){
			$sql .= " AND b.branch_code = ?";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= " AND b.cm_code = ?";
			$param[] = $cm_code;
		}

		$sql .= ") AS x WHERE tabungan_sukarela <> tabungan_histori";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function update_tabsuk($data,$cif_no){
		$this->db->where('cif_no',$cif_no);
		$this->db->update('mfi_account_default_balance',$data);
	}

	function fn_update_jtempo_angsuran_last_next($branch_code){
		$sql = "SELECT fn_update_jtempo_angsuran_last_next(?)";

		$param = array($branch_code);

		$query = $this->db->query($sql,$param);
	}

	function sum_wajib_kelompok($cif_no){
		$sql = "SELECT
		SUM(freq * tab_wajib_cr) AS tabungan_wajib,
		SUM(freq * tab_kelompok_cr) AS tabungan_kelompok
		FROM mfi_trx_cm_detail
		WHERE cif_no = ?";

		$param = array($cif_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function jqgrid_count_koreksi_pembulatan($majelis){
		$sql = "SELECT
		COUNT(*) AS jumlah
		FROM mfi_account_default_balance AS madb
		JOIN mfi_cif AS mc ON mc.cif_no = madb.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.status = '1' ";

		$param = array();

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ?";
			$param[] = $majelis;
		}

		$query = $this->db->query($sql,$param);
		$row = $query->row_array();

		if(isset($row['jumlah'])){
			$result = $row['jumlah'];
		} else {
			$result = 0;
		}
		return $result;
	}

	function jqgrid_list_koreksi_pembulatan($sidx='',$sord='',$limit_rows='',$start='',$majelis){
		$order = '1';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		madb.tabungan_wajib,
		madb.tabungan_kelompok,
		mcm.cm_name
		FROM mfi_account_default_balance AS madb
		JOIN mfi_cif AS mc ON mc.cif_no = madb.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.status = '1'  ";

		$param = array();

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $majelis;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function show_data_koreksi_pembulatan($majelis){
		$sql = "SELECT
		mc.cif_no,
		madb.tabungan_wajib,
		madb.tabungan_kelompok
		FROM mfi_account_default_balance AS madb
		JOIN mfi_cif AS mc ON mc.cif_no = madb.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.status = '1' ";

		$param = array();

		if($majelis != '00000'){
			$sql .= "AND mcm.cm_code = ?";
			$param[] = $majelis;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_data_koreksi_jto_individu($branch_code){
		$sql = "SELECT fn_reupdate_jto_date_angs_idvidu_by_branch(?) ";

		$param = array();

		$param[] = $branch_code;		

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_count_koreksi_wajib_kelompok($cabang,$cm_code){
		$sql = "SELECT
		COUNT(*) AS jumlah
		FROM mfi_cif AS mc
		JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.status = '1' ";

		$param = array();

		if($cabang != '00000'){
			$sql .= "AND mc.branch_code = ? ";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= "AND mc.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= "AND (((SELECT COALESCE(SUM(mtcd.tab_wajib_cr * mtcd.freq),0) FROM mfi_trx_cm_detail AS mtcd WHERE mtcd.cif_no = mc.cif_no) + (SELECT COALESCE(SUM(maf.angsuran_tab_wajib * mtaf.freq),0) FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf WHERE mtaf.account_financing_no = maf.account_financing_no AND maf.cif_no = mc.cif_no AND maf.financing_type = '1')) <> madb.tabungan_wajib
		OR ((SELECT COALESCE(SUM(mtcd.tab_kelompok_cr * mtcd.freq),0) FROM mfi_trx_cm_detail AS mtcd WHERE mtcd.cif_no = mc.cif_no) + (SELECT COALESCE(SUM(maf.angsuran_tab_kelompok * mtaf.freq),0) FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf WHERE mtaf.account_financing_no = maf.account_financing_no AND maf.cif_no = mc.cif_no AND maf.financing_type = '1')) <> madb.tabungan_kelompok)";

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		if(isset($row['jumlah'])){
			$result = $row['jumlah'];
		} else {
			$result = 0;
		}
		return $result;
	}

	function jqgrid_list_koreksi_wajib_kelompok($sidx='',$sord='',$limit_rows='',$start='',$cabang,$cm_code){
		$order = '1';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$param = array();

		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		madb.tabungan_wajib,
		(SELECT COALESCE(SUM(mtcd.tab_wajib_cr * mtcd.freq),0) FROM mfi_trx_cm_detail AS mtcd WHERE mtcd.cif_no = mc.cif_no) AS tabungan_wajib_histori_kelompok,
		(SELECT COALESCE(SUM(mtaf.tab_wajib),0) FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf WHERE mtaf.account_financing_no = maf.account_financing_no AND maf.cif_no = mc.cif_no AND maf.financing_type = '1') AS tabungan_wajib_histori_individu,
		madb.tabungan_kelompok,
		(SELECT COALESCE(SUM(mtcd.tab_kelompok_cr * mtcd.freq),0) FROM mfi_trx_cm_detail AS mtcd WHERE mtcd.cif_no = mc.cif_no) AS tabungan_kelompok_histori_kelompok,
		(SELECT COALESCE(SUM(mtaf.tab_kelompok),0) FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf WHERE mtaf.account_financing_no = maf.account_financing_no AND maf.cif_no = mc.cif_no AND maf.financing_type = '1') AS tabungan_kelompok_histori_individu,
		mcm.cm_name
		FROM mfi_cif AS mc
		JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.status = '1' ";

		if($cabang != '00000'){
			$sql .= "AND mc.branch_code = ? ";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= "AND mc.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= "AND (((SELECT COALESCE(SUM(mtcd.tab_wajib_cr * mtcd.freq),0) FROM mfi_trx_cm_detail AS mtcd WHERE mtcd.cif_no = mc.cif_no) + (SELECT COALESCE(SUM(maf.angsuran_tab_wajib * mtaf.freq),0) FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf WHERE mtaf.account_financing_no = maf.account_financing_no AND maf.cif_no = mc.cif_no AND maf.financing_type = '1')) <> madb.tabungan_wajib
		OR ((SELECT COALESCE(SUM(mtcd.tab_kelompok_cr * mtcd.freq),0) FROM mfi_trx_cm_detail AS mtcd WHERE mtcd.cif_no = mc.cif_no) + (SELECT COALESCE(SUM(maf.angsuran_tab_kelompok * mtaf.freq),0) FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf WHERE mtaf.account_financing_no = maf.account_financing_no AND maf.cif_no = mc.cif_no AND maf.financing_type = '1')) <> madb.tabungan_kelompok) ";

		$sql .= "GROUP BY 1,2,3,6,9 ";
		$sql .= $order.' '.$limit;

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function show_data_koreksi_wajib_kelompok($cabang,$cm_code){
		$sql = "SELECT
		mc.cif_no,
		mc.nama,
		madb.tabungan_wajib,
		(SELECT COALESCE(SUM(mtcd.tab_wajib_cr * mtcd.freq),0) FROM mfi_trx_cm_detail AS mtcd WHERE mtcd.cif_no = mc.cif_no) AS tabungan_wajib_histori_kelompok,
		(SELECT COALESCE(SUM(mtaf.tab_wajib),0) FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf WHERE mtaf.account_financing_no = maf.account_financing_no AND maf.cif_no = mc.cif_no AND maf.financing_type = '1') AS tabungan_wajib_histori_individu,
		madb.tabungan_kelompok,
		(SELECT COALESCE(SUM(mtcd.tab_kelompok_cr * mtcd.freq),0) FROM mfi_trx_cm_detail AS mtcd WHERE mtcd.cif_no = mc.cif_no) AS tabungan_kelompok_histori_kelompok,
		(SELECT COALESCE(SUM(mtaf.tab_kelompok),0) FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf WHERE mtaf.account_financing_no = maf.account_financing_no AND maf.cif_no = mc.cif_no AND maf.financing_type = '1') AS tabungan_kelompok_histori_individu,
		mcm.cm_name
		FROM mfi_cif AS mc
		JOIN mfi_account_default_balance AS madb ON madb.cif_no = mc.cif_no
		JOIN mfi_cm AS mcm ON mcm.cm_code = mc.cm_code
		WHERE mc.status = '1' ";

		$param = array();

		if($cabang != '00000'){
			$sql .= "AND mc.branch_code = ? ";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= "AND mc.cm_code = ?";
			$param[] = $cm_code;
		}

		$sql .= "AND (((SELECT COALESCE(SUM(mtcd.tab_wajib_cr * mtcd.freq),0) FROM mfi_trx_cm_detail AS mtcd WHERE mtcd.cif_no = mc.cif_no) + (SELECT COALESCE(SUM(maf.angsuran_tab_wajib * mtaf.freq),0) FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf WHERE mtaf.account_financing_no = maf.account_financing_no AND maf.cif_no = mc.cif_no AND maf.financing_type = '1')) <> madb.tabungan_wajib
		OR ((SELECT COALESCE(SUM(mtcd.tab_kelompok_cr * mtcd.freq),0) FROM mfi_trx_cm_detail AS mtcd WHERE mtcd.cif_no = mc.cif_no) + (SELECT COALESCE(SUM(maf.angsuran_tab_kelompok * mtaf.freq),0) FROM mfi_trx_account_financing AS mtaf, mfi_account_financing AS maf WHERE mtaf.account_financing_no = maf.account_financing_no AND maf.cif_no = mc.cif_no AND maf.financing_type = '1')) <> madb.tabungan_kelompok)";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_count_koreksi_tmajelis($sidx,$sord,$limit_rows,$start,$cabang,$cm_code,$from_date,$thru_date){

		$param = array();

		$sql = "SELECT
		COUNT(*) AS jumlah
		FROM mfi_trx_cm AS mtc
		LEFT JOIN mfi_trx_gl AS mtg ON mtg.jurnal_trx_id = mtc.trx_cm_id
		JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_fa AS mf ON mf.fa_code = mtc.fa_code
		WHERE mtc.trx_status IN('0','1') ";

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= "AND (SELECT COUNT(*) FROM mfi_trx_gl WHERE jurnal_trx_id = mtc.trx_cm_id) = '0' ";

		$sql .= "AND mtc.trx_date BETWEEN ? AND ?";

		$param[] = $from_date;
		$param[] = $thru_date;

		$query = $this->db->query($sql,$param);

		$row = $query->row_array();

		if(isset($row['jumlah'])){
			$result = $row['jumlah'];
		} else {
			$result = 0;
		}

		return $result;
	}

	function jqgrid_list_koreksi_tmajelis($sidx,$sord,$limit_rows,$start,$cabang,$cm_code,$from_date,$thru_date){
		$order = '5,4';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
		mtc.trx_date,
		mb.branch_name,
		mcm.cm_name,
		COUNT(mtg.trx_gl_id) AS jurnal_transaksi,
		mf.fa_name
		FROM mfi_trx_cm AS mtc
		LEFT JOIN mfi_trx_gl AS mtg ON mtg.jurnal_trx_id = mtc.trx_cm_id
		JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_fa AS mf ON mf.fa_code = mtc.fa_code
		WHERE mtc.trx_status IN('0','1') ";

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= "AND (SELECT COUNT(*) FROM mfi_trx_gl WHERE jurnal_trx_id = mtc.trx_cm_id) = '0' ";

		$sql .= "AND mtc.trx_date BETWEEN ? AND ? ";

		$param[] = $from_date;
		$param[] = $thru_date;

		$sql .= "GROUP BY 1,2,3,5";

		$sql .= $order.' '.$limit;

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_data_koreksi_tmajelis($cabang,$cm_code,$from_date,$thru_date){
		$param = array();

		$sql = "SELECT
		mtc.trx_cm_id
		FROM mfi_trx_cm AS mtc
		LEFT JOIN mfi_trx_gl AS mtg ON mtg.jurnal_trx_id = mtc.trx_cm_id
		JOIN mfi_cm AS mcm ON mcm.cm_code = mtc.cm_code
		JOIN mfi_branch AS mb ON mb.branch_id = mcm.branch_id
		JOIN mfi_fa AS mf ON mf.fa_code = mtc.fa_code
		WHERE mtc.trx_status IN('0','1') ";

		if($cabang != '00000'){
			$sql .= "AND mb.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $cabang;
		}

		if($cm_code != '00000'){
			$sql .= "AND mcm.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= "AND (SELECT COUNT(*) FROM mfi_trx_gl WHERE jurnal_trx_id = mtc.trx_cm_id) = '0' ";

		$sql .= "AND mtc.trx_date BETWEEN ? AND ? ";

		$param[] = $from_date;
		$param[] = $thru_date;

		$sql .= "GROUP BY 1";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_trx_cm_detail($trx_cm_id){
		$sql = "SELECT * FROM mfi_trx_cm_detail WHERE trx_cm_id = ?";

		$param = array($trx_cm_id);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_financing_lunas($trx_cm_detail_id){
		$sql = "SELECT COUNT(*) AS jumlah FROM mfi_account_financing_lunas WHERE trx_cm_detail_id = ?";

		$param = array($trx_cm_detail_id);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function show_savingplan($trx_cm_detail_id){
		$sql = "SELECT * FROM mfi_trx_cm_detail_savingplan WHERE trx_cm_detail_id = ?";

		$param = array($trx_cm_detail_id);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_savingplan_account($trx_cm_detail_savingplan_id){
		$sql = "SELECT * FROM mfi_trx_cm_detail_savingplan_account WHERE trx_cm_detail_savingplan_id = ?";

		$param = array($trx_cm_detail_savingplan_id);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_detail_droping($trx_cm_detail_id){
		$sql = "SELECT * FROM mfi_trx_cm_detail_droping WHERE trx_cm_detail_id = ?";

		$param = array($trx_cm_detail_id);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function show_cm_lwk($trx_cm_detail_id){
		$sql = "SELECT * FROM mfi_trx_cm_lwk WHERE trx_cm_detail_id = ?";

		$param = array($trx_cm_detail_id);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function delete_table($table,$param){
		$this->db->delete($table,$param);
	}
}