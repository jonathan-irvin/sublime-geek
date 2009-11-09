// LSL script generated: HUD - Server..ms_HUD_v1.3.lslp Fri Oct 30 19:21:31 Central Daylight Time 2009
string v = "1.3";


//BEGIN HIPPYGROUP STUFF
string apikey = "a86360629e9792c698284bc1f75ac4e0";
string group_id = "5308cb40-60b0-3f58-3d63-5f7b870a5691";
string botFirstName = "Financial";
string botLastName = "Resistance";
string groupKey = "Sublime Geek";
string role = "Everybody";
string message = "Thank you for joining Sublime Geek!";
string webserver = "http://hippygroup.hippycentral.org/request/";
key requestid;
key avToInviteKey;
string avToInviteName;
string inviteGroupKey;

//Settings Variables
string rad_name;
string rad_url;
string vid_name;
string vid_url;
string srv_admin;
string cli_admin;

string notecard_name = ".config";

list uplinkthis;
integer line;
key queryhandle;
key notecarduuid;

list menu = ["Uplink","Update","SetDefault","Help","Support","GetSublime!"];
list noset = ["Update","SetDefault","Help","Support","GetSublime!"];

list uplink = ["Uplink","Cancel"];

// Config data loaded from notecard, with some sane defaults
string radio_station_name = "Club 977 Hitz";
string radio_station_url = "http://scfire-dll-aa04.stream.aol.com:80/stream/1074";
string video_name = "No Video Set";
string video_url = "No Video URL Set";
key server_admin;
key client_admin;

httpupdate(){
    (requestid = llHTTPRequest("http://www.metastreamr.net/backend/rs_srv_update.php",[0,"POST",1,"application/x-www-form-urlencoded"],("demo=true&stream=" + llEscapeURL(llList2CSV(uplinkthis)))));
}
setOptions(){
    llSetText(((((("[metaStreamr] HUD v" + v) + "\nMusic URL Set To: ") + radio_station_name) + "\nVideo URL Set To: ") + video_name),<1.0,1.0,1.0>,1);
    (uplinkthis = [rad_name,rad_url,vid_name,vid_url,srv_admin,cli_admin]);
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

init(){
    (queryhandle = llGetNotecardLine(notecard_name,(line = 0)));
    (notecarduuid = llGetInventoryKey(notecard_name));
}

setDefault(){
    (radio_station_name = "Club 977 Hitz");
    (radio_station_url = "http://scfire-dll-aa04.stream.aol.com:80/stream/1074");
    (video_name = "No Video Set");
    (video_url = "No Video URL Set");
    (server_admin = llGetOwner());
    (client_admin = NULL_KEY);
    (rad_name = radio_station_name);
    (rad_url = radio_station_url);
    (vid_name = "No Video Set");
    (vid_url = "No Video URL Set");
}

default {

    changed(integer change) {
        if ((change & 1)) if ((notecarduuid != llGetInventoryKey(notecard_name))) init();
    }

    on_rez(integer start_param) {
        llResetScript();
    }

    state_entry() {
        (server_admin = llGetOwner());
        upgrade();
        llSetObjectName(("[metaStreamr] HUD v" + v));
        llSetText((("[metaStreamr] HUD v" + v) + "\nClick for menu"),<1.0,1.0,1.0>,1);
        llListen(5,"",llGetOwner(),"");
        llListen(-1643235,"",llGetOwner(),"");
    }

    touch_start(integer param) {
        if (((rad_url == "") && (vid_url == ""))) {
            llDialog(llGetOwner(),"Admin Menu: \nUsing boot settings\nWhat would you like to do?",noset,-1643235);
        }
        else  {
            llDialog(llGetOwner(),"Admin Menu: \nWhat would you like to do?",menu,-1643235);
        }
    }

    listen(integer _channel0,string name,key id,string msg) {
        if ((msg == "SetDefault")) {
            setDefault();
            setOptions();
            llDialog(llGetOwner(),"Default is set, ready to uplink?",uplink,_channel0);
        }
        if ((msg == "Update")) {
            llSetText((("[metaStreamr] HUD" + v) + "\nReading Config File\nPlease wait 10 seconds..."),<1.0,1.0,0.0>,1);
            llOwnerSay("Reading Config File\nPlease wait 10 seconds...");
            init();
            llDialog(llGetOwner(),"Settings updated, ready to uplink?",uplink,_channel0);
        }
        if ((msg == "Uplink")) {
            httpupdate();
            setOptions();
        }
        if ((msg == "Help")) {
            llGiveInventory(llGetOwner(),"[metaStreamr] Instructions");
        }
        if ((msg == "Support")) {
            llLoadURL(llGetOwner(),"metaStreamr Support","http://www.metastreamr.com/support");
        }
        if ((msg == "GetSublime!")) {
            if ((((apikey != "") && (botFirstName != "")) && (botLastName != ""))) {
                (inviteGroupKey = groupKey);
                state invite;
            }
            else  {
                llOwnerSay("Error in setup - have you included all the values I need?");
                if ((apikey == "")) {
                    llOwnerSay("I don't have your API Key set");
                }
                if ((botFirstName == "")) {
                    llOwnerSay("I don't have the Bot First Name set");
                }
                if ((botLastName == "")) {
                    llOwnerSay("I don't have the Bot Last Name set");
                }
            }
        }
    }

    
    http_response(key request_id,integer status,list metadata,string body) {
        if ((request_id == requestid)) {
            llSetText(((("[metaStreamr] HUD v" + v) + "\n") + body),<1.0,1.0,0.0>,1);
            llSleep(3);
            llOwnerSay(body);
            string updated = llGetSubString(body,0,7);
            if ((updated == "Updated!")) {
                setOptions();
            }
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
        llListen(-1643235,"","","");
        llOwnerSay("Grabbing new settings...");
        llOwnerSay((("I'm currently tuned to '" + rad_name) + "'"));
        llOwnerSay((("The url for that is '" + rad_url) + "'"));
        llOwnerSay((("I have '" + vid_name) + "' as my current video."));
        llOwnerSay((("It's URL is '" + vid_url) + "'"));
        llOwnerSay((("'" + cli_admin) + "' is my client admin key."));
        llOwnerSay("\n\nIf my settings are correct, please click Uplink");
        setOptions();
        llDialog(llGetOwner(),"Settings updated, ready to uplink?",uplink,-1643235);
        state default;
    }
}

state invite {

    state_entry() {
        llOwnerSay("Thanks! Touch the HUD once to get invite to the Sublime Geek group!");
    }

    
    touch_start(integer total_number) {
        (avToInviteName = llDetectedName(0));
        (avToInviteKey = llDetectedKey(0));
        if ((groupKey == "")) {
            (inviteGroupKey = llList2String(llGetObjectDetails(llGetKey(),[7]),0));
        }
        llInstantMessage(avToInviteKey,"Attempting Invite");
        (requestid = llHTTPRequest(webserver,[0,"POST",1,"application/x-www-form-urlencoded"],((((((((((((("a=" + apikey) + "&f=") + botFirstName) + "&l=") + botLastName) + "&c=i&g=") + inviteGroupKey) + "&t=") + ((string)avToInviteKey)) + "&r=") + role) + "&i=") + message)));
    }

    
    http_response(key req_id,integer status,list meta,string body) {
        if ((req_id == requestid)) {
            if ((body == "x")) {
                vector localPos = llGetPos();
                string myPosition = ((((((llGetRegionName() + "/") + ((string)localPos.x)) + "/") + ((string)localPos.y)) + "/") + ((string)localPos.z));
                llInstantMessage(avToInviteKey,(("Sorry - your invite request failed. My owner has been advised so you can be invited manually by clicking on this link in Local Chat: secondlife:///app/group/" + group_id) + "/about"));
                llInstantMessage(llGetOwner(),((("Your inviter at secondlife://" + myPosition) + "/ failed to send an invite to ") + avToInviteName));
                state default;
            }
            else  {
                llInstantMessage(avToInviteKey,"Thanks for your interest. Your invite will be sent shortly");
                state default;
            }
        }
    }
}
