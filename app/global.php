<?php
//Config variables

$config = array( );

function initialize() {
	global $config;
	setlocale( LC_ALL, "el_GR.UTF-8" );
	
	($GLOBALS["___mysqli_ston"] = mysqli_connect( $config[ 'db' ][ 'hostname' ],  
				   $config[ 'db' ][ 'user' ],  
				   $config[ 'db' ][ 'password' ] ));
	((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE ".$config[ 'db' ][ 'database' ]));
	mysqli_query($GLOBALS["___mysqli_ston"],  "SET NAMES utf8" );
	
	
	($GLOBALS["___mysqli_ston_apofaseis"] = mysqli_connect( $config[ 'dbapofaseis' ][ 'hostname' ],  
				   $config[ 'dbapofaseis' ][ 'user' ],  
				   $config[ 'dbapofaseis' ][ 'password' ] ));
	((bool)mysqli_query($GLOBALS["___mysqli_ston_apofaseis"], "USE ".$config[ 'dbapofaseis' ][ 'database' ]));
	mysqli_query($GLOBALS["___mysqli_ston_apofaseis"],  "SET NAMES utf8" );
	
	$config[ 'regions_parentid' ] = 5000;
	$config[ 'ministries_firstid' ] = 3;
	$config[ 'ministries_lastid' ] = 21;
	
}	

?>
