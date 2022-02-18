<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
* Enables the HTTP Strict Transport Security (HSTS) header.
*
* @since 1.0.0
*/
add_action(
	'send_headers',
	function () {

		header( 'Strict-Transport-Security: max-age=10886400; includeSubDomains; env=HTTPS; preload' );
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-XSS-Protection: 1; mode=block' );
		header( 'Content-Security-Policy: default-src \'self\' \'unsafe-inline\' \'unsafe-eval\' https: data:' );
	}
);

// This instructs the browser to trust the cookie only by the server and that cookie is accessible over secure SSL channels.
@ini_set( 'session.cookie_httponly', true );
@ini_set( 'session.cookie_secure', true );
@ini_set( 'session.use_only_cookies', true );

// Disable WordPress login hints
add_filter(
	'login_errors',
	function () {
		return 'Try again';
	}
);

// By default, WordPress places a meta tag in your website’s code that states the version of WordPress you are using. This information is useful to hackers because it makes it easy to know which security holes they can abuse.
remove_action( 'wp_head', 'wp_generator' );

function wpb_disable_feed() {
	wp_die( __( 'No feed available!' ) );
}

add_action( 'do_feed', 'wpb_disable_feed', 1 );
add_action( 'do_feed_rdf', 'wpb_disable_feed', 1 );
add_action( 'do_feed_rss', 'wpb_disable_feed', 1 );
add_action( 'do_feed_rss2', 'wpb_disable_feed', 1 );
add_action( 'do_feed_atom', 'wpb_disable_feed', 1 );
add_action( 'do_feed_rss2_comments', 'wpb_disable_feed', 1 );
add_action( 'do_feed_atom_comments', 'wpb_disable_feed', 1 );

remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
