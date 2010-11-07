{if !$status}

<p>{$LANG.sslinvalidlink}</p>

{else}

{if $errormessage}<div class="errorbox">{$errormessage|replace:'<li>':' &nbsp;#&nbsp; '} &nbsp;#&nbsp; </div><br />{/if}

<form name="submitticket" method="post" action="{$smarty.server.PHP_SELF}?cert={$cert}&step=2">

<p><b>{$LANG.sslcertinfo}</b></p>

<table cellspacing="1" cellpadding="0" class="frame"><tr><td>
<table width="100%" cellpadding="2">
<tr><td width="120" class="fieldarea">{$LANG.sslorderdate}</td><td>{$date}</td></tr>
<tr><td class="fieldarea">{$LANG.sslcerttype}</td><td>{$certtype}</td></tr>
<tr><td class="fieldarea">{$LANG.sslstatus}</td><td>{$status}</td></tr>
{foreach from=$displaydata key=displaydataname item=displaydatavalue}
<tr><td class="fieldarea">{$displaydataname}</td><td>{$displaydatavalue}</td></tr>
{/foreach}
</table>
</td></tr></table>

{if $status eq "Incomplete"}

<p><b>{$LANG.sslserverinfo}</b></p>

<p>{$LANG.sslserverinfodetails}</p>

<table cellspacing="1" cellpadding="0" class="frame"><tr><td>
<table width="100%" cellpadding="2">
<tr><td width="120" class="fieldarea">{$LANG.sslservertype}</td><td><select name="servertype"><option value="" selected>Please choose one...</option>{foreach from=$webservertypes key=webservertypeid item=webservertype}<option value="{$webservertypeid}"{if $servertype eq $webservertypeid} selected{/if}>{$webservertype}</option>{/foreach}</select></td></tr>
<tr><td class="fieldarea">{$LANG.sslcsr}</td><td><textarea name="csr" rows="7" cols="100">{$csr}</textarea></td></tr>
</table>
</td></tr></table>

<p><b>{$LANG.ssladmininfo}</b></p>

<p>{$LANG.ssladmininfodetails}</p>

<table cellspacing="1" cellpadding="0" class="frame"><tr><td>
<table width="100%" cellpadding="2">
<tr><td width="120" class="fieldarea">{$LANG.clientareafirstname}</td><td><input type="text" name="firstname" size="30" value="{$firstname}" /></td></tr>
<tr><td class="fieldarea">{$LANG.clientarealastname}</td><td><input type="text" name="lastname" size="30" value="{$lastname}" /></td></tr>
<tr><td class="fieldarea">{$LANG.organizationname}</td><td><input type="text" name="organisationname" size="30" value="{$organisationname}" /></td></tr>
<tr><td class="fieldarea">{$LANG.jobtitle}</td><td><input type="text" name="jobtitle" size="30" value="{$jobtitle}" /> (Required if Organization Name is set)</td></tr>
<tr><td class="fieldarea">{$LANG.clientareaemail}</td><td><input type="text" name="email" size="30" value="{$email}" /></td></tr>
<tr><td class="fieldarea">{$LANG.clientareaaddress1}</td><td><input type="text" name="address1" size="30" value="{$address1}" /></td></tr>
<tr><td class="fieldarea">{$LANG.clientareaaddress2}</td><td><input type="text" name="address2" size="30" value="{$address2}" /></td></tr>
<tr><td class="fieldarea">{$LANG.clientareacity}</td><td><input type="text" name="city" size="30" value="{$city}" /></td></tr>
<tr><td class="fieldarea">{$LANG.clientareastate}</td><td><input type="text" name="state" size="30" value="{$state}" /></td></tr>
<tr><td class="fieldarea">{$LANG.clientareapostcode}</td><td><input type="text" name="postcode" value="{$postcode}" size="30" /></td></tr>
<tr><td class="fieldarea">{$LANG.clientareacountry}</td><td>{$countriesdropdown}</td></tr>
<tr><td class="fieldarea">{$LANG.clientareaphonenumber}</td><td><input type="text" name="phonenumber" size="30" value="{$phonenumber}" /></td></tr>
</table>
</td></tr></table>

<p align="center"><input type="submit" value="{$LANG.ordercontinuebutton}" class="buttongo" /></p>

</form>

{else}

<p align="center"><input type="button" value="{$LANG.invoicesbacktoclientarea}" onclick="window.location='clientarea.php'" class="button" /></p>

{/if}{/if}