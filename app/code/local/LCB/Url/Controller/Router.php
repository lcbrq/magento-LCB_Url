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
                $config = $route->getDefaults();
                $module = $config['module'];
                $controller = (isset($config['controller'])) ? $config['controller'] : "index";
                $action = (isset($config['action'])) ? $config['action'] : "index";
                $request->setModuleName($module)->setControllerName($controller)->setActionName($action);

                if (!empty($config['params'])) {
                    $request->setParams($config['params']);
                }

                return true;
            }
        }

        return false;
    }
}
