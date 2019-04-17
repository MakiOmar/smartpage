<?php 
get_header();
?>
  <div class="grid">
  	<div class="grid-row grid-col">
        <div class="grid-col-sm-9-5">
			<div class="content-wrapper">
               <?php get_sidebar('secondary');?>
               
				<div id="section-top" class="grid-col-md-8 grid-col">

					<?php get_template_part('templates/temp','news') ;?>
					
					<?php get_template_part('templates/temp','featured') ;?>
					
				</div>   
            </div>
			<?php 
				
				get_template_part('templates/temp','downloads') ;

				get_template_part('templates/temp','category-posts-masonary') ;
			
				//get_template_part('templates/temp','video') ;
			
			 ?>	
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
 <?php get_footer();?>