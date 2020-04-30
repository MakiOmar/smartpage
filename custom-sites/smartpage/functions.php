<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define('SMPG_URI', ANONY_THEME_URI. '/custom-sites/smartpage');
define('SMPG_LIBS_DIR', SMPG_DIR. '/functions/');

//Core hooks files
$smpglibs = [
	'hooks'         => '',
	'custom-fields' => '',
	'ajax'          => '',
];

foreach($smpglibs as $smpglib=>$path){
	require_once( SMPG_LIBS_DIR . $path . $smpglib.'.php');
}