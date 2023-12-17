<?php
/**
 * Theme widgets
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Register Sidebars.
add_action(
	'widgets_init',
	function () {

		$sidebars =
		array(
			'main-sidebar'           => esc_html__( 'Main Sidebar', 'smartpage' ),
			'right-sidebar'          => esc_html__( 'Right Sidebar', 'smartpage' ),
			'left-sidebar'           => esc_html__( 'Left Sidebar', 'smartpage' ),
			'secondary-sidebar'      => esc_html__( 'Secondary Sidebar', 'smartpage' ),
			'footer-widget-1'        => esc_html__( 'Footer one', 'smartpage' ),
			'footer-widget-2'        => esc_html__( 'Footer two', 'smartpage' ),
			'footer-widget-3'        => esc_html__( 'Footer three', 'smartpage' ),
			'footer-widget-4'        => esc_html__( 'Footer four', 'smartpage' ),
			'top-footer-widget-1'    => esc_html__( 'Top footer one', 'smartpage' ),
			'top-footer-widget-2'    => esc_html__( 'Top footer two', 'smartpage' ),
			'top-footer-widget-3'    => esc_html__( 'Top footer three', 'smartpage' ),
			'bottom-footer-widget-1' => esc_html__( 'Bottom footer one', 'smartpage' ),
			'bottom-footer-widget-2' => esc_html__( 'Bottom footer two', 'smartpage' ),
			'bottom-footer-widget-3' => esc_html__( 'Bottom footer three', 'smartpage' ),
		);
		foreach ( $sidebars as $sidebar_id => $sidebar ) {
			$args = array(
				'name'          => $sidebar,
				'id'            => $sidebar_id,
				'class'         => $sidebar_id,
				'before_widget' => strpos( $sidebar_id, 'footer' ) !== false ? '<div class="footer-widget anony-grid-col">' : '<div class="white-bg widgeted anony-grid-col">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgeted_title">',
				'after_title'   => '</h3>',
			);
			register_sidebar( $args );
		}
	}
);
if ( ! function_exists( 'anony_dynamic_sidebar_params' ) ) {
	/**
	 * Filtr through dynamic sidebar params
	 *
	 * @param $param $param Sidebar parameters.
	 * @return array
	 */
	function anony_dynamic_sidebar_params( $param ) {
		if ( ! is_rtl() && 'right-sidebar' === $param[0]['id'] ) {

			$param[0]['name'] = esc_html__( 'Left Sidebar', 'smartpage' );

		}

		if ( ! is_rtl() && 'left-sidebar' === $param[0]['id'] ) {

			$param[0]['name'] = esc_html__( 'Right Sidebar', 'smartpage' );

		}
		return $param;
	}
}

add_filter( 'dynamic_sidebar_params', 'anony_dynamic_sidebar_params', 20 );



/**
 * Register categories widget
 */
add_action(
	'widgets_init',
	function () {

		$reg_widgets = array(
			'ANONY_Cats_Widget',
			'ANONY_Related_Posts_Widget',
			'ANONY_Posts_Widget',
		);

		foreach ( $reg_widgets as $reg_widget ) {
			register_widget( $reg_widget );
		}
	}
);
