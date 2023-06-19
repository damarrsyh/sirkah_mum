<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function api_post_data($url,$fields)
{
	$field_string = http_build_query($fields);
	// echo $field_string;
	// die();
	if(!isset($field_string)) $field_string = array();
	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
	//curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
	//curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

	//execute post
	$content = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	//close connection
	curl_close($ch);
	// echo $content;
	// die();
	$ret = json_decode($content);
	$data = array('data'=>$ret,'message'=>$httpcode);
	return $data;
}

function api_post_data_add($url,$fields,$keyword){
	$field_string = http_build_query($fields);

	if(!isset($field_string)) $field_string = array();

	$ch = curl_init();

	$header = array();
	/*
	$header[] = 'Authorization: Bearer '.$keyword;
	$header[] = 'Content-Type: application/x-www-form-urlencoded ';
	*/
	$header[] = 'key: '.$keyword;

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	//curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
	//curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

	$content = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	curl_close($ch);

	/*
	echo $content;
	die();
	*/

	$ret = json_decode($content);
	$data = array(
		'data' => $ret,
		'message' => $httpcode
	);

	return $data;
}

function api_jqgrid_data($url,$fields)
{
	$field_string = http_build_query($fields);

	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, count($field_string));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
	//curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
	//curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

	//execute post
	$content = curl_exec($ch);
	//close connection
	curl_close($ch);
	
	echo $content;
}

function getJSONData($url,$keyword)
{
	$ch = curl_init();
	$headr = array();
	$headr[] = 'Authorization: Bearer '.$keyword;

	// pass header variable in curl method
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);

	$data = curl_exec($ch); // execute curl request
	curl_close($ch);

	return $data;
}



         
set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno) {
  if (error_reporting() == 0) {
    return;
  }
  if (error_reporting() & $severity) {
    throw new ErrorException($message.'. '.$filename.' Line : '.$lineno, 0, $severity, $filename, $lineno);
  }
}