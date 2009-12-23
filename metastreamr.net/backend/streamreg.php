<?php
require_once ('./config.php');
connect2slm();
$id             = $_POST['id'];
$sim            = $_POST['simname'];
$slurl          = $_POST['slurl'];
$radname        = $_POST['radname'];
$radurl         = $_POST['radurl'];
$vidname        = $_POST['vidname'];
$vidtype        = $_POST['vidtype'];
$vidurl         = $_POST['vidurl'];
$cliadmin       = $_POST['cliadmin'];
$userkey        = $_POST['userkey'];
$srv_admin      = $_POST['srvadmin'];
$demo           = $_POST['demo'];

$pname           = $_POST['pname'];
$pdesc           = $_POST['pdesc'];
$parea           = $_POST['parea'];

$state           = $_POST['cli_state'];

$sqlreg = "INSERT INTO  `istream` (
                  `id` ,
                  `object_key`  ,
                  `owner_key`   ,
                  `simname`     ,
			   `parcelname`   ,
			   `parceldesc`   ,
			   `parcelarea`   ,
                  `slurl`       ,
                  `radname`     ,
                  `radurl`      ,
                  `vidname`     ,
			   `vidtype`      ,
                  `vidurl`      ,
                  `srv_admin`   ,
                  `cli_admin`   ,
                  `cliname`     ,
                  `timestamp`   ,
                  `demo`,
			   `state`
                  )
                  VALUES (
                  NULL ,
                  '$objectKey'  ,
                  '$ownerKey'   ,
                  '$sim'    ,
                  '$pname'    ,
			   '$pdesc'    ,
			   '$parea'    ,
			   '$slurl'      ,
                  '$radname'    ,
                  '$radurl'     ,
                  '$vidname'    ,
			   '$vidtype'     ,
                  '$vidurl'     ,
                  '$ownerKey'   ,
                  '$cliadmin'   ,
                  'None Set'    ,
                  CURRENT_TIMESTAMP,
                  '$demo',
			   'ACTIVE'
                  )";

  $d_sql          = "SELECT * FROM istream_demo WHERE `key` = '$ownerKey' ";
  $d_result       = mysql_query($d_sql);
  $d_row          = mysql_fetch_array($d_result);
  $num            = mysql_num_rows($d_result);

  if($num == 0){
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

    //$error = $sqlreg;
    mysql_query($sqlreg);
    // or die(mysql_error());
    if(mysql_error()){echo "Already registered...proceeding...";}
    else{echo "Registering with the database...Done";}

?>