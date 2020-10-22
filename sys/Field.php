<?php

/**
 * On development
 */
class Field extends Form{
    private $value;
    private $placeholder;
    private $name;
    public function getValue() {
        return $this->value;
    }

    public function getPlaceholder() {
        return $this->placeholder;
    }

    public function getName() {
        return $this->name;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function setPlaceholder($placeholder) {
        $this->placeholder = $placeholder;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function __construct($value = null, $placeholder = null, $name = null) {
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->name = $name;
    }

  
}
