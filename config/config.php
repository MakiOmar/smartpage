<?php
/**
 * Theme/Options confugurations
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
require_once 'required-plugins.php';
/**
 * ---------------------------------------------------------------
 * Define main constants
 * ---------------------------------------------------------------
 */
/**
 * Just no data text
 *
 * @const
 */
define( 'ANONY_NODATA', esc_html__( 'No data found' ) );

/**
 * Holds class/functions prefix
 *
 * @const
 */
define( 'ANONY_PREFIX', 'ANONY_' );

/**
 * Holds theme's version
 *
 * @const
 */
define( 'ANONY_THEME_VERSION', '1.0' );

/**
 * Holds theme's URI
 *
 * @const
 */
define( 'ANONY_THEME_URI', get_template_directory_uri() );

/**
 * Holds theme's path
 *
 * @const
 */
define( 'ANONY_THEME_DIR', wp_normalize_path( get_template_directory() ) );

/**
 * Holds functions folder URI
 *
 * @const
 */
define( 'ANONY_LIBS_URI', get_template_directory_uri() . '/functions' );


/**
 * Holds functions folder DIR
 *
 * @const
 */
define( 'ANONY_LIBS_DIR', wp_normalize_path( ANONY_THEME_DIR . '/functions/' ) );


/**
 * Holds core hooks folder URI
 *
 * @const
 */
define( 'ANONY_CORE_HOOKS_URI', get_template_directory_uri() . '/core-hooks' );

/**
 * Holds functions folder DIR
 *
 * @const
 */
define( 'ANONY_CORE_HOOKS_DIR', wp_normalize_path( ANONY_THEME_DIR . '/core-hooks/' ) );

/**
 * Holds main classes folder URI
 *
 * @const
 */
define( 'ANONY_CLASSES_URI', get_template_directory_uri() . '/functions/class' );

/**
 * Holds languages folder URI
 *
 * @const
 */
define( 'ANONY_LANG_DIR', wp_normalize_path( ANONY_THEME_DIR . '/languages/' ) );

/**
 * Holds rating table name
 *
 * @const
 */
define( 'ANONY_STAR_RATE', $GLOBALS['wpdb']->prefix . 'star_rating' );

/**
 * Holds blog's title
 *
 * @const
 */
define( 'ANONY_BLOG_TITLE', esc_html( get_bloginfo() ) );

/**
 * Holds blog's URL
 *
 * @const
 */
define( 'ANONY_BLOG_URL', esc_url( home_url() ) );

$anony_options = ANONY_Options_Model::get_instance();

/**
 * Header style
 *
 * @const
 */
define( 'ANONY_HEADER_STYLE', $anony_options->header_style );

/**
 * Mobile footer sticky menu style
 *
 * @const
 */
define( 'ANONY_FOOTER_STICKY_MENU_STYLE', $anony_options->mobile_footer_sticky_menu_style );

/**
 * ----------------------------------------------------------------------
 * Theme Autoloading
 * ---------------------------------------------------------------------
 */

/**
 * Holds a path to main classes folder
 *
 * @const
 */
define( 'ANONY_CLASSES', wp_normalize_path( ANONY_THEME_DIR . '/classes/' ) );

/**
 * Holds a path to widgets classes folder
 *
 * @const
 */
define( 'ANONY_WIDGETS', wp_normalize_path( ANONY_CLASSES . 'widgets/' ) );


/**
 * Holds a path to views classes folder
 *
 * @const
 */
define( 'ANONY_CONTENTS_VIEWS', wp_normalize_path( ANONY_CLASSES . '/views/' ) );


/**
 * Holds a path to elementor's extensions folder
 *
 * @const
 */
define( 'ANONY_ELEMENTOR_EXTENSION', wp_normalize_path( ANONY_THEME_DIR . '/elementor/' ) );


/**
 * Holds a path to elementor's documents folder
 *
 * @const
 */
define( 'ANONY_ELEMENTOR_DOCS', wp_normalize_path( ANONY_ELEMENTOR_EXTENSION . 'documents/' ) );

/**
 * Holds a json encoded array of all pathes to classes folders
 *
 * @const
 */
define(
	'ANONY_THEME_AUTOLOADS',
	wp_json_encode(
		array(
			ANONY_CLASSES,
			ANONY_WIDGETS,
			ANONY_CONTENTS_VIEWS,
			ANONY_ELEMENTOR_EXTENSION,
			ANONY_ELEMENTOR_DOCS,
		)
	)
);

/*
*Classes Auto loader
*/
spl_autoload_register(
	function ( $class_name ) {
		if ( strpos( $class_name, '\\' ) !== false ) {
			$parts      = explode( '\\', $class_name );
			$class_name = end( $parts );
		}
		if ( false !== strpos( $class_name, ANONY_PREFIX ) ) {
			$class_name = strtolower( preg_replace( '/' . ANONY_PREFIX . '/', '', $class_name ) );

			$class_name = str_replace( '_', '-', $class_name );
			foreach ( json_decode( ANONY_THEME_AUTOLOADS ) as $path ) {

				$class_file = wp_normalize_path( $path ) . $class_name . '.php';
				if ( file_exists( $class_file ) ) {
					include_once $class_file;
					return;
				}

				$class_file = wp_normalize_path( $path ) . 'class-anony-' . $class_name . '.php';
				if ( file_exists( $class_file ) ) {
					include_once $class_file;
					return;
				}

				$class_file = wp_normalize_path( $path ) . $class_name . '/' . $class_name . '.php';

				if ( file_exists( $class_file ) ) {
					include_once $class_file;
					return;
				}
			}
		}
	}
);
