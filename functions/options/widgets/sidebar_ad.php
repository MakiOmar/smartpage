<?php
if ( ! class_exists( 'Smpg__Sidebar_Ad' ) ) {
	class Smpg__Sidebar_Ad extends WP_Widget{
		public function __construct(){
			$parms = array(
				'description' => esc_html__('Displays the sidebar AD from theme options',TEXTDOM),
				'name' => esc_html__('Sidebar ADs',TEXTDOM)
			);
			parent::__construct('Options__Widgets__Sidebar__Ad','',$parms);
		}
		public function form($instance){
			extract($instance);?>
			
			<p>
				<label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', TEXTDOM) ?></label>
				
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>"  value="<?php echo (isset($title) && !empty($title))? esc_attr($title) : esc_attr__('ADs', TEXTDOM);?>">
				
			</p>
			
		<?php }
		public function widget($parms, $instance){
			extract($parms);
			
			extract($instance);
			
			if(empty($title)) $title = esc_html__('ADs', TEXTDOM);
			
			echo $before_widget;
			
			echo $before_title.$title.$after_title;
			
			if(has_action('sidebar_ad')){
				echo '<div id="smpg-ads">';
					do_action('sidebar_ad');
				echo '</div>';
			}
			
			echo $after_widget;
		}
	}
}
