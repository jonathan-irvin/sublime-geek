<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php wp_head(); ?>
</head>
<body>
<?php 
get_header();
?>
<div id="main">
<div id="menu">
<?php get_sidebar(); ?>
</div>
<div id="menu2">
<?php include (TEMPLATEPATH . '/sidebar2.php'); ?>
</div>
<div id="content">
<?php if (have_posts()) : ?>
		
	<?php while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<a href="<?php the_permalink() ?>" rel="bookmark" class="postlink" title="<?php bloginfo('name');?>: <?php the_title(); ?>"><?php the_title(); ?></a><br/>
			<span class="postdata">Posted on <?php the_time('F jS, Y') ?> at <?php the_time('g:i a'); ?> by <?php the_author() ?></span>
			
			<div class="entry">
				<?php the_content('Read the rest of this entry &raquo;'); ?>
			</div>
	
			<div class="cats"><p class="postmetadata">Posted in <?php the_category(', ') ?> <strong>|</strong> <?php edit_post_link('Edit','','<strong>|</strong>'); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p><div class="divider"></div></div>
		</div>

	<?php comments_template(); ?>
	<?php endwhile; ?>

		<p align="center"><?php next_posts_link('&laquo; Previous Entries') ?> &nbsp; <?php previous_posts_link('Next Entries &raquo;') ?></p>

	<?php else : ?>
		<h2 align="center">Not Found</h2>
		<p align="center">Sorry, but you are looking for something that isn't here.</p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
</div>
</body>
</html>