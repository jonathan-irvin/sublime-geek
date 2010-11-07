<?php

define("CLIENTAREA",true);

include("dbconnect.php");
include("includes/functions.php");

if (isset($aff)) {
	update_query("tblaffiliates",array("visitors"=>"+1"),array("id"=>$aff));
	setcookie("WHMCSAffiliateID", $aff, time()+90*24*60*60);
}

if ($pid) {
    header("Location: cart.php?a=add&pid=$pid");
    exit;
}

header("HTTP/1.1 301 Moved Permanently");
header("Location: ".$CONFIG["Domain"]);

?>