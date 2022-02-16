<?php
/**
 * Theme single template
 * 
 * PHP version 7.3 Or Later
 * 
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
!defined('ABSPATH') or die(); // Exit if accessed directly

$anonyOptions = ANONY_Options_Model::get_instance();

$wrapper_class = ($anonyOptions->single_sidebar == '1') ? 'anony-grid-col-sm-7' : 'anony-grid-col-sm-9-5' ;

$post_type = get_post_type();

$data = [];

if (have_posts() ) {
    
    while (have_posts() ) { 
        the_post();
        $data = anony_common_post_data(get_post_type());
    }
}

$right_sidebar = is_rtl() ? 'right' : 'left' ;

$left_sidebar  = is_rtl() ? 'left'  : 'right' ;

if (empty($data)) { return;
}

extract($data);

do_action('anony_before_inculde_single', $data,  $post_type);


require locate_template('template-parts/single-post/'.get_post_type().'.php', false, false);
