<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action('wp_ajax_anoe_dynamic_css', 'anoe_dynamic_css');
add_action('wp_ajax_nopriv_anoe_dynamic_css', 'anoe_dynamic_css');

function anoe_dynamic_css() {
	require( ANONY_THEME_DIR . '/assets/css/dynamic.php' );
	exit;
}

function anony_styles(){
	
	$anonyOptions = ANONY_Options_Model::get_instance();
	
	$styles = array('main','responsive');
		
	$styles_libs = ['font-awesome', 'prettyPhoto'];
	
	$styles = array_merge($styles, $styles_libs);
	
	foreach($styles as $style){
		
		$handle = in_array($style, $styles_libs) ? $style : 'anony-' . $style;
		
		wp_enqueue_style( 
			$handle, 
			ANONY_THEME_URI . '/assets/css/'.$style.'.css', 
			false,
			filemtime(
				wp_normalize_path(ANONY_THEME_DIR . '/assets/css/'.$style.'.css' )
			) 
		);
	}
	
	if(is_rtl()){
		wp_enqueue_style( 
			'anony-rtl', 
			ANONY_THEME_URI . '/assets/css/rtl.css',
			array('anony-main'), 
			filemtime(
				wp_normalize_path(ANONY_THEME_DIR . '/assets/css/rtl.css')
			)
		);
	}

	$dynamic_deps = ['anony-main'];
	
	if($anonyOptions->color_skin !== 'custom' && !empty($anonyOptions->color_skin)){

		$skin = $anonyOptions->color_skin;

		$dynamic_deps = [$skin.'-skin'];

		wp_enqueue_style( 
			$skin.'-skin',
			ANONY_THEME_URI .'/assets/css/skins/'.$skin.'.css',
			array('anony-main'), 
			filemtime(
				wp_normalize_path(ANONY_THEME_DIR . '/assets/css/skins/'.$skin.'.css')
			)
		);
	}

	wp_enqueue_style( 'anonyengine-dynamics', admin_url('admin-ajax.php').'?action=anoe_dynamic_css', $dynamic_deps);
}

function anony_scripts(){
	/**---------------------------------------------------------------------
	 *                   Register scripts
	 *---------------------------------------------------------------------*/
	
	$scripts = array('tabs','download', 'ajax_comment', 'custom');
	
	$libs_scripts = ['jquery.validate.min', 'jquery.prettyPhoto'];
	
	$scripts = array_merge($scripts, $libs_scripts);
	
	foreach($scripts as $script){
		
		$handle = in_array($script, $libs_scripts) ? $script : 'anony-' . $script;
		
		wp_register_script( 
			$handle , 
			ANONY_THEME_URI . '/assets/js/'.$script.'.js' ,
			['jquery', 'jquery.helpme'],
			filemtime(
				wp_normalize_path(ANONY_THEME_DIR . '/assets/js/'.$script.'.js' )
			), 
			true 
		);
	}
	
	wp_enqueue_script( 'anony-custom' );
	wp_enqueue_script( 'jquery.prettyPhoto' );
	
	/*----------------------------------------------------------------------*/

	$scripts = array();

	if(is_archive()){
		$scripts = array_merge($scripts, array('jquery.mousewheel', 'jquery.contentcarousel', 'jquery.easing.1.3'));
	}

	
	foreach($scripts as $script){
		wp_register_script(
			$script,
			ANONY_THEME_URI . '/assets/js/'.$script.'.js',
			['jquery'],
			filemtime(
				wp_normalize_path(ANONY_THEME_DIR . '/assets/js/'.$script.'.js' )
			),
			true
		);
		wp_enqueue_script($script);
	}

	// Localize the script with new data
	$anony_loca = array(
		'ajaxURL'          => ANONY_WPML_HELP::getAjaxUrl(),
		'textDir'          => (is_rtl() ? 'rtl' : 'ltr'),
		'themeLang'        => get_bloginfo('language'),
		'anonyFormAuthor'  => esc_html__("Please enter a valid name", ANONY_TEXTDOM),
		'anonyFormEmail'   => esc_html__("Please enter a valid email", ANONY_TEXTDOM),
		'anonyFormUrl'     => esc_html__("Please use a valid website address", ANONY_TEXTDOM),
		'anonyFormComment' => esc_html__("Comment must be at least 20 characters", ANONY_TEXTDOM),
	);
	wp_localize_script( 'anony-custom', 'anonyLoca', $anony_loca );
}

//Theme Scripts
add_action('wp_enqueue_scripts',function() {
		
	anony_styles();
	anony_scripts();

});