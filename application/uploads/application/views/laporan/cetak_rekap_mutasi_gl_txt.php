<?php
        header("Content-Type: plain/text");
        header("Content-Disposition: Attachment; filename=rekap_mutasi_gl.txt");
        header("Pragma: no-cache");
?>
<?php 
  $CI = get_instance(); 

  foreach ($datas as $key) {
    $flag = ($key['flag_debit_credit']=="D") ? "DEBET" : "CREDIT" ;

    echo '"'.$key['account_code'].'",';
    echo '"'.$flag.' '.$key['account_name'].'",';
    echo '"'.$key['debit'].'",';
    echo '"'.$key['credit'].'"';
    echo "\r\n";
  }
?> 
