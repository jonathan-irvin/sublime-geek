<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$months = array('January','February','March','April','May','June','July','August','September','October','November','December');

if ($month=="") {
	$month=date("m");
	$year=date("Y");
}

$pmonth = str_pad($month, 2, "0", STR_PAD_LEFT);  

$reportdata["title"] = "Monthly Transactions Report for ".$months[$month-1]." ".$year;
$reportdata["description"] = "This report shows a transactions summary for a selected month.";

$reportdata["currencyselections"] = true;

$reportdata["tableheadings"] = array("Date","Amount In","Fees","Amount Out","Balance");

for ( $counter = 1; $counter <= 31; $counter += 1) {
	$counter = str_pad($counter, 2, "0", STR_PAD_LEFT);  
	$query = "SELECT SUM(amountin),SUM(fees),SUM(amountout) FROM tblaccounts INNER JOIN tblclients ON tblclients.id=tblaccounts.userid WHERE date LIKE '$year-$pmonth-$counter%' AND tblclients.currency='$currencyid'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$amountin = $data[0];
	$fees = $data[1];
	$amountout = $data[2];
    $query = "SELECT SUM(amountin),SUM(fees),SUM(amountout) FROM tblaccounts WHERE date LIKE '$year-$pmonth-$counter%' AND userid='0' AND currency='$currencyid'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$amountin += $data[0];
	$fees += $data[1];
	$amountout += $data[2];
	$dailybalance = $amountin-$fees-$amountout;
	$overallbalance += $dailybalance;
	$amountin = formatCurrency($amountin);
	$fees = formatCurrency($fees);
	$amountout = formatCurrency($amountout);
	$dailybalance = formatCurrency($dailybalance);
	$reportdata["tablevalues"][] = array(fromMySQLDate("$year-$pmonth-$counter"),$CONFIG["CurrencySymbol"].$amountin,$CONFIG["CurrencySymbol"].$fees,$CONFIG["CurrencySymbol"].$amountout,$CONFIG["CurrencySymbol"].$dailybalance);
}

$overallbalance = formatCurrency($overallbalance);

$data["footertext"]="<p align=right><b>Balance: ".$CONFIG["CurrencySymbol"].$overallbalance."</b></p><table width=90% align=center><tr><td>";
if ($month=="1") {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=12&year=".($year-1)."&currencyid=$currencyid\"><< December ".($year-1)."</a>";
} else {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=".($month-1)."&year=".$year."&currencyid=$currencyid\"><< ".$months[($month-2)]." $year</a>";
}
$data["footertext"].="</td><td align=right>";
if ($month=="12") {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=1&year=".($year+1)."&currencyid=$currencyid\">January ".($year+1)." >></a>";
} else {
	$data["footertext"].="<a href=\"$PHP_SELF?report=$report&month=".($month+1)."&year=".$year."&currencyid=$currencyid\">".$months[(($month+1)-1)]." $year >></a>";
}
$data["footertext"].="</td></tr></table>";

?>