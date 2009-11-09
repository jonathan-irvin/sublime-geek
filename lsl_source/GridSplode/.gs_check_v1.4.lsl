// LSL script generated: .gs_check_v1.4.lslp Fri Oct 30 19:21:28 Central Daylight Time 2009
key requestid_chk;
list winners;

key kaboom = "26f06136-8ef4-ae64-55d5-3f9f02b1f84b";

default {

    on_rez(integer sp) {
        llResetScript();
    }

    state_entry() {
        llSetTimerEvent(30);
    }

    timer() {
        (requestid_chk = llHTTPRequest("https://www.sublimegeek.com/backend/gsplode_chkexpired.php",[0,"POST",1,"application/x-www-form-urlencoded",3,1],""));
    }

    http_response(key request_id,integer status,list metadata,string body) {
        if ((request_id == requestid_chk)) {
            list comms = llParseString2List(body,[";"],[]);
            string check = llList2String(comms,0);
            string splode = llList2String(comms,1);
            string msg = llList2String(comms,2);
            if ((splode == "announce")) {
                (winners = llParseString2List(msg,["::"],[]));
            }
            if ((check == "check")) {
                if ((splode == "splode")) {
                    llSay(0,msg);
                    llAdjustSoundVolume(1.0);
                    llPlaySound(kaboom,1.0);
                    llSay(0,"Stick around!  I'll be announcing the winners shortly...");
                }
                else  if ((splode == "announce")) {
                    string w1 = llList2String(winners,0);
                    string w2 = llList2String(winners,1);
                    string w3 = llList2String(winners,2);
                    llSay(0,((((("Congratulations to the following winners:\n" + w1) + "\n") + w2) + "\n") + w3));
                }
                else  if ((splode == "done")) {
                    llSay(0,msg);
                }
            }
        }
    }
}
