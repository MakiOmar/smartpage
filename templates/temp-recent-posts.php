<div id="recent" class ="tab_content">
	 <?php 
		$args = array(
			'posts_per_page' => 4,//NO. of posts you want to show 
		);
		$recent = new WP_Query($args);
		if ( $recent->have_posts() ) {
		while ($recent->have_posts() ) { $recent->the_post();
			?>
			<div id="recent-<?php the_ID() ?>">
				<div>
				  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
				</div>
				<div class="metadata"><i class="fa fa-calendar"></i>&nbsp;<?php echo get_the_date('Y-m-d'); ?></div>
				<div class="metadata"><i class="fa fa-comment-o"></i>&nbsp;<?php comments_number( __('No comments','smartpage'), __('One comment','smartpage'), '%'.__('comments','smartpage') ); ?></div>
				<div class="metadata"><i class="fa fa-eye"></i>&nbsp;<?php echo getPostViews(get_the_ID())?></div>
		    </div>	
	 <?php }
		wp_reset_postdata();			
		}else{
			echo'<p>'.__('No published posts','smartpage').'</p>';
		}?>
	  </div>