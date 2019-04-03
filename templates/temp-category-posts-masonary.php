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
		</div><div id="masonary">';
	}else{
		$tcp->sectionWrapperOpen ='<div><div id="masonary">';
	}

	$tcp->sectionWrapperClose ='</div></div>';

	$tcp->postsView();
						
?>