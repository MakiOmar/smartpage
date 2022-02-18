<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();?>

<div class="anony-grid">
  
	<div class="anony-grid-row">
	
		<div class="anony-grid-col">
	 
			<?php
			if ( $anonyOptions->sidebar == 'left-sidebar' ) {
				get_sidebar();
			}
			?>
	  
			<div class="anony-grid-col-sm-9-5 anony-grid-col">

				<div id="anony-<?php echo $grid; ?>">

						<div id="anony-blog-post">

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
				if ( $anonyOptions->sidebar == 'right-sidebar' ) {
					get_sidebar();
				}
				?>
	 
		</div>
	
	</div>
	 
</div>

<?php get_footer(); ?>
