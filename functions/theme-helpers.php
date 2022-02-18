<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @param $args  array Loop args
 * @param $title string Section title
 */
function anony_category_posts_section( $args, $title = '' ) {
	$anony_options = ANONY_Options_Model::get_instance();

	$grid = $anony_options->posts_grid;

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

	include locate_template( 'templates/category-posts-section.view.php', false, false );

}
/**
 * Desides which sidebar to load according to page direction
 *
 * @return void
 */
function anony_get_correct_sidebar() {
	$anony_options = ANONY_Options_Model::get_instance();

	if ( $anony_options->sidebar == 'left-sidebar' ) {
		get_sidebar();
	} elseif ( $anony_options->single_sidebar == '1' ) {
		get_sidebar( 'left' );
	}

}

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

/**
 * Generates comments number markup.
 *
 * @return string HTML of comments number.
 */
function anony_comments_number() {
	$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

	if ( comments_open() ) {

		$comment_text = esc_html__( 'comment', ANONY_TEXTDOM );

		if ( $num_comments != 1 ) {

			$comment_text = esc_html__( 'comments', ANONY_TEXTDOM );

		}

		$comments = '<a class="meta-text" href="' . esc_url( get_comments_link() ) . '"> ' . $num_comments . '</a><span class="meta-text single-meta-text">&nbsp;' . $comment_text . '&nbsp;</span>';
	} else {
		$comments = '<span class="meta-text single-meta-text">' . esc_html__( 'Comments-off', ANONY_TEXTDOM ) . '</span>';
	}
	return $comments;
}

/**
 * Collects common post data
 *
 * @return array
 */
function anony_common_post_data( $post_type = 'post' ) {
	$anony_options = ANONY_Options_Model::get_instance();
	$grid         = $anony_options->posts_grid;

	$ID                      = get_the_ID();
	$temp['id']              = $ID;
	$temp['permalink']       = esc_url( get_the_permalink() );
	$temp['title']           = esc_html( get_the_title() );
	$temp['title_attr']      = the_title_attribute( array( 'echo' => false ) );
	$temp['content']         = apply_filters( 'the_content', get_the_content() );
	$temp['excerpt']         = esc_html( get_the_excerpt() );
	$temp['thumb']           = has_post_thumbnail();
	$temp['thumb_exists']    = ANONY_LINK_HELP::curlUrlExists( get_the_post_thumbnail_url( $ID ) );
	$temp['thumb_img_full']  = get_the_post_thumbnail( $ID, 'full' );
	$temp['thumb_img']       = get_the_post_thumbnail( $ID, 'category-post-thumb' );
	$temp['thumbnail_img']   = get_the_post_thumbnail_url( $ID, 'thumbnail' );
	$temp['date']            = get_the_date();
	$temp['gravatar']        = get_avatar( get_the_author_meta( 'ID' ), 32 );
	$temp['author']          = sprintf( esc_html__( 'By %s', ANONY_TEXTDOM ), get_the_author() );
	$temp['read_more']       = esc_html__( 'Read more', ANONY_TEXTDOM );
	$temp['grid']            = $grid;
	$temp['views']           = anony_get_post_views( $ID );
	$temp['comments_open']   = comments_open();
	$temp['comments_number'] = anony_comments_number();
	$temp['has_category']    = has_category();

	if ( $post_type == 'post' ) {
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

	return apply_filters( $post_type . '_loop_data', $temp, $ID );

}

/**
 * render posts pagination
 *
 * @return string Markup for pagination links.
 */
function anony_pagination() {
	$prev_text = is_rtl() ? 'right' : 'left';

	$next_text = is_rtl() ? 'left' : 'right';

	$pagination = get_the_posts_pagination(
		array(
			'type'               => 'list',
			'prev_text'          => '<i class="fa fa-arrow-' . $prev_text . '"></i>',
			'next_text'          => '<i class="fa fa-arrow-' . $next_text . '"></i>',
			'screen_reader_text' => ' ',

		)
	);

	return $pagination;
}
