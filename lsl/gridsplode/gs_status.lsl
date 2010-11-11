// LSL script generated: gs_status.lslp Thu Nov 11 09:32:54 CST 2010
//start_unprocessed_text
/*/|/nfo_preprocessor_version 0
/|/program_version Emerald Viewer
/|/mono

string version = "2.3";
list tierid = [1,2,3,4];
key requestid_dsp;
integer pointer = 0;
integer pay_cfg_4;
integer pay_cfg_3;
integer pay_cfg_2;
integer pay_cfg_1;


default {

    on_rez(integer sp) {
        llResetScript();
    }

    state_entry() {
        llSetTimerEvent(5);
        requestid_dsp = llHTTPRequest("http:/|/www.sublimegeek.com/sg_admin/gridsplode/status/"+llList2String(tierid,pointer),
        [0,"POST",1,"application/x-www-form-urlencoded"],"");
    }

    
    http_response(key request_id,integer status,list metadata,string body) {
        /|/llOwnerSay("Pointer: "+(string)pointer);
        if ((request_id == requestid_dsp)) {
            /|/llOwnerSay("Status: "+body);
            llSetTimerEvent(15);
            list tiers = llParseString2List(body,[":::"],[]);
                  
            
            (pay_cfg_1 = llList2Integer(tiers,7));
            (pay_cfg_2 = llList2Integer(tiers,8));
            (pay_cfg_3 = llList2Integer(tiers,9));
            (pay_cfg_4 = llList2Integer(tiers,10));
            string sys_status = llList2String(tiers,6);            
            
            
            string tname = llList2String(tiers,0);
            string _p10 = llList2String(tiers,1);
            string _p21 = llList2String(tiers,2);
            string _p32 = llList2String(tiers,3);
            string _minpay3 = llList2String(tiers,4);
            string _needed_players4 = llList2String(tiers,5);            
            string ttexp = llList2String(tiers,11);
                        
            if ((sys_status == "")) {
                (sys_status = "OFFLINE");
            }
            if ((sys_status == "ONLINE")) {
                if ((_needed_players4 == "/|/|/SPLODE IMMINENT/|/|/")) {
                    llPlaySound("f268d850-8d5f-0912-8b40-b8641380fdce",1.0);
                    llSetText((((((((((((((((("..::[ GridSplode v" + version) + " [") + sys_status) + "] ]::..\n") + tname) + " TIER Current Prizes:\n1st Place: L$") + _p10) + "\n2nd Place: L$") + _p21) + "\n3rd Place: L$") + _p32) + "\n \nSPLODE IMMINENT!!!\nETA: ") + ttexp) + "\nYou still have a chance to WIN!!!\nJust pay me only L$") + _minpay3) + "!!!"),<0.0,1.0,0.0>,1);
                    llSay(0,(((((("[" + tname) + " Tier] WARNING!! SPLODE IMMINENT!! ETA: ") + ttexp) + " \nYou still have a chance to win! Just pay L$") + _minpay3) + " to enter!"));
                }
                else  {
                    llSetText((((((((((((((((("..::[ GridSplode v" + version) + " [") + sys_status) + "] ]::..\n") + tname) + " TIER Current Prizes:\n \n1st Place: L$") + _p10) + "\n2nd Place: L$") + _p21) + "\n3rd Place: L$") + _p32) + "\n \nPay only L$") + _minpay3) + " to enter!\nI need only ") + _needed_players4) + " more entries!"),<0.0,1.0,0.0>,1);
                }
                llSetPayPrice(-1,[pay_cfg_1,pay_cfg_2,pay_cfg_3,pay_cfg_4]);
            }
            else  {
                integer priority;
                if ((sys_status == "DEBUG")) {
                    (sys_status = "MAINTENANCE");
                    llSetTimerEvent(600);
                    llSetPayPrice(-1,[-1,-1,-1,-1]);
                    (priority = 1);
                }
                if ((sys_status == "SHUTDOWN")) {
                    (priority = 0);
                    llSetTimerEvent(600);
                    llSetPayPrice(-1,[-1,-1,-1,-1]);
                    llDie();
                }
                else  if ((sys_status == "OFFLINE")) {
                    (priority = 0);
                    llSetTimerEvent(600);
                    llSetPayPrice(-1,[-1,-1,-1,-1]);
                    llSetText((((((("..::[ GridSplode v" + version) + " [") + sys_status) + "] ]::..\nI'm sorry, we are currently \nin ") + sys_status) + " mode. We\nWill be back ONLINE shortly."),<1.0,priority,0.0>,1);
                }
            }
        }
    }

    
    timer() {
        requestid_dsp = llHTTPRequest("http:/|/www.sublimegeek.com/sg_admin/gridsplode/status/"+llList2String(tierid,pointer),
        [0,"POST",1,"application/x-www-form-urlencoded"],"");
        if ((pointer <= 2)) {
            (pointer++);
        }
        else  {
            (pointer = 0);
        }
    }

    
    money(key id,integer amt) {
        if ((amt == pay_cfg_1)) {
            (pointer = 0);
        }
        if ((amt == pay_cfg_2)) {
            (pointer = 1);
        }
        if ((amt == pay_cfg_3)) {
            (pointer = 2);
        }
        if ((amt == pay_cfg_4)) {
            (pointer = 3);
        }
        llSleep(1.0);
        llSetTimerEvent(5);
    }
}

*/
//end_unprocessed_text
//nfo_preprocessor_version 0
//program_version Emerald Viewer
//mono






string version = "2.3";
list tierid = [1,2,3,4];
key requestid_dsp;
integer pointer = 0;
integer pay_cfg_4;
integer pay_cfg_3;
integer pay_cfg_2;
integer pay_cfg_1;


default {


    on_rez(integer sp) {
        llResetScript();
    }


    state_entry() {
        llSetTimerEvent(5);
        (requestid_dsp = llHTTPRequest(("http://www.sublimegeek.com/sg_admin/gridsplode/status/" + llList2String(tierid,pointer)),[0,"POST",1,"application/x-www-form-urlencoded"],""));
    }


    
    http_response(key request_id,integer status,list metadata,string body) {
        if ((request_id == requestid_dsp)) {
            llSetTimerEvent(15);
            list tiers = llParseString2List(body,[":::"],[]);
            (pay_cfg_1 = llList2Integer(tiers,7));
            (pay_cfg_2 = llList2Integer(tiers,8));
            (pay_cfg_3 = llList2Integer(tiers,9));
            (pay_cfg_4 = llList2Integer(tiers,10));
            string sys_status = llList2String(tiers,6);
            string tname = llList2String(tiers,0);
            string _p10 = llList2String(tiers,1);
            string _p21 = llList2String(tiers,2);
            string _p32 = llList2String(tiers,3);
            string _minpay3 = llList2String(tiers,4);
            string _needed_players4 = llList2String(tiers,5);
            string ttexp = llList2String(tiers,11);
            if ((sys_status == "")) {
                (sys_status = "OFFLINE");
            }
            if ((sys_status == "ONLINE")) {
                if ((_needed_players4 == "///SPLODE IMMINENT///")) {
                    llPlaySound("f268d850-8d5f-0912-8b40-b8641380fdce",1.0);
                    llSetText((((((((((((((((("..::[ GridSplode v" + version) + " [") + sys_status) + "] ]::..\n") + tname) + " TIER Current Prizes:\n1st Place: L$") + _p10) + "\n2nd Place: L$") + _p21) + "\n3rd Place: L$") + _p32) + "\n \nSPLODE IMMINENT!!!\nETA: ") + ttexp) + "\nYou still have a chance to WIN!!!\nJust pay me only L$") + _minpay3) + "!!!"),<0.0,1.0,0.0>,1);
                    llSay(0,(((((("[" + tname) + " Tier] WARNING!! SPLODE IMMINENT!! ETA: ") + ttexp) + " \nYou still have a chance to win! Just pay L$") + _minpay3) + " to enter!"));
                }
                else  {
                    llSetText((((((((((((((((("..::[ GridSplode v" + version) + " [") + sys_status) + "] ]::..\n") + tname) + " TIER Current Prizes:\n \n1st Place: L$") + _p10) + "\n2nd Place: L$") + _p21) + "\n3rd Place: L$") + _p32) + "\n \nPay only L$") + _minpay3) + " to enter!\nI need only ") + _needed_players4) + " more entries!"),<0.0,1.0,0.0>,1);
                }
                llSetPayPrice((-1),[pay_cfg_1,pay_cfg_2,pay_cfg_3,pay_cfg_4]);
            }
            else  {
                integer priority;
                if ((sys_status == "DEBUG")) {
                    (sys_status = "MAINTENANCE");
                    llSetTimerEvent(600);
                    llSetPayPrice((-1),[(-1),(-1),(-1),(-1)]);
                    (priority = 1);
                }
                if ((sys_status == "SHUTDOWN")) {
                    (priority = 0);
                    llSetTimerEvent(600);
                    llSetPayPrice((-1),[(-1),(-1),(-1),(-1)]);
                    llDie();
                }
                else  if ((sys_status == "OFFLINE")) {
                    (priority = 0);
                    llSetTimerEvent(600);
                    llSetPayPrice((-1),[(-1),(-1),(-1),(-1)]);
                    llSetText((((((("..::[ GridSplode v" + version) + " [") + sys_status) + "] ]::..\nI'm sorry, we are currently \nin ") + sys_status) + " mode. We\nWill be back ONLINE shortly."),<1.0,priority,0.0>,1);
                }
            }
        }
    }


    
    timer() {
        (requestid_dsp = llHTTPRequest(("http://www.sublimegeek.com/sg_admin/gridsplode/status/" + llList2String(tierid,pointer)),[0,"POST",1,"application/x-www-form-urlencoded"],""));
        if ((pointer <= 2)) {
            (pointer++);
        }
        else  {
            (pointer = 0);
        }
    }


    
    money(key id,integer amt) {
        if ((amt == pay_cfg_1)) {
            (pointer = 0);
        }
        if ((amt == pay_cfg_2)) {
            (pointer = 1);
        }
        if ((amt == pay_cfg_3)) {
            (pointer = 2);
        }
        if ((amt == pay_cfg_4)) {
            (pointer = 3);
        }
        llSleep(1.0);
        llSetTimerEvent(5);
    }
}
