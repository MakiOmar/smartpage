<?php
/**
 * Meta boxes registration
 *
 * @package Anonymous Meta box
 * @author Makiomar
 * @link http://makiomar.com
 */

//Array of metaboxes to register
//id should be equal to title without the anony__ and underscores

add_action('admin_init', function(){
	$transmission_line = array(
		/*Any meta box ID should start with anony-meta- to have correct style*/
		'id'            => 'anony-tranasmission-line-details',//Meta box ID
		'title'         => esc_html__( 'Tranasmission line Details', ANONY_TEXTDOM ),
		'context'       => 'normal',
		'priority'      =>  'high', // high|low
        'hook_priority' =>  '10', // Default 10
		'post_type'     => array('transmission_line'),
		'fields'        => array(
								array(
									'id'       => 'anony__line_title',
									'title'    => esc_html__( 'Line title', ANONY_TEXTDOM ),
									'type'     => 'text',
									'validate' => 'no_html',
								),
								array(
									'id'       => 'anony__line_capcity',
									'title'    => __( 'Line Capcity (m<sup>3</sup>/day)', ANONY_TEXTDOM ),
									'type'     => 'text',
									'validate' => 'no_html',
								),
								array(
									'id'       => 'anony__line_const_year',
									'title'    => __( 'Line construction year', ANONY_TEXTDOM ),
									'type'     => 'text',
									'validate' => 'no_html',
								),
								array(
									'id'       => 'anony__line_length',
									'title'    => esc_html__( 'Line length (km)', ANONY_TEXTDOM ),
									'type'     => 'text',
									'validate' => 'number',
								),
								array(
									'id'       => 'anony__line_diameter',
									'title'    => esc_html__( 'Line diameter (mm)', ANONY_TEXTDOM ),
									'type'     => 'text',
									'validate' => 'no_html',
								),
								array(
									'id'       => 'anony__line_matrial',
									'title'    => esc_html__( 'Line matrial', ANONY_TEXTDOM ),
									'type'     => 'select',
									'validate' => 'no_html',
									'options'  => [
										''         => esc_html__( 'Select line material', ANONY_TEXTDOM ),
										'concrete' => 'Concrete',
										'steel'    => 'Steel',
										'gpr'      => 'GRP',
										'gpr'      => 'GRP',
										'ductile'  => 'Ductile',
										'pvc'      => 'PVC',
										'upvc'     => 'UPVC',
									],
								),
							)
	);

	//Custom fields object
	$transmission_lineMetaboxes = new ANONY__Meta_Box($transmission_line);
/*--------------------------------------------------------------------------*/	
	
	$reservoirs = array(
		/*Any meta box ID should start with anony-meta- to have correct style*/
		'id'            => 'anony-reservoir-details',//Meta box ID
		'title'         => esc_html__( 'Reservoir Details', ANONY_TEXTDOM ),
		'context'       => 'normal',
		'priority'      =>  'high', // high|low
        'hook_priority' =>  '10', // Default 10
		'post_type'     => array('reservoir'),
		'fields'        => array(
								array(
									'id'       => 'anony__res_city',
									'title'    => esc_html__( 'Reservoir city', ANONY_TEXTDOM ),
									'type'     => 'text',
									'validate' => 'no_html',
								),
								array(
									'id'       => 'anony__res_capcity',
									'title'    => __( 'Reservoir Capcity (m<sup>3</sup>/day)', ANONY_TEXTDOM ),
									'type'     => 'text',
									'validate' => 'no_html',
								),
								array(
									'id'       => 'anony__res_const_year',
									'title'    => __( 'Reservoir construction year', ANONY_TEXTDOM ),
									'type'     => 'text',
									'validate' => 'no_html',
								),
								array(
									'id'       => 'anony__res_type',
									'title'    => esc_html__( 'Reservoir type', ANONY_TEXTDOM ),
									'type'     => 'select',
									'validate' => 'no_html',
									'options'  => [
										''         => esc_html__( 'Select reservoir type', ANONY_TEXTDOM ),
										'concrete' => 'Concrete',
										'steel'    => 'Steel',
										'masonary' => 'Masonary',
									],
								),
							)
	);

	//Custom fields object
	$reservoirMetaboxe = new ANONY__Meta_Box($reservoirs);
/*--------------------------------------------------------------------------------*/
});