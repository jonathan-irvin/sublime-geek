<link rel="stylesheet" type="text/css" href="templates/orderforms/web20cart/style.css" />
<h2>{$LANG.cartproductconfig}</h2>
<p>{$LANG.cartproductdesc}</p>
{if $editconfig}
<form method="post" action="{$smarty.server.PHP_SELF}?a=confproduct&i={$i}">
<input type="hidden" name="configure" value="true">
{else}
<form method="post" action="{$smarty.server.PHP_SELF}?a=add&pid={$pid}">
  <input type="hidden" name="configure" value="true">
  {/if}
  
  {if $errormessage}
  <div class="errorbox">{$errormessage}</div>
  <br />
  {/if}
  
  {if $productinfo}
  <h3>{$LANG.orderproduct}</h3>
  <div class="cartbox"><strong>{$productinfo.groupname} - {$productinfo.name}</strong><br />
    {$productinfo.description}</div>
  <input type="hidden" name="previousbillingcycle" value="{$billingcycle}" />
  <h3>{$LANG.orderbillingcycle}</h3>
  <div class="cartbox">{if $pricing.type eq "free"}
    <input type="hidden" name="billingcycle" value="free" />
    {$LANG.orderfree}
    {elseif $pricing.type eq "onetime"}
    <input type="hidden" name="billingcycle" value="onetime" />
    {$pricing.onetime} {$LANG.orderpaymenttermonetime}
    {else}
<select name="billingcycle" onchange="submit()">
{if $pricing.monthly}<option value="monthly"{if $billingcycle eq "monthly"} selected="selected"{/if}>{$pricing.monthly}</option>{/if}
{if $pricing.quarterly}<option value="quarterly"{if $billingcycle eq "quarterly"} selected="selected"{/if}>{$pricing.quarterly}</option>{/if}
{if $pricing.semiannually}<option value="semiannually"{if $billingcycle eq "semiannually"} selected="selected"{/if}>{$pricing.semiannually}</option>{/if}
{if $pricing.annually}<option value="annually"{if $billingcycle eq "annually"} selected="selected"{/if}>{$pricing.annually}</option>{/if}
{if $pricing.biennially}<option value="biennially"{if $billingcycle eq "biennially"} selected="selected"{/if}>{$pricing.biennially}</option>{/if}
{if $pricing.triennially}<option value="triennially"{if $billingcycle eq "triennially"} selected="selected"{/if}>{$pricing.triennially}</option>{/if}
</select>
    {/if}</div>
  {/if}
  
  {if $productinfo.type eq "server"}
  <h3>{$LANG.cartconfigserver}</h3>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="frame">
    <tr>
      <td><table width="100%" border="0" cellpadding="10" cellspacing="0">
          <tr>
            <td width="150" class="fieldarea">{$LANG.serverhostname}:</td>
            <td><input type="text" name="hostname" size="15" value="{$server.hostname}" />
              eg. server1(.yourdomain.com)</td>
          </tr>
          <tr>
            <td width="150" class="fieldarea">{$LANG.serverns1prefix}:</td>
            <td><input type="text" name="ns1prefix" size="10" value="{$server.ns1prefix}" />
              eg. ns1(.yourdomain.com)</td>
          </tr>
          <tr>
            <td width="150" class="fieldarea">{$LANG.serverns2prefix}:</td>
            <td><input type="text" name="ns2prefix" size="10" value="{$server.ns2prefix}" />
              eg. ns2(.yourdomain.com)</td>
          </tr>
          <tr>
            <td width="150" class="fieldarea">{$LANG.serverrootpw}:</td>
            <td><input type="password" name="rootpw" size="20" value="{$server.rootpw}" /></td>
          </tr>
        </table></td>
    </tr>
  </table>
  {/if}
  
  {if $configurableoptions}
  <h3>{$LANG.orderconfigpackage}</h3>
  <p>{$LANG.cartconfigoptionsdesc}</p>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="frame">
    <tr>
      <td><table width="100%" border="0" cellpadding="10" cellspacing="0">
          {foreach key=num item=configoption from=$configurableoptions}
          <tr>
            <td width="150" class="fieldarea">{$configoption.optionname}:</td>
            <td> {if $configoption.optiontype eq 1}
<select name="configoption[{$configoption.id}]">
{foreach key=num2 item=options from=$configoption.options}
<option value="{$options.id}"{if $configoption.selectedvalue eq $options.id} selected="selected"{/if}>{$options.name}</option>
{/foreach}
</select>
              {elseif $configoption.optiontype eq 2}
              {foreach key=num2 item=options from=$configoption.options}
              <input type="radio" name="configoption[{$configoption.id}]" value="{$options.id}"{if $configoption.selectedvalue eq $options.id} checked="checked"{/if}>
              {$options.name}<br />
              {/foreach}
              {elseif $configoption.optiontype eq 3}
              <input type="checkbox" name="configoption[{$configoption.id}]" value="1"{if $configoption.selectedqty} checked{/if}>
              {$configoption.options.0.name}
              {elseif $configoption.optiontype eq 4}
              <input type="text" name="configoption[{$configoption.id}]" value="{$configoption.selectedqty}" size="5">
              x {$configoption.options.0.name}
              {/if} </td>
          </tr>
          {/foreach}
        </table></td>
    </tr>
  </table>
  {/if}
  
  {if $addons}
  <h3>{$LANG.cartaddons}</h3>
  <p>{$LANG.orderaddondescription}</p>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="frame">
    <tr>
      <td><table width="100%" border="0" cellpadding="10" cellspacing="0">
          {foreach key=num item=addon from=$addons}
          <tr>
            <td width="150" class="fieldarea">{$addon.checkbox}</td>
            <td><label for="a{$addon.id}"><strong>{$addon.name}</strong> - {$addon.description} ({$addon.pricing})</label></td>
          </tr>
          {/foreach}
        </table></td>
    </tr>
  </table>
  {/if}
  
  {if $customfields}
  <h3>{$LANG.orderadditionalrequiredinfo}</h3>
  <p>{$LANG.cartcustomfieldsdesc}</p>
  <div class="cartbox"> {foreach key=num item=customfield from=$customfields}
    {$customfield.name}: {$customfield.input} {$customfield.description}<br />
    {/foreach} </div>
  {/if}
  
  {if $domainoption}
  <h3>{$LANG.cartproductdomain}</h3>
  {if $domains}
  <input type="hidden" name="domainoption" value="{$domainoption}" />
  <p> {foreach key=num item=domain from=$domains}
    <input type="hidden" name="domains[]" value="{$domain.domain}" />
    <input type="hidden" name="domainsregperiod[{$domain.domain}]" value="{$domain.regperiod}" />
    {$LANG.orderdomain} {$num+1} - {$domain.domain}{if $domain.regperiod} ({$domain.regperiod} {$LANG.orderyears}){/if}<br />
    {/foreach} </p>
  {/if}
  
  {if $additionaldomainfields}
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="frame">
    <tr>
      <td><table width="100%" border="0" cellpadding="10" cellspacing="0">
          {foreach key=domainfieldname item=domainfield from=$additionaldomainfields}
          <tr>
            <td width="150" class="fieldarea">{$domainfieldname}</td>
            <td>{$domainfield}</td>
          </tr>
          {/foreach}
      </table></td>
    </tr>
  </table>
  {/if}
  
  {/if}
  <p align="center">{if $editconfig}
    <input type="submit" value="{$LANG.updatecart}" class="buttongo" />
    {else}
    <input type="submit" value="{$LANG.addtocart}" class="buttongo" />
    {/if}</p>
</form><br />
