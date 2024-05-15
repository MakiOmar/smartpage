<?php
/**
 * WooCommerce Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_WOOCOMMERCE_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Woocommerce', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'hide_no_price_products',
					'title'    => esc_html__( 'Hide products without prices', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),
				array(
					'id'       => 'show_empty_rating',
					'title'    => esc_html__( 'Show product\'s empty rating', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'default'  => '1',
				),

				array(
					'id'       => 'sale_badge_type',
					'title'    => esc_html__( 'Sale badge type', 'smartpage' ),
					'type'     => 'radio',
					'validate' => 'multiple_options',
					'options'  => array(
						'text'       => array(
							'title' => esc_html__( 'Text', 'smartpage' ),
						),

						'percentage' => array(
							'title' => esc_html__( 'percentage', 'smartpage' ),
						),
					),
					'default'  => 'percentage',
				),

				array(
					'id'       => 'related_products_title',
					'title'    => esc_html__( 'Related products title', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'no_html',
					'default'  => 'Related products',
				),
				array(
					'id'       => 'in_loop_quantity',
					'title'    => esc_html__( 'Show quantity selector in products\' loop', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),

				array(
					'id'       => 'loop_rating',
					'title'    => esc_html__( 'Show rating in products\' loop', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),
				array(
					'id'       => 'checkout_style',
					'title'    => esc_html__( 'Checkout layout', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'no_html',
					'options'  => array(
						'default'   => esc_html__( 'Default', 'smartpage' ),
						'style-one' => esc_html__( 'Style one', 'smartpage' ),
					),
					'default'  => 'default',
				),
			),
		)
	)
);
