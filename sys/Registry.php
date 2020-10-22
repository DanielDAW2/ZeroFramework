<?php
/**
 * Save the App data to a single array using singelton
 *
 * @author DanielRaya
 */
class Registry {
    public $data= array();
    public static $instance;
    
    /**
     * Send and instance of itself, this avoid to create multiple instances of regsitry
     */
    public static function singelton()
    {
        if(!(self::$instance instanceof self))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Set data to the registry as key value
     */
    public function __set($key, $value) {
        $this->data[$key]=$value;
    }
    
    /**
     * 
     * @param type $key to being search on the registry
     * @return the value of the key or false
     */
    public function __get($key) {
        if(array_key_exists($key, $this->data))
        {
            return $this->data[$key];
        }
        return false;
    }
    
    /**
     * Same as __Set but with and array
     */
    public function setMultipleData($array = array())
    {
        foreach ($array as $key => $value) {
            $this->data[$key] = $value;
        }
    }
    
    /**
     * 
     * Saves the routes defined in /config/routes.json to the registry
     */
    public function setUrls($array = array())
    {
        foreach ($array as $key => $value) {
            $this->data["url"][$key] = $value;
        }
    }
    
}
