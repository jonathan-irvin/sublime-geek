<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$charset}" />
<title>WHMCS - {$pagetitle}</title>
<link href="templates/simple/style.css" rel="stylesheet" type="text/css" />
<link href="../includes/jscript/css/ui.all.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/jscript/jquery.js"></script>
<script type="text/javascript" src="../includes/jscript/jqueryui.js"></script>
<script type="text/javascript" src="../includes/jscript/adminmenu.js"></script>
<script type="text/javascript" src="../includes/jscript/adminsearchbox.js"></script>
{literal}<script>
function intellisearch() {
    $.post("search.php", { intellisearch: "true", value: $("#intellisearchval").val() },
    function(data){
        $("#searchresults").html(data);
        $("#searchresults").slideDown("slow");
    });
}
  $(document).ready(function(){
    $("#shownotes").click(function () {
        $("#mynotes").toggle("slow");
        return false;
    });
    $("#savenotes").click(function () {
        $("#mynotes").toggle("slow");
        $.post("index.php", { action: "savenotes", notes: $("#mynotesbox").val() });
    });
    $("#intellisearchcancel").click(function () {
        $("#intellisearchval").val("");
        $("#searchresults").slideUp("slow");
    });
    $(".datepick").datepicker({
        dateFormat: "{/literal}{$datepickerformat}{literal}",
        showOn: "button",
        buttonImage: "images/showcalendar.gif",
        buttonImageOnly: true,
        showButtonPanel: true
    });
    {/literal}{$jquerycode}{literal}
  });{/literal}
  {$jscode}
</script>
</head>
<body>

<table width="100%" cellspacing="0" cellpadding="0" id="header"><tr><td nowrap>

<h1><img src="images/icons/{$pageicon}.png" width="16" height="16" /> {$pagetitle}</h1>

<br />

<div id="navigation">
  <ul>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu1, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='index.php'"><a href="index.php">Home</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu2, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='clients.php'"><a href="clients.php">Clients</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu3, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='orders.php'"><a href="orders.php">Orders</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu4, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='transactions.php'"><a href="transactions.php">Billing</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu5, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='supportcenter.php'"><a href="supportcenter.php">Support</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';" onmouseout="this.className='navbutton';" onclick="window.location='reports.php'"><a href="reports.php">Reports</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu7, '');" onmouseout="this.className='navbutton';delayhidemenu();">Utilities</li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu8, '');" onmouseout="this.className='navbutton';delayhidemenu();">Setup</li>
    <li class="navend" onmouseover="this.className='navendover';dropdownmenu(this, event, menu9, '');" onmouseout="this.className='navend';delayhidemenu();">Help</li>
  </ul>
</div>

</td><td id="headerright" valign="top">

<a href="../"><strong>Client Area</strong></a> | <a href="#" id="shownotes"><strong>My Notes</strong></a> | <a href="myaccount.php"><strong>My Account</strong></a> | <a href="logout.php"><strong>Logout</strong></a><br />
{$smarty.now|date_format:"%A, %d %B %Y, %H:%M"}<br /><br />
Online Staff: {$adminsonline}

</td></tr></table>

<div id="mynotes"><textarea id="mynotesbox" rows="15" cols="80">{$admin_notes}</textarea><br /><input type="button" value="Save" id="savenotes" /></div>

<table bgcolor="#ffffff" width="100%" cellspacing="0" cellpadding="0">
<tr><td valign="top" style="padding:15px;">

