key ownerkey;
key detected;
key requestid;
key gCreator = "6aab7af0-8ce8-4361-860b-7139054ed44f";
string locname;
string version = "1.4";
string type = "Pole";

vector Where;
string Name;
string SLURL;
integer X;
integer Y;
integer Z;

integer chan = -858592;
list user    = ["1 Bar", "2 Bars", "3 Bars", "4 Bars", " ","5 Bars","Popular","Get One!"];

string slurl()
{
    Name  = llGetRegionName();
    Where = llGetPos();

    X = (integer)Where.x;
    Y = (integer)Where.y;
    Z = (integer)Where.z;

    string SLURL = "secondlife://" + Name + "/" + (string)X + "/" + (string)Y + "/" + (string)Z + "/";
    return SLURL;
}
sendvote(key voter,string votername,integer rating)
{
    // Grab Parcel Info
    list lstParcelDetails = llGetParcelDetails(llGetPos(), [PARCEL_DETAILS_NAME, PARCEL_DETAILS_DESC, PARCEL_DETAILS_OWNER, PARCEL_DETAILS_GROUP, PARCEL_DETAILS_AREA]);

    // Set Parcel Variables
    string ParcelName = llList2String(lstParcelDetails, 0);     // Parcel's Name (63 Characters Max)
    string ParcelDesc = llList2String(lstParcelDetails, 1);     // Parcels Description (127 Characters Max)
    key ParcelOwner = llList2Key(lstParcelDetails, 2);          // Parcel Owners Key (AV Or Group Key If Group Owned)
    key ParcelGroup = llList2Key(lstParcelDetails, 3);          // Parcel's Group Key (NULL_KEY Unless Group Set Or Owned By Group)
    integer ParcelArea = llList2Integer(lstParcelDetails, 4);   // Parcel's Size (In Meters Squared. ie: 512, 1024...)

    
    requestid = llHTTPRequest("https://www.sublimegeek.com/backend/vote.php", 
        [HTTP_METHOD, "POST",
         HTTP_MIMETYPE, "application/x-www-form-urlencoded",3,TRUE],
        "simname="         + llEscapeURL(llGetRegionName())+        
        "&locname="        + llEscapeURL(ParcelName)+
        "&voter_key="      + llEscapeURL(voter)+
        "&voter_name="     + llEscapeURL(votername)+
        "&rating="         + llEscapeURL((string)rating)+
        "&slurl="          + llEscapeURL(slurl())           
        ); 
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
setname(){
    // Grab Parcel Info
    list lstPDetails = llGetParcelDetails(llGetPos(), [PARCEL_DETAILS_NAME, PARCEL_DETAILS_DESC, PARCEL_DETAILS_OWNER, PARCEL_DETAILS_GROUP, PARCEL_DETAILS_AREA]);

    // Set Parcel Variables
    string  PName    = llList2String (lstPDetails, 0);     // Parcel's Name (63 Characters Max)
    string  PDesc    = llList2String (lstPDetails, 1);     // Parcels Description (127 Characters Max)
    key     POwner   = llList2Key    (lstPDetails, 2);          // Parcel Owners Key (AV Or Group Key If Group Owned)
    key     PGroup   = llList2Key    (lstPDetails, 3);          // Parcel's Group Key (NULL_KEY Unless Group Set Or Owned By Group)
    integer PArea    = llList2Integer(lstPDetails, 4);   // Parcel's Size (In Meters Squared. ie: 512, 1024...)
    
    
    llSetObjectName("[sig] metaVotr v"+version+" "+type);
    llSetText("[sig] metaVotr v"+version+"\nTouch Me to Vote\nFor "+PName+"!\n \n \n \n ",<1,1,1>,1);
}



default
{
    on_rez(integer param){
        setname();
        llSetObjectDesc("Click me to vote for this location! Check us out at http://popular.sublimegeek.com");
        llResetScript();}    
    state_entry()
    {
        llSetObjectDesc("Click me to vote for this location! Check us out at http://popular.sublimegeek.com");
        setname();
        llListen(chan, "", NULL_KEY, "");
        llOwnerSay("Ready.");                
    }

    touch_start(integer total_number)
    {
        setname();                
        llDialog(llDetectedKey(0), "What do you want to do?",user,chan);        
    }
    
    listen(integer channel, string name, key id, string msg) 
    {
        if(msg == "1 Bar")   {sendvote(id,llKey2Name(id),1);}
        if(msg == "2 Bars")  {sendvote(id,llKey2Name(id),2);}
        if(msg == "3 Bars")  {sendvote(id,llKey2Name(id),3);}
        if(msg == "4 Bars")  {sendvote(id,llKey2Name(id),4);}
        if(msg == "5 Bars")  {sendvote(id,llKey2Name(id),5);}
        if(msg == "Get One!"){
            llSay(0,"You are now the proud owner of a new metaVotr!");
            llGiveInventory(id,llGetInventoryName(INVENTORY_OBJECT,0));
        }
        if(msg == "[sig] HQ"){llSay(0,"Please accept this landmark to our main store!");llGiveInventory(id,"[sig] Head Quarters");}
        if(msg == "Popular") {llLoadURL(id,"Check out other popular locations!","http://popular.sublimegeek.com");}
    }        
    
    http_response(key request_id, integer status, list metadata, string body)
    {
        if (request_id == requestid)            
            llSay(0,body);
    }
}
