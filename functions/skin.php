<?php
/**
 * Theme skin
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme skin
 */
function anony_theme_skin() {
	$anony_options = ANONY_Options_Model::get_instance();

	$primary_color      = $anony_options->primary_skin_color;
	$secondary_color    = $anony_options->secondary_skin_color;
	$menu_color         = $anony_options->main_menu_color;
	$menu_text_color    = $anony_options->main_menu_text_color;
	$menu_hover_color   = $anony_options->main_menu_text_hover_color;
	$links_color        = $anony_options->links_color;
	$footer_text_color  = $anony_options->footer_text_color;
	$footer_links_color = $anony_options->footer_links_color;
	$footer_bg_color    = $anony_options->footer_background_color;
	?>

	<style type="text/css">
		<?php
		if ( class_exists( 'WooCommerce' ) ) {
			?>
				.elementor-wc-products ul.products li.product span.onsale,
				.woocommerce span.onsale,
				.woocommerce ul.products li.product .onsale {
					background-color: <?php echo esc_html( $primary_color ); ?>!important;
				}
				.woocommerce div.product div.images .flex-control-thumbs li img.flex-active, .woocommerce div.product div.images .flex-control-thumbs li img:hover {
					border-color: <?php echo esc_html( $primary_color ); ?>!important;
				}
				.woocommerce div.product p.price,
				.woocommerce div.product span.price,
				.woocommerce ul.products li.product .price
				.comment-text .woocommerce-review__author,
				.woocommerce:where(body:not(.woocommerce-uses-block-theme)) ul.products li.product .price{
					color: <?php echo esc_html( $primary_color ); ?>!important;
				}
				.anony-quantity input.anony-plus,
				.anony-quantity input.anony-minus{
					background-color: <?php echo esc_html( $primary_color ); ?>!important;
				}
				.add_to_cart_button{
					background-color: <?php echo esc_html( $primary_color ); ?>!important;
				}
				.elementor-page .elementor-products-grid ul.products.elementor-grid li.product, .woocommerce ul.products li.product, .woocommerce-page ul.products li.product {
					background-color: #fff;
					border-radius: 15px;
					border: 1px solid <?php echo esc_html( $primary_color ); ?>;
				}
				.woocommerce div.product .sale-counter-rating .woocommerce-product-rating, .custom_sales_counter{
					border-color: <?php echo esc_html( $primary_color ); ?>;
					box-shadow: 2px 2px 0 <?php echo esc_html( $primary_color ); ?>;
				}
				.woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) #respond input#submit, .woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) a.button, .woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) button.button, .woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) input.button, :where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce #respond input#submit, :where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce a.button, :where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce button.button, :where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce input.button{
					background-color: <?php echo esc_html( $primary_color ); ?>;
					color: #fff;
				}
				a.icon-circle:hover, a.remove:hover {
					color: <?php echo esc_html( $primary_color ); ?>!important;
					background-color: transparent;
				}
				.anony-woocommerce div.woocommerce a.remove:hover {
					color: <?php echo esc_html( $secondary_color ); ?>!important;
					border-color: <?php echo esc_html( $secondary_color ); ?>!important;
					background-color: transparent;
				}

				<?php

		}
		?>
		a {
			color: <?php echo esc_html( $links_color ); ?>;
		}
		.anony-skew-bg::after,
		.anony-page-numbers li,
		.anony-active,
		.anony-active-tab,
		.anony-page-numbers a, 
		.widgeted_title, 
		#anony-dun-title,
		#submit,
		.anony-form_submit,
		.anony-featured-posts-title,
		.anony-section_title,
		#anony-page-scroll,
		.anony-button,
		.anony-post-image-wrapper h4,
		.f-post-title,
		.reply,
		.dun_text:after,
		.single-download,
		.anony-toggle-sidebar,
		.anony-popular-tabs span:not(.anony-active-tab):nth-child(2),
		li .current::after, .button, a.button, body.woocommerce a.button, .woocommerce.woocommerce-checkout .shop_table .order-total, .woocommerce .shop_table thead{
			background-color: <?php echo esc_html( $primary_color ); ?>!important;
			color: #fff
		}
		#anony-footer .widgeted_title{
			background-color: transparent!important;
		}
		.anony-multi-col-menu.menu-item-has-children:hover:after{
			border-top: 5px solid <?php echo esc_html( $secondary_color ); ?>;
		}
		#anony-footer p, #anony-footer h1, #anony-footer h2,#anony-footer h3,#anony-footer h4,#anony-footer h5,#anony-footer li,#anony-footer div, #anony-footer span{
			color: <?php echo esc_html( $footer_text_color ); ?>;
		}
		
		#anony-footer a{
			color: <?php echo esc_html( $footer_links_color ); ?>;
		}
		#anony-main_nav_con{
			background-color: <?php echo esc_html( $menu_color ); ?>!important;
		}
		#anony-main-menu-con li a{
			color: <?php echo esc_html( $menu_text_color ); ?>;
		}
		.anony-post-info .anony-nothumb-post .anony-thumb-post-title, #anony-top-header-wrapper, #anony-page-loading-bg {
			border-bottom-color: <?php echo esc_html( $primary_color ); ?>;
		}
		.anony-section, #anony-slider-wrapper {
			border-top-color: <?php echo esc_html( $primary_color ); ?>;
		}
		#cancel-comment-reply-link,
		.fa-bars, #anony-cat-list .toggle-category .fa ,
		.fa-calendar, .fa-comments-o, .fa-folder-open,
		.fa-eye,
		.fa-download,
		.anony-breadcrumbs li,
		.anony-breadcrumbs a{
			color: <?php echo esc_html( $primary_color ); ?>!important;
		}
		
		#anony-main-menu-con .anony-sub-menu li a {
			text-shadow: none;
		}
		.anony-warning {
			background-color: <?php echo esc_html( $primary_color ); ?>;
			border-left: 6px solid <?php echo esc_html( $primary_color ); ?>;
		}
		
		#anony-page-scroll-bg{
			border-left: 2px solid <?php echo esc_html( $primary_color ); ?>;
		}
		.anony-page-numbers, .widgeted_title, .anony-slide-title a, .anony-featured-button, .anony-featured-posts-title a, .anony-section_title, .anony-button, .anony-single_post_title a {
			color: #fff;
		}
		#anony-main-menu-con .anony-sub-menu li {
			border-bottom: 1px solid <?php echo esc_html( $primary_color ); ?>;
		}
		
		.anony-custom-bullets ul li::before, .anony-sub-menu li a {
			color: <?php echo esc_html( $secondary_color ); ?>; /* Change the color */
		}
		#anony-footer{
			background-color: <?php echo esc_html( $footer_bg_color ); ?>;
		}
		.footer-sticky-menu {
			background-color: <?php echo ! empty( $anony_options->mobile_footer_sticky_menu_bg_color ) ? esc_html( $anony_options->mobile_footer_sticky_menu_bg_color ) : 'transparent'; ?>;
		}
		#anony-footer svg path, #anony-footer svg circle{
			stroke:<?php echo esc_html( $anony_options->footer_svg_icons_color ); ?>!important;
		}
		.footer-sticky-menu svg path,.footer-sticky-menu svg circle{
				stroke:<?php echo esc_html( $anony_options->mobile_footer_sticky_menu_icons_color ); ?>!important;
		}
		@media screen and (min-width: 768px) {
			#anony-main-menu-con li a:hover {
			background-color: <?php echo esc_html( $primary_color ); ?>;
			color: <?php echo esc_html( $menu_hover_color ); ?>;
			font-size: 16px;
			}
		}
		
		
	</style>
	<?php
}
add_action( 'wp_head', 'anony_theme_skin' );
