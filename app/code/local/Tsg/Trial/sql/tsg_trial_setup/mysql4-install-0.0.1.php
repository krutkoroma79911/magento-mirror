<?php

/** @var Tsg_Trial_Model_Resource_Setup $installer */
/** @var Tsg_Trial_Model_Resource_Setup $this */
$installer = $this;
$installer->startSetup();
if (!$installer->tableExists($installer->getTable('tsg_trial/news'))) {
    $installer->run("
        -- DROP TABLE IF EXISTS {$this->getTable('tsg_trial/news')};
        CREATE TABLE {$this->getTable('tsg_trial/news')}(
        `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `title` varchar(50) NOT NULL,
        `content` mediumtext,
        `image` varchar(250)
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    $installer->endSetup();
}
