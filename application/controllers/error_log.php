<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
[PERHATIAN]
Source Code ini milik PT AMA Salam Indonesia.
Dilarang menggunakan sebagian atau seluruhnya tanpa izin tertulis dari PT AMA Salam Indonesia 
*/

class Error_log extends CI_Controller {

	function __construct(){
		parent::__construct(FALSE);
	}

	function write(){
		date_default_timezone_set('Asia/Jakarta');

		$url = $this->input->post('url');
		$status = $this->input->post('status');
		$statusText = $this->input->post('statusText');
		$responseText = $this->input->post('responseText');
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('fullname');

		$data = array(
			'date_time' => $created_date,
			'status' => $status,
			'status_text' => $statusText,
			'url' => $created_by.' - '.$url,
			'error' => $responseText
		);

		$this->db->insert('mfi_log_error',$data);
	}

}

/*
[PERHATIAN]
Source Code ini milik PT AMA Salam Indonesia.
Dilarang menggunakan sebagian atau seluruhnya tanpa izin tertulis dari PT AMA Salam Indonesia 
*/
