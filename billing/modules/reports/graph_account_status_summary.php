<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$description = "This graph shows a breakdown of the percentage of accounts in each of the different statuses.";

if ($statsonly) { return false; }

$chartdata = array();
$query = "SELECT domainstatus,COUNT(*) FROM tblhosting GROUP BY domainstatus";
$result = mysql_query($query);
while ($data = mysql_fetch_array($result)) {
    $chartdata[$data[0]] = $data[1];
}

$graph=new WHMCSGraphPie(600,200);
$graph->addData($chartdata);
$graph->setTitle("Products/Services Status Breakdown");
$graph->setLabelTextColor("50,50,50");

?>