<?php

/**
 * Entity repository
 */

class SAT_MARCAS_Repository extends Repository{
    protected static $instance;
    
    public function __construct() {
        parent::__construct(get_class($this));
    }
    
    public static function singelton()
    {
        if(!(self::$instance instanceof self))
        {
            self::$instance = new self;
        }
        return self::$instance;
    }
	
	public function getMarcasModelos() {
		$this->select(["ID_SAT_MARCAS","MARCA_SAT","SAT_MODELOS"=>["ID_SAT_MODELOS","MODELO_SAT"]]);
		$this->join(array("SAT_MODELOS"));
		$this->getStmt()->query($this->query);
        return $this->getStmt()->getResult();
	}

  
}
