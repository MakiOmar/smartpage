<?php
/**
 * Page template
 *
 * PHP version 7.3 Or Later
 *
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined( 'ABSPATH' ) or die(); // Exit if accessed direct

get_header();?>
<div class="anony-grid">
	  
	  <div class="anony-grid-row anony-grid-col">
		  
		<div class="anony-grid-col-sm-9-5">
			
			<div class="anony-grid-col anony-posts-wrapper">
				
			<?php
			if ( has_action( 'page_ad' ) ) {
				do_action( 'page_ad' );
			}
			?>
			
				<div class="anony-grid-container">
					
				<?php
				if ( have_posts() ) {

					while ( have_posts() ) {

						the_post();
						?>
					
						<div 
						class="anony-grid-col anony-post-contents anony-single_post">
							
							<div class="anony-post-info">
								
								<div class="anony-single-text">
						<?php the_content(); ?>
								</div>
								
							</div>
							
						</div>
					
						<?php
					}
				};
				?>
				
				</div>
				
			</div>
			
		</div>
		
	   <?php get_sidebar(); ?>
	   
	</div>
	
</div>

<?php get_footer(); ?>
