<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}


get_header( 'default' );

$data = array();

$pagination = '';

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		$data[] = anony_common_post_data();

	}


	$pagination = anony_pagination();
}

?>

<div class="anony-grid">
  
	<div class="anony-grid-row">
	
		<div class="anony-grid-col">
	  
			<div class="anony-grid-col-sm-9-5 anony-grid-col">

				<div id="anony-standard ?>">

						<div id="anony-blog-post" class="anony-grid-row">

						<?php
						foreach ( $data as $p ) :
							extract( $p );

							include locate_template( 'templates/blog-post-view.php', false, false );

						endforeach;
						?>

						</div>

				</div>

			<?php echo $pagination; ?>

			</div>
	  
				<?php get_sidebar( 'default' ); ?>
	 
		</div>
	
	</div>
	 
</div>

<?php get_footer( 'default' ); ?>
