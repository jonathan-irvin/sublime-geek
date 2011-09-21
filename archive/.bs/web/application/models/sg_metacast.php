<?php

class SG_metacast extends CI_Model {
    
	//SL Headers Info
	var $headers        ;
	var $objectName     ;
	var $objectKey      ;
	var $ownerKey       ;
	var $ownerName      ;
	var $region         ;
	
	var $apiurl			;
	var $xmlpayload		;
	var $adminpass		;
	
	var $listeners		;
	var $stream_title	;
	var $currentsong	;
	var $bitrate		;
	var $servertype		;
	var $email			;
	var $template		;
	
    function __construct()    {
        parent::__construct();
		$this->load->helper('date');
		
        
        //Set Headers
		$this->headers			= $this->sg_backend->emu_getallheaders();
		$this->objectName     	= $this->headers["X-SecondLife-Object-Name"];
		$this->objectKey      	= $this->headers["X-SecondLife-Object-Key"];
		$this->ownerKey       	= $this->headers["X-SecondLife-Owner-Key"];
		$this->ownerName      	= $this->headers["X-SecondLife-Owner-Name"];
		$this->region         	= $this->headers["X-SecondLife-Region"];
		
		//$this->apiurl			= "http://10.177.35.245/api.php";  //Pass all API requests through private pipe
		$this->apiurl			= "http://metacast.sublimegeek.com/api.php";  //Pass all API requests through private pipe
		$this->adminpass		= "Jurb1f!ed";
    }
    
	function sendRequest()	{
		/* Initialize handle and set options */
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $this->apiurl); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 4); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->xmlpayload); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close'));
		
		/* Execute the request and also time the transaction */
		$start = array_sum(explode(' ', microtime()));
		$result = curl_exec($ch); 
		$stop = array_sum(explode(' ', microtime()));
		$totalTime = $stop - $start;
		
		/* Check for errors */
		if ( curl_errno($ch) ) {
			$result = 'ERROR -> ' . curl_errno($ch) . ': ' . curl_error($ch);
		} else {
			$returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
			switch($returnCode){
				case 404:
					$result = 'ERROR -> 404 Not Found';
					break;
				default:
					break;
			}
		}
		
		/* Close the handle */
		curl_close($ch);
		
		/* Output the results and time */
		//echo 'Total time for request: ' . $totalTime . "\n";		   
		
		$this->load->library('simplexml');
		$xmlData = $this->simplexml->xml_parse($result);
		
		return $xmlData;		
	}
	
	function newacct($affecteduser,$afftpassword,$email,$template,$duration){
		//Begin Existing/New Account Check
		$this->db->select('*');
		$this->db->from('sg_accounts');
		$this->db->where(array('key' => $this->ownerKey));
		
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		
		if($template == "ShoutCastBasic10")	{$mc_template = "SHOUTCAST-10";}
		if($template == "ShoutCastBasic25")	{$mc_template = "SHOUTCAST-25";}
		if($template == "ShoutCastBasic75")	{$mc_template = "SHOUTCAST-75";}
		if($template == "IceCastBasic10")	{$mc_template = "ICECAST-10";}
		if($template == "IceCastBasic25")	{$mc_template = "ICECAST-25";}
		if($template == "IceCastBasic75")	{$mc_template = "ICECAST-75";}
		if($template == "Enterprise100")	{$mc_template = "ENTERPRISE-100";}
		if($template == "Enterprise250")	{$mc_template = "ENTERPRISE-250";}
		if($template == "Enterprise750")	{$mc_template = "ENTERPRISE-750";}
		
		if($db_row['mc_user'] == ""){		
			$usr_array = explode(" ",$this->ownerName);		
			$newpass   = $this->sg_backend->mc_genPass();
			$newuser   = strtolower($usr_array[0].$usr_array[1]);
			
			$this->db->where('key',$this->ownerKey);
			
			$exptime = date ("Y-m-d H:i:s", (time() + 2629743));
			
			$this->db->update('sg_accounts', array('mc_active'=>'ACTIVE', 'mc_user'=>$newuser, 'mc_package' => $mc_template,'mc_exp' => $exptime ));
			//echo $this->db->last_query();
			
			//$email = $newpass."test@sublimegeek.com";		
			
			$this->provision($newuser,$newpass,$email,$template);
			
			$this->sg_backend->account_log($db_row['name'],$db_row['key'],'PROVISION','Your MetaCast Cloud account has been created: '.$newuser);
			$this->sg_backend->account_log($db_row['name'],$db_row['key'],'INFO','You subscribed to the MetaCast Cloud '.$mc_template.' package.');
			$this->sg_backend->account_log($db_row['name'],$db_row['key'],'INFO','Your MetaCast Cloud account is set to expire on '.unix_to_human(gmt_to_local((time() + 2629743),"UM8",FALSE),TRUE,'us').' SLT');
		}else{
			//print_r($db_row);
			print("provision|error|User's account ".$db_row['mc_user']." already exists");
		}
	}
	
	function acctstatus($affecteduser,$afftpassword){
		//Begin Existing/New Account Check
		$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
		$this->db->from('sg_accounts');
		$this->db->where(array('key' => $this->ownerKey));
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		
		if($db_row['mc_user'] != ""){
			$bandwidth 	= $this->getaccount($affecteduser,$afftpassword,'bandwidth',FALSE);
			$disk 		= $this->getaccount($affecteduser,$afftpassword,'disk',FALSE);
			
			print("acctstatus|success|Your current package is ".$db_row['mc_package']."GB|Your account expires ".unix_to_human(gmt_to_local($db_row['exp'],"UM8",FALSE),TRUE,'us')." SLT|".$bandwidth."|".$disk);
			$this->sg_backend->account_log($db_row['name'],$db_row['key'],'INFO','You checked the status of your MetaCast Cloud Account');
		}else{
			print("acctstatus|error|Unable to find account status of $affecteduser. No user exists by that name");
		}		
	}
	
	function mc_admacctcheck(){
		//Begin Existing/New Account Check
		$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
		$this->db->from('sg_accounts');
		$this->db->where(
			array(
				'mc_exp <='  => date ("Y-m-d H:i:s", time()),
				'mc_user !=' => '',
				'mc_active !=' => 'INACTIVE'
			)
		);
		$db_res = $this->db->get();				
		
		if ($db_res->num_rows() > 0){
			foreach ($db_res->result() as $row){
				if($row->mc_user != ''){
					//Check the expiry time
					if($row->exp <= time()){
						//Account is Expired, Disable them
						$this->db->where(array('key' => $row->key));
						$this->db->update('sg_accounts', array('mc_active'=>'INACTIVE'));
						
						//Disable their MetaCast Account
						$this->setstatus($row->mc_user,$this->adminpass,'disabled');
						$this->sg_backend->account_log($row->name,$row->key,'INFO','Your MetaCast Cloud Account was disabled due to non-payment.');
						
						//Delete their MetaCast Account after 60 Days
						if($row->exp <= (time() - (2629743 * 2))){
							$this->terminate($row->mc_user,$this->adminpass,FALSE);
							$this->sg_backend->account_log($row->name,$row->key,'INFO','Your MetaCast Cloud Account was automatically deleted after 60 days.');
						}
					}
				}else if($row->mc_active == 'INACTIVE'){
					//Disable their MetaCast Account
					$this->setstatus($row->mc_user,$this->adminpass,'disabled');
					
					//Delete their MetaCast Account after 60 Days
					if($row->exp <= (time() - (2629743 * 2))){
						$this->terminate($row->mc_user,$this->adminpass,FALSE);
						$this->sg_backend->account_log($row->name,$row->key,'INFO','Your MetaCast Cloud Account was automatically deleted after 60 days.');
					}
				}
			}
		}		
	}
	
	function svrinfo($affecteduser){
		//Begin Existing/New Account Check
		$this->db->select('
			`sg_accounts`.`id`,
			`sg_accounts`.`name`,
			`sg_accounts`.`key`,
			`sg_accounts`.`api_key`,
			`sg_accounts`.`mc_user`,
			`sg_mc_pkgconfig`.`package`,
			`sg_mc_pkgconfig`.`price`,
			`sg_accounts`.`mc_exp`,
			`sg_accounts`.`updated`,
			UNIX_TIMESTAMP(`mc_exp`) AS \'exp\'');
		$this->db->from('sg_accounts');		
		$this->db->where(array('key' => $this->ownerKey));
		$this->db->join('sg_mc_pkgconfig','sg_mc_pkgconfig.package = sg_accounts.mc_package','INNER');
		
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		
		//print_r($db_row);
		
		if($db_row['mc_user'] != ""){
			print("svrinfo|success|".$db_row['package']."|".$db_row['price']."|".unix_to_human(gmt_to_local($db_row['exp'],"UM8",FALSE),TRUE,'us')." SLT");
		}else{
			print("svrinfo|error|Unable to find account status of $affecteduser. No user exists by that name");
		}
	}
	
	function renew($affecteduser,$duration){
		//Begin Existing/New Account Check
		$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
		$this->db->from('sg_accounts');		
		$this->db->where(array('key' => $this->ownerKey));		
		
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		
		//print_r($db_row);
		
		if(isset($duration)){
		
			if($db_row['exp'] <= time()){
				$existingtime = time();
			}else{
				$existingtime = $db_row['exp'];
			}
		
			if($duration == "month")	{$futuretime = $existingtime +  2629743;	 		}
			if($duration == "quarter")	{$futuretime = $existingtime + (2629743  * 3);		}
			if($duration == "halfyear")	{$futuretime = $existingtime + (31556926 / 2);		}
			if($duration == "year")		{$futuretime = $existingtime +  31556926;			}
		
			$this->db->set('mc_exp',date ("Y-m-d H:i:s", $futuretime));
			$this->db->set('mc_active','ACTIVE');			
			$this->db->where(array('key' => $this->ownerKey));
			$this->db->update('sg_accounts');
			
			//Make sure account is enabled
			$this->setstatus($affecteduser,'admin|Jurb1f!ed','enabled');
			$this->start($affecteduser,'admin|Jurb1f!ed',FALSE);
			
			if($db_row['mc_user'] != ""){
				print("renew|success|Your account will now expire on ".unix_to_human(gmt_to_local($futuretime,"UM8",FALSE),TRUE,'us')." SLT");
				$this->sg_backend->account_log($db_row['name'],$db_row['key'],'RENEWAL','Your MetaCast Cloud Account was renewed to '.unix_to_human(gmt_to_local($futuretime,'UM8',FALSE),TRUE,'us').' SLT');
			}else{
				print("svrinfo|error|Unable to renew $affecteduser. No user exists by that name");
			}
			
		}		
	}
	
	function upgrade($affecteduser,$afftpassword,$package){
		//Begin Existing/New Account Check
		$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
		$this->db->from('sg_accounts');
		$this->db->where(array('key' => $this->ownerKey));
		
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		
		if($package != ""){
			if($db_row['mc_user'] != ""){
				if($package == "25GB"){
					if($this->reconfigure($affecteduser,$afftpassword,'transferlimit',25000) == "success"){
						print("upgrade|success|Account upgraded to $package");
						$this->sg_backend->account_log($db_row['name'],$db_row['key'],'UPGRADE','Your MetaCast Cloud Account was upgraded to '.$package);
					}
				}else if($package == "75GB"){
					if($this->reconfigure($affecteduser,$afftpassword,'transferlimit',75000) == "success"){
						print("upgrade|success|Account upgraded to $package");
						$this->sg_backend->account_log($db_row['name'],$db_row['key'],'UPGRADE','Your MetaCast Cloud Account was upgraded to '.$package);
					}
				}
			}else{
				print("upgrade|error|Unable to upgrade $affecteduser. No user exists by that name.  Select NewAcct instead");
			}
		}else{
			if($db_row['mc_user'] != ""){
				$transferlimit = $this->getaccount($affecteduser,$afftpassword,'acctxfer','FALSE');
				$upgpacks;
				
				if($transferlimit == 10000){
					$upgpacks = "1125|4875|Reseller";
					print("upgradechoices|success|".$upgpacks);
				}else if($transferlimit == 25000){
					$upgpacks = "3750|Reseller";
					print("upgradechoices|success|".$upgpacks);
				}else if($transferlimit == 75000){
					$upgpacks = "Reseller";
					print("upgradechoices|success|".$upgpacks);
				}else if($transferlimit == "UNLIMITED"){
					print("upgradechoices|error|Unable to upgrade, your package is unlimited");
				}
			}
		}
	}
	
	function downgrade($affecteduser,$afftpassword){
		//Begin Existing/New Account Check
		$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
		$this->db->from('sg_accounts');
		$this->db->where(array('key' => $this->ownerKey));
		
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		
		/*
		if($package != ""){
			if($db_row['mc_user'] != ""){
				if($package == "10GB"){
					if($this->reconfigure($affecteduser,$afftpassword,'transferlimit',10000) == "success"){
						print("downgrade|success|Account downgraded to $package");
					}
				}else if($package == "25GB"){
					if($this->reconfigure($affecteduser,$afftpassword,'transferlimit',25000) == "success"){
						print("downgrade|success|Account downgraded to $package");
					}
				}
			}else{
				print("upgrade|error|Unable to downgrade $affecteduser. No user exists by that name.  Select NewAcct instead");
			}
		}else{
			if($db_row['mc_user'] != ""){
				$transferlimit = $this->getaccount($affecteduser,$afftpassword,'acctxfer','FALSE');
				$transferusage = $this->getaccount($affecteduser,$afftpassword,'acctxferusage','FALSE');
				$upgpacks;
				
				
				if($transferlimit == 10000){					
					print("downgradechoices|error|Unable to downgrade, your at the lowest package.");
				}else if($transferlimit == 25000){
					if($transferusage >= 10000){
						print("downgradechoices|error|Unable to downgrade, your usage is higher than the lowest package.");
					}else{
						$upgpacks = "3750|Reseller";
						print("downgradechoices|success|".$upgpacks);
					}					
				}else if($transferlimit == 75000){
					$upgpacks = "Reseller";
					print("downgradechoices|success|".$upgpacks);
				}else if($transferlimit == "UNLIMITED"){
					print("downgradechoices|error|Unable to downgrade, your package is unlimited");
				}				
			}
		}
		*/
		
		print("downgradechoices|error|Unable to downgrade, please create a ticket at http://support.sublimegeek.com");
	}
	
    function status($affecteduser,$afftpassword)	{
		/** 
		 * Define POST URL and also payload
		 */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="system" method="info">
						<password>'.$this->adminpass.'</password>
						<username>'.$affecteduser.'</username>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		$server;
		$stream;
		
		$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
		$this->db->from('sg_accounts');		
		$this->db->where(array('mc_user' => $affecteduser));
		
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		
		if($db_res->num_rows() > 0){
			if($db_row['exp'] >= time()){
				if(
					isset($response['response']['data']['row']['field']['1']['@content'])&&
					isset($response['response']['data']['row']['field']['3']['@content'])
				){		
					$server = "Your server is ".$response['response']['data']['row']['field']['1']['@content'];			
					$stream = "Your broadcast is ".$response['response']['data']['row']['field']['3']['@content'];
				}else{
					$server = "Your server is down";
					$stream = "Your broadcast is down";
				}
				
				if(!$this->streamstatus($affecteduser,$afftpassword,FALSE)){
					$streaminfo = " ";
				}else{
					$streaminfo = 	$this->listeners		."|".
									$this->stream_title		."|".
									$this->currentsong		."|".
									$this->bitrate			."|".
									$this->servertype		."|";
				}							
				
				if($response['response']['@attributes']['type'] == 'success'){
					$result = $response['response']['@attributes']['type'];
				}else{$result = "failure";}
				
				if(isset($response['response']['data']['row']['field']['0']['@content'])){
					$username = $response['response']['data']['row']['field']['0']['@content'];
				}else{$username = "Not Available";}
				
				$pushto_sl = "status|".$result."|".$affecteduser."|".$server."|".$stream."|".$streaminfo;
			}else{
				$pushto_sl = "status|success|".$affecteduser."|Your account is disabled|Your account expired on ".unix_to_human(gmt_to_local($db_row['exp'],"UM8",FALSE),TRUE,'us');
			}			
		}else{$pushto_sl = "status|error|".$affecteduser." account was not found|";}
		
		
		return print($pushto_sl);
	}
	
	function streamstatus($affecteduser,$afftpassword,$push)	{
		/** 
		 * Define POST URL and also payload
		 */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="server" method="getstatus">
						<password>'.$afftpassword.'</password>
						<username>'.$affecteduser.'</username>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		
		if(
			isset(
				$response['response']['data']['row']['field']['1']['@content'],
				$response['response']['data']['row']['field']['4']['@content'],
				$response['response']['data']['row']['field']['5']['@content'],
				$response['response']['data']['row']['field']['6']['@content'],
				$response['response']['data']['row']['field']['14']['@content']
			)
		){			
			$this->listeners    = $response['response']['data']['row']['field']['1']['@content'];
			$this->stream_title	= stripslashes($response['response']['data']['row']['field']['4']['@content']);
			$this->currentsong	= stripslashes($response['response']['data']['row']['field']['5']['@content']);
			$this->bitrate		= $response['response']['data']['row']['field']['6']['@content'];
			$this->servertype	= $response['response']['data']['row']['field']['14']['@content'];

			if($push){
				return $pushto_sl = 
					"streamstatus" 			."|".
					$this->listeners		."|".
					$this->stream_title		."|".
					$this->currentsong		."|".
					$this->bitrate			."|".
					$this->servertype		."|";
			}
			return TRUE;
		}else{ 			
			return FALSE;
		}
	}

	function getsongs($affecteduser,$afftpassword)	{
		/** 
		 * Define POST URL and also payload
		 */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="server" method="getsongs">
						<password>'.$afftpassword.'</password>
						<username>'.$affecteduser.'</username>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		if($response['response']['@attributes']['type'] == 'success'){
			$result = $response['response']['@attributes']['type'];
		}else{$result = "failure";}
		
		if(isset($response['response']['message'])){
			$message = $response['response']['message'];
		}else{$message = "";}
		
		$numsongs = count($response['response']['data']['row']);
		$songs    = "";
		
		for($i=0;$i<$numsongs;$i++){			
			$songs .= stripslashes($response['response']['data']['row'][$i]['field'][0]['@content'])."|";
		}
		
		//print_r($numsongs);
		
		print("getsongs|".$result."|".$message."|".$numsongs."|".$songs);
	}
	
	function nextsong($affecteduser,$afftpassword)	{
		/* Define POST URL and also payload */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="server" method="nextsong">
						<password>'.$afftpassword.'</password>
						<username>'.$affecteduser.'</username>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		if($response['response']['@attributes']['type'] == 'success'){
			$result = $response['response']['@attributes']['type'];
		}else{$result = "failure";}
		
		if(isset($response['response']['message'])){
			$message = $response['response']['message'];
		}else{$message = "";}
		
		print("nextsong|".$result."|".$message);
		
		$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
		$this->db->from('sg_accounts');
		$this->db->where(array('key' => $this->ownerKey));
		
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		$this->sg_backend->account_log($db_row['name'],$db_row['key'],'INFO','Your MetaCast Cloud AutoDJ was given the command to skip the current song.');
	}
	
	function switchsource($affecteduser,$afftpassword,$state)	{
		/* Define POST URL and also payload */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="server" method="switchsource">
						<password>'.$afftpassword.'</password>
						<username>'.$affecteduser.'</username>
						<state>'.$state.'</state>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		if($response['response']['@attributes']['type'] == 'success'){
			$result = $response['response']['@attributes']['type'];
		}else{$result = "failure";}
		
		if(isset($response['response']['message'])){
			$message = $response['response']['message'];
		}else{$message = "";}
		
		print("switchsource|".$result."|".$message."|".$state);
		
		if($state == 'up'){
			$type = "STARTAUTODJ";
		}else if($state == 'down'){
			$type == "STOPAUTODJ";
		}
		
		$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
		$this->db->from('sg_accounts');
		$this->db->where(array('key' => $this->ownerKey));
		
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		
		$this->sg_backend->account_log($db_row['name'],$db_row['key'],$type,'Your MetaCast Cloud AutoDJ was queued to be '.$state);
	}
	
	function getaccount($affecteduser,$afftpassword,$attribute,$printmsg)	{
		/* Define POST URL and also payload */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="server" method="getaccount">
						<password>'.$afftpassword.'</password>
						<username>'.$affecteduser.'</username>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		
		$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
		$this->db->from('sg_accounts');
		$this->db->where(array('key' => $this->ownerKey));
		
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		
		if($response['response']['@attributes']['type'] == 'success'){
			$result = $response['response']['@attributes']['type'];
		}else{$result = "failure";}
		
		if(isset($response['response']['message'])){
			$message = $response['response']['message'];
		}else{$message = "";}
		
		$numfields = count($response['response']['data']['row']['field']);		
		$acctinfo  = array();
		
		for($i=0;$i<$numfields;$i++){			
			if(isset($response['response']['data']['row']['field'][$i]['@content'])){
				$acctinfo[stripslashes($response['response']['data']['row']['field'][$i]['@attributes']['name'])] = stripslashes($response['response']['data']['row']['field'][$i]['@content']);
			}
		}
		
		if($attribute == "bandwidth"){
		
			$usage = $acctinfo['cachedtransfer'] 	;
			$total = $acctinfo['transferlimit']		;
			$unit  = "MB";
			
			if($acctinfo['noxferlimit'] == 0){
				$bwpercent = $usage / $total * 100;
				$bwmessage = $usage.$unit."/".$total.$unit." (".round($bwpercent)."%)";
			}else{
				$bwmessage = $usage.$unit."/UNLIMITED";
			}
			if($printmsg){
				print("bandwidth|".$result."|".$message."|".$bwmessage);
			}else{
				if($result!= 'failure'){return $bwmessage;}else{return $message;}
			}
			
			$this->sg_backend->account_log($db_row['name'],$db_row['key'],'GETBANDWIDTH','Your MetaCast Cloud Bandwidth was checked '.$bwmessage);
		}
		if($attribute == "disk"){
		
			$usage = $acctinfo['cacheddiskusage'] 	;
			$total = $acctinfo['diskquota']		;
			$unit  = "MB";
			
			if($acctinfo['nodiskquota'] == 0){
				$bwpercent = $usage / $total * 100;
				$bwmessage = $usage.$unit."/".$total.$unit." (".round($bwpercent)."%)";
			}else{
				$bwmessage = $usage.$unit."/UNLIMITED";
			}
			if($printmsg){
				print("disk|".$result."|".$message."|".$bwmessage);				
			}else{
				if($result!= 'failure'){return $bwmessage;}else{return $message;}				
			}
			$this->sg_backend->account_log($db_row['name'],$db_row['key'],'GETDISKSPACE','Your MetaCast Cloud Disk Usage was checked '.$bwmessage);
		}
		if($attribute == "acctxfer"){		
			$total = $acctinfo['transferlimit'];			
			
			if($acctinfo['transferlimit'] >= 0){				
				$bwmessage = $total;				
			}else{
				$bwmessage = "UNLIMITED";
			}
			return $bwmessage;
		}
		if($attribute == "acctxferusage"){		
			$usage = $acctinfo['cachedtransfer'];
			return $usage;
		}
	}
	
	function start($affecteduser,$afftpassword,$printmsg)	{
		/* Define POST URL and also payload */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="server" method="start">
						<password>'.$afftpassword.'</password>
						<username>'.$affecteduser.'</username>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		
		if($response['response']['@attributes']['type'] == 'success'){
			$result = $response['response']['@attributes']['type'];
			$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
			$this->db->from('sg_accounts');
			$this->db->where(array('key' => $this->ownerKey));
			
			$db_res 		= $this->db->get();				
			$db_row			= $db_res->row_array();
			$this->sg_backend->account_log($db_row['name'],$db_row['key'],'START','Your MetaCast Cloud server was started');
		}else{$result = "failure";}
		
		if(isset($response['response']['message'])){
			$message = $response['response']['message'];
		}else{$message = "";}
		
		if($printmsg){print("start|".$result."|".$message);}
		
	}
	
	function stop($affecteduser,$afftpassword)	{
		/* Define POST URL and also payload */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="server" method="stop">
						<password>'.$afftpassword.'</password>
						<username>'.$affecteduser.'</username>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		if($response['response']['@attributes']['type'] == 'success'){
			$result = $response['response']['@attributes']['type'];
			$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
			$this->db->from('sg_accounts');
			$this->db->where(array('key' => $this->ownerKey));
			
			$db_res 		= $this->db->get();				
			$db_row			= $db_res->row_array();
			$this->sg_backend->account_log($db_row['name'],$db_row['key'],'SHUTDOWN','Your MetaCast Cloud server was stopped');
		}else{$result = "failure";}
		
		if(isset($response['response']['message'])){
			$message = $response['response']['message'];
		}else{$message = "";}
		
		print("stop|".$result."|".$message);
	}
	
	function restart($affecteduser,$afftpassword,$admin)	{
		/* Define POST URL and also payload */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="server" method="restart">
						<password>'.$afftpassword.'</password>
						<username>'.$affecteduser.'</username>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		if(!$admin){
			if($response['response']['@attributes']['type'] == 'success'){
				$result = $response['response']['@attributes']['type'];
				$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
				$this->db->from('sg_accounts');
				$this->db->where(array('key' => $this->ownerKey));
				
				$db_res 		= $this->db->get();				
				$db_row			= $db_res->row_array();
				$this->sg_backend->account_log($db_row['name'],$db_row['key'],'RESTART','Your MetaCast Cloud server was restarted');
			}else{$result = "failure";}
			
			if(isset($response['response']['message'])){
				$message = $response['response']['message'];
			}else{$message = "";}
			
			print("restart|".$result."|".$message);
		}
	}
	
	function reload($affecteduser,$afftpassword)	{
		/* Define POST URL and also payload */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="server" method="reload">
						<password>'.$afftpassword.'</password>
						<username>'.$affecteduser.'</username>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		if($response['response']['@attributes']['type'] == 'success'){
			$result = 'success';
			$this->db->select('*,UNIX_TIMESTAMP(`mc_exp`) AS "exp"');
			$this->db->from('sg_accounts');
			$this->db->where(array('key' => $this->ownerKey));
			
			$db_res 		= $this->db->get();				
			$db_row			= $db_res->row_array();
			$this->sg_backend->account_log($db_row['name'],$db_row['key'],'RELOAD','Your MetaCast Cloud server configuration was reloaded');
		}else{$result = "failure";}
		
		if(isset($response['response']['message'])){
			$message = $response['response']['message'];
		}else{$message = "";}
		
		print("reload|".$result."|".$message);
	}
	
	function setstatus($affecteduser,$afftpassword,$status)	{
		/* Define POST URL and also payload */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="system" method="setstatus">
						<password>'.$afftpassword.'</password>
						<username>'.$affecteduser.'</username>
						<status>'.$status.'</status>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();		
		//print_r($response);
	}
	
	function terminate($affecteduser,$afftpassword,$printmsg)	{
		/* Define POST URL and also payload */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="server" method="setstatus">
						<password>'.$afftpassword.'</password>
						<username>'.$affecteduser.'</username>						
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		if($response['response']['@attributes']['type'] == 'success'){
			$result = $response['response']['@attributes']['type'];
		}else{$result = "failure";}
		
		if(isset($response['response']['message'])){
			$message = $response['response']['message'];
		}else{$message = "";}
		
		//Disable SG Account
		$this->db->where('mc_user',$affecteduser);
		$this->db->update('sg_accounts', array('mc_active'=>'INACTIVE', 'mc_exp' => date ("Y-m-d H:i:s", time())));
		
		if($printmsg){print("terminate|".$result."|".$message);}
		
		//print_r($response);
	}
	
	function reconfigure($affecteduser,$afftpassword,$setting,$attr)	{		
		/* Define POST URL and also payload */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="server" method="reconfigure">
						<password>admin|'.$this->adminpass.'</password>
						<username>'.$affecteduser.'</username>
						<'.$setting.'>'.$attr.'</'.$setting.'>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		if($response['response']['@attributes']['type'] == 'success'){
			$result = $response['response']['@attributes']['type'];
		}else{
			$result = "failure";
			$this->terminate($affecteduser,$this->adminpass,FALSE);
		}
		
		if(isset($response['response']['message'])){
			$message = $response['response']['message'];
		}else{$message = "";}
		
		return $result;
		
		//print_r($response);
	}
	
	function provision($affecteduser,$afftpassword,$email,$template)	{		
		/* Define POST URL and also payload */
		$this->xmlpayload = 
			'<?xml version="1.0" encoding="UTF-8"?>
				<centovacast>
					<request class="system" method="provision">
						<password>'.$this->adminpass.'</password>
						<adminpassword>'.$afftpassword.'</adminpassword>
						<sourcepassword>'.$afftpassword.'</sourcepassword>						
						<username>'.$affecteduser.'</username>
						<email>'.$email.'</email>
						<template>'.$template.'</template>
						<autostart>1</autostart>
					</request>
				</centovacast>';
		
		$response = $this->sendrequest();
		
		$message;
		
		if(isset($response['response']['message'])){
			$message = $response['response']['message'];
		}else{$message = "";}
		
		if($response['response']['@attributes']['type'] == 'success'){
			$result = "success";
			$this->start($affecteduser,$this->adminpass,FALSE);
		}else{
			$result = "error";
			$this->terminate($affecteduser,$this->adminpass,FALSE);
			return print("provision|".$result."|".$message."|".$affecteduser."|".$afftpassword);
		}	
		
		return print("provision|".$result."|".$message."|".$affecteduser."|".$afftpassword);
		
		//print_r($response);
	}
}

?>
