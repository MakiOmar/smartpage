<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Posts Functions
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

/*-------------------------------------------------------------
 * Posts hooks
 *-----------------------------------------------------------*/

/**
 * We should flush rewrite rules, so as not to get 404 for custom post types
 */
add_action( 'after_switch_theme', 'flush_rewrite_rules' );

//Filter reply link
add_filter('comment_reply_link', function($link, $args, $comment, $post){
	if(wp_doing_ajax()){
		if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
				$link = sprintf(
					'<a rel="nofollow" class="anony-comment-reply-login" href="%s">%s</a>',
					esc_url( wp_login_url( get_permalink($post) ) ),
					$args['login_text']
				);
			} else {
				$data_attributes = array(
					'commentid'      => $comment->comment_ID,
					'postid'         => $post->ID,
					'belowelement'   => $args['add_below'] . '-' . $comment->comment_ID,
					'respondelement' => $args['respond_id'],
				);

				$data_attribute_string = '';

				foreach ( $data_attributes as $name => $value ) {
					$data_attribute_string .= " data-${name}=\"" . esc_attr( $value ) . '"';
				}

				$data_attribute_string = trim( $data_attribute_string );
				
			
				$current_url = str_replace(get_bloginfo('url'),'',get_permalink($post));
			
				$link = sprintf(
					"<a rel='nofollow' class='comment-reply-link' href='%s' %s aria-label='%s'>%s</a>",
					esc_url(
						add_query_arg(
							array(
								'replytocom'      => $comment->comment_ID,
								'unapproved'      => false,
								'moderation-hash' => false,
							),$current_url
						)
					) .'#'. $args['respond_id'],
					$data_attribute_string,
					esc_attr( sprintf( $args['reply_to_text'], $comment->comment_author ) ),
					$args['reply_text']
				);
			}
		return $link;
	}
			
	return $link;
		
},'',4);

//Filter commet classes
add_filter('comment_class', function($classes, $class, $comment_id, $comment, $post_id){
	if(intval($comment->comment_parent) != 0){

		$classes[] = 'child';
		
		return $classes;
	}
	
	return $classes;
},'',5);

// remove width and height atrr from img
add_filter( 'post_thumbnail_html', function( $html) {
	
	return preg_replace('/(width|height)="\d+"\s/', "", $html);
} );

//Chenge excerpt length
add_filter( 'excerpt_length', function() { return 15; }, 999 );

// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

//define post types to search for
add_filter('pre_get_posts',function($query) {
 
    if ($query->is_search && !is_admin() ) {
		
        $query->set('post_type',array('post','page'));
		
    }
 
	return $query;
});

//Set default term for custom post anony_download
add_action( 'save_post_anony_download', function( $post_id, $post ) {
    if ( 'publish' === $post->post_status) {
		
        $defaults = array('download_category' => array( 'general_downloads'));
		
        $taxonomies = get_object_taxonomies( $post->post_type );

        foreach ( (array) $taxonomies as $taxonomy ) {
			
            $terms = wp_get_post_terms( $post_id, $taxonomy );
			
            if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
				
                wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
				
            }
        }
    }
}, 100, 2 );

//Ajax download for logged in users
add_action('wp_ajax_download','anony_download_ajax');

//Ajax download for users that are not logged in.
add_action('wp_ajax_nopriv_download', 'anony_download_ajax');

//Set post views count
add_action('template_redirect', function(){
	
	global $post;
	
    if (is_single()) anony_set_post_views($post->ID);
});

/*-------------------------------------------------------------
 * Posts functions
 *-----------------------------------------------------------*/

/**
 * Gets post views count.
 *
 * @param string $postID The post ID to get views count for
 * @return string post views count
 */
function anony_get_post_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return '0';
    }
    return $count;
}

/**
 * Sets post views count.
 *
 * @param string $postID The post ID to set views count for
 * @return void
 */
function anony_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

/**
 * Gets number of posts per category.
 *
 * @param int $idcat The category ID to get posts count for
 * @return int posts count
 */
function anony_cat_posts_count($idcat) {
	global $wpdb;
	$query = "SELECT count FROM $wpdb->term_taxonomy WHERE term_id = $idcat";
	$num = $wpdb->get_col($query);
	if(is_array($num) && !empty($num)){
		return $num[0];
	}

}

/**
 * Gets latest comments.
 *
 * **Description: ** Outputs HTML for latest comments.
 *
 * @return void
 */
function anony_latest_comments(){
	
	$args = array('number'=>4,'author__not_in' => array(get_current_user_id()));
	
		$comments = get_comments($args);
	
		if(count($comments) > 0){
			
			foreach($comments as $comment) {?>	
			
				<div  class="anony-recent-comment-wrapper">
				
					<h3><?php echo '<i class="fa fa-user"></i> '.$comment->comment_author.' '.__('Commented',ANONY_TEXTDOM) ?></h3>
					
					<p class='recent-comment'>
					<?php echo substr($comment->comment_content,0 , 150).'... ' ?>
					
					<a href="<?php echo get_the_permalink($comment->comment_post_ID)?>"><?php esc_html_e('View Post',ANONY_TEXTDOM) ?></a>
					
					</p>
					
				</div>
				
		<?php }}else{?>
				
					<p><?php esc_html_e('No comments yet',ANONY_TEXTDOM);?></p>
					
				<?php };
}


/**
 * //Add or update downloads counter.
 *
 * @return void
 */
function anony_download_ajax() {
			
	if(isset($_POST['download_id']) && !empty($_POST['download_id'])){
			$download_counter = get_post_meta($_POST['download_id'], 'download_times',true);
			if(empty($download_counter)){
				add_post_meta($_POST['download_id'], 'download_times',1);
			}else{
				$download_counter +=  1;
				update_post_meta($_POST['download_id'], 'download_times',$download_counter);
			}
		wp_die();
		}
}
?>