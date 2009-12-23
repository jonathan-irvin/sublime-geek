<?php /* Smarty version 2.6.10, created on 2009-11-16 19:43:21
         compiled from install/install.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'install/install.tpl', 149, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'install/install_header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  <div class="mcenter">
    <div class="arialwhite14 txtleft">
    <?php if ($this->_tpl_vars['step'] == 1): ?>
      <strong><span class="txtunderlined">Thank you for choosing POS-Tracker 3.0.0. Please fill the form to set the database information.</span></strong>
      <ul>
        <li>Current PHP version: <?php echo $this->_tpl_vars['phpversion']; ?>
 (Needs to be greater than 5.1.2)</li>
        <li>Your CURL Version: <?php echo $this->_tpl_vars['curlversion']['version'];  if ($this->_tpl_vars['curlversion']['version'] == '0'): ?> (fopen alternative: <?php echo $this->_tpl_vars['fopen']; ?>
)<?php endif; ?></li>
      </ul>
      <strong><span class="txtunderlined">Required Modules Installed</span></strong>
      <ul>
        <li>CURL: <?php echo $this->_tpl_vars['curl'];  if ($this->_tpl_vars['curl'] == 'No' && $this->_tpl_vars['fopen'] == 'Yes'): ?> (Will use fopen)<?php endif; ?></li>
        <li>SimpleXML: <?php echo $this->_tpl_vars['simpleXML']; ?>
</li>
        <li>Hash: <?php echo $this->_tpl_vars['hash']; ?>
</li>
        <li>cache/template_c: <?php if ($this->_tpl_vars['cache']): ?>OK<?php else: ?><span style="color:red;font-weight:bold;">NOT WRITABLE!</span><?php endif; ?></li>
        <li>eveconfig/dbconfig.php: <?php if ($this->_tpl_vars['dbconfig']): ?>OK<?php else: ?><span style="color:red;font-weight:bold;">NOT WRITABLE!</span><?php endif; ?></li>
      </ul>
      <form class="txtleft" method="post" action="install.php?step=2">
      <div style="margin-top:40px;">
        <input type="hidden" id="querycount" name="querycount" value="<?php echo $this->_tpl_vars['querycount']; ?>
" />
        <input type="hidden" id="querytotal" name="querytotal" value="<?php echo $this->_tpl_vars['querytotal']; ?>
" />
        <table style="width:740px;" summary="Database Configuration">
          <tr>
            <td>MySQL Host</td>
            <td><input type="text" id="dbhost" name="dbhost" value="localhost" /></td>
          </tr>
          <tr>
            <td>MySQL Database</td>
            <td><input type="text" id="dbname" name="dbname" value="" /></td>
          </tr>
          <tr>
            <td>MySQL Username</td>
            <td><input type="text" id="dbuname" name="dbuname" value="" /></td>
          </tr>
          <tr>
            <td>MySQL Password</td>
            <td><input type="password" id="dbpass" name="dbpass" value="" /></td>
          </tr>
          <tr>
            <td>Table Prefix</td>
            <td><input type="text" id="dbprefix" name="dbprefix" value="pos3_" /></td>
          </tr>
          <tr>
            <td>Upgrade From 2.1.x</td>
            <td><input type="checkbox" id="dbupgrade" name="dbupgrade" /> (Make sure the Prefix is the same as your current setup)</td>
          </tr>
          <tr>
            <td colspan="2"><hr /></td>
          </tr>
          <tr>
            <td colspan="2" class="txtleft">
              <input type="button" id="btnTest" value="test" onclick="ajax_CheckDB();" />
              <img id="loader" style="display:none;" src="images/loader.gif" alt="loader" />
              <img id="loaderblank" src="images/loader.blank.black.gif" alt="loaderblank" />
              <button type="button" id="btnWrite" onclick="ajax_WriteConfig();" disabled="disabled">Write Config</button>
              <img id="loader2" style="display:none;" src="images/loader.gif" alt="loader2" />
              <img id="loaderblank2" src="images/loader.blank.black.gif" alt="loaderblank2" />
              <button type="button" id="btnNext" disabled="disabled" onclick="ajax_InstallTables();">Install tables</button>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="txtleft"><div id="dbinfo" style="font-size: 11px;font-weight: bold;">&nbsp;</div></td>
          </tr>
        </table>
      </div>
      </form>
    <?php elseif ($this->_tpl_vars['step'] == 2): ?>
    <?php if (! $this->_tpl_vars['done']): ?>
      Problem?
    <?php else: ?>
      <strong><span class="txtunderlined">Tables created/updated successfully!</span></strong>
      <br /><br />
      This is to create the user <strong>'admin'</strong>. Please provide an email address and a password.<br />
      You must <strong>click</strong> the <strong>"Next"</strong> button if using the IGB!
      <form method="post" action="install.php?step=3">
      <div style="margin-top:10px;">
        <input type="hidden" name="name" value="<?php if ($this->_tpl_vars['IS_IGB']):  echo $this->_tpl_vars['userinfo']['username'];  else: ?>Admin<?php endif; ?>" />
        <table style="width:560px;" summary="Admin configuration">
          <tr>
            <td>Email Address:</td>
            <td><input type="text" name="email" maxlength="255" /></td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input type="password" name="pass" maxlength="255" /></td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" name="action" value="Next" /></td>
          </tr>
        </table>
      </div>
      </form>
    <?php endif; ?>
    <?php elseif ($this->_tpl_vars['step'] == 4): ?>
      <div class="mcenter txtcenter">
      <p>
        <a class="arialwhite14 txtunderlined" href="install.php?step=5" title="Next">Next</a>
      </p>
      </div>
      <table class="tracktable mcenter" style="font-size:11px; font-family: Arial, sans-serif;" summary="Moon Installation">
        <tr style="background-color:#4F0202;">
          <td>Region</td>
          <td>Region ID</td>
          <td>File Name</td>
          <td>Currently Installed?</td>
          <td>Install/Uninstall?</td>
        </tr>
      <?php $_from = $this->_tpl_vars['regions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['region']):
?>
        <tr>
          <td><?php echo $this->_tpl_vars['region']['regionName']; ?>
</td>
          <td><?php echo $this->_tpl_vars['region']['regionID']; ?>
</td>
          <td><?php echo $this->_tpl_vars['region']['file_name']; ?>
</td>
          <td><div id="row_<?php echo $this->_tpl_vars['region']['regionID']; ?>
"><?php if ($this->_tpl_vars['region']['installed']): ?>Yes<?php else: ?>No<?php endif; ?></div></td>
          <td style="width:100px;"><button type="button" id="region_<?php echo $this->_tpl_vars['region']['regionID']; ?>
" onclick="ajax_InstallRegion(<?php echo $this->_tpl_vars['region']['regionID']; ?>
);"><?php if ($this->_tpl_vars['region']['installed']): ?>Uninstall<?php else: ?>Install<?php endif; ?></button>&nbsp;&nbsp;<img id="loaderblank_<?php echo $this->_tpl_vars['region']['regionID']; ?>
" src="images/loader.blank.black.gif" alt="loaderblank" /><img style="display:none;" id="loader_<?php echo $this->_tpl_vars['region']['regionID']; ?>
" src="images/loader.gif" alt="loaderblank" /></td>
        </tr>
      <?php endforeach; endif; unset($_from); ?>
      </table>
	<?php elseif ($this->_tpl_vars['step'] == 5): ?>
    <h4>ADD an API Key</h4>
    <div class="mcenter txtcenter">
      <p>
        <a class="arialwhite14 txtunderlined" href="install.php?step=6" title="Finish Installation">Finish Installation</a>
      </p>
    </div>
    <div class="mcenter">
      <form method="post" action="install.php?action=getcharacters">
      <div>
        USERID: <input type="text" name="userid" size="10" /> APIKEY: <input type="text" name="apikey" size="35" /> <input type="submit" value="Select Character" />
      </div>
      </form>
      </div>
      <br /><br /><hr />
          <div class="mcenter">
      <div>
      <h4>Current API Keys</h4>
        <table class="tracktable" style="width:640px;">
        <thead>
          <tr class="trackheader">
            <th>Corp</th>
            <th>UserID</th>
            <th>API Key (first 5 characters)</th>
          </tr>
        </thead>
        <tbody>
        <?php $_from = $this->_tpl_vars['keys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key']):
?>
          <tr>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['key']['corp'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['key']['userID'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['key']['shortkey'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
           </tr>
        <?php endforeach; endif; unset($_from); ?>
        </tbody>
        </table>
      </div>
      </form>
    
	<?php endif; ?>
	<?php if ($this->_tpl_vars['action'] == 'getcharacters'): ?>
      <?php $_from = $this->_tpl_vars['characters']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['character']):
?>
      <?php $this->assign('alliance', $this->_tpl_vars['character']['alliance']); ?>
      <div style="margin-bottom:25px;">
      <form id="u_<?php echo $this->_tpl_vars['character']['characterID']; ?>
" method="post" action="install.php">
      <div>
        <input type="hidden" name="action" value="saveapi" />
        <input type="hidden" name="apikey" value="<?php echo $this->_tpl_vars['apikey']; ?>
" />
        <input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['userid']; ?>
" />
        <input type="hidden" name="characterID" value="<?php echo $this->_tpl_vars['character']['characterID']; ?>
" />
        <input type="hidden" name="corporationName" value="<?php echo $this->_tpl_vars['character']['corporationName']; ?>
" />
        <input type="hidden" name="corporationID" value="<?php echo $this->_tpl_vars['character']['corporationID']; ?>
" />
        <input type="hidden" name="allianceName" value="<?php echo $this->_tpl_vars['alliance']['allianceName']; ?>
" />
        <input type="hidden" name="allianceID" value="<?php echo $this->_tpl_vars['alliance']['allianceID']; ?>
" />
        <input type="submit" value="Save <?php echo $this->_tpl_vars['character']['name']; ?>
 API Key" />
      </div>
      </form>
      </div>
      <?php endforeach; endif; unset($_from); ?>


    <?php endif; ?>
    </div>
  </div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>