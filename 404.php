<?php
/**
 * 404 template
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
$anony_options = ANONY_Options_Model::get_instance();
?>

<main class="anony-content anony-flex flex-h-center flex-v-center"></main>

<?php get_footer(); ?>
