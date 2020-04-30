<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div id="post-<?= $id?>" class="anony-post-wrapper anony-grid-col-max-480-12 anony-grid-col-av-12 anony-grid-col-md-6 anony-grid-col">
	
	<div class="anony-post-contents anony-blog-post anony-grid-col">
  
	  	<div class="anony-post-info">
	  
		    <?php if( $thumb && $thumb_exists ){
		
				include(locate_template( 'templates/post-layout/post-with-thumb.php', false, false ));
		
			}else{
		
				include(locate_template( 'templates/post-layout/post-without-thumb.php', false, false ));
		
			}?>
			
			<div class="anony-extra-metas">
			
				<div class="anony-author-avatar">
				
					<?= $gravatar ?>
					
				</div>
				
				<div class="author-name">
				
					<span><?= $author?></span>
					
				</div>
				
				<div>
				
					<a class="button anony-button" href="<?= $permalink ?>"><?= $read_more ?></a>
					
				</div>
				
			</div>
		
		</div>
		
	</div>
  
</div>