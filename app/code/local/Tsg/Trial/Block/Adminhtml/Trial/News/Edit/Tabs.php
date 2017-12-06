<?php

class Tsg_Trial_Block_Adminhtml_Trial_News_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        $helper = Mage::helper('tsg_trial');
        parent::__construct();
        $this->setId('trial_tabs');
        $this->setDestElementId('edit_form'); // this should be same as the form id define above
        $this->setTitle($helper->__('News Information'));
    }

    protected function _beforeToHtml()
    {
        $helper = Mage::helper('tsg_trial');
        $this->addTab('trial_section', array(
            'label' => $helper->__('News'),
            'title' => $helper->__('News Information'),
            'content' => $this->getLayout()->createBlock('tsg_trial/adminhtml_trial_news_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}