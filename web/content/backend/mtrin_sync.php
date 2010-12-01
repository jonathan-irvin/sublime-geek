<?php
include 'config.php';
connect2slm();

//Globals
$debug = FALSE;

//Receive Data from Second Life
$type           = $_POST['type'];
$ok             = $_POST['owner_api'];
$tasks          = $_POST['tasks'];

$gCreator       = "6aab7af0-8ce8-4361-860b-7139054ed44f";
$gBank          = "633ccfe5-9eae-4e3a-8abb-48773dee0edf";
$gApi           = "9354f9133ecc061fc604d2963e05f0d841d55704";

//Find all groups owner has including system group for usage fee
$g_sql   = "SELECT * FROM `mtrinity_profiles` WHERE `owner_api` = '$ok'";
$g_res   = mysql_query($g_sql) or die('Database Error: '.mysql_error());
$g_num   = mysql_num_rows($g_res);

$new_profile_sql = "INSERT INTO `mtrinity_profiles` 
(`id` ,`owner_api` ,`owner_key` ,`tasks`,`updated`)
VALUES (NULL ,  '$ok',  '$ownerKey', '$tasks', CURRENT_TIMESTAMP)";

if($g_num > 0){
	$g_row	 		= mysql_fetch_array($g_res);
	$mt_id   		= $g_row['id'];
	$mt_api   		= $g_row['owner_api'];
	$mt_ok   		= $g_row['owner_key'];
	$mt_tasks   	= $g_row['tasks'];
	$mt_updated   	= nicetime($g_row['updated']);
	
	
	
	if($type == "pull"){ //Pull array from DB
		print("pullresp|$mt_updated|$mt_tasks");
	}
	if($type == "push"){ //Push array to DB
		mysql_query("UPDATE `mtrinity_profiles` SET `tasks` = '$tasks' WHERE `owner_api` = '$ok'");
		print("pushresp|Database has been updated.");
	}
}else{
	if($ok != ""){
		print("info|New database profile created.");
		mysql_query($new_profile_sql);}
}


?>
