<?php
$opts_consts = array( 
	'DIRS'                 => DIRECTORY_SEPARATOR ,
	'SMPG_OPTIONS_DIR'     => wp_normalize_path(THEME_DIR . "/functions/options/"),
	'SMPG_OPTIONS_URI'     => THEME_URI . "/functions/options/",
	'SMPG_OPTIONS_FIELDS'  => wp_normalize_path(THEME_DIR . "/functions/options/fields/"),
	'SMPG_OPTIONS_WIDGETS' => wp_normalize_path(THEME_DIR . "/functions/options/widgets/"),
	'SMPG_OPTIONS'         => "Smpg_Options",
	
);

foreach($opts_consts as $opts_const => $v){
	if(!defined($opts_const)){
		define($opts_const, $v);
	}
}

define('SMPG_OPTIONS_AUTOLOADS' ,serialize(array(SMPG_OPTIONS_DIR , SMPG_OPTIONS_FIELDS, SMPG_OPTIONS_WIDGETS)));
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
		
		foreach(unserialize( SMPG_OPTIONS_AUTOLOADS ) as $path){
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