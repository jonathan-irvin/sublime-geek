<!--[* $Id: register.tpl 131 2008-07-21 06:18:41Z stephenmg $ *]-->
<!--[include file='header.tpl']-->


  <h2>Welcome to the POS Tracker</h2>
  <div class="mcenter">
  <!--[if $IS_IGB]-->
    <form method="post" action="register.php">
      Email Address: <input type="text" name="email" maxlength="255" /><br />
      Password: <input type="password" name="pass" maxlength="255" /><br />
      <input type="submit" name="action" value="Create" />
    </form>
  <!--[else]-->
    <strong>You must use the in game browser to register!</strong>
  <!--[/if]-->
  </div>

<!--[include file='footer.tpl']-->