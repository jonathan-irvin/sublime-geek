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

$hesk_error_buffer = array();

hesk_session_start();

if ($hesk_settings['question_use'])
{
        $question = hesk_input($_POST['question']);
        if (empty($question))
        {
        	$hesk_error_buffer[]=$hesklang['q_miss'];
        }
        elseif (strtolower($question) != strtolower($hesk_settings['question_ans']))
        {
        	$hesk_error_buffer[]=$hesklang['q_wrng'];
        }
        else
        {
        	$_SESSION['c_question'] = $question;
        }
}

if ($hesk_settings['secimg_use'])
{
        $mysecnum = hesk_isNumber($_POST['mysecnum']);
        if (empty($mysecnum))
        {
                $hesk_error_buffer[]=$hesklang['sec_miss'];
        }
        else
        {
            require(HESK_PATH . 'secimg.inc.php');
            $sc = new PJ_SecurityImage($hesk_settings['secimg_sum']);
            if (!($sc->checkCode($mysecnum,$_SESSION['checksum'])))
            {
                    $hesk_error_buffer[]=$hesklang['sec_wrng'];
            }
        }
}

$name	  = hesk_input($_POST['name']) or $hesk_error_buffer[]=$hesklang['enter_your_name'];
$email	  = hesk_validateEmail($_POST['email'],'ERR',0) or $hesk_error_buffer[]=$hesklang['enter_valid_email'];
$category = hesk_input($_POST['category']) or $hesk_error_buffer[]=$hesklang['sel_app_cat'];
$priority = hesk_input($_POST['priority']) or $hesk_error_buffer[]=$hesklang['sel_app_priority'];
$subject  = hesk_input($_POST['subject']) or $hesk_error_buffer[]=$hesklang['enter_ticket_subject'];
$message  = hesk_input($_POST['message']) or $hesk_error_buffer[]=$hesklang['enter_message'];


/* Custom fields */
foreach ($hesk_settings['custom_fields'] as $k=>$v)
{
	if ($v['use'])
    {
		if ($v['req'])
        {
        	$$k=hesk_makeURL(nl2br(hesk_input($_POST[$k]))) or $hesk_error_buffer[]=$hesklang['fill_all'].': '.$v['name'];
        }
		else
        {
        	$$k=hesk_makeURL(nl2br(hesk_input($_POST[$k])));
        }
		$_SESSION["c_$k"]=$_POST[$k];
	}
    else
    {
    	$$k = '';
    }
}


/* If we have any errors lets store info in session to avoid re-typing everything */
if (count($hesk_error_buffer)!=0)
{
    $_SESSION['c_name']     = $_POST['name'];
    $_SESSION['c_email']    = $_POST['email'];
    $_SESSION['c_category'] = $_POST['category'];
    $_SESSION['c_priority'] = $_POST['priority'];
    $_SESSION['c_subject']  = $_POST['subject'];
    $_SESSION['c_message']  = $_POST['message'];

    $_SESSION['HESK_MESSAGE'] = '';
    foreach ($hesk_error_buffer as $error)
    {
        $_SESSION['HESK_MESSAGE'] .= "<li>$error</li>\n";
    }

    $_SESSION['HESK_ERROR'] = true;
    Header('Location: index.php?a=add');
    exit();
}

$message=hesk_makeURL($message);
$message=nl2br($message);

/* Generate tracking ID */
$useChars = 'AEUYBDGHJLMNPQRSTVWXZ123456789';
$trackingID = $useChars{mt_rand(0,29)};
for($i=1;$i<10;$i++)
{
    $trackingID .= $useChars{mt_rand(0,29)};
}
$trackingURL = $hesk_settings['hesk_url'].'/ticket.php?track='.$trackingID;

/* Attachments */
if ($hesk_settings['attachments']['use'])
{
    require_once(HESK_PATH . 'inc/attachments.inc.php');
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

/* Add to database */
hesk_dbConnect();

if ($hesk_settings['attachments']['use'] && !empty($attachments))
{
    foreach ($attachments as $myatt)
    {
        $sql = "INSERT INTO `".$hesk_settings['db_pfix']."attachments` (`ticket_id`,`saved_name`,`real_name`,`size`) VALUES ('$trackingID', '$myatt[saved_name]', '$myatt[real_name]', '$myatt[size]')";
        $result = hesk_dbQuery($sql);
        $myattachments .= hesk_dbInsertID() . '#' . $myatt['real_name'] .',';
    }
}

$sql = "
INSERT INTO `".$hesk_settings['db_pfix']."tickets` (
`trackid`,`name`,`email`,`category`,`priority`,`subject`,`message`,`dt`,`lastchange`,`ip`,`status`,`attachments`,`custom1`,`custom2`,`custom3`,`custom4`,`custom5`,`custom6`,`custom7`,`custom8`,`custom9`,`custom10`
)
VALUES (
'$trackingID','$name','$email','$category','$priority','$subject','$message',NOW(),NOW(),'$_SERVER[REMOTE_ADDR]','0','$myattachments','$custom1','$custom2','$custom3','$custom4','$custom5','$custom6','$custom7','$custom8','$custom9','$custom10'
)
";

$result = hesk_dbQuery($sql);

/* Get e-mail message for customer */
$message=file_get_contents(HESK_PATH.'emails/new_ticket.txt');
$message=str_replace('%%NAME%%',$name,$message);
$message=str_replace('%%SUBJECT%%',$subject,$message);
$message=str_replace('%%TRACK_ID%%',$trackingID,$message);
$message=str_replace('%%TRACK_URL%%',$trackingURL,$message);
$message=str_replace('%%SITE_TITLE%%',$hesk_settings['site_title'] ,$message);
$message=str_replace('%%SITE_URL%%',$hesk_settings['site_url'] ,$message);

/* Send e-mail */
$headers="From: Sublime Geek Support <$hesk_settings[noreply_mail]>\n";
$headers.="Reply-to: Sublime Geek Support <$hesk_settings[noreply_mail]>\n";
$headers.="Return-Path: Sublime Geek Support <$hesk_settings[webmaster_mail]>\n";
@mail($email,$hesklang['ticket_received'],$message,$headers);

/* Need to notify any admins? */
$admins=array();
$sql = "SELECT `email`,`isadmin`,`categories` FROM `".$hesk_settings['db_pfix']."users` WHERE `notify`='1'";
$result = hesk_dbQuery($sql);
while ($myuser=hesk_dbFetchAssoc($result))
{
    /* Is this an administrator? */
    if ($myuser['isadmin']) {$admins[]=$myuser['email']; continue;}
    /* Not admin, is he allowed this category? */
    $cat=substr($myuser['categories'], 0, -1);
    $myuser['categories']=explode(',',$cat);
    if (in_array($category,$myuser['categories']))
    {
        $admins[]=$myuser['email']; continue;
    }
}
if (count($admins)>0)
{
$trackingURL_admin=$hesk_settings['hesk_url'].'/admin/admin_ticket.php?track='.$trackingID;

$message=file_get_contents(HESK_PATH.'emails/new_ticket_staff.txt');
$message=str_replace('%%NAME%%',$name,$message);
$message=str_replace('%%SUBJECT%%',$subject,$message);
$message=str_replace('%%TRACK_ID%%',$trackingID,$message);
$message=str_replace('%%TRACK_URL%%',$trackingURL_admin,$message);
$message=str_replace('%%SITE_TITLE%%',$hesk_settings['site_title'] ,$message);
$message=str_replace('%%SITE_URL%%',$hesk_settings['site_url'] ,$message);

/* Send e-mail to staff */
$email=implode(',',$admins);
$headers="From: $hesk_settings[noreply_mail]\n";
$headers.="Reply-to: $hesk_settings[noreply_mail]\n";
$headers.="Return-Path: $hesk_settings[webmaster_mail]\n";
@mail($email,$hesklang['new_ticket_submitted'],$message,$headers);
} // End if

/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="3"><img src="img/headerleftsm.jpg" width="3" height="25" alt="" /></td>
<td class="headersm"><?php echo $hesklang['ticket_submitted']; ?></td>
<td width="3"><img src="img/headerrightsm.jpg" width="3" height="25" alt="" /></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td><span class="smaller"><a href="<?php echo $hesk_settings['site_url']; ?>" class="smaller"><?php echo $hesk_settings['site_title']; ?></a> &gt;
<a href="<?php echo $hesk_settings['hesk_url']; ?>" class="smaller"><?php echo $hesk_settings['hesk_title']; ?></a>
&gt; <?php echo $hesklang['ticket_submitted']; ?></span></td>
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
<td align="left" class="ok_header">&nbsp;<img src="img/ok.gif" style="vertical-align:text-bottom" width="16" height="16" alt="" />&nbsp; <?php echo $hesklang['reply_submitted']; ?></td>
</tr>
<tr>
<td align="left" class="ok_body"><?php echo $hesklang['ticket_submitted_success'].': <b>'.$trackingID.'</b>';?><br /><br />
<a href="<?php echo $trackingURL; ?>"><?php echo $hesklang['view_your_ticket']; ?></a></td>
</tr>
</table>
</div>

<p>&nbsp;</p>

<?php
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();
?>
