<link rel="stylesheet" type="text/css" href="templates/orderforms/cart/style.css" />

<p align="center" class="cartheading">{$LANG.orderconfirmation}</p>

<p>{$LANG.orderreceived}</p>

<div class="cartbox">
<p align="center"><strong>{$LANG.ordernumberis} {$ordernumber}</strong></p>
</div>

<p>{$LANG.orderfinalinstructions}</p>

{if $invoiceid && !$ispaid}
<div class="errorbox">{$LANG.ordercompletebutnotpaid}</div>
<p align="center"><a href="viewinvoice.php?id={$invoiceid}" target="_blank">{$LANG.invoicenumber}{$invoiceid}</a></p>
{/if}

{if $ispaid}
<!-- Enter any HTML code which needs to be displayed once a user has completed the checkout of their order here - for example conversion tracking and affiliate tracking scripts -->
{/if}

<p align="center"><a href="clientarea.php">{$LANG.ordergotoclientarea}</a></p>
