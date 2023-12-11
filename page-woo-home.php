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

<div class="anony-spacer"></div>
<div class="woocommerce anony-grid-row">
	<?php echo anony_section_title( 'عروض الإشتراكات' ); ?>	
	<div class="anony-grid-col anony-flex-grow">
		
		<?php
		if ( class_exists( 'ANONY_Woo_Help' ) ) {
			ANONY_Woo_Help::products_loop(
				array(
					'loop_args' => array(
						'include' => array( 6431, 6430, 6429, 6418 ),
					),
				),
			);
		}
		?>
	
	</div>

	<?php echo anony_section_title( 'الأكثر مبيعاً' ); ?>	
	<div class="anony-grid-col anony-flex-grow">
		
		<?php
		if ( class_exists( 'ANONY_Woo_Help' ) ) {
			ANONY_Woo_Help::products_loop(
				array(
					'loop_args' => array(
						'include' => array( 1400, 1400, 5994, 6052 ),
					),
				),
			);
		}
		?>
	
	</div>

	<?php echo anony_section_title( 'مجموعات متكاملة' ); ?>	
	<div class="anony-grid-col anony-flex-grow">
		
		<?php
		if ( class_exists( 'ANONY_Woo_Help' ) ) {
			ANONY_Woo_Help::products_loop(
				array(
					'loop_args' => array(
						'include' => array( 4482, 4984, 4994, 8210 ),
					),
				),
			);
		}
		?>
	
	</div>

	<?php echo anony_section_title( 'المكملات الأكثر رواجاً' ); ?>	
	<div class="anony-grid-col anony-flex-grow">
		
		<?php
		if ( class_exists( 'ANONY_Woo_Help' ) ) {
			ANONY_Woo_Help::products_loop(
				array(
					'loop_args' => array(
						'include' => array( 2767, 2860, 2979, 2987 ),
					),
				),
			);
		}
		?>
	
	</div>
			
</div>

<?php
get_footer();
