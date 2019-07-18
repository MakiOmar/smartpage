<?php
/**
 * Meta boxes registration
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

//Array of metaboxes to register
$metaBoxes = array(
	'post' => array(
				array(
					'id' => 'smpg_set_featured',
					'title' => esc_html__( 'Set as featured post', TEXTDOM ),
					'context' => 'side',
					'type' => 'checkbox',
					'validate' => 'no_html',
				),
				
			),
	'smpg_download' => array(
							array(
								'id' => 'smpg_download_attachment',
								'title' => esc_html__( 'Upload your attachment', TEXTDOM ),
								'context' => 'normal',
								'type' => 'upload',
								//'validate' => 'no_html',
							),
			),

);

//Custom fields object
$metaboxes = new Class__Custom_Field($metaBoxes);