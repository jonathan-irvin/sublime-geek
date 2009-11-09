<?php

//Connect to the DB
include 'config.php';
connect2slm();

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

$tid = $_POST['tierid'];


//Grab system information
$sys_sql        = "SELECT * from `gsplode_config`";
$sys_res        = mysql_query($sys_sql) or die();
$sys_status     = mysql_result($sys_res,0,'status');     //System status
$sys_multi_base = mysql_result($sys_res,0,'multi_base'); //Base multiplier
$sys_multi_prize= mysql_result($sys_res,0,'multi_prize');//Multiplier for prize money
$sys_multi_tier = mysql_result($sys_res,0,'multi_tier'); //Multiplier for prize tiers
$sys_num_prize  = mysql_result($sys_res,0,'num_prize');  //Number of prizes available

//Based on the received tier id, what tier are we using

$tier_sql       = "SELECT * FROM `gsplode_splode_config` WHERE `id` = '$tid'";
$tier_res       = mysql_query($tier_sql) or die();
$tier_row       = mysql_fetch_object($tier_res);
$tier_num       = mysql_num_rows($tier_res);
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

//Grab all of the payment settings from the 4 different types of splodes
$pay_sql		= "SELECT * FROM `gsplode_splode_config`";
$pay_res		= mysql_query($pay_sql);	

//Search for active sessions
$filled_sql = "SELECT * FROM `gsplode_sessions` WHERE 
	`status` = 'FILLED'
	AND `gs_type_id` = '$tier_id' ORDER BY `status` DESC";
$filled_res = mysql_query($filled_sql) or die();
$filled_num = mysql_num_rows($filled_res);

$open_sql = "SELECT * FROM `gsplode_sessions` WHERE 
	`status` = 'OPEN'
	AND `gs_type_id` = '$tier_id' ORDER BY `status` DESC";
$open_res = mysql_query($open_sql) or die();
$open_num = mysql_num_rows($open_res);

/* 
Overflow Notes:
Currence Bal = Total Entries * Min. Pay
Adj. PayOuts = Surplus + Bal Needed

Divide the Surplus

Prize 1 = 10%
Prize 2 = 15%
Prize 3 = 25%
-------------
Total     50%

Our Take  25% * 2
Total    100%
*/

if($filled_num == 1){
	$total_entries   = "///SPLODE IMMINENT///";
	$exp_sl 	     = mysql_result($filled_res,0,'completed');	
	$expires	     = nicetime($exp_sl);
	$f_bal_surplus   = mysql_result($filled_res,0,'bal_surplus');
	
	$p1_mod			 = floor($f_bal_surplus * 0.10);
	$p2_mod			 = floor($f_bal_surplus * 0.15);
	$p3_mod			 = floor($f_bal_surplus * 0.25);
	
	$p_one      	 = $tier_p_one   + $p1_mod;
	$p_two      	 = $tier_p_two   + $p2_mod;
	$p_three      	 = $tier_p_three + $p3_mod;
	
}else{
	if($open_num == 1){
		$ent_total 		 = mysql_result($open_res,0,'ent_total');
		$ent_min 		 = mysql_result($open_res,0,'ent_min');
		$bal_surplus	 = mysql_result($open_res,0,'bal_surplus');
		
		$p1_mod			 = floor($bal_surplus * 0.10);
		$p2_mod			 = floor($bal_surplus * 0.15);
		$p3_mod			 = floor($bal_surplus * 0.25);
		
		$p_one      	 = $tier_p_one   + $p1_mod;
		$p_two      	 = $tier_p_two   + $p2_mod;
		$p_three      	 = $tier_p_three + $p3_mod;
		
		$total_entries   = $ent_min - $ent_total;
	}else{
		$total_entries   = $tier_min_entries;
		$p_one      	 = $tier_p_one      ;
		$p_two      	 = $tier_p_two      ;
		$p_three      	 = $tier_p_three    ;
	}
}

print("$tier_name:::$p_three:::$p_two:::$p_one:::$tier_min_pay:::$total_entries:::$sys_status");

//Output pmt amounts
while($pay_row		= mysql_fetch_array($pay_res)){
	$pmt_amt = $pay_row['min_pay'];
	print(":::$pmt_amt");
}

//Time to Splode!!!
print(":::$expires");
?>