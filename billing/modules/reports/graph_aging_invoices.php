<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$description = "This graph shows the value of aging invoices.";

if ($statsonly) { return false; }

$newtotal = 0;
$new_time=mktime(0,0,0,date("m"),date("d")-30,date("Y"));
$date = date("Y-m-d",$new_time);
$query = "SELECT SUM(total) FROM tblinvoices WHERE duedate<='".date("Y-m-d")."' AND duedate>='$date' AND status='Unpaid'";
$result = mysql_query($query);
$data = mysql_fetch_array($result);
$totaldue = $data[0];
$newtotal = $totaldue;
$chartdata["0-30"] = format_as_currency($totaldue);
$new_time=mktime(0,0,0,date("m"),date("d")-60,date("Y"));
$date = date("Y-m-d",$new_time);
$query = "SELECT SUM(total) FROM tblinvoices WHERE duedate<='".date("Y-m-d")."' AND duedate>='$date' AND status='Unpaid'";
$result = mysql_query($query);
$data = mysql_fetch_array($result);
$totaldue = $data[0]-$newtotal;
$newtotal += $totaldue;
$chartdata["31-60"] = format_as_currency($totaldue);
$new_time=mktime(0,0,0,date("m"),date("d")-90,date("Y"));
$date = date("Y-m-d",$new_time);
$query = "SELECT SUM(total) FROM tblinvoices WHERE duedate<='".date("Y-m-d")."' AND duedate>='$date' AND status='Unpaid'";
$result = mysql_query($query);
$data = mysql_fetch_array($result);
$totaldue = $data[0]-$newtotal;
$newtotal += $totaldue;
$chartdata["61-90"] = format_as_currency($totaldue);
$new_time=mktime(0,0,0,date("m"),date("d")-120,date("Y"));
$date = date("Y-m-d",$new_time);
$query = "SELECT SUM(total) FROM tblinvoices WHERE duedate<='".date("Y-m-d")."' AND duedate>='$date' AND status='Unpaid'";
$result = mysql_query($query);
$data = mysql_fetch_array($result);
$totaldue = $data[0]-$newtotal;
$newtotal += $totaldue;
$chartdata["91-120"] = format_as_currency($totaldue);
$query = "SELECT SUM(total) FROM tblinvoices WHERE duedate<='".date("Y-m-d")."' AND status='Unpaid'";
$result = mysql_query($query);
$data = mysql_fetch_array($result);
$totaldue = $data[0]-$newtotal;
$newtotal += $totaldue;
$chartdata["120+"] = format_as_currency($totaldue);
$graph=new WHMCSGraph(650,400);
$graph->addData($chartdata);
$graph->setTitle("Aging Invoices");
$graph->setGradient("lime", "green");
$graph->setDataValues(true); 
$graph->setXValuesHorizontal(true);

?>