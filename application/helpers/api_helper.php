<?php
function getJSONRequest($url,$param,$token){
  // set_time_limit(0);
  $field_string = http_build_query($param);
  if(!isset($field_string)) $field_string = array();
  /*
  if (count($param)>0) {
    $field_string = http_build_query($param);
    $url = $url.'?'.$field_string;
  }
  */

  /*
  $CI = get_instance();
  $token = $CI->session->userdata('token');
  */
  
  //$headers = array();

  $headers = array(
    "Content-Type: application/json;",
    "key: " . $token
  );

  /*
  if (isset($token)) {
    array_push($headers, 'key: '.$token);
  }
  */

  // Open connection
  $ch = curl_init();

  // Set the url, number of GET vars, GET data
  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
  // curl_setopt($ch, CURLOPT_POST, false);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
  // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, 1800);

  // Execute request
  $response = curl_exec($ch);
  $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  // extract header
  $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$response_header = substr($response, 0, $headerSize);
  $response_header = getHeaders($response_header);
  
	// extract body
  $response_body = substr($response, $headerSize);

  // Close connection
  curl_close($ch);

  if ($response_body == null) {
    $response_body = errorResponse();
  }

  return json_decode($response_body, true);
}


function getHeaders($respHeaders) {
  $headers = array();
  $headerText = substr($respHeaders, 0, strpos($respHeaders, "\r\n\r\n"));
  foreach (explode("\r\n", $headerText) as $i => $line) {
      if ($i === 0) {
          $headers['http_code'] = $line;
      } else {
          list ($key, $value) = explode(': ', $line);
          $headers[$key] = $value;
      }
  }
  return $headers;
}

function postJSONRequest($url, $fields=array()) {
  // set_time_limit(0);
  $field_string = http_build_query($fields);

  $CI = get_instance();
  $token = $CI->session->userdata('token');

  $headers = array();
  if (isset($token)) {
    array_push($headers, 'token: '.$token);
  }

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  // curl_setopt($ch, CURLOPT_TIMEOUT, 120);
  curl_setopt($ch, CURLOPT_POST, @count($field_string));
  curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, 1800);

  // Execute request
  $response = curl_exec($ch);
  $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  // extract header
  $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$response_header = substr($response, 0, $headerSize);
  $response_header = getHeaders($response_header);
  
	// extract body
  $response_body = substr($response, $headerSize);

  // Close connection
  curl_close($ch);

  if ($response_body == null) {
    $response_body = errorResponse();
  }

  return json_decode($response_body, true);
}

function postMultipartJSONRequest($url, $fields=array(), $files=array()) {
  // $headers = array("Content-Type:multipart/form-data"); // cURL headers for file uploading
  // set_time_limit(0);

  $boundary = uniqid();
  $delimiter = '-------------' . $boundary;

  $data = build_data_files($boundary, $fields, $files);

  $ch = curl_init($url);

  $headers = array(
    //"Authorization: Bearer $TOKEN",
    "Content-Type: multipart/form-data; boundary=" . $delimiter,
    "Content-Length: " . strlen($data)
  );
  
  $CI = get_instance();
  $token = $CI->session->userdata('token');

  if (isset($token)) {
    array_push($headers, 'token: '.$token);
  }
  // print_r($headers);
  // print_r($data);
  // die();

  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  // curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, 1800);

  // Execute request
  $response = curl_exec($ch);
  $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  // extract header
  $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$response_header = substr($response, 0, $headerSize);
  $response_header = getHeaders($response_header);
  
	// extract body
  $response_body = substr($response, $headerSize);

  // Close connection
  curl_close($ch);

  if ($response_body == null) {
    $response_body = errorResponse();
  }
  return json_decode($response_body, true);
}

function build_data_files($boundary, $fields, $files){
  $data = '';
  $eol = "\r\n";

  $delimiter = '-------------' . $boundary;

  foreach ($fields as $name => $content) {
      $data .= "--" . $delimiter . $eol
          . 'Content-Disposition: form-data; name="' . $name . "\"".$eol.$eol
          . $content . $eol;
  }

  foreach ($files as $name => $content) {
      $filename = $content['filename'];
      $filetmp = $content['filetmp'];
      $data .= "--" . $delimiter . $eol
          . 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $filename . '"' . $eol
          //. 'Content-Type: image/png'.$eol
          . 'Content-Transfer-Encoding: binary'.$eol
          ;

      $data .= $eol;
      $data .= $filetmp . $eol;
  }
  $data .= "--" . $delimiter . "--".$eol;


  return $data;
}

function errorResponse() {
  return json_encode(array(
    'success'=>false,
    'message'=>'Failed: Please check your internet connection!',
    'causes'=>'CURL ERROR!'
  ));
}