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
