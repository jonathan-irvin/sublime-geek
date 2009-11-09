<?php
include 'config.php';
connect2slm();

$api_sql        = "SELECT * FROM `istream_demo` WHERE `key` = '$ownerKey'";
$api_res        = mysql_query($api_sql);
$api_row        = mysql_fetch_array($api_res);

$id             = $api_row['id'];
$name           = $api_row['name'];
$key            = $api_row['key'];
$expires        = $api_row['expires'];
$ak             = $api_row['auth_key'];
$api            = $api_row['api_key'];

$task           = $_POST['task']; //Are we generating an API key or Auth key?
$loc            = $_POST['loc'];  //Where are we taking the user?

//Generate Auth Key Data
$auth_data      = $name.genPass().$key.(microtime()*2).uniqid().$region; 
$gen_auth       = SHA1($auth_data);


//Begin Active License Check
$l_sql          = "SELECT * FROM istream_demo WHERE `key` = '$ownerKey' ";
$l_result       = mysql_query($l_sql);
$l_row          = mysql_fetch_array($l_result);
$l_num          = mysql_num_rows($l_result);

if($l_num == 0){
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
    print("msg,No license detected yet...Creating new license.");
  }
  
  else{
    //Get License Info
    $d_sql          = "SELECT * , subtime( `expires` , '2:0:0' ) AS slt
                              FROM `istream_demo`
                              WHERE `key` = '$ownerKey' ";
    $d_result       = mysql_query($d_sql) or die(mysql_error());
    $d_row          = mysql_fetch_array($d_result);
    $expire         = $d_row['expires'];
    $slt		= $d_row['slt'];
    $timeleft       = strtotime($expire);
    $time           = readable_time(time() - $timeleft, 5);
    $dateslt        = date("D M j Y @ H:i:s \S\L\T", strtotime($slt) );    
      
      if($task == "auth"){  
          $auth_sql = "UPDATE `istream_demo` SET  `auth_key` = '$gen_auth' WHERE `id` = '$id' ";
          $auth_res = mysql_query($auth_sql) or die(mysql_error());
          
          print($loc.','.$api.','.$gen_auth);
      }
  }
  
?>