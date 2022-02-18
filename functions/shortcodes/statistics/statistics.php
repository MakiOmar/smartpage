<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
add_shortcode(
	'anony_statistics',
	function ( $atts ) {
		$counters = array();

		/**
	*
	 -----------------------------------------------
		 * Users
		 *-----------------------------------------------
	*/
		$users =
		array(
			'title' => esc_html__( 'Users' ),
			'count' => count_users()['total_users'],
			'icon'  => 'users',
			'id'    => 'anony-our-clients',
		);

		/**
	*
	 -----------------------------------------------
		 * posts
		 *-----------------------------------------------
	*/
		$posts =
		array(
			'title' => esc_html__( 'Posts' ),
			'count' => wp_count_posts( 'post', 'readable' )->publish,
			'icon'  => 'newspaper-o',
			'id'    => 'anony-posts',
		);
		/**
	*
	 -----------------------------------------------
		 * Online
		 *-----------------------------------------------
	*/

		if ( shortcode_exists( 'wpstatistics' ) ) {
			$number = do_shortcode( '[wpstatistics stat=usersonline]' );
		} else {
			$number = 0;
		}

		$online =
		array(
			'title' => esc_html__( 'Online now' ),
			'count' => $number,
			'icon'  => 'user',
			'id'    => 'anony-online-clients',
		);

		$counters[] = $users;
		$counters[] = $posts;
		$counters[] = $online;

		foreach ( $counters as $counter ) {
			extract( $counter );
			include 'statistics.view.php';
		}
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {

		if ( is_archive() ) {
			return;
		}

		global $post;

		$path = ANONY_LIBS_DIR . '/shortcodes/statistics/';
		$uri  = ANONY_LIBS_URI . '/shortcodes/statistics/';

		if ( ! ANONY_POST_HELP::isPageHasShortcode( $post, 'anony_statistics' ) ) {
			return;
		}

		wp_enqueue_style(
			'anony-statistics',
			$uri . 'statistics.css',
			fileatime( $path . 'statistics.css' )
		);

		wp_enqueue_script(
			'waypoints',
			$uri . 'jquery.waypoints.min.js',
			array( 'jquery' ),
			'4.0.1',
			true
		);

		wp_enqueue_script(
			'waypoints-counterup',
			$uri . 'jquery.counterup.js',
			array( 'waypoints' ),
			'1.0',
			true
		);
	}
);

add_action(
	'wp_footer',
	function () {

		if ( is_archive() ) {
			return;
		}

		global $post;

		if ( ! ANONY_POST_HELP::isPageHasShortcode( $post, 'anony_statistics' ) ) {
			return;
		}
		?>

	<script type="text/javascript">
		jQuery(document).ready(function($){
			"use strict";

			//waypoint plugin counter
			$('.counter').each(function(){
				if($(this).text() !== '0'){
					$(this).counterUp({
						delay: 30,
						time: 1000
					});
				}
			});

		});
	</script>

		<?php
	}
);



