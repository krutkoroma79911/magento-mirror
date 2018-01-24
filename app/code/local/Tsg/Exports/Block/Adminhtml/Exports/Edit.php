<?php

class Tsg_Exports_Block_Adminhtml_Exports_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'tsg_exports';
        $this->_controller = 'adminhtml_exports';

        parent::__construct();
        $this->_updateButton('save', 'label', $this->__('Save Export'));
        $this->_updateButton('delete', 'label', $this->__('Delete Export'));
        $this->_addButton('generate', array(
            'label'     => Mage::helper('tsg_exports')->__('Generate Export'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/generate/id/'.$this->getRequest()->getParam('id'))}')",
            ));
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('tsg_exports')->__('Save and Continue Edit'),
            'onclick'   => "$('save_and_continue').value = 1; editForm.submit();",
            'class'     => 'save',
        ), -100);
    }

    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        $headerText = 'New Export';
        if (Mage::registry('tsg_exports')->getId()) {
            $headerText = 'Edit Export';
        }
        return $this->__($headerText);

    }
}