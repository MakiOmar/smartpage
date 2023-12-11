<?php
/**
 * Template Name: WooCommerce Home
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

get_header();
get_template_part( 'templates/woocommerce-home-content' );
get_footer();
