<?php

include 'config.php';
connect2slm();

$simname   = addslashes($_POST['simname']);
$locname   = addslashes($_POST['locname']);
$slurl     = $_POST['slurl'];
$voterkey  = $_POST['voter_key'];
$votername = $_POST['voter_name'];
$rating    = $_POST['rating'];
$authhash  = $_POST['authhash'];
$unitver   = $_POST['version'];

$hash = "e76f4f903386a2e4fdec21a045da8294140389ae";
$version = 2.0;

$ins_vote="INSERT INTO `mvs_votes` 
(`id`,`voter_name`,`voter_key`,`owner_key`,`simname`,`locname`,`locurl`,`rating`,`type`,`timestamp`)
VALUES
(NULL,'$votername','$voterkey','$ownerKey','$simname','$locname','$slurl','$rating','FREE',CURRENT_TIMESTAMP)";

$sel_vote="SELECT 
`voter_key` as 'voter',
`owner_key` as 'owner',
`simname` as 'sim', 
`locname` as 'loc',
`locurl` as 'url',
`timestamp` as 'time',
DATE_ADD(`timestamp`,INTERVAL 1 DAY) as 'ftime',
CURDATE() as 'today'
FROM `mvs_votes` 
WHERE 
`voter_key` = '$voterkey' AND
`locname`   = '$locname'  AND
`timestamp` >= DATE_SUB(NOW(),INTERVAL 1 DAY)"; 

//print("FOR DEBUG PURPOSES ONLY: $sel_vote");

$l_sql          = "SELECT * FROM `istream_demo` WHERE `key` = '$ownerKey' ";
$l_result       = mysql_query($l_sql);
$l_row          = mysql_fetch_array($l_result);
$l_num          = mysql_num_rows($l_result);

if($l_num == 0){
    $sqldemo = "INSERT INTO `istream_demo` (
                  `id` ,
                  `name` ,
                  `key` ,
                  `expires`
                  )
                  VALUES (
                  NULL ,
                  '$ownerName',
                  '$ownerKey',
                  date_add(NOW(),INTERVAL 7 DAY) )";
                mysql_query($sqldemo);
    print("No license detected yet...Creating new license. \n");
}
$sel_res    	= mysql_query($sel_vote) or die(mysql_error());
$sel_num    	= mysql_num_rows($sel_res);
$sel_row		= mysql_fetch_array($sel_res);

if($authhash == $hash){
	if($unitver == $version){
		if($sel_num == 0){
			mysql_query($ins_vote) or die("err|".mysql_error());
			print ("vote|Thank you $votername, your vote has been accepted!
			metaVotr 2.0 has released!  Upgrade now to the latest version! This version will expire in 24 hours.
			Watch your favorite location's standings at http://popular.sublimegeek.com/");		
		}else{
			$ttnextvote = nicetime($sel_row['ftime']);
			print ("vote|You've already voted $votername, but you can vote again $ttnextvote!
			metaVotr 2.0 has released!  Upgrade now to the latest version! This version will expire in 24 hours.
			Watch your favorite location's standings at http://popular.sublimegeek.com/");
		}
	}else if($unitver < $version){
		print ("exp|Error: Unable to vote, this unit requires an update before proceeding.  Get with the owner and have them put out a new version. You need version $version and you have $unitver");
	}
}else{print ("noauth|Error: Unable to vote, this unit is no longer authorized.  Get with the owner and have them put out a new version.");}
?>
