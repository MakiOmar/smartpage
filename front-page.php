<?php 
get_header();
?>
  <div class="anony-grid">
	<?php
	
$anonyOptions = anonyOpt();

	if(anonyGetOpt($anonyOptions, 'slider') ){
		
		if(ANONY_WPPLUGIN_HELP::isActive('revslider/revslider.php') && anonyGetOpt($anonyOptions, 'home_slider') == '1'){
			
			if(anonyGetOpt($anonyOptions, 'rev_slider') && anonyGetOpt($anonyOptions, 'rev_slider') != '0'){
				
				putRevSlider(anonyGetOpt($anonyOptions, 'rev_slider'));
				
			}else{
				
				echo '<p class="anony-warning">'.esc_html__('You didn\'t choose a slider, Please select one from theme options page').'</p>';
				
			}
			
		}
		
	}

	?>
  	<div class="anony-grid-row anony-grid-col">
        <div class="anony-grid-col-sm-9-5">
			<div class="anony-content-wrapper">
               <?php get_sidebar('secondary');?>
               
				<div id="anony-section-top" class="anony-grid-col-md-8 anony-grid-col">

					<?php get_template_part('templates/news') ;?>
					
					<?php get_template_part('templates/featured') ;?>
					
				</div>   
            </div>
			<?php 
				
				get_template_part('templates/downloads') ;

				get_template_part('templates/category-posts-'.anonyGetOpt($anonyOptions, 'posts_grid')) ;
			
				//get_template_part('templates/video') ;
			
			 ?>	
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
 <?php get_footer();?>