<?php

require_once(wp_normalize_path(get_template_directory() . '/config/config.php'));


//Core hooks files
$anonylibs = [
	'posts'       =>'',
];

foreach($anonylibs as $anonylib=>$path){
	require_once( ANONY_CORE_HOOKS_DIR . $path . $anonylib.'.php');
}

//Functions files
$anonylibs = [
	'theme-helpers'       =>'',
	'theme-options'       =>'',
	'posts'     		  =>'',
	'theme'     		  =>'',
	'menus'     		  =>'',
	'admin'     		  =>'',
	'media'     		  =>'',
	'widgets'     		  =>'',
	'db'        		  =>'',
	'mail'        		  =>'',
	'ajax-comments'       =>'ajax' . DIRECTORY_SEPARATOR,
	'tinymce-editor-btns' =>'mce' . DIRECTORY_SEPARATOR,
];

foreach($anonylibs as $anonylib=>$path){
	require_once( ANONY_LIBS_DIR . $path . $anonylib.'.php');
}



/*--------------------------------------omdb----------------------------*/

define('OMDB_DIR', ANONY_THEME_DIR. '/custom-sites/omdb');


require_once(OMDB_DIR.'/functions.php');



//Just for testing purposes
add_action('wp_footer', function(){
	
});