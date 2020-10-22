<?php
/**
 * On development
 */
class Form {
    protected $action;
    private $method;
    protected $id;
    protected $class;
    private $fields;
    
    function getAction() {
        return $this->action;
    }

    function getMethod() {
        return $this->method;
    }

    function getId() {
        return $this->id;
    }

    function getClass() {
        return $this->class;
    }

    function getFields() {
        return $this->fields;
    }

    function setAction($action) {
        $this->action = $action;
    }

    function setMethod($method) {
        $this->method = $method;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setClass($class) {
        $this->class = $class;
    }

    function addFields(Field $field) {
        $this->fields[] = $field;
    }

    public function __construct($action = null, $method = "GET", $id = null, $class = null) {
        $this->action = $action;
        $this->method = $method;
        $this->id = $id;
        $this->class = $class;
    }

}
