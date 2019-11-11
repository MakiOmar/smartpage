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
		'ANONY__Cats_Widget',
		'ANONY__Related_Posts_Widget',
		'ANONY__Posts_Widget',
	);
	
	foreach($reg_widgets as $reg_widget){
		register_widget($reg_widget);
	}
	
	
});