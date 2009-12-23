<!--[* $Id: track.tpl 205 2008-10-24 08:06:58Z stephenmg $ *]-->
<!--[include file='header.tpl']-->
  <form method="post" action="track.php">
  <!--[html_options options=$sortlist name='sortlist' selected=$sb]-->
  <input type="submit" name="action" value="Sort Towers" />
  <!--[html_options options=$pagernumlist name='pagernumsel' selected=$pager.limit]-->
  <input type="submit" name="action" value="Display" />
  </form>
  <table class="mcenter tracktable" style="width:100%;" cellspacing="0">
  <tbody>
    <tr class="trackheader">
      <!--[*<td>Parent Outpost</td>*]-->
      <td>Status</td>
      <td>Pos type</td>
      <td>Tower Name</td>
      <td>Location</td>
      <td>Region</td>
      <!--<td>Owner</td>-->
      <td>Last Update</td>
      <td>Status</td>
      <td>Action</td>
    </tr>

  <!--[foreach item='pos' from=$poses]-->
    <!--[assign var='pos_size' value=$pos.pos_size]-->
    <!--[assign var='pos_race' value=$pos.pos_race]-->
    <tr style="background-color:<!--[$pos.bgcolor]-->;">
       <!--[*<td>None</td>*]-->
      <td><!--[if $pos.pos_status_img]--><img src="themes/<!--[$config.theme]-->/images/<!--[$pos.pos_status_img]-->" alt="<!--[$pos.pos_status_img]-->" /><!--[else]-->&nbsp;<!--[/if]--></td>
      <td><!--[$arrposize.$pos_size]--> <!--[$arrporace.$pos_race]--></td>
      <td><!--[$pos.towerName]--></td>
      <td><!--[$pos.MoonName]--></td>
      <td><!--[$pos.region]--></td>
      <!--<td><a href="showinfo:1373//1048666916"> </a></td>-->
      <td><!--[$pos.last_update]--></td>
      <td style="color:<!--[$pos.textcolor]-->;"><!--[$pos.online]--></td>
      <td><button type="button" onclick="window.location.href='viewpos.php?i=<!--[$pos.pos_id]-->'">View</button><button type="button" onclick="window.location.href='fuelbill.php?pos_id=<!--[$pos.pos_id]-->'">Fuel Bill</button><button type="button" onclick="window.location.href='editpos.php?i=<!--[$pos.pos_id]-->'">Edit</button><button type="button" onclick="window.location.href='deletepos.php?i=<!--[$pos.pos_id]-->'">Delete</button></td>
    </tr>

  <!--[/foreach]-->

  </tbody>
  </table>
  <!--[pager numitems=$pager.numitems limit=$pager.limit]-->
  <div class="mcenter"><a href="addpos.php" title="Add a new Tower">Add a New Tower</a></div>
<!--[include file='footer.tpl']-->