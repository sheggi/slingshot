<?php 
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])) send_404();
require_once "database.php";
require_once "dbmodel.php";

// inital DB connection
Validator::getInstance();
class Validator
{
	private $db;
	private $tableField = [];
	private static $instance;
	
    /**
     * Returns the *Singleton* instance of this class.
     *
     * @staticvar Singleton $instance The *Singleton* instances of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        self::$instance = null;
        if (null == self::$instance) {
			self::$instance = new Validator();
        }
		
        return self::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     * /^http(?:s?):\/\/regex101\.com\/r\/([a-zA-Z0-9]{1,6})?$
	 */
    protected function __construct()
    {
		$tables = ["user", "money_account", "money_record"];
		$this->db = DB::getInstance();
		
		foreach($tables as $val){
			$sql = "DESCRIBE ".DB::tablename($val);
			$mixed = mysqli_query($this->db, $sql);
			while($row = mysqli_fetch_array($mixed)) {
			
				$text = $row['Type'];
				preg_match("/(?<=\()(.+)(?=\))/is", $text, $matches);
				$limit = @$matches[0]*1;
				$type = explode("(",$text)[0];
			
				$this->tableField[$val][$row['Field']] = ["type"=>$type, "limit"=>$limit];
			}
				
			//FIXXX nur ein foreign key erfasst
			$sql = "SHOW CREATE TABLE ".DB::tablename($val);
			$mixed = mysqli_query($this->db, $sql);
			$field = mysqli_fetch_array($mixed);
			$dat = explode(' ',preg_replace("/([\(\)])/",'',str_replace('`','',$field["Create Table"])));
			if(array_search('CONSTRAINT', $dat)) {
				$pos1 = array_search('FOREIGN',$dat);
				$pos2 = array_search('REFERENCES',$dat);
				$this->tableField[$val][$dat[$pos1+2]]['foreign'] = ["table"=>$dat[$pos2+1], "column" =>$dat[$pos2+2]];
			}
		}
		
		//RegEX patern
		$this->tableField['user']['id']['regex'] = "/(^u[a-zA-Z0-9]{2})/";
		$this->tableField['money_account']['id']['regex'] = "/(^a[a-zA-Z0-9]{2})/";
		$this->tableField['money_record']['id']['regex'] = "/(^1[a-zA-Z0-9]{4})/";
    }
	
	public function isValide($data){
		$valide = true;
		$msg = "";
		foreach($data as $table => $coldat){
			foreach($coldat as $col => $value){
				$rules = $this->tableField[$table][$col];
				foreach($rules as $rule => $ruleDat){
					$val = true;
					if($rule === "limit"){
						$val = ($ruleDat == 0)? true : (strlen($value) <= $ruleDat);
						$msg .= $val ? "" : "invalide limit($ruleDat) $table.$col '".strlen($value)."'\n";
					} else if($rule === "type") {
						if($ruleDat === "varchar") {
							// FIXXX check quote
						} else if($ruleDat === 'int' ) {
							$val = is_numeric($value);
							$msg .= $val ? "" : "invalide int $table.$col '$value'\n";
						} else if($ruleDat === 'datetime' ) {
							try{
								$val = (new DateTime($value))->format(DateTime::ISO8601) == $value;
							} catch(Exception $e){
								$val = false;
								$msg .= "invalide datetime $table.$col '$value'\n";
							}
						} else {
							throw new Exception("unchecked rule type $table.$col => $rule $ruleDat");
						}
					} else if($rule === "regex"){
						preg_match($ruleDat, $value, $matches);
						$val = !empty($matches);
						$msg .= $val ? "" : "invalide regex $table.$col '$value'\n";
					} else if($rule === "foreign"){
						$checkRes = $this->isValide([$ruleDat['table']=>[$ruleDat['column']=>$value]]);
						if($checkRes["valide"]){
							$sql = "SELECT * FROM `".DB::tablename($ruleDat['table'])."` WHERE `".$ruleDat['column']."` = '".$value."' LIMIT 1;";
							$mixed = mysqli_query($this->db, $sql);
							$val = (mysqli_num_rows($mixed) == 1);
							$msg .= $val ? "" : "dont existing (".$ruleDat['table'].".".$ruleDat['column'].") $table.$col '$value'\n";
						} else {
							$val = false;
							$msg .= $checkRes["error"];
						}
					} else {
						throw new Exception("unchecked rule $table.$col => $rule");
					}
					$valide &= $val;
				}
			}
		}
		return ["valide"=>($valide?true:false),"error"=>$msg];
	}

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}