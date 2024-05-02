<?php
/**
 * Blog Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_BLOG_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Blog', 'smartpage' ),
			'icon'   => 'n',
			'fields' => array(
				array(
					'id'       => 'posts_grid',
					'title'    => esc_html__( 'Posts grid', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array(
						'standard' => esc_html__( 'Standard', 'smartpage' ),
						'masonry'  => esc_html__( 'Masonry', 'smartpage' ),
					),
					'default'  => 'masonry',

				),

			),
		)
	)
);
