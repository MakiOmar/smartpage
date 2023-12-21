<?php
/**
 * Footer template
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

if ( ! defined( 'ANOENGINE' ) ) {
	require_once 'footer-default.php';
} else {
	require locate_template( 'templates/footer-view.php', false, false );
}
