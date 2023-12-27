<?php
/**
 * Post types Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_POST_TYPES_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Post types', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'enable_portfolio',
					'title'    => esc_html__( 'Enable portfolio', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),

				array(
					'id'       => 'enable_news',
					'title'    => esc_html__( 'Enable news', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),

				array(
					'id'       => 'enable_downloads',
					'title'    => esc_html__( 'Enable downloads', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),

				array(
					'id'       => 'enable_testimonials',
					'title'    => esc_html__( 'Enable testimonials', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),
				array(
					'id'       => 'enable_faqs',
					'title'    => esc_html__( 'Enable faqs', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),
			),
		)
	)
);
