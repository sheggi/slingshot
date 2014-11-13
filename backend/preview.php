<?php 

//PRE SET




require_once "core.php";
//POST SET

$_JSON = $_REQUEST = ["c" => "Money", "f" => "getRecordList", "a" => ["accountId" => "a01"] ];

$_RESPONSE["RESPONSE_TYPE"] = "DUMP";



echo "### PREVIEW ###\n";
include "handle.php";
?>