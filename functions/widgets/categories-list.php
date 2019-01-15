<?php
class SmPG_Categories_List extends WP_Widget{
	public function __construct(){
		$parms = array(
		'description' => __('Displays an organized dropdown list of your categories','smartpage'),
		'name' => __('Smart Page categories','smartpage')
		);
		parent::__construct('SmartPage_Categories_List','',$parms);
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
				'walker' => new SmPG_Cats_Walk()
			   );
				wp_list_categories($args);
		echo $after_widget;
		echo '</ul>';
	}
	
}

add_action('widgets_init', 'SmPG_categories_list_register');
function SmPG_categories_list_register(){
	register_widget('SmPG_Categories_List');
}