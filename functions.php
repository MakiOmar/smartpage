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
	'menus'     		  =>'',
	'admin'     		  =>'',
	'media'     		  =>'',
	'widgets'     		  =>'',
	'db'        		  =>'',
	'statistics'          =>'shortcodes/statistics/',
	'ajax-comments'       =>'ajax/',
	'tinymce-editor-btns' =>'mce/' ,
];

foreach($anonylibs as $anonylib=>$path){
	require_once( wp_normalize_path( ANONY_LIBS_DIR . $path . $anonylib.'.php') );
}


/*--------------------------------------smartpage----------------------*/

define('SMPG_DIR', ANONY_THEME_DIR. '/custom-sites/smartpage');


require_once(SMPG_DIR .'/functions.php');



//Just for testing purposes
add_action('wp_footer', function(){
	
});