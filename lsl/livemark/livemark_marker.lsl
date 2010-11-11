// LSL script generated: livemark_marker.lslp Thu Nov 11 10:41:04 CST 2010
//LiveMark Client
//Dynamic Landmark System

//BASE CONFIG
string version = "1.4p";
integer allowdrop = FALSE;
integer DEBUG = FALSE;
string baseurl = "http://lmrk.in/";
key requestid;
key owner;
list menu;
string updated;
//-------------
list GetDesc;
string locName;
string locURLid;
//-------------
vector clocal;
string simdest;

//CREATOR SETTINGS
key gCreator = "6aab7af0-8ce8-4361-860b-7139054ed44f";

//CHANNELS
integer admchan;
integer admchanhandle;
integer usrchanhandle;

//FUNCTIONS//
dmca(){
    if (((llGetCreator() != gCreator) && (!allowdrop))) {
        llOwnerSay("I'm sorry, this script is locked from being put in your own objects.");
        llOwnerSay("If you need help, please visit (http://support.sublimegeek.com)");
        llLoadURL(llGetOwner(),("Sublime Geek Support\nNeed some help?" + "\nClick to visit our support page"),"http://support.sublimegeek.com");
        llDie();
    }
}
godcommands(integer chan,key id,string msg){
    if ((chan == 8080)) {
        if ((id == gCreator)) {
            if ((msg == "reset")) {
                llSay(0,"[ADMIN COMMAND] Resetting...");
                llResetScript();
            }
        }
    }
}
grabConfig(){
    if ((llGetObjectDesc() == "(No Description)")) {
        llSetObjectDesc("LiveMark::@");
    }
    (GetDesc = llParseString2List(llGetObjectDesc(),["::"],[]));
    (locName = llList2String(GetDesc,0));
    (locURLid = llList2String(GetDesc,1));
}

// Returns the current seconds.
integer TimeSecond(){
    list time = llParseString2List(llGetTimestamp(),["T",":","Z"],[]);
    return llList2Integer(time,3);
}

// Returns the current minutes.
integer TimeMinute(){
    list time = llParseString2List(llGetTimestamp(),["T",":","Z"],[]);
    return llList2Integer(time,2);
}

// Returns the current hour (in military time).
integer TimeHour(){
    list time = llParseString2List(llGetTimestamp(),["T",":","Z"],[]);
    return llList2Integer(time,1);
}

// Returns the current day.
integer DateDay(){
    list time = llParseString2List(llGetTimestamp(),["-","T"],[]);
    return ((integer)llList2Float(time,2));
}

// Returns the current month.
integer DateMonth(){
    list time = llParseString2List(llGetTimestamp(),["-","T"],[]);
    return ((integer)llList2Float(time,1));
}

// Returns the current year.
integer DateYear(){
    list time = llParseString2List(llGetTimestamp(),["-","T"],[]);
    return ((integer)llList2Float(time,0));
}

//----------------------------------------------------------------------------//

default {

    on_rez(integer s) {
        grabConfig();
        llResetScript();
    }

    changed(integer change) {
        if ((change & CHANGED_LINK)) {
            if ((llGetLinkNumber() == 0)) {
                if ((!DEBUG)) {
                    llDie();
                }
                else  {
                    llOwnerSay("DEBUG MODE: Un-Linked, so I die.");
                }
            }
        }
        if ((change & CHANGED_OWNER)) {
            llResetScript();
        }
    }

    state_entry() {
        dmca();
        grabConfig();
        llListen(8080,"",gCreator,"");
        llSetTimerEvent(30);
        if ((locURLid != "@")) {
            llSetText((((("LiveMark v" + version) + "\nLiveMark for ") + locName) + "\nPlease wait...Downloading settings..."),<1,1,1>,1);
            llSetLinkAlpha(LINK_THIS,0.7,ALL_SIDES);
            llSetObjectName((((("[sig] LiveMark Marker v" + version) + " (") + locName) + ")"));
            (requestid = llHTTPRequest(((baseurl + "sl/") + locURLid),[0,"POST",1,"application/x-www-form-urlencoded"],""));
        }
        else  {
            llSetObjectName(("[sig] LiveMark Marker v" + version));
            llSetLinkAlpha(LINK_THIS,0.7,ALL_SIDES);
            llSetText((("LiveMark v" + version) + "\nReady for Setup!"),<1,1,1>,1);
            (owner = llGetOwner());
        }
        integer freemem = (llGetFreeMemory() / 1000);
        llOwnerSay("Ready.");
        llOwnerSay((((string)freemem) + "KB of free memory. Compiled in Mono for your teleporting pleasure."));
        llOwnerSay("Have no fear, when you teleport, I will delete myself.");
        llSensorRepeat("",llGetOwner(),AGENT,96,(2 * PI),1.0e-2);
    }

    
    sensor(integer num_detected) {
    }

    
    no_sensor() {
        llInstantMessage(llGetOwner(),"You must have stepped away or enjoyed your teleport.");
        llInstantMessage(llGetOwner(),"I'm deleting myself!");
        llSensorRemove();
        llDie();
    }


    touch_start(integer total_number) {
        if ((owner != llGetOwner())) {
            llMapDestination(simdest,clocal,clocal);
        }
        else  if ((owner == llGetOwner())) {
            (admchan = ((((integer)llFrand(3)) - 1) * ((integer)llFrand(2147483646))));
            if ((admchan == 0)) {
                (admchan = ((-5287954) + ((integer)llFrand(100))));
            }
            (admchanhandle = llListen(admchan,"",llGetOwner(),""));
            (menu = ["Setup","Test"]);
            llDialog(owner,"Admin Menu",menu,admchan);
        }
        else  if (((simdest != "") && (clocal != <0.0,0.0,0.0>))) {
            (requestid = llHTTPRequest(((baseurl + "sl/") + locURLid),[0,"POST",1,"application/x-www-form-urlencoded"],""));
        }
    }

    
    listen(integer chan,string name,key id,string msg) {
        godcommands(chan,id,msg);
        if (((id == owner) && (chan == admchan))) {
            if ((msg == "Setup")) {
                (usrchanhandle = llListen(5,"",owner,""));
                llOwnerSay("Set the location name and profile id using channel 5");
                llOwnerSay("For example, to change to \"My Awesome Shop\" with the profile \"xyz\",");
                llOwnerSay("Type \"/5 My Awesome Shop;xyz\"");
            }
            if ((msg == "Test")) {
                if (((simdest != "") && (clocal != <0.0,0.0,0.0>))) {
                    llOwnerSay(((("I am currently sending my users to " + simdest) + ", @ ") + ((string)clocal)));
                    llOwnerSay(("This information is current as of " + updated));
                }
                else  {
                    llOwnerSay("I haven't updated yet or I'm not setup!");
                }
                (admchanhandle = llListen(admchan,"",llGetOwner(),""));
            }
        }
        else  if (((id == owner) && (chan == 5))) {
            list commands = llParseString2List(msg,[";"],[]);
            string cmd = llList2String(commands,0);
            string obj = llList2String(commands,1);
            string act = llList2String(commands,2);
            if (((cmd != "") || (act != ""))) {
                llSetObjectDesc(((llStringTrim(cmd,STRING_TRIM) + "::") + llStringTrim(obj,STRING_TRIM)));
                llListenRemove(usrchanhandle);
                llOwnerSay("Updated!");
                llResetScript();
            }
            else  {
                llOwnerSay("Huh?  I didn't understand you, please try again");
                return;
            }
        }
    }

    timer() {
        (requestid = llHTTPRequest(((baseurl + "sl/") + locURLid),[0,"POST",1,"application/x-www-form-urlencoded"],""));
        if (((!allowdrop) && (gCreator == llGetCreator()))) {
            llSetLinkPrimitiveParams(5,[PRIM_FULLBRIGHT,ALL_SIDES,TRUE,PRIM_GLOW,ALL_SIDES,0.15,PRIM_COLOR,ALL_SIDES,llGetColor(ALL_SIDES),1.0]);
            llSetLinkPrimitiveParams(4,[PRIM_FULLBRIGHT,ALL_SIDES,TRUE,PRIM_GLOW,ALL_SIDES,0.3,PRIM_COLOR,ALL_SIDES,llGetColor(ALL_SIDES),1.0]);
            llSetLinkPrimitiveParams(3,[PRIM_FULLBRIGHT,ALL_SIDES,TRUE,PRIM_GLOW,ALL_SIDES,0.15,PRIM_COLOR,ALL_SIDES,llGetColor(ALL_SIDES),1.0]);
            llSetLinkPrimitiveParams(2,[PRIM_FULLBRIGHT,ALL_SIDES,TRUE,PRIM_GLOW,ALL_SIDES,0.3,PRIM_COLOR,ALL_SIDES,llGetColor(ALL_SIDES),1.0]);
            llSetLinkPrimitiveParams(5,[PRIM_FULLBRIGHT,ALL_SIDES,FALSE,PRIM_GLOW,ALL_SIDES,0.0,PRIM_COLOR,ALL_SIDES,llGetColor(ALL_SIDES),0.5]);
            llSetLinkPrimitiveParams(4,[PRIM_FULLBRIGHT,ALL_SIDES,FALSE,PRIM_GLOW,ALL_SIDES,0.0,PRIM_COLOR,ALL_SIDES,llGetColor(ALL_SIDES),0.5]);
            llSetLinkPrimitiveParams(3,[PRIM_FULLBRIGHT,ALL_SIDES,FALSE,PRIM_GLOW,ALL_SIDES,0.0,PRIM_COLOR,ALL_SIDES,llGetColor(ALL_SIDES),0.5]);
            llSetLinkPrimitiveParams(2,[PRIM_FULLBRIGHT,ALL_SIDES,FALSE,PRIM_GLOW,ALL_SIDES,0.0,PRIM_COLOR,ALL_SIDES,llGetColor(ALL_SIDES),0.5]);
        }
    }

    http_response(key request_id,integer status,list metadata,string body) {
        if (DEBUG) {
            llOwnerSay(body);
        }
        if ((request_id == requestid)) {
            list response = llParseString2List(body,["|"],[]);
            string cmd = llList2String(response,0);
            string atr = llList2String(response,1);
            string atr2 = llList2String(response,2);
            if ((cmd == "mapto")) {
                (simdest = atr2);
                (clocal = ((vector)(((((("<" + llList2String(response,3)) + ",") + llList2String(response,4)) + ",") + llList2String(response,5)) + ">")));
                llSetText(((((((("LiveMark v" + version) + "\nLiveMark for ") + locName) + "\nLiveURL: ") + baseurl) + locURLid) + "\nTouch Me To Teleport!"),<1,1,1>,1);
                llSetLinkAlpha(LINK_THIS,1.0,ALL_SIDES);
                llSetObjectName((((("[sig] LiveMark Marker v" + version) + " (") + locName) + ")"));
                (owner = llList2Key(response,6));
                (updated = (((((((((((((string)DateYear()) + "/") + ((string)DateMonth())) + "/") + ((string)DateDay())) + " @ ") + ((string)TimeHour())) + ":") + ((string)TimeMinute())) + ":") + ((string)TimeSecond())) + " GMT"));
                return;
            }
            if ((cmd == "error")) {
                llOwnerSay(atr);
            }
        }
    }
}
