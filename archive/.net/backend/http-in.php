<?php
$Data = CallLSLScript("http://sigobj88f.obj.virtualid.info", "Hello");
die($Data);
 
//Function by Simba Fuhr
//Use under the GPL License
function CallLSLScript($URL, $Data, $Timeout = 10)
{
 //Parse the URL into Server, Path and Port
 $Host = str_ireplace("http://", "", $URL);
 $Path = explode("/", $Host, 2);
 $Host = $Path[0];
 $Path = $Path[1];
 $PrtSplit = explode(":", $Host);
 $Host = $PrtSplit[0];
 $Port = $PrtSplit[1];
 
 //Open Connection
 $Socket = fsockopen($Host, $Port, $Dummy1, $Dummy2, $Timeout);
 if ($Socket)
 {
  //Send Header and Data
  fputs($Socket, "POST /$Path HTTP/1.1\r\n");
  fputs($Socket, "Host: $Host\r\n");
  fputs($Socket, "Content-type: application/x-www-form-urlencoded\r\n");
  fputs($Socket, "User-Agent: Opera/9.01 (Windows NT 5.1; U; en)\r\n");
  fputs($Socket, "Accept-Language: de-DE,de;q=0.9,en;q=0.8\r\n");
  fputs($Socket, "Content-length: ".strlen($Data)."\r\n");
  fputs($Socket, "Connection: close\r\n\r\n");
  fputs($Socket, $Data);
 
  //Receive Data
  while(!feof($Socket))
   {$res .= fgets($Socket, 128);}
  fclose($Socket);
 }
 
 //ParseData and return it
 $res = explode("\r\n\r\n", $res);
 return $res[1];
}
?>
