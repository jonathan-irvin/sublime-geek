<?php

//Connect to the DB
include 'config.php';
connect2slm();

//Message Scripts
$loss_msg	  = "I\'m sorry, you were not a winner this time, but you still have a chance!  \nVisit any GridSplode location and enter to win!\nRemember, the more you enter, the more chance you have to win!";

//This script is designed to check if we have any expired sessions for announcing splodes
$check_sql    = "SELECT * FROM `gsplode_sessions` WHERE `status` = 'FILLED'";
$check_res    = mysql_query($check_sql);
$check_row    = mysql_fetch_object($check_res);
$check_num    = mysql_num_rows($check_res);
$check_id     = $check_row->gsid;
$check_type   = $check_row->gs_type_id;
$tid          = $check_row->gsid;
$check_surplus= $check_row->bal_surplus;
$bal_needed   = $check_row->bal_needed;
$bal_surplus  = $check_surplus;

$a_sql = "SELECT * FROM `gsplode_sessions` WHERE `status` = 'ANNOUNCE'";
$a_res = mysql_query($a_sql);
$a_row = mysql_fetch_object($a_res);
$a_num = mysql_num_rows($a_res);

if($check_num ==1){//We have a valid session to splode
	$expires = $check_row->completed;
	$created = $check_row->created;
	$winners = $check_row->winners;
	$gsid	 = $check_row->gsid;
	$exptime = strtotime($expires);		
	$timedif = time() - $exptime;
	//$timedif = 1;
	
	if((($timedif < 30)&&($timedif >= 0)&&($winners == ""))){
	//Expire time between 0-30sec & winners haven't been populated
		$tier_sql       = "SELECT * FROM `gsplode_splode_config` WHERE `id` = '$check_type'";
		$tier_res       = mysql_query($tier_sql) or die();
		$tier_row       = mysql_fetch_object($tier_res);
		$tier_num       = mysql_num_rows($tier_res);
		
		print("check;splode;KABOOOOOOOOOOOOOOOOOOOM!");

		if($tier_num == 1){
			//Let's build all the info for the current tier we are using	
			$tier_id         = $tier_row->id;
			$tier_name       = strtoupper($tier_row->name);
			$tier_min_pay    = $tier_row->min_pay;
			$tier_usr_comm   = $tier_row->usr_comm;
			$tier_min_entries= $tier_row->min_entries;
			$tier_p_one 	 = $tier_row->p_one;
			$tier_p_two 	 = $tier_row->p_two;
			$tier_p_three 	 = $tier_row->p_three;
		}
		
		$p1_mod			 = floor($bal_surplus * 0.10);
		$p2_mod			 = floor($bal_surplus * 0.15);
		$p3_mod			 = floor($bal_surplus * 0.25);
		$adm_mod		 = floor($bal_surplus * 0.50);
		
		$p_one      	 = $tier_p_one   + $p1_mod;
		$p_two      	 = $tier_p_two   + $p2_mod;
		$p_three      	 = $tier_p_three + $p3_mod;
		
		$win1_sql = "SELECT * FROM `gsplode_pay_log` WHERE `gsid` = $gsid 
		AND `player_key` != '6aab7af0-8ce8-4361-860b-7139054ed44f'
		AND `player_key` != '9373569d-db5f-45f3-9f51-4e4498e34adb'
		ORDER BY RAND()";
		$win1_res = mysql_query($win1_sql);				
		$win1_row = mysql_fetch_array($win1_res);
		$p1_name = $win1_row['player_name'];
		$p1_key  = $win1_row['player_key'];
		$winners[] = $p1_name.",".$p1_key;
		
		$win2_sql = "SELECT * FROM `gsplode_pay_log` WHERE `gsid` = $gsid 
		AND `player_key` != '6aab7af0-8ce8-4361-860b-7139054ed44f'
		AND `player_key` != '9373569d-db5f-45f3-9f51-4e4498e34adb'
		AND `player_key` != '$p1_key'
		ORDER BY RAND()";
		$win2_res = mysql_query($win2_sql);				
		if($win2_res){
			$win2_row = mysql_fetch_array($win2_res);
			$p2_name = $win2_row['player_name'];
			$p2_key  = $win2_row['player_key'];
			array_push($winners,$p2_name.",".$p2_key);
		}else{mysql_query("UPDATE `gsplode_sessions` SET `bal_surplus` = `bal_surplus`+ $p_two WHERE `gs_type_id` = $check_type AND `status` = 'OPEN'");}
		
		$win3_sql = "SELECT * FROM `gsplode_pay_log` WHERE `gsid` = $gsid 
		AND `player_key` != '6aab7af0-8ce8-4361-860b-7139054ed44f'
		AND `player_key` != '9373569d-db5f-45f3-9f51-4e4498e34adb'
		AND `player_key` != '$p1_key'
		AND `player_key` != '$p2_key'
		ORDER BY RAND()";
		$win3_res = mysql_query($win3_sql);
		if($win3_res){		
			$win3_row = mysql_fetch_array($win3_res);
			$p3_name = $win3_row['player_name'];
			$p3_key  = $win3_row['player_key'];
			array_push($winners,$p3_name.",".$p3_key);
		}else{mysql_query("UPDATE `gsplode_sessions` SET `bal_surplus` = `bal_surplus`+ $p_three WHERE `gs_type_id` = $check_type AND `status` = 'OPEN'");}
		
		$p1_winner 		 = $winners[0].",".$p_one.	    "::";
		$p2_winner 		 = $winners[1].",".$p_two.	    "::";
		$p3_winner 		 = $winners[2].",".$p_three.	"::";
		
		$tot_win         = $tier_p_one + $tier_p_two + $tier_p_three;
		$remaining		 = floor(($bal_needed - $tot_win)* 0.5);
		$adm_take_mcd	 = floor($remaining);
		$adm_take_sig	 = floor($remaining + $adm_mod);
		
		$trans_1		 = seqid();
		$trans_2		 = seqid();
		$trans_3		 = seqid();
		$trans_4		 = seqid();
		$trans_5		 = seqid();
		
		$csv_p1			 = explode(",",$winners[0]);
		$csv_p2			 = explode(",",$winners[1]);
		$csv_p3			 = explode(",",$winners[2]);
		
		$adm_msg_mcd	 = "Admin Payout...\nTier: $tier_name\nTID: $gsid\nCreated: $created GMT -6\nCompleted: $expires GMT -6\nCommission: L$$adm_take_mcd";
		$adm_msg_sig	 = "Admin Payout...\nTier: $tier_name\nTID: $gsid\nCreated: $created GMT -6\nCompleted: $expires GMT -6\nCommission: L$$adm_take_sig";
		
		mysql_query("INSERT INTO `geekfox_ms`.`gsplode_pending_payouts` 
		(`id` ,`gsid` ,`transid` ,`winner_name` ,`winner_key` ,`payout_amt` , `type` , `msg` ,`timestamp`)		
		VALUES 
			(NULL , '$gsid', '$trans_1', '$csv_p1[0]', '$csv_p1[1]', '$p_one',   'PAY','Today is your lucky day!  You\'ve just won L$$p_one from the [sig] GridSplode! \nThanks for playing and we hope to see you again!', CURRENT_TIMESTAMP),
			(NULL , '$gsid', '$trans_2', '$csv_p2[0]', '$csv_p2[1]', '$p_two',   'PAY','Today is your lucky day!  You\'ve just won L$$p_two from the [sig] GridSplode! \nThanks for playing and we hope to see you again!', CURRENT_TIMESTAMP),
			(NULL , '$gsid', '$trans_3', '$csv_p3[0]', '$csv_p3[1]', '$p_three', 'PAY','Today is your lucky day!  You\'ve just won L$$p_three from the [sig] GridSplode! \nThanks for playing and we hope to see you again!', CURRENT_TIMESTAMP),
			(NULL , '$gsid', '$trans_4', 'Jon Desmoulins', '6aab7af0-8ce8-4361-860b-7139054ed44f', '$adm_take_sig', 'PAY','$adm_msg_sig',CURRENT_TIMESTAMP),
			(NULL , '$gsid', '$trans_5', 'Monkey Canning', '9373569d-db5f-45f3-9f51-4e4498e34adb', '$adm_take_mcd', 'PAY','$adm_msg_mcd',CURRENT_TIMESTAMP)
		");
		
		//Use this for messaging and send a "You Lost" message to the losers
		$msg_sql = "SELECT id,gsid,player_name,player_key FROM `gsplode_pay_log` 
		WHERE `gsid` = $gsid 		
		GROUP BY player_key";
		$msg_res = mysql_query($msg_sql);
		
		while($msg_row = mysql_fetch_array($msg_res)){
			$loser_name = $msg_row['player_name'];
			$loser_key  = $msg_row['player_key'];
			
			$loser_transid = seqid();
			
			if( ($loser_key != $csv_p1[1]) || ($loser_key != $csv_p2[1]) || ($loser_key != $csv_p3[1]) ){
				mysql_query("INSERT INTO `geekfox_ms`.`gsplode_pending_payouts` 
							(`id` ,`gsid` ,`transid` ,`winner_name` ,`winner_key` ,`payout_amt` , `type` , `msg` ,`timestamp`)		
							VALUES
							(NULL , '$gsid', '$loser_transid', '$loser_name', '$loser_key', '0', 'MSG','$loss_msg', CURRENT_TIMESTAMP)");
			}
		}
		
		//Change the status of the session to announce to let everyone know who won
		$winnerlist = "$p1_winner\n$p2_winner\n$p3_winner";
		mysql_query("UPDATE `geekfox_ms`.`gsplode_sessions` 
		SET `winners` = '$winnerlist',`status` = 'ANNOUNCE' WHERE `gsplode_sessions`.`gsid` = $gsid");
		
		die();
	}
}

if($a_num == 1){
	$expires      = $a_row->completed;
	$gsid         = $a_row->gsid;
	$a_id         = $a_row->gsid;
	$a_win        = $a_row->winners;
	$exptime      = strtotime($expires);  
	$tdif         = time() - $exptime;
	//$tdif         = 1;
	
	print("check;announce;");
	
	$split_winners= explode("::",$a_win); 
	
	$a_w3         = explode(",",$split_winners[0]);
	$a_w2         = explode(",",$split_winners[1]);
	$a_w1         = explode(",",$split_winners[2]); 
	
	$w3           = trim($a_w3[0]." - L$".$a_w3[2]);
	$w2           = trim($a_w2[0]." - L$".$a_w2[2]);
	$w1           = trim($a_w1[0]." - L$".$a_w1[2]);
	
	print("$w1::$w2::$w3");
	
	if($tdif >= 60){		
		mysql_query("UPDATE `geekfox_ms`.`gsplode_sessions` 
		SET `status` = 'CLOSED' WHERE `gsplode_sessions`.`gsid` = $gsid");
	}
}
?>