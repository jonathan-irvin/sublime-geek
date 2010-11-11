//metaVotr
//Paid Edition

key requestid;
string version = "2.5";
integer premium = TRUE;
integer vmultiplier;
list type = ["Cube","Pole","Prism"];

//Land UUID & Pic
key landpic;
key landid;

//ThreadMap
key tmid;
key tmimgid;
integer gridx;
integer gridy;
vector  start;
vector currentGlobalPos;
string threadmap_getinfo    = "getSimpleRegionViewInfo";
string threadmap_getlink    = "getSimpleRegionView";
string threadmap_base_url   = "http://www.threadmap.com/api1p0/";
string threadmap_api        = "qdkPKRGGp40eewVihK5Fc0bIa9LRWAXYHf0KwqzF";


string hash;
string paidhash = "17235846e853b95b792cb5b3da50ba59600a0a55";
string freehash = "e76f4f903386a2e4fdec21a045da8294140389ae";

//Tip System
integer votepushamt = 30;


vector Where;
string Name;
integer X;
integer Y;
integer Z;
list user = 
    ["Hate it!","Crappy.","I Dunno...",
     "It's Okay","Awesome!!","Support",
     "ViewScores","Get One!","Feedback",
     "Update"];

//CHANNELS
integer admchan;
integer usrchan;
integer admchanhandle;
integer usrchanhandle;

//CREATOR SETTINGS
key gCreator = "6aab7af0-8ce8-4361-860b-7139054ed44f";
key gBank    = "633ccfe5-9eae-4e3a-8abb-48773dee0edf";
integer allow_drop = FALSE;

dmca(){
    if ((llGetCreator() != gCreator)&&(allow_drop)) {
        llOwnerSay("I'm sorry, this script is locked from being put in your own objects.");
        llOwnerSay("If you need help, please visit (http://support.sublimegeek.com)");
        llLoadURL(llGetOwner(),"Sublime Geek Support\nNeed some help?" +
        "\nClick to visit our support page","http://support.sublimegeek.com");
        llDie();
    }
}
string slurl(){
    Name    = llGetRegionName();
    Where   = llGetPos();
    X       = (integer)Where.x;
    Y       = (integer)Where.y;
    Z       = (integer)Where.z;
    string _SLURL0 = "secondlife://" + Name + "/" + (string)X + "/" + (string)Y + "/" + (string)Z + "/";
    return _SLURL0;
}
sendvote(key voter,string votername,integer rating,integer push){
    list    lstParcelDetails    = llGetParcelDetails(llGetPos(),[0,1,2,3,4,5]);
    string  ParcelName          = llList2String (lstParcelDetails,0);
    string  ParcelDesc          = llList2String (lstParcelDetails,1);
    key     ParcelOwner         = llList2Key    (lstParcelDetails,2);
    key     ParcelGroup         = llList2Key    (lstParcelDetails,3);
    integer ParcelArea          = llList2Integer(lstParcelDetails,4);
    key     ParcelUUID          = llList2Key    (lstParcelDetails,5);
    
    landid    =  llHTTPRequest("http://world.secondlife.com/place/"+(string)ParcelUUID,[],"");
    
    string baseURL = "http://www.sublimegeek.com/sg_admin/metavotr/";
    string target;
    
    if(premium){
        vmultiplier = 2;
        rating = rating * vmultiplier;
        hash = paidhash;
        target = "PAID";
    }else{
        vmultiplier = 1;
        rating = rating * vmultiplier;
        hash = freehash;
        target = "FREE";
    }    
    
    requestid = llHTTPRequest(baseURL+target,[0,"POST",1,"application/x-www-form-urlencoded"],
    "simname="          + llEscapeURL(llGetRegionName()) + 
    "&locname="         + llEscapeURL(ParcelName) + 
    "&voter_key="       + llEscapeURL(voter) + 
    "&voter_name="      + llEscapeURL(votername) + 
    "&rating="          + llEscapeURL((string)rating) + 
    "&slurl="           + llEscapeURL(slurl())+
    "&authhash="        + llEscapeURL((string)hash) +
    "&version="         + llEscapeURL((string)((float)version))+
    "&land_uuid="       + llEscapeURL((string)ParcelUUID)+
    "&land_pic_uuid="   + llEscapeURL((string)landpic)+
    "&land_area="       + llEscapeURL((string)ParcelArea)+
    "&push_vote="       + llEscapeURL((string)push)+
    "&grid_x="          + llEscapeURL((string)gridx)+
    "&grid_y="          + llEscapeURL((string)gridy));    
}
setname(){
    list        lstPDetails = llGetParcelDetails(llGetPos(),[0,1,2,3,4]);
    string      PName = llList2String(lstPDetails,0);
    
    list        primspecs = llGetPrimitiveParams([PRIM_TYPE]);
    integer     primtype  = llList2Integer(primspecs,0);
    string      primtypename = llList2String(type,primtype);
    string      versionletter;
    
    if(allow_drop){primtypename = "";}
    if(premium)   {versionletter = "p";}else{versionletter = "";}
    
    
    llSetObjectName("[sig] metaVotr v" + version + versionletter + " " + primtypename);
    llSetText("[sig] metaVotr v" + version + versionletter + "\nTouch Me to Vote\nFor " + PName + "!\n \n \n \n ",<1.0,1.0,1.0>,1);
}
wave(){
    if(!allow_drop){
        llSetLinkPrimitiveParams(6, 
            [PRIM_FULLBRIGHT, ALL_SIDES,  TRUE, PRIM_GLOW, ALL_SIDES, 0.15,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 1.0]);
        llSetLinkPrimitiveParams(5, 
            [PRIM_FULLBRIGHT, ALL_SIDES,  TRUE, PRIM_GLOW, ALL_SIDES, 0.15,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 1.0]);        
        llSetLinkPrimitiveParams(4, 
            [PRIM_FULLBRIGHT, ALL_SIDES,  TRUE, PRIM_GLOW, ALL_SIDES, 0.30,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 1.0]);        
        llSetLinkPrimitiveParams(3, 
            [PRIM_FULLBRIGHT, ALL_SIDES,  TRUE, PRIM_GLOW, ALL_SIDES, 0.15,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 1.0]);        
        llSetLinkPrimitiveParams(2, 
            [PRIM_FULLBRIGHT, ALL_SIDES,  TRUE, PRIM_GLOW, ALL_SIDES, 0.30,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 1.0]);        
        llSetLinkPrimitiveParams(6, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.00,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 0.5]);
        llSetLinkPrimitiveParams(5, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.00,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 0.5]);
        llSetLinkPrimitiveParams(4, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.00,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 0.5]);
        llSetLinkPrimitiveParams(3, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.00,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 0.5]);
        llSetLinkPrimitiveParams(2, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.00,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 0.5]);
    }
}
getperms(integer perms){
    if (perms && PERMISSION_DEBIT){
        llOwnerSay((string)((integer)(64-(llGetFreeMemory()*.001)))+"KiB in use...");
        llOwnerSay("Ready.");
    }else{llOwnerSay("Please select YES to continue.  This is for the vote push feature.");}
}
check_threadmap(){
    currentGlobalPos = llGetRegionCorner() + llGetPos();
    
    gridx = (integer)currentGlobalPos.x;
    gridy = (integer)currentGlobalPos.y;
    
    string url = threadmap_base_url + threadmap_getinfo + "?" + "x=" + (string)gridx + "&y=" + (string)gridy + "&key=" + threadmap_api;
    //llOwnerSay(url);
    tmid = llHTTPRequest(url,[0,"POST",1,"application/x-www-form-urlencoded"],"");
}


default {

    on_rez(integer param) {
        setname();
        llSetObjectDesc("Click me to vote for this location! Check us out at http://popular.sublimegeek.com");
        llResetScript();
    }

    state_entry() {
        llSetObjectDesc("Click me to vote for this location! Check us out at http://popular.sublimegeek.com");
        check_threadmap();
        setname();
        dmca();        
        wave();
        //Set Default Pay Amounts
        llSetPayPrice(PAY_HIDE, [votepushamt,PAY_HIDE,PAY_HIDE,PAY_HIDE]);
        llListen(-581391,"","","");
        llRequestPermissions(llGetOwner(), PERMISSION_DEBIT );        
    }
    
    run_time_permissions(integer perms){
        getperms(perms);        
    }
    
    moving_start() {
        start = llGetPos();
        llSleep(5.0); // this prevents the end event from getting triggered earlier than we want
    }
        
    moving_end() {
        llSay(0, "You moved me " + (string)llVecDist(start, llGetPos()) + " meters.  Updating location info.");
        check_threadmap();
    }

    touch_start(integer total_number) {
        setname();
        //GENERATE RANDOM CHANNELS FOR COMMS
        admchan = ((integer) llFrand(3) - 1) * ((integer) llFrand(2147483646));
        
        //FALL BACK TO SECURE CHANNELS IF EITHER IS BAD
        if(admchan == 0){admchan = -5287954 + (integer)llFrand(100);}
        
        //LISTEN HANDLER
        admchanhandle = llListen(admchan,"",llDetectedKey(0),"");
        
        llDialog(llDetectedKey(0),"---> What do you think of my place? <---\n \nViewScores - How we rank!\nGet One! - Grab a copy!\nFeedback - Sublime Geek wants your feedback!\nSupport - Sublime Geek Support",user,admchan);
    }

    
    listen(integer channel,string name,key id,string msg) {
        if ((msg == "Hate it!")) {
            sendvote(id,llKey2Name(id),1,FALSE);
            llListenRemove(admchanhandle);
        }
        if ((msg == "Crappy.")) {
            sendvote(id,llKey2Name(id),2,FALSE);
            llListenRemove(admchanhandle);
        }
        if ((msg == "I Dunno...")) {
            sendvote(id,llKey2Name(id),3,FALSE);
            llListenRemove(admchanhandle);
        }
        if ((msg == "It's Okay")) {
            sendvote(id,llKey2Name(id),4,FALSE);
            llListenRemove(admchanhandle);
        }
        if ((msg == "Awesome!!")) {
            sendvote(id,llKey2Name(id),5,FALSE);
            llListenRemove(admchanhandle);
        }
        if ((msg == "Get One!")) {
            llSay(0,"Check out our other stuff!");
            llGiveInventory(id,llGetInventoryName(6,0));
            llListenRemove(admchanhandle);
        }
        if ((msg == "Feedback")) {
            llLoadURL(id,"We want your feedback!!!","http://getsatisfaction.com/sublime_geek");
            llListenRemove(admchanhandle);
        }
        if ((msg == "ViewScores")) {
            llLoadURL(id,"Check out other popular locations!","http://popular.sublimegeek.com");
            llListenRemove(admchanhandle);
        }
        if ((msg == "Update")) {
            if(llGetOwner() == id){               
                llListenRemove(admchanhandle);
                llRegionSay(-581391,"metavotrmarco");
            }else{
                llSay(0,"I'm sorry, this feature is only available to my owner.");
            }
        }
        if((channel == -581391)&&(msg == "metavotrmarco")){
            llInstantMessage(llGetOwner(),"Hi! I'm located at "+slurl()+" and my version is "+version+".");
        }
    }
    
    money(key id, integer amount){
        if(amount < votepushamt){
            llGiveMoney(id,amount);
            llInstantMessage(id, "I'm sorry, I'm unable to push your vote through.  You payed less than the push vote fee which is L$"+(string)votepushamt);
        }else if(amount == votepushamt){
            llGiveMoney(gCreator,       (integer)(amount / 2));
            llGiveMoney(llGetOwner(),   (integer)(amount / 2));
            sendvote(id,llKey2Name(id),5,TRUE);
        }
    }
    
    http_response(key request_id,integer status,list metadata,string body) {        
        if ((request_id == requestid)) {
            list commands = llParseString2List(body,["|"],[]);
            string cmd = llList2String(commands,0);
            string obj = llList2String(commands,1);
            string act = llList2String(commands,2);
            
            if(cmd == "vote"){
                llSay(0,obj);
            }else if(cmd == "exp"){
                llSay(0,obj);
                llInstantMessage(llGetOwner(),"Hey! You have a metaVotr Unit that is out-of-date! Please visit "+slurl()+" to update it!\n"+
                "Follow us on twitter @SublimeGeek or visit our blog at http://sublimegeek.com/blog for more details.\n"+
                "If you need help, visit http://sublimegeek.com/support for assistance.");
            }else if(cmd == "noauth"){
                llSay(0,obj);
                llInstantMessage(llGetOwner(),"Hey! You have a metaVotr Unit that is no longer authenticated! Please visit "+slurl()+" to update it!\n"+
                "Follow us on twitter @SublimeGeek or visit our blog at http://sublimegeek.com/blog for more details.\n"+
                "If you need help, visit http://sublimegeek.com/support for assistance.");
            }else if(cmd == "err"){
                llSay(0,"Error: Communication has failed.  Your vote has not been logged.  The creator has been contacted.\n"+
                "Follow us on twitter @SublimeGeek or visit our blog at http://sublimegeek.com/blog for more details.\n"+
                "If you need help, visit http://sublimegeek.com/support for assistance.");
                llInstantMessage(gCreator,"MetaVotr Comm Error\nLocated at @"+llGetRegionName()+"\nHTTP Status: "+(string)status+"\nslURL: "+slurl()+"\nBody:\n"+body);
            }            
            else{
                llSay(0,"Error: Communication has failed.  Your vote has not been logged.  The creator has been contacted\n"+
                "Follow us on twitter @SublimeGeek or visit our blog at http://sublimegeek.com/blog for more details.\n"+
                "If you need help, visit http://sublimegeek.com/support for assistance.");
                llInstantMessage(gCreator,"MetaVotr Comm Error\nLocated at @"+llGetRegionName()+"\nHTTP Status: "+(string)status+"\nslURL: "+slurl()+"\nBody:\n"+body);
            }
            wave();
        }
        if(request_id == landid){
             if (llSubStringIndex(body, "blank.jpg") == -1){
                    // Find starting point of the land picture UUID
                    integer start_of_UUID = 
                        llSubStringIndex(body,"<meta name=\"imageid\" content=\"") 
                            + llStringLength("<meta name=\"imageid\" content=\"");
                    // Find ending point of land picture UUID
                    integer end_of_UUID = llSubStringIndex(body,"/");
                    // Parse out land UUID from the body
                    string profile_pic = llGetSubString(body, start_of_UUID, end_of_UUID);
                    // Set the sides of the prim to the picture
         
                    //Parse some more, we need to dig deeper to get the key.
                    integer start = 
                        llSubStringIndex(profile_pic,"<!DOCTYPE html PUBLIC \"-/") 
                            + llStringLength("<!DOCTYPE html PUBLIC \"-/");
                    integer end = llSubStringIndex(profile_pic,"\" />");            
                    landpic = (key)llGetSubString(profile_pic, start,end - 1);
            }
        }
        if(request_id == tmid){
            if(body == "0"){
                llOwnerSay("ThreadMap not detected.  Defaulting to Location image.");
            }else if(body == "1"){
                llOwnerSay("ThreadMap detected.");
            }
        }
    }
}
