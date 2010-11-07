<p>{$LANG.serverstatusheadingtext}</p>
<table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" class="data">
  <tr>
    <th>{$LANG.servername}</th>
    <th>HTTP</th>
    <th>FTP</th>
    <th>POP3</th>
    <th>{$LANG.serverstatusphpinfo}</th>
    <th>{$LANG.serverstatusserverload}</th>
    <th>{$LANG.serverstatusuptime}</th>
  </tr>
  {foreach key=num item=server from=$servers}
  <tr>
    <td>{$server.name}</td>
    <td>{get_port_status num="$num" port="80"}</td>
    <td>{get_port_status num="$num" port="21"}</td>
    <td>{get_port_status num="$num" port="110"}</td>
    <td><a href="{$server.phpinfourl}" target="_blank">{$LANG.serverstatusphpinfo}</a></td>
    <td>{$server.serverload}</td>
    <td>{$server.uptime}</td>
  </tr>
  {foreachelse}
  <tr>
    <td colspan="7">{$LANG.serverstatusnoservers}</td>
  </tr>
  {/foreach}
</table><br />