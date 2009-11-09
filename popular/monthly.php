<?php
include "../backend/config.php";
connect2slm();
$interval   = "1 MONTH";
include 'config.php';
include 'header.php';
?>

<div id="content">
<div class="left"> 
<?php
print("<h2><a href='#'>Monthly Top $sel Locations</a></h2><div class='articles'>");
if($topnum > 0){ 
 print("
  <a href='monthly.php?show=5'>Monthly Top 5</a> | 
  <a href='monthly.php?show=10'>Monthly Top 10</a> |    
  <a href='monthly.php?show=25'>Monthly Top 25</a>
  <!-- <div id='chart_div'></div> -->");  
  if($sel <= 15){
    //Chart Data
    $count = 0;
    while($c_toprow = mysql_fetch_array($c_topres)){	 	  			
		$c_title = escape_string_for_regex($c_toprow['locname']);				
		$c_total = $c_toprow['total'];
		$count2 = $count + 1;
		$chart->addSlice($count, trim($c_title), $c_total );
		$count++;
    }
	print("<div align='center'>");
	print($chart->getCode());
	print("</div>");
  }else{print("<br><br><div align='center'><b>I'm sorry, the pie chart is not available for selections greater than 15</b></div><br>");}
  
  print("<br><div align='center'><i>Note: Some cropping may occur on longer names, <br>please refer to the data below for ranking, votes, and names.<br>Pardon the mess, we are using this page for testing :)</i></div><br>");
  
  print("
  <table width=100%>
   <tr>
    <td align=center><b>Rank:</b>            </td>
    <td ><b>Location:</b>        			 </td>
    <td align=center><b>Sim:</b>             </td>
    <td align=center><b>SL Url:</b>          </td>
    <td align=center><b>Votes:</b>           </td>
    <td align=center><b>Rating:</b>          </td>
   </tr>");
  $rank         = 1;
  while($toprow = mysql_fetch_array($topres)){
    $location   = $toprow['locname'];
    $simname    = $toprow['simname'];
    $slurl      = $toprow['locurl'];
    $total      = $toprow['total'];
    $rating     = number_format(round($toprow['rating'],1),1,'.',',');   
    print("
    <tr>
     <td align=center>#$rank</td>
     <td><a href='$slurl'>$location</a></td> 
     <td align=center>$simname</td> 
     <td align=center><a href=\"$slurl\">Teleport</a></td> 
     <td align=center>$total</td>
     <td align=center>$rating</td>
    </tr>");
    $rank++;
  } 
  print("</table>"); 
}
else{print("I'm sorry, no data is available at this time, go vote for your favorite location!<br><br>");}
include 'b_content.php';
print("</div>");
?>
</div>
<div class="right">
<? include 'sidebar.php'; ?>
</div>
<? include 'footer.php'; ?>
</div>
</div>
</div>
</body>
</html>