<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}

if ( ! function_exists( 'anony_elementor_editor_custom_fonts' ) ) {
	function anony_elementor_editor_custom_fonts() {

		$custom_fonts = ANONY_Post_Help::queryPostTypeSimple( 'anony_fonts' );

		$font_faces = '';
		if ( ! empty( $custom_fonts ) ) {

			foreach ( $custom_fonts as $id => $title ) {
				$font_faces .= anony_render_font_face( $id );
			}
		}

		if ( ! empty( $font_faces ) ) : ?>
			<style id="anony-editor-custom-fonts">
				<?php echo $font_faces; ?>
			</style>
			<?php
		endif;
	}
}

add_action( 'elementor/editor/wp_head', 'anony_elementor_editor_custom_fonts' );


if ( ! function_exists( 'anony_get_font_family' ) ) {
	function anony_get_font_family() {
		$anony_options = ANONY_Options_Model::get_instance();

		if ( ! empty( $anony_options->anony_general_font ) ) {

			$font_variations = get_post_meta( intval( $anony_options->anony_general_font ), 'anony_font_variations', true );

			if ( empty( $font_variations['font_family'] ) ) {

				$font_family = sanitize_title( get_the_title( intval( $anony_options->anony_general_font ) ) );

			} else {

				$font_family = sanitize_title( $font_variations['font_family'] );
			}
		} else {
			$font_family = 'Arial';
		}
		return $font_family;
	}

}
if ( ! function_exists( 'anony_render_font_face' ) ) {
	function anony_render_font_face( $post_id ) {
		$font_variations = get_post_meta( intval( $post_id ), 'anony_font_variations', true );
		$url             = '';
		$font_face       = false;
		if ( $font_variations && ! empty( $font_variations ) ) {
			$font_variations = array_map( 'intval', $font_variations );
			if ( ! empty( $font_variations['eot'] ) ) {
				$eot_url = wp_get_attachment_url( $font_variations['eot'] );

				if ( $eot_url ) {
					$url .= "url('{$eot_url}') format('embedded-opentype'),";
				}
			}

			if ( ! empty( $font_variations['woff'] ) ) {
				$woff = wp_get_attachment_url( $font_variations['woff'] );

				if ( $woff ) {
					$url .= "url('{$woff}') format('woff'),";
				}
			}

			if ( ! empty( $font_variations['woff2'] ) ) {
				$woff2 = wp_get_attachment_url( $font_variations['woff2'] );

				if ( $woff2 ) {
					$url .= "url('{$woff2}') format('woff2'),";
				}
			}

			if ( ! empty( $font_variations['svg'] ) ) {
				$svg = wp_get_attachment_url( $font_variations['svg'] );

				if ( $svg ) {
					$url .= "url('{$svg}') format('svg'),";
				}
			}

			if ( ! empty( $url ) ) {

				$url = rtrim( $url, ',' );

				if ( empty( $font_variations['font_family'] ) ) {
					$font_family = sanitize_title( get_the_title( intval( $post_id ) ) );
				} else {
					$font_family = sanitize_title( $font_variations['font_family'] );
				}

				$font_face = '@font-face{
						font-family:"' . $font_family . '";
						src:' . $url . ';
						font-weight:normal;
						font-style:normal;

					}';
			}
		}

		return $font_face;
	}
}

if ( ! function_exists( 'anony_elementor_custom_fonts' ) ) {
	function anony_elementor_custom_fonts( $fonts ) {

		$custom_fonts = ANONY_Post_Help::queryPostTypeSimple( 'anony_fonts' );

		if ( ! empty( $custom_fonts ) ) {
			foreach ( $custom_fonts as $id => $title ) {
				$fonts[ sanitize_title( $title ) ] = 'smartpage';
			}
		}
		return $fonts;
	}
}
add_filter( 'elementor/fonts/additional_fonts', 'anony_elementor_custom_fonts', 999 );

if ( ! function_exists( 'anony_insert_font_face' ) ) {
	function anony_insert_font_face() {
		$anony_options = ANONY_Options_Model::get_instance();

		if ( ! empty( $anony_options->anony_general_font ) ) {

			$font_face = anony_render_font_face( $anony_options->anony_general_font );

			if ( $font_face ) :
				?>
				<style id="anony-custom-font">
					<?php echo $font_face; ?>
				</style>
				<?php
			endif;
		}
	}
}
add_action( 'wp_head', 'anony_insert_font_face' );




/**
 * Load default templates.
 *
 * @param string $template The path of the template to include.
 * @return string The path of the template to include.
 */
function anony_load_defaults( $template ) {

	$template = locate_template( 'defaults/index.php', false, false );

	if ( is_page() && ! is_front_page() ) {
		$template = locate_template( 'defaults/page.php', false, false );
	}
	return $template;
}

if ( ! function_exists( 'anony_category_posts_section' ) ) {
	/**
	 * @param $args  array Loop args
	 * @param $title string Section title
	 */
	function anony_category_posts_section( $args, $title = '' ) {
		$grid = 'standard';
		if ( class_exists( 'ANONY_Options_Model' ) ) {

			$anony_options = ANONY_Options_Model::get_instance();

			$grid = $anony_options->posts_grid;
		}

		$query = new WP_Query( $args );

		$data = array();

		if ( $query->have_posts() ) {

			while ( $query->have_posts() ) {
				$query->the_post();

				$data[] = anony_common_post_data();
			}

			wp_reset_postdata();
		}
		if ( empty( $data ) ) {
			return;
		}

		include locate_template( 'templates/category-posts-section-view.php', false, false );
	}
}

if ( ! function_exists( 'anony_get_correct_sidebar' ) ) {
	/**
	 * Desides which sidebar to load according to page direction
	 */
	function anony_get_correct_sidebar() {

		if ( class_exists( 'ANONY_Options_Model' ) ) {
			$anony_options = ANONY_Options_Model::get_instance();

			if ( $anony_options->sidebar == 'left-sidebar' ) {
				get_sidebar();

				return;
			} elseif ( $anony_options->single_sidebar == '1' ) {
				get_sidebar( 'left' );
				return;
			}
		}

		get_sidebar();
	}
}

if ( ! function_exists( 'anony_get_custom_logo' ) ) {
	/**
	 * Generates logo markup.
	 *
	 * **Description: ** If logo is set from customizer it will display it.
	 * otherwise it will display a default theme logo.<br/>
	 * **Note: ** can be overriden by hookin on anony_get_custom_logo.
	 *
	 * @param  string $color The color of theme's default logo,
	 *                       Will have no effect once a logo is set from customizer.
	 * @return string Theme's logo with a link to the homepage
	 */
	function anony_get_custom_logo( $color = 'main' ) {
		$logo_url = ANONY_THEME_URI . '/images/logo-' . $color . '.png';

		if ( has_custom_logo() ) {
			$logo = '<div id="anony-logo" class="anony-grid-col-md-4 anony-grid-col-sm-3">' . get_custom_logo() . '</div>';
		} else {

			$logo  = '<div id="anony-logo" class="anony-grid-col-md-4 anony-grid-col-sm-3"><h1>';
			$logo .= '<a href="' . ANONY_BLOG_URL . '" title="' . ANONY_BLOG_TITLE . '" data-logourl="' . $logo_url . '">';
			$logo .= '<img alt="' . ANONY_BLOG_TITLE . '" ';
			$logo .= 'src="' . $logo_url . '"/>';
			$logo .= '</a></h1></div>';
		}
		return apply_filters( 'anony_get_custom_logo', $logo );
	}
}

if ( ! function_exists( 'anony_get_custom_logo_url' ) ) {
	/**
	 * get custom logo url.
	 */
	function anony_get_custom_logo_url( $color = 'main' ) {
		if ( has_custom_logo() ) {
			$custom_logo_id = get_theme_mod( 'custom_logo' );

			$logo = wp_get_attachment_image_url( $custom_logo_id, 'full' );
		} else {
			$logo = ANONY_THEME_URI . '/images/logo-' . $color . '.png';
		}

		return apply_filters( 'anony_get_custom_logo_url', $logo );
	}
}

if ( ! function_exists( 'anony_remove_type_attr' ) ) {
	/**
	 * Remove type attribute from styles/scripts.
	 *
	 * **Description: ** It is recommended to remove type attribute from styles/scripts that has a link|src attribute.
	 *
	 * @param  $tag    string style|script tag
	 * @param  $handle string style|script handle defined with wp_register_style|wp_register_script
	 * @return string styles/scripts tags with no type attribute.
	 */
	function anony_remove_type_attr( $tag, $handle ) {
		return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
	}
}

if ( ! function_exists( 'anony_comments_number' ) ) {
	/**
	 * Generates comments number markup.
	 *
	 * @return string HTML of comments number.
	 */
	function anony_comments_number() {
		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

		if ( comments_open() ) {

			$comment_text = esc_html__( 'comment', 'smartpage' );

			if ( $num_comments != 1 ) {

				$comment_text = esc_html__( 'comments', 'smartpage' );

			}

			$comments = '<a class="meta-text" href="' . esc_url( get_comments_link() ) . '"> ' . $num_comments . '</a><span class="meta-text single-meta-text">&nbsp;' . $comment_text . '&nbsp;</span>';
		} else {
			$comments = '<span class="meta-text single-meta-text">' . esc_html__( 'Comments-off', 'smartpage' ) . '</span>';
		}
		return $comments;
	}
}

/**
 * Renders sction title
 *
 * @param  string $title Title text.
 * @return string
 */
function anony_section_title( $title = '' ) {
	if ( empty( $title ) ) {
		return;
	}
	$html  = '<div class="anony-section-title">';
	$html .= '<img src="https://cleo.makiomar.com/wp-content/uploads/2022/08/ezgif.com-gif-maker-6.webp" width="224" height="80"/>';
	$html .= '<h4>' . esc_html( $title ) . '</h4>';
	$html .= '</div>';
	return $html;
}
if ( ! function_exists( 'anony_common_post_data' ) ) {
	/**
	 * Collects common post data
	 *
	 * @return array
	 */
	function anony_common_post_data( $post_type = 'post' ) {
		$grid = 'standard';
		if ( class_exists( 'ANONY_Options_Model' ) ) {

			$anony_options = ANONY_Options_Model::get_instance();

			$grid = $anony_options->posts_grid;
		}

		$p_id                 = get_the_ID();
		$temp['id']           = $p_id;
		$temp['permalink']    = esc_url( get_the_permalink() );
		$temp['title']        = esc_html( get_the_title() );
		$temp['title_attr']   = the_title_attribute( array( 'echo' => false ) );
		$temp['content']      = apply_filters( 'the_content', get_the_content() );
		$temp['excerpt']      = wp_trim_words( esc_html( get_the_excerpt() ), 25 );
		$temp['thumb']        = has_post_thumbnail();
		$temp['thumb_exists'] = true;
		$temp['date']         = get_the_date();
		$temp['gravatar']     = get_avatar( get_the_author_meta( 'ID' ), 32 );
		// Translators: Author's name.
		$temp['author']          = sprintf( esc_html__( 'By %s', 'smartpage' ), get_the_author() );
		$temp['read_more']       = esc_html__( 'Read more', 'smartpage' );
		$temp['grid']            = $grid;
		$temp['views']           = anony_get_post_views( $p_id );
		$temp['comments_open']   = comments_open();
		$temp['comments_number'] = anony_comments_number();
		$temp['has_category']    = has_category();

		if ( $post_type === 'post' ) {
			if ( has_category() ) {
				$_1st_category              = get_the_category()[0];
				$temp['categories']         = get_the_category();
				$temp['_1st_category_id']   = $_1st_category->cat_ID;
				$temp['_1st_category_name'] = esc_html( $_1st_category->name );
				$temp['_1st_category_url']  = esc_url( get_category_link( $_1st_category->cat_ID ) );
			}
		} else {
			$temp['terms'] = array();
			if ( has_term() ) {
				$_1st_category              = get_the_term()[0];
				$temp['categories']         = get_the_term();
				$temp['_1st_category_id']   = $_1st_term->term_id;
				$temp['_1st_category_name'] = esc_html( $_1st_term->name );
				$temp['_1st_category_url']  = esc_url( get_term_link( $_1st_term->term_id ) );
			}
		}

		return apply_filters( $post_type . '_loop_data', $temp, $p_id );
	}
}

if ( ! function_exists( 'anony_pagination' ) ) {
	/**
	 * render posts pagination
	 *
	 * @return string Markup for pagination links.
	 */
	function anony_pagination() {
		$prev_text = is_rtl() ? 'right' : 'left';

		$next_text  = is_rtl() ? 'left' : 'right';
		$pagination = get_the_posts_pagination(
			array(
				'type'               => 'list',
				'prev_text'          => '<i class="fa fa-arrow-' . $prev_text . '"></i>',
				'next_text'          => '<i class="fa fa-arrow-' . $next_text . '"></i>',
				'screen_reader_text' => ' ',
				'class'              => 'anony-page-numbers',

			)
		);

		return $pagination;
	}
}
/*
-------------------------------------------------------------
 * Posts functions
 *-----------------------------------------------------------*/

if ( ! function_exists( 'anony_get_post_views' ) ) {
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
}

if ( ! function_exists( 'anony_set_post_views' ) ) {
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
			++$count;
			update_post_meta( $postID, $count_key, $count );
		}
	}
}

if ( ! function_exists( 'anony_cat_posts_count' ) ) {
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
}
if ( ! function_exists( 'anony_latest_comments' ) ) {
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

			foreach ( $comments as $comment ) {
				?>
					

					<div  class="anony-recent-comment-wrapper">

						<h3><?php echo '<i class="fa fa-user"></i> ' . $comment->comment_author . ' ' . __( 'Commented', 'smartpage' ); ?></h3>

						<p class='recent-comment'>
							<?php echo $comment->comment_content; ?>

							<?php if ( get_the_permalink( $comment->comment_post_ID ) ) : ?>
								<a href="<?php echo get_the_permalink( $comment->comment_post_ID ); ?>"><?php esc_html_e( 'View Post', 'smartpage' ); ?></a>
							<?php endif ?>

						</p>

					</div>

				<?php
			}
		} else {
			?>

			<p><?php esc_html_e( 'No comments yet', 'smartpage' ); ?></p>

			<?php
		}
	}
}