<div class="anony-nothumb-post">
	<h3 class="anony-thumb-post-title"><a href="<?php echo get_the_permalink() ;?>"><?php echo get_the_title() ?></a></h3>
	<div class="anony-post_meta">
		<div class="date">
			<i class="fa fa-calendar meta-text"></i>
			<span class="meta-text"><?php echo get_the_date(); ?></span>
		</div>
		
		<div class="anony-comments">
			<i class="fa fa-comments-o meta-text"></i>
			<?php echo anony_comments_number(); ?>
		</div>
		<?php if(has_category()){?>
		
			<div class="category">
			
				<i class="fa fa-folder-open meta-text"></i>
				
				<a class="meta-text" href="<?php echo esc_url(get_category_link(get_the_category()[0]->cat_ID));?>"><?php echo esc_html(get_the_category()[0]->name );?></a>
			
			</div>
		
		<?php }?>
		
	</div>
		<p><?php echo esc_html(get_the_excerpt()); ?></p>
</div>