<?php

/*
*Simple function to instantiate the options object
*@return object options object
*/

function opt_init_(){
	return Class__Options_Model::get_instance();
}


$anonyOptions = opt_init_();

/*----------------------------------------------------------------------------------
*Apply style options
*---------------------------------------------------------------------------------*/

add_action('wp_head', function() use($anonyOptions){?>
	<style type="text/css">
		<?php
			if(is_rtl()){?>
				h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
					font-family: "<?php echo $anonyOptions->anony_headings_ar_font ?>"
				}

				a{
					font-family: "<?php echo $anonyOptions->anony_paragraph_ar_font ?>"
				}
				p{
					font-family: "<?php echo $anonyOptions->anony_paragraph_ar_font ?>"
				}
			<?php }
	
			if(!is_rtl()){?>
				h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
					font-family: "<?php echo $anonyOptions->anony_headings_en_font ?>"
				}
				a{
					font-family: "<?php echo $anonyOptions->anony_links_en_font ?>"
				}
				p{
					font-family: "<?php echo $anonyOptions->anony_paragraph_en_font ?>"
				}
			<?php }
		?>
	</style>
<?php });

//Show admin bar for only admins
add_action('after_setup_theme', function() use($anonyOptions){
	if (isset($anonyOptions->admin_bar) && $anonyOptions->admin_bar != '0' && !current_user_can('administrator') && !is_admin()) {
		
		show_admin_bar(false);

	}
});


//restrict admin access
add_action( 'init', function() use($anonyOptions){
	
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) && isset($anonyOptions->not_admin_restricted) && $anonyOptions->not_admin_restricted != '0' ) {
		
		wp_redirect( home_url() );
		
		exit;
		
	} 
});


// custom login logo tooltip
add_filter('login_headertext', function() use($anonyOptions){
	if(isset($anonyOptions->change_login_title) && $anonyOptions->change_login_title != '0'){
		
		return get_bloginfo();
	}
});


//controls add query strings to scripts/styles
function _control_q_strings($src, $handle){
	global $anonyOptions;
	
	$neglected = array();
	
	if(isset($anonyOptions->keep_query_string) && !empty($anonyOptions->keep_query_string)){
		$neglected = explode(',',$anonyOptions->keep_query_string);
	}
	
	if(isset($anonyOptions->query_string) && $anonyOptions->query_string != '0' && !in_array( $handle, $neglected )){
		$src = remove_query_arg('ver', $src);
	}
	return $src;
	
}
add_filter( 'script_loader_src', '_control_q_strings', 15, 2 );
add_filter( 'style_loader_src', '_control_q_strings', 15, 2);
	