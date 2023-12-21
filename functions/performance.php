<?php
/**
 * Theme performance
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Fix: Notice: ob_end_flush(): failed to send buffer of zlib output compression.
if ( '1' === ini_get( 'zlib.output_compression' ) ) {
	/**
	 * Proper ob_end_flush() for all levels
	 *
	 * This replaces the WordPress `wp_ob_end_flush_all()` function
	 * with a replacement that doesn't cause PHP notices.
	 */
	remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
}

add_filter(
	'post_thumbnail_html',
	function ( $html, $post_id, $post_image_id, $size, $attr ) {

		$anony_options = ANONY_Options_Model::get_instance();

		$lightbox_library = 'lightbox';

		$library_attribute = ( 'prettyphoto' === $lightbox_library ) ? 'rel="prettyPhoto"' : 'data-lightbox="image-' . $post_image_id . '"';

		$html = '<a href="' . get_the_post_thumbnail_url( $post_id, 'full' ) . '" ' . $library_attribute . ' title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . wp_get_attachment_image( $post_image_id, $size, false, $attr ) . '</a>';

		return $html;
	},
	10,
	5
);
