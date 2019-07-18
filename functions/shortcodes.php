<?php
/**
 * Adding shortcodes
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

//Array of shortcodes to be added
$shcods = array('ltrtext');

foreach($shcods as $code){
	add_shortcode( $code, $code.'_shcode' );
}

/*------------------------------------------------------------
*Display LTR text correctly within RTL text
*-----------------------------------------------------------*/
function ltrtext_shcode( $atts,$content = null ){
	return '<span dir="ltr">'.$content.'</span>';
}