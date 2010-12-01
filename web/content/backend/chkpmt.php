<?php
include 'config.php';
connect2slm();

$chkpmtsql      = "SELECT 
`pid`           as 'id',
`pmt_to`        as 'to',
`pmt_amt`       as 'total'
FROM `mtip_pending_trans` WHERE `pmt_amt` >= 1.0";

$chkpmtres      = mysql_query($chkpmtsql);
$chkpmtnum      = mysql_num_rows($chkpmtres);

if($chkpmtnum > 0){ //We have pending payments, process

  $chkpmtrow    = mysql_fetch_array($chkpmtres);
  $id           = $chkpmtrow['id'];
  $key          = $chkpmtrow['to'];
  $total        = $chkpmtrow['total'];
  
  $payout       = floor($total); //Turn the total into an integer, this is how much we will pay out
  $remain       = $total - $payout;
  
  print("pmt,$key,$total");
  
  $updsql       = "UPDATE  `mtip_pending_trans` 
  SET  
  `pmt_amt` = '$remain',
  `timestamp` = CURRENT_TIMESTAMP 
  WHERE `pid` = '$id'";
  mysql_query($updsql) or die("err,6aab7af0-8ce8-4361-860b-7139054ed44f,".mysql_error());
} else {print("none");} 

?>