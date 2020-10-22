<?php


include 'DB.php';

/**
 * PDO class to do queries 
 */
class Stmt extends DB{
    /**
     * Instance of DB Object
     */
    public $instance;
    /**
     * PDOStatement Obect
     */
    public $stmt;
    
    /**
     * Entity to makes the queries
     */
    public $entity;

    public function setEntity($entity) {
        $this->entity = $entity;
    }

    /**
     * Instanciates a DB Object
     */
    public function __construct() {
        $this->instance = DB::singelton();
       
    }
    
    /**
     * Prepares a query
     */
    public function query($stmt){

        return $this->setStmt($this->instance->prepare($stmt));
    }
    
    /**
     * Execute the prepared query
     */
    public function execute()
    {
        try {
            return $this->stmt->execute();
        } catch (\PDOException $ex) {
            echo "Cant execute the query, error code: ".$ex->getCode();
        }
        
    }
    
    public function bind($param, $value){
        switch (true) 
        {
            case is_int($value):
                $type = \PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = \PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = \PDO::PARAM_NULL;
                break;
            default:
                $type = \PDO::PARAM_STR;
        }
        $this->stmt->bindValue($param, $value, $type);
        
	}

        /**
         * 
         * @return result as array ASSOC
         */
	public function resultset(){
    	
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
        
        /**
         * 
         * @return result as single array
         */
	public function single()
        {
	    return $this->stmt->fetch(\PDO::FETCH_ASSOC);
	}

        /**
         * 
         * @return int total of rows on the query
         */
	public function rowCount(){
            return $this->stmt->rowCount();
	}

        /**
         * Begins and SQL Transaction
         */
	public function beginTransaction(){
	    return $this->instance->beginTransaction();
	}

        /**
         * Ends the transactions and send the result
         */
	public function endTransaction(){
	    return $this->instance->commit();
	}

	public function cancelTransaction(){
	    return $this->instance->rollBack();
	}

	public function debugDumpParams(){
	    return $this->instance->debugDumpParams();
	}

        /**
         * 
         * @return The current PDOStatement Object
         */
        public function getStmt()
        {
            return $this->stmt;
        }
        
        public function setStmt($stmt)
        {
            $this->stmt = $stmt;
        }
		
		public function getPDO()
        {
            return $this->instance;
        }
        
        /**
         * 
         * @return auto execute the query and send the result as array assoc
         */
        public function getResult()
        {
            $this->stmt->execute();
            return $this->resultset();
        }

        
}
