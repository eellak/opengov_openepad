<?php
//Config variables

$config = array( );
$config[ 'db' ][ 'hostname' ] = 'localhost';
$config[ 'db' ][ 'user' ] = 'openpad';
$config[ 'db' ][ 'password' ] = 'openpad';
$config[ 'db' ][ 'database' ] = 'openpad';


function initialize() {
	global $config;
	setlocale( LC_ALL, "el_GR.UTF-8" );
	
	($GLOBALS["___mysqli_ston"] = mysqli_connect( $config[ 'db' ][ 'hostname' ],  
				   $config[ 'db' ][ 'user' ],  
				   $config[ 'db' ][ 'password' ] ));
	((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE ".$config[ 'db' ][ 'database' ]));
	mysqli_query($GLOBALS["___mysqli_ston"],  "SET NAMES utf8" );
	
	
	
	$config[ 'regions_parentid' ] = 5000;
	$config[ 'ministries_firstid' ] = 3;
	$config[ 'ministries_lastid' ] = 21;
	
}	

?>