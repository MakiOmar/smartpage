<?php
/**
 * Navigation menu widget
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

if ( ! class_exists( 'ANONY_Navigation_Menu' ) ) {
	/**
	 * Navigation menu widget class
	 *
	 * @package    Widgets
	 * @author     Makiomar <info@makior.com>
	 * @license    https://makiomar.com SmartPage Licence
	 * @link       https://makiomar.com
	 */
	class ANONY_Navigation_Menu extends WP_Widget {

		/**
		 * Class constructor
		 *
		 * @return void
		 */
		public function __construct() {
			$parms = array(
				'description' => esc_html__( 'Displays a navigation menu created with menu admin screen', 'smartpage' ),
				'name'        => esc_html__( 'Anonymous Navigation Menu', 'smartpage' ),
			);
			parent::__construct( 'ANONY_Navigation_Menu', '', $parms );
		}

		/**
		 * Outputs the settings update form.
		 *
		 * @param array $instance Current settings.
		 *
		 * @return void
		 */
		public function form( $instance ) {
		}

		/**
		 * Echoes the widget content.
		 *
		 * @param array $parms    Display arguments including 'before_title', 'after_title',
		 *                        'before_widget', and 'after_widget'.
		 * @param array $instance The settings for the particular instance of the widget.
		 *
		 * @return void
		 */
		public function widget( $parms, $instance ) {

			$title = empty( $instance['title'] ) ? esc_html__( 'Menu', 'smartpage' ) : $instance['title'];

			$output = $parms['before_widget'];

			$output .= $parms['before_title'] . $title . $parms['after_title'];

			$output .= wp_nav_menu(
				array(
					'depth'     => 0,
					'menu'      => 75,
					'container' => 'div',
					'echo'      => false,
				)
			);
			$output .= $parms['after_widget'];
			//phpcs:disable
			echo $output;
			//phpcs:enable.
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			/*
			$instance              = array();
			$instance['title']     = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
			$instance['post_type'] = ( ! empty( $new_instance['post_type'] ) ) ? sanitize_text_field( $new_instance['post_type'] ) : 'place';
			*/
			return $new_instance;
		}
	}
}
