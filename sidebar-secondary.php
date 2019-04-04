<div id="secondary-sidebar" class="grid-col-md-4 grid-col">
	  <div class="grid-col-12">
		<ul class="tabs">
		  <li class="active-tab grid-col-6 popular"><?php _e('Popular',TEXTDOM)?></li>
		  <li class="grid-col-6 comments"><?php _e('Recent comments',TEXTDOM)?></li>
		</ul>
		<?php 
		   get_template_part('templates/temp','popular') ;
		   get_template_part('templates/temp','comments') ;
		 ?>	
	  </div>
</div>