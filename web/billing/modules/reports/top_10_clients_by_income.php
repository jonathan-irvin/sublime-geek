<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$reportdata["title"] = "Top 10 Clients by Income";
$reportdata["description"] = "This report shows the 10 clients with the highest balance in your transactions log.";

$reportdata["tableheadings"] = array("Client Name","Total Amount In","Total Fees","Total Amount Out","Balance");

$query = "SELECT tblclients.id,tblclients.firstname, tblclients.lastname, SUM(tblaccounts.amountin), SUM(tblaccounts.fees), SUM(tblaccounts.amountout), SUM(tblaccounts.amountin-tblaccounts.fees-tblaccounts.amountout) AS balance FROM tblaccounts INNER JOIN tblclients ON tblclients.id = tblaccounts.userid GROUP BY userid ORDER BY balance DESC LIMIT 0,10";
$result=mysql_query($query);
while($data = mysql_fetch_array($result)) {
    $userid = $data[0];

    $currency = getCurrency($userid);

    $reportdata["tablevalues"][] = array($data[1]." ".$data[2],formatCurrency($data[3]),formatCurrency($data[4]),formatCurrency($data[5]),formatCurrency($data[6]));

}

?>