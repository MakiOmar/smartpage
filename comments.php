<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if ( post_password_required() ) return;

$data = [
	'have_comments'   => have_comments(),
	'comments_number' => sprintf( 
							_nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', ANONY_TEXTDOM ), 
							number_format_i18n( get_comments_number() ) 
						),

	'comments' => wp_list_comments( 
		[ 
			'echo'=> false ,
			'avatar_size'=>'64',
			'format'=>'xhtml',
			'style' => 'div'
		] 
	),

	'comments_open' => comments_open(),
	'comments_off_text' => esc_html__( 'Comments off' , ANONY_TEXTDOM ),

];

extract($data);

include(locate_template( 'templates/comments-single.view.php', false, false ));
?>