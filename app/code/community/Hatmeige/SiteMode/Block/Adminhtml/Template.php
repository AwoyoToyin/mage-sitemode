<?php

/**
 * SiteMode Template block
 *
 * @category   Hatmeige
 * @package    Hatmeige_SiteMode
 * @author     Hatmeige <hatmeige@gmail.com>
 */
class Hatmeige_SiteMode_Block_Adminhtml_Template extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_template';
        $this->_blockGroup = 'sitemode';
        $this->_headerText = Mage::helper('sitemode')->__('Manage Templates');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('sitemode')->__('Add New Template'));
        } else {
            $this->_removeButton('add');
        }

    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('hatmeige/sitemode/template/' . $action);
    }

}
