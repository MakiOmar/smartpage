<?php
/**
 * Testimonials model
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com/smartpage
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

$args = array(
	'post_type'      => 'anony_testimonial',
	'posts_per_page' => 5,
	'order'          => 'ASC',
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
	echo '<div class="anony-grid-row flex-h-center">';
	while ( $query->have_posts() ) {
		$query->the_post();
		$testimonial_data = get_post_meta( get_the_ID(), 'anony_testimonial_data', true );
		if ( ! empty( $testimonial_data ) && ! empty( $testimonial_data['anony_testimonial_rating'] ) ) {
			$rating = $testimonial_data['anony_testimonial_rating'];
		} else {
			$rating = 0;
		}
		echo '<div class="anony-testimonial-item anony-grid-col anony-grid-col-3 anony-inline-flex anony-flex-column">';
		echo '<span>';
		for ( $r = 1; $r <= 5; $r++ ) {

			$rate_star = ( $r <= $rating ) ? 'fa-star' : 'fa-star-o';
			$class     = ( $r <= $rating ) ? ' reviews' : '';
			?>
	
			<i class="fa <?php echo esc_attr( $rate_star . $class ); ?>"></i><?php echo ( ( 5 !== $r ) ? '&nbsp' : '' ); ?>
	
			<?php
		}
		echo '</span>';
		echo '<p><strong>';
		the_title();
		echo '</strong></p>';
		the_content();
		echo '</div>';
	}
	echo '</div>';

	wp_reset_postdata();
}
