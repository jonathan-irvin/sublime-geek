<?php

require_once ('./config.php');
connect2slm();

$sql = "UPDATE istream SET `url` =  '".$url."' WHERE `owner_key` = '".$ownerKey."' "; 
  $error = "Error with processing";
  mysql_query($sql) or die(mysql_error());

//Get All Units 3 days or older
$sql = 'SELECT `timestamp` FROM `istream` WHERE `timestamp` < CURRENT_DATE()-3'; 

$result = mysql_query($sql);
while ($row = mysql_fetch_array($result,MYSQL_NUM)) {
$sqldelete = 'DELETE FROM `istream` WHERE `istream`.`timestamp` < CURRENT_DATE()-3 ';
mysql_query($sqldelete) or die(mysql_error());
}

?>