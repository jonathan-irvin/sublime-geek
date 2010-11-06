<p>{$LANG.clientareaheader}</p>

<table width="80%" align="center"><tr><td width="50%">
<table width="100%" height="125" class="clientareatable" cellspacing="1"><tr class="clientareatableactive"><td style="padding:10px;">
<strong>{$clientsdetails.firstname} {$clientsdetails.lastname} {if $clientsdetails.companyname}({$clientsdetails.companyname}){/if}</strong><br />
{$clientsdetails.address1}, {$clientsdetails.address2}<br />
{$clientsdetails.city}, {$clientsdetails.state}, {$clientsdetails.postcode}<br />
{$clientsdetails.countryname}<br />
{$clientsdetails.email}<br /><br />
<a href="clientarea.php?action=details"><img src="images/details.gif" border="0" hspace="5" align="absmiddle" alt="" />{$LANG.clientareaupdateyourdetails}</a>{if $addfundsenabled} <a href="clientarea.php?action=addfunds"><img src="images/affiliates.gif" border="0" align="absmiddle" alt="" /> {$LANG.addfunds}</a>{/if}
</td></tr></table>
</td><td width="50%" align="center">
<table width="100%" height="125" class="clientareatable" cellspacing="1"><tr class="clientareatableactive"><td style="padding:10px;">
<strong>{$LANG.accountstats}</strong><br />
{$LANG.statsnumproducts}: <strong>{$clientsstats.productsnumactive}</strong> ({$clientsstats.productsnumtotal})<br />
{$LANG.statsnumdomains}: <strong>{$clientsstats.numactivedomains}</strong> ({$clientsstats.numdomains})<br />
{$LANG.statsnumtickets}: <strong>{$clientsstats.numtickets}</strong><br />
{$LANG.statsnumreferredsignups}: <strong>{$clientsstats.numaffiliatesignups}</strong><br />
{$LANG.statscreditbalance}: <strong>{$clientsstats.creditbalance}</strong><br />
{$LANG.statsdueinvoicesbalance}: <strong>{if $clientsstats.numdueinvoices>0}<font color="#cc0000">{/if}{$clientsstats.dueinvoicesbalance}{if $clientsstats.numdueinvoices>0}</font>{/if}</strong><br />
</td></tr></table>
</td></tr></table>

{if in_array('tickets',$contactpermissions)}

<p class="heading2"><img src="images/supporttickets.gif" border="0" hspace="5" align="absmiddle" alt="" />{$clientsstats.numactivetickets} {$LANG.supportticketsopentickets} (<a href="submitticket.php">{$LANG.supportticketssubmitticket}</a>)</p>

<table align="center" style="width:90%" class="clientareatable" cellspacing="1">
<tr class="clientareatableheading"><td>{$LANG.supportticketsdate}</td><td>{$LANG.supportticketssubject}</td><td>{$LANG.supportticketsstatus}</td><td>{$LANG.supportticketsticketurgency}</td></tr>
{foreach key=num item=ticket from=$tickets}
<tr><td>{$ticket.date}</td><td><div align="left"><img src="images/article.gif" hspace="5" align="middle" alt="" /><a href="viewticket.php?tid={$ticket.tid}&amp;c={$ticket.c}">{if $ticket.unread}<strong>{/if}#{$ticket.tid} - {$ticket.subject}{if $ticket.unread}</strong>{/if}</a></div></td><td width="120">{$ticket.status}</td><td width="80">{$ticket.urgency}</td></tr>
{foreachelse}
<tr class="clientareatableactive"><td colspan="4">{$LANG.norecordsfound}</td></tr>
{/foreach}
</table>

{/if}

{if in_array('invoices',$contactpermissions)}

<p class="heading2"><img src="images/invoices.gif" border="0" hspace="5" align="absmiddle" alt="" />{$clientsstats.numdueinvoices} {$LANG.invoicesdue}</p>

<form method="post" action="clientarea.php?action=masspay">

<table align="center" style="width:90%" class="clientareatable" cellspacing="1">
<tr class="clientareatableheading">{if $masspay}<td width="15"></td>{/if}<td>{$LANG.invoicenumber}</td><td>{$LANG.invoicesdatecreated}</td><td>{$LANG.invoicesdatedue}</td><td>{$LANG.invoicestotal}</td><td>{$LANG.invoicesbalance}</td><td>{$LANG.invoicesstatus}</td><td></td></tr>
{foreach key=num item=invoice from=$invoices}
<tr>{if $masspay}<td><input type="checkbox" name="invoiceids[]" value="{$invoice.id}" /></td>{/if}<td><a href="viewinvoice.php?id={$invoice.id}" target="_blank">{$invoice.invoicenum}</a></td><td>{$invoice.datecreated}</td><td>{$invoice.datedue}</td><td>{$invoice.total}</td><td>{$invoice.balance}</td><td>{$invoice.status}</td><td><a href="viewinvoice.php?id={$invoice.id}" target="_blank">{$LANG.invoicesview}</a></td></tr>
{foreachelse}
<tr class="clientareatableactive"><td colspan="{if $masspay}8{else}7{/if}">{$LANG.norecordsfound}</td></tr>
{/foreach}
{if $invoices}<tr class="clientareatableheading"><td colspan="{if $masspay}4{else}3{/if}">{if $masspay}<input type="submit" value="{$LANG.masspayselected}" class="buttongo" />{/if}</td><td>{$LANG.invoicestotaldue}</td><td>{$totalbalance}</td><td colspan="2">{if $masspay}<a href="clientarea.php?action=masspay&all=true">{$LANG.masspayall}</a>{/if}</td></tr>{/if}
</table>

</form>

{/if}

{if $files}

<p class="heading2"><img src="images/file.png" border="0" hspace="5" align="absmiddle" alt="" /> {$LANG.clientareafiles}</p>

<table align="center" style="width:90%" class="clientareatable" cellspacing="1">
<tr class="clientareatableheading"><td>{$LANG.clientareafilesdate}</td><td>{$LANG.clientareafilesfilename}</td></tr>
{foreach key=num item=file from=$files}
<tr class="clientareatableactive"><td>{$file.date}</td><td align="left"><img src="images/file.png" hspace="5" align="middle" alt="" /> <a href="dl.php?type=f&id={$file.id}"><strong>{$file.title}</strong></a></td></tr>
{/foreach}
</table>

{/if}