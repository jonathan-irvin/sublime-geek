<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<div style="text-align:left;"><input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
<input type="submit" id="searchsubmit" value="Search" />
</div>
</form>
