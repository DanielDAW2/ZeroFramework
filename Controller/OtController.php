<?php

/**
 * I'll include that entity
 */
include __ENTITY__.'SAT_ORDEN_TRABAJO.php';
/**
 * Controller
 */
class OtController extends FController{

    
    public function index($params)
    {
        $ot = new SAT_ORDEN_TRABAJO();
       
        if(isset($params["order"]))
        {
            return $this->view->renderJSON($ot->getRepository()->getOt($params["order"]));
        }
        $result = $ot->getRepository()->getOtBtwDates($params["begin"],$params["end"]);
        return $this->view->renderJSON($result);
    }
    
    public function number()
    {
       $ot = new SAT_ORDEN_TRABAJO();
       
       $result = $ot->getRepository()->getOt($params["number"]);
       
     
       return $this->view->renderJson($result);
    }
    
    public function test()
    {
        
        $ot = new SAT_ORDEN_TRABAJO();
        
        $result = $ot->getRepository()->findAll();
        
        
        return $this->view->renderJSON($result);
    }
    
    public function getOrderNumber($number)
    {
        $ot = new SAT_ORDEN_TRABAJO();
        
        $result = $ot->getRepository()->getOrderNumber($number);
        
        return $this->view->renderJSON($result);
    }
    
    public function getOrderMats($order)
    {
        $ot = new SAT_ORDEN_TRABAJO();
        
        $repo = $ot->getRepository();
       
        $result = $repo->getOrderMats($order["order"]);
        
        return $this->view->renderJSON($result);
    }
	
	public function insertOrder($params)
	{
		$ot = new SAT_ORDEN_TRABAJO();
		$repo = $ot->getRepository();
		$params = $_POST;
		$params = array_map(function($v){
            return mb_convert_encoding($v,"ISO-8859-1");
        },$params);
		
		switch($params["orden"])
		{
            case '1':
                $result = $ot->getRepository()->getOt($params["caso"]);
			    return $this->view->renderJSON($result);
            break;
            case '0':
                return $this->view->renderJSON($repo->addOt($params));
            break;
        }
          
    }
    
    public function updateOrder($params)
	{
		$ot = new SAT_ORDEN_TRABAJO();
		$repo = $ot->getRepository();
		$params = $_POST;
		$params = array_map(function($v){
            return mb_convert_encoding($v,"ISO-8859-1");
        },$params);
		
        $repo->updateOrder($params);
        
        return $this->view->renderJSON("OK");
          
	}
	
	public function getAllOt()
	{
		$ot = new SAT_ORDEN_TRABAJO();
		
		$repo = $ot->getRepository();
		
		return $this->view->renderJSON($repo->setAllOt());
	}
	
	public function getAllOtByClinica($params)
	{
		$ot = new SAT_ORDEN_TRABAJO();
		
		$repo = $ot->getRepository();
		
		return $this->view->renderJSON($repo->setAllOtbyClinica($params["clinica"]));
	}
	
	public function getAllOtSrv()
	{
		$ot = new SAT_ORDEN_TRABAJO();
		
		$repo = $ot->getRepository();
		
		return $this->view->renderJSON($repo->getAllOtSrv());
	}
	
		

    
}
