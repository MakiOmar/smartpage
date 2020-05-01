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

					<?php get_template_part('controllers/news') ;?>
					
					<?php get_template_part('controllers/featured') ;?>
					
				</div>   
            </div>
			<?php 
				
				get_template_part('controllers/downloads') ;

				include(locate_template( 'controllers/category-posts-section.php', false, false ));
			
				//get_template_part('controllers/video') ;
			
			 ?>	
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
<?php get_footer();?>