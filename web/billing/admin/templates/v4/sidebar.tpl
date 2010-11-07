{if $sidebar eq "home"}

<span class="header"><img src="images/icons/home.png" class="absmiddle" width="16" height="16" /> Shortcuts</span>
<ul class="menu">
    <li><a href="clientsadd.php">Add a New Client</a></li>
    <li><a href="ordersadd.php">Place New Order</a></li>
    <li><a href="quotes.php?action=manage">Create Quote</a></li>
    <li><a href="todolist.php">Create New To-Do Item</a></li>
    <li><a href="supporttickets.php?action=open">Create New Support Ticket</a></li>
    <li><a href="whois.php">WHOIS Lookup</a></li>
    <li><a href="#" onClick="showDialog('geninvoices');return false">Generate Due Invoices</a></li>
    <li><a href="#" onClick="showDialog('cccapture');return false">Attempt CC Captures</a></li>
</ul>

<span class="plain_header">Income Projection</span>
<div class="smallfont">{$incomestats}</div>

<br />

<span class="plain_header">System Information</span>
<div class="smallfont">Reg. To: {$licenseinfo.registeredname}<br />Type: {$licenseinfo.productname}<br />Expires: {$licenseinfo.expires}<br />Version: {$licenseinfo.currentversion}{if $licenseinfo.currentversion neq $licenseinfo.latestversion}<br /><span class="textred"><b>An update is available!</b></span>{/if}</div>

{elseif $sidebar eq "clients"}

<span class="header"><img src="images/icons/clients.png" class="absmiddle" alt="Clients" width="16" height="16" /> Clients</span>
<ul class="menu">
    <li><a href="clients.php">View/Search Clients</a></li>
    <li><a href="clientsadd.php">Add New Client</a></li>
    <li><a href="massmail.php">Mass Mail Clients</a></li>
</ul>

<span class="header"><img src="images/icons/products.png" alt="Products/Services" width="16" height="16" class="absmiddle" /> Product/Services</span>
<ul class="menu">
    <li><a href="clientshostinglist.php">All Services</a></li>
    <li><a href="clientshostinglist.php?type=hostingaccount">Hosting Accounts</a></li>
    <li><a href="clientshostinglist.php?type=reselleraccount">Reseller Accounts</a></li>
    <li><a href="clientshostinglist.php?type=server">Server Accounts</a></li>
    <li><a href="clientshostinglist.php?type=other">Product/Services</a></li>
    <li><a href="clientsaddonslist.php">Account Addons</a></li>
    <li><a href="clientsdomainlist.php">Domains</a></li>
    <li><a href="cancelrequests.php">Cancellation Requests</a></li>
</ul>

<span class="header"><img src="images/icons/affiliates.png" alt="Affiliates" width="16" height="16" class="absmiddle" /> Affiliates</span>
<ul class="menu">
    <li><a href="affiliates.php">Manage Affiliates</a></li>
</ul>

{elseif $sidebar eq "orders"}

<span class="header"><img src="images/icons/orders.png" alt="Affiliates" width="16" height="16" class="absmiddle" /> Orders</span>
<ul class="menu">
    <li><a href="orders.php">All Orders</a></li>
    <li><a href="orders.php?status=Pending">Pending Orders</a></li>
    <li><a href="orders.php?status=Active">Active Orders</a></li>
    <li><a href="orders.php?status=Fraud">Fraud Orders</a></li>
    <li><a href="orders.php?status=Cancelled">Cancelled Orders</a></li>
    <li><a href="ordersadd.php">Add New Order</a></li>
</ul>

{elseif $sidebar eq "support"}

<span class="header"><img src="images/icons/support.png" alt="Support Center" width="16" height="16" class="absmiddle" /> Support Center</span>
<ul class="menu">
    <li><a href="supportcenter.php">Summary</a></li>
    <li><a href="supportannouncements.php">Announcements</a></li>
    <li><a href="supportdownloads.php">Downloads</a></li>
    <li><a href="supportkb.php">Knowledgebase</a></li>
    <li><a href="supporttickets.php?action=open">Open New Ticket</a></li>
    <li><a href="supportticketpredefinedreplies.php">Predefined Replies</a></li>
</ul>

<span class="header"><img src="images/icons/tickets.png" alt="Filter Tickets" width="16" height="16" class="absmiddle" /> Filter Tickets</span>
<ul class="menu">
    <li><a href="supporttickets.php">Awaiting Reply ({$ticketsawaitingreply})</a></li>
    <li><a href="supporttickets.php?view=flagged">My Flagged Tickets ({$ticketsflagged})</a></li>
    <li><a href="supporttickets.php?view=active">All Active Tickets ({$ticketsallactive})</a></li>
{foreach from=$ticketcounts item=ticket}
    <li><a href="supporttickets.php?view={$ticket.title}">{$ticket.title} ({$ticket.count})</a></li>
{/foreach}</ul>

<span class="header"><img src="images/icons/networkissues.png" alt="Network Issues" width="16" height="16" class="absmiddle" /> Network Issues</span>
<ul class="menu">
    <li><a href="networkissues.php">Open Issues</a></li>
    <li><a href="networkissues.php?view=scheduled">Scheduled Issues</a></li>
    <li><a href="networkissues.php?view=resolved">Resolved Issues</a></li>
    <li><a href="networkissues.php?action=manage">Add New Issue</a></li>
</ul>

{elseif $sidebar eq "billing"}

<span class="header"><img src="images/icons/transactions.png" class="absmiddle" width="16" height="16" /> Billing</span>
<ul class="menu">
    <li><a href="transactions.php">View Transactions List</a></li>
    <li><a href="gatewaylog.php">View Gateway Log</a></li>
    <li><a href="offlineccprocessing.php">Offline CC Processing</a></li>
</ul>

<span class="header"><img src="images/icons/invoices.png" class="absmiddle" width="16" height="16" /> Invoices</span>
<ul class="menu">
    <li><a href="invoices.php">All Invoices</a></li>
    <li><a href="invoices.php?status=Paid">Paid Invoices</a></li>
    <li><a href="invoices.php?status=Unpaid">Unpaid Invoices</a></li>
    <li><a href="invoices.php?status=Overdue">Overdue Invoices</a></li>
    <li><a href="invoices.php?status=Cancelled">Cancelled Invoices</a></li>
    <li><a href="invoices.php?status=Refunded">Refunded Invoices</a></li>
    <li><a href="invoices.php?status=Collections">Collections Invoices</a></li>
</ul>

<span class="header"><img src="images/icons/billableitems.png" class="absmiddle" width="16" height="16" /> Billable Items</span>
<ul class="menu">
    <li><a href="billableitems.php">All Items</a></li>
    <li><a href="billableitems.php?status=Uninvoiced">Uninvoiced Items</a></li>
    <li><a href="billableitems.php?status=Recurring">Recurring Items</a></li>
    <li><a href="billableitems.php?action=manage">Add New</a></li>
</ul>

<span class="header"><img src="images/icons/quotes.png" class="absmiddle" width="16" height="16" /> Quotes</span>
<ul class="menu">
    <li><a href="quotes.php">All Quotes</a></li>
    <li><a href="quotes.php?validity=Valid">Valid Quotes</a></li>
    <li><a href="quotes.php?validity=Expired">Expired Quotes</a></li>
    <li><a href="quotes.php?action=manage">Create New Quote</a></li>
</ul>

{elseif $sidebar eq "reports"}

<span class="header"><img src="images/icons/reports.png" class="absmiddle" width="16" height="16" /> Reports</span>
<ul class="menu">
    {foreach from=$text_reports key=filename item=reporttitle}
    <li><a href="reports.php?report={$filename}">{$reporttitle}</a></li>
    {/foreach}
</ul>

<span class="header"><img src="images/icons/graphs.png" class="absmiddle" width="16" height="16" /> Graphs</span>
<ul class="menu">
    {foreach from=$graph_reports key=filename item=reporttitle}
    <li><a href="reports.php?graph={$filename}">{$reporttitle}</a></li>
    {/foreach}
</ul>

<span class="header"><img src="images/icons/csvexports.png" class="absmiddle" width="16" height="16" /> Exports</span>
<ul class="menu">
    <li><a href="csvdownload.php?type=clients">Clients</a></li>
    <li><a href="csvdownload.php?type=products">Products/Services</a></li>
    <li><a href="csvdownload.php?type=domains">Domains</a></li>
    <li><a href="reports.php?report=transactions">Transactions</a></li>
    <li><a href="reports.php?report=pdfbatch">PDF Batch</a></li>
</ul>

{elseif $sidebar eq "browser"}

<span class="header"><img src="images/icons/browser.png" class="absmiddle" width="16" height="16" /> Bookmarks</span>
<ul class="menu">
    <li><a href="http://www.whmcs.com/" target="brwsrwnd">WHMCS Homepage</a></li>
    <li><a href="https://www.whmcs.com/clients/" target="brwsrwnd">WHMCS Client Area</a></li>
    {foreach from=$browserlinks item=link}
    <li><a href="{$link.url}" target="brwsrwnd">{$link.name} <img src="images/delete.gif" width="10" border="0" onclick="doDelete('{$link.id}')"></a></li>
    {/foreach}
</ul>

<form method="post" action="browser.php?action=add">
<span class="header"><img src="images/icons/browseradd.png" class="absmiddle" width="16" height="16" /> Add New Bookmark</span>
<ul class="menu">
    <li>Site Name:<br><input type="text" name="sitename" size="25" style="font-size:9px;"><br>URL:<br><input type="text" name="siteurl" size="25" value="http://" style="font-size:9px;"><br><input type="submit" value="Add Bookmark" style="font-size:9px;"></li>
</ul>
</form>

{elseif $sidebar eq "utilities"}

<span class="header"><img src="images/icons/utilities.png" class="absmiddle" width="16" height="16" /> Utilities</span>
<ul class="menu">
    <li><a href="addonmodules.php">Addon Modules</a></li>
    <li><a href="utilitieslinktracking.php">Link Tracking</a></li>
    <li><a href="browser.php">Browser</a></li>
    <li><a href="calendar.php">Calendar</a></li>
    <li><a href="todolist.php">To-Do List</a></li>
    <li><a href="whois.php">WHOIS Lookup</a></li>
    <li><a href="utilitiesresolvercheck.php">Domain Resolver</a></li>
    <li><a href="systemintegrationcode.php">Integration Code</a></li>
    <li><a href="whmimport.php">cPanel/WHM Import</a></li>
    <li><a href="systemdatabase.php">Database Status</a></li>
    <li><a href="systemcleanup.php">System Cleanup</a></li>
    <li><a href="systemphpinfo.php">PHP Info</a></li>
</ul>

<span class="header"><img src="images/icons/logs.png" class="absmiddle" width="16" height="16" /> Logs</span>
<ul class="menu">
    <li><a href="systemactivitylog.php">Activity Log</a></li>
    <li><a href="systemadminlog.php">Admin Logins</a></li>
    <li><a href="systememaillog.php">Email Messages</a></li>
    <li><a href="systemmailimportlog.php">Ticket Mail Import</a></li>
    <li><a href="systemwhoislog.php">WHOIS Lookups</a></li>
</ul>

{elseif $sidebar eq "addonmodules"}

<span class="header"><img src="images/icons/addonmodules.png" class="absmiddle" width="16" height="16" /> Addon Modules</span>
<ul class="menu">
    {foreach from=$addon_modules key=filename item=addontitle}
    <li><a href="addonmodules.php?module={$filename}">{$addontitle}</a></li>
    {/foreach}
</ul>

{elseif $sidebar eq "config"}

<span class="header"><img src="images/icons/config.png" class="absmiddle" width="16" height="16" /> Configuration</span>
<ul class="menu">
    <li><a href="configgeneral.php">General Settings</a></li>
    <li><a href="configauto.php">Automation Settings</a></li>
    <li><a href="configemailtemplates.php">Email Templates</a></li>
    <li><a href="configfraud.php">Fraud Protection</a></li>
    <li><a href="configclientgroups.php">Client Groups</a></li>
    <li><a href="configcustomfields.php">Custom Client Fields</a></li>
    <li><a href="configadmins.php">Administrators</a></li>
    <li><a href="configadminroles.php">Administrator Roles</a></li>
</ul>

<span class="header"><img src="images/icons/income.png" class="absmiddle" width="16" height="16" /> Payments</span>
<ul class="menu">
    <li><a href="configcurrencies.php">Currencies</a></li>
    <li><a href="configgateways.php">Payment Gateways</a></li>
    <li><a href="configtax.php">Tax Rules</a></li>
    <li><a href="configpromotions.php">Promotions</a></li>
</ul>

<span class="header"><img src="images/icons/products.png" class="absmiddle" width="16" height="16" /> Products/Services</span>
<ul class="menu">
    <li><a href="configproducts.php">Products/Services</a></li>
    <li><a href="configproductoptions.php">Configurable Options</a></li>
    <li><a href="configaddons.php">Product Addons</a></li>
    <li><a href="configdomains.php">Domain Pricing</a></li>
    <li><a href="configregistrars.php">Domain Registrars</a></li>
    <li><a href="configservers.php">Servers</a></li>
</ul>

<span class="header"><img src="images/icons/support.png" class="absmiddle" width="16" height="16" /> Support</span>
<ul class="menu">
    <li><a href="configticketdepartments.php">Support Departments</a></li>
    <li><a href="configticketstatuses.php">Ticket Statuses</a></li>
    <li><a href="configticketescalations.php">Escalation Rules</a></li>
    <li><a href="configticketspamcontrol.php">Spam Control</a></li>
</ul>

<span class="header"><img src="images/icons/configother.png" class="absmiddle" width="16" height="16" /> Other</span>
<ul class="menu">
    <li><a href="configsecurityqs.php">Security Questions</a></li>
    <li><a href="configbannedips.php">Banned IPs</a></li>
    <li><a href="configbannedemails.php">Banned Emails</a></li>
    <li><a href="configbackups.php">Database Backups</a></li>
</ul>

{/if}

{if $sidebar eq "clients" OR $sidebar eq "orders" OR $sidebar eq "billing"}

<span class="plain_header">Quick Links</span>
<div class="smallfont">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td><a href="orders.php?filter=true&amp;status=Pending">Pending Orders</a></td>
      <td align="left" valign="middle">{$sidebarstats.orders.pending}</td>
    </tr>
    <tr>
      <td><a href="clients.php?status=Active">Active Clients</a></td>
      <td align="left" valign="middle">{$sidebarstats.clients.active}</td>
    </tr>
    <tr>
      <td><a href="clientshostinglist.php?status=Active">Active Services</a></td>
      <td align="left" valign="middle">{$sidebarstats.services.active}</td>
    </tr>
    <tr>
      <td><a href="clientsdomainlist.php?status=Active">Active Domains</a></td>
      <td align="left" valign="middle">{$sidebarstats.domains.active}</td>
    </tr>
    <tr>
      <td><a href="invoices.php?status=Overdue">Overdue Invoices</a></td>
      <td align="left" valign="middle">{$sidebarstats.invoices.overdue}</td>
    </tr>
    <tr>
      <td><a href="supporttickets.php?view=active">Active Support Tickets</a></td>
      <td align="left" valign="middle">{$sidebarstats.tickets.active}</td>
    </tr>
</table>
</div>

{/if}

<br />

<span class="plain_header">Advanced Search</span>
<div class="smallfont">

<form method="get" action="search.php">
    <select name="type" id="searchtype" onchange="populate(this)">
      <option value="clients">Clients </option>
      <option value="orders">Orders </option>
      <option value="services">Services </option>
      <option value="domains">Domains </option>
      <option value="invoices">Invoices </option>
      <option value="tickets">Tickets </option>
    </select>
    <select name="field" id="searchfield">
      <option>Client ID</option>
      <option selected="selected">Client Name</option>
      <option>Company Name</option>
      <option>Email Address</option>
      <option>Address 1</option>
      <option>Address 2</option>
      <option>City</option>
      <option>State</option>
      <option>Postcode</option>
      <option>Country</option>
      <option>Phone Number</option>
      <option>CC Last Four</option>
    </select>
    <input type="text" name="q" style="width:100%;" />
    <input type="submit" value="Search" class="button" />
  </form>

</div>

<br />

<span class="plain_header">Staff Online</span>
<div class="smallfont">{$adminsonline}</div>
