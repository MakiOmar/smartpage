<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
// start output buffering at the top of our script with this simple command
// we've added "ob_gzhandler" as a parameter of ob_start
ob_start('ob_gzhandler');

$langAtts    = get_language_attributes();
$contentType = get_bloginfo( 'html_type' );
$charSet     = get_bloginfo( 'charset' );
$bodyClass   = 'class="' . join( ' ', get_body_class() ) . '"';
$logo        = anony_get_custom_logo('orange');
$nav         = anony_navigation('anony-main-menu');

include(locate_template( 'templates/header.view.php', false, false ));
?>
