<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
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
									'id'       => 'anony__aqiq_production',
									'title'    => esc_html__( 'Aqiq project production', ANONY_TEXTDOM ),
									'type'     => 'multi_input',
									'validate' => 'multi_input',
									'show_on_front' => true,
									'fields'   =>[
											[
												'type'        => 'number',
												'validate'    => 'number',
												'nested-to'   => 'anony__aqiq_production',
												'id'          => 'purification_plant',
												'show_on_front' => true,
												'class'       => 'anony-multi-value production_value',
												'placeholder' => esc_html__( 'Purification plant', ANONY_TEXTDOM ),
												'title' => esc_html__( 'Purification plant', ANONY_TEXTDOM ),
											],

											[
												'type'        => 'number',
												'validate'    => 'number',
												'nested-to'   => 'anony__aqiq_production',
												'id'          => 'tharad',
												'show_on_front' => true,
												'class'       => 'anony-multi-value production_value',
												'placeholder' => esc_html__( 'Tharad', ANONY_TEXTDOM ),

												'title' => esc_html__( 'Tharad', ANONY_TEXTDOM ),
											],

											[
												'type'        => 'number',
												'validate'    => 'number',
												'nested-to'   => 'anony__aqiq_production',
												'id'          => 'desalination-to-aqiq',
												'show_on_front' => true,
												'class'       => 'anony-multi-value production_value',
												'placeholder' => esc_html__( 'Desalination to AQIQ', ANONY_TEXTDOM ),
												'title' => esc_html__( 'Desalination to AQIQ', ANONY_TEXTDOM ),
											],

											[
												'type'        => 'number',
												'validate'    => 'number',
												'nested-to'   => 'anony__aqiq_production',
												'id'          => 'desalination-to-baljurashi',
												'show_on_front' => true,
												'class'       => 'anony-multi-value production_value',
												'placeholder' => esc_html__( 'Desalination to Baljurashi', ANONY_TEXTDOM ),
												'title' => esc_html__( 'Desalination to Baljurashi', ANONY_TEXTDOM ),
											],

											[
												'type'        => 'number',
												'validate'    => 'number',
												'nested-to'   => 'anony__aqiq_production',
												'id'          => 'desalination-to-shahba',
												'show_on_front' => true,
												'class'       => 'anony-multi-value production_value',
												'placeholder' => esc_html__( 'Desalination to Shahba', ANONY_TEXTDOM ),
												'title' => esc_html__( 'Desalination to Shahba', ANONY_TEXTDOM ),
											],

											[
												'type'        => 'number',
												'validate'    => 'number',
												'nested-to'   => 'anony__aqiq_production',
												'id'          => 'desalination-to-arada',
												'show_on_front' => true,
												'class'       => 'anony-multi-value production_value',
												'placeholder' => esc_html__( 'Desalination to Arada', ANONY_TEXTDOM ),
												'title' => esc_html__( 'Desalination to Arada', ANONY_TEXTDOM ),
											],

											[
												'type'        => 'number',
												'validate'    => 'number',
												'nested-to'   => 'anony__aqiq_production',
												'id'          => 'desalination-to-abdan',
												'show_on_front' => true,
												'class'       => 'anony-multi-value production_value',
												'placeholder' => esc_html__( 'Desalination to Abdan', ANONY_TEXTDOM ),
												'title' => esc_html__( 'Desalination to Abdan', ANONY_TEXTDOM ),
											],

								
										]
								),
							)
	];

omdb_add_project_metabox('aqiq_project_contract', $aqiq_metaboxes);