<?php
/**
 * Single product Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_SINGLE_PRODUCT_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Single product', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'disable_comment_form_email_field',
					'title'    => esc_html__( 'Disable comment\'s form\'s email\'s field', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),

				array(
					'id'       => 'disable_woo_comment_avatar',
					'title'    => esc_html__( 'Disable woo comment avatar', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),

				array(
					'id'       => 'enable_woo_comments_load_more',
					'title'    => esc_html__( 'Enable woo comments load more', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Replace pagination with a load more button', 'smartpage' ),
				),
				array(
					'id'       => 'ajax_load_more_comment',
					'title'    => esc_html__( 'ajax comments', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Load comments with ajax', 'smartpage' ),
				),

				array(
					'id'       => 'enable_direct_checkout',
					'title'    => esc_html__( 'Enable direct checkout', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Adds a direct checkout button to single product.', 'smartpage' ),
				),
				array(
					'id'       => 'reply_avatar',
					'title'    => esc_html__( 'Replay avatar', 'smartpage' ),
					'type'     => 'textarea',
					'validate' => 'no_html',
				),
				array(
					'id'       => 'slider_dots',
					'title'    => esc_html__( 'Slider Dots', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Use dots instead of thumbnails of gallery slider', 'smartpage' ),
				),
			),
		)
	)
);
