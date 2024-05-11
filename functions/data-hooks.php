<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
add_action(
	'anony_before_inculde_single',
	function ( $data, $post_type ) {
		switch ( $post_type ) {
			case 'anony_download':
				wp_enqueue_script( 'anony-download' );
				break;

			default:
				break;
		}
	},
	10,
	2
);

add_filter(
	'anony_download_loop_data',
	function ( $temp, $ID ) {

		$temp['date'] = explode( ' ', get_the_date() );

		$curr_download_meta = get_post_meta( $ID, 'anony_download', true );

		$download_times = 0;

		if ( $curr_download_meta && $curr_download_meta != '' ) {
			$curr_download = $curr_download_meta['anony_download_attachment'];

			$get_url = wp_get_attachment_url( intval( $curr_download ) );

			$file_url = $get_url ? esc_url( $get_url ) : flase;

			if ( $file_url ) {
				$temp['file_url'] = $file_url;
			}

			if ( isset( $curr_download_meta['download_times'] ) && ! empty( $curr_download_meta['download_times'] ) ) {
				$download_times = $curr_download_meta['download_times'];
			}
		}

		$temp['download_times'] = $download_times;

		$terms = get_the_terms( $ID, 'anony_download_type' );

		$temp['terms'] = array();

		if ( $terms && ! is_wp_error( $terms ) ) {

			foreach ( $terms as $term ) {

				$temp['terms'][] = array(
					'name' => esc_html( $term->name ),
					'url'  => esc_url( get_term_link( $term->term_id, 'anony_download_type' ) ),
				);
			}
		}

		$temp['download_text'] = esc_html__( 'Download', 'smartpage' );

		ob_start();

		get_template_part( 'models/rate' );

		$temp['rating'] = ob_get_clean();

		ob_start();

		comments_template( '', true );

		$temp['comments_template'] = ob_get_clean();

		return $temp;
	},
	10,
	2
);
/**
 * Filter content to render device specific content only.
 *
 * @param string $content Page content.
 * @return string
 */
function anony_blocks_device_based_render( $content ) {
	$remove  = wp_is_mobile() ? 'desktop' : 'mobile';
	$pattern = '/<!--\s*wp:' . $remove . '\s*-->(.*?)<!--\s*\/wp:' . $remove . '\s*-->/is';
	$content = preg_replace( $pattern, '', $content );

	return $content;
}
add_filter( 'the_content', 'anony_blocks_device_based_render' );
