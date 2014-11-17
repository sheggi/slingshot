<?php 

class AccountModel
{
	private $db;
	
	function __construct(){
		$this->db = DB::getInstance();
	}
	
	function add($attr){
	}
	
	function delete($attr){
	}
	
	function get($attr){
	}
	
	function getList($attr){
	}
}



class Account{


	public static function isValidId($id){
		//FIXXX validation not complete
		
		return ($id === "a01");
	}
}