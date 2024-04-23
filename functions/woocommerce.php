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

require_once 'woocommerce-orders.php';

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
	$anony_options = ANONY_Options_Model::get_instance();
	if ( ! is_singular( 'product' ) && '1' !== $anony_options->loop_rating || did_action( 'woocommerce_single_product_summary' ) ) {
		$html = '';
	} else {
		global $product;

		$rating_count = $product->get_rating_count();
		$review_count = $product->get_review_count();
		$average      = $product->get_average_rating();

		/* translators: %s: rating */
		$label = sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $rating_count );
		$html  = '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $average, $rating_count ) . '</div>';
	}

	echo wp_kses_post( $html );
}

/**
 * Allways show rating after shop loop item title
 */
function anony_rating_after_shop_loop_item_title() {

	$anony_options = ANONY_Options_Model::get_instance();
	if ( '1' === $anony_options->show_empty_rating ) {
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

$anony_options = ANONY_Options_Model::get_instance();
if ( '1' === $anony_options->disable_woo_comment_avatar ) {
	remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );
}

/**
 * Replace username used as comment author
 *
 * @param string $comment_author Comment author.
 * @param string $comment_id Comment ID.
 * @return string
 */
function anony_comment_author( $comment_author, $comment_id ) {
	$user_id = get_comment( $comment_id )->user_id;
	$user    = get_user_by( 'id', $user_id );
	$output  = $comment_author;
	$class   = 'anony-comment-author-display-name';
	if ( $user ) {
		if ( in_array( 'administrator', $user->roles, true ) ) {
			$class .= ' is-us';
		}
		if ( ! empty( $user->display_name ) ) {
			$output = $user->display_name;
		}
	}
	return '<span class="' . $class . '">' . $output . '</span>';
}
add_filter( 'comment_author', 'anony_comment_author', 10, 2 );

/**
 * Override single product ratings cb
 */
function anony_wc_single_product_ratings() {
	global $product;

	$rating_count = $product->get_rating_count();
	$class        = '';
	if ( wp_is_mobile() ) {
		$class = ' flex-h-center';
	}
	//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '<div class="sale-counter-rating anony-flex' . $class . '">';
	anony_sales_counter();
	if ( $rating_count >= 0 ) {
		$review_count = $product->get_review_count();
		$average      = $product->get_average_rating();
		do_action( 'anony_before_wc_single_product_ratings' );
		?>
		<div class="woocommerce-product-rating">
			<div class="container-rating">
				
				<div class="star-rating">
					<?php echo wp_kses_post( wc_get_rating_html( $average, $rating_count ) ); ?>
				</div>
				
					<?php if ( comments_open() ) : ?>
						<a href="#reviews" class="woocommerce-review-link anony-flex flex-h-center" rel="nofollow">
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
			<strong class="anony-rating-average">(<?php echo esc_html( $average ); ?>)</strong>
		</div>
		<?php
		do_action( 'anony_after_wc_single_product_ratings' );
	}
	echo '</div>';
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
			$prices = $product->get_variation_prices();

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

			$sale_badge_type  = 'percentage';
			$sale_badge_text  = $percentage;
			$sale_flash_style = 'default';

			$class = 'on-sale-percent anony-onsale-' . $sale_flash_style;

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


/**
 * Add the custom meta field to the product page
 *
 * @return void
 */
function anony_add_custom_sale_badge_field() {
	global $post;

	$custom_sale_badge    = get_post_meta( $post->ID, 'custom-sale-badge', true );
	$custom_sales_counter = get_post_meta( $post->ID, 'custom-sales-counter', true );

	// Output the field HTML.
	echo '<div class="options_group">';
	echo '<p class="form-field">';
	echo '<label for="custom-sale-badge">' . esc_html__( 'Custom Sale Badge', 'smartpage' ) . '</label>';
	echo '<input type="text" class="short" name="custom-sale-badge" id="custom-sale-badge" value="' . esc_attr( $custom_sale_badge ) . '"/>';
	echo '</p>';
	echo '<p class="form-field">';
	echo '<label for="custom-sales-counter">' . esc_html__( 'Custom Sales counter', 'smartpage' ) . '</label>';
	echo '<input type="number" class="short" name="custom-sales-counter" id="custom-sales-counter" value="' . esc_attr( $custom_sales_counter ) . '"/>';
	echo '</p>';
	echo '</div>';
}
add_action( 'woocommerce_product_options_general_product_data', 'anony_add_custom_sale_badge_field' );


/**
 * Save the custom meta field with security measures.
 *
 * @param int $post_id Product ID.
 * @return void
 */
function anony_save_custom_sale_badge_field( $post_id ) {
	//phpcs:disable
	$request = $_POST;
	//phpcs:enable.
	// Verify the nonce.
	if ( ! isset( $request['woocommerce_meta_nonce'] ) || ! wp_verify_nonce( $request['woocommerce_meta_nonce'], 'woocommerce_save_data' ) ) {
		return;
	}

	// Check user capabilities.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $request['custom-sale-badge'] ) ) {
		$custom_sale_badge = sanitize_text_field( $request['custom-sale-badge'] );
		update_post_meta( $post_id, 'custom-sale-badge', $custom_sale_badge );
	}

	if ( isset( $request['custom-sales-counter'] ) ) {
		$custom_sales_counter = sanitize_text_field( $request['custom-sales-counter'] );
		update_post_meta( $post_id, 'custom-sales-counter', $custom_sales_counter );
	}
}
add_action( 'woocommerce_process_product_meta', 'anony_save_custom_sale_badge_field' );


/**
 * Print sales counter
 *
 * @return void
 */
function anony_sales_counter() {
	global $product;
	$anony_options        = ANONY_Options_Model::get_instance();
	$custom_sales_counter = get_post_meta( $product->get_id(), 'custom-sales-counter', true );
	// Translators: Count of sales.
	$counter_text      = sprintf( __( 'Sold <strong>%s</strong> times', 'smartpage' ), esc_html( $custom_sales_counter ) );
	$pointer_direction = is_rtl() ? 'right' : 'left';
	if ( $custom_sales_counter && ! empty( $custom_sales_counter ) ) {
		do_action( 'anony_before_sales_counter' );
		//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<div class="anony-inline-flex custom_sales_counter flex-v-center">' . $anony_options->offers_icon . '&nbsp;<span class="custom-sales-counter anony-pointing-triangle-' . esc_attr( $pointer_direction ) . '">' . wp_kses_post( $counter_text ) . '</span></div>';
			do_action( 'anony_after_sales_counter' );
	}
}

/**
 * Fancy quantity before
 *
 * @return void
 */
function anony_fancy_quantity_before() {
	global $product;
	if ( ! $product || ! $product->is_purchasable() || ! $product->is_in_stock() || $product->is_sold_individually() ) {
		return;
	}
	if ( ! defined( 'HAS_FANCY_QUANTITY' ) ) {
		define( 'HAS_FANCY_QUANTITY', '' );
	}
	$style = 'default';
	switch ( $style ) {
		case 'one':
			$class = ' anony-quantity-style-one';
			break;
		case 'two':
			$class = ' anony-quantity-style-two';
			break;
		default:
			$class = '';
			break;
	}
	?>
	<style type="text/css">
		#anony-mobile-footer-menu form.cart{
			display: flex;
		}
		.anony-quantity {
			display: flex;
			align-items: center;
		}

		li.product .anony-quantity{
			justify-content: center;
		}

		.anony-quantity input {
			border: 1px solid #ccc;
			padding: 5px;
			width: 30px;
			height: 30px;
			text-align: center;
			font-size: 16px;
			line-height: 1;
			border-radius: 50%;
		}

		.anony-quantity input.anony-plus,
		.anony-quantity input.anony-minus {
			cursor: pointer;
		}

		.anony-quantity input.anony-plus:hover,
		.anony-quantity input.anony-minus:hover {
			background-color: #f9f9f9;
		}
		/* Chrome, Safari, Edge, Opera */
		.anony-quantity input::-webkit-outer-spin-button,
		.anony-quantity input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		/* Firefox */
		.anony-quantity input[type=number] {
			appearance: textfield;
			-moz-appearance: textfield;
		}

		.anony-quantity-style-one {
			background-color: #F5F5F5;
			padding: 2px 3px;
			border-radius: 8px;
		}
		
		.anony-quantity.anony-quantity-style-one input.anony-plus,
		.anony-quantity.anony-quantity-style-one input.anony-minus {
			background-color: #fff!important;
			border-radius:8px;
			border-color:#CACACA;
		}
	</style>
	<div class="anony-quantity<?php echo esc_attr( $class ); ?>">
		<input type="button" value="-" class="anony-minus"/>
	<?php
}

/**
 * Fancy quantity after
 *
 * @return void
 */
function anony_fancy_quantity_after() {
	global $product;
	if ( ! $product || ! $product->is_purchasable() || ! $product->is_in_stock() || $product->is_sold_individually() || ! defined( 'HAS_FANCY_QUANTITY' ) ) {
		return;
	}
	?>
	<input type="button" value="+" class="anony-plus"/>
	</div>
	<?php
}
/**
 * Fancy quantity script
 *
 * @return void
 */
function anony_fancy_quantity_script() {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		$('.anony-quantity').on('click', '.anony-plus, .anony-minus', function(e) {

		e.preventDefault();

		var quantityInput = $(this).parent().find('input.qty');

		var step = quantityInput.attr('step');

		step = typeof step !== 'undefined' && step !== '' ? parseFloat(step) : 1;

		var min = quantityInput.attr('min');

		min = typeof min !== 'undefined' && min !== '' ? parseFloat(min) : 1;

		var max = quantityInput.attr('max');

		max = typeof max !== 'undefined' && max !== '' ? parseFloat(max) : '';

		var currentVal = parseFloat(quantityInput.val());

		if (!isNaN(currentVal)) {

			if ($(this).hasClass('anony-plus')) {

			if (max && (currentVal + step) > max) {

				quantityInput.val(max);

			} else {

				quantityInput.val(currentVal + step);

			}
			} else {

			if (min && (currentVal - step) < min) {


				quantityInput.val(min);
			} else if (currentVal > 1) {

				quantityInput.val(currentVal - step);

			}
			}
		}
		// Trigger change event for WooCommerce
		quantityInput.trigger('change');
		});
	});
	</script>
	<?php
}

/**
 * Woocommerce quantity selector for loop pages.
 *
 * @param string     $html Add to cart link html.
 * @param WC_Product $product WooCommerce Product object.
 * @return string
 */
function anony_loop_qty_selector( $html, $product ) {
	$anony_options = ANONY_Options_Model::get_instance();
	if ( ! is_singular( 'product' ) && '1' !== $anony_options->in_loop_quantity ) {
		return $html;
	}
	if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
		ob_start();
		do_action( 'woocommerce_before_add_to_cart_quantity' );
		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				//phpcs:disable
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
				//phpcs:enable.
			),
			$product
		);
		do_action( 'woocommerce_after_add_to_cart_quantity' );
		$qty  = ob_get_clean();
		$html = $qty . $html;
	}
	return $html;
}

/**
 * Loop quantity selector
 */
function anony_loop_qty_selector_script() {
	?>
	<script>
		jQuery(document).ready( function($) {
			$( 'li.product' ).on( 'input, change', 'input[name=quantity]', function(){
				$( this ).closest('li.product').find('.ajax_add_to_cart').attr('data-quantity', $(this).val() );
			} );
		} );
	</script>
	<?php
}

/**
 * Product loop thumbnail
 *
 * @param string $size Thumbnail size.
 * @return string
 */
function anony_woo_loop_thumb_size( $size ) {
	if ( wp_is_mobile() ) {
		$size = 'product-loop-mobile';
	} else {
		$size = 'product-loop-desktop';
	}

	return $size;
}

/**
 * Direct add to cart form
 *
 * @return void
 */
function anony_direct_checkout_form() {
	$anony_options = ANONY_Options_Model::get_instance();
	if ( '1' !== $anony_options->enable_direct_checkout ) {
		return;
	}
	global $product;

	echo '<input type="hidden" name="direct_add_to_cart" value="' . esc_attr( $product->get_id() ) . '">';
	wp_nonce_field( 'anony-direct-add-to-cart', 'direct-add-to-cart-nonce' );
	//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '<button type="submit" class="button anony-button alt direct-checkout-button"><span>' . apply_filters( 'anony_direct_checkout_icon', '' ) . '</span>' . esc_html__( 'Direct Checkout', 'smartpage' ) . '</button>';
	//phpcs:enable.
}

/**
 * Now add to cart.
 */
function anony_direct_checkout() {
	global $woocommerce;

	if ( ! $woocommerce ) {
		return;
	}
	// phpcs:disable
	$req = $_POST;
	if ( empty( $req['direct_add_to_cart'] ) || ! isset( $req['direct_add_to_cart'] ) || wp_verify_nonce( wp_unslash( $req['direct_add_to_cart'] ), 'anony-direct-add-to-cart' ) ) {
		return;
	}
	// phpcs:enable.

	WC()->cart->empty_cart();

	$product_id = absint( wp_unslash( $req['direct_add_to_cart'] ) );

	// This adds the product with the ID; we can also add a second variable which will be the variation ID.
	WC()->cart->add_to_cart( $product_id );

	// Redirects to the checkout page.
	wp_safe_redirect( wc_get_checkout_url() );

	// Safely closes the function.
	exit();
}

/**
 * Filer WooCommerce Flexslider options - Add Dot Pagination Instead of Thumbnails.
 *
 * @param array $options Flex slider options.
 * @return array
 */
function anony_update_woo_flexslider_options( $options ) {
	$anony_options = ANONY_Options_Model::get_instance();
	if ( '1' === $anony_options->slider_dots ) {
		$options['controlNav'] = true;
	}
	$options['rtl'] = is_rtl();
	return $options;
}

/**
 * Filter cart fagments
 *
 * @param array $fragments Cart fagments.
 * @return array
 */
function anony_woocommerce_add_to_cart_fragments( $fragments ) {
	$fragments['div.widget_shopping_cart_content'] = str_replace( 'widget_shopping_cart_content', 'widget_shopping_cart_content anony-mini-cart-open', $fragments['div.widget_shopping_cart_content'] );
	return $fragments;
} 
add_filter( 'woocommerce_add_to_cart_fragments', 'anony_woocommerce_add_to_cart_fragments');
/**
 * Filter product's thumbnail.
 *
 * @param string $image Product's thumbnail HTML.
 * @return string
 */
function anony_woocommerce_product_get_image( $image ) {
	return '<div class="anony-woo-product-image">' . $image . '</div>';
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_add_to_cart_quantity', 'anony_fancy_quantity_before' );
add_action( 'woocommerce_after_add_to_cart_quantity', 'anony_fancy_quantity_after' );
add_action( 'wp_footer', 'anony_fancy_quantity_script' );
add_action( 'wp_footer', 'anony_loop_qty_selector_script' );
add_action( 'woocommerce_after_add_to_cart_button', 'anony_direct_checkout_form' );
add_action( 'template_redirect', 'anony_direct_checkout' );
add_action( 'init', 'anony_create_product_attributes_metaboxes' );
add_action( 'init', 'anony_create_product_attributes' );
add_action( 'after_setup_theme', 'anony_woo_add_theme_support' );
add_action( 'pre_get_posts', 'anony_hide_products_without_price' );
add_action( 'woocommerce_after_shop_loop_item_title', 'anony_rating_after_shop_loop_item_title', 4 );
add_action( 'woocommerce_single_product_summary', 'anony_change_single_product_ratings', 2 );
add_filter( 'woocommerce_product_get_image', 'anony_woocommerce_product_get_image' );
add_filter( 'woocommerce_sale_flash', 'anony_custom_sale_badge', 20, 3 );
add_filter( 'woocommerce_product_description_heading', '__return_false' );
add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );
add_filter( 'woocommerce_product_reviews_heading', '__return_false' );
add_filter( 'gettext', 'anony_change_related_products_text', 10, 3 );
add_filter( 'comment_form_fields', 'anony_wc_comment_form_fields' );
add_filter( 'woocommerce_loop_add_to_cart_link', 'anony_loop_qty_selector', 10, 2 );
add_filter( 'single_product_archive_thumbnail_size', 'anony_woo_loop_thumb_size' );
add_filter( 'woocommerce_single_product_carousel_options', 'anony_update_woo_flexslider_options' );
