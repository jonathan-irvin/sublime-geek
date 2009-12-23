<div id="allsidebars">

<div class="sidebarswrapper"><div class="sidebars">

<?php if (get_option('greeting') || get_option('welcomemessage')) {
  echo "<div id='welcome'>";
  if (get_option('greeting')) {
    echo "<h2>" . get_option('greeting') . "</h2>";
    }
  if (get_option('welcomemessage')) {
    echo "<p>" . get_option('welcomemessage') . "</p>";
    }
  echo "</div>";
  } else {
  echo "<div id='welcome'><h2>Welcome!</h2><p>To customize this message, please go to your Admin panel and find Presentation->Theme Options. Modify at will!</p></div>";
}
 
?>

<div class="sidebarsbottom"></div>
</div> <!-- Closes Sidebars -->
</div> <!-- Closes SidebarsWrapper -->



<div class="sidebarsB">

<div class="adsense_sidebar"><?php include (TEMPLATEPATH . '/adsense_sidebar336.php'); ?></div>


<div class="sidebar1">
<ul>

<li>
<h2>Categories</h2>
<ul>
  <?php wp_list_categories('show_count=0&title_li='); ?>
</ul>
</li>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar1') ) : ?>

<li>
<h2>Meta</h2>
<ul>
  <?php wp_register(); ?>
  <li><?php wp_loginout(); ?></li>
  <li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
  <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
  <?php wp_meta(); ?>
</ul>
</li>

<?php endif; ?>

<li>
<h2>Sponsors</h2>
<?php include (TEMPLATEPATH . '/adsense_sidebar160.php'); ?>
</li>

</ul>

</div> <!-- Closes Sidebar1 -->

<div class="sidebar2">

<ul>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar2') ) : ?>

<li>
<h2>Blogroll</h2>
<ul>
  <?php get_links('-1', '<li>', '</li>'); ?>
</ul>
</li>

<li>
<h2>Archives</h2>
<ul>
  <?php wp_get_archives('type=monthly'); ?>
</ul>
</li>

<li>
<h2>Tag Cloud</h2>
<?php wp_tag_cloud(''); ?>
</li>

<?php endif; ?>
</ul>

</div> <!-- Closes Sidebar2 -->
<div class="cleared"></div>
</div> <!-- Closes SidebarsB -->


</div> <!-- Closes allsidebars -->