<?php
if (! defined('ABSPATH') ) {
    exit; // Exit if accessed direct.ly
}

$title       = esc_html__('News letter', 'smartpage');
$subtitle    = esc_html__('Receive news notifications', 'smartpage');
$placeholder = esc_html__('&#xf090; Email Adress', 'smartpage');
$buttonText  = esc_html__('SUBSCRIBE', 'smartpage');

require locate_template('templates/newsletter-view.php', false, false);
?>
