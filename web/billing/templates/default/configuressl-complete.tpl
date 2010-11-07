{if $errormessage}

<div class="errorbox">{$errormessage|replace:'<li>':' &nbsp;#&nbsp; '} &nbsp;#&nbsp; </div>

{else}

<p><b>{$LANG.sslconfigcomplete}</b></p>

<p>{$LANG.sslconfigcompletedetails}</p>

<p align="center"><input type="button" value="{$LANG.ordercontinuebutton}" onclick="window.location='clientarea.php'" /></p>

{/if}