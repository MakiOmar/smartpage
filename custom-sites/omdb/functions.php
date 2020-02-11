<?php

define('OMDB_URI', ANONY_THEME_URI. '/custom-sites/omdb');
define('OMDB_LIBS_DIR', OMDB_DIR. '/functions/');

//Core hooks files
$anonylibs = [
	'scripts'       =>'',
	'custom-fields' =>'',
];

foreach($anonylibs as $anonylib=>$path){
	require_once( OMDB_LIBS_DIR . $path . $anonylib.'.php');
}