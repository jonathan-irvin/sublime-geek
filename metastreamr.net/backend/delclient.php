<?php

require_once ('./config.php');
connect2slm();

$date = date('Y-m-d G:i:s');
$ownerkey    = $_POST["ownerkey"];
$objectkey    = $_POST["objectkey"];

	$result = mysql_query("SELECT * FROM vgi_games WHERE machine_key='$objectkey' AND owner_key='$ownerkey'");
	$num=mysql_numrows($result);				
	
if($ownerkey != "")
{
	if($num == 1)
	{
		$status=mysql_result($result,0,"status");
		$mfgid = mysql_result($result,0,"mfg_id");
		mysql_free_result($result);
		
		if($status == "Activated")
		{
			$result = mysql_query("SELECT * FROM vgi_mfg_games WHERE mfg_id='$mfgid'");
			$creditcost=mysql_result($result,0,"credit_cost");
			mysql_free_result($result);
			
			$result = mysql_query("SELECT * FROM vgi_users WHERE slkey='$ownerkey'");
			$vgicreditsused=mysql_result($result,0,"vgi_credits_used");
			mysql_free_result($result);
			$vgicreditsused -= $creditcost;
		
			mysql_query("UPDATE vgi_users SET vgi_credits_used='$vgicreditsused' WHERE slkey='$ownerkey'") or die("Unable to delete game\n");
		}
		
		mysql_query("DELETE FROM vgi_games WHERE machine_key='$objectkey' AND owner_key='$ownerkey'") or die("Unable to delete game\n");
		printf("deleted");
	}
	else
	{
		printf("deleted");
	}
}

function delgame($ownerskey,$objectskey)
{
	$result = mysql_query("SELECT * FROM vgi_games WHERE machine_key='$objectskey' AND owner_key='$ownerskey'");
	$num=mysql_numrows($result);				
	
	if($num == 1)
	{
		$status=mysql_result($result,0,"status");
		$mfgid = mysql_result($result,0,"mfg_id");
		$commchan=mysql_result($result,0,"xmlchan");
		mysql_free_result($result);
		
		$commands = "delete";
		$intsend = 0;
		
		if($status == "Activated")
		{
			$result = mysql_query("SELECT * FROM vgi_mfg_games WHERE mfg_id='$mfgid'");
			$creditcost=mysql_result($result,0,"credit_cost");
			mysql_free_result($result);
			
			$result = mysql_query("SELECT * FROM vgi_users WHERE slkey='$ownerskey'");
			$vgicreditsused=mysql_result($result,0,"vgi_credits_used");
			mysql_free_result($result);
			$vgicreditsused -= $creditcost;
		
			mysql_query("UPDATE vgi_users SET vgi_credits_used='$vgicreditsused' WHERE slkey='$ownerskey'") or die("Unable to delete game\n");
		}
		
		mysql_query("UPDATE vgi_games SET status='Deleted' WHERE machine_key='$objectskey' AND owner_key='$ownerskey'") or die("Unable to delete game\n");
    
    print('<script language="Javascript">
      alert ("Please wait 5-10 seconds while your product deletes itself.  Now removing the product from the system.")');      
      sleep(10);
    mysql_query("DELETE FROM vgi_games WHERE machine_key='$objectskey' AND owner_key='$ownerskey'") or die("Unable to delete game\n");
    print('location.replace ("myproducts.php")</script>');
	}
}
?>