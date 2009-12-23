<!-- Begin sidebar 2 -->
<?php if(!is_single()) { /* If we're displaying this on any page but a single post page, then... */ ?>
<!-- (Not a single post) --> <?php /* Just an HTML debugging comment. Optional. */ ?>
<div id="aboutbar"></div>
<br/><?php bloginfo('description'); ?><br/>

<!-- The code below is disabled. When enabled, it will show a "briefs" section of the page. -->
<!-- To enable it, remove this comment, and the comment above the flickr stuff.

<div id="briefsbar"></div>
<?php $my_query = new WP_Query('category_name=shorts&showposts=2');
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID; ?>
<a href="<?php the_permalink(); ?>" class="postlink" title="View more of <?php the_title();?>"><?php the_title(); ?></a> - <?php comments_popup_link('(0)', '(1)', '(%)'); ?>
<?php the_excerpt();?>
<?php rewind_posts(); ?>
<?php endwhile; ?>

  The code above is disabled. Read up to enable it. -->

<div id="flickrbar"></div>
<?php
/* Will grab photos with the specified tag randomly from Flickr. */

$numberofphotos = "5"; /* Must be numerical. Default is "5". */
$tag = "blackandwhite"; /* Must be one word, no spaces. Default is "blackandwhite". */

?>
<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $numberofphotos;?>&amp;display=random&amp;size=t&amp;layout=x&amp;source=all_tag&amp;tag=<?php echo $tag;?>"></script>

<?php } else { /* But if we _are_ displaying this on a single post page, then... */ ?>
<!-- (A single post) --> <?php /* Again, just an HTML debugging comment; Optional. */ ?>
<div id="sidebarpostdata">
Posted on <?php the_time('F jS, Y') ?> at <?php the_time('g:i a'); ?> by <?php the_author() ?> in <?php the_category(', ') ?>. There's <?php comments_number('zero responses','one response','% responses'); ?> for this post.
</div>
<?php } /* End all the if's. */ ?>

<!-- End sidebar 2 -->