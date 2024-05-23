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
<div class="anony-image-box-wrapper">
	<div class="anony-grid-row anony-flex<?php echo esc_attr( $classes ); ?>">
		<div class="anony-grid-col<?php echo 'vertical' !== $layout ? ' anony-grid-col-4' : ''; ?>">
		<?php
		if ( $image_url && ! empty( $image_url ) ) {
			?>
			<a href="<?php echo esc_url( $image_box_link ); ?>" title="<?php echo esc_attr( wp_strip_all_tags( $image_box_title ) ); ?>"><img style="width:<?php echo esc_html( $image_width ); ?>px" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_box_title ); ?>"/></a>
			<?php
		}
		?>
		</div>
		<div class="anony-grid-col<?php echo 'vertical' !== $layout ? ' anony-grid-col-8 ' : ''; ?>anony-inline-flex flex-v-center anony-flex-column">
			<?php if ( $image_box_title && ! empty( $image_box_title ) ) { ?>
			<div><strong><?php echo wp_kses_post( $image_box_title ); ?></strong></div>
			<?php } ?>
			<?php if ( $image_box_description && ! empty( $image_box_description ) ) { ?>
			<div><?php echo wp_kses_post( $image_box_description ); ?></div>
			<?php } ?>
		</div>
	</div>
</div>