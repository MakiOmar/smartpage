<?php
/**
 * Ajax add to cart
 *
 * @package Anonymous Meta box
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue add to cart scripts
 *
 * @return void
 */
function anony_woocommerce_ajax_add_to_cart_js() {
	if ( function_exists( 'is_product' ) && is_product() ) {
		wp_register_script(
			'anony-woocommerce-ajax-add-to-cart',
			ANONY_THEME_URI . '/assets/js/ajax-add-to-cart.js',
			array( 'jquery' ),
			filemtime(
				wp_normalize_path( ANONY_THEME_DIR . '/assets/js/ajax-add-to-cart.js' )
			),
			true
		);
		$use_ajax_add_to_cart = apply_filters( 'anony_use_ajax_add_to_cart', true );
		if ( $use_ajax_add_to_cart ) {
			wp_enqueue_script( 'anony-woocommerce-ajax-add-to-cart' );
			wp_localize_script( 'anony-woocommerce-ajax-add-to-cart', 'AnonyCartScripts', array( 'nonce' => wp_create_nonce( 'anony-addtocart' ) ) );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'anony_woocommerce_ajax_add_to_cart_js', 99 );
add_action( 'wp_ajax_anony_woocommerce_ajax_add_to_cart', 'anony_woocommerce_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_anony_woocommerce_ajax_add_to_cart', 'anony_woocommerce_ajax_add_to_cart' );
/**
 * Add to cart ajax action.
 *
 * @return void
 */
function anony_woocommerce_ajax_add_to_cart() {
	// phpcs:disable
	$req = $_POST;
	// phpcs:enable.
	$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $req['product_id'] ) );

	if ( ! wp_verify_nonce( $req['nonce'], 'anony-addtocart' ) ) {
		$data = array(
			'error'       => true,
			'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
		);

		wp_send_json( $data );

		die();
	}
	$quantity          = empty( $req['quantity'] ) ? 1 : wc_stock_amount( $req['quantity'] );
	$variation_id      = absint( $req['variation_id'] );
	$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
	$product_status    = get_post_status( $product_id );

	if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id ) && 'publish' === $product_status ) {

		do_action( 'woocommerce_ajax_added_to_cart', $product_id );

		if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
			wc_add_to_cart_message( array( $product_id => $quantity ), true );
		}

		WC_AJAX::get_refreshed_fragments();
	} else {

		$data = array(
			'error'       => true,
			'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
		);

		wp_send_json( $data );
	}

	die();
}
