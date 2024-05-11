<?php
/**
 * Menu colors Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_MENU_COLORS_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Menu Colors', 'smartpage' ),
			'icon'   => 'E',
			'fields' => array(
				array(
					'id'       => 'main_menu_color',
					'title'    => esc_html__( 'Main menu container color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#fff',
				),

				array(
					'id'       => 'main_menu_text_color',
					'title'    => esc_html__( 'Main menu text color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#000',
				),

				array(
					'id'       => 'main_menu_text_hover_color',
					'title'    => esc_html__( 'Main menu text hover color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#000',
				),

				array(
					'id'       => 'main_menu_search_icon_color',
					'title'    => esc_html__( 'Main menu searc icon color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#000',
				),
			),
		)
	)
);
