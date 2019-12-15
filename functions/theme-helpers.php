<?php

/**
 * Desides which sidebar to load according to page direction
 * @return void
 */
function anony_get_correct_sidebar(){
	$anonyOptions = anony_opts_();

	if($anonyOptions->sidebar == 'left-sidebar'){
		get_sidebar();
	}elseif($anonyOptions->single_sidebar == '1'){
		get_sidebar('single');
	}
}