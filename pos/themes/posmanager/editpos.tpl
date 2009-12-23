<!--[* $Id: editpos.tpl 241 2009-04-13 03:58:45Z stephenmg $ *]-->
<!--[include file='header.tpl']-->

<div>
  <a href="viewpos.php?i=<!--[$tower.pos_id]-->" title="Back">Back</a>
  <form method="post" action="editpos.php">
  <div>
    <input name="i" value="<!--[$tower.pos_id]-->" type="hidden" />
  </div>
  <table class="mcenter">
  <tbody>
    <tr>
      <td rowspan="11"><img src="images/structures/256_256/<!--[$tower.typeID]-->.gif" alt="<!--[$tower.towerName]-->" /></td>
      <td class="tracktable txtleft">Last Updated:</td>
      <td class="tracktable txtleft"><!--[$last_update]--></td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="tracktable txtleft">Was updated:</td>
      <td class="tracktable txtleft"><!--[$hoursago]--> Hours Ago</td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="tracktable txtleft">Type:</td>
      <td class="tracktable txtleft"><!--[$arrposize[$tower.pos_size]]--> <!--[$arrporace[$tower.pos_race]]--></td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="tracktable txtleft">Status:</td>
      <td class="tracktable txtleft">
        <!--[html_options options=$towerstatus name='newstatus' selected=$tower.pos_status]-->
      </td>
    </tr>
  <tr>
      <!--<td></td>-->
      <td class="tracktable txtleft">Outpost:</td>
      <td class="tracktable txtleft">
        <!--[html_options options=$outpostlist name='outpostlist' selected=$tower.outpost_id]-->
      </td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="tracktable txtleft">Location:</td>
      <td class="tracktable txtleft"><!--[$tower.moonName]--></td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="tracktable txtleft">Tower Name:</td>
      <td class="tracktable txtleft">
        <input name="new_tower_name" type="text" value="<!--[$tower.towerName]-->" />
      </td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="tracktable txtleft">Sovereignty:</td>
      <td class="tracktable txtleft"><!--[if $tower.sovereigntyLevel]-->Yes<!--[else]-->No<!--[/if]--></td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="tracktable txtleft">Sovereignty Status:</td>
      <td class="tracktable txtleft"><!--[if $tower.sovfriendly]-->Friendly<!--[else]-->Hostile<!--[/if]--></td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="tracktable txtleft">Sovereignty Level:</td>
      <td class="tracktable txtleft"><!--[$tower.sovereigntyLevel]--></td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="tracktable txtleft">CPU:</td>
      <td class="tracktable txtleft"><!--[$tower.current_cpu]--> / <!--[$tower.total_cpu]--></td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td></td>
      <td class="tracktable txtleft">PG:</td>
      <td class="tracktable txtleft"><!--[$tower.current_pg]--> / <!--[$tower.total_pg]--></td>
    </tr>
    <tr>
      <td colspan="3" class="tracktable txtcenter"><input type="submit" name="action" value="Change Tower Information" /></td>
    </tr>
  </tbody>
  </table>
  </form>
</div>
<hr />
<div>
<form method="post" action="editpos.php">
<input name="i" value="<!--[$tower.pos_id]-->" type="hidden" />
<!--[html_options options=$users name='newowner' selected=$tower.owner_id]-->
<input type="submit" name="action" value="Assign As Fuel Tech" />
<input type="submit" name="action" value="Assign As Backup Fuel Tech" />
</div>
<hr />
<div>
  <form method="post" action="editpos.php">
  <div>
    <input name="i" value="<!--[$tower.pos_id]-->" type="hidden" />
  </div>
  <table class="mcenter tracktable" style="width:650px; padding:5px;" cellspacing="0">
  <tbody>
    <tr>
      <th>Fuel</th>
      <th>Previously</th>
      <th>New Values</th>
      <th>Optimum</th>
      <th colspan="2">Diff</th>
    </tr>
    <tr>
      <td>Enriched Uranium</td>
      <td><!--[$tower.avail_uranium]--></td>
      <td><input name="uranium" value="<!--[$tower.avail_uranium]-->" size="10" type="text" /></td>
      <td><!--[$tower.optimum_uranium]--></td>
      <td class="txtright"><!--[math equation="x-y" x=$tower.optimum_uranium y=$tower.avail_uranium]--></td>
      <td class="txtright">(<!--[math equation="(x-y)*z" x=$tower.optimum_uranium y=$tower.avail_uranium z=1]--> m3)</td>
    </tr>
    <tr>
      <td>Oxygen</td>
      <td><!--[$tower.avail_oxygen]--></td>
      <td><input name="oxygen" value="<!--[$tower.avail_oxygen]-->" size="10" type="text" /></td>
      <td><!--[$tower.optimum_oxygen]--></td>
      <td class="txtright"><!--[math equation="x-y" x=$tower.optimum_oxygen y=$tower.avail_oxygen]--></td>
      <td class="txtright">(<!--[math equation="(x-y)*z" x=$tower.optimum_oxygen y=$tower.avail_oxygen z=1]--> m3)</td>
    </tr>
    <tr>
      <td>Mechanical Parts</td>
      <td><!--[$tower.avail_mechanical_parts]--></td>
      <td><input name="mechanical_parts" value="<!--[$tower.avail_mechanical_parts]-->" size="10" type="text" /></td>
      <td><!--[$tower.optimum_mechanical_parts]--></td>
      <td class="txtright"><!--[math equation="x-y" x=$tower.optimum_mechanical_parts y=$tower.avail_mechanical_parts]--></td>
      <td class="txtright">(<!--[math equation="(x-y)*z" x=$tower.optimum_mechanical_parts y=$tower.avail_mechanical_parts z=1]--> m3)</td>
    </tr>
    <tr>
      <td>Coolant</td>
      <td><!--[$tower.avail_coolant]--></td>
      <td><input name="coolant" value="<!--[$tower.avail_coolant]-->" size="10" type="text" /></td>
      <td><!--[$tower.optimum_coolant]--></td>
      <td class="txtright"><!--[math equation="x-y" x=$tower.optimum_coolant y=$tower.avail_coolant]--></td>
      <td class="txtright">(<!--[math equation="(x-y)*z" x=$tower.optimum_coolant y=$tower.avail_coolant z=2]--> m3)</td>
    </tr>
    <tr>
      <td>Robotics</td>
      <td><!--[$tower.avail_robotics]--></td>
      <td><input name="robotics" value="<!--[$tower.avail_robotics]-->" size="10" type="text" /></td>
      <td><!--[$tower.optimum_robotics]--></td>
      <td class="txtright"><!--[math equation="x-y" x=$tower.optimum_robotics y=$tower.avail_robotics]--></td>
      <td class="txtright">(<!--[math equation="(x-y)*z" x=$tower.optimum_robotics y=$tower.avail_robotics z=2]--> m3)</td>
    </tr>
  <tr>
      <td>Charters</td>
      <td><!--[$tower.avail_charters]--></td>
      <td><input name="charters" value="<!--[$tower.avail_charters]-->" size="10" type="text" /></td>
      <td><!--[$tower.optimum_charters]--></td>
      <td class="txtright"><!--[math equation="x-y" x=$tower.optimum_charters y=$tower.avail_charters]--></td>
      <td class="txtright">(<!--[math equation="(x-y)*z" x=$tower.optimum_charters y=$tower.avail_charters z=0.15]--> m3)</td>
    </tr>
    <tr>
      <td>Isotopes</td>
      <td><!--[$tower.avail_isotope]--></td>
      <td><input name="isotope" value="<!--[$tower.avail_isotope]-->" size="10" type="text" /></td>
      <td><!--[$tower.optimum_isotope]--></td>
      <td class="txtright"><!--[math equation="x-y" x=$tower.optimum_isotope y=$tower.avail_isotope]--></td>
      <td class="txtright">(<!--[math equation="(x-y)*z" x=$tower.optimum_isotope y=$tower.avail_isotope z=0.15]--> m3)</td>
    </tr>
    <tr>
      <td>Liquid Ozone</td>
      <td><!--[$tower.avail_ozone]--></td>
      <td><input name="ozone" value="<!--[$tower.avail_ozone]-->" size="10" type="text" /></td>
      <td><!--[$tower.optimum_ozone]--></td>
      <td class="txtright"><!--[math equation="x-y" x=$tower.optimum_ozone y=$tower.avail_ozone]--></td>
      <td class="txtright">(<!--[math equation="(x-y)*z" x=$tower.optimum_ozone y=$tower.avail_ozone z=0.4]--> m3)</td>
    </tr>
    <tr>
      <td>Heavy Water</td>
      <td><!--[$tower.avail_heavy_water]--></td>
      <td><input name="heavy_water" value="<!--[$tower.avail_heavy_water]-->" size="10" type="text" /></td>
      <td><!--[$tower.optimum_heavy_water]--></td>
      <td class="txtright"><!--[math equation="x-y" x=$tower.optimum_heavy_water y=$tower.avail_heavy_water]--></td>
      <td class="txtright">(<!--[math equation="(x-y)*z" x=$tower.optimum_heavy_water y=$tower.avail_heavy_water z=0.4]--> m3)</td>
    </tr>
    <tr>
      <td>Strontium Calthrates</td>
      <td><!--[$tower.avail_strontium]--></td>
      <td><input name="strontium" value="<!--[$tower.avail_strontium]-->" size="10" type="text" /></td>
      <td><!--[$tower.optimum_strontium]--></td>
      <td class="txtright"><!--[math equation="x-y" x=$tower.optimum_strontium y=$tower.avail_strontium]--></td>
      <td class="txtright">(<!--[math equation="(x-y)*z" x=$tower.optimum_strontium y=$tower.avail_strontium z=3]--> m3)</td>
    </tr>
    <tr>
      <td colspan="6" class="txtcenter" style="padding:10px;"><input name="action" value="Update Fuel" type="submit" /></td>
    </tr>
  </tbody>
  </table>
  </form>
</div>
<!--[*assign var='hangars' value=$tower.hangars*]-->
<!--[*if $hangars]-->
<hr />
<div>
  <h3>Hangars</h3>
  <!--[foreach item='hangar' key='hangarid' from=$hangars]-->
  <h4>Hangar <!--[$hangarid]--></h4>
  <table class="mcenter tracktable" style="width:650px; padding:5px;" cellspacing="0">
  <thead>
    <tr>
      <th>Fuel</th>
      <th>Previously</th>
      <th>New Values</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Enriched Uranium</td>
      <td><!--[$hangar.uranium]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Oxygen</td>
      <td><!--[$hangar.oxygen]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Mechanical Parts</td>
      <td><!--[$hangar.mechanical_parts]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Coolant</td>
      <td><!--[$hangar.coolant]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Robotics</td>
      <td><!--[$hangar.robotics]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Isotopes</td>
      <td><!--[$hangar.isotope]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Liquid Ozone</td>
      <td><!--[$hangar.ozone]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Heavy Water</td>
      <td><!--[$hangar.heavy_water]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Strontium Calthrates</td>
      <td><!--[$hangar.strontium]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td colspan="3" class="txtcenter"><input type="submit" value="Update Hangar Stock" /></td>
    </tr>
  </tbody>
  </table>
  <!--[/foreach]-->
</div>
<!--[/if*]-->

<!--[assign var='silos'  value=$tower.silos]-->
<!--[assign var='miners' value=$tower.miners]-->
<!--[if $miners]-->
<hr />
<div>
  <h3>Harvesters/Reactors Arrays</h3>
  <form method="post" action="editpos.php">
  <div>
    <input type="hidden" name="i"      value="<!--[$tower.pos_id]-->" />
    <input type="hidden" name="action" value="updateminers" />
  </div>
  <table class="mcenter tracktable" style="font-size: 12px;">
  <tbody>
    <tr>
      <th>Module</th>
      <th>Material</th>
    </tr>
  <!--[foreach item='miner' key='minerid' from=$miners]-->
    <tr>
      <td><!--[$miner.name]--> <!--[$miner.structure_id]--></td>
      <td><select name="material[<!--[$miner.structure_id]-->]"><!--[html_options options=$optmaterials selected=$miner.material_id]--></select><!--[*$miner.material_name*]--></td>
    </tr>
  <!--[/foreach]-->
    <tr>
      <td colspan="2" class="txtcenter"><input type="submit" value="Update Chain Info" /></td>
    </tr>
  </tbody>
  </table>
  </form>
</div>
<!--[/if]-->
<!--[if $silos]-->
<hr />
<div>
  <h3>Silo Arrays</h3>
  <form method="post" action="editpos.php">
  <div>
    <input type="hidden" name="i"      value="<!--[$tower.pos_id]-->" />
    <input type="hidden" name="action" value="updatesilos" />
  </div>
  <table class="mcenter tracktable" style="font-size: 12px;">
  <tbody>
    <tr>
      <th>Silo</th>
      <th>Material</th>
      <th>Input/Output</th>
      <th>Required/Produced</th>
      <th>Available</th>
      <th>Online</th>
      <th>FULL</th>
      <th>Connected to:</th>
      <th>Linked to:</th>
    </tr>
  <!--[foreach item='silo' key='siloid' from=$silos]-->
    <tr>
      <td>Silo <!--[$silo.silo_id]--></td>
      <td><select name="material[<!--[$silo.silo_id]-->]"><!--[html_options options=$optmaterials selected=$silo.material_id]--></select><!--[*$silo.material_name*]--></td>
      <!--[*<td><!--[if $silo.direction eq 'Output']-->Receiver<!--[else]-->Provider<!--[/if]--></td>*]-->
      <td><select name="direction[<!--[$silo.silo_id]-->]"><!--[html_options options=$optdirections selected=$silo.direction]--></select></td>
      <td><!--[$silo.rate]--> <span style="color:#aaaaaa;">(<!--[$silo.material_volume]-->m3)</span></td>
      <td><input type="text" name="new_amount[<!--[$silo.silo_id]-->]" value="<!--[$silo.material_amount]-->" /></td>
      <td><!--[daycalc hours=$silo.hourstofill]--></td>
      <td><!--[if $silo.full]-->YES<!--[else]-->No<!--[/if]--></td>
      <td><select name="connection[<!--[$silo.silo_id]-->]"><!--[html_options options=$optminers selected=$silo.connection_id]--></select></td>
      <td><input size="6" type="text" name="links[<!--[$silo.silo_id]-->]" value="<!--[$silo.silo_link]-->" /></td>
      <!--[*<td><!--[$silo.structure_name]--> (<!--[$silo.structure_material_name]-->)</td>*]-->
    </tr>
  <!--[/foreach]-->
    <tr>
      <td colspan="9" class="txtcenter"><input type="submit" value="Update Silo Info" /></td>
    </tr>
  </tbody>
  </table>
  </form>
</div>
<!--[/if]-->


<!--[assign var='mods' value=$tower.mods]-->
<div>
<hr />
  <form method="post" action="addstructure.php">
  <div>
    <input type="hidden" name="pos_id" value="<!--[$tower.pos_id]-->" />
    <input type="hidden" name="struct_amount" value="1" />
    <input type="submit" name="action" value="Add Structures" />
  </form>
    <form method="post" action="importfit.php">
    <input type="hidden" name="pos_id" value="<!--[$tower.pos_id]-->" />
    <input type="submit" name="action" value="Import Structures" />
  </div>
  </form>

</div>
<!--[if $mods]-->
<hr />
<div>
  <h3>Modules</h3>
  <form method="post" action="editpos.php">
  <div>
    <input type="hidden" name="i"      value="<!--[$tower.pos_id]-->" />
    <input type="hidden" name="action" value="updatemods" />
  </div>
  <table class="mcenter tracktable" style="width:600px;font-size: 12px;border-collapse:collapse;">
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>CPU</th>
      <th>PG</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <!--[foreach item='mod' from=$mods]-->
    <!--[assign var='modid' value=$mod.mod_id]-->
    <tr>
      <td class="txtleft"><!--[$mod.mod_id]--></td>
      <td class="txtleft"><!--[$mod.name]--></td>
      <td><!--[$mod.cpu]--></td>
      <td><!--[$mod.pg]--></td>
      <td><!--[foreach item='modstate' key='modstateid' from=$arronline]--><label><input style="width: 1.5em; height: 1.5em;" name="mod[<!--[$modid]-->]" value="<!--[$modstateid]-->"<!--[if $mod.online eq $modstateid]--> checked="checked"<!--[/if]--> type="radio" /><!--[$modstate]--></label><!--[/foreach]--><!--[*html_checkboxes options=$arronline selected=$mod.online name="mod[$modid]"*]--></td>
    </tr>
    <!--[/foreach]-->
    <tr>
      <td colspan="5" class="txtcenter"><input type="submit" value="Update Module Info" /></td>
    </tr>
  </tbody>
  </table>
  </form>
</div>
<!--[/if]-->

<!--[include file='footer.tpl']-->