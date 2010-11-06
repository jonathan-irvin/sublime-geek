<link rel="stylesheet" type="text/css" href="templates/orderforms/default/style.css" />

<table width="100%"><tr><td width="160" valign="top">

<div class="stepsboxinactive">
<b class="stepsboxinactivertop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<b>{$LANG.step} 1</b><br />{$LANG.orderchooseapackage}
<b class="stepsboxinactiverbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>

<div class="stepsboxactive">
<b class="stepsboxactivertop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<b>{$LANG.step} 2</b><br />{$LANG.orderdomainoptions}
<b class="stepsboxactiverbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
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
{if $loggedin}
<option value="addons">{$LANG.cartproductaddons}</option>
<option value="renewals" selected="selected">{$LANG.domainrenewals}</option>
{/if}
{if $registerdomainenabled}<option value="domains">{$LANG.orderdomainregonly}</option>{/if}
</select></p>
</form>

<p>{$LANG.domainrenewdesc}</p>

<form method="post" action="cart.php?a=add&renewals=true">

<table align="center" cellspacing="1" class="clientareatable">
<tr class="clientareatableheading"><td width="20"></td><td>{$LANG.orderdomain}</td><td>{$LANG.domainstatus}</td><td>{$LANG.domaindaysuntilexpiry}</td><td></td></tr>
{foreach from=$renewals item=renewal}
<tr><td>{if !$renewal.pastgraceperiod}<input type="checkbox" name="renewalids[]" value="{$renewal.id}" />{/if}</td><td>{$renewal.domain}</td><td>{$renewal.status}</td><td>
      {if $renewal.daysuntilexpiry > 30}
        <span class="textgreen">{$renewal.daysuntilexpiry} {$LANG.domainrenewalsdays}</span>
      {elseif $renewal.daysuntilexpiry > 0}
        <span class="textred">{$renewal.daysuntilexpiry} {$LANG.domainrenewalsdays}</span>
      {else}
        <span class="textblack">{$renewal.daysuntilexpiry*-1} {$LANG.domainrenewalsdaysago}</span>
      {/if}
      {if $renewal.ingraceperiod}
        <br />
        <span class="textred">{$LANG.domainrenewalsingraceperiod}<span>
      {/if}
</td><td>
      {if $renewal.pastgraceperiod}
        <span class="textred">{$LANG.domainrenewalspastgraceperiod}<span>
      {else}
        <select name="renewalperiod[{$renewal.id}]">
        {foreach from=$renewal.renewaloptions item=renewaloption}
          <option value="{$renewaloption.period}">{$renewaloption.period} {$LANG.orderyears} @ {$renewaloption.price}</option>
        {/foreach}
        </select>
      {/if}
</td></tr>
{foreachelse}
<tr><td colspan="5">{$LANG.domainrenewalsnoneavailable}</td></tr>
{/foreach}
</table>

<p align="center"><input type="submit" value="{$LANG.ordernowbutton}" class="buttongo" /></p>

</form>

</td></tr></table>