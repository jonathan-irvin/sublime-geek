var menu1=new Array()
menu1[0]='<a href="index.php">Admin Home</a>'
menu1[1]='<a href="myaccount.php">My Account</a>'
menu1[2]='<a href="logout.php">Logout</a>'

var menu2=new Array()
menu2[0]='<a href="clients.php">View/Search Clients</a>'
menu2[1]='<a href="clientsadd.php">Add New Client</a>'
menu2[2]='<a href="massmail.php">Mass Mail Clients</a>'
menu2[3]='<a href="clientshostinglist.php">List All Products/Services</a>'
menu2[4]='<a href="clientshostinglist.php?type=hostingaccount">List Hosting Accounts</a>'
menu2[5]='<a href="clientshostinglist.php?type=reselleraccount">List Reseller Accounts</a>'
menu2[6]='<a href="clientshostinglist.php?type=server">List Server Accounts</a>'
menu2[7]='<a href="clientshostinglist.php?type=other">List Other Services</a>'
menu2[8]='<a href="clientsaddonslist.php">List Account Addons</a>'
menu2[9]='<a href="clientsdomainlist.php">List Domains</a>'
menu2[10]='<a href="cancelrequests.php">Cancellation Requests</a>'
menu2[11]='<a href="affiliates.php">Manage Affiliates</a>'

var menu3=new Array()
menu3[0]='<a href="orders.php">List All Orders</a>'
menu3[1]='<a href="orders.php?status=Pending">List Pending Orders</a>'
menu3[2]='<a href="orders.php?status=Active">List Active Orders</a>'
menu3[3]='<a href="orders.php?status=Fraud">List Fraud Orders</a>'
menu3[4]='<a href="orders.php?status=Cancelled">List Cancelled Orders</a>'
menu3[5]='<a href="ordersadd.php">Place New Order</a>'

var menu4=new Array()
menu4[0]='<a href="transactions.php">View Transaction List</a>'
menu4[1]='<a href="offlineccprocessing.php">Offline CC Processing</a>'
menu4[2]='<a href="gatewaylog.php">View Gateway Log</a>'
menu4[3]='<a href="invoices.php">List All Invoices</a>'
menu4[4]='<a href="invoices.php?status=Unpaid"> - Unpaid Invoices</a>'
menu4[5]='<a href="invoices.php?status=Paid"> - Paid Invoices</a>'
menu4[6]='<a href="invoices.php?status=Cancelled"> - Cancelled Invoices</a>'
menu4[7]='<a href="billableitems.php">List All Billable Items</a>'
menu4[8]='<a href="billableitems.php?status=Uninvoiced"> - Uninvoiced Items</a>'
menu4[9]='<a href="billableitems.php?status=Recurring"> - Recurring Items</a>'
menu4[10]='<a href="billableitems.php?action=manage"> - Add New</a>'
menu4[11]='<a href="quotes.php">List All Quotes</a>'
menu4[12]='<a href="quotes.php?validity=Valid"> - Valid Quotes</a>'
menu4[13]='<a href="quotes.php?validity=Expired"> - Expired Quotes</a>'
menu4[14]='<a href="quotes.php?action=manage"> - Create New</a>'

var menu5=new Array()
menu5[0]='<a href="supportannouncements.php">Announcements</a>'
menu5[1]='<a href="supportdownloads.php">Downloads</a>'
menu5[2]='<a href="supportkb.php">Knowledgebase</a>'
menu5[3]='<a href="supporttickets.php">Support Tickets</a>'
menu5[4]='<a href="supporttickets.php?action=open">Open New Ticket</a>'
menu5[5]='<a href="supportticketpredefinedreplies.php">Predefined Replies</a>'
menu5[6]='<a href="supporttickets.php?view=flagged"> - My Flagged Tickets</a>'
menu5[7]='<a href="supporttickets.php?view=active"> - All Active Tickets</a>'
menu5[8]='<a href="supporttickets.php?view=Open"> - Open</a>'
menu5[9]='<a href="supporttickets.php?view=Answered"> - Answered</a>'
menu5[10]='<a href="supporttickets.php?view=Customer-Reply"> - Customer-Reply</a>'
menu5[11]='<a href="supporttickets.php?view=On Hold"> - On Hold</a>'
menu5[12]='<a href="supporttickets.php?view=In Progress"> - In Progress</a>'
menu5[13]='<a href="supporttickets.php?view=Closed"> - Closed</a>'
menu5[14]='<a href="networkissues.php">Network Issues</a>'
menu5[15]='<a href="networkissues.php"> - Open</a>'
menu5[16]='<a href="networkissues.php?view=scheduled"> - Scheduled</a>'
menu5[17]='<a href="networkissues.php?view=resolved"> - Resolved</a>'
menu5[18]='<a href="networkissues.php?action=manage"> - Add New</a>'

var menu6=new Array()
menu6[0]='<a href="reports.php?report=orders">Monthly Signups</a>'
menu6[1]='<a href="reports.php?report=productssales">Products Sales Sum.</a>'
menu6[2]='<a href="reports.php?report=recurringincomesummary">Recurring Income Sum.</a>'
menu6[3]='<a href="reports.php?report=serverrevenue">Server Revenue Breakd.</a>'
menu6[4]='<a href="reports.php?report=supporttickets">Support Tickets Sum.</a>'
menu6[5]='<a href="reports.php?report=promotionssummary">Promotions Summary</a>'
menu6[6]='<a href="reports.php?report=usagesummary">Disk Space & BW Usage</a>'
menu6[7]='<a href="reports.php?report=dailyperformance">Daily Performance</a>'
menu6[8]='<a href="reports.php?report=top10clientsinvoices">Top 10 Clients by Income</a>'

var menu7=new Array()
menu7[0]='<a href="addonmodules.php">Addon Modules</a>'
menu7[1]='<a href="utilitieslinktracking.php">Link Tracking</a>'
menu7[2]='<a href="browser.php">Browser</a>'
menu7[3]='<a href="calendar.php">Calendar</a>'
menu7[4]='<a href="todolist.php">To-Do List</a>'
menu7[5]='<a href="whois.php">WHOIS Lookup</a>'
menu7[6]='<a href="utilitiesresolvercheck.php">Domain Resolver</a>'
menu7[7]='<a href="systemintegrationcode.php">Integration Code</a>'
menu7[8]='<a href="whmimport.php">cPanel/WHM Import</a>'
menu7[9]='<a href="systemdatabase.php">Database Status</a>'
menu7[10]='<a href="systemcleanup.php">System Cleanup</a>'
menu7[11]='<a href="systemphpinfo.php">PHP Info</a>'
menu7[12]='<a href="systemactivitylog.php">Activity Log</a>'
menu7[13]='<a href="systemadminlog.php">Admin Log</a>'
menu7[14]='<a href="systememaillog.php">Email Message Log</a>'
menu7[15]='<a href="systemmailimportlog.php">Ticket Mail Import Log</a>'
menu7[16]='<a href="systemwhoislog.php">WHOIS Lookup Log</a>'

var menu8=new Array()
menu8[0]='<a href="configgeneral.php">General Settings</a>'
menu8[1]='<a href="configauto.php">Automation Settings</a>'
menu8[2]='<a href="configemailtemplates.php">Email Templates</a>'
menu8[3]='<a href="configfraud.php">Fraud Protection</a>'
menu8[4]='<a href="configclientgroups.php">Client Groups</a>'
menu8[5]='<a href="configcustomfields.php">Custom Client Fields</a>'
menu8[6]='<a href="configadmins.php">Administrators</a>'
menu8[7]='<a href="configadminroles.php">Administrator Roles</a>'
menu8[8]='<a href="configcurrencies.php">Currencies</a>'
menu8[9]='<a href="configgateways.php">Payment Gateways</a>'
menu8[10]='<a href="configtax.php">Tax Rules</a>'
menu8[11]='<a href="configpromotions.php">Promotions</a>'
menu8[12]='<a href="configproducts.php">Products/Services</a>'
menu8[13]='<a href="configproductoptions.php">Configurable Options</a>'
menu8[14]='<a href="configaddons.php">Product Addons</a>'
menu8[15]='<a href="configdomains.php">Domain Pricing</a>'
menu8[16]='<a href="configregistrars.php">Domain Registrars</a>'
menu8[17]='<a href="configservers.php">Servers</a>'
menu8[18]='<a href="configticketdepartments.php">Support Departments</a>'
menu8[19]='<a href="configticketstatuses.php">Ticket Statuses</a>'
menu8[20]='<a href="configticketescalations.php">Escalation Rules</a>'
menu8[21]='<a href="configticketspamcontrol.php">Spam Control</a>'
menu8[22]='<a href="configsecurityqs.php">Security Questions</a>'
menu8[23]='<a href="configbannedips.php">Banned IPs</a>'
menu8[24]='<a href="configbannedemails.php">Banned Emails</a>'
menu8[25]='<a href="configbackups.php">Database Backups</a>'

var menu9=new Array()
menu9[0]='<a href="http://wiki.whmcs.com/" target="_blank">Documentation</a>'
menu9[1]='<a href="systemlicense.php">License Information</a>'
menu9[2]='<a href="licenseerror.php?licenseerror=change">Change License Key</a>'
menu9[3]='<a href="systemupdates.php">Check for Updates</a>'
menu9[4]='<a href="systemsupportrequest.php">Support Request</a>'
menu9[5]='<a href="http://forum.whmcs.com/" target="_blank">Community Forums</a>'


var menuwidth='170px' //default menu width
var menubgcolor='#E7EDF4'  //menu bgcolor
var disappeardelay=250  //menu disappear speed onMouseout (in miliseconds)
var hidemenu_onclick="yes" //hide menu when user clicks within menu?

var ie4=document.all
var ns6=document.getElementById&&!document.all

if (ie4||ns6)
document.write('<div id="dropmenudiv" style="visibility:hidden;width:'+menuwidth+';background-color:'+menubgcolor+'" onMouseover="clearhidemenu()" onMouseout="dynamichide(event)"></div>')

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}


function showhide(obj, e, visible, hidden, menuwidth){
if (ie4||ns6)
dropmenuobj.style.left=dropmenuobj.style.top="-500px"
if (menuwidth!=""){
dropmenuobj.widthobj=dropmenuobj.style
dropmenuobj.widthobj.width=menuwidth
}
if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
obj.visibility=visible
else if (e.type=="click")
obj.visibility=hidden
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=0
if (whichedge=="rightedge"){
var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
}
else{
var topedge=ie4 && !window.opera? iecompattest().scrollTop : window.pageYOffset
var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure){ //move up?
edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
if ((dropmenuobj.y-topedge)<dropmenuobj.contentmeasure) //up no good either?
edgeoffset=dropmenuobj.y+obj.offsetHeight-topedge
}
}
return edgeoffset
}

function populatemenu(what){
if (ie4||ns6)
dropmenuobj.innerHTML=what.join("")
}


function dropdownmenu(obj, e, menucontents, menuwidth){
if (window.event) event.cancelBubble=true
else if (e.stopPropagation) e.stopPropagation()
clearhidemenu()
dropmenuobj=document.getElementById? document.getElementById("dropmenudiv") : dropmenudiv
populatemenu(menucontents)

if (ie4||ns6){
showhide(dropmenuobj.style, e, "visible", "hidden", menuwidth)

dropmenuobj.x=getposOffset(obj, "left")
dropmenuobj.y=getposOffset(obj, "top")
dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px"
}

return clickreturnvalue()
}

function clickreturnvalue(){
if (ie4||ns6) return false
else return true
}

function contains_ns6(a, b) {
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}

function dynamichide(e){
if (ie4&&!dropmenuobj.contains(e.toElement))
delayhidemenu()
else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
delayhidemenu()
}

function hidemenu(e){
if (typeof dropmenuobj!="undefined"){
if (ie4||ns6)
dropmenuobj.style.visibility="hidden"
}
}

function delayhidemenu(){
if (ie4||ns6)
delayhide=setTimeout("hidemenu()",disappeardelay)
}

function clearhidemenu(){
if (typeof delayhide!="undefined")
clearTimeout(delayhide)
}

if (hidemenu_onclick=="yes")
document.onclick=hidemenu