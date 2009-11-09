<?php
include 'config.php';
connect2slm();

//Globals
$debug = FALSE;

//Receive Data from Second Life
$transid        = seqid();
$frm            = $_POST['frm'];
$frm_name       = $_POST['frm_name'];
$to             = $_POST['to'];
$to_name        = $_POST['to_name'];
$amt            = number_format($_POST['amt'],2); //Convert to float 000.00L$
$type           = $_POST['type'];
$ok             = $_POST['owner_api'];

$gCreator       = "6aab7af0-8ce8-4361-860b-7139054ed44f";
$gBank          = "633ccfe5-9eae-4e3a-8abb-48773dee0edf";
$gApi           = "9354f9133ecc061fc604d2963e05f0d841d55704";

//Find all groups owner has including system group for usage fee
$g_sql   = "SELECT * FROM `mtip_groups` WHERE `owner_api` = '$ok' OR gid= '1'";
$g_res   = mysql_query($g_sql) or die('Find Group: '.mysql_error());
$g_num   = mysql_num_rows($g_res);

if($g_num > 0){ //User has groups
  while($g_row = mysql_fetch_array($g_res)){ //Populate an array with group / payout information
    $gid = $g_row['gid'];
    $pay = $g_row['payout'];    
    $g_array[$gid] = $pay;  
  }
  if($debug == TRUE){print("GROUPS: TRUE\n");}
  foreach ($g_array as $key => $value){ //Using the groupid, grab all the members out of that group
    $u_sql   = "SELECT * FROM `mtip_gmembers` WHERE `gid` = '$key'";
    $u_res   = mysql_query($u_sql) or die('Find Users: '.mysql_error());
    $u_num   = mysql_num_rows($u_res);
    
    if($u_num > 0){//Do this if we have members
      if($debug == TRUE){print("Grp #$key: TRUE\n");}
      while($u_row = mysql_fetch_array($u_res)){//Throw the members in an array with the payout data
        $name = $u_row['name'];
        $ukey = $u_row['key'];        
        
        $totpout = ($amt * $value) / $u_num;
        
        if($key != $pmt_to){//Exclude tipped members in this group
          $u_array[$ukey] = $totpout;
        } 
      }      
    }else{if($debug == TRUE){print("Grp #$key: FALSE\n");}}
  }  
    
  //If we have groups with members our arrays should be built, now lets feed the database...    
  
  $comsum = array_sum($g_array);    //Find the total amount of commission we are paying
  $totcom = $amt * $comsum;         //How much of the amt are we using for commission?
  $amtrem = $amt - $totcom;         //What's left after the commission  
  
  //What we tell the receiver of the tip the amt they will get
  $usrget = number_format($amtrem,2,'.',',');
      
  if($debug == TRUE){print("ComSum: $comsum\nTotCom: $totcom\nAmtRem: $amtrem\nUsrGet: $usrget\n");}
  
  //Start with the owner's tip  
  //All payments to me as Usage Fees
  if($comkey == $gCreator){$ptype = "usg";}else{$ptype = "pmt";} 
    
  //Check for existing user
  $ruser_sql = "SELECT * FROM `mtip_pending_trans` WHERE `pmt_to` = '$to'";
  $ruser_res = mysql_query($ruser_sql) or die('Rem Chk Ext Usr: '.mysql_error());
  $ruser_num = mysql_num_rows($ruser_res);  
  
  if($debug == TRUE){print("Rem Usr #: $ruser_num \n");}
  
  if($ruser_num >= 1){//We found an existing user, do not create a new entry, just update it
    $ruser_row = mysql_fetch_array($ruser_res);    
    $ruser_key = $ruser_row['pmt_to'];
    $ruser_amt = $ruser_row['pmt_amt'];
    $ruser_id  = $ruser_row['pid'];
    
    $new_amt   = $ruser_amt + $amtrem;
    
    $fmt_amt   = number_format($new_amt,2,'.',',');
    $fmt_amt2  = floor($fmt_amt);
    
    $updusrsql = "UPDATE `mtip_pending_trans` 
    SET  `pmt_amt` = '$new_amt' 
    WHERE `pid` = '$ruser_id'";
    mysql_query($updusrsql) or die('Rem Update Bal: '.mysql_error()); //Update their balance so far.
    
    //Log Remaining Payment
    $com_sql = "INSERT INTO `mtipcomm_translog`
    (`transid`,`owner_api`,`pmt_type`,`pmt_from`,`pmt_from_name`,`pmt_to`,`pmt_to_name`,`pmt_amt`,`timestamp`)
    VALUES  
    ('$transid','$ok','$ptype','$frm','$frm_name','$to','$to_name','$amtrem',CURRENT_TIMESTAMP)";
    
    mysql_query($com_sql) or die('Log Pmt New: '.mysql_error()); //Process TransLog Entry for Payment  
    
    if($fmt_amt2 >= 1){
      //Message sent to usr in llOwnerSay
      print("After deductions... Net Pay: L$$usrget Awaiting Pmt: L$$fmt_amt Est. Payout: L$$fmt_amt2
      If you need support, contact your club owner first, or visit http://www.sublimegeek.com/support/");
    }else{    
      print("After deductions... Net Pay: L$$usrget Awaiting Pmt: L$$fmt_amt Storing for future payments      
      If you need support, contact your club owner first, or visit http://www.sublimegeek.com/support/");
    }
    
  }else{
    
    //Log Remaining Payment
    $com_sql = "INSERT INTO `mtipcomm_translog`
    (`transid`,`owner_api`,`pmt_type`,`pmt_from`,`pmt_from_name`,`pmt_to`,`pmt_to_name`,`pmt_amt`,`timestamp`)
    VALUES  
    ('$transid','$ok','$ptype','$frm','$frm_name','$to','$to_name','$amtrem',CURRENT_TIMESTAMP)";
    
    mysql_query($com_sql) or die('Log Pmt New: '.mysql_error()); //Process TransLog Entry for Payment 
    
    //Create a New Bal Entry
    $payg_sql =  "INSERT INTO `mtip_pending_trans` 
               (`pid`,`pmt_to` ,`pmt_amt`,`timestamp`)
        VALUES (NULL ,'$to','$amtrem',CURRENT_TIMESTAMP)";
    mysql_query($payg_sql) or die('Rem Crt New Bal: '.mysql_error()); // Process

    if($usrget >= 1){
      //Message sent to usr in llOwnerSay
      
      $fmt_usg = floor($usrget);
      
      print("After deductions... Net Pay: L$$usrget Awaiting Pmt: L$$usrget Est. Payout: L$$fmt_usg
      If you need support, contact your club owner first, or visit http://www.sublimegeek.com/support/");
    }else{
      print("After deductions... Net Pay: L$$usrget Awaiting Pmt: L$$usrget Storing for future payouts
      If you need support, contact your club owner first, or visit http://www.sublimegeek.com/support/");
    }
  }  
  
  if($u_num > 0){
    foreach ($u_array as $key => $value){ //Process the commission payments
    
      $commsn = $value;               //The amount of commission
      $comkey = $key;                 //Key of the avatar we are giving it to
      
      //All payments to me as Usage Fees
      if($comkey == $gCreator){$ptype = "usg";}else{$ptype = "com";} 
      
      //Check for existing user
      $euser_sql = "SELECT * FROM `mtip_pending_trans` WHERE `pmt_to` = '$comkey'";
      $euser_res = mysql_query($euser_sql) or die('Chk Ext Usr: '.mysql_error());
      $euser_num = mysql_num_rows($euser_res);
      
      //Grab their name
      $unm_sql   = "SELECT `name` FROM `mtip_gmembers` WHERE `key` = '$comkey'";
      $unm_res   = mysql_query($unm_sql) or die('Grab Usr Nm: '.mysql_error());
      $unm       = mysql_result($unm_res,0);
      
      if($debug == TRUE){print("Ext Usr #: $euser_num \n");}
      
      if($euser_num >= 1){//We found an existing user, do not create a new entry, just update it
        $euser_row = mysql_fetch_array($euser_res);    
        $euser_key = $euser_row['pmt_to'];
        $euser_amt = $euser_row['pmt_amt'];
        $euser_id  = $euser_row['pid'];
        
        $new_amt   = $euser_amt + $commsn;
        
        $updusrsql = "UPDATE `mtip_pending_trans` 
        SET  `pmt_amt` = '$new_amt' 
        WHERE `pid` = '$euser_id'";
        mysql_query($updusrsql) or die('Update Bal: '.mysql_error()); //Update their balance so far.
        
        //Log Commission Payment
        $com_sql = "INSERT INTO `mtipcomm_translog`
        (`transid`,`owner_api`,`pmt_type`,`pmt_from`,`pmt_from_name`,`pmt_to`,`pmt_to_name`,`pmt_amt`,`timestamp`)
        VALUES  
        ('$transid','$ok','$ptype','$gBank','System Payment','$comkey','$unm','$commsn',CURRENT_TIMESTAMP)";
        
        mysql_query($com_sql) or die('Log Comm Pmt Ext: '.mysql_error()); //Process TransLog Entry for Commission  
        
      }else{ // No User is Found
        if($debug == TRUE){print("Ext Usr #: No Usr Found \n");}
        //Log Commission Payment
        $com_sql = "INSERT INTO `mtipcomm_translog`
        (`transid`,`owner_api`,`pmt_type`,`pmt_from`,`pmt_from_name`,`pmt_to`,`pmt_to_name`,`pmt_amt`,`timestamp`)
        VALUES  
        ('$transid','$ok','$ptype','$gBank','System Payment','$comkey','$unm','$commsn',CURRENT_TIMESTAMP)";
        
        mysql_query($com_sql) or die('Log Comm Pmt New: '.mysql_error()); //Process TransLog Entry for Commission 
        
        //Create a New Bal Entry
        $payg_sql =  "INSERT INTO `mtip_pending_trans` 
                   (`pid`,`pmt_to` ,`pmt_amt`,`timestamp`)
            VALUES (NULL ,'$comkey','$commsn',CURRENT_TIMESTAMP)";
        mysql_query($payg_sql) or die('Create New Bal: '.mysql_error()); // Process    
        
      }
    }
  }
  
} 
else 
{ 
  /*If no groups were found, just log the transaction */ 
  /*in the database & give the money to the employee  */
  
  
  //Check for existing user
  $nguser_sql = "SELECT * FROM `mtip_pending_trans` WHERE `pmt_to` = '$to'";
  $nguser_res = mysql_query($nguser_sql) or die('Rem Chk Ext Usr: '.mysql_error());
  $nguser_num = mysql_num_rows($nguser_res);  
  
  if($debug == TRUE){print("Rem Usr #: $ruser_num \n");}
  
  //All payments to me as Usage Fees
  if($to == $gCreator){$ptype = "usg";}else{$ptype = "pmt";} 
  
  if($nguser_num >= 1){//We found an existing user, do not create a new entry, just update it
    $nguser_row = mysql_fetch_array($ruser_res);    
    $nguser_key = $ruser_row['pmt_to'];
    $nguser_amt = $ruser_row['pmt_amt'];
    $nguser_id  = $ruser_row['pid'];
    
    $new_amt   = $nguser_amt + $amt;
    
    $updusrsql = "UPDATE `mtip_pending_trans` 
    SET  `pmt_amt` = '$new_amt' 
    WHERE `pid` = '$ruser_id'";
    mysql_query($updusrsql) or die('Rem Update Bal: '.mysql_error()); //Update their balance so far.
    
    //Log Remaining Payment
    $com_sql = "INSERT INTO `mtipcomm_translog`
    (`transid`,`owner_api`,`pmt_type`,`pmt_from`,`pmt_from_name`,`pmt_to`,`pmt_to_name`,`pmt_amt`,`timestamp`)
    VALUES  
    ('$transid','$ok','$ptype','$frm','$frm_name','$to','$to_name','$amtrem',CURRENT_TIMESTAMP)";
    
    mysql_query($com_sql) or die('Log Pmt New: '.mysql_error()); //Process TransLog Entry for Payment  
    
  }else{
    
    //Log Remaining Payment
    $com_sql = "INSERT INTO `mtipcomm_translog`
    (`transid`,`owner_api`,`pmt_type`,`pmt_from`,`pmt_from_name`,`pmt_to`,`pmt_to_name`,`pmt_amt`,`timestamp`)
    VALUES  
    ('$transid','$ok','$ptype','$frm','$frm_name','$to','$to_name','$amtrem',CURRENT_TIMESTAMP)";
    
    mysql_query($com_sql) or die('Log Pmt New: '.mysql_error()); //Process TransLog Entry for Payment 
    
    //Create a New Bal Entry
    $payg_sql =  "INSERT INTO `mtip_pending_trans` 
               (`pid`,`pmt_to` ,`pmt_amt`,`timestamp`)
        VALUES (NULL ,'$to','$pmt',CURRENT_TIMESTAMP)";
    mysql_query($payg_sql) or die('Rem Crt New Bal: '.mysql_error()); // Process        
  }

  //Message sent to usr in llOwnerSay
  print("After deductions... Net Pay: L$$usrget
  If you need support, contact your club owner first, or visit http://www.sublimegeek.com/support/");
}


?>