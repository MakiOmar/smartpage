<?php
/**
 * Debug query result.
 * 
 * @param mixed $results Query result
 * @return void
 */
function anony_debug($results){
	//get_results returns null on failure
	if(is_null($results) && WP_DEBUG == true){
		$wpdb->show_errors();
		$wpdb->print_error();
	}
}

/**
 * Gets an array of pages IDs and titles
 * @return array Return an associative array of pages IDs and titles. key (id) equal value (title)
 */
function anony_pages_basic_data(){
	$pages_data = [];

	$pages = get_pages('sort_column=post_title&hierarchical=0');

	foreach ($pages as $page) {
		$pages_data[$page->ID] = $page->post_title;
	}

	return $pages_data;
}

/**
 * Render select option groups.
 * @param  array  $options      Array of all options groups.
 * @param  array  $opts_groups  array of option groups names and there option group lable ['system' => 'option group label']
 * @param  string $selected     Value to check selected option against
 * @return string $html         HTML of options groups
 */
function anony_render_opts_groups( $options, $opts_groups, $selected ){

	$html = '';

	foreach ($opts_groups as $key => $group_name) {

		if(isset($options[$key])){

			$html = '<optgroup label="'. $group_name .'">';

			foreach ( $options[$key] as $option ) {

				$html .= sprintf(
							'<option value="%1$s"%2$s>%1$s</option>', 
							$option, 
							selected($selected, $option, false)
						);

			}

			$html .= '</optgroup>';

		}

	}

	return $html;
}

/**
 * Comments render
 * @param object $comment 
 * @param array  $args 
 * @param integer $depth 
 * @return void
 */
function anony_render_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="anony-comment-<?php comment_ID(); ?>">
		<p><?php esc_html_e( 'Pingback:', TEXTDOM ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', TEXTDOM ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="anony-comment-<?php comment_ID(); ?>" class="anony-comment">
			<header class="anony-comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . esc_html__( 'Post author', TEXTDOM ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( esc_html__( '%1$s at %2$s', TEXTDOM ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .anony-comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="anony-comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', TEXTDOM ); ?></p>
			<?php endif; ?>

			<section class="anony-comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( esc_html__( 'Edit', TEXTDOM ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .anony-comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', TEXTDOM ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #anony-comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}

/**
 * Gets post excerpt.
 *
 * **Dscription: ** Echoes out an excerpt depending on the language
 * @param int $id The post ID to get excerpt for
 * @param int $words_count number of words
 * @return void
 */
function anony_get_excerpt( $id,$words_count= 25 ) {
		$text = get_the_content($id);
		$text = strip_shortcodes( $text );
		$text = str_replace(']]>', ']]&gt;', $text);
		$text = wp_strip_all_tags( $text );
		$text = explode(' ',$text);
		$text = array_slice($text, 0 , $words_count);
		$text = '<p>'.implode(' ',$text).'...</p>';
		if(get_bloginfo('language')=='ar'){
			echo $text;
		}else{
			echo '<p>'.get_the_excerpt($id).'</p>';
		}
	}

/**
 * Gets revolution slider list of silders
 * @return array  Associative array of slider id = name
 */
function anony_get_rev_sliders(){
	$sliders = array();
	
	if ( class_exists( 'RevSlider' ) ) {
		
		$rev_slider = new RevSlider();
		
		foreach($rev_slider->getAllSliderAliases() as $slider){
			
			$sliders[$slider] = ucfirst(str_replace('-', ' ', $slider));
				
		}		
	}
	
	return $sliders;
}

/**
 * Check if plugin is active
 * @var string $path  Path of plugin file
 */
function anony_is_active_plugin($path){
	if(!is_admin()){
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}
	
	return is_plugin_active($path);
}

/**
 * Query posts IDs by meta key and meta value
 * @param  string $key    The meta key you want to query with
 * @param  string $value  The meta value you want to query with
 * @return array          An array of posts IDs
 */
function anony_posts_ids_by_meta($key, $value){
	global $wpdb;
	
	$postIDs = array();

	$query = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'anony__set_as_featured' AND meta_value = 'on'";

	$results = $wpdb->get_results($query);
	
	if(!empty($results) && !is_null($results)){
		foreach($results as $result){
			foreach($result as $id){
				$postIDs[] = $id;
			}
		}
	}

	anony_debug($results);
	
	return $postIDs;
}

/**
 * Query meta values by meta key.
 * 
 * @param string $key    the meta key you want to query with
 * @return array Returns an array of meta values
 */
function anony_meta_values_by_meta_key($key){
	global $wpdb;
	
	$metaValues = array();

	$query = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '$key'";

	$results = $wpdb->get_results($query);
	
	if(!empty($results) && !is_null($results)){
		foreach($results as $result){
			foreach($result as $value){
				$metaValues[] = $value;
			}
		}
	}
	
	anony_debug($results);

	return array_values($metaValues);	
}

/**
 * Link all post thumbnails to the post permalink and remove width and height atrr from img
 *
 * @param  string $html          Post thumbnail HTML.
 * @param  int    $post_id       Post ID.
 * @param  int    $post_image_id Post image ID.
 * @return string                Filtered post image HTML.
 */
function anony_thumb_to_link( $html, $post_id, $post_image_id ) {

	$html = '<a href="' . esc_url(get_permalink( $post_id )) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . $html . '</a>';
	
	return preg_replace('/(width|height)="\d+"\s/', "", $html);
}

add_filter( 'post_thumbnail_html', 'anony_thumb_to_link', 10, 3 );

/**
 * Get terms using WP_Term_Query class.
 * 
 * Use instead of get_terms for admin purpuses.
 * @param  string  $tax    Taxonomy to get terms from
 * @param  string  $fields Fields to fetch.
 * @return array             array of terms (id, name, slug)
 */
function anony_terms_query($tax, $fields){
	/**
	 * 'fields' to return Accepts:
	 * 'all' (returns an array of complete term objects),
	 * 'all_with_object_id' (returns an array of term objects with the 'object_id' param; works only when 
	 * the $object_ids parameter is populated), 
	 * 'ids' (returns an array of ids), 
	 * 'tt_ids' (returns an array of term taxonomy ids), 
	 * 'id=>parent' (returns an associative array with ids as keys, parent term IDs as values), 
	 * 'names' (returns an array of term names), 
	 * 'count' (returns the number of matching terms), 
	 * 'id=>name' (returns an associative array with ids as keys, term names as values), or 
	 * 'id=>slug' (returns an associative array with ids as keys, term slugs as values)
	 */
	$termsObject = new WP_Term_Query(
							array(
								'taxonomy' => $tax,
								'fields'   => $fields
							)
						);
		
	if(!empty ($termsObject->terms)) return $termsObject->terms;

	return '';
}

/**
 * Query terms by taxonomy
 * @param  string  $taxonomy taxonomy to get terms from
 * @return array             An array of terms objects
 */
function anony_terms($taxonomy){
	global $wpdb;
	$query = "SELECT 
					* 
				FROM 
					$wpdb->terms t 
				INNER JOIN 
					$wpdb->term_taxonomy tax 
				ON 
					tax.term_id = t.term_id 
				WHERE 
					tax.taxonomy = '$taxonomy'";

	$result =  $wpdb->get_results($query);

	anony_debug($result);

	return $result;                 
} 

/**
 * Query terms slug names by taxonomy
 * @param  string  $taxonomy taxonomy to get terms from
 * @return array             An array of terms objects contains only slug name
 */
function anony_terms_slugs($taxonomy){
	global $wpdb;
	$query = "SELECT DISTINCT 
				t.slug 
				FROM 
					$wpdb->terms t 
				INNER JOIN 
					$wpdb->term_taxonomy tax 
				ON 
					tax.term_id = t.term_id 
				WHERE 
					tax.taxonomy = '$taxonomy'";

	$result =  $wpdb->get_results($query);

	anony_debug($result);

	return $result;                 
} 

/**
 * Gets an array of human readable terms slug names by taxonomy.
 * 
 * Use instead of get_terms for admin purpuses.
 * @param  string  $taxonomy Taxonomy to get terms from
 * @return arrsy             An indexed array of terms slugs
 */
function anony_terms_slugs_array($taxonomy){
	
	$terms = anony_obj_to_custom_array(
				anony_terms($taxonomy),
				'', 
				'slug'
			);
	return array_map('urldecode', $terms);
}

/**
 * Gets an associative array as key/value pairs from any object properties.
 * 
 * Useful where a select input field has dynamic options.
 * @param object $objects_array The array of objects to loop through
 * @param string $key           The property that should be used as a key
 * @param string $value         The property that should be used as a value
 * @return array                An array of properties as key/value pairs    
 */
function anony_obj_to_custom_array($objects_array, $key, $value, $assoc = true){

	$arr = [];

	foreach ($objects_array as $object) {
		if($assoc && !empty($key)){
			$arr[$object->$key] = $object->$value;
		}else{
			$arr[] = $object->$value;
		}
		
	}

	return $arr;
}

/**
 * Get page id by its slug
 * @param string $page_slug Page's slug
 * @return null|int returns Pages id on success or null on failure
 */
function anony_get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}

/**
 * Get curent user role
 * @return string|bool Returns current user role on success or false on failure
 */
function anony_get_current_user_role() {

	if( is_user_logged_in() ) {

		$user = wp_get_current_user();

		$role = ( array ) $user->roles;

		return $role[0];
	}

	return false;
 }

/**
 * Get timestamp of remaining time for wordpress transient to be expired
 *
 * @param  string   $transient              the transient name you want to get.
 * @var    object   $wpdb                   the wordpress database object.
 * @var    array    $transient_timeout      array contains the transient time for expiry.
 * @return string                           timestamp of transient expiry;                     
 */
function anony_get_transient_timeout( $transient ) {
    global $wpdb;
    $transient_timeout = $wpdb->get_col( "
      SELECT option_value
      FROM $wpdb->options
      WHERE option_name
      LIKE '%_transient_timeout_$transient%'
    " );
    return $transient_timeout[0];
}