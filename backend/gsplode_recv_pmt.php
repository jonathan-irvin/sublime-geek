<?php

//Connect to the DB

include 'config.php';
connect2slm();

//Key to use for auth
//Is this one of our grid sploders?
$auth_config    = "7399F2FB0B4C2DF30E5D2F0CFF59B6516C64BF58";

//System Version
$version        = 1.2;
$DEBUG          = FALSE;

//Default Commission
$usr_commission = 0.2;

//First, lets check the config for the system status
//Also, we need to grab some other important stuff

$sys_sql        = "SELECT * from `gsplode_config`";
$sys_res        = mysql_query($sys_sql) or die();
$sys_status     = mysql_result($sys_res,0,'status');     //System status
$sys_multi_base = mysql_result($sys_res,0,'multi_base'); //Base multiplier
$sys_multi_prize= mysql_result($sys_res,0,'multi_prize');//Multiplier for prize money
$sys_multi_tier = mysql_result($sys_res,0,'multi_tier'); //Multiplier for prize tiers
$sys_num_prize  = mysql_result($sys_res,0,'num_prize');  //Number of prizes available

//Grab the information we just received from SL

$player_name    = $_POST['player_name'];
$player_key     = $_POST['player_key'];
$pmt_amt        = floor($_POST['pmt_amt']);
$slurl          = $_POST['slurl'];
$auth_recv      = $_POST['auth'];
$v_recv         = $_POST['version'];

$dividend_amt   = $pmt_amt * $usr_commission;
$deposit_amt    = $pmt_amt - $dividend_amt;

if($DEBUG){
	print("DEBUG VALUES:
	
	System Settings
	----------------
	Status: $sys_status
	Multiplier Base: $sys_multi_base
	Multiplier Prize: $sys_multi_prize
	Multiplier Tier: $sys_multi_tier
	Num Prizes: $sys_num_prize
	
	Received from SL
	----------------	
	PlayerName: $player_name
	PlayerKey: $player_key
	PaymentAmt: $pmt_amt
	SLURL: $slurl
	Auth: $auth_recv
	Version: $v_recv");
}

//Based on the payment amount, which tier does it belong to?

$tier_sql       = "SELECT * FROM `gsplode_splode_config` WHERE `min_pay` = '$pmt_amt'";
$tier_res       = mysql_query($tier_sql) or die();
$tier_row       = mysql_fetch_array($tier_res);
$tier_num       = mysql_num_rows($tier_res);
if($tier_num    == 1){
	//Let's build all the info for the current tier we are using
	
	$tier_id         = $tier_row['id'];
	$tier_name       = $tier_row['name'];
	$tier_min_pay    = $tier_row['min_pay'];
	$tier_usr_comm   = $tier_row['usr_comm'];
	$tier_p_one 	 = number_format($tier_row['p_one']);
	$tier_p_two 	 = number_format($tier_row['p_two']);
	$tier_p_three 	 = number_format($tier_row['p_three']);
	$tier_min_entries= $tier_row['min_entries'];
	$tier_time_to_exp= $tier_row['ttexp'];
}

if($DEBUG){
	print("
	Tier VALUES:
	---------------
	Tier Name: $tier_name
	Prize 1: $tier_p_one
	Prize 2: $tier_p_two
	Prize 3: $tier_p_three
	");}

//Now, let's check for any filled sessions
//Where the gs_type_id matches the tier we are using
//A filled session is where we have enough entries,
//we just haven't expired yet.

$filled_sql = "SELECT *,UNIX_TIMESTAMP(`completed`) AS 'ttexp' FROM `gsplode_sessions` WHERE 
	`status` = 'FILLED'
	AND `gs_type_id` = '$tier_id' ORDER BY `status` DESC";
$filled_res = mysql_query($filled_sql) or die();
$filled_num = mysql_num_rows($filled_res);
$filled_row = mysql_fetch_object($filled_res);

//We have filled sessions grab the data from it
$filled_id         = $filled_row->gsid;
$filled_type_id    = $filled_row->gs_type_id;
$filled_bal_surplus= $filled_row->bal_surplus;
$filled_cur_bal    = $filled_row->cur_bal;
$filled_bal_needed = $filled_row->bal_needed;
$filled_ent_min    = $filled_row->ent_min;
$filled_ent_total  = $filled_row->ent_total;
$filled_winners    = $filled_row->winners;
$filled_status     = $filled_row->status;
$filled_created    = $filled_row->created;
$filled_completed  = $filled_row->completed;
$filled_ttexp      = $filled_row->ttexp;

$open_sql 		   = "SELECT * FROM `gsplode_sessions` WHERE 
	`status` = 'OPEN'
	AND `gs_type_id` = '$tier_id' ORDER BY `status` DESC";
$open_res        = mysql_query($open_sql) or die();
$open_row        = mysql_fetch_object($open_res);
$open_num        = mysql_num_rows($open_res);

$open_id         = $open_row->gsid;
$open_type_id    = $open_row->gs_type_id;
$open_bal_surplus= $open_row->bal_surplus;
$open_cur_bal    = $open_row->cur_bal;
$open_bal_needed = $open_row->bal_needed;
$open_ent_min    = $open_row->ent_min;
$open_ent_total  = $open_row->ent_total;
$open_winners    = $open_row->winners;
$open_status     = $open_row->status;
$open_created    = $open_row->created;
$open_completed  = $open_row->completed;

function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
    
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time();
    $unix_date       = strtotime($date);
    
       // check validity of date
    if(empty($unix_date)) {    
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense          = "ago";
        
    } else {
        $difference     = $unix_date - $now;
        $tense          = "";
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        $periods[$j].= "s";
    }
    
    if($now > $unix_date) {
		return "Any second now...";
	}else{return "$difference $periods[$j] {$tense}";}
}

if($DEBUG){
	print("	
	Total Open Sessions: $open_num
	Total Filled Sessions: $filled_num");
}

function new_session($tid,$deposit,$t_minpay,$min_entries,$e_tot){
	//This is a new session
				//We still want to increase the entry by one
				//And add their payment to the existing balance
								
				
				$t_comm			= $t_minpay * 0.2; //Commission
				$minpay_nocomm	= $t_minpay - $t_comm;				
				$new_bal_needed = $minpay_nocomm * $min_entries;				
				
				$new_sql		= "INSERT INTO  `geekfox_ms`.`gsplode_sessions` (
									`gsid` ,
									`gs_type_id` ,
									`cur_bal` ,
									`bal_surplus` ,
									`bal_needed` ,
									`ent_min` ,
									`ent_total` ,
									`winners` ,
									`status` ,
									`created` ,
									`completed`
									)
									VALUES (
									NULL ,  
									'$tid',  
									'$deposit',
									'0',
									'$new_bal_needed',  
									'$min_entries',  
									'$e_tot',  
									'',  
									'OPEN', 
									NOW(),  
									'0000-00-00 00:00:00'
									)";
				$new_res 		= mysql_query($new_sql) or die("\nNewSession: ".mysql_error());
				//print("New Session SQL: $new_sql");
				
				sleep(3); //Delay the script slightly on new entries for payment logging
				
				$oid_sql		= "SELECT * FROM `geekfox_ms`.`gsplode_sessions`
								  WHERE `gs_type_id` = '$tid' AND `status` = 'OPEN'";
				$oid_res		= mysql_query($oid_sql) or die("\nNewSessionOid: ".mysql_error());
				$oid_row		= mysql_fetch_object($oid_res);				
				$oid_gen		= $oid_row->gsid;
				
				return			$oid_gen;
}

function new_overflow_session($tid,$deposit,$t_minpay,$min_entries,$e_tot){
	//This is a new session
				//We still want to increase the entry by one
				//And add their payment to the existing balance
								
				
				$t_comm			= $t_minpay * 0.2; //Commission
				$minpay_nocomm	= $t_minpay - $t_comm;				
				$new_bal_needed = $minpay_nocomm * $min_entries;				
				
				$new_sql		= "INSERT INTO  `geekfox_ms`.`gsplode_sessions` (
									`gsid` ,
									`gs_type_id` ,
									`cur_bal` ,
									`bal_surplus` ,
									`bal_needed` ,
									`ent_min` ,
									`ent_total` ,
									`winners` ,
									`status` ,
									`created` ,
									`completed`
									)
									VALUES (
									NULL ,  
									'$tid',  
									'0',
									'$deposit',
									'$new_bal_needed',  
									'$min_entries',  
									'$e_tot',  
									'',  
									'OPEN', 
									NOW(),  
									'0000-00-00 00:00:00'
									)";
				$new_res 		= mysql_query($new_sql) or die("\nNewOFSession: ".mysql_error());
				//print("New Session SQL: $new_sql");
				
				sleep(3); //Delay the script slightly on new entries for payment logging
				
				$oid_sql		= "SELECT * FROM `geekfox_ms`.`gsplode_sessions`
								  WHERE `gs_type_id` = '$tid' AND `status` = 'OPEN'";
				$oid_res		= mysql_query($oid_sql) or die("\nNewSessionOid: ".mysql_error());
				$oid_row		= mysql_fetch_object($oid_res);				
				$oid_gen		= $oid_row->gsid;
				
				return			$oid_gen;
}

function open_session($oid,$deposit,$cur_bal,$ent_total){

	//This time, we have to enter in all the needed info				
	$open_new_bal	= $deposit + $cur_bal;
	$ent_total++;
	$open_sql		= "UPDATE  `geekfox_ms`.`gsplode_sessions` SET  
					`cur_bal`  =  '$open_new_bal',
					`ent_total`=  '$ent_total' 
					WHERE  `gsplode_sessions`.`gsid` = '$oid' LIMIT 1";
	$open_res		= mysql_query($open_sql);
	//print("Open Session SQL: $open_sql");
}

function overflow_session($oid,$deposit,$cur_bal_surplus,$ent_total){

	//This time, we have to enter in all the needed info				
	$open_new_bal_surplus	= $deposit + $cur_bal_surplus;
	$ent_total++;
	$open_sql		= "UPDATE  `geekfox_ms`.`gsplode_sessions` SET  
					`bal_surplus`  =  '$open_new_bal_surplus',
					`ent_total`    =  '$ent_total' 
					WHERE  `gsplode_sessions`.`gsid` = '$oid' LIMIT 1";
	$open_res		= mysql_query($open_sql);
	//print("Open Session SQL: $open_sql");
}

function log_pmt($oid,$pname,$pkey,$deposit,$sl_url){
	//Log the payment into the payment log				
				$pmt_open_transid    = seqid();				
				$pmt_open_sql        = "INSERT INTO  `geekfox_ms`.`gsplode_pay_log` (
											`id` ,
											`gsid` ,
											`transid` ,											
											`player_name` ,
											`player_key` ,
											`pmt_amt` ,
											`slurl` ,
											`timestamp`
											)
											VALUES (
											'',  
											'$oid',  
											'$pmt_open_transid',  											
											'$pname',  
											'$pkey',  
											'$deposit',  
											'$sl_url', 
											NOW()
											)";
				$pmt_open_res			= mysql_query($pmt_open_sql);
				//print("Log Payment SQL: $pmt_open_sql");
}

$paymentmsg = array("You've just increased your chances of winning!",
					"You've just made everyone else look bad!",
					"You've just made the Lindens happier!",
					"You must really want to win!",
					"You've just deposited a little awesome in your SLife",
					"Can't get enough can you?",
					"Is that the BEST you can do?",
					"I bet you can't do that again.",
					"Your mom could do better.",
					"I don't think you really WANT it bad enough.  Try again.",
					"You've just boosted the economy!",
					"You've just made my day!",
					"I know you can do better than THAT",
					"That...was...EPIC.",
					"Don't lie to me.  I know you have more money than that",
					"Confucious Say, 'He who pay, get to play'",
					"Epic Fail, try again...jk...but really.",
					"More!",
					"Muah hah hah hah hah!",
					"Dude...sweet.",
					"You know you could do better...",
					"God that felt amazing, do it again!",
					"*Yawn* Is that it? For a moment, I thought you were playing again.",
					"Find out the meaning of life...on the next play",
					"42...That's all you get.",
					"Your grandma could do better in her SLEEP",
					"Do you feel lucky? Huh?! Do ya punk?",
					"Brilliant!",
					"OMG LOL WTF BRB KKTHXBAI",
					"Eh, maybe...but if you played again I think I can hook you up",
					"Sorry, the princess is in another castle. Try again.",
					"[Jedi Mind Trick] You will pay again...erm these are the droids we are looking for",
					"Psst...That may not be enough, but another payment will.",
					"Don't tell me your are finished!  But but...I'm SO CLOSE",
					"Come on...oh yeah, you like that don't you?",
					"Wait...wait...a little to the left...yeah, try that again",
					"I think I'm feeling a little green, you should pay me again",
					"You've definately got mad splode'n skillz",
					"lololololololololololol...awesome",
					"This is me before you paid in :| and this is me now :D",
					"When you pay, I pay...yeah just like that",
					"Does this prim make my butt look fat?",
					"I am completely green.  I recycle L$",
					"Remember: It doesn't matter what port you use, as long as you use a firewall.",
					"Awww you shouldn't have...well, yeah you should.",
					"Keep up the good work!  I'll have college paid off in no time!",
					"You've just made the Linden Lab stock go up!",
					"You've just increased the daily L$ transaction rate!",
					"Good work!  You are helping the economy, one splode at a time",
					"I don't care what they say about you.  You are awesome!  Just don't tell them I said anything.",
					"Whatever, I know you can do better",
					"Pay me once, shame on you...Pay me twice, shame on me...Pay me three times, I've done my job \;)",
					"EXCELLENT!!! My purpose is now complete!",
					"At least you didn't have to give your lunch money to some bully",
					"Arg! I be plunderin' yer booty!",
					"Quick!!! Pay me again before someone else does!",
					"Don't feel bad, you're helping the economy",
					"If I had any more prims attached, I'd strip for you",
					"Ka-Ching!");

shuffle($paymentmsg);
$paymentmsgdsp	 = $paymentmsg[0];

//Chance messages
$min_e = $tier_min_entries;
$min_p = $tier_min_pay;

$chance_sql = "SELECT COUNT(*) as 'tot_plays' WHERE `player_key` = '$player_key'";


if($auth_config == $auth_recv){//This is not an imposter
	if($sys_status == ("ONLINE" || "DEBUG")){
	//Only do stuff if we are online or testing
	print($sys_status.";/me says to $player_name, \"$paymentmsgdsp\"\nThanks for playing!  Remember, the more you enter, the more chances you have at winning!!!");
		if($filled_num == 1){
			if($filled_ttexp > time()){//We still have some time remaining on a filled session
				//print("Filled Completed > Now\n");
				//Lets add their entry in with this session, but allocate the funds to the next open session				
				$pmt_filled_gsid       = $filled_id;
				$pmt_filled_transid    = seqid();				
				
				$pmt_filled_sql        = "INSERT INTO  `geekfox_ms`.`gsplode_pay_log` (
											`id` ,
											`gsid` ,
											`transid` ,
											`player_name` ,
											`player_key` ,
											`pmt_amt` ,
											`slurl` ,
											`timestamp`)
											VALUES (
											'',  
											'$filled_id',  
											'$pmt_filled_transid',  
											'$player_name',  
											'$player_key',  
											'$deposit_amt',  
											'$slurl', 
											NOW()
											)";
				$pmt_filled_res			= mysql_query($pmt_filled_sql);
				//print("Pmt Filled SQL: $pmt_filled_sql");
				
				//Now that we have entered in our payment for the current filled session id,
				//check for any open ids
				
				if($open_num == 1){
					//Looks like we have some, lets take the money from the 
					//filled session and apply it to the new session
					
					overflow_session($open_id,$deposit_amt,$open_bal_surplus,-1);	 	    		//Open a Session
					log_pmt($filled_id,$player_name,$player_key,$deposit_amt,$slurl);	 			//Log the payment	
				}else{
					new_overflow_session($tier_id,$deposit_amt,$tier_min_pay,$tier_min_entries,0);	//Create the session
					log_pmt($filled_id,$player_name,$player_key,$deposit_amt,$slurl);				//Log the payment	
				}
			}else{
				//The filled session we have is expired
				//We will be coming back and paying out the winners, 
				//for now, just enter the payment into a new session
				
				if($open_num == 1){//Do we have any open sessions?
					open_session($open_id,$deposit_amt,$open_cur_bal,$open_ent_total); 	 			//Update the session
					log_pmt($open_id,$player_name,$player_key,$deposit_amt,$slurl);      			//Log the payment				
				}else{
					$op_id =  new_session($tier_id,$deposit_amt,$tier_min_pay,$tier_min_entries,1);	 //Update the session
								log_pmt($op_id,$player_name,$player_key,$deposit_amt,$slurl);		 //Log the payment	
				}
			}
		}else{//We have no filled sessions, lets check for open ones
			if($open_num == 1){//We have an open session, lets update its balance and entries
				//Looks like we have some, lets add the payment				
				if( ($open_ent_min - $open_ent_total) >= 2){ 
				/* As long as the needed # of players is greater than or equal to one
				use the currently open session unless the minimum req minus the total = 0
				then fill the session and continue */
				
					open_session($open_id,$deposit_amt,$open_cur_bal,$open_ent_total); 				//Update the session
					log_pmt($open_id,$player_name,$player_key,$deposit_amt,$slurl);      			//Log the payment
				}else{
					
					//Process the last entry
					open_session($open_id,$deposit_amt,$open_cur_bal,$open_ent_total); 	//Update the session
					log_pmt($open_id,$player_name,$player_key,$deposit_amt,$slurl);      	//Log the payment
					
					//Fill the session and close it out for now for new payments
					//7200 for total seconds for 2 hours (converting into SL time)
					$fts_sql = "UPDATE  `geekfox_ms`.`gsplode_sessions` SET  
					`status`    =  'FILLED' ,
					`completed` =  DATE_ADD(NOW(),INTERVAL $tier_time_to_exp SECOND)
					WHERE  `gsplode_sessions`.`gsid` = $open_id";
					$fts_res = mysql_query($fts_sql) or die(mysql_error());
					
					//Lets already have a new session ready
					new_session($tier_id,0,$tier_min_pay,$tier_min_entries,0);
					
					//Broadcast out to all the players that the session is filled and we will be sploding soon					
					$o_res        = mysql_query($filled_sql) or die(mysql_error());
					$o_row        = mysql_fetch_object($o_res);
					$o_c		  = $o_row->completed;
					$msg_eta	  = nicetime($o_c);
					
					//$msg_sql = "SELECT id,gsid,player_name,player_key FROM `gsplode_pay_log` WHERE `gsid` = $open_id GROUP BY player_key";
					$msg_sql = "SELECT id,gsid,player_name,player_key FROM `gsplode_pay_log` WHERE `gsid` = $open_id GROUP BY player_key";
					$msg_res = mysql_query($msg_sql);
					$brdcst_msg = "[GridSplode Priority Alert] The $tier_name splode countdown has BEGUN! ETA: $msg_eta\n
					Visit *ANY* GridSplode location and pay L$$tier_min_pay to increase your chances of winning!\n
					If you do not wish to receive these messages, \n
					feel free to create a ticket at http://www.sublimegeek.com/support";
					
					while($msg_row = mysql_fetch_array($msg_res)){
						$msg_name = $msg_row['player_name'];
						$msg_key  = $msg_row['player_key'];
						
						$msg_transid = seqid();						
						
						if(
							($msg_name != 'Tristain Savon') ||
							($msg_name != 'Inchino Melson') 
						)
						{		
							mysql_query("INSERT INTO `geekfox_ms`.`gsplode_pending_payouts` 
										(`id` ,`gsid` ,`transid` ,`winner_name` ,`winner_key` ,`payout_amt` , `type` , `msg` ,`timestamp`)		
								VALUES	(NULL , '$open_id', '$msg_transid', '$msg_name', '$msg_key', '0', 'MSG','$brdcst_msg', CURRENT_TIMESTAMP)");
						}
					}					
				}
			}else{
				$op_id =  new_session($tier_id,$deposit_amt,$tier_min_pay,$tier_min_entries,1);	 //Update the session
								log_pmt($op_id,$player_name,$player_key,$deposit_amt,$slurl);		 //Log the payment	
			}
		}
	}
	elseif($sys_status == "OFFLINE") {print("OFFLINE;The GridSplode system is currently offline.  We will be back up shortly.  Refunding your money now.");}
	elseif($sys_status == "SHUTDOWN"){print("SHUTDOWN;The GridSplode system has been shut down.  Thank you for playing.  Refunding your money now.");}
}else{print("AUTH_FAIL;I'm sorry, this unit is unauthorized to be used in the GridSplode network. Please get a new copy. Refunding your money now.");}
?>
