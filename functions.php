<?php

require_once(wp_normalize_path(get_template_directory() . '/config/config.php'));

require_once(wp_normalize_path(ANONY_LIBS_DIR . 'helper/php-helpers.php'));

require_once(wp_normalize_path(ANONY_LIBS_DIR . 'helper/wordpress-helpers.php'));

require_once(wp_normalize_path('options/options.php'));

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
	'posts'     		  =>'',
	'theme'     		  =>'',
	'menus'     		  =>'',
	'admin'     		  =>'',
	'media'     		  =>'',
	'widgets'     		  =>'',
	'db'        		  =>'',
	'mail'        		  =>'',
	'ajax-comments'       =>'ajax' . ANONY_DIRS,
	'tinymce-editor-btns' =>'mce' . ANONY_DIRS,
];

foreach($anonylibs as $anonylib=>$path){
	require_once( ANONY_LIBS_DIR . $path . $anonylib.'.php');
}


//Just for testing purposes
add_action('wp_footer', function(){

});

/*--------------------------------------omdb----------------------------*/

define('OMDB_DIR', ANONY_THEME_DIR. '/custom-sites/omdb');


require_once(OMDB_DIR.'/functions.php');