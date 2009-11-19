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
  genRanks();
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
