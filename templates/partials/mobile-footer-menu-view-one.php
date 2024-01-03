<?php
/**
 * Mobile footer menu
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

$my_account_url = class_exists( 'WooCommerce' ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : '#';
?>
<div id="anony-mobile-footer-menu" class="anony-grid-row footer-sticky-menu footer-sticky-menu-one anony-flex-column anony-box-shadow">
	<?php
	if ( is_singular( 'product' ) ) {
		global $product;
		if ( wp_is_mobile() ) {
			define( 'FOOTER_ADD_TO_CART', true );
			?>
			<div class="anony-grid-row anony-footer-add-to-cart">
				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>
			<?php
		}
	}
	?>
	<div class="anony-grid-row">
		<div class="anony-grid-col anony-grid-10-col-slg-2 anony-inline-flex flex-h-center flex-v-center">
			<a id="anony-mobile-footer-menu-categories" class="anony-inline-flex" href="<?php echo esc_url( site_url( '/our-categories' ) ); ?>" title="<?php esc_attr_e( 'Categories', 'smartpage' ); ?>">
				<svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g clip-path="url(#clip0_429_11052)">
					<circle cx="17" cy="7" r="3" stroke="#292929" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
					<circle cx="7" cy="17" r="3" stroke="#292929" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M14 14H20V19C20 19.5523 19.5523 20 19 20H15C14.4477 20 14 19.5523 14 19V14Z" stroke="#292929" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M4 4H10V9C10 9.55228 9.55228 10 9 10H5C4.44772 10 4 9.55228 4 9V4Z" stroke="#292929" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
					</g>
					<defs>
					<clipPath id="clip0_429_11052">
					<rect width="24" height="24" fill="white"/>
					</clipPath>
					</defs>
				</svg>
			</a>
		</div>
		<div id="anony-mobile-footer-menu-orders" class="anony-grid-col anony-grid-10-col-slg-2 anony-inline-flex flex-h-center flex-v-center">
			<a class="anony-inline-flex" href="<?php echo esc_url( site_url( '/my-orders' ) ); ?>" title="<?php esc_attr_e( 'My orders', 'smartpage' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M2 10.9902V20.9902C2 21.8202 2.93998 22.2902 3.59998 21.7902L5.31 20.5102C5.71 20.2102 6.27 20.2502 6.63 20.6102L8.28998 22.2802C8.67998 22.6702 9.32002 22.6702 9.71002 22.2802L11.39 20.6002C11.74 20.2502 12.3 20.2102 12.69 20.5102L14.4 21.7902C15.06 22.2802 16 21.8102 16 20.9902V3.99023C16 2.89023 16.9 1.99023 18 1.99023H7H6C3 1.99023 2 3.78023 2 5.99023V6.99023" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M22 5.99023V8.41023C22 9.99023 21 10.9902 19.42 10.9902H16V4.00023C16 2.89023 16.91 1.99023 18.02 1.99023C19.11 2.00023 20.11 2.44023 20.83 3.16023C21.55 3.89023 22 4.89023 22 5.99023Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M10.98 8.99023H12" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6 8.99023H7.96002" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6.75 12.9902H11.25" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
			</a>
		</div>
		<div class="anony-grid-col anony-grid-10-col-slg-2 anony-inline-flex flex-h-center flex-v-center">
			<a class="anony-inline-flex" href="<?php echo esc_url( site_url() ); ?>" title="<?php esc_attr_e( 'Home', 'smartpage' ); ?>">
				<svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
					<path d="M15 18H9" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
				</svg>
			</a>
		</div>
		<div id="anony-mobile-footer-menu-wishlist" class="anony-grid-col anony-grid-10-col-slg-2 anony-inline-flex flex-h-center flex-v-center">
			<a class="anony-inline-flex" href="<?php echo esc_url( site_url( '/wishlist' ) ); ?>" title="<?php esc_attr_e( 'My wishlist', 'smartpage' ); ?>">
				<svg width="24px" height="24px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#000000" fill="none"><path d="M9.06,25C7.68,17.3,12.78,10.63,20.73,10c7-.55,10.47,7.93,11.17,9.55a.13.13,0,0,0,.25,0c3.25-8.91,9.17-9.29,11.25-9.5C49,9.45,56.51,13.78,55,23.87c-2.16,14-23.12,29.81-23.12,29.81S11.79,40.05,9.06,25Z"/></svg>
			</a>
		</div>
		<div class="anony-grid-col anony-grid-10-col-slg-2 anony-inline-flex flex-h-center flex-v-center">
			<a id="anony-mobile-footer-menu-account" class="anony-inline-flex" href="<?php echo esc_url( $my_account_url ); ?>" title="<?php esc_attr_e( 'My account', 'smartpage' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none"><path d="M18.2933 4.61024C18.8533 5.43858 19.18 6.43024 19.18 7.50358C19.1683 10.3036 16.9633 12.5786 14.1866 12.6719C14.07 12.6602 13.93 12.6602 13.8016 12.6719C11.2233 12.5902 9.13498 10.6186 8.85498 8.09858C8.51664 5.10024 10.9783 2.32358 13.9883 2.32358M8.15498 16.9769C5.33164 18.8669 5.33164 21.9469 8.15498 23.8252C11.3633 25.9719 16.625 25.9719 19.8333 23.8252C22.6566 21.9352 22.6566 18.8552 19.8333 16.9769C16.6483 14.8419 11.3866 14.8419 8.15498 16.9769Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
			</a>
		</div>
	</div>
</div>
