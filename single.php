<?php get_header();?>
  <div class="anony-grid">
  	<div class="anony-grid-row anony-grid-col">
       <?php get_template_part( 'template-parts/single-post/'.get_post_type() );?>
	</div>
  </div>
 <?php get_footer();?>