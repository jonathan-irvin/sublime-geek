<?php
include "../backend/config.php";
connect2slm();
$interval   = "100 YEAR";
include 'config.php';
include 'header.php';
?>

<div id="content">
<div class="left"> 
<?php
print("<h2><a href='#'>All Time Top $sel Locations</a></h2><div class='articles'>");
if($topnum > 0){ 
 print("
  <a href='alltime.php?show=5'>All Time Top 5</a> | 
  <a href='alltime.php?show=10'>All Time Top 10</a> |    
  <a href='alltime.php?show=25'>All Time Top 25</a>
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
    $type		= $toprow['type'];	
    $tags;
	
	if($rank == 1){$tags = "<a href='$slurl' title='1st Place'><img src='./images/trophy.png'></a>";}
	else if($rank == 2){$tags = "<a href='$slurl' title='2nd Place'><img src='./images/trophy_silver.png'></a>";}
	else if($rank == 3){$tags = "<a href='$slurl' title='3rd Place'><img src='./images/trophy_bronze.png'></a>";}
<<<<<<< HEAD:popular/alltime.php
<<<<<<< HEAD:popular/alltime.php
	else if($rank >= 4){$tags = "";}
=======
	else{$tags}
>>>>>>> metavotr:popular/alltime.php
=======
	else if($rank >= 4){$tags = "";}
>>>>>>> livemark:popular/alltime.php
	if($type == 'PAID'){$tags .= "<a href='$slurl' title='Featured Location'><img src='./images/star_1.png'></a>";}
	
	if($type == "FREE"){
		print("
	    <tr>
	     <td align=center>#$rank</td>
	     <td><a href='$slurl'>$location</a></td> 
	     <td align=center>$simname</td>
		 <td align=center>$tags</td>
	     <td align=center>$total</td>
	     <td align=center>$rating</td>
	    </tr>");
	}else if ($type == "PAID"){
		print("
	    <tr class=\"paid\">
	     <td align=center>#$rank</td>
	     <td><a href='$slurl'>$location</a></td> 
	     <td align=center>$simname</td>
		 <td align=center>$tags</td>
	     <td align=center>$total</td>
	     <td align=center>$rating</td>
	    </tr>");
	}
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