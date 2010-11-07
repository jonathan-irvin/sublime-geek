{if $errormessage}
<div class="errorbox">{$errormessage}</div>
{else}
<p><strong>{$LANG.sslconfigcomplete}</strong></p>
<p>{$LANG.sslconfigcompletedetails}</p>
<p align="center">
  <input type="button" value="{$LANG.ordercontinuebutton}" onclick="window.location='clientarea.php'" />
</p>
{/if}