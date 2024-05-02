<?php
/**
 * AJAX Functions
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'wp_ajax_anony_ajax_comments', 'anony_submit_ajax_comment' );
add_action( 'wp_ajax_nopriv_anony_ajax_comments', 'anony_submit_ajax_comment' );

/**
 * AJAX comment submit
 *
 * **Description: **Inserts new comment and and respond with a JSON object contains the comment markup, comment ID and comments count
 *
 * @return void
 */
function anony_submit_ajax_comment() {
	if ( ! isset( $_POST['anony_comment_nonce'] ) || ( isset( $_POST['anony_comment_nonce'] ) && ! wp_verify_nonce( 'anony_comment_nonce', sanitize_text_field( wp_unslash( $_POST['anony_comment_nonce'] ) ) ) ) ) {
		return;
	}
	$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );

	if ( is_wp_error( $comment ) ) {

		$data = intval( $comment->get_error_data() );

		if ( ! empty( $data ) ) {

			wp_die(
				'<p><?= $comment->get_error_message() ?></p>',
				esc_html__( 'Comment Submission Failure', 'smartpage' ),
				array(
					'response'  => esc_html( $data ),
					'back_link' => true,
				)
			);

		} else {

			exit;

		}
	}

	$user = wp_get_current_user();

	$cookies_consent = ( isset( $_POST['wp-comment-cookies-consent'] ) );

	/**
	 * Perform other actions when comment cookies are set..
	 */

	do_action( 'set_comment_cookies', $comment, $user, $cookies_consent );
	/**
	 * If you do not like this loop, pass the comment depth from JavaScript code
	 */
	$comment_depth  = 1;
	$comment_parent = $comment->comment_parent;
	while ( $comment_parent ) {
		++$comment_depth;
		$parent_comment = get_comment( $comment_parent );
		$comment_parent = $parent_comment->comment_parent;
	}

	$max_no_comments = get_option( 'thread_comments_depth' );

	$comments_count = wp_count_comments( $comment->comment_post_ID )->approved;
	/**
	 * Set the globals, so our comment functions below will work correctly.
	 */
	//phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited
	$GLOBALS['comment']       = $comment;
	$GLOBALS['comment_depth'] = $comment_depth;
	//phpcs:enable.

	$comment_class = comment_class( '', null, null, false );
	$avatar        = get_avatar( $comment, 64 );
	$author_link   = get_comment_author_link( $comment );
	$comment_link  = esc_url( get_comment_link( $comment->comment_ID ) );
	// Translators: %1$s date, %2$s time.
	$when_text        = sprintf( esc_html__( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() );
	$edit_link        = get_edit_comment_link();
	$edit_text        = esc_html__( 'Edit', 'smartpage' );
	$comment_approved = $comment->comment_approved;
	$waiting_approve  = esc_html__( 'Your comment is awaiting moderation', 'smartpage' );
	$comment_text     = apply_filters( 'comment_text', get_comment_text( $comment ), $comment );
	$reply_link       = get_comment_reply_link(
		array(
			'depth'     => $comment_depth,
			'max_depth' => $max_no_comments,
		),
		$comment,
		''
	);
	// Translators: Threads cound.
	$limit_reached_text = sprintf( esc_html__( 'A Max number of %s threads has been reached', 'smartpage' ), $max_no_comments );
	$says               = esc_html__( 'says:' );

	ob_start();

	include locate_template( 'templates/ajax-comment-view.php', false, false );

	$comment_html = ob_get_clean();

	$return = array(
		'html'          => $comment_html,
		'comment_id'    => $comment->comment_ID,
		'comment_count' => $comments_count,
		'resp'          => '',
	);

	wp_send_json( $return );

	die();
}
