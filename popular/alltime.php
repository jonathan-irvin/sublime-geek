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
