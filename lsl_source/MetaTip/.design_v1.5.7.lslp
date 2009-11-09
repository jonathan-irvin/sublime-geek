//metaTip Design
//By Jon Desmoulins

integer     totaldonated;
string      owner;
key         requestid;
key         detected;
integer     sfloat;
string      txthgt = "\n \n \n ";
integer     liloact  = FALSE; //Lilo is set to off by default

//GLOBAL COMM CHANNELS
integer 	BASE   = -7173976;
integer 	API    = -9519803;
integer 	DESIGN = -8511582;

//OPERATIONAL CONFIG
string      version = "1.5.7";
integer     showpmt = TRUE;
// 0 - Heart
// 1 - Note
// 2 - Star
// 3 - Shield
integer     shapeid = 2;
list        availshapes = ["Heart","Star","Shield"];
integer     usrchan;
integer     admchan;

//SHAPES & CONFIG
list pst_names = ["Heart","Note","Star","Shield"];                  
list pst_map   = ["183bf4f9-7af1-cc70-a5fa-7181963ca711",
                  "57dc4fd3-0c24-48ad-4c7a-5deb67df5f0d",
                  "c812335e-c161-33ef-1eb8-4096ae5c8f7e",
                  "f1f2bb61-1923-aa51-9936-c69386bc94ef"]; 
list pst_rot   = [360,          0,              90,             90];                  
list pst_fltv  = [<0,0,.25>,    <0,0,.25>,      <0,.25,0>,      <0,.25,0>];                  
list pst_nfltv = [<0,0,.25>,    <0,0,.25>,      <0,0,.25>,      <0,0,.25>];
list pst_size  = [<.5,.214,.5>, <.5,.228,.5>,   <.5,.5,.286>,   <.05,.5,.5>];

string      objname(integer sid) {return llList2String (pst_names ,sid);}
key         sclpmap(integer sid) {return llList2Key    (pst_map   ,sid);}
integer     rotamt(integer sid)  {return llList2Integer(pst_rot   ,sid);}
vector      floatv(integer sid)  {return llList2Vector (pst_fltv  ,sid);}
vector      nfloatv(integer sid) {return llList2Vector (pst_nfltv ,sid);}
vector      jarsize(integer sid) {return llList2Vector (pst_size  ,sid);}

//GLOBAL COLOR VARIABLES
string purewhite    = "<255,255,255>";
string pureblack    = "<0,0,0>";
string aliceblue    = "<240,248,255>";
string aquamarine   = "<127,255,212>";
string bisque       = "<255,228,196>";
string pureblue     = "<0,0,255>";
string blueviolet   = "<138,43,226>";
string chartreuse   = "<127,255,0>";
string chocolate    = "<210,105,30>";
string coral        = "<255,127,80>";
string cyan         = "<0,255,255>";
string dkblue       = "<0,0,139>";
string gold         = "<255,215,0>";
string dkorchid     = "<153,50,204>";
string hotpink      = "<255,20,147>";
string pink         = "<255,105,180>";
string skyblue      = "<0,191,255>";
string firebrickred = "<178,34,34>";
string puregreen    = "<0,255,0>";
string babyblue     = "<173,216,230>";
string magenta      = "<255,0,255>";
string orange       = "<255,165,0>";
string purered      = "<255,0,0>";
string royalblue    = "<65,105,225>";
string pureyellow   = "<255,255,0>";
string springgreen  = "<0,255,127>";
string grape        = "<160, 32,240>";

//DESIGN & SETTINGS VARIABLES
vector      color   = <0,.6,.75>;
string      tiptxt  = "Please tip if you are so inclined!";
string      tipmsg  = "Thanks for the tip!  I really appreciate it.";

vector sl2rgb( vector sl ){
    sl *= 255;                //Scale the SL color up by 255
    return <(integer)sl.x, (integer)sl.y, (integer)sl.z>;    //Make each part of it a whole number
}

vector rgb2sl( vector rgb ){
    return rgb / 255;        //Scale the RGB color down by 255
}

setdefshape(integer sid){		
	shapeid = sid; //Update the global
	rotation    defrot  = llEuler2Rot(<rotamt(sid)*DEG_TO_RAD,0,0>);
    
	//llOwnerSay("DEBUG:\nShapeid: "+(string)sid+"\nName: "+(string)objname(sid)+"\nMap: "+(string)sclpmap(sid) +"\nRotation: "+(string)rotamt(sid)  +"\nFloat Vector: "+(string)floatv(sid)  +"\nNon Float Vector: "+(string)nfloatv(sid) +"\nSize Vector: "+(string)jarsize(sid));
    
    if(shapeid != 1){
        llSetPrimitiveParams([PRIM_PHANTOM,TRUE,PRIM_PHYSICS,FALSE,PRIM_ROTATION,defrot,
        PRIM_TYPE, PRIM_TYPE_SCULPT,sclpmap(sid),PRIM_SCULPT_TYPE_SPHERE,PRIM_SIZE, jarsize(sid)]);}
    else{llSetPrimitiveParams([PRIM_PHANTOM,TRUE,PRIM_PHYSICS,FALSE,PRIM_ROTATION,defrot,PRIM_SIZE, jarsize(sid)]);}        
    llSetLinkAlpha(LINK_ALL_OTHERS,0.46,ALL_SIDES);     
}
sysMessage(integer destination,string command, string request){
	llMessageLinked(LINK_THIS,destination,command + "|" + request,NULL_KEY);
}

default
{
    link_message(integer sender_num, integer num, string str, key id)
    {
        //llOwnerSay("Design API Msg: "+str);
        
        list   comms     = llParseString2List(str,["|"],[]);
        string command   = llList2String(comms,0);        
        string request   = llList2String(comms,1);
        string attribute = llList2String(comms,2);       
        
        if(num = DESIGN){//This message is for us
	        if(command == "set"){
	        	if(request == "defshape")    {setdefshape((integer)attribute);}        
		        if(request == "lilo_off")    {liloact = FALSE;}
		        if(request == "lilo_on")     {liloact = TRUE;}
		        
		        if(request == "custcolor")   {state setcustcolor;}
		        if(request == "pstcolor")    {state setpstcolor;}
		        if(request == "tipmsgset")   {state tipmsgset;}
		        if(request == "tiptxtset")   {state tiptxtset;}
		        if(request == "shape")       {state shapeset;}
	        }
        }
        //GENERATE RANDOM CHANNELS FOR COMMS
        admchan = ((integer) llFrand(3) - 1) * ((integer) llFrand(2147483646));
        usrchan = ((integer) llFrand(3) - 1) * ((integer) llFrand(2147483646));
        
        //FALL BACK TO SECURE CHANNELS IF EITHER IS BAD
        if(admchan == 0){admchan = -5287954 + (integer)llFrand(100);}
        if(usrchan == 0){usrchan = -3249957 + (integer)llFrand(100);}
        
        detected = (key)llList2String(comms,2);        
    }    
}

state shapeset{ //Change shape of unit
    on_rez(integer p){llResetScript();}
    state_entry(){
        llOwnerSay("Going in standby mode...\nPlease choose the following available shapes\nYou have 30 seconds before I go back to my normal state.");
        llDialog(llGetOwner(),"Shape Selection\nChoose a shape...",
        ["Heart","Star","Shield"],
         -5287954);
        llSetText("[SET SHAPE MODE]\nYou have 30 seconds before I become active again!",<1,1,1>,1);
        llListen(       5,"",llGetOwner(),"");
        llListen(-5287954,"",llGetOwner(),"");
        llSetTimerEvent(30);
    }
    timer(){llOwnerSay("Times up! Going back to accepting payments");
        llMessageLinked(LINK_THIS, 0, "return2run", NULL_KEY);
        state default;
    }
    listen(integer channel,string name,key id,string msg){
        if(channel == -5287954){            
            if(msg == "Heart"){                
                sysMessage(BASE,"set","shape|0");
                shapeid = 0;
                setdefshape(shapeid);
                llSleep(2);                    
                state default;
            }
            else if(msg == "Star"){                
                sysMessage(BASE,"set","shape|2");
                shapeid = 2;
                setdefshape(shapeid);
                llSleep(2);
                state default;
            }
            else if(msg == "Shield"){                
                sysMessage(BASE,"set","shape|3");
                shapeid = 3;
                setdefshape(shapeid);
                llSleep(2);                   
                state default;
            }
            else{llSay(0,"I'm sorry, you selected an invalid shape name...please try again.");}
        }        
        
        if(!liloact){
            sysMessage(BASE,"set","running");
            state default;
            }
    }
    state_exit(){llSetTimerEvent(0);}
}

state setcustcolor{ //FOR MORE PRECISE COLORS
    on_rez(integer p){llResetScript();}
    state_entry(){
        llOwnerSay("Going in standby mode...\nPlease say the color in RGB format Example: <255,255,255> is all white. \nYou have 30 seconds before I go back to my normal state.");
        llOwnerSay("All commands are on channel 5, example: /5 <255,255,255>");
        llSetText("[SET COLOR MODE]\nYou have 30 seconds before I become active again!",<1,1,1>,1);
        llListen(5,"",llGetOwner(),"");
        llSetTimerEvent(30);
    }
    timer(){llOwnerSay("Times up! Going back to accepting payments");
        sysMessage(BASE,"set","running");
        state default;
    }
    listen(integer channel,string name,key id,string msg){
        color = rgb2sl((vector)msg);        
        llOwnerSay("Setting Color...");        
        sysMessage(BASE,"set","color|"+(string)color);
        if(!liloact){
            sysMessage(BASE,"set","running");
            state default;
            }
    }
    state_exit(){llSetTimerEvent(0);}
}

state setpstcolor{ //FOR MORE PRESET COLORS
    on_rez(integer p){llResetScript();}
    state_entry(){
        llOwnerSay("Going in standby mode...\nPlease say the color you want to set the metaTip jar to...");
        llOwnerSay("All commands are on channel 5, example: /5 gold");
        llOwnerSay("Available colors are: \ndefault,purewhite, pureblack,  \naliceblue, aquamarine, bisque,  \npureblue, blueviolet, chartreuse,  \nchocolate, coral, cyan,  \ndkblue, gold, dkorchid, \nhotpink, pink, skyblue,  \nfirebrickred, puregreen, babyblue,\n magenta, orange, purered, \nroyalblue, pureyellow, springgreen, \nand grape.");     
        llOwnerSay("You have 30 seconds before I go back to my normal state.");
        llSetText("[SET COLOR MODE]\nYou have 30 seconds before I become active again!",<1,1,1>,1);
        llListen(5,"",llGetOwner(),"");
        llSetTimerEvent(30);
    }
    timer(){llOwnerSay("Times up! Going back to accepting payments");
        sysMessage(BASE,"set","running");
        state default;        
    }
    listen(integer channel,string name,key id,string msg){
        
        msg = llStringTrim(msg,STRING_TRIM); //TRIM IT DOWN
        
        if(msg == "default")             {color = <0,.6,.75>;                    llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "purewhite")      {color = rgb2sl((vector)purewhite);     llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "pureblack")      {color = rgb2sl((vector)pureblack);     llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "aliceblue")      {color = rgb2sl((vector)aliceblue);     llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "aquamarine")     {color = rgb2sl((vector)aquamarine);    llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "bisque")         {color = rgb2sl((vector)bisque);        llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "pureblue")       {color = rgb2sl((vector)pureblue);      llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "blueviolet")     {color = rgb2sl((vector)blueviolet);    llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "chartreuse")     {color = rgb2sl((vector)chartreuse);    llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "chocolate")      {color = rgb2sl((vector)chocolate);     llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "coral")          {color = rgb2sl((vector)coral);         llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "cyan")           {color = rgb2sl((vector)cyan);          llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "dkblue")         {color = rgb2sl((vector)dkblue);        llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "gold")           {color = rgb2sl((vector)gold);          llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "dkorchid")       {color = rgb2sl((vector)dkorchid);      llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "hotpink")        {color = rgb2sl((vector)hotpink);       llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "pink")           {color = rgb2sl((vector)pink);          llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "skyblue")        {color = rgb2sl((vector)skyblue);       llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "firebrickred")   {color = rgb2sl((vector)firebrickred);  llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "puregreen")      {color = rgb2sl((vector)puregreen);     llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "babyblue")       {color = rgb2sl((vector)babyblue);      llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "magenta")        {color = rgb2sl((vector)magenta);       llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "orange")         {color = rgb2sl((vector)orange);        llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "purered")        {color = rgb2sl((vector)purered);       llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "royalblue")      {color = rgb2sl((vector)royalblue);     llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "pureyellow")     {color = rgb2sl((vector)pureyellow);    llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "springgreen")    {color = rgb2sl((vector)springgreen);   llOwnerSay("Setting color to "+msg+"...");}
        else if(msg == "grape")          {color = rgb2sl((vector)grape);         llOwnerSay("Setting color to "+msg+"...");}
        else{llOwnerSay("I'm sorry!  You specified an invalid color, I'm going back to accepting payments.");}
        
        setdefshape(shapeid);        
        
        sysMessage(BASE,"set","color|"+(string)color);
        
        if(!liloact){
            sysMessage(BASE,"set","running");
            state default;
            }
    }
    state_exit(){llSetTimerEvent(0);}
}

state tiptxtset {
    on_rez(integer p){state default;}
    state_entry(){
        llOwnerSay("Please say the text you want as the hovering txt. Default:\"Please tip if you are so inclined!\" \n\nYou have 30 seconds before I go back to my normal state.");
        llOwnerSay("All commands are on channel 5, example: /5 text");
        llSetText("[SET TIP TXT MODE]\nYou have 30 seconds before I become active again!",<1,1,1>,1);
        llListen(5,"",llGetOwner(),"");
        llSetTimerEvent(30);
    }
    timer(){llOwnerSay("Times up! Going back to accepting payments");
         sysMessage(BASE,"set","running");
         state default;
    }
    listen(integer channel,string name,key id,string msg){
        tiptxt = msg;        
        llOwnerSay("Setting Tip Text to '"+msg+"'");
        llOwnerSay("Setting Tip Text...");        
        sysMessage(BASE,"set","tip_txt|"+msg);
        if(!liloact){
            sysMessage(BASE,"set","running");
            state default;
            }
    }
    state_exit(){llSetTimerEvent(0);}
}

state tipmsgset {
    on_rez(integer p){state default;}
    state_entry(){
        llOwnerSay("Please say the text you want as the message send to your tippers. Default:\"Thanks for the tip!  I really appreciate it.\" \n\nYou have 30 seconds before I go back to my normal state.");
       llOwnerSay("All commands are on channel 5, example: /5 text"); 
        llSetText("[SET TIP MESSAGE MODE]\nYou have 30 seconds before I become active again!",<1,1,1>,1);
        llListen(5,"",llGetOwner(),"");
        llSetTimerEvent(30);
    }
    timer(){llOwnerSay("Times up! Going back to accepting payments");
        sysMessage(BASE,"set","running");
        state default;
    }
    listen(integer channel,string name,key id,string msg){
        tipmsg = msg;        
        llOwnerSay("Setting Tip Message to '"+msg+"'");
        llOwnerSay("Setting Tip Message...");
        sysMessage(BASE,"set","tip_msg|"+msg);        
        if(!liloact){
            sysMessage(BASE,"set","running");
            state default;
            }
    }
    state_exit(){llSetTimerEvent(0);}
}