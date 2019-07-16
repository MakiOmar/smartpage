<?php 
get_header();
?>
  <div class="grid">
	<?php
	$smpgOptions = opt_init_();

	if(isset($smpgOptions->slider )){
		
		if(smpg_is_active_plugin('revslider/revslider.php') && $smpgOptions->home_slider == '1'){
			
			if(isset($smpgOptions->rev_slider) && $smpgOptions->rev_slider != '0'){
				
				putRevSlider($smpgOptions->rev_slider);
				
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

				get_template_part('templates/category-posts-'.$smpgOptions->posts_grid) ;
			
				get_template_part('templates/video') ;
			
			 ?>	
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
 <?php get_footer();?>