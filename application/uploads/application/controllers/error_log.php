<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error_log extends GMN_Controller {

	public function __construct()
	{
		parent::__construct(true);
	}

	function write()
	{
		date_default_timezone_set('Asia/Jakarta');

		$url = $this->input->post('url');
		$status = $this->input->post('status');
		$statusText = $this->input->post('statusText');
		
		$responseText = "[".date('Y-m-d H:i:s')."] ".$status." - ".$statusText."\r\n";
		$responseText .= "[URL] ".$url."\r\n\r\n";
		$responseText .= $this->input->post('responseText')."\r\n";
		$responseText .= "----------------------------------------------------------------------\r\n";

		$file = 'error_log.txt';
		// Open the file to get existing content
		$text = file_get_contents($file);
		// Append a new person to the file
		$text .= $responseText;
		// Write the contents back to the file
		file_put_contents($file, $text);
	
	}

}