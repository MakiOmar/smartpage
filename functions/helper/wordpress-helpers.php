<?php
//Use instead of get_terms for admin purpuses
function abstracted_load_terms($taxonomy){
  global $wpdb;
  $query = 'SELECT DISTINCT 
                  t.slug 
              FROM
                wp_terms t 
              INNER JOIN 
                wp_term_taxonomy tax 
              ON 
                tax.term_id = t.term_id
              WHERE 
                  ( tax.taxonomy = \'' . $taxonomy . '\')';                     
  $result =  $wpdb->get_results($query , OBJECT);
  return $result;                 
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