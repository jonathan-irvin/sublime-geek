<?php 
include "../backend/config.php";
require_once "GphpChart.class.php";
connect2slm();

$api       = $_GET['api'];
$auth      = $_GET['auth'];
$ok        = $_GET['ok'];
$gid        = $_GET['gid'];

$act        = $_GET['act'];
$unm        = $_GET['unm'];
$uky        = $_GET['uky'];
$uid        = $_GET['uid'];
$role       = $_GET['role'];

$gnm        = $_GET['gname'];
$pay        = $_GET['payout'];

$uadd       = "?auth=$auth&api=$api&ok=$ok";

//Debug
//$ok  = "6aab7af0-8ce8-4361-860b-7139054ed44f";

define(NULL_KEY, "00000000-0000-0000-0000-000000000000");

function name2key($name){
  $key = file('http://w-hat.com/name2key/?terse=1&name=' . urlencode( trim($name) ));
  if($key[0] != NULL_KEY){return $key[0];}
  else{return NULL_KEY;}
}

$trans_sql  = "SELECT * FROM `mtipcomm_translog` WHERE `owner_key` = '$ok'";
$trans_res  = mysql_query($trans_sql);
$trans_res2 = mysql_query($trans_sql);

//Begin Active License Check
$l_sql          = "SELECT * FROM sg_accounts WHERE `key` = '$ok' ";
$l_result       = mysql_query($l_sql);
$l_row          = mysql_fetch_array($l_result);
$l_num          = mysql_num_rows($l_result);
$l_name           = $l_row['name'];
$l_auth           = $l_row['auth_key'];
$l_api            = $l_row['api_key'] ;

$gApi = "9354f9133ecc061fc604d2963e05f0d841d55704";
$selection = "`api_key` =  '$l_api'";

if($gApi == $l_api){$selection = "`api_key` =  '$l_api' OR `api_key` != '$l_api'";}

if(!isset($api,$auth,$ok)){die('Error: You must access this page from your metaTip Control Panel');}

//Authenticate
if( ($l_auth == $auth) && ($l_api == $api) ){}
else{
  die('Unauthorized<br>Please visit your control panel in-world for access.');
}

function week_start_date($wk_num, $yr, $first = 1, $format = 'd M') 
{ 
    $wk_ts  = strtotime('+' . $wk_num . ' weeks', strtotime($yr . '0101')); 
    $mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts); 
    return date($format, $mon_ts); 
} 

$scStartDate = week_start_date($date, date('Y',time() ) ); 
$scEndDate   = date('n/d', strtotime('+6 days', strtotime($sStartDate)));

//TRANSACTION LOG QUERY
$log_sql  = "SELECT * FROM `mtipcomm_translog` WHERE `api_key` = '$l_api' ORDER BY `timestamp` DESC LIMIT 0,100";
$log_res  = mysql_query($log_sql) or die (mysql_error());
$log_num  = mysql_num_rows($log_res);

/////////////////////Begin Regular Chart Queries/////////////////////////////
//Last 24 Hours
$last24_sql  = "SELECT 
Date_format(`timestamp`,'%H') as 'date',
AVG(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  $selection
AND  `pmt_type`  =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE() , INTERVAL 24 HOUR ) 
GROUP BY HOUR(`timestamp`) LIMIT 0,24";

$last24_res   = mysql_query($last24_sql);
$last24_res2  = mysql_query($last24_sql);
$last24_num   = mysql_num_rows($last24_res);

while($l24row = mysql_fetch_array($last24_res))
{
  $total  = $l24row['total'];
  $date   = $l24row['date'];
    
  $l24[$date] = $l24row['total'];  
}

if($last24_num != 0){
$last24= new GphpChart('lc');
$last24->width= 600;
$last24->add_data(array_values($l24),'006E93');
$last24->add_labels('x',array_keys($l24));
}

//Last 7 Days
$last7_sql  = "SELECT 
Date_format(`timestamp`,'%c-%e') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  $selection
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 1 WEEK ) 
GROUP BY DAY(  `timestamp` ) LIMIT 0,7";

$last7_res   = mysql_query($last7_sql);
$last7_res2  = mysql_query($last7_sql);
$last7_num   = mysql_num_rows($last7_res);

while($l7row = mysql_fetch_array($last7_res))
{
  $total  = number_format($l7row['total'],2,".",",");
  $date   = $l7row['date'];
    
  $l7t[$date] = $total;  
}

if($last7_num != 0){
$last7= new GphpChart('bvg');
$last7->add_data($l7t,'006E93');
$last7->add_labels('x',array_keys($l7t));
}

//Begin Queries
//Last 4 Weeks
$lastmon_sql  = "SELECT 
Date_format(`timestamp`,'%U') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  $selection
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 4 WEEK ) 
GROUP BY WEEK(  `timestamp` ) LIMIT 0,4";

$lastmon_res   = mysql_query($lastmon_sql);
$lastmon_res2  = mysql_query($lastmon_sql);
$lastmon_num   = mysql_num_rows($lastmon_res);

while($lmonrow = mysql_fetch_array($lastmon_res))
{
  $total  = number_format($lmonrow['total'],2,".",",");
  $date   = $lmonrow['date'];
  
  $scStartDate = week_start_date($date, date('Y',time() ) ); 
  $scEndDate   = date('d M', strtotime('+6 days', strtotime($scStartDate)));
  
  $lmont[(string) $scStartDate." to ".(string) $scEndDate] = $total;  
}

if($lastmon_num != 0){
$lastmon= new GphpChart('bvg');
$lastmon->add_data($lmont,'006E93');
$lastmon->add_labels('x',array_keys($lmont));
}

//Begin Queries
//Last 12 Months
$last6mon_sql  = "SELECT 
date_format(`timestamp`,'%b') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  $selection
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 12 MONTH) 
GROUP BY MONTH(`timestamp`) LIMIT 0,12";

$last6mon_res   = mysql_query($last6mon_sql);
$last6mon_res2  = mysql_query($last6mon_sql);
$last6mon_num   = mysql_num_rows($last6mon_res);

while($l6monrow = mysql_fetch_array($last6mon_res))
{
  $total  = number_format($l6monrow['total'],2,".",",");
  $date   = $l6monrow['date'];
  
  $l6mon[$l6monrow['date']] = $total;  
}

if($last6mon_num != 0){
$last6mon= new GphpChart('bvg');
$last6mon->add_data($l6mon,'006E93');
$last6mon->add_labels('x',array_keys($l6mon));
}

//Begin Queries
//Last 4 Years
$last4y_sql  = "SELECT 
date_format(`timestamp`,'%Y') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  $selection
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 4 YEAR) 
GROUP BY YEAR(`timestamp`) LIMIT 0,4";

$last4y_res   = mysql_query($last4y_sql);
$last4y_res2  = mysql_query($last4y_sql);
$last4y_num   = mysql_num_rows($last4y_res);

while($l4yrow = mysql_fetch_array($last4y_res))
{
  $total  = number_format($l4yrow['total'],2,".",",");
  $date   = $l4yrow['date'];
  
  $l4y[$l4yrow['date']] = $total;  
}

if($last4y_num != 0){
$last4y= new GphpChart('bvg');
$last4y->add_data($l4y,'006E93');
$last4y->add_labels('x',array_keys($l4y));
}

//Begin Statistics
//Top 10 Tippers
$fromsql = "SELECT
`pmt_from_name` AS  'name',
COUNT( * ) AS  'num',
SUM(  `pmt_amt` ) AS  'total'
FROM  `mtipcomm_translog`
WHERE  $selection
AND `pmt_from` != '$ok'
GROUP BY  `name`
ORDER BY  `total` DESC
LIMIT 0 , 10";
$fromres = mysql_query($fromsql) or die("T5T Error: ".mysql_error());;
$fromnum = mysql_num_rows($fromres);

//Top 10 Employees
$tosql = "SELECT
`pmt_to_name` AS  'name',
COUNT( * ) AS  'num',
SUM(  `pmt_amt` ) AS  'total'
FROM  `mtipcomm_translog`
WHERE  $selection
AND `pmt_to` != '$ok'
GROUP BY  `name`
ORDER BY  `total` DESC
LIMIT 0 , 10";
$tores = mysql_query($tosql) or die("T5E Error: ".mysql_error());;
$tonum = mysql_num_rows($tores);

//User Stats
$ustatsql="SELECT   
COUNT( * ) AS  'num',
sum(`pmt_amt`) as 'tot',
avg(`pmt_amt`) as 'avg'
FROM  `mtipcomm_translog` 
WHERE  $selection
GROUP BY  `api_key`";
$ustatres = mysql_query($ustatsql);
$ustatnum = mysql_num_rows($ustatres);
if($ustatnum > 0){
$usrow    = mysql_fetch_array($ustatres);
$unum     = number_format($usrow['num'],2,".",",");
$utot     = number_format($usrow['tot'],2,".",",");
$uavg     = number_format($usrow['avg'],2,".",",");
}

//Owner Groups
$g_sql     = "SELECT * FROM `mtip_groups` WHERE `api_key` = '$l_api'";
$g_res     = mysql_query($g_sql) or die(mysql_error());
$g_num     = mysql_num_rows($g_res);


$gn_sql    = "SELECT * FROM `mtip_groups` WHERE `api_key` = '$l_api' AND `gid` = '$gid'";
$gn_res    = mysql_query($gn_sql) or die(mysql_error());
$gn_num    = mysql_num_rows($gn_res);
if($gn_num >= 1){$groupname = mysql_result($gn_res,0,'gname');}else{$groupname = "No Selected Group";}


if($act == 'adduser'){
  $key = name2key($unm);
  if($key == NULL_KEY){$message = "<div class=error>Error! Invalid Second Life Name!</div>";}
  else{
  $sql = "INSERT INTO `mtip_gmembers` (`uid`,`gid`,`name`,`key`,`role`)
  VALUES (NULL,'$gid','$unm','$key','$role') ";
  mysql_query($sql) or die("Add User Error: ".mysql_error());}
}

else if($act == 'deluser'){
  $sql = "DELETE FROM `mtip_gmembers` WHERE `uid` = '$uid'";
  mysql_query($sql) or die("Del User Error: ".mysql_error());
  $message = "<div class=info>User Deleted<br>Please refresh your page to see the changes</div>";
}

else if($act == 'addgrp'){
  $chktot = "SELECT SUM(`payout`) AS  'total'
  FROM  `mtip_groups` 
  WHERE  $selection";
  $chkres = mysql_query($chktot) or die("Error Check Total: $chktot");
  $chknum = mysql_num_rows($chkres);
  
  if($chknum >= 1){
    $chkrow = mysql_fetch_array($chkres);
    $grpcal = $chkrow['total'];
  }
  
  if($pay > 1){$paycvt = $pay * .01;} //Convert to %
  
  $grptot = $grpcal + $paycvt;
  
  if($grptot < 0.95){
  $sql = "INSERT INTO `mtip_groups` 
  (`gid`,`gname`,`api_key`,`payout`,`timestamp`)
  VALUES (NULL,'$gname','$l_api','$paycvt',NOW())";
  mysql_query($sql) or die("Error Adding Total: $sql");
  }else{$message = "<div class=error>Error! Your total group % cannot exceed 100%!<br>
  Your total is $grptot</div>";}
}

else if($act == 'delgrp'){
  $g_sql = "DELETE FROM `mtip_groups`   WHERE `gid` = '$gid'";
  $u_sql = "DELETE FROM `mtip_gmembers` WHERE `gid` = '$gid'";
  
  mysql_query($u_sql) or die("DelAll User Error: ".mysql_error()); //Delete All Members
  mysql_query($g_sql) or die("Del Grp Error: ".mysql_error()); //Delete Group
  $message = "<div class=info>Group Deleted<br>Please refresh your page to see the changes</div>";
}

?>
