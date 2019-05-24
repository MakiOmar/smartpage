<?php
function smpg_enqueue_media_uploader(){
    wp_enqueue_media();
	$scripts = array('wp-media-uploader.min','wp-media-uploader-custom');
	foreach($scripts as $script){
		wp_register_script( $script ,THEME_URI.'/assets/js/wordpress-media-uploader/dist/jquery.'.$script.'.js' ,array('jquery'),filemtime(THEME_DIR.'/assets/js/wordpress-media-uploader/dist/jquery.'.$script.'.js'),true);
			wp_enqueue_script($script);
		}
}
add_action("admin_enqueue_scripts", "smpg_enqueue_media_uploader");
?>