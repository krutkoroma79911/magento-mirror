<?php

/** @var Tsg_Trial_Model_Resource_Setup $installer */
/** @var Tsg_Trial_Model_Resource_Setup $this */

$installer = $this;

$installer->startSetup();

$installer->getConnection()
    ->addColumn($installer->getTable('tsg_trial/news'),
        'created_at',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
            'comment' => 'Created At'
        )
    );
$installer->getConnection()
    ->addColumn($installer->getTable('tsg_trial/news'),
        'priority',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'nullable' => true,
            'default' => null,
            'comment' => 'Priority'
        )
    );

$installer->endSetup();