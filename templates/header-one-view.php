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
?>
<header class="white-bg <?php echo 'header_style_' . esc_attr( ANONY_HEADER_STYLE ); ?>">
	<div class="anony-grid-row">
		<div class="anony-grid-col anony-grid-col-2 anony-inline-flex flex-h-center flex-v-center">
			<?php
			// phpcs:disable
			$logo = anony_get_custom_logo( 'orange' );
			echo '<div id="header-style-one-logo">' . $logo . '</div>';
			// phpcs:enable.
			?>
		</div>
		<div class="anony-grid-col anony-grid-col-8 anony-inline-flex flex-h-center flex-v-center">
			<!-- Navigation menu -->
			<?php echo $nav; ?>
			<!-- Mobile Navigation menu toggle -->
			<!-- <div id="menu-close"><a href="#"><i class="fa fa-2x fa-window-close" aria-hidden="true"></i></a></div>-->
		</div>
		<div class="anony-grid-col anony-grid-col-2 anony-inline-flex flex-h-center flex-v-center">
			<div id="anony-hidden-search-form">
				<a class="anony-search-form-toggle" href="#" title="Scroll page">
					<i class="fa fa-search"></i>
				</a>
				<?php get_search_form(); ?>
			</div>
			<?php
			if ( class_exists( 'ANONY_Options_Model' ) ) {
				$anony_options     = ANONY_Options_Model::get_instance();
				$search_icon_color = $anony_options->main_menu_search_icon_color;
			} else {
				$search_icon_color = '#000';
			}

			echo '<div class="anony-search-form-toggle active"><a href="#" title="' . esc_attr__( 'Search', 'smartpage' ) . '"><svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<g clip-path="url(#clip0_15_152)">
				<rect width="24" height="24" fill="none"/>
				<circle cx="10.5" cy="10.5" r="6.5" stroke="' . esc_attr( $search_icon_color ) . '" stroke-linejoin="round"/>
				<path d="M19.6464 20.3536C19.8417 20.5488 20.1583 20.5488 20.3536 20.3536C20.5488 20.1583 20.5488 19.8417 20.3536 19.6464L19.6464 20.3536ZM20.3536 19.6464L15.3536 14.6464L14.6464 15.3536L19.6464 20.3536L20.3536 19.6464Z" fill="' . esc_attr( $search_icon_color ) . '"/>
				</g>
				<defs>
				<clipPath id="clip0_15_152">
				<rect width="24" height="24" fill="white"/>
				</clipPath>
				</defs>
				</svg></a></div>';
			require 'partials/mini-cart.php';
			?>
		</div>
	</div>

</header>
