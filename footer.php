<?php
/**
 * Footer template
 *
 * PHP version 7.3 Or Later
 *
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined( 'ABSPATH' ) or die(); // Exit if accessed direct

$anony_options = ANONY_Options_Model::get_instance();

$copyright = esc_html( $anony_options->copyright );

$ajaxUrl = ANONY_WPML_HELP::getAjaxUrl();

$footer_ad = has_action( 'footer_ad' );

require locate_template( 'templates/footer.view.php', false, false );

