<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$description = "This graph shows the number of new clients signed up for each month of the year.";
$showyearcycles = true;

if ($statsonly) { return false; }

if (!$year) {
	$year = date("Y");
}

$year2 = $year-1;

$chartdata = array();
$chartdata2 = array();

$months = array('x','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
for ( $rawmonth = 1; $rawmonth <= 12; $rawmonth += 1) {
	$month = str_pad($rawmonth, 2, 0, STR_PAD_LEFT);
    $query = "SELECT COUNT(*) FROM tblorders WHERE date LIKE '$year-$month-%' AND status='Active'";
	$result=mysql_query($query);
	$data = mysql_fetch_array($result);
	$totalsignups = $data[0];
	$chartdata[$months[$rawmonth]] = $totalsignups;
    $totaltotalsignups += $totalsignups;
    $query = "SELECT COUNT(*) FROM tblorders WHERE date LIKE '$year2-$month-%' AND status='Active'";
	$result=mysql_query($query);
	$data = mysql_fetch_array($result);
	$totalsignups = $data[0];
	$chartdata2[$months[$rawmonth]] = $totalsignups;
    $totaltotalsignups += $totalsignups;
}

if ($homepage)
    $graph=new WHMCSGraph(400,200);
else
    $graph=new WHMCSGraph(780,300);
$graph->addData($chartdata,$chartdata2);
$graph->setTitle("A Summary of Completed Orders");
$graph->setBarColor("navy", "silver");
$graph->setLegendTitle($year,$year2);
$graph->setDataValues(true);
$graph->setLegend(true);
$graph->setTitleLocation("left");
$graph->setLegendOutlineColor("white");

?>