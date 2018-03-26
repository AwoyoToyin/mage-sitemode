<?php

class Hatmeige_SiteMode_Block_Adminhtml_System_Config_Info extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{
    protected $_template = 'hatmeige/sitemode/information.phtml';
    /**
     * Retrieve is allow and show block
     *
     * @return bool
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->toHtml();
    }
}