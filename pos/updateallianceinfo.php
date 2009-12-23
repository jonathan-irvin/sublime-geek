<?php
/**
 * Pos-Tracker2
 *
 * Alliance API update script
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
require_once 'functions.php';
require_once 'header.php';


$time = time();
//Sets the location of the eveapi xml file to parse
$url="http://api.eve-online.com/eve/AllianceList.xml.aspx";

//Begins connecting to eve api

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
//curl_setopt($ch, CURLOPT_POST, 1);
$counttotal = 0;
$updatestotal = 0;
$time = time();

//Create XML Parser
$xml = new SimpleXMLElement(curl_exec($ch));
curl_close($ch);
$fail=0;
foreach ($xml->xpath('//error') as $error) {
			echo "Error: ".$error['code']."<br>\n";
			$fail=1;
	}
if($fail!=1)
{
	$sql = "UPDATE `".TBL_PREFIX."alliance_info` SET `updateTime` = '" . $time . "' where `allianceID` = '0'";
	$result = mysql_query($sql) or die('Could not update time, contact your admin;' . mysql_error());


	//Parse the file
	foreach ($xml->xpath('/eveapi/result/rowset/row') as $row) {
		//Finds out if 
		$sql = 'SELECT * FROM `'.TBL_PREFIX.'alliance_info` WHERE `allianceID` = '.my_escape($row['allianceID']).' LIMIT 1';
		$result = mysql_query($sql)
			or die('Could not select Member; ' . mysql_error());
		$name=$row['name'];
		$counttotal = $counttotal +1;
		if (mysql_num_rows($result) == 0) {
			
			$sql = 'INSERT INTO `'.TBL_PREFIX.'alliance_info` (`allianceID`, `name`, `shortName`, `updateTime`) VALUES (\''.my_escape($row['allianceID']).'\', \''.my_escape($row['name']).'\', \''.my_escape($row['shortName']).'\', \''.$time.'\');';
			$result = mysql_query($sql)
				or die('Could not Insert; ' . mysql_error());
				echo "Adding ".my_encode($row['name'])." &lt;".my_encode($row['shortName'])."&gt;<br>\n";
			$updatestotal = $updatestotal + 1;
		}
		else
		{
			$time = time();
			$sql = 'UPDATE `'.TBL_PREFIX.'alliance_info` SET `allianceID` =\''.$row['allianceID'].'\', `name` = \''.$row['name'].'\', `shortName` = \''.$row['shortName'].'\', `updateTime` = \''.$time.'\'  WHERE `alliance_info`.`allianceID` = \''.$row['allianceID'].'\' LIMIT 1;';
		}
	}
	foreach ($xml->xpath('//cachedUntil') as $cached) {
	 	echo "<br>";
		echo $cached."<br>\n";
	}
	echo "<br>";
	echo "Success"."<br>\n";
	echo "Total Number of Alliances: " . $counttotal . "<br>";
	echo "Total Number of Updates: " . $updatestotal . "<br>";
	echo "<form method=\"post\" action=\"track.php\"><input type=\"submit\" name=\"action\" value=\"Done\"></form>";
	require_once 'footer.php';
	ob_end_flush();
}

?>