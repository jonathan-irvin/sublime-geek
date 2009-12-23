/*<script>*/
/*
AJAXed Wordpress
(C) Anthologyoi.com
*/

var aWP = function (){

		var _d=[]; /*_d is an object with an index of i that holds currently active "request" element information*/
		var _p=[]; /*_p is an object with an index of i that holds information that must exist between requests.*/
		var _a=[]; /*_a is an object that can be used throughout this function.*/
		var i; /*Currently processing element id*/
		var mrc = '';
		var force = 0;
		var com_hide = '';
		
	var $ = function(id) {
		return document.getElementById(id);
	};

	var pos = function(ele) {
		var e = $(ele);
		var etop = 0;
			if(e && e.style.display != 'none'){
				if (e.offsetParent) {
					etop = e.offsetTop
					while (e = e.offsetParent) {
						etop += e.offsetTop
					}
				}
			}
		return etop;

	};

	var get_current_scroll = function(){
		var cur_scroll = 0;

		if(document.body && document.body.scrollTop){

			cur_scroll = document.body.scrollTop;

		}else if(document.documentElement && document.documentElement.scrollTop){

			cur_scroll = document.documentElement.scrollTop;
		}

		return cur_scroll;
	};

	var get_form_data = function(i){
		var base = $(i).getElementsByTagName('input');
		var postobj = {};
		var x = base.length;
		var value = '';
		var name = '';
		var radios=[];

		for(y=0; y<x; y++){
			if(base[y].type != 'button'){
				if(base[y].type == 'text' || base[y].type == 'hidden' || base[y].type == 'password' || base[y].type == 'select'){
						value =  base[y].value;
						name = base[y].name;
				}else if(base[y].type == 'checkbox' || base[y].type == 'radio'){
					if (base[y].checked) {
						value =  base[y].value;
						name = base[y].name;
					}
				}
				if(name && value){
					postobj[name] = value;
				}
				name = value= null;
			}
		}

		base = $(i).getElementsByTagName('textarea');
		x = base.length;

		for(y=0; y<x; y++){
			postobj[base[y].name]= base[y].value;
		}
		return postobj;
	};

	var get_throbber = function (){

			var img = document.createElement('img');
			img.src="http://metastreamr.com/wp-content/plugins/ajaxd-wordpress/images/throbberradar.gif";
			img.alt="Please hold now loading";
			img.id = "throbber"+i;
			img.className = "throbber";
			if(_d[i].submit == 'TRUE'){

				try{$(_d[i].type+'_'+_d[i].main).parentNode.appendChild(img);}catch(e){}

			}else if(_d[i].this_page && _d[i].pagenum){

				try{$('awppage_'+_d[i].this_page+'_'+_d[i].main+'_link').appendChild(img);}catch(e){}

			}else if(_d[i].link_num){

				try{$('awp'+_d[i].type+'_link'+_d[i].link_num+'_'+_d[i].main).appendChild(img);}catch(e){}

			}else if(arguments[0] && $(arguments[0]) && arguments[1]){
				img.className =arguments[1];
				try{$(arguments[0]).parentNode.insertBefore(img, $(arguments[0]));}catch(e){}
			}else{

				try{$('awp'+_d[i].type+'_link_'+_d[i].main).appendChild(img);}catch(e){}

			}
	};

	var do_JS = function(e){
		var Reg = '(?:<script.*?>)((\n|.)*?)(?:</script>)';
		var match    = new RegExp(Reg, 'img');
		var scripts  = e.innerHTML.match(match);
		var doc = document.write;
		document.write = function(p){ e.innerHTML = e.innerHTML.replace(scripts[s],p)};
		if(scripts) {
			for(var s = 0; s < scripts.length; s++) {
				var js = '';
				var match = new RegExp(Reg, 'im');
				js = scripts[s].match(match)[1];
				js = js.replace('<!--','');
				js = js.replace('-->','');
				eval('try{'+js+'}catch(e){}');
			}
		}
		document.write = doc;
	};

	var link_text = function(id,newtext,toggle_text,style,style_toggle){

		if($(id)){
			var l = $(id);
			if(toggle_text){
				if(l.firstChild.data == toggle_text){
					l.firstChild.data = newtext;
					if(style) {l.className = style;}
				}else{
					l.firstChild.data = toggle_text;
					if(style_toggle) {l.className = style_toggle;}
				}
			}else{
				l.firstChild.data = newtext;
					if(style) {l.className = style;}
			}
		}
	};


	var move = function(id,moveto,mode){
		if($(id) && $(moveto) ){
			if(mode == 'sib'){
				$(id).parentNode.insertBefore($(moveto), $(id).nextSibling);
			}else{
				$(id).parentNode.insertBefore($(moveto),$(id));
			}
		}
	};
	return{

		addEvent: function(evn,fn,base){

			if (base.addEventListener){
				base.addEventListener(evn, fn, false);
				return true;
			} else if (base.attachEvent){
				var r = base.attachEvent("on"+evn, fn);
				return r;
			} else {
				return false;
			}
		},


		doit : function() {
			aWP.start.main(arguments);

		},

		update: function (){
			var e = $(i);
			_d[i].response = '';

			var nodes = _d[i].result.getElementsByTagName("var");
			if(nodes.length > 0){
				for (j=0; j<nodes.length; j++) {
					if(nodes.item(j).getAttribute('name') && nodes.item(j).firstChild.data){
						_d[i][nodes.item(j).getAttribute('name')] = nodes.item(j).firstChild.data;
					}
				}
			}

			nodes = _d[i].result.getElementsByTagName("response");
			if(nodes.length > 0){
				for (j=0; j<nodes.length; j++) {
					if(nodes.item(j).getAttribute('name')){
						_d[i][nodes.item(j).getAttribute('name')] = nodes.item(j).firstChild.data;
					}else{
						_d[i].response += nodes.item(j).firstChild.data
					}
				}
			}

			nodes = _d[i].result.getElementsByTagName("action");
			if(nodes.length > 0){
				for (j=0; j<nodes.length; j++) {
					if(nodes.item(j).firstChild.data){
						if(nodes.item(j).getAttribute('name')){
							_d[i][nodes.item(j).getAttribute('name')] = nodes.item(j).firstChild.data;
						}else{
							eval(nodes.item(j).firstChild.data);
						}
					}
				}
			}

			if(!_d[i].update_next){
				e.innerHTML = _d[i].response;
				do_JS(e);
				aWP.toggle.main();
			}else{
				eval(_d[i].update_next+'();');
			}
		},

		start: {

			main: function(){

				var args = arguments[0];
				var temp = args[0];
				var postobj = {};

				if(!temp.i){

					if((!temp.id && !temp.primary) || !temp.type){
						return false;
					}else{
						if(!temp.primary){
							temp.primary = 'id';
						}
					}

					i = 'awp'+temp.type+'_'+temp[temp.primary];

				}else{

					i = temp.i;
					temp.i = null;

				}

				if(!$(i)){
					return false;
				}else{
					e = $(i);
				}

				if(!_p[i]){
					_p[i] = [];
				}

				_d[i] = [];
				_d[i] = temp;
				_d[i].main = _d[i][_d[i].primary];
				temp = null;

				if(_d[i].submit == 'TRUE'){
					if($(_d[i].type+_d[i].main)){
						try{$(_d[i].type+_d[i].main).disabled = true;} catch(e){}
					}
					postobj = get_form_data(i);
					_d[i].force = 1;
					postobj['id'] = _d[i].id;
				}else{
					postobj['id'] = _d[i].id;
					postobj.main = _d[i].main;
				}

				postobj['type'] =_d[i].type;

				if(aWP.start[_d[i].type])
					postobj = aWP.start[_d[i].type](postobj);

				if(!postobj)
					return false;

				var n=0;

				if(e.innerHTML)
					n = e.innerHTML.length;

				if (n==0 || _d[i].force == 1){

					
				get_throbber();
				if(!_d[i].jQuery){
					aWP.jQuery = function(r){_d[i].result = r;  if(_d[i].result) {aWP.update();}}
				}
				jQuery.ajax({
				type: 'POST',
				url: 'http://metastreamr.com/wp-content/plugins/ajaxd-wordpress/aWP-response.php',
				data:  postobj,
				success:aWP.jQuery,
				async:false
				});

			
				}else{

					return aWP.toggle.main();

				}


			},

						nav: function(postobj){
				if(document.getElementById('awp_loop')){
					aWP.foward = 1;
					if(_d[i].ths && _d[i].nav != 'url'){
						ajax_nav.addHistory(_d[i].ths.href);
					}
					aWP.foward = 0;

					postobj['nav'] = _d[i].nav;
					if(_d[i].nav != 'single' && _d[i].nav != 'url'){
						postobj['pagenum'] = _d[i].pagenum;
					}

					if(_d[i].nav == 'url'){
						var base_url ='http://metastreamr.com';
						if(_d[i].url.slice(0, base_url.length) != base_url)
							return false;

						postobj['url'] = _d[i].url;
						postobj['id'] = 0;
					}

					if(_d[i].nav == 'cat'){
						postobj['cat_id'] = _d[i].cat_id;
						postobj['id'] = 0;
					}

					get_throbber('awp_loop','bigthrobber');
					aWP.toggle.smooth_scroll(i,-100);
				}else{

					if(_d[i].ths)
						window.location(_d[i].ths.href);

					return true;

				}
			return postobj;
			},

			commentform: function(postobj){

				if(isNaN(_p[i].prev_link)){
					_p[i].prev_link = 1;
					_d[i].faked = 1;
				}

				if(isNaN(_d[i].com_parent)){
					_d[i].com_parent = 0;
				}

			return postobj;
			},

			comments: function(postobj){

				if(_d[i].show){
					_p[i].show = _d[i].show;
				}

				if(_d[i].hide){
					_p[i].hide = _d[i].hide;
				}

				return postobj;
			},
		previewcomment: function(postobj){

				if($('comment_'+_d[i].id)){
					postobj['comment'] = $('comment_'+_d[i].id).value;
				}else{
					base = document.getElementById('awpsubmit_commentform_'+id).getElementsByTagName('textarea');
					x = base.length;
					for(j=0; j<x; j++){
						if(base[j].name = 'comment'){
							postobj['comment'] = base[j].value;
							j = x;
						}
					}
				}
			return postobj;
			},
				dummy: function(){}
		},

		toggle: {
			main: function (){
				var e = $(i);
				var style = $(i).style.display; /*Otherwise we need to get it several times.*/
				if(style != 'none' && style != 'block'){ /*If the element is displayed, but not explicitly set.*/
					$(i).style.display = 'block'; /*Explicitly set it.*/
				}
				var winHeight = window.innerHeight;
				if(!winHeight){
					//yet another IE fix
					winHeight = document.documentElement.clientHeight;
				}

				if(document.getElementById('throbber'+i)){
					setTimeout("try{document.getElementById('throbber"+i+"').parentNode.removeChild(document.getElementById('throbber"+i+"'));}catch(e){}",500);
					setTimeout("try{document.getElementById('throbber"+i+"').parentNode.removeChild(document.getElementById('throbber"+i+"'));}catch(e){}",500);
				}

				if(aWP.toggle[_d[i].type]){
					aWP.toggle[_d[i].type](e,style);
				}else{
					var toggle = 0;
					if(!_d[i].force){

							link_text('awp'+_d[i].type+'_link'+'_'+_d[i].main, _p[i].show, _p[i].hide,'awp' + _d[i].type + '_link','awp' + _d[i].type + '_link_hide');

						toggle = 1;
					}

					if( $(i).style.display != 'block' || toggle){
						aWP.toggle.pick_switch();
					}

				}

				if(_d[i].focus){
					setTimeout("aWP.toggle.smooth_scroll('"+_d[i].focus+"',0);",100);
				}else if(pos(i) > 0 && !_d[i].force && !_d[i].no_jump){
					aWP.toggle.smooth_scroll(i,-1*(winHeight/4));
				}

			},

			commentform: function(){
				var comparent;
				var moveto;
				var sib;
				var style = arguments[1];
	
					if(!_p[i].nomove && style != 'none' && !_d[i].nomove){
						if(!$('awpcommentform_anchor_'+_d[i].main)){
							var div = document.createElement('div');
							div.id = 'awpcommentform_anchor_'+_d[i].main;
							div.style.display = 'none';
							try{$('awpcommentform_'+_d[i].main).parentNode.insertBefore(div, $('awpcommentform_'+_d[i].main).nextSibling);}catch(e){}
						}
					}else{
						if(_d[i].nomove)
							_p[i].nomove = 1;
					}

				if(_p[i].prev_link != _d[i].link_num || _d[i].faked ){
					var will_move = 1;
					 moveto = 'awpcommentform_link'+_d[i].link_num+'_'+_d[i].main;
					 sib = 'sib'
				}
				if((style == 'none' || _d[i].quickclose == 1 || _p[i].nomove) && !will_move){
					var will_hide = 1;
				}
				if(_p[i].prev_link == _d[i].link_num && !_p[i].nomove && !will_move){
					var will_remove = 1;
				}

				link_text('awpcommentform_link'+_d[i].link_num+'_'+_d[i].main,_d[i].show,_d[i].hide);

				if(will_remove){
					_d[i].no_jump = 1;
					_d[i].link_num =0;
					will_move = 1
					moveto = 'awpcommentform_anchor_'+_d[i].main
					sib = '';

	
				}

				if(will_move == 1){
					var pos1 = pos(i);

						if(_a['beforemove'])
							_a['beforemove']();

						move(moveto,i,sib);

						if(_a['aftermove'])
							_a['aftermove']();

				

					var pos2 = pos(i);

					if(pos1 == pos2)
						will_hide = 1;
				}

				if(_p[i].last_show && (pos1 != pos2  || _d[i].quickclose == 1)){
					link_text('awpcommentform_link'+_p[i].prev_link+'_'+_d[i].main,_p[i].last_show);
				}

				if(will_hide == 1){
					aWP.toggle.pick_switch();
					_d[i].no_jump = 1;
				}



				try{$('submit_commentform_'+_d[i].main).disabled = false;} catch(e){}

				_p[i].last_show = _d[i].show;
				_p[i].prev_link = _d[i].link_num;
			},
	//<script>
			previewcomment: function(){
				$(i).style.height = $('awpsubmit_commentform_'+_d[i].id).offsetHeight+'px';
				$(i).style.top = pos('awpsubmit_commentform_'+_d[i].id)+'px';
				$(i).style.width = $('awpsubmit_commentform_'+_d[i].id).offsetWidth+'px';
				$(i).style.display = 'none';
				$(i).style.overflow = 'auto';
				aWP.toggle.pick_switch();
				$(i).style.position = 'absolute';

			},
	
			pick_switch:function(){

						if($(i).style.display === 'block'){
			jQuery('#'+i).slideUp("Fast");
		}else{
			jQuery('#'+i).slideDown("Fast");
		}

	
	
			},

			smooth_scroll: function(scrolluntil,extra){
				var end = pos(scrolluntil) + extra;
				var cur_scroll = get_current_scroll();
				var step = 50;
				var scrollto = 0;
				var val = cur_scroll - end;

				if(Math.abs(val) > 50 && _p[i].scrollval != val){
					if(Math.abs(val) > 5000){step = 750;} else
					if(Math.abs(val) > 2500){step = 500;} else
					if(Math.abs(val) > 1000){step = 200;} else
					{ step = 50; }
					if (val > 0){
						scrollto =  cur_scroll - step;
					}else if (val < 0){
						scrollto =  cur_scroll + step;
					}
					_p[i].scrollval = val;
					try{window.parent.scrollTo(0,scrollto);}catch(e){}
					setTimeout("aWP.toggle.smooth_scroll('"+scrolluntil+"',"+extra+")",100);
				}

			}
		},

		
		complete: function (){

			aWP.finish.main(_d[i].type);

		},

		finish: {
			main: function(){

				try{$('throbber'+i).parentNode.removeChild($('throbber'+i));}catch(e){}

				if(aWP.finish[_d[i].type])
					aWP.finish[_d[i].type]();

			},

 //<script>
			submit_commentform : function(){

				$('comment_result_'+_d[i].main).innerHTML = _d[i].response;

				if(!_d[i].error){
					if(_d[i].show){
						var num = 1;
						if(_p[i].prev_link){
							num = _p[i].prev_link;
						}

						link_text('awpcommentform_link'+num+'_'+_d[i]['id'],_d[i].show)
					}
					/*If the comment form is inside of the comment div, reloading will destroy it, so we move it.*/
					var moveto;

					if($('awpcommentform_anchor_'+_d[i].main)){
						moveto = 'awpcommentform_anchor_'+_d[i].main;
					}else{
						moveto ='awpcomments_'+_d[i].main;
						$('awpcommentform_'+_d[i].main).style.display='none';
					}

					if(moveto){
						if(_a['beforemove'])
							_a['beforemove']();
						try{move( moveto,'awpcommentform_'+_d[i].main);}catch(e){}
						if(_a['aftermove'])
							_a['aftermove']();
					}

					try{$('comment_'+_d[i][_d[i].primary]).value = '';}catch(e){}
					try{$(_d[i].type+'_'+_d[i][_d[i].primary]).disabled = false;} catch(e){}

					if($('awpcomments_none_'+_d[i].main)){
							if($('awpcomments_none_'+_d[i].main).style.display != 'none'){
								$('awpcomments_none_'+_d[i].main).style.display = 'none';
								$('awpcomments_link_'+_d[i].main).style.display = 'inline';
							}
					}

					var temp = 0
					if($('awpcomments_'+_d[i].id).innerHTML.length > 0){
						temp = 1;
					}

					try{
						if(_p['awpcomments_'+_d[i].id] && _p['awpcomments_'+_d[i].id].hide){
							link_text('awpcomments_link_'+_d[i].id, _p['awpcomments_'+_d[i].id].hide);
						}
					}catch(e){}
						aWP.doit({'id': _d[i].id, 'type': 'comments', 'force': temp, 'focus': 'comment-'+_d[i].mrc});
				}
			},

			dummy: function(){}
		}
	}
}();



/* start AJAX nav UnFocus */
 var historyKeeper; 
 var unFocus;/* unFocus.History, version2.0 (Beta 2) (2007/09/10)
Copyright: 2005-2007, Kevin Newman (http://www.unfocus.com/Projects/HistoryKeeper/)
License: http://www.gnu.org/licenses/lgpl.html */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('8 o={};o.Q=2(){h.j={};B(8 i=0;i<18.l;i++){h.j[18[i]]=[]}};o.Q.W={12:2(a,b){B(8 i=0;i<h.j[a].l;i++)4(h.j[a][i]==b)7;h.j[a].1Z(b)},1V:2(a,b){B(8 i=0;i<h.j[a].l;i++){4(h.j[a][i]==b){h.j.1S(i,1);7}}},p:2(a,b){B(8 i=0;i<h.j[a].l;i++)h.j[a][i](b)}};o.14=(2(){2 C(){8 c=h,E=1E,v,3;8 d=2(){7 1p.1k.23(1)};3=d();8 e=2(a){z.1p.1k=a};2 1f(){8 a=d();4(3!=a){3=a;c.p("n",a)}}4(O)v=O(1f,E);2 r(a){4(!1c(a)){8 b;4(/1b/.19(A.17)&&!z.16)b=6.w(\'<a G="\'+a+\'">\'+a+"</a>");u b=6.w("a");b.t("G",a);Z(b.D){V="U";1D="1A";1d=s()+"R";1v=1t()+"R"}6.k.L(b,6.k.P)}}2 1c(a){4(6.24(a).l>0)7 q}4(1i 1h.1g=="22"){2 s(){7 1h.1g}}u 4(6.N&&6.N.M){2 s(){7 6.N.M}}u 4(6.k){2 s(){7 6.k.M}}21(20(s).1X().1e(/1W/g,"1U").1e(/Y/g,"X"));c.1T=2(){7 3};2 9(a){4(3!=a){r(a);3=a;e(a);c.p("n",a)}7 q}c.9=2(a){r(3);c.9=9;7 c.9(a)};4(/1a\\/\\d+/.19(A.1n)&&A.1n.1o(/1a\\/(\\d+)/)[1]<1R){8 f=H.l,x={},m,y=15;2 S(){m=6.w("1O");m.13="1N";m.1M="1L";6.k.L(m,6.k.P)}e=2(a){x[f]=a;m.1K="#"+d();m.1J()};d=2(){7 x[f]};x[f]=3;2 T(a){4(3!=a){r(a);3=a;f=H.l+1;y=q;e(a);c.p("n",a);y=15}7 q}c.9=2(a){r(3);S();c.9=T;7 c.9(a)};2 10(){4(!y){8 a=H.l;4(a!=f){f=a;8 b=d();4(3!=b){3=b;c.p("n",b)}}}};1I(v);v=O(10,E)}u 4(1i 1H!="1G"&&z.1F&&!z.16&&A.17.1o(/1b (\\d\\.\\d)/)[1]>=5.5){8 g,F;2 11(){8 a="1C";g=6.w("1B");g.t("G",a);g.t("13",a);g.t("1P",\'1Q:;\');g.D.V="U";g.D.1d="-1z";6.k.L(g,6.k.P);F=1y[a];J(3,q)}2 J(a){Z(F.6){1x("1w/I");1u("<I><1q></1q><k 1s",\'1Y="1r.o.14.K(\\\'\'+a+\'\\\');">\',a+"</k></I>");25()}}2 1m(a){3=a;c.p("n",a)}c.K=2(){c.K=1m};2 1l(a){4(3!=a){3=a;J(a)}7 q};c.9=2(a){11();c.9=1l;7 c.9(a)};c.12("n",2(a){e(a)})}}C.W=1j o.Q("n");7 1j C()})();',62,130,'||function|_currentHash|if||document|return|var|addHistory||||||||this||_listeners|body|length|_form|historyChange|unFocus|notifyListeners|true|_createAnchor|getScrollY|setAttribute|else|_intervalID|createElement|_historyStates|_recentlyAdded|window|navigator|for|Keeper|style|_pollInterval|_historyFrameRef|name|history|html|_createHistoryHTML|_updateFromHistory|insertBefore|scrollTop|documentElement|setInterval|firstChild|EventManager|px|_createSafariSetHashForm|addHistorySafari|absolute|position|prototype|||with|_watchHistoryLength|_createHistoryFrame|addEventListener|id|History|false|opera|userAgent|arguments|test|WebKit|MSIE|_checkAnchorExists|top|replace|_watchHash|pageYOffset|self|typeof|new|hash|addHistoryIE|updateFromHistory|appVersion|match|location|head|parent|onl|getScrollX|write|left|text|open|frames|900px|block|iframe|unFocusHistoryFrame|display|200|print|undefined|ActiveXObject|clearInterval|submit|action|get|method|unFocusHistoryForm|form|src|javascript|420|splice|getCurrent|Left|removeEventListener|Top|toString|oad|push|String|eval|number|substring|getElementsByName|close'.split('|'),0,{}))//<script>
	aWP.addEvent('load',start_awp_nav,window);
	var ajax_nav;
	aWP.foward = 0;
	aWP.started = 0;

	function start_awp_nav(){
		ajax_nav = new awp_nav;

		var parts = location.href.split('#');

		if(!unFocus.History.getCurrent()){
			ajax_nav.addHistory(location.href);
		}else if(parts[1] != parts[0]){
			aWP.doit({'type': 'nav', 'nav': 'url', 'url': unFocus.History.getCurrent(), 'i' : 'awp_loop', 'force' : 1 });
		}

		aWP.started = 1;
	}

	function awp_nav(){
		var stateVar = "nothin'";

		this.addHistory = function(newVal) {
			unFocus.History.addHistory(newVal);
		};

		this.historyListener = function(historyHash) {

			stateVar = historyHash;
			var parts = location.href;
			if(aWP.foward != 1 && historyHash != '' && aWP.started != 0){
				aWP.doit({'type': 'nav', 'nav': 'url', 'url': historyHash, 'i' : 'awp_loop', 'force' : 1 });
			}

		};

		unFocus.History.addEventListener('historyChange', this.historyListener);
		this.historyListener(unFocus.History.getCurrent());
	}


		function add_ajax_form(){
			try{document.getElementById('searchform').onsubmit = function (){ajax_nav.addHistory('http://metastreamr.com?s='+document.getElementById('s').value);  return false;};}catch(e){}
		}
		aWP.addEvent('load',add_ajax_form,window);


/* start quicktags */
/**
 Originally by Alex King
 http://www.alexking.org/
 edit toolbar used without permission
 This file has been edited from its original state
 The original author should not be held responsible for any bugs.
  **/

var aWP_qt = function(){
 var element =[];
	var edButtons = [];
	var edOpenTags = [];
	var suffix = '';

	var $ = function(id) {
		return document.getElementById(id);
	};

	var _$ = function(id) {

		if(!element[id]){
			if(!suffix){
				base = document.getElementById('awpsubmit_commentform_'+id).getElementsByTagName('textarea');
				x = base.length;
				for(i=0; i<x; i++){
					if(base[i].name = 'comment'){
						element[id] = base[i];
						i = x;
					}
				}
			}else{
				element[id] = document.getElementById('comment'+suffix);
			}
		}
		return element[id];
	};


	function edButton(i, display, tagStart, tagEnd, access, open) {
		this.id = i;				// used to name the toolbar button
		this.display = display;		// label on button
		this.tagStart = tagStart; 	// open tag
		this.tagEnd = tagEnd;		// close tag
		this.access = access;		// access key
		this.open = open;			// set to -1 if tag does not need to be closed
	}

	function zeroise(number, threshold) {
		// FIXME: or we could use an implementation of printf in js here
		var str = number.toString();
		if (number < 0) { str = str.substr(1, str.length); }
		while (str.length < threshold) { str = "0" + str; }
		if (number < 0) { str = '-' + str; }
		return str;
	}

	var now = new Date();
	var datetime = now.getUTCFullYear() + '-' +
	zeroise(now.getUTCMonth() + 1, 2) + '-' +
	zeroise(now.getUTCDate(), 2) + 'T' +
	zeroise(now.getUTCHours(), 2) + ':' +
	zeroise(now.getUTCMinutes(), 2) + ':' +
	zeroise(now.getUTCSeconds() ,2) +
	'+00:00';

	edButtons[edButtons.length] = new edButton('ed_strong','b','<strong>','</strong>','b');
	edButtons[edButtons.length] = new edButton('ed_em','i','<em>','</em>','i');
	edButtons[edButtons.length] = new edButton('ed_link','link','','</a>','a'); // special case
	edButtons[edButtons.length] = new edButton('ed_block','b-quote','\n\n<blockquote>','</blockquote>\n\n','q');
	edButtons[edButtons.length] = new edButton('ed_img','img','','','m',-1); // special case
	edButtons[edButtons.length] = new edButton('ed_ul','ul','<ul>\n','</ul>\n\n','u');
	edButtons[edButtons.length] = new edButton('ed_ol','ol','<ol>\n','</ol>\n\n','o');
	edButtons[edButtons.length] = new edButton('ed_li','li','\t<li>','</li>\n','l');
	edButtons[edButtons.length] = new edButton('ed_code','code','<code>','</code>','c');
	edButtons[edButtons.length] = new edButton('ed_quote','Quote','<q>','</q>','');


	function edAddTag(button) {
		if(!edOpenTags[id]){
			edOpenTags[id] = [];}

		if (edButtons[button].tagEnd !== '') {
			edOpenTags[id][edOpenTags[id].length] = button;
			$(edButtons[button].id + '_'+ id).value = '/' + $(edButtons[button].id + '_'+ id).value;
		}
	};

	function edRemoveTag(button) {

		for (i = 0; i < edOpenTags[id].length; i++) {
			if (edOpenTags[id][i]== button) {
				edOpenTags[id].splice(i, 1);
				$(edButtons[button].id + '_'+ id).value = 		$(edButtons[button].id + '_'+ id).value.replace(/\//g, '');
			}
		}
	};

	function edCheckOpenTags(button) {
		if(!edOpenTags[id]){
			edOpenTags[id] = [];}

		var tag = 0;
		for (i = 0; i < edOpenTags[id].length; i++) {
			if (edOpenTags[id][i] == button) {
				tag++;
			}
		}
		if (tag > 0) {
			return true; // tag found
		}
		else {
			return false; // tag not found
		}
	};

		function edInsertContent  (myValue) {
		var myField = _$(id);
			//IE support
			if (document.selection) {
				myField.focus();
				sel = document.selection.createRange();
				sel.text = myValue;
				myField.focus();
			}
			//MOZILLA/NETSCAPE support
			else if (myField.selectionStart || myField.selectionStart == '0') {
				var startPos = myField.selectionStart;
				var endPos = myField.selectionEnd;
				myField.value = myField.value.substring(0, startPos)
						+ myValue
						+ myField.value.substring(endPos, myField.value.length);
				myField.focus();
				myField.selectionStart = startPos + myValue.length;
				myField.selectionEnd = startPos + myValue.length;
			} else {
				myField.value += myValue;
				myField.focus();
			}
		};

	return {
		edCloseAllTags: function (the_id, suf) {
			if( the_id){
				id = the_id;}
		if (suf){
		suffix = suf;}
			if(!edOpenTags[id]){
				edOpenTags[id] = [];}

			var count = edOpenTags[id].length;
			for (o = 0; o < count; o++) {
				aWP_qt.edInsertTag(id,edOpenTags[id][edOpenTags[id].length - 1]);
			}
		},

	// insertion code
		edInsertTag: function (the_id,i, suf) {
		if (the_id){
		id = the_id;}
		if (suf){
		suffix = suf;}
		var myField = _$(id);

			//IE support
			if (document.selection) {
				myField.focus();
			sel = document.selection.createRange();
				if (sel.text.length > 0) {
					sel.text = edButtons[i].tagStart + sel.text + edButtons[i].tagEnd;
				}
				else {
					if (!edCheckOpenTags(i) || edButtons[i].tagEnd === '') {
						sel.text = edButtons[i].tagStart;
						edAddTag(i);
					}
					else {
						sel.text = edButtons[i].tagEnd;
						edRemoveTag(i);
					}
				}
				myField.focus();
			}
			//MOZILLA/NETSCAPE support
			else if (myField.selectionStart || myField.selectionStart == '0') {
				var startPos = myField.selectionStart;
				var endPos = myField.selectionEnd;
				var cursorPos = endPos;
				var scrollTop = myField.scrollTop;
				if (startPos != endPos) {
					myField.value = myField.value.substring(0, startPos)
							+ edButtons[i].tagStart
							+ myField.value.substring(startPos, endPos)
							+ edButtons[i].tagEnd
							+ myField.value.substring(endPos, myField.value.length);
					cursorPos += edButtons[i].tagStart.length + edButtons[i].tagEnd.length;
				}
				else {
					if (!edCheckOpenTags(i) || edButtons[i].tagEnd === '') {
						myField.value = myField.value.substring(0, startPos)
								+ edButtons[i].tagStart
								+ myField.value.substring(endPos, myField.value.length);
						edAddTag(i);
						cursorPos = startPos + edButtons[i].tagStart.length;
					}
					else {
						myField.value = myField.value.substring(0, startPos) +
										edButtons[i].tagEnd  +
										myField.value.substring(endPos, myField.value.length);
						edRemoveTag(i);
						cursorPos = startPos + edButtons[i].tagEnd.length;
					}
				}
				myField.focus();
				myField.selectionStart = cursorPos;
				myField.selectionEnd = cursorPos;
				myField.scrollTop = scrollTop;
			}
			else {
				if (!edCheckOpenTags(i) || edButtons[i].tagEnd === '') {
					myField.value += edButtons[i].tagStart;
					edAddTag(i);
				}
				else {
					myField.value += edButtons[i].tagEnd;
					edRemoveTag(i);
				}
				myField.focus();
			}
		},

		edInsertLink: function(the_id, i, suf) {
		if (the_id){
			id = the_id;
		}		if (suf){
		suffix = suf;}

			if (!edCheckOpenTags(i)) {
				var URL = prompt('Enter the URL' ,'http://');
				if (URL) {
					edButtons[i].tagStart = '<a href="' + URL + '">';
					aWP_qt.edInsertTag(the_id,i);
				}
			}
			else {
				aWP_qt.edInsertTag(the_id,i);
			}
		},

		edInsertImage: function (the_id,myField, suf) {
			if (the_id){
				id = the_id;
			}

			if (suf){
				suffix = suf;
			}

			var myValue = prompt('Enter the URL of the image', 'http://');
			if (myValue) {
				myValue = '<img src="'
						+ myValue
						+ '" alt="' + prompt('Enter a description of the image', '')
						+ '" />';
				edInsertContent(myValue);
			}
		},


		edInsertSmilie: function (the_id,smilie, suf) {
			if (smilie) {
				if (the_id){
					id = the_id;
				}
				if (suf){
					suffix = suf;
				}
				edInsertContent(smilie);
			}
		}
	}
}();

/* start effects */

/**
*	Copyrighted 2007 to:
*	Aaron Huran http://anthologyoi.com
*	The code is released under a Creative Commons Liscense
*	(Attribution-NonCommercial-ShareAlike 2.0)
*	TERMS: (Removal this section indicates agreement with these Terms.)
*	For Personal (non-distribution) this notice (sans Terms section) must remain.
*	For Distribution this notice must remain and attribution through
*	a publically accessible "followable" link on applicable information/download page is required.
*	No Commercial use without prior approval.
**/

var AOI_eff = function () {
	var delay = 100;
	var _d = [];
	var $ = function (id) {
		return document.getElementById(id);
	};

	var hideChildren = function(id){
		var c = document.getElementById(id).getElementsByTagName('div');

		for(x=0; x < c; x++){

			if(c.parentNode.id == id){
				console.log('hi');
			}
		console.log(id, c, document.getElementById(c).parentNode.id)
		}

	}

	return {
		start: function () {
			var	i = arguments[0];

			if (!_d[i]) {
				_d[i] = arguments[1] || [];

				if (!_d[i].queue) {
					_d[i].queue = '';
				}

				if (!_d[i].mode) {
					if ($(i).style.display === 'block') {
						_d[i].mode = 'hide';
					} else {
						_d[i].mode = 'show';
					}
				}

				if(_d[i].hideChildren)
					hideChildren(_d[i].hideChildren);
				AOI_eff.setup(i);
			}
		},
		setup: function (i) {

			if ($(i)) {
				if (_d[i].mode === 'hide') {
					_d[i].step = -10;

					AOI_eff.ready(i, 'hide');
				} else if (_d[i].mode === 'show') {

					_d[i].step = 10;
					AOI_eff.ready(i, 'show');
				} else if (_d[i].mode === 'other') {
					_d[i].step = 10;
					AOI_eff.ready(i, 'other');
				}

				if (!_d[i].delay) {
					_d[i].delay = delay;
				}

				AOI_eff.doit(i);
			} else {
				return false;
			}
		},
		ready: function (i, m) {
			var e = $(i).style;
			switch (_d[i].eff) {
				case 'Expand':

					_d[i]['overflow'] = e.overflow;
					_d[i]['lineHeight'] = e.lineHeight;
					_d[i]['letterSpacing'] = e.letterSpacing;

					if (m === 'show') {
						e.overflow = 'hidden';
						e.lineHeight = '300%';
						e.letterSpacing = '1em';
					}

					break;
				case 'SlideUp':
					_d[i]['height'] = $(i).offsetHeight;
					if (m === 'show') { /*We need an object to be displayed to retrieve height.*/
						e.position='absolute'; /*Pull the element out of its default location*/
						e.visibility='hidden'; /*Hide the element*/
						e.display='block';/*"Display" the hidden element*/
						_d[i]['height'] = $(i).offsetHeight;
						e.visibility=''; /*Show it*/
						e.position='relative'; /*Put it back where it was*/
						e.height = '0px'; /*shrink it for the effect.*/
					}
					e.overflow="hidden";
					break;

				case 'ScrollLeft':
					_d[i]['marginLeft'] = e.marginLeft;
					if (m === 'show') {
						e.marginLeft = 80+'%';
					}
					break;
				case 'Fade':
					e.zoom = 1;/*IE fix*/
					e.backgroundColor = _d[i].background;
					if (m === 'show') {
						e.filter = 'alpha(opacity=0)';
						e.opacity = 0;
					}
					break;
			}

			if (m === 'show') {
				e.display = 'block';
			}
		},
		doit: function (i) {
			var e = $(i).style; /**/
			var m = _d[i].mode;
			var s = _d[i].step;
			var v = 0;

			if ( _d[i].step !== 0  ) {
				switch (_d[i].eff) {
					case 'Expand':
						if 	( m === 'hide' ) {
							v = (100+ (10+s)*20); /*IE fix*/
							e.lineHeight = v+'%';
							e.letterSpacing = ((10+s)*3)+'px';
							_d[i].step += 1;
						} else {
							v = (300 - (10-s)*20);/*IE fix*/
							e.lineHeight = v+'%';
							e.letterSpacing = s*2+'px';
							_d[i].step -= 1;
						}
					break;

					case 'SlideUp':
						if 	( m === 'hide' ) {
							e.height =  Math.floor( _d[i]['height']*s*-0.1)+'px';
							_d[i].step += 1;
						} else {
							e.height = Math.floor( _d[i]['height']*(10-s)*0.1)+'px';
							_d[i].step -= 1;
						}
					break;

					case 'ScrollLeft':

						if 	( m === 'hide' ) {
							if ((!window.innerHeight && s < -3) || window.innerHeight ) {/*IE fix*/
								e.marginLeft=((10 + s)*10)+'%';
							}
							_d[i].step += 1;
						} else {
							e.marginLeft=(s*8)+'%';
							_d[i].step -= 1;
						}
					break;

					case 'Fade' :
						if 	( m === 'hide' ) {
							e.opacity = (s)/-10;
							e.filter = 'alpha(opacity='+(s*-10)+')';
							_d[i].step+= 1;
						} else {
							e.filter = 'alpha(opacity='+((10-s)*10)+')';
							e.opacity = (10 - s)/10;
							_d[i].step -= 1;
						}
						break;
					default:
						_d[i].step = 0;
						break;

				}
					setTimeout("AOI_eff.doit('"+i+"');",  _d[i].delay); /*Call next frame after delay.*/
			} else {
				AOI_eff.finish(i); /*Clean up*/
			}
		},
		finish: function (i) {
			var e = $(i).style; /**/
			if ( _d[i].mode === 'hide' ) {
				e.display = 'none';
			}

			switch (_d[i].eff) {
				case 'Expand':
					if ( _d[i]['overflow'] ) {
						e.overflow = _d[i]['overflow'];
					}

					e.lineHeight ="normal";
					e.letterSpacing ="normal";

					break;
				case 'SlideUp':
					e.height = _d[i]['height']+'px';
					if(window.innerHeight){ /*IE has problems setting height to auto.*/
						e.height = 'auto';}
					e.overflow="visible";
					break;
				case 'ScrollLeft':
					e.marginLeft = _d[i]['marginLeft'] ;
					break;
				default :
					e.opacity = 10;
					e.filter = 'alpha(Opacity=100)';
			}

			if ( _d[i].queue.length > 0 ) {/* Checks to see if there is another effect*/
				var val;

				val = _d[i].queue.shift().split('::'); /*Gets values for first queue'd item*/
				if (val[2]) { /*Sets effect*/
					_d[i].eff = val[2];
				}
				if (val[3]) { /*Sets delay*/
					_d[i].delay = val[3];
				}
				dtemp = _d[i];
				_d[i] = null;
				_d[val[1]] = [];
				_d[val[1]] = dtemp;
				_d[val[1]].mode = val[0];


				AOI_eff.setup(val[1]);
			} else {
				_d[i] = null;
			}
		}
	};
}();