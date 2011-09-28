<?php
/*******************************************************************************
*  Title: Help Desk Software HESK
*  Version: 2.1 from 7th August 2009
*  Author: Klemen Stirn
*  Website: http://www.hesk.com
********************************************************************************
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2005-2009 Klemen Stirn. All Rights Reserved.
*  HESK is a trademark of Klemen Stirn.

*  The HESK may be used and modified free of charge by anyone
*  AS LONG AS COPYRIGHT NOTICES AND ALL THE COMMENTS REMAIN INTACT.
*  By using this code you agree to indemnify Klemen Stirn from any
*  liability that might arise from it's use.

*  Selling the code for this program, in part or full, without prior
*  written consent is expressly forbidden.

*  Using this code, in part or full, to create derivate work,
*  new scripts or products is expressly forbidden. Obtain permission
*  before redistributing this software over the Internet or in
*  any other medium. In all cases copyright and header must remain intact.
*  This Copyright is in full effect in any country that has International
*  Trade Agreements with the United States of America or
*  with the European Union.

*  Removing any of the copyright notices without purchasing a license
*  is expressly forbidden. To remove HESK copyright notice you must purchase
*  a license for this script. For more information on how to obtain
*  a license please visit the page below:
*  https://www.hesk.com/buy.php
*******************************************************************************/

define('IN_SCRIPT',1);
define('HESK_PATH','../');

/* Get all the required files and functions */
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'inc/common.inc.php');
require(HESK_PATH . 'inc/database.inc.php');

hesk_session_start();
hesk_dbConnect();
hesk_isLoggedIn();

/* Check permissions for this feature */
hesk_checkPermission('can_view_tickets');
hesk_checkPermission('can_reply_tickets');

$trackingID = strtoupper(hesk_input($_POST['track'],"$hesklang[int_error]: $hesklang[no_trackID]."));
$priority   = intval($_POST['priority']);
if ($priority < 1 || $priority > 3)
{
	$_SESSION['HESK_ERROR']   = true;
	$_SESSION['HESK_MESSAGE'] = $hesklang['inpr'];
	header('Location: admin_ticket.php?track='.$trackingID.'&Refresh='.mt_rand(10000,99999));
	exit();
}

$sql = "UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets` SET `priority`='".hesk_dbEscape($priority)."' WHERE `trackid`='".hesk_dbEscape($trackingID)."' LIMIT 1";
$result = hesk_dbQuery($sql);
if (hesk_dbAffectedRows() != 1)
{
	hesk_error("$hesklang[int_error]: $hesklang[trackID_not_found].");
}

$options = array(
	1 => '<font class="important">'.$hesklang['high'].'</font>',
	2 => '<font class="medium">'.$hesklang['medium'].'</font>',
	3 => $hesklang['low']
);

$_SESSION['HESK_NOTICE']  = $hesklang['chpri'];
$_SESSION['HESK_MESSAGE'] = sprintf($hesklang['chpri2'],$options[$priority]);
header('Location: admin_ticket.php?track='.$trackingID.'&Refresh='.mt_rand(10000,99999));
exit();
?>