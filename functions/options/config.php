<?php
$opts_consts = array( 
	'SMPG_OPTIONS_DIR'      => THEME_DIR . "/functions/options/",
	'SMPG_OPTIONS_URI'      => THEME_URI . "/functions/options/",
	'SMPG_OPTIONS_FIELDS'   => THEME_DIR . "/functions/options/fields/",
	'SMPG_OPTIONS_WIDGETS'  => THEME_DIR . "/functions/options/widgets/",
	
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
spl_autoload_register( 'opts_anony_autoloader' );

/*
*@param  string $class_name 
*/
function opts_anony_autoloader( $class_name ) {
	$class_name = strtolower($class_name);
	$subFolder = '';
	
	$classDir = SMPG_OPTIONS_DIR;
	
	$class_file = $classDir . $class_name . '.php';
	
	
	if(strpos( $class_name, 'field__' ) !== false){

		$class_name = str_replace('field__','', $class_name);
		$subFolder = $class_name . DIRECTORY_SEPARATOR;
		$classDir = SMPG_OPTIONS_FIELDS; 
		
	}
	
	$class_file = wp_normalize_path($classDir . $subFolder . $class_name . '.php');

	if(file_exists($class_file)){
		require_once($class_file);
	}else{

		foreach(unserialize( SMPG_OPTIONS_AUTOLOADS ) as $path){
			$class_file = wp_normalize_path($path . DIRECTORY_SEPARATOR . $class_name . '.php');
			if(file_exists($class_file)){
				require_once($class_file);
			}
		}
		
	}
	
}