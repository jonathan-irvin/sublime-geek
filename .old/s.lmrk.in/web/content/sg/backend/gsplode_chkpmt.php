<?php
include 'config.php';
connect2slm();

$auth_config    = "ED20F44C5B3A71A345189ACFBA0C25A16F11D960ED20F44C5B3A71A345189ACFBA0C25A16F11D960";
$auth			= $_POST['auth'];
$chkpmtsql      = "SELECT * FROM `gsplode_pending_payouts`";
$chkpmtres      = mysql_query($chkpmtsql);
$chkpmtnum      = mysql_num_rows($chkpmtres);

if($auth == $auth_config){
	if($chkpmtnum > 0){ //We have pending payments, process
	  $cp_row       = mysql_fetch_object($chkpmtres);
	  $id			= $cp_row->id;
	  $gsid			= $cp_row->gsid;
	  $t_id 		= $cp_row->transid;
	  $w_name		= $cp_row->winner_name;
	  $w_key		= $cp_row->winner_key;
	  $p_amt		= $cp_row->payout_amt;
	  $type			= $cp_row->type;
	  $msg			= $cp_row->msg;
	  
	  if($type == "PAY"){
		print("pmt;$w_key;$p_amt;$msg");
		$logsql       = "INSERT INTO `gsplode_payout_log` (`id` ,`transid` ,`payee_name` ,`payee_key` ,`pmt_amt` ,`timestamp`)
						VALUES (NULL , '$t_id', '$w_name', '$w_key', '$p_amt', NOW())";
		mysql_query($logsql) or die(mysql_error()); 
	  }
	  elseif($type == "MSG"){print("msg;$w_key;$msg");}
	  elseif($type == "TST"){print("msg;6aab7af0-8ce8-4361-860b-7139054ed44f;$msg");}	  
	  $delsql       = "DELETE FROM `gsplode_pending_payouts` WHERE `id` = $id";
	  mysql_query($delsql) or die(mysql_error()); 
	} else {print("none");}
}else {print("msg;6aab7af0-8ce8-4361-860b-7139054ed44f;Not Authorized...Check the pay server");}
?>