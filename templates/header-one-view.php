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
			echo '<div id="header-style-one-logo">' . anony_get_theme_logo() . '</div>';
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
			<?php
			require 'partials/fullwidth-search-form-view.php';
			require 'partials/mini-cart.php';
			?>
		</div>
	</div>

</header>
