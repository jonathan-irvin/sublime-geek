<p class="heading2">{$LANG.domaindnsmanagement}</p>

<p>{$LANG.domaindnsmanagementdesc}</p>

<p>{$LANG.domainname}: <strong>{$domain}</strong></p>

{if $error}<div class="errorbox">{$error}</div><br />{/if}

<form method="post" action="{$smarty.server.PHP_SELF}?action=domaindns">
<input type="hidden" name="sub" value="save" />
<input type="hidden" name="domainid" value="{$domainid}" />

<table class="clientareatable" style="width:80%;" align="center" cellspacing="1">
<tr class="clientareatableheading"><td align="center">{$LANG.domaindnshostname}</td><td>{$LANG.domaindnsrecordtype}</td><td>{$LANG.domaindnsaddress}</td></tr>
{foreach key=num item=dnsrecord from=$dnsrecords}
<tr class="clientareatableactive"><td><input type="text" name="dnsrecordhost[]" value="{$dnsrecord.hostname}" size="10" /></td><td><select name="dnsrecordtype[]">
<option value="A"{if $dnsrecord.type eq "A"} selected="selected"{/if}>A (Address)</option>
<option value="MXE"{if $dnsrecord.type eq "MXE"} selected="selected"{/if}>MXE (Mail Easy)</option>
<option value="MX"{if $dnsrecord.type eq "MX"} selected="selected"{/if}>MX (Mail)</option>
<option value="CNAME"{if $dnsrecord.type eq "CNAME"} selected="selected"{/if}>CNAME (Alias)</option>
<option value="TXT"{if $dnsrecord.type eq "TXT"} selected="selected"{/if}>SPF (txt)</option>
<option value="URL"{if $dnsrecord.type eq "URL"} selected="selected"{/if}>URL Redirect</option>
<option value="FRAME"{if $dnsrecord.type eq "FRAME"} selected="selected"{/if}>URL Frame</option>
</select></td><td><input type="text" name="dnsrecordaddress[]" value="{$dnsrecord.address}" size="40" /></td></tr>
{/foreach}
<tr class="clientareatableactive"><td><input type="text" name="dnsrecordhost[]" size="10" /></td><td><select name="dnsrecordtype[]">
<option value="A">A (Address)</option>
<option value="MXE">MXE (Mail Easy)</option>
<option value="MX">MX (Mail)</option>
<option value="CNAME">CNAME (Alias)</option>
<option value="TXT">SPF (txt)</option>
<option value="URL">URL Redirect</option>
<option value="FRAME">URL Frame</option>
</select></td><td><input type="text" name="dnsrecordaddress[]" size="40" /></td></tr>
</table>

<p align="center"><input type="submit" value="{$LANG.clientareasavechanges}" class="buttongo" /></p>

</form>

<form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
<input type="hidden" name="id" value="{$domainid}" />
<p align="center"><input type="submit" value="{$LANG.clientareabacklink}" class="button" /></p>
</form>