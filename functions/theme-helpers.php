<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if (!function_exists('anony_restrict_admin_access')) {
	
	/**
	 * Restrict admin access for non admins
	 */
	function anony_restrict_admin_access(){
		//restrict admin access
		if(!is_user_logged_in()) return;
		
		$anonyOptions = ANONY_Options_Model::get_instance();

		if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) && $anonyOptions->not_admin_restricted != '0' ) {
			
			wp_redirect( home_url() );
			
			exit;
			
		}
	}

}

if (!function_exists('anony_add_theme_support')) {
	/**
	 * Add theme support
	 */
	function anony_add_theme_support(){
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background');
		add_theme_support( 'post-thumbnails', array( 'post','anony_download' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'post-formats', array( 'gallery', 'quote', 'video', 'aside', 'image', 'link' ) );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	}
}

if (!function_exists('anony_hide_admin_bar')) {
	/**
	 * Hide admin bar
	 */
	function anony_hide_admin_bar(){

		$anonyOptions = ANONY_Options_Model::get_instance();

		if ($anonyOptions->admin_bar != '0' && !current_user_can('administrator') && !is_admin()) {
			
			show_admin_bar(false);

		}
		
	}
}

if (!function_exists('anony_display_ads')) {
	
	/**
	 * Display theme options' ADs
	 * 
	 * Show ads hooked to custom hook.
	 *
	 * Hook name will be {location}_ad.<br>
	 * do_action('{location}_ad') should be existed in the desired location [header, footer, sidebar, post, page]
	 */
	function anony_display_ads(){
		
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
		
	}

}



/**
 * Desides which sidebar to load according to page direction
 * @return void
 */
function anony_get_correct_sidebar(){
	
	$anonyOptions = ANONY_Options_Model::get_instance();

	if($anonyOptions->sidebar == 'left-sidebar'){
		get_sidebar();
	}elseif($anonyOptions->single_sidebar == '1'){
		get_sidebar('single');
	}
	
}

/**
 * Generates logo markup.
 *
 * **Description: ** If logo is set from customizer it will display it.
 * otherwise it will display a default theme logo.<br/>
 * **Note: ** can be overriden by hookin on anony_get_custom_logo.
 *
 * @param string $color The color of theme's default logo,
 * Will have no effect once a logo is set from customizer.
 * @return string Theme's logo with a link to the homepage
 */
function anony_get_custom_logo($color='main') {	
	if ( has_custom_logo() ) {
		$logo ='<div id="anony-logo" class="anony-grid-col-md-4 anony-grid-col-sm-3">'.get_custom_logo().'</div>';	
	}else{

		$logo= '<div id="anony-logo" class="anony-grid-col-md-4 anony-grid-col-sm-3"><h1>';
		$logo .='<a href="'.ANONY_BLOG_URL.'" title="'.ANONY_BLOG_TITLE.'">';
		$logo .='<img alt="'.ANONY_BLOG_TITLE.'" '; 
		$logo .= 'src="'.ANONY_THEME_URI.'/images/logo-'.$color.'.png"/>';
		$logo .='</a></h1></div>';
	}
	return apply_filters('anony_get_custom_logo', $logo);

}
/**
 * Remove type attribute from styles/scripts.
 *
 * **Description: ** It is recommended to remove type attribute from styles/scripts that has a link|src attribute.
 * @param $tag string style|script tag
 * @param $handle string style|script handle defined with wp_register_style|wp_register_script
 * @return string styles/scripts tags with no type attribute.
 */
function anony_remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

/**
 * Generates comments number markup.
 *
 * @return string HTML of comments number.
 */
function anony_comments_number() {
	$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
	
	if ( comments_open() ) {
		
		$comment_text = esc_html__('comment',ANONY_TEXTDOM);
		
		if ( $num_comments != 1 ) {
			
			$comment_text = esc_html__('comments',ANONY_TEXTDOM);
			
		}
		
		$comments = '<a class="meta-text" href="' . esc_url(get_comments_link()) .'"> '. $num_comments.'</a><span class="meta-text single-meta-text">&nbsp;'.$comment_text.'&nbsp;</span>';
	} else {
		$comments = '<span class="meta-text single-meta-text">'.esc_html__('Comments-off',ANONY_TEXTDOM).'</span>';
	}
	return $comments;
}

/**
 * Collects common post data
 * @return array
 */
function anony_common_post_data(){
	
	$anonyOptions = ANONY_Options_Model::get_instance();
	$grid = $anonyOptions->posts_grid;
	
	$temp['id']        = get_the_ID();
	$temp['title']     = esc_html(get_the_title());
	$temp['title_attr']        = the_title_attribute( ['echo' => false] );
	$temp['content']   = get_the_content();
	$temp['excerpt']   = esc_html(get_the_excerpt());
	$temp['comments_number']   = anony_comments_number();
	$temp['has_category']      = has_category();
	$temp['thumb']     = has_post_thumbnail();
	$temp['thumb_exists']      = ANONY_LINK_HELP::curlUrlExists(get_the_post_thumbnail_url(get_the_ID()));
	$temp['thumb_img']     = get_the_post_thumbnail(get_the_ID(), 'full');
	$temp['thumbnail_img'] = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
	$temp['date']      = get_the_date();
	$temp['permalink'] = esc_url(get_the_permalink());
	$temp['gravatar']  = get_avatar(get_the_author_meta('ID'),32);
	$temp['author']    = sprintf(esc_html__( 'By %s', ANONY_TEXTDOM ), get_the_author());
	$temp['read_more']         = esc_html__('Read more',ANONY_TEXTDOM);
	$temp['grid']      = $grid;
	$temp['views']     = anony_get_post_views(get_the_ID());

	if(has_category()){
		$_1st_category = get_the_category()[0];
		$temp['_1st_category_id']   = $_1st_category->cat_ID;
		$temp['_1st_category_name'] = esc_html($_1st_category->name);
		$temp['_1st_category_url']  = esc_url(get_category_link($_1st_category->cat_ID));
	}
	
	return $temp;
	
}