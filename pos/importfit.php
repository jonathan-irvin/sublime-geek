<?php
/**
 * Pos-Tracker2
 *
 * Starbase Modules XML import page
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
 * @version    SVN: $Id: importfit.php 243 2009-04-26 16:10:33Z stephenmg $
 * @link       https://sourceforge.net/projects/pos-tracker2/
 * @link       http://www.eve-online.com/
 */

include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$eveRender->Assign('config', $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();


$access = $eve->SessionGetVar('access');

if ($access < 1) {
    $eve->RedirectUrl('login.php');
}

$eveRender->Assign('access', $access);
if (empty($pos_id)) {
    $pos_id = $eve->VarCleanFromInput('pos_id');
}
if (empty($pos_id)) {
    $eve->SessionSetVar('errormsg', 'No POS ID!');
    $eve->RedirectUrl('track.php');
}
$tower['pos_id']=$pos_id;
$action = $eve->VarCleanFromInput('action');

if ($access < 3) {
    $eve->RedirectUrl('track.php');
}

switch($action) {
    case 'Import Structures':
		$eveRender->Assign('tower',         $tower);
		$eveRender->Display('importfit.tpl');
	break;
	case 'Send File':
	$tmp_name=$_FILES["fitimport"]["tmp_name"];
	echo $tmp_name."<br>".$_POST['xmlstyle']."<br>".$pos_id;
		if (file_exists($tmp_name)) {
			try {
				$xml = simplexml_load_file($tmp_name);
			} catch (Exception $e) {
				$eve->SessionSetVar('errormsg', 'File Not Valid!');
			}
			$structures=array();
				if($_POST['xmlstyle']=='mypos')
				{
					foreach ($xml->xpath('//ItemID') as $key => $structure) {
						$posmgmt->addstructure($structure, $pos_id, 1);
						$structures[$key]=$structure;
					}
				}
				if($_POST['xmlstyle']=='tracker')
				{
					foreach ($xml->xpath('//structure') as $key =>$structure) {
						$posmgmt->addstructure($structure['typeID'], $pos_id, $structure['online']);
						$structures[$key]=$structure;
					}
				}
			echo"<pre>";print_r($structures);echo"</pre>";exit;
			$eveRender->Assign('poses',     $structures);
			} else {
		    $eve->SessionSetVar('errormsg', 'Failed to Open File!');
			}
	break;
}

?>