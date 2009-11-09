<?php

$selected 	= $_GET['selected'];
$vl_api		= $l_api;

$vlist_sql	= "SELECT `pmt_from_name`,`pmt_from` 
FROM `mtipcomm_translog` WHERE 
`owner_api` = '$l_api' 
AND `pmt_from_name` != '' 
GROUP BY `pmt_from_name`
ORDER BY `pmt_from_name` ASC";
$vlist_res	= mysql_query($vlist_sql);
$vlist_num	= mysql_num_rows($vlist_res);

/////////////////////Begin Employee Chart Queries/////////////////////////////
//Last 24 Hours
$vlast24_sql  = "SELECT 
Date_format(`timestamp`,'%h %p') as 'date',
AVG(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  `owner_api` =  '$vl_api'
AND	 `pmt_from`    =  '$selected'
AND  `pmt_type`  =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE() , INTERVAL 24 HOUR ) 
GROUP BY HOUR(`timestamp`) ";

$vlast24_res   = mysql_query($vlast24_sql);
$vlast24_res2  = mysql_query($vlast24_sql);
$vlast24_num   = mysql_num_rows($vlast24_res);

while($vl24row = mysql_fetch_array($vlast24_res))
{
  $total  = $vl24row['total'];
  $date   = $vl24row['date'];
    
  $vl24[$date] = $vl24row['total'];  
}

if($vlast24_num != 0){
$vlast24= new GphpChart('lc');
$vlast24->width= 600;
$vlast24->add_data(array_values($vl24),'006E93');
$vlast24->add_labels('x',array_keys($vl24));
}

//Last 7 Days
$vlast7_sql  = "SELECT 
Date_format(`timestamp`,'%c-%d') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  `owner_api` =  '$vl_api'
AND	 `pmt_from`    =  '$selected'
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 1 WEEK ) 
GROUP BY DAY(  `timestamp` ) ";

$vlast7_res   = mysql_query($vlast7_sql);
$vlast7_res2  = mysql_query($vlast7_sql);
$vlast7_num   = mysql_num_rows($vlast7_res);

while($vl7row = mysql_fetch_array($vlast7_res))
{
  $total  = number_format($vl7row['total'],2,".",",");
  $date   = $vl7row['date'];
    
  $vl7t[$date] = $total;  
}

if($vlast7_num != 0){
$vlast7= new GphpChart('bvg');
$vlast7->add_data($vl7t,'006E93');
$vlast7->add_labels('x',array_keys($vl7t));
}

//Begin Queries
//Last 4 Weeks
$vlastmon_sql  = "SELECT 
Date_format(`timestamp`,'%U') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  `owner_api` =  '$l_api'
AND	 `pmt_from`    =  '$selected'
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 4 WEEK ) 
GROUP BY WEEK(  `timestamp` ) ";

$vlastmon_res   = mysql_query($vlastmon_sql);
$vlastmon_res2  = mysql_query($vlastmon_sql);
$vlastmon_num   = mysql_num_rows($vlastmon_res);

while($vlmonrow = mysql_fetch_array($vlastmon_res))
{
  $total  = number_format($vlemonrow['total'],2,".",",");
  $date   = $vlmonrow['date'];
  
  $scStartDate = week_start_date($date, date('Y',time() ) ); 
  $scEndDate   = date('d M', strtotime('+6 days', strtotime($scStartDate)));
  
  $vlmont[(string) $scStartDate." to ".(string) $scEndDate] = $total;  
}

if($vlastmon_num != 0){
$vlastmon= new GphpChart('bvg');
$vlastmon->add_data($vlmont,'006E93');
$vlastmon->add_labels('x',array_keys($vlmont));
}

//Begin Queries
//Last 12 Months
$vlast6mon_sql  = "SELECT 
date_format(`timestamp`,'%b %y') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  `owner_api` =  '$vl_api'
AND	 `pmt_from`    =  '$selected'
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 12 MONTH) 
GROUP BY MONTH(`timestamp`)";

$vlast6mon_res   = mysql_query($vlast6mon_sql);
$vlast6mon_res2  = mysql_query($vlast6mon_sql);
$vlast6mon_num   = mysql_num_rows($vlast6mon_res);

while($vl6monrow = mysql_fetch_array($vlast6mon_res))
{
  $total  = number_format($vl6monrow['total'],2,".",",");
  $date   = $vl6monrow['date'];
  
  $vl6mon[$vl6monrow['date']] = $total;  
}

if($vlast6mon_num != 0){
$vlast6mon= new GphpChart('bvg');
$vlast6mon->add_data($vl6mon,'006E93');
$vlast6mon->add_labels('x',array_keys($vl6mon));
}

//Begin Queries
//Last 4 Years
$vlast4y_sql  = "SELECT 
date_format(`timestamp`,'%Y') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  `owner_api` =  '$vl_api'
AND	 `pmt_from`    =  '$selected'
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 4 YEAR) 
GROUP BY YEAR(`timestamp`)";

$vlast4y_res   = mysql_query($vlast4y_sql);
$vlast4y_res2  = mysql_query($vlast4y_sql);
$vlast4y_num   = mysql_num_rows($vlast4y_res);

while($vl4yrow = mysql_fetch_array($vlast4y_res))
{
  $total  = number_format($vl4yrow['total'],2,".",",");
  $date   = $vl4yrow['date'];
  
  $vl4y[$vl4yrow['date']] = $total;  
}

if($vlast4y_num != 0){
$vlast4y= new GphpChart('bvg');
$vlast4y->add_data($vl4y,'006E93');
$vlast4y->add_labels('x',array_keys($vl4y));
}

?>