<?php

class SAT_ORDEN_TRABAJO_Form extends Field{
    
    public function buildForm()
    {
        $this->addFields(new Field(null, "Introduce el Numero de orden", $name));
    }
    
    public function getInstance()
    {
        return new self;
    }
}
