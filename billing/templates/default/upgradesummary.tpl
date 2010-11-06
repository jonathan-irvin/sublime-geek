<form method="post" action="{$smarty.server.PHP_SELF}">
<input type="hidden" name="step" value="3">
<input type="hidden" name="type" value="{$type}">
<input type="hidden" name="id" value="{$id}">
{foreach from=$configoptions key=id item=value}<input type="hidden" name="configoption[{$id}]" value="{$value}" />{/foreach}

<p>{$LANG.upgradesummary}</p>

<p>{$LANG.orderproduct}:<strong> {$groupname} - {$productname}</strong>{if $domain} ({$domain}){/if}</p>

<table class="clientareatable" cellspacing="1">
<tr class="clientareatableheading"><td width="55%">{$LANG.orderdesc}</td><td width="45%">{$LANG.orderprice}</td></tr>

{foreach key=num item=upgrade from=$upgrades}
{if $type eq "package"}
<tr class="clientareatableactive"><td><input type="hidden" name="pid" value="{$upgrade.newproductid}" /><input type="hidden" name="billingcycle" value="{$upgrade.newproductbillingcycle}" />{$upgrade.oldproductname} => {$upgrade.newproductname}</td><td align="center">{$upgrade.price}</td></tr>
{elseif $type eq "configoptions"}
<tr class="clientareatableactive"><td>{$upgrade.configname}: {$upgrade.originalvalue} => {$upgrade.newvalue}</td><td align="center">{$currencysymbol}{$upgrade.price} {$currency}</td></tr>
{/if}
{/foreach}

<tr class="clientareatableheading"><td align="right">{$LANG.ordersubtotal}: &nbsp;</td><td align="center">{$currencysymbol}{$subtotal} {$currency}</td></tr>
{if $taxrate}
<tr class="clientareatableheading"><td align="right">{$taxname} @ {$taxrate}%: &nbsp;</td><td align="center">{$currencysymbol}{$tax} {$currency}</td></tr>
{/if}
{if $taxrate2}
<tr class="clientareatableheading"><td align="right">{$taxname2} @ {$taxrate2}%: &nbsp;</td><td align="center">{$currencysymbol}{$tax2} {$currency}</td></tr>
{/if}
<tr class="clientareatableheading"><td align="right">{$LANG.ordertotalduetoday}: &nbsp;</td><td align="center">{$currencysymbol}{$total} {$currency}</td></tr>
</table>

{if $type eq "package"}<p align="center">{$LANG.upgradeproductlogic} ({$upgrade.daysuntilrenewal} {$LANG.days})</p>{/if}

<p><strong>{$LANG.orderpaymentmethod}</strong></p>
<p>{foreach key=num item=gateway from=$gateways}<input type="radio" name="paymentmethod" value="{$gateway.sysname}" id="pgbtn{$num}"{if $selectedgateway eq $gateway.sysname} checked{/if}><label for="pgbtn{$num}">{$gateway.name}</label> {/foreach}</p>

<p align="center"><input type="submit" value="{$LANG.ordercontinuebutton}" class="buttongo" /></p>

</form>