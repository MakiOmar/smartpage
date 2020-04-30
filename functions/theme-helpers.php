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
	function anonyOpt($optGroup = 'Anony_options'){
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
	$temp['thumb']     = has_post_thumbnail() ? true : false;
	$temp['thumb_exists']      = ANONY_LINK_HELP::curlUrlExists(get_the_post_thumbnail_url(get_the_ID()));
	$temp['thumb_img'] = get_the_post_thumbnail(get_the_ID(), 'full');
	$temp['date']      = get_the_date();
	$temp['permalink'] = esc_url(get_the_permalink());
	$temp['gravatar']  = get_avatar(get_the_author_meta('ID'),32);
	$temp['author']    = sprintf(esc_html__( 'By %s', ANONY_TEXTDOM ), get_the_author());
	$temp['read_more']         = esc_html__('Read more',ANONY_TEXTDOM);
	$temp['grid']      = $grid;

	if(has_category()){
		$_1st_category = get_the_category()[0];
		$temp['_1st_category_id']   = $_1st_category->cat_ID;
		$temp['_1st_category_name'] = esc_html($_1st_category->name);
		$temp['_1st_category_url']  = esc_url(get_category_link($_1st_category->cat_ID));
	}
	
	return $temp;
}