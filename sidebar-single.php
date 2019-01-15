 <span class="toggle-sidebar"><i class="fa fa-arrow-down"></i></span>
 <div class="grid-col-sm-2-5 asidebar single-sidebar grid-col">
	<?php if ( is_single() ) {
					  $cats = wp_get_post_categories($post->ID);
					  $first_cat_id=$cats[0];
					  $catpostcount= number_postpercat($first_cat_id);
						if ($catpostcount>=2){
						echo '<h3 class="widgeted_title"><a href="'.get_category_link( $first_cat_id ).'">'.get_cat_name( $first_cat_id ).'</a></h3>';}
					  if ($cats) {
						$first_cat = $cats[0];
						$args=array(
						  'cat' => $first_cat,
						  'post__not_in' => array($post->ID),
						  'order' => 'ASC',
						  'showposts'=>-1,
						);
						$same_cat_posts = new WP_Query($args);
						if( $same_cat_posts->have_posts() ) {
						  while ($same_cat_posts->have_posts()) : $same_cat_posts->the_post(); ?>
							<h5 class="same_cat_post"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
						   <?php
						  endwhile;
						} //if ($my_query)
					  } //if ($cats)
					  wp_reset_query();  // Restore global post data stomped by the_post().
					}?>	
</div>