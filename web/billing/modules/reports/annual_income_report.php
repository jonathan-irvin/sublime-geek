<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$months = array('January','February','March','April','May','June','July','August','September','October','November','December');

if ($year=="") {
	$year=date("Y");
}

$reportdata["title"] = "Annual Income Report for ".$year;
$reportdata["description"] = "This report shows the income received broken down by month converted to the base currency using rates at the time of the transaction";

$currency = getCurrency(0,1);

$reportdata["tableheadings"] = array("Month","Amount In","Fees","Amount Out","Balance");

for ( $counter = 1; $counter <= 12; $counter += 1) {
	$month = $months[$counter-1];
	$counter = str_pad($counter, 2, "0", STR_PAD_LEFT);
    $query = "SELECT SUM(amountin/rate),SUM(fees/rate),SUM(amountout/rate) FROM tblaccounts WHERE date LIKE '$year-$counter-%'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$amountin = $data[0];
	$fees = $data[1];
	$amountout = $data[2];
	$dailybalance = $amountin-$fees-$amountout;
	$overallbalance += $dailybalance;
	$amountin = formatCurrency($amountin);
	$fees = formatCurrency($fees);
	$amountout = formatCurrency($amountout);
	$dailybalance = formatCurrency($dailybalance);
	$reportdata["tablevalues"][] = array($month." $year",$CONFIG["CurrencySymbol"].$amountin,$CONFIG["CurrencySymbol"].$fees,$CONFIG["CurrencySymbol"].$amountout,$CONFIG["CurrencySymbol"].$dailybalance);
}

$overallbalance = formatCurrency($overallbalance);

$data["footertext"]="<p align=right><b>Balance: ".$CONFIG["CurrencySymbol"].$overallbalance."</b></p><table width=90% align=center><tr><td><a href=\"$PHP_SELF?report=$report&year=".($year-1)."&currencyid=$currencyid\"><< ".($year-1)."</a></td><td align=right><a href=\"$PHP_SELF?report=$report&year=".($year+1)."&currencyid=$currencyid\">".($year+1)." >></a></td></tr></table>";

?>