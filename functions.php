<?php
if(!defined('LIBS_DIR')){
	define('LIBS_DIR', wp_normalize_path ( get_template_directory() . '/functions/'));
}

$smpglibs = [
	'php-helpers'       =>'helper/',
	'wordpress-helpers' =>'helper/',
	'config'            =>'',
	'options'           =>'options/',
	'posts'     		=>'',
	'theme'     		=>'',
	'menus'     		=>'',
	'admin'     		=>'',
	'media'     		=>'',
	'db'        		=>'',
	'opts'      		=>'',
	'ajax-comments'     =>'ajax/',
];

foreach($smpglibs as $smpglib=>$path){
	require_once(LIBS_DIR.$path.$smpglib.'.php');
}

add_action('wp_footer', function(){
	//neat_print_r(get_option(SMPG_OPTIONS));
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
	
	register_widget('Smpg__Cats_Widget');
	
});

