<?php
/**
 * Posts Widget
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

if ( ! class_exists( 'ANONY_Posts_Widget' ) ) {
	/**
	 * Posts Widget class
	 *
	 * @package    SmartPage
	 * @author     Makiomar <info@makior.com>
	 * @license    https://makiomar.com SmartPage Licence
	 * @link       https://makiomar.com
	 */
	class ANONY_Posts_Widget extends WP_Widget {

		/**
		 * Class constructor
		 *
		 * @return void
		 */
		public function __construct() {
			$parms = array(
				'description' => esc_html__( 'Displays posts by post type', 'smartpage' ),
				'name'        => esc_html__( 'Anonymous posts', 'smartpage' ),
			);
			parent::__construct( 'ANONY_Posts_Widget', '', $parms );
		}

		/**
		 * Outputs the settings update form.
		 *
		 * @param array $instance Current settings.
		 *
		 * @return void
		 */
		public function form( $instance ) {

			if ( ! isset( $instance['post_type'] ) || empty( $instance['post_type'] ) ) {
				esc_html_e( 'You should select a post type', 'smartpage' );
			}
			?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'smartpage' ); ?></label>
				
				<input 
				type="text" 
				class="widefat" 
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"  
				value="<?php echo ( isset( $instance['title'] ) && ! empty( $instance['title'] ) ) ? esc_attr( $instance['title'] ) : esc_attr__( 'Top places', 'smartpage' ); ?>">
				
			</p>


			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php esc_attr_e( 'Post Type:', 'smartpage' ); ?></label>

				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>" autocomplete="off">
			<?php
			$post_type = isset( $instance['post_type'] ) ? $instance['post_type'] : 'post';
			$selected  = selected( $post_type, 'current', false );
			?>
					<option value="current" <?php echo esc_attr( $selected ); ?>><?php esc_html_e( 'Current post type', 'smartpage' ); ?></option>
			<?php
			foreach ( get_post_types(
				array(
					'public'   => true,
					'_builtin' => false,
				)
			) as $type ) {
				$selected = selected( $post_type, $type, false )
				?>
							<option value="<?php echo esc_attr( $post_type ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_html( $type ); ?></option>
				<?php
			}

			?>
					
				</select>

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

			if ( 'current' === $instance['post_type'] && ! is_single() ) {
				$post_type = 'post';
			} else {
				$post_type = ( 'current' === $instance['post_type'] ) ? get_post_type() : $instance['post_type'];
			}
			$title = $instance['title'];

			$args  = array(
				'post_type'      => $post_type,
				'posts_per_page' => -1,
			);
			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {

				$post_type_object = get_post_type_object( $post_type );

				if ( 'current' === $instance['post_type'] ) {
					$title = $post_type_object->label;
				}

				$output = '';

				$output .= $parms['before_widget'];

				$output .= $parms['before_title'] . esc_html( $title ) . $parms['after_title'];

				$output .= '<ul class="artr_terms_list">';

				while ( $query->have_posts() ) {
					$query->the_post();

					$output .= sprintf( '<li class="artr_post_item"><a class="artr_post_link" href="%1$s">%2$s</a></li>', esc_url( get_the_permalink( get_the_ID() ) ), get_the_title() );
				}

				wp_reset_postdata();

				$output .= '</ul>';

				$output .= $parms['after_widget'];

				//phpcs:disable
				echo $output;
				//phpcs:enable.
			} elseif ( ! isset( $instance['post_type'] ) || empty( $instance['post_type'] ) ) {
					esc_html_e( 'Anonymous posts widget: You should select a post type', 'smartpage' );
			}
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
			$instance              = array();
			$instance['title']     = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
			$instance['post_type'] = ( ! empty( $new_instance['post_type'] ) ) ? sanitize_text_field( $new_instance['post_type'] ) : 'place';

			return $instance;
		}
	}
}
