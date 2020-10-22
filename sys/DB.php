<?php

/**
 * DB Object that connects to the database
 */
class DB extends \PDO{
    /**
     * Instance of DB Object
     */
    private static $instance;
    
    /**
     * Envirement (dev/prod)
     */
    private $env = "dev";
    
    /**
     * Send and instance of itself
     */
    public static function singelton()
    {
        if(!(self::$instance instanceOf self))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Gets the DB Conf by ./sys/conf.json and connects to the database (Firebird DSN)
     */
    public function __construct() {
        //$conf = $this->loadConf();
       
        parent::__construct("odbc:Treyder_FB");
		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
    }
    /**
     * Gets the json data and decodes as array assoc
     * @return type
     */
    public function loadConf()
    {
        $arrayConf = json_decode(file_get_contents(__SYS__."conf.json"), true);
        $conf = array();
        foreach($arrayConf[$this->env] as $key => $value)
        {
            $conf[$key]= $value;
        }
        return $conf;
    }
}
