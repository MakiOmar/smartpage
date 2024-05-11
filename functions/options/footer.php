<?php
/**
 * Footer Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_FOOTER_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Footer', 'smartpage' ),
			'icon'   => 'y',
			'fields' => array(
				array(
					'id'       => 'only_one_col_footer',
					'title'    => esc_html__( 'Footer one column only', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'can be enabled to allow building custom footer using widgets block editor', 'smartpage' ),
				),
				array(
					'id'       => 'enable_footer_top',
					'title'    => esc_html__( 'Enable footer top', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),
				array(
					'id'       => 'enable_footer_bottom',
					'title'    => esc_html__( 'Enable footer bottom', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),
				array(
					'id'       => 'enable_mobile_footer_sticky',
					'title'    => esc_html__( 'Enable Sticky menu style', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),
				array(
					'id'       => 'mobile_footer_sticky_menu_style',
					'title'    => esc_html__( 'Sticky menu style', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'no_html',
					'options'  => array(
						'default' => esc_html__( 'Default', 'smartpage' ),
						'one'     => esc_html__( 'Style one', 'smartpage' ),
						'custom'  => esc_html__( 'Custom', 'smartpage' ),
					),
					'default'  => 'default',
				),

				array(
					'id'       => 'mobile_footer_sticky_menu_bg_color',
					'title'    => esc_html__( 'Sticky menu background color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#fff',
				),

				array(
					'id'       => 'footer_svg_icons_color',
					'title'    => esc_html__( 'Footer svg icons color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#fff',
				),

				array(
					'id'       => 'mobile_footer_sticky_menu_icons_color',
					'title'    => esc_html__( 'Sticky menu icons color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#fff',
				),
			),
		)
	)
);
