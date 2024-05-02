<?php
/**
 * Miscellanous Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_MISCELLANOUS_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Miscellanous', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'admin_bar',
					'title'    => esc_html__( 'Hide admin bar', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Shows admin bar only for admins', 'smartpage' ),
				),
				array(
					'id'       => 'not_admin_restricted',
					'title'    => esc_html__( 'Restrict access to admin', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Restricts non-admins from accessing the dashboard', 'smartpage' ),
				),
				array(
					'id'       => 'change_login_title',
					'title'    => esc_html__( 'Change login header title', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Changes the default header title in WordPress login page to be your site title', 'smartpage' ),
				),
				array(
					'id'       => 'cats_in_nav',
					'title'    => esc_html__( 'Add categories to Navigation', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Adds categories menu to the main navigation menu (Show only if on mobile device)', 'smartpage' ),
				),

				array(
					'id'       => 'tinymce_comments',
					'title'    => esc_html__( 'Enable tinymce for comment form', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),

			),
		)
	)
);
