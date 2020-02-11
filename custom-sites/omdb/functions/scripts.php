<?php
//Theme Scripts
add_action('admin_enqueue_scripts',function() {
	$anonyOptions = anony_opts_();
	$scripts = ['x-omdb-admin'];

	foreach ($scripts as $script) {
		wp_register_script( $script , OMDB_URI.'/assets/js/'.$script.'.js' ,array('jquery'),filemtime(wp_normalize_path(OMDB_DIR.'/assets/js/'.$script.'.js')));

		wp_enqueue_script($script);
	}
});