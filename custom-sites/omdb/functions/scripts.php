<?php
//custom site scripts: omdb
$scripts_hook = is_admin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';
add_action($scripts_hook,function() {
	
	$scripts = ['x-omdb-admin'];

	foreach ($scripts as $script) {
		wp_register_script( $script , OMDB_URI.'/assets/js/'.$script.'.js' ,array('jquery'),filemtime(wp_normalize_path(OMDB_DIR.'/assets/js/'.$script.'.js')));

		wp_enqueue_script($script);
	}
});

add_action( 'admin_head', function(){
	$screen = get_current_screen();
	if($screen->base == 'post' && $screen->post_type == 'contract'){?>
		<style type="text/css">
			#poststuff #post-body.columns-2{
				/*margin-left: 0;*/
			}
		</style>
	<?php }
} );