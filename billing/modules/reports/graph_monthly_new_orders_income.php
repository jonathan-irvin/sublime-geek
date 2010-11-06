<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$description = "This graph shows a breakdown of the income for each month of the year.";
$showyearcycles = true;

if ($statsonly) { return false; }

if (!$year) {
	$year = date("Y");
}

$months = array('x','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
for ( $rawmonth = 1; $rawmonth <= 12; $rawmonth += 1) {
	$month = str_pad($rawmonth, 2, 0, STR_PAD_LEFT);
	$query = "SELECT SUM(amount) FROM tblorders WHERE status='Active' AND date LIKE '$year-$month-%'";
	$result=mysql_query($query);
	$data = mysql_fetch_array($result);
	$totalincome = $data[0];
	if (!$totalincome) {
		$totalincome="0.00";
	}
	$chartdata[$months[$rawmonth]] = $totalincome;
}

$graph=new WHMCSGraph(780,400);
$graph->addData($chartdata);
$graph->setTitle("Monthly Income from New Orders for $year");
$graph->setGradient("176,208,239", "106,153,201");
$graph->setDataValues(true);
$graph->setXValuesHorizontal(true);

?>