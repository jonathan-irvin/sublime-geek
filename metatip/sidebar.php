        
	<div id="main">
		<div id="rightside">
			<h2>Security Information</h2>		
			<!-- GeoTrust QuickSSL [tm] Smart  Icon tag. Do not edit. -->
			<SCRIPT LANGUAGE="JavaScript"  TYPE="text/javascript"  
			SRC="//smarticon.geotrust.com/si.js"></SCRIPT>
			<!-- end  GeoTrust Smart Icon tag -->
							

			<h2>Top 10 Tippers:</h2>
			<div class="box">
                        <ol>
                          <?php
                          if($fromnum > 0){
                            while($fromrow = mysql_fetch_array($fromres)){
                              $name  = $fromrow['name'];
                              $amt   = $fromrow['num'];
                              $total = number_format($fromrow['total'],2,".",",");
                                                            
                              if($name != "System Payment"){print("<li>$name - L$$total</li>");}
                              }
                          }else{print("Not enough data yet :D");}
                          ?>
                        </ol>
                        </div>
                        
                        <h2>Top 10 Employees:</h2>
			<div class="box">
                        <ol>
                          <?php
                          if($tonum > 0){
                            while($torow = mysql_fetch_array($tores)){
                              $name  = $torow['name'];
                              $amt   = $torow['num'];
                              $total = number_format($torow['total'],2,".",",");
                                                            
                              if($name != "System Payment"){print("<li>$name - L$$total </li>");}
                              }
                          }else{print("Not enough data yet :D");}
                          ?>
                        </ol>
                        </div>
                        
                        <h2>My Statistics:</h2>
			<div class="box">
                        <table width=100%>
                        <?php
                        if($ustatnum > 0){
                        print("                          
                          <tr><td>Total Tips</td>       <td>::::: L$$utot</td></tr>
                          <tr><td>Total # Tips</td>     <td>::::: $unum</td></tr>
                          <tr><td>Average Tip</td>      <td>::::: L$$uavg</td></tr>
                          ");
                          }else{print("Not enough data yet :D");}
                        ?>
                        
                        </table>                                               
                        </div>
                        
                        <h2>Quick Help:</h2>
			<div class="box">
                        <b>Why am I seeing numbers less than 1L$?</b><br>
                        <i>To explain it simply, this is because if you 
                        have more than 1 member in a group, especially
                        large groups, one cannot obviously pay a fraction
                        of 1L$, so the system splits it and waits for there
                        to be enough to pay out whole L$.</i><br><br>
                        <b>My last 24 hours history is empty!</b><br>
                        <i>Nothing will show if no transactions 
                        were not made within 24 hours.</i><br><br>
                        <b>My issue is not listed here!</b><br>
                        <i>Click the support link at top :D</i>
                        
                        </div>


                        </div>
        </div>