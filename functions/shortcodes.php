<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}

/**
 * Adding shortcodes
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

// Array of shortcodes to be added
$shcods = array( 'ltrtext' );

foreach ( $shcods as $code ) {
	add_shortcode( $code, $code . '_shcode' );
}

/**
 * Display LTR text correctly within RTL text
 *
 * @param  string $atts    the shortcode attributes
 * @param  string $content the shortcode content
 * @return string the text that is to be used to replace the shortcode
 */
function ltrtext_shcode( $atts, $content = null ) {
	 return '<span dir="ltr">' . $content . '</span>';
}
