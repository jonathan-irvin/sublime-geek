// LSL script generated: .api_v1.5.7.lslp Fri Oct 30 19:21:32 Central Daylight Time 2009
//metaTip API
//By Jon Desmoulins

//HTTP GLOBALS
key requestid;

//API KEY GLOBALS
list desc;
string adm_name;
string api_key;
integer apicheck = 0;

sysMessage(integer destination,string command,string request){
    llMessageLinked(-4,destination,((command + "|") + request),NULL_KEY);
}
genApi(){
    (requestid = llHTTPRequest("https://www.sublimegeek.com/backend/api_generator.php",[0,"POST",1,"application/x-www-form-urlencoded",3,1],""));
}

default {

    link_message(integer sender_num,integer num,string str,key id) {
        list comms = llParseString2List(str,["|"],[]);
        string command = llList2String(comms,0);
        string request = llList2String(comms,1);
        string attribute = llList2String(comms,2);
        if ((num = -9519803)) {
            if ((command == "get")) {
                if ((request == "api")) {
                    genApi();
                }
            }
        }
    }

    http_response(key request_id,integer status,list metadata,string body) {
        if ((requestid == request_id)) {
            (desc = llParseString2List(llGetObjectDesc(),["::::"],[]));
            (adm_name = llList2String(desc,0));
            (api_key = llList2String(desc,1));
            list feedback = llParseString2List(body,[","],[]);
            string loc = llList2String(feedback,0);
            string api = llList2String(feedback,1);
            string auth = llList2String(feedback,2);
            if ((apicheck == 0)) {
                if ((((llGetObjectDesc() == "(No Description)") || (api_key == "")) || (adm_name != llKey2Name(llGetOwner())))) {
                    if ((loc == "newkey")) {
                        if (((api != "") || (adm_name != llKey2Name(llGetOwner())))) {
                            llSetObjectDesc(((llKey2Name(llGetOwner()) + "::::") + api));
                            llOwnerSay("Your key has been updated into your control panel's description");
                            sysMessage(-7173976,"info","API_OK");
                            (apicheck++);
                        }
                        else  {
                            llOwnerSay("Oops! Looks like your API key didn't go through all the way, trying again!");
                        }
                    }
                    if ((loc == "existing")) {
                        if (((api != "") || (adm_name != llKey2Name(llGetOwner())))) {
                            llSetObjectDesc(((llKey2Name(llGetOwner()) + "::::") + api));
                            llOwnerSay("Your key has been updated into your control panel's description");
                            sysMessage(-7173976,"info","API_OK");
                            (apicheck++);
                        }
                        else  {
                            llOwnerSay("Oops! Looks like your API key didn't go through all the way, trying again!");
                        }
                    }
                }
            }
            if ((loc == "expired")) {
                llOwnerSay("I'm sorry, your API key is invalid or your license has expired");
            }
            if ((loc == "msg")) {
                llOwnerSay(api);
            }
        }
    }
}
