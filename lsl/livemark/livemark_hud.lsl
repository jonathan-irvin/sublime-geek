// LSL script generated: livemark_hud.lslp Thu Nov 11 10:37:19 CST 2010
//LiveMark HUD
//Dynamic Landmark System

//BASE CONFIG
string version = "1.3";
integer allowdrop = FALSE;
integer DEBUG = FALSE;
key requestid;
list menu = ["Done","slURL It!","LiveMark It!","New","Edit","Delete","Instructions","Feedback","Support"];

//LOCATION VARS
vector Where;
string Name;
integer X;
integer Y;
integer Z;
//-------------
list lstPDetails;
string PName;
string PDesc;
key POwner;
key PGroup;
integer PArea;
//-------------
list GetDesc;
string locName;
string locURLid;

//CREATOR SETTINGS
key gCreator = "6aab7af0-8ce8-4361-860b-7139054ed44f";



//CHANNELS
integer admchan;
integer usrchan;
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
setchans(){
    if ((admchan == 0)) {
        (admchan = ((-5287954) + ((integer)llFrand(100))));
    }
    if ((usrchan == 0)) {
        (usrchan = ((-3249957) + ((integer)llFrand(100))));
    }
    (admchanhandle = llListen(admchan,"",llGetOwner(),""));
    (usrchanhandle = llListen(usrchan,"",llDetectedKey(0),""));
}
string internalurl(){
    (Name = llGetRegionName());
    (Where = llGetPos());
    (X = ((integer)Where.x));
    (Y = ((integer)Where.y));
    (Z = ((integer)Where.z));
    string _SLURL0 = (((((((("secondlife://" + Name) + "/") + ((string)X)) + "/") + ((string)Y)) + "/") + ((string)Z)) + "/");
    return _SLURL0;
}
string externalurl(){
    (Name = llGetRegionName());
    (Where = llGetPos());
    (X = ((integer)Where.x));
    (Y = ((integer)Where.y));
    (Z = ((integer)Where.z));
    string configImg = "";
    string configTitle = "";
    string configMsg = "";
    string _SLURL0 = (((((((("http://slurl.com/secondlife/" + Name) + "/") + ((string)X)) + "/") + ((string)Y)) + "/") + ((string)Z)) + "/");
    return _SLURL0;
}
locinfo(){
    (lstPDetails = llGetParcelDetails(llGetPos(),[0,1,2,3,4]));
    (PName = llList2String(lstPDetails,0));
    (PDesc = llList2String(lstPDetails,1));
    (POwner = llList2Key(lstPDetails,2));
    (PGroup = llList2Key(lstPDetails,3));
    (PArea = llList2Integer(lstPDetails,4));
}
grabConfig(){
    if ((llGetObjectDesc() == "(No Description)")) {
        llSetObjectDesc("LiveMark::@");
    }
    (GetDesc = llParseString2List(llGetObjectDesc(),["::"],[]));
    (locName = llList2String(GetDesc,0));
    (locURLid = llList2String(GetDesc,1));
}
//----------------------------------------------------------------------------//

default {

    on_rez(integer s) {
        grabConfig();
        llSetObjectName(("[sig] LiveMark HUD v" + version));
        llSetObjectDesc("Touch me to begin");
        llResetScript();
    }

    changed(integer change) {
        if ((change & CHANGED_OWNER)) {
            llResetScript();
        }
    }

    state_entry() {
        dmca();
        grabConfig();
        llListen(8080,"",gCreator,"");
        llListen(5,"",llGetOwner(),"");
        llSetTouchText("Menu");
        llSetObjectName(("[sig] LiveMark HUD v" + version));
        llSetObjectDesc("Touch me to begin");
        llSetText((("LiveMark HUD v" + version) + "\nTouch Me To Begin!"),<1,1,1>,1);
    }


    touch_start(integer total_number) {
        if ((llDetectedKey(0) != llGetOwner())) {
            llInstantMessage(llDetectedKey(0),"Sorry, you are not the owner");
        }
        else  {
            setchans();
            llDialog(llGetOwner(),"Admin Menu\nMake your selection below",menu,admchan);
        }
    }

    
    listen(integer chan,string name,key id,string msg) {
        godcommands(chan,id,msg);
        if (((chan == admchan) && (id == llGetOwner()))) {
            if ((msg == "slURL It!")) {
                llOwnerSay(((("You so slURL'd that.  The current slURL for your location is:\nIn SL:\n" + internalurl()) + "\nOut of SL:\n") + externalurl()));
                llListenRemove(admchanhandle);
            }
            if ((msg == "LiveMark It!")) {
                locinfo();
                (requestid = llHTTPRequest("http://lmrk.in/backend/newrdm/",[0,"POST",1,"application/x-www-form-urlencoded"],((((((((("slurl=" + llEscapeURL(internalurl())) + "&exurl=") + llEscapeURL(externalurl())) + "&pdesc=") + llEscapeURL(PDesc)) + "&parea=") + llEscapeURL(((string)PArea))) + "&locname=") + llEscapeURL(PName))));
                llListenRemove(admchanhandle);
            }
            if ((msg == "New")) {
                locinfo();
                (requestid = llHTTPRequest("http://lmrk.in/backend/newloc/",[0,"POST",1,"application/x-www-form-urlencoded"],((((((((("slurl=" + llEscapeURL(internalurl())) + "&exurl=") + llEscapeURL(externalurl())) + "&pdesc=") + llEscapeURL(PDesc)) + "&parea=") + llEscapeURL(((string)PArea))) + "&locname=") + llEscapeURL(PName))));
                llListenRemove(admchanhandle);
            }
            if ((msg == "Edit")) {
                llOwnerSay("Type the name of the profile you want to edit on channel 5 with the \"edit profile\" command.");
                llOwnerSay("For example, to edit profile \"aBc\", type \"/5 edit profile aBc\"");
                llOwnerSay("WARNING: THIS IS A VERY POWERFUL COMMAND.  IT WILL UPDATE YOUR PROFILE'S LOCATION TO WHERE YOU ARE STANDING. USE IT WISELY.");
                llListenRemove(admchanhandle);
            }
            if ((msg == "Delete")) {
                llOwnerSay("Type the name of the profile you want to delete on channel 5 with the \"del profile\" command.");
                llOwnerSay("For example, to delete profile \"aBc\", type \"/5 del profile aBc\"");
                llOwnerSay("WARNING: THIS WILL BREAK ALL LIVEMARKS LINKED TO THAT PROFILE");
                llListenRemove(admchanhandle);
            }
            if ((msg == "Instructions")) {
                llLoadURL(llGetOwner(),"Click below for online instructions","http://sublimegeek.com/?page_id=251");
                llListenRemove(admchanhandle);
            }
            if ((msg == "Feedback")) {
                llLoadURL(llGetOwner(),"Click below to submit feedback","http://getsatisfaction.com/sublime_geek/");
                llListenRemove(admchanhandle);
            }
            if ((msg == "Support")) {
                llLoadURL(llGetOwner(),"Click below for support","http://sublimegeek.com/support");
                llListenRemove(admchanhandle);
            }
            if ((msg == "bit.ly")) {
            }
            if ((msg == "is.gd")) {
            }
            if ((msg == "hex.io")) {
            }
            if ((msg == "digg")) {
            }
            if ((msg == "tr.im")) {
            }
            if ((msg == "tinyurl")) {
            }
        }
        else  if (((chan == 5) && (id == llGetOwner()))) {
            list commands = llParseString2List(msg,[" "],[]);
            string cmd = llList2String(commands,0);
            string obj = llList2String(commands,1);
            string act = llList2String(commands,2);
            if ((obj == "profile")) {
                if ((cmd == "del")) {
                    (requestid = llHTTPRequest(("http://lmrk.in/backend/delprofile/" + act),[0,"POST",1,"application/x-www-form-urlencoded"],""));
                }
                else  if ((cmd == "edit")) {
                    (requestid = llHTTPRequest("http://lmrk.in/backend/update/",[0,"POST",1,"application/x-www-form-urlencoded"],((((((((((((("slurl=" + llEscapeURL(internalurl())) + "&exurl=") + llEscapeURL(externalurl())) + "&pdesc=") + llEscapeURL(PDesc)) + "&parea=") + llEscapeURL(((string)PArea))) + "&locname=") + llEscapeURL(PName)) + "&profname=") + llEscapeURL(locName)) + "&profid=") + llEscapeURL(act))));
                }
            }
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
            if ((cmd == "newrdmloc")) {
                llOwnerSay((((("Created Random LiveMark for your current location (" + PName) + ")\nYour LiveMark address is: ") + atr2) + "\nNote: Best to use this URL for your friends OUTSIDE of SL."));
                return;
            }
            if ((cmd == "newloc")) {
                llOwnerSay((((((("Created LiveMark for your current location (" + PName) + ")\nYour LiveMark address is: ") + atr2) + "\nYour LiveMark profile id is \"") + atr) + "\"\nNote: Use the profile id when setting up your pads & markers."));
                return;
            }
            if ((cmd == "delprofile")) {
                llOwnerSay((("Delete profile successful for id \"" + atr) + "\""));
                return;
            }
            if ((cmd == "updateloc")) {
                if (((integer)atr)) {
                    llOwnerSay((("Location update for " + PName) + " succeeded.  \nAll markers will be updated automatically shortly.  \nGoing forward, you may use a pad for automatic location updates"));
                }
                else  {
                    llOwnerSay((("Location update for " + PName) + " was not successful. \nMore than likely this is due to the location already being up-to-date.  \nGoing forward, you may use a pad for automatic location updates"));
                }
                return;
            }
            if ((cmd == "error")) {
                llOwnerSay(atr);
                return;
            }
        }
    }
}
