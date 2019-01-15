<?php 
get_header();
?>
  <div class="grid">
  	<div class="grid-row">
      <div class="grid-col">
        <div class="grid-col-sm-9-5">
        <?php get_template_part('templates/temp','blog') ;?>	
        </div>
       <?php get_sidebar();?>
	  </div>
	</div>
  </div>
 <?php get_footer();?>