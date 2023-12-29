<?php
/**
 * Adding shortcodes
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Array of shortcodes to be added.
$shcods = array(
	'anony_ltrtext',
	'anony_products_loop',
	'anony_section_title',
	'anony_banner',
	'anony_row',
	'anony_column',
	'anony_shape_divider',
	'anony_posts_slider',
	'anony_images_slider',
	'anony_testimonials',
	'anony_faqs',
	'anony_terms_listing',
	'anony_post_listing',
	'anony_popup',
);

foreach ( $shcods as $code ) {
	add_shortcode( $code, $code . '_shcode' );
}

/**
 * Renders terms listings
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_post_listing_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'post_type'       => 'post',
			'ids'             => '',
			'number'          => 3,
			'desktop_columns' => 3,
			'mobile_columns'  => 1,
		),
		$atts,
		'anony_post_listing'
	);

	$args = array(
		'post_type'      => $atts['post_type'],
		'posts_per_page' => $atts['number'],
		'post_status'    => 'publish',
	);

	if ( ! empty( $atts['ids'] ) ) {
		$args['post__in'] = explode( ',', str_replace( ' ', '', $atts['ids'] ) );
	}
	$thumb_size      = wp_is_mobile() ? 'category-post-thumb-mobile' : 'category-post-thumb';
	$desktop_columns = 12 / absint( $atts['desktop_columns'] );
	$mobile_columns  = 12 / absint( $atts['mobile_columns'] );
	$output          = '';
	$query           = new WP_Query( $args );
	if ( $query->have_posts() ) {
		ob_start();
		require locate_template( 'templates/listings/post/post-listing-one.php', false, false );
		$output .= ob_get_clean();
	}
	return $output;
}

/**
 * Renders terms listings
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_terms_listing_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'taxonomy'          => 'category',
			'ids'               => '',
			'number'            => '',
			'desktop_columns'   => 4,
			'mobile_columns'    => 2,
			'image_id_meta_key' => 'thumbnail_id',
		),
		$atts,
		'anony_terms_listing'
	);

	$args = array(
		'taxonomy'   => $atts['taxonomy'],
		'number'     => $atts['number'],
		'fields'     => 'id=>name',
		'hide_empty' => false,
		'parent'     => 0,
	);

	if ( ! empty( $atts['ids'] ) ) {
		$args['include'] = str_replace( ' ', '', $atts['ids'] );
	}

	$desktop_columns = 12 / absint( $atts['desktop_columns'] );
	$mobile_columns  = 12 / absint( $atts['mobile_columns'] );

	$output = '';
	$terms  = get_terms( $args );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		ob_start();
		require locate_template( 'templates/listings/term/term-listing-one.php', false, false );
		$output .= ob_get_clean();
	}
	return $output;
}

/**
 * Renders testimonials
 *
 * @return string
 */
function anony_testimonials_shcode() {
	$output = '';
	ob_start();
	require locate_template( 'templates/testimonials.php', false, false );
	$output .= ob_get_clean();
	return $output;
}

/**
 * Renders popup
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_popup_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id'               => '',
			'callback'         => 'anony_mobile_menu',
			'width'            => '200px',
			'height'           => '100%',
			'border_width'     => '0',
			'border_style'     => 'solid',
			'border_color'     => '#000',
			'border_radius'    => '20px',
			'background_color' => '#fff',
			'zindex'           => '100',
		),
		$atts,
		'anony_popup'
	);

	if ( empty( $atts['id'] ) && current_user_can( 'manage_options' ) ) {
		return esc_html__( 'Popup id is missing', 'smartpage' );
	}
	$content = '';
	if ( ! empty( $atts['callback'] ) ) {
		$content = call_user_func( $atts['callback'] );
	}
	$id               = $atts['id'];
	$width            = $atts['width'];
	$height           = $atts['height'];
	$border_width     = $atts['border_width'];
	$border_style     = $atts['border_style'];
	$border_color     = $atts['border_color'];
	$border_radius    = $atts['border_radius'];
	$background_color = $atts['background_color'];
	$zindex           = $atts['zindex'];
	ob_start();
	require locate_template( 'templates/partials/popup.php', false, false );
	return ob_get_clean();
}

/**
 * Renders FAQs
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_faqs_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'ids'    => '',
			'number' => 3,
		),
		$atts,
		'anony_faqs'
	);

	$args = array(
		'post_type'      => 'anony_faqs',
		'posts_per_page' => $atts['number'],
		'post_status'    => 'publish',
	);

	if ( ! empty( $atts['ids'] ) ) {
		$args['post__in'] = explode( ',', str_replace( ' ', '', $atts['ids'] ) );
	}

	$query = new WP_Query( $args );

	$output = '';
	$data   = array();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			$temp['title']   = get_the_title();
			$temp['content'] = get_the_content();

			$data[] = $temp;
		}
		wp_reset_postdata();
	}

	if ( ! empty( $data ) ) {
		ob_start();
		require locate_template( 'templates/partials/accordion.php', false, false );
		$output .= ob_get_clean();
	}

	return $output;
}

/**
 * Renders Images slider
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_images_slider_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'ids' => '',
		),
		$atts,
		'anony_images_slider'
	);

	$slider_settings = array(

		'style'           => 'one',
		'show_pagination' => true,
		'pagination_type' => 'dots', // Accepts (thumbnails or dots).
		'slider_data'     => array(
			'transition' => 5000,
			'animation'  => 1500,
		),
	);

	$image_size = wp_is_mobile() ? 'medium' : 'woocommerce_single';

	// Get the comma-separated IDs and convert them into an array.
	$ids  = explode( ',', str_replace( ' ', '', $atts['ids'] ) );
	$data = array();
	if ( ! empty( $ids ) ) {
		foreach ( $ids as $key => $id ) {
			$temp['id']             = absint( $id );
			$temp['permalink_full'] = wp_get_original_image_url( absint( $id ) );
			$temp['permalink']      = wp_get_attachment_image_url( absint( $id ), $image_size );
			$data[]                 = $temp;
		}
	}

	if ( empty( $data ) ) {
		return '';
	}

	if ( $slider_settings['show_pagination'] ) {

		$slider_nav = array();

		foreach ( $data as $index => $p ) :

			$slider_nav_temp['permalink']     = $p['permalink'];
			$slider_nav_temp['id']            = $p['id'];
			$slider_nav_temp['class']         = 0 === $index ? 'anony-active-slide ' : '';
			$slider_nav_temp['thumbnail_img'] = get_the_post_thumbnail( $p['id'], 'full' );
			$slider_nav[]                     = $slider_nav_temp;

		endforeach;
	}

	$output = '';
	ob_start();
	require locate_template( 'templates/images-slider.php', false, false );
	$output .= ob_get_clean();
	wp_enqueue_script( 'anony-featured-slider' );
	return $output;
}
/**
 * Renders posts slider
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_posts_slider_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'slider_content' => '', // Accepts (featured-cat or featured-post).
			'featured_cat'   => '0',
			'taxonomy'       => 'category',
			'post_type'      => 'post',
		),
		$atts,
		'anony_posts_slider'
	);

	$anony_options   = ANONY_Options_Model::get_instance();
	$slider_settings = array(

		'style'           => 'one',
		'show_read_more'  => false,
		'show_pagination' => true,
		'pagination_type' => 'dots', // Accepts (thumbnails or dots).
		'slider_data'     => array(
			'transition' => 5000,
			'animation'  => 1500,
		),
	);

	$message = '';

	$args = array(
		'post_type'      => $atts['post_type'],
		'posts_per_page' => 5,
		'order'          => 'ASC',
		// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		'meta_query'     => array(
			array(
				'key'     => '_thumbnail_id',
				'compare' => 'EXISTS',
			),
		),
		// phpcs:enable.
	);

	if ( 'featured-cat' === $atts['slider_content'] && '0' !== $atts['featured_cat'] ) {

		$freatured_cat = get_term_by(
			'id',
			absint( $atts['featured_cat'] ),
			$atts['taxonomy']
		);

		if ( $freatured_cat ) {
			$args['cat'] = $freatured_cat->term_id;
		} else {
			$message = esc_html__( 'Please make sure you select a category and its corresponding taxonomy from theme options->slider', 'smartpage' );
		}
	} elseif ( 'featured-post' === $anony_options->slider_content ) {
		// phpcs:disable
		$args['meta_key'] = 'anony__set_as_featured';
		// phpcs:enable.
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

	if ( $slider_settings['show_pagination'] ) {

		$slider_nav = array();

		foreach ( $data as $index => $p ) :

			$slider_nav_temp['permalink']     = $p['permalink'];
			$slider_nav_temp['id']            = $p['id'];
			$slider_nav_temp['title']         = $p['title'];
			$slider_nav_temp['class']         = 0 === $index ? 'anony-active-slide ' : '';
			$slider_nav_temp['thumbnail_img'] = get_the_post_thumbnail( $p['id'], 'full' );

			$slider_nav[] = $slider_nav_temp;

		endforeach;
	}

	$title_link = isset( $args['cat'] ) ? get_category_link( $args['cat'] ) : '#';

	$title_text = isset( $args['cat'] ) ? get_cat_name( $args['cat'] ) : __( 'Featured Posts', 'smartpage' );

	$output = '';
	ob_start();
	require locate_template( 'templates/featured-' . $slider_settings['style'] . '-view.php', false, false );
	$output .= ob_get_clean();
	wp_enqueue_script( 'anony-featured-slider' );
	return $output;
}

/**
 * Shape divider
 *
 * @param  string $atts    the shortcode attributes.
 * @return string
 */
function anony_shape_divider_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'shape' => '',
		),
		$atts,
		'anony_shape_divider'
	);
	ob_start();
	?>
	<style>
		.website-divider-container-165642 {
			overflow: hidden;
			position: absolute;
			width: 100%;
			height: 250px;
			z-index: -1;
			bottom: 0;
			}

		.divider-img-165642 {
			position: absolute;
			width: 100%;
			height: 250px;
			transform: scale(1, 1);
			bottom:0px;
			left: 0px;
			fill: rgb(224 224 224);
		}
	</style>
	<div id="divider_id" class="website-divider-container-165642">

		<svg xmlns="http://www.w3.org/2000/svg" class="divider-img-165642" viewBox="0 0 1080 137" preserveAspectRatio="none">
		<path d="M 0,137 V 59.03716 c 158.97703,52.21241 257.17659,0.48065 375.35967,2.17167 118.18308,1.69101 168.54911,29.1665 243.12679,30.10771 C 693.06415,92.25775 855.93515,29.278599 1080,73.61449 V 137 Z" style="opacity:0.85"></path>
		<path d="M 0,10.174557 C 83.419822,8.405668 117.65911,41.78116 204.11379,44.65308 290.56846,47.52499 396.02558,-7.4328 620.04248,94.40134 782.19141,29.627636 825.67279,15.823104 1080,98.55518 V 137 H 0 Z" style="opacity:0.5"></path>
		<path d="M 0,45.10182 C 216.27861,-66.146913 327.90348,63.09813 416.42665,63.52904 504.94982,63.95995 530.42054,22.125806 615.37532,25.210412 700.33012,28.295019 790.77619,132.60682 1080,31.125744 V 137 H 0 Z" style="opacity:0.25"></path>
		</svg>   

	</div>
	<?php
	return ob_get_clean();
}

/**
 * Renders row
 *
 * @param  string $atts    the shortcode attributes.
 * @param  string $content the shortcode content.
 * @return string
 */
function anony_row_shcode( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'classes' => '',
		),
		$atts,
		'anony_column'
	);

	if ( '' !== $atts['classes'] ) {
		$class = ' ' . $atts['classes'];
	} else {
		$class = '';
	}
	return '<div class="anony-grid-row' . $class . '">' . do_shortcode( $content ) . '</div>';
}

/**
 * Renders column
 *
 * @param  string $atts    the shortcode attributes.
 * @param  string $content the shortcode content.
 * @return string
 */
function anony_column_shcode( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'classes' => '',
		),
		$atts,
		'anony_column'
	);

	if ( '' !== $atts['classes'] ) {
		$class = ' ' . $atts['classes'];
	} else {
		$class = '';
	}
	return '<div class="anony-grid-col' . $class . '">' . $content . '</div>';
}
/**
 * Renders a banner
 *
 * @param  string $atts    the shortcode attributes.
 * @param  string $content the shortcode content.
 * @return string the text that is to be used to replace the shortcode.
 */
function anony_ltrtext_shcode( $atts, $content = null ) {
	return '<span dir="ltr">' . $content . '</span>';
}

/**
 * Renders a banner
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_banner_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'style'          => 'default',
			'desktop-image'  => '/wp-content/uploads/2023/12/fit.webp',
			'desktop-height' => '450',
			'mobile-image'   => '/wp-content/uploads/2023/12/fit-mobile.webp',
			'mobile-height'  => '200',
		),
		$atts,
		'anony_banner'
	);

	if ( wp_is_mobile() ) {
		$banner_bg = $atts['mobile-image'];
		$height    = $atts['mobile-height'];
	} else {
		$banner_bg = $atts['desktop-image'];
		$height    = $atts['desktop-height'];
	}
	ob_start();
	?>
	<div class="anony-bg-banner" style="background-image: url(<?php echo esc_url( site_url( $banner_bg ) ); ?>);height:<?php echo esc_attr( $height ); ?>px">
	</div>
	<?php
	return ob_get_clean();
}
/**
 * Section title
 *
 * @param  string $atts    the shortcode attributes.
 * @return string Title markup.
 */
function anony_section_title_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'style' => 'default',
			'title' => __( 'Section title', 'samrtpage' ),
		),
		$atts,
		'anony_section_title'
	);
	switch ( $atts['style'] ) {
		case 'one':
			$output = anony_section_title( esc_html( $atts['title'] ) );
			break;
		default:
			$output = anony_section_title( esc_html( $atts['title'] ) );
			break;
	}

	return $output;
}

/**
 * Display products loop
 *
 * @param  string $atts    the shortcode attributes.
 * @return string Products loop output.
 */
function anony_products_loop_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'ids' => '',
		),
		$atts,
		'anony_products_loop'
	);
	// Get the comma-separated IDs and convert them into an array.
	$ids = explode( ',', str_replace( ' ', '', $atts['ids'] ) );
	ob_start();
	echo '<div class="woocommerce anony-flex-grow">';
	ANONY_Woo_Help::products_loop(
		array(
			'loop_args' => array(
				'include' => $ids,
			),
		),
	);
	echo '</div>';
	return ob_get_clean();
}
