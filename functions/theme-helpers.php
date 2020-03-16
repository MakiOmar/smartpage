<?php
if (!function_exists('anonyOpt')) {
	/**
	 * instantiate options object
	 * @param  string $optName Options name in DB
	 * @return object
	 */
	function anonyOpt($optGroup = 'Anony_options'){
		if (class_exists('ANONY_Options_Model')) return ANONY_Options_Model::get_instance($optGroup);
		return new stdClass();
	}
}

if (!function_exists('anonyGetOpt')) {
	/**
	 * Get option value from an options group 
	 * @param object $optObject Object of ANONY_Options_Model
	 * @param string $optName   Option 
	 * @return type
	 */
	function anonyGetOpt($optObject, $optName , $notSet = ''){
		if(isset($optObject->$optName)) return $optObject->$optName;
		return $notSet;
	}
}

/**
 * Desides which sidebar to load according to page direction
 * @return void
 */
function anony_get_correct_sidebar(){
	$anonyOptions = anonyOpt();

	if(anonyGetOpt($anonyOptions, 'sidebar') == 'left-sidebar'){
		get_sidebar();
	}elseif(anonyGetOpt($anonyOptions, 'single_sidebar') == '1'){
		get_sidebar('single');
	}
}