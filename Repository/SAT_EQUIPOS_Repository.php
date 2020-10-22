<?php

/**
 * Entity repository
 */

class SAT_EQUIPOS_Repository extends Repository{
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
    /**
     * Gets ID of SAT_MARCA AND SAT_MODELOS and the part number
     */
	public function getPn(){
        $this->select(array("SAT_EQ_CLASES"=>["CLASE_EQUIPO"],"SAT_EQUIPOS"=>["ID_SAT_MARCAS","ID_SAT_MODELOS"],"SAT_MARCAS"=>["MARCA_SAT"],"SAT_MODELOS"=>["MODELO_SAT"]));
        $this->join(ARRAY("SAT_EQ_CLASES","SAT_MARCAS","SAT_MODELOS"));
		$this->getStmt()->query($this->query);
        return $this->getStmt()->getResult();
	}

  
}
