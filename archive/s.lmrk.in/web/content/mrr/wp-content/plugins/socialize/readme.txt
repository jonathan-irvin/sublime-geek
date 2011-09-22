=== Socialize ===
Contributors: JonBishop
Donate link: http://www.jonbishop.com/donate/
Tags:  socialize, bookmark, post, posts, admin, page, digg, facebook, twitter, delicious, Digg, seo, button, buzz, google buzz, google, sharing, stumbleupon, posting, saving, sharethis, share, bookmarking, bookmarks menu, social, social bookmarking, yahoo, Reddit, sexybookmarks, sphinn, dzone, meta, linkedin
Requires at least: 2.7
Tested up to: 3.0.1
Stable tag: 1.3.1

Provides an easy way to selectively add actionable social bookmarks to your posts content or below the post in a 'Call To Action' box.

== Description ==

Socialize is an easy way to selectively add actionable social bookmarks to your posts. 

You can add bookmarks in two places:

1. Inside the content (aligned left or right)
1. In a box below the content

The plugin was designed to make managing and adding actionable social bookmarks easier and more efficient. Instead of adding new meta keys like other plugins require, there is an additional panel in your posts admin that allows you to select which bookmarks you want to display. This is to encourage people to choose more relevant bookmarks for their posts. By only displaying the more relevant and socially successful posts, you create a form of social proof that might encourage more shares, comments and subscriptions.

You are also provided with a box at the bottom of your posts that asks readers to subscribe and comment. This text can be edited in the 'Socialize Admin Page' and on individual posts/pages. You can also selectively display social bookmarks in this box the same way you go about inserting bookmarks in content. This is a great place to ask your readers to do something, like check out one of your services or to leave a comment and subscribe.

Furthermore, you can choose to display bookmarks in the content on all pages or just on single pages. You can also choose to hide the box that displays beneath the posts by default.

== Installation ==

1. Upload the 'socialize' folder to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Tweak your settings under 'Socialize' in your settings panel
1. (optional) Choose some default bookmarks to display on existing posts
1. Selectively display bookmarks at your will


== Frequently Asked Questions ==

= Can I change the background color of the 'Call To Action' box? =

Of course your can. It's one of the choice settings available to you in the settings panel.

= What if I don't want bookmarks to show up? =

Load the page/pages in question and make sure there are no checkboxes checked in the 'Socialize' panel of the post.

= Can I hide the 'Call To Action' box on specific pages? =

Load the page/pages in question and check 'Hide Call To Action Box below this post' in the 'Socialize' panel of the post.

= How do I change @tweetmeme/@backtype to my own Twitter username? =

Change the "Twitter Source" in the Socialize settings panel

= Why are there two Facebook Buttons? =

One is the official Facebook button and the other is the unofficial fbShare.me button. I prefer the fbShare.me button because it displays at full height when there are no shares where the official button shrinks when there are no shares.

= Why do the buttons display in weird locations when I have a lot of buttons displayed? =

Because you can only display as many buttons that will fit within the width of the 'Call To Action' box. Besides, displaying too many buttons defeats the purpose of this plugin. Try to display less than three (3) buttons in each area. This will increase page load time and will look a lot prettier.


== Screenshots ==

1. Some buttons in the content
2. The box displays below posts
3. The post module where you can select what buttons to display
4. The settings panel


== Changelog ==

The current version is 1.3.1 (2010.11.30)

= 1.3.1 (2010.11.30) =
* Fixed LinkedIn javascript

= 1.3 (2010.11.30) =
* Added LinkedIn button
* Cleaned up CSS
* Added option to not display 'Call To Action' box on pages

= 1.2.3 (2010.11.15) =
* Fixed bug in socialize.php in socialize_metabox_action_admin(), variables not loaded properly

= 1.2.2 (2010.11.15) =
* Added unneeded returns to readme.txt

= 1.2.1 (2010.11.15) =
* Used wrong WordPress version in 'Tested up to' in readme.txt

= 1.2 (2010.11.15) =
* Renamed 'Alert Box' to 'Call to Action' Box and edited readme.txt to match
* Re-designed settings page with collapsible drag and drop boxes to organize content
* Moved 'Please Domate' area in settings page
* Added Support area to settings page
* Added Tips and Tricks to settings page
* Added 'Call to Action' meta box to posts and pages so poster can change the call to action for a specific post/page
* Added official Twitter count button
* Added Topsy button
* Added Facebook Like button
* Added additional security to forms and data
* Added color picker to admin
* Updated header css with wp_enqueue_style

= 1.1.5 (2010.06.28) =
* SVN glitch

= 1.1.4 (2010.06.25) =
* Fixed issue where default Google/Yahoo Buzz options didn't work

= 1.1.3 (2010.06.22) =
* Fixed glith where alert box would only display if inline buttons were bing displayed
* Fixed CSS glitch with delicious inline button
* Removed unneccesary calls to displayButtons()

= 1.1.2 (2010.06.18) =
* Added current_theme_supports('post-thumbnails') to prevent error when no featured image

= 1.1.1 (2010.06.18) =
* SVN glitch

= 1.1 (2010.06.18) =
* Fixed Delicious button

= 1.0 (2010.06.18) =
* Commented out javascript
* Added security to page meta box
* Added Yahoo Buzz and Google Buzz buttons
* Removed custom facebook button and replaced with official Facebook Share button
* Created Delicious button with save count
* Provided options to float in-content buttons to right or left
* Provided options to display buttons on different pages
* Added option to hide alert box on specific pages
* Fixed CSS
* Plugin now updates upon activation and keeps record of version
* Buttons can now be displayed in feeds

= 0.4 (2010.03.29) =
* Added wp_is_post_revision() and wp_is_post_autosave() to prevent WordPress from trying to save empty data when 

autosaving
* Can now add buttons to pages

= 0.3 (2009.10.06) =
* Fixed default options code

= 0.2 =
* Added http://www.fbshare.me widget
* Added backtype Tweetcount Widget
* Added new settings for Twitter Source
* Added default settings

= 0.1 =
* Plugin released