<?php include "config.php"; ?>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

		<div id="leftside">
                <h1>Transaction Information</h1>
                <table class="trans" style="vertical-align">
                  <tr>
                    <td colspan=2 align="center" style="vertical-align:top">                    
                    <?php
                      print("<b>Last 24 Hours Average</b><br><br>");
                      if($last24_num != 0){                        
                        print($last24->get_Image_String());
                      }else{print("Not enough data yet.  This area will populate with data when you have had transactions in the past 24 hours.<br><br><br><br>");}
                    ?>
                    </td>
                    <!--<td>&nbsp;</td>-->
                  </tr>                 
                  
                  <tr>
                    <td align="center" width=50% style="vertical-align:top">                      
                      <?php
                        print("<b>Last 7 Days Transaction History</b><br><br>");
                        if($last7_num != 0){                          
                          print($last7->get_Image_String());
                          print("<table class=stats>
                          <tr>
                            <td class=hed>Date:</td>
                            <td class=hed>Total:</td>
                          </tr>");
                          while($l7 = mysql_fetch_array($last7_res2)){
                            $done  = $l7['date'];
                            $total = number_format($l7['total'],2,".",",");
                            print("<tr><td>$done</td><td>$total L$</td></tr>");
                          }
                          print("</table>");
                        }else{print("Not enough data yet.  This area will populate with data when you have had transactions in the past 7 days.");}                      
                        
                      ?>
                        
                    </td>
                    <td align="center" width=50% style="vertical-align:top">                    
                    <?php
                      print("<b>Last 4 Weeks Transaction History</b><br><br>");
                      if($lastmon_num != 0){                        
                        print($lastmon->get_Image_String());
                        print("<table class=stats>
                          <tr>
                            <td class=hed>Week (Start to End):</td>
                            <td class=hed>Total:</td>
                          </tr>");
                        while($lmon = mysql_fetch_array($lastmon_res2)){
                          $dtwo   = $lmon['date'];
                          $total  = number_format($lmon['total'],2,".",",");
                          $sSDate = week_start_date($dtwo, date('Y',time() ) ); 
                          $sEDate = date('d M', strtotime('+6 days', strtotime($sSDate)));
                          print("<tr><td>$sSDate to $sEDate</td><td>$total L$</td></tr>");
                        }
                        print("</table>");
                      }else{print("Not enough data yet.  This area will populate with data when you have had transactions in the past 4 weeks.");}                        
                      ?>
                        
                    </td>
                  </tr>
                  <tr>
                    <td align="center" width=50% style="vertical-align:top">                                          
                    <?php
					  print("<b>Last 12 Months Transaction History</b><br><br>");
                      if($last6mon_num != 0){
                        
                        print($last6mon->get_Image_String());
                        print("<table class=stats>
                          <tr>
                            <td class=hed>Month:</td>
                            <td class=hed>Total:</td>
                          </tr>");
                        while($l6mon = mysql_fetch_array($last6mon_res2)){
                          $dthree  = $l6mon['date'];
                          $total = number_format($l6mon['total'],2,".",",");
                          print("<tr><td>$dthree</td><td>$total L$</td></tr>");
                        }
                        print("</table>");
                      }else{print("Not enough data yet.  This area will populate with data when you have had transactions in the past 12 months.");}                        
                      ?>
                        
                    </td>
                    <td align="center" width=50% style="vertical-align:top">
                    <?php
                      print("<b>Last 4 Years Transaction History</b><br><br>");
					  if($last4y_num != 0){
                        
                        print($last4y->get_Image_String());
                        print("<table class=stats>
                          <tr>
                            <td class=hed>Year:</td>
                            <td class=hed>Total:</td>
                          </tr>");
                        while($l4y = mysql_fetch_array($last4y_res2)){
                          $dfour  = $l4y['date'];
                          $total = number_format($l4y['total'],2,".",",");
                          print("<tr><td>$dfour</td><td>$total L$</td></tr>");
                        }
                        print("</table>");
                      }else{print("Not enough data yet.  This area will populate with data when you have had transactions in the past 4 years.");}
                      ?>
                        
                    </td>
                  </tr>
                  <tr>
                    <td colspan=2 align="center" style="vertical-align:top">
                      <i>
                        <b>Note: Normal usage will populate the tables, if empty.</b>
                      </i>
                    </td>
                    <!--<td>&nbsp;</td>-->
                  </tr>
                </table>                
                </div>	
	
<?php include "footer.php"; ?>