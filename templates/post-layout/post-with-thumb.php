<div class="post-image-wrapper">
	<div class="toggle-excerpt"><i class="fa fa-arrow-up"></i></div>
	
	<div class="text">
		<h3 class="thumb-post-title"><a href="<?php echo esc_url(get_the_permalink()) ;?>"><?php echo get_the_title() ?></a></h3>
		<p><?php echo esc_html(get_the_excerpt()); ?></p>
	</div>
	
	<div class="post_meta inside-thumb">
	  <div class="date">
		<i class="fa fa-calendar meta-text"></i>
		<span class="meta-text"><?php echo get_the_date(); ?></span>
		</div>
		<div class="comments">
			<i class="fa fa-comments-o meta-text"></i>
			<?php echo smpg_comments_number(); ?>
		</div>
	</div>
	  
	  <?php if(has_category()){?>
	  
	  	<h4><a href="<?php echo esc_url(get_category_link(get_the_category()[0]->cat_ID));?>"><?php echo esc_html(get_the_category()[0]->name) ;?></a></h4>
	  	
	  <?php } ?>
	  <div class="shares-count">
	  	<i class="fa fa-share-alt"></i><span>1000 <?php esc_html_e('Shares',TEXTDOM) ?></span>
	  </div>
	  
	   <div class="post-title-cover"><?php echo '<a href="' . esc_url( get_the_permalink() ) . '" title="' . esc_attr( get_the_title() ) . '">.</a>';?></div>
	   
		<?php echo get_the_post_thumbnail($post, 'full') ?>
</div>