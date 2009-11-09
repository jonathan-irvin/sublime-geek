<?php include "config.php"; ?>
<?php include "vipstatconfig.php"; ?>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

		<div id="leftside">
                <h1>Choose a Patron</h1>
			 <table class="trans" style="vertical-align">
				 <tr>
					<td width=100%>
						<FORM action="vipstat.php" method="get">
						<P>
						<select name="selected">
						<OPTION VALUE=''>Choose a patron...</OPTION>
						<?php
							if($vlist_num > 0){
								while($vselrow = mysql_fetch_array($vlist_res)){
									$vkey  = $vselrow['pmt_from'];
									$vname = $vselrow['pmt_from_name'];
									print("<OPTION VALUE='$vkey'>$vname</OPTION>");
								}
							}
							
						print('
						<INPUT type="hidden" name="api" 	value="'.$api.'">
						<INPUT type="hidden" name="auth" 	value="'.$auth.'">
						<INPUT type="hidden" name="ok" 		value="'.$ok.'">
						');
						?>
						<INPUT type="submit" value="Go">
						</P>
					 </FORM>
					 </td>
				 </tr>
			 </table>
				<br><br>
				<h1>Patron Transaction Information for </h1>
                <table class="trans" style="vertical-align">
                  <tr>
                    <td colspan=2 align="center" style="vertical-align:top">                    
                    <?php
                      print("<b>Last 24 Hours Average</b><br><br>");
                      if($vlast24_num != 0){                        
                        print($vlast24->get_Image_String());
                      }else{print("Not enough data yet.  This area will populate with data when the patron has tipped within the past 24 hours.<br><br><br><br>");}
                    ?>
                    </td>
                    <!--<td>&nbsp;</td>-->
                  </tr>                 
                  
                  <tr>
                    <td align="center" width=50% style="vertical-align:top">                      
                      <?php
                        print("<b>Last 7 Days Transaction History</b><br><br>");
                        if($vlast7_num != 0){                          
                          print($vlast7->get_Image_String());
                          print("<table class=stats>
                          <tr>
                            <td class=hed>Date:</td>
                            <td class=hed>Total:</td>
                          </tr>");
                          while($vl7 = mysql_fetch_array($vlast7_res2)){
                            $done  = $vl7['date'];
                            $total = number_format($vl7['total'],2,".",",");
                            print("<tr><td>$done</td><td>$total L$</td></tr>");
                          }
                          print("</table>");
                        }else{print("Not enough data yet.  This area will populate with data when the patron has tipped within the past 7 days.");}                      
                        
                      ?>
                        
                    </td>
                    <td align="center" width=50% style="vertical-align:top">                    
                    <?php
                      print("<b>Last 4 Weeks Transaction History</b><br><br>");
                      if($vlastmon_num != 0){                        
                        print($vlastmon->get_Image_String());
                        print("<table class=stats>
                          <tr>
                            <td class=hed>Week (Start to End):</td>
                            <td class=hed>Total:</td>
                          </tr>");
                        while($vlmon = mysql_fetch_array($vlastmon_res2)){
                          $dtwo   = $vlmon['date'];
                          $total  = number_format($vlmon['total'],2,".",",");
                          $sSDate = week_start_date($dtwo, date('Y',time() ) ); 
                          $sEDate = date('d M', strtotime('+6 days', strtotime($sSDate)));
                          print("<tr><td>$sSDate to $sEDate</td><td>$total L$</td></tr>");
                        }
                        print("</table>");
                      }else{print("Not enough data yet.  This area will populate with data when the patron has tipped within the past 4 weeks.");}                        
                      ?>
                        
                    </td>
                  </tr>
                  <tr>
                    <td align="center" width=50% style="vertical-align:top">                                          
                    <?php
					  print("<b>Last 12 Months Transaction History</b><br><br>");
                      if($vlast6mon_num != 0){
                        
                        print($vlast6mon->get_Image_String());
                        print("<table class=stats>
                          <tr>
                            <td class=hed>Month:</td>
                            <td class=hed>Total:</td>
                          </tr>");
                        while($vl6mon = mysql_fetch_array($vlast6mon_res2)){
                          $dthree  = $vl6mon['date'];
                          $total = number_format($vl6mon['total'],2,".",",");
                          print("<tr><td>$dthree</td><td>$total L$</td></tr>");
                        }
                        print("</table>");
                      }else{print("Not enough data yet.  This area will populate with data when the patron has tipped within the past 12 months.");}                        
                      ?>
                        
                    </td>
                    <td align="center" width=50% style="vertical-align:top">
                    <?php
                      print("<b>Last 4 Years Transaction History</b><br><br>");
					  if($vlast4y_num != 0){
                        
                        print($vlast4y->get_Image_String());
                        print("<table class=stats>
                          <tr>
                            <td class=hed>Year:</td>
                            <td class=hed>Total:</td>
                          </tr>");
                        while($vl4y = mysql_fetch_array($vlast4y_res2)){
                          $dfour  = $vl4y['date'];
                          $total = number_format($vl4y['total'],2,".",",");
                          print("<tr><td>$dfour</td><td>$total L$</td></tr>");
                        }
                        print("</table>");
                      }else{print("Not enough data yet.  This area will populate with data when the patron has tipped within the past 4 years.");}
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