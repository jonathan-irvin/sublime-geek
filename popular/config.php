<?php 
$sel = $_GET['show'];
if($sel == ''){$sel = 5;}

//Used to select the top locations
$toploc = "SELECT  
`locname` ,  `simname` ,  `locurl` , 
COUNT( * ) AS  `total` , 
AVG(  `rating` ) as `rating` ,  `type` ,
`timestamp` 
FROM  `mvs_votes` 
WHERE  `timestamp` >= DATE_SUB( CURDATE( ) , INTERVAL $interval ) 
GROUP BY  `locname` , `type`
ORDER BY  `total` DESC , `rating` DESC, `locname` ASC, `type` DESC
LIMIT 0 , $sel";

$topres = mysql_query($toploc);
$topnum = mysql_num_rows($topres);

//Used for chart generation
$c_topres = mysql_query($toploc);
$c_topnum = mysql_num_rows($c_topres);

//Used for chart generation
$c2_topres = mysql_query($toploc);
$c2_topnum = mysql_num_rows($c2_topres);

//Total Votes
$totvotes = "SELECT count(*) as 'total' from `mvs_votes`";
$totres   = mysql_query($totvotes);
$totrow   = mysql_fetch_array($totres);
if($totres){$tv = $totrow['total'];}

//Top Voter
$topvoter = "SELECT DISTINCT 
`voter_name` AS  'voter', COUNT( * ) AS  'total'
FROM  `mvs_votes` 
GROUP BY  `voter_name` 
ORDER BY  `total` DESC";
$tvres   = mysql_query($topvoter);
$tvrow   = mysql_fetch_array($tvres);
if($tvres){$tvr = $tvrow['voter'];}

//Top Location
$toploc = "SELECT DISTINCT 
`locname`, COUNT( * ) AS  'total'
FROM  `mvs_votes` 
GROUP BY  `locname` 
ORDER BY  `total` DESC";
$tlres   = mysql_query($toploc);
$tlrow   = mysql_fetch_array($tlres);
if($tlres)
  {
    $tloc   = $tlrow['locname'];
    $tvotes = $tlrow['total'];
    if($tvotes > 1){$vcount = "votes";}else{$vcount = "vote";}
  } 
  
 ///////////////////////////////////////////////
 //GRIDSPLODE
 //Sessions
 $sessions_sql =  "SELECT * FROM `gsplode_sessions`";
 $sessions_res = mysql_query($sessions_sql); 
 $gs_tp_sql = "SELECT * FROM `gsplode_pay_log` GROUP BY `player_name`";
 $gs_tp_res = mysql_query($gs_tp_sql); 
 $tot_players  = mysql_num_rows($gs_tp_res); 
 $gs_totp_sql = "SELECT SUM(pmt_amt) as 'total' FROM `gsplode_payout_log` WHERE `payee_name` != 'Jon Desmoulins' AND `payee_name` != 'Monkey Canning' ";
 $gs_totp_res = mysql_query($gs_totp_sql); 
 $gs_tot_paid = number_format(mysql_result($gs_totp_res,0,'total'));
 $gs_lck_sql = "SELECT `payee_name` , count( * ) AS total
FROM `gsplode_payout_log`
WHERE `payee_name` != 'Jon Desmoulins'
AND `payee_name` != 'Monkey Canning'
AND `payee_name` != 'Bishop Abbot'
GROUP BY `payee_name`
ORDER BY total DESC";
 $gs_lck_res = mysql_query($gs_lck_sql); 
 $gs_lck_player = mysql_result($gs_lck_res,0,'payee_name'); 
 $gs_wlth_sql = "SELECT `payee_name`,`pmt_amt` as total FROM `gsplode_payout_log` WHERE 
`payee_name` != 'Jon Desmoulins' AND
`payee_name` != 'Monkey Canning' AND
`payee_name` != 'Bishop Abbot'
group by `payee_name`
order by total desc";
 $gs_wlth_res = mysql_query($gs_wlth_sql); 
 $gs_wlth_player = mysql_result($gs_wlth_res,0,'payee_name');
 $gs_wlth_amt = number_format(mysql_result($gs_wlth_res,0,'total'));
 
 
 //FUNCTIONS
 function jsEscape($str) { 
    return addcslashes($str,"\\\'\"\n\r~*"); 
}
 function escape_string_for_regex($str)
{
        //All regex special chars (according to arkani at iol dot pt below):
        // \ ^ . $ | ( ) [ ]
        // * + ? { } ,
        
        $patterns = array('/\//', '/\^/', '/\./', '/\$/', '/\|/',
 '/\(/', '/\)/', '/\[/', '/\]/', '/\*/', '/\+/', 
'/\?/', '/\{/', '/\}/', '/\,/','/\'/');
        $replace = array('\/', '\^', '\.', '\$', '\|', '\(', '\)', 
'\[', '\]', '\*', '\+', '\?', '\{', '\}', '\,');
        
        return preg_replace($patterns,$replace, $str);
}

// Require necessary files
require("./ac/lib/AmPieChart.php");

// Alls paths are relative to your base path (normally your php file)
// Path to swfobject.js
AmChart::$swfObjectPath 	= "./ac/source/swfobject.js";
// Path to AmCharts files (SWF files)
AmChart::$libraryPath 		= "./ac/source/ampie";
// Path to jquery.js and AmCharts.js (only needed for pie legend)
AmChart::$jsPath 			= "./ac/lib/AmCharts.js";
AmChart::$jQueryPath		= "./ac/source/jquery.js";
AmChart::$loadJQuery 		= true;

// Tell AmChart to load jQuery if you don't already use it on your site.

// Initialize the chart (the parameter is just a unique id used to handle multiple
// charts on one page.)
$chart = new AmPieChart("myPieChart");
$chart->setConfig('width', '550');
$chart->setConfig('height', '250');
$chart->setConfig('pie.angle', '30');
$chart->setConfig('pie.height', '12.5');
$chart->setConfig('pie.radius', '35%');
$chart->setConfig('pie.y', '60%');
$chart->setConfig('data_type', 'xml');
$chart->setConfig('background.border_alpha', '15');
$chart->setConfig('legend.enabled', '0');
$chart->setConfig('data_labels.show', '{title}');
$chart->setConfig('data_labels.max_width', '150');
$chart->setConfig('data_labels.radius', '50%');
$chart->setConfig('thousands_separator', ',');
$chart->setConfig('decimals_separator', '.');
$chart->setConfig('animation.start_effect', 'regular');
$chart->setConfig('animation.start_time', '.5');
$chart->setConfig('animation.pull_out_time', '1.5');


function genRanks($tres){  
  print("<br><div align='center'><i>Note: Some cropping may occur on longer names, <br>please refer to the data below for ranking, votes, and names.</i></div><br>");
  
  print("
  <table width=100%>
   <tr>
    <td align=center><b>Rank:</b>            </td>
    <td ><b>Location:</b>        			 </td>
    <td align=center><b>Sim:</b>             </td>
    <td align=center><b>Tags:</b>            </td>
    <td align=center><b>Votes:</b>           </td>
    <td align=center><b>Rating:</b>          </td>
   </tr>");
  $rank         = 1;
  while($toprow = mysql_fetch_array($tres)){
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
	else if($rank >= 4){$tags = "";}
	if($type == 'PAID'){$tags .= "<a href='https://xstreetsl.com/modules.php?name=Marketplace&file=item&ItemID=1943564' title='Featured Location - Get a Premium metaVotr today!'><img src='./images/star_1.png'></a>";}
	
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
?>
