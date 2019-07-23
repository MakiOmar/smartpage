<?php 
/*
*Download custom post type anony_download
*/

get_header();

$dPost_Id = get_the_ID();

$curr_download_meta = get_post_meta( $dPost_Id, 'anony_download_attachment', true );

$download_times = get_post_meta($dPost_Id,'download_times',true);

if(empty($download_times)){
	$download_times = 0;
}
?>
  <div class="anony-grid">
  	<div class="anony-grid-row anony-grid-col">
      
       <?php get_sidebar();?>
       
        <div class="anony-grid-col-sm-9">
      		 <div class="anony-grid-col anony-blog-section">
				<div class="anony-posts-section">
       		 		<div class="anony-grid-col anony-post-contents">
                      <?php
						if ( have_posts() ) {
							
					   		while (have_posts() ) {
							the_post();?>
                       	
                        	<div class="anony-hover-toggle anony-download-meta anony-post-info anony-grid-col-lg-3">
                        	
							  <?php if ( has_post_thumbnail() ) {?>
							  
								  <div class="download-image-wrapper">
									<?php the_post_thumbnail(array('230','300'));?>
								  </div>
								  
							  <?php }?>
                            </div>
                            
                            <div class="anony-grid-col-lg-9">
								<div class="single-download-title">
									<div class="title-date-wrapper">
									
										<?php $date = explode(' ',get_the_date()) ;?>
										<div class="date">
											<div class="date-wrapper">
												<h1 class="day"><?php echo $date[0] ?></h1>
												<span><?php echo $date[1].' '.$date[2] ?></span>
											</div>
										</div>

										
										<div class="download-title">
										
											<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
											
											<div class="anony-post_meta">
												<div class="category">
												
													<i class="fa fa-folder-open"></i>

													<?php the_terms($dPost_Id,'download_category') ;?>

												</div>
												
												
												<div class="download-counts">
												
													<i class="fa fa-download"></i>
													<span id="download-<?php echo $dPost_Id?>"><?php echo $download_times ;?></span>
													
												</div>

 												<?php get_template_part('templates/rate') ?>

											</div>
											
											
											<div class="single-download">
											
												<a title="download-<?php echo $dPost_Id?>" target="_blank" class="anony-download" href="<?php echo $curr_download_meta ?>">
													<i class="fa fa-download"></i>
													<span><?php esc_html_e('Download',TEXTDOM) ?></span>
												</a>
												
											</div>
											
										</div>
										
									</div>
									
								</div>
							  
								  <?php the_content() ?>
							  </div>
                          <?php 
								}
							}
						?>
               		</div>
               		
				</div>
      		 
       		 </div>
       		 
       		 <?php comments_template( '', true ); ?>
       		 
        </div>
       
	</div>
	
  </div>
 <?php get_footer();?>