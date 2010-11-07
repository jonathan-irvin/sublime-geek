<link rel="stylesheet" type="text/css" href="templates/orderforms/web20cart/style.css" />
<h2>{$LANG.cartproductaddons}</h2>
<div class="cartmenu" align="center"> {foreach key=num item=productgroup from=$productgroups}
  {if $gid eq $productgroup.gid}
  {$productgroup.name} | 
  {else} <a href="{$smarty.server.PHP_SELF}?gid={$productgroup.gid}">{$productgroup.name}</a> | 
  {/if}
  {/foreach}
  {if $loggedin}
  <strong>{$LANG.cartproductaddons} </strong>|
  {if $renewalsenabled}<a href="{$smarty.server.PHP_SELF}?gid=renewals">{$LANG.domainrenewals}</a> | {/if}
  {/if}
  {if $registerdomainenabled}<a href="{$smarty.server.PHP_SELF}?a=add&domain=register">{$LANG.registerdomain}</a> |{/if}
  {if $transferdomainenabled}<a href="{$smarty.server.PHP_SELF}?a=add&domain=transfer">{$LANG.transferdomain}</a> |{/if} <a href="{$smarty.server.PHP_SELF}?a=view">{$LANG.viewcart}</a> </div>
<br />
{foreach from=$addons item=addon}
<div class="cartbox" align="center">
  <form method="post" action="{$smarty.server.PHP_SELF}?a=add">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="40%" align="left" valign="top">
    <input type="hidden" name="aid" value="{$addon.id}" />
    <strong>{$addon.name}</strong><br />
    {$addon.description}</td>
      <td width="40%" align="center" valign="middle" class="pricing"> {if $addon.free}
        {$LANG.orderfree}
        {else}
        {if $addon.setupfee}{$currencysymbol}{$addon.setupfee} {$LANG.ordersetupfee}<br />
        {/if}
        {$currencysymbol}{$addon.recurringamount} {$addon.billingcycle}
      {/if}</td>
      <td width="20%" align="center" valign="middle"><input type="submit" value="{$LANG.ordernowbutton}" /></td>
    </tr>
  </table>
  {$LANG.cartproductaddonschoosepackage}: <select name="productid">{foreach from=$addon.productids item=product}
<option value="{$product.id}">{$product.product}{if $product.domain} - {$product.domain}{/if}</option>
{/foreach}</select>
  </form>
</div>
<br />
{/foreach}

{if $noaddons}
<div class="errorbox">{$LANG.cartproductaddonsnone}</div>
{/if}
<p align="center">
  <input type="button" value="{$LANG.viewcart}" onclick="window.location='cart.php?a=view'" class="button" />
</p><br />