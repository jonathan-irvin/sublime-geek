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
hesk_checkPermission('can_edit_tickets');

$trackingID = strtoupper(hesk_input($_REQUEST['track'],$hesklang['no_trackID']));
$is_reply = 0;

/* Get ticket info */
$sql = "SELECT * FROM `".$hesk_settings['db_pfix']."tickets` WHERE `trackid`='$trackingID' LIMIT 1";
$result = hesk_dbQuery($sql);
if (hesk_dbNumRows($result) != 1)
{
	hesk_error($hesklang['ticket_not_found']);
}
$ticket = hesk_dbFetchAssoc($result);

/* Is this user allowed to view tickets inside this category? */
hesk_okCategory($ticket['category']);

if (isset($_REQUEST['reply']))
{
	$id = hesk_isNumber($_REQUEST['reply'],$hesklang['id_not_valid']);
	$sql = "SELECT * FROM `".$hesk_settings['db_pfix']."replies` WHERE `id`=$id AND `replyto`='$ticket[id]' LIMIT 1";
	$result = hesk_dbQuery($sql);
	if (hesk_dbNumRows($result) != 1)
    {
    	hesk_error($hesklang['id_not_valid']);
    }
    $reply = hesk_dbFetchAssoc($result);
    $ticket['message'] = $reply['message'];
    $is_reply = 1;
}

if (isset($_POST['save']))
{
	$message = hesk_input($_POST['message'],$hesklang['enter_message']);
	$message = hesk_makeURL($message);
	$message = nl2br($message);
    if ($is_reply)
    {
    	$sql = "UPDATE `".$hesk_settings['db_pfix']."replies` SET `message`='$message' WHERE `id`=$id AND `replyto`='$ticket[id]' LIMIT 1";
    }
    else
    {
    	$sql = "UPDATE `".$hesk_settings['db_pfix']."tickets` SET `message`='$message' WHERE `id`='$ticket[id]' LIMIT 1";
    }
    hesk_dbQuery($sql);
	$_SESSION['HESK_NOTICE']  = $hesklang['edt1'];
	$_SESSION['HESK_MESSAGE'] = $hesklang['edt2'];
	header('Location: admin_ticket.php?track='.$trackingID.'&Refresh='.mt_rand(10000,99999));
}

$from = array('/\<a href="mailto\:([^"]*)"\>([^\<]*)\<\/a\>/i', '/\<a href="([^"]*)" target="_blank"\>([^\<]*)\<\/a\>/i');
$to   = array("$1", "$1");
$ticket['message'] = preg_replace($from,$to,$ticket['message']);
$ticket['message'] = preg_replace('/<br \/>\s*/',"\n",$ticket['message']);
$ticket['message'] = trim(stripslashes($ticket['message']));

/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');

/* Print admin navigation */
require_once(HESK_PATH . 'inc/show_admin_nav.inc.php');
?>

</td>
</tr>
<tr>
<td>

<p><span class="smaller"><a href="admin_ticket.php?track=<?php echo $trackingID; ?>&amp;Refresh=<?php echo mt_rand(10000,99999); ?>" class="smaller"><?php echo $hesklang['ticket'].' '.$trackingID; ?></a> &gt;
<?php echo $hesklang['edtt']; ?></span></p>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornerstop"></td>
	<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
</tr>
<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

	<h3 align="center"><?php echo $hesklang['edtt']; ?></h3>

	<form method="post" action="edit_post.php" name="form1">

	<p style="text-align:center">&nbsp;<br /><?php echo $hesklang['message']; ?>:<br />
	<textarea name="message" rows="12" cols="60"><?php echo $ticket['message']; ?></textarea></p>

	<p style="text-align:center">
	<input type="hidden" name="save" value="1" /><input type="hidden" name="track" value="<?php echo $trackingID; ?>" />
	<?php
	if ($is_reply)
	{
	?>
	<input type="hidden" name="reply" value="<?php echo $id; ?>" />
	<?php
	}
	?>
	<input type="submit" value="<?php echo $hesklang['save_changes']; ?>" class="orangebutton" onmouseover="hesk_btn(this,'orangebuttonover');" onmouseout="hesk_btn(this,'orangebutton');" /></p>

	</form>

	</td>
	<td class="roundcornersright">&nbsp;</td>
</tr>
<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
</tr>
</table>

<p style="text-align:center"><a href="javascript:history.go(-1)"><?php echo $hesklang['back']; ?></a></p>

<p>&nbsp;</p>

<?php
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();
?>
