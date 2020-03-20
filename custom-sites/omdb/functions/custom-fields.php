<?php
/**
 * Meta boxes registration
 *
 * @package Anonymous Meta box
 * @author Makiomar
 * @link http://makiomar.com
 */


//Array of metaboxes to register
//id should be equal to title without the anony_ and underscores

add_filter('anony_metaboxes', function($metaboxes){
	$metaboxes[] = 
		[
			
			'id'            => 'anony-tranasmission-line-details',//Meta box ID
			'title'         => esc_html__( 'Tranasmission line Details', ANONY_TEXTDOM ),
			'context'       => 'normal',
			'priority'      =>  'high', // high|low
	        'hook_priority' =>  '10', // Default 10
			'post_type'     => array('transmission_line'),
			'fields'        => array(
									array(
										'id'       => 'anony__testtabs',
										'title'    => esc_html__( 'Line title', ANONY_TEXTDOM ),
										'type'     => 'tabs',
										//'validate' => 'url',
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
									)
								)
		];

	$metaboxes[] =
		[
			
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
										'show_on_front' => true
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
		
		];

	$metaboxes[] =
		[
			
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
										'show_on_front' => true
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
		];

	$metaboxes[] = 
		[
			
			'id'            => 'anony-contract-details',//Meta box ID
			'title'         => esc_html__( 'Contract Details', ANONY_TEXTDOM ),
			'context'       => 'normal',
			'priority'      =>  'high', // high|low
	        'hook_priority' =>  '10', // Default 10
			'post_type'     => array('contract'),
			'fields'        => array(

									array(
										'id'       => 'anony__contracted_company',
										'title'    => esc_html__( 'Contracted company', ANONY_TEXTDOM ),
										'type'     => 'select',
										'options'  => ANONY_POST_HELP::queryPostTypeSimple('company'),
										'validate' => 'multiple_options',
									),

									array(
										'id'       => 'anony__project_no',
										'title'    => esc_html__( 'Project number', ANONY_TEXTDOM ),
										'type'     => 'number',
										'validate' => 'number',
									),

									array(
										'id'       => 'anony__contract_connected_supply_term',
										'title'    => esc_html__( 'Contract connected supply term', ANONY_TEXTDOM ),
										'type'     => 'number',
										'validate' => 'no_html',
									),

									array(
										'id'       => 'anony__contract_ref_number',
										'title'    => esc_html__( 'Contract reference number', ANONY_TEXTDOM ),
										'type'     => 'number',
										'validate' => 'number',
									),

									array(
										'id'       => 'anony__contract_start',
										'title'    => esc_html__( 'Contract start date', ANONY_TEXTDOM ),
										'type'     => 'date_time',
										'get'      => 'date',
										'date-format' => 'dd-mm-yy',
										'desc' => esc_html__( 'Date format should be Day-Month-Year',ANONY_TEXTDOM ),
										'validate' => 'date',
										'show_on_front' => true

									),

									array(
										'id'       => 'anony__contract_end',
										'title'    => esc_html__( 'Contract end date', ANONY_TEXTDOM ),
										'type'     => 'date_time',
										'get'      => 'date',
										'date-format' => 'dd-mm-yy',
										'desc' => esc_html__( 'Date format should be Day-Month-Year',ANONY_TEXTDOM ),
										'validate' => 'date',
										'show_on_front' => true
									),

									array(
										'id'       => 'anony__contract_period',
										'title'    => esc_html__( 'Contract period', ANONY_TEXTDOM ),
										'type'     => 'number',
										'validate' => 'no_html',
									),


									array(
										'id'       => 'anony__contract_value',
										'title'    => esc_html__( 'Contract value', ANONY_TEXTDOM ),
										'type'     => 'number',
										'step'     => '0.01',
										'validate' => 'number',
									),

									array(
										'id'       => 'anony__contract_value_after_reduction',
										'title'    => esc_html__( 'Contract value after reduction', ANONY_TEXTDOM ),
										'type'     => 'number',
										'step'     => '0.01',
										'validate' => 'number',
									),


									array(
										'id'       => 'anony__quantities_reduction',
										'title'    => esc_html__( 'Quantities reduction', ANONY_TEXTDOM ),
										'type'     => 'multi_value',
										'validate' => 'multi_value',
										'button-text' => esc_html__( 'Add new reduction', ANONY_TEXTDOM ),
										'fields'   =>
											[
												[
													'type'        => 'number',
													'validate'    => 'number',
													'nested-to'   => 'anony__quantities_reduction',
													'id'          => 'reduction_value',
													'class'       => 'anony-multi-value reduction_value',
													'placeholder' => esc_html__( 'Reduction value', ANONY_TEXTDOM ),
												],

												[
													'type'        => 'date_time',
													'validate'    => 'date',
													'get'         => 'date',
													'date-format' => 'dd-mm-yy',
													'desc' => esc_html__( 'Date format should be Day-Month-Year',ANONY_TEXTDOM ),
													'nested-to'   => 'anony__quantities_reduction',
													'id'          => 'reduction_date',
													'class'       => 'anony-multi-value',
													'placeholder' => esc_html__( 'Reduction date', ANONY_TEXTDOM ),
													'show_on_front' => true
												],

												[
													'type'        => 'textarea',
													'validate'    => 'no_html',
													'nested-to'   => 'anony__quantities_reduction',
													'id'          => 'reduction_details',
													'class'       => 'anony-multi-value',
													'placeholder' => esc_html__( 'Details', ANONY_TEXTDOM ),
												],
											],
									),
									
									array(
										'id'       => 'anony__contract_total_reduction',
										'type'     => 'hidden',
									),

									array(
										'id'       => 'anony__contract_extended',
										'title'    => esc_html__( 'Contract extension', ANONY_TEXTDOM ),
										'type'     => 'checkbox',
									),

									

									array(
										'id'       => 'anony__contract_extension_value',
										'title'    => esc_html__( 'Contract extension\'s value', ANONY_TEXTDOM ),
										'type'     => 'number',
										'step'     => '0.1',
										'validate' => 'number',
									),

									array(
										'id'       => 'anony__contract_end_after_extension',
										'title'    => esc_html__( 'Contract end date after extension', ANONY_TEXTDOM ),
										'type'     => 'date_time',
										'date-format' => 'dd-mm-yy',
										'desc' => esc_html__( 'Date format should be Day-Month-Year',ANONY_TEXTDOM ),
										'get'      => 'date',
										'validate' => 'date',
										'show_on_front' => true
									),

								)
		];
			

	$metaboxes[] = 
		[
			
			'id'            => 'anony-production-details',//Meta box ID
			'title'         => esc_html__( 'Production details', ANONY_TEXTDOM ),
			'context'       => 'normal',
			'priority'      =>  'high', // high|low
	        'hook_priority' =>  '10', // Default 10
			'post_type'     => array('production_report'),
			'fields'        => array(
									array(
										'id'       => 'parent_id',
										'title'    => esc_html__( 'Reprot for project', ANONY_TEXTDOM ),
										'type'     => 'select',
										'options'  => ANONY_POST_HELP::queryPostTypeSimple('contract'),
									),

									array(
										'id'       => 'anony__purification_plant',
										'title'    => esc_html__( 'purification plant production', ANONY_TEXTDOM ),
										'type'     => 'number',
										'validate' => 'number',
										'show_on_front' => true
									),

								)

		];

	return $metaboxes;
});

add_action( 'init', function(){
	if (!class_exists('ANONY_Options_Model')) return;
	$omdb_options = ANONY_Options_Model::get_instance('Omdb_Options');

	$arada_metaboxes = [
		
		'id'            => 'arada-production-distripution',//Meta box ID
		'title'         => esc_html__( 'arada post meta boxes', ANONY_TEXTDOM ),
		'context'       => 'normal',
		'priority'      =>  'high', // high|low
        'hook_priority' =>  '10', // Default 10
		'post_type'     => array('production_report'),
		'fields'        => array(

								array(
									'id'       => 'parent_id',
									'title'    => esc_html__( 'Peport of project', ANONY_TEXTDOM ),
									'type'     => 'select',
									'options'     => ANONY_POST_HELP::queryPostTypeSimple('contract'),
									'validate' => 'multiple_options',
								),

								array(
									'id'       => 'anony__arada_wells',
									'title'    => esc_html__( 'Arada wells production', ANONY_TEXTDOM ),
									'type'     => 'number',
									'validate' => 'numder',
									'show_on_front' => true,
								),
							)
	];

	if(isset($omdb_options->arada_project_contract) && !empty($omdb_options->arada_project_contract)){
		$project_metaboxes = get_post_meta( intval($omdb_options->arada_project_contract) , 'anony_this_project_metaboxes', true );
		if (empty($project_metaboxes)) {
			add_post_meta( intval($omdb_options->arada_project_contract) , 'anony_this_project_metaboxes', $arada_metaboxes );
		}

	}

	$aqiq_metaboxes = [
		
		'id'            => 'aqiq-production-distripution',//Meta box ID
		'title'         => esc_html__( 'aqiq post meta boxes', ANONY_TEXTDOM ),
		'context'       => 'normal',
		'priority'      =>  'high', // high|low
        'hook_priority' =>  '10', // Default 10
		'post_type'     => array('production_report'),
		'fields'        => array(
								array(
									'id'       => 'parent_id',
									'title'    => esc_html__( 'Peport of project', ANONY_TEXTDOM ),
									'type'     => 'select',
									'options'     => ANONY_POST_HELP::queryPostTypeSimple('contract'),
									'validate' => 'multiple_options',
								),

								array(
									'id'       => 'anony__aqiq_wells',
									'title'    => esc_html__( 'aqiq wells production', ANONY_TEXTDOM ),
									'type'     => 'number',
									'validate' => 'numder',
									'show_on_front' => true,
								),
							)
	];

	if(isset($omdb_options->aqiq_project_contract) && !empty($omdb_options->aqiq_project_contract)){
		$project_metaboxes = get_post_meta( intval($omdb_options->aqiq_project_contract) , 'anony_this_project_metaboxes', true );
		if (empty($project_metaboxes)) {
			add_post_meta( intval($omdb_options->aqiq_project_contract) , 'anony_this_project_metaboxes', $aqiq_metaboxes );
		}

	}

});

add_filter( 'anony_post_specific_metaboxes', function($post_metaboxes, $post){
	$parent_id = get_post_meta( $post->ID, 'parent_id', true );
	$post_metaboxes = get_post_meta( intval($parent_id), 'anony_this_project_metaboxes', true );
	return $post_metaboxes;
}, 10, 2);

add_filter( 'anony_mb_frontend_fields', function($fields){
	if (!is_admin()) {

		$parent_id = omdb_get_user_project_id();

		if ($parent_id) {
			$project_metaboxes = get_post_meta( $parent_id , 'anony_this_project_metaboxes', true );

			if (!empty($project_metaboxes)) {
				$fields = $project_metaboxes['fields'];

			}
		}
	}
	return $fields;
} );