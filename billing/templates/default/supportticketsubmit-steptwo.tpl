<script language="javascript">
{literal}
var currentcheckcontent,lastcheckcontent;
$(document).ready(function(){
    $("#addfileupload").click(function () {
        $("#fileuploads").append("<input type=\"file\" name=\"attachments[]\" size=\"75\"><br />");
        return false;
    });
});
{/literal}
{if $kbsuggestions}
{literal}
function getticketsuggestions() {
    currentcheckcontent = $("#message").val();
    if (currentcheckcontent!=lastcheckcontent && currentcheckcontent!="") {
        $.post("submitticket.php", { action: "getkbarticles", text: currentcheckcontent },
        function(data){
            if (data) {
                $("#searchresults").html(data);
                $("#searchresults").slideDown();
            }
        });
        lastcheckcontent = currentcheckcontent;
	}
    setTimeout('getticketsuggestions();', 3000);
}
getticketsuggestions();
{/literal}
{/if}
</script>

{if $errormessage}<div class="errorbox">{$errormessage|replace:'<li>':' &nbsp;#&nbsp; '} &nbsp;#&nbsp; </div><br />{/if}

<form name="submitticket" method="post" action="{$smarty.server.PHP_SELF}?step=3" enctype="multipart/form-data">

<input type="hidden" name="deptid" value="{$deptid}" />

<table cellspacing="1" cellpadding="0" class="frame"><tr><td>
<table width="100%" cellpadding="2">
<tr><td width="120" class="fieldarea">{$LANG.supportticketsclientname}</td><td>{if $loggedin}{$clientname}{else}<input type="text" name="name" size="30" value="{$name}" />{/if}</td></tr>
<tr><td class="fieldarea">{$LANG.supportticketsclientemail}</td><td>{if $loggedin}{$email}{else}<input type="text" name="email" size="50" value="{$email}" />{/if}</td></tr>
<tr><td class="fieldarea">{$LANG.supportticketsdepartment}</td><td>{$department}</td></tr>
<tr><td class="fieldarea">{$LANG.supportticketsticketsubject}</td><td><input type="text" name="subject" size="60" value="{$subject}" /></td></tr>
<tr><td class="fieldarea">{$LANG.supportticketsticketurgency}</td><td><select name="urgency">
<option value="High">{$LANG.supportticketsticketurgencyhigh}</option>
<option value="Medium" selected="selected">{$LANG.supportticketsticketurgencymedium}</option>
<option value="Low">{$LANG.supportticketsticketurgencylow}</option>
</select></td></tr>
{if $relatedservices}<tr><td class="fieldarea">{$LANG.relatedservice}</td><td><select name="relatedservice">
<option value="">{$LANG.none}</option>
{foreach from=$relatedservices item=relatedservice}
<option value="{$relatedservice.id}">{$relatedservice.name} ({$relatedservice.status})</option>
{/foreach}
</select></td></tr>{/if}
<tr><td colspan="2" class="fieldarea"><textarea name="message" id="message" rows="12" cols="60" style="width:100%">{$message}</textarea></td></tr>
{foreach key=num item=customfield from=$customfields}
<tr><td class="fieldarea">{$customfield.name}</td><td>{$customfield.input} {$customfield.description}</td></tr>
{/foreach}
<tr><td class="fieldarea">{$LANG.supportticketsticketattachments}:</td><td><input type="file" name="attachments[]" size="75" /> <a href="#" id="addfileupload"><img src="images/add.gif" align="absmiddle" border="0" /> {$LANG.addmore}</a><br />
<div id="fileuploads"></div>
({$LANG.supportticketsallowedextensions}: {$allowedfiletypes})</td></tr>
</table>
</td></tr></table>

<br />

<div id="searchresults" class="contentbox" style="display:none;"></div>

{if $capatacha}<p align="center">{$LANG.imagecheck}<br /><img src="includes/verifyimage.php" align="middle" alt="" /> <input type="text" name="code" size="10" maxlength="5" /></p>{/if}

<p align="center"><input type="submit" value="{$LANG.supportticketsticketsubmit}" class="buttongo" /></p>

</form>