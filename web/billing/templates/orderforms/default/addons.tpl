<link rel="stylesheet" type="text/css" href="templates/orderforms/default/style.css" />

<table width="100%"><tr><td width="160" valign="top">

<div class="stepsboxactive">
<b class="stepsboxactivertop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<b>{$LANG.step} 1</b><br />{$LANG.orderchooseapackage}
<b class="stepsboxactiverbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>

<div class="stepsboxinactive">
<b class="stepsboxinactivertop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<b>{$LANG.step} 2</b><br />{$LANG.orderdomainoptions}
<b class="stepsboxinactiverbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>

<div class="stepsboxinactive">
<b class="stepsboxinactivertop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<b>{$LANG.step} 3</b><br />{$LANG.orderconfigure}
<b class="stepsboxinactiverbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>

<div class="stepsboxinactive">
<b class="stepsboxinactivertop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<b>{$LANG.step} 4</b><br />{$LANG.orderconfirmorder}
<b class="stepsboxinactiverbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>

<div class="stepsboxinactive">
<b class="stepsboxinactivertop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<b>{$LANG.step} 5</b><br />{$LANG.ordercheckout}
<b class="stepsboxinactiverbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>

</td><td valign="top">

<form method="post" action="{$smarty.server.PHP_SELF}">
<p>{$LANG.ordercategories}: <select name="gid" onchange="submit()">
{foreach key=num item=productgroup from=$productgroups}
<option value="{$productgroup.gid}">{$productgroup.name}</option>
{/foreach}
<option value="addons" selected="selected">{$LANG.cartproductaddons}</option>
{if $renewalsenabled}<option value="renewals">{$LANG.domainrenewals}</option>{/if}
{if $registerdomainenabled}<option value="domains">{$LANG.orderdomainregonly}</option>{/if}
</select></p>
</form>

{foreach from=$addons item=addon}
<div class="orderbox">
<b class="orderboxrtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<div class="orderboxpadding">
<form method="post" action="{$smarty.server.PHP_SELF}?a=add">
<input type="hidden" name="aid" value="{$addon.id}" />
<strong>{$addon.name}</strong><br />
{$addon.description}<br />
<div style="margin:5px;padding:2px;color:#cc0000;">
{if $addon.free}
{$LANG.orderfree}
{else}
{if $addon.setupfee}{$addon.setupfee} {$LANG.ordersetupfee}<br />{/if}
{$addon.recurringamount} {$addon.billingcycle}
{/if}
</div>
{$LANG.cartproductaddonschoosepackage}: <select name="productid">{foreach from=$addon.productids item=product}
<option value="{$product.id}">{$product.product}{if $product.domain} - {$product.domain}{/if}</option>
{/foreach}</select>
<br /><br />
<div align="center"><input type="submit" value="{$LANG.ordernowbutton}" class="buttongo" /></div>
</form>
</div>
<b class="orderboxrbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>
{/foreach}

{if $noaddons}
<div class="errorbox">{$LANG.cartproductaddonsnone}</div>
{/if}

</td></tr></table>