//LiveMark Client
//Dynamic Landmark System

//BASE CONFIG
string version    = "1.3";
integer allowdrop = FALSE;
integer DEBUG     = FALSE;
string baseurl    = "http://lmrk.in/";
float time = 0.1;
key requestid;
key owner;
list menu;
string updated;
string salt = "2x4DVGxGMFQ3ULHxf61b";

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
//-------------
vector newloc;
integer xloc;
integer yloc;
integer zloc;
//-------------
vector clocal;
vector cglobal;
string simdest;
key dataquery;

//CREATOR SETTINGS
key gCreator = "6aab7af0-8ce8-4361-860b-7139054ed44f";
key gBank    = "633ccfe5-9eae-4e3a-8abb-48773dee0edf";

//CHANNELS
integer admchan;
integer usrchan;
integer admchanhandle;
integer usrchanhandle;

//FUNCTIONS//
dmca(){
    if ((llGetCreator() != gCreator) && (!allowdrop)) {
        llOwnerSay("I'm sorry, this script is locked from being put in your own objects.");
        llOwnerSay("If you need help, please visit (http://support.sublimegeek.com)");
        llLoadURL(llGetOwner(),"Sublime Geek Support\nNeed some help?" +
        "\nClick to visit our support page","http://support.sublimegeek.com");
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
sysMessage(integer destination,string command,string request){
    llMessageLinked(-4,destination,((command + "|") + request),NULL_KEY);
}
setchans(){
    if ((admchan == 0)) {(admchan = (-5287954 + ((integer)llFrand(100))));}
    if ((usrchan == 0)) {(usrchan = (-3249957 + ((integer)llFrand(100))));}
    (admchanhandle = llListen(admchan,"",llGetOwner()    ,""));
    (usrchanhandle = llListen(usrchan,"",llDetectedKey(0),""));
}
string internalurl(){
    (Name = llGetRegionName());
    (Where = llGetPos());
    (X = ((integer)Where.x));
    (Y = ((integer)Where.y));
    (Z = ((integer)Where.z));
    string _SLURL0 = "secondlife://"+Name+"/"+(string)X+"/"+(string)Y+"/"+(string)Z+"/";
    
    //http://slurl.com/secondlife/Region/XXX/YYY/ZZZ/?img=WindowImg&title=WindowTitle&msg=WindowMsg
    
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
    
    string _SLURL0 = "http://slurl.com/secondlife/"+Name+
    "/"+(string)X+"/"+(string)Y+"/"+(string)Z+"/";    
    
    return _SLURL0;
}
locinfo(){
    lstPDetails = llGetParcelDetails(llGetPos(),[0,1,2,3,4]);
    PName = llList2String(lstPDetails,0);
    PDesc = llList2String(lstPDetails,1);
    POwner = llList2Key(lstPDetails,2);
    PGroup = llList2Key(lstPDetails,3);
    PArea = llList2Integer(lstPDetails,4);    
}
grabConfig(){
    if(llGetObjectDesc() == "(No Description)"){llSetObjectDesc("LiveMark::@");}
    GetDesc  = llParseString2List(llGetObjectDesc(),["::"],[]);
    locName  = llList2String(GetDesc,0);
    locURLid = llList2String(GetDesc,1);
}
setloc(){    
    locinfo();
    requestid = llHTTPRequest("http://www.sublimegeek.com/backend/lm_addloc.php",
    [0,"POST",1,"application/x-www-form-urlencoded"],
    "slurl="       +llEscapeURL(internalurl())+
    "&exurl="      +llEscapeURL(externalurl())+
    "&pdesc="      +llEscapeURL(PDesc)+
    "&parea="      +llEscapeURL((string)PArea)+
    "&locname="    +llEscapeURL(PName)+
    "&profname="   +llEscapeURL(locName));
}

// Returns the current millisecond.
integer TimeMillisecond()
{
    list time = llParseString2List(llGetTimestamp(), ["."], []);
    llOwnerSay(llGetTimestamp());
    return (integer)llGetSubString(llList2String(time, 1), 0, 1);
}

// Returns the current seconds.
integer TimeSecond()
{
    list time = llParseString2List(llGetTimestamp(), ["T",":","Z"], []);
    return llList2Integer(time, 3);
}

// Returns the current minutes.
integer TimeMinute()
{
    list time = llParseString2List(llGetTimestamp(), ["T",":","Z"], []);
    return llList2Integer(time, 2);
}

// Returns the current hour (in military time).
integer TimeHour()
{
    list time = llParseString2List(llGetTimestamp(), ["T",":","Z"], []);
    return llList2Integer(time, 1);
}

// Returns the time for a specific hour, minute, and second in the format HH:MM:SS AM/PM.
string TimeSerial(integer hour, integer minute, integer second)
{
    string AMPM = "AM";
    string min = (string)minute;
    string sec = (string)second;
    if (hour > 12)
    {
        AMPM = "PM";
        hour -= 12;
    }
    if (minute < 10) min = "0" + min;
    if (second < 10) sec = "0" + sec; 
    return (string)hour + ":" + min + ":" + sec + " " + AMPM;
}

// Returns the current day.
integer DateDay()
{
    list time = llParseString2List(llGetTimestamp(), ["-", "T"], []);
    return (integer)llList2Float(time, 2);
}

// Returns the current month.
integer DateMonth()
{
    list time = llParseString2List(llGetTimestamp(), ["-", "T"], []);
    return (integer)llList2Float(time, 1);
}

// Returns the current year.
integer DateYear()
{
    list time = llParseString2List(llGetTimestamp(), ["-", "T"], []);
    return (integer)llList2Float(time, 0);
}

// Returns the name of a specified month.  If abbreviate is TRUE only the 1st 3 letters of
// the month will be returned.
string DateMonthName(integer month, integer abbreviate)
{
    list name = ["January", "February", "March", "April", "May", "June", "July", "August",
        "September", "November", "December"];
    string str = llGetSubString(llList2String(name, month - 1), 0, -1);
    if (abbreviate)
        str = llGetSubString(str, 0, 2);    
    return str;    
}

// Returns the name of the day of the week for a given date.  If abbreviate is TRUE
// only the 1st 3 letters of the day will be returned.
// * Uses Christian Zeller's congruence algorithm to calculate the day of the week.
string DateDayName(integer month, integer day, integer year, integer abbreviate)
{
    list name = ["Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
    if (month < 3)
    {
        month += 12;
        year -= 1;
    }
    integer index = (day + 2*month + (3*(month + 1))/5 + year + year/4 - year/100 + year/400 + 2) % 7;
    string str = llGetSubString(llList2String(name, index), 0, -1);
    if (abbreviate)
        str = llGetSubString(str, 0, 2);    
    return str;
}

//----------------------------------------------------------------------------//

default
{
    on_rez(integer s){
        grabConfig();
        llResetScript();}
    changed(integer change) {
        if (change & CHANGED_LINK){ 
            if (llGetLinkNumber() == 0){
                if(!DEBUG){llDie();}else{llOwnerSay("DEBUG MODE: Un-Linked, so I die.");}
            }
        }
        if (change & CHANGED_OWNER){
            llResetScript();
        }
    }
    state_entry()
    {
        dmca();        
        grabConfig();        
        llListen(8080,"",gCreator,"");                
        llSetTimerEvent(30);
        if(locURLid != "@"){
            llSetText("LiveMark v"+version+"\nLiveMark for "+locName+
            "\nPlease wait...Downloading settings...",<1,1,1>,1);
            llSetLinkAlpha(LINK_THIS, 0.7, ALL_SIDES);
            llSetObjectName("[sig] LiveMark Marker v"+version+" ("+locName+")");
            
            requestid = llHTTPRequest(baseurl+"sl/"+locURLid,[0,"POST",1,"application/x-www-form-urlencoded"],"");            
        }else{            
            llSetObjectName("[sig] LiveMark Marker v"+version);
            llSetLinkAlpha(LINK_THIS, 0.7, ALL_SIDES);
            llSetText("LiveMark v"+version+"\nReady for Setup!",<1,1,1>,1);
            owner = llGetOwner();
        }
        integer freemem = llGetFreeMemory() / 1000;
        llOwnerSay("Ready.");
        llOwnerSay((string)freemem+"KB of free memory. Compiled in Mono for your teleporting pleasure.");
        llOwnerSay("Have no fear, when you teleport, I will delete myself.");
        llSensorRepeat("",llGetOwner(),AGENT,96,2*PI,.01);
    }
    
    sensor(integer num_detected){}
    
    no_sensor(){
        llInstantMessage(llGetOwner(),"You must have stepped away or enjoyed your teleport.");
        llInstantMessage(llGetOwner(),"I'm deleting myself!");        
        llSensorRemove();
        llDie();
    }

    touch_start(integer total_number)
    {
        if(llDetectedKey(0) != llGetOwner()){
            llInstantMessage(llDetectedKey(0),"Sorry, you are not the owner");
        }else{
            if(owner != llGetOwner()){
                llMapDestination(simdest,clocal,clocal);
            }else if(owner == llGetOwner()){
                    //GENERATE RANDOM CHANNELS FOR COMMS
                    admchan = ((integer) llFrand(3) - 1) * ((integer) llFrand(2147483646));
                    
                    //FALL BACK TO SECURE CHANNELS IF EITHER IS BAD
                    if(admchan == 0){admchan = -5287954 + (integer)llFrand(100);}
                    
                    //LISTEN HANDLER
                    admchanhandle = llListen(admchan,"",llGetOwner(),"");
                                        
                    menu = ["Setup","Test"];
                    llDialog(owner,"Admin Menu",menu,admchan);
            }else if((simdest != "")&&(clocal != <0.0, 0.0, 0.0>)){
                requestid = llHTTPRequest(baseurl+"sl/"+locURLid,[0,"POST",1,"application/x-www-form-urlencoded"],"");
            }
        }
    }
    
    listen(integer chan, string name, key id, string msg)
    {
        godcommands(chan,id,msg);
        
        if((id == owner)&&(chan == admchan)){
            if(msg == "Setup"){
                usrchanhandle = llListen(5,"",owner,"");
                llOwnerSay("Set the location name and profile id using channel 5");
                llOwnerSay("For example, to change to \"My Awesome Shop\" with the profile \"xyz\",");
                llOwnerSay("Type \"/5 My Awesome Shop;xyz\"");
            }
            if(msg == "Test"){
                if((simdest != "")&&(clocal != <0.0, 0.0, 0.0>)){
                    llOwnerSay("I am currently sending my users to "+simdest+", @ "+(string)clocal);
                    llOwnerSay("This information is current as of "+updated);
                }else{llOwnerSay("I haven't updated yet or I'm not setup!");}
                admchanhandle = llListen(admchan,"",llGetOwner(),"");
            }
        }else if((id == owner)&&(chan == 5)){
            list commands = llParseString2List(msg,[";"],[]);
            string cmd = llList2String(commands,0);
            string obj = llList2String(commands,1);
            string act = llList2String(commands,2);
            
            if((cmd != "")||(act != "")){
                llSetObjectDesc(
                    llStringTrim(cmd,STRING_TRIM)+"::"+llStringTrim(obj,STRING_TRIM)
                    );
                llListenRemove(usrchanhandle);
                llOwnerSay("Updated!");
                state default;                
            }else{
                llOwnerSay("Huh?  I didn't understand you, please try again");                
                return;
            }
        }
    }
    timer(){
        requestid = llHTTPRequest(baseurl+"sl/"+locURLid,[0,"POST",1,"application/x-www-form-urlencoded"],"");        
        llSetLinkPrimitiveParams(5, 
            [PRIM_FULLBRIGHT, ALL_SIDES, TRUE, PRIM_GLOW, ALL_SIDES, 0.15,PRIM_COLOR, ALL_SIDES, llGetColor(ALL_SIDES), 1.0]);        
        llSetLinkPrimitiveParams(4, 
            [PRIM_FULLBRIGHT, ALL_SIDES, TRUE, PRIM_GLOW, ALL_SIDES, 0.3,PRIM_COLOR, ALL_SIDES, llGetColor(ALL_SIDES), 1.0]);        
        llSetLinkPrimitiveParams(3, 
            [PRIM_FULLBRIGHT, ALL_SIDES, TRUE, PRIM_GLOW, ALL_SIDES, 0.15,PRIM_COLOR, ALL_SIDES, llGetColor(ALL_SIDES), 1.0]);        
        llSetLinkPrimitiveParams(2, 
            [PRIM_FULLBRIGHT, ALL_SIDES, TRUE, PRIM_GLOW, ALL_SIDES, 0.3,PRIM_COLOR, ALL_SIDES, llGetColor(ALL_SIDES), 1.0]);        
        llSetLinkPrimitiveParams(5, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.0,PRIM_COLOR, ALL_SIDES, llGetColor(ALL_SIDES), 0.5]);
        llSetLinkPrimitiveParams(4, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.0,PRIM_COLOR, ALL_SIDES, llGetColor(ALL_SIDES), 0.5]);
        llSetLinkPrimitiveParams(3, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.0,PRIM_COLOR, ALL_SIDES, llGetColor(ALL_SIDES), 0.5]);
        llSetLinkPrimitiveParams(2, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.0,PRIM_COLOR, ALL_SIDES, llGetColor(ALL_SIDES), 0.5]);
    }
    http_response(key request_id,integer status,list metadata,string body)
    {
        if(DEBUG){llOwnerSay(body);}
        if(request_id == requestid){
            list response = llParseString2List(body,["|"],[]);
            string cmd = llList2String(response,0);
            string atr = llList2String(response,1);
            string atr2 = llList2String(response,2);
            
            if(cmd == "mapto"){                
                //Load settings from the web                
                simdest     = atr2;
                clocal      = (vector)("<"+llList2String(response,3)+","+llList2String(response,4)+","+llList2String(response,5)+">");
                llSetText("LiveMark v"+version+"\nLiveMark for "+locName+
                "\nLiveURL: "+baseurl+locURLid+"\nTouch Me To Teleport!",<1,1,1>,1);
                llSetLinkAlpha(LINK_THIS, 1.0, ALL_SIDES);
                llSetObjectName("[sig] LiveMark Marker v"+version+" ("+locName+")");
                owner = llList2Key(response,6);
                updated = (string)DateYear()+"/"+(string)DateMonth()+"/"+(string)DateDay()+" @ "+(string)TimeHour()+":"+(string)TimeMinute()+":"+(string)TimeSecond()+" GMT";                
                return;                
            }
            if(cmd == "error"){
                llOwnerSay(atr);
            }
        }
    }     
}