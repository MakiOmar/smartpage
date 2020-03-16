<?php
/**
 * Theme options functions
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

/*---------------------------------------------------------------
 * Options configurations
 *-------------------------------------------------------------*/

/**
 * Holds directory separator
 * @const
 */
define('ANONY_DIRS', DIRECTORY_SEPARATOR );

/**
 * Holds options group name
 * @const
 */
define('ANONY_OPTIONS', "Anony_Options");

/**
 * Holds options folder URI
 * @const
 */
define('ANONY_OPTIONS_URI', ANONY_THEME_URI . "/options/");

/*----------------------------------------------------------------------
* Options Autoloading
*---------------------------------------------------------------------*/


/**
 * Holds options folder path
 * @const
 */
define('ANONY_OPTIONS_DIR', wp_normalize_path(ANONY_THEME_DIR . "/options/"));

/**
 * Holds options fields folder path
 * @const
 */
define('ANONY_OPTIONS_FIELDS', wp_normalize_path(ANONY_THEME_DIR . "/options/fields/"));

/**
 * Holds options widgets folder path
 * @const
 */
define('ANONY_OPTIONS_WIDGETS', wp_normalize_path(ANONY_THEME_DIR . "/options/widgets/"));

define(
	'ANONY_OPTIONS_AUTOLOADS' ,
	serialize(
		array(
			ANONY_OPTIONS_DIR , 
			ANONY_OPTIONS_FIELDS, 
			ANONY_OPTIONS_WIDGETS,
			ANONY_INPUT_FIELDS
		)
	)
);

/**
 * Classes Auto loader
 */
spl_autoload_register( 'anony_opts_autoloader' );

/**
 * Options classes autoload.
 *
 * @param  string $class_name 
 */
function anony_opts_autoloader( $class_name ) {
	
	if ( false !== strpos( $class_name, ANONY_PREFIX )) {
		
		$class_name = strtolower(preg_replace('/'.ANONY_PREFIX.'/', '', $class_name));
		
		$class_name = str_replace('_', '-', $class_name);
		
		foreach(unserialize( ANONY_OPTIONS_AUTOLOADS ) as $path){
			
			$class_file = wp_normalize_path($path) .$class_name . '.php';
			
			if(file_exists($class_file)){
				//die($class_file.' exists');
				require_once($class_file);
				
			}else{
				//die($class_file.' not exist');
				$class_file = wp_normalize_path($path. $class_name . ANONY_DIRS) .$class_name . '.php';
				
				if(file_exists($class_file)){
					
					require_once($class_file);
					
				}
			}
		}
		

	}
	
}

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


//controls add query strings to scripts/styles
function anony_control_query_strings($src, $handle){
	if(is_admin()) return $src;

	$anonyOptions = ANONY_Options_Model::get_instance();
	
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
add_action('wp_head', function(){

	$anonyOptions = ANONY_Options_Model::get_instance();

?>
	<style type="text/css">
		<?php
			if(is_rtl()){?>
				h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
					font-family: "<?php echo $anonyOptions->anony_headings_ar_font ?>"
				}

				a{
					font-family: "<?php echo $anonyOptions->anony_links_ar_font ?>"
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
add_action('after_setup_theme', function(){
	$anonyOptions = ANONY_Options_Model::get_instance();

	if ($anonyOptions->admin_bar != '0' && !current_user_can('administrator') && !is_admin()) {
		
		show_admin_bar(false);

	}
});

//restrict admin access
/*add_action( 'init', function(){
	$anonyOptions = ANONY_Options_Model::get_instance();

	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) && $anonyOptions->not_admin_restricted != '0' ) {
		
		wp_redirect( home_url() );
		
		exit;
		
	} 
});*/

// custom login logo tooltip
add_filter('login_headertext', function(){
	$anonyOptions = ANONY_Options_Model::get_instance();
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

add_action('init', function(){
	$anonyOptions = ANONY_Options_Model::get_instance();
	
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
	