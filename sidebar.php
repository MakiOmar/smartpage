<?php

/*
*Main sidebar
*/

?>
<div class="grid-col-sm-2-5 asidebar">
	<?php  
		if (is_active_sidebar('right-sidebar')){
		   dynamic_sidebar('right-sidebar');
		}else{
			$url = get_home_url().'/wp-admin/widgets.php';
			$allowed_tags = array('strong'=> array(), 'a' => array('href'=> array()));
			printf(
				wp_kses(
						__( '<strong>Please add some widgets.</strong><a href="%s"> Add Here</a>', TEXTDOM ), 
						$allowed_tags
					),
				esc_url($url)
			);
		}
		get_template_part('templates/newsletters') ;
	?>
</div>