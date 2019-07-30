<?php
foreach(array(
			'THEME_URI' => get_template_directory_uri(),
			'THEME_DIR' => wp_normalize_path( get_template_directory() ),
		) as $const => $value){
			if(!defined($const)){
				define($const, $value);
			}
}

if(!defined('THEME_NAME')) define('THEME_NAME', 'Anonymous');

if(!defined('TEXTDOM'))    define('TEXTDOM', strtolower(THEME_NAME));


//Opions constants
$opts_consts = array( 
	'DIRS'                 => DIRECTORY_SEPARATOR ,
	'ANONY_OPTIONS_DIR'     => wp_normalize_path(THEME_DIR . "/options/"),
	'ANONY_OPTIONS_URI'     => THEME_URI . "/options/",
	'ANONY_OPTIONS_FIELDS'  => wp_normalize_path(THEME_DIR . "/options/fields/"),
	'ANONY_OPTIONS_WIDGETS' => wp_normalize_path(THEME_DIR . "/options/widgets/"),
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
				//die($class_file.' exists');
				require_once($class_file);
				
			}else{
				//die($class_file.' not exist');
				$class_file = wp_normalize_path($path. $class_name . DIRS) .$class_name . '.php';
				
				if(file_exists($class_file)){
					
					require_once($class_file);
					
				}
			}
		}
		

	}
	
}

require_once('opts.php');