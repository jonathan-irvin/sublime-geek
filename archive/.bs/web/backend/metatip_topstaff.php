<?php 
include "config.php";
connect2slm();

$api       = $_POST['api'];
$auth      = $_POST['auth'];
$ok        = $_POST['ok'];

//Begin Active License Check
$l_sql          = "SELECT * FROM istream_demo WHERE `key` = '$ok' ";
$l_result       = mysql_query($l_sql);
$l_row          = mysql_fetch_array($l_result);
$l_num          = mysql_num_rows($l_result);
$l_name           = $l_row['name'];
$l_auth           = $l_row['auth_key'];
$l_api            = $l_row['api_key'] ;
//Debug
//$l_api = "9354f9133ecc061fc604d2963e05f0d841d55704";

//Top 10 Staff
$fromsql = "SELECT
`pmt_to_name` AS  'name',
COUNT( * ) AS  'num',
SUM(  `pmt_amt` ) AS  'total'
FROM  `mtipcomm_translog`
WHERE  `owner_api` =  '$l_api'
AND `pmt_to` != '$ok'
AND `pmt_to_name` != ''
GROUP BY  `name`
ORDER BY  `total` DESC
LIMIT 0 , 10";
$fromres = mysql_query($fromsql) or die("T5T Error: ".mysql_error());;
$fromnum = mysql_num_rows($fromres);

print("top5;");

$counter = 01;
$totchar = 40;

if($fromnum > 0){
	while($fromrow = mysql_fetch_array($fromres)){
	  $name  = $fromrow['name'];
	  $amt   = $fromrow['total'];
	  
	  if($counter < 10){$counter = "0".$counter;}
	  $total = number_format($fromrow['total'],0,".",",");
	  
	  $counttxt = strlen("#$counter $name - L$$total|");
	  $padcount = $totchar - $counttxt+2;
	  $display  = "#$counter $name";
	  $dsp_pad  = $display.str_repeat(" ",$padcount)."L$$total|";
	   
	  if($name != "System Payment"){print($dsp_pad);}
	  $counter++;
	}
  }else{print("Not enough data yet :D");}
 
?>