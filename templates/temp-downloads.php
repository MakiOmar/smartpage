<?php
	$tcp= new Smpg_Generate_Posts_View(
						array('post_type' => 'smpg_download','posts_per_page'=>5),
						'download-loop',
						true
					);

	$tcp->sectionWrapperOpen ='
	<div class="section">
		<div><h4 class="section_title clearfix">'.esc_html__('Suggested downloads',TEXTDOM).'</h4></div>
			<div class="posts-wrapper">
				<div id="download">';

	$tcp->sectionWrapperClose ='</div></div></div>';

	$tcp->postsView();

?>