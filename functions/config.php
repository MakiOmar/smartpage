<?php
/*
*Theme configuration codes
*/




/*
*Define theme constants
*Other constants depends on these ones
*/
$theme_constants = array(
	'THEME_NAME'    => 'Smartpage',
	'THEME_DIR'     => wp_normalize_path( get_template_directory() ),
);
foreach($theme_constants as $theme_constant => $v){
	if(!defined($theme_constant)){
		define($theme_constant, $v);
	}
}

//Define theme constants
$theme_constants = array(
	'THEME_VERSION' => '1.0',
	'THEME_URI'     => get_template_directory_uri(),
	'LIBS_URI'      => get_template_directory_uri(). '/functions',
	'TEXTDOM'       => strtolower(THEME_NAME),
	'LANG_DIR'      => wp_normalize_path(THEME_DIR. '/languages/'),
	'STAR_RATE'     => $GLOBALS['wpdb']->prefix . 'star_rating' ,
	'BLOG_TITLE'    => esc_html(get_bloginfo() ),
	'BLOG_URL'      => esc_url(get_bloginfo('url') ),
	'SuppTypes'     => serialize(array(
									'pdf','doc','docx','7z','arj','deb','zip','iso','pkg','rar','rpm','z','gz','bin','dmg','toast','vcd','csv','dat','log','mdb','sav','tar','ods','xlr','xls','xlsx','odt','txt','rtf','tex','wks','wps','wpd')
								),
);
foreach($theme_constants as $theme_constant => $v){
	if(!defined($theme_constant)){
		define($theme_constant, $v);
	}
}
/*----------------------------------------------------------------------
*Autoloading
*---------------------------------------------------------------------*/

//Main classes folder
define( 'SMPG_CLASSES', wp_normalize_path (LIBS_DIR . '/class/'));

//Custom fileds classes
define( 'SMPG_CF_CLASSES', wp_normalize_path (SMPG_CLASSES . '/cf/'));

//views classes
define( 'SMPG_VIEWS_CLASSES', wp_normalize_path (SMPG_CLASSES . '/views/'));

//Hoolds a serialized array of all classes folders
define('SMPG_THEME_AUTOLOADS' ,serialize(array(SMPG_CLASSES, SMPG_CF_CLASSES, SMPG_VIEWS_CLASSES)));
/*
*Classes Auto loader
*/
spl_autoload_register( 'thm_autoloader' );

/*
*@param  string $class_name 
*/
function thm_autoloader( $class_name ) {
	if ( false !== strpos( $class_name, '__' )) {
		$class_name = preg_replace('/\w+__/', '', strtolower($class_name));

		$class_name  = str_replace('_', '-', $class_name);

		foreach(unserialize( SMPG_THEME_AUTOLOADS ) as $path){
			$class_file = wp_normalize_path($path) .$class_name . '.php';
			if(file_exists($class_file)){
				require_once($class_file);
			}
		}
		

	}
}

/*---------------------End autoloading---------------------------------*/