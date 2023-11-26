<?php
/**
 * Rate model
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com/smartpage
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

$post_ratings = get_post_meta( $id, 'anony_post_rating', true );

if ( ! $post_ratings || empty( $post_ratings ) || ! is_array( $post_ratings ) ) {
	$rate_times = 0;
	$rate_value = 0;
	$rate_bg    = 0;
} else {
	$rate_times = count( $post_ratings );
	$sum_rates  = array_sum( array_values( $post_ratings ) );
	$rate_value = $sum_rates / $rate_times;
	$rate_bg    = ( ( $rate_value ) / 5 ) * 100;
}
$rated_count  = floor( $rate_value );
$rated_text   = __( 'Rated', 'smartpage' );
$out_of       = __( 'out of', 'smartpage' );
$reviews_text = __( 'Review(s)', 'smartpage' );

$rate_class = is_user_logged_in() ? ' rate-btn' : '';
require locate_template( 'templates/rate-view.php', false, false );
