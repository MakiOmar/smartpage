<?php
// Register Custom Download

function reg_smpg_post_type() {
	$custom_posts = array(
			'Download'=>array(
					__('Download',TEXTDOM)=>__('Downloads',TEXTDOM)),
			'Portfolio'=>array(
					__('Portfolio',TEXTDOM)=>__('Portfolios',TEXTDOM)),
			'Testimonial'=>array(
					__('Testimonial',TEXTDOM)=>__('Testimonials',TEXTDOM)),
			'News'=>array(
					__('New',TEXTDOM)=>__('News',TEXTDOM)),
			);
	foreach($custom_posts as $custom_posts=> $translatable){
		foreach($translatable as $translatable_single => $translatable_plural){
		$labels = array(
			'name'                  => sprintf(_x( '%s', 'General Name', TEXTDOM),$translatable_plural ),
			'singular_name'         => sprintf(_x( '%s', 'Singular Name', TEXTDOM ),$translatable_plural),
			'menu_name'             => sprintf(__( '%s', TEXTDOM ),$translatable_plural),
			'name_admin_bar'        => sprintf(__( '%s', TEXTDOM ),$translatable_plural),
			'archives'              => sprintf(__( '%s Archives', TEXTDOM ),$translatable_plural),
			'attributes'            => sprintf(__( '%s Attributes', TEXTDOM ),$translatable_plural),
			'parent_item_colon'     => sprintf(__( 'Parent %s:', TEXTDOM ),$translatable_single),
			'all_items'             => sprintf(__( 'All %s', TEXTDOM ),$translatable_plural),
			'add_new_item'          => sprintf(__( 'Add New %s', TEXTDOM ),$translatable_single),
			'add_new'               => sprintf(__( 'Add New', TEXTDOM ),$translatable_single),
			'new_item'              => sprintf(__( 'New %s', TEXTDOM ),$translatable_single),
			'edit_item'             => sprintf(__( 'Edit %s', TEXTDOM ),$translatable_single),
			'update_item'           => sprintf(__( 'Update %s', TEXTDOM ),$translatable_single),
			'view_item'             => sprintf(__( 'View %s', TEXTDOM ),$translatable_single),
			'view_items'            => sprintf(__( 'View %s', TEXTDOM ),$translatable_plural),
			'search_items'          => sprintf(__( 'Search %s', TEXTDOM ),$translatable_plural),
			'not_found'             => __( 'Not found', TEXTDOM ),
			'not_found_in_trash'    => __( 'Not found in Trash', TEXTDOM ),
			'featured_image'        => __( 'Featured Image', TEXTDOM ),
			'set_featured_image'    => __( 'Set featured image', TEXTDOM ),
			'remove_featured_image' => __( 'Remove featured image', TEXTDOM ),
			'use_featured_image'    => __( 'Use as featured image', TEXTDOM ),
			'insert_into_item'      => sprintf(__( 'Insert into %s', TEXTDOM ),$translatable_single),
			'uploaded_to_this_item' => sprintf(__( 'Uploaded to this %s', TEXTDOM ),$translatable_single),
			'items_list'            => sprintf(__( '%s list', TEXTDOM ),$translatable_plural),
			'items_list_navigation' => sprintf(__( '%s list navigation', TEXTDOM ),$translatable_plural),
			'filter_items_list'     => sprintf(__( 'Filter %s list', TEXTDOM ),$translatable_plural),
		);
		$args = array(
			'label'                 => sprintf(__( '%s', TEXTDOM ),$translatable_plural),
			'description'           => sprintf(__( 'Here you can add your %s', TEXTDOM ),lcfirst($translatable_plural)),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor','thumbnail', 'comments'),
			'taxonomies'            => array( lcfirst($custom_posts).'_category' ),
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
			'rewrite' => array('slug' => 'smpg_'.lcfirst($custom_posts)),
		);
	}
		register_post_type( 'smpg_'.lcfirst($custom_posts), $args );
	}
}
add_action( 'init', 'reg_smpg_post_type', 0 );

//Register Taxonomies
function reg_smpg_taxonomies(){
	$smpg_custom_taxs = array(
			'Download'=>array(
					__('Download',TEXTDOM)=>__('Downloads',TEXTDOM)),
			'Portfolio'=>array(
					__('Portfolio',TEXTDOM)=>__('Portfolios',TEXTDOM)),
			'Testimonial'=>array(
					__('Testimonial',TEXTDOM)=>__('Testimonials',TEXTDOM)),
			);;
	foreach($smpg_custom_taxs as $smpg_custom_tax => $translatable ){
	foreach($translatable as $translatable_single => $translatable_plural){
		register_taxonomy(
			lcfirst($smpg_custom_tax).'_category',
			array("smpg_".lcfirst($smpg_custom_tax)),
			array(
				 "hierarchical" => true,
				 "label" => sprintf(__('%s categories',TEXTDOM),$translatable_plural),
				 "singular_label" => sprintf(__('%s category',TEXTDOM),$translatable_single),
				  "labels"=>array(
							 "all_items"=>sprintf(__('All %s categories',TEXTDOM),$translatable_single),
							 "edit_item"=>sprintf(__('Edit %s category',TEXTDOM),$translatable_single),
							 "view_item"=>sprintf(__('view %s category',TEXTDOM),$translatable_single),
							 "update_item"=>sprintf(__('update %s category',TEXTDOM),$translatable_single),
							 "add_new_item"=>sprintf(__('Add new %s category',TEXTDOM),$translatable_single),
							 "new_item_name"=>sprintf(__('new %s category',TEXTDOM),$translatable_single),
							 "parent_item"=>sprintf(__('Parent %s category',TEXTDOM),$translatable_single),
							 "parent_item_colon"=>sprintf(__('Parent %s category:',TEXTDOM),$translatable_single),
							 "search_items"=>sprintf(__('search %s categories',TEXTDOM),$translatable_single),
							 "not_found"=>sprintf(__('No %s category found',TEXTDOM),$translatable_single),
							  ),
			"show_admin_column" => true,
			)
		);
	}
}
}

add_action( 'init', 'reg_smpg_taxonomies', 0 );

//Add download's upload meta box
function smpg_upload_meta_boxes() {
    add_meta_box('smpg_download_attachment', __('Add your download',TEXTDOM), 'smpg_upload_with_media_uploader', 'smpg_download', 'normal', 'high');  
}
add_action('add_meta_boxes', 'smpg_upload_meta_boxes');  

function smpg_upload_with_media_uploader() { ?>
	<div class="file-upload-override-button">
		<a href="#" class="insert-media" data-editor="my-editor"><?php _e('Select your file',TEXTDOM) ;?></a>
	</div>
	<?php
		$file_url = get_post_meta( get_the_ID(), 'smpg_download_attachment', true );
		if(is_array($file_url)){
			delete_post_meta( get_the_ID(), 'smpg_download_attachment' );
		}
		if(!empty($file_url)){
			   $html = '<div id="download-file"><p>'.__('Current file:',TEXTDOM).'<span>'.basename($file_url).'</span></p><a href="'.$file_url.'">'.__('Download',TEXTDOM).'</a></div>';
		}else{
			$html = '<div id="download-file"><p>'.'<span>'.__('No selected file ',TEXTDOM).'</span></p></div>';
		}
		echo $html;
	?>
	<!-- Caller -->
	<span id="media-caller">
		<div class="attachment">
			<img width="277" height="300" alt="{{ alt }}">
			<input type="hidden" name ="smpg_download_attachment" value="{{ url }}">
		</div>
	</span>

	<!-- Results placeholder -->
	<div id="upload-result"></div>
<?php }
function save_smpg_upload_meta_data($id) {
    if(isset($_POST['smpg_download_attachment']) && !empty($_POST['smpg_download_attachment'])) {
		$ext = pathinfo($_POST['smpg_download_attachment'], PATHINFO_EXTENSION);
			if(in_array($ext,unserialize(SuppTypes))){
				update_post_meta($id, 'smpg_download_attachment',$_POST['smpg_download_attachment']);
			}else{
				add_filter( 'redirect_post_location', 'smpg_download_redirect_post_location');
			}
        }
}
add_action('save_post_smpg_download', 'save_smpg_upload_meta_data');


function smpg_download_redirect_post_location( $location ) {
	$location = add_query_arg( 'c_error' , '1' , $location );
    return $location;
}
//Show admin notice if no supported file type
add_action( 'admin_notices', 'smpg_upload_admin_notice' );
function smpg_upload_admin_notice() {
	$screen = get_current_screen();
	if( 'smpg_download' == $screen->post_type && 'post' == $screen->base ){
	if ( array_key_exists( 'c_error', $_GET) ) {?>
		<div class="error">
			<p><?php _e( 'Sorry!! Please make sure your file type is one of the following', TEXTDOM );?><br><?php echo implode("-",unserialize(SuppTypes)); ?></p>
		</div>
	<?php }}
}

function implement_download_ajax() {
	//Add and update downloads counter
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
add_action('wp_ajax_download', 'implement_download_ajax');
add_action('wp_ajax_nopriv_download', 'implement_download_ajax');//for users that are not logged in.

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

//filter excerpt length
function custom_excerpt_length( $length ) {
	$length = 15;
	return $length;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
/**
 * Link all post thumbnails to the post permalink.
 *
 * @param string $html          Post thumbnail HTML.
 * @param int    $post_id       Post ID.
 * @param int    $post_image_id Post image ID.
 * @return string Filtered post image HTML.
 */
function wpdocs_post_image_html( $html, $post_id, $post_image_id ) {
    $html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . $html . '</a>';
    return $html;
}
add_filter( 'post_thumbnail_html', 'wpdocs_post_image_html', 10, 3 );

// remove width & height attributes from images
//
function remove_img_attr ($html){
    return preg_replace('/(width|height)="\d+"\s/', "", $html);
}
add_filter( 'post_thumbnail_html', 'remove_img_attr' );

if ( ! function_exists( 'smartpage_comment' ) ) :

function smartpage_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', TEXTDOM ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', TEXTDOM ), '<span class="edit-link">', '</span>' ); ?></p>
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
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', TEXTDOM ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', TEXTDOM ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', TEXTDOM ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', TEXTDOM ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', TEXTDOM ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
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
		return wp_insert_term( __('General Downloads',TEXTDOM), 'download_category', $args  );
	}
	
}
/*
*Set default term for custom post
*/

function smpg_downloads_default_object_terms( $post_id, $post ) {
    if ( 'publish' === $post->post_status && $post->post_type == 'smpg_download' ) {
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
add_action( 'save_post', 'smpg_downloads_default_object_terms', 100, 2 );


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
?>