<?php 
/*Template Name: HomePage*/
get_header();
?>
  <div class="grid">
  	<div class="grid-row grid-col">
        <div class="grid-col-sm-9-5">
			<div class="content-wrapper">
               <?php get_sidebar('secondary');?>
               <?php 
					$args = array('post_type' => 'smpg_news','posts_per_page'=>5);
					$smpg_news= new WP_Query($args);
				?>
                <div id="section-top" class="grid-col-md-8 grid-col">
                <?php if ( $smpg_news->have_posts() ) {?>
					  <div id="didyouknow" class="group">
						<p id="dun-title"><?php _e('Simple Info','smartpage') ?></p>
						<?php get_search_form();?>
						</div>
							<div id="dun-text">
							<div id="dun_text_wrapper"<?php if (is_rtl()) echo ' class="is-rtl"' ?>>
								<?php while($smpg_news->have_posts()){
									$smpg_news->the_post();?>
									<p id="dun-text-<?php the_ID()?>" class="dun_text"><?php echo strip_tags(get_the_content())?></p>
								<?php }?>
							</div>
							</div>
							<?php }
						wp_reset_postdata();
						?>
						<?php get_template_part('templates/temp','featured') ;?>
                  </div>   
            </div>
			<?php 
				//get_template_part('templates/temp','video') ;
				$args = array('post_type' => 'smpg_download','posts_per_page'=>5);
							$smpg_download = new WP_Query($args);
							if ( $smpg_download->have_posts() ) {
				?>
				<div class="section">
					<div><h4 class="section_title clearfix"><?php _e('Suggested downloads','smartpage');?></h4></div>
					<div class="posts-wrapper">
					  <div id="download">
							<?php 
									while ( $smpg_download->have_posts() ) { 
									$smpg_download->the_post();
									get_template_part('templates/temp','download') ;	
					  			}?>
					  </div>
					</div>
				  </div>
							<?php wp_reset_postdata();} 
				
				
			   get_template_part('templates/temp','category-posts-masonary') ;
			 ?>	
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
 <?php get_footer();?>