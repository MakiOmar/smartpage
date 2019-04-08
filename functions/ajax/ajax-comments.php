<?php
	add_action( 'wp_ajax_smpg_ajax_comments', 'smpg_submit_ajax_comment' ); // wp_ajax_{action} for registered user
	add_action( 'wp_ajax_nopriv_smpg_ajax_comments', 'smpg_submit_ajax_comment' ); // wp_ajax_nopriv_{action} for not registered users
	function smpg_submit_ajax_comment(){
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
		
		//Check if comments will be held for moderation
		if(get_option('comment_moderation' === true)){
			//do something
		}
		
		$return = array(
            'resp'  => '',
            );

		wp_send_json($return);

		wp_die();
	}