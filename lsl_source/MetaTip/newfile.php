<?php

include "../backend/config.php"; 
connect2slm();
$interval   = "100 YEAR";

include 'config.php';
include 'header.php'; 

// Require necessary files
require("../lib/AmPieChart.php");

// Alls paths are relative to your base path (normally your php file)
// Path to swfobject.js
AmChart::$swfObjectPath = "swfobject.js";
// Path to AmCharts files (SWF files)
AmChart::$libraryPath = "./ac/source/ampie";
// Path to jquery.js and AmCharts.js (only needed for pie legend)
AmChart::$jsPath = "../lib/AmCharts.js";
AmChart::$jQueryPath = "jquery.js";
AmChart::$loadJQuery = true;

// Tell AmChart to load jQuery if you don't already use it on your site.

// Initialize the chart (the parameter is just a unique id used to handle multiple
// charts on one page.)
$chart = new AmPieChart("sigPie");

// The title we set will be shown above the chart, not in the flash object.
// So you can format it using CSS.
//$chart->setTitle("Percent of people in the world at different poverty levels, 2005");
?>

<div id="content">
<div class="left"> 

<?php
print("<h2><a href='#'>All Time Top $sel Locations</a></h2><div class='articles'>");
if($topnum > 0){ 

  print("
  <a href='alltime.php?show=5'>All Time Top 5</a> | 
  <a href='alltime.php?show=10'>All Time Top 10</a> | 
  <a href='alltime.php?show=20'>All Time Top 20</a> | 
  <a href='alltime.php?show=100'>All Time Top 100</a>
  <!-- <div id='chart_div'></div> -->");  

  if($sel <= 20){  
    
    //Chart Data
    $count;
    while($toprow = mysql_fetch_array($topres)){	 
	  $c_title = ['locname'];
	  $c_total = ['total'];
      $chart->addSlice($count, $c_title, $c_total);
	  $count++;
    }
  }

  else{print("<br><br><div align='center'><b>I'm sorry, the pie chart is not available for selections greater than 20</b></div><br>");}

  

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