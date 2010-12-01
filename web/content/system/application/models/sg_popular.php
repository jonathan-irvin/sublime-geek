
<?php

class SG_Popular extends Model {

    function SG_Popular()
    {
        parent::Model();		
    }
    
    function grab_ratings($interval, $limit){
		//Used to select the top locations
		/*
		$toploc = "SELECT  
		`locname` ,  `simname` ,  `locurl` , 
		COUNT( * ) AS  `total` , 
		AVG(  `rating` ) as `rating` ,  `type` ,
		`timestamp` ,
		(AVG(  `rating` ) * COUNT( * )) as 'sgi'
		FROM  `mvs_votes` 
		WHERE  `timestamp` >= DATE_SUB( NOW() , INTERVAL $interval ) AND
		`type` IN ('FREE',  'PAID', 'PUSH', 'GRIDSPLODE')
		GROUP BY  `locname` , `type`
		ORDER BY  (AVG(  `rating` ) * COUNT( * )) DESC , `locname` ASC, `type` DESC
		LIMIT 0 , $sel";		
		*/
		
		$this->db->select("`locname` ,  `simname` ,  `locurl` , `land_pic_uuid`, `land_uuid`, `threadmap_url`, `type`, COUNT( * ) AS  `total` , AVG(  `rating` ) as `rating` , (AVG(  `rating` ) * COUNT( * )) as 'sgi'",FALSE);
		$this->db->from('mvs_votes');
		$this->db->where("`timestamp` >= DATE_SUB(NOW(),INTERVAL ".$interval.")");
		$this->db->where("`type` IN ('FREE',  'PAID', 'PUSH', 'GRIDSPLODE')");
		$this->db->group_by(array("locname")); 
		$this->db->order_by("(AVG(  `rating` ) * COUNT( * )) DESC , `locname` ASC, `type` DESC"); 
		$this->db->limit($limit);
		$scores = $this->db->get();
		
		$db_count 	= $scores->num_rows();
		$locations  = array();
		
		//print_r($scores->result_array());
		
		if ($db_count > 0)
		{
			$i = 0;			
			foreach ($scores->result_array() as $row){
				$location_threadmap = "http://threadmap.com";
				$location_img = "http://secondlife.com/app/image/".$row['land_pic_uuid']."/2";
				
				if($row['threadmap_url'] == "1"){					
					$location_threadmap = $row['threadmap_url'];
				}else if($row['threadmap_url'] == "0"){
					if (preg_match('/^\{?[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}\}?$/', $row['land_pic_uuid'])) {
						$location_img = "http://secondlife.com/app/image/".$row['land_pic_uuid']."/2";
					}else{
						$location_img = "http://sublimegeek.com/images/no_image.jpg";
					}
				}
				
				if( (!@getimagesize($location_img) ) || ($row['land_pic_uuid'] == "00000000-0000-0000-0000-000000000000") ){
					$location_img = "http://sublimegeek.com/images/no_image.jpg";
				}
				
							
				$locations[$i] = array(
					'location_name'=>stripslashes($row['locname']),
					'location_url'=>$row['locurl'],
					'location_sim'=>stripslashes($row['simname']),
					'location_sgi'=>number_format($row['sgi'],0,'.',','),
					'location_image'=>$location_img,
					'location_threadmap'=>$location_threadmap);
				$i++;
			}
		}

		return $locations;
	}
	
	function checkRemoteFile($url){
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL,$url);
		// don't download content
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

		if(curl_exec($ch)!==FALSE)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>
