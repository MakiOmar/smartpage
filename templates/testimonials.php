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

$anony_options = ANONY_Options_Model::get_instance();

$testimonial_data = get_post_meta( get_the_ID(), 'anony_testimonial_data', true );
if ( ! empty( $testimonial_data ) && ! empty( $testimonial_data['anony_testimonial_rating'] ) ) {
	$rating = $testimonial_data['anony_testimonial_rating'];
} else {
	$rating = 0;
}
?>
<div class="<?php echo esc_html( $slider_class ); ?>anony-testimonial-item anony-grid-col anony-grid-col-sm-3 anony-inline-flex anony-flex-column">
	<div class="anony-grid-row">
		<div class="anony-grid-col anony-grid-col-2 anony-inline-flex flex-h-center flex-v-center">
			<?php
			//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
			echo ! empty( $anony_options->testimonials_icon ) ? $anony_options->testimonials_icon : '<svg width="40" height="40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22"><defs id="defs3051">  </defs><path style="fill:currentColor;fill-opacity:1;stroke:none" d="M 11 3 A 3.9999902 4.0000296 0 0 0 7 7 A 3.9999902 4.0000296 0 0 0 11 11 A 3.9999902 4.0000296 0 0 0 15 7 A 3.9999902 4.0000296 0 0 0 11 3 z M 11 4 A 3 3.0000296 0 0 1 14 7 A 3 3.0000296 0 0 1 11 10 A 3 3.0000296 0 0 1 8 7 A 3 3.0000296 0 0 1 11 4 z M 11 12 A 7.9999504 8.0000296 0 0 0 3.0722656 19 L 4.0800781 19 A 6.9999604 7.0000296 0 0 1 11 13 A 6.9999604 7.0000296 0 0 1 17.921875 19 L 18.929688 19 A 7.9999504 8.0000296 0 0 0 11 12 z " class="ColorScheme-Text"></path></svg>';
			//phpcs:enable
			?>
		</div>
		<div class="anony-grid-col anony-grid-col-10 anony-inline-flex anony-flex-column">
			<p style="line-height:initial"><strong><?php the_title(); ?></strong></p>
			<span>
				<?php
				for ( $r = 1; $r <= 5; $r++ ) {
					$rate_star = ( $r <= $rating ) ? 'fa-star' : 'fa-star-o';
					$class     = ( $r <= $rating ) ? ' reviews' : '';
					?>
						<i class="fa <?php echo esc_attr( $rate_star . $class ); ?>"></i><?php echo ( ( 5 !== $r ) ? '&nbsp;' : '' ); ?>
						<?php
				}
				?>
			</span>
		</div>
	</div>
	<?php the_content(); ?>
</div>
