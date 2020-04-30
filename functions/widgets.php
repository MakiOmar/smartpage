<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Widgets functions
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

/**
 * Register categories widget
 */
add_action('widgets_init', function (){
	
	$reg_widgets = array(
		'ANONY_Cats_Widget',
		'ANONY_Related_Posts_Widget',
		'ANONY_Posts_Widget',
	);
	
	foreach($reg_widgets as $reg_widget){
		register_widget($reg_widget);
	}
	
	
});