<?php

include './Model/SAT_MARCAS.php';

class MarcasController extends FController{

    
    public function findAll()
    {
        $marcasEntity = new SAT_MARCAS();
        $marcas = $marcasEntity->getRepository()->getMarcasModelos();
        return $this->view->renderJSON($marcas);
    }

    
}
