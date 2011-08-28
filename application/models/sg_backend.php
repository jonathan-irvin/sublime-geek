<?php

class SG_Backend extends CI_Model {

    //SL Headers Info
	var $headers        ;
	var $objectName     ;
	var $objectKey      ;
	var $ownerKey       ;
	var $ownerName      ;
	var $region         ;
    
    function __construct()
    {
        parent::__construct();
		$this->load->helper('date');
        
        //Set Headers
		$this->headers 		      = $this->emu_getallheaders();
		if($this->headers){
			$this->objectName     = $this->headers["X-SecondLife-Object-Name"];
			$this->objectKey      = $this->headers["X-SecondLife-Object-Key"];
			$this->ownerKey       = $this->headers["X-SecondLife-Owner-Key"];
			$this->ownerName      = $this->headers["X-SecondLife-Owner-Name"];
			$this->region         = $this->headers["X-SecondLife-Region"];
		}
    }
    
    function check_account($api_check)
    {
		//Begin Existing/New Account Check		
		$this->db->select('*');
		$this->db->from('sg_accounts');
		$this->db->where(array('key' => $this->ownerKey));
		
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		$api_data       = $this->ownerName.$this->ownerKey.microtime().uniqid().$this->genPass().$this->seqid();
		$gen_api        = SHA1($api_data);
		
		$auth_data      = $this->ownerName.$this->genPass().$this->ownerKey.(microtime()*2).uniqid().$this->region; 
		$gen_auth       = SHA1($auth_data);
		
		$data_insert = array(
			'id'		=>'NULL',
			'name'		=>$this->ownerName,
			'key'		=>$this->ownerKey
			
		);

		if($db_res->num_rows() == 0){ //No User Detected, Create their account
			$this->db->insert('sg_accounts',$data_insert);
			$data_update = array('api_key' => $gen_api);
			$this->db->where('key',$this->ownerKey);
			$this->db->update('sg_accounts', $data_update);
			if($api_check){print('newkey,'.$gen_api.','.$gen_auth);}
		} else if($db_res->num_rows() == 1){		
			if($db_row['api_key'] == ""){
				$data_update = array('api_key' => $gen_api);
				$this->db->where('key',$this->ownerKey);
				$this->db->update('sg_accounts', $data_update);
				if($api_check){print('newkey,'.$gen_api.','.$gen_auth);}
			}else{
				if($api_check){print('existing,'.$db_row['api_key'].','.$gen_auth);}
			}
		}
		
	}
	
	function is_uuid($guid){
		if (preg_match('/^\{?[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}\}?$/', $guid)) {
			return $guid;
		} else {
			return "000000-0000-0000-0000-000000000000";
		}
	}
	
	function check_account_new($name,$key,$api_check)
    {
		
		$this->db->select('*');
		$this->db->from('sg_accounts');
		$this->db->where(array('key' => $key));
		
		$db_res 		= $this->db->get();				
		$db_row			= $db_res->row_array();
		$api_data       = $name.$key.microtime().uniqid().$this->genPass().$this->seqid();
		$gen_api        = SHA1($api_data);
		
		$auth_data      = $name.$this->genPass().$key.(microtime()*2).uniqid().$this->region; 
		$gen_auth       = SHA1($auth_data);
		
		$data_insert = array('name' => $name,'`key`' => $key);
		
		if($db_res->num_rows() == 0){ //No User Detected, Create their account
			$this->db->insert('sg_accounts',$data_insert);
			$data_update = array('api_key' => $gen_api);
			$this->db->where('key',$key);
			$this->db->update('sg_accounts', $data_update);
			if($api_check){print('newkey,'.$gen_api.','.$gen_auth);}
		} else if($db_res->num_rows() == 1){		
			if($db_row['api_key'] == ""){
				$data_update = array('api_key' => $gen_api);
				$this->db->where('key',$key);
				$this->db->update('sg_accounts', $data_update);
				if($api_check){print('newkey,'.$gen_api.','.$gen_auth);}
			}else{
				if($api_check){print('existing,'.$db_row['api_key'].','.$gen_auth);}
			}
		}
	}
	
	/*
		'INFO','WARNING','ERROR','MAINTENANCE',
		'PROVISION','UPGRADE','DOWNGRADE','RENEWAL',
		'START','SHUTDOWN','RESTART','RELOAD',
		'GETSONGS','GETACCT','GETDISKSPACE','GETBANDWIDTH',		
		'STARTAUTODJ','STOPAUTODJ'
	*/
	
	function account_log($name,$key,$type,$description)
    {
		//Make sure they have an account first
		$this->check_account_new($name,$key,FALSE);
		
		//Begin Existing/New Account Check
		$this->db->select('*');
		$this->db->from('sg_accounts');
		$this->db->where(array('key' => $key));
		
		$db_res = $this->db->get();				
		$db_row	= $db_res->row_array();
		
		$data_insert = array(				
				'`uid`'			=>$db_row['id'],				
				'`name`'			=>$name,
				'`key`'			=>$key,
				'`api_key`'		=>$db_row['api_key'],
				'`action`'		=>$type,
				'`description`'	=>$description
		);
		
		$this->db->insert('sg_accounts_log',$data_insert);
	}
	
	function acct_history()
    {
		//Begin Existing/New Account Check
		$this->db->select('*');
		$this->db->from('sg_accounts_log');
		$this->db->where(array('key' => $this->ownerKey));
		$this->db->order_by('timestamp','DESC');
		$this->db->limit(3);
		
		$db_res = $this->db->get();				
		$db_row	= $db_res->row_array();
		
		$pushtosl = array();
		
		foreach($db_res->result() as $row){
			$pushtosl[] = unix_to_human(gmt_to_local(strtotime($row->timestamp),"UM8",FALSE),TRUE,'us')." SLT [".$row->action."] ".stripslashes($row->description);
		}
		
		$logsarray = implode('|',$pushtosl);
		$logs = "getlogs|success|".$logsarray;
		
		print($logs);
	}
	
	function migrate_accts($apicheck)
    {
		$this->db->select('*');
		$this->db->from('mtipcomm_translog');
		$this->db->group_by('pmt_from');		
		
		$db1_res 		= $this->db->get();				
		$db1_row		= $db1_res->row_array();		
		
		//print_r($db1_row);
		
		foreach($db1_res->result() as $row){
			
			$name = $row->pmt_from_name;
			$key  = $row->pmt_from;
			
			//Begin Existing/New Account Check
			$this->db->select('*');
			$this->db->from('sg_accounts');
			$this->db->where(array('key' => $key));
			
			$db_res 		= $this->db->get();				
			$db_row			= $db_res->row_array();
			$api_data       = $name.$key.microtime().uniqid().$this->genPass().$this->seqid();
			$gen_api        = SHA1($api_data);
			
			$auth_data      = $this->ownerName.$this->genPass().$key.(microtime()*2).uniqid().$this->region; 
			$gen_auth       = SHA1($auth_data);
			
			$data_insert = array(
				'id'		=>'NULL',
				'name'		=>$name,
				'key'		=>$key
			);

			if($db_res->num_rows() == 0){ //No User Detected, Create their account
				$this->db->insert('sg_accounts',$data_insert);
				$data_update = array('api_key' => $gen_api);
				$this->db->where('key',$key);
				$this->db->update('sg_accounts', $data_update);
				if($apicheck){print('newkey,'.$gen_api.','.$gen_auth);}
				print("Account created for $name & api generated<br>");
			} else if($db_res->num_rows() == 1){		
				if($db_row['api_key'] == ""){
					$data_update = array('api_key' => $gen_api);
					$this->db->where('key',$key);
					$this->db->update('sg_accounts', $data_update);
					if($api_check){print('newkey,'.$gen_api.','.$gen_auth);}
					print("API updated for $name<br>");
				}else{
					if($apicheck){print('existing,'.$db1_row['api_key'].','.$gen_auth);}
				}
			}
		}
	}
	
	function check_auth($api_check)
	{
		$this->db->select('*');
		$this->db->from('istream_demo');
		$this->db->where(array('key' => $this->ownerKey));								
		$db_res = $this->db->get();
		$db_row	= $db_res->row_array();
		
		$auth_data      = $this->ownerName.$this->genPass().$this->ownerKey.(microtime()*2).uniqid().$this->region; 
		$gen_auth       = SHA1($auth_data);
		
		$data_insert = array(
			'id'		=>'NULL',
			'name'		=>$this->ownerName,
			'key'		=>$this->ownerKey,
			'expires' 	=> 'date_add(NOW(),INTERVAL 7 DAY))'
		);

		if($db_res->num_rows() == 0){ //No User Detected, Create their account
			$this->db->insert('istream_demo',$data_insert);
		}
		
		//Get License Info        
		if($task == "auth"){  
			$this->db->where('id',$id);			
			$this->db->update('istream_demo', array('auth_key' => $gen_auth));
			echo $loc.','.$api.','.$gen_auth;
		}
	}
    
    function genPass()        
	{
	    $len      = 3; 
	    $char     = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';       
	    $chars    = $char;
	    $numChars = strlen($chars);

	    $string = '';
	    for ($i = 0; $i < $len; $i++) {
		$string .= substr($chars, rand(1, $numChars) - 1, 1);
	    }
	    return $string;
	}
	
	function mc_genPass()        
	{
	    $len      = 8; 
	    $char     = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';       
	    $chars    = $char;
	    $numChars = strlen($chars);

	    $string = '';
	    for ($i = 0; $i < $len; $i++) {
		$string .= substr($chars, rand(1, $numChars) - 1, 1);
	    }
	    return $string;
	}

	function emu_getallheaders()
	{
	    foreach($_SERVER as $name => $value){
			if(substr($name, 0, 5) == 'HTTP_'){
				$headers[str_replace('X-Secondlife-', 'X-SecondLife-', str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5))))))] = $value;
			}
		}
	    
		if(isset($headers)){
			return $headers;
		}else{
			return false;
		}
	}
	
	function convert_datetime($str) {

		list($date, $time) = explode(' ', $str);
		list($year, $month, $day) = explode('-', $date);
		list($hour, $minute, $second) = explode(':', $time);

		$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

		return $timestamp;
	}
	
	function readable_time($timestamp, $num_times = 2)
	{
	    //this returns human readable time when it was uploaded (array in seconds)
	    $times = array(31536000 => 'y', 2592000 => 'm',  604800 => 'w', 86400 => 'd', 3600 => 'h', 60 => 'min', 1 => 'sec');
	    $now = time();
	    $secs = $now - $timestamp;
	    $count = 0;
	    $time = '';

	    foreach ($times AS $key => $value)
	    {
		if ($secs >= $key)
		{
		    //time found
		    $s = '';
		    $time .= floor($secs / $key);

		    if ((floor($secs / $key) != 1))
			$s = 's';

		    $time .= ' ' . $value . $s;
		    $count++;
		    $secs = $secs % $key;
		   
		    if ($count > $num_times - 1 || $secs == 0)
			break;
		    else
			$time .= ', ';
		}
	    }

	    return $time;
	}

	function seqid(){
		list($usec, $sec) = explode(" ", microtime());
		list($int, $dec) = explode(".", $usec);
		return $sec.$dec;
	}

	function nicetime($date)
	{
	    if(empty($date)) {
		return "No date provided";
	    }
	    
	    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	    $lengths         = array("60","60","24","7","4.35","12","10");
	    
	    $now             = time();
	    $unix_date         = strtotime($date);
	    
	       // check validity of date
	    if(empty($unix_date)) {    
		return "Bad date";
	    }

	    // is it future date or past date
	    if($now > $unix_date) {    
		$difference     = $now - $unix_date;
		$tense         = "ago";
	
	    } else {
		$difference     = $unix_date - $now;
		$tense         = "from now";
	    }
	    
	    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		$difference /= $lengths[$j];
	    }
	    
	    $difference = round($difference);
	    
	    if($difference != 1) {
		$periods[$j].= "s";
	    }
	    
	    return "$difference $periods[$j] $tense";
	}
	
	function gs_nicetime($date)
	{
		if(empty($date)) {
			return "No date provided";
		}
		
		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");
		
		$now             = time();
		$unix_date       = strtotime($date);
		
		   // check validity of date
		if(empty($unix_date)) {    
			return "Bad date";
		}

		// is it future date or past date
		if($now > $unix_date) {    
			$difference     = $now - $unix_date;
			$tense          = "ago";
			
		} else {
			$difference     = $unix_date - $now;
			$tense          = "";
		}
		
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		
		$difference = round($difference);
		
		if($difference != 1) {
			$periods[$j].= "s";
		}
		
		if($now > $unix_date) {
			return "Any second now...";
		}else{return "$difference $periods[$j] {$tense}";}
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
	
	function just_clean($string)
	{
		// Replace other special chars
		$specialCharacters = array(
		'#' => '',
		'$' => '',
		'%' => '',
		'&' => '',
		'@' => '',
		'.' => '',
		'?' => '',
		'+' => '',
		'=' => '',
		'?' => '',
		'\\' => '',
		'/' => '',
		);

		while (list($character, $replacement) = each($specialCharacters)) {
			$string = str_replace($character, '-' . $replacement . '-', $string);
		}

		$string = strtr($string,
		"??????? ??????????????????????????????????????????????",
		"AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"
		);

		// Remove all remaining other unknown characters
		$string = preg_replace('/[^a-zA-Z0-9\-]/', ' ', $string);
		$string = preg_replace('/^[\-]+/', '', $string);
		$string = preg_replace('/[\-]+$/', '', $string);
		$string = preg_replace('/[\-]{2,}/', ' ', $string);

		return $string;
	}
	
	function alphaID($in, $to_num = false, $pad_up = false){
		$index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$base  = strlen($index);

	 
		if ($to_num){
			// Digital number  <<--  alphabet letter code
			$in  = strrev($in);
			$out = 0;
			$len = strlen($in) - 1;
			for ($t = 0; $t <= $len; $t++) {
				$bcpow = pow($base, $len - $t);
				$out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
			}
	 
			if (is_numeric($pad_up)) {
				$pad_up--;
				if ($pad_up > 0) {
					$out -= pow($base, $pad_up);
				}
			}
		}else{ 
			// Digital number  -->>  alphabet letter code
			if (is_numeric($pad_up)) {
				$pad_up--;
				if ($pad_up > 0) {
					$in += pow($base, $pad_up);
				}
			}
	 
			$out = "";
			for ($t = floor(log10($in) / log10($base)); $t >= 0; $t--) {
				$a   = floor($in / pow($base, $t));
				$out = $out . substr($index, $a, 1);
				$in  = $in - ($a * pow($base, $t));
			}
			$out = strrev($out); // reverse
		}
		return $out;
	}
}

?>
