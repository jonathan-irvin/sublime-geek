<link rel="stylesheet" type="text/css" href="templates/orderforms/web20cart/style.css" />
<h2>{$LANG.cartexistingclientlogin}</h2>
<p>{$LANG.cartexistingclientlogindesc}</p>
<form action="dologin.php?goto=cart" method="post">
  {if $incorrect}
  <div class="errorbox">{$LANG.loginincorrect}</div>
  <br />
  {/if}
  <table border="0" cellpadding="0" cellspacing="0" class="frame">
    <tr>
      <td><table border="0" align="center" cellpadding="10" cellspacing="0">
          <tr>
            <td width="150" align="right" class="fieldarea">{$LANG.loginemail}:</td>
            <td><input type="text" name="username" size="40" value="{$username}" /></td>
          </tr>
          <tr>
            <td width="150" align="right" class="fieldarea">{$LANG.loginpassword}:</td>
            <td><input type="password" name="password" size="25" /></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p align="center">
    <input type="submit" value="{$LANG.loginbutton}" class="button" />
  </p>
</form>
<p align="center"><strong>{$LANG.loginforgotten}</strong> <a href="pwreset.php" target="_blank">{$LANG.loginforgotteninstructions}</a></p>