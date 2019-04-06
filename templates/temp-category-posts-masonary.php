<?php
$FreaturedCat = get_category_by_slug('featured-posts');

	$tcp= new Smpg_Generate_Posts_View(
			array(
				'post_type'=>'post',
				'category__not_in' => $FreaturedCat->term_id,
			),
			'blog-post',
			true
		);
	if(is_front_page() or is_home()){
		$tcp->sectionWrapperOpen = 
		'<div class="section">
			<div>
				<h4 class="section_title clearfix">'.esc_html__('Recent Posts',TEXTDOM).'
				</h4>
		</div><div id="masonary">';
	}else{
		$tcp->sectionWrapperOpen ='<div><div id="masonary">';
	}

	$tcp->sectionWrapperClose ='</div></div>';

	$tcp->postsView();
						
?>