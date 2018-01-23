<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('tsg_productalert/price'))
    ->addColumn('price_alert_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Price ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => false,
    ), 'Product ID')
    ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => false,
    ), 'Website ID')
    ->addColumn('price', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Product Price')
    ->addColumn('add_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        "default" => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ), 'Add Data')
    ->addColumn('customer_email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'primary' => false,

    ), 'Customer email');
$installer->getConnection()->createTable($table);

// setup stock product alert table
$table = $installer->getConnection()
    ->newTable($installer->getTable('tsg_productalert/stock'))
    ->addColumn('stock_alert_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Price ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => false,
    ), 'Product ID')
    ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => false,
    ), 'Website ID')
    ->addColumn('stock', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Product Stock')
    ->addColumn('add_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        "default" => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ), 'Add Data')
    ->addColumn('customer_email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'primary' => false,

    ), 'Customer email');

$installer->getConnection()->createTable($table);
$installer->endSetup();