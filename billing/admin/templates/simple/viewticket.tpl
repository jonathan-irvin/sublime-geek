<script type="text/javascript" src="../includes/jscript/jquerylq.js"></script>

<script language="javascript">
var ticketid = '{$ticketid}';
var pagefilename = '{$smarty.server.PHP_SELF}';
var ticketcontent = "";
{literal}
function doDeleteReply(id) {
    if (confirm("Are you sure you want to delete this support ticket reply?")) {
        window.location=pagefilename+'?action=viewticket&id='+ticketid+'&sub=del&idsd='+id;
    }
}
function doDeleteTicket() {
    if (confirm("Are you sure you want to delete this support ticket and all replies?")) {
        window.location=pagefilename+'?sub=deleteticket&id='+ticketid;
    }
}
function doDeleteNote(id) {
    if (confirm("Are you sure you want to delete this support ticket note?")) {
        window.location=pagefilename+'?action=viewticket&id='+ticketid+'&sub=delnote&idsd='+id;
    }
}
function quoteTicket(id,ids) {
    $(".tab").removeClass("tabselected");
    $("#tab0").addClass("tabselected");
    $(".tabbox").hide();
    $("#tab0box").show();
    $.post("supporttickets.php", { action: "getquotedtext", id: id, ids: ids },
    function(data){
        $("#replymessage").val(data+"\n\n"+$("#replymessage").val());
    });
    return false;
}

$(document).ready(function(){

$(".tabbox").css("display","none");
$(".tab").click(function(){
    var elid = $(this).attr("id");
    $(".tab").removeClass("tabselected");
    $("#"+elid).addClass("tabselected");
    $(".tabbox").slideUp();
    $("#"+elid+"box").slideDown();
    $("#tab").val(elid.substr(3));
});
$("#tab0").addClass("tabselected");
$("#tab0box").css("display","");
$(".editbutton").click(function () {
    var butid = $(this).attr("id");
    ticketcontent = $("#"+butid+"_box").html();
    var browsername = navigator.appName;
    if (browsername == "Microsoft Internet Explorer") {
        var ticketcontentpassback = ticketcontent.replace(/<br>/gi, '\n');
    } else {
        var ticketcontentpassback = ticketcontent.replace(/<br>/gi, '');
    }
    $("#"+butid+"_box").html("<textarea rows=\"10\" style=\"width:99%\" id=\""+butid+"_box_text\">"+ticketcontentpassback+"</textarea>");
    $(".editticketbuttons"+butid).toggle();
});
$(".savebutton").click(function () {
    var butid = $(this).attr("id");
    var newticketcontent = $("#"+butid+"_box_text").val();
    var ticketcontentpassback = newticketcontent.replace(/\n/gi, '<br>');
    $("#"+butid+"_box").html(ticketcontentpassback);
    $.post("supporttickets.php", { action: "updatereply", text: newticketcontent, id: butid });
    $(".editticketbuttons"+butid).toggle();
});
$(".cancelbutton").click(function () {
    var butid = $(this).attr("id");
    $("#"+butid+"_box").html(ticketcontent);
    $(".editticketbuttons"+butid).toggle();
});
$("#replymessage").focus(function () {
	$.post("supporttickets.php", { action: "makingreply", id: ticketid },
	function(data){
        $("#replyingadmin").html(data);
    });
    return false;
});
$("#replyfrm").submit(function () {
	var status = $("#ticketstatus").val();
	var response = $.ajax({
		type: "POST",
		url: "supporttickets.php?action=checkstatus",
		data: "id="+ticketid+"&ticketstatus="+status,
		async: false
	}).responseText;
	if (response == "true") {
    	return true;
	} else {
		if (confirm("The status of this ticket has changed since you started replying which could indicate another staff member has already replied.\n\nAre you sure you still want to submit this reply?")) {
	        return true;
	    }
	    return false;
	}
});
$(window).unload( function () {
    $.post("supporttickets.php", { action: "endreply", id: ticketid });
});
$("#insertpredef").click(function () {
    $("#prerepliescontainer").slideToggle();
    return false;
});
$(".loadpredefinedreplycat").livequery("click", function(event) {
    var catid = $(this).attr("id");
    $.post("supporttickets.php", { action: "loadpredefinedreplies", cat: catid },
    function(data){
        $("#prerepliescontent").html(data);
    });
    return false;
});
$(".selectpredefinedreply").livequery("click", function(event) {
    var artid = $(this).attr("id");
    $.post("supporttickets.php", { action: "getpredefinedreply", id: artid },
    function(data){
        $('#replymessage').addToReply(data);
    });
    $("#prerepliescontainer").slideToggle();
    return false;
});
$("#addfileupload").click(function () {
    $("#fileuploads").append("<input type=\"file\" name=\"attachments[]\" size=\"85\"><br />");
    return false;
});
$("#ticketstatus").change(function () {
    $.post("supporttickets.php", { action: "changestatus", id: ticketid, status: this.options[this.selectedIndex].text });
});

});
{/literal}
</script>

{$infobox}

<div id="replyingadmin">
{if $replyingadmin}<div class="errorbox">{$replyingadmin.name} viewed this ticket and started making a reply @ {$replyingadmin.time}</div><br />{/if}
</div>

<h2 style="margin:0;">#{$tid} - {$subject} <select name="ticketstatus" id="ticketstatus" style="font-size:18px;">
{foreach from=$statuses item=statusitem}
<option{if $statusitem.title eq $status} selected{/if} style="color:{$statusitem.color}">{$statusitem.title}</option>
{/foreach}
</select></h2>

<p>Client: {if $userid}<a href="clientssummary.php?userid={$userid}"{if $clientgroupcolour} style="background-color:{$clientgroupcolour}"{/if} target="_blank">{$clientname}</a>{else}Not a Registered Client{/if} | Last Reply: {$lastreply}</p>

<div id="tabs">
    <ul>
        <li id="tab0" class="tab"><a href="javascript:;">Reply</a></li>
        <li id="tab1" class="tab"><a href="javascript:;">Notes{if $numnotes} ({$numnotes}){/if}</a></li>
        <li id="tab2" class="tab"><a href="javascript:;">Custom Fields</a></li>
        <li id="tab3" class="tab"><a href="javascript:;">Options</a></li>
        <li id="tab4" class="tab"><a href="javascript:;">Log</a></li>
    </ul>
</div>

<div id="tab0box" class="tabbox">
    <div id="tab_content">

<form method="post" action="{$smarty.server.PHP_SELF}?action=viewticket&id={$ticketid}" enctype="multipart/form-data" name="replyfrm" id="replyfrm">

<textarea name="message" id="replymessage" rows="14" style="width:100%">{$predefinedmessage}


{$signature}</textarea>

<br>

<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
<tr><td width="15%" class="fieldlabel">Post Reply</td><td class="fieldarea"><select name="postaction">
<option value="return">Set to Answered & Return to Ticket List
<option value="answered">Set to Answered & Remain in Ticket View
{foreach from=$statuses item=statusitem}
{if $statusitem.id > 4}<option value="setstatus{$statusitem.id}">Set to {$statusitem.title} & Remain in Ticket View</option>{/if}
{/foreach}
<option value="close">Close & Return to Ticket List
<option value="note">Add as a Private Ticket Note
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#" onClick="window.open('supportticketskbarticle.php','kbartwnd','width=500,height=400,scrollbars=yes');return false">Insert KB Article Link</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#" id="insertpredef">Insert Predefined Ticket Reply</a>
</td></tr>
<tr><td class="fieldlabel">Attachments</td><td class="fieldarea"><input type="file" name="attachments[]" size="85"> <a href="#" id="addfileupload"><img src="images/icons/add.png" align="absmiddle" border="0" /> Add More</a><br /><div id="fileuploads"></div></td></tr>
{if $userid}<tr><td class="fieldlabel">Add Billing Entry</td><td class="fieldarea"><input type="text" name="billingdescription" size="60" value="To invoice, enter a description" onfocus="if(this.value=='To invoice, enter a description')this.value=''" /> @ <input type="text" name="billingamount" size="10" value="Amount" /> <select name="billingaction">
<option value="3" /> Invoice Immediately</option>
<option value="0" /> Don't Invoice for Now</option>
<option value="1" /> Invoice on Next Cron Run</option>
<option value="2" /> Add to User's Next Invoice</option>
</select></td></tr>{/if}
</table>

<div id="prerepliescontainer" style="display:none;">
    <img src="images/spacer.gif" height="8" width="1" />
    <br />
    <div id="prerepliescontent" style="border:1px solid #DFDCCE;background-color:#F7F7F2;padding:5px;text-align:left;">
        {$predefinedreplies}
    </div>
</div>

<br />

<div align="center"><input type="submit" value="Add Response" name="postreply" class="button" /></div>

</form>

    </div>
</div>
<div id="tab1box" class="tabbox">
    <div id="tab_content">

{if !$numnotes}
<div align="center">No Notes Found for this Ticket</div>
{else}
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#cccccc">
{foreach from=$notes item=note}
<tr><td rowspan="2" bgcolor="#F8F8F8" width="120" valign="top" align="left">{$note.admin}<br><a href="#" onClick="doDeleteNote('{$note.id}');return false"><img src="images/delete.gif" alt="Delete Ticket Note" border="0" align="absmiddle"></a></td><td bgcolor="#F8F8F" align="left">{$note.date}</td></tr><tr><td bgcolor="#F8F8F8" align="left">{$note.message}</td></tr>
{/foreach}
</table>
{/if}

    </div>
</div>
<div id="tab2box" class="tabbox">
    <div id="tab_content">

<form method="post" action="{$smarty.server.PHP_SELF}?action=viewticket&id={$ticketid}&sub=savecustomfields">

{if !$numcustomfields}
<div align="center">No Custom Fields Setup for this Department</div>
{else}
<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
{foreach from=$customfields item=customfield}
<tr><td width="25%" class="fieldlabel">{$customfield.name}</td><td class="fieldarea">{$customfield.input}</td></tr>
{/foreach}
</table>
<img src="images/spacer.gif" height="10" width="1" /><br />
<div align="center"><input type="submit" value="Save Changes" class="button"></div>
</form>
{/if}

    </div>
</div>
<div id="tab3box" class="tabbox">
    <div id="tab_content">

<form method="post" action="{$smarty.server.PHP_SELF}?action=viewticket&id={$ticketid}">

<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
<tr><td width="15%" class="fieldlabel">Department</td><td class="fieldarea"><select name="deptid">
{foreach from=$departments item=department}
<option value="{$department.id}"{if $department.id eq $deptid} selected{/if}>{$department.name}</option>
{/foreach}
</select></td><td width="15%" class="fieldlabel">Client ID</td><td class="fieldarea"><input type="text" name="userid" size="10" value="{$userid}" /></td></tr>
<tr><td class="fieldlabel">Subject</td><td class="fieldarea"><input type="text" name="subject" value="{$subject}" style="width:80%"></td><td class="fieldlabel">Flag</td><td class="fieldarea"><select name="flagto">
<option value="0">None</option>
{foreach from=$staff item=staffmember}
<option value="{$staffmember.id}"{if $staffmember.id eq $flag} selected{/if}>{$staffmember.name}</option>
{/foreach}
</select></td></tr>
<tr><td class="fieldlabel">Status</td><td class="fieldarea"><select name="status">
{foreach from=$statuses item=statusitem}
<option{if $statusitem.title eq $status} selected{/if} style="color:{$statusitem.color}">{$statusitem.title}</option>
{/foreach}
</select></td><td class="fieldlabel">Priority</td><td class="fieldarea"><select name="priority">
<option{if $priority eq "High"} selected{/if}>High</option>
<option{if $priority eq "Medium"} selected{/if}>Medium</option>
<option{if $priority eq "Low"} selected{/if}>Low</option>
</select></td></tr>
<tr><td class="fieldlabel">CC Recipients</td><td class="fieldarea"><input type="text" name="cc" value="{$cc}" size="40"> (Comma separated)</td><td class="fieldlabel">Merge Ticket</td><td class="fieldarea"><input type="text" name="mergetid" size="10"> (# to combine)</td></tr>
</table>

<img src="images/spacer.gif" height="10" width="1"><br>
<div align="center"><input type="submit" value="Save Changes" class="button"></div>
</form>

    </div>
</div>
<div id="tab4box" class="tabbox">
    <div id="tab_content">

<table cellspacing=1 bgcolor=#cccccc width=100%>
<tr style="background-color:#f2f2f2;font-weight:bold;text-align:center;"><td>Date</td><td>Action</td></tr>
{foreach from=$ticketlog item=log}
<tr bgcolor="#ffffff"><td align=center width=160>{$log.date}</td><td>{$log.action}</td></tr>
{/foreach}
</table>

    </div>
</div>

<br />

{if $relatedproduct}
<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
<tr><td class="fieldlabel" width="15%">Product/Service</td><td class="fieldarea"><a href="clientshosting.php?userid={$userid}&hostingid={$relatedproduct.id}" target="_blank">{$relatedproduct.name}</a></td><td class="fieldlabel" width="15%">Reg Date</td><td class="fieldarea">{$relatedproduct.regdate}</td></tr>
<tr><td class="fieldlabel">Domain</td><td class="fieldarea"><a href="http://{$relatedproduct.domain}" target="_blank">{$relatedproduct.domain}</a></td><td class="fieldlabel" width="15%">Next Due Date</td><td class="fieldarea">{$relatedproduct.nextduedate}</td></tr>
<tr><td class="fieldlabel">User/Pass</td><td class="fieldarea">{if $relatedproduct.username} {$relatedproduct.username} / {$relatedproduct.password} {$relatedproduct.loginlink}{/if}</td><td class="fieldlabel">Status</td><td class="fieldarea">{$relatedproduct.status}</td></tr>
</table>
{/if}

{if $relateddomain}
<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
<tr><td class="fieldlabel" width="15%">Domain</td><td class="fieldarea">{$relateddomain.domain}</td><td class="fieldlabel" width="15%">Next Due Date</td><td class="fieldarea">{$relateddomain.nextduedate}</td></tr>
<tr><td class="fieldlabel">Registrar</td><td class="fieldarea">{$relateddomain.registrar}</td><td class="fieldlabel">Registration Period</td><td class="fieldarea">{$relateddomain.regperiod} Year(s)</td></tr>
<tr><td class="fieldlabel">Order Type</td><td class="fieldarea">{$relateddomain.ordertype}</td><td class="fieldlabel">Status</td><td class="fieldarea">{$relateddomain.status}</td></tr>
</table>
{/if}

{if $relatedservices && !$relatedproduct && !$relateddomain}
<div class="tablebg">
<table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
<tr><th>Product/Service</th><th>Amount</th><th>Billing Cycle</th><th>Signup Date</th><th>Next Due Date</th><th>Status</th></tr>
{foreach from=$relatedservices item=relatedservice}
<tr><td>{$relatedservice.name}</td><td>{$relatedservice.amount}</td><td>{$relatedservice.billingcycle}</td><td>{$relatedservice.regdate}</td><td>{$relatedservice.nextduedate}</td><td>{$relatedservice.status}</td></tr>
{/foreach}
</table>
</div>
{/if}

<br />

<table width=100% cellpadding=5 cellspacing=1 bgcolor="#cccccc" align=center>
{foreach from=$replies item=reply}
<tr><td rowspan="2" bgcolor="{cycle values="#F4F4F4,#F8F8F8"}" width="200" valign="top">

{if $reply.admin}

<strong>{$reply.admin}</strong><br />
Staff<br />

{if $reply.rating}
<br />
Rating: {$reply.rating}
<br />
{/if}

{else}

<strong>{$reply.clientname}</strong><br />

{if $reply.userid}
Client<br />
{else}
<a href="mailto:{$reply.clientemail}">{$reply.clientemail}</a>
<br />
<input type="button" value="Block Sender" style="font-size:9px;" onclick="window.location='{$smarty.server.PHP_SELF}?action=viewticket&id={$ticketid}&blocksender=true'"><br>
{/if}

{/if}

{if $reply.id}

<br />
<div class="editticketbuttons{$reply.id}"><input type="button" value="Edit" class="editbutton" id="{$reply.id}" /></div><div class="editticketbuttons{$reply.id}" style="display:none"><input type="button" value="Save" class="savebutton" id="{$reply.id}" >&nbsp;<input type="button" value="Cancel" class="cancelbutton" id="{$reply.id}" /></div>

{/if}

</td><td bgcolor="#F4F4F4">

{if $reply.id}
<a href="#" onClick="doDeleteReply('{$reply.id}');return false">
{else}
<a href="#" onClick="doDeleteTicket();return false">
{/if}
<img src="images/icons/delete.png" alt="Delete Support Ticket" align="right" border="0" hspace="5"></a>

{if $reply.id}
<a href="#" onClick="quoteTicket('','{$reply.id}')">
{else}
<a href="#" onClick="quoteTicket('{$ticketid}','')">
{/if}
<img src="images/icons/quote.png" align="right" border="0"></a> {$reply.date}

</td></tr>
<tr><td bgcolor="#F4F4F4"{if $reply.id} id="{$reply.id}_box"{/if}>

{$reply.message}

{if $reply.numattachments}
<p>
<b>Attachments</b>
<br />
{foreach from=$reply.attachments item=attachment}
<img src="../images/article.gif"> <a href="../{$attachment.dllink}">{$attachment.filename}</a> <small><a href="{$attachment.deletelink}" style="color:#cc0000">remove</a></small><br />
{/foreach}
</p>
{/if}

</td></tr>
{/foreach}
</table>

<p align="center"><a href="supportticketsprint.php?id={$ticketid}" target="_blank">View Printable Version</a></p>