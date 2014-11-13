<?php




class ControllerMoney
{
	private $userId = null;
	private $accountId = null;
	private $db_record = null;
	
	function __construct(){
	}	
	
	private function handleAttribute($attr){
		$this->userId = @$attr["userId"]; 
		$this->accountId = @$attr["accountId"];
		$this->db_record = RecordFactory::create($this->accountId); //FIXXXX validate
	}
	
	
	function setUserId( $userId ){
		$this->userId = $userId;
	}
	function setAccountId( $accountId ){
		$this->accountId = $accountId;
		
		$this->db_record = RecordFactory::create($accountId);
	}
	
	function getRecordList($attr){
		$this->handleAttribute($attr);
		if($this->accountId === null) {
			return false;
		} else {
			return $this->db_record->getList();
		}
	}
	
	function addRecord($attr){
		$this->handleAttribute($attr);
		if($this->accountId === null) {
			return false;
		} else {
			$successfull = $this->db_record->add($attr['record']);
			if($successfull){
				return $this->db_record->getList();
			} else {
				false;
			}
		}
	}
	
	
	function deleteRecord($attr){
		$this->handleAttribute($attr);
		if($this->accountId === null) {
			return false;
		} else {
			$successfull = $this->db_record->delete($attr['record']);
			if($successfull){
				return $this->db_record->getList();
			} else {
				false;
			}
		}
	}
}