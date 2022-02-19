<?php
/**
 * Comments template
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined( 'ABSPATH' ) || die(); // Exit if accessed direct.
if ( post_password_required() ) {
	return;
}

$data = array(
	'have_comments'     => have_comments(),
	'comments_number'   => sprintf(
		_nx(
			'One Comment',
			'%1$s Comments',
			get_comments_number(),
			'comments title',
			'smartpage'
		),
		number_format_i18n( get_comments_number() )
	),

	'comments'          => wp_list_comments(
		array(
			'echo'        => false,
			'avatar_size' => '64',
			'format'      => 'xhtml',
			'style'       => 'div',
		)
	),

	'comments_open'     => comments_open(),
	'comments_off_text' => esc_html__( 'Comments off', 'smartpage' ),

);

extract( $data );
wp_enqueue_script( 'jquery.validate.min' );
wp_enqueue_script( 'anony-ajax_comment' );
require locate_template( 'templates/comments-single.view.php', false, false );

