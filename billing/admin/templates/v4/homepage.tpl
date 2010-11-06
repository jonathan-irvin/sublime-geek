<script type="text/javascript" src="../includes/jscript/jqueryag.js"></script>

{if $maintenancemode}
<div class="errorbox" style="font-size:14px;">
Maintenance Mode is On. Remember to switch it off when finished in <a href="configgeneral.php">General Settings</a>
</div>
<br />
{/if}

{if $freetrial}
<div class="errorbox" style="font-size:14px;">
You are currently running our 15 Day Free Trial!  <a href="http://www.whmcs.com/order.php" target="_blank">Click here to order a full license</a>
</div>
<br />
{/if}

{$infobox}

{if $viewincometotals}<div class="contentbox" style="font-size:18px;"><a href="transactions.php"><img src="images/icons/transactions.png" align="absmiddle" border="0"> <b>Income</b></a> Today: <span class="textgreen"><b>{$stats.income.today}</b></span> This Month: <span class="textred"><b>{$stats.income.thismonth}</b></span> This Year: <span class="textblack"><b>{$stats.income.thisyear}</b></span></div>

<br />{/if}

{foreach from=$addons_html item=addon_html}
<div style="margin-bottom:15px;">{$addon_html}</div>
{/foreach}

<table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center">

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><a href="orders.php?status=Pending"><img src="images/icons/orders.png" align="absmiddle" border="0"> <b>Orders</b></a></td></tr>
<tr><td width="160" class="fieldlabel"><a href="orders.php">Today's Orders</a></td><td class="fieldarea"><span class="textblue"><b>{$stats.orders.today.total}</b></span></td></tr>
<tr><td class="fieldlabel"><a href="orders.php?status=Pending">Today's Pending</a></td><td class="fieldarea"><span class="textred"><b>{$stats.orders.today.pending}</b></span></td></tr>
<tr><td class="fieldlabel"><a href="orders.php?status=Active">Today's Completed</a></td><td class="fieldarea"><span class="textgreen"><b>{$stats.orders.today.active}</b></span></td></tr>
<tr><td class="fieldlabel">Yesterdays Orders</td><td class="fieldarea"><span class="textblue"><b>{$stats.orders.yesterday.total}</b></span></td></tr>
<tr><td class="fieldlabel">Yesterdays Completed</td><td class="fieldarea"><span class="textgreen"><b>{$stats.orders.yesterday.active}</b></span></td></tr>
<tr><td class="fieldlabel">Month to Date Total</td><td class="fieldarea"><span class="textgold"><b>{$stats.orders.thismonth.total}</b></span></td></tr>
<tr><td class="fieldlabel">Year to Date Total</td><td class="fieldarea"><span class="textblack"><b>{$stats.orders.thisyear.total}</b></span></td></tr>
</table>

</td><td align="center">

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><img src="images/icons/stats.png" align="absmiddle" border="0"> <b>Statistics</b></td></tr>
<tr><td width="180" class="fieldlabel"><a href="clients.php?status=Active">Active Clients</a></td><td class="fieldarea"><span class="textgreen"><b>{$sidebarstats.clients.active}</b></span></td></tr>
<tr><td class="fieldlabel"><a href="invoices.php?status=Unpaid">Unpaid Invoices</a></td><td class="fieldarea"><span class="textred"><b>{$sidebarstats.invoices.unpaid}</b></span></td></tr>
<tr><td class="fieldlabel"><a href="invoices.php?status=Overdue">Overdue Invoices</a></td><td class="fieldarea"><span class="textblack"><b>{$sidebarstats.invoices.overdue}</b></span></td></tr>
<tr><td class="fieldlabel"><a href="clientsdomainlist.php?status=Pending%20Transfer">Pending Transfer Domains</a></td><td class="fieldarea"><span class="textgold"><b>{$sidebarstats.domains.pendingtransfer}</b></span></td></tr>
<tr><td class="fieldlabel"><a href="clientshostinglist.php?status=Suspended">Suspended Services</a></td><td class="fieldarea"><span class="testblue"><b>{$sidebarstats.services.suspended}</b></span></td></tr>
<tr><td class="fieldlabel"><a href="billableitems.php?status=Uninvoiced">Uninvoiced Billable Items</a></td><td class="fieldarea"><span class="textred"><b>{$stats.billableitems.uninvoiced}</b></span></td></tr>
<tr><td class="fieldlabel"><a href="quotes.php?validity=Valid">Valid Quotes</a></td><td class="fieldarea"><span class="textgreen"><b>{$stats.quotes.valid}</b></span></td></tr>
</table>

</td><td width="400">

<img src="reports.php?displaygraph=graph_monthly_signups&homepage=true">

</td></tr></table>

<br />

<div class="errorbox" style="font-size:14px;"><a href="supporttickets.php">{$sidebarstats.tickets.awaitingreply} Ticket(s) Awaiting Reply</a> || <a href="cancelrequests.php">{$stats.cancellations.pending} Pending Cancellation(s)</a> || <a href="todolist.php">{$stats.todoitems.due} To-Do Item(s) Due</a> || <a href="networkissues.php">{$stats.networkissues.open} Open Network Issue(s)</a></div>

<br />

<div class="contentbox"><form method="post" action="index.php"><input type="hidden" name="action" value="savenotes"><table width="100%"><tr><td width="40"><b>My Notes</b></td><td><textarea name="notes" class="expanding" style="width:95%;">{$adminnotes}</textarea></td><td width="40"><input type="submit" value="Save"></td></tr></table></form></div>

<br />

<table width="100%" cellspacing="0" cellpadding="0"><tr><td width="49%" valign="top">

<h3 align="center">Recent Client Activity</h3>

<table width="100%" bgcolor="#cccccc" cellspacing="1">
<tr bgcolor="#efefef" style="text-align:center;font-weight:bold;"><td>Client</td><td>IP</td><td>Last Access</td></tr>
{foreach from=$recentclients item=activity}
<tr bgcolor="#ffffff" style="text-align:center;"><td><a href="clientssummary.php?userid={$activity.id}">{$activity.firstname} {$activity.lastname}</a></td><td><a href="http://www.geoiptool.com/en/?IP={$activity.ip}" target="_blank">{$activity.ip}</a></td><td>{$activity.lastlogin}</td></tr>
{foreachelse}
<tr bgcolor="#ffffff"><td align="center" colspan="3">No Entries Found</td></tr>
{/foreach}
</table>

</td><td width="2%"></td><td width="49%" valign="top">

<h3 align="center">Recent Admin Activity</h3>

<table width="100%" bgcolor="#cccccc" cellspacing="1">
<tr bgcolor="#efefef" style="text-align:center;font-weight:bold;"><td>Admin</td><td>IP</td><td>Last Access</td></tr>
{foreach from=$recentadmins item=activity}
<tr bgcolor="#ffffff" style="text-align:center;"><td>{$activity.username}</td><td><a href="http://www.geoiptool.com/en/?IP={$activity.ip}" target="_blank">{$activity.ip}</a></td><td>{$activity.lastvisit}</td></tr>
{foreachelse}
<tr bgcolor="#ffffff"><td align="center" colspan="3">No Entries Found</td></tr>
{/foreach}
</table>

</td></tr></table>

<h3 align="center">To-Do List - <a href="todolist.php">Manage</a></h3>

<table width=100% cellspacing=1 bgcolor="#cccccc">
<tr bgcolor=#efefef style="text-align:center;font-weight:bold;"><td>Date</td><td>Title</td><td>Description</td><td>Due Date</td><td>Status</td><td width="20"></td></tr>
{foreach key=num from=$todoitems item=todoitem}
<tr bgcolor="{$todoitem.bgcolor}"><td align=center>{$todoitem.date}</td><td align=center>{$todoitem.title}</td><td>{$todoitem.description|truncate:80:"..."}</td><td align=center>{$todoitem.duedate}</td><td align=center>{$todoitem.status}</td><td><a href="todolist.php?action=edit&id={$todoitem.id}"><img src="images/edit.gif" border="0"></a></td></tr>
{foreachelse}
<tr bgcolor=#ffffff><td align=center colspan=6>No Entries Found</td></tr>
{/foreach}
</table>

<a name="checknetwork"></a>

<h3 align="center">Network Status - <a href="{$smarty.server.PHP_SELF}?checknetwork=true#checknetwork">Check Network Status</a></h3>

<table width=100% bgcolor="#cccccc" cellspacing=1>
<tr style="background-color:#efefef;font-weight:bold;text-align:center"><td>Server Name</td><td>HTTP</td><td>Load</td><td>Uptime</td><td>% Used</td></tr>
{foreach key=num from=$servers item=server}
<tr bgcolor="#ffffff"><td align="center">{$server.name}</td><td align="center">{$server.http}</td><td align="center">{$server.load}</td><td align="center">{$server.uptime}</td><td align="center">{$server.usage}</td></tr>
{foreachelse}
<tr bgcolor=#ffffff><td align=center colspan=5>No Servers Setup</td></tr>
{/foreach}
</table>

<h3 align="center">Recent Activity</h3>

<table width="100%" bgcolor="#cccccc" cellspacing="1">
<tr bgcolor="#efefef" style="text-align:center;font-weight:bold;"><td>Date</td><td>Description</td><td>Username</td></tr>
{foreach from=$recentactivity item=activity}
<tr bgcolor="#ffffff"><td align="center">{$activity.date}</td><td>{$activity.description}</td><td align="center">{$activity.username}</td></tr>
{foreachelse}
<tr bgcolor="#ffffff"><td align="center" colspan="3">No Entries Found</td></tr>
{/foreach}
</table>

<div id="geninvoices" title="Generate Due Invoices">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 40px 0;"></span>Do you want to send the invoice notification emails immediately after generation?</p>
</div>
<div id="cccapture" title="Attempt CC Captures">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 40px 0;"></span>Are you sure? This will attempt the captures for all due credit card invoices.</p>
</div>