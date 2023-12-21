<?php
/**
 * Socials Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define(
	'ANONY_SOCIALS_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Social Media', 'smartpage' ),
			'icon'   => 'B',
			'fields' => array(
				array(
					'id'       => 'facebook',
					'title'    => esc_html__( 'Facebook account link', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'twitter',
					'title'    => esc_html__( 'Twitter account link', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'linkedin',
					'title'    => esc_html__( 'Linkedin account link', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'instagram',
					'title'    => esc_html__( 'Instagram account link', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'tumblr',
					'title'    => esc_html__( 'Tumbler account link', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'youtube',
					'title'    => esc_html__( 'Youtube channel', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'rss',
					'title'    => esc_html__( 'RSS feed', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => get_bloginfo( 'rss_url' ),
				),
				array(
					'id'       => 'email',
					'title'    => esc_html__( 'Email address', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'email',
					'default'  => get_bloginfo( 'admin_email' ),
				),
				array(
					'id'       => 'phone',
					'title'    => esc_html__( 'Phone number', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'no_html',
					'default'  => '#',
				),

			),
		)
	)
);
