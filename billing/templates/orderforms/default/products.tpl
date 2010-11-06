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

<table width="100%" cellspacing="0" cellpadding="0"><tr><td>

<form method="get" action="{$smarty.server.PHP_SELF}">
<p>{$LANG.ordercategories}: <select name="gid" onchange="submit()">
{foreach key=num item=productgroup from=$productgroups}
<option value="{$productgroup.gid}"{if $gid eq $productgroup.gid} selected="selected"{/if}>{$productgroup.name}</option>
{/foreach}
{if $loggedin}
<option value="addons">{$LANG.cartproductaddons}</option>
{if $renewalsenabled}<option value="renewals">{$LANG.domainrenewals}</option>{/if}
{/if}
{if $registerdomainenabled}<option value="domains">{$LANG.orderdomainregonly}</option>{/if}
</select></p>
</form>

</td><td>

{if !$loggedin && $currencies}
<form method="post" action="cart.php?gid={$smarty.get.gid}">
<p align="right">{$LANG.choosecurrency}: <select name="currency" onchange="submit()">{foreach from=$currencies item=curr}
<option value="{$curr.id}"{if $curr.id eq $currency.id} selected{/if}>{$curr.code}</option>
{/foreach}</select> <input type="submit" value="{$LANG.go}" /></p>
</form>
{/if}

</td></tr></table>

<br />

{foreach key=num item=product from=$products}
<div class="orderbox">
<b class="orderboxrtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<div class="orderboxpadding">
<form method="post" action="{$smarty.server.PHP_SELF}?a=add&pid={$product.pid}">
<table width="100%"><tr><td width="75%">
<strong>{$product.name}</strong> {if $product.qty!=""}<em>({$product.qty} {$LANG.orderavailable})</em>{/if} - {$product.description}<br /><br />
{if $product.freedomain}<em>{$LANG.orderfreedomainregistration} {$LANG.orderfreedomaindescription}</em><br />{/if}
{if $product.paytype eq "free"}
{$LANG.orderfree}<br />
<input type="hidden" name="billingcycle" value="free" />
{elseif $product.paytype eq "onetime"}
{$product.pricing.onetime} {$LANG.orderpaymenttermonetime}<br />
<input type="hidden" name="billingcycle" value="onetime" />
{elseif $product.paytype eq "recurring"}
<select name="billingcycle">
{if $product.pricing.monthly}<option value="monthly">{$product.pricing.monthly}</option>{/if}
{if $product.pricing.quarterly}<option value="quarterly">{$product.pricing.quarterly}</option>{/if}
{if $product.pricing.semiannually}<option value="semiannually">{$product.pricing.semiannually}</option>{/if}
{if $product.pricing.annually}<option value="annually">{$product.pricing.annually}</option>{/if}
{if $product.pricing.biennially}<option value="biennially">{$product.pricing.biennially}</option>{/if}
{if $product.pricing.triennially}<option value="triennially">{$product.pricing.triennially}</option>{/if}
</select>
{/if}
</td><td width="25%" align="center">
<input type="submit" value="{$LANG.ordernowbutton}"{if $product.qty eq "0"} disabled{/if} class="buttongo" />
</td></tr></table>
</form>
</div>
<b class="orderboxrbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>

{/foreach}

</td></tr></table>

<p><img align="left" src="images/padlock.gif" border="0" alt="Secure Transaction" style="padding-right: 10px;" /> {$LANG.ordersecure} (<strong>{$ipaddress}</strong>) {$LANG.ordersecure2}</p>