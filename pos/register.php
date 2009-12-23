<?php
/**
 * Pos-Tracker2
 *
 * POS-Tracker new user registration
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
 * @version    SVN: $Id: register.php 243 2009-04-26 16:10:33Z stephenmg $
 * @link       https://sourceforge.net/projects/pos-tracker2/
 * @link       http://www.eve-online.com/
 */

include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';
include_once 'includes/class.posmailer.php';

$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;
$eveRender->Assign('config', $config);
$eve     = New Eve();
$posmgmt = New POSMGMT();

//Create and initialize mail object
$mail = new posMailer();
$mail->mailinit();

//Add site URL to $mail object
$url_path=$eve->GetBaseURL();
$mail->site_URL=$url_path;

$IS_IGB = false;



if ($eve->IsMiniBrowser()) {
    if (!$eve->IsTrusted()) {
        $eve->RequestTrust('You must add this site to your trusted list to log in in-game!');
    } else {

        $userinfo = $eve->GetUserVars();

        $action = $eve->VarCleanFromInput('action');

        if (!empty($action) && $action == 'Create') {
            $email = $eve->VarCleanFromInput('email');
            $pass  = $eve->VarCleanFromInput('pass');

            if (empty($pass) || empty($email)) {
                $eve->SessionSetVar('errormsg', 'Fill all the fields smartass!');
                $eve->RedirectUrl('register.php');
            }

            $time = time();
            // pulls alliance name from the server, then sends it to the function to convert into idnumber
            $alliancename = $eve->VarPrepForStore($userinfo['useralliance']);
            $result = mysql_query("SELECT * FROM ".TBL_PREFIX."alliance_info WHERE `name` = '".$alliancename."' LIMIT 1") or die('Could not find allianceid to name;' . mysql_error());
            $row = mysql_fetch_array($result);
            //Password Hash
            $password = $posmgmt->newpasswordhash($pass); //New Password hashing method
			//Email Validtion Code generation
			$email_code= $posmgmt->newpasswordhash($eve->VarPrepForStore($email));
            // made changes to accept the new varibles
                       $sql = "INSERT INTO ".TBL_PREFIX."user
                    VALUES     (NULL,
                                '" . $eve->VarPrepForStore($eve->ServerGetVar('HTTP_EVE_CHARID')) . "',
                                '" . $eve->VarPrepForStore($eve->ServerGetVar('HTTP_EVE_CHARNAME')) . "',
                                '" . $eve->VarPrepForStore($password) . "',
                                '" . $eve->VarPrepForStore($eve->ServerGetVar('HTTP_EVE_CORPNAME')) . "',
                                '" . $eve->VarPrepForStore($row['allianceID']) . "',
                                '" . $eve->VarPrepForStore($email) . "',
								0,
								'" . $eve->VarPrepForStore($email_code) . "',
								0,
                                0,
                                '" . $time . "',
                                0,
                                0)";
            $result = mysql_query($sql) or die('Could not create user;' . mysql_error());
			$mail->sendcode($email, $eve->VarPrepForStore($eve->ServerGetVar('HTTP_EVE_CHARNAME')), $eve->VarPrepForStore($email_code), $eve->VarPrepForStore($eve->ServerGetVar('HTTP_EVE_CHARID')));
            $eve->SessionSetVar('statusmsg', 'User Created - Welcome '.$eve->ServerGetVar('HTTP_EVE_CHARNAME'));
            $eve->RedirectUrl('login.php');
        }

        $sql = "SELECT * FROM ".TBL_PREFIX."user WHERE eve_id = '" . $eve->VarPrepForStore($userinfo['UserID'])."'";
        $result = mysql_query($sql) or die('error while checking for existing user; ' . mysql_error());
        if (mysql_num_rows($result) != 0) {
            $eve->SessionSetVar('errormsg', 'You are already registered you muppet!');
            $eve->RedirectUrl('index.php');
        }

        $IS_IGB = true;
        $eveRender->Assign('userinfo', $userinfo);

    }
}

$eveRender->Assign('IS_IGB', $IS_IGB);

$eveRender->Display('register.tpl');


?>