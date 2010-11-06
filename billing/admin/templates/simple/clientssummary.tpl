<table width="100%">
<tr><td>

<div style="font-size:18px;">#{$clientsdetails.userid} - {$clientsdetails.firstname} {$clientsdetails.lastname}</div>
<img src="images/spacer.gif" width="1" height="6" /><br />

</td><td colspan="2" align="right">

<a href="../dologin.php?username={$clientsdetails.email|urlencode}"><img src="images/icons/clientlogin.png" border="0" align="absmiddle" /> Login as Client</a>
<a href="clientssummary.php?userid={$clientsdetails.userid}&resetpw=true"><img src="images/icons/resetpw.png" border="0" align="absmiddle" /> Reset Password</a>
<a href="ordersadd.php?userid={$clientsdetails.userid}"><img src="images/icons/ordersadd.png" border="0" align="absmiddle" /> Add New Order</a>
<a href="invoices.php?action=createinvoice&userid={$clientsdetails.userid}"><img src="images/icons/invoicesedit.png" border="0" align="absmiddle" /> Create Invoice</a>
<a href="supporttickets.php?action=open&userid={$clientsdetails.userid}"><img src="images/icons/ticketsopen.png" border="0" align="absmiddle" /> Open Ticket</a>
<a href="#" onClick="window.open('clientsmerge.php?userid={$clientsdetails.userid}','movewindow','width=500,height=280,top=100,left=100');return false"><img src="images/icons/clients.png" border="0" align="absmiddle" /> Merge</a>
<a href="#" onClick="closeClient();return false" style="color:#000000;"><img src="images/icons/delete.png" border="0" align="absmiddle" /> Close</a>

</td></tr>
<tr><td width="34%" valign="top">

<div class="clientssummarybox">
<div class="title">Client Information</div>
<table class="clientssummarystats" cellspacing="0" cellpadding="2">
<tr><td width="110">First Name</td><td>{$clientsdetails.firstname}</td></tr>
<tr class="altrow"><td>Last Name</td><td>{$clientsdetails.lastname}</td></tr>
<tr><td>Company Name</td><td>{$clientsdetails.companyname}</td></tr>
<tr class="altrow"><td>Email Address</td><td>{$clientsdetails.email}</td></tr>
<tr><td>Address 1</td><td>{$clientsdetails.address1}</td></tr>
<tr class="altrow"><td>Address 2</td><td>{$clientsdetails.address2}</td></tr>
<tr><td>City</td><td>{$clientsdetails.city}</td></tr>
<tr class="altrow"><td>State</td><td>{$clientsdetails.state}</td></tr>
<tr><td>Postcode</td><td>{$clientsdetails.postcode}</td></tr>
<tr class="altrow"><td>Country</td><td>{$clientsdetails.country} - {$clientsdetails.countrylong}</td></tr>
<tr><td>Phone Number</td><td>{$clientsdetails.phonenumber}</td></tr>
</table>
<ul>
<li><a href="clientssummary.php?userid={$clientsdetails.userid}&resetpw=true"><img src="images/icons/resetpw.png" border="0" align="absmiddle" /> Reset & Send Password</a>
<li><a href="#" onClick="openCCDetails();return false"><img src="images/icons/offlinecc.png" border="0" align="absmiddle" /> Credit Card Information</a>
<li><a href="../dologin.php?username={$clientsdetails.email|urlencode}"><img src="images/icons/clientlogin.png" border="0" align="absmiddle" /> Login as Client</a>
</ul>
</div>

<div class="clientssummarybox">
<div class="title">Contacts/Sub-Accounts</div>
<table class="clientssummarystats" cellspacing="0" cellpadding="2">
{foreach key=num from=$contacts item=contact}
<tr class="{cycle values=",altrow"}"><td align="center"><a href="clientscontacts.php?userid={$clientsdetails.userid}&contactid={$contact.id}">{$contact.firstname} {$contact.lastname}</a> - {$contact.email}</td></tr>
{foreachelse}
<tr><td align="center">No additional contacts setup</td></tr>
{/foreach}
</table>
<ul>
<li><a href="clientscontacts.php?userid={$clientsdetails.userid}&contactid=addnew"><img src="images/icons/clientsadd.png" border="0" align="absmiddle" /> Add Contact</a>
</ul>
</div>

<div class="clientssummarybox">
<div class="title">Other Information</div>
<table class="clientssummarystats" cellspacing="0" cellpadding="2">
<tr><td width="110">Status</td><td>{$clientsdetails.status}</td></tr>
<tr class="altrow"><td>Client Group</td><td>{$clientgroup.name}</td></tr>
<tr><td>Tax Exempt</td><td>{$clientsdetails.taxstatus}</td></tr>
<tr class="altrow"><td>Signup Date</td><td>{$signupdate}</td></tr>
<tr><td>Client For</td><td>{$clientfor}</td></tr>
<tr class="altrow"><td width="110">Last Login</td><td>{$lastlogin}</td></tr>
</table>
</div>

</td><td width="33%" valign="top">

<div class="clientssummarybox">
<div class="title">Invoices/Billing</div>
<table class="clientssummarystats" cellspacing="0" cellpadding="2">
<tr><td width="110">Paid Invoices</td><td>{$stats.numpaidinvoices} ({$stats.paidinvoicesamount})</td></tr>
<tr class="altrow"><td>Unpaid/Due</td><td>{$stats.numdueinvoices} ({$stats.dueinvoicesbalance})</td></tr>
<tr><td>Cancelled</td><td>{$stats.numcancelledinvoices} ({$stats.cancelledinvoicesamount})</td></tr>
<tr class="altrow"><td>Refunded</td><td>{$stats.numrefundedinvoices} ({$stats.refundedinvoicesamount})</td></tr>
<tr><td>Collections</td><td>{$stats.numcollectionsinvoices} ({$stats.collectionsinvoicesamount})</td></tr>
<tr class="altrow"><td><strong>Income</strong></td><td><strong>{$stats.income}</strong></td></tr>
<tr><td>Credit Balance</td><td>{$stats.creditbalance}</td></tr>
</table>
<ul>
<li><a href="invoices.php?action=createinvoice&userid={$clientsdetails.userid}"><img src="images/icons/invoicesedit.png" border="0" align="absmiddle" /> Create Invoice</a>
<li><a href="#" onClick="showDialog('geninvoices');return false"><img src="images/icons/ticketspredefined.png" border="0" align="absmiddle" /> Generate Due Invoices</a>
<li><a href="clientsbillableitems.php?userid={$clientsdetails.userid}&action=manage"><img src="images/icons/billableitems.png" border="0" align="absmiddle" /> Add Billable Item</a>
<li><a href="#" onClick="window.open('clientscredits.php?userid={$clientsdetails.userid}','','width=750,height=350,scrollbars=yes');return false"><img src="images/icons/income.png" border="0" align="absmiddle" /> Manage Credits</a>
<li><a href="quotes.php?action=manage&userid={$clientsdetails.userid}"><img src="images/icons/quotes.png" border="0" align="absmiddle" /> Create Quote</a>
</ul>
</div>

<div class="clientssummarybox">
<div class="title">Files</div>
<table class="clientssummarystats" cellspacing="0" cellpadding="2">
{foreach key=num from=$files item=file}
<tr class="{cycle values=",altrow"}"><td align="center"><a href="../dl.php?type=f&id={$file.id}"><img src="../images/file.png" align="absmiddle" vspace="1" border="0" /> {$file.title}</a> {if $file.adminonly}(Admin Only){/if} <img src="images/icons/delete.png" align="absmiddle" border="0" onClick="deleteFile('{$file.id}')" /></td></tr>
{foreachelse}
<tr><td align="center">No files uploaded</td></tr>
{/foreach}
</table>
<ul>
<li><a href="#" id="addfile"><img src="images/icons/add.png" border="0" align="absmiddle" /> Add File</a>
</ul>
<div id="addfileform" style="display:none;">
<img src="images/spacer.gif" width="1" height="4" /><br />
<form method="post" action="clientssummary.php?userid={$clientsdetails.userid}&action=uploadfile" enctype="multipart/form-data">
<table class="clientssummarystats" cellspacing="0" cellpadding="2">
<tr><td width="40">Title</td><td class="fieldarea"><input type="text" name="title" style="width:90%" /></td></tr>
<tr><td>File</td><td class="fieldarea"><input type="file" name="uploadfile" style="width:90%" /></td></tr>
<tr><td></td><td class="fieldarea"><input type="checkbox" name="adminonly" value="1" /> Admin Only &nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" value="Add" /></td></tr>
</table>
</form>
</div>
</div>

<div class="clientssummarybox">
<div class="title">Recent Emails</div>
<table class="clientssummarystats" cellspacing="0" cellpadding="2">
{foreach key=num from=$lastfivemail item=email}
<tr class="{cycle values=",altrow"}"><td align="center">{$email.date} - <a href="#" onClick="window.open('clientsemails.php?&displaymessage=true&id={$email.id}','','width=650,height=400,scrollbars=yes');return false">{$email.subject}</a></td></tr>
{foreachelse}
<tr><td align="center">No emails sent</td></tr>
{/foreach}
</table>
</div>

</td><td width="33%" valign="top">

<div class="clientssummarybox">
<div class="title">Products/Services</div>
<table class="clientssummarystats" cellspacing="0" cellpadding="2">
<tr><td width="140">Hosting Accounts</td><td>{$stats.productsnumactivehosting} ({$stats.productsnumhosting} Total)</td></tr>
<tr class="altrow"><td>Reseller Accounts</td><td>{$stats.productsnumactivereseller} ({$stats.productsnumreseller} Total)</td></tr>
<tr><td>Dedicated/VPS Servers</td><td>{$stats.productsnumactiveservers} ({$stats.productsnumservers} Total)</td></tr>
<tr class="altrow"><td>Products/Services</td><td>{$stats.productsnumactiveother} ({$stats.productsnumother} Total)</td></tr>
<tr><td>Domains</td><td>{$stats.numactivedomains} ({$stats.numdomains} Total)</td></tr>
<tr class="altrow"><td>Accepted Quotes</td><td>{$stats.numacceptedquotes} ({$stats.numquotes} Total)</td></tr>
<tr><td>Support Tickets</td><td>{$stats.numactivetickets} ({$stats.numtickets} Total)</td></tr>
<tr class="altrow"><td>Affiliate Signups</td><td>{$stats.numaffiliatesignups}</td></tr>
</table>
<ul>
<li><a href="orders.php?client={$clientsdetails.userid}"><img src="images/icons/orders.png" border="0" align="absmiddle" /> View Orders</a>
<li><a href="ordersadd.php?userid={$clientsdetails.userid}"><img src="images/icons/ordersadd.png" border="0" align="absmiddle" /> Add New Order</a>
</ul>
</div>

<div class="clientssummarybox">
<div class="title">Send Email</div>
<form action="clientsemails.php?userid={$clientsdetails.userid}&action=send&type=general" method="post">
<input type="hidden" name="id" value="{$clientsdetails.userid}">
<div align="center">{$messages} <input type="submit" value="Send" class="button"></div>
</form>
</div>

<div class="clientssummarybox">
<div class="title">Other Actions</div>
<ul>
<li><a href="reports.php?report=client_statement&userid={$clientsdetails.userid}"><img src="images/icons/reports.png" border="0" align="absmiddle" /> View Account Statement</a>
<li><a href="supporttickets.php?action=open&userid={$clientsdetails.userid}"><img src="images/icons/ticketsopen.png" border="0" align="absmiddle" /> Open New Support Ticket</a>
<li><a href="supporttickets.php?view=any&client={$clientsdetails.userid}"><img src="images/icons/ticketsother.png" border="0" align="absmiddle" /> View all Support Tickets</a>
<li><a href="{if $affiliateid}affiliates.php?action=edit&id={$affiliateid}{else}clientssummary.php?userid={$clientsdetails.userid}&activateaffiliate=true{/if}"><img src="images/icons/affiliates.png" border="0" align="absmiddle" /> {if $affiliateid}View Affiliate Details{else}Activate as Affiliate{/if}</a>
<li><a href="#" onClick="window.open('clientsmerge.php?userid={$clientsdetails.userid}','movewindow','width=500,height=280,top=100,left=100');return false"><img src="images/icons/clients.png" border="0" align="absmiddle" /> Merge Clients Accounts</a>
<li><a href="#" onClick="closeClient();return false" style="color:#000000;"><img src="images/icons/delete.png" border="0" align="absmiddle" /> Close Clients Account</a>
<li><a href="#" onClick="deleteClient();return false" style="color:#CC0000;"><img src="images/icons/delete.png" border="0" align="absmiddle" /> Delete Clients Account</a>
</ul>
</div>

<div class="clientssummarybox">
<div class="title">Admin Notes</div>
<form method="post" action="{$smarty.server.PHP_SELF}?userid={$clientsdetails.userid}&action=savenotes">
<div align="center">
<textarea name="adminnotes" rows="6" style="width:90%;" />{$clientsdetails.notes}</textarea><br />
<input type="submit" value="Submit" class="button" />
</div>
</form>
</div>

</td></tr>
<tr><td colspan="3">

<form method="post" action="{$smarty.server.PHP_SELF}?userid={$clientsdetails.userid}&action=massaction">

<table width="100%" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Products/Services</strong></td></tr>
<tr><td align="center">

<div class="tablebg">
<table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
<tr><th width="20"></th><th>ID</th><th>Product/Service</th><th>Amount</th><th>Billing Cycle</th><th>Signup Date</th><th>Next Due Date</th><th>Status</th><th width="20"></th></tr>
{foreach key=num from=$productsummary item=product}
<tr><td><input type="checkbox" name="selproducts[]" value="{$product.id}" /></td><td><a href="clientshosting.php?userid={$clientsdetails.userid}&hostingid={$product.id}">{$product.idshort}</a></td><td style="padding-left:5px;padding-right:5px">{$product.dpackage} - <a href="http://{$product.domain}" target="_blank">{$product.domain}</a></td><td>{$product.amount}</td><td>{$product.dbillingcycle}</td><td>{$product.regdate}</td><td>{$product.nextduedate}</td><td>{$product.domainstatus}</td><td><a href="clientshosting.php?userid={$clientsdetails.userid}&hostingid={$product.id}"><img src="images/edit.gif" width="16" height="16" border="0" alt="Edit"></a></td></tr>
{foreachelse}
<tr><td colspan="9">No Products/Services Found</td></tr>
{/foreach}
</table>
</div>

</td></tr></table>

<img src="images/spacer.gif" width="1" height="4" /><br />

<table width="100%" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Addons</strong></td></tr>
<tr><td align="center">

<div class="tablebg">
<table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
<tr><th width="20"></th><th>ID</th><th>Addon Details</th><th>Amount</th><th>Billing Cycle</th><th>Signup Date</th><th>Next Due Date</th><th>Status</th><th width="20"></th></tr>
{foreach key=num from=$addonsummary item=addon}
<tr><td><input type="checkbox" name="seladdons[]" value="{$addon.id}" /></td><td><a href="clientshosting.php?userid={$clientsdetails.userid}&hostingid={$addon.hostingid}">{$addon.idshort}</a></td><td style="padding-left:5px;padding-right:5px">{$addon.addonname}<br>{$addon.dpackage} - <a href="http://{$addon.domain}" target="_blank">{$addon.domain}</a></td><td>{$addon.amount}</td><td>{$addon.dbillingcycle}</td><td>{$addon.regdate}</td><td>{$addon.nextduedate}</td><td>{$addon.status}</td><td><a href="clientshosting.php?userid={$clientsdetails.userid}&hostingid={$addon.hostingid}"><img src="images/edit.gif" width="16" height="16" border="0" alt="Edit"></a></td></tr>
{foreachelse}
<tr><td colspan="9">No Addons Found</td></tr>
{/foreach}
</table>
</div>

</td></tr></table>

<img src="images/spacer.gif" width="1" height="4" /><br />

<table width="100%" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Domains</strong></td></tr>
<tr><td align="center">

<div class="tablebg">
<table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
<tr><th width="20"></th><th>ID</th><th>Domain</th><th>Registrar</th><th>Reg Date</th><th>Next Due Date</th><th>Expiry Date</th><th>Status</th><th width="20"></th></tr>
{foreach key=num from=$domainsummary item=domain}
<tr><td><input type="checkbox" name="seldomains[]" value="{$domain.id}" /></td><td><a href="clientsdomains.php?userid={$clientsdetails.userid}&domainid={$domain.id}">{$domain.idshort}</a></td><td style="padding-left:5px;padding-right:5px"><a href="http://{$domain.domain}" target="_blank">{$domain.domain}</a></td><td>{$domain.registrar}</td><td>{$domain.registrationdate}</td><td>{$domain.nextduedate}</td><td>{$domain.expirydate}</td><td>{$domain.status}</td><td><a href="clientsdomains.php?userid={$clientsdetails.userid}&domainid={$domain.id}"><img src="images/edit.gif" width="16" height="16" border="0" alt="Edit"></a></td></tr>
{foreachelse}
<tr><td colspan="9">No Domains Found</td></tr>
{/foreach}
</table>
</div>

</td></tr></table>

<img src="images/spacer.gif" width="1" height="4" /><br />

<table width="100%" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Current Quotes</strong></td></tr>
<tr><td align="center">

<div class="tablebg">
<table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
<tr><th>ID</th><th>Subject</th><th>Create Date</th><th>Total</th><th>Valid Until Date</th><th>Status</th><th width="20"></th></tr>
{foreach key=num from=$quotes item=quote}
<tr><td>{$quote.id}</td><td style="padding-left:5px;padding-right:5px">{$quote.subject}</td><td>{$quote.datecreated}</td><td>{$quote.total}</td><td>{$quote.validuntil}</td><td>{$quote.stage}</td><td><a href="quotes.php?action=manage&id={$quote.id}"><img src="images/edit.gif" width="16" height="16" border="0" alt="Edit"></a></td></tr>
{foreachelse}
<tr><td colspan="7">No Quotes Found</td></tr>
{/foreach}
</table>
</div>

</td></tr></table>

<p align="center"><input type="submit" name="inv" value="Invoice Selected Items" class="button" /> <input type="submit" name="del" value="Delete Selected Items" class="button" /></p>

</form>

</td></tr></table>
