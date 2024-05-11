<?php
/**
 * Theme helpers
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Helper that require all files in a folder/subfolders once.
 *
 * @param string $dir Directory path.
 * @return void
 */
function smpg_require_all_files( $dir ) {
	foreach ( glob( "$dir/*" ) as $path ) {
		if ( preg_match( '/\.php$/', $path ) ) {
			require_once $path; // It's a PHP file, so just require it.
		} elseif ( is_dir( $path ) ) {
			atrn_require_all_files( $path ); // It's a subdir, so call the same function for this subdir.
		}
	}
}
/**
 * Display a hint for administrator if he missd somthing.
 *
 * @param string $hint The hint.
 * @return string
 */
function anony_admin_hint( $hint ) {
	if ( current_user_can( 'manage_options' ) ) {
		return '<p>' . esc_html( $hint ) . '</p>';
	}
}
/**
 * Get current object title
 *
 * @param bool $_echo Set true to echo, Otherwise set to false.
 * @return string
 */
function anony_current_object_title( $_echo = true ) {

	$permalink = '';
	$title     = '';

	if ( is_singular() ) {
		global $post;
		$permalink = get_permalink( $post->ID );
		$title     = '<a href="' . $permalink . '">' . $post->post_title . '</a>';
	} elseif ( is_post_type_archive() ) {
		$post_type        = get_post_type();
		$permalink        = get_post_type_archive_link( $post_type );
		$post_type_object = get_post_type_object( $post_type );
		if ( $post_type_object ) {
			$post_type_label = $post_type_object->labels->name; // or use 'singular_name' for the singular label.
			$title           = '<a href="' . $permalink . '">' . $post_type_label . '</a>';
		}
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$term      = get_queried_object();
		$permalink = get_term_link( $term );
		$title     = '<a href="' . $permalink . '">' . $term->name . '</a>';
	} elseif ( is_archive() ) {
		$permalink      = get_post_type_archive_link( get_post_type() );
		$queried_object = get_queried_object();
		if ( $queried_object && isset( $queried_object->label ) ) {
			$archive_label = $queried_object->label;
			$title         = '<a href="' . $permalink . '">' . $archive_label . '</a>';
		}
	}
	if ( $_echo ) {
		echo wp_kses_post( $title );
	} else {
		return $title;
	}
}
/**
 * Get menus
 *
 * @return array
 */
function anony_get_menus() {
	$menus       = get_terms( 'nav_menu' );
	$menus_array = array();

	foreach ( $menus as $menu ) {
		$menus_array[ $menu->term_id ] = $menu->name;
	}

	return $menus_array;
}

if ( ! function_exists( 'anony_elementor_editor_custom_fonts' ) ) {
	/**
	 * Add custom fonts to elementor'd editor head
	 *
	 * @return void
	 */
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
				<?php
				//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $font_faces;
				//phpcs:enable.
				?>
			</style>
			<?php
		endif;
	}
}

add_action( 'elementor/editor/wp_head', 'anony_elementor_editor_custom_fonts' );


if ( ! function_exists( 'anony_get_font_family' ) ) {
	/**
	 * Get font family
	 *
	 * @return string
	 */
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
	/**
	 * Generate font face
	 *
	 * @param int $post_id Font face.
	 * @return string
	 */
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
						font-display: swap;
					}';
			}
		}

		return $font_face;
	}
}

if ( ! function_exists( 'anony_elementor_custom_fonts' ) ) {
	/**
	 * Add fonts to elementor
	 *
	 * @param array $fonts Fonts' array.
	 * @return array
	 */
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
	/**
	 * Add font face to head
	 *
	 * @return void
	 */
	function anony_insert_font_face() {
		$anony_options = ANONY_Options_Model::get_instance();

		if ( ! empty( $anony_options->anony_general_font ) ) {

			$font_face = anony_render_font_face( $anony_options->anony_general_font );

			if ( $font_face ) :
				?>
				<style id="anony-custom-font">
					<?php
					//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
					echo $font_face;
					//phpcs:enable.
					?>
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
	 * Render category's posts' section
	 *
	 * @param array  $args Loop args.
	 * @param string $title Section title.
	 */
	function anony_category_posts_section( $args, $title = '' ) {
		$title = $title;
		$grid  = 'standard';
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
if ( ! function_exists( 'anony_dynamic_sidebar' ) ) {
	/**
	 * Get sidebar
	 *
	 * @param string $id Sidebar's ID.
	 */
	function anony_dynamic_sidebar( $id ) {
		if ( is_active_sidebar( $id ) ) {

			dynamic_sidebar( $id );

		} elseif ( current_user_can( 'manage_options' ) ) {
			?>
				
			<?php if ( current_user_can( 'manage_options' ) ) { ?>
			<strong>
				<?php esc_html_e( 'Please add some widgets. ', 'smartpage' ); ?>    
			</strong>
			<?php } ?>
			<a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"><?php esc_html_e( 'Add Here', 'smartpage' ); ?></a>
				
			<?php
		}
	}
}

if ( ! function_exists( 'anony_get_correct_sidebar' ) ) {
	/**
	 * Desides which sidebar to load according to page direction
	 */
	function anony_get_correct_sidebar() {

		if ( class_exists( 'ANONY_Options_Model' ) ) {
			$anony_options = ANONY_Options_Model::get_instance();

			if ( 'left-sidebar' === $anony_options->sidebar ) {
				get_sidebar();

				return;
			} elseif ( '1' === $anony_options->single_sidebar ) {
				get_sidebar( 'left' );
				return;
			}
		}

		get_sidebar();
	}
}
/**
 * Get logo img markup.
 * The default WP customizer log
 *
 * @param  string $color The color of theme's default logo.
 * @return string Theme's logo img with a link to the homepage
 */
function anony_get_custom_logo_img( $color = 'main' ) {
	$logo_url = ANONY_THEME_URI . '/images/logo-' . $color . '.png';
	if ( has_custom_logo() ) {
		$logo = get_custom_logo();
	} else {
		$logo  = '<a href="' . ANONY_BLOG_URL . '" title="' . ANONY_BLOG_TITLE . '" data-logourl="' . esc_attr( $logo_url ) . '">';
		$logo .= '<img alt="' . ANONY_BLOG_TITLE . '" ';
		$logo .= 'src="' . esc_attr( $logo_url ) . '"/>';
		$logo .= '</a>';
	}

	return apply_filters( 'anony_get_custom_logo', $logo );
}

/**
 * Get logo img markup.
 * The default WP customizer log
 *
 * @return string Theme's logo img with a link to the homepage
 */
function anony_get_theme_logo() {
	if ( class_exists( 'ANONY_Options_Model' ) ) {
		$anony_options = ANONY_Options_Model::get_instance();
		if ( wp_is_mobile() ) {
			$logo_id = $anony_options->mobile_logo;
		} else {
			$logo_id = $anony_options->logo;
		}
		if ( $logo_id && ! empty( $logo_id ) ) {
			$logo  = '<a href="' . ANONY_BLOG_URL . '" title="' . ANONY_BLOG_TITLE . '">';
			$logo .= wp_get_attachment_image( absint( $logo_id ), 'full' );
			$logo .= '</a>';
			return apply_filters( 'anony_get_theme_logo', $logo );
		} else {
			return anony_get_custom_logo_img( 'orange' );
		}
	} else {
		return anony_get_custom_logo_img( 'orange' );
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
		$logo = anony_get_custom_logo_img( $color );
		return apply_filters( 'anony_get_custom_logo', $logo );
	}
}

if ( ! function_exists( 'anony_get_custom_logo_url' ) ) {
	/**
	 * Get custom logo url.
	 *
	 * @param string $color Logo color.
	 * @return string
	 */
	function anony_get_custom_logo_url( $color = 'main' ) {
		if ( has_custom_logo() ) {
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			if ( wp_is_mobile() ) {
				$size = 'thumb-50-50';
			} else {
				$size = 'thumb-80-80';
			}
			$logo = wp_get_attachment_image_url( $custom_logo_id, $size );
		} else {
			$logo = ANONY_THEME_URI . '/images/logo-' . $color . '.png';
		}

		return apply_filters( 'anony_get_custom_logo_url', $logo );
	}
}

if ( ! function_exists( 'anony_comments_number' ) ) {
	/**
	 * Generates comments number markup.
	 *
	 * @return string HTML of comments number.
	 */
	function anony_comments_number() {
		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value.

		if ( comments_open() ) {

			$comment_text = esc_html__( 'comment', 'smartpage' );

			if ( 1 !== $num_comments ) {

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
 * @param  string $style Title style.
 * @return string
 */
function anony_section_title( $title = '', $style = 'default' ) {
	if ( empty( $title ) ) {
		return;
	}
	$html = "<div class='anony-section-title-wrapper anony-section-title-{$style}'>";

	if ( 'one' === $style ) {
		$html .= '<img src="/wp-content/uploads/2022/08/ezgif.com-gif-maker-6.webp" alt="' . esc_attr( $title ) . '" width="224" height="80"/>';
	}
	$html .= '<h1 class="anony-section-title" style="font-size:18px">' . esc_html( $title ) . '</h1>';
	$html .= '</div>';
	return $html;
}
if ( ! function_exists( 'anony_common_post_data' ) ) {
	/**
	 * Collects common post data
	 *
	 * @param string $post_type Post type.
	 * @param mixed  $taxonomy Post type taxonomy.
	 * @return array
	 */
	function anony_common_post_data( $post_type = 'post', $taxonomy = false ) {
		$grid = 'standard';
		if ( class_exists( 'ANONY_Options_Model' ) ) {

			$anony_options = ANONY_Options_Model::get_instance();

			$grid = $anony_options->posts_grid;
		}

		$p_id                 = get_the_ID();
		$temp['id']           = $p_id;
		$temp['permalink']    = esc_url( get_the_permalink() );
		$temp['title']        = get_the_title();
		$temp['title_attr']   = the_title_attribute( array( 'echo' => false ) );
		$temp['content']      = apply_filters( 'the_content', get_the_content() );
		$temp['excerpt']      = wp_trim_words( get_the_excerpt(), 25 );
		$temp['thumb']        = has_post_thumbnail();
		$temp['thumb_exists'] = true;
		$temp['date']         = get_the_date();
		$temp['gravatar']     = get_avatar( get_the_author_meta( 'ID' ), 32 );
		// Translators: Author's name.
		$temp['author']          = sprintf( esc_html__( 'By %s', 'smartpage' ), get_the_author() );
		$temp['read_more']       = __( 'Read more', 'smartpage' );
		$temp['grid']            = $grid;
		$temp['views']           = anony_get_post_views( $p_id );
		$temp['comments_open']   = comments_open();
		$temp['comments_number'] = anony_comments_number();
		$temp['has_category']    = has_category();

		if ( 'post' === $post_type ) {
			if ( has_category() ) {
				$temp['categories'] = get_the_category();
				if ( ! empty( $temp['categories'] ) ) {
					$_1st_category              = $temp['categories'][0];
					$temp['_1st_category_id']   = $_1st_category->cat_ID;
					$temp['_1st_category_name'] = esc_html( $_1st_category->name );
					$temp['_1st_category_url']  = esc_url( get_category_link( $_1st_category->cat_ID ) );
				}
			}
		} elseif ( $taxonomy ) {
			$temp['terms'] = array();
			if ( has_term() ) {
				$temp['categories'] = get_the_terms( get_the_ID(), $taxonomy );
				if ( $temp['categories'] && ! is_wp_error( $temp['categories'] ) ) {
					$_1st_category              = $temp['categories'][0];
					$temp['_1st_category_id']   = $_1st_category->term_id;
					$temp['_1st_category_name'] = esc_html( $_1st_category->name );
					$temp['_1st_category_url']  = esc_url( get_term_link( $_1st_category->term_id ) );
				}
			}
		}

		return apply_filters( $post_type . '_loop_data', $temp, $p_id );
	}
}

if ( ! function_exists( 'anony_pagination' ) ) {
	/**
	 * Render posts pagination
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
/**
 *-------------------------------------------------------------
 * Posts functions
 *-----------------------------------------------------------
 */

if ( ! function_exists( 'anony_get_post_views' ) ) {
	/**
	 * Gets post views count.
	 *
	 * @param  string $post_id The post ID to get views count for.
	 * @return string post views count.
	 */
	function anony_get_post_views( $post_id ) {
		$count_key = 'post_views_count';
		$count     = get_post_meta( $post_id, $count_key, true );
		if ( '' === $count ) {
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '0' );
			return '0';
		}
		return $count;
	}
}

if ( ! function_exists( 'anony_set_post_views' ) ) {
	/**
	 * Sets post views count.
	 *
	 * @param  string $post_id The post ID to set views count for.
	 * @return void
	 */
	function anony_set_post_views( $post_id ) {
		$count_key = 'post_views_count';
		$count     = get_post_meta( $post_id, $count_key, true );
		if ( '' === $count ) {
			$count = 0;
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '0' );
		} else {
			++$count;
			update_post_meta( $post_id, $count_key, $count );
		}
	}
}

if ( ! function_exists( 'anony_cat_posts_count' ) ) {
	/**
	 * Gets number of posts per category.
	 *
	 * @param  int $idcat The category ID to get posts count for.
	 * @return int posts count
	 */
	function anony_cat_posts_count( $idcat ) {
		global $wpdb;
		$num = ANONY_Wp_Db_Help::get_col( $wpdb->prepare( "SELECT count FROM $wpdb->term_taxonomy WHERE term_id = %s", $idcat ), 'anony_cat_posts_count_' . $idcat );
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

						<h3><?php echo '<i class="fa fa-user"></i> ' . wp_kses_post( $comment->comment_author ) . ' ' . esc_html__( 'Commented', 'smartpage' ); ?></h3>

						<p class='recent-comment'>
							<?php echo wp_kses_post( $comment->comment_content ); ?>

							<?php
							$comment_permalink = get_the_permalink( $comment->comment_post_ID );
							if ( $comment_permalink ) :
								?>
								<a href="<?php echo esc_url( $comment_permalink ); ?>"><?php esc_html_e( 'View Post', 'smartpage' ); ?></a>
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
if ( ! function_exists( 'anony_option_svg_icon' ) ) {
	/**
	 * Get svg icon stored in an option filed.
	 *
	 * @param array $field_name Option field name.
	 * @return string
	 */
	function anony_option_svg_icon( $field_name ) {

		$anony_options = ANONY_Options_Model::get_instance();
		$icon          = $anony_options->$field_name;

		if ( ! empty( $icon ) ) {
			return $icon;
		}
		return '';
	}
}