<link rel="stylesheet" type="text/css" href="templates/orderforms/web20cart/style.css" />
<h2>{$LANG.cartdomainsconfig}</h2>
<p>{$LANG.cartdomainsconfigdesc}</p>
{if $errormessage}
<div class="errorbox">{$errormessage}</div>
<br />
{/if}
<form method="post" action="{$smarty.server.PHP_SELF}?a=confdomains">
  <input type="hidden" name="update" value="true" />
  {foreach key=num item=domain from=$domains}
  <h3>{$domain.domain} - {$domain.regperiod} {$LANG.orderyears} {if $domain.hosting}<span class="textgreen">[{$LANG.cartdomainshashosting}]</span>{else}<a href="cart.php" class="textred">[{$LANG.cartdomainsnohosting}]</a><br />
    {/if}</h3>
  {if $domain.configtoshow}
  <div class="cartbox"> {if $domain.eppenabled}{$LANG.domaineppcode}
    <p><input type="text" name="epp[{$num}]" size="20" value="{$domain.eppvalue}" />
    {$LANG.domaineppcodedesc}</p>
    {/if}
    {if $domain.dnsmanagement}
    <p><input type="checkbox" name="dnsmanagement[{$num}]"{if $domain.dnsmanagementselected} checked{/if} />
    {$LANG.domaindnsmanagement} ({$domain.dnsmanagementprice})</p>
    {/if}
    {if $domain.emailforwarding}
    <p><input type="checkbox" name="emailforwarding[{$num}]"{if $domain.emailforwardingselected} checked{/if} />
    {$LANG.domainemailforwarding} ({$domain.emailforwardingprice})</p>
    {/if}
    {if $domain.idprotection}
    <p><input type="checkbox" name="idprotection[{$num}]"{if $domain.idprotectionselected} checked{/if} />
    {$LANG.domainidprotection} ({$domain.idprotectionprice})</p>
    {/if}
    {foreach key=domainfieldname item=domainfield from=$domain.fields}
    <p>{$domainfieldname}: {$domainfield}</p>
    {/foreach} </div>
  <br />
  {/if}
  {/foreach}
  
  {if $atleastonenohosting}
  <h3>{$LANG.domainnameservers}</h3>
  <p>{$LANG.cartnameserversdesc}</p>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="frame">
    <tr>
      <td><table width="100%" border="0" cellpadding="10" cellspacing="0">
          <tr>
            <td width="150" class="fieldarea">{$LANG.domainnameserver1}:</td>
            <td><input type="text" name="domainns1" size="40" value="{$domainns1}" /></td>
          </tr>
          <tr>
            <td width="150" class="fieldarea">{$LANG.domainnameserver2}:</td>
            <td><input type="text" name="domainns2" size="40" value="{$domainns2}" /></td>
          </tr>
          <tr>
            <td width="150" class="fieldarea">{$LANG.domainnameserver3}:</td>
            <td><input type="text" name="domainns3" size="40" value="{$domainns3}" /></td>
          </tr>
          <tr>
            <td width="150" class="fieldarea">{$LANG.domainnameserver4}:</td>
            <td><input type="text" name="domainns4" size="40" value="{$domainns4}" /></td>
          </tr>
        </table></td>
    </tr>
  </table>
  {/if}
  <p align="center">
    <input type="submit" value="{$LANG.updatecart}" class="buttongo" />
  </p>
</form><br />