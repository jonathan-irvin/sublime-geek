<?php

function connect2slm()
{
mysql_connect("localhost", "geekfox", "jurby5000") or die(mysql_error());
mysql_select_db("geekfox_ms") or die(mysql_error()); 
}

function genPass()        
        {
            $len      = 36; 
            $char     = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?';       
            $chars    = $char;
            $numChars = strlen($chars);
     
            $string = '';
            for ($i = 0; $i < $len; $i++) {
                $string .= substr($chars, rand(1, $numChars) - 1, 1);
            }
            return $string;
        }

function emu_getallheaders()
{
    foreach($_SERVER as $name => $value)
    if(substr($name, 0, 5) == 'HTTP_')
        $headers[str_replace('X-Secondlife-', 'X-SecondLife-', str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5))))))] = $value;
    return $headers;
}

function readable_time($timestamp, $num_times = 2)
{
    //this returns human readable time when it was uploaded (array in seconds)
    $times = array(31536000 => 'y', 2592000 => 'm',  604800 => 'w', 86400 => 'd', 3600 => 'h', 60 => 'min', 1 => 'sec');
    $now = time();
    $secs = $now - $timestamp;
    $count = 0;
    $time = '';

    foreach ($times AS $key => $value)
    {
        if ($secs >= $key)
        {
            //time found
            $s = '';
            $time .= floor($secs / $key);

            if ((floor($secs / $key) != 1))
                $s = 's';

            $time .= ' ' . $value . $s;
            $count++;
            $secs = $secs % $key;
           
            if ($count > $num_times - 1 || $secs == 0)
                break;
            else
                $time .= ', ';
        }
    }

    return $time;
}

function seqid(){
list($usec, $sec) = explode(" ", microtime());
list($int, $dec) = explode(".", $usec);
return $sec.$dec;}

$headers = emu_getallheaders();

$objectName     = $headers["X-SecondLife-Object-Name"];
$objectKey      = $headers["X-SecondLife-Object-Key"];
$ownerKey       = $headers["X-SecondLife-Owner-Key"];
$ownerName      = $headers["X-SecondLife-Owner-Name"];
$region         = $headers["X-SecondLife-Region"];

?>