<?php
/**
 * Theme confugurations
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */




/*
*Define theme constants
*Other constants depends on these ones
*/
$theme_constants = array(
	'THEME_NAME'    => 'Anonymous',
	'THEME_DIR'     => wp_normalize_path( get_template_directory() ),
);
foreach($theme_constants as $theme_constant => $v){
	if(!defined($theme_constant)){
		define($theme_constant, $v);
	}
}

//Define theme constants
$theme_constants = array(
	'THEME_VERSION' => '1.0',
	'THEME_URI'     => get_template_directory_uri(),
	'LIBS_URI'      => get_template_directory_uri(). '/functions',
	'CLASSES_URI'   => get_template_directory_uri(). '/functions/class',
	'TEXTDOM'       => strtolower(THEME_NAME),
	'LANG_DIR'      => wp_normalize_path(THEME_DIR. '/languages/'),
	'STAR_RATE'     => $GLOBALS['wpdb']->prefix . 'star_rating' ,
	'BLOG_TITLE'    => esc_html(get_bloginfo() ),
	'BLOG_URL'      => esc_url(get_bloginfo('url') ),
);
foreach($theme_constants as $theme_constant => $v){
	if(!defined($theme_constant)){
		define($theme_constant, $v);
	}
}
/*----------------------------------------------------------------------
*Autoloading
*---------------------------------------------------------------------*/

/**
 * Holds a path to main classes folder
 * @const
 */
define( 'ANONY_CLASSES', wp_normalize_path (LIBS_DIR . '/class/'));

/**
 * Holds a path to metaboxes class folder
 * @const
 */
define( 'ANONY_METABOXES', wp_normalize_path (THEME_DIR . '/metaboxes/'));

/**
 * Holds a path to Custom fields classes folder
 * @const
 */
define( 'ANONY_CUSTOM_FIELDS', wp_normalize_path (ANONY_METABOXES . '/cf/'));

/**
 * Holds a path to views classes folder
 * @const
 */
define( 'ANONY_CONTENTS_VIEWS', wp_normalize_path (ANONY_CLASSES . '/views/'));

/**
 * Holds a serialized array of all pathes to classes folders
 * @const
 */
define('ANONY_THEME_AUTOLOADS' ,serialize(array(ANONY_CLASSES, ANONY_METABOXES, ANONY_CUSTOM_FIELDS, ANONY_CONTENTS_VIEWS)));

/*
*Classes Auto loader
*/
spl_autoload_register( 'anony_theme_autoloader' );

/**
 * Theme autoloading.
 * **Description: ** Any class should be writtn in the structure of Class__{class_name} or CF__{class_name}<br/>
 * **Note: ** Class or CF should correspond to classes folder name, and can be any name not just Class or CF
 * @param  string $class_name
 * @return void
 */
function anony_theme_autoloader( $class_name ) {
	if ( false !== strpos( $class_name, '__' )) {
		$class_name = preg_replace('/\w+__/', '', strtolower($class_name));

		$class_name  = str_replace('_', '-', $class_name);

		foreach(unserialize( ANONY_THEME_AUTOLOADS ) as $path){
			$class_file = wp_normalize_path($path) .$class_name . '.php';
			if(file_exists($class_file)){
				require_once($class_file);
			}
		}
		

	}
}

/*---------------------End autoloading---------------------------------*/