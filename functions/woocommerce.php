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
		
		if( is_array( $meta_query ) ){
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
function replace_product_rating() {
    global $product;

    $rating_count = $product->get_rating_count();
    $review_count = $product->get_review_count();
    $average      = $product->get_average_rating();

    /* translators: %s: rating */
	$label = sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $rating_count );
	$html  = '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $average, $rating_count ) . '</div>';
	
	echo $html;
}

/**
 * Allways show rating after shop loop item title
 */
function anony_rating_after_shop_loop_item_title() {
    global $product;
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	add_action( 'woocommerce_after_shop_loop_item_title', 'replace_product_rating', 5 );
    
}

function change_single_product_ratings(){
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_rating', 10 );
    add_action('woocommerce_single_product_summary','wc_single_product_ratings', 10 );
}

function wc_single_product_ratings(){
    global $product;

    $rating_count = $product->get_rating_count();

    if ( $rating_count >= 0 ) {
        $review_count = $product->get_review_count();
        $average      = $product->get_average_rating();
        ?>
        <div class="woocommerce-product-rating">
            <div class="container-rating">
				
				<div class="star-rating">
					<?php echo wc_get_rating_html( $average, $rating_count ); ?>
				</div>
				
            		<?php if ( comments_open() ) : ?>
						<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)</a>
					<?php endif ?>
        		</div>
		</div>
        <?php
    }
}

function anony_add_percentage_to_sale_badge( $html, $post, $product ) {

  if( $product->is_type('variable')){
      $percentages = array();

      // Get all variation prices
      $prices = $product->get_variation_prices();

      // Loop through variation prices
      foreach( $prices['price'] as $key => $price ){
          // Only on sale variations
          if( $prices['regular_price'][$key] !== $price ){
              // Calculate and set in the array the percentage for each variation on sale
              $percentages[] = round( 100 - ( floatval($prices['sale_price'][$key]) / floatval($prices['regular_price'][$key]) * 100 ) );
          }
      }
      // We keep the highest value
      $percentage = max($percentages) . '%';

  } elseif( $product->is_type('grouped') ){
      $percentages = array();

      // Get all variation prices
      $children_ids = $product->get_children();

      // Loop through variation prices
      foreach( $children_ids as $child_id ){
          $child_product = wc_get_product($child_id);

          $regular_price = (float) $child_product->get_regular_price();
          $sale_price    = (float) $child_product->get_sale_price();

          if ( $sale_price != 0 || ! empty($sale_price) ) {
              // Calculate and set in the array the percentage for each child on sale
              $percentages[] = round(100 - ($sale_price / $regular_price * 100));
          }
      }
      // We keep the highest value
      $percentage = max($percentages) . '%';

  } else {
      $regular_price = (float) $product->get_regular_price();
      $sale_price    = (float) $product->get_sale_price();

      if ( $sale_price != 0 || ! empty($sale_price) ) {
          $percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
      } else {
          return $html;
      }
  }
  return '<span class="onsale percent">' . $percentage . '</span>';
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
add_action( 'woocommerce_after_shop_loop_item_title', 'anony_rating_after_shop_loop_item_title', 4 );

add_action('woocommerce_single_product_summary', 'change_single_product_ratings', 2 );

add_filter( 'woocommerce_sale_flash', 'anony_add_percentage_to_sale_badge', 20, 3 );