// LSL script generated: .gs_base_v1.4.lslp Fri Oct 30 19:21:28 Central Daylight Time 2009
//GridSplode Base
//By Jon Desmoulins
//Original Concept by Monkey Canning

//OPERATIONAL CONFIG
string shape = "Star";
string version = "1.4";
string auth = "7399F2FB0B4C2DF30E5D2F0CFF59B6516C64BF58";
key requestid_pay;
vector Where;
string Name;
integer X;
integer Y;
integer Z;

integer paid_in;
key paid_id;

//CREATOR SETTINGS
key gCreator = "6aab7af0-8ce8-4361-860b-7139054ed44f";
key gBank = "633ccfe5-9eae-4e3a-8abb-48773dee0edf";

//FUNCTIONS
string slurl(){
    (Name = llGetRegionName());
    (Where = llGetPos());
    (X = ((integer)Where.x));
    (Y = ((integer)Where.y));
    (Z = ((integer)Where.z));
    string _SLURL0 = ((((((((("http://slurl.com/secondlife/" + Name) + "/") + ((string)X)) + "/") + ((string)Y)) + "/") + ((string)Z)) + "/?title=") + Name);
    return _SLURL0;
}
logpmt(key player_key,integer pmt_amt){
    (requestid_pay = llHTTPRequest("https://www.sublimegeek.com/backend/gsplode_recv_pmt.php",[0,"POST",1,"application/x-www-form-urlencoded",3,1],((((((((((("player_name=" + llEscapeURL(llKey2Name(player_key))) + "&player_key=") + llEscapeURL(((string)player_key))) + "&pmt_amt=") + llEscapeURL(((string)pmt_amt))) + "&slurl=") + llEscapeURL(slurl())) + "&auth=") + llEscapeURL(auth)) + "&version=") + llEscapeURL(version))));
}
getperms(integer _perms0){
    if ((_perms0 && 2)) {
        llOwnerSay("Thank you!...Proceeding.");
        llOwnerSay("I'm active and accepting payments");
        llPlaySound("a3c3d7f5-a01b-9365-672d-4507ab281fc3",1.0);
    }
    else  {
        llOwnerSay("Please rez a new GridSploder and select YES to startup this GridSploder");
        llDie();
    }
}

dmca(){
    if ((llGetCreator() != gCreator)) {
        llShout(0,(("<<<DMCA Security Violation Detected! Violator is: " + llKey2Name(llGetOwnerKey(llGetOwner()))) + ".  Purging violation!>>>"));
        llShout(0,(("<<<DMCA Security Violation Detected! Violator is: " + llKey2Name(llGetOwnerKey(llGetOwner()))) + ".  Your Purchase is now VOID>>>"));
        llInstantMessage(gCreator,(("<<<DMCA Security Violation: " + llKey2Name(llGetOwnerKey(llGetOwner()))) + ">>> Deleting Object"));
        llShout(0,"<<< You have been reported for your actions! >>>");
        llDie();
    }
}

default {

    on_rez(integer sparam) {
        {
            dmca();
        }
        llPlaySound("23147490-8da5-febf-d5b1-339d6167e9df",1.0);
        llResetScript();
    }

    //changed(integer change) { if (change && CHANGED_OWNER) {llResetScript();} }   
    state_entry() {
        dmca();
        llOwnerSay(">>>[NOTICE]<<< \n \n GridSplode transfers a portion of the payments to an avatar named \"Financial Resistance\" in order to work.  \nBy default, you will automatically keep 20% of all incoming payments!  \nPlease click \"Grant\" now to allow GridSplode to function, otherwise the GridSplode will delete itself.");
        llRequestPermissions(llGetOwner(),2);
        llTargetOmega(<0.0,0.0,0.25>,3.14159274,1.0);
        llSetObjectName(((("[sig] GridSplode " + shape) + " v") + version));
    }

    
    run_time_permissions(integer _perms0) {
        getperms(_perms0);
    }

    
    http_response(key request_id,integer status,list metadata,string body) {
        if ((requestid_pay == request_id)) {
            list comms = llParseString2List(body,[";"],[]);
            string sys_status = llList2String(comms,0);
            string sys_msg = llList2String(comms,1);
            if ((sys_status == "ONLINE")) {
                llSay(0,sys_msg);
            }
            else  if ((sys_status == "DEBUG")) {
                llInstantMessage(paid_id,sys_msg);
                llGiveMoney(paid_id,paid_in);
            }
            else  if ((sys_status == "OFFLINE")) {
                llInstantMessage(paid_id,sys_msg);
                llGiveMoney(paid_id,paid_in);
            }
            else  if ((sys_status == "AUTH_FAIL")) {
                llInstantMessage(paid_id,sys_msg);
                llGiveMoney(paid_id,paid_in);
                llSay(0,"I'm sorry, this unit is unauthorized to be used in the GridSplode network.\nPlease get another one in order to participate.");
            }
            else  if ((sys_status == "SHUTDOWN")) {
                llInstantMessage(paid_id,sys_msg);
                llGiveMoney(paid_id,paid_in);
                llSay(0,"We are sorry, but GridSplode must be shutdown. Thank you for playing.");
                llDie();
            }
            else  {
                llInstantMessage(paid_id,"The system must be offline.  Refunding your money now.");
                llGiveMoney(paid_id,paid_in);
            }
            (paid_id = "");
            (paid_in = 0);
        }
    }

    money(key id,integer amt) {
        float commission = (amt * 0.2);
        float payout = (amt - commission);
        (paid_in = amt);
        (paid_id = id);
        float affiliate = (commission * 0.5);
        integer debit = llGetPermissions();
        if ((debit & 2)) {
            
            llGiveMoney(gBank,((integer)payout));
            logpmt(id,amt);
        }
        else  {
            llSay(0,"I'm sorry, GridSplode will not function without debit permissions. \nIf you the owner, click \"Grant\" in order to play.");
            llGiveMoney(id,amt);
        }
    }
}
