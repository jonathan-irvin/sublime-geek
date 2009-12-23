<?php



function remotestream ($userkey)
{
connect2slm();
$fontsize = '-1';
//mysql_connect("localhost", "codeman615", "Jurb1f!ed") or die(mysql_error());
//mysql_select_db("codeman615_vend") or die(mysql_error());
//echo "This is the SL Key: ".$slkey;
// Get all the data from the "example" table
$result = mysql_query("SELECT * FROM istream WHERE owner_key = '$userkey' ORDER BY id ASC") 
or die(mysql_error());
$num = mysql_num_rows($result);
if($num > 0)
{
echo "<fieldset>";
echo "<legend><b>Admin Control Panel</b></legend><br>";
echo "<b>You have Administrator control over the following locations:</b><br><table border='0' bordercolor=\"#000000\">";
echo "<tr bgcolor=\"#FFFFFF\" > <td align='center'><font size='$fontsize'>ID#</td></font> <td align='center'><font size='$fontsize'>Sim Name</td></font> <td align='center'><font size='$fontsize'>Location</td></font> <td align='center'><font size='$fontsize'>Radio Name</td></font> <td align='center'><font size='$fontsize'>Radio URL</td></font> <td align='center'><font size='$fontsize'>Video Name</td></font> <td align='center'><font size='$fontsize'>Video URL</td></font> <td align='center'><font size='$fontsize'>Allow Access To</td></font> <td align='center'><font size='$fontsize'>Update</td></font></tr></font>";
// keeps getting the next row until there are no more to get
while($row = mysql_fetch_array( $result )) {
	// Print out the contents of each row into a table
$slurl = $row['slurl'];
$radname = $row['radname'];
$radurl = $row['radurl'];
$vidname = $row['vidname'];
$vidurl = $row['vidurl'];
$cliadmin = $row['cli_admin'];

$locationurl = "<a href='$slurl' target='_blank' title='Click Here To Visit This Product'>Teleport</a>";
$options = mysql_query("SELECT * FROM istream_cliadminlist WHERE userkey = '$userkey' AND clientkey = '$cliadmin'") or die(mysql_error());
$options2 = mysql_query("SELECT * FROM istream_cliadminlist WHERE userkey = '$userkey' AND clientkey != '$cliadmin'") or die(mysql_error());
echo "<FORM ACTION='./ssl/php/remotestreamupdate.php' METHOD='post'> ";


echo "<tr><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>"; 
echo $row['id']." ";	
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo $row['simname']." ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo $locationurl." ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"radname\" VALUE='$radname' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"radurl\" VALUE='$radurl' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"vidname\" VALUE='$vidname' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"vidurl\" VALUE='$vidurl' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<select name='cliadmin'>";
$clientadmin = mysql_fetch_array($options);
if ($cliadmin == $clientadmin['clientkey']) 
{ 
  echo '<option value=" ">No One</option><option value="'.$cliadmin.'" selected value="selected">Current User: '.$clientadmin['clientname'].'</option>';   
}
else if ($cliadmin == ' ') 
{ 
  echo '<option value=" " selected value="selected">Current User: No One</option>'; 
}
else
{
  echo "<option value=' '>No One</option>
  <option value='$cliadmin' selected value='selected'>Current User: Set From Server</option>";
} 
while ($c = mysql_fetch_array($options2)) 
  { 
    $clientname = $c['clientname'];
    $clientkey = $c['clientkey'];
    echo "<option value='$clientkey'>$clientname</option>";
  }
echo "</select>";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"hidden\" NAME=\"id\" value=".$row['id'].">
<INPUT TYPE=\"hidden\" NAME=\"userkey\" value=".$userkey.">
<INPUT TYPE=\"image\" NAME=\"Submit\" title=\"Update\" src=\"./back-forth.gif\"> "; 
echo "</td></tr>";
echo "</form>";
}
echo "</table></fieldset>";
}
else
{
echo "<br><br><fieldset>";
echo "<legend><b>Admin Control Panel</b></legend><br>";
echo "<b>You do not currently have Admin control over any locations...</b></fieldset><br>";
}
}


// Make a MySQL Connection
function altremotestream ($userkey)
{
connect2slm();
$fontsize = '-1';
//mysql_connect("localhost", "codeman615", "Jurb1f!ed") or die(mysql_error());
//mysql_select_db("codeman615_vend") or die(mysql_error());
//echo "This is the SL Key: ".$slkey;
// Get all the data from the "example" table
$result = mysql_query("SELECT * FROM istream WHERE cli_admin = '$userkey' ORDER BY id ASC") 
or die(mysql_error());  
$num = mysql_num_rows($result);
if($num > 0)
{
echo "<br><br><fieldset>";
echo "<legend><b>Client Control Panel</b></legend><br>";
echo "<b>You have Client control over the following locations:</b><table border='0' bordercolor=\"#000000\">";
echo "<tr bgcolor=\"#FFFFFF\" > <td align='center'><font size='$fontsize'>ID#</td></font> <td align='center'><font size='$fontsize'>Sim Name</td></font> <td align='center'><font size='$fontsize'>Location</td></font> <td align='center'><font size='$fontsize'>Radio Name</td></font> <td align='center'><font size='$fontsize'>Radio URL</td></font> <td align='center'><font size='$fontsize'>Video Name</td></font> <td align='center'><font size='$fontsize'>Video URL</td></font> <td align='center'><font size='$fontsize'>Update</td></font></tr>";
// keeps getting the next row until there are no more to get
while($row = mysql_fetch_array( $result )) {
	// Print out the contents of each row into a table
$slurl = $row['slurl'];
$radname = $row['radname'];
$radurl = $row['radurl'];
$vidname = $row['vidname'];
$vidurl = $row['vidurl'];
$cliadmin = $row['cli_admin'];
$owner = $row['owner_key'];

$locationurl = "<a href='$slurl' target='_blank' title='Click Here To Visit This Product'>Teleport</a>";

echo "<FORM ACTION='./ssl/php/remotestreamupdate.php' METHOD='post'> ";


echo "<tr><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>"; 
echo $row['id']." ";	
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo $row['simname']." ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo $locationurl." ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"radname\" VALUE='$radname' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"radurl\" VALUE='$radurl' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"vidname\" VALUE='$vidname' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"vidurl\" VALUE='$vidurl' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"hidden\" NAME=\"id\" value=".$row['id'].">
<INPUT TYPE=\"hidden\" NAME=\"userkey\" value=".$owner.">
<INPUT TYPE=\"hidden\" NAME=\"cliadmin\" value=".$cliadmin.">
<INPUT TYPE=\"image\" NAME=\"Submit\" title=\"Update\" src=\"./back-forth.gif\"> ";  
  
echo "</td></tr>";
echo "</form>";
} 
echo "</table></fieldset><br><br>";
}
else
{
echo "<br><br><fieldset>";
echo "<legend><b>Client Control Panel</b></legend><br>";
echo "You do not currently have Client control over any locations...</fieldset><br><br>";
}
}

function rsupdateall ($userkey)
{
connect2slm();
$fontsize = '-1';
//mysql_connect("localhost", "codeman615", "Jurb1f!ed") or die(mysql_error());
//mysql_select_db("codeman615_vend") or die(mysql_error());
//echo "This is the SL Key: ".$slkey;
// Get all the data from the "example" table

echo "<fieldset>";
echo "<legend><b>Update All Locations With These Settings:</b></legend><br>";
echo "<table border='0' bordercolor=\"#000000\">";
echo "<tr bgcolor=\"#FFFFFF\" > <td align='center'><font size='$fontsize'>Radio Name</td></font> <td align='center'><font size='$fontsize'>Radio URL</td></font> <td align='center'><font size='$fontsize'>Video Name</td></font> <td align='center'><font size='$fontsize'>Video URL</td></font> <td align='center'><font size='$fontsize'>Allow Access To</td></font> <td align='center'><font size='$fontsize'>Update</td></font></tr></font>";
// keeps getting the next row until there are no more to get
//while($row = mysql_fetch_array( $result )) {
	// Print out the contents of each row into a table
//$locationurl = "<a href='$slurl' target='_blank' title='Click Here To Visit This Product'>Teleport</a>";
$sql = "SELECT * FROM istream_cliadminlist WHERE userkey = '$userkey' ORDER BY clientname";
$options = mysql_query($sql) or die(mysql_error());
//echo $sql;
echo "<FORM ACTION='./ssl/php/rsupdateall.php' METHOD='post'> ";
echo "<tr>";
echo "<td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"radname\" VALUE='' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"radurl\" VALUE='' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"vidname\" VALUE='' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"text\" NAME=\"vidurl\" VALUE='' SIZE=10 MAXLENGTH=255> ";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<select name='cliadmin'><option value=' '>...Select</option>";
while ($c = mysql_fetch_array($options)) 
{ 
  $clientname = $c['clientname'];
  $clientkey = $c['clientkey'];
  echo "<option value='$clientkey'>$clientname</option>";
}
echo "</select>";
echo "</td><td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
echo "<INPUT TYPE=\"hidden\" NAME=\"userkey\" VALUE='$userkey'> ";  
echo "<INPUT TYPE=\"image\" NAME=\"Submit\" title=\"Update All\" src=\"./grow.gif\"> ";  
echo "</td></tr>";
echo "</form>";
echo "</table></fieldset><br><br>";
}

function admin_maint ($userkey)
{
  connect2slm();
  $fontsize = '-1';
  //mysql_connect("localhost", "codeman615", "Jurb1f!ed") or die(mysql_error());
  //mysql_select_db("codeman615_vend") or die(mysql_error());
  //echo "This is the SL Key: ".$slkey;
  // Get all the data from the "example" table
  // keeps getting the next row until there are no more to get
  $options = mysql_query("SELECT * FROM istream_cliadminlist WHERE userkey = '$userkey' ORDER BY clientname") or die(mysql_error());
  $num = mysql_num_rows($options);
  
  if ($num > 0)
  {

    echo "<fieldset>";
    echo "<legend><b>Administrator List</b></legend><br>";
    echo "<table border='0' bordercolor=\"#000000\">";
    echo "<tr bgcolor=\"#FFFFFF\" > <td></td> <td></td> </tr></font>";

    while($row = mysql_fetch_array( $options )) 
    {
      $clientname = $row['clientname'];
      $clientkey = $row['clientkey'];
      $clientid = $row['id'];
      echo "<FORM ACTION='./remotestream/deleteadmin.php' METHOD='post'> ";
      echo "<tr>";
      echo "<td bgcolor=\"#FFFFFF\" background=\"/php/images/dkbluecell501.jpg\" align=\"center\"><font color=\"black\" size='1'>";
      echo $clientname;
      echo "</td>";
      echo "<td><INPUT TYPE=\"hidden\" NAME=\"cli_id\" VALUE='$clientid'>";
      echo "<INPUT TYPE=\"hidden\" NAME=\"userkey\" VALUE='$userkey'> ";
      echo "<INPUT TYPE=\"hidden\" NAME=\"cliadmin\" VALUE='$clientname'> ";
      echo "<INPUT TYPE=\"image\" NAME=\"Submit\" title=\"Delete\" src=\"./skull.gif\"> ";  
      echo "</td></tr>";
      echo "</form>";      
    }
    echo "</table><br><br>";
  }

  else
  {
    echo "<fieldset>";
    echo "<legend><b>Administrator List</b></legend><br>";
    echo "You currently don't have any listed administrators. You can add them by adding their name below.<br><br>";
  }
print('<table border="0" bordercolor="#000000">
<form action="./remotestream/updateadmin.php" method="POST">
<tr bgcolor="#FFFFFF" > <td align="center"><font size="'.$fontsize.'">Administrator Name</td></font> <td></td></tr></font>
<tr><td><input type="text" name="cliadmin" size=20></td> <td><input type="hidden" name="userkey" value='.$userkey.'><input type="Submit" name="Submit" value="Add"></td></tr>
</table></fieldset><br><br>');

  
}

?>