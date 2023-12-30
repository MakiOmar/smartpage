<?php
/**
 * Orders Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_ORDERS_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Orders', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'enable_custom_orders_page',
					'title'    => esc_html__( 'Enable custom orders page', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),
			),
		)
	)
);
