<!--[* $Id: user.tpl 131 2008-07-21 06:18:41Z stephenmg $ *]-->
<!--[include file='header.tpl']-->


  <h2>User Panel</h2>
  <div class="mcenter">
    <h4>User Information</h4>
    <form method="post" action="user.php">
    <div>
      <input type="hidden" name="id"     value="<!--[$id]-->" />
      <input type="hidden" name="action" value="changeinfo" />
      <table class="mcenter tracktable" style="width:500px;">
      <tbody>
        <tr class="trackheader">
          <td>New password</td>
          <td><input type="password" name="newpass" value="" /></td>
        </tr>
        <tr class="trackheader">
          <td>Confirm your new password</td>
          <td><input type="password" name="newpass2" value="" /></td>
        </tr>
        <tr class="trackheader">
          <td>Your email</td>
          <td><input type="text" name="email" value="<!--[$email]-->" /></td>
        </tr>
        <tr class="trackheader">
          <td colspan="2"><input type="submit" value="Change Info" /></td>
        </tr>
      </tbody>
      </table>
    </div>
    </form>
    <br /><hr /><br />
    <div class="mcenter txtcenter">
    <!--[if $IS_IGB]-->
      <form method="post" action="user.php">
      <div>
        <input type="hidden" name="action" value="updatecorpinfo" />
        <input type="submit" value="Update General Info" />
      </div>
      </form>
    <!--[else]-->
      You have to be in-game to update your corp/Alliance information!
    <!--[/if]-->
    </div>
  </div>

<!--[include file='footer.tpl']-->