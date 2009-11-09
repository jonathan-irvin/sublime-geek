// LSL script generated: .design_v1.5.7.lslp Fri Oct 30 19:21:32 Central Daylight Time 2009
//metaTip Design
//By Jon Desmoulins


key detected;
integer liloact = 0;
// 0 - Heart
// 1 - Note
// 2 - Star
// 3 - Shield
integer shapeid = 2;
integer usrchan;
integer admchan;
list pst_map = ["183bf4f9-7af1-cc70-a5fa-7181963ca711","57dc4fd3-0c24-48ad-4c7a-5deb67df5f0d","c812335e-c161-33ef-1eb8-4096ae5c8f7e","f1f2bb61-1923-aa51-9936-c69386bc94ef"];
list pst_rot = [360,0,90,90];
list pst_size = [<0.5,0.214,0.5>,<0.5,0.228,0.5>,<0.5,0.5,0.286>,<5.0e-2,0.5,0.5>];

//GLOBAL COLOR VARIABLES
string purewhite = "<255,255,255>";
string pureblack = "<0,0,0>";
string aliceblue = "<240,248,255>";
string aquamarine = "<127,255,212>";
string bisque = "<255,228,196>";
string pureblue = "<0,0,255>";
string blueviolet = "<138,43,226>";
string chartreuse = "<127,255,0>";
string chocolate = "<210,105,30>";
string coral = "<255,127,80>";
string cyan = "<0,255,255>";
string dkblue = "<0,0,139>";
string gold = "<255,215,0>";
string dkorchid = "<153,50,204>";
string hotpink = "<255,20,147>";
string pink = "<255,105,180>";
string skyblue = "<0,191,255>";
string firebrickred = "<178,34,34>";
string puregreen = "<0,255,0>";
string babyblue = "<173,216,230>";
string magenta = "<255,0,255>";
string orange = "<255,165,0>";
string purered = "<255,0,0>";
string royalblue = "<65,105,225>";
string pureyellow = "<255,255,0>";
string springgreen = "<0,255,127>";
string grape = "<160, 32,240>";

//DESIGN & SETTINGS VARIABLES
vector color = <0.0,0.6,0.75>;
string tiptxt = "Please tip if you are so inclined!";
string tipmsg = "Thanks for the tip!  I really appreciate it.";
key sclpmap(integer sid){
    return llList2Key(pst_map,sid);
}
integer rotamt(integer sid){
    return llList2Integer(pst_rot,sid);
}
vector jarsize(integer sid){
    return llList2Vector(pst_size,sid);
}

vector rgb2sl(vector rgb){
    return (rgb / 255);
}

setdefshape(integer sid){
    (shapeid = sid);
    rotation defrot = llEuler2Rot(<(rotamt(sid) * 1.745329238e-2),0.0,0.0>);
    if ((shapeid != 1)) {
        llSetPrimitiveParams([5,1,3,0,8,defrot,9,7,sclpmap(sid),1,7,jarsize(sid)]);
    }
    else  {
        llSetPrimitiveParams([5,1,3,0,8,defrot,7,jarsize(sid)]);
    }
    llSetLinkAlpha(-2,0.46,-1);
}
sysMessage(integer destination,string command,string request){
    llMessageLinked(-4,destination,((command + "|") + request),NULL_KEY);
}

default {

    link_message(integer sender_num,integer num,string str,key id) {
        list comms = llParseString2List(str,["|"],[]);
        string command = llList2String(comms,0);
        string request = llList2String(comms,1);
        string attribute = llList2String(comms,2);
        if ((num = -8511582)) {
            if ((command == "set")) {
                if ((request == "defshape")) {
                    setdefshape(((integer)attribute));
                }
                if ((request == "lilo_off")) {
                    (liloact = 0);
                }
                if ((request == "lilo_on")) {
                    (liloact = 1);
                }
                if ((request == "custcolor")) {
                    state setcustcolor;
                }
                if ((request == "pstcolor")) {
                    state setpstcolor;
                }
                if ((request == "tipmsgset")) {
                    state tipmsgset;
                }
                if ((request == "tiptxtset")) {
                    state tiptxtset;
                }
                if ((request == "shape")) {
                    state shapeset;
                }
            }
        }
        (admchan = ((((integer)llFrand(3)) - 1) * ((integer)llFrand(2147483646))));
        (usrchan = ((((integer)llFrand(3)) - 1) * ((integer)llFrand(2147483646))));
        if ((admchan == 0)) {
            (admchan = (-5287954 + ((integer)llFrand(100))));
        }
        if ((usrchan == 0)) {
            (usrchan = (-3249957 + ((integer)llFrand(100))));
        }
        (detected = ((key)llList2String(comms,2)));
    }
}

state shapeset {

    on_rez(integer p) {
        llResetScript();
    }

    state_entry() {
        llOwnerSay("Going in standby mode...\nPlease choose the following available shapes\nYou have 30 seconds before I go back to my normal state.");
        llDialog(llGetOwner(),"Shape Selection\nChoose a shape...",["Heart","Star","Shield"],-5287954);
        llSetText("[SET SHAPE MODE]\nYou have 30 seconds before I become active again!",<1.0,1.0,1.0>,1);
        llListen(5,"",llGetOwner(),"");
        llListen(-5287954,"",llGetOwner(),"");
        llSetTimerEvent(30);
    }

    timer() {
        llOwnerSay("Times up! Going back to accepting payments");
        llMessageLinked(-4,0,"return2run",NULL_KEY);
        state default;
    }

    listen(integer channel,string name,key id,string msg) {
        if ((channel == -5287954)) {
            if ((msg == "Heart")) {
                sysMessage(-7173976,"set","shape|0");
                (shapeid = 0);
                setdefshape(shapeid);
                llSleep(2);
                state default;
            }
            else  if ((msg == "Star")) {
                sysMessage(-7173976,"set","shape|2");
                (shapeid = 2);
                setdefshape(shapeid);
                llSleep(2);
                state default;
            }
            else  if ((msg == "Shield")) {
                sysMessage(-7173976,"set","shape|3");
                (shapeid = 3);
                setdefshape(shapeid);
                llSleep(2);
                state default;
            }
            else  {
                llSay(0,"I'm sorry, you selected an invalid shape name...please try again.");
            }
        }
        if ((!liloact)) {
            sysMessage(-7173976,"set","running");
            state default;
        }
    }

    state_exit() {
        llSetTimerEvent(0);
    }
}

state setcustcolor {

    on_rez(integer p) {
        llResetScript();
    }

    state_entry() {
        llOwnerSay("Going in standby mode...\nPlease say the color in RGB format Example: <255,255,255> is all white. \nYou have 30 seconds before I go back to my normal state.");
        llOwnerSay("All commands are on channel 5, example: /5 <255,255,255>");
        llSetText("[SET COLOR MODE]\nYou have 30 seconds before I become active again!",<1.0,1.0,1.0>,1);
        llListen(5,"",llGetOwner(),"");
        llSetTimerEvent(30);
    }

    timer() {
        llOwnerSay("Times up! Going back to accepting payments");
        sysMessage(-7173976,"set","running");
        state default;
    }

    listen(integer channel,string name,key id,string msg) {
        (color = rgb2sl(((vector)msg)));
        llOwnerSay("Setting Color...");
        sysMessage(-7173976,"set",("color|" + ((string)color)));
        if ((!liloact)) {
            sysMessage(-7173976,"set","running");
            state default;
        }
    }

    state_exit() {
        llSetTimerEvent(0);
    }
}

state setpstcolor {

    on_rez(integer p) {
        llResetScript();
    }

    state_entry() {
        llOwnerSay("Going in standby mode...\nPlease say the color you want to set the metaTip jar to...");
        llOwnerSay("All commands are on channel 5, example: /5 gold");
        llOwnerSay("Available colors are: \ndefault,purewhite, pureblack,  \naliceblue, aquamarine, bisque,  \npureblue, blueviolet, chartreuse,  \nchocolate, coral, cyan,  \ndkblue, gold, dkorchid, \nhotpink, pink, skyblue,  \nfirebrickred, puregreen, babyblue,\n magenta, orange, purered, \nroyalblue, pureyellow, springgreen, \nand grape.");
        llOwnerSay("You have 30 seconds before I go back to my normal state.");
        llSetText("[SET COLOR MODE]\nYou have 30 seconds before I become active again!",<1.0,1.0,1.0>,1);
        llListen(5,"",llGetOwner(),"");
        llSetTimerEvent(30);
    }

    timer() {
        llOwnerSay("Times up! Going back to accepting payments");
        sysMessage(-7173976,"set","running");
        state default;
    }

    listen(integer channel,string name,key id,string msg) {
        (msg = llStringTrim(msg,3));
        if ((msg == "default")) {
            (color = <0.0,0.6,0.75>);
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "purewhite")) {
            (color = rgb2sl(((vector)purewhite)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "pureblack")) {
            (color = rgb2sl(((vector)pureblack)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "aliceblue")) {
            (color = rgb2sl(((vector)aliceblue)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "aquamarine")) {
            (color = rgb2sl(((vector)aquamarine)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "bisque")) {
            (color = rgb2sl(((vector)bisque)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "pureblue")) {
            (color = rgb2sl(((vector)pureblue)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "blueviolet")) {
            (color = rgb2sl(((vector)blueviolet)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "chartreuse")) {
            (color = rgb2sl(((vector)chartreuse)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "chocolate")) {
            (color = rgb2sl(((vector)chocolate)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "coral")) {
            (color = rgb2sl(((vector)coral)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "cyan")) {
            (color = rgb2sl(((vector)cyan)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "dkblue")) {
            (color = rgb2sl(((vector)dkblue)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "gold")) {
            (color = rgb2sl(((vector)gold)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "dkorchid")) {
            (color = rgb2sl(((vector)dkorchid)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "hotpink")) {
            (color = rgb2sl(((vector)hotpink)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "pink")) {
            (color = rgb2sl(((vector)pink)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "skyblue")) {
            (color = rgb2sl(((vector)skyblue)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "firebrickred")) {
            (color = rgb2sl(((vector)firebrickred)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "puregreen")) {
            (color = rgb2sl(((vector)puregreen)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "babyblue")) {
            (color = rgb2sl(((vector)babyblue)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "magenta")) {
            (color = rgb2sl(((vector)magenta)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "orange")) {
            (color = rgb2sl(((vector)orange)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "purered")) {
            (color = rgb2sl(((vector)purered)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "royalblue")) {
            (color = rgb2sl(((vector)royalblue)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "pureyellow")) {
            (color = rgb2sl(((vector)pureyellow)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "springgreen")) {
            (color = rgb2sl(((vector)springgreen)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  if ((msg == "grape")) {
            (color = rgb2sl(((vector)grape)));
            llOwnerSay((("Setting color to " + msg) + "..."));
        }
        else  {
            llOwnerSay("I'm sorry!  You specified an invalid color, I'm going back to accepting payments.");
        }
        setdefshape(shapeid);
        sysMessage(-7173976,"set",("color|" + ((string)color)));
        if ((!liloact)) {
            sysMessage(-7173976,"set","running");
            state default;
        }
    }

    state_exit() {
        llSetTimerEvent(0);
    }
}

state tiptxtset {

    on_rez(integer p) {
        state default;
    }

    state_entry() {
        llOwnerSay("Please say the text you want as the hovering txt. Default:\"Please tip if you are so inclined!\" \n\nYou have 30 seconds before I go back to my normal state.");
        llOwnerSay("All commands are on channel 5, example: /5 text");
        llSetText("[SET TIP TXT MODE]\nYou have 30 seconds before I become active again!",<1.0,1.0,1.0>,1);
        llListen(5,"",llGetOwner(),"");
        llSetTimerEvent(30);
    }

    timer() {
        llOwnerSay("Times up! Going back to accepting payments");
        sysMessage(-7173976,"set","running");
        state default;
    }

    listen(integer channel,string name,key id,string msg) {
        (tiptxt = msg);
        llOwnerSay((("Setting Tip Text to '" + msg) + "'"));
        llOwnerSay("Setting Tip Text...");
        sysMessage(-7173976,"set",("tip_txt|" + msg));
        if ((!liloact)) {
            sysMessage(-7173976,"set","running");
            state default;
        }
    }

    state_exit() {
        llSetTimerEvent(0);
    }
}

state tipmsgset {

    on_rez(integer p) {
        state default;
    }

    state_entry() {
        llOwnerSay("Please say the text you want as the message send to your tippers. Default:\"Thanks for the tip!  I really appreciate it.\" \n\nYou have 30 seconds before I go back to my normal state.");
        llOwnerSay("All commands are on channel 5, example: /5 text");
        llSetText("[SET TIP MESSAGE MODE]\nYou have 30 seconds before I become active again!",<1.0,1.0,1.0>,1);
        llListen(5,"",llGetOwner(),"");
        llSetTimerEvent(30);
    }

    timer() {
        llOwnerSay("Times up! Going back to accepting payments");
        sysMessage(-7173976,"set","running");
        state default;
    }

    listen(integer channel,string name,key id,string msg) {
        (tipmsg = msg);
        llOwnerSay((("Setting Tip Message to '" + msg) + "'"));
        llOwnerSay("Setting Tip Message...");
        sysMessage(-7173976,"set",("tip_msg|" + msg));
        if ((!liloact)) {
            sysMessage(-7173976,"set","running");
            state default;
        }
    }

    state_exit() {
        llSetTimerEvent(0);
    }
}
