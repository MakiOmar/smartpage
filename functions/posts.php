<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
/**
 * Posts Functions
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

/*
-------------------------------------------------------------
 * Posts hooks
 *-----------------------------------------------------------*/

/**
 * Extend custom post types
 *
 * @return array of post types
 */
add_filter(
	'anony_post_types',
	function ( $custom_post_types ) {
		$custom_posts = array(
			'anony_download' =>
				array(
					esc_html__( 'Download', 'smartpage' ),
					esc_html__( 'Downloads', 'smartpage' ),
				),

			'portfolio'      =>
				array(
					esc_html__( 'portfolio', 'smartpage' ),
					esc_html__( 'Portfolios', 'smartpage' ),
				),

			'testimonial'    =>
				array(
					esc_html__( 'Testimonial', 'smartpage' ),
					esc_html__( 'Testimonials', 'smartpage' ),
				),
			'anony_news'     =>
				array(
					esc_html__( 'New', 'smartpage' ),
					esc_html__( 'News', 'smartpage' ),
				),
		);

		return array_merge( $custom_post_types, $custom_posts );
	}
);


/**
 * Extend custom taxonomies
 *
 * @return array of taxonomies
 */
add_filter(
	'anony_taxonomies',
	function ( $anony_custom_taxs ) {

		$custom_taxs =
		array(
			'anony_download_type' =>
				array(
					esc_html__( 'Download type', 'smartpage' ),
					esc_html__( 'Download type', 'smartpage' ),
				),

		);

		return array_merge( $anony_custom_taxs, $custom_taxs );
	}
);


/**
 * Extend posts' taxonomies
 *
 * @return array of post's taxonomies
 */
add_filter(
	'anony_post_taxonomies',
	function ( $anony_post_taxonomies ) {

		$post_taxs = array( 'anony_download' => array( 'anony_download_type' ) );

		return array_merge( $anony_post_taxonomies, $post_taxs );
	}
);

/**
 * Extend taxonomies' posts
 *
 * @return array of taxonomies' posts
 */
add_filter(
	'anony_taxonomy_posts',
	function ( $anony_tax_posts ) {

		$tax_posts = array( 'anony_download_type' => array( 'anony_download' ) );

		return array_merge( $anony_tax_posts, $tax_posts );
	}
);


/**
 * change project post type support
 *
 * @return array
 */
add_filter(
	'anony_anony_news_supports',
	function ( $support ) {
		return array( 'editor' );
	}
);


/**
 * We should flush rewrite rules, so as not to get 404 for custom post types
 */
add_action( 'after_switch_theme', 'flush_rewrite_rules' );

// Filter reply link
add_filter(
	'comment_reply_link',
	function ( $link, $args, $comment, $post ) {
		if ( wp_doing_ajax() ) {
			if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
				$link = sprintf(
					'<a rel="nofollow" class="anony-comment-reply-login" href="%s">%s</a>',
					esc_url( wp_login_url( get_permalink( $post ) ) ),
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

				$current_url = str_replace( get_bloginfo( 'url' ), '', get_permalink( $post ) );

				$link = sprintf(
					"<a rel='nofollow' class='comment-reply-link' href='%s' %s aria-label='%s'>%s</a>",
					esc_url(
						add_query_arg(
							array(
								'replytocom'      => $comment->comment_ID,
								'unapproved'      => false,
								'moderation-hash' => false,
							),
							$current_url
						)
					) . '#' . $args['respond_id'],
					$data_attribute_string,
					esc_attr( sprintf( $args['reply_to_text'], $comment->comment_author ) ),
					$args['reply_text']
				);
			}
			return $link;
		}

		return $link;

	},
	'',
	4
);

// Filter commet classes
add_filter(
	'comment_class',
	function ( $classes, $class, $comment_id, $comment, $post_id ) {
		if ( intval( $comment->comment_parent ) != 0 ) {

			$classes[] = 'child';

			return $classes;
		}

		return $classes;
	},
	'',
	5
);

// Add tinymce to the comment form
add_filter(
	'comment_form_defaults',
	function ( $args ) {

		$anony_options = ANONY_Options_Model::get_instance();

		if ( $anony_options->tinymce_comments != '1' ) {
			return $args;
		}

		ob_start();

		wp_editor(
			'',
			'comment',
			array(

				// 'media_buttons' => true, // show insert/upload button(s) to users with permission

				'textarea_rows' => '10', // re-size text area

				'dfw'           => true, // replace the default full screen with DFW (WordPress 3.4+)

				'tinymce'       => array(

					'theme_advanced_buttons1' => 'bold,italic,underline,strikethrough,bullist,numlist,code,blockquote,link,unlink,outdent,indent,|,undo,redo,fullscreen',

				),

				'quicktags'     => array(

					'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close',

				),

			)
		);

		$args['comment_field'] = ob_get_clean();

		return $args;

	}
);

// remove width and height atrr from img
add_filter(
	'post_thumbnail_html',
	function ( $html ) {

		return preg_replace( '/(width|height)="\d+"\s/', '', $html );
	}
);

// Chenge excerpt length
add_filter(
	'excerpt_length',
	function () {
		return 15;
	},
	999
);

// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

// Set post views count
add_action(
	'template_redirect',
	function () {

		global $post;

		if ( is_single() ) {
			anony_set_post_views( $post->ID );
		}
	}
);

/*
-------------------------------------------------------------
 * Posts functions
 *-----------------------------------------------------------*/

/**
 * Gets post views count.
 *
 * @param  string $postID The post ID to get views count for
 * @return string post views count
 */
function anony_get_post_views( $postID ) {
	$count_key = 'post_views_count';
	$count     = get_post_meta( $postID, $count_key, true );
	if ( $count == '' ) {
		delete_post_meta( $postID, $count_key );
		add_post_meta( $postID, $count_key, '0' );
		return '0';
	}
	return $count;
}

/**
 * Sets post views count.
 *
 * @param  string $postID The post ID to set views count for
 * @return void
 */
function anony_set_post_views( $postID ) {
	$count_key = 'post_views_count';
	$count     = get_post_meta( $postID, $count_key, true );
	if ( $count == '' ) {
		$count = 0;
		delete_post_meta( $postID, $count_key );
		add_post_meta( $postID, $count_key, '0' );
	} else {
		$count++;
		update_post_meta( $postID, $count_key, $count );
	}
}

/**
 * Gets number of posts per category.
 *
 * @param  int $idcat The category ID to get posts count for
 * @return int posts count
 */
function anony_cat_posts_count( $idcat ) {
	global $wpdb;
	$query = "SELECT count FROM $wpdb->term_taxonomy WHERE term_id = $idcat";
	$num   = $wpdb->get_col( $query );
	if ( is_array( $num ) && ! empty( $num ) ) {
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
function anony_latest_comments() {
	$args = array( 'number' => 4 );

	if ( is_user_logged_in() ) {
		$args['author__not_in'] = array( get_current_user_id() );
	}

	$comments = get_comments( $args );

	if ( count( $comments ) > 0 ) {

		foreach ( $comments as $comment ) { ?>    
			
				<div  class="anony-recent-comment-wrapper">
				
					<h3><?php echo '<i class="fa fa-user"></i> ' . $comment->comment_author . ' ' . __( 'Commented', 'smartpage' ); ?></h3>
					
					<p class='recent-comment'>
			<?php echo mb_substr( $comment->comment_content, 0, 150 ) . '... '; ?>
					
					<a href="<?php echo get_the_permalink( $comment->comment_post_ID ); ?>"><?php esc_html_e( 'View Post', 'smartpage' ); ?></a>
					
					</p>
					
				</div>
				
			<?php
		}
	} else {
		?>
				
		<p><?php esc_html_e( 'No comments yet', 'smartpage' ); ?></p>
		
		<?php
	};
}
