<?php
/**
 * Theme functions
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com/smartpage
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

require_once wp_normalize_path( get_template_directory() . '/config/config.php' );

// Initial functions files.

/**
 * Theme update checker.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'updates.php' );

/**
 * Theme Scripts.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'scripts.php' );

/**
 * Theme helper functions.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'theme-helpers.php' );

/**
 * Theme menus.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'menus.php' );


if ( ! defined( 'ANOENGINE' ) ) {
	// Load defaults.
	add_filter( 'template_include', 'anony_load_defaults' );
	return;
}

// Main functions files.

/**
 * Theme features.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'theme.php' );

/**
 * Theme options.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'theme-options.php' );

/**
 * Data injection.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'data-hooks.php' );

/**
 * Posts registrations.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'posts.php' );

if ( class_exists( 'woocommerce' ) ) {
	/**
	 * WooCommerce.
	 */
	require_once wp_normalize_path( ANONY_LIBS_DIR . 'woocommerce.php' );
	require_once wp_normalize_path( ANONY_LIBS_DIR . 'ajax-add-to-cart.php' );
}


/**
 * Performance.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'performance.php' );

/**
 * Admin area.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'admin.php' );

/**
 * Media handing.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'media.php' );

/**
 * Widgets registration.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'widgets.php' );

/**
 * Custom fields.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'custom-fields.php' );


/**
 * Comments AJAX.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'ajax/ajax-comments.php' );

/**
 * Download AJAX.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'ajax/ajax-download.php' );

/**
 * Rating AJAX.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'ajax/ajax-rate.php' );

/**
 * TinyMCE buttons.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'mce/tinymce-editor-btns.php' );


/**
 * Custom shortcodes.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'shortcodes/statistics/statistics.php' );

/**
 * Visual composer includes
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'vc-includes.php' );
require_once wp_normalize_path( ANONY_LIBS_DIR . 'vc-shortcode-types/switch.php' );


/**
 * Elementor includes
 */
require_once wp_normalize_path( ANONY_ELEMENTOR_EXTENSION . 'elementor-incl.php' );


require ANONY_THEME_DIR . '/plugin-update-checker/plugin-update-checker.php';

Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/MakiOmar/smartpage/master/plugin-update-checker/examples/theme.json',
	__FILE__, // Full path to the main plugin file or functions.php.
	'anony-smartpage'
);

add_action(
	'wp_footer',
	function () {
		$anony_options = ANONY_Options_Model::get_instance();
		if ( class_exists( 'ANONY_Wpml_Help' ) ) {
			echo '<input type="hidden" id="anony_ajax_url" value="' . esc_url( ANONY_Wpml_Help::get_ajax_url() ) . '" />';
		}

		if ( '1' === $anony_options->compress_html ) {
			ob_end_flush();
		}
	}
);
