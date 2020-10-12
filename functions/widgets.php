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

//Register Sidebars
add_action('widgets_init',function(){
	

	$sidebars = 
		[
			'main-sidebar'      => esc_html__( 'Main Sidebar', ANONY_TEXTDOM ),
			'right-sidebar'     => esc_html__( 'Right Sidebar', ANONY_TEXTDOM ),
			'left-sidebar'      => esc_html__( 'Left Sidebar', ANONY_TEXTDOM ) ,
			'secondary-sidebar' => esc_html__( 'Secondary Sidebar', ANONY_TEXTDOM ),
			'footer-widget-1'   => esc_html__( 'Footer Widget 1', ANONY_TEXTDOM ),
			'footer-widget-2'   => esc_html__( 'Footer Widget 2', ANONY_TEXTDOM ),
			'footer-widget-3'   => esc_html__( 'Footer Widget 3', ANONY_TEXTDOM ),
			'footer-widget-4'   => esc_html__( 'Footer Widget 4', ANONY_TEXTDOM )
		];
	foreach($sidebars as $sidebar_id => $sidebar){
	    $args = array(
			'name'          => $sidebar,
			'id'            => $sidebar_id,
			'class'         => $sidebar_id,
			'before_widget' => '<div class="white-bg widgeted anony-grid-col-md-6 anony-grid-col-av-6 anony-grid-col-sm-12 anony-grid-col">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgeted_title">',
			'after_title'   => '</h3>' 
	    );
	   register_sidebar( $args );
	}
});

add_filter('dynamic_sidebar_params',function ($param){
		
	if(!is_rtl() && $param[0]['id'] == 'right-sidebar'){
		
		$param[0]['name'] = esc_html__( 'Left Sidebar', ANONY_TEXTDOM );
		
	}
	
	if(!is_rtl() && $param[0]['id'] == 'left-sidebar'){

		$param[0]['name'] = esc_html__( 'Right Sidebar', ANONY_TEXTDOM );
		
	}
	
	//nvd($param);
    return $param;
}, 20);



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