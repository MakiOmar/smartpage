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
);

foreach ( $shcods as $code ) {
	add_shortcode( $code, $code . '_shcode' );
}

/**
 * Display LTR text correctly within RTL text
 *
 * @param  string $atts    the shortcode attributes.
 * @param  string $content the shortcode content.
 * @return string the text that is to be used to replace the shortcode.
 */
function anony_ltrtext_shcode( $atts, $content = null ) {
	return '<span dir="ltr">' . $content . '</span>';
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
