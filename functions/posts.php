<?php
// Register Custom Download

function reg_smpg_post_type() {
	$custom_posts = array(
			'Download'=>array(
					esc_html__('Download',TEXTDOM)   => esc_html__('Downloads',TEXTDOM)),
			'Portfolio'=>array(
					esc_html__('Portfolio',TEXTDOM)  => esc_html__('Portfolios',TEXTDOM)),
			'Testimonial'=>array(
					esc_html__('Testimonial',TEXTDOM)=> esc_html__('Testimonials',TEXTDOM)),
			'News'=>array(
					esc_html__('New',TEXTDOM)        => esc_html__('News',TEXTDOM)),
			);
	foreach($custom_posts as $custom_post=> $translatable){
		
		foreach($translatable as $t_s => $t_p){
			
		$labels = array(
			'name'                  => sprintf(esc_html_x( '%s', 'General Name'    , TEXTDOM),$t_p ),
			'singular_name'         => sprintf(esc_html_x( '%s', 'Singular Name'   , TEXTDOM ),$t_p),
			'menu_name'             => sprintf(esc_html__( '%s'                    , TEXTDOM ),$t_p),
			'name_admin_bar'        => sprintf(esc_html__( '%s'                    , TEXTDOM ),$t_p),
			'archives'              => sprintf(esc_html__( '%s Archives'           , TEXTDOM ),$t_p),
			'attributes'            => sprintf(esc_html__( '%s Attributes'         , TEXTDOM ),$t_p),
			'parent_item_colon'     => sprintf(esc_html__( 'Parent %s:'            , TEXTDOM ),$t_s),
			'all_items'             => sprintf(esc_html__( 'All %s'                , TEXTDOM ),$t_p),
			'add_new_item'          => sprintf(esc_html__( 'Add New %s'            , TEXTDOM ),$t_s),
			'add_new'               => sprintf(esc_html__( 'Add New'               , TEXTDOM ),$t_s),
			'new_item'              => sprintf(esc_html__( 'New %s'                , TEXTDOM ),$t_s),
			'edit_item'             => sprintf(esc_html__( 'Edit %s'               , TEXTDOM ),$t_s),
			'update_item'           => sprintf(esc_html__( 'Update %s'             , TEXTDOM ),$t_s),
			'view_item'             => sprintf(esc_html__( 'View %s'               , TEXTDOM ),$t_s),
			'view_items'            => sprintf(esc_html__( 'View %s'               , TEXTDOM ),$t_p),
			'search_items'          => sprintf(esc_html__( 'Search %s'             , TEXTDOM ),$t_p),
			'not_found'             => esc_html__( 		   'Not found'             , TEXTDOM ),
			'not_found_in_trash'    => esc_html__(         'Not found in Trash'    , TEXTDOM ),
			'featured_image'        => esc_html__(         'Featured Image'        , TEXTDOM ),
			'set_featured_image'    => esc_html__(         'Set featured image'    , TEXTDOM ),
			'remove_featured_image' => esc_html__(         'Remove featured image' , TEXTDOM ),
			'use_featured_image'    => esc_html__(          'Use as featured image', TEXTDOM ),
			'insert_into_item'      => sprintf(esc_html__( 'Insert into %s'        , TEXTDOM ),$t_s),
			'uploaded_to_this_item' => sprintf(esc_html__( 'Uploaded to this %s'   , TEXTDOM ),$t_s),
			'items_list'            => sprintf(esc_html__( '%s list'               , TEXTDOM ),$t_p),
			'items_list_navigation' => sprintf(esc_html__( '%s list navigation'    , TEXTDOM ),$t_p),
			'filter_items_list'     => sprintf(esc_html__( 'Filter %s list'        , TEXTDOM ),$t_p),
		);
			
			
		$args = array(
			'label'                 => sprintf(esc_html__( '%s', TEXTDOM ),$t_p),
			'description'           => sprintf(esc_html__( 'Here you can add your %s', TEXTDOM ),lcfirst($t_p)),
			'labels'                => $labels,
			'supports'              => ($custom_post == 'News') ? array( 'editor') : array( 'title', 'editor','thumbnail', 'comments'),
			'taxonomies'            => array( lcfirst($custom_post).'_category' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'rewrite' => array('slug' => 'smpg_'.lcfirst($custom_post)),
		);
	}
		register_post_type( 'smpg_'.lcfirst($custom_post), $args );
	}
}
add_action( 'init', 'reg_smpg_post_type', 0 );

//Register Taxonomies
function reg_smpg_taxonomies(){
	$smpg_custom_taxs = array(
			'Download'=>array(
					esc_html__('Download',TEXTDOM)=> esc_html__('Downloads',TEXTDOM)),
			'Portfolio'=>array(
					esc_html__('Portfolio',TEXTDOM)=> esc_html__('Portfolios',TEXTDOM)),
			'Testimonial'=>array(
					esc_html__('Testimonial',TEXTDOM)=> esc_html__('Testimonials',TEXTDOM)),
			);;
	foreach($smpg_custom_taxs as $smpg_custom_tax => $translatable ){
	foreach($translatable as $t_s => $t_p){
		register_taxonomy(
			lcfirst($smpg_custom_tax).'_category',
			array("smpg_".lcfirst($smpg_custom_tax)),
			array(
				 "hierarchical" => true,
				 "label" => sprintf(esc_html__('%s categories',TEXTDOM),$t_p),
				 "singular_label" => sprintf(esc_html__('%s category',TEXTDOM),$t_s),
				  "labels"=>array(
							 "all_items"=>sprintf(esc_html__('All %s categories',TEXTDOM),$t_s),
							 "edit_item"=>sprintf(esc_html__('Edit %s category',TEXTDOM),$t_s),
							 "view_item"=>sprintf(esc_html__('view %s category',TEXTDOM),$t_s),
							 "update_item"=>sprintf(esc_html__('update %s category',TEXTDOM),$t_s),
							 "add_new_item"=>sprintf(esc_html__('Add new %s category',TEXTDOM),$t_s),
							 "new_item_name"=>sprintf(esc_html__('new %s category',TEXTDOM),$t_s),
							 "parent_item"=>sprintf(esc_html__('Parent %s category',TEXTDOM),$t_s),
							 "parent_item_colon"=>sprintf(esc_html__('Parent %s category:',TEXTDOM),$t_s),
							 "search_items"=>sprintf(esc_html__('search %s categories',TEXTDOM),$t_s),
							 "not_found"=>sprintf(esc_html__('No %s category found',TEXTDOM),$t_s),
							  ),
			"show_admin_column" => true,
			)
		);
	}
}
}

add_action( 'init', 'reg_smpg_taxonomies', 0 );

//Post views Count
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return '0';
    }
    return $count;
}

//Set post views
function setPostViews($postID) {
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

// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/*
*Numbe Of Post Per Category
*/
function number_postpercat($idcat) {
	global $wpdb;
	$query = "SELECT count FROM $wpdb->term_taxonomy WHERE term_id = $idcat";
	$num = $wpdb->get_col($query);
	if(is_array($num) && !empty($num)){
		return $num[0];
	}

}

if ( ! function_exists( 'smartpage_comment' ) ) :

function smartpage_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php esc_html_e( 'Pingback:', TEXTDOM ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', TEXTDOM ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
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
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', TEXTDOM ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( esc_html__( 'Edit', TEXTDOM ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', TEXTDOM ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;
/*
*Create term for custom post to be set as default
*/
add_action('init','create_smpg_downloads_object_terms');

function create_smpg_downloads_object_terms( ) {
	if(!term_exists('general_downloads', 'download_category')){
		$args = array('slug' => 'general_downloads');
		return wp_insert_term( esc_html__('General Downloads',TEXTDOM), 'download_category', $args  );
	}
	
}
/*
*Set default term for custom post smpg_download
*/

function smpg_downloads_default_object_terms( $post_id, $post ) {
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
}

add_action( 'save_post_smpg_download', 'smpg_downloads_default_object_terms', 100, 2 );


function smpg_get_excerpt( $id,$words_count= 25 ) {
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

/*
*Chenge excerpt length
*/
function custom_excerpt_length(  ) {
		return 15;
	}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * remove width and height atrr from img
 *
 * @param string $html          Post thumbnail HTML.
 * @return string Filtered post image HTML.
 */
function smpg_post_image_html( $html) {
	
	return preg_replace('/(width|height)="\d+"\s/', "", $html);
}

add_filter( 'post_thumbnail_html', 'smpg_post_image_html' );


/*
*Add tinymce to the comment form
*/
add_filter( 'comment_form_defaults', 'smpg_rich_text_comment_form' );

function smpg_rich_text_comment_form( $args ) {
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
	
}

function smpg_init_tinymce(){
		if(is_single()){?>
				<script type="text/javascript">
					if(tinymce !== 'undefined'){
						tinymce.init({
							selector: '#comment',
						});
					}

				</script>
		<?php }

 }

add_action('wp_footer', 'smpg_init_tinymce',999);

/*
*Filter reply link
*/
add_filter('comment_reply_link', 'smpg_ajax_comment_reply_link','',4);
function smpg_ajax_comment_reply_link($link, $args, $comment, $post){
	if(wp_doing_ajax()){
		if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
				$link = sprintf(
					'<a rel="nofollow" class="comment-reply-login" href="%s">%s</a>',
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
		
}

/*
*Filter commet classes
*/
add_filter('comment_class', 'smpg_filter_comment_class','',5);

function smpg_filter_comment_class($classes, $class, $comment_id, $comment, $post_id){
	if(intval($comment->comment_parent) != 0){

		$classes[] = 'child';
		
		return $classes;
	}
	
	return $classes;
}


$metaBoxes = array(
	'post' => array(
				array(
					'id' => 'smpg_set_featured',
					'title' => esc_html__( 'Set as featured post', TEXTDOM ),
					'context' => 'side',
					'type' => 'checkbox',
					'validate' => 'no_html',
				),
				
			),
	'smpg_download' => array(
							array(
								'id' => 'smpg_download_attachment',
								'title' => esc_html__( 'Upload your attachment', TEXTDOM ),
								'context' => 'normal',
								'type' => 'upload',
								//'validate' => 'no_html',
							),
			),

);

$metaboxes = new Smpg__Custom_Field($metaBoxes);
?>