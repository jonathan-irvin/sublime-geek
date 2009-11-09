<?php
include 'config.php';
connect2slm();

//Begin Existing/New Account Check
$l_sql          = "SELECT * FROM istream_demo WHERE `key` = '$ownerKey' ";
$l_result       = mysql_query($l_sql);
$l_row          = mysql_fetch_array($l_result);
$l_num          = mysql_num_rows($l_result);

//Variables
$id             = $l_row['id'];
$name           = $l_row['name'];
$key            = $l_row['key'];
$expires        = $l_row['expires'];
$ak             = $l_row['auth_key'];
$api            = $l_row['api_key'];

$task           = $_POST['task']; //Are we generating an API key or Auth key?

$api_data       = $name.$key.microtime().uniqid().genPass();
$gen_api        = SHA1($api_data);

if($l_num == 0){ //No User Detected, Create their account
    $sqldemo = "INSERT INTO `istream_demo` (
                  `id` ,
                  `name` ,
                  `key` ,
                  `expires`
                  )
                  VALUES (
                  NULL ,
                  '$ownerName',
                  '$ownerKey',
                  date_add(NOW(),INTERVAL 7 DAY) )";
                mysql_query($sqldemo);    
  }

//Does user have an API key yet? If not, create one anyways
if($api == ""){  
  $update_sql = "UPDATE `istream_demo` SET  `api_key` =  '$gen_api' WHERE `id` = '$id' ";
  $update_res = mysql_query($update_sql) or die(mysql_error());
  print('newkey,'.$api.','.$gen_auth);
}else{
  print('existing,'.$api.','.$gen_auth);
}
?>