<?php

/* @var $installer Hatmeige_SiteMode_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/** Create Templates Table */
$template = $installer->getTable('sitemode/template');

// Check if the table already exist
if ($installer->getConnection()->isTableExists($template) !== true) {
    $table = $installer->getConnection()
            ->newTable($template)
            ->addColumn('template_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
                    ), 'ID')
            ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 50, array(
                'nullable' => false,
                    ), 'Title')
            ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
                'nullable' => false,
                    ), 'Content')
            ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'nullable' => false,
                'default' => '1',
                    ), 'Status')
            ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                    ), 'Created At')
            ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                    ), 'Updated At')
            ->setComment('Sitemode Templates Table');
    $installer->getConnection()->createTable($table);
}

/** Create Templates Store Table */
$templateStore = $installer->getTable('sitemode/template_store');

// Check if the table already exist
if ($installer->getConnection()->isTableExists($templateStore) !== true) {
    $table = $installer->getConnection()
            ->newTable($templateStore)
            ->addColumn('template_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'nullable' => false,
                'primary' => true,
                    ), 'Template ID')
            ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                ), 'Store ID')
            ->addIndex($installer->getIdxName('sitemode/template_store', array('store_id')),
                array('store_id'))
            ->addForeignKey($installer->getFkName('sitemode/template_store', 'template_id', 'sitemode/template', 'template_id'),
                'template_id', $installer->getTable('sitemode/template'), 'template_id',
                Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
            ->addForeignKey($installer->getFkName('sitemode/template_store', 'store_id', 'core/store', 'store_id'),
                'store_id', $installer->getTable('core/store'), 'store_id',
                Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
            ->setComment('Sitemode Templates To Store Linkage Table');
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();
