<?php
/**
 * $_JSON ist eine globale Variable, worin der JSON Request enthalten ist
 */
$_JSON = json_decode(file_get_contents("php://input"), TRUE);
if($_JSON == null){
	$_JSON = [];
}
if( is_array($_REQUEST) && is_array($_JSON)) {
	$_REQUEST = array_merge($_REQUEST, $_JSON);
} else if ( empty($_REQUEST) && is_array( $_JSON ) ){
	$_REQUEST = $_JSON;
}

/*
 * loading systemfiles
 */

foreach (glob("core/*.php") as $filename)
{
    require_once $filename;
}

foreach (glob("controller/*.php") as $filename)
{
    include $filename;
}
foreach (glob("model/*.php") as $filename)
{
    include $filename;
}

/**
 * DEFAULT VAlUES
 */
 
$_RESPONSE = ["RESPONSE_TYPE" => "JSON"];

