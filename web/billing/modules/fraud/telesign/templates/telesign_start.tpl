<!--  telesign_start  -->
<form method="post" action="{$formaction}?step=fraudcheck">
<center>{$telesign_mess}<br>
<input type="radio" name="ver_type" value="call" checked>{$LANG.telesignphonecall}
<input type="radio" name="ver_type" value="sms">{$LANG.telesignsms}<br><br>
<input type="submit" name="ver" value="{$LANG.ordercontinuebutton}"></center>
<input type="hidden" name="sub" value="1">
</form>