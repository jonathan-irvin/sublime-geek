<?php
//METASTREAMR CONFIG FILE

//GLOBAL FUNCTIONS
$i=0;

function connect(){
	$host = "localhost"		;
	$user = "geekfox"		;
	$pass = "jurby5000"		;
	$db   = "geekfox_ms"	;
	mysql_connect($host,$user,$pass) or die(mysql_error());
	mysql_select_db($db) or die(mysql_error());
}

//ESTABLISH CONNECTION TO THE DB
connect();

function getglobaltotal(){
	$sql = "SELECT count(*) as 'total'
	FROM `istream`
	WHERE `timestamp` >= current_date()";
	$row = mysql_fetch_array(mysql_query($sql));
	return $row['total'];
}

function getglobalsim(){
	$sql = "SELECT count(DISTINCT `simname`) as 'total'
	FROM `istream`
	WHERE `timestamp` >= CURRENT_DATE()
	GROUP BY `simname`";
	$result = mysql_query($sql);
	$total  = mysql_result($result,$i,'total');
	return $total;
}

function getglobalname($sel){
	$sql = "SELECT DISTINCT `$sel` AS 'select'
	FROM `istream`
	WHERE `timestamp` >= current_date()
	GROUP BY `$sel`
	ORDER BY `$sel` DESC";
	$result = mysql_query($sql);
	$name   = mysql_result($result,$i,'select');
	return $name;
}

function like($var,$text){
	similar_text($var,$text,$p);
	return $p;
}

//GLOBAL USER FUNCTIONS
function getlocalnum($key){
	$sql = "SELECT * FROM `istream`
	WHERE `owner_key` = '$key' AND
	`timestamp` = CURRENT_DATE()";

	$result 	= mysql_query($sql);
	$num		= mysql_num_rows($result);
	return $num;
}

//GLOBAL POST VARIABLES
$key = $_POST['ownerkey'];

//GLOBAL VARIABLES
$version 	= "1.1";
$total_active_locations 	= getglobaltotal();
$total_active_sim 		= getglobalsim();
$total_active_simname	= getglobalname('simname');
$total_active_radname	= getglobalname('radname');
$total_active_vidname	= getglobalname('vidname');

$user_active_locations	= getlocalnum($key);

//CONDITIONS
$rad_diff = like($total_active_radname,'Club 977 Hitz');
$vid_diff = like($total_active_vidname,'No Video Set');

if($rad_diff >= 0.90)
	{$total_active_radname = $total_active_radname.'(Default)';}
if($vid_diff >= 0.90)
	{$total_active_vidname = $total_active_vidname.'(Default)';}

?>
