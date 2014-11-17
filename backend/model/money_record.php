<?php

class RecordModel extends DBModel
{
	function __construct($param = null){
		parent::__construct('money_record');
		if($param !== null){
			$this->PARAM = $param;
		}
	}
	
	function newId(){
		$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for($cycle=0; $cycle<1000; $cycle++){
			for($i=0;$i<4;$i++){	
				$pos = rand(0,61);
				$str .= $string{$pos};
			}
			$id = "1". $str;
			if(empty($this->select(["id"=>$id]))){
				$this->id = $id;
				return $id;
			}
		}
		throw new Exception("no new record id available");
	}
	
	function save($attr = null){ //FIXXX validate attr
		if($attr !== null){
			$this->PARAM = $attr;
		}
		if(empty($this->id)){
			$this->newId();
		}
		
		if($this->isValide()){
			if(empty($this->select())){
				if($this->insert()){
					return $this->load();
				} else {	
					return false;
				}
			} else {
				if($this->update(array_push($this->PARAM, ["WHERE" => ["id"=>$this->id]]))){
					return $this->load();
				} else {
					return false;
				}
			}
		} else {
			throw new Exception("invalide record data");
		}
	}
	
	function load($attr = null){
		if($attr !== null){
			$this->PARAM = $attr;
		} else {
			$attr = $this->getParam();
		}
		$attr["LIMIT"] = 1;
		$record = @$this->select($attr)[0];
		$this->PARAM = $record;
		return $record;
	}
	
	function find($attr = null){
		if($attr !== null){
			$this->PARAM = $attr;
		}
		$records = $this->select();
		return $records;
	}
	
	function isValide($attr = null) {
		if($attr === null) {
			$attr = $this->getParam();
		}
		$valider = Validator::getInstance();
		$result = $valider->isValide([$this->getTableName()=> $attr]); 
		if($result['valide']){
			return true; 
		} else {
			throw new Exception($result['error']);
		}
	}
}