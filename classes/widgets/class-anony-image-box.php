<?php
/**
 * Image box widget
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

if ( ! class_exists( 'ANONY_Image_Box' ) ) {
	/**
	 * Image box widget class
	 *
	 * @package    Widgets
	 * @author     Makiomar <info@makior.com>
	 * @license    https://makiomar.com SmartPage Licence
	 * @link       https://makiomar.com
	 */
	class ANONY_Image_Box extends WP_Widget {

		/**
		 * Class constructor
		 *
		 * @return void
		 */
		public function __construct() {
			$parms = array(
				'description' => esc_html__( 'Displays an image box', 'smartpage' ),
				'name'        => esc_html__( 'Anonymous image box', 'smartpage' ),
			);
			parent::__construct( 'ANONY_Image_Box', '', $parms );
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
				<label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php esc_html_e( 'Image URL:', 'smartpage' ); ?></label>
				
				<input 
				type="text" 
				class="widefat" 
				id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>"  
				value="<?php echo ( isset( $instance['image_url'] ) && ! empty( $instance['image_url'] ) ) ? esc_attr( $instance['image_url'] ) : ''; ?>">
				
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'image_box_title' ) ); ?>"><?php esc_html_e( 'Title:', 'smartpage' ); ?></label>
				
				<input 
				type="text" 
				class="widefat" 
				id="<?php echo esc_attr( $this->get_field_id( 'image_box_title' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'image_box_title' ) ); ?>"  
				value="<?php echo ( isset( $instance['image_box_title'] ) && ! empty( $instance['image_box_title'] ) ) ? esc_attr( $instance['image_box_title'] ) : ''; ?>">
				
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'image_box_description' ) ); ?>"><?php esc_html_e( 'Description:', 'smartpage' ); ?></label>
				
				<input 
				type="text" 
				class="widefat" 
				id="<?php echo esc_attr( $this->get_field_id( 'image_box_description' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'image_box_description' ) ); ?>"  
				value="<?php echo ( isset( $instance['image_box_description'] ) && ! empty( $instance['image_box_description'] ) ) ? esc_attr( $instance['image_box_description'] ) : ''; ?>">
				
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
			$image_box_title       = $instance['image_box_title'];
			$image_box_description = $instance['image_box_description'];
			$image_url             = $instance['image_url'];
			include locate_template( 'templates/partials/image-box.php', false, false );
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
			$instance                          = array();
			$instance['image_box_title']       = ( ! empty( $new_instance['image_box_title'] ) ) ? $new_instance['image_box_title'] : '';
			$instance['image_box_description'] = ( ! empty( $new_instance['image_box_description'] ) ) ? $new_instance['image_box_description'] : '';
			$instance['image_url']             = ( ! empty( $new_instance['image_url'] ) ) ? $new_instance['image_url'] : '';
			return $new_instance;
		}
	}
}
