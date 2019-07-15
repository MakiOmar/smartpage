<?php
/*
*Shortcodes
*/

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