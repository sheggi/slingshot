<?php 
require_once("core.php");



if(isset($_REQUEST['method'])) {
	$meth = explode(".",$_REQUEST['method']);
	$MODEL = $meth[0]."Model";
	$ACTION = $meth[1];
	$PARAM = $_REQUEST;
	unset($PARAM["method"]);
	
	$_mod = null;
	if( class_exists($MODEL) ) {
		$_mod = new $MODEL();
		
		if( method_exists($_mod, $ACTION) ){
					
			$log = ["Model: $MODEL, ACTION: $ACTION, PARAM: ".json_encode($_REQUEST)];
			//FIXXXXX check CONTROLLER, FUNCTION, ATTRIBUTE
			
			$_RESPONSE["response"] = $_mod->$ACTION($PARAM);
			$_RESPONSE["log"] = $log;
			$_RESPONSE["error"] = false;
			
		} else {
			$_RESPONSE["error"] = true;
			$_RESPONSE["message"] = "invalide method";
		}
	} else {
		$_RESPONSE["error"] = true;
		$_RESPONSE["message"] = "invalide method";
	}
	
}

if(strtoupper($_RESPONSE["RESPONSE_TYPE"] === "JSON")) {
	unset($_RESPONSE["RESPONSE_TYPE"]);
	header('Content-type: application/json');
	exit(json_encode($_RESPONSE));
} else if(strtoupper($_RESPONSE["RESPONSE_TYPE"] === "DUMP")) {
	var_dump($_RESPONSE);
} else {
	echo "END OF HANDLE";
	//do nothing
} 