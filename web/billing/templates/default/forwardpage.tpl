<br /><br />
<p align="center">{$message}</p>
<p align="center"><img src="images/loading.gif" alt="Loading" border="0" /></p>
<p align="center">{$code}</p>
<form method="post" action="{if $invoiceid}viewinvoice.php?id={$invoiceid}{else}clientarea.php{/if}"></form>
<br /><br /><br />
{literal}
<script language="javascript">
setTimeout ( "autoForward()" , 5000 );
function autoForward() {
	document.forms[0].submit()
}
</script>
{/literal}