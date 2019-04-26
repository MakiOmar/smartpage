 <div class="grid-col-sm-2-5 asidebar">
	<?php  
		if (is_active_sidebar('right-sidebar')){
		   dynamic_sidebar('right-sidebar');
		}else{
			$url = get_bloginfo('url').'/wp-admin/widgets.php';
			printf(__( '<strong>Please add some widgets.</strong><a href="%s"> Add Here</a>', TEXTDOM ),esc_url($url));
		}
		//get_template_part('templates/newsletters') ;
	?>
</div>