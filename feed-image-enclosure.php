<?php
/*
Plugin Name: Feed Image Enclosure
Plugin URI: https://github.com/kasparsd/
Description: Add featured images as enclosures in RSS feeds
Version: 0.2.2
Author: Kaspars Dambis
Author URI: http://konstruktors.com
License: GPL2
*/

add_action( 'rss2_item', 'add_post_featured_image_as_rss_item_enclosure' );

function add_post_featured_image_as_rss_item_enclosure( $post_id=0 ) {
	global $post;
	$post_id = $post_id ? $post_id : $post->ID;

	if ( ! has_post_thumbnail( $post_id ) )
		return;

	$thumb_id = get_post_thumbnail_id( $post_id );
	
	// Get image meta data and create an object out of it (WordPress returns just an array);
	$thumb_srcdata = wp_get_attachment_image_src( $thumb_id, 'thumbnail-size', false );
	$image = array(
		'src' => $thumb_srcdata[0],
		'width' => $thumb_srcdata[1],
		'height' => $thumb_srcdata[2],
		'resized' => $thumb_srcdata[3],
	);

	printf( 
		'<enclosure url="%s" length="%s" type="%s" />',
		$image['src'], 
		"1337", // filesize( path_join( $upload_dir['basedir'], $thumbnail['path'] ) ), 
		get_post_mime_type( $thumb_id ) 
	);
}
