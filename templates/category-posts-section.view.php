<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}?>	
<div class="anony-section">
	<div>
		<h4 class="anony-section_title clearfix"><?= $title ?></h4>
	</div>

	<div id="anony-<?= $grid ?>">

		<div id="anony-blog-post">

			<?php 
			foreach ($data as $p) : extract($p);
	

				include(locate_template( 'templates/blog-post.view.php', false, false )); 

			endforeach
			?>

		</div>

	</div>
</div>
						