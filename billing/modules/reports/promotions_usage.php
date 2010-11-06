<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$reportdata["title"] = "Promotions Usage Report";
$reportdata["description"] = "This report shows usage statistics for each promotional code.";

$reportdata["tableheadings"] = array("Coupon Code","Item","Discount","Value","Number of Uses");

$query = "SELECT * FROM tblpromotions ORDER BY code ASC"; 
$result=mysql_query($query);
while($data = mysql_fetch_array($result)) {
	$code = $data["code"];
	$item = $data["item"];
	$type = $data["type"];
	$discount = $data["discount"];
	$value = $data["value"];
	$uses = $data["uses"];
	$reportdata["tablevalues"][] = array($code,$item,$discount,$value,$uses);
}

?>