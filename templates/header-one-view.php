<?php
/**
 * Header one template
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
require 'document-head.php';
$my_account_url = class_exists( 'WooCommerce' ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : '#';
?>
<header id="anony-header-wrapper" class="anony-header white-bg <?php echo 'header_style_' . esc_attr( ANONY_HEADER_STYLE ) . esc_attr( $sticky_class ); ?>">
	<?php do_action( 'anony_before_header_content' ); ?>
	<div class="anony-grid-row anony-header-content white-bg">
		<div class="anony-grid-col anony-grid-col-2 anony-inline-flex flex-h-center flex-v-center">
			<?php
			// phpcs:disable
			echo '<div id="header-style-one-logo">' . anony_get_theme_logo() . '</div>';
			// phpcs:enable.
			?>
		</div>
		<div class="anony-grid-col anony-grid-col-8 anony-inline-flex flex-h-center flex-v-center">
			<!-- Navigation menu -->
			<?php echo wp_kses_post( $nav ); ?>
			<!-- Mobile Navigation menu toggle -->
			<!-- <div id="menu-close"><a href="#"><i class="fa fa-2x fa-window-close" aria-hidden="true"></i></a></div>-->
		</div>
		<div class="anony-grid-col anony-grid-col-2 anony-inline-flex flex-h-center flex-v-center">
			<?php
			require 'partials/fullwidth-search-form-view.php';
			if ( class_exists( 'WooCommerce' ) ) {
				require 'partials/mini-cart.php';
				?>
				<a class="anony-inline-flex" href="<?php echo esc_url( $my_account_url ); ?>" title="<?php echo esc_attr__( 'Account', 'smartpage' ); ?>">
					<svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.8462 20C10.1892 20 8.5748 19.4652 7.2343 18.4721C5.8938 17.4791 4.89604 16.0789 4.38402 14.4721C3.87199 12.8654 3.87199 11.1346 4.38402 9.52786C4.89604 7.92112 5.8938 6.52089 7.2343 5.52786C8.5748 4.53484 10.1892 4 11.8462 4C13.5031 4 15.1175 4.53484 16.458 5.52787C17.7985 6.52089 18.7963 7.92112 19.3083 9.52787C19.8203 11.1346 19.8203 12.8654 19.3083 14.4721M18.1667 12.8889L19.2564 14.6667L21 13.3333M13.5897 9.33333C13.5897 10.3152 12.8091 11.1111 11.8462 11.1111C10.8832 11.1111 10.1026 10.3152 10.1026 9.33333C10.1026 8.35149 10.8832 7.55556 11.8462 7.55556C12.8091 7.55556 13.5897 8.35149 13.5897 9.33333ZM10.2872 12.8889H13.4051C13.6856 12.8889 13.8258 12.8889 13.9512 12.9094C14.3853 12.9803 14.7607 13.2294 14.971 13.5862C15.0317 13.6893 15.0761 13.8118 15.1648 14.0568C15.2713 14.3512 15.3246 14.4984 15.3318 14.6171C15.3572 15.0359 15.0612 15.4141 14.6217 15.5243C14.4971 15.5556 14.3287 15.5556 13.9917 15.5556H9.70063C9.36366 15.5556 9.19517 15.5556 9.0706 15.5243C8.63108 15.4141 8.33507 15.0359 8.36049 14.6171C8.3677 14.4984 8.42098 14.3512 8.52754 14.0568C8.61622 13.8118 8.66056 13.6893 8.72133 13.5862C8.93163 13.2294 9.307 12.9803 9.74109 12.9094C9.86652 12.8889 10.0067 12.8889 10.2872 12.8889Z" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</a>
				<?php
			}
			?>
		</div>
	</div>
	<?php do_action( 'anony_after_header_content' ); ?>
</header>
