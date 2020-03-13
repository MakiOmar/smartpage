<?php

/**
 * Holds plugin text domain
 * @const
 */
define('ANONY_HLP_PREFIX', 'ANONY_'); 

/**
 * Holds plugin text domain
 * @const
 */
define('ANONY_HLP_TEXTDOM', 'anony-helpme'); 

/**
 * Holds a URI to Custom fields classes folder
 * @const
 */
define('ANONY_HLP_PATH', wp_normalize_path(get_template_directory().'/helpme')); 

/**
 * Holds a path plugin's folder
 * @const
 */
define('ANONY_HLP_URI', get_template_directory_uri());


/**
 * Holds a URI to main classes folder
 * @const
 */
define('ANONY_HLP_PHP', ANONY_HLP_PATH .'/php/' );

/**
 * Holds a URI to Custom fields classes folder
 * @const
 */
define( 'ANONY_HLP_WP', ANONY_HLP_PATH . '/wp/');

/**
 * Holds a serialized array of all pathes to classes folders
 * @const
 */
define(
	'ANONY_HLP_AUTOLOADS' ,
	serialize(
		[
			ANONY_HLP_PHP, 
			ANONY_HLP_WP
		]
	)
);

/*
*Classes Auto loader
*/
spl_autoload_register( 'anony_helpme_autoloader' );

/**
 * Theme classes autoloading.
 * **Description: ** Any class should be writtn in the structure of CLASS_{class_name} or ANONY_cf__{class_name}<br/>
 * **Note: ** Class or CF is optional prefixes, but any prefix should be followed by double underscore, so can get class file name. For example: a class name of XYZ__Class_name is located in file class_name.php.
 * @param  string $class_name
 * @return void
 */
function anony_helpme_autoloader( $class_name ) {
	if ( false !== strpos( $class_name, ANONY_HLP_PREFIX )) {
		$class_name = strtolower(preg_replace('/'.ANONY_HLP_PREFIX.'/', '', $class_name));


		
		$class_name = str_replace('_', '-', $class_name);

		foreach(unserialize( ANONY_HLP_AUTOLOADS ) as $path){
			
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