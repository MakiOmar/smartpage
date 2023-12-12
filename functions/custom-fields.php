<?php
/**
 * Meta boxes registration
 *
 * @package Anonymous Meta box
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


// Array of metaboxes to register.
add_filter(
	'anony_metaboxes',
	function ( $metaboxes ) {
		$metaboxes[] =
		array(
			'id'            => 'anony_download', // Meta box ID.
			'title'         => esc_html__( 'Downloads', 'smartpage' ),
			'context'       => 'normal',
			'priority'      => 'high', // high|low.
			'hook_priority' => '10', // Default 10.
			'post_type'     => array( 'anony_download' ),
			'tapped'        => true,
			'fields'        =>
					array(
						array(
							'id'       => 'anony_download_attachment',
							'title'    => esc_html__( 'Download file', 'smartpage' ),
							'type'     => 'file_upload',
							'validate' => 'no_html',
						),
					),
		);

		return $metaboxes;
	}
);

// Array of metaboxes to register.
add_filter(
	'anony_metaboxes',
	function ( $metaboxes ) {
		$metaboxes[] =
		array(
			'id'            => 'anony_template_settings', // Meta box ID.
			'title'         => esc_html__( 'Page/Post settings', 'smartpage' ),
			'context'       => 'side',
			'priority'      => 'high', // high|low.
			'hook_priority' => '10', // Default 10.
			'post_type'     => array( 'page', 'post' ),
			'fields'        =>
					array(
						array(
							'id'       => 'is_absolute_header',
							'title'    => esc_html__( 'Header overlaps content?', 'smartpage' ),
							'type'     => 'switch',
							'validate' => 'no_html',
						),
					),
		);

		return $metaboxes;
	}
);

/**
 * Add fot variationsmetabox
 *
 * @param array $metaboxes Registered metaboxes array.
 * @return array
 */
function anony_font_variations( $metaboxes ) {
	$metaboxes[] =
		array(
			'id'            => 'anony_font_variations', // Meta box ID.
			'title'         => esc_html__( 'Font variations', 'smartpage' ),
			'context'       => 'normal',
			'priority'      => 'high', // high|low.
			'hook_priority' => '10', // Default 10.
			'post_type'     => array( 'anony_fonts' ),
			'fields'        =>
					array(
						array(
							'id'       => 'font_family',
							'title'    => 'Font family',
							'type'     => 'text',
							'validate' => 'no_html',
							'desc'     => esc_html__( 'If left empty, slug will be used as font family. Input will be sanitized', 'smartpage' ),
						),
						array(
							'id'       => 'eot',
							'title'    => 'eot',
							'type'     => 'file_upload',
							'validate' => 'no_html',
						),

						array(
							'id'       => 'svg',
							'title'    => 'svg',
							'type'     => 'file_upload',
							'validate' => 'no_html',
						),

						array(
							'id'       => 'woff',
							'title'    => 'woff',
							'type'     => 'file_upload',
							'validate' => 'no_html',
						),

						array(
							'id'       => 'woff2',
							'title'    => 'woff2',
							'type'     => 'file_upload',
							'validate' => 'no_html',
						),
					),
		);

	return $metaboxes;
}

add_filter( 'anony_metaboxes', 'anony_font_variations' );
