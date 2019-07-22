<?php

/*
*This is the sidebar in the featured section
*/

?>
<div id="anony-secondary-sidebar" class="anony-grid-col-md-4 anony-grid-col">
	  <div class="anony-grid-col-12">
		<ul class="tabs">
		  <li class="anony-active-tab anony-grid-col-6 anony-popular"><?php esc_html_e('Popular',TEXTDOM)?></li>
		  <li class="anony-grid-col-6 comments"><?php esc_html_e('Recent comments',TEXTDOM)?></li>
		</ul>
		<?php 
		   get_template_part('templates/popular') ;
		   get_template_part('templates/comments') ;
		 ?>	
	  </div>
</div>