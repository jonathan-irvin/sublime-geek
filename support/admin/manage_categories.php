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
hesk_checkPermission('can_man_cat');

/* What should we do? */
$action=hesk_input($_REQUEST['a']);
if ($action == 'new') {new_cat();}
elseif ($action == 'rename') {rename_cat();}
elseif ($action == 'remove') {remove();}
elseif ($action == 'order') {order_cat();}

/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');

/* Print main manage users page */
require_once(HESK_PATH . 'inc/show_admin_nav.inc.php');
?>

</td>
</tr>
<tr>
<td>

<script language="Javascript" type="text/javascript"><!--
function confirm_delete()
{
if (confirm('<?php echo $hesklang['confirm_del_cat']; ?>')) {return true;}
else {return false;}
}
//-->
</script>

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
	<?php
	        unset($_SESSION['HESK_NOTICE']);
	        unset($_SESSION['HESK_MESSAGE']);
	    }
	?>

<h3 align="center"><?php echo $hesklang['manage_cat']; ?></h3>

<p><?php echo $hesklang['cat_intro']; ?>.</p>

<div align="center">
<table border="0" cellspacing="1" cellpadding="3" class="white">
<tr>
<th class="admin_white"><b><i><?php echo $hesklang['cat_name']; ?></i></b></th>
<th class="admin_white"><b><i><?php echo $hesklang['not']; ?></i></b></th>
<th class="admin_white"><b><i><?php echo $hesklang['graph']; ?></i></b></th>
<th class="admin_white">&nbsp;</th>
</tr>

<?php
$sql = 'SELECT COUNT(*) AS `cnt`, `category` FROM `'.$hesk_settings['db_pfix'].'tickets` GROUP BY `category` ORDER BY `cnt` DESC';
$res = hesk_dbQuery($sql);
$line_width  = 150;
$max_tickets = 0;
while ($tmp = hesk_dbFetchAssoc($res))
{
	if (!$max_tickets && $tmp['cnt'])
    {
    	$max_tickets = $tmp['cnt'];
    }
	$number_of_tickets[$tmp['category']] = $tmp['cnt'];
}

$sql = "SELECT * FROM `".$hesk_settings['db_pfix']."categories` ORDER BY `cat_order` ASC";
$result = hesk_dbQuery($sql);
$options='';

$i=1;
$j=0;
$num = hesk_dbNumRows($result);

while ($mycat=hesk_dbFetchAssoc($result))
{
	$j++;

	$color = $i ? 'admin_white' : 'admin_gray';
	$i	   = $i ? 0 : 1;

    /* Deleting category with ID 1 (default category) is not allowed */
    if ($mycat['id'] == 1)
    {
        $remove_code=' <img src="../img/blank.gif" width="16" height="16" alt="" border="0" />';
    }
    else
    {
        $remove_code=' <a href="manage_categories.php?a=remove&amp;id='.$mycat['id'].'" onclick="return confirm_delete();"><img src="../img/delete.png" width="16" height="16" alt="'.$hesklang['remove'].'" title="'.$hesklang['remove'].'" border="0" /></a>';
    }

    $options .= '<option value="'.$mycat['id'].'">'.$mycat['name'].'</option>';

	echo '
	<tr>
	<td class="'.$color.'">'.$mycat['name'].'</td>
	';

	$tickets = $number_of_tickets[$mycat['id']] ? $number_of_tickets[$mycat['id']] : 0;
	if ($max_tickets)
    {
    	$width = ceil($line_width * $tickets / $max_tickets)+1;
    }
    else
    {
    	$width = 1;
    }
    echo '
	<td class="'.$color.'" style="text-align:center">'.$tickets.'</td>
    <td class="'.$color.'" width="1"><img src="../img/line_graph.gif" height="5" width="'.$width.'" border="0" alt="" style="text-align:bottom" /></td>
    <td class="'.$color.'" style="text-align:center; white-space:nowrap;">';

	if ($num > 1)
	{
		if ($j == 1)
		{
			echo'<img src="../img/blank.gif" width="16" height="16" alt="" border="0" /> <a href="manage_categories.php?a=order&amp;catid='.$mycat['id'].'&amp;move=15"><img src="../img/move_down.png" width="16" height="16" alt="'.$hesklang['move_dn'].'" title="'.$hesklang['move_dn'].'" border="0" /></a>';
		}
		elseif ($j == $num)
		{
			echo'<a href="manage_categories.php?a=order&amp;catid='.$mycat['id'].'&amp;move=-15"><img src="../img/move_up.png" width="16" height="16" alt="'.$hesklang['move_up'].'" title="'.$hesklang['move_up'].'" border="0" /></a> <img src="../img/blank.gif" width="16" height="16" alt="" border="0" />';
		}
		else
		{
			echo'
			<a href="manage_categories.php?a=order&amp;catid='.$mycat['id'].'&amp;move=-15"><img src="../img/move_up.png" width="16" height="16" alt="'.$hesklang['move_up'].'" title="'.$hesklang['move_up'].'" border="0" /></a>
			<a href="manage_categories.php?a=order&amp;catid='.$mycat['id'].'&amp;move=15"><img src="../img/move_down.png" width="16" height="16" alt="'.$hesklang['move_dn'].'" title="'.$hesklang['move_dn'].'" border="0" /></a>
			';
		}
	}

    echo $remove_code.'</td>
	</tr>
	';

} // End while

?>
</table>
</div>

<p>&nbsp;</p>

<hr />

<form action="manage_categories.php" method="post">
<p style="text-align:center"><b><?php echo $hesklang['add_cat']; ?>:</b> (<?php echo $hesklang['max_chars']; ?>)
<input type="text" name="name" size="30" maxlength="40" /><input type="hidden" name="a" value="new" />
<input type="submit" value="<?php echo $hesklang['create_cat']; ?>" class="orangebutton" onmouseover="hesk_btn(this,'orangebuttonover');" onmouseout="hesk_btn(this,'orangebutton');" /></p>
</form>

<hr />

<form action="manage_categories.php" method="post">
<p align="center"><?php echo $hesklang['ren_cat']; ?> <select name="catid"><?php
echo $options;
?></select> <?php echo $hesklang['to']; ?> <input type="text" name="name" size="30" maxlength="40" /><input type="hidden" name="a" value="rename" />
<input type="submit" value="<?php echo $hesklang['ren_cat']; ?>" class="orangebutton" onmouseover="hesk_btn(this,'orangebuttonover');" onmouseout="hesk_btn(this,'orangebutton');" /></p>
</form>

<p>&nbsp;</p>

<!-- HR -->
<p>&nbsp;</p>

<?php
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();


/*** START FUNCTIONS ***/

function new_cat() {
	global $hesk_settings, $hesklang;

	$catname=hesk_Input($_POST['name'],$hesklang['enter_cat_name']);

	/* Get the latest cat_order */
	$sql = "SELECT `cat_order` FROM `".$hesk_settings['db_pfix']."categories` ORDER BY `cat_order` DESC LIMIT 1";
	$result = hesk_dbQuery($sql);
	$row = hesk_dbFetchRow($result);
	$my_order = $row[0]+10;

	$sql = "INSERT INTO `".$hesk_settings['db_pfix']."categories` (`name`,`cat_order`) VALUES ('$catname','$my_order')";
	$result = hesk_dbQuery($sql);

	$_SESSION['HESK_NOTICE']  = $hesklang['cat_added'];
	$_SESSION['HESK_MESSAGE'] = sprintf($hesklang['cat_name_added'],'<i>'.$catname.'</i>');
	Header('Location: manage_categories.php');
	exit();
} // End new_cat()


function rename_cat() {
	global $hesk_settings, $hesklang;

	$catid=hesk_isNumber($_POST['catid'],$hesklang['choose_cat_ren']);
	$catname=hesk_Input($_POST['name'],$hesklang['cat_ren_name']);

	$sql = "UPDATE `".$hesk_settings['db_pfix']."categories` SET `name`='$catname' WHERE `id`=$catid LIMIT 1";
	$result = hesk_dbQuery($sql);
	if (hesk_dbAffectedRows() != 1)
    {
    	hesk_error("$hesklang[int_error]: $hesklang[cat_not_found].");
    }

	$_SESSION['HESK_NOTICE']  = $hesklang['cat_renamed'];
	$_SESSION['HESK_MESSAGE'] = $hesklang['cat_renamed_to'].' <i>'.$catname.'</i>';
	Header('Location: manage_categories.php');
	exit();
} // End rename_cat()


function remove() {
	global $hesk_settings, $hesklang;

	$mycat=hesk_isNumber($_GET['id'],$hesklang['no_cat_id']);
	if ($mycat == 1) {hesk_error($hesklang['cant_del_default_cat']);}

	$sql = "DELETE FROM `".$hesk_settings['db_pfix']."categories` WHERE `id`=$mycat LIMIT 1";
	$result = hesk_dbQuery($sql);
	if (hesk_dbAffectedRows() != 1)
    {
    	hesk_error("$hesklang[int_error]: $hesklang[cat_not_found].");
    }

	$sql = "UPDATE `".$hesk_settings['db_pfix']."tickets` SET `category`=1 WHERE `category`=$mycat LIMIT 1";
	$result = hesk_dbQuery($sql);

	$_SESSION['HESK_NOTICE']  = $hesklang['cat_removed'];
	$_SESSION['HESK_MESSAGE'] = $hesklang['cat_removed_db'];
	Header('Location: manage_categories.php');
	exit();
} // End remove()


function order_cat() {
	global $hesk_settings, $hesklang;

	$catid=hesk_isNumber($_GET['catid'],$hesklang['cat_move_id']);
	$cat_move=intval($_GET['move']);

	$sql = "UPDATE `".$hesk_settings['db_pfix']."categories` SET `cat_order`=`cat_order`+$cat_move WHERE `id`=$catid LIMIT 1";
	$result = hesk_dbQuery($sql);
	if (hesk_dbAffectedRows() != 1) {hesk_error("$hesklang[int_error]: $hesklang[cat_not_found].");}

	/* Update all category fields with new order */
	$sql = "SELECT `id` FROM `".$hesk_settings['db_pfix']."categories` ORDER BY `cat_order` ASC";
	$result = hesk_dbQuery($sql);

	$i = 10;
	while ($mycat=hesk_dbFetchAssoc($result))
	{
	    $sql = "UPDATE `".$hesk_settings['db_pfix']."categories` SET `cat_order`=$i WHERE `id`=$mycat[id] LIMIT 1";
	    hesk_dbQuery($sql);
	    $i += 10;
	}

	Header('Location: manage_categories.php');
	exit();
} // End order_cat()
?>
