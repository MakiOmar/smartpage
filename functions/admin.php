<?php
/**
 *ALL administraion side functions
 */

/*--------------------------------------------------------------------
 *Hook to enqueue admin styles and scripts
 *------------------------------------------------------------------*/
/*
 * Enqueue admin side styles/scripts.
 *
 * Looping through arrays of styles/scripts, with care of using filemtime
 * to override caching.
 */
add_action( 'admin_enqueue_scripts', function() {
	
	$styles = array('smpg-admin');
	
		foreach($styles as $style){
			
			wp_enqueue_style( 
				$style , 
				THEME_URI . '/assets/css/'.$style.'.css' , 
				false, 
				filemtime( wp_normalize_path( THEME_DIR . '/assets/css/'.$style.'.css')  )
			);
			
		}

		$scripts = array('smpg-admin');
	
			foreach($scripts as $script){
				
			wp_register_script( 
				$script , 
				THEME_URI . '/assets/js/'.$script.'.js' ,
				array('jquery'),
				filemtime(wp_normalize_path( THEME_DIR . '/assets/js/'.$script.'.js' ) ),true
			);
			wp_enqueue_script($script);
			}
	}  
);

?>