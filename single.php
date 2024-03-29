<?php
/**
 * Theme single template
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined( 'ABSPATH' ) || die(); // Exit if accessed direct.ly

$anony_options = ANONY_Options_Model::get_instance();

if ( 'no-sidebar' === $anony_options->sidebar ) {
    $wrapper_class = '';
}else{
    $wrapper_class = ( $anony_options->single_sidebar == '1' ) ? 'anony-grid-col-sm-7' : 'anony-grid-col-sm-9-5';
}

$post_type = get_post_type();

$data = array();

if ( have_posts() ) {

    while ( have_posts() ) {
        the_post();
        $data = anony_common_post_data( get_post_type() );
    }
}

$right_sidebar = is_rtl() ? 'right' : 'left';

$left_sidebar = is_rtl() ? 'left' : 'right';

if ( empty( $data ) ) {
    return;
}

extract( $data );

do_action( 'anony_before_inculde_single', $data, $post_type );

if( in_array( get_post_type(), array( 'anony_download', 'elementor_library' ) ) )
{
    require locate_template( 'template-parts/single-post/' . get_post_type() . '.php', false, false );
}else{
    require locate_template( 'template-parts/single-post/post.php', false, false );
}