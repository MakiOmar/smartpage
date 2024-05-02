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
	'anony_divider',
	'anony_posts_slider',
	'anony_images_slider',
	'anony_content_slider',
	'anony_testimonials',
	'anony_faqs',
	'anony_terms_listing',
	'anony_post_listing',
	'anony_popup',
	'anony_navigation',
	'anony_price_tables',
	'anony_facy_list',
	'anony_get_block',
	'anony_spacer',
	'anony_timeline',
);

foreach ( $shcods as $code ) {
	add_shortcode( $code, $code . '_shcode' );
}

/**
 * Renders a timeline
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_timeline_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id'                    => '',
			'line-color'            => '#000',
			'bullets-in-view-color' => '#777',
			'background-color'      => '#f3f3f3',
		),
		$atts,
		'anony_timeline'
	);

	if ( empty( $atts['id'] ) ) {
		return;
	}

	$line_color           = $atts['line-color'];
	$bullets_inview_color = $atts['bullets-in-view-color'];
	$backgrond_color      = $atts['background-color'];
	$id                   = absint( $atts['id'] );
	ob_start();
	require locate_template( 'templates/partials/timeline.php', false, false );
	return ob_get_clean();
}

/**
 * Renders a spacer
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_spacer_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'height' => '50px',
		),
		$atts,
		'anony_spacer'
	);
	return '<div style="width:100%;height:' . esc_attr( $atts['height'] ) . '"></div>';
}

/**
 * Renders a block
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_get_block_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id' => '',
		),
		$atts,
		'anony_get_block'
	);
	if ( ! empty( $atts['id'] ) ) {
		$_post = get_post( absint( $atts['id'] ) );
		if ( $_post ) {
			return '<div class="anony_get_block">' . $_post->post_content . '</div>';
		}
	}
	return '';
}
/**
 * Renders a fancy list
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_facy_list_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'style'             => 'one',
			'target_class'      => 'wrapper',
			'item_width'        => '100%',
			'content_direction' => 'horizontal',
		),
		$atts,
		'anony_facy_list'
	);

	$content_direction = 'vertical' === $atts['content_direction'] ? 'column' : 'row';
	ob_start();
	?>
	<style>
		.___ ol {
			list-style: none;
			padding: 0;
		}
		.___ li {
			position: relative;
			display: flex;
			flex-direction: <?php echo esc_html( $content_direction ); ?>;
			align-items: center;
			gap: 1rem;
			background: aliceblue;
			padding: 1.5rem;
			border-radius: 1rem;
			width: calc(100% - 2rem);
			box-shadow: 0.25rem 0.25rem 0.75rem rgb(0 0 0 / 0.1);
		}
		.___ li::before {
			counter-increment: list-item;
			content: counter(list-item);
			font-size: 30px;
			font-weight: 700;
			width: 40px;
			height: 40px;
			background: #2b2059;
			flex: 0 0 auto;
			border-radius: 50%;
			color: white;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.___ li + li {
			margin-top: 1rem;
		}

		.___ li:nth-child(even) {
			flex-direction: row-reverse;
			background: lavender;
			margin-right: -2rem;
			margin-left: 2rem;
		}

		@media screen and (min-width:768px){
			.___ li {
				width: <?php echo esc_html( $atts['item_width'] ); ?>;
				display: inline-flex;
			}
			.___ li::before {
				font-size: 3rem;
				width: 2em;
				height: 2em;
			}
		}
		@media screen and (max-width:480px){
			.___ li {
				width: auto;
				display: inline-flex;
			}
			.___ li:nth-child(2n) {
				margin-right: -0.5rem;
				margin-left: 1rem;
			}
		}
	</style>
	<?php
	$styles = ob_get_clean();
	return str_replace( '___', $atts['target_class'], $styles );
}
/**
 * Renders price tables
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_price_tables_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'ids'    => '',
			'number' => 69,
		),
		$atts,
		'anony_price_tables'
	);

	$args = array(
		'post_type'      => 'anony_price_tables',
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
			$price_table_meta = get_post_meta( get_the_ID(), 'anony_price_table', true );
			if ( $price_table_meta && ! empty( $price_table_meta ) ) {
				$temp['title']          = get_the_title();
				$temp['content']        = get_the_content();
				$temp['icon']           = get_the_post_thumbnail( get_the_ID(), 'full' );
				$temp['price']          = $price_table_meta['price'];
				$temp['title_bg_color'] = $price_table_meta['title_bg_color'];
				$temp['price_per']      = $price_table_meta['price_per'];
				$temp['subtitle']       = $price_table_meta['subtitle'];
				$temp['button_link']    = $price_table_meta['button_link'];
				$temp['button_text']    = $price_table_meta['button_text'];

				$data[] = $temp;
			}
		}
		wp_reset_postdata();
	}

	if ( ! empty( $data ) ) {
		ob_start();
		require locate_template( 'templates/partials/price-table.php', false, false );
		$output .= ob_get_clean();
	}

	return $output;
}

/**
 * Renders divider
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_divider_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'style'        => 'default',
			'thickness'    => '1px',
			'width'        => '100%',
			'color'        => '#000000',
			'border-style' => 'solid',
			'height'       => '20px',
			'align'        => 'center',
			'justify'      => 'flex-start',
		),
		$atts,
		'anony_divider'
	);

	return sprintf(
		'<div style="height:%2$s;display:flex;align-items:%6$s;justify-content:%7$s">
		<span style="display:block; border-bottom:%3$s %4$s %5$s;width:%1$s;"></span>
		</div>',
		$atts['width'],
		$atts['height'],
		$atts['thickness'],
		$atts['border-style'],
		$atts['color'],
		$atts['align'],
		$atts['justify']
	);
}

/**
 * Renders navigation menu by title
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_navigation_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'menu' => '',
		),
		$atts,
		'anony_navigation'
	);

	if ( empty( $atts['menu'] ) ) {
		return;
	}
	$direction = is_rtl() ? 'to-left' : 'to-right';
	$menu_args = array(
		'menu'            => $atts['menu'],
		'container'       => 'nav',
		'container_class' => 'menu-container',
		'menu_class'      => "woocommerce-MyAccount-navigation menu anony-menu anony-divided-menu anony-vertical-menu {$direction}",
		'echo'            => false,
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	);
	return wp_nav_menu( $menu_args );
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
			'name_align'        => 'center',
			'desktop_font_size' => '18px',
			'mobile_font_size'  => '14px',
		),
		$atts,
		'anony_terms_listing'
	);

	$args = array(
		'taxonomy'   => $atts['taxonomy'],
		'number'     => $atts['number'],
		'fields'     => 'id=>name',
		'hide_empty' => false,
	);

	if ( isset( $atts['parent'] ) ) {
		$args['parent'] = absint( $atts['parent'] );
	}

	if ( ! empty( $atts['ids'] ) ) {
		$args['include'] = str_replace( ' ', '', $atts['ids'] );
	}

	$desktop_columns = 12 / absint( $atts['desktop_columns'] );
	$mobile_columns  = 12 / absint( $atts['mobile_columns'] );
	$name_align      = $atts['name_align'];
	$font_size       = wp_is_mobile() ? $atts['mobile_font_size'] : $atts['desktop_font_size'];

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
			'callback'         => '',
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
			'cat'    => false,
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

	if ( $atts['cat'] && ! empty( $atts['cat'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'anony_faqs_cats',
				'field'    => 'id',
				'terms'    => explode( ',', str_replace( ' ', '', $atts['cat'] ) ),
			),
		);
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
 * Renders content slider
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_content_slider_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'ids'    => '',
			'number' => 3,
			'cat'    => false,
			'height' => 'auto',
		),
		$atts,
		'anony_content_slider'
	);

	$args = array(
		'post_type'      => 'anony_blocks',
		'posts_per_page' => $atts['number'],
		'post_status'    => 'publish',
	);

	if ( ! empty( $atts['ids'] ) ) {
		$args['post__in'] = explode( ',', str_replace( ' ', '', $atts['ids'] ) );
	}

	if ( $atts['cat'] && ! empty( $atts['cat'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'anony_blocks_cats',
				'field'    => 'id',
				'terms'    => explode( ',', str_replace( ' ', '', $atts['cat'] ) ),
			),
		);
	}
	$height       = $atts['height'];
	$container_id = 'content-slider-' . time();
	$query        = new WP_Query( $args );
	$output       = '';
	$data         = array();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$temp['content'] = get_the_content();

			$data[] = $temp;
		}
		wp_reset_postdata();
	}
	if ( ! empty( $data ) ) {
		ob_start();
		require locate_template( 'templates/partials/content-slider.php', false, false );
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
			'ids'        => '',
			'transition' => '5000',
			'animation'  => '1500',
		),
		$atts,
		'anony_images_slider'
	);

	$slider_settings = array(

		'style'           => 'one',
		'show_pagination' => true,
		'pagination_type' => 'dots', // Accepts (thumbnails or dots).
		'slider_data'     => array(
			'transition' => $atts['transition'],
			'animation'  => $atts['animation'],
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
			'desktop-image'  => '',
			'desktop-height' => '450',
			'mobile-image'   => '',
			'mobile-height'  => '200',
		),
		$atts,
		'anony_banner'
	);

	if ( empty( $atts['desktop-image'] ) ) {
		return anony_admin_hint( 'Please add the desctop image url' );
	}
	// Defaults to desktop image.
	if ( empty( $atts['mobile-image'] ) ) {
		$atts['mobile-image'] = $atts['desktop-image'];
	}

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
	return anony_section_title( $atts['title'], $atts['style'] );
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
			'ids'                => '',
			'author'             => '',
			'slider'             => 'off',
			'height'             => '500px',
			'width'              => '100vw',
			'item-width-desktop' => '320px',
			'item-width-mobile'  => '150px',
		),
		$atts,
		'anony_products_loop'
	);
	// Get the comma-separated IDs and convert them into an array.
	$ids = ! empty( $atts['ids'] ) ? explode( ',', str_replace( ' ', '', $atts['ids'] ) ) : '';

	$products_loop_args = array();
	if ( ! empty( $ids ) ) {
		$products_loop_args['include'] = $ids;
	}

	if ( ! empty( $atts['author'] ) ) {
		$products_loop_args['post_author'] = absint( $atts['author'] );
	}

	if ( 'on' === $atts['slider'] ) {
		$slider_class = ' anony-woocommerce-loop-slider';
	} else {
		$slider_class = '';
	}
	$container_id = uniqid( 'anony-products-loop-' );

	if ( wp_is_mobile() ) {
		$item_width = $atts['item-width-mobile'];
	} else {
		$item_width = $atts['item-width-desktop'];
	}
	ob_start();
	if ( 'on' === $atts['slider'] ) {
		?>
		<style>
			.anony-woocommerce-loop-slider.anony-woocommerce-loop{
				position:relative;
				max-width: <?php echo esc_html( $atts['width'] ); ?>;
				overflow:hidden;
				/*height:<?php echo esc_html( $atts['height'] ); ?>;*/
				margin:auto;
			}
			.anony-woocommerce-loop-slider.anony-woocommerce-loop ul.products  li{
				width:<?php echo esc_html( $item_width ); ?>!important;
				display:inline-block;
				vertical-align: top;
				float: none !important;
				clear: none !important;
			}
			.anony-woocommerce-loop-slider.anony-woocommerce-loop ul.products{
				position:relative;
				display:block;
				width:9999999px;
				transition: transform 2s ease-in-out;
				-webkit-transition: transform 2s ease-in-out;
				-moz-transition: transform 2s ease-in-out;
				-ms-transition: transform 2s ease-in-out;
				-o-transition: transform 2s ease-in-out;
			}
			
			/* -------------*/
			.anony-woocommerce-loop-slider .anony-slider-control{
				margin: auto;
				text-align: center;
				position: relative;
				bottom: auto;
			}
			body.rtl .anony-woocommerce-loop-slider .anony-slider-control{
				display: flex;
				justify-content: center;
				align-items: center;
				flex-direction: row-reverse;
			}
			.anony-woocommerce-loop-slider .anony-slider-nav .top, .anony-slider-nav .bottom {
				display: block;
				width: 10px;
				height: 1px;
				height: 1px;
				background-color: #fff;
			}
		
			.anony-woocommerce-loop-slider .anony-greater-than .top {
				transform: rotate(45deg);
				top: 8px;
				position: relative;
			}
		
			.anony-woocommerce-loop-slider .anony-greater-than .bottom {
				transform: rotate(-45deg);
			}
		
			.anony-woocommerce-loop-slider .anony-smaller-than .top {
				transform: rotate(-45deg);
				top: 8px;
				position: relative;
			}
		
			.anony-woocommerce-loop-slider .anony-smaller-than .bottom {
				transform: rotate(45deg);
			}
			.anony-woocommerce-loop-slider .anony-slider-control button{
				height: 35px;
				width: 35px;
				margin: 0 3px;
				background-color: rgb(0,0,0,0.5);
				color: #fff;
				outline: none;
				border-radius: 50%;
				border: none;
				cursor: pointer;
			}
			.anony-woocommerce-loop-slider .anony-slider-control button:hover{
				background-color: rgb(0,0,0,1);
			}
			.anony-woocommerce-loop-slider .anony-slider-nav{
				position: relative;
				top: -3px;
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
			}
			@media screen and (max-width:480px) {
				.anony-woocommerce-loop-slider .anony-slider div{
					max-width: calc(100vw - 40px);
				}
				.anony-woocommerce-loop-slider .anony-slide .wp-block-columns{
					flex-direction: column;
				}
			}
		</style>

		<?php
	}
	echo '<div id="' . esc_html( $container_id ) . '" class="woocommerce anony-woocommerce-loop anony-flex-grow' . esc_html( $slider_class ) . '">';

	ANONY_Woo_Help::products_loop(
		array(
			'loop_args' => $products_loop_args,
			'slider'    => $atts['slider'],
			'id'        => $container_id,
		)
	);

	if ( 'on' === $atts['slider'] ) {
		?>
		<div class="anony-slider-control" data-slider="<?php echo esc_html( $container_id ); ?>">
			<button class="anony-slider-prev">
				<span class="anony-greater-than anony-slider-nav">
					<span class="top"></span><span class="bottom"></span>
				</span>
			</button>
			<button class="anony-slider-next">
				<span class="anony-smaller-than anony-slider-nav">
					<span class="top"></span><span class="bottom"></span>
				</span>
			</button>
		</div>
		<?php
	}
	echo '</div>';

	if ( 'on' === $atts['slider'] ) {

		add_action(
			'wp_footer',
			function () use( $container_id ) {
				?>
		<script>
		jQuery(document).ready(function($) {
			var containerID = '<?php echo esc_html( $container_id ); ?>';

			var slideWidth = $('ul.products li', $( '#' + containerID )).outerWidth();
			
			var slider     = $('ul.products', $( '#' + containerID ));
			// Clone the first and last slide.
			var firstSlide = $('ul.products li:first-child', $( '#' + containerID )).clone();
			var lastSlide = $('ul.products li:last-child', $( '#' + containerID )).clone();
		
			// Append cloned slides to the slider.
			slider.append(firstSlide);
			slider.prepend(lastSlide);
			
			var margins = 0
			$('li.product', $( '#' + containerID )).each( function() {
				margins = margins + parseFloat( $(this).css("marginRight").replace('px', '' ) );
			} );
			var itemsLength = $('ul.products li', $( '#' + containerID )).length;
			// Adjust the slider width.
			var sliderWidth = slideWidth * itemsLength + ( 10 * itemsLength ) + margins ;
		
			slider.width( sliderWidth );
			// Set initial position.
				<?php if ( ! is_rtl() ) { ?>
			var initialPosition = -slideWidth;
			<?php } else { ?>
				var initialPosition = slideWidth;
			<?php } ?>
			if ( 3 > $('ul.products li', $( '#' + containerID )).length ) {
				
			}
			slider.css('transform', 'translateX(' + initialPosition + 'px)');
			
			// Slide to the next slide.
			$( '#' + containerID ).on('click','.anony-slider-next', function() {
		
		
				$( '#' + containerID ).find( 'ul.products' ).animate(
				{ 'margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>': '-=' + slideWidth },
				300,
				function() {
					slider.css('margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>', 0);
					slider.append($('ul.products li:first-child', $( '#' + containerID )));
				}
				);
			});
		
			// Slide to the previous slide.
			$( '#' + containerID ).on('click','.anony-slider-prev', function() {
		
				$( '#' + containerID ).find( 'ul.products' ).animate(
				{ 'margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>': '+=' + slideWidth },
				300,
				function() {
					slider.css('margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>', 0);
					slider.prepend($('ul.products li:last-child', $( '#' + containerID )));
				}
				);
			});
		
			
		});
		</script>
				<?php
			}
		);
	}
	return ob_get_clean();
}