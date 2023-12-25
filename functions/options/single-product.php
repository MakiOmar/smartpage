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
			),
		)
	)
);
