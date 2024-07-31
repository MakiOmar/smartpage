<?php
/**
 * General Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_GENERAL_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'General', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'logo',
					'title'    => esc_html__( 'Logo', 'smartpage' ),
					'type'     => 'uploader',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'A logo that willbe displayed on desktop version', 'smartpage' ),
				),
				array(
					'id'       => 'mobile_logo',
					'title'    => esc_html__( 'Mobile Logo', 'smartpage' ),
					'type'     => 'uploader',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'A logo that willbe displayed on mobile version', 'smartpage' ),
				),
				array(
					'id'       => 'preloader',
					'title'    => esc_html__( 'Enable preloader', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Enabel or disable page preloader', 'smartpage' ),
				),
				array(
					'id'       => 'preloader_img',
					'title'    => esc_html__( 'Preloader image', 'smartpage' ),
					'type'     => 'uploader',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Choose preloader image', 'smartpage' ),
				),
				array(
					'id'       => 'copyright',
					'title'    => esc_html__( 'Copyright', 'smartpage' ),
					'type'     => 'textarea',
					'validate' => 'html',
					// Translators: Date string.
					'default'  => sprintf( esc_html__( 'All rights are reserved to Anonymous %s', 'smartpage' ), gmdate( 'Y' ) ),
				),
				array(
					'id'       => 'page_scroll',
					'title'    => esc_html__( 'Page scroll button', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					// Translators: Date string.
					'default'  => sprintf( esc_html__( 'Show/hide page scroll button', 'smartpage' ), gmdate( 'Y' ) ),
				),
				array(
					'id'       => 'ajax_search',
					'title'    => esc_html__( 'AJAX Search', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Show results while user is typing', 'smartpage' ),
				),
			),
		)
	)
);
