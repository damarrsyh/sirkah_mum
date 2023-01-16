<?php

Class Model_api extends CI_Model {

	function get_all_document($map_no){
		$sql = "SELECT
		ttd_anggota,
		doc_ktp,
		doc_kk,
		doc_pendukung
		FROM mfi_account_financing_reg WHERE map_no = ?";

		$param = array($map_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function insert_batch($table,$data){
		$this->db->insert_batch($table,$data);
	}

}