<br />
<table width="90%" cellspacing="0" cellpadding="0" align="center">
  <tr>
{foreach from=$products item=product key=num}
    <td width="50%"><input type="radio" name="pid" value="{$product.pid}" id="pid{$product.pid}" onclick="loadproductconfig('{$product.pid}')"> <label for="pid{$product.pid}">{$product.name}</label></td>
    {if $num % 2}</tr><tr>{/if}
{/foreach}
  </tr>
</table>