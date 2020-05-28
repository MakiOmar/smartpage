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
	<div id="anony_map"></div>
	<?php 
		if ( have_posts() ) {
			while (have_posts() ) { 
				the_post();
				$post_id = get_the_ID();
				?>
				<div class="anony-grid-col anony-post-contents anony-single_post">
					<div class="anony-post-info">
						<div class="anony-single-text">
							<?php 
								$THs = [
									esc_html__( 'Reservoir name', ANONY_TEXTDOM ),
									esc_html__( 'Type', ANONY_TEXTDOM ),
									__( 'Capacity (m<sup>3</sup>/day)', ANONY_TEXTDOM ),
									esc_html__( 'Latitude', ANONY_TEXTDOM ),
									esc_html__( 'Longitude', ANONY_TEXTDOM ),
									esc_html__( 'City', ANONY_TEXTDOM ),
									esc_html__( 'Construction year', ANONY_TEXTDOM ),
								];

								$TDs = [
									get_the_title(),
									get_post_meta( $post_id, 'anony__res_type', true ),
									get_post_meta( $post_id, 'anony__res_capacity', true ),
									get_post_meta( $post_id, 'anony__entry_lat', true ),
									get_post_meta( $post_id, 'anony__entry_long', true ),
									get_post_meta( $post_id, 'anony__res_city', true ),
									get_post_meta( $post_id, 'anony__res_const_year', true ),
								];
							;?>
							<table>
							  <tr>
							  	<?php 
							  	foreach ($THs as $TH) {?>
							  		<th><?php echo $TH ;?></th>
							  	<?php }?>
							  </tr>

							  <tr>
							    <?php 
							  	foreach ($TDs as $TD) {?>
							  		<td><?php echo $TD ;?></td>
							  	<?php }?>
							  </tr>  
							</table>
						</div>
					</div>

				 </div>
		  <?php } 
		} 
	?>
</div>

<?php anony_get_correct_sidebar();?>