<p>{$LANG.serverstatusheadingtext}</p>

<table class="clientareatable" align="center" cellspacing="1">
<tr class="clientareatableheading">
<td>{$LANG.servername}</td>
<td>HTTP</td>
<td>FTP</td>
<td>POP3</td>
<td>{$LANG.serverstatusphpinfo}</td>
<td>{$LANG.serverstatusserverload}</td>
<td>{$LANG.serverstatusuptime}</td>
</tr>
{foreach key=num item=server from=$servers}
<tr class="clientareatableactive">
<td>{$server.name}</td>
<td>{get_port_status num="$num" port="80"}</td>
<td>{get_port_status num="$num" port="21"}</td>
<td>{get_port_status num="$num" port="110"}</td>
<td><a href="{$server.phpinfourl}" target="_blank">{$LANG.serverstatusphpinfo}</a></td>
<td>{$server.serverload}</td>
<td>{$server.uptime}</td>
</tr>
{foreachelse}
<tr class="clientareatableactive">
<td colspan="7">{$LANG.serverstatusnoservers}</td>
</tr>
{/foreach}
</table>