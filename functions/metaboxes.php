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

add_action('admin_init', function(){
	$metaBoxes = array(
		'id'            => 'anony-post-meta',//Meta box ID
		'label'         => esc_html__( 'Anonymous custom fields', TEXTDOM ),
		'context'       => 'normal',
		'priority'      =>  'high', // high|low
        'hook_priority' =>  '10', // Default 10
		'post_type'     => array('anony_download'),
		'fields'        => array(
								array(
									'id'       => 'anony__upload_attachment',
									'label'    => esc_html__( 'Upload attachment', TEXTDOM ),
									'type'      => 'upload',
									'validate'  => 'url|file_type:pdf,doc,docx,7z,arj,deb,zip,iso,pkg,rar,rpm,z,gz,bin,dmg,toast,vcd,csv,dat,log,mdb,sav,tar,ods,xlr,xls,xlsx,odt,txt,rtf,tex,wks,wps,wpd',
								),
								array(
									'id'       => 'anony__test_post_text',
									'label'    => esc_html__( 'Test post text', TEXTDOM ),
									'type'     => 'text',
									'validate' => 'number',
								),
		
								array(
									'id'       => 'anony__test_post_checkbox',
									'label'    => esc_html__( 'Test post checkbox', TEXTDOM ),
									'type'     => 'checkbox',
									'validate' => 'no_html',
								),
								array(
									'id'       => 'anony__test_post_textarea',
									'label'    => esc_html__( 'Test post textarea', TEXTDOM ),
									'type'     => 'textarea',
									'validate' => 'no_html',
								),
								array(
									'id'       => 'anony__test_post_color',
									'label'    => esc_html__( 'Test post color', TEXTDOM ),
									'type'     => 'color',
									'validate' => 'hex_color',
									'default' => '#222',
								),
								array(
									'id'       => 'anony__test_post_wysiwyg',
									'label'    => esc_html__( 'Test post wysiwyg', TEXTDOM ),
									'type'     => 'wysiwyg',
									'validate' => 'html',
									'options'  => array('drag_drop_upload' => true),
								),
								array(
									'id'           => 'anony__test_post_select',
									'label'        => esc_html__( 'Test post select', TEXTDOM ),
									'type'         => 'select',
									'validate'     => 'multiple_options',
									'multiple'     => true,
									'autocomplete' => 'off',
									'options'      => array(
														'1' => 'a',
														'2' => 'b',
														'3' => 'c',
													),
									'default'      => '2',
									
								),
								array(
									'id'           => 'anony__test_post_select_single',
									'label'        => esc_html__( 'Test post select single', TEXTDOM ),
									'type'         => 'select',
									'validate'     => 'no_html',
									'autocomplete' => 'off',
									'options'      => array(
														'1' => 'a',
														'2' => 'b',
														'3' => 'c',
													),
									'default'      => '1',
									
								),

							),
	);
	
	//Custom fields object
	$postMetaboxes = new Class__Custom_Field($metaBoxes);
});