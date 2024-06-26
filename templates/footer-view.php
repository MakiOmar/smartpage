<?php
/**
 * Main footer
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
$anony_options = ANONY_Options_Model::get_instance();
?>
<footer id="anony-footer" class="anony-grid-col">
	<?php
	if ( '1' === $anony_options->only_one_col_footer ) {
		?>
		<div id="anony-footer-one-col">
			<?php anony_dynamic_sidebar( 'footer-one-col' ); ?>
		</div>
		<?php
	} else {
		if ( '1' === $anony_options->enable_footer_top ) {
			?>
			<div id="anony-top-footer" class="anony-grid-row">
				<div class="anony-grid-col anony-grid-col-sm-4"><?php anony_dynamic_sidebar( 'top-footer-widget-1' ); ?></div>
				<div class="anony-grid-col anony-grid-col-sm-4"><?php anony_dynamic_sidebar( 'top-footer-widget-2' ); ?></div>
				<div class="anony-grid-col anony-grid-col-sm-4"><?php anony_dynamic_sidebar( 'top-footer-widget-3' ); ?></div>
			</div>
			<?php
		}
		?>
		<div id="anony-main-footer" class="anony-grid-row">
			<div class="anony-grid-col anony-grid-col-sm-2">
				<?php anony_dynamic_sidebar( 'footer-widget-1' ); ?>
			</div>
			<div class="anony-grid-col anony-grid-col-sm-2">
			<?php anony_dynamic_sidebar( 'footer-widget-2' ); ?>
			</div>
			<div class="anony-grid-col anony-grid-col-sm-5">
			<?php anony_dynamic_sidebar( 'footer-widget-3' ); ?>
			</div>
			<div class="anony-grid-col anony-grid-col-sm-3">
			<?php anony_dynamic_sidebar( 'footer-widget-4' ); ?>
			</div>
		</div>
		<?php
		if ( '1' === $anony_options->enable_footer_bottom ) {
			?>
			<div id="anony-bottom-footer" class="anony-grid-row">
				<div class="anony-grid-col anony-grid-col-sm-4"><?php anony_dynamic_sidebar( 'bottom-footer-widget-1' ); ?></div>
				<div class="anony-grid-col anony-grid-col-sm-4"><?php anony_dynamic_sidebar( 'bottom-footer-widget-2' ); ?></div>
				<div class="anony-grid-col anony-grid-col-sm-4"><?php anony_dynamic_sidebar( 'bottom-footer-widget-3' ); ?></div>
			</div>
			<?php
		}
	}
	?>
	<?php
	if ( wp_is_mobile() && '1' === $anony_options->enable_mobile_footer_sticky ) {
		switch ( ANONY_FOOTER_STICKY_MENU_STYLE ) {
			case ( 'one' ):
				get_template_part( 'templates/partials/mobile-footer-menu-view', 'one' );
				break;
			case ( 'custom' ):
				get_template_part( 'templates/partials/mobile-footer-menu-view', 'custom' );
				break;
			default:
				get_template_part( 'templates/partials/mobile-footer-menu', 'view' );

		}
	}

	get_template_part( 'templates/partials/page', 'scroll' );
	?>
	<?php do_action( 'anony_before_footer_closing' ); ?>
</footer>
<?php do_action( 'anony_after_footer_closing' ); ?>
<?php require 'partials/document-closing.php'; ?>
