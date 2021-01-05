<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Theme/Options confugurations
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

require_once('required-plugins.php');
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
define('ANONY_BLOG_URL'      , esc_url(home_url()));

/*----------------------------------------------------------------------
* Theme Autoloading
*---------------------------------------------------------------------*/

/**
 * Holds a path to main classes folder
 * @const
 */
define( 'ANONY_CLASSES', wp_normalize_path (ANONY_THEME_DIR . '/classes/'));


/**
 * Holds a path to views classes folder
 * @const
 */
define( 'ANONY_CONTENTS_VIEWS', wp_normalize_path (ANONY_CLASSES . '/views/'));


/**
 * Holds a path to elementor's extensions folder
 * @const
 */
define( 'ANONY_ELEMENTOR_EXTENSION', wp_normalize_path (ANONY_THEME_DIR . '/elementor/'));


/**
 * Holds a path to elementor's documents folder
 * @const
 */
define( 'ANONY_ELEMENTOR_DOCS', wp_normalize_path (ANONY_ELEMENTOR_EXTENSION . 'documents/'));

/**
 * Holds a serialized array of all pathes to classes folders
 * @const
 */
define(
	'ANONY_THEME_AUTOLOADS',
	serialize(
		[
			ANONY_CLASSES,
			ANONY_CONTENTS_VIEWS,
			ANONY_ELEMENTOR_EXTENSION,
			ANONY_ELEMENTOR_DOCS
		]
	)
);

/*
*Classes Auto loader
*/
spl_autoload_register( function ( $class_name ) {
	if (strpos( $class_name, "\\") !== false) {
	    $parts = explode('\\', $class_name);
	    $class_name = end($parts);
	}
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

 );
