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
        return Mage::getStoreConfig(self::XML_PATH_CURRENT_MODE);
    }
    
    public function getConfig($path, $type = 'maintenance')
    {
        return Mage::getStoreConfig('sitemode/'.$type.'/'.$path);
    }
}