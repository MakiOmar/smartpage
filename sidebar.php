<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/*
*Main sidebar
*/

?>
<div class="anony-grid-col anony-grid-col-sm-2-5 anony-asidebar">
	<?php  
		if (is_active_sidebar('right-sidebar')){
		   dynamic_sidebar('right-sidebar');
		}else{
			$url = get_home_url().'/wp-admin/widgets.php';
			$allowed_tags = array('strong'=> array(), 'a' => array('href'=> array()));
			printf(
				wp_kses(
						__( '<strong>Please add some widgets.</strong><a href="%s"> Add Here</a>', ANONY_TEXTDOM ), 
						$allowed_tags
					),
				esc_url($url)
			);
		}
		get_template_part('templates/newsletters') ;
	?>
</div>