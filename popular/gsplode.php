<? 
include "../backend/config.php"; 
connect2slm();
$interval   = "100 YEAR";
include 'config.php';
include 'header.php'; 

$gs_sql = "SELECT * FROM `gsplode_sessions` WHERE `status` = 'CLOSED' ORDER BY `completed` DESC LIMIT 0,5";
$gs_res = mysql_query($gs_sql);

$gslive_sql = "SELECT * FROM `gsplode_sessions` WHERE `status` = 'OPEN' OR 
`status` = 'FILLED' ORDER BY `gs_type_id` ASC ";
$gslive_res = mysql_query($gslive_sql);
?>

<div id="content">
<div class="left"> 

<?php
print("<h2><a href='#'>Live GridSplode Statistics</a></h2><div class='articles'>");

//Live Plays
print("
<h2>GridSplode Current Tiers</h2>
<i>These are live tier sessions people are playing within Second Life!  Find any GridSplode in-world to join in on the fun!</i><br><br>

<table width=100% border=1>
	<tr>
		<td align=center><b>Tier:</b></td>
		<td><b>Prizes:</b></td>
		<td align=center><b>Needed Entries:</b></td>
        <td align=center><b>Status:</b></td>
	</tr>	
");

while($gslive_row = mysql_fetch_array($gslive_res)){
	$gsl_type     = $gslive_row['gs_type_id'];
	$gsl_status   = $gslive_row['status'];
	$gsl_ent_min  = $gslive_row['ent_min'];
	$gsl_ent_total= $gslive_row['ent_total'];
	$gsl_winners  = $gslive_row['winners'];
	$gsl_created  = $gslive_row['created'];
	$gsl_completed= $gslive_row['completed'];
    $gsl_surplus  = $gslive_row['bal_surplus'];
    
    $tier_sql       = "SELECT * FROM `gsplode_splode_config` WHERE `id` = '$gsl_type'";
    $tier_res       = mysql_query($tier_sql) or die();
    $tier_row       = mysql_fetch_object($tier_res);
    $tier_num       = mysql_num_rows($tier_res);

    if($tier_num == 1){
        //Let's build all the info for the current tier we are using	
        $tier_id         = $tier_row->id;
        $tier_name       = strtoupper($tier_row->name);
        $tier_min_pay    = $tier_row->min_pay;
        $tier_usr_comm   = $tier_row->usr_comm;
        $tier_min_entries= $tier_row->min_entries;
        $tier_p_one 	 = $tier_row->p_one;
        $tier_p_two 	 = $tier_row->p_two;
        $tier_p_three 	 = $tier_row->p_three;
    }
    
    $p1_mod			 = floor($gsl_surplus * 0.10);
    $p2_mod			 = floor($gsl_surplus * 0.15);
    $p3_mod			 = floor($gsl_surplus * 0.25);
    $adm_mod		 = floor($gsl_surplus * 0.50);
    
    $p_three      	 = number_format($tier_p_one   + $p1_mod);
    $p_two      	 = number_format($tier_p_two   + $p2_mod);
    $p_one      	 = number_format($tier_p_three + $p3_mod);    
    
    $gsl_needed   = $gsl_ent_min - $gsl_ent_total;
    
    if($gsl_status == "OPEN")  {$status = "ACTIVE";}
    if($gsl_status == "FILLED"){$status = "///SPLODE IMMINENT///";}
	
	if($gsl_type == 1){$tier = "BRONZE";}
	if($gsl_type == 2){$tier = "SILVER";}
	if($gsl_type == 3){$tier = "GOLD";}
	if($gsl_type == 4){$tier = "PLATINUM";}	
	
	print("
		<tr>
			<td align=center><b>$tier</b></td>
			<td>
                1st Place: L$$p_one<br>
                2nd Place: L$$p_two<br>
                3rd Place: L$$p_three<br>
			</td>
			<td align=center>$gsl_needed</td>
            <td align=center><b>$status</b></td>            
		</tr>
	");
}

print("</table>");

//Hall of Win
print("
<br><br><h2>GridSplode Hall of Win</h2>
<i>Congratulations to the winners from our previous splodes!<br>
Shown below is the previous 5 splodes<br>
Note: It is possible to win more than one prize, especially if you pay in more than once!</i><br><br>

<table width=100% border=1>
	<tr>
		<td align=center><b>Tier:</b></td>
		<td><b>Winners</b></td>
		<td align=center><b>Time Sploded (GMT -6):</b></td>
	</tr>	
");

while($gs_row = mysql_fetch_array($gs_res)){
	$gs_type     = $gs_row['gs_type_id'];
	$gs_status   = $gs_row['status'];
	$gs_ent_min  = $gs_row['ent_min'];
	$gs_ent_total= $gs_row['ent_total'];
	$gs_winners  = $gs_row['winners'];
	$gs_created  = $gs_row['created'];
	$gs_completed= $gs_row['completed'];
	
	if($gs_type == 1){$tier = "BRONZE";}
	if($gs_type == 2){$tier = "SILVER";}
	if($gs_type == 3){$tier = "GOLD";}
	if($gs_type == 4){$tier = "PLATINUM";}
	
	$w_array = explode("::",$gs_winners);
	$w1_array= explode(",",$w_array[0]);
	$w2_array= explode(",",$w_array[1]);
	$w3_array= explode(",",$w_array[2]);
	
	print("
		<tr>
			<td align=center><b>$tier</b></td>
			<td>
				<u>$w3_array[0]</u> - <b>L$$w3_array[2]</b><br>
				<u>$w2_array[0]</u> - <b>L$$w2_array[2]</b><br>
				<u>$w1_array[0]</u> - <b>L$$w1_array[2]</b><br>
			</td>
			<td align=center>$gs_completed</td>
		</tr>
	");
}

print("</table>");

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

</body>
</html>