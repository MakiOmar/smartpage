<?php

/**
 * Holds class/functions prefix
 * @const
 */
define('ANONY_INF_PREFIX'    , 'ANONY_');


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
 * Holds a serialized array of all pathes to input fields folders
 * @const
 */
define(
	'ANONY_INPUT_FIELDS_AUTOLOADS',
	serialize(
		[
			ANONY_INPUT_FIELDS,
		]
	)
);

/*
*Classes Auto loader
*/
spl_autoload_register( 'anony_input_fields_autoloader' );


/**
 * Theme classes autoloading.
 * **Description: ** Any class should be writtn in the structure of CLASS_{class_name} or ANONY_cf__{class_name}<br/>
 * **Note: ** Class or CF is optional prefixes, but any prefix should be followed by double underscore, so can get class file name. For example: a class name of XYZ__Class_name is located in file class_name.php.
 * @param  string $class_name
 * @return void
 */
function anony_input_fields_autoloader( $class_name ) {
	if ( false !== strpos( $class_name, ANONY_INF_PREFIX )) {
		$class_name = strtolower(preg_replace('/'.ANONY_INF_PREFIX.'/', '', $class_name));
		
		$class_name = str_replace('_', '-', $class_name);

		foreach(unserialize( ANONY_INPUT_FIELDS_AUTOLOADS ) as $path){
			
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

add_action( 'wp_head', function(){?>
		<style type="text/css">
			[id*="fieldset_anony"] {
				display: inline-flex;
				flex-direction: column;
				border: 0;
			}

			.anony-multi-value-flex {
				align-items: flex-start!important;
			}
		</style>
	<?php }
);

