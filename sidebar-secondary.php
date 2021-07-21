<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * This is the sidebar in the featured section
 */

$popular_title = esc_html__('Popular',ANONY_TEXTDOM);
$recent_comments_title = esc_html__('Recent comments',ANONY_TEXTDOM);
?>
<div class="anony-secondary-sidebar anony-grid-col-md-4 anony-grid-col">
	
	<div class="white-bg">
	  	
		<div class="anony-popular-tabs">
			
		  <span class="anony-active-tab anony-grid-col-6 anony-popular" rel-id="anony-popular"><?= $popular_title ?></span>
		  <span class="anony-grid-col-6 comments" rel-id="anony-comments"><?= $recent_comments_title ?></span>
		  
		</div>
		
		<?php get_template_part('models/popular') ?>
		
		<?php get_template_part('templates/latest-comments') ?>
		 	
	</div>
</div>