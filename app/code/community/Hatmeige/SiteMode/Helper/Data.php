<?php

/**
 * SiteMode Template edit form main tab
 *
 * @category   Hatmeige
 * @package    Hatmeige_SiteMode
 * @author     Hatmeige <hatmeige@gmail.com>
 */
class Hatmeige_SiteMode_Helper_Data extends Mage_Core_Helper_Abstract
{
    CONST LIVE_MODE                                     = 'live';
    CONST COMING_SOON_MODE                              = 'comingsoon';
    CONST MAINTENANCE_MODE                              = 'maintenance';
    
    const XML_PATH_CURRENT_MODE                         = 'sitemode/general/current_mode';
    
    public function getExtensionVersion()
    {
        return (string) Mage::getConfig()->getNode()->modules->Hatmeige_SiteMode->version;
    }
    
    public function getCurrentMode()
    {
        $store_id = $this->_getStoreId();
        return Mage::getStoreConfig(self::XML_PATH_CURRENT_MODE, $store_id);
    }
    
    public function getConfig($path, $type = 'maintenance')
    {
        return Mage::getStoreConfig('sitemode/'.$type.'/'.$path);
    }

    /**
     * Get Current Store ID
     * If adminhtml, gets the Store ID from the config scope
     * Else, get the Store ID from the current store view
     */
    protected function _getStoreId()
    {
        $store = Mage::getSingleton('adminhtml/config_data')->getStore();
        $website = Mage::getSingleton('adminhtml/config_data')->getWebsite();
        if (strlen($store)) {
            $store_id = Mage::getModel('core/store')->load($store)->getId();
        } elseif (strlen($website)) {
            $website_id = Mage::getModel('core/website')->load($website)->getId();
            $store_id = Mage::app()->getWebsite($website_id)->getDefaultStore()->getId();
        } else {
            $store_id = Mage::app()->getStore()->getStoreId();
        }
        return $store_id;
    }
}
