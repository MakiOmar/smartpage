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

//Add tinymce to the comment form
add_filter( 'comment_form_defaults', function( $args ) {
	ob_start();
	
	wp_editor( '', 'comment', array(
		
		//'media_buttons' => true, // show insert/upload button(s) to users with permission
		
		'textarea_rows' => '10', // re-size text area
		
		'dfw' => true, // replace the default full screen with DFW (WordPress 3.4+)
		
		'tinymce' => array(
		
        	'theme_advanced_buttons1' => 'bold,italic,underline,strikethrough,bullist,numlist,code,blockquote,link,unlink,outdent,indent,|,undo,redo,fullscreen',
		
  	  	),
		
		'quicktags' => array(
		
 	       'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close'
		
	    )
		
	) );
	
	$args['comment_field'] = ob_get_clean();
	
	return $args;
	
} );

//Initialize tinymce
add_action('wp_footer', function(){
		if(is_single()){?>
				<script type="text/javascript">
					if(typeof tinymce !== 'undefined'){
						tinymce.init({
							selector: '#anony-comment',
						});
					}

				</script>
		<?php }

 },999);

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

/**
 * Get post type for a taxonomy  
 *
 * @param string $tax The taxonomy to get post types for
 * @return array An array of post types names
 */
function anony_taxonomy_posts($tax){
	$tax_posts = apply_filters( 'anony_taxonomy_posts', [] );

	if(!empty($tax_posts) && array_key_exists($tax, $tax_posts)){
		return $tax_posts[$tax];
	}

	return [];
}

/**
 * Get post type taxonomies
 *
 * @param string $post_type The post type to get taxonomies for
 * @return array An array of taxonomies names
 */
function anony_post_taxonomies($post_type){

	$post_taxonomies = apply_filters( 'anony_post_taxonomies', [] );

	if(!empty($post_taxonomies) && array_key_exists($post_type, $post_taxonomies))
	{
		return $post_taxonomies[$post_type];
	}

	return [];
}

/**
 * Register post types
 */
function anony_reg_post_types(){

	$custom_posts = apply_filters( 'anony_post_types', [] );
	
	if(empty($custom_posts)) return;

	foreach($custom_posts as $custom_post=> $translatable){

		$t_s = $translatable[0];
		$t_p = $translatable[1];
			
		$labels = array(
			'name'                  => sprintf(esc_html_x( '%s', 'General Name'    , ANONY_TEXTDOM ),$t_p ),
			'singular_name'         => sprintf(esc_html_x( '%s', 'Singular Name'   , ANONY_TEXTDOM ),$t_p),
			'menu_name'             => sprintf(esc_html__( '%s'                    , ANONY_TEXTDOM ),$t_p),
			'name_admin_bar'        => sprintf(esc_html__( '%s'                    , ANONY_TEXTDOM ),$t_p),
			'archives'              => sprintf(esc_html__( '%s Archives'           , ANONY_TEXTDOM ),$t_p),
			'attributes'            => sprintf(esc_html__( '%s Attributes'         , ANONY_TEXTDOM ),$t_p),
			'parent_item_colon'     => sprintf(esc_html__( 'Parent %s:'            , ANONY_TEXTDOM ),$t_s),
			'all_items'             => sprintf(esc_html__( 'All %s'                , ANONY_TEXTDOM ),$t_p),
			'add_new_item'          => sprintf(esc_html__( 'Add New %s'            , ANONY_TEXTDOM ),$t_s),
			'add_new'               => sprintf(esc_html__( 'Add New'               , ANONY_TEXTDOM ),$t_s),
			'new_item'              => sprintf(esc_html__( 'New %s'                , ANONY_TEXTDOM ),$t_s),
			'edit_item'             => sprintf(esc_html__( 'Edit %s'               , ANONY_TEXTDOM ),$t_s),
			'update_item'           => sprintf(esc_html__( 'Update %s'             , ANONY_TEXTDOM ),$t_s),
			'view_item'             => sprintf(esc_html__( 'View %s'               , ANONY_TEXTDOM ),$t_s),
			'view_items'            => sprintf(esc_html__( 'View %s'               , ANONY_TEXTDOM ),$t_p),
			'search_items'          => sprintf(esc_html__( 'Search %s'             , ANONY_TEXTDOM ),$t_p),
			'not_found'             => esc_html__( 		   'Not found'             , ANONY_TEXTDOM ),
			'not_found_in_trash'    => esc_html__(         'Not found in Trash'    , ANONY_TEXTDOM ),
			'featured_image'        => esc_html__(         'Featured Image'        , ANONY_TEXTDOM ),
			'set_featured_image'    => esc_html__(         'Set featured image'    , ANONY_TEXTDOM ),
			'remove_featured_image' => esc_html__(         'Remove featured image' , ANONY_TEXTDOM ),
			'use_featured_image'    => esc_html__(          'Use as featured image', ANONY_TEXTDOM ),
			'insert_into_item'      => sprintf(esc_html__( 'Insert into %s'        , ANONY_TEXTDOM ),$t_s),
			'uploaded_to_this_item' => sprintf(esc_html__( 'Uploaded to this %s'   , ANONY_TEXTDOM ),$t_s),
			'items_list'            => sprintf(esc_html__( '%s list'               , ANONY_TEXTDOM ),$t_p),
			'items_list_navigation' => sprintf(esc_html__( '%s list navigation'    , ANONY_TEXTDOM ),$t_p),
			'filter_items_list'     => sprintf(esc_html__( 'Filter %s list'        , ANONY_TEXTDOM ),$t_p),
		);
			
			
		$args = array(
			'label'                 => sprintf(esc_html__( '%s', ANONY_TEXTDOM ),$t_p),
			'description'           => sprintf(esc_html__( 'Here you can add your %s', ANONY_TEXTDOM ),lcfirst($t_p)),
			'labels'                => $labels,
			'supports'              => apply_filters
											( 
													"anony_{$custom_post}_supports",

													['title','editor','excerpt','custom-fields','comments','revisions','thumbnail','author','post-formats'
													] 
											),
			'taxonomies'            => anony_post_taxonomies(lcfirst($custom_post)),
			'public'                => true,
			'hierarchical'          => apply_filters( "anony_{$custom_post}_hierarchical", false),
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'rewrite' => array(
							'slug'         => lcfirst($custom_post),
							'with_front'   => false,
						),
		);
		
		register_post_type( lcfirst($custom_post), $args );
	}
}


/**
 * Register taxonomies
 */
function anony_reg_taxonomies(){
	$anony_custom_taxs = apply_filters( 'anony_taxonomies', [] );

	if(empty($anony_custom_taxs)) return;

	foreach($anony_custom_taxs as $anony_custom_tax => $translatable ){
		$t_s = $translatable[0];
		$t_p = $translatable[1];

		register_taxonomy(
			$anony_custom_tax,
			anony_taxonomy_posts($anony_custom_tax),
			[
				"hierarchical" => true,
				"label" => $t_p,
				"singular_label" => $t_s,
				"labels"=>
						[
							"all_items"=>sprintf(esc_html__('All %s',ANONY_TEXTDOM),$t_p),
							"edit_item"=>sprintf(esc_html__('Edit %s',ANONY_TEXTDOM),$t_s),
							"view_item"=>sprintf(esc_html__('View %s',ANONY_TEXTDOM),$t_s),
							"update_item"=>sprintf(esc_html__('update %s',ANONY_TEXTDOM),$t_s),
							"add_new_item"=>sprintf(esc_html__('Add new %s',ANONY_TEXTDOM),$t_s),
							"new_item_name"=>sprintf(esc_html__('new %s',ANONY_TEXTDOM),$t_s),
							"parent_item"=>sprintf(esc_html__('Parent %s',ANONY_TEXTDOM),$t_s),
							"parent_item_colon"=>sprintf(esc_html__('Parent %s:',ANONY_TEXTDOM),$t_s),
							"search_items"=>sprintf(esc_html__('search %s',ANONY_TEXTDOM),$t_p),
							"not_found"=>sprintf(esc_html__('No %s found',ANONY_TEXTDOM),$t_p),
						],
				"show_admin_column" => true,
			]
		);
	}
}


add_action( 'init', function(){
	//Register Post Types
	anony_reg_post_types();
	
	//Register Taxonomies
	anony_reg_taxonomies();
}, 10 );

// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

//define post types to search for
add_filter('pre_get_posts',function($query) {
 
    if ($query->is_search && !is_admin() ) {
		
        $query->set('post_type',array('post','page'));
		
    }
 
	return $query;
});

//Create term for custom post (anony_download) to be set as default
add_action('init',function( ) {
	if(!term_exists('general_downloads', 'download_category')){
		$args = array('slug' => 'general_downloads');
		return wp_insert_term( esc_html__('General Downloads',ANONY_TEXTDOM), 'download_category', $args  );
	}
	
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