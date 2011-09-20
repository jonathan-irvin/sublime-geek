<?php

class SG_Metatip extends CI_Model {

    //MetaTip Constants
    const mt_version 	= 3.0;
    
    const gCreator      = "6aab7af0-8ce8-4361-860b-7139054ed44f";
    const gBank         = "93e0aa20-99eb-4730-b9f2-5e0e19ab06ca";
    const gApi          = "9354f9133ecc061fc604d2963e05f0d841d55704";    

    //SL Headers Info
    var $headers;
    var $objectName;
    var $objectKey;
    var $ownerKey;
    var $ownerName;
    var $region;
    
    //MetaTip Vars
    var $payout_groups;
    var $payout_users;
	
    function __construct()
    {
        parent::__construct();
        
        //Set Headers
        $this->headers		= $this->sg_backend->emu_getallheaders();
        $this->objectName     	= $this->headers["X-SecondLife-Object-Name"];
        $this->objectKey      	= $this->headers["X-SecondLife-Object-Key"];
        $this->ownerKey       	= $this->headers["X-SecondLife-Owner-Key"];
        $this->ownerName      	= $this->headers["X-SecondLife-Owner-Name"];
        $this->region         	= $this->headers["X-SecondLife-Region"];
    }
    
    function tip($from_uuid,$from_name,$to_uuid,$to_name,$tip_amount,$trans_type,$user_api)
    {	
        //Find all groups belonging to the API Owner        			
        $this->db->select('*');
        $this->db->from('mtip_groups');
        $this->db->where(array('owner_api' => $user_api));
        
        $group_result = $this->db->get();				
	$group_rows   = $group_result->row_array();
        $group_total  = $group_result->num_rows();
        
        //Now we have our result, add all applicable groups to an array with group id and commission percentage
        if($group_rows>0){
           foreach($group_result->result() as $row){ 
                $group_id                            = $row->gid;
                $total_payout_commission             = $row->payout;    
                $this->payout_groups[$group_id]      = $total_payout_commission;
           }
           
           //Next, find all members of each group and calculate their total commission
           foreach ($this->payout_groups as $key => $value){ 
                $this->db->select('*');
                $this->db->from('mtip_gmembers');
                $this->db->where(array('gid' => $key));                
                
                $users_result = $this->db->get();				
                $users_rows   = $users_result->row_array();
                $users_total  = $users_result->num_rows();
           
                //We have users in this group, calculate total commission payout
                if($users_rows > 0){
                    foreach($users_result as $row){
                        $total_user_payout = ($tip_amount * $value) / $users_total;
                        
                        //Filter out the user who was tipped
                        if($row->key != $to_uuid){
                            $this->payout_users[$row->key] = $total_user_payout;
                        }
                    }
                }
           }
           
           
           //If we have groups with members our arrays should be built, let's feed the database...
           
           //Find the total amount of commission we are paying
           $total_commission_percent = array_sum($this->payout_groups);
           
           //How much of the tip amount are we using for commission?
           $total_commission         = $tip_amount * $total_commission_percent;
           
           //What's the remainder after all commissions have been removed  
           $amount_remaining         = $tip_amount - $total_commission;

           //This is used to inform the payee how much tip they are receiving
           //Convert how much they get into 00.00 number format
           $user_gets    = number_format($amount_remaining,2,'.',',');
           $user_keeps   = floor($user_gets);
           $users_change = $user_gets - $user_keeps;
           $users_change_formatted = number_format($users_change,2,'.',',');

           $commission_percent = round($total_commission);
           
           //Start with the owner's tip  
           //All payments to me as Usage Fees
           if($comkey == $gCreator){$ptype = "usg";}else{$ptype = "pmt";}
           
           /* INITIATE PAYOUT TRANSACTION */
           
           foreach ($this->payout_users as $key => $value){
               
                $this->db->select('*');
                $this->db->from('mtip_pending_trans');
                $this->db->where(array('pmt_to' => $key));                
                
                $payout_result           = $this->db->get();				
                $payout_rows             = $payout_result->row_array();
                $payout_total            = $payout_result->num_rows();
                
                $new_balance             = $payout_rows->pmt_amt + $users_change;
                $new_balance_formatted   = floor($users_change_formatted);
                
                if($payout_total > 0){
                    $balance_update = array('pmt_amt' => $users_change);
                    $this->db->where('pid',$key);
		    $this->db->update('mtip_pending_trans', $balance_update);
                }
                
                
                
                
           }
           

    $ruser_row = mysql_fetch_array($ruser_res);    
    $ruser_key = $ruser_row['pmt_to'];
    $ruser_amt = $ruser_row['pmt_amt'];
    $ruser_id  = $ruser_row['pid'];
    
    $new_amt   = $ruser_amt + $usrchg; //Don't store the amount only keep the change
    
    $fmt_amt   = number_format($usrchg,2,'.',',');
    $fmt_amt2  = floor($fmt_amt);
    
    $updusrsql = "UPDATE `mtip_pending_trans` 
    SET  `pmt_amt` = '$usrchg' 
    WHERE `pid` = '$ruser_id'";
    mysql_query($updusrsql) or die('Rem Update Bal: '.mysql_error()); //Update their balance so far.
    
    //Log Remaining Payment, We still want to log the full amount even though the change is pending
    $com_sql = "INSERT INTO `mtipcomm_translog`
    (`transid`,`owner_api`,`pmt_type`,`pmt_from`,`pmt_from_name`,`pmt_to`,`pmt_to_name`,`pmt_amt`,`timestamp`)
    VALUES  
    ('$transid','$ok','$ptype','$frm','$frm_name','$to','$to_name','$amtrem',CURRENT_TIMESTAMP)";
    
    mysql_query($com_sql) or die('Log Pmt New: '.mysql_error()); //Process TransLog Entry for Payment  
    
    if($fmt_amt2 >= 1){
      //Message sent to usr in llOwnerSay
      print("pay;After deductions... Net Pay: L$$usrget Awaiting Pmt: L$$fmt_amt Est. Payout: L$$fmt_amt2
      If you need support, contact your club owner first, or visit http://www.sublimegeek.com/support/;$comprc");
    }else{    
      print("pay;After deductions... Net Pay: L$$usrget Awaiting Pmt: L$$fmt_amt Storing for future payments      
      If you need support, contact your club owner first, or visit http://www.sublimegeek.com/support/;$comprc");
    }
        }
    }
}
?>
