<?php

/** @var Tsg_Trial_Model_Resource_Setup $installer */
/** @var Tsg_Trial_Model_Resource_Setup $this */
$installer = $this;
$installer->startSetup();

if (!$installer->tableExists($installer->getTable('tsg_trial/news'))) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('tsg_trial/news'))
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'News Id')
        ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 50, array(
            'nullable' => false
        ), 'News Title')
        ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null)
        ->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 250);
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();
