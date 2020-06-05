<?php 
if ( ! defined( 'ABSPATH' ) )  exit; // Exit if accessed directly

get_header();?>

<div class="anony-grid">
	<div class="anony-grid-row anony-grid-col">
  
	   <?php get_sidebar();?>
	   
		<div class="anony-grid-col-sm-9">

			<div class="anony-grid-col anony-blog-section">

				<div class="anony-posts-section">

				 		<div class="anony-grid-col anony-post-contents">
		               	
		                	<div class="anony-hover-toggle anony-download-meta anony-post-info anony-grid-col-lg-3">
		                	
							  <?php if ( $thumb ) {?>
							  
								  <div class="download-image-wrapper">
									<?= $thumb_img ?>
								  </div>
								  
							  <?php }?>
		                    </div>
		                    
		                    <div class="anony-grid-col-lg-9">

								<div class="single-download-title">

									<div class="title-date-wrapper">
				
										<div class="date">

											<div class="date-wrapper">

												<h1 class="day">
													<?= $date[0] ?>
												</h1>

												<span>
													<?= $date[1].' '.$date[2] ?>	
												</span>

											</div>
										</div>

										
										<div class="download-title">
										
											<h2>
												<a href="<?= $permalink ?>">
													<?= $title ?>
												</a>
											</h2>
											
											<div class="anony-post_meta">
												<div class="category">
												
													<i class="fa fa-folder-open"></i>

													<?= $terms ?>

												</div>
												
												
												<div class="download-counts">
												
													<i class="fa fa-download"></i>

													<span id="download-<?= $id ?>">
														<?= $download_times ?>
													</span>
													
												</div>

												<?= $rating ?>

											</div>
											
											
											<div class="single-download">
											
												<a title="download-<?= $id ?>" target="_blank" class="anony-download" href="<?= $download_url ?>">

													<i class="fa fa-download"></i>

													<span><?= $download_text ?></span>
												</a>
												
											</div>
											
										</div>
										
									</div>
									
								</div>
							  
								  <?= $content ?>
							  </div>
		       		</div>
		       		
				</div>
				 
			</div>
				 
				 <?= $comments_template ?>       		 
		</div>
	   
	</div>

</div>
<?php get_footer();?>