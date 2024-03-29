<?php
function anony_theme_skin(){
	$anony_options = ANONY_Options_Model::get_instance();
	
	$primary_color = $anony_options->primary_skin_color;
	$secondary_color = $anony_options->secondary_skin_color; ?>

	<style type="text/css">

		.anony-skew-bg::after, .anony-page-numbers li, .anony-active, .button, .anony-active-tab,
.anony-page-numbers a, .widgeted_title, #anony-dun-title, #submit, .anony-form_submit,
.anony-featured-posts-title, .anony-section_title, #anony-page-scroll, .anony-button,
.anony-post-image-wrapper h4, .f-post-title, .reply, .dun_text:after, .single-download, .anony-toggle-sidebar, #anony-main_nav_con, .anony-popular-tabs span:not(.anony-active-tab):nth-child(2), li .current::after, .elementor-wc-products ul.products li.product span.onsale, .woocommerce span.onsale, .woocommerce ul.products li.product .onsale {
		  background-color: <?php echo esc_html( $primary_color ) ;?>!important;
		}
		.anony-post-info .anony-nothumb-post .anony-thumb-post-title, #anony-top-header-wrapper, #anony-page-loading-bg {
		  border-bottom-bottom: <?php echo esc_html( $primary_color ) ;?>;
		}
		.anony-section, #anony-slider-wrapper {
		  border-top-color: <?php echo esc_html( $primary_color ) ;?>;
		}
		#cancel-comment-reply-link,
		.fa-bars, #anony-cat-list .toggle-category .fa ,
		#anony-main-menu-con .anony-sub-menu li a,
		.fa-calendar, .fa-comments-o, .fa-folder-open,
		.fa-eye,
		.fa-download,
		.anony-breadcrumbs li,
		.anony-breadcrumbs a,
		.woocommerce ul.products li.product .price {
		  color: <?php echo esc_html( $primary_color ); ?>!important;
		}
		#anony-main-menu-con .anony-sub-menu li a {
		  text-shadow: none;
		}
		.anony-warning {
		  background-color: <?php echo esc_html( $primary_color ) ;?>;
		  border-left: 6px solid <?php echo esc_html( $primary_color ) ;?>;
		}
		
		#anony-page-scroll-bg{
			border-left: 2px solid <?php echo esc_html( $primary_color ) ;?>;
		}
		.anony-page-numbers, #anony-main-menu-con .anony-sub-menu li a, .widgeted_title, .anony-slide-title a, .anony-featured-button, .anony-featured-posts-title a, .anony-section_title, .anony-button, .anony-single_post_title a {
		  color: #fff;
		}
		#anony-main-menu-con .anony-sub-menu li {
		  border-bottom: 1px solid <?php echo esc_html( $primary_color ) ;?>;
		  background-color: <?php echo esc_html( $primary_color ) ;?>;
		}
		
		.anony-custom-bullets ul li::before {
		  color: <?php echo esc_html( $secondary_color ) ;?>; /* Change the color */
		}
		@media screen and (min-width: 768px) {
		  #anony-main-menu-con li a:hover {
			background-color: <?php echo esc_html( $primary_color ) ;?>;
			font-size: 16px;
		  }
		}
		
		
	</style>
<?php }
add_action( 'wp_head', 'anony_theme_skin' );