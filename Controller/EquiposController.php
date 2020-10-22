<?php

include './Model/SAT_EQUIPOS.php';

class EquiposController extends FController{

    
    public function index()
    {
        $equipos = new SAT_EQUIPOS();
        $equipos = $equipos->getRepository()->findAll();
        return $this->view->renderJSON($equipos);
    }
    
   public function getPN()
    {
        $equipo = new SAT_EQUIPOS();
		$PN = $equipo->getRepository()->getPn();
		
		return $this->view->renderJSON($PN);
    }


    
}
