<?php

class LCB_Url_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @var Zend_Controller_Router_Rewrite
     */
    protected $router;

    /**
     * @var Zend_Config_Xml
     */
    protected $config;

    /**
     * @var string
     */
    private $storeCode = null;

    /**
     * Get custom routing config
     *
     * @return Zend_Config_Xml|false
     */
    public function getConfig()
    {
        if ($this->config) {
            return $this->config;
        }

        if (file_exists(Mage::getBaseDir() . DS . 'app' . DS . 'etc' . DS . 'routes.xml')) {
            return $this->config = new Zend_Config_Xml(Mage::getBaseDir() . DS . 'app' . DS . 'etc' . DS . 'routes.xml');
        }

        return false;
    }

    /**
     * Get router if custom routing is set
     *
     * @return Zend_Controller_Router_Rewrite|false
     */
    public function getRouter()
    {
        if ($this->router) {
            return $this->router;
        }

        if ($config = $this->getConfig()) {
            $store = Mage::app()->getStore()->getCode();
            if ($config->get($store)) {
                $config = $config->get($store);
            } elseif ($config->get('default')) {
                $config = $config->get('default');
            }
            $router = new Zend_Controller_Router_Rewrite();
            $router->addConfig($config);
            return $this->router = $router;
        }

        return false;
    }

    /**
     * Match getUrl route to custom routing
     *
     * @param  string       $routePath
     * @return false|string
     */
    public function matchRoute($routePath)
    {
        if ($config = $this->getConfig()) {

            if (!$this->storeCode) {
                $this->storeCode = Mage::app()->getStore()->getCode();
            }

            $path = trim($routePath, '/');
            $storeCode = $this->storeCode;
            if ($config->get($storeCode)) {
                $config = $config->get($storeCode);
            } elseif ($config->get('default')) {
                $config = $config->get('default');
            }

            foreach ($config as $route => $data) {
                if ($path === $data->get('name')) {
                    return $data->get('route') . DS;
                }
            }
        }

        return false;
    }

    /**
     * Get last url
     * @author Jigsaw Marcin Gierus<martin@lcbrq.com>
     * @return string
     */
    public function getLastUrl()
    {
        $url = Mage::app()->getRequest()->getServer('HTTP_REFERER');
        if ((strpos($url, Mage::app()->getStore()->getBaseUrl()) !== 0) && (strpos($url, Mage::app()->getStore()->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, true)) !== 0)) {
            $url = Mage::app()->getStore()->getBaseUrl();
        }

        return $url;
    }
}
