<?php 
get_header();
?>
  <div class="grid">
	<?php
	$smpgOptions = Smpg__Options_Model::get_instance();

	if(isset($smpgOptions->smpg_slider_settings )){
		
		if(smpg_is_active_plugin('revslider/revslider.php') && $smpgOptions->smpg_home_slider_settings == '1'){
			
			if(isset($smpgOptions->smpg_rev_slider_settings) && $smpgOptions->smpg_rev_slider_settings != '0'){
				
				putRevSlider($smpgOptions->smpg_rev_slider_settings);
				
			}else{
				
				echo '<p class="smpg-warning">'.esc_html__('You didn\'t choose a slider, Please select one from theme options page').'</p>';
				
			}
			
		}
		
	}

	?>
  	<div class="grid-row grid-col">
        <div class="grid-col-sm-9-5">
			<div class="content-wrapper">
               <?php get_sidebar('secondary');?>
               
				<div id="section-top" class="grid-col-md-8 grid-col">

					<?php get_template_part('templates/news') ;?>
					
					<?php get_template_part('templates/featured') ;?>
					
				</div>   
            </div>
			<?php 
				
				get_template_part('templates/downloads') ;

				get_template_part('templates/category-posts-'.$smpgOptions->smpg_posts_grid_settings) ;
			
				//get_template_part('templates/video') ;
			
			 ?>	
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
 <?php get_footer();?>