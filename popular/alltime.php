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
  genRanks($topres);
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
