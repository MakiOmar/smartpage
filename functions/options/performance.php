<?php
/**
 * Performance Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_PERFORMANCE_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Performance', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'disable_rsponsive_css',
					'title'    => esc_html__( 'Disable responsive css', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'You may need to disable theme\'s responsive css if all your pages are built with elementor, Or you think this introduces more speed', 'smartpage' ),
				),
				array(
					'id'       => 'disable_main_css',
					'title'    => esc_html__( 'Disable Main css', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'You may need to disable theme\'s main css if you think this introduces more speed and will not affect design', 'smartpage' ),
				),
				array(
					'id'       => 'load_minified_styles',
					'title'    => esc_html__( 'Load minified styles', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Speeds up page load time.', 'smartpage' ),
				),

				array(
					'id'       => 'dynamic_css_ajax',
					'title'    => esc_html__( 'Disable dynamic AJAX css', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'If your website loads slowly because of AJAX css, enable this', 'smartpage' ),
				),

				array(
					'id'       => 'disable_prettyphoto',
					'title'    => esc_html__( 'Disable prettyPhoto image light box', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'prettyPhoto disable may help improve performance', 'smartpage' ),
				),

			),
		)
	)
);
