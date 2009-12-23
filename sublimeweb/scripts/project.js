$(document).ready(function(){
	$("#toolbox").hide();  
	$("#toolbox-tab a").click(function(){
		$("#toolbox").slideToggle("slow")
	}).toggle(
		function(){
			$("#theArrow").attr("src","img/arrow-up.gif")
		},
		function(){
			$("#theArrow").attr("src","img/arrow-down.gif")
		}
	);
	
	// edit in place hover
	$(".editable")
	.hover(function(){
		$(this).addClass("editableOver");
	},function(){
		$(this).removeClass("editableOver");
	});
	
	// autocomplete
	$("#search-query").autocomplete("search.php", {
		delay: 250
	});
	
	/* returns a selection of HTML DIVs to be inserted in to 
	the #spyContainer in a spy-style */
	$('#activity').spy({'ajax': 'activity.php', fadeLast: "2", limit: "7",timeout: 20000}); 
	
	// snapshot popups stuff
	$("#map li:gt(0)").hide();
	nextSnapshot();
	
	// make rows clickable
	$("tr a").each(function(){
		//console.debug(this);
		var theLink = $(this).attr("href");
		$(this).parents("tr").click(function(){
			window.location = theLink;
		});
	});
	
	$("div.title a").livequery(function(){
		//console.debug(this);
		var theLink = $(this).attr("href");
		$(this).parents("div.entry").click(function(){
			window.location = theLink;
		});
	});
});

// function for dynamically updating the "ago" in the activity column
function figureTime(){
	$("#activity div[@class*=stamp_]").each(function(){
		var epoch = new Date(1970, 0, 1);
		var curClass = $(this).attr("class");
		//console.debug(curClass);
		regex = "[0-9]+";
		var curNum = curClass.match(regex);
		//console.debug("curNum="+curNum);
		var now = new Date();
		//foo = (now.getTime()-now.getMilliseconds())/1000;
		foo = Math.floor((now - epoch) / 1000);
		//console.debug("foo="+foo);
		diff = foo - curNum;
		//console.debug("diff="+diff);
		if(diff < 30) msg = "< 30 sec ago";
		if(diff > 30) msg = "< 1 min ago";
		if(diff > 60) msg = "1 min ago";
		if(diff > 120) msg = "2 min ago";
		if(diff > 180) msg = "3 min ago";
		//console.debug(msg);
		$(this).html(msg);
	});
}

// edit in place for bio
function editNote(foo){
	$(foo).hide();
	curClass = $(foo).attr("class");
	curID = $(foo).attr("id");
	saveID = curID.match(/noteSnippet(\d*)/)[1];
	curVal = $("#noteFull"+saveID).html();
	$(foo).after("<span class=\"newNote "+curClass+"\"><textarea style='width:99%'>"+curVal+"</textarea><br /><input type=\"submit\" value=\"Save\" onclick=\"saveNote(this,'"+curID+"');\" /> <input type=\"submit\" value=\"Cancel\" onclick=\"$('#"+curID+"').show(); $(this).parents('span').remove();\" /></span>");
}

$("<img>").attr("src", "img/spinner.gif");
// save off the edit in place
function saveNote(foo,theElem){
	noteID = theElem.match(/noteSnippet(\d*)/)[1];
	//console.debug("###"+theElem);
	theElem = $("#"+theElem);
	theVal = $(foo).parents("span").children("textarea").val();
	//console.debug($(foo).parents("span"));
	curClass = $(theElem).attr("class");
	//console.debug(curClass);
	saveID = curClass.match(/saveid(\d*)/)[1];

	// submit ajax
	//console.debug("savedJobID: "+saveID+", newNote: "+theVal);
	//saveInfo(theElem,theVal,"saveJobNote");
	$(theElem).show();
	$(foo).parents('span').remove();
	$("#noteFull"+noteID).html(theVal);
	$(theElem).html('<img src="img/spinner.gif" alt="" /> saving');
	$(".editableOver").removeClass("editableOver");
	$.post(
		'ajaxStuff.php',
		{ theType: 'saveJobNote', savedJobID: saveID, newNote: theVal },
		function(data){
			$(theElem).html(data+'  (<a href="#" onclick="return false">Edit</a>)');
		}
	);
}

// logic for the snapshot popups

function nextSnapshot(){
	var curID = $("#map li:visible").attr("id");
	regex = "[0-9]+";
	var curNum = curID.match(regex);
	var numLIs = $("#map li").length;
	if(curNum >= numLIs) curNum = 0;
	curNum++;
	$("#"+curID).hide("slow");
	
	var randomnumber=Math.floor(Math.random()*100);
	
	$("#map"+curNum).find("span").html(randomnumber);
	$("#map"+curNum).show("slow");
	
	
	setTimeout(nextSnapshot,5000);
}
//

/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * http://www.stilbuero.de/2006/09/17/cookie-plugin-for-jquery/
 */
 
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}
//jQuery.cookie=function(name,value,options){if(typeof value!='undefined'){options=options||{};if(value===null){value='';options.expires=-1}var expires='';if(options.expires&&(typeof options.expires=='number'||options.expires.toUTCString)){var date;if(typeof options.expires=='number'){date=new Date();date.setTime(date.getTime()+(options.expires*24*60*60*1000))}else{date=options.expires}expires='; expires='+date.toUTCString()}var path=options.path?'; path='+options.path:'';var domain=options.domain?'; domain='+options.domain:'';var secure=options.secure?'; secure':'';document.cookie=[name,'=',encodeURIComponent(value),expires,path,domain,secure].join('')}else{var cookieValue=null;if(document.cookie&&document.cookie!=''){var cookies=document.cookie.split(';');for(var i=0;i<cookies.length;i++){var cookie=jQuery.trim(cookies[i]);if(cookie.substring(0,name.length+1)==(name+'=')){cookieValue=decodeURIComponent(cookie.substring(name.length+1));break}}}return cookieValue}};