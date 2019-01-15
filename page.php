<?php get_header();?>
  <div class="grid">
  	<div class="grid-row grid-col">
        <div class="grid-col-sm-9-5">
        	<div class="grid-col posts-wrapper">
				<div class="grid-container">
				<?php 
					if ( have_posts() ) {
					while (have_posts() ) { the_post();
				?>
					<div class="grid-col post-contents single_post">
						<div class="post-info">
							<div class="single-text">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				  <?php }};?>
				</div>
			</div>
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
 <?php get_footer();?>