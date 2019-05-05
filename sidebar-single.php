 <?php 
if ( is_single() ) {
	$p_ID = get_The_ID();
	
	$cats = wp_get_post_categories($p_ID);
	
	if (!is_wp_error($cats) && !empty($cats)) {
		
		$first_cat = $cats[0];

		$catpostcount = number_postpercat($first_cat);?>
		
		<span class="toggle-sidebar"><i class="fa fa-arrow-down"></i></span>

		<div class="grid-col-sm-2-5 asidebar single-sidebar grid-col">
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
						echo '<h3 class="widgeted_title"><a href="'.get_category_link( $first_cat ).'">'.get_cat_name( $first_cat ).'</a></h3>';
						while ($same_cat_posts->have_posts()) : $same_cat_posts->the_post(); ?>

							<h5 class="same_cat_post"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h5>

					   <?php 
							endwhile;
							wp_reset_postdata();  // Restore global post data stomped by the_post().
						?>

				
				<?php } //if ($same_cat_posts)
		}else{
			echo '<p>'. esc_html__('No more posts in this category') . '</p>';
		}
	} //if ($cats)?>
	</div>
<?php }?>	