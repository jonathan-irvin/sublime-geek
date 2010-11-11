// LSL script generated: metacast_server.lslp Thu Nov 11 15:42:18 CST 2010
//MetaCast Controller

string version = "1.4";
key gCreator = "6aab7af0-8ce8-4361-860b-7139054ed44f";

key reqid;
integer stopwatch;
integer admchanhandle;
integer admchan;
integer DEBUG = TRUE;
integer configactive = FALSE;
integer power = TRUE;
integer broadcasting = FALSE;
integer pvision = FALSE;
integer upgrade = FALSE;
integer downgrade = FALSE;
integer renew = FALSE;

string mail;
string servertype;
string pchannel;

string svrpackage;
integer svrcost;

vector pwron = <0.48627000000000004,0.74902,1.0>;
vector pwroff = <0.33333,0.33333,0.33333>;

list menu = ["Stats","AutoDJ","Server","Display","Account","Reset","GetHUD","ReLoad","Instructions","AdminPage","Support","StreamPage"];
    
list prices = ["750","1875","5625","7500","18750","56250"];
string package;
integer monthly;
integer quarterly;
integer biannually;
integer annually;
integer xferamount;

//Notecard Settings
string username;
string password;

integer line;
key queryhandle;
key notecarduuid;
string notecard_name = ".metacast_server_config";

//Functions
request(string type){
    (reqid = llHTTPRequest(((("http://sublimegeek.com/sg_admin/metacast/" + type) + "/") + llEscapeURL(username)),[0,"POST",1,"application/x-www-form-urlencoded"],("mccpass=" + llEscapeURL(password))));
}
command(string type,string status){
    (reqid = llHTTPRequest(((("http://sublimegeek.com/sg_admin/metacast/" + type) + "/") + llEscapeURL(username)),[0,"POST",1,"application/x-www-form-urlencoded"],((("mccpass=" + llEscapeURL(password)) + "&state=") + llEscapeURL(status))));
}
acct(string type,string attr){
    (reqid = llHTTPRequest(((("http://sublimegeek.com/sg_admin/metacast/" + type) + "/") + llEscapeURL(username)),[0,"POST",1,"application/x-www-form-urlencoded"],((("mccpass=" + llEscapeURL(password)) + "&attr=") + llEscapeURL(attr))));
}
acct_history(){
    (reqid = llHTTPRequest("http://sublimegeek.com/sg_admin/admin/getlogs",[0,"POST",1,"application/x-www-form-urlencoded"],("mccpass=" + llEscapeURL(password))));
}
    
provision(string mail,string template,string duration){
    if ((!DEBUG)) {
        (reqid = llHTTPRequest(("http://sublimegeek.com/sg_admin/metacast/newacct/" + llEscapeURL(username)),[0,"POST",1,"application/x-www-form-urlencoded"],((((((("mccpass=" + llEscapeURL(password)) + "&email=") + llEscapeURL(mail)) + "&template=") + llEscapeURL(template)) + "&duration=") + llEscapeURL(duration))));
    }
    else  {
        (reqid = llHTTPRequest(("http://sublimegeek.com/sg_admin/metacast/newacct/" + llEscapeURL(username)),[0,"POST",1,"application/x-www-form-urlencoded"],((((((("mccpass=" + llEscapeURL(password)) + "&email=") + llEscapeURL(mail)) + "&template=") + llEscapeURL(template)) + "&duration=") + llEscapeURL(duration))));
    }
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
    llSetLinkColor(2,<0.75,0.75,0>,ALL_SIDES);
    llSetLinkColor(3,<0.75,0.75,0>,ALL_SIDES);
    llSetLinkColor(4,<0.75,0.75,0>,ALL_SIDES);
    llSetLinkColor(5,<0.75,0.75,0>,ALL_SIDES);
    llSetLinkColor(6,<0.75,0.75,0>,ALL_SIDES);
    llSetText((llGetObjectName() + "\nReading configuration...\n \n \n"),<1,1,1>,1);
    (queryhandle = llGetNotecardLine(notecard_name,(line = 0)));
    (notecarduuid = llGetInventoryKey(notecard_name));
}
rlisten(){
    llListenRemove(admchanhandle);
}
color(){
    if (power) {
        llSetLinkColor(1,pwroff,ALL_SIDES);
        llSetLinkColor(2,pwron,ALL_SIDES);
        llSetLinkColor(3,pwron,ALL_SIDES);
        llSetLinkColor(4,pwron,ALL_SIDES);
        llSetLinkColor(5,pwron,ALL_SIDES);
        llSetLinkColor(6,pwron,ALL_SIDES);
        llSetLinkColor(7,pwron,ALL_SIDES);
    }
    else  {
        llSetLinkColor(LINK_SET,pwroff,ALL_SIDES);
    }
    if (broadcasting) {
        llSetLinkColor(9,<1,1,0>,ALL_SIDES);
        llSetLinkColor(8,<1,1,0>,ALL_SIDES);
        llSetLinkColor(7,<1,1,0>,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(9,1,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(8,1,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(7,1,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(9,0,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(8,0,ALL_SIDES);
        llSleep(0.25);
        llSetLinkAlpha(7,0,ALL_SIDES);
        llSleep(0.25);
    }
    else  {
        llSetLinkAlpha(9,0,ALL_SIDES);
        llSetLinkAlpha(8,0,ALL_SIDES);
        llSetLinkAlpha(7,0,ALL_SIDES);
    }
}

prov(integer amt){
    list packages = [];
    string template;
    if ((servertype == "IceCast")) {
        (packages = ["IceCastBasic10","IceCastBasic25","IceCastBasic75"]);
    }
    else  if ((servertype == "ShoutCast")) {
        (packages = ["ShoutCastBasic10","ShoutCastBasic25","ShoutCastBasic75"]);
    }
    if ((monthly == llList2Integer(prices,0))) {
        (template = llList2String(packages,0));
    }
    else  if ((monthly == llList2Integer(prices,1))) {
        (template = llList2String(packages,1));
    }
    else  if ((monthly == llList2Integer(prices,2))) {
        (template = llList2String(packages,2));
    }
    if ((amt == monthly)) {
        provision(mail,template,"1");
    }
    else  if ((amt == quarterly)) {
        provision(mail,template,"3");
    }
    else  if ((amt == biannually)) {
        provision(mail,template,"6");
    }
    else  if ((amt == annually)) {
        provision(mail,template,"12");
    }
}

getperms(integer perms){
    if ((perms && PERMISSION_DEBIT)) {
        llOwnerSay("Ready.");
    }
    else  {
        llOwnerSay("Please select YES to continue.  This is so we can bill you properly.");
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
        llSetObjectName(("[sig] MetaCast Server v" + version));
        llSetText((llGetObjectName() + "\nWaiting for status update...\n \n \n"),<1,1,1>,1);
        llSetPayPrice(PAY_HIDE,[PAY_HIDE,PAY_HIDE,PAY_HIDE,PAY_HIDE]);
        llSetClickAction(CLICK_ACTION_TOUCH);
        (menu = llListSort(menu,0,FALSE));
        color();
        init();
        llSetTimerEvent(1);
    }

    run_time_permissions(integer perms) {
        getperms(perms);
    }

    timer() {
        if (((stopwatch == 0) || (stopwatch == 30))) {
            if ((configactive && power)) {
                request("status");
            }
        }
        if ((((pvision || upgrade) || downgrade) || renew)) {
            if ((stopwatch == 30)) {
                llOwnerSay("Need more time?");
            }
        }
        if ((stopwatch <= 59)) {
            (++stopwatch);
        }
        else  {
            (stopwatch = 0);
            if ((((pvision || upgrade) || downgrade) || renew)) {
                (pvision = FALSE);
                (upgrade = FALSE);
                (downgrade = FALSE);
                (renew = FALSE);
                llOwnerSay("Timed out.");
                llSetClickAction(CLICK_ACTION_TOUCH);
                llSetPayPrice(PAY_HIDE,[PAY_HIDE,PAY_HIDE,PAY_HIDE,PAY_HIDE]);
            }
        }
    }


    touch_start(integer total_number) {
        if ((llDetectedKey(0) == llGetOwner())) {
            rlisten();
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
                llDialog(llDetectedKey(0),(("MetaCast Cloud Controller\n" + "Account Menu\n") + "Did you need to setup a new account?"),["NewAcct","Exit"],admchan);
            }
            else  if ((!power)) {
                llDialog(llDetectedKey(0),("MetaCast Cloud Controller\n" + "Make your selection..."),["Display On"],admchan);
            }
            else  {
                llOwnerSay("Only the owner is allowed to activate the menu.");
            }
        }
    }

    
    listen(integer channel,string name,key id,string msg) {
        if (DEBUG) {
            llOwnerSay(((((string)channel) + ": ") + msg));
        }
        list commands = llParseString2List(msg,[" "],[]);
        string cmd = llList2String(commands,0);
        string obj = llList2String(commands,1);
        string act = llList2String(commands,2);
        if (((id == llGetOwner()) && (channel == admchan))) {
            if ((msg == "Back")) {
                llDialog(id,("MetaCast Cloud Controller\n" + "Make your selection..."),menu,admchan);
            }
            if ((msg == "AcctLogs")) {
                acct_history();
            }
            if ((msg == "Display")) {
                if ((!power)) {
                    llDialog(id,(("MetaCast Cloud Controller\n" + "HUD Power Menu\n") + "Make your selection..."),["Display On","Back"],admchan);
                }
                else  {
                    llDialog(id,(("MetaCast Cloud Controller\n" + "HUD Power Menu\n") + "Make your selection..."),["Display Off","Back"],admchan);
                }
            }
            if ((msg == "Account")) {
                llDialog(id,(("MetaCast Cloud Controller\n" + "Account Menu\n") + "Make your selection..."),["AcctStatus","NewAcct","Back","Change","Renew","Usage","AcctLogs"],admchan);
            }
            if ((msg == "NewAcct")) {
                llDialog(id,(("MetaCast Cloud Controller\n" + "New Account Menu\n") + "Please select the MetaCast Cloud Package..."),[" "," ","Back","ShoutCast","IceCast","Reseller"],admchan);
            }
            if ((msg == "Change")) {
                llDialog(id,(("MetaCast Cloud Controller\n" + "Account Change Menu\n") + "Make your selection..."),["Upgrade","Downgrade","Back"],admchan);
            }
            if ((msg == "Renew")) {
                request("svrinfo");
            }
            if ((msg == "Upgrade")) {
                acct("upgrade","");
            }
            if ((msg == "Downgrade")) {
                llOwnerSay("Please contact support at http://support.sublimegeek.com to process your downgrade.");
            }
            if ((msg == "ShoutCast")) {
                (servertype = "ShoutCast");
                llDialog(id,(("MetaCast Cloud Controller\n" + "New Account Menu\n") + "Please select the MetaCast Cloud Package..."),[" "," ","Back","Sh.Cast10","Sh.Cast25","Sh.Cast75"],admchan);
            }
            if ((msg == "IceCast")) {
                (servertype = "IceCast");
                llDialog(id,(("MetaCast Cloud Controller\n" + "New Account Menu\n") + "Please select the MetaCast Cloud Package..."),[" "," ","Back","IceCast10","IceCast25","IceCast75"],admchan);
            }
            if ((msg == "Reseller")) {
                (servertype = "Reseller");
                llDialog(id,(("MetaCast Cloud Controller\n" + "New Account Menu\n") + "Please select the MetaCast Cloud Package..."),[" "," ","Back","Reseller100","Reseller250","Reseller750"],admchan);
            }
            if ((((msg == "Reseller100") || (msg == "Reseller250")) || (msg == "Reseller750"))) {
                llOwnerSay("Reseller accounts aren't able to be setup from the server's yet, please contact http://support.sublimegeek.com/ to get your Reseller account setup.");
            }
            if (((((((msg == "Sh.Cast10") || (msg == "IceCast10")) || (msg == "Sh.Cast25")) || (msg == "IceCast25")) || (msg == "Sh.Cast75")) || (msg == "IceCast75"))) {
                llOwnerSay("Preparing the server to accept your payment...");
                if (((msg == "Sh.Cast10") || (msg == "IceCast10"))) {
                    (package = msg);
                    (monthly = llList2Integer(prices,0));
                    (quarterly = ((integer)((llList2Integer(prices,0) * 0.95) * 3)));
                    (biannually = ((integer)((llList2Integer(prices,0) * 0.925) * 6)));
                    (annually = ((integer)((llList2Integer(prices,0) * 0.8) * 12)));
                    llSetPayPrice(PAY_HIDE,[monthly,quarterly,biannually,annually]);
                }
                if (((msg == "Sh.Cast25") || (msg == "IceCast25"))) {
                    (package = msg);
                    (monthly = llList2Integer(prices,1));
                    (quarterly = ((integer)((llList2Integer(prices,1) * 0.95) * 3)));
                    (biannually = ((integer)((llList2Integer(prices,1) * 0.925) * 6)));
                    (annually = ((integer)((llList2Integer(prices,1) * 0.8) * 12)));
                    llSetPayPrice(PAY_HIDE,[monthly,quarterly,biannually,annually]);
                }
                if (((msg == "Sh.Cast75") || (msg == "IceCast75"))) {
                    (package = msg);
                    (monthly = llList2Integer(prices,2));
                    (quarterly = ((integer)((llList2Integer(prices,2) * 0.95) * 3)));
                    (biannually = ((integer)((llList2Integer(prices,2) * 0.925) * 6)));
                    (annually = ((integer)((llList2Integer(prices,2) * 0.8) * 12)));
                    llSetPayPrice(PAY_HIDE,[monthly,quarterly,biannually,annually]);
                }
                if ((mail == "")) {
                    llOwnerSay((("Wait!  " + "\nWe can't setup your account without a valid email address.  ") + "\nEdit the configuration notecard inside and add your email to the notecard and then try again."));
                }
                else  {
                    llOwnerSay((((((((((((("Thank you for choosing MetaCast Cloud by Sublime Geek:\n" + "Please pay L$") + ((string)monthly)) + " to subscribe for 1 Month\n") + "Please pay L$") + ((string)quarterly)) + " to subscribe for 3 Months (Save 5%)\n") + "Please pay L$") + ((string)biannually)) + " to subscribe for 6 Months (Save 7.5%)\n") + "Please pay L$") + ((string)annually)) + " to subscribe for 12 Months (Save 10%)"));
                    llSetClickAction(CLICK_ACTION_PAY);
                    (pvision = TRUE);
                }
            }
            if ((msg == "Server")) {
                llDialog(id,(("MetaCast Cloud Controller\n" + "Server Menu\n") + "Make your selection..."),["Start","Stop","Back","Restart","Reload"],admchan);
            }
            if ((msg == "AutoDJ")) {
                llDialog(id,(("MetaCast Cloud Controller\n" + "AutoDJ Menu\n") + "Make your selection..."),["StartAuto","KillAuto","Back","NextSong"],admchan);
            }
            if (((msg == "Stats") || (msg == "Usage"))) {
                llDialog(id,(("MetaCast Cloud Controller\n" + "Statistics Menu\n") + "Make your selection..."),["GetSongs","Bandwidth","Back","DiskSpace"],admchan);
            }
            if (((((msg == "Start") || (msg == "Stop")) || (msg == "Restart")) || (msg == "Reload"))) {
                command(llToLower(msg),"");
            }
            if ((msg == "GetAcctInfo")) {
                request("getaccount");
            }
            if ((msg == "AcctStatus")) {
                request("acctstatus");
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
            if ((msg == "GetHUD")) {
                llOwnerSay("Giving you a HUD");
                llGiveInventory(llGetOwner(),llGetInventoryName(INVENTORY_OBJECT,0));
            }
            if ((msg == "Instructions")) {
                llGiveInventory(llGetOwner(),"MetaCast Cloud Server Instructions");
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
            if ((msg == "Display On")) {
                (power = TRUE);
                color();
                llOwnerSay("Refreshing settings...");
                init();
            }
            if ((msg == "Display Off")) {
                (power = FALSE);
                color();
                llSetText("",<1,1,1>,1);
            }
            if ((msg == "Reset")) {
                llResetScript();
            }
            if ((msg == "ReLoad")) {
                init();
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
                    if ((((((((llList2String(commands,4) == "Your broadcast is down") || (llList2String(commands,4) == "")) || (llList2String(commands,5) == "")) || (llList2String(commands,6) == "")) || (llList2String(commands,7) == "")) || (llList2String(commands,8) == "")) || (llList2String(commands,9) == ""))) {
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
                else  if ((cmd == "provision")) {
                    llOwnerSay(((obj + "! ") + act));
                    llOwnerSay((((((((("\nPlease login to http://metacast.sublimegeek.com" + "\n") + "with the following credentials:\n") + "Username: ") + llList2String(commands,3)) + "\n") + "Password: ") + llList2String(commands,4)) + "\n"));
                    llOwnerSay("Make sure to change your password and update it in your config notecards on both the server and HUD.");
                    llOwnerSay((("For your convenience, your server has already been started and your stream is ready for use.\n" + "Login to the web control panel to attain your stream settings.  \n") + "Should you need help, simply click on the Server and select \"Support\"."));
                    color();
                    request("status");
                    (pvision = FALSE);
                    (xferamount = 0);
                    return;
                }
                else  if ((cmd == "switchsource")) {
                    if ((llList2String(commands,3) == "up")) {
                        llOwnerSay((("Success! " + "! Your autoDJ is queued to be UP.  ") + "This will occur when no one else is connected to the stream."));
                        request("status");
                        color();
                    }
                    if ((llList2String(commands,3) == "down")) {
                        llOwnerSay((("Success! " + "! Your autoDJ is queued to be DOWN.  ") + "This should occur immediately."));
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
                    llOwnerSay((((("Success! " + "Last ") + llList2String(commands,3)) + " Songs:\n") + songs));
                    return;
                }
                else  if ((cmd == "bandwidth")) {
                    llOwnerSay((("Success! " + "Your current bandwidth usage is ") + llList2String(commands,3)));
                    return;
                }
                else  if ((cmd == "disk")) {
                    llOwnerSay((("Success! " + "Your current disk usage is ") + llList2String(commands,3)));
                    return;
                }
                else  if ((cmd == "acctstatus")) {
                    llOwnerSay(((((((("\n" + act) + "\n") + "Your current bandwidth usage is ") + llList2String(commands,4)) + "\n") + "Your current disk usage is ") + llList2String(commands,5)));
                    return;
                }
                else  if ((cmd == "upgradechoices")) {
                    llOwnerSay("Please pay the server the difference between packages.");
                    if ((llList2Integer(commands,2) == 1125)) {
                        llOwnerSay((("\n" + "Please pay L$1125 to Upgrade to 25GB (if currently on 10GB plan)\n") + "Please pay L$4875 to Upgrade to 75GB (if currently on 10GB plan)"));
                        llSetClickAction(CLICK_ACTION_PAY);
                        llSetPayPrice(PAY_HIDE,[llList2Integer(commands,2),llList2Integer(commands,3),llList2Integer(commands,4),PAY_HIDE]);
                    }
                    else  if ((llList2Integer(commands,2) == 3750)) {
                        llOwnerSay(("\n" + "Please pay L$3750 to Upgrade to 75GB (if currently on 25GB plan)"));
                        llSetPayPrice(PAY_HIDE,[llList2Integer(commands,2),PAY_HIDE,PAY_HIDE,PAY_HIDE]);
                        llSetClickAction(CLICK_ACTION_PAY);
                    }
                    else  if ((llList2String(commands,2) == "Reseller")) {
                        llOwnerSay("We'd be happy to help! Create a ticket at http://support.sublimegeek.com to upgrade your account to reseller!");
                    }
                    (stopwatch = 0);
                    (upgrade = TRUE);
                    return;
                }
                else  if ((cmd == "svrinfo")) {
                    (svrpackage = llList2String(commands,2));
                    (svrcost = llList2Integer(commands,3));
                    (monthly = llList2Integer(commands,3));
                    (quarterly = ((integer)((llList2Integer(commands,3) * 0.95) * 3)));
                    (biannually = ((integer)((llList2Integer(commands,3) * 0.925) * 6)));
                    (annually = ((integer)((llList2Integer(commands,3) * 0.8) * 12)));
                    llOwnerSay(((((((((((((((((("You currently have the " + svrpackage) + " package:\n") + "Your account is set to expire ") + llList2String(commands,4)) + "\n") + "Please pay L$") + ((string)monthly)) + " to add 1 Month\n") + "Please pay L$") + ((string)quarterly)) + " to add 3 Months (Save 5%)\n") + "Please pay L$") + ((string)biannually)) + " to add 6 Months (Save 7.5%)\n") + "Please pay L$") + ((string)annually)) + " to add 12 Months (Save 10%)"));
                    llSetClickAction(CLICK_ACTION_PAY);
                    llSetPayPrice(PAY_HIDE,[monthly,quarterly,biannually,annually]);
                    (stopwatch = 0);
                    (renew = TRUE);
                }
                else  if ((cmd == "svrinfo")) {
                    llOwnerSay(("Success! " + llList2String(commands,2)));
                }
                else  if ((cmd == "getlogs")) {
                    list logs = llList2List(commands,2,llGetListLength(commands));
                    integer i;
                    llOwnerSay("Here are your last 3 log entries:");
                    for ((i = 0); (i < llGetListLength(logs)); (i++)) {
                        llOwnerSay(llList2String(logs,i));
                    }
                }
            }
            else  if ((obj == "error")) {
                llOwnerSay((((((("\nThere was an error in your request. " + "\nError: ") + act) + ".") + "  \nPlease visit http://metacast.sublimegeek.com to login ") + "and attempt your request via the online control panel.  ") + "\nIf you need assistance, please create a ticket at http://support.sublimegeek.com"));
                color();
                if ((cmd == "provision")) {
                    llOwnerSay("In addition, no money was removed from your account.");
                }
                return;
            }
            else  if (((obj == "failure") || ((obj != "success") && (cmd != "status")))) {
                llOwnerSay(((("\nThere was an error in your request." + "  \nPlease visit http://metacast.sublimegeek.com to login ") + "and attempt your request via the online control panel.  ") + "\nIf you need assistance, please create a ticket at http://support.sublimegeek.com"));
                color();
                return;
            }
        }
    }

    
    money(key id,integer amt) {
        if (pvision) {
            if ((mail != "")) {
                prov(amt);
                if ((!DEBUG)) {
                    llGiveMoney(gCreator,amt);
                }
            }
            else  {
                llOwnerSay("Please update your email in the notecard");
            }
            (pvision = FALSE);
        }
        if (upgrade) {
            if ((amt == 1125)) {
                acct("upgrade","25GB");
            }
            if ((amt == 3750)) {
                acct("upgrade","75GB");
            }
            if ((amt == 4875)) {
                acct("upgrade","75GB");
            }
            if ((!DEBUG)) {
                llGiveMoney(gCreator,amt);
            }
            (upgrade = FALSE);
        }
        if (renew) {
            if ((amt == monthly)) {
                acct("renew","month");
            }
            if ((amt == quarterly)) {
                acct("renew","quarter");
            }
            if ((amt == biannually)) {
                acct("renew","halfyear");
            }
            if ((amt == annually)) {
                acct("renew","year");
            }
            if ((!DEBUG)) {
                llGiveMoney(gCreator,amt);
            }
            (renew = FALSE);
        }
        llSetClickAction(CLICK_ACTION_TOUCH);
        llSetPayPrice(PAY_HIDE,[PAY_HIDE,PAY_HIDE,PAY_HIDE,PAY_HIDE]);
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
                        if ((token == "email")) {
                            string notecard_email = data;
                            (mail = llStringTrim(notecard_email,STRING_TRIM));
                        }
                        if ((token == "channel")) {
                            string notecard_channel = data;
                            (pchannel = llStringTrim(notecard_channel,STRING_TRIM));
                        }
                    }
                }
                (queryhandle = llGetNotecardLine(notecard_name,(++line)));
            }
            else  {
                llOwnerSay("Done reading configuration.");
                llOwnerSay((((string)((integer)(64 - (llGetFreeMemory() * 1.0e-3)))) + "KiB in use..."));
                llOwnerSay("Requesting debit permissions.  This is so we can properly bill you.  Select \"Grant\" to continue.");
                llRequestPermissions(llGetOwner(),PERMISSION_DEBIT);
                if (((username == "") || (password == ""))) {
                    llOwnerSay(("Hey! Open me and edit my configuration notecard inside" + " and add your username and password.  I won't work without *both* pieces of info."));
                    llSetText((llGetObjectName() + "\nPlease open me and update my configuration notecard!\nOtherwise, click on me to create a new account!\n \n"),<1,1,1>,1);
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
