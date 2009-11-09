//Activation Script

//System Data
key requestid;
key revolution = "633ccfe5-9eae-4e3a-8abb-48773dee0edf";
list commands;
integer timestat = 1;

//HTTP REQUEST DATA
string baseurl = "http://www.metastreamr.net/backend/";
string mimetype = "application/x-www-form-urlencoded";
string delete = "delclient.php";
string slots = "client.php";
string register = "regclient.php";
integer verifycert = TRUE;

//SLURL Data
string slurl;
string simname;
string size;
vector Where;
integer X;
integer Y;
integer Z;

//Machine Data
key object;
key owner;
string mfgid = "1";
string parcelname;
integer jackpotamount = 0;

//Company Info
string gCompanyName = "[metaStreamr]";
//Version Label
string version = "1.2";

//Player Data
key player;
integer bet;
string symbolnum;

//Dialog Options
list owneroptions = ["DELETE","Cancel"];
list useroptions = ["Cancel"];
integer dchannel;

set_msg(string sysmsg)
{
    llSetText(sysmsg,<1,0,0>,1);
}

default
{
    state_entry()
    {        
        llResetOtherScript(".cb_v"+version);
        llResetOtherScript(".cm_v"+version);
        owner = llGetOwner();        
    }
    
    on_rez(integer i){ llResetScript(); }    
    
    link_message(integer sender_num, integer num, string str, key id)
    {
        commands = llCSV2List(str);
        llOwnerSay(str);
        
        if(llList2String(commands,0) == "registered")
        {                       
            state running;              
        }
    }    
}

state running
{
    state_entry()
    {        
        llOwnerSay("[metaStreamr] Client is Fully Operational");            
        llSetTimerEvent(5);
        llMessageLinked(LINK_THIS,0,"ready",NULL_KEY);
        requestid = llHTTPRequest(baseurl + slots, 
                    [HTTP_METHOD, "POST",
                    HTTP_MIMETYPE, mimetype],
                    "objectkey=" + ((string)llGetKey()) + "&ownerkey=" + ((string)owner));        
    }
    on_rez(integer i){ llResetScript(); }    
    link_message(integer sender_num, integer num, string str, key id)
    {
        commands = llCSV2List(str);       
    }
    timer()
    {
        requestid = llHTTPRequest(baseurl + slots, 
                    [HTTP_METHOD, "POST",
                    HTTP_MIMETYPE, mimetype],
                    "objectkey=" + ((string)llGetKey()) + "&ownerkey=" + ((string)owner));
    }    
    http_response(key request_id, integer status, list metadata, string body)
    {
        //llOwnerSay(body);
        if(requestid == request_id)
        {
            commands = llCSV2List(body);            
            //llOwnerSay(body);
            
            if(llList2String(commands,0) == "deleted")
            {
                llDie();
            }         
            else if(llList2String(commands,0) == "not activated")
            {                
                llMessageLinked(LINK_THIS,0,"not activated",NULL_KEY);
                set_msg(llGetObjectName()+"\nNot Activated\n \n \n \n \n ");                
            }
            else if(llList2String(commands,0) == "activated")
            {                
                llMessageLinked(LINK_THIS,0,"activated",NULL_KEY);                
            }
            else if(llList2String(commands,0) == "not registered")
            {                
                llInstantMessage(owner, "Your [metaStreamr] Client at " + slurl + "Is stated to be unregistered. Re-registering now.");
                llMessageLinked(LINK_THIS,0,"registerme",NULL_KEY);              
            }
            else if(llList2String(commands,0) == "noserver")
            {                
                llInstantMessage(llList2Key(commands,1),llList2String(commands,2));
                return;
            }            
        }
    }    
}
