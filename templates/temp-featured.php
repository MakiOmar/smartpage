<?php 
	$idObj = get_category_by_slug('featured-posts');
	if($idObj){
		$args = array('cat'=>$idObj->term_id);
		$que = new WP_Query($args);
		if ( $que->have_posts() ) {
			$featuredIDs = array();
			
	?>
	<div id="slider-wrapper">
	<div id="featured">
		<div id="active-slide">
			<?php 
			while ($que->have_posts() ) { $que->the_post();
			if (has_post_thumbnail()){
				$featuredIDs[]= get_the_ID();
			?>
			<div class="view">
			  <?php the_post_thumbnail('full');?>
			  <div class="title-readmore">
				  <h2 class="slide-title"><a href="<?php the_permalink()?>"><?php the_title() ;?></a></h2>
				  <a class="featured-button" href="<?php the_permalink()?>"><?php _e('Read more', 'smartpage')?></a>
			  </div>
			</div>
			<?php } } wp_reset_postdata();?>
		</div>
		<?php if(count($featuredIDs) > 0){ ?>
				<h3 class="featured-posts-title"><a href="<?php echo get_category_link($idObj->term_id) ?>"><?php echo get_cat_name( $idObj->term_id ) ?></a></h3>
		<?php }?>
		<div id="slides-list" class="">
		<?php foreach($featuredIDs as $pID) {?>
			<a href="<?php echo get_the_permalink($pID) ?>" class="<?php if(array_search($pID,$featuredIDs) == 0) echo 'active-slide '?>slide-item grid-col-<?php echo count($featuredIDs)?>"><img src="<?php echo get_the_post_thumbnail_url($pID,'thumbnail') ?>" alt="<?php echo get_the_title($pID) ?>"/></a>
			<?php }?>
		</div>
	 </div>
</div>
<?php }}; 
?>