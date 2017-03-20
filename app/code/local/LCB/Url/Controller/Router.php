<?php

class LCB_Url_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard {

    /**
     * Init custom routing
     * 
     * @return Zend_Controller_Router_Rewrite
     */
    public function init()
    {
        if (file_exists(Mage::getBaseDir() . DS . 'app' . DS . 'etc' . DS . 'routes.xml')) {
            $router = new Zend_Controller_Router_Rewrite();
            $router->addConfig(new Zend_Config_Xml(Mage::getBaseDir() . DS . 'app' . DS . 'etc' . DS . 'routes.xml'));
            return $router;
        }
    }

    /**
     * @param Zend_Controller_Request_Http $request
     * 
     * @return boolean
     */
    public function match(Zend_Controller_Request_Http $request)
    {

        $router = $this->init();

        if (!$router) {
            return false;
        }

        $routes = $router->getRoutes();
        $path = trim($request->getPathInfo(), '/');

        foreach ($routes as $route) {
            if ($route->match($path)) {
                $params = $route->getDefaults();
                $module = $params['module'];
                $controller = (isset($params['controller'])) ? $params['controller'] : "index";
                $action = (isset($params['action'])) ? $params['controller'] : "index";
                $request->setModuleName($module)->setControllerName($controller)->setActionName($action);
                return true;
            }
        }

        return false;
    }

}
