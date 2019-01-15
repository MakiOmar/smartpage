<?php 
	$args = array('post_type'=>'post');
	$p = new WP_Query($args);
	if ( $p->have_posts() ) {
		if(is_front_page() or is_home()){?>
			<div class="section"><div><h4 class="section_title clearfix"><?php _e('Recent Posts','smartpage');?></h4></div><div id="masonary">
		<?php }else{?>
		<div><div id="masonary">
		<?php }
		while ($p->have_posts() ) {
			$p->the_post();
			get_template_part('templates/temp','blog-post') ;
		}
		wp_reset_postdata();
		?>
   </div>
	   </div>
<?php  }

?>