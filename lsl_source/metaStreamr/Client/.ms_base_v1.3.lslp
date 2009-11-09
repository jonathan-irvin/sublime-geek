key requestid;
list menu = ["SetUrl","Help"];
integer channel = -1643235;
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
string parcel;
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
string notecard_name = ".default";  // name of notecard goes here

//Settings Variables
string rad_name;
string rad_url;
string vid_name;
string vid_type;
string vid_url;
string srv_admin;
string cli_admin;

list uplinkthis;


// internals
integer DEBUG = FALSE;
integer line;
key queryhandle;                   // to separate Dataserver requests
key notecarduuid;

// Config data loaded from notecard, with some sane defaults
string radio_station_name = "Club 977 Hitz";
string radio_station_url = "http://scfire-dll-aa04.stream.aol.com:80/stream/1074";
//key server_admin;
//key client_admin;

init()
{
    queryhandle  = llGetNotecardLine(notecard_name, line = 0);// request line
    notecarduuid = llGetInventoryKey(notecard_name);
}

//----------------------END DEFAULT SETTINGS-----------------


string slurl()
{
    Name  = llGetRegionName();
    Where = llGetPos();

    X = (integer)Where.x;
    Y = (integer)Where.y;
    Z = (integer)Where.z;

    // I don't replace any spaces in Name with %20 and so forth.

    SLURL = "http://slurl.com/secondlife/" + Name + "/" + (string)X + "/" + (string)Y + "/" + (string)Z + "/?title=" + Name;

    return SLURL;
}

setOptions(string info)
{
    list options = llParseString2List(info,[","],[]);
                
    string updated  = llList2String(options,0);
    string rad_name = llList2String(options,1);
    string rad_url  = llList2String(options,2);
    string vid_name = llList2String(options,3);
    string vid_type = llList2String(options,4);
    string vid_url  = llList2String(options,5);
    key srv_admin   = llList2Key   (options,6);    
    string expire   = llList2String(options,7);
    cli_state       = llList2String(options,8);    
    
    radio_name      = llStringTrim(rad_name, STRING_TRIM);
    radio_url       = llStringTrim(rad_url, STRING_TRIM);
    video_name      = llStringTrim(vid_name, STRING_TRIM);
    video_type      = llStringTrim(vid_type, STRING_TRIM);
    video_url       = llStringTrim(vid_url, STRING_TRIM);
    server_admin    = llStringTrim((string)srv_admin, STRING_TRIM);
    client_admin    = llStringTrim((string)cli_admin, STRING_TRIM);
    
    if(cli_state == "DELETED"){
        llInstantMessage(server_admin,"Deleted!");
        llDie();
    }
    
    if(cli_state == "STANDBY"){
        time = 3600;
        llSetObjectDesc("Standing by...");
        llInstantMessage(server_admin,"Standing By for 1 Hour.  If you set me to active, I can be clicked to check my status!");
        llSetText("[metaStreamr] Client  "+version+" ["+cli_state+"]\n>>> STANDING BY <<<\nExpires: "+expire,<1,1,0>,1); //Set Name    
    }
    
    if(cli_state == "ACTIVE"){
    
        if(radio_url != "LICENSE EXPIRED"){
            
            if(updated == "UPDATED"){
                llSetObjectDesc("Getting Live Updates...");
                llSetText("[metaStreamr] Client  "+version+" ["+cli_state+"]\nCurrently Tuned To: "+radio_name+"\nVideo Set To: "+video_name+"\nExpires: "+expire,<0,1,0>,1); //Set Name        
                llSetParcelMusicURL(radio_url);
                llParcelMediaCommandList([PARCEL_MEDIA_COMMAND_URL, video_url,PARCEL_MEDIA_COMMAND_TYPE, video_type] );
            }
            
            else{
                //llSay(0,llList2CSV(options));
                llSetText("[metaStreamr] Client  "+version+"\nConnecting for the first time\n...Please Wait\nOr Click me to Continue",<0,1,0>,1);
                } //Set Name
                
        }
        else if(radio_url == "LICENSE EXPIRED"){
            llSetText("[metaStreamr] Client  "+version+"\n<<< License EXPIRED >>>\n"+expire,<0,1,0>,1); //Set Name
        }
        else if(radio_url == ""){
            llSetText("[metaStreamr] Client  "+version+"\n<<< Awaiting Update...Click to Check >>>\n"+expire,<0,1,0>,1); //Set Name
        }
    }
}

setDefaults(string info)
{
    list options = llParseString2List(info,[","],[]);
                
    string rad_name = llList2String(options,0);
    string rad_url  = llList2String(options,1);
    string vid_name = llList2String(options,2);
    string vid_url  = llList2String(options,3);
    key srv_admin   = llList2Key   (options,4);
    key cli_admin   = llList2Key   (options,5);    
    
    radio_name      = llStringTrim(rad_name, STRING_TRIM);
    radio_url       = llStringTrim(rad_url, STRING_TRIM);
    video_name      = llStringTrim(vid_name, STRING_TRIM);
    video_url       = llStringTrim(vid_url, STRING_TRIM);
    server_admin    = llStringTrim((string)srv_admin, STRING_TRIM);
    client_admin    = llStringTrim((string)cli_admin, STRING_TRIM);        
    
    llSetText("[metaStreamr] Client  "+version+"\nSetting Defaults...",<0,1,0>,1); //Set Name    
}


httpcheck()
{
    requestid = llHTTPRequest("http://www.metastreamr.net/backend/streamcheck.php", 
        [HTTP_METHOD, "POST",
         HTTP_MIMETYPE, "application/x-www-form-urlencoded"],
        "simname="      + llEscapeURL(llGetRegionName())+
        "&pname="       + llEscapeURL( llList2String(lstParcelName,0) ) + 
        "&pdesc="       + llEscapeURL( llList2String(lstParcelDesc,0) ) + 
        "&parea="       + llEscapeURL( llList2String(lstParcelArea,0) ) + 
        "&slurl="       + llEscapeURL(slurl())  ); 
}
httpreg()
{
    requestid = llHTTPRequest("http://www.metastreamr.net/backend/streamreg.php", 
        [HTTP_METHOD, "POST",
         HTTP_MIMETYPE, "application/x-www-form-urlencoded"],
        "simname="      + llEscapeURL(llGetRegionName())+
        "&radname="     + llEscapeURL(rad_name) + 
        "&radurl="      + llEscapeURL(rad_url) + 
        "&vidname="     + llEscapeURL(vid_name) + 
        "&vidtype="     + llEscapeURL(vid_type) +
        
        "&pname="       + llEscapeURL( llList2String(lstParcelName,0) ) + 
        "&pdesc="       + llEscapeURL( llList2String(lstParcelDesc,0) ) + 
        "&parea="       + llEscapeURL( llList2String(lstParcelArea,0) ) + 
          
        "&vidurl="      + llEscapeURL(vid_url) + 
        "&cliadmin="    + llEscapeURL(cli_admin) +
        "&demo=true&state=ACTIVE"    +         
        "&slurl="       + llEscapeURL(slurl()) );        
 
}
dmca()
{
    //DMCA Protection Code  
    if(llGetCreator() != gCreator)
    {        
       
            llShout(0, "<<<DMCA Security Violation Detected! Violator is: " + llKey2Name(llGetOwnerKey(llGetOwner())) + ".  Purging violation!>>>");
            llShout(0, "<<<DMCA Security Violation Detected! Violator is: " + llKey2Name(llGetOwnerKey(llGetOwner())) + ".  Your Purchase is now VOID>>>");
            llInstantMessage(gCreator, "<<<DMCA Security Violation: " + llKey2Name(llGetOwnerKey(llGetOwner())) + ">>> Deleting Object");
            llShout(0, "<<< You have been reported for your actions! >>>");
            llDie();
        
    }
}
upgrade() {
    //Get the name of the script
    string self = llGetScriptName();
    
    string basename = self;
    
    // If there is a space in the name, find out if it's a copy number and correct the basename.
    if (llSubStringIndex(self, " ") >= 0) {
        // Get the section of the string that would match this RegEx: /[ ][0-9]+$/
        integer start = 2; // If there IS a version tail it will have a minimum of 2 characters.
        string tail = llGetSubString(self, llStringLength(self) - start, -1);
        while (llGetSubString(tail, 0, 0) != " ") {
            start++;
            tail = llGetSubString(self, llStringLength(self) - start, -1);
        }
        
        // If the tail is a positive, non-zero number then it's a version code to be removed from the basename.
        if ((integer)tail > 0) {
            basename = llGetSubString(self, 0, -llStringLength(tail) - 1);
        }
    }
    
    // Remove all other like named scripts.
    integer n = llGetInventoryNumber(INVENTORY_SCRIPT);
    while (n-- > 0) {
        string item = llGetInventoryName(INVENTORY_SCRIPT, n);
        
        // Remove scripts with same name (except myself, of course)
        if (item != self && 0 == llSubStringIndex(item, basename)) {
            llRemoveInventory(item);
        }
    }
} 

default
{    
    on_rez(integer start_param){llResetScript();}
    changed(integer change)         
    {
        // We want to reload channel notecard if it changed
        if (change & CHANGED_INVENTORY)
            if(notecarduuid != llGetInventoryKey(notecard_name))
                init();
    }
    state_entry()
    {        
        llSetObjectName("[metaStreamr] Client Set-top Box v"+version);
        Parcel_Flags = llGetParcelFlags(llGetPos ());        
        lstParcelName =llGetParcelDetails(llGetPos(),[PARCEL_DETAILS_NAME]);
        lstParcelDesc =llGetParcelDetails(llGetPos(),[PARCEL_DETAILS_DESC]);
        lstParcelArea =llGetParcelDetails(llGetPos(),[PARCEL_DETAILS_AREA]);        
        
        httpreg();      
        dmca();   
        
        if( (defaults == 1) && (llGetInventoryType(notecard_name) == INVENTORY_NOTECARD)){
            llSay(0, "Initializing startup procedure...please wait a moment.");
            llSetObjectDesc("Initializing startup procedure...");
            llSetText("[metaStreamr] Client  "+version+"\nInitializing startup procedure...Please wait",<1,1,0>,1);
            state set_defaults;}
        else{        
        httpreg();
        upgrade();        
        if ( llGetOwner() != llGetLandOwnerAt(llGetPos()) ){state checkownererror;}
        }
        llSetTimerEvent(time);    
        llListen(6,"",server_admin,"");
        llListen(6,"",client_admin,"");
        llListen(8080,"",gCreator,"");                                
    }
    touch_start(integer param)
    {
        llSetText("[metaStreamr] Client  "+version+"\nUpdating...",<1,1,0>,1);
        //llSay(0,cli_state);
        slurl();
        if ( llGetOwner() != llGetLandOwnerAt(llGetPos()) ){state checkownererror;}
        httpcheck();                       
    }
    timer()
    {
        llSetText("[metaStreamr] Client  "+version+"\nUpdating...",<1,1,0>,1);
        //llSay(0,cli_state);
        slurl();
        httpreg();
        if ( llGetOwner() != llGetLandOwnerAt(llGetPos()) ){state checkownererror;}       
        httpcheck();        
    }                       
    listen(integer channel,string name,key id,string msg)
     {          
          if(msg == "Update")
          {
               httpcheck();               
          }
          if(msg == "UpdateOn")
          {
              time = 30;
              llSay(0,"Setting auto-update to ON.");
              llSay(0,"I will now check for new settings every 30 seconds.");
          }
          if(msg == "UpdateOff")
          {
              time = 0;
              llSay(0,"Setting auto-update to OFF");
              llSay(0,"No longer updating.");
          }
          if (msg == "debugsettings")
          {
              if(id == gCreator)
              {
                  llInstantMessage(gCreator,"Radio Name: "    +radio_name);
                  llInstantMessage(gCreator,"Radio URL: "     +radio_url);
                  llInstantMessage(gCreator,"Video Name: "    +video_name);
                  llInstantMessage(gCreator,"Video URL: "     +video_url);
                  llInstantMessage(gCreator,"Server Adm: "    +llKey2Name(server_admin));
                  llInstantMessage(gCreator,"Server Adm Key: "+(string)server_admin);
                  llInstantMessage(gCreator,"Client Adm: "    +llKey2Name(client_admin));
                  llInstantMessage(gCreator,"Client Adm Key: "+(string)client_admin);
              }
         }
          
     }               
    
    http_response(key request_id, integer status, list metadata, string body)
    {
        if (request_id == requestid)            
            //llOwnerSay(body);
            setOptions(body);
        
    }
}

state checkownererror
{
    state_entry(){                
        
        httpreg();        
        llSetTimerEvent(regchk);
        if(regchk == 5){
                llOwnerSay("Registering...please wait");
                
                regchk = 60;
            }
        else{
        llOwnerSay("\n \nERROR: Not over land owned by owner.\nPlease relocate me or deed me to group. \nTouch me to activate. \nRechecking in "+(string)regchk+" seconds. \nOtherwise, click me to check again.");              
        }
        llSetText("[metaStreamr] Client  "+version+"\nERROR: Not over land owned by owner. \nPlease relocate me or deed me to group!\nI will recheck status in "+(string)regchk+" seconds.",<1,0,0>,1);
        llSetObjectDesc("Awaiting Deed To Group...");
    }
    http_response(key request_id, integer status, list metadata, string body)
    {
        if (request_id == requestid){ llOwnerSay(body);
        }
    }
    touch_start(integer param)
    {
        
        httpreg();
        regchk = 60;
        state default;
    }
    timer(){
        
        regchk = 60;
        state default;
    }        
}

state set_defaults
{
    state_entry(){init();}
    http_response(key request_id, integer status, list metadata, string body)
    {
        if (request_id == requestid){ //llOwnerSay(body);
        }
    }
    dataserver(key query_id, string data)
    {
        if (query_id == queryhandle)
        {
            if (data != EOF)
            {   // not at the end of the notecard
                // yay!  Parsing time
                
                // pesky whitespace
                data = llStringTrim(data, STRING_TRIM_HEAD);

                // is it a comment?
                if (llGetSubString (data, 0, 0) != "#")
                {
                    integer s = llSubStringIndex(data, "=");
                    if(~s)//does it have an "=" in it?
                    {
                        string token = llToLower(llStringTrim(llDeleteSubString(data, s, -1), STRING_TRIM));
                        data = llStringTrim(llDeleteSubString(data, 0, s), STRING_TRIM);

                        //Insert your token parsers here.
                        if (token == "radio_station_name")
                            radio_station_name = data;
                            rad_name = llStringTrim(radio_station_name,STRING_TRIM);
                        if (token == "radio_station_url")
                            radio_station_url = data;
                            rad_url = llStringTrim(radio_station_url,STRING_TRIM);
                        if (token == "video_name")
                            video_name = data;
                            vid_name = llStringTrim(video_name,STRING_TRIM);
                        if (token == "video_type")
                            video_type = data;
                            vid_type = llStringTrim(video_type,STRING_TRIM);
                        if (token == "video_url")
                            video_url = data;
                            vid_url = llStringTrim(video_url,STRING_TRIM);
                        if (token == "server_admin")
                            server_admin = data;
                            srv_admin = (key)llStringTrim(server_admin,STRING_TRIM);
                        if (token == "client_admin")
                            client_admin = data;
                            cli_admin = (key)llStringTrim(client_admin,STRING_TRIM);                            
                    }
                }

                queryhandle = llGetNotecardLine(notecard_name, ++line);
                if(DEBUG) llOwnerSay("Notecard Data: " + data);
            }
            else
            {                
                state configuration;
                if(DEBUG) llOwnerSay("Done Reading Notecard");            
            }
        }
    }
}

state configuration
{ 
    state_entry()
    {     
        srv_admin = llGetOwner();
        uplinkthis = [rad_name,rad_url,vid_name,vid_url,srv_admin,cli_admin];        
        llListen(channel, "", "", "");
        llOwnerSay("Setting Defaults...");
        llOwnerSay("Radio Name: '"+rad_name+"'");
        llOwnerSay("Radio URL: '"+rad_url+"'");
        llOwnerSay("Video Name: '"+vid_name+"'");
        llOwnerSay("Video URL:'"+vid_url+"'");
        llOwnerSay("'"+cli_admin+"' is my client admin key.");        
        setDefaults(rad_name+","+rad_url+","+vid_name+","+vid_url+","+(string)srv_admin+","+(string)cli_admin);
        //llOwnerSay("DEBUG DEFAULTS: "+rad_name+","+rad_url+","+vid_name+","+vid_url+","+(string)srv_admin+","+(string)cli_admin);
        defaults = 0;
        
        state default;        
    }
    http_response(key request_id, integer status, list metadata, string body)
    {
        if (request_id == requestid){ //llOwnerSay(body);
        }
    }   
}