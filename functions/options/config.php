<?php
$consts = array( 
	'SMPG_OPTIONS_DIR'      => THEME_DIR . "/functions/options/",
	'SMPG_OPTIONS_URI'      => THEME_URI . "/functions/options/",
	'SMPG_OPTIONS_FIELDS'   => THEME_DIR . "/functions/options/fields/",
	'SMPG_OPTIONS_WIDGETS'  => THEME_DIR . "/functions/options/widgets/",
	
);

foreach($consts as $const => $v){
	if(!defined($const)){
		define($const, $v);
	}
}

define('SMPG_OPTIONS_AUTOLOADS' ,serialize(array(SMPG_OPTIONS_DIR , SMPG_OPTIONS_FIELDS, SMPG_OPTIONS_WIDGETS)));
/*
*Classes Auto loader
*/
spl_autoload_register( 'opts_anony_autoloader' );

/*
*@param  string $class_name 
*/
function opts_anony_autoloader( $class_name ) {
	$subFolder = '';
	
	$classDir = SMPG_OPTIONS_DIR;
	
	$class_file = $classDir . strtolower($class_name) . '.php';
	
	
	if(strpos( $class_name, 'Field__' ) !== false){

		$class_name = str_replace('Field__','', $class_name);
		$subFolder = strtolower($class_name) . DIRECTORY_SEPARATOR;
		$classDir = SMPG_OPTIONS_FIELDS; 
		
	}
	
	$class_file = wp_normalize_path($classDir . $subFolder . strtolower($class_name) . '.php');

	if(file_exists($class_file)){
		require_once($class_file);
	}else{

		foreach(unserialize( SMPG_OPTIONS_AUTOLOADS ) as $path){
			$class_file = wp_normalize_path($path . DIRECTORY_SEPARATOR . strtolower($class_name) . '.php');
			if(file_exists($class_file)){
				require_once($class_file);
			}
		}
		
	}
	
}