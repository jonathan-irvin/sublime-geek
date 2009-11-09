<?php

include 'config.php';
connect2slm();

$transid        = seqid();
$frm            = $_POST['frm'];
$frm_name       = $_POST['frm_name'];
$to             = $_POST['to'];
$to_name        = $_POST['to_name'];
$amt            = $_POST['amt'];
$type           = $_POST['type'];

$ins_tip = "INSERT INTO `mtip_translog` 
        (`transid`,`pmt_type`,`pmt_from`,`pmt_from_name`,`pmt_to`,`pmt_to_name`,`pmt_amt`,`timestamp`)
VALUES  ('$transid','$type','$frm','$frm_name','$to','$to_name','$amt',CURRENT_TIMESTAMP)";
mysql_query($ins_tip);
?>