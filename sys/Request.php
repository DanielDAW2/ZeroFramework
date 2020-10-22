<?php

/**
 * Class that analyzies the uri and adds the url and the params to the registry
 */
class Request {
    
    public static function decomposeUrl()
    {
        $registry = Registry::singelton();
        /**
         * Split url adn params
         */
        $url = explode('?', $_SERVER['REQUEST_URI']);
        /**
         * Saves the url on the registry
         */
        $registry->__set("urlreq",$url[0]);
        /**
         * Saves the method
         */
        $registry->__set("method",$_SERVER["REQUEST_METHOD"]);
        /**
         * If i get params
         */
        if(isset($url[1]))
        {
            $urlparams = $url[1];
            /**
             * I split all params
             */
            $arrayparams = explode('&', $urlparams);
            $params = array();
            foreach ($arrayparams as $value) 
            {
                /*
                 * Split key and value
                 */
                $value = explode('=', $value);
                /**
                 * Save the params into and array
                 */
                $params[$value[0]]=$value[1];
            }
            /**
             * Saves the params into the registry
             */
            $registry->__set("urlreqparams",$params);
            
        }
        
    }
}
