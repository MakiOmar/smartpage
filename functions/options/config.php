<?php
//Opions constants
$opts_consts = array( 
	'DIRS'                 => DIRECTORY_SEPARATOR ,
	'ANONY_OPTIONS_DIR'     => wp_normalize_path(THEME_DIR . "/functions/options/"),
	'ANONY_OPTIONS_URI'     => THEME_URI . "/functions/options/",
	'ANONY_OPTIONS_FIELDS'  => wp_normalize_path(THEME_DIR . "/functions/options/fields/"),
	'ANONY_OPTIONS_WIDGETS' => wp_normalize_path(THEME_DIR . "/functions/options/widgets/"),
	'ANONY_OPTIONS'         => "Anony_Options",
	
);

foreach($opts_consts as $opts_const => $v){
	if(!defined($opts_const)){
		define($opts_const, $v);
	}
}

define('ANONY_OPTIONS_AUTOLOADS' ,serialize(array(ANONY_OPTIONS_DIR , ANONY_OPTIONS_FIELDS, ANONY_OPTIONS_WIDGETS)));
/*
*Classes Auto loader
*/
spl_autoload_register( 'opts_autoloader' );

/*
*@param  string $class_name 
*/
function opts_autoloader( $class_name ) {
	
	if ( false !== strpos( $class_name, '__' )) {
		
		$class_name = preg_replace('/\w+__/', '', strtolower($class_name));
		
		foreach(unserialize( ANONY_OPTIONS_AUTOLOADS ) as $path){
			$class_file = wp_normalize_path($path) .$class_name . '.php';
			
			if(file_exists($class_file)){
				
				require_once($class_file);
				
			}else{
				
				$class_file = wp_normalize_path($path. $class_name . DIRS) .$class_name . '.php';
				
				if(file_exists($class_file)){
					
					require_once($class_file);
					
				}
			}
		}
		

	}
	
}

require_once('opts.php');