<?php

include 'config.php';
connect2slm();

$simname   		 	 = addslashes($_POST['simname']);
$locname   		 	 = addslashes($_POST['locname']);
$slurl     		 	 = $_POST['slurl'];
$exurl     		 	 = $_POST['exurl'];
$profilename     	 	 = $_POST['profname'];
$landdesc     		 	 = $_POST['pdesc'];
$landarea     		 	 = $_POST['parea'];

$addlmk_sql="INSERT INTO `livemark_profiles`(`id` ,`profile_name` ,`owner_name` ,`owner_key` ,`location_name` ,`location_url` ,`location_slurl` ,`location_desc` ,`location_area` ,`timestamp`)VALUES ('', '$profilename',  '$ownerName',  '$ownerKey',  '$locname',  '$slurl',  '$exurl', '$landdesc', '$landarea', NOW())";
mysql_query($addlmk_sql);

$urlpath  = str_replace("http://lmrk.in/","",$data);

print("newloc|$data|$urlpath");

?>
