<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Sublime Geek" />
	<meta name="description" content="Home of Sublime Geek Products and Services" />
	<meta name="keywords" content="keywords, or phrases, associated, with each page, are best" />
	<title>{title}</title>
	
	<!-- Favorites icon -->
	<link rel="shortcut icon" href="http://sublimegeek.com/favicon.ico" />
	
	<!-- Style sheets -->
	<link rel="stylesheet" type="text/css" href="css/reset.min.css" />
	<link rel="stylesheet" type="text/css" href="css/menu.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fancybox.css" />
	<link rel="stylesheet" type="text/css" href="css/tooltip.min.css" />
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="stylesheet" type="text/css" href="css/skins/skin-1.css" />
	<link rel="stylesheet" type="text/css" href="css/css_buttons.css" />
	
	<!-- jQuery framework and utilities -->
	<script type="text/javascript" src="js/jquery-1.4.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.min.js"></script>
	<script type="text/javascript" src="js/hoverIntent.min.js"></script>
	<script type="text/javascript" src="js/jquery.bgiframe.min.js"></script>
	<!-- Drop down menus -->
	<script type="text/javascript" src="js/superfish.min.js"></script>
	<script type="text/javascript" src="js/supersubs.min.js"></script>
	<!-- Tooltips -->
	<script type="text/javascript" src="js/jquery.cluetip.min.js"></script>
	<!-- Input labels -->
	<script type="text/javascript" src="js/jquery.overlabel.min.js"></script>
	<!-- Anchor tag scrolling effects -->
	<script type="text/javascript" src="js/jquery.scrollTo-min.js"></script>
	<script type="text/javascript" src="js/jquery.localscroll-min.js"></script>
	<!-- Inline popups/modal windows -->
	<script type="text/javascript" src="js/jquery.fancybox-1.2.6.pack.js"></script>
	
	<!-- Slide shows -->
		<!-- Cycle 	(default, used by demo skin changer) -->
			<script type="text/javascript" src="js/jquery.cycle.all.min.js"></script>
				<!-- Cu3er -->
				<script type="text/javascript" src="js/swfobject.js"></script>
				<script type="text/javascript">
					var flashvars = {};
					flashvars.xml = "xml/config.xml";
					flashvars.font = "font.swf";
					var attributes = {};
					attributes.wmode = "transparent";
					attributes.id = "slider";
					swfobject.embedSWF("flash/cu3er.swf", "TheCu3er", "938", "340", "9", "flash/expressInstall.swf", flashvars, attributes);
				</script>
		
	<!-- Font replacement (cufón) -->
	<script src="js/cufon-yui.js" type="text/javascript"></script>
	<script src="js/LiberationSans.font.js" type="text/javascript"></script>

	<!-- IE only includes (PNG Fix and other things for sucky browsers -->
	
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="css/ie-only.css">
		<script type="text/javascript" src="js/pngFix.min.js"></script>
		<script type="text/javascript"> 
			$(document).ready(function(){ 
				$(document.body).supersleight();
			}); 
		</script> 
	<![endif]-->
	<!--[if IE]><link rel="stylesheet" type="text/css" href="css/ie-only-all-versions.css"><![endif]-->

	
	
	<!-- BEGIN: For Demo Only -->
		<!--			
		These entries are only needed for demo features, such as the real-time skin changer.
		They can be deleted for production installs without effecting the theme's design or 
		any of the funcionality.		
		-->
		
		<script type="text/javascript" src="js/demo.js"></script>	
		<link rel="stylesheet" type="text/css" href="css/demo.css" />		
	<!-- END: For Demo Only -->
	

	<!-- Functions to initialize after page load -->
	<script type="text/javascript" src="js/onLoad.min.js"></script>

	
</head>
<body>

<!-- Top reveal (slides open, add class "topReveal" to links for open/close toggle ) -->
<div id="ContentPanel">

	<!-- close button -->
	<a href="#" class="topReveal closeBtn">Close</a>
	
	<div class="contentArea">

		<!-- New member registration -->
		<div class="right" style="margin:10px 0 0;">
			<h1>
				Not a member yet?
				<span>Register now and get started.</span>
			</h1>
			<button type="button">Register for an account</button>
		</div>
		
		<!-- Alternate Login -->				
		<div>
			<form class="loginForm" method="post" action="" style="height:auto;">
				<div id="loginBg"><img src="images/icons/lock-and-key-110.png" width="110" height="110" alt="lock and key" /></div>
				<h2 style="margin-top: 20px;">Sign in to your account.</h2>
				<fieldset>
					<legend>Account Login</legend>
					<p class="left" style="margin: 0 8px 0 0;">
						<label for="RevealUsername" class="overlabel">Username</label>
						<input id="RevealUsername" name="RevealUsername" type="text" class="loginInput textInput rounded" />
					</p>
					<p class="left" style="margin: 0 5px 0 0;">
						<label for="RevealPassword" class="overlabel">Password</label>
						<input id="RevealPassword" name="RevealPassword" type="password" class="loginInput textInput rounded" />
					</p>
					<p class="left" style="margin: -7px 0 0;">
						<button type="submit" class="btn" style="margin:0;"><span>Sign in</span></button>
					</p>
				</fieldset>
				<p class="left noMargin">
					<a href="#">Forgot your password?</a>
				</p>
			</form>		
		</div>
		
		<!-- End of Content -->
		<div class="clear"></div>
	
	</div>
</div>

<!-- Site Container -->
<div id="Wrapper">
	<div id="PageWrapper">
		<div class="pageTop"></div>
		<div id="Header">
		
			<!-- Main Menu -->
			<div id="MenuWrapper">
				<div id="MainMenu">
					<div id="MmLeft"></div>
					<div id="MmBody">
						
						<!-- Main Menu Links -->
						<ul class="sf-menu">
							<li class="current"><a href="/">Home</a></li>
							<li>
								<a href="#">Products</a>
								<ul>
									{products}
									<li><a href={product_url}>{product_name}</a></li>
									{/products}									
								</ul>
							</li>
							<li>
								<a href="#">Popular</a>
								<ul>
									{metavotr}
									<li><a href={metavotr_url}>{metavotr_name}</a></li>
									{/metavotr}									
								</ul>
							</li>
							<li><a href="http://blog.sublimegeek.com/">Blog</a></li>
							<li><a href="http://codaset.com/sublimegeek/sublime-geek/tickets/new">Support</a></li>
							<li><?=safe_mailto('support@sublimegeek.com', 'Contact'); ?></li>
								
						</ul>
						
						<div class="mmDivider"></div>				
						
						<!-- Extra Menu Links -->
						<ul id="MmOtherLinks" class="sf-menu">
							<li>
								<a href="#"><span class="mmFeeds">Feeds</span></a>
								<ul>
									<li><a href="http://blog.sublimegeek.com/?feed=rss2"><span class="mmRSS">RSS</span></a></li>
									<li><a href="http://www.facebook.com/pages/Sublime-Geek/185566386860"><span class="mmFacebook">Facebook</span></a></li>
									<li><a href="http://twitter.com/sublimegeek"><span class="mmTwitter">Twitter</span></a></li>
								</ul>
							</li>
							<li><a href="http://sublimegeek.com/blog/wp-login.php" class="login">Login</a></li>
						</ul>
						
					</div>
					<div id="MmRight"></div>
				</div>
			</div>
			
			<!-- Search -->
			<div id="Search">				
				<form action="http://www.google.com/cse" id="cse-search-box" target="_blank">
				  <div>
				    <input type="hidden" name="cx" value="partner-pub-6116332704082648:bg9z3d94m8a" />
				    <input type="hidden" name="ie" value="ISO-8859-1" />
				    <input type="text" name="q" id="SearchInput" value="" size="31" />
				    <p style="margin:0;"><input type="submit" name="sa" id="SearchSubmit" class="noStyle" value="" /></p>
				  </div>
				</form>
				<!--<script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&amp;lang=en"></script>-->

			</div>
			
			<!-- Logo -->
			<div id="Logo">
				<a href="/"></a>
			</div>
			
			<!-- End of Content -->
			<div class="clear"></div>
		
		</div>

		<!-- Slide show: CU3ER -->
		<div id="Slideshow-cu3er">
			<div id="cu3erShadow">
				<div id="TheCu3er"></div>
			</div>	
		</div>		
		
		<div class="pageMain">
		
			<!-- Showcase Content -->
			<div id="Showcase">
			
				
				<div class="two-thirds">
					<!--
					<img src="images/icons/monitor-skins.png" width="85" height="75" alt="computer monitor" style="float:left; margin: -2px 30px 0 15px;" /> 
					<h1 class="title">
						Under Construction
						<span>As you can see we are remodeling!  More to come soon.</span>
					</h1>
					-->
				</div>
				
				
				<div class="one-third">
					<!-- <img src="images/icons/projector.png" width="96" height="75" alt="digital projector" style="float:right; margin: 0 8px 0 0;" /> 
					<h1 class="title">
						3 Slide Shows
						<span>A style for every layout</span>
					</h1>
					<p>
						<a href="index.html">Cycle</a>, <a href="index-2.html">Cu3er</a> and <a href="index-3.html">Gallery</a>
					</p>
					-->
				</div>
				
				
				<div class="hr"></div>
				
			</div>
			
			<!-- Page Content -->
			<div class="contentArea">
			
				<div class="two-thirds">
					
					<!-- Welcome Message / Page Headline -->
					<h1 class="headline">Welcome to <strong>Sublime Geek</strong>, we hope you enjoy our new site.</h1>
					<p class="impact">We're all about bringing you the best products at the right price.  That's why each product goes under many tests before, during, and after release ensuring you have the best gadget a geek could hope for.  Sublime Geek is committed to quality, stability, and a friendly, helpful staff who is there when you need them.</p>
	
					<!-- Featured Content 
					<div class="ribbon">
						<div class="wrapAround"></div>
						<div class="tab">
							<span>Products &amp; Services</span>
						</div>
					</div>
					-->
	
					<div class="featuredContent">
						<!-- Featured Item 
						<div class="featuredItem">
							<a href="images/content/demo-only/featured-1.jpg" class="featuredImg img zoom" rel="featured"><img src="images/content/demo-only/featured-1-thumb.jpg" alt="featured item" /></a>
							<div class="featuredText">
								<h1 class="title">
									Dynamic Functionality
									<span>jQuery integrated to provide high quality, dynamic design features.</span>
								</h1>
								<a href="#">More information...</a>
							</div>
						</div>
						-->
											
						<!-- End of Content -->
						<div class="clear"></div>
	
					</div>
					
					<!-- Blog Post 
					<div class="ribbon">
						<div class="wrapAround"></div>
						<div class="tab">
							<span class="blogDate">5 Jan.</span>
							<span class="blogPostInfo">Posted by <a href="#">J. Smith</a> in <a href="#">Advertising</a> | <a href="#">3 comments</a></span>
						</div>
					</div>
					<div class="blogPostSummary">
						<h1>How to Build a Better Mousetrap</h1>
						<div class="blogPostImage">
							<a href="#" class="img"><img src="images/content/demo-only/blog-post-1.jpg" width="566" height="133" alt="blog post image" /></a>
						</div>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel leo vitae mi iaculis tincidunt. Sed ipsum diam, semper et adipiscing sit amet, gravida ac ipsum. Phasellus rutrum est non eros ultrices a molestie tellus suscipit. Nunc eleifend, nisl vel cursus hendrerit, arcu risus sagittis lorem, nec gravida massa lacus non nulla. Praesent urna diam, cursus ac eleifend mattis, euismod et nisi. Vestibulum id leo sit amet nisi. Aliquam erat volutpat. Nam egestas mollis ultrices. Praesent nec tellus est, et convallis mauris.
						</p>
						<p><a href="#">Read more...</a></p>
					</div>
					-->					
				</div>
				
				<div class="one-third">
				<a href="https://sublimegeek.freshbooks.com/refer/www" style="background-color: transparent;"><img src="http://www.freshbooks.com/images/banners/fb200x125-loving.png" width="200" height="125" border="0" alt="FreshBooks" /></a>
					<div class="hr"></div>
					
					<!-- Side Navigation Menu -->
					<h1 class="title" style="margin-bottom:0;">
						Other Cool Links
						<span>Links to other places we've been</span>
					</h1>
					<div class="sideNavWrapper">
						<div class="sideNavBox-1">
							<div class="sideNavBox-2">
								<ul class="sideNav">
									{links}<li><a href={link_url}>{link_title}</a></li>{/links}									
								</ul>
							</div>
						</div>
					</div>
					
					<!-- Testimonial/Quote 
					{testimonials}
					<div class="quote">
						<div class="quoteBox-1">
							<div class="quoteBox-2">
								<p>{quote}</p>
							</div>
						</div>
					</div>
					
					<div class="quoteAuthor">
						<p class="name">{quote_author}</p>
						<p class="details">{quote_details}</p>
					</div>
					{/testimonials}
					-->
					
					<div class="hr"></div>
					
					<!-- Newsletter 
					<h1 class="title" style="margin-bottom:0;">
						Newsletter
						<span>We’ll keep you informed and updated</span>
					</h1>
					<form action="#" id="newsletter" method="post">
						<p style="margin: 1em 0 1px;">
							<label for="NewsletterEmail" class="overlabel">Email</label>
							<input type="text" id="NewsletterEmail" class="textInput" style="width: 259px; margin:0;" />
						</p>
						<p style="margin:0;"><button type="submit" class="btn"><span>Sign me up!</span></button></p>
					</form>
					-->
	
				</div>
				
				
				<!-- End of Content -->
				<div class="clear"></div>
			
			</div>
			
		</div>
		
		<!-- Footer -->
		<div id="Footer">
			<div id="FooterTop"></div>
			<div id="FooterContent">
			
				<div class="contentArea">
				
					<!-- Column 1 -->
					<div class="one-third">
						<h3>We are in Second Life</h3>
						<p>Come visit us in-world in <a href="http://lmrk.in/sig">Quietly Tuesday</a>.</p>
						<h3>Sublime Geek Powered By:</h3>
						<a href="http://www.rackspacecloud.com/295-0-1-19.html" target="_blank"><img border="0" src="http://affiliates.rackspacecloud.com/banners/Powered_the-rackspace-cloud-250-wide.png" width="250" height="69" alt="Powered by Rackspace Cloud Computing"></a>
					</div>

					<!-- Column 2 -->
					<div class="one-third">
						<h3>Stay Connected</h3>
						<ul class="horizList">
							<!--
								<li><a href="#"><img src="images/icons/social/delicious.png" width="40" height="40" alt="Delicious" /></a></li>
								<li><a href="#"><img src="images/icons/social/flickr.png" width="40" height="40" alt="Flickr" /></a></li>
								<li><a href="#"><img src="images/icons/social/linkedin.png" width="40" height="40" alt="LinkedIn" /></a></li>
								<li><a href="#"><img src="images/icons/social/skype.png" width="40" height="40" alt="Skype" /></a></li>
							-->
							<li><a href="http://www.facebook.com/pages/Sublime-Geek/185566386860">	<img src="images/icons/social2/facebook.png" 	alt="Facebook" />	</a></li>
							<li><a href="http://twitter.com/sublimegeek">							<img src="images/icons/social2/twitter.png"  	alt="Twitter" />	</a></li>
							<li><a href="http://blog.sublimegeek.com/">								<img src="images/icons/social2/wordpress.png"  	alt="Blog" />		</a></li>
							<li><a href="mailto:support@sublimegeek.com">							<img src="images/icons/social2/email.png"  		alt="Email" />		</a></li>
							<li><a href="http://youtube.com/djfoxyslpr">							<img src="images/icons/social2/youtube.png"  	alt="YouTube" />	</a></li>
						</ul>
						<p>Keep track of Sublime Geek on all your favorite social networks.</p>
					</div>

					<!-- Column 3 -->
					<div class="one-third last">
						<h3>Contact Information</h3>
						<div class="logoMark"></div>						
					</div>
					
					<!-- End of Content -->
					<div class="clear"></div>
	
				</div>
					
			</div>
			<div id="FooterBottom">
			
			<!-- Begin W3Counter Tracking Code -->
				<script type="text/javascript" src="http://www.w3counter.com/tracker.js"></script>
				<script type="text/javascript">
				w3counter(30100);
				</script>
				<noscript>
				<div><a href="http://www.w3counter.com"><img src="http://www.w3counter.com/tracker.php?id=30100" style="border: 0;height:1px;width:1px" alt="W3Counter" /></a></div>
				</noscript>
			<!-- End W3Counter Tracking Code-->
			
			</div>
			
		</div>
		
		<!-- Copyright/legal text -->
		<div id="Copyright">
			<p>
				Copyright &copy; 2010 - <a href="http://sublimegeek.com" onclick="window.open(this.href); return false;">Sublime Geek</a> - All rights reserved. 
				Conforms to W3C Standard 
				<a href="http://validator.w3.org/check?uri=referer" onclick="window.open(this.href); return false;">XHTML</a> &amp; 
				<a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3" onclick="window.open(this.href); return false;">CSS</a>
			</p>
		</div>
		
	</div>
</div>

<!-- Activate Font Replacement (cufón) -->
<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>
