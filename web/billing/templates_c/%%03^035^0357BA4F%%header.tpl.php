<?php /* Smarty version 2.6.26, created on 2010-10-03 20:48:18
         compiled from v4/header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'v4/header.tpl', 52, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['charset']; ?>
" />
<title>WHMCS - <?php echo $this->_tpl_vars['pagetitle']; ?>
</title>
<link href="templates/v4/style.css" rel="stylesheet" type="text/css" />
<link href="../includes/jscript/css/ui.all.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/jscript/jquery.js"></script>
<script type="text/javascript" src="../includes/jscript/jqueryui.js"></script>
<script type="text/javascript" src="../includes/jscript/adminmenu.js"></script>
<script type="text/javascript" src="../includes/jscript/adminsearchbox.js"></script>
<?php echo '<script>
  $(document).ready(function(){
     $("#shownotes").click(function () {
        $("#mynotes").toggle("slow");
        return false;
    });
    $("#savenotes").click(function () {
        $("#mynotes").toggle("slow");
        $.post("index.php", { action: "savenotes", notes: $("#mynotesbox").val() });
    });
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
        dateFormat: "'; ?>
<?php echo $this->_tpl_vars['datepickerformat']; ?>
<?php echo '",
        showOn: "button",
        buttonImage: "images/showcalendar.gif",
        buttonImageOnly: true,
        showButtonPanel: true
    });
    '; ?>
<?php echo $this->_tpl_vars['jquerycode']; ?>
<?php echo '
  });'; ?>

  <?php echo $this->_tpl_vars['jscode']; ?>

</script>
</head>
<body>
<div id="mynotes"><textarea id="mynotesbox" rows="15" cols="80"><?php echo $this->_tpl_vars['admin_notes']; ?>
</textarea><br /><input type="button" value="Save" id="savenotes" /></div>
<div id="topnav">
  <div id="welcome">Welcome Back <strong><?php echo $this->_tpl_vars['admin_username']; ?>
</strong>&nbsp;&nbsp;- <a href="../" title="Client Area">Client Area</a> | <a href="#" id="shownotes" title="My Notes">My Notes</a> | <a href="myaccount.php" title="My Account">My Account</a> | <a href="logout.php" title="Logout">Logout</a></div>
  <div id="date"><?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%A | %d %B %Y | %H:%M %p") : smarty_modifier_date_format($_tmp, "%A | %d %B %Y | %H:%M %p")); ?>
</div>
  <div class="clear"></div>
</div>
<div id="logo_container"><img class="banner" src="templates/v4/images/logo.gif" alt="WHMCS" width="400" height="115" border="0" />
  <div id="intellisearch"><strong>Intelligent Search</strong><br />
    <div style="padding-top: 5px;" align="center">
      <input type="text" id="intellisearchval" />
      <img src="images/icons/delete.png" alt="Cancel" width="16" height="16" class="absmiddle" id="intellisearchcancel" />
      </div>
    <div align="left" id="searchresults"></div>
  </div>
</div>
<div id="navigation">
  <ul>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu1, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='index.php'"><a href="index.php" title="Home">Home</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu2, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='clients.php'"><a href="clients.php" title="Clients">Clients</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu3, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='orders.php'"><a href="orders.php" title="Orders">Orders</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu4, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='transactions.php'"><a href="transactions.php" title="Billing">Billing</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu5, '');" onmouseout="this.className='navbutton';delayhidemenu();" onclick="window.location='supportcenter.php'"><a href="supportcenter.php" title="Support">Support</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';" onmouseout="this.className='navbutton';" onclick="window.location='reports.php'"><a href="reports.php" title="Reports">Reports</a></li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu7, '');" onmouseout="this.className='navbutton';delayhidemenu();">Utilities</li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu8, '');" onmouseout="this.className='navbutton';delayhidemenu();">Setup</li>
    <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu9, '');" onmouseout="this.className='navbutton';delayhidemenu();">Help</li>
  </ul>
</div>
<div id="content_container">
  <div id="left_side">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "v4/sidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  </div>
  <div id="content">
    <h1><?php echo $this->_tpl_vars['pagetitle']; ?>
</h1>
    <div id="content_padded">