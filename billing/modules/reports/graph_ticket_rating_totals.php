<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$description = "This graph shows an overview of ticket ratings";

if ($statsonly) { return false; }

$chartdata = array();

$query = "SELECT rating,COUNT(rating) AS ratingcount FROM `tblticketreplies` WHERE admin!='' AND rating!='' GROUP BY rating ORDER BY rating ASC";
$result = mysql_query($query);
while ($data = mysql_fetch_array($result)) {
    $chartdata[$data[0]] = round($data[1],2);
}

$graph=new WHMCSGraph(650,400);
$graph->addData($chartdata);
$graph->setTitle("Support Ticket Ratings Overview");
$graph->setGradient("red", "maroon");
$graph->setDataValues(true);
$graph->setXValuesHorizontal(true);

?>