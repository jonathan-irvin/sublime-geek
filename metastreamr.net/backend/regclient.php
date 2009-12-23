<?

require_once ('./config.php');
connect2slm();
// and so on for getting all the other variables ...
$date 			= date('Y-m-d G:i:s');
$slurl    		= $_GET["slurl"];
$parcelname    	        = $_GET["parcelname"];
$mfgid    		= $_GET["mfgid"];
$simname    	        = $_GET["simname"];
$ownerkey    	        = $_GET["ownerkey"];
$objectkey    	        = $_GET["objectkey"];
$xmlchan    	        = $_GET["xmlchan"];

$radname    		= $_GET["radname"];
$radurl    		= $_GET["radurl"];
$vidname    		= $_GET["vidname"];
$vidurl    		= $_GET["vidurl"];
$cliadmin    		= $_GET["cliadmin"];

$sqlreg = "INSERT INTO  `istream` (
                  `id` ,
                  `object_key`  ,
                  `owner_key`   ,
                  `simname`     ,
                  `slurl`       ,
                  `radname`     ,
                  `radurl`      ,
                  `vidname`     ,
                  `vidurl`      ,
                  `srv_admin`   ,
                  `cli_admin`   , 
                  `cliname`     ,
                  `timestamp`
                  )
                  VALUES (
                  NULL ,  
                  '$objectkey'  ,  
                  '$ownerkey'   ,    
                  '$simname'    ,  
                  '$slurl'      ,  
                  '$radname'    ,  
                  '$radurl'     ,  
                  '$vidname'    ,  
                  '$vidurl'     ,  
                  '$ownerkey'   ,  
                  '$cliadmin'   ,
                  'None Set'    , 
                  CURRENT_TIMESTAMP
                  )";


$getitemname    = mysql_query("SELECT * FROM vgi_mfg_games WHERE mfg_id='$mfgid'");
$name           = mysql_result($getitemname,0,'name');
$type           = mysql_result($getitemname,0,'type');
mysql_free_result($getitemname);

	$result = mysql_query("SELECT * FROM vgi_games WHERE machine_key='$objectkey' AND owner_key='$ownerkey'");
	$num = mysql_num_rows($result);				
	mysql_free_result($result);
	
	if($num == 0)
	{
		mysql_query("INSERT INTO vgi_games 
                VALUES (
                '',
                '$objectkey',
                '$xmlchan',
                '$mfgid',
                '$name',
                '$type',
                '$ownerkey',
                '$parcelname',
                '$simname',
                '$slurl',
                'Activated',
                '$date')") or die("Unable to post transaction\n");
                
                mysql_query($sqlreg);
                
                print $sqlreg;

                //print("registerme");
	}
	else
	{
		mysql_query("UPDATE vgi_games SET 
                xmlchan='$xmlchan',
                parcelname='$parcelname',
                slurl='$slurl',
                sim='$simname',
                activetime='$date' 
                WHERE machine_key='$objectkey' 
                AND owner_key='$ownerkey'") 
                or die("Unable to post transaction\n");
                print("registered");
	}
	
?>
