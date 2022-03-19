<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}

add_action(
	'after_setup_theme',
	function () {

		// Support woocommerce
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );

	},
	20
);


// Alter The Archive Title for The Shop
add_filter(
	'get_the_archive_title',
	function ( $title ) {
		if ( is_shop() && $shop_id = wc_get_page_id( 'shop' ) ) {
			$title = get_the_title( $shop_id );
		}
		return $title;
	}
);

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action(
	'woocommerce_before_main_content',
	function () {

		echo '<div class="anony-grid-col anony-post-contents anony-single_post">
							
				<div class="anony-post-info">
								
						<div class="anony-single-text">';
	},
	10
);

add_action(
	'woocommerce_after_main_content',
	function () {
		echo '</div></div></div>';
	},
	10
);

function anony_create_product_attributes(){
	ANONY_WOO_HELP::createProductAttribute( 'Brand' );
}
add_action( 'init', 'anony_create_product_attributes' );

function anony_create_product_attributes_metaboxes(){
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

add_action( 'init', 'anony_create_product_attributes_metaboxes' );
