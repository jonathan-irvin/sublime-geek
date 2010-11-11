// LSL script generated: metacast_hud.lslp Thu Nov 11 16:01:11 CST 2010
//MetaCast Controller

string version = "1.4";

key reqid;
integer stopwatch;
integer admchanhandle;
integer admchan;
integer DEBUG = FALSE;
integer configactive = FALSE;
integer power = TRUE;
integer broadcasting = FALSE;

vector pwron = <0.48627000000000004,0.74902,1.0>;
vector pwroff = <0.33333,0.33333,0.33333>;

list menu = ["Stats","AutoDJ","Server","AdminPage","Support","StreamPage","Power","Reset"];

//Notecard Settings
string username;
string password;

integer line;
key queryhandle;
key notecarduuid;
string notecard_name = ".metacast_controller_config";

//Functions
request(string type){
    (reqid = llHTTPRequest(((("http://www.sublimegeek.com/sg_admin/metacast/" + type) + "/") + llEscapeURL(username)),[0,"POST",1,"application/x-www-form-urlencoded"],("mccpass=" + llEscapeURL(password))));
}
command(string type,string status){
    (reqid = llHTTPRequest(((("http://www.sublimegeek.com/sg_admin/metacast/" + type) + "/") + llEscapeURL(username)),[0,"POST",1,"application/x-www-form-urlencoded"],((("mccpass=" + llEscapeURL(password)) + "&state=") + llEscapeURL(status))));
}
acct(string type,string attr){
    (reqid = llHTTPRequest(((("http://www.sublimegeek.com/sg_admin/metacast/" + type) + "/") + llEscapeURL(username)),[0,"POST",1,"application/x-www-form-urlencoded"],((("mccpass=" + llEscapeURL(password)) + "&attr=") + llEscapeURL(attr))));
}

string float2string(float input){
    string result = ((string)input);
    integer i = llStringLength(result);
    while ((llGetSubString(result,(--i),i) == "0"));
    (result = llDeleteSubString(result,(i + 1),llStringLength(result)));
    integer dot = (llStringLength(result) - 1);
    if ((llGetSubString(result,dot,dot) == ".")) (result = llDeleteSubString(result,dot,dot));
    return result;
}

init(){
    llOwnerSay("Reading configuration...");
    llSetLinkColor(LINK_SET,<0.75,0.75,0>,ALL_SIDES);
    llSetText((llGetObjectName() + "\nReading configuration...\n \n \n"),<1,1,1>,1);
    (queryhandle = llGetNotecardLine(notecard_name,(line = 0)));
    (notecarduuid = llGetInventoryKey(notecard_name));
}
color(){
    if (power) {
        llSetLinkColor(0,pwron,ALL_SIDES);
        llSetLinkColor(1,pwron,ALL_SIDES);
        llSetLinkColor(2,pwron,ALL_SIDES);
        llSetLinkColor(3,pwron,ALL_SIDES);
        llSetLinkColor(4,pwron,ALL_SIDES);
        llSetLinkColor(5,pwron,ALL_SIDES);
    }
    else  {
        llSetLinkColor(0,pwroff,ALL_SIDES);
        llSetLinkColor(1,pwroff,ALL_SIDES);
        llSetLinkColor(2,pwroff,ALL_SIDES);
        llSetLinkColor(3,pwroff,ALL_SIDES);
        llSetLinkColor(4,pwroff,ALL_SIDES);
        llSetLinkColor(5,pwroff,ALL_SIDES);
    }
    if (broadcasting) {
        llSetLinkColor(8,<1,1,0>,ALL_SIDES);
        llSetLinkColor(7,<1,1,0>,ALL_SIDES);
        llSetLinkColor(6,<1,1,0>,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(8,1,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(7,1,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(6,1,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(8,0,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(7,0,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(6,0,ALL_SIDES);
        llSleep(0.25);
    }
    else  {
        llSetLinkAlpha(8,0,ALL_SIDES);
        llSetLinkAlpha(7,0,ALL_SIDES);
        llSetLinkAlpha(6,0,ALL_SIDES);
    }
}

default {

    changed(integer change) {
        if ((change & CHANGED_INVENTORY)) {
            if ((notecarduuid != llGetInventoryKey(notecard_name))) {
                init();
            }
        }
    }

    on_rez(integer start) {
        llResetScript();
    }

    state_entry() {
        (stopwatch = 0);
        llSetObjectName(("[sig] MetaCast Controller v" + version));
        llSetText((llGetObjectName() + "\nWaiting for status update...\n \n \n"),<1,1,1>,1);
        color();
        init();
        llSetTimerEvent(1);
    }

    
    timer() {
        if (((stopwatch == 0) || (stopwatch == 30))) {
            if (configactive) {
                request("status");
            }
        }
        if ((stopwatch <= 59)) {
            (++stopwatch);
        }
        else  {
            (stopwatch = 0);
        }
    }


    touch_start(integer total_number) {
        (admchan = ((((integer)llFrand(3)) - 1) * ((integer)llFrand(2147483646))));
        if ((admchan == 0)) {
            (admchan = ((-5287954) + ((integer)llFrand(100))));
        }
        (admchanhandle = llListen(admchan,"",llGetOwner(),""));
        if ((configactive && power)) {
            llDialog(llDetectedKey(0),("MetaCast Cloud Controller\n" + "Make your selection..."),menu,admchan);
        }
        else  if ((!configactive)) {
            llOwnerSay("Config still loading, please wait a moment.");
        }
        else  if ((!power)) {
            llDialog(llDetectedKey(0),("MetaCast Cloud Controller\n" + "Make your selection..."),["HUD On"],admchan);
        }
        integer i;
        for ((i = 0); (i < total_number); (++i)) {
        }
    }

    
    listen(integer channel,string name,key id,string msg) {
        if (DEBUG) {
            llOwnerSay(((((string)channel) + ": ") + msg));
        }
        if (((id == llGetOwner()) && (channel == admchan))) {
            if ((msg == "Back")) {
                llDialog(id,("MetaCast Cloud Controller\n" + "Make your selection..."),menu,admchan);
            }
            if ((msg == "Power")) {
                if ((!power)) {
                    llDialog(id,(("MetaCast Cloud Controller\n" + "HUD Power Menu\n") + "Make your selection..."),["HUD On"],admchan);
                }
                else  {
                    llDialog(id,(("MetaCast Cloud Controller\n" + "HUD Power Menu\n") + "Make your selection..."),["HUD Off"],admchan);
                }
            }
            if ((msg == "Server")) {
                llDialog(id,(("MetaCast Cloud Controller\n" + "Server Menu\n") + "Make your selection..."),["Start","Stop","Back","Restart","Reload"],admchan);
            }
            if ((msg == "AutoDJ")) {
                llDialog(id,(("MetaCast Cloud Controller\n" + "AutoDJ Menu\n") + "Make your selection..."),["StartAuto","KillAuto","Back","NextSong"],admchan);
            }
            if ((msg == "Stats")) {
                llDialog(id,(("MetaCast Cloud Controller\n" + "AutoDJ Menu\n") + "Make your selection..."),["GetSongs","Bandwidth","Back","DiskSpace"],admchan);
            }
            if (((((msg == "Start") || (msg == "Stop")) || (msg == "Restart")) || (msg == "Reload"))) {
                command(llToLower(msg),"");
            }
            if ((msg == "GetAcctInfo")) {
                request("getaccount");
            }
            if ((msg == "GetSongs")) {
                request("getsongs");
            }
            if ((msg == "Bandwidth")) {
                acct("getaccount","bandwidth");
            }
            if ((msg == "DiskSpace")) {
                acct("getaccount","disk");
            }
            if ((msg == "StartAuto")) {
                command("switchsource","up");
            }
            if ((msg == "KillAuto")) {
                command("switchsource","down");
            }
            if ((msg == "NextSong")) {
                command("nextsong","");
            }
            if ((msg == "AdminPage")) {
                llLoadURL(llGetOwner(),"MetaCast Cloud Control Panel","http://metacast.sublimegeek.com");
            }
            if ((msg == "Support")) {
                llLoadURL(llGetOwner(),"Sublime Geek Support","http://support.sublimegeek.com");
            }
            if ((msg == "StreamPage")) {
                llLoadURL(llGetOwner(),"Your Personal Stream Page",("http://metacast.sublimegeek.com/start/" + username));
            }
            if ((msg == "HUD On")) {
                (power = TRUE);
                llSetLinkColor(LINK_SET,pwron,ALL_SIDES);
                llOwnerSay("Refreshing settings...");
                init();
            }
            if ((msg == "HUD Off")) {
                (power = FALSE);
                llSetLinkColor(LINK_SET,pwroff,ALL_SIDES);
                llSetText("",<1,1,1>,1);
            }
            if ((msg == "Reset")) {
                llResetScript();
            }
        }
    }

    
    http_response(key request_id,integer status,list metadata,string body) {
        if ((((request_id == reqid) && power) && configactive)) {
            if (DEBUG) {
                llOwnerSay(((("@" + ((string)stopwatch)) + ": ") + body));
            }
            list commands = llParseString2List(body,["|"],[]);
            string cmd = llList2String(commands,0);
            string obj = llList2String(commands,1);
            string act = llList2String(commands,2);
            if ((obj == "success")) {
                if ((cmd == "status")) {
                    float mbph = ((((llList2Float(commands,8) / 8) / 1000) * 60) * 60);
                    string unit;
                    if ((llList2Integer(commands,5) == 0)) {
                        (mbph = 0);
                    }
                    if ((mbph >= 1000)) {
                        (unit = "GB");
                    }
                    else  if ((mbph >= 1)) {
                        (unit = "MB");
                    }
                    else  if ((mbph < 1)) {
                        (unit = "KB");
                        (mbph * 1000);
                    }
                    string streamdata = ((((((((((((((((("On-Air: " + llList2String(commands,6)) + "  ") + "Listeners: ") + llList2String(commands,5)) + "\n") + "Now Playing: ") + llList2String(commands,7)) + "\n") + "Broadcasting on ") + llList2String(commands,9)) + " @ ") + llList2String(commands,8)) + "kbps\n") + "Current Usage: ") + float2string(mbph)) + unit) + " per hour");
                    if ((((((((llList2String(commands,4) == "You are not broadcasting") || (llList2String(commands,4) == "")) || (llList2String(commands,5) == "")) || (llList2String(commands,6) == "")) || (llList2String(commands,7) == "")) || (llList2String(commands,8) == "")) || (llList2String(commands,9) == ""))) {
                        (streamdata = "No stream info available...");
                        (broadcasting = FALSE);
                    }
                    else  {
                        (broadcasting = TRUE);
                    }
                    llSetText(((((((((llGetObjectName() + "\n") + llList2String(commands,3)) + " & ") + llList2String(commands,4)) + "\n") + streamdata) + "\n") + "\n \n \n"),<1,1,1>,1);
                    color();
                    return;
                }
                else  if ((((((cmd == "nextsong") || (cmd == "start")) || (cmd == "stop")) || (cmd == "restart")) || (cmd == "reload"))) {
                    llOwnerSay(((obj + "! ") + act));
                    color();
                    request("status");
                    return;
                }
                else  if ((cmd == "switchsource")) {
                    if ((llList2String(commands,3) == "up")) {
                        llOwnerSay(((obj + "! Your autoDJ is queued to be UP.  ") + "This will occur when no one else is connected to the stream."));
                        request("status");
                        color();
                    }
                    if ((llList2String(commands,3) == "down")) {
                        llOwnerSay(((obj + "! Your autoDJ is queued to be DOWN.  ") + "This should occur immediately."));
                        request("status");
                        color();
                    }
                    return;
                }
                else  if ((cmd == "getsongs")) {
                    integer i;
                    string songs;
                    for ((i = 0); (i < llList2Integer(commands,3)); (i++)) {
                        (songs += (("* " + llList2String(commands,(4 + i))) + "\n"));
                    }
                    llOwnerSay(((("Last " + llList2String(commands,3)) + " Songs:\n") + songs));
                    return;
                }
                else  if ((cmd == "bandwidth")) {
                    llOwnerSay(("Your current bandwidth usage is " + llList2String(commands,3)));
                    return;
                }
                else  if ((cmd == "disk")) {
                    llOwnerSay(("Your current disk usage is " + llList2String(commands,3)));
                    return;
                }
            }
            else  if (((obj == "error") && (cmd != "status"))) {
                llOwnerSay((((((("\nThere was an error in your request. " + "\nError: ") + act) + ".") + "  \nPlease visit http://metacast.sublimegeek.com to login ") + "and attempt your request via the online control panel.  ") + "\nIf you need assistance, please create a ticket at http://support.sublimegeek.com"));
                color();
                return;
            }
            else  if (((obj == "failure") || ((obj != "success") && (cmd != "status")))) {
                llOwnerSay(((("\nThere was an error in your request." + "  \nPlease visit http://metacast.sublimegeek.com to login ") + "and attempt your request via the online control panel.  ") + "\nIf you need assistance, please create a ticket at http://support.sublimegeek.com"));
                color();
                return;
            }
        }
    }

    
    dataserver(key query_id,string data) {
        if ((query_id == queryhandle)) {
            if ((data != EOF)) {
                (data = llStringTrim(data,STRING_TRIM_HEAD));
                if ((llGetSubString(data,0,0) != "#")) {
                    integer s = llSubStringIndex(data,"=");
                    if ((~s)) {
                        string token = llToLower(llStringTrim(llDeleteSubString(data,s,(-1)),STRING_TRIM));
                        (data = llStringTrim(llDeleteSubString(data,0,s),STRING_TRIM));
                        if ((token == "username")) {
                            string notecard_user = data;
                            (username = llStringTrim(notecard_user,STRING_TRIM));
                        }
                        if ((token == "password")) {
                            string notecard_pass = data;
                            (password = llStringTrim(notecard_pass,STRING_TRIM));
                        }
                    }
                }
                (queryhandle = llGetNotecardLine(notecard_name,(++line)));
            }
            else  {
                llOwnerSay("Done reading configuration.");
                llOwnerSay((((string)((integer)(64 - (llGetFreeMemory() * 1.0e-3)))) + "KiB in use..."));
                llOwnerSay("Ready");
                if (((username == "") || (password == ""))) {
                    llOwnerSay(("Hey! Open me and edit my configuration notecard inside" + " and add your username and password.  I won't work without *both* pieces of info."));
                    llSetText((llGetObjectName() + "\nPlease open me and update my configuration notecard!\n \n \n"),<1,1,1>,1);
                    llSetLinkColor(LINK_SET,pwroff,ALL_SIDES);
                }
                else  {
                    (configactive = TRUE);
                    llSetText((llGetObjectName() + "\nWaiting for status update...\n \n \n"),<1,1,1>,1);
                }
                if (configactive) {
                    request("status");
                }
            }
        }
    }
}
