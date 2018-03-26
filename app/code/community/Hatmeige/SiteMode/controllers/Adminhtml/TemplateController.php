<?php

/**
 * SiteMode Template
 *
 * @category   Hatmeige
 * @package    Hatmeige_SiteMode
 * @author     Hatmeige <hatmeige@gmail.com>
 */
class Hatmeige_Sitemode_Adminhtml_TemplateController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Hatmeige_Sitemode_Adminhtml_TemplateController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('hatmeige/sitemode')
            ->_addBreadcrumb(Mage::helper('sitemode')->__('Sitemode'), Mage::helper('sitemode')->__('Sitemode'))
            ->_addBreadcrumb(Mage::helper('sitemode')->__('Manage Templates'), Mage::helper('sitemode')->__('Manage Templates'));
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Sitemode'))
             ->_title($this->__('Manage Templates'));

        $this->_initAction();
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('sitemode/adminhtml_template_grid')
                ->setUseAjax(true)
                ->toHtml()
        );
    }

    /**
     * Create new Template
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit CMS page
     */
    public function editAction()
    {
        $this->_title($this->__('Sitemode'))
             ->_title($this->__('Manage Templates'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('template_id');
        $model = Mage::getModel('sitemode/template');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('cms')->__('This template no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Template'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('sitemode_template', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('sitemode')->__('Edit Template')
                    : Mage::helper('sitemode')->__('New Template'),
                $id ? Mage::helper('sitemode')->__('Edit Template')
                    : Mage::helper('sitemode')->__('New Template'));

        $this->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        // check if data sent
        $data = $this->getRequest()->getPost();
        if (!$data) {
            $this->_redirect('*/*/');
            return;
        }
        //init model and set data
        $model = Mage::getModel('sitemode/template');

        $id = $this->getRequest()->getParam('template_id');
        if ($id) {
            $model->load($id);
        }

        $model->setData($data);

        Mage::dispatchEvent('sitemode_template_prepare_save', array('template' => $model, 'request' => $this->getRequest()));

        // try to save it
        try {
            // save the data
            $model->save();

            // display success message
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('sitemode')->__('The template has been saved.'));
            // clear previously saved data from session
            Mage::getSingleton('adminhtml/session')->setFormData(false);
            // check if 'Save and Continue'
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('template_id' => $model->getId(), '_current'=>true));
                return;
            }
            // go to grid
            $this->_redirect('*/*/');
            return;

        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()->addException($e,
                Mage::helper('sitemode')->__('An error occurred while saving the template.'));
        }

        $this->_getSession()->setFormData($data);
        $this->_redirect('*/*/edit', array('template_id' => $this->getRequest()->getParam('template_id')));
        return;
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('template_id');
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('sitemode/template');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('sitemode')->__('The template has been deleted.'));
                // go to grid
                Mage::dispatchEvent('sitemode_template_on_delete', array('title' => $title, 'status' => 'success'));
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::dispatchEvent('sitemode_template_on_delete', array('title' => $title, 'status' => 'fail'));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('template_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sitemode')->__('Unable to find a template to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'new':
            case 'save':
                return Mage::getSingleton('admin/session')->isAllowed('hatmeige/sitemode/template/save');
                break;
            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('hatmeige/sitemode/template/delete');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('hatmeige/sitemode/template');
                break;
        }
    }
}
