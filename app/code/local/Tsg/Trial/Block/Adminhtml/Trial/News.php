<?php

class Tsg_Trial_Block_Adminhtml_Trial_News
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Tsg_Trial_Block_Adminhtml_Trial_News constructor.
     */
    public function __construct()
    {
        $helper = Mage::helper('tsg_trial');
        $this->_blockGroup = "tsg_trial";
        $this->_controller = "adminhtml_trial_news";
        $this->_headerText = $helper->__('Manage news');
        parent::__construct();
    }

}