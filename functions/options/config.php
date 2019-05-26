<?php
$consts = array( 
	'SMPG_OPTIONS_DIR'    => THEME_DIR . wp_normalize_path("/functions/options/"),
	'SMPG_OPTIONS_URI'    => THEME_URI . "/functions/options/",
	'SMPG_OPTIONS_FIELDS' => THEME_DIR . wp_normalize_path("fields/"),
	'SMPG_OPTIONS_AUTOLOADS' => serialize(array('SMPG_OPTIONS_DIR' , 'SMPG_OPTIONS_FIELDS')),
);

foreach($consts as $const => $v){
	if(!defined($const)){
		define($const, $v);
	}
}

/*
*Classes Auto loader
*/
spl_autoload_register( 'opts_anony_autoloader' );

/*
*@param  string $class_name 
*/
function opts_anony_autoloader( $class_name ) {
	
	$class_file = SMPG_OPTIONS_DIR . strtolower($class_name) . '.php';
	
	if(file_exists($class_file)){
		require_once($class_file);
	}else{
		
		foreach(unserialize( SMPG_OPTIONS_AUTOLOADS ) as $path){
			$class_file = $path . strtolower($class_name) . '.php';
			
			if(file_exists($class_file)){
				require_once($class_file);
			}
		}
		
	}
	
}