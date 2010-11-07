//metaVotr
//Paid Edition

key requestid;
string version = "2.1p";
list type = ["Cube","Pole","Prism"];
string landpic;

string hash = "17235846e853b95b792cb5b3da50ba59600a0a55";

vector Where;
string Name;
integer X;
integer Y;
integer Z;
list user = 
    ["Hate it!","Crappy.","I Dunno...",
    "It's Okay","Awesome!!","Support",
    "ViewScores","Get One!","Feedback"];

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
sendvote(key voter,string votername,integer rating){
    list    lstParcelDetails = llGetParcelDetails(llGetPos(),[0,1,2,3,4,5]);
    string  ParcelName = llList2String(lstParcelDetails,0);
    string  ParcelDesc = llList2String(lstParcelDetails,1);
    key     ParcelOwner = llList2Key(lstParcelDetails,2);
    key     ParcelGroup = llList2Key(lstParcelDetails,3);
    integer ParcelArea = llList2Integer(lstParcelDetails,4);
    key     ParcelUUID = llList2Integer(lstParcelDetails,5);
    
    landid    =  llHTTPRequest("http://world.secondlife.com/place/"+(string)ParcelUUID,[],"");
    
    requestid = llHTTPRequest("http://www.sublimegeek.com/sg_admin/metavotr/PAID",[0,"POST",1,"application/x-www-form-urlencoded"],
    "simname="          + llEscapeURL(llGetRegionName()) + 
    "&locname="         + llEscapeURL(ParcelName) + 
    "&voter_key="       + llEscapeURL(voter) + 
    "&voter_name="      + llEscapeURL(votername) + 
    "&rating="          + llEscapeURL((string)rating) + 
    "&slurl="           + llEscapeURL(slurl())+
    "&authhash="        + llEscapeURL((string)hash) +
    "&version="         + llEscapeURL((string)((float)version))    );
}
setname(){
    list        lstPDetails = llGetParcelDetails(llGetPos(),[0,1,2,3,4]);
    string      PName = llList2String(lstPDetails,0);
    
    list        primspecs = llGetPrimitiveParams([PRIM_TYPE]);
    integer     primtype  = llList2Integer(primspecs,0);
    string      primtypename = llList2String(type,primtype);
    
    if(allow_drop){primtypename = "";}
    
    llSetObjectName("[sig] metaVotr v" + version + " " + primtypename);
    llSetText("[sig] metaVotr v" + version + "\nTouch Me to Vote\nFor " + PName + "!\n \n \n \n ",<1.0,1.0,1.0>,1);
}
wave(){
    if(!allow_drop){
        llSetLinkPrimitiveParams(6, 
            [PRIM_FULLBRIGHT, ALL_SIDES, TRUE, PRIM_GLOW, ALL_SIDES, 0.15,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 1.0]);
        llSetLinkPrimitiveParams(5, 
            [PRIM_FULLBRIGHT, ALL_SIDES, TRUE, PRIM_GLOW, ALL_SIDES, 0.15,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 1.0]);        
        llSetLinkPrimitiveParams(4, 
            [PRIM_FULLBRIGHT, ALL_SIDES, TRUE, PRIM_GLOW, ALL_SIDES, 0.3,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 1.0]);        
        llSetLinkPrimitiveParams(3, 
            [PRIM_FULLBRIGHT, ALL_SIDES, TRUE, PRIM_GLOW, ALL_SIDES, 0.15,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 1.0]);        
        llSetLinkPrimitiveParams(2, 
            [PRIM_FULLBRIGHT, ALL_SIDES, TRUE, PRIM_GLOW, ALL_SIDES, 0.3,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 1.0]);        
        llSetLinkPrimitiveParams(6, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.0,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 0.5]);
        llSetLinkPrimitiveParams(5, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.0,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 0.5]);
        llSetLinkPrimitiveParams(4, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.0,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 0.5]);
        llSetLinkPrimitiveParams(3, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.0,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 0.5]);
        llSetLinkPrimitiveParams(2, 
            [PRIM_FULLBRIGHT, ALL_SIDES, FALSE, PRIM_GLOW, ALL_SIDES, 0.0,PRIM_COLOR, ALL_SIDES, <0,.6,.75>, 0.5]);
    }
}


default {

    on_rez(integer param) {
        setname();
        llSetObjectDesc("Click me to vote for this location! Check us out at http://popular.sublimegeek.com");
        llResetScript();
    }

    state_entry() {
        llSetObjectDesc("Click me to vote for this location! Check us out at http://popular.sublimegeek.com");
        setname();
        dmca();        
        wave();
        llOwnerSay("Ready.");
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
            sendvote(id,llKey2Name(id),2);
            llListenRemove(admchanhandle);
        }
        if ((msg == "Crappy.")) {
            sendvote(id,llKey2Name(id),4);
            llListenRemove(admchanhandle);
        }
        if ((msg == "I Dunno...")) {
            sendvote(id,llKey2Name(id),6);
            llListenRemove(admchanhandle);
        }
        if ((msg == "It's Okay")) {
            sendvote(id,llKey2Name(id),8);
            llListenRemove(admchanhandle);
        }
        if ((msg == "Awesome!!")) {
            sendvote(id,llKey2Name(id),10);
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
                llInstantMessage(llGetOwner(),"Hey! You have a metaVotr Premium Unit that is out-of-date! Please visit "+slurl()+" to update it!");
            }else if(cmd == "noauth"){
                llSay(0,obj);
                llInstantMessage(llGetOwner(),"Hey! You have a metaVotr Premium Unit that is no longer authenticated! Please visit "+slurl()+" to update it!");
            }else if(cmd == "err"){
                llSay(0,"Error: Communication has failed.  Your vote has not been logged.  The creator has been contacted");
                llInstantMessage(gCreator,"MetaVotr Comm Error\nLocated at @"+llGetRegionName()+"\nHTTP Status: "+(string)status+"\nslURL: "+slurl()+"\nBody:\n"+body);
            }            
            else{
                llSay(0,"Error: Communication has failed.  Your vote has not been logged.  The creator has been contacted");
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
                    landpic = llGetSubString(profile_pic, start,end - 1);
            }
        }
    }
}
