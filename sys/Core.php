<?php
/**
 * Core of the apps, where the magic happens,
 * here is the first stop of the app
 * 
 * Defines all the constants and all the resources that we will need for the app
 * Also call the front controller with the controller asigned to that route
 */
define("__ROUTES__", "./sys/config/routes.json");
define("__SYS__", "./sys/");
define("__REPOSITORY__","./Repository/");
define("__CONTROLLERS__", "./Controller/");
define("__CONTROLLERS_AB__", "\Controller\\");
define("__VIEWS__", "./public/");
define("__FORM__", "./Form/");
define("__ORM__", "./sys/ORM/");
define("__ENTITY__","./Model/");

include __SYS__.'Registry.php';
include __SYS__.'Request.php';
include __SYS__.'Entity.php';
include __REPOSITORY__.'Repository.php';
include __CONTROLLERS__.'FController.php';
include __SYS__.'Stmt.php';

class Core {
    protected $registry;
    protected $router;
    private $controller = array();
    
    /**
     * Engines the application
     */
    public function init()
    {
        /** Sets the routes on the ./sys/config/routes.json to the registry
         * 
         */
        $this->registry->setUrls(json_decode(file_get_contents(__ROUTES__),true));
        
        /**
         * Routes the app
         */
        $this->route();
    }
    
    public function route()
    {
        /**
         * gets the url decomposed (uri / array of params like key => value)
         */
        Request::decomposeUrl();
        /**
         * Follow the array to get the path that is being asked
         */
        foreach ($this->registry->__get("url") as $key => $value)
        {
            /**
             * If found saves the controller and the action defined on routes.json to the controller
             */
            if($this->registry->__get("urlreq")===$value['path'])
            {
                $this->controller["controller"] = $value["controller"];
                $this->controller["action"] = $value["action"];
                /**
                 * If i get params decomposing the url il also save it
                 */
                if($this->registry->__get("urlreqparams"))
                {
                    $this->controller["params"] = $this->registry->__get("urlreqparams");
                }
            }
        }
        /**
         * Call the front controller to redirect to the controller that its called
         * @param $this->Controller (array with controller, action and params)
         */
        FController::setControllerAndAction($this->controller);
    }
    
    /**
     * When app starts also instanciate a registry
     */
    public function __construct() 
    {
        $this->registry = Registry::singelton();
    }
}
