<?php
/**
 * Theme Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
require_once 'options/general.php';
require_once 'options/performance.php';
require_once 'options/slider.php';
require_once 'options/menu-colors.php';
require_once 'options/general-colors.php';
require_once 'options/header.php';
require_once 'options/footer.php';
require_once 'options/sidebars.php';
require_once 'options/blog.php';
require_once 'options/advertisements.php';
require_once 'options/ar-fonts.php';
require_once 'options/en-fonts.php';
require_once 'options/socials.php';
require_once 'options/miscellanous.php';
require_once 'options/post-types.php';
require_once 'options/orders.php';

/**
 * Multilingual options
 */
add_action(
	'after_setup_theme',
	function () {

		if ( ! ANONY_Wpml_Help::is_active() ) {
			return;
		}

		do_action( 'wpml_multilingual_options', ANONY_OPTIONS );
	},
	1
);

add_action(
	'init',
	function () {
		// Navigation elements.
		$options_nav = array(
			// General --------------------------------------------.
			'general'      => array(
				'title'    => esc_html__( 'Getting started', 'smartpage' ),
				'sections' => array( 'general', 'advertisements' ),
			),
			// Performance --------------------------------------------.
			'Performance'  => array(
				'title' => esc_html__( 'Performance', 'smartpage' ),
			),
			// Slider --------------------------------------------.
			'slider'       => array(
				'title' => esc_html__( 'Slider', 'smartpage' ),
			),
			// Layout --------------------------------------------.
			'layout'       => array(
				'title'    => esc_html__( 'Layout', 'smartpage' ),
				'sections' => array( 'header', 'footer', 'sidebars', 'blog' ),
			),

			// Colors --------------------------------------------.
			'colors'       => array(
				'title'    => esc_html__( 'Colors', 'smartpage' ),
				'sections' => array( 'general-colors', 'menu-colors' ),
			),

			// Fonts --------------------------------------------.
			'fonts'        => array(
				'title'    => esc_html__( 'Fonts', 'smartpage' ),
				'sections' => array( 'arabic-fonts', 'english-fonts' ),
			),
			// Socials --------------------------------------------.
			'socials'      => array(
				'title'    => esc_html__( 'Socials', 'smartpage' ),
				'sections' => array( 'socials' ),
			),

			// Miscellanous --------------------------------------------.
			'miscellanous' => array(
				'title' => esc_html__( 'Miscellanous', 'smartpage' ),
			),

			// Modules --------------------------------------------.
			'modules'      => array(
				'title'    => esc_html__( 'Modules', 'smartpage' ),
				'sections' => array( 'post-types' ),
			),

		);

		// Sectoins.
		$sections = array();

		$sections['general']        = json_decode( ANONY_GENERAL_OPTIONS, true );
		$sections['Performance']    = json_decode( ANONY_PERFORMANCE_OPTIONS, true );
		$sections['slider']         = json_decode( ANONY_SLIDER_OPTIONS, true );
		$sections['menu-colors']    = json_decode( ANONY_MENU_COLORS_OPTIONS, true );
		$sections['general-colors'] = json_decode( ANONY_GENERAL_COLORS_OPTIONS, true );
		$sections['header']         = json_decode( ANONY_HEADER_OPTIONS, true );
		$sections['sidebars']       = json_decode( ANONY_SIDEBARS_OPTIONS, true );
		$sections['footer']         = json_decode( ANONY_FOOTER_OPTIONS, true );
		$sections['blog']           = json_decode( ANONY_BLOG_OPTIONS, true );
		$sections['advertisements'] = json_decode( ANONY_ADS_OPTIONS, true );
		$sections['arabic-fonts']   = json_decode( ANONY_AR_FONTS_OPTIONS, true );
		$sections['english-fonts']  = json_decode( ANONY_EN_FONTS_OPTIONS, true );
		$sections['socials']        = json_decode( ANONY_SOCIALS_OPTIONS, true );
		$sections['miscellanous']   = json_decode( ANONY_MISCELLANOUS_OPTIONS, true );
		$sections['post-types']     = json_decode( ANONY_POST_TYPES_OPTIONS, true );
		if ( class_exists( 'woocommerce' ) ) {
			require_once 'options/woocommerce.php';
			require_once 'options/single-product.php';
			$sections['woocommerce']    = json_decode( ANONY_WOOCOMMERCE_OPTIONS, true );
			$sections['single-product'] = json_decode( ANONY_SINGLE_PRODUCT_OPTIONS, true );
			$sections['orders']         = json_decode( ANONY_ORDERS_OPTIONS, true );

			$options_nav['woocommerce'] = array(
				'title'    => esc_html__( 'woocommerce', 'smartpage' ),
				'sections' => array( 'woocommerce', 'single-product', 'orders' ),
			);
		}

		$widgets = array( 'ANONY_Sidebar_Ad' );

		$anony_options = new ANONY_Theme_Settings( $options_nav, $sections, $widgets );
	}
);
