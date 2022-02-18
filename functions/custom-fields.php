<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
/**
 * Meta boxes registration
 *
 * @package Anonymous Meta box
 * @author  Makiomar
 * @link    http://makiomar.com
 */


// Array of metaboxes to register
add_filter(
	'anony_metaboxes',
	function ( $metaboxes ) {
		$metaboxes[] =
		array(
			'id'            => 'anony_download', // Meta box ID
			'title'         => esc_html__( 'Downloads', 'smartpage' ),
			'context'       => 'normal',
			'priority'      => 'high', // high|low
			'hook_priority' => '10', // Default 10
			'post_type'     => array( 'anony_download' ),
			'fields'        =>
					array(
						array(
							'id'       => 'anony_download_attachment',
							'title'    => esc_html__( 'Download file', 'smartpage' ),
							'type'     => 'file_upload',
							'validate' => 'no_html',
						),
					),
		);

		return $metaboxes;
	}
);
