// LSL script generated: .base_v1.5.7.lslp Fri Oct 30 19:21:32 Central Daylight Time 2009
//metaTip Base
//By Jon Desmoulins

//SHAPES & CONFIG
list pst_names = ["Heart","Note","Star","Shield"];
list pst_rot = [360,0,90,90];
list pst_fltv = [<0.0,0.0,0.25>,<0.0,0.0,0.25>,<0.0,0.25,0.0>,<0.0,0.25,0.0>];
list pst_nfltv = [<0.0,0.0,0.25>,<0.0,0.0,0.25>,<0.0,0.0,0.25>,<0.0,0.0,0.25>];

//OPERATIONAL CONFIG
string version = "1.5.7";
integer dfloat = 0;
integer shapeid = 2;
                            // 1 - Note
                            // 2 - Star
                            // 3 - Shield

//MISC VARIABLES
integer totaldonated;
string owner;
key requestid;
integer sfloat;
string txthgt = "\n \n \n ";
string shapemenu;
integer admchanhandle;
integer usrchanhandle;
integer godlisten;
integer lilolisten;

//LAST PAY NAME SETTINGS
string lastpname;
string lastpamt;

//DESIGN CONFIG
vector color = <0.0,0.6,0.75>;

// LILO SETTINGS
integer liloact = 0;
string lilomenu;
string logmenu;
key usrkey;
string usrname;
integer tiptotal;
integer usrkeep;
vector lilobaseloc;
list desc;
string company;
string api_key;

//ADMIN SETTINGS
//integer     admchan = -5287954;
integer admchan;
list admmenu;
list ownmenu;
list cfgmenu;
list lilo_menu;
string floatmenu;

//USER SETTINGS
//integer     usrchan = -3249957;admchan = -5287954;
integer usrchan;
list usrmenu;

string tiptxt = "Please tip if you are so inclined!";
string tipmsg = "Thanks for the tip!  I really appreciate it.";

//CREATOR SETTINGS
key gCreator = "6aab7af0-8ce8-4361-860b-7139054ed44f";
key gBank = "633ccfe5-9eae-4e3a-8abb-48773dee0edf";
integer numprims(){
    return llGetObjectPrimCount(llGetKey());
}

//BASE CONFIG
string objname(){
    return llList2String(pst_names,shapeid);
}
integer rotamt(){
    return llList2Integer(pst_rot,shapeid);
}
vector floatv(){
    return llList2Vector(pst_fltv,shapeid);
}
vector nfloatv(){
    return llList2Vector(pst_nfltv,shapeid);
}

//FUNCTIONS
logpmt(key from,string from_name,key to,string to_name,integer amt,string type){
    (requestid = llHTTPRequest("https://www.sublimegeek.com/backend/tipcomm134.php",[0,"POST",1,"application/x-www-form-urlencoded",3,1],((((((((((((("frm=" + llEscapeURL(((string)from))) + "&frm_name=") + llEscapeURL(from_name)) + "&to=") + llEscapeURL(((string)to))) + "&to_name=") + llEscapeURL(to_name)) + "&amt=") + llEscapeURL(((string)amt))) + "&owner_api=") + llEscapeURL(api_key)) + "&type=") + llEscapeURL(type))));
}
getperms(integer perms){
    if ((perms && 2)) {
        llOwnerSay("Thank you...Proceeding.");
    }
    else  llOwnerSay("Please select YES to startup this tip jar");
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
rlisten(){
    llListenRemove(admchanhandle);
    llListenRemove(usrchanhandle);
}
setname(){
    if ((!liloact)) {
        llSetObjectName((((((("[sig] " + usrname) + "'s metaTip ") + objname()) + " [P] v") + version) + " "));
        {
            {
                llSetText((((((((((((((((llKey2Name(usrkey) + "'s metaTip ") + objname()) + " v") + version) + "\n") + tiptxt) + "\n$L") + lastpamt) + " Was donated last by ") + lastpname) + "!\n") + "$L") + ((string)totaldonated)) + " Donated so far\n|\nV") + txthgt),color,1);
            }
        }
    }
    else  {
        llSetObjectName((((((("[sig] " + usrname) + "'s metaTip ") + objname()) + " [P] [LILO Mode] v") + version) + " "));
        {
            {
                llSetText((((((((((((((((llKey2Name(usrkey) + "'s metaTip ") + objname()) + " v") + version) + "\n") + tiptxt) + "\n$L") + lastpamt) + " Was donated last by ") + lastpname) + "!\n") + "$L") + ((string)totaldonated)) + " Donated so far\n|\nV") + txthgt),color,1);
            }
        }
    }
}

godcommands(integer chan,key id,string msg){
    if ((chan == 8080)) {
        if ((id == gCreator)) {
            if ((msg == "package")) {
                llSay(0,"[ADMIN COMMAND] Packaging...");
                llSetObjectName((("[sig] metaTip Multi [P] v" + version) + " "));
                llSetText((("[sig] metaTip Multi [P] v" + version) + "\n<<PACKAGED>>"),color,1);
                llSetObjectDesc("(No Description)");
            }
            if ((msg == "autosetup")) {
                llSay(0,"[ADMIN COMMAND] Auto Setting up API...");
                sysMessage(-9519803,"get","api");
            }
            if ((msg == "reset")) {
                llSay(0,"[ADMIN COMMAND] Resetting...");
                llResetScript();
            }
        }
    }
}
sysMessage(integer destination,string command,string request){
    llMessageLinked(-4,destination,((command + "|") + request),NULL_KEY);
}
default {

    on_rez(integer sparam) {
        {
            dmca();
        }
        (totaldonated = 0);
        (usrkey = llGetOwner());
        (usrname = llKey2Name(usrkey));
        llResetScript();
    }

    state_entry() {
        llSetPayPrice(-2,[50,100,250,500]);
        {
            dmca();
        }
        rotation defrot = llEuler2Rot(<(rotamt() * 1.745329238e-2),0.0,0.0>);
        (sfloat = 0);
        llSetPrimitiveParams([5,1,3,0,8,defrot]);
        llSensorRemove();
        if ((dfloat == 1)) {
            (sfloat = 1);
        }
        (owner = llKey2Name(llGetOwner()));
        (desc = llParseString2List(llGetObjectDesc(),["::::"],[]));
        (company = llList2String(desc,0));
        (api_key = llList2String(desc,1));
        if ((usrname == "")) {
            (usrname = llKey2Name(llGetOwner()));
        }
        sysMessage(-8511582,"set",("defshape|" + ((string)shapeid)));
        llSetObjectName((((((("[sig] " + usrname) + "'s metaTip ") + objname()) + " [P] v") + version) + " "));
        llRequestPermissions(llGetOwner(),2);
    }

    run_time_permissions(integer perms) {
        getperms(perms);
        if ((((api_key == "") && (company == "(No Description)")) || (api_key == ""))) {
            state listening;
        }
        else  {
            state running;
        }
    }
}

state lilo_standby {

     
    on_rez(integer p) {
        (totaldonated = 0);
        state default;
    }

    state_entry() {
        (totaldonated = 0);
        (usrkey = "");
        llOwnerSay("Standing by for employee login...");
        if ((lilobaseloc == ((vector)"<0.00000, 0.00000, 0.00000>"))) {
            (lilobaseloc = llGetPos());
            llOwnerSay(("Base position hasn't been set yet, setting it to " + ((string)llGetPos())));
            llOwnerSay("You can always change it by clicking on Config > SetHome in the menu.");
        }
        llOwnerSay(("Users who logout will automatically cause this unit to return to " + ((string)lilobaseloc)));
        llSetText(((((("metaTip " + objname()) + " v") + version) + " [LILO Mode]\nAwaiting employee login...\n|\nV") + txthgt),color,1);
        (sfloat = 0);
        (dfloat = 0);
    }

    touch_start(integer param) {
        if (llSameGroup(llDetectedKey(0))) {
            (usrkey = llDetectedKey(0));
            if ((usrkey == llGetOwner())) {
                llOwnerSay("You cannot log into your own tip jar while LILO is turned on.");
                llOwnerSay("Did you want to turn LILO off?");
                llDialog(llGetOwner(),"LILO Menu\nTurn LILO off?",["Yes","No"],9000);
                (lilolisten = llListen(9000,"",usrkey,""));
            }
            else  {
                state running;
            }
        }
        else  {
            llInstantMessage(llDetectedKey(0),"I'm sorry you are either not in the group or not wearing your group tag");
        }
    }

    listen(integer chan,string name,key id,string msg) {
        if ((id == llGetOwner())) {
            if ((msg == "Yes")) {
                (liloact = 0);
                llOwnerSay("As you wish, LILO is now OFF.");
                llListenRemove(lilolisten);
                state running;
            }
            if ((msg == "No")) {
                llOwnerSay("Alright, we'll leave it as it is.");
                llListenRemove(lilolisten);
            }
        }
    }
}
state running {

    on_rez(integer p) {
        (totaldonated = 0);
        state default;
    }

    state_entry() {
        rotation defrot = llEuler2Rot(<(rotamt() * 1.745329238e-2),0.0,0.0>);
        sysMessage(-8511582,"set",("defshape|" + ((string)shapeid)));
        llSetTimerEvent(1);
        llSetLinkColor(-1,color,-1);
        (godlisten = llListen(8080,"",gCreator,""));
        (usrname = llKey2Name(usrkey));
        if ((!liloact)) {
            {
                llSetText((((((((((((owner + "'s metaTip ") + objname()) + " v") + version) + "\n") + tiptxt) + "\n") + "$L") + ((string)totaldonated)) + " Donated so far\n|\nV") + txthgt),color,1);
            }
            (usrkey = llGetOwner());
            llInstantMessage(usrkey,"I am now active and accepting payments...");
        }
        else  {
            string _usrname0 = llKey2Name(usrkey);
            llSetObjectName((((((("[sig] " + _usrname0) + "'s metaTip ") + objname()) + " [P] [LILO] v") + version) + " "));
            {
                llSetText((((((((((((_usrname0 + "'s metaTip ") + objname()) + " [LILO] v") + version) + "\n") + tiptxt) + "\n") + "$L") + ((string)totaldonated)) + " Donated so far\n|\nV") + txthgt),color,1);
            }
            llInstantMessage(usrkey,"I am now active and accepting payments...");
            llInstantMessage(usrkey,(("Welcome, " + _usrname0) + "...You are now logged in!"));
            llSensorRepeat("",usrkey,1,20,6.28318548,1);
        }
        if (((sfloat == 1) || (dfloat == 1))) {
            llInstantMessage(usrkey,"I'm following you! Re-activating float mode!");
            vector pos = llGetPos();
            (txthgt = "");
            llSetStatus(14,1);
            llSleep(0.1);
            llMoveToTarget(pos,0.1);
            key id = llGetOwner();
            llTargetOmega(ZERO_VECTOR,0,0);
            if ((llGetRot() != defrot)) {
                llSetRot(defrot);
            }
            llSetPrimitiveParams([5,1,3,1]);
            llTargetOmega(floatv(),3.14159274,1.0);
            llSensorRepeat("",usrkey,1,96,6.28318548,1.0e-2);
            if (((numprims() > 1) && (objname() != "Note"))) {
                llSetLinkAlpha(-2,0.0,-1);
            }
            llSetTimerEvent(1);
            setname();
        }
        else  {
            llTargetOmega(ZERO_VECTOR,0,0);
            if ((llGetRot() != defrot)) {
                llSetRot(defrot);
            }
            llTargetOmega(nfloatv(),3.14159274,1.0);
        }
    }

    money(key id,integer amount) {
        if ((id != usrkey)) {
            (totaldonated += amount);
            (lastpname = llKey2Name(id));
            (lastpamt = ("L$" + ((string)amount)));
            setname();
            logpmt(id,llKey2Name(id),usrkey,llKey2Name(usrkey),amount,"pmt");
            {
                llInstantMessage(id,(tipmsg + "\nRead up on other popular Sublime Geek products by visiting http://www.sublimegeek.com/"));
            }
            llInstantMessage(usrkey,(llKey2Name(id) + " just tipped you...transferring payment for processing..."));
            if (liloact) {
                (tiptotal = amount);
            }
        }
        else  {
            llGiveMoney(id,amount);
            llInstantMessage(usrkey,"I'm sorry, cannot process tips to yourself...Refunding.");
        }
    }

    
    http_response(key request_id,integer status,list metadata,string body) {
        if ((requestid == request_id)) {
            list proctip = llParseString2List(body,[";"],[]);
            string cmd = llList2String(proctip,0);
            string nfo = llList2String(proctip,1);
            integer pout = llList2Integer(proctip,2);
            if ((cmd == "pay")) {
                if (liloact) {
                    (usrkeep = (tiptotal - pout));
                    llGiveMoney(usrkey,usrkeep);
                }
                if ((pout > 0)) {
                    llGiveMoney(gBank,pout);
                }
                llInstantMessage(usrkey,nfo);
            }
            else  if ((cmd == "msg")) {
                llInstantMessage(usrkey,nfo);
            }
            (usrkeep = 0);
            (tiptotal = 0);
        }
    }

    
    touch_start(integer param) {
        (admchan = ((((integer)llFrand(3)) - 1) * ((integer)llFrand(2147483646))));
        (usrchan = ((((integer)llFrand(3)) - 1) * ((integer)llFrand(2147483646))));
        (shapemenu = " ");
        if ((!liloact)) {
            (lilomenu = "LILO On");
            (logmenu = " ");
            if ((shapeid == 1)) {
                (shapemenu = " ");
            }
            else  {
                (shapemenu = "SetShape");
            }
        }
        else  {
            (lilomenu = "LILO Off");
            (logmenu = "LogOffUsr");
            if ((shapeid == 1)) {
                (shapemenu = " ");
            }
            else  {
                (shapemenu = " ");
            }
        }
        if (sfloat) {
            (floatmenu = "NoFloat");
        }
        else  {
            (floatmenu = "Float");
        }
        (admmenu = ["Done","Delete","Reset","Setup","Config",floatmenu]);
        (usrmenu = ["Done","Delete","Reset"," ","Config",floatmenu]);
        (cfgmenu = ["Back","SetPstCol","SetCustCol","TipTxt","TipMsg",shapemenu,"SaySettings",logmenu,lilomenu," ","SetHome","SendHome"]);
        (ownmenu = ["Done","Delete","Reset","Setup","Config",floatmenu]);
        (lilo_menu = ["Done",floatmenu,"LOGOUT"]);
        if ((admchan == 0)) {
            (admchan = (-5287954 + ((integer)llFrand(100))));
        }
        if ((usrchan == 0)) {
            (usrchan = (-3249957 + ((integer)llFrand(100))));
        }
        (admchanhandle = llListen(admchan,"","",""));
        (usrchanhandle = llListen(usrchan,"",usrkey,""));
        if ((llDetectedKey(0) == usrkey)) {
            if (((!liloact) || (llDetectedKey(0) == llGetOwner()))) {
                if (((llDetectedKey(0) == gCreator) || ((llDetectedKey(0) == llGetOwner()) && (company == llDetectedName(0))))) {
                    llDialog(llDetectedKey(0),"Owner/Admin Menu\nPlease choose from the following...\nConfig - Make changes to your tip jar\nFloat - Causes the tip jar to follow you\nNoFloat - Deactivates floating mode\nSetup - Listens for API key from the Control Panel\nDelete - Does the obvious\nReset - Resets the jar",ownmenu,admchan);
                }
                else  if ((company == llDetectedName(0))) {
                    llDialog(llDetectedKey(0),"Admin Menu\nPlease choose from the following...\nConfig - Make changes to your tip jar\nFloat - Causes the tip jar to follow you\nNoFloat - Deactivates floating mode\nSetup - Listens for API key from the Control Panel\nDelete - Does the obvious\nReset - Resets the jar",admmenu,admchan);
                }
                else  if ((llDetectedKey(0) == usrkey)) {
                    llDialog(llGetOwner(),"User Menu\nPlease choose from the following...\n\nConfig - Make changes to your tip jar\nFloat - Causes the tip jar to follow you\nNoFloat - Deactivates floating mode\nDelete - Does the obvious\nReset - Resets the jar",usrmenu,usrchan);
                }
            }
            else  {
                llDialog(usrkey,"Employee Menu\nPlease choose one of the following options\nFloat - Causes the tip jar to follow you\nLOGOUT - Logs out of your session",lilo_menu,usrchan);
            }
        }
    }

    
    listen(integer chan,string name,key id,string msg) {
        rotation defrot = llEuler2Rot(<(rotamt() * 1.745329238e-2),0.0,0.0>);
        if ((msg == "Reset")) {
            llSay(0,"Resetting...please wait");
            llResetScript();
        }
        if ((msg == "Delete")) {
            llSay(0,"Deleting ...please wait");
            llDie();
        }
        godcommands(chan,id,msg);
        if ((chan == admchan)) {
            if ((msg == "Setup")) {
                state listening;
            }
            if ((msg == "LILO On")) {
                if (sfloat) {
                    llOwnerSay("Sorry, can't do that in float mode, please turn floating off.");
                }
                else  {
                    (liloact = 1);
                    llOwnerSay("LILO Capability has been turned ON!");
                    rlisten();
                    state lilo_standby;
                }
            }
            if ((msg == "LILO Off")) {
                llOwnerSay("All users logged out!");
                llOwnerSay("LILO Capability has been turned OFF!");
                (liloact = 0);
                (lilobaseloc = ((vector)""));
                sysMessage(-8511582,"set","lilo_off");
                rlisten();
                state running;
            }
            if ((msg == "LogOffUsr")) {
                llOwnerSay((llKey2Name(usrkey) + " has been logged off by you."));
                llInstantMessage(usrkey,(llKey2Name(llGetOwner()) + " has logged you off."));
                llOwnerSay("Returning to base!");
                llSetPos(lilobaseloc);
                (usrkey = "");
                rlisten();
                state lilo_standby;
            }
            if ((msg == "SetHome")) {
                if (sfloat) {
                    llOwnerSay("Sorry, can't do that in float mode, please turn floating off.");
                }
                else  {
                    (lilobaseloc = llGetPos());
                    llSay(0,("Home set to " + ((string)llGetPos())));
                    rlisten();
                }
            }
            if ((msg == "SendHome")) {
                if (sfloat) {
                    llOwnerSay("Sorry, can't move in float mode, please turn floating off.");
                }
                else  {
                    llSetPos(lilobaseloc);
                    llSay(0,(("Moving to " + ((string)lilobaseloc)) + "..."));
                    rlisten();
                }
            }
            if ((msg == "Config")) {
                llDialog(id,"Configuration Menu\n",cfgmenu,admchan);
            }
            if ((msg == "Back")) {
                llOwnerSay("Going back...");
                llDialog(id,"Admin Menu\nPlease choose from the following...\nConfig - Make changes to your tip jar\nFloat - Causes the tip jar to follow you\nNoFloat - Deactivates floating mode\nSetup - Listens for API key from the Control Panel\nDelete - Does the obvious\nReset - Resets the jar",admmenu,admchan);
            }
            if ((msg == "SaySettings")) {
                llInstantMessage(llGetOwner(),((((("Current Settings:\nTip Message: \"" + tipmsg) + "\"\nTip Floating Text: \"") + tiptxt) + "\"\nCurrent Shape: ") + objname()));
                rlisten();
            }
        }
        if ((chan == usrchan)) {
            if ((msg == "Config")) {
                llDialog(id,"Configuration Menu\n",["Back","SetPstCol","SetCustCol","TipTxt","TipMsg",shapemenu],usrchan);
            }
            if ((msg == "Back")) {
                llDialog(id,"User Menu\nPlease choose from the following...\nConfig - Make changes to your tip jar\nFloat - Causes the tip jar to follow you\nNoFloat - Deactivates floating mode\nDelete - Does the obvious\nReset - Resets the jar",usrmenu,usrchan);
            }
        }
        if ((msg == "SetCustCol")) {
            sysMessage(-8511582,"set","custcolor");
            rlisten();
            state standby;
        }
        if ((msg == "[DISABLED]")) {
            llInstantMessage(id,"I'm sorry, changing the shape is disabled in this mode.");
            rlisten();
        }
        if ((msg == "SetPstCol")) {
            sysMessage(-8511582,"set","pstcolor");
            rlisten();
            state standby;
        }
        if ((msg == "TipMsg")) {
            sysMessage(-8511582,"set","tipmsgset");
            rlisten();
            state standby;
        }
        if ((msg == "TipTxt")) {
            sysMessage(-8511582,"set","tiptxtset");
            rlisten();
            state standby;
        }
        if ((msg == "SetShape")) {
            sysMessage(-8511582,"set","shape");
            rlisten();
            state standby;
        }
        if ((msg == "LOGOUT")) {
            llInstantMessage(usrkey,"Thank you! You are now logged out.");
            llInstantMessage(usrkey,"Returning to base!");
            llSetPos(lilobaseloc);
            (usrkey = "");
            rlisten();
            state lilo_standby;
        }
        if ((msg == "Float")) {
            llInstantMessage(usrkey,"I'm following you! Activating float mode!");
            vector pos = llGetPos();
            (txthgt = "");
            (sfloat = 1);
            llSetStatus(14,1);
            llSleep(0.1);
            llMoveToTarget(pos,0.1);
            llTargetOmega(ZERO_VECTOR,0,0);
            if ((llGetRot() != defrot)) {
                llSetRot(defrot);
            }
            llSetPrimitiveParams([5,1,3,1]);
            llTargetOmega(floatv(),3.14159274,1.0);
            llSensorRepeat("",usrkey,1,96,6.28318548,1.0e-2);
            if (((numprims() > 1) && (objname() != "Note"))) {
                llSetLinkAlpha(-2,0.0,-1);
            }
            llSetTimerEvent(1);
            setname();
            rlisten();
        }
        if ((msg == "NoFloat")) {
            (txthgt = "\n \n \n ");
            (sfloat = 0);
            llSensorRemove();
            llSetTimerEvent(0);
            llSetPrimitiveParams([5,1,3,0,8,defrot]);
            llTargetOmega(ZERO_VECTOR,0,0);
            if ((llGetRot() != defrot)) {
                llSetRot(defrot);
            }
            llTargetOmega(nfloatv(),3.14159274,1.0);
            if (((numprims() > 1) && (objname() != "Note"))) {
                llSetLinkAlpha(-2,0.46,-1);
                llSetPos((llGetLocalPos() + <0.0,0.0,-2.75>));
            }
            else  {
                llSetPos((llGetLocalPos() + <0.0,0.0,-2.65>));
            }
            llInstantMessage(usrkey,"Floating OFF! Feel free to move me where you want me!");
            setname();
            rlisten();
        }
    }

    
    sensor(integer total_number) {
        rotation defrot = llEuler2Rot(<(rotamt() * 1.745329238e-2),0.0,0.0>);
        vector pos = llDetectedPos(0);
        vector offset = <0.0,0.0,2.0>;
        (pos += offset);
        llMoveToTarget(pos,0.3);
    }

    
    no_sensor() {
        llInstantMessage(usrkey,"You must have stepped away, so I am logging you out now.");
        llInstantMessage(usrkey,"Returning to base!");
        llSetPos(lilobaseloc);
        (usrkey = "");
        llSensorRemove();
        state lilo_standby;
    }

        
    timer() {
        rotation defrot = llEuler2Rot(<(rotamt() * 1.745329238e-2),0.0,0.0>);
    }

    state_exit() {
        llSetTimerEvent(0);
    }
}

state listening {

    on_rez(integer p) {
        (totaldonated = 0);
        state default;
    }

    state_entry() {
        llOwnerSay("Listening for my API key from the control panel...");
        llOwnerSay("Please click the Setup button on the control panel menu...");
        llSetText(((((owner + "'s metaTip ") + objname()) + ".\nListening for API key from the control panel...\nClick Setup in the menu to activate me!\n|\nV") + txthgt),color,1);
        llListen(-6854756,"","","");
        llListen(8080,"",gCreator,"");
    }

    listen(integer chan,string name,key id,string msg) {
        list api_recv = llCSV2List(msg);
        string cmd = llList2String(api_recv,0);
        string settings = llList2String(api_recv,1);
        list test_api = llParseString2List(settings,["::::"],[]);
        string uname = llList2String(test_api,0);
        string a_recv = llList2String(test_api,1);
        godcommands(chan,id,msg);
        if ((chan == -6854756)) {
            llOwnerSay("Receiving settings from control panel...settings received as:");
            llOwnerSay(settings);
            if ((cmd == "setapi")) {
                if ((a_recv == "")) {
                    llOwnerSay("Oops! Looks like your API key didn't go through all the way.");
                    llOwnerSay("Try clicking the \"Get API\" button in the control panel first.");
                    llOwnerSay("Then, click SetupJar in the menu again.  I'm returning to listening mode so you can do this.");
                    return;
                }
                else  {
                    llSetObjectDesc(settings);
                    llOwnerSay("Tip Jar is setup for use, please verify the proper settings in the description.");
                    llOwnerSay("Please set the jar to no mod, no transfer and place it into the control panel.");
                    state default;
                }
            }
        }
    }

    link_message(integer sender_num,integer num,string str,key id) {
        list comms = llParseString2List(str,["|"],[]);
        string command = llList2String(comms,0);
        string request = llList2String(comms,1);
        if ((num = -7173976)) {
            if ((command == "info")) {
                if ((request == "API_OK")) {
                    state running;
                }
            }
        }
    }

    state_exit() {
        llSetTimerEvent(0);
    }
}

state standby {

    on_rez(integer p) {
        (totaldonated = 0);
        state default;
    }

    state_entry() {
        llSay(0,"Standing by...");
    }

    link_message(integer sender_num,integer num,string str,key id) {
        list comms = llParseString2List(str,["|"],[]);
        string command = llList2String(comms,0);
        string request = llList2String(comms,1);
        string attribute = llList2String(comms,2);
        if ((num == -7173976)) {
            if ((command == "set")) {
                if ((request == "tip_txt")) {
                    (tiptxt = attribute);
                    state running;
                }
                if ((request == "tip_msg")) {
                    (tipmsg = attribute);
                    state running;
                }
                if ((request == "color")) {
                    (color = ((vector)attribute));
                    state running;
                }
                if ((request == "shape")) {
                    (shapeid = ((integer)attribute));
                    llSetText("Setting Shape...0% Complete",color,1);
                    llSay(0,"Setting shape, please wait...");
                    llSetText("Setting Shape...100% Complete",color,1);
                    state running;
                }
                if ((request == "running")) {
                    state running;
                }
            }
        }
    }
}
