<h2>{$LANG.clientareacancelrequest}</h2>

{if $invalid}

<p>{$LANG.clientareacancelinvalid}</p>

{else}

{if $requested}

<p>{$LANG.clientareacancelconfirmation}</p>

{else}

<p>{$LANG.clientareacancelproduct}: <strong>{$groupname} - {$productname}</strong>{if $domain} ({$domain}){/if}</p>

<form method="post" action="{$smarty.server.PHP_SELF}?action=cancel&amp;id={$id}">
<input type="hidden" name="sub" value="submit" />
<table width=80% align="center">
<tr><td>{if $error}<font style="color:#cc0000;font-weight:bold;">{/if}{$LANG.clientareacancelreason}:</td></tr>
<tr><td><textarea name="cancellationreason" rows="6" style="width:100%;"></textarea></td></tr>
<tr><td align="center">{$LANG.clientareacancellationtype}: <select name="type"><option value="Immediate">{$LANG.clientareacancellationimmediate}</option><option value="End of Billing Period">{$LANG.clientareacancellationendofbillingperiod}</option></select></td></tr>
</table>
<p align="center"><input type="submit" value="{$LANG.clientareacancelrequestbutton}" class="button" /></p>
</form>

{/if}{/if}