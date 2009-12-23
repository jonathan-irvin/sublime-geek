<?php
/**
*
* @package phpBB3
* @version $Id: $
* @copyright (c) 2006 Star Trek Guide Group and 2008 T50
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @Orig author Highway of Life : Lew21
* @Revised edition author T50Webmaster (T50) - This version--
*/

define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.'.$phpEx);


// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('mods/bots');
// end session management

//Set admin only beyond this point
//Is this user any type of admin? No, then stop here!
if (!$auth->acl_get('a_'))
{
	trigger_error($user->lang['NO_ADMIN']);
}

// Add the search bots into the database

function add_bots2()
{
	global $db, $user, $config, $phpbb_root_path, $phpEx;


	$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . " WHERE group_name = 'BOTS'";
	$result = $db->sql_query($sql);
	$group_id = (int) $db->sql_fetchfield('group_id', false, $result);
	$db->sql_freeresult($result);

	if (!$group_id)
	{
		add_default_groups();

		$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . " WHERE group_name = 'BOTS'";
		$result = $db->sql_query($sql);
		$group_id = (int) $db->sql_fetchfield('group_id', false, $result);
		$db->sql_freeresult($result);

		if (!$group_id)
		{
			trigger_error($user->lang['NO_GROUP_ID']);
		}
	}

	$bots = array(
		'Java [Bad bot]'			=> array('Java/', ''),
		'Thumbshots [Capture]'		=> array('thumbshots-de-Bot', ''),
		'Susie [Sync]'				=> array('!Susie', ''),
		'Google Ads'				=> array('AdsBot-Google', ''),
		'Google Python URL fetcher'	=> array('Python-urllib/', ''),
		'Google Search Appliance'	=> array('gsa', ''),
		'Yahoo! SpiderMan'			=> array('SpiderMan', ''),
		'Yahoo! Mindset'			=> array('Yahoo! Mindset', ''),
		'Yahoo! Blogs'				=> array('Yahoo-Blogs', ''),
		'Yahoo! Feed Seeker'		=> array('YahooFeedSeeker', ''),
		'Yahoo! Multimedia'			=> array('Yahoo-MM', ''),
		'Yahoo! Test'				=> array('Yahoo-Test', ''),
		'Yahoo! VerticalCrawler'	=> array('Yahoo-VerticalCrawler', ''),
		'Fast PartnerSite'			=> array('Fast PartnerSite Crawler', ''),
		'Fast Crawler Gold'			=> array('Fast Crawler Gold Edition', ''),
		'FAST FirstPage retriever'	=> array('FAST FirstPage retriever', ''),
		'FAST MetaWeb'				=> array('FAST MetaWeb Crawler', ''),
		'Yahoo! Search Marketing'	=> array('crawlx', ''),
		'Fast PartnerSite'			=> array('Fast PartnerSite Crawler', ''),
		'Walhello'					=> array('appie', ''),
		'GeoBot'					=> array('GeoBot/version', ''),
		'suchpad'					=> array('http://www.suchpad.de/bot/', ''),
		'Insuranco'					=> array('InsurancoBot', ''),
		'Xaldon'					=> array('Xaldon WebSpider', ''),
		'Cosmix'					=> array('cfetch/', ''),
		'Esperanza'					=> array('EsperanzaBot', ''),
		'EliteSys'					=> array('EliteSys SuperBot/', ''),
		'MP3-Bot'					=> array('MP3-Bot', ''),
		'genie'						=> array('genieBot (', ''),
		'g2'						=> array('g2Crawler', ''),
		'GBSpider'					=> array('GBSpider v', ''),
		'Picsearch'					=> array('psbot/', ''),
		'PlantyNet'					=> array('PlantyNet_WebRobot_V', ''),
		'Twiceler'					=> array('Twiceler www.cuill.com/robots.html', ''),
		'IPG'						=> array('internet-provider-guenstig.de-Bot', ''),
		'WissenOnline'				=> array('WissenOnline-Bot', ''),
		'24spider'					=> array('24spider-Robot', ''),
		'Zerx'						=> array('zerxbot/', ''),
		'LinkWalker'				=> array('LinkWalker', ''),
		'Exabot'					=> array('Exabot/', ''),
		'Jyxobot'					=> array('Jyxobot/', ''),
		'Tbot'						=> array('Tbot/', ''),
		'Findexa Crawler'			=> array('Findexa Crawler (', ''),
		'ISC Systems iRc Search'	=> array('ISC Systems iRc Search', ''),
		'IRLbot'					=> array('http://irl.cs.tamu.edu/crawler', ''),
		'Mirago'					=> array('HeinrichderMiragoRobot (', ''),
		'Sygol'						=> array('SygolBot', ''),
		'WWWeasel'					=> array('WWWeasel Robot v', ''),
		'Naver'						=> array('nhnbot@naver.com', ''),
		'MMSBot'					=> array('http://www.mmsweb.at/bot.html', ''),
		'Hogsearch'					=> array('oegp v. ', ''),
		'Kraehe'					=> array('-DIE-KRAEHE- META-SEARCH-ENGINE/', ''),
		'Vagabondo'					=> array('http://webagent.wise-guys.nl/', ''),
		'Nimble'					=> array('NimbleCrawler', ''),
		'Bunnybot'					=> array('powered by www.buncat.de', ''),
		'Boitho'					=> array('boitho.com-dc/', ''),
		'Scumbot'					=> array('Scumbot/', ''),
		'GeigerzaehlerBot'			=> array('http://www.geigerzaehler.org/bot.html', ''),
		'Orbiter'					=> array('http://www.dailyorbit.com/bot.htm', ''),
		'ASPseek'					=> array('ASPseek/', ''),
		'Crawler Search'			=> array('.Crawler-Search.de', ''),
		'Singingfish Asterias'		=> array('Asterias', ''),
		'NetResearchServer'			=> array('NetResearchServer/', ''),
		'OrangeSpider'				=> array('OrangeSpider', ''),
		'McSeek'					=> array('powered by www.McSeek.de', ''),
		'Accoona'					=> array('Accoona-AI-Agent/', ''),
		'Webmeasurement'			=> array('webmeasurement-bot,', ''),
		'123spider'					=> array('123spider-Bot', ''),
		'Cometrics'					=> array('cometrics-bot,', ''),
		'Houxou'					=> array('HouxouCrawler/', ''),
		'Ocelli'					=> array('Ocelli/', ''),
		'EchO!'						=> array('EchO!/', ''),
		'Gigablast'					=> array('gigablast.com/', ''),
		'SurveyBot'					=> array('SurveyBot/', ''),
		'Marvin Medhunt'			=> array('Marvin', ''),
		'InfoSeek SideWinder'		=> array('Infoseek SideWinder/', ''),
		'InternetSeer'				=> array('InternetSeer', ''),
		'Rambler'					=> array('StackRambler/', ''),
		'Vestris Alkaline'			=> array('AlkalineBOT/', ''),
		'Robozilla'					=> array('Robozilla/', ''),
		'Openfind'					=> array('openfind.com', ''),
		'Diggit!'					=> array('Digger/', ''),
		'Become'					=> array('become.com/', ''),
		'NetSprint'					=> array('NetSprint', ''),
		'Szukacz'					=> array('szukacz', ''),
		'Gooro'						=> array('Gooru-WebSpider', ''),
		'Onet'						=> array('OnetSzukaj', ''),
		'Inktomi'					=> array('Inktomi', ''),
		'Kraehe [Metasuche]'		=> array('-DIE-KRAEHE- META-SEARCH-ENGINE/', ''),
		'SnapPreview [bot]'			=> array('SnapPreviewBot', ''),
		'XML Sitemap Generator [bot]'	=> array('XML Sitemaps Generator', ''),
		'Google Sitemap [bot]'		=> array('GSMA/', ''),
		'Larbin [bot]'				=> array('larbin_2.6.3', ''),
		'Seznam [Bot]'				=> array('SeznamBot', ''),
		'Indy Library [Bot]'		=> array('Indy Library', ''),
		'Crawler0.1 [Crawler]'		=> array('Crawler0.1', ''),
		'VoilaBot [Bot]'			=> array('VoilaBot', ''),
		'Sogou [Bot]'				=> array('Sogou web spider', ''),
		'MWI [bot]'					=> array('MWI-UCE-Checker', ''),
		'Lycos [spider]'			=> array('Lycos_Spider_', ''),
		'Speedy [spider]'			=> array('Speedy Spider', ''),
		'Pagebull'					=> array('Pagebull', ''),
		'panscient [spider]'		=> array('panscient.com', ''),
		'libwww-perl'				=> array('libwww-perl', ''),
		'SBIder [bot]'				=> array('SBIder/', ''),
		'PHP version tracker'		=> array('PHP version tracker', ''),
		'hbtronix [spider]'			=> array('hbtronix.spider', ''),
		'over-zealus [bot]'			=> array('Opera/5.0 (Windows NT 4.0;US)', ''),
		'HP Web PrintSmart'			=> array('HP Web PrintSmart', ''),
	);

	if (!function_exists('user_add'))
	{
		include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
	}

		foreach ($bots as $bot_name => $bot_ary)
	{
		$user_row = array(
			'user_type'				=> USER_IGNORE,
			'group_id'				=> $group_id,
			'username'				=> $bot_name,
			'user_regdate'			=> time(),
			'user_password'			=> '',
			'user_colour'			=> '9E8DA7',
			'user_email'			=> '',
			'user_lang'				=> $config['default_lang'],
			'user_style'			=> 1,
			'user_timezone'			=> 0,
			'user_allow_massemail'	=> 0,
		);

		$user_id = user_add($user_row);

		if ($user_id)
		{
			$sql = 'INSERT INTO ' . BOTS_TABLE . ' ' . $db->sql_build_array('INSERT', array(
				'bot_active'	=> 1,
				'bot_name'		=> $bot_name,
				'user_id'		=> $user_id,
				'bot_agent'		=> $bot_ary[0],
				'bot_ip'		=> $bot_ary[1])
			);
			$db->sql_query($sql);
		}
	}
}

add_bots2();

trigger_error($user->lang['BOTS_ADDED']);	//NOT a real error, this makes it usable with any style, as it displays it in an information page. *credit for this idea goes to Handyman`*

?>