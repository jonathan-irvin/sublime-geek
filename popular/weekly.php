<?php
include "../backend/config.php";
connect2slm();
$interval   = "168 HOUR";
include 'config.php';
include 'header.php';
?>

<div id="content">
<div class="left"> 
<?php
print("<h2><a href='#'>Weekly Top $sel Locations</a></h2><div class='articles'>");
if($topnum > 0){ 
 print("
  <a href='weekly.php?show=5'>Weekly Top 5</a> | 
  <a href='weekly.php?show=10'>Weekly Top 10</a> |    
  <a href='weekly.php?show=25'>Weekly Top 25</a>
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
