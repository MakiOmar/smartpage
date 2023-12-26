<?php
/**
 * Imagebox partial
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div id="anony-image-box-wrapper">
	<div class="anony-grid-row anony-inline-flex">
		<div class="anony-grid-col anony-grid-col-4 anony-inline-flex flex-v-center">
		<?php
		if ( $image_url && ! empty( $image_url ) ) {
			if ( class_exists( 'ANONY_Options_Model' ) ) {
				$anofl_options = ANONY_Options_Model::get_instance( 'Anofl_Options' );
				if ( '1' === $anofl_options->add_missing_image_dimensions && '1' === $anofl_options->lazyload_images ) {
					?>
					<img loading="lazy" data-src="<?php echo esc_url( $image_url ); ?>" src="data:image/svg+xml,%3Csvg%20xmlns=\'http://www.w3.org/2000/svg\'%20viewBox=\'0%200%20225%20225\'%3E%3C/svg%3E" alt="<?php echo esc_attr( $image_box_title ); ?>">
					<?php
				}
			} else {
				?>
				<img width="55" height="68" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_box_title ); ?>"/>
				<?php
			}
		}
		?>
		</div>
		<div class="anony-grid-col anony-grid-col-8 anony-inline-flex flex-v-center anony-flex-column">
			<?php if ( $image_box_title && ! empty( $image_box_title ) ) { ?>
			<div><strong><?php echo esc_html( $image_box_title ); ?></strong></div>
			<?php } ?>
			<?php if ( $image_box_description && ! empty( $image_box_description ) ) { ?>
			<div><?php echo esc_html( $image_box_description ); ?></div>
			<?php } ?>
		</div>
	</div>
</div>