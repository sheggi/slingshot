<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])) send_404();

class DBModel {
	private $TABLE_NAME = null;
	protected $FIELD = [];
	protected $db;
	
	function __construct($tablename){
		if(empty($tablename)){
			throw new Exception("no Table name set");
		}
		$this->TABLE_NAME = $tablename;
		$this->db = DB::getInstance();
		
		$q = mysqli_query($this->db, 'DESCRIBE '.$this->TABLE_NAME);
		while($row = mysqli_fetch_array($q)) {
			$this->FIELD[$row['Field']] = "";
			//echo "{$row['Field']} - {$row['Type']}\n";
		}
	}
	
	function __get($index){
		if($index === "PARAM"){
			return $this->FIELD;
		}
		if(isset($this->FIELD[$index])){
			return $this->FIELD[$index];
		} else {
			throw new Exception("invalide model filedname >$index<");
		}
	}
	
	function __set($index, $value){// FIXXX field validation
		if($index === "PARAM"){
			if(is_array($value)){
				foreach($value as $key => $val){
					if(isset($this->FIELD[$key])){
						$this->FIELD[$key] = $val;
					}
				}
			}
		} else if(isset($this->FIELD[$index])){
			return $this->FIELD[$index] = $value;
		} else {
			throw new Exception("invalide model fieldname >$index<");
		}
	}
	
	function insert($attr = null){
		if($attr === null){
			$attr = $this->getParam();
		}
		$ks = "";
		$vs = "";
		foreach ($attr as $k => $v){
			$ks .= "`$k`,";
			$vs .= "'$v',";
		}
		$ks = substr($ks,0,-1);
		$vs = substr($vs,0,-1);
		
		$sql = "INSERT INTO `".DB::tablename($this->TABLE_NAME)."` ($ks) VALUES ($vs);";
		if(mysqli_query($this->db, $sql)){
			return true;
		} else {
			throw new Exception(">>".$sql."<<".mysqli_error());
		}
	}
	
	function select($attr = null, $returnMySQLResult = false){
		if($attr === null){
			$attr = $this->getParam();
		}
		$orderBy = null;
		$asc = null;
		$limit = null;
		$col = null;
		
		$orderBy = @$attr["ORDERBY"];
		unset($attr["ORDERBY"]);
		$asc = @$attr["ASC"];
		unset($attr["ASC"]);
		$limit = @$attr["LIMIT"];
		unset($attr["LIMIT"]);
		$col = @$attr["COLUMN"];
		unset($attr["COLUMN"]);
		
		$cond = "";
		foreach($attr as $k => $v){
			$cond .= "`$k` = '$v' AND ";
		}
		$cond = substr($cond,0,-5);
		
		$sql = "SELECT ".(($col === null) ?  '*': $col)
		." FROM ".DB::tablename($this->TABLE_NAME)." "
		.((empty($cond)) ? "" : "WHERE $cond " )
		.((empty($orderBy)) ? "" : "ORDER BY $orderBy ".((empty($asc)) ? "ASC " : "$asc " ))
		.((empty($limit)) ? "" : "LIMIT $limit" ) . ";";
	
		$mixed = mysqli_query($this->db, $sql);
		if($mixed===false){
			throw new Exception(">>".$sql."<<".mysqli_error($this->db));
		} else {
			$resultAssocArray = [];
			while($res = mysqli_fetch_assoc($mixed)){
				array_push($resultAssocArray, $res);
			}
			return $returnMySQLResult ? [$resultAssocArray, $mixed] : $resultAssocArray;
		}
	}
	
	function update($attr){
	
		if(empty($attr["WHERE"])){
			throw new Exception("missing WHERE condition");
		}
		
		$cond = "";
		foreach($attr["WHERE"] as $k => $v){
			$cond .= "`$k` = '$v' AND ";
		}
		$cond = substr($cond,0,-5);
		unset($attr["WHERE"]);
		
		$set = "";
		foreach($attr as $k => $v){
			$set .= "`$k` = '$v', ";
		}
		$set = substr($set,0,-2);
		if(empty($set)){
			throw new Exception("missing SET condition");
		}
		
		$sql = "UPDATE `".DB::tablename($this->TABLE_NAME)."` SET $set WHERE $cond;";
		
		$mixed = mysqli_query($this->db, $sql);
		if($mixed===false){
			throw new Exception(">>".$sql."<<".mysqli_error($this->db));
		} else {
			return mysqli_affected_rows($this->db);
		}
	}
	
	function delete($attr = null){
		if($attr === null){
			$attr = $this->getParam();
		}
		$cond = "";
		foreach($attr as $k => $v){
			$cond .= "`$k` = '$v' AND ";
		}
		$cond = substr($cond,0,-5);
		
		$sql = "DELETE FROM `".DB::tablename($this->TABLE_NAME)."` WHERE $cond;";
		
		$mixed = mysqli_query($this->db, $sql);
		if($mixed===false){
			throw new Exception(">>".$sql."<<".mysqli_error($this->db));
		} else {
			return mysqli_affected_rows($this->db);
		}
	}
	
	function querry($attr){
		if(isset($attr["STATEMENT"])){
			$STATEMENT = strtolower($attr["STATEMENT"]);
			unset($attr["STATEMENT"]);
			if(method_exists($this,$STATEMENT)){ 
				return $this->$STATEMENT($attr);
			} else {
				throw new Exception('STATEMENT "'.$attr["STATEMENT"].'" unknown');
			}
		} else {
			throw new Exception('STATEMENT not set');
		}
	}
	
	function getTableName(){
		return $this->TABLE_NAME;
	}
	
	function getParam(){
		$clean = [];
		foreach($this->FIELD as $key => $val){
			if(!empty($val)){
				$clean[$key] = $val;
			}
		}
		return $clean;
	}
}

