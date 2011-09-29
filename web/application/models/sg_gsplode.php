<?php

class SG_Gsplode extends CI_Model {
	
	//SL Headers Info
	var $headers        ;
	var $objectName     ;
	var $objectKey      ;
	var $ownerKey       ;
	var $ownerName      ;
	var $region         ;
	
			//System Version
	var	$version        = 3.0;
	var	$DEBUG          = FALSE;

		//Default Commission
	var	$usr_commission = 0.2;
	
	var $server_auth    = "ED20F44C5B3A71A345189ACFBA0C25A16F11D960";
	var $client_auth	= "7399F2FB0B4C2DF30E5D2F0CFF59B6516C64BF58";
	
	/* Used for Recv Payments
	 * $player_name    = $_POST['player_name'];
	 * $player_key     = $_POST['player_key'];
	 * $pmt_amt        = floor($_POST['pmt_amt']);
	 * $slurl          = $_POST['slurl'];
	 * $auth_recv      = $_POST['auth'];
	 * $v_recv         = $_POST['version'];
	 */
	
    function __construct()
    {
        parent::__construct();
        
		$this->load->helper('date');
		
        //Set Headers
		$this->headers 		      = $this->sg_backend->emu_getallheaders();
		if($this->headers){
			$this->objectName     = $this->headers["X-SecondLife-Object-Name"];
			$this->objectKey      = $this->headers["X-SecondLife-Object-Key"];
			$this->ownerKey       = $this->headers["X-SecondLife-Owner-Key"];
			$this->ownerName      = $this->headers["X-SecondLife-Owner-Name"];
			$this->region         = $this->headers["X-SecondLife-Region"];
		}		
    }
    
    function chkexpired()
    {
		//Message Scripts
		$loss_msg	  = "I\'m sorry, you were not a winner this time, but you still have a chance!".
						"\nVisit any GridSplode location and enter to win!".
						"\nRemember, the more you enter, the more chance you have to win!";
		$check 		  = $this->db->get_where('gsplode_sessions',array('status' => 'FILLED'));
		$check_count  = $check->num_rows();		

		$announce	     = $this->db->get_where('gsplode_sessions',array('status' => 'ANNOUNCE'));
		$announce_count  = $announce->num_rows();
		
		if($check_count >= 1){ //We have one or more than one filled tier
			$chkrow 		= $check->result_array();
			$expires 		= $chkrow[0]['completed'];
			$created 		= $chkrow[0]['created'];
			$winners 		= $chkrow[0]['winners'];
			$gsid	 		= $chkrow[0]['gsid'];
			
			$check_id     	= $gsid;			
			$tid          	= $gsid;
			$check_surplus	= $chkrow[0]['bal_surplus'];
			$bal_needed   	= $chkrow[0]['bal_needed'];
			$bal_surplus  	= $check_surplus;			
			
			
			list($date, $time)           = explode(' ', $expires);
			list($year, $month, $day)    = explode('-', $date);
			list($hour, $minute, $second)= explode(':', $time);  

			$exp = mktime($hour, $minute, $second, $month, $day, $year);
			
										
			$timedif 		= $exp - time();
			//$timedif 		= 1;		//USE IN CASE OF SPLODE FREEZE
			//echo $timedif;			
			
			if( (($timedif > 30) && ($timedif >= 0)) && ($winners == "") ){				
				$tier = $this->db->get_where('gsplode_splode_config',array('id'=>$chkrow[0]['gs_type_id']));
				if($tier->num_rows() == 1){
					//Let's build all the info for the current tier we are using						
					$tierrow 		= $tier->result_array();
				}
				
				echo "check;splode;KABOOOOOOOOOOOOOOOOOOOM!";
				
				//Build prizes				
				$prizes 		 = array(
											($tierrow[0]['p_one']   + (floor($bal_surplus * 0.10))),
											($tierrow[0]['p_two']   + (floor($bal_surplus * 0.15))),
											($tierrow[0]['p_three'] + (floor($bal_surplus * 0.25))),
											(                         (floor($bal_surplus * 0.50)))
										);
				/* 
				 * Admins
				 * Jon Desmoulins - '6aab7af0-8ce8-4361-860b-7139054ed44f'
				 * Monkey Canning - '9373569d-db5f-45f3-9f51-4e4498e34adb'
				*/
				
				$admin			 = array("6aab7af0-8ce8-4361-860b-7139054ed44f");
				$players		 = array();				
				
				$w1 = $this->db->where_not_in('player_key',$admin);
				$w1 = $this->db->order_by("player_name","random");
				$w1 = $this->db->get_where('gsplode_pay_log',array('gsid'=>$gsid));				
				
				$w1_sel    		 = $w1->result_array();
				$winners[0] 	 = $w1_sel[0]['player_name'].",".$w1_sel[0]['player_key'];
				$players[0]      = $w1_sel[0]['player_key'];
				
				$w2 = $this->db->where_not_in('player_key',$admin);
				$w2 = $this->db->where_not_in('player_key',$players);
				$w2 = $this->db->order_by("player_name","random");
				$w2 = $this->db->get_where('gsplode_pay_log',array('gsid'=>$gsid));	
				
				if($w2->num_rows() > 0){
					$w2_sel    		 = $w2->result_array();
					$winners[1] 	 = $w2_sel[0]['player_name'].",".$w2_sel[0]['player_key'];
					$players[1]      = $w2_sel[0]['player_key'];
				}else{
					$this->db->where(array('gs_type_id' => $chkrow[0]['gs_type_id'], 'status' => 'OPEN'));
					$this->db->update('gsplode_sessions',array('bal_surplus'=>'(`bal_surplus`+'.$prizes[1].')'));
				}
				
				$w3 = $this->db->where_not_in('player_key',$admin);
				$w3 = $this->db->where_not_in('player_key',$players);
				$w3 = $this->db->order_by("player_name","random");
				$w3 = $this->db->get_where('gsplode_pay_log',array('gsid'=>$gsid));
				
				//echo $this->db->last_query(); return;
				
				if($w3->num_rows() > 0){
					$w3_sel    		 = $w3->result_array();
					$winners[2] 	 = $w3_sel[0]['player_name'].",".$w3_sel[0]['player_key'];
					$players[2]      = $w3_sel[0]['player_key'];
				}else{
					$this->db->where(array('gs_type_id' => $chkrow[0]['gs_type_id'], 'status' => 'OPEN'));
					$this->db->update('gsplode_sessions',array('bal_surplus'=>'(`bal_surplus`+'.$prizes[2].')'));
				}
				
				$p1_winner 		 = $winners[0].",".$prizes[0]."::";
				$p2_winner 		 = $winners[1].",".$prizes[1]."::";
				$p3_winner 		 = $winners[2].",".$prizes[2]."::";
				
				$tot_win         = $tierrow[0]['p_one'] + $tierrow[0]['p_two'] + $tierrow[0]['p_three'];
				$remaining		 = floor($bal_needed - $tot_win);			
				
				$trans		     = array($this->sg_backend->seqid(),$this->sg_backend->seqid(),$this->sg_backend->seqid(),$this->sg_backend->seqid(),$this->sg_backend->seqid());						
				
				$adm_take_sig	 = floor($remaining + $prizes[3]);
				$adm_msg_sig	 = "Admin Payout...\nTier: ".$tierrow[0]['name']."\nTID: $gsid\nCreated: $created GMT -6\nCompleted: $expires GMT -6\nCommission: L$$adm_take_sig";				
				
				$this->db->insert('gsplode_pending_payouts',array('id'=>'NULL','gsid'=>$gsid,'transid'=>$trans[0],'winner_name'=>$w1_sel[0]['player_name'],'winner_key'=>$w1_sel[0]['player_key'],'payout_amt'=>$prizes[0],   					'type'=>'PAY','msg'=>'Today is your lucky day!  You\'ve just won L$'.$prizes[0].' from the Sublime Geek GridSplode Grid-Wide Sploder! \nThanks for playing and we hope to see you as a winner again!','timestamp'=>'CURRENT_TIMESTAMP'));
				$this->db->insert('gsplode_pending_payouts',array('id'=>'NULL','gsid'=>$gsid,'transid'=>$trans[1],'winner_name'=>$w2_sel[0]['player_name'],'winner_key'=>$w2_sel[0]['player_key'],'payout_amt'=>$prizes[1],   					'type'=>'PAY','msg'=>'Today is your lucky day!  You\'ve just won L$'.$prizes[1].' from the Sublime Geek GridSplode Grid-Wide Sploder! \nThanks for playing and we hope to see you as a winner again!','timestamp'=>'CURRENT_TIMESTAMP'));
				$this->db->insert('gsplode_pending_payouts',array('id'=>'NULL','gsid'=>$gsid,'transid'=>$trans[2],'winner_name'=>$w3_sel[0]['player_name'],'winner_key'=>$w3_sel[0]['player_key'],'payout_amt'=>$prizes[2],   					'type'=>'PAY','msg'=>'Today is your lucky day!  You\'ve just won L$'.$prizes[2].' from the Sublime Geek GridSplode Grid-Wide Sploder! \nThanks for playing and we hope to see you as a winner again!','timestamp'=>'CURRENT_TIMESTAMP'));
				$this->db->insert('gsplode_pending_payouts',array('id'=>'NULL','gsid'=>$gsid,'transid'=>$trans[3],'winner_name'=>'Jon Desmoulins',      'winner_key'=>$admin[0],           'payout_amt'=>floor($remaining + $prizes[3]),	    'type'=>'PAY','msg'=>$adm_msg_sig,																																 									  'timestamp'=>'CURRENT_TIMESTAMP'));				
				
				$this->sg_backend->account_log($w1_sel[0]['player_name'],$w1_sel[0]['player_key'],
				'GRIDSPLODE','Today is your lucky day!  
				You\'ve just won L$'.$prizes[0].' from the Sublime Geek GridSplode Grid-Wide Sploder! \n
				Thanks for playing and we hope to see you as a winner again!');
				$this->sg_backend->account_log($w2_sel[0]['player_name'],$w2_sel[0]['player_key'],
				'GRIDSPLODE','Today is your lucky day!  
				You\'ve just won L$'.$prizes[1].' from the Sublime Geek GridSplode Grid-Wide Sploder! \n
				Thanks for playing and we hope to see you as a winner again!');
				$this->sg_backend->account_log($w3_sel[0]['player_name'],$w3_sel[0]['player_key'],
				'GRIDSPLODE','Today is your lucky day!  
				You\'ve just won L$'.$prizes[2].' from the Sublime Geek GridSplode Grid-Wide Sploder! \n
				Thanks for playing and we hope to see you as a winner again!');
				$this->sg_backend->account_log('Jon Desmoulins','6aab7af0-8ce8-4361-860b-7139054ed44f','GRIDSPLODE',$adm_msg_sig);
				
				//Use this for messaging and send a "You Lost" message to the losers				
				$msg = $this->db->group_by("player_name","asc");
				$msg = $this->db->where_not_in('player_key',$players);
				$msg = $this->db->get_where('gsplode_pay_log',array('gsid'=>$gsid));				
				
				foreach($msg->result_array() as $msg_row){
					$this->db->insert('gsplode_pending_payouts',
						array(
							'id'=>'NULL',
							'gsid'=>$gsid,
							'transid'=>$this->sg_backend->seqid(),
							'winner_name'=>$msg_row['player_name'],
							'winner_key'=>$msg_row['player_key'],
							'payout_amt'=>0,
							'type'=>'MSG',
							'msg'=>$loss_msg,
							'timestamp'=>'CURRENT_TIMESTAMP'
						)
					);
					$this->sg_backend->account_log($msg_row['player_name'],$msg_row['player_key'],'GRIDSPLODE',$loss_msg);
				}
				
				//Change the status of the session to announce to let everyone know who won
				$winnerlist = "$p1_winner\n$p2_winner\n$p3_winner";				
				
				$this->db->where(array('gsid'=>$gsid));
				$this->db->update('gsplode_sessions',array('winners'=>$winners[0].','.$prizes[0].'::'.$winners[1].','.$prizes[1].'::'.$winners[2].','.$prizes[2].'::','status'=>'ANNOUNCE'));
				
				
			}			
		}
		if($announce_count >= 1){				
				$announce_row  = $announce->result_array();
				//print_r($announce_row);
				
				$chkrow 		= $announce_row;
				$expires 		= $chkrow[0]['completed'];
				$created 		= $chkrow[0]['created'];
				$winners 		= $chkrow[0]['winners'];
				$gsid	 		= $chkrow[0]['gsid'];
				
				$check_id     	= $gsid;			
				$tid          	= $gsid;
				$check_surplus	= $chkrow[0]['bal_surplus'];
				$bal_needed   	= $chkrow[0]['bal_needed'];
				$bal_surplus  	= $check_surplus;
				
				list($date, $time)           = explode(' ', $expires);
				list($year, $month, $day)    = explode('-', $date);
				list($hour, $minute, $second)= explode(':', $time);  

				$exp = mktime($hour, $minute, $second, $month, $day, $year);
				
				$timedif 		= $exp - time();
				
				$split_winners = explode("::",$announce_row[0]['winners']);
				
				$a_w3         = explode(",",$split_winners[0]);
				$a_w2         = explode(",",$split_winners[1]);
				$a_w1         = explode(",",$split_winners[2]); 				
				
				echo "check;announce;".trim($a_w1[0]." - L$".$a_w1[2])."::".trim($a_w2[0]." - L$".$a_w2[2])."::".trim($a_w3[0]." - L$".$a_w3[2]);
				
				if($timedif >= 60){					
					$this->db->where(array('gsid'=>$gsid));
					$this->db->update('gsplode_sessions',array('status'=>'CLOSED'));
				}
			}
	}
	
	function chkpmt($auth)
	{		
		$this->db->order_by('payout_amt','desc');
		$chkpmt = $this->db->get('gsplode_pending_payouts');
		//echo $this->db->last_query();
		if($auth == $this->server_auth){
			if($chkpmt->num_rows() > 0){ //We have pending payments, process
				$chkpmtrow = $chkpmt->result_array();
				
				if($chkpmtrow[0]['type'] == "PAY"){										
					$this->db->insert('gsplode_payout_log',array('id'=>'NULL','transid'=>$chkpmtrow[0]['transid'],'payee_name'=>$chkpmtrow[0]['winner_name'],'payee_key'=>$chkpmtrow[0]['winner_key'],'pmt_amt'=>$chkpmtrow[0]['payout_amt'],'timestamp'=>'CURRENT_TIMESTAMP'));
					echo "pmt;".$chkpmtrow[0]['winner_key'].";".$chkpmtrow[0]['payout_amt'].";".$chkpmtrow[0]['msg']."";
					$this->sg_backend->account_log('Jon Desmoulins','6aab7af0-8ce8-4361-860b-7139054ed44f','GRIDSPLODE','Paid L$'.$chkpmtrow[0]['payout_amt'].' to '.$chkpmtrow[0]['winner_name']);
					$this->db->delete('gsplode_pending_payouts',array('id'=>$chkpmtrow[0]['id']));
				}elseif($chkpmtrow[0]['type'] == "MSG"){
					$this->db->insert('gsplode_message_log',array('id'=>'NULL','transid'=>$chkpmtrow[0]['transid'],'payee_name'=>$chkpmtrow[0]['winner_name'],'payee_key'=>$chkpmtrow[0]['winner_key'],'msg'=>$chkpmtrow[0]['msg'],'timestamp'=>'CURRENT_TIMESTAMP'));
					echo "msg;".$chkpmtrow[0]['winner_key'].";".$chkpmtrow[0]['msg']."";
					$this->db->delete('gsplode_pending_payouts',array('id'=>$chkpmtrow[0]['id']));
				}elseif($chkpmtrow[0]['type'] == "TST"){
					echo "msg;6aab7af0-8ce8-4361-860b-7139054ed44f;".$chkpmtrow[0]['msg']."";
					$this->db->delete('gsplode_pending_payouts',array('id'=>$chkpmtrow[0]['id']));
				}
			}else{print("none");}
		}else{print("msg;6aab7af0-8ce8-4361-860b-7139054ed44f;Not Authorized...Check the pay server");}		
	}
	
	function throttle(){
		$sys  	 = $this->db->get('gsplode_config');
		$sys_row = $sys->result_array();
		
		echo $sys_row[0]['throttle'];
	}
	
	function status($tier_id)
	{
		/* 
		Overflow Notes:
		Currence Bal = Total Entries * Min. Pay
		Adj. PayOuts = Surplus + Bal Needed

		Divide the Surplus

		Prize 1 = 10%
		Prize 2 = 15%
		Prize 3 = 25%
		-------------
		Total     50%

		Our Take  25% * 2
		Total    100%
		*/	
		
		$sys  	 = $this->db->get('gsplode_config');
		$sys_row = $sys->result_array();		
		$sys_row[0]['status'] = "ONLINE";
		
		$tier 	 = $this->db->get_where('gsplode_splode_config',array('id'=>$tier_id));
		$tierall = $this->db->get('gsplode_splode_config');		
		
		if($tier->num_rows() > 0){
			//Let's build all the info for the current tier we are using						
			$tierrow 		= $tier->result_array();			
			$filled  		= $this->db->get_where('gsplode_sessions',array('status'=>'FILLED','gs_type_id'=>$tier_id));
			$open    		= $this->db->get_where('gsplode_sessions',array('status'=>'OPEN'  ,'gs_type_id'=>$tier_id));			
		}			
		
		if($filled->num_rows() > 0){
			$filled_row		 = $filled->result_array();			
			$total_entries   = "///SPLODE IMMINENT///";			
			$expires	     = $this->sg_backend->gs_nicetime($filled_row[0]['completed']);		
			
			$prizes 		 = array(
									($tierrow[0]['p_one']   + (floor($filled_row[0]['bal_surplus'] * 0.10))),
									($tierrow[0]['p_two']   + (floor($filled_row[0]['bal_surplus'] * 0.15))),
									($tierrow[0]['p_three'] + (floor($filled_row[0]['bal_surplus'] * 0.25))),
									(                         (floor($filled_row[0]['bal_surplus'] * 0.50)))
								);
			//echo "".$tierrow[0]['name'].":::".$prizes[2].":::".$prizes[1].":::".$prizes[0].":::".$tierrow[0]['min_pay'].":::".$total_entries.":::".$sys_row[0]['status']."";
			echo "".$tierrow[0]['name'].":::".$prizes[2].":::".$prizes[1].":::".$prizes[0].":::".$tierrow[0]['min_pay'].":::".$total_entries.":::SHUTDOWN";
		}else if($open->num_rows() > 0){
			$open_row		 = $open->result_array();			
			$prizes 		 = array(
								($tierrow[0]['p_one']   + (floor($open_row[0]['bal_surplus'] * 0.10))),
								($tierrow[0]['p_two']   + (floor($open_row[0]['bal_surplus'] * 0.15))),
								($tierrow[0]['p_three'] + (floor($open_row[0]['bal_surplus'] * 0.25))),
								(                      (floor($open_row[0]['bal_surplus'] * 0.50)))
							);				
			$total_entries   = $open_row[0]['ent_min'] - $open_row[0]['ent_total'];
			
			//echo "".$tierrow[0]['name'].":::".$prizes[2].":::".$prizes[1].":::".$prizes[0].":::".$tierrow[0]['min_pay'].":::".$total_entries.":::".$sys_row[0]['status']."";
			echo "".$tierrow[0]['name'].":::".$prizes[2].":::".$prizes[1].":::".$prizes[0].":::".$tierrow[0]['min_pay'].":::".$total_entries.":::SHUTDOWN";
		}	

		//Output pmt amounts						
		foreach($tierall->result_array() as $trow){
			echo ":::".$trow['min_pay'];
		}		
		
		if($filled->num_rows() > 0){
			//Time to Splode!!!
			echo ":::".$expires;
		}
	}
	
	function pmt_msg(){
		$this->db->order_by('id','random');
		$pmt_msg 		= $this->db->get('gsplode_pymsg');
		$pmt_msg_row 	= $pmt_msg->result_array(); 		
		return $pmt_msg_row[0]['message'];
	}
	function new_session($tid,$deposit,$t_minpay,$min_entries,$e_tot){
		//This is a new session
		//We still want to increase the entry by one
		//And add their payment to the existing balance
		
		$t_comm          = $t_minpay * 0.2; //Commission
		$minpay_nocomm   = $t_minpay - $t_comm;    
		$new_bal_needed  = $minpay_nocomm * $min_entries;    
		
		$new_session     = array(
			'gsid'       => 'NULL',
			'gs_type_id' => $tid,
			'cur_bal'    => $deposit,
			'bal_surplus'=> 0,
			'bal_needed' => $new_bal_needed,
			'ent_min'    => $min_entries,
			'ent_total'  => $e_tot,
			'winners'    => '',
			'status'     => 'OPEN',			
			'completed'  => '0000-00-00 00:00:00');
		
		$this->db->insert('gsplode_sessions',$new_session);		
		return			$this->db->insert_id();
	}

	function new_overflow_session($tid,$deposit,$t_minpay,$min_entries,$e_tot){
		//This is a new session
		//We still want to increase the entry by one
		//And add their payment to the existing balance
				
		$t_comm			= $t_minpay * 0.2; //Commission
		$minpay_nocomm	= $t_minpay - $t_comm;				
		$new_bal_needed = $minpay_nocomm * $min_entries;				
		
		$new_session		= array(
			'gsid'       => 'NULL',
			'gs_type_id' => $tid,
			'cur_bal'    => 0,
			'bal_surplus'=> $deposit,
			'bal_needed' => $new_bal_needed,
			'ent_min'    => $min_entries,
			'ent_total'  => $e_tot,
			'winners'    => '',
			'status'     => 'OPEN',
			'completed'  => '0000-00-00 00:00:00');
		
		$this->db->insert('gsplode_sessions',$new_session);		
		return			$this->db->insert_id();
	}

	function open_session($oid,$deposit,$cur_bal,$ent_total){

		//This time, we have to enter in all the needed info				
		$open_new_bal	= $deposit + $cur_bal;
		$ent_total++;		
		$data = array('cur_bal' => $open_new_bal,'ent_total' => $ent_total);
		$this->db->where('gsid', $oid);
		$this->db->update('gsplode_sessions', $data); 
	}

	function overflow_session($oid,$deposit,$cur_bal_surplus,$ent_total){

		//This time, we have to enter in all the needed info				
		$open_new_bal_surplus	= $deposit + $cur_bal_surplus;
		$ent_total++;
		
		$data = array('bal_surplus' => $open_new_bal_surplus,'ent_total' => $ent_total);
		$this->db->where('gsid', $oid);
		$this->db->update('gsplode_sessions', $data); 
	}

	function log_pmt($oid,$pname,$pkey,$deposit,$sl_url){
		//Log the payment into the payment log
		$new_session = array(
			'gsid' => $oid,
			'transid' => $this->sg_backend->seqid(),
			'player_name'=> $pname,
			'player_key' => $pkey,
			'pmt_amt' => $deposit,
			'slurl'  => $sl_url
			);
		$this->db->insert('gsplode_pay_log',$new_session);				
		
		//print("Log Payment SQL: $pmt_open_sql");
	}	
	
	function recv_pmt($player_name,$player_key,$pmt_amt,$slurl,$auth,$v_recv)
	{
		//echo "SHUTDOWN;The GridSplode system has been shut down.  Thank you for playing.  Refunding your money now.  Check our twitter for more information http://twitter.com/sublimegeek or our blog http://sublimegeek.com/blog";
		//return;
		
		$sys  	  = $this->db->get('gsplode_config');
		$sys_row  = $sys->result_array();		
		
		$tier 	  = $this->db->get_where('gsplode_splode_config',array('min_pay' => $pmt_amt));						

		$dividend_amt   = $pmt_amt * $this->usr_commission;
		$deposit_amt    = $pmt_amt - $dividend_amt;
		
		if($tier->num_rows() > 0){
			//Let's build all the info for the current tier we are using						
			$tier_row 		= $tier->result_array();
			//print_r($tier_row);
							  $this->db->select("*");
							  $this->db->order_by('status','desc');
			$filled  		= $this->db->get_where('gsplode_sessions',array('status'=>'FILLED','gs_type_id'=>$tier_row[0]['id']));
			
			if($filled->num_rows() > 0){
				$filled_row		= $filled->result();
			}
			
							  $this->db->order_by('status','desc');
			$open    		= $this->db->get_where('gsplode_sessions',array('status'=>'OPEN'  ,'gs_type_id'=>$tier_row[0]['id']));
			if($open->num_rows() > 0){
				$open_row		= $open->result_array();
			}
		}
		
		if($auth == $this->client_auth){//This is not an imposter
			if($sys_row[0]['status'] == ("ONLINE" || "DEBUG")){
				//Only do stuff if we are online or testing
				echo $sys_row[0]['status']. ';/me says to '.$player_name.', '.$this->pmt_msg().'...Thanks for playing!  Remember, the more you enter, the more chances you have at winning!!!;'.$sys_row[0]['throttle'];
					if($filled->num_rows() >= 1){
						if($filled_row[0]['ttexp'] > time()){
							//We still have some time remaining on a filled session
							//print("Filled Completed > Now\n");
							//Lets add their entry in with this session, but allocate the funds to the next open session
							
							$filled = array(
								`id`         => '',
								`gsid`       => $filled_id ,
								`transid`    => $this->sg_backend->seqid(),
								`player_name`=> $player_name ,
								`player_key` => $player_key ,
								`pmt_amt`    => $deposit_amt ,
								`slurl`      => $slurl ,
								`timestamp`  => 'NOW()');
							
							$this->db->insert('gsplode_sessions',$filled);
							
							//print("Pmt Filled SQL: $pmt_filled_sql");
							
							//Now that we have entered in our payment for the current filled session id,
							//check for any open ids
							
							if($open->num_rows() == 1){
								//Looks like we have some, lets take the money from the 
								//filled session and apply it to the new session
								
								//Open a Session
									$this->overflow_session($open_row[0]['gsid'],$deposit_amt,$open_row[0]['bal_surplus'],-1);
								//Log the payment
									$this->log_pmt($filled_row[0]['gsid'],$player_name,$player_key,$deposit_amt,$slurl);
							}else{
								//Create the session
									$this->new_overflow_session($tier_row[0]['gsid'],$deposit_amt,$tier_row[0]['min_pay'],$tier_row[0]['min_entries'],0);
								//Log the payment
									$this->log_pmt($filled_row[0]['gsid'],$player_name,$player_key,$deposit_amt,$slurl);					 	
							}
						}else{
							//The filled session we have is expired
							//We will be coming back and paying out the winners, 
							//for now, just enter the payment into a new session
							
							if($open->num_rows() == 1){//Do we have any open sessions?
								//Update the session
									$this->open_session($open_row[0]['gsid'],$deposit_amt,$open_row[0]['cur_bal'],$open_row[0]['ent_total']);
								//Log the payment
									$this->log_pmt($open_row[0]['gsid'],$player_name,$player_key,$deposit_amt,$slurl);
							}else{
								//Update the session
								$op_id =  	$this->new_session($tier_row[0]['gsid'],$deposit_amt,$tier_row[0]['min_pay'],$tier_row[0]['min_entries'],1);	 
								//Log the payment
											$this->log_pmt($op_id,$player_name,$player_key,$deposit_amt,$slurl);		 	 
							}
						}
				}else{//We have no filled sessions, lets check for open ones
					if($open->num_rows() == 1){//We have an open session, lets update its balance and entries
						//Looks like we have some, lets add the payment
						
						$rem = $open_row[0]['ent_min'] - $open_row[0]['ent_total'];						
						//print_r($open_row);
						//echo $this->db->last_query();
						if($rem >= 2){ 
						/* As long as the needed # of players is greater than or equal to one
						use the currently open session unless the minimum req minus the total = 0
						then fill the session and continue */
						
							//Update the session
								$this->open_session($open_row[0]['gsid'],$deposit_amt,$open_row[0]['cur_bal'],$open_row[0]['ent_total']);
							//Log the payment
								$this->log_pmt($open_row[0]['gsid'],$player_name,$player_key,$deposit_amt,$slurl);
						}else{
							
							//Process the last entry
							
							//Update the session
								$this->open_session($open_row[0]['gsid'],$deposit_amt,$open_row[0]['cur_bal'],$open_row[0]['ent_total']);
							//Log the payment
								$this->log_pmt($open_row[0]['gsid'],$player_name,$player_key,$deposit_amt,$slurl);   	
							
							//Fill the session and close it out for now for new payments
							//7200 for total seconds for 2 hours (converting into SL time)
							
							/*
							$data = array(
							   'status' => 'FILLED',
							   'completed' => 'DATE_ADD(NOW(),INTERVAL '.$tier_row[0]['ttexp'].' SECOND)'										   
							);
							*/
							
							$futuretime = (now() + $tier_row[0]['ttexp']);		
							$exptime = date ("Y-m-d H:i:s", $futuretime);
							
							$this->db->set('status','FILLED');
							$this->db->set('completed', $exptime);
							$this->db->where('gsid', $open_row[0]['gsid']);
							$this->db->update('gsplode_sessions'); 
							
							//Lets already have a new session ready
							$this->new_session($tier_row[0]['id'],0,$tier_row[0]['min_pay'],$tier_row[0]['min_entries'],0);
							
							//Broadcast out to all the players that the session is filled and we will be sploding soon
							$msg_eta	  = nicetime($open_row[0]['completed']);
							
							$this->db->group_by('player_key');
							$msg 	 = $this->db->get_where('gsplode_pay_log',array('gsid' => $open_row[0]['id']));
							$msg_row = $msg->result();
							
							$brdcst_msg = 
								"[GridSplode Priority Alert] The ".$tier_row[0]['name']." splode countdown has BEGUN! ETA: ".$msg_eta.
								"\nVisit *ANY* GridSplode location and pay L$".$tier_row[0]['min_pay']." to increase your chances of winning!\n
								If you do not wish to receive these messages, \n
								feel free to create a ticket at http://www.sublimegeek.com/support";
							
							foreach ($msg->result() as $row){
								$msg_name = $row[0]['player_name'];
								$msg_key  = $row[0]['player_key'];
								
								$msg_transid = $this->sg_backend->seqid();						
								
								if( ($msg_name != 'Tristain Savon') || ($msg_name != 'Inchino Melson') ){
									$msg_insert = array(
										'id' => '',
										'gsid' => $open_row[0]['gsid'],
										'transid' => $this->sg_backend->seqid(),
										'winner_name'=> $msg_name,
										'winner_key' => $msg_key,
										'pmt_amt' => '0',
										'type' => 'MSG',
										'msg'  => $brdcst_msg);
									$this->db->insert('gsplode_pending_payouts',$msg_insert);
								}
							}					
						}
					}else{
						//Update the session
							$op_id =  $this->new_session($tier_row[0]['id'],$deposit_amt,$tier_row[0]['min_pay'],$tier_row[0]['min_entries'],1);
						//Log the payment
							$this->log_pmt($op_id,$player_name,$player_key,$deposit_amt,$slurl);
					}
				}
			}
			elseif($sys_row[0]['status'] == "OFFLINE") {
				echo "OFFLINE;The GridSplode system is currently offline.  We will be back up shortly.  Refunding your money now. Check our twitter for more information http://twitter.com/sublimegeek or our blog http://sublimegeek.com/blog";
			}
			elseif($sys_row[0]['status'] == "SHUTDOWN"){
				echo "SHUTDOWN;The GridSplode system has been shut down.  Thank you for playing.  Refunding your money now.  Check our twitter for more information http://twitter.com/sublimegeek or our blog http://sublimegeek.com/blog";
			}
		}else{
			echo "AUTH_FAIL;I'm sorry, this unit is unauthorized to be used in the GridSplode network. Please get a new copy. Refunding your money now.  Check our twitter for more information http://twitter.com/sublimegeek or our blog http://sublimegeek.com/blog";
		}
	}
}

?>
