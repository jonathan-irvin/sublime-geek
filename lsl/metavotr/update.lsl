// LSL script generated: update.lslp Thu Nov 11 16:01:51 CST 2010
string version = "2.5";
string serverKEY;
string server = "Sublime Geek Update Server";
integer retries;
string product = "pmetaVotr";
string password = "Jurb1f!ed";
string ownerName;
string my_key = "6aab7af0-8ce8-4361-860b-7139054ed44f";
string myRPC;
string last_url;


process_command(string message){
    list data = llParseStringKeepNulls(message,["^"],[]);
    if ((llList2String(data,0) == "SUCCESS")) {
        llMessageLinked((-1),(-2948813),"SUCCESS","");
        return;
    }
    if ((llList2String(data,0) == "FAIL")) {
        llMessageLinked((-1),(-2948813),llList2String(data,1),"");
        return;
    }
    if ((llList2String(data,0) == "DOUPDATE")) {
        (serverKEY = llList2String(data,1));
        llEmail((serverKEY + "@lsl.secondlife.com"),(llMD5String(password,28172) + "XGIVE"),((((((((((((((((llList2String(data,2) + "^") + llList2String(data,3)) + "^") + llList2String(data,4)) + "^") + llList2String(data,5)) + "^") + llList2String(data,6)) + "^") + llList2String(data,7)) + "^") + llList2String(data,8)) + "^") + llList2String(data,9)) + "^") + llList2String(data,10)));
    }
}


load_html(string url){
    (last_url = url);
    llHTTPRequest(url,[0,"GET"],"");
}


check_for_update(){
    integer hash = ((((integer)llFrand(9999)) * llGetUnixTime()) % 65536);
    if ((hash < 0)) {
        (hash *= (-1));
    }
    load_html(((((((((((((((((((("http://www.hippo-tech-sl.com/hippoupdate/update-give.php?N=" + llEscapeURL(server)) + "&O=") + my_key) + "&PS=") + llMD5String(password,45736)) + "&PR=") + llEscapeURL(product)) + "&V=") + llEscapeURL(version)) + "&TO=") + ((string)llGetOwner())) + "&TONAME=") + llEscapeURL(ownerName)) + "&H=") + ((string)hash)) + "&R=") + myRPC) + "&T=") + "43200"));
}


default {


   
    on_rez(integer params) {
        llResetScript();
    }


    
    state_entry() {
        (ownerName = llKey2Name(llGetOwner()));
        if ((llGetInventoryPermMask(llGetScriptName(),4) & 8192)) {
            llWhisper(0,(("Warning! Transfer permissions are set on " + llGetScriptName()) + "!"));
        }
        if ((llGetInventoryPermMask(llGetScriptName(),4) & 16384)) {
            llWhisper(0,(("Warning! Modify permissions are set on " + llGetScriptName()) + "!"));
        }
        llOpenRemoteDataChannel();
        llSetTimerEvent(3600);
    }


        
    timer() {
        check_for_update();
    }


    
    remote_data(integer type,key channel,key message_id,string sender,integer idata,string sdata) {
        if ((type == 1)) {
            (myRPC = channel);
            return;
        }
        if ((type == 2)) {
            process_command(sdata);
        }
    }


    
    http_response(key id,integer err,list metadata,string body) {
        if (((err == 404) || (err == 500))) {
            (retries++);
            if ((retries > 4)) {
                (retries = 0);
                (last_url = "");
                llMessageLinked((-1),(-2948813),"HTTP PROBLEM","");
            }
            if ((last_url != "")) {
                load_html(last_url);
            }
        }
        else  {
            (last_url = "");
            (retries = 0);
            process_command(body);
        }
    }
}
