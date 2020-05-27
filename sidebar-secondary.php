<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/*
*This is the sidebar in the featured section
*/

?>
<div id="anony-secondary-sidebar" class="anony-grid-col-md-4 anony-grid-col">
	  <div class="anony-grid-col-12 white-bg">
		<ul class="tabs">
		  <li class="anony-active-tab anony-grid-col-6 anony-popular" rel-id="anony-popular"><?php esc_html_e('Popular',ANONY_TEXTDOM)?></li>
		  <li class="anony-grid-col-6 comments" rel-id="anony-comments"><?php esc_html_e('Recent comments',ANONY_TEXTDOM)?></li>
		</ul>
		<?php 
		   get_template_part('controllers/popular') ;
		   get_template_part('templates/latest-comments') ;
		 ?>	
	  </div>
</div>