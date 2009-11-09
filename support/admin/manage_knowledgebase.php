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
hesk_checkPermission('can_man_kb');

/* Is Knowledgebase enabled? */
if (!$hesk_settings['kb_enable'])
{
	hesk_error($hesklang['kbdis']);
}

/* What should we do? */
$action=hesk_input($_REQUEST['a']);
if ($action == 'new_article') 		 {new_article();}
elseif ($action == 'new_category') 	 {new_category();}
elseif ($action == 'manage_cat') 	 {manage_category();}
elseif ($action == 'remove_article') {remove_article();}
elseif ($action == 'edit_article') 	 {edit_article();}
elseif ($action == 'save_article') 	 {save_article();}
elseif ($action == 'order_article')	 {order_article();}
elseif ($action == 'edit_category')	 {edit_category();}

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

<h3 align="center"><?php echo $hesklang['kb']; ?></h3>

<p><?php echo $hesklang['kb_intro']; ?></p>

<script src="<?php echo HESK_PATH; ?>/TreeMenu.js" language="JavaScript" type="text/javascript"></script>

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

	<?php
	$sql = 'SELECT * FROM `'.$hesk_settings['db_pfix'].'kb_categories` ORDER BY `parent` ASC, `cat_order` ASC';
	$result = hesk_dbQuery($sql);
	$kb_cat = array();

	while ($cat = hesk_dbFetchAssoc($result))
	{
		$kb_cat[] = $cat;
	}

	/* Translate main category "Knowledgebase" if needed */
	$kb_cat[0]['name'] = $hesklang['kb_text'];

	require(HESK_PATH . 'inc/TreeMenu.php');
	$icon         = 'folder.gif';
	$expandedIcon = 'folder-expanded.gif';
	$menu		  = new HTML_TreeMenu();

	$thislevel = array('0');
	$nextlevel = array();
	$i = 1;
	$j = 1;

	while (count($kb_cat) > 0)
	{

	    foreach ($kb_cat as $k=>$cat)
	    {

	    	if (in_array($cat['parent'],$thislevel))
	        {

	        	$up = $cat['parent'];
	            $my = $cat['id'];
	            $type = $cat['type'] ? '*' : '';

	            $text = $cat['name'].$type.' ('.$cat['articles'].') [ '
	            		.'<a href="#new_article" onclick="document.getElementById(\'option'.$j.'\').selected=true;return true;">'.$hesklang['kb_p_art'].'</a> | '
	                    .'<a href="#new_category" onclick="document.getElementById(\'option'.$j.'_2\').selected=true;return true;">'.$hesklang['kb_p_cat'].'</a> | '
	                    .'<a href="manage_knowledgebase.php?a=manage_cat&catid='.$my.'">'.$hesklang['kb_p_man'].'</a> ]';
	            $text_short = $cat['name'].$type.' ('.$cat['articles'].')';

	            if (isset($node[$up]))
	            {
		            $node[$my] = &$node[$up]->addItem(new HTML_TreeNode(array('text' => $text, 'text_short' => $text_short, 'hesk_catid' => $cat['id'], 'hesk_select' => 'option'.$j, 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true)));
	            }
	            else
	            {
	                $node[$my] = new HTML_TreeNode(array('text' => $text, 'text_short' => $text_short, 'hesk_catid' => $cat['id'], 'hesk_select' => 'option'.$j, 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true));
	            }

		        $nextlevel[] = $cat['id'];
	            $j++;
		        unset($kb_cat[$k]);

	        }

	    }

	    $thislevel = $nextlevel;
	    $nextlevel = array();

	    /* Break after 20 recursions to avoid hang-ups in case of any problems */
	    if ($i > 20)
	    {
	    	break;
	    }
	    $i++;
	}

	$menu->addItem($node[1]);

	// Create the presentation class
	$treeMenu = &new HTML_TreeMenu_DHTML($menu, array('images' => '../img', 'defaultClass' => 'treeMenuDefault', 'isDynamic' => true));
	$listBox  = &new HTML_TreeMenu_Listbox($menu);

	$treeMenu->printMenu();

	?>

	<br />

	<table border="0" cellspacing="1" cellpadding="1">
	<tr>
	<td><b><?php echo $hesklang['legend']; ?></b></td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	</tr>
	<tr>
	<td><?php echo $hesklang['kb_p_art']; ?></td>
    <td>=</td>
	<td><?php echo $hesklang['kb_p_art2']; ?></td>
	</tr>
	<tr>
	<td><?php echo $hesklang['kb_p_cat']; ?></td>
    <td>=</td>
	<td><?php echo $hesklang['kb_p_cat2']; ?></td>
	</tr>
	<tr>
	<td><?php echo $hesklang['kb_p_man']; ?></td>
    <td>=</td>
	<td><?php echo $hesklang['kb_p_man2']; ?></td>
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
</div>

<br /><hr />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

	    <div align="center">
	    <table border="0">
	    <tr>
	    <td>

	    <form action="manage_knowledgebase.php" method="post" name="form1">

		<h3 align="center"><a name="new_article"></a><?php echo $hesklang['new_kb_art']; ?></h3>
	    <br />

		<table border="0">
		<tr>
		<td><b><?php echo $hesklang['kb_cat']; ?>:</b></td>
		<td><select name="catid"><?php $listBox->printMenu()?></select></td>
		</tr>
		<tr>
		<td valign="top"><b><?php echo $hesklang['kb_type']; ?>:</b></td>
		<td>
		<p><label><input type="radio" name="type" value="0" checked="checked" /> <b><i><?php echo $hesklang['kb_published']; ?></i></b></label><br />
		<?php echo $hesklang['kb_published2']; ?></p>
		<p><label><input type="radio" name="type" value="1" /> <b><i><?php echo $hesklang['kb_private']; ?></i></b></label><br />
		<?php echo $hesklang['kb_private2']; ?></p>
		<p><label><input type="radio" name="type" value="2" /> <b><i><?php echo $hesklang['kb_draft']; ?></i></b></label><br />
		<?php echo $hesklang['kb_draft2']; ?><br />&nbsp;</p>
		</td>
		</tr>
		<tr>
		<td><b><?php echo $hesklang['kb_subject']; ?>:</b></td>
		<td><input type="text" name="subject" size="70" maxlength="255" /></td>
		</tr>
		</table>

		<p><b><?php echo $hesklang['kb_content']; ?>:</b><br />
        <label><input type="radio" name="html" value="0" checked="checked" onclick="javascript:document.getElementById('kblinks').style.display = 'none'" /> <?php echo $hesklang['kb_dhtml']; ?></label><br />
        <label><input type="radio" name="html" value="1" onclick="javascript:document.getElementById('kblinks').style.display = 'block'" /> <?php echo $hesklang['kb_ehtml']; ?></label><br />
        <span id="kblinks" style="display:none"><i><?php echo $hesklang['kb_links']; ?></i><br /></span>
		<textarea name="content" rows="25" cols="70"></textarea></p>

		<p align="center"><input type="hidden" name="a" value="new_article" /><input type="submit" value="<?php echo $hesklang['kb_save']; ?>" class="orangebutton" onmouseover="hesk_btn(this,'orangebuttonover');" onmouseout="hesk_btn(this,'orangebutton');" /></p>
		</form>

		</td>
		</tr>
		</table>
	    </div>

	</td>
	<td class="roundcornersright">&nbsp;</td>
	</tr>
	<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
	</tr>
</table>

<br /><hr />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

	    <div align="center">
	    <table border="0">
	    <tr>
	    <td>

		<form action="manage_knowledgebase.php" method="post" name="form2">

		<h3 align="center"><a name="new_category"></a><?php echo $hesklang['kb_cat_new']; ?></h3>
	    <br />

		<table border="0">
		<tr>
		<td><b><?php echo $hesklang['kb_cat_title']; ?>:</b></td>
		<td><input type="text" name="title" size="70" maxlength="255" /></td>
		</tr>
		<tr>
		<td><b><?php echo $hesklang['kb_cat_parent']; ?>:</b></td>
		<td><select name="parent"><?php $listBox->printMenu()?></select></td>
		</tr>
		<tr>
		<td valign="top"><b><?php echo $hesklang['kb_type']; ?>:</b></td>
		<td>
		<p><label><input type="radio" name="type" value="0" checked="checked" /> <b><i><?php echo $hesklang['kb_published']; ?></i></b></label><br />
		<?php echo $hesklang['kb_cat_published']; ?></p>
		<p><label><input type="radio" name="type" value="1" /> <b><i><?php echo $hesklang['kb_private']; ?></i></b></label><br />
		<?php echo $hesklang['kb_cat_private']; ?></p>
		</td>
		</tr>
		</table>

		<p align="center"><input type="hidden" name="a" value="new_category" /><input type="submit" value="<?php echo $hesklang['kb_cat_add']; ?>" class="orangebutton" onmouseover="hesk_btn(this,'orangebuttonover');" onmouseout="hesk_btn(this,'orangebutton');" /></p>
		</form>

		</td>
		</tr>
		</table>
	    </div>

	</td>
	<td class="roundcornersright">&nbsp;</td>
	</tr>
	<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
	</tr>
</table>

<?php
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();


/*** START FUNCTIONS ***/

function edit_category() {
	global $hesk_settings, $hesklang;

	$catid  = hesk_isNumber($_POST['catid'],$hesklang['kb_cat_inv']);
    $title  = hesk_input($_POST['title'],$hesklang['kb_cat_e_title']);
    $parent = hesk_isNumber($_POST['parent']) or $parent = 1;
    $type   = ($_POST['type']) ? 1 : 0;

    /* Delete category or just update it? */
    if (isset($_POST['dodelete']) && $_POST['dodelete']=='Y')
    {
    	/* Delete articles or move to parent category? */
    	if ($_POST['movearticles'] == 'N')
        {
        	$sql = 'DELETE FROM `'.$hesk_settings['db_pfix'].'kb_articles` WHERE `catid`='.$catid;
            hesk_dbQuery($sql);
        }
        else
        {
        	$sql = 'SELECT `id` FROM `'.$hesk_settings['db_pfix'].'kb_articles` WHERE `catid`='.$catid.' AND `type`=\'0\'';
            $res = hesk_dbQuery($sql);
            $num = hesk_dbNumRows($res);

        	$sql = 'UPDATE `'.$hesk_settings['db_pfix'].'kb_articles` SET `catid`='.$parent.' WHERE `catid`='.$catid;
            hesk_dbQuery($sql);

        	$sql = 'UPDATE `'.$hesk_settings['db_pfix'].'kb_categories` SET `articles`=`articles`+'.$num.' WHERE `id`='.$parent.' LIMIT 1';
            hesk_dbQuery($sql);
        }

        /* Delete the category */
        $sql = 'DELETE FROM `'.$hesk_settings['db_pfix'].'kb_categories` WHERE `id`='.$catid.' LIMIT 1';
        hesk_dbQuery($sql);

		$_SESSION['HESK_NOTICE']  = $hesklang['kb_cat_del'];
		$_SESSION['HESK_MESSAGE'] = $hesklang['kb_cat_dlt'];
		Header('Location: manage_knowledgebase.php');
		exit();
    }

	$sql = "UPDATE `".$hesk_settings['db_pfix']."kb_categories` SET `name`='$title',`parent`=$parent,`type`='$type' WHERE `id`=$catid LIMIT 1";
	$result = hesk_dbQuery($sql);

	$_SESSION['HESK_NOTICE']  = $hesklang['kb_cat_mod'];
	$_SESSION['HESK_MESSAGE'] = $hesklang['your_cat_mod'];
	Header('Location: manage_knowledgebase.php?a=manage_cat&catid='.$catid);
	exit();
} // END edit_category()


function save_article() {
	global $hesk_settings, $hesklang;

    $id    = hesk_isNumber($_POST['id'],$hesklang['kb_art_id']);
	$catid = hesk_isNumber($_POST['catid']) or $catid = 1;
    $type  = ($_POST['type'] == 1 || $_POST['type'] == 2) ? $_POST['type'] : 0;
    $html  = $_POST['html'] ? 1 : 0;
    $now   = hesk_date();
    $old_catid = hesk_isNumber($_POST['old_catid']);
    $old_type  = ($_POST['old_type'] == 1 || $_POST['old_type'] == 2) ? $_POST['old_type'] : 0;

    $subject = hesk_input($_POST['subject'],$hesklang['kb_e_subj']);

    if ($html)
    {
	    if (empty($_POST['content']))
	    {
	    	hesk_error($hesklang['kb_e_cont']);
	    }
	    $content = ini_get('magic_quotes_gpc') ? $_POST['content'] : addslashes($_POST['content']);
    }
	else
    {
    	$content = hesk_input($_POST['content'], $hesklang['kb_e_cont']);
	    $content = nl2br($content);
	    $content = hesk_makeURL($content);
    }

    $extra_sql = '';
    if ($_POST['resetviews']=='Y')
    {
    	$extra_sql .= ',`views`=0 ';
    }
    if ($_POST['resetvotes']=='Y')
    {
    	$extra_sql .= ',`votes`=0, `rating`=0 ';
    }

    /* Update article in the database */
    $revision = addslashes(sprintf($hesklang['revision2'],$now,$_SESSION['user'].' ('.$_SESSION['name'].')'));
	$sql = "UPDATE `".$hesk_settings['db_pfix']."kb_articles` SET `catid`=$catid,`subject`='$subject',`content`='$content' $extra_sql ,`type`='$type',`html`='$html',`history`=CONCAT(`history`,'$revision') WHERE `id`=$id LIMIT 1";
	$result = hesk_dbQuery($sql);

	/* Update proper category article count */
    if ($type == $old_type)
    {
    	if ($type == 0 && ($catid != $old_catid))
        {
		    $sql = 'UPDATE `'.$hesk_settings['db_pfix'].'kb_categories` SET `articles`=`articles`+1 WHERE `id`='.$catid;
			$result = hesk_dbQuery($sql);

		    $sql = 'UPDATE `'.$hesk_settings['db_pfix'].'kb_categories` SET `articles`=`articles`-1 WHERE `id`='.$old_catid;
			$result = hesk_dbQuery($sql);
        }
    }
    else
    {
    	if ($old_type == 0)
        {
		    $sql = 'UPDATE `'.$hesk_settings['db_pfix'].'kb_categories` SET `articles`=`articles`-1 WHERE `id`='.$old_catid;
            $result = hesk_dbQuery($sql);
        }
        else
        {
		    $sql = 'UPDATE `'.$hesk_settings['db_pfix'].'kb_categories` SET `articles`=`articles`+1 WHERE `id`='.$catid;
            $result = hesk_dbQuery($sql);
        }
    }

	$_SESSION['HESK_NOTICE']  = $hesklang['kb_art_mod'];
	$_SESSION['HESK_MESSAGE'] = $hesklang['your_kb_mod'];
	Header('Location: manage_knowledgebase.php?a=manage_cat&catid='.$catid);
	exit();
} // END save_article()


function edit_article() {
	global $hesk_settings, $hesklang;

    $id = hesk_isNumber($_GET['id'],$hesklang['kb_cat_inv']);

    /* Get article details */
	$sql = 'SELECT * FROM `'.$hesk_settings['db_pfix'].'kb_articles` WHERE `id`='.$id.' LIMIT 1';
	$result = hesk_dbQuery($sql);

    if (hesk_dbNumRows($result) != 1)
    {
    	hesk_error($hesklang['kb_art_id']);
    }

    $article = hesk_dbFetchAssoc($result);

    if ($article['html'])
    {
		$article['content'] = htmlspecialchars(stripslashes($article['content']));
    }
    else
    {
		$from = array('/\<a href="mailto\:([^"]*)"\>([^\<]*)\<\/a\>/i', '/\<a href="([^"]*)" target="_blank"\>([^\<]*)\<\/a\>/i');
		$to   = array("$1", "$1");
		$article['content'] = preg_replace($from,$to,$article['content']);
		$article['content'] = str_replace('<br />','',$article['content']);
		$article['content'] = stripslashes($article['content']);
    }
    $catid = $article['catid'];

    /* Get categories */
	$sql = 'SELECT * FROM `'.$hesk_settings['db_pfix'].'kb_categories` ORDER BY `parent` ASC, `cat_order` ASC';
	$result = hesk_dbQuery($sql);
	$kb_cat = array();

	while ($cat = hesk_dbFetchAssoc($result))
	{
		$kb_cat[] = $cat;
        if ($cat['id'] == $catid)
        {
        	$this_cat = $cat;
            $this_cat['parent'] = $catid;
        }
	}

	/* Translate main category "Knowledgebase" if needed */
	$kb_cat[0]['name'] = $hesklang['kb_text'];

	require(HESK_PATH . 'inc/TreeMenu.php');
	$icon         = HESK_PATH . 'img/folder.gif';
	$expandedIcon = HESK_PATH . 'img/folder-expanded.gif';
    $menu		  = new HTML_TreeMenu();

	$thislevel = array('0');
	$nextlevel = array();
	$i = 1;
	$j = 1;

	while (count($kb_cat) > 0)
	{

	    foreach ($kb_cat as $k=>$cat)
	    {

	    	if (in_array($cat['parent'],$thislevel))
	        {

	        	$up = $cat['parent'];
	            $my = $cat['id'];
	            $type = $cat['type'] ? '*' : '';

	            $text_short = $cat['name'].$type.' ('.$cat['articles'].')';

	            if (isset($node[$up]))
	            {
		            $node[$my] = &$node[$up]->addItem(new HTML_TreeNode(array('hesk_parent' => $this_cat['parent'], 'text' => 'Text', 'text_short' => $text_short, 'hesk_catid' => $cat['id'], 'hesk_select' => 'option'.$j, 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true)));
	            }
	            else
	            {
	                $node[$my] = new HTML_TreeNode(array('hesk_parent' => $this_cat['parent'], 'text' => 'Text',  'text_short' => $text_short, 'hesk_catid' => $cat['id'], 'hesk_select' => 'option'.$j, 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true));
	            }

		        $nextlevel[] = $cat['id'];
	            $j++;
		        unset($kb_cat[$k]);

	        }

	    }

	    $thislevel = $nextlevel;
	    $nextlevel = array();

	    /* Break after 20 recursions to avoid hang-ups in case of any problems */

	    if ($i > 20)
	    {
	    	break;
	    }
	    $i++;
	}

	$menu->addItem($node[1]);

	// Create the presentation class
	$listBox  = &new HTML_TreeMenu_Listbox($menu);

	/* Print header */
	require_once(HESK_PATH . 'inc/header.inc.php');

	/* Print main manage users page */
	require_once(HESK_PATH . 'inc/show_admin_nav.inc.php');
	?>

	</td>
	</tr>
	<tr>
	<td>

	<p><span class="smaller"><a href="manage_knowledgebase.php" class="smaller"><?php echo $hesklang['menu_kb']; ?></a> &gt;
    <a href="manage_knowledgebase.php?a=manage_cat&amp;catid=<?php echo $catid; ?>" class="smaller"><?php echo $hesklang['kb_cat_man']; ?></a> &gt; <?php echo $hesklang['kb_art_edit']; ?></span></p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

	    <div align="center">
	    <table border="0">
	    <tr>
	    <td>

		<h3 align="center"><?php echo $hesklang['kb_art_edit']; ?></h3>
        <br />

		<form action="manage_knowledgebase.php" method="post" name="form1">

		<table border="0">
		<tr>
		<td><b><?php echo $hesklang['kb_cat']; ?>:</b></td>
		<td><select name="catid"><?php $listBox->printMenu()?></select></td>
		</tr>
		<tr>
		<td valign="top"><b><?php echo $hesklang['kb_type']; ?>:</b></td>
		<td>
		<p><label><input type="radio" name="type" value="0" <?php if ($article['type']==0) {echo 'checked="checked"';} ?> /> <b><i><?php echo $hesklang['kb_published']; ?></i></b></label><br />
		<?php echo $hesklang['kb_published2']; ?></p>
		<p><label><input type="radio" name="type" value="1" <?php if ($article['type']==1) {echo 'checked="checked"';} ?> /> <b><i><?php echo $hesklang['kb_private']; ?></i></b></label><br />
		<?php echo $hesklang['kb_private2']; ?></p>
		<p><label><input type="radio" name="type" value="2" <?php if ($article['type']==2) {echo 'checked="checked"';} ?> /> <b><i><?php echo $hesklang['kb_draft']; ?></i></b></label><br />
		<?php echo $hesklang['kb_draft2']; ?><br />&nbsp;</p>
		</td>
		</tr>
		<tr>
		<td><b><?php echo $hesklang['kb_subject']; ?>:</b></td>
		<td><input type="text" name="subject" size="70" maxlength="255" value="<?php echo $article['subject']; ?>" /></td>
		</tr>
		<tr>
		<td valign="top"><b><?php echo $hesklang['opt']; ?>:</b></td>
		<td>
		<p><label><input type="checkbox" name="resetviews" value="Y" /> <i><?php echo $hesklang['rv']; ?></i></label><br />
	    <label><input type="checkbox" name="resetvotes" value="Y" /> <i><?php echo $hesklang['rr']; ?></i></label></p>
		</td>
		</tr>
		</table>

		<p><b><?php echo $hesklang['kb_content']; ?>:</b><br />
        <label><input type="radio" name="html" value="0" <?php if (!$article['html']) {echo 'checked="checked"';} ?> onclick="javascript:document.getElementById('kblinks').style.display = 'none'" /> <?php echo $hesklang['kb_dhtml']; ?></label><br />
        <label><input type="radio" name="html" value="1" <?php if ($article['html']) {echo 'checked="checked"';} ?> onclick="javascript:document.getElementById('kblinks').style.display = 'block'" /> <?php echo $hesklang['kb_ehtml']; ?></label><br />
        <span id="kblinks" style="display: <?php echo $article['html'] ? 'block' : 'none'  ?>"><i><?php echo $hesklang['kb_links']; ?></i><br /></span>
		<textarea name="content" rows="25" cols="70"><?php echo $article['content']; ?></textarea></p>

		<p align="center"><input type="hidden" name="a" value="save_article" />
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /><input type="hidden" name="old_type" value="<?php echo $article['type']; ?>" />
	    <input type="hidden" name="old_catid" value="<?php echo $catid; ?>" /><input type="submit" value="<?php echo $hesklang['kb_save']; ?>" class="orangebutton" onmouseover="hesk_btn(this,'orangebuttonover');" onmouseout="hesk_btn(this,'orangebutton');" /></p>
		</form>

		</td>
		</tr>
		</table>
	    </div>

	</td>
	<td class="roundcornersright">&nbsp;</td>
	</tr>
	<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
	</tr>
</table>

	    <br /><hr />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

    	<h3><?php echo $hesklang['revhist']; ?></h3>

		<ul><?php echo $article['history']; ?></ul>

	</td>
	<td class="roundcornersright">&nbsp;</td>
	</tr>
	<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
	</tr>
</table>

	<?php
    require_once(HESK_PATH . 'inc/footer.inc.php');
    exit();
} // END edit_article()


function manage_category() {
	global $hesk_settings, $hesklang;

    $catid = hesk_isNumber($_GET['catid'],$hesklang['kb_cat_inv']);

	$sql = 'SELECT * FROM `'.$hesk_settings['db_pfix'].'kb_categories` ORDER BY `parent` ASC, `cat_order` ASC';
	$result = hesk_dbQuery($sql);
	$kb_cat = array();

	while ($cat = hesk_dbFetchAssoc($result))
	{
		$kb_cat[] = $cat;
        if ($cat['id'] == $catid)
        {
        	$this_cat = $cat;
        }
	}

	/* Translate main category "Knowledgebase" if needed */
	$kb_cat[0]['name'] = $hesklang['kb_text'];

	require(HESK_PATH . 'inc/TreeMenu.php');
	$icon         = HESK_PATH . 'img/folder.gif';
	$expandedIcon = HESK_PATH . 'img/folder-expanded.gif';
    $menu		  = new HTML_TreeMenu();

	$thislevel = array('0');
	$nextlevel = array();
	$i = 1;
	$j = 1;

	while (count($kb_cat) > 0)
	{

	    foreach ($kb_cat as $k=>$cat)
	    {

	    	if (in_array($cat['parent'],$thislevel))
	        {

	        	$up = $cat['parent'];
	            $my = $cat['id'];
	            $type = $cat['type'] ? '*' : '';

	            $text_short = $cat['name'].$type.' ('.$cat['articles'].')';

	            if (isset($node[$up]))
	            {
		            $node[$my] = &$node[$up]->addItem(new HTML_TreeNode(array('hesk_parent' => $this_cat['parent'], 'text' => 'Text', 'text_short' => $text_short, 'hesk_catid' => $cat['id'], 'hesk_select' => 'option'.$j, 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true)));
	            }
	            else
	            {
	                $node[$my] = new HTML_TreeNode(array('hesk_parent' => $this_cat['parent'], 'text' => 'Text',  'text_short' => $text_short, 'hesk_catid' => $cat['id'], 'hesk_select' => 'option'.$j, 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true));
	            }

		        $nextlevel[] = $cat['id'];
	            $j++;
		        unset($kb_cat[$k]);

	        }

	    }

	    $thislevel = $nextlevel;
	    $nextlevel = array();

	    /* Break after 20 recursions to avoid hang-ups in case of any problems */

	    if ($i > 20)
	    {
	    	break;
	    }
	    $i++;
	}

	$menu->addItem($node[1]);

	// Create the presentation class
	$listBox  = &new HTML_TreeMenu_Listbox($menu);

	/* Print header */
	require_once(HESK_PATH . 'inc/header.inc.php');

	/* Print main manage users page */
	require_once(HESK_PATH . 'inc/show_admin_nav.inc.php');
	?>

	</td>
	</tr>
	<tr>
	<td>

    <p><span class="smaller"><a href="manage_knowledgebase.php" class="smaller"><?php echo $hesklang['menu_kb']; ?></a> &gt; <?php echo $hesklang['kb_cat_man']; ?></span></p>


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

    <h3 align="center"><?php echo $hesklang['kb_cat_art']; ?></h3>
    <br />

    <?php
    $sql = 'SELECT * FROM `'.$hesk_settings['db_pfix'].'kb_articles` WHERE `catid`='.$catid.' ORDER BY `art_order` ASC';
	$result = hesk_dbQuery($sql);
    $num	= hesk_dbNumRows($result);

    if ($num == 0)
    {
    	echo '<p>'.$hesklang['kb_no_art'].'</p>';
    }
    else
    {
    	?>
		<div align="center">
		<table border="0" width="100%" cellspacing="1" cellpadding="3" class="white">
		<tr>
        <th class="admin_white">&nbsp;</th>
		<th class="admin_white"><b><i><?php echo $hesklang['kb_subject']; ?></i></b></th>
		<th class="admin_white"><b><i><?php echo $hesklang['kb_type']; ?></i></b></th>
        <th class="admin_white"><b><i><?php echo $hesklang['views']; ?></i></b></th>
        <?php
        if ($hesk_settings['kb_rating'])
        {
        ?>
        <th class="admin_white"><b><i><?php echo $hesklang['rating'].' ('.$hesklang['votes'].')'; ?></i></b></th>
        <?php
        }
        ?>
        <th class="admin_white">&nbsp;</th>
		</tr>
    	<?php

		$i=1;
        $j=1;

		while ($article=hesk_dbFetchAssoc($result))
		{
        	$color = $i ? 'admin_white' : 'admin_gray';
            $i	   = $i ? 0 : 1;

        	switch ($article['type'])
            {
            	case '1':
                	$type = $hesklang['kb_private'];
                	break;
                case '2':
                	$type = $hesklang['kb_draft'];
                	break;
                default:
                	$type = $hesklang['kb_published'];
            }

            if ($hesk_settings['kb_rating'])
            {
	            $alt = $article['rating'] ? sprintf($hesklang['kb_rated'], sprintf("%01.1f", $article['rating'])) : $hesklang['kb_not_rated'];
	            $rat = '<td class="'.$color.'" style="white-space:nowrap;"><img src="../img/star_'.(hesk_round_to_half($article['rating'])*10).'.png" width="85" height="16" alt="'.$alt.'" title="'.$alt.'" border="0" style="vertical-align:text-bottom" /> ('.$article['votes'].')</td>';
            }
            else
            {
            	$rat = '';
            }

        	?>
			<tr>
			<td class="<?php echo $color; ?>"><?php echo $j; ?>.</td>
			<td class="<?php echo $color; ?>"><?php echo $article['subject']; ?></td>
            <td class="<?php echo $color; ?>"><?php echo $type; ?></td>
            <td class="<?php echo $color; ?>"><?php echo $article['views']; ?></td>
            <?php echo $rat; ?>
            <td class="<?php echo $color; ?>" style="text-align:center; white-space:nowrap;">
			<?php
            if ($num > 1)
            {
            	if ($j == 1)
                {
	            ?>
                    <img src="../img/blank.gif" width="16" height="16" alt="" border="0" />
                	<a href="manage_knowledgebase.php?a=order_article&amp;id=<?php echo $article['id']; ?>&amp;catid=<?php echo $catid; ?>&amp;move=15"><img src="../img/move_down.png" width="16" height="16" alt="<?php echo $hesklang['move_dn']; ?>" title="<?php echo $hesklang['move_dn']; ?>" border="0" /></a>
	            <?php
                }
                elseif ($j == $num)
                {
	            ?>
					<a href="manage_knowledgebase.php?a=order_article&amp;id=<?php echo $article['id']; ?>&amp;catid=<?php echo $catid; ?>&amp;move=-15"><img src="../img/move_up.png" width="16" height="16" alt="<?php echo $hesklang['move_up']; ?>" title="<?php echo $hesklang['move_up']; ?>" border="0" /></a>
                    <img src="../img/blank.gif" width="16" height="16" alt="" border="0" />
	            <?php
                }
                else
                {
	            ?>
					<a href="manage_knowledgebase.php?a=order_article&amp;id=<?php echo $article['id']; ?>&amp;catid=<?php echo $catid; ?>&amp;move=-15"><img src="../img/move_up.png" width="16" height="16" alt="<?php echo $hesklang['move_up']; ?>" title="<?php echo $hesklang['move_up']; ?>" border="0" /></a>
					<a href="manage_knowledgebase.php?a=order_article&amp;id=<?php echo $article['id']; ?>&amp;catid=<?php echo $catid; ?>&amp;move=15"><img src="../img/move_down.png" width="16" height="16" alt="<?php echo $hesklang['move_dn']; ?>" title="<?php echo $hesklang['move_dn']; ?>" border="0" /></a>
	            <?php
                }
            }
            else
            {
            	echo '<img src="../img/blank.gif" width="16" height="16" alt="" border="0" />';
            }
            ?>
            <a href="manage_knowledgebase.php?a=edit_article&amp;id=<?php echo $article['id']; ?>"><img src="../img/edit.png" width="16" height="16" alt="<?php echo $hesklang['edit']; ?>" title="<?php echo $hesklang['edit']; ?>" border="0" /></a>
            <a href="manage_knowledgebase.php?a=remove_article&amp;id=<?php echo $article['id']; ?>" onclick="return hesk_confirmExecute('<?php echo $hesklang['del_art']; ?>');"><img src="../img/delete.png" width="16" height="16" alt="<?php echo $hesklang['delete']; ?>" title="<?php echo $hesklang['delete']; ?>" border="0" /></a>&nbsp;</td>
			</tr>
            <?php
			$j++;
		} // End while
		?>
		</table>
		</div>
		<?php
    }
    ?>
        <br /><hr />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="7" height="7"><img src="../img/roundcornerslt.jpg" width="7" height="7" alt="" /></td>
		<td class="roundcornerstop"></td>
		<td><img src="../img/roundcornersrt.jpg" width="7" height="7" alt="" /></td>
	</tr>
	<tr>
	<td class="roundcornersleft">&nbsp;</td>
	<td>

	<h3 align="center"><?php echo $hesklang['kb_cat_man']; ?></h3>
    <br />

    <?php
    if ($catid == 1)
    {
		echo '<p align="center"><i>'.$hesklang['kb_main'].'</i></p>';
    } // END if catid == 1
    else
    {
    	?>
		<form action="manage_knowledgebase.php" method="post" name="form1" onsubmit="Javascript:return hesk_deleteIfSelected('dodelete','<?php echo addslashes($hesklang['kb_delcat']); ?>')">

		<div align="center">
		<table border="0">
		<tr>
		<td>

		<table border="0">
		<tr>
		<td><b><?php echo $hesklang['kb_cat_title']; ?>:</b></td>
		<td><input type="text" name="title" size="70" maxlength="255" value="<?php echo $this_cat['name']; ?>" /></td>
		</tr>
		<tr>
		<td><b><?php echo $hesklang['kb_cat_parent']; ?>:</b></td>
		<td><select name="parent"><?php $listBox->printMenu();  ?></select></td>
		</tr>
		<tr>
		<td valign="top"><b><?php echo $hesklang['kb_type']; ?>:</b></td>
		<td>
			<p><label><input type="radio" name="type" value="0" <?php if (!$this_cat['type']) {echo 'checked="checked"';} ?> /> <b><i><?php echo $hesklang['kb_published']; ?></i></b></label><br />
			<?php echo $hesklang['kb_cat_published']; ?></p>
			<p><label><input type="radio" name="type" value="1" <?php if ($this_cat['type']) {echo 'checked="checked"';} ?> /> <b><i><?php echo $hesklang['kb_private']; ?></i></b></label><br />
			<?php echo $hesklang['kb_cat_private']; ?><br />&nbsp;</p>
		</td>
		</tr>
        <tr>
        <td valign="top"><b><?php echo $hesklang['opt']; ?>:</b></td>
        <td>
        	<p><label><input type="checkbox" name="dodelete" id="dodelete" value="Y" onclick="Javascript:hesk_toggleLayerDisplay('deleteoptions')" /> <i><?php echo $hesklang['delcat']; ?></i></label></p>
            <div id="deleteoptions" style="display: none;">
            <p>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="movearticles" value="Y" checked="checked" /> <?php echo $hesklang['move1']; ?></label><br />
            &nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="movearticles" value="N" /> <?php echo $hesklang['move2']; ?></label></p>
            </div>
        </td>
        </tr>
		</table>

		</td>
		</tr>
		</table>
		</div>

		<p align="center"><input type="hidden" name="a" value="edit_category" /><input type="hidden" name="catid" value="<?php echo $catid; ?>" /><input type="submit" value="<?php echo $hesklang['save_changes']; ?>" class="orangebutton" onmouseover="hesk_btn(this,'orangebuttonover');" onmouseout="hesk_btn(this,'orangebutton');" /></p>
		</form>

        <p>&nbsp;</p>
    	<?php
    } // END else
    ?>

	</td>
	<td class="roundcornersright">&nbsp;</td>
	</tr>
	<tr>
	<td><img src="../img/roundcornerslb.jpg" width="7" height="7" alt="" /></td>
	<td class="roundcornersbottom"></td>
	<td width="7" height="7"><img src="../img/roundcornersrb.jpg" width="7" height="7" alt="" /></td>
	</tr>
</table>

	<?php
    require_once(HESK_PATH . 'inc/footer.inc.php');
    exit();
} // END manage_category()


function new_category() {
	global $hesk_settings, $hesklang;

    $title  = hesk_input($_POST['title'],$hesklang['kb_cat_e_title']);
    $parent = hesk_isNumber($_POST['parent']) or $parent = 1;
    $type   = ($_POST['type']) ? 1 : 0;

	/* Get the latest reply_order */
	$sql = 'SELECT `cat_order` FROM `'.$hesk_settings['db_pfix'].'kb_categories` ORDER BY `cat_order` DESC LIMIT 1';
	$result = hesk_dbQuery($sql);
	$row = hesk_dbFetchRow($result);
	$my_order = $row[0]+10;

	$sql = "INSERT INTO `".$hesk_settings['db_pfix']."kb_categories` (`name`,`parent`,`cat_order`,`type`) VALUES ('$title','$parent','$my_order','$type')";
	$result = hesk_dbQuery($sql);

	$_SESSION['HESK_NOTICE']  = $hesklang['kb_cat_added'];
	$_SESSION['HESK_MESSAGE'] = $hesklang['kb_cat_added2'];
	Header('Location: manage_knowledgebase.php');
	exit();
} // End new_category()


function new_article() {
	global $hesk_settings, $hesklang;

	$catid = hesk_isNumber($_POST['catid']) or $catid = 1;
    $type  = ($_POST['type'] == 1 || $_POST['type'] == 2) ? $_POST['type'] : 0;
    $html  = $_POST['html'] ? 1 : 0;
    $now   = hesk_date();

    $subject = hesk_input($_POST['subject'],$hesklang['kb_e_subj']);

    if ($html)
    {
	    if (empty($_POST['content']))
	    {
	    	hesk_error($hesklang['kb_e_cont']);
	    }
	    $content = ini_get('magic_quotes_gpc') ? $_POST['content'] : addslashes($_POST['content']);
    }
	else
    {
    	$content = hesk_input($_POST['content'], $hesklang['kb_e_cont']);
	    $content = nl2br($content);
	    $content = hesk_makeURL($content);
    }

    $revision = addslashes(sprintf($hesklang['revision1'],$now,$_SESSION['user'].' ('.$_SESSION['name'].')'));

	/* Get the latest reply_order */
	$sql = 'SELECT `art_order` FROM `'.$hesk_settings['db_pfix'].'kb_articles` WHERE `catid`='.$catid.' ORDER BY `art_order` DESC LIMIT 1';
	$result = hesk_dbQuery($sql);
	$row = hesk_dbFetchRow($result);
	$my_order = $row[0]+10;

    /* Insert article into database */
	$sql = "INSERT INTO `".$hesk_settings['db_pfix']."kb_articles` (`catid`,`dt`,`author`,`subject`,`content`,`type`,`html`,`art_order`,`history`) VALUES ('$catid',NOW(),'$_SESSION[id]','$subject','$content','$type','$html','$my_order','$revision')";
	$result = hesk_dbQuery($sql);

	/* Update category article count */
    if ($type == 0)
    {
	    $sql = 'UPDATE `'.$hesk_settings['db_pfix'].'kb_categories` SET `articles`=`articles`+1 WHERE `id`='.$catid;
		$result = hesk_dbQuery($sql);
	}

	$_SESSION['HESK_NOTICE']  = $hesklang['kb_art_added'];
	$_SESSION['HESK_MESSAGE'] = $hesklang['your_kb_added'];
	Header('Location: manage_knowledgebase.php');
	exit();
} // End new_article()


function remove_article() {
	global $hesk_settings, $hesklang;

	$id = hesk_isNumber($_GET['id'],$hesklang['kb_art_id']);

    /* Get article details */
	$sql = 'SELECT * FROM `'.$hesk_settings['db_pfix'].'kb_articles` WHERE `id`='.$id.' LIMIT 1';
	$result = hesk_dbQuery($sql);

    if (hesk_dbNumRows($result) != 1)
    {
    	hesk_error($hesklang['kb_art_id']);
    }

    $article = hesk_dbFetchAssoc($result);
	$catid = $article['catid'];

    $sql = 'DELETE FROM `'.$hesk_settings['db_pfix'].'kb_articles` WHERE `id`='.$id.' LIMIT 1';
    $result = hesk_dbQuery($sql);

    /* Update category article count */
    if ($article['type'] == 0)
	{
    	$sql = 'UPDATE `'.$hesk_settings['db_pfix'].'kb_categories` SET `articles`=`articles`-1 WHERE `id`='.$catid;
		$result = hesk_dbQuery($sql);
    }

	$_SESSION['HESK_NOTICE']  = $hesklang['kb_art_deleted'];
	$_SESSION['HESK_MESSAGE'] = $hesklang['your_kb_deleted'];
	Header('Location: manage_knowledgebase.php?a=manage_cat&catid='.$catid);
	exit();
} // End remove_article()


function order_article() {
	global $hesk_settings, $hesklang;

	$id    = hesk_isNumber($_GET['id'],$hesklang['kb_art_id']);
    $catid = hesk_isNumber($_GET['catid'],$hesklang['kb_cat_inv']);
	$move  = intval($_GET['move']);

	$sql = "UPDATE `".$hesk_settings['db_pfix']."kb_articles` SET `art_order`=`art_order`+$move WHERE `id`=$id LIMIT 1";
	$result = hesk_dbQuery($sql);
	if (hesk_dbAffectedRows() != 1)
    {
    	hesk_error($hesklang['kb_art_id']);
    }

	/* Update all category fields with new order */
	$sql = 'SELECT `id` FROM `'.$hesk_settings['db_pfix'].'kb_articles` WHERE `catid`='.$catid.' ORDER BY `art_order` ASC';
	$result = hesk_dbQuery($sql);

	$i = 10;
	while ($article=hesk_dbFetchAssoc($result))
	{
	    $sql = "UPDATE `".$hesk_settings['db_pfix']."kb_articles` SET `art_order`=$i WHERE `id`=$article[id] LIMIT 1";
	    hesk_dbQuery($sql);
	    $i += 10;
	}

	Header('Location: manage_knowledgebase.php?a=manage_cat&catid='.$catid);
	exit();
} // End order_article()
?>
