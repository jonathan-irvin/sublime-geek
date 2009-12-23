

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sublime Geek metaTip</title>
	<meta http-equiv="Content-Language" content="English" />
	<meta name="Robots" content="index,follow" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
        
        <!-- Google Ajax Api  -->
        <script src="http://www.google.com/jsapi?key=notsupplied-wizard"
          type="text/javascript"></script>
      
        <!-- Dynamic Feed Control and Stylesheet -->
        <script src="http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.js"
          type="text/javascript"></script>
        <style type="text/css">
          @import url("http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.css");
        </style>
      
        <script type="text/javascript">
          function LoadDynamicFeedControl() {
            var feeds = [{title: 'Sublime Geek',url: 'http://sublimegeek.com/?feed=rss2' }];
            var options = {
              stacked : false,
              horizontal : true,
              title : ""
            }      
            new GFdynamicFeedControl(feeds, 'feed-control', options);
          }
          // Load the feeds API and set the onload callback.
          google.load('feeds', '1');
          google.setOnLoadCallback(LoadDynamicFeedControl);
        </script>
        <!-- ++End Dynamic Feed Control Wizard Generated Code++ -->
<!--
		<style type="text/css">
table.trans {
	border-width: medium medium medium medium;
	border-spacing: 2px;
	border-style: solid solid solid solid;
	border-color: gray gray gray gray;
	border-collapse: collapse;
	background-color: white;
	width: 100%;
}
table.trans th {
	border-width: thin thin thin thin;
	padding: 1px 1px 1px 1px;	
	border-color: gray gray gray gray;
	background-color: white;	
}
table.trans td {
	border-width: thin thin thin thin;
	padding: 1px 1px 1px 1px;	
	border-color: gray gray gray gray;
	background-color: white;	
}
</style> -->

<!-- jQuery -->
<link type="text/css" href="css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
	$(function(){

		// Accordion
		$("#accordion").accordion({ header: "h3" });

		// Tabs
		$('#tabs').tabs();


		// Dialog			
		$('#dialog').dialog({
			autoOpen: false,
			width: 600,
			buttons: {
				"Ok": function() { 
					$(this).dialog("close"); 
				}, 
				"Cancel": function() { 
					$(this).dialog("close"); 
				} 
			}
		});
		
		// Dialog Link
		$('#dialog_link').click(function(){
			$('#dialog').dialog('open');
			return false;
		});

		// Datepicker
		$('#datepicker').datepicker({
			inline: true
		});
		
		// Slider
		$('#slider').slider({
			range: true,
			values: [17, 67]
		});
		
		// Progressbar
		$("#progressbar").progressbar({
			value: 20 
		});
		
		//hover states on the static widgets
		$('#dialog_link, ul#icons li').hover(
			function() { $(this).addClass('ui-state-hover'); }, 
			function() { $(this).removeClass('ui-state-hover'); }
		);
		
	});
</script>
<style type="text/css">	
	body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px;}
	.demoHeaders { margin-top: 2em; }
	#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
	#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
	ul#icons {margin: 0; padding: 0;}
	ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
	ul#icons span.ui-icon {float: left; margin: 0 4px;}
</style>	

</head>
<body>

<div id="wrap">

	<div id="top">
            <div class="rights"></div>
            <div id="search"></div>
            
            <div class="lefts">
                    <h1>Sublime Geek metaTip</h1>
                    <h2>Your #1 Tip Jar Resource</h2>
            </div>
	</div>
	
	
          <div id="topmenu">
            <div class="rights"></div>
            <div class="lefts">
            <ul>
            <?php
            print('
            <li><a href="index.php'.$uadd.'"   					title="Dashboard">Dashboard</a></li>                      
            <li><a href="empstat.php'.$uadd.'" 					title="Employee Stats">Employee Stats</a></li>
            <li><a href="vipstat.php'.$uadd.'" 					title="Customer Stats">Tip Stats</a></li> 
			<li><a href="log.php'.$uadd.'"     					title="Transaction Log">Trans Log</a></li> 
            <li><a href="grp_mgt.php'.$uadd.'" 					title="Group Management">Group Mgt.</a></li>            
            <li><a href="http://www.sublimegeek.com/" 			title="Sublime Geek Home">[sig] Blog</a></li>
            <li><a href="http://www.metastreamr.com/" 			title="metaStreamr Home">metaStreamr Blog</a></li>
            <li><a href="http://popular.sublimegeek.com/" 		title="Check Out Hot Locations!">[sig] Popular</a></li>
            <li><a href="http://www.sublimegeek.com/support" 	title="Need Help?">Support</a></li>
            ');
            ?>
          </ul></div>
          </div>       
	
	<div id="subheader">
		<strong>Sublime Geek</strong> aims at bringing you the most useful and most powerful tools that make your SL experience a very efficient and very equipped one.
        </div>
	
	<div id="feed-control" style="background:#FFF;border:5px solid #FFF">
          <span style="color:#FFF;font-size:11px;margin:10px;padding:4px;">Loading...</span>
        </div>