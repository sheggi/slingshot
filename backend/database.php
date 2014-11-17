<?php 
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])) send_404();

// inital DB connection
DB::getInstance();
class DB
{

	private static $dbHost = "localhost";        //Location Of Database usually its localhost
	private static $dbUser = "root";            //Database User Name
	private static $dbPass = "";            //Database Password
	private static $dbDatabase = "slingshot";       //Database Name
#	private static $dbPreamble = "sls_";

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
            self::$instance = mysql_connect(self::$dbHost, self::$dbUser, self::$dbPass) or die ("Error connecting to database.");
			mysql_select_db(self::$dbDatabase, self::$instance) or die ("Couldn't select the database.");
        }
		
        return self::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
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

 
 
class DBModel {
	private $TABLE_NAME = null;
	private $db;
	
	function __construct($tablename){
		$this->TABLE_NAME = $tablename;
		$this->db = DB::getInstance();
	}
	
	function INSERT($attr){
		$ks = "";
		$vs = "";
		foreach ($attr as $k => $v){
			$ks .= "`$k`,";
			$vs .= "'$v',";
		}
		$ks = substr($ks,0,-1);
		$vs = substr($vs,0,-1);
		
		$query = "INSERT INTO `".$this->TABLE_NAME."` ($ks) VALUES ($vs);";
		if(mysql_query($query)){
			return true;
		} else {
			throw new Exception(mysql_error());
		}
	}
	
	function SELECT($attr){
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
		
		
		$query = "SELECT ".(($col === null) ?  '*': $col)
		." FROM ".$this->TABLE_NAME." "
		.((empty($cond)) ? "" : "WHERE $cond " )
		.((empty($orderBy)) ? "" : "ORDER BY $orderBy ")
		.((empty($asc)) ? "ASC " : "$asc " )
		.((empty($limit)) ? "" : "LIMIT $limit" ) . ";";
		
		var_dump($query);
		var_dump($mixed = mysql_query($query));
		var_dump(mysql_num_rows($mixed));
		var_dump(mysql_fetch_assoc($mixed));
	}
	
	function DELETE($attr){
	}
	
	function UPDATE($attr){
	}
	
	function QUERRY($attr){
		if(isset($attr["STATEMENT"])){
			$STATEMENT = $attr["STATEMENT"];
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
}
 
 
 
 
 
 
 
 
# This function will send an imitation 404 page if the user
# types in this files filename into the address bar.
# only files connecting with in the same directory as this
# file will be able to use it as well.
function send_404()
{
    header('HTTP/1.x 404 Not Found');
?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">
<head>
<title>Objekt nicht gefunden!</title>
<link rev="made" href="mailto:postmaster@localhost" />
<style type="text/css"><!--/*--><![CDATA[/*><!--*/ 
    body { color: #000000; background-color: #FFFFFF; }
    a:link { color: #0000CC; }
    p, address {margin-left: 3em;}
    span {font-size: smaller;}
/*]]>*/--></style>
</head>

<body>
<h1>Objekt nicht gefunden!</h1>
<p>


    Der angeforderte URL konnte auf dem Server nicht gefunden werden.

  

    Sofern Sie den URL manuell eingegeben haben,
    &uuml;berpr&uuml;fen Sie bitte die Schreibweise und versuchen Sie es erneut.

  

</p>

<p>
Sofern Sie dies f&uuml;r eine Fehlfunktion des Servers halten,
informieren Sie bitte den 
<a href="mailto:postmaster@localhost">Webmaster</a>
hier&uuml;ber.

</p>

<h2>Error 404</h2>
<address>
  <a href="/">localhost</a><br />
  <span>Apache/2.4.10 (Win32) OpenSSL/1.0.1i PHP/5.5.15</span>
</address>
</body>
</html>

<?php
}
 
# In any file you want to connect to the database, 
# and in this case we will name this file db.php 
# just add this line of php code (without the pound sign):
# include"db.php";
?>