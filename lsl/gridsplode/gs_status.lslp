string  tiername;
string  p1;
string  p2;
string  p3;
string  minpay;
string  needed_players;
list    tierid = [1,2,3,4];
key     requestid_dsp;
string  version = "1.0";
integer pointer = 0;

integer pay_cfg_1;
integer pay_cfg_2;
integer pay_cfg_3;
integer pay_cfg_4;

default
{
    on_rez(integer sp){llResetScript();}
    state_entry(){
        llSetTimerEvent(15);
        //llSetText("",<1,1,1>,1);
        
        requestid_dsp = llHTTPRequest("http://www.sublimegeek.com/backend/gsplode_status.php", 
        [HTTP_METHOD, "POST",HTTP_MIMETYPE, "application/x-www-form-urlencoded"],
        "tierid="+ llList2String(tierid,0));
    }    
    
    http_response(key request_id,integer status,list metadata,string body)
    {
        if(request_id == requestid_dsp){
            
            //llOwnerSay(body);
            
            llSetTimerEvent(15); //Reset the timer
        
            list tiers              = llParseString2List(body,[":::"],[]);
            string tname            = llList2String (tiers,0);
            string p1               = llList2String (tiers,1);
            string p2               = llList2String (tiers,2);
            string p3               = llList2String (tiers,3);
            string minpay           = llList2String (tiers,4);
            string needed_players   = llList2String (tiers,5);
            string sys_status       = llList2String (tiers,6);
                        
            pay_cfg_1               = llList2Integer(tiers,7);
            pay_cfg_2               = llList2Integer(tiers,8);
            pay_cfg_3               = llList2Integer(tiers,9);
            pay_cfg_4               = llList2Integer(tiers,10);
            
            string ttexp            = llList2String (tiers,11);
            
            //If the web server cannot be contacted, assume we are offline
            if(sys_status == ""){sys_status = "OFFLINE";}
            
            if(sys_status == "ONLINE"){
                if(needed_players == "///SPLODE IMMINENT///"){
                    llPlaySound("f268d850-8d5f-0912-8b40-b8641380fdce",1.0); //Warning!
                    llSetText("..::[ GridSplode v"+version+" ["+sys_status+"]]::..
"+tname+" TIER
Current Prizes:
 
1st Place: L$"+p1+"
2nd Place: L$"+p2+"
3rd Place: L$"+p3+"
 
WARNING!!!
SPLODE IMMINENT!!!
ETA: "+ttexp+"

You still have a chance to WIN!!!
Just pay me only L$"+minpay+"!!!",<0,1,0>,1);
llSay(0,"["+tname+" Tier] WARNING!! SPLODE IMMINENT!! ETA: "+ttexp+" \nYou still have a chance to win! Just pay L$"+minpay+" to enter!");

                }else{
                    llSetText("..::[ GridSplode v"+version+" ["+sys_status+"]]::..
"+tname+" TIER
Current Prizes:
 
1st Place: L$"+p1+"
2nd Place: L$"+p2+"
3rd Place: L$"+p3+"
 
Pay only L$"+minpay+" to Enter!
I need "+needed_players+" more players
Before I EXPLODE!!!",<0,1,0>,1);
                }                     
            llSetPayPrice(PAY_HIDE, [pay_cfg_1, pay_cfg_2, pay_cfg_3, pay_cfg_4]);            
            }else{
                
                integer priority;
                
                if(sys_status == "DEBUG"){
                    sys_status = "MAINTENANCE";
                    llSetPayPrice(PAY_HIDE, [PAY_HIDE,PAY_HIDE,PAY_HIDE,PAY_HIDE]);
                    priority   = 1;
                }
                if(sys_status == "SHUTDOWN"){
                    priority = 0;
                    llSetPayPrice(PAY_HIDE, [PAY_HIDE,PAY_HIDE,PAY_HIDE,PAY_HIDE]);
                    llDie();                
                }else if(sys_status == "OFFLINE"){
                    priority = 0;
                    llSetPayPrice(PAY_HIDE, [PAY_HIDE,PAY_HIDE,PAY_HIDE,PAY_HIDE]);
                llSetText("..::[ GridSplode v"+version+" ["+sys_status+"]]::..
I'm sorry, we are currently 
in "+sys_status+" mode. We
Will be back ONLINE shortly.",<1,priority,0>,1);
                }
            }
        }  
    }
    
    timer(){
        requestid_dsp = llHTTPRequest("http://www.sublimegeek.com/backend/gsplode_status.php", 
        [HTTP_METHOD, "POST",HTTP_MIMETYPE, "application/x-www-form-urlencoded"],
        "tierid="+ llList2String(tierid,pointer));
        
        if(pointer <= 2){
            pointer++;
        }else{pointer = 0;}
    }
    
    money(key id, integer amt){
        
        //The purpose of this is if a player is playing a certain tier,
        //show the current tier that the player(s) are playing
        if(amt == pay_cfg_1){pointer = 0;}
        if(amt == pay_cfg_2){pointer = 1;}
        if(amt == pay_cfg_3){pointer = 2;}
        if(amt == pay_cfg_4){pointer = 3;}
        
        llSleep(1.0); //Make sure we don't flood the system
        llSetTimerEvent(5); //Reset the timer
    }
}
