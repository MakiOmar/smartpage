<div id="popular" class ="tab_content">
	 <?php 
		$args = array(
			'posts_per_page' => 4,//NO. of posts you want to show 
			 'meta_key' => 'post_views_count',
			 'orderby'=> 'meta_value_num',// Order according to numbers not name 
			 'order' => 'DESC', 
		);
		$popular = new WP_Query($args);
		if ( $popular->have_posts() ) {
		while ($popular->have_posts() ) { $popular->the_post();
		?>
		<div id="popular-<?php the_ID() ?>" class="posts-list-wrapper">
		<?php if(has_post_thumbnail()){?>
			<div class="posts-list-thumb">
				<?php  the_post_thumbnail(array('150','150'),array( 'class' => 'post-thumb'))?>	
			</div>
		<?php } ?>
			<div class="posts-list">
				<div>
					  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
				</div>
				<div class="metadata"><i class="fa fa-calendar"></i>&nbsp;<?php echo get_the_date('Y-m-d'); ?></div>
				<div class="metadata"><i class="fa fa-eye"></i>&nbsp;<?php echo getPostViews(get_the_ID())?></div>
				<?php get_template_part('templates/temp','rate') ?>
			</div>
		</div>	
	 <?php }			
		}else{
			echo'<p>'.__('No popular posts till now','smartpage').'</p>';
		}
	wp_reset_postdata();?>
	  </div>