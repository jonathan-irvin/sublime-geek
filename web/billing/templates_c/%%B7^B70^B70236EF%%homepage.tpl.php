<?php /* Smarty version 2.6.26, created on 2010-10-03 20:48:18
         compiled from v4/homepage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'v4/homepage.tpl', 102, false),)), $this); ?>
<script type="text/javascript" src="../includes/jscript/jqueryag.js"></script>

<?php if ($this->_tpl_vars['maintenancemode']): ?>
<div class="errorbox" style="font-size:14px;">
Maintenance Mode is On. Remember to switch it off when finished in <a href="configgeneral.php">General Settings</a>
</div>
<br />
<?php endif; ?>

<?php if ($this->_tpl_vars['freetrial']): ?>
<div class="errorbox" style="font-size:14px;">
You are currently running our 15 Day Free Trial!  <a href="http://www.whmcs.com/order.php" target="_blank">Click here to order a full license</a>
</div>
<br />
<?php endif; ?>

<?php echo $this->_tpl_vars['infobox']; ?>


<?php if ($this->_tpl_vars['viewincometotals']): ?><div class="contentbox" style="font-size:18px;"><a href="transactions.php"><img src="images/icons/transactions.png" align="absmiddle" border="0"> <b>Income</b></a> Today: <span class="textgreen"><b><?php echo $this->_tpl_vars['stats']['income']['today']; ?>
</b></span> This Month: <span class="textred"><b><?php echo $this->_tpl_vars['stats']['income']['thismonth']; ?>
</b></span> This Year: <span class="textblack"><b><?php echo $this->_tpl_vars['stats']['income']['thisyear']; ?>
</b></span></div>

<br /><?php endif; ?>

<?php $_from = $this->_tpl_vars['addons_html']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['addon_html']):
?>
<div style="margin-bottom:15px;"><?php echo $this->_tpl_vars['addon_html']; ?>
</div>
<?php endforeach; endif; unset($_from); ?>

<table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center">

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><a href="orders.php?status=Pending"><img src="images/icons/orders.png" align="absmiddle" border="0"> <b>Orders</b></a></td></tr>
<tr><td width="160" class="fieldlabel"><a href="orders.php">Today's Orders</a></td><td class="fieldarea"><span class="textblue"><b><?php echo $this->_tpl_vars['stats']['orders']['today']['total']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel"><a href="orders.php?status=Pending">Today's Pending</a></td><td class="fieldarea"><span class="textred"><b><?php echo $this->_tpl_vars['stats']['orders']['today']['pending']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel"><a href="orders.php?status=Active">Today's Completed</a></td><td class="fieldarea"><span class="textgreen"><b><?php echo $this->_tpl_vars['stats']['orders']['today']['active']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel">Yesterdays Orders</td><td class="fieldarea"><span class="textblue"><b><?php echo $this->_tpl_vars['stats']['orders']['yesterday']['total']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel">Yesterdays Completed</td><td class="fieldarea"><span class="textgreen"><b><?php echo $this->_tpl_vars['stats']['orders']['yesterday']['active']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel">Month to Date Total</td><td class="fieldarea"><span class="textgold"><b><?php echo $this->_tpl_vars['stats']['orders']['thismonth']['total']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel">Year to Date Total</td><td class="fieldarea"><span class="textblack"><b><?php echo $this->_tpl_vars['stats']['orders']['thisyear']['total']; ?>
</b></span></td></tr>
</table>

</td><td align="center">

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><img src="images/icons/stats.png" align="absmiddle" border="0"> <b>Statistics</b></td></tr>
<tr><td width="180" class="fieldlabel"><a href="clients.php?status=Active">Active Clients</a></td><td class="fieldarea"><span class="textgreen"><b><?php echo $this->_tpl_vars['sidebarstats']['clients']['active']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel"><a href="invoices.php?status=Unpaid">Unpaid Invoices</a></td><td class="fieldarea"><span class="textred"><b><?php echo $this->_tpl_vars['sidebarstats']['invoices']['unpaid']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel"><a href="invoices.php?status=Overdue">Overdue Invoices</a></td><td class="fieldarea"><span class="textblack"><b><?php echo $this->_tpl_vars['sidebarstats']['invoices']['overdue']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel"><a href="clientsdomainlist.php?status=Pending%20Transfer">Pending Transfer Domains</a></td><td class="fieldarea"><span class="textgold"><b><?php echo $this->_tpl_vars['sidebarstats']['domains']['pendingtransfer']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel"><a href="clientshostinglist.php?status=Suspended">Suspended Services</a></td><td class="fieldarea"><span class="testblue"><b><?php echo $this->_tpl_vars['sidebarstats']['services']['suspended']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel"><a href="billableitems.php?status=Uninvoiced">Uninvoiced Billable Items</a></td><td class="fieldarea"><span class="textred"><b><?php echo $this->_tpl_vars['stats']['billableitems']['uninvoiced']; ?>
</b></span></td></tr>
<tr><td class="fieldlabel"><a href="quotes.php?validity=Valid">Valid Quotes</a></td><td class="fieldarea"><span class="textgreen"><b><?php echo $this->_tpl_vars['stats']['quotes']['valid']; ?>
</b></span></td></tr>
</table>

</td><td width="400">

<img src="reports.php?displaygraph=graph_monthly_signups&homepage=true">

</td></tr></table>

<br />

<div class="errorbox" style="font-size:14px;"><a href="supporttickets.php"><?php echo $this->_tpl_vars['sidebarstats']['tickets']['awaitingreply']; ?>
 Ticket(s) Awaiting Reply</a> || <a href="cancelrequests.php"><?php echo $this->_tpl_vars['stats']['cancellations']['pending']; ?>
 Pending Cancellation(s)</a> || <a href="todolist.php"><?php echo $this->_tpl_vars['stats']['todoitems']['due']; ?>
 To-Do Item(s) Due</a> || <a href="networkissues.php"><?php echo $this->_tpl_vars['stats']['networkissues']['open']; ?>
 Open Network Issue(s)</a></div>

<br />

<div class="contentbox"><form method="post" action="index.php"><input type="hidden" name="action" value="savenotes"><table width="100%"><tr><td width="40"><b>My Notes</b></td><td><textarea name="notes" class="expanding" style="width:95%;"><?php echo $this->_tpl_vars['adminnotes']; ?>
</textarea></td><td width="40"><input type="submit" value="Save"></td></tr></table></form></div>

<br />

<table width="100%" cellspacing="0" cellpadding="0"><tr><td width="49%" valign="top">

<h3 align="center">Recent Client Activity</h3>

<table width="100%" bgcolor="#cccccc" cellspacing="1">
<tr bgcolor="#efefef" style="text-align:center;font-weight:bold;"><td>Client</td><td>IP</td><td>Last Access</td></tr>
<?php $_from = $this->_tpl_vars['recentclients']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['activity']):
?>
<tr bgcolor="#ffffff" style="text-align:center;"><td><a href="clientssummary.php?userid=<?php echo $this->_tpl_vars['activity']['id']; ?>
"><?php echo $this->_tpl_vars['activity']['firstname']; ?>
 <?php echo $this->_tpl_vars['activity']['lastname']; ?>
</a></td><td><a href="http://www.geoiptool.com/en/?IP=<?php echo $this->_tpl_vars['activity']['ip']; ?>
" target="_blank"><?php echo $this->_tpl_vars['activity']['ip']; ?>
</a></td><td><?php echo $this->_tpl_vars['activity']['lastlogin']; ?>
</td></tr>
<?php endforeach; else: ?>
<tr bgcolor="#ffffff"><td align="center" colspan="3">No Entries Found</td></tr>
<?php endif; unset($_from); ?>
</table>

</td><td width="2%"></td><td width="49%" valign="top">

<h3 align="center">Recent Admin Activity</h3>

<table width="100%" bgcolor="#cccccc" cellspacing="1">
<tr bgcolor="#efefef" style="text-align:center;font-weight:bold;"><td>Admin</td><td>IP</td><td>Last Access</td></tr>
<?php $_from = $this->_tpl_vars['recentadmins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['activity']):
?>
<tr bgcolor="#ffffff" style="text-align:center;"><td><?php echo $this->_tpl_vars['activity']['username']; ?>
</td><td><a href="http://www.geoiptool.com/en/?IP=<?php echo $this->_tpl_vars['activity']['ip']; ?>
" target="_blank"><?php echo $this->_tpl_vars['activity']['ip']; ?>
</a></td><td><?php echo $this->_tpl_vars['activity']['lastvisit']; ?>
</td></tr>
<?php endforeach; else: ?>
<tr bgcolor="#ffffff"><td align="center" colspan="3">No Entries Found</td></tr>
<?php endif; unset($_from); ?>
</table>

</td></tr></table>

<h3 align="center">To-Do List - <a href="todolist.php">Manage</a></h3>

<table width=100% cellspacing=1 bgcolor="#cccccc">
<tr bgcolor=#efefef style="text-align:center;font-weight:bold;"><td>Date</td><td>Title</td><td>Description</td><td>Due Date</td><td>Status</td><td width="20"></td></tr>
<?php $_from = $this->_tpl_vars['todoitems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['todoitem']):
?>
<tr bgcolor="<?php echo $this->_tpl_vars['todoitem']['bgcolor']; ?>
"><td align=center><?php echo $this->_tpl_vars['todoitem']['date']; ?>
</td><td align=center><?php echo $this->_tpl_vars['todoitem']['title']; ?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['todoitem']['description'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 80, "...") : smarty_modifier_truncate($_tmp, 80, "...")); ?>
</td><td align=center><?php echo $this->_tpl_vars['todoitem']['duedate']; ?>
</td><td align=center><?php echo $this->_tpl_vars['todoitem']['status']; ?>
</td><td><a href="todolist.php?action=edit&id=<?php echo $this->_tpl_vars['todoitem']['id']; ?>
"><img src="images/edit.gif" border="0"></a></td></tr>
<?php endforeach; else: ?>
<tr bgcolor=#ffffff><td align=center colspan=6>No Entries Found</td></tr>
<?php endif; unset($_from); ?>
</table>

<a name="checknetwork"></a>

<h3 align="center">Network Status - <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?checknetwork=true#checknetwork">Check Network Status</a></h3>

<table width=100% bgcolor="#cccccc" cellspacing=1>
<tr style="background-color:#efefef;font-weight:bold;text-align:center"><td>Server Name</td><td>HTTP</td><td>Load</td><td>Uptime</td><td>% Used</td></tr>
<?php $_from = $this->_tpl_vars['servers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['num'] => $this->_tpl_vars['server']):
?>
<tr bgcolor="#ffffff"><td align="center"><?php echo $this->_tpl_vars['server']['name']; ?>
</td><td align="center"><?php echo $this->_tpl_vars['server']['http']; ?>
</td><td align="center"><?php echo $this->_tpl_vars['server']['load']; ?>
</td><td align="center"><?php echo $this->_tpl_vars['server']['uptime']; ?>
</td><td align="center"><?php echo $this->_tpl_vars['server']['usage']; ?>
</td></tr>
<?php endforeach; else: ?>
<tr bgcolor=#ffffff><td align=center colspan=5>No Servers Setup</td></tr>
<?php endif; unset($_from); ?>
</table>

<h3 align="center">Recent Activity</h3>

<table width="100%" bgcolor="#cccccc" cellspacing="1">
<tr bgcolor="#efefef" style="text-align:center;font-weight:bold;"><td>Date</td><td>Description</td><td>Username</td></tr>
<?php $_from = $this->_tpl_vars['recentactivity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['activity']):
?>
<tr bgcolor="#ffffff"><td align="center"><?php echo $this->_tpl_vars['activity']['date']; ?>
</td><td><?php echo $this->_tpl_vars['activity']['description']; ?>
</td><td align="center"><?php echo $this->_tpl_vars['activity']['username']; ?>
</td></tr>
<?php endforeach; else: ?>
<tr bgcolor="#ffffff"><td align="center" colspan="3">No Entries Found</td></tr>
<?php endif; unset($_from); ?>
</table>

<div id="geninvoices" title="Generate Due Invoices">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 40px 0;"></span>Do you want to send the invoice notification emails immediately after generation?</p>
</div>
<div id="cccapture" title="Attempt CC Captures">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 40px 0;"></span>Are you sure? This will attempt the captures for all due credit card invoices.</p>
</div>