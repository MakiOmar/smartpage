<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if (!function_exists('anonyOpt')) {
	/**
	 * instantiate options object
	 * @param  string $optName Options name in DB
	 * @return object
	 */
	function anonyOpt($optGroup = 'Anony_Options'){
		if (class_exists('ANONY_Options_Model')) return ANONY_Options_Model::get_instance($optGroup);
		return new stdClass();
	}
}

if (!function_exists('anonyGetOpt')) {
	/**
	 * Get option value from an options group 
	 * @param object $optObject Object of ANONY_Options_Model
	 * @param string $optName   Option name
	 * @param mixed  $notSet    what to return if not set
	 * @return type
	 */
	function anonyGetOpt($optObject, $optName , $notSet = ''){
		if(isset($optObject->$optName)) return $optObject->$optName;
		return $notSet;
	}
}

/**
 * Desides which sidebar to load according to page direction
 * @return void
 */
function anony_get_correct_sidebar(){
	$anonyOptions = anonyOpt();

	if(anonyGetOpt($anonyOptions, 'sidebar') == 'left-sidebar'){
		get_sidebar();
	}elseif(anonyGetOpt($anonyOptions, 'single_sidebar') == '1'){
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
	$anonyOptions = anonyOpt();
	$grid = anonyGetOpt($anonyOptions, 'posts_grid');
	
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