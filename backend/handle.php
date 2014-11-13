<?php 
require_once("core.php");



if($_JSON == null){
 exit(1);
} else {
	$CONTROLLER = "Controller" . $_JSON['c'];
	$FUNCTION = $_JSON['f'];
	$ATTRIBUTE = $_JSON['a'];
	$log = ["CONTROLLER" => $CONTROLLER, "FUNCTION" => $FUNCTION, "ATTRIBUTE" => $ATTRIBUTE];
	//FIXXXXX check CONTROLLER, FUNCTION, ATTRIBUTE
	
	$_controller = new $CONTROLLER();

	//$_controller->setAccountId($ATTRIBUTE); //FIXXXXX

	$_RESPONSE["response"] = $_controller->$FUNCTION($ATTRIBUTE);
	$_RESPONSE["log"] = $log;


	
}

if(strtoupper($_RESPONSE["RESPONSE_TYPE"] === "JSON")) {
	header('Content-type: application/json');
	exit(json_encode($_RESPONSE));
} else {
	var_dump($_RESPONSE);
} 