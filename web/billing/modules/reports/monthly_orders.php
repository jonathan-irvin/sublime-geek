<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$months = array('January','February','March','April','May','June','July','August','September','October','November','December');

if ($month=="") {
	$month=date("m");
	$year=date("Y");
}

$pmonth = str_pad($month, 2, "0", STR_PAD_LEFT);  

$reportdata["title"] = "New Orders for ".$months[$month-1]." ".$year;
$reportdata["description"] = "This report shows all new orders for a given month";

$query = "SELECT tblorders.*,tblclients.firstname,tblclients.lastname,tblpaymentgateways.value FROM tblorders INNER JOIN tblclients ON tblclients.id=tblorders.userid INNER JOIN tblpaymentgateways ON tblpaymentgateways.gateway=tblorders.paymentmethod WHERE tblpaymentgateways.setting='name' AND date like '$year-$pmonth%' ORDER BY date ASC";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);

$reportdata["headertext"] = "Total New Orders: $num_rows";

$reportdata["tableheadings"] = array("Order ID","Order #","Order Date","Client","Amount","Promo Code","Payment Method","Status");

while ($data = mysql_fetch_array($result)) {
	$id = $data["id"];
	$ordernum = $data["ordernum"];
	$userid = $data["userid"];
	$date = $data["date"];
	$amount = $CONFIG["CurrencySymbol"].$data["amount"];
	$promo = $data["promocode"];
	$paymentmethod = $data["value"];
	$status = $data["status"];
	$date = fromMySQLDate($date);
	$currency = getCurrency($userid);
    $clientname = $data["firstname"]." ".$data["lastname"];
	if ($promo=="") {
		$promo="-";
	}
	$reportdata["tablevalues"][] = array($id,$ordernum,$date,$clientname,formatCurrency($amount),$promo,$paymentmethod,$status);
}

$data["footertext"]="<table width=90% align=center><tr><td>";
if ($month=="1") {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=12&year=".($year-1)."\"><< December ".($year-1)."</a>";
} else {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=".($month-1)."&year=".$year."\"><< ".$months[($month-2)]." $year</a>";
}
$data["footertext"].="</td><td align=right>";
if ($month=="12") {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=1&year=".($year+1)."\">January ".($year+1)." >></a>";
} else {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=".($month+1)."&year=".$year."\">".$months[(($month+1)-1)]." $year >></a>";
}
$data["footertext"].="</td></tr></table>";

?>