<?php
/**
 * Header Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_HEADER_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Header', 'smartpage' ),
			'icon'   => 'y',
			'fields' => array(
				array(
					'id'       => 'header_style',
					'title'    => esc_html__( 'Header style', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'no_html',
					'options'  => array(
						'default' => esc_html__( 'Default', 'smartpage' ),
						'one'     => esc_html__( 'Style one', 'smartpage' ),
					),
					'default'  => 'default',
				),

				array(
					'id'       => 'mobile_header_behavior',
					'title'    => esc_html__( 'Mobile header position', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'no_html',
					'options'  => array(
						'default' => esc_html__( 'Default', 'smartpage' ),
						'sticky'  => esc_html__( 'sticky', 'smartpage' ),
					),
					'default'  => 'default',
				),
				array(
					'id'       => 'title_bar',
					'title'    => esc_html__( 'Title bar', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Enable/disable title bar', 'smartpage' ),
				),
				array(
					'id'       => 'title_bar_bg',
					'title'    => esc_html__( 'Title bar background', 'smartpage' ),
					'type'     => 'uploader',
					'validate' => 'no_html',
				),

			),
		)
	)
);
