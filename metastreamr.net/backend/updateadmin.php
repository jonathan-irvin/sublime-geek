<?php

require_once ('./config.php');
connect2slm();

$cliadmin = $_POST['cliadmin'];
$clikey = $_POST['clikey'];
$userkey = $_POST['userkey'];
$nullkey = "00000000-0000-0000-0000-000000000000";

function name2key($name)
  {
      define(NULL_KEY, "00000000-0000-0000-0000-000000000000");
      $key = file('http://w-hat.com/name2key/?terse=1&name=' . urlencode( $name ));       
             if($key[0] != NULL_KEY)
             {                
               return $key[0];
             }
             else
             {
                echo 
                "<script>
								alert(\"Name not recognized!\");
								location.replace(\"https://www.slmarketing.us/rs-show.php\");
                </script>";
                return NULL_KEY;
             }
  }
  $key = name2key($cliadmin);
  if ($key != $nullkey)
 {
    
  $sql = "INSERT INTO `istream_cliadminlist` (`id` ,`userkey` ,`clientname` ,`clientkey`)
  VALUES (NULL , '$userkey', '$cliadmin', '$key') "; 
  $error = "Error with processing";
  mysql_query($sql) or die(mysql_error());
  //print ("Updating...");  
  echo 
  "<script>
                  alert(\"Added $cliadmin as an administrator!\");
                  location.replace(\"https://www.slmarketing.us/rs-show.php\");
  </script>";
  }
  else
  {
  echo 
  "<script>
                  alert(\"Name not recognized!\");
                  location.replace(\"https://www.slmarketing.us/rs-show.php\");
  </script>";
  }
?>