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

if(class_exists('ANONY__Meta_Box')){
	add_action('init', function(){
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
										'id'       => 'anony_map',
										'class'    => 'anony_map',
										'title'    => esc_html__( 'Location on the map', ANONY_TEXTDOM ),
										'type'     => 'div',
										'scripts'  => array(
									               
														[
														'handle' => 'google-maps-api',
														'url' => 'https://maps.googleapis.com/maps/api/js?key='.ANONY_GOOGLE_MAP_API.'&libraries=places&language=ar&region=EG',
														'dependancies' => ['jquery']
														],
														[
														'handle' => 'google-map',
														'file_name' => 'google-map',
														'dependancies' => ['jquery', 'google-maps-api']
														],
	        									    ),
										'also_on_front_scripts' => true
									),
									array(
										'id'       => 'anony__entry_lat',
										'title'    => esc_html__( 'Latitude', ANONY_TEXTDOM ),
										'type'     => 'text',
										'validate' => 'number',
									),
									array(
										'id'       => 'anony__entry_long',
										'title'    => esc_html__( 'Longitude', ANONY_TEXTDOM ),
										'type'     => 'text',
										'validate' => 'number',
									),
									array(
										'id'       => 'anony__res_city',
										'title'    => esc_html__( 'City', ANONY_TEXTDOM ),
										'type'     => 'text',
										'validate' => 'no_html',
									),
									array(
										'id'       => 'anony__res_capacity',
										'title'    => __( 'Capacity (m<sup>3</sup>/day)', ANONY_TEXTDOM ),
										'type'     => 'text',
										'validate' => 'no_html',
									),
									array(
										'id'       => 'anony__res_const_year',
										'title'    => esc_html__( 'Construction year', ANONY_TEXTDOM ),
										'type'     => 'text',
										'validate' => 'no_html',
									),
									array(
										'id'       => 'anony__res_type',
										'title'    => esc_html__( 'Type', ANONY_TEXTDOM ),
										'type'     => 'select',
										'validate' => 'no_html',
										'options'  => [
											''         => esc_html__( 'Select reservoir type', ANONY_TEXTDOM ),
											'concrete' => esc_html__( 'Concrete', ANONY_TEXTDOM ),
											'steel'    => esc_html__( 'Steel', ANONY_TEXTDOM ),
											'masonary' => esc_html__( 'Masonary', ANONY_TEXTDOM ),
										],
									),
								)
		);

		//Custom fields object
		$reservoirMetaboxe = new ANONY__Meta_Box($reservoirs);
	/*--------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------*/	
		
		$dams = array(
			/*Any meta box ID should start with anony-meta- to have correct style*/
			'id'            => 'anony-dam-details',//Meta box ID
			'title'         => esc_html__( 'Dam Details', ANONY_TEXTDOM ),
			'context'       => 'normal',
			'priority'      =>  'high', // high|low
	        'hook_priority' =>  '10', // Default 10
			'post_type'     => array('dam'),
			'fields'        => array(
									array(
										'id'       => 'anony_map',
										'class'    => 'anony_map',
										'title'    => esc_html__( 'Location on the map', ANONY_TEXTDOM ),
										'type'     => 'div',
										'scripts'  => array(
									               
														[
														'handle' => 'google-maps-api',
														'url' => 'https://maps.googleapis.com/maps/api/js?key='.ANONY_GOOGLE_MAP_API.'&libraries=places&language=ar&region=EG',
														'dependancies' => ['jquery']
														],
														[
														'handle' => 'google-map',
														'file_name' => 'google-map',
														'dependancies' => ['jquery', 'google-maps-api']
														],
	        									    ),
										'also_on_front_scripts' => true
									),
									array(
										'id'       => 'anony__entry_lat',
										'title'    => esc_html__( 'Latitude', ANONY_TEXTDOM ),
										'type'     => 'text',
										'validate' => 'number',
									),
									array(
										'id'       => 'anony__entry_long',
										'title'    => esc_html__( 'Longitude', ANONY_TEXTDOM ),
										'type'     => 'text',
										'validate' => 'number',
									),
									array(
										'id'       => 'anony__dam_city',
										'title'    => esc_html__( 'City', ANONY_TEXTDOM ),
										'type'     => 'text',
										'validate' => 'no_html',
									),
									array(
										'id'       => 'anony__dam_capacity',
										'title'    => __( 'Capacity (Million m<sup>3</sup>)', ANONY_TEXTDOM ),
										'type'     => 'text',
										'validate' => 'no_html',
									),
									array(
										'id'       => 'anony__dam_const_year',
										'title'    => esc_html__( 'Construction year', ANONY_TEXTDOM ),
										'type'     => 'text',
										'validate' => 'no_html',
									),
									array(
										'id'       => 'anony__dam_type',
										'title'    => esc_html__( 'Type', ANONY_TEXTDOM ),
										'type'     => 'select',
										'validate' => 'no_html',
										'options'  => [
											''         => esc_html__( 'Select Dam type', ANONY_TEXTDOM ),
											'concrete' => esc_html__( 'Concrete', ANONY_TEXTDOM ),
											'steel'    => esc_html__( 'Steel', ANONY_TEXTDOM ),
											'masonary' => esc_html__( 'Masonary', ANONY_TEXTDOM ),
											'rock-fill-dam'   => esc_html__( 'Rock Fill Dam', ANONY_TEXTDOM ),
											'earthen'  => esc_html__( 'Earthen', ANONY_TEXTDOM ),
										],
									),
								)
		);

		//Custom fields object
		$damsMetaboxe = new ANONY__Meta_Box($dams);
	});
}