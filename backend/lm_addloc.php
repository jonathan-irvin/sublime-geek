<?php

include 'config.php';
connect2slm();

$simname   		 	 = addslashes($_POST['simname']);
$locname   		 	 = addslashes($_POST['locname']);
$slurl     		 	 = $_POST['slurl'];
$exurl     		 	 = $_POST['exurl'];
$profilename     	 = $_POST['profname'];
$landdesc     		 = $_POST['pdesc'];
$landarea     		 = $_POST['parea'];

/* BEGIN LMRK.IN API */
// EDIT THIS: your auth parameters
$username = 'admin';
$password = 'Jurb1f!ed';

// EDIT THIS: the query parameters
$url = $exurl; // URL to shrink
$keyword;				// optional keyword
$format = 'simple';				// output format: 'json', 'xml' or 'simple'

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
/* END LMRK.IN API */

$addlmk_sql="INSERT INTO `livemark_profiles` (
`id` ,
`profile_name` ,
`owner_name` ,
`owner_key` ,
`location_name` ,
`location_url` ,
`location_slurl` ,
`location_desc` ,
`location_area` ,
`timestamp`
)
VALUES ('',
 '$profilename', 
 '$ownerName', 
 '$ownerKey', 
 '$locname', 
 '$slurl|$data', 
 '$exurl',
 '$landdesc',
 '$landarea',
 NOW())";
mysql_query($addlmk_sql);

$urlpath  = str_replace("http://lmrk.in/","",$data);

print("newloc|$data|$urlpath");

?>
