<link rel="stylesheet" type="text/css" href="templates/orderforms/web20cart/style.css" />
<h2>{$LANG.cartbrowse}</h2>
<div class="cartmenu" align="center"> {foreach key=num item=productgroup from=$productgroups}
  {if $gid eq $productgroup.gid}
  <strong>{$productgroup.name}</strong> | 
  {else} <a href="{$smarty.server.PHP_SELF}?gid={$productgroup.gid}">{$productgroup.name}</a> | 
  {/if}
  {/foreach}
  {if $loggedin}
  <a href="{$smarty.server.PHP_SELF}?gid=addons">{$LANG.cartproductaddons}</a> |
  {if $renewalsenabled}<a href="{$smarty.server.PHP_SELF}?gid=renewals">{$LANG.domainrenewals}</a> | {/if}
  {/if}
  {if $registerdomainenabled}<a href="{$smarty.server.PHP_SELF}?a=add&domain=register">{$LANG.registerdomain}</a> |{/if}
  {if $transferdomainenabled}<a href="{$smarty.server.PHP_SELF}?a=add&domain=transfer">{$LANG.transferdomain}</a> |{/if} <a href="{$smarty.server.PHP_SELF}?a=view">{$LANG.viewcart}</a> </div>

{if !$loggedin && $currencies}
<form method="post" action="cart.php?gid={$smarty.get.gid}">
<p align="right">{$LANG.choosecurrency}: <select name="currency" onchange="submit()">{foreach from=$currencies item=curr}
<option value="{$curr.id}"{if $curr.id eq $currency.id} selected{/if}>{$curr.code}</option>
{/foreach}</select> <input type="submit" value="{$LANG.go}" /></p>
</form>
<br />
{/if}

{foreach key=num item=product from=$products}
<div class="cartbox" align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40%" align="left" valign="top"><strong>{$product.name}</strong> {if $product.qty!=""}<em>({$product.qty} {$LANG.orderavailable})</em>{/if}<br />
{if $product.description}{$product.description}<br />
{/if}</td>
    <td width="40%" align="center" valign="middle" class="pricing">{if $product.paytype eq "free"}
      {$LANG.orderfree}
      {elseif $product.paytype eq "onetime"}
      {$product.pricing.onetime} {$LANG.orderpaymenttermonetime}
      {elseif $product.paytype eq "recurring"}
      {if $product.pricing.monthly}{$product.pricing.monthly}<br />
      {/if}
      {if $product.pricing.quarterly}{$product.pricing.quarterly}<br />
      {/if}
      {if $product.pricing.semiannually}{$product.pricing.semiannually}<br />
      {/if}
      {if $product.pricing.annually}{$product.pricing.annually}<br />
      {/if}
      {if $product.pricing.biennially}{$product.pricing.biennially}<br />
      {/if}
      {if $product.pricing.triennially}{$product.pricing.triennially}<br />
      {/if}
    {/if}</td>
    <td width="20%" align="center" valign="middle"><input type="button" value="{$LANG.ordernowbutton}"{if $product.qty eq "0"} disabled{/if} onclick="window.location='{$smarty.server.PHP_SELF}?a=add&pid={$product.pid}'" class="buttongo" /></td>
  </tr>
</table>
</div>
<br />
{/foreach}
<p align="center">
  <input type="button" value="{$LANG.viewcart}" onclick="window.location='cart.php?a=view'" class="button" />
</p>
