//Client Menu

list menu = ["ONLINE","OFFLINE"];
integer channel = -69787623;


default
{
    state_entry()
    {
        list options = llParseString2List(llGetObjectDesc(),[";"], []);
        key auth = llList2Key(options,4);
        llListen(channel,"",auth,"");
    }

    touch_start(integer total_number)
    {
        list options = llParseString2List(llGetObjectDesc(),[";"], []);
        key auth = llList2Key(options,4);
        llDialog(auth,"Admin Menu",menu,channel);
    }
    
    listen(integer channel, string name, key id, string msg)
    {
        if(msg == "OFFLINE")
        {
            llSetScriptState(".cb_v1.2",FALSE);
            list options = llParseString2List(llGetObjectDesc(),[";"], []);
            key auth = llList2Key(options,4);
            llSetText("metaStreamr Client\nCurrently OFFLINE\n \nAuthorized User:\n"+llKey2Name(auth),<1,1,1>,1);
        }
        if(msg == "ONLINE")
        {
            llSetScriptState(".cb_v1.2",TRUE);
        }
    }
}
