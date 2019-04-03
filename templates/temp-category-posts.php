<?php 
/*
	$args = array();

	$p = new WP_Query($args);

	if ( $p->have_posts() ) {
		
		if(is_front_page() or is_home()){?>
		
			<div class="section">
				<div>
					<h4 class="section_title clearfix">
						<?php esc_html_e('Recent Posts','smartpage');?>
					</h4>
				</div>
			
		<?php }else{?>
		
		<div>
		
			<?php }

			while ($p->have_posts() ) {

				$p->the_post();

				get_template_part('templates/temp','blog-post') ;

			}

			wp_reset_postdata();?>
			
	   </div>
	   
<?php  }*/?>


<?php
		$tcp= new Smpg_Generate_Posts_View(
				array('post_type'=>'post'),
				'blog-post',
				true
			);
		if(is_front_page() or is_home()){
			$tcp->sectionWrapperOpen = 
			'<div class="section">
				<div>
					<h4 class="section_title clearfix">'.esc_html__('Recent Posts','smartpage').'
					</h4>
			</div>';
		}else{
			$tcp->sectionWrapperOpen ='<div>';
		}
		
		$tcp->sectionWrapperClose ='</div>';

		$tcp->postsView();
						
?>