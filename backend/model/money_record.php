<?php

class Record
{
	private $accountId;
	private $db;
	
	function __construct($accountId){
		$this->db = DB::getInstance();
		$this->accountId = $accountId;
	}
	
	function add( $attr ){ //FIXXX validate attr
		
		$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for($i=0;$i<4;$i++){
			$pos = rand(0,62);
			$str .= $string{$pos};
		}
		$id = "1". $str; //FIXXX unique id
		
		$query = "INSERT INTO `money_record` (id, account_id, amount, datetime, hint) VALUES ('".$id."','".$this->accountId."','".$attr['amount']."','".$attr['datetime']."','".$attr['hint']."');";
		
		$mixed = mysql_query($query);
		return $mixed;
	}
	
	function delete( $attr ){ //FIXXX validate attr
		$query = "DELETE FROM `money_record` WHERE `id`='".$attr['id']."';";
		
		$mixed = mysql_query($query);
		return $mixed;
	}
	
	function getList(){
		$query = "SELECT * FROM `money_record` ORDER BY `datetime` ASC";;
		
		$mixed = mysql_query($query);
		$list = array();
		while($record = mysql_fetch_assoc($mixed)){
			$datetime = new DateTime($record["datetime"]);
			$record["datetime"] = date_format($datetime, DateTime::ISO8601);
			array_push($list, $record);
		}
		
		return $list;
	}
	
	function getAccountId(){
		return $this->recordAccountId;
	}
}

class RecordFactory
{
	public static function create($accountId){
		if(AccountFactory::validateId($accountId)){ //FIXXX validation
			return new Record($accountId);
		} else {
			return null;
		}
	}
	
}