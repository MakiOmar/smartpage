<?php
/**
 * Cart counter
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'wp_ajax_get_cart_count', 'anony_cart_counter' );
add_action( 'wp_ajax_nopriv_get_cart_count', 'anony_cart_counter' );

/**
 * Cart counter ajax cb.
 *
 * @return void
 */
function anony_cart_counter() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	$return = array(
		'count' => WC()->cart->get_cart_contents_count(),
	);

	wp_send_json( $return );

	die();
}
