<?php


if ( function_exists('register_sidebars') )
 register_sidebars(2,array(
        'before_widget' => '',
    'after_widget' => '',
 'before_title' => '<h1>',
        'after_title' => '</h1>',
    ));


// WP-darks Pages Box  
 function widget_dark_pages() {
?>

<h1><?php _e('Pages'); ?></h1>
   <ul>
<li class="page_item"><a href="<?php bloginfo('url'); ?>">Home</a></li>

<?php wp_list_pages('title_li='); ?>

 </ul>

<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Pages'), 'widget_dark_pages');


// WP-darks Search Box  
 function widget_dark_search() {
?>
   <ul>

<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>">

<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" /><input type="submit" id="sidebarsubmit" value="Search" />

 </form>

 </ul>

<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_dark_search');

// WP-dark Blogroll  
 function widget_dark_blogroll() {
?>

<h1><?php _e('Blogroll'); ?></h1>

<ul>

<?php get_links(-1, '<li>', '</li>', '', FALSE, 'name', FALSE, FALSE, -1, FALSE); ?>

</ul>

<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Blogroll'), 'widget_dark_blogroll');
 
// WP-dark Links  
 function widget_dark_links() {
?>

<h1><?php _e('Links'); ?></h1>

<ul>

<?php get_links(-1, '<li>', '</li>', '', FALSE, 'name', FALSE, FALSE, -1, FALSE); ?>

</ul>

<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Links'), 'widget_dark_links');


?>