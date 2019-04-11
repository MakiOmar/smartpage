<?php
	$tn= new Smpg__Generate_Posts_View(
						array('post_type' => 'smpg_news','posts_per_page'=>5),
						'news-loop',
						true
					);
	$tn->beforeSection  = '<div id="didyouknow" class="group">';

	$tn->beforeSection .= '<p id="dun-title">'.esc_html__('Simple Info',TEXTDOM).'</p>';

	$tn->beforeSection .= get_search_form(false);

	$tn->beforeSection .= '</div>';

	$tn->sectionWrapperOpen ='
	<div id="dun-text">
		<div id="dun_text_wrapper"'.(is_rtl() ? ' class="is-rtl"' : '').'>';

	$tn->sectionWrapperClose ='</div></div>';

	$tn->IfNot = '<div id="didyouknow" class="group search-only">';

	$tn->IfNot .= get_search_form(false);

	$tn->IfNot .= '</div>';

	$tn->postsView();

?>