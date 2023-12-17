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

/**
 * Hide products without price
 *
 * @param object $query Query object.
 * @return void
 */
function anony_hide_products_without_price( $query ) {
	$anony_options = ANONY_Options_Model::get_instance();

	if ( '1' === $anony_options->hide_no_price_products && ! is_admin() && in_array( $query->get( 'post_type' ), array( 'product' ), true ) ) {
		$meta_query = $query->get( 'meta_query' );

		if ( is_array( $meta_query ) ) {
			$meta_query[] = array(
				'key'     => '_price',
				'value'   => '',
				'compare' => '!=',
			);
			$query->set( 'meta_query', $meta_query );
		}
	}
}

/**
 * Replaces product rating. Shows rating even if no ratings (Will show empty stars).
 */
function anony_replace_product_rating() {
	global $product;

	$rating_count = $product->get_rating_count();
	$review_count = $product->get_review_count();
	$average      = $product->get_average_rating();

	/* translators: %s: rating */
	$label = sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $rating_count );
	$html  = '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $average, $rating_count ) . '</div>';

	echo wp_kses_post( $html );
}

/**
 * Allways show rating after shop loop item title
 */
function anony_rating_after_shop_loop_item_title() {

	$anony_options = ANONY_Options_Model::get_instance();
	if ( '1' === $anony_options->show_empty_rating ) {
		global $product;
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'anony_replace_product_rating', 5 );
	}
}

/**
 * Override single product ratings hooks
 */
function anony_change_single_product_ratings() {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	add_action( 'woocommerce_single_product_summary', 'anony_wc_single_product_ratings', 10 );
}

/**
 * Override single product ratings cb
 */
function anony_wc_single_product_ratings() {
	global $product;

	$rating_count = $product->get_rating_count();

	if ( $rating_count >= 0 ) {
		$review_count = $product->get_review_count();
		$average      = $product->get_average_rating();
		?>
		<div class="woocommerce-product-rating">
			<div class="container-rating">
				
				<div class="star-rating">
					<?php echo wp_kses_post( wc_get_rating_html( $average, $rating_count ) ); ?>
				</div>
				
					<?php if ( comments_open() ) : ?>
						<a href="#reviews" class="woocommerce-review-link" rel="nofollow">
							(
							<?php
								printf(
									wp_kses_post(
										// Translators: Reviews count.
										_n( '%s customer review', '%s customer reviews', $review_count, 'woocommerce' )
									),
									'<span class="count">' . esc_html( $review_count ) . '</span>'
								);
							?>
							)
						</a>
					<?php endif ?>
				</div>
		</div>
		<?php
	}
}
if ( ! function_exists( 'anony_custom_sale_badge' ) ) {
	/**
	 * Customsale badge
	 *
	 * @param string     $html Badge html.
	 * @param WP_Post    $post Post object.
	 * @param WC_Product $product Product object.
	 * @return string
	 */
	function anony_custom_sale_badge( $html, $post, $product ) {

		$custom_sale_badge = get_post_meta( $post->ID, 'custom-sale-badge', true );

		if ( $custom_sale_badge && ! empty( $custom_sale_badge ) ) {

			return sprintf( '<span class="onsale on-sale-text">%s</span>', $custom_sale_badge );
		}

		$anony_options = ANONY_Options_Model::get_instance();
		if ( $product->is_type( 'variable' ) ) {
			$percentages    = array();
			$regular_prices = array();

			// Get all variation prices.
			$prices = $product->get_variations_prices();

			// Loop through variation prices.
			foreach ( $prices['price'] as $key => $price ) {
				// Only on sale variations.
				if ( $prices['regular_price'][ $key ] !== $price ) {
					// Calculate and set in the array the percentage for each variation on sale.
					$percentages[] = round( 100 - ( floatval( $prices['sale_price'][ $key ] ) / floatval( $prices['regular_price'][ $key ] ) * 100 ) );

					$sale_prices[] = floatval( $prices['sale_price'][ $key ] );

					$regular_prices[] = floatval( $prices['regular_price'][ $key ] );
				}
			}
			// We keep the highest value.
			$percentage    = max( $percentages ) . '%';
			$regular_price = max( $regular_prices );
			$sale_price    = max( $sale_prices );

			$saved = $regular_price - $sale_price;

		} elseif ( $product->is_type( 'grouped' ) ) {
				$percentages    = array();
				$regular_prices = array();

				// Get all variation prices.
				$children_ids = $product->get_children();

				// Loop through variation prices.
			foreach ( $children_ids as $child_id ) {
				$child_product = wc_get_product( $child_id );

				$regular_price = (float) $child_product->get_regular_price();
				$sale_price    = (float) $child_product->get_sale_price();

				if ( 0 !== $sale_price || ! empty( $sale_price ) ) {
					// Calculate and set in the array the percentage for each child on sale.
					$percentages[] = round( 100 - ( $sale_price / $regular_price * 100 ) );

					$regular_prices[] = $regular_price;
					$sale_prices[]    = $sale_price;
				}
			}
				// We keep the highest value.
				$percentage = max( $percentages ) . '%';

				$regular_price = max( $regular_prices );

				$sale_price = max( $sale_prices );

				$saved = $regular_price - $sale_price;

		} else {
			$regular_price = (float) $product->get_regular_price();
			$sale_price    = (float) $product->get_sale_price();

			if ( 0 !== $sale_price || ! empty( $sale_price ) ) {
					$percentage = round( 100 - ( $sale_price / $regular_price * 100 ) ) . '%';

					$saved = $regular_price - $sale_price;
			} else {
				return $html;
			}
		}

			$sale_badge_type = 'percentage';

			$sale_badge_text = $percentage;

			$class = 'on-sale-percent';

		if ( 'text' === $anony_options->sale_badge_type ) {
			// Translators: %1$s for saved amount and %2$s for currncy.
			$sale_badge_text = sprintf( esc_html__( 'Save %1$s %2$s', 'smartpage' ), round( $saved ), get_woocommerce_currency_symbol() );

			$class = 'on-sale-text';
		}

			return sprintf( '<span class="onsale %1$s">%2$s</span>', $class, $sale_badge_text );
	}

}

/**
 * Related products title filter callback
 *
 * @param string $new_text The new text.
 * @param string $related_text The old text.
 * @param string $source Text source.
 * @return string
 */
function anony_change_related_products_text( $new_text, $related_text, $source ) {
	if ( 'Related products' === $related_text && 'woocommerce' === $source ) {
		$anony_options = ANONY_Options_Model::get_instance();
		if ( ! empty( $anony_options->related_products_title ) ) {
			$new_text = $anony_options->related_products_title;
		}
	}
	return $new_text;
}

/**
 * Remove Email from woocommerce comments' form
 *
 * @param array $fields Comment form fields array.
 * @return array
 */
function anony_wc_comment_form_fields( $fields ) {
	global $post;

	if ( 'product' !== $post->post_type ) {
		return $fields;
	}
	$anony_options = ANONY_Options_Model::get_instance();

	if ( isset( $fields['email'] ) && '1' === $anony_options->disable_comment_form_email_field ) {
		unset( $fields['email'] );
	}
	return $fields;
}

// Remove actions.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );


// Add actions.
add_action( 'init', 'anony_create_product_attributes_metaboxes' );
add_action( 'init', 'anony_create_product_attributes' );
add_action( 'after_setup_theme', 'anony_woo_add_theme_support' );
add_action( 'pre_get_posts', 'anony_hide_products_without_price' );
add_action( 'woocommerce_after_shop_loop_item_title', 'anony_rating_after_shop_loop_item_title', 4 );

add_action( 'woocommerce_single_product_summary', 'anony_change_single_product_ratings', 2 );

add_filter( 'woocommerce_sale_flash', 'anony_custom_sale_badge', 20, 3 );

add_filter( 'woocommerce_product_description_heading', '__return_false' );
add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );
add_filter( 'woocommerce_product_reviews_heading', '__return_false' );

add_filter( 'gettext', 'anony_change_related_products_text', 10, 3 );

add_filter( 'comment_form_fields', 'anony_wc_comment_form_fields' );
