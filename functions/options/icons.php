<?php
/**
 * Icons Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_ICONS_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Icons', 'smartpage' ),
			'icon'   => 'n',
			'fields' => array(
				array(
					'id'       => 'testimonials_icon',
					'title'    => esc_html__( 'Testimonials', 'smartpage' ),
					'type'     => 'textarea',
					'validate' => 'html',
				),

			),
		)
	)
);
