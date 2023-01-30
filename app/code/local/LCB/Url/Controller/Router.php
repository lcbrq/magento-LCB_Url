<?php

class LCB_Url_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard
{
    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return boolean
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        $router = Mage::helper('lcb_url')->getRouter();

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
                $action = (isset($params['action'])) ? $params['action'] : "index";
                $request->setModuleName($module)->setControllerName($controller)->setActionName($action);
                return true;
            }
        }

        return false;
    }
}
