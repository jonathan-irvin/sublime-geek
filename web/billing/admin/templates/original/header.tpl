<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$charset}" />
<title>WHMCS - {$pagetitle}</title>
<link href="templates/original/style.css" rel="stylesheet" type="text/css" />
<link href="../includes/jscript/css/ui.all.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/jscript/jquery.js"></script>
<script type="text/javascript" src="../includes/jscript/jqueryui.js"></script>
<script type="text/javascript" src="../includes/jscript/adminmenu.js"></script>
<script type="text/javascript" src="../includes/jscript/adminsearchbox.js"></script>
{literal}<script>
  $(document).ready(function(){
     $("#intellisearchval").keyup(function () {
        var intellisearchlength = $("#intellisearchval").val().length;
        if (intellisearchlength>2) {
        $.post("search.php", { intellisearch: "true", value: $("#intellisearchval").val() },
          function(data){
            $("#searchresults").html(data);
            $("#searchresults").slideDown("slow");
          });
        }
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
<div id="searchbox" style="visibility: hidden;">
  <form method="get" action="search.php">
    &nbsp;<b>Quick Search</b>
    <select name="type" id="searchtype" onchange="populate(this)">
      <option value="clients">Clients </option>
      <option value="orders">Orders </option>
      <option value="services">Services </option>
      <option value="domains">Domains </option>
      <option value="invoices">Invoices </option>
      <option value="tickets">Tickets </option>
    </select>
    <select name="field" id="searchfield">
      <option>Client ID</option>
      <option selected="selected">Client Name</option>
      <option>Company Name</option>
      <option>Email Address</option>
      <option>Address 1</option>
      <option>Address 2</option>
      <option>City</option>
      <option>State</option>
      <option>Postcode</option>
      <option>Country</option>
      <option>Phone Number</option>
      <option>CC Last Four</option>
    </select>
    <input type="text" name="q" size="25" />
    <input type="submit" value="Search" class="button" />
  </form>
</div>
<div id="topnav">
  <div id="welcome">Welcome Back <strong>{$admin_username}</strong>&nbsp;&nbsp;[ <a href="#" onclick="toggleadvsearch();return false"><strong>Quick Search</strong></a> | <a href="myaccount.php"><strong>My Account</strong></a> | <a href="logout.php"><strong>Logout</strong></a> ]</div>
  <div id="date">{$smarty.now|date_format:"%A <strong>|</strong> %d %B %Y <strong>|</strong> %H:%M %p"}</div>
  <div class="clear"></div>
</div>
<div id="logo_container"><img src="templates/original/images/toplogo.gif" alt="WHMCS" width="300" height="90" border="0" /></div>
<div id="navigation">
  <ul>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu1, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='index.php'"><a href="index.php">Home</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu2, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='clients.php'"><a href="clients.php">Clients</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu3, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='orders.php'"><a href="orders.php">Orders</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu4, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='transactions.php'"><a href="transactions.php">Billing</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu5, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='supportcenter.php'"><a href="supportcenter.php">Support</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';" onmouseout="this.className='navbutton';" onclick="window.location='reports.php'"><a href="reports.php">Reports</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu7, '');" onmouseout="this.className='navbutton';delayhidemenu();">Utilities</li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu8, '');" onmouseout="this.className='navbutton';delayhidemenu();">Configuration</li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu9, '');" onmouseout="this.className='navbutton';delayhidemenu();">Help</li>
  </ul>
</div>
<div id="content_container">
  <div id="left_side">

    {include file="original/sidebar.tpl"}

  </div>
  <div id="content">
    <div class="header_container">
      <h1><img src="images/icons/{$pageicon}.png" alt="Hosting Clients" width="16" height="16" class="absmiddle" /> {$pagetitle}</h1>
      <div id="intellisearch"><img src="images/icons/search.png" alt="Search" width="16" height="16" class="absmiddle" /> <strong>Intelligent Search</strong>
        <input type="text" id="intellisearchval" />
        <img src="images/delete.gif" alt="Cancel" width="16" height="16" class="absmiddle" id="intellisearchcancel" />
        <div align="left" id="searchresults"></div>
        <div class="clear"></div>
      </div>
    </div>
    <div id="content_padded">
      <br />
