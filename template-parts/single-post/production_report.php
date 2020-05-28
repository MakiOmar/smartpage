<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
	
$anonyOptions = ANONY_Options_Model::get_instance();
	anony_get_correct_sidebar();

	if(has_action('post_ad')){
		do_action('post_ad');
	}
?>
<div class="anony-grid-col <?php echo ($anonyOptions->single_sidebar == '1') ? 'anony-grid-col-sm-7' : 'anony-grid-col-sm-9-5' ?>">

	<?php anony_breadcrumbs()?>
	<?php 
		if ( have_posts() ) {
			while (have_posts() ) { 
				the_post();
				$post_id = get_the_ID();
				?>
				<div class="anony-grid-col anony-post-contents anony-single_post">
					<div class="anony-post-info">
						<div class="anony-single-text">
							
							<?php the_content();?>
						</div>
					</div>

				 </div>
		  <?php } 
		} 
	?>
</div>

<?php anony_get_correct_sidebar();?>