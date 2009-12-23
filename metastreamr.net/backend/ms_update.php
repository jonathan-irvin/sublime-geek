<?php

require_once ('/home/codeman615/domains/slmarketing.us/private_html/slmconfig.php');
connect2slm();

$id = $_POST['id'];
//$sim = $_POST['simname'];
//$slurl = $_POST['slurl'];
$radname = $_POST['radname'];
$radurl = $_POST['radurl'];
$vidname = $_POST['vidname'];
$vidurl = $_POST['vidurl'];
$cliadmin = $_POST['cliadmin'];
$userkey = $_POST['userkey'];
$cliname = $_POST['cliname'];
  
  $sql = "UPDATE istream SET 
  
  `radname` =  '$radname', 
  `radurl` = '$radurl',
  `vidname` = '$vidname',
  `vidurl` = '$vidurl',
  `cli_admin` = '$cliadmin',
  `cliname` = '$cliname'
  
  WHERE `owner_key` = '$userkey' AND `id` = '$id' "; 
  $error = "Error with processing";
  mysql_query($sql) or die(mysql_error());
  print ("Updating...");
  
echo 
"<script>
								alert(\"Updated with these settings! \\n\\nLocation #$id \\nRadio Station Name: $radname \\nRadio Station URL: $radurl \\nVideo Name: $vidname \\nVideo URL: $vidurl\");
								location.replace(\"https://www.slmarketing.us/rs-show.php\");
</script>";

?>