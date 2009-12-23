<?php
/**
 * Pos-Tracker2
 *
 * Starbase Delete page
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
 * @version    SVN: $Id: deletepos.php 243 2009-04-26 16:10:33Z stephenmg $
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
$eveRender->Assign('config',    $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();

$access = $eve->SessionGetVar('access');
$eveRender->Assign('access', $access);

$pos_id = $eve->VarCleanFromInput('i');

if (!$pos_id) {
    $eve->SessionSetVar('errormsg', 'Need an ID!');
    $eve->RedirectUrl('index.php');
}

$pos = $posmgmt->GetTowerInfo($pos_id);

$arrposize = array(1  => 'Small', 2 => 'Medium', 3 => 'Large');
$arrporace = array(1  => 'Amarr CT',
                   2  => 'Caldari CT',
                   3  => 'Gallente CT',
                   4  => 'Minmatar CT',
                   5  => 'Angel CT',
                   6  => 'Blood CT',
                   7  => 'Dark Blood CT',
                   8  => 'Domination CT',
                   9  => 'Dread Guristas CT',
                   10 => 'Guristas CT',
                   11 => 'Sansha CT',
                   12 => 'Serpentis CT',
                   13 => 'Shadow CT',
                   14 => 'True Sansha CT');

$pos['pos_type_name'] = $arrporace[$pos['pos_race']];
$pos['pos_size_name'] = $arrposize[$pos['pos_size']];

//echo '<pre>';print_r($pos); echo '</pre>';exit;
if (!$pos) {
    $eve->SessionSetVar('errormsg', 'That POS apparently does not exist!');
    $eve->RedirectUrl('index.php');
}

$action = $eve->VarCleanFromInput('action');

if ($action == 'deletepos') {
    // DELETE
    if ($posmgmt->DeletePOS($pos_id)) {
        $eve->SessionSetVar('statusmsg', 'POS deleted!');
        $eve->RedirectUrl('track.php');
    }
}

$eveRender->Assign($pos);

$eveRender->Display('deletepos.tpl');


?>