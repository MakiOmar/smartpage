<?php
/**
 * General colors Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_GENERAL_COLORS_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'General', 'smartpage' ),
			'icon'   => 'E',
			'fields' => array(
				array(
					'id'       => 'primary_skin_color',
					'title'    => esc_html__( 'Primary color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#230005',
				),

				array(
					'id'       => 'secondary_skin_color',
					'title'    => esc_html__( 'secondary color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#e2e2e2',
				),
			),
		)
	)
);
