<?php

require_once ('./config.php');
connect2slm();

$cliadmin = $_POST['cliadmin'];
$clikey = $_POST['clikey'];
$userkey = $_POST['userkey'];
$cli_id = $_POST['cli_id'];
  
  $sql = "DELETE FROM `istream_cliadminlist` WHERE id = '$cli_id' AND userkey = '$userkey' "; 
  $error = "Error with processing";
  mysql_query($sql) or die(mysql_error());
  
echo 
"<script>
								alert(\"Deleted $cliadmin as an administrator!\");
								location.replace(\"https://www.slmarketing.us/rs-show.php\");
</script>";

?>