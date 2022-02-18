<?php
/**
 * Frontpage template
 *
 * PHP version 7.3 Or Later
 *
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

$anony_options = ANONY_Options_Model::get_instance();

$grid = $anony_options->posts_grid;

$slider = false;

$revSlider = $anony_options->rev_slider;

$homeSlider = $anony_options->home_slider;

$chooseSlider
	= esc_html__(
		"You didn't choose a slider, Please select one from theme options page"
	);


if ( function_exists( 'putRevSlider' ) && $homeSlider == '1' ) {

	if ( $revSlider != '' ) {

		$slider = ANONY_HELP::obGet( 'putRevSlider', array( $revSlider ) );

	}
}

require locate_template( 'templates/front-page.view.php', false, false );

