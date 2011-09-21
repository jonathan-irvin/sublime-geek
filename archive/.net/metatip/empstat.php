<?php include "config.php"; ?>
<?php include "empstatconfig.php"; ?>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

		<div id="leftside">
             <h1>Choose an employee</h1>
			 <table class="trans" style="vertical-align">
				 <tr>
					<td width=100%>
						<FORM action="empstat.php" method="get">
						<P>
						<select name="selected">
						<OPTION VALUE=''>Choose an employee...</OPTION>
						<?php
							if($elist_num > 0){
								while($eselrow = mysql_fetch_array($elist_res)){
									$ekey  = $eselrow['pmt_to'];
									$ename = $eselrow['pmt_to_name'];
									print("<OPTION VALUE='$ekey'>$ename</OPTION>");
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
				<h1>Employee Transaction Information for </h1>
                <table class="trans" style="vertical-align">
                  <tr>
                    <td colspan=2 align="center" style="vertical-align:top">                    
                    <?php
                      print("<b>Last 24 Hours Average</b><br><br>");
                      if($elast24_num != 0){                        
                        print($elast24->get_Image_String());
                      }else{print("Not enough data yet.  This area will populate with data when the employee has had transactions in the past 24 hours.<br><br><br><br>");}
                    ?>
                    </td>
                    <!--<td>&nbsp;</td>-->
                  </tr>                 
                  
                  <tr>
                    <td align="center" width=50% style="vertical-align:top">                      
                      <?php
                        print("<b>Last 7 Days Transaction History</b><br><br>");
                        if($elast7_num != 0){                          
                          print($elast7->get_Image_String());
                          print("<table class=stats>
                          <tr>
                            <td class=hed>Date:</td>
                            <td class=hed>Total:</td>
                          </tr>");
                          while($el7 = mysql_fetch_array($elast7_res2)){
                            $done  = $el7['date'];
                            $total = number_format($el7['total'],2,".",",");
                            print("<tr><td>$done</td><td>$total L$</td></tr>");
                          }
                          print("</table>");
                        }else{print("Not enough data yet.  This area will populate with data when the employee has had transactions in the past 7 days.");}                      
                        
                      ?>
                        
                    </td>
                    <td align="center" width=50% style="vertical-align:top">                    
                    <?php
                      print("<b>Last 4 Weeks Transaction History</b><br><br>");
                      if($elastmon_num != 0){                        
                        print($elastmon->get_Image_String());
                        print("<table class=stats>
                          <tr>
                            <td class=hed>Week (Start to End):</td>
                            <td class=hed>Total:</td>
                          </tr>");
                        while($elmon = mysql_fetch_array($elastmon_res2)){
                          $dtwo   = $elmon['date'];
                          $total  = number_format($elmon['total'],2,".",",");
                          $sSDate = week_start_date($dtwo, date('Y',time() ) ); 
                          $sEDate = date('d M', strtotime('+6 days', strtotime($sSDate)));
                          print("<tr><td>$sSDate to $sEDate</td><td>$total L$</td></tr>");
                        }
                        print("</table>");
                      }else{print("Not enough data yet.  This area will populate with data when the employee has had transactions in the past 4 weeks.");}                        
                      ?>
                        
                    </td>
                  </tr>
                  <tr>
                    <td align="center" width=50% style="vertical-align:top">                                          
                    <?php
					  print("<b>Last 12 Months Transaction History</b><br><br>");
                      if($elast6mon_num != 0){
                        
                        print($elast6mon->get_Image_String());
                        print("<table class=stats>
                          <tr>
                            <td class=hed>Month:</td>
                            <td class=hed>Total:</td>
                          </tr>");
                        while($el6mon = mysql_fetch_array($elast6mon_res2)){
                          $dthree  = $el6mon['date'];
                          $total = number_format($el6mon['total'],2,".",",");
                          print("<tr><td>$dthree</td><td>$total L$</td></tr>");
                        }
                        print("</table>");
                      }else{print("Not enough data yet.  This area will populate with data when the employee has had transactions in the past 12 months.");}                        
                      ?>
                        
                    </td>
                    <td align="center" width=50% style="vertical-align:top">
                    <?php
                      print("<b>Last 4 Years Transaction History</b><br><br>");
					  if($elast4y_num != 0){
                        
                        print($elast4y->get_Image_String());
                        print("<table class=stats>
                          <tr>
                            <td class=hed>Year:</td>
                            <td class=hed>Total:</td>
                          </tr>");
                        while($el4y = mysql_fetch_array($elast4y_res2)){
                          $dfour  = $el4y['date'];
                          $total = number_format($el4y['total'],2,".",",");
                          print("<tr><td>$dfour</td><td>$total L$</td></tr>");
                        }
                        print("</table>");
                      }else{print("Not enough data yet.  This area will populate with data when the employee has had transactions in the past 4 years.");}
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