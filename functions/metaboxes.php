<?php
/**
 * Meta boxes registration
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

//Array of metaboxes to register
//id should be equal to title without the anony__ and underscores
$metaBoxes = array(
	'post' => array(
				array(
					'id'       => 'anony__set_as_featured',
					'title'    => esc_html__( 'Set as featured', TEXTDOM ),
					'context'  => 'side',
					'type'     => 'checkbox',
					'validate' => 'no_html',
				),
				
			),
	'anony_download' => array(
				array(
					'id'        => 'anony__upload_attachment',
					'title'     => esc_html__( 'Upload attachment', TEXTDOM ),
					'context'   => 'normal',
					'type'      => 'upload',
					'validate'  => 'url|file_type:pdf,doc,docx,7z,arj,deb,zip,iso,pkg,rar,rpm,z,gz,bin,dmg,toast,vcd,csv,dat,log,mdb,sav,tar,ods,xlr,xls,xlsx,odt,txt,rtf,tex,wks,wps,wpd',

				),
				array(
					'id'        => 'anony__some_text',
					'title'     => esc_html__( 'Some text', TEXTDOM ),
					'context'   => 'normal',
					'type'      => 'text',
					'validate'  => 'number',

				),
			),

);

//Custom fields object
$metaboxes = new Class__Custom_Field($metaBoxes);