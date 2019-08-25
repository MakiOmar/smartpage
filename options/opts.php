<?php
/**
 * Theme options functions
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */


/*----------------------------------------------------------------------------------
*Options functions
*---------------------------------------------------------------------------------*/

require_once('fonts.php');

/**
 * Theme Fonts list - system & Google Fonts.
 * @param mixed $type type of font ['system', 'default', 'popular', 'all']
 * @return array Array of fonts names
 */
function anony_fonts( $type = false ){
	$fonts = unserialize(THEME_FONTS);
	
	if( $type ) {
		return $fonts[$type];
	} else {
		return $fonts;
	}
}


/**
 * Simple function to instantiate the options object
 * @return object options object
 */

function anony_opts_(){
	return ANONY__Options_Model::get_instance();
}

//controls add query strings to scripts/styles
function anony_control_query_strings($src, $handle){
	global $anonyOptions;
	
	//Keep query string for these items
	$neglected = array();
	
	if(!empty($anonyOptions->keep_query_string)){
		$neglected = explode(',',$anonyOptions->keep_query_string);
	}
	
	if($anonyOptions->query_string != '0' && !in_array( $handle, $neglected )){
		$src = remove_query_arg('ver', $src);
	}
	return $src;
	
}


/*----------------------------------------------------------------------------------
*Options hooks
*---------------------------------------------------------------------------------*/
$anonyOptions = anony_opts_();

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
	if ($anonyOptions->admin_bar != '0' && !current_user_can('administrator') && !is_admin()) {
		
		show_admin_bar(false);

	}
});

//restrict admin access
add_action( 'init', function() use($anonyOptions){
	
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) && $anonyOptions->not_admin_restricted != '0' ) {
		
		wp_redirect( home_url() );
		
		exit;
		
	} 
});

// custom login logo tooltip
add_filter('login_headertext', function() use($anonyOptions){
	if($anonyOptions->change_login_title != '0'){
		
		return get_bloginfo();
	}
});

//controls add query strings to scripts
add_filter( 'script_loader_src', 'anony_control_query_strings', 15, 2 );

//controls add query strings to styles
add_filter( 'style_loader_src', 'anony_control_query_strings', 15, 2);


/**
 * Show ads hooked to custom hook.
 *
 * Hook name will be {location}_ad.<br>
 * do_action('{location}_ad') should be existed in the desired location [header, footer, sidebar, post, page]
 */

add_action('init', function() use($anonyOptions){
	
	$anonyADs = array('one', 'two', 'three');

	foreach($anonyADs as $adBlock){
		
		 $block = 'ad_block_'.$adBlock;
		 $blockLoc = $block.'_location';
		
		if(isset($anonyOptions->$blockLoc) && !empty($anonyOptions->$blockLoc)){
			
			foreach($anonyOptions->$blockLoc as $loc){
				
				 add_action($loc.'_ad', function() use($anonyOptions, $block){
					 echo $anonyOptions->$block;
				 });
				
			 }
			
		}
		 
	 }
});
	