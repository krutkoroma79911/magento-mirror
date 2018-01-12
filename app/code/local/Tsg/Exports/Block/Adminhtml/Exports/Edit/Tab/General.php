<?php

class Tsg_Exports_Block_Adminhtml_Exports_Edit_Tab_General
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
        return Mage::helper('tsg_exports')->__('General');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('tsg_exports')->__('General');
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
     * Preparing general tab
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $helper = Mage::helper('tsg_exports');
        $model = Mage::registry('tsg_exports');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => $helper->__('General information'),
        ));
        $fieldset->addField('save_and_continue', 'hidden', array(
            'name' => 'save_and_continue'
        ));

        if ($model->getId()) {
            $fieldset->addField('export_id', 'hidden', array(
                'name' => 'export_id',
            ));
        }

        $fieldset->addField('export_name', 'text', array(
            'name' => 'export_name',
            'label' => $helper->__('Export Name'),
            'required' => true,
        ));
        $fieldset->addField('file_name', 'text', array(
            'name' => 'file_name',
            'label' => $helper->__('File Name'),
            'required' => true,
        ));
        $fieldset->addField('enable', 'select', array(
            'name' => 'enable',
            'values' => array('0' => 'Disable', '1' => 'Enable',),
            'label' => $helper->__('Status'),
            'required' => true,
        ));
        $fieldset->addField('format', 'select', array(
            'name' => 'format',
            'label' => $helper->__('Format'),
            'values' => array('yaml' => 'YAML', 'json' => 'JSON',),
            'title' => $helper->__('Format'),
            'required' => true,
        ));
        $fieldset->addType('exported_file', 'Tsg_Exports_Block_Adminhtml_Exports_Render_ExportedFile');
        $fieldset->addField('next_date', 'exported_file', array(
            'name' => 'generated_file',
            'label' => $helper->__('Generated file'),
            'required' => true,
        ));
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

}