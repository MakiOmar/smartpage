<?php
/**
 * Frontpage model
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

$anony_options = ANONY_Options_Model::get_instance();

$grid = $anony_options->posts_grid;

$slider = false;

$rev_slider = $anony_options->rev_slider;

$home_slider = $anony_options->home_slider;

$choose_slider
	= __(
		"You didn't choose a slider, Please select one from theme options page"
	);


if ( function_exists( 'putRevSlider' ) && '1' === $home_slider ) {

	if ( '' !== $rev_slider ) {

		$slider = ANONY_HELP::ob_get( 'putRevSlider', array( $rev_slider ) );

	}
}

require locate_template( 'templates/front-page-view.php', false, false );
