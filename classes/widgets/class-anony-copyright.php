<?php
/**
 * Copyright widget
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

if ( ! class_exists( 'ANONY_Copyright' ) ) {
	/**
	 * Copyright widget class
	 *
	 * @package    Widgets
	 * @author     Makiomar <info@makior.com>
	 * @license    https://makiomar.com SmartPage Licence
	 * @link       https://makiomar.com
	 */
	class ANONY_Copyright extends WP_Widget {

		/**
		 * Class constructor
		 *
		 * @return void
		 */
		public function __construct() {
			$parms = array(
				'description' => esc_html__( 'Displays a dynamic copyright text', 'smartpage' ),
				'name'        => esc_html__( 'Anonymous copyright', 'smartpage' ),
			);
			parent::__construct( 'ANONY_Copyright', '', $parms );
		}

		/**
		 * Outputs the settings update form.
		 *
		 * @param array $instance Current settings.
		 *
		 * @return void
		 */
		public function form( $instance ) {
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'copyright_text' ) ); ?>"><?php esc_html_e( 'Copyright text:', 'smartpage' ); ?></label>
				
				<input 
				type="text" 
				class="widefat" 
				id="<?php echo esc_attr( $this->get_field_id( 'copyright_text' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'copyright_text' ) ); ?>"  
				value="<?php echo ( isset( $instance['copyright_text'] ) && ! empty( $instance['copyright_text'] ) ) ? esc_attr( $instance['copyright_text'] ) : esc_attr__( 'All copyrights are reserved', 'smartpage' ); ?>">
				
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

			?>
			<p>©&nbsp;<?php echo wp_kses_post( $instance['copyright_text'] ); ?>&nbsp;<span id="anony-copyright-year"></span></p>
			<script>
			var date = new Date().getFullYear();
			document.getElementById("anony-copyright-year").innerHTML = date;
			</script>
			<?php
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
			$instance                   = array();
			$instance['copyright_text'] = ( ! empty( $new_instance['copyright_text'] ) ) ? $new_instance['copyright_text'] : '';
			return $new_instance;
		}
	}
}
