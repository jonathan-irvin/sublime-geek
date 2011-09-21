<?php

class A extends Controller {
	
	function A()
	{
		parent::Controller();
		$this->output->enable_profiler(FALSE);
		$this->load->model('sg_backend');
		$this->load->helper('date');
		$this->load->helper('url');		
	}
	
	function index()
	{
		$DB 		= $this->load->database();
		$source 	= $this->uri->segment_array();		
		
		if(strtolower($source[2]) == "sl"){			
			
			$headers 		= $this->sg_backend->emu_getallheaders();
			$objectName     = $headers["X-SecondLife-Object-Name"];
			$objectKey      = $headers["X-SecondLife-Object-Key"];
			$ownerKey       = $headers["X-SecondLife-Owner-Key"];
			$ownerName      = $headers["X-SecondLife-Owner-Name"];
			$region         = $headers["X-SecondLife-Region"];
			
			if($source[3] === FALSE){
				echo "error|Sorry.  Either the location hasn't been setup correctly or my owner deleted the LiveMark profile";
			}else{
				//URL is from SL
				$this->db->select('*');
				$this->db->from('livemark_profiles');
				$this->db->where(array('profile_name' => $source[3]));								
				$db_res = $this->db->get();
				
				if(($db_res->num_rows() > 0)&&($ownerKey != "")){	
					$db_row	= $db_res->row_array();
					$parse  = explode("/",$db_row['location_url']);
					$reparse = implode("|",$parse);					
					echo "mapto|$reparse|".$db_row['owner_key'];
				}else{
					$this->db->select('*');
					$this->db->from('livemark_profiles');
					$this->db->where(array('id' => $this->sg_backend->alphaID($source[3], true,false)));								
					$db_res = $this->db->get();
				
					if($db_res->num_rows() > 0){
						$db_row	= $db_res->row_array();
						$parse  = explode("/",$db_row['location_url']);
						$reparse = implode("|",$parse);					
						echo "mapto|$reparse|".$db_row['owner_key'];
					}else{echo "error|Sorry.  Either the location hasn't been setup correctly or my owner deleted the LiveMark profile";}
				}
			}
			$db_res->free_result();
		}else if(strtolower($source[2]) == "backend"){			
			
			//SL Headers
			$headers 	= $this->sg_backend->emu_getallheaders();
			$objectName     = $headers["X-SecondLife-Object-Name"];
			$objectKey      = $headers["X-SecondLife-Object-Key"];
			$ownerKey       = $headers["X-SecondLife-Owner-Key"];
			$ownerName      = $headers["X-SecondLife-Owner-Name"];
			$region         = $headers["X-SecondLife-Region"];
			
			//SL Variables from post
			$simname   		= addslashes($this->input->post('simname',TRUE));
			$locname   		= addslashes($this->input->post('locname',TRUE));
			$slurl     		= $this->input->post('slurl',TRUE);
			$exurl     		= $this->input->post('exurl',TRUE);
			$profilename    = $this->input->post('profname',TRUE);
			$landdesc     	= $this->input->post('pdesc',TRUE);
			$landarea     	= $this->input->post('parea',TRUE);	
			$profid     	= $this->input->post('profid',TRUE);
			$landid     	= $this->input->post('puuid',TRUE);
			$landpic     	= $this->input->post('landpic',TRUE);
			
			$genProfile	= $this->sg_backend->genPass();			
			
			$profilelist = "";
			
			//Add LiveMark SQL
			$addlmk = 
			array(
				'id'=>'',
				'profile_name'=>$genProfile,
				'owner_name'=>$ownerName,
				'owner_key'=>$ownerKey,
				'location_name'=>$locname,
				'location_url'=>$slurl,
				'location_slurl'=>$exurl,
				'location_desc'=>$landdesc,
				'location_area'=>$landarea,
				'land_uuid'=>$landid,
				'land_img_uuid'=>$landpic,
				'timestamp'=>date('Y-m-d H:i:s', now())
			);
			
			if($source[3] == "newrdm"){				
				$this->db->insert('livemark_profiles',$addlmk);
				$data = $this->sg_backend->alphaID($this->db->insert_id(), false,false);
				echo "newrdmloc|$genProfile|http://lmrk.in/$data";
			}else if($source[3] == "newloc"){
				$this->db->insert('livemark_profiles',$addlmk);
				$data = $this->sg_backend->alphaID($this->db->insert_id(), false,false);
				echo "newloc|$genProfile|http://lmrk.in/$data";
			}else if($source[3] == "list"){
				$this->db->select('*');
				$this->db->from('livemark_profiles');
				$this->db->where(array('owner_key' => $ownerKey));								
				$db_res = $this->db->get();
				
				if($db_res->num_rows()>0){					
					foreach($db_res->result_array() as $db_row){
						$profilelist .= "\nLocation Name: \"".$db_row['location_name']
										."\" ProfileID: \"".$db_row['profile_name']
										."\" URL: http://lmrk.in/".$this->sg_backend->alphaID($db_row['id'],false,false).";";
					}
				}
				echo "list|$profilelist";
				$db_res->free_result();
			}else if($source[3] == "delprofile"){				
				$db_res = $this->db->get_where('livemark_profiles',array('profile_name' => $source[4]));
				if($db_res->num_rows() > 0){
					$db_row	= $db_res->row_array();
					$this->db->delete('livemark_profiles',array('owner_key'=>$ownerKey,'profile_name'=>$source[4]));
					echo "delprofile|".$source[4];
				}else{
					echo "error|Error: Profile not found.  Is it yours?  Did you delete it already? Did you type the wrong name?";
				}		
			}else if ($source[3] == "update"){
				
				$data = array(
					'location_name'=>$locname,
					'location_url'=>$slurl,
					'location_slurl'=>$exurl,
					'location_desc'=>$landdesc,
					'location_area'=>$landarea,
					'land_uuid'=>$landid,
					'land_img_uuid'=>$landpic					
				);
				
				//URL is from SL
				$this->db->select('*');
				$this->db->from('livemark_profiles');
				$this->db->where(array('profile_name' => $profid,'owner_key'=>$ownerKey));								
				$db_res = $this->db->get();
				
				if(($db_res->num_rows() > 0)&&($ownerKey != "")){	
					$db_row	= $db_res->row_array();
					$parse  = explode("/",$db_row['location_url']);
					$reparse = implode("|",$parse);	
					
					$this->db->where('profile_name',$profid);
					$this->db->where('owner_key',$ownerKey);
					$this->db->update('livemark_profiles',$data);
					$affected = $this->db->affected_rows();
					echo "updateloc|$affected";
					$db_res->free_result();
				}else{
					$this->db->select('*');
					$this->db->from('livemark_profiles');
					$this->db->where(array('id' => $this->sg_backend->alphaID($profid, true,false),'owner_key'=>$ownerKey));								
					$db_res = $this->db->get();
				
					if(($db_res->num_rows() > 0)&&($ownerKey != "")){
						$this->db->where('id',$this->sg_backend->alphaID($profid, true,false));
						$this->db->where('owner_key',$ownerKey);
						$this->db->update('livemark_profiles',$data);
						$affected = $this->db->affected_rows();
						echo "updateloc|$affected";
						$db_res->free_result();
					}else{
						echo "error|Incorrect id or you are trying to update an id that isn't yours.  Please correct this to avoid seeing this message";
						$db_res->free_result();
					}
				}
			}
		}else{
			//Source is web, redirect to SLurl
			//Do we have a profile name that matches?
			$this->db->select('*');
			$this->db->from('livemark_profiles');
			$this->db->where(array('profile_name' => $source[2]));								
			$db_res = $this->db->get();		
			
			$slurlimg = '';
			$slurlmsg = '';
			
			if($db_res->num_rows() > 0){//Yes! Send us there.
				$db_row	= $db_res->row_array();
				if(
					($db_row['land_img_uuid'] != '00000000-0000-0000-0000-000000000000')&&
					($db_row['land_img_uuid'] != '0')&&
					($db_row['land_img_uuid'] != '')
				){$slurlimg = "&img=http://secondlife.com/app/image/".$db_row['land_img_uuid']."/1";}

				if($db_row['location_desc'] != ''){
					$slurlmsg = "&msg=".$db_row['location_desc'].htmlentities(" :: Powered By: LiveMark - http://bit.ly/dx5kVD");
				}else{
					$slurlmsg = "&msg=".htmlentities("Powered By: LiveMark - http://bit.ly/dx5kVD");
				}
				
				echo '<meta http-equiv="REFRESH" content="0;url='.$db_row['location_slurl'].'?title=LiveMark:%20'.$db_row['location_name'].$slurlimg.$slurlmsg.'">';
				
				$db_res->free_result();
				exit;
			}else{ //No.  Is it a hashed id?
				$this->db->select('*');
				$this->db->from('livemark_profiles');
				$this->db->where(array('id' => $this->sg_backend->alphaID($source[2], true,false)));								
				$db_res = $this->db->get();
				
				if($db_res->num_rows() > 0){//Yes! Send us there.
					$db_row	= $db_res->row_array();				
					if(
						($db_row['land_img_uuid'] != '00000000-0000-0000-0000-000000000000')&&
						($db_row['land_img_uuid'] != '0')&&
						($db_row['land_img_uuid'] != '')
					){$slurlimg = "&img=http://secondlife.com/app/image/".$db_row['land_img_uuid']."/1";}

					if($db_row['location_desc'] != ''){
						$slurlmsg = "&msg=".$db_row['location_desc'];
					}
					echo '<meta http-equiv="REFRESH" content="0;url='.$db_row['location_slurl'].'?title=LiveMark:%20'.$db_row['location_name'].$slurlimg.$slurlmsg.'">';
					exit;
				}else{//No. We don't know where that is
					show_404();
					//echo $this->sg_backend->alphaID($source[2], false,false);
				}
				$db_res->free_result();
				exit;
			}			
		}		
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
