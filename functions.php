<?php

require_once(wp_normalize_path(get_template_directory() . '/config/config.php'));

require_once(wp_normalize_path(LIBS_DIR . 'helper/php-helpers.php'));

require_once(wp_normalize_path(LIBS_DIR . 'helper/wordpress-helpers.php'));

require_once(wp_normalize_path('options/options.php'));

require_once(wp_normalize_path('metaboxes/metaboxes.php'));

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

/*
*Changes the default role of registered user
*Shloud be checked befor publish
*/
add_filter('pre_option_default_role', function($default_role){
	
    // You can also add conditional tags here and return whatever
    return 'administrator'; // This is changed
	
    return $default_role; // This allows default
	
});


/*
*Controles the registration link on wp-login.php
*Shloud be checked befoor publish
*/
add_filter('option_users_can_register', function($value) {
    
        $value = true;
    
    return $value;
});


/*
*Register categories widget
*/
add_action('widgets_init', function (){
	
	$reg_widgets = array(
		'Class__Cats_Widget',
		'Class__Related_Posts_Widget',
	);
	
	foreach($reg_widgets as $reg_widget){
		register_widget($reg_widget);
	}
	
	
});

