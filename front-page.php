<?php 

$anonyOptions = ANONY_Options_Model::get_instance();

$grid = $anonyOptions->posts_grid;

$slider = false;

$revSlider = $anonyOptions->rev_slider;

$homeSlider = $anonyOptions->home_slider;

$chooseSlider = esc_html__("You didn't choose a slider, Please select one from theme options page");

	
if(function_exists('putRevSlider') && $homeSlider == '1'){
	
	if($revSlider != ''){
		
		$slider = ANONY_HELP::obGet('putRevSlider', [$revSlider]);
		
	}
}
	
include(locate_template( 'templates/front-page.view.php', false, false ));
?>
