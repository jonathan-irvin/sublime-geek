<?php

function connect2slm()
{
mysql_connect('localhost', 'root', 'Jurb1f!ed615') 
or die(mysql_error());
mysql_select_db("sblg_mb") or die(mysql_error()); 
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

function addLivemark(){
	// EDIT THIS: your auth parameters
	$username = 'admin';
	$password = 'Jurb1f!ed';

	// EDIT THIS: the query parameters
	$url; // URL to shrink
	$keyword;				// optional keyword
	$format = 'json';				// output format: 'json', 'xml' or 'simple'

	// EDIT THIS: the URL of the API file
	$api_url = 'http://lmrk.in/yourls-api.php';

	// Init the CURL session
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $api_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);            // No header in the result
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result
	curl_setopt($ch, CURLOPT_POST, 1);              // This is a POST request
	curl_setopt($ch, CURLOPT_POSTFIELDS, array(     // Data to POST
			'url'      => $url,
			'keyword'  => $keyword,
			'format'   => $format,
			'action'   => 'shorturl',
			'username' => $username,
			'password' => $password
		));

	// Fetch and return content
	$data = curl_exec($ch);
	curl_close($ch);

	// Do something with the result. Here, we just echo it.
	return $data;
}
/*
function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
    
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time();
    $unix_date         = strtotime($date);
    
       // check validity of date
    if(empty($unix_date)) {    
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "ago";
        
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        $periods[$j].= "s";
    }
    
    return "$difference $periods[$j] {$tense}";
}
*/
?>
