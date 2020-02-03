<?php get_header();?>
  <div class="anony-grid">
  	<div class="anony-grid-row anony-grid-col">
       <?php
       $sites = ['dam', 'reservoir'];
       if(in_array(get_post_type(), $sites)){
       		get_template_part( 'template-parts/single-post/site' );
       }else{
       		get_template_part( 'template-parts/single-post/'.get_post_type() );
       }
       ?>
	</div>
  </div>
 <?php get_footer();?>