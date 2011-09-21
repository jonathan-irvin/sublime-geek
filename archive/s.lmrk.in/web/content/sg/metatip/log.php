<?php include "config.php"; ?>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

		<div id="leftside">                
                <?php
				if($log_num != 0){
					print('
					<h1>Transaction History (Last 100 Transactions)</h1>
					<i>Shown below are the last 100 transactions that have flowed through the system.</i>
					<br><br>
					Legend:<br>
					PMT - Normal Payment<br>
					COM - Commission Payment<br>
					USG - Usage Fee (deprecated)<br>
					RFD - System Refund<br>
					MSG - System Message<br>
					<br>
					<table class="trans" style="vertical-align:top">
					  <tr>						
						<th>ID</th>
						<th>Type</th>
						<th>Description</th>
						<th>Amount</th>
						<th>Date / Time (CST)</th>
					  </tr>');
					  
				
					while($logrow = mysql_fetch_array($log_res)){
						$log_trans_id 	= $logrow['transid'];
						$log_type 		= $logrow['pmt_type'];
						$log_amt 		= number_format($logrow['pmt_amt'],2,".",",");
						$log_time 		= $logrow['timestamp'];
						
						$log_to			= $logrow['pmt_to_name'];
						$log_from		= $logrow['pmt_from_name'];
						
						print("<tr>");						
						print("<td><a href='#' title='$log_trans_id'>[i]</a></td>");
						
						if($log_type == "pmt"){
							print("<td>PMT</td>");
							print("<td><b>$log_to</b> made <b>L$$log_amt</b> from <b>$log_from</b> after commissions</td>");
						}else if($log_type == "com"){						
							print("<td>COM</td>");
							print("<td><b>$log_to</b> was paid <b>L$$log_amt</b> from commissions</td>");
						}else if($log_type == "usg"){						
							print("<td>USG</td>");
							print("<td><b>Sublime Geek</b> was paid <b>L$$log_amt</b> for Usage Fees</td>");
						}else if($log_type == "rfd"){						
							print("<td>RFD</td>");
							print("<td>You were refunded <b>L$$log_amt</b> from <b>Sublime Geek</b></td>");
						}else if($log_type == "rmk"){						
							print("<td>MSG</td>");
							print("<td> </td>");
						}
						
						print("<td>L$$log_amt</td>");
						print("<td>$log_time</td>");
						print("</tr>");
					}
				print("</table>");
				}
				?>
                
                
                </div>
                </div>
                </div>

<?php include "footer.php"; ?>