<?php
/*
Plugin Name: WP Chiclets
Plugin URI: http://www.tsaiberspace.net/projects/wordpress/wp-chiclets/
Description: Sidebar widget with various RSS chiclets. Navigate to <a href="widgets.php">Presentation &rarr; Widgets</a> to add to your sidebar.
Author: Robert Tsai
Author URI: http://www.tsaiberspace.net/
Version: 1.2.3
*/

function widget_wpchiclets_init() {
	if ( !function_exists('register_sidebar_widget') )
		return;

	function widget_wpchiclets($args) {
		extract($args);

		$options = get_option('widget_wpchiclets');
		$wpchiclets_title = $options['wpchiclets_title'];

		$rsspng = get_bloginfo('wpurl') . '/wp-includes/images/rss.png';

		$encoded_blogname = urlencode(get_bloginfo('name'));

		$feedurl = get_feed_link('rss2');
		$commentsfeedurl = get_feed_link('comments_rss2');

		print <<<EOM

$before_widget
  $before_title$wpchiclets_title$after_title
  <!-- wp-chiclets: http://www.tsaiberspace.net/projects/wordpress/wp-chiclets/ -->
  <ul>
    <li><a href="$feedurl" title="Syndicate the latest posts"><img src="$rsspng" alt="" /> Posts</a> | <a href="$commentsfeedurl" title="Syndicate the latest comments"><img src="$rsspng" alt="" /> Comments</a></li>
    <li><a href="http://fusion.google.com/add?feedurl=$feedurl" title="Add to Google"><img src="http://buttons.googlesyndication.com/fusion/add.gif" alt="Add to Google" /> </a></li>
    <li><a href="http://us.rd.yahoo.com/my/atm/$encoded_blogname/$encoded_blogname/*http://add.my.yahoo.com/rss?url=$feedurl" title="Add to My Yahoo!"><img src="http://us.i1.yimg.com/us.yimg.com/i/us/my/addtomyyahoo4.gif" alt="Add to My Yahoo!" /> </a></li>
    <li><a href="http://www.bloglines.com/sub/$feedurl" title="Subscribe with Bloglines"><img src="http://www.bloglines.com/images/sub_modern11.gif" alt="Subscribe with Bloglines" /> </a></li>
    <li><a href="http://technorati.com/faves?add=$feedurl" title="Add to Technorati Favorites"><img src="http://static.technorati.com/pix/fave/tech-fav-5.gif" alt="Add to Technorati Favorites" /> </a></li>
    <li><a href="http://www.netvibes.com/subscribe.php?url=$feedurl" title="Add to netvibes"><img src="http://www.netvibes.com/img/add2netvibes.gif" alt="Add to netvibes" /> </a></li>
    <li><a href="http://www.rojo.com/add-subscription?resource=$feedurl" title="Add to My Rojo"><img src="http://blog.rojo.com/RojoWideRed.gif" alt="Add to My Rojo" /> </a></li>
    <li><a href="http://www.newsgator.com/ngs/subscriber/subext.aspx?url=$feedurl" title="Subscribe with NewsGator"><img src="http://www.newsgator.com/images/ngsub1.gif" alt="Subscribe with NewsGator" /> </a></li>
    <li><a href="http://feeds.my.aol.com/add.jsp?url=$feedurl" title="Add to My AOL"><img src="http://cdn.digitalcity.com/channels/icon_myaol" alt="Add to My AOL" /> </a></li>
    <li><a href="http://www.live.com/?add=$feedurl" title="Add to Windows Live Favorites"><img src="http://stc.msn.com/br/gbl/css/6/decoration/wl_add_feed.gif" alt="Add to Windows Live Favorites" /> </a></li>
    <li><a href="http://my.msn.com/addtomymsn.armx?id=rss&amp;ut=$feedurl" title="Add to My MSN"><img src="http://stc.msn.com/br/gbl/css/6/decoration/rss_my.gif" alt="Add to My MSN" /> </a></li>
  </ul>
$after_widget

EOM;
	}

	function widget_wpchiclets_control() {
		$options = get_option('widget_wpchiclets');
		if ( !is_array($options) )
			$options = array('wpchiclets_title'=>'Subscribe');
		if ( $_POST['wpchiclets-submit'] ) {
			$options['wpchiclets_title'] = strip_tags(stripslashes($_POST['wpchiclets-wpchiclets_title']));
			update_option('widget_wpchiclets', $options);
		}

		$wpchiclets_title = htmlspecialchars($options['wpchiclets_title'], ENT_QUOTES);
		echo '<p style="text-align:center;"><label for="wpchiclets-title">Title: <input style="width: 100%;" id="wpchiclets-title" name="wpchiclets-wpchiclets_title" type="text" value="'.$wpchiclets_title.'" /></label></p>';
		echo '<input type="hidden" id="wpchiclets-submit" name="wpchiclets-submit" value="1" />';
	}
	
	register_sidebar_widget('WP Chiclets', 'widget_wpchiclets');
	register_widget_control('WP Chiclets', 'widget_wpchiclets_control',
		300, 90);
}

function widget_wpchiclets_deactivate() {
	delete_option('widget_wpchiclets');
}

register_deactivation_hook(__FILE__, 'widget_wpchiclets_deactivate');
add_action('plugins_loaded', 'widget_wpchiclets_init');

?>
