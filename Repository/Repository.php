<?php
/**
 * Parent Repository
 */
include __SYS__.'Stmt\IQuery.php';

abstract class Repository implements IQuery{
    /**
     * String to send to the PDO Statement (SQL)
     */
    protected $query = "";
    protected $result;
    /**
     * Instance of PDOStatement
     */
    protected $stmt;
    /**
     * The entity that im working with
     */
    protected $entity;
    /**
     * The mapping info retrieved of __ORM__/$this_entity.json
     */
    protected $map;

    /**
     * append the query to the current query
     * @param string $query 
     */
    public function setQuery($query)
    {
        $this->query .= $query;
    }
    
    public function getStmt() {
        return $this->stmt;
    }

    
    public function __construct($entity = null) {
        /**
         * Gets and instance of PDO Statement
         */
        $this->stmt = new Stmt();
        /**
         * Gets the entity that we will work with
         */
        $entity = substr($entity, 0 ,strpos($entity,"_Repository"));
        
        $this->entity = $entity;
        
        /**
         * Send the entity to the PDOStatement
         */
        $this->stmt->setEntity($entity);
        
        $file =  __ORM__.$this->entity.'.json';             
        if(is_readable($file))
        {
            $this->map = json_decode(file_get_contents($file), true);
   
        }
    }

    /**
     * 
     * @return resultset of all objects at the database
     */
    public function findAll() 
    {
        $this->select();
        $this->stmt->query($this->query);
        return $this->stmt->getResult();
    }

    /**
     * Find on the database with criteria
     * @param the criteria to find
     * @return the object finded
     */
    public function findBy($array = array()) {
        $this->select();
        $this->where($array);
        $this->stmt->query($this->query);
        
        return $this->stmt->getResult();
    }
    
    /**
     * 
     * @param type $array the criteria to search
     * @return the result of the query as an unique array.
     */
    public function findOneBy($array = array()) {
        $this->select();
        $this->where($array);
        
        $this->stmt->query($this->query);
        
        
        
        $this->stmt->execute();
        
        return $this->stmt->single();
    }
    
    /**
     * 
     * @param int $id
     * @return returns the data founded usng its id
     */
    public function find($id)
    {
        $this->select();
        $this->where(array("ID_".$this->entity => $id));
        $this->stmt->query($this->query);
        return $this->stmt->single();
    }
    
    /**
     * @return the SQL writed
     */
    public function getSQL()
    {
        return $this->query;
    }

    
    /**
     * 
     * @param type $array of columns to retreave
     */
    public function select($array = null, $type = null)
    {

        $query = "SELECT ";
        if($type)
        {
            $query .= "$type[0] $type[1]";
        }
        if(!is_array($array))
        {
            $query .= " * ";
        }
        else
        {
            foreach ($array as $key => $value) {
                if(array_key_exists($key, $this->map))
                {
                    $alias = $this->map[$key]["ALIAS"];
                }else
                {
                    $alias = $this->entity;
                }
                if(is_array($value))
                {
                    foreach($value as $valueE)
                    {
                        $query .= $alias.".".$valueE." ";
                        if($valueE !== end($value))
                        {
                            $query .= ", ";
                        }  
                        
                    }
                }
                else
                {
                    $query .= $alias.".".$value." ";
                }
                /*
                * If is not the end of the array write a colon
                */
                if($value !== end($array))
                {
                    $query .= ", ";
                }  
                
                              
                
            }
            
        }
        /**
         * Im always working with the table of the entity
         * 
         */
        $query .= "FROM ".$this->entity;
        $this->setQuery($query);
    }
    
    /**
     * 
     * @param type $array WITH CONDITIONS
     * @param type $type OF THE CONDITION (AND / OR)
     * 
     * UPDATED: param $condition (< > =)
     */
    public function where($array, $condition = "=", $type = "AND")
    {
        $filter = "";
        
        switch ($condition)
        {
            case "BETWEEN":
                foreach ($array as $key => $value) 
                 {
                     $filter = "$key $condition '$value[0]' AND '$value[1]'";
                 }
                
                
                break;
            case "LIKE":
					foreach ($array as $key => $value) 
                 {
                     $filter = $key." like '%".$value."%'";
					 
                 }
                break;
            default:
                foreach ($array as $key => $value)
                {
                    $filter .= "$key $condition $value";
                    if($value !== end($array))
                    {   
                        $filter .= " ".$type;
                    }
                }
                break;
                
        }
        $this->setQuery(" WHERE ".$filter);
		
    }
    /**
     * 
     * @param type $table array with the table/s to join
     */
    public function join($table,$master = null)
    {
        $join = " ";
        /**
         * gets the tables to join
         */
        
        $master ? $master = $master : $master = $this->entity;
        
        if(is_array($table)===TRUE)
        {
            for($i = 0; $i<count($table);$i++)
            {
                /**
                 * Verify that exist mapping info for that table
                 */
                if(array_key_exists($table[$i], $this->map))
                {
                    $join .= $this->map[$table[$i]]["TYPE"]. " JOIN ".$table[$i]." ".$this->map[$table[$i]]["ALIAS"]." ON ".$this->map[$table[$i]]["ALIAS"].".".$this->map[$table[$i]]["CHILD"]." = $master.".$this->map[$table[$i]]["KEY"]." ";                
                }
            }
        }else
        {
            
            $join .= $this->map[$table]["TYPE"]. " JOIN ".$table." ".$this->map[$table]["ALIAS"]." ON ".$this->map[$table]["ALIAS"].".".$this->map[$table]["CHILD"]." = ".$this->map[$master]["ALIAS"].".".$this->map[$table]["KEY"]." "; 
        }
        
        
        $this->setQuery($join);
    }
    
    /**
     * 
     * Defines the order into the SQL
     */
    public function orderBy($alias, $column, $order)
    {
        $this->setQuery(" ORDER BY $alias.$column $order");
        
    }
    
    public function SqlRaw($query) {
        $this->setQuery(" ".$query);
    }
    

}
