<?php
/**
 * $_JSON ist eine globale Variable, worin der JSON Request enthalten ist
 */
$_JSON = json_decode(file_get_contents("php://input"), TRUE);
if( is_array($_REQUEST) && is_array($_JSON)) {
	$_REQUEST = array_merge($_REQUEST, $_JSON);
} else if ( is_array( $_JSON ) ){
	$_REQUEST = $_JSON;
}

/*
 * loading systemfiles
 */

require_once("./database.php");

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
