<?php 

//PRE SET




require_once "core.php";
//POST SET

$_JSON = $_REQUEST = ["method" => "Record.getList", "accountId" => "a01"];

$_RESPONSE["RESPONSE_TYPE"] = "JSON";



echo "### PREVIEW ###\n";
include "handle.php";
?>