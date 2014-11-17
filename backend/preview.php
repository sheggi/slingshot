<?php 

//PRE SET




require_once "core.php";
//POST SET

$_JSON = $_REQUEST = ["method" => "Record.getList", "accountId" => "a01"];

$_RESPONSE["RESPONSE_TYPE"] = "DUMP";



//$AT = ["STATEMENT" => "INSERT", "id" => "1gKmX", "account_id"=>"a01", "hint" => "DBModel", "amount" => "1234567890", "datetime"=>"2017-11-09 13:45:12"];
$AT = ["STATEMENT" => "SELECT", "ORDERBY" => "datetime", "COLUMN" => "*", "ASC" => "DESC"];
$mod = new DBModel('money_record');
var_dump($mod->QUERRY($AT));

echo "### PREVIEW ###\n";
include "handle.php";
?>