<?php

class Tsg_Trial_Block_Adminhtml_Trial_News_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Tsg_Trial_Block_Adminhtml_Trial_News_Edit constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $helper = Mage::helper('tsg_trial');
        $this->_objectId = 'id';
        $this->_blockGroup = "tsg_trial";
        $this->_controller = "adminhtml_trial_news";
        $this->_updateButton('save', 'label', $helper->__('Save'));
        $this->_updateButton('delete', 'label', $helper->__('Delete'));
    }

    /**
     * @return string
     */
    public function getHeaderText()
    {
        $helper = Mage::helper('tsg_trial');
        return $helper->__('News');

    }
}