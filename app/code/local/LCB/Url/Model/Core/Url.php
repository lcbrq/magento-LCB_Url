<?php

class LCB_Url_Model_Core_Url extends Mage_Core_Model_Url {

    public function getRoutePath($routeParams = array())
    {
        $routePath = parent::getRoutePath($routeParams);
        $customPath = Mage::helper('lcb_url')->matchRoute($routePath);
        if ($customPath) {
            return $customPath;
        }
        return $routePath;
    }

}
