<?php

/**
 * Desides which sidebar to load according to page direction
 * @return void
 */
function anony_get_correct_sidebar(){
	global $anonyOptions;

	if($anonyOptions->sidebar == 'left-sidebar'){
		get_sidebar();
	}elseif($anonyOptions->single_sidebar == '1'){
		get_sidebar('single');
	}
}