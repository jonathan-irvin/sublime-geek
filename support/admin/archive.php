<?php
/*******************************************************************************
*  Title: Helpdesk software Hesk
*  Version: 2.0 from 24th January 2009
*  Author: Klemen Stirn
*  Website: http://www.phpjunkyard.com
********************************************************************************
*  COPYRIGHT NOTICE
*  Copyright 2005-2009 Klemen Stirn. All Rights Reserved.

*  The Hesk may be used and modified free of charge by anyone
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
*  is illegal! To remove PHPJunkyard copyright notice you must purchase
*  a license for this script. For more information on how to obtain
*  a license please visit the site below:
*  http://www.phpjunkyard.com/copyright-removal.php
*******************************************************************************/

define('IN_SCRIPT',1);
define('HESK_PATH','../');

/* Get all the required files and functions */
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'language/'.$hesk_settings['language'].'.inc.php');
require(HESK_PATH . 'inc/common.inc.php');
require(HESK_PATH . 'inc/database.inc.php');

hesk_session_start();
hesk_isLoggedIn();
hesk_dbConnect();

/* Check permissions for this feature */
hesk_checkPermission('can_view_tickets');
hesk_checkPermission('can_reply_tickets');

$trackingID = strtoupper(hesk_input($_GET['track'],"$hesklang[int_error]: $hesklang[no_trackID]."));
if ($_GET['archived'])
{
	$status=1;
    $_SESSION['HESK_NOTICE']  = $hesklang['added_archive'];
    $_SESSION['HESK_MESSAGE'] = $hesklang['added2archive'];
}
else
{
	$status=0;
    $_SESSION['HESK_NOTICE']  = $hesklang['removed_archive'];
    $_SESSION['HESK_MESSAGE'] = $hesklang['removedfromarchive'];
}

$sql = "UPDATE `".$hesk_settings['db_pfix']."tickets` SET `archive`='$status' WHERE `trackid`='$trackingID' LIMIT 1";
hesk_dbQuery($sql);

header('Location: admin_ticket.php?track='.$trackingID.'&Refresh='.rand(10000,99999));
exit();
?>
