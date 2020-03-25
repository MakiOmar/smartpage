<?php

$arada_metaboxes = [
		
		'id'            => 'arada-production-details',//Meta box ID
		'title'         => esc_html__( 'arada post meta boxes', ANONY_TEXTDOM ),
		'context'       => 'normal',
		'priority'      =>  'high', // high|low
        'hook_priority' =>  '10', // Default 10
		'post_type'     => array('production_report'),
		'fields'        => array(


								array(
									'id'       => 'anony__arada_wells',
									'title'    => esc_html__( 'Arada wells production', ANONY_TEXTDOM ),
									'type'     => 'number',
									'validate' => 'numder',
									'show_on_front' => true,
								),
							)
	];

omdb_add_project_metabox('arada_project_contract', $arada_metaboxes);