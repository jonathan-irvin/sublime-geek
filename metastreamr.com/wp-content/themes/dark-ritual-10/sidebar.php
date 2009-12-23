<div class="subnav">
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar(1) ) : ?>
		
		
		<?php if (function_exists('wp_theme_switcher')) { ?>

<h1>Themes</h1>

<?php wp_theme_switcher('dropdown'); ?>

<?php } ?>


		<h1><?php _e('Pages');?></h1>
		<ul>

<li class="page_item"><a href="<?php bloginfo('url'); ?>">Home</a></li>

<?php wp_list_pages('title_li='); ?>

</ul>



		<h1><?php _e('Categories');?></h1>
		<ul>

<?php wp_list_cats('sort_column=name&hierarchical=0'); ?>

</ul>

		<h1><?php _e('Archives');?></h1>
	<ul>

<?php wp_list_cats('sort_column=name&hierarchical=0'); ?>

</ul>
		
		
				<h1><?php _e('Blogroll');?></h1>
	<ul>

<?php get_links(-1, '<li>', '</li>', '', FALSE, 'name', FALSE, FALSE, -1, FALSE); ?>

</ul> 

<?php endif; ?>
	</div>
		