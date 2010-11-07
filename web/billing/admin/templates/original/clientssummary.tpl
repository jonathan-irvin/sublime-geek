<div style="font-size:18px;">#{$clientsdetails.userid} - {$clientsdetails.firstname} {$clientsdetails.lastname}</div>
<img src="images/spacer.gif" width="1" height="6" /><br />

<table width=100%>
<tr><td width=34% valign=top>

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Client Information</strong></td></tr>
<tr><td width="90" class="fieldlabel">First Name</td><td class="fieldarea">{$clientsdetails.firstname}</td></tr>
<tr><td class="fieldlabel">Last Name</td><td class="fieldarea">{$clientsdetails.lastname}</td></tr>
<tr><td class="fieldlabel">Company Name</td><td class="fieldarea">{$clientsdetails.companyname}</td></tr>
<tr><td class="fieldlabel">Email Address</td><td class="fieldarea">{$clientsdetails.email}</td></tr>
<tr><td class="fieldlabel">Address 1</td><td class="fieldarea">{$clientsdetails.address1}</td></tr>
<tr><td class="fieldlabel">Address 2</td><td class="fieldarea">{$clientsdetails.address2}</td></tr>
<tr><td class="fieldlabel">City</td><td class="fieldarea">{$clientsdetails.city}</td></tr>
<tr><td class="fieldlabel">State</td><td class="fieldarea">{$clientsdetails.state}</td></tr>
<tr><td class="fieldlabel">Postcode</td><td class="fieldarea">{$clientsdetails.postcode}</td></tr>
<tr><td class="fieldlabel">Country</td><td class="fieldarea">{$clientsdetails.country} - {$clientsdetails.countrylong}</td></tr>
<tr><td class="fieldlabel">Phone Number</td><td class="fieldarea">{$clientsdetails.phonenumber}</td></tr>
</table>

<img src="images/spacer.gif" width="1" height="4" /><br />

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Contacts/Sub-Accounts</strong></td></tr>
<tr><td align="center">
{foreach key=num from=$contacts item=contact}
{$contact.firstname} {$contact.lastname} - {$contact.email}<br />
{foreachelse}
No additional contacts setup
{/foreach}

</td></tr></table>

<img src="images/spacer.gif" width="1" height="4" /><br />

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Other Information</strong></td></tr>
<tr><td width="90" class="fieldlabel">Status</td><td class="fieldarea">{$clientsdetails.status}</td></tr>
<tr><td class="fieldlabel">Client Group</td><td class="fieldarea">{$clientgroup.name}</td></tr>
<tr><td class="fieldlabel">Tax Exempt</td><td class="fieldarea">{$clientsdetails.taxstatus}</td></tr>
<tr><td class="fieldlabel">Signup Date</td><td class="fieldarea">{$signupdate}</td></tr>
<tr><td class="fieldlabel">Client For</td><td class="fieldarea">{$clientfor}</td></tr>
<tr><td class="fieldlabel">Last Login</td><td class="fieldarea">{$lastlogin}</td></tr>
</table>

</td><td width=33% valign=top>

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Client Stats</strong></td></tr>
<tr><td width="125" class="fieldlabel">Invoices Paid</td><td class="fieldarea">{$stats.numpaidinvoices} ({$stats.paidinvoicesamount})</td></tr>
<tr><td class="fieldlabel">Invoices Due</td><td class="fieldarea">{$stats.numdueinvoices} ({$stats.dueinvoicesbalance})</td></tr>
<tr><td class="fieldlabel">Invoices Cancelled</td><td class="fieldarea">{$stats.numcancelledinvoices} ({$stats.cancelledinvoicesamount})</td></tr>
<tr><td class="fieldlabel">Invoices Refunded</td><td class="fieldarea">{$stats.numrefundedinvoices} ({$stats.refundedinvoicesamount})</td></tr>
<tr><td class="fieldlabel">Income</td><td class="fieldarea">{$stats.income}</td></tr>
<tr><td class="fieldlabel">Credit Balance</td><td class="fieldarea">{$stats.creditbalance}</td></tr>
<tr><td class="fieldlabel">Hosting Accounts</td><td class="fieldarea">{$stats.productsnumactivehosting} ({$stats.productsnumhosting} Total)</td></tr>
<tr><td class="fieldlabel">Reseller Accounts</td><td class="fieldarea">{$stats.productsnumactivereseller} ({$stats.productsnumreseller} Total)</td></tr>
<tr><td class="fieldlabel">Dedicated/VPS Servers</td><td class="fieldarea">{$stats.productsnumactiveservers} ({$stats.productsnumservers} Total)</td></tr>
<tr><td class="fieldlabel">Products/Services</td><td class="fieldarea">{$stats.productsnumactiveother} ({$stats.productsnumother} Total)</td></tr>
<tr><td class="fieldlabel">Domains</td><td class="fieldarea">{$stats.numactivedomains} ({$stats.numdomains} Total)</td></tr>
<tr><td class="fieldlabel">Accepted Quotes</td><td class="fieldarea">{$stats.numacceptedquotes} ({$stats.numquotes} Total)</td></tr>
<tr><td class="fieldlabel">Support Tickets</td><td class="fieldarea">{$stats.numactivetickets} ({$stats.numtickets} Total)</td></tr>
<tr><td class="fieldlabel">Affiliate Signups</td><td class="fieldarea">{$stats.numaffiliatesignups}</td></tr>
</table>

<img src="images/spacer.gif" width="1" height="4" /><br />

<table width="100%" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Files</strong></td></tr>
<tr><td align="center">
<div align="left">
{foreach key=num from=$files item=file}
<a href="../dl.php?type=f&id={$file.id}"><img src="../images/file.png" align="absmiddle" vspace="1" border="0" /> {$file.title}</a> {if $file.adminonly}(Admin Only){/if} <img src="images/icons/delete.png" align="absmiddle" border="0" onClick="deleteFile('{$file.id}')" /><br />
{foreachelse}
<div align="center">No files uploaded</div>
{/foreach}
</div>
<div align="right"><a href="#" id="addfile">Add File <img src="images/icons/add.png" align="absmiddle" border="0" /></a></div>
</td></tr></table>

<div id="addfileform" style="display:none;">
<img src="images/spacer.gif" width="1" height="4" /><br />
<form method="post" action="clientssummary.php?userid={$clientsdetails.userid}&action=uploadfile" enctype="multipart/form-data">
<table width="100%" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Add File</strong></td></tr>
<tr><td width="30" class="fieldlabel">Title</td><td class="fieldarea"><input type="text" name="title" style="width:90%" /></td></tr>
<tr><td class="fieldlabel">File</td><td class="fieldarea"><input type="file" name="uploadfile" style="width:90%" /></td></tr>
<tr><td class="fieldlabel"></td><td class="fieldarea"><input type="checkbox" name="adminonly" value="1" /> Admin Only &nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" value="Add" /></td></tr>
</table>
</form>
</div>

<img src="images/spacer.gif" width="1" height="4" /><br />

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Last 5 Emails</strong></td></tr>
<tr><td>
{foreach key=num from=$lastfivemail item=email}
{$email.date} - <a href="#" onClick="window.open('clientsemails.php?&displaymessage=true&id={$email.id}','','width=650,height=400,scrollbars=yes');return false">{$email.subject}</a><br />
{foreachelse}
<div style='text-align:center;'>No emails sent</div>
{/foreach}
</td></tr></table>

</td><td width=33% valign=top>

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Actions</strong></td></tr>
<tr><td align="center">

<a href="../dologin.php?username={$clientsdetails.email|urlencode}">Login as Client</a><br />
<a href="clientssummary.php?userid={$clientsdetails.userid}&resetpw=true">Reset & Send Password</a><br /><br />
{if $clientsdetails.status neq "Closed"}<a href="ordersadd.php?userid={$clientsdetails.userid}">Add New Order</a><br />
<a href="quotes.php?action=manage&userid={$clientsdetails.userid}">Create Quote</a><br />
<a href="invoices.php?action=createinvoice&userid={$clientsdetails.userid}">Create Invoice</a><br />
<a href="#" onClick="showDialog('geninvoices');return false">Generate Due Invoices</a><br /><br />{/if}
<a href="orders.php?client={$clientsdetails.userid}">View Orders</a><br />
<a href="quotes.php?userid={$clientsdetails.userid}">View Quotes</a><br />
<a href="#" onClick="window.open('clientscredits.php?userid={$clientsdetails.userid}','','width=750,height=350,scrollbars=yes');return false">Manage Credits</a><br />
<a href="clientstransactions.php?userid={$clientsdetails.userid}">View Transactions History</a><br />
<a href="#" onClick="openCCDetails();return false">Manage Credit Card Information</a><br />
<a href="reports.php?report=client_statement&userid={$clientsdetails.userid}">View Account Statement</a><br /><br />
{if $clientsdetails.status neq "Closed"}<a href="supporttickets.php?action=open&userid={$clientsdetails.userid}">Open New Support Ticket</a><br />{/if}
<a href="supporttickets.php?view=any&client={$clientsdetails.userid}">View all Support Tickets</a><br /><br />
{$afflink}
<a href="#" onClick="window.open('clientsmerge.php?userid={$clientsdetails.userid}','movewindow','width=500,height=280,top=100,left=100');return false">Merge Clients Accounts</a><br />
<a href="#" onClick="closeClient();return false" style="color:#000000;">Close Clients Account</a><br />
<a href="#" onClick="deleteClient();return false" style="color:#CC0000;">Delete Clients Account</a><br /><br />
</td></tr></table>

<img src="images/spacer.gif" width="1" height="4" /><br />

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Send Email</strong></td></tr>
<tr><td align="center">
<form action="clientsemails.php?userid={$clientsdetails.userid}&action=send&type=general" method="post">
<input type="hidden" name="id" value="{$clientsdetails.userid}">
{$messages}
<input type="submit" value="Send" class="button">
</form>
</td></tr></table>

<img src="images/spacer.gif" width="1" height="4" /><br />

<table width="250" class="form">
<tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>Admin Notes</strong></td></tr>
<tr><td align="center">
<form method="post" action="{$smarty.server.PHP_SELF}?userid={$clientsdetails.userid}&action=savenotes">
<textarea name="adminnotes" rows="6" cols="38" />{$clientsdetails.notes}</textarea>
<div align="center"><input type="submit" value="Submit" class="button" /></div>
</form>
</td></tr></table>

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
