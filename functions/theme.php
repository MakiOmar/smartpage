<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Theme Functions
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

add_action( 'after_setup_theme', function() {
	//Add theme support
	anony_add_theme_support();
	
	//Load Text Domain
	load_theme_textdomain(ANONY_TEXTDOM, ANONY_LANG_DIR);
	
	//hide admin bar for non admins
	anony_hide_admin_bar();
	
}, 20 );

//Register Sidebars
add_action('widgets_init',function(){
	$sidebars = array('Right Sidebar','left Sidebar','Secondary Sidebar','Footer Widget 1','Footer Widget 2','Footer Widget 3','Footer Widget 4');
	foreach($sidebars as $sidebar){
	    $sidebar_id = strtolower(str_replace(' ','-',$sidebar ));
	    $args = array(
			'name'=> esc_html__( $sidebar, ANONY_TEXTDOM ),
			'id'=> $sidebar_id,
			'class'=>$sidebar_id,
			'before_widget' => '<div class="white-bg widgeted anony-grid-col-md-6 anony-grid-col-av-6 anony-grid-col-sm-12 anony-grid-col">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgeted_title">',
			'after_title'   => '</h3>' 
	    );
	   register_sidebar( $args );
	}
});

//Remove width|height from img
add_filter( 'post_thumbnail_html', function ( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}, 10, 5 );

//Remove type attribute from styles.
add_filter('style_loader_tag', 'anony_remove_type_attr', 10, 2);

//Remove type attribute from scripts.
add_filter('script_loader_tag', 'anony_remove_type_attr', 10, 2);

// custom login logo tooltip
add_filter('login_headertext', function(){
	
	$anonyOptions = anonyOpt();
	
	if(anonyGetOpt($anonyOptions, 'change_login_title') != '0'){
		
		return get_bloginfo();
	}
});

add_action('init', function(){
	
	anony_restrict_admin_access();
	
	anony_display_ads();
}, 200);

//controls add query strings to scripts/styles
function anony_control_query_strings($src, $handle){
	if(is_admin()) return $src;

	$anonyOptions = ANONY_Options_Model::get_instance();
	
	//Keep query string for these items
	$neglected = array();
	
	if(!empty($anonyOptions->keep_query_string)){
		$neglected = explode(',',$anonyOptions->keep_query_string);
	}
	
	if($anonyOptions->query_string != '0' && !in_array( $handle, $neglected )){
		$src = remove_query_arg('ver', $src);
	}
	return $src;
	
}


//controls add query strings to scripts
add_filter( 'script_loader_src', 'anony_control_query_strings', 15, 2 );

//controls add query strings to styles
add_filter( 'style_loader_src', 'anony_control_query_strings', 15, 2);

?>