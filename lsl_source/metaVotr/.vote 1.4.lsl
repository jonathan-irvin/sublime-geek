// LSL script generated: .vote 1.4.lslp Fri Oct 30 19:21:35 Central Daylight Time 2009

key requestid;
string version = "1.4";
string type = "Pole";

vector Where;
string Name;
integer X;
integer Y;
integer Z;
list user = ["1 Bar","2 Bars","3 Bars","4 Bars"," ","5 Bars","Popular","Get One!"];

string slurl(){
    (Name = llGetRegionName());
    (Where = llGetPos());
    (X = ((integer)Where.x));
    (Y = ((integer)Where.y));
    (Z = ((integer)Where.z));
    string _SLURL0 = (((((((("secondlife://" + Name) + "/") + ((string)X)) + "/") + ((string)Y)) + "/") + ((string)Z)) + "/");
    return _SLURL0;
}
sendvote(key voter,string votername,integer rating){
    list lstParcelDetails = llGetParcelDetails(llGetPos(),[0,1,2,3,4]);
    string ParcelName = llList2String(lstParcelDetails,0);
    string ParcelDesc = llList2String(lstParcelDetails,1);
    key ParcelOwner = llList2Key(lstParcelDetails,2);
    key ParcelGroup = llList2Key(lstParcelDetails,3);
    integer ParcelArea = llList2Integer(lstParcelDetails,4);
    (requestid = llHTTPRequest("https://www.sublimegeek.com/backend/vote.php",[0,"POST",1,"application/x-www-form-urlencoded",3,1],((((((((((("simname=" + llEscapeURL(llGetRegionName())) + "&locname=") + llEscapeURL(ParcelName)) + "&voter_key=") + llEscapeURL(voter)) + "&voter_name=") + llEscapeURL(votername)) + "&rating=") + llEscapeURL(((string)rating))) + "&slurl=") + llEscapeURL(slurl()))));
}
setname(){
    list lstPDetails = llGetParcelDetails(llGetPos(),[0,1,2,3,4]);
    string PName = llList2String(lstPDetails,0);
    string PDesc = llList2String(lstPDetails,1);
    key POwner = llList2Key(lstPDetails,2);
    key PGroup = llList2Key(lstPDetails,3);
    integer PArea = llList2Integer(lstPDetails,4);
    llSetObjectName(((("[sig] metaVotr v" + version) + " ") + type));
    llSetText((((("[sig] metaVotr v" + version) + "\nTouch Me to Vote\nFor ") + PName) + "!\n \n \n \n "),<1.0,1.0,1.0>,1);
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
        llListen(-858592,"",NULL_KEY,"");
        llOwnerSay("Ready.");
    }


    touch_start(integer total_number) {
        setname();
        llDialog(llDetectedKey(0),"What do you want to do?",user,-858592);
    }

    
    listen(integer channel,string name,key id,string msg) {
        if ((msg == "1 Bar")) {
            sendvote(id,llKey2Name(id),1);
        }
        if ((msg == "2 Bars")) {
            sendvote(id,llKey2Name(id),2);
        }
        if ((msg == "3 Bars")) {
            sendvote(id,llKey2Name(id),3);
        }
        if ((msg == "4 Bars")) {
            sendvote(id,llKey2Name(id),4);
        }
        if ((msg == "5 Bars")) {
            sendvote(id,llKey2Name(id),5);
        }
        if ((msg == "Get One!")) {
            llSay(0,"You are now the proud owner of a new metaVotr!");
            llGiveInventory(id,llGetInventoryName(6,0));
        }
        if ((msg == "[sig] HQ")) {
            llSay(0,"Please accept this landmark to our main store!");
            llGiveInventory(id,"[sig] Head Quarters");
        }
        if ((msg == "Popular")) {
            llLoadURL(id,"Check out other popular locations!","http://popular.sublimegeek.com");
        }
    }

    
    http_response(key request_id,integer status,list metadata,string body) {
        if ((request_id == requestid)) llSay(0,body);
    }
}
