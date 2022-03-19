<?php
/**
 * Theme functions
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
 
require_once wp_normalize_path( get_template_directory() . '/config/config.php' );

// Initial functions files.

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

	anony_load_defaults();
	
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

/**
 * WooCommerce.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'woocommerce.php' );

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