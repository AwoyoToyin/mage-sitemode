<?php

/**
 * SiteMode Observer
 *
 * @category   Hatmeige
 * @package    Hatmeige_SiteMode
 * @author     Hatmeige <hatmeige@gmail.com>
 */
class Hatmeige_SiteMode_Model_Observer
{
    public function setSiteMode(Varien_Event_Observer $observer)
    {
        /** If admin store, do nothing */
        if (Mage::app()->getStore()->getCode() !== 'admin') {
            $action = $observer->getEvent()->getControllerAction();
            $requestPath = trim($action->getRequest()->getPathInfo(), '/');

            // if store is in live mode and tring to access offline route, redirect to home page
            if (
                ($this->_isLiveMode() && $this->_isRequestPathOffline($requestPath)) ||
                (!$this->_isLiveMode() && $this->_isRequestPathOffline($requestPath) && $this->isIPAllowed())
            ) {
                $this->_redirect($action, Mage::getUrl('/'));
            } else if (!$this->_isLiveMode() && !$this->_isRequestPathOffline($requestPath) && !$this->isIPAllowed()) {
                $this->_redirect($action, Mage::getUrl('offline', ['_secure' => true]));
            }
        }
    }
    
    /**
     * Checks if Customer's IP is white listed
     * @return boolean
     */
    protected function isIPAllowed()
    {
        // get the allowed ips and shave off any white spaces
        $addresses = str_replace(' ', '', Mage::helper('sitemode')->getConfig('allowedips', 'general'));
        if (!$addresses) {
            return false;
        }

        if (!preg_match('/^[^\s,]+(,[^\s,]+)*$/', $addresses)) {
            return false;
        }
        
        $remoteAddr = Mage::helper('core/http')->getRemoteAddr(false);
        
        $allowedIPs = explode(',', trim($addresses));

        return in_array($remoteAddr, $allowedIPs);
    }

    /**
     * Checks if store is in live mode
     * @return boolean
     */
    protected function _isLiveMode()
    {
        $mode = Mage::helper('sitemode')->getCurrentMode();
        return $mode === Hatmeige_SiteMode_Helper_Data::LIVE_MODE;
    }

    /**
     * Checks if the customer is trying to access the offline page
     * @param type $requestPath
     * @return boolean
     */
    protected function _isRequestPathOffline($requestPath)
    {
        if (strpos($requestPath, 'offline') !== false) {
            return true;
        }
        return false;
    }
    
    /**
     * Handles redirect
     * @param type $action
     * @param type $path
     */
    protected function _redirect($action, $path)
    {
        $action->getResponse()->setRedirect($path)->sendResponse();
        $action->getRequest()->setDispatched(true);
    }

}
