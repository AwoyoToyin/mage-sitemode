<?php

/**
 * SiteMode Router
 *
 * @category   Hatmeige
 * @package    Hatmeige_SiteMode
 * @author     Hatmeige <hatmeige@gmail.com>
 */
class Hatmeige_SiteMode_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard
{
    /**
     * Validate and Match router with the Page and modify request
     *
     * @param Zend_Controller_Request_Http $request
     * @return bool
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        if (!Mage::isInstalled())
        {
            Mage::app()->getFrontController()->getResponse()
                    ->setRedirect(Mage::getUrl('install'))
                    ->sendResponse();
            exit;
        }

        $requestPath = trim($request->getPathInfo(), '/');

        $condition = new Varien_Object(array(
            'identifier' => $requestPath,
            'continue' => true
        ));
        Mage::dispatchEvent('sitemode_controller_router_match_before', array(
            'router' => $this,
            'condition' => $condition
        ));

        $identifier = $condition->getIdentifier();

        if ($condition->getRedirectUrl()) {
            Mage::app()->getFrontController()->getResponse()
                    ->setRedirect($condition->getRedirectUrl())
                    ->sendResponse();
            $request->setDispatched(true);
            return true;
        }

        if (!$condition->getContinue()) {
            return false;
        }

        /**
         * Get template id based on current store mode
         * and selected template
         */
        $mode = Mage::helper('sitemode')->getCurrentMode();
        var_dump($mode); die;
        if ($mode === Hatmeige_SiteMode_Helper_Data::LIVE_MODE) {
            return false;
        }
        
        $templateId = Hatmeige_SiteMode_Helper_Data::XML_PATH_MAINTENANCE_PAGE;
        if ($mode === Hatmeige_SiteMode_Helper_Data::XML_PATH_COMING_PAGE) {
            $templateId = Hatmeige_SiteMode_Helper_Data::XML_PATH_COMING_PAGE;
        }

        $request->setModuleName('sitemode')
                ->setControllerName('index')
                ->setActionName('index')
                ->setParam('template_id', $templateId);

        $request->setAlias(
            Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS, $identifier
        );

        return true;
    }

}
