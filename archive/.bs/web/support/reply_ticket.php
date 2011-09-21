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
define('HESK_PATH','');

/* Get all the required files and functions */
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'inc/common.inc.php');
require(HESK_PATH . 'inc/database.inc.php');

/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');

$message=hesk_input($_POST['message'],$hesklang['enter_message']);
$message=hesk_makeURL($message);
$message=nl2br($message);
$orig_name=hesk_input($_POST['orig_name'],"$hesklang[int_error]: No orig_name");
$replyto=hesk_isNumber($_POST['orig_id'],"$hesklang[int_error]: No or invalid orig_id");
$trackingID=hesk_input($_POST['orig_track'],"$hesklang[int_error]: No orig_track");
$trackingURL=$hesk_settings['hesk_url'].'/ticket.php?track='.$trackingID.'&Refresh='.rand(10000,99999);

/* Attachments */
if ($hesk_settings['attachments']['use'])
{
    require(HESK_PATH . 'inc/attachments.inc.php');
    $attachments = array();
    for ($i=1;$i<=$hesk_settings['attachments']['max_number'];$i++)
    {
        $att = hesk_uploadFile($i);
        if (!empty($att))
        {
            $attachments[$i] = $att;
        }
    }
}
$myattachments='';

/* Connect to database */
hesk_dbConnect();

if ($hesk_settings['attachments']['use'] && !empty($attachments))
{
    foreach ($attachments as $myatt)
    {
        $sql = "INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."attachments` (`ticket_id`,`saved_name`,`real_name`,`size`) VALUES (
        '".hesk_dbEscape($trackingID)."',
        '".hesk_dbEscape($myatt['saved_name'])."',
        '".hesk_dbEscape($myatt['real_name'])."',
        '".hesk_dbEscape($myatt['size'])."'
        )";
        $result = hesk_dbQuery($sql);
        $myattachments .= hesk_dbInsertID() . '#' . $myatt['real_name'] .',';
    }
}

/* Make sure the ticket is open */
$sql = "UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets` SET `status`='1',`lastreplier`='0',`lastchange`=NOW() WHERE `id`=".hesk_dbEscape($replyto)." LIMIT 1";
$result = hesk_dbQuery($sql);

/* Add reply */
$sql = "
INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."replies` (
`replyto`,`name`,`message`,`dt`,`attachments`
)
VALUES (
'".hesk_dbEscape($replyto)."',
'".hesk_dbEscape($orig_name)."',
'".hesk_dbEscape($message)."',
NOW(),
'".hesk_dbEscape($myattachments)."'
)
";
$result = hesk_dbQuery($sql);

$sql = "SELECT `name`,`subject`,`category` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets` WHERE `id`=".hesk_dbEscape($replyto)." LIMIT 1";
$result = hesk_dbQuery($sql);
$ticket = hesk_dbFetchAssoc($result);

$name=$ticket['name'];
$subject=$ticket['subject'];
$category=$ticket['category'];

/* Need to notify any admins? */
$admins=array();
$sql = "SELECT `email`,`isadmin`,`categories` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."users` WHERE `notify`='1'";
$result = hesk_dbQuery($sql);
while ($myuser=hesk_dbFetchAssoc($result))
{
    /* Is this an administrator? */
    if ($myuser['isadmin']) {$admins[]=$myuser['email']; continue;}
    /* Not admin, is he allowed this category? */
    $cat=substr($myuser['categories'], 0, -1);
    $myuser['categories']=explode(",",$cat);
    if (in_array($category,$myuser['categories']))
    {
        $admins[]=$myuser['email']; continue;
    }
}

if (count($admins)>0)
{
	/* Prepare ticket message for the e-mail */
	$message = hesk_msgToPlain($message,1);

	$trackingURL_admin = $hesk_settings['hesk_url'].'/admin/admin_ticket.php?track='.$trackingID;

	$msg = hesk_getEmailMessage('new_reply_by_customer');
	$msg = str_replace('%%NAME%%',$name,$msg);
	$msg = str_replace('%%SUBJECT%%',$subject,$msg);
	$msg = str_replace('%%TRACK_ID%%',$trackingID,$msg);
	$msg = str_replace('%%TRACK_URL%%',$trackingURL_admin,$msg);
	$msg = str_replace('%%SITE_TITLE%%',$hesk_settings['site_title'],$msg);
	$msg = str_replace('%%SITE_URL%%',$hesk_settings['site_url'],$msg);
	$msg = str_replace('%%MESSAGE%%',$message,$msg);

	/* Send e-mail to staff */
	$email=implode(',',$admins);
	$headers = "From: $hesk_settings[noreply_mail]\n";
	$headers.= "Reply-to: $hesk_settings[noreply_mail]\n";
	$headers.= "Return-Path: $hesk_settings[webmaster_mail]\n";
	$headers.= "Content-type: text/plain; charset=".$hesklang['ENCODING'];
	@mail($email,$hesklang['new_reply_ticket'],$msg,$headers);
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="3"><img src="https://s3.amazonaws.com/sg-support-static/headerleftsm.jpg" width="3" height="25" alt="" /></td>
<td class="headersm"><?php echo $hesklang['cid'].': '.$trackingID; ?></td>
<td width="3"><img src="https://s3.amazonaws.com/sg-support-static/headerrightsm.jpg" width="3" height="25" alt="" /></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td><span class="smaller"><a href="<?php echo $hesk_settings['site_url']; ?>" class="smaller"><?php echo $hesk_settings['site_title']; ?></a> &gt;
<a href="<?php echo $hesk_settings['hesk_url']; ?>" class="smaller"><?php echo $hesk_settings['hesk_title']; ?></a>
&gt; <?php echo $hesklang['reply_submitted']; ?></span></td>
</tr>
</table>

</td>
</tr>
<tr>
<td>

<p>&nbsp;</p>

<div align="center">
<table border="0" width="600" id="ok" cellspacing="0" cellpadding="3">
<tr>
<td align="left" class="ok_header">&nbsp;<img src="https://s3.amazonaws.com/sg-support-static/ok.gif" style="vertical-align:text-bottom" width="16" height="16" alt="" />&nbsp; <?php echo $hesklang['reply_submitted']; ?></td>
</tr>
<tr>
<td align="left" class="ok_body"><?php echo $hesklang['reply_submitted_success']; ?><br /><br />
<a href="<?php echo $trackingURL; ?>"><?php echo $hesklang['view_your_ticket']; ?></a></td>
</tr>
</table>
</div>

<p>&nbsp;</p>

<?php
require_once(HESK_PATH . 'inc/footer.inc.php');
?>
