<!--[* $Id: outpost.tpl 168 2008-09-20 07:24:02Z stephenmg $ *]-->
<!--[include file='header.tpl']-->

  <table class="mcenter tracktable" style="width:100%;" cellspacing="0">
  <tbody>
    <tr class="trackheader">
      <td>Outpost Name</td>
      <!--[*<td>System</td>*]-->
      <td>Last Update</td>
      <td>Status</td>
      <td>Action</td>

    </tr>

  <!--[foreach item='outpost' from=$outposts]-->
    <tr style="background-color:<!--[$pos.bgcolor]-->;">
      <td><!--[$outpost.outpost_name]--></td>
      <!--[*<td><!--[$outpost.systemID]--></td>*]-->
      <td><!--[$outpost.lastupdate]--></td>
      <td><!--[$outpost.outpostdaycalc]--></td>
      <td><button type="button" onclick="window.location.href='viewoutpost.php?i=<!--[$outpost.outpost_id]-->'">View</button><button type="button" onclick="window.location.href='editoutpost.php?i=<!--[$outpost.outpost_id]-->'">Edit</button><button type="button" onclick="window.location.href='outpost.php?i=<!--[$outpost.outpost_id]-->'">Delete</button></td>
    </tr>

  <!--[/foreach]-->

  </tbody>
  </table>

  <div class="mcenter"><a href="addoutpost.php" title="Add a new Outpost">Add a New Outpost</a></div>
<!--[include file='footer.tpl']-->