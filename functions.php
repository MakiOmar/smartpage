<?php

require_once(wp_normalize_path(get_template_directory() . '/config/config.php'));

require_once(wp_normalize_path(LIBS_DIR . 'helper/php-helpers.php'));

require_once(wp_normalize_path(LIBS_DIR . 'helper/wordpress-helpers.php'));

require_once(wp_normalize_path('options/options.php'));

require_once(wp_normalize_path('metaboxes/custom-fields.php'));

//Functions files
$anonylibs = [
	'posts'     		  =>'',
	'theme'     		  =>'',
	'menus'     		  =>'',
	'admin'     		  =>'',
	'media'     		  =>'',
	'db'        		  =>'',
	'ajax-comments'       =>'ajax' . DIRS,
	'tinymce-editor-btns' =>'mce' . DIRS,
];

foreach($anonylibs as $anonylib=>$path){
	require_once( LIBS_DIR . $path . $anonylib.'.php');
}

add_action('wp_footer', function(){
	//neat_print_r(get_option(ANONY_OPTIONS));
});


