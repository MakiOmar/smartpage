<?php
/**
 * Template Name: WooCommerce Home
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

get_header();
?>


<div class="woocommerce anony-grid-row">
	
		
	<div class="anony-grid-col anony-flex-grow">
		
		<?php
		if ( class_exists( 'ANONY_Woo_Help' ) ) {
			ANONY_Woo_Help::products_loop();
		}
		?>
	
	</div>
			
</div>

<?php
get_footer();
