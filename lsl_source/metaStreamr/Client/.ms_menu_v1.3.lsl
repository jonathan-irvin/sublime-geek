// LSL script generated: Client..ms_menu_v1.3.lslp Fri Oct 30 19:21:31 Central Daylight Time 2009
//Client Menu

list menu = ["ONLINE","OFFLINE"];


default {

    state_entry() {
        list options = llParseString2List(llGetObjectDesc(),[";"],[]);
        key auth = llList2Key(options,4);
        llListen(-69787623,"",auth,"");
    }


    touch_start(integer total_number) {
        list options = llParseString2List(llGetObjectDesc(),[";"],[]);
        key auth = llList2Key(options,4);
        llDialog(auth,"Admin Menu",menu,-69787623);
    }

    
    listen(integer _channel0,string name,key id,string msg) {
        if ((msg == "OFFLINE")) {
            llSetScriptState(".cb_v1.2",0);
            list options = llParseString2List(llGetObjectDesc(),[";"],[]);
            key auth = llList2Key(options,4);
            llSetText(("metaStreamr Client\nCurrently OFFLINE\n \nAuthorized User:\n" + llKey2Name(auth)),<1.0,1.0,1.0>,1);
        }
        if ((msg == "ONLINE")) {
            llSetScriptState(".cb_v1.2",1);
        }
    }
}
