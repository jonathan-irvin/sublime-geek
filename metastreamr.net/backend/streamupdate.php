<?php

require_once ('./config.php');
connect2slm();

  $url = $_POST['stream'];
  $sql = "UPDATE istream SET `url` =  '".$url."' WHERE `owner_key` = '".$ownerKey."' "; 
  $error = "Error with processing";
  mysql_query($sql) or die(mysql_error());
  print ("Updating...");

?>