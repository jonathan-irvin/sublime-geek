<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$months = array('January','February','March','April','May','June','July','August','September','October','November','December');

if ($month=="") {
	$month=date("m");
	$year=date("Y");
}

$pmonth = str_pad($month, 2, "0", STR_PAD_LEFT);

$reportdata["title"] = "Sales by Product for ".$months[$month-1]." ".$year;
$reportdata["description"] = "This report gives a breakdown of the number of units sold of each product per month";
$reportdata["currencyselections"] = true;

$total = 0;

$reportdata["tableheadings"] = array("Product Name","Units Sold","Value");

$result = select_query("tblproducts","tblproducts.id,tblproducts.name,tblproductgroups.name AS groupname","","tblproductgroups`.`order` ASC,`tblproducts`.`order` ASC,`name","ASC","","tblproductgroups ON tblproducts.gid=tblproductgroups.id");
while($data = mysql_fetch_array($result)) {
	$pid = $data["id"];
	$group = $data["groupname"];
	$prodname = $data["name"];

    if ($group!=$prevgroup) $reportdata["tablevalues"][] = array("**<b>$group</b>");

    $result2 = select_query("tblhosting","COUNT(*),SUM(tblhosting.firstpaymentamount)","tblhosting.packageid='$pid' AND tblhosting.domainstatus='Active' AND tblhosting.regdate LIKE '$year-$pmonth%' AND tblclients.currency='$currencyid'","","","","tblclients ON tblclients.id=tblhosting.userid");
    $data = mysql_fetch_array($result2);
    $number = $data[0];
    $amount = $data[1];

    $total += $amount;

    $amount = formatCurrency($amount);

    $reportdata["tablevalues"][] = array($prodname,$number,$amount);

    $prevgroup = $group;

}

$reportdata["tablevalues"][] = array("**<b>Addons</b>");

$result = select_query("tbladdons","","","name","ASC");
while($data = mysql_fetch_array($result)) {

    $pid = $data["id"];
    $prodname = $data["name"];

    $result2 = select_query("tblhostingaddons","COUNT(*),SUM(tblhostingaddons.setupfee+tblhostingaddons.recurring)","tblhostingaddons.addonid='$pid' AND tblhostingaddons.status='Active' AND tblhostingaddons.regdate LIKE '$year-$pmonth%' AND tblclients.currency='$currencyid'","","","","tblhosting ON tblhosting.id=tblhostingaddons.hostingid INNER JOIN tblclients ON tblclients.id=tblhosting.userid");
    $data = mysql_fetch_array($result2);
    $number = $data[0];
    $amount = $data[1];

    $total += $amount;

    $amount = formatCurrency($amount);

    $reportdata["tablevalues"][] = array($prodname,$number,$amount);

    $prevgroup = $group;

}

$total = formatCurrency($total);

$data["footertext"]='<table width=90% align=center><tr><td width="25%" align="left">';
if ($month=="1") {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=12&year=".($year-1)."\"><< December ".($year-1)."</a>";
} else {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=".($month-1)."&year=".$year."\"><< ".$months[($month-2)]." $year</a>";
}
$data["footertext"].='</td><td align="center">Total: '.$total.'</td><td width="25%" align="right">';
if ($month=="12") {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=1&year=".($year+1)."\">January ".($year+1)." >></a>";
} else {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=".($month+1)."&year=".$year."\">".$months[(($month+1)-1)]." $year >></a>";
}
$data["footertext"].='</td></tr></table>';

?>