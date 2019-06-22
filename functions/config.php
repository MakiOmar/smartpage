<?php
define( 'DIRS', DIRECTORY_SEPARATOR );

define( 'THEME_DIR', wp_normalize_path( get_template_directory() ) );

define( 'THEME_URI', get_template_directory_uri() );

define( 'THEME_NAME', 'Smartpage' );

define( 'TEXTDOM', strtolower(THEME_NAME) );

define( 'THEME_VERSION', '1.0' );

//define( 'LIBS_DIR', wp_normalize_path (THEME_DIR . abstracted_generate_path(array('functions'))));

define( 'SMPG_CLASSES', wp_normalize_path (LIBS_DIR . abstracted_generate_path(array('smpg'))));

//Custom fileds classes
define( 'SMPG_CF_CLASSES', wp_normalize_path (SMPG_CLASSES . abstracted_generate_path(array('cf'))));

//views classes
define( 'SMPG_VIEWS_CLASSES', wp_normalize_path (SMPG_CLASSES . abstracted_generate_path(array('views'))));

define( 'LANG_DIR', wp_normalize_path(THEME_DIR. abstracted_generate_path(array('languages'))));

define( 'STAR_RATE', $GLOBALS['wpdb']->prefix . 'star_rating' );

define( 'BLOG_TITLE', get_bloginfo() );

define( 'BLOG_URL', get_bloginfo('url') );

define( 'SMPG_OPTIONS', 'Smpg_Options' );

define( 'SMPG_OPTIONS_URI', wp_normalize_path (THEME_URI . abstracted_generate_path(array('functions', 'options'))));

define('SuppTypes',serialize(array('pdf','doc','docx','7z','arj','deb','zip','iso','pkg','rar','rpm','z','gz','bin','dmg','toast','vcd','csv','dat','log','mdb','sav','tar','ods','xlr','xls','xlsx','odt','txt','rtf','tex','wks','wps','wpd')));


define('SMPG_THEME_AUTOLOADS' ,serialize(array(SMPG_CLASSES, SMPG_CF_CLASSES, SMPG_VIEWS_CLASSES)));
/*
*Classes Auto loader
*/
spl_autoload_register( 'thm_autoloader' );

/*
*@param  string $class_name 
*/
function thm_autoloader( $class_name ) {
	if ( false !== strpos( $class_name, '__' )) {
		$class_name = preg_replace('/\w+__/', '', strtolower($class_name));

		$class_name  = str_replace('_', '-', $class_name);

		foreach(unserialize( SMPG_THEME_AUTOLOADS ) as $path){
			$class_file = wp_normalize_path($path) .$class_name . '.php';
			if(file_exists($class_file)){
				require_once($class_file);
			}
		}
		

	}
}