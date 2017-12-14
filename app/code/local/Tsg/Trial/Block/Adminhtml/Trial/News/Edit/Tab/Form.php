<?php

class Tsg_Trial_Block_Adminhtml_Trial_News_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $helper = Mage::helper('tsg_trial');

        $form = new Varien_Data_Form(array('enctype' => 'multipart/form-data'));
        $newsModel = Mage::registry('current_news') ?: new Varien_Object;
        $this->setForm($form);
        $fieldset = $form->addFieldset('trial_news', array('legend' => $helper->__('News information')));

        $fieldset->addField('title', 'text', array(
            'label' => $helper->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));
        $fieldset->addField('content', 'textarea', array(
            'label' => $helper->__('Content'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'content',
        ));

        $fieldset->addField('image', 'image', array(
            'label' => $helper->__('Image'),
            'required' => false,
            'name' => 'image'
        ));
        $fieldset->addField('priority', 'text', array(
            'label' => $helper->__('Priority'),
            'required' => false,
            'name' => 'priority'
        ));

        $form->setValues($newsModel->getData());

        return parent::_prepareForm();
    }
}