<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
require_once(wp_normalize_path(get_template_directory() . '/config/config.php'));

if (!defined('ANOENGINE')) return;

//Functions files
$anonylibs = [
	'theme-helpers'       =>'',
	'theme-options'       =>'',
	'posts'     		  =>'',
	'scripts'     		  =>'',
	'theme'     		  =>'',
	'performance'     	  =>'',
	'menus'     		  =>'',
	'admin'     		  =>'',
	'media'     		  =>'',
	'widgets'     		  =>'',
	'db'        		  =>'',
	'custom-fields'       =>'',
	'statistics'          =>'shortcodes/statistics/',
	'ajax-comments'       =>'ajax/',
	'ajax-download'       =>'ajax/',
	'tinymce-editor-btns' =>'mce/' ,
];

foreach($anonylibs as $anonylib=>$path){
	require_once( wp_normalize_path( ANONY_LIBS_DIR . $path . $anonylib.'.php') );
}

//Just for testing purposes
add_action('wp_footer', function(){
	
});