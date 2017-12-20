<?php

/**
 * Installation script for changing theme config
 */

$installer = $this;
$installer->startSetup();


// Update theme package values
$themeConfig = array(
    'theme_package_name' => 'tsg',
    'theme_locale' => 'trial',
    'theme_template' => 'trial',
    'theme_skin' => 'trial',
    'theme_layout' => 'trial',
    'theme_default' => 'default'
);

// Update theme package values
$configUpdate = new Mage_Core_Model_Config();
$configUpdate->saveConfig('design/package/name', $themeConfig['theme_package_name'], 'default', 0);
$configUpdate->saveConfig('design/theme/locale', $themeConfig['theme_locale'], 'default', 0);
$configUpdate->saveConfig('design/theme/template', $themeConfig['theme_template'], 'default', 0);
$configUpdate->saveConfig('design/theme/skin', $themeConfig['theme_skin'], 'default', 0);
$configUpdate->saveConfig('design/theme/layout', $themeConfig['theme_layout'], 'default', 0);
$configUpdate->saveConfig('design/theme/default', $themeConfig['theme_default'], 'default', 0);

$installer->endSetup();