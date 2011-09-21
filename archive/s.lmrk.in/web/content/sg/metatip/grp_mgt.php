<?php include "config.php"; ?>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

		<div id="leftside">
                  <hr>
                <div><b>DISCLAIMER - PLEASE READ:</b> <br>Commissions set here are deducted from the base amount of payment.  With no groups or members, by default, 100% will go directly to the employee.  For example, if you have 5 members in Group 1 with a commission of 10%, the receiver of the tip will get 90% of the payment.  <br>The remainder 10% WILL BE DIVIDED EQUALLY BETWEEN ALL MEMBERS IN GROUP 1.  <br><u>We recommend you reserve these groups for members of management or owners only because out of every group, every member will recieve a payment.  <br>Sublime Geek is NOT RESPONSIBLE for lost profits due to incorrectly setting up groups.</u>  <br>If you have any issues or questions, visit http://www.sublimegeek.com/support</div>
                <hr>
                <div align='center'><?php print($message); ?></div><br><br>
                
                <h1>Group Management</h1>
                <table border=0 width=100% style="vertical-align:top">
                  <tr>
                    <td>
                      <?php

                        print("<form action='grp_mgt.php' method='GET'>");
                        if($g_num > 0){//User Has Groups
                          //Group Members
                          $u_sql    = "SELECT * FROM `mtip_gmembers` WHERE `gid` = '$gid'";
                          $u_res    = mysql_query($u_sql);
                          $u_num    = mysql_num_rows($u_res);

                          print("<select name='gid'>");
                          print("<option value=''>...Select Group</option>");
                          while($g_row = mysql_fetch_array($g_res)){
                            $gid        = $g_row['gid'];
                            $gname      = $g_row['gname'];
                            $rate       = $g_row['payout'] * 100;
                            print("<option value=$gid>$gname [$rate%]</option>");
                          }
                          print("
                          </select>
                          <input type=hidden name=auth value=$auth>
                          <input type=hidden name=api  value=$api>
                          <input type=hidden name=ok   value=$ok>
                          <input type=submit value='Select Group'>
                          </form><br>");

                          print("<b>Create a New Group:</b> <br>                          
                          <form action='grp_mgt.php' method='GET'>
                          Group Name:    <input type='text'   name='gname'>
                          Commission %:  <input type='text'   name='payout' size=5>
                          <input type='hidden' name='act' value='addgrp'>                          
                          <input type=hidden name=auth value=$auth>
                          <input type=hidden name=api  value=$api>
                          <input type=hidden name=ok   value=$ok>                          
                          <input type='submit' value='Create Group'>
                          </form>");
                          
                          if( (isset($gid)) && ($gid != "") && ($groupname != "No Selected Group") && (!(isset($act))) ){    
                            if($u_num != 0){
                              print("<br><br>
                              <h1>Member Management for $groupname</h1>                            
                              <table class=stats width=50%>
                                <tr>
                                  <td class=hed><b>Name:</b></td>
                                  <td class=hed><b>Role:</b></td>
                                  <td class=hed><b></b></td>
                                </tr>");
  
                              while($u_row = mysql_fetch_array($u_res)){
                                $uname    = $u_row['name'];
                                $urole    = $u_row['role'];
                                $uid      = $u_row['uid'];
  
                                print("
                                <tr>
                                  <td>$uname</td>
                                  <td>$urole</td>
                                  <td align='center'>
                                  <a href=grp_mgt.php$uadd&act=deluser&uid=$uid&gid=$gid>[DELETE]</a></td>
                                </tr>");
                              }
                              print("</table>");
                              print("                            
                              <br><br>
                              <b>Add some group members:</b> -OR- <a href=grp_mgt.php$uadd&act=delgrp&gid=$gid>[DELETE \"$groupname\" GROUP]</a><br>
                              <form action='grp_mgt.php' method='GET'>
                              SL Name: <input type='text'   name='unm'>
                              Role / Duty: <input type='text'   name='role'>
                              <input type='hidden' name='act' value='adduser'>
                              <input type=hidden name=auth value=$auth>
                              <input type=hidden name=api  value=$api>
                              <input type=hidden name=ok   value=$ok>
                              <input type=hidden name=gid  value=$gid>
                              <input type='submit' value='Add User'>
                              </form>");
                            }else{
                              print("<br><br>
                              <h1>Member Management for $groupname</h1>
                              <br><br>
                              <h3> No Members Detected! <a href=grp_mgt.php$uadd&act=delgrp&gid=$gid>DELETE \"$groupname\"?</a></h3>
                              <br><br>
                              <b>Add some group members:</b><br>
                              <form action='grp_mgt.php' method='GET'>
                              SL Name: <input type='text'   name='unm'>
                              Role / Duty: <input type='text'   name='role'>
                              <input type='hidden' name='act' value='adduser'>
                              <input type=hidden name=auth value=$auth>
                              <input type=hidden name=api  value=$api>
                              <input type=hidden name=ok   value=$ok>
                              <input type=hidden name=gid  value=$gid>
                              <input type='submit' value='Add User'>
                              </form>");
                            }
                          }else{print("<br><br><h1>Please select or create a group</h1>");}
                          
                        }else{
                          print("
                          <b>Create a New Group:</b><br>                          
                          <form action='grp_mgt.php' method='GET'>
                          Group Name:  <input type='text'   name='gname'>
                          Commission %:  <input type='text'   name='payout' size=5>
                          <input type='hidden' name='act' value='addgrp'>
                          <input type=hidden name=auth value=$auth>
                          <input type=hidden name=api  value=$api>
                          <input type=hidden name=ok   value=$ok>
                          <input type='submit' value='Add Group'>
                          </form>");
                        }
                      ?>
                    </td>
                  </tr>
                </table>
                
                </div>
                </div>
                </div>

<?php include "footer.php"; ?>