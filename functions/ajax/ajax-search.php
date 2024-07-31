<?php
/**
 * Search with AJAX.
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 */

defined( 'ABSPATH' ) || die;
/**
 * Search ajax
 *
 * @return void
 */
function anony_ajax_search_cb() {

	$_request = isset( $_POST ) ? wp_unslash( $_POST ) : array();
	// Verify the nonce.
	if ( isset( $_request['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( $_request['nonce'] ), 'anony_start_ajax_search' ) ) {
		wp_send_json_error( 'Invalid nonce.' );
	}
	$search_query = isset( $_request['search'] ) ? sanitize_text_field( $_request['search'] ) : '';

	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'contains'       => $search_query,
		'posts_per_page' => 10,
	);

	$_query = new WP_Query( $args );

	if ( $_query->have_posts() ) {
		while ( $_query->have_posts() ) {
			$_query->the_post();
			?>
			<div class="search-result-item anony-flex flex-v-center">
				<?php do_action( 'anony_search_ajax_afetr_item_opening', get_the_ID() ); ?>
				<?php if ( has_post_thumbnail() ) { ?>
					<div class="search-result-thumbnail anony-inline-flex flex-v-center"><?php the_post_thumbnail( 'thumbnail' ); ?></div>
				<?php } ?>
				<div class="search-result-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<?php do_action( 'anony_search_ajax_after_title', get_the_ID() ); ?>
				</div>
				<?php do_action( 'anony_search_ajax_before_item_closing', get_the_ID() ); ?>
			</div>
			<?php
		}
		wp_reset_postdata();
	} else {
		echo '<p>No products found.</p>';
	}

	wp_die();
}
add_action( 'wp_ajax_anony_ajax_search', 'anony_ajax_search_cb' );
add_action( 'wp_ajax_nopriv_anony_ajax_search', 'anony_ajax_search_cb' );
