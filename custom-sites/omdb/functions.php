<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define('OMDB_URI', ANONY_THEME_URI. '/custom-sites/omdb');
define('OMDB_LIBS_DIR', OMDB_DIR. '/functions/');

define('OMDB_CROSS_PARENTS', serialize(['production_report' => 'contract']));

//Core hooks files
$anonylibs = [
	'site-helpers'    =>'',
	'options'         =>'',
	'scripts'         =>'',
	'custom-fields'   =>'',
	'production-report-hooks'   =>'',
	'contract-hooks'  =>'',
	'hooks'           =>'',
	'users-metaboxes' =>'',
];

foreach($anonylibs as $anonylib=>$path){
	require_once( OMDB_LIBS_DIR . $path . $anonylib.'.php');
}