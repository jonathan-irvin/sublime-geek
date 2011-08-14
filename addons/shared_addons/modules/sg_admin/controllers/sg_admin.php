<?php

class Sg_admin extends  Public_Controller {
	
	//SL Headers Info
	var $headers        ;
	var $objectName     ;
	var $objectKey      ;
	var $ownerKey       ;
	var $ownerName      ;
	var $region         ;
	
	//MetaVotr Vars
	var $simname   		;
	var $locname   		;
	var $slurl     		;
	var $voterkey  		;
	var $votername 		;
	var $rating    		;
	var $authhash  		;
	var $unitver   		;
	var $land_uuid   	;
	var $land_pic_uuid	;
	var $land_area 		;
	var $push_vote 		;
	
	//MetaVotr ThreadMap Vars
	var $grid_x 		;
	var $grid_y 		;	
	
	//GSplode Vars
	var $svr_auth_recv	;
	var $player_name    ;
	var $player_key     ;
	var $pmt_amt        ;	
	var $auth_recv      ;
	var $v_recv         ;
	
	//MetaCast Vars
	var $afftuser		;
	var $afftpass		;
	var $state			;
	var $email			;
	var $template		;
	
	function Sg_admin()
	{
		parent::Controller();	
		
		//Backend Specific
		$this->load->model('sg_backend');
		$this->load->helper('date');
		
		//Application Specific
		$this->load->model('sg_metavotr');		
		$this->load->model('sg_gsplode');
		$this->load->model('sg_metacast');
		
		//Requires
		$this->load->library('parser');
		$this->load->library('xmlrpc');
		$this->load->helper('url');
		
		$DB 		= $this->load->database();		
		$source 	= $this->uri->segment_array();		
		
		//Set Headers
		$this->headers 		  = $this->sg_backend->emu_getallheaders();
		if($this->headers){
			$this->objectName     = $this->headers["X-SecondLife-Object-Name"];
			$this->objectKey      = $this->headers["X-SecondLife-Object-Key"];
			$this->ownerKey       = $this->headers["X-SecondLife-Owner-Key"];
			$this->ownerName      = $this->headers["X-SecondLife-Owner-Name"];
			$this->region         = $this->headers["X-SecondLife-Region"];
		}
		
		//Set MetaVotr Vars
		$this->simname   		= addslashes(	$this->input->post('simname')  			);
		$this->locname   		= addslashes(	$this->input->post('locname')  			);
		$this->slurl     		= 				$this->input->post('slurl'     			);
		$this->voterkey  		= 				$this->input->post('voter_key' 			);
		$this->votername 		= 				$this->input->post('voter_name'			);
		$this->rating    		= 				$this->input->post('rating'    			);
		$this->authhash  		= 				$this->input->post('authhash'  			);
		$this->unitver   		= 				$this->input->post('version'   			);
		$this->land_uuid   		= 				$this->input->post('land_uuid'   		);
		$this->land_pic_uuid    = 				$this->input->post('land_pic_uuid'   	);
		$this->land_area   		= 				$this->input->post('land_area'   		);
		$this->push_vote   		= 				$this->input->post('push_vote'   		);
		
		//MetaVotr ThreadMap
		$this->grid_x   		= 				$this->input->post('grid_x'   			);
		$this->grid_y   		= 				$this->input->post('grid_y'   			);				
		
		//Set GSplode Vars
		$this->svr_auth_recv	= 				$this->input->post('auth' 		  		);
		$this->player_name		=				$this->input->post('player_name'		);
		$this->player_key		=				$this->input->post('player_key'			);
		$this->pmt_amt			=				$this->input->post('pmt_amt'			);
		$this->slurl			=				$this->input->post('slurl'				);
		$this->client_auth_recv	=				$this->input->post('auth'				);
		$this->v_recv			=				$this->input->post('version'			);
		
		//MetaCast Vars
		$this->afftuser 		= 				$this->input->post('mccuser'			);
		$this->afftpass 		= 				$this->input->post('mccpass'			);
		$this->state	 		= 				$this->input->post('state'				);
		$this->attr		 		= 				$this->input->post('attr'				);
		$this->email		 	= 				$this->input->post('email'				);
		$this->template		 	= 				$this->input->post('template'			);
		$this->duration		 	= 				$this->input->post('duration'			);
		
		//Check for an existing account, if not create one
		/*
		if(isset($this->ownerName,$this->ownerKey)){
			$this->sg_backend->check_account_new($this->ownerName,$this->ownerKey,FALSE);
		}
		*/
	}
	
	function index()
	{
		echo "Not Authorized...";
	}
	
	function admin($action)
	{
		if($action == "migrate"){
			$this->sg_backend->migrate_accts(FALSE);
		}else if($action == "mcglobalrestart"){
			$this->db->select('*');
			$this->db->from('geekfox_metacast.accounts');
			$this->db->where('port !=',0);
			$this->db->where('status','enabled');
			$db_res 		= $this->db->get();
		
			foreach($db_res->result() as $row){				
				$this->db->select('*');
				$this->db->from('sg_accounts');
				$this->db->where('mc_user',$row->username);
				
				$sg_res = $this->db->get();					
				$sg_row = $sg_res->result_array();
				
				if($sg_res->num_rows() > 0){
					$this->sg_backend->account_log($sg_row['name'],$sg_row['key'],'MAINTENANCE','Your MetaCast Cloud account was restarted due to system maintenance');
				}
				
				$this->sg_metacast->restart($row->username,'admin|Jurb1f!ed',TRUE);
			}
		}else if($action == "mc_admacctcheck"){
			$this->sg_metacast->mc_admacctcheck();
		}else if($action == "getlogs"){
			$this->sg_backend->acct_history();
		}
		
		
		/*else if($action == "gridsplode_refundall"){
			$db_res = $this->db->query("SELECT
				`gsplode_pay_log`.`gsid`,
				`gsplode_pay_log`.`player_name`,
				`gsplode_pay_log`.`player_key`,
				SUM(`gsplode_pay_log`.`pmt_amt`) as 'total_payed'
				FROM
				`gsplode_sessions` ,
				`gsplode_pay_log`
				WHERE
				`gsplode_sessions`.`status` = 'OPEN' AND
				`gsplode_pay_log`.`gsid` = `gsplode_sessions`.`gsid`
				GROUP BY
				`gsplode_pay_log`.`player_name`");			
		
			foreach($db_res->result() as $row){
				$this->db->insert('gsplode_pending_payouts',array(
					'id'=>'NULL',
					'gsid'=>'99999',
					'transid'=>$this->sg_backend->seqid(),
					'winner_name'=>$row->player_name,
					'winner_key'=>$row->player_key,
					'payout_amt'=>$row->total_payed,
					'type'=>'PAY',
					'msg'=>'Sublime Geek is shutting down GridSplode for now.  We are refunding you any funds that were not in play.  Your total refund is L$'.$row->total_payed,
					'timestamp'=>'CURRENT_TIMESTAMP')
				);
			}
			
			$this->db->update('gsplode_sessions',array('status'=>'CLOSED'));
			$this->db->update('gsplode_config',array('status'=>'SHUTDOWN'));
		}*/
	}
	
	function gridsplode($action,$attr)
	{		
		if(isset($this->player_name,$this->player_key)){
			//$this->sg_backend->check_account_new($this->player_name,$this->player_key,FALSE);
		}		
		if(($action == "chkexp")&&($attr==FALSE)){
			$this->sg_gsplode->chkexpired();
		}
		if(($action == "chkpmt")&&($attr==FALSE)){
			$this->sg_gsplode->chkpmt($this->svr_auth_recv);
		}
		if(($action == "recvpmt")&&($attr==FALSE)){
			$this->sg_gsplode->recv_pmt($this->player_name,$this->player_key,$this->pmt_amt,$this->slurl,$this->client_auth_recv,$this->v_recv);
		}
		if($action == "status"){
			$this->sg_gsplode->status($attr);			
		}
		if($action == "throttle"){
			$this->sg_gsplode->throttle();			
		}
	}
	
	function metacast($request,$username)
	{
		$this->afftuser = $username;
		if($this->ownerKey == "6aab7af0-8ce8-4361-860b-7139054ed44f"){$this->afftpass = "admin|Jurb1f!ed";}
		
		if($request == "status"){
			$this->sg_metacast->status(			$this->afftuser,$this->afftpass);
		}else if ($request == "getsongs"){
			$this->sg_metacast->getsongs(		$this->afftuser,$this->afftpass);
		}else if ($request == "nextsong"){
			$this->sg_metacast->nextsong(		$this->afftuser,$this->afftpass);
		}else if ($request == "switchsource"){
			$this->sg_metacast->switchsource(	$this->afftuser,$this->afftpass,$this->state);
		}else if ($request == "getaccount"){			
			$this->sg_metacast->getaccount(		$this->afftuser,$this->afftpass,$this->attr,TRUE);
		}else if ($request == "start"){
			$this->sg_metacast->start(			$this->afftuser,$this->afftpass,TRUE);
		}else if ($request == "stop"){
			$this->sg_metacast->stop(			$this->afftuser,$this->afftpass);
		}else if ($request == "restart"){
			$this->sg_metacast->restart(		$this->afftuser,$this->afftpass,'FALSE');
		}else if ($request == "reload"){
			$this->sg_metacast->reload(			$this->afftuser,$this->afftpass);
		}else if ($request == "terminate"){
			$this->sg_metacast->terminate(		$this->afftuser,$this->afftpass);
		}else if ($request == "provision"){
			$this->sg_metacast->provision(		$this->afftuser,$this->afftpass,$this->email,$this->template);
		}
		
		else if ($request == "newacct"){
			$this->sg_metacast->newacct(		$this->afftuser,$this->afftpass,$this->email,$this->template,$this->duration);
		}else if ($request == "acctstatus"){
			$this->sg_metacast->acctstatus(		$this->afftuser,$this->afftpass);
		}else if ($request == "upgrade"){
			$this->sg_metacast->upgrade(		$this->afftuser,$this->afftpass,$this->attr);
		}else if ($request == "downgrade"){
			$this->sg_metacast->downgrade(		$this->afftuser,$this->afftpass);
		}else if ($request == "svrinfo"){
			$this->sg_metacast->svrinfo(		$this->afftuser);
		}else if ($request == "renew"){
			$this->sg_metacast->renew(			$this->afftuser,$this->attr);
		}
		
		else{echo "error|Bad request";}
		
	}
	
	function metavotr($type)
	{
		$type = strtolower($type);		
		$this->sg_metavotr->vote(
			$type,
			$this->simname,
			$this->locname,
			$this->slurl,
			$this->voterkey,
			$this->votername,
			$this->rating,
			$this->authhash,
			$this->unitver,
			$this->land_uuid,
			$this->land_pic_uuid,
			$this->land_area,
			$this->push_vote,
			$this->grid_x,
			$this->grid_y
		);
	}	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
