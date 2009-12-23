<?php
/**
 * Pos-Tracker2
 *
 * Starbase API update script
 *
 * PHP version 5
 *
 * LICENSE: This file is part of POS-Tracker2.
 * POS-Tracker2 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 3 of the License.
 *
 * POS-Tracker2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with POS-Tracker2.  If not, see <http://www.gnu.org/licenses/>.
 *

 * @author     Stephen Gulickk <stephenmg12@gmail.com>
 * @author     DeTox MinRohim <eve@onewayweb.com>
 * @author      Andy Snowden <forumadmin@eve-razor.com>
 * @copyright  2007-2009 (C)  Stephen Gulick, DeTox MinRohim, and Andy Snowden
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @package    POS-Tracker2
 * @version    SVN: $Id$
 * @link       https://sourceforge.net/projects/pos-tracker2/
 * @link       http://www.eve-online.com/
 */
ob_start();
require_once 'config.php';
require_once 'header.php';
require_once 'functions.php';
$url="http://api.eve-online.com/corp/StarbaseList.xml.aspx";
$sql1 = "SELECT * FROM `".TBL_PREFIX."eveapi`";
$result1 = mysql_query($sql1);
if($_SESSION['access']>=3) {
if (mysql_num_rows($result1) > 0) {
while($row1 = mysql_fetch_array($result1)) {
	$time=time();
	if($row['apitimer'] < ($time-3600))
	{
	$userid=$row1['userID'];
	$apikey=$row1['apikey'];
	$characterID=$row1['characterID'];
	$corp=$row1['corp'];
	$allianceID=$row1['allianceID'];
	$fail=0;
	$count_added=0;
	$count_updated=0;
	$count_towers=0;
	$version=2;
	$data = array(
		'userID' => $userid,
		'apiKey' => $apikey,
		'version' => $version,
		'characterID' => $characterID
	);
	

	//Begins connecting to eve api

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	$curl_error=curl_errno($ch);
	if($curl_error!=0)
	{
		$fail=1;
		echo $curl_error;
	} //if curl error
if($fail!=1 || $curl_error!=0)
{
	$xmlstr = ''; // empty to throw an exception
	//LOAD $ch from CURL into $xml as an SimpleXMLElement
	try {
		
		$xml = new SimpleXMLElement(curl_exec($ch));
	} catch (Exception $e) {
		// handle the error
		echo 'Not a valid xml string';
		$fail=1;
	}
	//Close CURL connection
	curl_close($ch);
	if($fail!=1)
	{
		foreach ($xml->xpath('//error') as $error) {
					echo "Error Code: ".$error['code']."::".$error.". User ID: ".$userID." Character ID: ".$characterID." Corp: ".$corp."\n";
					$fail=1;
			}
		if($fail!=1)
		{
			foreach ($xml->xpath('//row') as $pos) {
				(integer) $evetowerid=$pos['itemID'];
				(integer) $typeID=$pos['typeID'];
				(integer) $systemID=$pos['locationID'];
				$fuel=posdetail($evetowerid, $userid, $apikey, $characterID);
				(string) $outpost_name="None";
				(string) $towerName="EVE API";		
				(integer) $isotope=$fuel['isotope'];
				(integer) $oxygen=$fuel['oxygen'];
				(integer) $mechanical_parts=$fuel['mechanical_parts'];
				(integer) $coolant=$fuel['coolant'];
				(integer) $robotics=$fuel['robotics'];
				(integer) $uranium=$fuel['uranium'];
				(integer) $ozone=$fuel['ozone'];
				(integer) $heavy_water=$fuel['heavy_water'];
				(integer) $charters=$fuel['charters'];
				(integer) $strontium=$fuel['strontium'];
				(integer) $systemID=$pos['locationID'];
				(integer) $owner_id=0;
				(integer) $moonID=$pos['moonID'];
				
				#define varibles for the row count function
					$sql = "SELECT * FROM `".TBL_PREFIX."tower_info` WHERE `evetowerID` = ".my_escape($evetowerid).";";
					$result = mysql_query($sql)
						or die('Could not get tower_info; ' . mysql_error());
							if (mysql_num_rows($result)> 0) {
								$sql = "UPDATE ".TBL_PREFIX."tower_info SET isotope='" . my_escape($isotope) . "', oxygen='" . my_escape($oxygen) . "', mechanical_parts='" . my_escape($mechanical_parts) . "', coolant='" . my_escape($coolant) . "', robotics='" . my_escape($robotics) . "', uranium='" . my_escape($uranium) . "', ozone='" . my_escape($ozone) . "', heavy_water='" . my_escape($heavy_water) . "', strontium='" . my_escape($strontium) . "', charters='". my_escape($charters) ."' WHERE evetowerid = '" . my_escape($evetowerid) . "'";
								$result = mysql_query($sql);
								echo $evetowerid." is already in database<br>\n";
								$sql = 'SELECT * FROM `'.TBL_PREFIX.'tower_info` WHERE `evetowerID` = '.$evetowerid.' LIMIT 0, 30 ';
								$result = mysql_query($sql);
								$row = mysql_fetch_array($result);
								$pos_id=$row['pos_id'];
								$count_updated++;
								$count_towers++;
							} // If Count
							//Add to POS to database if not already in
							else {
								$sql = "SELECT * FROM `".TBL_PREFIX."tower_static` WHERE `typeID` = ".$typeID." LIMIT 0, 30 ";
								$result = mysql_query($sql);
								$row = mysql_fetch_array($result);
								(integer) $pos_size=$row['pos_size'];
								(integer) $pos_race=$row['pos_race'];
								
								$sql = "INSERT INTO `".TBL_PREFIX."tower_info` (`typeID`, `evetowerID`, `outpost_name`, `corp`, `allianceid`, `pos_size`, `pos_race`, `isotope`, `oxygen`, `mechanical_parts`, `coolant`, `robotics`, `uranium`, `ozone`, `heavy_water`, `charters`, `strontium`, `towerName`, `systemID`, `charters_needed`, `status`, `owner_id`, `secondary_owner_id`, `pos_status`, `pos_comment`, `secret_pos`, `moonID`) VALUES ('".my_escape($typeID)."', '".my_escape($evetowerid)."', 'None', '" . my_escape($corp) . "', '" . my_escape($allianceid) . "', '" . my_escape($pos_size) . "', '" . my_escape($pos_race) . "', '" . my_escape($isotope) . "', '" . my_escape($oxygen) . "', '" . my_escape($mechanical_parts) . "', '" . my_escape($coolant) . "', '" . my_escape($robotics) . "', '" . my_escape($uranium) . "', '" . my_escape($ozone) . "', '" . my_escape($heavy_water) . "', '".my_escape($charters)."', '" . my_escape($strontium) . "', '" . my_escape($towerName) . "', '" . my_escape($systemID) . "', '0','0','". my_escape($owner_id) ."' , 'NULL', 'False', 'NULL', '0', '" . my_escape($moonID) . "')";
								$result = mysql_query($sql)	or die('Could not insert values into tower_info; ' . mysql_error());
								$pos_id = mysql_insert_id();
								echo $evetowerid." has been added<br>\n";
								$count_added++;
								$count_towers++;
								
							} //Else Count
								$time = time();
								$sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES ('NULL', '0', '" . $pos_id . "', '1', 'EVEAPI XML STARBASE API UPDATE', '" . $time . "')";
								$result = mysql_query($sql)	or die('Could not insert values into update_log; ' . mysql_error());
							
			} //foreach Row as POS

			foreach ($xml->xpath('//cachedUntil') as $cached) {
				echo $cached."<br>\n";
			} //Foreach cached
		} //IF Fail
		if($fail==0)
		{
			echo "Success" . "<br>\n";
			echo "Towers Added: " . $count_added."<br>\n";
			echo "Towers Updated: ".$count_updated."<br>\n";
			echo "Total Towers : ".$count_towers."<br>\n";
			echo "<br>";
			echo "<form method=\"post\" action=\"track.php\"><input type=\"submit\" name=\"action\" value=\"Done\"></form>";
		} //if fail
	} //if fail
	} //if fail curl
	if($fail==0)
	{
		$sql = "UPDATE ".TBL_PREFIX."eveapi SET apitimer='".my_escape($time)."' WHERE characterID = '" . my_escape($characterID) . "';";
		$result = mysql_query($sql)
						or die('Could not get tower_info; ' . mysql_error());
		
	}
} //apitimer check
} //while row
} //if num rows
} //if session access 3
	require_once 'footer.php';



function posdetail($itemID, $userid, $apikey, $characterID)
{

	$url='http://api.eve-online.com/corp/StarbaseDetail.xml.aspx';

	$version='2';
	$data = array(
	'userID' => $userid,
	'apiKey' => $apikey,
	'version' => $version,
	'itemID' => $itemID,
	'characterID' => $characterID
	);


	//Begins connecting to eve api

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$curl_error=curl_errno($ch);
	if($curl_error!=0)
	{
		$fail=1;
		echo $curl_error;
		curl_close($ch);
	}
	if($fail!=1 || $curl_error!=0)
	{
		$xmlstr = ''; // empty to throw an exception
		//LOAD $ch from CURL into $xml as an SimpleXMLElement
		try {
			
			$xml = new SimpleXMLElement(curl_exec($ch));
			//$xml = new SimpleXMLElement($xmlstr);
		} catch (Exception $e) {
			// handle the error
			echo 'Not a valid xml string';
			$fail=1;
		}
		//Close CURL connection
		curl_close($ch);
		if($fail!=1)
		{
			foreach ($xml->xpath('//error') as $error) {
						echo "Error: ".$error['code']."<br>\n";
						$fail=1;
				}
			if($fail!=1)
			{
			foreach ($xml->xpath('//row') as $row) {
				switch ($row['typeID']) {
					case '44':
						$uranium=$row['quantity'];
					break;
					case '3683':
						$oxygen=$row['quantity'];
					break;
					case '3689':
						$mechanical_parts=$row['quantity'];
					break;
					case '9832':
						$coolant=$row['quantity'];
					break;
					case '9848':
						$robotics=$row['quantity'];
					break;
					case '16272':
						$heavy_water=$row['quantity'];
					break;
					case '16273':
						$ozone=$row['quantity'];
					break;
					case '16274':
					case '17887':
					case '17888':
					case '17889':
						$isotope=$row['quantity'];
					break;
					case '24592':
					case '24593':
					case '24594':
					case '24595':
					case '24596':
					case '24597':
						$charters=$row['quantity'];
					break;
					case '16275':
						$strontium=$row['quantity'];
					break;
				} //switch xml row typeID
			} //XML foreach row (fuel)
			//echo "TypeID: ".$row['typeID']." TowerID: ".$itemID." Enriched Uranium: ".$uranium." Oxygen: ".$oxygen." Mechanical Parts: ".$mechanical_parts." Coolant: ".$coolant." Robotics: ".$robotics." Heavy Water: ".$heavy_water." Liquid Ozone: ".$ozone." Isotope: ".$isotope." Strontium: ".$strontium."<br>";
				$fuel["isotope"] = $isotope;
				$fuel["oxygen"] = $oxygen;
				$fuel["mechanical_parts"] = $mechanical_parts;
				$fuel["coolant"] = $coolant;
				$fuel["robotics"] = $robotics;
				$fuel["uranium"] = $uranium;
				$fuel["strontium"] = $strontium;
				$fuel["ozone"] = $ozone;
				$fuel["heavy_water"] = $heavy_water;
				if($charters>0) {
					$fuel["charters"]= $charters;
				}
				else {
					$fuel["charters"]= 0;
				}
				return $fuel;
			} //if fail
		} //if fail
	} //if fail
} //function posdetail

?>