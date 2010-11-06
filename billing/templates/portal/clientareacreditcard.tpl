<div class="contentbox"><a href="{$smarty.server.PHP_SELF}?action=details">{$LANG.clientareanavdetails}</a> | <a href="{$smarty.server.PHP_SELF}?action=contacts">{$LANG.clientareanavcontacts}</a> | <a href="{$smarty.server.PHP_SELF}?action=addcontact">{$LANG.clientareanavaddcontact}</a> | <strong>{$LANG.clientareanavchangecc}</strong> | <a href="{$smarty.server.PHP_SELF}?action=changepw">{$LANG.clientareanavchangepw}</a> | <a href="{$smarty.server.PHP_SELF}?action=changesq">{$LANG.clientareanavsecurityquestions}</a></div>

<h2>{$LANG.clientareanavchangecc}</h2>

{if $remoteupdatecode}

  <div align="center">
    {$remoteupdatecode}
  </div>

{else}

{if $successful}<div class="successbox">{$LANG.changessavedsuccessfully}</div><br />{/if}
{if $errormessage}<div class="errorbox">{$errormessage|replace:'<li>':' &nbsp;#&nbsp; '} &nbsp;#&nbsp; </div><br />{/if}

<form method="post" action="{$smarty.server.PHP_SELF}?action=creditcard">
<input type="hidden" name="submit" value="true" />

  <table width="100%" cellspacing="0" cellpadding="0" class="frame">
    <tr>
      <td><table width="100%" border="0" cellpadding="10" cellspacing="0">
          <tr><td width="150" class="fieldarea">{$LANG.creditcardcardtype}</td><td>{$cardtype}</td></tr>
          <tr><td class="fieldarea">{$LANG.creditcardcardnumber}</td><td>{$cardnum}{if $allowcustomerdelete && $cardtype} &nbsp;&nbsp;&nbsp; <input type="button" value="{$LANG.creditcarddelete}" class="button" onclick="window.location='clientarea.php?action=creditcard&delete=true'" />{/if}</td></tr>
          <tr><td class="fieldarea">{$LANG.creditcardcardexpires}</td><td>{$cardexp}</td></tr>
          {if $cardissuenum}<tr><td class="fieldarea">{$LANG.creditcardcardissuenum}</td><td>{$cardissuenum}</td></tr>{/if}
          {if $cardstart}<tr><td class="fieldarea">{$LANG.creditcardcardstart}</td><td>{$cardstart}</td></tr>{/if}
      </table></td>
    </tr>
  </table>

<h2>{$LANG.creditcardenternewcard}</h2>

<table width="100%" cellspacing="0" cellpadding="0" class="frame">
    <tr>
      <td><table width="100%" border="0" cellpadding="10" cellspacing="0">
          <tr><td width="150" class="fieldarea">{$LANG.creditcardcardtype}</td><td><select name="cctype">
{foreach key=num item=cardtype from=$acceptedcctypes}
<option>{$cardtype}</option>
{/foreach}
</select></td></tr>
          <tr><td class="fieldarea">{$LANG.creditcardcardnumber}</td><td><input type="text" name="ccnumber" size="25" /></td></tr>
          <tr><td class="fieldarea">{$LANG.creditcardcardexpires}</td><td><input type="text" name="ccexpirymonth" size="2" maxlength="2" />/<input type="text" name="ccexpiryyear" size="2" maxlength="2" /> (MM/YY)</td></tr>
          {if $showccissuestart}<tr><td class="fieldarea">{$LANG.creditcardcardissuenum}</td><td><input type="text" name="ccissuenum" value="{$ccissuenum}" size="5" maxlength="3" /></td></tr>
          <tr><td class="fieldarea">{$LANG.creditcardcardstart}</td><td><input type="text" name="ccstartmonth" size="2" maxlength="2" value="{$ccstartmonth}" />/<input type="text" name="ccstartyear" size="2" maxlength="2" value="{$ccstartyear}" /> (MM/YY)</td></tr>{/if}
      </table></td>
    </tr>
  </table>

<p align="center"><input type="submit" value="{$LANG.clientareasavechanges}" class="button" /> <input type="reset" value="{$LANG.clientareacancel}" class="button" /></p>

</form>

{/if}