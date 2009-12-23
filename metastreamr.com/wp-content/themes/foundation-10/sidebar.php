<!-- begin sidebar -->

    <!--  START LINKS LIST  -->
<div id="linksbar"></div>
    <?php get_linksbyname('', '', '<br />', '', TRUE, 'name', FALSE, TRUE); ?>
    <!--  END LINKS LIST  -->
    <br/>
    <!--  START CATEGORIES  -->
<div id="catsbar"></div>
    <ul><?php wp_list_cats(); ?></ul>
    <!--  END CATEGORIES  -->
    <br/>
    <!--  START ARCHIVES  -->
<div id="archivesbar"></div>
     <ul><?php wp_get_archives('type=monthly'); ?></ul>
    <!--  END ARCHIVES  -->
    <br/>
    <!--  START META  -->
<div id="metabar"></div><br/>
        <?php wp_register(); ?>
        <?php wp_loginout(); ?><br/>
        <a href="feed:<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a><br/>
        <a href="feed:<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a><br/>
        <?php wp_meta(); /* do not remove this line */ ?>
    <!--  END META  -->
    <br/>
<?php if (function_exists('wp_theme_switcher')) { ?>
    <!--  START THEME SWITCHER -->
<div id="themesbar"></div>
<?php wp_theme_switcher(); ?>
    <!--  END THEME SWITCHER  -->
<?php } ?>
<!-- end sidebar -->