<?php
/**
 * Template Name: WooCommerce Home content
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.
if ( ! class_exists( 'ANONY_Woo_Help' ) ) {
	return;
}

$products_sections = array(
	array(
		'title' => 'عروض الإشتراكات',
		'ids'   => array( 6431, 6430, 6429, 6418 ),
	),
	array(
		'title' => 'الأكثر مبيعاً',
		'ids'   => array( 1400, 1400, 5994, 6052 ),
	),
	array(
		'title' => 'مجموعات متكاملة',
		'ids'   => array( 4482, 4984, 4994, 8210 ),
	),
	array(
		'title' => 'المكملات الأكثر رواجاً',
		'ids'   => array( 2767, 2860, 2979, 2987 ),
	),
);

if ( wp_is_mobile() ) {
	$banner_bg = '/wp-content/uploads/2023/12/fit-mobile.webp';
	$height    = '200';
} else {
	$banner_bg = '/wp-content/uploads/2023/12/fit.webp';
	$height    = '450';
}
?>
<div class="anony-bg-banner" style="background-image: url(<?php echo esc_url( site_url( $banner_bg ) ); ?>);height:<?php echo esc_attr( $height ); ?>px">
</div>

<div class="anony-spacer">
</div>
<div class="woocommerce anony-grid-row">
	<?php
	$output = '';
	foreach ( $products_sections as $product_section ) {
		$output .= anony_section_title( esc_html( $product_section['title'] ) );
		$output .= '<div class="anony-grid-col anony-flex-grow">';
		ob_start();
		ANONY_Woo_Help::products_loop(
			array(
				'loop_args' => array(
					'include' => $product_section['ids'],
				),
			),
		);
		$output .= ob_get_clean();
		$output .= '</div>';
	}
	// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $output;
	// phpcs:enable.
	?>
</div>
