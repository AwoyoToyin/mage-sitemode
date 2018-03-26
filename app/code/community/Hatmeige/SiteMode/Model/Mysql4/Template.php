<?php

/**
 * SiteMode Template
 *
 * @category   Hatmeige
 * @package    Hatmeige_SiteMode
 * @author     Hatmeige <hatmeige@gmail.com>
 */
class Hatmeige_SiteMode_Model_Mysql4_Template extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Store model
     *
     * @var null|Mage_Core_Model_Store
     */
    protected $_store  = null;
    
    public function _construct() {
        $this->_init('sitemode/template', 'template_id');
    }
    
    /**
     * Process template data before deleting
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Hatmeige_SiteMode_Model_Mysql4_Template
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $condition = array(
            'template_id = ?'     => (int) $object->getId(),
        );

        $this->_getWriteAdapter()->delete($this->getTable('sitemode/template_store'), $condition);

        return parent::_beforeDelete($object);
    }

    /**
     * Process template data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Hatmeige_SiteMode_Model_Mysql4_Template
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        // modify create / update dates
        if ($object->isObjectNew() && !$object->hasCreatedAt()) {
            $object->setCreatedAt(Mage::getSingleton('core/date')->gmtDate());
        }

        $object->setUpdatedAt(Mage::getSingleton('core/date')->gmtDate());

        return parent::_beforeSave($object);
    }

    /**
     * Assign template to store views
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Hatmeige_SiteMode_Model_Mysql4_Template
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('sitemode/template_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = array(
                'template_id = ?'   => (int) $object->getId(),
                'store_id IN (?)'   => $delete
            );

            $this->_getWriteAdapter()->delete($table, $where);
        }

        if ($insert) {
            $data = array();

            foreach ($insert as $storeId) {
                $data[] = array(
                    'template_id'   => (int) $object->getId(),
                    'store_id'      => (int) $storeId
                );
            }

            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }

        return parent::_afterSave($object);
    }

    /**
     * Load an object using 'id' field if there's no field specified and value is not numeric
     *
     * @param Mage_Core_Model_Abstract $object
     * @param mixed $value
     * @param string $field
     * @return Hatmeige_SiteMode_Model_Mysql4_Template
     */
    public function load(Mage_Core_Model_Abstract $object, $value, $field = null)
    {
        if (!is_numeric($value) && is_null($field)) {
            $field = 'template_id';
        }

        return parent::load($object, $value, $field);
    }

    /**
     * Perform operations after object load
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Hatmeige_SiteMode_Model_Mysql4_Template
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());

            $object->setData('store_id', $stores);

        }

        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Hatmeige_SiteMode_Model_Page $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('template_store' => $this->getTable('sitemode/template_store')),
                $this->getMainTable() . '.template_id = template_store.template_id',
                array())
                ->where('is_active = ?', 1)
                ->where('template_store.store_id IN (?)', $storeIds)
                ->order('template_store.store_id DESC')
                ->limit(1);
        }

        return $select;
    }

    /**
     * Retrieves template title from DB by passed id.
     *
     * @param string $id
     * @return string|false
     */
    public function getModeTemplateTitleById($id)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getMainTable(), 'title')
            ->where('template_id = :template_id');

        $binds = array(
            'template_id' => (int) $id
        );

        return $adapter->fetchOne($select, $binds);
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $pageId
     * @return array
     */
    public function lookupStoreIds($pageId)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getTable('sitemode/template_store'), 'store_id')
            ->where('template_id = ?',(int)$pageId);

        return $adapter->fetchCol($select);
    }

    /**
     * Set store model
     *
     * @param Mage_Core_Model_Store $store
     */
    public function setStore($store)
    {
        $this->_store = $store;
        return $this;
    }

    /**
     * Retrieve store model
     *
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        return Mage::app()->getStore($this->_store);
    }

}
