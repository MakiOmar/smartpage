<?php get_header();
	$curr_download_meta = get_post_meta( get_the_ID(), 'smpg_download_attachment', true );
	$download_times = get_post_meta(get_the_ID(),'download_times',true);
	if(empty($download_times)){
		$download_times = 0;
	}
?>
  <div class="grid">
  	<div class="grid-row grid-col">
       <?php get_sidebar();?>
        <div class="grid-col-sm-9">
      		 <div class="grid-col section blog-section">
				<div class="posts-section">
       		 		<div class="grid-col post-contents">
                      <?php
						if ( have_posts() ) {
					   	while (have_posts() ) {the_post();
					   	?>
                        	<div class="hover-toggle download-meta post-info grid-col-lg-3">
							  <?php if ( has_post_thumbnail() ) {?>
								  <div class="download-image-wrapper">
									<?php the_post_thumbnail(array('230','300'));?>
								  </div>
							  <?php }?>
                            </div>
                            <div class="grid-col-lg-9">
							<div class="single-download-title">
							<div class="title-date-wrapper">
									<?php 
										$date = explode(' ',get_the_date()) ;
										echo '<div class="date"><div class="date-wrapper"><h1 class="day">'.$date[0].'</h1>';
										echo '<span>'.$date[1].' '.$date[2].'</span></div></div>';

									?>
									<div class="download-title">
									<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<div class="post_meta">
									<div class="category">
									  <i class="fa fa-folder-open"></i>
									  <?php the_terms(get_the_ID(),'download_category') ;?>
									  </div>
									  <div class="download-counts">
									  <i class="fa fa-download"></i>
										<span id="download-<?php the_ID()?>"><?php echo $download_times ;?></span>
									  </div>
									 <?php get_template_part('templates/rate') ?>
									</div>
									<div class="single-download">
									<a title="download-<?php the_ID()?>" target="_blank" class="smpg-download" href="<?php echo $curr_download_meta ?>"><i class="fa fa-download"></i><span><?php esc_html_e('Download',TEXTDOM) ?></a></span>
									</div>
									</div>
								</div>
							</div>
							  <?php the_content() ?>
							  </div>
                          <?php }};?>
               </div>
				</div>
       		 </div>
       		 <?php comments_template( '', true ); ?>
        </div>
       
	</div>
  </div>
 <?php get_footer();?>