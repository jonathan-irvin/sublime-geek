<script type="text/javascript" src="../includes/jscript/jqueryag.js"></script>

{if $maintenancemode}
<div align="center" class="errorbox">
Maintenance Mode is On. Remember to switch it off when finished in <a href="configgeneral.php">General Settings</a>
</div>
<br />
{/if}

{if $freetrial}
<div align="center" class="errorbox">
You are currently running our 15 Day Free Trial!  <a href="http://www.whmcs.com/order.php" target="_blank">Click here to order a full license</a>
</div>
<br />
{/if}

{$infobox}

<div class="errorbox">Quick Summary &nbsp; &raquo; &nbsp; <span style="color:#000000;">{if $viewincometotals}Todays Income: {$stats.income.today} &nbsp; - &nbsp; {/if}Pending Orders: {$stats.orders.today.pending} &nbsp; - &nbsp; Pending Cancellations: {$stats.cancellations.pending} &nbsp; - &nbsp; Overdue Invoices: {$sidebarstats.invoices.overdue}</span></div>

<br />

{foreach from=$addons_html item=addon_html}
<div style="margin-bottom:15px;">{$addon_html}</div>
{/foreach}

<table align="center"><tr><td valign="top">

{php}
$sidebarstats = $this->_tpl_vars["sidebarstats"];
$stats = $this->_tpl_vars["stats"];
{/php}

<table width="250" class="form">
<tr><td colspan=3 class="fieldarea"><div align="center"><strong>Clients</strong></div></td></tr>
<tr><td width="75" align="right"><a href="clients.php?status=Active">Active</a></td><td width="104"><img src="images/percentbar.png" class="greenbar" style="background-position: -{php} echo 100-(round($sidebarstats["clients"]["active"]/($sidebarstats["clients"]["active"]+$sidebarstats["clients"]["inactive"]+$sidebarstats["clients"]["closed"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.clients.active}</td></tr>
<tr><td align="right"><a href="clients.php?status=Inactive">Inactive</a></td><td><img src="images/percentbar.png" class="bluebar" style="background-position: -{php} echo 100-(round($sidebarstats["clients"]["inactive"]/($sidebarstats["clients"]["active"]+$sidebarstats["clients"]["inactive"]+$sidebarstats["clients"]["closed"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.clients.inactive}</td></tr>
<tr><td align="right"><a href="clients.php?status=Closed">Closed</a></td><td><img src="images/percentbar.png" class="redbar" style="background-position: -{php} echo 100-(round($sidebarstats["clients"]["closed"]/($sidebarstats["clients"]["active"]+$sidebarstats["clients"]["inactive"]+$sidebarstats["clients"]["closed"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.clients.closed}</td></tr>
</table>

<img src="images/spacer.gif" width="1" height="4"><br>

<table width="250" class="form">
<tr><td colspan=3 class="fieldarea"><div align="center"><strong>Support Tickets</strong></div></td></tr>
<tr><td width="90" align="right"><a href="supporttickets.php?view=Open">Open</a></td><td width="104"><img src="images/percentbar.png" class="goldbar" style="background-position: -{php} echo 100-(round($stats["tickets"]["open"]/($stats["tickets"]["open"]+$stats["tickets"]["answered"]+$stats["tickets"]["customerreply"]+$stats["tickets"]["onhold"]+$stats["tickets"]["inprogress"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$stats.tickets.open}</td></tr>
<tr><td align="right"><a href="supporttickets.php?view=Answered">Answered</a></td><td><img src="images/percentbar.png" class="greenbar" style="background-position: -{php} echo 100-(round($stats["tickets"]["answered"]/($stats["tickets"]["open"]+$stats["tickets"]["answered"]+$stats["tickets"]["customerreply"]+$stats["tickets"]["onhold"]+$stats["tickets"]["inprogress"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$stats.tickets.answered}</td></tr>
<tr><td align="right"><a href="supporttickets.php?view=Customer-Reply">Customer-Reply</a></td><td><img src="images/percentbar.png" class="bluebar" style="background-position: -{php} echo 100-(round($stats["tickets"]["customerreply"]/($stats["tickets"]["open"]+$stats["tickets"]["answered"]+$stats["tickets"]["customerreply"]+$stats["tickets"]["onhold"]+$stats["tickets"]["inprogress"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$stats.tickets.customerreply}</td></tr>
<tr><td align="right"><a href="supporttickets.php?view=On Hold">On Hold</a></td><td><img src="images/percentbar.png" class="redbar" style="background-position: -{php} echo 100-(round($stats["tickets"]["onhold"]/($stats["tickets"]["open"]+$stats["tickets"]["answered"]+$stats["tickets"]["customerreply"]+$stats["tickets"]["onhold"]+$stats["tickets"]["inprogress"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$stats.tickets.onhold}</td></tr>
<tr><td align="right"><a href="supporttickets.php?view=In Progress">In Progress</a></td><td><img src="images/percentbar.png" class="redbar" style="background-position: -{php} echo 100-(round($stats["tickets"]["inprogress"]/($stats["tickets"]["open"]+$stats["tickets"]["answered"]+$stats["tickets"]["customerreply"]+$stats["tickets"]["onhold"]+$stats["tickets"]["inprogress"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$stats.tickets.inprogress}</td></tr>
</table>

</td><td valign="top">

<table width="250" class="form">
<tr><td colspan=3 class="fieldarea"><div align="center"><strong>Products/Services</strong></div></td></tr>
<tr><td width="75" align="right"><a href="clientshostinglist.php?status=Pending">Pending</a></td><td width="104"><img src="images/percentbar.png" class="goldbar" style="background-position: -{php} echo 100-(round($sidebarstats["services"]["pending"]/($sidebarstats["services"]["pending"]+$sidebarstats["services"]["active"]+$sidebarstats["services"]["suspended"]+$sidebarstats["services"]["terminated"]+$sidebarstats["services"]["cancelled"]+$sidebarstats["services"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.services.pending}</td></tr>
<tr><td align="right"><a href="clientshostinglist.php?status=Active">Active</a></td><td><img src="images/percentbar.png" class="greenbar" style="background-position: -{php} echo 100-(round($sidebarstats["services"]["active"]/($sidebarstats["services"]["pending"]+$sidebarstats["services"]["active"]+$sidebarstats["services"]["suspended"]+$sidebarstats["services"]["terminated"]+$sidebarstats["services"]["cancelled"]+$sidebarstats["services"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.services.active}</td></tr>
<tr><td align="right"><a href="clientshostinglist.php?status=Suspended">Suspended</a></td><td><img src="images/percentbar.png" class="bluebar" style="background-position: -{php} echo 100-(round($sidebarstats["services"]["suspended"]/($sidebarstats["services"]["pending"]+$sidebarstats["services"]["active"]+$sidebarstats["services"]["suspended"]+$sidebarstats["services"]["terminated"]+$sidebarstats["services"]["cancelled"]+$sidebarstats["services"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.services.suspended}</td></tr>
<tr><td align="right"><a href="clientshostinglist.php?status=Terminated">Terminated</a></td><td><img src="images/percentbar.png" class="redbar" style="background-position: -{php} echo 100-(round($sidebarstats["services"]["terminated"]/($sidebarstats["services"]["pending"]+$sidebarstats["services"]["active"]+$sidebarstats["services"]["suspended"]+$sidebarstats["services"]["terminated"]+$sidebarstats["services"]["cancelled"]+$sidebarstats["services"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.services.terminated}</td></tr>
<tr><td align="right"><a href="clientshostinglist.php?status=Cancelled">Cancelled</a></td><td><img src="images/percentbar.png" class="redbar" style="background-position: -{php} echo 100-(round($sidebarstats["services"]["cancelled"]/($sidebarstats["services"]["pending"]+$sidebarstats["services"]["active"]+$sidebarstats["services"]["suspended"]+$sidebarstats["services"]["terminated"]+$sidebarstats["services"]["cancelled"]+$sidebarstats["services"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.services.cancelled}</td></tr>
<tr><td align="right"><a href="clientshostinglist.php?status=Fraud">Fraud</a></td><td><img src="images/percentbar.png" class="blackbar" style="background-position: -{php} echo 100-(round($sidebarstats["services"]["fraud"]/($sidebarstats["services"]["pending"]+$sidebarstats["services"]["active"]+$sidebarstats["services"]["suspended"]+$sidebarstats["services"]["terminated"]+$sidebarstats["services"]["cancelled"]+$sidebarstats["services"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.services.fraud}</td></tr>
</table>

<img src="images/spacer.gif" width="1" height="4"><br>

<table width="250" class="form">
<tr><td colspan=3 class="fieldarea"><div align="center"><strong>Todays Orders</strong></div></td></tr>
<tr><td width="75" align="right"><a href="orders.php?filter=true&status=Pending">Pending</a></td><td width="104"><img src="images/percentbar.png"class="redbar" style="background-position: -{php} if ($stats["orders"]["today"]["total"]) echo 100-(round($stats["orders"]["today"]["pending"]/$stats["orders"]["today"]["total"],2)*100); else echo "100"; {/php}px 0pt;" /></td><td class="fieldareasmall">{$stats.orders.today.pending}</td></tr>
<tr><td align="right"><a href="orders.php?filter=true&status=Active">Active</a></td><td><img src="images/percentbar.png" alt="{$todaysactiveorderspercent}%" title="{$todaysactiveorderspercent}%" class="goldbar" style="background-position: -{php} if ($stats["orders"]["today"]["total"]) echo 100-(round($stats["orders"]["today"]["active"]/$stats["orders"]["today"]["total"],2)*100); else echo "100"; {/php}px 0pt;" /></td><td class="fieldareasmall">{$stats.orders.today.active}</td></tr>
</table>

</td><td valign="top">

<table width="250" class="form">
<tr><td colspan=3 class="fieldarea"><div align="center"><strong>Domains</strong></div></td></tr>
<tr><td width="90" align="right"><a href="clientsdomainlist.php?status=Pending">Pending</a></td><td width="104"><img src="images/percentbar.png" class="goldbar" style="background-position: -{php} echo 100-(round($sidebarstats["domains"]["pending"]/($sidebarstats["domains"]["pending"]+$sidebarstats["domains"]["pendingtransfer"]+$sidebarstats["domains"]["active"]+$sidebarstats["domains"]["expired"]+$sidebarstats["domains"]["cancelled"]+$sidebarstats["domains"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.domains.pending}</td></tr>
<tr><td align="right"><a href="clientsdomainlist.php?status=Pending Transfer">Pending Transfer</a></td><td width="104"><img src="images/percentbar.png" class="goldbar" style="background-position: -{php} echo 100-(round($sidebarstats["domains"]["pendingtransfer"]/($sidebarstats["domains"]["pending"]+$sidebarstats["domains"]["pendingtransfer"]+$sidebarstats["domains"]["active"]+$sidebarstats["domains"]["expired"]+$sidebarstats["domains"]["cancelled"]+$sidebarstats["domains"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.domains.pendingtransfer}</td></tr>
<tr><td align="right"><a href="clientsdomainlist.php?status=Active">Active</a></td><td><img src="images/percentbar.png" class="greenbar" style="background-position: -{php} echo 100-(round($sidebarstats["domains"]["active"]/($sidebarstats["domains"]["pending"]+$sidebarstats["domains"]["pendingtransfer"]+$sidebarstats["domains"]["active"]+$sidebarstats["domains"]["expired"]+$sidebarstats["domains"]["cancelled"]+$sidebarstats["domains"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.domains.active}</td></tr>
<tr><td align="right"><a href="clientsdomainlist.php?status=Expired">Expired</a></td><td><img src="images/percentbar.png" class="bluebar" style="background-position: -{php} echo 100-(round($sidebarstats["domains"]["expired"]/($sidebarstats["domains"]["pending"]+$sidebarstats["domains"]["pendingtransfer"]+$sidebarstats["domains"]["active"]+$sidebarstats["domains"]["expired"]+$sidebarstats["domains"]["cancelled"]+$sidebarstats["domains"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.domains.expired}</td></tr>
<tr><td align="right"><a href="clientsdomainlist.php?status=Cancelled">Cancelled</a></td><td><img src="images/percentbar.png" class="redbar" style="background-position: -{php} echo 100-(round($sidebarstats["domains"]["cancelled"]/($sidebarstats["domains"]["pending"]+$sidebarstats["domains"]["pendingtransfer"]+$sidebarstats["domains"]["active"]+$sidebarstats["domains"]["expired"]+$sidebarstats["domains"]["cancelled"]+$sidebarstats["domains"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.domains.cancelled}</td></tr>
<tr><td align="right"><a href="clientsdomainlist.php?status=Fraud">Fraud</a></td><td><img src="images/percentbar.png" class="blackbar" style="background-position: -{php} echo 100-(round($sidebarstats["domains"]["fraud"]/($sidebarstats["domains"]["pending"]+$sidebarstats["domains"]["pendingtransfer"]+$sidebarstats["domains"]["active"]+$sidebarstats["domains"]["expired"]+$sidebarstats["domains"]["cancelled"]+$sidebarstats["domains"]["fraud"]),2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.domains.fraud}</td></tr>
</table>

<img src="images/spacer.gif" width="1" height="4"><br>

<table width="250" class="form">
<tr><td colspan=3 class="fieldarea"><div align="center"><strong>Invoices</strong></div></td></tr>
<tr><td width="60" align="right"><a href="invoices.php?status=Unpaid">Unpaid</a></td><td width="104"><img src="images/percentbar.png" alt="100%" title="100%" class="goldbar" style="background-position: 0px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.invoices.unpaid}</td></tr>
<tr><td align="right"><a href="invoices.php?status=Overdue">Overdue</a></td><td><img src="images/percentbar.png" class="redbar" style="background-position: -{php} echo 100-(round($sidebarstats["invoices"]["overdue"]/$sidebarstats["invoices"]["unpaid"],2)*100); {/php}px 0pt;" /></td><td class="fieldareasmall">{$sidebarstats.invoices.overdue}</td></tr>
</table>

</td></tr></table>

<form method="post" action="{$smarty.server.PHP_SELF}?action=savenotes">
<table width="758" align="center" class="form">
<tr><td colspan=3 class="fieldarea"><div align="center"><strong>Private Notes</strong></div></td></tr>
<tr><td class="fieldareasmall"><textarea name="notes" class="expanding" style="width:99%;border:1px dashed #8FBCE9;">{$adminnotes}</textarea></td></tr>
<tr><td align=center class="fieldareasmall"><input type="submit" value="Save Notes" class="button" style="font-size:10px;height:16px;"></td></tr>
</table>
</form>

<h2>To-Do List - <a href="todolist.php">Manage</a></h2>
<table width=100% cellspacing=1 bgcolor="#cccccc">
<tr bgcolor=#efefef style="text-align:center;font-weight:bold;"><td>Date</td><td>Title</td><td>Description</td><td>Due Date</td><td>Status</td><td width="20"></td></tr>
{foreach key=num from=$todoitems item=todoitem}
<tr bgcolor="{$todoitem.bgcolor}"><td align=center>{$todoitem.date}</td><td align=center>{$todoitem.title}</td><td align=center>{$todoitem.description|truncate:80:"..."}</td><td align=center>{$todoitem.duedate}</td><td align=center>{$todoitem.status}</td><td><a href="todolist.php?action=edit&id={$todoitem.id}"><img src="images/edit.gif" border="0"></a></td></tr>
{foreachelse}
<tr bgcolor=#ffffff><td align=center colspan=6>No To-Do Items Found</td></tr>
{/foreach}
</table>

<h2>Unpaid Invoices ({$totalunpaidinvoices}) - Showing 5 Oldest... <a href="invoices.php?status=Unpaid">View All</a></h2>

<table width=100% cellspacing=1 bgcolor="#cccccc"><tr bgcolor="#efefef" style="text-align:center;font-weight:bold"><td>Invoice #</td><td>Client Name</td><td>Invoice Date</td><td>Due Date</td><td>Balance</td><td>Payment Method</td><td width="20"></td></tr>
{foreach key=num from=$unpaidinvoices item=unpaidinvoice}
<tr bgcolor=#ffffff><td align=center><a href="invoices.php?action=edit&id={$unpaidinvoice.id}">{$unpaidinvoice.id}</a></td><td align=center><a href="clientssummary.php?userid={$unpaidinvoice.userid}">{$unpaidinvoice.client}</a><td align=center>{$unpaidinvoice.date}</td><td align=center>{$unpaidinvoice.duedate}</td><td align=center>{$unpaidinvoice.balance}</td><td align=center>{$unpaidinvoice.paymentmethod}</td><td align=center><a href="invoices.php?action=edit&id={$unpaidinvoice.id}"><img src="images/edit.gif" border="0"></a></td></tr>
{foreachelse}
<tr bgcolor="#ffffff"><td align=center colspan=7>No Unpaid Invoices</td></tr>
{/foreach}
</table>

<h2>Network Status - <a href="{$smarty.server.PHP_SELF}?checknetwork=true">Check Network Status</a></h2>
<table width=100% bgcolor="#cccccc" cellspacing=1>
<tr style="background-color:#efefef;font-weight:bold;text-align:center"><td>Server Name</td><td>HTTP</td><td>Load</td><td>Uptime</td><td>% Used</td></tr>
{foreach key=num from=$servers item=server}
<tr bgcolor="#ffffff"><td align="center">{$server.name}</td><td align="center">{$server.http}</td><td align="center">{$server.load}</td><td align="center">{$server.uptime}</td><td align="center">{$server.usage}</td></tr>
{foreachelse}
<tr bgcolor=#ffffff><td align=center colspan=5>No Servers Currently Setup</td></tr>
{/foreach}
</table>

<p align="center"><input type="button" value="Generate Invoices" class="button" onClick="showDialog('geninvoices')">{if $showattemptccbutton} <input type="button" value="Attempt CC Payments" class="button" onClick="showDialog('cccapture')">{/if}</p>

<div id="geninvoices" title="Generate Due Invoices">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 40px 0;"></span>Do you want to send the invoice notification emails immediately after generation?</p>
</div>
<div id="cccapture" title="Attempt CC Captures">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 40px 0;"></span>Are you sure? This will attempt the captures for all due credit card invoices.</p>
</div>