<?php get_header();?>

<div class="anony-grid">

	<?php if($slider) : ?> 
	
		<?= $slider ?>
	
	<?php endif ?>
	
	<?php if(!$slider && $homeSlider == '1') : ?>

		<p class="anony-warning"><?= $chooseSlider ?></p>		

	<?php endif ?>

  	<div class="anony-grid-row anony-grid-col">
        <div class="anony-grid-col-sm-9-5">
			<div class="anony-content-wrapper">
				
               <?php get_sidebar('secondary');?>
               
				<div id="anony-section-top" class="anony-grid-col-md-8 anony-grid-col">

					<?php get_template_part('models/news') ;?>
					
					<?php get_template_part('models/featured') ;?>
					
				</div>   
            </div>
			<?php 
				
				get_template_part('models/downloads') ;

				include(locate_template( 'models/category-posts-section.php', false, false ));
			
				//get_template_part('models/video') ;
			
			 ?>
			 <div class="anony-ad">
				
				<?php do_action('before_footer_ad')?>
				
			</div>
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
<?php get_footer();?>