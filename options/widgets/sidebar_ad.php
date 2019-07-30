<?php
/**
 * Sidebar ADs widget class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

if ( ! class_exists( 'Class__Sidebar_Ad' ) ) {
class Class__Sidebar_Ad extends WP_Widget{
	
	/**
	 * Constructor
	 */
	
	public function __construct(){
		$parms = array(
			'description' => esc_html__('Displays the sidebar AD from theme options',TEXTDOM),
			'name' => esc_html__('Sidebar ADs',TEXTDOM)
		);
		parent::__construct('Options__Widgets__Sidebar__Ad','',$parms);
	}
	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 */
	
	public function form($instance){
		extract($instance);?>

		<p>
			<label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', TEXTDOM) ?></label>

			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>"  value="<?php echo (isset($title) && !empty($title))? esc_attr($title) : esc_attr__('ADs', TEXTDOM);?>">

		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('anony_ad') ?>"><?php esc_html_e('AD:', TEXTDOM) ?></label><br/>
			
			<textarea rows="10" class="widefat" id="<?php echo $this->get_field_id('anony_ad') ?>" name="<?php echo $this->get_field_name('anony_ad') ?>"><?php echo (isset($anony_ad) && !empty($anony_ad))? anony_remove_tags_dom($anony_ad, 'script',true) : ''?></textarea>

		</p>

	<?php }
	
	/**
	 * Outputs the HTML for this widget.
	 */
	
	public function widget($parms, $instance){
		
		extract($parms);

		extract($instance);

		$title = empty($title) ?  esc_html__('ADs', TEXTDOM) : $title;

		echo $before_widget;

		echo $before_title.$title.$after_title;

		echo '<div id="anony-ads">';
			echo anony_remove_tags_dom($anony_ad, 'script',true);
			has_action('sidebar_ad') ? do_action('sidebar_ad') : '';
		echo '</div>';
		

		echo $after_widget;
	}
	
	/**
	 * Deals with the settings when they are saved by the admin.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] 	    = strip_tags( $new_instance['title'] );
		$instance['anony_ad'] 	= anony_remove_tags_dom($new_instance['anony_ad'], 'script',true) ;
		
		return $instance;
	}
}
}
