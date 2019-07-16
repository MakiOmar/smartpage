<span class="toggle-sidebar"><i class="fa fa-arrow-down"></i></span>
<div class="grid-col-sm-2-5 asidebar single-sidebar">
	<?php  
		if (is_active_sidebar('left-sidebar')){
		   dynamic_sidebar('left-sidebar');
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
	?>
</div>