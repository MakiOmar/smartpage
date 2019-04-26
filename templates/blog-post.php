<?php 

$tbp_post_id = get_the_ID();

setPostViews($tbp_post_id);?>

<div id="post-<?php echo $tbp_post_id?>" class="post-wrapper grid-col-max-480-12 grid-col-av-12 grid-col-md-6 grid-col">
	<div class="post-contents blog-post grid-col">
  
	  <div class="post-info">
	  
	   <?php if( has_post_thumbnail() && is_url_exist(get_the_post_thumbnail_url($tbp_post_id))){
	
			get_template_part('templates/post-layout/post','with-thumb') ;
	
		}else{
	
			get_template_part('templates/post-layout/post','without-thumb') ;
	
		}?>
		
		<div class="extra-metas">
		
			<div class="author-avatar">
			
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
			
				<a class="button smpg-button" href="<?php echo esc_url( get_the_permalink() ) ?>"><?php esc_html_e('Read more',TEXTDOM) ?></a>
				
			</div>
			
		</div>
		
	</div>
	
  </div>
  
</div>