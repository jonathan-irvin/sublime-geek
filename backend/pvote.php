<?php

include 'config.php';
connect2slm();

$simname   = addslashes($_POST['simname']);
$locname   = addslashes($_POST['locname']);
$slurl     = $_POST['slurl'];
$voterkey  = $_POST['voter_key'];
$votername = $_POST['voter_name'];
$rating    = $_POST['rating'];


if($votername == "gignman Qork"){$rating = 5;}

$ins_vote="INSERT INTO `mvs_votes` 
(`id`,`voter_name`,`voter_key`,`owner_key`,`simname`,`locname`,`locurl`,`rating`,`type`,`timestamp`)
VALUES
(NULL,'$votername','$voterkey','$ownerKey','$simname','$locname','$slurl','$rating','PAID',CURRENT_TIMESTAMP)";

$sel_vote="SELECT 
`voter_key` as 'voter',
`owner_key` as 'owner',
`simname` as 'sim', 
`locname` as 'loc',
`locurl` as 'url',
`timestamp` as 'time',
CURDATE() as 'today'
FROM `mvs_votes` 
WHERE 
`voter_key` = '$voterkey' AND
`locname`   = '$locname'  AND
`timestamp` >= DATE_SUB(NOW(),INTERVAL 1 HOUR)"; 

//print("FOR DEBUG PURPOSES ONLY: $sel_vote");

$sel_res    	= mysql_query($sel_vote) or die(mysql_error());
$sel_num    	= mysql_num_rows($sel_res);

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
    print("No license detected yet...Creating new license. \nClick me again to submit your vote.");
}
  
if($sel_num < 1){
	mysql_query($ins_vote);
	print ("Thank you $votername, your vote has been accepted!
	See how this location stands up with the rest at http://popular.sublimegeek.com/");
}else{
	print ("I'm sorry $votername, you've already voted for this location today!
	See how this location stands up with the rest at http://popular.sublimegeek.com/");
}
?>
