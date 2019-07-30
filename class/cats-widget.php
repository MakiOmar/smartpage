<?php
if ( ! class_exists( 'Class__Cats_Widget' ) ) {
	class Class__Cats_Widget extends WP_Widget{
		public function __construct(){
			$parms = array(
				'description' => esc_html__('Displays an organized dropdown list of your categories',TEXTDOM),
				'name' => esc_html__('Anonymous categories',TEXTDOM)
			);
			parent::__construct('Class__Cats_Widget','',$parms);
		}
		public function form($instance){
			extract($instance);?>
			
			<p>
				<label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', TEXTDOM) ?></label>
				
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>"  value="<?php echo (isset($title) && !empty($title))? esc_attr($title) : esc_attr__('Categories', TEXTDOM);?>">
				
			</p>
			
		<?php }
		public function widget($parms, $instance){
			extract($parms);
			
			extract($instance);
			
			if(empty($title)) $title = esc_html__('Categories', TEXTDOM);
			
			echo $before_widget;
			
			echo $before_title.$title.$after_title;
			
			echo '<ul id="anony-cat-list">';
			
			$args = array(
					'hide_empty' => 0,
					'title_li' => '',
					'order'=> 'DESC',
					'walker' => new Class__Cats_Walk()
				   );
			
					wp_list_categories($args);
			
			echo $after_widget;
			
			echo '</ul>';
		}
	}
}