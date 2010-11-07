<?php

function seqid()
{
list($usec, $sec) = explode(" ", microtime());
list($int, $dec) = explode(".", $usec);
return $sec.$dec.rand();   
}

//creates a unique id with the 'about' prefix
$a = seqid();
echo $a;
echo "<br>";

//creates a longer unique id with the 'about' prefix
$b = uniqid (about, true);
Echo $b;
echo "<br>";

//creates a unique ID with a random number as a prefix - more secure than a static prefix 
$c = uniqid (rand (),true);
echo $c;
echo "<br>";

//this md5 encrypts the username from above, so its ready to be stored in your database
$md5c = md5($c);

?>