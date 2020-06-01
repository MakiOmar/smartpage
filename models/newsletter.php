<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$title       = esc_html__( 'News letter' , ANONY_TEXTDOM );
$subtitle    = esc_html__( 'Receive news notifications' , ANONY_TEXTDOM );
$placeholder = esc_html__( '&#xf090; Email Adress' , ANONY_TEXTDOM );
$buttonText  = esc_html__( 'SUBSCRIBE' , ANONY_TEXTDOM );

include(locate_template( 'templates/newsletter.view.php', false, false ));
?>
