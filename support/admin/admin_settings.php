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

hesk_session_start();
hesk_isLoggedIn();

/* Check permissions for this feature */
hesk_checkPermission('can_man_settings');

$enable_save_settings   = 0;
$enable_use_attachments = 0;

/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');

/* Print main manage users page */
require_once(HESK_PATH . 'inc/show_admin_nav.inc.php');
?>

</td>
</tr>
<tr>
<td>

	<?php
	    if(isset($_SESSION['HESK_NOTICE']))
        {
	?>
	        <div align="center">
	        <table border="0" width="600" id="ok" cellspacing="0" cellpadding="3">
		        <tr>
		        	<td align="left" class="ok_header">&nbsp;<img src="../img/ok.gif" style="vertical-align:text-bottom" width="16" height="16" alt="" />&nbsp; <?php echo $_SESSION['HESK_NOTICE']; ?></td>
		        </tr>
		        <tr>
		        	<td align="left" class="ok_body"><?php echo $_SESSION['HESK_MESSAGE']; ?></td>
		        </tr>
	        </table>
	        </div>
            <br />
	<?php
	        unset($_SESSION['HESK_NOTICE']);
	        unset($_SESSION['HESK_MESSAGE']);
	    }
	?>

<h3 align="center"><?php echo $hesklang['settings']; ?></h3>

<p><?php echo $hesklang['settings_intro'] . ' <b>' . $hesklang['all_req']; ?></b></p>

<script language="javascript" type="text/javascript"><!--
function hesk_checkFields() {
d=document.form1;
if (d.s_site_title.value=='') {alert('<?php echo $hesklang['err_sname']; ?>'); return false;}
if (d.s_site_url.value=='') {alert('<?php echo $hesklang['err_surl']; ?>'); return false;}

if (d.s_support_mail.value=='' || d.s_support_mail.value.indexOf(".") == -1 || d.s_support_mail.value.indexOf("@") == -1)
{alert('<?php echo $hesklang['err_supmail']; ?>'); return false;}
if (d.s_webmaster_mail.value=='' || d.s_webmaster_mail.value.indexOf(".") == -1 || d.s_webmaster_mail.value.indexOf("@") == -1)
{alert('<?php echo $hesklang['err_wmmail']; ?>'); return false;}
if (d.s_noreply_mail.value=='' || d.s_noreply_mail.value.indexOf(".") == -1 || d.s_noreply_mail.value.indexOf("@") == -1)
{alert('<?php echo $hesklang['err_nomail']; ?>'); return false;}

if (d.s_hesk_title.value=='') {alert('<?php echo $hesklang['err_htitle']; ?>'); return false;}
if (d.s_hesk_url.value=='') {alert('<?php echo $hesklang['err_hurl']; ?>'); return false;}
if (d.s_server_path.value=='') {alert('<?php echo $hesklang['err_spath']; ?>'); return false;}
if (d.s_max_listings.value=='') {alert('<?php echo $hesklang['err_max']; ?>'); return false;}
if (d.s_print_font_size.value=='') {alert('<?php echo $hesklang['err_psize']; ?>'); return false;}

if (d.s_db_host.value=='') {alert('<?php echo $hesklang['err_dbhost']; ?>'); return false;}
if (d.s_db_name.value=='') {alert('<?php echo $hesklang['err_dbname']; ?>'); return false;}
if (d.s_db_user.value=='') {alert('<?php echo $hesklang['err_dbuser']; ?>'); return false;}
if (d.s_db_pass.value=='') {alert('<?php echo $hesklang['err_dbpass']; ?>'); return false;}

if (d.s_custom1_use.checked && d.s_custom1_name.value == '') {alert('<?php echo $hesklang['err_custname']; ?>'); return false;}
if (d.s_custom2_use.checked && d.s_custom2_name.value == '') {alert('<?php echo $hesklang['err_custname']; ?>'); return false;}
if (d.s_custom3_use.checked && d.s_custom3_name.value == '') {alert('<?php echo $hesklang['err_custname']; ?>'); return false;}
if (d.s_custom4_use.checked && d.s_custom4_name.value == '') {alert('<?php echo $hesklang['err_custname']; ?>'); return false;}
if (d.s_custom5_use.checked && d.s_custom5_name.value == '') {alert('<?php echo $hesklang['err_custname']; ?>'); return false;}
if (d.s_custom6_use.checked && d.s_custom6_name.value == '') {alert('<?php echo $hesklang['err_custname']; ?>'); return false;}
if (d.s_custom7_use.checked && d.s_custom7_name.value == '') {alert('<?php echo $hesklang['err_custname']; ?>'); return false;}
if (d.s_custom8_use.checked && d.s_custom8_name.value == '') {alert('<?php echo $hesklang['err_custname']; ?>'); return false;}
if (d.s_custom9_use.checked && d.s_custom9_name.value == '') {alert('<?php echo $hesklang['err_custname']; ?>'); return false;}
if (d.s_custom10_use.checked && d.s_custom10_name.value == '') {alert('<?php echo $hesklang['err_custname']; ?>'); return false;}

return true;
}

function hesk_customOptions(cID, fID, fTYPE, maxlenID, oldTYPE)
{
	var t = document.getElementById(fTYPE).value;
    if (t == oldTYPE)
    {
		var d = document.getElementById(fID).value;
	    var m = document.getElementById(maxlenID).value;
    }
    else
    {
    	var d = '';
        var m = 255;
    }
    var myURL = "options.php?i=" + cID + "&q=" + escape(d) + "&t=" + t + "&m=" + m;
    window.open(myURL,"Hesk_window","height=400,width=500,menubar=0,location=0,toolbar=0,status=0,resizable=1,scrollbars=1");
    return false;
}

function hesk_toggleLayer(nr,setto) {
        if (document.all)
                document.all[nr].style.display = setto;
        else if (document.getElementById)
                document.getElementById(nr).style.display = setto;
}

//-->
</script>

<form method="post" action="admin_settings_save.php" name="form1" onsubmit="return hesk_checkFields()">

<!-- Checkign status of files and folders -->
<span class="section">&raquo; <?php echo $hesklang['check_status']; ?></span>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

	<table border="0">
	<tr>
	<td width="200" valign="top"><?php echo $hesklang['v']; ?>:</td>
	<td><b><?php echo $hesk_settings['hesk_version']; ?></b> (<a href="http://www.phpjunkyard.com/check4updates.php?s=Hesk&amp;v=<?php echo $hesk_settings['hesk_version']; ?>" target="_blank"><?php echo $hesklang['check4updates']; ?></a>)</td>
	</tr>
	<tr>
	<td width="200" valign="top">/hesk_settings.inc.php</td>
	<td>
	<?php
	if (is_writable(HESK_PATH . 'hesk_settings.inc.php')) {
	    $enable_save_settings=1;
	    echo '<font class="success">'.$hesklang['exists'].'</font>, <font class="success">'.$hesklang['writable'].'</font>';
	} else {
	    echo '<font class="success">'.$hesklang['exists'].'</font>, <font class="error">'.$hesklang['not_writable'].'</font><br />'.$hesklang['e_settings'];
	}
	?>
	</td>
	</tr>
	<tr>
	<td width="200">/attachments</td>
	<td>
	<?php
	if (!file_exists(HESK_PATH . 'attachments'))
	{
	    @mkdir(HESK_PATH . 'attachments', 0777);
	}

	if (is_dir(HESK_PATH . 'attachments'))
	{
	    echo '<font class="success">'.$hesklang['exists'].'</font>, ';
	    if (is_writable(HESK_PATH . 'attachments'))
	    {
	        $enable_use_attachments=1;
	        echo '<font class="success">'.$hesklang['writable'].'</font>';
	    }
	    else
	    {
	        echo '<font class="error">'.$hesklang['not_writable'].'</font><br />'.$hesklang['e_attdir'];
	    }
	}
	else
	{
	    echo '<font class="error">'.$hesklang['no_exists'].'</font>, <font class="error">'.$hesklang['not_writable'].'</font><br />'.$hesklang['e_attdir'];
	}
	?>
	</td>
	</tr>
	</table>

	</td>
	<td class="roundcornersright">&nbsp;</td>
	</tr>
	<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
	</tr>
</table>

<br />

<span class="section">&raquo; <?php echo $hesklang['gs']; ?></span>

<!-- Website info -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

	<table border="0">
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['wbst_title']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#1','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_site_title" size="40" maxlength="255" value="<?php echo $hesk_settings['site_title']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['wbst_url']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#2','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_site_url" size="40" maxlength="255" value="<?php echo $hesk_settings['site_url']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['email_sup']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#3','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_support_mail" size="40" maxlength="255" value="<?php echo $hesk_settings['support_mail']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['email_wm']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#4','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_webmaster_mail" size="40" maxlength="255" value="<?php echo $hesk_settings['webmaster_mail']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['email_noreply']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#5','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_noreply_mail" size="40" maxlength="255" value="<?php echo $hesk_settings['noreply_mail']; ?>" /></td>
	</tr>
	</table>

	</td>
	<td class="roundcornersright">&nbsp;</td>
	</tr>
	<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
	</tr>
</table>

<br />

<!-- Helpdesk settings -->
<span class="section">&raquo; <?php echo $hesklang['hd']; ?></span>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

	<table border="0">
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['hesk_title']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#6','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_hesk_title" size="40" maxlength="255" value="<?php echo $hesk_settings['hesk_title']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['hesk_url']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#7','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_hesk_url" size="40" maxlength="255" value="<?php echo $hesk_settings['hesk_url']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['hesk_path']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#8','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_server_path" size="40" maxlength="255" value="<?php
	if ($hesk_settings['server_path'] == '/home/mysite/public_html/hesk') {
	    echo getcwd();
	} else {
	    echo $hesk_settings['server_path'];
	}
	?>" />
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['hesk_lang']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#9','400','500')"><b>?</b></a>]</td>
	<td>
	<select name="s_language">
	<?php
	$dir = HESK_PATH . '/language';
	$path = opendir($dir);
	$files = array();

	while (false !== ($file = readdir($path)))
	{
	    if(is_file($dir.'/'.$file) && substr($file, -8) == '.inc.php')
	    {
	        $files[]=$file;
	    }
	}

	if(!empty($files))
	{
	    natcasesort($files);
	    foreach ($files as $file)
	    {
	        $file=substr($file, 0, -8);
	        if ($file == $hesk_settings['language'])
	        {
	            echo '<option value="'.$file.'" selected="selected">'.ucfirst($file).'</option>';
	        }
	        else
	        {
	            echo '<option value="'.$file.'">'.ucfirst($file).'</option>';
	        }
	    }
	}

	closedir($path);
	?>
	</select>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['max_listings']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#10','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_max_listings" size="5" maxlength="3" value="<?php echo $hesk_settings['max_listings']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['print_size']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#11','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_print_font_size" size="5" maxlength="3" value="<?php echo $hesk_settings['print_font_size']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['debug_mode']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#12','400','500')"><b>?</b></a>]</td>
	<td>
	<?php
	    $on = $hesk_settings['debug_mode'] ? 'checked="checked"' : '';
	    $off = $hesk_settings['debug_mode'] ? '' : 'checked="checked"';
	    echo '
	    <label><input type="radio" name="s_debug_mode" value="0" '.$off.' /> '.$hesklang['off'].'</label> |
	    <label><input type="radio" name="s_debug_mode" value="1" '.$on.' /> '.$hesklang['on'].'</label>';
	?>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['use_secimg']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#13','400','500')"><b>?</b></a>]</td>
	<td>
	<?php
	if(function_exists('imagecreate'))
	{
	    $on = $hesk_settings['secimg_use'] ? 'checked="checked"' : '';
	    $off = $hesk_settings['secimg_use'] ? '' : 'checked="checked"';
	    echo '
	    <label><input type="radio" name="s_secimg_use" value="0" '.$off.' /> '.$hesklang['off'].'</label> |
	    <label><input type="radio" name="s_secimg_use" value="1" '.$on.' /> '.$hesklang['on'].'</label>';
	}
	else
	{
	    echo $hesklang['secimg_no'];
	}
	?>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200" valign="top"><?php echo $hesklang['use_q']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#42','400','500')"><b>?</b></a>]</td>
	<td>
	<?php

        $on  = '';
        $off = '';
        $div = 'block';

    	if ($hesk_settings['question_use'])
        {
        	$on = 'checked="checked"';
        }
        else
        {
        	$off = 'checked="checked"';
            $div = 'none';
        }
	    echo '
	    <label><input type="radio" name="s_question_use" value="0" '.$off.' onclick="javascript:hesk_toggleLayer(\'question\',\'none\')" /> '.$hesklang['off'].'</label> |
	    <label><input type="radio" name="s_question_use" value="1" '.$on.' onclick="javascript:hesk_toggleLayer(\'question\',\'block\')" /> '.$hesklang['on'].'</label>';
	?>
    	<div id="question" style="display: <?php echo $div; ?>;">

        <a href="Javascript:void(0)" onclick="Javascript:hesk_rate('generate_spam_question.php','question')"><?php echo $hesklang['genq']; ?></a><br />

        <?php echo $hesklang['q_q']; ?>:<br />
        <textarea name="s_question_ask" rows="3" cols="40"><?php echo htmlentities($hesk_settings['question_ask']); ?></textarea><br />

        <?php echo $hesklang['q_a']; ?>:<br />
        <input type="text" name="s_question_ans" value="<?php echo $hesk_settings['question_ans']; ?>" size="10" />

        </div>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['lu']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#14','400','500')"><b>?</b></a>]</td>
	<td>
	<?php
	    $on = $hesk_settings['list_users'] ? 'checked="checked"' : '';
	    $off = $hesk_settings['list_users'] ? '' : 'checked="checked"';
	    echo '
	    <label><input type="radio" name="s_list_users" value="0" '.$off.' /> '.$hesklang['off'].'</label> |
	    <label><input type="radio" name="s_list_users" value="1" '.$on.' /> '.$hesklang['on'].'</label>';
	?>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['aclose']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#15','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_autoclose" size="5" maxlength="3" value="<?php echo $hesk_settings['autoclose']; ?>" />
	<?php echo $hesklang['aclose2']; ?></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['s_ucrt']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#16','400','500')"><b>?</b></a>]</td>
	<td>
	<?php
	    $on = $hesk_settings['custopen'] ? 'checked="checked"' : '';
	    $off = $hesk_settings['custopen'] ? '' : 'checked="checked"';
	    echo '
	    <label><input type="radio" name="s_custopen" value="0" '.$off.' /> '.$hesklang['off'].'</label> |
	    <label><input type="radio" name="s_custopen" value="1" '.$on.' /> '.$hesklang['on'].'</label>';
	?>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['urate']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#17','400','500')"><b>?</b></a>]</td>
	<td>
	<?php
	    $on = $hesk_settings['rating'] ? 'checked="checked"' : '';
	    $off = $hesk_settings['rating'] ? '' : 'checked="checked"';
	    echo '
	    <label><input type="radio" name="s_rating" value="0" '.$off.' /> '.$hesklang['off'].'</label> |
	    <label><input type="radio" name="s_rating" value="1" '.$on.' /> '.$hesklang['on'].'</label>';
	?>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200" valign="top"><?php echo $hesklang['server_time']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#18','400','500')"><b>?</b></a>]</td>
	<td><?php echo $hesklang['csrt'] .' ' . date('H:i'); ?><br />
	<input type="text" name="s_diff_hours" size="5" maxlength="3" value="<?php echo $hesk_settings['diff_hours']; ?>" />
	<?php echo $hesklang['t_h']; ?> <br />
	<input type="text" name="s_diff_minutes" size="5" maxlength="3" value="<?php echo $hesk_settings['diff_minutes']; ?>" />
	<?php echo $hesklang['t_m']; ?></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['day']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#19','400','500')"><b>?</b></a>]</td>
	<td>
	<?php
	    $on = $hesk_settings['daylight'] ? 'checked="checked"' : '';
	    $off = $hesk_settings['daylight'] ? '' : 'checked="checked"';
	    echo '
	    <label><input type="radio" name="s_daylight" value="0" '.$off.' /> '.$hesklang['off'].'</label> |
	    <label><input type="radio" name="s_daylight" value="1" '.$on.' /> '.$hesklang['on'].'</label>';
	?>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['tfor']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#20','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_timeformat" size="40" maxlength="255" value="<?php echo $hesk_settings['timeformat']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['al']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#21','400','500')"><b>?</b></a>]</td>
	<td><label><input type="checkbox" name="s_alink" value="1" <?php if ($hesk_settings['alink']) {echo 'checked="checked"';} ?>/> <?php echo $hesklang['dap']; ?></label></td>
	</tr>
	</table>

	</td>
	<td class="roundcornersright">&nbsp;</td>
	</tr>
	<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
	</tr>
</table>

<br />

<!-- Knowledgebase settings -->
<span class="section">&raquo; <?php echo $hesklang['kb_text']; ?></span>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

	<table border="0">
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['s_ekb']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#22','400','500')"><b>?</b></a>]</td>
	<td>
	<?php
	    $on = $hesk_settings['kb_enable'] ? 'checked="checked"' : '';
	    $off = $hesk_settings['kb_enable'] ? '' : 'checked="checked"';
	    echo '
	    <label><input type="radio" name="s_kb_enable" value="0" '.$off.' /> '.$hesklang['off'].'</label> |
	    <label><input type="radio" name="s_kb_enable" value="1" '.$on.' /> '.$hesklang['on'].'</label>';
	?>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['s_suggest']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#23','400','500')"><b>?</b></a>]</td>
	<td>
	<?php
	    $on = $hesk_settings['kb_recommendanswers'] ? 'checked="checked"' : '';
	    $off = $hesk_settings['kb_recommendanswers'] ? '' : 'checked="checked"';
	    echo '
	    <label><input type="radio" name="s_kb_recommendanswers" value="0" '.$off.' /> '.$hesklang['no'].'</label> |
	    <label><input type="radio" name="s_kb_recommendanswers" value="1" '.$on.' /> '.$hesklang['yes'].'</label>';
	?>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['s_kbr']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#24','400','500')"><b>?</b></a>]</td>
	<td>
	<?php
	    $on = $hesk_settings['kb_rating'] ? 'checked="checked"' : '';
	    $off = $hesk_settings['kb_rating'] ? '' : 'checked="checked"';
	    echo '
	    <label><input type="radio" name="s_kb_rating" value="0" '.$off.' /> '.$hesklang['no'].'</label> |
	    <label><input type="radio" name="s_kb_rating" value="1" '.$on.' /> '.$hesklang['yes'].'</label>';
	?>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['s_kbs']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#25','400','500')"><b>?</b></a>]</td>
	<td>
	<?php
	    $on = $hesk_settings['kb_search'] ? 'checked="checked"' : '';
	    $off = $hesk_settings['kb_search'] ? '' : 'checked="checked"';
	    echo '
	    <label><input type="radio" name="s_kb_search" value="0" '.$off.' /> '.$hesklang['no'].'</label> |
	    <label><input type="radio" name="s_kb_search" value="1" '.$on.' /> '.$hesklang['yes'].'</label>';
	?>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['s_maxsr']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#26','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_kb_search_limit" size="5" maxlength="3" value="<?php echo $hesk_settings['kb_search_limit']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['s_ptxt']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#27','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_kb_substrart" size="5" maxlength="5" value="<?php echo $hesk_settings['kb_substrart']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['s_scol']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#28','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_kb_cols" size="5" maxlength="2" value="<?php echo $hesk_settings['kb_cols']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['s_psubart']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#29','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_kb_numshow" size="5" maxlength="2" value="<?php echo $hesk_settings['kb_numshow']; ?>" /></td>
	</tr>
	<tr>
	<td valign="top" style="text-align:right" width="200"><?php echo $hesklang['s_spop']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#30','400','500')"><b>?</b></a>]</td>
	<td>
	<input type="text" name="s_kb_index_popart" size="5" maxlength="2" value="<?php echo $hesk_settings['kb_index_popart']; ?>" /> <?php echo $hesklang['s_onin']; ?><br />
	<input type="text" name="s_kb_popart" size="5" maxlength="2" value="<?php echo $hesk_settings['kb_popart']; ?>" /> <?php echo $hesklang['s_onkb']; ?>
	</td>
	</tr>
	<tr>
	<td valign="top" style="text-align:right" width="200"><?php echo $hesklang['s_slat']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#31','400','500')"><b>?</b></a>]</td>
	<td>
	<input type="text" name="s_kb_index_latest" size="5" maxlength="2" value="<?php echo $hesk_settings['kb_index_latest']; ?>" /> <?php echo $hesklang['s_onin']; ?><br />
	<input type="text" name="s_kb_latest" size="5" maxlength="2" value="<?php echo $hesk_settings['kb_latest']; ?>" /> <?php echo $hesklang['s_onkb']; ?>
	</td>
	</tr>
	</table>

	</td>
	<td class="roundcornersright">&nbsp;</td>
	</tr>
	<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
	</tr>
</table>

<br />

<!-- Database settings -->
<span class="section">&raquo; <?php echo $hesklang['db']; ?></span>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

	<table border="0">
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['db_host']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#32','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_db_host" size="30" maxlength="255" value="<?php echo $hesk_settings['db_host']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['db_name']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#33','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_db_name" size="30" maxlength="255" value="<?php echo $hesk_settings['db_name']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['db_user']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#34','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_db_user" size="30" maxlength="255" value="<?php echo $hesk_settings['db_user']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['db_pass']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#35','400','500')"><b>?</b></a>]</td>
	<td><input type="password" name="s_db_pass" size="30" maxlength="255" value="<?php echo $hesk_settings['db_pass']; ?>" /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['prefix']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#36','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_db_pfix" size="30" maxlength="255" value="<?php echo $hesk_settings['db_pfix']; ?>" /></td>
	</tr>
	</table>

	</td>
	<td class="roundcornersright">&nbsp;</td>
	</tr>
	<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
	</tr>
</table>

<br />

<!-- Attachments -->
<span class="section">&raquo; <?php echo $hesklang['attachments']; ?></span>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

	<table border="0">
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['attach_use']; $onload_status=''; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#37','400','500')"><b>?</b></a>]</td>
	<td>
	<?php
	if ($enable_use_attachments)
	{
	?>
	    <label><input type="radio" name="s_attach_use" value="0" onclick="hesk_attach_disable(new Array('a1','a2','a3'))" <?php if(!$hesk_settings['attachments']['use']) {echo ' checked="checked" '; $onload_status=' disabled="disabled" ';} ?> />
	    <?php echo $hesklang['no']; ?></label> |
	    <label><input type="radio" name="s_attach_use" value="1" onclick="hesk_attach_enable(new Array('a1','a2','a3'))" <?php if($hesk_settings['attachments']['use']) {echo ' checked="checked" ';} ?> />
	    <?php echo $hesklang['yes'].'</label>';
	}
	else
	{
	    $onload_status=' disabled="disabled" ';
	    echo '<input type="hidden" name="s_attach_use" value="0" /><font class="notice">'.$hesklang['e_attach'].'</font>';
	}
	?>
	</td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['attach_num']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#38','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_max_number" size="5" maxlength="2" id="a1" value="<?php echo $hesk_settings['attachments']['max_number']; ?>" <?php echo $onload_status; ?> /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['attach_size']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#39','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_max_size" size="5" maxlength="6" id="a2" value="<?php echo $hesk_settings['attachments']['max_size']; ?>" <?php echo $onload_status; ?> /></td>
	</tr>
	<tr>
	<td style="text-align:right" width="200"><?php echo $hesklang['attach_type']; ?>: [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#40','400','500')"><b>?</b></a>]</td>
	<td><input type="text" name="s_allowed_types" size="40" maxlength="255" id="a3" value="<?php echo implode(',',$hesk_settings['attachments']['allowed_types']); ?>" <?php echo $onload_status; ?> /></td>
	</tr>
	</table>

	</td>
	<td class="roundcornersright">&nbsp;</td>
	</tr>
	<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
	</tr>
</table>

<br />

<!-- Custom fields -->
<span class="section">&raquo; <?php echo $hesklang['custom_use']; ?></span> [<a href="Javascript:void(0)" onclick="Javascript:hesk_window('../help_files/settings.html#41','400','500')"><b>?</b></a>]



	<table border="0" cellspacing="1" cellpadding="3" width="100%" class="white">
	<tr>
	<th><b><i><?php echo $hesklang['enable']; ?></i></b></th>
	<th><b><i><?php echo $hesklang['s_type']; ?></i></b></th>
	<th><b><i><?php echo $hesklang['custom_r']; ?></i></b></th>
	<th><b><i><?php echo $hesklang['custom_n']; ?></i></b></th>
	<th><b><i><?php echo $hesklang['custom_place']; ?></i></b></th>
	<th><b><i><?php echo $hesklang['opt']; ?></i></b></th>
	</tr>

	<?php
	for ($i=1;$i<=10;$i++)
	{
	    //$this_field='custom' . $i;
	    $this_field = $hesk_settings['custom_fields']['custom'.$i];

		if ($this_field['use'])
	    {
	        $onload_locally='';
	    }
	    else
	    {
	        $onload_locally=' disabled="disabled" ';
	    }

	    if ($i % 2)
	    {
	        $color=' class="admin_white" ';
	    }
	    else
	    {
	        $color=' class="admin_gray"';
	    }

		echo '
		<tr>
		<td'.$color.'><label><input type="checkbox" name="s_custom'.$i.'_use" value="1" id="c'.$i.'1" '; if ($this_field['use']) {echo 'checked="checked"';} echo ' onclick="hesk_attach_toggle(\'c'.$i.'1\',new Array(\'s_custom'.$i.'_type\',\'s_custom'.$i.'_req\',\'s_custom'.$i.'_name\',\'c'.$i.'5\',\'c'.$i.'6\'))" /> '.$hesklang['yes'].'</label></td>
	    <td'.$color.'>
	    	<select name="s_custom'.$i.'_type" id="s_custom'.$i.'_type" '.$onload_locally.'>
	        	<option value="text"     '.($this_field['type'] == 'text' ? 'selected="selected"' : '').    '>'.$hesklang['stf'].'</option>
	        	<option value="textarea" '.($this_field['type'] == 'textarea' ? 'selected="selected"' : '').'>'.$hesklang['stb'].'</option>
	        	<option value="radio"    '.($this_field['type'] == 'radio' ? 'selected="selected"' : '').   '>'.$hesklang['srb'].'</option>
	        	<option value="select"   '.($this_field['type'] == 'select' ? 'selected="selected"' : '').  '>'.$hesklang['ssb'].'</option>
	        </select>
	    </td>
	    <td'.$color.'><label><input type="checkbox" name="s_custom'.$i.'_req" value="1" id="s_custom'.$i.'_req" '; if ($this_field['req']) {echo 'checked="checked"';} echo $onload_locally.' /> '.$hesklang['yes'].'</label></td>
	    <td'.$color.'><input type="text" name="s_custom'.$i.'_name" size="20" maxlength="255" id="s_custom'.$i.'_name" value="'.$this_field['name'].'"'.$onload_locally.' /></td>
	    <td'.$color.'>
	    	<label><input type="radio" name="s_custom'.$i.'_place" value="0" id="c'.$i.'5" '.($this_field['place'] ? '' : 'checked="checked"').'  '.$onload_locally.' /> '.$hesklang['place_before'].'</label><br />
			<label><input type="radio" name="s_custom'.$i.'_place" value="1" id="c'.$i.'6" '.($this_field['place'] ? 'checked="checked"' : '').'  '.$onload_locally.' /> '.$hesklang['place_after'].'</label>
		</td>
	    <td'.$color.'><input type="hidden" name="s_custom'.$i.'_val" id="s_custom'.$i.'_val" value="'.$this_field['value'].'" />
	    <input type="hidden" name="s_custom'.$i.'_maxlen" id="s_custom'.$i.'_maxlen" value="'.$this_field['maxlen'].'" />
	    <a href="Javascript:void(0)" onclick="Javascript:return hesk_customOptions(\'custom'.$i.'\',\'s_custom'.$i.'_val\',\'s_custom'.$i.'_type\',\'s_custom'.$i.'_maxlen\',\''.$this_field['type'].'\')">'.$hesklang['opt'].'</a></td>

		</tr>
		';
	} // End FOR
	?>
	</table>



<p align="center">
<?php
if ($enable_save_settings)
{
    echo '<input type="submit" value="'.$hesklang['save_changes'].'" class="orangebutton" onmouseover="hesk_btn(this,\'orangebuttonover\');" onmouseout="hesk_btn(this,\'orangebutton\');" />';
}
else
{
    echo '<input type="submit" value="'.$hesklang['save_changes'].' ('.$hesklang['disabled'].')" class="orangebutton" onmouseover="hesk_btn(this,\'orangebuttonover\');" onmouseout="hesk_btn(this,\'orangebutton\');" disabled="disabled" /><br /><font class="error">'.$hesklang['e_save_settings'].'</font>';
}
?></p>

</form>

<p>&nbsp;</p>

<?php
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();
?>
