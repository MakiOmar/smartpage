<?php
/**
 * AJAX Functions
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

// wp_ajax_{action} for registered user
add_action( 'wp_ajax_anony_ajax_comments', 'anony_submit_ajax_comment' );

// wp_ajax_nopriv_{action} for not registered users
add_action( 'wp_ajax_nopriv_anony_ajax_comments', 'anony_submit_ajax_comment' );

/**
 * AJAX comment submit
 *
 * **Description: **Inserts new comment and and respond with a JSON object contains the comment markup, comment ID and comments count
 * @return void
 */
function anony_submit_ajax_comment(){
	$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );

	if ( is_wp_error( $comment ) ) {

		$data = intval( $comment->get_error_data() );

		if ( ! empty( $data ) ) {

			wp_die(
				'<p>' . $comment->get_error_message() . '</p>',
				__( 'Comment Submission Failure' ),
				array(
					'response'  => $data,
					'back_link' => true,
				)
			);

		} else {

			exit;

		}
	}

	$user            = wp_get_current_user();

	$cookies_consent = ( isset( $_POST['wp-comment-cookies-consent'] ) );


	/**
	 * Perform other actions when comment cookies are set..
	 */

	do_action( 'set_comment_cookies', $comment, $user, $cookies_consent );
	/*
	 * If you do not like this loop, pass the comment depth from JavaScript code
	 */
	$comment_depth = 1;
	$comment_parent = $comment->comment_parent;
	while( $comment_parent ){
		$comment_depth++;
		$parent_comment = get_comment( $comment_parent );
		$comment_parent = $parent_comment->comment_parent;
	}

	$maxNOcomments = get_option( 'thread_comments_depth' );

	$commentsCount = wp_count_comments( $comment->comment_post_ID )->approved;
	/*
	 * Set the globals, so our comment functions below will work correctly
	 */
	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $comment_depth;

	$comment_html = '<div ' . comment_class('', null, null, false ) . ' id="comment-' . $comment->comment_ID . '">			

			<div class="anony-comment-author vcard">
				' . get_avatar( $comment, 64 ) .
				sprintf( __( '%s <span class="says">says:</span>' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link( $comment ) )).'
			</div>

			<div class="anony-comment-metadata">
				<a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' . sprintf( esc_html__( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() ) . '</a> ';

				if( $edit_link = get_edit_comment_link() )
					$comment_html .= '<span class="edit-link"><a class="anony-comment-edit-link" href="' . $edit_link . '">'.esc_html__('Edit', TEXTDOM).'</a></span>';

			$comment_html .= '</div>';

			if ( $comment->comment_approved == '0' )
				$comment_html .= '<p class="anony-comment-awaiting-moderation">'.esc_html__('Your comment is awaiting moderation.', TEXTDOM).'</p>';

		$comment_html .= '<div class="anony-comment-content">' . apply_filters( 'comment_text', get_comment_text( $comment ), $comment ) . '</div>';

		if($maxNOcomments > $comment_depth){
			$comment_html .= '<div class="reply">'.get_comment_reply_link( array('depth' => $comment_depth,'max_depth'     => $maxNOcomments), $comment , '' ).'</div>';
		}else{
			$comment_html .= '<p class="limit-reach">'.sprintf(esc_html__('A Max number of %s threads has been reached'),$maxNOcomments).'<p>';
		}

		$comment_html .= '</div>';



	$return = array(
		'html'          => $comment_html,
		'comment_id'    => $comment->comment_ID,
		'comment_count' => $commentsCount,
		'resp'          => '',
		);

	wp_send_json($return);

	wp_die();
}