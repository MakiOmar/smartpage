<?php
/**
 * Theme/Options confugurations
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

/*---------------------------------------------------------------
 * Define main constants
 *-------------------------------------------------------------*/
/**
 * Holds class/functions prefix
 * @const
 */
define('ANONY_PREFIX'    , 'ANONY_');

/**
 * Holds theme's name
 * @const
 */
define('ANONY_THEME_NAME'    , 'Anonymous');

/**
 * Holds theme's version
 * @const
 */
define('ANONY_THEME_VERSION' , '1.0');

/**
 * Holds theme's text domain
 * @const
 */
define('ANONY_TEXTDOM'       , strtolower(ANONY_THEME_NAME));

/**
 * Holds theme's URI
 * @const
 */
define('ANONY_THEME_URI'     , get_template_directory_uri());

/**
 * Holds theme's path
 * @const
 */
define('ANONY_THEME_DIR'     , wp_normalize_path( get_template_directory() ));

/**
 * Holds functions folder URI
 * @const
 */
define('ANONY_LIBS_URI'      , get_template_directory_uri(). '/functions');


/**
 * Holds functions folder DIR
 * @const
 */
define('ANONY_LIBS_DIR'      , wp_normalize_path(ANONY_THEME_DIR. '/functions/'));


/**
 * Holds core hooks folder URI
 * @const
 */
define('ANONY_CORE_HOOKS_URI'      , get_template_directory_uri(). '/core-hooks');

/**
 * Holds functions folder DIR
 * @const
 */
define('ANONY_CORE_HOOKS_DIR'      , wp_normalize_path(ANONY_THEME_DIR. '/core-hooks/'));

/**
 * Holds main classes folder URI
 * @const
 */
define('ANONY_CLASSES_URI'   , get_template_directory_uri(). '/functions/class');

/**
 * Holds a URI to Custom fields classes folder
 * @const
 */
//define( 'ANONY_INPUT_FIELDS_URI', wp_normalize_path (ANONY_THEME_URI . '/input-fields/'));

/**
 * Holds languages folder URI
 * @const
 */
define('ANONY_LANG_DIR'      , wp_normalize_path(ANONY_THEME_DIR. '/languages/'));

/**
 * Holds rating table name
 * @const
 */
define('ANONY_STAR_RATE'     , $GLOBALS['wpdb']->prefix . 'star_rating' );

/**
 * Holds blog's title
 * @const
 */
define('ANONY_BLOG_TITLE'    , esc_html(get_bloginfo() ));

/**
 * Holds blog's URL
 * @const
 */
define('ANONY_BLOG_URL'      , esc_url(get_bloginfo('url') ));

/*----------------------------------------------------------------------
* Theme Autoloading
*---------------------------------------------------------------------*/

/**
 * Holds a path to main classes folder
 * @const
 */
define( 'ANONY_CLASSES', wp_normalize_path (ANONY_THEME_DIR . '/classes/'));

/**
 * Holds a path to metaboxes class folder
 * @const
 */
define( 'ANONY_METABOXES', wp_normalize_path (ANONY_THEME_DIR . '/metaboxes/'));

/**
 * Holds a path to Custom fields classes folder
 * @const
 */
define( 'ANONY_CUSTOM_FIELDS', wp_normalize_path (ANONY_METABOXES . '/fields/'));

/**
 * Holds a path to Custom fields classes folder
 * @const
 */
define( 'ANONY_INPUT_FIELDS', wp_normalize_path (ANONY_THEME_DIR . '/input-fields/'));

/**
 * Holds a path to Custom fields classes folder
 * @const
 */
define( 'ANONY_INPUT_FIELDS_URI', wp_normalize_path (ANONY_THEME_URI . '/input-fields/'));

/**
 * Holds a path to views classes folder
 * @const
 */
define( 'ANONY_CONTENTS_VIEWS', wp_normalize_path (ANONY_CLASSES . '/views/'));

/**
 * Holds a serialized array of all pathes to classes folders
 * @const
 */
define(
	'ANONY_THEME_AUTOLOADS',
	serialize(
		[
			ANONY_CLASSES,
			ANONY_METABOXES,
			ANONY_CUSTOM_FIELDS,
			ANONY_CONTENTS_VIEWS,
			ANONY_INPUT_FIELDS,
		]
	)
);

/*
*Classes Auto loader
*/
spl_autoload_register( 'anony_theme_autoloader' );

/**
 * Theme classes autoloading.
 * **Description: ** Any class should be writtn in the structure of CLASS_{class_name} or ANONY_cf__{class_name}<br/>
 * **Note: ** Class or CF is optional prefixes, but any prefix should be followed by double underscore, so can get class file name. For example: a class name of XYZ__Class_name is located in file class_name.php.
 * @param  string $class_name
 * @return void
 */
function anony_theme_autoloader( $class_name ) {
	if ( false !== strpos( $class_name, ANONY_PREFIX )) {
		$class_name = strtolower(preg_replace('/'.ANONY_PREFIX.'/', '', $class_name));
		
		$class_name = str_replace('_', '-', $class_name);

		foreach(unserialize( ANONY_THEME_AUTOLOADS ) as $path){
			
			$class_file = wp_normalize_path($path) .$class_name . '.php';

			if(file_exists($class_file)){
				require_once($class_file);
			}else{
				$class_file = wp_normalize_path($path) .$class_name .'/' .$class_name . '.php';
				if(file_exists($class_file)){
					require_once($class_file);
				}
			}

			
			
		}
		

	}
}

/*---------------------------------------------------------------
 * Options configurations
 *-------------------------------------------------------------*/

/**
 * Holds directory separator
 * @const
 */
define('ANONY_DIRS', DIRECTORY_SEPARATOR );

/**
 * Holds options group name
 * @const
 */
define('ANONY_OPTIONS', "Anony_Options");

/**
 * Holds options folder URI
 * @const
 */
define('ANONY_OPTIONS_URI', ANONY_THEME_URI . "/options/");

/*----------------------------------------------------------------------
* Options Autoloading
*---------------------------------------------------------------------*/


/**
 * Holds options folder path
 * @const
 */
define('ANONY_OPTIONS_DIR', wp_normalize_path(ANONY_THEME_DIR . "/options/"));

/**
 * Holds options fields folder path
 * @const
 */
define('ANONY_OPTIONS_FIELDS', wp_normalize_path(ANONY_THEME_DIR . "/options/fields/"));

/**
 * Holds options widgets folder path
 * @const
 */
define('ANONY_OPTIONS_WIDGETS', wp_normalize_path(ANONY_THEME_DIR . "/options/widgets/"));

define(
	'ANONY_OPTIONS_AUTOLOADS' ,
	serialize(
		array(
			ANONY_OPTIONS_DIR , 
			ANONY_OPTIONS_FIELDS, 
			ANONY_OPTIONS_WIDGETS,
			ANONY_INPUT_FIELDS
		)
	)
);

/**
 * Classes Auto loader
 */
spl_autoload_register( 'anony_opts_autoloader' );

/**
 * Options classes autoload.
 *
 * @param  string $class_name 
 */
function anony_opts_autoloader( $class_name ) {
	
	if ( false !== strpos( $class_name, ANONY_PREFIX )) {
		
		$class_name = strtolower(preg_replace('/'.ANONY_PREFIX.'/', '', $class_name));
		
		$class_name = str_replace('_', '-', $class_name);
		
		foreach(unserialize( ANONY_OPTIONS_AUTOLOADS ) as $path){
			
			$class_file = wp_normalize_path($path) .$class_name . '.php';
			
			if(file_exists($class_file)){
				//die($class_file.' exists');
				require_once($class_file);
				
			}else{
				//die($class_file.' not exist');
				$class_file = wp_normalize_path($path. $class_name . ANONY_DIRS) .$class_name . '.php';
				
				if(file_exists($class_file)){
					
					require_once($class_file);
					
				}
			}
		}
		

	}
	
}