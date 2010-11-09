// LSL script generated: gs_base.lslp Mon Nov  8 19:26:03 CST 2010
//GridSplode Base
//By Jon Desmoulins
//Original Concept by Monkey Canning

//OPERATIONAL CONFIG
string version = "1.0";
string auth = "ED20F44C5B3A71A345189ACFBA0C25A16F11D960";
integer drop = FALSE;
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

//AFFILIATE SETTINGS
integer AFF_MODE = FALSE;
key AFFILIATE = "";

//FUNCTIONS
string slurl(){
    (Name = llGetRegionName());
    (Where = llGetPos());
    (X = ((integer)Where.x));
    (Y = ((integer)Where.y));
    (Z = ((integer)Where.z));
    string SLURL = ((((((((("http://slurl.com/secondlife/" + Name) + "/") + ((string)X)) + "/") + ((string)Y)) + "/") + ((string)Z)) + "/?title=") + Name);
    return SLURL;
}
logpmt(key player_key,integer pmt_amt){
    (requestid_pay = llHTTPRequest("http://www.sublimegeek.com/backend/gsplode_recv_pmt.php",[HTTP_METHOD,"POST",HTTP_MIMETYPE,"application/x-www-form-urlencoded"],((((((((((("player_name=" + llEscapeURL(llKey2Name(player_key))) + "&player_key=") + llEscapeURL(((string)player_key))) + "&pmt_amt=") + llEscapeURL(((string)pmt_amt))) + "&slurl=") + llEscapeURL(slurl())) + "&auth=") + llEscapeURL(auth)) + "&version=") + llEscapeURL(version))));
}
getperms(integer perms){
    if ((perms && PERMISSION_DEBIT)) {
        llOwnerSay("Thank you...Proceeding.");
        llOwnerSay("I'm active and accepting payments");
        llPlaySound("a3c3d7f5-a01b-9365-672d-4507ab281fc3",1.0);
    }
    else  {
        llOwnerSay("Please rez and new GridSploder and select YES to startup this GridSploder");
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
        if ((!drop)) {
            dmca();
        }
        llPlaySound("23147490-8da5-febf-d5b1-339d6167e9df",1.0);
        llResetScript();
    }

    changed(integer change) {
        if ((change && CHANGED_OWNER)) {
            llResetScript();
        }
    }

    state_entry() {
        dmca();
        llRequestPermissions(llGetOwner(),PERMISSION_DEBIT);
        llTargetOmega(<0,0,0.25>,PI,1.0);
    }

    
    run_time_permissions(integer perms) {
        getperms(perms);
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
        if (AFF_MODE) {
            llGiveMoney(AFFILIATE,((integer)affiliate));
        }
        llGiveMoney(gBank,((integer)payout));
        logpmt(id,amt);
    }
}
