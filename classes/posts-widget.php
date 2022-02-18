<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
class ANONY_Posts_Widget extends WP_Widget {

	public function __construct() {
		 $parms = array(
			 'description' => esc_html__( 'Displays posts by post type', 'smartpage' ),
			 'name'        => esc_html__( 'Anonymous posts', 'smartpage' ),
		 );
		 parent::__construct( 'ANONY_Posts_Widget', '', $parms );
	}
	public function form( $instance ) {
		 extract( $instance );

		if ( ! isset( $instance['post_type'] ) || empty( $instance['post_type'] ) ) {
			esc_html_e( 'You should select a post type', 'smartpage' );
		}
		?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'smartpage' ); ?></label>
				
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>"  value="<?php echo ( isset( $title ) && ! empty( $title ) ) ? esc_attr( $title ) : esc_attr__( 'Top places', 'smartpage' ); ?>">
				
			</p>


			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php esc_attr_e( 'Post Type:', 'smartpage' ); ?></label>

				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'smartpage' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>" autocomplete="off">
		<?php
		$postType = isset( $instance['post_type'] ) ? $instance['post_type'] : 'post';
		$selected = selected( $postType, 'current', false );
		?>
					<option value="current" <?php echo $selected; ?>><?php esc_html_e( 'Current post type', 'smartpage' ); ?></option>
		<?php
		foreach ( get_post_types(
			array(
				'public'   => true,
				'_builtin' => false,
			)
		) as $type ) {
			$selected = selected( $postType, $type, false )
			?>
							<option value="<?php echo $postType; ?>" <?php echo $selected; ?>><?php echo $type; ?></option>
			<?php
		}

		?>
					
				</select>

			</p>
			
		<?php
	}
	public function widget( $parms, $instance ) {
		extract( $parms );

		extract( $instance );

		if ( $instance['post_type'] == 'current' && ! is_single() ) {
			$post_type = 'post';
		} else {
			$post_type = ( $instance['post_type'] == 'current' ) ? get_post_type() : $instance['post_type'];
		}

		$args  = array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
		);
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {

			$post_type_object = get_post_type_object( $post_type );

			if ( $instance['post_type'] == 'current' ) {
				$title = $post_type_object->label;
			}

			$output = '';

			$output .= $before_widget;

			$output .= $before_title . $title . $after_title;

			$output .= '<ul class="artr_terms_list">';

			while ( $query->have_posts() ) {
				$query->the_post();

				$output .= sprintf( '<li class="artr_post_item"><a class="artr_post_link" href="%1$s">%2$s</a></li>', esc_url( get_the_permalink( get_the_ID() ) ), get_the_title() );
			}

			wp_reset_postdata();

			$output .= '</ul>';

			$output .= $after_widget;

			echo $output;
		} else {
			if ( ! isset( $instance['post_type'] ) || empty( $instance['post_type'] ) ) {
				esc_html_e( 'You should select a post type', 'smartpage' );
			}
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
