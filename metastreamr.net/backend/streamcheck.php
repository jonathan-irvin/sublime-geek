<?php

require_once ('./config.php');
connect2slm();

$sim              = $_POST['simname'];
$slurl            = $_POST['slurl'];
$pname            = $_POST['pname'];
$pdesc            = $_POST['pdesc'];
$parea            = $_POST['parea'];

  $sql            = "SELECT * FROM `istream` WHERE `object_key` = '$objectKey' ";
  $error          = "Error with processing";
  $result         = mysql_query($sql) or die(mysql_error());
  $row            = mysql_fetch_array($result);

  $ok             = $row['owner_key'];
  $slurl          = $row['slurl'];
  $radname        = $row['radname'];
  $radurl         = $row['radurl'];
  $vidname        = $row['vidname'];
  $vidurl         = $row['vidurl'];
  $vidtype        = $row['vidtype'];
  $cliadmin       = $row['cli_admin'];
  $srvadmin       = $row['srv_admin'];
  $demo           = $row['demo'];
  $state          = $row['state'];


$d_sql          = "SELECT * , subtime( `expires` , '2:0:0' ) AS slt
                          FROM `istream_demo`
                          WHERE `key` = '$ok' ";
$d_result       = mysql_query($d_sql) or die(mysql_error());
$d_row          = mysql_fetch_array($d_result);
$expire         = $d_row['expires'];
$slt		   = $d_row['slt'];
$timeleft       = strtotime($expire);
$time           = readable_time(time() - $timeleft, 5);

$dateslt        = date("D M j Y @ H:i:s \S\L\T", strtotime($slt) );



if($timeleft <= time())
      {
        print ("UPDATED,LICENSE EXPIRED,LICENSE EXPIRED,LICENSE EXPIRED,LICENSE EXPIRED,LICENSE EXPIRED,LICENSE EXPIRED,Your License Has Expired on \n$dateslt\nPlease visit a vendor online or \nin-world to purchase another license\n,$state");
      }
  else{
        print ("UPDATED,$radname,$radurl,$vidname,$vidtype,$vidurl,$srvadmin,$dateslt,$state");
      }


  $sql2 = "UPDATE istream SET
  `timestamp` 	=  NOW()	,
  `simname` 	= '$sim'	,
  `slurl` 	= '$slurl',
  `parcelname` = '$pname' ,
  `parceldesc` = '$pdesc' ,
  `parcelarea` = '$parea'
  WHERE `object_key` = '".$objectKey."' ";
  mysql_query($sql2) or die(mysql_error());
?>