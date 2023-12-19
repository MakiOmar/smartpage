<?php
/**
 * Adding shortcodes
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Array of shortcodes to be added.
$shcods = array(
	'anony_ltrtext',
	'anony_products_loop',
	'anony_section_title',
	'anony_banner',
);

foreach ( $shcods as $code ) {
	add_shortcode( $code, $code . '_shcode' );
}

/**
 * Renders a banner
 *
 * @param  string $atts    the shortcode attributes.
 * @param  string $content the shortcode content.
 * @return string the text that is to be used to replace the shortcode.
 */
function anony_ltrtext_shcode( $atts, $content = null ) {
	return '<span dir="ltr">' . $content . '</span>';
}

/**
 * Renders a banner
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_banner_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'style'          => 'default',
			'desktop-image'  => '/wp-content/uploads/2023/12/fit.webp',
			'desktop-height' => '450',
			'mobile-image'   => '/wp-content/uploads/2023/12/fit-mobile.webp',
			'mobile-height'  => '200',
		),
		$atts,
		'anony_banner'
	);

	if ( wp_is_mobile() ) {
		$banner_bg = $atts['mobile-image'];
		$height    = $atts['mobile-height'];
	} else {
		$banner_bg = $atts['desktop-image'];
		$height    = $atts['desktop-height'];
	}
	ob_start();
	?>
	<div class="anony-bg-banner" style="background-image: url(<?php echo esc_url( site_url( $banner_bg ) ); ?>);height:<?php echo esc_attr( $height ); ?>px">
	</div>
	<?php
	return ob_get_clean();
}
/**
 * Section title
 *
 * @param  string $atts    the shortcode attributes.
 * @return string Title markup.
 */
function anony_section_title_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'style' => 'default',
			'title' => __( 'Section title', 'samrtpage' ),
		),
		$atts,
		'anony_section_title'
	);
	switch ( $atts['style'] ) {
		case 'one':
			$output = anony_section_title( esc_html( $atts['title'] ) );
			break;
		default:
			$output = anony_section_title( esc_html( $atts['title'] ) );
			break;
	}

	return $output;
}

/**
 * Display products loop
 *
 * @param  string $atts    the shortcode attributes.
 * @return string Products loop output.
 */
function anony_products_loop_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'ids' => '',
		),
		$atts,
		'anony_products_loop'
	);
	// Get the comma-separated IDs and convert them into an array.
	$ids = explode( ',', str_replace( ' ', '', $atts['ids'] ) );
	ob_start();
	echo '<div class="woocommerce anony-flex-grow">';
	ANONY_Woo_Help::products_loop(
		array(
			'loop_args' => array(
				'include' => $ids,
			),
		),
	);
	echo '</div>';
	return ob_get_clean();
}
