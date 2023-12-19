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
);

foreach ( $shcods as $code ) {
	add_shortcode( $code, $code . '_shcode' );
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
	return '<div class="anony-grid-row'. $class .'">' . do_shortcode( $content ) . '</div>';
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
