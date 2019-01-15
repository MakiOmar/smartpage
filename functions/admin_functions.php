<?php
	add_action( 'admin_enqueue_scripts', 'smpg_load_admin_styles' );
	function smpg_load_admin_styles() {
	$styles = array('smpg-admin');
		foreach($styles as $style){
			wp_enqueue_style( $style , get_theme_file_uri('/assets/css/'.$style.'.css') , false, filemtime(get_theme_file_path('/assets/css/'.$style.'.css')) );
		}

		$scripts = array('smpg-admin');
			foreach($scripts as $script){
			wp_register_script( $script , get_theme_file_uri('/assets/js/'.$script.'.js') ,array('jquery'),filemtime(get_theme_file_path('/assets/js/'.$script.'.js')),true);
				wp_enqueue_script($script);
			}
	} 
?>