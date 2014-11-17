<?php 

//PRE SET


require_once "core.php";
//POST SET


echo "### PREVIEW ###\n";







//$_JSON = $_REQUEST = ["method" => "Record.find", "accountId" => "a01"];
$_RESPONSE["RESPONSE_TYPE"] = "DUMP";

//$AT = ["STATEMENT" => "INSERT", "id" => "1gKmz", "account_id"=>"a01", "hint" => "DBModel", "amount" => "1234567890", "datetime"=>"2017-11-09 13:45:12"];
//$AT = ["STATEMENT" => "SELECT", "ORDERBY" => "datetime", "accountId" => "a01", "ASC" => "ASC"];
//$AT = ["STATEMENT" => "UPDATE", "WHERE" => ["hint" => "DBModel"], "amount" => "1234567890", "datetime"=>"2017-11-09 13:45:12"];
//$AT = ["STATEMENT" => "DELETE",  "hint" => "DBModel", "amount" => "1234567890", "datetime"=>"2017-11-09 13:45:12"];

$mod = new RecordModel(["id"=>"a01","accountId"=>"a01","datetime"=>"2014-11-17T14:49:13+0100","amount"=>2343254345,"hint"=>"asdföldkfjgsö"]);
$mod->newId();
var_dump($mod->PARAM);
var_dump($mod->isValide());
//var_dump($mod->querry($AT));

include "handle.php";

?>