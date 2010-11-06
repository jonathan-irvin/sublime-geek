<link rel="stylesheet" type="text/css" href="templates/orderforms/web20cart/style.css" />

<form method="post" action="{$smarty.server.PHP_SELF}">
<input type="hidden" name="step" value="3">
<input type="hidden" name="type" value="{$type}">
<input type="hidden" name="id" value="{$id}">
{foreach from=$configoptions key=id item=value}<input type="hidden" name="configoption[{$id}]" value="{$value}" />{/foreach}

<p>{$LANG.upgradesummary}</p>

<p>{$LANG.orderproduct}:<strong> {$groupname} - {$productname}</strong>{if $domain} ({$domain}){/if}</p>

<table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" class="data">
  <tr>
    <th width="55%">{$LANG.orderdesc}</th>
    <th width="45%">{$LANG.orderprice}</th>
  </tr>

{foreach key=num item=upgrade from=$upgrades}
{if $type eq "package"}
<tr class="carttableproduct"><td><input type="hidden" name="pid" value="{$upgrade.newproductid}" /><input type="hidden" name="billingcycle" value="{$upgrade.newproductbillingcycle}" />{$upgrade.oldproductname} => {$upgrade.newproductname}</td><td align="center">{$currencysymbol}{$upgrade.price} {$currency}</td></tr>
{elseif $type eq "configoptions"}
<tr class="carttableproduct"><td>{$upgrade.configname}: {$upgrade.originalvalue} => {$upgrade.newvalue}</td><td align="center">{$currencysymbol}{$upgrade.price} {$currency}</td></tr>
{/if}
{/foreach}

<tr class="carttablesummary"><td align="right">{$LANG.ordersubtotal}: &nbsp;</td><td align="center">{$currencysymbol}{$subtotal} {$currency}</td></tr>
{if $taxrate}
<tr class="carttablesummary"><td align="right">{$taxname} @ {$taxrate}%: &nbsp;</td><td align="center">{$currencysymbol}{$tax} {$currency}</td></tr>
{/if}
{if $taxrate2}
<tr class="carttablesummary"><td align="right">{$taxname2} @ {$taxrate2}%: &nbsp;</td><td align="center">{$currencysymbol}{$tax2} {$currency}</td></tr>
{/if}
<tr class="carttabledue"><td align="right">{$LANG.ordertotalduetoday}: &nbsp;</td><td align="center">{$currencysymbol}{$total} {$currency}</td></tr>
</table>

{if $type eq "package"}<p align="center">{$LANG.upgradeproductlogic} ({$upgrade.daysuntilrenewal} {$LANG.days})</p>{/if}

<p><strong>{$LANG.orderpaymentmethod}</strong></p>
<p>{foreach key=num item=gateway from=$gateways}<input type="radio" name="paymentmethod" value="{$gateway.sysname}" id="pgbtn{$num}"{if $selectedgateway eq $gateway.sysname} checked{/if}><label for="pgbtn{$num}">{$gateway.name}</label> {/foreach}</p>

<p align="center"><input type="submit" value="{$LANG.ordercontinuebutton}"></p>

</form>