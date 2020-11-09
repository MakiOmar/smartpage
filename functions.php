<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
require_once(wp_normalize_path(get_template_directory() . '/config/config.php'));

if (!defined('ANOENGINE')) return;

//Functions files
$anonylibs = [
	'theme-helpers'       =>'',
	'theme-options'       =>'',
	'data-hooks'       =>'',
	'posts'     		  =>'',
	'scripts'     		  =>'',
	'theme'     		  =>'',
	'woocommerce'     	  =>'',
	'performance'     	  =>'',
	'menus'     		  =>'',
	'admin'     		  =>'',
	'media'     		  =>'',
	'widgets'     		  =>'',
	'db'        		  =>'',
	'custom-fields'       =>'',
	'statistics'          =>'shortcodes/statistics/',
	'ajax-comments'       =>'ajax/',
	'ajax-download'       =>'ajax/',
	'tinymce-editor-btns' =>'mce/' ,
];

foreach($anonylibs as $anonylib=>$path){
	require_once( wp_normalize_path( ANONY_LIBS_DIR . $path . $anonylib.'.php') );
}

//Just for testing purposes
add_action('wp_footer', function(){
	
});


add_action('init', function(){
	
	ANONY_WOO_HELP::createProductAttribute('Brand');

	$termMetaBox = new ANONY_Term_Metabox(
		[ 
			'id'       => 'anony_brand',
			'taxonomy' => 'pa_brand',
			'context'  => 'term',
			'fields'   => 
				[
					[
						'id' => 'anony_brand_logo',
						'title'    => esc_html__( 'Brand logo', ANOE_TEXTDOM ),
						'type'     => 'gallery',
					]
				],
		]
	);
	
} );