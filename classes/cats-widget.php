<?php
/**
 * Categories menu walkker
 *
 * PHP version 7.3 Or Later
 *
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

! class_exists( 'ANONY_Cats_Widget' ) || exit();

/**
 * Categories menu walkker class
 *
 * @category   Widgets
 * @package    Widgets
 * @subpackage Category
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
	 * @since 2.8.0
	 *
	 * @return string Default return is 'noform'.
	 */
	public function form( $instance ) {
		 extract( $instance );?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'smartpage' ); ?></label>
			
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>"  value="<?php echo ( isset( $title ) && ! empty( $title ) ) ? esc_attr( $title ) : esc_attr__( 'Categories', 'smartpage' ); ?>">
			
		</p>
		
		<?php
	}

	/**
	 * Echoes the widget content.
	 *
	 * Subclasses should override this function to generate their widget code.
	 *
	 * @param array $parms    Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance The settings for the particular instance of the widget.
	 *
	 * @since 2.8.0
	 *
	 * @return void
	 */
	public function widget( $parms, $instance ) {
		extract( $parms );

		extract( $instance );

		$title = empty( $title ) ? esc_html__( 'Categories', 'smartpage' ) : $title;

		echo $before_widget;

		echo $before_title . $title . $after_title;

		echo '<ul id="anony-cat-list">';

		wp_list_categories(
			array(
				'hide_empty' => 0,
				'title_li'   => '',
				'order'      => 'DESC',
				'walker'     => new ANONY_Cats_Walk(),
			)
		);

		echo $after_widget;

		echo '</ul>';

		wp_enqueue_script( 'anony-cats-menu' );
	}
}

