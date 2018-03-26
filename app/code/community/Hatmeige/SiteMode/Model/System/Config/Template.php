<?php

/**
 * SiteMode Template
 *
 * @category   Hatmeige
 * @package    Hatmeige_SiteMode
 * @author     Hatmeige <hatmeige@gmail.com>
 */
class Hatmeige_SiteMode_Model_System_Config_Template
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $output = [];
        $templates = $this->getAvailableOptions();
        foreach ($templates as $template) {
            $output[] = [
                'value' => $template->getId(),
                'label' => Mage::helper('sitemode')->__($template->getTitle())
            ];
        }
        return $output;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $output = [];
        $templates = $this->getAvailableOptions();
        foreach ($templates as $template) {
            $output[$template->getId()] = Mage::helper('sitemode')->__($template->getTitle());
        }
        return $output;
    }
    
    protected function getAvailableOptions()
    {
        $storeId = $this->_getConfigScopeStoreId();
        $collection = Mage::getModel('sitemode/template')->getCollection();
        $collection->addStoreFilter($storeId);
        
        return $collection;
    }
    
    protected function _getConfigScopeStoreId()
    {
        try {
            $storeId = Mage_Core_Model_App::ADMIN_STORE_ID; // default store level

            $storeCode = (string)Mage::getSingleton('adminhtml/config_data')->getStore();
            $websiteCode = (string)Mage::getSingleton('adminhtml/config_data')->getWebsite();
            
            if ($storeCode !== '') {
                $storeId = Mage::getModel('core/store')->load($storeCode)->getId();
            } elseif ($websiteCode !== '') {
                $websiteId = Mage::getModel('core/website')->load($websiteCode)->getId();
                $storeId = Mage::app()->getWebsite($websiteId)->getDefaultStore()->getId();
            }
        } catch (Exception $ex) {

        }
        return $storeId;
    }
}