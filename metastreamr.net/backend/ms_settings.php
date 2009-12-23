<?php
	function list_remotestream()
	{
		require_once ('remotestreamdisplay.php');
    
		$user_name = $_SESSION['session_user'];
		$user_password = $_SESSION['session_password'];
		$user_type = $_SESSION['session_type'];
		$user_id = $_SESSION['session_userID'];
		$sessionresult = mysql_query("SELECT * FROM vgi_users WHERE username='$user_name' AND password='$user_password' AND type='$user_type' AND active='Yes'");
		
    $name=mysql_result($sessionresult,$i,"username");    
    $slkey=mysql_result($sessionresult,$i,"slkey");
    
    $i = 0; 
    
    if(mysql_num_rows($sessionresult) == 0)
			logout();
		else
		{			
			//mysql_free_result($sessionresult);
			
			printf("
					<div class=\"rightcolumn\">
	  				<div class=\"info\">$name's RemoteStream Settings</div>
				  <br>	
          <b>You have Administrator control over the following locations:<br>
			");
      //echo $slkey;
      remotestream($slkey);
      altremotestream($slkey);
      
      printf("</div>");
		}
	}
?>