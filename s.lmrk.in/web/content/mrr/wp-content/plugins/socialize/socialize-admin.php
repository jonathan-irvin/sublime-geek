<?PHP
//=============================================
// Load admin styles
//=============================================
function add_socialize_admin_styles() {
	global $pagenow;
	if ( $pagenow == 'options-general.php' && isset($_GET['page']) && strstr($_GET['page'],"socialize")) {
		wp_enqueue_style('dashboard');
		wp_enqueue_style('global');
		wp_enqueue_style('wp-admin');
		wp_enqueue_style('farbtastic');
	}
}

//=============================================
// Load admin scripts
//=============================================
function add_socialize_admin_scripts() {
	global $pagenow;
	if ( $pagenow == 'options-general.php' && isset($_GET['page']) &&  strstr($_GET['page'],"socialize")) {
		wp_enqueue_script('postbox');
		wp_enqueue_script('dashboard');
		wp_enqueue_script('custom-background');
	}
}

//=============================================
// Display support info
//=============================================
function socialize_show_plugin_support() {
	$content = '<p>Leave a comment on the <a target="_blank" href="http://www.jonbishop.com/downloads/wordpress-plugins/socialize/#comments">Socialize Plugin Page</a></p>
	<p style="text-align:center;">- or -</p>
	<p>Create a new topic on the <a target="_blank" href="http://wordpress.org/tags/socialize">WordPress Support Forum</a></p>';
	return socialize_postbox('socialize-support', 'Support', $content);
}

//=============================================
// Display support info
//=============================================
function socialize_show_donate() {
	$content = '<p>If you like this plugin please consider donating a few bucks to support its development. If you can\'t spare any change you can also help by giving me a good rating on WordPress.org and tweeting this plugin to your followers.
	<ul>
		<li><a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=jonbish%40gmail%2ecom&lc=US&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted">Donate With PayPal</a></li>
		<li><a target="_blank" href="http://wordpress.org/extend/plugins/socialize/">Give Me A Good Rating</a></li>
		<li><a target="_blank" href="http://twitter.com/?status=WordPress Plugin: Selectively Add Social Bookmarks to Your Posts http://bit.ly/IlCdN (via @jondbishop)">Share On Twitter</a></li>
	</ul></p>';
	return socialize_postbox('socialize-donate', 'Donate & Share', $content);
}

//=============================================
// Display feed
//=============================================
function socialize_show_blogfeed() {
	include_once(ABSPATH . WPINC . '/feed.php');
	$content = "";
	$rss = fetch_feed("http://feeds.feedburner.com/JonBishop");
	if (!is_wp_error( $rss ) ) {
	  $maxitems = $rss->get_item_quantity(5); 
	  $rss_items = $rss->get_items(0, $maxitems); 
	}
	
	if ($maxitems == 0) {
		$content .= "<p>No Posts</p>";
	} else {
		$content .= "<ul>";
		foreach ( $rss_items as $item ) { 
			$content .= "<li><a href='" . $item->get_permalink(). "' title='Posted ".$item->get_date('j F Y | g:i a') ."'>" . $item->get_title() . "</a></li>";
		}
		$content .= "</ul>";
		$content .= "<p><a href='" . $rss->get_permalink() . "'>More Posts &raquo;</a></p>";
	}
	return socialize_postbox('socialize-blog-rss', 'Tips and Tricks', $content);
}

//=============================================
// Contact page options
//=============================================
function socialize_general_settings(){
	$socialize_settings = socialize_process_settings();
	$socializemeta = explode( ',', $socialize_settings['sharemeta']);
	
	$wrapped_content = "";
	$general_content = "";	
	$alert_content = "";
	$buttons_content = "";
	$default_content= "";
	
	if ( function_exists('wp_nonce_field') ){ $general_content .= wp_nonce_field('socialize-update-options','_wpnonce',true,false); }
	$general_content .= '<p><strong>' . __("Top Button Location") . '</strong><br /> 
				<label>Left<input type="radio" value="left" name="socialize_float" ' . checked($socialize_settings['socialize_float'], 'left', false) . '/></label>
                <label>Right<input type="radio" value="right" name="socialize_float" ' . checked($socialize_settings['socialize_float'], 'right', false) . '/></label>
				<small>Choose whether to display the buttons in the content on the right or left.</small></p>';
	$general_content .= '<p><strong>' . __("Display On Front Page") . '</strong><br /> 
				<input type="checkbox" name="socialize_display_front" ' .checked($socialize_settings['socialize_display_front'], 'on', false) . ' />
				<small>Display buttons on the front page at the top of each entry.</small></p>';			
	$general_content .= '<p><strong>' . __("Display In Archives") . '</strong><br /> 
				<input type="checkbox" name="socialize_display_archives" ' .checked($socialize_settings['socialize_display_archives'], 'on', false) . ' />
				<small>Display buttons on the archive pages at the top of each entry.</small></p>';	
	$general_content .= '<p><strong>' . __("Display In Search Results") . '</strong><br /> 
				<input type="checkbox" name="socialize_display_search" ' .checked($socialize_settings['socialize_display_search'], 'on', false) . ' />
				<small>Display buttons on the search page at the top of each entry.</small></p>';	
	$general_content .= '<p><strong>' . __("Display On Individual Posts") . '</strong><br /> 
				<input type="checkbox" name="socialize_display_posts" ' .checked($socialize_settings['socialize_display_posts'], 'on', false) . ' />
				<small>Display buttons on individual posts at the top of the entry.</small></p>';	
	$general_content .= '<p><strong>' . __("Display On Individual Pages") . '</strong><br /> 
				<input type="checkbox" name="socialize_display_pages" ' .checked($socialize_settings['socialize_display_pages'], 'on', false) . ' />
				<small>Display buttons on individual pages at the top of the entry.</small></p>';	
	$general_content .= '<p><strong>' . __("Display In Feed") . '</strong><br /> 
				<input type="checkbox" name="socialize_display_feed" ' .checked($socialize_settings['socialize_display_feed'], 'on', false) . ' />
				<small>Display buttons in your feed at the top of each entry.</small></p>';			
	$wrapped_content .= socialize_postbox('socialize-settings-general', 'Display Settings', $general_content);
	
	$buttons_content .= '<p><strong>' . __("Twitter") . '</strong></p>';
	$buttons_content .= '<p>' . __("Choose which Twitter retweet button to display") . ':<br /> 
				<label><input type="radio" value="official" name="socialize_twitterWidget" ' . checked($socialize_settings['socialize_twitterWidget'], 'official', false) . '/> <a href="http://twitter.com/goodies/tweetbutton" target="_blank">Official Tweet Button</a></label><br />
                <label><input type="radio" value="tweetmeme" name="socialize_twitterWidget" ' . checked($socialize_settings['socialize_twitterWidget'], 'tweetmeme', false) . '/> <a href="http://tweetmeme.com/" target="_blank">TweetMeme</a></label><br />
				<label><input type="radio" value="backtype" name="socialize_twitterWidget" ' . checked($socialize_settings['socialize_twitterWidget'], 'backtype', false) . '/> <a href="http://www.backtype.com/widgets/tweetcount" target="_blank">BackType</a></label><br />
                <label><input type="radio" value="topsy" name="socialize_twitterWidget" ' . checked($socialize_settings['socialize_twitterWidget'], 'topsy', false) . '/> <a href="http://topsy.com/" target="_blank">Topsy</a></label><br /></p>';								
	$buttons_content .= '<p>' . __("Twitter Source") . '<br /> 
				<input type="text" name="socialize_twitter_source" value="' . $socialize_settings['socialize_twitter_source'] . '" />
				<small>This is your Twitter name. By default, the source is @socializeWP.</small></p>';				
	$buttons_content .= '<p><strong>' . __("Facebook") . '</strong></p>';
	$buttons_content .= '<p>' . __("Choose which Facebook share button to display") . ':<br /> 
				<label><input type="radio" value="official" name="socialize_fbWidget" ' . checked($socialize_settings['socialize_fbWidget'], 'official', false) . '/> <a href="http://www.facebook.com/facebook-widgets/share.php" target="_blank">Official Share Button</a></label><br />
                <label><input type="radio" value="official-like" name="socialize_fbWidget" ' . checked($socialize_settings['socialize_fbWidget'], 'official-like', false) . '/> <a href="http://developers.facebook.com/docs/reference/plugins/like" target="_blank">Official Like Button</a></label><br />
				<label><input type="radio" value="fbshareme" name="socialize_fbWidget" ' . checked($socialize_settings['socialize_fbWidget'], 'fbshareme', false) . '/> <a href="http://www.fbshare.me/" target="_blank">fbShare.me</a></label><br /></p>';
	$wrapped_content .= socialize_postbox('socialize-settings-buttnos', 'Twitter and Facebook Button Settings', $buttons_content);
	
	$alert_content .= '<p><strong>' . __("Display 'Call To Action' Box Below Posts") . '</strong><br /> 
				<input type="checkbox" name="socialize_alert_box" ' .checked($socialize_settings['socialize_alert_box'], 'on', false) . ' />
				<small>Check this if you want to display a \'Call To Action\' box at the bottom of your posts with "Please Subscribe" text and some social bookmarking buttons.</small></p>';
	$alert_content .= '<p><strong>' . __("Display 'Call To Action' Box On Pages") . '</strong><br /> 
				<input type="checkbox" name="socialize_alert_box_pages" ' .checked($socialize_settings['socialize_alert_box_pages'], 'on', false) . ' />
				<small>Uncheck this if you do not want the \'Call To Action Box\' displayed on your pages and only on blog posts.</small></p>';					
	$alert_content .= '<p><strong>' . __("'Call To Action' Box Text") . '</strong><br /> 
				<textarea name="socialize_text" rows="4" style="width:100%;">' . $socialize_settings['socialize_text'] . '</textarea><br />
				<small>Here you can change your \'Call To Action\' box text. (If you are using a 3rd party site to handle your RSS, like FeedBurner, please make sure any links to your RSS are updated.)</small></p>';	
	$alert_content .= '<p><strong>' . __("'Call To Action' Box Background Color") . '</strong><br /> 
				<input type="text" name="socialize_alert_bg" id="background-color" value="' . $socialize_settings['socialize_alert_bg'] . '" />
				<a class="hide-if-no-js" href="#" id="pickcolor">' . __('Select a Color') . '</a>
				<div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
				<small>By default, the background color of the \'Call To Action\' box is a yellowish tone.</small></p>';	
	$wrapped_content .= socialize_postbox('socialize-settings-alert', '\'Call To Action\' Box Settings', $alert_content);
	
	$default_content .= '
	<div class="socialize-div1" style="width:50%; float: left;">
    	<strong>InLine Social Buttons</strong><br />
        <label class="selectit"><input value="1" type="checkbox" name="sm_twitter_ip" id="post-share-1" ' . checked(in_array(1,$socializemeta), true, false) . ' />' . __('Twitter') . '</label><br />
        <label class="selectit"><input value="2" type="checkbox" name="sm_facebook_ip" id="post-share-2"' . checked(in_array(2,$socializemeta), true, false) . ' />' . __('Facebook') . '</label><br />
        <label class="selectit"><input value="3" type="checkbox" name="sm_digg_ip" id="post-share-3"' . checked(in_array(3,$socializemeta), true, false) . ' />' . __('Digg') . '</label><br />
        <label class="selectit"><input value="4" type="checkbox" name="sm_sphinn_ip" id="post-share-4"' . checked(in_array(4,$socializemeta), true, false) . ' />' . __('Sphinn') . '</label><br />
        <label class="selectit"><input value="5" type="checkbox" name="sm_reddit_ip" id="post-share-5"' . checked(in_array(5,$socializemeta), true, false) . ' />' . __('Reddit') . '</label><br />
        <label class="selectit"><input value="6" type="checkbox" name="sm_dzone_ip" id="post-share-6"' . checked(in_array(6,$socializemeta), true, false) . ' />' . __('Dzone') . '</label><br />
		<label class="selectit"><input value="7" type="checkbox" name="sm_stumbleupon_ip" id="post-share-7"' . checked(in_array(7,$socializemeta), true, false) . ' />' . __('StumbleUpon') . '</label><br />
    	<label class="selectit"><input value="8" type="checkbox" name="sm_delicious_ip" id="post-share-8"' . checked(in_array(8,$socializemeta), true, false) . ' />' . __('Delicious') . '</label><br />
		<label class="selectit"><input value="9" type="checkbox" name="sm_buzz_ip" id="post-share-9"' . checked(in_array(9,$socializemeta), true, false) . ' />' . __('Google Buzz') . '</label><br />
    	<label class="selectit"><input value="10" type="checkbox" name="sm_yahoo_ip" id="post-share-10"' . checked(in_array(10,$socializemeta), true, false) . ' />' . __('Yahoo Buzz') . '</label><br />	
    	<label class="selectit"><input value="22" type="checkbox" name="sm_linkedin_ip" id="post-share-22"' . checked(in_array(22,$socializemeta), true, false) . ' />' . __('LinkedIn') . '</label>	

</div>
    <div class="socialize-div2" style="width:50%; float: left;">
    	<strong>\'Call To Action\' Box Social Buttons</strong><br />
        <label class="selectit"><input value="11" type="checkbox" name="sm_twitter_fp" id="post-share-11"' . checked(in_array(11,$socializemeta), true, false) . ' />' . __('Twitter') . '</label><br />
        <label class="selectit"><input value="12" type="checkbox" name="sm_facebook_fp" id="post-share-12"' . checked(in_array(12,$socializemeta), true, false) . ' />' . __('Facebook') . '</label><br />
        <label class="selectit"><input value="13" type="checkbox" name="sm_digg_fp" id="post-share-13"' . checked(in_array(13,$socializemeta), true, false) . ' />' . __('Digg') . '</label><br />
        <label class="selectit"><input value="14" type="checkbox" name="sm_sphinn_fp" id="post-share-14"' . checked(in_array(14,$socializemeta), true, false) . ' />' . __('Sphinn') . '</label><br />
        <label class="selectit"><input value="15" type="checkbox" name="sm_reddit_fp" id="post-share-15"' . checked(in_array(15,$socializemeta), true, false) . ' />' . __('Reddit') . '</label><br />
        <label class="selectit"><input value="16" type="checkbox" name="sm_dzone_fp" id="post-share-16"' . checked(in_array(16,$socializemeta), true, false) . ' />' . __('Dzone') . '</label><br />
    	<label class="selectit"><input value="17" type="checkbox" name="sm_stumbleupon_fp" id="post-share-17"' . checked(in_array(17,$socializemeta), true, false) . ' />' . __('StumbleUpon') . '</label><br />
		<label class="selectit"><input value="18" type="checkbox" name="sm_delicious_fp" id="post-share-18"' . checked(in_array(18,$socializemeta), true, false) . ' />' .__('Delicious') . '</label><br />
		<label class="selectit"><input value="19" type="checkbox" name="sm_buzz_fp" id="post-share-19"' . checked(in_array(19,$socializemeta), true, false) . ' />' . __('Google Buzz') . '</label><br />
		<label class="selectit"><input value="20" type="checkbox" name="sm_yahoo_fp" id="post-share-20"' . checked(in_array(20,$socializemeta), true, false) . ' />' . __('Yahoo Buzz') . '</label><br />
		<label class="selectit"><input value="23" type="checkbox" name="sm_linkedin_fp" id="post-share-23"' . checked(in_array(23,$socializemeta), true, false) . ' />' . __('LinkedIn') . '</label>	

	</div>
	<div class="clear"></div>';
	$wrapped_content .= socialize_postbox('socialize-settings-default', 'Default Button Settings', $default_content);
	
	socialize_admin_wrap('Socialize Settings', $wrapped_content);
}

//=============================================
// Process contact page form data
//=============================================
function socialize_process_settings() {
	
	//print_r(get_option('socialize_settings10'));
	//echo $_POST['socialize_display_front'];
	
	if ( !empty($_POST['socialize_option_submitted']) ){
		//$socialize_settings=get_option('socialize_settings10');
		
		$socialize_settings = array();
		$socializemetaarray = array();
		
		if(strstr($_GET['page'],"socialize") && check_admin_referer('socialize-update-options')){
			if(isset($_POST['socialize_text'])){ $socialize_settings['socialize_text']=stripslashes($_POST['socialize_text']); }
			$color = preg_replace('/[^0-9a-fA-F]/', '', $_POST['socialize_alert_bg']);
			if ((strlen($color)==6||strlen($color) == 3)&&isset($_POST['socialize_alert_bg'])){ $socialize_settings['socialize_alert_bg']=$_POST['socialize_alert_bg']; }
			if(isset($_POST['socialize_display_front'])){ $socialize_settings['socialize_display_front']=$_POST['socialize_display_front']; }
			if(isset($_POST['socialize_display_archives'])){ $socialize_settings['socialize_display_archives']=$_POST['socialize_display_archives']; }
			if(isset($_POST['socialize_display_search'])){ $socialize_settings['socialize_display_search']=$_POST['socialize_display_search']; }
			if(isset($_POST['socialize_display_posts'])){ $socialize_settings['socialize_display_posts']=$_POST['socialize_display_posts']; }
			if(isset($_POST['socialize_display_pages'])){ $socialize_settings['socialize_display_pages']=$_POST['socialize_display_pages']; }
			if(isset($_POST['socialize_display_feed'])){ $socialize_settings['socialize_display_feed']=$_POST['socialize_display_feed']; }
			if(isset($_POST['socialize_alert_box'])){ $socialize_settings['socialize_alert_box']=$_POST['socialize_alert_box']; }
			if(isset($_POST['socialize_alert_box'])){ $socialize_settings['socialize_alert_box']=$_POST['socialize_alert_box']; }
			if(isset($_POST['socialize_alert_box_pages'])){ $socialize_settings['socialize_alert_box_pages']=$_POST['socialize_alert_box_pages']; }
			if(isset($_POST['socialize_twitterWidget'])){ $socialize_settings['socialize_twitterWidget']=$_POST['socialize_twitterWidget']; }
			if(isset($_POST['socialize_float'])){ $socialize_settings['socialize_float']=$_POST['socialize_float']; }
			if(isset($_POST['socialize_fbWidget'])){ $socialize_settings['socialize_fbWidget']=$_POST['socialize_fbWidget']; }
			if(isset($_POST['socialize_twitter_source'])){ $socialize_settings['socialize_twitter_source']=$_POST['socialize_twitter_source']; }
			if(isset($_POST['sm_twitter_ip']) && ($_POST['sm_twitter_ip']>0)){ array_push($socializemetaarray, $_POST['sm_twitter_ip']); }
			if(isset($_POST['sm_facebook_ip']) && ($_POST['sm_facebook_ip']>0)){ array_push($socializemetaarray, $_POST['sm_facebook_ip']); }
			if(isset($_POST['sm_digg_ip']) && ($_POST['sm_digg_ip']>0)){ array_push($socializemetaarray, $_POST['sm_digg_ip']); }
			if(isset($_POST['sm_sphinn_ip']) && ($_POST['sm_sphinn_ip']>0)){ array_push($socializemetaarray, $_POST['sm_sphinn_ip']); }
			if(isset($_POST['sm_reddit_ip']) && ($_POST['sm_reddit_ip']>0)){ array_push($socializemetaarray, $_POST['sm_reddit_ip']); }
			if(isset($_POST['sm_dzone_ip']) && ($_POST['sm_dzone_ip']>0)){ array_push($socializemetaarray, $_POST['sm_dzone_ip']); }
			if(isset($_POST['sm_stumbleupon_ip']) && ($_POST['sm_stumbleupon_ip']>0)){ array_push($socializemetaarray, $_POST['sm_stumbleupon_ip']); }
			if(isset($_POST['sm_delicious_ip']) && ($_POST['sm_delicious_ip']>0)){ array_push($socializemetaarray, $_POST['sm_delicious_ip']); }
			if(isset($_POST['sm_buzz_ip']) && ($_POST['sm_buzz_ip']>0)){ array_push($socializemetaarray, $_POST['sm_buzz_ip']); }
			if(isset($_POST['sm_yahoo_ip']) && ($_POST['sm_yahoo_ip']>0)){ array_push($socializemetaarray, $_POST['sm_yahoo_ip']); }
			if(isset($_POST['sm_linkedin_ip']) && ($_POST['sm_linkedin_ip']>0)){ array_push($socializemetaarray, $_POST['sm_linkedin_ip']); }
			if(isset($_POST['sm_twitter_fp']) && ($_POST['sm_twitter_fp']>0)){ array_push($socializemetaarray, $_POST['sm_twitter_fp']); }
			if(isset($_POST['sm_facebook_fp']) && ($_POST['sm_facebook_fp']>0)){ array_push($socializemetaarray, $_POST['sm_facebook_fp']); }
			if(isset($_POST['sm_digg_fp']) && ($_POST['sm_digg_fp']>0)){ array_push($socializemetaarray, $_POST['sm_digg_fp']); }
			if(isset($_POST['sm_sphinn_fp']) && ($_POST['sm_sphinn_fp']>0)){ array_push($socializemetaarray, $_POST['sm_sphinn_fp']); }
			if(isset($_POST['sm_reddit_fp']) && ($_POST['sm_reddit_fp']>0)){ array_push($socializemetaarray, $_POST['sm_reddit_fp']); }
			if(isset($_POST['sm_dzone_fp']) && ($_POST['sm_dzone_fp']>0)){ array_push($socializemetaarray, $_POST['sm_dzone_fp']); }
			if(isset($_POST['sm_stumbleupon_fp']) && ($_POST['sm_stumbleupon_fp']>0)){ array_push($socializemetaarray, $_POST['sm_stumbleupon_fp']); }
			if(isset($_POST['sm_delicious_fp']) && ($_POST['sm_delicious_fp']>0)){ array_push($socializemetaarray, $_POST['sm_delicious_fp']); }
			if(isset($_POST['sm_buzz_fp']) && ($_POST['sm_buzz_fp']>0)){ array_push($socializemetaarray, $_POST['sm_buzz_fp']); }
			if(isset($_POST['sm_yahoo_fp']) && ($_POST['sm_yahoo_fp']>0)){ array_push($socializemetaarray, $_POST['sm_yahoo_fp']); }
			if(isset($_POST['sm_linkedin_fp']) && ($_POST['sm_linkedin_fp']>0)){ array_push($socializemetaarray, $_POST['sm_linkedin_fp']); }
			
			echo "<div id=\"updatemessage\" class=\"updated fade\"><p>Socialize settings updated.</p></div>\n";
			echo "<script type=\"text/javascript\">setTimeout(function(){jQuery('#updatemessage').hide('slow');}, 3000);</script>";	
			
			$socializemeta = implode(',', $socializemetaarray);
			$socialize_settings['sharemeta']=$socializemeta;
			
			update_option('socialize_settings10', $socialize_settings);
		}
	}//updated
	$socialize_settings=get_option('socialize_settings10');
	return $socialize_settings;
}

//=============================================
// admin options panel
//=============================================
function add_socialize_options_subpanel() {
	if (function_exists('add_options_page')) {
	  add_options_page('Socialize', 'Socialize', 'manage_options', __FILE__, 'socialize_general_settings');
	}
}

//=============================================
// Create postbox for admin
//=============================================	
function socialize_postbox($id, $title, $content) {
	$postbox_wrap = "";
	$postbox_wrap .= '<div id="' . $id . '" class="postbox">';
	$postbox_wrap .= '<div class="handlediv" title="Click to toggle"><br /></div>';
	$postbox_wrap .= '<h3 class="hndle"><span>' . $title . '</span></h3>';
	$postbox_wrap .= '<div class="inside">' . $content . '</div>';
	$postbox_wrap .= '</div>';
	return $postbox_wrap;
}	

//=============================================
// Admin page wrap
//=============================================	
function socialize_admin_wrap($title, $content) {
?>
    <div class="wrap">
        <h2><?php echo $title; ?></h2>
        <form method="post" action="">
            <div class="postbox-container" style="width:60%;">
                <div class="metabox-holder">	
                    <div class="meta-box-sortables">
                    <?php
                        echo $content;
                    ?>
                    <p class="submit"> 
                        <input type="submit" name="socialize_option_submitted" class="button-primary" value="Save Changes" /> 
                    </p> 
                    </div>
                  </div>
                </div>
                <div class="postbox-container" style="width:30%;">
                  <div class="metabox-holder">	
                    <div class="meta-box-sortables">
                    <?php
						echo socialize_show_donate();
                        echo socialize_show_plugin_support();
                        echo socialize_show_blogfeed();
                    ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php
}
?>