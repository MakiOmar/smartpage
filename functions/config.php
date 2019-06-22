<?php
define( 'DIRS', DIRECTORY_SEPARATOR );

define( 'THEME_DIR', wp_normalize_path( get_template_directory() ) );

define( 'THEME_URI', get_template_directory_uri() );

define( 'THEME_NAME', 'Smartpage' );

define( 'TEXTDOM', strtolower(THEME_NAME) );

define( 'THEME_VERSION', '1.0' );

//define( 'LIBS_DIR', wp_normalize_path (THEME_DIR . abstracted_generate_path(array('functions'))));

define( 'SMPG_CLASSES', wp_normalize_path (LIBS_DIR . abstracted_generate_path(array('smpg'))));

define( 'LANG_DIR', wp_normalize_path(THEME_DIR. abstracted_generate_path(array('languages'))));

define( 'STAR_RATE', $GLOBALS['wpdb']->prefix . 'star_rating' );

define( 'BLOG_TITLE', get_bloginfo() );

define( 'BLOG_URL', get_bloginfo('url') );

define( 'SMPG_OPTIONS', 'Smpg_Options' );

define( 'SMPG_OPTIONS_URI', wp_normalize_path (THEME_URI . abstracted_generate_path(array('functions', 'options'))));

define('SuppTypes',serialize(array('pdf','doc','docx','7z','arj','deb','zip','iso','pkg','rar','rpm','z','gz','bin','dmg','toast','vcd','csv','dat','log','mdb','sav','tar','ods','xlr','xls','xlsx','odt','txt','rtf','tex','wks','wps','wpd')));

/*
*Classes Auto loader
*/
spl_autoload_register( 'smpg_autoloader' );

/*
*@param  string $class_name 
*/
function smpg_autoloader( $class_name ) {

	if ( false !== strpos( $class_name, 'Smpg__' )) {

		$class_sub =  preg_replace('/__/', DIRS, strtolower($class_name));

		$classes_dir = THEME_DIR .abstracted_generate_path(array('functions'));

		$class_path =  wp_normalize_path($classes_dir) . str_replace('_','-',$class_sub) . '.php';

		if(file_exists($class_path)){

			require_once $class_path;

		}


	}

}