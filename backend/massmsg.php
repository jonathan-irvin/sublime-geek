<?php

//Connect to the DB
include 'config.php';
connect2slm();

$active = FALSE;

//Message Scripts
$loss_msg	  = "GridSplode bug has been fixed.  
Feel free to re-rez your GridSplodes or visit any GridSplode location to play.
  Questions?  Visit http://sublimegeek.com/support for assistance.";

//Use this for messaging and send a "You Lost" message to the losers
if($active){
		$msg_sql = "SELECT id,gsid,player_name,player_key FROM `gsplode_pay_log` GROUP BY player_key";
		$msg_res = mysql_query($msg_sql);
		
		while($msg_row = mysql_fetch_array($msg_res)){
			$loser_name = $msg_row['player_name'];
			$loser_key  = $msg_row['player_key'];
			
			$loser_transid = seqid();			
			
			mysql_query("INSERT INTO `geekfox_ms`.`gsplode_pending_payouts` 
						(`id` ,`gsid` ,`transid` ,`winner_name` ,`winner_key` ,`payout_amt` , `type` , `msg` ,`timestamp`)		
						VALUES
						(NULL , '0', '$loser_transid', '$loser_name', '$loser_key', '0', 'MSG','$loss_msg', CURRENT_TIMESTAMP)");			
			print("Message Sent to $loser_name<br>");
		}
}

?>
