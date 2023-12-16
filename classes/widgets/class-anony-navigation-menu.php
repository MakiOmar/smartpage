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
		 * @since 1.0.0
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
			$title       = ( isset( $instance['title'] ) && ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Menu', 'smartpage' );
			$field_title = $this->get_field_id( 'title' );
			$field_name  = $this->get_field_name( 'title' );
			?>
			<p>
				<label for="<?php echo esc_attr( $field_title ); ?>"><?php esc_html_e( 'Title:', 'smartpage' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $field_title ); ?>" name="<?php echo esc_attr( $field_name ); ?>"  value="<?php echo esc_attr( $title ); ?>">
			</p>

			<?php
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

			$output .= '<ul id="anony-cat-list">';

			$output .= wp_list_categories(
				array(
					'hide_empty' => 0,
					'title_li'   => '',
					'order'      => 'DESC',
					'echo'       => false,
					'walker'     => new ANONY_Cats_Walk(),
				)
			);

			$output .= '</ul>';
			$output .= $parms['after_widget'];
			//phpcs:disable
			echo $output;
			//phpcs:enable.
		}
	}
}
