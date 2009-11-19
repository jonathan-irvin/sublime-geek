<?php
include "../backend/config.php";
connect2slm();
$interval   = "24 HOUR";
include 'config.php';
include 'header.php';
?>

<div id="content">
<div class="left"> 
<?php
print("<h2><a href='#'>Daily Top $sel Locations</a></h2><div class='articles'>");
if($topnum > 0){ 
 print("
  <a href='index.php?show=5'>Daily Top 5</a> | 
  <a href='index.php?show=10'>Daily Top 10</a> |    
  <a href='index.php?show=25'>Daily Top 25</a>
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
