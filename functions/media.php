<?php
/**
 * Media functions
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

/*-------------------------------------------------------------
 * Media hooks
 *-----------------------------------------------------------*/

//Enqueue media scripts for uploader in anony_download post type
add_action("admin_enqueue_scripts", function(){
    wp_enqueue_media();
	
	$scripts = array('wp-media-uploader.min','wp-media-uploader-custom');
	
	foreach($scripts as $script){
		
		wp_register_script( 
			$script ,
			THEME_URI.'/assets/js/wordpress-media-uploader/dist/jquery.'.$script.'.js'
			,array('jquery', 'jquery-ui-core'),
			filemtime(wp_normalize_path(THEME_DIR.'/assets/js/wordpress-media-uploader/dist/jquery.'.$script.'.js')),
			true
		);
		
		wp_enqueue_script($script);
	}
});
?>