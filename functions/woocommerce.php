<?php
/**
 * SmartPage WooComerce.
 *
 * PHP version 7.3 Or Later.
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com/anonyengine_elements
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

/**
 * Add theme support for WooCommerce gallery features
 */
function anony_woo_add_theme_support() {

	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
}

/**
 * Wrap WooCommerce content with apropriate markup
 */
function anony_woocommerce_before_main_content() {
	echo '<div class="anony-grid-col anony-post-contents anony-single_post">
							
				<div class="anony-post-info">
								
						<div class="anony-single-text">';
}

/**
 * Close wrapped WooCommerce content with apropriate markup
 */
function anony_woocommerce_after_main_content() {
	echo '</div></div></div>';
}

/**
 * Create brand attribute
 */
function anony_create_product_attributes() {
	ANONY_WOO_HELP::create_product_attribute( 'Brand' );
}

/**
 * Add brand's logo meta box
 */
function anony_create_product_attributes_metaboxes() {
	new ANONY_Term_Metabox(
		array(
			'id'       => 'anony_brand',
			'taxonomy' => 'pa_brand',
			'context'  => 'term',
			'fields'   =>
				array(
					array(
						'id'    => 'anony_brand_logo',
						'title' => esc_html__( 'Brand logo', 'smartpage' ),
						'type'  => 'gallery',
					),
				),
		)
	);
}

function anony_hide_products_without_price( $query ) {
	$anony_options = ANONY_Options_Model::get_instance();

	if ( '1' === $anony_options->hide_no_price_products && ! is_admin() && in_array( $query->get( 'post_type' ), array( 'product' ) ) ) {
		$meta_query   = $query->get( 'meta_query' );
		$meta_query[] = array(
			'key'     => '_price',
			'value'   => '',
			'compare' => '!=',
		);
		$query->set( 'meta_query', $meta_query );
	}

}

// Remove actions.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Add actions.
add_action( 'init', 'anony_create_product_attributes_metaboxes' );
add_action( 'init', 'anony_create_product_attributes' );
add_action( 'woocommerce_after_main_content', 'anony_woocommerce_after_main_content' );
add_action( 'woocommerce_before_main_content', 'anony_woocommerce_before_main_content' );
add_action( 'after_setup_theme', 'anony_woo_add_theme_support' );
add_action( 'pre_get_posts', 'anony_hide_products_without_price' );

