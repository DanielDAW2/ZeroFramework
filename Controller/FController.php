<?php

include __SYS__.'View.php';

abstract class FController {
    protected $view;
    private static $action;
    private static $controller;
    private static $params;



    public function __construct() {
        $this->view = new View();
    }
    
    public static function setControllerAndAction($params)
    {
        if(empty($params))
        {
            $params["controller"] = "DefaultController";
            $params["action"] = "Error";
        }
        /**
         * Define de controller to call
         */
        self::$controller = $params["controller"];
        /**
         * Defines the methos to use
         */
        self::$action = $params["action"];
        /**
         * Saves the params if passed
         */
        isset($params["params"]) ? self::$params = $params["params"] : self::$params = null;
        $controllerRequested = __CONTROLLERS__.self::$controller.".php";
        /**
         * Verify that the controller exist
         */
        if(is_readable($controllerRequested));
        {
            /**
             * Requires the controller
             */
            require_once $controllerRequested;
            /**
             * Requires and instance of the controller
             */
            $controller = new self::$controller();
            /**
             * Very that the method exists on the controller
             */
            if(is_callable(array($controller,self::$action)))
            {
                /**
                 * Call the method of tha controller
                 */
                call_user_func(array($controller, self::$action), self::$params);
            }
        }
    }    
    
}
