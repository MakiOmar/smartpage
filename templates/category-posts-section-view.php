<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}?>    
<div class="anony-section white-bg">
	<div class="anony-skew-bg">
		<h4 class="anony-section_title"><?php echo $title; ?></h4>
	</div>

	<div id="anony-<?php echo $grid; ?>">

		<div id="anony-blog-post" class="anony-grid-row">

			<?php
			foreach ( $data as $p ) :
				extract( $p );


				include locate_template( 'templates/blog-post-view.php', false, false );

			endforeach
			?>

		</div>

	</div>
</div>
						
