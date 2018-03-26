<?php

/**
 * SiteMode Template
 *
 * @category   Hatmeige
 * @package    Hatmeige_SiteMode
 * @author     Hatmeige <hatmeige@gmail.com>
 */
class Hatmeige_SiteMode_Model_Template extends Mage_Core_Model_Abstract
{
    /**
     * Template's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    const CACHE_TAG              = 'sitemode_template';
    protected $_cacheTag         = 'sitemode_template';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'sitemode_template';
    
    public function _construct()
    {
        $this->_init('sitemode/template');
    }

    /**
     * Prepare template's statuses.
     * Available event sitemode_template_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        $statuses = new Varien_Object(array(
            self::STATUS_ENABLED => Mage::helper('sitemode')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('sitemode')->__('Disabled'),
        ));

        Mage::dispatchEvent('sitemode_template_get_available_statuses', array('statuses' => $statuses));

        return $statuses->getData();
    }

}
