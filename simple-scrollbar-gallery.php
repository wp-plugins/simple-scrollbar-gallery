<?php
/*
Plugin Name: simple scrollbar gallery
Version: 1.7
Description: Replaces the builtin [gallery] with a simple jQuery script. Still integrated in the page without any popups.
Author: Thomas Schmidt
Author URI:http://www.netaction.de/
Plugin URI: http://wordpress.org/extend/plugins/simple-scrollbar-gallery/
*/

if (!is_admin()) {
	load_plugin_textdomain('simple_scrollbar_gallery', NULL, dirname(plugin_basename(__FILE__)));
	add_shortcode('gallery', 'simple_scrollbar_gallery');
	add_action('wp_head', 'simple_scrollbar_gallery_header');
	add_action('init', 'simple_scrollbar_gallery_enqueue_scripts');
}


/*****************************
* Enqueue jQuery & Scripts
*/
function simple_scrollbar_gallery_enqueue_scripts() {
	if ( function_exists('plugin_url') )
		$plugin_url = plugin_url();
	else
		$plugin_url = get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));

	// jquery
	wp_deregister_script('jquery');
	wp_register_script('jquery', ($plugin_url  . '/jquery-1.4.2.min.js'), false, '1.4.2');
	wp_enqueue_script('jquery');
}


function simple_scrollbar_gallery_header() {
	if ( function_exists('plugin_url') )
		$plugin_url = plugin_url();
	else
		$plugin_url = get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));

	/**
	* Initialize
	*/
	echo "<script type='text/javascript'>
	var active,element,mouseX;
	function scroller() {
		var x = (mouseX - element.offset().left) / element.width() - 0.5;

		x=Math.round(x*x*x*60);

		element.scrollLeft(element.scrollLeft()+x);
	}
	$(function() {

		$('.gallery .gallery-list').mousemove( function(e) { mouseX = e.pageX; });
		$('.gallery .gallery-list').css('white-space','nowrap').css('overflow','hidden');
		$('.gallery .gallery-list a').mouseover(function() {  // load big image
			$(this).parent().parent().children(':first').attr('src',$(this).attr('href'));
		});
		$('.gallery .gallery-list a').click(function() {  // disable mouseclick
			return false;
		});
		$('.gallery .gallery-list').mouseenter(function() {  // start scrolling
			element=$(this);
			active=setInterval('scroller()', 20);
		});
		$('.gallery .gallery-list').mouseleave(function() {  // stop scrolling
			clearInterval(active);
		});
	});
</script>
";
}




function simple_scrollbar_gallery($output, $attr) {

	/**
	* Grab attachments
	*/
	global $post;
	
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
	
	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
	), $attr));

	$id = intval($id);
	$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	
	if ( empty($attachments) )
		return '';
		
	if ( is_feed() ) { // link to medium image in feeds
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link($id, 'medium', true) . "\n";
		return $output;
	}
	


	/**
	* start output
	*/
	$output = "<!-- begin simple scrollbar gallery -->\n	<div class='gallery'>\n";

	/**
	* first big image
	*/
	$output .= "	".wp_get_attachment_image(key($attachments),"large")."\n";

	/**
	* thumbnails
	*/
	$output .= "	<div class='gallery-list'>\n";
	foreach ( $attachments as $id => $attachment ) {
		$big_image = wp_get_attachment_image_src($id, 'large'); // url of big image
//		$thumbnail_image = wp_get_attachment_image_src($id,"thumbnail"); // url of thumbnail
		$output .= "		<a href=\"".$big_image[0]."\">\n";
		$output .= "				".wp_get_attachment_image($id,"thumbnail")."\n";
		$output .= "		</a>\n";
	}
	$output .= "	</div></div>\n";

	/**
	* end output
	*/
	$output .= "<!-- end simple scrollbar gallery -->\n";


	return $output;

}

?>
