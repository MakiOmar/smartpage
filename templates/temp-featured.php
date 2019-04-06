<?php 
	$FreaturedCat = get_category_by_slug('featured-posts');
	
	if($FreaturedCat){
		
		$args = array(
			'posts_per_page' => 5,
			'orderby'        => 'rand',
			'cat'            =>$FreaturedCat->term_id
		);
		
		$FreaturedQuery = new WP_Query($args);
		
		if ( $FreaturedQuery->have_posts() ) {
			
			$FeaturedIDs = array();
			
	?>
	<div id="slider-wrapper">
	
		<div id="featured">
	
			<div id="active-slide">
				<?php

				while ($FreaturedQuery->have_posts() ) { 

					$FreaturedQuery->the_post();

					if (has_post_thumbnail()){

						$FeaturedIDs[]= get_the_ID();

						$link = get_the_permalink();?>

						<div class="view">

						  <?php the_post_thumbnail('full');?>

						  <div class="title-readmore">

							  <h2 class="slide-title"><a href="<?php echo $link ?>"><?php the_title() ;?></a></h2>

							  <a class="featured-button" href="<?php echo $link?>"><?php _e('Read more', TEXTDOM)?></a>

						  </div>
						</div>
					<?php }
				}?>
			</div>
		
		<?php if(count($FeaturedIDs) > 0){ ?>
			
			<h3 class="featured-posts-title">
			
				<a href="<?php echo get_category_link($FreaturedCat->term_id) ?>">
				
					<?php echo get_cat_name( $FreaturedCat->term_id ) ?>
					
				</a>
				
			</h3>
				
		
			<div id="slides-list" class="">

			<?php foreach($FeaturedIDs as $pID) {?>

				<a href="<?php echo get_the_permalink($pID) ?>" class="<?php if(array_search($pID,$FeaturedIDs) == 0) echo 'active-slide'?> slide-item grid-col-<?php echo count($FeaturedIDs)?>">
				
					<img src="<?php echo get_the_post_thumbnail_url($pID,'thumbnail') ?>" alt="<?php echo get_the_title($pID) ?>"/>
					
				</a>

				<?php }?>

			</div>
		
		<?php }?>
		
	 </div>
	 
</div>

<?php }
		
	wp_reset_postdata();
		
	}; 
?>