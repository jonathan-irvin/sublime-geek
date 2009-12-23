<?php get_header(); ?>

	<div id="content" class="widecolumn">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>

<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			<div class="entrytext">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
	
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
	
			</div>
		</div>
<?php comments_template(); ?>
	  <?php endwhile; endif; ?>
	
	</div>

<?php get_footer(); ?>