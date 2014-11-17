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
	private static $dbPreamble = ""; //"sls_";

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
			self::$instance = mysqli_connect(self::$dbHost, self::$dbUser, self::$dbPass) or die ("Error connecting to database.");
            //self::$instance = mysql_connect(self::$dbHost, self::$dbUser, self::$dbPass) or die ("Error connecting to database.");
			mysqli_select_db(self::$instance, self::$dbDatabase) or die ("Couldn't select the database.");
			//mysql_select_db(self::$dbDatabase, self::$instance) or die ("Couldn't select the database.");
        }
		
        return self::$instance;
    }
	
	public static function getPreamble(){
		return self::$dbPreamble;
	}
	
	public static function tablename($tablename){
		if(!empty(self::$dbPreamble)){
			if(strpos($tablename,self::$dbPreamble) == 0){
				return $tablename;
			} else {
				return self::$dbPreamble . $tablename;
			}
		} else {
			return $tablename;
		}
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

 
 

 
 
 
 
 
 
 
 
