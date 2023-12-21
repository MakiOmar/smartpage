<?php
/**
 * Sidebars Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_SIDEBARS_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Sidebars', 'smartpage' ),
			'icon'   => 'y',
			'fields' => array(
				array(
					'id'       => 'sidebar',
					'title'    => esc_html__( 'Sidebar', 'smartpage' ),
					'type'     => 'radio_img',
					'validate' => 'multiple_options',
					'options'  => array(
						'left-sidebar'  => array(
							'title' => esc_html__( 'Left Sidebar', 'smartpage' ),
							'img'   => ANONY_THEME_URI . '/images/icons/left-sidebar.png',
						),

						'right-sidebar' => array(
							'title' => esc_html__( 'Right Sidebar', 'smartpage' ),
							'img'   => ANONY_THEME_URI . '/images/icons/right-sidebar.png',
						),

						'no-sidebar'    => array(
							'title' => esc_html__( 'Full width', 'smartpage' ),
							'img'   => ANONY_THEME_URI . '/images/icons/full-width.png',
						),
					),
					'default'  => 'left-sidebar',
					'desc'     => esc_html__( 'This controls the direction of the main sidebar', 'smartpage' ),
				),
				array(
					'id'       => 'single_sidebar',
					'title'    => esc_html__( 'Single post sidebar', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'A single post can have two sidebars, check this to enable the secondary sidebar', 'smartpage' ),
				),

			),
		)
	)
);
