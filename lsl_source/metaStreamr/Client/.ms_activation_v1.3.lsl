// LSL script generated: Client..ms_activation_v1.3.lslp Fri Oct 30 19:21:31 Central Daylight Time 2009
//Activation Script

//System Data
key requestid;
list commands;

//HTTP REQUEST DATA
string baseurl = "http://www.metastreamr.net/backend/";
string mimetype = "application/x-www-form-urlencoded";
string slots = "client.php";

//SLURL Data
string slurl;
key owner;
//Version Label
string version = "1.2";

set_msg(string sysmsg){
    llSetText(sysmsg,<1.0,0.0,0.0>,1);
}

default {

    state_entry() {
        llResetOtherScript((".cb_v" + version));
        llResetOtherScript((".cm_v" + version));
        (owner = llGetOwner());
    }

    
    on_rez(integer i) {
        llResetScript();
    }

    
    link_message(integer sender_num,integer num,string str,key id) {
        (commands = llCSV2List(str));
        llOwnerSay(str);
        if ((llList2String(commands,0) == "registered")) {
            state running;
        }
    }
}

state running {

    state_entry() {
        llOwnerSay("[metaStreamr] Client is Fully Operational");
        llSetTimerEvent(5);
        llMessageLinked(-4,0,"ready",NULL_KEY);
        (requestid = llHTTPRequest((baseurl + slots),[0,"POST",1,mimetype],((("objectkey=" + ((string)llGetKey())) + "&ownerkey=") + ((string)owner))));
    }

    on_rez(integer i) {
        llResetScript();
    }

    link_message(integer sender_num,integer num,string str,key id) {
        (commands = llCSV2List(str));
    }

    timer() {
        (requestid = llHTTPRequest((baseurl + slots),[0,"POST",1,mimetype],((("objectkey=" + ((string)llGetKey())) + "&ownerkey=") + ((string)owner))));
    }

    http_response(key request_id,integer status,list metadata,string body) {
        if ((requestid == request_id)) {
            (commands = llCSV2List(body));
            if ((llList2String(commands,0) == "deleted")) {
                llDie();
            }
            else  if ((llList2String(commands,0) == "not activated")) {
                llMessageLinked(-4,0,"not activated",NULL_KEY);
                set_msg((llGetObjectName() + "\nNot Activated\n \n \n \n \n "));
            }
            else  if ((llList2String(commands,0) == "activated")) {
                llMessageLinked(-4,0,"activated",NULL_KEY);
            }
            else  if ((llList2String(commands,0) == "not registered")) {
                llInstantMessage(owner,(("Your [metaStreamr] Client at " + slurl) + "Is stated to be unregistered. Re-registering now."));
                llMessageLinked(-4,0,"registerme",NULL_KEY);
            }
            else  if ((llList2String(commands,0) == "noserver")) {
                llInstantMessage(llList2Key(commands,1),llList2String(commands,2));
                return;
            }
        }
    }
}
