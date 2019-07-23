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
					'id'       => 'anony_set_featured',
					'title'    => esc_html__( 'Set as featured post', TEXTDOM ),
					'context'  => 'side',
					'type'     => 'checkbox',
					'validate' => 'no_html',
				),
				
			),
	'anony_download' => array(
							array(
								'id'        => 'anony_download_attachment',
								'title'     => esc_html__( 'Upload your attachment', TEXTDOM ),
								'context'   => 'normal',
								'type'      => 'upload',
								'validate'  => 'url',
								'supported' => array('pdf','doc','docx','7z','arj','deb','zip','iso','pkg','rar','rpm','z','gz','bin','dmg','toast','vcd','csv','dat','log','mdb','sav','tar','ods','xlr','xls','xlsx','odt','txt','rtf','tex','wks','wps','wpd'),
							),
			),

);

//Custom fields object
$metaboxes = new Class__Custom_Field($metaBoxes);