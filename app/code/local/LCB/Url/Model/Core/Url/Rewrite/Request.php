<?php

class LCB_Url_Model_Core_Url_Rewrite_Request extends Mage_Core_Model_Url_Rewrite_Request {

    /**
     * Fix for gclid issue
     * 
     * @see http://stackoverflow.com/questions/26629722/magento-category-redirect-cuts-off-the-querystring-of-an-url
     * @return LCB_Url_Model_Core_Url_Rewrite_Request
     */
    protected function _processRedirectOptions()
    {
        $isPermanentRedirectOption = $this->_rewrite->hasOption('RP');

        $external = substr($this->_rewrite->getTargetPath(), 0, 6);
        if ($external === 'http:/' || $external === 'https:') {
            $destinationStoreCode = $this->_app->getStore($this->_rewrite->getStoreId())->getCode();
            $this->_setStoreCodeCookie($destinationStoreCode);
            $this->_sendRedirectHeaders($this->_rewrite->getTargetPath(), $isPermanentRedirectOption);
        }

        $targetUrl = $this->_request->getBaseUrl() . '/' . $this->_rewrite->getTargetPath();

        $storeCode = $this->_app->getStore()->getCode();
        if (Mage::getStoreConfig('web/url/use_store') && !empty($storeCode)) {
            $targetUrl = $this->_request->getBaseUrl() . '/' . $storeCode . '/' . $this->_rewrite->getTargetPath();
        }

        if ($this->_rewrite->hasOption('R') || $isPermanentRedirectOption) {

            $queryString = $this->_getQueryString();
            if ($queryString) {
                $targetUrl .= '?' . $queryString;
            }

            $this->_sendRedirectHeaders($targetUrl, $isPermanentRedirectOption);
        }

        $this->_request->setRequestUri($targetUrl);
        $this->_request->setPathInfo($this->_rewrite->getTargetPath());

        return $this;
    }

}
