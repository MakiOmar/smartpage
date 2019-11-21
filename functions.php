<?php

require_once(wp_normalize_path(get_template_directory() . '/config/config.php'));

require_once(wp_normalize_path(ANONY_LIBS_DIR . 'helper/php-helpers.php'));

require_once(wp_normalize_path(ANONY_LIBS_DIR . 'helper/wordpress-helpers.php'));

require_once(wp_normalize_path('options/options.php'));

//Functions files
$anonylibs = [
	'posts'     		  =>'',
	'theme'     		  =>'',
	'menus'     		  =>'',
	'admin'     		  =>'',
	'media'     		  =>'',
	'widgets'     		  =>'',
	'db'        		  =>'',
	'ajax-comments'       =>'ajax' . ANONY_DIRS,
	'tinymce-editor-btns' =>'mce' . ANONY_DIRS,
];

foreach($anonylibs as $anonylib=>$path){
	require_once( ANONY_LIBS_DIR . $path . $anonylib.'.php');
}


//Just for testing purposes
add_action('wp_footer', function(){
	//neat_print_r(get_option(ANONY_OPTIONS));
});


