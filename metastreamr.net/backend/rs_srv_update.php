<?php

require_once ('./config.php');
connect2slm();

$strcvt         = $_POST['stream'];
$stream         = explode(",",$strcvt);
$radname        = trim($stream[0]);
$radurl         = trim($stream[1]);
$vidname        = trim($stream[2]);
$vidurl         = trim($stream[3]);
$srv_admin      = trim($stream[4]);
$cliadmin       = trim($stream[5]);
$demo           = $_POST['demo'];

$sql = "UPDATE istream SET   
  `radname`             = '$radname', 
  `radurl`              = '$radurl',
  `vidname`             = '$vidname',
  `vidurl`              = '$vidurl',
  `cli_admin`           = '$cliadmin'  
  WHERE `owner_key`     = '$ownerKey' ";


      $d_sql          = "SELECT * , subtime( `expires` , '2:0:0' ) AS slt
				FROM `istream_demo`
				WHERE `key` = '$ownerKey' ";
      $d_result       = mysql_query($d_sql) or die(mysql_error());
      $d_row          = mysql_fetch_array($d_result);
      $expire         = $d_row['expires'];
      $slt            = $d_row['slt'];
      $timeleft       = strtotime($expire);
      $time           = readable_time(time() - $timeleft, 5);
      
      $dateslt		= date("D M j Y @ H:i:s \S\L\T", strtotime($slt) );
    
    if($timeleft <= time())
      {
        print("\nYour license has expired as of $dateslt\nIf you wish to purchase the full version, please visit a vendor.");
      }
    else{
        $error = "Error with processing";
        $result = mysql_query($sql) or die(mysql_error());
        
        if($result){print("Updated! \nThank you for choosing [metaStreamr]. \nYour license expires on\n$dateslt."); }
      }
    
?>