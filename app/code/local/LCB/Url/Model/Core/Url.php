<?php 

if (Mage::helper('core')->isModuleEnabled('Mana_Seo')) {

    abstract class LCB_Url_Model_Core_Url_Abstract extends Mana_Seo_Rewrite_Url {
        
    }

} else {

    abstract class LCB_Url_Model_Core_Url_Abstract extends Mage_Core_Model_Url {
        
    }

}

class LCB_Url_Model_Core_Url extends LCB_Url_Model_Core_Url_Abstract{

    public function getUrl($routePath = null, $routeParams = null)
    {
        if ($routePath == 'checkout/cart') {
            $routePath = 'winkelwagen';
        }

        return parent::getUrl($routePath, $routeParams);
    }
}
