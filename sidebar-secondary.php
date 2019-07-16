<?php

/*
*This is the sidebar in the featured section
*/

?>
<div id="secondary-sidebar" class="grid-col-md-4 grid-col">
	  <div class="grid-col-12">
		<ul class="tabs">
		  <li class="active-tab grid-col-6 popular"><?php esc_html_e('Popular',TEXTDOM)?></li>
		  <li class="grid-col-6 comments"><?php esc_html_e('Recent comments',TEXTDOM)?></li>
		</ul>
		<?php 
		   get_template_part('templates/popular') ;
		   get_template_part('templates/comments') ;
		 ?>	
	  </div>
</div>