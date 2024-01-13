<?php
/**
 * Posts Functions
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * -------------------------------------------------------------
 * Posts hooks
 * -------------------------------------------------------------
 */

/**
 * Extend custom post types
 *
 * @return array of post types
 */
add_filter(
	'anony_post_types',
	function ( $custom_post_types ) {
		$custom_posts = array();
		if ( class_exists( 'ANONY_Options_Model' ) && get_option( ANONY_OPTIONS ) ) {
			$anony_options = ANONY_Options_Model::get_instance();

			if ( '1' === $anony_options->enable_portfolio ) {
				$custom_posts ['portfolio'] = array(
					esc_html__( 'portfolio', 'smartpage' ),
					esc_html__( 'Portfolios', 'smartpage' ),
				);
			}

			if ( '1' === $anony_options->enable_downloads ) {
				$custom_posts ['anony_download'] = array(
					esc_html__( 'Download', 'smartpage' ),
					esc_html__( 'Downloads', 'smartpage' ),
				);
			}

			if ( '1' === $anony_options->enable_testimonials ) {
				$custom_posts ['anony_testimonial'] = array(
					esc_html__( 'Testimonial', 'smartpage' ),
					esc_html__( 'Testimonials', 'smartpage' ),
				);
			}

			if ( '1' === $anony_options->enable_news ) {
				$custom_posts ['anony_news'] = array(
					esc_html__( 'New', 'smartpage' ),
					esc_html__( 'News', 'smartpage' ),
				);
			}

			if ( '1' === $anony_options->enable_faqs ) {
				$custom_posts ['anony_faqs'] = array(
					esc_html__( 'FAQ', 'smartpage' ),
					esc_html__( 'FAQs', 'smartpage' ),
				);
			}

			$custom_posts ['anony_fonts'] = array(
				esc_html__( 'Font', 'smartpage' ),
				esc_html__( 'Fonts', 'smartpage' ),
			);
		}

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
			'anony_faqs_cats' =>
				array(
					esc_html__( 'FAQs categories', 'smartpage' ),
					esc_html__( 'FAQs category', 'smartpage' ),
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

		$post_taxs = array(
			'anony_download' => array( 'anony_download_type' ),
		);
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

		$tax_posts = array(
			'anony_download_type' => array( 'anony_download' ),
			'anony_faqs_cats'     => array( 'anony_faqs' ),
		);

		return array_merge( $anony_tax_posts, $tax_posts );
	}
);


/**
 * Change news post type support
 *
 * @return array
 */
add_filter(
	'anony_anony_news_supports',
	function () {
		return array( 'editor' );
	}
);

/**
 * Change news post type support
 *
 * @return array
 */
add_filter(
	'anony_anony_faqs_supports',
	function () {
		return array( 'title', 'editor' );
	}
);

/**
 * Change anony_fonts post type args
 *
 * @return array
 */
add_filter(
	'anony_anony_fonts_args',
	function ( $args ) {
		$args['public']              = false;
		$args['supports']            = array( 'title' );
		$args['has_archive']         = false;
		$args['exclude_from_search'] = true;

		return $args;
	}
);


/**
 * We should flush rewrite rules, so as not to get 404 for custom post types
 */
add_action( 'after_switch_theme', 'flush_rewrite_rules' );

// Filter reply link.
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
					$data_attribute_string .= " data-{$name}=\"" . esc_attr( $value ) . '"';
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

// Filter commet classes.
add_filter(
	'comment_class',
	// phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	function ( $classes, $comment_class, $comment_id, $comment, $post_id ) {
		// phpcs:enable.
		if ( 0 !== intval( $comment->comment_parent ) ) {

			$classes[] = 'child';

			return $classes;
		}

		return $classes;
	},
	'',
	5
);

// Add tinymce to the comment form.
add_filter(
	'comment_form_defaults',
	function ( $args ) {

		$anony_options = ANONY_Options_Model::get_instance();

		if ( '1' !== $anony_options->tinymce_comments ) {
			return $args;
		}

		ob_start();

		wp_editor(
			'',
			'comment',
			array(

				'textarea_rows' => '10', // re-size text area.

				'dfw'           => true, // replace the default full screen with DFW (WordPress 3.4+).

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

// remove width and height atrr from img.
add_filter(
	'post_thumbnail_html',
	function ( $html ) {

		return preg_replace( '/(width|height)="\d+"\s/', '', $html );
	}
);

// Chenge excerpt length.
add_filter(
	'excerpt_length',
	function () {
		return 15;
	},
	999
);

// Remove issues with prefetching adding extra views.
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

// Set post views count.
add_action(
	'template_redirect',
	function () {

		global $post;

		if ( is_single() ) {
			anony_set_post_views( $post->ID );
		}
	}
);
