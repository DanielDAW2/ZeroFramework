<?php

/**
 * Class to make custom queries to the database based of the entity
 */
class SAT_ORDEN_TRABAJO_Repository extends Repository{
    protected static $instance;
    
    /**
     * Generates and repository based of the entity that is being created
     */
    public function __construct() {
        /**
         * Instance of object based of this class names
         */
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
     * Custom Query using parents methods
     * @return type
     */
    public function getOt($id)
    {
        $this->select(array("SAT_ORDEN_TRABAJO"=>["CAMPOCONFL4","ID_SAT_ORDEN_TRABAJO","N_ORDEN_TRABAJO","ID_CLIDIRECCIONES","TRABAJOS_AREALIZAR","FECHA_ENTRADA","FECHA_SALIDA","AVERIAS_DETECTADAS","INDICACIONES_CLIENTE","CAMPOCONFC1","CAMPOCONFC2","CAMPOCONFC3","CAMPOCONFC4","OBSERVACIONES","OBSERVACIONES_INT", "ID_SAT_ORDPRIORIDAD", "ID_SAT_ORDTIPO"],"SAT_EQUIPOS"=>"CODIGO_EQUIPO", "SERIES"=>"ID_SERIES","SAT_ORDEN_SITUACION"=>"ID_SAT_ORDEN_SITUACION","PRESUPUESTOS"=>"N_PRESUPUESTO"));
        $this->join(array("SAT_EQUIPOS","SERIES","SAT_ORDEN_SITUACION","PRESUPUESTOS"));
		IF(is_int($id))
		{
			$this->where(array("SAT_ORDEN_TRABAJO.CAMPOCONFC1"=>"'$id'"));
			$this->SqlRaw("OR SAT_ORDEN_TRABAJO.N_ORDEN_TRABAJO = '$id'");
		}else
		{
			$this->where(array("SAT_ORDEN_TRABAJO.CAMPOCONFC1"=>"$id"),'LIKE');
			$this->SqlRaw("OR SAT_ORDEN_TRABAJO.N_ORDEN_TRABAJO = '$id'");
		}
        $this->getStmt()->query($this->query);
        return $this->getStmt()->getResult();
    }
    
    public function getOtBtwDates($begin, $end)
    {
        $this->select(array("SAT_ORDEN_TRABAJO"=>["CAMPOCONFL4","ID_SAT_ORDEN_TRABAJO","N_ORDEN_TRABAJO","ID_CLIDIRECCIONES","TRABAJOS_AREALIZAR","FECHA_ENTRADA","AVERIAS_DETECTADAS","INDICACIONES_CLIENTE","CAMPOCONFC1","CAMPOCONFC2","CAMPOCONFC3","CAMPOCONFC4","OBSERVACIONES","OBSERVACIONES_INT"],"SAT_EQUIPOS"=>"CODIGO_EQUIPO", "SERIES"=>"SERIE","SAT_ORDEN_SITUACION"=>"SITUACION_ORDEN"));
		$this->join(array("SAT_EQUIPOS","SERIES","SAT_ORDEN_SITUACION"));
		$this->where(array("SAT_ORDEN_TRABAJO.FECHA_ENTRADA"=>[$begin,$end]),"BETWEEN");
        $this->getStmt()->query($this->query);
        return $this->getStmt()->getResult();
    }
    
    
    public function getOrderMats($order = null)
    {
        $this->select(array("LINEAS_PRESUPUESTOS"=>["ID_LINEAS_PRESUPUESTOS", "DESCRIPCION","CANTIDAD","ID_ARTICULOS"], $this->entity => ["N_ORDEN_TRABAJO"]));
        $this->join(array("PRESUPUESTOS"));
        $this->join("LINEAS_PRESUPUESTOS","PRESUPUESTOS");
        $this->join("ARTICULOS","LINEAS_PRESUPUESTOS");
        $this->where(array("SAT_ORDEN_TRABAJO.N_ORDEN_TRABAJO"=>"'$order'"));
		$this->SqlRaw("OR SAT_ORDEN_TRABAJO.CAMPOCONFC1 = '$order' ");
        $this->SqlRaw("AND ART.PRODUCTO_SERVICIO NOT LIKE 'Servicio'");

        $this->getStmt()->query($this->query);
        return $this->getStmt()->getResult();
    }
	
	public function addOt($params)
	{
		try{
			
		$this->query = " 
		INSERT INTO SAT_ORDEN_TRABAJO (ID_SAT_ORDEN_TRABAJO, ID_DELEGACIONES, ID_ALMACENES ,ID_CLIENTES, ID_MONEDAS, ID_CLIDIRECCIONES, ID_SERIES,
    ID_SAT_ORDTIPO, ID_SAT_ORDEN_SITUACION, ID_SAT_ORDPRIORIDAD,
    ID_EMPLEADOS_SUB1, FECHA_ENTRADA, FECHA, ACEPTADO,
    INDICACIONES_CLIENTE, AVERIAS_DETECTADAS, TRABAJOS_AREALIZAR, CODIGO_CLI,
    ID_POBLACIONES, ID_PROVINCIA, CAMPOCONFC1, CAMPOCONFC2, CAMPOCONFC3,
    CAMPOCONFC4, CAMPOCONFC5, CAMPOCONFC11, CAMPOCONFC12, CAMPOCONFC13, CAMPOCONFC14, CAMPOCONFC10, CAMPOCONFC9, CAMPOCONFC8, NOMBRECOMERCIAL, NOMBREFISCAL, CIF_NIF, DIRECCION, E_MAIL, TELEFONOS)
	VALUES (
			NULL,
			 1,
			 1,
			'3',
			'3', 
			'".$params["delegacion"]."', 
			'".$params["serie"]."',
			'".$params["tipo"]."',
			'".$params["situacion"]."',
			'".$params["prioridad"]."',
			'1', 
			'".$params["fechaentrada"]."',
			'".$params["fechaentrada"]."', 
			'A', 
			'".$params["indicaciones-cliente"]."', 
			'".$params["averias"]."', 
			'".$params["trabajos"]."', 
			'1',
			'".$params["poblaciones"]."',
			'".$params["provincia"]."',
			'".$params["caso"]."', 
			'".$params["nserie"]."',
			'".$params["marca"]."',
			'".$params["modelo"]."',
			'".$params["ProductNumber"]."',
			'".$params["color"]."',
			'".$params["tipo_equipo"].$params["tiquet_equipo"]."',
			'".$params["pantalla"]."',
			'".$params["tiquet_pr"]."',
			'".$params["observaciones"]."',
			'".$params["accesorios"]."',
			'".$params["observaciones_equipo"]."',
			'FNAC',
			'".$params["nombrecomercial"]."',
			'A80500200',
			'".$params["direccion"]."',
			'".$params["email"]."',
			'".$params["telefono"]."'
		)

		returning N_ORDEN_TRABAJO
		;
		";
		
		$this->getStmt()->getPDO()->beginTransaction();
		$val = $this->getStmt()->query($this->query);
		$this->getStmt()->execute();
		$this->getStmt()->getPDO()->commit();

		$file = fopen("sql.sql","w+");

		fwrite($file,$this->getSQL());
		fclose($file);
		$this->query = "";



		return $this->getStmt()->resultset();

		
		}catch(\PDOException $ex)
		{
			return $this->getSQL()." ".$ex->getMessage();
		}
		
	}
	
	public function setAllOt()
	{
		$this->select(array($this->entity=>["CAMPOCONFL4","N_ORDEN_TRABAJO","ID_CLIDIRECCIONES","ID_SAT_ORDTIPO","ID_SAT_ORDEN_SITUACION","FECHA_ENTRADA","FECHA_SALIDA","INDICACIONES_CLIENTE", "AVERIAS_DETECTADAS","TRABAJOS_AREALIZAR","OBSERVACIONES","OBSERVACIONES_INT","CAMPOCONFC1","ID_SERIES","ID_SAT_ORDPRIORIDAD","CAMPOCONFC2","CAMPOCONFC3","CAMPOCONFC4","CAMPOCONFC5"],"PRESUPUESTOS"=>"N_PRESUPUESTO"));
		$this->join(array("PRESUPUESTOS"));
		$this->SqlRaw(" WHERE SAT_ORDEN_TRABAJO.ID_SAT_ORDEN_SITUACION <> 28 AND SAT_ORDEN_TRABAJO.ID_SAT_ORDEN_SITUACION <> 37 AND SAT_ORDEN_TRABAJO.ID_CLIDIRECCIONES <> 15");
		$this->getStmt()->query($this->query);
		return $this->getStmt()->getResult();
	}
	
	public function setAllOtbyClinica($clinica)
	{
		$this->select(array($this->entity=>["CAMPOCONFL4","N_ORDEN_TRABAJO","ID_CLIDIRECCIONES","ID_SAT_ORDTIPO","ID_SAT_ORDEN_SITUACION","FECHA_ENTRADA","FECHA_SALIDA","INDICACIONES_CLIENTE", "AVERIAS_DETECTADAS","TRABAJOS_AREALIZAR","OBSERVACIONES","OBSERVACIONES_INT","CAMPOCONFC1","ID_SERIES","ID_SAT_ORDPRIORIDAD","CAMPOCONFC2","CAMPOCONFC3","CAMPOCONFC4"],"PRESUPUESTOS"=>"N_PRESUPUESTO"));
		$this->join(array("PRESUPUESTOS"));
		$this->SqlRaw(" WHERE SAT_ORDEN_TRABAJO.ID_SAT_ORDEN_SITUACION <> 28 AND SAT_ORDEN_TRABAJO.ID_SAT_ORDEN_SITUACION <> 37 AND SAT_ORDEN_TRABAJO.ID_CLIDIRECCIONES = $clinica");
		$this->getStmt()->query($this->query);
		return $this->getStmt()->getResult();
	}
	
	public function getAllOtSrv()
	{
		$this->select(array($this->entity=>["CAMPOCONFL4","N_ORDEN_TRABAJO","ID_CLIDIRECCIONES","ID_SAT_ORDTIPO","ID_SAT_ORDEN_SITUACION","FECHA_ENTRADA","FECHA_SALIDA","INDICACIONES_CLIENTE", "AVERIAS_DETECTADAS","TRABAJOS_AREALIZAR","OBSERVACIONES","OBSERVACIONES_INT","CAMPOCONFC1","ID_SERIES","ID_SAT_ORDPRIORIDAD"],"PRESUPUESTOS"=>"N_PRESUPUESTO"));
		$this->join(array("PRESUPUESTOS"));
		$this->SqlRaw(" WHERE SAT_ORDEN_TRABAJO.ID_SAT_ORDEN_SITUACION <> 28");
		$this->getStmt()->query($this->query);
		return $this->getStmt()->getResult();
	}

	public function updateOrder($props)
	{
		$this->SqlRaw("
		UPDATE SAT_ORDEN_TRABAJO a
		SET 
			a.ID_SAT_ORDEN_SITUACION = '".$props["situacion"]."', 
			a.CAMPOCONFL4 = '".$props["pr"]."',
			a.OBSERVACIONES_INT = '".$props["message"]."',
			a.CAMPOCONFC15 = '".$props["tiquet"]."'
		WHERE
			a.N_ORDEN_TRABAJO = '".$props["order"]."'
			");
		$this->getStmt()->getPDO()->beginTransaction();
		$val = $this->getStmt()->query($this->query);
		$this->getStmt()->execute();
		$this->getStmt()->getPDO()->commit();
	}


    /**
     *   Overriding parent method findAll()
     */
    public function findAll() {
        $this->select(array("SAT_ORDEN_TRABAJO"=>["CAMPOCONFL4","N_ORDEN_TRABAJO","FECHA_ENTRADA","FECHA_SALIDA","INDICACIONES_CLIENTE","AVERIAS_DETECTADAS","FECHA_TERMINADO"],"SERIES"=>"SERIE","SAT_ORDEN_SITUACION"=>"SITUACION_ORDEN","SAT_ORDPRIORIDAD"=>"ID_SAT_ORDPRIORIDAD"));
        $this->join(array("SAT_EQUIPOS","SERIES","SAT_ORDEN_SITUACION","SAT_ORDPRIORIDAD"));
        $this->orderBy($this->entity, "N_ORDEN_TRABAJO", "DESC");
        $this->getStmt()->query($this->query);
        return $this->getStmt()->getResult();
    }
}
