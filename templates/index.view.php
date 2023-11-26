<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}

get_header();
$anony_options = ANONY_Options_Model::get_instance();
?>

<div class="anony-grid">
  
	<div class="anony-grid-row">
	
		<div class="anony-grid-col">
	 
			<?php
			if ( $anony_options->sidebar == 'left-sidebar' ) {
				get_sidebar();
			}
			?>
	  
			<div class="anony-grid-col-sm-9-5 anony-grid-col">

				<div id="anony-<?php echo $grid; ?>">

						<div id="anony-blog-post" class="anony-grid-row">

						<?php
						foreach ( $data as $p ) :
							extract( $p );

							include locate_template( 'templates/blog-post.view.php', false, false );

						endforeach;
						?>

						</div>

				</div>

			<?php echo $pagination; ?>

			</div>
	  
			  <?php
				if ( $anony_options->sidebar == 'right-sidebar' ) {
					get_sidebar();
				}
				?>
	 
		</div>
	
	</div>
	 
</div>

<?php get_footer(); ?>
