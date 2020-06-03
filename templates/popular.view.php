<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div id="anony-popular" class ="anony-tab_content">
			
	<?php foreach ($data as $p) : extract($p)?>
		
		<div id="anony-popular-<?= $id ?>" class="anony-posts-list-wrapper">
		
			<?php if($thumb && $thumb_exists){?>
			
				<div class="anony-posts-list-thumb">
					<?= $thumb_img  ?>	
				</div>
				
			<?php } ?>
			
				<div class="anony-posts-list">
				
					<div>
						  <h3><a href="<?= $permalink ?>"><?= $title ?></a></h3> 
					</div>
					
					<div class="anony-metadata"><i class="fa fa-calendar"></i>&nbsp;<?= $date ?></div>
					<div class="anony-metadata"><i class="fa fa-eye"></i>&nbsp;<?= $views ?></div>
					
					<?php get_template_part('models/rate') ?>
					
				</div>
				
		</div>	

	<?php endforeach ?>
		
</div>