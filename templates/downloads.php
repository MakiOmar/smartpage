<?php
	$tcp= new ANONY_Generate_Posts_View(
						array('post_type' => 'anony_download','posts_per_page'=>5),
						'downloads',
						true
					);

	$tcp->postsView();

?>