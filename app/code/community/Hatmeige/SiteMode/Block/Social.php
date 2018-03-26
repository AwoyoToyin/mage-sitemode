<?php

/**
 * SiteMode Social
 *
 * @category   Hatmeige
 * @package    Hatmeige_SiteMode
 * @author     Hatmeige <hatmeige@gmail.com>
 */
class Hatmeige_SiteMode_Block_Social extends Mage_Core_Block_Template
{
    public function socialLink($type)
    {
        return Mage::helper('sitemode')->getConfig($type, 'social');
    }
}