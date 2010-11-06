<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$description = "This graph shows average support ratings by staff member";

if ($statsonly) { return false; }

$chartdata = array();

$query = "SELECT admin, AVG(rating) AS avgrating FROM `tblticketreplies` WHERE admin != '' AND rating!='0' GROUP BY admin ORDER BY avgrating ASC";
$result = mysql_query($query);
while ($data = mysql_fetch_array($result)) {
    $chartdata[$data[0]] = round($data[1],2);
}

$graph=new WHMCSGraph(650,400);
$graph->addData($chartdata);
$graph->setTitle("Average Support Ticket Ratings by Staff Member");
$graph->setGradient("lime", "green");
$graph->setDataValues(true);
$graph->setXValuesHorizontal(true);

?>