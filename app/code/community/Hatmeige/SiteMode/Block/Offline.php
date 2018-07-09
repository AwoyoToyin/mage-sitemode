<?php

/**
 * SiteMode Offline
 *
 * @category   Hatmeige
 * @package    Hatmeige_SiteMode
 * @author     Hatmeige <hatmeige@gmail.com>
 */
class Hatmeige_SiteMode_Block_Offline extends Mage_Core_Block_Template
{
    /**
     * Template Variables
     * @var array
     */
    protected $variables = [
        'countdown', 'social', 'subscribe'
    ];
    
    public function getContent()
    {
        $type = $this->_getType();
        $templateId = Mage::helper('sitemode')->getConfig('template', $type);
        
        /** Load the template to use */
        $template = Mage::getModel('sitemode/template')->load($templateId);

        if (!$template->getId()) {
            return false;
        }
        
        // set template varialbe
        $content = Mage::helper('cms')->getBlockTemplateProcessor()->filter($template->getContent());
        
        foreach ($this->variables as $variable) {
            $childHtml = ''; // holds the html of the current child

            // handles countdown timer
            if ($variable === 'countdown' && Mage::helper('sitemode')->getConfig('showtimer', $type)) {
                $date = Mage::helper('sitemode')->getConfig('launchdate', $type);
                $time = str_replace(',', ':', Mage::helper('sitemode')->getConfig('launchtime', $type));
                $childContent = $date .' '. $time; // formats the date & time
                $childHtml = $this->getChild($variable)->setContent($childContent)->toHtml();
            }
            
            // handles newsletter
            if ($variable === 'subscribe' && Mage::helper('sitemode')->getConfig('showsubscribe', $type)) {
                $childHtml = $this->getChildHtml($variable);
            }
            
            // handles newsletter
            if ($variable === 'social' && Mage::helper('sitemode')->getConfig('showsocial', $type)) {
                $childHtml = $this->getChildHtml($variable);
            }

            $content = str_replace("{{var ".$variable."}}", $childHtml, $content);
        }
        
        return $content;
    }

    /**
     * Determine which template to use
     */
    protected function _getType()
    {
        return Mage::helper('sitemode')->getCurrentMode();
    }
}