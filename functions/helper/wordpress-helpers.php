<?php
/*
*Gets revolution slider list of silders
*@return array  Associative array of slider id = name
*/

function smpg_get_rev_sliders(){
	$sliders = array();
	
	if ( class_exists( 'RevSlider' ) ) {
		
		$rev_slider = new RevSlider();
		
		foreach($rev_slider->getAllSliderAliases() as $slider){
			
			$sliders[$slider] = ucfirst(str_replace('-', ' ', $slider));
				
		}		
	}
	
	return $sliders;
}
/*
*Check if plugin is active
*@var string $path  Path of plugin file
*/

function smpg_is_active_plugin($path){
	if(!is_admin()){
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}
	
	return is_plugin_active($path);
}
/*
*Query posts IDs by meta key and meta value
*@param string $key    the meta key you want to query with
*@param string $value  the meta value you want to query with
*@return array of posts IDs
*/

function get_posts_ids_by_meta($key, $value){
	global $wpdb;
	
	$postIDs = array();

	$query = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'smpg_set_featured' AND meta_value = 'on'";

	$results = $wpdb->get_results($query);
	
	if(!empty($results) && !is_null($results)){
		foreach($results as $result){
			foreach($result as $id){
				$postIDs[] = $id;
			}
		}
	}
	
	//get_results return null on failure
	if(is_null($results) && WP_DEBUG == true){
		$wpdb->show_errors();
		$wpdb->print_error();
	}
	
	return $postIDs;
	
}
/**
 * Link all post thumbnails to the post permalink and remove width and height atrr from img
 *
 * @param string $html          Post thumbnail HTML.
 * @param int    $post_id       Post ID.
 * @param int    $post_image_id Post image ID.
 * @return string Filtered post image HTML.
 */
function post_image_html( $html, $post_id, $post_image_id ) {

	$html = '<a href="' . esc_url(get_permalink( $post_id )) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . $html . '</a>';
	
	return preg_replace('/(width|height)="\d+"\s/', "", $html);
}

add_filter( 'post_thumbnail_html', 'post_image_html', 10, 3 );

/*
**Use instead of get_terms for admin purpuses
*Get terms using WP_Term_Query class
*@param  string  $taxonomy taxonomy to get terms from
*@return  array of terms (id, name, slug)
*/

function admin_get_terms_query($taxonomy){
	//This for first use when no featured taxonomy been set
	if(empty($taxonomy)){
		$taxonomy = 'category';
	}
	
	$termsObject = new WP_Term_Query(array('taxonomy' => $taxonomy));
	
	$termsArray = array();
	
	if(!empty ($termsObject->terms)){
		
		foreach($termsObject->terms as $term){
			
			$termsArray[$term->term_id] = array('name' => $term->name, 'slug'=>$term->slug);
			
		}
		
	}else{
		$termsArray[0] = array('name' => esc_html__('No terms found'), 'slug'=>'no-terms-found');
	}
	
	
	return $termsArray;
}
/*
*Use instead of get_terms for admin purpuses
*Get terms for slider options
*@param  string  $taxonomy taxonomy to get terms from
*@return  array of terms (id, name)
*/

function admin_get_terms_options($taxonomy){
	
	$termsOptions = array();
	
	foreach(admin_get_terms_query($taxonomy) as $id => $meta){
		$termsOptions[$id] = $meta['name'];
	}
	
	return $termsOptions;
}
/*
*Use instead of get_terms for admin purpuses
*@param  string  $taxonomy taxonomy to get terms from
*@return  array of terms objects
*/
function admin_load_terms_slugs($taxonomy){
	global $wpdb;
	$query = 'SELECT DISTINCT 
				  t.slug 
			  FROM
				' . $wpdb->prefix . 'terms t 
			  INNER JOIN 
				' . $wpdb->prefix . 'term_taxonomy tax 
			  ON 
				tax.term_id = t.term_id
			  WHERE 
				  ( tax.taxonomy = \'' . $taxonomy . '\')';                     
	$result =  $wpdb->get_results($query);
	if(WP_DEBUG == true){
		$wpdb->show_errors();
		$wpdb->print_error();
	}
	return $result;                 
} 

/*
*Use instead of get_terms for admin purpuses
*@param  string  $taxonomy taxonomy to get terms from
*@return  index array of terms
*/

function admin_get_terms($taxonomy){
	
	$terms = array();
	foreach(admin_load_terms_slugs($taxonomy) as $term){
		$terms[] = urldecode($term->slug);
	}
	
	return $terms;
}

/*
*Use instead of get_terms for admin purpuses
*@param  string  $taxonomy taxonomy to get terms from
*@return  associative array of terms
*/

function admin_get_terms_assoc($taxonomy){
	
	$terms = array();
	foreach(admin_load_terms_slugs($taxonomy) as $term){
		$terms[$term->slug] = ucfirst(str_replace ('-',' ',$term->slug));
	}
	
	return $terms;
}


//Get page ID from slug
function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}

//GET USER ROLE
function restrictly_get_current_user_role() {
  if( is_user_logged_in() ) {
    $user = wp_get_current_user();
    $role = ( array ) $user->roles;
    return $role[0];
  } else {
    return false;
  }
 }


/**
 * Get timestamp of remaining time for wordpress transient to be expired
 *
 * @param  string   $transient              the transient name you want to get.
 * @var    object   $wpdb                   the wordpress database object.
 * @var    array    $transient_timeout      array contains the transient time for expiry.
 * @return string                           timestamp of transient expiry;                     
 */
function get_transient_timeout( $transient ) {
    global $wpdb;
    $transient_timeout = $wpdb->get_col( "
      SELECT option_value
      FROM $wpdb->options
      WHERE option_name
      LIKE '%_transient_timeout_$transient%'
    " );
    return $transient_timeout[0];
}