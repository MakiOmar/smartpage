<?php
	$news= new ANONY_Generate_Posts_View(
						array('post_type' => 'anony_news','posts_per_page'=>5),
						'news',
						true
					);

	$news->postsView();
?>