<?php
if ( ! class_exists( 'Smpg_Cats_Widget' ) ) {
	class Smpg_Cats_Widget extends WP_Widget{
		public function __construct(){
			$parms = array(
				'description' => esc_html__('Displays an organized dropdown list of your categories',TEXTDOM),
				'name' => esc_html__('Smart Page categories',TEXTDOM)
			);
			parent::__construct('smpg_cats_widget','',$parms);
		}
		public function form($instance){
			extract($instance);?>
			
			<p>
				<label for="<?php echo $this->get_field_id('title') ?>">Title:</label>
				
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>"  value="<?php if(isset($title)) echo esc_attr($title);?>">
				
			</p>
			
		<?php }
		public function widget($parms, $instance){
			extract($parms);
			
			extract($instance);
			
			echo $before_widget;
			
			echo $before_title.$title.$after_title;
			
			echo '<ul id="smpg-cat-list">';
			
			$args = array(
					'hide_empty' => 0,
					'title_li' => '',
					'order'=> 'DESC',
					'walker' => new Smpg_Cats_Walk()
				   );
			
					wp_list_categories($args);
			
			echo $after_widget;
			
			echo '</ul>';
		}
	}
}