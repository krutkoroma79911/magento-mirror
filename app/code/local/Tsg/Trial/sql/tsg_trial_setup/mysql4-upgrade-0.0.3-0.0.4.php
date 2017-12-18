<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$attrCode = 'main_news';
$attrGroupName = 'News Group';
$attrLabel = 'Main News';

/** @var Mage_Catalog_Model_Resource_Setup $objCatalogEavSetup */
$objCatalogEavSetup = Mage::getResourceModel('catalog/eav_mysql4_setup', 'core_setup');
$objCatalogEavSetup->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attrCode, array(
    'group' => $attrGroupName,
    'sort_order' => 7,
    'type' => 'int',
    'label' => $attrLabel,
    'input' => 'select',
    'class' => '',
    'source' => 'tsg_trial/news',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => '0',
    'visible_on_front' => true,
    'unique' => false,
    'is_configurable' => false,
    'used_for_promo_rules' => true
));

$installer->endSetup();