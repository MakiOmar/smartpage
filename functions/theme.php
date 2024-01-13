<?php
/**
 * Theme Functions
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Filter body classes
 *
 * @param array $classes Body classes.
 * @return array
 */
function anony_body_classes( $classes ) {
	global $post;
	if ( wp_is_mobile() ) {
		$classes[] = 'anony-is-mobile';
	}
	return $classes;
}
add_filter( 'body_class', 'anony_body_classes' );

if ( ! function_exists( 'anony_elementor_custom_fonts_group' ) ) {
	/**
	 * Add to fonts group
	 *
	 * @param array $font_groups Fonts group.
	 * @return array
	 */
	function anony_elementor_custom_fonts_group( $font_groups ) {
		$font_groups['smartpage'] = esc_html__( 'SmartPage', 'smartpage' );
		return $font_groups;
	}
}
add_filter( 'elementor/fonts/groups', 'anony_elementor_custom_fonts_group', 99 );

if ( ! function_exists( 'anon_allow_custom_mime_types' ) ) {
	/**
	 * Allow fonts mime types to be uploaded
	 *
	 * @param array $mimes Mime types.
	 * @return array
	 */
	function anon_allow_custom_mime_types( $mimes ) {

		$mimes['woff']  = 'application/x-font-woff';
		$mimes['woff2'] = 'application/x-font-woff2';
		$mimes['ttf']   = 'application/x-font-ttf';
		$mimes['svg']   = 'image/svg+xml';
		$mimes['eot']   = 'application/vnd.ms-fontobject';
		$mimes['otf']   = 'font/otf';

		return $mimes;
	}
}

add_filter( 'upload_mimes', 'anon_allow_custom_mime_types' );

if ( ! function_exists( 'anony_hide_admin_bar' ) ) {
	/**
	 * Hide admin bar
	 */
	function anony_hide_admin_bar() {
		$anony_options = ANONY_Options_Model::get_instance();

		if ( $anony_options->admin_bar != '0' && ! current_user_can( 'administrator' ) && ! is_admin() ) {

			show_admin_bar( false );

		}
	}
}

if ( ! function_exists( 'anony_display_ads' ) ) {

	/**
	 * Display theme options' ADs
	 *
	 * Show ads hooked to custom hook.
	 *
	 * Hook name will be {location}_ad.<br>
	 * do_action('{location}_ad') should be existed in the desired location [header, footer, sidebar, post, page]
	 */
	function anony_display_ads() {
		$anony_options = ANONY_Options_Model::get_instance();

		$anonyADs = array( 'one', 'two', 'three' );

		foreach ( $anonyADs as $adBlock ) {

			$block    = 'ad_block_' . $adBlock;
			$blockLoc = $block . '_location';

			if ( isset( $anony_options->$blockLoc ) && ! empty( $anony_options->$blockLoc ) ) {

				foreach ( $anony_options->$blockLoc as $loc ) {

					add_action(
						$loc . '_ad',
						function () use ( $anony_options, $block ) {
							echo $anony_options->$block;
						}
					);

				}
			}
		}
	}
}

if ( ! function_exists( 'anony_restrict_admin_access' ) ) {

	/**
	 * Restrict admin access for non admins
	 */
	function anony_restrict_admin_access() {
		// restrict admin access.
		if ( ! is_user_logged_in() ) {
			return;
		}

		$anony_options = ANONY_Options_Model::get_instance();

		if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) && $anony_options->not_admin_restricted != '0' ) {

			wp_redirect( home_url() );

			exit;

		}
	}
}

if ( ! function_exists( 'anony_add_theme_support' ) ) {
	/**
	 * Add theme support
	 */
	function anony_add_theme_support() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'post-thumbnails', array( 'post', 'anony_download' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'post-formats', array( 'gallery', 'quote', 'video', 'aside', 'image', 'link' ) );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	}
}

/**
 * Add image sizes
 */
function anony_thumbs_sizes() {
	add_image_size( 'category-post-thumb', 495 ); // 300 pixels wide (and unlimited height).
	add_image_size( 'category-post-thumb-mobile', 350, 200 ); // 350*200 pixels wide* height and crop.
	add_image_size( 'popular-post-thumb', 60, 60, true ); // 60*60 pixels and crop.
	add_image_size( 'download-thumb', 195, 250, true ); // 195*250 pixels and crop.
	if ( class_exists( 'WooCommerce' ) ) {
		add_image_size( 'mini-cart', 80, 80, true ); // 80*80 pixels and crop.
		add_image_size( 'product-loop-desktop', 450 ); // 450*250 pixels and crop.
		add_image_size( 'product-loop-mobile', 200 ); // 200*150 pixels and crop.
	}
}

/**
 * Hook to mobile header first column
 *
 * @return void
 */
function anony_mobile_header_first_cb() {
	?>
	<a class="anony-mobile-menu-button anony-inline-flex anony-popup-toggle" href="#" data-target="anony-mobile-menu" title="Menu"><svg width="30px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" viewBox="0 0 455 455" style="enable-background:new 0 0 455 455;" xml:space="preserve"><g> <rect y="312.5" width="455" height="30"></rect> <rect y="212.5" width="455" height="30"></rect> <rect y="112.5" width="455" height="30"></rect></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></a>
	<?php
	echo do_shortcode( '[anony_popup id="anony-mobile-menu" callback="anony_mobile_menu"]' );
}
add_action( 'anony_mobile_header_first', 'anony_mobile_header_first_cb', 10 );

/**
 * Hook to mobile header second column
 *
 * @return void
 */
function anony_mobile_header_second_cb() {
	// phpcs:disable
	echo anony_get_theme_logo();
	// phpcs:enable.
}
add_action( 'anony_mobile_header_second', 'anony_mobile_header_second_cb', 10 );

/**
 * Hook to mobile header third column
 *
 * @return void
 */
function anony_mobile_header_third_cb() {
	require locate_template( 'templates/partials/fullwidth-search-form-view.php', false, false );
	if ( class_exists( 'WooCommerce' ) ) {
		require locate_template( 'templates/partials/mini-cart.php', false, false );
	}
}
add_action( 'anony_mobile_header_third', 'anony_mobile_header_third_cb', 10 );

add_action(
	'after_setup_theme',
	function () {

		// Add theme support.
		anony_add_theme_support();

		// set post thumbnail sizes.
		anony_thumbs_sizes();

		// Load Text Domain.
		load_theme_textdomain( 'smartpage', ANONY_LANG_DIR );

		// hide admin bar for non admins.
		anony_hide_admin_bar();
	},
	20
);

// Remove width|height from img.
add_filter(
	'post_thumbnail_html',
	function ( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
		$html = preg_replace( '/(width|height)=\"\d*\"\s/', '', $html );
		return $html;
	},
	10,
	5
);

add_action(
	'init',
	function () {

		anony_restrict_admin_access();

		anony_display_ads();
	},
	200
);

// favicon.
add_action(
	'wp_head',
	function () {
		$site_icon = get_option( 'site_icon' );

		if ( $site_icon && $site_icon != '0' ) {
			return;
		}
		?>
	<!-- Custom Favicons -->
	<link rel="shortcut icon" href="<?php echo ANONY_THEME_URI; ?>/images/favicon.ico"/>
	<link rel="icon" href="<?php echo ANONY_THEME_URI; ?>/images/favicon.ico" />
	<link rel="apple-touch-icon" href="<?php echo ANONY_THEME_URI; ?>/images/favicon.ico">
		<?php
	}
);
