<?php

/**
 * SiteMode Template left menu
 *
 * @category   Hatmeige
 * @package    Hatmeige_SiteMode
 * @author     Hatmeige <hatmeige@gmail.com>
 */
class Hatmeige_SiteMode_Block_Adminhtml_Template_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('template_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sitemode')->__('Template Information'));
    }
}
