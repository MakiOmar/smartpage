<?php
/**
 * General colors Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_GENERAL_COLORS_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'General', 'smartpage' ),
			'icon'   => 'E',
			'fields' => array(
				array(
					'id'       => 'primary_skin_color',
					'title'    => esc_html__( 'Primary color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#230005',
				),

				array(
					'id'       => 'secondary_skin_color',
					'title'    => esc_html__( 'secondary color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#e2e2e2',
				),
				array(
					'id'       => 'links_color',
					'title'    => esc_html__( 'Links color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#000',
				),
				array(
					'id'       => 'footer_background_color',
					'title'    => esc_html__( 'Footer background color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#000',
				),
				array(
					'id'       => 'footer_text_color',
					'title'    => esc_html__( 'Footer text color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#fff',
				),
				array(
					'id'       => 'footer_links_color',
					'title'    => esc_html__( 'Footer links color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#fff',
				),
			),
		)
	)
);
