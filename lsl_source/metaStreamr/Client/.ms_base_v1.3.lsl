// LSL script generated: Client..ms_base_v1.3.lslp Fri Oct 30 19:21:31 Central Daylight Time 2009
key requestid;
key gCreator = "6aab7af0-8ce8-4361-860b-7139054ed44f";

string version = "1.3";

integer Parcel_Flags;
list lstParcelName;
list lstParcelDesc;
list lstParcelArea;

string radio_name;
string radio_url;
string video_name;
string video_type;
string video_url;
string cli_state;

key server_admin;
key client_admin;
integer time = 30;
integer regchk = 5;
integer defaults = 1;

vector Where;
string Name;
string SLURL;
integer X;
integer Y;
integer Z;

//----------------------BEGIN DEFAULT SETTINGS-----------------
string notecard_name = ".default";

//Settings Variables
string rad_name;
string rad_url;
string vid_name;
string vid_type;
string vid_url;
string srv_admin;
string cli_admin;

list uplinkthis;
integer line;
key queryhandle;
key notecarduuid;

// Config data loaded from notecard, with some sane defaults
string radio_station_name = "Club 977 Hitz";
string radio_station_url = "http://scfire-dll-aa04.stream.aol.com:80/stream/1074";
//key server_admin;
//key client_admin;

init(){
    (queryhandle = llGetNotecardLine(notecard_name,(line = 0)));
    (notecarduuid = llGetInventoryKey(notecard_name));
}

//----------------------END DEFAULT SETTINGS-----------------


string slurl(){
    (Name = llGetRegionName());
    (Where = llGetPos());
    (X = ((integer)Where.x));
    (Y = ((integer)Where.y));
    (Z = ((integer)Where.z));
    (SLURL = ((((((((("http://slurl.com/secondlife/" + Name) + "/") + ((string)X)) + "/") + ((string)Y)) + "/") + ((string)Z)) + "/?title=") + Name));
    return SLURL;
}

setOptions(string info){
    list options = llParseString2List(info,[","],[]);
    string updated = llList2String(options,0);
    string _rad_name0 = llList2String(options,1);
    string _rad_url1 = llList2String(options,2);
    string _vid_name2 = llList2String(options,3);
    string _vid_type3 = llList2String(options,4);
    string _vid_url4 = llList2String(options,5);
    key _srv_admin5 = llList2Key(options,6);
    string expire = llList2String(options,7);
    (cli_state = llList2String(options,8));
    (radio_name = llStringTrim(_rad_name0,3));
    (radio_url = llStringTrim(_rad_url1,3));
    (video_name = llStringTrim(_vid_name2,3));
    (video_type = llStringTrim(_vid_type3,3));
    (video_url = llStringTrim(_vid_url4,3));
    (server_admin = llStringTrim(((string)_srv_admin5),3));
    (client_admin = llStringTrim(((string)cli_admin),3));
    if ((cli_state == "DELETED")) {
        llInstantMessage(server_admin,"Deleted!");
        llDie();
    }
    if ((cli_state == "STANDBY")) {
        (time = 3600);
        llSetObjectDesc("Standing by...");
        llInstantMessage(server_admin,"Standing By for 1 Hour.  If you set me to active, I can be clicked to check my status!");
        llSetText(((((("[metaStreamr] Client  " + version) + " [") + cli_state) + "]\n>>> STANDING BY <<<\nExpires: ") + expire),<1.0,1.0,0.0>,1);
    }
    if ((cli_state == "ACTIVE")) {
        if ((radio_url != "LICENSE EXPIRED")) {
            if ((updated == "UPDATED")) {
                llSetObjectDesc("Getting Live Updates...");
                llSetText(((((((((("[metaStreamr] Client  " + version) + " [") + cli_state) + "]\nCurrently Tuned To: ") + radio_name) + "\nVideo Set To: ") + video_name) + "\nExpires: ") + expire),<0.0,1.0,0.0>,1);
                llSetParcelMusicURL(radio_url);
                llParcelMediaCommandList([5,video_url,10,video_type]);
            }
            else  {
                llSetText((("[metaStreamr] Client  " + version) + "\nConnecting for the first time\n...Please Wait\nOr Click me to Continue"),<0.0,1.0,0.0>,1);
            }
        }
        else  if ((radio_url == "LICENSE EXPIRED")) {
            llSetText(((("[metaStreamr] Client  " + version) + "\n<<< License EXPIRED >>>\n") + expire),<0.0,1.0,0.0>,1);
        }
        else  if ((radio_url == "")) {
            llSetText(((("[metaStreamr] Client  " + version) + "\n<<< Awaiting Update...Click to Check >>>\n") + expire),<0.0,1.0,0.0>,1);
        }
    }
}

setDefaults(string info){
    list options = llParseString2List(info,[","],[]);
    string _rad_name0 = llList2String(options,0);
    string _rad_url1 = llList2String(options,1);
    string _vid_name2 = llList2String(options,2);
    string _vid_url3 = llList2String(options,3);
    key _srv_admin4 = llList2Key(options,4);
    key _cli_admin5 = llList2Key(options,5);
    (radio_name = llStringTrim(_rad_name0,3));
    (radio_url = llStringTrim(_rad_url1,3));
    (video_name = llStringTrim(_vid_name2,3));
    (video_url = llStringTrim(_vid_url3,3));
    (server_admin = llStringTrim(((string)_srv_admin4),3));
    (client_admin = llStringTrim(((string)_cli_admin5),3));
    llSetText((("[metaStreamr] Client  " + version) + "\nSetting Defaults..."),<0.0,1.0,0.0>,1);
}


httpcheck(){
    (requestid = llHTTPRequest("http://www.metastreamr.net/backend/streamcheck.php",[0,"POST",1,"application/x-www-form-urlencoded"],((((((((("simname=" + llEscapeURL(llGetRegionName())) + "&pname=") + llEscapeURL(llList2String(lstParcelName,0))) + "&pdesc=") + llEscapeURL(llList2String(lstParcelDesc,0))) + "&parea=") + llEscapeURL(llList2String(lstParcelArea,0))) + "&slurl=") + llEscapeURL(slurl()))));
}
httpreg(){
    (requestid = llHTTPRequest("http://www.metastreamr.net/backend/streamreg.php",[0,"POST",1,"application/x-www-form-urlencoded"],(((((((((((((((((((((("simname=" + llEscapeURL(llGetRegionName())) + "&radname=") + llEscapeURL(rad_name)) + "&radurl=") + llEscapeURL(rad_url)) + "&vidname=") + llEscapeURL(vid_name)) + "&vidtype=") + llEscapeURL(vid_type)) + "&pname=") + llEscapeURL(llList2String(lstParcelName,0))) + "&pdesc=") + llEscapeURL(llList2String(lstParcelDesc,0))) + "&parea=") + llEscapeURL(llList2String(lstParcelArea,0))) + "&vidurl=") + llEscapeURL(vid_url)) + "&cliadmin=") + llEscapeURL(cli_admin)) + "&demo=true&state=ACTIVE") + "&slurl=") + llEscapeURL(slurl()))));
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
upgrade(){
    string self = llGetScriptName();
    string basename = self;
    if ((llSubStringIndex(self," ") >= 0)) {
        integer start = 2;
        string tail = llGetSubString(self,(llStringLength(self) - start),-1);
        while ((llGetSubString(tail,0,0) != " ")) {
            (start++);
            (tail = llGetSubString(self,(llStringLength(self) - start),-1));
        }
        if ((((integer)tail) > 0)) {
            (basename = llGetSubString(self,0,((-llStringLength(tail)) - 1)));
        }
    }
    integer n = llGetInventoryNumber(10);
    while (((n--) > 0)) {
        string item = llGetInventoryName(10,n);
        if (((item != self) && (0 == llSubStringIndex(item,basename)))) {
            llRemoveInventory(item);
        }
    }
}

default {

    on_rez(integer start_param) {
        llResetScript();
    }

    changed(integer change) {
        if ((change & 1)) if ((notecarduuid != llGetInventoryKey(notecard_name))) init();
    }

    state_entry() {
        llSetObjectName(("[metaStreamr] Client Set-top Box v" + version));
        (Parcel_Flags = llGetParcelFlags(llGetPos()));
        (lstParcelName = llGetParcelDetails(llGetPos(),[0]));
        (lstParcelDesc = llGetParcelDetails(llGetPos(),[1]));
        (lstParcelArea = llGetParcelDetails(llGetPos(),[4]));
        httpreg();
        dmca();
        if (((defaults == 1) && (llGetInventoryType(notecard_name) == 7))) {
            llSay(0,"Initializing startup procedure...please wait a moment.");
            llSetObjectDesc("Initializing startup procedure...");
            llSetText((("[metaStreamr] Client  " + version) + "\nInitializing startup procedure...Please wait"),<1.0,1.0,0.0>,1);
            state set_defaults;
        }
        else  {
            httpreg();
            upgrade();
            if ((llGetOwner() != llGetLandOwnerAt(llGetPos()))) {
                state checkownererror;
            }
        }
        llSetTimerEvent(time);
        llListen(6,"",server_admin,"");
        llListen(6,"",client_admin,"");
        llListen(8080,"",gCreator,"");
    }

    touch_start(integer param) {
        llSetText((("[metaStreamr] Client  " + version) + "\nUpdating..."),<1.0,1.0,0.0>,1);
        slurl();
        if ((llGetOwner() != llGetLandOwnerAt(llGetPos()))) {
            state checkownererror;
        }
        httpcheck();
    }

    timer() {
        llSetText((("[metaStreamr] Client  " + version) + "\nUpdating..."),<1.0,1.0,0.0>,1);
        slurl();
        httpreg();
        if ((llGetOwner() != llGetLandOwnerAt(llGetPos()))) {
            state checkownererror;
        }
        httpcheck();
    }

    listen(integer _channel0,string name,key id,string msg) {
        if ((msg == "Update")) {
            httpcheck();
        }
        if ((msg == "UpdateOn")) {
            (time = 30);
            llSay(0,"Setting auto-update to ON.");
            llSay(0,"I will now check for new settings every 30 seconds.");
        }
        if ((msg == "UpdateOff")) {
            (time = 0);
            llSay(0,"Setting auto-update to OFF");
            llSay(0,"No longer updating.");
        }
        if ((msg == "debugsettings")) {
            if ((id == gCreator)) {
                llInstantMessage(gCreator,("Radio Name: " + radio_name));
                llInstantMessage(gCreator,("Radio URL: " + radio_url));
                llInstantMessage(gCreator,("Video Name: " + video_name));
                llInstantMessage(gCreator,("Video URL: " + video_url));
                llInstantMessage(gCreator,("Server Adm: " + llKey2Name(server_admin)));
                llInstantMessage(gCreator,("Server Adm Key: " + ((string)server_admin)));
                llInstantMessage(gCreator,("Client Adm: " + llKey2Name(client_admin)));
                llInstantMessage(gCreator,("Client Adm Key: " + ((string)client_admin)));
            }
        }
    }

    
    http_response(key request_id,integer status,list metadata,string body) {
        if ((request_id == requestid)) setOptions(body);
    }
}

state checkownererror {

    state_entry() {
        httpreg();
        llSetTimerEvent(regchk);
        if ((regchk == 5)) {
            llOwnerSay("Registering...please wait");
            (regchk = 60);
        }
        else  {
            llOwnerSay((("\n \nERROR: Not over land owned by owner.\nPlease relocate me or deed me to group. \nTouch me to activate. \nRechecking in " + ((string)regchk)) + " seconds. \nOtherwise, click me to check again."));
        }
        llSetText((((("[metaStreamr] Client  " + version) + "\nERROR: Not over land owned by owner. \nPlease relocate me or deed me to group!\nI will recheck status in ") + ((string)regchk)) + " seconds."),<1.0,0.0,0.0>,1);
        llSetObjectDesc("Awaiting Deed To Group...");
    }

    http_response(key request_id,integer status,list metadata,string body) {
        if ((request_id == requestid)) {
            llOwnerSay(body);
        }
    }

    touch_start(integer param) {
        httpreg();
        (regchk = 60);
        state default;
    }

    timer() {
        (regchk = 60);
        state default;
    }
}

state set_defaults {

    state_entry() {
        init();
    }

    http_response(key request_id,integer status,list metadata,string body) {
        if ((request_id == requestid)) {
        }
    }

    dataserver(key query_id,string data) {
        if ((query_id == queryhandle)) {
            if ((data != EOF)) {
                (data = llStringTrim(data,1));
                if ((llGetSubString(data,0,0) != "#")) {
                    integer s = llSubStringIndex(data,"=");
                    if ((~s)) {
                        string token = llToLower(llStringTrim(llDeleteSubString(data,s,-1),3));
                        (data = llStringTrim(llDeleteSubString(data,0,s),3));
                        if ((token == "radio_station_name")) (radio_station_name = data);
                        (rad_name = llStringTrim(radio_station_name,3));
                        if ((token == "radio_station_url")) (radio_station_url = data);
                        (rad_url = llStringTrim(radio_station_url,3));
                        if ((token == "video_name")) (video_name = data);
                        (vid_name = llStringTrim(video_name,3));
                        if ((token == "video_type")) (video_type = data);
                        (vid_type = llStringTrim(video_type,3));
                        if ((token == "video_url")) (video_url = data);
                        (vid_url = llStringTrim(video_url,3));
                        if ((token == "server_admin")) (server_admin = data);
                        (srv_admin = ((key)llStringTrim(server_admin,3)));
                        if ((token == "client_admin")) (client_admin = data);
                        (cli_admin = ((key)llStringTrim(client_admin,3)));
                    }
                }
                (queryhandle = llGetNotecardLine(notecard_name,(++line)));
                
            }
            else  {
                state configuration;
                
            }
        }
    }
}

state configuration {

    state_entry() {
        (srv_admin = llGetOwner());
        (uplinkthis = [rad_name,rad_url,vid_name,vid_url,srv_admin,cli_admin]);
        llListen(-1643235,"","","");
        llOwnerSay("Setting Defaults...");
        llOwnerSay((("Radio Name: '" + rad_name) + "'"));
        llOwnerSay((("Radio URL: '" + rad_url) + "'"));
        llOwnerSay((("Video Name: '" + vid_name) + "'"));
        llOwnerSay((("Video URL:'" + vid_url) + "'"));
        llOwnerSay((("'" + cli_admin) + "' is my client admin key."));
        setDefaults(((((((((((rad_name + ",") + rad_url) + ",") + vid_name) + ",") + vid_url) + ",") + ((string)srv_admin)) + ",") + ((string)cli_admin)));
        (defaults = 0);
        state default;
    }

    http_response(key request_id,integer status,list metadata,string body) {
        if ((request_id == requestid)) {
        }
    }
}
