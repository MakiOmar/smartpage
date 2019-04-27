<?php
	$news= new Smpg__Generate_Posts_View(
						array('post_type' => 'smpg_news','posts_per_page'=>5),
						'news',
						true
					);

	$news->postsView();
?>