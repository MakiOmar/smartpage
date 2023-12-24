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
		<?php if ( $image_url && ! empty( $image_url ) ) { ?>
			<img src="<?php echo esc_url( $image_url ); ?>"/>
		<?php } ?>
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