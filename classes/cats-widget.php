<?php
/**
 * Categories menu walkker
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

if ( ! class_exists( 'ANONY_Cats_Widget' ) ) {

	/**
	 * Categories menu walkker class
	 *
	 * @package    Widgets
	 * @author     Makiomar <info@makior.com>
	 * @license    https://makiomar.com SmartPage Licence
	 * @link       https://makiomar.com
	 */
	class ANONY_Cats_Widget extends WP_Widget {

		/**
		 * Class constructor
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function __construct() {
			$parms = array(
				'description' => esc_html__( 'Displays an organized dropdown list of your categories', 'smartpage' ),
				'name'        => esc_html__( 'Anonymous categories', 'smartpage' ),
			);
			parent::__construct( 'ANONY_Cats_Widget', '', $parms );
		}

		/**
		 * Outputs the settings update form.
		 *
		 * @param array $instance Current settings.
		 *
		 * @return void
		 */
		public function form( $instance ) {
			$title       = ( isset( $instance['title'] ) && ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Categories', 'smartpage' );
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
		 *
		 * @param array $parms    Display arguments including 'before_title', 'after_title',
		 *                        'before_widget', and 'after_widget'.
		 * @param array $instance The settings for the particular instance of the widget.
		 *
		 *
		 * @return void
		 */
		public function widget( $parms, $instance ) {

			$title = empty( $instance['title'] ) ? __( 'Categories', 'smartpage' ) : $instance['title'];

			echo $parms['before_widget'];

			echo $parms['before_title'] . esc_html( $title ) . $parms['after_title'];

			echo '<ul id="anony-cat-list">';

			wp_list_categories(
				array(
					'hide_empty' => 0,
					'title_li'   => '',
					'order'      => 'DESC',
					'walker'     => new ANONY_Cats_Walk(),
				)
			);

			echo '</ul>';
			echo $parms['after_widget'] ;
			wp_enqueue_script( 'anony-cats-menu' );
		}
	}
}
