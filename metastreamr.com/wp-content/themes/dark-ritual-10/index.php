<?php get_header(); ?>


	<div class="main_right">
<?php include (TEMPLATEPATH.'/right.php') ?>
	</div>
<?php get_sidebar(); ?>
	
	<div class="main">

		<div class="padded">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

<div class="post" id="post-<?php the_ID(); ?>">

<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>

<p class="meta"><?php the_time('F jS, Y') ?> by <?php the_author() ?></p>

<div class="entry">

<?php the_content('Read the rest of this entry &raquo;'); ?>

</div>

<p class="info">Posted in <?php the_category(', ') ?> <strong>|</strong> <?php edit_post_link('Edit','','<strong>|</strong>'); ?> <?php comments_popup_link('Talk About It! &raquo;', '1 Comment &raquo;', '% Comments &raquo;'); ?></p>

</div>

<?php comments_template(); ?>

<?php endwhile; ?>

<p align="center"><?php next_posts_link('&laquo; Previous Entries') ?> <?php previous_posts_link('Next Entries &raquo;') ?></p>

<?php else : ?>

<h2 align="center">Not Found</h2>

<p align="center">Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>
				
		</div>

	</div>
	
	<div class="clearer"><span></span></div>
<?php get_footer(); ?>
</div>

//BEGIN SL MARKETING BANNER CODE
<div align="center">

<a href='http://slmarketing.us/modules/phpads/adclick.php?n=ace1dcdc' target='_blank'><img src='http://slmarketing.us/modules/phpads/adview.php?what=zone:28&amp;n=ace1dcdc' border='0' alt=''></a></div>
//END SL MARKETING BANNER CODE

	
</body>

</html>