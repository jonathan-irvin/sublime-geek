<?php

class SG_Metavotr extends CI_Model {

    //MetaVotr Constants
	const mv_version 	= 2.5;
	
	//Paid	
	const mv_paidhash 	= "17235846e853b95b792cb5b3da50ba59600a0a55";
	const mv_paiddelay 	= "60 MINUTE";
	
	//Test	
	const mv_testhash 	= "17235846e853b95b792cb5b3da50ba59600a0a55";
	const mv_testdelay 	= "1 MINUTE";
		
	//Free
	const mv_freehash 	= "e76f4f903386a2e4fdec21a045da8294140389ae";
	                     //e76f4f903386a2e4fdec21a045da8294140389ae
	const mv_freedelay 	= "1 DAY";
	
	//ThreadMap
	const threadmap_api = "qdkPKRGGp40eewVihK5Fc0bIa9LRWAXYHf0KwqzF";
	const threadmap_url = "http://www.threadmap.com/api1p0/";
	const threadmap_getinfo    = "getSimpleRegionViewInfo";
	const threadmap_getlink    = "getSimpleRegionView";
	
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
        
        //Set Headers
		$this->headers		    = $this->sg_backend->emu_getallheaders();
		$this->objectName     	= $this->headers["X-SecondLife-Object-Name"];
		$this->objectKey      	= $this->headers["X-SecondLife-Object-Key"];
		$this->ownerKey       	= $this->headers["X-SecondLife-Owner-Key"];
		$this->ownerName      	= $this->headers["X-SecondLife-Owner-Name"];
		$this->region         	= $this->headers["X-SecondLife-Region"];
    }
    
    function vote($type,$simname,$locname,$slurl,$voterkey,$votername,$rating,$authhash,$unitver,$land_uuid,$land_pic_uuid,$land_area,$push_vote,$grid_x,$grid_y)
    {	
		if($type == "free"){
			$delay 	= self::mv_freedelay;
			$hash	= self::mv_freehash;			
		}else if ($type == "paid"){
			$delay 	= self::mv_paiddelay;
			$hash	= self::mv_paidhash;			
		}else if ($type == "gridsplode"){
			$delay 	= self::mv_paiddelay;
			$hash	= self::mv_paidhash;			
		}else if ($type == "test"){
			$delay 	= self::mv_testdelay;
			$hash	= self::mv_testhash;			
		}		
		
		//Do they have an account yet?
		//$this->sg_backend->check_account_new($votername,$voterkey,FALSE); //Not an API Check
		
		//And the owner?
		//$this->sg_backend->check_account_new($this->ownerName,$this->ownerKey,FALSE); //Not an API Check
		
		$ts_delay = "DATE_SUB(NOW(),INTERVAL $delay)";
		//$this->db->cache_on(); //Cache Database queries when possible
		$this->db->select("*,`timestamp` as 'time',DATE_ADD(`timestamp`,INTERVAL ".$delay.") as 'ftime',CURDATE() as 'today'",FALSE);
		$this->db->where("`timestamp` >= DATE_SUB(NOW(),INTERVAL ".$delay.")");
		$this->db->where(array(
			'voter_key'=>$voterkey,
			'locname'=>$locname)
		);
		$get_votes 	= $this->db->get('mvs_votes');	
		//echo $this->db->last_query();
		$db_count 	= $get_votes->num_rows();
		
		$cap_delay = "24 HOUR";		
		$this->db->select("*,`timestamp` as 'time',DATE_ADD(`timestamp`,INTERVAL ".$cap_delay.") as 'ftime',CURDATE() as 'today'",FALSE);
		$this->db->where("`timestamp` >= DATE_SUB(NOW(),INTERVAL ".$cap_delay.")");
		$this->db->where(array(
			'voter_key'=>$voterkey,
			'locname'=>$locname)
		);
		$cap_votes 	= $this->db->get('mvs_votes');			
		$cap_count 	= $cap_votes->num_rows();
		
		if($db_count > 0){
			$db_row   	= $get_votes->row();
			$ttnextvote = $this->sg_backend->nicetime($db_row->ftime);
		}else{
			$ttnextvote = "soon!";
		}
		
		$unitverrecv = $unitver;
		//if($rating > 10){$rating = $rating / 2;}
		
		//Strip alpha from version for production values like p or beta like b
		$unitver = preg_replace('/[^0-9\.]/', '', $unitver);
		
		$push_vote_msg;
		
		if($unitverrecv >= 2.5){
			$push_vote_msg = "Don't feel like waiting? Pay this unit L$30 to push your vote through and help support this location!\n";
		}else if($unitverrecv >= 2.3){
			$push_vote_msg = "Don't feel like waiting? Pay this unit L$50 to push your vote through and help support this location!\n";
		}else{$push_vote_msg = "";}
		
		if($type == "free"){			
			$vote_accept 	= "vote|Thank you ".$votername.", your vote has been accepted!\n".			
			"Watch your favorite location's standings at http://sublimegeek.com/popular";
			$vote_deny	= "vote|You've already voted ".$votername.", but you can vote again ".$ttnextvote."\n".
			$push_vote_msg.			
			"Tired of seeing this message? You can vote more often with metaVotr Premium! (http://bit.ly/9YtfMT)\n".
			"Watch your favorite location's standings at http://sublimegeek.com/popular";
		}else if (($type == "paid") || ($type == "suspend") || ($type == "push") || ($type == "gridsplode")){			
			$vote_accept 	= "vote|Thank you ".$votername.", your vote has been accepted!\n".			
			"Watch your favorite location's standings at http://sublimegeek.com/popular";
			$vote_deny	= "vote|You've already voted ".$votername.", but you can vote again ".$ttnextvote."\n".
			$push_vote_msg.			
			"Watch your favorite location's standings at http://sublimegeek.com/popular";
		}else if ($type == "test"){			
			$vote_accept 	= "vote|Thank you ".$votername.", your vote has been accepted!\n".
			"Watch your favorite location's standings at http://sublimegeek.com/popular";
			$vote_deny	= "vote|You've already voted ".$votername.", but you can vote again ".$ttnextvote."\n".
			"Watch your favorite location's standings at http://sublimegeek.com/popular";
		}
		
		if(($push_vote == TRUE)&&($type!="gridsplode")){$type = "PUSH";}
		
		//Blacklist
		if($this->ownerKey == "51d78a8e-a198-4a8e-853f-432f1d6dbc9c"){$type = "SUSPEND";}  //Suspended for use of alts for padding numbers
		
		$cap_deny	= "vote|I'm sorry ".$votername.", you've already voted for this location ".$cap_count." times today.  ".
			"We've capped the personal daily voting limit at 6 free votes per location per avatar in a 24-hour period.  ".
			"Your cap will decrease slowly in a 24 hour period.  Check back often to vote for your location again!  ".
			$push_vote_msg.	
			"Watch your favorite location's standings at http://sublimegeek.com/popular";
			
		if($unitverrecv >= 2.5){
			$vote_ins = array(
				'id'			=>'NULL',
				'voter_name'	=>$votername,
				'voter_key'		=>$voterkey,
				'owner_key'		=>$this->ownerKey,
				'simname'		=>$simname,
				'locname'		=>$locname,
				'locurl'		=>$slurl,
				'rating'		=>$rating,
				'type'			=>strtoupper($type),
				'version'		=>$unitverrecv,
				'land_uuid'		=>$this->sg_backend->is_uuid($land_uuid),
				'land_pic_uuid'	=>$this->sg_backend->is_uuid($land_pic_uuid),
				'land_area'		=>$land_area,
				'gridx'			=>$grid_x,
				'gridy'			=>$grid_y,
				'threadmap_url' =>self::threadmap_url.self::threadmap_getlink.'?'.'x='.$grid_x.'&y='.$grid_y.'&key='.self::threadmap_api
			);
		}else{
			$vote_ins = array(
				'id'			=>'NULL',
				'voter_name'	=>$votername,
				'voter_key'		=>$voterkey,
				'owner_key'		=>$this->ownerKey,
				'simname'		=>$simname,
				'locname'		=>$locname,
				'locurl'		=>$slurl,
				'rating'		=>$rating,
				'type'			=>strtoupper($type),
				'version'		=>$unitverrecv,
				'land_uuid'		=>$this->sg_backend->is_uuid($land_uuid),
				'land_pic_uuid'	=>$this->sg_backend->is_uuid($land_pic_uuid),
				'land_area'		=>$land_area
			);
		}	

		if($authhash == $hash){
			if($unitver >= self::mv_version){
				if( ($locname != " ") || ($locname != "")){									
					if(($cap_count < 6)||($push_vote == TRUE)){
						if(($db_count == 0)||($push_vote == TRUE)){	
							$this->db->set($vote_ins);					
							$this->db->insert('mvs_votes');
							$str = $this->db->insert_string('mvs_votes', $vote_ins);							
							$this->db->cache_delete('sg_admin','metavotr');//Clear the cache
							if ($type == "test"){echo "\nCap Count: ".$cap_count;}
							
							if($voterkey == $this->ownerKey){
								$voter = $this->ownerName;
							}else{$voter = $votername;}
							
							if($push_vote){
								$this->sg_backend->account_log($this->ownerName,$this->ownerKey,'PUSHVOTE',$voter.' payed to vote for your location.  Increasing your SG Index by '.$rating);
							}else{
								$this->sg_backend->account_log($this->ownerName,$this->ownerKey,'VOTE',$voter.' voted for your location.   Increasing your SG Index by '.$rating);
							}
							echo $vote_accept;
						}else{					
							echo $vote_deny;
						}
					}else{
						echo $cap_deny;
					}
				}else{ echo "err|Location name cannot be blank.";}
			}else if($unitver < self::mv_version){
				echo 	"exp|Error: Unable to vote, this unit requires an update before proceeding.".
					"Get with the owner and have them put out a new version.".
					"This unit must have version ".number_format(self::mv_version, 2, '.', '')." or higher.";
			}
		}else{
			echo "noauth|Error: Unable to vote, this unit is no longer authorized.  Get with the owner and have them put out a new version.";
		}
	}
}

?>
