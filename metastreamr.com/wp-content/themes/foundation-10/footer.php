<div id="foot"><br /><form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div>
 <input type="text" name="s" id="search" size="15" />
 <input type="submit" id="searchbutton" value="<?php _e('search'); ?>" />
</div>
</form>
<span class="credit"><?php echo $wpdb->num_queries; ?> queries. <?php timer_stop(1); ?> seconds.<br/>powered by <a href="http://www.wordpress.org">wordpress</a> <?php bloginfo('version'); ?> | theme by <a href="http://www.tonystreet.com" target="_blank">tony</a></span></div><!-- please leave the theme credit there. feel free to add something like 'modified by John Doe'. -->