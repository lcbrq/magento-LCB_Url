<?php

class LCB_Url_Model_Observer
{
    /**
     * Set NOINDEX/NOFOLLOW meta on pages with rewrite
     * 
     * @since 0.5.0
     * @return void
     */
    public function modifyRobotsMeta(Varien_Event_Observer $observer)
    {
        $request = Mage::app()->getRequest();
        $routePath = trim((string) $request->getPathInfo(), '/');
        $matched = Mage::helper('lcb_url')->matchRoute($routePath);

        if ($matched) {
            $head = Mage::app()->getLayout()->getBlock('head');
            if ($head) {
                $head->setRobots('NOINDEX,NOFOLLOW');
            }
        }
    }

}
