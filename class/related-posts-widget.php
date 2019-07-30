<?php
if ( ! class_exists( 'Class__Related_Posts_Widget' ) ) {
	class Class__Related_Posts_Widget extends WP_Widget{
		public function __construct(){
			$parms = array(
				'description' => esc_html__('Displays list of posts within the same category',TEXTDOM),
				'name' => esc_html__('Anonymous related posts',TEXTDOM)
			);
			parent::__construct('Class__Related_Posts_Widget','',$parms);
		}
		public function form($instance){
			extract($instance);?>
			
			<p>
				<label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', TEXTDOM) ?></label>
				
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>"  value="<?php echo (isset($title) && !empty($title))? esc_attr($title) : esc_attr__('Related posts', TEXTDOM);?>">
				
			</p>
			
		<?php }
		public function widget($parms, $instance){
			if ( is_single() ) {
				
			extract($parms);
			
			extract($instance);
			
			if(empty($title)) $title = esc_html__('Related posts', TEXTDOM);
	
			echo $before_widget;
			
			echo $before_title.$title.$after_title;
			
			$p_ID = get_The_ID();

			$cats = wp_get_post_categories($p_ID);

			if (!is_wp_error($cats) && !empty($cats)) {

				$first_cat = $cats[0];

				$catpostcount = anony_cat_posts_count($first_cat);?>

				<ul class="anony-grid-col">
				<?php
				if ($catpostcount >= 1){
						$args=array(
						  'cat' => $first_cat,
						  'post__not_in' => array($p_ID),
						  'order' => 'ASC',
						  'posts_per_page'=>-1,
						);

						$same_cat_posts = new WP_Query($args);

						if( $same_cat_posts->have_posts() ) {?>



								<?php 
								/*echo '<h3 class="widgeted_title"><a href="'.get_category_link( $first_cat ).'">'.get_cat_name( $first_cat ).'</a></h3>';*/
								while ($same_cat_posts->have_posts()) : $same_cat_posts->the_post(); ?>

									<li class="anony-same_cat_post"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></li>

							   <?php 
									endwhile;
									wp_reset_postdata();  // Restore global post data stomped by the_post().
								?>


						<?php } //if ($same_cat_posts)
				}else{
					echo '<p>'. esc_html__('No more posts in this category') . '</p>';
				}
			} //if ($cats)?>
			</ul>
		<?php }
			
			echo $after_widget;
		}
	}
}