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

$set=array();

/* General settings */
$set['site_title']		= hesk_input($_POST['s_site_title'],$hesklang['err_sname']);
$set['site_title']		= str_replace('\\&quot;','&quot;',$set['site_title']);
$set['site_url']		= hesk_validateURL($_POST['s_site_url'],$hesklang['err_surl']);
$set['support_mail']	= hesk_validateEmail($_POST['s_support_mail'],$hesklang['err_supmail']);
$set['webmaster_mail']	= hesk_validateEmail($_POST['s_webmaster_mail'],$hesklang['err_wmmail']);
$set['noreply_mail']	= hesk_validateEmail($_POST['s_noreply_mail'],$hesklang['err_nomail']);

/* Helpdesk settings */
$set['hesk_title']		= hesk_input($_POST['s_hesk_title'],$hesklang['err_htitle']);
$set['hesk_title']		= str_replace('\\&quot;','&quot;',$set['hesk_title']);
$set['hesk_url']		= hesk_validateURL($_POST['s_hesk_url'],$hesklang['err_hurl']);
$set['server_path']		= hesk_input($_POST['s_server_path'],$hesklang['err_spath']);
$set['language']		= hesk_input($_POST['s_language'],$hesklang['err_lang']);
$set['language']		= str_replace('.inc.php','',$set['language']);
if (!file_exists(HESK_PATH . 'language/'.$set['language'].'.inc.php'))
{
	hesk_error($hesklang['err_nolang']);
}
$set['max_listings']	= hesk_input($_POST['s_max_listings'],$hesklang['err_max']);
$set['print_font_size']	= hesk_input($_POST['s_print_font_size'],$hesklang['err_psize']);
$set['debug_mode']		= $_POST['s_debug_mode'] ? 1 : 0;
$set['secimg_use']		= $_POST['s_secimg_use'] ? 1 : 0;
$set['secimg_sum']		= '';
for ($i=1;$i<=10;$i++)
{
    $set['secimg_sum'] .= substr('AEUYBDGHJLMNPQRSTVWXZ123456789', rand(0,29), 1);
}
$set['question_use']	= $_POST['s_question_use'] ? 1 : 0;
$set['question_ask']	= trim(stripslashes($_POST['s_question_ask'])) or hesk_error($hesklang['err_qask']);
$set['question_ask']	= str_replace("'","\\'",$set['question_ask']);
$set['question_ans']	= hesk_input($_POST['s_question_ans'],$hesklang['err_qans']);
$set['list_users']		= $_POST['s_list_users'] ? 1 : 0;
$set['autoclose']		= hesk_isNumber($_POST['s_autoclose']);
$set['custopen']		= $_POST['s_custopen'] ? 1 : 0;
$set['rating']			= $_POST['s_rating'] ? 1 : 0;
$set['diff_hours']		= floatval($_POST['s_diff_hours']);
$set['diff_minutes']	= floatval($_POST['s_diff_minutes']);
$set['daylight']		= $_POST['s_daylight'] ? 1 : 0;
$set['timeformat']		= hesk_input($_POST['s_timeformat']) or $set['timeformat'] = 'Y-m-d H:i:s';
$set['alink']			= $_POST['s_alink'] ? 1 : 0;

/* Knowledgebase settings */
$set['kb_enable']			= $_POST['s_kb_enable'] ? 1 : 0;
$set['kb_search']			= $_POST['s_kb_search'] ? 1 : 0;
$set['kb_search_limit']		= hesk_isNumber($_POST['s_kb_search_limit']);
$set['kb_recommendanswers']	= $_POST['s_kb_recommendanswers'] ? 1 : 0;
$set['kb_rating']			= $_POST['s_kb_rating'] ? 1 : 0;
$set['kb_substrart']		= hesk_isNumber($_POST['s_kb_substrart']);
$set['kb_cols']				= hesk_isNumber($_POST['s_kb_cols']);
$set['kb_numshow']			= hesk_isNumber($_POST['s_kb_numshow']); // Popular articles on subcat listing
$set['kb_popart']			= hesk_isNumber($_POST['s_kb_popart']); // Popular articles on main category page
$set['kb_latest']			= hesk_isNumber($_POST['s_kb_latest']); // Latest articles on main category page
$set['kb_index_popart']		= hesk_isNumber($_POST['s_kb_index_popart']);
$set['kb_index_latest']		= hesk_isNumber($_POST['s_kb_index_latest']);

/* Database settings */
$set['db_host'] = hesk_input($_POST['s_db_host'],$hesklang['err_dbhost']);
$set['db_name'] = hesk_input($_POST['s_db_name'],$hesklang['err_dbname']);
$set['db_user'] = hesk_input($_POST['s_db_user'],$hesklang['err_dbuser']);
$set['db_pass'] = hesk_input($_POST['s_db_pass'],$hesklang['err_dbpass']);
$set['db_pfix'] = hesk_input($_POST['s_db_pfix']);
$set_link = @mysql_connect($set['db_host'],$set['db_user'],$set['db_pass']) or hesk_error($hesklang['err_dbconn']);
if (!(@mysql_select_db($set['db_name'],$set_link))) {hesk_error($hesklang['err_dbsele']);}
mysql_close($set_link);

/* Attachments */
$set['attachments']['use']=$_POST['s_attach_use'] ? 1 : 0;
if ($set['attachments']['use'])
{
    $set['attachments']['max_number']=hesk_isNumber($_POST['s_max_number']) ? $_POST['s_max_number'] : 2;
    $set['attachments']['max_size']=hesk_isNumber($_POST['s_max_size']) ? $_POST['s_max_size'] : 512;
    $set['attachments']['allowed_types']=hesk_input($_POST['s_allowed_types']);
    if (empty($set['attachments']['allowed_types']))
    {
        $set['attachments']['allowed_types']=array('.gif','.jpg','.zip','.rar','.csv','.doc','.txt','.pdf');
    }
    else
    {
        $set['attachments']['allowed_types']=explode(',',str_replace(' ','',$set['attachments']['allowed_types']));
    }
}
else
{
    $set['attachments']['max_number']=2;
    $set['attachments']['max_size']=512;
    $set['attachments']['allowed_types']=array('.gif','.jpg','.zip','.rar','.csv','.doc','.txt','.pdf');
}


/* Custom fields */
for ($i=1;$i<=10;$i++)
{
	$this_field='custom' . $i;
	$set['custom_fields'][$this_field]['use'] = $_POST['s_custom'.$i.'_use'] ? 1 : 0;

	if ($set['custom_fields'][$this_field]['use'])
	{
		$set['custom_fields'][$this_field]['place']		= $_POST['s_custom'.$i.'_place'] ? 1 : 0;
		$set['custom_fields'][$this_field]['type']		= $_POST['s_custom'.$i.'_type'];
		$set['custom_fields'][$this_field]['req']		= $_POST['s_custom'.$i.'_req'] ? 1 : 0;
		$set['custom_fields'][$this_field]['name']		= hesk_input($_POST['s_custom'.$i.'_name'],$hesklang['err_custname']);
		$set['custom_fields'][$this_field]['maxlen']	= hesk_isNumber($_POST['s_custom'.$i.'_maxlen']) ? $_POST['s_custom'.$i.'_maxlen'] : 255;
        $set['custom_fields'][$this_field]['value']		= hesk_input($_POST['s_custom'.$i.'_val']);

        if (!in_array($set['custom_fields'][$this_field]['type'],array('text','textarea','select','radio')))
        {
        	$set['custom_fields'][$this_field]['type'] = 'text';
        }
	}
	else
	{
		$set['custom_fields'][$this_field] = array('use'=>0,'place'=>0,'type'=>'text','req'=>0,'name'=>'Custom field '.$i ,'maxlen'=>255,'value'=>'');
	}
}




$settings_file_content='<?php
/* Settings file for Hesk ' . $hesk_settings['hesk_version'] . ' */
/*** Please read the README.HTM file for more information on these settings ***/

/* General settings */
$hesk_settings[\'site_title\']=\'' . $set['site_title'] . '\';
$hesk_settings[\'site_url\']=\'' . $set['site_url'] . '\';
$hesk_settings[\'support_mail\']=\'' . $set['support_mail'] . '\';
$hesk_settings[\'webmaster_mail\']=\'' . $set['webmaster_mail'] . '\';
$hesk_settings[\'noreply_mail\']=\'' . $set['noreply_mail'] . '\';

/* Help desk settings */
$hesk_settings[\'hesk_url\']=\'' . $set['hesk_url'] . '\';
$hesk_settings[\'hesk_title\']=\'' . $set['hesk_title'] . '\';
$hesk_settings[\'server_path\']=\'' . $set['server_path'] . '\';
$hesk_settings[\'language\']=\'' . $set['language'] . '\';
$hesk_settings[\'max_listings\']=' . $set['max_listings'] . ';
$hesk_settings[\'print_font_size\']=' . $set['print_font_size'] . ';
$hesk_settings[\'debug_mode\']=' . $set['debug_mode'] . ';
$hesk_settings[\'secimg_use\']=' . $set['secimg_use'] . ';
$hesk_settings[\'secimg_sum\']=\'' . $set['secimg_sum'] . '\';
$hesk_settings[\'question_use\']=' . $set['question_use'] . ';
$hesk_settings[\'question_ask\']=\'' . $set['question_ask'] . '\';
$hesk_settings[\'question_ans\']=\'' . $set['question_ans'] . '\';
$hesk_settings[\'list_users\']=' . $set['list_users'] . ';
$hesk_settings[\'autoclose\']=' . $set['autoclose'] . ';
$hesk_settings[\'custopen\']=' . $set['custopen'] . ';
$hesk_settings[\'rating\']=' . $set['rating'] . ';
$hesk_settings[\'diff_hours\']=' . $set['diff_hours'] . ';
$hesk_settings[\'diff_minutes\']=' . $set['diff_minutes'] . ';
$hesk_settings[\'daylight\']=' . $set['daylight'] . ';
$hesk_settings[\'timeformat\']=\'' . $set['timeformat'] . '\';
$hesk_settings[\'alink\']=' . $set['alink'] . ';

/* Knowledgebase settings */
$hesk_settings[\'kb_enable\']=' . $set['kb_enable'] . ';
$hesk_settings[\'kb_search\']=' . $set['kb_search'] . ';
$hesk_settings[\'kb_search_limit\']=' . $set['kb_search_limit'] . ';
$hesk_settings[\'kb_recommendanswers\']=' . $set['kb_recommendanswers'] . ';
$hesk_settings[\'kb_rating\']=' . $set['kb_rating'] . ';
$hesk_settings[\'kb_substrart\']=' . $set['kb_substrart'] . ';
$hesk_settings[\'kb_cols\']=' . $set['kb_cols'] . ';
$hesk_settings[\'kb_numshow\']=' . $set['kb_numshow'] . ';
$hesk_settings[\'kb_popart\']=' . $set['kb_popart'] . ';
$hesk_settings[\'kb_latest\']=' . $set['kb_latest'] . ';
$hesk_settings[\'kb_index_popart\']=' . $set['kb_index_popart'] . ';
$hesk_settings[\'kb_index_latest\']=' . $set['kb_index_latest'] . ';

/* Database settings */
$hesk_settings[\'db_host\']=\'' . $set['db_host'] . '\';
$hesk_settings[\'db_name\']=\'' . $set['db_name'] . '\';
$hesk_settings[\'db_user\']=\'' . $set['db_user'] . '\';
$hesk_settings[\'db_pass\']=\'' . $set['db_pass'] . '\';
$hesk_settings[\'db_pfix\']=\'' . $set['db_pfix'] . '\';

/* File attachments */
$hesk_settings[\'attachments\']=array (
    \'use\' =>  ' . $set['attachments']['use'] . ',
    \'max_number\'  =>  ' . $set['attachments']['max_number'] . ',
    \'max_size\'    =>  ' . $set['attachments']['max_size'] . ', // kb
    \'allowed_types\'   =>  array(\'' . implode('\',\'',$set['attachments']['allowed_types']) . '\')
);

/* Custom fields */
$hesk_settings[\'custom_fields\']=array (
';

for ($i=1;$i<=10;$i++) {
    $settings_file_content.='\'custom'.$i.'\'=>array(\'use\'=>'.$set['custom_fields']['custom'.$i]['use'].',\'place\'=>'.$set['custom_fields']['custom'.$i]['place'].',\'type\'=>\''.$set['custom_fields']['custom'.$i]['type'].'\',\'req\'=>'.$set['custom_fields']['custom'.$i]['req'].',\'name\'=>\''.$set['custom_fields']['custom'.$i]['name'].'\',\'maxlen\'=>'.$set['custom_fields']['custom'.$i]['maxlen'].',\'value\'=>\''.$set['custom_fields']['custom'.$i]['value'].'\')';
    if ($i!=10) {$settings_file_content.=',
';}
}

$settings_file_content.='
);

#############################
#     DO NOT EDIT BELOW     #
#############################
$hesk_settings[\'hesk_version\']=\'' . $hesk_settings['hesk_version'] . '\';
if ($hesk_settings[\'debug_mode\'])
{
    error_reporting(E_ALL ^ E_NOTICE);
}
else
{
    ini_set(\'display_errors\', 0);
    ini_set(\'log_errors\', 1);
}
if (!defined(\'IN_SCRIPT\')) {die(\'Invalid attempt!\');}
if (is_dir(HESK_PATH . \'install\') && !defined(\'INSTALL\')) {die(\'Please delete the <b>install</b> folder from your server for security reasons then refresh this page!\');}
?>';

/* uncomment for debugging purposes:
echo $settings_file_content;
exit();
*/

$fp=@fopen(HESK_PATH . 'hesk_settings.inc.php','w') or hesk_error($hesklang['err_openset']);
fputs($fp,$settings_file_content);
fclose($fp);

$_SESSION['HESK_NOTICE']  = $hesklang['set_saved'];
$_SESSION['HESK_MESSAGE'] = $hesklang['set_were_saved'];
Header('Location: admin_settings.php');
exit();
?>
