<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$description = "This graph shows a breakdown of the percentage of domains in each of the different statuses.";

if ($statsonly) { return false; }

$query = "SELECT status,COUNT(*) FROM tbldomains GROUP BY status";
$result = mysql_query($query);
while ($data = mysql_fetch_array($result)) {
$chartdata[$data[0]] = $data[1];
}

$graph=new WHMCSGraphPie(600,200);
$graph->addData($chartdata);
$graph->setTitle("Domains Status Breakdown");
$graph->setLabelTextColor("50,50,50");

?>