<h2>{$LANG.domaincontactinfo}</h2>
<p>{$LANG.domainname}: <strong>{$domain}</strong></p>
<form method="post" action="{$smarty.server.PHP_SELF}?action=domaincontacts">
  <input type="hidden" name="sub" value="save">
  <input type="hidden" name="domainid" value="{$domainid}">
  {foreach key=contactdetail item=values from=$contactdetails}
  <p><strong>{$contactdetail}</strong></p>
  <table width="100%" border="0" cellpadding="10" cellspacing="0">
    {foreach key=name item=value from=$values}
    <tr>
      <td width=120 align="right">{$name}</td>
      <td><input type="text" name="contactdetails[{$contactdetail}][{$name}]" value="{$value}" size="30"></td>
    </tr>
    {/foreach}
  </table>
  {/foreach}
  <p align="center">
    <input type="submit" value="{$LANG.clientareasavechanges}">
  </p>
</form>
<form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
  <input type="hidden" name="id" value="{$domainid}" />
  <p align="center">
    <input type="submit" value="{$LANG.clientareabacklink}" />
  </p>
</form><br />