<?php

//License Renewal
require_once ('./config.php');
connect2slm();

$renew          = $_POST['renew'];

$d_sql          = "SELECT * FROM istream_demo WHERE `key` = '$ownerKey' ";
$d_result       = mysql_query($d_sql);
$d_row          = mysql_fetch_array($d_result);
$num            = mysql_num_rows($d_result);

$date           = $d_row['expires'];
$dtime          = strtotime($date);

//If license expired, extend from now else extend on the time already
if($dtime <= time()){$start = "NOW()";}
else{$start = "'$date'";}

if($num == 1){
    $sqldemo = "UPDATE  `istream_demo` 
    SET  `expires` =  date_add($start,INTERVAL $renew) 
    WHERE  `key` = '$ownerKey' ";
    mysql_query($sqldemo);
    
    print ("R3d@y2D!e");
  }

//print($sqldemo);

?>