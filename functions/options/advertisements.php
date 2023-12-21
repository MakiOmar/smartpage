<?php
/**
 * Advertisements Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$anony_ads_loc = array(
	'header'        => esc_html__( 'Header', 'smartpage' ),
	'footer'        => esc_html__( 'Footer', 'smartpage' ),
	'sidebar'       => esc_html__( 'Sidebar', 'smartpage' ),
	'post'          => esc_html__( 'Single post', 'smartpage' ),
	'page'          => esc_html__( 'page', 'smartpage' ),
	'before_fotter' => esc_html__( 'Before footer', 'smartpage' ),
);

define(
	'ANONY_ADS_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Advertisements', 'smartpage' ),
			'icon'   => 'E',
			'fields' => array(
				array(
					'id'       => 'ad_block_one',
					'title'    => esc_html__( 'AD block one', 'smartpage' ),
					'type'     => 'textarea',
					'validate' => 'html',
				),
				array(
					'id'       => 'ad_block_one_location',
					'title'    => esc_html__( 'AD block one location', 'smartpage' ),
					'type'     => 'checkbox',
					'validate' => 'multiple_options',
					'options'  => $anony_ads_loc,

				),
				array(
					'id'       => 'ad_block_two',
					'title'    => esc_html__( 'AD block two', 'smartpage' ),
					'type'     => 'textarea',
					'validate' => 'html',
				),
				array(
					'id'       => 'ad_block_two_location',
					'title'    => esc_html__( 'AD block two location', 'smartpage' ),
					'type'     => 'checkbox',
					'validate' => 'multiple_options',
					'options'  => $anony_ads_loc,

				),
				array(
					'id'       => 'ad_block_three',
					'title'    => esc_html__( 'AD block three', 'smartpage' ),
					'type'     => 'textarea',
					'validate' => 'html',
				),
				array(
					'id'       => 'ad_block_three_location',
					'title'    => esc_html__( 'AD block three location', 'smartpage' ),
					'type'     => 'checkbox',
					'validate' => 'multiple_options',
					'options'  => $anony_ads_loc,

				),

			),
		)
	)
);
