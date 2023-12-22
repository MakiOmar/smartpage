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
			<div class="anony-grid-col anony-grid-col-sm-<?php echo esc_attr( $desktop_columns ); ?> anony-grid-col-slg-<?php echo esc_attr( $mobile_columns ); ?> anony-circle-image anony-inline-flex flex-h-center">
				<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>" title="<?php echo esc_attr( $name ); ?>" class="anony-grid-row flex-h-center anony-flex-column">
					<?php
					$image_id = get_term_meta( $term_id, $atts['image_id_meta_key'], true );

					if ( ! empty( $image_id ) && is_numeric( $image_id ) ) {
						$image_url = wp_get_attachment_image_url( absint( $image_id ), 'thumbnail' );
						?>
						<img style="width:80px;height:80px" src="<?php echo esc_url( $image_url ); ?>"/>
						<?php
					} else {
						?>
						<img style="width:80px;height:80px" src="<?php echo esc_url( ANONY_THEME_URI . '/images/placeholder_150x150.webp' ); ?>"/>
						<?php
					}
					?>
					<div><strong><?php echo esc_html( $name ); ?></strong></div>
				</a>
			</div>
			<?php

	}
	?>
</div>
