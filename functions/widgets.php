<?php
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
		'Class__Cats_Widget',
		'Class__Related_Posts_Widget',
	);
	
	foreach($reg_widgets as $reg_widget){
		register_widget($reg_widget);
	}
	
	
});