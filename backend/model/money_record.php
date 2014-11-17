<?php

class RecordModel
{
	private $db;
	
	function __construct(){
		$this->db = DB::getInstance();
	}
	
	function add( $attr ){ //FIXXX validate attr
		$rec = new Record((isset($attr['record'])?$attr['record']:$attr));
	
		$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for($i=0;$i<4;$i++){
			$pos = rand(0,62);
			$str .= $string{$pos};
		}
		$rec->id = "1". $str; //FIXXX unique id
		
		if($rec->isValid()){
		
			
			$query = "INSERT INTO `money_record` (id, account_id, amount, datetime, hint) VALUES ('".$rec->id."','".$rec->accountId."','".$rec->amount."','".$rec->datetime."','".$rec->hint."');";
			
			if(mysql_query($query)){
				return ["record" => $rec];
			} else {	
				return false;
			}
		} else {
			throw new Exception("invalide Record");
		}
	}
	
	function delete( $attr ){ //FIXXX validate attr
		$rec = $this->get($attr);
		
		$query = "DELETE FROM `money_record` WHERE `id`='".$attr['id']."';";
		
		$mixed = mysql_query($query);
		return ($mixed ? $rec : false);
	}
	
	function get($attr){
		$query = "SELECT * FROM `money_record`  WHERE `id`='".$attr['id']."' LIMIT 1;"; //FIXXX select attr
		
		$mixed = mysql_query($query);
		$list = array();
		$record = mysql_fetch_assoc($mixed);
		
		return ["record" => $record];
	}
	
	function getList($attr){
		$query = "SELECT * FROM `money_record` ORDER BY `datetime` ASC"; //FIXXX select attr
		
		$mixed = mysql_query($query);
		$list = array();
		while($record = mysql_fetch_assoc($mixed)){
			$datetime = new DateTime($record["datetime"]);
			$record["datetime"] = date_format($datetime, DateTime::ISO8601);
			array_push($list, $record);
		}
		
		return ["records" => $list];
	}
}

class Record extends RecordModel
{
	public $id;
	public $accountId;
	public $hint;
	public $datetime;
	public $amount;
	
	
	function __construct($param){
		$this->accountId = $param['accountId'];
		$this->id = @$param['id'];
		$this->hint = @$param['hint'];
		$this->datetime = @$param['datetime'];
		$this->amount = @$param['amount'];
	}
	
	function isValid() {
		$valide = true;
		$valide &= Account::isValidId($this->id);
		return ($this->accountId == "a01"); //FIXXX validation
	}
}