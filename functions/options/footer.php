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
					'id'       => 'mobile_footer_sticky_menu_style',
					'title'    => esc_html__( 'Sticky menu style', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'no_html',
					'options'  => array(
						'default' => esc_html__( 'Default', 'smartpage' ),
						'one'     => esc_html__( 'Style one', 'smartpage' ),
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
					'id'       => 'mobile_footer_sticky_menu_icons_color',
					'title'    => esc_html__( 'Sticky menu icons color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#fff',
				),

				array(
					'id'       => 'mobile_footer_sticky_menu_height',
					'title'    => esc_html__( 'Sticky menu height (px)', 'smartpage' ),
					'type'     => 'number',
					'validate' => 'no_html',
					'default'  => '100',
				),

			),
		)
	)
);
