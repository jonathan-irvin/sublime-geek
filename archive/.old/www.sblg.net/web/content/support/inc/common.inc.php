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

/* Check if this is a valid include */
if (!defined('IN_SCRIPT')) {die($hesklang['attempt']);}

#error_reporting(E_ALL);

/* PHP 6 doesn't support magic_quotes anymore */
if (version_compare(PHP_VERSION, '6.0.0-dev', '<'))
{
	@set_magic_quotes_runtime(0);
	if (get_magic_quotes_gpc())
	{
		define('HESK_SLASH',false);
	}
    else
    {
    	define('HESK_SLASH',true);
    }
}
else
{
	define('HESK_SLASH',true);
}

hesk_getLanguage();


/*** FUNCTIONS ***/

function & ref_new(&$new_statement)
{
	return $new_statement;
} // END ref_new()


function hesk_getHTML($in) {
	global $hesk_settings, $hesklang;

	$replace_from = array("\t","<?","?>","$","<%","%>");
	$replace_to   = array("","&lt;?","?&gt;","\$","&lt;%","%&gt;");

	$in = trim($in);
	$in = str_replace($replace_from,$replace_to,$in);
	$in = preg_replace('/\<script(.*)\>(.*)\<\/script\>/Uis',"<script$1></script>",$in);
	$in = preg_replace('/\<\!\-\-(.*)\-\-\>/Uis',"<!-- comments have been removed -->",$in);

	if (HESK_SLASH === true)
	{
		$in = addslashes($in);
	}
    $in = str_replace('\"','"',$in);

	return $in;
} // END hesk_getHTML()


function hesk_getEmailMessage($eml_file) {
	global $hesk_settings, $hesklang;

    $valid_emails = array('category_moved','forgot_ticket_id','new_reply_by_customer','new_reply_by_staff','new_ticket','new_ticket_staff');

    if (!in_array($eml_file,$valid_emails))
    {
    	hesk_error($hesklang['inve']);
    }

    $eml_file = 'language/' . $hesk_settings['languages'][$hesk_settings['language']]['folder'] . '/emails/' . $eml_file . '.txt';

    if (file_exists(HESK_PATH . $eml_file))
    {
		return file_get_contents(HESK_PATH . $eml_file);
    }
    else
    {
    	hesk_error($hesklang['emfm'].': '.$eml_file);
    }
} // END hesk_getEmailMessage


function hesk_msgToPlain($msg, $specialchars=0, $strip=1) {
	$from = array('/\<a href="mailto\:([^"]*)"\>([^\<]*)\<\/a\>/i', '/\<a href="([^"]*)" target="_blank"\>([^\<]*)\<\/a\>/i');
	$to   = array("$1", "$1");
	$msg = preg_replace($from,$to,$msg);
	$msg = preg_replace('/<br \/>\s*/',"\n",$msg);
    $msg = trim($msg);

    if ($strip)
    {
    	$msg = stripslashes($msg);
    }

    if ($specialchars)
    {
    	$msg = html_entity_decode($msg);
    }

    return $msg;
} // END hesk_msgToPlain()


function hesk_showTopBar($page_title) {
	global $hesk_settings, $hesklang;

	if ($hesk_settings['can_sel_lang'])
	{

		$str = '<form method="get" action="" style="margin:0;padding:0;border:0;white-space:nowrap;">';
		foreach ($_GET as $k => $v)
		{
			if ($k == 'language')
			{
				continue;
			}
			$str .= '<input type="hidden" name="'.htmlentities($k).'" value="'.htmlentities($v).'" />';
		}

        $str .= '<select name="language" onchange="this.form.submit()">';
		$str .= hesk_listLanguages(0);
		$str .= '</select>';

	?>
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
		<td class="headersm" style="padding-left: 0px;"><?php echo $page_title; ?></td>
		<td class="headersm" style="padding-left: 0px;text-align: right">
        <script language="javascript" type="text/javascript">
		document.write('<?php echo str_replace(array('"','<','=','>'),array('\42','\74','\75','\76'),$str . '</form>'); ?>');
        </script>
        <noscript>
        <?php
        	echo $str . '<input type="submit" value="'.addslashes($hesklang['go']).'" /></form>';
        ?>
        </noscript>
        </td>
		</tr>
		</table>
	<?php
	}
	else
	{
		echo $page_title;
	}
} // END hesk_showTopBar()


function hesk_getLanguage() {
	global $hesk_settings, $hesklang, $_SESSION;

    $language = $hesk_settings['language'];

    /* Can users select language? */
    if (!$hesk_settings['can_sel_lang'])
    {
        return hesk_returnLanguage();
    }

    /* Is a non-default language selected? If not use default one */
    if (isset($_GET['language']))
    {
    	$language = hesk_input($_GET['language']) or $language = $hesk_settings['language'];
    }
    elseif (isset($_COOKIE['hesk_language']))
    {
    	$language = hesk_input($_COOKIE['hesk_language']) or $language = $hesk_settings['language'];
    }
    else
    {
        return hesk_returnLanguage();
    }

    /* non-default language selected. Check if it's a valid one, if not use default one */
    if ($language != $hesk_settings['language'] && isset($hesk_settings['languages'][$language]))
    {
        $hesk_settings['language'] = $language;
    }

	setcookie('hesk_language',$hesk_settings['language'],time()+31536000,'/');
    return hesk_returnLanguage();
} // END hesk_getLanguage()


function hesk_returnLanguage() {
	global $hesk_settings, $hesklang;
	require(HESK_PATH . 'language/' . $hesk_settings['languages'][$hesk_settings['language']]['folder'] . '/text.php');
    return true;
} // END hesk_returnLanguage()


function hesk_listLanguages($doecho = 1) {
	global $hesk_settings, $hesklang;

	foreach ($hesk_settings['languages'] as $lang => $info)
	{
		if ($lang == $hesk_settings['language'])
		{
			$tmp .= '<option value="'.$lang.'" selected="selected">'.$lang.'</option>';
		}
		else
		{
			$tmp .= '<option value="'.$lang.'">'.$lang.'</option>';
		}
	}

    if ($doecho)
    {
		echo $tmp;
    }
    else
    {
    	return $tmp;
    }
} // END hesk_listLanguages


function hesk_autoLogin($noredirect=0) {
	global $hesk_settings, $hesklang, $hesk_db_link;

	if (!$hesk_settings['autologin'])
    {
    	return false;
    }

    $user = $_COOKIE['hesk_username'] ? htmlspecialchars($_COOKIE['hesk_username']) : '';
    $hash = $_COOKIE['hesk_p'] ? htmlspecialchars($_COOKIE['hesk_p']) : '';
    define('HESK_USER', $user);

	if (empty($user) || empty($hash))
    {
    	return false;
    }

	$sql = 'SELECT * FROM `'.$hesk_settings['db_pfix'].'users` WHERE `user` = \''.hesk_dbEscape($user).'\' LIMIT 1';
	$result = hesk_dbQuery($sql);
	if (hesk_dbNumRows($result) != 1)
	{
        setcookie('hesk_username', '');
        setcookie('hesk_p', '');
        header('Location: index.php?a=login&notice=1');
        exit();
	}

	$res=hesk_dbFetchAssoc($result);
	foreach ($res as $k=>$v)
	{
	    $_SESSION[$k]=$v;
	}

	/* Check password */
	if ($hash != hesk_Pass2Hash($_SESSION['pass'].strtolower($user).$_SESSION['pass']))
    {
        setcookie('hesk_username', '');
        setcookie('hesk_p', '');
        header('Location: index.php?a=login&notice=1');
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

	/* Renew cookies */
	setcookie('hesk_username', "$user", strtotime('+1 year'));
	setcookie('hesk_p', "$hash", strtotime('+1 year'));

    /* Close any old tickets here so Cron jobs aren't necessary */
	if ($hesk_settings['autoclose'])
    {
    	$dt  = date('Y-m-d H:i:s',time() - $hesk_settings['autoclose']*86400);
		$sql = 'UPDATE `'.$hesk_settings['db_pfix'].'tickets` SET `status`=\'3\' WHERE `status` = \'2\' AND `lastchange` <= \''.hesk_dbEscape($dt).'\'';
		hesk_dbQuery($sql);
    }

	/* If session expired while a HESK page is open just continue using it, don't redirect */
    if ($noredirect)
    {
    	return true;
    }

	/* Redirect to the destination page */
	if ($url = hesk_input($_REQUEST['goto']))
	{
	    $url = str_replace('&amp;','&',$url);
	    header('Location: '.$url);
	}
	else
	{
	    header('Location: admin_main.php');
	}
	exit();
} // END hesk_autoLogin()


function hesk_Pass2Hash($plaintext) {
    $majorsalt  = '';
    $len = strlen($plaintext);
    for ($i=0;$i<$len;$i++)
    {
        $majorsalt .= sha1(substr($plaintext,$i,1));
    }
    $corehash = sha1($majorsalt);
    return $corehash;
} // END hesk_Pass2Hash()


function hesk_date($dt='')
{
	global $hesk_settings;

    if (!$dt)
    {
    	$dt = time();
    }
    else
    {
    	$dt = strtotime($dt);
    }

	$zone=3600*$hesk_settings['diff_hours'] + 60*$hesk_settings['diff_minutes'];

    if ($hesk_settings['daylight'])
    {
		if (date('I',$dt))
        {
        	$zone += 3600;
        }
	}

	return date($hesk_settings['timeformat'], $dt + $zone);
} // End hesk_date()


function hesk_formatDate($dt)
{
    $dt=hesk_date($dt);
	$dt=str_replace(' ','<br />',$dt);
    return $dt;
} // End hesk_formatDate()


function hesk_jsString($str)
{
	$str  = str_replace( array('\'','<br />') , array('\\\'','') ,$str);
    $from = array("/\r\n|\n|\r/", '/\<a href="mailto\:([^"]*)"\>([^\<]*)\<\/a\>/i', '/\<a href="([^"]*)" target="_blank"\>([^\<]*)\<\/a\>/i');
    $to   = array("\\r\\n' + \r\n'", "$1", "$1");
    return preg_replace($from,$to,$str);
} // END hesk_jsString()


function hesk_makeURL($strUrl)
{
    $myMsg = ' ' . $strUrl;
    $myMsg = preg_replace("#(^|[\n ])([\w]+?://[^ \"\n\r\t<]*)#is", "$1<a href=\"$2\" target=\"_blank\">$2</a>", $myMsg);
    $myMsg = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#is", "$1<a href=\"http://$2\" target=\"_blank\">$2</a>", $myMsg);
    $myMsg = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $myMsg);
    $myMsg = substr($myMsg, 1);
    return($myMsg);
} // End hesk_makeURL()


function hesk_isNumber($in,$error=0) {

    $in = trim($in);

    if (preg_match("/\D/",$in) || $in=="")
    {
        if ($error)
        {
            hesk_error($error);
        }
        else
        {
            return 0;
        }
    }

    return $in;

} // END hesk_isNumber()


function hesk_PasswordSyntax($password,$error,$checklength=1,$required=1) {

    if (preg_match("/\W|\_|\./",$password) || empty($password))
    {
		if ($required)
		{
			hesk_error($error);
		}
		else
		{
			return '';
		}
    }

    if ($checklength==1 && strlen($password) < 5)
    {
		if ($required)
		{
			hesk_error($error);
		}
		else
		{
			return '';
		}
    }

    return $password;

} // END hesk_PasswordSyntax()


function hesk_validateURL($url,$error) {
	global $hesklang;

    $url = trim($url);

    if (strpos($url,"'") !== false || strpos($url,"\"") !== false)
    {
		die($hesklang['attempt']);
    }

    if (preg_match('/^https?:\/\/+(localhost|[\w\-]+\.[\w\-]+)/i',$url))
    {
        return hesk_input($url);
    }

    hesk_error($error);

} // END hesk_validateURL()


function hesk_input($in,$error=0) {

	if (is_array($in))
    {
    	$in = array_map('hesk_input',$in);
        return $in;
    }

    $in = trim($in);

    if (strlen($in))
    {
        $in = htmlspecialchars($in);
        $in = preg_replace('/&amp;(\#[0-9]+;)/','&$1',$in);
    }
    elseif ($error)
    {
        hesk_error($error);
    }

    if (HESK_SLASH)
    {
		$in = addslashes($in);
    }

    return $in;

} // END hesk_input()


function hesk_validateEmail($address,$error,$required=1) {
	global $hesklang;

    $address = trim($address);

    if (strpos($address,"'") !== false || strpos($address,"\"") !== false)
    {
		die($hesklang['attempt']);
    }

    if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$address))
    {
        return hesk_input($address);
    }

    if ($required) {
        hesk_error($error);
    } else {
        return '';
    }

} // END hesk_validateEmail()


function hesk_myCategories($what='category') {

    if (!empty($_SESSION['isadmin']))
    {
        return '1';
    }
    else
    {
        $i=1;
        $mycat_sql='(';
        foreach ($_SESSION['categories'] as $mycat)
        {
            if ($i)
            {
                $mycat_sql.=" `".hesk_dbEscape($what)."`=".hesk_dbEscape($mycat)." ";
            }
            else
            {
                $mycat_sql.=" OR `".hesk_dbEscape($what)."`=".hesk_dbEscape($mycat)." ";
            }
            $i=0;
        }
        $mycat_sql.=')';
        return $mycat_sql;
    }

} // END hesk_myCategories()


function hesk_okCategory($cat) {

    if (!empty($_SESSION['isadmin']))
    {
        return true;
    }
    elseif (in_array($cat,$_SESSION['categories']))
    {
        return true;
    }
    else
    {
        global $hesklang;
        hesk_error($hesklang['not_authorized_tickets']);
    }

} // END hesk_okCategory()


function hesk_session_regenerate_id() {

    if (version_compare(phpversion(),'4.3.3','>='))
    {
       session_regenerate_id();
    }
    else
    {
        $randlen = 32;
        $randval = '0123456789abcdefghijklmnopqrstuvwxyz';
        $random = '';
        $randval_len = 35;
        for ($i = 1; $i <= $randlen; $i++)
        {
            $random .= substr($randval, rand(0,$randval_len), 1);
        }

        if (session_id($random))
        {
            setcookie(
                session_name('HESK'),
                $random,
                ini_get('session.cookie_lifetime'),
                '/'
            );
            return true;
        }
        else
        {
            return false;
        }
    }

} // END hesk_session_regenerate_id()


function hesk_checkPermission($feature,$showerror=1) {

    /* Admins have full access to all features */
    if ($_SESSION['isadmin'])
    {
        return true;
    }

    /* Check other staff for permissions */
    if (strpos($_SESSION['heskprivileges'], $feature) === false)
    {
    	if ($showerror)
        {
        	global $hesklang;
        	hesk_error($hesklang['no_permission'].'<p>&nbsp;</p><p align="center"><a href="index.php">'.$hesklang['click_login'].'</a>');
        }
        else
        {
        	return false;
        }
    }
    else
    {
        return true;
    }

} // END hesk_checkPermission()


function hesk_isLoggedIn() {
	global $hesk_settings;

    if (empty($_SESSION['id']))
    {
    	if ($hesk_settings['autologin'] && hesk_autoLogin(1))
        {
        	return true;
        }

        $referer = hesk_input($_SERVER['REQUEST_URI']);
        $referer = str_replace('&amp;','&',$referer);

        if (strpos($referer,'admin_reply_ticket.php')!== false)
        {
            $referer = 'admin_main.php';
        }

        $url = 'index.php?a=login&notice=1&goto='.urlencode($referer);
        header('Location: '.$url);
        exit();
    }
    else
    {
        hesk_session_regenerate_id();
        return true;
    }

} // END hesk_isLoggedIn()


function hesk_session_start() {

    session_name('HESK');

    if (session_start()) {
        header ('P3P: CP="CAO DSP COR CURa ADMa DEVa OUR IND PHY ONL UNI COM NAV INT DEM PRE"');
        return true;
    } else {
        global $hesk_settings, $hesklang;
        hesk_error("$hesklang[no_session] $hesklang[contact_webmaster] $hesk_settings[webmaster_mail]");
    }

} // END hesk_session_start()


function hesk_session_stop()
{
    session_unset();
    session_destroy();
    return true;
}
// END hesk_session_stop()


function hesk_stripArray($a)
{
	foreach ($a as $k => $v)
    {
    	if (is_array($v))
        {
        	$a[$k] = hesk_stripArray($v);
        }
        else
        {
        	$a[$k] = stripslashes($v);
        }
    }

    reset ($a);
    return ($a);
} // END hesk_stripArray()


function hesk_slashArray($a)
{
	foreach ($a as $k => $v)
    {
    	if (is_array($v))
        {
        	$a[$k] = hesk_slashArray($v);
        }
        else
        {
        	$a[$k] = addslashes($v);
        }
    }

    reset ($a);
    return ($a);
} // END hesk_slashArray()


function hesk_error($error) {
global $hesk_settings, $hesklang;

require_once(HESK_PATH . 'inc/header.inc.php');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="3"><img src="<?php echo HESK_PATH; ?>img/headerleftsm.jpg" width="3" height="25" alt="" /></td>
<td class="headersm"><?php echo $hesk_settings['hesk_title']; ?></td>
<td width="3"><img src="<?php echo HESK_PATH; ?>img/headerrightsm.jpg" width="3" height="25" alt="" /></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td><span class="smaller"><a href="<?php echo $hesk_settings['site_url']; ?>"
class="smaller"><?php echo $hesk_settings['site_title']; ?></a> &gt; <a href="<?php
if (empty($_SESSION['id']))
{
	echo $hesk_settings['hesk_url'];
}
else
{
	echo 'admin_main.php';
}
?>" class="smaller"><?php echo $hesk_settings['hesk_title']; ?></a>
&gt; <?php echo $hesklang['error']; ?></span></td>
</tr>
</table>

</td>
</tr>
<tr>
<td>

<p>&nbsp;</p>

<div align="center">
<table border="0" width="600" id="error" cellspacing="0" cellpadding="3">
	<tr>
		<td align="left" class="error_header">&nbsp;<img src="<?php echo HESK_PATH; ?>img/error.gif" style="vertical-align:text-bottom" width="16" height="16" alt="" />&nbsp; <?php echo $hesklang['error']; ?></td>
	</tr>
	<tr>
		<td align="left" class="error_body"><?php
        	echo $error;

            if ($hesk_settings['debug_mode'])
            {
            	echo "<p>&nbsp;</p><p><span style=\"color:red;font-weight:bold\">$hesklang[warn]</span><br />$hesklang[dmod]</p>";
            }

        ?></td>
	</tr>
</table>
</div>

<p>&nbsp;</p>
<p style="text-align:center"><a href="javascript:history.go(-1)"><?php echo $hesklang['back']; ?></a></p>

<p>&nbsp;</p>
<p>&nbsp;</p>

<?php
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();
} // END hesk_error()


function hesk_round_to_half($num) {
	if ($num >= ($half = ($ceil = ceil($num))- 0.5) + 0.25)
    {
    	return $ceil;
    }
    elseif ($num < $half - 0.25)
    {
    	return floor($num);
    }
    else
    {
    	return $half;
    }
} // END hesk_round_to_half()


function hesk_detect_bots() {

	$botlist = array('googlebot', 'msnbot', 'slurp', 'alexa', 'teoma', 'froogle',
	'gigabot', 'inktomi', 'looksmart', 'firefly', 'nationaldirectory',
	'ask jeeves', 'tecnoseek', 'infoseek', 'webfindbot', 'girafabot',
	'crawl', 'www.galaxy.com', 'scooter', 'appie', 'fast', 'webbug', 'spade', 'zyborg', 'rabaz',
	'baiduspider', 'feedfetcher-google', 'technoratisnoop', 'rankivabot',
	'mediapartners-google', 'webalta crawler', 'spider', 'robot', 'bot/', 'bot-','voila');

    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);

	foreach ($botlist as $bot)
    {
    	if (strpos($ua,$bot)!== false)
        {
        	return true;
        }
    }

	return false;
} // END hesk_detect_bots()


function hesk_randomize_array($array) {
	$rand_items = array_rand($array, count($array));
	$new_array = array();
	foreach($rand_items as $value)
	{
	    $new_array[$value] = $array[$value];
	}

	return $new_array;
} // END hesk_randomize_array()


function hesk_generate_SPAM_question () {

	$useChars = 'AEUYBDGHJLMNPRSTVWXZ23456789';
	$ac = $useChars{mt_rand(0,27)};
	for($i=1;$i<5;$i++)
	{
	    $ac .= $useChars{mt_rand(0,27)};
	}

    $animals = array('dog','cat','cow','pig','elephant','tiger','chicken','bird','fish','alligator','monkey','mouse','lion','turtle','crocodile','duck','gorilla','horse','penguin','dolphin','rabbit','sheep','snake','spider');
    $not_animals = array('ball','window','house','tree','earth','money','rocket','sun','star','shirt','snow','rain','air','candle','computer','desk','coin','TV','paper','bell','car','baloon','airplane','phone','water','space');

    $keys = array_rand($animals,2);
    $my_animals[] = $animals[$keys[0]];
    $my_animals[] = $animals[$keys[1]];

    $keys = array_rand($not_animals,2);
    $my_not_animals[] = $not_animals[$keys[0]];
    $my_not_animals[] = $not_animals[$keys[1]];

	$my_animals[] = $my_not_animals[0];
    $my_not_animals[] = $my_animals[0];

    $e = mt_rand(1,9);
    $f = $e + 1;
    $d = mt_rand(1,9);
    $s = intval($e + $d);

    if ($e == $d)
    {
    	$d ++;
    	$h = $d;
        $l = $e;
    }
    elseif ($e < $d)
    {
    	$h = $d;
        $l = $e;
    }
    else
    {
    	$h = $e;
        $l = $d;
    }

    $spam_questions = array(
    	$f => 'What is the next number after '.$e.'? (Use only digits to answer)',
    	'white' => 'What color is snow? (give a 1 word answer to show you are a human)',
    	'green' => 'What color is grass? (give a 1 word answer to show you are a human)',
    	'blue' => 'What color is water? (give a 1 word answer to show you are a human)',
    	$ac => 'Access code (type <b>'.$ac.'</b> here):',
    	$ac => 'Type <i>'.$ac.'</i> here to fight SPAM:',
    	$s => 'Solve this equation to show you are human: '.$e.' + '.$d.' = ',
    	$my_animals[2] => 'Which of these is NOT an animal: ' . implode(', ',hesk_randomize_array($my_animals)),
    	$my_not_animals[2] => 'Which of these IS an animal: ' . implode(', ',hesk_randomize_array($my_not_animals)),
    	$h => 'Which number is higher <b>'.$e.'</b> or <b>'.$d.'</b>:',
    	$l => 'Which number is lower <b>'.$e.'</b> or <b>'.$d.'</b>:',
        'no' => 'Are you a robot? (yes or no)',
        'yes' => 'Are you a human? (yes or no)'
    );

    $r = array_rand($spam_questions);
	$ask = $spam_questions[$r];
    $ans = $r;

    return array($ask,$ans);
} // END hesk_generate_SPAM_question()
?>
