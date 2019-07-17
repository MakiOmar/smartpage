<?php
	$tcp= new Class__Generate_Posts_View(
						array('post_type' => 'smpg_download','posts_per_page'=>5),
						'downloads',
						true
					);

	$tcp->postsView();

?>