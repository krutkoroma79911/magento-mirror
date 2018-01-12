<?php

class Tsg_Exports_Block_Adminhtml_Exports_Edit_Tab_Filters
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare content for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('tsg_exports')->__('Filters');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('tsg_exports')->__('Filters');
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return false
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Preparing filter tab
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        // Getting attribute values
        $sharesValues = $this->getAttributeOption('catalog_product', 'tsg_shares');
        $markdownValues = $this->getAttributeOption('catalog_product', 'tsg_markdown');
        $providerValues = $this->getAttributeOption('catalog_product', 'tsg_provider');

        $helper = Mage::helper('tsg_exports');
        $model = Mage::registry('tsg_exports');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => $helper->__('Filters'),
        ));
        $fieldset->addField('qty_filter', 'text', array(
            'name' => 'qty_filter',
            'label' => $helper->__('Filter by quantity'),
            'required' => false,
        ));
        $fieldset->addField('shares_filter', 'multiselect', array(
            'name' => 'shares_filter',
            'label' => $helper->__('Filter by shares'),
            'required' => false,
            'values' => array(
                '1' => array(
                    'value' => $sharesValues,
                    'label' => 'Shares',
                ),
            ),
        ));
        $fieldset->addField('markdown_filter', 'multiselect', array(
            'name' => 'markdown_filter',
            'label' => $helper->__('Filter by markdown'),
            'required' => false,
            'values' => array(
                '1' => array(
                    'value' => $markdownValues,
                    'label' => 'Markdown',
                ),
            ),
        ));
        $fieldset->addField('provider_filter', 'multiselect', array(
            'name' => 'provider_filter',
            'label' => $helper->__('Filter by provider'),
            'required' => false,
            'values' => array(
                '1' => array(
                    'value' => $providerValues,
                    'label' => 'Provider',
                ),
            ),
        ));
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Returning array of attribute options
     *
     * @param $entityType
     * @param $attributeCode
     * @return array
     */
    public function getAttributeOption($entityType, $attributeCode)
    {
        /** @var Mage_Eav_Model_Config $attributeModel */
        $attributeModel = Mage::getModel('eav/config');
        $attribute = $attributeModel->getAttribute($entityType, $attributeCode);
        // Getting Options
        $attributeOptions = $attribute->getSource()->getAllOptions(true, true);
        $attributeValues = array();
        foreach ($attributeOptions as $option) {
            $attributeValues[] = ['value' => $option['value'], 'label' => $option['label']];
        }
        return $attributeValues;
    }
}