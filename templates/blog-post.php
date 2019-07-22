<?php 

$tbp_post_id = get_the_ID();

anony_set_post_views($tbp_post_id);?>

<div id="post-<?php echo $tbp_post_id?>" class="anony-post-wrapper anony-grid-col-max-480-12 anony-grid-col-av-12 anony-grid-col-md-6 anony-grid-col">
	<div class="anony-post-contents anony-blog-post anony-grid-col">
  
	  <div class="anony-post-info">
	  
	   <?php if( has_post_thumbnail() && is_url_exist(get_the_post_thumbnail_url($tbp_post_id))){
	
			get_template_part('templates/post-layout/post','with-thumb') ;
	
		}else{
	
			get_template_part('templates/post-layout/post','without-thumb') ;
	
		}?>
		
		<div class="anony-extra-metas">
		
			<div class="anony-author-avatar">
			
				<?php echo get_avatar(get_the_author_meta('ID'),32) ?>
				
			</div>
			
			<div class="author-name">
			
				<span>
				
					<?php 
						esc_html_e('By',TEXTDOM);
						echo ' '.get_the_author(); 
					?>
					
				</span>
				
			</div>
			
			<div>
			
				<a class="button anony-button" href="<?php echo esc_url( get_the_permalink() ) ?>"><?php esc_html_e('Read more',TEXTDOM) ?></a>
				
			</div>
			
		</div>
		
	</div>
	
  </div>
  
</div>