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
hesk_dbConnect();

/* What should we do? */
switch ($_REQUEST['a'])
{
    case 'do_login':
    	do_login();
        break;
    case 'logout':
    	logout();
        break;
    default:
    	print_login();
}

/* Print footer */
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();

/*** START FUNCTIONS ***/

function do_login() {
	global $hesk_settings, $hesklang;

    $user = hesk_input($_POST['user']);
    if (empty($user))
    {
		$myerror = $hesk_settings['list_users'] ? $hesklang['select_username'] : $hesklang['enter_username'];
        $_SESSION['HESK_ERROR']   = true;
        $_SESSION['HESK_MESSAGE'] = $myerror;
        print_login();
        exit();
    }
    define('HESK_USER', $user);

	$pass = hesk_input($_POST['pass']);
	if (empty($pass))
	{
        $_SESSION['HESK_ERROR']   = true;
        $_SESSION['HESK_MESSAGE'] = $hesklang['enter_pass'];
        print_login();
        exit();
	}

	$sql = 'SELECT * FROM `'.$hesk_settings['db_pfix'].'users` WHERE `user` = \''.$user.'\' LIMIT 1';
	$result = hesk_dbQuery($sql);
	if (hesk_dbNumRows($result) != 1)
	{
        $_SESSION['HESK_ERROR']   = true;
        $_SESSION['HESK_MESSAGE'] = $hesklang['wrong_user'];
        print_login();
        exit();
	}

	$res=hesk_dbFetchAssoc($result);
	foreach ($res as $k=>$v)
	{
	    $_SESSION[$k]=$v;
	}

	/* Check password */
	if (hesk_Pass2Hash($pass) != $_SESSION['pass'])
    {
	    hesk_session_stop();
        $_SESSION['HESK_ERROR']   = true;
        $_SESSION['HESK_MESSAGE'] = $hesklang['wrong_pass'];
        print_login();
        exit();
	}
	unset($_SESSION['pass']);

	/* Regenerate session ID (security) */
	hesk_session_regenerate_id();

	/* Get allowed categories */
	if (empty($_SESSION['isadmin']))
	{
	    $cat=substr($_SESSION['categories'], 0, -1);
	    $_SESSION['categories']=explode(',',$cat);
	}

	session_write_close();

	/* Remember username? */
	if (isset($_POST['remember_user']) && $_POST['remember_user']=='Y')
	{
	    setcookie('hesk_username', "$user", strtotime('+1 month'));
	}
	elseif (isset($_COOKIE['hesk_username']))
	{
	    // Expire cookie if set otherwise
	    setcookie('hesk_username', '');
	}

    /* Close any old tickets here so Cron jobs aren't necessary */
	if ($hesk_settings['autoclose'])
    {
    	$dt  = date('Y-m-d H:i:s',time() - $hesk_settings['autoclose']*86400);
		$sql = 'UPDATE `'.$hesk_settings['db_pfix'].'tickets` SET `status`=\'3\' WHERE `status` = \'2\' AND `lastchange` <= \''.$dt.'\'';
		hesk_dbQuery($sql);
    }

	/* Redirect to the destination page */
	if ($url = hesk_input($_REQUEST['goto']))
	{
	    $url = str_replace('&amp;','&',$url);
	    Header('Location: '.$url);
	}
	else
	{
	    Header('Location: admin_main.php');
	}
	exit();
} // End do_login()


function print_login() {
	global $hesk_settings, $hesklang;
	require_once(HESK_PATH . 'inc/header.inc.php');

	if (isset($_REQUEST['notice']))
	{
	    $_SESSION['HESK_ERROR']   = true;
        $_SESSION['HESK_MESSAGE'] = $hesklang['session_expired'];
	}

	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="3"><img src="../img/headerleftsm.jpg" width="3" height="25" alt="" /></td>
	<td class="headersm"><?php echo $hesklang['login']; ?></td>
	<td width="3"><img src="../img/headerrightsm.jpg" width="3" height="25" alt="" /></td>
	</tr>
	</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td><span class="smaller"><a href="<?php echo $hesk_settings['site_url']; ?>" class="smaller"><?php echo $hesk_settings['site_title']; ?></a> &gt;
	<?php echo $hesklang['admin_login']; ?></span></td>
	</tr>
	</table>

	</td>
	</tr>
	<tr>
	<td>

	<br />

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

	    if(isset($_SESSION['HESK_ERROR']))
        {
	?>
	        <div align="center">
	        <table border="0" width="600" id="error" cellspacing="0" cellpadding="3">
		        <tr>
		        	<td align="left" class="error_header">&nbsp;<img src="../img/error.gif" style="vertical-align:text-bottom" width="16" height="16" alt="" />&nbsp; <?php echo $hesklang['error']; ?></td>
		        </tr>
		        <tr>
		        	<td align="left" class="error_body"><?php echo $_SESSION['HESK_MESSAGE']; ?></td>
		        </tr>
	        </table>
	        </div>
            <br />
	<?php
	        unset($_SESSION['HESK_ERROR']);
	        unset($_SESSION['HESK_MESSAGE']);
	    }
	?>
    <br />

    <div align="center">
	<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
		<td class="roundcornersleft">&nbsp;</td>
		<td>

		<h3 align="center"><?php echo $hesklang['login']; ?></h3>

		<form action="index.php" method="post">

		<table border="0" cellspacing="1" cellpadding="5">
		<tr>
		<td style="text-align:right"><?php echo $hesklang['user']; ?>: </td>
		<td>
		<?php
		if (defined('HESK_USER'))
		{
			$savedUser = HESK_USER;
		}
		else
		{
			$savedUser = $_COOKIE['hesk_username'] ? htmlspecialchars($_COOKIE['hesk_username']) : '';
		}

        $is_checked = $_COOKIE['hesk_username'] ? 'checked="checked"' : '';

		if ($hesk_settings['list_users'])
		{
		    echo '<select name="user">';
		    $sql    = 'SELECT * FROM `'.$hesk_settings['db_pfix'].'users` ORDER BY `id` ASC';
		    $result = hesk_dbQuery($sql);
		    while ($row=hesk_dbFetchAssoc($result))
		    {
		        $sel = (strtolower($savedUser) == strtolower($row['user'])) ? 'selected="selected"' : '';
		        echo '<option value="'.$row['user'].'" '.$sel.'>'.$row['user'].'</option>';
		    }
		    echo '</select>';

		}
		else
		{
		    echo '<input type="text" name="user" size="30" value="'.$savedUser.'" />';
		}
		?>
		</td>
		</tr>
		<tr>
		<td style="text-align:right"><?php echo $hesklang['pass']; ?>: </td>
		<td><input type="password" name="pass" size="30" /></td>
		</tr>
		</table>

		<p style="text-align:center"><label><input type="checkbox" name="remember_user" value="Y" <?php echo $is_checked; ?> /> <?php echo $hesklang['remember_user']; ?></label></p>

		<p style="text-align:center"><input type="hidden" name="a" value="do_login" />
		<?php
		if ($url=hesk_input($_REQUEST['goto']))
		{
		    echo '<input type="hidden" name="goto" value="'.$url.'" />';
		}
		?>
		<input type="submit" value="<?php echo $hesklang['login']; ?>" class="orangebutton" onmouseover="hesk_btn(this,'orangebuttonover');" onmouseout="hesk_btn(this,'orangebutton');" /></p>

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
    </div>

    <p>&nbsp;</p>

	<?php
    require_once(HESK_PATH . 'inc/footer.inc.php');
    exit();
} // End print_login()

function logout() {
	global $hesk_settings, $hesklang;
	hesk_session_stop();
	$_SESSION['HESK_NOTICE']  = $hesklang['logout'];
	$_SESSION['HESK_MESSAGE'] = $hesklang['logout_success'];
	print_login();
	exit();
} // End logout()

?>
