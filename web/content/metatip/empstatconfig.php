<?php

$selected 	= $_GET['selected'];
$el_api		= $l_api;

$elist_sql	= "SELECT `pmt_to_name`,`pmt_to` 
FROM `mtipcomm_translog` WHERE 
`owner_api` = '$l_api' 
AND `pmt_to_name` != '' 
GROUP BY `pmt_to_name`
ORDER BY `pmt_to_name` ASC";
$elist_res	= mysql_query($elist_sql);
$elist_num	= mysql_num_rows($elist_res);

/////////////////////Begin Employee Chart Queries/////////////////////////////
//Last 24 Hours
$elast24_sql  = "SELECT 
Date_format(`timestamp`,'%h %p') as 'date',
AVG(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  `owner_api` =  '$el_api'
AND	 `pmt_to`    =  '$selected'
AND  `pmt_type`  =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE() , INTERVAL 24 HOUR ) 
GROUP BY HOUR(`timestamp`) ";

$elast24_res   = mysql_query($elast24_sql);
$elast24_res2  = mysql_query($elast24_sql);
$elast24_num   = mysql_num_rows($elast24_res);

while($el24row = mysql_fetch_array($elast24_res))
{
  $total  = $el24row['total'];
  $date   = $el24row['date'];
    
  $el24[$date] = $el24row['total'];  
}

if($elast24_num != 0){
$elast24= new GphpChart('lc');
$elast24->width= 600;
$elast24->add_data(array_values($el24),'006E93');
$elast24->add_labels('x',array_keys($el24));
}

//Last 7 Days
$elast7_sql  = "SELECT 
Date_format(`timestamp`,'%c-%d') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  `owner_api` =  '$el_api'
AND	 `pmt_to`    =  '$selected'
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 1 WEEK ) 
GROUP BY DAY(  `timestamp` ) ";

$elast7_res   = mysql_query($elast7_sql);
$elast7_res2  = mysql_query($elast7_sql);
$elast7_num   = mysql_num_rows($elast7_res);

while($el7row = mysql_fetch_array($elast7_res))
{
  $total  = number_format($el7row['total'],2,".",",");
  $date   = $el7row['date'];
    
  $el7t[$date] = $etotal;  
}

if($elast7_num != 0){
$elast7= new GphpChart('bvg');
$elast7->add_data($el7t,'006E93');
$elast7->add_labels('x',array_keys($el7t));
}

//Begin Queries
//Last 4 Weeks
$elastmon_sql  = "SELECT 
Date_format(`timestamp`,'%U') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  `owner_api` =  '$l_api'
AND	 `pmt_to`    =  '$selected'
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 4 WEEK ) 
GROUP BY WEEK(  `timestamp` ) ";

$elastmon_res   = mysql_query($elastmon_sql);
$elastmon_res2  = mysql_query($elastmon_sql);
$elastmon_num   = mysql_num_rows($elastmon_res);

while($elmonrow = mysql_fetch_array($elastmon_res))
{
  $total  = number_format($elemonrow['total'],2,".",",");
  $date   = $elmonrow['date'];
  
  $scStartDate = week_start_date($date, date('Y',time() ) ); 
  $scEndDate   = date('d M', strtotime('+6 days', strtotime($scStartDate)));
  
  $elmont[(string) $scStartDate." to ".(string) $scEndDate] = $total;  
}

if($elastmon_num != 0){
$elastmon= new GphpChart('bvg');
$elastmon->add_data($elmont,'006E93');
$elastmon->add_labels('x',array_keys($elmont));
}

//Begin Queries
//Last 12 Months
$elast6mon_sql  = "SELECT 
date_format(`timestamp`,'%b %y') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  `owner_api` =  '$el_api'
AND	 `pmt_to`    =  '$selected'
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 12 MONTH) 
GROUP BY MONTH(`timestamp`)";

$elast6mon_res   = mysql_query($elast6mon_sql);
$elast6mon_res2  = mysql_query($elast6mon_sql);
$elast6mon_num   = mysql_num_rows($elast6mon_res);

while($el6monrow = mysql_fetch_array($elast6mon_res))
{
  $total  = number_format($el6monrow['total'],2,".",",");
  $date   = $el6monrow['date'];
  
  $el6mon[$el6monrow['date']] = $total;  
}

if($elast6mon_num != 0){
$elast6mon= new GphpChart('bvg');
$elast6mon->add_data($el6mon,'006E93');
$elast6mon->add_labels('x',array_keys($el6mon));
}

//Begin Queries
//Last 4 Years
$elast4y_sql  = "SELECT 
date_format(`timestamp`,'%Y') as 'date',
SUM(`pmt_amt`) AS  `total`
FROM  `mtipcomm_translog` 
WHERE  `owner_api` =  '$el_api'
AND	 `pmt_to`    =  '$selected'
AND  `pmt_type` =  'pmt'
AND  `pmt_type` !=  'usg'
AND  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL 4 YEAR) 
GROUP BY YEAR(`timestamp`)";

$elast4y_res   = mysql_query($elast4y_sql);
$elast4y_res2  = mysql_query($elast4y_sql);
$elast4y_num   = mysql_num_rows($elast4y_res);

while($el4yrow = mysql_fetch_array($elast4y_res))
{
  $total  = number_format($el4yrow['total'],2,".",",");
  $date   = $el4yrow['date'];
  
  $el4y[$el4yrow['date']] = $total;  
}

if($elast4y_num != 0){
$elast4y= new GphpChart('bvg');
$elast4y->add_data($el4y,'006E93');
$elast4y->add_labels('x',array_keys($el4y));
}

?>