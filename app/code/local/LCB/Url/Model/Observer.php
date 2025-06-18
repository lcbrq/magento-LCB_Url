<?php

class LCB_Url_Model_Observer
{
    /**
     * @var bool
     */
    private $redirectToNewRoute = true;

    /**
     * Set 301 redirect on old routes
     *
     * @since 0.6.0
     * @return void
     */
    public function redirectToNewRoute(Varien_Event_Observer $observer)
    {
        if ($this->redirectToNewRoute) {
            $controller = $observer->getEvent()->getControllerAction();
            $request = $controller->getRequest();
            $routePath = trim((string) $request->getPathInfo(), '/');

            if ($matchedRoute = Mage::helper('lcb_url')->matchRoute($routePath)) {
                $newUrl = Mage::getUrl($matchedRoute);
                $controller->getResponse()->setRedirect($newUrl, 301)->sendResponse();
            }
        }
    }

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
