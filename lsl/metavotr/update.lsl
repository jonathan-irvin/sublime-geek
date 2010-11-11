// LSL script generated: update.lslp Thu Nov 11 15:55:21 CST 2010
//start_unprocessed_text
/*/|/ LSL script generated: update_v2.lslp Sun Sep 27 16:15:14 Central Daylight Time 2009
/|/ *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*
/|/ IMPORTANT! IMPORTANT! IMPORTANT! IMPORTANT! IMPORTANT!
/|/ SET THE PERMISSIONS ON THIS SCRIPT TO NO TRANSFER
/|/ BEFORE YOU INCLUDE IT IN YOUR PRODUCTS!
/|/ *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*

/|/ FOLLOW THE INSTRUCTIONS BELOW TO EDIT THIS SCRIPT TO
/|/ WORK WITH YOUR PRODUCT

/|/ insert your server name between the quotemarks below
string server = "Sublime Geek Update Server";

/|/ insert your server's password between the quotemarks below
string password = "Jurb1f!ed";

/|/ insert the product name between the quotemarks below
string product = "pmetaVotr";

/|/ insert the current version number between the quotemarks below
/|/ don't use numbers like 1.2.4 ... stick to integers (1, 4, 9 etc.) or decimals (1.2, 4.12 etc.)
string version = "2.5";

/|/ insert your avatar key below (use the server's "My Key" command to get it)
string my_key = "6aab7af0-8ce8-4361-860b-7139054ed44f";
/|/ tip: hourly = 3600; daily = 86400;
/|/ personally I use nothing less than the daily amount, to reduce lag










/|/ *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*
/|/ * DON'T CHANGE THINGS BELOW THIS POINT UNLESS YOU KNOW WHAT YOU'RE DOING!
/|/ *|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*|*

string myRPC;
string serverKEY;
string last_url;
integer retries;
string ownerName;

check_for_update(){
    integer hash = ((((integer)llFrand(9999)) * llGetUnixTime()) % 65536);
    if ((hash < 0)) {
        (hash *= -1);
    }
    load_html(((((((((((((((((((("http:/|/www.hippo-tech-sl.com/hippoupdate/update-give.php?N=" + llEscapeURL(server)) + "&O=") + my_key) + "&PS=") + llMD5String(password,45736)) + "&PR=") + llEscapeURL(product)) + "&V=") + llEscapeURL(version)) + "&TO=") + ((string)llGetOwner())) + "&TONAME=") + llEscapeURL(ownerName)) + "&H=") + ((string)hash)) + "&R=") + myRPC) + "&T=") + "43200"));
}

load_html(string url){
    (last_url = url);
    llHTTPRequest(url,[0,"GET"],"");
}

process_command(string message){
    list data = llParseStringKeepNulls(message,["^"],[]);
    if ((llList2String(data,0) == "SUCCESS")) {
        llMessageLinked(-1,-2948813,"SUCCESS","");
        return;
    }
    if ((llList2String(data,0) == "FAIL")) {
        llMessageLinked(-1,-2948813,llList2String(data,1),"");
        return;
    }
    if ((llList2String(data,0) == "DOUPDATE")) {
        (serverKEY = llList2String(data,1));
        llEmail((serverKEY + "@lsl.secondlife.com"),(llMD5String(password,28172) + "XGIVE"),((((((((((((((((llList2String(data,2) + "^") + llList2String(data,3)) + "^") + llList2String(data,4)) + "^") + llList2String(data,5)) + "^") + llList2String(data,6)) + "^") + llList2String(data,7)) + "^") + llList2String(data,8)) + "^") + llList2String(data,9)) + "^") + llList2String(data,10)));
    }
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
                llMessageLinked(-1,-2948813,"HTTP PROBLEM","");
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
*/
//end_unprocessed_text
//nfo_preprocessor_version 0
//program_version Emerald Viewer 1.4.0.2439 - Jon Desmoulins
//mono


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
