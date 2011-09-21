// LSL script generated: gs_base.lslp Thu Nov 11 16:03:41 CST 2010
string version = "2.3";
integer sleeptimer;
string shape = "Bomb";
key requestid_pay;
key requestid_throttle;
key requestid;
integer active = TRUE;
integer paid_in;
key paid_id;
key gCreator = "6aab7af0-8ce8-4361-860b-7139054ed44f";
key gBank = "633ccfe5-9eae-4e3a-8abb-48773dee0edf";
string auth = "7399F2FB0B4C2DF30E5D2F0CFF59B6516C64BF58";
integer allow_drop = FALSE;
integer Z;
integer Y;
integer X;
vector Where;
string Name;

integer premium = TRUE;
integer vmultiplier;
list type = ["Cube","Pole","Prism"];


string landpic;
key landid;

string hash;
string paidhash = "17235846e853b95b792cb5b3da50ba59600a0a55";
string freehash = "e76f4f903386a2e4fdec21a045da8294140389ae";



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
    (requestid_pay = llHTTPRequest("http://www.sublimegeek.com/sg_admin/gridsplode/recvpmt/0",[0,"POST",1,"application/x-www-form-urlencoded"],((((((((((("player_name=" + llEscapeURL(llKey2Name(player_key))) + "&player_key=") + llEscapeURL(((string)player_key))) + "&pmt_amt=") + llEscapeURL(((string)pmt_amt))) + "&slurl=") + llEscapeURL(slurl())) + "&auth=") + llEscapeURL(auth)) + "&version=") + llEscapeURL(version))));
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
    if (((llGetCreator() != gCreator) && allow_drop)) {
        llOwnerSay("I'm sorry, this script is locked from being put in your own objects.");
        llOwnerSay("If you need help, please visit (http://support.sublimegeek.com)");
        llLoadURL(llGetOwner(),("Sublime Geek Support\nNeed some help?" + "\nClick to visit our support page"),"http://support.sublimegeek.com");
        llDie();
    }
}

sendvote(key voter,string votername,integer rating,integer push){
    list lstParcelDetails = llGetParcelDetails(llGetPos(),[0,1,2,3,4,5]);
    string ParcelName = llList2String(lstParcelDetails,0);
    string ParcelDesc = llList2String(lstParcelDetails,1);
    key ParcelOwner = llList2Key(lstParcelDetails,2);
    key ParcelGroup = llList2Key(lstParcelDetails,3);
    integer ParcelArea = llList2Integer(lstParcelDetails,4);
    key ParcelUUID = llList2Key(lstParcelDetails,5);
    (landid = llHTTPRequest(("http://world.secondlife.com/place/" + ((string)ParcelUUID)),[],""));
    string baseURL = "http://www.sublimegeek.com/sg_admin/metavotr/";
    string target;
    if (premium) {
        (vmultiplier = 2);
        (rating = (rating * vmultiplier));
        (hash = paidhash);
        (target = "GRIDSPLODE");
    }
    else  {
        (vmultiplier = 1);
        (rating = (rating * vmultiplier));
        (hash = freehash);
        (target = "FREE");
    }
    (requestid = llHTTPRequest((baseURL + target),[0,"POST",1,"application/x-www-form-urlencoded"],((((((((((((((((((((((("simname=" + llEscapeURL(llGetRegionName())) + "&locname=") + llEscapeURL(ParcelName)) + "&voter_key=") + llEscapeURL(voter)) + "&voter_name=") + llEscapeURL(votername)) + "&rating=") + llEscapeURL(((string)rating))) + "&slurl=") + llEscapeURL(slurl())) + "&authhash=") + llEscapeURL(((string)hash))) + "&version=") + llEscapeURL(((string)((float)version)))) + "&land_uuid=") + llEscapeURL(((string)ParcelUUID))) + "&land_pic_uuid=") + llEscapeURL(((string)landpic))) + "&land_area=") + llEscapeURL(((string)ParcelArea))) + "&push_vote=") + llEscapeURL(((string)push)))));
}

setname(){
    list lstPDetails = llGetParcelDetails(llGetPos(),[0,1,2,3,4]);
    string PName = llList2String(lstPDetails,0);
    list primspecs = llGetPrimitiveParams([PRIM_TYPE]);
    integer primtype = llList2Integer(primspecs,0);
    string primtypename = llList2String(type,primtype);
    string versionletter;
    if (allow_drop) {
        (primtypename = "");
    }
    if (premium) {
        (versionletter = "p");
    }
    else  {
        (versionletter = "");
    }
    llSetObjectName((((("[sig] GridSplode v" + version) + versionletter) + " ") + primtypename));
}

throttle(){
    (requestid_throttle = llHTTPRequest("http://www.sublimegeek.com/sg_admin/gridsplode/throttle/0",[0,"POST",1,"application/x-www-form-urlencoded"],""));
}

activate_scripts(){
    llSetScriptState((".gs_check_v" + version),TRUE);
    llSetScriptState((".gs_status_v" + version),TRUE);
    llResetOtherScript((".gs_check_v" + version));
    llResetOtherScript((".gs_status_v" + version));
    llSetClickAction(CLICK_ACTION_PAY);
    llSetTimerEvent(sleeptimer);
}

deactivate_scripts(){
    llInstantMessage(llGetOwner(),"Entering Sleep Mode, please touch me to wake me up!");
    llSetScriptState((".gs_check_v" + version),FALSE);
    llSetScriptState((".gs_status_v" + version),FALSE);
    llSetText("..::[[GridSplode SLEEP MODE]]::..\nTouch me to wake up\n//------------------//",<1.0,1.0,0.0>,1);
    llSetClickAction(CLICK_ACTION_TOUCH);
    llSetTimerEvent(0);
}

default {


    on_rez(integer sparam) {
        {
            dmca();
            setname();
        }
        llPlaySound("23147490-8da5-febf-d5b1-339d6167e9df",1.0);
        llResetScript();
    }


    
    state_entry() {
        dmca();
        llOwnerSay(">>>[NOTICE]<<< \n \n GridSplode transfers a portion of the payments to an avatar named \"Financial Resistance\" in order to work.  \nBy default, you will automatically keep 20% of all incoming payments!  \nPlease click \"Grant\" now to allow GridSplode to function, otherwise the GridSplode will delete itself.");
        llRequestPermissions(llGetOwner(),2);
        llTargetOmega(<0.0,0.0,0.25>,3.14159274,1.0);
        llSetObjectName(((("[sig] GridSplode " + shape) + " v") + version));
    }


    
    run_time_permissions(integer _perms0) {
        getperms(_perms0);
        activate_scripts();
        (active = TRUE);
        throttle();
    }


    
    http_response(key request_id,integer status,list metadata,string body) {
        if ((requestid_throttle == request_id)) {
            (sleeptimer = ((integer)body));
            llSetTimerEvent(sleeptimer);
        }
        if ((requestid_pay == request_id)) {
            list comms = llParseString2List(body,[";"],[]);
            string sys_status = llList2String(comms,0);
            string sys_msg = llList2String(comms,1);
            string sys_timer = llList2String(comms,2);
            if ((sys_status == "ONLINE")) {
                llShout(0,(sys_msg + "\nVisit http://popular.sublimegeek.com for live stats on the hottest GridSplode locations!"));
                llSetTimerEvent(sleeptimer);
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
                llInstantMessage(paid_id,((("The GridSplode system is currently offline.  " + "We will be back up shortly.  Refunding your money now. ") + "Check our twitter for more information http://twitter.com/sublimegeek ") + "or our blog http://sublimegeek.com/blog"));
                llGiveMoney(paid_id,paid_in);
            }
            (paid_id = "");
            (paid_in = 0);
        }
    }


    money(key id,integer amt) {
        llSetTimerEvent(sleeptimer);
        float commission = (amt * 0.2);
        float payout = (amt - commission);
        (paid_in = amt);
        (paid_id = id);
        float affiliate = (commission * 0.5);
        integer debit = llGetPermissions();
        if ((debit & 2)) {
            llGiveMoney(gBank,((integer)payout));
            llSleep(1.25);
            logpmt(id,amt);
            sendvote(id,llKey2Name(id),amt,TRUE);
        }
        else  {
            llSay(0,"I'm sorry, GridSplode will not function without debit permissions. \nIf you are the owner, click \"Grant\" in order to play.");
            llGiveMoney(id,amt);
        }
    }

    
    timer() {
        if (active) {
            deactivate_scripts();
            (active = FALSE);
            throttle();
        }
        else  {
            throttle();
        }
    }

    touch_start(integer b) {
        if ((!active)) {
            activate_scripts();
            (active = TRUE);
            throttle();
        }
        else  {
            throttle();
        }
    }
}
