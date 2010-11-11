//LiveMark Update Pad
//Dynamic Landmark System

//BASE CONFIG
string version    = "1.3";
integer allowdrop = FALSE;
integer DEBUG     = FALSE;
string baseurl    = "http://lmrk.in/";
integer show      = TRUE;
integer retries;
string  hidemenu;
key requestid;
key owner;
integer confighandle;

string salt = "2x4DVGxGMFQ3ULHxf61b";
list menu;

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
vector start;
integer xloc;
integer yloc;
integer zloc;

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
updateloc(){    
    locinfo();
    
    if(DEBUG){//What are we sending to the web
        llOwnerSay("slurl="       +llEscapeURL(internalurl())+
        "&exurl="      +llEscapeURL(externalurl())+
        "&pdesc="      +llEscapeURL(PDesc)+
        "&parea="      +llEscapeURL((string)PArea)+
        "&locname="    +llEscapeURL(PName)+
        "&profname="   +llEscapeURL(locName));
    }
    
    requestid = llHTTPRequest("http://lmrk.in/backend/update/",
    [0,"POST",1,"application/x-www-form-urlencoded"],
    "slurl="       +llEscapeURL(internalurl())+
    "&exurl="      +llEscapeURL(externalurl())+
    "&pdesc="      +llEscapeURL(PDesc)+
    "&parea="      +llEscapeURL((string)PArea)+
    "&locname="    +llEscapeURL(PName)+
    "&profname="   +llEscapeURL(locName)+
    "&profid="     +llEscapeURL(locURLid));    
}
//----------------------------------------------------------------------------//

default
{
    on_rez(integer s){
        grabConfig();
        llResetScript();}
    changed(integer change) {
        if (change & CHANGED_REGION){ 
            llOwnerSay("You moved me to a new sim.  Updating location now.");
            updateloc();
        }
        if (change & CHANGED_OWNER){
            llResetScript();
        }        
    }
    moving_start(){
        start = llGetPos();
        llSleep(5);
    }
    moving_end(){
        llOwnerSay("You moved me in the sim.  Updating location now.");
        updateloc();
    }
    state_entry()
    {
        dmca();        
        grabConfig();        
        llListen(8080,"",gCreator,"");
        llListen(-851095,"","","");        
        if(!DEBUG){llSetTimerEvent(300);}else{llSetTimerEvent(15);}
        llSetAlpha(show,ALL_SIDES);
        if(locURLid != "@"){
            llSetText("LiveMark Update Pad v"+version+"\nAuto-updating for:\n"+locName+"\n \n \n",<1,1,1>,1);            
            llSetObjectName("[sig] LiveMark Update Pad v"+version);
        }else{            
            llSetObjectName("[sig] LiveMark Update Pad v"+version);
            llSetText("LiveMark Update Pad v"+version+"\nReady for Setup!\nTouch me to begin!\n \n ",<1,1,1>,1);
        }
    }

    touch_start(integer total_number)
    {
        
        //GENERATE RANDOM CHANNELS FOR COMMS
        admchan = ((integer) llFrand(3) - 1) * ((integer) llFrand(2147483646));
        
        //FALL BACK TO SECURE CHANNELS IF EITHER IS BAD
        if(admchan == 0){admchan = -5287954 + (integer)llFrand(100);}
        
        //LISTEN HANDLER
        admchanhandle = llListen(admchan,"",llGetOwner(),"");
        
        if(show){hidemenu = "Hide";}else{hidemenu = "Show";}
        menu = ["Update","Setup",hidemenu];        
        
        if(llDetectedKey(0) != llGetOwner()){
            llInstantMessage(llDetectedKey(0),"Sorry, you are not the owner");
        }else{
            if(locURLid != "@"){                
                llSetText("LiveMark Update Pad v"+version+"\nAuto-updating for:\n"+locName+"\n \n \n",<1,1,1>,1);                
                llDialog(llDetectedKey(0),"LiveMark Update Pad Menu",menu,admchan);
                updateloc();
            }else{                
                llDialog(llDetectedKey(0),"LiveMark Update Pad Menu",menu,admchan);
            }
        }
    }
    
    listen(integer chan, string name, key id, string msg)
    {
        godcommands(chan,id,msg);
        if(DEBUG){llOwnerSay("("+(string)chan+") "+msg);}
        
        if(chan == -851095){
            if((locURLid == "@") && (msg == "editloc|"+llSHA1String((string)gCreator+(string)gBank+(string)llGetOwner()+salt))){
                llOwnerSay("User authenticated...Proceeding.");                
            }else {
                llInstantMessage(id,"Error: Authentication failed.");
            }
        }else if((chan == admchan) && (id == llGetOwner())){
            if(msg == "Setup"){
                llListenRemove(admchanhandle);
                state config;
            }
            if(msg == "Update"){
                if(locURLid != "@"){updateloc();}else{llOwnerSay("Error: Location hasn't been setup yet, please choose Setup");}
                llListenRemove(admchanhandle);
                return;
            }
            if(msg == "Hide"){
                show = FALSE;
                llSetAlpha(show,ALL_SIDES);
                if(locURLid != "@"){
                    llSetText("",<1,1,1>,1);            
                    llSetObjectName("[sig] LiveMark Update Pad v"+version);
                }else{            
                    llSetObjectName("[sig] LiveMark Update Pad v"+version);
                    llSetText("",<1,1,1>,1);
                }
                llListenRemove(admchanhandle);
                return;
            }
            if(msg == "Show"){
                show = TRUE;
                llSetAlpha(show,ALL_SIDES);
                if(locURLid != "@"){
                    llSetText("LiveMark Update Pad v"+version+"\nAuto-updating for:\n"+locName+"\n \n \n",<1,1,1>,1);            
                    llSetObjectName("[sig] LiveMark Update Pad v"+version);
                }else{            
                    llSetObjectName("[sig] LiveMark Update Pad v"+version);
                    llSetText("LiveMark Update Pad v"+version+"\nReady for Setup!\nTouch me to begin!\n \n ",<1,1,1>,1);
                }
                llListenRemove(admchanhandle);
                return;
            }
            
        }
    }
    timer(){
        if(locURLid != "@"){updateloc();}
        else{
            llOwnerSay("Hey! \nYou rezzed a LiveMark Update Pad and you haven't set it up yet! \nI'm located at "+internalurl()+"\nClick the link to teleport");
        }
        
    }
    http_response(key request_id,integer status,list metadata,string body)
    {
        if(DEBUG){llOwnerSay(body);}
        if(request_id == requestid){
            list response = llParseString2List(body,["|"],[]);
            string cmd = llList2String(response,0);
            string atr = llList2String(response,1);
            string atr2 = llList2String(response,2);
            
            if(cmd == "updateloc"){                
                if(atr=="1"){
                    llOwnerSay("My new location has been updated!");
                    return;
                }else if(atr=="0"){return;}
            }else if(cmd == "error"){                
                llOwnerSay("Error: "+atr);
            }
        }
    }        
}

state config
{
    on_rez(integer p){
        llResetScript();
    }
    state_entry(){
        if(retries <=2){
            llOwnerSay("Say all responses on channel 5");
            llOwnerSay("Say the profile name and id like this:");
            llOwnerSay("Type /5 profile name;id");
            llOwnerSay("Note: You won't need the brackets & don't forget the semicolon! \";\"");
            llOwnerSay("If your id is abc and your name is \"Sublime Geek\", type /5 Sublime Geek;abc");
        }else{
            llOwnerSay("Are you having trouble?  If so, just say \"/5 return\" and I will return back to my normal state.  Otherwise, keep trying.");
        }
        
        
        confighandle = llListen(5,"",llGetOwner(),"");
    }
    listen(integer chan, string name, key id, string msg)
    {
        if(id == llGetOwner()){
            list settings = llParseString2List(msg,[";"],[]);
            string name = llList2String(settings,0);
            string profile = llList2String(settings,1);
            
            if((name != "")||(profile != "")){
                llSetObjectDesc(
                    llStringTrim(name,STRING_TRIM)+"::"+llStringTrim(profile,STRING_TRIM)
                    );
                llOwnerSay("Updated!");
                llListenRemove(confighandle);
                state default;                
            }else{
                llOwnerSay("Huh?  I didn't understand you, please try again");
                retries++;
                return;
            }
        }
    }
}