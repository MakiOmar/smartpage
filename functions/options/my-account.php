<?php
/**
 * WooCommerce My account Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_WOO_MY_ACCOUNT_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'My account', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'custom_woo_account_menu',
					'title'    => esc_html__( 'My account menu', 'smartpage' ),
					'type'     => 'select',
					'options'  => anony_get_menus(),
					'validate' => 'no_html',
				),
			),
		)
	)
);
