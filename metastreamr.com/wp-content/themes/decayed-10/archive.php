<?php get_header(); ?>

	<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
	<h1 class="decay"><?php echo single_cat_title(); ?></h1>

 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h1 class="decay">Archive for <?php the_time('F jS, Y'); ?></h1>

	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h1 class="decay">Archive for <?php the_time('F, Y'); ?></h1>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h1 class="decay">Archive for <?php the_time('Y'); ?></h1>

	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h1 class="decay">Author Archive</h1>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h1 class="decay">Blog Archives</h1>

		<?php } ?>

	<div class="left"><?php next_posts_link('&laquo; Previous Entries') ?></div>
	<div class="right"><?php previous_posts_link('Next Entries &raquo;') ?></div>
	<div class="clearer"><span></span></div>

		<?php while (have_posts()) : the_post(); ?>
	<div class="post">

		<h1 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>

		<div class="descr"><?php the_time('l F jS, Y') ?> in <?php the_category(', ') ?> | <?php edit_post_link('Edit post', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></div>

	</div>

		<?php endwhile; ?>

	<div class="left"><?php next_posts_link('&laquo; Previous Entries') ?></div>
	<div class="right"><?php previous_posts_link('Next Entries &raquo;') ?></div>
	<div class="clearer"><span></span></div>

	<?php else : ?>

	<h2 class="decay">Not Found</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
