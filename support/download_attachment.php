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
define('HESK_PATH','');

/* Get all the required files and functions */
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'language/'.$hesk_settings['language'].'.inc.php');
require(HESK_PATH . 'inc/common.inc.php');
require(HESK_PATH . 'inc/database.inc.php');

$att_id=hesk_isNumber($_GET['att_id'],$hesklang['id_not_valid']);
$tic_id=hesk_input($_GET['track'],$hesklang['no_trackID']);

/* Connect to database */
hesk_dbConnect();

/* Get attachment info */
$sql = "SELECT * FROM `".$hesk_settings['db_pfix']."attachments` WHERE `att_id`=$att_id LIMIT 1";
$result = hesk_dbQuery($sql);
if (hesk_dbNumRows($result) != 1)
{
	hesk_error($hesklang['id_not_valid'].' (att_id)');
}
$file = hesk_dbFetchAssoc($result);

/* Is ticket ID valid for this attachment? */
if ($file['ticket_id'] != $tic_id)
{
    hesk_error($hesklang['trackID_not_found']);
}

/* Send the file as an attachment to prevent malicious code from executing */
header ("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Length: ' . $file['size']);
header('Content-Disposition: attachment; filename=' . $file['real_name']);
readfile($hesk_settings['server_path'].'/attachments/'.$file['saved_name']);
?>
