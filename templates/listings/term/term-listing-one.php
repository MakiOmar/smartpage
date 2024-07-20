<?php
/**
 * Term listing
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="anony-grid-row flex-h-center">
	<?php
	foreach ( $terms as $term_id => $name ) {
		?>
			<div height="<?php echo esc_html( $height ); ?>" class="anony-grid-col <?php echo esc_attr( $class_prefix ); ?>-sm-<?php echo esc_attr( $desktop_columns ); ?> <?php echo esc_attr( $class_prefix ); ?>-slg-<?php echo esc_attr( $mobile_columns ); ?> <?php echo esc_html( $layout ); ?> anony-inline-flex flex-h-center flex-v-center anony-align-flex-start">
				<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>" title="<?php echo esc_attr( $name ); ?>" class="anony-grid-row flex-h-center anony-flex-column">
					<?php
					$image_id = get_term_meta( $term_id, $image_id_meta_key, true );

					if ( ! empty( $image_id ) && is_numeric( $image_id ) ) {
						$image_url = wp_get_attachment_image_url( absint( $image_id ), $thumb_size );
						?>
						<img width="<?php echo esc_html( $width ); ?>" height="<?php echo esc_html( $height ); ?>" style="max-width:<?php echo esc_html( $width ); ?>;height:<?php echo esc_html( $height ); ?>" src="<?php echo esc_url( $image_url ); ?>"/>
						<?php
					} else {
						?>
						<img width="<?php echo esc_html( $width ); ?>" height="<?php echo esc_html( $height ); ?>" style="max-width:<?php echo esc_html( $width ); ?>;height:<?php echo esc_html( $height ); ?>" src="<?php echo esc_url( ANONY_THEME_URI . '/images/placeholder_150x150.webp' ); ?>"/>
						<?php
					}
					?>
					<?php if ( 'yes' === $show_title ) : ?>
					<strong style="text-align:<?php echo esc_attr( $name_align ); ?>;font-size:<?php echo esc_attr( $font_size ); ?>"><?php echo esc_html( $name ); ?></strong>
					<?php endif; ?>
				</a>
			</div>
			<?php
	}
	?>
</div>
